<?php
/**
 * Query Loop customizations for featured and related posts.
 *
 * @package Ayan_Modern
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Customize Query Loop block queries.
 *
 * @param array    $query Query vars.
 * @param WP_Block $block Block instance.
 * @param int      $page  Current page.
 * @return array
 */
function ayan_modern_query_loop_block_query_vars( $query, $block, $page ) { // phpcs:ignore Generic.CodeAnalysis.UnusedFunctionParameter
	$class_name = $block->parsed_block['attrs']['className'] ?? '';

	if ( str_contains( $class_name, 'is-featured-query' ) ) {
		$query['meta_key']       = '_featured_post';
		$query['meta_value']     = '1';
		$query['posts_per_page'] = 1;
		$query['orderby']        = 'date';
		$query['order']          = 'DESC';
	}

	if ( str_contains( $class_name, 'is-related-query' ) ) {
		$post_id = get_queried_object_id();

		if ( $post_id ) {
			$categories = wp_get_post_categories( $post_id );

			if ( ! empty( $categories ) ) {
				$query['category__in'] = $categories;
			}

			$query['post__not_in']   = array( $post_id );
			$query['posts_per_page'] = 3;
		}
	}

	return $query;
}
add_filter( 'query_loop_block_query_vars', 'ayan_modern_query_loop_block_query_vars', 10, 3 );

/**
 * Customize the main query for classic fallbacks.
 *
 * @param WP_Query $query Query object.
 */
function ayan_modern_pre_get_posts( $query ) {
	if ( ! is_admin() && $query->is_main_query() ) {
		if ( is_home() || is_archive() ) {
			$query->set( 'posts_per_page', 10 );
		}
	}
}
add_action( 'pre_get_posts', 'ayan_modern_pre_get_posts' );
