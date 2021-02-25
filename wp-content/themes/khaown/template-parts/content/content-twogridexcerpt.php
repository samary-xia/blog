<?php
/**
 * Template part for displaying post archives and search results
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package WordPress
 * @subpackage khaown
 * @since 1.0.0
 */
?>

	<div class="col-md-6  col-xs-12 khaown-article-container">
        <article id="post-<?php the_ID(); ?>" <?php post_class('mx8'); ?>>
            <div  class="feature bordered text-left bg-color-blog-posts feature px24 py24">
                <a id="post-<?php the_ID(); ?>" <?php post_class(); ?> href="<?php the_permalink(); ?>">
                    <?php if ( has_post_thumbnail() ) { ?>
                            <div class="blog-posts-image-holder">
                                <a id="post-<?php the_ID(); ?>" <?php post_class(); ?> href="<?php the_permalink(); ?>">
                                    <?php the_post_thumbnail(); ?>
                                </a>
                            </div>
                            <a id="post-<?php the_ID(); ?>" <?php post_class(); ?> href="<?php the_permalink(); ?>">
                                <header>
                                    <h1 class="my16 mb-xs-24">
                                        <?php the_title(); ?>
                                    </h1>
                                </header>
                                <div class="mb40">
                                    <?php the_excerpt(); ?>
                                    <a href="<?php the_permalink(); ?>"> <?php  _e('Read Details', 'khaown') ?></a>
                                </div>
                            </a>
                    <?php } else { ?>
                        <a id="post-<?php the_ID(); ?>" <?php post_class(); ?> href="<?php the_permalink(); ?>">
                            <header>
                                <h1 class="mb16 mb-xs-24">
                                    <?php the_title(); ?>
                                </h1>
                            </header>
                            <div class="mb40">
                                <?php the_excerpt(); ?>
                                <a href="<?php the_permalink(); ?>"> <?php  _e('Read Details', 'khaown') ?></a>
                            </div>
                        </a>
                    <?php } ?>
                </a>
            </div>
        </article><!-- #post-<?php the_ID(); ?> -->
    </div>

