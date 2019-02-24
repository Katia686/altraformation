<?php
/**
 * Theme storage manipulations
 *
 * @package WordPress
 * @subpackage TRANSLANG
 * @since TRANSLANG 1.0
 */

// Disable direct call
if ( ! defined( 'ABSPATH' ) ) { exit; }

// Get theme variable
if (!function_exists('translang_storage_get')) {
	function translang_storage_get($var_name, $default='') {
		global $TRANSLANG_STORAGE;
		return isset($TRANSLANG_STORAGE[$var_name]) ? $TRANSLANG_STORAGE[$var_name] : $default;
	}
}

// Set theme variable
if (!function_exists('translang_storage_set')) {
	function translang_storage_set($var_name, $value) {
		global $TRANSLANG_STORAGE;
		$TRANSLANG_STORAGE[$var_name] = $value;
	}
}

// Check if theme variable is empty
if (!function_exists('translang_storage_empty')) {
	function translang_storage_empty($var_name, $key='', $key2='') {
		global $TRANSLANG_STORAGE;
		if (!empty($key) && !empty($key2))
			return empty($TRANSLANG_STORAGE[$var_name][$key][$key2]);
		else if (!empty($key))
			return empty($TRANSLANG_STORAGE[$var_name][$key]);
		else
			return empty($TRANSLANG_STORAGE[$var_name]);
	}
}

// Check if theme variable is set
if (!function_exists('translang_storage_isset')) {
	function translang_storage_isset($var_name, $key='', $key2='') {
		global $TRANSLANG_STORAGE;
		if (!empty($key) && !empty($key2))
			return isset($TRANSLANG_STORAGE[$var_name][$key][$key2]);
		else if (!empty($key))
			return isset($TRANSLANG_STORAGE[$var_name][$key]);
		else
			return isset($TRANSLANG_STORAGE[$var_name]);
	}
}

// Inc/Dec theme variable with specified value
if (!function_exists('translang_storage_inc')) {
	function translang_storage_inc($var_name, $value=1) {
		global $TRANSLANG_STORAGE;
		if (empty($TRANSLANG_STORAGE[$var_name])) $TRANSLANG_STORAGE[$var_name] = 0;
		$TRANSLANG_STORAGE[$var_name] += $value;
	}
}

// Concatenate theme variable with specified value
if (!function_exists('translang_storage_concat')) {
	function translang_storage_concat($var_name, $value) {
		global $TRANSLANG_STORAGE;
		if (empty($TRANSLANG_STORAGE[$var_name])) $TRANSLANG_STORAGE[$var_name] = '';
		$TRANSLANG_STORAGE[$var_name] .= $value;
	}
}

// Get array (one or two dim) element
if (!function_exists('translang_storage_get_array')) {
	function translang_storage_get_array($var_name, $key, $key2='', $default='') {
		global $TRANSLANG_STORAGE;
		if (empty($key2))
			return !empty($var_name) && !empty($key) && isset($TRANSLANG_STORAGE[$var_name][$key]) ? $TRANSLANG_STORAGE[$var_name][$key] : $default;
		else
			return !empty($var_name) && !empty($key) && isset($TRANSLANG_STORAGE[$var_name][$key][$key2]) ? $TRANSLANG_STORAGE[$var_name][$key][$key2] : $default;
	}
}

// Set array element
if (!function_exists('translang_storage_set_array')) {
	function translang_storage_set_array($var_name, $key, $value) {
		global $TRANSLANG_STORAGE;
		if (!isset($TRANSLANG_STORAGE[$var_name])) $TRANSLANG_STORAGE[$var_name] = array();
		if ($key==='')
			$TRANSLANG_STORAGE[$var_name][] = $value;
		else
			$TRANSLANG_STORAGE[$var_name][$key] = $value;
	}
}

// Set two-dim array element
if (!function_exists('translang_storage_set_array2')) {
	function translang_storage_set_array2($var_name, $key, $key2, $value) {
		global $TRANSLANG_STORAGE;
		if (!isset($TRANSLANG_STORAGE[$var_name])) $TRANSLANG_STORAGE[$var_name] = array();
		if (!isset($TRANSLANG_STORAGE[$var_name][$key])) $TRANSLANG_STORAGE[$var_name][$key] = array();
		if ($key2==='')
			$TRANSLANG_STORAGE[$var_name][$key][] = $value;
		else
			$TRANSLANG_STORAGE[$var_name][$key][$key2] = $value;
	}
}

// Merge array elements
if (!function_exists('translang_storage_merge_array')) {
	function translang_storage_merge_array($var_name, $key, $value) {
		global $TRANSLANG_STORAGE;
		if (!isset($TRANSLANG_STORAGE[$var_name])) $TRANSLANG_STORAGE[$var_name] = array();
		if ($key==='')
			$TRANSLANG_STORAGE[$var_name] = array_merge($TRANSLANG_STORAGE[$var_name], $value);
		else
			$TRANSLANG_STORAGE[$var_name][$key] = array_merge($TRANSLANG_STORAGE[$var_name][$key], $value);
	}
}

