<?php
/**
 * Plugin Name: Qwizcards - online quizzes and flashcards
 * Plugin URI: http://qwizcards.com
 * Description: Easy online quizzes and flashcards for WordPress
 * Version: 3.29
 * Author: Dan Kirshner
 * Author URI: http://qwizcards.com
 * License: GPL2
 */
$qwizcards_version = '3.29';

/*  Copyright 2017  Dan Kirshner  (email : dan_kirshner@yahoo.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

define ('PLUGIN_DIR', 'qwiz-online-quizzes-and-flashcards/');
define ('PLUGIN_FILE', 'qwiz-online-quizzes-wp-plugin.php');
define ('BETA_SUBDIR', 'beta/' . PLUGIN_DIR);


// Debug and server loc - varies with environment.
include "plugin_globals.php";

$qwiz_textentry_suggestions_ver = 3.1;

// http: or https: depends on server.  If currently being served under https,
// the WP_Http calls need to be under https.
$http_https_server_loc = $server_loc;
if (stripos ($_SERVER['SERVER_PROTOCOL'], 'https') === true) {
   $http_https_server_loc = preg_replace ('/http:/', 'https:', $server_loc);
}
if ($debug[0]) {
   error_log ('[qwiz-online-quizzes-wp-plugin.php] $http_https_server_loc: ' . $http_https_server_loc);
}

// Get the options array from the WordPress database.
$options = get_option ('qwiz_options');

// -----------------------------------------------------------------------------
function qwiz_language_init () {
   global $debug;

   // Try to load "qwiz-{locale}.mo" from
   //
   //    qwiz-online-quizzes-and-flashcards/languages
   //
   // where {locale} defaults (right now) to en_US (e.g., qwiz-en_US.mo).
   $loaded = load_plugin_textdomain ('qwiz', false, dirname (plugin_basename (__FILE__)) . '/' . qwiz_beta_subdir () . 'languages/');
   if ($debug[0]) {
      error_log ('[qwiz_language_init] $loaded: ' . $loaded);
   }
}


function qwiz_info_report () {
   global $debug, $options, $http_https_server_loc, $wpdb;

   // If it's been more than one week since last sent usage info, do so now and
   // update date-sent record.
   $now_sec = time ();
   if ($now_sec > $options['info_sent_time'] + 24*7*3600) {

      // Gather info -- current counters, how many times qwiz pages and
      // individual quizzes/deck have been accessed.
      $table = $wpdb->prefix . 'postmeta';
      $sql  = "SELECT   post_id,
                        meta_key,
                        meta_value
               FROM     $table
               WHERE    meta_key LIKE 'qwiz%'";
      $rows = $wpdb->get_results ($sql, ARRAY_A);
      $page_urls       = array ();
      $page_quiz_decks = array ();
      $hitss           = array ();
      foreach ($rows as $row) {
         $post_id         = $row['post_id'];
         $permalink     = get_permalink ($post_id);

         // Do if "localhost" not in address (include localhost if local_debug
         // on).
         $local_debug = false;
         if ($local_debug || strpos ($permalink, 'localhost') === false) {
            $page_urls[]        = $permalink;

            //                 0----+----1---      0----+----1----
            // Key looks like "qwiz_hits_page" or "qwiz_hits_quiz0" or
            // "qwiz_hits_deck0".  We're going to boil them down to "p", "q0",
            // "d0"
            $meta_key          = $row['meta_key'];
            $page_quiz_decks[] = substr ($meta_key, 10, 1) . substr ($meta_key, 14);

            $hits              = $row['meta_value'];
            $hitss[]           = $hits;
         }
      }
      if (count ($page_urls)) {
         $body = array ('page_urls'       => json_encode ($page_urls),
                        'page_quiz_decks' => json_encode ($page_quiz_decks),
                        'hits'            => json_encode ($hitss));

         $url = $http_https_server_loc . '/info_report.php';
         $http_request = new WP_Http;
         $result = $http_request->request ($url, array ('method' => 'POST',
                                                        'body'   => $body));
         if ($debug[0]) {
            error_log ('[qwiz_info_report]' . print_r ($result, true));
         }
         if ($result['response']['message'] == 'OK') {
            $options['info_sent_time'] = $now_sec;
            update_option ('qwiz_options', $options);
            if ($debug[0]) {
               error_log ('[qwiz_info_report] info_sent_time:' . $now_sec);
            }
         }
      }
   }
}


function set_qwiz_params () {
   global $debug, $options, $qwiz_T, $qwizcards_version, $server_loc,
          $secure_server_loc;

   // Options/parameters.  Set default content option.
   $plugin_url        = qwiz_plugin_url ( '/');
   $mobile_enabled    = $options['go_mobile'];
   $icon_qwiz         = $options['icon_qwiz'];
   $content           = $options['content'];
   $use_dict          = $options['use_dict'];
   $use_terms         = $options['use_terms'];
   $hint_timeout_sec  = $options['hint_timeout_sec'];
   $hangman_hints     = $options['hangman_hints'];
   $translate_strings = $options['translate_strings'];
   if (isset ($options['info_sent_time'])) {
      $info_sent_time = $options['info_sent_time'];
   } else {
      $info_sent_time = 0;
      $options['info_sent_time'] = 0;
   }
   $post_id = $info_sent_time != -1 ? get_the_ID () : 0;
   if ($debug[5]) {
      error_log ('[set_qwiz_params] $post_id: ' . $post_id);
      $post_obj = get_post ($post_id);
      if ($post_obj) {
         error_log ('[set_qwiz_params] $post_obj->ID: ' . $post_obj->ID);
      }
   }

   // Default for content div selector.
   if (! $content) {
      $content = 'div.entry-content, div.post-entry, div#content';
   }

   // If string substitutions given (from Settings/Admin page), make them now.
   if ($translate_strings) {
      $translate_strings = explode ("\n", $translate_strings);
      $n_translate_strings = count ($translate_strings);
      for ($i=0; $i<$n_translate_strings; $i++) {
         $strings = explode (';', $translate_strings[$i]);
         $old_string = $strings[0];

         // Translation of "Flip" to "Check answer" is default.  Allow "Check
         // answer" to be translated.
         if ($old_string == 'Check answer') {
            $old_string = 'Flip';
         }
         $new_string = trim ($strings[1]);
         $qwiz_T[$old_string] = $new_string;
      }
   }
   $beta = isset ($_SESSION['qwiz_beta']);

   $qwiz_params = array (
      //'T'                => $qwiz_T,    // Added in add_qwiz_js_and_style ().
      'url'              => $plugin_url,
      'mobile_enabled'   => $mobile_enabled,
      'icon_qwiz'        => $icon_qwiz,
      'content'          => $content,
      'beta'             => $beta,
      'server_loc'       => $server_loc,
      'secure_server_loc'=> $secure_server_loc,
      'use_dict'         => $use_dict,
      'use_terms'        => $use_terms,
      'hint_timeout_sec' => $hint_timeout_sec,
      'hangman_hints'    => $hangman_hints,
      'post_id'          => $post_id,
      'ajaxurl'          => admin_url ('admin-ajax.php'),
      'includes_url'     => includes_url (),
      'qwizcards_version'=> $qwizcards_version,
      'wp_server_address'=> $_SERVER['SERVER_ADDR']
   );

   return $qwiz_params;
}


function add_qwiz_js_and_style () {
   global $debug, $qwizcards_version, $options, $qwiz_params, $qwiz_T;

   // Reset default image link option to no link.  (Should still be in effect
   // when click 'Edit page'.)
   update_option ('image_default_link_type', '');

   // JavaScript.
   // Load jQuery independently if option set.
   if ($options['force_jquery_load'] == 1) {
      $jquery = '//code.jquery.com/jquery-3.2.1.min.js';
      wp_enqueue_script ('jquery_handle', $jquery);
   }

   // jQuery-ui components.
   wp_enqueue_script ('jquery-ui-core');
   wp_enqueue_script ('jquery-ui-autocomplete');
   wp_enqueue_script ('jquery-ui-button');
   wp_enqueue_script ('jquery-ui-dialog');
   wp_enqueue_script ('jquery-ui-draggable');
   wp_enqueue_script ('jquery-ui-droppable');
   wp_enqueue_script ('jquery-ui-menu');
   wp_enqueue_script ('jquery-ui-position');
   wp_enqueue_script ('jquery-ui-progressbar');
   wp_enqueue_script ('jquery-ui-resizable');
   wp_enqueue_script ('jquery-ui-tabs');
   wp_enqueue_script ('jquery-ui-tooltip');
   wp_enqueue_script ('jquery-ui-widget');

   // In case an audio or video player shortcode is brought in later (say, via
   // use_dataset=).
   wp_enqueue_style ('wp-mediaelement');
   wp_enqueue_script ('wp-playlist');

   $qwiz_qcards_common   = qwiz_plugin_url ('qwiz_qcards_common.js');
   $qwiz                 = qwiz_plugin_url ('qwiz.js');
   $qwizcards            = qwiz_plugin_url ('qwizcards.js');
   //$jquery_ui            = qwiz_plugin_url ('jquery-ui.min.js');
   $jquery_ui_touchpunch = qwiz_plugin_url ('jquery.ui.touch-punch.min.js');

   wp_enqueue_script ('qwiz_qcards_common_handle',   $qwiz_qcards_common,   array (), $qwizcards_version, true);
   wp_enqueue_script ('qwiz_handle',                 $qwiz,                 array (), $qwizcards_version, true);
   wp_enqueue_script ('qwizcards_handle',            $qwizcards,            array (), $qwizcards_version, true);
   wp_enqueue_script ('jquery_ui_touchpunch_handle', $jquery_ui_touchpunch, array (), $qwizcards_version, true);

   // Send info -- don't do if administrator has opted out.
   if (isset ($options['info_sent_time'])) {
      if ($options['info_sent_time'] != -1) {
         qwiz_info_report ();
      }
   }

   // Set qwiz_T as array of strings.
   $qwiz_T = array ();
   include qwiz_beta_subdir () . "languages/strings_to_translate.php";

   $qwiz_params = set_qwiz_params ();
   $local_qwiz_params = $qwiz_params;
   $local_qwiz_params['T'] = $qwiz_T;
   wp_localize_script ('qwiz_handle',      'qwiz_params', $local_qwiz_params);
   wp_localize_script ('qwizcards_handle', 'qwiz_params', $local_qwiz_params);

   // Stylesheets.
   $qwiz_css             = qwiz_plugin_url ('qwiz.css');
   $qwizcards_css        = qwiz_plugin_url ('qwizcards.css');
   $jquery_ui_styles_css = qwiz_plugin_url ('jquery-ui.css');

   wp_register_style ('qwiz_css_handle',         $qwiz_css,             array (), $qwizcards_version);
   wp_register_style ('qwizcards_css_handle',    $qwizcards_css,        array (), $qwizcards_version);
   wp_register_style ('jquery_ui_styles_handle', $jquery_ui_styles_css, array (), $qwizcards_version);

   wp_enqueue_style ('qwiz_css_handle');
   wp_enqueue_style ('qwizcards_css_handle');
   wp_enqueue_style ('jquery_ui_styles_handle');
}


function qwizzled_button () {
   if (current_user_can ('edit_posts' ) && current_user_can ('edit_pages')) {
      add_filter ('mce_buttons', 'register_qwizzled_buttons');
      add_filter ('mce_external_plugins', 'add_qwizzled_buttons');
   }
}


function register_qwizzled_buttons ($buttons) {
   array_push ($buttons, "button_q");
   return $buttons;
}


function add_qwizzled_buttons ($plugin_array) {
   $plugin_array['qwizzled_button_script'] = qwiz_plugin_url ( 'qwiz_tinymce.js') ;
   return $plugin_array;
}


// Pass info to qwizzled.js via admin_head script.
function set_qwizzled_params () {
   global $debug, $qwiz_params;

   // Set qwiz_T as array of strings.
   $qwiz_T = array ();
   include qwiz_beta_subdir () . "languages/strings_to_translate.php";

   $qwizzled_params = set_qwiz_params ();
   $qwizzled_params['T'] = $qwiz_T;

   $qwizzled_params_json = json_encode ($qwizzled_params);
   print "<script type=\"text/javascript\">\n";
   print "   var qwizzled_params = $qwizzled_params_json;\n";

   // If there's an update message, alert, erase.
   $update_msg = get_option ('update_msg');
   if ($update_msg) {
      $update_msg = addslashes ($update_msg);
      print "qwizzled_params['update_msg'] = '$update_msg';\n";
      update_option ('update_msg', '');
   }
   print "</script>\n";
}


function qwiz_plugin_url ($path) {

   // This is like .../qwiz-online-quizzes-and-flashcards/qwiz.js?ver=2.15.
   $plugin_url = plugins_url ($path, __FILE__);

   $bsub = qwiz_beta_subdir ();
   if ($bsub) {

      // Insert beta version subdir after final '/'.
      $last_slash_pos = strrpos ($plugin_url, '/');
      $plugin_url = substr ($plugin_url, 0, $last_slash_pos + 1) . $bsub
                                   . substr ($plugin_url, $last_slash_pos + 1);
   }

   return $plugin_url;
}

function qwiz_beta_subdir () {
   global $options;

   $bsub = '';
   if (isset ($_SESSION['qwiz_beta']) || (isset ($options['deploy_beta']) && $options['deploy_beta'])) {
      $beta_plugin_file = plugin_dir_path (__FILE__) . BETA_SUBDIR . PLUGIN_FILE;
      if (file_exists ($beta_plugin_file)) {
         $bsub = BETA_SUBDIR;
      }
   }

   return $bsub;
}


function increment_qwiz_deck_usage_exec () {
   global $debug, $wpdb;
   if ($debug[0]) {
      error_log ('[increment_qwiz_deck_usage_exec] $_POST: ' . print_r ($_POST, true));
   }
   $quiz_deck     = $_POST['quiz_deck'];
   $i_qwiz_deck   = $_POST['i_qwiz_deck'];
   $post_id       = $_POST['post_id'];

   $meta_key = 'qwiz_hits_' . $quiz_deck . $i_qwiz_deck;

   $table    = $wpdb->prefix . 'postmeta';
   $sql  = "UPDATE $table
            SET    meta_value = meta_value + 1
            WHERE      post_id  = %d
                   AND meta_key = %s";
   $sql = $wpdb->prepare ($sql, $post_id, $meta_key);
   $affected_rows = $wpdb->query ($sql);
   if ($debug[0]) {
      error_log ('[increment_qwiz_deck_usage_exec] $sql: ' . $sql);
      error_log ('[increment_qwiz_deck_usage_exec] $affected_rows: ' . $affected_rows);
   }
   if ($affected_rows === 0) {
      $sql  = "INSERT INTO $table
               SET   post_id    = %d,
                     meta_key   = %s,
                     meta_value = 1";
      $sql = $wpdb->prepare ($sql, $post_id, $meta_key);
      $affected_rows = $wpdb->query ($sql);
      if ($debug[0]) {
         error_log ('[increment_qwiz_deck_usage_exec] $sql: ' . $sql);
         error_log ('[increment_qwiz_deck_usage_exec] $affected_rows: ' . $affected_rows);
      }
      if ($affected_rows === false) {
         error_log ("[increment_qwiz_deck_usage_exec] unable to insert into $table");
      }
   }
   print 'increment_qwiz_deck_usage_exec OK';

   wp_die ();  // Required to terminate and return proper response.
}


// Retrieve questions for a dataset from Qwizcards server, pass through
// the_content filter, return to ajax caller.
function qwiz_get_dataset_questions () {
   global $debug, $http_https_server_loc;

   if ($debug[5]) {
      error_log ('[qwiz_get_dataset_questions] $_POST: ' . print_r ($_POST, true));
   }
   $dataset             = $_POST['dataset'];
   $qname               = $_POST['qname'];
   $i_qwiz_qdeck        = $_POST['i_qwiz_qdeck'];
   $qrecord_id          = $_POST['qrecord_id'];
   $b64_units           = $_POST['units'];
   $b64_topics          = $_POST['topics'];
   $n_questions_in_set  = $_POST['n_questions_in_set'];
   //DKTMP
   $questions_to_do = 'spaced_repetition';
   if (isset ($_POST['questions_to_do'])) {
      $questions_to_do  = $_POST['questions_to_do'];
   }
   $qwiz_session_id     = $_POST['qwiz_session_id'];
   $page_url = '';
   if (isset ($_POST['page_url'])) {
      $page_url         = $_POST['page_url'];
   }
   $b64_use_dataset_question_ids = '';
   if (isset ($_POST['use_dataset_question_ids'])) {
      $b64_use_dataset_question_ids = $_POST['use_dataset_question_ids'];
   }
   $body = array ('dataset'                  => $dataset,
                  'qname'                    => $qname,
                  'i_qwiz_qdeck'             => $i_qwiz_qdeck,
                  'qrecord_id'               => $qrecord_id,
                  'units'                    => $b64_units,
                  'topics'                   => $b64_topics,
                  'n_questions_in_set'       => $n_questions_in_set,
                  'questions_to_do'          => $questions_to_do,
                  'qwiz_session_id'          => $qwiz_session_id,
                  'page_url'                 => $page_url,
                  'use_dataset_question_ids' => $b64_use_dataset_question_ids);
   $url = $http_https_server_loc . '/get_dataset_questions_v2.php';
   $http_request = new WP_Http;

   // Result is json-encoded data.
   if ($debug[5]) {
      error_log ('[qwiz_get_dataset_questions] $body: ' . print_r ($body, true));
   }
   $result = $http_request->request ($url, array ('method'  => 'POST',
                                                  'timeout' => 20,    // Seconds.
                                                  'body'    => $body));
   if ($debug[5]) {
      error_log ('[qwiz_get_dataset_questions] result: ' . print_r ($result, true));
   }
   $data_array = json_decode ($result['body']);
   if ($debug[5]) {
      error_log ('[qwiz_get_dataset_questions] data_array: ' . print_r ($data_array, true));
   }
   $questions_html = $data_array->questions_html;
   $questions_html = $questions_html[0];

   // For some reason "the_content" filter applied here does not process [embed]
   // shortcodes, nor oembed links.  Can do so "manually."
   $questions_html = qwiz_filter_embeds ($questions_html);
   if ($debug[5]) {
      error_log ('[qwiz_get_dataset_questions] questions_html: ' . print_r ($questions_html, true));
   }

   $filtered_questions_html = apply_filters ('the_content', $questions_html);
   if ($debug[5]) {
      error_log ('[qwiz_get_dataset_questions] filtered_questions_html: ' . print_r ($filtered_questions_html, true));
   }
   $data_array->questions_html = $filtered_questions_html;

   // Response to callback can be simple print of json-encoded data.  Decode-
   // encode: some incompatibility between PHP and JavaScript json?
   wp_send_json ($data_array);

   wp_die ();  // Required to terminate and return proper response.
}


function qwiz_filter_embeds ($html) {
   global $debug;

   // First.  Look for links by themselves on a line, pass through oembed.
   $n_links = preg_match_all ('/^\s*(http:\/\/|https:\/\/)\S+\s*$/m', $html, $matches, PREG_SET_ORDER);
   if ($debug[5]) {
      error_log ('[qwiz_filter_embeds] $matches: ' . print_r ($matches, true));
   }
   for ($i=0; $i<$n_links; $i++) {
      $url = trim ($matches[$i][0]);
      $embed_html = wp_oembed_get ($url);

      // Replace the link.
      $html = preg_replace ('/^\s*(http:\/\/|https:\/\/|\/\/)\S+\s*$/m', $embed_html, $html, 1);
   }

   // Second.  Look for [embed] shortcodes, and see if width and/or height
   // attributes.
   $n_embeds = preg_match_all ('/\[embed[^\]]*\](.*?)\[\/embed\]/', $html, $matches, PREG_SET_ORDER);
   if ($debug[5]) {
      error_log ('[qwiz_filter_embeds] $matches: ' . print_r ($matches, true));
   }
   for ($i=0; $i<$n_embeds; $i++) {
      $embed = $matches[$i][0];

      // See if width and/or height attributes.
      $attr = array ();
      $width  = qwiz_get_attr ($embed, 'width');
      if ($width) {
         $attr['width'] = $width;
      }
      $height = qwiz_get_attr ($embed, 'height');
      if ($height) {
         $attr['height'] = $height;
      }
      $url = trim ($matches[$i][1]);

      // Get iframe html.
      $embed_html = wp_oembed_get ($url, $attr);

      // Replace this [embed]...[/embed] pair.
      $html = preg_replace ('/\[embed.*?\[\/embed\]/', $embed_html, $html, 1);
   }

   return $html;
}


function qwiz_process_embeds () {
   global $debug;
   if ($debug[0]) {
      error_log ('[qwiz_process_embeds] $_POST: ' . print_r ($_POST, true));
   }

   // For each url, convert to embed code.
   $urls = json_decode (urldecode ($_POST['urls']), true);
   if ($debug[0]) {
      error_log ('                      $urls: ' . print_r ($urls, true));
   }
   $embed_htmls = array ();
   $n_urls = count ($urls);
   for ($i=0; $i<$n_urls; $i++) {
      $embed_htmls[] = wp_oembed_get ($urls[$i]);
   }
   if ($debug[0]) {
      error_log ('[qwiz_process_embeds] $embed_htmls: ' . print_r ($embed_htmls, true));
   }
   wp_send_json ($embed_htmls);

   wp_die ();  // Required to terminate and return proper response.
}


// =============================================================================
add_action ('plugins_loaded', 'qwiz_language_init');

add_action ('wp_enqueue_scripts', 'add_qwiz_js_and_style');

add_action ('admin_init', 'qwizzled_button');

add_action ('wp_ajax_increment_qwiz_deck_usage', 'increment_qwiz_deck_usage_exec');
add_action ('wp_ajax_nopriv_increment_qwiz_deck_usage', 'increment_qwiz_deck_usage_exec');

add_action ('wp_ajax_get_dataset_questions', 'qwiz_get_dataset_questions');
add_action ('wp_ajax_nopriv_get_dataset_questions', 'qwiz_get_dataset_questions');

add_action ('wp_ajax_process_embeds', 'qwiz_process_embeds');
add_action ('wp_ajax_nopriv_process_embeds', 'qwiz_process_embeds');

// Pass plugin url, etc. to qwiz_tinymce.js/qwizzled.js.
add_action ('admin_head', 'set_qwizzled_params');

function qwizzled_add_locale ($locales) {
    $locales ['qwizzled_langs'] = plugin_dir_path (__FILE__) . qwiz_beta_subdir () . 'languages/qwizzled_langs.php';
    //error_log ("[qwizzled_add_locale] locales: " . print_r ($locales, TRUE));
    return $locales;
}
add_filter ('mce_external_languages', 'qwizzled_add_locale');


// =============================================================================
/*
function qwiz_change_mce_options ($mceInit) {
   $mceInit['paste_preprocess']
      = 'function (pl, o) {
            console.log ("[qwiz_change_mce_options] o.content: ", o.content);
            o.content = "[[" + o.content + "]]";
         }';
   //error_log ("[qwiz_change_mce_options] mceInit: " . print_r ($mceInit, true));

   return $mceInit;
}

add_filter ('tiny_mce_before_init', 'qwiz_change_mce_options');
*/


