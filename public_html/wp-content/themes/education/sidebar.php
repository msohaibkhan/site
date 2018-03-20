<?php
/**
 * The sidebar containing the main widget area.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Education
 */
?>
<?php if(function_exists('education_get_option')):
    if (is_page()):
        if (education_get_option('page_layout') != 'no-sidebar') :
            ?>
            <aside id="secondary" class="widget-area" role="complementary">
                <?php dynamic_sidebar('page-sidebar'); ?>
            </aside>
        <?php
        endif;
    elseif (is_search()) :
        if (education_get_option('search_layout') != 'no-sidebar' && is_active_sidebar('search-sidebar')) :
            ?>
            <aside id="secondary" class="widget-area" role="complementary">
                <?php dynamic_sidebar('search-sidebar'); ?>
            </aside>
        <?php endif;
    elseif (is_tag()) :
        if (education_get_option('archive_layout') != 'no-sidebar' && is_active_sidebar('blog-sidebar')) :
            ?>
            <aside id="secondary" class="widget-area" role="complementary">
                <?php dynamic_sidebar('blog-sidebar'); ?>
            </aside>
        <?php endif;
    elseif (((is_archive() || is_single()) && !is_author()) && !is_front_page()) :
        ?>
        <?php
        if (get_post_type() == 'sfwd-courses' || get_post_type() == 'sfwd-lessons' || get_post_type() == 'sfwd-topic' || get_post_type() == 'sfwd-quiz'):
            if (education_get_option('course_layout') != 'no-sidebar' && is_active_sidebar('course-sidebar')) :
                if ((is_archive() && education_get_option('course_category_layout')) || is_single()) :
                    ?>
                    <aside id="secondary" class="widget-area" role="complementary">
                        <?php dynamic_sidebar('course-sidebar'); ?>
                    </aside>
                <?php
                endif;
            endif;
        elseif (get_post_type() == 'espresso_events' || get_post_type() == 'espresso_venues'):
            if (education_get_option('event_layout') != 'no-sidebar' && is_active_sidebar('event-sidebar')) :
                if ((is_archive() && education_get_option('event_category_layout')) || is_single()) :
                    ?>
                    <aside id="secondary" class="widget-area" role="complementary">
                        <?php dynamic_sidebar('event-sidebar'); ?>
                    </aside>
                <?php endif; ?>
            <?php
            endif;
        elseif (get_post_type() == 'service'):
            if (education_get_option('service_layout') != 'no-sidebar' && is_active_sidebar('service-sidebar')) :
                ?>
                <aside id="secondary" class="widget-area" role="complementary">
                    <?php dynamic_sidebar('service-sidebar'); ?>
                </aside>
                <?php
                endif;
            elseif (get_post_type() == 'team'):
                if (education_get_option('team_layout') != 'no-sidebar' && is_active_sidebar('team-sidebar')) :
                    ?>
                <aside id="secondary" class="widget-area" role="complementary">
                    <?php dynamic_sidebar('team-sidebar'); ?>
                </aside>
            <?php
            endif;
        elseif (get_post_type() == 'post'):
            if (get_post_format() == 'gallery'):
                if (education_get_option('gallery_layout') != 'no-sidebar' && is_active_sidebar('gallery-sidebar')) :
                    ?>
                    <aside id="secondary" class="widget-area" role="complementary">
                        <?php dynamic_sidebar('gallery-sidebar'); ?>
                    </aside>
                <?php endif;
            elseif (education_get_option('archive_layout') != 'no-sidebar' && is_active_sidebar('blog-sidebar')) :
                ?>
                <aside id="secondary" class="widget-area" role="complementary">
                    <?php dynamic_sidebar('blog-sidebar'); ?>
                </aside>
            <?php
            endif;
        endif;
    endif;
else:
    if (is_active_sidebar('blog-sidebar')): ?>
        <aside id="secondary" class="widget-area" role="complementary">
            <?php dynamic_sidebar('blog-sidebar'); ?>
        </aside>
    <?php endif;
endif; ?>