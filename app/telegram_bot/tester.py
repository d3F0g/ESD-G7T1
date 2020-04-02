from sqlalchemy import create_engine
engine = create_engine('mysql+mysqlconnector://root:root@localhost:3306/esd') 
connection = engine.connect() 
email = "joqeewee@gmail.com"
i_d = "SELECT ID from users where `email`='{}'".format(email)
result_proxy = connection.execute(i_d)
id_confirm = result_proxy.fetchall()

stmt = "SELECT * FROM booking where userID="+str(id_confirm[0][0])
r_proxy = connection.execute(stmt)
results = r_proxy.fetchall()

stmt = "SELECT name FROM cafes where ID="+str(results[0][2])
r_proxy = connection.execute(stmt)
results = r_proxy.fetchall()
print(results)