<?php
/**
 * The template for displaying just the fotn page / homepage.
 *
 * @package WordPress
 * @subpackage Twenty_Ten
 * @since Twenty Ten 1.0
 */

get_header(); ?>

<?php get_template_part( '/partials/home/home-hero' ); ?>
<main>
    <div class="center">
        <section class="row">
            <div class="seven-twelfths one-twelfth-right-margin">
                <h1 class="entry-title"><?php the_title(); ?></h1>
				<?php the_content(); ?>
            </div>
            <div class="five-twelfths">
                <h3 class="popular-courses-title">Popular courses</h3>
				<?php
				// check if the repeater field has rows of data
				if ( have_rows( 'popular_courses' ) ): ?>
					<?php get_template_part( '/partials/home/popular-courses' ); ?>
				<?php else :
					// no rows found
				endif; ?>
            </div>
        </section>
		<?php get_template_part( '/partials/home/home-logos' ); ?>
    </div>

    <section class="row great-courses-container">
        <div class="center">
            <h3>Great Courses & Great Service</h3>
            <div class="great-courses">
                <div>
					<?php the_field( 'great_courses_text' ); ?>
                </div>
                <div>
					<?php the_field( 'great_courses_text_2' ); ?>
                </div>
                <div>
					<?php the_field( 'great_courses_text_3' ); ?>
                </div>
            </div>
        </div>
    </section>

</main>

<?php get_footer(); ?>
