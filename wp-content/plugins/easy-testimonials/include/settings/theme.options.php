<?php
class easyTestimonialThemeOptions extends easyTestimonialOptions{
	var $tabs;
	var $config;	
	
	function __construct($config){			
		//call register settings function
		add_action( 'admin_init', array($this, 'register_settings'));	
		
		//assign config
		$this->config = $config;
	}
	
	function register_settings(){		
		//register our settings				
	
		/* Theme selection */
		register_setting( 'easy-testimonials-style-settings-group', 'testimonials_style' );
	}
	
	function render_settings_page()
	{
		//instantiate tabs object for output basic settings page tabs
		$tabs = new GP_Sajak( array(
			'header_label' => 'Theme Settings',
			'settings_field_key' => 'easy-testimonials-style-settings-group', // can be an array			
		) );		
		
		$this->settings_page_top();
		$this->setup_basic_tabs($tabs);
		$this->settings_page_bottom();
	}
	
	function output_theme_options(){			
		$themes = $this->config->load_theme_array();
		
		//load currently selected theme
		$current_theme = get_option('testimonials_style');
		?>
		
		<h3>Style &amp; Theme Options</h3>
		<p class="description">Select which style you want to use.  If 'No Style' is selected, only your Theme's CSS, and any Custom CSS you've added, will be used.</p>
				
		<table class="form-table easy_t_options">
			<tr>
				<td>
					<fieldset>
						<legend>Select Your Theme</legend>
						<select name="testimonials_style" id="testimonials_style">	
							<?php foreach($themes as $group_key => $theme_group): ?>
							<?php $group_label = $this->get_theme_group_label($theme_group); ?>									
								<optgroup  label="<?php echo htmlentities($group_label);?>">
									<?php foreach($theme_group as $key => $theme_name): ?>
										<option value="<?php echo $key ?>" <?php if($current_theme == $key): echo 'selected="SELECTED"'; endif; ?>><?php echo htmlentities($theme_name); ?></option>
									<?php endforeach; ?>
								</optgroup>
							<?php endforeach; ?>
						</select>
					</fieldset>
					
					<h4>Preview Selected Theme</h4>
					<p class="description">Please note: your Theme's CSS may impact the appearance.</p>
					<p><strong>Current Saved Theme Selection:</strong>  <?php echo ucwords(str_replace('-', ' - ', str_replace('_',' ', str_replace('-style', '', $current_theme)))); ?></p>
					<div id="easy_t_preview" class="easy_t_preview">
						<p class="easy_testimonials_not_registered" style="display: none; margin-bottom: 20px;"><a href="https://goldplugins.com/our-plugins/easy-testimonials-details/upgrade-to-easy-testimonials-pro/?utm_source=themes_preview"><?php _e('This Theme Requires Pro! Upgrade to Easy Testimonials Pro now', 'easy-testimonials');?></a> <?php _e('to unlock all 75+ themes!', 'easy-testimonials');?> </p>
						<div class="style-<?php echo str_replace('-style', '', $current_theme); ?> easy_t_single_testimonial">
							<blockquote itemprop="review" itemscope itemtype="http://schema.org/Review" class="easy_testimonial" style="">
								<img class="attachment-easy_testimonial_thumb wp-post-image easy_testimonial_mystery_person" src="<?php echo $this->config->url_path . 'assets/img/mystery-person.png';?>" />		
								<p itemprop="name" class="easy_testimonial_title">Support is second to none</p>	
								<div class="testimonial_body" itemprop="description">
									<p>I looked at several testimonial plugins, and Easy Testimonials was by far the best, most user friendly and customizable plugin I found (and a reasonable price).</p>
									<a href="https://goldplugins.com/testimonials/" class="easy_testimonials_read_more_link">Read More Testimonials</a>			
								</div>	
								<p class="testimonial_author">
									<cite>
										<span class="testimonial-client" itemprop="author" style="">Greg Campisi</span>
										<span class="testimonial-position" style="">GC Design and Creation</span>
										<span class="testimonial-other" itemprop="itemReviewed">Easy Testimonials Pro&nbsp;</span>
										<span class="date" itemprop="datePublished" content="January 29, 2016" style="">January 29, 2016&nbsp;</span>
										<span itemprop="reviewRating" itemscope itemtype="http://schema.org/Rating" class="stars">
											<meta itemprop="worstRating" content="1"/>
											<meta itemprop="ratingValue" content="5"/>
											<meta itemprop="bestRating" content="5"/>
											<span class="dashicons dashicons-star-filled"></span><span class="dashicons dashicons-star-filled"></span><span class="dashicons dashicons-star-filled"></span><span class="dashicons dashicons-star-filled"></span><span class="dashicons dashicons-star-filled"></span>			
										</span>	
									</cite>
								</p>	
							</blockquote>
						</div>
					</div>
				</td>
			</tr>
		</table>
		<?php
	}
	
	function setup_basic_tabs($tabs){	
		$this->tabs = $tabs;
	
		$this->tabs->add_tab(
			'theme_options', // section id, used in url fragment
			'Theme Options', // section label
			array($this, 'output_theme_options'), // display callback
			array(
				'class' => 'extra_li_class', // extra classes to add sidebar menu <li> and tab wrapper <div>
				'icon' => 'paint-brush' // icons here: http://fontawesome.io/icons/
			)
		);
		
		$this->tabs->display();
	}
	
	//some functions for theme output
	function get_theme_group_label($theme_group)
	{
		reset($theme_group);
		$first_key = key($theme_group);
		$group_label = $theme_group[$first_key];
		if ( ($dash_pos = strpos($group_label, ' -')) !== FALSE && ($avatar_pos = strpos($group_label, 'Avatar')) === FALSE ) {
			$group_label = substr($group_label, 0, $dash_pos);
		}
		return $group_label;
	}
}