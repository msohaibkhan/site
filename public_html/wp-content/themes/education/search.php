<?php
/**
 * The template for displaying search results pages.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package Education
 */
get_header();
?>

<div id="primary" class="content-area">
    <div class="container education-search">
        <div class="row">
            <main id="main" class="site-main">
                <?php if (have_posts()) : ?>
                    <header class="page-header">
                        <h2 class="page-title"><?php printf(esc_html__('Search Results for: %s', 'education'), '<span>' . get_search_query() . '</span>'); ?></h2>
                    </header><!-- .page-header -->
                    <div class="education-search-list">
                        <?php
                        /* Start the Loop */
                        while (have_posts()) : the_post();

                            /**
                             * Run the loop for the search to output the results.
                             * If you want to overload this in a child theme then include a file
                             * called content-search.php and that will be used instead.
                             */
                            get_template_part('template-parts/content', 'search');

                        endwhile; ?>
                    </div>

                    <?php 
					the_posts_pagination( array(
						'screen_reader_text' => '',
						'prev_text' => wp_kses( '<i class="nbticon-chevron-thin-'.(is_rtl()?'right':'left').'"></i>', array('i' => array('class' => array())) ),
						'next_text' => wp_kses( '<i class="nbticon-chevron-thin-'.(is_rtl()?'left':'right').'"></i>', array('i' => array('class' => array())) ),
						'before_page_number' => '',
					) );
                else :
                    get_template_part('template-parts/content', 'none');
                endif;
                ?>
            </main><!-- #main -->
            <?php get_sidebar(); ?>
        </div>
    </div>
</div><!-- #primary -->
<?php
get_footer();