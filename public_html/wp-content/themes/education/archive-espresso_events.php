<?php
/**
 * The template for displaying archive pages.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Education
 */
get_header(); ?>
    <div id="primary" class="content-area">
        <div class="container education-category-event">
            <div class="row">
                <main id="main" class="site-main">
                    <?php
                    if ( have_posts() ) : ?>
                        <header class="page-header">
                            <?php
                                the_archive_title( '<h2 class="page-title">', '</h2>' );
                                the_archive_description( '<div class="archive-description">', '</div>' );
                            ?>
                        </header><!-- .page-header -->
                        <div class="page-detail">
                            <?php
                            /* Start the Loop */
                            while ( have_posts() ) : the_post();
                                /*
                                 * Include the Post-Format-specific template for the content.
                                 * If you want to override this in a child theme, then include a file
                                 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
                                 */
                                get_template_part( 'template-parts/content', 'event');
                            endwhile;
                            ?>
                        </div>
                        <?php
                        the_posts_pagination( array(
                            'screen_reader_text' => '',
                            'prev_text'          => wp_kses('<i class="nbticon-chevron-thin-'.(is_rtl()?'right':'left').'"></i>', array('i' => array('class' => array()))),
                            'next_text'          => wp_kses('<i class="nbticon-chevron-thin-'.(is_rtl()?'left':'right').'"></i>', array('i' => array('class' => array()))),
                            'before_page_number' => '',
                        ) );
                    else :
                        get_template_part( 'template-parts/content', 'none' );
                    endif; ?>
                </main><!-- #main -->
                <?php get_sidebar(); ?>
            </div>
        </div>
    </div><!-- #primary -->
<?php
get_footer();
