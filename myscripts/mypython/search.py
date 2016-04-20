#!/usr/bin/python
import os
def search_file(filename, search_path, pathsep=os.pathsep):
    for path in search_path.split(pathsep):
        candidate = os.path.join(path,filename)
        if os.path.isfile(candidate):
            return os.path.abspath(candidate)
    
        
