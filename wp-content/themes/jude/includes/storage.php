<?php
/**
 * Theme storage manipulations
 *
 * @package WordPress
 * @subpackage JUDE
 * @since JUDE 1.0
 */

// Disable direct call
if ( ! defined( 'ABSPATH' ) ) { exit; }

// Get theme variable
if (!function_exists('jude_storage_get')) {
	function jude_storage_get($var_name, $default='') {
		global $JUDE_STORAGE;
		return isset($JUDE_STORAGE[$var_name]) ? $JUDE_STORAGE[$var_name] : $default;
	}
}

// Set theme variable
if (!function_exists('jude_storage_set')) {
	function jude_storage_set($var_name, $value) {
		global $JUDE_STORAGE;
		$JUDE_STORAGE[$var_name] = $value;
	}
}

// Check if theme variable is empty
if (!function_exists('jude_storage_empty')) {
	function jude_storage_empty($var_name, $key='', $key2='') {
		global $JUDE_STORAGE;
		if (!empty($key) && !empty($key2))
			return empty($JUDE_STORAGE[$var_name][$key][$key2]);
		else if (!empty($key))
			return empty($JUDE_STORAGE[$var_name][$key]);
		else
			return empty($JUDE_STORAGE[$var_name]);
	}
}

// Check if theme variable is set
if (!function_exists('jude_storage_isset')) {
	function jude_storage_isset($var_name, $key='', $key2='') {
		global $JUDE_STORAGE;
		if (!empty($key) && !empty($key2))
			return isset($JUDE_STORAGE[$var_name][$key][$key2]);
		else if (!empty($key))
			return isset($JUDE_STORAGE[$var_name][$key]);
		else
			return isset($JUDE_STORAGE[$var_name]);
	}
}

// Inc/Dec theme variable with specified value
if (!function_exists('jude_storage_inc')) {
	function jude_storage_inc($var_name, $value=1) {
		global $JUDE_STORAGE;
		if (empty($JUDE_STORAGE[$var_name])) $JUDE_STORAGE[$var_name] = 0;
		$JUDE_STORAGE[$var_name] += $value;
	}
}

// Concatenate theme variable with specified value
if (!function_exists('jude_storage_concat')) {
	function jude_storage_concat($var_name, $value) {
		global $JUDE_STORAGE;
		if (empty($JUDE_STORAGE[$var_name])) $JUDE_STORAGE[$var_name] = '';
		$JUDE_STORAGE[$var_name] .= $value;
	}
}

// Get array (one or two dim) element
if (!function_exists('jude_storage_get_array')) {
	function jude_storage_get_array($var_name, $key, $key2='', $default='') {
		global $JUDE_STORAGE;
		if (empty($key2))
			return !empty($var_name) && !empty($key) && isset($JUDE_STORAGE[$var_name][$key]) ? $JUDE_STORAGE[$var_name][$key] : $default;
		else
			return !empty($var_name) && !empty($key) && isset($JUDE_STORAGE[$var_name][$key][$key2]) ? $JUDE_STORAGE[$var_name][$key][$key2] : $default;
	}
}

// Set array element
if (!function_exists('jude_storage_set_array')) {
	function jude_storage_set_array($var_name, $key, $value) {
		global $JUDE_STORAGE;
		if (!isset($JUDE_STORAGE[$var_name])) $JUDE_STORAGE[$var_name] = array();
		if ($key==='')
			$JUDE_STORAGE[$var_name][] = $value;
		else
			$JUDE_STORAGE[$var_name][$key] = $value;
	}
}

// Set two-dim array element
if (!function_exists('jude_storage_set_array2')) {
	function jude_storage_set_array2($var_name, $key, $key2, $value) {
		global $JUDE_STORAGE;
		if (!isset($JUDE_STORAGE[$var_name])) $JUDE_STORAGE[$var_name] = array();
		if (!isset($JUDE_STORAGE[$var_name][$key])) $JUDE_STORAGE[$var_name][$key] = array();
		if ($key2==='')
			$JUDE_STORAGE[$var_name][$key][] = $value;
		else
			$JUDE_STORAGE[$var_name][$key][$key2] = $value;
	}
}

// Merge array elements
if (!function_exists('jude_storage_merge_array')) {
	function jude_storage_merge_array($var_name, $key, $value) {
		global $JUDE_STORAGE;
		if (!isset($JUDE_STORAGE[$var_name])) $JUDE_STORAGE[$var_name] = array();
		if ($key==='')
			$JUDE_STORAGE[$var_name] = array_merge($JUDE_STORAGE[$var_name], $value);
		else
			$JUDE_STORAGE[$var_name][$key] = array_merge($JUDE_STORAGE[$var_name][$key], $value);
	}
}

