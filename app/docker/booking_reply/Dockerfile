FROM python:3
WORKDIR /usr/src/app
COPY requirements.txt ./
RUN pip install --no-cache-dir -r requirements.txt
COPY ./booking_reply.py .
CMD [ "python", "./booking_reply.py" ]