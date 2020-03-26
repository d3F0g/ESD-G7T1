from flask import Flask, request, jsonify
from flask_sqlalchemy import SQLAlchemy
from flask_cors import CORS
import simplejson as json # remember to include simplejson as part of requirements.txt
app = Flask(__name__)
app.config['SQLALCHEMY_DATABASE_URI'] = 'mysql+mysqlconnector://root@localhost:3306/esd'
app.config['SQLALCHEMY_TRACK_MODIFICATIONS'] = False
 
db = SQLAlchemy(app)
CORS(app)

class Review(db.Model):
    __tablename__ = 'reviews'

    ID = db.Column(db.Integer, primary_key=True)
    userID = db.Column(db.Integer, nullable=False)
    cafeID = db.Column(db.Integer, nullable=False)
    bookingID = db.Column(db.Integer, nullable=False)
    content = db.Column(db.Text, nullable=False)
    stars = db.Column(db.Float(3,2), nullable=False)

    def __init__(self, ID, userID, cafeID, bookingID, content, stars):
        self.ID = ID
        self.userID = userID
        self.cafeID = cafeID
        self.bookingID = bookingID
        self.content = content
        self.stars = stars

    def json(self):
        return {"ID": self.ID, "userID": self.userID, "cafeID": self.cafeID, "bookingID": self.bookingID,
        "content": self.content, "stars": self.stars}

@app.route("/reviews")
def get_all():
    return jsonify({"reviews": [review.json() for review in Review.query.all()]})

# retrieve all the reviews belonging to a user
@app.route("/reviews/<int:userID>")
def get_reviews(userID):
    return jsonify({"reviews": [review.json() for review in Review.query.filter_by(userID=userID)]}
    )

@app.route("/reviews/<int:reviewID>", methods=['POST'])
def create_review(reviewID):
    data = request.get_json()
    review = Review(reviewID, **data)
    try:
        db.session.add(review)
        db.session.commit()
        print("Test review created: " + json.dumps(review.json(), default=str))
    except:
        return jsonify({"message": "An error occurred while creating the review."}), 500
    
    return jsonify(review.json()), 201

if __name__ == '__main__':
    app.run(port=5001, debug=True)