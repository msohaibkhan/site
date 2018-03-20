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
                    get_template_part( 'template-parts/content-type', get_post_type() );
                    the_post_navigation();
                endwhile; // End of the loop.
                ?>
            </main><!-- #main -->
            <?php get_sidebar(); ?>
        </div>
    </div>
    <?php if (is_active_sidebar( 'related-course' )) : ?>
        <div class="education-related education-related-course">
            <div class="nbtsow-related-title-widget">
                <h2><?php echo esc_html__('Related Course', 'education')?></h2>
            </div>
            <div class="nbtsow-related-description">
                <span class="education-divide"></span>
                <i class="nbticon-black-graduation-cap2"></i>
                <span class="education-divide"></span>
                <p><?php echo esc_html__('Meet our excellent founders.They have a lot of experience in online education.', 'education') ?></p>
            </div>
            <?php dynamic_sidebar( 'related-course' ); ?>
        </div>
    <?php endif;?>
</div><!-- #primary -->
<?php
get_footer();
