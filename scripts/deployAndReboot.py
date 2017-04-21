#!/usr/bin/python
#
# apmodeOn.py
#
# Prerequisites: dnsmasq, hostapd, lighttpd, wlan0 interface
#

from __future__ import print_function
import time
import sys
import subprocess
import traceback
import os

def deploy():
    subprocess.call("sudo ./opt/FeerBoxClient/FeerBoxClient/scripts/deploy.sh", shell=True)
    time.sleep(3)
    subprocess.call("sudo reboot", shell=True)

def Main():
    deploy()

#Main loop
if __name__ == '__main__':
    try:
        Main()

    except KeyboardInterrupt:
        print(" -> Stopped")

    except Exception as e:
        #print("ERROR: " + str(e))
        traceback.print_exc()

    finally:
        print("PROGRAM FINISHED")


