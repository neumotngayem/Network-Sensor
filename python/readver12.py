import serial
import pymysql
pymysql.install_as_MySQLdb()
import MySQLdb
import time
import datetime
import re
import os

port = serial.Serial("/dev/ttyUSB0",baudrate=9600,timeout=0.2)
db= MySQLdb.connect("localhost", "root", "admin123", "iot")
cursor= db.cursor()
hostnm = 'RS1'
print("Raspberry's receiving : ")
 
try:
    while True:
        rcv = port.readline()
        data = rcv.rstrip()			# cut "\r\n" at last of string
        if data != "":
            print(data) # print string
            if "ACK YES" in data:
                ts = time.time()
                st = datetime.datetime.fromtimestamp(ts).strftime('%Y-%m-%d %H:%M:%S')
                hostrcv = data[(data.find("HOST")+5):(data.find("DEVICE")-1)]
                dvid = data[(data.find("DEVICE")+7):(data.find("TYPE")-1)]

                if hostrcv == hostnm:
                    if "DHT11" in data:
                        typedv = "DHT11"
                        temp = data[(data.find("TEMP")+5):(data.find("HUMI")-1)]
                        humi = data[(data.find("HUMI")+5):(data.find("SEC")-1)]
                        sec = data[(data.find("SEC")+4):]
                        sql = "INSERT INTO home (device_id, type, temp, humi, sec) VALUES ('%s', '%s', %s, %s, '%s') ON DUPLICATE KEY UPDATE temp = %s, humi = %s, timestamp = '%s'" % (dvid,typedv,temp,humi,sec,temp,humi,str(st))
                    elif "TH50K" in data:
                        typedv = "TH50K"
                        water = data[(data.find("WATER")+6):(data.find("SEC")-1)]
                        sec = data[(data.find("SEC")+4):]
                        sql = "INSERT INTO home (device_id, type, water, sec) VALUES ('%s', '%s', %s, '%s') ON DUPLICATE KEY UPDATE water = %s, timestamp = '%s'" % (dvid,typedv,water,sec,water,str(st))

                    matchObj = re.match("DV[0-9]+$",dvid,re.I)
                    if(matchObj):
                        try:
                            cursor.execute(sql)
                            db.commit()
                            upstr = "UPDATED ON %s" % (str(st))
                            print upstr
                        except MySQLdb.Error, e:
                            print("Error with MySQL")
                        except Exception,e:
                            print(e)             
            else:
                dvid = data[(data.find("DEVICE")+7):(data.find("TYPE")-1)]
                typedv = data[(data.find("TYPE")+5):]                                                                                                                                                 
                try:
                    sql = "SELECT sec FROM home where device_id = '%s'" % (dvid)
                    cursor.execute(sql)
                    data = cursor.fetchall()
                    row = data[0]
                    sentstr = dvid+" ACK SEC "+ str(row[0])+" HOST "+hostnm
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

