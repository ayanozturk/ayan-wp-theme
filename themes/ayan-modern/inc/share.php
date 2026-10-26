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
function ayan_modern_render_share_link( string $block_content, array $block ): string {
	$class_name = $block['attrs']['className'] ?? '';
	$class_names = preg_split( '/\s+/', trim( $class_name ) );

	$service = array_find(
		array( 'share-link--x', 'share-link--linkedin' ),
		static fn( string $class ): bool => in_array( $class, $class_names, true )
	);

	if ( null === $service ) {
		return $block_content;
	}

	$post_url = get_permalink();
	if ( ! $post_url ) {
		return $block_content;
	}

	if ( 'share-link--x' === $service ) {
		$share_url = add_query_arg(
			array(
				'url'  => rawurlencode( $post_url ),
				'text' => rawurlencode( get_the_title() ),
			),
			'https://twitter.com/intent/tweet'
		);
	} else {
		$share_url = add_query_arg( 'url', rawurlencode( $post_url ), 'https://www.linkedin.com/sharing/share-offsite/' );
	}

	$processor = new WP_HTML_Tag_Processor( $block_content );
	while ( $processor->next_tag( 'a' ) ) {
		if ( in_array( $processor->get_attribute( 'data-share' ), array( 'x', 'linkedin' ), true ) && '#' === $processor->get_attribute( 'href' ) ) {
			$processor->set_attribute( 'href', esc_url_raw( $share_url ) );
			break;
		}
	}

	return $processor->get_updated_html();
}
add_filter( 'render_block_core/paragraph', 'ayan_modern_render_share_link', 10, 2 );
