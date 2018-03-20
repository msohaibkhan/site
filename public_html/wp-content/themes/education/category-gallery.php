<?php
/**
 * The template for displaying archive pages.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Education
 */
get_header();?>
<div id="primary" class="content-area container">
    <div class="row">
        <main id="main" class="site-main">
            <?php
            if (have_posts() ) : ?>
                <header class="page-header">
                    <div class="text-center education-gallery-category">
                        <h2><?php echo esc_html__('Our all activities', 'education'); ?></h2>
                        <p>
                            <span class="education-divide"></span>
                            <i class="nbticon-black-graduation-cap2"></i>
                            <span class="education-divide"></span>
                        </p>
                        <p><?php echo esc_html__('Images, Videos, Events, Students, Teachers...', 'education'); ?></p>
                    </div>
                </header><!-- .page-header -->
                <?php
                /* Start the Loop */
                while (have_posts() ) :the_post();
                    /*
                     * Include the Post-Format-specific template for the content.
                     * If you want to override this in a child theme, then include a file
                     * called content-___.php (where ___ is the Post Format name) and that will be used instead.
                     */
                    get_template_part( 'template-parts/content', get_post_format() );
                endwhile;
				the_posts_pagination( array(
					'screen_reader_text' => '',
					'prev_text' => wp_kses('<i class="nbticon-angle-'.(is_rtl()?'right':'left').'"></i>', array('i' => array('class' => array()))),
					'next_text' => wp_kses('<i class="nbticon-angle-'.(is_rtl()?'left':'right').'"></i>', array('i' => array('class' => array()))),
					'before_page_number' => '',
				) );
            else :
                get_template_part( 'template-parts/content', 'none' );
            endif; ?>
        </main><!-- #main -->
        <?php get_sidebar(); ?>
    </div>
</div><!-- #primary -->
<?php
get_footer();
