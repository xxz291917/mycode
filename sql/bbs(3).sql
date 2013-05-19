-- phpMyAdmin SQL Dump
-- version 3.5.2.2
-- http://www.phpmyadmin.net
--
-- 主机: 127.0.0.1
-- 生成日期: 2013 年 05 月 19 日 12:45
-- 服务器版本: 5.5.27
-- PHP 版本: 5.4.7

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- 数据库: `bbs`
--

-- --------------------------------------------------------

--
-- 表的结构 `attachments`
--

CREATE TABLE IF NOT EXISTS `attachments` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '附件id',
  `topic_id` int(11) unsigned NOT NULL COMMENT '所属主题id',
  `post_id` int(11) unsigned NOT NULL COMMENT '所属帖子id',
  `user_id` int(11) unsigned NOT NULL COMMENT '上传者',
  `upload_time` int(11) unsigned NOT NULL COMMENT '附件上传时间',
  `size` int(11) NOT NULL COMMENT '附件大小',
  `extension` varchar(10) NOT NULL COMMENT '文件扩展名',
  `filename` varchar(80) NOT NULL COMMENT '附件名字',
  `path` varchar(255) NOT NULL COMMENT '附件的完整路径',
  `description` varchar(255) NOT NULL COMMENT '附件的简单描述',
  `is_image` tinyint(1) NOT NULL COMMENT '是否是图片',
  `is_thumb` tinyint(1) NOT NULL COMMENT '是否是缩率图',
  `is_remote` tinyint(1) NOT NULL COMMENT '是否是远程附件',
  `downloads` int(10) unsigned NOT NULL COMMENT '附件下载次数',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='附件表' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `config`
--

