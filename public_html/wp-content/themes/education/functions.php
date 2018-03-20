<?php

/**
 * Education functions and definitions.
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Education
 */
if (!function_exists('education_setup')) :

    /**
     * Sets up theme defaults and registers support for various WordPress features.
     *
     * Note that this function is hooked into the after_setup_theme hook, which
     * runs before the init hook. The init hook is too late for some features, such
     * as indicating support for post thumbnails.
     */
    function education_setup() {
        /*
         * Make theme available for translation.
         * Translations can be filed in the /languages/ directory.
         * If you're building a theme based on Education, use a find and replace
         * to change 'education' to the name of your theme in all the template files.
         */
        load_theme_textdomain('education', get_template_directory() . '/languages');

        // Add default posts and comments RSS feed links to head.
        add_theme_support('automatic-feed-links');

        /*
         * Let WordPress manage the document title.
         * By adding theme support, we declare that this theme does not use a
         * hard-coded <title> tag in the document head, and expect WordPress to
         * provide it for us.
         */
        add_theme_support('title-tag');

        /*
         * Enable support for Post Thumbnails on posts and pages.
         *
         * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
         */
        add_theme_support('post-thumbnails');

        // This theme uses wp_nav_menu() in one location.
        register_nav_menus(array(
            'primary' => esc_html__('Primary', 'education'),
			'footer' => esc_html__('Footer', 'education'),
        ));

        add_theme_support('post-formats', array(
            'standard',
            'image',
            'video',
            'gallery',
            'audio'
                )
        );
        /*
         * Switch default core markup for search form, comment form, and comments
         * to output valid HTML5.
         */
        add_theme_support('html5', array(
            'search-form',
            'comment-form',
            'comment-list',
            'gallery',
            'caption',
        ));

        // Set up the WordPress core custom background feature.
        add_theme_support('custom-background', apply_filters('education_custom_background_args', array(
            'default-color' => 'ffffff',
            'default-image' => '',
        )));

        add_theme_support('woocommerce');
    }

