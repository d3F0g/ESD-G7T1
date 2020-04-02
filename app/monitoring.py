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

class Monitor(db.Model):
    __tablename__ = 'monitoring'

    ID = db.Column(db.Integer, primary_key=True)
    body = db.Column(db.Text, nullable=False)

    def __init__(self, ID, body):
        self.ID = ID
        self.body = body

    def json(self):
        return {"ID": self.ID, "body": self.body}

def receiveBookingLog():
    hostname = "localhost" # default host
    port = 5672 # default port
    # connect to the broker and set up a communication channel in the connection
    connection = pika.BlockingConnection(pika.ConnectionParameters(host=hostname, port=port))
    channel = connection.channel()

    # set up the exchange if the exchange doesn't exist
    exchangename="booking_topic"
    channel.exchange_declare(exchange=exchangename, exchange_type='topic')

    # prepare a queue for receiving messages
    channelqueue = channel.queue_declare(queue='', exclusive=True) # '' indicates a random unique queue name; 'exclusive' indicates the queue is used only by this receiver and will be deleted if the receiver disconnects.
        # If no need durability of the messages, no need durable queues, and can use such temp random queues.
    queue_name = channelqueue.method.queue
    channel.queue_bind(exchange=exchangename, queue=queue_name, routing_key='#') # bind the queue to the exchange via the key
        # Can bind the same queue to the same exchange via different keys

    # set up a consumer and start to wait for coming messages
    channel.basic_consume(queue=queue_name, on_message_callback=callback, auto_ack=True)
    channel.start_consuming() # an implicit loop waiting to receive messages; it doesn't exit by default. Use Ctrl+C in the command window to terminate it.

def callback(channel, method, properties, body): # required signature for the callback; no return
    print("Received a monitoring log by " + __file__)
    processLog(json.loads(body))
    print() # print a new line feed

def processLog(log):
    print("Recording a monitoring log:")
    retrieved = Monitor.query.order_by(desc(Monitor.ID)).first()
    if retrieved:
        retrieved_id = retrieved.ID + 1
    else:
        retrieved_id = 1

    monitor = Monitor(retrieved_id, str(log))

    db.session.add(monitor)
    db.session.commit()

    print("Monitoring log successfully added into database")
    return "Success"

if __name__ == "__main__":  # execute this program only if it is run as a script (not by 'import')
    print("This is " + os.path.basename(__file__) + ": monitoring for events...")
    receiveBookingLog()