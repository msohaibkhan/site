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
    <div class="container education-single-service">
        <div class="row">
            <main id="main" class="site-main">
            <?php
                while ( have_posts() ) : the_post();
                    get_template_part( 'template-parts/content', 'service' );
                endwhile; // End of the loop.
            ?>
                <?php if (is_active_sidebar( 'related-service' )) : ?>
                    <div class="education-related education-related-service">
                        <div class="nbtsow-related-title-widget">
                            <h2><?php echo esc_html__('Related Services', 'education')?></h2>
                        </div>
                        <div class="nbtsow-related-description">
                            <span class="education-divide"></span>
                        </div>
                        <?php dynamic_sidebar( 'related-service' ); ?>
                    </div>
                <?php endif;?>
            </main><!-- #main -->
            <?php get_sidebar(); ?>
		</div>
    </div>
</div><!-- #primary -->
	
<?php
get_footer();
