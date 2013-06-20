-- phpMyAdmin SQL Dump
-- version 3.5.2.2
-- http://www.phpmyadmin.net
--
-- 主机: 127.0.0.1
-- 生成日期: 2013 年 06 月 20 日 15:01
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
  PRIMARY KEY (`topic_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='问答扩展表';

--
-- 转存表中的数据 `ask`
--

INSERT INTO `ask` (`topic_id`, `price`, `best_answer`) VALUES
(41, 5, 0),
(42, 5, 0),
(43, 5, 0),
(45, 20, 0),
(46, 0, 0),
(47, 0, 0);

-- --------------------------------------------------------

--
-- 表的结构 `ask_posts`
--

CREATE TABLE IF NOT EXISTS `ask_posts` (
  `topic_id` int(10) unsigned NOT NULL COMMENT '主题id',
  `post_id` int(11) unsigned NOT NULL COMMENT '回复posts的id',
  `user_id` int(10) unsigned NOT NULL COMMENT '回答者id',
  `supports` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '支持人数',
  `opposes` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '反对人数'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='附件表';

--
-- 转存表中的数据 `attachments`
--

INSERT INTO `attachments` (`id`, `topic_id`, `post_id`, `user_id`, `upload_time`, `size`, `extension`, `filename`, `path`, `description`, `is_image`, `is_thumb`, `is_remote`, `downloads`) VALUES
(1, 25, 73, 1, 1369979836, 15.31, 'docx', '5520a1cd411ab52d3a772502d1deafd7.docx', 'uploads/file/5520a1cd411ab52d3a772502d1deafd7.docx', '士大夫士大夫', 0, 0, 0, 0),
(2, 25, 73, 1, 1369979843, 10.54, 'jpg', '53adced7aeae07272c908a9b5149e518.jpg', 'uploads/image/53adced7aeae07272c908a9b5149e518.jpg', '师傅的说法', 1, 0, 0, 0),
(3, 16, 74, 1, 1369988084, 10.54, 'jpg', '9c77e8083802b692e1d79b063ae823f1.jpg', 'uploads/image/9c77e8083802b692e1d79b063ae823f1.jpg', '学智测试图片', 1, 0, 0, 0);

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='附件表' AUTO_INCREMENT=4 ;

--
-- 转存表中的数据 `attachments_unused`
--

INSERT INTO `attachments_unused` (`id`, `user_id`, `upload_time`, `size`, `extension`, `filename`, `path`, `description`, `is_image`, `is_thumb`) VALUES
(1, 1, 1370259021, 81.83, 'jpg', '81b02032c5cd8f7c013e9036afa81f61.jpg', 'uploads/image/81b02032c5cd8f7c013e9036afa81f61.jpg', '', 1, 0),
(2, 1, 1370660619, 81.83, 'jpg', '9574e0d7244c79c89374a3732ddf6c98.jpg', 'uploads/file/9574e0d7244c79c89374a3732ddf6c98.jpg', '', 1, 0),
(3, 1, 1371635857, 27.85, 'jpg', '7e79dfed920432070064ba9bd8c61035.jpg', 'uploads/image/7e79dfed920432070064ba9bd8c61035.jpg', '', 1, 0);

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='积分日志表' AUTO_INCREMENT=302 ;

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
(301, 'extcredits3', 'post', 3, '发表主题', 1, 'xxz291917', 1371726788);

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
(44, 1, 1370770112, 1370448000, 0, 1, 0, 0, 'xxz291917', 0, '', '学智测试辩论', '学智测试辩论', '', '', '', 0, 1);

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
(90, 44, 1, 2, 1370781961, 1);

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- 转存表中的数据 `drafts`
--

INSERT INTO `drafts` (`id`, `user_id`, `topic_id`, `forum_id`, `special`, `subject`, `content`, `remain_data`, `time`) VALUES
(3, 1, 0, 11, 0, '$post', 0x24706f737424703c7374726f6e673e6f73743c2f7374726f6e673e3c7374726f6e673e24706f73743c2f7374726f6e673e3c7374726f6e673e24706f73743c2f7374726f6e673e3c7374726f6e673e24706f3c2f7374726f6e673e737424706f73747b3a325f33373a7d, '{"editcategory":"0","price":"4","tags":"test \\u767d\\u8272,,hongse,,   sfsl  sdfsdf"}', 1371732576),
(4, 1, 0, 0, 0, '输入问答概述', 0x797472797472797472797472797275797279747279, '{"editcategory":"0","price":"","tags":"\\u6807\\u7b7e\\u95f4\\u8bf7\\u7528''\\u7a7a\\u683c''\\u6216''\\u9017\\u53f7''\\u9694\\u5f00\\uff0c\\u6700\\u591a\\u53ef\\u6dfb\\u52a05\\u4e2a\\u6807\\u7b7e\\u3002"}', 1371732422),
(5, 1, 0, 0, 2, '$post', 0x24706f737424703c7374726f6e673e6f73743c2f7374726f6e673e3c7374726f6e673e24706f73743c2f7374726f6e673e3c7374726f6e673e24706f73743c2f7374726f6e673e3c7374726f6e673e24706f3c2f7374726f6e673e737424706f73747b3a325f33373a7d, '{"editcategory":"0","price":"4","tags":"test \\u767d\\u8272,,hongse,,   sfsl  sdfsdf"}', 1371732613),
(6, 1, 0, 11, 2, '$post', 0x24706f737424703c7374726f6e673e6f73743c2f7374726f6e673e3c7374726f6e673e24706f73743c2f7374726f6e673e3c7374726f6e673e24706f73743c2f7374726f6e673e3c7374726f6e673e24706f3c2f7374726f6e673e737424706f73747b3a325f33373a7d, '{"editcategory":"0","price":"4","tags":"test \\u767d\\u8272,,hongse,,   sfsl  sdfsdf","forum_id":"11"}', 1371732649);

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
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '显示状态 (1正常,0关闭)',
  PRIMARY KEY (`id`),
  KEY `forum` (`status`,`type`,`display_order`),
  KEY `fup_type` (`parent_id`,`type`,`display_order`),
  KEY `fup` (`parent_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='论坛版块' AUTO_INCREMENT=13 ;

--
-- 转存表中的数据 `forums`
--

INSERT INTO `forums` (`id`, `parent_id`, `type`, `name`, `description`, `icon`, `manager`, `display_order`, `create_user`, `create_user_id`, `create_time`, `allow_special`, `is_category`, `is_cat_necessary`, `is_anonymous`, `is_html`, `is_bbcode`, `is_smilies`, `is_media`, `check`, `allow_visit`, `allow_read`, `allow_post`, `allow_reply`, `allow_upload`, `allow_download`, `seo_title`, `seo_keywords`, `seo_description`, `credit_setting`, `status`) VALUES
(1, 0, 'group', 'cript>', '测试新分类', '', 'dsdff', 1, '', 0, 0, '', 0, 0, 0, 0, 0, 0, 0, 0, '1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19', '1,2,3,4,6,7', '1,2,3,4,5,6', '1,2,3,4,5,9,10', '1,2,3', '1,2,3', '论坛seo', '', '', '{"post":{"extcredits1":"3","extcredits2":"4","extcredits3":"5"},"reply":{"extcredits1":"","extcredits2":"6","extcredits3":""},"digest":{"extcredits1":"","extcredits2":"7","extcredits3":""},"postattach":{"extcredits1":"","extcredits2":"8","extcredits3":""},"getattach":{"extcredits1":"","extcredits2":"","extcredits3":""},"daylogin":{"extcredits1":"","extcredits2":"","extcredits3":""},"search":{"extcredits1":"","extcredits2":"","extcredits3":""}}', 1),
(2, 1, 'forum', 'test版', '测试默认版块', '', 'xxz291917', 2, '', 0, 0, '1,2', 0, 0, 0, 1, 1, 0, 0, 0, '1,2,3,16,17,18,19,10,11,12,13,14,15', '1,2,3,16,17,18,19,10,11,12,13,14,15', '1,2,3,16,17,18,19,10,11,12,13,14,15', '1,2,3,16,17,18,19,10,11,12,13,14,15', '1,2,3,16,17,18,19,10,11,12,13,14,15', '1,2,3,16,17,18,19,10,11,12,13,14,15', '', '', '', '{"post":{"extcredits1":"3","extcredits2":"4","extcredits3":"6"},"reply":{"extcredits1":"2","extcredits2":"2","extcredits3":"3"},"digest":{"extcredits1":"","extcredits2":"","extcredits3":""},"postattach":{"extcredits1":"","extcredits2":"","extcredits3":""},"getattach":{"extcredits1":"0","extcredits2":"5","extcredits3":"4"},"daylogin":{"extcredits1":"","extcredits2":"","extcredits3":""},"search":{"extcredits1":"","extcredits2":"","extcredits3":""}}', 0),
(4, 0, 'group', 'test545', '测试版块内容哦测试版块内容哦测试版块内容哦测试版块内容哦测试版块内容哦测试版块内容哦测试版块内容哦', '', 'admin', 5, '', 0, 0, '2,3', 0, 0, 0, 1, 1, 1, 1, 2, '', '', '', '', '', '', '论坛seo', '论坛seo 论坛seo', '论坛seo论坛seo论坛seo论坛seo论坛seo论坛seo', '', 1),
(6, 2, 'sub', '学智测试版块', '', '', '', 0, '', 0, 0, '', 0, 0, 0, 0, 0, 0, 0, 2, '1,2', '1,2', '1,2', '1,2', '1,2', '1,2', '', '', '', '{"post":{"extcredits1":"3","extcredits2":"5","extcredits3":"5"},"reply":{"extcredits1":"","extcredits2":"","extcredits3":""},"digest":{"extcredits1":"","extcredits2":"","extcredits3":""},"postattach":{"extcredits1":"","extcredits2":"","extcredits3":""},"getattach":{"extcredits1":"","extcredits2":"","extcredits3":""},"daylogin":{"extcredits1":"","extcredits2":"","extcredits3":""},"search":{"extcredits1":"","extcredits2":"","extcredits3":""}}', 1),
(10, 0, 'group', '子版块测试', '', '', '', 2, '', 0, 0, '', 0, 0, 0, 0, 0, 0, 0, 0, '', '', '', '', '', '', '', '', '', '', 0),
(11, 1, 'forum', 'test版块', '', '', '', 0, 'xxz291917', 1, 1367912803, '', 1, 0, 0, 0, 0, 0, 0, 2, '', '', '', '', '', '', '', '', '', '{"post":{"extcredits1":"2","extcredits2":"3","extcredits3":"3"},"reply":{"extcredits1":"4","extcredits2":"4","extcredits3":"4"},"digest":{"extcredits1":"4","extcredits2":"3","extcredits3":"3"},"postattach":{"extcredits1":"","extcredits2":"","extcredits3":""},"getattach":{"extcredits1":"","extcredits2":"","extcredits3":""},"daylogin":{"extcredits1":"","extcredits2":"","extcredits3":""},"search":{"extcredits1":"","extcredits2":"","extcredits3":""}}', 0),
(12, 10, 'forum', '学习好习惯', '', '', '', 0, 'xxz291917', 1, 1368584217, '', 0, 0, 0, 0, 0, 0, 0, 0, '', '', '', '', '', '', '', '', '', '', 0);

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
(2, 29, 14, 6, 2, 34, 1371097775, 'xxz291917'),
(6, 8, 5, 1, 1, 21, 1369452030, 'xxz291917'),
(10, 1, 1, 1, 1, 15, 1368772328, 'xxz5291917'),
(11, 40, 12, 2, 2, 47, 1371726788, 'xxz291917'),
(12, 15, 2, 1, 2, 16, 1371105016, 'xxz291917');

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
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '1正常，2申请，3删除',
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`,`medal_id`),
  KEY `time` (`time`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=21 ;

--
-- 转存表中的数据 `medals_log`
--

INSERT INTO `medals_log` (`id`, `user_id`, `medal_id`, `time`, `expired_time`, `description`, `status`) VALUES
(1, 1, 8, 1371544640, 1371657600, '', 0),
(2, 1, 10, 1371544640, 1371657600, '', 0),
(3, 2, 8, 1371544640, 1371657600, '', 0),
(4, 2, 10, 1371544640, 1371657600, '', 0),
(5, 1, 7, 1371544935, 1370275200, '', 1),
(6, 1, 8, 1371544935, 1370275200, '', 1),
(7, 2, 7, 1371544935, 1370275200, '', 1),
(8, 2, 8, 1371544935, 1370275200, '', 1),
(9, 1, 7, 1371545347, 1370188800, '', 1),
(10, 1, 9, 1371545347, 1370188800, '', 1),
(11, 2, 7, 1371545347, 1370188800, '', 1),
(12, 2, 9, 1371545347, 1370188800, '', 1),
(13, 1, 7, 1371545712, 1371657600, '', 1),
(14, 1, 8, 1371545712, 1371657600, '', 1),
(15, 2, 7, 1371545712, 1371657600, '', 1),
(16, 2, 8, 1371545712, 1371657600, '', 1),
(17, 1, 7, 1371545843, 1372262400, '', 1),
(18, 1, 8, 1371545843, 1372262400, '', 1),
(19, 2, 7, 1371545843, 1372262400, '', 1),
(20, 2, 8, 1371545843, 1372262400, '', 1);

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
(34, 0, 1, 1, 2, 1378662983, 'www[|]dd', 10);

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- 转存表中的数据 `poll_options`
--

INSERT INTO `poll_options` (`id`, `topic_id`, `votes`, `display_order`, `option`, `voterids`) VALUES
(1, 29, 0, 0, '士大夫士大夫', ''),
(2, 29, 0, 1, '士大夫士大夫撒', ''),
(3, 29, 0, 2, 'sdfsdf6', ''),
(4, 34, 4, 0, 'www发发反反复复反反复复', '1,1,1'),
(5, 34, 7, 1, 'ddffsdf', '1,1,1,1,1,1,1'),
(6, 34, 4, 2, '555554444444467667', '1,1,1,1');

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=101 ;

--
-- 转存表中的数据 `posts`
--

INSERT INTO `posts` (`id`, `topic_id`, `forum_id`, `author`, `author_id`, `author_ip`, `post_time`, `subject`, `content`, `edit_user`, `edit_user_id`, `edit_time`, `attachment`, `check_status`, `is_first`, `is_report`, `is_bbcode`, `is_smilies`, `is_media`, `is_html`, `is_anonymous`, `is_hide`, `is_sign`, `position`, `status`) VALUES
(1, 4, 2, 'xxz291917', 1, '127.0.0.1', 1368531409, '输入标题r', '填写帖子内容', '', 0, 0, 0, 0, 1, 0, 1, 1, 1, 1, 1, 1, 1, 0, 1),
(2, 6, 2, 'xxz291917', 1, '127.0.0.1', 1368531645, '输入标题r', '填写帖子内容', '', 0, 0, 0, 0, 1, 0, 1, 1, 1, 1, 1, 1, 1, 0, 1),
(6, 10, 2, 'xxz291917', 1, '127.0.0.1', 1368535793, '输入标题r', '填写帖子内容', '', 0, 0, 0, 0, 1, 0, 1, 1, 1, 1, 1, 1, 1, 0, 1),
(7, 7, 2, 'xxz291917', 1, '127.0.0.1', 1368583217, '夏学智测试', '今天的内容要新鲜哦\r\n<p class="MsoNormalCxSpFirst" style="margin-left:6.55pt;text-indent:36.0pt;">\r\n	<span style="font-family:&quot;">显式地把已<span>经</span>不再被引<span>用</span>的对象<span>赋</span>为</span><span> </span><span>nu</span><span>l</span><span>l</span>\r\n</p>\r\n<p class="MsoNormalCxSpMiddle" style="margin-left:6.55pt;text-indent:36.0pt;">\r\n	<span style="font-family:&quot;">不要频繁初<span>始</span>化对象</span><b><span></span></b>\r\n</p>\r\n<p class="MsoNormalCxSpMiddle" style="margin-left:6.55pt;text-indent:36.0pt;">\r\n	<span style="font-family:&quot;">除非必要，<span>否</span>则不要<span>在</span>循环内<span>初</span>始化对象</span><span> <span></span></span>\r\n</p>\r\n<p class="MsoNormalCxSpMiddle" style="margin-left:6.55pt;text-indent:36.0pt;">\r\n	<span style="font-family:&quot;">示例：</span><b><span></span></b>\r\n</p>\r\n<p class="MsoNormalCxSpMiddle" style="margin-left:6.55pt;text-indent:36.0pt;">\r\n	<span>f</span><span>o</span><span>r <span>(</span><span>$</span>i<span> </span>= <span>0</span>; <span>$</span>i<span> </span><span>&lt;</span><span>$</span><span>r</span><span>o</span><span>w</span>s;<span> </span><span>$i</span><span>++</span>)<span> </span>{</span><b><span></span></b>\r\n</p>\r\n<p class="MsoNormalCxSpMiddle" style="margin-left:36.0pt;text-indent:36.0pt;">\r\n	<span>$</span><span>c<span>o</span><span>mm</span><span>o</span><span>n</span><span>W</span><span>r</span><span>k</span><span>S</span><span>h</span>t<span> </span>= <span>n</span><span>e</span>w<span> </span><span>C</span><span>o</span><span>mm</span><span>o</span><span>n</span><span>W</span><span>r</span><span>k</span><span>S</span><span>h</span><span>t()</span>;</span><b><span></span></b>\r\n</p>\r\n<p class="MsoNormalCxSpMiddle" style="margin-left:36.0pt;text-indent:36.0pt;">\r\n	<span>…</span><b><span></span></b>\r\n</p>\r\n<p class="MsoNormalCxSpMiddle" style="text-indent:41.45pt;">\r\n	<span>}</span><b><span></span></b>\r\n</p>\r\n<p class="MsoNormalCxSpMiddle" style="text-indent:41.45pt;">\r\n	<span style="font-family:&quot;">应写成：</span><b><span></span></b>\r\n</p>\r\n<p class="MsoNormalCxSpMiddle" style="text-indent:40.35pt;">\r\n	<span>$</span><span>c<span>o</span><span>mm</span><span>o</span><span>n</span><span>W</span><span>r</span><span>k</span><span>S</span><span>h</span>t<span> </span>= <span>n</span><span>e</span>w<span> </span><span>C</span><span>o</span><span>mm</span><span>o</span><span>n</span><span>W</span><span>r</span><span>k</span><span>S</span><span>h</span><span>t()</span>;</span><b><span></span></b>\r\n</p>\r\n<p class="MsoNormalCxSpMiddle" style="text-indent:42.2pt;">\r\n	<span>f</span><span>o</span><span>r <span>(</span><span>$</span>i<span> </span>= <span>0</span>; <span>$</span>i<span> </span><span>&lt;</span><span>r</span><span>o</span><span>w</span>s;<span> </span><span>$i</span><span>++</span>)<span> </span>{</span><b><span></span></b>\r\n</p>\r\n<p class="MsoNormalCxSpMiddle" style="margin-left:30.55pt;text-indent:41.45pt;">\r\n	<span>…</span><b><span></span></b>\r\n</p>\r\n<p class="MsoNormalCxSpMiddle" style="text-indent:41.45pt;">\r\n	<span>}</span><b><span></span></b>\r\n</p>', '', 0, 0, 0, 0, 1, 0, 1, 1, 1, 1, 1, 1, 1, 0, 1),
(8, 8, 2, 'xxz291917', 1, '127.0.0.1', 1368588882, '发帖测试123', '<table>\r\n	<tbody>\r\n		<tr>\r\n			<td class="c1 td1">\r\n				tid\r\n			</td>\r\n			<td class="c2 td1">\r\n				mediumint(8) unsigned\r\n			</td>\r\n			<td class="c3 td1">\r\n				&nbsp;0\r\n			</td>\r\n			<td class="c4 td1">\r\n				&nbsp;NO\r\n			</td>\r\n			<td class="c5 td1">\r\n				&nbsp;\r\n			</td>\r\n			<td class="c6 td1">\r\n				&nbsp;主题id\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td class="c1 td2">\r\n				overt\r\n			</td>\r\n			<td class="c2 td2">\r\n				tinyint(1)\r\n			</td>\r\n			<td class="c3 td2">\r\n				&nbsp;0\r\n			</td>\r\n			<td class="c4 td2">\r\n				&nbsp;NO\r\n			</td>\r\n			<td class="c5 td2">\r\n				&nbsp;\r\n			</td>\r\n			<td class="c6 td2">\r\n				&nbsp;是否公开投票参与人\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td class="c1 td1">\r\n				multiple\r\n			</td>\r\n			<td class="c2 td1">\r\n				tinyint(1)\r\n			</td>\r\n			<td class="c3 td1">\r\n				&nbsp;0\r\n			</td>\r\n			<td class="c4 td1">\r\n				&nbsp;NO\r\n			</td>\r\n			<td class="c5 td1">\r\n				&nbsp;\r\n			</td>\r\n			<td class="c6 td1">\r\n				&nbsp;是否多选\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td class="c1 td2">\r\n				visible\r\n			</td>\r\n			<td class="c2 td2">\r\n				tinyint(1)\r\n			</td>\r\n			<td class="c3 td2">\r\n				&nbsp;0\r\n			</td>\r\n			<td class="c4 td2">\r\n				&nbsp;NO\r\n			</td>\r\n			<td class="c5 td2">\r\n				&nbsp;\r\n			</td>\r\n			<td class="c6 td2">\r\n				&nbsp;是否投票后可见\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td class="c1 td1">\r\n				maxchoices\r\n			</td>\r\n			<td class="c2 td1">\r\n				tinyint(3) unsigned\r\n			</td>\r\n			<td class="c3 td1">\r\n				&nbsp;0\r\n			</td>\r\n			<td class="c4 td1">\r\n				&nbsp;NO\r\n			</td>\r\n			<td class="c5 td1">\r\n				&nbsp;\r\n			</td>\r\n			<td class="c6 td1">\r\n				&nbsp;最大可选项数\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td class="c1 td2">\r\n				expiration\r\n			</td>\r\n			<td class="c2 td2">\r\n				int(10) unsigned\r\n			</td>\r\n			<td class="c3 td2">\r\n				&nbsp;0\r\n			</td>\r\n			<td class="c4 td2">\r\n				&nbsp;NO\r\n			</td>\r\n			<td class="c5 td2">\r\n				&nbsp;\r\n			</td>\r\n			<td class="c6 td2">\r\n				&nbsp;过期时间\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td class="c1 td1">\r\n				pollpreview\r\n			</td>\r\n			<td class="c2 td1">\r\n				varchar(255)\r\n			</td>\r\n			<td class="c3 td1">\r\n				&nbsp;\r\n			</td>\r\n			<td class="c4 td1">\r\n				&nbsp;NO\r\n			</td>\r\n			<td class="c5 td1">\r\n				&nbsp;\r\n			</td>\r\n			<td class="c6 td1">\r\n				&nbsp;选项内容前两项预览\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td class="c1 td2">\r\n				voters\r\n			</td>\r\n			<td class="c2 td2">\r\n				mediumint(8) unsigned\r\n			</td>\r\n			<td class="c3 td2">\r\n				&nbsp;0\r\n			</td>\r\n			<td class="c4 td2">\r\n				&nbsp;NO\r\n			</td>\r\n			<td class="c5 td2">\r\n				&nbsp;\r\n			</td>\r\n			<td class="c6 td2">\r\n				&nbsp;投票人数\r\n			</td>\r\n		</tr>\r\n	</tbody>\r\n</table>', '', 0, 0, 0, 0, 1, 0, 1, 1, 1, 1, 1, 1, 1, 0, 1),
(9, 9, 2, 'xxz291917', 1, '127.0.0.1', 1368609926, '输入标题二二', '填写帖子内容污染物而', '', 0, 0, 0, 0, 1, 0, 1, 1, 1, 1, 1, 1, 1, 0, 1),
(10, 10, 2, 'xxz291917', 1, '127.0.0.1', 1368610003, '输入标题二二', '填写帖子内容污染物而', '', 0, 0, 0, 0, 1, 0, 1, 1, 1, 1, 1, 1, 1, 0, 1),
(11, 11, 12, 'xxz291917', 1, '127.0.0.1', 1368611640, '输入标题人人', '<a>展开</a> | <a>全部折叠</a> \r\n<table class="tb tb2 ">\r\n	<tbody>\r\n		<tr class="header">\r\n			<th>\r\n				<br />\r\n			</th>\r\n			<th>\r\n				显示顺序\r\n			</th>\r\n			<th>\r\n				版块名称\r\n			</th>\r\n			<th>\r\n				<br />\r\n			</th>\r\n			<th>\r\n				版主\r\n			</th>\r\n			<th>\r\n				<a>批量编辑</a>\r\n			</th>\r\n		</tr>\r\n		<tr class="hover">\r\n			<td class="td25">\r\n				<a id="a_group_1">[-]</a>\r\n			</td>\r\n			<td class="td25">\r\n			</td>\r\n			<td>\r\n				<div class="parentboard">\r\n				</div>\r\n			</td>\r\n			<td class="td23 lightfont" align="right">\r\n				(gid:1)\r\n			</td>\r\n			<td class="td23">\r\n				<a href="http://localhost/dz2.5/admin.php?action=forums&amp;operation=moderators&amp;fid=1">无 / 添加版主</a>\r\n			</td>\r\n			<td width="160">\r\n				<a href="http://localhost/dz2.5/admin.php?action=forums&amp;operation=edit&amp;fid=1" class="act">编辑</a><a href="http://localhost/dz2.5/admin.php?action=forums&amp;operation=delete&amp;fid=1" class="act">删除</a>\r\n			</td>\r\n		</tr>\r\n	</tbody>\r\n	<tbody id="group_1">\r\n		<tr class="hover">\r\n			<td class="td25">\r\n				<br />\r\n			</td>\r\n			<td class="td25">\r\n			</td>\r\n			<td>\r\n				<div class="board">\r\n					<a href="http://localhost/dz2.5/admin.php?action=forums###" class="addchildboard">添加子版块</a>\r\n				</div>\r\n			</td>\r\n			<td class="td23 lightfont" align="right">\r\n				(fid:2)\r\n			</td>\r\n			<td class="td23">\r\n				<a href="http://localhost/dz2.5/admin.php?action=forums&amp;operation=moderators&amp;fid=2">无 / 添加版主</a>\r\n			</td>\r\n			<td width="160">\r\n				<a href="http://localhost/dz2.5/admin.php?action=forums&amp;operation=edit&amp;fid=2" class="act">编辑</a><a href="http://localhost/dz2.5/admin.php?action=forums&amp;operation=copy&amp;source=2" class="act">设置复制</a><a href="http://localhost/dz2.5/admin.php?action=forums&amp;operation=delete&amp;fid=2" class="act">删除</a>\r\n			</td>\r\n		</tr>\r\n		<tr class="hover">\r\n			<td class="td25">\r\n				<br />\r\n			</td>\r\n			<td class="td25">\r\n			</td>\r\n			<td>\r\n				<div id="cb_39" class="lastchildboard">\r\n				</div>\r\n			</td>\r\n			<td class="td23 lightfont" align="right">\r\n				(fid:39)\r\n			</td>\r\n			<td class="td23">\r\n				<a href="http://localhost/dz2.5/admin.php?action=forums&amp;operation=moderators&amp;fid=39">xxz291917 »</a>\r\n			</td>\r\n			<td width="160">\r\n				<a href="http://localhost/dz2.5/admin.php?action=forums&amp;operation=edit&amp;fid=39" class="act">编辑</a><a href="http://localhost/dz2.5/admin.php?action=forums&amp;operation=copy&amp;source=39" class="act">设置复制</a><a href="http://localhost/dz2.5/admin.php?action=forums&amp;operation=delete&amp;fid=39" class="act">删除</a>\r\n			</td>\r\n		</tr>\r\n	</tbody>\r\n	<tbody>\r\n		<tr>\r\n			<td>\r\n				<br />\r\n			</td>\r\n			<td colspan="4">\r\n				<div class="lastboard">\r\n					<a href="http://localhost/dz2.5/admin.php?action=forums###" class="addtr">添加新版块</a>\r\n				</div>\r\n			</td>\r\n			<td>\r\n				&nbsp;\r\n			</td>\r\n		</tr>\r\n		<tr class="hover">\r\n			<td class="td25">\r\n				<a id="a_group_36">[-]</a>\r\n			</td>\r\n			<td class="td25">\r\n			</td>\r\n			<td>\r\n				<div class="parentboard">\r\n				</div>\r\n			</td>\r\n			<td class="td23 lightfont" align="right">\r\n				(gid:36)\r\n			</td>\r\n			<td class="td23">\r\n				<a href="http://localhost/dz2.5/admin.php?action=forums&amp;operation=moderators&amp;fid=36">无 / 添加版主</a>\r\n			</td>\r\n			<td width="160">\r\n				<a href="http://localhost/dz2.5/admin.php?action=forums&amp;operation=edit&amp;fid=36" class="act">编辑</a><a href="http://localhost/dz2.5/admin.php?action=forums&amp;operation=delete&amp;fid=36" class="act">删除</a>\r\n			</td>\r\n		</tr>\r\n	</tbody>\r\n	<tbody id="group_36">\r\n		<tr class="hover">\r\n			<td class="td25">\r\n				<br />\r\n			</td>\r\n			<td class="td25">\r\n			</td>\r\n			<td>\r\n				<div class="board">\r\n					<a href="http://localhost/dz2.5/admin.php?action=forums###" class="addchildboard">添加子版块</a>\r\n				</div>\r\n			</td>\r\n		</tr>\r\n	</tbody>\r\n</table>', '', 0, 0, 0, 0, 1, 0, 1, 1, 1, 1, 1, 1, 1, 0, 1),
(12, 12, 11, 'xxz291917', 1, '127.0.0.1', 1368612732, 'gdgdfgdgdfg', 'dfgdfgdgdfg', '', 0, 0, 0, 0, 1, 0, 1, 1, 1, 1, 1, 1, 1, 0, 1),
(13, 11, 12, 'xxz291917', 1, '127.0.0.1', 1368696089, '', '回复贴标题回复贴标题回复贴标题回复贴标题回复贴标题回复贴标题回复贴标题回复贴标题回复贴标题回复贴标题回复贴标题回复贴标题回复贴标题回复贴标题回复贴标题回复贴标题', '', 0, 0, 0, 0, 0, 0, 1, 1, 1, 1, 0, 0, 1, 0, 1),
(14, 11, 12, 'xxz291917', 1, '127.0.0.1', 1368696323, '', '回复贴标题回复贴标题回复贴标题回复贴标题回复贴标题回复贴标题回复贴标题回复贴标题回复贴标题回复贴标题回复贴标题回复贴标题回复贴标题回复贴标题回复贴标题回复贴标题', '', 0, 0, 0, 0, 0, 0, 1, 1, 1, 1, 0, 0, 1, 0, 1),
(15, 11, 12, 'xxz291917', 1, '127.0.0.1', 1368696465, '', '回复贴标题回复贴标题回复贴标题回复贴标题回复贴标题回复贴标题回复贴标题回复贴标题回复贴标题回复贴标题回复贴标题回复贴标题回复贴标题回复贴标题回复贴标题回复贴标题', '', 0, 0, 0, 0, 0, 0, 1, 1, 1, 1, 0, 0, 1, 0, 1),
(16, 11, 12, 'xxz291917', 1, '127.0.0.1', 1368696706, 'test', '测试回复内容', '', 0, 0, 0, 0, 0, 0, 1, 1, 1, 1, 0, 0, 1, 0, 1),
(17, 11, 12, 'xxz291917', 1, '127.0.0.1', 1368696770, '输入标题', '填写帖子内容才踩踩踩踩踩踩踩踩踩踩踩踩', '', 0, 0, 0, 0, 0, 0, 1, 1, 1, 1, 0, 0, 1, 0, 1),
(18, 13, 11, 'xxz291917', 1, '127.0.0.1', 1368696809, '输入标题大大大', '填写帖子内容士大夫士大夫', '', 0, 0, 0, 0, 1, 0, 1, 1, 1, 1, 0, 0, 1, 0, 1),
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
(38, 11, 12, 'xxz5291917', 2, '127.0.0.1', 1368774534, '输入标题', '填写帖子内容', '', 0, 0, 0, 0, 0, 0, 1, 0, 0, 1, 0, 0, 1, 0, 1),
(39, 11, 12, 'xxz5291917', 2, '127.0.0.1', 1368774539, '输入标题', '填写帖子内容', '', 0, 0, 0, 0, 0, 0, 1, 0, 0, 1, 0, 0, 1, 0, 1),
(40, 11, 12, 'xxz5291917', 2, '127.0.0.1', 1368774591, '输入标题', '填写帖子内容', '', 0, 0, 0, 0, 0, 0, 1, 0, 0, 1, 0, 0, 1, 0, 1),
(41, 11, 12, 'xxz5291917', 2, '127.0.0.1', 1368774662, '输入标题', '填写帖子内容', '', 0, 0, 0, 0, 0, 0, 1, 0, 0, 1, 0, 0, 1, 0, 1),
(42, 16, 12, 'xxz5291917', 2, '127.0.0.1', 1368774681, '输入标题凤飞飞', '填写帖子内容', '', 0, 0, 0, 0, 1, 0, 1, 0, 0, 1, 0, 0, 1, 0, 1),
(43, 17, 6, 'xxz291917', 1, '127.0.0.1', 1369310155, '是否需要测试', '是否需要测试是否需要测试是否需要测试是否需要测试是否需要测试是否需要测试是否需要测试是否需要测试是否需要测试是否需要测试是否需要测试', '', 0, 0, 0, 0, 1, 0, 1, 1, 1, 1, 1, 1, 1, 0, 1),
(44, 18, 11, 'xxz291917', 1, '127.0.0.1', 1369310199, '电梯直达跳转到指定楼层', '<h1 class="ts">\r\n	<a href="http://localhost/dz2.5/forum.php?mod=viewthread&amp;tid=2" id="thread_subject">我们的测试</a> \r\n</h1>\r\n<span class="xg1"> <a href="http://localhost/dz2.5/forum.php?mod=viewthread&amp;tid=2&amp;fromuid=1">[复制链接]</a> </span> \r\n<table class="ad" cellpadding="0" cellspacing="0">\r\n	<tbody>\r\n		<tr>\r\n			<td class="pls">\r\n				<br />\r\n			</td>\r\n			<td class="plc">\r\n				<br />\r\n			</td>\r\n		</tr>\r\n	</tbody>\r\n</table>\r\n<table id="pid5" cellpadding="0" cellspacing="0">\r\n	<tbody>\r\n		<tr>\r\n			<td class="pls" rowspan="2">\r\n				<div class="pi">\r\n					<div class="authi">\r\n						<a href="http://localhost/dz2.5/home.php?mod=space&amp;uid=1" target="_blank" class="xw1">admin</a> \r\n					</div>\r\n				</div>\r\n				<div>\r\n					<div class="avatar">\r\n						<a href="http://localhost/dz2.5/home.php?mod=space&amp;uid=1" target="_blank"><img src="http://localhost/dz2.5/uc_server/avatar.php?uid=1&amp;size=middle" /></a>\r\n					</div>\r\n					<div class="tns xg2">\r\n						<table cellpadding="0" cellspacing="0">\r\n							<tbody>\r\n								<tr>\r\n									<th>\r\n										<p>\r\n											<a href="http://localhost/dz2.5/home.php?mod=space&amp;uid=1&amp;do=thread&amp;view=me&amp;from=space" class="xi2">2</a>\r\n										</p>\r\n主题\r\n									</th>\r\n									<th>\r\n										<p>\r\n											<a href="http://localhost/dz2.5/home.php?mod=space&amp;uid=1&amp;do=friend&amp;view=me" class="xi2">0</a>\r\n										</p>\r\n好友\r\n									</th>\r\n									<td>\r\n										<p>\r\n											<a href="http://localhost/dz2.5/home.php?mod=space&amp;uid=1&amp;do=profile" class="xi2">68</a>\r\n										</p>\r\n积分\r\n									</td>\r\n								</tr>\r\n							</tbody>\r\n						</table>\r\n					</div>\r\n					<p>\r\n						<em><a href="http://localhost/dz2.5/home.php?mod=spacecp&amp;ac=usergroup&amp;gid=1" target="_blank">管理员</a></em>\r\n					</p>\r\n				</div>\r\n				<p>\r\n					<img src="http://localhost/dz2.5/static/image/common/star_level3.gif" alt="Rank: 9" /><img src="http://localhost/dz2.5/static/image/common/star_level3.gif" alt="Rank: 9" /><img src="http://localhost/dz2.5/static/image/common/star_level1.gif" alt="Rank: 9" />\r\n				</p>\r\n				<p class="cp_pls cl">\r\n					<a href="http://localhost/dz2.5/forum.php?mod=topicadmin&amp;action=getip&amp;fid=37&amp;tid=2&amp;pid=5">IP</a> <a href="http://localhost/dz2.5/admin.php?frames=yes&amp;action=members&amp;operation=search&amp;uid=1&amp;submit=yes" target="_blank">编辑</a> <a href="http://localhost/dz2.5/admin.php?action=members&amp;operation=ban&amp;username=admin&amp;frames=yes" target="_blank">禁止</a> <a href="http://localhost/dz2.5/forum.php?mod=modcp&amp;action=thread&amp;op=post&amp;do=search&amp;searchsubmit=1&amp;users=admin" target="_blank">帖子</a> <a href="http://localhost/dz2.5/forum.php?mod=ajax&amp;action=quickclear&amp;uid=1">清理</a> \r\n				</p>\r\n			</td>\r\n			<td class="plc">\r\n				<div class="pi">\r\n					<div id="fj" class="y">\r\n						电梯直达<a id="fj_btn" class="z"><img src="http://localhost/dz2.5/static/image/common/fj_btn.png" alt="跳转到指定楼层" class="vm" /></a> \r\n					</div>\r\n<strong> <a href="http://localhost/dz2.5/forum.php?mod=viewthread&amp;tid=2&amp;fromuid=1" id="postnum5">楼主</a> </strong> \r\n					<div class="pti">\r\n						<div class="pdbt">\r\n						</div>\r\n						<div class="authi">\r\n							<img class="authicn vm" id="authicon5" src="http://localhost/dz2.5/static/image/common/online_admin.gif" /> <em id="authorposton5">发表于 2013-4-16 17:59:25</em> <span class="pipe">|</span><a href="http://localhost/dz2.5/forum.php?mod=viewthread&amp;tid=2&amp;page=1&amp;authorid=1">只看该作者</a> <span class="pipe">|</span><a href="http://localhost/dz2.5/forum.php?mod=viewthread&amp;tid=2&amp;extra=page%3D1&amp;ordertype=1">倒序浏览</a> <span class="pipe">|</span> <a id="replynotice" href="http://localhost/dz2.5/forum.php?mod=misc&amp;action=replynotice&amp;op=ignore&amp;tid=2">取消回复通知</a> \r\n						</div>\r\n					</div>\r\n				</div>\r\n				<div class="pct">\r\n					<div class="pcb">\r\n						<div class="t_fsz">\r\n							<table cellpadding="0" cellspacing="0">\r\n								<tbody>\r\n									<tr>\r\n										<td class="t_f" id="postmessage_5">\r\n											主题测试主题测试主题测试主题测试主题测试主题测试主题测试主题测试<img src="http://localhost/dz2.5/static/image/smiley/default/lol.gif" alt="" border="0" /><br />\r\n										</td>\r\n									</tr>\r\n								</tbody>\r\n							</table>\r\n						</div>\r\n					</div>\r\n				</div>\r\n			</td>\r\n		</tr>\r\n	</tbody>\r\n</table>', '', 0, 0, 0, 0, 1, 0, 1, 1, 1, 1, 1, 1, 1, 0, 1),
(45, 19, 6, 'xxz291917', 1, '127.0.0.1', 1369313698, '审核测试审核测试', '审核测试审核测试审核测试审核测试审核测试审核测试审核测试', '', 0, 0, 0, 0, 1, 0, 1, 1, 1, 1, 1, 1, 1, 0, 1),
(46, 20, 6, 'xxz291917', 1, '127.0.0.1', 1369314292, '士大夫士大夫士大夫似的', '填写帖子内容反反复复反反复复反反复复反反复复', '', 0, 0, 0, 0, 1, 0, 1, 1, 1, 1, 1, 1, 1, 0, 4),
(47, 21, 6, 'xxz291917', 1, '127.0.0.1', 1369452030, '输入标题ddd', '填写帖子内容\r\n<pre class="prettyprint lang-php">phpinfo();\r\necho 123;</pre>', '', 0, 0, 0, 0, 1, 0, 1, 1, 1, 1, 1, 1, 1, 0, 4),
(48, 22, 11, 'xxz291917', 1, '127.0.0.1', 1369472789, '输入标题士大夫士大夫', '填写帖子内容\r\n<pre class="prettyprint lang-php">phpinfo();\r\necho 123;</pre>\r\n<pre class="prettyprint lang-js">alert(2222222);\r\n</pre>', '', 0, 0, 0, 0, 1, 0, 1, 1, 1, 1, 1, 1, 1, 0, 4),
(49, 22, 11, 'xxz291917', 1, '127.0.0.1', 1369476588, '输入标题', '<pre class="brush: js;">function helloSyntaxHighlighter()\r\n{\r\n    return "hi!";\r\n}\r\n</pre>', '', 0, 0, 0, 0, 0, 0, 1, 1, 1, 1, 1, 1, 1, 0, 4),
(50, 22, 11, 'xxz291917', 1, '127.0.0.1', 1369476618, '输入标题', '填写帖子内容\r\n<pre class="prettyprint lang-js">function helloSyntaxHighlighter()\r\n{\r\n    return "hi!";\r\n}</pre>', '', 0, 0, 0, 0, 0, 0, 1, 1, 1, 1, 1, 1, 1, 0, 4),
(51, 22, 11, 'xxz291917', 1, '127.0.0.1', 1369624037, '输入标题', '<pre class="brush:php;">phpinfo();</pre>\r\n填写帖子内容', '', 0, 0, 0, 0, 0, 0, 1, 1, 1, 1, 1, 1, 1, 0, 4),
(52, 22, 11, 'xxz291917', 1, '127.0.0.1', 1369624075, '输入标题', '填写帖子内容\r\n<pre class="brush:php;">function helloSyntaxHighlighter()\r\n{\r\n    return "hi!";\r\n}</pre>', '', 0, 0, 0, 0, 0, 0, 1, 1, 1, 1, 1, 1, 1, 0, 4),
(53, 22, 11, 'xxz291917', 1, '127.0.0.1', 1369625536, '输入标题', '<pre class="codeprint brush:applescript;">asdasd\r\nsfsdfsfdsf\r\nsdfsdfsdfsdfsdf\r\n</pre>\r\n填写帖子内容', '', 0, 0, 0, 0, 0, 0, 1, 1, 1, 1, 1, 1, 1, 0, 4),
(54, 22, 11, 'xxz291917', 1, '127.0.0.1', 1369626059, '输入标题', '<pre class="codeprint brush:html;">ssssssssssssssssss</pre>\r\n填写帖子内容', '', 0, 0, 0, 0, 0, 0, 1, 1, 1, 1, 1, 1, 1, 0, 4),
(55, 22, 11, 'xxz291917', 1, '127.0.0.1', 1369714000, '输入标题', '<p>\r\n	填写帖子内容\r\n</p>\r\n<p>\r\n	<br />\r\n</p>\r\n<p>\r\n<pre class="codeprint brush:php;">phpinfo();\r\necho 123;</pre>\r\n234\r\n</p>\r\neeeeeeeeeee', '', 0, 0, 0, 0, 0, 0, 1, 1, 1, 1, 1, 1, 1, 0, 4),
(56, 23, 2, 'xxz291917', 1, '127.0.0.1', 1369740062, '输入标题7777', '填写帖子内容:$:kiss::handshake{:3_46:}', '', 0, 0, 0, 0, 1, 0, 1, 1, 1, 1, 1, 1, 1, 0, 1),
(57, 23, 2, 'xxz291917', 1, '127.0.0.1', 1369795605, '输入标题', '填写帖子内容', '', 0, 0, 0, 0, 0, 0, 1, 1, 1, 1, 1, 1, 1, 0, 1),
(58, 24, 11, 'xxz291917', 1, '127.0.0.1', 1369815311, '输入标题夸奖夸奖夸奖', '填写帖子内容:lol{:2_36:}<a href="http://www.baidu.com" target="_blank">http://www.baidu.com</a>', '', 0, 0, 0, 0, 1, 0, 1, 1, 1, 1, 1, 1, 1, 0, 4),
(59, 24, 11, 'xxz291917', 1, '127.0.0.1', 1369815380, '输入标题', '填写帖子内容{:3_46:}', '', 0, 0, 0, 0, 0, 0, 1, 1, 1, 1, 1, 1, 1, 0, 4),
(60, 24, 11, 'xxz291917', 1, '127.0.0.1', 1369817179, '输入标题', '<blockquote class="blockquote">\r\n	士大夫士大夫\r\n</blockquote>\r\n填写帖子内容', '', 0, 0, 0, 0, 0, 0, 1, 1, 1, 1, 1, 1, 1, 0, 4),
(61, 24, 11, 'xxz291917', 1, '127.0.0.1', 1369818158, '输入标题', '<blockquote class="blockquote">\r\n	sdfsdf\r\n</blockquote>\r\n填写帖子内容', '', 0, 0, 0, 0, 0, 0, 1, 1, 1, 1, 1, 1, 1, 0, 4),
(62, 25, 11, 'xxz291917', 1, '127.0.0.1', 1369819307, 'hahhhhhhhh', '填写帖子内容:sleepy:{:3_43:}:@{:2_38:}', '', 0, 0, 0, 0, 1, 0, 1, 1, 1, 1, 1, 1, 1, 0, 4),
(63, 25, 11, 'xxz291917', 1, '127.0.0.1', 1369819367, '输入标题', '<blockquote class="blockquote">\r\n	''|'',\r\n</blockquote>\r\n<br />\r\n填写帖子内容', '', 0, 0, 0, 0, 0, 0, 1, 1, 1, 1, 1, 1, 1, 0, 4),
(64, 25, 11, 'xxz291917', 1, '127.0.0.1', 1369893399, '输入标题', '填写帖子内容<img src="/mycode/./uploads/file/b7da665c18f830c5a081a695395e734c.jpg" alt="" />', '', 0, 0, 0, 0, 0, 0, 1, 1, 1, 1, 1, 1, 1, 0, 4),
(65, 25, 11, 'xxz291917', 1, '127.0.0.1', 1369898357, '输入标题', '<img src="/mycode/uploads/file/e378c80cacad35dc854a972f397b0ed7.jpg" alt="" />填写帖子内容<img src="/mycode/uploads/file/9685aa209fb498b4eb8e5ddc0c987a7d.jpg" title="xxzxxzxxz" alt="xxzxxzxxz" height="109" width="109" /><a class="ke-insertfile" href="/mycode/uploads/file/2d925a00ca6495b559d646002de13f07.jpg" target="_blank">dddddddd</a>', '', 0, 0, 0, 0, 0, 0, 1, 1, 1, 1, 1, 1, 1, 0, 4),
(66, 25, 11, 'xxz291917', 1, '127.0.0.1', 1369899428, '输入标题', '<img src="/mycode/uploads/file/5134fa443f587661f910228e594d89f5.jpg" alt="" />填写帖子内容', '', 0, 0, 0, 0, 0, 0, 1, 1, 1, 1, 1, 1, 1, 0, 4),
(67, 25, 11, 'xxz291917', 1, '127.0.0.1', 1369899454, '输入标题', '填写帖子内容<img src="/mycode/uploads/file/b43e329af02d0b67017b2ea5681249c3.jpg" alt="" />', '', 0, 0, 0, 0, 0, 0, 1, 1, 1, 1, 1, 1, 1, 0, 4),
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
(87, 44, 11, 'xxz291917', 1, '127.0.0.1', 1370770112, '学智测试辩论', '学智测试辩论学智测试辩论学智测试辩论学智测试辩{:3_60:}论学智测试辩论学智测试辩论学智测试辩论学智测试辩论学智测试辩论学智测试辩论学智测试辩论学:hug:智测试辩论学智测试辩论学智测试辩论', '', 0, 0, 0, 0, 1, 0, 1, 1, 1, 1, 1, 1, 1, 0, 4),
(88, 44, 11, 'xxz291917', 1, '127.0.0.1', 1370781275, '蓝放蓝放', '蓝放蓝放蓝放蓝放蓝放蓝放', '', 0, 0, 0, 0, 0, 0, 1, 1, 1, 1, 1, 1, 1, 0, 4),
(89, 44, 11, 'xxz291917', 1, '127.0.0.1', 1370781675, '蓝放', '蓝放蓝放蓝放蓝放蓝放', '', 0, 0, 0, 0, 0, 0, 1, 1, 1, 1, 1, 1, 1, 0, 4),
(90, 44, 11, 'xxz291917', 1, '127.0.0.1', 1370781961, 'specialspecialspecial', 'specialspecialspecialspecial', '', 0, 0, 0, 0, 0, 0, 1, 1, 1, 1, 1, 1, 1, 0, 1),
(91, 45, 11, 'xxz291917', 1, '127.0.0.1', 1370782056, '问答问答问答', '问答问答问答问答', '', 0, 0, 0, 0, 1, 0, 1, 1, 1, 1, 1, 1, 1, 0, 4),
(92, 34, 2, 'xxz291917', 1, '127.0.0.1', 1371097739, '输入标题', '填写帖子内容', '', 0, 0, 0, 0, 0, 0, 1, 1, 1, 1, 1, 1, 1, 0, 1),
(93, 34, 2, 'xxz291917', 1, '127.0.0.1', 1371097751, '', '士大夫士大夫', '', 0, 0, 0, 0, 0, 0, 1, 1, 1, 1, 1, 1, 1, 0, 1),
(94, 34, 2, 'xxz291917', 1, '127.0.0.1', 1371097756, '输入标题', '填写帖子内容', '', 0, 0, 0, 0, 0, 0, 1, 1, 1, 1, 1, 1, 1, 0, 1),
(95, 34, 2, 'xxz291917', 1, '127.0.0.1', 1371097762, '输入标题', '填写帖子内容', '', 0, 0, 0, 0, 0, 0, 1, 1, 1, 1, 1, 1, 1, 0, 1),
(96, 34, 2, 'xxz291917', 1, '127.0.0.1', 1371097769, '输入标题', '填写帖子内容叫姐姐', '', 0, 0, 0, 0, 0, 0, 1, 1, 1, 1, 1, 1, 1, 0, 1),
(97, 34, 2, 'xxz291917', 1, '127.0.0.1', 1371097775, '输入标题', '填写帖子内容规划局', '', 0, 0, 0, 0, 0, 0, 1, 1, 1, 1, 1, 1, 1, 0, 1),
(98, 16, 12, 'xxz291917', 1, '127.0.0.1', 1371105016, '输入标题', '填写帖子内容啊实打实大', '', 0, 0, 0, 0, 0, 0, 1, 1, 1, 1, 1, 1, 1, 0, 1),
(99, 46, 11, 'xxz291917', 1, '127.0.0.1', 1371702544, '人人人人人人人', '人人人人人人人人人人人人', '', 0, 0, 0, 0, 1, 0, 1, 1, 1, 1, 1, 1, 1, 1, 4),
(100, 47, 11, 'xxz291917', 1, '127.0.0.1', 1371726788, '输入问答概述', '反反复复', '', 0, 0, 0, 0, 1, 0, 1, 1, 1, 1, 1, 1, 1, 1, 4);

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='前台管理回复日志表' AUTO_INCREMENT=43 ;

--
-- 转存表中的数据 `posts_log`
--

INSERT INTO `posts_log` (`id`, `post_id`, `user_id`, `username`, `time`, `action`, `data`, `reason`) VALUES
(40, 37, 1, 'xxz291917', 1369313364, 'pass', '{"submit":"1","topic_id":"37","del":"1","reason":"lllllllllllll"}', 'lllllllllllll'),
(41, 18, 1, 'xxz291917', 1369724443, 'pass', '{"submit":"1","topic_id":"18,19","del":"1","reason":"SSSS"}', 'SSSS'),
(42, 19, 1, 'xxz291917', 1369724443, 'pass', '{"submit":"1","topic_id":"18,19","del":"1","reason":"SSSS"}', 'SSSS');

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
(89, '1'),
(90, '1');

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
  `status` tinyint(4) DEFAULT NULL COMMENT '记录是否已经处理的举报，1表示已处理，0表示未处理 ',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='帖子举报表';

--
-- 转存表中的数据 `reports`
--

INSERT INTO `reports` (`id`, `topic_id`, `post_id`, `user_id`, `reason`, `time`, `operate_user`, `operate_time`, `status`) VALUES
(0, 19, 45, 1, '[removed]alert&amp;#40;123&amp;#41;[removed]\r\n&lt;font color=&quot;red&quot;&gt;333333333&lt;/font&gt;', 1371263423, NULL, NULL, 0);

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=10 ;

--
-- 转存表中的数据 `tags`
--

INSERT INTO `tags` (`id`, `topic_id`, `tag`) VALUES
(6, 41, '&lt;script&gt;alert('),
(7, 42, '&lt;script&gt;alert('),
(3, 38, 'hongse'),
(5, 38, 'sdfsdf'),
(4, 38, 'sfsl'),
(1, 38, 'test'),
(8, 46, '标签间请用''空格''或''逗号''隔开，最多可'),
(9, 47, '标签间请用''空格''或''逗号''隔开，最多可'),
(2, 38, '白色');

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
  `highlight` varchar(30) NOT NULL DEFAULT '0' COMMENT '高亮样式用'',''分隔',
  `digest` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否精华，精华类型',
  `recommend` int(11) NOT NULL DEFAULT '0' COMMENT '推荐主题',
  `special` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '特殊主题（1正常，2问答，3投票）',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '状态（1正常，2删除，3屏蔽, 4待审核, 5关闭）',
  PRIMARY KEY (`id`),
  KEY `forum_id` (`forum_id`),
  KEY `author_id` (`author_id`),
  KEY `last_post_time` (`last_post_time`),
  KEY `status` (`status`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=48 ;

--
-- 转存表中的数据 `topics`
--

INSERT INTO `topics` (`id`, `forum_id`, `category_id`, `author`, `author_id`, `post_time`, `subject`, `last_author`, `last_author_id`, `last_post_time`, `tags`, `views`, `replies`, `supports`, `opposes`, `top`, `highlight`, `digest`, `recommend`, `special`, `status`) VALUES
(1, 6, 0, 'admin', 1, 0, 'xuezhiceshi', '', 0, 0, '', 4, 0, 0, 0, 0, '0', 0, 0, 0, 0),
(6, 2, 0, 'xxz291917', 1, 1368531645, '输入标题r', '', 0, 0, '', 0, 0, 0, 0, 1, '0', 0, 0, 1, 1),
(7, 2, 0, 'xxz291917', 1, 1368583217, '夏学智测试', '', 0, 0, '', 7, 0, 0, 0, 1, '0', 0, 0, 1, 3),
(8, 2, 0, 'xxz291917', 1, 1368588882, '发帖测试123', 'xxz5291917', 2, 1368772292, '', 10, 2, 0, 0, 0, '0', 0, 0, 1, 1),
(9, 2, 0, 'xxz291917', 1, 1368609926, '输入标题二二', 'xxz291917', 1, 1368702719, '', 7, 1, 0, 0, 1, '0', 0, 0, 1, 1),
(10, 2, 0, 'xxz291917', 1, 1368610003, '输入标题二二', 'xxz5291917', 2, 1368774131, '', 120, 5, 0, 0, 0, '0', 0, 0, 1, 1),
(11, 12, 0, 'xxz291917', 1, 1368611640, '输入标题人人', 'xxz5291917', 2, 1368774662, '', 70, 11, 0, 0, 0, '0', 0, 0, 1, 1),
(12, 11, 0, 'xxz291917', 1, 1368612732, 'gdgdfgdgdfg', '', 0, 0, '', 14, 0, 0, 0, 0, '0', 1, 1, 1, 1),
(13, 11, 0, 'xxz291917', 1, 1368696809, '输入标题大大大', 'xxz5291917', 2, 1337484852, '', 292, 8, 0, 0, 2, '#2B65B7,0,1,1', 1, 1, 1, 5),
(14, 6, 0, 'xxz291917', 1, 1368699427, '红星闪闪放光芒', 'xxz291917', 1, 1368701675, '', 6, 4, 0, 0, 0, '0', 0, 0, 1, 1),
(15, 6, 0, 'xxz5291917', 2, 1368772328, '输入标题yy', '', 0, 0, '', 0, 0, 0, 0, 0, '0', 0, 0, 1, 1),
(16, 12, 0, 'xxz5291917', 2, 1368774681, '输入标题凤飞飞', 'xxz291917', 1, 1371105016, '', 28, 2, 0, 0, 0, '0', 0, 0, 1, 1),
(17, 6, 0, 'xxz291917', 1, 1369310155, '是否需要测试', '', 0, 0, '', 1, 0, 0, 0, 0, '', 0, 0, 1, 4),
(18, 11, 0, 'xxz291917', 1, 1369310199, '电梯直达跳转到指定楼层', '', 0, 0, '', 3, 0, 0, 0, 0, '', 0, 0, 1, 4),
(19, 6, 0, 'xxz291917', 1, 1369313698, '审核测试审核测试', '', 0, 0, '', 0, 0, 0, 0, 0, '', 0, 0, 1, 4),
(20, 6, 0, 'xxz291917', 1, 1369314292, '士大夫士大夫士大夫似的', '', 0, 0, '', 0, 0, 0, 0, 0, '', 0, 0, 1, 4),
(21, 6, 0, 'xxz291917', 1, 1369452030, '输入标题ddd', '', 0, 0, '', 1, 0, 0, 0, 0, '', 0, 0, 1, 4),
(22, 11, 0, 'xxz291917', 1, 1369472789, '输入标题士大夫士大夫', 'xxz291917', 1, 1369714000, '', 37, 7, 0, 0, 0, '', 0, 0, 1, 4),
(23, 2, 4, 'xxz291917', 1, 1369740062, '输入标题7777', 'xxz291917', 1, 1369795605, '', 8, 1, 0, 0, 0, '', 0, 0, 1, 1),
(24, 11, 0, 'xxz291917', 1, 1369815311, '输入标题夸奖夸奖夸奖', 'xxz291917', 1, 1369818158, '', 4, 3, 0, 0, 0, '', 0, 0, 1, 4),
(25, 11, 0, 'xxz291917', 1, 1369819307, 'hahhhhhhhh', 'xxz291917', 1, 1369979898, '', 42, 11, 0, 0, 0, '', 0, 0, 1, 4),
(26, 2, 0, 'xxz291917', 1, 1370230068, '去问去问夫士大夫', '', 0, 0, '', 0, 0, 0, 0, 0, '', 0, 0, 3, 1),
(27, 2, 0, 'xxz291917', 1, 1370230139, '去问去问夫士大夫', '', 0, 0, '', 0, 0, 0, 0, 0, '', 0, 0, 3, 1),
(28, 2, 0, 'xxz291917', 1, 1370233072, '去问去问夫士大夫', '', 0, 0, '', 0, 0, 0, 0, 0, '', 0, 0, 3, 1),
(29, 2, 0, 'xxz291917', 1, 1370233126, '去问去问夫士大夫', '', 0, 0, '', 0, 0, 0, 0, 0, '', 0, 0, 3, 1),
(30, 2, 0, 'xxz291917', 1, 1370319680, '辩论发帖测试', '', 0, 0, '', 0, 0, 0, 0, 0, '', 0, 0, 4, 1),
(31, 2, 0, 'xxz291917', 1, 1370319752, '辩论发帖测试', '', 0, 0, '', 0, 0, 0, 0, 0, '', 0, 0, 4, 1),
(32, 2, 0, 'xxz291917', 1, 1370331322, '输入标题jhjhjh', '', 0, 0, '', 0, 0, 0, 0, 0, '', 0, 0, 3, 1),
(33, 2, 0, 'xxz291917', 1, 1370335275, '输入标sdfsdfsdf', '', 0, 0, '', 0, 0, 0, 0, 0, '', 0, 0, 3, 1),
(34, 2, 0, 'xxz291917', 1, 1370335370, '输入标sdfsdfsdf', 'xxz291917', 1, 1371097775, '', 157, 8, 0, 0, 0, '', 0, 0, 3, 1),
(35, 2, 0, 'xxz291917', 1, 1370397845, 'test 白色,,hongse,,   sfsl  sdfsdf', '', 0, 0, '', 0, 0, 0, 0, 0, '', 0, 0, 4, 1),
(36, 2, 0, 'xxz291917', 1, 1370398156, '输入标题士大夫士大夫', '', 0, 0, 'test,白色,hongse,sfsl,sdfsdf', 0, 0, 0, 0, 0, '', 0, 0, 1, 1),
(37, 2, 0, 'xxz291917', 1, 1370418336, '士大夫士大夫标题', '', 0, 0, 'test,白色,hongse,sfsl,sdfsdf', 0, 0, 0, 0, 0, '', 0, 0, 1, 1),
(38, 2, 0, 'xxz291917', 1, 1370418370, '士大夫士大夫标题', '', 0, 0, 'test,白色,hongse,sfsl,sdfsdf', 1, 0, 0, 0, 0, '', 0, 0, 1, 1),
(39, 11, 0, 'xxz291917', 1, 1370585781, 'alert(123);', '', 0, 0, '', 0, 0, 0, 0, 0, '', 0, 0, 1, 4),
(40, 11, 0, 'xxz291917', 1, 1370586266, '&lt;script&gt;alert(123);&lt;/script&gt;', '', 0, 0, '', 4, 0, 0, 0, 0, '', 0, 0, 1, 4),
(41, 2, 0, 'xxz291917', 1, 1370662753, '发表文旦扣减分', '', 0, 0, '&lt;script&gt;alert(123);&lt;/script&gt;', 0, 0, 0, 0, 0, '', 0, 0, 2, 1),
(42, 2, 0, 'xxz291917', 1, 1370662947, '发表文旦扣减分', '', 0, 0, '&lt;script&gt;alert(123);&lt;/script&gt;', 0, 0, 0, 0, 0, '', 0, 0, 2, 1),
(43, 2, 0, 'xxz291917', 1, 1370662983, 'vvvvvvvvvvvvv', '', 0, 0, '', 0, 0, 0, 0, 0, '', 0, 0, 2, 1),
(44, 11, 0, 'xxz291917', 1, 1370770112, '学智测试辩论', 'xxz291917', 1, 1370781961, '', 18, 3, 0, 0, 0, '', 0, 0, 4, 4),
(45, 11, 0, 'xxz291917', 1, 1370782056, '问答问答问答', '', 0, 0, '', 14, 0, 0, 0, 0, '', 0, 0, 2, 4),
(46, 11, 0, 'xxz291917', 1, 1371702544, '人人人人人人人', '', 0, 0, '标签间请用''空格''或''逗号''隔开，最多可添加5个标签。', 0, 0, 0, 0, 0, '0', 0, 0, 2, 4),
(47, 11, 0, 'xxz291917', 1, 1371726788, '输入问答概述', '', 0, 0, '标签间请用''空格''或''逗号''隔开，最多可添加5个标签。', 0, 0, 0, 0, 0, '0', 0, 0, 2, 4);

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='主题置顶、高亮、精华、推荐的有效时间表' AUTO_INCREMENT=23 ;

--
-- 转存表中的数据 `topics_endtime`
--

INSERT INTO `topics_endtime` (`id`, `topic_id`, `action`, `end_time`) VALUES
(2, 13, 'top', 1369864800),
(10, 13, 'highlight', 1369864800),
(13, 12, 'digest', 0),
(14, 13, 'digest', 0),
(17, 6, 'top', 1369864800),
(18, 7, 'top', 1369864800),
(21, 9, 'top', 0),
(22, 8, 'top', 0);

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='前台管理日志表' AUTO_INCREMENT=43 ;

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
(42, 23, 1, 'xxz291917', 1370585470, 'editcategory', '{"submit":"1","topic_id":"23","editcategory":"4","reason":""}', '');

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
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='论坛用户表' AUTO_INCREMENT=3 ;

--
-- 转存表中的数据 `users`
--

INSERT INTO `users` (`id`, `email`, `username`, `password`, `credits`, `group_id`, `member_id`, `groups`, `icon`, `gender`, `signature`, `regdate`, `status`) VALUES
(1, 'xxz291917@163.com', 'xxz291917', '', 1807, 1, 14, '2', '', 0, '<font color=''red''>签名测试22</font>', 1298763453, 1),
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
(1, 80, 0, 2, 80, 0, '', 1371726788, 1371733283, 0, 273, 184, 620, 0, 0, 0, 0, 0, ''),
(2, 16, 0, 17, 16, 0, '', 1368774681, 1368774681, 0, 30, 39, 34, 0, 0, 0, 0, 0, '');

-- --------------------------------------------------------

--
-- 表的结构 `users_medal`
--

CREATE TABLE IF NOT EXISTS `users_medal` (
  `user_id` int(10) unsigned NOT NULL,
  `medal_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`user_id`,`medal_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `users_medal`
--

INSERT INTO `users_medal` (`user_id`, `medal_id`) VALUES
(1, 7),
(1, 8),
(1, 9),
(1, 10),
(2, 7),
(2, 8),
(2, 9),
(2, 10);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
