<?php
/**
 * Uninstall Email Cop
 */

// Exit if accessed directly
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) exit;

//get all wp_cop_email post_type post ids
$email_cop_post_ids = get_posts(
	array(
		'post_type' => 'wp_cop_email',
		'post_status' => 'any',
		'posts_per_page' => -1,
		'fields' => 'ids'
	)
);

//delete posts
if ( $email_cop_post_ids ) {
	foreach ( $email_cop_post_ids as $postID ) {
		wp_delete_post( $postID, true );
	}
}