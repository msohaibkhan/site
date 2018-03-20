<?php
global $post;
?>
<div class="event-content">
	<?php if ( apply_filters( 'FHEE__content_espresso_events_details_template__display_entry_meta', TRUE )): ?>
		<div class="entry-meta">
			<span class="tags-links"><?php espresso_event_categories( $post->ID, TRUE, TRUE ); ?></span>
			<?php
			if ( ! post_password_required() && ( comments_open() || get_comments_number() ) ) :
				?>
				<span class="comments-link"><?php comments_popup_link( __( 'Leave a comment', 'education' ), __( '1 Comment', 'education' ), __( '% Comments', 'education' ) ); ?></span>
				<?php
			endif;
			edit_post_link( __( 'Edit', 'education' ), '<span class="edit-link">', '</span>' );
			?>
		</div>
	<?php endif;
	$event_phone = espresso_event_phone( $post->ID, FALSE );
	if ( $event_phone != '' ) : ?>
		<p>
			<span class="small-text"><strong><?php _e( 'Event Phone:', 'education' ); ?> </strong></span> <?php echo sprintf(esc_html__('%s', 'education'), $event_phone); ?>
		</p>
	<?php endif;  ?>
	<?php
	if ( apply_filters( 'FHEE__content_espresso_events_details_template__display_the_content', true ) ) { 
		do_action( 'AHEE_event_details_before_the_content', $post );
		if (is_single()){
			apply_filters( 'FHEE__content_espresso_events_details_template__the_content', espresso_event_content_or_excerpt() );
		} else {
			if (has_excerpt()){
				espresso_get_template_part( 'content', 'espresso_events-datetimes' );
				printf(esc_html__('%s', 'education'), get_the_excerpt());
			} else {
				the_content( sprintf(
                    /* translators: %s: Name of current post. */
                    wp_kses( __( 'Continue reading %s <span class="meta-nav">'.(is_rtl()?'&larr;':'&rarr;').'</span>', 'education' ), array( 'span' => array( 'class' => array() ) ) ),
                    the_title( '<span class="screen-reader-text">"', '"</span>', false )
                ) );
			}
		}
		do_action( 'AHEE_event_details_after_the_content', $post );
	}
 ?>
</div>
<!-- .event-content -->
