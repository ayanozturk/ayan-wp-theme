<?php get_header(); ?>

<main class="site-main">
    <div class="container">
        <?php if (have_posts()) : ?>
            <?php while (have_posts()) : the_post(); ?>
                <article id="post-<?php the_ID(); ?>" <?php post_class('entry-content'); ?>>
                    <header class="entry-header">
                        <h1 class="entry-title">
                            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                        </h1>
                        <div class="entry-meta">
                            <span class="posted-on">
                                Posted on <?php echo get_the_date(); ?>
                            </span>
                            <span class="byline">
                                by <?php the_author(); ?>
                            </span>
                        </div>
                    </header>

                    <div class="entry-summary">
                        <?php the_excerpt(); ?>
                    </div>

                    <footer class="entry-footer">
                        <a href="<?php the_permalink(); ?>" class="read-more">
                            Read More →
                        </a>
                    </footer>
                </article>
            <?php endwhile; ?>

            <?php
            // Pagination
            the_posts_pagination(array(
                'mid_size' => 2,
                'prev_text' => '← Previous',
                'next_text' => 'Next →',
            ));
            ?>

        <?php else : ?>
            <article class="entry-content">
                <h1>Nothing Found</h1>
                <p>It looks like nothing was found at this location.</p>
            </article>
        <?php endif; ?>
    </div>
</main>

<?php get_footer(); ?>
