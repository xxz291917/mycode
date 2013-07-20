<?php
list($forum_name) = explode('/',trim($_SERVER['REQUEST_URI'],'/'));
$forum_name = strtolower($forum_name);
$site_url = 'test2.9tech.cn';
$forum_ids = array(
	'html5'=>'191',
	'flash'=>'192',
	'android'=>'193',
	'unity3d'=>'194',
	'cocos2d'=>'195',
	'ios'=>'196',
	);

if(!isset($forum_ids[$forum_name])){
	echo 'url£¬³ö´í';die;
}
$get_url = 'http://' . $site_url . '/index.php/forum/show/' . $forum_ids[$forum_name];
echo file_get_contents($get_url);
?>