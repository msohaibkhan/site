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
    <header class="entry-header education-event-header">
        <?php
        if ( is_single() ) :?>
            <div class="education-event<?php echo has_post_thumbnail() ? '-thumb' : ''; ?>-time">
                <?php if (has_post_thumbnail()): ?>
                    <div class="entry-thumb">
                        <?php the_post_thumbnail(); ?>
                    </div>
                <?php endif;?>
                <div class="education-event-time-countdown">
                    <?php  
                        $datetime = espresso_event_date_obj($post->ID);
                        $start_date = $datetime->start_date('Y/m/d'); 
                    ?>
                    <div data-countdown="<?php printf(esc_html__('%s', 'education'), $start_date); ?>" class="education-time-countdown">
                        <div class="education-days"><span></span><?php echo esc_html__('Days','education');?></div>
                        <div class="education-hours"><span></span><?php echo esc_html__('Hours','education');?></div>
                        <div class="education-mins"><span></span><?php echo esc_html__('Mins','education');?></div>
                        <div class="education-secs"><span></span><?php echo esc_html__('Secs','education');?></div>
                    </div>
                </div>
            </div>
           <?php the_title( '<h2 class="entry-title">', '</h2>' );
        else :
            if (has_post_thumbnail()): ?>
                <div class="entry-thumb">
                    <?php the_post_thumbnail('education-event-thumb'); ?>
                </div>
            <?php endif;
        endif;?>
    </header><!-- .entry-header -->
    <div class="entry-content education-event-content">
        <?php
        if( is_single()):
            the_content( 
                /* translators: %s: Name of current post. */
                wp_kses( esc_html__( 'Continue reading', 'education' ) . ' <span class="meta-nav">'.(is_rtl()?'&larr;':'&rarr;').'</span>', array( 'span' => array( 'class' => array() ) ) )
            );
        else:
            the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' ); 
            if ( is_archive() && has_excerpt() ) :
                // the_excerpt();
                espresso_get_template_part( 'content', 'espresso_events-datetimes' );
                printf(esc_html__('%s', 'education'), wp_trim_words(get_the_excerpt(), 30, '...'));
            else :
                the_content( 
					/* translators: %s: Name of current post. */
					wp_kses( esc_html__( 'Continue reading', 'education' ) . ' <span class="meta-nav">'.(is_rtl()?'&larr;':'&rarr;').'</span>', array( 'span' => array( 'class' => array() ) ) )
				);
            endif;
            ?>
            <div class="education-event-time-countdown">
                <?php  
                    $datetime = espresso_event_date_obj($post->ID);
                    $start_date = $datetime->start_date('Y/m/d'); 
                ?>
                <div data-countdown="<?php printf(esc_html__('%s', 'education'), $start_date); ?>" class="education-time-countdown">
                    <div class="education-days"><span></span><?php echo esc_html__('Days','education');?></div>
                    <div class="education-hours"><span></span><?php echo esc_html__('Hours','education');?></div>
                    <div class="education-mins"><span></span><?php echo esc_html__('Mins','education');?></div>
                    <div class="education-secs"><span></span><?php echo esc_html__('Secs','education');?></div>
                </div>
            </div>
            <?php if ( is_archive() && has_excerpt() ) :
                espresso_get_template_part( 'content', 'espresso_events-tickets' );
            endif; ?>
        <?php endif;?>
    </div><!-- .entry-content -->
    <div class="clearfix"></div>
</article><!-- #post-## -->
