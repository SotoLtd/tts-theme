<?php /* 
	Registration button template
*/ ?>

<?php if( $event->is_sold_out() ) { ?>

	<span class="administrate-event-table-sold-out orrange"><?php _e('Sold Out'); ?></span>

<?php } else { ?>

	<?php
	$registration_enabled = (bool) ( $event->registration_available() && !empty($checkout_page) );
	$registration_url = $this->service->get_widget_url_checkout( $event->get_id(), $event_currency );
	?>
		
	<?php if( $registration_enabled ) { ?>
		<a href="<?= $registration_url ?>" class="administrate-event-table-register-link book-now-button orrange"><?php _e('Book Now'); ?></a>
	<?php } ?>
			
	<span class="administrate-event-table-places-left">
		<?php if( $show_remaining_places && ($event->get_num_places()!==null) ) {
			switch($event->get_num_places())
			{
				case 0:_e("No Places Available"); break;
				case 1:_e("1 Place Available"); break;
				default: echo $event->get_num_places(). " " ._("Places Available");
			} 
		}
		else {
			_e($registration_enabled ? 'Available' : 'No Places Available');
		} ?>
	</span>

<?php } ?>
