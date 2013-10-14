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
	          }
	      }
	      else
	       if( strpos( $_value, $_filter) !== false) {
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
		return strlen($string) <= $limit ? $string : substr($string, 0, $limit).$trail ;

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
		$string = preg_replace('![^'.preg_quote($separator).'\pL\pN\s]+!u', '', strtolower(strip_tags($string)));

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

class Output {

	/**
	* Determine if Number id Odd/Even
	*
	* @param  number  $count
	* @return string
	*
	*/

	public function odd_even($count = 1){

		return $count % 2 == 0 ? "even" : "odd";

	}

	/**
	* Merge Two Arrays/Objects into a Single Object.
	*
	* @param  array/object  $initial_data
	* @param  array/object  $extra_data
	* @return object
	*
	*/

	public function object_merge($initial_data, $extra_data){
 		return (object) array_merge((array) $initial_data, (array) $extra_data);
	}

	/**
	* Add Span To Specified Letter.
	*
	* @param  string  $string
	* @param  string  $class_name
	* @param  array   $words
	* @return string
	*
	*/

	public function drop_letter($string, $class_name = '', $words = array(0)){
		$word_array = str_split($string);
		$new_word = '';
		if(count($word_array) > 1){
			for($i=0;$i<count($word_array);$i++){
				if(in_array($i, $words)){
					$new_word .= '<span class="'.$class_name.'">'.$word_array[$i].'</span>';
				} else {
					$new_word .= $word_array[$i];
				}
			}
			return $new_word;
		}
		return '<span class="'.$class_name.'">'.$string.'</span> ';
	}

	/**
	* Add Span To Specified Word.
	*
	* @param  string  $string
	* @param  string  $class_name
	* @param  array   $words
	* @return string
	*
	*/

	public function drop_word($string, $class_name = '', $words = array(0)){
		$word_array = explode(' ', $string);
		$new_word = '';
		if(count($word_array) > 1){
			for($i=0;$i<count($word_array);$i++){
				if(in_array($i, $words)){
					$new_word .= '<span class="'.$class_name.'">'.$word_array[$i].'</span> ';
				} else {
					$new_word .= $word_array[$i].' ';
				}
			}
			return $new_word;
		}
		return '<span class="'.$class_name.'">'.$string.'</span> ';
	}

	/**
	* Create or Format a Date
	*
	* @param  string/int  $date (e.g. "2012-05-18 15:28:21" OR 1333699439)
	* @param  string  	  $format
	* @return string
	*
	*/

	public function date_format($date = '', $format = "d/m/Y"){
		
		return is_int($date) ? date( $format, $date ) : date_format( date_create($date), $format );
	
	}

}

?>