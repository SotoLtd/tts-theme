<?php
include_once untrailingslashit( dirname( __FILE__ ) ) . '/course_fields.php';
include_once untrailingslashit( dirname( __FILE__ ) ) . '/course.php';
include_once untrailingslashit( dirname( __FILE__ ) ) . '/course-functions.php';

class TTS_Courses {

	static $post_type				 = 'courses';
	static $post_slug				 = 'course';
	static $singular				 = 'Course';
	static $plural					 = 'Course';
	static $text_domain				 = 'twentyten';
	static $css						 = '';
	static $js						 = '';
	static $path;
	static $instance				 = null;
	public $one_time_actions_added	 = false;
	public $menu_items;
	public $menuItemId;
	
	public $messages= array();

	/**
	 * get instance
	 * @return object
	 */
	static function get_instance() {
		if ( empty( self::$instance ) ) {
			self::$instance = new TTS_Courses();
		}

		return self::$instance;
	}

	public function __construct() {
		if ( !$this->one_time_actions_added ) {
			$this->init_var();
			$this->add_one_time_actions();
			$this->one_time_actions_added = true;
		}
	}

	public function init_var() {
		$this->one_time_actions_added	 = false;
		self::$css						 = get_stylesheet_directory_uri() . '/courses/css';
		self::$js						 = get_stylesheet_directory_uri() . '/courses/js';
		self::$path						 = untrailingslashit( dirname( __FILE__ ) );
	}

	public function add_one_time_actions() {
		$this->one_time_actions_added = true;
		add_action( 'after_switch_theme', array($this, 'after_switch_theme') );
		add_action( 'init', array($this, 'init') );
		add_action( 'admin_init', array($this, 'admin_init') );
		add_action( 'admin_enqueue_scripts', array($this, 'admin_assets') );
		add_action( 'wp_enqueue_scripts', array($this, 'assets') );

		add_action( 'course_category_add_form_fields', array($this, 'course_category_add_fields'), 10 );
		add_action( 'course_category_edit_form_fields', array($this, 'course_category_edit_fields'), 10, 2 );
		add_action( 'created_term', 'save_course_category_fields', 10, 3 );
		add_action( 'edit_term', array($this, 'save_course_category_fields'), 10, 3 );

		add_action( 'pre_get_posts', array($this, 'category_posts_per_page') );

		//add_action('template_redirect', array($this, 'training_course_submenu'));

		add_filter( 'template_include', array($this, 'load_template') );

		add_shortcode( 'tts_courses', array($this, 'tts_courses') );
		add_shortcode( 'tts_courses_category_boxes', array($this, 'tts_courses_category_boxes') );
                add_shortcode('tts_row', array($this, 'sc_row'));
                add_shortcode('tts_col', array($this, 'tts_col'));

		// Settings for courses
		add_action( 'admin_menu', array($this, 'add_settings_page') );
	}

	public function admin_init() {
		$this->save_settings();
		add_action( 'save_post', array($this, 'save_fields') );
		include_once self::$path . '/meta_fields.php';
	}

	public function init() {
		$this->course_taxonomy_metadata_wpdbfix();

		$this->register_post_type();

		if ( class_exists( 'AdministratePlugin' ) ) {
			include_once self::$path . '/adminstrate/shortcodes/event_table_1/event_table_1.php';
			include_once self::$path . '/adminstrate/shortcodes/event_table_2/event_table_2.php';
			global $_ADMINISTRATE;
			new AdministrateWidgetEventTable1( $_ADMINISTRATE );
			new AdministrateWidgetEventTable2( $_ADMINISTRATE );
		}
	}

