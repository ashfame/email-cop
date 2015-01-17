<?php

require_once( ABSPATH . 'wp-includes/class-phpmailer.php' );

class WPCopPHPMailer extends PHPMailer {

	private $post_meta_prefix = 'wp_cop_email_';

	public function do_work() {
		// catch recipients, there are probably more conditions here than needed but it makes sure emails are caught up recursively upto a depth of 2
		$to = array();
		if ( is_array( $this->to ) ) {
			foreach ( $this->to as $recipient ) {
				if ( is_array( $recipient ) ) {
					foreach ( $recipient as $r ) {
						if ( is_email( $r ) ) {
							$to[] = $r;
						}
					}
				} else if ( is_email( $recipient ) ) {
					$to[] = $recipient;
				}
			}
		}

		$chargesheet_id = wp_insert_post(
			array(
				'post_status' => 'publish',
				'post_type' => 'wp_cop_email',
				'post_title' => $this->Subject . ' (' . ( is_array( $to ) ? implode( ', ', $to ) : $to ) . ')',
				'post_content' => $this->MIMEBody
			)
		);

		if ( $chargesheet_id ) {
			update_post_meta( $chargesheet_id, $this->post_meta_prefix . 'to', $to );
			if ( ! empty( $this->cc ) ) {
				update_post_meta( $chargesheet_id, $this->post_meta_prefix . 'cc', $this->cc );
			}
			if ( ! empty( $this->bcc ) ) {
				update_post_meta( $chargesheet_id, $this->post_meta_prefix . 'bcc', $this->bcc );
			}
			update_post_meta( $chargesheet_id, $this->post_meta_prefix . 'subject', $this->Subject );
			update_post_meta( $chargesheet_id, $this->post_meta_prefix . 'from', $this->From );
			update_post_meta( $chargesheet_id, $this->post_meta_prefix . 'from_name', $this->FromName );
		}
	}

	public function send() {
		try {
			if ( !$this->preSend() )
				return false;

			$this->do_work();

			// fake orgasm
			return true;
		} catch ( phpmailerException $e ) {
			return false;
		}
	}
}