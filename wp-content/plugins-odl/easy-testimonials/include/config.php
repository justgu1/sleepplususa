<?php
class easyTestimonialsConfig{	
	var $cycle_transitions;
	var $dir_path;
	var $url_path;
	var $is_pro;
	var $do_export;
	var $cache_time;
	var $cache_enabled;
	var $typography_cache_key;
	var $content_filter_has_run = false;

	function __construct(){		
		$this->cycle_transitions = $this->load_cycle_transitions();
		$this->dir_path = plugin_dir_path( __FILE__ );
		$this->url_path = plugin_dir_url( __FILE__ );
		$this->is_pro = isValidKey();
		$this->do_export = ( isset($_POST['_easy_t_do_export']) && $_POST['_easy_t_do_export'] == '_easy_t_do_export' ) ? true : false;
		$this->cache_time = get_option('easy_t_cache_time', 900); //default to 15 minutes
		$this->cache_enabled = get_option('easy_t_cache_enabled', true); //default to true
		$this->smart_text_avatar_generator = new GP_SmartTextAvatarGenerator();
	}

	function load_theme_array()
	{
		$themes = get_transient('easy_testimonials_theme_listx');
		if ( empty($themes) ) {
			// array of free themes that are available
			$theme_array = array(
				'standard_themes' => array(
					//'quote_style' => 'Quote Style',
					//'new_style' => 'New Style',
					'default_style' => 'Standard Themes - Default Style',
					'dark_style' => 'Standard Themes - Dark Style',
					'light_style' => 'Standard Themes - Light Style',
					'clean_style' => 'Standard Themes - Clean Style',
					'no_style' => 'Standard Themes - No Style'
				)
			);
			$themes = apply_filters('easy_testimonials_theme_array', $theme_array);
			set_transient('easy_testimonials_theme_list', $themes, 3600); // cache for one hour
		}
		return $themes;
	}
	
	function load_cycle_transitions(){
		$cycle_transitions = array(
			'scrollHorz' => 
				array(
					'label' => 	'Horizontal Scroll',
					'pro'	=>	false
				),
			'scrollVert' => 
				array(
					'label' => 	'Vertical Scroll',
					'pro'	=>	true
				),
			'fade' => 
				array(
					'label' => 	'Fade',
					'pro'	=>	false
				),
			'fadeout' => 
				array(
					'label' => 	'Fade Out',
					'pro'	=>	true
				),
			'carousel' => 
				array(
					'label' => 	'Carousel',
					'pro'	=>	true
				),
			'flipHorz' => 
				array(
					'label' => 	'Horizontal Flip',
					'pro'	=>	true
				),
			'flipVert' => 
				array(
					'label' => 	'Vertical Flip',
					'pro'	=>	true
				),
			'tileSlide' => 
				array(
					'label' => 	'Tile Slide',
					'pro'	=>	true
				)
		);	

		return apply_filters('easy_testimonials_transitions_array', $cycle_transitions);
	}
	
	function set_content_flag($new_value)
	{
		$this->content_filter_has_run = $new_value;
	}
	
	function content_filter_has_run()
	{
		return $this->content_filter_has_run;
	}
}	