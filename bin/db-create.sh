#!/bin/bash

. /etc/opt/labsystem/db-config

clear
if [ -e $DB_CFILE ]; then
	mysql -v -v -v -u $DB_USER -p$DB_PASS < $DB_CFILE
else
	echo "ERROR: File not found, $DB_CFILE"
fi
echo
