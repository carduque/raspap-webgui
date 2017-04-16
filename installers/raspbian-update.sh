UPDATE_URL="https://raw.githubusercontent.com/carduque/raspap-webgui/master/"
wget -q ${UPDATE_URL}/installers/common.sh -O /tmp/raspapcommon.sh
source /tmp/raspapcommon.sh && rm -f /tmp/raspapcommon.sh

install_raspap_update