// =============================================================================
/**
 * Customize TinyMCE's configuration
 *
 * @param   array
 * @return  array
 */
function configure_tinymce ($in) {
   $in['paste_preprocess']
      = "function (plugin, args) {
            var stripped = jQuery ('<div>' + args.content + '</div>');

            /*
            // Strip all HTML tags except those in whitelist.
            var whitelist = 'p,span,b,strong,i,em,h3,h4,h5,h6,ul,li,ol';
            var els = stripped.find ('*').not (whitelist);
            for (var i=els.length - 1; i>=0; i--) {
               var e = els[i];
               jQuery (e).replaceWith (e.innerHTML);
            }
            */

            // Strip class and id attributes.
            stripped.find ('*').removeAttr('id').removeAttr ('class');

            // Return the clean HTML.
            args.content = stripped.html();
         }";

   // Retain color etc. when pasting from MS Word.
   $in['paste_retain_style_properties'] = 'all';

   return $in;
}

add_filter ('tiny_mce_before_init', 'configure_tinymce');


// =============================================================================
function qwiz_admin_bar_item ($wp_admin_bar) {

   $args = array (
      'id'     => 'qwiz_menu',
      'title'  => 'Qwizcards'
   );
   $wp_admin_bar->add_node ($args);

   $args = array (
      'id'     => 'qwiz_menu_keep_next_active',
      'parent' => 'qwiz_menu',
      'title'  => 'Keep "next" button active',
      'href'   => '#',
      'meta'   => array ('onclick' => 'qwiz_.keep_next_button_active (); qcard_.keep_next_button_active (); return false;',
                         'title'   => 'Allows you to skip questions/cards')
   );
   $wp_admin_bar->add_node ($args);
}


