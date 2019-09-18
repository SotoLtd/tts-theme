<?php
// Prevent direct access
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}
$home_logos_enable = get_field( 'home_logos_enable' );
$home_logos_section_title = trim(get_field( 'home_logos_section_title' ));


if ( $home_logos_enable && have_rows( 'home_logos' ) ):
	?>
    <section class="row">
        <div class="tts-home-logos-wrap">
            <?php if($home_logos_section_title): ?>
            <div class="tts-home-logos-title"><?php echo $home_logos_section_title; ?></div>
            <?php endif; ?>
            <ul class="tts-home-logos">
				<?php
				while ( have_rows( 'home_logos' ) ):
					the_row();
					$logo_image = get_sub_field( 'logo' );
					$logo_link  = trim( get_sub_field( 'link' ) );
					if ( ! $logo_image ) {
						continue;
					}
					?>
                    <li>
						<?php if ( $logo_link ): ?><a href="<?php echo esc_url( $logo_link ); ?>"
                                                      target="_blank"><?php endif; ?>
                            <img src="<?php echo $logo_image; ?>" alt="">
							<?php if ( $logo_link ): ?></a><?php endif; ?>
                    </li>
				<?php endwhile; ?>
            </ul>
        </div>
    </section>
<?php endif; ?>
