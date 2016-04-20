#!/usr/bin/python
import xml.etree.ElementTree as ET
tree = ET.parse('country_data.xml')
#root = tree.getroot()
#root = ET.fromstring(country_data_as_string)
for node in tree.iter('gdppc'):
    if node.text == '59900':
        node.text = '99999'
        print 'node.tag: ',node.tag
        print 'node.attrib: ',node.attrib
        print 'node.text: ',node.text
        print '#'*50
tree.write('data.xml')


