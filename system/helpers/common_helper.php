<?php
if ( ! function_exists('get_key')){
	function get_key($passport_user_id){
		$random_key = 'zt2ms6cf4bhiwq8x';
		$public_key = 'uv1aj7lnyok0r35p9deg';
		
		$res = floatval($passport_user_id);
		$id = '';
		$public_key_num = strlen($public_key);
		$random_key_num = strlen($random_key);
		while(($res/$public_key_num) > 0){
			$remainder = $res % $public_key_num;
			$id = $public_key[$remainder].$id;
			$res = floor($res/$public_key_num);
		}
		while((15 - strlen($id)) > 0){
			$id = $random_key[rand(0,($random_key_num-1))].$id;
		}
		
		return $id;
	}
}

if ( ! function_exists('back_key')){
	function back_key($id_key){
		$public_key = 'uv1aj7lnyok0r35p9deg';
		$passport_user_id = 0;
		
		$public_key_num = strlen($public_key);
		for($i=0;$i < strlen($id_key);$i++){
			$tmp = strpos($public_key,$id_key[$i]);
			if($tmp > 0){
				$passport_user_id = $public_key_num * $passport_user_id + $tmp;
			}
		}
		return $passport_user_id;
	}
}

if ( ! function_exists('avatar_url'))
{
	/*
	 * size =big	=middle		=small	
	*/
	function avatar_url($passport_user_id,$size = 'big')
	{
		$domian = 'http://test.9tech.cn/hi/avatar/';
//		$domian = 'http://local.hi.9tech.cn/avatar/';
		
		$md5 = strtoupper(md5(md5($passport_user_id)));
        $dir1 = substr($md5, 0, 1);
        $dir2 = substr($md5, 1, 1);
        $dir3 = substr($md5, 2, 1);
        
		$randomKey = "ZT2MS6CF4BHIWQ8X";
		$publicKey = 'UV1AJ7LNY0KOR35P9DEG';
		
		$res = floatval($passport_user_id);
		$idKey = '';
		while (($res / 20) > 0) {
			$yushu = $res % 20;
			$idKey = $publicKey[$yushu] . $idKey;
			$res = floor($res / 20);
		}
		$len = 6 - strlen($idKey);
		$passport_user_id = sprintf("%0" . $len . "d", $passport_user_id);
		for ($i = 0; $i < $len; $i++) {
			$pos = substr($passport_user_id, $i, 1);
			$idKey = $randomKey[$pos] . $idKey;
		}
		 
		$size = in_array($size, array('big', 'middle', 'small')) ? $size : 'big';
		$url = $domian.$dir1.'/'.$dir2.'/'.$dir3.'/'.$idKey."_$size.jpg";
		
		return $url;
	}
}

if ( ! function_exists('cdate'))
{
	function cdate($time){
	
		$tadtime = time()-60*60*24;
		if($time>$tadtime){
			$cha = time() - $time;  
			if($cha < 60) $return = $cha.'秒前';
			elseif($cha >= 60 and $cha < 3600){
				$return = ceil($cha/60).'分钟前';
			}else{
				$return = (ceil($cha/3600)-1).'小时前';
			}
		}else{
			$return = date('m-d H:i',$time);
		}
		return $return;
	}
}


if ( ! function_exists('jsonpcallback'))
{
    function jsonpcallback($data)
    {	
		$CI = & get_instance();	
        $jsonpcallback = strip_tags($CI->input->get('jsonpcallback')) ;
		if (strnatcmp(phpversion(),'5.3') >= 0) 
		{
			$json = json_encode($data,JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP);
		}else
		{
			$json = str_replace(array("\r", "\n", "<", ">", "&", "\'"),array('\r', '\n', '\u003c', '\u003e', '\u0026', '\''),json_encode($data));
		}
        
        if($jsonpcallback)
            echo "$jsonpcallback(".$json.")";
        else
            echo $json;
        exit;
    }
}

if ( ! function_exists('urldecode_utf8'))
{
    function urldecode_utf8($str) {
      if(  preg_match('/%u([0-9a-f]{3,4})/i',$str))
      {
          $str = preg_replace("/%u([0-9a-f]{3,4})/i","&#x\\1;",urldecode($str));
          return html_entity_decode($str,null,'UTF-8');;          
      }elseif(preg_match('/%([0-9a-f]{2})/i',$str))
      {
          return urldecode($str);
      }else
      {
          return $str;
      }

    }
}
?>
