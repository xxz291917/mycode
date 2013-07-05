<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/** 
*
* @project CodeIgniter
* @version $id$
* @date 2012-11-06
* @author qinyf
* @copyright (c) 2012 9ria
*
*/
class Restclient
{
	var $CI;
	private $curr_url = '';
	private $datatype = 'json';
	private $header = array();
	private $timeout = 10;
	private $connect_timeout = 10;
	
	function __construct($params=array('datatype'=>"json"))
	{
		if(!isset($this->CI)){
			$this->CI = & get_instance();
		}
		if(isset($params))
		{
			$this->initialize($params);
		}
	}
	
	function initialize($config=array())
	{
		if(count($config) > 0){
			foreach($config as $key => $val){
				if(isset($this->$key)){
					$this->$key = $val;
				}
			}
		}
	}
	
	public function set_header($header)
	{
		$this->header = $header;		
	}
	
	public function set_return_type($type)
	{
		$this->datatype = $type;
	}
	
	public function get($url,$param=array())
	{
		if(substr($url,0,1) == '/'){
			$url = 'http://'.$_SERVER['HTTP_HOST'].$url;
		}
		if(substr($url,-1,1) != '?'){
			$url .= '?'.$this->_getParameter($param);
		}
		if(function_exists('curl_init')){
			$session = curl_init($url);
			curl_setopt($session, CURLOPT_HEADER,false);
			curl_setopt($session, CURLOPT_FOLLOWLOCATION, 1);
			curl_setopt($session, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($session, CURLOPT_CONNECTTIMEOUT, $this->connect_timeout);
			curl_setopt($session, CURLOPT_TIMEOUT, $this->timeout);
			
			if(!empty($this->header)){
				curl_setopt($session, CURLOPT_HTTPHEADER, $this->header);
			}
			$response = curl_exec($session);
			curl_close($session);
		}else{
			$response = file_get_contents($url);
		}
		if($this->datatype == 'json'){
			$ret = json_decode($response);
		}else{
			$ret = $response;
		}
		
		return $ret;
	}

	public function post($url,$param=array())
	{
		if(substr($url,0,1) == '/'){
			$url = 'http://'.$_SERVER['HTTP_HOST'].$url;
		}
		$session = curl_init($url);
		curl_setopt($session, CURLOPT_POSTFIELDS, $this->_getParameter($param));
		curl_setopt($session, CURLOPT_POST, true);
		curl_setopt($session, CURLOPT_HTTPHEADER, false);
		curl_setopt($session, CURLOPT_RETRUNTRANSFER, true);
		curl_setopt($session, CURLOPT_CONNECTTIMEOUT, $this->connect_timeout);
		curl_setopt($session, CURLOPT_TIMEOUT, $this->timeout);
		if(!empty($this->header)){
			curl_setopt($session, CURLOPT_HTTPHEADER, $this->header);
		}
		$response = curl_exec($session);
		curl_close($session);
		if($this->datatype == 'json'){
			$ret = json_decode($response);
		}else{
			$ret = $response;
		}
		
		return $ret;
	}	
	
	function _getParameter($param)
	{
		$ret = '';
		if(is_array($param)){
			$ret = http_build_query($param);
		}else{
			$ret = $param;
		}
		return $ret;
	}
}