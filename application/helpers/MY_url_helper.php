<?php

if ( ! function_exists('my_current_url'))
{
	function my_current_url()
	{
		$CI =& get_instance();
		return $CI->config->site_url($CI->uri->uri_string()).'/?'.((isset($_SERVER['QUERY_STRING'])) ? $_SERVER['QUERY_STRING'] : @getenv('QUERY_STRING'));
	}
}


if ( ! function_exists('page_url'))
{
	function page_url()
	{
		return preg_replace('/.per_page=[^&]+/','',my_current_url());
	}
}