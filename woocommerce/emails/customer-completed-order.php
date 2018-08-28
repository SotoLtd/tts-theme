<?php
/**
 * Customer completed order email
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/emails/customer-completed-order.php.
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
 * @version     2.5.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * @hooked WC_Emails::email_header() Output the email header
 */
do_action( 'woocommerce_email_header', $email_heading, $email ); ?>

<p><?php _e( "Thank you very much for your completed booking form, I am very pleased to confirm the booking of the course/s below.", TBS_i18n::get_domain_name() ); ?></p>
<p><span style="text-decoration: underline;"><?php _e('What happens next?', TBS_i18n::get_domain_name()); ?></span></p>
<p>You and your delegates (if you supplied their email/s) will be emailed joining instructions which will detail everything they need to know about their course/s, including:</p>
<ul>
	<li>Date</li>
	<li>Start and finish times</li>
	<li>Full venue address and map</li>
	<li>What they need to bring.</li>
</ul>
<p>Here, in the meantime is a reminder of what you have booked with us:</p>
<?php

/**
 * @hooked WC_Emails::order_details() Shows the order details table.
 * @hooked WC_Structured_Data::generate_order_data() Generates structured data.
 * @hooked WC_Structured_Data::output_structured_data() Outputs structured data.
 * @since 2.5.0
 */
do_action( 'woocommerce_email_order_details', $order, $sent_to_admin, $plain_text, $email );

/**
 * @hooked WC_Emails::order_meta() Shows order meta data.
 */
do_action( 'woocommerce_email_order_meta', $order, $sent_to_admin, $plain_text, $email );

/**
 * @hooked WC_Emails::customer_details() Shows customer details
 * @hooked WC_Emails::email_address() Shows email address
 */
do_action( 'woocommerce_email_customer_details', $order, $sent_to_admin, $plain_text, $email );

?> 

				<p>On successful completion of course each delegate will receive an attendance certificate and photo card (if supplied) approximately 4 weeks after the course has been completed. For CITB courses this may be 8 weeks.</p>
				<p><strong>We welcome all delegates from all nationalities who want to learn and grow with us. However, as per our terms and conditions, please note that it is the bookers responsibility to make sure that delegates have a satisfactory understanding of the English language in terms of reading, writing, listening and spoken. Translators are not allowed. If you feel an English course is needed we recommend the course "English for Speakers of Other Languages" which can be found at <a href="http://www.cityofbristol.ac.uk">www.cityofbristol.ac.uk</a>.</strong></p>
				<p><strong>Please note</strong> that charges are applicable for cancellations and transfers (dates and venues) of courses as per our <a href="https://thetrainingsocieti.co.uk/terms-and-conditions/">terms and conditions</a>.</p>
				<p>I would like to take this opportunity to thank you very much for choosing The Training Societi Ltd. I trust that our service meets your expectations and that we will be able to help you with your future training requirements.</p>
				<p>If you have any questions regarding this booking please phone me direct on 0117 971 1892 option 2.</p>
				<p>Kind regards</p>
				<p><strong>Chaz Foulstone</strong></p>
				<p>01179 711 892 Option 2</p>
				<p><a href="mailto:bookings@thetrainingsocieti.co.uk">bookings@thetrainingsocieti.co.uk</a></p>
				<p><a href="https://thetrainingsocieti.co.uk/">www.thetrainingsocieti.co.uk</a></p>

<?php
/**
 * @hooked WC_Emails::email_footer() Output the email footer
 */
do_action( 'woocommerce_email_footer', $email );
