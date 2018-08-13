import serial
import pymysql
pymysql.install_as_MySQLdb()
import MySQLdb
import time
import sys

port2 = serial.Serial("/dev/ttyAMA0",baudrate=9600,timeout=1)
db= MySQLdb.connect("localhost", "root", "admin123", "iot")
cursor= db.cursor()
sql = "SELECT regisphone FROM account"
cursor.execute(sql)
data = cursor.fetchall()
row = data[0]
phone = row[0]               
while True:
    print("START SMS")
    smsnum = "AT+CMGS=\""+phone+"\""
    mess = sys.argv[1]
    port2.write('AT+CMGF=1'+'\r\n')
    time.sleep(2)
    port2.write(smsnum+'\r\n')
    time.sleep(2)
    port2.write(mess)
    time.sleep(0.5)
    port2.write(chr(26))
    time.sleep(7)
    reply = port2.read(port2.inWaiting())
    print(reply)
    if "+CMGS:" in reply:
        callFlg = False
        print("SMS SUCCESS")
        break
