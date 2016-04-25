#!/bin/bash

TIME=\'$1\'
echo $TIME
for table in $(mysql -uroot -p'!QAZ@WSX' ahero -e "show tables;" | grep ST )
do
    echo "$table:"
    mysql -uroot -p'!QAZ@WSX' ahero  -e "delete * from $table where time < $TIME ;"
    echo "##############################"
done