	public function register_post_type() {
		// Register the taxonomy
		$labels	 = array(
			'name'						 => _x( 'Course Categories', 'taxonomy general name', self::$text_domain ),
			'singular_name'				 => _x( 'Course  Category', 'taxonomy singular name', self::$text_domain ),
			'search_items'				 => __( 'Search Course Categories', self::$text_domain ),
			'popular_items'				 => __( 'Popular Course Categories', self::$text_domain ),
			'all_items'					 => __( 'All Course Categories', self::$text_domain ),
			'parent_item'				 => null,
			'parent_item_colon'			 => null,
			'edit_item'					 => __( 'Edit Course Category', self::$text_domain ),
			'update_item'				 => __( 'Update Course Category', self::$text_domain ),
			'add_new_item'				 => __( 'Add New Course Category', self::$text_domain ),
			'new_item_name'				 => __( 'New Course Category', self::$text_domain ),
			'separate_items_with_commas' => __( 'Separate Course Categories with commas', self::$text_domain ),
			'add_or_remove_items'		 => __( 'Add or remove Course Categories', self::$text_domain ),
			'choose_from_most_used'		 => __( 'Choose from the most used Course Categories', self::$text_domain ),
			'not_found'					 => __( 'No Course  found.', self::$text_domain ),
			'menu_name'					 => __( 'Categories', self::$text_domain ),
		);
		$args	 = array(
			"labels"			 => $labels,
			'public'			 => true,
			'hierarchical'		 => true,
			'show_ui'			 => true,
			'show_in_nav_menus'	 => true,
			'show_admin_column'	 => true,
			'args'				 => array('orderby' => 'term_order'),
			'query_var'			 => true,
			'rewrite'			 => array('slug' => self::$post_slug . '/category', 'with_front' => false),
		);
		register_taxonomy( 'course_category', self::$post_type, $args );

		$labels = array(
			'name'				 => _x( self::$singular, 'post type general name', self::$text_domain ),
			'singular_name'		 => _x( self::$singular, 'post type singular name', self::$text_domain ),
			'menu_name'			 => _x( self::$plural, 'admin menu', self::$text_domain ),
			'name_admin_bar'	 => _x( self::$singular, 'add new on admin bar', self::$text_domain ),
			'add_new'			 => _x( 'Add New', strtolower( self::$singular ), self::$text_domain ),
			'add_new_item'		 => __( 'Add New ' . self::$singular, self::$text_domain ),
			'new_item'			 => __( 'New ' . self::$singular, self::$text_domain ),
			'edit_item'			 => __( 'Edit ' . self::$singular, self::$text_domain ),
			'view_item'			 => __( 'View ' . self::$singular, self::$text_domain ),
			'all_items'			 => __( 'All ' . self::$plural, self::$text_domain ),
			'search_items'		 => __( 'Search ' . self::$plural, self::$text_domain ),
			'parent_item_colon'	 => __( 'Parent ' . self::$plural, self::$text_domain ),
			'not_found'			 => __( 'No ' . self::$plural . ' found.', self::$text_domain ),
			'not_found_in_trash' => __( 'No ' . strtolower( self::$plural ) . ' found in Trash.', self::$text_domain )
		);

		$args = array(
			'labels'				 => $labels,
			'public'				 => true,
			'publicly_queryable'	 => true,
			'show_ui'				 => true,
			'show_in_menu'			 => true,
			'query_var'				 => true,
			'rewrite'				 => array('slug' => self::$post_slug),
			'capability_type'		 => 'post',
			'has_archive'			 => true,
			'show_in_nav_menus'		 => true,
			'hierarchical'			 => false,
			'menu_position'			 => 5,
			'supports'				 => array('title', 'editor', 'thumbnail', 'excerpt'),
			'register_meta_box_cb'	 => array($this, 'course_fields'),
			'taxonomies'			 => array('course_category')
		);

		register_post_type( self::$post_type, $args );
                
                $labels = array(
			'name'				 => _x( 'Trainer', 'post type general name', self::$text_domain ),
			'singular_name'		 => _x( 'Trainer', 'post type singular name', self::$text_domain ),
			'menu_name'			 => _x( 'Trainers', 'admin menu', self::$text_domain ),
			'name_admin_bar'	 => _x( 'Trainer', 'add new on admin bar', self::$text_domain ),
			'add_new'			 => _x( 'Add New','trainer', self::$text_domain ),
			'add_new_item'		 => __( 'Add New Trainer', self::$text_domain ),
			'new_item'			 => __( 'New Trainer', self::$text_domain ),
			'edit_item'			 => __( 'Edit Trainer', self::$text_domain ),
			'view_item'			 => __( 'View Trainer', self::$text_domain ),
			'all_items'			 => __( 'All Trainers', self::$text_domain ),
			'search_items'		 => __( 'Search Trainers', self::$text_domain ),
			'parent_item_colon'	 => __( 'Parent Trainers', self::$text_domain ),
			'not_found'			 => __( 'No Trainers found.', self::$text_domain ),
			'not_found_in_trash' => __( 'No trainers found in Trash.', self::$text_domain )
		);

		$args = array(
			'labels'				 => $labels,
			'public'				 => false,
			'publicly_queryable'	 => false,
			'show_ui'				 => true,
			'show_in_menu'			 => true,
			'query_var'				 => false,
			'rewrite'				 => false,
			'capability_type'		 => 'post',
			'has_archive'			 => false,
			'show_in_nav_menus'		 => false,
			'hierarchical'			 => false,
			'menu_position'			 => 5.1,
			'supports'                       => array('title', 'editor', 'thumbnail'),
		);

		register_post_type( 'trainer', $args );
	}

