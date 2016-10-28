<?php

// -----------------------------------------------------------------------------
// @section     Function Pannel Templates
// @description Option de personnalisation
// -----------------------------------------------------------------------------

if (is_admin()) :

	function pannel_templates_options() {
		/*
		// @todo Débug
		if(!empty($_POST)){
			echo '<pre style="color:#ddd;background:#444;padding:20px;">';
		//	print_r($_POST);
			var_dump($_POST['option']);
			echo '</pre>';
			}
		*/
		if( isset( $_POST[ 'pannel-update'] ) ) {
			if( ! wp_verify_nonce( $_POST[ 'pannel_noncename' ], 'pannel-update' ) ) {
				die( 'Token non valide' );
			}
			foreach ($_POST[ 'option' ] as $name => $value) {
				if( empty( $value ) ) {
					delete_option( $name );			// Supprimer les options vides de la table MySQL 'wp_options'
				} else {
					update_option( $name, $value );	// Créer une option si valeur existante
				}
			}
			echo '<div id="message" class="updated">';
			echo '<p>' .__( 'Options saved successfully.', 'scriptura' ). '</p>';
			echo '</div>';
		}

	wp_enqueue_media(); // Permet l'upload des medias WP
	echo '<script>';
	echo '$templateUri = "' . get_bloginfo( 'template_directory' ) . '";'; // Variable javascript sur l'emplacement du thème, pour le bouton de suppression
	echo '</script>';
	?>
	<div class="wrap">
		<h2><?php _e( 'Options for Scriptura framework', 'scriptura' ); ?></h2>
		<form method="post" action="">
			<hr>
			<table class="form-table">
			<h3><?php _e( 'Google Analytics', 'scriptura' ); ?></h3>
				<tbody>
					<tr>
						<th scope="row">
							<label><?php _e( 'Account number', 'scriptura' ); ?></label>
						</th>
						<fieldset>
						<td>
							<input type="text" id="scriptura_google_analytics" name="option[scriptura_google_analytics]" value="<?php echo get_option( 'scriptura_google_analytics' ); ?>" class="regular-text" placeholder="UA-XXXXXXXX-X">
							<p class="description"><?php _e( 'Register your account number Analytics if you require this service. You must have previously created an account on <a href="http://www.google.fr/intl/fr/analytics/">the API website</a>.', 'scriptura' ); ?></p>
						</td>
						<fieldset>
					</tr>
				</tbody>
			</table>
			<hr>
			<table class="form-table">
			<h3><?php _e( 'Google Maps', 'scriptura' ); ?></h3>
				<tbody>
					<tr>
						<th scope="row">
							<label><?php _e( 'API Key', 'scriptura' ); ?></label>
						</th>
						<fieldset>
						<td>
							<input type="text" id="scriptura_google_maps" name="option[scriptura_google_maps]" value="<?php echo get_option( 'scriptura_google_maps' ); ?>" class="regular-text" placeholder="UA-XXXXXXXX-X">
						</td>
						<fieldset>
					</tr>
				</tbody>
			</table>
			<hr>
			<table class="form-table">
			<h3><?php _e( 'Google reCAPTCHA', 'scriptura' ); ?></h3>
				<tbody>
					<tr>
						<th scope="row">
							<label><?php _e( 'Recaptcha Site Key', 'scriptura' ); ?></label>
						</th>
						<fieldset>
						<td>
							<input type="text" id="scriptura_google_recaptchasitekey" name="option[scriptura_google_recaptchasitekey]" value="<?php echo get_option( 'scriptura_google_recaptchasitekey' ); ?>" class="regular-text" placeholder="...">
						</td>
						<fieldset>
					</tr>
					<tr>
						<th scope="row">
							<label><?php _e( 'Recaptcha Secret Key', 'scriptura' ); ?></label>
						</th>
						<fieldset>
						<td>
							<input type="text" id="scriptura_google_recaptchasecretkey" name="option[scriptura_google_recaptchasecretkey]" value="<?php echo get_option( 'scriptura_google_recaptchasecretkey' ); ?>" class="regular-text" placeholder="...">
						</td>
						<fieldset>
					</tr>
				</tbody>
			</table>
			<hr>
			<table class="form-table">
			<h3><?php _e( 'Logo SVG', 'scriptura' ); ?></h3>
				<tbody>
					<tr>
						<th scope="row">
							<label><?php _e( 'Logo SVG', 'scriptura' ); ?></label>
						</th>
						<fieldset>
						<td>
							<input type="text" id="scriptura_logo_site_svg" name="option[scriptura_logo_site_svg]" value='<?php echo str_replace( '\"', '"', get_option( 'scriptura_logo_site_svg' ) ); ?>' class="regular-text" placeholder="<svg><path/></svg>">
							<p class="description"><?php _e( 'The logo must be saved in SVG.', 'scriptura' ); ?></p>
						</td>
						<fieldset>
					</tr>
				</tbody>
			</table>
			<hr>
			<table class="form-table">
			<h3><?php _e( 'Thumbnail Welcome', 'scriptura' ); ?></h3>
			<p><?php _e( 'Customizing the first image of the website home page.', 'scriptura' ); ?></p>
				<tbody>
					<tr>
						<th scope="row">
							<label for="scriptura_thumbnail_welcome"><?php _e( 'Thumbnail Welcome', 'scriptura' ); ?></label>
						</th>
						<td>
							<div style="width:100%;height:150px;max-width:350px;max-height:150px;background:#333">
								<img id="visual_scriptura_thumbnail_welcome" class="scriptura-media-visual" src="<?php if( get_option( 'scriptura_thumbnail_welcome' ) ) { echo get_option('scriptura_thumbnail_welcome', '' ); } else { echo get_template_directory_uri() . '/Images/Null.svg'; } ?>" style="display:block;max-width:100%;max-height:100%;margin:0 auto">
							</div><br>
							<input type="text" id="scriptura_thumbnail_welcome" class="regular-text scriptura-media-link" name="option[scriptura_thumbnail_welcome]" value="<?php echo get_option('scriptura_thumbnail_welcome', ''); ?>" class="regular-text" placeholder="<?php _e( 'No current image', 'scriptura' ); ?>">
							<a href="#" class="button scriptura-media-uploader"><?php _e( 'Choose an image', 'scriptura' ); ?></a>
							<a href="#" class="button scriptura-media-remove"><?php _e( 'Delete image', 'scriptura' ); ?></a>
							<p class="description"><?php _e( 'The image must first be uploaded via the media library.', 'scriptura' ); ?></p>
						</td>
					</tr>
				</tbody>
			</table>
			<hr>
			<table class="form-table">
			<h3><?php _e( 'Default thumbnail', 'scriptura' ); ?></h3>
			<p><?php _e( 'Customizing the default image for the presentation of items.', 'scriptura' ); ?></p>
				<tbody>
					<tr>
						<th scope="row">
							<label for="scriptura_def_thumbnail"><?php _e( 'Default thumbnail', 'scriptura' ); ?></label>
						</th>
						<td>
							<div style="width:100%;height:150px;max-width:350px;max-height:150px;background:#333">
								<img id="visual_scriptura_def_thumbnail" class="scriptura-media-visual" src="<?php if( get_option( 'scriptura_def_thumbnail' ) ) { echo get_option('scriptura_def_thumbnail', '' ); } else { echo get_template_directory_uri() . '/Images/Null.svg'; } ?>" style="display:block;max-width:100%;max-height:100%;margin:0 auto">
							</div><br>
							<input type="text" id="scriptura_def_thumbnail" class="regular-text scriptura-media-link" name="option[scriptura_def_thumbnail]" value="<?php echo get_option('scriptura_def_thumbnail', ''); ?>" class="regular-text" placeholder="<?php _e( 'No current image', 'scriptura' ); ?>">
							<a href="#" class="button scriptura-media-uploader"><?php _e( 'Choose an image', 'scriptura' ); ?></a>
							<a href="#" class="button scriptura-media-remove"><?php _e( 'Delete image', 'scriptura' ); ?></a>
							<p class="description"><?php _e( 'The image must first be uploaded via the media library.', 'scriptura' ); ?></p>
						</td>
					</tr>
				</tbody>
			</table>
			<hr>
			<table class="form-table">
			<h3><?php _e( 'Snowstorm', 'scriptura' ); ?></h3>
				<tbody>
					<tr>
						<th scope="row">
							<label for="scriptura_snowstorm"><?php _e( 'Activate', 'scriptura' ); ?></label>
						</th>
						<td>
						<select id="scriptura_calendar" name="option[scriptura_snowstorm]">
							<option value="0"<?php if( get_option( 'scriptura_snowstorm' ) == 0 ) { echo ' selected="selected"'; } ?><?php if ( ! get_option( 'scriptura_snowstorm' ) ) { echo ' selected="selected"'; } ?>><?php _e( 'No', 'scriptura' ); ?></option>
							<option value="1"<?php if( get_option( 'scriptura_snowstorm' ) == 1 ) { echo ' selected="selected"'; } ?>><?php _e('Yes', 'scriptura'); ?></option>
						</select>
						<p class="description"><?php _e( 'Displays a snow effect on the site during the winter season.', 'scriptura' ); ?></p>
						</td>
					</tr>
				</tbody>
			</table>
			<hr>
			<p class="submit">
				<input type="hidden" name="pannel_noncename" value="<?php echo wp_create_nonce( 'pannel-update' ); ?>"><!-- Génération d'un Token -->
				<input type="submit" name="pannel-update" class="button-primary autowidth" value="<?php _e( 'Save changes', 'scriptura' ); ?>">
			</p>
		</form>
	</div>
	<?php }

endif; // admin