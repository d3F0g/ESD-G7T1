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

@bot.message_handler(commands=['follow_us'])
def send_welcome(msg):
    bot.reply_to(msg, 'https://instagram.com/teeteeyup')



def at_answer(msg):
    email = msg.text
    sql = "SELECT (SELECT ID from users where email=)"
    bot.reply_to(msg,)




bot.polling()



