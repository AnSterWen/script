#!/bin/bash
tel=13918295804

function send_message() {
local err_message=${@:1}
for phone in ${tel[@]}
do
links -dump "http://192.168.6.19/cgi-bin/newsend?mobile=$phone&msg=$err_message&sign=add6b4bb1b0d2f3f6d859eeab7f1eb4b" > /dev/null 2>&1
done
}
