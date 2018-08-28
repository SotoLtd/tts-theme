<?php

class TTS_Course_Fields {

	static function do_meta_fields( $post_id = false ) {
		$fields = tts_course_fields($post_id);
		foreach ( $fields as $meta_key => $meta_label ) {
			if ( method_exists( __CLASS__, $meta_key ) ) {
				call_user_func( array(__CLASS__, $meta_key), $meta_key, $meta_label, $post_id );
			}
		}
	}

	static function course_template( $meta_key, $meta_label, $post_id = false ) {
		$meta_value = get_post_meta( $post_id, $meta_key, true );
		if ( empty( $meta_value ) ) {
			$meta_value = array();
		}
		?>
		<div class="tts-mb-field-wrap">
                    <div class="tts-mb-label"><label for="<?php echo $meta_key ?>"><strong><?php echo $meta_label; ?></strong></label></div>
                    <div class="tts-mb-field tts-select">
                        <select id="<?php echo $meta_key ?>" name="<?php echo $meta_key ?>">
                            <option value="old">Template 1</option>
                            <option value="new" <?php selected($meta_value, 'new', true); ?> >Template 2</option>
                        </select>
                        <p class="description">Select course template.</p>
                    </div>
		</div>
		<?php
	}


	static function accreditation_logos( $meta_key, $meta_label, $post_id = false ) {
		$meta_value = get_post_meta( $post_id, $meta_key, true );
		if ( empty( $meta_value ) ) {
			$meta_value = array();
		}
		?>
		<div class="tts-mb-field-wrap">
			<div class="tts-mb-label"><strong><?php echo $meta_label; ?></strong></div>
			<div class="tts-mb-field tts-checkbox-group">
				<?php
				$acc_logos = tts_get_acc_logos();
				foreach ( $acc_logos as $key => $logo ) {
					?> 
					<label><strong><?php echo $logo['label']; ?></strong>  <input type="checkbox" name="<?php echo $meta_key ?>[]" value="<?php echo esc_attr( $key ); ?>" <?php checked( true, in_array( $key, $meta_value ), true ) ?> /></label>

					<?php
				}
				?>
			</div>
		</div>
		<?php
	}

	static function person_graphic_1( $meta_key, $meta_label, $post_id = false ) {
		$meta_value = get_post_meta( $post_id, $meta_key, true );
		if ( empty( $meta_value ) ) {
			$meta_value = array();
		}
		?>
		<div class="tts-mb-field-wrap">
			<div class="tts-mb-label"><strong><?php echo $meta_label; ?></strong></div>
			<div class="tts-mb-field tts-checkbox-group">
				<?php
				$acc_persons = tts_get_persons_graphics1();
				foreach ( $acc_persons as $key => $logo ) {
					?> 
					<label><strong><?php echo $logo['label']; ?></strong>  <input type="checkbox" name="<?php echo $meta_key ?>[]" value="<?php echo esc_attr( $key ); ?>" <?php checked( true, in_array( $key, $meta_value ), true ) ?> /></label>

					<?php
				}
				?>
			</div>
		</div>
		<?php
	}

	static function quote( $meta_key, $meta_label, $post_id = false ) {
		$meta_value = get_post_meta( $post_id, $meta_key, true );
		?>
		<div class="tts-mb-field-wrap">
			<div class="tts-mb-label"><label for="<?php echo $meta_key ?>"><strong><?php echo $meta_label; ?></strong></label></div>
			<div class="tts-mb-field tts-textarea">
				<textarea id="<?php echo $meta_key ?>" name="<?php echo $meta_key ?>"><?php echo esc_textarea( $meta_value ); ?></textarea>
			</div>
		</div>
		<?php
	}

