<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="profile" href="https://gmpg.org/xfn/11">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<div id="page" class="site">
    <header id="masthead" class="site-header">
        <div class="container">
            <div class="header-content">
                <div class="site-branding">
                    <?php
                    if (has_custom_logo()) {
                        the_custom_logo();
                    } else {
                        ?>
                        <h1 class="site-title">
                            <a href="<?php echo esc_url(home_url('/')); ?>" rel="home">
                                <?php bloginfo('name'); ?>
                            </a>
                        </h1>
                        <?php
                        $ayan_modern_description = get_bloginfo('description', 'display');
                        if ($ayan_modern_description || is_customize_preview()) :
                            ?>
                            <p class="site-description"><?php echo $ayan_modern_description; ?></p>
                        <?php endif;
                    }
                    ?>
                </div>

                <nav id="site-navigation" class="main-navigation">
                    <button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false">
                        <span class="menu-toggle-icon"></span>
                        <span class="screen-reader-text"><?php esc_html_e('Menu', 'ayan-modern'); ?></span>
                    </button>
                    
                    <?php
                    wp_nav_menu(array(
                        'theme_location' => 'primary',
                        'menu_id'        => 'primary-menu',
                        'menu_class'     => 'nav-menu',
                        'container'      => false,
                        'fallback_cb'    => 'ayan_modern_fallback_menu',
                    ));
                    ?>
                </nav>
            </div>
        </div>
    </header>

    <!-- Optional: Small welcome section for homepage only -->
    <?php if (is_home() && !is_paged() && get_theme_mod('ayan_modern_show_welcome', true)) : ?>
        <div class="welcome-banner">
            <div class="container">
                <p class="welcome-text">
                    <?php echo esc_html(get_theme_mod('ayan_modern_welcome_message', 'Welcome to my blog where I share thoughts on technology, programming, and life.')); ?>
                </p>
            </div>
        </div>
    <?php endif; ?>
