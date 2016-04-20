#!/bin/bash
while getopts "lmn:" s
do
    case $s in
        l)
            echo "l"
            ;;
        m)
            echo "m"
            ;;
        n)
            echo "the name is $OPTARG"
           ;;
        ?)
            echo "unknown arg"
    esac
done