add_action ('admin_bar_menu', 'qwiz_admin_bar_item', 999);


// =============================================================================
// For each post, look through for [qwiz]...[/qwiz] or [qdeck]...[/qdeck] valid
// pairs.  If all valid (exclude those within [qwizdemo] or [qcarddemo] pairs),
// then, wrap each in a div, with class for no display.  qwiz.js and
// qwizcards.js will rewrite those divs within the DOM, which will avoid
// clobbering events bound elsewhere (rewriting the html does the clobbering).
function qwiz_process_shortcodes_initially ($content) {
   global $debug, $secure_server_loc;

   if (   strpos ($content, '[qwiz')      !== false
       || strpos ($content, '[qdeck')     !== false
       || strpos ($content, '[qscores')   !== false
       || strpos ($content, '[qfeedback') !== false) {

      // [qwizdemo] and [qcarddemo] contents -- save, replace with placeholder
      // (restore when done).
      list ($content, $qwizdemos)  = qwiz_cut_demos ($content, 'qwiz');
      list ($content, $qdeckdemos) = qwiz_cut_demos ($content, 'qdeck');

      // If not editor of this page, delete [qfeedback]...[/qfeedback].
      $author_id = get_the_author_meta ('ID');
      $user_id   = get_current_user_id ();
      if (! ($user_id == $author_id || current_user_can ('editor') || current_user_can ('administrator'))) {
         $match_pat = "/\[qfeedback\][\s\S]*?\[\/qfeedback\]/";
         $content = preg_replace ($match_pat, '', $content);
      } else {

         // For editors, when viewing, delete just the shortcodes.
         $content = preg_replace ("/\[qfeedback\]|\[\/qfeedback\]/", '', $content);
      }

      // If there are any qwizard bookmarks, delete.
      $content = preg_replace ('/<span id="qbookmark[^<]+<\/span>/m', '', $content);

      // Check that have valid [qwiz] and [qdeck] open/close pairs.
      if (qwiz_check_shortcode_pairs_ok ($content, 'qwiz')
                         && qwiz_check_shortcode_pairs_ok ($content, 'qdeck')) {

         // Yes, valid pairs.  Preface content with one empty wrapper div of
         // each type: signals we're on WordPress.  (Do only if valid pairs
         // so that JavaScript can separately catch and report the error.)
         $content =   '<div class="qwiz_wrapper"  style="display: none;"></div>'
                    . '<div class="qdeck_wrapper" style="display: none;"></div>'
                    . $content;

         // Wrap each such pair, but make sure balanced <div> ... </div>
         // tag pairs inside (move unmatched tags outside).
         $content = qwiz_wrap_shortcode_pairs ($content, 'qwiz');
         $content = qwiz_wrap_shortcode_pairs ($content, 'qdeck');

         // Also, save hits for periodic reporting.
         qwiz_increment_page_hits ();
      }

      // Replace [qscores] with span.
      $content = str_replace ('[qscores]', '<span class="qscores"><a href="' . $secure_server_loc . '/student_login.php" target="_blank">Login/View scores</a></span>', $content);

      // Restore demo contents, without the opening/closing shortcodes.
      $content = qwiz_unwrap_and_paste_demos ($content, $qwizdemos, 'qwiz');
      $content = qwiz_unwrap_and_paste_demos ($content, $qdeckdemos, 'qdeck');
      if ($debug[1]) {
         error_log ("[qwiz_process_shortcodes_initially] content:\n" . $content);
      }
   }

   return $content;
}


