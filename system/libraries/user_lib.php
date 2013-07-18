<?php if (!defined('BASEPATH'))    exit('No direct script access allowed');

class User_lib {

    public $passport_url = 'http://passport.9ria.com/';
    
    function getUser() {
		if(!isset($_COOKIE['token'])){
			return ;
		}
		session_start();
		$token = $_COOKIE['token'];
		$user = array();
		$result = file_get_contents($this->passport_url.'/interface/getUser.php?token='.$token);
		if(strlen(trim($result)) > 0){
			$result = json_decode($result,true);
			$user['id'] = $result[0]['LtUserID'];
			$user['name'] = $result[0]['LtUserName'];
			$user['email'] = $result[0]['LtEmail'];
			$user['register_date'] = $result[0]['RegDate'];
		}
        return $user;
    }
    
    function logout(){
    	$token = $_COOKIE['token'];
    	setcookie('token',"",time() - 3600,'/','9tech.cn');
    	return ;
    }

    function getUserInfo($user_str,$type=1){
    	$user = array();
    	if(empty($user_str)){
    		return $user;
    	}
    	if($type == 1){
    		if(!is_numeric($user_str) or $user_str < 1){
	    		return $user;
	    	}
    		$result = file_get_contents($this->passport_url.'/interface/getUserInfo.php?user_id='.$user_str);
    	}elseif($type == 2){
    		$result = file_get_contents($this->passport_url.'/interface/getUserInfo.php?user_name='.$user_str);
    	}
    	
		if(strlen(trim($result)) > 0){
			$result = json_decode($result,true);
			$user['id'] = $result[0]['LtUserID'];
			$user['name'] = $result[0]['LtUserName'];
			$user['email'] = $result[0]['LtEmail'];
			$user['register_date'] = $result[0]['RegDate'];
		}
    	
        return $user;
    }

}

?>
