<?php

if (!function_exists('my_set_checkbox')) {

    function my_set_checkbox($field = '', $value = '', $data = array()) {
            if (!isset($data[$field])) {
                return '';
            }
            $field = $data[$field];
            if (is_array($field)) {
                if (!in_array($value, $field)) {
                    return '';
                }
            } else {
                if (($field == '' OR $value == '') OR ($field != $value)) {
                    return '';
                }
            }
            return ' checked="checked"';
    }

}

// ------------------------------------------------------------------------

/**
 * Set Radio
 *
 * Let's you set the selected value of a radio field via info in the POST array.
 * If Form Validation is active it retrieves the info from the validation class
 *
 * @access	public
 * @param	string
 * @param	string
 * @param	bool
 * @return	string
 */
if (!function_exists('my_set_radio')) {
    function my_set_radio($field = '', $value = '', $data = array()) {
        echo $field;
        if (!isset($data[$field])) {
            return '';
        }
        $field = $data[$field];
        if ($field != $value) {
            return '';
        }
        return ' checked="checked"';
    }

}

if (!function_exists('my_set_select')) {
    function my_set_select($field = '', $value = '', $data = array()) {
        if (!isset($data[$field])) {
            return '';
        }
        $field = $data[$field];
        if (is_array($field)) {
            if (!in_array($value, $field)) {
                return '';
            }
        } else {
            if ($field != $value) {
                return '';
            }
        }
        return ' selected="selected"';
    }

}

if (!function_exists('my_set_value')) {

    function my_set_value($field = '', $data = array(),$default='') {
        if (!isset($data[$field]) || $data[$field]=='') {
//            file_put_contents('xxz.txt', $default, 8);
            return $default;
        }
        return form_prep($data[$field]);
    }

}

if (!function_exists('my_validation_errors')) {

    function my_validation_errors($prefix = '', $suffix = '') {
        if (FALSE === ($OBJ = & _get_validation_object())) {
            return '';
        }
        $error = $OBJ->error_string($prefix, $suffix);
        $errors = array_unique(preg_split('/\n+/', $error));
        if (is_array($errors)) {
            return json_encode($errors);
        } else {
            return '';
        }
    }

}

if (!function_exists('set_date')) {

    function my_set_date($field = '', $data = array(),$date_format='Y-m-d H:i:s') {
        if (!isset($data[$field]) || empty($data[$field])) {
            return '';
        }
        return date($date_format,intval($data[$field]));
    }

}

if ( ! function_exists('set_value'))
{
	function set_value($field = '', $default = '')
	{
		if (FALSE === ($OBJ =& _get_validation_object()))
		{
                        if(substr($field, -2)=='[]'){
                            $field = substr($field, 0,-2);
                        }
			if ( ! isset($_POST[$field]))
			{
				return $default;
			}
                        if (is_array($_POST[$field]))
                        {
                                return array_shift($_POST[$field]);
                        }
			return form_prep($_POST[$field], $field);
		}

		return form_prep($OBJ->set_value($field, $default), $field);
	}
}

?>
