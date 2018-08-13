import serial
import pymysql
pymysql.install_as_MySQLdb()
import MySQLdb
import time

port2 = serial.Serial("/dev/ttyAMA0",baudrate=9600,timeout=1)
db= MySQLdb.connect("localhost", "root", "admin123", "iot")
cursor= db.cursor()
sql = "SELECT regisphone FROM account"
cursor.execute(sql)
data = cursor.fetchall()
row = data[0]
phone = row[0]               
while True:
    print("START CALL")
    port2.write('AT'+'\r\n')
    time.sleep(1)
    port2.write("ATD"+phone+'\r\n')
    time.sleep(5)
    reply = port2.read(port2.inWaiting())
    print(reply)
    if "+CIEV:" in reply:
        callFlg = False
        print("CALL SUCCESS")
        break
