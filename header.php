<?php
/**
 * The Header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="main">
 *
 * @package WordPress
 * @subpackage Twenty_Ten
 * @since Twenty Ten 1.0
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <script async src="//41730.tctm.co/t.js"></script>
    <meta charset="<?php bloginfo( 'charset' ); ?>" />
    <meta content="width=device-width, initial-scale=1, maximum-scale=1" name="viewport">
    
    <link rel="profile" href="http://gmpg.org/xfn/11" />
    <link rel="stylesheet" type="text/css" media="all" href="<?php echo get_stylesheet_directory_uri(); ?>/js/flexslider/flexslider.css" />
    <link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo( 'stylesheet_url' ); ?>" />
    <link rel="stylesheet" type="text/css" media="all" href="<?php echo get_stylesheet_directory_uri(); ?>/css/responsive.css" />
    <link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />

    <script>
    (function() {
        var _fbq = window._fbq || (window._fbq = []);
        if (!_fbq.loaded) {
            var fbds = document.createElement('script');
            fbds.async = true;
            fbds.src = '//connect.facebook.net/en_US/fbds.js';
            var s = document.getElementsByTagName('script')[0];
            s.parentNode.insertBefore(fbds, s);
            _fbq.loaded = true;
        }
        _fbq.push(['addPixelId', '1578320215739095']);
    })();
    window._fbq = window._fbq || [];
    window._fbq.push(['track', 'PixelInitialized', {}]);
    </script>
    <noscript><img height="1" width="1" alt="" style="display:none" src="https://www.facebook.com/tr?id=1578320215739095&amp;ev=PixelInitialized" /></noscript>
<?php
	/* We add some JavaScript to pages with the comment form
	 * to support sites with threaded comments (when in use).
	 */
	if ( is_singular() && get_option( 'thread_comments' ) )
		wp_enqueue_script( 'comment-reply' );

	/* Always have wp_head() just before the closing </head>
	 * tag of your theme, or you will break many plugins, which
	 * generally use this hook to add elements to <head> such
	 * as styles, scripts, and meta tags.
	 */
	wp_head();
?>
</head>

<body <?php body_class('responsive-desktop'); ?>>

<header>
    <div id="mian-menu-icon-mobile" onClick="return true;"><span>Menu</span></div>
    <div id="mobile-searchbar" class="tts-mobile">
        <?php get_search_form(); ?>
    </div>
	<div class="center">
            <div class="col col1">
                <a href="<?php echo home_url( '/' ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><img src="<?php echo get_template_directory_uri(); ?>/images/logo.png" class="logo" /></a>
				<div class="quicklinks tts-mobile">
                    <?php echo do_shortcode("[smartblock id=375]"); ?>
                    <div class="clear"></div>
                </div>
            </div>
            <div class="col col2">
                <div class="contact">
					<?php echo do_shortcode("[smartblock id=338]"); ?>
                </div>
                <div class="methods">
					<?php echo do_shortcode("[smartblock id=339]"); ?>
                    <div class="clear"></div>
                </div>
				<div class="tbs-header-cart-summery-wrap">
					<?php if( function_exists('tbs_header_cart_summery') ){tbs_header_cart_summery();} ?>
				</div>
            </div>
            <div class="clear"></div>
            <div class="quicklinks tts-desktop">
                <?php echo do_shortcode("[smartblock id=375]"); ?>
                <div class="clear"></div>
            </div>
			<?php if( !function_exists( 'tbs_is_manual_booking_form_page' ) || !tbs_is_manual_booking_form_page() ): ?>
            <div class="header-book-buttons">
                <a title="" href="<?php echo get_permalink(361); ?>"><img alt="book now - link to course dates" src="<?php echo get_stylesheet_directory_uri(); ?>/images/btn-book-online.png"></a>
            </div>
			<?php endif; ?>
            <div class="clear"></div>
            <nav id="main-nav">
                            <?php wp_nav_menu( array( 'container_class' => 'menu-header', 'theme_location' => 'primary', 'menu_class' => 'menu clearfix' ) ); ?>
                <div class="clear"></div>
            </nav>
        </div>
</header>
	


