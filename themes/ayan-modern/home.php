<?php get_header(); ?>

<main class="site-main">
	<div class="container">
		<div class="content-area">
			<div class="main-content">
				<?php if (have_posts()) : ?>
					
					<?php if (is_home() && !is_paged()) : ?>
						<!-- Featured Posts Section -->
						<section class="featured-posts">
							<h2 class="section-title">Featured Posts</h2>
							<div class="featured-grid">
								<?php
								$featured_posts = new WP_Query(array(
									'posts_per_page' => 3,
									'meta_key' => '_featured_post',
									'meta_value' => '1',
									'post_status' => 'publish'
								));
								
								if ($featured_posts->have_posts()) :
									while ($featured_posts->have_posts()) : $featured_posts->the_post();
								?>
									<article class="featured-post">
										<?php if (has_post_thumbnail()) : ?>
											<div class="featured-image">
												<a href="<?php the_permalink(); ?>">
													<?php the_post_thumbnail('ayan-modern-featured'); ?>
												</a>
											</div>
										<?php endif; ?>
										
										<div class="featured-content">
											<div class="post-meta">
												<span class="post-date"><?php echo get_the_date(); ?></span>
												<span class="reading-time"><?php echo ayan_modern_get_reading_time(); ?> min read</span>
											</div>
											
											<h3 class="post-title">
												<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
											</h3>
											
											<div class="post-excerpt">
												<?php the_excerpt(); ?>
											</div>
											
											<div class="post-categories">
												<?php the_category(', '); ?>
											</div>
										</div>
									</article>
								<?php
									endwhile;
									wp_reset_postdata();
								endif;
								?>
							</div>
						</section>
						
						<hr class="section-divider">
					<?php endif; ?>
					
					<!-- Regular Posts -->
					<section class="posts-section">
						<div class="posts-grid">
							<?php while (have_posts()) : the_post(); ?>
								<article id="post-<?php the_ID(); ?>" <?php post_class('post-card'); ?>>
									<?php if (has_post_thumbnail()) : ?>
										<div class="post-image">
											<a href="<?php the_permalink(); ?>">
												<?php the_post_thumbnail('ayan-modern-thumbnail'); ?>
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
												Read More →
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
					<section class="no-posts">
						<h1><?php _e('Nothing Found', 'ayan-modern'); ?></h1>
						<p><?php _e('It looks like nothing was found at this location. Maybe try a search?', 'ayan-modern'); ?></p>
						
						<?php get_search_form(); ?>
					</section>
				<?php endif; ?>
			</div>
			
			<?php get_sidebar(); ?>
		</div>
	</div>
</main>

<?php get_footer(); ?>


