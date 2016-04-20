#!/bin/bash
echo "<?php return array ("
while read a
do
echo "'$a' =>' ',"

done < $1
echo "?>"
