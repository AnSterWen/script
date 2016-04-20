awk '{a[$1]+=$2} END {for (i in a) print i "=" a[i]}' file.txt
awk '{x+=$2} END {print x}' file.txt
awk '$1=="www" {x+=$2} END {print x}' file.txt
