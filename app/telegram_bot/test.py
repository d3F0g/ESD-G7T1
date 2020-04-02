import telebot
import time 





bot_token = "922902239:AAEv-N_nhUdz8J7RLsw7cCJiDHfg_jglEsk"
chat = "-407238405"

bot = telebot.TeleBot(token=bot_token)

@bot.message_handler(commands=['start'])
def send_welcome(msg):
    bot.reply_to(msg, 'Welcome to your new experience with CafeBookie! :)')

@bot.message_handler(commands=['help'])
def send_welcome(msg):
    bot.reply_to(msg, 'To start using this bot enter the same email you used for CafeBookie!')

@bot.message_handler(func=lambda msg: msg.text is not None and '@' in msg.text)
def at_answer(msg):

    email = msg.text
    from sqlalchemy import create_engine
    engine = create_engine('mysql+mysqlconnector://root:root@localhost:3306/esd') 
    connection = engine.connect() 
    i_d = "SELECT ID from users where `email`='{}'".format(email)
    result_proxy = connection.execute(i_d)
    id_confirm = result_proxy.fetchall()
    final_string = ""
    if id_confirm != []:
        stmt = "SELECT * FROM booking where userID="+str(id_confirm[0][0])
        r_proxy = connection.execute(stmt)
        results = r_proxy.fetchall()
        
        time = str(results[0][4]-1+8)
        end_time = str(results[0][4]+8)
        cafe_id = results[0][2]
        stmt = "SELECT name FROM cafes where ID="+str(results[0][2])
        r_proxy = connection.execute(stmt)
        results = r_proxy.fetchall()
        cafe = results[0][0]
        final_string = "You have booked for "+time+"00 to "+end_time+"00 at "+str(cafe)
    bot.reply_to(msg, final_string)


@bot.message_handler(commands=['follow_us'])
def send_welcome(msg):
    bot.reply_to(msg, 'https://www.instagram.com/cafebookie/')







bot.polling()



