#!/bin/bash
while read zhong tai
do
    echo $zhong,$tai
    sed -i "s/$zhong/$tai/" Localization2.lua
done <name.txt