	static function stickers( $meta_key, $meta_label, $post_id = false ) {
		$meta_value = get_post_meta( $post_id, $meta_key, true );
		if ( empty( $meta_value ) ) {
			$meta_value = array();
		}
		?>
		<div class="tts-mb-field-wrap">
			<div class="tts-mb-label"><strong><?php echo $meta_label; ?></strong></div>
			<div class="tts-mb-field">
				<ul class="tts-stikers-ul clearfix">
					<?php
					$acc_stickers = tts_check_stickers_array( $meta_value );
					foreach ( $acc_stickers as $key => $st ) {
						?> 
						<li>
							<p class="ttsad-control"><span class="tts-sahandle dashicons dashicons-menu"></span><span class="tts-delete-sticker dashicons dashicons-no-alt"></span></p>

							<p class="small-stickers">
								<input type="hidden" name="<?php echo $meta_key . '[' . $key . ']'; ?>[normal]" value="<?php echo esc_attr( $st['normal'] ); ?>"/>
								<a class="tts-add-media tss-has-prev" href="#">Add small sticker</a>
								<span class="tts-media-prev"><?php if ( $st['normal'] ) { ?><img src="<?php echo esc_attr( $st['normal'] ); ?>"/><?php } ?></span>
							</p>

							<p class="hover-stickers">
								<input type="hidden" name="<?php echo $meta_key . '[' . $key . ']'; ?>[hover]" value="<?php echo esc_attr( $st['hover'] ); ?>"/>
								<a class="tts-add-media tss-has-prev" href="#">Add hover sticker</a>
								<span class="tts-media-prev"><?php if ( $st['hover'] ) { ?><img src="<?php echo esc_attr( $st['hover'] ); ?>"/><?php } ?></span>
							</p>
						</li>
						<?php
					}
					?>
				</ul>
				<a href="#" class="tts-add-stiker"><span class="dashicons dashicons-plus"></span></a>
			</div>
		</div>
		<?php
	}

	static function save_stickers( $meta_key, $meta_value, $post_id ) {
		$acc_stickers = tts_check_stickers_array( $meta_value, true );
		if ( $acc_stickers ) {
			update_post_meta( $post_id, $meta_key, $acc_stickers );
		} else {
			delete_post_meta( $post_id, $meta_key );
		}
	}

	static function short_description( $meta_key, $meta_label, $post_id = false ) {
		$meta_value = get_post_meta( $post_id, $meta_key, true );
		?>
		<div class="tts-mb-field-wrap">
			<div class="tts-mb-label"><label for="<?php echo $meta_key ?>"><strong><?php echo $meta_label; ?></strong></label></div>
			<div class="tts-mb-field tts-textarea">

				<?php
				wp_editor( $meta_value, 'ttscourse' . $meta_key, array(
					'wpautop'		 => true,
					'media_buttons'	 => false,
					'textarea_name'	 => $meta_key,
					'textarea_rows'	 => 5,
					'teeny'			 => true
				) );
				?>
			</div>
		</div>
		<?php
	}

	static function person_graphic_2( $meta_key, $meta_label, $post_id = false ) {
		$meta_value = get_post_meta( $post_id, $meta_key, true );
		if ( empty( $meta_value ) ) {
			$meta_value = array();
		}
		?>
		<div class="tts-mb-field-wrap">
			<div class="tts-mb-label"><strong><?php echo $meta_label; ?></strong></div>
			<div class="tts-mb-field tts-checkbox-group">
				<?php
				$acc_persons = tts_get_persons_graphics2();
				foreach ( $acc_persons as $key => $logo ) {
					?> 
					<label><strong><?php echo $logo['label']; ?></strong>  <input type="checkbox" name="<?php echo $meta_key ?>[]" value="<?php echo esc_attr( $key ); ?>" <?php checked( true, in_array( $key, $meta_value ), true ) ?> /></label>

					<?php
				}
				?>
			</div>
		</div>
		<?php
	}

	static function benefits( $meta_key, $meta_label, $post_id = false ) {
		$meta_value = get_post_meta( $post_id, $meta_key, true );
		?>
		<div class="tts-mb-field-wrap">
			<div class="tts-mb-label"><label for="<?php echo $meta_key ?>"><strong><?php echo $meta_label; ?></strong></label></div>
			<div class="tts-mb-field tts-textarea">

				<?php
				wp_editor( $meta_value, 'ttscourse' . $meta_key, array(
					'wpautop'		 => true,
					'media_buttons'	 => false,
					'textarea_name'	 => $meta_key,
					'textarea_rows'	 => 5,
					'teeny'			 => true
				) );
				?>
			</div>
		</div>
		<?php
	}

