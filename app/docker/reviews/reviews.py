from flask import Flask, request, jsonify
from flask_sqlalchemy import SQLAlchemy
from flask_cors import CORS
from os import environ
from sqlalchemy import desc
import simplejson as json # remember to include simplejson as part of requirements.txt
import pika
app = Flask(__name__)
app.config['SQLALCHEMY_DATABASE_URI'] = environ.get('dbURL')
app.config['SQLALCHEMY_TRACK_MODIFICATIONS'] = False
 
db = SQLAlchemy(app)
CORS(app)

class Review(db.Model):
    __tablename__ = 'reviews'

    ID = db.Column(db.Integer, primary_key=True)
    userID = db.Column(db.Integer, nullable=False)
    cafeID = db.Column(db.Integer, nullable=False)
    bookingID = db.Column(db.Integer, nullable=False)
    content = db.Column(db.Text, nullable=False)
    stars = db.Column(db.Float(3,2), nullable=False)

    def __init__(self, ID, userID, cafeID, bookingID, content, stars):
        self.ID = ID
        self.userID = userID
        self.cafeID = cafeID
        self.bookingID = bookingID
        self.content = content
        self.stars = stars

    def json(self):
        return {"ID": self.ID, "userID": self.userID, "cafeID": self.cafeID, "bookingID": self.bookingID,
        "content": self.content, "stars": self.stars}


# AMQP messaging function for a successful review
def send_successful_review(review):
    hostname = "some-rabbit"
    port = 5672
    connection = pika.BlockingConnection(pika.ConnectionParameters(host=hostname, port=port))
    channel = connection.channel()

    # set up the exchange if the exchange doesn't exist
    exchangename="booking_topic"
    channel.exchange_declare(exchange=exchangename, exchange_type='topic')

    # prepare the message body content
    message = json.dumps(review.json(), default=str) # convert a JSON object to a string

    # inform monitoring
    channel.basic_publish(exchange=exchangename, routing_key="review.info", body=message)

    connection.close()

# AMQP messaging function for an unsuccessful review
def send_error_review(review):
    hostname = "some-rabbit"
    port = 5672
    connection = pika.BlockingConnection(pika.ConnectionParameters(host=hostname, port=port))
    channel = connection.channel()

    # set up the exchange if the exchange doesn't exist
    exchangename="booking_topic"
    channel.exchange_declare(exchange=exchangename, exchange_type='topic')

    # prepare the message body content
    message = json.dumps(review.json(), default=str) # convert a JSON object to a string

    # inform monitoring
    channel.basic_publish(exchange=exchangename, routing_key="review.info", body=message)

    # send the error message over to error handler too
    channel.queue_declare(queue='errorhandler', durable=True) # make sure the queue used by the error handler exist and durable
    channel.queue_bind(exchange=exchangename, queue='errorhandler', routing_key='*.error') # make sure the queue is bound to the exchange
    channel.basic_publish(exchange=exchangename, routing_key="review.error", body=message,
        properties=pika.BasicProperties(delivery_mode = 2) # make message persistent within the matching queues until it is received by some receiver (the matching queues have to exist and be durable and bound to the exchange)
    )
    print("Successful sending of notification to error handler.")
    connection.close()

@app.route("/reviews")
def get_all():
    return jsonify({"reviews": [review.json() for review in Review.query.all()]})

# retrieve all the reviews belonging to a specific cafe
@app.route("/reviews/cafe/<int:cafeID>")
def get_cafe_reviews(cafeID):
    return jsonify({"reviews": [review.json() for review in Review.query.filter_by(cafeID=cafeID)]}
    )

# retrieve all the reviews belonging to a user
@app.route("/reviews/<int:userID>")
def get_reviews(userID):
    return jsonify({"reviews": [review.json() for review in Review.query.filter_by(userID=userID)]}
    )

# HTTP GET function to retrieve the latest review ID from the database
@app.route("/reviews/get_id")
def find_latestID():
    review = Review.query.order_by(desc(Review.ID)).first()
    if review:
        return str(review.ID + 1)
    else:
        return str(1)
    
@app.route("/reviews/add/<int:ID>", methods=['POST'])
def create_review(ID):
    data = request.get_json()
    review = Review(ID, **data)
    try:
        db.session.add(review)
        db.session.commit()
        print("Test review created: " + json.dumps(review.json(), default=str))
        send_successful_review(review)
    except:
        print("An error occurred while creating a review")
        send_error_review(review)
    
    return jsonify(review.json()), 201

if __name__ == '__main__':
    app.run(host='0.0.0.0', port=5000, debug=True)