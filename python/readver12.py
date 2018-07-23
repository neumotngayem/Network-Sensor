import serial
import pymysql
pymysql.install_as_MySQLdb()
import MySQLdb
import time
import datetime
import re
import os
import logging

port = serial.Serial("/dev/ttyUSB0",baudrate=9600,timeout=0.2)
db= MySQLdb.connect("localhost", "root", "admin123", "iot")
cursor= db.cursor()
hostnm = 'RS1'
print("Raspberry's receiving : ")
 
try:
    while True:
        logging.basicConfig(filename='start.log', filemode='w', level=logging.DEBUG)
        logging.info('Starting')
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
                        sql2 = "INSERT INTO dht11 (device_id, temp, humi) VALUES ('%s', '%s', %s)" % (dvid,temp,humi)
                    elif "MC52" in data:
                        typedv = "MC52"
                        dopen = data[(data.find("OPEN")+5):]
                        sql = "INSERT INTO home (device_id, type, open, sec) VALUES ('%s', '%s', %s, %s) ON DUPLICATE KEY UPDATE open = %s, timestamp = '%s'" % (dvid,typedv,dopen,30,dopen,str(st))
                    elif "MQ135" in data:
                        typedv = "MQ135"
                        co2 = data[(data.find("CO2")+4):(data.find("CO0")-1)]
                        co = data[(data.find("CO0")+4):(data.find("ETHANOL")-1)]
                        ethanol = data[(data.find("ETHANOL")+8):(data.find("TOLUENE")-1)]
                        toluene = data[(data.find("TOLUENE")+8):(data.find("ACETONE")-1)]
                        acetone = data[(data.find("ACETONE")+8):(data.find("ANALOG")-1)]
                        analog = data[(data.find("ANALOG")+7):(data.find("SEC")-1)]
                        print analog+"\n";
                        sec = data[(data.find("SEC")+4):]
                        sql = "INSERT INTO home (device_id, type, co2, co, ethanol, toluene, acetone, analog, sec) VALUES ('%s', '%s', %s, %s, %s, %s, %s, %s, %s) ON DUPLICATE KEY UPDATE co2 = %s, co = %s, ethanol = %s, toluene = %s, acetone = %s, analog = %s, timestamp = '%s'" % (dvid,typedv,co2,co,ethanol,toluene,acetone,analog,sec,co2,co,ethanol,toluene,acetone,analog,str(st))         
                        sql2 = "INSERT INTO mq135 (device_id, co2, co, ethanol, toluene, acetone) VALUES ('%s', %s, %s, %s, %s, %s)" % (dvid,co2,co,ethanol,toluene,acetone)
        
                    matchObj = re.match("DV[0-9]+$",dvid,re.I)
                    if(matchObj):
                        try:
                            cursor.execute(sql)
                            if('DHT11' in typedv or 'MQ135' in typedv):
                                cursor.execute(sql2)
                            db.commit()
                            upstr = "UPDATED ON %s" % (str(st))
                            print upstr
                        except MySQLdb.Error, e:
                            print sql+"\n";
                            print sql2+"\n";
                            print("Error with MySQL")
                        except Exception,e:
                            print sql;
                            print(e)             
            else:
                dvid = data[(data.find("DEVICE")+7):(data.find("TYPE")-1)]
                typedv = data[(data.find("TYPE")+5):]                                                                                                                                                 
                try:
                    sql = "SELECT sec FROM home where device_id = '%s'" % (dvid)
                    cursor.execute(sql)
                    data = cursor.fetchall()
                    row = data[0]
                    sentstr = dvid+" ACKYES SEC "+ str(row[0])+" HOST "+hostnm
                    port.write(str(sentstr))
                    port.flush()
                except IndexError:
                    matchObj = re.match("DV[0-9]+$",dvid,re.I)
                    if (matchObj and (typedv == "DHT11" or typedv == "MC52" or typedv == "MQ135")):
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

