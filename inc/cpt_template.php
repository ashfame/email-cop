<html>
	<head>
		<?php wp_head(); ?>
		<style>
			html, body {
				background: #CECECE;
			}
			#wp-cop-preview-email {
				background: #FFF;
				margin: auto;
				max-width: 800px;
				padding: 25px;
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
			.email_meta p {
				margin-top: 4px;
				margin-bottom: 4px;
			}
			.email-body {
				background: #f2efe9;
				padding: 10px;
			}
		</style>
	</head>
	<body>
		<?php the_post(); ?>
		<div id="wp-cop-preview-email">
			<div class="email_meta">
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
			<div class="email-body">
				<?php the_content(); ?>
			</div>
		</div>
		<?php wp_footer(); ?>
	</body>
</html>