	static function right_hand_long_graphic( $meta_key, $meta_label, $post_id = false ) {
		$meta_value = get_post_meta( $post_id, $meta_key, true );
		?>
		<div class="tts-mb-field-wrap">
			<div class="tts-mb-label"><label for="<?php echo $meta_key ?>"><strong><?php echo $meta_label; ?></strong></label></div>
			<div class="tts-mb-field tts-media-add">
				<input type="text" name="<?php echo $meta_key ?>" value="<?php echo esc_attr( $meta_value ); ?>" />
				<a href="#" title="Add image using medoa library" class="tts-add-media">Add Image</a>
			</div>
		</div>
		<?php
	}

	static function available_training_centers( $meta_key, $meta_label, $post_id = false ) {
		$meta_value = get_post_meta( $post_id, $meta_key, true );
		if ( empty( $meta_value ) ) {
			$meta_value = array();
		}
		?>
		<div class="tts-mb-field-wrap">
			<div class="tts-mb-label"><strong><?php echo $meta_label; ?></strong></div>
			<div class="tts-mb-field tts-checkbox-group">
				<ul class="clearfix tts-mb-tcchecklists">
					<?php
					$training_centers = tts_get_course_locations();
					foreach ( $training_centers as $tc ) {
						?> 
						<li>
							<label><input type="checkbox" name="<?php echo $meta_key ?>[]" value="<?php echo esc_attr( $tc ); ?>" <?php checked( true, in_array( $tc, $meta_value ) ) ?>/><strong><?php echo $tc; ?></strong></label>
						</li>
			<?php
		}
		?>
				</ul>
			</div>
		</div>
		<?php
	}

	static function available_at_training_centre( $meta_key, $meta_label, $post_id = false ) {
		$meta_value = (bool) get_post_meta( $post_id, $meta_key, true );
		?>
		<div class="tts-mb-field-wrap">
			<div class="tts-mb-label"><label><strong><?php echo $meta_label; ?></strong> <input type="checkbox" name="<?php echo $meta_key ?>" value="1" <?php checked( 1, $meta_value, true ); ?> /></label></div>
		</div>
		<?php
	}

	static function trianing_center_map_graphic( $meta_key, $meta_label, $post_id = false ) {
		$meta_value = get_post_meta( $post_id, $meta_key, true );
		?>
		<div class="tts-mb-field-wrap">
			<div class="tts-mb-label"><label for="<?php echo $meta_key ?>"><strong><?php echo $meta_label; ?></strong></label></div>
			<div class="tts-mb-field tts-media-add">
				<input type="text" name="<?php echo $meta_key ?>" value="<?php echo esc_attr( $meta_value ); ?>" />
				<a href="#" title="Add image using medoa library" class="tts-add-media">Add Image</a>
			</div>
		</div>
		<?php
	}

	static function customer_site_instruction( $meta_key, $meta_label, $post_id = false ) {
		if ( !metadata_exists( 'post', $post_id, $meta_key ) ) {
			$meta_value = "<strong>We can deliver this training anywhere in the South of England, click above to view the area we cover on a map.</strong>";
		} else {
			$meta_value = get_post_meta( $post_id, $meta_key, true );
		}
		?>
		<div class="tts-mb-field-wrap">
			<div class="tts-mb-label"><label for="<?php echo $meta_key ?>"><strong><?php echo $meta_label; ?></strong></label></div>
			<div class="tts-mb-field tts-textarea">

				<?php
				wp_editor( $meta_value, 'ttscourse' . $meta_key, array(
					'wpautop'		 => true,
					'media_buttons'	 => false,
					'textarea_name'	 => $meta_key,
					'textarea_rows'	 => 5,
					'teeny'			 => true
				) );
				?>
			</div>
		</div>
		<?php
	}