	public function after_switch_theme() {
		$this->create_tables();
		flush_rewrite_rules();
	}

	public function create_tables() {
		global $wpdb;

		$wpdb->hide_errors();

		$collate = '';

		if ( $wpdb->has_cap( 'collation' ) ) {
			if ( !empty( $wpdb->charset ) ) {
				$collate .= "DEFAULT CHARACTER SET $wpdb->charset";
			}
			if ( !empty( $wpdb->collate ) ) {
				$collate .= " COLLATE $wpdb->collate";
			}
		}

		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
		$tables_sql = "
        CREATE TABLE {$wpdb->prefix}course_termmeta (
	  meta_id bigint(20) NOT NULL auto_increment,
	  course_term_id bigint(20) NOT NULL,
	  meta_key varchar(255) NULL,
	  meta_value longtext NULL,
	  PRIMARY KEY  (meta_id),
	  KEY course_term_id (course_term_id),
	  KEY meta_key (meta_key)
	) $collate;";

		dbDelta( $tables_sql );
	}

	public function course_taxonomy_metadata_wpdbfix() {
		global $wpdb;
		$termmeta_name = 'course_termmeta';

		$wpdb->course_termmeta	 = $wpdb->prefix . $termmeta_name;
		$wpdb->tables[]			 = 'course_termmeta';
	}

	public function course_category_add_fields() {
		?>
		<div class="form-field">
			<label><?php _e( 'Featured Images', self::$text_domain ); ?></label>
			<div id="course_cat_featured_image" style="float:left;margin-right:10px;"><img src="<?php echo get_stylesheet_directory_uri() . '/images/placeholder.png'; ?>" width="60px" height="60px" /></div>
			<div style="line-height:60px;">
				<input type="hidden" id="course_cat_featured_image_id" name="_featured_image_id" />
				<button type="button" class="course-cat-ubutton button"><?php _e( 'Upload/Add image', self::$text_domain ); ?></button>
				<button type="button" class="course-cat-rbutton button"><?php _e( 'Remove image', self::$text_domain ); ?></button>
			</div>
			<script type="text/javascript">

				// Only show the "remove image" button when needed
				if (!jQuery('#course_cat_featured_image_id').val())
					jQuery('.course-cat-rbutton').hide();

				// Uploading files
				var file_frame;

				jQuery(document).on('click', '.course-cat-ubutton', function (event) {

					event.preventDefault();

					// If the media frame already exists, reopen it.
					if (file_frame) {
						file_frame.open();
						return;
					}

					// Create the media frame.
					file_frame = wp.media.frames.downloadable_file = wp.media({
						title: '<?php _e( 'Choose an image', self::$text_domain ); ?>',
						button: {
							text: '<?php _e( 'Use image', self::$text_domain ); ?>',
						},
						multiple: false
					});

					// When an image is selected, run a callback.
					file_frame.on('select', function () {
						attachment = file_frame.state().get('selection').first().toJSON();

						jQuery('#course_cat_featured_image_id').val(attachment.id);
						jQuery('#course_cat_featured_image img').attr('src', attachment.url);
						jQuery('.course-cat-rbutton').show();
					});

					// Finally, open the modal.
					file_frame.open();
				});

				jQuery(document).on('click', '.course-cat-rbutton', function (event) {
					jQuery('#course_cat_featured_image img').attr('src', '<?php echo get_stylesheet_directory_uri() . '/images/placeholder.png'; ?>');
					jQuery('#course_cat_featured_image_id').val('');
					jQuery('.course-cat-rbutton').hide();
					return false;
				});

			</script>
			<div class="clear"></div>
		</div>
		<?php
	}

