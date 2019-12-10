<?php
/**
 * Customer new account email
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/emails/customer-new-account.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates/Emails
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

?>

<?php do_action( 'woocommerce_email_header', $email_heading, $email ); ?>
	
	<p><?php _e('Thank you very much for creating a cash account with the Training Societi Ltd.', TBS_i18n::get_domain_name()) ?></p>
	<p><?php printf( __( 'To view your orders and edit your account details, go to %s.', 'woocommerce' ), make_clickable( esc_url( wc_get_page_permalink( 'myaccount' ) ) ) ); ?></p>
	<p>Here is a quick video from me, Rowena Hicks, MD and Founder of The Training Societi.  If for any reason, you can't play, or don't have speakers on your computer, then please read the transcript below.</p>
	<p class="video">
		<a href="https://vimeo.com/219065776" target=""_blank>
			<img style="display: block;height: auto;width: 100%;border: 0;" src="<?php echo get_stylesheet_directory_uri() ?>/images/email/video-overlay.jpg" alt="" width="600">
		</a>
	</p>
	<p>&quot;Hello, my name is Rowena Hicks and I am the founder and the MD of The Training Societi in Bristol.</p>
    <p>I just wanted to say a huge thank you for your first ever booking with us which is really appreciated.</p>
    <p>I trust that our team are taking good care of you and your delegates but if you need anything else from them then their contact details are below:</p>
    <p>&#128073;&#127996; If you need advice on what training you need or wish to book a course - Ryan 01179 971 1892 - Option 1 - <a style="text-decoration: underline;transition: opacity 0.1s ease-in;color: #fc7208;" href="mailto:info@trainingsocieti.co.uk">info@trainingsocieti.co.uk</a></p>
    <p>&#128073;&#127996; If you have an existing course booking with us and wish to talk to us about this - Chaz - 0117 971 1892 - Option 2 - <a style="text-decoration: underline;transition: opacity 0.1s ease-in;color: #fc7208;" href="mailto:bookings@trainingsocieti.co.uk">bookings@trainingsocieti.co.uk</a></p>
    <p>&#128073;&#127996; If you have a query about your Certification - Kath 0117 971 1892 option 3 - <a style="text-decoration: underline;transition: opacity 0.1s ease-in;color: #fc7208;" href="mailto:certificates@trainingsocieti.co.uk">certificates@trainingsocieti.co.uk</a></p>
    <p>&#128073;&#127996; If you want to talk to us about Finance - Lisa - 0117 971 1892 option 4 or <a style="text-decoration: underline;transition: opacity 0.1s ease-in;color: #fc7208;" href="mailto:finance@trainingsocieti.co.uk">finance@trainingsocieti.co.uk</a></p>
    <p>&#128073;&#127996;&nbsp; For anything else! -&nbsp;Ryan 01179 971 1892 - Option 5 <a style="text-decoration: underline;transition: opacity 0.1s ease-in;color: #fc7208;" href="mailto:info@trainingsocieti.co.uk">info@trainingsocieti.co.uk</a></p>
	<p>&quot;I also wanted to let you know that now you are one of our customers, we want to do everything possible to take care of you, your delegates and&nbsp;your company to give you the correct advice on training and help you where ever possible.</p>
	<table width="100%" cellspacing="0" cellpadding="20" border="0" style="margin-bottom: 15px;">
		<tbody>
			<tr>
				<td style="padding: 0 12px 0 0; width: 50%" valign="top">
					<img style="display: block;height: auto;width: 100%;border: 0;" src="<?php echo get_stylesheet_directory_uri() ?>/images/email/2018wallplanner.PNG" alt="" width="300">
				</td>
				<td style="padding: 0 0 0 12px;width: 50%;" valign="top">
					<p>One thing we have are wallplanners which have all of our up and coming dates on them.&nbsp;</p><p style="Margin-top: 20px;Margin-bottom: 0;">Other customers have said how useful they are, so if you want a copy (they are free) then just <a style="text-decoration: underline;transition: opacity 0.1s ease-in;color: #fc7208;" href="mailto:rowena.hicks@trainingsocieti.co.uk">email me</a> and I will get one in the post to you.</p>
				</td>
			</tr>
		</tbody>
	</table>
	<p>I've also put you on our email list which means we will send you news on special deals, information about up and coming changes in legislation (for example CITB changes).&nbsp; If you do want to unsubsribe from the list, then it's very easy.</p><p style="Margin-top: 20px;Margin-bottom: 0;">Anyway, that's enough from me for now, we look forward to meeting your delegates.</p><p style="Margin-top: 20px;Margin-bottom: 20px;">Take care and stay safe!</p>
    <p>Many thanks from</p>
	<p><strong>Rowena Hicks, Founder &amp; MD of The Training Societi Ltd</strong></p>
	<p>PS - If there is any feedback you would like to share then please let me know.&nbsp; I am always looking to improve our service so any comments will be very gratefully received.</p>
	<p style="margin-bottom: 20px;">
		<img style="display: block;height: auto;width: 100%;border: 0;" src="<?php echo get_stylesheet_directory_uri() ?>/images/email/Logowiththatsmewebversion.png" alt="" width="600">
	</p>
	
<?php do_action( 'woocommerce_email_footer', $email );