// Add array element after the key
if (!function_exists('jude_storage_set_array_after')) {
	function jude_storage_set_array_after($var_name, $after, $key, $value='') {
		global $JUDE_STORAGE;
		if (!isset($JUDE_STORAGE[$var_name])) $JUDE_STORAGE[$var_name] = array();
		if (is_array($key))
			jude_array_insert_after($JUDE_STORAGE[$var_name], $after, $key);
		else
			jude_array_insert_after($JUDE_STORAGE[$var_name], $after, array($key=>$value));
	}
}

// Add array element before the key
if (!function_exists('jude_storage_set_array_before')) {
	function jude_storage_set_array_before($var_name, $before, $key, $value='') {
		global $JUDE_STORAGE;
		if (!isset($JUDE_STORAGE[$var_name])) $JUDE_STORAGE[$var_name] = array();
		if (is_array($key))
			jude_array_insert_before($JUDE_STORAGE[$var_name], $before, $key);
		else
			jude_array_insert_before($JUDE_STORAGE[$var_name], $before, array($key=>$value));
	}
}

// Push element into array
if (!function_exists('jude_storage_push_array')) {
	function jude_storage_push_array($var_name, $key, $value) {
		global $JUDE_STORAGE;
		if (!isset($JUDE_STORAGE[$var_name])) $JUDE_STORAGE[$var_name] = array();
		if ($key==='')
			array_push($JUDE_STORAGE[$var_name], $value);
		else {
			if (!isset($JUDE_STORAGE[$var_name][$key])) $JUDE_STORAGE[$var_name][$key] = array();
			array_push($JUDE_STORAGE[$var_name][$key], $value);
		}
	}
}

// Pop element from array
if (!function_exists('jude_storage_pop_array')) {
	function jude_storage_pop_array($var_name, $key='', $defa='') {
		global $JUDE_STORAGE;
		$rez = $defa;
		if ($key==='') {
			if (isset($JUDE_STORAGE[$var_name]) && is_array($JUDE_STORAGE[$var_name]) && count($JUDE_STORAGE[$var_name]) > 0) 
				$rez = array_pop($JUDE_STORAGE[$var_name]);
		} else {
			if (isset($JUDE_STORAGE[$var_name][$key]) && is_array($JUDE_STORAGE[$var_name][$key]) && count($JUDE_STORAGE[$var_name][$key]) > 0) 
				$rez = array_pop($JUDE_STORAGE[$var_name][$key]);
		}
		return $rez;
	}
}

// Inc/Dec array element with specified value
if (!function_exists('jude_storage_inc_array')) {
	function jude_storage_inc_array($var_name, $key, $value=1) {
		global $JUDE_STORAGE;
		if (!isset($JUDE_STORAGE[$var_name])) $JUDE_STORAGE[$var_name] = array();
		if (empty($JUDE_STORAGE[$var_name][$key])) $JUDE_STORAGE[$var_name][$key] = 0;
		$JUDE_STORAGE[$var_name][$key] += $value;
	}
}

// Concatenate array element with specified value
if (!function_exists('jude_storage_concat_array')) {
	function jude_storage_concat_array($var_name, $key, $value) {
		global $JUDE_STORAGE;
		if (!isset($JUDE_STORAGE[$var_name])) $JUDE_STORAGE[$var_name] = array();
		if (empty($JUDE_STORAGE[$var_name][$key])) $JUDE_STORAGE[$var_name][$key] = '';
		$JUDE_STORAGE[$var_name][$key] .= $value;
	}
}

// Call object's method
if (!function_exists('jude_storage_call_obj_method')) {
	function jude_storage_call_obj_method($var_name, $method, $param=null) {
		global $JUDE_STORAGE;
		if ($param===null)
			return !empty($var_name) && !empty($method) && isset($JUDE_STORAGE[$var_name]) ? $JUDE_STORAGE[$var_name]->$method(): '';
		else
			return !empty($var_name) && !empty($method) && isset($JUDE_STORAGE[$var_name]) ? $JUDE_STORAGE[$var_name]->$method($param): '';
	}
}

// Get object's property
if (!function_exists('jude_storage_get_obj_property')) {
	function jude_storage_get_obj_property($var_name, $prop, $default='') {
		global $JUDE_STORAGE;
		return !empty($var_name) && !empty($prop) && isset($JUDE_STORAGE[$var_name]->$prop) ? $JUDE_STORAGE[$var_name]->$prop : $default;
	}
}
?>