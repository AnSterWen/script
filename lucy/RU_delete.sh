#!/bin/bash
for table in $(mysql -h10.165.58.100 -ukaka -pkaka123 -B --skip-column-names RU -e "show tables;")
do
     echo $table
     mysql -h10.165.58.100 -ukaka -pkaka123 RU -e "delete from $table where zone_id = 2"
     echo '########################################################'
done
