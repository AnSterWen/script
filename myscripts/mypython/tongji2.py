#!/usr/bin/python
def test(file,n=10):
    count = {}
    for word in open(file).read().split():
        if count.has_key(word):
            count[word] = count[word] + 1
        else:
            count[word] = 1
    return sorted(count.items( ),key=lambda x:x[1],reverse=True)[0:n]

for i in  test('/etc/init.d/functions',10):
    print '-%8s\t%d' % i
