<?php $group = get_field ( $fieldgroup ); 

// check that we have some fields to output 
if ( $group ) : ?>

    <?php 
    $title = 'title'; 
    $course_links = 'course_links';
    $category_link = 'category_link';
    ?>

    <?php if ( $group[$title] ) : ?>

        <h2><?php echo $group[$title]; ?></h2>

    <?php endif; ?>

    <?php $courselinks = $group[ $course_links ]; ?>

    <?php if ( $courselinks ) : ?>

        <ul>

            <?php
            // loop through the rows of data
            foreach ( $courselinks as $course ) : ?>

                <?php $postid = $course['course']->ID; ?>

                <li>
                    <a href="<?php echo get_the_permalink ( $postid );?>"><?php echo get_the_title ( $postid ); ?></a>
                </li>

            <?php endforeach; ?>

        </ul>

    <?php endif ?>

    <?php if ( $group[ $category_link ] ) : ?>

        <p><a href="<?php echo $group[ $category_link ]; ?>">View all <?php echo $group[$title]; ?> courses</a></p>
        
    <?php endif ?>


<?php endif ?>