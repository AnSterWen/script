. ./sql_config

if [ x"$1" = x ]; then 
	echo "NO FROM ZONEID "
	exit 0;
else
	ZONEID_FROM=$1
	ZONEID_FROM_EXT=$3
fi

if [ x"$2" = x ]; then 
	echo "NO TO ZONEID "
	exit 0;
else
	ZONEID_TO=$2
	ZONEID_TO_EXT=$(($2%1000))
fi


echo "START UPDATE NAME ZONE_ID($1, $ZONEID_FROM_EXT)"
`$SQL_CONNECT "update RU.t_ru_base set name=concat(concat(name, '-s'), '$ZONEID_FROM_EXT')  where zone_id=$1 and name not like '%-s%';"`
echo "END UPDATE NAME ZONE_ID($1, $ZONEID_FROM_EXT)"

NOW=`date +%s`



TABLES=`$SQL_CONNECT "select COLUMNS.TABLE_NAME from information_schema.TABLES, information_schema.COLUMNS where information_schema.TABLES.TABLE_NAME = information_schema.COLUMNS.TABLE_NAME and information_schema.COLUMNS.COLUMN_NAME='zone_id' and information_schema.TABLES.TABLE_SCHEMA='RU';"`
echo "UPDATE USER ZONE_ID FROM($ZONEID_FROM, $ZONEID_TO)"
for TABLE in $TABLES; do
	echo $TABLE
	`$SQL_CONNECT "update RU.$TABLE set zone_id=$ZONEID_TO where zone_id=$ZONEID_FROM"`
done

