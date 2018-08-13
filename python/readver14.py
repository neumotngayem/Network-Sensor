import serial
import pymysql
pymysql.install_as_MySQLdb()
import MySQLdb
import time
import datetime
import re
import os
import logging
import subprocess

port = serial.Serial("/dev/ttyUSB0",baudrate=9600,timeout=0.2)
db= MySQLdb.connect("localhost", "root", "admin123", "iot")
cursor= db.cursor()
hostnm = 'RS1'
updateFlg = False
callFlg = True
smsFlgDHT11 = True
smsFlgMQ135 = True
print("Raspberry's receiving : ")
 
try:
    while True:
        rcv = port.readline()
        data = rcv.rstrip()			# cut "\r\n" at last of string
        if data != "":
            print(data) # print string
            if "ACKNO" in data:
                dvid = data[:(data.find("ACKNO"))]
                typedv = data[(data.find("TYP:")+4):]
                try:
                    sql = "SELECT loca_id FROM home where device_id = '%s'" % (dvid)
                    cursor.execute(sql)
                    data = cursor.fetchall()
                    row = data[0]
                    if row[0] == 0:
                        sql = "DELETE FROM home where device_id = '%s'" % (dvid)
                        cursor.execute(sql)
                        db.commit()
                        raise IndexError
                    sentstr = dvid+"ACKYESHS:"+hostnm+"\n"
                    print(sentstr)
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
                    continue
            if "TMP" in data:
                hs = data[0:data.find("TMP")]
                if hs != hostnm:
                    continue
                else:
                    dvid = data[(data.find("TMP")+3):data.find("DT:")]
                    typedv="DHT11"
                    temp = data[(data.find("DT:")+3):]     
            if "HUM" in data:
                humi = data[(data.find("DT:")+3):]                
                updateFlg = True
            if "OPN" in data:
                hs = data[0:data.find("OPN")]
                if hs != hostnm:
                    continue
                else:
                    dvid = data[(data.find("OPN")+3):data.find("DT:")]
                    typedv = "MC52"
                    dopen = data[(data.find("DT:")+3):]
                    updateFlg = True
            if "CO2" in data:
                hs = data[0:data.find("CO2")]
                if hs != hostnm:
                    continue
                else:
                    dvid = data[(data.find("CO2")+3):data.find("DT:")]
                    typedv = "MQ135"
                    co2 = data[(data.find("DT:")+3):]
            if "COO" in data:
                co = data[(data.find("DT:")+3):] 
            if "ETH" in data:
                ethanol = data[(data.find("DT:")+3):] 
            if "TOL" in data:
                toluene = data[(data.find("DT:")+3):] 
            if "ACE" in data:
                acetone = data[(data.find("DT:")+3):] 
            if "ANA" in data:
                analog = data[(data.find("DT:")+3):]
                updateFlg = True
            if updateFlg :
                try:
                    sql = "SELECT loca_id,warn,cmpsign1,warntemp,cmpsign2,warnhumi FROM home where device_id = '%s'" % (dvid)
                    cursor.execute(sql)
                    query = cursor.fetchall()
                    row = query[0]
                    locaid = row[0]
                    warn = row[1]
                    cmpsign1 = row[2]
                    warntemp = row[3]
                    cmpsign2 = row[4]
                    warnhumi = row[5]
                except Exception,e:
                    print(e)
                    continue
                if(locaid ==  0):
                    print("SENT ACKNO")
                    port.write(dvid+"ACKNO")
                    port.flush()
                    updateFlg = False
                    continue
                ts = time.time()
                st = datetime.datetime.fromtimestamp(ts).strftime('%Y-%m-%d %H:%M:%S')
                if "DHT11" in typedv:
                    sms = ''
                    if warn == 1:
                        if cmpsign1 == 1 and float(temp) > warntemp:
                                sms = "Device "+dvid+" measure the temperature right now is "+temp+" hotter than your thresehold"
                        if cmpsign1 == 2 and float(temp) == warntemp:
                                sms = "Device "+dvid+" measure the temperature right now is "+temp+" equal your thresehold"
                        if cmpsign1 == 3 and float(temp) < warntemp:
                                sms = "Device "+dvid+" measure the temperature right now is "+str(temp)+" colder than your thresehold"
                        if cmpsign2 == 1 and float(humi) > warnhumi:
                                if sms != '':
                                    sms += ", and also the humidity right now is "+str(humi)+" higher than your thresehold"
                                else:
                                    sms = "Device "+dvid+" measure the humidity right now is "+str(humi)+" higher than your thresehold"
                        if cmpsign2 == 2 and float(humi) == warnhumi:
                                if sms != '':
                                    sms += ", and also the humidity right now is "+str(humi)+" equal your thresehold"
                                else:
                                    sms = "Device "+dvid+" measure the humidity right now is "+str(humi)+" equal your thresehold"
                        if cmpsign2 == 3 and float(humi) < warnhumi:
                                if sms != '':
                                    sms += ", and also the humidity right now is "+humi+" lower than your thresehold"
                                else:
                                    sms = "Device "+dvid+" measure the humidity right now is "+humi+" lower than your thresehold"
                    if sms == '':
                        smsFlgDHT11 = True
                    if warn == 1 and sms != '' and smsFlgDHT11:
                        subprocess.call(["python","smssos.py",sms])
                        smsFlgDHT11 = False                   
                    sql = "INSERT INTO home (device_id, type, temp, humi, warn) VALUES ('%s', '%s', %s, %s, '%s') ON DUPLICATE KEY UPDATE temp = %s, humi = %s, timestamp = '%s'" % (dvid,typedv,temp,humi,0,temp,humi,str(st))
                    sql2 = "INSERT INTO dht11 (device_id, temp, humi) VALUES ('%s', '%s', %s)" % (dvid,temp,humi)
                elif "MC52" in typedv:
                    if dopen == '0':
                        callFlg = True
                    if warn == 1 and dopen == '1' and callFlg:
                       subprocess.call(["python","callsos.py"])
                       callFlg = False
                    sql = "INSERT INTO home (device_id, type, open, warn) VALUES ('%s', '%s', %s, %s) ON DUPLICATE KEY UPDATE open = %s, timestamp = '%s'" % (dvid,typedv,dopen,0,dopen,str(st))
                    sql2 = "INSERT INTO mc52 (device_id, open) VALUES ('%s', %s)" % (dvid,dopen)
                elif "MQ135" in typedv:
                    if analog < 200:
                        smsFlgMQ135 = True
                    if warn == 1 and int(analog)  > 200:
                        sms = "Device "+dvid+" detected a problem with your air quality right now"
                        subprocess.call(["python","smssos.py",sms])
                        smsFlgMQ135 = False           
                    sql = "INSERT INTO home (device_id, type, co2, co, ethanol, toluene, acetone, analog, warn) VALUES ('%s', '%s', %s, %s, %s, %s, %s, %s, %s) ON DUPLICATE KEY UPDATE co2 = %s, co = %s, ethanol = %s, toluene = %s, acetone = %s, analog = %s, timestamp = '%s'" % (dvid,typedv,co2,co,ethanol,toluene,acetone,analog,0,co2,co,ethanol,toluene,acetone,analog,str(st))         
                    sql2 = "INSERT INTO mq135 (device_id, co2, co, ethanol, toluene, acetone) VALUES ('%s', %s, %s, %s, %s, %s)" % (dvid,co2,co,ethanol,toluene,acetone)
                matchObj = re.match("DV[0-9]+$",dvid,re.I)
                if(matchObj):
                    try:
                        cursor.execute(sql)
                        cursor.execute(sql2)
                        db.commit()
                        upstr = "UPDATED ON %s" % (str(st))
                        print upstr
                        updateFlg = False
                    except MySQLdb.Error, e:
                        print sql+"\n";
                        print sql2+"\n";
                        print("Error with MySQL")
                    except Exception,e:
                        print sql;
                        print(e)  
                               
except KeyboardInterrupt:
        port.close()
        db.close()

