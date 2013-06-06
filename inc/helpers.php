<?php

/**
* Dump the given value and kill the script.
*
* @param  mixed  $value
* @return void
*
*/

function dd($value){
	
	echo '<pre>';
	var_dump($value);
	echo '</pre>';
	die();

}

/**
 * Savride's environment variables filtering ($_GET, $_POST, etc.) (c) 2008
 * wrapper function
 *
 * @return > a filtered value or redirect if filtered out as abuse  
 * @param $_option Object > get variable by index, example: 'pagename' (useful when var does'nt exist)
 * @param $_old_option Object > use this as default if no value is set
 * @param $_filter Object[optional] regexp for advanced filtering or simple /string/ to deny
 */

class Input {

  	public static function get($_option, $_old_option = false, $_filter = false){
  		  $_value = false;
	  if( isset( $_GET[$_option] )) {
	    $_get_t = $_GET[$_option];
	   
	    if( $_get_t !== false)
	      $_value = $_get_t;
	    }
	 
	  if( isset( $_POST[$_option] )) {
	    $_post_t = $_POST[$_option];
	    
	    if( $_post_t !== false)
	      $_value = $_post_t;
	    }
	 
	  if( $_filter) {
	    if ((( strpos($_filter, "#") !== false) && ( strpos($_filter, "#") == 0))
	      ||
	      (( strpos($_filter, "/") !== false) && ( strpos($_filter, "/") == 0))) {
	        if ( !preg_match( $_filter, $_value)) {
	          $_value = false;
	              //echo "Error _sopt - unwanted chars";
	          }
	      }
	      else
	       if( strpos( $_value, $_filter) !== false) {
	             //echo "$_value  | $_filter";
	         Header( "HTTP/1.1 403 Forbidden" );
	         exit;
	         }
	    }
	 
	  if( !$_value ) 
	    {
	    if ( isset( $_old_option) && ( $_old_option != "") )
	      $_value = $_old_option;
	      else
	      $_value = false;   
	      }
	 
	      //echo $_value;
	  return( $_value );
  	}

  	public static function all(){

  		if( isset($_GET) ){
  			return $_GET;
  		}
  		if( isset($_POST) ){
  			return $_POST;
  		}
  		return false;

  	}

  	public static function has($value = ''){

  		if( isset($_GET[$value]) ){
  			return true;
  		}
  		if( isset($_POST[$value]) ){
  			return true;
  		}
  		return false;

  	}


}

class Str {

	/**
	* Convert a string to lowercase.
	*
	* @param  string  $string
	* @return string
	*
	*/

	public static function lower($string = ''){
		return strtolower(strip_tags($string));
	}

	/**
	* Convert a string to uppercase.
	*
	* @param  string  $string
	* @return string
	*
	*/

	public static function upper($string = ''){
		return strtoupper(strip_tags($string));
	}

	/**
	* Convert a string to title case (ucwords equivalent).
	*
	* @param  string  $string
	* @return string
	*
	*/

	public static function title($string = ''){
		return ucwords(strtolower(strip_tags($string)));
	}

	/**
	* Get the length of a string.
	*
	* @param  string  $string
	* @return int
	*
	*/

	public static function length($string = ''){
		return  strlen(strip_tags($string));
	}

	/**
	* Limit the number of characters in a string.
	* @param  string  $string
	* @param  int     $limit
	* @param  string  $trail
	* @return string
	*
	*/

	public static function limit($string = '', $limit, $trail = '...'){
		
		$string = trim(strip_tags($string));

		if (static::length($string) <= $limit){
			return $string;
		}
		return substr($string, 0, $limit).$trail;
	}

	/**
	* Limit the number of words in a string.
	*
	* @param  string  $string
	* @param  int     $limit
	* @param  string  $trail
	* @return string
	*
	*/

	public static function words($string = '', $limit, $trail = '...'){

		$string = strip_tags($string);

		if (trim($string) == ''){
			return '';
		}

		preg_match('/^\s*+(?:\S++\s*+){1,'.$limit.'}/u', $string, $matches);

		return rtrim($matches[0]).$trail;
	}

	/**
	* Generate a random alpha or alpha-numeric string.
	*
	* @param  int	  $length
	* @param  string  $type
	* @return string
	*
	*/

	public static function random($length, $type = 'alpha_num'){

		switch($type){
			case 'alpha':
				$pool = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
			break;

			case 'num':
				$pool = '1234567890';
			break;

			case 'alpha_num':
				$pool = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
			break;
		}

		return substr(str_shuffle(str_repeat($pool, 5)), 0, $length);

	}

	/**
	* Generate a URL friendly "slug" from a given string.
	*
	* @param  string  $string
	* @param  string  $separator
	* @return string
	*
	*/
	public static function slug($string, $separator = '-'){
		
		// Remove all characters that are not the separator, letters, numbers, or whitespace.
		$string = preg_replace('![^'.preg_quote($separator).'\pL\pN\s]+!u', '', static::lower($string));

		// Replace all separator characters and whitespace by a single separator
		$string = preg_replace('!['.preg_quote($separator).'\s]+!u', $separator, $string);

		return trim($string, $separator);
	}

	/**
	* Return the "URI" style segments in a given string.
	*
	* @param  string  $string
	* @return array
	*
	*/

	public static function segments($string){

		return array_diff(explode('/', trim($string, '/')), array(''));

	}

}

//Date Format Functions
// public function format_date($date){
// 	return date_format(date_create($date), "d/m/Y");
// }
// public function format_date_text($date){
// 	return date_format(date_create($date), "jS F Y");
// }

//Merge Array/Object into Object
// public function object_merge($initial_data, $extra_data){
// 	return (object) array_merge((array) $initial_data, (array) $extra_data);
// }


?>