	public function course_category_edit_fields( $term, $taxonomy ) {
		$title			 = get_course_term_meta( $term->term_id, '_title', true );
		$description	 = get_course_term_meta( $term->term_id, '_description', true );
                $disable_quote_sb = get_course_term_meta( $term->term_id, '_disable_quotes_sb', true );
		$image			 = '';
		$thumbnail_id	 = absint( get_course_term_meta( $term->term_id, '_featured_image_id', true ) );
		if ( $thumbnail_id )
			$image			 = wp_get_attachment_thumb_url( $thumbnail_id );
		else
			$image			 = get_stylesheet_directory_uri() . '/images/placeholder.png';
		?>
		<tr class="form-field">
			<th scope="row" valign="top"><label><?php _e( 'Disable Qoutes Sidebar', self::$text_domain ); ?></label></th>
			<td>
				<div id="course_cate_description">
					<input class="widefat" type="checkbox" name="cc_dis_quote_sb" value="1" <?php checked($disable_quote_sb, 'yes', true);?>/>
				</div>
				<p class="description">To hide quotes sidebar.</p>
		</tr>
		<tr class="form-field">
			<th scope="row" valign="top"><label><?php _e( 'Featured Text Title', self::$text_domain ); ?></label></th>
			<td>
				<div id="course_cate_description">
					<input class="widefat" type="text" name="cc_title" value="<?php echo esc_attr( $title ); ?>"/>
				</div>
				<p class="description">This title will be shown the title on single category page.</p>
		</tr>
		<tr class="form-field">
			<th scope="row" valign="top"><label><?php _e( 'Featured Text', self::$text_domain ); ?></label></th>
			<td>
				<div id="course_cate_description">
					<?php
					wp_editor( $description, 'coursecatdescription', array(
						'media_buttons'	 => false,
						'textarea_rows'	 => 6,
						'teeny'			 => true
					) );
					?>
				</div>
				<p class="description">This text will be shown bellow the title and above the course list on single category page.</p>
			</td>
		</tr>
		<tr class="form-field">
			<th scope="row" valign="top"><label><?php _e( 'Featured Image', self::$text_domain ); ?></label></th>
			<td>
				<div id="course_cat_featured_image" style="float:left;margin-right:10px;"><img src="<?php echo $image; ?>" width="60px" height="60px" /></div>
				<div style="line-height:60px;">
					<input type="hidden" id="course_cat_featured_image_id" name="_featured_image_id" value="<?php echo $thumbnail_id; ?>" />
					<button type="submit" class="course-cat-ubutton button"><?php _e( 'Upload/Add image', self::$text_domain ); ?></button>
					<button type="submit" class="course-cat-rbutton button"><?php _e( 'Remove image', self::$text_domain ); ?></button>
				</div>
				<script type="text/javascript">

					// Uploading files
					var file_frame;

					jQuery(document).on('click', '.course-cat-ubutton', function (event) {

						event.preventDefault();

						// If the media frame already exists, reopen it.
						if (file_frame) {
							file_frame.open();
							return;
						}

						// Create the media frame.
						file_frame = wp.media.frames.downloadable_file = wp.media({
							title: '<?php _e( 'Choose an image', self::$text_domain ); ?>',
							button: {
								text: '<?php _e( 'Use image', self::$text_domain ); ?>',
							},
							multiple: false
						});

						// When an image is selected, run a callback.
						file_frame.on('select', function () {
							attachment = file_frame.state().get('selection').first().toJSON();

							jQuery('#course_cat_featured_image_id').val(attachment.id);
							jQuery('#course_cat_featured_image img').attr('src', attachment.url);
							jQuery('.course-cat-rbutton').show();
						});

						// Finally, open the modal.
						file_frame.open();
					});

					jQuery(document).on('click', '.course-cat-rbutton', function (event) {
						jQuery('#course_cat_featured_image img').attr('src', '<?php echo get_stylesheet_directory_uri() . '/images/placeholder.png'; ?>');
						jQuery('#course_cat_featured_image_id').val('');
						jQuery('.winter-thumb-rbutton').hide();
						return false;
					});

				</script>
				<div class="clear"></div>
			</td>
		</tr>
		<?php
	}

