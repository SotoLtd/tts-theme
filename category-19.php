<?php
/**
 * The template for displaying Category Archive pages.
 *
 * @package WordPress
 * @subpackage Twenty_Ten
 * @since Twenty Ten 1.0
 */

get_header(); ?>

<main>
	<div class="center">
        <div class="col col1 faqs-wrap">

				<h1 class="page-title"><?php
					printf( __( ' %s', 'twentyten' ), '<span>' . single_cat_title( '', false ) . '</span>' );
				?></h1><p></p>
					<?php
					$category_description = category_description();
					if ( ! empty( $category_description ) )
						echo '<div class="archive-meta">' . $category_description . '</div>';

				/* Run the loop for the category page to output the posts.
				 * If you want to overload this in a child theme then include a file
				 * called loop-category.php and that will be used instead.
				 */
				get_template_part( 'loop', 'faq' );
				?>

        </div>
        <div class="col col2">
            <?php get_sidebar('news'); ?>
        </div>
        <div class="clear"></div>
    </div>
</main>

<?php get_footer(); ?>