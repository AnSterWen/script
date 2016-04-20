#!/bin/bash
awk  -f online.awk 400009* &
awk  -f online.awk 400010* &
awk  -f online.awk 400021* &
ps -ef | grep -v grep | grep -q awk 
