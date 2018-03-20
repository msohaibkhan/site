<?php
/**
 * This file contains the code that displays the course list.
 * 
 * @since 2.1.0
 * 
 * @package Education
 */
?>
<?php
$options = get_option('sfwd_cpt_options');
$currency = null;
if(!is_null($options)){
    if(isset($options['modules']) && isset($options['modules']['sfwd-courses_options']) && isset($options['modules']['sfwd-courses_options']['sfwd-courses_paypal_currency'])){
        $currency = $options['modules']['sfwd-courses_options']['sfwd-courses_paypal_currency'];
    }
}
if(is_null($currency)){
    $currency = 'USD';
}
$course_options = get_post_meta(get_the_ID(),'_sfwd-courses', true);
$price = $course_options && isset($course_options['sfwd-courses_course_price']) ?
        $course_options['sfwd-courses_course_price']
        : esc_html__('Free', 'education');
if($price==''){
    $price .= esc_html__('Free', 'education');
}

if(is_numeric($price)){
    if($currency == "USD"){
    $price = '$' . $price;
    } else {
    $price .= ' ' . $currency;
    }
}
?>
<article class="education-entry-content entry-content">
    <header class="entry-header">
        <?php if ( has_post_thumbnail() ) : ?>
            <div class="entry-thumb">
                <a href="<?php the_permalink(); ?>" title="<?php echo the_title_attribute( 'echo=0' ); ?>" rel="bookmark">
                    <?php the_post_thumbnail('education-course-thumb'); ?>
                </a>
				<?php // get_template_part( 'learndash/course_media'); ?>
            </div>
        <?php endif; ?>
    </header>
    <div class="entry-course">
        <div class="education-course-price <?php echo !empty($course_options['sfwd-courses_course_price']) ? 'price_'.$currency : esc_attr__('Free', 'education');?>">
            <span><?php printf(esc_html__('%s', 'education'), $price);?></span>
        </div>
        <?php the_title( '<h2 class="ld-entry-title entry-title"><a href="' . get_permalink() . '" title="' . the_title_attribute( 'echo=0' ) . '" rel="bookmark">', '</a></h2>' ); ?>
        <?php if (get_post_meta(get_the_ID(),'_courses_date_start', true) || get_post_meta(get_the_ID(),'_nbt_time_start', true) || get_post_meta(get_the_ID(),'_nbt_time_end', true)) : ?>
            <div class="education-course-info">
                <?php if (get_post_meta(get_the_ID(),'_courses_date_start', true)): ?>
                    <span class="education-course-date">
                        <span class="nbticon nbticon-calendar"></span>
                        <?php $education_course_date = date_i18n(get_option('date_format'),strtotime(get_post_meta(get_the_ID(),'_courses_date_start', true)));
                        printf(esc_html__('%s', 'education'), $education_course_date); ?>
                    </span>
                <?php endif; ?>
                <?php if (get_post_meta(get_the_ID(),'_nbt_time_start', true) || get_post_meta(get_the_ID(),'_nbt_time_end', true)) : ?>
                    <span class="education-course-time">
                        <span class="nbticon nbticon-schedule-button"></span>
                        <?php
                        if (get_post_meta(get_the_ID(),'_nbt_time_start', true)):
                            printf(esc_html__('%s','education'), get_post_meta(get_the_ID(),'_nbt_time_start', true));
                        endif;
                        if (get_post_meta(get_the_ID(),'_nbt_time_start', true) || get_post_meta(get_the_ID(),'_nbt_time_end', true)):
                            echo esc_html__(' - ', 'education');
                        endif;
                        if (get_post_meta(get_the_ID(),'_nbt_time_end', true)):
                            printf(esc_html__('%s','education'), get_post_meta(get_the_ID(),'_nbt_time_end', true));
                        endif;
                        ?>
                    </span>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </div>
</article>
