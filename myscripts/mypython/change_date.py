import datetime
today = datetime.date.today()
yesterday = today - datetime.timedelta(days=1)
tomorrow = today + datetime.timedelta(days=1)
print yesterday, today, tomorrow

print yesterday.strftime('%Y%m%d')
print today.strftime('%Y%m%d')
print tomorrow.strftime('%Y%m%d')

