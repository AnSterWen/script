#!/usr/bin/python
n = 15
def zhu(a):
    a = [str(i) for i in a]
    print '%s%s' % (' ' * (n - len(a)),' '.join(a))

for x in range(n):
    if x < 2:
        b = [1] * (x + 1)
    else:
        b[1:-1] = [(b[j] + s) for j, s in enumerate(b[1:])]
    zhu(b)












