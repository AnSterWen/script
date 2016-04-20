#!/bin/bash
for table in $(mysql -B -N RU -e "show tables" | grep -v id)
do
    echo $table
    mysqldump RU -t --skip-triggers $table -w "zone_id=3" | mysql -ukaka -pkaka123 -h10.1.6.143  RU
done