	public function save_course_category_fields( $term_id, $tt_id, $taxonomy ) {
		if ( isset( $_POST['_featured_image_id'] ) ) {
			update_course_termmeta( $term_id, '_featured_image_id', absint( $_POST['_featured_image_id'] ) );
		} else {
			delete_course_term_meta( $term_id, '_featured_image_id' );
		}
		if ( !empty( $_POST['cc_dis_quote_sb'] ) ) {
			update_course_termmeta( $term_id, '_disable_quotes_sb', 'yes' );
		} else {
			delete_course_term_meta( $term_id, '_disable_quotes_sb' );
		}

		if ( isset( $_POST['cc_title'] ) ) {
			update_course_termmeta( $term_id, '_title', $_POST['cc_title'] );
		} else {
			delete_course_term_meta( $term_id, '_title' );
		}

		if ( isset( $_POST['coursecatdescription'] ) ) {
			update_course_termmeta( $term_id, '_description', $_POST['coursecatdescription'] );
		} else {
			delete_course_term_meta( $term_id, '_description' );
		}
	}

	public function admin_assets() {
		$curent_screen = get_current_screen();
		if ( in_array( $curent_screen->id, array('course_category') ) ) {
			wp_enqueue_media();
		} elseif ( isset( $curent_screen->post_type ) && ($curent_screen->post_type == self::$post_type) ) {
			if ( function_exists( 'wp_enqueue_media' ) ) {
				wp_enqueue_media();
			} else {
				wp_enqueue_style( 'thickbox' );
				wp_enqueue_script( 'media-upload' );
				wp_enqueue_script( 'thickbox' );
			}

			wp_enqueue_style( 'tts-admin-css', self::$css . '/admin.css' );
			wp_enqueue_script( 'jquery' );
			wp_enqueue_script( 'jquery-ui-sortable', array('jquery') );
			wp_enqueue_script( 'tts-admin-js', self::$js . '/admin.js', array('jquery', 'jquery-ui-sortable') );

			$s_data			 = array();
			$s_data['url']	 = admin_url( '/admin-ajax.php' );
			wp_localize_script( 'tts-admin-js', TTS_SC_DATA, $s_data );
		}
	}

	public function assets() {

		if ( is_singular( self::$post_type ) ) {
			wp_enqueue_script( 'jquery' );
			wp_enqueue_script( 'tipped', self::$js . '/tipped.min.js', array('jquery') );
			wp_enqueue_script( 'tts-course-js', self::$js . '/frontend.js', array('jquery', 'tipped') );
			wp_enqueue_style( 'tipped', self::$css . '/tipped.css' );
		}
	}

	public function course_fields() {
		add_meta_box( self::$post_type . '-fields', self::$singular . ' Fields', array($this, 'course_fields_generator'), self::$post_type, 'normal', 'high' );
	}

	public function course_fields_generator( $post ) {
		wp_nonce_field( 'save_cfg_for' . $post->ID, '_cfgnonce' );
		$this->do_fields_html( $post->ID );
	}

	public function do_fields_html( $post_id ) {
		TTS_Course_Fields::do_meta_fields( $post_id );
	}

