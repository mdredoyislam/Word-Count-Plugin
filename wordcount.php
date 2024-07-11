<?php
/*
Plugin Name: Word Count
Plugin URI: https://redoyit.com/
Description: Used by millions, WordCount is quite possibly the best way in the world to <strong>protect your blog from spam</strong>. WordCount Anti-spam keeps your site protected even while you sleep. To get started: activate the WordCount plugin and then go to your WordCount Settings page to set up your API key.
Version: 5.3
Requires at least: 5.8
Requires PHP: 5.6.20
Author: Md. Redoy Islam
Author URI: https://redoyit.com/wordpress-plugins/
License: GPLv2 or later
Text Domain: wordcount
Domain Path: /languages
*/
/*
function wordcount_activation_hook(){}
register_activation_hook(__FILE__, "wordcount_activation_hook");

function wordcount_deactivation_hook(){}
register_deactivation_hook(__FILE__, "wordcount_deactivation_hook");
*/

function wordcount_load_textdomain(){
    load_plugin_textdomain('wordcount', false, dirname(__FILE__).'/languages');
}
add_action("plugins_loaded", "wordcount_load_textdomain");

function wordcount_count_words($content){
    $stripped_content = strip_tags($content);
    $wordn = str_word_count($stripped_content);
    $label = __('Total Number of Words', 'wordcount');
    $label = apply_filters('wordcount_heading', $label);
    $tag = apply_filters('wordcount_tag','h2');
    $content .= sprintf('<%s>%s:%s</%s>', $tag,$label, $wordn,$tag);
    return $content;
}
add_filter('the_content', 'wordcount_count_words');

function wordcount_reading_time($content){
    $stripped_content = strip_tags($content);
    $wordn = str_word_count($stripped_content);
    $reading_munites = floor($wordn / 200);
    $reading_secounds = floor($wordn % 200 / (200/60));

    $is_visible = apply_filters('wordcoun_display_readingtime', 1);
    if($is_visible){
        $label = __('Total Reading Time', 'wordcount');
        $label = apply_filters('wordcount_readingtime_heading', $label);
        $tag = apply_filters('wordcount_readingtime_tag','h4');
        $content .= sprintf('<%s>%s:%s minutes %s secounds</%s>', $tag,$label, $reading_munites, $reading_secounds,$tag);
    }
    return $content;
}
add_filter('the_content', 'wordcount_reading_time');