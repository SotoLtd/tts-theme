<?php
dynamic_sidebar('right-sidebar');

$disabled_qsb = '';
if(is_page() || is_archive('course_category')){
    
    if(is_page()){
        $disabled_qsb = get_post_meta(get_the_ID(), 'tts_disable_quotes_sb', true);
    }
    if(is_archive('course_category')){
        $course_cat = get_queried_object();
        $disabled_qsb = get_term_meta( $course_cat->term_id, '_disable_quotes_sb', true );
    }
    
}
if(!$disabled_qsb) {
    dynamic_sidebar('quotes-sidebar');
}