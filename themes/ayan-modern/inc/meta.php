<?php
/**
 * Post meta registration and reading-time helpers.
 *
 * @package Ayan_Modern
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Register post meta for the block editor REST API.
 */
function ayan_modern_register_post_meta() {
	register_post_meta(
		'post',
		'_featured_post',
		array(
			'type'              => 'string',
			'single'            => true,
			'show_in_rest'      => true,
			'default'           => '0',
			'sanitize_callback' => 'ayan_modern_sanitize_featured_post',
			'auth_callback'     => function () {
				return current_user_can( 'edit_posts' );
			},
		)
	);

	register_post_meta(
		'post',
		'_reading_time',
		array(
			'type'              => 'integer',
			'single'            => true,
			'show_in_rest'      => true,
			'default'           => 0,
			'sanitize_callback' => 'ayan_modern_sanitize_reading_time',
			'auth_callback'     => function () {
				return current_user_can( 'edit_posts' );
			},
		)
	);
}
add_action( 'init', 'ayan_modern_register_post_meta' );

/**
 * Sanitize featured post meta.
 *
 * @param mixed $value Meta value.
 * @return string
 */
function ayan_modern_sanitize_featured_post( $value ) {
	return ( '1' === (string) $value || true === $value ) ? '1' : '0';
}

/**
 * Sanitize reading time meta.
 *
 * @param mixed $value Meta value.
 * @return int
 */
function ayan_modern_sanitize_reading_time( $value ) {
	$minutes = absint( $value );

	if ( $minutes < 1 ) {
		return 0;
	}

	return min( 60, $minutes );
}

/**
 * Get reading time for a post.
 *
 * @param int|null $post_id Post ID.
 * @return int
 */
function ayan_modern_get_reading_time( $post_id = null ) {
	if ( ! $post_id ) {
		$post_id = get_the_ID();
	}

	if ( ! $post_id ) {
		return 1;
	}

	$reading_time = get_post_meta( $post_id, '_reading_time', true );

	if ( $reading_time ) {
		return max( 1, (int) $reading_time );
	}

	$content    = wp_strip_all_tags( (string) get_post_field( 'post_content', $post_id ) );
	$word_count = preg_match_all( '/[\p{L}\p{N}]+(?:[\'’][\p{L}\p{N}]+)*/u', $content );
	$word_count = false === $word_count ? 0 : $word_count;
	$words_per_minute = (int) apply_filters( 'ayan_modern_reading_speed', 200, $post_id );
	$words_per_minute = max( 1, $words_per_minute );
	$reading_time     = (int) ceil( $word_count / $words_per_minute );

	return max( 1, $reading_time );
}

/**
 * Format reading time for display.
 *
 * @param int|null $post_id Post ID.
 * @return string
 */
function ayan_modern_format_reading_time( $post_id = null ) {
	$minutes = ayan_modern_get_reading_time( $post_id );

	return sprintf(
		/* translators: %d: number of minutes */
		_n( '%d min read', '%d mins read', $minutes, 'ayan-modern' ),
		$minutes
	);
}
