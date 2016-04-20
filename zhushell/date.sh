#!/bin/bash
#时间格式为"20150108 12:30:30" or "2015/01/08 12:30:30"
YMD=$1
HMS=$2
date -s "$YMD $HMS"
