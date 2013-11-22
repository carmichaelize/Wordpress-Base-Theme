<?php

class page_meta {

	public static function title($id){

		$site_title = get_bloginfo('name');
		$page_title = get_the_title();

		// Site Home
		if( is_home() || is_front_page() ){
			return $site_title;
		}

		// Single/Custom Posts & Pages
		if( is_single() || is_page() ){
			//Custom Meta Title (See meta_options.php)
			if( $meta_title = get_post_meta($id, 'sc_seo_meta_data', true ) ){
				if($meta_title['title'] != ''){
					return $meta_title['title'];
				}
			}
			return $page_title.' - '.$site_title;
		}

		if( is_archive() ){

			// Custom Post Archive
			if( is_post_type_archive() ){
				return get_post_type().' - '.$site_title;
			}

			// Date Archive
			if( is_day() ) {
				return get_the_time('F jS, Y').' - '.$site_title;
			} elseif ( is_month() ) {
				return get_the_time('F, Y').' - '.$site_title;
			} elseif ( is_year() ) {
				return get_the_time('Y').' - '.$site_title;
			}

			// Author Page
			if( is_author() ) {
				return get_query_var('author_name').' - '.$site_title;
			}

			// Category/Tag/Taxonomy Page
			if ( is_category() || is_tag() || is_tax() ) {
				return single_cat_title('', false).' - '.$site_title;
			}

			return 'Archive - '.$site_title;
		}

		return $site_title;

	}

	public static function description($id){

		//Archive Page Description
		if( is_archive() ){

			//Author Bio
			if(is_author()){
				global $post;
				return Str::limit( get_the_author_meta('description', (int)$post->post_author), 160 );
			}

			if( category_description() ){
				return  Str::limit( category_description(), 160 );
			}

		}

		// Single/Custom Posts & Pages
		if( is_single() || is_page() ){

			//Custom Meta Description (See meta_options.php)
			if( $meta_title = get_post_meta($id, 'sc_seo_meta_data', true ) ){
				if($meta_title['description'] != ''){
					return $meta_title['description'];
				}
			}

			global $post;
			if( $post->post_content ){
				return Str::limit( $post->post_content, 160 );
			}

		}

		return Str::limit( get_bloginfo('description'), 160 );

	}

	public static function keywords($id){

		if( is_single() || is_page()){

			//Custom Meta Keywords (See meta_options.php)
			if( $meta_keywords = get_post_meta($id, 'sc_seo_meta_data', true ) ){
				if($meta_keywords['keywords'] != ''){
					return $meta_keywords['keywords'];
				}
			}

			$tags = get_the_tags();

			if($tags){
				foreach($tags as $tag){
					$sep = (empty($keywords)) ? '' : ', ';
					$keywords .= $sep . $tag->name;
				}
			}
			return $keywords;

		}

		return '';

	}

}

?>