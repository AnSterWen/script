#!/usr/bin/awk -f

BEGIN {
    FS="-"
    print $0
}


{ 
 if ( FILENAME ~ 400009){
     print 400009
     }
}
