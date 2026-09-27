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
	$class_name = $block->attributes['className'] ?? $block->parsed_block['attrs']['className'] ?? '';
	$query_id  = absint( $block->context['queryId'] ?? 0 );

	if ( 1 === $query_id || str_contains( $class_name, 'is-featured-query' ) ) {
		$featured_post_id = ayan_modern_get_home_featured_post_id();
		$query['post__in']       = $featured_post_id ? array( $featured_post_id ) : array( 0 );
		$query['posts_per_page'] = 1;
	}

	if ( 2 === $query_id && ( is_home() || is_front_page() ) ) {
		$featured_post_id = ayan_modern_get_home_featured_post_id();

		if ( $featured_post_id ) {
			$query['post__not_in'] = array_values(
				array_unique(
					array_merge(
						array_map( 'absint', $query['post__not_in'] ?? array() ),
						array( $featured_post_id )
					)
				)
			);
		}
	}

	if ( 3 === $query_id || str_contains( $class_name, 'related-posts-list' ) ) {
		$post_id = absint( $block->context['postId'] ?? 0 );

		if ( ! $post_id ) {
			$post_id = absint( get_queried_object_id() );
		}

		if ( ! $post_id && isset( $GLOBALS['post']->ID ) ) {
			$post_id = absint( $GLOBALS['post']->ID );
		}
		if ( $post_id ) {
			$categories = wp_get_post_categories( $post_id );

			if ( ! empty( $categories ) ) {
				$query['category__in'] = $categories;
			}

			$query['post__not_in']   = array_values(
				array_unique(
					array_merge(
						array_map( 'absint', $query['post__not_in'] ?? array() ),
						array( $post_id )
					)
				)
			);
			$query['posts_per_page'] = 3;
		}
	}

	return $query;
}
add_filter( 'query_loop_block_query_vars', 'ayan_modern_query_loop_block_query_vars', 10, 3 );

/**
 * Get the post shown in the homepage feature. Fall back to the newest post.
 *
 * @return int
 */
function ayan_modern_get_home_featured_post_id() {
	static $featured_post_id = null;

	if ( null !== $featured_post_id ) {
		return $featured_post_id;
	}

	$featured_posts = get_posts(
		array(
			'post_type'              => 'post',
			'post_status'            => 'publish',
			'posts_per_page'         => 1,
			'meta_key'               => '_featured_post',
			'meta_value'             => '1',
			'orderby'                => 'date',
			'order'                  => 'DESC',
			'fields'                 => 'ids',
			'no_found_rows'          => true,
			'update_post_meta_cache' => false,
			'update_post_term_cache' => false,
		)
	);

	if ( empty( $featured_posts ) ) {
		$featured_posts = get_posts(
			array(
				'post_type'              => 'post',
				'post_status'            => 'publish',
				'posts_per_page'         => 1,
				'orderby'                => 'date',
				'order'                  => 'DESC',
				'fields'                 => 'ids',
				'no_found_rows'          => true,
				'update_post_meta_cache' => false,
				'update_post_term_cache' => false,
			)
		);
	}

	$featured_post_id = empty( $featured_posts ) ? 0 : absint( reset( $featured_posts ) );

	return $featured_post_id;
}

/**
 * Customize the main query for classic fallbacks.
 *
 * @param WP_Query $query Query object.
 */
function ayan_modern_pre_get_posts( $query ) {
	if ( ! is_admin() && $query->is_main_query() ) {
		if ( is_home() ) {
			$query->set( 'posts_per_page', 10 );

			$featured_post_id = ayan_modern_get_home_featured_post_id();

			if ( $featured_post_id ) {
				$query->set(
					'post__not_in',
					array_values(
						array_unique(
							array_merge(
								array_map( 'absint', (array) $query->get( 'post__not_in' ) ),
								array( $featured_post_id )
							)
						)
					)
				);
			}
		} elseif ( is_archive() ) {
			$query->set( 'posts_per_page', 10 );
		}
	}
}
add_action( 'pre_get_posts', 'ayan_modern_pre_get_posts' );
