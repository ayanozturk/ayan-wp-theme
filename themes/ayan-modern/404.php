<?php get_header(); ?>

<main class="site-main">
    <div class="container">
        <div class="content-area">
            <div class="main-content">
                <header class="page-header">
                    <h1 class="page-title">
                        <?php esc_html_e('Page Not Found', 'ayan-modern'); ?>
                    </h1>
                </header>

                <section class="no-results">
                    <h2><?php esc_html_e('Oops! That page can\'t be found.', 'ayan-modern'); ?></h2>
                    <p><?php esc_html_e('It looks like nothing was found at this location. The page may have been moved, deleted, or the URL might be incorrect.', 'ayan-modern'); ?></p>

                    <div class="search-form-container">
                        <?php get_search_form(); ?>
                    </div>

                    <div class="suggestions">
                        <h3><?php esc_html_e('Suggestions:', 'ayan-modern'); ?></h3>
                        <ul>
                            <li><?php esc_html_e('Check the URL for typos or extra characters.', 'ayan-modern'); ?></li>
                            <li><?php esc_html_e('Use the search form above to find what you\'re looking for.', 'ayan-modern'); ?></li>
                            <li>
                                <?php
                                printf(
                                    /* translators: %s: link to the homepage */
                                    esc_html__('Or %s to start fresh.', 'ayan-modern'),
                                    '<a href="' . esc_url(home_url('/')) . '">' . esc_html__('return home', 'ayan-modern') . '</a>'
                                );
                                ?>
                            </li>
                        </ul>
                    </div>
                </section>
            </div>

            <?php get_sidebar(); ?>
        </div>
    </div>
</main>

<?php get_footer(); ?>