// Find qwizdemo or qdeckdemo pairs, replace with placeholder, return for
// save.
function qwiz_cut_demos ($content, $qwiz_qdeck) {

   // Grab content of demo pair with subexpression.
   $match_pat = "/\[${qwiz_qdeck}demo\]([\s\S]*?)\[\/${qwiz_qdeck}demo\]/";
   preg_match_all ($match_pat, $content, $matches, PREG_SET_ORDER);

   $replace_pat = "${qwiz_qdeck}_PLACEHOLDER";
   $content = preg_replace ($match_pat, $replace_pat, $content);

   return array ($content, $matches);
}


function qwiz_unwrap_and_paste_demos ($content, $demos, $qwiz_qdeck) {
   $n_demos = count ($demos);
   $match_pat = "/${qwiz_qdeck}_PLACEHOLDER/";
   for ($i=0; $i<$n_demos; $i++) {

      // Get the subexpression (demo pair content).
      $demo = $demos[$i][1];

      // Do one at a time.
      $content = preg_replace ($match_pat, $demo, $content, 1);
   }

   return $content;
}


function qwiz_wrap_shortcode_pairs ($content, $qwiz_qdeck) {

   // Find [qwiz] ... [/qwiz] pairs and content.  Include opening/closing
   // <p>, <h*>, and <span> tags.
   $qmatch_pat = "/(<(p|h|span)[^>]*>\s*)*\[${qwiz_qdeck}[\s\S]*?\[\/$qwiz_qdeck\](<\/(p|h|span)[^>]*>\s*)*/";
   $n_qwiz_qdecks = preg_match_all ($qmatch_pat, $content, $matches, PREG_SET_ORDER);

   // Also find "pieces" outside [qwiz] ... [/qwiz] pairs.
   $pieces = preg_split ($qmatch_pat, $content);

   // Process each [qwiz] ... [/qwiz] pair contents.
   $new_content = array ($pieces[0]);
   for ($i=0; $i<$n_qwiz_qdecks; $i++) {
      $qcontent = $matches[$i][0];
      $modified_qwiz_qdeck = qwiz_check_fix_wrap_matched_divs ($qcontent, $qwiz_qdeck);

      // Change images to tag that won't be loaded; qwiz.js/qwizcards.js will
      // change back when question/card displayed.  Don't do if inside [caption]
      // shortcode.
      $modified_qwiz_qdeck = qwiz_encode_image_tags ($modified_qwiz_qdeck);
      array_push ($new_content, $modified_qwiz_qdeck);
      array_push ($new_content, $pieces[$i+1]);
   }

   return implode ('', $new_content);
}


