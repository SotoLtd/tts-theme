<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the id=main div and all content
 * after. Calls sidebar-footer.php for bottom widgets.
 *
 * @package WordPress
 * @subpackage Twenty_Ten
 * @since Twenty Ten 1.0
 */
?>
<footer>
	<div class="center">
    	<div class="orange clearfix">
        	<?php echo do_shortcode("[smartblock id=241]"); ?>
        </div>
        <div class="info">
			<?php if ( has_nav_menu( 'footer-menu' ) ) { /* if menu location 'primary-menu' exists then use custom menu */
      			wp_nav_menu( array( 'theme_location' => 'footer-menu') ); 
			} ?>
            <div class="clear"></div>
			<?php if(empty($_GET['administrate_checkout_event_id'])): ?> 
            <div class="footer-social-icons"><?php echo do_shortcode("[smartblock id=2359]"); ?></div>
			<?php endif; ?> 
            <?php echo do_shortcode("[smartblock id=281]"); ?>
        </div>
        <div class="clear"></div>
    </div>
</footer>

<script src="<?php echo get_template_directory_uri(); ?>/js/flexslider/jquery.flexslider-min.js" type="text/javascript"></script>

<script>
function ttsdebounce(func, wait, immediate) {
    var timeout;
    return function() {
            var context = this, args = arguments;
            var later = function() {
                    timeout = null;
                    if (!immediate) func.apply(context, args);
            };
            var callNow = immediate && !timeout;
            clearTimeout(timeout);
            timeout = setTimeout(later, wait);
            if (callNow) func.apply(context, args);
    };
};
(function($){
        function ttsCourseEF(){
            var f = $('.course-enquiry-form'), t, h = f.height() + 50, wh = $(window).height();
            if(h < wh){
                t = (wh - h)/2;
                t = parseInt(t, 10);
            }else{
                t = 0;
            }
            t = t + 50;
            f.css('top', t + "px");
        }
	function isMobile(w){
		if(w>$(window).width())
			return true;
		else
			return false;
	}

	$(document).ready(function(){
		if(isMobile(768)){
			$('body').removeClass('responsive-desktop');
		}
		$(window).resize(function(){
			if(isMobile(768)){
				$('body').removeClass('responsive-desktop');
			}else{
				$('body').addClass('responsive-desktop');
			}
		});
		$('#mian-menu-icon-mobile').on('click', function(){
			if($(this).hasClass('mian-menu-icon-shown')){
				$(this).removeClass('mian-menu-icon-shown');
				$('#main-nav').slideUp('400');
			}else{
				$(this).addClass('mian-menu-icon-shown');
				$('#main-nav').slideDown('400');
			}
		});
                $('.course-ef-title').on('click', function(e){
                    e.preventDefault();
                    $('body').toggleClass('course-enquiry-form-revealed');
                });
                ttsCourseEF();
                $(window).resize(ttsdebounce(function(){
                    ttsCourseEF();
                }, 200));
	});
	$(window).load(function() {
          $('.course-testimonials').flexslider({
                selector: ".course-testimonials-wrap >.course-testimonial",
                animation: "slide",
                controlNav: false,
                directionNav: true
            });
	});
	$(function() {
		function animateOneWay(el, startStyle, endStyle, duration, repeat){
			setTimeout(function(){animateOneWay(el, startStyle, endStyle, duration, repeat)}, repeat);
			el.css(startStyle);
			el.animate(endStyle, duration, 'linear');
		}
		 
		w = $(document).width();
		//animateOneWay($('#plane'),{left: w}, {left: -1980}, 24000, 25000);
		$('.fc-checkbox input[name*="checkbox-"]:not(:checked)').trigger('click');
	});



})(jQuery);
</script>

<?php
	/* Always have wp_footer() just before the closing </body>
	 * tag of your theme, or you will break many plugins, which
	 * generally use this hook to reference JavaScript files.
	 */

	wp_footer();
?>
<?php if(is_page(475)){ ?>
<!-- Google Code for enquiry Conversion Page -->

<script type="text/javascript">

/* <![CDATA[ */

var google_conversion_id = 1005052345;

var google_conversion_language = "en";

var google_conversion_format = "2";

var google_conversion_color = "ffffff";

var google_conversion_label = "n63UCIefxgoQucOf3wM";

var google_conversion_value = 1.00;

var google_conversion_currency = "GBP";

var google_remarketing_only = false;

/* ]]> */

</script>

<script type="text/javascript" src="//www.googleadservices.com/pagead/conversion.js">

</script>

<noscript>

<div style="display:inline;">

<img height="1" width="1" style="border-style:none;" alt="" src="//www.googleadservices.com/pagead/conversion/1005052345/?value=1.00&amp;currency_code=GBP&amp;label=n63UCIefxgoQucOf3wM&amp;guid=ON&amp;script=0"/>

</div>

</noscript>
<?php }?>

<?php if(is_page(1286)){ ?>
<!-- Google Code for Sales Page Conversion Page -->

<script type="text/javascript">

/* <![CDATA[ */

var google_conversion_id = 1005052345;

var google_conversion_language = "en";

var google_conversion_format = "3";

var google_conversion_color = "ffffff";

var google_conversion_label = "sK1jCIqyxlsQucOf3wM";

var google_conversion_value = 1.00;

var google_conversion_currency = "GBP";

var google_remarketing_only = false;

/* ]]> */

</script>

<script type="text/javascript" src="//www.googleadservices.com/pagead/conversion.js">

</script>

<noscript>

<div style="display:inline;">

<img height="1" width="1" style="border-style:none;" alt="" src="//www.googleadservices.com/pagead/conversion/1005052345/?value=1.00&amp;currency_code=GBP&amp;label=sK1jCIqyxlsQucOf3wM&amp;guid=ON&amp;script=0"/>

</div>

</noscript>
<?php }?>

<!-- Google Code for Remarketing Tag -->

<!--------------------------------------------------

Remarketing tags may not be associated with personally identifiable information or placed on pages related to sensitive categories. See more information and instructions on how to setup the tag on: http://google.com/ads/remarketingsetup

--------------------------------------------------->

<script type="text/javascript">

/* <![CDATA[ */

var google_conversion_id = 1005052345;

var google_custom_params = window.google_tag_params;

var google_remarketing_only = true;

/* ]]> */

</script>

<script type="text/javascript" src="//www.googleadservices.com/pagead/conversion.js">

</script>

<noscript>

<div style="display:inline;">

<img height="1" width="1" style="border-style:none;" alt="" src="//googleads.g.doubleclick.net/pagead/viewthroughconversion/1005052345/?value=0&amp;guid=ON&amp;script=0"/>

</div>
</noscript> 


<!--PAGE PROOFER-->
<script type="text/javascript"> (function (d, t) { var pp = d.createElement(t), s = d.getElementsByTagName(t)[0]; pp.src = '//app.pageproofer.com/overlay/js/2702/1254'; pp.type = 'text/javascript'; pp.async = true; s.parentNode.insertBefore(pp, s); })(document, 'script'); </script>
</body>
</html>