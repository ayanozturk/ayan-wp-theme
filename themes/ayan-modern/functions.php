<?php
/**
 * Ayan Modern Theme Functions
 * 
 * @package Ayan_Modern
 * @author Ayan Ozturk
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Theme setup
 */
function ayan_modern_setup() {
    // Add theme support for various features
    add_theme_support('automatic-feed-links');
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
        'style',
        'script',
    ));
    add_theme_support('custom-logo', array(
        'height'      => 60,
        'width'       => 200,
        'flex-height' => true,
        'flex-width'  => true,
    ));

    // Recommended supports
    add_theme_support('custom-header', array(
        'default-image'      => '',
        'width'              => 1600,
        'height'             => 400,
        'flex-width'         => true,
        'flex-height'        => true,
        'uploads'            => true,
        'header-text'        => false,
    ));

    add_theme_support('custom-background', array(
        'default-color' => 'ffffff',
        'default-image' => '',
    ));
    add_theme_support('customize-selective-refresh-widgets');
    add_theme_support('responsive-embeds');
    add_theme_support('wp-block-styles');
    add_theme_support('align-wide');
    add_theme_support('editor-styles');
    add_theme_support('dark-editor-style');
    // Editor styles
    add_editor_style('assets/css/editor-style.css');

    // Load translations
    load_theme_textdomain('ayan-modern', get_template_directory() . '/languages');

    // Register navigation menus
    register_nav_menus(array(
        'primary' => esc_html__('Primary Menu', 'ayan-modern'),
        'footer'  => esc_html__('Footer Menu', 'ayan-modern'),
    ));

    // Add image sizes
    add_image_size('ayan-modern-featured', 800, 400, true);
    add_image_size('ayan-modern-thumbnail', 400, 250, true);
    add_image_size('ayan-modern-square', 600, 600, true);
}
add_action('after_setup_theme', 'ayan_modern_setup');

/**
 * Enqueue scripts and styles
 */
function ayan_modern_scripts() {
    // Use theme version for cache-busting
    $theme      = wp_get_theme();
    $version    = $theme ? $theme->get('Version') : null;

    // Enqueue main stylesheet
    wp_enqueue_style('ayan-modern-style', get_stylesheet_uri(), array(), $version);
    
    // Enqueue Google Fonts
    wp_enqueue_style('ayan-modern-fonts', 'https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap', array(), null);
    
    // Enqueue main JavaScript
    wp_enqueue_script('ayan-modern-script', get_template_directory_uri() . '/assets/js/main.js', array(), $version, true);
    
    // Enqueue comment reply script
    if (is_singular() && comments_open() && get_option('thread_comments')) {
        wp_enqueue_script('comment-reply');
    }
}
add_action('wp_enqueue_scripts', 'ayan_modern_scripts');

/**
 * Register simple block patterns
 */
function ayan_modern_register_block_patterns() {
    if (!function_exists('register_block_pattern')) {
        return;
    }

    register_block_pattern(
        'ayan-modern/hero',
        array(
            'title'       => __('Hero with heading and paragraph', 'ayan-modern'),
            'description' => __('A simple hero section with a large heading and supporting text.', 'ayan-modern'),
            'categories'  => array('text'),
            'content'     => '<!-- wp:group {"layout":{"type":"constrained"}} --><div class="wp-block-group"><!-- wp:heading {"level":1} --><h1>' . esc_html__('Welcome to my blog', 'ayan-modern') . '</h1><!-- /wp:heading --><!-- wp:paragraph --><p>' . esc_html__('Sharing thoughts on technology, programming, and life.', 'ayan-modern') . '</p><!-- /wp:paragraph --></div><!-- /wp:group -->',
        )
    );

    register_block_pattern(
        'ayan-modern/callout',
        array(
            'title'       => __('Callout box', 'ayan-modern'),
            'description' => __('A subtle callout box with background and padding.', 'ayan-modern'),
            'categories'  => array('text'),
            'content'     => '<!-- wp:group {"style":{"spacing":{"padding":{"top":"24px","right":"24px","bottom":"24px","left":"24px"}},"border":{"radius":"12px"}},"backgroundColor":"bg-secondary","layout":{"type":"constrained"}} --><div class="wp-block-group has-bg-secondary-background-color has-background" style="border-radius:12px;padding-top:24px;padding-right:24px;padding-bottom:24px;padding-left:24px"><!-- wp:paragraph --><p>' . esc_html__('Pro tip: Use categories and tags to organize your content.', 'ayan-modern') . '</p><!-- /wp:paragraph --></div><!-- /wp:group -->',
        )
    );
}
add_action('init', 'ayan_modern_register_block_patterns');

/**
 * Inject custom header image styling
 */
