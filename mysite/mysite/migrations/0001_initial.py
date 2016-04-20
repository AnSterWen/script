# -*- coding: utf-8 -*-
# Generated by Django 1.9.4 on 2016-03-25 08:54
from __future__ import unicode_literals

from django.db import migrations, models


class Migration(migrations.Migration):

    initial = True

    dependencies = [
    ]

    operations = [
        migrations.CreateModel(
            name='lush',
            fields=[
                ('name', models.CharField(max_length=30, primary_key=True, serialize=False)),
                ('ip', models.CharField(max_length=30)),
            ],
        ),
        migrations.CreateModel(
            name='ServerList',
            fields=[
                ('id', models.AutoField(auto_created=True, primary_key=True, serialize=False, verbose_name='ID')),
                ('name', models.CharField(max_length=30)),
                ('ip', models.CharField(max_length=30)),
            ],
        ),
    ]