	static function training_center_administrate_link( $meta_key, $meta_label, $post_id = false ) {
		$meta_value = get_post_meta( $post_id, $meta_key, true );
		?>
		<div class="tts-mb-field-wrap">
			<div class="tts-mb-label"><label for="<?php echo $meta_key ?>"><strong><?php echo $meta_label; ?></strong></label></div>
			<div class="tts-mb-field">
				<input type="text" name="<?php echo $meta_key ?>" value="<?php echo esc_attr( $meta_value ); ?>" />
			</div>
		</div>
		<?php
	}

	static function available_at_customer_site( $meta_key, $meta_label, $post_id = false ) {
		$meta_value = (bool) get_post_meta( $post_id, $meta_key, true );
		?>
		<div class="tts-mb-field-wrap">
			<div class="tts-mb-label"><label><strong><?php echo $meta_label; ?></strong> <input type="checkbox" name="<?php echo $meta_key ?>" value="1" <?php checked( 1, $meta_value, true ); ?> /></label></div>
		</div>
		<?php
	}

	static function training_administrate_course( $meta_key, $meta_label, $post_id = false ) {
		if ( !class_exists( 'Administrate' ) ) {
			return '';
		}
		$meta_value	 = get_post_meta( $post_id, $meta_key, true );
		$ad_courses	 = get_adminstrate_courses();
		?>
		<div class="tts-mb-field-wrap">
			<div class="tts-mb-label"><label for="<?php echo $meta_key ?>"><strong><?php echo $meta_label; ?></strong></label></div>
			<div class="tts-mb-field">
				<select name="<?php echo $meta_key; ?>">
					<option value="">Select a course</option>
					<?php
					foreach ( $ad_courses as $corse_code => $course ) {
						?>
						<option value="<?php echo esc_attr( $corse_code ); ?>" <?php selected( $corse_code, $meta_value, true ); ?>><?php echo $course->get_title(); ?></option>
			<?php
		}
		?>
				</select>
			</div>
		</div>
		<?php
	}

	static function save_training_administrate_course( $meta_key, $meta_value = '', $post_id = '' ) {
		if ( !class_exists( 'Administrate' ) ) {
			return '';
		}
		update_post_meta( $post_id, $meta_key, $meta_value );
	}

	static function training_hide_book_button( $meta_key, $meta_label, $post_id = false ) {
		$meta_value = (bool) get_post_meta( $post_id, $meta_key, true );
		?>
		<div class="tts-mb-field-wrap">
			<div class="tts-mb-label"><label><strong><?php echo $meta_label; ?></strong> <input type="checkbox" name="<?php echo $meta_key ?>" value="1" <?php checked( 1, $meta_value, true ); ?> /></label></div>
		</div>
		<?php
	}

	static function training_hide_events_table( $meta_key, $meta_label, $post_id = false ) {
		$meta_value = (bool) get_post_meta( $post_id, $meta_key, true );
		?>
		<div class="tts-mb-field-wrap">
			<div class="tts-mb-label"><label><strong><?php echo $meta_label; ?></strong> <input type="checkbox" name="<?php echo $meta_key ?>" value="1" <?php checked( 1, $meta_value, true ); ?> /></label></div>
		</div>
		<?php
	}

	static function customer_site_map_graphic( $meta_key, $meta_label, $post_id = false ) {
		$meta_value = get_post_meta( $post_id, $meta_key, true );
		?>
		<div class="tts-mb-field-wrap">
			<div class="tts-mb-label"><label for="<?php echo $meta_key ?>"><strong><?php echo $meta_label; ?></strong></label></div>
			<div class="tts-mb-field tts-media-add">
				<input type="text" name="<?php echo $meta_key ?>" value="<?php echo esc_attr( $meta_value ); ?>" />
				<a href="#" title="Add image using medoa library" class="tts-add-media">Add Image</a>
			</div>
		</div>
		<?php
	}
        