function qwiz_check_fix_wrap_matched_divs ($qcontent, $qwiz_qdeck) {
   global $debug;

   // Find all opening/closing divs.
   $div_match_pat = "/<div[^>]*>|<\/div>/";
   $n_tags = preg_match_all ($div_match_pat, $qcontent, $div_matches, PREG_SET_ORDER);

   // Loop over tags.  Mark matches.
   $matched_pair_b = array ();
   for ($i=0; $i<$n_tags; $i++) {
      array_push ($matched_pair_b, false);
      $tag = $div_matches[$i][0];
      if (substr ($tag, 0, 2) == '</') {

         // Closing </div>.  Look for previous unmatched opening <div>.  If
         // found, mark pair as matched.
         for ($jj=$i-1; $jj>=0; $jj--) {
            if (substr ($div_matches[$jj][0], 0, 2) == '<d' && ! $matched_pair_b[$jj]) {
               $matched_pair_b[$jj] = true;
               $matched_pair_b[$i] = true;
               break;
            }
         }
      }
   }

   // Move unmatched tags to after [qwiz]...[/qwiz] pair.  First split this
   // pair's contents on div tags.
   $pieces = preg_split ($div_match_pat, $qcontent);

   // Prepend wrapper.
   $new_qcontent = array ("<div class=\"${qwiz_qdeck}_wrapper qwiz_shortcodes_hidden\">\n");

   // In case qwiz or qdeck content is brought in after page load
   // (document.ready () won't see that content!).
   $fallback =   '<div class="' . $qwiz_qdeck . '_wrapper_fallback ' . $qwiz_qdeck . '_wrapper_fallback_visible">'
               .    '<button onclick="qwiz_.qwiz_init (); qcard_.qdeck_init (); flipping_cards_part2 ()">'
               .        'Click here to start ' . ($qwiz_qdeck == 'qwiz' ? 'quiz' : 'flashcard deck')
               .    '</button>'
               . '</div>';
   array_push ($new_qcontent, $fallback);

   // Put back together with divs, except those unmatched.
   array_push ($new_qcontent, $pieces[0]);
   for ($i=0; $i<$n_tags; $i++) {
      if ($matched_pair_b[$i]) {
         if ($debug[2]) {
            error_log ('[qwiz_check_fix_wrap_matched_divs] matched pair tag html: ' . qwiz_summary ($div_matches[$i][0], 100));
         }
         $tag = $div_matches[$i][0];
         array_push ($new_qcontent, $tag);
      }
      array_push ($new_qcontent, $pieces[$i+1]);
   }

   // Close wrapper.
   array_push ($new_qcontent, "\n</div>  <!-- ${qwiz_qdeck}_wrapper -->\n");

   // Finally, add unmatched divs afterword.
   for ($i=0; $i<$n_tags; $i++) {
      if (! $matched_pair_b[$i]) {
         if ($debug[2]) {
            error_log ('[qwiz_check_fix_wrap_matched_divs] unmatched pair tag html: ' . qwiz_summary ($div_matches[$i][0], 100));
         }
         $tag = $div_matches[$i][0];
         array_push ($new_qcontent, $tag);
      }
   }

   return implode ('', $new_qcontent);
}


// Change images to tag that won't be loaded; qwiz.js/qwizcards.js will change
// back when question/card displayed.  Don't do if inside [caption] shortcode.
function qwiz_encode_image_tags ($qwiz_qdeck_content) {

   // Find images with and without [caption...] shortcode in front of them.
   $n_images = preg_match_all ('/(\[caption[^\]]*\])*<img/', $qwiz_qdeck_content, $matches, PREG_OFFSET_CAPTURE);

   // Element 0 is array over matches of two-element arrays (whole-query match
   // and offset), element 1 is array over matches of subquery two-element
   // arrays (sub-query match and offset).  So just look at element 0.
   // Do in reverse order so offsets still valid.
   for ($i=$n_images-1; $i>=0; $i--) {

      // Is it a caption?  Skip.
      $match = $matches[0][$i][0];
      if (substr ($match, 0, 1) == '[') {
         continue;
      } else {

         // No caption.  Do replace.  Only do one replace!
         $i_offset = $matches[0][$i][1];
         $remaining = substr ($qwiz_qdeck_content, $i_offset);
         $new_remaining = preg_replace ('/<img/', '<input name="qwiz_img"', $remaining, 1);
         $qwiz_qdeck_content = substr ($qwiz_qdeck_content, 0, $i_offset) . $new_remaining;
      }
   }

   return $qwiz_qdeck_content;
}


function qwiz_check_shortcode_pairs_ok ($content, $qwiz_qdeck) {
   global $debug;

   $error_b = false;
   $n_qwiz_qdecks = preg_match_all ("/\[$qwiz_qdeck|\[\/$qwiz_qdeck\]/", $content, $matches, PREG_SET_ORDER);
   if ($debug[2]) {
      error_log ("[qwiz_check_shortcode_pairs_ok] n_${qwiz_qdeck}_s: $n_qwiz_qdecks");
   }
   if ($n_qwiz_qdecks) {
      if ($n_qwiz_qdecks % 2 != 0) {
         $error_b = true;
      } else {

         // Check proper pairs.
         for ($i=0; $i<$n_qwiz_qdecks; $i++) {
            $shortcode = $matches[$i][0];
            if ($i % 2 == 0) {
               if ($shortcode != "[$qwiz_qdeck") {
                  $error_b = true;
                  break;
               }
            } else {
               if ($shortcode != "[/$qwiz_qdeck]") {
                  $error_b = true;
                  break;
               }
            }
         }
      }
   }

   $ok_b = ! $error_b;
   if ($debug[2]) {
      error_log ("[qwiz_check_shortcode_pairs_ok] ok_b: $ok_b");
   }

   return $ok_b;
}


