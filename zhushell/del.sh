#!/bin/bash
for ip in 107 114 115 116 117 118 119
do
    for table in t_ru_base t_ru_friend t_ru_enemy
    do
        mysql -h10.100.150.$ip -P57306 -upubs_ru_mng -p0EOxMx=9@cWO RU -e "delete from $table where userid in (select userid from t_ru_del_player where dflag = 1 and modify_tm > UNIX_TIMESTAMP(TIMESTAMPADD(WEEK,-1,now()))"
    done
mysql -h10.100.150.$ip -P57306 -upubs_ru_mng -p0EOxMx=9@cWO RU -e "delete from from t_ru_del_player where dflag = 1 and modify_tm > UNIX_TIMESTAMP(TIMESTAMPADD(WEEK,-1,now()))"
done