	static function price( $meta_key, $meta_label, $post_id = false ) {
		$meta_value = get_post_meta( $post_id, $meta_key, true );
		?>
		<div class="tts-mb-field-wrap">
                    <div class="tts-mb-label"><label for="<?php echo $meta_key ?>"><strong><?php echo $meta_label; ?></strong></label></div>
                    <div class="tts-mb-field">
                        <input type="text" name="<?php echo $meta_key ?>" value="<?php echo esc_attr( $meta_value ); ?>" />
                        <p class="description">For example '£125 per person'</p>
                    </div>
		</div>
		<?php
	}
        
	static function price_includes( $meta_key, $meta_label, $post_id = false ) {
		$meta_value = get_post_meta( $post_id, $meta_key, true );
		?>
		<div class="tts-mb-field-wrap">
                    <div class="tts-mb-label"><label for="<?php echo $meta_key ?>"><strong><?php echo $meta_label; ?></strong></label></div>
                    <div class="tts-mb-field tts-textarea">
                        <textarea type="text" name="<?php echo $meta_key ?>"><?php echo esc_textarea($meta_value); ?></textarea>
                        <p class="description">Enter each item in a line.</p>
                    </div>
		</div>
		<?php
	}
        

	static function location( $meta_key, $meta_label, $post_id = false ) {
		$meta_value = get_post_meta( $post_id, $meta_key, true );
		if ( empty( $meta_value ) ) {
			$meta_value = array();
		}
		?>
		<div class="tts-mb-field-wrap">
                    <div class="tts-mb-label"><strong><?php echo $meta_label; ?></strong></div>
                    <div class="tts-mb-field tts-checkbox-group">
                        <ul class="clearfix tts-mb-tcchecklists">
                            <li><label><input type="checkbox" name="<?php echo $meta_key ?>[]" value="bristol" <?php checked( true, in_array( 'bristol', $meta_value ) ) ?>/><strong>Bristol</strong></label></li>
                            <li><label><input type="checkbox" name="<?php echo $meta_key ?>[]" value="onsite" <?php checked( true, in_array( 'onsite', $meta_value ) ) ?>/><strong>On site by arrangement</strong></label></li>
                            <li><label><input type="checkbox" name="<?php echo $meta_key ?>[]" value="nationaltc" <?php checked( true, in_array( 'nationaltc', $meta_value ) ) ?>/><strong>National Training Centres</strong></label></li>
                        </ul>
                        <p class="description">Select location of the course.</p>
                    </div>
		</div>
		<?php
	}
        
	static function duration( $meta_key, $meta_label, $post_id = false ) {
		$meta_value = get_post_meta( $post_id, $meta_key, true );
		?>
		<div class="tts-mb-field-wrap">
                    <div class="tts-mb-label"><label for="<?php echo $meta_key ?>"><strong><?php echo $meta_label; ?></strong></label></div>
                    <div class="tts-mb-field tts-textarea">
                        <textarea type="text" name="<?php echo $meta_key ?>"><?php echo esc_textarea($meta_value); ?></textarea>
                        <p class="description">Enter course duration text.</p>
                    </div>
		</div>
		<?php
	}
        
	static function delegates( $meta_key, $meta_label, $post_id = false ) {
		$meta_value = get_post_meta( $post_id, $meta_key, true );
		?>
		<div class="tts-mb-field-wrap">
                    <div class="tts-mb-label"><label for="<?php echo $meta_key ?>"><strong><?php echo $meta_label; ?></strong></label></div>
                    <div class="tts-mb-field tts-textarea">
                        <textarea type="text" name="<?php echo $meta_key ?>"><?php echo esc_textarea($meta_value); ?></textarea>
                        <p class="description">Enter course delegates text.</p>
                    </div>
		</div>
		<?php
	}

	static function certification_logo( $meta_key, $meta_label, $post_id = false ) {
		$meta_value = get_post_meta( $post_id, $meta_key, true );
		?>
		<div class="tts-mb-field-wrap">
			<div class="tts-mb-label"><label for="<?php echo $meta_key ?>"><strong><?php echo $meta_label; ?></strong></label></div>
			<div class="tts-mb-field tts-media-add">
				<input type="text" name="<?php echo $meta_key ?>" value="<?php echo esc_attr( $meta_value ); ?>" />
				<a href="#" title="Add image using media library" class="tts-add-media">Add Logo</a>
                                
                            <p class="description">Add course certification logo.</p>
			</div>
		</div>
		<?php
	}
        
