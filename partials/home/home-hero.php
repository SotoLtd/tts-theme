<div class="hero-section">
	<?php
	$search_title = trim(get_field('search_title'));
	$search_title = wp_kses($search_title, array(
		'span' => array('class' => array(), 'style' => array()),
		'em' => array('class' => array(), 'style' => array()),
		'strong' => array('class' => array(), 'style' => array()),
		'a' => array('class' => array(), 'style' => array(), 'href' => array(), 'target' => array()),
	));
	?>
	<div class="center hero-overlay">
        <?php if($search_title): ?>
        <h2><?php echo $search_title; ?></h2>
        <?php endif; ?>
        <?php get_template_part( 'partials/home/searchform' ); ?>
	</div>

</div>

<div class="hero-subheading">
    <?php
    $subheading_title = trim(get_field('subheading_title'));
    $subheading_subtitle = trim(get_field('subheading_subtitle'));
    $subheading_title = wp_kses($subheading_title, array(
	    'span' => array('class' => array(), 'style' => array()),
	    'em' => array('class' => array(), 'style' => array()),
	    'strong' => array('class' => array(), 'style' => array()),
	    'a' => array('class' => array(), 'style' => array(), 'href' => array(), 'target' => array()),
    ));
    $subheading_subtitle = wp_kses($subheading_subtitle, array(
	    'span' => array('class' => array(), 'style' => array()),
	    'em' => array('class' => array(), 'style' => array()),
	    'strong' => array('class' => array(), 'style' => array()),
	    'a' => array('class' => array(), 'style' => array(), 'href' => array(), 'target' => array()),
    ));
    ?>

        <?php if($subheading_title): ?>
        <h2><?php echo $subheading_title; ?></h2>
        <?php endif; ?>
        <?php if($subheading_subtitle): ?>
        <p><?php echo $subheading_subtitle; ?></p>
        <?php endif; ?>
       

</div>
