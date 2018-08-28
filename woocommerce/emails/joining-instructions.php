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

$location = $course_date->get_location();

/**
 * @hooked WC_Emails::email_header() Output the email header
 */
do_action( 'woocommerce_email_header', $email_heading, $email ); ?>
<p style="font-size: 13px;line-height: 20px;">Thank you very much for your completed booking form, I am very pleased to confirm the booking of the below course:</p>
<table class="td" cellspacing="0" cellpadding="6" style="width: 100%; font-family: 'Helvetica Neue', Helvetica, Roboto, Arial, sans-serif; margin-bottom: 15px;" border="1">
		<tbody>
			<tr>
				<td class="td" scope="col" style="text-align:left;vertical-align: top;font-size: 13px;font-weight: bold;line-height: 20px;">Course:</th>
				<td class="td" scope="col" style="text-align:center;vertical-align: top;font-size: 13px;"><?php echo $course_date->get_course_title(); ?></td>
			</tr>
			<tr>
				<td class="td" scope="col" style="text-align:left;vertical-align: top;font-size: 13px;font-weight: bold;line-height: 20px;">Date:</th>
				<td class="td" scope="col" style="text-align:center;vertical-align: top;font-size: 13px;line-height: 20px;"><?php echo $course_date->get_date_formatted(); ?></td>
			</tr>
			<tr>
				<td class="td" scope="col" style="text-align:left;vertical-align: top;font-size: 13px;font-weight: bold;line-height: 20px;">Duration:</th>
				<td class="td" scope="col" style="text-align:center;vertical-align: top;font-size: 13px;line-height: 20px;"><?php echo $course_date->get_duration_formatted(); ?></td>
			</tr>
			<?php if($location): ?>
			<tr>
				<td class="td" scope="col" style="text-align:left;vertical-align: top;font-size: 13px;font-weight: bold;line-height: 20px;">Venue:</th>
				<td class="td" scope="col" style="text-align:center;vertical-align: top;font-size: 13px;line-height: 20px;"><?php echo wpautop($location->full_address); ?></td>
			</tr>
			<?php endif; ?>
			<?php if($course_date->get_start_finish_time()): ?>
			<tr>
				<td class="td" scope="col" style="text-align:left;vertical-align: top;font-size: 13px;font-weight: bold;line-height: 20px;">Start/finish time:</th>
				<td class="td" scope="col" style="text-align:center;vertical-align: top;font-size: 13px;line-height: 20px;">
					<p><?php echo $course_date->get_start_finish_time(); ?></p>
					<p>Please ensure you arrive in good time as we cannot accept delegates who are more than 15 minutes late due to regular auditing from official bodies.</p>
				</td>
			</tr>
			<?php endif; ?>
			<tr>
				<td class="td" scope="col" style="text-align:left;vertical-align: top;font-size: 13px;font-weight: bold;line-height: 20px;">Joining Instructions:</th>
				<td class="td" scope="col" style="text-align:left;vertical-align: top;font-size: 13px;line-height: 20px;">
					<?php echo $joining_istructions; ?>
				</td>
			</tr>
		</tbody>
	</table>
<p style="font-size: 13px;line-height: 20px;">On successful completion of course each delegate will receive an attendance certificate and photo card (if supplied) approximately 4 weeks after the course has been completed.  For CITB courses this may be 8 weeks.</p>
<p style="font-size: 13px;line-height: 20px;">We welcome all delegates from all nationalities who want to learn and grow with us.  However, as per our terms and conditions, please note that it is the bookers responsibility to make sure that delegates have a satisfactory understanding of the English language in terms of reading, writing, listening and spoken.  Translators are not allowed.  If you feel an English course is needed we recommend the course "English for Speakers of Other Languages" which can be found at <a href="http://www.cityofbristol.ac.uk">www.cityofbristol.ac.uk</a>.</p>
<p style="font-size: 13px;line-height: 20px;">Please note that charges are applicable for cancellations and transfers (dates and venues) of courses as per our <a href="https://thetrainingsocieti.co.uk/terms-and-conditions/">terms and conditions</a>.</p>
<p style="font-size: 13px;line-height: 20px;">I would like to take this opportunity to thank you very much for choosing The Training Societi Ltd.  I trust that our service meets your expectations and that we will be able to help you with your future training requirements.</p>
<p style="font-size: 13px;line-height: 20px;">If you have any questions regarding this booking please phone me direct on 0117 971 1892 option 2.</p>	
<p style="font-size: 13px;line-height: 20px;">Kind regards</p>
<p style="font-size: 13px;line-height: 20px;"><strong>Chaz Foulstone</strong></p>
<p style="font-size: 13px;line-height: 20px;">01179 711 892 Option 2</p>
<p style="font-size: 13px;line-height: 20px;"><a href="mailto:bookings@thetrainingsocieti.co.uk">bookings@thetrainingsocieti.co.uk</a></p>
<p style="font-size: 13px;line-height: 20px;"><a href="https://thetrainingsocieti.co.uk/">www.thetrainingsocieti.co.uk</a></p>
<?php
/**
 * @hooked WC_Emails::email_footer() Output the email footer
 */
do_action( 'woocommerce_email_footer', $email );
