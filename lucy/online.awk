#!/usr/bin/awk -f

BEGIN {
    TABLES[2]="ST_SPIRIT_INFO" #精灵信息
    TABLES[3]="ST_SUIT_INFO" #装备信息
    TABLES[4]="ST_SKILL_INFO" #技能信息
    TABLES[9]="ST_ROLE_LEVELUP" #角色升级
    TABLES[10]="ST_VIP_LEVELUP" #VIP升级记录
    TABLES[11]="ST_UNLOCK_SPIRIT" #精灵解锁信息
    TABLES[12]="ST_ROLE_LOGIN_INFO" #用户登入
    TABLES[16]="ST_GAIN_COIN" #金币产出
    TABLES[17]="ST_CONSUME_COIN" #金币消耗
    TABLES[18]="ST_GAIN_EXPLOIT" #功勋产出
    TABLES[19]="ST_CONSUME_EXPLOIT" #功勋消耗
    TABLES[20]="ST_GAIN_PRESTIGE" #声望产出
    TABLES[22]="ST_STRENGTHEN_SUIT" #装备强化
    TABLES[23]="ST_SYNTHESIS_SUI" #装备合成
    TABLES[25]="ST_SKILL_LEVELUP" #技能升级
    TABLES[26]="ST_DOWER_LEVELUP" #天赋升级
    TABLES[30]="ST_DAILY_TASK_INFO" #每日任务数据
    TABLES[31]="ST_TASK_RECORD" #每日任务刷新
    TABLES[33]="ST_MULTIPEOPLE_INSTANCE" #多人副本
    TABLES[34]="ST_RESET_INSTANCE" #副本重置
    TABLES[35]="ST_GAIN_CARD" #卡牌产出
    TABLES[37]="ST_GYMKHANA" #竞技场
    TABLES[38]="ST_AMPHITHEATER" #斗技场
    TABLES[39]="ST_IMPERIAL_CITY_GUARD" #王城守卫
    TABLES[41]="ST_GAIN_GEM" #纹章产出
    TABLES[42]="ST_RECAST_GEM" #纹章重铸
    TABLES[43]="ST_EXCHANGE_GEM" #精华消耗
    TABLES[44]="ST_INLAY_GEM" #纹章镶嵌
    TABLES[45]="ST_MANOR_REWARD" #庄园奖励
    TABLES[46]="ST_REFRESH_MANOR" #庄园刷新
    TABLES[47]="ST_REFRESH_EXPLORATION" #云游刷新
    TABLES[49]="ST_EXPLORATION_REWARD" #云游奖励
    TABLES[51]="ST_GAIN_FROM_FINDING_SPIRIT" #寻灵产出
    TABLES[52]="ST_GAIN_PSIONIC" #灵能产出
    TABLES[53]="ST_CONSUME_PSIONIC" #灵能消耗
    TABLES[54]="ST_RECORD_SS_EXCHANGING" #灵石兑换纪录
    TABLES[56]="ST_DAILY_TARGET" #每日目标
    TABLES[59]="ST_DEAD_RECORD" #死亡记录
    TABLES[60]="ST_REVIVING_RECORD" #复活记录
    TABLES[61]="ST_TASK_INFO" #任务信息数据
    TABLES[62]="ST_JOIN_INSTANCE" #进入副本
    TABLES[63]="ST_LEAVE_INSTANCE" #离开副本
    TABLES[64]="ST_COMPLETE_INSTANCE" #完成副本
    TABLES[65]="ST_ITEM_COMPOSE_CONSUME" #兑换中物品消耗
    TABLES[66]="ST_ITEM_COMPOSE_GAIN" #兑换中物品产出
    TABLES[67]="ST_ADD_EXP" #经验产出
    TABLES[69]="ST_AUTOBATTLE" #副本挂机
    TABLES[79]="ST_LUCKY_OCT" #运营活动
    TABLES[1100]="ST_ITEM_GIAN" #物品产出
    TABLES[1101]="ST_ITEM_CONSUME" #物品消耗
}

/Statistics/ { 
	table=$6
	if (table in TABLES){
	    file=TABLES[table]
            name1=$8
            name2=strftime("%Y-%m-%d %H:%M:%S",$8)
            gsub(name1,name2,$8)
            gsub(/^.*Statistics\] [0-9]*[ ]* /,"")
            name3=$2
            gsub(/ /,",")
            gsub(name3",",name3" ")
	    print $0>>file
        }
	else if (table == 13){
	    file="ST_ROLE_LOGOUT_INFO"
            name1=$8
            name11=$14
            name2=strftime("%Y-%m-%d %H:%M:%S",$8)
            name22=strftime("%Y-%m-%d %H:%M:%S",$14)
            gsub(name1,name2,$8)
            gsub(name11,name22,$14)
            gsub(/^.*Statistics\] [0-9]*[ ]* /,"")
            name3=$2
            gsub(/ /,",")
            gsub(name3",",name3" ")
	    print $0 >>file
	    
        }
}

END {
    system("mysqlimport --local --fields-terminated-by=',' ahero ST_*")
}