CREATE TABLE IF NOT EXISTS `config` (
  `conf_name` varchar(255) NOT NULL,
  `conf_value` mediumtext NOT NULL,
  PRIMARY KEY (`conf_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='论坛核心设置表';

-- --------------------------------------------------------

--
-- 表的结构 `credit_log`
--

CREATE TABLE IF NOT EXISTS `credit_log` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `type` varchar(20) DEFAULT NULL COMMENT '受影响的积分类型（extcredits1……）',
  `action` varchar(80) NOT NULL DEFAULT '' COMMENT '积分产生的动作标识',
  `affect` int(10) NOT NULL DEFAULT '0' COMMENT '影响的积分数',
  `description` varchar(255) NOT NULL DEFAULT '' COMMENT '描述信息',
  `user_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '涉及用户id',
  `username` varchar(20) NOT NULL DEFAULT '' COMMENT '涉及用户',
  `time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '产生时间',
  PRIMARY KEY (`id`),
  KEY `idx_createduserid_createdtime` (`user_id`,`time`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='积分日志表' AUTO_INCREMENT=135 ;

--
-- 转存表中的数据 `credit_log`
--

INSERT INTO `credit_log` (`id`, `type`, `action`, `affect`, `description`, `user_id`, `username`, `time`) VALUES
(1, 'extcredits1', 'admin_set', 100, '后台管理员设置', 1, 'xxz291917', 1368072604),
(2, 'extcredits2', 'admin_set', 100, '后台管理员设置', 1, 'xxz291917', 1368072604),
(3, 'extcredits3', 'admin_set', 6, '后台管理员设置', 1, 'xxz291917', 1368072604),
(4, 'extcredits1', 'admin_set', 100, '后台管理员设置', 1, 'xxz291917', 1368072608),
(5, 'extcredits2', 'admin_set', 100, '后台管理员设置', 1, 'xxz291917', 1368072608),
(6, 'extcredits3', 'admin_set', 6, '后台管理员设置', 1, 'xxz291917', 1368072608),
(7, 'extcredits1', 'admin_set', 100, '后台管理员设置', 1, 'xxz291917', 1368072814),
(8, 'extcredits2', 'admin_set', 100, '后台管理员设置', 1, 'xxz291917', 1368072814),
(9, 'extcredits3', 'admin_set', 6, '后台管理员设置', 1, 'xxz291917', 1368072814),
(10, 'extcredits1', 'admin_set', 2, '后台管理员设置', 1, 'xxz291917', 1368076777),
(11, 'extcredits2', 'admin_set', 2, '后台管理员设置', 1, 'xxz291917', 1368076777),
(12, 'extcredits3', 'admin_set', 2, '后台管理员设置', 1, 'xxz291917', 1368076777),
(13, 'extcredits1', 'admin_set', 2, '后台管理员设置', 1, 'xxz291917', 1368076791),
(14, 'extcredits2', 'admin_set', 2, '后台管理员设置', 1, 'xxz291917', 1368076791),
(15, 'extcredits3', 'admin_set', 2, '后台管理员设置', 1, 'xxz291917', 1368076791),
(16, 'extcredits1', 'admin_set', -640, '后台管理员设置', 1, 'xxz291917', 1368077936),
(17, 'extcredits2', 'admin_set', -2008, '后台管理员设置', 1, 'xxz291917', 1368077936),
(18, 'extcredits3', 'admin_set', 266, '后台管理员设置', 1, 'xxz291917', 1368077936),
(19, 'extcredits1', 'admin_set', -640, '后台管理员设置', 1, 'xxz291917', 1368078309),
(20, 'extcredits2', 'admin_set', -2008, '后台管理员设置', 1, 'xxz291917', 1368078309),
(21, 'extcredits2', 'admin_set', 2, '后台管理员设置', 1, 'xxz291917', 1368078326),
(22, 'extcredits1', 'admin_set', 1, '后台管理员设置', 1, 'xxz291917', 1368078333),
(23, 'extcredits1', 'admin_set', -51, '后台管理员设置', 1, 'xxz291917', 1368078365),
(24, 'extcredits2', 'admin_set', -152, '后台管理员设置', 1, 'xxz291917', 1368078365),
(25, 'extcredits1', 'admin_set', 3, '后台管理员设置', 1, 'xxz291917', 1368535704),
(26, 'extcredits2', 'admin_set', 4, '后台管理员设置', 1, 'xxz291917', 1368535704),
(27, 'extcredits3', 'admin_set', 6, '后台管理员设置', 1, 'xxz291917', 1368535704),
(28, 'extcredits4', 'admin_set', 0, '后台管理员设置', 1, 'xxz291917', 1368535704),
(29, 'extcredits5', 'admin_set', 0, '后台管理员设置', 1, 'xxz291917', 1368535704),
(30, 'extcredits6', 'admin_set', 0, '后台管理员设置', 1, 'xxz291917', 1368535704),
(31, 'extcredits7', 'admin_set', 0, '后台管理员设置', 1, 'xxz291917', 1368535704),
(32, 'extcredits8', 'admin_set', 0, '后台管理员设置', 1, 'xxz291917', 1368535704),
(33, 'extcredits1', 'admin_set', 3, '后台管理员设置', 1, 'xxz291917', 1368535793),
(34, 'extcredits2', 'admin_set', 4, '后台管理员设置', 1, 'xxz291917', 1368535793),
(35, 'extcredits3', 'admin_set', 6, '后台管理员设置', 1, 'xxz291917', 1368535793),
(36, 'extcredits4', 'admin_set', 0, '后台管理员设置', 1, 'xxz291917', 1368535793),
(37, 'extcredits5', 'admin_set', 0, '后台管理员设置', 1, 'xxz291917', 1368535793),
(38, 'extcredits6', 'admin_set', 0, '后台管理员设置', 1, 'xxz291917', 1368535793),
(39, 'extcredits7', 'admin_set', 0, '后台管理员设置', 1, 'xxz291917', 1368535793),
(40, 'extcredits8', 'admin_set', 0, '后台管理员设置', 1, 'xxz291917', 1368535793),
(41, 'extcredits1', 'post', 3, '发表主题', 1, 'xxz291917', 1368536126),
(42, 'extcredits2', 'post', 4, '发表主题', 1, 'xxz291917', 1368536126),
(43, 'extcredits3', 'post', 6, '发表主题', 1, 'xxz291917', 1368536126),
(44, 'extcredits1', 'post', 3, '发表主题', 1, 'xxz291917', 1368536223),
(45, 'extcredits2', 'post', 4, '发表主题', 1, 'xxz291917', 1368536223),
(46, 'extcredits3', 'post', 6, '发表主题', 1, 'xxz291917', 1368536223),
(47, 'extcredits1', 'post', 3, '发表主题', 1, 'xxz291917', 1368536322),
(48, 'extcredits2', 'post', 4, '发表主题', 1, 'xxz291917', 1368536322),
(49, 'extcredits3', 'post', 6, '发表主题', 1, 'xxz291917', 1368536322),
(50, 'extcredits1', 'post', 3, '发表主题', 1, 'xxz291917', 1368536374),
(51, 'extcredits2', 'post', 4, '发表主题', 1, 'xxz291917', 1368536374),
(52, 'extcredits3', 'post', 6, '发表主题', 1, 'xxz291917', 1368536374),
(53, 'extcredits1', 'post', 3, '发表主题', 1, 'xxz291917', 1368536413),
(54, 'extcredits2', 'post', 4, '发表主题', 1, 'xxz291917', 1368536413),
(55, 'extcredits3', 'post', 6, '发表主题', 1, 'xxz291917', 1368536413),
(56, 'extcredits1', 'post', 3, '发表主题', 1, 'xxz291917', 1368536467),
(57, 'extcredits2', 'post', 4, '发表主题', 1, 'xxz291917', 1368536467),
(58, 'extcredits3', 'post', 6, '发表主题', 1, 'xxz291917', 1368536467),
(59, 'extcredits1', 'post', 3, '发表主题', 1, 'xxz291917', 1368583217),
(60, 'extcredits2', 'post', 4, '发表主题', 1, 'xxz291917', 1368583217),
(61, 'extcredits3', 'post', 6, '发表主题', 1, 'xxz291917', 1368583217),
(62, 'extcredits1', 'post', 3, '发表主题', 1, 'xxz291917', 1368588882),
(63, 'extcredits2', 'post', 4, '发表主题', 1, 'xxz291917', 1368588882),
(64, 'extcredits3', 'post', 6, '发表主题', 1, 'xxz291917', 1368588882),
(65, 'extcredits1', 'post', 3, '发表主题', 1, 'xxz291917', 1368609926),
(66, 'extcredits2', 'post', 4, '发表主题', 1, 'xxz291917', 1368609926),
(67, 'extcredits3', 'post', 6, '发表主题', 1, 'xxz291917', 1368609926),
(68, 'extcredits1', 'post', 3, '发表主题', 1, 'xxz291917', 1368610003),
(69, 'extcredits2', 'post', 4, '发表主题', 1, 'xxz291917', 1368610003),
(70, 'extcredits3', 'post', 6, '发表主题', 1, 'xxz291917', 1368610003),
(71, 'extcredits2', 'post', 2, '发表主题', 1, 'xxz291917', 1368611640),
(72, 'extcredits1', 'post', 2, '发表主题', 1, 'xxz291917', 1368612732),
(73, 'extcredits2', 'post', 3, '发表主题', 1, 'xxz291917', 1368612732),
(74, 'extcredits3', 'post', 3, '发表主题', 1, 'xxz291917', 1368612732),
(75, 'extcredits2', 'reply', 1, '发表回复', 1, 'xxz291917', 1368696089),
(76, 'extcredits2', 'reply', 1, '发表回复', 1, 'xxz291917', 1368696323),
(77, 'extcredits2', 'reply', 1, '发表回复', 1, 'xxz291917', 1368696465),
(78, 'extcredits2', 'reply', 1, '发表回复', 1, 'xxz291917', 1368696706),
(79, 'extcredits2', 'reply', 1, '发表回复', 1, 'xxz291917', 1368696770),
(80, 'extcredits1', 'post', 2, '发表主题', 1, 'xxz291917', 1368696809),
(81, 'extcredits2', 'post', 3, '发表主题', 1, 'xxz291917', 1368696809),
(82, 'extcredits3', 'post', 3, '发表主题', 1, 'xxz291917', 1368696809),
(83, 'extcredits1', 'reply', 4, '发表回复', 1, 'xxz291917', 1368696817),
(84, 'extcredits2', 'reply', 4, '发表回复', 1, 'xxz291917', 1368696817),
(85, 'extcredits3', 'reply', 4, '发表回复', 1, 'xxz291917', 1368696817),
(86, 'extcredits1', 'reply', 4, '发表回复', 1, 'xxz291917', 1368697037),
(87, 'extcredits2', 'reply', 4, '发表回复', 1, 'xxz291917', 1368697037),
(88, 'extcredits3', 'reply', 4, '发表回复', 1, 'xxz291917', 1368697037),
(89, 'extcredits1', 'post', 3, '发表主题', 1, 'xxz291917', 1368699427),
(90, 'extcredits2', 'post', 5, '发表主题', 1, 'xxz291917', 1368699427),
(91, 'extcredits3', 'post', 5, '发表主题', 1, 'xxz291917', 1368699427),
(92, 'extcredits1', 'reply', 4, '发表回复', 1, 'xxz291917', 1368757267),
(93, 'extcredits2', 'reply', 4, '发表回复', 1, 'xxz291917', 1368757267),
(94, 'extcredits3', 'reply', 4, '发表回复', 1, 'xxz291917', 1368757267),
(95, 'extcredits1', 'admin_set', -98, '后台管理员设置', 2, 'xxz5291917', 1368757534),
(96, 'extcredits2', 'admin_set', -122, '后台管理员设置', 2, 'xxz5291917', 1368757545),
(97, 'extcredits3', 'admin_set', -391, '后台管理员设置', 2, 'xxz5291917', 1368757545),
(98, 'extcredits1', 'admin_set', -10, '后台管理员设置', 2, 'xxz5291917', 1368757556),
(99, 'extcredits1', 'admin_set', 10, '后台管理员设置', 2, 'xxz5291917', 1368757562),
(100, 'extcredits1', 'admin_set', 90, '后台管理员设置', 2, 'xxz5291917', 1368757570),
(101, 'extcredits1', 'admin_set', -90, '后台管理员设置', 2, 'xxz5291917', 1368757583),
(102, 'extcredits1', 'reply', 4, '发表回复', 2, 'xxz5291917', 1368758585),
(103, 'extcredits2', 'reply', 4, '发表回复', 2, 'xxz5291917', 1368758585),
(104, 'extcredits3', 'reply', 4, '发表回复', 2, 'xxz5291917', 1368758585),
(105, 'extcredits1', 'reply', 4, '发表回复', 2, 'xxz5291917', 1368758605),
(106, 'extcredits2', 'reply', 4, '发表回复', 2, 'xxz5291917', 1368758605),
(107, 'extcredits3', 'reply', 4, '发表回复', 2, 'xxz5291917', 1368758605),
(108, 'extcredits2', 'admin_set', -1, '后台管理员设置', 2, 'xxz5291917', 1368758961),
(109, 'extcredits2', 'admin_set', -1, '后台管理员设置', 2, 'xxz5291917', 1368759198),
(110, 'extcredits2', 'admin_set', 1, '后台管理员设置', 2, 'xxz5291917', 1368759219),
(111, 'extcredits1', 'reply', 2, '发表回复', 2, 'xxz5291917', 1368771927),
(112, 'extcredits2', 'reply', 2, '发表回复', 2, 'xxz5291917', 1368771927),
(113, 'extcredits3', 'reply', 3, '发表回复', 2, 'xxz5291917', 1368771927),
(114, 'extcredits1', 'reply', 2, '发表回复', 2, 'xxz5291917', 1368772287),
(115, 'extcredits2', 'reply', 2, '发表回复', 2, 'xxz5291917', 1368772287),
(116, 'extcredits3', 'reply', 3, '发表回复', 2, 'xxz5291917', 1368772287),
(117, 'extcredits1', 'reply', 2, '发表回复', 2, 'xxz5291917', 1368772292),
(118, 'extcredits2', 'reply', 2, '发表回复', 2, 'xxz5291917', 1368772292),
(119, 'extcredits3', 'reply', 3, '发表回复', 2, 'xxz5291917', 1368772292),
(120, 'extcredits2', 'post', 2, '发表主题', 2, 'xxz5291917', 1368772328),
(121, 'extcredits1', 'reply', 4, '发表回复', 2, 'xxz5291917', 1368773339),
(122, 'extcredits2', 'reply', 4, '发表回复', 2, 'xxz5291917', 1368773339),
(123, 'extcredits3', 'reply', 4, '发表回复', 2, 'xxz5291917', 1368773339),
(124, 'extcredits1', 'reply', 2, '发表回复', 2, 'xxz5291917', 1368774131),
(125, 'extcredits2', 'reply', 2, '发表回复', 2, 'xxz5291917', 1368774131),
(126, 'extcredits3', 'reply', 3, '发表回复', 2, 'xxz5291917', 1368774131),
(127, 'extcredits2', 'reply', 1, '发表回复', 2, 'xxz5291917', 1368774508),
(128, 'extcredits2', 'reply', 1, '发表回复', 2, 'xxz5291917', 1368774528),
(129, 'extcredits2', 'reply', 1, '发表回复', 2, 'xxz5291917', 1368774534),
(130, 'extcredits2', 'reply', 1, '发表回复', 2, 'xxz5291917', 1368774539),
(131, 'extcredits2', 'reply', 1, '发表回复', 2, 'xxz5291917', 1368774591),
(132, 'extcredits2', 'reply', 1, '发表回复', 2, 'xxz5291917', 1368774662),
(133, 'extcredits2', 'post', 2, '发表主题', 2, 'xxz5291917', 1368774681),
(134, 'extcredits2', 'admin_set', -112, '后台管理员设置', 1, 'xxz291917', 1368775202);

-- --------------------------------------------------------

--
-- 表的结构 `credit_name`
--

CREATE TABLE IF NOT EXISTS `credit_name` (
  `credit_x` varchar(12) NOT NULL,
  `view_name` varchar(20) NOT NULL,
  PRIMARY KEY (`credit_x`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `credit_name`
--

INSERT INTO `credit_name` (`credit_x`, `view_name`) VALUES
('extcredits1', '威望'),
('extcredits2', '金钱'),
('extcredits3', '贡献');

-- --------------------------------------------------------

--
-- 表的结构 `credit_rule`
--

CREATE TABLE IF NOT EXISTS `credit_rule` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL DEFAULT '' COMMENT '规则名',
  `action` varchar(20) NOT NULL DEFAULT '' COMMENT '规则唯一key',
  `cycle_type` tinyint(1) NOT NULL DEFAULT '0' COMMENT '奖励周期0:一次;1:每天;2:整点;3:间隔分钟;4:不限;',
  `cycle_time` int(10) NOT NULL DEFAULT '0' COMMENT '间隔时间',
  `reward_num` tinyint(2) NOT NULL DEFAULT '1' COMMENT '奖励次数',
  `is_repeat` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否重复（0：不重复，1：重复）',
  `extcredits1` int(10) NOT NULL DEFAULT '0',
  `extcredits2` int(10) NOT NULL DEFAULT '0',
  `extcredits3` int(10) NOT NULL DEFAULT '0',
  `extcredits4` int(10) NOT NULL DEFAULT '0',
  `extcredits5` int(10) NOT NULL DEFAULT '0',
  `extcredits6` int(10) NOT NULL DEFAULT '0',
  `extcredits7` int(10) NOT NULL DEFAULT '0',
  `extcredits8` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `action` (`action`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='全局积分规则表，如果版块有自己的积分设置，则覆盖掉此表的设置。' AUTO_INCREMENT=8 ;

--
-- 转存表中的数据 `credit_rule`
--

INSERT INTO `credit_rule` (`id`, `name`, `action`, `cycle_type`, `cycle_time`, `reward_num`, `is_repeat`, `extcredits1`, `extcredits2`, `extcredits3`, `extcredits4`, `extcredits5`, `extcredits6`, `extcredits7`, `extcredits8`) VALUES
(1, '发表主题', 'post', 4, 0, 0, 0, 0, 2, 0, 0, 0, 0, 0, 0),
(2, '发表回复', 'reply', 4, 0, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0),
(3, '加精华', 'digest', 4, 0, 0, 0, 0, 5, 0, 0, 0, 0, 0, 0),
(4, '上传附件', 'postattach', 4, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(5, '下载附件', 'getattach', 4, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(6, '每天登录', 'daylogin', 1, 0, 1, 0, 0, 2, 0, 0, 0, 0, 0, 0),
(7, '搜索', 'search', 4, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- 表的结构 `drafts`
--

CREATE TABLE IF NOT EXISTS `drafts` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '所属用户id',
  `topic_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '所属主题id',
  `forum_id` mediumint(8) unsigned NOT NULL DEFAULT '0' COMMENT '所属版块id',
  `subject` varchar(80) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL DEFAULT '' COMMENT '草稿主题',
  `content` mediumtext CHARACTER SET utf8 COLLATE utf8_bin NOT NULL COMMENT '草稿内容',
  `time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '保存时间',
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `forums`
--

CREATE TABLE IF NOT EXISTS `forums` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `parent_id` mediumint(8) unsigned NOT NULL DEFAULT '0' COMMENT '版面隶属的上一级版面ID, 如果自己为根版面, 则此值为0',
  `type` enum('group','forum','sub') NOT NULL DEFAULT 'forum',
  `name` varchar(50) NOT NULL COMMENT '版块名字',
  `description` varchar(500) NOT NULL COMMENT '版块描述说明',
  `icon` varchar(255) NOT NULL COMMENT '版块图标',
  `manager` varchar(255) NOT NULL COMMENT '论坛版主列表,用‘,’分隔',
  `display_order` smallint(6) NOT NULL DEFAULT '0' COMMENT '版块显示顺序',
  `create_user` varchar(20) NOT NULL COMMENT '创建版块者',
  `create_user_id` int(10) unsigned NOT NULL COMMENT '创建版块者id',
  `create_time` int(11) NOT NULL COMMENT '创建版块时间',
  `allow_special` varchar(255) NOT NULL COMMENT '本版块允许发表的特殊主题',
  `is_anonymous` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否允许匿名发帖子',
  `is_html` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否允许html',
  `is_bbcode` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否允许使用bbcode',
  `is_smilies` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否允许使用表情符号',
  `is_media` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否允许使用链接',
  `check` tinyint(1) unsigned NOT NULL COMMENT '是否需要审核(0不审核，1审核主题，2审核主题和回复)',
  `allow_visit` varchar(255) NOT NULL COMMENT '允许访问版块的用户组',
  `allow_read` varchar(255) NOT NULL COMMENT '允许访问主题的用户组',
  `allow_post` varchar(255) NOT NULL COMMENT '允许发表主题的用户组',
  `allow_reply` varchar(255) NOT NULL COMMENT '允许回复的用户组',
  `allow_upload` varchar(255) NOT NULL COMMENT '允许上传附件的用户组',
  `allow_download` varchar(255) NOT NULL COMMENT '允许下载附件的用户组',
  `seo_title` varchar(255) NOT NULL COMMENT 'seo标题',
  `seo_keywords` varchar(255) NOT NULL COMMENT 'seo关键字',
  `seo_description` varchar(255) NOT NULL COMMENT 'seo描述',
  `credit_setting` varchar(3000) NOT NULL COMMENT '积分设置（发帖，回复，加精……）',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '显示状态 (1正常,0关闭)',
  PRIMARY KEY (`id`),
  KEY `forum` (`status`,`type`,`display_order`),
  KEY `fup_type` (`parent_id`,`type`,`display_order`),
  KEY `fup` (`parent_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='论坛版块' AUTO_INCREMENT=13 ;

--
-- 转存表中的数据 `forums`
--

INSERT INTO `forums` (`id`, `parent_id`, `type`, `name`, `description`, `icon`, `manager`, `display_order`, `create_user`, `create_user_id`, `create_time`, `allow_special`, `is_anonymous`, `is_html`, `is_bbcode`, `is_smilies`, `is_media`, `check`, `allow_visit`, `allow_read`, `allow_post`, `allow_reply`, `allow_upload`, `allow_download`, `seo_title`, `seo_keywords`, `seo_description`, `credit_setting`, `status`) VALUES
(1, 0, 'group', 'test版大大大', '测试新分类', '', 'dsdff', 1, '', 0, 0, '', 0, 0, 0, 0, 0, 0, '1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19', '1,2,3,4,6,7', '1,2,3,4,5,6', '1,2,3,4,5,9,10', '1,2,3', '1,2,3', '论坛seo', '', '', '{"post":{"extcredits1":"3","extcredits2":"4","extcredits3":"5"},"reply":{"extcredits1":"","extcredits2":"6","extcredits3":""},"digest":{"extcredits1":"","extcredits2":"7","extcredits3":""},"postattach":{"extcredits1":"","extcredits2":"8","extcredits3":""},"getattach":{"extcredits1":"","extcredits2":"","extcredits3":""},"daylogin":{"extcredits1":"","extcredits2":"","extcredits3":""},"search":{"extcredits1":"","extcredits2":"","extcredits3":""}}', 1),
(2, 1, 'forum', 'test版', '测试默认版块', '', 'xxz291917', 2, '', 0, 0, '1,2', 0, 1, 1, 0, 0, 0, '1,2,3,16,17,18,19,10,11,12,13,14,15', '1,2,3,16,17,18,19,10,11,12,13,14,15', '1,2,3,16,17,18,19,10,11,12,13,14,15', '1,2,3,16,17,18,19,10,11,12,13,14,15', '1,2,3,16,17,18,19,10,11,12,13,14,15', '1,2,3,16,17,18,19,10,11,12,13,14,15', '', '', '', '{"post":{"extcredits1":"3","extcredits2":"4","extcredits3":"6"},"reply":{"extcredits1":"2","extcredits2":"2","extcredits3":"3"},"digest":{"extcredits1":"","extcredits2":"","extcredits3":""},"postattach":{"extcredits1":"","extcredits2":"","extcredits3":""},"getattach":{"extcredits1":"0","extcredits2":"5","extcredits3":"4"},"daylogin":{"extcredits1":"","extcredits2":"","extcredits3":""},"search":{"extcredits1":"","extcredits2":"","extcredits3":""}}', 0),
(4, 0, 'group', 'test545', '测试版块内容哦测试版块内容哦测试版块内容哦测试版块内容哦测试版块内容哦测试版块内容哦测试版块内容哦', '', 'admin', 5, '', 0, 0, '2,3', 0, 1, 1, 1, 1, 2, '', '', '', '', '', '', '论坛seo', '论坛seo 论坛seo', '论坛seo论坛seo论坛seo论坛seo论坛seo论坛seo', '', 1),
(6, 2, 'sub', '学智测试版块', '', '', '', 0, '', 0, 0, '', 0, 0, 0, 0, 0, 0, '1,2', '1,2', '1,2', '1,2', '1,2', '1,2', '', '', '', '{"post":{"extcredits1":"3","extcredits2":"5","extcredits3":"5"},"reply":{"extcredits1":"","extcredits2":"","extcredits3":""},"digest":{"extcredits1":"","extcredits2":"","extcredits3":""},"postattach":{"extcredits1":"","extcredits2":"","extcredits3":""},"getattach":{"extcredits1":"","extcredits2":"","extcredits3":""},"daylogin":{"extcredits1":"","extcredits2":"","extcredits3":""},"search":{"extcredits1":"","extcredits2":"","extcredits3":""}}', 1),
(10, 0, 'group', '子版块测试', '', '', '', 2, '', 0, 0, '', 0, 0, 0, 0, 0, 0, '', '', '', '', '', '', '', '', '', '', 0),
(11, 1, 'forum', 'test版块', '', '', '', 0, 'xxz291917', 1, 1367912803, '', 0, 0, 0, 0, 0, 0, '', '', '', '', '', '', '', '', '', '{"post":{"extcredits1":"2","extcredits2":"3","extcredits3":"3"},"reply":{"extcredits1":"4","extcredits2":"4","extcredits3":"4"},"digest":{"extcredits1":"4","extcredits2":"3","extcredits3":"3"},"postattach":{"extcredits1":"","extcredits2":"","extcredits3":""},"getattach":{"extcredits1":"","extcredits2":"","extcredits3":""},"daylogin":{"extcredits1":"","extcredits2":"","extcredits3":""},"search":{"extcredits1":"","extcredits2":"","extcredits3":""}}', 0),
(12, 10, 'forum', '学习好习惯', '', '', '', 0, 'xxz291917', 1, 1368584217, '', 0, 0, 0, 0, 0, 0, '', '', '', '', '', '', '', '', '', '', 0);

-- --------------------------------------------------------

--
-- 表的结构 `forums_statistics`
--

CREATE TABLE IF NOT EXISTS `forums_statistics` (
  `forum_id` mediumint(8) unsigned NOT NULL COMMENT '版块id',
  `posts` int(10) unsigned NOT NULL COMMENT '总共回复数',
  `topics` int(10) unsigned NOT NULL COMMENT '总共主题数',
  `today_posts` int(10) unsigned NOT NULL COMMENT '今天的回复数',
  `today_topics` int(10) unsigned NOT NULL COMMENT '今天的主题数',
  `last_post_id` int(10) unsigned NOT NULL COMMENT '最后回复id',
  `last_post_time` int(10) unsigned NOT NULL COMMENT '最后回复时间',
  `last_author` varchar(20) NOT NULL COMMENT '最后回复者',
  PRIMARY KEY (`forum_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='版块统计表';

--
-- 转存表中的数据 `forums_statistics`
--

INSERT INTO `forums_statistics` (`forum_id`, `posts`, `topics`, `today_posts`, `today_topics`, `last_post_id`, `last_post_time`, `last_author`) VALUES
(2, 11, 5, 5, 3, 10, 1368774131, 'xxz5291917'),
(6, 4, 1, 4, 1, 14, 1368701675, 'xxz291917'),
(10, 1, 1, 1, 1, 15, 1368772328, 'xxz5291917'),
(11, 8, 2, 4, 1, 13, 1368773339, 'xxz5291917'),
(12, 13, 2, 7, 2, 16, 1368774681, 'xxz5291917');

-- --------------------------------------------------------

--
-- 表的结构 `groups`
--

CREATE TABLE IF NOT EXISTS `groups` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `type` enum('system','special','member') NOT NULL,
  `name` varchar(80) NOT NULL COMMENT '用户组名称',
  `icon` varchar(30) NOT NULL COMMENT '等级图片号',
  `credits` int(11) NOT NULL DEFAULT '0' COMMENT '升级所需积分',
  `stars` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '星星的数量',
  `is_sign` tinyint(1) NOT NULL DEFAULT '1' COMMENT '是否允许签名',
  `is_anonymous` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否允许匿名发帖子',
  `is_html` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否允许html',
  `is_bbcode` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否允许使用bbcode',
  `is_smilies` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否允许使用表情符号',
  `is_media` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否允许使用多媒体代码',
  `check` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '是否需要审核(0不审核，1审核主题，2审核主题和回复)',
  `allow_special` varchar(255) NOT NULL COMMENT '允许发布的特殊主题',
  `max_post_num` smallint(11) NOT NULL DEFAULT '0' COMMENT '每日最多发帖数',
  `max_upload_num` smallint(11) NOT NULL DEFAULT '0' COMMENT '每日最多上传附件数',
  `min_pertime` smallint(6) NOT NULL DEFAULT '0' COMMENT '最小的发帖间隔',
  `is_hide` tinyint(4) NOT NULL DEFAULT '0' COMMENT '允许使用隐藏标签',
  `is_permission` tinyint(4) NOT NULL DEFAULT '0' COMMENT '设置访问权限',
  `is_site_visit` tinyint(1) NOT NULL DEFAULT '1' COMMENT '是否允许访问站点',
  `is_report` tinyint(1) NOT NULL DEFAULT '1' COMMENT '是否允许举报帖子',
  `is_visit` tinyint(1) NOT NULL DEFAULT '1' COMMENT '允许访问论坛和版块',
  `is_read` tinyint(1) NOT NULL DEFAULT '1' COMMENT '允许查看主题',
  `is_post` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否允许发表主题',
  `is_reply` tinyint(1) NOT NULL DEFAULT '1' COMMENT '是否允许回复',
  `is_upload` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否允许上传附件',
  `is_download` tinyint(1) NOT NULL DEFAULT '1' COMMENT '是否允许下载附件',
  `extra_setting` varchar(3000) NOT NULL COMMENT '扩展设置，保存数组格式',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=20 ;

--
-- 转存表中的数据 `groups`
--

INSERT INTO `groups` (`id`, `type`, `name`, `icon`, `credits`, `stars`, `is_sign`, `is_anonymous`, `is_html`, `is_bbcode`, `is_smilies`, `is_media`, `check`, `allow_special`, `max_post_num`, `max_upload_num`, `min_pertime`, `is_hide`, `is_permission`, `is_site_visit`, `is_report`, `is_visit`, `is_read`, `is_post`, `is_reply`, `is_upload`, `is_download`, `extra_setting`) VALUES
(1, 'system', '管理员', '', 0, 9, 1, 1, 1, 1, 1, 1, 0, '1,2,3', 0, 0, 0, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, ''),
(2, 'system', '超级版主', '', 0, 8, 1, 0, 1, 1, 1, 1, 0, '2', 3, 0, 0, 0, 0, 0, 1, 1, 1, 1, 1, 1, 1, ''),
(3, 'system', '版主', '', 0, 7, 1, 0, 1, 1, 1, 1, 0, '', 0, 10, 10, 0, 0, 0, 1, 1, 1, 1, 1, 0, 0, ''),
(4, 'system', '禁止发言', '', 0, 0, 1, 0, 1, 1, 0, 0, 0, '', 0, 0, 0, 0, 0, 0, 1, 1, 1, 0, 0, 0, 0, ''),
(5, 'system', '禁止访问', '', 0, 0, 0, 0, 0, 0, 0, 0, 0, '', 0, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, ''),
(6, 'system', '禁止 IP', '', 0, 0, 0, 0, 0, 0, 0, 0, 0, '', 0, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, ''),
(7, 'system', '游客', '', 0, 0, 1, 0, 1, 1, 0, 0, 0, '', 0, 0, 0, 0, 0, 0, 1, 1, 1, 0, 0, 0, 0, ''),
(8, 'system', '等待验证会员', '', 0, 0, 1, 0, 1, 1, 0, 0, 0, '', 0, 0, 0, 0, 0, 0, 1, 1, 1, 0, 0, 0, 0, ''),
(9, 'member', '限制会员', '', -99999, 0, 1, 0, 1, 1, 0, 0, 0, '', 0, 0, 0, 0, 0, 0, 1, 1, 1, 0, 0, 0, 0, ''),
(10, 'member', '新手上路', '', 0, 1, 1, 1, 1, 1, 0, 0, 0, '2,3', 0, 0, 0, 0, 0, 1, 1, 1, 1, 1, 1, 1, 1, ''),
(11, 'member', '注册会员', '', 50, 2, 1, 0, 1, 1, 0, 0, 0, '1,2', 0, 0, 0, 0, 0, 0, 1, 1, 1, 0, 0, 0, 0, ''),
(12, 'member', '中级会员', '', 200, 3, 1, 0, 1, 1, 0, 0, 0, '', 0, 0, 0, 0, 0, 0, 1, 1, 1, 0, 0, 0, 0, ''),
(13, 'member', '高级会员', '', 500, 4, 1, 0, 1, 1, 0, 0, 0, '', 0, 0, 0, 0, 0, 0, 1, 1, 1, 0, 0, 0, 0, ''),
(14, 'member', '金牌会员', '', 1000, 6, 1, 0, 1, 1, 0, 0, 0, '', 0, 0, 0, 0, 0, 0, 1, 1, 1, 0, 0, 0, 0, ''),
(15, 'member', '论坛元老', '', 3000, 8, 1, 0, 1, 1, 0, 0, 0, '', 0, 0, 0, 0, 0, 0, 1, 1, 1, 0, 0, 0, 0, ''),
(16, 'special', '实习版主', '', 0, 7, 1, 0, 1, 1, 0, 0, 2, '', 0, 0, 0, 0, 0, 0, 1, 1, 1, 1, 1, 0, 0, ''),
(17, 'special', '网站编辑', '', 0, 8, 1, 0, 1, 1, 0, 0, 0, '', 0, 0, 0, 0, 0, 0, 1, 1, 1, 0, 0, 0, 0, ''),
(18, 'special', '信息监察员', '', 0, 9, 1, 0, 1, 1, 0, 0, 0, '', 0, 0, 0, 0, 0, 0, 1, 1, 1, 0, 0, 0, 0, ''),
(19, 'special', '审核员', '', 0, 6, 1, 0, 1, 1, 0, 0, 0, '', 0, 0, 0, 0, 0, 0, 1, 1, 1, 0, 0, 0, 0, '');

-- --------------------------------------------------------

--
-- 表的结构 `groups_admin`
--

CREATE TABLE IF NOT EXISTS `groups_admin` (
  `group_id` smallint(6) unsigned NOT NULL DEFAULT '0' COMMENT '关联用户组id',
  `allow_top` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否允许主题置顶类型',
  `is_toppost` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否允许置顶回帖',
  `allow_digest` tinyint(1) NOT NULL DEFAULT '0' COMMENT '允许主题加精类型',
  `is_highlight` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否允许高亮主题',
  `is_bump` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否允许提升主题',
  `is_recommend` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否允许推荐主题',
  `is_edit` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否允许编辑帖子',
  `is_check` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否允许审核帖子',
  `is_copy` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否允许复制主题',
  `is_merge` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否允许合并主题',
  `is_split` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否允许切分主题',
  `is_move` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否允许移动主题',
  `is_editcategory` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否允许编辑主题分类',
  `is_ban` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否允许屏蔽帖子',
  `is_close` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否允许关闭主题',
  `is_del` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否允许删除帖子',
  `is_edituser` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否允许编辑用户信息',
  `is_banuser` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否允许禁止用户发言',
  `is_viewip` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否允许查看IP',
  `is_banip` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否允许禁止IP',
  `is_viewlog` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否允许查看管理日志',
  PRIMARY KEY (`group_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `groups_admin`
--

INSERT INTO `groups_admin` (`group_id`, `allow_top`, `is_toppost`, `allow_digest`, `is_highlight`, `is_bump`, `is_recommend`, `is_edit`, `is_check`, `is_copy`, `is_merge`, `is_split`, `is_move`, `is_editcategory`, `is_ban`, `is_close`, `is_del`, `is_edituser`, `is_banuser`, `is_viewip`, `is_banip`, `is_viewlog`) VALUES
(1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1),
(2, 2, 1, 3, 1, 1, 0, 0, 1, 1, 0, 1, 1, 1, 1, 1, 0, 0, 0, 0, 0, 0),
(3, 1, 0, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 0, 1, 1, 1, 1, 1, 1, 1, 1),
(16, 2, 1, 2, 1, 1, 0, 0, 1, 1, 0, 0, 1, 1, 0, 0, 0, 1, 1, 1, 1, 1),
(17, 2, 0, 3, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 0, 0, 0, 1, 0, 1),
(18, 0, 0, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, 1, 1, 0),
(19, 0, 0, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 1, 1, 0);

-- --------------------------------------------------------

--
-- 表的结构 `posts`
--

CREATE TABLE IF NOT EXISTS `posts` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键id',
  `topic_id` int(10) unsigned NOT NULL COMMENT '所属主题id',
  `forum_id` int(11) NOT NULL,
  `author` varchar(20) NOT NULL COMMENT '作者',
  `author_id` int(10) unsigned NOT NULL COMMENT '作者id',
  `author_ip` varchar(15) NOT NULL COMMENT '发帖者IP',
  `post_time` int(10) unsigned NOT NULL COMMENT '回复时间',
  `subject` varchar(80) NOT NULL COMMENT '回复标题',
  `content` mediumtext NOT NULL COMMENT '回复内容',
  `edit_user` varchar(20) NOT NULL COMMENT '最后编辑者',
  `edit_user_id` int(10) unsigned NOT NULL COMMENT '最后编辑者id',
  `edit_time` int(10) unsigned NOT NULL,
  `attachment` tinyint(3) unsigned NOT NULL COMMENT '附件类型，0没有附件，1图片附件，2其他附件',
  `check_status` tinyint(1) NOT NULL COMMENT '审核状态',
  `is_first` tinyint(1) NOT NULL COMMENT '是否是主题贴',
  `is_report` tinyint(1) NOT NULL COMMENT '是否举报',
  `is_bbcode` tinyint(1) NOT NULL COMMENT '是否允许bbcode',
  `is_smilies` tinyint(1) NOT NULL COMMENT '是否允许表情符号',
  `is_media` tinyint(1) NOT NULL COMMENT '是否允许使用多媒体',
  `is_html` tinyint(1) NOT NULL COMMENT '是否开启html',
  `is_anonymous` tinyint(1) NOT NULL COMMENT '是否匿名贴',
  `is_hide` tinyint(1) NOT NULL COMMENT '是否是隐藏贴',
  `is_sign` int(11) NOT NULL COMMENT '是否显示签名',
  `status` tinyint(3) unsigned NOT NULL COMMENT '状态（1正常，2删除，3被锁定）',
  PRIMARY KEY (`id`),
  KEY `forum_id` (`forum_id`),
  KEY `topic_id` (`topic_id`,`author_id`),
  KEY `post_time` (`post_time`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=43 ;

--
-- 转存表中的数据 `posts`
--

INSERT INTO `posts` (`id`, `topic_id`, `forum_id`, `author`, `author_id`, `author_ip`, `post_time`, `subject`, `content`, `edit_user`, `edit_user_id`, `edit_time`, `attachment`, `check_status`, `is_first`, `is_report`, `is_bbcode`, `is_smilies`, `is_media`, `is_html`, `is_anonymous`, `is_hide`, `is_sign`, `status`) VALUES
(1, 4, 2, 'xxz291917', 1, '127.0.0.1', 1368531409, '输入标题r', '填写帖子内容', '', 0, 0, 0, 0, 1, 0, 1, 1, 1, 1, 1, 1, 1, 1),
(2, 6, 2, 'xxz291917', 1, '127.0.0.1', 1368531645, '输入标题r', '填写帖子内容', '', 0, 0, 0, 0, 1, 0, 1, 1, 1, 1, 1, 1, 1, 1),
(6, 10, 2, 'xxz291917', 1, '127.0.0.1', 1368535793, '输入标题r', '填写帖子内容', '', 0, 0, 0, 0, 1, 0, 1, 1, 1, 1, 1, 1, 1, 1),
(7, 7, 2, 'xxz291917', 1, '127.0.0.1', 1368583217, '夏学智测试', '今天的内容要新鲜哦\r\n<p class="MsoNormalCxSpFirst" style="margin-left:6.55pt;text-indent:36.0pt;">\r\n	<span style="font-family:&quot;">显式地把已<span>经</span>不再被引<span>用</span>的对象<span>赋</span>为</span><span> </span><span>nu</span><span>l</span><span>l</span>\r\n</p>\r\n<p class="MsoNormalCxSpMiddle" style="margin-left:6.55pt;text-indent:36.0pt;">\r\n	<span style="font-family:&quot;">不要频繁初<span>始</span>化对象</span><b><span></span></b>\r\n</p>\r\n<p class="MsoNormalCxSpMiddle" style="margin-left:6.55pt;text-indent:36.0pt;">\r\n	<span style="font-family:&quot;">除非必要，<span>否</span>则不要<span>在</span>循环内<span>初</span>始化对象</span><span> <span></span></span>\r\n</p>\r\n<p class="MsoNormalCxSpMiddle" style="margin-left:6.55pt;text-indent:36.0pt;">\r\n	<span style="font-family:&quot;">示例：</span><b><span></span></b>\r\n</p>\r\n<p class="MsoNormalCxSpMiddle" style="margin-left:6.55pt;text-indent:36.0pt;">\r\n	<span>f</span><span>o</span><span>r <span>(</span><span>$</span>i<span> </span>= <span>0</span>; <span>$</span>i<span> </span><span>&lt;</span><span>$</span><span>r</span><span>o</span><span>w</span>s;<span> </span><span>$i</span><span>++</span>)<span> </span>{</span><b><span></span></b>\r\n</p>\r\n<p class="MsoNormalCxSpMiddle" style="margin-left:36.0pt;text-indent:36.0pt;">\r\n	<span>$</span><span>c<span>o</span><span>mm</span><span>o</span><span>n</span><span>W</span><span>r</span><span>k</span><span>S</span><span>h</span>t<span> </span>= <span>n</span><span>e</span>w<span> </span><span>C</span><span>o</span><span>mm</span><span>o</span><span>n</span><span>W</span><span>r</span><span>k</span><span>S</span><span>h</span><span>t()</span>;</span><b><span></span></b>\r\n</p>\r\n<p class="MsoNormalCxSpMiddle" style="margin-left:36.0pt;text-indent:36.0pt;">\r\n	<span>…</span><b><span></span></b>\r\n</p>\r\n<p class="MsoNormalCxSpMiddle" style="text-indent:41.45pt;">\r\n	<span>}</span><b><span></span></b>\r\n</p>\r\n<p class="MsoNormalCxSpMiddle" style="text-indent:41.45pt;">\r\n	<span style="font-family:&quot;">应写成：</span><b><span></span></b>\r\n</p>\r\n<p class="MsoNormalCxSpMiddle" style="text-indent:40.35pt;">\r\n	<span>$</span><span>c<span>o</span><span>mm</span><span>o</span><span>n</span><span>W</span><span>r</span><span>k</span><span>S</span><span>h</span>t<span> </span>= <span>n</span><span>e</span>w<span> </span><span>C</span><span>o</span><span>mm</span><span>o</span><span>n</span><span>W</span><span>r</span><span>k</span><span>S</span><span>h</span><span>t()</span>;</span><b><span></span></b>\r\n</p>\r\n<p class="MsoNormalCxSpMiddle" style="text-indent:42.2pt;">\r\n	<span>f</span><span>o</span><span>r <span>(</span><span>$</span>i<span> </span>= <span>0</span>; <span>$</span>i<span> </span><span>&lt;</span><span>r</span><span>o</span><span>w</span>s;<span> </span><span>$i</span><span>++</span>)<span> </span>{</span><b><span></span></b>\r\n</p>\r\n<p class="MsoNormalCxSpMiddle" style="margin-left:30.55pt;text-indent:41.45pt;">\r\n	<span>…</span><b><span></span></b>\r\n</p>\r\n<p class="MsoNormalCxSpMiddle" style="text-indent:41.45pt;">\r\n	<span>}</span><b><span></span></b>\r\n</p>', '', 0, 0, 0, 0, 1, 0, 1, 1, 1, 1, 1, 1, 1, 1),
(8, 8, 2, 'xxz291917', 1, '127.0.0.1', 1368588882, '发帖测试123', '<table>\r\n	<tbody>\r\n		<tr>\r\n			<td class="c1 td1">\r\n				tid\r\n			</td>\r\n			<td class="c2 td1">\r\n				mediumint(8) unsigned\r\n			</td>\r\n			<td class="c3 td1">\r\n				&nbsp;0\r\n			</td>\r\n			<td class="c4 td1">\r\n				&nbsp;NO\r\n			</td>\r\n			<td class="c5 td1">\r\n				&nbsp;\r\n			</td>\r\n			<td class="c6 td1">\r\n				&nbsp;主题id\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td class="c1 td2">\r\n				overt\r\n			</td>\r\n			<td class="c2 td2">\r\n				tinyint(1)\r\n			</td>\r\n			<td class="c3 td2">\r\n				&nbsp;0\r\n			</td>\r\n			<td class="c4 td2">\r\n				&nbsp;NO\r\n			</td>\r\n			<td class="c5 td2">\r\n				&nbsp;\r\n			</td>\r\n			<td class="c6 td2">\r\n				&nbsp;是否公开投票参与人\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td class="c1 td1">\r\n				multiple\r\n			</td>\r\n			<td class="c2 td1">\r\n				tinyint(1)\r\n			</td>\r\n			<td class="c3 td1">\r\n				&nbsp;0\r\n			</td>\r\n			<td class="c4 td1">\r\n				&nbsp;NO\r\n			</td>\r\n			<td class="c5 td1">\r\n				&nbsp;\r\n			</td>\r\n			<td class="c6 td1">\r\n				&nbsp;是否多选\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td class="c1 td2">\r\n				visible\r\n			</td>\r\n			<td class="c2 td2">\r\n				tinyint(1)\r\n			</td>\r\n			<td class="c3 td2">\r\n				&nbsp;0\r\n			</td>\r\n			<td class="c4 td2">\r\n				&nbsp;NO\r\n			</td>\r\n			<td class="c5 td2">\r\n				&nbsp;\r\n			</td>\r\n			<td class="c6 td2">\r\n				&nbsp;是否投票后可见\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td class="c1 td1">\r\n				maxchoices\r\n			</td>\r\n			<td class="c2 td1">\r\n				tinyint(3) unsigned\r\n			</td>\r\n			<td class="c3 td1">\r\n				&nbsp;0\r\n			</td>\r\n			<td class="c4 td1">\r\n				&nbsp;NO\r\n			</td>\r\n			<td class="c5 td1">\r\n				&nbsp;\r\n			</td>\r\n			<td class="c6 td1">\r\n				&nbsp;最大可选项数\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td class="c1 td2">\r\n				expiration\r\n			</td>\r\n			<td class="c2 td2">\r\n				int(10) unsigned\r\n			</td>\r\n			<td class="c3 td2">\r\n				&nbsp;0\r\n			</td>\r\n			<td class="c4 td2">\r\n				&nbsp;NO\r\n			</td>\r\n			<td class="c5 td2">\r\n				&nbsp;\r\n			</td>\r\n			<td class="c6 td2">\r\n				&nbsp;过期时间\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td class="c1 td1">\r\n				pollpreview\r\n			</td>\r\n			<td class="c2 td1">\r\n				varchar(255)\r\n			</td>\r\n			<td class="c3 td1">\r\n				&nbsp;\r\n			</td>\r\n			<td class="c4 td1">\r\n				&nbsp;NO\r\n			</td>\r\n			<td class="c5 td1">\r\n				&nbsp;\r\n			</td>\r\n			<td class="c6 td1">\r\n				&nbsp;选项内容前两项预览\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td class="c1 td2">\r\n				voters\r\n			</td>\r\n			<td class="c2 td2">\r\n				mediumint(8) unsigned\r\n			</td>\r\n			<td class="c3 td2">\r\n				&nbsp;0\r\n			</td>\r\n			<td class="c4 td2">\r\n				&nbsp;NO\r\n			</td>\r\n			<td class="c5 td2">\r\n				&nbsp;\r\n			</td>\r\n			<td class="c6 td2">\r\n				&nbsp;投票人数\r\n			</td>\r\n		</tr>\r\n	</tbody>\r\n</table>', '', 0, 0, 0, 0, 1, 0, 1, 1, 1, 1, 1, 1, 1, 1),
(9, 9, 2, 'xxz291917', 1, '127.0.0.1', 1368609926, '输入标题二二', '填写帖子内容污染物而', '', 0, 0, 0, 0, 1, 0, 1, 1, 1, 1, 1, 1, 1, 1),
(10, 10, 2, 'xxz291917', 1, '127.0.0.1', 1368610003, '输入标题二二', '填写帖子内容污染物而', '', 0, 0, 0, 0, 1, 0, 1, 1, 1, 1, 1, 1, 1, 1),
(11, 11, 12, 'xxz291917', 1, '127.0.0.1', 1368611640, '输入标题人人', '<a>展开</a> | <a>全部折叠</a> \r\n<table class="tb tb2 ">\r\n	<tbody>\r\n		<tr class="header">\r\n			<th>\r\n				<br />\r\n			</th>\r\n			<th>\r\n				显示顺序\r\n			</th>\r\n			<th>\r\n				版块名称\r\n			</th>\r\n			<th>\r\n				<br />\r\n			</th>\r\n			<th>\r\n				版主\r\n			</th>\r\n			<th>\r\n				<a>批量编辑</a>\r\n			</th>\r\n		</tr>\r\n		<tr class="hover">\r\n			<td class="td25">\r\n				<a id="a_group_1">[-]</a>\r\n			</td>\r\n			<td class="td25">\r\n			</td>\r\n			<td>\r\n				<div class="parentboard">\r\n				</div>\r\n			</td>\r\n			<td class="td23 lightfont" align="right">\r\n				(gid:1)\r\n			</td>\r\n			<td class="td23">\r\n				<a href="http://localhost/dz2.5/admin.php?action=forums&amp;operation=moderators&amp;fid=1">无 / 添加版主</a>\r\n			</td>\r\n			<td width="160">\r\n				<a href="http://localhost/dz2.5/admin.php?action=forums&amp;operation=edit&amp;fid=1" class="act">编辑</a><a href="http://localhost/dz2.5/admin.php?action=forums&amp;operation=delete&amp;fid=1" class="act">删除</a>\r\n			</td>\r\n		</tr>\r\n	</tbody>\r\n	<tbody id="group_1">\r\n		<tr class="hover">\r\n			<td class="td25">\r\n				<br />\r\n			</td>\r\n			<td class="td25">\r\n			</td>\r\n			<td>\r\n				<div class="board">\r\n					<a href="http://localhost/dz2.5/admin.php?action=forums###" class="addchildboard">添加子版块</a>\r\n				</div>\r\n			</td>\r\n			<td class="td23 lightfont" align="right">\r\n				(fid:2)\r\n			</td>\r\n			<td class="td23">\r\n				<a href="http://localhost/dz2.5/admin.php?action=forums&amp;operation=moderators&amp;fid=2">无 / 添加版主</a>\r\n			</td>\r\n			<td width="160">\r\n				<a href="http://localhost/dz2.5/admin.php?action=forums&amp;operation=edit&amp;fid=2" class="act">编辑</a><a href="http://localhost/dz2.5/admin.php?action=forums&amp;operation=copy&amp;source=2" class="act">设置复制</a><a href="http://localhost/dz2.5/admin.php?action=forums&amp;operation=delete&amp;fid=2" class="act">删除</a>\r\n			</td>\r\n		</tr>\r\n		<tr class="hover">\r\n			<td class="td25">\r\n				<br />\r\n			</td>\r\n			<td class="td25">\r\n			</td>\r\n			<td>\r\n				<div id="cb_39" class="lastchildboard">\r\n				</div>\r\n			</td>\r\n			<td class="td23 lightfont" align="right">\r\n				(fid:39)\r\n			</td>\r\n			<td class="td23">\r\n				<a href="http://localhost/dz2.5/admin.php?action=forums&amp;operation=moderators&amp;fid=39">xxz291917 »</a>\r\n			</td>\r\n			<td width="160">\r\n				<a href="http://localhost/dz2.5/admin.php?action=forums&amp;operation=edit&amp;fid=39" class="act">编辑</a><a href="http://localhost/dz2.5/admin.php?action=forums&amp;operation=copy&amp;source=39" class="act">设置复制</a><a href="http://localhost/dz2.5/admin.php?action=forums&amp;operation=delete&amp;fid=39" class="act">删除</a>\r\n			</td>\r\n		</tr>\r\n	</tbody>\r\n	<tbody>\r\n		<tr>\r\n			<td>\r\n				<br />\r\n			</td>\r\n			<td colspan="4">\r\n				<div class="lastboard">\r\n					<a href="http://localhost/dz2.5/admin.php?action=forums###" class="addtr">添加新版块</a>\r\n				</div>\r\n			</td>\r\n			<td>\r\n				&nbsp;\r\n			</td>\r\n		</tr>\r\n		<tr class="hover">\r\n			<td class="td25">\r\n				<a id="a_group_36">[-]</a>\r\n			</td>\r\n			<td class="td25">\r\n			</td>\r\n			<td>\r\n				<div class="parentboard">\r\n				</div>\r\n			</td>\r\n			<td class="td23 lightfont" align="right">\r\n				(gid:36)\r\n			</td>\r\n			<td class="td23">\r\n				<a href="http://localhost/dz2.5/admin.php?action=forums&amp;operation=moderators&amp;fid=36">无 / 添加版主</a>\r\n			</td>\r\n			<td width="160">\r\n				<a href="http://localhost/dz2.5/admin.php?action=forums&amp;operation=edit&amp;fid=36" class="act">编辑</a><a href="http://localhost/dz2.5/admin.php?action=forums&amp;operation=delete&amp;fid=36" class="act">删除</a>\r\n			</td>\r\n		</tr>\r\n	</tbody>\r\n	<tbody id="group_36">\r\n		<tr class="hover">\r\n			<td class="td25">\r\n				<br />\r\n			</td>\r\n			<td class="td25">\r\n			</td>\r\n			<td>\r\n				<div class="board">\r\n					<a href="http://localhost/dz2.5/admin.php?action=forums###" class="addchildboard">添加子版块</a>\r\n				</div>\r\n			</td>\r\n		</tr>\r\n	</tbody>\r\n</table>', '', 0, 0, 0, 0, 1, 0, 1, 1, 1, 1, 1, 1, 1, 1),
(12, 12, 11, 'xxz291917', 1, '127.0.0.1', 1368612732, 'gdgdfgdgdfg', 'dfgdfgdgdfg', '', 0, 0, 0, 0, 1, 0, 1, 1, 1, 1, 1, 1, 1, 1),
(13, 11, 12, 'xxz291917', 1, '127.0.0.1', 1368696089, '', '回复贴标题回复贴标题回复贴标题回复贴标题回复贴标题回复贴标题回复贴标题回复贴标题回复贴标题回复贴标题回复贴标题回复贴标题回复贴标题回复贴标题回复贴标题回复贴标题', '', 0, 0, 0, 0, 0, 0, 1, 1, 1, 1, 0, 0, 1, 1),
(14, 11, 12, 'xxz291917', 1, '127.0.0.1', 1368696323, '', '回复贴标题回复贴标题回复贴标题回复贴标题回复贴标题回复贴标题回复贴标题回复贴标题回复贴标题回复贴标题回复贴标题回复贴标题回复贴标题回复贴标题回复贴标题回复贴标题', '', 0, 0, 0, 0, 0, 0, 1, 1, 1, 1, 0, 0, 1, 1),
(15, 11, 12, 'xxz291917', 1, '127.0.0.1', 1368696465, '', '回复贴标题回复贴标题回复贴标题回复贴标题回复贴标题回复贴标题回复贴标题回复贴标题回复贴标题回复贴标题回复贴标题回复贴标题回复贴标题回复贴标题回复贴标题回复贴标题', '', 0, 0, 0, 0, 0, 0, 1, 1, 1, 1, 0, 0, 1, 1),
(16, 11, 12, 'xxz291917', 1, '127.0.0.1', 1368696706, 'test', '测试回复内容', '', 0, 0, 0, 0, 0, 0, 1, 1, 1, 1, 0, 0, 1, 1),
(17, 11, 12, 'xxz291917', 1, '127.0.0.1', 1368696770, '输入标题', '填写帖子内容才踩踩踩踩踩踩踩踩踩踩踩踩', '', 0, 0, 0, 0, 0, 0, 1, 1, 1, 1, 0, 0, 1, 1),
(18, 13, 11, 'xxz291917', 1, '127.0.0.1', 1368696809, '输入标题大大大', '填写帖子内容士大夫士大夫', '', 0, 0, 0, 0, 1, 0, 1, 1, 1, 1, 0, 0, 1, 1),
(19, 13, 11, 'xxz291917', 1, '127.0.0.1', 1368696817, '输入标题', '填写帖子内容发反反复复反反复复', '', 0, 0, 0, 0, 0, 0, 1, 1, 1, 1, 0, 0, 1, 1),
(20, 13, 11, 'xxz291917', 1, '127.0.0.1', 1368697037, '输入标题', '填写帖子内容<img src="http://localhost/mycode/js/kindeditor/plugins/emoticons/images/10.gif" alt="" border="0" />', '', 0, 0, 0, 0, 0, 0, 1, 1, 1, 1, 0, 0, 1, 1),
(21, 14, 6, 'xxz291917', 1, '127.0.0.1', 1368699427, '红星闪闪放光芒', '填写帖子内容', '', 0, 0, 0, 0, 1, 0, 1, 1, 1, 1, 0, 0, 1, 1),
(22, 14, 6, 'xxz291917', 1, '127.0.0.1', 1368699436, '输入标题', '填写帖子内容士大夫士大夫撒', '', 0, 0, 0, 0, 0, 0, 1, 1, 1, 1, 0, 0, 1, 1),
(23, 14, 6, 'xxz291917', 1, '127.0.0.1', 1368701592, '输入标题士大夫士大夫', '填写帖子内容士大夫士大夫', '', 0, 0, 0, 0, 0, 0, 1, 1, 1, 1, 0, 0, 1, 1),
(24, 14, 6, 'xxz291917', 1, '127.0.0.1', 1368701675, '', '填写帖子内容士大夫士大夫', '', 0, 0, 0, 0, 0, 0, 1, 1, 1, 1, 0, 0, 1, 1),
(25, 9, 2, 'xxz291917', 1, '127.0.0.1', 1368702719, '输入标题', '填写帖子内容凤飞飞', '', 0, 0, 0, 0, 0, 0, 1, 1, 1, 1, 0, 0, 1, 1),
(26, 13, 11, 'xxz291917', 1, '127.0.0.1', 1368757267, '输入标题', '填写帖子内容', '', 0, 0, 0, 0, 0, 0, 1, 1, 1, 1, 0, 0, 1, 1),
(27, 13, 11, 'xxz5291917', 2, '127.0.0.1', 1368758585, '输入标题', '填写帖子内容sdf <br />', '', 0, 0, 0, 0, 0, 0, 1, 1, 1, 1, 1, 1, 1, 1),
(28, 13, 11, 'xxz5291917', 2, '127.0.0.1', 1368758605, '输入标题', '填写帖子内容', '', 0, 0, 0, 0, 0, 0, 1, 1, 1, 1, 1, 1, 1, 1),
(29, 10, 2, 'xxz5291917', 2, '127.0.0.1', 1368771892, '输入标题', '填写帖子内容', '', 0, 0, 0, 0, 0, 0, 1, 0, 0, 1, 0, 0, 1, 1),
(30, 10, 2, 'xxz5291917', 2, '127.0.0.1', 1368771927, '输入标题', '填写帖子内容', '', 0, 0, 0, 0, 0, 0, 1, 0, 0, 1, 0, 0, 1, 1),
(31, 8, 2, 'xxz5291917', 2, '127.0.0.1', 1368772287, '输入标题', '填写帖子内容', '', 0, 0, 0, 0, 0, 0, 1, 0, 0, 1, 0, 0, 1, 1),
(32, 8, 2, 'xxz5291917', 2, '127.0.0.1', 1368772292, '输入标题', '填写帖子内容', '', 0, 0, 0, 0, 0, 0, 1, 0, 0, 1, 0, 0, 1, 1),
(33, 15, 6, 'xxz5291917', 2, '127.0.0.1', 1368772328, '输入标题yy', '填写帖子内容', '', 0, 0, 0, 0, 1, 0, 1, 0, 0, 1, 0, 0, 1, 1),
(34, 13, 11, 'xxz5291917', 2, '127.0.0.1', 1368773339, '输入标题', '填写帖子内容', '', 0, 0, 0, 0, 0, 0, 1, 0, 0, 1, 0, 0, 1, 1),
(35, 10, 2, 'xxz5291917', 2, '127.0.0.1', 1368774131, '是大范甘迪过分的', '大范甘迪过分', '', 0, 0, 0, 0, 0, 0, 1, 0, 0, 1, 0, 0, 1, 1),
(36, 11, 12, 'xxz5291917', 2, '127.0.0.1', 1368774508, '输入标题', '填写帖子内容', '', 0, 0, 0, 0, 0, 0, 1, 0, 0, 1, 0, 0, 1, 1),
(37, 11, 12, 'xxz5291917', 2, '127.0.0.1', 1368774528, '输入标题', '填写帖子内容', '', 0, 0, 0, 0, 0, 0, 1, 0, 0, 1, 0, 0, 1, 1),
(38, 11, 12, 'xxz5291917', 2, '127.0.0.1', 1368774534, '输入标题', '填写帖子内容', '', 0, 0, 0, 0, 0, 0, 1, 0, 0, 1, 0, 0, 1, 1),
(39, 11, 12, 'xxz5291917', 2, '127.0.0.1', 1368774539, '输入标题', '填写帖子内容', '', 0, 0, 0, 0, 0, 0, 1, 0, 0, 1, 0, 0, 1, 1),
(40, 11, 12, 'xxz5291917', 2, '127.0.0.1', 1368774591, '输入标题', '填写帖子内容', '', 0, 0, 0, 0, 0, 0, 1, 0, 0, 1, 0, 0, 1, 1),
(41, 11, 12, 'xxz5291917', 2, '127.0.0.1', 1368774662, '输入标题', '填写帖子内容', '', 0, 0, 0, 0, 0, 0, 1, 0, 0, 1, 0, 0, 1, 1),
(42, 16, 12, 'xxz5291917', 2, '127.0.0.1', 1368774681, '输入标题凤飞飞', '填写帖子内容', '', 0, 0, 0, 0, 1, 0, 1, 0, 0, 1, 0, 0, 1, 1);

-- --------------------------------------------------------

--
-- 表的结构 `posts_top`
--

CREATE TABLE IF NOT EXISTS `posts_top` (
  `topic_id` mediumint(8) unsigned NOT NULL,
  `post_id` int(10) unsigned NOT NULL,
  `position` int(10) unsigned NOT NULL,
  `end_time` int(10) unsigned NOT NULL,
  PRIMARY KEY (`topic_id`,`post_id`),
  KEY `end_time` (`topic_id`,`end_time`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='回复帖子置顶表';

-- --------------------------------------------------------

--
-- 表的结构 `reports`
--

CREATE TABLE IF NOT EXISTS `reports` (
  `id` int(10) unsigned NOT NULL DEFAULT '0',
  `topic_id` int(10) unsigned DEFAULT NULL COMMENT '所属主题id',
  `post_id` int(10) unsigned DEFAULT NULL COMMENT '举报帖子id',
  `user_id` int(10) unsigned DEFAULT NULL COMMENT '举报者id',
  `reason` varchar(255) DEFAULT NULL,
  `time` int(11) DEFAULT NULL,
  `operate_user` varchar(20) DEFAULT NULL,
  `operate_time` int(10) unsigned DEFAULT NULL COMMENT '处理状态（1未处理，2已经处理）',
  `status` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='帖子举报表';

-- --------------------------------------------------------

--
-- 表的结构 `topics`
--

CREATE TABLE IF NOT EXISTS `topics` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键id',
  `forum_id` mediumint(8) unsigned NOT NULL COMMENT '所属板块id',
  `author` varchar(20) NOT NULL COMMENT '发表者',
  `author_id` int(10) unsigned NOT NULL COMMENT '发表者id',
  `post_time` int(10) unsigned NOT NULL COMMENT '发表时间',
  `subject` varchar(80) NOT NULL COMMENT '主题',
  `last_author` varchar(20) NOT NULL COMMENT '最后回复作者',
  `last_author_id` int(10) unsigned NOT NULL COMMENT '最后发表作者id',
  `last_post_time` int(10) unsigned NOT NULL COMMENT '最后回复时间',
  `views` int(10) unsigned NOT NULL COMMENT '浏览次数',
  `replies` int(10) unsigned NOT NULL COMMENT '回复次数',
  `favors` int(10) unsigned NOT NULL COMMENT '收藏次数',
  `top` tinyint(1) NOT NULL COMMENT '是否置顶,置顶类型',
  `hightlight` varchar(30) NOT NULL COMMENT '高亮样式用'',''分隔',
  `digest` tinyint(1) NOT NULL COMMENT '是否精华，精华类型',
  `recommend` int(11) NOT NULL COMMENT '推荐主题',
  `special` tinyint(1) unsigned NOT NULL COMMENT '特殊主题（1正常，2问答，3投票）',
  `status` tinyint(1) unsigned NOT NULL COMMENT '状态（1正常，2删除，3被锁定, 4待审核）',
  PRIMARY KEY (`id`),
  KEY `forum_id` (`forum_id`),
  KEY `author_id` (`author_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=17 ;

--
-- 转存表中的数据 `topics`
--

INSERT INTO `topics` (`id`, `forum_id`, `author`, `author_id`, `post_time`, `subject`, `last_author`, `last_author_id`, `last_post_time`, `views`, `replies`, `favors`, `top`, `hightlight`, `digest`, `recommend`, `special`, `status`) VALUES
(1, 6, 'admin', 1, 0, 'xuezhiceshi', '', 0, 0, 0, 0, 0, 0, '0', 0, 0, 0, 0),
(6, 2, 'xxz291917', 1, 1368531645, '输入标题r', '', 0, 0, 0, 0, 0, 0, '0', 0, 0, 1, 1),
(7, 2, 'xxz291917', 1, 1368583217, '夏学智测试', '', 0, 0, 1, 0, 0, 0, '0', 0, 0, 1, 1),
(8, 2, 'xxz291917', 1, 1368588882, '发帖测试123', 'xxz5291917', 2, 1368772292, 7, 2, 0, 0, '0', 0, 0, 1, 1),
(9, 2, 'xxz291917', 1, 1368609926, '输入标题二二', 'xxz291917', 1, 1368702719, 7, 1, 0, 0, '0', 0, 0, 1, 1),
(10, 2, 'xxz291917', 1, 1368610003, '输入标题二二', 'xxz5291917', 2, 1368774131, 112, 5, 0, 0, '0', 0, 0, 1, 1),
(11, 12, 'xxz291917', 1, 1368611640, '输入标题人人', 'xxz5291917', 2, 1368774662, 60, 11, 0, 0, '0', 0, 0, 1, 1),
(12, 11, 'xxz291917', 1, 1368612732, 'gdgdfgdgdfg', '', 0, 0, 11, 0, 0, 0, '0', 0, 0, 1, 1),
(13, 11, 'xxz291917', 1, 1368696809, '输入标题大大大', 'xxz5291917', 2, 1368773339, 156, 8, 0, 2, '0', 0, 0, 1, 1),
(14, 6, 'xxz291917', 1, 1368699427, '红星闪闪放光芒', 'xxz291917', 1, 1368701675, 4, 4, 0, 0, '0', 0, 0, 1, 1),
(15, 6, 'xxz5291917', 2, 1368772328, '输入标题yy', '', 0, 0, 0, 0, 0, 0, '0', 0, 0, 1, 1),
(16, 12, 'xxz5291917', 2, 1368774681, '输入标题凤飞飞', '', 0, 0, 14, 0, 0, 0, '0', 0, 0, 1, 4);

-- --------------------------------------------------------

--
-- 表的结构 `topics_category`
--

CREATE TABLE IF NOT EXISTS `topics_category` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `forum_id` mediumint(8) unsigned NOT NULL,
  `name` varchar(255) CHARACTER SET latin1 NOT NULL,
  `display_order` mediumint(9) NOT NULL,
  `icon` varchar(255) CHARACTER SET latin1 NOT NULL,
  `moderators` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `fid` (`forum_id`,`display_order`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='主题分类' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `topics_endtime`
--

CREATE TABLE IF NOT EXISTS `topics_endtime` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `topic_id` int(10) unsigned NOT NULL,
  `action` varchar(20) NOT NULL,
  `end_time` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `topic_id` (`topic_id`,`action`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='主题置顶、高亮、精华、推荐的有效时间表' AUTO_INCREMENT=3 ;

--
-- 转存表中的数据 `topics_endtime`
--

INSERT INTO `topics_endtime` (`id`, `topic_id`, `action`, `end_time`) VALUES
(2, 13, 'top', 0);

-- --------------------------------------------------------

--
-- 表的结构 `topics_log`
--

CREATE TABLE IF NOT EXISTS `topics_log` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `topic_id` int(10) unsigned NOT NULL COMMENT '主题id',
  `user_id` int(10) unsigned NOT NULL,
  `username` varchar(50) CHARACTER SET latin1 NOT NULL,
  `time` int(10) unsigned NOT NULL COMMENT '操作时间',
  `action` varchar(20) CHARACTER SET latin1 NOT NULL COMMENT '操作标识符',
  `data` varchar(1000) CHARACTER SET latin1 NOT NULL COMMENT '操作相关json数据。',
  `reason` varchar(255) CHARACTER SET latin1 NOT NULL COMMENT '操作原因',
  PRIMARY KEY (`id`),
  KEY `topic_id` (`topic_id`,`time`),
  KEY `topic_id_2` (`topic_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='前台管理日志表' AUTO_INCREMENT=3 ;

--
-- 转存表中的数据 `topics_log`
--

INSERT INTO `topics_log` (`id`, `topic_id`, `user_id`, `username`, `time`, `action`, `data`, `reason`) VALUES
(1, 13, 1, 'xxz291917', 1368959568, 'top', '{"submit":"1","topic_id":"13","top":"1","end_time":1369692000,"reason":"ddddddddddddddd"}', 'ddddddddddddddd'),
(2, 13, 1, 'xxz291917', 1368959812, 'top', '{"submit":"1","topic_id":"13","top":"2","end_time":1369692000,"reason":"uiyiyuiyuiyuiy ui"}', 'uiyiyuiyuiyuiy ui');

-- --------------------------------------------------------

--
-- 表的结构 `topics_posted`
--

CREATE TABLE IF NOT EXISTS `topics_posted` (
  `user_id` int(10) unsigned NOT NULL DEFAULT '0',
  `topic_id` int(10) unsigned NOT NULL DEFAULT '0',
  `time` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`user_id`,`topic_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='用户参与的主题列表，将用户回复过的主题都记录下来，避免查询posts表。';

--
-- 转存表中的数据 `topics_posted`
--

INSERT INTO `topics_posted` (`user_id`, `topic_id`, `time`) VALUES
(2, 3, 0),
(2, 4, 0),
(2, 8, 0),
(2, 10, 0),
(2, 11, 0),
(2, 13, 0);

-- --------------------------------------------------------

--
-- 表的结构 `topics_views`
--

CREATE TABLE IF NOT EXISTS `topics_views` (
  `topic_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '主题id',
  `views` int(10) unsigned DEFAULT NULL COMMENT '查看数',
  PRIMARY KEY (`topic_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='主题查看数缓存表';

-- --------------------------------------------------------

--
-- 表的结构 `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '用户id',
  `email` varchar(80) NOT NULL COMMENT '用户邮箱',
  `username` varchar(20) NOT NULL COMMENT '用户名',
  `password` char(32) NOT NULL COMMENT '基本上不需要这个字段（passport登陆）',
  `credits` int(10) unsigned NOT NULL COMMENT '用户总积分',
  `group_id` smallint(5) unsigned NOT NULL COMMENT '所属用户组id',
  `member_id` smallint(5) unsigned NOT NULL COMMENT '管理组id',
  `groups` varchar(255) NOT NULL COMMENT '拥有的扩展用户组',
  `icon` varchar(255) NOT NULL COMMENT '用户头像',
  `gender` tinyint(4) NOT NULL COMMENT '性别',
  `signature` varchar(500) NOT NULL COMMENT '个性签名',
  `regdate` int(10) unsigned NOT NULL COMMENT '注册时间',
  `status` tinyint(3) unsigned NOT NULL COMMENT '用户状态（1正常，2删除，3锁定）',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='论坛用户表' AUTO_INCREMENT=3 ;

--
-- 转存表中的数据 `users`
--

INSERT INTO `users` (`id`, `email`, `username`, `password`, `credits`, `group_id`, `member_id`, `groups`, `icon`, `gender`, `signature`, `regdate`, `status`) VALUES
(1, 'xxz291917@163.com', 'xxz291917', '', 765, 3, 13, '2', '', 0, '<font color=''red''>签名测试22</font>', 1298763453, 1),
(2, 'xxz5291917@163.com', 'xxz5291917', '', 202, 16, 12, '16', '', 1, '<font color=''green''>签名测试</font>', 1298543453, 1);

-- --------------------------------------------------------

--
-- 表的结构 `users_belong`
--

CREATE TABLE IF NOT EXISTS `users_belong` (
  `user_id` int(10) unsigned NOT NULL,
  `group_id` smallint(10) unsigned NOT NULL,
  `end_time` int(10) unsigned NOT NULL,
  PRIMARY KEY (`user_id`,`group_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- 转存表中的数据 `users_belong`
--

INSERT INTO `users_belong` (`user_id`, `group_id`, `end_time`) VALUES
(1, 2, 1369951200),
(2, 16, 0);

-- --------------------------------------------------------

--
-- 表的结构 `users_extra`
--

CREATE TABLE IF NOT EXISTS `users_extra` (
  `user_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '用户ID',
  `posts` mediumint(8) unsigned NOT NULL DEFAULT '0' COMMENT '发帖数',
  `digests` mediumint(8) unsigned NOT NULL DEFAULT '0' COMMENT '精华数',
  `today_posts` mediumint(8) unsigned NOT NULL DEFAULT '0' COMMENT '今天发帖数',
  `today_uploads` mediumint(8) unsigned NOT NULL DEFAULT '0' COMMENT '今日上传个数',
  `last_visit_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '最后访问时间',
  `last_login_ip` varchar(20) NOT NULL DEFAULT '' COMMENT '最后登录IP',
  `last_post_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '最后发帖时间',
  `last_active_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '最后活动时间',
  `online_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '在线时长',
  `extcredits1` int(10) NOT NULL DEFAULT '0' COMMENT '积分字段1',
  `extcredits2` int(10) NOT NULL DEFAULT '0' COMMENT '积分字段2',
  `extcredits3` int(10) NOT NULL DEFAULT '0' COMMENT '积分字段3',
  `extcredits4` int(10) NOT NULL DEFAULT '0' COMMENT '积分字段4',
  `extcredits5` int(10) NOT NULL DEFAULT '0',
  `extcredits6` int(10) NOT NULL DEFAULT '0',
  `extcredits7` int(10) NOT NULL DEFAULT '0',
  `extcredits8` int(10) NOT NULL DEFAULT '0',
  `last_credit_affect_log` varchar(255) NOT NULL DEFAULT '' COMMENT '最后积分变动内容',
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `users_extra`
--

INSERT INTO `users_extra` (`user_id`, `posts`, `digests`, `today_posts`, `today_uploads`, `last_visit_time`, `last_login_ip`, `last_post_time`, `last_active_time`, `online_time`, `extcredits1`, `extcredits2`, `extcredits3`, `extcredits4`, `extcredits5`, `extcredits6`, `extcredits7`, `extcredits8`, `last_credit_affect_log`) VALUES
(1, 24, 0, 1, 24, 0, '', 1368757267, 1368757267, 0, 108, 20, 401, 0, 0, 0, 0, 0, ''),
(2, 16, 0, 17, 16, 0, '', 1368774681, 1368774681, 0, 30, 39, 34, 0, 0, 0, 0, 0, '');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
