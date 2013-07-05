-- phpMyAdmin SQL Dump
-- version 3.5.2.2
-- http://www.phpmyadmin.net
--
-- 主机: 127.0.0.1
-- 生成日期: 2013 年 07 月 04 日 12:24
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
-- 表的结构 `ask`
--

CREATE TABLE IF NOT EXISTS `ask` (
  `topic_id` int(10) unsigned NOT NULL,
  `price` int(11) NOT NULL COMMENT '悬赏价格',
  `best_answer` int(10) unsigned NOT NULL COMMENT '最佳答案',
  `forum_id` mediumint(8) unsigned NOT NULL,
  `category_id` mediumint(8) unsigned NOT NULL,
  `post_time` int(10) unsigned NOT NULL,
  `last_post_time` int(10) unsigned NOT NULL,
  `replies` int(11) unsigned NOT NULL,
  PRIMARY KEY (`topic_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='问答扩展表';

--
-- 转存表中的数据 `ask`
--

INSERT INTO `ask` (`topic_id`, `price`, `best_answer`, `forum_id`, `category_id`, `post_time`, `last_post_time`, `replies`) VALUES
(41, 5, 0, 2, 0, 0, 0, 0),
(42, 5, 0, 2, 0, 0, 0, 0),
(43, 5, 0, 2, 0, 0, 0, 0),
(45, 20, 0, 11, 0, 0, 0, 0),
(46, 0, 0, 11, 0, 0, 0, 0),
(47, 0, 0, 11, 0, 0, 0, 0),
(48, 4, 0, 11, 0, 0, 0, 0),
(66, 0, 151, 11, 3, 1372767152, 1372767369, 3),
(67, 6, 153, 11, 3, 1372769377, 1372769422, 2),
(68, 5, 156, 11, 3, 1372829309, 1372829339, 2);

-- --------------------------------------------------------

--
-- 表的结构 `ask_posts`
--

CREATE TABLE IF NOT EXISTS `ask_posts` (
  `topic_id` int(10) unsigned NOT NULL COMMENT '主题id',
  `post_id` int(11) unsigned NOT NULL COMMENT '回复posts的id',
  `user_id` int(10) unsigned NOT NULL COMMENT '回答者id',
  `supports` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '支持人数',
  `opposes` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '反对人数',
  PRIMARY KEY (`post_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `ask_posts`
--

INSERT INTO `ask_posts` (`topic_id`, `post_id`, `user_id`, `supports`, `opposes`) VALUES
(66, 149, 1, 6, 1),
(66, 150, 1, 1, 7),
(66, 151, 1, 66, 1),
(67, 153, 1, 0, 1),
(67, 154, 1, 1, 0),
(68, 156, 1, 0, 1),
(68, 157, 1, 1, 0);

-- --------------------------------------------------------

--
-- 表的结构 `attachments`
--

CREATE TABLE IF NOT EXISTS `attachments` (
  `id` int(10) unsigned NOT NULL COMMENT '附件id',
  `topic_id` int(11) unsigned NOT NULL COMMENT '所属主题id',
  `post_id` int(11) unsigned NOT NULL COMMENT '所属帖子id',
  `user_id` int(11) unsigned NOT NULL COMMENT '上传者',
  `upload_time` int(11) unsigned NOT NULL COMMENT '附件上传时间',
  `size` float unsigned NOT NULL COMMENT '附件大小',
  `extension` varchar(10) NOT NULL COMMENT '文件扩展名',
  `filename` varchar(80) NOT NULL COMMENT '附件名字',
  `path` varchar(255) NOT NULL COMMENT '附件的完整路径',
  `description` varchar(255) NOT NULL COMMENT '附件的简单描述',
  `is_image` tinyint(1) NOT NULL COMMENT '是否是图片',
  `is_thumb` tinyint(1) NOT NULL COMMENT '是否是缩率图',
  `is_remote` tinyint(1) NOT NULL COMMENT '是否是远程附件',
  `downloads` int(10) unsigned NOT NULL COMMENT '附件下载次数',
  `status` tinyint(3) unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='附件表';

--
-- 转存表中的数据 `attachments`
--

INSERT INTO `attachments` (`id`, `topic_id`, `post_id`, `user_id`, `upload_time`, `size`, `extension`, `filename`, `path`, `description`, `is_image`, `is_thumb`, `is_remote`, `downloads`, `status`) VALUES
(32, 62, 139, 1, 1372665718, 606.33, 'png', 'tumblr_mllq9of63a1qam5nvo1_500.png', 'uploads/image/18762d84dfbca6861df8b9515bc88c11.png', '士大夫士大夫', 1, 0, 0, 0, 1),
(33, 62, 139, 1, 1372665793, 248.04, 'jpg', 'tumblr_mllq9of63a1qam5nvo2_500.jpg', 'uploads/image/aab5c06120bb6d9f6ca242da75e7cb43.jpg', '', 1, 0, 0, 0, 2),
(34, 61, 137, 1, 1372668841, 248.04, 'jpg', 'tumblr_mllq9of63a1qam5nvo2_500.jpg', 'uploads/image/d4b20d3a8730bb565e68179483994a5d.jpg', '', 1, 0, 0, 0, 1),
(35, 63, 142, 1, 1372670966, 606.33, 'png', 'tumblr_mllq9of63a1qam5nvo1_500.png', 'uploads/image/cfeabb71f2d3431ccf0626f43418e6f6.png', '凤飞飞', 1, 0, 0, 0, 1);

-- --------------------------------------------------------

--
-- 表的结构 `attachments_unused`
--

CREATE TABLE IF NOT EXISTS `attachments_unused` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '附件id',
  `user_id` int(11) unsigned NOT NULL COMMENT '上传者',
  `upload_time` int(11) unsigned NOT NULL COMMENT '附件上传时间',
  `size` float unsigned NOT NULL COMMENT '附件大小',
  `extension` varchar(10) NOT NULL COMMENT '文件扩展名',
  `filename` varchar(80) NOT NULL COMMENT '附件名字',
  `path` varchar(255) NOT NULL COMMENT '附件的完整路径',
  `description` varchar(255) NOT NULL COMMENT '附件的简单描述',
  `is_image` tinyint(1) NOT NULL COMMENT '是否是图片',
  `is_thumb` tinyint(1) NOT NULL COMMENT '是否是缩率图',
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='附件表' AUTO_INCREMENT=32 ;

--
-- 转存表中的数据 `attachments_unused`
--

INSERT INTO `attachments_unused` (`id`, `user_id`, `upload_time`, `size`, `extension`, `filename`, `path`, `description`, `is_image`, `is_thumb`) VALUES
(12, 1, 1372411362, 10.54, 'jpg', '641bae695b14651f9b524cf849aafd0b.jpg', 'uploads/image/641bae695b14651f9b524cf849aafd0b.jpg', '090909', 1, 0),
(13, 1, 1372411374, 15.31, 'docx', '1f831e515500a190225a5bf70836b5ec.docx', 'uploads/file/1f831e515500a190225a5bf70836b5ec.docx', '接口将空间', 0, 0),
(14, 1, 1372411386, 15.31, 'docx', 'dfd8ba59ae5800edfbd5ea4e6a0169ac.docx', 'uploads/file/dfd8ba59ae5800edfbd5ea4e6a0169ac.docx', '噼噼啪啪', 0, 0),
(15, 1, 1372470072, 10.54, 'jpg', 'd6fee8b704f45b26d1f450760a3867e8.jpg', 'uploads/image/d6fee8b704f45b26d1f450760a3867e8.jpg', '', 1, 0),
(16, 1, 1372470529, 10.54, 'jpg', '9f1e1c0c5a81cee41a8604e82378eb79.jpg', 'uploads/image/9f1e1c0c5a81cee41a8604e82378eb79.jpg', '', 1, 0),
(17, 1, 1372470563, 10.54, 'jpg', '68c791ff122b0f1d305656c247120859.jpg', 'uploads/image/68c791ff122b0f1d305656c247120859.jpg', '', 1, 0),
(18, 1, 1372470846, 10.54, 'jpg', '8310b7d4fe66c9435da91bb21af66a2f.jpg', 'uploads/image/8310b7d4fe66c9435da91bb21af66a2f.jpg', '', 1, 0),
(19, 1, 1372475746, 15.31, 'docx', 'ea98267b468f21199bdf6378ecda5fb5.docx', 'uploads/file/ea98267b468f21199bdf6378ecda5fb5.docx', 'ddd', 0, 0),
(20, 1, 1372476501, 10.54, 'jpg', 'bfd049bce1d57f7de91147515a41c42d.jpg', 'uploads/image/bfd049bce1d57f7de91147515a41c42d.jpg', 'tyty', 1, 0),
(21, 1, 1372476512, 15.31, 'docx', '6bac904d812138d70a0ce07a5f3667d7.docx', 'uploads/file/6bac904d812138d70a0ce07a5f3667d7.docx', 'yyy', 0, 0),
(22, 1, 1372487873, 10.54, 'jpg', 'b5fbba299c2117c22870f5758b379c81.jpg', 'uploads/image/b5fbba299c2117c22870f5758b379c81.jpg', '', 1, 0),
(26, 1, 1372492312, 89.35, 'jpeg', 'bb9768a155d16341667f8855a08a8c8f.jpeg', 'uploads/image/bb9768a155d16341667f8855a08a8c8f.jpeg', 'yyy', 1, 0),
(27, 1, 1372492445, 89.35, 'jpeg', '61fd3f0b4a6d2d34049d6315640e4518.jpeg', 'uploads/image/61fd3f0b4a6d2d34049d6315640e4518.jpeg', '7777', 1, 0),
(28, 1, 1372492484, 10.54, 'jpg', '5805b8bf9137b710a5c89c0f07cbb243.jpg', 'uploads/image/5805b8bf9137b710a5c89c0f07cbb243.jpg', '', 1, 0),
(29, 1, 1372492504, 89.35, 'jpeg', '3cbdcc48c28c05259ab7002c89e31013.jpeg', 'uploads/image/3cbdcc48c28c05259ab7002c89e31013.jpeg', '', 1, 0),
(30, 1, 1372492884, 89.35, 'jpeg', '205fc0213277b0d045f6a7589ad1d3ec.jpeg', 'uploads/image/205fc0213277b0d045f6a7589ad1d3ec.jpeg', '55', 1, 0),
(31, 1, 1372901225, 10.54, 'jpg', '203fb80e7bec54e75bf93cb4b9389b504fc26a06.jpg', 'uploads/image/3749c990dde58d54be86870695d6bfa1.jpg', '', 1, 0);

-- --------------------------------------------------------

--
-- 表的结构 `config`
--

CREATE TABLE IF NOT EXISTS `config` (
  `name` varchar(80) NOT NULL,
  `value` mediumtext NOT NULL,
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='论坛核心设置表';

--
-- 转存表中的数据 `config`
--

INSERT INTO `config` (`name`, `value`) VALUES
('closed', '1'),
('icp', 'dddd'),
('manager_email', 'xxz291917@163.com'),
('seo_index_description', ''),
('seo_index_keywords', ''),
('seo_index_title', '9tech首页标题'),
('seo_post_description', ''),
('seo_post_keywords', ''),
('seo_post_title', '9tech帖子页标题'),
('seo_topic_description', ''),
('seo_topic_keywords', ''),
('seo_topic_title', '9tech列表页标题'),
('site_name', '9tech'),
('statistic_code', '<script>alert(123);</script>');

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='积分日志表' AUTO_INCREMENT=428 ;

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
(134, 'extcredits2', 'admin_set', -112, '后台管理员设置', 1, 'xxz291917', 1368775202),
(135, 'extcredits1', 'post', 3, '发表主题', 1, 'xxz291917', 1369310155),
(136, 'extcredits2', 'post', 5, '发表主题', 1, 'xxz291917', 1369310155),
(137, 'extcredits3', 'post', 5, '发表主题', 1, 'xxz291917', 1369310155),
(138, 'extcredits1', 'post', 2, '发表主题', 1, 'xxz291917', 1369310199),
(139, 'extcredits2', 'post', 3, '发表主题', 1, 'xxz291917', 1369310199),
(140, 'extcredits3', 'post', 3, '发表主题', 1, 'xxz291917', 1369310199),
(141, 'extcredits1', 'post', 3, '发表主题', 1, 'xxz291917', 1369313698),
(142, 'extcredits2', 'post', 5, '发表主题', 1, 'xxz291917', 1369313698),
(143, 'extcredits3', 'post', 5, '发表主题', 1, 'xxz291917', 1369313698),
(144, 'extcredits1', 'post', 3, '发表主题', 1, 'xxz291917', 1369314292),
(145, 'extcredits2', 'post', 5, '发表主题', 1, 'xxz291917', 1369314292),
(146, 'extcredits3', 'post', 5, '发表主题', 1, 'xxz291917', 1369314292),
(147, 'extcredits1', 'post', 3, '发表主题', 1, 'xxz291917', 1369452030),
(148, 'extcredits2', 'post', 5, '发表主题', 1, 'xxz291917', 1369452030),
(149, 'extcredits3', 'post', 5, '发表主题', 1, 'xxz291917', 1369452030),
(150, 'extcredits1', 'post', 2, '发表主题', 1, 'xxz291917', 1369472789),
(151, 'extcredits2', 'post', 3, '发表主题', 1, 'xxz291917', 1369472789),
(152, 'extcredits3', 'post', 3, '发表主题', 1, 'xxz291917', 1369472789),
(153, 'extcredits1', 'reply', 4, '发表回复', 1, 'xxz291917', 1369476588),
(154, 'extcredits2', 'reply', 4, '发表回复', 1, 'xxz291917', 1369476588),
(155, 'extcredits3', 'reply', 4, '发表回复', 1, 'xxz291917', 1369476588),
(156, 'extcredits1', 'reply', 4, '发表回复', 1, 'xxz291917', 1369476618),
(157, 'extcredits2', 'reply', 4, '发表回复', 1, 'xxz291917', 1369476618),
(158, 'extcredits3', 'reply', 4, '发表回复', 1, 'xxz291917', 1369476618),
(159, 'extcredits1', 'reply', 4, '发表回复', 1, 'xxz291917', 1369624037),
(160, 'extcredits2', 'reply', 4, '发表回复', 1, 'xxz291917', 1369624037),
(161, 'extcredits3', 'reply', 4, '发表回复', 1, 'xxz291917', 1369624037),
(162, 'extcredits1', 'reply', 4, '发表回复', 1, 'xxz291917', 1369624075),
(163, 'extcredits2', 'reply', 4, '发表回复', 1, 'xxz291917', 1369624075),
(164, 'extcredits3', 'reply', 4, '发表回复', 1, 'xxz291917', 1369624075),
(165, 'extcredits1', 'reply', 4, '发表回复', 1, 'xxz291917', 1369625536),
(166, 'extcredits2', 'reply', 4, '发表回复', 1, 'xxz291917', 1369625536),
(167, 'extcredits3', 'reply', 4, '发表回复', 1, 'xxz291917', 1369625536),
(168, 'extcredits1', 'reply', 4, '发表回复', 1, 'xxz291917', 1369626059),
(169, 'extcredits2', 'reply', 4, '发表回复', 1, 'xxz291917', 1369626059),
(170, 'extcredits3', 'reply', 4, '发表回复', 1, 'xxz291917', 1369626059),
(171, 'extcredits1', 'reply', 4, '发表回复', 1, 'xxz291917', 1369714000),
(172, 'extcredits2', 'reply', 4, '发表回复', 1, 'xxz291917', 1369714000),
(173, 'extcredits3', 'reply', 4, '发表回复', 1, 'xxz291917', 1369714000),
(174, 'extcredits1', 'post', 3, '发表主题', 1, 'xxz291917', 1369740062),
(175, 'extcredits2', 'post', 4, '发表主题', 1, 'xxz291917', 1369740062),
(176, 'extcredits3', 'post', 6, '发表主题', 1, 'xxz291917', 1369740062),
(177, 'extcredits1', 'reply', 2, '发表回复', 1, 'xxz291917', 1369795605),
(178, 'extcredits2', 'reply', 2, '发表回复', 1, 'xxz291917', 1369795605),
(179, 'extcredits3', 'reply', 3, '发表回复', 1, 'xxz291917', 1369795605),
(180, 'extcredits1', 'post', 2, '发表主题', 1, 'xxz291917', 1369815311),
(181, 'extcredits2', 'post', 3, '发表主题', 1, 'xxz291917', 1369815311),
(182, 'extcredits3', 'post', 3, '发表主题', 1, 'xxz291917', 1369815311),
(183, 'extcredits1', 'reply', 4, '发表回复', 1, 'xxz291917', 1369815380),
(184, 'extcredits2', 'reply', 4, '发表回复', 1, 'xxz291917', 1369815380),
(185, 'extcredits3', 'reply', 4, '发表回复', 1, 'xxz291917', 1369815380),
(186, 'extcredits1', 'reply', 4, '发表回复', 1, 'xxz291917', 1369817179),
(187, 'extcredits2', 'reply', 4, '发表回复', 1, 'xxz291917', 1369817179),
(188, 'extcredits3', 'reply', 4, '发表回复', 1, 'xxz291917', 1369817179),
(189, 'extcredits1', 'reply', 4, '发表回复', 1, 'xxz291917', 1369818158),
(190, 'extcredits2', 'reply', 4, '发表回复', 1, 'xxz291917', 1369818158),
(191, 'extcredits3', 'reply', 4, '发表回复', 1, 'xxz291917', 1369818158),
(192, 'extcredits1', 'post', 2, '发表主题', 1, 'xxz291917', 1369819307),
(193, 'extcredits2', 'post', 3, '发表主题', 1, 'xxz291917', 1369819307),
(194, 'extcredits3', 'post', 3, '发表主题', 1, 'xxz291917', 1369819307),
(195, 'extcredits1', 'reply', 4, '发表回复', 1, 'xxz291917', 1369819367),
(196, 'extcredits2', 'reply', 4, '发表回复', 1, 'xxz291917', 1369819367),
(197, 'extcredits3', 'reply', 4, '发表回复', 1, 'xxz291917', 1369819367),
(198, 'extcredits1', 'reply', 4, '发表回复', 1, 'xxz291917', 1369893399),
(199, 'extcredits2', 'reply', 4, '发表回复', 1, 'xxz291917', 1369893399),
(200, 'extcredits3', 'reply', 4, '发表回复', 1, 'xxz291917', 1369893399),
(201, 'extcredits1', 'reply', 4, '发表回复', 1, 'xxz291917', 1369898357),
(202, 'extcredits2', 'reply', 4, '发表回复', 1, 'xxz291917', 1369898357),
(203, 'extcredits3', 'reply', 4, '发表回复', 1, 'xxz291917', 1369898357),
(204, 'extcredits1', 'reply', 4, '发表回复', 1, 'xxz291917', 1369899428),
(205, 'extcredits2', 'reply', 4, '发表回复', 1, 'xxz291917', 1369899428),
(206, 'extcredits3', 'reply', 4, '发表回复', 1, 'xxz291917', 1369899428),
(207, 'extcredits1', 'reply', 4, '发表回复', 1, 'xxz291917', 1369899454),
(208, 'extcredits2', 'reply', 4, '发表回复', 1, 'xxz291917', 1369899454),
(209, 'extcredits3', 'reply', 4, '发表回复', 1, 'xxz291917', 1369899454),
(210, 'extcredits1', 'reply', 4, '发表回复', 1, 'xxz291917', 1369899590),
(211, 'extcredits2', 'reply', 4, '发表回复', 1, 'xxz291917', 1369899590),
(212, 'extcredits3', 'reply', 4, '发表回复', 1, 'xxz291917', 1369899590),
(213, 'extcredits1', 'reply', 4, '发表回复', 1, 'xxz291917', 1369899791),
(214, 'extcredits2', 'reply', 4, '发表回复', 1, 'xxz291917', 1369899791),
(215, 'extcredits3', 'reply', 4, '发表回复', 1, 'xxz291917', 1369899791),
(216, 'extcredits1', 'reply', 4, '发表回复', 1, 'xxz291917', 1369903578),
(217, 'extcredits2', 'reply', 4, '发表回复', 1, 'xxz291917', 1369903578),
(218, 'extcredits3', 'reply', 4, '发表回复', 1, 'xxz291917', 1369903578),
(219, 'extcredits1', 'reply', 4, '发表回复', 1, 'xxz291917', 1369979898),
(220, 'extcredits2', 'reply', 4, '发表回复', 1, 'xxz291917', 1369979898),
(221, 'extcredits3', 'reply', 4, '发表回复', 1, 'xxz291917', 1369979898),
(222, 'extcredits2', 'reply', 1, '发表回复', 1, 'xxz291917', 1369988139),
(223, 'extcredits1', 'post', 3, '发表主题', 1, 'xxz291917', 1370233126),
(224, 'extcredits2', 'post', 4, '发表主题', 1, 'xxz291917', 1370233126),
(225, 'extcredits3', 'post', 6, '发表主题', 1, 'xxz291917', 1370233126),
(226, 'extcredits1', 'post', 3, '发表主题', 1, 'xxz291917', 1370319752),
(227, 'extcredits2', 'post', 4, '发表主题', 1, 'xxz291917', 1370319752),
(228, 'extcredits3', 'post', 6, '发表主题', 1, 'xxz291917', 1370319752),
(229, 'extcredits1', 'post', 3, '发表主题', 1, 'xxz291917', 1370335370),
(230, 'extcredits2', 'post', 4, '发表主题', 1, 'xxz291917', 1370335370),
(231, 'extcredits3', 'post', 6, '发表主题', 1, 'xxz291917', 1370335370),
(232, 'extcredits1', 'post', 3, '发表主题', 1, 'xxz291917', 1370397845),
(233, 'extcredits2', 'post', 4, '发表主题', 1, 'xxz291917', 1370397845),
(234, 'extcredits3', 'post', 6, '发表主题', 1, 'xxz291917', 1370397845),
(235, 'extcredits1', 'post', 3, '发表主题', 1, 'xxz291917', 1370398156),
(236, 'extcredits2', 'post', 4, '发表主题', 1, 'xxz291917', 1370398156),
(237, 'extcredits3', 'post', 6, '发表主题', 1, 'xxz291917', 1370398156),
(238, 'extcredits1', 'post', 3, '发表主题', 1, 'xxz291917', 1370418370),
(239, 'extcredits2', 'post', 4, '发表主题', 1, 'xxz291917', 1370418370),
(240, 'extcredits3', 'post', 6, '发表主题', 1, 'xxz291917', 1370418370),
(241, 'extcredits1', 'post', 2, '发表主题', 1, 'xxz291917', 1370585781),
(242, 'extcredits2', 'post', 3, '发表主题', 1, 'xxz291917', 1370585781),
(243, 'extcredits3', 'post', 3, '发表主题', 1, 'xxz291917', 1370585781),
(244, 'extcredits1', 'post', 2, '发表主题', 1, 'xxz291917', 1370586266),
(245, 'extcredits2', 'post', 3, '发表主题', 1, 'xxz291917', 1370586266),
(246, 'extcredits3', 'post', 3, '发表主题', 1, 'xxz291917', 1370586266),
(247, 'extcredits2', 'ask_action', -5, '发表问答扣减积分', 1, 'xxz291917', 1370662947),
(248, 'extcredits1', 'post', 3, '发表主题', 1, 'xxz291917', 1370662947),
(249, 'extcredits2', 'post', 4, '发表主题', 1, 'xxz291917', 1370662947),
(250, 'extcredits3', 'post', 6, '发表主题', 1, 'xxz291917', 1370662947),
(251, 'extcredits2', 'ask_action', -5, '发表问答扣减积分', 1, 'xxz291917', 1370662983),
(252, 'extcredits1', 'post', 3, '发表主题', 1, 'xxz291917', 1370662983),
(253, 'extcredits2', 'post', 4, '发表主题', 1, 'xxz291917', 1370662983),
(254, 'extcredits3', 'post', 6, '发表主题', 1, 'xxz291917', 1370662983),
(255, 'extcredits1', 'reply', 2, '发表回复', 1, 'xxz291917', 1370762810),
(256, 'extcredits2', 'reply', 2, '发表回复', 1, 'xxz291917', 1370762810),
(257, 'extcredits3', 'reply', 3, '发表回复', 1, 'xxz291917', 1370762810),
(258, 'extcredits1', 'reply', 2, '发表回复', 1, 'xxz291917', 1370766742),
(259, 'extcredits2', 'reply', 2, '发表回复', 1, 'xxz291917', 1370766742),
(260, 'extcredits3', 'reply', 3, '发表回复', 1, 'xxz291917', 1370766742),
(261, 'extcredits1', 'post', 2, '发表主题', 1, 'xxz291917', 1370770112),
(262, 'extcredits2', 'post', 3, '发表主题', 1, 'xxz291917', 1370770112),
(263, 'extcredits3', 'post', 3, '发表主题', 1, 'xxz291917', 1370770112),
(264, 'extcredits1', 'reply', 4, '发表回复', 1, 'xxz291917', 1370781275),
(265, 'extcredits2', 'reply', 4, '发表回复', 1, 'xxz291917', 1370781275),
(266, 'extcredits3', 'reply', 4, '发表回复', 1, 'xxz291917', 1370781275),
(267, 'extcredits1', 'reply', 4, '发表回复', 1, 'xxz291917', 1370781675),
(268, 'extcredits2', 'reply', 4, '发表回复', 1, 'xxz291917', 1370781675),
(269, 'extcredits3', 'reply', 4, '发表回复', 1, 'xxz291917', 1370781675),
(270, 'extcredits1', 'reply', 4, '发表回复', 1, 'xxz291917', 1370781961),
(271, 'extcredits2', 'reply', 4, '发表回复', 1, 'xxz291917', 1370781961),
(272, 'extcredits3', 'reply', 4, '发表回复', 1, 'xxz291917', 1370781961),
(273, 'extcredits2', 'ask_action', -20, '发表问答扣减积分', 1, 'xxz291917', 1370782056),
(274, 'extcredits1', 'post', 2, '发表主题', 1, 'xxz291917', 1370782056),
(275, 'extcredits2', 'post', 3, '发表主题', 1, 'xxz291917', 1370782056),
(276, 'extcredits3', 'post', 3, '发表主题', 1, 'xxz291917', 1370782056),
(277, 'extcredits1', 'reply', 2, '发表回复', 1, 'xxz291917', 1371097739),
(278, 'extcredits2', 'reply', 2, '发表回复', 1, 'xxz291917', 1371097739),
(279, 'extcredits3', 'reply', 3, '发表回复', 1, 'xxz291917', 1371097739),
(280, 'extcredits1', 'reply', 2, '发表回复', 1, 'xxz291917', 1371097751),
(281, 'extcredits2', 'reply', 2, '发表回复', 1, 'xxz291917', 1371097751),
(282, 'extcredits3', 'reply', 3, '发表回复', 1, 'xxz291917', 1371097751),
(283, 'extcredits1', 'reply', 2, '发表回复', 1, 'xxz291917', 1371097756),
(284, 'extcredits2', 'reply', 2, '发表回复', 1, 'xxz291917', 1371097756),
(285, 'extcredits3', 'reply', 3, '发表回复', 1, 'xxz291917', 1371097756),
(286, 'extcredits1', 'reply', 2, '发表回复', 1, 'xxz291917', 1371097762),
(287, 'extcredits2', 'reply', 2, '发表回复', 1, 'xxz291917', 1371097762),
(288, 'extcredits3', 'reply', 3, '发表回复', 1, 'xxz291917', 1371097762),
(289, 'extcredits1', 'reply', 2, '发表回复', 1, 'xxz291917', 1371097769),
(290, 'extcredits2', 'reply', 2, '发表回复', 1, 'xxz291917', 1371097769),
(291, 'extcredits3', 'reply', 3, '发表回复', 1, 'xxz291917', 1371097769),
(292, 'extcredits1', 'reply', 2, '发表回复', 1, 'xxz291917', 1371097775),
(293, 'extcredits2', 'reply', 2, '发表回复', 1, 'xxz291917', 1371097775),
(294, 'extcredits3', 'reply', 3, '发表回复', 1, 'xxz291917', 1371097775),
(295, 'extcredits2', 'reply', 1, '发表回复', 1, 'xxz291917', 1371105016),
(296, 'extcredits1', 'post', 2, '发表主题', 1, 'xxz291917', 1371702544),
(297, 'extcredits2', 'post', 3, '发表主题', 1, 'xxz291917', 1371702544),
(298, 'extcredits3', 'post', 3, '发表主题', 1, 'xxz291917', 1371702544),
(299, 'extcredits1', 'post', 2, '发表主题', 1, 'xxz291917', 1371726788),
(300, 'extcredits2', 'post', 3, '发表主题', 1, 'xxz291917', 1371726788),
(301, 'extcredits3', 'post', 3, '发表主题', 1, 'xxz291917', 1371726788),
(302, 'extcredits2', 'ask_action', -4, '发表问答扣减积分', 1, 'xxz291917', 1371807011),
(303, 'extcredits1', 'post', 2, '发表主题', 1, 'xxz291917', 1371807011),
(304, 'extcredits2', 'post', 3, '发表主题', 1, 'xxz291917', 1371807011),
(305, 'extcredits3', 'post', 3, '发表主题', 1, 'xxz291917', 1371807011),
(306, 'extcredits1', 'post', 2, '发表主题', 1, 'xxz291917', 1371972423),
(307, 'extcredits2', 'post', 3, '发表主题', 1, 'xxz291917', 1371972423),
(308, 'extcredits3', 'post', 3, '发表主题', 1, 'xxz291917', 1371972423),
(309, 'extcredits1', 'post', 2, '发表主题', 1, 'xxz291917', 1371977989),
(310, 'extcredits2', 'post', 3, '发表主题', 1, 'xxz291917', 1371977989),
(311, 'extcredits3', 'post', 3, '发表主题', 1, 'xxz291917', 1371977989),
(312, 'extcredits1', 'post', 2, '发表主题', 1, 'xxz291917', 1371978022),
(313, 'extcredits2', 'post', 3, '发表主题', 1, 'xxz291917', 1371978022),
(314, 'extcredits3', 'post', 3, '发表主题', 1, 'xxz291917', 1371978022),
(315, 'extcredits2', 'reply', 1, '发表回复', 1, 'xxz291917', 1372139708),
(316, 'extcredits2', 'reply', 1, '发表回复', 1, 'xxz291917', 1372139903),
(317, 'extcredits2', 'reply', 1, '发表回复', 1, 'xxz291917', 1372139977),
(318, 'extcredits2', 'reply', 1, '发表回复', 1, 'xxz291917', 1372140208),
(319, 'extcredits2', 'reply', 1, '发表回复', 1, 'xxz291917', 1372142466),
(320, 'extcredits2', 'reply', 1, '发表回复', 1, 'xxz291917', 1372142906),
(321, 'extcredits2', 'reply', 1, '发表回复', 1, 'xxz291917', 1372143237),
(322, 'extcredits2', 'reply', 1, '发表回复', 1, 'xxz291917', 1372143607),
(323, 'extcredits2', 'reply', 1, '发表回复', 1, 'xxz291917', 1372143618),
(324, 'extcredits2', 'reply', 1, '发表回复', 1, 'xxz291917', 1372143670),
(325, 'extcredits2', 'reply', 1, '发表回复', 1, 'xxz291917', 1372211834),
(326, 'extcredits2', 'reply', 1, '发表回复', 1, 'xxz291917', 1372232414),
(327, 'extcredits1', 'post', 2, '发表主题', 1, 'xxz291917', 1372247353),
(328, 'extcredits2', 'post', 3, '发表主题', 1, 'xxz291917', 1372247353),
(329, 'extcredits3', 'post', 3, '发表主题', 1, 'xxz291917', 1372247353),
(330, 'extcredits1', 'reply', 4, '发表回复', 1, 'xxz291917', 1372297586),
(331, 'extcredits2', 'reply', 4, '发表回复', 1, 'xxz291917', 1372297586),
(332, 'extcredits3', 'reply', 4, '发表回复', 1, 'xxz291917', 1372297586),
(333, 'extcredits1', 'reply', 4, '发表回复', 1, 'xxz291917', 1372304277),
(334, 'extcredits2', 'reply', 4, '发表回复', 1, 'xxz291917', 1372304277),
(335, 'extcredits3', 'reply', 4, '发表回复', 1, 'xxz291917', 1372304277),
(336, 'extcredits1', 'reply', 4, '发表回复', 1, 'xxz291917', 1372312389),
(337, 'extcredits2', 'reply', 4, '发表回复', 1, 'xxz291917', 1372312389),
(338, 'extcredits3', 'reply', 4, '发表回复', 1, 'xxz291917', 1372312389),
(339, 'extcredits1', 'post', 2, '发表主题', 1, 'xxz291917', 1372312851),
(340, 'extcredits2', 'post', 3, '发表主题', 1, 'xxz291917', 1372312851),
(341, 'extcredits3', 'post', 3, '发表主题', 1, 'xxz291917', 1372312851),
(342, 'extcredits1', 'reply', 4, '发表回复', 1, 'xxz291917', 1372313414),
(343, 'extcredits2', 'reply', 4, '发表回复', 1, 'xxz291917', 1372313414),
(344, 'extcredits3', 'reply', 4, '发表回复', 1, 'xxz291917', 1372313414),
(345, 'extcredits1', 'reply', 4, '发表回复', 1, 'xxz291917', 1372313433),
(346, 'extcredits2', 'reply', 4, '发表回复', 1, 'xxz291917', 1372313433),
(347, 'extcredits3', 'reply', 4, '发表回复', 1, 'xxz291917', 1372313433),
(348, 'extcredits1', 'reply', 4, '发表回复', 1, 'xxz291917', 1372313467),
(349, 'extcredits2', 'reply', 4, '发表回复', 1, 'xxz291917', 1372313467),
(350, 'extcredits3', 'reply', 4, '发表回复', 1, 'xxz291917', 1372313467),
(351, 'extcredits1', 'reply', 4, '发表回复', 1, 'xxz291917', 1372315193),
(352, 'extcredits2', 'reply', 4, '发表回复', 1, 'xxz291917', 1372315193),
(353, 'extcredits3', 'reply', 4, '发表回复', 1, 'xxz291917', 1372315193),
(354, 'extcredits2', 'reply', 1, '发表回复', 1, 'xxz291917', 1372316668),
(355, 'extcredits2', 'post', 2, '发表主题', 1, 'xxz291917', 1372317871),
(356, 'extcredits2', 'reply', 1, '发表回复', 1, 'xxz291917', 1372320821),
(357, 'extcredits2', 'reply', 1, '发表回复', 1, 'xxz291917', 1372320844),
(358, 'extcredits1', 'reply', 4, '发表回复', 1, 'xxz291917', 1372331494),
(359, 'extcredits2', 'reply', 4, '发表回复', 1, 'xxz291917', 1372331494),
(360, 'extcredits3', 'reply', 4, '发表回复', 1, 'xxz291917', 1372331494),
(361, 'extcredits2', 'post', 2, '发表主题', 1, 'xxz291917', 1372409705),
(362, 'extcredits2', 'post', 2, '发表主题', 1, 'xxz291917', 1372409831),
(363, 'extcredits2', 'post', 2, '发表主题', 1, 'xxz291917', 1372411442),
(364, 'extcredits2', 'post', 2, '发表主题', 1, 'xxz291917', 1372411535),
(365, 'extcredits1', 'post', 2, '发表主题', 1, 'xxz291917', 1372491400),
(366, 'extcredits2', 'post', 3, '发表主题', 1, 'xxz291917', 1372491400),
(367, 'extcredits3', 'post', 3, '发表主题', 1, 'xxz291917', 1372491400),
(368, 'extcredits2', 'post', 2, '发表主题', 1, 'xxz291917', 1372645276),
(369, 'extcredits2', 'reply', 1, '发表回复', 1, 'xxz291917', 1372649054),
(370, 'extcredits2', 'post', 2, '发表主题', 1, 'xxz291917', 1372665723),
(371, 'extcredits1', 'reply', 2, '发表回复', 1, 'xxz291917', 1372670768),
(372, 'extcredits2', 'reply', 2, '发表回复', 1, 'xxz291917', 1372670768),
(373, 'extcredits3', 'reply', 3, '发表回复', 1, 'xxz291917', 1372670768),
(374, 'extcredits1', 'post', 2, '发表主题', 1, 'xxz291917', 1372670946),
(375, 'extcredits2', 'post', 3, '发表主题', 1, 'xxz291917', 1372670946),
(376, 'extcredits3', 'post', 3, '发表主题', 1, 'xxz291917', 1372670946),
(377, 'extcredits1', 'reply', 4, '发表回复', 1, 'xxz291917', 1372670967),
(378, 'extcredits2', 'reply', 4, '发表回复', 1, 'xxz291917', 1372670967),
(379, 'extcredits3', 'reply', 4, '发表回复', 1, 'xxz291917', 1372670967),
(380, 'extcredits1', 'reply', 4, '发表回复', 1, 'xxz291917', 1372670987),
(381, 'extcredits2', 'reply', 4, '发表回复', 1, 'xxz291917', 1372670987),
(382, 'extcredits3', 'reply', 4, '发表回复', 1, 'xxz291917', 1372670987),
(383, 'extcredits1', 'reply', 4, '发表回复', 1, 'xxz291917', 1372671031),
(384, 'extcredits2', 'reply', 4, '发表回复', 1, 'xxz291917', 1372671031),
(385, 'extcredits3', 'reply', 4, '发表回复', 1, 'xxz291917', 1372671031),
(386, 'extcredits1', 'post', 2, '发表主题', 1, 'xxz291917', 1372737971),
(387, 'extcredits2', 'post', 3, '发表主题', 1, 'xxz291917', 1372737971),
(388, 'extcredits3', 'post', 3, '发表主题', 1, 'xxz291917', 1372737971),
(389, 'extcredits2', 'post', 2, '发表主题', 1, 'xxz291917', 1372744686),
(390, 'extcredits1', 'post', 2, '发表主题', 1, 'xxz291917', 1372767152),
(391, 'extcredits2', 'post', 3, '发表主题', 1, 'xxz291917', 1372767152),
(392, 'extcredits3', 'post', 3, '发表主题', 1, 'xxz291917', 1372767152),
(393, 'extcredits1', 'reply', 4, '发表回复', 1, 'xxz291917', 1372767301),
(394, 'extcredits2', 'reply', 4, '发表回复', 1, 'xxz291917', 1372767301),
(395, 'extcredits3', 'reply', 4, '发表回复', 1, 'xxz291917', 1372767301),
(396, 'extcredits1', 'reply', 4, '发表回复', 1, 'xxz291917', 1372767310),
(397, 'extcredits2', 'reply', 4, '发表回复', 1, 'xxz291917', 1372767310),
(398, 'extcredits3', 'reply', 4, '发表回复', 1, 'xxz291917', 1372767310),
(399, 'extcredits1', 'reply', 4, '发表回复', 1, 'xxz291917', 1372767369),
(400, 'extcredits2', 'reply', 4, '发表回复', 1, 'xxz291917', 1372767369),
(401, 'extcredits3', 'reply', 4, '发表回复', 1, 'xxz291917', 1372767369),
(402, 'extcredits2', 'ask_action', -6, '发表问答扣减积分', 1, 'xxz291917', 1372769377),
(403, 'extcredits1', 'post', 2, '发表主题', 1, 'xxz291917', 1372769377),
(404, 'extcredits2', 'post', 3, '发表主题', 1, 'xxz291917', 1372769377),
(405, 'extcredits3', 'post', 3, '发表主题', 1, 'xxz291917', 1372769377),
(406, 'extcredits1', 'reply', 4, '发表回复', 1, 'xxz291917', 1372769397),
(407, 'extcredits2', 'reply', 4, '发表回复', 1, 'xxz291917', 1372769397),
(408, 'extcredits3', 'reply', 4, '发表回复', 1, 'xxz291917', 1372769397),
(409, 'extcredits1', 'reply', 4, '发表回复', 1, 'xxz291917', 1372769422),
(410, 'extcredits2', 'reply', 4, '发表回复', 1, 'xxz291917', 1372769422),
(411, 'extcredits3', 'reply', 4, '发表回复', 1, 'xxz291917', 1372769422),
(412, 'extcredits2', 'ask_action', -5, '发表问答扣减积分', 1, 'xxz291917', 1372829309),
(413, 'extcredits1', 'post', 2, '发表主题', 1, 'xxz291917', 1372829309),
(414, 'extcredits2', 'post', 3, '发表主题', 1, 'xxz291917', 1372829309),
(415, 'extcredits3', 'post', 3, '发表主题', 1, 'xxz291917', 1372829309),
(416, 'extcredits1', 'reply', 4, '发表回复', 1, 'xxz291917', 1372829324),
(417, 'extcredits2', 'reply', 4, '发表回复', 1, 'xxz291917', 1372829324),
(418, 'extcredits3', 'reply', 4, '发表回复', 1, 'xxz291917', 1372829324),
(419, 'extcredits1', 'reply', 4, '发表回复', 1, 'xxz291917', 1372829339),
(420, 'extcredits2', 'reply', 4, '发表回复', 1, 'xxz291917', 1372829339),
(421, 'extcredits3', 'reply', 4, '发表回复', 1, 'xxz291917', 1372829339),
(422, 'extcredits2', 'best_answer', 5, 'best_answer', 1, 'xxz291917', 1372829420),
(423, 'extcredits2', 'best_answer', 5, 'best_answer', 1, 'xxz291917', 1372829438),
(424, 'extcredits2', 'best_answer', 5, 'best_answer', 1, 'xxz291917', 1372829450),
(425, 'extcredits1', 'reply', 2, '发表回复', 1, 'xxz291917', 1372906277),
(426, 'extcredits2', 'reply', 2, '发表回复', 1, 'xxz291917', 1372906277),
(427, 'extcredits3', 'reply', 3, '发表回复', 1, 'xxz291917', 1372906277);

-- --------------------------------------------------------

--
-- 表的结构 `credit_name`
--

CREATE TABLE IF NOT EXISTS `credit_name` (
  `credit_x` varchar(12) NOT NULL,
  `view_name` varchar(20) NOT NULL,
  `icon` varchar(200) NOT NULL COMMENT '积分图标',
  `unit` varchar(20) NOT NULL COMMENT '积分单位',
  `status` tinyint(4) NOT NULL COMMENT '状态0：不启用，1启用',
  PRIMARY KEY (`credit_x`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `credit_name`
--

INSERT INTO `credit_name` (`credit_x`, `view_name`, `icon`, `unit`, `status`) VALUES
('extcredits1', '威望', '110', '', 1),
('extcredits2', '金钱', '220', '两', 1),
('extcredits3', '贡献', '330', '', 1);

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
-- 表的结构 `debate`
--

CREATE TABLE IF NOT EXISTS `debate` (
  `topic_id` mediumint(8) unsigned NOT NULL DEFAULT '0' COMMENT '主题id',
  `user_id` mediumint(8) unsigned NOT NULL DEFAULT '0' COMMENT '发表用户id',
  `start_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '辩论开始时间',
  `end_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '辩论结束时间',
  `affirm_debaters` mediumint(8) unsigned NOT NULL DEFAULT '0' COMMENT '正方人数',
  `negate_debaters` mediumint(8) unsigned NOT NULL DEFAULT '0' COMMENT '反方人数',
  `affirm_votes` mediumint(8) unsigned NOT NULL DEFAULT '0' COMMENT '正方得票数',
  `negate_votes` mediumint(8) unsigned NOT NULL DEFAULT '0' COMMENT '反方得票数',
  `umpire` varchar(15) NOT NULL DEFAULT '' COMMENT '裁判用户名',
  `winner` tinyint(1) NOT NULL DEFAULT '0' COMMENT '获胜方 (0:平局 1:为正方 2:为反方) 裁判评判结果',
  `best_debater` varchar(50) NOT NULL DEFAULT '' COMMENT '最佳辩手用户名',
  `affirm_point` varchar(1500) NOT NULL COMMENT '正方观点',
  `negate_point` varchar(1500) NOT NULL COMMENT '反方观点',
  `umpire_point` varchar(1500) NOT NULL COMMENT '裁判观点，裁判结束辩论时填写',
  `affirm_voterids` text NOT NULL COMMENT '正方投票人的 id 集合',
  `negate_voterids` text NOT NULL COMMENT '反方投票人的 id 集合',
  `affirm_replies` mediumint(8) unsigned NOT NULL COMMENT '正方回复次数，用来翻页',
  `negate_replies` mediumint(8) unsigned NOT NULL COMMENT '反方回复次数，用来翻页',
  PRIMARY KEY (`topic_id`),
  KEY `uid` (`user_id`,`start_time`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='辩论主题帖';

--
-- 转存表中的数据 `debate`
--

INSERT INTO `debate` (`topic_id`, `user_id`, `start_time`, `end_time`, `affirm_debaters`, `negate_debaters`, `affirm_votes`, `negate_votes`, `umpire`, `winner`, `best_debater`, `affirm_point`, `negate_point`, `umpire_point`, `affirm_voterids`, `negate_voterids`, `affirm_replies`, `negate_replies`) VALUES
(31, 1, 1370319752, 0, 0, 0, 0, 0, 'xxz291917', 0, '', 'errrrrrrrrrrrrrrr', 'errrrrrrrrrrrrrrrerrrrrrrrrrrrrrrrerrrrrrrrrrrrrrrr', '', '', '', 0, 0),
(35, 1, 1370397845, 1371052800, 0, 0, 0, 0, 'xxz291917', 0, '', 'sdfsfd', 'fffff', '', '', '', 0, 0),
(44, 1, 1370770112, 1370448000, 1, 0, 0, 0, 'xxz291917', 0, '', '学智测试2222', '学智测试辩论22244444', '', '', '', 1, 0),
(49, 1, 1371972423, 1370966400, 0, 0, 0, 0, 'xxz291917', 0, '', '红星闪闪放光芒', '红星闪闪放光芒', '', '', '', 0, 0),
(53, 1, 1372312851, 1372850826, 0, 256, 151, 256, 'xxz291917', 1, 'xxz5291917', '红星闪闪放光', '红星闪闪放光芒', 'asdasdasdasdasd', ',1', '', 0, 1);

-- --------------------------------------------------------

--
-- 表的结构 `debate_posts`
--

CREATE TABLE IF NOT EXISTS `debate_posts` (
  `post_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '帖子id',
  `topic_id` mediumint(8) unsigned NOT NULL DEFAULT '0' COMMENT '主题id',
  `user_id` mediumint(8) unsigned NOT NULL DEFAULT '0' COMMENT '作者',
  `stand` tinyint(1) NOT NULL DEFAULT '0' COMMENT '立场 (0:中立 1:正方 2:为反方)',
  `post_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '发表的时间',
  `voters` mediumint(10) unsigned NOT NULL DEFAULT '0' COMMENT '投票人数',
  PRIMARY KEY (`post_id`),
  KEY `pid` (`post_id`,`stand`),
  KEY `tid` (`topic_id`,`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `debate_posts`
--

INSERT INTO `debate_posts` (`post_id`, `topic_id`, `user_id`, `stand`, `post_time`, `voters`) VALUES
(90, 44, 1, 1, 1372304213, 1),
(130, 53, 1, 0, 1372331740, 0);

-- --------------------------------------------------------

--
-- 表的结构 `drafts`
--

CREATE TABLE IF NOT EXISTS `drafts` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '所属用户id',
  `topic_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '所属主题id',
  `forum_id` mediumint(8) unsigned NOT NULL DEFAULT '0' COMMENT '所属版块id',
  `special` tinyint(3) unsigned NOT NULL,
  `subject` varchar(80) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL DEFAULT '' COMMENT '草稿主题',
  `content` mediumtext CHARACTER SET utf8 COLLATE utf8_bin NOT NULL COMMENT '草稿内容',
  `remain_data` varchar(3000) NOT NULL,
  `time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '保存时间',
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

--
-- 转存表中的数据 `drafts`
--

INSERT INTO `drafts` (`id`, `user_id`, `topic_id`, `forum_id`, `special`, `subject`, `content`, `remain_data`, `time`) VALUES
(3, 1, 0, 11, 0, '', '', '{"category":"0","affirm_point":"\\u7ea2\\u661f\\u95ea\\u95ea\\u653e\\u5149\\u8292","negate_point":"\\u7ea2\\u661f\\u95ea\\u95ea\\u653e\\u5149\\u8292","end_time":"2013-06-21","umpire":"","tags":"\\u6807\\u7b7e\\u95f4\\u8bf7\\u7528''\\u7a7a\\u683c''\\u6216''\\u9017\\u53f7''\\u9694\\u5f00\\uff0c\\u6700\\u591a\\u53ef\\u6dfb\\u52a05\\u4e2a\\u6807\\u7b7e\\u3002","forum_id":"11"}', 1372154734),
(4, 1, 0, 0, 0, '输入问答概述', 0x797472797472797472797472797275797279747279, '{"editcategory":"0","price":"","tags":"\\u6807\\u7b7e\\u95f4\\u8bf7\\u7528''\\u7a7a\\u683c''\\u6216''\\u9017\\u53f7''\\u9694\\u5f00\\uff0c\\u6700\\u591a\\u53ef\\u6dfb\\u52a05\\u4e2a\\u6807\\u7b7e\\u3002"}', 1371732422),
(5, 1, 0, 0, 2, '$post', 0x24706f737424703c7374726f6e673e6f73743c2f7374726f6e673e3c7374726f6e673e24706f73743c2f7374726f6e673e3c7374726f6e673e24706f73743c2f7374726f6e673e3c7374726f6e673e24706f3c2f7374726f6e673e737424706f73747b3a325f33373a7d, '{"editcategory":"0","price":"4","tags":"test \\u767d\\u8272,,hongse,,   sfsl  sdfsdf"}', 1371732613),
(7, 1, 13, 0, 1, '输入帖子标题', 0xe5a3abe5a4a7e5a4abe5a3abe5a4a7e5a4ab, '{"topic_id":"13"}', 1372144135);

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
  `is_category` tinyint(4) NOT NULL COMMENT '是否启用主题分类',
  `is_cat_necessary` tinyint(4) NOT NULL COMMENT '主题分类是否必选',
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
  `redirect` int(11) NOT NULL DEFAULT '0' COMMENT '可以重定向某个版块',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '显示状态 (1正常,0关闭)',
  PRIMARY KEY (`id`),
  KEY `forum` (`status`,`type`,`display_order`),
  KEY `fup_type` (`parent_id`,`type`,`display_order`),
  KEY `fup` (`parent_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='论坛版块' AUTO_INCREMENT=18 ;

--
-- 转存表中的数据 `forums`
--

INSERT INTO `forums` (`id`, `parent_id`, `type`, `name`, `description`, `icon`, `manager`, `display_order`, `create_user`, `create_user_id`, `create_time`, `allow_special`, `is_category`, `is_cat_necessary`, `is_anonymous`, `is_html`, `is_bbcode`, `is_smilies`, `is_media`, `check`, `allow_visit`, `allow_read`, `allow_post`, `allow_reply`, `allow_upload`, `allow_download`, `seo_title`, `seo_keywords`, `seo_description`, `credit_setting`, `redirect`, `status`) VALUES
(1, 0, 'group', 'Flash RIA', '测试新分类', '', 'dsdff', 1, '', 0, 0, '', 0, 0, 0, 0, 0, 0, 0, 0, '1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19', '1,2,3,4,6,7', '1,2,3,4,5,6', '1,2,3,4,5,9,10', '1,2,3', '1,2,3', '论坛seo', '', '', '{"post":{"extcredits1":"3","extcredits2":"4","extcredits3":"5"},"reply":{"extcredits1":"","extcredits2":"6","extcredits3":""},"digest":{"extcredits1":"","extcredits2":"7","extcredits3":""},"postattach":{"extcredits1":"","extcredits2":"8","extcredits3":""},"getattach":{"extcredits1":"","extcredits2":"","extcredits3":""},"daylogin":{"extcredits1":"","extcredits2":"","extcredits3":""},"search":{"extcredits1":"","extcredits2":"","extcredits3":""}}', 0, 1),
(2, 1, 'forum', 'Flex', '测试默认版块', '', 'xxz291917', 2, '', 0, 0, '1,2', 0, 0, 0, 1, 1, 0, 0, 0, '1,2,3,16,17,18,19,10,11,12,13,14,15', '1,2,3,16,17,18,19,10,11,12,13,14,15', '1,2,3,16,17,18,19,10,11,12,13,14,15', '1,2,3,16,17,18,19,10,11,12,13,14,15', '1,2,3,16,17,18,19,10,11,12,13,14,15', '1,2,3,16,17,18,19,10,11,12,13,14,15', '', '', '', '{"post":{"extcredits1":"3","extcredits2":"4","extcredits3":"6"},"reply":{"extcredits1":"2","extcredits2":"2","extcredits3":"3"},"digest":{"extcredits1":"","extcredits2":"","extcredits3":""},"postattach":{"extcredits1":"","extcredits2":"","extcredits3":""},"getattach":{"extcredits1":"0","extcredits2":"5","extcredits3":"4"},"daylogin":{"extcredits1":"","extcredits2":"","extcredits3":""},"search":{"extcredits1":"","extcredits2":"","extcredits3":""}}', 0, 0),
(4, 0, 'group', '口水天下', '测试版块内容哦测试版块内容哦测试版块内容哦测试版块内容哦测试版块内容哦测试版块内容哦测试版块内容哦', '', 'admin', 5, '', 0, 0, '2,3', 0, 0, 0, 1, 1, 1, 1, 2, '', '', '', '', '', '', '论坛seo', '论坛seo 论坛seo', '论坛seo论坛seo论坛seo论坛seo论坛seo论坛seo', '', 0, 1),
(6, 2, 'sub', '口水天下', '', '', '', 0, '', 0, 0, '', 0, 0, 0, 0, 0, 0, 0, 2, '1,2', '1,2', '1,2', '1,2', '1,2', '1,2', '', '', '', '{"post":{"extcredits1":"3","extcredits2":"5","extcredits3":"5"},"reply":{"extcredits1":"","extcredits2":"","extcredits3":""},"digest":{"extcredits1":"","extcredits2":"","extcredits3":""},"postattach":{"extcredits1":"","extcredits2":"","extcredits3":""},"getattach":{"extcredits1":"","extcredits2":"","extcredits3":""},"daylogin":{"extcredits1":"","extcredits2":"","extcredits3":""},"search":{"extcredits1":"","extcredits2":"","extcredits3":""}}', 0, 1),
(10, 0, 'group', '综合交流', '', '', '', 2, '', 0, 0, '', 0, 0, 0, 0, 0, 0, 0, 0, '', '', '', '', '', '', '', '', '', '', 0, 0),
(11, 1, 'forum', 'ActionScript 3', 'ttt', 'uploads/icon/9c2d991ae95c6eab3af12bf7853e4691_s.jpg', 'xxz291917', 0, 'xxz291917', 1, 1367912803, '', 1, 0, 0, 0, 0, 0, 0, 2, '', '', '', '', '', '', '', '', '', '{"post":{"extcredits1":"2","extcredits2":"3","extcredits3":"3"},"reply":{"extcredits1":"4","extcredits2":"4","extcredits3":"4"},"digest":{"extcredits1":"4","extcredits2":"3","extcredits3":"3"},"postattach":{"extcredits1":"","extcredits2":"","extcredits3":""},"getattach":{"extcredits1":"","extcredits2":"","extcredits3":""},"daylogin":{"extcredits1":"","extcredits2":"","extcredits3":""},"search":{"extcredits1":"","extcredits2":"","extcredits3":""}}', 0, 0),
(12, 10, 'forum', '问答求助', '', '', '', 0, 'xxz291917', 1, 1368584217, '', 0, 0, 0, 0, 0, 0, 0, 0, '', '', '', '', '', '', '', '', '', '', 0, 0),
(13, 1, 'forum', 'Flash 3D', '', '', '', 0, 'xxz291917', 1, 1371785369, '', 0, 0, 0, 0, 0, 0, 0, 0, '', '', '', '', '', '', '', '', '', '', 0, 0),
(14, 10, 'forum', '口水天下', '', '', '', 0, 'xxz291917', 1, 1371785408, '', 0, 0, 0, 0, 0, 0, 0, 0, '', '', '', '', '', '', '', '', '', '', 4, 0),
(15, 10, 'forum', '活动专区', '', '', '', 0, 'xxz291917', 1, 1371785408, '', 0, 0, 0, 0, 0, 0, 0, 0, '', '', '', '', '', '', '', '', '', '', 0, 0),
(16, 4, 'forum', 'AIR', '', '', '', 0, 'xxz291917', 1, 1371785444, '', 0, 0, 0, 0, 0, 0, 0, 0, '', '', '', '', '', '', '', '', '', '', 0, 0),
(17, 11, 'sub', 'sdfsdf', '士大夫', 'uploads/icon/30548c2b89bf24036297e69cfd81a985_s.jpg', '发士大夫', 0, 'xxz291917', 1, 1372663741, '', 0, 0, 0, 0, 0, 0, 0, 0, '', '', '', '', '', '', '', '', '', '', 0, 0);

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
(2, 31, 14, 1, 2, 23, 1372906277, 'xxz291917'),
(6, 8, 5, 1, 1, 21, 1369452030, 'xxz291917'),
(10, 1, 1, 1, 1, 15, 1368772328, 'xxz5291917'),
(11, 70, 24, 3, 1, 68, 1372829339, 'xxz291917'),
(12, 37, 8, 2, 1, 61, 1372649054, 'xxz291917'),
(13, 1, 1, 1, 1, 62, 1372665723, 'xxz291917'),
(16, 1, 1, 1, 1, 65, 1372744686, 'xxz291917');

-- --------------------------------------------------------

--
-- 表的结构 `groups`
--

CREATE TABLE IF NOT EXISTS `groups` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `type` enum('system','special','member') NOT NULL,
  `name` varchar(80) NOT NULL COMMENT '用户组名称',
  `icon` varchar(255) NOT NULL COMMENT '等级图片号',
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
(9, 'member', '限制会员', 'uploads/icon/6099cf655da8573567bf4a069496863c_s.jpg', -99999, 0, 1, 0, 1, 1, 0, 0, 0, '', 0, 0, 0, 0, 0, 0, 1, 1, 1, 0, 0, 0, 0, ''),
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
-- 表的结构 `medals`
--

CREATE TABLE IF NOT EXISTS `medals` (
  `id` smallint(6) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键id',
  `name` varchar(50) NOT NULL DEFAULT '' COMMENT '勋章名称',
  `image` varchar(255) NOT NULL DEFAULT '' COMMENT '勋章图片',
  `type` tinyint(1) NOT NULL DEFAULT '0' COMMENT '勋章类型',
  `display_order` tinyint(3) NOT NULL DEFAULT '0' COMMENT '显示顺序',
  `description` varchar(255) NOT NULL COMMENT '勋章描述',
  `expired_time` smallint(6) unsigned NOT NULL DEFAULT '0' COMMENT '过期时间',
  `condition` mediumtext NOT NULL COMMENT '勋章获得条件',
  `credit` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '勋章购买使用积分',
  `price` mediumint(8) unsigned NOT NULL DEFAULT '0' COMMENT '勋章价格',
  `is_open` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否启用',
  PRIMARY KEY (`id`),
  KEY `displayorder` (`display_order`),
  KEY `available` (`is_open`,`display_order`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='勋章表' AUTO_INCREMENT=11 ;

--
-- 转存表中的数据 `medals`
--

INSERT INTO `medals` (`id`, `name`, `image`, `type`, `display_order`, `description`, `expired_time`, `condition`, `credit`, `price`, `is_open`) VALUES
(1, '最佳新人', 'medal1.gif', 0, 0, '注册账号后积极发帖的会员', 65535, 'extcredits2 > 100 and topics >= 50', 0, 0, 1),
(2, '活跃会员', 'medal2.gif', 0, 0, '经常参与各类话题的讨论，发帖内容较有主见', 0, '', 0, 0, 0),
(3, '热心会员', 'medal3.gif', 0, 0, '经常帮助其他会员答疑', 0, '', 0, 0, 0),
(4, '推广达人', 'medal4.gif', 0, 0, '积极宣传本站，为本站带来更多注册会员', 0, '', 0, 0, 0),
(5, '宣传达人', 'medal5.gif', 0, 0, '积极宣传本站，为本站带来更多的用户访问量', 0, '', 0, 0, 0),
(6, '灌水之王', 'medal6.gif', 0, 0, '经常在论坛发帖，且发帖量较大', 0, '', 0, 0, 0),
(7, '突出贡献', 'medal7.gif', 0, 0, '长期对论坛的繁荣而不断努力，或多次提出建设性意见', 0, '', 0, 0, 1),
(8, '优秀版主', 'medal8.gif', 0, 0, '活跃且尽责职守的版主', 0, '', 0, 0, 1),
(9, '荣誉管理', 'medal9.gif', 0, 0, '曾经为论坛做出突出贡献目前已离职的版主', 0, '', 0, 0, 1),
(10, '论坛元老', 'medal10.gif', 0, 0, '为论坛做出突出贡献的会员', 0, '', 0, 0, 1);

-- --------------------------------------------------------

--
-- 表的结构 `medals_log`
--

CREATE TABLE IF NOT EXISTS `medals_log` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` mediumint(8) unsigned NOT NULL DEFAULT '0' COMMENT '勋章拥有着用户id',
  `medal_id` smallint(6) unsigned NOT NULL DEFAULT '0' COMMENT '勋章id',
  `time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '颁发时间',
  `expired_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '到期时间',
  `description` varchar(255) NOT NULL DEFAULT '' COMMENT '颁发原因',
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`,`medal_id`),
  KEY `time` (`time`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=27 ;

--
-- 转存表中的数据 `medals_log`
--

INSERT INTO `medals_log` (`id`, `user_id`, `medal_id`, `time`, `expired_time`, `description`) VALUES
(1, 1, 8, 1371544640, 1371657600, ''),
(2, 1, 10, 1371544640, 1371657600, ''),
(3, 2, 8, 1371544640, 1371657600, ''),
(4, 2, 10, 1371544640, 1371657600, ''),
(5, 1, 7, 1371544935, 1370275200, ''),
(6, 1, 8, 1371544935, 1370275200, ''),
(7, 2, 7, 1371544935, 1370275200, ''),
(8, 2, 8, 1371544935, 1370275200, ''),
(9, 1, 7, 1371545347, 1370188800, ''),
(10, 1, 9, 1371545347, 1370188800, ''),
(11, 2, 7, 1371545347, 1370188800, ''),
(12, 2, 9, 1371545347, 1370188800, ''),
(13, 1, 7, 1371545712, 1371657600, ''),
(14, 1, 8, 1371545712, 1371657600, ''),
(15, 2, 7, 1371545712, 1371657600, ''),
(16, 2, 8, 1371545712, 1371657600, ''),
(17, 1, 7, 1371545843, 1372262400, ''),
(18, 1, 8, 1371545843, 1372262400, ''),
(19, 2, 7, 1371545843, 1372262400, ''),
(20, 2, 8, 1371545843, 1372262400, ''),
(21, 1, 7, 1371986482, 1372348800, ''),
(22, 1, 8, 1371986482, 1372348800, ''),
(23, 1, 9, 1371986482, 1372348800, ''),
(24, 2, 7, 1371986482, 1372348800, ''),
(25, 2, 8, 1371986482, 1372348800, ''),
(26, 2, 9, 1371986482, 1372348800, '');

-- --------------------------------------------------------

--
-- 表的结构 `poll`
--

CREATE TABLE IF NOT EXISTS `poll` (
  `topic_id` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `is_overt` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否公开投票参与人',
  `is_multiple` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否多选',
  `is_visible` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否投票后可见',
  `max_choices` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '最多可选 项数',
  `expire_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '过期时间',
  `preview` varchar(255) NOT NULL DEFAULT '' COMMENT '选项内容前两项预览',
  `voters` mediumint(8) unsigned NOT NULL DEFAULT '0' COMMENT '投票人数',
  PRIMARY KEY (`topic_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `poll`
--

INSERT INTO `poll` (`topic_id`, `is_overt`, `is_multiple`, `is_visible`, `max_choices`, `expire_time`, `preview`, `voters`) VALUES
(28, 1, 0, 1, 1, 0, '士大夫士大夫[|]士大夫士大夫撒', 0),
(29, 1, 0, 1, 1, 0, '士大夫士大夫[|]士大夫士大夫撒', 0),
(34, 0, 1, 1, 2, 1378662983, 'www[|]dd', 10),
(50, 1, 1, 1, 3, 1372409989, 'fffffsdf[|]ffsdf', 0),
(51, 1, 1, 1, 3, 1372410022, 'fffffsdf[|]ffsdf', 0),
(52, 1, 0, 0, 1, 1375843099, '学智测试投票11[|]学智测试投票22', 0),
(54, 1, 0, 1, 1, 1372576248, '234234234234234235234[|]fsdfefsdgfewsdggasdfa', 0);

-- --------------------------------------------------------

--
-- 表的结构 `poll_options`
--

CREATE TABLE IF NOT EXISTS `poll_options` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `topic_id` int(8) unsigned NOT NULL DEFAULT '0',
  `votes` int(8) unsigned NOT NULL DEFAULT '0' COMMENT '票数',
  `display_order` tinyint(3) NOT NULL DEFAULT '0',
  `option` varchar(100) NOT NULL DEFAULT '' COMMENT '选项内容',
  `voterids` mediumtext COMMENT '投票用户id',
  PRIMARY KEY (`id`),
  KEY `tid` (`topic_id`,`display_order`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=26 ;

--
-- 转存表中的数据 `poll_options`
--

INSERT INTO `poll_options` (`id`, `topic_id`, `votes`, `display_order`, `option`, `voterids`) VALUES
(1, 29, 0, 0, '士大夫士大夫', ''),
(2, 29, 0, 1, '士大夫士大夫撒', ''),
(3, 29, 0, 2, 'sdfsdf6', ''),
(4, 34, 4, 0, 'www发发反反复复反反复复', '1,1,1'),
(5, 34, 7, 1, 'ddffsdf', '1,1,1,1,1,1,1'),
(6, 34, 4, 2, '555554444444467667', '1,1,1,1'),
(7, 50, 0, 0, 'fffffsdf', NULL),
(8, 50, 0, 1, 'ffsdf', NULL),
(9, 50, 0, 2, '发布帖子', NULL),
(10, 51, 0, 0, 'fffffsdf', NULL),
(11, 51, 0, 1, 'ffsdf', NULL),
(12, 51, 0, 2, '发布帖子', NULL),
(13, 52, 0, 0, '学智测试投票11', NULL),
(14, 52, 0, 1, '学智测试投票22', NULL),
(15, 52, 0, 2, '学智测试投票33', NULL),
(16, 52, 0, 3, '学智测试投票44', NULL),
(17, 54, 0, 0, '234234234234234235234', NULL),
(18, 54, 0, 1, 'fsdfefsdgfewsdggasdfa', NULL),
(19, 54, 0, 2, 'sdfsdfffff234234234fsdfsdf34534fsdfs345', NULL),
(25, 54, 0, 3, 'sssssssssssssssssssssssssssssssssssssssssss', NULL);

-- --------------------------------------------------------

--
-- 表的结构 `poll_voter`
--

CREATE TABLE IF NOT EXISTS `poll_voter` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `topic_id` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `user_id` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `username` varchar(15) NOT NULL DEFAULT '',
  `options` text NOT NULL COMMENT '选项,分隔',
  `vote_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '投票时间',
  PRIMARY KEY (`id`),
  KEY `tid` (`topic_id`),
  KEY `uid` (`user_id`,`topic_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=10 ;

--
-- 转存表中的数据 `poll_voter`
--

INSERT INTO `poll_voter` (`id`, `topic_id`, `user_id`, `username`, `options`, `vote_time`) VALUES
(1, 34, 1, 'xxz291917', '5,6', 1370745841),
(2, 34, 1, 'xxz291917', '4,5', 1370746825),
(3, 34, 1, 'xxz291917', '5', 1370747271),
(4, 34, 1, 'xxz291917', '5', 1370748157),
(5, 34, 1, 'xxz291917', '4,6', 1370748980),
(6, 34, 1, 'xxz291917', '4,6', 1370749227),
(7, 34, 1, 'xxz291917', '5', 1370749278),
(8, 34, 1, 'xxz291917', '5', 1370749623),
(9, 34, 1, 'xxz291917', '5,6', 1370750630);

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
  `position` mediumint(8) unsigned NOT NULL DEFAULT '0' COMMENT '帖子位置',
  `status` tinyint(3) unsigned NOT NULL COMMENT '状态（1正常，2删除，3被锁定）',
  PRIMARY KEY (`id`),
  KEY `forum_id` (`forum_id`),
  KEY `topic_id` (`topic_id`,`author_id`),
  KEY `post_time` (`topic_id`,`post_time`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=159 ;

--
-- 转存表中的数据 `posts`
--

INSERT INTO `posts` (`id`, `topic_id`, `forum_id`, `author`, `author_id`, `author_ip`, `post_time`, `subject`, `content`, `edit_user`, `edit_user_id`, `edit_time`, `attachment`, `check_status`, `is_first`, `is_report`, `is_bbcode`, `is_smilies`, `is_media`, `is_html`, `is_anonymous`, `is_hide`, `is_sign`, `position`, `status`) VALUES
(1, 4, 2, 'xxz291917', 1, '127.0.0.1', 1368531409, '输入标题r', '填写帖子内容', '', 0, 0, 0, 0, 1, 0, 1, 1, 1, 1, 1, 1, 1, 0, 1),
(2, 6, 2, 'xxz291917', 1, '127.0.0.1', 1368531645, '输入标题r', '填写帖子内容', '', 0, 0, 0, 0, 1, 0, 1, 1, 1, 1, 1, 1, 1, 0, 1),
(6, 10, 2, 'xxz291917', 1, '127.0.0.1', 1368535793, '输入标题r', '填写帖子内容', 'xxz291917', 1, 1372818530, 0, 0, 1, 0, 1, 1, 1, 1, 1, 1, 1, 0, 1),
(7, 7, 2, 'xxz291917', 1, '127.0.0.1', 1368583217, '夏学智测试', '今天的内容要新鲜哦\r\n<p class="MsoNormalCxSpFirst" style="margin-left:6.55pt;text-indent:36.0pt;">\r\n	<span style="font-family:&quot;">显式地把已<span>经</span>不再被引<span>用</span>的对象<span>赋</span>为</span><span> </span><span>nu</span><span>l</span><span>l</span>\r\n</p>\r\n<p class="MsoNormalCxSpMiddle" style="margin-left:6.55pt;text-indent:36.0pt;">\r\n	<span style="font-family:&quot;">不要频繁初<span>始</span>化对象</span><b><span></span></b>\r\n</p>\r\n<p class="MsoNormalCxSpMiddle" style="margin-left:6.55pt;text-indent:36.0pt;">\r\n	<span style="font-family:&quot;">除非必要，<span>否</span>则不要<span>在</span>循环内<span>初</span>始化对象</span><span> <span></span></span>\r\n</p>\r\n<p class="MsoNormalCxSpMiddle" style="margin-left:6.55pt;text-indent:36.0pt;">\r\n	<span style="font-family:&quot;">示例：</span><b><span></span></b>\r\n</p>\r\n<p class="MsoNormalCxSpMiddle" style="margin-left:6.55pt;text-indent:36.0pt;">\r\n	<span>f</span><span>o</span><span>r <span>(</span><span>$</span>i<span> </span>= <span>0</span>; <span>$</span>i<span> </span><span>&lt;</span><span>$</span><span>r</span><span>o</span><span>w</span>s;<span> </span><span>$i</span><span>++</span>)<span> </span>{</span><b><span></span></b>\r\n</p>\r\n<p class="MsoNormalCxSpMiddle" style="margin-left:36.0pt;text-indent:36.0pt;">\r\n	<span>$</span><span>c<span>o</span><span>mm</span><span>o</span><span>n</span><span>W</span><span>r</span><span>k</span><span>S</span><span>h</span>t<span> </span>= <span>n</span><span>e</span>w<span> </span><span>C</span><span>o</span><span>mm</span><span>o</span><span>n</span><span>W</span><span>r</span><span>k</span><span>S</span><span>h</span><span>t()</span>;</span><b><span></span></b>\r\n</p>\r\n<p class="MsoNormalCxSpMiddle" style="margin-left:36.0pt;text-indent:36.0pt;">\r\n	<span>…</span><b><span></span></b>\r\n</p>\r\n<p class="MsoNormalCxSpMiddle" style="text-indent:41.45pt;">\r\n	<span>}</span><b><span></span></b>\r\n</p>\r\n<p class="MsoNormalCxSpMiddle" style="text-indent:41.45pt;">\r\n	<span style="font-family:&quot;">应写成：</span><b><span></span></b>\r\n</p>\r\n<p class="MsoNormalCxSpMiddle" style="text-indent:40.35pt;">\r\n	<span>$</span><span>c<span>o</span><span>mm</span><span>o</span><span>n</span><span>W</span><span>r</span><span>k</span><span>S</span><span>h</span>t<span> </span>= <span>n</span><span>e</span>w<span> </span><span>C</span><span>o</span><span>mm</span><span>o</span><span>n</span><span>W</span><span>r</span><span>k</span><span>S</span><span>h</span><span>t()</span>;</span><b><span></span></b>\r\n</p>\r\n<p class="MsoNormalCxSpMiddle" style="text-indent:42.2pt;">\r\n	<span>f</span><span>o</span><span>r <span>(</span><span>$</span>i<span> </span>= <span>0</span>; <span>$</span>i<span> </span><span>&lt;</span><span>r</span><span>o</span><span>w</span>s;<span> </span><span>$i</span><span>++</span>)<span> </span>{</span><b><span></span></b>\r\n</p>\r\n<p class="MsoNormalCxSpMiddle" style="margin-left:30.55pt;text-indent:41.45pt;">\r\n	<span>…</span><b><span></span></b>\r\n</p>\r\n<p class="MsoNormalCxSpMiddle" style="text-indent:41.45pt;">\r\n	<span>}</span><b><span></span></b>\r\n</p>', '', 0, 0, 0, 0, 1, 0, 1, 1, 1, 1, 1, 1, 1, 0, 1),
(8, 8, 2, 'xxz291917', 1, '127.0.0.1', 1368588882, '发帖测试123', '<table>\r\n	<tbody>\r\n		<tr>\r\n			<td class="c1 td1">\r\n				tid\r\n			</td>\r\n			<td class="c2 td1">\r\n				mediumint(8) unsigned\r\n			</td>\r\n			<td class="c3 td1">\r\n				&nbsp;0\r\n			</td>\r\n			<td class="c4 td1">\r\n				&nbsp;NO\r\n			</td>\r\n			<td class="c5 td1">\r\n				&nbsp;\r\n			</td>\r\n			<td class="c6 td1">\r\n				&nbsp;主题id\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td class="c1 td2">\r\n				overt\r\n			</td>\r\n			<td class="c2 td2">\r\n				tinyint(1)\r\n			</td>\r\n			<td class="c3 td2">\r\n				&nbsp;0\r\n			</td>\r\n			<td class="c4 td2">\r\n				&nbsp;NO\r\n			</td>\r\n			<td class="c5 td2">\r\n				&nbsp;\r\n			</td>\r\n			<td class="c6 td2">\r\n				&nbsp;是否公开投票参与人\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td class="c1 td1">\r\n				multiple\r\n			</td>\r\n			<td class="c2 td1">\r\n				tinyint(1)\r\n			</td>\r\n			<td class="c3 td1">\r\n				&nbsp;0\r\n			</td>\r\n			<td class="c4 td1">\r\n				&nbsp;NO\r\n			</td>\r\n			<td class="c5 td1">\r\n				&nbsp;\r\n			</td>\r\n			<td class="c6 td1">\r\n				&nbsp;是否多选\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td class="c1 td2">\r\n				visible\r\n			</td>\r\n			<td class="c2 td2">\r\n				tinyint(1)\r\n			</td>\r\n			<td class="c3 td2">\r\n				&nbsp;0\r\n			</td>\r\n			<td class="c4 td2">\r\n				&nbsp;NO\r\n			</td>\r\n			<td class="c5 td2">\r\n				&nbsp;\r\n			</td>\r\n			<td class="c6 td2">\r\n				&nbsp;是否投票后可见\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td class="c1 td1">\r\n				maxchoices\r\n			</td>\r\n			<td class="c2 td1">\r\n				tinyint(3) unsigned\r\n			</td>\r\n			<td class="c3 td1">\r\n				&nbsp;0\r\n			</td>\r\n			<td class="c4 td1">\r\n				&nbsp;NO\r\n			</td>\r\n			<td class="c5 td1">\r\n				&nbsp;\r\n			</td>\r\n			<td class="c6 td1">\r\n				&nbsp;最大可选项数\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td class="c1 td2">\r\n				expiration\r\n			</td>\r\n			<td class="c2 td2">\r\n				int(10) unsigned\r\n			</td>\r\n			<td class="c3 td2">\r\n				&nbsp;0\r\n			</td>\r\n			<td class="c4 td2">\r\n				&nbsp;NO\r\n			</td>\r\n			<td class="c5 td2">\r\n				&nbsp;\r\n			</td>\r\n			<td class="c6 td2">\r\n				&nbsp;过期时间\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td class="c1 td1">\r\n				pollpreview\r\n			</td>\r\n			<td class="c2 td1">\r\n				varchar(255)\r\n			</td>\r\n			<td class="c3 td1">\r\n				&nbsp;\r\n			</td>\r\n			<td class="c4 td1">\r\n				&nbsp;NO\r\n			</td>\r\n			<td class="c5 td1">\r\n				&nbsp;\r\n			</td>\r\n			<td class="c6 td1">\r\n				&nbsp;选项内容前两项预览\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td class="c1 td2">\r\n				voters\r\n			</td>\r\n			<td class="c2 td2">\r\n				mediumint(8) unsigned\r\n			</td>\r\n			<td class="c3 td2">\r\n				&nbsp;0\r\n			</td>\r\n			<td class="c4 td2">\r\n				&nbsp;NO\r\n			</td>\r\n			<td class="c5 td2">\r\n				&nbsp;\r\n			</td>\r\n			<td class="c6 td2">\r\n				&nbsp;投票人数\r\n			</td>\r\n		</tr>\r\n	</tbody>\r\n</table>', '', 0, 0, 0, 0, 1, 0, 1, 1, 1, 1, 1, 1, 1, 0, 1),
(9, 9, 2, 'xxz291917', 1, '127.0.0.1', 1368609926, '输入标题二二', '填写帖子内容污染物而', '', 0, 0, 0, 0, 1, 0, 1, 1, 1, 1, 1, 1, 1, 0, 1),
(10, 10, 2, 'xxz291917', 1, '127.0.0.1', 1368610003, '输入标题二二', '填写帖子内容污染物而', '', 0, 0, 0, 0, 1, 0, 1, 1, 1, 1, 1, 1, 1, 0, 1),
(11, 11, 12, 'xxz291917', 1, '127.0.0.1', 1368611640, '$type == &#039;edit&#039;', 'dddddddddddddddddd[attachimg]22[/attachimg]dddddddddddd:lol', 'xxz291917', 1, 1372487913, 0, 0, 1, 0, 1, 1, 1, 1, 1, 1, 1, 0, 1),
(12, 12, 11, 'xxz291917', 1, '127.0.0.1', 1368612732, 'gdgdfgdgdfg', 'dfgdfgdgdfg', '', 0, 0, 0, 0, 1, 0, 1, 1, 1, 1, 1, 1, 1, 0, 1),
(13, 11, 12, 'xxz291917', 1, '127.0.0.1', 1368696089, '', '回复贴标题回复贴标题回复贴标题回复贴标题回复贴标题回复贴标题回复贴标题回复贴标题回复贴标题回复贴标题回复贴标题回复贴标题回复贴标题回复贴标题回复贴标题回复贴标题', '', 0, 0, 0, 0, 0, 0, 1, 1, 1, 1, 0, 0, 1, 0, 1),
(14, 11, 12, 'xxz291917', 1, '127.0.0.1', 1368696323, '', '回复贴标题回复贴标题回复贴标题回复贴标题回复贴标题回复贴标题回复贴标题回复贴标题回复贴标题回复贴标题回复贴标题回复贴标题回复贴标题回复贴标题回复贴标题回复贴标题', '', 0, 0, 0, 0, 0, 0, 1, 1, 1, 1, 0, 0, 1, 0, 1),
(15, 11, 12, 'xxz291917', 1, '127.0.0.1', 1368696465, '', '回复贴标题回复贴标题回复贴标题回复贴标题回复贴标题回复贴标题回复贴标题回复贴标题回复贴标题回复贴标题回复贴标题回复贴标题回复贴标题回复贴标题回复贴标题回复贴标题', '', 0, 0, 0, 0, 0, 0, 1, 1, 1, 1, 0, 0, 1, 0, 1),
(16, 11, 12, 'xxz291917', 1, '127.0.0.1', 1368696706, 'test', '测试回复内容', '', 0, 0, 0, 0, 0, 0, 1, 1, 1, 1, 0, 0, 1, 0, 1),
(17, 11, 12, 'xxz291917', 1, '127.0.0.1', 1368696770, '输入标题', '填写帖子内容才踩踩踩踩踩踩踩踩踩踩踩踩', '', 0, 0, 0, 0, 0, 0, 1, 1, 1, 1, 0, 0, 1, 0, 1),
(18, 13, 11, 'xxz291917', 1, '127.0.0.1', 1368696809, '输入标题大大大', '填写帖子内容士大夫士大夫', 'xxz291917', 1, 1372315970, 0, 0, 1, 0, 1, 1, 1, 1, 0, 0, 1, 0, 1),
(19, 13, 11, 'xxz291917', 1, '127.0.0.1', 1368696817, '输入标题', '填写帖子内容发反反复复反反复复', '', 0, 0, 0, 0, 0, 0, 1, 1, 1, 1, 0, 0, 1, 0, 1),
(20, 13, 11, 'xxz291917', 1, '127.0.0.1', 1368697037, '输入标题', '填写帖子内容<img src="http://localhost/mycode/js/kindeditor/plugins/emoticons/images/10.gif" alt="" border="0" />', '', 0, 0, 0, 0, 0, 0, 1, 1, 1, 1, 0, 0, 1, 0, 1),
(21, 14, 6, 'xxz291917', 1, '127.0.0.1', 1368699427, '红星闪闪放光芒', '填写帖子内容', '', 0, 0, 0, 0, 1, 0, 1, 1, 1, 1, 0, 0, 1, 0, 1),
(22, 14, 6, 'xxz291917', 1, '127.0.0.1', 1368699436, '输入标题', '填写帖子内容士大夫士大夫撒', '', 0, 0, 0, 0, 0, 0, 1, 1, 1, 1, 0, 0, 1, 0, 1),
(23, 14, 6, 'xxz291917', 1, '127.0.0.1', 1368701592, '输入标题士大夫士大夫', '填写帖子内容士大夫士大夫', '', 0, 0, 0, 0, 0, 0, 1, 1, 1, 1, 0, 0, 1, 0, 1),
(24, 14, 6, 'xxz291917', 1, '127.0.0.1', 1368701675, '', '填写帖子内容士大夫士大夫', '', 0, 0, 0, 0, 0, 0, 1, 1, 1, 1, 0, 0, 1, 0, 1),
(25, 9, 2, 'xxz291917', 1, '127.0.0.1', 1368702719, '输入标题', '填写帖子内容凤飞飞', '', 0, 0, 0, 0, 0, 0, 1, 1, 1, 1, 0, 0, 1, 0, 1),
(26, 13, 11, 'xxz291917', 1, '127.0.0.1', 1368757267, '输入标题', '填写帖子内容', '', 0, 0, 0, 0, 0, 0, 1, 1, 1, 1, 0, 0, 1, 0, 1),
(27, 13, 11, 'xxz5291917', 2, '127.0.0.1', 1368758585, '输入标题', '填写帖子内容sdf <br />', '', 0, 0, 0, 0, 0, 0, 1, 1, 1, 1, 1, 1, 1, 0, 1),
(28, 13, 11, 'xxz5291917', 2, '127.0.0.1', 1368758605, '输入标题', '填写帖子内容', '', 0, 0, 0, 0, 0, 0, 1, 1, 1, 1, 1, 1, 1, 0, 1),
(29, 10, 2, 'xxz5291917', 2, '127.0.0.1', 1368771892, '输入标题', '填写帖子内容', '', 0, 0, 0, 0, 0, 0, 1, 0, 0, 1, 0, 0, 1, 0, 1),
(30, 10, 2, 'xxz5291917', 2, '127.0.0.1', 1368771927, '输入标题', '填写帖子内容', '', 0, 0, 0, 0, 0, 0, 1, 0, 0, 1, 0, 0, 1, 0, 1),
(31, 8, 2, 'xxz5291917', 2, '127.0.0.1', 1368772287, '输入标题', '填写帖子内容', '', 0, 0, 0, 0, 0, 0, 1, 0, 0, 1, 0, 0, 1, 0, 1),
(32, 8, 2, 'xxz5291917', 2, '127.0.0.1', 1368772292, '输入标题', '填写帖子内容', '', 0, 0, 0, 0, 0, 0, 1, 0, 0, 1, 0, 0, 1, 0, 1),
(33, 15, 6, 'xxz5291917', 2, '127.0.0.1', 1368772328, '输入标题yy', '填写帖子内容', '', 0, 0, 0, 0, 1, 0, 1, 0, 0, 1, 0, 0, 1, 0, 1),
(34, 13, 11, 'xxz5291917', 2, '127.0.0.1', 1368773339, '输入标题', '填写帖子内容', '', 0, 0, 0, 0, 0, 0, 1, 0, 0, 1, 0, 0, 1, 0, 1),
(35, 10, 2, 'xxz5291917', 2, '127.0.0.1', 1368774131, '是大范甘迪过分的', '大范甘迪过分', '', 0, 0, 0, 0, 0, 0, 1, 0, 0, 1, 0, 0, 1, 0, 1),
(36, 11, 12, 'xxz5291917', 2, '127.0.0.1', 1368774508, '输入标题', '填写帖子内容', '', 0, 0, 0, 0, 0, 0, 1, 0, 0, 1, 0, 0, 1, 0, 1),
(37, 11, 12, 'xxz5291917', 2, '127.0.0.1', 1368774528, '输入标题', '填写帖子内容', '', 0, 0, 0, 0, 0, 0, 1, 0, 0, 1, 0, 0, 1, 0, 1),
(38, 11, 12, 'xxz5291917', 2, '127.0.0.1', 1368774534, '题哦屁', '填写<span style="font-size:24px;">帖子内容</span>', 'xxz291917', 1, 1372316749, 0, 0, 0, 0, 1, 0, 0, 1, 0, 0, 1, 0, 1),
(39, 11, 12, 'xxz5291917', 2, '127.0.0.1', 1368774539, '输入标题', '填写帖子内容', '', 0, 0, 0, 0, 0, 0, 1, 0, 0, 1, 0, 0, 1, 0, 1),
(40, 11, 12, 'xxz5291917', 2, '127.0.0.1', 1368774591, '输入标题', '填写帖子内容', '', 0, 0, 0, 0, 0, 0, 1, 0, 0, 1, 0, 0, 1, 0, 1),
(41, 11, 12, 'xxz5291917', 2, '127.0.0.1', 1368774662, '输入标题', '填写帖子内容', '', 0, 0, 0, 0, 0, 0, 1, 0, 0, 1, 0, 0, 1, 0, 1),
(42, 16, 12, 'xxz5291917', 2, '127.0.0.1', 1368774681, '输入标题凤飞飞', '填写帖子内容', '', 0, 0, 0, 0, 1, 0, 1, 0, 0, 1, 0, 0, 1, 0, 1),
(43, 17, 6, 'xxz291917', 1, '127.0.0.1', 1369310155, '是否需要测试', '是否需要测试是否需要测试是否需要测试是否需要测试是否需要测试是否需要测试是否需要测试是否需要测试是否需要测试是否需要测试是否需要测试', '', 0, 0, 0, 0, 1, 0, 1, 1, 1, 1, 1, 1, 1, 0, 1),
(44, 18, 11, 'xxz291917', 1, '127.0.0.1', 1369310199, '电梯直达跳转到指定楼层', '<h1 class="ts">\r\n	<a href="http://localhost/dz2.5/forum.php?mod=viewthread&amp;tid=2" id="thread_subject">我们的测试</a> \r\n</h1>\r\n<span class="xg1"> <a href="http://localhost/dz2.5/forum.php?mod=viewthread&amp;tid=2&amp;fromuid=1">[复制链接]</a> </span> \r\n<table class="ad" cellpadding="0" cellspacing="0">\r\n	<tbody>\r\n		<tr>\r\n			<td class="pls">\r\n				<br />\r\n			</td>\r\n			<td class="plc">\r\n				<br />\r\n			</td>\r\n		</tr>\r\n	</tbody>\r\n</table>\r\n<table id="pid5" cellpadding="0" cellspacing="0">\r\n	<tbody>\r\n		<tr>\r\n			<td class="pls" rowspan="2">\r\n				<div class="pi">\r\n					<div class="authi">\r\n						<a href="http://localhost/dz2.5/home.php?mod=space&amp;uid=1" target="_blank" class="xw1">admin</a> \r\n					</div>\r\n				</div>\r\n				<div>\r\n					<div class="avatar">\r\n						<a href="http://localhost/dz2.5/home.php?mod=space&amp;uid=1" target="_blank"><img src="http://localhost/dz2.5/uc_server/avatar.php?uid=1&amp;size=middle" /></a>\r\n					</div>\r\n					<div class="tns xg2">\r\n						<table cellpadding="0" cellspacing="0">\r\n							<tbody>\r\n								<tr>\r\n									<th>\r\n										<p>\r\n											<a href="http://localhost/dz2.5/home.php?mod=space&amp;uid=1&amp;do=thread&amp;view=me&amp;from=space" class="xi2">2</a>\r\n										</p>\r\n主题\r\n									</th>\r\n									<th>\r\n										<p>\r\n											<a href="http://localhost/dz2.5/home.php?mod=space&amp;uid=1&amp;do=friend&amp;view=me" class="xi2">0</a>\r\n										</p>\r\n好友\r\n									</th>\r\n									<td>\r\n										<p>\r\n											<a href="http://localhost/dz2.5/home.php?mod=space&amp;uid=1&amp;do=profile" class="xi2">68</a>\r\n										</p>\r\n积分\r\n									</td>\r\n								</tr>\r\n							</tbody>\r\n						</table>\r\n					</div>\r\n					<p>\r\n						<em><a href="http://localhost/dz2.5/home.php?mod=spacecp&amp;ac=usergroup&amp;gid=1" target="_blank">管理员</a></em>\r\n					</p>\r\n				</div>\r\n				<p>\r\n					<img src="http://localhost/dz2.5/static/image/common/star_level3.gif" alt="Rank: 9" /><img src="http://localhost/dz2.5/static/image/common/star_level3.gif" alt="Rank: 9" /><img src="http://localhost/dz2.5/static/image/common/star_level1.gif" alt="Rank: 9" />\r\n				</p>\r\n				<p class="cp_pls cl">\r\n					<a href="http://localhost/dz2.5/forum.php?mod=topicadmin&amp;action=getip&amp;fid=37&amp;tid=2&amp;pid=5">IP</a> <a href="http://localhost/dz2.5/admin.php?frames=yes&amp;action=members&amp;operation=search&amp;uid=1&amp;submit=yes" target="_blank">编辑</a> <a href="http://localhost/dz2.5/admin.php?action=members&amp;operation=ban&amp;username=admin&amp;frames=yes" target="_blank">禁止</a> <a href="http://localhost/dz2.5/forum.php?mod=modcp&amp;action=thread&amp;op=post&amp;do=search&amp;searchsubmit=1&amp;users=admin" target="_blank">帖子</a> <a href="http://localhost/dz2.5/forum.php?mod=ajax&amp;action=quickclear&amp;uid=1">清理</a> \r\n				</p>\r\n			</td>\r\n			<td class="plc">\r\n				<div class="pi">\r\n					<div id="fj" class="y">\r\n						电梯直达<a id="fj_btn" class="z"><img src="http://localhost/dz2.5/static/image/common/fj_btn.png" alt="跳转到指定楼层" class="vm" /></a> \r\n					</div>\r\n<strong> <a href="http://localhost/dz2.5/forum.php?mod=viewthread&amp;tid=2&amp;fromuid=1" id="postnum5">楼主</a> </strong> \r\n					<div class="pti">\r\n						<div class="pdbt">\r\n						</div>\r\n						<div class="authi">\r\n							<img class="authicn vm" id="authicon5" src="http://localhost/dz2.5/static/image/common/online_admin.gif" /> <em id="authorposton5">发表于 2013-4-16 17:59:25</em> <span class="pipe">|</span><a href="http://localhost/dz2.5/forum.php?mod=viewthread&amp;tid=2&amp;page=1&amp;authorid=1">只看该作者</a> <span class="pipe">|</span><a href="http://localhost/dz2.5/forum.php?mod=viewthread&amp;tid=2&amp;extra=page%3D1&amp;ordertype=1">倒序浏览</a> <span class="pipe">|</span> <a id="replynotice" href="http://localhost/dz2.5/forum.php?mod=misc&amp;action=replynotice&amp;op=ignore&amp;tid=2">取消回复通知</a> \r\n						</div>\r\n					</div>\r\n				</div>\r\n				<div class="pct">\r\n					<div class="pcb">\r\n						<div class="t_fsz">\r\n							<table cellpadding="0" cellspacing="0">\r\n								<tbody>\r\n									<tr>\r\n										<td class="t_f" id="postmessage_5">\r\n											主题测试主题测试主题测试主题测试主题测试主题测试主题测试主题测试<img src="http://localhost/dz2.5/static/image/smiley/default/lol.gif" alt="" border="0" /><br />\r\n										</td>\r\n									</tr>\r\n								</tbody>\r\n							</table>\r\n						</div>\r\n					</div>\r\n				</div>\r\n			</td>\r\n		</tr>\r\n	</tbody>\r\n</table>', '', 0, 0, 0, 0, 1, 0, 1, 1, 1, 1, 1, 1, 1, 0, 1),
(45, 19, 6, 'xxz291917', 1, '127.0.0.1', 1369313698, '审核测试审核测试', '审核测试审核测试审核测试审核测试审核测试审核测试审核测试', '', 0, 0, 0, 0, 1, 0, 1, 1, 1, 1, 1, 1, 1, 0, 1),
(46, 20, 6, 'xxz291917', 1, '127.0.0.1', 1369314292, '士大夫士大夫士大夫似的', '填写帖子内容反反复复反反复复反反复复反反复复', '', 0, 0, 0, 0, 1, 0, 1, 1, 1, 1, 1, 1, 1, 0, 1),
(47, 21, 6, 'xxz291917', 1, '127.0.0.1', 1369452030, '输入标题ddd', '填写帖子内容\r\n<pre class="prettyprint lang-php">phpinfo();\r\necho 123;</pre>', '', 0, 0, 0, 0, 1, 0, 1, 1, 1, 1, 1, 1, 1, 0, 1),
(48, 22, 11, 'xxz291917', 1, '127.0.0.1', 1369472789, '输入标题士大夫士大夫', '填写帖子内容\r\n<pre class="prettyprint lang-php">phpinfo();\r\necho 123;</pre>\r\n<pre class="prettyprint lang-js">alert(2222222);\r\n</pre>', '', 0, 0, 0, 0, 1, 0, 1, 1, 1, 1, 1, 1, 1, 0, 1),
(49, 22, 11, 'xxz291917', 1, '127.0.0.1', 1369476588, '输入标题', '<pre class="brush: js;">function helloSyntaxHighlighter()\r\n{\r\n    return "hi!";\r\n}\r\n</pre>', '', 0, 0, 0, 0, 0, 0, 1, 1, 1, 1, 1, 1, 1, 0, 1),
(50, 22, 11, 'xxz291917', 1, '127.0.0.1', 1369476618, '输入标题', '填写帖子内容\r\n<pre class="prettyprint lang-js">function helloSyntaxHighlighter()\r\n{\r\n    return "hi!";\r\n}</pre>', '', 0, 0, 0, 0, 0, 0, 1, 1, 1, 1, 1, 1, 1, 0, 1),
(51, 22, 11, 'xxz291917', 1, '127.0.0.1', 1369624037, '输入标题', '<pre class="brush:php;">phpinfo();</pre>\r\n填写帖子内容', '', 0, 0, 0, 0, 0, 0, 1, 1, 1, 1, 1, 1, 1, 0, 1),
(52, 22, 11, 'xxz291917', 1, '127.0.0.1', 1369624075, '输入标题', '填写帖子内容\r\n<pre class="brush:php;">function helloSyntaxHighlighter()\r\n{\r\n    return "hi!";\r\n}</pre>', '', 0, 0, 0, 0, 0, 0, 1, 1, 1, 1, 1, 1, 1, 0, 1),
(53, 22, 11, 'xxz291917', 1, '127.0.0.1', 1369625536, '输入标题', '<pre class="codeprint brush:applescript;">asdasd\r\nsfsdfsfdsf\r\nsdfsdfsdfsdfsdf\r\n</pre>\r\n填写帖子内容', '', 0, 0, 0, 0, 0, 0, 1, 1, 1, 1, 1, 1, 1, 0, 1),
(54, 22, 11, 'xxz291917', 1, '127.0.0.1', 1369626059, '输入标题', '<pre class="codeprint brush:html;">ssssssssssssssssss</pre>\r\n填写帖子内容', '', 0, 0, 0, 0, 0, 0, 1, 1, 1, 1, 1, 1, 1, 0, 1),
(55, 22, 11, 'xxz291917', 1, '127.0.0.1', 1369714000, '输入标题', '<p>\r\n	填写帖子内容\r\n</p>\r\n<p>\r\n	<br />\r\n</p>\r\n<p>\r\n<pre class="codeprint brush:php;">phpinfo();\r\necho 123;</pre>\r\n234\r\n</p>\r\neeeeeeeeeee', '', 0, 0, 0, 0, 0, 0, 1, 1, 1, 1, 1, 1, 1, 0, 1),
(56, 23, 2, 'xxz291917', 1, '127.0.0.1', 1369740062, '输入标题7777', '填写帖子内容:$:kiss::handshake{:3_46:}', '', 0, 0, 0, 0, 1, 0, 1, 1, 1, 1, 1, 1, 1, 0, 1),
(57, 23, 2, 'xxz291917', 1, '127.0.0.1', 1369795605, '输入标题', '填写帖子内容', '', 0, 0, 0, 0, 0, 0, 1, 1, 1, 1, 1, 1, 1, 0, 1),
(58, 24, 11, 'xxz291917', 1, '127.0.0.1', 1369815311, '输入标题夸奖夸奖夸奖', '填写帖子内容:lol{:2_36:}<a href="http://www.baidu.com" target="_blank">http://www.baidu.com</a>', '', 0, 0, 0, 0, 1, 0, 1, 1, 1, 1, 1, 1, 1, 0, 1),
(59, 24, 11, 'xxz291917', 1, '127.0.0.1', 1369815380, '输入标题', '填写帖子内容{:3_46:}', '', 0, 0, 0, 0, 0, 0, 1, 1, 1, 1, 1, 1, 1, 0, 1),
(60, 24, 11, 'xxz291917', 1, '127.0.0.1', 1369817179, '输入标题', '<blockquote class="blockquote">\r\n	士大夫士大夫\r\n</blockquote>\r\n填写帖子内容', '', 0, 0, 0, 0, 0, 0, 1, 1, 1, 1, 1, 1, 1, 0, 1),
(61, 24, 11, 'xxz291917', 1, '127.0.0.1', 1369818158, '输入标题', '<blockquote class="blockquote">\r\n	sdfsdf\r\n</blockquote>\r\n填写帖子内容', '', 0, 0, 0, 0, 0, 0, 1, 1, 1, 1, 1, 1, 1, 0, 1),
(62, 25, 11, 'xxz291917', 1, '127.0.0.1', 1369819307, 'hahhhhhhhh', '填写帖子内容:sleepy:{:3_43:}:@{:2_38:}', '', 0, 0, 0, 0, 1, 0, 1, 1, 1, 1, 1, 1, 1, 0, 1),
(63, 25, 11, 'xxz291917', 1, '127.0.0.1', 1369819367, '输入标题', '<blockquote class="blockquote">\r\n	''|'',\r\n</blockquote>\r\n<br />\r\n填写帖子内容', '', 0, 0, 0, 0, 0, 0, 1, 1, 1, 1, 1, 1, 1, 0, 1),
(64, 25, 11, 'xxz291917', 1, '127.0.0.1', 1369893399, '输入标题', '填写帖子内容<img src="/mycode/./uploads/file/b7da665c18f830c5a081a695395e734c.jpg" alt="" />', '', 0, 0, 0, 0, 0, 0, 1, 1, 1, 1, 1, 1, 1, 0, 1),
(65, 25, 11, 'xxz291917', 1, '127.0.0.1', 1369898357, '输入标题', '<img src="/mycode/uploads/file/e378c80cacad35dc854a972f397b0ed7.jpg" alt="" />填写帖子内容<img src="/mycode/uploads/file/9685aa209fb498b4eb8e5ddc0c987a7d.jpg" title="xxzxxzxxz" alt="xxzxxzxxz" height="109" width="109" /><a class="ke-insertfile" href="/mycode/uploads/file/2d925a00ca6495b559d646002de13f07.jpg" target="_blank">dddddddd</a>', '', 0, 0, 0, 0, 0, 0, 1, 1, 1, 1, 1, 1, 1, 0, 1),
(66, 25, 11, 'xxz291917', 1, '127.0.0.1', 1369899428, '输入标题', '<img src="/mycode/uploads/file/5134fa443f587661f910228e594d89f5.jpg" alt="" />填写帖子内容', '', 0, 0, 0, 0, 0, 0, 1, 1, 1, 1, 1, 1, 1, 0, 1),
(67, 25, 11, 'xxz291917', 1, '127.0.0.1', 1369899454, '输入标题', '填写帖子内容<img src="/mycode/uploads/file/b43e329af02d0b67017b2ea5681249c3.jpg" alt="" />', '', 0, 0, 0, 0, 0, 0, 1, 1, 1, 1, 1, 1, 1, 0, 1),
(68, 25, 11, 'xxz291917', 1, '127.0.0.1', 1369899590, '输入标题', '填写帖子内容<img src="/mycode/uploads/file/47158d0b0863f15c4eaf28f659b9b8a1.jpg" alt="" />', '', 0, 0, 0, 0, 0, 0, 1, 1, 1, 1, 1, 1, 1, 0, 4),
(69, 25, 11, 'xxz291917', 1, '127.0.0.1', 1369899791, '输入标题', '填写帖子内容<img src="/mycode/uploads/file/6f5a88c0a5643420ca913595f20fcd04.jpg" alt="" />', '', 0, 0, 0, 0, 0, 0, 1, 1, 1, 1, 1, 1, 1, 0, 4),
(70, 25, 11, 'xxz291917', 1, '127.0.0.1', 1369903578, '输入标题', '填写帖子内容<img src="/mycode/uploads/file/9ba8fe893d04425fd9fb1fd17fed7e04.jpg" title="ffffffffffff" aid="34" alt="ffffffffffff" height="109" width="109" />', '', 0, 0, 0, 0, 0, 0, 1, 1, 1, 1, 1, 1, 1, 0, 4),
(71, 25, 11, 'xxz291917', 1, '127.0.0.1', 1369979792, '输入标题', '[attach]7[/attach]填写帖子内容', '', 0, 0, 0, 0, 0, 0, 1, 1, 1, 1, 1, 1, 1, 0, 4),
(72, 25, 11, 'xxz291917', 1, '127.0.0.1', 1369979848, '输入标题', '填写帖子内容[attach]1[/attach]', '', 0, 0, 0, 0, 0, 0, 1, 1, 1, 1, 1, 1, 1, 0, 4),
(73, 25, 11, 'xxz291917', 1, '127.0.0.1', 1369979898, '输入标题', '填写帖子内容[attach]1[/attach]', '', 0, 0, 0, 0, 0, 0, 1, 1, 1, 1, 1, 1, 1, 0, 4),
(74, 16, 12, 'xxz291917', 1, '127.0.0.1', 1369988139, '输入标题', '填写帖子内容[attachimg]3[/attachimg]', '', 0, 0, 0, 0, 0, 0, 1, 1, 1, 1, 1, 1, 1, 0, 1),
(75, 29, 2, 'xxz291917', 1, '127.0.0.1', 1370233126, '去问去问夫士大夫', '填写帖子内容反反复复&nbsp; 士大夫士大夫士大夫士大夫<br />', '', 0, 0, 0, 0, 1, 0, 1, 1, 1, 1, 1, 1, 1, 0, 1),
(76, 31, 2, 'xxz291917', 1, '127.0.0.1', 1370319752, '辩论发帖测试', 'errrrrrrrrrrrrrrrerrrrrrrrrrrrrrrrerrrrrrrrrrrrrrrrerrrrrrrrrrrrrrrrerrrrrrrrrrrrrrrrerrrrrrrrrrrrrrrrerrrrrrrrrrrrrrrrerrrrrrrrrrrrrrrrerrrrrrrrrrrrrrrrerrrrrrrrrrrrrrrrerrrrrrrrrrrrrrrr', '', 0, 0, 0, 0, 1, 0, 1, 1, 1, 1, 1, 1, 1, 0, 1),
(77, 34, 2, 'xxz291917', 1, '127.0.0.1', 1370335370, '输入标sdfsdfsdf', '填写帖子内容', '', 0, 0, 0, 0, 1, 0, 1, 1, 1, 1, 1, 1, 1, 0, 1),
(78, 35, 2, 'xxz291917', 1, '127.0.0.1', 1370397845, 'test 白色,,hongse,,   sfsl  sdfsdf', 'test 白色,,hongse,,&nbsp;&nbsp; sfsl&nbsp; sdfsdftest 白色,,hongse,,&nbsp;&nbsp; sfsl&nbsp; sdfsdftest 白色,,hongse,,&nbsp;&nbsp; sfsl&nbsp; sdfsdftest 白色,,hongse,,&nbsp;&nbsp; sfsl&nbsp; sdfsdftest 白色,,hongse,,&nbsp;&nbsp; sfsl&nbsp; sdfsdf', '', 0, 0, 0, 0, 1, 0, 1, 1, 1, 1, 1, 1, 1, 0, 1),
(79, 36, 2, 'xxz291917', 1, '127.0.0.1', 1370398156, '输入标题士大夫士大夫', '填写帖子内容', '', 0, 0, 0, 0, 1, 0, 1, 1, 1, 1, 1, 1, 1, 0, 1),
(80, 38, 2, 'xxz291917', 1, '127.0.0.1', 1370418370, '士大夫士大夫标题', '填写士大夫士大夫', '', 0, 0, 0, 0, 1, 0, 1, 1, 1, 1, 1, 1, 1, 0, 1),
(81, 39, 11, 'xxz291917', 1, '127.0.0.1', 1370585781, 'lert(123);', '填写帖子内容123123', '', 0, 0, 0, 0, 1, 0, 1, 1, 1, 1, 1, 1, 1, 0, 4),
(82, 40, 11, 'xxz291917', 1, '127.0.0.1', 1370586266, '&lt;script&gt;alert(123);&lt;/script&gt;', '填写帖子内容sdfsdfsdfsdf', '', 0, 0, 0, 0, 1, 0, 1, 1, 1, 1, 1, 1, 1, 0, 4),
(83, 42, 2, 'xxz291917', 1, '127.0.0.1', 1370662947, '发表文旦扣减分', '发表文旦扣减分发表文旦扣减分发表文旦扣减分发表文旦扣减分发表文旦扣减分发表文旦扣减分发表文旦扣减分发表文旦扣减分发表文旦扣减分', '', 0, 0, 0, 0, 1, 0, 1, 1, 1, 1, 1, 1, 1, 0, 1),
(84, 43, 2, 'xxz291917', 1, '127.0.0.1', 1370662983, 'vvvvvvvvvvvvv', 'vvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvv', '', 0, 0, 0, 0, 1, 0, 1, 1, 1, 1, 1, 1, 1, 0, 1),
(85, 34, 2, 'xxz291917', 1, '127.0.0.1', 1370762810, '', '填写帖子内容士大夫士大夫', '', 0, 0, 0, 0, 0, 0, 1, 1, 1, 1, 1, 1, 1, 0, 1),
(86, 34, 2, 'xxz291917', 1, '127.0.0.1', 1370766742, '输入标题sdffff', '填写帖子内容sdfsdfsdf', '', 0, 0, 0, 0, 0, 0, 1, 1, 1, 1, 1, 1, 1, 0, 1),
(87, 44, 11, 'xxz291917', 1, '127.0.0.1', 1370770112, '看看我们的成绩', '学智测试辩论学智测试辩论学智测试辩论学智测试辩{:3_60:}论学智测试辩论学智测试辩论学智测试辩论学智测试辩论学智测试辩论学智测试辩论学智测试辩论学:hug:智测试辩论学智测试辩论学智测试辩论', 'xxz291917', 1, 1372315525, 0, 0, 1, 0, 1, 1, 1, 1, 1, 1, 1, 0, 4),
(88, 44, 11, 'xxz291917', 1, '127.0.0.1', 1370781275, '看看我们的成绩', '蓝放<strong>蓝放蓝放蓝放蓝放</strong>蓝放{:3_45:}', 'xxz291917', 1, 1372300197, 0, 0, 0, 0, 1, 1, 1, 1, 1, 1, 1, 0, 4),
(89, 44, 11, 'xxz291917', 1, '127.0.0.1', 1370781675, '蓝放', '蓝放蓝放蓝放蓝放蓝放', '', 0, 0, 0, 0, 0, 0, 1, 1, 1, 1, 1, 1, 1, 0, 4),
(90, 44, 11, 'xxz291917', 1, '127.0.0.1', 1370781961, '标题', 'special<strong>specialspecials</strong>pecial', 'xxz291917', 1, 1372304213, 0, 0, 0, 0, 1, 1, 1, 1, 1, 1, 1, 0, 1),
(91, 45, 11, 'xxz291917', 1, '127.0.0.1', 1370782056, '问答问答问答', '问答问答问答问答', '', 0, 0, 0, 0, 1, 0, 1, 1, 1, 1, 1, 1, 1, 0, 4),
(92, 34, 2, 'xxz291917', 1, '127.0.0.1', 1371097739, '输入标题', '填写帖子内容', '', 0, 0, 0, 0, 0, 0, 1, 1, 1, 1, 1, 1, 1, 0, 1),
(93, 34, 2, 'xxz291917', 1, '127.0.0.1', 1371097751, '', '士大夫士大夫', '', 0, 0, 0, 0, 0, 0, 1, 1, 1, 1, 1, 1, 1, 0, 1),
(94, 34, 2, 'xxz291917', 1, '127.0.0.1', 1371097756, '输入标题', '填写帖子内容', '', 0, 0, 0, 0, 0, 0, 1, 1, 1, 1, 1, 1, 1, 0, 1),
(95, 34, 2, 'xxz291917', 1, '127.0.0.1', 1371097762, '输入标题', '填写帖子内容', '', 0, 0, 0, 0, 0, 0, 1, 1, 1, 1, 1, 1, 1, 0, 1),
(96, 34, 2, 'xxz291917', 1, '127.0.0.1', 1371097769, '输入标题', '填写帖子内容叫姐姐', '', 0, 0, 0, 0, 0, 0, 1, 1, 1, 1, 1, 1, 1, 0, 1),
(97, 34, 2, 'xxz291917', 1, '127.0.0.1', 1371097775, '输入标题', '填写帖子内容规划局', '', 0, 0, 0, 0, 0, 0, 1, 1, 1, 1, 1, 1, 1, 0, 1),
(98, 16, 12, 'xxz291917', 1, '127.0.0.1', 1371105016, '输入标题', '填写帖子内容啊实打实大', '', 0, 0, 0, 0, 0, 0, 1, 1, 1, 1, 1, 1, 1, 0, 1),
(99, 46, 11, 'xxz291917', 1, '127.0.0.1', 1371702544, '人人人人人人人', '人人人人人人人人人人人人', '', 0, 0, 0, 0, 1, 0, 1, 1, 1, 1, 1, 1, 1, 1, 4),
(100, 47, 11, 'xxz291917', 1, '127.0.0.1', 1371726788, '输入问答概述', '反反复复', '', 0, 0, 0, 0, 1, 0, 1, 1, 1, 1, 1, 1, 1, 1, 4),
(101, 48, 11, 'xxz291917', 1, '127.0.0.1', 1371807011, '本版规则及说明,新手发帖前请花两分钟了解，谢谢', '$post$p<strong>ost</strong><strong>$post</strong><strong>$post</strong><strong>$po</strong>st$post{:2_37:}', '', 0, 0, 0, 0, 1, 0, 1, 1, 1, 1, 1, 1, 1, 1, 4),
(102, 49, 11, 'xxz291917', 1, '127.0.0.1', 1371972423, '红星闪闪放光芒', '红星闪闪放光芒红星闪闪放光芒红星闪闪放光芒红星闪闪放光芒红星闪闪放光芒红星闪闪放光芒红星闪闪放光芒红星闪闪放光芒红星闪闪放光芒红星闪闪放光芒红星闪闪放光芒红星闪闪放光芒红星闪闪放光芒红星闪闪放光芒红星闪闪放光芒红星闪闪放光芒', '', 0, 0, 0, 0, 1, 0, 1, 1, 1, 1, 1, 1, 1, 1, 4),
(103, 50, 11, 'xxz291917', 1, '127.0.0.1', 1371977989, '发布帖子333', '<a href="http://localhost/mycode/index.php/action/post/11/3">发布帖子</a><a href="http://localhost/mycode/index.php/action/post/11/3">发布帖子</a><a href="http://localhost/mycode/index.php/action/post/11/3">发布帖子{:3_47:}</a><a href="http://localhost/mycode/index.php/action/post/11/3">发布帖子</a><a href="http://localhost/mycode/index.php/action/post/11/3">发布帖子</a><a href="http://localhost/mycode/index.php/action/post/11/3">发布帖子{:2_35:}</a>', '', 0, 0, 0, 0, 1, 0, 1, 1, 1, 1, 1, 1, 1, 1, 4),
(104, 51, 11, 'xxz291917', 1, '127.0.0.1', 1371978022, '发布帖子333', '<a href="http://localhost/mycode/index.php/action/post/11/3">发布帖子</a><a href="http://localhost/mycode/index.php/action/post/11/3">发布帖子</a><a href="http://localhost/mycode/index.php/action/post/11/3">发布帖子{:3_47:}</a><a href="http://localhost/mycode/index.php/action/post/11/3">发布帖子</a><a href="http://localhost/mycode/index.php/action/post/11/3">发布帖子</a><a href="http://localhost/mycode/index.php/action/post/11/3">发布帖子{:2_35:}</a>', '', 0, 0, 0, 0, 1, 0, 1, 1, 1, 1, 1, 1, 1, 1, 4),
(105, 11, 12, 'xxz291917', 1, '127.0.0.1', 1372139708, '', '士大夫士大夫', '', 0, 0, 0, 0, 0, 0, 1, 1, 1, 1, 1, 1, 1, 1, 1),
(106, 11, 12, 'xxz291917', 1, '127.0.0.1', 1372139903, '', '<blockquote class="blockquote">xxz5291917 发表于 2013-05-17 15:11:02<br/>填写帖子内容</blockquote>', '', 0, 0, 0, 0, 0, 0, 1, 1, 1, 1, 1, 1, 1, 2, 1),
(107, 11, 12, 'xxz291917', 1, '127.0.0.1', 1372139977, '4大大大', '<blockquote class="blockquote">xxz291917 发表于 2013-06-25 13:55:08<br/>士大夫士大夫</blockquote>44444444444444444444444444444444444', '', 0, 0, 0, 0, 0, 0, 1, 1, 1, 1, 1, 1, 1, 3, 1),
(108, 11, 12, 'xxz291917', 1, '127.0.0.1', 1372140208, '', '<blockquote class="blockquote">xxz291917 发表于 2013-06-25 13:59:37<br/>44444444444444444444</blockquote>人人人人人人人人人人', '', 0, 0, 0, 0, 0, 0, 1, 1, 1, 1, 1, 1, 1, 4, 1),
(109, 11, 12, 'xxz291917', 1, '127.0.0.1', 1372142466, '', '<blockquote class="blockquote">xxz291917 发表于 2013-05-16 17:21:29<br/>回复贴标题回复贴标题回复贴标题回复贴标题……</blockquote>他天天天天', '', 0, 0, 0, 0, 0, 0, 1, 1, 1, 1, 1, 1, 1, 5, 1),
(110, 11, 12, 'xxz291917', 1, '127.0.0.1', 1372142906, '', '<blockquote class="blockquote">xxz5291917 发表于 2013-05-17 15:11:02<br/>填写帖子内容</blockquote>utyuiyut', '', 0, 0, 0, 0, 0, 0, 1, 1, 1, 1, 1, 1, 1, 6, 1),
(111, 11, 12, 'xxz291917', 1, '127.0.0.1', 1372143237, '', '<blockquote class="blockquote">xxz5291917 发表于 2013-05-17 15:09:51<br/>填写帖子内容</blockquote>士大夫士大夫考虑据了解', '', 0, 0, 0, 0, 0, 0, 1, 1, 1, 1, 1, 1, 1, 7, 1),
(112, 11, 12, 'xxz291917', 1, '127.0.0.1', 1372143607, '', '<blockquote class="blockquote">xxz5291917 发表于 2013-05-17 15:09:51<br/>填写帖子内容</blockquote>士大夫士大夫', '', 0, 0, 0, 0, 0, 0, 1, 1, 1, 1, 1, 1, 1, 8, 1),
(113, 11, 12, 'xxz291917', 1, '127.0.0.1', 1372143618, '', '<blockquote class="blockquote">xxz5291917 发表于 2013-05-17 15:08:54<br/>填写帖子内容</blockquote>士大夫', '', 0, 0, 0, 0, 0, 0, 1, 1, 1, 1, 1, 1, 1, 9, 1),
(114, 11, 12, 'xxz291917', 1, '127.0.0.1', 1372143670, '', '<blockquote class="blockquote">xxz5291917 发表于 2013-05-17 15:08:54<br/>填写帖子内容</blockquote>士大夫士大夫士大夫', '', 0, 0, 0, 0, 0, 0, 1, 1, 1, 1, 1, 1, 1, 10, 1),
(115, 11, 12, 'xxz291917', 1, '127.0.0.1', 1372211834, '', 'sdfsdfsdfsdfsdfsdf', '', 0, 0, 0, 0, 0, 0, 1, 1, 1, 1, 1, 1, 1, 11, 1),
(116, 11, 12, 'xxz291917', 1, '127.0.0.1', 1372232414, '输入标题人人', '<blockquote class="blockquote">xxz291917 发表于 2013-06-25 13:59:37<br/>44444444444444444444……</blockquote><blockquote class="blockquote">\r\n	xxz291917 发表于 2013-06-25 13:55:08<br />\r\n士大夫士大夫\r\n</blockquote>\r\n44444444444444444444444444444444444', '', 0, 0, 0, 0, 0, 0, 1, 1, 1, 1, 1, 1, 1, 12, 1),
(117, 52, 11, 'xxz291917', 1, '127.0.0.1', 1372247353, '学智测试投票', '学智测试投票学智测试投票学智测试投票学智测试投票学智测试投票学智测试投票学智测试投票学智测试投票学智测试投票学智测试投票学智测试投票学智测试投票学智测试投票学智测试投票学智测试投票学智测试投票学智测试投票学智测试投票', 'xxz291917', 1, 1372387099, 0, 0, 1, 0, 1, 1, 1, 1, 1, 1, 1, 1, 4),
(118, 44, 11, 'xxz291917', 1, '127.0.0.1', 1372297586, '', 'sdfsdfsdddddddddddddddddddddd', '', 0, 0, 0, 0, 0, 0, 1, 1, 1, 1, 1, 1, 1, 1, 1),
(119, 44, 11, 'xxz291917', 1, '127.0.0.1', 1372304277, '', '<blockquote class="blockquote">xxz291917 发表于 2013-06-09 20:46:01<br/>special&lt;strong&gt;speci……</blockquote>士大夫士大夫士大夫', '', 0, 0, 0, 0, 0, 0, 1, 1, 1, 1, 1, 1, 1, 2, 4),
(120, 44, 11, 'xxz291917', 1, '127.0.0.1', 1372312389, '', '<blockquote class="blockquote">xxz291917 发表于 2013-06-27 09:46:26<br/>sdfsdfsddddddddddddd……</blockquote>啊实打实的', '', 0, 0, 0, 0, 0, 0, 1, 1, 1, 1, 1, 1, 1, 3, 4),
(121, 53, 11, 'xxz291917', 1, '127.0.0.1', 1372312851, '红星闪闪放光芒', '士大夫士大夫士大夫士大夫士大夫', 'xxz291917', 1, 1372842138, 0, 0, 1, 0, 1, 1, 1, 1, 1, 1, 1, 1, 4),
(122, 53, 11, 'xxz291917', 1, '127.0.0.1', 1372313414, '', '啊实打实的', '', 0, 0, 0, 0, 0, 0, 1, 1, 1, 1, 1, 1, 1, 2, 4),
(123, 53, 11, 'xxz291917', 1, '127.0.0.1', 1372313433, '', '士大夫发反反复复反反复复反反复复', '', 0, 0, 0, 0, 0, 0, 1, 1, 1, 1, 1, 1, 1, 3, 4),
(124, 53, 11, 'xxz291917', 1, '127.0.0.1', 1372313467, '', '啊啊啊啊啊啊啊啊啊啊啊啊啊啊', '', 0, 0, 0, 0, 0, 0, 1, 1, 1, 1, 1, 1, 1, 4, 4),
(125, 53, 11, 'xxz291917', 1, '127.0.0.1', 1372315193, '', '发反反复复反反复复反反', '', 0, 0, 0, 0, 0, 0, 1, 1, 1, 1, 1, 1, 1, 5, 4),
(126, 11, 12, 'xxz291917', 1, '127.0.0.1', 1372316668, '', 'if($db_post[''is_first'']==1){//主题帖子', '', 0, 0, 0, 0, 0, 0, 1, 1, 1, 1, 1, 1, 1, 13, 1),
(127, 54, 12, 'xxz291917', 1, '127.0.0.1', 1372317871, 'xuezhi投票', '字母数字组合选择。字母数字组合选择。字母数字组合选择。字母数字组合选择。字母数字组合选择。字母数字组合选择。字母数字组合选择。字母数字组合选择。字母数字组合选择。字母数字组合选择。字母数字组合选择。字母数字组合选择。字母数字组合选择。字母数字组合选择。', 'xxz291917', 1, 1372403448, 0, 0, 1, 0, 1, 1, 1, 1, 1, 1, 1, 0, 1),
(128, 54, 12, 'xxz291917', 1, '127.0.0.1', 1372320821, '', '希望大家都来投票哦。', '', 0, 0, 0, 0, 0, 0, 1, 1, 1, 1, 1, 1, 1, 1, 1),
(129, 54, 12, 'xxz291917', 1, '127.0.0.1', 1372320844, '', '<blockquote class="blockquote">xxz291917 发表于 2013-06-27 16:13:41<br/>希望大家都来投票哦。</blockquote>士大<strong>夫士大夫士大</strong>夫', '', 0, 0, 0, 0, 0, 0, 1, 1, 1, 1, 1, 1, 1, 2, 1),
(130, 53, 11, 'xxz291917', 1, '127.0.0.1', 1372331494, '', '士大夫士大夫', 'xxz291917', 1, 1372331740, 0, 0, 0, 0, 1, 1, 1, 1, 1, 1, 1, 6, 4),
(131, 55, 12, 'xxz291917', 1, '127.0.0.1', 1372405704, '输入标题人人', '<blockquote class="blockquote">\r\n	xxz291917 发表于 2013-06-25 13:55:08<br />\r\n士大夫士大夫\r\n</blockquote>\r\n4444444[attachimg]4[/attachimg]44444444444444{:2_37:}44444444444444:loveliness:', '', 0, 0, 0, 0, 1, 0, 1, 1, 1, 1, 1, 1, 1, 0, 1),
(132, 56, 12, 'xxz291917', 1, '127.0.0.1', 1372409705, '输入标题人人', '<blockquote class="blockquote">\r\n	xxz291917 发表于 2013-06-25 13:55:08<br />\r\n士大夫士大夫\r\n</blockquote>\r\n4444444[attachimg]4[/attachimg]44444444444444{:2_37:}44444444444444:loveliness:', '', 0, 0, 0, 0, 1, 0, 1, 1, 1, 1, 1, 1, 1, 0, 1),
(133, 57, 12, 'xxz291917', 1, '127.0.0.1', 1372409831, '士大夫士大夫', ':Q[attachimg]10[/attachimg][attach]11[/attach]', '', 0, 0, 0, 0, 1, 0, 1, 1, 1, 1, 1, 1, 1, 0, 1),
(134, 58, 12, 'xxz291917', 1, '127.0.0.1', 1372411442, '55555555555', '[attachimg]12[/attachimg] <a class="ke-insertfile" href="/mycode/uploads/file/1f831e515500a190225a5bf70836b5ec.docx" target="_blank">接口将空间</a> [attach]14[/attach]', '', 0, 0, 0, 0, 1, 0, 1, 1, 1, 1, 1, 1, 1, 0, 1),
(135, 59, 12, 'xxz291917', 1, '127.0.0.1', 1372411535, '人人人人5555人人人人人', '<p>\r\n	:L[attach]16[/attach]\r\n</p>\r\n<p>\r\n	sdfsdffffffffffffffffffffffffffffffffff\r\n</p>', 'xxz291917', 1, 1372479750, 0, 0, 1, 0, 1, 1, 1, 1, 1, 1, 1, 0, 1),
(136, 60, 11, 'xxz291917', 1, '127.0.0.1', 1372491400, '44444444444444', '<p>\r\n	:loli哦i [attachimg]23[/attachimg] [attach]24[/attach]\r\n</p>\r\n<p>\r\n	阿斯达\r\n</p>\r\n<p>\r\n	<br />\r\n</p>\r\n<p>\r\n<pre class="codeprint brush:php;">phpinfo();\r\necho 123;</pre>\r\n</p>', 'xxz291917', 1, 1372493407, 0, 0, 1, 0, 1, 1, 1, 1, 1, 1, 1, 0, 4),
(137, 61, 12, 'xxz291917', 1, '127.0.0.1', 1372645276, '添加一张图片附件，测试。', '添加一张图片附件，测试。添加一张图片附件，测试。添加一张图片附件，测试。添加一张图片附件，测试。添加一张图片附件，测试。添加一张图片附件，测试。添加一张图片附件，测试。添加一张图片附件，测试。添加一张图片附件，测试。添加一张图[attachimg]34[/attachimg]片附件，测试。添加一张图片附件，测试。', 'xxz291917', 1, 1372668844, 1, 0, 1, 0, 1, 1, 1, 1, 1, 1, 1, 0, 1),
(138, 61, 12, 'xxz291917', 1, '127.0.0.1', 1372649054, '', '<a href="http://localhost/mycode/index.php/topic/show/61">标<em>题大大</em>大</a>', 'xxz291917', 1, 1372824623, 0, 0, 0, 0, 1, 1, 1, 1, 1, 1, 1, 1, 1),
(139, 62, 13, 'xxz291917', 1, '127.0.0.1', 1372665723, '去问去问去问去问', '按时打发士大夫阿斯顿发[attachimg]32[/attachimg]阿斯顿发阿斯顿发<br />', 'xxz291917', 1, 1372668761, 1, 0, 1, 0, 1, 1, 1, 1, 1, 1, 1, 0, 1),
(140, 23, 2, 'xxz291917', 1, '127.0.0.1', 1372670768, '', '<blockquote class="blockquote">xxz291917 发表于 2013-05-28 19:21:02<br/>填写帖子内容:$:kiss::hands……</blockquote>士大夫士大夫撒', '', 0, 0, 0, 0, 0, 0, 1, 1, 1, 1, 1, 1, 1, 1, 1),
(141, 63, 11, 'xxz291917', 1, '127.0.0.1', 1372670946, 'xuezhi分类测试。', '丰东股份电饭锅:lol电饭锅', '', 0, 0, 0, 0, 1, 0, 1, 1, 1, 1, 1, 1, 1, 0, 4),
(142, 63, 11, 'xxz291917', 1, '127.0.0.1', 1372670967, '', '[attachimg]35[/attachimg]', 'xxz291917', 1, 1372671024, 1, 0, 0, 0, 1, 1, 1, 1, 1, 1, 1, 1, 4),
(143, 63, 11, 'xxz291917', 1, '127.0.0.1', 1372670987, '', '<blockquote class="blockquote">xxz291917 发表于 2013-07-01 17:29:27<br/>士大夫士[attachimg]35[/a……</blockquote>士大夫士大夫', '', 0, 0, 0, 0, 0, 0, 1, 1, 1, 1, 1, 1, 1, 2, 4),
(144, 63, 11, 'xxz291917', 1, '127.0.0.1', 1372671031, '', '<blockquote class="blockquote">xxz291917 发表于 2013-07-01 17:29:27<br/>[attachimg]35[/attac……</blockquote>士大夫士大夫士大夫', '', 0, 0, 0, 0, 0, 0, 1, 1, 1, 1, 1, 1, 1, 3, 4),
(145, 64, 11, 'xxz291917', 1, '127.0.0.1', 1372737971, 'adasd', 'asasddddddddddddddd', '', 0, 0, 0, 0, 1, 0, 1, 1, 1, 1, 1, 1, 1, 0, 4),
(146, 65, 16, 'xxz291917', 1, '127.0.0.1', 1372744686, '$this-&gt;input-&gt;post()', 'sdfsdfffffffffffffffffffffffffffffffff', '', 0, 0, 0, 0, 1, 0, 1, 1, 1, 1, 1, 1, 1, 0, 1),
(147, 66, 11, 'xxz291917', 1, '127.0.0.1', 1372767152, '空间和客户', '空间很快就会狂欢节', '', 0, 0, 0, 0, 1, 0, 1, 1, 1, 1, 1, 1, 1, 0, 4),
(148, 66, 11, 'xxz291917', 1, '127.0.0.1', 1372767243, '', '反反复复反反复复凤飞飞', '', 0, 0, 0, 0, 0, 0, 1, 1, 1, 1, 1, 1, 1, 1, 4),
(149, 66, 11, 'xxz291917', 1, '127.0.0.1', 1372767301, '', '反反复复反反复复凤飞飞', '', 0, 0, 0, 0, 0, 0, 1, 1, 1, 1, 1, 1, 1, 2, 4),
(150, 66, 11, 'xxz291917', 1, '127.0.0.1', 1372767310, '', '大大大大大大大大大大大大', '', 0, 0, 0, 0, 0, 0, 1, 1, 1, 1, 1, 1, 1, 3, 4),
(151, 66, 11, 'xxz291917', 1, '127.0.0.1', 1372767369, '', '空间考虑进口邻居', '', 0, 0, 0, 0, 0, 0, 1, 1, 1, 1, 1, 1, 1, 4, 4),
(152, 67, 11, 'xxz291917', 1, '127.0.0.1', 1372769377, '问答帖子测试', '问答帖子测试问答帖子测试问答帖子测试问答帖子测试问答帖子测试问答帖子测试问答帖子测试问答帖子测试问答帖子测试问答帖子测试问答帖子测试问答帖子测试问答帖子测试问答帖子测试问答帖子测试问答帖子测试', '', 0, 0, 0, 0, 1, 0, 1, 1, 1, 1, 1, 1, 1, 0, 4),
(153, 67, 11, 'xxz291917', 1, '127.0.0.1', 1372769397, '', '人同意让他一人', '', 0, 0, 0, 0, 0, 0, 1, 1, 1, 1, 1, 1, 1, 1, 4),
(154, 67, 11, 'xxz291917', 1, '127.0.0.1', 1372769422, '', '<blockquote class="blockquote">xxz291917 发表于 2013-07-02 20:49:37<br/>问答帖子测试问答帖子测试问答帖子测试问答……</blockquote>问答帖子测试', '', 0, 0, 0, 0, 0, 0, 1, 1, 1, 1, 1, 1, 1, 2, 4),
(155, 68, 11, 'xxz291917', 1, '127.0.0.1', 1372829309, 'dsasdasd', 'aaaaaaaaaaaaaaaaaaaaaaa', '', 0, 0, 0, 0, 1, 0, 1, 1, 1, 1, 1, 1, 1, 0, 4),
(156, 68, 11, 'xxz291917', 1, '127.0.0.1', 1372829324, '', '<blockquote class="blockquote">xxz291917 发表于 2013-07-03 13:28:29<br/>aaaaaaaaaaaaaaaaaaaa</blockquote>asdasdasdasd', '', 0, 0, 0, 0, 0, 0, 1, 1, 1, 1, 1, 1, 1, 1, 4),
(157, 68, 11, 'xxz291917', 1, '127.0.0.1', 1372829339, '', 'asdasdasdasd', '', 0, 0, 0, 0, 0, 0, 1, 1, 1, 1, 1, 1, 1, 2, 4),
(158, 23, 2, 'xxz291917', 1, '127.0.0.1', 1372906277, '', '<blockquote class="blockquote">xxz291917 发表于 2013-05-29 10:46:45<br/>填写帖子内容</blockquote>啊实打实的', '', 0, 0, 0, 0, 0, 0, 1, 1, 1, 1, 1, 1, 1, 2, 1);

-- --------------------------------------------------------

--
-- 表的结构 `posts_log`
--

CREATE TABLE IF NOT EXISTS `posts_log` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `post_id` int(10) unsigned NOT NULL COMMENT 'post回帖子id',
  `user_id` int(10) unsigned NOT NULL,
  `username` varchar(50) NOT NULL,
  `time` int(10) unsigned NOT NULL COMMENT '操作时间',
  `action` varchar(20) NOT NULL COMMENT '操作标识符',
  `data` varchar(1000) NOT NULL COMMENT '操作相关json数据。',
  `reason` varchar(255) NOT NULL COMMENT '操作原因',
  PRIMARY KEY (`id`),
  KEY `post_id` (`post_id`,`time`),
  KEY `post_id_2` (`post_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='前台管理回复日志表' AUTO_INCREMENT=64 ;

--
-- 转存表中的数据 `posts_log`
--

INSERT INTO `posts_log` (`id`, `post_id`, `user_id`, `username`, `time`, `action`, `data`, `reason`) VALUES
(40, 37, 1, 'xxz291917', 1369313364, 'pass', '{"submit":"1","topic_id":"37","del":"1","reason":"lllllllllllll"}', 'lllllllllllll'),
(41, 18, 1, 'xxz291917', 1369724443, 'pass', '{"submit":"1","topic_id":"18,19","del":"1","reason":"SSSS"}', 'SSSS'),
(42, 19, 1, 'xxz291917', 1369724443, 'pass', '{"submit":"1","topic_id":"18,19","del":"1","reason":"SSSS"}', 'SSSS'),
(43, 118, 1, 'xxz291917', 1372299011, 'pass', '{"submit":"1","topic_id":"118","del":"1","reason":"dd"}', 'dd'),
(44, 46, 1, 'xxz291917', 1372299085, 'pass', '{"submit":"1","topic_id":"46,47,48,49,50,51,52,53,54,55","del":"1","reason":""}', ''),
(45, 47, 1, 'xxz291917', 1372299085, 'pass', '{"submit":"1","topic_id":"46,47,48,49,50,51,52,53,54,55","del":"1","reason":""}', ''),
(46, 48, 1, 'xxz291917', 1372299085, 'pass', '{"submit":"1","topic_id":"46,47,48,49,50,51,52,53,54,55","del":"1","reason":""}', ''),
(47, 49, 1, 'xxz291917', 1372299085, 'pass', '{"submit":"1","topic_id":"46,47,48,49,50,51,52,53,54,55","del":"1","reason":""}', ''),
(48, 50, 1, 'xxz291917', 1372299085, 'pass', '{"submit":"1","topic_id":"46,47,48,49,50,51,52,53,54,55","del":"1","reason":""}', ''),
(49, 51, 1, 'xxz291917', 1372299085, 'pass', '{"submit":"1","topic_id":"46,47,48,49,50,51,52,53,54,55","del":"1","reason":""}', ''),
(50, 52, 1, 'xxz291917', 1372299085, 'pass', '{"submit":"1","topic_id":"46,47,48,49,50,51,52,53,54,55","del":"1","reason":""}', ''),
(51, 53, 1, 'xxz291917', 1372299085, 'pass', '{"submit":"1","topic_id":"46,47,48,49,50,51,52,53,54,55","del":"1","reason":""}', ''),
(52, 54, 1, 'xxz291917', 1372299085, 'pass', '{"submit":"1","topic_id":"46,47,48,49,50,51,52,53,54,55","del":"1","reason":""}', ''),
(53, 55, 1, 'xxz291917', 1372299085, 'pass', '{"submit":"1","topic_id":"46,47,48,49,50,51,52,53,54,55","del":"1","reason":""}', ''),
(54, 58, 1, 'xxz291917', 1372299096, 'pass', '{"submit":"1","topic_id":"58,59,60,61,62,63,64,65,66,67","del":"1","reason":""}', ''),
(55, 59, 1, 'xxz291917', 1372299096, 'pass', '{"submit":"1","topic_id":"58,59,60,61,62,63,64,65,66,67","del":"1","reason":""}', ''),
(56, 60, 1, 'xxz291917', 1372299096, 'pass', '{"submit":"1","topic_id":"58,59,60,61,62,63,64,65,66,67","del":"1","reason":""}', ''),
(57, 61, 1, 'xxz291917', 1372299096, 'pass', '{"submit":"1","topic_id":"58,59,60,61,62,63,64,65,66,67","del":"1","reason":""}', ''),
(58, 62, 1, 'xxz291917', 1372299096, 'pass', '{"submit":"1","topic_id":"58,59,60,61,62,63,64,65,66,67","del":"1","reason":""}', ''),
(59, 63, 1, 'xxz291917', 1372299096, 'pass', '{"submit":"1","topic_id":"58,59,60,61,62,63,64,65,66,67","del":"1","reason":""}', ''),
(60, 64, 1, 'xxz291917', 1372299096, 'pass', '{"submit":"1","topic_id":"58,59,60,61,62,63,64,65,66,67","del":"1","reason":""}', ''),
(61, 65, 1, 'xxz291917', 1372299096, 'pass', '{"submit":"1","topic_id":"58,59,60,61,62,63,64,65,66,67","del":"1","reason":""}', ''),
(62, 66, 1, 'xxz291917', 1372299096, 'pass', '{"submit":"1","topic_id":"58,59,60,61,62,63,64,65,66,67","del":"1","reason":""}', ''),
(63, 67, 1, 'xxz291917', 1372299096, 'pass', '{"submit":"1","topic_id":"58,59,60,61,62,63,64,65,66,67","del":"1","reason":""}', '');

-- --------------------------------------------------------

--
-- 表的结构 `posts_supported`
--

CREATE TABLE IF NOT EXISTS `posts_supported` (
  `post_id` int(11) NOT NULL,
  `user_ids` text NOT NULL,
  PRIMARY KEY (`post_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `posts_supported`
--

INSERT INTO `posts_supported` (`post_id`, `user_ids`) VALUES
(148, '1'),
(149, '1'),
(150, '1'),
(151, '1'),
(153, '1'),
(154, '1'),
(156, '1'),
(157, '1');

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
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `topic_id` int(10) unsigned DEFAULT NULL COMMENT '所属主题id',
  `post_id` int(10) unsigned DEFAULT NULL COMMENT '举报帖子id',
  `user_id` int(10) unsigned DEFAULT NULL COMMENT '举报者id',
  `reason` varchar(255) DEFAULT NULL,
  `time` int(11) DEFAULT NULL,
  `operate_user` varchar(20) DEFAULT NULL,
  `operate_time` int(10) unsigned DEFAULT NULL COMMENT '处理状态（1未处理，2已经处理）',
  `status` tinyint(4) DEFAULT NULL COMMENT '记录是否已经处理的举报，1表示已处理，0表示未处理 ',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='帖子举报表' AUTO_INCREMENT=4 ;

--
-- 转存表中的数据 `reports`
--

INSERT INTO `reports` (`id`, `topic_id`, `post_id`, `user_id`, `reason`, `time`, `operate_user`, `operate_time`, `status`) VALUES
(1, 19, 45, 1, '[removed]alert&amp;#40;123&amp;#41;[removed]\r\n&lt;font color=&quot;red&quot;&gt;333333333&lt;/font&gt;', 1371263423, NULL, NULL, 0),
(2, 44, 87, 1, 'mainCmtBtn', 1372304862, NULL, 1372304882, 1),
(3, 67, 152, 1, '', 1372909354, NULL, NULL, 0);

-- --------------------------------------------------------

--
-- 表的结构 `smiley`
--

CREATE TABLE IF NOT EXISTS `smiley` (
  `id` smallint(6) unsigned NOT NULL AUTO_INCREMENT,
  `type_id` smallint(6) unsigned NOT NULL,
  `displayorder` tinyint(1) NOT NULL DEFAULT '0',
  `type` enum('smiley','stamp','stamplist') NOT NULL DEFAULT 'smiley',
  `code` varchar(30) NOT NULL DEFAULT '',
  `url` varchar(30) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `type` (`type`,`displayorder`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=86 ;

--
-- 转存表中的数据 `smiley`
--

INSERT INTO `smiley` (`id`, `type_id`, `displayorder`, `type`, `code`, `url`) VALUES
(1, 1, 1, 'smiley', ':)', 'smile.gif'),
(2, 1, 2, 'smiley', ':(', 'sad.gif'),
(3, 1, 3, 'smiley', ':D', 'biggrin.gif'),
(4, 1, 4, 'smiley', ':''(', 'cry.gif'),
(5, 1, 5, 'smiley', ':@', 'huffy.gif'),
(6, 1, 6, 'smiley', ':o', 'shocked.gif'),
(7, 1, 7, 'smiley', ':P', 'tongue.gif'),
(8, 1, 8, 'smiley', ':$', 'shy.gif'),
(9, 1, 9, 'smiley', ';P', 'titter.gif'),
(10, 1, 10, 'smiley', ':L', 'sweat.gif'),
(11, 1, 11, 'smiley', ':Q', 'mad.gif'),
(12, 1, 12, 'smiley', ':lol', 'lol.gif'),
(13, 1, 13, 'smiley', ':loveliness:', 'loveliness.gif'),
(14, 1, 14, 'smiley', ':funk:', 'funk.gif'),
(15, 1, 15, 'smiley', ':curse:', 'curse.gif'),
(16, 1, 16, 'smiley', ':dizzy:', 'dizzy.gif'),
(17, 1, 17, 'smiley', ':shutup:', 'shutup.gif'),
(18, 1, 18, 'smiley', ':sleepy:', 'sleepy.gif'),
(19, 1, 19, 'smiley', ':hug:', 'hug.gif'),
(20, 1, 20, 'smiley', ':victory:', 'victory.gif'),
(21, 1, 21, 'smiley', ':time:', 'time.gif'),
(22, 1, 22, 'smiley', ':kiss:', 'kiss.gif'),
(23, 1, 23, 'smiley', ':handshake', 'handshake.gif'),
(24, 1, 24, 'smiley', ':call:', 'call.gif'),
(25, 2, 1, 'smiley', '{:2_25:}', '01.gif'),
(26, 2, 2, 'smiley', '{:2_26:}', '02.gif'),
(27, 2, 3, 'smiley', '{:2_27:}', '03.gif'),
(28, 2, 4, 'smiley', '{:2_28:}', '04.gif'),
(29, 2, 5, 'smiley', '{:2_29:}', '05.gif'),
(30, 2, 6, 'smiley', '{:2_30:}', '06.gif'),
(31, 2, 7, 'smiley', '{:2_31:}', '07.gif'),
(32, 2, 8, 'smiley', '{:2_32:}', '08.gif'),
(33, 2, 9, 'smiley', '{:2_33:}', '09.gif'),
(34, 2, 10, 'smiley', '{:2_34:}', '10.gif'),
(35, 2, 11, 'smiley', '{:2_35:}', '11.gif'),
(36, 2, 12, 'smiley', '{:2_36:}', '12.gif'),
(37, 2, 13, 'smiley', '{:2_37:}', '13.gif'),
(38, 2, 14, 'smiley', '{:2_38:}', '14.gif'),
(39, 2, 15, 'smiley', '{:2_39:}', '15.gif'),
(40, 2, 16, 'smiley', '{:2_40:}', '16.gif'),
(41, 3, 1, 'smiley', '{:3_41:}', '01.gif'),
(42, 3, 2, 'smiley', '{:3_42:}', '02.gif'),
(43, 3, 3, 'smiley', '{:3_43:}', '03.gif'),
(44, 3, 4, 'smiley', '{:3_44:}', '04.gif'),
(45, 3, 5, 'smiley', '{:3_45:}', '05.gif'),
(46, 3, 6, 'smiley', '{:3_46:}', '06.gif'),
(47, 3, 7, 'smiley', '{:3_47:}', '07.gif'),
(48, 3, 8, 'smiley', '{:3_48:}', '08.gif'),
(49, 3, 9, 'smiley', '{:3_49:}', '09.gif'),
(50, 3, 10, 'smiley', '{:3_50:}', '10.gif'),
(51, 3, 11, 'smiley', '{:3_51:}', '11.gif'),
(52, 3, 12, 'smiley', '{:3_52:}', '12.gif'),
(53, 3, 13, 'smiley', '{:3_53:}', '13.gif'),
(54, 3, 14, 'smiley', '{:3_54:}', '14.gif'),
(55, 3, 15, 'smiley', '{:3_55:}', '15.gif'),
(56, 3, 16, 'smiley', '{:3_56:}', '16.gif'),
(57, 3, 17, 'smiley', '{:3_57:}', '17.gif'),
(58, 3, 18, 'smiley', '{:3_58:}', '18.gif'),
(59, 3, 19, 'smiley', '{:3_59:}', '19.gif'),
(60, 3, 20, 'smiley', '{:3_60:}', '20.gif'),
(61, 3, 21, 'smiley', '{:3_61:}', '21.gif'),
(62, 3, 22, 'smiley', '{:3_62:}', '22.gif'),
(63, 3, 23, 'smiley', '{:3_63:}', '23.gif'),
(64, 3, 24, 'smiley', '{:3_64:}', '24.gif'),
(65, 0, 0, 'stamp', '精华', '001.gif'),
(66, 0, 1, 'stamp', '热帖', '002.gif'),
(67, 0, 2, 'stamp', '美图', '003.gif'),
(68, 0, 3, 'stamp', '优秀', '004.gif'),
(69, 0, 4, 'stamp', '置顶', '005.gif'),
(70, 0, 5, 'stamp', '推荐', '006.gif'),
(71, 0, 6, 'stamp', '原创', '007.gif'),
(72, 0, 7, 'stamp', '版主推荐', '008.gif'),
(73, 0, 8, 'stamp', '爆料', '009.gif'),
(74, 0, 9, 'stamplist', '精华', '001.small.gif'),
(75, 0, 10, 'stamplist', '热帖', '002.small.gif'),
(76, 0, 11, 'stamplist', '美图', '003.small.gif'),
(77, 0, 12, 'stamplist', '优秀', '004.small.gif'),
(78, 0, 13, 'stamplist', '置顶', '005.small.gif'),
(79, 0, 14, 'stamplist', '推荐', '006.small.gif'),
(80, 0, 15, 'stamplist', '原创', '007.small.gif'),
(81, 0, 16, 'stamplist', '版主推荐', '008.small.gif'),
(82, 0, 17, 'stamplist', '爆料', '009.small.gif'),
(83, 4, 19, 'stamp', '编辑采用', '010.gif'),
(84, 0, 18, 'stamplist', '编辑采用', '010.small.gif'),
(85, 0, 20, 'stamplist', '新人帖', '011.small.gif');

-- --------------------------------------------------------

--
-- 表的结构 `smiley_type`
--

CREATE TABLE IF NOT EXISTS `smiley_type` (
  `id` smallint(6) unsigned NOT NULL AUTO_INCREMENT,
  `available` tinyint(1) NOT NULL DEFAULT '0',
  `name` char(20) NOT NULL,
  `type` enum('smiley','icon','avatar') NOT NULL DEFAULT 'smiley',
  `displayorder` tinyint(3) NOT NULL DEFAULT '0',
  `directory` char(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- 转存表中的数据 `smiley_type`
--

INSERT INTO `smiley_type` (`id`, `available`, `name`, `type`, `displayorder`, `directory`) VALUES
(1, 1, '默认', 'smiley', 1, 'default'),
(2, 1, '酷猴', 'smiley', 2, 'coolmonkey'),
(3, 1, '呆呆男', 'smiley', 3, 'grapeman');

-- --------------------------------------------------------

--
-- 表的结构 `tags`
--

CREATE TABLE IF NOT EXISTS `tags` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `topic_id` int(10) unsigned NOT NULL COMMENT '主题id',
  `tag` varchar(20) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `tag` (`tag`,`topic_id`),
  KEY `topic_id` (`topic_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=133 ;

--
-- 转存表中的数据 `tags`
--

INSERT INTO `tags` (`id`, `topic_id`, `tag`) VALUES
(6, 41, '&lt;script&gt;alert('),
(7, 42, '&lt;script&gt;alert('),
(131, 53, '333'),
(102, 60, '44'),
(100, 60, '444'),
(101, 60, '444444'),
(125, 68, 'ads'),
(51, 59, 'asd'),
(126, 68, 'asd'),
(3, 38, 'hongse'),
(12, 48, 'hongse'),
(5, 38, 'sdfsdf'),
(14, 48, 'sdfsdf'),
(4, 38, 'sfsl'),
(13, 48, 'sfsl'),
(1, 38, 'test'),
(10, 48, 'test'),
(123, 65, '[removed]a'),
(20, 13, '士大夫'),
(132, 53, '士大夫'),
(50, 59, '士大夫'),
(121, 63, '士大夫'),
(21, 13, '士大夫士大夫'),
(122, 63, '大富贵'),
(38, 52, '学智测'),
(119, 61, '张图片附件'),
(8, 46, '标签间请用''空格''或''逗号''隔开，最多可'),
(9, 47, '标签间请用''空格''或''逗号''隔开，最多可'),
(15, 50, '标签间请用''空格''或''逗号''隔开，最多可'),
(16, 51, '标签间请用''空格''或''逗号''隔开，最多可'),
(120, 61, '测试。'),
(118, 61, '添加一'),
(2, 38, '白色'),
(11, 48, '白色'),
(39, 52, '试投票'),
(124, 67, '问答帖子测试');

-- --------------------------------------------------------

--
-- 表的结构 `topics`
--

CREATE TABLE IF NOT EXISTS `topics` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键id',
  `forum_id` mediumint(8) unsigned NOT NULL COMMENT '所属板块id',
  `category_id` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '主题分类id',
  `author` varchar(20) NOT NULL COMMENT '发表者',
  `author_id` int(10) unsigned NOT NULL COMMENT '发表者id',
  `post_time` int(10) unsigned NOT NULL COMMENT '发表时间',
  `subject` varchar(80) NOT NULL COMMENT '主题',
  `last_author` varchar(20) NOT NULL COMMENT '最后回复作者',
  `last_author_id` int(10) unsigned NOT NULL COMMENT '最后发表作者id',
  `last_post_time` int(10) unsigned NOT NULL COMMENT '最后回复时间',
  `tags` varchar(255) NOT NULL DEFAULT '' COMMENT '帖子tags,以‘，’分隔。',
  `views` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '浏览次数',
  `replies` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '回复次数',
  `supports` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '支持次数',
  `opposes` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '反对者人数',
  `top` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否置顶,置顶类型',
  `highlight` varchar(30) NOT NULL COMMENT '高亮样式用'',''分隔',
  `digest` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否精华，精华类型',
  `recommend` tinyint(4) NOT NULL DEFAULT '0' COMMENT '推荐主题',
  `special` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '特殊主题（1正常，2问答，3投票）',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '状态（1正常，2删除，3屏蔽, 4待审核, 5关闭）',
  PRIMARY KEY (`id`),
  KEY `forum_id` (`forum_id`),
  KEY `author_id` (`author_id`),
  KEY `last_post_time` (`last_post_time`),
  KEY `special` (`special`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=69 ;

--
-- 转存表中的数据 `topics`
--

INSERT INTO `topics` (`id`, `forum_id`, `category_id`, `author`, `author_id`, `post_time`, `subject`, `last_author`, `last_author_id`, `last_post_time`, `tags`, `views`, `replies`, `supports`, `opposes`, `top`, `highlight`, `digest`, `recommend`, `special`, `status`) VALUES
(1, 6, 0, 'admin', 1, 0, 'xuezhiceshi', '', 0, 0, '', 8, 0, 0, 0, 0, '0', 0, 0, 0, 0),
(6, 2, 0, 'xxz291917', 1, 1368531645, '输入标题r', '', 0, 0, '', 1, 0, 0, 0, 0, '0', 0, 0, 1, 1),
(7, 2, 0, 'xxz291917', 1, 1368583217, '夏学智测试', '', 0, 0, '', 8, 0, 0, 0, 0, '0', 0, 0, 1, 3),
(8, 2, 0, 'xxz291917', 1, 1368588882, '发帖测试123', 'xxz5291917', 2, 1368772292, '', 10, 2, 0, 0, 0, '0', 0, 0, 1, 1),
(9, 2, 0, 'xxz291917', 1, 1368609926, '输入标题二二', 'xxz291917', 1, 1368702719, '', 9, 1, 0, 0, 1, '0', 0, 0, 1, 1),
(10, 2, 0, 'xxz291917', 1, 1368610003, '输入标题r', 'xxz5291917', 2, 1368774131, '', 131, 5, 0, 0, 0, '#ff00ff,0,1,0', 0, 0, 1, 1),
(11, 12, 0, 'xxz291917', 1, 1368611640, '$type == &#039;edit&#039;', 'xxz291917', 1, 1372316668, '', 191, 24, 0, 0, 0, '0', 0, 0, 1, 1),
(12, 11, 0, 'xxz291917', 1, 1368612732, 'gdgdfgdgdfg', '', 0, 0, '', 16, 0, 0, 0, 0, '0', 1, 1, 1, 1),
(13, 11, 0, 'xxz291917', 1, 1368696809, '输入标题大大大', 'xxz5291917', 2, 1337484852, '士大夫,士大夫士大夫', 403, 8, 0, 0, 0, '#ff00ff,1,1,1', 1, 1, 1, 5),
(14, 6, 0, 'xxz291917', 1, 1368699427, '红星闪闪放光芒', 'xxz291917', 1, 1368701675, '', 6, 4, 0, 0, 0, '0', 0, 0, 1, 1),
(15, 6, 0, 'xxz5291917', 2, 1368772328, '输入标题yy', '', 0, 0, '', 0, 0, 0, 0, 0, '0', 0, 0, 1, 1),
(16, 12, 0, 'xxz5291917', 2, 1368774681, '输入标题凤飞飞', 'xxz291917', 1, 1371105016, '', 30, 2, 0, 0, 0, '0', 0, 0, 1, 1),
(17, 6, 0, 'xxz291917', 1, 1369310155, '是否需要测试', '', 0, 0, '', 1, 0, 0, 0, 0, '', 0, 0, 1, 4),
(18, 11, 0, 'xxz291917', 1, 1369310199, '电梯直达跳转到指定楼层', '', 0, 0, '', 3, 0, 0, 0, 0, '', 0, 0, 1, 4),
(19, 6, 0, 'xxz291917', 1, 1369313698, '审核测试审核测试', '', 0, 0, '', 0, 0, 0, 0, 0, '', 0, 0, 1, 4),
(20, 6, 0, 'xxz291917', 1, 1369314292, '士大夫士大夫士大夫似的', '', 0, 0, '', 0, 0, 0, 0, 0, '', 0, 0, 1, 4),
(21, 6, 0, 'xxz291917', 1, 1369452030, '输入标题ddd', '', 0, 0, '', 1, 0, 0, 0, 0, '', 0, 0, 1, 4),
(22, 11, 0, 'xxz291917', 1, 1369472789, '输入标题士大夫士大夫', 'xxz291917', 1, 1369714000, '', 38, 7, 0, 0, 0, '', 0, 0, 1, 4),
(23, 2, 4, 'xxz291917', 1, 1369740062, '输入标题7777', 'xxz291917', 1, 1372906277, '', 15, 3, 0, 0, 0, '', 0, 0, 1, 1),
(24, 11, 0, 'xxz291917', 1, 1369815311, '输入标题夸奖夸奖夸奖', 'xxz291917', 1, 1369818158, '', 9, 3, 0, 0, 0, '', 0, 0, 1, 4),
(25, 11, 0, 'xxz291917', 1, 1369819307, 'hahhhhhhhh', 'xxz291917', 1, 1369979898, '', 50, 11, 0, 0, 0, '', 0, 0, 1, 4),
(26, 2, 0, 'xxz291917', 1, 1370230068, '去问去问夫士大夫', '', 0, 0, '', 0, 0, 0, 0, 0, '', 0, 0, 3, 1),
(27, 2, 0, 'xxz291917', 1, 1370230139, '去问去问夫士大夫', '', 0, 0, '', 0, 0, 0, 0, 0, '', 0, 0, 3, 1),
(28, 2, 0, 'xxz291917', 1, 1370233072, '去问去问夫士大夫', '', 0, 0, '', 0, 0, 0, 0, 0, '', 0, 0, 3, 1),
(29, 2, 0, 'xxz291917', 1, 1370233126, '去问去问夫士大夫', '', 0, 0, '', 0, 0, 0, 0, 0, '', 0, 0, 3, 1),
(30, 2, 0, 'xxz291917', 1, 1370319680, '辩论发帖测试', '', 0, 0, '', 0, 0, 0, 0, 0, '', 0, 0, 4, 1),
(31, 2, 0, 'xxz291917', 1, 1370319752, '辩论发帖测试', '', 0, 0, '', 0, 0, 0, 0, 0, '', 0, 0, 4, 1),
(32, 2, 0, 'xxz291917', 1, 1370331322, '输入标题jhjhjh', '', 0, 0, '', 0, 0, 0, 0, 0, '', 0, 0, 3, 1),
(33, 2, 0, 'xxz291917', 1, 1370335275, '输入标sdfsdfsdf', '', 0, 0, '', 0, 0, 0, 0, 0, '', 0, 0, 3, 1),
(34, 2, 0, 'xxz291917', 1, 1370335370, '输入标sdfsdfsdf', 'xxz291917', 1, 1371097775, '', 158, 8, 0, 0, 0, '', 0, 0, 3, 1),
(35, 2, 0, 'xxz291917', 1, 1370397845, 'test 白色,,hongse,,   sfsl  sdfsdf', '', 0, 0, '', 0, 0, 0, 0, 0, '', 0, 0, 4, 1),
(36, 2, 0, 'xxz291917', 1, 1370398156, '输入标题士大夫士大夫', '', 0, 0, 'test,白色,hongse,sfsl,sdfsdf', 0, 0, 0, 0, 0, '', 0, 0, 1, 1),
(37, 2, 0, 'xxz291917', 1, 1370418336, '士大夫士大夫标题', '', 0, 0, 'test,白色,hongse,sfsl,sdfsdf', 0, 0, 0, 0, 0, '', 0, 0, 1, 1),
(38, 2, 0, 'xxz291917', 1, 1370418370, '士大夫士大夫标题', '', 0, 0, 'test,白色,hongse,sfsl,sdfsdf', 1, 0, 0, 0, 0, '', 0, 0, 1, 1),
(39, 16, 0, 'xxz291917', 1, 1370585781, 'alert(123);', '', 0, 0, '', 4, 0, 0, 0, 0, '', 2, 1, 1, 4),
(40, 11, 0, 'xxz291917', 1, 1370586266, '&lt;script&gt;alert(123);&lt;/script&gt;', '', 0, 0, '', 4, 0, 0, 0, 0, '', 0, 0, 1, 4),
(41, 2, 0, 'xxz291917', 1, 1370662753, '发表文旦扣减分', '', 0, 0, '&lt;script&gt;alert(123);&lt;/script&gt;', 0, 0, 0, 0, 0, '', 0, 0, 2, 1),
(42, 2, 0, 'xxz291917', 1, 1370662947, '发表文旦扣减分', '', 0, 0, '&lt;script&gt;alert(123);&lt;/script&gt;', 12, 0, 0, 0, 2, '', 0, 0, 2, 1),
(43, 2, 0, 'xxz291917', 1, 1370662983, 'vvvvvvvvvvvvv', '', 0, 0, '', 1, 0, 0, 0, 0, '', 0, 0, 2, 1),
(44, 11, 0, 'xxz291917', 1, 1370770112, '看看我们的成绩', 'xxz291917', 1, 1372312389, '', 174, 6, 0, 0, 0, '#ff00ff,1,0,0', 0, 0, 4, 4),
(45, 11, 0, 'xxz291917', 1, 1370782056, '问答问答问答', '', 0, 0, '', 18, 0, 0, 0, 0, '', 0, 0, 2, 4),
(46, 11, 0, 'xxz291917', 1, 1371702544, '人人人人人人人', '', 0, 0, '标签间请用''空格''或''逗号''隔开，最多可添加5个标签。', 0, 0, 0, 0, 0, '0', 0, 0, 2, 4),
(47, 11, 0, 'xxz291917', 1, 1371726788, '输入问答概述', '', 0, 0, '标签间请用''空格''或''逗号''隔开，最多可添加5个标签。', 0, 0, 0, 0, 0, '0', 0, 0, 2, 4),
(48, 11, 0, 'xxz291917', 1, 1371807011, '本版规则及说明,新手发帖前请花两分钟了解，谢谢', '', 0, 0, 'test,白色,hongse,sfsl,sdfsdf', 1, 0, 0, 0, 0, '0', 0, 1, 2, 4),
(49, 11, 0, 'xxz291917', 1, 1371972423, '红星闪闪放光芒', '', 0, 0, '', 1, 0, 0, 0, 0, '0', 0, 0, 4, 4),
(50, 11, 0, 'xxz291917', 1, 1371977989, '发布帖子333', '', 0, 0, '标签间请用''空格''或''逗号''隔开，最多可添加5个标签。', 1, 0, 0, 0, 0, '0', 0, 0, 3, 4),
(51, 11, 0, 'xxz291917', 1, 1371978022, '发布帖子333', '', 0, 0, '标签间请用''空格''或''逗号''隔开，最多可添加5个标签。', 2, 0, 0, 0, 0, '0', 0, 0, 3, 4),
(52, 11, 0, 'xxz291917', 1, 1372247353, '学智测试投票', '', 0, 0, '学智测,试投票', 19, 0, 0, 0, 0, '0', 0, 0, 3, 4),
(53, 11, 0, 'xxz291917', 1, 1372312851, '红星闪闪放光芒', 'xxz291917', 1, 1372818603, '333,士大夫', 117, 5, 0, 0, 0, '0', 0, 0, 4, 5),
(54, 12, 0, 'xxz291917', 1, 1372317871, 'xuezhi投票', 'xxz291917', 1, 1372320844, '', 39, 2, 0, 0, 0, '0', 0, 0, 3, 1),
(55, 12, 0, 'xxz291917', 1, 1372405704, '输入标题人人', '', 0, 0, '', 0, 0, 0, 0, 0, '0', 0, 0, 1, 1),
(56, 12, 0, 'xxz291917', 1, 1372409705, '输入标题人人', '', 0, 0, '', 0, 0, 0, 0, 0, '0', 0, 0, 1, 1),
(57, 12, 0, 'xxz291917', 1, 1372409831, '士大夫士大夫', '', 0, 0, '', 3, 0, 0, 0, 0, '0', 0, 0, 1, 1),
(58, 12, 0, 'xxz291917', 1, 1372411442, '55555555555', '', 0, 0, '', 2, 0, 0, 0, 0, '0', 0, 0, 1, 1),
(59, 12, 0, 'xxz291917', 1, 1372411535, '人人人人5555人人人人人', '', 0, 0, '士大夫,asd', 15, 0, 0, 0, 0, '0', 0, 0, 1, 1),
(60, 11, 0, 'xxz291917', 1, 1372491400, '44444444444444', '', 0, 0, '444,444444,44', 7, 0, 0, 0, 0, '0', 0, 0, 1, 4),
(61, 12, 0, 'xxz291917', 1, 1372645276, '添加一张图片附件，测试。', 'xxz291917', 1, 1372649054, '添加一,张图片附件,测试。', 32, 1, 0, 0, 2, '0', 0, 0, 1, 1),
(62, 13, 0, 'xxz291917', 1, 1372665723, '去问去问去问去问', '', 0, 0, '', 17, 0, 0, 0, 0, '0', 0, 0, 1, 1),
(63, 11, 3, 'xxz291917', 1, 1372670946, 'xuezhi分类测试。', 'xxz291917', 1, 1372671031, '士大夫,大富贵', 21, 3, 0, 0, 0, '0', 0, 0, 1, 4),
(64, 11, 3, 'xxz291917', 1, 1372737971, 'adasd', '', 0, 1372737971, '', 5, 0, 0, 0, 0, '0', 0, 0, 1, 4),
(65, 16, 0, 'xxz291917', 1, 1372744686, '$this-&gt;input-&gt;post()', '', 0, 1372744686, '[removed]a', 24, 0, 0, 0, 0, '#008080,1,0,1', 0, 0, 1, 1),
(66, 11, 3, 'xxz291917', 1, 1372767152, '空间和客户', 'xxz291917', 1, 1372767369, '', 86, 7, 0, 0, 0, '', 0, 0, 2, 4),
(67, 11, 3, 'xxz291917', 1, 1372769377, '问答帖子测试', 'xxz291917', 1, 1372769422, '问答帖子测试', 70, 4, 0, 0, 0, '', 0, 0, 2, 4),
(68, 11, 3, 'xxz291917', 1, 1372829309, 'dsasdasd', 'xxz291917', 1, 1372829339, 'ads,asd', 7, 4, 0, 0, 0, '', 0, 0, 2, 4);

-- --------------------------------------------------------

--
-- 表的结构 `topics_category`
--

CREATE TABLE IF NOT EXISTS `topics_category` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `forum_id` mediumint(8) unsigned NOT NULL,
  `name` varchar(255) NOT NULL,
  `display_order` mediumint(9) NOT NULL,
  `icon` varchar(255) NOT NULL,
  `moderators` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `fid` (`forum_id`,`display_order`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='主题分类' AUTO_INCREMENT=5 ;

--
-- 转存表中的数据 `topics_category`
--

INSERT INTO `topics_category` (`id`, `forum_id`, `name`, `display_order`, `icon`, `moderators`) VALUES
(1, 11, '666', 1, '', 1),
(3, 11, 'rrr', 0, '', 0),
(4, 2, 'fff', 0, '', 0);

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='主题置顶、高亮、精华、推荐的有效时间表' AUTO_INCREMENT=46 ;

--
-- 转存表中的数据 `topics_endtime`
--

INSERT INTO `topics_endtime` (`id`, `topic_id`, `action`, `end_time`) VALUES
(13, 12, 'digest', 0),
(14, 13, 'digest', 0),
(21, 9, 'top', 0),
(22, 8, 'top', 0),
(24, 11, 'digest', 0),
(25, 44, 'digest', 0),
(26, 39, 'digest', 0),
(27, 61, 'top', 0),
(34, 42, 'top', 1373040000),
(39, 13, 'highlight', 1374249599),
(40, 44, 'highlight', 86399),
(41, 10, 'highlight', 1374163199),
(45, 65, 'highlight', 86399);

-- --------------------------------------------------------

--
-- 表的结构 `topics_log`
--

CREATE TABLE IF NOT EXISTS `topics_log` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `topic_id` int(10) unsigned NOT NULL COMMENT '主题id',
  `user_id` int(10) unsigned NOT NULL,
  `username` varchar(50) NOT NULL,
  `time` int(10) unsigned NOT NULL COMMENT '操作时间',
  `action` varchar(20) NOT NULL COMMENT '操作标识符',
  `data` varchar(1000) NOT NULL COMMENT '操作相关json数据。',
  `reason` varchar(255) NOT NULL COMMENT '操作原因',
  PRIMARY KEY (`id`),
  KEY `topic_id` (`topic_id`,`time`),
  KEY `topic_id_2` (`topic_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='前台管理日志表' AUTO_INCREMENT=72 ;

--
-- 转存表中的数据 `topics_log`
--

INSERT INTO `topics_log` (`id`, `topic_id`, `user_id`, `username`, `time`, `action`, `data`, `reason`) VALUES
(1, 13, 1, 'xxz291917', 1368959568, 'top', '{"submit":"1","topic_id":"13","top":"1","end_time":1369692000,"reason":"ddddddddddddddd"}', 'ddddddddddddddd'),
(2, 13, 1, 'xxz291917', 1368959812, 'top', '{"submit":"1","topic_id":"13","top":"2","end_time":1369692000,"reason":"uiyiyuiyuiyuiy ui"}', 'uiyiyuiyuiyuiy ui'),
(3, 13, 1, 'xxz291917', 1369018051, 'highlight', '{"submit":"1","topic_id":"13","highlight":["#2B65B7","rr","0","0"],"end_time":1369951200,"reason":""}', ''),
(4, 13, 1, 'xxz291917', 1369018449, 'highlight', '{"submit":"1","topic_id":"13","highlight":["#2B65B7","1","0","1"],"end_time":1369864800,"reason":""}', ''),
(5, 13, 1, 'xxz291917', 1369018592, 'highlight', '{"submit":"1","topic_id":"13","highlight":"#2B65B7,0,1,1","end_time":1369864800,"reason":""}', ''),
(6, 13, 1, 'xxz291917', 1369020804, 'bump', '{"submit":"1","topic_id":"13","bump":"1","reason":""}', ''),
(7, 13, 1, 'xxz291917', 1369020852, 'bump', '{"submit":"1","topic_id":"13","bump":"0","reason":""}', ''),
(8, 13, 1, 'xxz291917', 1369021995, 'close', '{"submit":"1","topic_id":"13","close":"1","reason":"\\u5173\\u95ed\\u5e16\\u5b50\\u6d4b\\u8bd5\\u3002"}', '???????'),
(9, 13, 1, 'xxz291917', 1369022029, 'close', '{"submit":"1","topic_id":"13","close":"0","reason":""}', ''),
(10, 13, 1, 'xxz291917', 1369023256, 'ban', '{"submit":"1","topic_id":"13","ban":"1","reason":""}', ''),
(11, 13, 1, 'xxz291917', 1369023544, 'ban', '{"submit":"1","topic_id":"13","ban":"0","reason":""}', ''),
(12, 13, 1, 'xxz291917', 1369023557, 'close', '{"submit":"1","topic_id":"13","close":"1","reason":""}', ''),
(13, 13, 1, 'xxz291917', 1369023683, 'close', '{"submit":"1","topic_id":"13","close":"0","reason":""}', ''),
(14, 13, 1, 'xxz291917', 1369023696, 'ban', '{"submit":"1","topic_id":"13","ban":"1","reason":""}', ''),
(15, 13, 1, 'xxz291917', 1369023705, 'close', '{"submit":"1","topic_id":"13","close":"1","reason":""}', ''),
(16, 13, 1, 'xxz291917', 1369023935, 'digest', '{"submit":"1","topic_id":"13","digest":"3","end_time":1369951200,"reason":""}', ''),
(17, 13, 1, 'xxz291917', 1369027599, 'highlight', '{"submit":"1","topic_id":"13","highlight":"#2B65B7,1,0,1","end_time":1369864800,"reason":""}', ''),
(18, 13, 1, 'xxz291917', 1369027880, 'highlight', '{"submit":"1","topic_id":"13","highlight":"#2B65B7,1,0,1","end_time":1369864800,"reason":""}', ''),
(19, 13, 1, 'xxz291917', 1369028089, 'highlight', '{"submit":"1","topic_id":"13","highlight":"#2B65B7,0,0,1","end_time":1369864800,"reason":""}', ''),
(20, 13, 1, 'xxz291917', 1369028115, 'highlight', '{"submit":"1","topic_id":"13","highlight":"#2B65B7,0,1,1","end_time":1369864800,"reason":""}', ''),
(21, 13, 1, 'xxz291917', 1369031429, 'digest', '{"submit":"1","topic_id":"13","digest":"2","end_time":"","reason":""}', ''),
(22, 13, 1, 'xxz291917', 1369031815, 'move', '{"submit":"1","topic_id":"13","move":"6","reason":"\\u79fb\\u52a8\\u6d4b\\u8bd5\\u3002"}', '?????'),
(23, 13, 1, 'xxz291917', 1369032180, 'move', '{"submit":"1","topic_id":"13","move":"11","reason":""}', ''),
(24, 13, 1, 'xxz291917', 1369136508, 'highlight', '{"submit":"1","topic_id":"13","highlight":"#2B65B7,0,1,1","end_time":1369864800,"reason":""}', ''),
(25, 12, 1, 'xxz291917', 1369139751, 'digest', '{"submit":"1","topic_id":"12,13","digest":"2","end_time":"","reason":""}', ''),
(26, 13, 1, 'xxz291917', 1369139751, 'digest', '{"submit":"1","topic_id":"12,13","digest":"2","end_time":"","reason":""}', ''),
(27, 12, 1, 'xxz291917', 1369139810, 'digest', '{"submit":"1","topic_id":"12,13","digest":"1","end_time":"","reason":""}', ''),
(28, 13, 1, 'xxz291917', 1369139810, 'digest', '{"submit":"1","topic_id":"12,13","digest":"1","end_time":"","reason":""}', ''),
(29, 9, 1, 'xxz291917', 1369187901, 'top', '{"submit":"1","topic_id":"9","top":"0","end_time":"","reason":""}', ''),
(30, 9, 1, 'xxz291917', 1369187964, 'top', '{"submit":"1","topic_id":"9","top":"0","end_time":"","reason":""}', ''),
(31, 6, 1, 'xxz291917', 1369295366, 'top', '{"submit":"1","topic_id":"6,7","top":"1","end_time":1369864800,"reason":""}', ''),
(32, 7, 1, 'xxz291917', 1369295366, 'top', '{"submit":"1","topic_id":"6,7","top":"1","end_time":1369864800,"reason":""}', ''),
(33, 9, 1, 'xxz291917', 1369295544, 'top', '{"submit":"1","topic_id":"9","top":"0","end_time":"","reason":""}', ''),
(34, 8, 1, 'xxz291917', 1369296414, 'top', '{"submit":"1","topic_id":"8,9","top":"1","end_time":"","reason":""}', ''),
(35, 9, 1, 'xxz291917', 1369296414, 'top', '{"submit":"1","topic_id":"8,9","top":"1","end_time":"","reason":""}', ''),
(36, 8, 1, 'xxz291917', 1369296428, 'top', '{"submit":"1","topic_id":"8","top":"0","end_time":"","reason":""}', ''),
(37, 7, 1, 'xxz291917', 1369296685, 'ban', '{"submit":"1","topic_id":"7","ban":"1","reason":""}', ''),
(38, 16, 1, 'xxz291917', 1369309889, 'pass', '{"submit":"1","topic_id":"16","del":"1","reason":"555555555555555555555555555555555"}', '555555555555555555555555555555555'),
(39, 37, 1, 'xxz291917', 1369312236, 'pass', '{"submit":"1","topic_id":"37","del":"1","reason":"iooiopi"}', 'iooiopi'),
(40, 37, 1, 'xxz291917', 1369313116, 'pass', '{"submit":"1","topic_id":"37","del":"1","reason":"jjjjjjjjjj"}', 'jjjjjjjjjj'),
(41, 23, 1, 'xxz291917', 1370585464, 'editcategory', '{"submit":"1","topic_id":"23","editcategory":"3","reason":""}', ''),
(42, 23, 1, 'xxz291917', 1370585470, 'editcategory', '{"submit":"1","topic_id":"23","editcategory":"4","reason":""}', ''),
(43, 11, 1, 'xxz291917', 1372143758, 'digest', '{"submit":"1","topic_id":"11","digest":"3","end_time":"","reason":""}', ''),
(44, 11, 1, 'xxz291917', 1372143929, 'digest', '{"submit":"1","topic_id":"11","digest":"3","end_time":"","reason":""}', ''),
(45, 11, 1, 'xxz291917', 1372231777, 'digest', '{"submit":"1","topic_id":"11","digest":"0","end_time":1372262400,"reason":""}', ''),
(46, 44, 1, 'xxz291917', 1372304229, 'digest', '{"submit":"1","topic_id":"44","digest":"1","end_time":"","reason":""}', ''),
(47, 44, 1, 'xxz291917', 1372670450, 'digest', '{"submit":"1","topic_id":"44","digest":"0","end_time":"","reason":""}', ''),
(48, 39, 1, 'xxz291917', 1372670480, 'digest', '{"submit":"1","topic_id":"39","digest":"2","end_time":"","reason":""}', ''),
(49, 63, 1, 'xxz291917', 1372671045, 'editcategory', '{"submit":"1","topic_id":"63","editcategory":"3","reason":""}', ''),
(50, 61, 1, 'xxz291917', 1372739088, 'top', '{"submit":"1","topic_id":"61","top":"2","end_time":"","reason":""}', ''),
(51, 42, 1, 'xxz291917', 1372763709, 'top', '{"submit":"1","topic_id":"42","top":"2","end_time":"","reason":""}', ''),
(52, 42, 1, 'xxz291917', 1372763749, 'top', '{"submit":"1","topic_id":"42","top":"3","end_time":"","reason":""}', ''),
(53, 42, 1, 'xxz291917', 1372763922, 'top', '{"submit":"1","topic_id":"42","top":"2","end_time":"1372780800","reason":""}', ''),
(54, 42, 1, 'xxz291917', 1372764080, 'top', '{"submit":"1","topic_id":"42","top":"2","end_time":"1372780800","reason":""}', ''),
(55, 42, 1, 'xxz291917', 1372764110, 'top', '{"submit":"1","topic_id":"42","top":"2","end_time":"1372867200","reason":""}', ''),
(56, 42, 1, 'xxz291917', 1372764119, 'top', '{"submit":"1","topic_id":"42","top":"2","end_time":"1372780800","reason":""}', ''),
(57, 42, 1, 'xxz291917', 1372764136, 'top', '{"submit":"1","topic_id":"42","top":"2","end_time":"1372953600","reason":""}', ''),
(58, 10, 1, 'xxz291917', 1372765126, 'highlight', '{"submit":"1","topic_id":"10","highlight":"#ff00ff,0,0,0","end_time":"1374076800","reason":"$highlight"}', '$highlight'),
(59, 13, 1, 'xxz291917', 1372766123, 'highlight', '{"submit":"1","topic_id":"13","highlight":"#ff00ff,1,1,1","end_time":"","reason":""}', ''),
(60, 13, 1, 'xxz291917', 1372766305, 'highlight', '{"submit":"1","topic_id":"13","highlight":"#ff00ff,0,1,1","end_time":"","reason":""}', ''),
(61, 13, 1, 'xxz291917', 1372766352, 'highlight', '{"submit":"1","topic_id":"13","highlight":"#ff00ff,0,1,1","end_time":"1374163200","reason":""}', ''),
(62, 13, 1, 'xxz291917', 1372766670, 'highlight', '{"submit":"1","topic_id":"13","highlight":"#ff00ff,1,1,1","end_time":"1374163200","reason":""}', ''),
(63, 44, 1, 'xxz291917', 1372766735, 'highlight', '{"submit":"1","topic_id":"44","highlight":"#ff00ff,1,0,0","end_time":"","reason":""}', ''),
(64, 53, 1, 'xxz291917', 1372818603, 'bump', '{"submit":"1","topic_id":"53","bump":"1","reason":""}', ''),
(65, 10, 1, 'xxz291917', 1372819307, 'highlight', '{"submit":"1","topic_id":"10","highlight":"#ff00ff,0,1,0","end_time":"1374076800","reason":""}', ''),
(66, 39, 1, 'xxz291917', 1372840419, 'move', '{"submit":"1","topic_id":"39","move":"6","reason":""}', ''),
(67, 39, 1, 'xxz291917', 1372840551, 'move', '{"submit":"1","topic_id":"39","move":"16","reason":""}', ''),
(68, 65, 1, 'xxz291917', 1372840941, 'highlight', '{"submit":"1","topic_id":"65","highlight":"#ffcc00,0,1,0","end_time":"","reason":"sdfsdfsdf"}', 'sdfsdfsdf'),
(69, 65, 1, 'xxz291917', 1372841007, 'highlight', '{"submit":"1","topic_id":"65","highlight":"#00ffff,0,1,1","end_time":"","reason":""}', ''),
(70, 65, 1, 'xxz291917', 1372841054, 'highlight', '{"submit":"1","topic_id":"65","highlight":"#008080,1,0,1","end_time":"1374854400","reason":""}', ''),
(71, 65, 1, 'xxz291917', 1372841155, 'highlight', '{"submit":"1","topic_id":"65","highlight":"#008080,1,0,1","end_time":"","reason":""}', '');

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
(1, 16, 0),
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
  `id` int(10) unsigned NOT NULL COMMENT '用户id',
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
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='论坛用户表';

--
-- 转存表中的数据 `users`
--

INSERT INTO `users` (`id`, `email`, `username`, `password`, `credits`, `group_id`, `member_id`, `groups`, `icon`, `gender`, `signature`, `regdate`, `status`) VALUES
(1, 'xxz291917@163.com', 'xxz291917', '', 2509, 1, 14, '2', '', 0, '<font color=''red''>签名测试22</font>', 1298763453, 1),
(2, 'xxz5291917@163.com', 'xxz5291917', '', 202, 16, 12, '16', '', 1, '<font color=''green''>签名测试</font>', 1298543453, 1);

-- --------------------------------------------------------

--
-- 表的结构 `users_admin`
--

CREATE TABLE IF NOT EXISTS `users_admin` (
  `user_id` int(11) NOT NULL,
  `username` varchar(80) NOT NULL,
  `password` varchar(32) NOT NULL,
  `email` varchar(100) NOT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `users_admin`
--

INSERT INTO `users_admin` (`user_id`, `username`, `password`, `email`) VALUES
(1, 'xxz291917', '96e79218965eb72c92a549dd5a330112', 'xxz291917@163.com'),
(2, 'xxz5291917', '96e79218965eb72c92a549dd5a330112', 'xxz291917@163.com');

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
  `last_login_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '最后访问时间',
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

INSERT INTO `users_extra` (`user_id`, `posts`, `digests`, `today_posts`, `today_uploads`, `last_login_time`, `last_login_ip`, `last_post_time`, `last_active_time`, `online_time`, `extcredits1`, `extcredits2`, `extcredits3`, `extcredits4`, `extcredits5`, `extcredits6`, `extcredits7`, `extcredits8`, `last_credit_affect_log`) VALUES
(1, 136, 0, 1, 136, 1372914548, '127.0.0.1', 1372906277, 1372916431, 1884, 373, 328, 734, 0, 0, 0, 0, 0, ''),
(2, 16, 0, 17, 16, 0, '', 1368774681, 1368774681, 0, 30, 39, 34, 0, 0, 0, 0, 0, '');

-- --------------------------------------------------------

--
-- 表的结构 `users_medal`
--

CREATE TABLE IF NOT EXISTS `users_medal` (
  `user_id` int(10) unsigned NOT NULL,
  `medal_id` int(10) unsigned NOT NULL,
  `expired_time` int(10) unsigned NOT NULL,
  PRIMARY KEY (`user_id`,`medal_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
