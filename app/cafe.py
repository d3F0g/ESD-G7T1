from flask import Flask, request, jsonify
from flask_sqlalchemy import SQLAlchemy

app = Flask(__name__)
app.config['SQLALCHEMY_DATABASE_URI'] = 'mysql+mysqlconnector://root@localhost:3306/esd'
app.config['SQLALCHEMY_TRACK_MODIFICATIONS'] = False

db = SQLAlchemy(app)

class Cafe(db.Model):
    __tablename__ = 'cafe'

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
        self.location = location

    def json(self):
        return {"cafeID": self.id, "name": self.name, "phone": self.phone, "average review": self.avg_review, "price": self.price, "location": self.location}


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
    app.run(port=5000, debug=True)

