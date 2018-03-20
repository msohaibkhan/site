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
        if (is_single()) :
            if ('post' === get_post_type()) :
                if (has_post_thumbnail()):
                    ?>
                    <div class="entry-thumb">
                        <a href="<?php echo esc_url(get_permalink()); ?>" rel="bookmark">
                            <?php the_post_thumbnail('education-blog-thumb'); ?>
                        </a>
                    </div>
                <?php
                endif;
            endif;
            the_title('<h2 class="entry-title">', '</h2>');
        else :
            if (has_post_thumbnail()):
                ?>
                <div class="entry-thumb">
					<?php the_post_thumbnail('education-blog-thumb'); ?>
                </div>
            <?php
            endif;
            the_title('<h2 class="entry-title"><a href="' . esc_url(get_permalink()) . '" rel="bookmark">', '</a></h2>');
        endif;
        if ('post' === get_post_type()) :
            ?>
            <div class="entry-meta">
				<?php education_posted_on(); ?>
            </div><!-- .entry-meta -->
		<?php endif;
        ?>
    </header><!-- .entry-header -->

    <div class="entry-content">
        <?php
        if (is_archive() && has_excerpt()) :
            if ('post' === get_post_type()) {
                the_excerpt();
                echo'<a class="education-readmore-blog" href="' . esc_url(get_permalink()) . '" rel="bookmark">' . esc_html__('Read more', 'education') . '</a>';
            } else {
                the_excerpt();
            }
        else :
            the_content(
				/* translators: %s: Name of current post. */
				wp_kses(esc_html__('Continue reading', 'education') . ' <span class="meta-nav">'.(is_rtl()?'&larr;':'&rarr;').'</span>', array('span' => array('class' => array())))
            );
        endif;
        wp_link_pages(array(
            'before' => '<div class="page-links">' . esc_html__('Pages:', 'education'),
            'after' => '</div>',
        ));
        ?>
    </div><!-- .entry-content -->
    <div class="clearfix"></div>
    <?php if (is_home()) : ?>
        <div class="entry-meta entry-meta-footer">
			<?php education_entry_footer(); ?>
        </div>
	<?php endif; ?>
</article><!-- #post-## -->
