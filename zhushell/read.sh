#!/bin/bash
while read OS VALUE
do
    echo "OS : $OS"
    echo "VALUE: $VALUE"
done < name.txt