	static function certification_text( $meta_key, $meta_label, $post_id = false ) {
		$meta_value = get_post_meta( $post_id, $meta_key, true );
		?>
		<div class="tts-mb-field-wrap">
                    <div class="tts-mb-label"><label for="<?php echo $meta_key ?>"><strong><?php echo $meta_label; ?></strong></label></div>
                    <div class="tts-mb-field tts-textarea">
                        <textarea type="text" name="<?php echo $meta_key ?>"><?php echo esc_textarea($meta_value); ?></textarea>
                        <p class="description">Enter course certification text.</p>
                    </div>
		</div>
		<?php
	}
        

	static function who_needs_to_do_text( $meta_key, $meta_label, $post_id = false ) {
            $meta_value = get_post_meta( $post_id, $meta_key, true );
            ?>
            <div class="tts-mb-field-wrap">
                <div class="tts-mb-label"><label for="<?php echo $meta_key ?>"><strong><?php echo $meta_label; ?></strong></label></div>
                <div class="tts-mb-field tts-textarea">

                    <?php
                    wp_editor( $meta_value, 'ttscourse' . $meta_key, array(
                        'wpautop'		 => true,
                        'media_buttons'	 => false,
                        'textarea_name'	 => $meta_key,
                        'textarea_rows'	 => 5,
                        'teeny'			 => true
                    ) );
                    ?>
                </div>
            </div>
            <?php
	}

        
	static function offer( $meta_key, $meta_label, $post_id = false ) {
		$meta_value = get_post_meta( $post_id, $meta_key, true );
		?>
		<div class="tts-mb-field-wrap">
                    <div class="tts-mb-label"><label for="<?php echo $meta_key ?>"><strong><?php echo $meta_label; ?></strong></label></div>
                    <div class="tts-mb-field tts-textarea">
                        <textarea type="text" name="<?php echo $meta_key ?>"><?php echo esc_textarea($meta_value); ?></textarea>
                        <p class="description">Enter course offer text.</p>
                    </div>
		</div>
		<?php
	}
        
	static function trainer( $meta_key, $meta_label, $post_id = false ) {
            $meta_value	 = get_post_meta( $post_id, $meta_key, true );
            $trainers	 = get_posts(array(
                'post_type' => 'trainer',
                'numberposts' => -1,
                'orderby' => 'title',
                'order' => 'ASC',
            ));
            if(!$trainers || is_wp_error($trainers)){
                $trainers = array();
            }
            ?>
            <div class="tts-mb-field-wrap">
                <div class="tts-mb-label"><label for="<?php echo $meta_key ?>"><strong><?php echo $meta_label; ?></strong></label></div>
                <div class="tts-mb-field">
                    <select name="<?php echo $meta_key; ?>">
                        <option value="">Select a trainer</option>
                        <?php
                        foreach ( $trainers as $trainer ) {
                            ?>
                            <option value="<?php echo esc_attr( $trainer->ID ); ?>" <?php selected( $trainer->ID, $meta_value, true ); ?>><?php echo get_the_title($trainer->ID); ?></option>
                        <?php
            }
            ?>
                    </select>
                    
                    <p class="description">Select trainer of the course.</p>
                </div>
            </div>
            <?php
	}
        
