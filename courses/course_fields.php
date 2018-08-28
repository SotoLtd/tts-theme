<?php

function tts_course_fields($post_id = false) {
    $course_template = '';
    if($post_id){
        $course_template = get_post_meta($post_id, 'course_template', true);
    }
    if(!$course_template){
        $course_settings = get_option('tts_course_settings');
        $course_template = isset($course_settings['course_template'])?$course_settings['course_template']:'';
    }
    if( 'new' == $course_template ){
       $fields = array(
            'course_template' => 'Template',
            'training_administrate_course' => 'Link to Administrate Course',
            'training_hide_events_table' => 'Hide Administrate Events Table',
            // Sidebar data
            'price' => 'Price',
            'price_includes' => 'Price Includes',
            'location' => 'Location',
            'duration' => 'Duration',
            'delegates' => 'Delegates',
            'certification_logo' => 'Certification Logo',
            'certification_text' => 'Certification Text',
            // Main Content
            'who_needs_to_do_text' => 'Who needs to do this course text',
            'trainer' => 'Trainer',
            'offer' => 'Offer',
            'cbenefits' => 'Benefits',
            'testimonials' => 'Testimonials',
            'faqs' => 'FAQs',
            'terms_condition' => 'Terms &amp; Conditions',

        ); 
    }else{
        $fields = array(
            //'accreditation_logos'   => 'Accreditation Logos',
            'course_template' => 'Template',
            'person_graphic_1'					 => 'Person Graphic 1',
            'quote'								 => 'Quote',
            'stickers'							 => 'Stickers',
            'short_description'					 => 'Short Description',
            'person_graphic_2'					 => 'Person Graphic 2',
            'who_needs_to_do_text'				 => 'Who needs to do this course text',
            'benefits'							 => 'Benefits',
            'right_hand_long_graphic'			 => 'Right Hand Long Graphic',
            'available_at_training_centre'		 => 'Available at Training Centre',
            'trianing_center_map_graphic'		 => 'Training Center Map Graphic',
            'training_administrate_course'		 => 'Link to Administrate Course',
            'training_hide_book_button'			 => 'Hide "View Dates &amp; Book Now" Button',
            'training_hide_events_table'		 => 'Hide Administrate Events Table',
            'training_center_administrate_link'	 => 'Training Administrate Link',
            'available_training_centers'		 => 'Available Training Centres',
            'available_at_customer_site'		 => 'Available at Customer Site',
            'customer_site_map_graphic'			 => 'Customer Site Map Graphic',
            'customer_site_instruction'			 => 'Customer Site Instruction',
            'testimonials'						 => 'Testimonials'
        );
    }
    return $fields;
}

function tts_get_acc_logos() {

    $logos = array(
        'logo1' => array('label' => 'Logo 1', 'logo' => get_stylesheet_directory_uri() . '/images/course/logo1.png'),
        'logo2' => array('label' => 'Logo 2', 'logo' => get_stylesheet_directory_uri() . '/images/course/logo2.png'),
        'logo3' => array('label' => 'Logo 2', 'logo' => get_stylesheet_directory_uri() . '/images/course/logo3.png'),
    );

    return $logos;
}

function tts_get_persons_graphics1() {
    $persons = array(
        'alan' => array('label' => 'Alan', 'logo' => get_stylesheet_directory_uri() . '/images/course/person-alan.png'),
        'dave' => array('label' => 'Dave', 'logo' => get_stylesheet_directory_uri() . '/images/course/person-dave.png'),
    );

    return $persons;
}

function tts_get_persons_graphics2() {
    return tts_get_persons_graphics1();
}

function tts_get_stikers() {

    $stikers = array(
        'sticker_certificate' => array(
            'label' => 'Ceritificate',
            'logo' => get_stylesheet_directory_uri() . '/images/course/sticker-certificate.png',
            'info' => 'Cirficate Hover Text'
        ),
        'sticker_duration-1d' => array(
            'label' => 'One Day Duration',
            'logo' => get_stylesheet_directory_uri() . '/images/course/sticker-duration-1d.png',
            'info' => 'One day dureation'
        ),
        'sticker_price_175' => array(
            'label' => 'Price - $175',
            'logo' => get_stylesheet_directory_uri() . '/images/course/sticker-price-175.png',
            'info' => '$175 with vat'
        ),
        'sticker_delegates_1_12' => array(
            'label' => 'Delegates 1min-12max',
            'logo' => get_stylesheet_directory_uri() . '/images/course/sticker-delegates-1-12.png',
            'info' => '1 min 12 Max delegates.'
        ),
    );

    return $stikers;
}

function tts_array_ksort_merge($main_array, $key_array) {
    if (empty($key_array)) {
        return $main_array;
    }
    $sorted_arrray = array();
    foreach ($key_array as $k) {
        if (isset($main_array[$k])) {
            $sorted_arrray[$k] = $main_array[$k];
            unset($main_array[$k]);
        }
    }
    return array_merge($sorted_arrray, $main_array);
}

function tts_check_stickers_array($stikers = array(), $save = false) {
    if (empty($stikers) || !is_array($stikers)) {
        if ($save)
            return '';
        return array(
            0 => array('normal' => '', 'hover' => '')
        );
    }
    $checked_sticker = array();
    $k = 0;
    foreach ($stikers as $st) {
        if (!is_array($st) || empty($st['normal']) || empty($st['hover'])) {
            continue;
        }
        $checked_sticker[$k]['normal'] = $st['normal'];
        $checked_sticker[$k]['hover'] = $st['hover'];
        $k++;
    }
    return $checked_sticker;
}

function tts_get_course_locations() {
    return array(
        "Aberdeen",
        "Aintree (Liverpool)",
        "Birmingham",
        "Bracknell",
        "Caldicot (South Wales)",
        "Cambridge",
        "Canning Town",
        "Cardiff",
        "Chelmsford",
        "Coatbridge (Glasgow)",
        "Con Hill",
        "Derby",
        "Doncaster",
        "Durham",
        "Edinburgh",
        "Essex",
        "Exeter",
        "Gatwick",
        "Gatwick (London)",
        "Glasgow",
        "Hull",
        "Kent",
        "Leeds",
        "Leicester",
        "Lincoln",
        "Liskeard",
        "Liverpool",
        "London",
        "London East",
        "London – East Thurrock",
        "London – Purfleet ",
        "London – Uxbridge ",
        "Luton",
        "Manchester",
        "Manchester Norwich",
        "Middlesbrough",
        "Milton Keynes",
        "Newcastle",
        "North Wales (Deeside) Peterborough",
        "Norwich",
        "Nottingham",
        "Nottingham (Newstead)",
        "Penzance",
        "Plymouth",
        "Portsmouth",
        "Rainham",
        "Reading",
        "Ringwood",
        "Roche (Cornwall)",
        "Salford",
        "Sheffield",
        "Southampton",
        "St Albans",
        "Swansea",
        "Swindon",
        "Taunton",
        "Uxbridge",
        "Walsall",
        "Warrington",
        "Wembley",
        "Weston",
        "Wimborne",
        "Worcester",
        "York"
    );
}
