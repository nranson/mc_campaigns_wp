<?php
/*
   Plugin Name: MailChimp Curator
   Plugin URI: http://kb.mailchimp.com/article/how-do-i-use-goals-tracking/
   Description: Curate your RSS feed to create MailChimp campaigns.
   Author: Nate Ranson
   Version: 1.02
   Author URI: http://www.mailchimp.com
 */
load_plugin_textdomain('mc_campaigns', false, basename( dirname( __FILE__ ) ) . '/languages' );

//I think I'm doing this correctly?  -- http://pippinsplugins.com/loading-scripts-correctly-in-the-wordpress-admin/

function get_scripts($hook){
	if($hook != 'edit.php' && $_GET['page'] != 'MCBuilder') return;
	wp_enqueue_script('jquery');
	wp_enqueue_script('jquery-ui');
	wp_enqueue_script('jquery-ui-sortable');
	wp_register_script('sortable', plugins_url('scripts/drag.js', __FILE__), array('jquery-core', 'jquery-ui-core'));
	wp_enqueue_script('sortable');
};

add_action('admin_enqueue_scripts', 'get_scripts');

function mc_posts_actions() {
	add_posts_page("Build New Campaign", "Build New Campaign", 1, "MCBuilder", "mc_posts");
};

function mc_admin() {
	include(plugin_dir_path( __FILE__ ).'/mc-campaigns.php');
};

function mc_admin_actions() {
	add_options_page("MailChimp Curator", "MailChimp Curator", 1, "MCCurator", "mc_admin");
};

function mc_posts(){
	include(plugin_dir_path(__FILE__).'/mc-content.php');
}

$mcWP = get_option('mcWP');
if(!empty($mcWP['apikey'])){
	add_action('admin_menu', 'mc_posts_actions');
};

add_action('admin_menu', 'mc_admin_actions');
