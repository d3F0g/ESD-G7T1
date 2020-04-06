from flask import Flask, request, jsonify
from flask_sqlalchemy import SQLAlchemy
from flask_cors import CORS
from os import environ
from sqlalchemy import desc, update
import json
import pika
import os
app = Flask(__name__)
app.config['SQLALCHEMY_DATABASE_URI'] = environ.get('dbURL')
app.config['SQLALCHEMY_TRACK_MODIFICATIONS'] = False
 
db = SQLAlchemy(app)
CORS(app)

class CorrID(db.Model):
    __tablename__ = 'corrid'

    bookingID = db.Column(db.Integer, primary_key=True)
    corrid = db.Column(db.String(100), nullable=False)
    
    def __init__(self, bookingID, corrid):
        self.corrid = corrid
        self.bookingID = bookingID

    
    def json(self):
        return {"corrid": self.corrid, "bookingID": self.bookingID}

def receiveBooking():
    hostname = "some-rabbit" # default broker hostname. Web management interface default at http://localhost:15672
    port = 5672 # default messaging port.
    # connect to the broker and set up a communication channel in the connection
    connection = pika.BlockingConnection(pika.ConnectionParameters(host=hostname, port=port))
        # Note: various network firewalls, filters, gateways (e.g., SMU VPN on wifi), may hinder the connections;
        # If "pika.exceptions.AMQPConnectionError" happens, may try again after disconnecting the wifi and/or disabling firewalls
    channel = connection.channel()

    # set up the exchange if the exchange doesn't exist
    exchangename="booking_topic"
    channel.exchange_declare(exchange=exchangename, exchange_type='topic')

    replyqueuename="booking.reply"
    channel.queue_declare(queue=replyqueuename, durable=True) # make sure the queue used for "reply_to" is durable for reply messages
    channel.queue_bind(exchange=exchangename, queue=replyqueuename, routing_key=replyqueuename) # make sure the reply_to queue is bound to the exchange
    # set up a consumer and start to wait for coming messages
    channel.basic_qos(prefetch_count=1) # The "Quality of Service" setting makes the broker distribute only one message to a consumer if the consumer is available (i.e., having finished processing and acknowledged all previous messages that it receives)
    channel.basic_consume(queue=replyqueuename,
            on_message_callback=reply_callback, # set up the function called by the broker to process a received message
    ) # prepare the reply_to receiver
    channel.start_consuming()

def reply_callback(channel, method, properties, body):
    retrieved = CorrID.query.order_by(desc(CorrID.corrid)).first()
    if retrieved:
        print("Reply received from Cafe Notification: ", str(body))
        print("Correlation: ", retrieved.corrid)
    
    channel.basic_ack(delivery_tag=method.delivery_tag)
if __name__ == '__main__':
    print("This is " + os.path.basename(__file__) + ": awaiting for response from Cafe Notification...")
    receiveBooking()