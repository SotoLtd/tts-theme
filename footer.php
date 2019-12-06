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
<footer id="site-footer">
    <div class="center">
        <div class="site-footer-inner">
            <div class="footer-block">
                <div class="footer-block-inner">
					<?php if ( has_nav_menu( 'footer-menu' ) ): ?>
                        <div class="site-footer-menu">
							<?php
							wp_nav_menu( array(
								'theme_location' => 'footer-menu',
								'fallback_cb'    => false,
								'container'      => ''
							) );
							?>
                        </div>
					<?php endif; ?>
                    <div class="footer-social-icons"><?php echo do_shortcode( "[smartblock id=2359]" ); ?></div>
					<?php echo do_shortcode( "[smartblock id=281]" ); ?>
                </div>
            </div>
            <div class="footer-block">
                <div class="footer-block-inner">
                    <div class="footer-block-title">Accredited by</div>
                    <ul class="tts-accreditation-logos">
                        <li>
                            <img src="/wp-content/uploads/2019/09/citb-logo-2.png" alt="citb logo">
                        </li>
                        <li>
                            <img src="/wp-content/uploads/2019/09/PASMA-logo-2.png" alt="pasma logo">
                        </li>
                        <li>
                            <img src="/wp-content/uploads/2019/09/IPAF-logo-3.png" alt="ipaf logo">
                        </li>
                    </ul>
                </div>
            </div>
            <div class="footer-block">
                <div class="footer-block-inner">
                    <div class="footer-contact-icons">
						<?php echo do_shortcode( "[smartblock id=241]" ); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>
<?php
if ( is_page( 'basket' ) || is_page( 'checkout' ) ) {

} else { ?>
    <div class="course-enquiry-form">
        <h5 class="course-ef-title">Enquire</h5>
        <div class="course-efwrap">
			<?php echo do_shortcode( '[contact-form-7 id="2057" title="Course Quick Enquiry"]' ); ?>
        </div>
    </div>
    <script src="<?php echo get_template_directory_uri(); ?>/js/flexslider/jquery.flexslider-min.js" type="text/javascript"></script>

    <script>
        function ttsdebounce(func, wait, immediate) {
            var timeout;
            return function () {
                var context = this, args = arguments;
                var later = function () {
                    timeout = null;
                    if (!immediate) func.apply(context, args);
                };
                var callNow = immediate && !timeout;
                clearTimeout(timeout);
                timeout = setTimeout(later, wait);
                if (callNow) func.apply(context, args);
            };
        };
        (function ($) {
            function ttsCourseEF() {
                var f = $('.course-enquiry-form'), t, h = f.height() + 50, wh = $(window).height();
                if (h < wh) {
                    t = (wh - h) / 2;
                    t = parseInt(t, 10);
                } else {
                    t = 0;
                }
                t = t + 50;
                f.css('top', t + "px");
            }

            function isMobile(w) {
                if (w > $(window).width())
                    return true;
                else
                    return false;
            }

            $(document).ready(function () {
                if (isMobile(768)) {
                    $('body').removeClass('responsive-desktop');
                }
                $(window).resize(function () {
                    if (isMobile(768)) {
                        $('body').removeClass('responsive-desktop');
                    } else {
                        $('body').addClass('responsive-desktop');
                    }
                });
                $('#mian-menu-icon-mobile').on('click', function () {
                    if ($(this).hasClass('mian-menu-icon-shown')) {
                        $(this).removeClass('mian-menu-icon-shown');
                        $('#main-nav').slideUp('400');
                    } else {
                        $(this).addClass('mian-menu-icon-shown');
                        $('#main-nav').slideDown('400');
                    }
                });
                $('.course-ef-title').on('click', function (e) {
                    e.preventDefault();
                    $('body').toggleClass('course-enquiry-form-revealed');
                });
                ttsCourseEF();
                $(window).resize(ttsdebounce(function () {
                    ttsCourseEF();
                }, 200));
            });
            $(window).load(function () {
                $('.course-testimonials').flexslider({
                    selector: ".course-testimonials-wrap >.course-testimonial",
                    animation: "slide",
                    controlNav: false,
                    directionNav: true
                });
            });
            $(function () {
                function animateOneWay(el, startStyle, endStyle, duration, repeat) {
                    setTimeout(function () {
                        animateOneWay(el, startStyle, endStyle, duration, repeat)
                    }, repeat);
                    el.css(startStyle);
                    el.animate(endStyle, duration, 'linear');
                }

                w = $(document).width();
                //animateOneWay($('#plane'),{left: w}, {left: -1980}, 24000, 25000);
                //$('.fc-checkbox input[name*="checkbox-"]:not(:checked)').trigger('click');
            });


        })(jQuery);
    </script>

	<?php
}
?>

<?php wp_footer(); ?>
</body>
</html>