<form role="search" method="get" class="search-form row" action="<?php echo home_url( '/' ); ?>">
<?php
$search_placeholder = trim(get_field('search_placeholder'));
$search_placeholder = strip_tags($search_placeholder);
?>
    <label>
        <span class="screen-reader-text"><?php echo _x( 'Search for:', 'label' ) ?></span>
        <input type="search" class="search-field"
            placeholder="<?php echo $search_placeholder; ?>"
            value="<?php echo get_search_query() ?>" name="s"
            title="<?php echo esc_attr_x( 'Search for:', 'label' ) ?>" />
        <input type="hidden" name="post_type" value="courses"> 
    </label>

    <button type="submit" class="dashicons dashicons-search" value="<?php echo esc_attr_x( 'Search', 'submit button'); ?>"></button>

</form>