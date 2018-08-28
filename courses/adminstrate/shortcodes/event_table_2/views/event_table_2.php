<?php 
/* 
	Event table 1 template
*/
$class_course_code     = 'administrate-event-table-course-code';
$class_course_name     = 'administrate-event-table-course-name';
$class_course_location = 'administrate-event-table-course-location';
$class_course_link     = 'administrate-event-table-course-link';
if($this->service->debug) {
	var_export("Debug Mode");
}
?>
<div id="administrate-event-table" class="administrate-widget administrate-sort-filter-table">
    <?php include($this->wpath . 'views/options_form.php'); ?>
    <table cellspacing="0" <?php if( $show_prices ) { echo "class='administrate-event-table-pricing-table'"; } ?> <?php if( $group_size > 0 ) { echo "data-group-size='{$group_size}'"; } ?> >
        <thead>
            <tr>
                <th scope="col"><?php _e('Dates', 'administrate'); ?></th>
                <th scope="col" style="width: 40px;"><?php _e('Days', 'administrate'); ?></th>
                <th scope="col"><?php _e('Price per Person *', 'administrate'); ?></th>
                <th scope="col"><?php _e('Location', 'administrate'); ?></th>
                <th scope="col"><?php _e('Status', 'administrate'); ?></th>
            </tr>
        </thead>
        <tbody>
        <?php
        foreach ($event_list as $event) {
            extract( $this->event_data($event) );
			
            if( $months_until_start > $num_months ) { 
                continue;
            }
            $days = $event->get_course_duration();
            
            $linked_course = get_linked_course($event->get_course_code());
            if($linked_course){
                $course_title = get_the_title($linked_course->ID);
                $courseUrl = get_permalink($linked_course->ID);
            }else{
                $course_title =$event->get_course_title();
                $courseUrl = $this->service->get_widget_url_course($event->get_course_code());
            }
            $days = $event->get_course_duration();
            if($days>1){
                $date_string_formatted = '<span>'.date('D j M', $dates['start']) .'</span> - <span>' . date('D j M', $dates['end']) . '</span>';
            }else{
                $date_string_formatted = date('D j M', $dates['start']);
            }
        ?>
            <tr data-event-id="<?= $event->get_id(); ?>" data-categories="<?= $categories_str; ?>" data-subcategories="<?= $subcategories_str; ?>" data-num-months="<?= $months_until_start; ?>" data-location="<?= $event->get_location(); ?>" data-currencies="<?= $currencies_str ?>" data-event-default-currency="<?= $event_currency ?>" >
                <td><?php echo $date_string_formatted; ?></td>
                <td><?php echo $days; ?></td>
                <td><?php echo $this->service->t_prices($event, $basis, $currency, $show_currency_indicator, $currency_indicator, $currency_list); ?></td>
                <td><?php echo $event->get_location(); ?></td>
                <td class="tts-admin-booking-status">
                    <?php 
                    $show_locations = $show_dates = true;
                    include( $this->wpath . "views/registration.php" ); 
                    ?>
                </td>
            </tr>
        <?php
        }
        ?>
        </tbody>
    </table>
	<div class="tts-post-script-note"><p>*prices subject to 20% VAT</p></div>
    <div class="administrate-no-rows"><?php echo str_replace('0117 971 1892', '<a href="tel:0117 971 1892">0117 971 1892</a>', $no_events_message); ?></div>
    <p class="administrate-footer">
            <a rel="nofollow" href="http://www.GetAdministrate.com/" target="_blank"><?php _e('Powered by'); ?> <img alt="Administrate" src="<?php echo  $logo_url; ?>"> <span><?php _e('Software for Training Providers'); ?></span></a>
    </p>
    <?php if( $group_size > 0 ) { ?>
        <div id="administrate-event-table-pager">
            <a href="#" class="administrate-event-table-pager-first" title="<?php _e('first group'); ?>">&laquo;</a>
            <a href="#" class="administrate-event-table-pager-previous" title="<?php _e('previous group'); ?>">&lsaquo;</a>
            <span class="administrate-event-table-pager-status"></span>
            <a href="#" class="administrate-event-table-pager-next" title="<?php _e('next group'); ?>">&rsaquo;</a>
            <a href="#" class="administrate-event-table-pager-last" title="<?php _e('last group'); ?>">&raquo;</a>
        </div>
    <?php } ?>
    <?php 
    $logo_url = $this->service->get_resource_url('images/logo-public.png');
    ?>

</div>