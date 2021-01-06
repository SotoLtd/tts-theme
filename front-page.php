<?php
/**
 * The template for displaying just the fotn page / homepage.
 *
 * @package WordPress
 * @subpackage Twenty_Ten
 * @since Twenty Ten 1.0
 */

get_header(); ?>


<div class="mob-hero"><?php get_template_part ( '/partials/home/home-hero' ); ?></div>

<main>

	<div class="center">

		<section class="row">

			<div class="seven-twelfths one-twelfth-right-margin">

				<h1 class="entry-title"><?php the_title(); ?></h1>
				<?php the_content(); ?>

			</div>

			<div class="five-twelfths">

				<div class="dsk-hero"><?php get_template_part ( '/partials/home/home-hero' ); ?></div>


				<h3 class="popular-courses-title">Popular courses</h3>

				<?php
				// check if the repeater field has rows of data
				if( have_rows( 'popular_courses' ) ): ?>

					<?php get_template_part ( '/partials/home/popular-courses' ); ?>

				<?php else :

					// no rows found

				endif; ?>

			</div>

		</section>

		<?php get_template_part ( '/partials/home/home-logos' ); ?>

		<!-- <section>

			<div class="row-column course-category-teaser-wrapper working-at-height">

				<div class="course-category-teaser-image"> </div>

				<div class="course-category-teaser-content five-twelfths">

					//<?php $fieldgroup = 'working_at_height'; ?>
					//<?php include( locate_template( 'partials/home/courses-teasers.php' ) ); ?>

				</div>

			</div>

			<div class="row-column course-category-teaser-wrapper site-safety">

				<div class="course-category-teaser-image"> </div>

				<div class="course-category-teaser-content five-twelfths flex-right">

					//<?php $fieldgroup = 'site_safety'; ?>
					//<?php include( locate_template( 'partials/home/courses-teasers.php' ) ); ?>

				</div>

			</div>

		</section> -->

		</div>

		<section class="row great-courses-container">
			<div>
				<h3>Great Courses & Great Service</h3>
				<div class="great-courses">
					<div>
						<?php the_field ( 'great_courses_text'); ?>
					</div>
					<div>
						<?php the_field ( 'great_courses_text_2'); ?>
					</div>
					<div>
						<?php the_field ( 'great_courses_text_3'); ?>
					</div>
			</div>
		</div>
		</section>



</main>

<?php get_footer(); ?>
