#!/bin/bash
name="192.168.56.101"
re='[0-9]*\.[0-9]*\.[0-9]*\.[0-9]*'
if [[ "$name" =~ $re ]];then
    echo $BASH_REMATCH
else
    echo no
fi