// Add array element after the key
if (!function_exists('translang_storage_set_array_after')) {
	function translang_storage_set_array_after($var_name, $after, $key, $value='') {
		global $TRANSLANG_STORAGE;
		if (!isset($TRANSLANG_STORAGE[$var_name])) $TRANSLANG_STORAGE[$var_name] = array();
		if (is_array($key))
			translang_array_insert_after($TRANSLANG_STORAGE[$var_name], $after, $key);
		else
			translang_array_insert_after($TRANSLANG_STORAGE[$var_name], $after, array($key=>$value));
	}
}

// Add array element before the key
if (!function_exists('translang_storage_set_array_before')) {
	function translang_storage_set_array_before($var_name, $before, $key, $value='') {
		global $TRANSLANG_STORAGE;
		if (!isset($TRANSLANG_STORAGE[$var_name])) $TRANSLANG_STORAGE[$var_name] = array();
		if (is_array($key))
			translang_array_insert_before($TRANSLANG_STORAGE[$var_name], $before, $key);
		else
			translang_array_insert_before($TRANSLANG_STORAGE[$var_name], $before, array($key=>$value));
	}
}

// Push element into array
if (!function_exists('translang_storage_push_array')) {
	function translang_storage_push_array($var_name, $key, $value) {
		global $TRANSLANG_STORAGE;
		if (!isset($TRANSLANG_STORAGE[$var_name])) $TRANSLANG_STORAGE[$var_name] = array();
		if ($key==='')
			array_push($TRANSLANG_STORAGE[$var_name], $value);
		else {
			if (!isset($TRANSLANG_STORAGE[$var_name][$key])) $TRANSLANG_STORAGE[$var_name][$key] = array();
			array_push($TRANSLANG_STORAGE[$var_name][$key], $value);
		}
	}
}

// Pop element from array
if (!function_exists('translang_storage_pop_array')) {
	function translang_storage_pop_array($var_name, $key='', $defa='') {
		global $TRANSLANG_STORAGE;
		$rez = $defa;
		if ($key==='') {
			if (isset($TRANSLANG_STORAGE[$var_name]) && is_array($TRANSLANG_STORAGE[$var_name]) && count($TRANSLANG_STORAGE[$var_name]) > 0) 
				$rez = array_pop($TRANSLANG_STORAGE[$var_name]);
		} else {
			if (isset($TRANSLANG_STORAGE[$var_name][$key]) && is_array($TRANSLANG_STORAGE[$var_name][$key]) && count($TRANSLANG_STORAGE[$var_name][$key]) > 0) 
				$rez = array_pop($TRANSLANG_STORAGE[$var_name][$key]);
		}
		return $rez;
	}
}

// Inc/Dec array element with specified value
if (!function_exists('translang_storage_inc_array')) {
	function translang_storage_inc_array($var_name, $key, $value=1) {
		global $TRANSLANG_STORAGE;
		if (!isset($TRANSLANG_STORAGE[$var_name])) $TRANSLANG_STORAGE[$var_name] = array();
		if (empty($TRANSLANG_STORAGE[$var_name][$key])) $TRANSLANG_STORAGE[$var_name][$key] = 0;
		$TRANSLANG_STORAGE[$var_name][$key] += $value;
	}
}

// Concatenate array element with specified value
if (!function_exists('translang_storage_concat_array')) {
	function translang_storage_concat_array($var_name, $key, $value) {
		global $TRANSLANG_STORAGE;
		if (!isset($TRANSLANG_STORAGE[$var_name])) $TRANSLANG_STORAGE[$var_name] = array();
		if (empty($TRANSLANG_STORAGE[$var_name][$key])) $TRANSLANG_STORAGE[$var_name][$key] = '';
		$TRANSLANG_STORAGE[$var_name][$key] .= $value;
	}
}

// Call object's method
if (!function_exists('translang_storage_call_obj_method')) {
	function translang_storage_call_obj_method($var_name, $method, $param=null) {
		global $TRANSLANG_STORAGE;
		if ($param===null)
			return !empty($var_name) && !empty($method) && isset($TRANSLANG_STORAGE[$var_name]) ? $TRANSLANG_STORAGE[$var_name]->$method(): '';
		else
			return !empty($var_name) && !empty($method) && isset($TRANSLANG_STORAGE[$var_name]) ? $TRANSLANG_STORAGE[$var_name]->$method($param): '';
	}
}

// Get object's property
if (!function_exists('translang_storage_get_obj_property')) {
	function translang_storage_get_obj_property($var_name, $prop, $default='') {
		global $TRANSLANG_STORAGE;
		return !empty($var_name) && !empty($prop) && isset($TRANSLANG_STORAGE[$var_name]->$prop) ? $TRANSLANG_STORAGE[$var_name]->$prop : $default;
	}
}
?>