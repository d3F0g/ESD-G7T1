Steps to follow to setup Cafe Bookie:

1. Make sure your WAMP/MAMP server is running...

2. Copy the ESD-G7T1 folder into your /var/www folder in your WAMP/MAMP directory

3. Follow Lab 7 docker desktop installation guide
https://docs.google.com/document/d/1zi7utU2pwaHcBM8jekr13DAJbeq53UwM_d4O8jyXkxU/edit

4. Follow Kong, Konga installation guide
https://docs.google.com/document/d/1aLlLSIuep2vqtlCaHlMaUWC6Sf5WaebvPZNlY0IZPq0/edit

5. Import esd.sql into phpmyadmin

6. Deploy RabbitMQ on the kong-net network within Docker by entering the following command into CMD/Terminal:
docker run -d --network kong-net --hostname my-rabbit --name some-rabbit rabbitmq

7. For each microservice, run an instance of the microservice's image through docker by entering the following command into CMD/Terminal:
docker run --rm -d --name=_______ --network=kong-net -e dbURL=mysql+mysqlconnector://is213@host.docker.internal:3306/esd terenceyap96/_______:1.0.0

7.1
Booking Mircroservice
Name: booking1
Image: terenceyap96/booking:1.0.0

7.2
Cafe Notification Microservice
Name: cafe_notification
Image: terenceyap96/cafe_notification:1.0.0

7.3
Booking Reply Queue
Name: booking_reply
Image: terenceyap96/booking_reply:1.0.0

7.4
Monitoring Microservice
Name: monitoring
Image: terenceyap96/monitoring:1.0.0

7.5
Error Handler Microservice
Name: errorhandler
Image: terenceyap96/errorhandler:1.0.0

7.6
Reviews Microservice:
Name: reviews1
Image: terenceyap96/reviews:1.0.0

7.7
Cafe Microservice:
Name: cafe1
Image: terenceyap96/cafe:1.0.0

7.8
User Microservice:
Name: user1
Image: terenceyap96/user:1.0.0

After running all the microservices covered above, run the following command to ensure that all microservices and RabbitMQ have been deployed on the kong-net Docker network:
- docker network ls
- docker inspect _____ (network ID of your kong-net network)

The output should return a similar looking output as this:
https://imgur.com/IdHSiet
https://imgur.com/f0iTDIK

8. Configure the Kong API Gateway by accessing Konga GUI at http://localhost:1337

Add the necessary services and routes for all the microservices which are running on flask by following the steps below:

8.1
Service Name: booking
URL: http://booking1:5000/booking

Route Name: Booking_GET
Paths: /api/v1/booking
Methods: GET

Route Name: Booking_POST
Paths: /api/v1/booking
Methods: POST

8.2
Service Name: booking-update
URL: http://booking1:5000/booking/update

Route Name: Booking_UPDATE
Paths: /api/v1/booking/update
Methods: PUT

8.3
Service Name: booking-user
URL: http://booking1:5000/booking/user

Route Name: BookingUser_GET
Paths: /api/v1/booking/user
Methods: GET

8.4
Service Name: booking-cafe
URL: http://booking1:5000/booking/cafe

Route Name: BookingCafe_GET
Paths: /api/v1/booking/cafe
Methods: GET

8.5
Service Name: booking-getID
URL: http://booking1:5000/booking/get_id

Route Name: BookingID_Retrieve
Paths: /api/v1/booking/get_id
Methods: GET

8.6
Service Name: reviews
URL: http://reviews1:5000/reviews

Route Name: Reviews_GET
Paths: /api/v1/reviews
Methods: GET

8.7
Service Name: reviews-cafe
URL: http://reviews1:5000/reviews/cafe

Route Name: ReviewCafe_GET
Paths: /api/v1/reviews/cafe
Methods: GET

8.8
Service Name: reviews-booking
URL: http://reviews1:5000/reviews/booking

Route Name: ReviewsBooking_GET
Paths: /api/v1/reviews/booking
Methods: GET

8.9
Service Name: reviews-getID
URL: http://reviews1:5000/reviews/get_id

Route Name: ReviewID_Retrieve
Paths: /api/v1/reviews/get_id
Methods: GET

8.10
Service Name: reviews-create
URL: http://reviews1:5000/reviews/add

Route Name: Reviews_POST
Paths: /api/v1/reviews/add
Methods: POST

8.11
Service Name: reviews-delete
URL: http://reviews1:5000/reviews/delete

Route Name: Reviews_DELETE
Paths: /api/v1/reviews/delete
Methods: POST

8.12
Service Name: cafes
URL: http://cafe1:5000/cafes

Route Name: Cafes_Search
Paths: /api/v1/cafes
Methods: GET

8.13
Service Name: cafe-retrieve
URL: http://cafe1:5000/cafes/get

Route Name: Cafe_GET
Paths: /api/v1/cafes/get
Methods: GET

8.14
Service Name: user
URL: http://user1:5000/user/get

Route Name: User_GET
Paths: /api/v1/user/get
Methods: GET

8.15
Service Name: user-create
URL: http://user1:5000/user/create

Route Name: User_POST
Paths: /api/v1/user/create
Methods: POST

8.16
Service Name: user-getID
URL: http://user1:5000/user/get_id

Route Name: User_GetID
Paths: /api/v1/user/get_id
Methods: GET

After configurations, the services page in Konga should look like the interface shown here: https://imgur.com/a/3drLw0i

And the routes page in Konga should look like the interface in this image: https://imgur.com/a/WXLeqEp

9. The last step will be to access http://localhost/ESD-G7T1/app/simple_UI.php through your web browser and use our application!