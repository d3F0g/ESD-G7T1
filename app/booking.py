from flask import Flask, request, jsonify
from flask_sqlalchemy import SQLAlchemy
from flask_cors import CORS
import json
import pika
app = Flask(__name__)
app.config['SQLALCHEMY_DATABASE_URI'] = 'mysql+mysqlconnector://root@localhost:3306/esd'
app.config['SQLALCHEMY_TRACK_MODIFICATIONS'] = False
 
db = SQLAlchemy(app)
CORS(app)

class Booking(db.Model):
    __tablename__ = 'booking'

    ID = db.Column(db.Integer, primary_key=True)
    userID = db.Column(db.Integer, nullable=False)
    cafeID = db.Column(db.Integer, nullable=False)
    seat_no = db.Column(db.Integer, nullable=False)
    block = db.Column(db.Integer, nullable=False)
    status = db.Column(db.Enum('Confirmed', 'Cancelled'), nullable=False)

    def __init__(self, ID, userID, cafeID, seat_no, block, status):
        self.ID = ID
        self.userID = userID
        self.cafeID = cafeID
        self.seat_no = seat_no
        self.block = block
        self.status = status

    def json(self):
        return {"ID": self.ID, "userID": self.userID, "cafeID": self.cafeID, "seat_no": self.seat_no,
        "block": self.block, "status": self.status}

# AMQP messaging function for a successful booking
def send_successful_booking(booking):
    hostname = "localhost"
    port = 5672
    connection = pika.BlockingConnection(pika.ConnectionParameters(host=hostname, port=port))
    channel = connection.channel()

    # set up the exchange if the exchange doesn't exist
    exchangename="booking_topic"
    channel.exchange_declare(exchange=exchangename, exchange_type='topic')

    # prepare the message body content
    message = json.dumps(booking.json(), default=str) # convert a JSON object to a string

    # inform monitoring
    channel.basic_publish(exchange=exchangename, routing_key="booking.info", body=message)

    connection.close()

# AMQP messaging function for a unsuccessful booking
def send_error_booking(booking):
    hostname = "localhost"
    port = 5672
    connection = pika.BlockingConnection(pika.ConnectionParameters(host=hostname, port=port))
    channel = connection.channel()

    # set up the exchange if the exchange doesn't exist
    exchangename="booking_topic"
    channel.exchange_declare(exchange=exchangename, exchange_type='topic')

    # prepare the message body content
    message = json.dumps(booking.json(), default=str) # convert a JSON object to a string

    # inform monitoring
    channel.basic_publish(exchange=exchangename, routing_key="booking.info", body=message)

    # send the error message over to error handler too
    channel.queue_declare(queue='errorhandler', durable=True) # make sure the queue used by the error handler exist and durable
    channel.queue_bind(exchange=exchangename, queue='errorhandler', routing_key='*.error') # make sure the queue is bound to the exchange
    channel.basic_publish(exchange=exchangename, routing_key="booking.error", body=message,
        properties=pika.BasicProperties(delivery_mode = 2) # make message persistent within the matching queues until it is received by some receiver (the matching queues have to exist and be durable and bound to the exchange)
    )
    print("Successful sending of booking to error handler.")
    connection.close()

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
    return jsonify({"message": "Booking not found."}), 404

# HTTP POST function to create a new booking
@app.route("/booking/<int:booking_id>", methods=['POST'])
def create_booking(booking_id):
    data = request.get_json()
    booking = Booking(booking_id, **data)
    try:
        db.session.add(booking)
        db.session.commit()
        print("Test booking created: " + json.dumps(booking.json(), default=str))
        send_successful_booking(booking)
    except:
        print("An error occurred while creating the booking")
        send_error_booking(booking)
    
    return jsonify(booking.json()), 201

if __name__ == '__main__':
    app.run(port=5000, debug=True)