<?php if ( is_front_page() && empty($_GET['booking_manual_key']) ) { ?>
    <section class="home-contact-video tts-desktop">
        <div class="center clearfix">
            <div class="home-banner-wrap clearfix">
                <div class="banner-women-image"></div>
                <div class="banner-content-box">
                    <div class="banner-content-box-inner clearfix free-training-button-active">
                        <div class="home-banner-title"><span class="orrange">Health &amp; Safety Training</span></div>
                        <div class="col col2 banner-nlsignup-form clearfix">
                            <div class="hb-course-links">
                                <ul class="hb-cl-ul">
                                    <li class="hb-citb"><a href="https://thetrainingsocieti.co.uk/course/citb-health-safety-awareness-2/"><img alt="" src="<?php echo get_stylesheet_directory_uri(); ?>/images/home-banner/hb-citb.png" /> Health &amp; Safety Awareness <span class="orrange">&gt;</span></a></li>
                                    <li class="hb-citb"><a href="https://thetrainingsocieti.co.uk/course/citb-sssts/"><img alt="" src="<?php echo get_stylesheet_directory_uri(); ?>/images/home-banner/hb-citb.png" /> SSSTS <span class="orrange">&gt;</span></a></li>
                                    <li class="hb-citb"><a href="https://thetrainingsocieti.co.uk/course/citb-smsts/"> <img alt="" src="<?php echo get_stylesheet_directory_uri(); ?>/images/home-banner/hb-citb.png" /> SMSTS <span class="orrange">&gt;</span></a></li>
                                    <li class="hb-psma"><a href="https://thetrainingsocieti.co.uk/course/pasma-mobile-access-tower/"><img alt="" src="<?php echo get_stylesheet_directory_uri(); ?>/images/home-banner/hb-psma.png" /> Mobile Access Tower <span class="orrange">&gt;</span></a></li>
                                    <li class="hb-ipaf"><a href="https://thetrainingsocieti.co.uk/course/ipaf-scissor-boom/"><img alt="" src="<?php echo get_stylesheet_directory_uri(); ?>/images/home-banner/hb-ipaf.png" /> Scissor &amp; Boom (3a &amp; 3b) <span class="orrange">&gt;</span></a></li>
                                </ul>
                            </div>
                            <h4 class="clear hb-more-courses"><a title="" href=""><span class="orrange"></span></a></h4>
                        </div>
                        <div class="col col1">
                            <div class="responsive-embed-contianer">
                                <div id="freesevenpointguid"></div>
                                <script>
                                    ;
                                    var tag = document.createElement('script');
                                    tag.src = "https://www.youtube.com/player_api";
                                    var firstScriptTag = document.getElementsByTagName('script')[0];
                                    firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);

                                    var ttsyplayer;
                                    function onYouTubeIframeAPIReady(){
                                        if(ttsyplayer){
                                            return;
                                        }
                                        ttsyplayer = new YT.Player('freesevenpointguid', {
                                            videoId: 'brexqkfx4pw',
                                            height: '315',
                                            width: '560',
                                            playerVars: {
                                                autoplay: 1,
                                                cc_load_policy: 0,
                                                enablejsapi: 1,
                                                origin: 'https://thetrainingsocieti.co.uk',
                                                rel: 0
                                            },
                                            events: {
                                                'onReady': function(event){
                                                    event.target.mute();
                                                    event.target.playVideo();
                                                    event.target.mute();
                                                },
                                                'onStateChange': function(event){
                                                    event.target.mute();
                                                }
                                            }
                                        });
                                    };
                                    function onYouTubePlayerAPIReady(){
                                        if(ttsyplayer){
                                            return;
                                        }
                                        ttsyplayer = new YT.Player('freesevenpointguid', {
                                            videoId: 'brexqkfx4pw',
                                            height: '315',
                                            width: '560',
                                            playerVars: {
                                                autoplay: 1,
                                                cc_load_policy: 0,
                                                enablejsapi: 1,
                                                origin: 'https://thetrainingsocieti.co.uk',
                                                rel: 0
                                            },
                                            events: {
                                                'onReady': function(event){
                                                    event.target.mute();
                                                    event.target.playVideo();
                                                    event.target.mute();
                                                },
                                                'onStateChange': function(event){
                                                    event.target.mute();
                                                }
                                            }
                                        });
                                    }
                                </script>
                                
                            </div>
                            

                            
                        </div>
                    </div>
                </div>
                <div class="banner-women-hand"></div>
            </div>
        </div>
    </section>
<?php }elseif(function_exists('bcn_display') && empty($_GET['booking_manual_key'])){ ?>
    <div class="bread-crumb-container">
        <div class="center">
            <div class="breadcrumbs" xmlns:v="http://rdf.data-vocabulary.org/#">
                <?php bcn_display(); ?>
            </div>
        </div>
    </div>
<?php } ?>