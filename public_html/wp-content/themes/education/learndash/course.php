<?php
/**
 * Displays a course
 *
 * Available Variables:
 * $course_id       : (int) ID of the course
 * $course      : (object) Post object of the course
 * $course_settings : (array) Settings specific to current course
 * 
 * $courses_options : Options/Settings as configured on Course Options page
 * $lessons_options : Options/Settings as configured on Lessons Options page
 * $quizzes_options : Options/Settings as configured on Quiz Options page
 * 
 * $user_id         : Current User ID
 * $logged_in       : User is logged in
 * $current_user    : (object) Currently logged in user object
 * 
 * $course_status   : Course Status
 * $has_access  : User has access to course or is enrolled.
 * $materials       : Course Materials
 * $has_course_content      : Course has course content
 * $lessons         : Lessons Array
 * $quizzes         : Quizzes Array
 * $lesson_progression_enabled  : (true/false)
 * $has_topics      : (true/false) 
 * $lesson_topics   : (array) lessons topics 
 * 
 * @since 2.1.0
 * 
 * @package Education
 */
?>
<?php
/**
 * Display course status
 */
?>

<div class="learndash_course_info">
    <?php if(has_action('nbt_learndash_date_hook')):
        do_action('nbt_learndash_date_hook');
    endif; ?>
    <?php if (class_exists('NbtEducationTheme')) :
        $educationReview = new NbtEducationTheme();
        $average = $educationReview->education_get_reviews($post->ID)->aggregate_rating;
    endif; ?>
    <div class="learndash_course_review">
        <?php echo esc_html__('Review', 'education'); ?>
        <div class="wpcr3_rating_style1_base ">
            <div class="wpcr3_rating_style1_average" style="width:<?php printf(esc_html__('%s', 'education'), $average); ?>%;"></div>
        </div>
    </div>
    <?php if ( $logged_in ) : ?>
        <div id="learndash_course_status">
            <b><?php printf(esc_html_x('%s Status:', 'Course Status Label', 'education'), LearnDash_Custom_Label::get_label('course')); ?></b> <?php printf(esc_html__('%s', 'education'), $course_status);  ?>
        </div>
        <?php if (!empty($course_certficate_link)) : ?>
            <div id="learndash_course_certificate">
                <a href='<?php echo esc_url($course_certficate_link); ?>' class="btn-blue" target="_blank"><?php echo apply_filters('ld_certificate_link_label', esc_html__('PRINT YOUR CERTIFICATE', 'education'), $user_id, $post->ID); ?></a>
            </div>
            <br />
        <?php endif; ?>
    <?php endif; ?>
    <?php if ( ! $has_access ) : ?>
        <?php echo learndash_payment_buttons( $post ); ?>
    <?php endif; ?>
