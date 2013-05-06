-- phpMyAdmin SQL Dump
-- version 3.5.2.2
-- http://www.phpmyadmin.net
--
-- 主机: 127.0.0.1
-- 生成日期: 2013 年 05 月 06 日 13:47
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='积分日志表' AUTO_INCREMENT=1 ;

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='论坛版块' AUTO_INCREMENT=11 ;

--
-- 转存表中的数据 `forums`
--

INSERT INTO `forums` (`id`, `parent_id`, `type`, `name`, `description`, `icon`, `manager`, `display_order`, `create_user`, `create_user_id`, `create_time`, `allow_special`, `is_anonymous`, `is_html`, `is_bbcode`, `is_smilies`, `is_media`, `check`, `allow_visit`, `allow_read`, `allow_post`, `allow_reply`, `allow_upload`, `allow_download`, `seo_title`, `seo_keywords`, `seo_description`, `credit_setting`, `status`) VALUES
(1, 0, 'group', 'test版大大大', ' 测试新分类', '', 'dsdff', 1, '', 0, 0, '', 0, 0, 0, 0, 0, 0, '1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19', '1,2,3,4,6,7', '1,2,3,4,5,6', '1,2,3,4,5,9,10', '1,2,3', '1,2,3', '论坛seo', '', '', '{"post":{"extcredits1":"3","extcredits2":"4","extcredits3":"5"},"reply":{"extcredits1":"","extcredits2":"6","extcredits3":""},"digest":{"extcredits1":"","extcredits2":"7","extcredits3":""},"postattach":{"extcredits1":"","extcredits2":"8","extcredits3":""},"getattach":{"extcredits1":"","extcredits2":"","extcredits3":""},"daylogin":{"extcredits1":"","extcredits2":"","extcredits3":""},"search":{"extcredits1":"","extcredits2":"","extcredits3":""}}', 0),
(2, 1, 'forum', 'test版', '测试默认版块', '', 'admin', 2, '', 0, 0, '1,2', 0, 1, 1, 0, 0, 0, '1', '1', '1', '1', '1', '1', '', '', '', '{"post":{"extcredits1":"","extcredits2":"","extcredits3":""},"reply":{"extcredits1":"","extcredits2":"","extcredits3":""},"digest":{"extcredits1":"","extcredits2":"","extcredits3":""},"postattach":{"extcredits1":"","extcredits2":"","extcredits3":""},"getattach":{"extcredits1":"0","extcredits2":"5","extcredits3":"4"},"daylogin":{"extcredits1":"","extcredits2":"","extcredits3":""},"search":{"extcredits1":"","extcredits2":"","extcredits3":""}}', 0),
(4, 0, 'group', 'test545', '测试版块内容哦测试版块内容哦测试版块内容哦测试版块内容哦测试版块内容哦测试版块内容哦测试版块内容哦', '', 'admin', 5, '', 0, 0, '2,3', 0, 1, 1, 1, 1, 2, '', '', '', '', '', '', '论坛seo', '论坛seo 论坛seo', '论坛seo论坛seo论坛seo论坛seo论坛seo论坛seo', '', 1),
(6, 2, 'sub', '学智测试版块', '', '', 'admin', 0, '', 0, 0, '', 0, 0, 0, 0, 0, 0, '', '', '', '', '', '', '', '', '', '', 0),
(10, 0, 'group', '子版块测试', '', '', '', 2, '', 0, 0, '', 0, 0, 0, 0, 0, 0, '', '', '', '', '', '', '', '', '', '', 0);

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
(1, 'system', '管理员', '', 0, 9, 1, 0, 1, 1, 1, 1, 0, '', 0, 0, 0, 0, 0, 0, 1, 1, 1, 1, 1, 0, 0, ''),
(2, 'system', '超级版主', '', 0, 8, 1, 0, 1, 1, 1, 1, 0, '', 0, 0, 0, 0, 0, 0, 1, 1, 1, 1, 1, 1, 1, ''),
(3, 'system', '版主', '', 0, 7, 1, 0, 1, 1, 1, 1, 0, '', 0, 0, 0, 0, 0, 0, 1, 1, 1, 1, 1, 0, 0, ''),
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
(16, 'special', '实习版主', '', 0, 7, 1, 0, 1, 1, 0, 0, 0, '', 0, 0, 0, 0, 0, 0, 1, 1, 1, 0, 0, 0, 0, ''),
(17, 'special', '网站编辑', '', 0, 8, 1, 0, 1, 1, 0, 0, 0, '', 0, 0, 0, 0, 0, 0, 1, 1, 1, 0, 0, 0, 0, ''),
(18, 'special', '信息监察员', '', 0, 9, 1, 0, 1, 1, 0, 0, 0, '', 0, 0, 0, 0, 0, 0, 1, 1, 1, 0, 0, 0, 0, ''),
(19, 'special', '审核员', '', 0, 6, 1, 0, 1, 1, 0, 0, 0, '', 0, 0, 0, 0, 0, 0, 1, 1, 1, 0, 0, 0, 0, '');

