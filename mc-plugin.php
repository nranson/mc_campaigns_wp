<?php
/*
Plugin Name: MailChimp Curator
Plugin URI: http://kb.mailchimp.com/article/how-do-i-use-goals-tracking/
Description: Curate your RSS feed to create MailChimp campaigns.
Author: Nate Ranson
Version: 1.0
Author URI: http://www.mailchimp.com
*/
		load_plugin_textdomain('mc_campaigns', false, basename( dirname( __FILE__ ) ) . '/languages' );

		function get_scripts(){
			wp_register_script('mc_drag', plugins_url().'/scripts/drag.js', array('jquery-ui'), null);
			admin_enqueue_script('jquery');
			admin_enqueue_script('jquery-ui');
			admin_enqueue_script('mc_drag');
		};

		function mc_posts_actions() {
			add_posts_page("Build New Campaign", "Build New Campaign", 1, "MCBuilder", "mc_posts");
		};

		add_action('admin_menu', 'mc_admin_actions');
		$mcWP = get_option('mcWP');
		if(!empty($mcWP['apikey'])){
			add_action('admin_menu', 'mc_posts_actions');
		};

		function mc_admin() {
			include(plugin_dir_path( __FILE__ ).'/mc-campaigns.php');
		};

		function mc_admin_actions() {
			add_action('wp_enqueue_scripts', 'get_scripts');
			add_options_page("MailChimp Curator", "MailChimp Curator", 1, "MCCurator", "mc_admin");
		};

		function mc_posts(){
			include(plugin_dir_path(__FILE__).'/mc-content.php');
		}
