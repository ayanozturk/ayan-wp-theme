<?php
/**
 * Sample Theme functions and definitions
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Theme setup
 */
function sample_theme_setup() {
    // Add theme support for various features
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
    ));
    add_theme_support('custom-logo');
    add_theme_support('customize-selective-refresh-widgets');

    // Register navigation menus
    register_nav_menus(array(
        'primary' => esc_html__('Primary Menu', 'sample-theme'),
        'footer' => esc_html__('Footer Menu', 'sample-theme'),
    ));
}
add_action('after_setup_theme', 'sample_theme_setup');

/**
 * Enqueue scripts and styles
 */
function sample_theme_scripts() {
    wp_enqueue_style('sample-theme-style', get_stylesheet_uri(), array(), '1.0.0');
    
    if (is_singular() && comments_open() && get_option('thread_comments')) {
        wp_enqueue_script('comment-reply');
    }
}
add_action('wp_enqueue_scripts', 'sample_theme_scripts');

/**
 * Register widget areas
 */
function sample_theme_widgets_init() {
    register_sidebar(array(
        'name'          => esc_html__('Sidebar', 'sample-theme'),
        'id'            => 'sidebar-1',
        'description'   => esc_html__('Add widgets here.', 'sample-theme'),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h2 class="widget-title">',
        'after_title'   => '</h2>',
    ));
}
add_action('widgets_init', 'sample_theme_widgets_init');

/**
 * Custom excerpt length
 */
function sample_theme_excerpt_length($length) {
    return 20;
}
add_filter('excerpt_length', 'sample_theme_excerpt_length');

/**
 * Custom excerpt more
 */
function sample_theme_excerpt_more($more) {
    return '...';
}
add_filter('excerpt_more', 'sample_theme_excerpt_more');

/**
 * Add custom classes to body
 */
function sample_theme_body_classes($classes) {
    // Add a class of no-sidebar when there is no sidebar present
    if (!is_active_sidebar('sidebar-1')) {
        $classes[] = 'no-sidebar';
    }
    return $classes;
}
add_filter('body_class', 'sample_theme_body_classes');
