<?php
/**
 * Course Term Meta API - Update term meta
 *
 * @param mixed $term_id
 * @param string $meta_key
 * @param mixed $meta_value
 * @param string $prev_value (default: '')
 * @return bool
 */
function update_course_termmeta( $term_id, $meta_key, $meta_value, $prev_value = '' ) {
	return update_metadata( 'course_term', $term_id, $meta_key, $meta_value, $prev_value );
}

/**
 * Course Term Meta API - Add term meta
 *
 * @param mixed $term_id
 * @param mixed $meta_key
 * @param mixed $meta_value
 * @param bool $unique (default: false)
 * @return bool
 */
function add_woocommerce_term_meta( $term_id, $meta_key, $meta_value, $unique = false ){
	return add_metadata( 'course_term', $term_id, $meta_key, $meta_value, $unique );
}

/**
 * Course Term Meta API - Delete term meta
 *
 * @param mixed $term_id
 * @param mixed $meta_key
 * @param string $meta_value (default: '')
 * @param bool $delete_all (default: false)
 * @return bool
 */
function delete_course_term_meta( $term_id, $meta_key, $meta_value = '', $delete_all = false ) {
	return delete_metadata( 'course_term', $term_id, $meta_key, $meta_value, $delete_all );
}

/**
 * Course Term Meta API - Get term meta
 *
 * @param mixed $term_id
 * @param string $key
 * @param bool $single (default: true)
 * @return mixed
 */
function get_course_term_meta( $term_id, $key, $single = true ) {
	return get_metadata( 'course_term', $term_id, $key, $single );
}


function get_adminstrate_courses($params = array()){
    $courses = array();
    if(!class_exists('Administrate')){return $courses;}
    $courses = Administrate::api()->get_course_list( $params);
    
    ksort($courses);
    return $courses;
}

function get_linked_course($course_code=''){
    if(!$course_code){return false;}
    $post = get_posts(array(
        'post_type' => 'courses',
        'meta_key'     => 'training_administrate_course',
	'meta_value'   => $course_code,
    ));
    if($post){
        return array_shift($post);
    }
    return false;
}