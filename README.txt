Steps to follow:

1. Make sure your WAMP/MAMP server is running...

2. Follow Lab 7 docker desktop installation guide
https://docs.google.com/document/d/1zi7utU2pwaHcBM8jekr13DAJbeq53UwM_d4O8jyXkxU/edit

3. Follow Kong, Konga installation guide
https://docs.google.com/document/d/1aLlLSIuep2vqtlCaHlMaUWC6Sf5WaebvPZNlY0IZPq0/edit

4. Follow instructions to deploy to Docker Container 
https://docs.google.com/document/d/1SVAKVz6AuCyE610uJfJVJ6DlOY6adp6lXfhVE5We9do/edit

5. Import esd.sql into phpmyadmin

6. For each microservice, run an instance of the microservice's image through docker by entering the following command:
docker run --rm -d --name=_______ --network=kong-net -e dbURL=mysql+mysqlconnector://is213@host.docker.internal:3306/esd terenceyap96/_______:1.0.0

Booking Mircroservice
Name: booking1
Image: terenceyap96/booking:1.0.0

Cafe Notification Microservice
Name: cafe_notification
Image: terenceyap96/cafe_notification:1.0.0

Booking Reply Queue
Name: booking_reply
Image: terenceyap96/booking_reply:1.0.0

Monitoring Microservice
Name: monitoring
Image: terenceyap96/monitoring:1.0.0

Error Handler Microservice
Name: errorhandler
Image: terenceyap96/errorhandler:1.0.0

Reviews Microservice:
Name: reviews1
Image: terenceyap96/reviews:1.0.0

Cafe Microservice:
Name: cafe1
Image: terenceyap96/cafe:1.0.0

User Microservice:
Name: user1
Image: terenceyap96/user:1.0.0

6. Configure Kong API Gateway
After configuring, it should look like this image https://imgur.com/a/WXLeqEp  