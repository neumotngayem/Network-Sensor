import serial
import pymysql
pymysql.install_as_MySQLdb()
import MySQLdb
import time
import datetime

port = serial.Serial("/dev/ttyAMA0",baudrate=9600,timeout=0.2)
db= MySQLdb.connect("localhost", "root", "admin123", "iot")
cursor= db.cursor()

print("Raspberry's receiving : ")
 
try:
    while True:
        rcv = port.readline()
        data = rcv.rstrip()			# cut "\r\n" at last of string
        if data != "":
            print(data) # print string
            
            if "DEVICE" in data:
                dvid = data[7:]
                sql = "SELECT sec FROM home where device_id = '%s'" % (dvid)
                try:
                    cursor.execute(sql)
                    data = cursor.fetchall()
                    row = data[0]
                    sec = row[0]
                    sentstr = dvid+" SEC "+ str(row[0])
                    port.write(str(sentstr))
                    port.flush()
                except:
                    sec = 30
	    if "TYPE" in data:
		typedv = data[5:]
	
            if "TEMP" in data:
                temp = data[5:]

            if "HUMI" in data:
                humi = data[5:]

            if "WATER" in data:
                water = data[6:]

            if "SEC" in data:
                try:
                    sec1 = data[4:]
                    ts = time.time()
                    st = datetime.datetime.fromtimestamp(ts).strftime('%Y-%m-%d %H:%M:%S')
                    if typedv == "DHT11":
                        sql = "INSERT INTO home (device_id, type, temp, humi, sec) VALUES ('%s', '%s', %s, %s, '%s') ON DUPLICATE KEY UPDATE temp = %s, humi = %s, timestamp = '%s'" % (dvid,typedv,temp,humi,sec,temp,humi,str(st))
                    if typedv == "TH50K":
                        sql = "INSERT INTO home (device_id, type, water, sec) VALUES ('%s', '%s', %s, '%s') ON DUPLICATE KEY UPDATE water = %s, timestamp = '%s'" % (dvid,typedv,water,sec,water,str(st))   
                    if("DV" in dvid):
                        cursor.execute(sql)
                        db.commit()
                except MySQLdb.Error, e:
                    print("Error o day roi")
                except Exception,e:
                    print(e)             
           
               
except KeyboardInterrupt:
        port.close()
        db.close()

