#!/bin/bash

. /srv/www/htdocs/wsslab/install/db-config

printf "Exporting wsslab data... "
echo "SELECT * FROM servers;" | mysql -u $DB_USER -p$DB_PASS -D $DB_NAME > $DB_XFILE
echo Done
echo
exit 0
