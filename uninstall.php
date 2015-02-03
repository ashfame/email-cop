<?php

// Exit if accessed directly
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) exit;

// pick irrespective of post status, including trashed ones
$email_cop_post_ids = $wpdb->get_col( "SELECT ID FROM $wpdb->posts WHERE post_type = 'wp_cop_email';" );

if ( $email_cop_post_ids ) {
	foreach ( $email_cop_post_ids as $postID ) {
		wp_delete_post( $postID, true );
	}
}
