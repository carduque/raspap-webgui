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

def turnOff():
    subprocess.call("sudo ifdown wlan0", shell=True)
    subprocess.call("sudo service hostapd stop", shell=True)
    subprocess.call("sudo service dnsmasq stop", shell=True)
    subprocess.call("sudo service lighttpd stop", shell=True)
    subprocess.call("sudo cp " + os.getcwd() + "/interfaces.client /etc/network/interfaces", shell=True)
    subprocess.call("sudo cat /etc/dhcpcd.conf | grep -v 'denyinterfaces wlan0' > /tmp/dhcpcd.conf", shell=True)
    subprocess.call("sudo mv /tmp/dhcpcd.conf /etc/dhcpcd.conf", shell=True)
    time.sleep(3)
    subprocess.call("sudo ifup wlan0", shell=True)
    subprocess.call("sudo reboot", shell=True)
    #If issues, relaunch this: "/sbin/wpa_supplicant -s -B -P /run/wpa_supplicant.wlan0.pid -i wlan0 -D nl80211,wext -c /etc/wpa_supplicant/wpa_supplicant.conf"

def turnOn():
    subprocess.call("sudo ifdown wlan0", shell=True)
    subprocess.call("sudo cp " + os.getcwd() + "/interfaces.ap /etc/network/interfaces", shell=True)
    subprocess.call("echo 'denyinterfaces wlan0' | sudo tee -a /etc/dhcpcd.conf", shell=True)
    time.sleep(3)
    subprocess.call("sudo ifup wlan0", shell=True)
    subprocess.call("sudo service hostapd start", shell=True)
    subprocess.call("sudo service dnsmasq start", shell=True)
    subprocess.call("sudo service lighttpd start", shell=True)
    

def Main():
    if len(sys.argv) != 2:
        print("Only one argument expected")
        sys.exit(-1)
    if sys.argv[1] == "on":
        print("Turn on AP mode")
        turnOn()
    elif sys.argv[1] == "off":
        print("Turn off AP mode")
        turnOff()
    else:
        print("Unexpected argument")
        sys.exit(-1)


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


