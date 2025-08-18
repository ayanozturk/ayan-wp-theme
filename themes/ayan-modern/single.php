<?php get_header(); ?>

<main class="site-main">
    <div class="container">
        <div class="content-area">
            <div class="main-content">
                <?php while (have_posts()) : the_post(); ?>
                    <article id="post-<?php the_ID(); ?>" <?php post_class('single-post'); ?>>
                        <header class="post-header">
                            <div class="post-meta">
                                <span class="post-date"><?php echo get_the_date(); ?></span>
                                <span class="reading-time"><?php echo ayan_modern_get_reading_time(); ?> min read</span>
                                <?php if (has_category()) : ?>
                                    <span class="post-categories"><?php the_category(', '); ?></span>
                                <?php endif; ?>
                            </div>
                            
                            <h1 class="post-title"><?php the_title(); ?></h1>
                            
                            <div class="post-author">
                                <div class="author-avatar">
                                    <?php echo get_avatar(get_the_author_meta('ID'), 60); ?>
                                </div>
                                <div class="author-info">
                                    <span class="author-name"><?php the_author(); ?></span>
                                    <span class="author-bio"><?php echo get_the_author_meta('description'); ?></span>
                                </div>
                            </div>
                        </header>

                        <?php if (has_post_thumbnail()) : ?>
                            <div class="post-featured-image">
                                <?php the_post_thumbnail('full'); ?>
                            </div>
                        <?php endif; ?>

                        <div class="post-content">
                            <?php the_content(); ?>
                            
                            <?php
                            wp_link_pages(array(
                                'before' => '<div class="page-links">' . esc_html__('Pages:', 'ayan-modern'),
                                'after'  => '</div>',
                            ));
                            ?>
                        </div>

                        <footer class="post-footer">
                            <?php if (has_tag()) : ?>
                                <div class="post-tags">
                                    <h4>Tags:</h4>
                                    <?php the_tags('<div class="tag-list">', ', ', '</div>'); ?>
                                </div>
                            <?php endif; ?>

                            <div class="post-share">
                                <h4>Share this post:</h4>
                                <div class="share-buttons">
                                    <a href="https://twitter.com/intent/tweet?url=<?php echo urlencode(get_permalink()); ?>&text=<?php echo urlencode(get_the_title()); ?>" target="_blank" rel="noopener noreferrer" class="share-button share-twitter">
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                                            <path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/>
                                        </svg>
                                        Twitter
                                    </a>
                                    
                                    <a href="https://www.linkedin.com/sharing/share-offsite/?url=<?php echo urlencode(get_permalink()); ?>" target="_blank" rel="noopener noreferrer" class="share-button share-linkedin">
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                                            <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
                                        </svg>
                                        LinkedIn
                                    </a>
                                    
                                    <button class="share-button share-copy" onclick="copyToClipboard('<?php echo esc_js(get_permalink()); ?>')">
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                                            <path d="M16 1H4c-1.1 0-2 .9-2 2v14h2V3h12V1zm3 4H8c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h11c1.1 0 2-.9 2-2V7c0-1.1-.9-2-2-2zm0 16H8V7h11v14z"/>
                                        </svg>
                                        Copy Link
                                    </button>
                                </div>
                            </div>
                        </footer>
                    </article>

                    <!-- Author Bio -->
                    <section class="author-bio-section">
                        <div class="author-bio-card">
                            <div class="author-avatar-large">
                                <?php echo get_avatar(get_the_author_meta('ID'), 100); ?>
                            </div>
                            <div class="author-bio-content">
                                <h3>About <?php the_author(); ?></h3>
                                <p><?php echo get_the_author_meta('description'); ?></p>
                                <div class="author-links">
                                    <?php if (get_the_author_meta('url')) : ?>
                                        <a href="<?php echo esc_url(get_the_author_meta('url')); ?>" target="_blank" rel="noopener noreferrer">Website</a>
                                    <?php endif; ?>
                                    <a href="<?php echo esc_url(get_author_posts_url(get_the_author_meta('ID'))); ?>">More posts by <?php the_author(); ?></a>
                                </div>
                            </div>
                        </div>
                    </section>

                    <!-- Related Posts -->
                    <?php
                    $categories = get_the_category();
                    if ($categories) {
                        $category_ids = array();
                        foreach ($categories as $category) {
                            $category_ids[] = $category->term_id;
                        }
                        
                        $related_posts = new WP_Query(array(
                            'category__in' => $category_ids,
                            'post__not_in' => array(get_the_ID()),
                            'posts_per_page' => 3,
                            'orderby' => 'rand'
                        ));
                        
                        if ($related_posts->have_posts()) :
                    ?>
                        <section class="related-posts">
                            <h3>Related Posts</h3>
                            <div class="related-posts-grid">
                                <?php while ($related_posts->have_posts()) : $related_posts->the_post(); ?>
                                    <article class="related-post">
                                        <?php if (has_post_thumbnail()) : ?>
                                            <div class="related-post-image">
                                                <a href="<?php the_permalink(); ?>">
                                                    <?php the_post_thumbnail('ayan-modern-thumbnail'); ?>
                                                </a>
                                            </div>
                                        <?php endif; ?>
                                        
                                        <div class="related-post-content">
                                            <h4 class="related-post-title">
                                                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                            </h4>
                                            <div class="related-post-meta">
                                                <span class="post-date"><?php echo get_the_date(); ?></span>
                                            </div>
                                        </div>
                                    </article>
                                <?php endwhile; ?>
                            </div>
                        </section>
                    <?php
                        endif;
                        wp_reset_postdata();
                    }
                    ?>

                    <!-- Navigation -->
                    <nav class="post-navigation">
                        <div class="nav-links">
                            <div class="nav-previous">
                                <?php previous_post_link('%link', '← %title'); ?>
                            </div>
                            <div class="nav-next">
                                <?php next_post_link('%link', '%title →'); ?>
                            </div>
                        </div>
                    </nav>

                    <!-- Comments -->
                    <?php
                    if (comments_open() || get_comments_number()) :
                        comments_template();
                    endif;
                    ?>

                <?php endwhile; ?>
            </div>
            
            <?php get_sidebar(); ?>
        </div>
    </div>
</main>

<script>
function copyToClipboard(text) {
    navigator.clipboard.writeText(text).then(function() {
        const button = event.target.closest('.share-copy');
        const originalText = button.innerHTML;
        button.innerHTML = '<svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/></svg>Copied!';
        setTimeout(() => {
            button.innerHTML = originalText;
        }, 2000);
    });
}
</script>

<?php get_footer(); ?>
