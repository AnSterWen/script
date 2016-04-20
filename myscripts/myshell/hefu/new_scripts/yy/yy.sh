./change_name.sh 5001232 5001253  10
./change_name.sh 5001233 5001253  11
./combine_server.sh 5001253 "zone_id=5001232 or zone_id = 5001233"
./rank.sh 5001253
