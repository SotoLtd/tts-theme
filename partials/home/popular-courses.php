<ul class="popular-courses">

    <?php
    // loop through the rows of data
    while ( have_rows( 'popular_courses' ) ) : the_row(); ?>

        <?php $postid = get_sub_field( 'course' ); ?>

        <li>
            <img src="<?php echo the_sub_field ('logo'); ?>">
            <a href="<?php echo get_the_permalink ( $postid );?>"><?php echo get_the_title ( $postid ); ?><span class="dashicons dashicons-arrow-right-alt2"></span></a>
        </li>

    <?php endwhile; ?>

</ul>