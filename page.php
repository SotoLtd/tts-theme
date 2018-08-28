<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 * @package WordPress
 * @subpackage Twenty_Ten
 * @since Twenty Ten 1.0
 */

get_header(); ?>


<?php if( !is_account_page() && !is_checkout() && !is_cart() ): ?>
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
			<div class="col col2">
				<?php get_sidebar('right'); ?>
			</div>
        <div class="clear"></div>
    </div>
</main>
<?php else: ?>
<main class="tbs-wc-page <?php if(is_account_page()) { echo 'tbs-account-page'; } ?>">
	<div class="center">
		<div class="tbs-wc-page-content">
			<?php if ( have_posts() ): while ( have_posts() ) : the_post(); ?>
			<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
				<div class="entry-content">
					<?php the_content(); ?>
				</div>
			</div>
			<?php endwhile; endif; // end of the loop. ?>
        </div>
    </div>
</main>
<?php endif; ?>

<?php get_footer(); ?>