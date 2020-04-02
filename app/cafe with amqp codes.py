from flask import Flask, request, jsonify
from flask_sqlalchemy import SQLAlchemy
import json
import pika

app = Flask(__name__)
app.config['SQLALCHEMY_DATABASE_URI'] = 'mysql+mysqlconnector://root@localhost:3306/esd'
app.config['SQLALCHEMY_TRACK_MODIFICATIONS'] = False

db = SQLAlchemy(app)

class Cafe:
    """__tablename__ = 'cafe'

    id = db.Column(db.Integer(), primary_key=True) # CHECK AGAIN SEE IF .INTEGER(10) IS IT NEED PARAMETER
    name = db.Column(db.String(100), nullable=False)
    phone = db.Column(db.String(15), nullable=False)
    avg_review = db.Column(db.Float(precision=3), nullable=False) # CHECK AGAIN
    price = db.Column(db.Float(precision=6), nullable=False) # CHECK AGAIN
    location = db.Column(db.String(50), nullable=False)

    def __init__(self, id, name, phone, avg_review, price, location):
        self.id = id
        self.name = name
        self.phone = phone
        self.avg_review = avg_review
        self.price = price
        self.location = location"""
    
    def __init__(self):
        self.id = 0
        self.name = "abc"
        self.phone = 0
        self.avg_review = 0
        self.price = 0
        self.location = 0

    def json(self):
        return {"cafeID": self.id, "name": self.name, "phone": self.phone, "average review": self.avg_review, "price": self.price, "location": self.location}

# function which executes AMQP message sending
def send_cafe(cafe):
    hostname = "localhost"
    port = 5672
    connection = pika.BlockingConnection(pika.ConnectionParameters(host=hostname, port=port))
    channel = connection.channel()

    # set up the exchange if the exchange doesn't exist
    exchangename="order_topic"
    channel.exchange_declare(exchange=exchangename, exchange_type='topic')

    # prepare the message body content
    message = json.dumps(cafe.json(), default=str) # convert a JSON object to a string

    # test the sending of messages
    channel.queue_declare(queue='errorhandler', durable=True) # make sure the queue used by the error handler exist and durable
    channel.queue_bind(exchange=exchangename, queue='errorhandler', routing_key='*.error') # make sure the queue is bound to the exchange
    channel.basic_publish(exchange=exchangename, routing_key="shipping.error", body=message,
        properties=pika.BasicProperties(delivery_mode = 2) # make message persistent within the matching queues until it is received by some receiver (the matching queues have to exist and be durable and bound to the exchange)
    )
    print("Successful sending of message to error handler.")
    connection.close()


@app.route("/cafe") 
def get_all():
    return jsonify({"cafes": [cafe.json() for cafe in Cafe.query.all()]})


# search by price, location
@app.route("/cafe/<float:price>/<string:location>")
def find_by_price_location(price, location):
    cafe = Cafe.query.filter_by( price=price, location=location).first()
    if cafe:
        return jsonify(cafe.json())
    return jsonify({"message": "No results."}), 404

# search by cafe name
@app.route("/cafe/<string:name>")
def find_by_cafe_name(name):
    cafe = Cafe.query.filter_by(name).first()
    if cafe:
        return jsonify(cafe.json())
    return jsonify({"message": "No results."}), 404



if __name__ == '__main__':
    cafe = Cafe()
    cafe.id = 1
    cafe.name = "lola"
    cafe.phone = 123
    cafe.avg_review = 5
    cafe.price = 15
    cafe.location = "kovan"
    send_cafe(cafe)
    app.run(port=5000, debug=True)