#!/bin/bash

. /etc/opt/labsystem/db-config

clear
printf "User: $DB_USER  "
mysqlshow -v -v -v -u $DB_USER -p$DB_PASS $DB_NAME $DB_TABLE
echo '\s' | mysql -v -v -v -u $DB_USER -p$DB_PASS -D $DB_NAME
echo
