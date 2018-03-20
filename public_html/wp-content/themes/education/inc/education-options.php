<?php

    /**
     * ReduxFramework Education WordPress Theme Config File
     */

    if ( ! class_exists( 'Redux' ) ) {
        return;
    }

    $opt_name = "education_options";

    /**
     * ---> SET ARGUMENTS
     * All the arguments for Redux.
     * */

    $theme = wp_get_theme();

    $args = array(
        'opt_name'             => $opt_name,
        'display_name'         => $theme->get( 'Name' ),
        'display_version'      => $theme->get( 'Version' ),
        'menu_type'            => 'menu',
        'allow_sub_menu'       => true,
        'menu_title'           => esc_html__( 'Education Options', 'education' ),
        'page_title'           => esc_html__( 'Education Options', 'education' ),
        'google_api_key'       => '',
        'google_update_weekly' => false,
        'async_typography'     => false,
        'admin_bar'            => true,
        'admin_bar_icon'       => 'dashicons-portfolio',
        'admin_bar_priority'   => 50,
        'global_variable'      => '',
        'dev_mode'             => false,
        'update_notice'        => true,
        'customizer'           => true,
        'page_priority'        => null,
        'page_parent'          => 'themes.php',
        'page_permissions'     => 'manage_options',
        'menu_icon'            => '',
        'page_icon'            => 'icon-themes',
        'page_slug'            => 'education_options',
        'save_defaults'        => true,
        'default_show'         => true,
        'default_mark'         => '',
        'show_import_export'   => true,
        'transient_time'       => 60 * MINUTE_IN_SECONDS,
        'output'               => true,
        'output_tag'           => true,
        // 'footer_credit'     => '',                   // Disable the footer credit of Redux. Please leave if you can help it.
        'use_cdn'              => true,

        // HINTS
        'hints'                => array(
            'icon'          => 'el el-question-sign',
            'icon_position' => 'right',
            'icon_color'    => 'lightgray',
            'icon_size'     => 'normal',
            'tip_style'     => array(
                'color'   => 'light',
                'shadow'  => true,
                'rounded' => false,
                'style'   => '',
            ),
            'tip_position'  => array(
                'my' => 'top left',
                'at' => 'bottom right',
            ),
            'tip_effect'    => array(
                'show' => array(
                    'effect'   => 'slide',
                    'duration' => '500',
                    'event'    => 'mouseover',
                ),
                'hide' => array(
                    'effect'   => 'slide',
                    'duration' => '500',
                    'event'    => 'click mouseleave',
                ),
            ),
        )
    );

    // ADMIN BAR LINKS
    $args['admin_bar_links'][] = array(
        'id'    => 'redux-docs',
        'href'  => esc_url('http://docs.reduxframework.com/'),
        'title' => esc_html__( 'Documentation', 'education' ),
    );

    $args['admin_bar_links'][] = array(
        //'id'    => 'redux-support',
        'href'  => esc_url('https://github.com/ReduxFramework/redux-framework/issues'),
        'title' => esc_html__( 'Support', 'education' ),
    );


    // SOCIAL ICONS -> Setup custom links in the footer for quick links in your panel footer icons.
    $args['share_icons'][] = array(
        'url'   => esc_url('https://github.com/ReduxFramework/ReduxFramework'),
        'title' => esc_html__('Visit us on GitHub', 'education'),
        'icon'  => 'el el-github'
        //'img'   => '', // You can use icon OR img. IMG needs to be a full URL.
    );
    $args['share_icons'][] = array(
        'url'   => esc_url('https://www.facebook.com/pages/Redux-Framework/243141545850368'),
        'title' => esc_html__('Like us on Facebook', 'education'),
        'icon'  => 'el el-facebook'
    );
    $args['share_icons'][] = array(
        'url'   => esc_url('http://twitter.com/reduxframework'),
        'title' => esc_html__('Follow us on Twitter', 'education'),
        'icon'  => 'el el-twitter'
    );
    $args['share_icons'][] = array(
        'url'   => esc_url('http://www.linkedin.com/company/redux-framework'),
        'title' => esc_html__('Find us on LinkedIn', 'education'),
        'icon'  => 'el el-linkedin'
    );

    // Panel Intro text -> before the form
    if ( ! isset( $args['global_variable'] ) || $args['global_variable'] !== false ) {
        if ( ! empty( $args['global_variable'] ) ) {
            $v = $args['global_variable'];
        } else {
            $v = str_replace( '-', '_', $args['opt_name'] );
        }
        $args['intro_text'] = sprintf( '<p>' . esc_html__( 'Did you know that Redux sets a global variable for you? To access any of your saved options from within your code you can use your global variable: ', 'education' ) . '<strong>$%1$s</strong></p>', $v );
    } else {
        $args['intro_text'] = '<p>' . esc_html__( 'This text is displayed above the options panel. It isn\'t required, but more info is always better! The intro_text field accepts all HTML.', 'education' ) . '</p>';
    }

    // Add content after the form.
    $args['footer_text'] = '<p>' . esc_html__( 'This text is displayed below the options panel. It isn\'t required, but more info is always better! The footer_text field accepts all HTML.', 'education' ) . '</p>';

    Redux::setArgs( $opt_name, $args );

    /*
     * ---> END ARGUMENTS
     */

    /*
     * ---> START HELP TABS
     */

    $tabs = array(
        array(
            'id'      => 'redux-help-tab-1',
            'title'   => esc_html__( 'Theme Information 1', 'education' ),
            'content' => '<p>' . esc_html__( 'This is the tab content, HTML is allowed.', 'education' ) . '</p>'
        ),
        array(
            'id'      => 'redux-help-tab-2',
            'title'   => esc_html__( 'Theme Information 2', 'education' ),
            'content' => '<p>' . esc_html__( 'This is the tab content, HTML is allowed.', 'education' ) . '</p>'
        )
    );
    Redux::setHelpTab( $opt_name, $tabs );

    // Set the help sidebar
    $content = '<p>' . esc_html__( 'This is the sidebar content, HTML is allowed.', 'education' ) . '</p>';
    Redux::setHelpSidebar( $opt_name, $content );


    /*
     * <--- END HELP TABS
     */


    /*
     *
     * ---> START SECTIONS
     *
     */

    /*

        As of Redux 3.5+, there is an extensive API. This API can be used in a mix/match mode allowing for


     */

    // -> START GENERAL SECTION
    Redux::setSection( $opt_name, array(
        'title'  => esc_html__( 'General', 'education' ),
        'id'     => 'education-general',
        'desc'   => esc_html__( 'Change some site main options', 'education' ),
        'icon'   => 'el-icon-cog el-icon-large',
        'fields' => array(
            array(
                'id'       =>'header_logo',
                'type'     => 'media',
                'title'    => esc_html__('Site\'s header logo', 'education'),
            ),
            array(
                'id'       => 'extra_header',
                'type'     => 'switch',
                'title'    => esc_html__('Enable extra header', 'education'),
				'subtitle'  => esc_html__('Header overlaps with content', 'education'),
                'default'  => false,
            ),
            array(
                'id'       => 'header_logo2',
                'type'     => 'media',
                'title'    => esc_html__('Site\'s header logo', 'education'),
                'required' => array('extra_header', '=', true )
            ),
			// array(
				// 'id'        => 'mainmenu_color',
				// 'type'      => 'color',
				// 'title'     => esc_html__('Mainmenu Text Color', 'education'),
				// 'subtitle'  => esc_html__('Pick a text color.', 'education'),
				// 'default'   => '#1c81c5',
				// 'transparent'=> false,
				// 'output'    => array('color' => '.header-over #mega-menu-wrap-primary #mega-menu-primary > li.mega-menu-item > a.mega-menu-link'),
                // 'required' => array('extra_header', '=', true )
			// ),
			// array(
				// 'id'        => 'mainmenu_border',
				// 'type'      => 'color',
				// 'title'     => esc_html__('Mainmenu Border Color', 'education'),
				// 'subtitle'  => esc_html__('Pick a border color.', 'education'),
				// 'default'   => '#1c81c5',
				// 'transparent'=> true,
				// 'output'    => array('border-color' => '.header-over #mega-menu-wrap-primary #mega-menu-primary > li.mega-menu-item > a.mega-menu-link'),
                // 'required' => array('extra_header', '=', true )
			// ),
			// array(
				// 'id'        => 'mainmenu_hover',
				// 'type'      => 'color',
				// 'title'     => esc_html__('Mainmenu Text Hover Color', 'education'),
				// 'subtitle'  => esc_html__('Pick a text color.', 'education'),
				// 'default'   => '#1c81c5',
				// 'transparent'=> false,
				// 'output'    => array('color' => '.header-over #mega-menu-wrap-primary #mega-menu-primary > li.mega-menu-item.mega-toggle-on > a.mega-menu-link, .header-over #mega-menu-wrap-primary #mega-menu-primary > li.mega-menu-item > a.mega-menu-link:hover, .header-over #mega-menu-wrap-primary #mega-menu-primary > li.mega-menu-item > a.mega-menu-link:focus, .header-over #mega-menu-wrap-primary #mega-menu-primary > li.mega-menu-item.mega-current-menu-item > a.mega-menu-link, .header-over #mega-menu-wrap-primary #mega-menu-primary > li.mega-menu-item.mega-current-menu-ancestor > a.mega-menu-link, .header-over .menu-responsive-toggle .nbticon'),
                // 'required' => array('extra_header', '=', true )
			// ),
			// array(
				// 'id'        => 'mainmenu_border_hover',
				// 'type'      => 'color',
				// 'title'     => esc_html__('Mainmenu Border Hover Color', 'education'),
				// 'subtitle'  => esc_html__('Pick a border color.', 'education'),
				// 'default'   => '#1c81c5',
				// 'transparent'=> true,
				// 'output'    => array('border-color' => '.header-over #mega-menu-wrap-primary #mega-menu-primary > li.mega-menu-item.mega-toggle-on > a.mega-menu-link, .header-over #mega-menu-wrap-primary #mega-menu-primary > li.mega-menu-item > a.mega-menu-link:hover, .header-over #mega-menu-wrap-primary #mega-menu-primary > li.mega-menu-item > a.mega-menu-link:focus, .header-over #mega-menu-wrap-primary #mega-menu-primary > li.mega-menu-item.mega-current-menu-item > a.mega-menu-link, .header-over #mega-menu-wrap-primary #mega-menu-primary > li.mega-menu-item.mega-current-menu-ancestor > a.mega-menu-link'),
                // 'required' => array('extra_header', '=', true )
			// ),
        )
    ) );

    // -> START HEADER
    Redux::setSection( $opt_name, array(
        'title'  => esc_html__( 'Header', 'education' ),
        'id'     => 'education-header',
        'desc'   => esc_html__( 'Change display of header area', 'education' ),
        'icon'   => 'el el-icon-photo',
        'fields' => array(
            array(
                'id'       => 'header_top',
                'type'     => 'switch',
                'title'    => esc_html__('Enable header top area.', 'education'),
                'default'  => true,
            ),
            array(
                'id'       => 'header_email',
                'type'     => 'text',
                'title'    => esc_html__( 'Email contact', 'education' ),
                'validate' => 'email',
                'msg'      => esc_html__('custom error message', 'education'),
                'required' => array('header_top', '=', true )
            ),
            array(
                'id'       => 'header_phone',
                'type'     => 'text',
                'title'    => esc_html__( 'Phone number', 'education' ),
                'required' => array('header_top', '=', true )
            ),
            array(
                'id'       => 'header_facebook',
                'type'     => 'text',
                'title'    => esc_html__( 'Facebook', 'education' ),
                'validate' => 'url',
                'required' => array('header_top', '=', true )
            ),
            array(
                'id'       => 'header_twitter',
                'type'     => 'text',
                'title'    => esc_html__( 'Twitter', 'education' ),
                'validate' => 'url',
                'required' => array('header_top', '=', true )
            ),
            array(
                'id'       => 'header_linkedin',
                'type'     => 'text',
                'title'    => esc_html__( 'Linkedin', 'education' ),
                'validate' => 'url',
                'required' => array('header_top', '=', true )
            ),
            array(
                'id'       => 'header_instagram',
                'type'     => 'text',
                'title'    => esc_html__( 'Instagram', 'education' ),
                'validate' => 'url',
                'required' => array('header_top', '=', true )
            ),
            array(
                'id'       => 'header_blog',
                'type'     => 'text',
                'title'    => esc_html__( 'Blog', 'education' ),
                'validate' => 'url',
                'required' => array('header_top', '=', true )
            ),
            array(
                'id'       => 'header_pinterest',
                'type'     => 'text',
                'title'    => esc_html__( 'Pinterest', 'education' ),
                'validate' => 'url',
                'required' => array('header_top', '=', true )
            ),
            array(
                'id'       => 'header_googleplus',
                'type'     => 'text',
                'title'    => esc_html__( 'Google Plus', 'education' ),
                'validate' => 'url',
                'required' => array('header_top', '=', true )
            )
        )
    ) );

    // -> START FOOTER
    Redux::setSection( $opt_name, array(
        'title'  => esc_html__( 'Footer', 'education' ),
        'id'     => 'education-footer',
        'desc'   => esc_html__( 'Change display of footer area', 'education' ),
        'icon'   => 'el el-icon-photo',
        'fields' => array(
            array(
                'id'       => 'newsletter',
                'type'     => 'switch',
                'title'    => esc_html__('Enable newsletter area.', 'education'),
                'default'  => true,
            ),
            array(
                'id'       => 'footer_widgets',
                'type'     => 'switch',
                'title'    => esc_html__('Enable footer widgets area.', 'education'),
                'default'  => true,
            ),
            
            array(
                'id'      => 'footer_columns',
                'type'    => 'button_set',
                'title'   => esc_html__( 'Footer Columns', 'education' ),
                'desc'    => esc_html__( 'Select the number of columns you would like for your footer widgets area.', 'education' ),
                'default' => '4',
                'required' => array('footer_widgets', '=', true ),
                'options' => array(
                    '1'   => esc_html__( '1 Column', 'education' ),
                    '2'   => esc_html__( '2 Columns', 'education' ),
                    '3'   => esc_html__( '3 Columns', 'education' ),
                    '4'   => esc_html__( '4 Columns', 'education' )
                ),
            ),
            array(
                'id'       => 'footer_bottom',
                'type'     => 'switch',
                'title'    => esc_html__('Enable footer bottom with section for copyright and a image.', 'education'),
                'default'  => true
            ),
            array(
                'id'       =>'footer_bottom_copyright',
                'type'     => 'textarea',
                'title'    => esc_html__('Footer Copyright', 'education'),
                'subtitle' => esc_html__('Enter the copyright section text(allow link tag).', 'education'),
                'required' => array('footer_bottom', '=', true )
            ),
            array(
                'id'       =>'footer_bottom_menu',
                'type'     => 'switch',
                'title'    => esc_html__('Enable Footer Bottom Menu', 'education'),
                'default'  => true
            ), 
        )
    ) );

    // -> START lAYOUTS
    Redux::setSection( $opt_name, array(
        'title' => esc_html__('Layouts', 'education'),
        'id'     => 'education-layouts',
        'desc'   => esc_html__( 'Layouts Configuration', 'education' ),
        'icon'   => 'el el-website',
        'fields' => array(            
            array(
                'id' => 'page_layout',
                'type'     => 'button_set',
                'title'    => esc_html__( 'Page Layout', 'education' ),
                'subtitle' => esc_html__( 'Default page layout.', 'education' ),
                'options'  => array(
                    'left-sidebar'  => esc_html__('Left Sidebar', 'education' ),
                    'no-sidebar'    => esc_html__('No Sidebar', 'education' ),
                    'right-sidebar' => esc_html__('Right Sidebar', 'education' )
                ),
                'default'  => 'no-sidebar'
            ),          
            array(
                'id' => 'search_layout',
                'type'     => 'button_set',
                'title'    => esc_html__( 'Search Layout', 'education' ),
                'subtitle' => esc_html__( 'Default search layout.', 'education' ),
                'options'  => array(
                    'left-sidebar'  => esc_html__('Left Sidebar', 'education' ),
                    'no-sidebar'    => esc_html__('No Sidebar', 'education' ),
                    'right-sidebar' => esc_html__('Right Sidebar', 'education' )
                ),
                'default'  => 'no-sidebar'
            ),
            array(
                'id'       => 'archive_layout',
                'type'     => 'button_set',
                'title'    => esc_html__( 'Archive Layout', 'education' ),
                'subtitle' => esc_html__( 'Default archive layout ( front page, category, tag, search, author, archive ).', 'education' ),
                'options'  => array(
                    'left-sidebar'  => esc_html__('Left Sidebar', 'education' ),
                    'no-sidebar'    => esc_html__('No Sidebar', 'education' ),
                    'right-sidebar' => esc_html__('Right Sidebar', 'education' )
                ),
                'default'  => 'right-sidebar'
            ),
            array(
                'id'       => 'team_layout',
                'type'     => 'button_set',
                'title'    => esc_html__( 'Team Layout', 'education' ),
                'subtitle' => esc_html__( 'Layout for single team', 'education' ),
                'options'  => array(
                    'left-sidebar'  => esc_html__('Left Sidebar', 'education' ),
                    'no-sidebar'    => esc_html__('No Sidebar', 'education' ),
                    'right-sidebar' => esc_html__('Right Sidebar', 'education' )
                ),
                'default'  => 'right-sidebar'
            ),
            array(
                'id'       => 'service_layout',
                'type'     => 'button_set',
                'title'    => esc_html__( 'Service Layout', 'education' ),
                'subtitle' => esc_html__( 'Layout for single service', 'education' ),
                'options'  => array(
                    'left-sidebar'  => esc_html__('Left Sidebar', 'education' ),
                    'no-sidebar'    => esc_html__('No Sidebar', 'education' ),
                    'right-sidebar' => esc_html__('Right Sidebar', 'education' )
                ),
                'default'  => 'left-sidebar'
            ),
            array(
                'id'       => 'event_layout',
                'type'     => 'button_set',
                'title'    => esc_html__( 'Event Layout', 'education' ),
                'subtitle' => esc_html__( 'Layout for single event', 'education' ),
                'options'  => array(
                    'left-sidebar'  => esc_html__('Left Sidebar', 'education' ),
                    'no-sidebar'    => esc_html__('No Sidebar', 'education' ),
                    'right-sidebar' => esc_html__('Right Sidebar', 'education' )
                ),
                'default'  => 'left-sidebar'
            ),array(
                'id'       => 'gallery_layout',
                'type'     => 'button_set',
                'title'    => esc_html__( 'Gallery Layout', 'education' ),
                'subtitle' => esc_html__( 'Default gallery layout ( front page, category, tag, search, author, archive ).', 'education' ),
                'options'  => array(
                    'left-sidebar'  => esc_html__('Left Sidebar', 'education' ),
                    'no-sidebar'    => esc_html__('No Sidebar', 'education' ),
                    'right-sidebar' => esc_html__('Right Sidebar', 'education' )
                ),
                'default'  => 'no-sidebar'
            ),
            array(
                'id'       => 'course_layout',
                'type'     => 'button_set',
                'title'    => esc_html__( 'Course layout', 'education' ),
                'subtitle' => esc_html__( 'Layout for course', 'education' ),
                'options'  => array(
                    'left-sidebar'  => esc_html__('Left Sidebar', 'education' ),
                    'no-sidebar'    => esc_html__('No Sidebar', 'education' ),
                    'right-sidebar' => esc_html__('Right Sidebar', 'education' )
                ),
                'default'  => 'right-sidebar'
            ),
            array(
                'id'       => 'course_category_layout',
                'type'     => 'switch',
                'title'    => esc_html__('Course Category Layout', 'education'),
                'default'  => true,
            ),
            array(
                'id'       => 'event_category_layout',
                'type'     => 'switch',
                'title'    => esc_html__('Event Category Layout', 'education'),
                'default'  => true,
            ),
        )
    ));
    
    // -> START ITEMS PER PAGE
    Redux::setSection( $opt_name, array(
        'title'  => esc_html__( 'Items per page', 'education' ),
        'id'     => 'education-per-page',
        'desc'   => esc_html__( 'Change display items per page', 'education' ),
        'icon'   => 'el el-website',
        'fields' => array(
            array(
                'id'       => 'item_per_blog',
                'type'     => 'switch',
                'title'    => esc_html__('Display all item per blog.', 'education'),
                'default'  => false,
            ),
            array(
                'id' => 'item_per_blog_slider',
                'type' => 'slider',
                'title' => esc_html__('Items per Blog', 'education'),
                'desc' => esc_html__('Slider description. Min: 1, max: 30, step: 1, default value: 4', 'education'),
                "default" => 4,
                "min" => 1,
                "step" => 1,
                "max" => 30,
                'resolution' => 1,
                'display_value' => 'text',
                'required' => array('item_per_blog', '=', false )
            ),
            array(
                'id'       => 'item_per_service',
                'type'     => 'switch',
                'title'    => esc_html__('Display all item per service.', 'education'),
                'default'  => false,
            ),
            array(
                'id' => 'item_per_service_slider',
                'type' => 'slider',
                'title' => esc_html__('Items per Service page', 'education'),
                'desc' => esc_html__('Slider description. Min: 1, max: 30, step: 1, default value: 8', 'education'),
                "default" => 8,
                "min" => 1,
                "step" => 1,
                "max" => 30,
                'resolution' => 1,
                'display_value' => 'text',
                'required' => array('item_per_service', '=', false )
            ),
            array(
                'id'       => 'item_per_team',
                'type'     => 'switch',
                'title'    => esc_html__('Display all item per team.', 'education'),
                'default'  => false,
            ),
            array(
                'id' => 'item_per_team_slider',
                'type' => 'slider',
                'title' => esc_html__('Items per Team page', 'education'),
                'desc' => esc_html__('Slider description. Min: 1, max: 30, step: 1, default value: 12', 'education'),
                "default" => 12,
                "min" => 1,
                "step" => 1,
                "max" => 30,
                'resolution' => 1,
                'display_value' => 'text',
                'required' => array('item_per_team', '=', false )
            ),
            array(
                'id'       => 'item_per_event',
                'type'     => 'switch',
                'title'    => esc_html__('Display all item per event.', 'education'),
                'default'  => false,
            ),
            array(
                'id' => 'item_per_event_slider',
                'type' => 'slider',
                'title' => esc_html__('Items per Event page', 'education'),
                'desc' => esc_html__('Slider description. Min: 1, max: 30, step: 1, default value: 4', 'education'),
                "default" => 4,
                "min" => 1,
                "step" => 1,
                "max" => 30,
                'resolution' => 1,
                'display_value' => 'text',
                'required' => array('item_per_event', '=', false )
            ),
            array(
                'id'       => 'item_per_gallery',
                'type'     => 'switch',
                'title'    => esc_html__('Display all item per gallery.', 'education'),
                'default'  => false,
            ),
            array(
                'id' => 'item_per_gallery_slider',
                'type' => 'slider',
                'title' => esc_html__('Items per Gallery page', 'education'),
                'desc' => esc_html__('Slider description. Min: 1, max: 30, step: 1, default value: 8', 'education'),
                "default" => 8,
                "min" => 1,
                "step" => 1,
                "max" => 30,
                'resolution' => 1,
                'display_value' => 'text',
                'required' => array('item_per_gallery', '=', false )
            ),
            array(
                'id'       => 'item_per_course',
                'type'     => 'switch',
                'title'    => esc_html__('Display all item per course.', 'education'),
                'default'  => false,
            ),
            array(
                'id' => 'item_per_course_slider',
                'type' => 'slider',
                'title' => esc_html__('Items per Course page', 'education'),
                'desc' => esc_html__('Slider description. Min: 1, max: 30, step: 1, default value: 9', 'education'),
                "default" => 9,
                "min" => 1,
                "step" => 1,
                "max" => 30,
                'resolution' => 1,
                'display_value' => 'text',
                'required' => array('item_per_course', '=', false )
            )
        )
    ));

    if ( ! function_exists('education_get_option') ) {
        function education_get_option($id, $fallback = false, $key = false ) {
            global $education_options;
            if ( $fallback == false ){
                $fallback = '';
            }
            $output = ( isset($education_options[$id]) && $education_options[$id] !== '' ) ? $education_options[$id] : $fallback;
            if ( !empty($education_options[$id]) && $key ) {
                $output = $education_options[$id][$key];
            }
            return $output;
        }
    }

    /*
     * <--- END SECTIONS
     */
