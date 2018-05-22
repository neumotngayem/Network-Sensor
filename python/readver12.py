import serial
import pymysql
pymysql.install_as_MySQLdb()
import MySQLdb
import time
import datetime
import re

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
            if "ACK YES" in data:
                if "DEVICE" in data:
                    dvid = data[7:]
                
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
                        sec = data[4:]
                        ts = time.time()
                        st = datetime.datetime.fromtimestamp(ts).strftime('%Y-%m-%d %H:%M:%S')
                                                      
                        if typedv == "DHT11":
                            sql = "INSERT INTO home (device_id, type, temp, humi, sec) VALUES ('%s', '%s', %s, %s, '%s') ON DUPLICATE KEY UPDATE temp = %s, humi = %s, timestamp = '%s'" % (dvid,typedv,temp,humi,sec,temp,humi,str(st))
                        if typedv == "TH50K":
                            sql = "INSERT INTO home (device_id, type, water, sec) VALUES ('%s', '%s', %s, '%s') ON DUPLICATE KEY UPDATE water = %s, timestamp = '%s'" % (dvid,typedv,water,sec,water,str(st))   

                        matchObj = re.match("DV[0-9]+$",dvid,re.I)
                        if(matchObj):
                            cursor.execute(sql)
                            db.commit()
                            
                    except MySQLdb.Error, e:
                        print("Error o day roi")
                    except Exception,e:
                        print(e)             
            else:
                   if "DEVICE" in data:
                       dvid = data[7:]
                   if "TYPE" in data:
                       typedv = data[5:]
                       try:
                            sql = "SELECT sec FROM home where device_id = '%s'" % (dvid)
                            cursor.execute(sql)
                            data = cursor.fetchall()
                            row = data[0]
                            sentstr = dvid+" ACK SEC "+ str(row[0])
                            port.write(str(sentstr))
                            port.flush()
                       except IndexError:
                            matchObj = re.match("DV[0-9]+$",dvid,re.I)
                            if (matchObj and (typedv == "DHT11" or typedv =="TH50K")):
                                sql = "INSERT INTO ack_list (device_id, type) VALUES('%s', '%s') ON DUPLICATE KEY UPDATE device_id = device_id" % (dvid,typedv)
                                try:
                                    cursor.execute(sql)
                                    db.commit()
                                except Exception,e:
                                    print(e)
                       except Exception,e:
                            print(e)              
                           
except KeyboardInterrupt:
        port.close()
        db.close()

