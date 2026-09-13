<?php get_header(); ?>

<main class="site-main">
    <div class="container">
        <div class="content-area">
            <div class="main-content">
                <?php if (have_posts()) : ?>

                    <section class="posts-section">
                        <header class="page-header">
                            <h1 class="page-title"><?php the_archive_title(); ?></h1>
                            <?php the_archive_description('<div class="archive-description">', '</div>'); ?>
                        </header>

                        <div class="posts-grid posts-grid--square">
                            <?php while (have_posts()) : the_post(); ?>
                                <article id="post-<?php the_ID(); ?>" <?php post_class('post-card'); ?>>
                                    <?php if (has_post_thumbnail()) : ?>
                                        <div class="post-image post-image--square">
                                            <a href="<?php the_permalink(); ?>">
                                                <?php echo get_the_post_thumbnail(get_the_ID(), 'ayan-modern-square'); ?>
                                            </a>
                                        </div>
                                    <?php endif; ?>

                                    <div class="post-content">
                                        <header class="post-header">
                                            <div class="post-meta">
                                                <span class="post-date"><?php echo get_the_date(); ?></span>
                                                <span class="reading-time"><?php echo ayan_modern_get_reading_time(); ?> min read</span>
                                            </div>

                                            <h2 class="post-title">
                                                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                            </h2>
                                        </header>

                                        <div class="post-excerpt">
                                            <?php the_excerpt(); ?>
                                        </div>

                                        <footer class="post-footer">
                                            <div class="post-categories">
                                                <?php the_category(', '); ?>
                                            </div>

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

                    </section>

                <?php else : ?>
                    <section class="no-results">
                        <h2><?php esc_html_e('Nothing Found', 'ayan-modern'); ?></h2>
                        <p><?php esc_html_e('It looks like nothing was found at this location. Maybe try a search?', 'ayan-modern'); ?></p>

                        <div class="search-form-container">
                            <?php get_search_form(); ?>
                        </div>
                    </section>
                <?php endif; ?>
            </div>

            <?php get_sidebar(); ?>
        </div>
    </div>
</main>

<?php get_footer(); ?>
