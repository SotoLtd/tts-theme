<?php /* 
	Event table options template
*/ ?>
<form><p>
	
	<?php if( $show_categories ) { ?>
	<span>
		<?php _e('Show'); ?>
		
			<select name="administrate-event-table-category" id="administrate-event-table-category">
				<option value=""><?php _e('All Events'); ?></option>
					
				<?php foreach( $categories_list as $category ) { ?>
				
					<?php
					if ($this->service->is_hidden('category', $category->get_id())) {
						continue;
					} ?>
				
					<?php $id_str = $category->get_id().':0'; ?>
				
					<option value="<?= $id_str; ?>" <?php if ($id_str == $cat_id) { echo "selected"; } ?> >
						<?= $category->get_name(); ?>
					</option>
				
				<?php $subcat_list = $category->get_subcategories(); ?>
				
				<?php foreach( $subcat_list as $subcategory ) { ?>
					<?php if ($this->service->is_hidden('subcategory', $subcategory->get_id())) {
						continue;
					} ?>
					<?php $sub_id = $category->get_id() . ':' . $subcategory->get_id(); ?>
					<option value="<?= $sub_id; ?>" <?php if( $sub_id == $cat_id ) { echo "selected"; } ?> >
						&nbsp; &ndash; <?= $subcategory->get_name(); ?>
					</option>
				<?php } ?>
					
			<?php } ?>
		</select>
	</span>
	<?php } ?>

	<span>
		<?php _e( $show_categories ? 'in the next' : 'Show the next'); ?>
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
	
	<span>
		<?php _e('in'); ?> <span class="tts-orrange-styled">Bristol</span>
		
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
		
		<select  style="display:none;" name="administrate-currency-select" id="administrate-currency-select" class="administrate-currency-select">
			<option value="all">All Currencies</option>
			
			<?php foreach( $currency_list as $currency_name => $processor_name) { ?>
			<option value="<?=$currency_name?>"><?=$currency_name?></option>
			<?php } ?>
			
		</select>
		<?php } ?>
	</span>

</p></form>
