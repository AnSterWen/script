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
fi



echo "START UPDATE NAME ZONE_ID($1, $ZONEID_FROM_EXT)"
`$SQL_CONNECT "update RU.t_ru_base set name=concat(concat(name, '-s'), '$ZONEID_FROM_EXT')  where zone_id=$1 and name not like '%-s%' and name not like '%-a%';"`
echo "END UPDATE NAME ZONE_ID($1, $ZONEID_FROM_EXT)"


