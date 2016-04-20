#!/usr/bin/python2.7
import collections
import re
words = re.findall(r'\w+',open('/etc/init.d/functions').read().lower())
print collections.Counter(words).most_common(5)
