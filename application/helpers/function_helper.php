<?php

/**
 * Timespan
 * 计算两个时间戳之间的更友好的时间格式
 * 计算$first_time到$second_time还有多久!
 * Returns a span of seconds in this format:
 * 	10 days 14 hours 36 minutes 47 seconds
 *
 * @access	public
 * @param	integer	a number of seconds
 * @param	integer	Unix timestamp
 * @return	integer
 */
if (!function_exists('time_span')) {

    function time_span($first_time = 1, $second_time = '',$max_time=2592000,$view_str = '') {
        $CI = & get_instance();
        $CI->lang->load('date');
        if (!is_numeric($second_time)) {
            $second_time = time();
        }
        if (!is_numeric($max_time)) {
            $max_time=2592000;
        }
        if (empty($first_time) || !is_numeric($first_time)) {
            return '';
        } elseif ( !empty($max_time) && $second_time - $first_time >= $max_time) {
            return date('Y-m-d H:i:s', $first_time);
        }

        if ($first_time>=$second_time) {
            return '';
        } else {
            $first_time = $second_time - $first_time;
        }

        $str = '';
        
        $years = floor($first_time / 31536000);
        if ($years > 0) {
            $str .= $years . ' ' . $CI->lang->line((($years > 1) ? 'date_years' : 'date_year')) . '';
            $first_time -= $years * 31536000;
        }

        $months = floor($first_time / 2628000);
        if ($months > 0) {
            $str .= $months . ' ' . $CI->lang->line((($months > 1) ? 'date_months' : 'date_month')) . '';
            $first_time -= $months * 2628000;
        }
        
//        $weeks = floor($first_time / 604800);
//        if ($weeks > 0) {
//            $str .= $weeks . ' ' . $CI->lang->line((($weeks > 1) ? 'date_weeks' : 'date_week')) . '';
//            $first_time -= $weeks * 604800;
//        }

        $days = floor($first_time / 86400);
        if ($days > 0) {
            $str .= $days . ' ' . $CI->lang->line((($days > 1) ? 'date_days' : 'date_day')) . '';
            $first_time -= $days * 86400;
        }

        $hours = floor($first_time / 3600);
        if ($hours > 0) {
            $str .= $hours . ' ' . $CI->lang->line((($hours > 1) ? 'date_hours' : 'date_hour')) . '';
            $first_time -= $hours * 3600;
        }

        $minutes = floor($first_time / 60);
        if ($minutes > 0) {
            $str .= $minutes . ' ' . $CI->lang->line((($minutes > 1) ? 'date_minutes' : 'date_minute')) . '';
            $first_time -= $minutes * 60;
        }

        if ($str == '') {
            $str .= $first_time . ' ' . $CI->lang->line((($first_time > 1) ? 'date_seconds' : 'date_second')) . '';
        }

        return trim($str).$view_str;
    }

}
if (!function_exists('include_view')) {
    function include_view($file,$ext = '.php'){
        $view_paths = APPPATH.'views/';
        $file = $view_paths.$file.$ext;
        if(file_exists($file)){
            include $file;
        }
    }
}

?>
