<?php

class TTS_Course {

	public $id;
	public $accreditation_logos;
	public $person_graphic_1;
	public $quote;
	public $stickers;
	public $short_description;
	public $person_graphic_2;
	public $benefits;
	public $right_hand_long_graphic;
	public $available_at_training_centre;
	public $trianing_center_map_graphic;
	public $training_center_administrate_link;
	public $available_at_customer_site;
	public $customer_site_map_graphic;
	public $customer_site_instruction;
	public $linked_course_code;
	public $training_hide_book_button;
	public $training_hide_events_table;
        
        public $price;
        public $price_includes;
        public $location;
        public $duration;
        public $delegates;
        public $certification_logo;
        public $certification_text;
	public $who_needs_to_do_text;
        public $trainer;
        public $offer;
        public $cbenefits;
	public $testimonials;
        public $terms_condition;
        public $faqs;
        
        public $loc_britol = false;

        public function __construct( $post_id ) {
		$course									 = get_post( $post_id );
		$this->id								 = $post_id;
		$this->accreditation_logos				 = $this->accreditation_logos();
		$this->person_graphic_1					 = $this->person_graphic_1();
		$this->person_graphic_2					 = $this->person_graphic_2();
		$this->quote							 = get_post_meta( $post_id, 'quote', true );
		$this->stickers							 = $this->stickers();
		$this->short_description				 = get_post_meta( $post_id, 'short_description', true );
		$this->content							 = apply_filters( 'the_content', $course->post_content );
		$this->benefits							 = get_post_meta( $post_id, 'benefits', true );
		$this->right_hand_long_graphic			 = get_post_meta( $post_id, 'right_hand_long_graphic', true );
		$this->available_at_training_centre		 = (bool) get_post_meta( $post_id, 'available_at_training_centre', true );
		$this->trianing_center_map_graphic		 = get_post_meta( $post_id, 'trianing_center_map_graphic', true );
		$this->training_center_administrate_link = get_post_meta( $post_id, 'training_center_administrate_link', true );
		$this->available_training_centers		 = $this->available_training_centers();
		$this->available_at_customer_site		 = (bool) get_post_meta( $post_id, 'available_at_customer_site', true );
		$this->customer_site_map_graphic		 = get_post_meta( $post_id, 'customer_site_map_graphic', true );
		$this->customer_site_instruction		 = get_post_meta( $post_id, 'customer_site_instruction', true );
		$this->excerpt							 = $course->post_excerpt;
		$this->training_hide_book_button		 = (bool) get_post_meta( $post_id, 'training_hide_book_button', true );
                
                
		$this->linked_course_code = get_post_meta( $post_id, 'training_administrate_course', true );
		$this->training_hide_events_table = (bool) get_post_meta( $post_id, 'training_hide_events_table', true );
                $this->price = get_post_meta( $post_id, 'price', true );
                $this->price_includes = $this->price_includes();
                $this->location = $this->location();
                $this->duration = get_post_meta( $post_id, 'duration', true );
                $this->delegates = get_post_meta( $post_id, 'delegates', true );
                $this->certification_logo = get_post_meta( $post_id, 'certification_logo', true );
                $this->certification_text = get_post_meta( $post_id, 'certification_text', true );
                $this->trainer = $this->trainer();
		$this->who_needs_to_do_text = get_post_meta( $post_id, 'who_needs_to_do_text', true );
                $this->offer = get_post_meta( $post_id, 'offer', true );
                $this->cbenefits = $this->cbenefits();
		$this->testimonials = $this->testimonials();
                $this->faqs = $this->faqs();
                $this->terms_condition = get_post_meta( $post_id, 'terms_condition', true );
	}
        
        public function price_includes(){
            $price_includes = get_post_meta( $this->id, 'price_includes', true );
            $price_includes = trim($price_includes);
            if(!$price_includes){
                return '';
            }
            $price_includes = explode("\n", $price_includes);
            if(!$price_includes){
                return '';
            }
            $incs = '';
            foreach($price_includes as $prci){
                if(!trim($prci)){
                    continue;
                }
                $incs .= "<li>{$prci}</li>";
            }
            if($incs){
                $incs = '<ul class="no-bullet">'. $incs .'</ul>';
            }
            return $incs;
        }
        