        static function cbenefits( $meta_key, $meta_label, $post_id = false ) {
		$meta_value = get_post_meta( $post_id, $meta_key, true );
		if ( empty( $meta_value ) ) {
			$meta_value = array(0 => '');
		} else {
			$meta_value = array_values( $meta_value );
		}
		?>
		<div class="tts-mb-field-wrap ttsmb-cloneable-fieldset">
                    <div class="tts-mb-label"><strong><?php echo $meta_label; ?></strong></div>
                    <div class="tts-mb-clone-wrap">

		<?php foreach ( $meta_value as $k => $value ) { ?>
                        <div class="tts-mb-field-group tts-field-cloneable">
                            <span class="tts-mb-clone-delete dashicons dashicons-dismiss"></span>
                            <span class="tts-mb-clone-sahandle dashicons dashicons-sort"></span>
                            <div class="tts-mb-field-wrap ttsmb-inline">
                                <label for="<?php echo $meta_key . '-' . $k . '-text' ?>">Benefit <span class="tts-label-num"><?php echo $k+1; ?></span> </label>
                                <div class="tts-mb-field tts-textarea">
                                    <textarea id="<?php echo $meta_key . '-' . $k . '-text' ?>" type="text" name="<?php echo $meta_key . '[]' ?>" ><?php echo esc_textarea( $value ); ?></textarea>
                                </div>
                            </div>
                        </div>
		<?php } ?>
			</div>
			<span class="tts-mb-clone-add dashicons dashicons-plus-alt"></span>
		</div>
		<?php
	}
        
	static function testimonials( $meta_key, $meta_label, $post_id = false ) {
		$meta_value = get_post_meta( $post_id, $meta_key, true );
		if ( empty( $meta_value ) ) {
			$meta_value = array(
				0 => array(
					'name'			 => '',
					'job_title'		 => '',
					'company_name'	 => '',
					'city'			 => '',
					'photo'			 => '',
					'testimonial'	 => ''
				)
			);
		} else {
			$meta_value = array_values( $meta_value );
		}
		?>
		<div class="tts-mb-field-wrap ttsmb-cloneable-fieldset">
			<div class="tts-mb-label"><strong><?php echo $meta_label; ?></strong></div>
			<div class="tts-mb-clone-wrap">

		<?php foreach ( $meta_value as $k => $value ) { ?>
					<div class="tts-mb-field-group tts-field-cloneable">
						<span class="tts-mb-clone-delete dashicons dashicons-dismiss"></span>
						<span class="tts-mb-clone-sahandle dashicons dashicons-sort"></span>
						<div class="tts-mb-field-wrap ttsmb-inline">
							<label for="<?php echo $meta_key . '-' . $k . '-name' ?>">Name</label>
							<div class="tts-mb-field">
								<input id="<?php echo $meta_key . '-' . $k . '-name' ?>" type="text" name="<?php echo $meta_key . '[' . $k . '][name]' ?>" value="<?php echo esc_attr( $value['name'] ); ?>"/>
							</div>
						</div>
						<div class="tts-mb-field-wrap ttsmb-inline">
							<label for="<?php echo $meta_key . '-' . $k . '-job_title' ?>">Job Title</label>
							<div class="tts-mb-field">
								<input id="<?php echo $meta_key . '-' . $k . '-job_title' ?>" type="text" name="<?php echo $meta_key . '[' . $k . '][job_title]' ?>" value="<?php echo esc_attr( $value['job_title'] ); ?>"/>
							</div>
						</div>
						<div class="tts-mb-field-wrap ttsmb-inline">
							<label for="<?php echo $meta_key . '-' . $k . '-company_name' ?>">Company Name</label>
							<div class="tts-mb-field">
								<input id="<?php echo $meta_key . '-' . $k . '-company_name' ?>" type="text" name="<?php echo $meta_key . '[' . $k . '][company_name]' ?>" value="<?php echo esc_attr( $value['company_name'] ); ?>"/>
							</div>
						</div>
						<div class="tts-mb-field-wrap ttsmb-inline">
							<label for="<?php echo $meta_key . '-' . $k . '-city' ?>">City</label>
							<div class="tts-mb-field">
								<input id="<?php echo $meta_key . '-' . $k . '-city' ?>" type="text" name="<?php echo $meta_key . '[' . $k . '][city]' ?>" value="<?php echo esc_attr( $value['city'] ); ?>"/>
							</div>
						</div>
						<div class="tts-mb-field-wrap ttsmb-inline">
							<label for="<?php echo $meta_key . '-' . $k . '-photo' ?>">Photo</label>
							<div class="tts-mb-field tts-media-add">
								<input id="<?php echo $meta_key . '-' . $k . '-photo' ?>" type="text" name="<?php echo $meta_key . '[' . $k . '][photo]' ?>" value="<?php echo esc_attr( $value['photo'] ); ?>"/>
								<a href="#" title="Add image using medoa library" class="tts-add-media">Add Image</a>
							</div>
						</div>
						<div class="tts-mb-field-wrap ttsmb-inline">
							<label for="<?php echo $meta_key . '-' . $k . '-testimonial' ?>">Testimonial</label>
							<div class="tts-mb-field tts-textarea">
								<textarea id="<?php echo $meta_key . '-' . $k . '-testimonial' ?>" type="text" name="<?php echo $meta_key . '[' . $k . '][testimonial]' ?>" ><?php echo esc_textarea( $value['testimonial'] ); ?></textarea>
							</div>
						</div>
					</div>
		<?php } ?>
			</div>
			<span class="tts-mb-clone-add dashicons dashicons-plus-alt"></span>
		</div>
		<?php
	}
        
