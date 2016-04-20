./change_name.sh 6010001 6010032 1001  
./change_name.sh 6010002 6010032 1002
./combine_server.sh 6010032 "zone_id=6010001 or zone_id = 6010002"
./rank.sh 6010032