function ayan_modern_custom_header_style() {
    $image = get_header_image();
    if ($image) {
        echo '<style id="ayan-modern-custom-header">.site-header{background-image:url(' . esc_url($image) . ');background-size:cover;background-position:center;}</style>';
    }
}
add_action('wp_head', 'ayan_modern_custom_header_style');

/**
 * Register custom block styles
 */
function ayan_modern_register_block_styles() {
    // Ensure main stylesheet is the handle used for block styles
    $style_handle = 'ayan-modern-style';

    // Image: Rounded corners
    if (function_exists('register_block_style')) {
        register_block_style('core/image', array(
            'name'         => 'rounded',
            'label'        => __('Rounded', 'ayan-modern'),
            'style_handle' => $style_handle,
        ));

        // Button: Outline variant
        register_block_style('core/button', array(
            'name'         => 'outline',
            'label'        => __('Outline', 'ayan-modern'),
            'style_handle' => $style_handle,
        ));

        // Quote: Card style
        register_block_style('core/quote', array(
            'name'         => 'card',
            'label'        => __('Card', 'ayan-modern'),
            'style_handle' => $style_handle,
        ));
    }
}
add_action('init', 'ayan_modern_register_block_styles');

/**
 * Register widget areas
 */
function ayan_modern_widgets_init() {
    register_sidebar(array(
        'name'          => esc_html__('Sidebar', 'ayan-modern'),
        'id'            => 'sidebar-1',
        'description'   => esc_html__('Add widgets here.', 'ayan-modern'),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h2 class="widget-title">',
        'after_title'   => '</h2>',
    ));
}
add_action('widgets_init', 'ayan_modern_widgets_init');

/**
 * Custom excerpt length
 */
function ayan_modern_excerpt_length($length) {
    return 25;
}
add_filter('excerpt_length', 'ayan_modern_excerpt_length');

/**
 * Custom excerpt more
 */
function ayan_modern_excerpt_more($more) {
    return '...';
}
add_filter('excerpt_more', 'ayan_modern_excerpt_more');

/**
 * Add custom classes to body
 */
function ayan_modern_body_classes($classes) {
    // Add a class of no-sidebar when there is no sidebar present
    if (!is_active_sidebar('sidebar-1')) {
        $classes[] = 'no-sidebar';
    }
    
    // Add class for single posts
    if (is_single()) {
        $classes[] = 'single-post';
    }
    
    // Add class for pages
    if (is_page()) {
        $classes[] = 'single-page';
    }
    
    return $classes;
}
add_filter('body_class', 'ayan_modern_body_classes');

/**
 * Customize the main query
 */
function ayan_modern_pre_get_posts($query) {
    if (!is_admin() && $query->is_main_query()) {
        // Set posts per page
        if (is_home() || is_archive()) {
            $query->set('posts_per_page', 10);
        }
    }
}
add_action('pre_get_posts', 'ayan_modern_pre_get_posts');

/**
 * Add custom meta boxes for posts
 */
function ayan_modern_add_meta_boxes() {
    add_meta_box(
        'ayan_modern_post_options',
        'Post Options',
        'ayan_modern_post_options_callback',
        'post',
        'side',
        'high'
    );
}
add_action('add_meta_boxes', 'ayan_modern_add_meta_boxes');

/**
 * Meta box callback
 */
function ayan_modern_post_options_callback($post) {
    wp_nonce_field('ayan_modern_save_meta_box_data', 'ayan_modern_meta_box_nonce');
    
    $featured_post = get_post_meta($post->ID, '_featured_post', true);
    $reading_time = get_post_meta($post->ID, '_reading_time', true);
    
    echo '<p><label for="featured_post">';
    echo '<input type="checkbox" id="featured_post" name="featured_post" value="1" ' . checked($featured_post, '1', false) . ' />';
    echo ' Mark as featured post</label></p>';
    
    echo '<p><label for="reading_time">Reading time (minutes):</label><br>';
    echo '<input type="number" id="reading_time" name="reading_time" value="' . esc_attr($reading_time) . '" min="1" max="60" /></p>';
}

/**
 * Save meta box data
 */
function ayan_modern_save_meta_box_data($post_id) {
    if (!isset($_POST['ayan_modern_meta_box_nonce'])) {
        return;
    }
    
    if (!wp_verify_nonce($_POST['ayan_modern_meta_box_nonce'], 'ayan_modern_save_meta_box_data')) {
        return;
    }
    
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }
    
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }
    
    // Save featured post status
    $featured_post = isset($_POST['featured_post']) ? '1' : '0';
    update_post_meta($post_id, '_featured_post', $featured_post);
    
    // Save reading time
    if (isset($_POST['reading_time'])) {
        update_post_meta($post_id, '_reading_time', sanitize_text_field($_POST['reading_time']));
    }
}
add_action('save_post', 'ayan_modern_save_meta_box_data');