        public function location(){
            $location = get_post_meta( $this->id, 'location', true );
            if(!$location && !is_array($location)){
                return '';
            }
            $locs = array();
            foreach($location as $lc){
                if('bristol' == $lc){
                    $this->loc_britol = true;
                }
                $locs[] = $lc;
            }
            return $locs;
        }
        
        public function trainer(){
            $trainer = get_post_meta( $this->id, 'trainer', true );
            if(!$trainer){
                return false;
            }
            $trainer_post = get_post($trainer);
            if(!$trainer_post || is_wp_error($trainer_post)){
                return false;
            }
            $tobj = new stdClass();
            $tobj->ID = $trainer_post->ID;
            $tobj->name = $trainer_post->post_title;
            $tobj->bio = $trainer_post->post_content;
            if(has_post_thumbnail($trainer_post)){
                $post_thumbnail_id = get_post_thumbnail_id($trainer_post);
                $tobj->photo = wp_get_attachment_image( $post_thumbnail_id, 'full', false );
            }else{
                $tobj->photo = '';
            }
            return $tobj;
        }

	public function accreditation_logos() {
		$logos = get_post_meta( $this->id, 'accreditation_logos', true );
		if ( empty( $logos ) ) {
			return array();
		}
		$r			 = array();
		$acc_logos	 = tts_get_acc_logos();
		foreach ( $logos as $key => $value ) {
			if ( isset( $acc_logos[$value] ) ) {
				$r[] = $acc_logos[$value]['logo'];
			}
		}

		return $r;
	}

	public function person_graphic_1() {
		$persons = get_post_meta( $this->id, 'person_graphic_1', true );
		if ( empty( $persons ) ) {
			return array();
		}
		$r	 = array();
		$dps = tts_get_persons_graphics1();
		foreach ( $persons as $key => $value ) {
			if ( isset( $dps[$value] ) ) {
				$r[] = $dps[$value]['logo'];
			}
		}

		return $r;
	}

	public function person_graphic_2() {
		$persons = get_post_meta( $this->id, 'person_graphic_2', true );
		if ( empty( $persons ) ) {
			return array();
		}
		$r	 = array();
		$dps = tts_get_persons_graphics2();
		foreach ( $persons as $key => $value ) {
			if ( isset( $dps[$value] ) ) {
				$r[] = $dps[$value]['logo'];
			}
		}

		return $r;
	}

	public function short_description() {
		echo wpautop( $this->short_description );
	}

	public function who_needs_to_do_text() {
		echo wpautop( $this->who_needs_to_do_text );
	}

	public function benefits() {
		echo wpautop( $this->benefits );
	}

	public function stickers() {
		$stickers	 = get_post_meta( $this->id, 'stickers', true );
		$stickers	 = tts_check_stickers_array( $stickers );
		return $stickers;
	}

	public function available_training_centers() {
		$locations = get_post_meta( $this->id, 'available_training_centers', true );
		if ( !$locations || !is_array( $locations ) ) {
			return array();
		}
		return $locations;
	}
        public function cbenefits(){
            $meta_value = get_post_meta( $this->id, 'cbenefits', true );
            if ( empty( $meta_value ) ) {
                    $meta_value = array();
            } else {
                    $meta_value = array_values( $meta_value );
            }

            return $meta_value;
        }
	public function testimonials() {
		$meta_value = get_post_meta( $this->id, 'testimonials', true );
		if ( empty( $meta_value ) ) {
			$meta_value = array();
		} else {
			$meta_value = array_values( $meta_value );
		}

		return $meta_value;
	}

        public function faqs(){
            $meta_value = get_post_meta( $this->id, 'faqs', true );
            if ( empty( $meta_value ) ) {
                    $meta_value = array();
            } else {
                    $meta_value = array_values( $meta_value );
            }
            if(!is_array($meta_value)){
                return array();
            }
            $faqs = array();
            foreach($meta_value as $f){
                if(empty($f['q'])){
                    continue;
                }
                $faqs[] = $f;
            }
            return $faqs;
        }
	public function adminstrate_linked_courese() {
		if ( !$this->linked_course_code ) {
			return false;
		}
		$cc = $this->linked_course_code;
	}

}
