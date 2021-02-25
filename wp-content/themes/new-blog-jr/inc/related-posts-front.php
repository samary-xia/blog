<section>
    <?php 
    $new_blog_jr_categories = get_the_category($post->ID);
    if ($new_blog_jr_categories) {
    $new_blog_jr_category_ids = array();
    foreach($new_blog_jr_categories as $new_blog_jr_individual_category) $new_blog_jr_category_ids[] = $new_blog_jr_individual_category->term_id;
    $new_blog_jr_args=array(
    'category__in' => $new_blog_jr_category_ids,
    'orderby' => array( esc_attr(get_theme_mod('pro_new_blog_related_post_order', 'date')) => 'DSC', 'date' => 'DSC'),
    'post__not_in' => array($post->ID),
    'posts_per_page'=> 4, // Number of related posts that will be shown.
    'ignore_sticky_posts'=>1
    );

    $new_blog_jr_my_query = new wp_query( $new_blog_jr_args );
    if( $new_blog_jr_my_query->have_posts() ) { ?> 
    <div class="related-posts-front mt-4 mb-5">
        <div class="title-holder text-center other-title">
            <h2><?php echo esc_html(get_theme_mod('pro_new_blog_related_post_title',__('Related posts','new-blog-jr'))); ?></h2>
        </div>
        <div class="row">
        <?php while( $new_blog_jr_my_query->have_posts() ) {
            $new_blog_jr_my_query->the_post();?>
            <div class="col-lg-12">
                <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                    <div class="card">
                    
                    <?php 
                        if ( ! has_post_thumbnail() ) {
                            if ( get_theme_mod('pro_new_blog_related_post_post_taxonomy_UseBlankImage','1') ==1) { ?>
                            
                            <div>
                                <img  class="card-img-top" src = "<?php echo esc_url( get_template_directory_uri() ); ?>/images/baby-887833_1920-360x250.jpg " >
                            </div>
                            <?php } 
                            
                        } else if ( has_post_thumbnail() ) {
                            new_blog_post_thumbnail();
                        } 
                    ?>
                        <div class="card-body">
                            <header class="entry-header">
                                <?php the_title( '<h3 class="entry-title related-posts-front-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h3>' ); ?>
                            </header>
                        
                        </div>
                    </div>
                </article><!-- #post-<?php the_ID(); ?> -->
            </div>
        <?php }
       ?>
        </div>
    </div>
    <?php }
     wp_reset_postdata(); 
    }
    
    ?></section>