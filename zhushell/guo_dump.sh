#!/bin/bash
#date:Nov 28 2014
#Author:jimmygong
#Mail:jimmygong@taomee.com
#Function:backup zoneid
#Version:1.0
set -o nounset
set -o errexit

function aaa () {
i=1
for tables in t_ru_base t_ru_activity t_ru_airank t_ru_attribute t_ru_dailytask t_ru_dnd t_ru_enemy t_ru_friend t_ru_instance t_ru_item t_ru_shared_attribute t_ru_skills t_ru_task t_ru_weapon t_ru_diamondback t_ru_fairy t_ru_shopping t_ru_freeze_player t_ru_mail_relation t_ru_new_mail t_ru_temp_reward t_ru_guild t_ru_guild_player t_ru_player_red_packet t_ru_red_packet t_ru_red_packet_record 
do
	{
echo $tables
mysqldump -uroot -pRYcO*QCV -S /var/run/mysqld/mysqld.sock RU --opt -t  $tables --single-transaction --quote-names --skip-set-charset --default-character-set=latin1 --where "zone_id=5001272 or zone_id=5001273 or zone_id=5001274 or zone_id=5001259 or zone_id=5001260 or zone_id=5001263 " > /opt/taomee/appgame/scripts/201411283306/$tables.sql
}&
[[ $i%10 -eq 0 ]] && wait
let i++
done
date +%F:%T
echo "=============================================="
wait
}

aaa
exit 0
