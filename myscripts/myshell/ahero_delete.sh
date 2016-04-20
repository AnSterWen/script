#!/bin/bash
TIME=\'$1\'

for table in $(mysql -p123456 ahero -e "show tables;" | grep ST )
do
    echo "$table:" 
    mysql -p123456 ahero -e "delete from $table where time < $TIME;optimize $table;"
    echo "##############################"
done
