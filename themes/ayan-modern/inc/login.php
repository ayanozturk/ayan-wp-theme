/**
 * Login branding.
 *
 * @package Ayan_Modern
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Customize the login page logo.
 */
function ayan_modern_login_logo() {
	$custom_logo_id = get_theme_mod( 'custom_logo' );
	if ( ! $custom_logo_id ) {
		return;
	}

	$logo_url = wp_get_attachment_image_url( $custom_logo_id, 'full' );
	if ( ! $logo_url ) {
		return;
	}

	echo '<style type="text/css">
		#login h1 a {
			background-image: url(' . esc_url( $logo_url ) . ') !important;
			background-size: contain !important;
			width: 200px !important;
			height: 60px !important;
		}
	</style>';
}
add_action( 'login_head', 'ayan_modern_login_logo' );

/**
 * Change login logo URL.
 *
 * @return string
 */
function ayan_modern_login_logo_url() {
	return home_url();
}
add_filter( 'login_headerurl', 'ayan_modern_login_logo_url' );

/**
 * Change login logo title.
 *
 * @return string
 */
function ayan_modern_login_logo_url_title() {
	return get_bloginfo( 'name' );
}
add_filter( 'login_headertext', 'ayan_modern_login_logo_url_title' );
