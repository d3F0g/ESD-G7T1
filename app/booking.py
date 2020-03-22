from flask import Flask, request, jsonify
from flask_sqlalchemy import SQLAlchemy
from flask_cors import CORS
import json
import pika
app = Flask(__name__)
"""app.config['SQLALCHEMY_DATABASE_URI'] = 'mysql+mysqlconnector://root@localhost:3306/book'
app.config['SQLALCHEMY_TRACK_MODIFICATIONS'] = False
 
db = SQLAlchemy(app)
CORS(app)"""

class Booking:
    def __init__(self, booking_id, user_id, cafe_id, block):
        self.booking_id = booking_id
        self.user_id = user_id
        self.cafe_id = cafe_id
        self.block = block

    def json(self):
        return {"booking_id": self.booking_id, "user_id": self.user_id,
        "cafe_id": self.cafe_id, "block": self.block}

def send_booking(booking):
    hostname = "localhost"
    port = 5672
    connection = pika.BlockingConnection(pika.ConnectionParameters(host=hostname, port=port))
    channel = connection.channel()

    # set up the exchange if the exchange doesn't exist
    exchangename="booking_topic"
    channel.exchange_declare(exchange=exchangename, exchange_type='topic')

    # prepare the message body content
    message = json.dumps(booking.json(), default=str) # convert a JSON object to a string

    # test the sending of messages
    channel.queue_declare(queue='errorhandler', durable=True) # make sure the queue used by the error handler exist and durable
    channel.queue_bind(exchange=exchangename, queue='errorhandler', routing_key='*.error') # make sure the queue is bound to the exchange
    channel.basic_publish(exchange=exchangename, routing_key="booking.error", body=message,
        properties=pika.BasicProperties(delivery_mode = 2) # make message persistent within the matching queues until it is received by some receiver (the matching queues have to exist and be durable and bound to the exchange)
    )
    print("Successful sending of booking to error handler.")
    connection.close()

@app.route("/booking/<int:booking_id>", methods=['POST'])
def create_booking(booking_id):
    data = request.get_json()
    booking = Booking(booking_id, **data)
    try:
        print("Test booking created: " + json.dumps(booking.json(), default=str))
        send_booking(booking)
    except:
        return jsonify({"message": "An error occurred while creating the booking."}), 500
    
    return jsonify(booking.json()), 201

if __name__ == '__main__':
    app.run(port=5000, debug=True)