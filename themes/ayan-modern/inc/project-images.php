<?php
/**
 * Project image presentation classes.
 *
 * @package Ayan_Modern
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Add reusable image classes to legacy portfolio images.
 *
 * New images should use these classes in the Image block's Advanced settings.
 * The alt-text map keeps existing site content styled while it is migrated.
 *
 * @param string $block_content Rendered image markup.
 * @param array  $block         Parsed block data.
 * @return string
 */
function ayan_modern_project_image_classes( $block_content, $block ) {
	$legacy_classes = array(
		'My Fridge app screen showing organised food containers' => 'ayan-project-artwork ayan-project-artwork--device',
		'SimbaHR mascot logo' => 'ayan-project-artwork ayan-project-artwork--logo',
		'PHP Strom extension logo' => 'ayan-project-artwork ayan-project-artwork--compact-logo',
		'PHPUnit Runner extension logo' => 'ayan-project-artwork ayan-project-artwork--compact-logo',
		'Last Done feature artwork with a reminder calendar and plants' => 'ayan-project-artwork ayan-project-artwork--wide',
	);
	$alt = $block['attrs']['alt'] ?? '';

	if ( ! isset( $legacy_classes[ $alt ] ) ) {
		return $block_content;
	}

	$classes = esc_attr( $legacy_classes[ $alt ] );

	return preg_replace_callback(
		'/<figure\b([^>]*)>/i',
		static function ( $matches ) use ( $classes ) {
			if ( preg_match( '/\bclass="([^"]*)"/i', $matches[1] ) ) {
				return preg_replace(
					'/\bclass="([^"]*)"/i',
					'class="$1 ' . $classes . '"',
					$matches[0],
					1
				);
			}

			return '<figure' . $matches[1] . ' class="' . $classes . '">';
		},
		$block_content,
		1
	);
}
add_filter( 'render_block_core/image', 'ayan_modern_project_image_classes', 10, 2 );
