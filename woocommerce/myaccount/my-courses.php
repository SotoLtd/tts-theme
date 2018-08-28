<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
$page_title = __('My Account', TBS_i18n::get_domain_name()) . ': <span>' . __('Courses', TBS_i18n::get_domain_name()) . '</span>';

?>

<h1><?php echo $page_title; ?></h1>

<?php 
foreach($delegates as $course_date_id => $course_date_delegates): 
	$course_date = new TBS_Course_Date($course_date_id);
	if(!$course_date->exists()){
		continue;
	}
	if(!is_array($course_date_delegates) || count($course_date_delegates) == 0){
		continue;
	}
?>

	<h4 class="order-course-date-title"><a href="<?php echo $course_date->get_course_permalink() ?>"><?php echo $course_date->get_course_title_with_date(); ?></a></h4>
	<table class="woocommerce-table woocommerce-table--order-details shop_table order_details order-delegates-table">
		<thead>
			<tr>
				<th style="width:15px;">&nbsp;</th>
				<th>Name</th>
				<th>Email</th>
				<th>Notes</th>
			</tr>
		</thead>
		<tbody>
		<?php 
		$serial_no = 0;
		foreach ($course_date_delegates as $delegate_id):
			$delegate = new TBS_Delegate($delegate_id);
			if(!$delegate->exists()){
				continue;
			}
			$serial_no++;
		?> 
		<tr>
			<td style="width:15px;"><?php echo $serial_no; ?>.</td>
			<td><?php echo esc_html($delegate->get_full_name()); ?></td>
			<td><?php if($delegate->has_email()): ?><a class="wcma-delegate-email" href="<?php echo esc_url($delegate->get_email()); ?>"><?php echo $delegate->get_email(); ?></a><?php endif; ?></td>
			<td><?php echo esc_html($delegate->get_notes()); ?></td>
		</tr>
		<?php endforeach;?> 
		</tbody>
	</table>


<?php endforeach; ?>
