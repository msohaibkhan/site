<?php
/**
 * This file represents an example of the code that themes would use to register
 * the required plugins.
 *
 * It is expected that theme authors would copy and paste this code into their
 * functions.php file, and amend to suit.
 *
 * @see http://tgmpluginactivation.com/configuration/ for detailed documentation.
 *
 * @package    TGM-Plugin-Activation
 * @subpackage Example
 * @version    2.6.1 for parent theme Printshop for publication on ThemeForest
 * @author     Thomas Griffin, Gary Jones, Juliette Reinders Folmer
 * @copyright  Copyright (c) 2011, Thomas Griffin
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       https://github.com/TGMPA/TGM-Plugin-Activation
 */

/**
 * Include the TGM_Plugin_Activation class.
 *
 * Depending on your implementation, you may want to change the include call:
 *
 * Parent Theme:
 * require_once get_template_directory() . '/path/to/class-tgm-plugin-activation.php';
 *
 * Child Theme:
 * require_once get_stylesheet_directory() . '/path/to/class-tgm-plugin-activation.php';
 *
 * Plugin:
 * require_once dirname( __FILE__ ) . '/path/to/class-tgm-plugin-activation.php';
 */
require_once get_template_directory() . '/inc/tgm/class-tgm-plugin-activation.php';

add_action( 'tgmpa_register', 'education_register_required_plugins' );

/**
 * Register the required plugins for this theme.
 *
 * In this example, we register five plugins:
 * - one included with the TGMPA library
 * - two from an external source, one from an arbitrary source, one from a GitHub repository
 * - two from the .org repo, where one demonstrates the use of the `is_callable` argument
 *
 * The variables passed to the `tgmpa()` function should be:
 * - an array of plugin arrays;
 * - optionally a configuration array.
 * If you are not changing anything in the configuration array, you can remove the array and remove the
 * variable from the function call: `tgmpa( $plugins );`.
 * In that case, the TGMPA default settings will be used.
 *
 * This function is hooked into `tgmpa_register`, which is fired on the WP `init` action on priority 10.
 */
