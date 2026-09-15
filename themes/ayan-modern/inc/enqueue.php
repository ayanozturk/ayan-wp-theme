/**
 * Scripts and styles.
 *
 * @package Ayan_Modern
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Enqueue front-end scripts and styles.
 */
function ayan_modern_scripts() {
	$theme   = wp_get_theme();
	$version = $theme ? $theme->get( 'Version' ) : null;

	wp_enqueue_style( 'ayan-modern-style', get_stylesheet_uri(), array(), $version );

	$built_css = get_template_directory() . '/assets/css/theme.css';
	if ( file_exists( $built_css ) ) {
		wp_enqueue_style(
			'ayan-modern-theme',
			get_template_directory_uri() . '/assets/css/theme.css',
			array( 'ayan-modern-style' ),
			filemtime( $built_css )
		);
	}

	$asset_file = get_template_directory() . '/assets/js/theme.asset.php';
	if ( file_exists( $asset_file ) ) {
		$asset = include $asset_file;
		wp_enqueue_script(
			'ayan-modern-script',
			get_template_directory_uri() . '/assets/js/theme.js',
			$asset['dependencies'],
			$asset['version'],
			true
		);
	}

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'ayan_modern_scripts' );

/**
 * Enqueue block editor assets.
 */
function ayan_modern_editor_assets() {
	$asset_file = get_template_directory() . '/assets/js/editor.asset.php';

	if ( ! file_exists( $asset_file ) ) {
		return;
	}

	$asset = include $asset_file;

	wp_enqueue_script(
		'ayan-modern-editor',
		get_template_directory_uri() . '/assets/js/editor.js',
		$asset['dependencies'],
		$asset['version'],
		true
	);
}
add_action( 'enqueue_block_editor_assets', 'ayan_modern_editor_assets' );
