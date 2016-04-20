from django import forms
from django.contrib.admin import widgets

class DateForm(forms.Form):
    time = forms.DateTimeField(required=True,label='time',widget=widgets.AdminDateWidget())
