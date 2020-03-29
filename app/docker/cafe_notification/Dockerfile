FROM python:3
WORKDIR /usr/src/app
COPY requirements.txt ./
RUN pip install --no-cache-dir -r requirements.txt
COPY ./cafe_notification.py .
CMD [ "python", "./cafe_notification.py" ]