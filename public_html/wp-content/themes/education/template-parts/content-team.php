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
    <header class="entry-header education-team">
        <?php
        if ( is_single() ) : ?>
            <div class="education-team-header">
                <?php if (has_post_thumbnail()): ?>
                    <div class="entry-thumb education-team-single-thumb">
                        <?php the_post_thumbnail('education-team-single'); ?>
                    </div>
                <?php endif;?>
                <?php 
                the_title( '<h2 class="entry-title education-team-title">', '</h2>' );
                if( has_excerpt()):
                    the_excerpt();
                endif;
                ?>
            </div>
            <?php if (function_exists('get_field') && (get_field('social_login') || get_field('description') || get_field('information'))): ?>
                <div class="education-team-custom">
                    <?php if( get_field('social_login') ): 
                        the_field('social_login'); 
                    endif; 
                    if( get_field('description') ): 
                        the_field('description'); 
                    endif; 
                    if( get_field('information') ): 
                        the_field('information'); 
                    endif;  ?>
                </div>
            <?php endif; ?>
        <?php
        else :
            if (has_post_thumbnail()): ?>
                <div class="entry-thumb">
                    <?php the_post_thumbnail('education-team-thumb'); ?>
                </div>
            <?php endif;
            the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
        endif;
        if ( 'post' === get_post_type() ) : ?>
            <div class="entry-meta">
                <?php education_posted_on(); ?>
            </div><!-- .entry-meta -->
        <?php
        endif; ?>
    </header><!-- .entry-header -->
    <div class="clearfix"></div>
    <div class="entry-content education-team-content">
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
