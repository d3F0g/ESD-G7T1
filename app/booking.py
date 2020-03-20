from flask import Flask, request, jsonify
import json
import pika

app = Flask(__name__)

class Booking:
    def __init__(self):
        self.booking_id = 0
        self.user = "abc"
        self.user_contact = 0
        self.cafe = "abc"
        self.date = "01-01-2020"
        self.time = "12:00"

    def json(self):
        return {"booking_id": self.booking_id, "user": self.user, "contact": self.user_contact,
        "cafe": self.cafe, "date": self.date, "time": self.time}

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

if __name__ == '__main__':
    print("Creating a test booking: ...")
    booking = Booking()
    booking.booking_id = 1
    booking.user = "Jason"
    booking.user_contact = 123
    booking.cafe = "lola"
    booking.date = "21-03-2020"
    booking.time = "13:00"
    print("Test booking created: " + json.dumps(booking.json(), default=str))
    send_booking(booking)