endif;
add_action('after_setup_theme', 'education_setup');
add_filter( 'auto_update_theme', '__return_true' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function education_content_width() {
    $GLOBALS['content_width'] = apply_filters('education_content_width', 640);
}
add_action('after_setup_theme', 'education_content_width', 0);

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function education_widgets_init() {
    register_sidebar(array(
        'name' => esc_html__('Blog Sidebar', 'education'),
        'id' => 'blog-sidebar',
        'description' => esc_html__('Add widgets here.', 'education'),
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget' => '</aside>',
        'before_title' => '<h3 class="blog-widget-title">',
        'after_title' => '</h3>',
    ));
    register_sidebar(array(
        'name' => esc_html__('Page Sidebar', 'education'),
        'id' => 'page-sidebar',
        'description' => esc_html__('Add widgets here.', 'education'),
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget' => '</aside>',
        'before_title' => '<h3 class="page-widget-title">',
        'after_title' => '</h3>',
    ));
    register_sidebar(array(
        'name' => esc_html__('Search Sidebar', 'education'),
        'id' => 'search-sidebar',
        'description' => esc_html__('Add widgets here.', 'education'),
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget' => '</aside>',
        'before_title' => '<h3 class="page-widget-title">',
        'after_title' => '</h3>',
    ));
    register_sidebar(array(
        'name' => esc_html__('Search Sidebar Courses', 'education'),
        'id' => 'search-sidebar-courses',
        'description' => esc_html__('Add widgets here.', 'education'),
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget' => '</aside>',
        'before_title' => '<h3 class="page-widget-title">',
        'after_title' => '</h3>',
    ));
    register_sidebar(array(
        'name' => esc_html__('Service Sidebar', 'education'),
        'id' => 'service-sidebar',
        'description' => esc_html__('Add widgets here.', 'education'),
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget' => '</aside>',
        'before_title' => '<h3 class="service-widget-title">',
        'after_title' => '</h3>',
    ));
    register_sidebar(array(
        'name' => esc_html__('Event Sidebar', 'education'),
        'id' => 'event-sidebar',
        'description' => esc_html__('Add widgets here.', 'education'),
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget' => '</aside>',
        'before_title' => '<h3 class="event-widget-title">',
        'after_title' => '</h3>',
    ));

    register_sidebar(array(
        'name' => 'Course Sidebar',
        'id' => 'course-sidebar',
        'description' => esc_html__('Add widgets here.', 'education'),
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget' => '</aside>',
        'before_title' => '<h3 class="course-widget-title">',
        'after_title' => '</h3>',
    ));
    register_sidebar(array(
        'name' => esc_html__('Newsletter', 'education'),
        'id' => 'newsletter',
        'description' => esc_html__('Add widgets here.', 'education'),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget' => '</div>'
    ));
    register_sidebar(array(
        'name' => esc_html__('Breadcrumb', 'education'),
        'id' => 'breadcrumb',
        'description' => esc_html__('Add widgets here.', 'education'),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget' => '</div>'
    ));
    register_sidebar(array(
        'name' => esc_html__('Footer 1', 'education'),
        'id' => 'footer-1',
        'description' => education_sidebar_desc('footer-1'),
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget' => '</aside>',
        'before_title' => '<h3 class="widget-title">',
        'after_title' => '</h3>',
    ));
    register_sidebar(array(
        'name' => esc_html__('Footer 2', 'education'),
        'id' => 'footer-2',
        'description' => education_sidebar_desc('footer-2'),
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget' => '</aside>',
        'before_title' => '<h3 class="widget-title">',
        'after_title' => '</h3>',
    ));
    register_sidebar(array(
        'name' => esc_html__('Footer 3', 'education'),
        'id' => 'footer-3',
        'description' => education_sidebar_desc('footer-3'),
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget'  => '</aside>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ) );
    register_sidebar( array(
        'name'          => esc_html__( 'Footer 4', 'education' ),
        'id'            => 'footer-4',
        'description'   => education_sidebar_desc( 'footer-4' ),
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget'  => '</aside>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ) );
    register_sidebar( array(
        'name'          => esc_html__( 'Testimonial', 'education' ),
        'id'            => 'testimonial',
        'description'   => esc_html__( 'Add widget testimonial','education'),
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget' => '</aside>',
        'before_title' => '<h3 class="widget-title">',
        'after_title' => '</h3>',
    ));
    register_sidebar( array(
        'name'          => esc_html__( 'Related team', 'education' ),
        'id'            => 'related-team',
        'description'   => esc_html__( 'Add widget related','education'),
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget' => '</aside>',
        'before_title' => '<h3 class="widget-title">',
        'after_title' => '</h3>',
    ));
    register_sidebar( array(
        'name'          => esc_html__( 'Related service', 'education' ),
        'id'            => 'related-service',
        'description'   => esc_html__( 'Add widget related','education'),
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget' => '</aside>',
        'before_title' => '<h3 class="widget-title">',
        'after_title' => '</h3>',
    ));
    register_sidebar( array(
        'name'          => esc_html__( 'Related gallery', 'education' ),
        'id'            => 'related-gallery',
        'description'   => esc_html__( 'Add widget related','education'),
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget' => '</aside>',
        'before_title' => '<h3 class="widget-title">',
        'after_title' => '</h3>',
    ));
    register_sidebar( array(
        'name'          => esc_html__( 'Related course', 'education' ),
        'id'            => 'related-course',
        'description'   => esc_html__( 'Add widget related','education'),
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget' => '</aside>',
        'before_title' => '<h3 class="widget-title">',
        'after_title' => '</h3>',
    ));
}
add_action('widgets_init', 'education_widgets_init');

/**
 * Enqueue scripts and styles.
 */
function education_scripts() {
    wp_enqueue_style('education-style', get_stylesheet_uri());
	wp_style_add_data( 'education-style', 'rtl', 'replace' );
    wp_enqueue_style('nbtico-style', get_template_directory_uri() . '/css/nbtico.css');
    wp_enqueue_style('owl-carousel', get_template_directory_uri() . '/css/vendor/owl.carousel.min.css');
    wp_enqueue_style('owl-theme', get_template_directory_uri() . '/css/vendor/owl.theme.default.min.css');
    
    wp_enqueue_script('libs-script', get_template_directory_uri() . '/js/libs.min.js', array('jquery'), '20151215', true);
    wp_enqueue_script('education-main', get_template_directory_uri() . '/js/theme.js', array('jquery'), '20151215', true);
    wp_enqueue_script('education-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '20151215', true);
    wp_enqueue_script('education-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20151215', true);

    if (is_singular() && comments_open() && get_option('thread_comments')) {
        wp_enqueue_script('comment-reply');
    }
}
add_action('wp_enqueue_scripts', 'education_scripts');

/**
 *  Editor Style
 */
function education_add_editor_styles() {
    add_editor_style( 'css/editor-style.css' );
}
add_action( 'admin_init', 'education_add_editor_styles' );

/** Form comment */
function education_comment( $comment, $args, $depth ) {
    $GLOBALS['comment'] = $comment;
    if ( 'div' === $args['style'] ) {
        $tag       = 'div';
        $add_below = 'comment';
    } else {
        $tag       = 'li';
        $add_below = 'div-comment';
    } ?>
    <<?php printf(esc_html__('%s', 'education'), $tag); ?> <?php comment_class( empty( $args['has_children'] ) ? '' : 'parent' ) ?> id="comment-<?php comment_ID() ?>">
    <?php if ( 'div' != $args['style'] ) : ?>
        <div id="div-comment-<?php comment_ID() ?>" class="comment-body">
    <?php endif; ?>
            <?php if ( $args['avatar_size'] != 0 ): ?>
                <div class="comment-avatar vcard">
                    <?php echo get_avatar( $comment, $args['avatar_size'] ); ?>
                </div>
            <?php endif; ?>
            <div class="comment-detail">
                <?php if ( $comment->comment_approved == '0' ) : ?>
                    <em class="comment-awaiting-moderation"><?php echo esc_html__( 'Your comment is awaiting moderation.', 'education' ); ?></em>
                <?php endif; ?>
                <div class="comment-meta commentmetadata"><a href="<?php echo htmlspecialchars( get_comment_link( $comment->comment_ID ) ); ?>">
                        <h4 class="comment-author">
                            <?php printf( esc_html__( '%s', 'education' ), get_comment_author_link() ); ?>
                        </h4>
                    <?php
                    /* translators: 1: date, 2: time */
                    printf( esc_html__('%1$s at %2$s', 'education'), get_comment_date(),  get_comment_time() ); ?></a><?php edit_comment_link( esc_html__( '(Edit)', 'education' ), '  ', '' );
                    ?>
                </div>
                <?php comment_text(); ?>
                <div class="reply">
                    <?php comment_reply_link( array_merge( $args, array( 'add_below' => $add_below, 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
                </div>
            </div>
    <?php if ( 'div' != $args['style'] ) : ?>
        </div>
    <?php endif;
    
}

/** Modify comments header text in comments */
function education_child_title_comments() {
    return '<h3>' . comments_number( esc_html__('No Responses', 'education'), esc_html__('1 Response', 'education'), esc_html__('% Responses...', 'education' )) . '</h3>';
}
add_filter( 'genesis_title_comments', 'education_child_title_comments');
 
/** Unset URL from comment form */
function education_move_comment_form_below( $fields ) { 
    $comment_field = $fields['comment']; 
    unset( $fields['comment'] );
    $fields['comment'] = '<p class="comment-form-comment">'.
            '<textarea id="comment" name="comment" placeholder="'.  esc_attr__('Comments...', 'education').'" cols="45" rows="8" maxlength="65525" aria-required="true" required="required"></textarea>'.
            '</p>';
    return $fields; 
} 
add_filter( 'comment_form_fields', 'education_move_comment_form_below' ); 

/** override event */
function education_ticket_details_template_location(){
    return get_template_directory() . '/espresso/ticket_details.template.php';
}
add_filter ('FHEE__EventEspresso_modules_ticket_selector_TicketDetails__display__template_path', 'education_ticket_details_template_location');

/** Add placeholder for Name and Email */
function education_modify_comment_form_fields($fields){
    $commenter = wp_get_current_commenter();
    $req = get_option( 'require_name_email' );
    $aria_req = ( $req ? " aria-required='true'" : '' );
    $fields['author'] = '<p class="comment-form-author">' . '<input id="author" placeholder="' . esc_attr__('Full name', 'education') . '" name="author" type="text" value="' .
                            esc_attr( $commenter['comment_author'] ) . '" size="30"' . $aria_req . ' />' .
                        '</p>';
    $fields['email'] = '<p class="comment-form-email">' . '<input id="email" placeholder="' . esc_attr__('Email address', 'education') . '" name="email" type="text" value="' . esc_attr(  $commenter['comment_author_email'] ) .
                            '" size="30"' . $aria_req . ' />' .
                        '</p>';
    $fields['url'] = '<p class="comment-form-url">' .
                            '<input id="url" name="url" placeholder="http://your-site-name.com" type="text" value="' . esc_url( $commenter['comment_author_url'] ) . '" size="30" /> ' .
                            '<label for="url">' . esc_html__( 'Website', 'education' ) . '</label>' .
                        '</p>';
    $fields['url'] = '';    
    return $fields;
}
add_filter('comment_form_default_fields','education_modify_comment_form_fields');

/** Default comment */
function education_comment_form_defaults( $defaults ) {
    $defaults['label_submit'] = esc_html__('Send', 'education');
    $defaults['title_reply'] = esc_html__('Comments:', 'education');
    $defaults['comment_notes_before'] = '';
    return $defaults;
}
add_filter( 'comment_form_defaults', 'education_comment_form_defaults' );

/** tag */
function education_custom_tag_cloud_widget($args) {
    $args['number'] = 0; //adding a 0 will display all tags
    $args['largest'] = 1; //largest tag
    $args['smallest'] = 1; //smallest tag
    $args['unit'] = 'em'; //tag font unit
    return $args;
}
add_filter('widget_tag_cloud_args', 'education_custom_tag_cloud_widget');

/** Add image size for widgets */
function education_add_thumb_size() {
    add_image_size('education-course-tab-popular', 570, 348, array('center', 'center'));
    add_image_size('education-course-single', 770, 385, array('center', 'center'));
    add_image_size('education-course-thumb', 370, 325, array('center', 'center'));
    add_image_size('education-course-service', 85, 85, array('center', 'center'));
    add_image_size('education-service-thumb', 370, 200, array('center', 'center'));
    add_image_size('education-event-category', 770, 450, array('center', 'center'));
    add_image_size('education-event-thumb', 445, 370, array('center', 'center'));
    add_image_size('education-team-single', 550, 600, array('center', 'center'));
    add_image_size('education-custom-team', 350, 510, array('center', 'center'));
    add_image_size('education-team-thumb', 270, 280, array('center', 'center'));
    add_image_size('education-gallery-thumb', 568, 319, array('center', 'center'));
	add_image_size('education-gallery-thumb-2', 480, 340, array('center', 'center'));
    add_image_size('education-blog-thumb', 770, 350, array('center', 'center'));
    add_image_size('education-recent-blog', 70, 70, array('center', 'center'));
    add_image_size('education-avatar', 100, 100, array('center', 'center'));
    add_image_size('education-thumb', 100, 70, array('center', 'center'));
}
add_action('after_setup_theme', 'education_add_thumb_size');

/** Add thumbnail on widget */

function education_custom_sizes($sizes) {
    return array_merge($sizes, array(
        'education-course-tab-popular' => esc_html__('Course tab popular', 'education'),
        'education-course-single' => esc_html__('Course thumbnail single', 'education'),
        'education-course-thumb' => esc_html__('Course thumbnail', 'education'),
        'education-course-service' => esc_html__('Course service', 'education'),
        'education-service-thumb' => esc_html__('Service thumbnail', 'education'),
        'education-event-category' => esc_html__('Event category', 'education'),
        'education-event-thumb' => esc_html__('Event thumbnail', 'education'),
        'education-team-single' => esc_html__('Team single', 'education'),
        'education-custom-team' => esc_html__('Custom team', 'education'),
        'education-team-thumb' => esc_html__('Team thumbnail', 'education'),
        'education-gallery-thumb' => esc_html__('Gallery thumbnail', 'education'),
        'education-blog-thumb' => esc_html__('Blog thumbnail', 'education'),
        'education-recent-blog' => esc_html__('Recent blog', 'education'),
        'education-avatar' => esc_html__('Avatar', 'education'),
        'education-thumb' => esc_html__('Sidebar thumbnail', 'education'),
    ));
}
add_filter('image_size_names_choose', 'education_custom_sizes');

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/jetpack.php';

/**
 * Theme Options Panel
 */
require get_template_directory() . '/inc/education-options.php';

/**
 * Recomend plugins via TGM activation class
 */
require_once( trailingslashit(get_template_directory()) . '/inc/tgm/plugin-activation.php' );

/** Get archiver title */
function education_get_the_archive_title($title) {
    if (is_category()) {
        $title = single_cat_title('', false);
    } elseif (is_tag()) {
        $title = single_tag_title('', false);
    } elseif (is_author()) {
        $title = '<span class="vcard">' . get_the_author() . '</span>';
    } elseif (is_post_type_archive()) {
        $title = post_type_archive_title('', false);
    } elseif (is_tax()) {
        $title = single_term_title('', false);
    }
    return $title;
}
add_filter('get_the_archive_title', 'education_get_the_archive_title');

/** Set posts per page */
function education_set_posts_per_page($query) {
    global $wp_query;

    if(function_exists('education_get_option')){
        if ((!is_admin()) && ($query->is_main_query()) && ($query === $wp_query) && ($query->is_archive())) {
            $postperpage = get_option('posts_per_page');
            if (isset($query->query_vars['espresso_event_categories'])) {
                if (education_get_option('item_per_event')) {
                    $postperpage = -1;
                } else {
                    $postperpage = education_get_option('item_per_event_slider');
                }
            } elseif (isset($query->query_vars['category-service'])) {
                if (education_get_option('item_per_service')) {
                    $postperpage = -1;
                } else {
                    $postperpage = education_get_option('item_per_service_slider');
                }
            } elseif (isset($query->query_vars['category-team'])) {
                if (education_get_option('item_per_team')) {
                    $postperpage = -1;
                } else {
                    $postperpage = education_get_option('item_per_team_slider');
                }
            } elseif ((isset($query->query_vars['post_format'])) && ($query->query_vars['post_format'] == 'post-format-gallery')) {
                if (education_get_option('item_per_gallery')) {
                    $postperpage = -1;
                } else {
                    $postperpage = education_get_option('item_per_gallery_slider');
                }
            } elseif (isset($query->query_vars['post_type'])) {
                if ($query->get('post_type') == 'sfwd-courses') {
                    if (education_get_option('item_per_course')) {
                        $postperpage = -1;
                    } else {
                        $postperpage = education_get_option('item_per_course_slider');
                    }
                } elseif ($query->get('post_type') == 'espresso_events') {
                    if (education_get_option('item_per_event')) {
                        $postperpage = -1;
                    } else {
                        $postperpage = education_get_option('item_per_event_slider');
                    }
                } elseif ($query->get('post_type') == 'service') {
                    if (education_get_option('item_per_service')) {
                        $postperpage = -1;
                    } else {
                        $postperpage = education_get_option('item_per_service_slider');
                    }
                } elseif ($query->get('post_type') == 'team') {
                    if (education_get_option('item_per_team')) {
                        $postperpage = -1;
                    } else {
                        $postperpage = education_get_option('item_per_team_slider');
                    }
                }
            } else {
                if (education_get_option('item_per_blog')) {
                    $postperpage = -1;
                } else {
                    $postperpage = education_get_option('item_per_blog_slider');
                }
            }
            $query->set('posts_per_page', $postperpage);
        }
    }
    return $query;
}
add_action('pre_get_posts', 'education_set_posts_per_page');

/** Query post type */
function education_query_post_type($query) {
    if (is_category() || is_tag()) {
        $post_type = get_query_var('post_type');
        if ($post_type)
            $post_type = $post_type;
        else
            $post_type = array('nav_menu_item', 'post', 'sfwd-courses'); // don't forget nav_menu_item to allow menus to work!
        $query->set('post_type', $post_type);
        return $query;
    }
}
add_filter('pre_get_posts', 'education_query_post_type');