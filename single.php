<?php
/**
 * The Template for displaying all single posts.
 *
 * @package WordPress
 * @subpackage Twenty_Ten
 * @since Twenty Ten 1.0
 */

get_header(); ?>

<main>
	<div class="center">
        <div class="col col1">
			<?php
			/* Run the loop to output the post.
			 * If you want to overload this in a child theme then include a file
			 * called loop-single.php and that will be used instead.
			 */
			get_template_part( 'loop', 'single' );
			?>
        </div>
        <div class="col col2">
            <?php get_sidebar('news'); ?>
        </div>
        <div class="clear"></div>
    </div>
</main>

<?php get_footer(); ?>