	public function save_fields( $post_id ) {
		if ( !isset( $_POST['_cfgnonce'] ) ) {
			return;
		}
		if ( !wp_verify_nonce( $_POST['_cfgnonce'], 'save_cfg_for' . $post_id ) ) {
			return;
		}
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return;
		}
		if ( !current_user_can( 'edit_post', $post_id ) ) {
			return;
		}

		$fields = tts_course_fields($post_id);
		foreach ( $fields as $meta_key => $label ) {
			if ( isset( $_POST[$meta_key] ) ) {
				if ( method_exists( 'TTS_Course_Fields', 'save_' . $meta_key ) ) {
					call_user_func( array("TTS_Course_Fields", 'save_' . $meta_key), $meta_key, $_POST[$meta_key], $post_id );
				} else {
					update_post_meta( $post_id, $meta_key, $_POST[$meta_key] );
				}
			} else {
				delete_post_meta( $post_id, $meta_key );
			}
		}
	}

	public function training_course_submenu() {
		add_filter( 'wp_nav_menu_objects', array($this, 'add_course_menu'), 10, 2 );
	}

	public function add_course_menu( $items, $args = array() ) {

		if ( $args->theme_location != 'primary' ) {
			return $items;
		}
		global $wpdb;
		$maxPost			 = $wpdb->get_row( "SELECT MAX(ID) as max_id FROM " . $wpdb->posts );
		$this->menuItemId	 = $maxPost->max_id;
		$this->menu_items	 = $items;

		$course_page = 248;
		foreach ( $items as $item ) {
			if ( $item->object_id == $course_page ) {
				$this->add_course_menu_items( $item );
			}
		}
		return $this->menu_items;
	}

	public function add_course_menu_items( &$item ) {
		$categories	 = '';
		$categories	 = get_terms( 'course_category', array(
			'orderby'	 => 'id',
			'order'		 => 'ASC',
			'hide_empty' => false,
			'fields'	 => 'id=>name',
				) );
		$catNum		 = 0;
		foreach ( $categories as $course_cat_id => $course_cat_name ) {

			$categoryItem		 = $this->add_menu_item(
					$item, $course_cat_id, $course_cat_name, get_term_link( $course_cat_id, 'course_category' ), ++$catNum, is_tax( 'course_category', $course_cat_id ), 'current-course-category-item'
			);
			$category_courses	 = get_posts( array(
				'posts_per_page' => -1,
				'post_type'		 => 'courses',
				'orderby'		 => 'id',
				'order'			 => 'DESC',
				'tax_query'		 => array(
					array(
						'taxonomy'	 => 'course_category',
						'field'		 => 'id',
						'terms'		 => array($course_cat_id)
					)
				)
					) );
			$courseNum			 = 0;
			foreach ( $category_courses as $course ) {
				$courseItem = $this->add_menu_item(
						$categoryItem, $course->ID, get_the_title( $course ), get_permalink( $course->ID ), ++$courseNum, is_single( $course->ID ), 'current-course-item'
				);
			}
		}
		return $this->menu_items;
	}

	protected function add_menu_item( &$parent, $id, $title, $url, $num = 1, $current = false, $extra_class = "" ) {
		//  Increment the menu item ID
		++$this->menuItemId;

		//  First, create a template submenu item
		$item						 = new stdClass();
		$item->post_status			 = $parent->post_status;
		$item->post_type			 = $parent->post_type;
		$item->menu_item_parent		 = $parent->ID;
		$item->filter				 = $parent->filter;
		$item->type_label			 = $parent->type_label;
		$item->object				 = $parent->object;
		$item->target				 = $parent->target;
		$item->attr_title			 = '';
		$item->current_item_ancestor = false;
		$item->current_item_parent	 = false;

		//  Set the item classes
		$classes = $parent->classes;
		if ( $extra_class ) {
			array_push( $classes, $extra_class );
		}
		if ( $current ) {
			array_push( $classes, 'current-menu-item' );
		}
		$item->classes = $classes;

		//  Add subcategory specific attributes
		$item->ID			 = $this->menuItemId;
		$item->post_name	 = $this->menuItemId;
		$item->guid			 = $url;
		$item->menu_order	 = $num;
		$item->db_id		 = $this->menuItemId;
		$item->object_id	 = $this->menuItemId;
		$item->url			 = $url;
		$item->title		 = $title;
		$item->current		 = $current;

		//  Add the subcategory item to the submenu
		array_push( $this->menu_items, $item );

		return $item;
	}

	public function load_template( $template ) {
		if ( is_tax() ) {
			$template = self::$path . '/templates/category.php';
		} elseif ( is_singular( self::$post_type ) ) {
                    $course_template = get_post_meta(get_the_ID(), 'course_template', true);
                    if(!$course_template){
                        $course_settings = get_option('tts_course_settings');
                        $course_template = isset($course_settings['course_template'])?$course_settings['course_template']:'';
                    }
                    if( 'new' == $course_template ){
                        $template = self::$path . '/templates/single-new.php';
                    }else{
			$template = self::$path . '/templates/single.php';
                    }
		}
		return $template;
	}

	public function tts_courses( $atts, $content = "" ) {
		$courses = get_posts( array(
			'post_type'		 => self::$post_type,
			'numberposts'	 => -1,
				) );
		if ( empty( $courses ) ) {
			return '';
		}
		ob_start();
		echo '<div class="tts-course-list">';
		foreach ( $courses as $course ) {
			$the_course = new TTS_Course( $course->ID );
			include self::$path . '/templates/loop.php';
		}
		echo '</div>';
		return ob_get_clean();
	}
        
        function sc_row($atts, $content = "") {
            $atts = shortcode_atts(array(
                'id' => '',
                'classes' => '',
            ), $atts, 'tts_row');

            extract($atts);
            ob_start();
            include self::$path . '/templates/sc-row.php';
            return ob_get_clean();
        }
        /**
         * Sortcode for tts_col
         * 
         */

        function tts_col($atts, $content = "") {
            $atts = shortcode_atts(array(
                'classes' => '',
                'size' => '1/2',
                'last' => 'no',
            ), $atts, 'tts_col');

            extract($atts);
            ob_start();
            include self::$path . '/templates/sc-col.php';
            return ob_get_clean();
        }

	/**
	 * Change Posts Per Page for course category archive
	 * 
	 * @param object $query data
	 *
	 */
	public function category_posts_per_page( $query ) {
		if ( $query->is_main_query() && !is_admin() && is_archive( 'course_category' ) ) {
			$query->set( 'posts_per_page', 12 );
		}
	}

	public function tts_courses_category_boxes( $atts, $content = "" ) {
		$atts = shortcode_atts( array('top_listed' => '', 'exclude' => ''), $atts, 'tts_courses_category_boxes' );
		if ( $atts['top_listed'] ) {
			$atts['top_listed'] = explode( ',', $atts['top_listed'] );
		}
        if($atts['exclude']){
            $exclude = explode(',', $atts['exclude']);
        }
        $excluded_cats = array();
        foreach($exclude as $exc){
            $excluded_cats[] = trim($exc);
        }
        

		$args		 = array(
			'orderby'	 => 'id',
			'order'		 => 'ASC',
			'hide_empty' => false,
			//'exclude'	 => array(),
			//'exclude_tree'      => array(), 
			//'include'           => array(),
			//'number'            => '', 
			'fields'	 => 'id=>name',
			'slug'		 => '',
			'parent'	 => 0
		);
		$top_listed	 = array();
		if ( is_array( $atts['top_listed'] ) && count( $atts['top_listed'] ) > 0 ) {
			$excluded_cats = array_merge($excluded_cats, $atts['top_listed']);
			foreach ( $atts['top_listed'] as $tlc_id ) {
				$tlc_id	 = (int) trim( $tlc_id );
				$tlc_cat = get_term( $tlc_id, 'course_category', OBJECT, 'raw' );
				if ( !$tlc_cat && is_wp_error( $tlc_cat ) ) {
					continue;
				}
				$top_listed[$tlc_id] = $tlc_cat->name;
			}
		}
        if(count($excluded_cats) > 0){
            $args['exclude'] = $excluded_cats;
        }
        

		$course_cats = get_terms( 'course_category', $args );

		if ( !$course_cats || is_wp_error( $course_cats ) ) {
			return '';
		}

		ob_start();
		echo '<div class="course-box-row clearfix">';
		foreach ( $top_listed as $course_cat_id => $course_cat_name ) {
			include self::$path . '/templates/category-box.php';
		}
		foreach ( $course_cats as $course_cat_id => $course_cat_name ) {
			include self::$path . '/templates/category-box.php';
		}
		echo '</div>';
		return ob_get_clean();
	}

	public function add_settings_page() {
		add_submenu_page(
				'edit.php?post_type='.self::$post_type,
				'Course Settings', 
				'Course Settings', 
				'manage_options', 
				'course-settings', 
				array($this, 'render_settings_page')
		);
	}
	public function render_settings_page(){
		$course_settings = get_option('tts_course_settings');
		$course_page_nottice = isset($course_settings['course_page_nottice'])?$course_settings['course_page_nottice']:'';
		$course_date_page_text = isset($course_settings['course_date_page_text'])?$course_settings['course_date_page_text']:'';
		$course_template = isset($course_settings['course_template'])?$course_settings['course_template']:'';
		?>
		<div class="wrap">
			<h1>Course Settings</h1>
			<?php 
			if(  is_array($this->messages) ){
				foreach($this->messages as $message){
					echo $message;
				}
			}
			?>
			<form novalidate="novalidate" action="" method="post">
				<input type="hidden" value="1" name="tts_course_settings">
				<?php wp_nonce_field('save_course_settings', '_ttscsnonce'); ?>
				<table class="form-table">
					<tr>
						<th scope="row"><label for="ttscoursepagenotice">Course Page Notice</label></th>
						<td>
							<?php
							wp_editor( $course_page_nottice, 'ttscoursepagenotice', array(
								'wpautop'		 => true,
								'media_buttons'	 => false,
								'textarea_name'	 => 'tts_course_page_nottice',
								'textarea_rows'	 => 5,
								'teeny'			 => true
							) );
							?>
							
						</td>
					</tr>
					<tr>
						<th scope="row"><label for="ttscoursedatepagetext">Course Date Page Text</label></th>
						<td>
							<?php
							wp_editor( $course_date_page_text, 'ttscoursedatepagetext', array(
								'wpautop'		 => true,
								'media_buttons'	 => false,
								'textarea_name'	 => 'course_date_page_text',
								'textarea_rows'	 => 5,
								'teeny'			 => true
							) );
							?>
							
						</td>
					</tr>
					<tr>
						<th scope="row"><label for="tts-course-template">Course Template</label></th>
						<td>
                                                    <select id="tts-course_template" name="tts_course_template">
                                                        <option value="old">Template 1</option>
                                                        <option value="new" <?php selected($course_template, 'new', true); ?> >Template 2</option>
                                                    </select>
						</td>
					</tr>
				</table>
				<p class="submit">
					<?php submit_button(); ?>
				</p>
			</form>
		</div>
		<?php
	}
	
	public function save_settings(){
		if(empty($_POST['tts_course_settings'])){
			return;
		}
		if(empty($_POST['_ttscsnonce']) || !wp_verify_nonce($_POST['_ttscsnonce'], 'save_course_settings')){
			return;
		}
		$settings = array();
		if(isset($_POST['tts_course_page_nottice'])){
			$settings['course_page_nottice'] = wp_unslash($_POST['tts_course_page_nottice']);
		}
		if(isset($_POST['course_date_page_text'])){
			$settings['course_date_page_text'] = wp_unslash($_POST['course_date_page_text']);
		}
		if(isset($_POST['tts_course_template'])){
			$settings['course_template'] = wp_unslash($_POST['tts_course_template']);
		}
		update_option('tts_course_settings', $settings);
		$this->messages[] = '<div class="updated notice is-dismissible"><p>Settings saved.</p><button class="notice-dismiss" type="button"><span class="screen-reader-text">Dismiss this notice.</span></button></div>';
		
	}

}

TTS_Courses::get_instance();
