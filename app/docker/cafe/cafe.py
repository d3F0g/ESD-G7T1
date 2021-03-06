from flask import Flask, request, jsonify
from flask_sqlalchemy import SQLAlchemy
from flask_cors import CORS
from os import environ
import simplejson as json

app = Flask(__name__)
app.config['SQLALCHEMY_DATABASE_URI'] = environ.get('dbURL')
app.config['SQLALCHEMY_TRACK_MODIFICATIONS'] = False

db = SQLAlchemy(app)
CORS(app)

class Cafe(db.Model):
    __tablename__ = 'cafes'

    ID = db.Column(db.Integer(), primary_key=True) 
    name = db.Column(db.String(100), nullable=False)
    email = db.Column(db.String(255), nullable=False)
    password = db.Column(db.String(64), nullable=False)
    phone = db.Column(db.String(15), nullable=False)
    poc = db.Column(db.String(100), nullable=False)
    avg_review = db.Column(db.Float(precision=2), nullable=False) 
    price = db.Column(db.Integer(), nullable=False) 
    location = db.Column(db.String(50), nullable=False)

    def __init__(self, ID, name, email, password, phone,poc, avg_review, price, location):
        self.ID = ID
        self.name = name
        self.email = email
        self.password = password
        self.phone = phone
        self.poc = poc
        self.avg_review = avg_review
        self.price = price
        self.location = location

    def json(self):
        return {"cafeID": self.ID, "name": self.name, "email": self.email,"password": self.password, "phone": self.phone,"poc": self.poc, "avg_review": self.avg_review, "price": self.price, "location": self.location}


@app.route("/cafes") 
def get_all():
    return jsonify({"cafes": [cafe.json() for cafe in Cafe.query.all()]})

# search by cafeID
@app.route("/cafes/get/<int:ID>")
def find_by_ID(ID):
    cafe = Cafe.query.filter_by( ID=ID).first()
    if cafe:
        return jsonify(cafe.json())

# search by price, location
@app.route("/cafes/<int:price>/<string:location>")
def find_by_price_location(price, location):
    cafes = Cafe.query.filter_by( price=price, location=location)
    if cafes:
        return jsonify({"cafes": [cafe.json() for cafe in Cafe.query.filter_by( price=price, location=location)]})
    return jsonify({"message": "No results."}), 404

# search by price
@app.route("/cafes/<int:price>")
def find_by_price(price):
    cafes = Cafe.query.filter_by( price=price)
    if cafes:
        return jsonify({"cafes": [cafe.json() for cafe in Cafe.query.filter_by( price=price)]})
    return jsonify({"message": "No results."}), 404

if __name__ == '__main__':
    app.run(host='0.0.0.0', port=5000, debug=True)