/**
 * Get reading time for a post
 */
function ayan_modern_get_reading_time($post_id = null) {
    if (!$post_id) {
        $post_id = get_the_ID();
    }
    
    $reading_time = get_post_meta($post_id, '_reading_time', true);
    
    if ($reading_time) {
        return intval($reading_time);
    }
    
    // Calculate reading time based on content
    $content = get_post_field('post_content', $post_id);
    $word_count = str_word_count(strip_tags($content));
    $reading_time = ceil($word_count / 200); // Average reading speed: 200 words per minute
    
    return max(1, $reading_time);
}

/**
 * Customize the login page
 */
function ayan_modern_login_logo() {
    echo '<style type="text/css">
        #login h1 a {
            background-image: url(' . get_template_directory_uri() . '/assets/images/logo.png) !important;
            background-size: contain !important;
            width: 200px !important;
            height: 60px !important;
        }
    </style>';
}
add_action('login_head', 'ayan_modern_login_logo');

/**
 * Change login logo URL
 */
function ayan_modern_login_logo_url() {
    return home_url();
}
add_filter('login_headerurl', 'ayan_modern_login_logo_url');

/**
 * Change login logo title
 */
function ayan_modern_login_logo_url_title() {
    return get_bloginfo('name');
}
add_filter('login_headertext', 'ayan_modern_login_logo_url_title');

/**
 * Add customizer options
 */
function ayan_modern_customize_register($wp_customize) {
    // Add section for social media
    $wp_customize->add_section('ayan_modern_social', array(
        'title'    => __('Social Media', 'ayan-modern'),
        'priority' => 30,
    ));
    
    // Twitter
    $wp_customize->add_setting('ayan_modern_twitter', array(
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
    ));
    
    $wp_customize->add_control('ayan_modern_twitter', array(
        'label'   => __('Twitter URL', 'ayan-modern'),
        'section' => 'ayan_modern_social',
        'type'    => 'url',
    ));
    
    // GitHub
    $wp_customize->add_setting('ayan_modern_github', array(
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
    ));
    
    $wp_customize->add_control('ayan_modern_github', array(
        'label'   => __('GitHub URL', 'ayan-modern'),
        'section' => 'ayan_modern_social',
        'type'    => 'url',
    ));
    
    // LinkedIn
    $wp_customize->add_setting('ayan_modern_linkedin', array(
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
    ));
    
    $wp_customize->add_control('ayan_modern_linkedin', array(
        'label'   => __('LinkedIn URL', 'ayan-modern'),
        'section' => 'ayan_modern_social',
        'type'    => 'url',
    ));
    
    // Add section for site content
    $wp_customize->add_section('ayan_modern_content', array(
        'title'    => __('Site Content', 'ayan-modern'),
        'priority' => 35,
    ));
    
    // Welcome message
    $wp_customize->add_setting('ayan_modern_welcome_message', array(
        'default'           => 'Welcome to my blog where I share thoughts on technology, programming, and life.',
        'sanitize_callback' => 'sanitize_textarea_field',
    ));
    
    $wp_customize->add_control('ayan_modern_welcome_message', array(
        'label'       => __('Welcome Message', 'ayan-modern'),
        'description' => __('This message appears on the homepage below the header.', 'ayan-modern'),
        'section'     => 'ayan_modern_content',
        'type'        => 'textarea',
    ));
    
    // Show welcome message option
    $wp_customize->add_setting('ayan_modern_show_welcome', array(
        'default'           => true,
        'sanitize_callback' => 'rest_sanitize_boolean',
    ));
    
    $wp_customize->add_control('ayan_modern_show_welcome', array(
        'label'   => __('Show Welcome Message', 'ayan-modern'),
        'section' => 'ayan_modern_content',
        'type'    => 'checkbox',
    ));

    // Sidebar About text
    $wp_customize->add_setting('ayan_modern_sidebar_about', array(
        'default'           => "Welcome to my personal blog where I share thoughts on technology, programming, photography, and life. I'm passionate about creating meaningful content and connecting with fellow developers and creatives.",
        'sanitize_callback' => 'wp_kses_post',
    ));

    $wp_customize->add_control('ayan_modern_sidebar_about', array(
        'label'       => __('Sidebar About Text', 'ayan-modern'),
        'description' => __('Appears in the About widget in the sidebar. Supports basic HTML.', 'ayan-modern'),
        'section'     => 'ayan_modern_content',
        'type'        => 'textarea',
    ));

    // Sidebar visibility controls
    $wp_customize->add_section('ayan_modern_sidebar', array(
        'title'    => __('Sidebar', 'ayan-modern'),
        'priority' => 36,
    ));

    $wp_customize->add_setting('ayan_modern_sidebar_show_search', array(
        'default'           => true,
        'sanitize_callback' => 'rest_sanitize_boolean',
    ));
    $wp_customize->add_control('ayan_modern_sidebar_show_search', array(
        'label'   => __('Show Search', 'ayan-modern'),
        'section' => 'ayan_modern_sidebar',
        'type'    => 'checkbox',
    ));

    $wp_customize->add_setting('ayan_modern_sidebar_show_about', array(
        'default'           => true,
        'sanitize_callback' => 'rest_sanitize_boolean',
    ));
    $wp_customize->add_control('ayan_modern_sidebar_show_about', array(
        'label'   => __('Show About', 'ayan-modern'),
        'section' => 'ayan_modern_sidebar',
        'type'    => 'checkbox',
    ));

    $wp_customize->add_setting('ayan_modern_sidebar_show_recent', array(
        'default'           => true,
        'sanitize_callback' => 'rest_sanitize_boolean',
    ));
    $wp_customize->add_control('ayan_modern_sidebar_show_recent', array(
        'label'   => __('Show Recent Posts', 'ayan-modern'),
        'section' => 'ayan_modern_sidebar',
        'type'    => 'checkbox',
    ));

    $wp_customize->add_setting('ayan_modern_sidebar_show_categories', array(
        'default'           => true,
        'sanitize_callback' => 'rest_sanitize_boolean',
    ));
    $wp_customize->add_control('ayan_modern_sidebar_show_categories', array(
        'label'   => __('Show Categories', 'ayan-modern'),
        'section' => 'ayan_modern_sidebar',
        'type'    => 'checkbox',
    ));

    $wp_customize->add_setting('ayan_modern_sidebar_show_tags', array(
        'default'           => true,
        'sanitize_callback' => 'rest_sanitize_boolean',
    ));
    $wp_customize->add_control('ayan_modern_sidebar_show_tags', array(
        'label'   => __('Show Tags', 'ayan-modern'),
        'section' => 'ayan_modern_sidebar',
        'type'    => 'checkbox',
    ));

    $wp_customize->add_setting('ayan_modern_sidebar_show_social', array(
        'default'           => true,
        'sanitize_callback' => 'rest_sanitize_boolean',
    ));
    $wp_customize->add_control('ayan_modern_sidebar_show_social', array(
        'label'   => __('Show Social Links', 'ayan-modern'),
        'section' => 'ayan_modern_sidebar',
        'type'    => 'checkbox',
    ));
}
add_action('customize_register', 'ayan_modern_customize_register');

