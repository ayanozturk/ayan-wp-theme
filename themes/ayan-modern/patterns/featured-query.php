<?php
/**
 * Title: Featured Query
 * Slug: ayan-modern/featured-query
 * Categories: featured, ayan-modern, query
 * Description: Full-bleed cover for the latest featured post.
 * Viewport Width: 1400
 *
 * @package Ayan_Modern
 */

?>
<!-- wp:query {"queryId":1,"query":{"perPage":1,"pages":0,"offset":0,"postType":"post","order":"desc","orderBy":"date","author":"","search":"","exclude":[],"sticky":"","inherit":false},"className":"is-featured-query featured-query","align":"full"} -->
<div class="wp-block-query alignfull is-featured-query featured-query">
	<!-- wp:post-template {"layout":{"type":"default"}} -->
		<!-- wp:cover {"useFeaturedImage":true,"dimRatio":40,"overlayColor":"ink","isUserOverlayColor":true,"minHeight":70,"minHeightUnit":"vh","contentPosition":"bottom left","align":"full","className":"featured-cover","style":{"spacing":{"padding":{"top":"var:preset|spacing|70","bottom":"var:preset|spacing|70","left":"var:preset|spacing|50","right":"var:preset|spacing|50"}}}} -->
		<div class="wp-block-cover alignfull featured-cover" style="padding-top:var(--wp--preset--spacing--70);padding-right:var(--wp--preset--spacing--50);padding-bottom:var(--wp--preset--spacing--70);padding-left:var(--wp--preset--spacing--50);min-height:70vh">
			<span aria-hidden="true" class="wp-block-cover__background has-ink-background-color has-background-dim-40 has-background-dim"></span>
			<div class="wp-block-cover__inner-container">
				<!-- wp:paragraph {"fontSize":"small","style":{"typography":{"textTransform":"uppercase","letterSpacing":"0.08em","fontWeight":"600"}},"textColor":"paper"} -->
				<p class="has-paper-color has-text-color has-small-font-size" style="font-weight:600;letter-spacing:0.08em;text-transform:uppercase">Featured</p>
				<!-- /wp:paragraph -->

				<!-- wp:post-title {"level":2,"isLink":true,"fontSize":"xx-large","fontFamily":"syne","textColor":"paper","style":{"spacing":{"margin":{"top":"var:preset|spacing|30","bottom":"var:preset|spacing|40"}}}} /-->

				<!-- wp:group {"layout":{"type":"flex","flexWrap":"wrap","verticalAlignment":"center"},"style":{"spacing":{"blockGap":"var:preset|spacing|40"}}} -->
				<div class="wp-block-group">
					<!-- wp:post-date {"fontSize":"small","textColor":"paper"} /-->

					<!-- wp:paragraph {"metadata":{"bindings":{"content":{"source":"ayan-modern/reading-time"}}},"className":"reading-time","fontSize":"small","textColor":"paper"} -->
					<p class="reading-time has-paper-color has-text-color has-small-font-size"></p>
					<!-- /wp:paragraph -->
				</div>
				<!-- /wp:group -->
			</div>
		</div>
		<!-- /wp:cover -->
	<!-- /wp:post-template -->

	<!-- wp:query-no-results -->
		<!-- wp:group {"align":"full","style":{"spacing":{"padding":{"top":"var:preset|spacing|70","bottom":"var:preset|spacing|70"}}},"backgroundColor":"ink","textColor":"paper","layout":{"type":"constrained"}} -->
		<div class="wp-block-group alignfull has-paper-color has-ink-background-color has-text-color has-background" style="padding-top:var(--wp--preset--spacing--70);padding-bottom:var(--wp--preset--spacing--70)">
			<!-- wp:heading {"level":2,"fontSize":"x-large","fontFamily":"syne"} -->
			<h2 class="wp-block-heading has-x-large-font-size">Latest writing</h2>
			<!-- /wp:heading -->

			<!-- wp:paragraph {"fontSize":"medium"} -->
			<p class="has-medium-font-size">Mark a post as featured in the editor to highlight it here.</p>
			<!-- /wp:paragraph -->
		</div>
		<!-- /wp:group -->
	<!-- /wp:query-no-results -->
</div>
<!-- /wp:query -->
