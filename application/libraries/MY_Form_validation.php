<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * CodeIgniter
 *
 * An open source application development framework for PHP 5.1.6 or newer
 *
 * @package		CodeIgniter
 * @author		ExpressionEngine Dev Team
 * @copyright	Copyright (c) 2008 - 2011, EllisLab, Inc.
 * @license		http://codeigniter.com/user_guide/license.html
 * @link		http://codeigniter.com
 * @since		Version 1.3.1
 * @filesource
 */
class MY_Form_validation extends CI_Form_validation {

    public function __construct() {
        parent::__construct();
    }

    /**
     * 是否是一个可以转化的字符串，如果返回值不是bool类型，则会改变当前值。
     * @param type $str
     * @return type
     */
    public function is_strtotime($str) {
        return !strtotime($str) ? FALSE : TRUE;
    }
    
	/**
	 * Tests if a number is within a range.
	 *
	 * @param   string  $number number to check
	 * @param   integer $min    minimum value
	 * @param   integer $max    maximum value
	 * @param   integer $step   increment size
	 * @return  boolean
	 */
	public function range($number, $min, $max, $step = NULL)
	{
		if ($number <= $min OR $number >= $max)
		{
			// Number is outside of range
			return FALSE;
		}

		if ( ! $step)
		{
			// Default to steps of 1
			$step = 1;
		}

		// Check step requirements
		return (($number - $min) % $step === 0);
	}

	/**
	 * Checks if a string is a proper hexadecimal HTML color value. The validation
	 * is quite flexible as it does not require an initial "#" and also allows for
	 * the short notation using only three instead of six hexadecimal characters.
	 *
	 * @param   string  $str    input string
	 * @return  boolean
	 */
	public function color($str)
	{
		return (bool) preg_match('/^#?+[0-9a-f]{3}(?:[0-9a-f]{3})?$/iD', $str);
	}
}