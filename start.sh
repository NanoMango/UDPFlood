#!/bin/bash
DIR="$(cd -P "$( dirname "${BASH_SOURCE[0]}" )" && pwd)"
cd "$DIR"
DO_LOOP="no"
while getopts "p:f:l" OPTION 2> /dev/null; do
	case ${OPTION} in
		p)
			PHP_BINARY="$OPTARG"
			;;
		f)
			UDPFLOOD="$OPTARG"
			;;
		l)
			DO_LOOP="yes"
			;;
		\?)
			break
			;;
	esac
done
if [ "$PHP_BINARY" == "" ]; then
	if [ -f ./bin/php7/bin/php ]; then
		export PHPRC=""
		PHP_BINARY="./bin/php7/bin/php"
	elif type php 2>/dev/null; then
		PHP_BINARY=$(type -p php)
	else
		echo "Couldn't find PHP7 binary"
		exit 1
	fi
fi

if [ "$UDPFLOOD" == "" ]; then
	if [ -f ./UDPFlood/UDPFlood.php ]; then
		UDPFLOOD="./UDPFlood/UDPFlood.php"
	else
		echo "UDPFlood.php is not found."
		exit 1
	fi
fi
LOOPS=0
set +e
while [ "$LOOPS" -eq 0 ] || [ "$DO_LOOP" == "yes" ]; do
	if [ "$DO_LOOP" == "yes" ]; then
		"$PHP_BINARY" $UDPFLOOD $@
	else
		exec "$PHP_BINARY" $UDPFLOOD $@
	fi
	((LOOPS++))
done
if [ ${LOOPS} -gt 1 ]; then
	echo "[INFO] Restarted $LOOPS times"
fi
