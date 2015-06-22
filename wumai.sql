-- phpMyAdmin SQL Dump
-- version 4.0.10
-- http://www.phpmyadmin.net
--
-- 主机: localhost
-- 生成日期: 2014-12-23 17:11:23
-- 服务器版本: 5.1.69
-- PHP 版本: 5.2.17p1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- 数据库: `xksds`
--

-- --------------------------------------------------------

--
-- 表的结构 `wumai_admin`
--

CREATE TABLE IF NOT EXISTS `wumai_admin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(30) NOT NULL,
  `password` char(32) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- 转存表中的数据 `wumai_admin`
--

INSERT INTO `wumai_admin` (`id`, `username`, `password`) VALUES
(4, 'admin', 'admin123');

-- --------------------------------------------------------

--
-- 表的结构 `wumai_score`
--

CREATE TABLE IF NOT EXISTS `wumai_score` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL,
  `score` float NOT NULL,
  `joindate` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- 转存表中的数据 `wumai_score`
--


--
-- 表的结构 `wumai_user`
--

CREATE TABLE IF NOT EXISTS `wumai_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `open_id` varchar(60) NOT NULL,
  `nickname` varchar(60) NOT NULL,
  `realname` varchar(60) NOT NULL,
  `jp_id` int(11) NOT NULL,
  `times` int(11) NOT NULL DEFAULT 1,
  `tel` varchar(50) DEFAULT NULL,
  `sex` varchar(4) NOT NULL,
  `location` varchar(50) NOT NULL,
  `avatar` varchar(300) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `open_id` (`open_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- 转存表中的数据 `wumai_user`
--


CREATE TABLE IF NOT EXISTS `wumai_jp` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `jp_id` int(11) NOT NULL,
  `jp_num` int(11) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
