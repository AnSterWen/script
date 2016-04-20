#!/bin/bash
for line in $(cat id.txt)
do
    echo $line
done

echo '##########################################'
while read line          #常用的方式
do
    echo $line 
done < id.txt
echo '##########################################'
IFS_OLD=$IFS
IFS=$(echo -en "\n")
for line in $(cat id.txt)
do
    echo $line
done
IFS=$IFS_OLD
echo '##########################################'
cat id.txt | while read line
do
    echo $line
done