        static function faqs( $meta_key, $meta_label, $post_id = false ) {
		$meta_value = get_post_meta( $post_id, $meta_key, true );
		if ( empty( $meta_value ) ) {
                    $meta_value = array(
                        0 => array(
                            'q' => '',
                            'a' => '',
                        )
                    );
		} else {
                    $meta_value = array_values( $meta_value );
		}
		?>
		<div class="tts-mb-field-wrap ttsmb-cloneable-fieldset">
                    <div class="tts-mb-label"><strong><?php echo $meta_label; ?></strong></div>
                    <div class="tts-mb-clone-wrap">

		<?php foreach ( $meta_value as $k => $value ) { ?>
                        <div class="tts-mb-field-group tts-field-cloneable">
                            <span class="tts-mb-clone-delete dashicons dashicons-dismiss"></span>
                            <span class="tts-mb-clone-sahandle dashicons dashicons-sort"></span>
                            <div class="tts-mb-field-wrap ttsmb-inline">
                                <label for="<?php echo $meta_key . '-' . $k . '-q' ?>">Question <span class="tts-label-num"><?php echo $k+1; ?></span></label>
                                <div class="tts-mb-field">
                                    <input id="<?php echo $meta_key . '-' . $k . '-q' ?>" type="text" name="<?php echo $meta_key . '[' . $k . '][q]' ?>" value="<?php echo esc_attr( $value['q'] ); ?>"/>
                                </div>
                            </div>
                            <div class="tts-mb-field-wrap ttsmb-inline">
                                <label for="<?php echo $meta_key . '-' . $k . '-a' ?>">Answer <span class="tts-label-num"><?php echo $k+1; ?></span> </label>
                                <div class="tts-mb-field tts-textarea">
                                    <textarea id="<?php echo $meta_key . '-' . $k . '-a' ?>" class="sd-visual-editor" type="text" name="<?php echo $meta_key . '[' . $k . '][a]' ?>" ><?php echo esc_textarea( $value['a'] ); ?></textarea>
                                </div>
                            </div>
                        </div>
		<?php } ?>
			</div>
			<span class="tts-mb-clone-add dashicons dashicons-plus-alt"></span>
		</div>
		<?php
	}

        
	static function terms_condition( $meta_key, $meta_label, $post_id = false ) {
		$meta_value = get_post_meta( $post_id, $meta_key, true );
		?>
		<div class="tts-mb-field-wrap">
                    <div class="tts-mb-label"><label for="<?php echo $meta_key ?>"><strong><?php echo $meta_label; ?></strong></label></div>
                    <div class="tts-mb-field tts-textarea">
                        <textarea type="text" name="<?php echo $meta_key ?>"><?php echo esc_textarea($meta_value); ?></textarea>
                        <p class="description">Enter course terms &amp; conditions text.</p>
                    </div>
		</div>
		<?php
	}
        
        
}
