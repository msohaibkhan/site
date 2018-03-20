<?php
/**
 * The template for displaying all single posts.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package Education
 */

get_header(); ?>
<div id="primary" class="content-area">
    <div class="container education-single-<?php echo get_post_type(); ?>">
        <div class="row">
            <main id="main" class="site-main">
                <?php
                while ( have_posts() ) :
                    the_post();
                    if (get_post_type()=='espresso_events'):
                        get_template_part( 'template-parts/content', 'event' );
                    else:
                        get_template_part( 'template-parts/content', get_post_format() );
                    endif;
                    // If comments are open or we have at least one comment, load up the comment template.
                    if ( comments_open() || get_comments_number() ) :
                            comments_template();
                    endif;
                endwhile; // End of the loop.
                ?>
            </main><!-- #main -->
            <?php get_sidebar(); ?>
        </div>
    </div>
</div><!-- #primary -->
<?php if (get_post_format()=='gallery' && is_active_sidebar( 'related-gallery') ) : ?>
    <div class="container education-related education-related-gallery">
        <div class="nbtsow-related-title-widget">
            <h2><?php echo esc_html__('Related images', 'education')?></h2>
        </div>
        <div class="nbtsow-related-description">
            <span class="education-divide"></span>
            <i class="nbticon-black-graduation-cap2"></i>
            <span class="education-divide"></span>
            <p><?php echo esc_html__('Some activities of funny courses', 'education') ?></p>
        </div>
        <?php dynamic_sidebar( 'related-gallery' ); ?>
    </div>
<?php endif; ?>
<?php
get_footer();
