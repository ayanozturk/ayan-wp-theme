<?php get_header(); ?>

<main class="site-main">
    <div class="container">
        <div class="content-area">
            <div class="main-content">
                <header class="page-header">
                    <h1 class="page-title">
                        <?php
                        printf(
                            esc_html__('Search Results for: %s', 'ayan-modern'),
                            '<span>' . get_search_query() . '</span>'
                        );
                        ?>
                    </h1>
                </header>

                <?php if (have_posts()) : ?>
                    <div class="search-results">
                        <?php while (have_posts()) : the_post(); ?>
                            <article id="post-<?php the_ID(); ?>" <?php post_class('search-result'); ?>>
                                <div class="search-result-content">
                                    <header class="entry-header">
                                        <h2 class="entry-title">
                                            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                        </h2>
                                        
                                        <div class="entry-meta">
                                            <span class="post-date"><?php echo get_the_date(); ?></span>
                                            <span class="post-type"><?php echo get_post_type_object(get_post_type())->labels->singular_name; ?></span>
                                        </div>
                                    </header>

                                    <div class="entry-summary">
                                        <?php the_excerpt(); ?>
                                    </div>

                                    <footer class="entry-footer">
                                        <a href="<?php the_permalink(); ?>" class="read-more">
                                            <?php esc_html_e('Read More →', 'ayan-modern'); ?>
                                        </a>
                                    </footer>
                                </div>
                            </article>
                        <?php endwhile; ?>
                    </div>

                    <!-- Pagination -->
                    <?php
                    the_posts_pagination(array(
                        'mid_size' => 2,
                        'prev_text' => '← Previous',
                        'next_text' => 'Next →',
                        'class' => 'pagination',
                    ));
                    ?>

                <?php else : ?>
                    <section class="no-results">
                        <h2><?php esc_html_e('Nothing Found', 'ayan-modern'); ?></h2>
                        <p><?php esc_html_e('Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'ayan-modern'); ?></p>
                        
                        <div class="search-form-container">
                            <?php get_search_form(); ?>
                        </div>
                        
                        <div class="suggestions">
                            <h3><?php esc_html_e('Suggestions:', 'ayan-modern'); ?></h3>
                            <ul>
                                <li><?php esc_html_e('Make sure all words are spelled correctly.', 'ayan-modern'); ?></li>
                                <li><?php esc_html_e('Try different keywords.', 'ayan-modern'); ?></li>
                                <li><?php esc_html_e('Try more general keywords.', 'ayan-modern'); ?></li>
                                <li><?php esc_html_e('Try fewer keywords.', 'ayan-modern'); ?></li>
                            </ul>
                        </div>
                    </section>
                <?php endif; ?>
            </div>
            
            <?php get_sidebar(); ?>
        </div>
    </div>
</main>

<?php get_footer(); ?>
