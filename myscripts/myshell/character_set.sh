#!/bin/bash

'服务器级别的字符集和排序的值是在mysql服务器启动的时候指定的，可以在命令行或配置文件中指定，该值一般写在配置文件
 中，若不指定则使用默认值，该值的默认值是在mysql编译安装时指定的，若在编译时不指定默认使用latin1'

'数据库级别的字符集和排序的值是在创建数据库的时候指定的，若不指定则使用默认值，默认值就是mysql服务器级别所设置的
 字符集和排序'

'表级别的字符集和排序的值是在创建表时指定的，若不指定则使用默认值，默认值就是数据库级别的所设置的字符集和排序'

'列级别的字符集和排序的值是在创建表时指定的，若不指定则使用默认值，默认值就是表级别的所设置的字符集和排序'

'character_set_client 客户端向服务器发送sql语句时所使用的字符集    
 character_set_connection 当服务器接收到客户端的语句字符串时，它将该字符串从character_set_client转换为
                          为character_set_connection并使用后者对该语句进行处理，                          
 character_set_database   默认数据库的字符集，该变量为只读变量   
 character_set_filesystem 文件系统字符集
 character_set_results    服务器向客户端返回结果时所使用的字符集  
 character_set_server     服务器的默认字符集和排序  
 character_set_system     各种标识符所使用的字符集，永远是utf8
 character_sets_dir'     