// Removed plugin-territory head cleanup and XML-RPC disabling per Theme Review guidelines

/**
 * Add custom image sizes to media library
 */
function ayan_modern_custom_image_sizes($sizes) {
    return array_merge($sizes, array(
        'ayan-modern-featured' => __('Featured Image', 'ayan-modern'),
        'ayan-modern-thumbnail' => __('Thumbnail', 'ayan-modern'),
    ));
}
add_filter('image_size_names_choose', 'ayan_modern_custom_image_sizes');

/**
 * Add schema markup
 */
function ayan_modern_schema_markup() {
    if (is_single()) {
        $schema = array(
            '@context' => 'https://schema.org',
            '@type' => 'BlogPosting',
            'headline' => get_the_title(),
            'author' => array(
                '@type' => 'Person',
                'name' => get_the_author(),
            ),
            'datePublished' => get_the_date('c'),
            'dateModified' => get_the_modified_date('c'),
            'publisher' => array(
                '@type' => 'Organization',
                'name' => get_bloginfo('name'),
            ),
        );
        
        if (has_post_thumbnail()) {
            $schema['image'] = get_the_post_thumbnail_url(get_the_ID(), 'full');
        }
        
        echo '<script type="application/ld+json">' . wp_json_encode($schema) . '</script>';
    }
}
add_action('wp_head', 'ayan_modern_schema_markup');

// Removed custom post type registration (plugin territory)

/**
 * Fallback menu function
 */
function ayan_modern_fallback_menu() {
    echo '<ul class="nav-menu">';
    echo '<li><a href="' . esc_url(home_url('/')) . '">Home</a></li>';
    echo '<li><a href="' . esc_url(home_url('/blog/')) . '">Blog</a></li>';
    echo '<li><a href="' . esc_url(home_url('/about/')) . '">About</a></li>';
    echo '<li><a href="' . esc_url(home_url('/contact/')) . '">Contact</a></li>';
    echo '</ul>';
}

// Removed rewrite rules flush (was used for CPT registration)
