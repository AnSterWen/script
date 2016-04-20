CREATE DATABASE  IF NOT EXISTS `ahero` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `ahero`;
-- MySQL dump 10.13  Distrib 5.6.13, for Win32 (x86)
--
-- Host: localhost    Database: ahero
-- ------------------------------------------------------
-- Server version	5.0.51a-24+lenny2

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
-- Not dumping tablespaces as no INFORMATION_SCHEMA.FILES table on this server
--

--
-- Table structure for table `Attrib_Role`
--

DROP TABLE IF EXISTS `Attrib_Role`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Attrib_Role` (
  `zone_id` int(10) unsigned NOT NULL,
  `update_time` timestamp NOT NULL default CURRENT_TIMESTAMP,
  `userid` bigint(20) unsigned default NULL,
  `miminum` int(10) unsigned NOT NULL,
  `channel_id` int(10) unsigned NOT NULL,
  `role_name` char(50) default NULL,
  `level` int(10) unsigned default NULL,
  `exp` int(10) unsigned default NULL,
  `coin` int(10) unsigned default NULL,
  `exploit` int(10) unsigned default NULL,
  `diamond` int(10) unsigned default NULL,
  `prestige` int(10) unsigned default NULL,
  `reg_tm` int(10) unsigned default NULL,
  `type` int(10) unsigned default NULL,
  `vip_level` int(10) unsigned default NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `Info_Card`
--

DROP TABLE IF EXISTS `Info_Card`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Info_Card` (
  `zone_id` int(10) unsigned NOT NULL,
  `update_time` timestamp NOT NULL default CURRENT_TIMESTAMP,
  `userid` bigint(20) unsigned NOT NULL,
  `reg_tm` int(10) unsigned NOT NULL,
  `miminum` int(10) unsigned NOT NULL,
  `channel_id` int(10) unsigned NOT NULL,
  `role_name` char(50) default NULL,
  `item_id` int(10) unsigned default NULL,
  `item_level` int(10) unsigned default NULL,
  `item_num` int(10) unsigned default NULL,
  `item_pos` int(10) unsigned default NULL,
  `constell` int(10) unsigned default NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `Info_Equip`
--

DROP TABLE IF EXISTS `Info_Equip`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Info_Equip` (
  `zone_id` int(10) unsigned NOT NULL,
  `update_time` timestamp NOT NULL default CURRENT_TIMESTAMP,
  `userid` bigint(20) unsigned NOT NULL,
  `reg_tm` int(10) unsigned NOT NULL,
  `miminum` int(10) unsigned NOT NULL,
  `channel_id` int(10) unsigned NOT NULL,
  `role_name` char(50) default NULL,
  `item_id` int(10) unsigned default NULL,
  `item_level` int(10) unsigned default NULL,
  `pos` int(10) unsigned default NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `Info_Fairy`
--

DROP TABLE IF EXISTS `Info_Fairy`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Info_Fairy` (
  `zone_id` int(10) unsigned NOT NULL,
  `update_time` timestamp NOT NULL default CURRENT_TIMESTAMP,
  `userid` bigint(20) unsigned NOT NULL,
  `reg_tm` int(10) unsigned NOT NULL,
  `miminum` int(10) unsigned NOT NULL,
  `channel_id` int(10) unsigned NOT NULL,
  `role_name` char(50) default NULL,
  `item_num` int(10) unsigned default NULL,
  `item_id` int(10) unsigned default NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `Info_Gem`
--

DROP TABLE IF EXISTS `Info_Gem`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Info_Gem` (
  `zone_id` int(10) unsigned NOT NULL,
  `update_time` timestamp NOT NULL default CURRENT_TIMESTAMP,
  `userid` bigint(20) unsigned NOT NULL,
  `reg_tm` int(10) unsigned NOT NULL,
  `miminum` int(10) unsigned NOT NULL,
  `channel_id` int(10) unsigned NOT NULL,
  `role_name` char(50) default NULL,
  `item_id` int(10) unsigned default NULL,
  `item_level` int(10) unsigned default NULL,
  `item_num` int(10) unsigned default NULL,
  `item_pos` int(10) unsigned default NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `Info_SS`
--

DROP TABLE IF EXISTS `Info_SS`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Info_SS` (
  `zone_id` int(10) unsigned NOT NULL,
  `update_time` timestamp NOT NULL default CURRENT_TIMESTAMP,
  `userid` bigint(20) unsigned NOT NULL,
  `reg_tm` int(10) unsigned NOT NULL,
  `miminum` int(10) unsigned NOT NULL,
  `channel_id` int(10) unsigned NOT NULL,
  `role_name` char(50) default NULL,
  `item_id` int(10) unsigned default NULL,
  `item_level` int(10) unsigned default NULL,
  `item_num` int(10) unsigned default NULL,
  `item_pos` int(10) unsigned default NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `Info_Skill`
--

DROP TABLE IF EXISTS `Info_Skill`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Info_Skill` (
  `zone_id` int(10) unsigned NOT NULL,
  `update_time` timestamp NOT NULL default CURRENT_TIMESTAMP,
  `userid` bigint(20) unsigned NOT NULL,
  `reg_tm` int(10) unsigned NOT NULL,
  `miminum` int(10) unsigned NOT NULL,
  `channel_id` int(10) unsigned NOT NULL,
  `role_name` char(50) default NULL,
  `skill_id` int(10) unsigned default NULL,
  `skill_level` int(10) unsigned default NULL,
  `state` int(10) unsigned default NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `Info_Talent`
--

DROP TABLE IF EXISTS `Info_Talent`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Info_Talent` (
  `zone_id` int(10) unsigned NOT NULL,
  `update_time` timestamp NOT NULL default CURRENT_TIMESTAMP,
  `userid` bigint(20) unsigned NOT NULL,
  `reg_tm` int(10) unsigned NOT NULL,
  `miminum` int(10) unsigned NOT NULL,
  `channel_id` int(10) unsigned NOT NULL,
  `role_name` char(50) default NULL,
  `attribute_id` int(10) unsigned default NULL,
  `attribute_value` int(10) unsigned default NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ST_ADD_EXP`
--

DROP TABLE IF EXISTS `ST_ADD_EXP`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ST_ADD_EXP` (
  `zone_id` int(10) unsigned NOT NULL,
  `time` timestamp NOT NULL default CURRENT_TIMESTAMP,
  `role_id` char(50) default NULL,
  `account_id` int(10) unsigned NOT NULL,
  `reg_tm` int(10) unsigned NOT NULL,
  `channel` int(11) NOT NULL,
  `vocation` int(10) unsigned NOT NULL,
  `output_count` int(10) unsigned NOT NULL,
  `output_channel` int(10) unsigned NOT NULL,
  `play_level` int(10) default NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ST_AMPHITHEATER`
--

DROP TABLE IF EXISTS `ST_AMPHITHEATER`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ST_AMPHITHEATER` (
  `zone_id` int(10) unsigned NOT NULL,
  `time` timestamp NOT NULL default CURRENT_TIMESTAMP,
  `role_id` char(50) default NULL,
  `account_id` int(10) unsigned NOT NULL,
  `reg_tm` int(10) unsigned NOT NULL,
  `channel` int(11) NOT NULL,
  `vocation` int(10) unsigned NOT NULL,
  `victory` int(10) unsigned NOT NULL,
  `play_level` int(10) default NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ST_AUTOBATTLE`
--

DROP TABLE IF EXISTS `ST_AUTOBATTLE`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ST_AUTOBATTLE` (
  `zone_id` int(10) unsigned NOT NULL,
  `time` timestamp NOT NULL default CURRENT_TIMESTAMP,
  `role_id` char(50) default NULL,
  `account_id` int(10) unsigned NOT NULL,
  `reg_tm` int(10) unsigned NOT NULL,
  `channel` int(11) NOT NULL,
  `vocation` int(10) unsigned NOT NULL,
  `instance_id` int(10) unsigned NOT NULL,
  `finished_loop` int(10) unsigned NOT NULL,
  `play_level` int(10) default NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ST_COMPLETE_INSTANCE`
--

DROP TABLE IF EXISTS `ST_COMPLETE_INSTANCE`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ST_COMPLETE_INSTANCE` (
  `zone_id` int(10) unsigned NOT NULL,
  `time` timestamp NOT NULL default CURRENT_TIMESTAMP,
  `role_id` char(50) default NULL,
  `account_id` int(10) unsigned NOT NULL,
  `reg_tm` int(10) unsigned NOT NULL,
  `channel` int(11) NOT NULL,
  `vocation` int(10) unsigned NOT NULL,
  `instance_id` int(11) NOT NULL,
  `instance_type` int(11) NOT NULL,
  `stars` int(10) unsigned NOT NULL,
  `play_level` int(10) default NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ST_CONSUME_COIN`
--

DROP TABLE IF EXISTS `ST_CONSUME_COIN`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ST_CONSUME_COIN` (
  `zone_id` int(10) unsigned NOT NULL,
  `time` timestamp NOT NULL default CURRENT_TIMESTAMP,
  `role_id` char(50) default NULL,
  `account_id` int(10) unsigned NOT NULL,
  `reg_tm` int(10) unsigned NOT NULL,
  `channel` int(11) NOT NULL,
  `vocation` int(10) unsigned NOT NULL,
  `consume_account` int(10) unsigned NOT NULL,
  `output_channel` int(10) unsigned NOT NULL,
  `player_level` int(10) default NULL,
  KEY `account_id` (`account_id`,`consume_account`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ST_CONSUME_DIAMOND`
--

DROP TABLE IF EXISTS `ST_CONSUME_DIAMOND`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ST_CONSUME_DIAMOND` (
  `zone_id` int(10) unsigned NOT NULL,
  `time` timestamp NOT NULL default CURRENT_TIMESTAMP,
  `role_id` char(50) default NULL,
  `account_id` int(10) unsigned NOT NULL,
  `reg_tm` int(10) unsigned NOT NULL,
  `channel` int(11) NOT NULL,
  `vocation` int(10) unsigned NOT NULL,
  `consume_account` int(10) unsigned NOT NULL,
  `output_channel` int(10) unsigned NOT NULL,
  `play_level` int(10) default NULL,
  KEY `account_id` (`account_id`,`consume_account`),
  KEY `player_key` (`account_id`,`reg_tm`,`channel`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ST_CONSUME_EXPLOIT`
--

DROP TABLE IF EXISTS `ST_CONSUME_EXPLOIT`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ST_CONSUME_EXPLOIT` (
  `zone_id` int(10) unsigned NOT NULL,
  `time` timestamp NOT NULL default CURRENT_TIMESTAMP,
  `role_id` char(50) default NULL,
  `account_id` int(10) unsigned NOT NULL,
  `reg_tm` int(10) unsigned NOT NULL,
  `channel` int(11) NOT NULL,
  `vocation` int(10) unsigned NOT NULL,
  `consume_account` int(10) unsigned NOT NULL,
  `output_channel` int(10) unsigned NOT NULL,
  `play_level` int(10) default NULL,
  KEY `account_id` (`account_id`,`consume_account`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ST_CONSUME_PSIONIC`
--

DROP TABLE IF EXISTS `ST_CONSUME_PSIONIC`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ST_CONSUME_PSIONIC` (
  `zone_id` int(10) unsigned NOT NULL,
  `time` timestamp NOT NULL default CURRENT_TIMESTAMP,
  `role_id` char(50) default NULL,
  `account_id` int(10) unsigned NOT NULL,
  `reg_tm` int(10) unsigned NOT NULL,
  `channel` int(11) NOT NULL,
  `vocation` int(10) unsigned NOT NULL,
  `ss_name` int(10) unsigned NOT NULL,
  `target_level` int(10) unsigned NOT NULL,
  `count` int(10) unsigned NOT NULL,
  `play_level` int(10) default NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ST_DAILY_ROLE_PROPERTIES`
--

DROP TABLE IF EXISTS `ST_DAILY_ROLE_PROPERTIES`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ST_DAILY_ROLE_PROPERTIES` (
  `zone_id` int(10) unsigned NOT NULL,
  `time` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  `role_id` char(50) default NULL,
  `account_id` int(10) unsigned NOT NULL,
  `channel` int(11) NOT NULL,
  `vocation` int(10) unsigned NOT NULL,
  `exp` int(10) unsigned NOT NULL,
  `coin` int(10) unsigned NOT NULL,
  `exploit` int(10) unsigned NOT NULL,
  `dimond` int(10) unsigned NOT NULL,
  `prestige` int(10) unsigned NOT NULL,
  `reg_time` int(10) unsigned NOT NULL,
  `vip_level` int(10) unsigned NOT NULL,
  `play_level` int(10) unsigned default NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ST_DAILY_TARGET`
--

DROP TABLE IF EXISTS `ST_DAILY_TARGET`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ST_DAILY_TARGET` (
  `zone_id` int(10) unsigned NOT NULL,
  `time` timestamp NOT NULL default CURRENT_TIMESTAMP,
  `role_id` char(50) default NULL,
  `account_id` int(10) unsigned NOT NULL,
  `reg_tm` int(10) unsigned NOT NULL,
  `channel` int(11) NOT NULL,
  `vocation` int(10) unsigned NOT NULL,
  `target_name` int(10) unsigned NOT NULL,
  `level` int(10) unsigned NOT NULL,
  `play_level` int(10) default NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ST_DAILY_TASK_INFO`
--

DROP TABLE IF EXISTS `ST_DAILY_TASK_INFO`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ST_DAILY_TASK_INFO` (
  `zone_id` int(10) unsigned NOT NULL,
  `time` timestamp NOT NULL default CURRENT_TIMESTAMP,
  `role_id` char(50) default NULL,
  `account_id` int(10) unsigned NOT NULL,
  `reg_tm` int(10) unsigned NOT NULL,
  `channel` int(11) NOT NULL,
  `vocation` int(10) unsigned NOT NULL,
  `state` int(11) NOT NULL,
  `task_id` int(11) NOT NULL,
  `task_level` int(11) NOT NULL,
  `play_level` int(10) default NULL,
  KEY `account_id` (`account_id`,`vocation`,`task_level`,`state`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ST_DEAD_RECORD`
--

DROP TABLE IF EXISTS `ST_DEAD_RECORD`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ST_DEAD_RECORD` (
  `zone_id` int(10) unsigned NOT NULL,
  `time` timestamp NOT NULL default CURRENT_TIMESTAMP,
  `role_id` char(50) default NULL,
  `account_id` int(10) unsigned NOT NULL,
  `reg_tm` int(10) unsigned NOT NULL,
  `channel` int(11) NOT NULL,
  `vocation` int(10) unsigned NOT NULL,
  `instance_id` int(11) NOT NULL,
  `instance_type` int(11) NOT NULL,
  `level` int(10) unsigned NOT NULL,
  KEY `user_key` (`account_id`,`reg_tm`,`channel`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ST_DOWER_LEVELUP`
--

DROP TABLE IF EXISTS `ST_DOWER_LEVELUP`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ST_DOWER_LEVELUP` (
  `zone_id` int(10) unsigned NOT NULL,
  `time` timestamp NOT NULL default CURRENT_TIMESTAMP,
  `role_id` char(50) default NULL,
  `account_id` int(10) unsigned NOT NULL,
  `reg_tm` int(10) unsigned NOT NULL,
  `channel` int(11) NOT NULL,
  `vocation` int(10) unsigned NOT NULL,
  `dower_id` int(10) unsigned NOT NULL,
  `dower_level` int(10) unsigned NOT NULL,
  `play_level` int(10) default NULL,
  KEY `player_key` (`account_id`,`reg_tm`,`channel`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ST_EXCHANGE_GEM`
--

DROP TABLE IF EXISTS `ST_EXCHANGE_GEM`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ST_EXCHANGE_GEM` (
  `zone_id` int(10) unsigned NOT NULL,
  `time` timestamp NOT NULL default CURRENT_TIMESTAMP,
  `role_id` char(50) default NULL,
  `account_id` int(10) unsigned NOT NULL,
  `reg_tm` int(10) unsigned NOT NULL,
  `channel` int(11) NOT NULL,
  `vocation` int(10) unsigned NOT NULL,
  `consume_count` int(10) unsigned NOT NULL,
  `consume_channel` int(10) unsigned NOT NULL,
  `play_level` int(10) default NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ST_EXPLORATION_REWARD`
--

DROP TABLE IF EXISTS `ST_EXPLORATION_REWARD`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ST_EXPLORATION_REWARD` (
  `zone_id` int(10) unsigned NOT NULL,
  `time` timestamp NOT NULL default CURRENT_TIMESTAMP,
  `role_id` char(50) default NULL,
  `account_id` int(10) unsigned NOT NULL,
  `reg_tm` int(10) unsigned NOT NULL,
  `channel` int(11) NOT NULL,
  `vocation` int(10) unsigned NOT NULL,
  `map_id` int(10) unsigned default NULL,
  `play_level` int(10) default NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ST_GAIN_CARD`
--

DROP TABLE IF EXISTS `ST_GAIN_CARD`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ST_GAIN_CARD` (
  `zone_id` int(10) unsigned NOT NULL,
  `time` timestamp NOT NULL default CURRENT_TIMESTAMP,
  `role_id` char(50) default NULL,
  `account_id` int(10) unsigned NOT NULL,
  `reg_tm` int(10) unsigned NOT NULL,
  `channel` int(11) NOT NULL,
  `vocation` int(10) unsigned NOT NULL,
  `card_id` int(10) unsigned NOT NULL,
  `card_count` int(10) unsigned NOT NULL,
  `output_channel` int(10) unsigned NOT NULL,
  `play_level` int(10) default NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ST_GAIN_COIN`
--

DROP TABLE IF EXISTS `ST_GAIN_COIN`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ST_GAIN_COIN` (
  `zone_id` int(10) unsigned NOT NULL,
  `time` timestamp NOT NULL default CURRENT_TIMESTAMP,
  `role_id` char(50) default NULL,
  `account_id` int(10) unsigned NOT NULL,
  `reg_tm` int(10) unsigned NOT NULL,
  `channel` int(11) NOT NULL,
  `vocation` int(10) unsigned NOT NULL,
  `output_account` int(10) unsigned NOT NULL,
  `output_channel` int(10) unsigned NOT NULL,
  `play_level` int(10) default NULL,
  KEY `account_id` (`account_id`,`output_account`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ST_GAIN_DIAMOND`
--

DROP TABLE IF EXISTS `ST_GAIN_DIAMOND`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ST_GAIN_DIAMOND` (
  `zone_id` int(10) unsigned NOT NULL,
  `time` timestamp NOT NULL default CURRENT_TIMESTAMP,
  `role_id` char(50) default NULL,
  `account_id` int(10) unsigned NOT NULL,
  `reg_tm` int(10) unsigned NOT NULL,
  `channel` int(11) NOT NULL,
  `vocation` int(10) unsigned NOT NULL,
  `output_account` int(10) unsigned NOT NULL,
  `output_channel` int(10) unsigned NOT NULL,
  `player_level` int(10) default NULL,
  KEY `account_id` (`account_id`,`output_account`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ST_GAIN_EXPLOIT`
--

DROP TABLE IF EXISTS `ST_GAIN_EXPLOIT`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ST_GAIN_EXPLOIT` (
  `zone_id` int(10) unsigned NOT NULL,
  `time` timestamp NOT NULL default CURRENT_TIMESTAMP,
  `role_id` char(50) default NULL,
  `account_id` int(10) unsigned NOT NULL,
  `reg_tm` int(10) unsigned NOT NULL,
  `channel` int(11) NOT NULL,
  `vocation` int(10) unsigned NOT NULL,
  `output_account` int(10) unsigned NOT NULL,
  `output_channel` int(10) unsigned NOT NULL,
  `play_level` int(10) default NULL,
  KEY `account_id` (`account_id`,`output_account`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ST_GAIN_FROM_FINDING_SPIRIT`
--

DROP TABLE IF EXISTS `ST_GAIN_FROM_FINDING_SPIRIT`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ST_GAIN_FROM_FINDING_SPIRIT` (
  `zone_id` int(10) unsigned NOT NULL,
  `time` timestamp NOT NULL default CURRENT_TIMESTAMP,
  `role_id` char(50) default NULL,
  `account_id` int(10) unsigned NOT NULL,
  `reg_tm` int(10) unsigned NOT NULL,
  `channel` int(11) NOT NULL,
  `vocation` int(10) unsigned NOT NULL,
  `item_id` int(10) unsigned NOT NULL,
  `item_count` int(10) unsigned NOT NULL,
  `play_level` int(10) default NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ST_GAIN_GEM`
--

DROP TABLE IF EXISTS `ST_GAIN_GEM`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ST_GAIN_GEM` (
  `zone_id` int(10) unsigned NOT NULL,
  `time` timestamp NOT NULL default CURRENT_TIMESTAMP,
  `role_id` char(50) default NULL,
  `account_id` int(10) unsigned NOT NULL,
  `reg_tm` int(10) unsigned NOT NULL,
  `channel` int(11) NOT NULL,
  `vocation` int(10) unsigned NOT NULL,
  `gem_id` int(10) unsigned NOT NULL,
  `gem_count` int(10) unsigned NOT NULL,
  `output_channel` int(10) unsigned NOT NULL,
  `play_level` int(10) default NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ST_GAIN_PRESTIGE`
--

DROP TABLE IF EXISTS `ST_GAIN_PRESTIGE`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ST_GAIN_PRESTIGE` (
  `zone_id` int(10) unsigned NOT NULL,
  `time` timestamp NOT NULL default CURRENT_TIMESTAMP,
  `role_id` char(50) default NULL,
  `account_id` int(10) unsigned NOT NULL,
  `reg_tm` int(10) unsigned NOT NULL,
  `channel` int(11) NOT NULL,
  `vocation` int(10) unsigned NOT NULL,
  `output_account` int(10) unsigned NOT NULL,
  `output_channel` int(10) unsigned NOT NULL,
  `play_level` int(10) default NULL,
  KEY `account_id` (`account_id`,`output_account`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ST_GAIN_PSIONIC`
--

DROP TABLE IF EXISTS `ST_GAIN_PSIONIC`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ST_GAIN_PSIONIC` (
  `zone_id` int(10) unsigned NOT NULL,
  `time` timestamp NOT NULL default CURRENT_TIMESTAMP,
  `role_id` char(50) default NULL,
  `account_id` int(10) unsigned NOT NULL,
  `reg_tm` int(10) unsigned NOT NULL,
  `channel` int(11) NOT NULL,
  `vocation` int(10) unsigned NOT NULL,
  `ss_id` int(10) unsigned NOT NULL,
  `ss_count` int(10) unsigned NOT NULL,
  `play_level` int(10) default NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ST_GYMKHANA`
--

DROP TABLE IF EXISTS `ST_GYMKHANA`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ST_GYMKHANA` (
  `zone_id` int(10) unsigned NOT NULL,
  `time` timestamp NOT NULL default CURRENT_TIMESTAMP,
  `role_id` char(50) default NULL,
  `account_id` int(10) unsigned NOT NULL,
  `reg_tm` int(10) unsigned NOT NULL,
  `channel` int(11) NOT NULL,
  `vocation` int(10) unsigned NOT NULL,
  `ai_name` char(50) default NULL,
  `play_level` int(10) default NULL,
  KEY `account_id` (`account_id`,`vocation`,`ai_name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ST_IMPERIAL_CITY_GUARD`
--

DROP TABLE IF EXISTS `ST_IMPERIAL_CITY_GUARD`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ST_IMPERIAL_CITY_GUARD` (
  `zone_id` int(10) unsigned NOT NULL,
  `time` timestamp NOT NULL default CURRENT_TIMESTAMP,
  `role_id` char(50) default NULL,
  `account_id` int(10) unsigned NOT NULL,
  `reg_tm` int(10) unsigned NOT NULL,
  `channel` int(11) NOT NULL,
  `vocation` int(10) unsigned NOT NULL,
  `play_level` int(10) default NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ST_INLAY_GEM`
--

DROP TABLE IF EXISTS `ST_INLAY_GEM`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ST_INLAY_GEM` (
  `zone_id` int(10) unsigned NOT NULL,
  `time` timestamp NOT NULL default CURRENT_TIMESTAMP,
  `role_id` char(50) default NULL,
  `account_id` int(10) unsigned NOT NULL,
  `reg_tm` int(10) unsigned NOT NULL,
  `channel` int(11) NOT NULL,
  `vocation` int(10) unsigned NOT NULL,
  `equip_id` int(10) unsigned NOT NULL,
  `equip_level` int(10) unsigned NOT NULL,
  `gem_id` int(10) unsigned NOT NULL,
  `gem_count` int(10) unsigned NOT NULL,
  `play_level` int(10) default NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ST_ITEM_COMPOSE_CONSUME`
--

DROP TABLE IF EXISTS `ST_ITEM_COMPOSE_CONSUME`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ST_ITEM_COMPOSE_CONSUME` (
  `zone_id` int(10) unsigned NOT NULL,
  `time` timestamp NOT NULL default CURRENT_TIMESTAMP,
  `role_id` char(50) default NULL,
  `account_id` int(10) unsigned NOT NULL,
  `reg_tm` int(10) unsigned NOT NULL,
  `channel` int(11) NOT NULL,
  `vocation` int(10) unsigned NOT NULL,
  `item_id` int(10) unsigned NOT NULL,
  `consume_count` int(10) unsigned NOT NULL,
  `consume_channel` int(10) unsigned NOT NULL,
  `play_level` int(10) default NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ST_ITEM_COMPOSE_GAIN`
--

DROP TABLE IF EXISTS `ST_ITEM_COMPOSE_GAIN`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ST_ITEM_COMPOSE_GAIN` (
  `zone_id` int(10) unsigned NOT NULL,
  `time` timestamp NOT NULL default CURRENT_TIMESTAMP,
  `role_id` char(50) default NULL,
  `account_id` int(10) unsigned NOT NULL,
  `reg_tm` int(10) unsigned NOT NULL,
  `channel` int(11) NOT NULL,
  `vocation` int(10) unsigned NOT NULL,
  `item_id` int(10) unsigned NOT NULL,
  `output_count` int(10) unsigned NOT NULL,
  `output_channel` int(10) unsigned NOT NULL,
  `play_level` int(10) default NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ST_ITEM_CONSUME`
--

DROP TABLE IF EXISTS `ST_ITEM_CONSUME`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ST_ITEM_CONSUME` (
  `zone_id` int(10) unsigned NOT NULL,
  `time` timestamp NOT NULL default CURRENT_TIMESTAMP,
  `role_id` char(50) default NULL,
  `account_id` int(10) unsigned NOT NULL,
  `reg_tm` int(10) unsigned NOT NULL,
  `channel` int(11) NOT NULL,
  `vocation` int(10) unsigned NOT NULL,
  `item_type` int(10) unsigned NOT NULL,
  `item_id` int(10) unsigned NOT NULL,
  `consume_count` int(10) unsigned NOT NULL,
  `player_level` int(10) unsigned NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ST_ITEM_GIAN`
--

DROP TABLE IF EXISTS `ST_ITEM_GIAN`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ST_ITEM_GIAN` (
  `zone_id` int(10) unsigned NOT NULL,
  `time` timestamp NOT NULL default CURRENT_TIMESTAMP,
  `role_id` char(50) default NULL,
  `account_id` int(10) unsigned NOT NULL,
  `reg_tm` int(10) unsigned NOT NULL,
  `channel` int(11) NOT NULL,
  `vocation` int(10) unsigned NOT NULL,
  `item_type` int(10) unsigned NOT NULL,
  `item_id` int(10) unsigned NOT NULL,
  `item_level` int(10) unsigned NOT NULL,
  `item_count` int(10) unsigned NOT NULL,
  `item_channel` int(10) unsigned NOT NULL,
  `player_level` int(10) unsigned NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ST_JOIN_INSTANCE`
--

DROP TABLE IF EXISTS `ST_JOIN_INSTANCE`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ST_JOIN_INSTANCE` (
  `zone_id` int(10) unsigned NOT NULL,
  `time` timestamp NOT NULL default CURRENT_TIMESTAMP,
  `role_id` char(50) default NULL,
  `account_id` int(10) unsigned NOT NULL,
  `reg_tm` int(10) unsigned NOT NULL,
  `channel` int(11) NOT NULL,
  `vocation` int(10) unsigned NOT NULL,
  `instance_id` int(11) NOT NULL,
  `instance_type` int(11) NOT NULL,
  `play_level` int(10) default NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ST_LEAVE_INSTANCE`
--

DROP TABLE IF EXISTS `ST_LEAVE_INSTANCE`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ST_LEAVE_INSTANCE` (
  `zone_id` int(10) unsigned NOT NULL,
  `time` timestamp NOT NULL default CURRENT_TIMESTAMP,
  `role_id` char(50) default NULL,
  `account_id` int(10) unsigned NOT NULL,
  `reg_tm` int(10) unsigned NOT NULL,
  `channel` int(11) NOT NULL,
  `vocation` int(10) unsigned NOT NULL,
  `instance_id` int(11) NOT NULL,
  `instance_type` int(11) NOT NULL,
  `stars` int(10) unsigned NOT NULL,
  `play_level` int(10) default NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ST_LUCKY_OCT`
--

DROP TABLE IF EXISTS `ST_LUCKY_OCT`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ST_LUCKY_OCT` (
  `zone_id` int(10) unsigned NOT NULL,
  `time` timestamp NOT NULL default CURRENT_TIMESTAMP,
  `role_id` char(50) default NULL,
  `account_id` int(10) unsigned NOT NULL,
  `reg_tm` int(10) unsigned NOT NULL,
  `channel` int(11) NOT NULL,
  `vocation` int(10) unsigned NOT NULL,
  `item_id` int(10) unsigned NOT NULL,
  `output_count` int(10) unsigned NOT NULL,
  `output_channel` int(10) unsigned NOT NULL,
  `player_level` int(10) default NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ST_MANOR_REWARD`
--

DROP TABLE IF EXISTS `ST_MANOR_REWARD`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ST_MANOR_REWARD` (
  `zone_id` int(10) unsigned NOT NULL,
  `time` timestamp NOT NULL default CURRENT_TIMESTAMP,
  `role_id` char(50) default NULL,
  `account_id` int(10) unsigned NOT NULL,
  `reg_tm` int(10) unsigned NOT NULL,
  `channel` int(11) NOT NULL,
  `vocation` int(10) unsigned NOT NULL,
  `manor_op` int(10) unsigned NOT NULL,
  `manor_grade` int(10) unsigned default NULL,
  `play_level` int(10) default NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ST_MULTIPEOPLE_INSTANCE`
--

DROP TABLE IF EXISTS `ST_MULTIPEOPLE_INSTANCE`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ST_MULTIPEOPLE_INSTANCE` (
  `zone_id` int(10) unsigned NOT NULL,
  `time` timestamp NOT NULL default CURRENT_TIMESTAMP,
  `role_id` char(50) default NULL,
  `account_id` int(10) unsigned NOT NULL,
  `reg_tm` int(10) unsigned NOT NULL,
  `channel` int(11) NOT NULL,
  `vocation` int(10) unsigned NOT NULL,
  `instance_id` int(10) unsigned NOT NULL,
  `play_level` int(10) default NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ST_RECAST_GEM`
--

DROP TABLE IF EXISTS `ST_RECAST_GEM`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ST_RECAST_GEM` (
  `zone_id` int(10) unsigned NOT NULL,
  `time` timestamp NOT NULL default CURRENT_TIMESTAMP,
  `role_id` char(50) default NULL,
  `account_id` int(10) unsigned NOT NULL,
  `reg_tm` int(10) unsigned NOT NULL,
  `channel` int(11) NOT NULL,
  `vocation` int(10) unsigned NOT NULL,
  `equip_id` int(10) unsigned NOT NULL,
  `equip_level` int(10) unsigned NOT NULL,
  `state` int(10) unsigned NOT NULL,
  `attrib_id` int(10) unsigned NOT NULL,
  `attrib_value` int(10) unsigned NOT NULL,
  `play_level` int(10) default NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ST_RECORD_SS_EXCHANGING`
--

DROP TABLE IF EXISTS `ST_RECORD_SS_EXCHANGING`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ST_RECORD_SS_EXCHANGING` (
  `zone_id` int(10) unsigned NOT NULL,
  `time` timestamp NOT NULL default CURRENT_TIMESTAMP,
  `role_id` char(50) default NULL,
  `account_id` int(10) unsigned NOT NULL,
  `reg_tm` int(10) unsigned NOT NULL,
  `channel` int(11) NOT NULL,
  `vocation` int(10) unsigned NOT NULL,
  `ss_id` int(10) unsigned NOT NULL,
  `play_level` int(10) default NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ST_REFRESH_EXPLORATION`
--

DROP TABLE IF EXISTS `ST_REFRESH_EXPLORATION`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ST_REFRESH_EXPLORATION` (
  `zone_id` int(10) unsigned NOT NULL,
  `time` timestamp NOT NULL default CURRENT_TIMESTAMP,
  `role_id` char(50) default NULL,
  `account_id` int(10) unsigned NOT NULL,
  `reg_tm` int(10) unsigned NOT NULL,
  `channel` int(11) NOT NULL,
  `vocation` int(10) unsigned NOT NULL,
  `play_level` int(10) default NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ST_REFRESH_MANOR`
--

DROP TABLE IF EXISTS `ST_REFRESH_MANOR`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ST_REFRESH_MANOR` (
  `zone_id` int(10) unsigned NOT NULL,
  `time` timestamp NOT NULL default CURRENT_TIMESTAMP,
  `role_id` char(50) default NULL,
  `account_id` int(10) unsigned NOT NULL,
  `reg_tm` int(10) unsigned NOT NULL,
  `channel` int(11) NOT NULL,
  `vocation` int(10) unsigned NOT NULL,
  `target_level` int(10) unsigned NOT NULL,
  `play_level` int(10) default NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ST_RESET_INSTANCE`
--

DROP TABLE IF EXISTS `ST_RESET_INSTANCE`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ST_RESET_INSTANCE` (
  `zone_id` int(10) unsigned NOT NULL,
  `time` timestamp NOT NULL default CURRENT_TIMESTAMP,
  `role_id` char(50) default NULL,
  `account_id` int(10) unsigned NOT NULL,
  `reg_tm` int(10) unsigned NOT NULL,
  `channel` int(11) NOT NULL,
  `vocation` int(10) unsigned NOT NULL,
  `instance_type` int(10) unsigned NOT NULL,
  `chapter_id` int(10) unsigned NOT NULL,
  `play_level` int(10) default NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ST_REVIVING_RECORD`
--

DROP TABLE IF EXISTS `ST_REVIVING_RECORD`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ST_REVIVING_RECORD` (
  `zone_id` int(10) unsigned NOT NULL,
  `time` timestamp NOT NULL default CURRENT_TIMESTAMP,
  `role_id` char(50) default NULL,
  `account_id` int(10) unsigned NOT NULL,
  `reg_tm` int(10) unsigned NOT NULL,
  `channel` int(11) NOT NULL,
  `vocation` int(10) unsigned NOT NULL,
  `revivings` int(10) unsigned NOT NULL,
  `play_level` int(10) default NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ST_ROLE_LEVELUP`
--

DROP TABLE IF EXISTS `ST_ROLE_LEVELUP`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ST_ROLE_LEVELUP` (
  `zone_id` int(10) unsigned NOT NULL,
  `time` timestamp NOT NULL default CURRENT_TIMESTAMP,
  `role_id` char(50) default NULL,
  `account_id` int(10) unsigned NOT NULL,
  `reg_tm` int(10) unsigned NOT NULL,
  `channel` int(11) NOT NULL,
  `vocation` int(10) unsigned NOT NULL,
  `target_level` int(10) unsigned NOT NULL,
  KEY `account_id` (`account_id`,`vocation`,`target_level`),
  KEY `account_id_2` (`account_id`,`target_level`),
  KEY `target_level_index` (`target_level`),
  KEY `time_index` (`time`),
  KEY `role_key_index` (`account_id`,`reg_tm`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ST_ROLE_LOGIN_INFO`
--

DROP TABLE IF EXISTS `ST_ROLE_LOGIN_INFO`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ST_ROLE_LOGIN_INFO` (
  `zone_id` int(10) unsigned NOT NULL,
  `login_time` timestamp NOT NULL default CURRENT_TIMESTAMP,
  `role_id` char(50) default NULL,
  `account_id` int(10) unsigned NOT NULL,
  `reg_tm` int(10) unsigned NOT NULL,
  `channel` int(11) NOT NULL,
  `vocation` int(10) unsigned NOT NULL,
  `play_level` int(10) default NULL,
  KEY `account_id` (`account_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ST_ROLE_LOGOUT_INFO`
--

DROP TABLE IF EXISTS `ST_ROLE_LOGOUT_INFO`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ST_ROLE_LOGOUT_INFO` (
  `zone_id` int(10) unsigned NOT NULL,
  `login_time` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  `role_id` char(50) default NULL,
  `account_id` int(10) unsigned NOT NULL,
  `reg_tm` int(10) unsigned NOT NULL,
  `channel` int(11) NOT NULL,
  `vocation` int(10) unsigned NOT NULL,
  `logout_time` timestamp NOT NULL default '0000-00-00 00:00:00',
  `online_time` int(10) unsigned NOT NULL,
  `play_level` int(10) default NULL,
  KEY `account_id` (`account_id`,`login_time`,`logout_time`,`online_time`),
  KEY `account_id_2` (`account_id`,`online_time`),
  KEY `role_key_index` (`account_id`,`reg_tm`),
  KEY `logout_time_index` (`logout_time`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ST_ROLE_LOGOUT_INFO1`
--

DROP TABLE IF EXISTS `ST_ROLE_LOGOUT_INFO1`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ST_ROLE_LOGOUT_INFO1` (
  `zone_id` int(10) unsigned NOT NULL,
  `login_time` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  `role_id` char(50) default NULL,
  `account_id` int(10) unsigned NOT NULL,
  `reg_tm` int(10) unsigned NOT NULL,
  `channel` int(11) NOT NULL,
  `vocation` int(10) unsigned NOT NULL,
  `logout_time` timestamp NOT NULL default '0000-00-00 00:00:00',
  `online_time` int(10) unsigned NOT NULL,
  `play_level` int(10) default NULL,
  KEY `account_id` (`account_id`,`login_time`,`logout_time`,`online_time`),
  KEY `account_id_2` (`account_id`,`online_time`),
  KEY `role_key_index` (`account_id`,`reg_tm`),
  KEY `logout_time_index` (`logout_time`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ST_ROLE_LOGOUT_INFO2`
--

DROP TABLE IF EXISTS `ST_ROLE_LOGOUT_INFO2`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ST_ROLE_LOGOUT_INFO2` (
  `rowNo` int(10) unsigned NOT NULL,
  `zone_id` int(10) unsigned NOT NULL,
  `login_time` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  `role_id` char(50) default NULL,
  `account_id` int(10) unsigned NOT NULL,
  `reg_tm` int(10) unsigned NOT NULL,
  `channel` int(11) NOT NULL,
  `vocation` int(10) unsigned NOT NULL,
  `logout_time` timestamp NOT NULL default '0000-00-00 00:00:00',
  `online_time` int(10) unsigned NOT NULL,
  `play_level` int(10) default NULL,
  KEY `account_id` (`account_id`,`login_time`,`logout_time`,`online_time`),
  KEY `account_id_2` (`account_id`,`online_time`),
  KEY `role_key_index` (`account_id`,`reg_tm`),
  KEY `logout_time_index` (`logout_time`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ST_ROLE_LOGOUT_INFO3`
--

DROP TABLE IF EXISTS `ST_ROLE_LOGOUT_INFO3`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ST_ROLE_LOGOUT_INFO3` (
  `rowNo` int(10) unsigned NOT NULL,
  `zone_id` int(10) unsigned NOT NULL,
  `login_time` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  `role_id` char(50) default NULL,
  `account_id` int(10) unsigned NOT NULL,
  `reg_tm` int(10) unsigned NOT NULL,
  `channel` int(11) NOT NULL,
  `vocation` int(10) unsigned NOT NULL,
  `logout_time` timestamp NOT NULL default '0000-00-00 00:00:00',
  `online_time` int(10) unsigned NOT NULL,
  `play_level` int(10) default NULL,
  KEY `account_id` (`account_id`,`login_time`,`logout_time`,`online_time`),
  KEY `account_id_2` (`account_id`,`online_time`),
  KEY `role_key_index` (`account_id`,`reg_tm`),
  KEY `logout_time_index` (`logout_time`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ST_ROLE_LOGOUT_INFO4`
--

DROP TABLE IF EXISTS `ST_ROLE_LOGOUT_INFO4`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ST_ROLE_LOGOUT_INFO4` (
  `zone_id` int(10) unsigned NOT NULL,
  `login_time` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  `role_id` char(50) default NULL,
  `account_id` int(10) unsigned NOT NULL,
  `reg_tm` int(10) unsigned NOT NULL,
  `channel` int(11) NOT NULL,
  `vocation` int(10) unsigned NOT NULL,
  `logout_time` timestamp NOT NULL default '0000-00-00 00:00:00',
  `online_time` int(10) unsigned NOT NULL,
  `play_level` int(10) default NULL,
  KEY `account_id` (`account_id`,`login_time`,`logout_time`,`online_time`),
  KEY `account_id_2` (`account_id`,`online_time`),
  KEY `role_key_index` (`account_id`,`reg_tm`),
  KEY `logout_time_index` (`logout_time`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ST_SKILL_INFO`
--

DROP TABLE IF EXISTS `ST_SKILL_INFO`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ST_SKILL_INFO` (
  `zone_id` int(10) unsigned NOT NULL,
  `time` timestamp NOT NULL default CURRENT_TIMESTAMP,
  `role_id` char(50) default NULL,
  `account_id` int(10) unsigned NOT NULL,
  `reg_tm` int(10) unsigned NOT NULL,
  `channel` int(11) NOT NULL,
  `vocation` int(10) unsigned NOT NULL,
  `skill_id` int(10) unsigned NOT NULL,
  `skill_level` int(10) unsigned NOT NULL,
  `skill_state` int(10) unsigned NOT NULL,
  `play_level` int(10) default NULL,
  KEY `account_id` (`account_id`,`vocation`,`skill_id`,`skill_level`),
  KEY `account_id_2` (`account_id`,`skill_id`,`skill_level`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ST_SKILL_LEVELUP`
--

DROP TABLE IF EXISTS `ST_SKILL_LEVELUP`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ST_SKILL_LEVELUP` (
  `zone_id` int(10) unsigned NOT NULL,
  `time` timestamp NOT NULL default CURRENT_TIMESTAMP,
  `role_id` char(50) default NULL,
  `account_id` int(10) unsigned NOT NULL,
  `reg_tm` int(10) unsigned NOT NULL,
  `channel` int(11) NOT NULL,
  `vocation` int(10) unsigned NOT NULL,
  `skill_id` int(10) unsigned NOT NULL,
  `skill_level` int(10) unsigned NOT NULL,
  `play_level` int(10) default NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ST_SPIRIT_INFO`
--

DROP TABLE IF EXISTS `ST_SPIRIT_INFO`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ST_SPIRIT_INFO` (
  `zone_id` int(10) unsigned NOT NULL,
  `time` timestamp NOT NULL default CURRENT_TIMESTAMP,
  `role_id` char(50) default NULL,
  `account_id` int(10) unsigned NOT NULL,
  `reg_tm` int(10) unsigned NOT NULL,
  `channel` int(11) NOT NULL,
  `vocation` int(10) unsigned NOT NULL,
  `battle_state` int(10) unsigned NOT NULL,
  `fairy` int(10) unsigned NOT NULL,
  `play_level` int(10) default NULL,
  KEY `account_id` (`account_id`,`vocation`,`battle_state`,`fairy`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ST_STRENGTHEN_SUIT`
--

DROP TABLE IF EXISTS `ST_STRENGTHEN_SUIT`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ST_STRENGTHEN_SUIT` (
  `zone_id` int(10) unsigned NOT NULL,
  `time` timestamp NOT NULL default CURRENT_TIMESTAMP,
  `role_id` char(50) default NULL,
  `account_id` int(10) unsigned NOT NULL,
  `reg_tm` int(10) unsigned NOT NULL,
  `channel` int(11) NOT NULL,
  `vocation` int(10) unsigned NOT NULL,
  `equip_id` int(10) unsigned NOT NULL,
  `equip_level` int(10) unsigned NOT NULL,
  `play_level` int(10) default NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ST_SUIT_INFO`
--

DROP TABLE IF EXISTS `ST_SUIT_INFO`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ST_SUIT_INFO` (
  `zone_id` int(10) unsigned NOT NULL,
  `time` timestamp NOT NULL default CURRENT_TIMESTAMP,
  `role_id` char(50) default NULL,
  `account_id` int(10) unsigned NOT NULL,
  `reg_tm` int(10) unsigned NOT NULL,
  `channel` int(11) NOT NULL,
  `vocation` int(10) unsigned NOT NULL,
  `equip_id` int(10) unsigned NOT NULL,
  `equip_level` int(10) unsigned NOT NULL,
  `location` int(10) unsigned NOT NULL,
  `play_level` int(10) default NULL,
  KEY `account_id` (`account_id`,`equip_id`,`equip_level`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ST_SYNTHESIS_SUI`
--

DROP TABLE IF EXISTS `ST_SYNTHESIS_SUI`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ST_SYNTHESIS_SUI` (
  `zone_id` int(10) unsigned NOT NULL,
  `time` timestamp NOT NULL default CURRENT_TIMESTAMP,
  `role_id` char(50) default NULL,
  `account_id` int(10) unsigned NOT NULL,
  `reg_tm` int(10) unsigned NOT NULL,
  `channel` int(11) NOT NULL,
  `vocation` int(10) unsigned NOT NULL,
  `psui_id` int(10) unsigned NOT NULL,
  `psui_level` int(10) unsigned NOT NULL,
  `nsui_id` int(10) unsigned NOT NULL,
  `nsui_level` int(10) unsigned NOT NULL,
  `play_level` int(10) default NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ST_TASK_INFO`
--

DROP TABLE IF EXISTS `ST_TASK_INFO`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ST_TASK_INFO` (
  `zone_id` int(10) unsigned NOT NULL,
  `time` timestamp NOT NULL default CURRENT_TIMESTAMP,
  `role_id` char(50) default NULL,
  `account_id` int(10) unsigned NOT NULL,
  `reg_tm` int(10) unsigned NOT NULL,
  `channel` int(11) NOT NULL,
  `vocation` int(10) unsigned NOT NULL,
  `task_id` int(11) NOT NULL,
  `task_state` int(11) NOT NULL,
  `play_level` int(10) default NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ST_TASK_RECORD`
--

DROP TABLE IF EXISTS `ST_TASK_RECORD`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ST_TASK_RECORD` (
  `zone_id` int(10) unsigned NOT NULL,
  `time` timestamp NOT NULL default CURRENT_TIMESTAMP,
  `role_id` char(50) default NULL,
  `account_id` int(10) unsigned NOT NULL,
  `reg_tm` int(10) unsigned NOT NULL,
  `channel` int(11) NOT NULL,
  `vocation` int(10) unsigned NOT NULL,
  `refresh_type` int(10) unsigned NOT NULL,
  `play_level` int(10) default NULL,
  KEY `account_id` (`account_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ST_UNLOCK_SPIRIT`
--

DROP TABLE IF EXISTS `ST_UNLOCK_SPIRIT`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ST_UNLOCK_SPIRIT` (
  `zone_id` int(10) unsigned NOT NULL,
  `time` timestamp NOT NULL default CURRENT_TIMESTAMP,
  `role_id` char(50) default NULL,
  `account_id` int(10) unsigned NOT NULL,
  `reg_tm` int(10) unsigned NOT NULL,
  `channel` int(11) NOT NULL,
  `vocation` int(10) unsigned NOT NULL,
  `spirit_id` int(10) unsigned NOT NULL,
  `spirit_level` int(10) unsigned NOT NULL,
  `spirit_count` int(10) unsigned NOT NULL,
  `play_level` int(10) default NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ST_VIP_LEVELUP`
--

DROP TABLE IF EXISTS `ST_VIP_LEVELUP`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ST_VIP_LEVELUP` (
  `zone_id` int(10) unsigned NOT NULL,
  `time` timestamp NOT NULL default CURRENT_TIMESTAMP,
  `role_id` char(50) default NULL,
  `account_id` int(10) unsigned NOT NULL,
  `reg_tm` int(10) unsigned NOT NULL,
  `channel` int(11) NOT NULL,
  `vocation` int(10) unsigned NOT NULL,
  `target_level` int(10) unsigned NOT NULL,
  `play_level` int(10) default NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ahero_0121_1`
--

DROP TABLE IF EXISTS `ahero_0121_1`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ahero_0121_1` (
  `lg_day` varchar(10) default NULL,
  `output_channel` int(10) unsigned NOT NULL,
  `role_id` varbinary(22) NOT NULL default '',
  `item_id` int(10) unsigned NOT NULL,
  `output_count` int(10) unsigned NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ahero_1219_ck1`
--

DROP TABLE IF EXISTS `ahero_1219_ck1`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ahero_1219_ck1` (
  `lg_day` varchar(10) default NULL,
  `output_channel` int(10) unsigned NOT NULL,
  `role_id` varbinary(22) NOT NULL default '',
  `total` decimal(33,0) default NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ahero_1219_ck2`
--

DROP TABLE IF EXISTS `ahero_1219_ck2`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ahero_1219_ck2` (
  `lg_day` varchar(10) default NULL,
  `output_channel` int(10) unsigned NOT NULL,
  `role_id` varbinary(22) NOT NULL default '',
  `total` decimal(33,0) default NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ahero_1219_ck3`
--

DROP TABLE IF EXISTS `ahero_1219_ck3`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ahero_1219_ck3` (
  `lg_day` varchar(10) default NULL,
  `output_channel` int(10) unsigned NOT NULL,
  `role_id` varbinary(22) NOT NULL default '',
  `total` decimal(33,0) default NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ahero_1219_ck4`
--

DROP TABLE IF EXISTS `ahero_1219_ck4`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ahero_1219_ck4` (
  `lg_day` varchar(10) default NULL,
  `output_channel` int(10) unsigned NOT NULL,
  `role_id` varbinary(22) NOT NULL default '',
  `total` decimal(33,0) default NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ahero_1219_ck41`
--

DROP TABLE IF EXISTS `ahero_1219_ck41`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ahero_1219_ck41` (
  `lg_day` varchar(10) default NULL,
  `output_channel` int(10) unsigned NOT NULL,
  `role_id` varbinary(22) NOT NULL default '',
  `total` decimal(33,0) default NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ahero_1219_ck5`
--

DROP TABLE IF EXISTS `ahero_1219_ck5`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ahero_1219_ck5` (
  `role_id` varbinary(22) default NULL,
  `up_day` varchar(10) default NULL,
  `max_lev` int(10) unsigned default NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ahero_1219_ck6`
--

DROP TABLE IF EXISTS `ahero_1219_ck6`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ahero_1219_ck6` (
  `lg_day` varchar(10) default NULL,
  `output_channel` int(10) unsigned NOT NULL,
  `role_id` varbinary(22) NOT NULL default '',
  `total` decimal(33,0) default NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ahero_1219_ck61`
--

DROP TABLE IF EXISTS `ahero_1219_ck61`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ahero_1219_ck61` (
  `lg_day` varchar(10) default NULL,
  `output_channel` int(10) unsigned NOT NULL,
  `role_id` varbinary(22) NOT NULL default '',
  `total` decimal(33,0) default NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ahero_1219_ck7`
--

DROP TABLE IF EXISTS `ahero_1219_ck7`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ahero_1219_ck7` (
  `lg_day` varchar(10) default NULL,
  `output_channel` int(10) unsigned NOT NULL,
  `role_id` varbinary(22) NOT NULL default '',
  `item_id` int(10) unsigned NOT NULL,
  `output_count` int(10) unsigned NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ahero_1219_ck71`
--

DROP TABLE IF EXISTS `ahero_1219_ck71`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ahero_1219_ck71` (
  `lg_day` varchar(10) default NULL,
  `output_channel` int(10) unsigned NOT NULL,
  `role_id` varbinary(22) NOT NULL default '',
  `item_id` int(10) unsigned NOT NULL,
  `output_count` int(10) unsigned NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ahero_lc_120101`
--

DROP TABLE IF EXISTS `ahero_lc_120101`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ahero_lc_120101` (
  `zone_id` int(10) unsigned NOT NULL,
  `reg_day` varchar(10) default NULL,
  `lg_day` varchar(10) default NULL,
  `u_id` varbinary(23) NOT NULL default ''
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ahero_lc_120102`
--

DROP TABLE IF EXISTS `ahero_lc_120102`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ahero_lc_120102` (
  `zone_id` int(10) unsigned NOT NULL,
  `userid` bigint(20) unsigned default NULL,
  `role_name` char(50) default NULL,
  `u_id` varbinary(23) default NULL,
  `reg_day2` varchar(10) default NULL,
  `reg_day` varchar(10) default NULL,
  `max_lev` int(10) unsigned default NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ahero_lc_120103`
--

DROP TABLE IF EXISTS `ahero_lc_120103`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ahero_lc_120103` (
  `zone_id` int(10) unsigned NOT NULL,
  `reg_day` varchar(10) default NULL,
  `lg_day` varchar(10) default NULL,
  `u_id` varbinary(23) NOT NULL default '',
  `max_lev` int(10) unsigned default NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ahero_lc_120104`
--

DROP TABLE IF EXISTS `ahero_lc_120104`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ahero_lc_120104` (
  `zone_id` int(10) unsigned NOT NULL,
  `reg_day` varchar(10) default NULL,
  `lg_day` varchar(10) default NULL,
  `u_id` varbinary(23) NOT NULL default ''
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ahero_lc_120105`
--

DROP TABLE IF EXISTS `ahero_lc_120105`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ahero_lc_120105` (
  `zone_id` int(10) unsigned NOT NULL,
  `reg_day` varchar(10) default NULL,
  `lg_day` varchar(10) default NULL,
  `u_id` varbinary(23) NOT NULL default '',
  `max_lev` int(10) unsigned default NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ahero_ls_210`
--

DROP TABLE IF EXISTS `ahero_ls_210`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ahero_ls_210` (
  `userid` bigint(20) unsigned default NULL,
  `miminum` int(10) unsigned NOT NULL,
  `level` int(10) unsigned default NULL,
  `type` int(10) unsigned default NULL,
  `reg_tm` int(10) unsigned default NULL,
  `role_name` char(50) default NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ahero_ls_2nd1`
--

DROP TABLE IF EXISTS `ahero_ls_2nd1`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ahero_ls_2nd1` (
  `userid` bigint(20) unsigned default NULL,
  `miminum` int(10) unsigned NOT NULL,
  `level` int(10) unsigned default NULL,
  `type` int(10) unsigned default NULL,
  `reg_tm` int(10) unsigned default NULL,
  `role_name` char(50) default NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ahero_xz_140115`
--

DROP TABLE IF EXISTS `ahero_xz_140115`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ahero_xz_140115` (
  `zone_id` int(10) unsigned NOT NULL,
  `reg_day` varchar(10) default NULL,
  `lg_day` varchar(10) default NULL,
  `u_id` varbinary(23) NOT NULL default ''
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ahero_xz_140115_2`
--

DROP TABLE IF EXISTS `ahero_xz_140115_2`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ahero_xz_140115_2` (
  `zone_id` int(10) unsigned NOT NULL,
  `userid` bigint(20) unsigned default NULL,
  `role_name` char(50) default NULL,
  `u_id` varbinary(23) default NULL,
  `reg_day2` varchar(10) default NULL,
  `reg_day` varchar(10) default NULL,
  `max_lev` int(10) unsigned default NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ahero_xz_140115_3`
--

DROP TABLE IF EXISTS `ahero_xz_140115_3`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ahero_xz_140115_3` (
  `zone_id` int(10) unsigned NOT NULL,
  `reg_day` varchar(10) default NULL,
  `lg_day` varchar(10) default NULL,
  `u_id` varbinary(23) NOT NULL default '',
  `max_lev` int(10) unsigned default NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ahero_xz_140115_4`
--

DROP TABLE IF EXISTS `ahero_xz_140115_4`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ahero_xz_140115_4` (
  `zone_id` int(10) unsigned NOT NULL,
  `reg_day` varchar(10) default NULL,
  `lg_day` varchar(10) default NULL,
  `u_id` varbinary(23) NOT NULL default '',
  `max_lev` int(10) unsigned default NULL
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
  PRIMARY KEY  (`userid`,`reg_tm`,`zone_id`,`attribute_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
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
  `fairy_grade` int(10) unsigned NOT NULL default '1' COMMENT '精灵阶级',
  `fairy_status` int(10) unsigned NOT NULL COMMENT '精灵状态',
  `fairy_exp` int(10) unsigned NOT NULL COMMENT '精灵经验',
  `fairy_born_time` int(10) unsigned NOT NULL COMMENT '精灵获取时间',
  `fairy_get_way` int(10) unsigned NOT NULL COMMENT '精灵获取方式',
  `train_phy_atk` int(10) NOT NULL default '0' COMMENT '精灵特训物攻增量',
  `train_mag_atk` int(10) NOT NULL default '0' COMMENT '精灵特训魔攻增量',
  `train_ski_atk` int(10) NOT NULL default '0' COMMENT '精灵特训技攻增量',
  `train_phy_def` int(10) NOT NULL default '0' COMMENT '精灵特训物防增量',
  `train_mag_def` int(10) NOT NULL default '0' COMMENT '精灵特训魔防增量',
  `train_ski_def` int(10) NOT NULL default '0' COMMENT '精灵特训技防增量',
  `train_hp` int(10) NOT NULL default '0' COMMENT '精灵特训生命值增量',
  `train_cost` int(10) NOT NULL default '0' COMMENT '精灵特训消耗',
  PRIMARY KEY  (`userid`,`reg_tm`,`zone_id`,`fairy_pos`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `temp_lv`
--

DROP TABLE IF EXISTS `temp_lv`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `temp_lv` (
  `zone_id` int(10) NOT NULL default '0',
  `account_id` int(10) NOT NULL default '0',
  `reg_tm` int(10) NOT NULL default '0',
  `channel` int(10) NOT NULL default '0',
  `lv` int(10) NOT NULL default '0',
  `ftime` int(10) default NULL,
  `ttime` int(10) default NULL,
  PRIMARY KEY  (`zone_id`,`account_id`,`reg_tm`,`channel`,`lv`),
  KEY `index_ftime` (`ftime`),
  KEY `index_ttime` (`ttime`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2014-09-02 20:18:35
