from flask import Flask, request, jsonify
from flask_sqlalchemy import SQLAlchemy
from flask_cors import CORS


app = Flask(__name__)
app.config['SQLALCHEMY_DATABASE_URI'] = 'mysql+mysqlconnector://root@localhost:3306/esd'
app.config['SQLALCHEMY_TRACK_MODIFICATIONS'] = False

db = SQLAlchemy(app)
CORS(app)

class Cafe(db.Model):
    __tablename__ = 'cafes'

    ID = db.Column(db.Integer(), primary_key=True) 
    name = db.Column(db.String(100), nullable=False)
    phone = db.Column(db.String(15), nullable=False)
    avg_review = db.Column(db.Float(precision=2), nullable=False) 
    price = db.Column(db.Float(precision=2), nullable=False) 
    location = db.Column(db.String(50), nullable=False)

    def __init__(self, ID, name, phone, avg_review, price, location):
        self.ID = ID
        self.name = name
        self.phone = phone
        self.avg_review = avg_review
        self.price = price
        self.location = location

    def json(self):
        return {"cafeID": self.ID, "name": self.name, "phone": self.phone, "average review": self.avg_review, "price": self.price, "location": self.location}


@app.route("/cafes") 
def get_all():
    return jsonify({"cafes": [cafe.json() for cafe in Cafe.query.all()]})


# search by price, location
@app.route("/cafes/<float:price>/<string:location>")
def find_by_price_location(price, location):
    cafe = Cafe.query.filter_by( price=price, location=location).first()
    if cafe:
        return jsonify(cafe.json())
    return jsonify({"message": "No results."}), 404

# search by location
@app.route("/cafes/<string:location>")
def find_by_location(location):
    cafe = Cafe.query.filter_by( location=location).first()
    if cafe:
        return jsonify(cafe.json())
    return jsonify({"message": "No results."}), 404

# search by cafe name
@app.route("/cafes/<string:name>")
def find_by_cafe_name(name):
    cafe = Cafe.query.filter_by(name).first()
    if cafe:
        return jsonify(cafe.json())
    return jsonify({"message": "No results."}), 404



if __name__ == '__main__':
    app.run(port=5000, debug=True)

