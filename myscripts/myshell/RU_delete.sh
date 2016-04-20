#!/bin/bash
for i in $(mysql -ukaka -pkaka123 -h10.10.10.10 -B --skip-column-names RU -e "show tables;")
do
    echo $i
    mysql -ukaka -pkaka123 -h10.10.10.10 -e "delete from $i;"
done
