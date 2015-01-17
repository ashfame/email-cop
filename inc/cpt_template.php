<?php
the_post();
$email_body = get_post( $post->ID )->post_content;

// if you have a special edge case for which you need to check against the email body, use the filter below
$is_it_a_html_email = apply_filters( 'wp_cop_email_is_email_html_check', false !== strpos( $email_body, 'DOCTYPE html' ), $email_body );

// If its a complete HTML email, then we just try to show email meta information on top of the actual email
if ( $is_it_a_html_email ) {
	?>
	<style>
		.email-meta {
			background: #FFF;
			padding: 25px;
		}
		.email-meta-content {
			max-width: 800px;
			margin: auto;
		}
		.avatar {
			border-radius: 60px;
			border: solid 1px #CECECE;
			width: 100px;
			height: 100px;
		}
		td {
			padding: 5px;
			vertical-align: top;
		}
		.email-meta p {
			margin-top: 4px;
			margin-bottom: 4px;
		}
	</style>

	<div class="email-meta">
		<div class="email-meta-content">
			<table>
				<tr>
					<td>
						<?php echo get_avatar( get_post_meta( $post->ID, 'wp_cop_email_from', true ), 200 ); ?>
					</td>
					<td>
						<p>
							<strong>From:</strong> <?php echo get_post_meta( $post->ID, 'wp_cop_email_from_name', true ) . ' &lt;' . get_post_meta( $post->ID, 'wp_cop_email_from', true ) . '&gt;'; ?>
						</p>
						<p>
							<?php if ( is_array( get_post_meta( $post->ID, 'wp_cop_email_to', true ) ) ) { ?>
								<strong>To:</strong> <?php echo implode( ', ', get_post_meta( $post->ID, 'wp_cop_email_to', true ) ); ?>
							<?php } else { ?>
								<strong>To:</strong> <?php echo get_post_meta( $post->ID, 'wp_cop_email_to', true ); ?>
							<?php } ?>
						</p>
						<?php if ( get_post_meta( $post->ID, 'wp_cop_email_cc', true ) ) { ?>
							<p>
								<strong>Cc:</strong> <?php echo get_post_meta( $post->ID, 'wp_cop_email_cc', true ); ?>
							</p>
						<?php } ?>
						<?php if ( get_post_meta( $post->ID, 'wp_cop_email_bcc', true ) ) { ?>
							<p>
								<strong>Bcc:</strong> <?php echo get_post_meta( $post->ID, 'wp_cop_email_bcc', true ); ?>
							</p>
						<?php } ?>
						<p>
							<strong>Subject:</strong> <?php echo get_post_meta( $post->ID, 'wp_cop_email_subject', true ); ?>
						</p>
					</td>
				</tr>
			</table>
		</div>
	</div>

	<?php
	// now output email content and bail
	echo $email_body;
	return;
}

// if we are here that means, its a simple text email, so lets roll out complete HTML to make it look nice
?>
<html>
	<head>
		<?php wp_head(); ?>
		<style>
			html, body {
				background: #f2efe9;
			}
			.email-meta {
				background: #FFF;
				padding: 25px;
			}
			.email-meta-content {
				max-width: 800px;
				margin: auto;
			}
			.avatar {
				border-radius: 60px;
				border: solid 1px #CECECE;
				width: 100px;
				height: 100px;
			}
			td {
				padding: 5px;
				vertical-align: top;
			}
			.email-meta p {
				margin-top: 4px;
				margin-bottom: 4px;
			}
			.email-body {
				background: #f2efe9;
				padding: 10px;
			}
			.email-body-content {
				max-width: 800px;
				margin: auto;
				background: #FFF;
				padding: 10px;
			}
			.email-body-content p {
				margin-bottom: 15px;
			}
		</style>
	</head>
	<body>

		<div class="email-meta">
			<div class="email-meta-content">
				<table>
					<tr>
						<td>
							<?php echo get_avatar( get_post_meta( $post->ID, 'wp_cop_email_from', true ), 200 ); ?>
						</td>
						<td>
							<p>
								<strong>From:</strong> <?php echo get_post_meta( $post->ID, 'wp_cop_email_from_name', true ) . ' &lt;' . get_post_meta( $post->ID, 'wp_cop_email_from', true ) . '&gt;'; ?>
							</p>
							<p>
								<?php if ( is_array( get_post_meta( $post->ID, 'wp_cop_email_to', true ) ) ) { ?>
									<strong>To:</strong> <?php echo implode( ', ', get_post_meta( $post->ID, 'wp_cop_email_to', true ) ); ?>
								<?php } else { ?>
									<strong>To:</strong> <?php echo get_post_meta( $post->ID, 'wp_cop_email_to', true ); ?>
								<?php } ?>
							</p>
							<?php if ( get_post_meta( $post->ID, 'wp_cop_email_cc', true ) ) { ?>
								<p>
									<strong>Cc:</strong> <?php echo get_post_meta( $post->ID, 'wp_cop_email_cc', true ); ?>
								</p>
							<?php } ?>
							<?php if ( get_post_meta( $post->ID, 'wp_cop_email_bcc', true ) ) { ?>
								<p>
									<strong>Bcc:</strong> <?php echo get_post_meta( $post->ID, 'wp_cop_email_bcc', true ); ?>
								</p>
							<?php } ?>
							<p>
								<strong>Subject:</strong> <?php echo get_post_meta( $post->ID, 'wp_cop_email_subject', true ); ?>
							</p>
						</td>
					</tr>
				</table>
			</div>
		</div>

		<div class="email-body">
			<div class="email-body-content">
				<?php the_content(); ?>
			</div>
		</div>
		<?php wp_footer(); ?>
	</body>
</html>