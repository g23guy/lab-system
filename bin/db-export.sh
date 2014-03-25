#!/bin/bash

. /etc/opt/labsystem/db-config

printf "Exporting Lab Data... "
BACKUP_DIR=$(dirname $DB_XFILE)
[[ -d $BACKUP_DIR ]] || mkdir -p $BACKUP_DIR
echo "SELECT * FROM servers;" | mysql -u $DB_USER -p$DB_PASS -D $DB_NAME > $DB_XFILE
echo Done
echo
exit 0