</div>
<div class="learndash_course_tabs">
    <ul class="nav nav-tabs nav-justified" role="tablist">
        <li role="presentation" class="active">
            <a href="#learndash_course_desc" aria-controls="description" role="tab" data-toggle="tab">
                <?php echo esc_html__('Description', 'education'); ?>
            </a>
        </li>
        <?php if ( $has_course_content ) : ?>
            <li role="presentation">
                <a href="#learndash_course_curricilum" aria-controls="description" role="tab" data-toggle="tab">
                    <?php echo esc_html__('Curricilum', 'education'); ?>
                </a>
            </li>
        <?php endif; ?>
        <?php  if( function_exists('get_field') && get_field('advisor') ): ?>
            <li role="presentation">
                <a href="#learndash_course_advisor" aria-controls="description" role="tab" data-toggle="tab">
                    <?php echo esc_html__('Advisor', 'education'); ?>
                </a>
            </li>
        <?php endif; ?>
        <?php if ( comments_open() || get_comments_number() ) : ?>
            <li role="presentation">
                <a href="#learndash_course_comment" aria-controls="description" role="tab" data-toggle="tab">
                    <?php echo esc_html__('Comment', 'education'); ?>
                </a>
            </li>
        <?php endif; ?>
    </ul>
    <div class="tab-content">
        <div role="tabpanel" class="tab-pane active" id="learndash_course_desc">
            <?php printf(esc_html__('%s', 'education'),  $content); ?>
        </div>
        <?php if ( $has_course_content ) : ?>
            <div role="tabpanel" class="tab-pane" id="learndash_course_curricilum">
            <?php 
                $show_course_content = true;
                if ( !$has_access ) :
                    if ( $course_meta['sfwd-courses_course_disable_content_table'] == 'on' ) :
                        $show_course_content = false;
                    endif;
                endif;                      
                if ( $show_course_content ) :
                ?>
                    <div id="learndash_course_content">
                        <h4 id="learndash_course_content_title"><?php printf( esc_html_x( '%s Content', 'Course Content Label', 'education' ), LearnDash_Custom_Label::get_label( 'course' ) ); ?></h4>
                        <?php
                        /**
                         * Display lesson list
                         */
                        ?>
                        <?php if ( ! empty( $lessons ) ) : ?>
                            <?php if ( $has_topics ) : ?>
                                <?php 
                                wp_localize_script( 'education-main', 'sfwd_courses', array(
                                    'course_id' => esc_attr($course_id)
                                ) );
                                wp_enqueue_script( 'education-main' );
                                ?>
                                <div class="expand_collapse">
                                    <a id="education_<?php echo esc_attr($course_id); ?>_expand" href="#"><?php echo esc_html__( 'Expand All', 'education' ); ?></a>
                                    <a id="education_<?php echo esc_attr($course_id); ?>_collapse" href="#"><?php echo esc_html__( 'Collapse All', 'education' ); ?></a>
                                </div>
                            <?php endif; ?>
                            <div id="learndash_lessons">
                                <div id="lesson_heading">
									<span><?php echo LearnDash_Custom_Label::get_label( 'lessons' ) ?></span>
									<span class="right"><?php echo esc_html__( 'Status', 'education' ); ?></span>
                                </div>
                                <div id="lessons_list">
                                    <?php foreach ( $lessons as $lesson ) : ?>
                                        <div class='post-<?php echo esc_attr( $lesson['post']->ID ); ?> <?php echo esc_attr( $lesson['sample'] ); ?>'>
                                            <div class="list-count">
                                                <?php printf(esc_html__('%s', 'education'), $lesson['sno']); ?>
                                            </div>
                                            <h4>
                                                <a class='<?php echo esc_attr( $lesson['status'] ); ?>' href='<?php echo esc_attr( $lesson['permalink'] ); ?>'><?php printf(esc_html('%s', 'education'), $lesson['post']->post_title); ?></a>
                                                <?php
                                                /**
                                                 * Not available message for drip feeding lessons
                                                 */
                                                ?>
                                                <?php if ( ! empty( $lesson['lesson_access_from'] ) && function_exists(learndash_adjust_date_time_display) ) : ?>
                                                    <small class="notavailable_message">
                                                        <?php echo sprintf( esc_html__( 'Available on: %s ', 'education' ), learndash_adjust_date_time_display( $lesson['lesson_access_from'] ) ); ?>
                                                    </small>
                                                <?php endif; ?>
                                                <?php
                                                /**
                                                 * Lesson Topics
                                                 */
                                                ?>
                                                <?php $topics = @$lesson_topics[ $lesson['post']->ID ]; ?>
                                                <?php if ( ! empty( $topics ) ) : ?>
                                                    <div id='learndash_topic_dots-<?php echo esc_attr( $lesson['post']->ID ); ?>' class="learndash_topic_dots type-list">
                                                        <ul>
                                                            <?php $odd_class = ''; ?>
                                                            <?php foreach ( $topics as $key => $topic ) : ?>
                                                                <?php $odd_class = empty( $odd_class ) ? 'nth-of-type-odd' : ''; ?>
                                                                <?php $completed_class = empty( $topic->completed ) ? 'topic-notcompleted':'topic-completed'; ?>                                                
                                                                <li class='<?php echo esc_attr( $odd_class ); ?>'>
                                                                    <span class="topic_item">
																		<a class='<?php echo esc_attr( $completed_class ); ?>' href='<?php echo esc_attr( get_permalink( $topic->ID ) ); ?>' title='<?php echo esc_attr( $topic->post_title ); ?>'>
																			<span><?php printf(esc_html('%s', 'education'), $topic->post_title); ?></span>
																		</a>
                                                                    </span>
                                                                </li>
                                                            <?php endforeach; ?>
                                                        </ul>
                                                    </div>
                                                <?php endif; ?>
                                            </h4>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                        <?php endif; ?>
                        <?php
                        /**
                         * Display quiz list
                         */
                        ?>
                        <?php if ( ! empty( $quizzes ) ) : ?>
                            <div id="learndash_quizzes">
                                <div id="quiz_heading">
                                    <span><?php echo LearnDash_Custom_Label::get_label( 'quizzes' ) ?></span><span class="right"><?php _e( 'Status', 'education' ); ?></span>
                                </div>
                                <div id="quiz_list">
                                    <?php foreach( $quizzes as $quiz ) : ?>
                                        <div id='post-<?php echo esc_attr( $quiz['post']->ID ); ?>' class='<?php echo esc_attr( $quiz['sample'] ); ?>'>
                                            <div class="list-count"><?php printf(esc_html__('%s', 'education'), $quiz['sno']); ?></div>
                                            <h4>
                                                <a class='<?php echo esc_attr( $quiz['status'] ); ?>' href='<?php echo esc_attr( $quiz['permalink'] ); ?>'><?php printf(esc_html__('%s', 'education'),  $quiz['post']->post_title); ?></a>
                                            </h4>
                                        </div>                      
                                    <?php endforeach; ?>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
            </div>
        <?php endif; ?>
        <?php  if( function_exists('get_field') && get_field('advisor') ): ?>
            <div role="tabpanel" class="tab-pane" id="learndash_course_advisor">
                <?php the_field('advisor'); ?>
            </div>
        <?php endif; ?>
        <?php // If comments are open or we have at least one comment, load up the comment template.
        if ( comments_open() || get_comments_number() ) : ?>
            <div role="tabpanel" class="tab-pane" id="learndash_course_comment">
                <?php comments_template(); ?>
            </div>
        <?php endif; ?>
    </div>
</div>
<?php if ( isset( $materials ) ) : ?>
    <div id="learndash_course_materials">
        <h4><?php printf( esc_html_x( '%s Materials', 'Course Materials Label', 'education' ), LearnDash_Custom_Label::get_label( 'course' ) ); ?></h4>
        <p><?php printf(esc_html('%s', 'education'), $materials); ?></p>
    </div>
<?php endif; ?>


