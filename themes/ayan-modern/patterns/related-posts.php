<?php
/**
 * Title: Related Posts
 * Slug: ayan-modern/related-posts
 * Categories: query, ayan-modern
 * Description: Three related posts from the same category.
 * Viewport Width: 1400
 *
 * @package Ayan_Modern
 */

?>
<!-- wp:group {"className":"related-posts","layout":{"type":"constrained"}} -->
<div class="wp-block-group related-posts">
	<!-- wp:heading {"level":2,"fontSize":"large","fontFamily":"syne","style":{"spacing":{"margin":{"bottom":"var:preset|spacing|50"}}}} -->
	<h2 class="wp-block-heading has-large-font-size" style="margin-bottom:var(--wp--preset--spacing--50)">Related reading</h2>
	<!-- /wp:heading -->

	<!-- wp:query {"query":{"perPage":3,"pages":0,"offset":0,"postType":"post","order":"desc","orderBy":"date","author":"","search":"","exclude":[],"excludeCurrent":true,"sticky":"","inherit":false},"className":"is-related-query related-posts-query"} -->
	<div class="wp-block-query is-related-query related-posts-query">
		<!-- wp:post-template {"className":"related-posts-list","layout":{"type":"default"}} -->
			<!-- wp:group {"className":"related-post-row post-row","layout":{"type":"flex","flexWrap":"nowrap","verticalAlignment":"stretch"},"style":{"spacing":{"blockGap":"0","margin":{"bottom":"0"}},"border":{"bottom":{"color":"var:preset|color|line","width":"1px"}}}} -->
			<div class="wp-block-group related-post-row post-row" style="border-bottom-color:var(--wp--preset--color--line);border-bottom-width:1px;margin-bottom:0">
				<!-- wp:post-featured-image {"isLink":true,"aspectRatio":"1","width":"28%","className":"post-row__image","style":{"spacing":{"margin":{"bottom":"0"}}}} /-->

				<!-- wp:group {"className":"post-row__body","style":{"spacing":{"padding":{"top":"var:preset|spacing|40","bottom":"var:preset|spacing|40","left":"var:preset|spacing|50","right":"var:preset|spacing|40"}}},"layout":{"type":"constrained","justifyContent":"left"}} -->
				<div class="wp-block-group post-row__body" style="padding-top:var(--wp--preset--spacing--40);padding-right:var(--wp--preset--spacing--40);padding-bottom:var(--wp--preset--spacing--40);padding-left:var(--wp--preset--spacing--50)">
					<!-- wp:post-date {"fontSize":"small","textColor":"mute","style":{"spacing":{"margin":{"bottom":"var:preset|spacing|20"}}}} /-->

					<!-- wp:post-title {"level":4,"isLink":true,"fontSize":"large","fontFamily":"syne"} /-->
				</div>
				<!-- /wp:group -->
			</div>
			<!-- /wp:group -->
		<!-- /wp:post-template -->

		<!-- wp:query-no-results -->
			<!-- wp:paragraph {"fontSize":"small","textColor":"mute"} -->
			<p class="has-mute-color has-text-color has-small-font-size">No related posts yet.</p>
			<!-- /wp:paragraph -->
		<!-- /wp:query-no-results -->
	</div>
	<!-- /wp:query -->
</div>
<!-- /wp:group -->
