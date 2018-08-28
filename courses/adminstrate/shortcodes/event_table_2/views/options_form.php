<?php /* 
	Event table options template
*/ ?>
<form><p>
	
	<?php if( $show_categories ) { ?>
            <input type="hidden"  name="administrate-event-table-category" id="administrate-event-table-category" value="">
	<?php } ?>

	<span>
		<?php _e('Show events in the next'); ?>
		<select name="administrate-event-table-month" id="administrate-event-table-month">
			<option value="3" <?php if( 3 == $num_saved_months ) { echo "selected"; } ?> >3</option>
			<option value="6" <?php if( 6 == $num_saved_months ) { echo "selected"; } ?> >6</option>
			<option value="12" <?php if( 12 == $num_saved_months ) { echo "selected"; } ?> >12</option>
			<?php 
			if( $num_months > 12 ) { 
                            $last_option_byond12 = (int)3 * ceil($num_months/3)
                            ?> 
                            <option value="<?php echo $last_option_byond12; ?>" <?php if( $last_option_byond12 == $num_saved_months ) { echo "selected"; } ?> ><?php echo $last_option_byond12; ?></option>
                        <?php } ?>
		</select>
		<?php _e('months'); ?>
	</span>
	
	<span style="display:none;">
		<select style="display:none;" name="administrate-event-table-location" id="administrate-event-table-location">
		<option value=""><?php _e('All Locations'); ?></option>
				
		<?php foreach( $locations_list as $location ) { ?>
			<?php if( is_string($location) ) { ?>
				<option value="<?= $location; ?>" <?php if( $location == $location_name ) { echo "selected"; } ?> >
					<?= $location; ?>
				</option>
			<?php } else { ?>
				<option value="<?= $location->get_name(); ?>" <?php if( $location->get_name() == $location_name ) { echo "selected"; } ?> >
					<?= $location->get_name(); ?><?php _e(','); ?> <?= $location->get_country(); ?>
				</option>
			<?php } ?>
		<?php } ?>
		</select>
		
		<?php /* Currency List*/ ?>
		<?php if( $currency_list ) { ?>
                 <input type="hidden"  name="administrate-currency-select" id="administrate-currency-select" value="">
		<?php } ?>
	</span>

</p></form>
