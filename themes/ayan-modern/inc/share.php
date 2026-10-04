<?php
/**
 * Progressive share links for the share-row pattern.
 *
 * @package Ayan_Modern
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Render real share destinations so social links work before JavaScript loads.
 *
 * @param string $block_content Rendered paragraph markup.
 * @param array  $block         Parsed block data.
 * @return string
 */
function ayan_modern_render_share_link( $block_content, $block ) {
	$class_name = $block['attrs']['className'] ?? '';
	$class_names = preg_split( '/\s+/', trim( $class_name ) );

	if ( ! in_array( 'share-link--x', $class_names, true ) && ! in_array( 'share-link--linkedin', $class_names, true ) ) {
		return $block_content;
	}

	$post_url = get_permalink();
	if ( ! $post_url ) {
		return $block_content;
	}

	if ( in_array( 'share-link--x', $class_names, true ) ) {
		$share_url = add_query_arg(
			array(
				'url'  => $post_url,
				'text' => get_the_title(),
			),
			'https://twitter.com/intent/tweet'
		);
	} else {
		$share_url = add_query_arg( 'url', $post_url, 'https://www.linkedin.com/sharing/share-offsite/' );
	}

	return preg_replace_callback(
		'/<a\b[^>]*\bdata-share=["\'](?:x|linkedin)["\'][^>]*>/i',
		static function ( $matches ) use ( $share_url ) {
			return preg_replace_callback(
				'/\bhref=(["\'])#\1/i',
				static function ( $href_matches ) use ( $share_url ) {
					return 'href=' . $href_matches[1] . esc_url( $share_url ) . $href_matches[1];
				},
				$matches[0],
				1
			);
		},
		$block_content,
		1
	);
}
add_filter( 'render_block_core/paragraph', 'ayan_modern_render_share_link', 10, 2 );
