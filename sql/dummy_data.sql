Insert into users 
(ID, email, password, first_name, last_name, phone, social_media)
values (1, "joqeewee@gmail.com","$2y$10$muXf58lihCL6cmObNmqBH.nr/szrmmrPw3MfQ2dpL/5JZCkM0EGbu", "Josiah", "Wong", "999",NULL),
(2,"lvin_tank_esd@gmail.com", "$2y$10$muXf58lihCL6cmObNmqBH.nr/szrmmrPw3MfQ2dpL/5JZCkM0EGbu", "Lvin", "Shao", "95595559", NULL),
(3,"stay_away_qijin@gmail.com", "$2y$10$muXf58lihCL6cmObNmqBH.nr/szrmmrPw3MfQ2dpL/5JZCkM0EGbu", "Qijon", "Tay", "505", NULL);


Insert into cafes
(ID, name, email, password, phone, poc, avg_review, price, location)
values (1, "Lola","kindadopey@gmail.com", "$2y$10$muXf58lihCL6cmObNmqBH.nr/szrmmrPw3MfQ2dpL/5JZCkM0EGbu","65353535",'Lola', 3, 1, "Bukit Josiah"),
(2, "Kooks","hxchoo@gmail.com","$2y$10$muXf58lihCL6cmObNmqBH.nr/szrmmrPw3MfQ2dpL/5JZCkM0EGbu", "999099",'Kook', 5,5,"Bukit Lvin"),
(3, "Josies","josie@gmail.com", "$2y$10$muXf58lihCL6cmObNmqBH.nr/szrmmrPw3MfQ2dpL/5JZCkM0EGbu","8888",'Josie', 3, 1, "Bukit Josie"),
(4, "Joqeewee","joqeewee@gmail.com", "$2y$10$muXf58lihCL6cmObNmqBH.nr/szrmmrPw3MfQ2dpL/5JZCkM0EGbu","23421331",'Joqeewee', 3, 1, "Bukit Joqeewee");

Insert into booking
(ID, userID, cafeID, seat_no, block,date, status)
values (1,1,1,"1A",6,"2020-04-02","Confirmed"),
(2,3,2,"6A",3,"2020-04-02","Confirmed"),
(3,2,1,"8A",3,"2020-04-02","Confirmed");


Insert into reviews
(ID, userID, cafeID, bookingID, content, stars)
values (1,1,1,1,"The service is excellent. Food was quite good. Ordered the Spinach and Mushroom Quiche and bread was on the crispy side which was delightful. However the serving size for all the dishes we ordered were quite little and I was unfortunately not filled after the meal.",4.25),
(2,3,2,2, "Rude server! He literally was telling me and my friend that he don't want to serve us and was not keen to take our orders. Stay away from this place. Don't spend your money to buy humiliation!", 1.05),
(3,2,1,3, "Such a disappointment. Took them 15 mins to inform that the plain waffles are not available. After we asked for the chocolate waffles, we waited for more than 30 mins before we were informed again that they are unable to produce the waffles. Seriously?? I have been looking at the 3 staff mending at the waffle machine. I am sure something could be done better with their services!", 2.45);

