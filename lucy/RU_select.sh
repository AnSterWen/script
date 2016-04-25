#!/bin/bash
for ip in 107 114 115 116 117 118 119
do
    for i in $(mysql -h10.100.150.$ip -P57306 -upubs_ru_mng -p0EOxMx=9@cWO -B --skip-column-names RU -e "show tables;")
    do
        echo $i
        #mysql -h10.100.150.$ip -P57306 -upubs_ru_mng -p0EOxMx=9@cWO -e "delete from $i;"
    done
    echo "################################################"
done

#./han.py -v aos -l rank  -c 'rm -rf /opt/new_ahero/rank_svc/db/*'
#./han.py -v aos -l rank -c restart
