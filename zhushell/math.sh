#!/bin/bash
i=0
while [ $i -le 5 ]
do
    let i++
    echo "i=$i"
done
echo '########################'
j=0
while [ $j -le 10 ]
do
    let j+=2
    echo "j=$j"
done
echo '########################'
