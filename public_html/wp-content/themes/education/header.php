<?php
/**
* The header for our theme.
*
* This is the template that displays all of the <head> section and everything up until <div id="content">
*
* @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
*
* @package Education
*/

?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
    <head>
        <meta charset="<?php bloginfo( 'charset' ); ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="profile" href="http://gmpg.org/xfn/11">
        <link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
        <?php wp_head(); ?>
    </head>
    <body <?php body_class(wp_get_theme()->stylesheet); ?>>
        <div id="page" class="site">
            <!--Header: Begin-->
            <header>
                <!--Header Top: Begin-->
                <?php if(function_exists('education_get_option')):
                    if ($header_top = education_get_option('header_top', false)): ?>
                        <div id="header-top" class="clear">
                            <div class="container">
                                <div class="header-info">
                                    <?php $header_email = education_get_option('header_email');
                                    if ($header_email): ?>
                                        <a class="header_email nbticon nbticon-close-envelope" href="mailto:<?php echo esc_url($header_email); ?>"><?php printf(esc_html('%s', 'education'), $header_email); ?></a>
                                    <?php endif;
                                    $header_phone = education_get_option('header_phone');
                                    if ($header_phone): ?>
                                        <span class="header_phone nbticon nbticon-handphone"><?php printf(esc_html('%s', 'education'), $header_phone); ?></span>
                                    <?php endif; ?>
                                    <?php $header_facebook = education_get_option('header_facebook');
                                    $header_twitter = education_get_option('header_twitter');
                                    $header_linkedin = education_get_option('header_linkedin');
                                    $header_instagram = education_get_option('header_instagram');
                                    $header_blog = education_get_option('header_blog');
                                    $header_pinterest = education_get_option('header_pintrest');
                                    $header_googleplus = education_get_option('header_googleplus'); ?>
                                    <?php if ($header_facebook || $header_twitter || $header_linkedin || $header_instagram || $header_blog || $header_pinterest || $header_googleplus): ?>
                                        <div class="header-socials">
                                            <?php if ($header_facebook): ?>
                                                <a class="header_facebook nbticon nbticon-facebook" href="<?php echo esc_url($header_facebook); ?>"></a>
                                            <?php endif; ?>
                                            <?php if ($header_twitter): ?>
                                                <a class="header_twitter nbticon nbticon-twitter" href="<?php echo esc_url($header_twitter); ?>"></a>
                                            <?php endif; ?>
                                            <?php if ($header_linkedin): ?>
                                                <a class="header_linkedin nbticon nbticon-linkedin" href="<?php echo esc_url($header_linkedin); ?>"></a>
                                            <?php endif; ?>
                                            <?php if ($header_instagram): ?>
                                                <a class="header_instagram nbticon nbticon-instagram" href="<?php echo esc_url($header_instagram); ?>"></a>
                                            <?php endif; ?>
                                            <?php if ($header_blog): ?>
                                                <a class="header_blog nbticon nbticon-blogger" href="<?php echo esc_url($header_blog); ?>"></a>
                                            <?php endif; ?>
                                            <?php if ($header_pinterest): ?>
                                                <a class="header_pintrest nbticon nbticon-pinterest" href="<?php echo esc_url($header_pintrest); ?>"></a>
                                            <?php endif; ?>
                                            <?php if ($header_googleplus): ?>
                                                <a class="header_googleplus nbticon nbticon-google-plus" href="<?php echo esc_url($header_googleplus); ?>"></a>
                                            <?php endif; ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                <div class="header-auth">
                                    <ul class="list-inline">
                                        <li><?php wp_loginout($_SERVER['REQUEST_URI']); ?></li>
                                        <?php if (!is_user_logged_in()): ?>
                                            <?php wp_register(); ?>
                                        <?php endif; ?>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    <?php endif;
                else: ?>
                    <div id="header-top" class="clear">
                        <div class="container">
                            <div class="header-auth">
                                <ul class="list-inline">
                                    <li><?php wp_loginout($_SERVER['REQUEST_URI']); ?></li>
                                    <?php if (!is_user_logged_in()): ?>
                                        <?php wp_register(); ?>
                                    <?php endif; ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                <?php endif;?>
                <!--Header Main: Begin-->
                <div id="header-main" class="clear<?php echo (function_exists('get_field')?(get_field('header_over')?' header-over':''):''); ?>">
                    <div class="container">
                        <div class="row">
                            <!--Header Logo: Begin-->
                            <div id="header-logo">
                                <h1 class="education-logo">
									<a href="<?php echo esc_url( home_url( '/' ) ); ?>">
										<?php if(function_exists('education_get_option')):
											if (education_get_option('header_logo2', false, 'url') && education_get_option('extra_header') && ((function_exists('get_field') && get_field('header_over')) || (!function_exists('get_field') && !get_field('header_over') && is_front_page()))):
												$header_logo = education_get_option('header_logo2', false, 'url'); ?>
												<img src="<?php echo esc_url( $header_logo ); ?>" alt="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>">
											<?php elseif (education_get_option('header_logo', false, 'url')):
												$header_logo = education_get_option('header_logo', false, 'url'); ?>
												<img src="<?php echo esc_url( $header_logo ); ?>" alt="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>">
											<?php else : ?>
												<span class="logo-text"><?php bloginfo( 'name' ); ?></span>
											<?php endif;
										else : ?>
                                            <span class="logo-text"><?php bloginfo( 'name' ); ?></span>
										<?php endif; ?>
									</a>
                                </h1>
                            </div>
                            <!--Header Logo: End-->
                            <div class="header-right-wrap">                            
                                <!--Main Navigation: Begin-->
                                <nav id="main-menu">
                                    <div class="main-menu-title">
                                        <h3><?php esc_html_e('Navigation','education'); ?></h3>
                                        <span class="close-mb-menu"><i class="nbticon nbticon-close2"></i></span>
                                    </div>
                                    <?php wp_nav_menu( array(
                                        'theme_location'  => 'primary',
                                        'container'       => 'nav',
                                        'container_id'    => 'education-main-menu' ) );
                                    ?>
                                </nav>
                                <div class="menu-responsive-toggle"><i class="nbticon nbticon-menu"></i></div>
                                <!--Main Navigation: End-->
                            </div>
                        </div>
                    </div>
                </div>
                <!--Header Top: End-->
            </header>
            <!--Header: End-->
            <!-- breadcrumb-->
            <?php if(function_exists('bcn_display')):
				$breadcrumb = (function_exists('get_field') && get_field('display_breadcrumb') && (get_field('display_breadcrumb') == '2')) ? false : true;
				if ($breadcrumb && (!is_front_page() || is_home())): ?>
					<div class="breadcrumbs" typeof="BreadcrumbList" vocab="http://schema.org/">
						<div class="container">
							<?php bcn_display(); ?>
						</div>
					</div>
				<?php endif;
			endif; ?>
            <!-- breadcrumb: End-->

            <div id="content" class="site-content">
