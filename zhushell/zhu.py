#!/usr/bin/python
import time
def foo():
    print 'in foo()'

def timeit(func):
    def wrapper():
        start = time.clock()
        func()
        end = time.clock()
        print 'used:',end - start
    return wrapper
foo = timeit(foo)
print foo
