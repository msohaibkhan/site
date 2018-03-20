<?php
/**
 * The template for displaying 404 pages (not found).
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package Education
 */
get_header();
?>

<div id="primary" class="content-area">
    <main id="main" class="site-main">
        <section class="error-404 not-found">
            <header class="page-header">
                <div class="container">
                    <h2 class="page-title"><?php echo esc_html__('404', 'education'); ?></h2>
                    <h3><?php echo esc_html__('Oops!! We Couldn&rsquo;t find the page you were looking for', 'education'); ?></h3>
                    <p><a href="<?php echo get_home_url(); ?>"><?php echo esc_html__('Back to home page', 'education'); ?></a></p>
                </div>
            </header><!-- .page-header -->
        </section><!-- .error-404 -->
    </main><!-- #main -->
</div><!-- #primary -->

<?php
get_footer();
