<?php
/*
Template Name: Courese 
*/

get_header(); ?>
<?php
$course_settings = get_option('tbs_settings');
$course_date_page_text = isset($course_settings['course_date_page_text'])?$course_settings['course_date_page_text']:'';

?>
<main>
	<div class="center">
        <div class="col col1">
            <?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>

                    <div id="post-<?php the_ID(); ?>" <?php post_class('tts-course-dates-container'); ?>>
                            <div class="entry-title"><?php the_title(); ?></div>
                            <div class="tts-booking-help clearfix">
                                <div class="ttsbh-left" style="float:none;width: auto;marign-bottom: 15px;">
                                    <?php if($course_date_page_text){ ?>
                                    <?php echo do_shortcode($course_date_page_text); ?>
                                    <?php } ?> 
                                </div>
                            </div>
                            <div class="entry-content">
                                <?php
                                if(!empty($_GET['tt_course_code'])){
                                    
                                    $sc = '[administrate_event_table_1 show_prices="true" show_codes="false" num_months="12" course="'.$_GET['tt_course_code'].'"]';
                                }else{
                                    $sc = '[administrate_event_table_1 show_prices="true" show_codes="false" num_months="12"]';
                                }
                                echo do_shortcode($sc);
                                ?>
                            </div><!-- .entry-content -->
                    </div><!-- #post-## -->

            <?php endwhile; // end of the loop. ?>
        </div>
        <div class="clear"></div>
    </div>
</main>

<?php get_footer(); ?>