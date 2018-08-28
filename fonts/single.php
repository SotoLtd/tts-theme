<?php
get_header(); 
?>

<main>
    <div class="center">
        <div id="tts-showcase-wrap" class="col col1">
            <?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
            <?php
            $the_course = new TTS_Course(get_the_ID());
            ?>
            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                <div class="showcase-row">
                    <div class="showcase-col showcase-col3">
                        <div class="showcase-title"><h1><?php the_title(); ?></h1></div>
                        <div class="showcase-accrediation-logos">
                            <img alt="" src="<?php echo get_stylesheet_directory_uri() ?>/images/course/by-training-logo.png" />
                            <?php
                            foreach($the_course->accreditation_logos as $accl){
                                echo '<img alt="" src="'. $accl .'" />';
                            }
                            unset($accl);
                            ?>
                        </div>
                        <div class="showcase-qoute"><?php echo $the_course->quote; ?></div>
                    </div>
                    <div class="showcase-col showcase-col1">
                        <?php
                        foreach($the_course->person_graphic_1 as $pg1){
                            echo '<img alt="" src="'. $pg1 .'" />';
                        }
                        unset($pg1);
                        ?>
                    </div>
                </div>
                <div class="showcase-row">
                    <div class="showcase-col showcase-colfull">
                        <div class="showcase-stickers">
                            <img alt="" src="<?php echo get_stylesheet_directory_uri() ?>/images/course/by-training-logo.png" />
                            <?php
                            foreach($the_course->stickers as $stiker){
                                ?>
                                <div class="showcase-stiker">
                                    <img alt="<?php $stiker['label'] ?>" src="<?php $stiker['logo'] ?>" />
                                    <p style="display:none;"><?php $stiker['info'] ?></p>
                                </div>
                                <?php
                            }
                            unset($accl);
                            ?>
                        </div>
                    </div>
                </div>
            </article><!-- #post-## -->

            <?php endwhile; // end of the loop. ?>
        </div>
        <div class="col col2">
            <?php get_sidebar('right'); ?>
        </div>
        <div class="clear"></div>
    </div>
</main>

<?php get_footer(); ?>