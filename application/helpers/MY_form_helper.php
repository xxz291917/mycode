<?php

if (!function_exists('set_checkbox')) {

    function set_checkbox($field = '', $value = '', $data = array()) {
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
if (!function_exists('set_radio')) {
    function set_radio($field = '', $value = '', $data = array()) {
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

if (!function_exists('set_select')) {
    function set_select($field = '', $value = '', $data = array()) {
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
        return ' selected="selected"';
    }

}

if (!function_exists('set_value')) {

    function set_value($field = '', $data = array()) {
        if (!isset($data[$field])) {
            return '';
        }
        return form_prep($data[$field]);
    }

}
?>
