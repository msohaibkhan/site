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
            if (has_post_thumbnail()): ?>
                <div class="entry-thumb">
                    <?php the_post_thumbnail(); ?>
					<?php // get_template_part( 'learndash/course_media'); ?>
                </div>
            <?php endif;
        else :
            if (has_post_thumbnail()): ?>
                <div class="entry-thumb">
                    <a href="<?php echo esc_url( get_permalink() ); ?>" rel="bookmark">
                        <?php the_post_thumbnail('education-course-thumb'); ?>
                    </a>
                </div>
            <?php endif;
        endif; ?>
    </header><!-- .entry-header -->

    <div class="entry-course">
        <?php
        if ( is_archive() ) :
            the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' ); ?>
            <?php if (get_post_meta(get_the_ID(),'_courses_date_start', true) || get_post_meta(get_the_ID(),'_nbt_time_start', true) || get_post_meta(get_the_ID(),'_nbt_time_end', true)) : ?>
                <div class="education-course-info">
                    <?php if (get_post_meta(get_the_ID(),'_courses_date_start', true)): ?>
                        <span class="education-course-date">
                            <span class="nbticon nbticon-calendar"></span>
                            <?php echo date(get_option('date_format'),strtotime(get_post_meta(get_the_ID(),'_courses_date_start', true))); ?>
                        </span>
                    <?php endif; ?>
                    <?php if (get_post_meta(get_the_ID(),'_nbt_time_start', true) || get_post_meta(get_the_ID(),'_nbt_time_end', true)) : ?>
                        <span class="education-course-time">
                            <span class="nbticon nbticon-schedule-button"></span>
                            <?php
                            if (get_post_meta(get_the_ID(),'_nbt_time_start', true)):
                                printf(esc_html__('%s','education'), get_post_meta(get_the_ID(),'_nbt_time_start', true));
                            endif;
                            if (get_post_meta(get_the_ID(),'_nbt_time_start', true) || get_post_meta(get_the_ID(),'_nbt_time_end', true)):
                                echo esc_html__(' - ', 'education');
                            endif;
                            if (get_post_meta(get_the_ID(),'_nbt_time_end', true)):
                                printf(esc_html__('%s','education'), get_post_meta(get_the_ID(),'_nbt_time_end', true));
                            endif;
                            ?>
                        </span>
					<?php endif; ?>
                </div>
            <?php endif; ?>
        <?php else :
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
