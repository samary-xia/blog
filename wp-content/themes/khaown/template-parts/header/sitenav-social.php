<nav class="social-navigation" aria-label="<?php echo esc_attr_e( 'Social Links Menu', 'khaown' ); ?>">
    <?php
    wp_nav_menu(
        array(
            'theme_location' => 'social',
            'menu_class'     => 'social-links-menu',
            'link_before'    => '<span class="screen-reader-text">',
            'link_after'     => '</span>' . khaown_get_icon_svg( 'link' ),
            'depth'          => 1,
        )
    );
    ?>
</nav><!-- .social-navigation -->
