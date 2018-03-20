<?php

/**
 * Custom template tags for this theme.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package Education
 */
if (!function_exists('education_posted_on')) :

    /**
     * Prints HTML with meta information for the current post-date/time and author.
     */
    function education_posted_on() {
        $time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
        $time_string = sprintf($time_string, esc_attr(get_the_date('c')), esc_html(get_the_date()), esc_attr(get_the_modified_date('c')), esc_html(get_the_modified_date()));

        $posted_on = sprintf(
			esc_html_x('%s', 'post date', 'education'), '<a href="' . esc_url(get_permalink()) . '" rel="bookmark">' . $time_string . '</a>'
        );

        if (is_sticky()) {
            echo '<span class="nbt-sticky-post"></span>';
        }
        if (get_the_author()) {
            $byline = sprintf(
				esc_html_x('%s', 'post author', 'education'), '<span class="author vcard icon-user"><a class="url fn n" href="' . esc_url(get_author_posts_url(get_the_author_meta('ID'))) . '">' . esc_html(get_the_author()) . '</a></span>'
            );
            echo '<span class="byline"><i class="nbticon-black-user-shape"></i> ' . $byline . '</span>';
        }
        echo '<span class="posted-on"><i class="nbticon-schedule-button"></i>' . $posted_on . '</span>';

        if (!post_password_required() && ( comments_open() || get_comments_number() )) {
            echo '<span class="comments-link"><i class="nbticon-big-speech-balloon"></i> ';
            comments_popup_link(
				esc_html__('0', 'education'), esc_html__('1', 'education'), esc_html__('%', 'education')
            );
            echo '</span>';
        }
        else{
            echo '<span class="comments-link-off"><i class="nbticon-big-speech-balloon"></i> ' . esc_html__('Comments off', 'education') . '</span>';
        }
    }
endif;

if (!function_exists('education_entry_footer')) :

    /**
     * Prints HTML with meta information for the categories, tags and comments.
     */
    function education_entry_footer() {
        // Hide category and tag text for pages.
        if ('post' === get_post_type()) {
            /* translators: used between list items, there is a space after the comma */
            $categories_list = get_the_category_list(esc_html__(', ', 'education'));
            if ($categories_list && education_categorized_blog()) {
                printf('<span class="cat-links"><i class="nbticon-books-stack"></i>' . esc_html__('%1$s', 'education') . '</span>', $categories_list); // WPCS: XSS OK.
            }

            /* translators: used between list items, there is a space after the comma */
            if (has_tag()) {
                echo '<span class="tags-links"><i class="nbticon-tags"></i>';
                printf(esc_html__('%1$s', 'education'), get_the_tag_list('', ', '));
                echo '</span>';
            }
        }

        edit_post_link(
			/* translators: %s: Name of current post */
			'<i class="nbticon-font-selection-editor"></i>' . esc_html__('Edit', 'education'), '<span class="edit-link">', '</span>'
        );
    }

endif;

/**
 * Returns true if a blog has more than 1 category.
 *
 * @return bool
 */
function education_categorized_blog() {
    if (false === ( $all_the_cool_cats = get_transient('education_categories') )) {
        // Create an array of all the categories that are attached to posts.
        $all_the_cool_cats = get_categories(array(
            'fields' => 'ids',
            'hide_empty' => 1,
            // We only need to know if there is more than one category.
            'number' => 2,
        ));
        // Count the number of categories that are attached to the posts.
        $all_the_cool_cats = count($all_the_cool_cats);
        set_transient('education_categories', $all_the_cool_cats);
    }
    if ($all_the_cool_cats > 1) {
        // This blog has more than 1 category so education_categorized_blog should return true.
        return true;
    } else {
        // This blog has only 1 category so education_categorized_blog should return false.
        return false;
    }
}

/**
 * Flush out the transients used in education_categorized_blog.
 */
function education_category_transient_flusher() {
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }
    // Like, beat it. Dig?
    delete_transient('education_categories');
}

add_action('edit_category', 'education_category_transient_flusher');
add_action('save_post', 'education_category_transient_flusher');
