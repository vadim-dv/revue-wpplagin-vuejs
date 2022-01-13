<?php
/*
Plugin Name: Latest Reviews
Description: Latest Reviews shortcode
Version: 1.0
*/

function handle_shortcode() {
    return '<div id="mount"></div>';
   }
   add_shortcode('latestReviews', 'handle_shortcode');

function enqueue_review_scripts(){
    if ( is_page_template('page-reviews-vue.php') || is_page_template('single-page-vue.php') ){
        wp_enqueue_script('vue', '//cdn.jsdelivr.net/npm/vue@2.5.17/dist/vue.js', [], '2.5.17');
        wp_enqueue_script('latest-posts', plugin_dir_url( __FILE__ ) . 'lastreviews.js', [], '1.0', true); 
    }
   }
add_action( 'wp_enqueue_scripts', 'enqueue_review_scripts' );