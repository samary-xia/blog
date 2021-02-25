<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package new_blog
 */

?>

</div><!-- #content -->

	<footer id="colophon" class="site-footer">
    <section>
      <div class="instagram">
        <div class="row">
        <?php if(absint(get_theme_mod('new_blog_footer_slider_enable','1'))==1): ?>

          <?php $args = array( 
            'post_type' => 'post',
            'category_name' => esc_attr(get_theme_mod('new_blog_footer_slider_categorylist','')),
            'orderby' => array( esc_attr(get_theme_mod('new_blog_footer_slider_order', 'date')) => 'DSC', 'date' => 'DSC'),
            'order'     => 'DSC',
            'posts_per_page' => absint(get_theme_mod( 'new_blog_footer_slider_noofpost','7' )),
            'ignore_sticky_posts' => 1,
            );
              $listings = new WP_Query( $args );
            if ( $listings->have_posts() ) :

            /* Start the Loop */
            while ( $listings->have_posts() ) :
                $listings->the_post();	
          ?> <div class="col-md-2">
                <?php
                if ( ! has_post_thumbnail() ) {
                  if ( absint(get_theme_mod('new_blog_footer_slider_post_taxonomy_UseBlankImage','1')) == 1) { 

                  ?>
                  <div>
                    <img  src = "<?php echo esc_url( get_template_directory_uri() ); ?>/images/woman-3208045_1920-240x200.jpg " >
                  </div>
                  <?php }
                } else if ( has_post_thumbnail() ) {
                  new_blog_footer_thumbnail();
                }
                ?>              
              </div>
            <?php endwhile;
            wp_reset_postdata();
            else :
            get_template_part( 'template-parts/content', 'none' );
            endif;
        endif; ?>
        </div>
      </div>
      <div class="info-content">
        <div class="container-fluid">
          <div class="row">
            <div class="col-md-4">
              <?php if(absint(get_theme_mod('new_blog_footer_title','1'))==1) : ?>
              <div class="f-about">
                <div class="logo">
                  <p class="site-title logo"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a><p>
                </div>
              </div>
              <?php endif; ?>
            </div>
            <div class="col-md-4">
            <?php get_sidebar( 'footer-1' );?>
            </div>
            <div class="col-md-4">
            <?php get_sidebar( 'footer-2' );?>
            </div>
          </div>
        </div>
      </div>
      <div class="site-info copyright">
        <div class="container">

          <a href="<?php echo esc_url( __( 'https://wordpress.org/', 'new-blog' ) ); ?>">
            <?php
            /* translators: %s: CMS name, i.e. WordPress. */
            printf( esc_html__( 'Proudly powered by %s', 'new-blog' ), 'WordPress' );
            ?>
          </a>
          <span class="sep "> | </span>
            <?php
            /* translators: 1: Theme name, 2: Theme author. */
            printf( esc_html__( 'Theme : %2$s : by :  %1$s', 'new-blog' ), '<a href="https://www.postmagthemes.com" target="_blank" > Postmagthemes </a>' , '<a href="https://www.postmagthemes.com/downloads/new-blog-a-free-wordpress-theme/" target="_blank">New Blog a free WordPress theme </a>' );

            if (absint(get_theme_mod('new_blog_social_bottom_enable','0'))==1) : ?>
              <ul class="social-icon ml-auto">
                <?php if(absint(get_theme_mod('new_blog_facebook_url_enable','1'))==1) : ?>
                  <li><a href="<?php echo esc_url(get_theme_mod( 'new_blog_social_url_'.'Facebook'))?>"target="_blank"><span class="fa fa-facebook" aria-hidden="true"></span></a></li>
                <?php endif ; ?>
                <?php if(absint(get_theme_mod('new_blog_twitter_url_enable','1'))==1) : ?>
                  <li><a href="<?php echo esc_url(get_theme_mod( 'new_blog_social_url_'.'Twitter'))?>"target="_blank"><span class="fa fa-twitter" aria-hidden="true"></span></a></li>
                <?php endif ; ?>
                <?php if(absint(get_theme_mod('new_blog_youtube_url_enable','1'))==1) : ?>
                  <li><a href="<?php echo esc_url(get_theme_mod( 'new_blog_social_url_'.'Youtube'))?>"target="_blank"><span class="fa fa-youtube" aria-hidden="true"></span></a></li>
                <?php endif ; ?>
                <?php if(absint(get_theme_mod('new_blog_pinterest_url_enable','1'))==1) : ?>
                  <li><a href="<?php echo esc_url(get_theme_mod( 'new_blog_social_url_'.'Pinterest'))?>"target="_blank"><span class="fa fa-pinterest" aria-hidden="true"></span></a></li>
                <?php endif ; ?>
              </ul>
            <?php endif ; ?>
        </div>
      </div><!-- .site-info -->
    </section>
	</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
