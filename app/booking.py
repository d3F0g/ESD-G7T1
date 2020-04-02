from flask import Flask, request, jsonify
from flask_sqlalchemy import SQLAlchemy
from flask_cors import CORS
from sqlalchemy import desc, update
import json
import pika
app = Flask(__name__)
app.config['SQLALCHEMY_DATABASE_URI'] = 'mysql+mysqlconnector://root@localhost:3306/esd'
app.config['SQLALCHEMY_TRACK_MODIFICATIONS'] = False
import uuid

db = SQLAlchemy(app)
CORS(app)

class CorrID(db.Model):
    __tablename__ = 'corrid'

    corrid = db.Column(db.String(100), primary_key=True)
    bookingID = db.Column(   db.Integer, nullable=False)
    
    def __init__(self, corrid, bookingID):
        self.corrid = corrid
        self.bookingID = bookingID

    
    def json(self):
        return {"corrid": self.corrid, "bookingID": self.bookingID}

class Booking(db.Model):
    __tablename__ = 'booking'

    ID = db.Column(db.Integer, primary_key=True)
    userID = db.Column(db.Integer, nullable=False)
    cafeID = db.Column(db.Integer, nullable=False)
    seat_no = db.Column(db.VARCHAR(10), nullable=False)
    block = db.Column(db.Integer, nullable=False)
    date = db.Column(db.Date, nullable=False)
    status = db.Column(db.Enum('Confirmed', 'Cancelled'), nullable=False)

    def __init__(self, ID, userID, cafeID, seat_no, block, date, status):
        self.ID = ID
        self.userID = userID
        self.cafeID = cafeID
        self.seat_no = seat_no
        self.block = block
        self.date = date
        self.status = status

    def json(self):
        return {"ID": self.ID, "userID": self.userID, "cafeID": self.cafeID, "seat_no": self.seat_no,
        "block": self.block, "date": self.date, "status": self.status}

# HTTP GET_ALL function to retrieve all bookings
@app.route("/booking")
def get_all():
    return jsonify({"bookings": [booking.json() for booking in Booking.query.all()]})

# HTTP GET function to retrieve a specified booking
@app.route("/booking/<int:booking_id>")
def find_booking(booking_id):
    booking = Booking.query.filter_by(ID=booking_id).first()
    if booking:
        return jsonify(booking.json())

# HTTP PUT function to update a booking when booking is cancelled
@app.route("/booking/update/<int:booking_id>", methods=["PUT"])
def update_booking(booking_id):
    booking = Booking.query.filter_by(ID=booking_id)
    if booking:
        rows_changed = Booking.query.filter_by(ID=booking_id).update(dict(status='Cancelled'))
        db.session.commit()
        return "Success"
    
    return jsonify({"message": "Booking not found."}), 404

# HTTP GET function to retrieve the cafeID from the database
@app.route("/booking/cafe/<int:cafe_id>")
def find_cafeid(cafe_id):
    bookings = Booking.query.filter_by(cafeID=cafe_id)
    if bookings:
        return jsonify({"bookings": [booking.json() for booking in Booking.query.filter_by( cafeID=cafe_id)]})
    return jsonify({"message": "Booking not found."}), 404

# HTTP GET function to retrieve the bookings belonging to a user from the database
@app.route("/booking/user/<int:user_id>")
def find_userid(user_id):
    bookings = Booking.query.filter_by(userID=user_id)
    if bookings:
        return jsonify({"bookings": [booking.json() for booking in Booking.query.filter_by( userID=user_id)]})
    return jsonify({"message": "Booking not found."}), 404

# HTTP GET function to retrieve the latest booking ID from the database
@app.route("/booking/get_id")
def find_latestID():
    booking = Booking.query.order_by(desc(Booking.ID)).first()
    if booking:
        return str(booking.ID + 1)
    else:
        return str(1)

# HTTP POST function that listens for a new booking from Payment
@app.route("/booking/<int:booking_id>", methods=['POST'])
def send_booking(booking_id):
    print()
    print("Booking received from Payment")
    data = request.get_json()
    data["ID"] = booking_id

    hostname = "localhost"
    port = 5672
    connection = pika.BlockingConnection(pika.ConnectionParameters(host=hostname, port=port))
    channel = connection.channel()

    # set up the exchange if the exchange doesn't exist
    exchangename="booking_topic"
    channel.exchange_declare(exchange=exchangename, exchange_type='topic')

    # prepare the message body content
    message = json.dumps(data, default=str) # convert a JSON object to a string

    corrid = str(uuid.uuid4())
    add = CorrID(corrid=corrid, bookingID=booking_id)
    db.session.add(add)
    db.session.commit()

    replyqueuename = "booking.reply"
    channel.queue_declare(queue=replyqueuename, durable=True)
    # prepare the channel and send a message to Cafe Notifcation
    channel.queue_declare(queue='booking', durable=True) # make sure the queue used by Shipping exist and durable
    channel.queue_bind(exchange=exchangename, queue='booking', routing_key='booking.creation') # make sure the queue is bound to the exchange
    channel.basic_publish(exchange=exchangename, routing_key="booking.creation", body=message,
        properties=pika.BasicProperties(delivery_mode = 2, # make message persistent within the matching queues until it is received by some receiver (the matching queues have to exist and be durable and bound to the exchange, which are ensured by the previous two api calls)
            reply_to=replyqueuename, # set the reply queue which will be used as the routing key for reply messages
            correlation_id =corrid # set the correlation id for easier matching of replies
        )
    )
    print("Booking sent to Cafe Notification for booking creation into database")
    connection.close()
    return "Booking creation confirmed"
    
if __name__ == '__main__':
    app.run(port=5000, debug=True)