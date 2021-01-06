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

    <meta charset="<?php bloginfo( 'charset' ); ?>"/>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1" name="viewport">

    <link rel="profile" href="http://gmpg.org/xfn/11"/>
    <link rel="stylesheet" type="text/css" media="all" href="<?php echo get_stylesheet_directory_uri(); ?>/js/flexslider/flexslider.css"/>
    <link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo( 'stylesheet_url' ); ?>"/>
    <link rel="stylesheet" type="text/css" media="all" href="<?php echo get_stylesheet_directory_uri(); ?>/css/responsive.css"/>
    <link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>"/>
    <link rel='shortcut icon' type='image/x-icon' href='/favicon.ico' />
<script type="text/javascript">
    (function(c,l,a,r,i,t,y){
        c[a]=c[a]||function(){(c[a].q=c[a].q||[]).push(arguments)};
        t=l.createElement(r);t.async=1;t.src="https://www.clarity.ms/tag/"+i;
        y=l.getElementsByTagName(r)[0];y.parentNode.insertBefore(t,y);
    })(window, document, "clarity", "script", "3vklxjkifd");
</script>
	<?php
	/* We add some JavaScript to pages with the comment form
	 * to support sites with threaded comments (when in use).
	 */
	if ( is_singular() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
	/* Always have wp_head() just before the closing </head>
	 * tag of your theme, or you will break many plugins, which
	 * generally use this hook to add elements to <head> such
	 * as styles, scripts, and meta tags.
	 */
	wp_head();
	?>
</head>

<body <?php body_class( 'responsive-desktop' ); ?>>

<header>
    <div id="mian-menu-icon-mobile" onClick="return true;"><span>Menu</span></div>
    <div id="mobile-searchbar" class="tts-mobile">
		<?php get_search_form(); ?>
    </div>
    <div class="center">
        <div class="col col1">
            <a href="<?php echo home_url( '/' ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><img src="https://thetrainingsocieti.co.uk/wp-content/uploads/2019/07/tts-logo.jpg" class="logo"/></a>
            <div class="quicklinks tts-mobile">
				<?php echo do_shortcode( "[smartblock id=375]" ); ?>
                <div class="clear"></div>
            </div>
        </div>
        <div class="col col2">
            <div class="contact">
				<?php echo do_shortcode( "[smartblock id=338]" ); ?>
            </div>
            <div class="methods">
				<?php echo do_shortcode( "[smartblock id=339]" ); ?>
                <div class="clear"></div>
            </div>
			<?php if ( ! function_exists( 'tbs_is_manual_booking_form_page' ) || ! tbs_is_manual_booking_form_page() ): ?>
                <div class="header-book-online-button">
                    <a title="" href="<?php echo get_permalink( 361 ); ?>">Book online</a>
                </div>
			<?php endif; ?>
            <div class="tbs-header-cart-summery-wrap">
				<?php if ( function_exists( 'tbs_header_cart_summery' ) ) {
					tbs_header_cart_summery();
				} ?>
            </div>
        </div>
        <div class="clear"></div>
        <nav id="main-nav">
			<?php wp_nav_menu( array(
				'container_class' => 'menu-header',
				'theme_location'  => 'primary',
				'menu_class'      => 'menu clearfix'
			) ); ?>
        <div class="courses-nav courses-menu-item">

              <?php wp_nav_menu( array(
                'container_class' => 'courses-primary',
                'theme_location'  => 'custom-courses',
                'menu_class'      => 'menu clearfix'
              ) ); ?>

              <?php wp_nav_menu( array(
                'container_class' => 'courses-children',
                'theme_location'  => 'custom-courses-children',
                'menu_class'      => 'menu clearfix'
              ) ); ?>

        </div>
        <script>
          $(".courses-menu-item").hover(function(){
              $(".courses-nav").css("display", "flex");
            }, function(){
              $(".courses-nav").css("display", "none");
            });
        </script>
            <div class="clear"></div>
        </nav>
    </div>
</header>


<?php if ( function_exists( 'bcn_display' ) && empty( $_GET['booking_manual_key'] ) ){ ?>
<div class="bread-crumb-container">
    <div class="center">
        <div class="breadcrumbs" xmlns:v="http://rdf.data-vocabulary.org/#">
			<?php bcn_display(); ?>
        </div>
    </div>
</div>
<?php } ?>
