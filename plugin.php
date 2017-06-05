<?php

/*
Plugin Name: Email Cop
Plugin URI: https://wordpress.org/plugins/email-cop/
Description: Prevent WordPress from sending any emails, also have a preview option of viewing emails (best for development)
Author: Ashfame
Version: 0.1.1
Author URI: http://ashfame.com/
*/

class Ashfame_WP_Email_Cop {

	private static $instance;

	public function __construct() {
		global $phpmailer;

		// load mock phpmailer class
		require_once( plugin_dir_path( __FILE__ ) . 'inc/wpcop-mailer.php' );

		// overwrite the global, hence giving the control to our cop
		$phpmailer = new WPCopPHPMailer();

		// show an admin notice that WP Email Cop is on patrol
		add_action( 'admin_notices', array( $this, 'admin_notice' ) );

		// register CPT
		add_action( 'init', array( $this, 'register_post_type' ) );

		// flush rewrite rules so that view link starts working on its own
		register_activation_hook( __FILE__, array( $this, 'activation' ) );
		register_deactivation_hook( __FILE__, array( $this, 'deactivation' ) );

		// provide CPT template file
		add_filter( 'single_template', array( $this, 'provide_cpt_template' ) );
	}

	public static function getInstance() {

		if ( ! self::$instance ) {
			self::$instance = new self;
		}

		return self::$instance;
	}

	public function activation() {
		$this->register_post_type();
		flush_rewrite_rules();
	}

	public function deactivation() {
		flush_rewrite_rules();
	}

	public function admin_notice() {
		if ( current_user_can( 'manage_options' ) ) {
			echo '<div class="error"><p><span class="dashicons dashicons-megaphone"></span> <strong>WP Email Cop</strong> is active and will prevent any emails from being sent. <a href="' . admin_url( 'edit.php?post_type=wp_cop_email' ) . '">View Emails</a></p></div>';
		}
	}

	public function register_post_type() {
		register_post_type(
			'wp_cop_email',
			apply_filters(
				'wp_cop_email_cpt_register_args',
				array(
					'public' => true,
					'label'  => 'Emails'
				)
			)
		);
	}

	public function provide_cpt_template( $single ) {
		global $post;

		if ( $post->post_type == 'wp_cop_email' ) {
			if ( file_exists( plugin_dir_path( __FILE__ ) . 'inc/cpt_template.php' ) ) {
				return plugin_dir_path( __FILE__ ) . 'inc/cpt_template.php';
			}
		}
		return $single;
	}
}

Ashfame_WP_Email_Cop::getInstance();