-- --------------------------------------------------------

--
-- 表的结构 `groups_admin`
--

CREATE TABLE IF NOT EXISTS `groups_admin` (
  `group_id` smallint(6) unsigned NOT NULL DEFAULT '0' COMMENT '关联用户组id',
  `allow_topthread` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否允许主题置顶类型',
  `is_editpost` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否允许编辑帖子',
  `is_checkpost` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否允许审核帖子',
  `is_delpost` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否允许删除帖子',
  `is_multildel` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否允许批量删帖',
  `is_refund` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否允许强制退款',
  `is_viewip` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否允许查看IP',
  `is_banip` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否允许禁止IP',
  `is_edituser` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否允许编辑用户信息',
  `is_checkuser` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否允许审核用户',
  `is_banuser` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否允许禁止用户发言',
  `is_viewlog` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否允许查看管理日志',
  `is_banpost` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否允许屏蔽帖子',
  `is_highlight` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否允许高亮主题',
  `allow_digest` tinyint(1) NOT NULL DEFAULT '0' COMMENT '允许主题加精类型',
  `is_recommend` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否允许推荐主题',
  `is_bump` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否允许提升主题',
  `is_closethread` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否允许关闭主题',
  `is_movethread` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否允许移动主题',
  `is_edittype` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否允许编辑主题分类',
  `is_copythread` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否允许复制主题',
  `is_mergethread` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否允许合并主题',
  `is_splitthread` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否允许切分主题',
  `is_topreply` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否允许置顶回帖',
  `is_edittag` tinyint(1) NOT NULL DEFAULT '0',
  `is_managereport` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`group_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `groups_admin`
--

INSERT INTO `groups_admin` (`group_id`, `allow_topthread`, `is_editpost`, `is_checkpost`, `is_delpost`, `is_multildel`, `is_refund`, `is_viewip`, `is_banip`, `is_edituser`, `is_checkuser`, `is_banuser`, `is_viewlog`, `is_banpost`, `is_highlight`, `allow_digest`, `is_recommend`, `is_bump`, `is_closethread`, `is_movethread`, `is_edittype`, `is_copythread`, `is_mergethread`, `is_splitthread`, `is_topreply`, `is_edittag`, `is_managereport`) VALUES
(1, 3, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 3, 1, 1, 1, 1, 1, 1, 1, 1, 1, 0, 1),
(2, 2, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 3, 1, 1, 1, 1, 1, 1, 1, 1, 0, 0, 0),
(3, 1, 1, 1, 1, 0, 0, 1, 0, 0, 1, 1, 1, 1, 1, 3, 1, 1, 1, 1, 1, 1, 1, 1, 0, 0, 0),
(16, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 1, 1, 1, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0),
(17, 2, 1, 1, 0, 0, 1, 1, 0, 0, 0, 0, 1, 1, 1, 3, 1, 1, 1, 1, 1, 1, 1, 1, 0, 0, 0),
(18, 0, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(19, 0, 0, 1, 0, 0, 0, 1, 1, 0, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);

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
  `is_sign` tinyint(1) NOT NULL COMMENT '是否允许使用签名',
  `status` tinyint(3) unsigned NOT NULL COMMENT '状态（1正常，2删除，3被锁定）',
  PRIMARY KEY (`id`),
  KEY `topic_id` (`topic_id`),
  KEY `forum_id` (`forum_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

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
  `is_top` tinyint(1) NOT NULL COMMENT '是否置顶',
  `is_digest` tinyint(1) NOT NULL COMMENT '是否高亮',
  `is_hightlight` tinyint(1) NOT NULL COMMENT '是否精华',
  `special` tinyint(1) unsigned NOT NULL COMMENT '特殊主题（1正常，2问答，3投票）',
  `attachment` tinyint(1) unsigned NOT NULL COMMENT '附件类型，0没有附件，1图片附件，2其他附件',
  `status` tinyint(1) unsigned NOT NULL COMMENT '状态（1正常，2删除，3被锁定）',
  PRIMARY KEY (`id`),
  KEY `forum_id` (`forum_id`),
  KEY `author_id` (`author_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- 转存表中的数据 `topics`
--

INSERT INTO `topics` (`id`, `forum_id`, `author`, `author_id`, `post_time`, `subject`, `last_author`, `last_author_id`, `last_post_time`, `views`, `replies`, `favors`, `is_top`, `is_digest`, `is_hightlight`, `special`, `attachment`, `status`) VALUES
(1, 6, 'admin', 1, 0, 'xuezhiceshi', '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- 表的结构 `topics_posted`
--

CREATE TABLE IF NOT EXISTS `topics_posted` (
  `user_id` int(10) unsigned NOT NULL DEFAULT '0',
  `topic_id` int(10) unsigned NOT NULL DEFAULT '0',
  `time` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='用户参与的主题列表，将用户回复过的主题都记录下来，避免查询posts表。';

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
  `admin_id` smallint(5) unsigned NOT NULL COMMENT '管理组id',
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

INSERT INTO `users` (`id`, `email`, `username`, `password`, `credits`, `group_id`, `admin_id`, `icon`, `gender`, `signature`, `regdate`, `status`) VALUES
(1, 'xxz291917@163.com', 'xxz291917', '', 108, 1, 0, '', 1, '<font color=''red''>签名测试</font>', 1298763453, 1),
(2, 'xxz5291917@163.com', 'xxz5291917', '', 108, 1, 0, '', 1, '<font color=''green''>签名测试</font>', 1298543453, 1);

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
  `credit1` int(10) NOT NULL DEFAULT '0' COMMENT '积分字段1',
  `credit2` int(10) NOT NULL DEFAULT '0' COMMENT '积分字段2',
  `credit3` int(10) NOT NULL DEFAULT '0' COMMENT '积分字段3',
  `credit4` int(10) NOT NULL DEFAULT '0' COMMENT '积分字段4',
  `credit5` int(10) NOT NULL DEFAULT '0',
  `credit6` int(10) NOT NULL DEFAULT '0',
  `credit7` int(10) NOT NULL DEFAULT '0',
  `credit8` int(10) NOT NULL DEFAULT '0',
  `last_credit_affect_log` varchar(255) NOT NULL DEFAULT '' COMMENT '最后积分变动内容',
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `users_extra`
--

INSERT INTO `users_extra` (`user_id`, `posts`, `digests`, `today_posts`, `today_uploads`, `last_visit_time`, `last_login_ip`, `last_post_time`, `last_active_time`, `online_time`, `credit1`, `credit2`, `credit3`, `credit4`, `credit5`, `credit6`, `credit7`, `credit8`, `last_credit_affect_log`) VALUES
(1, 0, 0, 0, 0, 0, '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
