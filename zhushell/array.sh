#!/bin/bash
name1[0]='qian'
name1[1]='shan'
name1[2]='niao'
name1[3]='fei jue'
name2=(du diao han jiang xue)
echo ${name1[0]}
echo ${name1[1]}
echo ${name1[3]}
echo '############'
for ((i=0;i<${#name1[@]};i++))
do
    echo ${name1[$i]}
done
