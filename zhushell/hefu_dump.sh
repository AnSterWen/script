#!/bin/bash
for table in $(mysql -B -N RU -e "show tables" | grep -v id)
do
    echo $table
    mysqldump RU -t --skip-triggers -w "zone_id=3" $table >$table.sql
done
