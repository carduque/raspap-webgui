## Info
Fork to test some features personal features. All credits to original repo: https://github.com/billz/raspap-webgui

## Fork changes
- Changed IP range and address
- Added menu to see logs
- Added support to rPi3

## Quick installer
Install RaspAP from your RaspberryPi's shell prompt:
```sh
$ wget -q https://git.io/vDHhd -O /tmp/raspap && bash /tmp/raspap
```
The installer will complete the steps in the manual installation (below) for you.

After the reboot at the end of the installation the wireless network will be
configured as an access point as follows:
* IP address: 192.168.83.1
  * Username: admin
  * Password: secret
* DHCP range: 192.168.83.10 to 192.168.83.40
* SSID: `raspi-webgui`
* Password: `raspberry`

## License
See the [LICENSE](./LICENSE) file.
