from flask import Flask, request, jsonify
from flask_sqlalchemy import SQLAlchemy
from flask_cors import CORS
from sqlalchemy import desc
import json
import sys
import os
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

hostname = "localhost"
port = 5672
# connect to the broker and set up a communication channel in the connection
connection = pika.BlockingConnection(pika.ConnectionParameters(host=hostname, port=port))
channel = connection.channel()

# set up the exchange if the exchange doesn't exist
exchangename="booking_topic"
channel.exchange_declare(exchange=exchangename, exchange_type='topic')

def receiveBooking():
    # prepare a queue for receiving messages
    channelqueue = channel.queue_declare(queue='booking', durable=True)
    queue_name = channelqueue.method.queue
    channel.queue_bind(exchange=exchangename, queue=queue_name, routing_key='booking.creation') # bind the queue to the exchange via the key

    # set up a consumer and start to wait for coming messages
    channel.basic_qos(prefetch_count=1)
    channel.basic_consume(queue=queue_name, on_message_callback=callback)
    channel.start_consuming() # an implicit loop waiting to receive messages; it doesn't exit by default. Use Ctrl+C in the command window to terminate it.

def callback(channel, method, properties, body): # required signature for the callback; no return
    print("Received a booking by " + __file__)
    booking = Booking(**json.loads(body))
    result = processBooking(booking)
    json.dump(result, sys.stdout, default=str)
    print() # print a new line feed to the previous json dump
    print() # print another new line as a separator

    # prepare the reply message and send it out
    replymessage = json.dumps(result, default=str) # convert the JSON object to a string
    replyqueuename="booking.reply"
    # A general note about AMQP queues: If a queue or an exchange doesn't exist before a message is sent,
    # - the broker by default silently drops the message;
    # - So, if really need a 'durable' message that can survive broker restarts, need to
    #  + declare the exchange before sending a message, and
    #  + declare the 'durable' queue and bind it to the exchange before sending a message, and
    #  + send the message with a persistent mode (delivery_mode=2).
    channel.queue_declare(queue=replyqueuename, durable=True) # make sure the queue used for "reply_to" is durable for reply messages
    channel.queue_bind(exchange=exchangename, queue=replyqueuename, routing_key=replyqueuename) # make sure the reply_to queue is bound to the exchange
    channel.basic_publish(exchange=exchangename,
            routing_key=properties.reply_to, # use the reply queue set in the request message as the routing key for reply messages
            body=replymessage, 
            properties=pika.BasicProperties(delivery_mode = 2, # make message persistent (stored to disk, not just memory) within the matching queues; default is 1 (only store in memory)
                #correlation_id = properties.correlation_id, # use the correlation id set in the request message
            )
    )
    channel.basic_ack(delivery_tag=method.delivery_tag) # acknowledge to the broker that the processing of the request message is completed

# AMQP messaging function for an unsuccessful booking
def send_error_booking(booking):
    hostname = "some-rabbit"
    port = 5672
    connection = pika.BlockingConnection(pika.ConnectionParameters(host=hostname, port=port))
    channel = connection.channel()

    # set up the exchange if the exchange doesn't exist
    exchangename="booking_topic"
    channel.exchange_declare(exchange=exchangename, exchange_type='topic')

    # prepare the message body content
    message = json.dumps(booking.json(), default=str) # convert a JSON object to a string

    # send the error message over to error handler too
    channel.queue_declare(queue='errorhandler', durable=True) # make sure the queue used by the error handler exist and durable
    channel.queue_bind(exchange=exchangename, queue='errorhandler', routing_key='*.error') # make sure the queue is bound to the exchange
    channel.basic_publish(exchange=exchangename, routing_key="booking.error", body=message,
        properties=pika.BasicProperties(delivery_mode = 2) # make message persistent within the matching queues until it is received by some receiver (the matching queues have to exist and be durable and bound to the exchange)
    )
    print("Successful sending of booking to error handler.")
    connection.close()

def processBooking(booking):
    print("Recording a Booking:")
    try:
        db.session.add(booking)
        db.session.commit()
        print("Booking successfully added into database")
        return "Success"
    except Exception as e:
        print("Error encountered while creating a booking")
        print(str(e))
        send_error_booking(booking)
    
    return jsonify(booking.json()), 201

if __name__ == "__main__":  # execute this program only if it is run as a script (not by 'import')
    print("This is " + os.path.basename(__file__) + ": Awaiting for bookings...")
    receiveBooking()