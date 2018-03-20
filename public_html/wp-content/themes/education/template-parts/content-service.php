<?php
/**
 * Template part for displaying posts.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Education
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <header class="entry-header">
        <?php
        if ( is_single() ) :
            the_title( '<h2 class="entry-title">', '</h2>' );
        else :
            if (has_post_thumbnail()): ?>
                <div class="entry-thumb">
                    <a href="<?php echo esc_url( get_permalink() ); ?>" rel="bookmark">
                        <?php the_post_thumbnail('education-service-thumb'); ?>
                    </a>
                </div>
            <?php endif;
            the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
        endif; ?>
    </header><!-- .entry-header -->

    <div class="entry-content">
        <?php
        if ( is_archive() && has_excerpt() ) :
            the_excerpt();
        else :
            the_content( 
                /* translators: %s: Name of current post. */
                wp_kses( esc_html__( 'Continue reading', 'education' ) . ' <span class="meta-nav">'.(is_rtl()?'&larr;':'&rarr;').'</span>', array( 'span' => array( 'class' => array() ) ) )
            );
        endif;
        wp_link_pages( array(
            'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'education' ),
            'after'  => '</div>',
        ) );
        ?>
    </div><!-- .entry-content -->
</article><!-- #post-## -->
