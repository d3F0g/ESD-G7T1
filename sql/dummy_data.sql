Insert into users 
(ID, email, password, first_name, last_name, phone, social_media)
values (1, "joqeewee@gmail.com","$2a$10$4FA.lSOnYmkyg8OAULokTeLAf923xXI8XGYUNQdtDLwNqD.mnJCFq", "Josiah", "Wong", "999",NULL),
(2,"lvin_tank_esd@gmail.com", "lSOnYmkyg8OAULokTeLAf923xXI8XGYUNQdtDLwNqD", "Lvin", "Shao", "95595559", NULL),
(3,"stay_away_qijin@gmail.com", "2a$10$4FA.lSOnYmkyg", "Qijon", "Tay", "505", NULL);


Insert into cafes
(ID, name, phone, avg_review, price, location)
values (1, "Lola's Cafe", "65353535", 3, 5.99, "Bukit Josiah"),
(2, "Kookie", "999099", 5,9.99,"Bukit Lvin");

Insert into booking
(ID, userID, cafeID, seat_no, block, status)
values (1,1,1,1,6,"Confirmed"),
(2,3,2,6,3,"Confirmed");
