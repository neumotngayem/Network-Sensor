import serial
import sys

port = serial.Serial("/dev/ttyUSB0",baudrate=9600,timeout=0.2)
sentstr = sys.argv[1]+" ACKNO"
port.write(str(sentstr))
port.flush()

