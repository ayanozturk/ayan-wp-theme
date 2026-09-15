<?php
/**
 * Schema JSON-LD.
 *
 * @package Ayan_Modern
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Add schema markup.
 */
function ayan_modern_schema_markup() {
	if ( is_front_page() || is_home() ) {
		$website = array(
			'@context' => 'https://schema.org',
			'@type'      => 'WebSite',
			'name'       => get_bloginfo( 'name' ),
			'url'        => home_url( '/' ),
			'description'=> get_bloginfo( 'description' ),
		);

		echo '<script type="application/ld+json">' . wp_json_encode( $website ) . '</script>';
	}

	if ( ! is_single() ) {
		return;
	}

	$schema = array(
		'@context'      => 'https://schema.org',
		'@type'         => 'BlogPosting',
		'headline'      => get_the_title(),
		'author'        => array(
			'@type' => 'Person',
			'name'  => get_the_author(),
		),
		'datePublished' => get_the_date( 'c' ),
		'dateModified'  => get_the_modified_date( 'c' ),
		'publisher'     => array(
			'@type' => 'Organization',
			'name'  => get_bloginfo( 'name' ),
		),
	);

	if ( has_post_thumbnail() ) {
		$schema['image'] = get_the_post_thumbnail_url( get_the_ID(), 'full' );
	}

	echo '<script type="application/ld+json">' . wp_json_encode( $schema ) . '</script>';
}
add_action( 'wp_head', 'ayan_modern_schema_markup' );
