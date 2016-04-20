#!/bin/bash
for i in $(mysql  -B --skip-column-names RU -e "show tables;" | grep -v t_ru_base | grep -v t_ru_attribute)
do
    echo $i
   # ./hefu_delete.sh $i
done