function qwiz_increment_page_hits () {
   global $debug, $wpdb;

   $table    = $wpdb->prefix . 'postmeta';
   $post_id  = get_the_ID ();
   $sql  = "UPDATE $table
            SET    meta_value = meta_value + 1
            WHERE      post_id  = $post_id
                   AND meta_key = 'qwiz_hits_page'";
   $affected_rows = $wpdb->query ($sql);
   if ($debug[0]) {
      error_log ('[qwiz_increment_page_hits] $sql: ' . $sql);
      error_log ('[qwiz_increment_page_hits] $affected_rows: ' . $affected_rows);
   }
   if ($affected_rows === 0) {
      $sql  = "INSERT INTO $table
               SET   post_id    = $post_id,
                     meta_key   = 'qwiz_hits_page',
                     meta_value = 1";
      $affected_rows = $wpdb->query ($sql);
      if ($affected_rows === false) {
         error_log ("[qwiz_increment_page_hits] unable to insert into $table");
      }
   }
}


function qwiz_summary ($txt, $summary_len) {
   $txtlen = strlen ($txt);
   if ($txtlen > 2*$summary_len) {
      $errtxt = substr ($txt, 0, $summary_len)
                . ' ... ' . substr ($txt, -$summary_len);
   } else {
      $errtxt = $txt;
   }

   return $errtxt;
}


add_filter ('the_content', 'qwiz_process_shortcodes_initially');


// =============================================================================
add_action ('wp_ajax_textentry_suggestions', 'qwiz_textentry_suggestions');
add_action ('wp_ajax_nopriv_textentry_suggestions', 'qwiz_textentry_suggestions');

function qwiz_textentry_suggestions () {
   global $wpdb, $debug;

   if ($debug[4]) {
      error_log ('[qwiz_textentry_suggestions] $_POST: ' . print_r ($_POST, true));
   }
   $entry           = urldecode ($_POST['entry']);
   $entry_metaphone = urldecode ($_POST['entry_metaphone']);
   $n_hints         = $_POST['n_hints'];
   $terms           = $_POST['terms'];
   $plural_f        = $_POST['plural_f'] == 1;

   $terms = str_replace ("\\\"", '"', $terms);
   if ($debug[4]) {
      error_log ('[qwiz_textentry_suggestions] $terms: ' . print_r ($terms, true));
      error_log ('[qwiz_textentry_suggestions] gettype ($terms): ' . gettype ($terms));
      error_log ('[qwiz_textentry_suggestions] count ($terms): ' . count ($terms));
   }
   $terms = json_decode (urldecode ($terms));
   if ($debug[4]) {
      error_log ('[qwiz_textentry_suggestions] $terms: ' . print_r ($terms, true));
      error_log ('[qwiz_textentry_suggestions] count ($terms): ' . count ($terms));
   }

   $hint_clause = '';
   if ($n_hints > 0) {
      $hint = substr ($entry, 0, $n_hints);
      $hint_clause = "AND word LIKE %s";
      $hint_like = $hint . '%';
   }
   $n_chars = strlen ($entry);
   $limit = 15;
   $table = $wpdb->prefix . 'qwiz_textentry_suggestions';
   $sql  = "SELECT   word
            FROM     $table
            WHERE        word LIKE %s
                     OR  (metaphone LIKE %s $hint_clause)
            ORDER BY SUBSTR(word, 1, %d) != %s, word
            LIMIT $limit";

   $entry_like     = $entry           . '%';
   $metaphone_like = $entry_metaphone . '%';
   if ($n_hints > 0) {
      $sql = $wpdb->prepare ($sql, $entry_like, $metaphone_like, $hint_like,
                                   $n_chars, $entry);
   } else {
      $sql = $wpdb->prepare ($sql, $entry_like, $metaphone_like,
                                   $n_chars, $entry);
   }
   $rows = $wpdb->get_results ($sql, ARRAY_N);
   if ($debug[4]) {
      error_log ('[qwiz_textentry_suggestions] $sql: ' . $sql);
      error_log ('[qwiz_textentry_suggestions] count ($rows): ' . count ($rows));
   }

   $suggestions = array ();
   foreach ($rows as $row) {
      if ($plural_f) {
         $suggestions[] = pluralize ($row[0]);
      } else {
         $suggestions[] = $row[0];
      }
   }

   // If terms, concatenate and resort by same criteria as in query.
   if (count ($terms)) {
      $suggestions = array_merge ($suggestions, $terms);

      // Set up a sort key.
      $sort_key = array ();
      foreach ($suggestions as $suggestion) {
         $suggestion = strtolower ($suggestion);
         $a_z = substr ($suggestion, 0, $n_chars) == $entry ? 'a' : 'z';
         $sort_key[] = $a_z . $suggestion;
      }
      if ($debug[4]) {
         error_log ('[qwiz_textentry_suggestions] $suggestions: ' . print_r ($suggestions, true));
         error_log ('[qwiz_textentry_suggestions] $sort_key: ' . print_r ($sort_key, true));
      }
      array_multisort ($sort_key, SORT_NATURAL | SORT_FLAG_CASE , $suggestions);

      // Dedup.
      $suggestions = array_unique ($suggestions);

      // Only the first n.
      $suggestions = array_slice ($suggestions, 0, $limit);
   }

   if ($debug[4]) {
      error_log ('[qwiz_textentry_suggestions] $suggestions: ' . print_r ($suggestions, true));
   }

   wp_send_json ($suggestions);
}


function pluralize ($term_i) {

   // If already ends in 'es', do nothing.  If ends in "y", substitute "ies";
   // if ends in "s" or "sh" or "ch", add "es"; if ends in "x", do nothing;
   // otherwise, just add "s".
   $last_char = substr ($term_i, -1);
   $last_2_chars = substr ($term_i, -2);
   if ($last_2_chars == 'es') {
      $term_i_plural = $term_i;
   } else if ($last_char == 'y') {
      $term_i_plural = substr ($term_i, 0, -1) . 'ies';
   } else if ($last_char == 's' || $last_2_chars == 'sh' || $last_2_chars == 'ch') {
      $term_i_plural = $term_i . 'es';
   } else if ($last_char == 'x') {
      $term_i_plural = $term_i;
   } else {
      $term_i_plural = $term_i . 's';
   }

   return $term_i_plural;
}


