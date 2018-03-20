<?php
/**
 * Template part for displaying results in search pages.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Education
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <header class="entry-header">
        <?php the_title(sprintf('<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url(get_permalink())), '</a></h2>'); ?>
        <?php if ('post' === get_post_type()) : ?>
            <div class="entry-meta">
                <?php education_posted_on(); ?>
            </div><!-- .entry-meta -->
        <?php endif; ?>
    </header><!-- .entry-header -->
    <div class="entry-summary">
        <?php if (has_excerpt()) :
            the_excerpt();
        else:
            the_content( 
                /* translators: %s: Name of current post. */
                wp_kses( esc_html__( 'Continue reading', 'education' ) . ' <span class="meta-nav">'.(is_rtl()?'&larr;':'&rarr;').'</span>', array( 'span' => array( 'class' => array() ) ) )
            );
        endif; ?>
    </div><!-- .entry-summary -->
    <footer class="entry-footer">
        <?php education_entry_footer(); ?>
    </footer><!-- .entry-footer -->
</article><!-- #post-## -->
