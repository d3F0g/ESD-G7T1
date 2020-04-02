from flask import Flask, request, jsonify
from flask_sqlalchemy import SQLAlchemy
from flask_cors import CORS
from sqlalchemy import desc
import json
import pika
app = Flask(__name__)
app.config['SQLALCHEMY_DATABASE_URI'] = 'mysql+mysqlconnector://root@localhost:3306/esd'
app.config['SQLALCHEMY_TRACK_MODIFICATIONS'] = False
 
db = SQLAlchemy(app)
CORS(app)

class User(db.Model):
    __tablename__ = 'users'

    ID = db.Column(db.Integer, primary_key=True)
    email = db.Column(db.VARCHAR(255), nullable=False)
    password = db.Column(db.VARCHAR(64), nullable=False)
    first_name = db.Column(db.VARCHAR(100), nullable=False)
    last_name = db.Column(db.VARCHAR(100), nullable=False)
    phone = db.Column(db.VARCHAR(15), nullable=False)
    social_media = db.Column(db.VARCHAR(50), nullable=False)

    def __init__(self, ID, userID, cafeID, seat_no, block, date, status):
        self.ID = ID
        self.email = email
        self.password = password
        self.first_name = first_name
        self.last_name = last_name
        self.phone = phone
        self.social_media = social_media

    def json(self):
        return {"ID": self.ID, "email": self.email, "password": self.password, "first_name": self.first_name,
        "last_name": self.last_name, "phone": self.phone, "social_media": self.social_media}

# HTTP GET function to retrieve the userID from the database
@app.route("/user/<int:user_id>")
def find_userid(user_id):
    users = User.query.filter_by(ID=user_id)
    if users:
        return jsonify({"users": [user.json() for user in User.query.filter_by( ID=user_id)]})
    return jsonify({"message": "User not found."}), 404

# HTTP GET function to retrieve the latest booking ID from the database
@app.route("/user/get_id")
def find_latestID():
    user= User.query.order_by(desc(Booking.ID)).first()
    if user:
        return str(user.ID + 1)
    else:
        return str(1)

# HTTP POST function to create a new user
@app.route("/user/create/<int:user_id>", methods=['POST'])
def create_booking(booking_id):
    data = request.get_json()
    user = User(user_id, **data)
    try:
        db.session.add(user)
        db.session.commit()
        print("Test user created: " + json.dumps(user.json(), default=str))
    except:
        print("An error occurred while creating the user")
    
    return jsonify(user.json()), 201

if __name__ == '__main__':
    app.run(port=5000, debug=True)