from flask import Flask, request, jsonify
from flask_sqlalchemy import SQLAlchemy
from flask_cors import CORS
from os import environ
from sqlalchemy import desc
import os
import json
import pika
app = Flask(__name__)
app.config['SQLALCHEMY_DATABASE_URI'] = environ.get('dbURL')
app.config['SQLALCHEMY_TRACK_MODIFICATIONS'] = False
 
db = SQLAlchemy(app)
CORS(app)

class ErrorHandler(db.Model):
    __tablename__ = 'error_handling'

    ID = db.Column(db.Integer, primary_key=True)
    body = db.Column(db.Text, nullable=False)

    def __init__(self, ID, body):
        self.ID = ID
        self.body = body

    def json(self):
        return {"ID": self.ID, "body": self.body}

def receiveBookingError():
    hostname = "some-rabbit" # default broker hostname
    port = 5672 # default port
    # connect to the broker and set up a communication channel in the connection
    connection = pika.BlockingConnection(pika.ConnectionParameters(host=hostname, port=port))
    channel = connection.channel()

    # set up the exchange if the exchange doesn't exist
    exchangename="booking_topic"
    channel.exchange_declare(exchange=exchangename, exchange_type='topic')

    # prepare a queue for receiving messages
    channelqueue = channel.queue_declare(queue="errorhandler", durable=True) # 'durable' makes the queue survive broker restarts
    queue_name = channelqueue.method.queue
    channel.queue_bind(exchange=exchangename, queue=queue_name, routing_key='booking.error') # bind the queue to the exchange via the key

    # set up a consumer and start to wait for coming messages
    channel.basic_consume(queue=queue_name, on_message_callback=callback, auto_ack=True)
    channel.start_consuming() # an implicit loop waiting to receive messages; it doesn't exit by default. Use Ctrl+C in the command window to terminate it.

def callback(channel, method, properties, body): # required signature for the callback; no return
    print("Received an error by " + __file__)
    processError(json.loads(body))
    print() # print a new line feed

def processError(error):
    print("Recording an error log:")
    retrieved = ErrorHandler.query.order_by(desc(ErrorHandler.ID)).first()
    if retrieved:
        retrieved_id = retrieved.ID + 1
    else:
        retrieved_id = 1

    error = ErrorHandler(retrieved_id, str(error))

    db.session.add(error)
    db.session.commit()

    print("Error log successfully added into database")
    return "Success"

if __name__ == "__main__":  # execute this program only if it is run as a script (not by 'import')
    print("This is " + os.path.basename(__file__) + ": awaiting for error...")
    receiveBookingError()