// =============================================================================
// Install/update (if any changes to structure) table, delete data (if any),
// load new data.
function textentry_suggestions_db_install () {
   global $wpdb, $qwiz_textentry_suggestions_ver, $debug;

   $table = $wpdb->prefix . 'qwiz_textentry_suggestions';
   $charset_collate = $wpdb->get_charset_collate();
   $sql =  "CREATE TABLE $table (
               word           varchar(31) NOT NULL,
               metaphone      varchar(31),
               UNIQUE KEY (word),
               KEY (metaphone)
            ) $charset_collate;";
   if ($debug[3]) {
      error_log ('[textentry_suggestions_db_install] $sql: ' . $sql);
   }

   // dbDelta () will make suitable changes if table's structure (above) has
   // changed from previously-created table's structure.
   require_once (ABSPATH . 'wp-admin/includes/upgrade.php');
   dbDelta ($sql);

   // Delete and re-load data if new version.
   $current_qwiz_textentry_suggestions_ver = get_option ('qwiz_textentry_suggestions_ver');
   if ($debug[3]) {
      error_log ('[textentry_suggestions_db_install] $current_qwiz_textentry_suggestions_ver: ' . $current_qwiz_textentry_suggestions_ver);
   }
   if ($current_qwiz_textentry_suggestions_ver != $qwiz_textentry_suggestions_ver) {

      // Record that has been installed/updated.  (update_option () does add if
      // option not there.)
      update_option ('qwiz_textentry_suggestions_ver', $qwiz_textentry_suggestions_ver);

      // Delete data.
      $table = $wpdb->prefix . 'qwiz_textentry_suggestions';
      $sql  = "DELETE FROM $table";
      $deleted_rows = $wpdb->query ($sql);
      if ($debug[3]) {
         error_log ('[textentry_suggestions_db_install] $sql: ' . $sql);
         error_log ('[textentry_suggestions_db_install] $deleted_rows: ' . $deleted_rows);
      }

      // Load new data.  Read from data file, do inserts in 20,000-line chunks
      // (avoid exceeding MySQL max_packet_allowed).
      $suggestions_data_file = plugin_dir_path (__FILE__) . 'textentry_suggestions.txt';

      $sql_part1  = "INSERT INTO $table
                     (word, metaphone)
                     VALUES\n";
      $fh = fopen ($suggestions_data_file, 'r');
      $n_lines = 0;
      $value_lines = array ();
      while ($line = fgets ($fh)) {
         $n_lines++;
         $line = trim ($line);
         $fields = explode ("\t", $line);
         $value_line = '("' . $fields[0] . '","' . $fields[1] . '")';
         $value_lines[] = $value_line;
         if ($n_lines == 20000) {
            qwiz_textentry_suggestions_insert ($sql_part1, $value_lines);

            // Reset to start on next chunk.
            $value_lines = array ();
            $n_lines = 0;
         }
      }

      // Finish up any remaining.
      if ($n_lines) {
         qwiz_textentry_suggestions_insert ($sql_part1, $value_lines);
      }

      /* LOAD DATA INFILE - suffers permission problems on Hostmonster,
       * presumably others.
      // MySQL needs file in Unix format.  On Windows, get rid of "C:", replace
      // backslashes with forward slashes.
      $suggestions_data_file = preg_replace ('/^.:/', '', $suggestions_data_file);
      $suggestions_data_file = preg_replace ('/\\\\/', '/', $suggestions_data_file);
      $sql  = "LOAD DATA INFILE     '$suggestions_data_file'
               REPLACE INTO TABLE   $table
               (word, metaphone)";
      $affected_rows = $wpdb->query ($sql);
      if ($debug[3]) {
         error_log ('[textentry_suggestions_db_install] $sql: ' . $sql);

         // For whatever reason, always shows 0.
         //error_log ('[textentry_suggestions_db_install] $affected_rows: ' . $affected_rows);
      }
       */
   }
}


function qwiz_textentry_suggestions_insert ($sql_part1, $value_lines) {
   global $wpdb, $debug;

   $values = implode (',', $value_lines);
   $sql = $sql_part1 . $values;

   $affected_rows = $wpdb->query ($sql);
   if ($debug[3]) {
      error_log ('[qwiz_textentry_suggestions_insert] $sql: ' . substr ($sql, 0, 500) . '...\n');

      // For whatever reason, always shows 0.
      //error_log ('[textentry_suggestions_db_install] $affected_rows: ' . $affected_rows);
   }
}


// Call when plugin activated.
register_activation_hook (__FILE__, 'textentry_suggestions_db_install');


// .............................................................................
// Check if new version of plugin has new version of suggestions table/data.
function qwiz_check_textentry_suggestions_update () {
   global $qwiz_textentry_suggestions_ver, $debug;

   $current_qwiz_textentry_suggestions_ver = get_option ('qwiz_textentry_suggestions_ver');
   if ($debug[3]) {
      error_log ('[qwiz_check_textentry_suggestions_update] $current_qwiz_textentry_suggestions_ver: ' . $current_qwiz_textentry_suggestions_ver);
   }
   if ($current_qwiz_textentry_suggestions_ver != $qwiz_textentry_suggestions_ver) {
      textentry_suggestions_db_install ();
   }
}

// Call when plugin loaded.
add_action ('plugins_loaded', 'qwiz_check_textentry_suggestions_update');


// -----------------------------------------------------------------------------
// Make sure scaling in viewport meta tag.
/* DKTMP
add_action ('wp_head', 'qwiz_viewport_scaling');
function qwiz_viewport_scaling () {

   print '<meta name="viewport" content="width=device-width, initial-scale=1.0">' . "\n";
}
 */


// =============================================================================
// On each save, check if there's a qwiz or deck that should be added to or
// updated in central db.
function check_for_qwizcards_db_dataset ($post_id) {
   global $debug;

   // Get post object.  If autosave or not page, don't do.
   if ($debug[5]) {
      error_log ('[check_for_qwizcards_db_dataset] $post_id: ' . $post_id);
   }
   $post_obj = get_post ($post_id);
   $post_name = $post_obj->post_name;
   $post_type = $post_obj->post_type;
   if (strpos ($post_name, 'autosave') !== false || $post_type != 'page') {
      return;
   }

   // Get content.
   $html = $post_obj->post_content;
   if ($debug[6]) {
      error_log ('[check_for_qwizcards_db_dataset] $post_obj: ' . print_r ($post_obj, true));
   }

   // Look for any dataset= or use_dataset= quizzes/decks.
   $i_pos = strpos ($html, 'dataset=');
   if ($i_pos === false) {
      return;
   }

   // Find dataset= quizzes/decks.  Parse out questions/cards.  Number/renumber
   // with current order.  For those with no ID, add ID, update and save
   // content, and add to database.  For those questions/cards with IDs, see if
   // IDs are consistent with current quiz/deck dataset name (since may have
   // changed).  Compare with database; if changed, save new version of
   // question/card.

   // Also, if there is in the database for this dataset a non-blank question/
   // card that is not here in the current source now (maker deleted it during
   // editing) then save new version of the question/card with blank HTML.
   $dataset_html = qwiz_update_datasets ($html, $post_id);

   // If change to content (IDs added), update version in wp_posts table.
   if ($dataset_html) {

      // Unhook action -- avoid infinite loop.
      remove_action ('save_post', 'check_for_qwizcards_db_dataset');

      // Now update the post.
      if ($debug[5]) {
         error_log ('[check_for_qwizcards_db_dataset] $post_id: ' . $post_id . ', $post_obj->ID: ' . $post_obj->ID);
         error_log ('[check_for_qwizcards_db_dataset] substr ($dataset_html, 0, 500): ' . substr ($dataset_html, 0, 500));
      }
      $post_obj->post_content = $dataset_html;
      wp_update_post ($post_obj);

      // Re-hook action.
      add_action ('save_post', 'check_for_qwizcards_db_dataset');
   }

   // Look for use_dataset quizzes/decks.  In case any that are registered (have
   // qrecord_id) were changed (different dataset, or different units/
   // topics), update the central database questions-per-unit counts for
   // each such quiz/deck.  First parse out the qrecord_ids.
   list ($qrecord_ids, $datasets, $qrecord_id_n_questions)
                                               = qwiz_parse_qrecord_ids ($html);
   if ($qrecord_ids) {
      qwiz_qdeck_unit_counts_to_db ($qrecord_ids, $datasets, $qrecord_id_n_questions);
   }
}
add_action ('save_post', 'check_for_qwizcards_db_dataset');

// function qwiz_update_datasets ($html, $post_id)
// function qwiz_parse_dataset_questions ($html);
// function compare_dataset_questions ($qdata, $prev_qdata, $prev_any_dataset_id_f)
// function qwiz_update_dataset_ids ($qwiz_qdeck_poss, $qwiz_qdeck_lens, $qdata, $html)
// function qwiz_create_dataset_id ($dataset)
// function qwiz_blank_deleted_dataset_questions ($dataset_ids_to_blank, $qdata)
// function qwiz_parse_qrecord_ids ($html)
include 'qwiz_update_datasets.php';

