Steps to follow:

1. Make sure your WAMP/MAMP server is running...

2. Ensure that you have the following modules installed to prevent any 'ModuleNotFound' errors
pip install requests
pip install Flask
pip install Flask-SQLAlchemy
pip install flask_cors
pip install mysql-connector-python
pip install pika
pip install simplejson


3. Follow Lab 7 docker desktop installation guide
https://docs.google.com/document/d/1zi7utU2pwaHcBM8jekr13DAJbeq53UwM_d4O8jyXkxU/edit

4. Follow Kong, Konga installation guide
https://docs.google.com/document/d/1aLlLSIuep2vqtlCaHlMaUWC6Sf5WaebvPZNlY0IZPq0/edit

5. Follow instructions to deploy to Docker Container 
https://docs.google.com/document/d/1SVAKVz6AuCyE610uJfJVJ6DlOY6adp6lXfhVE5We9do/edit

6. Import esd.sql into phpmyadmin

7. Configure Kong Gateway
After configuring, it should look like this image <insert url> 

8. Run an instance of the image 
docker run --rm -d --name=_______ --network=kong-net -e dbURL=mysql+mysqlconnector://is213@host.docker.internal:3306/esd terenceyap96/booking:1.0.0

