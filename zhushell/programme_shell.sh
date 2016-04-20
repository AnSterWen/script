#!/bin/bash
'###############################seq的使用###########################################'
seq [选项]... 尾数
seq [选项]... 首数 尾数
seq [选项]... 首数 增量 尾数
'''以指定增量从首数开始打印数字到尾数
使用方式有上面三种，当seq 后面的数字仅有1个时为位数，而首数省略时默认为1，增量省略时默认为1
root@zhu:/var/www# seq 3
1
2
3
root@zhu:/var/www# seq 3 10
3
4
5
6
7
8
9
10
root@zhu:/var/www# seq 3 2 10
3
5
7
9
root@zhu:/var/www# seq 3 3 10
3
6
9
-f, --format=格式	使用printf 样式的浮点格式
-s, --separator=字符串	使用指定字符串分隔数字(默认使用：\n)
-w, --equal-width	在列前添加0 使得宽度相同
选项的使用有上面三种，-s 字符串 ：指定数字之间的分割字符串，默认为换行符\n;
root@zhu:/var/www# seq -s php 3 3 10
3php6php9
root@zhu:/var/www# seq -s 'php and python' 3 3 10
3php and python6php and python9
root@zhu:/var/www# seq -s ' php and python ' 3 3 10
3 php and python 6 php and python 9
'''
'################################从文件中读取行数###########################################'
'''
for line in $(cat id.txt)
do
    echo $line
 done

echo '##########################################'
while read line          #常用的方式
do
    echo $line 
done < id.txt
echo '##########################################'
IFS_OLD=$IFS
IFS=$(echo -en "\n")
for line in $(cat id.txt)
do
    echo $line
    done
    IFS=$IFS_OLD
echo '##########################################'
cat id.txt | while read line
do
    echo $line
done

'
'##########################单引号与双引号###############################################'
'''
root@zhu:~# name="php and python"
root@zhu:~# echo "my name is $name"
my name is php and python
root@zhu:~# echo "my name is '$name'"
my name is 'php and python'
root@zhu:~# echo "my name is \'$name\'"
my name is \'php and python\'
root@zhu:~# echo 'my name is $name'
my name is $name
root@zhu:~# echo 'my name is "$name"'
my name is "$name"
root@zhu:~# echo my name is \'$name\'
my name is 'php and python'
root@zhu:~# echo "my name is \'$name\'"
my name is \'php and python\'
总结：
'' :单引号中的变量不会替换
"" :双引号中的变量可以替换
"''" :双引号内的单引号可以显示出来,单引号内的变量可以正常替换
'""' :双引号可以显示出来，双引号内的变量不会替换
'#######################################文件目录的判断###################################################'
[ -d file ] : 如果 file 存在且是一个目录则为真。
[ -e file ] : 如果 file 存在则为真。
[ -f file ] : 如果 file 存在且为普通文件则为真。
[ -h file ] : 如果 file 存在且为符号链接则为真。
[ -r file ] : 如果 file 存在且可读则为真。
[ -s file ] : 如果 file 存在且大小大于零则为真。
[ -w file ] : 如果 file 存在且可写则为真。
[ -x file ] : 如果 file 存在且可执行则为真。
[ -S file ] : 如果 file 存在且为套接字则为真。
[ file1 -nt file2 ] : 如果 file1 比 file2 要新 (根据修改日期)，或者 如果 file1 存在而 file2 不存在，则为真。
[ file1 -ot file2 ] : 如果 file1 比 file2 更旧，或者 如果 file1 不存在而 file2 存在，则为真。
[ file1 -ef file2 ] : 如果 file1 和 file2 指的是相同的设备和 inode 号则为真。
#####################################字符串比较########################################
[ -z string ] : 如果 string 的长度为 0 则为真。
[ -n string ] : 如果 string 的长度非 0 则为真。
[ string1 == string2 ]: 如果字符串相等则为真。= 可以用于使用 == 的场合来兼容 POSIX 规范。
[ string1 = string2 ]: 如果字符串相等则为真。= 可以用于使用 == 的场合来兼容 POSIX 规范。
[ string1 != string2 ]: 如果字符串不相等则为真。
[ string1 < string2 ] : 如果 string1 在当前语言环境的字典顺序中排在 string2 之前则为真。
[ string1 > string2 ] : 如果 string1 在当前语言环境的字典顺序中排在 string2 之后则为真。
[[ -z string ]] : 如果 string 的长度为 0 则为真。
[[ -n string ]] : 如果 string 的长度非 0 则为真。
[[ string1 == string2 ]]: 如果字符串相等则为真。= 可以用于使用 == 的场合来兼容 POSIX 规范。
[[ string1 = string2 ]]: 如果字符串相等则为真。= 可以用于使用 == 的场合来兼容 POSIX 规范。
[[ string1 != string2 ]]: 如果字符串不相等则为真。
[[ string1 < string2 ]] : 如果 string1 在当前语言环境的字典顺序中排在 string2 之前则为真。
[[ string1 > string2 ]] : 如果 string1 在当前语言环境的字典顺序中排在 string2 之后则为真。
总结：
字符串比较时最好用[[ ]],并且字符串用引号引住，否则有时会出错例如！
root@zhu:~# name="zhu"
root@zhu:~# [ -n $name ] && echo OK || echo NO
OK
root@zhu:~# [ -z $name ] && echo OK || echo NO
NO
root@zhu:~# [[ -n $name ]] && echo OK || echo NO
OK
root@zhu:~# [[ -z $name ]] && echo OK || echo NO
NO
root@zhu:~# [ -n "$name" ] && echo OK || echo NO
OK
root@zhu:~# [ -z "$name" ] && echo OK || echo NO
NO
root@zhu:~# [[ -n "$name" ]] && echo OK || echo NO
OK
root@zhu:~# [[ -z "$name" ]] && echo OK || echo NO
NO
.....................................................................................
#####################################整数比较##################################################
arg1, arg2 :arg1和arg2分别为正/负整数
[ arg1 -eq arg2 ] :如果arg1与arg2相等则为真否则为假
[ arg1 -ne arg2 ] :如果arg1与arg2不相等则为真否则为假
[ arg1 -lt arg2 ] :如果arg1小于arg2相等则为真否则为假
[ arg1 -le arg2 ] :如果arg1小于等于arg2相等则为真否则为假
[ arg1 -gt arg2 ] :如果arg1大于arg2相等则为真否则为假
[ arg1 -ge arg2 ] :如果arg1大于等于arg2相等则为真否则为假

