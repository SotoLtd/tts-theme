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
				<?php get_template_part( 'loop', 'page' ); ?>
			</div>

			<div class="five-twelfths">
				<h2>Popular courses</h2>
				<ul class="hb-cl-ul">
					<li class="hb-citb"><a href="https://thetrainingsocieti.co.uk/course/citb-health-safety-awareness-2/"><img alt="" src="<?php echo get_stylesheet_directory_uri(); ?>/images/home-banner/hb-citb.png" /> Health &amp; Safety Awareness <span class="orrange">&gt;</span></a></li>
					<li class="hb-citb"><a href="https://thetrainingsocieti.co.uk/course/citb-sssts/"><img alt="" src="<?php echo get_stylesheet_directory_uri(); ?>/images/home-banner/hb-citb.png" /> SSSTS <span class="orrange">&gt;</span></a></li>
					<li class="hb-citb"><a href="https://thetrainingsocieti.co.uk/course/citb-smsts/"> <img alt="" src="<?php echo get_stylesheet_directory_uri(); ?>/images/home-banner/hb-citb.png" /> SMSTS <span class="orrange">&gt;</span></a></li>
					<li class="hb-psma"><a href="https://thetrainingsocieti.co.uk/course/pasma-mobile-access-tower/"><img alt="" src="<?php echo get_stylesheet_directory_uri(); ?>/images/home-banner/hb-psma.png" /> Mobile Access Tower <span class="orrange">&gt;</span></a></li>
					<li class="hb-ipaf"><a href="https://thetrainingsocieti.co.uk/course/ipaf-scissor-boom/"><img alt="" src="<?php echo get_stylesheet_directory_uri(); ?>/images/home-banner/hb-ipaf.png" /> Scissor &amp; Boom (3a &amp; 3b) <span class="orrange">&gt;</span></a></li>
				</ul>
			</div>

		</section>	


		<section>

			<div class="row-column course-category-teaser-wrapper working-at-height">

				<div class="course-category-teaser-content five-twelfths">
					<h2>Working at height training</h2>
					<ul class="hb-cl-ul">
						<li class="hb-citb"><a href="https://thetrainingsocieti.co.uk/course/citb-health-safety-awareness-2/"> Health &amp; Safety Awareness <span class="orrange">&gt;</span></a></li>
						<li class="hb-citb"><a href="https://thetrainingsocieti.co.uk/course/citb-sssts/"> SSSTS <span class="orrange">&gt;</span></a></li>
						<li class="hb-citb"><a href="https://thetrainingsocieti.co.uk/course/citb-smsts/"> SMSTS <span class="orrange">&gt;</span></a></li>
					</ul>
					<p><a href="<?php get_site_url() ?>/course/category/work-at-height/">View all Working at Height Training courses<span class="orrange">&gt;</span></a>
				</div>

			</div>
		
			<div class="row-column course-category-teaser-wrapper site-safety">

				<div class="course-category-teaser-content five-twelfths flex-right">
					<h2>CITB Site Safety Plus Training</h2>
					<ul class="hb-cl-ul">
						<li class="hb-citb"><a href="https://thetrainingsocieti.co.uk/course/citb-health-safety-awareness-2/"> Health &amp; Safety Awareness <span class="orrange">&gt;</span></a></li>
						<li class="hb-citb"><a href="https://thetrainingsocieti.co.uk/course/citb-sssts/"> SSSTS <span class="orrange">&gt;</span></a></li>
						<li class="hb-citb"><a href="https://thetrainingsocieti.co.uk/course/citb-smsts/"> SMSTS <span class="orrange">&gt;</span></a></li>
					</ul>
					<p><a href="<?php get_site_url() ?>/course/category/work-at-height/">View all Working at Height Training courses<span class="orrange">&gt;</span></a>
				</div>

			</div>

			<div class="row-column course-category-teaser-wrapper scaffolding-training">

				<div class="course-category-teaser-content five-twelfths">
					<h2>Scaffolding Training</h2>
					<ul class="hb-cl-ul">
						<li class="hb-citb"><a href="https://thetrainingsocieti.co.uk/course/citb-health-safety-awareness-2/"> Health &amp; Safety Awareness <span class="orrange">&gt;</span></a></li>
						<li class="hb-citb"><a href="https://thetrainingsocieti.co.uk/course/citb-sssts/"> SSSTS <span class="orrange">&gt;</span></a></li>
						<li class="hb-citb"><a href="https://thetrainingsocieti.co.uk/course/citb-smsts/"> SMSTS <span class="orrange">&gt;</span></a></li>
					</ul>
					<p><a href="<?php get_site_url() ?>/course/category/work-at-height/">View all Working at Height Training courses<span class="orrange">&gt;</span></a>
				</div>

			</div>

		</section>	


		<section class="row">

			<div class="seven-twelfths">
				<h2>Great Courses & Great Service</h2>

				<div class="row orange-border">

					<img class="rowena-image" src="<?php echo get_stylesheet_directory_uri() . '/images/home/Rowena-Hicks-Director.png' ?>" alt="Rowena Hicks - Director" />
					
					<div>
						<h3>Pre-course</h3>
						<ul class="custom-bullet">
							<li>Advice &amp; Recommendations</li>
							<li>Fast &amp; Efficient Online Booking</li>
						</ul>
						
						<h3>During Course</h3>
						<ul class="custom-bullet">
							<li>Knowledgeable, Skilled, Experienced &amp; Friendly Trainers</li>
							<li>Experience in diverse sectors and industries</li>
						</ul>
						
						<h3>Post-course</h3>
						<ul class="custom-bullet">
							<li>Confirmation of Success within 24 hrs</li>
							<li>Certificates Sent Quickly</li>
						</ul>
					</div>	
				</div>		
			</div>	

			<div class="five-twelfths">
				<h2>Quick enquiry</h2>

				<?php echo do_shortcode( '[contact-form-7 id="5" title="Contact form 1"]' ); ?>
			</div>	
		
		</section>		

    </div>

</main>

<?php get_footer(); ?>