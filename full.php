<?php
/*
Template Name: Full
*/

get_header(); ?>

<main>
	<div class="center">
        <div class="col col1">
			<?php
			/* Run the loop to output the page.
			 * If you want to overload this in a child theme then include a file
			 * called loop-page.php and that will be used instead.
			 */
			get_template_part( 'loop', 'page' );
			?>
        </div>
        <div class="clear"></div>
    </div>
</main>

<?php get_footer(); ?>