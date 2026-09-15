<?php
/**
 * Block bindings for dynamic template values.
 *
 * @package Ayan_Modern
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Register custom block binding sources.
 */
function ayan_modern_register_binding_sources() {
	if ( ! function_exists( 'register_block_bindings_source' ) ) {
		return;
	}

	register_block_bindings_source(
		'ayan-modern/reading-time',
		array(
			'label'              => __( 'Reading time', 'ayan-modern' ),
			'get_value_callback' => 'ayan_modern_binding_reading_time',
			'uses_context'       => array( 'postId' ),
		)
	);
}
add_action( 'init', 'ayan_modern_register_binding_sources' );

/**
 * Return formatted reading time for block bindings.
 *
 * @param array    $source_args   Source arguments.
 * @param WP_Block $block_instance Block instance.
 * @param string   $attribute_name Attribute name.
 * @return string
 */
function ayan_modern_binding_reading_time( $source_args, $block_instance, $attribute_name ) { // phpcs:ignore Generic.CodeAnalysis.UnusedFunctionParameter
	unset( $source_args, $attribute_name );

	$post_id = 0;

	if ( isset( $block_instance->context['postId'] ) ) {
		$post_id = (int) $block_instance->context['postId'];
	}

	return ayan_modern_format_reading_time( $post_id );
}
