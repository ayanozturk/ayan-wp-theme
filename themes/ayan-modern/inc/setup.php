<?php
/**
 * Theme setup and supports.
 *
 * @package Ayan_Modern
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Theme setup.
 */
function ayan_modern_setup() {
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support(
		'html5',
		array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
			'style',
			'script',
		)
	);
	add_theme_support(
		'custom-logo',
		array(
			'height'      => 60,
			'width'       => 200,
			'flex-height' => true,
			'flex-width'  => true,
		)
	);

	add_theme_support( 'responsive-embeds' );
	add_theme_support( 'wp-block-styles' );
	add_theme_support( 'align-wide' );
	add_theme_support( 'editor-styles' );
	add_theme_support( 'dark-editor-style' );

	$built_editor_css = get_template_directory() . '/assets/css/theme.css';
	if ( file_exists( $built_editor_css ) ) {
		add_editor_style( 'assets/css/theme.css' );
	}

	load_theme_textdomain( 'ayan-modern', get_template_directory() . '/languages' );

	register_nav_menus(
		array(
			'primary' => esc_html__( 'Primary Menu', 'ayan-modern' ),
			'footer'  => esc_html__( 'Footer Menu', 'ayan-modern' ),
		)
	);

	add_image_size( 'ayan-modern-featured', 800, 400, true );
	add_image_size( 'ayan-modern-thumbnail', 400, 250, true );
	add_image_size( 'ayan-modern-square', 600, 600, true );
}
add_action( 'after_setup_theme', 'ayan_modern_setup' );

/**
 * Add custom image sizes to media library.
 *
 * @param array $sizes Image sizes.
 * @return array
 */
function ayan_modern_custom_image_sizes( $sizes ) {
	return array_merge(
		$sizes,
		array(
			'ayan-modern-featured'  => __( 'Featured Image', 'ayan-modern' ),
			'ayan-modern-thumbnail' => __( 'Thumbnail', 'ayan-modern' ),
			'ayan-modern-square'    => __( 'Square Crop', 'ayan-modern' ),
		)
	);
}
add_filter( 'image_size_names_choose', 'ayan_modern_custom_image_sizes' );

/**
 * Add custom classes to body.
 *
 * @param array $classes Body classes.
 * @return array
 */
function ayan_modern_body_classes( $classes ) {
	if ( is_single() ) {
		$classes[] = 'single-post';
	}

	if ( is_page() ) {
		$classes[] = 'single-page';
	}

	return $classes;
}
add_filter( 'body_class', 'ayan_modern_body_classes' );

/**
 * One-time import of legacy Customizer values into template parts.
 *
 * Reads existing theme mods once after switching to the block theme, then stops.
 * If template parts cannot be updated programmatically, values remain in theme mods
 * for manual copy into the Site Editor (Appearance → Editor → Patterns / template parts).
 */
function ayan_modern_import_customizer_to_fse() {
	if ( get_option( 'ayan_modern_fse_migrated' ) ) {
		return;
	}

	$welcome = get_theme_mod(
		'ayan_modern_welcome_message',
		'Welcome — personal notes on technology, craft, and the work of building things that last.'
	);

	$social = array(
		'twitter'  => get_theme_mod( 'ayan_modern_twitter', '' ),
		'github'   => get_theme_mod( 'ayan_modern_github', '' ),
		'linkedin' => get_theme_mod( 'ayan_modern_linkedin', '' ),
	);

	$updated = false;

	if ( $welcome && function_exists( 'get_block_template' ) ) {
		$home = get_block_template( get_stylesheet() . '//home', 'wp_template' );
		if ( $home && ! empty( $home->content ) && str_contains( $home->content, 'ayan-modern/hero-home' ) ) {
			$hero_pattern = '<!-- wp:paragraph {"fontSize":"large","style":{"typography":{"lineHeight":"1.5"}}} -->
<p class="has-large-font-size" style="line-height:1.5">' . esc_html( $welcome ) . '</p>
<!-- /wp:paragraph -->';

			$new_content = preg_replace(
				'/<!-- wp:paragraph.*?<!-- \/wp:paragraph -->/s',
				$hero_pattern,
				$home->content,
				1
			);

			if ( $new_content && $new_content !== $home->content && ! empty( $home->wp_id ) ) {
				wp_update_post(
					array(
						'ID'           => (int) $home->wp_id,
						'post_content' => $new_content,
					)
				);
				$updated = true;
			}
		}
	}

	$has_social = array_filter( $social );
	if ( $has_social && function_exists( 'get_block_template' ) ) {
		$footer = get_block_template( get_stylesheet() . '//footer', 'wp_template_part' );
		if ( $footer && ! empty( $footer->wp_id ) ) {
			$content = $footer->content;

			foreach ( $social as $service => $url ) {
				if ( ! $url ) {
					continue;
				}

				$content = preg_replace(
					'/("service":"' . preg_quote( $service, '/' ) . '"}[^}]*"url":")[^"]*(")/',
					'${1}' . esc_url_raw( $url ) . '${2}',
					$content
				);
			}

			if ( $content !== $footer->content ) {
				wp_update_post(
					array(
						'ID'           => (int) $footer->wp_id,
						'post_content' => $content,
					)
				);
				$updated = true;
			}
		}
	}

	update_option( 'ayan_modern_fse_migrated', 1, false );

	if ( ! $updated && ( $welcome || $has_social ) ) {
		update_option(
			'ayan_modern_fse_migration_note',
			array(
				'welcome' => $welcome,
				'social'  => $social,
			),
			false
		);
	}
}
add_action( 'after_switch_theme', 'ayan_modern_import_customizer_to_fse' );

/**
 * Show admin notice when manual Site Editor migration is needed.
 */
function ayan_modern_fse_migration_admin_notice() {
	$note = get_option( 'ayan_modern_fse_migration_note' );

	if ( ! $note || ! current_user_can( 'edit_theme_options' ) ) {
		return;
	}

	echo '<div class="notice notice-info is-dismissible"><p>';
	echo esc_html__( 'Ayan Modern imported legacy Customizer values. Open Appearance → Editor to confirm welcome text and social links in your header/footer template parts.', 'ayan-modern' );
	echo '</p></div>';

	delete_option( 'ayan_modern_fse_migration_note' );
}
add_action( 'admin_notices', 'ayan_modern_fse_migration_admin_notice' );
