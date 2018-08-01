import serial
import sys
import time
import logging

port = serial.Serial("/dev/ttyAMA0",baudrate=9600,timeout=1)

port.write('AT+CMGF=0'+'\r\n')
time.sleep(2)
port.flushInput()
port.flushOutput()
port.write('AT+CSCS="HEX"'+'\r\n')
time.sleep(2)
port.flushInput()
port.flushOutput()
port.write('AT+CUSD=1,"*101#",15'+'\r\n')
time.sleep(60)
while True:
    if port.inWaiting() > 0:
        reply = port.readline()
        if '+CUSD:' in reply:
            reply2 = reply[reply.find(',"'):reply.find('",')]
            print reply
            print reply2
    else:
        break
port.flushInput()
port.flushOutput()
port.close()
