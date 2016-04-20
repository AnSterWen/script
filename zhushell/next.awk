#!/usr/bin/awk -f

{ 
    if ($1=="Mary"){
        next
    }
    print $0
}
