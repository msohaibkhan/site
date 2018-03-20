<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Education
 */
?>

            </div><!-- #content -->
            <?php if (function_exists('education_get_option')):
                if ($newsletter = education_get_option('newsletter')):
                    ?>
                    <div class="education-newsletter">
                        <div class="container">
                    <?php dynamic_sidebar('newsletter'); ?>
                        </div>
                    </div>
                <?php endif;
            endif;
            ?>
            <footer id="colophon" class="site-footer">
                <?php
                $footer_columns = 4;
                $footer_cols = array();
                if (function_exists('education_get_option')):
                    $footer_columns = education_get_option('footer_columns');
                endif;
                for ($i = 1; $i <= 4; $i++):
                    if (is_active_sidebar('footer-' . $i)):
                        $footer_cols[] = $i;
                    endif;
                endfor;
                if (count($footer_cols) < $footer_columns):
                    $footer_columns = count($footer_cols);
                endif;
                if ($footer_columns > 0):
                ?>
                    <div class="footer-top">
                        <div class="container">
                            <div class="row">
                                <div class="footer-columns clear footer-<?php echo intval($footer_columns); ?>-columns">
                                    <?php for ($count = 0; $count < $footer_columns; $count++) :
                                        ?>
                                        <div class="footer-column" id="footer-column-<?php echo intval($footer_cols[$count]); ?>">
                                            <?php dynamic_sidebar('footer-' . $footer_cols[$count]); ?>
                                        </div>
                                    <?php endfor; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
                <div class="footer-bottom">
                    <div class="container">
                        <div class="row">
                            <?php if (function_exists('education_get_option')): ?>
                                <?php if ($footer_bottom_copyright = education_get_option('footer_bottom_copyright')): ?>
                                    <div class="footer-cpr">
                                        <?php
                                        echo wp_kses($footer_bottom_copyright, array(
                                            'a' => array(
                                                'href' => array(),
                                                'title' => array(),
                                            ),
                                        ));
                                        ?>
                                    </div>
                                <?php endif; ?>
                                <?php if ($footer_bottom_menu = education_get_option('footer_bottom_menu')): ?>
                                    <div class="footer-bottom-menu">
                                        <?php
                                        wp_nav_menu( array(
											'theme_location'  => 'footer',
											'menu_class'     => 'list-inline',
											'depth'          => 1, ) );
                                        ?>
                                    </div>
                                <?php endif; ?>
                            <?php else: ?>
                                <div class="footer-cpr">
                                    <a href="<?php echo esc_url(esc_html__('https://wordpress.org/', 'education')); ?>"><?php printf(esc_html__('Proudly powered by %s', 'education'), 'WordPress'); ?></a>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </footer><!-- #colophon -->
        </div><!-- #page -->
        <?php wp_footer(); ?>
    </body>
</html>