####################################逻辑运算符###########################################################
cmd1 && cmd2 :若 cmd1 执行完毕且正确执行($?=0)，则开始执行 cmd2,
              若 cmd1 执行完毕且为错诨 ($?≠0)，则 cmd2 不执行
cmd1 || cmd2 :若 cmd1 执行完毕且正确执行($?=0)，则 cmd2 不执行
              若 cmd1 执行完毕且为错诨 ($?≠0)，则开始执行 cmd2
..........................................................
多条件测试时：
root@zhu:~# name="zhu"
root@zhu:~# age="30"
root@zhu:~# [ $name = "zhu" -a  $age -eq 30 ] && echo OK
OK
root@zhu:~# [ $name = "zhu" &&  $age -eq 30 ] && echo OK
-bash: [: 缺少 `]'
root@zhu:~# [[ $name = "zhu" &&  $age -eq 30 ]] && echo OK
OK
root@zhu:~# [[ $name = "zhu" ||  $age -eq 33 ]] && echo OK
OK

总结：
[ expression1 -a expression2 ] :表达式1和表达式2都为真时才为真
[ expression1 -o expression2 ] :表达式1或表达式2为真时便为真
[[ expression1 -a expression2 ]]
[[ expression1 -o expression2 ]]
[[ expression1 && expression2 ]]
[[ expression1 || expression2 ]]
[ expression1 ] && [ expression2 ]
[ expression1 ] || [ expression2 ]
root@zhu:~# [ ! $name = "zhu" ] && echo OK
root@zhu:~# [ ! $name != "zhu" ] && echo OK
OK
root@zhu:~# [ ! $age -ge 30 ] && echo OK
root@zhu:~# [ ! $age -ge 33 ] && echo OK
OK

#####################################if控制######################################################
if [ 条件判断式 ] 
then
条件为真时，进行的操作 
fi
或者 
if [ 条件判断式 ]；then
条件为真时，进行的操作 
fi 
................................................
if [  条件判断式 ]；then
条件为真时，执行的操作 
else
条件为假时，执行的操作 
fi 

...............................................
if [ 条件判断1 ];then
条件1为真时执行的指令 
elif [ 条件判断2 ];then
条件2为真时执行的指令 
elif [ 条件判断3 ];then
条件3为真时执行的指令 
else
当前面的所有条件都不匹配时执行的指令 
fi 
...........................................................................
case $变量 in
"value1") 
指令；； 
"value2") 
指令；； 
"value3") 
指令；； 
*) 
指令；； 
esac 
######################################循环##############################################
for循环：列表for循环和步长for循环
for variable in list 
do
指令 
done
# variable 循环变量 
#list为列表，执行的次数与list列表中的常数或字符串的个数相等 
#do与dong之间是的命令称为循环体 
IFS字段分隔符对for循环的影响
IFS:内部字段分隔符，默认是空格，tab键，换行符
..................................................
#!/bin/bash
name="du diao han jiang xue"
for i in $name
do
echo $i
done
echo '#############################'
for i in du diao han jiang xue
do
   echo $i
done
echo '#############################'
IFS='a'
for i in $name
do
   echo $i
done
.......................................................
root@zhu:~/zhushell# ./for.sh 
du
diao
han
jiang
xue
#############################
du
diao
han
jiang
xue
#############################
du di
o h
n ji
ng xue

.......................................................
for ((初始值；限制值；步长)) 
do
命令区域 
done 
......................................................................
########################################数学运算##########################################
id++ id--
       变量自增/自减 (在后)
++id --id
       变量自增/自减 (在前)
- +    (单目的) 取负/取正
! ~    逻辑和位取反
**     乘幂
* / %  乘，除，取余
+ -    加，减
<< >>  左/右位移
<= >= < >
       比较
== !=  相等/不等
&      位与 (AND)
^      位异或 (exclusive OR)
|      位或 (OR)
&&     逻辑与 (AND)
||     逻辑或 (OR)
expr?expr:expr
       条件求值
= *= /= %= += -= <<= >>= &= ^= |=
..................................................................................
expr 总结：
运算符的前后要有空格
乘法*需要转义
赋值给变量时需要反单引号``或$()
root@zhu:~/zhushell# expr 3+5
3+5
root@zhu:~/zhushell# expr 3 + 5
8
root@zhu:~/zhushell# expr 3 * 5
expr: 语法错误
root@zhu:~/zhushell# expr 3 \* 5
15
root@zhu:~/zhushell# sum=`expr 8 + 8` && echo $sum
16
....................................................................................
let 总结：
#1.后面的表达式不能有空格，若有空格需要加上引号，所以建议一律使用let "表达式“的方法 
#2.let后跟的表达式中使用变量时不需使用$ 
root@zhu:~/zhushell# let x=8+9
root@zhu:~/zhushell# echo $x
17
root@zhu:~/zhushell# let x=8 + 9
-bash: let: +: 语法错误: 期待操作数 （错误符号是 "+"）
root@zhu:~/zhushell# let "x=8 + 9"
root@zhu:~/zhushell# echo $x
17
root@zhu:~/zhushell# x=11 && y=22 && let "m=x+y" && echo $m
33
....................................................................................
[]的总结： 
变量名=[表达式] []里面空格有没有无所谓 
root@zhu:~/zhushell# m=$[22+3] && echo $m
25
root@zhu:~/zhushell# m=$[ 22+3 ] && echo $m
25
root@zhu:~/zhushell# m=$[ 22 + 3 ] && echo $m
25
.......................................................
（（））与let等价，（（））双括号内是否有空格不做要求 
root@zhu:~/zhushell# m=$((3+5)) && echo $m
8
root@zhu:~/zhushell# a=2 && b=9 && echo $((a+b))
11
.......................................................
#在脚本中利用bc计算的一般格式为： 
variable=`echo "scale=n;expression" | bc` 
bc默认输出为整数，scale可以定义小数的位数 
root@zhu:~/zhushell#  m=`echo "scale=2;88+22" | bc` && echo $m
110
...........................................................

root@zhu:~/zhushell# a=5; echo $a; echo $((++a)); echo $a
5
6
6
root@zhu:~/zhushell# a=5; echo $a; echo $((a++)); echo $a
5
5
6
root@zhu:~/zhushell# a=5; echo $a; echo $((--a)); echo $a
5
4
4
root@zhu:~/zhushell# a=5; echo $a; echo $((a--)); echo $a
5
5
4

#########################################数组##################################################
数组的定义:
name=(value1     ...     valuen)
或者:
name[0]=value1
name[1]=value2
name[2]=value3
总结：
1：使用（）定义数组时元素value之间是空格隔开，此时若不对元素指定数标默认是从0开始，后面的元素索引是前一个的索引
   加1
2：访问数组元素时使用${数组名[index]}
例如:
root@zhu:~/zhushell# name=('du' 'diao' 'han jiang xue')
root@zhu:~/zhushell# echo ${name[0]}
du
root@zhu:~/zhushell# echo ${name[1]}
diao
root@zhu:~/zhushell# echo ${name[2]}
han jiang xue
............................................................
root@zhu:~/zhushell# name[0]='qian shan'
root@zhu:~/zhushell# name[1]='han jiang xue'
root@zhu:~/zhushell# echo ${name[0]}
qian shan
root@zhu:~/zhushell# echo ${name[1]}
han jiang xue
............................................................
root@zhu:~/zhushell# name=([1]='du' 'diao' 'han jiang xue')
root@zhu:~/zhushell# echo ${name[0]}

root@zhu:~/zhushell# echo ${name[1]}
du
root@zhu:~/zhushell# echo ${name[2]}
diao
root@zhu:~/zhushell# echo ${name[3]}
han jiang xue
............................................................
root@zhu:~/zhushell# name=([3]='php' [5]='python' [7]='mysql')
root@zhu:~/zhushell# echo ${name[@]}
php python mysql
root@zhu:~/zhushell# echo ${name[0]}

root@zhu:~/zhushell# echo ${name[1]}

root@zhu:~/zhushell# echo ${name[2]}

root@zhu:~/zhushell# echo ${name[3]}
php
root@zhu:~/zhushell# echo ${name[4]}

root@zhu:~/zhushell# echo ${name[5]}
python
root@zhu:~/zhushell# echo ${name[6]}

root@zhu:~/zhushell# echo ${name[7]}
mysql
.................................................................................
访问数组：
root@zhu:~/zhushell# name=('php' 'python' 'mysql' 'han jiang xue')
root@zhu:~/zhushell# echo ${name[0]} #访问元素1
php
root@zhu:~/zhushell# echo ${name[1]} #访问元素2
python
root@zhu:~/zhushell# echo ${name[2]} #访问元素3
mysql
root@zhu:~/zhushell# echo ${name[3]} #访问元素4
han jiang xue
root@zhu:~/zhushell# echo ${name[@]} #访问所有元素
php python mysql han jiang xue
root@zhu:~/zhushell# echo ${name[*]} #访问所有元素
php python mysql han jiang xue
root@zhu:~/zhushell# echo ${#name[*]} #返回数组元素个数
4
root@zhu:~/zhushell# echo ${#name[@]} #返回数组元素个数
4
遍历数组元素
for ((i=0;i<${#name1[@]};i++))
do
    echo ${name1[$i]}
done













































































