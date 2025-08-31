<aside id="secondary" class="sidebar" role="complementary">
    <!-- Search Widget -->
    <?php if ( get_theme_mod('ayan_modern_sidebar_show_search', true) ) : ?>
    <section class="widget widget_search">
        <h2 class="widget-title">Search</h2>
        <?php get_search_form(); ?>
    </section>
    <?php endif; ?>

    <!-- About Widget -->
    <?php if ( get_theme_mod('ayan_modern_sidebar_show_about', true) ) : ?>
    <section class="widget widget_about">
        <h2 class="widget-title">About</h2>
        <div class="about-content">
            <p><?php echo wp_kses_post( get_theme_mod('ayan_modern_sidebar_about', "Welcome to my personal blog where I share thoughts on technology, programming, photography, and life. I'm passionate about creating meaningful content and connecting with fellow developers and creatives.") ); ?></p>
        </div>
    </section>
    <?php endif; ?>

    <!-- Recent Posts Widget -->
    <?php if ( get_theme_mod('ayan_modern_sidebar_show_recent', true) ) : ?>
    <section class="widget widget_recent_entries">
        <h2 class="widget-title">Recent Posts</h2>
        <ul>
            <?php
            $recent_posts = wp_get_recent_posts(array(
                'numberposts' => 5,
                'post_status' => 'publish'
            ));
            
            foreach ($recent_posts as $post) :
            ?>
                <li>
                    <a href="<?php echo get_permalink($post['ID']); ?>">
                        <?php echo $post['post_title']; ?>
                    </a>
                    <span class="post-date"><?php echo get_the_date('', $post['ID']); ?></span>
                </li>
            <?php endforeach; ?>
        </ul>
    </section>
    <?php endif; ?>

    <!-- Categories Widget -->
    <?php if ( get_theme_mod('ayan_modern_sidebar_show_categories', true) ) : ?>
    <section class="widget widget_categories">
        <h2 class="widget-title">Categories</h2>
        <ul>
            <?php
            $categories = get_categories(array(
                'orderby' => 'count',
                'order' => 'DESC',
                'number' => 10
            ));
            
            foreach ($categories as $category) :
            ?>
                <li>
                    <a href="<?php echo get_category_link($category->term_id); ?>">
                        <?php echo $category->name; ?>
                        <span class="category-count">(<?php echo $category->count; ?>)</span>
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>
    </section>
    <?php endif; ?>

    <!-- Tags Widget -->
    <?php if ( get_theme_mod('ayan_modern_sidebar_show_tags', true) ) : ?>
    <section class="widget widget_tag_cloud">
        <h2 class="widget-title">Popular Tags</h2>
        <div class="tag-cloud">
            <?php
            $tags = get_tags(array(
                'orderby' => 'count',
                'order' => 'DESC',
                'number' => 20
            ));
            
            if ($tags) :
                foreach ($tags as $tag) :
                    $tag_link = get_tag_link($tag->term_id);
                    $font_size = 0.8 + ($tag->count / 10) * 0.4; // Scale font size based on count
            ?>
                <a href="<?php echo $tag_link; ?>" 
                   class="tag-link" 
                   style="font-size: <?php echo $font_size; ?>em;">
                    <?php echo $tag->name; ?>
                </a>
            <?php
                endforeach;
            endif;
            ?>
        </div>
    </section>
    <?php endif; ?>

    <!-- Social Links Widget -->
    <?php
    // Check if any social media links are configured and section enabled
    $has_social_links = get_theme_mod('ayan_modern_twitter') || 
                      get_theme_mod('ayan_modern_github') || 
                      get_theme_mod('ayan_modern_linkedin');
    
    if ( get_theme_mod('ayan_modern_sidebar_show_social', true) && $has_social_links ) :
    ?>
    <section class="widget widget_social">
        <h2 class="widget-title">Follow Me</h2>
        <div class="social-links">
            <?php if (get_theme_mod('ayan_modern_twitter')) : ?>
                <a href="<?php echo esc_url(get_theme_mod('ayan_modern_twitter')); ?>" target="_blank" rel="noopener noreferrer" aria-label="Twitter">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/>
                    </svg>
                    Twitter
                </a>
            <?php endif; ?>
            
            <?php if (get_theme_mod('ayan_modern_github')) : ?>
                <a href="<?php echo esc_url(get_theme_mod('ayan_modern_github')); ?>" target="_blank" rel="noopener noreferrer" aria-label="GitHub">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M12 0c-6.626 0-12 5.373-12 12 0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23.957-.266 1.983-.399 3.003-.404 1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576 4.765-1.589 8.199-6.086 8.199-11.386 0-6.627-5.373-12-12-12z"/>
                    </svg>
                    GitHub
                </a>
            <?php endif; ?>
            
            <?php if (get_theme_mod('ayan_modern_linkedin')) : ?>
                <a href="<?php echo esc_url(get_theme_mod('ayan_modern_linkedin')); ?>" target="_blank" rel="noopener noreferrer" aria-label="LinkedIn">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
                    </svg>
                    LinkedIn
                </a>
            <?php endif; ?>
        </div>
    </section>
    <?php endif; ?>

    <?php if (is_active_sidebar('sidebar-1')) : ?>
        <?php dynamic_sidebar('sidebar-1'); ?>
    <?php endif; ?>
</aside>
