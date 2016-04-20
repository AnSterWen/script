-- MySQL dump 10.13  Distrib 5.5.37, for debian-linux-gnu (x86_64)
--
-- Host: 10.100.23.32    Database: RU
-- ------------------------------------------------------
-- Server version	5.6.12-log

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Current Database: `RU`
--

CREATE DATABASE /*!32312 IF NOT EXISTS*/ `RU` /*!40100 DEFAULT CHARACTER SET utf8 */;

USE `RU`;

--
-- Table structure for table `t_ru_activity`
--

DROP TABLE IF EXISTS `t_ru_activity`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `t_ru_activity` (
  `userid` bigint(20) unsigned NOT NULL DEFAULT '0',
  `reg_tm` int(10) NOT NULL DEFAULT '0',
  `zone_id` int(10) unsigned NOT NULL DEFAULT '0',
  `activity_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '活动id',
  `activity_buff` varchar(500) NOT NULL DEFAULT '' COMMENT '活动各个步骤的buff记录',
  `revc_reward_times` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '领取奖励次数',
  `dead_tm` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '失效时间',
  `modify_tm` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`userid`,`reg_tm`,`zone_id`,`activity_id`),
  KEY `k_1` (`userid`,`activity_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `t_ru_airank`
--

DROP TABLE IF EXISTS `t_ru_airank`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `t_ru_airank` (
  `userid` bigint(20) unsigned NOT NULL,
  `reg_tm` int(10) unsigned NOT NULL,
  `zone_id` int(10) unsigned NOT NULL,
  `rank` int(10) unsigned NOT NULL,
  `log` varchar(500) DEFAULT NULL,
  `accu_coin` int(10) unsigned NOT NULL DEFAULT '0',
  `accu_reputation` int(10) unsigned NOT NULL DEFAULT '0',
  `accu_times` int(10) unsigned NOT NULL DEFAULT '0',
  `accu_end_time` int(10) unsigned NOT NULL DEFAULT '0',
  UNIQUE KEY `userid` (`userid`,`reg_tm`,`zone_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `t_ru_attribute`
--

DROP TABLE IF EXISTS `t_ru_attribute`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `t_ru_attribute` (
  `userid` bigint(20) unsigned NOT NULL,
  `reg_tm` int(10) unsigned NOT NULL,
  `zone_id` int(10) unsigned NOT NULL,
  `attribute_id` int(10) unsigned NOT NULL,
  `attribute_value` int(10) unsigned NOT NULL,
  `dead_tm` int(10) unsigned NOT NULL,
  `modify_tm` int(10) unsigned NOT NULL,
  PRIMARY KEY (`userid`,`reg_tm`,`zone_id`,`attribute_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `t_ru_base`
--

DROP TABLE IF EXISTS `t_ru_base`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `t_ru_base` (
  `userid` bigint(20) unsigned NOT NULL,
  `reg_tm` int(10) unsigned NOT NULL,
  `type` int(10) unsigned NOT NULL,
  `zone_id` int(10) unsigned NOT NULL,
  `gender` int(10) unsigned NOT NULL,
  `name` char(20) NOT NULL,
  `last_login_tm` int(10) unsigned NOT NULL,
  `last_logout_tm` int(10) unsigned NOT NULL,
  `lv` int(10) unsigned NOT NULL,
  `exp` int(10) unsigned NOT NULL,
  PRIMARY KEY (`userid`,`reg_tm`,`zone_id`),
  UNIQUE KEY `name` (`zone_id`,`name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`pubs_ru_mng`@`%`*/ /*!50003 trigger globalID_trigger
 AFTER 
INSERT ON t_ru_base

FOR EACH ROW

BEGIN

insert ignore into t_ru_id(userid, reg_tm, zone_id) values(new.userid, new.reg_tm, new.zone_id);

END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

--
-- Table structure for table `t_ru_dailytask`
--

DROP TABLE IF EXISTS `t_ru_dailytask`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `t_ru_dailytask` (
  `userid` bigint(20) unsigned NOT NULL,
  `reg_tm` int(10) unsigned NOT NULL,
  `zone_id` int(10) unsigned NOT NULL,
  `daily_task_id` int(10) unsigned NOT NULL,
  `daily_task_status` int(11) NOT NULL,
  `dead_tm` int(10) unsigned NOT NULL,
  `modify_tm` int(10) unsigned NOT NULL,
  PRIMARY KEY (`userid`,`reg_tm`,`zone_id`,`daily_task_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `t_ru_del_player`
--

DROP TABLE IF EXISTS `t_ru_del_player`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `t_ru_del_player` (
  `userid` bigint(20) unsigned NOT NULL,
  `dflag` tinyint(1) DEFAULT NULL,
  `modify_tm` int(10) unsigned NOT NULL,
  PRIMARY KEY (`userid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `t_ru_diamondback`
--

DROP TABLE IF EXISTS `t_ru_diamondback`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `t_ru_diamondback` (
  `userid` bigint(20) unsigned NOT NULL,
  `reg_tm` int(10) unsigned NOT NULL,
  `zone_id` int(10) unsigned NOT NULL,
  `back_time` int(10) unsigned NOT NULL DEFAULT '0',
  `back_num` int(10) unsigned NOT NULL,
  `vip` int(10) unsigned NOT NULL,
  PRIMARY KEY (`userid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `t_ru_dnd`
--

DROP TABLE IF EXISTS `t_ru_dnd`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `t_ru_dnd` (
  `userid` bigint(20) unsigned NOT NULL,
  `reg_tm` int(10) unsigned NOT NULL,
  `zone_id` int(10) unsigned NOT NULL,
  `duserid` bigint(20) unsigned NOT NULL,
  `dreg_tm` int(10) unsigned NOT NULL,
  PRIMARY KEY (`userid`,`reg_tm`,`zone_id`,`duserid`,`dreg_tm`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `t_ru_enemy`
--

DROP TABLE IF EXISTS `t_ru_enemy`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `t_ru_enemy` (
  `userid` bigint(20) unsigned NOT NULL,
  `reg_tm` int(10) unsigned NOT NULL,
  `zone_id` int(10) unsigned NOT NULL,
  `euserid` bigint(20) unsigned NOT NULL,
  `ereg_tm` int(10) unsigned NOT NULL,
  `meet_tm` int(10) unsigned NOT NULL,
  `kill_num` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`userid`,`reg_tm`,`zone_id`,`euserid`,`ereg_tm`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `t_ru_fairy`
--

DROP TABLE IF EXISTS `t_ru_fairy`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `t_ru_fairy` (
  `userid` bigint(20) unsigned NOT NULL,
  `reg_tm` int(10) unsigned NOT NULL,
  `zone_id` int(10) unsigned NOT NULL,
  `fairy_pos` int(10) unsigned NOT NULL COMMENT '精灵位置',
  `fairy_id` int(10) unsigned NOT NULL COMMENT '精灵id',
  `fairy_lv` int(10) unsigned NOT NULL COMMENT '精灵等级',
  `fairy_grade` int(10) unsigned NOT NULL DEFAULT '1' COMMENT '精灵阶级',
  `fairy_status` int(10) unsigned NOT NULL COMMENT '精灵状态',
  `fairy_exp` int(10) unsigned NOT NULL COMMENT '精灵经验',
  `fairy_born_time` int(10) unsigned NOT NULL COMMENT '精灵获取时间',
  `fairy_get_way` int(10) unsigned NOT NULL COMMENT '精灵获取方式',
  `train_phy_atk` int(10) NOT NULL DEFAULT '0' COMMENT '精灵特训物攻增量',
  `train_mag_atk` int(10) NOT NULL DEFAULT '0' COMMENT '精灵特训魔攻增量',
  `train_ski_atk` int(10) NOT NULL DEFAULT '0' COMMENT '精灵特训技攻增量',
  `train_phy_def` int(10) NOT NULL DEFAULT '0' COMMENT '精灵特训物防增量',
  `train_mag_def` int(10) NOT NULL DEFAULT '0' COMMENT '精灵特训魔防增量',
  `train_ski_def` int(10) NOT NULL DEFAULT '0' COMMENT '精灵特训技防增量',
  `train_hp` int(10) NOT NULL DEFAULT '0' COMMENT '精灵特训生命值增量',
  `train_cost` int(10) NOT NULL DEFAULT '0' COMMENT '精灵特训消耗',
  PRIMARY KEY (`userid`,`reg_tm`,`zone_id`,`fairy_pos`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `t_ru_freeze_player`
--

DROP TABLE IF EXISTS `t_ru_freeze_player`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `t_ru_freeze_player` (
  `userid` bigint(20) unsigned NOT NULL,
  `reg_tm` int(10) unsigned NOT NULL,
  `zone_id` int(10) unsigned NOT NULL,
  `time` int(10) unsigned NOT NULL,
  `type` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`userid`,`reg_tm`,`zone_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `t_ru_friend`
--

DROP TABLE IF EXISTS `t_ru_friend`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `t_ru_friend` (
  `userid` bigint(20) unsigned NOT NULL,
  `reg_tm` int(10) unsigned NOT NULL,
  `zone_id` int(10) unsigned NOT NULL,
  `fuserid` bigint(20) unsigned NOT NULL,
  `freg_tm` int(10) unsigned NOT NULL,
  `meet_tm` int(10) unsigned NOT NULL,
  `modify_tm` int(10) unsigned NOT NULL,
  PRIMARY KEY (`userid`,`reg_tm`,`zone_id`,`fuserid`,`freg_tm`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `t_ru_gm`
--

DROP TABLE IF EXISTS `t_ru_gm`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `t_ru_gm` (
  `userid` bigint(20) unsigned NOT NULL,
  `reg_tm` int(10) unsigned NOT NULL,
  `zone_id` int(10) unsigned NOT NULL,
  `time` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`userid`,`reg_tm`,`zone_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `t_ru_id`
--

DROP TABLE IF EXISTS `t_ru_id`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `t_ru_id` (
  `userid` bigint(20) unsigned NOT NULL,
  `reg_tm` int(10) unsigned NOT NULL,
  `zone_id` int(10) unsigned NOT NULL,
  `global_userid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`userid`,`reg_tm`,`zone_id`),
  UNIQUE KEY `global_userid_UNIQUE` (`global_userid`)
) ENGINE=MyISAM AUTO_INCREMENT=1488 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `t_ru_instance`
--

DROP TABLE IF EXISTS `t_ru_instance`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `t_ru_instance` (
  `userid` bigint(20) unsigned NOT NULL,
  `reg_tm` int(10) unsigned NOT NULL,
  `zone_id` int(10) unsigned NOT NULL,
  `instance_id` int(10) unsigned NOT NULL,
  `star` int(10) unsigned NOT NULL,
  `can_enter_flag` int(10) unsigned NOT NULL DEFAULT '0',
  `refresh_times` int(10) unsigned NOT NULL DEFAULT '0',
  `dead_tm` int(10) unsigned NOT NULL DEFAULT '0',
  `modify_tm` int(10) unsigned NOT NULL,
  `btl_times` int(10) unsigned NOT NULL DEFAULT '0',
  `btl_total` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`userid`,`reg_tm`,`zone_id`,`instance_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `t_ru_item`
--

DROP TABLE IF EXISTS `t_ru_item`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `t_ru_item` (
  `userid` bigint(20) unsigned NOT NULL,
  `reg_tm` int(10) unsigned NOT NULL,
  `zone_id` int(10) unsigned NOT NULL,
  `pos` int(10) unsigned NOT NULL,
  `item_id` int(10) unsigned NOT NULL,
  `item_level` int(10) unsigned NOT NULL,
  `item_num` int(10) unsigned NOT NULL,
  `modify_tm` int(10) unsigned NOT NULL,
  PRIMARY KEY (`userid`,`reg_tm`,`zone_id`,`pos`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `t_ru_kakao_attr`
--

DROP TABLE IF EXISTS `t_ru_kakao_attr`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `t_ru_kakao_attr` (
  `uid` int(10) unsigned NOT NULL,
  `type` int(10) unsigned NOT NULL,
  `count` int(10) unsigned NOT NULL,
  `expire_time` int(10) unsigned NOT NULL,
  `mod_time` int(10) unsigned NOT NULL,
  PRIMARY KEY (`uid`,`type`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `t_ru_kakao_cd`
--

DROP TABLE IF EXISTS `t_ru_kakao_cd`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `t_ru_kakao_cd` (
  `userid` bigint(20) unsigned NOT NULL,
  `type` int(10) unsigned NOT NULL,
  `accepter` bigint(20) unsigned NOT NULL,
  `count` int(10) unsigned NOT NULL,
  `start_time` int(10) unsigned NOT NULL,
  `expire_time` int(10) unsigned NOT NULL,
  PRIMARY KEY (`userid`,`type`,`accepter`,`count`,`start_time`,`expire_time`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `t_ru_kakao_friend`
--

DROP TABLE IF EXISTS `t_ru_kakao_friend`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `t_ru_kakao_friend` (
  `userid` bigint(10) unsigned NOT NULL,
  `reg` int(10) unsigned NOT NULL,
  `zone_id` int(10) unsigned NOT NULL,
  `fuserid` bigint(10) unsigned NOT NULL,
  `freg` int(10) unsigned NOT NULL,
  `type` int(10) unsigned NOT NULL,
  PRIMARY KEY (`userid`,`reg`,`zone_id`,`fuserid`,`freg`,`type`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `t_ru_lastlogin`
--

DROP TABLE IF EXISTS `t_ru_lastlogin`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `t_ru_lastlogin` (
  `userid` bigint(20) NOT NULL,
  `zone_id` int(11) DEFAULT NULL,
  `modify_tm` int(11) DEFAULT NULL,
  PRIMARY KEY (`userid`),
  UNIQUE KEY `userid_UNIQUE` (`userid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `t_ru_mail`
--

DROP TABLE IF EXISTS `t_ru_mail`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `t_ru_mail` (
  `mail_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(100) DEFAULT NULL,
  `from_user` varchar(100) DEFAULT NULL,
  `attach` varchar(250) DEFAULT NULL,
  `content` varchar(2000) DEFAULT NULL,
  `from_tm` int(10) DEFAULT '0',
  PRIMARY KEY (`mail_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `t_ru_mail_relation`
--

DROP TABLE IF EXISTS `t_ru_mail_relation`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `t_ru_mail_relation` (
  `userid` bigint(20) unsigned NOT NULL,
  `reg_tm` int(10) unsigned NOT NULL,
  `zone_id` int(10) unsigned NOT NULL,
  `mail_id` int(10) unsigned NOT NULL,
  `hasget` tinyint(1) DEFAULT '0',
  `hasread` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`userid`,`reg_tm`,`zone_id`,`mail_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `t_ru_new_mail`
--

DROP TABLE IF EXISTS `t_ru_new_mail`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `t_ru_new_mail` (
  `mail_id` bigint(20) unsigned NOT NULL,
  `zone_id` int(10) unsigned NOT NULL DEFAULT '0',
  `title` varchar(100) NOT NULL DEFAULT '',
  `come_from` varchar(100) NOT NULL DEFAULT '',
  `attachment` varchar(400) NOT NULL DEFAULT '',
  `content` varchar(2000) NOT NULL DEFAULT '',
  PRIMARY KEY (`mail_id`,`zone_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `t_ru_note_read_count`
--

DROP TABLE IF EXISTS `t_ru_note_read_count`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `t_ru_note_read_count` (
  `userid` bigint(20) unsigned NOT NULL,
  `count` int(10) unsigned DEFAULT '0',
  `last_tm` int(10) DEFAULT '0',
  `ann_id` int(10) DEFAULT '0',
  PRIMARY KEY (`userid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `t_ru_recruit`
--

DROP TABLE IF EXISTS `t_ru_recruit`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `t_ru_recruit` (
  `userid` bigint(20) unsigned NOT NULL,
  `award_id` int(10) unsigned NOT NULL,
  `award_status` int(11) NOT NULL,
  `award_tm` int(11) NOT NULL,
  PRIMARY KEY (`userid`,`award_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `t_ru_recruit_friend`
--

DROP TABLE IF EXISTS `t_ru_recruit_friend`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `t_ru_recruit_friend` (
  `userid` bigint(20) unsigned NOT NULL,
  `fuserid` bigint(20) unsigned NOT NULL,
  `add_tm` int(10) DEFAULT NULL,
  PRIMARY KEY (`userid`,`fuserid`),
  UNIQUE KEY `fuserid_UNIQUE` (`fuserid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `t_ru_server_attr`
--

DROP TABLE IF EXISTS `t_ru_server_attr`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `t_ru_server_attr` (
  `zone_id` int(10) unsigned NOT NULL DEFAULT '0',
  `attribute_id` int(10) unsigned NOT NULL DEFAULT '0',
  `attribute_value` int(10) unsigned NOT NULL DEFAULT '0',
  `dead_tm` int(10) unsigned NOT NULL DEFAULT '0',
  `modify_tm` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`zone_id`,`attribute_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `t_ru_shared_attribute`
--

DROP TABLE IF EXISTS `t_ru_shared_attribute`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `t_ru_shared_attribute` (
  `userid` bigint(20) unsigned NOT NULL,
  `zone_id` int(10) unsigned NOT NULL DEFAULT '0',
  `attribute_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '同服共享数据id',
  `attribute_value` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '同服共享数据value',
  `dead_tm` int(10) unsigned NOT NULL DEFAULT '0',
  `modify_tm` int(10) unsigned NOT NULL,
  PRIMARY KEY (`userid`,`zone_id`,`attribute_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `t_ru_shopping`
--

DROP TABLE IF EXISTS `t_ru_shopping`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `t_ru_shopping` (
  `userid` bigint(20) unsigned NOT NULL,
  `reg_tm` int(10) unsigned NOT NULL,
  `zone_id` int(10) unsigned NOT NULL,
  `shopping_id` int(10) unsigned NOT NULL,
  `buy_times` int(10) unsigned NOT NULL,
  `dead_tm` int(10) unsigned NOT NULL,
  `modify_tm` int(10) unsigned NOT NULL,
  PRIMARY KEY (`userid`,`reg_tm`,`zone_id`,`shopping_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `t_ru_skills`
--

DROP TABLE IF EXISTS `t_ru_skills`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `t_ru_skills` (
  `userid` bigint(20) unsigned NOT NULL,
  `reg_tm` int(10) unsigned NOT NULL,
  `zone_id` int(10) unsigned NOT NULL,
  `skill_id` int(10) unsigned NOT NULL,
  `skill_level` int(10) unsigned NOT NULL,
  `last_modify` int(10) unsigned NOT NULL,
  PRIMARY KEY (`userid`,`reg_tm`,`zone_id`,`skill_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `t_ru_task`
--

DROP TABLE IF EXISTS `t_ru_task`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `t_ru_task` (
  `userid` bigint(20) unsigned NOT NULL,
  `reg_tm` int(10) unsigned NOT NULL,
  `zone_id` int(10) unsigned NOT NULL,
  `task_id` int(10) unsigned NOT NULL,
  `step_id` int(10) unsigned NOT NULL,
  `step_rate` int(10) unsigned NOT NULL,
  `modify_tm` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`userid`,`reg_tm`,`zone_id`,`task_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `t_ru_value`
--

DROP TABLE IF EXISTS `t_ru_value`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `t_ru_value` (
  `findkey` bigint(20) DEFAULT NULL,
  `value` int(10) unsigned NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`value`),
  UNIQUE KEY `key` (`findkey`)
) ENGINE=InnoDB AUTO_INCREMENT=4053828 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `t_ru_weapon`
--

DROP TABLE IF EXISTS `t_ru_weapon`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `t_ru_weapon` (
  `userid` bigint(20) unsigned NOT NULL,
  `reg_tm` int(10) unsigned NOT NULL,
  `zone_id` int(10) unsigned NOT NULL,
  `pos` int(10) unsigned NOT NULL,
  `item_id` int(10) unsigned NOT NULL,
  `item_level` int(10) unsigned NOT NULL,
  `holes_buff` varchar(150) NOT NULL,
  `modify_tm` int(10) unsigned NOT NULL,
  PRIMARY KEY (`userid`,`reg_tm`,`zone_id`,`pos`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2014-11-03 15:00:35
