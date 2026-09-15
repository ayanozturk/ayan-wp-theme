/**
 * Block pattern categories and block styles.
 *
 * File-based patterns under patterns/ auto-register in WordPress 6.0+.
 *
 * @package Ayan_Modern
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Register custom pattern category.
 */
function ayan_modern_register_pattern_categories() {
	if ( ! function_exists( 'register_block_pattern_category' ) ) {
		return;
	}

	register_block_pattern_category(
		'ayan-modern',
		array(
			'label' => __( 'Ayan Modern', 'ayan-modern' ),
		)
	);
}
add_action( 'init', 'ayan_modern_register_pattern_categories' );

/**
 * Register custom block styles.
 */
function ayan_modern_register_block_styles() {
	if ( ! function_exists( 'register_block_style' ) ) {
		return;
	}

	$style_handle = 'ayan-modern-theme';

	register_block_style(
		'core/image',
		array(
			'name'         => 'full-bleed',
			'label'        => __( 'Full bleed', 'ayan-modern' ),
			'style_handle' => $style_handle,
		)
	);

	register_block_style(
		'core/post-featured-image',
		array(
			'name'         => 'full-bleed',
			'label'        => __( 'Full bleed', 'ayan-modern' ),
			'style_handle' => $style_handle,
		)
	);

	register_block_style(
		'core/quote',
		array(
			'name'         => 'signal',
			'label'        => __( 'Signal', 'ayan-modern' ),
			'style_handle' => $style_handle,
		)
	);

	register_block_style(
		'core/button',
		array(
			'name'         => 'ghost',
			'label'        => __( 'Ghost', 'ayan-modern' ),
			'style_handle' => $style_handle,
		)
	);
}
add_action( 'init', 'ayan_modern_register_block_styles' );
