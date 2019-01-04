<?php
/**
 * The template for displaying just the fotn page / homepage.
 *
 * @package WordPress
 * @subpackage Twenty_Ten
 * @since Twenty Ten 1.0
 */

get_header(); ?>

<?php get_template_part ( '/partials/home/home-hero' ); ?>


<main>

	<div class="center">

		<section class="row">

			<div class="seven-twelfths one-twelfth-right-margin">

				<h1 class="entry-title"><?php the_title(); ?></h1>
				<?php the_field ( 'intro_text'); ?>

			</div>

			<div class="five-twelfths">
				<h2 class="popular-courses-title">Popular courses</h2>

				<?php 
				// check if the repeater field has rows of data
				if( have_rows( 'popular_courses' ) ): ?>
					
					<?php get_template_part ( '/partials/home/popular-courses' ); ?>

				<?php else :

					// no rows found

				endif; ?>

			</div>

		</section>	


		<section>

			<div class="row-column course-category-teaser-wrapper working-at-height">

				<div class="course-category-teaser-image"> </div>

				<div class="course-category-teaser-content five-twelfths">

					<?php $fieldgroup = 'working_at_height'; ?>
					<?php include( locate_template( 'partials/home/courses-teasers.php' ) ); ?>

				</div>

			</div>
		
			<div class="row-column course-category-teaser-wrapper site-safety">

				<div class="course-category-teaser-image"> </div>

				<div class="course-category-teaser-content five-twelfths flex-right">

					<?php $fieldgroup = 'site_safety'; ?>
					<?php include( locate_template( 'partials/home/courses-teasers.php' ) ); ?>

				</div>

			</div>

			<div class="row-column course-category-teaser-wrapper scaffolding-training">

				<div class="course-category-teaser-image"> </div>

				<div class="course-category-teaser-content five-twelfths">

					<?php $fieldgroup = 'scaffolding'; ?>
					<?php include( locate_template( 'partials/home/courses-teasers.php' ) ); ?>

				</div>

			</div>

		</section>	


		<section class="row">

			<div class="seven-twelfths">
				<h2>Great Courses & Great Service</h2>

				<div class="orange-border">
					<div>

						<?php the_field ( 'great_courses_text'); ?>

					</div>	
				</div>		
			</div>	

			<div class="five-twelfths contact-form">

				<h2>Quick enquiry</h2>
				<?php echo do_shortcode( '[contact-form-7 id="232" title="Quick enquiry"]' ); ?>

			</div>	
		
		</section>		

    </div>

</main>

<?php get_footer(); ?>