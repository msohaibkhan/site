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
    <?php if (has_post_thumbnail()): ?>
        <div class="entry-thumb education-team-background">
            <?php the_post_thumbnail('education-team-single'); ?>
        </div>
    <?php endif;?>
    <div class="container education-single-team">
        <div class="row">
            <main id="main" class="site-main">
                <?php
                while ( have_posts() ) : the_post();

                    get_template_part( 'template-parts/content', 'team' );

                endwhile; // End of the loop.
                ?>
            </main><!-- #main -->
            <?php get_sidebar(); ?>
        </div>
    </div>
</div><!-- #primary -->
<?php if (is_active_sidebar( 'related-team' )) : ?>
    <div class="container education-related education-related-team">
        <div class="nbtsow-related-title-widget">
            <h2><?php echo esc_html__('Related team', 'education')?></h2>
        </div>
        <div class="nbtsow-related-description">
            <span class="education-divide"></span>
            <i class="nbticon-black-graduation-cap2"></i>
            <span class="education-divide"></span>
            <p><?php echo esc_html__('Meet our excellent founders.They have a lot of experience in online education', 'education') ?>.</p>
        </div>
        <?php dynamic_sidebar( 'related-team' ); ?>
    </div>
<?php endif;?>	
<?php
get_footer();
