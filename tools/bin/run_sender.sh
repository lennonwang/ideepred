#!/bin/bash
#
# 发送邮件的守护进程，每隔t秒运行一次检测脚本
# 

ROOT=`pwd`
# wait 3 
t=30

while(true)
do
    php -q $ROOT/Mailer.php
    sleep $t
done
