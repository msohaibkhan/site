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
    <header class="entry-header gallery-header">
        <?php
        if (is_single()) :
            the_title('<h2 class="entry-title">', '</h2>');
        else :
            if (has_post_thumbnail()):
                ?>
                <div class="gallery-image">
                    <?php the_post_thumbnail('education-gallery-thumb'); ?>
                    <div class="gallery-link-image">
                        <a class="gallery-link" href="<?php echo esc_url(get_permalink()); ?>" rel="bookmark"><i class="nbticon-link2"></i></a>
                        <a class="gallery-items" href="<?php echo esc_url(the_post_thumbnail_url('full')); ?>" rel="bookmark"><i class="nbticon-fullscreen"></i></a>
                    </div>
                </div>
            <?php
            endif;
            the_title('<h2 class="entry-title"><a href="' . esc_url(get_permalink()) . '" rel="bookmark">', '</a></h2>');
        endif;
        ?>
    </header><!-- .entry-header -->
    <div class="entry-content gallery-content">
        <?php
        if ( is_archive() && has_excerpt() ) :
            the_excerpt();
        else :
            the_content( sprintf(
                /* translators: %s: Name of current post. */
                wp_kses( esc_html__( 'Continue reading %s', 'education' ) . ' <span class="meta-nav">'.(is_rtl()?'&larr;':'&rarr;').'</span>', array( 'span' => array( 'class' => array() ) ) ),
                the_title( '<span class="screen-reader-text">"', '"</span>', false )
            ) );
        endif;
        wp_link_pages(array(
            'before' => '<div class="page-links">' . esc_html__('Pages:', 'education'),
            'after' => '</div>',
        ));
        ?>
    </div><!-- .entry-content -->
</article><!-- #post-## -->