// function qwiz_get_attr ($shortcode, $attribute) {
include 'qwiz_get_attr.php';


// -----------------------------------------------------------------------------
function qwiz_get_previous_version ($post_id) {
   global $debug, $wpdb;

   // Query for most-recent revision.  Avoid autosaves, skip current version.
   $table = $wpdb->prefix . 'posts';
   $sql  =  "SELECT     post_content,
                        ID,
                        post_name,
                        post_type
             FROM       $table
             WHERE          post_parent = $post_id
                        AND post_name   NOT LIKE '%autosave%'
                        AND post_type   = 'revision'
             ORDER BY   post_date DESC
             LIMIT      1, 1";
   $rows = $wpdb->get_results ($sql, ARRAY_A);
   if ($debug[5]) {
      error_log ('[qwiz_get_previous_version] $sql: ' . $sql);
      error_log ('[qwiz_get_previous_version] count ($rows): ' . count ($rows));
      error_log ('[qwiz_get_previous_version] $wpdb->print_error ()' . $wpdb->print_error ());
      if ($rows) {
         $row = $rows[0];
         error_log ('[qwiz_get_previous_version] ID: ' . $row['ID']);
         error_log ('[qwiz_get_previous_version] post_name: ' . $row['post_name']);
         error_log ('[qwiz_get_previous_version] post_type: ' . $row['post_type']);
      }
   }
   if ($rows) {
      $row = $rows[0];
      $prev_html = $row['post_content'];
      //if ($debug[6]) {
      //   error_log ('[qwiz_get_previous_version] prev_html: ' . $prev_html);
      //}
   } else {
      $prev_html = '';
   }

   return $prev_html;
}


// -----------------------------------------------------------------------------
// Send new and updated questions to Qwizcards database.
function qwiz_dataset_questions_to_db ($qdata, $post_id, $maker_session_id,
                                                                   $permalink) {
   global $debug, $http_https_server_loc;

   // Assemble new/modified questions.
   $datasets         = array ();
   $dataset_ids      = array ();
   $question_numbers = array ();
   $htmls            = array ();
   $units            = array ();
   $topics           = array ();
   $difficulties     = array ();

   $deleted_datasets    = array();
   $deleted_dataset_ids = array();

   $n_questions = count ($qdata['dataset_ids']);
   for ($i_question=0; $i_question<$n_questions; $i_question++) {
      if (isset ($qdata['new_modified'][$i_question])) {
         $datasets[]         = $qdata['datasets'][$i_question];
         $dataset_ids[]      = $qdata['dataset_ids'][$i_question];
         $question_numbers[] = $qdata['question_numbers'][$i_question];
         $htmls[]            = $qdata['htmls'][$i_question];
         $units[]            = $qdata['units'][$i_question];
         $topics[]           = $qdata['topics'][$i_question];
         $difficulties[]     = $qdata['difficulties'][$i_question];

         // If question includes [deleted] shortcode, send separate list --
         // delete association.
         if (strpos ($qdata['htmls'][$i_question], '[deleted]') !== false) {
            $deleted_datasets[]    = $qdata['datasets'][$i_question];
            $deleted_dataset_ids[] = $qdata['dataset_ids'][$i_question];
         }
      }
   }

   // Do HTTP request.
   $body = array ('maker_session_id'    => $maker_session_id,
                  'datasets'            => json_encode ($datasets),
                  'dataset_ids'         => json_encode ($dataset_ids),
                  'question_numbers'    => json_encode ($question_numbers),
                  'page_url'            => json_encode ($permalink),
                  'htmls'               => json_encode ($htmls),
                  'units'               => json_encode ($units),
                  'topics'              => json_encode ($topics),
                  'difficulties'        => json_encode ($difficulties),

                  'deleted_datasets'    => json_encode ($deleted_datasets),
                  'deleted_dataset_ids' => json_encode ($deleted_dataset_ids)
                 );
   $url = $http_https_server_loc . '/update_dataset_questions.php';
   $http_request = new WP_Http;
   $result = $http_request->request ($url, array ('method'  => 'POST',
                                                  'timeout' => 20,    // Seconds.
                                                  'body'    => $body));
   if ($debug[0] || $debug[5]) {
      error_log ('[qwiz_dataset_questions_to_db] result: ' . print_r ($result, true));
   }

   // Retrieve info on update, save in options variable.  Pass to qwizzled.js
   // via set_qwizzled_params ().
   if ($result['response']['message'] == 'OK') {
      $update_msg = $result['body'];
   } else {
      $update_msg = 'Unable to update questions/cards in Qwizcards database.';
   }
   update_option ('update_msg', $update_msg);
}


// -----------------------------------------------------------------------------
// Get from database all dataset question IDs for this page; compare with
// questions currently on page.  If any in database now not on page, return
// indicator to create new version of question with blank html.
function qwiz_find_deleted_dataset_questions ($permalink, $dataset_ids) {
   global $debug, $http_https_server_loc;

   // Do HTTP request.
   $body = array ('page_url'           => json_encode ($permalink),
                  'ids_only_f'         => 1
                 );
   $url = $http_https_server_loc . '/get_dataset_questions_v2.php';
   if ($debug[5]) {
      error_log ('[qwiz_find_deleted_dataset_questions] $url: ' . $url);
   }
   $http_request = new WP_Http;
   $result = $http_request->request ($url, array ('method' => 'POST',
                                                  'body'   => $body));
   if ($debug[5]) {
      error_log ('[qwiz_find_deleted_dataset_questions] $result: ' . print_r ($result, true));
   }
   $data_array = json_decode ($result['body']);
   if ($debug[5]) {
      error_log ('[qwiz_find_deleted_dataset_questions] $data_array: ' . print_r ($data_array, true));
   }
   $db_dataset_ids = $data_array->question_ids;

   // If database question IDs not in current-page IDs...
   $dataset_ids_to_blank = array ();
   foreach ($db_dataset_ids as $db_dataset_id) {
      if (! in_array ($db_dataset_id, $dataset_ids)) {

         // Add to list of those to be blanked.
         $dataset_ids_to_blank[] = $db_dataset_id;
      }
   }
   if ($debug[0]) {
      error_log ('[qwiz_find_deleted_dataset_questions] $dataset_ids_to_blank: ' . print_r ($dataset_ids_to_blank, true));
   }

   return $dataset_ids_to_blank;
}


// -----------------------------------------------------------------------------
function qwiz_qdeck_unit_counts_to_db ($qrecord_ids, $datasets, $qrecord_id_n_questions) {
   global $debug, $http_https_server_loc;

   // Do HTTP request.
   $body = array ('qrecord_ids'            => json_encode ($qrecord_ids),
                  'datasets'               => json_encode ($datasets),
                  'qrecord_id_n_questions' => json_encode ($qrecord_id_n_questions)
                 );
   $url = $http_https_server_loc . '/update_qwiz_qdeck_unit_counts.php';
   $http_request = new WP_Http;
   $result = $http_request->request ($url, array ('method' => 'POST',
                                                  'body'   => $body));
   if ($debug[0] || $debug[5]) {
      error_log ('[qwiz_qdeck_unit_counts_to_db] result: ' . print_r ($result, true));
   }
}


// -----------------------------------------------------------------------------
// -----------------------------------------------------------------------------
// Admin page.
include "qwiz_admin.php";
