<?php

/**
 * Custom functions that act independently of the theme templates.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package Education
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function education_body_classes($classes) {

    // Adds a class of group-blog to blogs with more than 1 published author.
    if (is_multi_author()) {
        $classes[] = 'group-blog';
    }

    // Adds a class of hfeed to non-singular pages.
    if (!is_singular()) {
        $classes[] = 'hfeed';
    }

    if (is_page()) {
        if(function_exists('education_get_option')){
            $page_layout = education_get_option('page_layout');
        } else {
            if (is_active_sidebar('blog-sidebar')) {
				if (is_rtl()){
					$page_layout = 'left-sidebar';
				} else {
					$page_layout = 'right-sidebar';
				}
            } else {
                $page_layout = 'no-sidebar';
            }
        }
        $classes[] = $page_layout;
		if ( is_front_page() && is_home() ) {
			// Default homepage
			$classes[] = 'default_homepage';
		} elseif ( is_front_page()){
			//Static homepage
			$classes[] = 'static_homepage';
		} elseif ( is_home()){
			//Blog page
			$classes[] = 'blog_page';
		}
		if (function_exists('get_field') && get_field('extra_class_page')){
			$classes[] = get_field('extra_class_page');
		}
        $classes[] = 'page-' . get_query_var('pagename');
    } elseif (is_search()) {
        if (function_exists('education_get_option') && is_active_sidebar('search-sidebar')) {
            $classes[] = education_get_option('search_layout');
        } else {
            if (is_active_sidebar('blog-sidebar')) {
                if (is_rtl()){
					$classes[] = 'left-sidebar';
				} else {
					$classes[] = 'right-sidebar';
				}
            } else {
                $classes[] = 'no-sidebar';
            }
        }
    } elseif (is_tag()) {
        if (function_exists('education_get_option') && is_active_sidebar('blog-sidebar')) {
            $classes[] = education_get_option('archive_layout');
        } else {
            if (is_active_sidebar('blog-sidebar')) {
				if (is_rtl()){
					$classes[] = 'left-sidebar';
				} else {
					$classes[] = 'right-sidebar';
				}
            } else {
                $classes[] = 'no-sidebar';
            }
        }
    } elseif (((is_archive() || is_single()) && !is_author()) && !is_front_page()) {
        if (function_exists('education_get_option')) {
            if (get_post_type() == 'sfwd-courses' || get_post_type() == 'sfwd-lessons' || get_post_type() == 'sfwd-topic' || get_post_type() == 'sfwd-quiz') {
                if (is_active_sidebar('course-sidebar')) {
                    if (is_archive() && !education_get_option('course_category_layout')) {
                        $archive_layout = 'no-sidebar';
                    } else {
                        $archive_layout = education_get_option('course_layout');
                    }
                } else {
                    $archive_layout = 'no-sidebar';
                }
            } elseif (get_post_type() == 'espresso_events' || get_post_type() == 'espresso_venues') {
                if (is_active_sidebar('event-sidebar')) {
                    if (is_archive() && !education_get_option('event_category_layout')) {
                        $archive_layout = 'no-sidebar';
                    } else {
                        $archive_layout = education_get_option('event_layout');
                    }
                } else {
                    $archive_layout = 'no-sidebar';
                }
            } elseif (get_post_type() == 'service') {
                if (is_active_sidebar('service-sidebar')) {
                    $archive_layout = education_get_option('service_layout');
                } else {
                    $archive_layout = 'no-sidebar';
                }
            } elseif (get_post_type() == 'team') {
                if (is_active_sidebar('team-sidebar')) {
                    $archive_layout = education_get_option('team_layout');
                } else {
                    $archive_layout = 'no-sidebar';
                }
            } else {
                if (get_post_format() == 'gallery') {
                    if (is_active_sidebar('gallery-sidebar')) {
                        $archive_layout = education_get_option('gallery_layout');
                    } else {
                        $archive_layout = 'no-sidebar';
                    }
                } else {
                    if (is_active_sidebar('blog-sidebar')) {
                        $archive_layout = education_get_option('archive_layout');
                    } else {
                        $archive_layout = 'no-sidebar';
                    }
                }
            }
        } else {
            if (is_active_sidebar('blog-sidebar')) {
                if (is_rtl()){
					$archive_layout = 'left-sidebar';
				} else {
					$archive_layout = 'right-sidebar';
				}
            } else {
                $archive_layout = 'no-sidebar';
            }
        }
        $classes[] = $archive_layout;
    } elseif (is_404()) {
		$classes[] = 'no-sidebar';
	} else {
		if (is_active_sidebar('blog-sidebar')) {
			if (is_rtl()){
				$archive_layout = 'left-sidebar';
			} else {
				$archive_layout = 'right-sidebar';
			}
		} else {
			$archive_layout = 'no-sidebar';
		}
        $classes[] = $archive_layout;
    }
    return $classes;
}

add_filter('body_class', 'education_body_classes');

/**
 * Change description of footer widget.
 * @param string Id of the footer widget.
 * @return string
 *
 */
function education_sidebar_desc($sidebar_id) {
    $desc = '';
    $column = str_replace('footer-', '', $sidebar_id);
    if (function_exists('education_get_option')) {
        $footer_columns = education_get_option('footer_columns');
		if ($column > $footer_columns) {
			$desc = esc_html__('This widget will not display. You can adjust this in Theme Options - Footer section.', 'education');
		}
    }

    return $desc;
}
