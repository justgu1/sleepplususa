<?php
//single testimonial default template
 ?>
		<div class="<?php echo $output_theme; ?> <?php echo $attribute_classes; ?> easy_t_single_testimonial" <?php echo $width_style; ?>>
			<?php
				//output json-ld review markup, if option is set
				if($output_schema_markup){
					echo $this->output_jsonld_markup($display_testimonial);
				}
			?>
			<blockquote class="easy_testimonial">
				<?php if ($show_thumbs) {
					?><div class="easy_testimonial_image_wrapper"><?php
					echo $display_testimonial['image'];
					?></div><?php
				} ?>		
				<?php if ($show_title) {
					echo '<p class="easy_testimonial_title">' . get_the_title($display_testimonial['id']) . '</p>';
				} ?>	
				<?php if($meta_data_position == "above") { ?>				
				<p class="<?php echo $author_class; ?>">
					<?php //if any of the items have data and are set to be displayed, construct the html ?>
					<?php if($show_the_client || $show_the_position || $show_the_other || $show_the_date || $show_rating == "stars" ): ?>
					<cite>
						<?php if($show_the_client): ?>
							<span class="testimonial-client"><?php echo $this->easy_t_clean_html($display_testimonial['client']);?></span>
						<?php endif; ?>
						<?php if($show_the_position): ?>
							<span class="testimonial-position"><?php echo $this->easy_t_clean_html($display_testimonial['position']);?></span>
						<?php endif; ?>
						<?php if($show_the_other): ?>
							<span class="testimonial-other"><?php echo $this->easy_t_clean_html($display_testimonial['other']);?></span>
						<?php endif; ?>
						<?php if($show_the_date): ?>
							<span class="date"><?php echo $this->easy_t_clean_html($display_testimonial['date']);?></span>
						<?php endif; ?>
						<?php if($show_the_rating): ?>
							<?php if(strlen($display_testimonial['num_stars'])>0): ?>
							<span class="stars">
							<?php			
								$x = 5; //total available stars
								//output dark stars for the filled in ones
								for($i = 0; $i < $display_testimonial['num_stars']; $i ++){
									echo '<span class="dashicons dashicons-star-filled"></span>';
									$x--; //one less star available
								}
								//fill out the remaining empty stars
								for($i = 0; $i < $x; $i++){
									echo '<span class="dashicons dashicons-star-filled empty"></span>';
								}
							?>			
							</span>	
							<?php endif; ?>
						<?php endif; ?>
					</cite>
					<?php endif; ?>					
				</p>	
				<?php } ?>
				<div class="<?php echo $body_class; ?>">
					<?php echo $display_testimonial['content']; ?>
				</div>	
				<?php if($meta_data_position == "below") { ?>				
				<p class="<?php echo $author_class; ?>">
					<?php //if any of the items have data and are set to be displayed, construct the html ?>
					<?php if($show_the_client || $show_the_position || $show_the_other || $show_the_date || $show_rating == "stars" ): ?>
					<cite>
						<?php if($show_the_client): ?>
							<span class="testimonial-client"><?php echo $this->easy_t_clean_html($display_testimonial['client']);?></span>
						<?php endif; ?>
						<?php if($show_the_position): ?>
							<span class="testimonial-position"><?php echo $this->easy_t_clean_html($display_testimonial['position']);?></span>
						<?php endif; ?>
						<?php if($show_the_other): ?>
							<span class="testimonial-other"><?php echo $this->easy_t_clean_html($display_testimonial['other']);?></span>
						<?php endif; ?>
						<?php if($show_the_date): ?>
							<span class="date"><?php echo $this->easy_t_clean_html($display_testimonial['date']);?></span>
						<?php endif; ?>
						<?php if($show_the_rating): ?>
							<?php if(strlen($display_testimonial['num_stars'])>0): ?>
							<span class="stars">
							<?php			
								$x = 5; //total available stars
								//output dark stars for the filled in ones
								for($i = 0; $i < $display_testimonial['num_stars']; $i ++){
									echo '<span class="dashicons dashicons-star-filled"></span>';
									$x--; //one less star available
								}
								//fill out the remaining empty stars
								for($i = 0; $i < $x; $i++){
									echo '<span class="dashicons dashicons-star-filled empty"></span>';
								}
							?>			
							</span>	
							<?php endif; ?>
						<?php endif; ?>
					</cite>
					<?php endif; ?>					
				</p>	
				<?php if($show_view_more):?><a href="<?php echo $testimonials_link; ?>" class="easy_testimonials_read_more_link"><?php echo get_option('easy_t_view_more_link_text', 'Read More Testimonials'); ?></a><?php endif; ?>
				<?php } ?>
				<div class="easy_t_clear"></div>
			</blockquote>
		</div>