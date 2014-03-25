#!/bin/bash

. /etc/opt/labsystem/db-config

clear
if [ -e $DB_IFILE ]; then
	echo "LOAD DATA INFILE '$DB_IFILE' INTO TABLE servers;" | mysql -v -v -v -u $DB_USER -p$DB_PASS -D $DB_NAME
	echo "SELECT * FROM servers;" | mysql -v -v -v -u $DB_USER -p$DB_PASS -D $DB_NAME
else
	echo "ERROR: File not found, $DB_IFILE"
fi
echo
