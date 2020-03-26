Insert into users 
(ID, email, password, first_name, last_name, phone, social_media)
values (1, "joqeewee@gmail.com","$2y$10$muXf58lihCL6cmObNmqBH.nr/szrmmrPw3MfQ2dpL/5JZCkM0EGbu", "Josiah", "Wong", "999",NULL),
(2,"lvin_tank_esd@gmail.com", "$2y$10$muXf58lihCL6cmObNmqBH.nr/szrmmrPw3MfQ2dpL/5JZCkM0EGbu", "Lvin", "Shao", "95595559", NULL),
(3,"stay_away_qijin@gmail.com", "$2y$10$muXf58lihCL6cmObNmqBH.nr/szrmmrPw3MfQ2dpL/5JZCkM0EGbu", "Qijon", "Tay", "505", NULL);


Insert into cafes
(ID, name, phone, avg_review, price, location)
values (1, "Lola's Cafe", "65353535", 3, 1, "Bukit Josiah"),
(2, "Kookie", "999099", 5,5,"Bukit Lvin");

Insert into booking
(ID, userID, cafeID, seat_no, block,date, status)
values (1,1,1,1,6,"2020-03-30","Confirmed"),
(2,3,2,6,3,"2020-03-30","Confirmed");
