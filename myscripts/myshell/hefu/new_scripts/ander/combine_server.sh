. ./sql_config

if [ x"$1" = x ]; then 
	echo "NO FROM ZONEID "
	exit 0;
else
	ZONEID_TO=$1 
fi

if [ x"$2" = x ]; then 
	echo "NO TO ZONEID "
	exit 0;
else
	ZONE_EXP=$2
fi

NOW=`date +%s`



TABLES=`$SQL_CONNECT "use RU; show tables;"`
echo "UPDATE USER ZONE_ID FROM($ZONEID_FROM, $ZONEID_TO)"
for TABLE in $TABLES; do
	echo $TABLE
	`$SQL_CONNECT "update RU.$TABLE set zone_id=if($ZONE_EXP,$ZONEID_TO,zone_id)"`
done