function education_register_required_plugins() {

    /**
     * Array of plugin arrays. Required keys are name and slug.
     * If the source is NOT from the .org repo, then source is also required.
     */
    $plugins = array(

        array(
            'name'               => 'Redux Framework',
            'slug'               => 'redux-framework',
            'required'           => true,
            'force_activation'   => false,
            'force_deactivation' => false,
        ),
        
        array(
            'name'               => 'So widgets bundle',
            'slug'               => 'so-widgets-bundle', 
            'required'           => false,
            'force_activation'   => false,
            'force_deactivation' => false,            
        ),  

        array(
            'name'              => 'Siteorigin Panels',
            'slug'              => 'siteorigin-panels', 
            'required'          => true,
            'force_activation'  => false,
            'external_url'      => 'https://siteorigin.com/',
        ),
        array(
            'name'              => 'Netbase Widgets Education For SiteOrigin',
            'slug'              => 'nbt-so-education', 
            'required'          => false,
            'source'             => esc_url('http://www.netbaseteam.com/wordpress/theme/plugins/elearning/nbt-so-education.zip'),
            'force_activation'  => false,
        ),
        array(
            'name'              => 'Netbase Education Theme',
            'slug'              => 'nbt-education-theme', 
            'required'          => false,
            'source'             => esc_url('http://www.netbaseteam.com/wordpress/theme/plugins/elearning/nbt-education-theme.zip'),
            'force_activation'  => false,
        ),

        array(
            'name'               => 'Slider Revolution',
            'slug'               => 'revslider',
            'source'             => esc_url('http://www.netbaseteam.com/wordpress/theme/plugins/revslider.zip'),
            'required'           => false,
            'force_activation'   => false,
            'force_deactivation' => false,
            'external_url'       => 'http://codecanyon.net/item/slider-revolution-responsive-wordpress-plugin/',
        ),

        array(
            'name'              => 'MailChimp for WordPress',
            'slug'              => 'mailchimp-for-wp',
            'required'          => false,
            'force_activation'  => false,
        ),

        array(
            'name'              => 'NetbaseTeam SimpleModal Login',
            'slug'              => 'nbt-simplemodal-login', 
            'required'          => false,
            'source'             => esc_url('http://www.netbaseteam.com/wordpress/theme/plugins/elearning/nbt-simplemodal-login.zip'),
            'force_activation'  => false,
        ),

        array(
            'name'              => 'WP Customer Reviews',
            'slug'              => 'wp-customer-reviews', 
            'required'          => false,
            'force_activation'  => false,
        ),

        array(
            'name'              => 'Breadcrumb NavXT',
            'slug'              => 'breadcrumb-navxt', 
            'required'          => false,
            'force_activation'  => false,
        ),

        array(
            'name'              => 'Contact Form 7',
            'slug'              => 'contact-form-7', 
            'required'          => false,
            'force_activation'  => false,
        ),

        array(
            'name'              => 'Max Mega Menu',
            'slug'              => 'megamenu', 
            'required'          => false,
            'force_activation'  => false,
        ),
        array(
            'name'              => 'Max Mega Menu pro',
            'slug'              => 'megamenu-pro', 
            'required'          => false,
            'force_activation'  => false,
            'source'             => esc_url('http://www.netbaseteam.com/wordpress/theme/plugins/megamenu-pro.zip')
        ),
        array(
            'name'              => 'LearnDash LMS',
            'slug'              => 'sfwd-lms', 
            'required'          => false,
            'source'             => esc_url('http://www.netbaseteam.com/wordpress/theme/plugins/elearning/sfwd-lms.zip'),
            'force_activation'  => false,
        ),
        array(
            'name'              => 'LearnDash Pro Panel',
            'slug'              => 'learndash-propanel', 
            'required'          => false,
            'source'             => esc_url('http://www.netbaseteam.com/wordpress/theme/plugins/elearning/learndash-propanel.zip'),
            'force_activation'  => false,
        ),

        array(
            'name'              => 'Netbase LearnDash Date Time',
            'slug'              => 'nbt-learndash-date-time', 
            'required'          => false,
            'source'             => esc_url('http://www.netbaseteam.com/wordpress/theme/plugins/elearning/nbt-learndash-date-time.zip'),
            'force_activation'  => false,
        ),

        array(
            'name'              => 'One Click Demo Import',
            'slug'              => 'one-click-demo-import', 
            'required'          => false,
            'source'             => esc_url('http://www.netbaseteam.com/wordpress/theme/plugins/elearning/one-click-demo-import.zip'),
            'force_activation'  => false,
        ),

        array(
            'name'              => 'Event Espresso 4 Decaf',
            'slug'              => 'event-espresso-decaf',
            'required'          => false,
            'force_activation'  => false,
        ),

    );

    /**
     * Array of configuration settings. Amend each line as needed.
     * If you want the default strings to be available under your own theme domain,
     * leave the strings uncommented.
     * Some of the strings are added into a sprintf, so see the comments at the
     * end of each line for what each argument will be.
     */
    $config = array(
        'id'           => 'education',
        'default_path' => '',                      // Default absolute path to pre-packaged plugins.
        'menu'         => 'tgmpa-install-plugins', // Menu slug.
        'has_notices'  => true,                    // Show admin notices or not.
        'dismissable'  => true,                    // If false, a user cannot dismiss the nag message.
        'dismiss_msg'  => '',                      // If 'dismissable' is false, this message will be output at top of nag.
        'is_automatic' => false,                   // Automatically activate plugins after installation or not.
        'message'      => '',                      // Message to output right before the plugins table.
        'strings'      => array(
            'page_title'                      => esc_html__( 'Install Required Plugins', 'education' ),
            'menu_title'                      => esc_html__( 'Install Plugins', 'education' ),
            'installing'                      => esc_html__( 'Installing Plugin: %s', 'education' ),
            'updating'                        => esc_html__( 'Updating Plugin: %s', 'education' ),
            'oops'                            => esc_html__( 'Something went wrong with the plugin API.', 'education' ),
            'notice_can_install_required'     => _n_noop(
                'This theme requires the following plugin: %1$s.',
                'This theme requires the following plugins: %1$s.',
                'education'
            ),
            'notice_can_install_recommended'  => _n_noop(
                'This theme recommends the following plugin: %1$s.',
                'This theme recommends the following plugins: %1$s.',
                'education'
            ),
            'notice_ask_to_update'            => _n_noop(
                'The following plugin needs to be updated to its latest version to ensure maximum compatibility with this theme: %1$s.',
                'The following plugins need to be updated to their latest version to ensure maximum compatibility with this theme: %1$s.',
                'education'
            ),
            'notice_ask_to_update_maybe'      => _n_noop(
                'There is an update available for: %1$s.',
                'There are updates available for the following plugins: %1$s.',
                'education'
            ),
            'notice_can_activate_required'    => _n_noop(
                'The following required plugin is currently inactive: %1$s.',
                'The following required plugins are currently inactive: %1$s.',
                'education'
            ),
            'notice_can_activate_recommended' => _n_noop(
                'The following recommended plugin is currently inactive: %1$s.',
                'The following recommended plugins are currently inactive: %1$s.',
                'education'
            ),
            'install_link'                    => _n_noop(
                'Begin installing plugin',
                'Begin installing plugins',
                'education'
            ),
            'update_link'                     => _n_noop(
                'Begin updating plugin',
                'Begin updating plugins',
                'education'
            ),
            'activate_link'                   => _n_noop(
                'Begin activating plugin',
                'Begin activating plugins',
                'education'
            ),
            'return'                          => esc_html__( 'Return to Required Plugins Installer', 'education' ),
            'plugin_activated'                => esc_html__( 'Plugin activated successfully.', 'education' ),
            'activated_successfully'          => esc_html__( 'The following plugin was activated successfully:', 'education' ),
            'plugin_already_active'           => esc_html__( 'No action taken. Plugin %1$s was already active.', 'education' ),
            'plugin_needs_higher_version'     => esc_html__( 'Plugin not activated. A higher version of %s is needed for this theme. Please update the plugin.', 'education' ),
            'complete'                        => esc_html__( 'All plugins installed and activated successfully. %1$s', 'education' ),
            'dismiss'                         => esc_html__( 'Dismiss this notice', 'education' ),
            'notice_cannot_install_activate'  => esc_html__( 'There are one or more required or recommended plugins to install, update or activate.', 'education' ),
            'contact_admin'                   => esc_html__( 'Please contact the administrator of this site for help.', 'education' ),
            'nag_type'                        => '', // Determines admin notice type - can only be one of the typical WP notice classes, such as 'updated', 'update-nag', 'notice-warning', 'notice-info' or 'error'. Some of which may not work as expected in older WP versions.
        ),
    );

    tgmpa( $plugins, $config );

}