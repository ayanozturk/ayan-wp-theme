<?php
/**
 * Title: Post Row
 * Slug: ayan-modern/post-row
 * Categories: query, ayan-modern
 * Description: Image-led horizontal post rows for archives and home.
 * Viewport Width: 1400
 *
 * @package Ayan_Modern
 */

?>
<!-- wp:query {"query":{"perPage":10,"pages":0,"offset":0,"postType":"post","order":"desc","orderBy":"date","author":"","search":"","exclude":[],"sticky":"","inherit":true},"className":"post-row-query is-home-latest-query","align":"wide"} -->
<div class="wp-block-query alignwide post-row-query is-home-latest-query">
	<!-- wp:post-template {"className":"post-row-list","layout":{"type":"default"}} -->
		<!-- wp:group {"className":"post-row","layout":{"type":"flex","flexWrap":"nowrap","verticalAlignment":"stretch"},"style":{"spacing":{"blockGap":"0","margin":{"bottom":"0"}},"border":{"bottom":{"color":"var:preset|color|line","width":"1px"}}}} -->
		<div class="wp-block-group post-row" style="border-bottom-color:var(--wp--preset--color--line);border-bottom-width:1px;margin-bottom:0">
			<!-- wp:post-featured-image {"isLink":true,"aspectRatio":"4/3","width":"38%","className":"post-row__image","style":{"spacing":{"margin":{"bottom":"0"}}}} /-->

			<!-- wp:group {"className":"post-row__body","style":{"spacing":{"padding":{"top":"var:preset|spacing|50","bottom":"var:preset|spacing|50","left":"var:preset|spacing|60","right":"var:preset|spacing|50"}}},"layout":{"type":"constrained","justifyContent":"left"}} -->
			<div class="wp-block-group post-row__body" style="padding-top:var(--wp--preset--spacing--50);padding-right:var(--wp--preset--spacing--50);padding-bottom:var(--wp--preset--spacing--50);padding-left:var(--wp--preset--spacing--60)">
				<!-- wp:group {"className":"post-meta-row","layout":{"type":"flex","flexWrap":"wrap","verticalAlignment":"center"},"style":{"spacing":{"blockGap":"var:preset|spacing|30","margin":{"bottom":"var:preset|spacing|30"}}}} -->
				<div class="wp-block-group post-meta-row" style="margin-bottom:var(--wp--preset--spacing--30)">
					<!-- wp:post-date {"fontSize":"small","textColor":"mute"} /-->

					<!-- wp:paragraph {"metadata":{"bindings":{"content":{"source":"ayan-modern/reading-time"}}},"className":"reading-time","fontSize":"small","textColor":"mute"} -->
					<p class="reading-time has-mute-color has-text-color has-small-font-size"></p>
					<!-- /wp:paragraph -->
				</div>
				<!-- /wp:group -->

				<!-- wp:post-title {"level":3,"isLink":true,"fontSize":"x-large","fontFamily":"syne","style":{"spacing":{"margin":{"bottom":"var:preset|spacing|30"}}}} /-->

				<!-- wp:post-excerpt {"moreText":"Read →","excerptLength":28,"fontSize":"medium","textColor":"mute"} /-->
			</div>
			<!-- /wp:group -->
		</div>
		<!-- /wp:group -->
	<!-- /wp:post-template -->

	<!-- wp:query-pagination {"layout":{"type":"flex","justifyContent":"space-between"},"fontSize":"small","style":{"spacing":{"margin":{"top":"var:preset|spacing|60"}}}} -->
		<!-- wp:query-pagination-previous /-->

		<!-- wp:query-pagination-numbers /-->

		<!-- wp:query-pagination-next /-->
	<!-- /wp:query-pagination -->

	<!-- wp:query-no-results -->
		<!-- wp:paragraph {"fontSize":"medium","textColor":"mute"} -->
		<p class="has-mute-color has-text-color has-medium-font-size">No posts found.</p>
		<!-- /wp:paragraph -->
	<!-- /wp:query-no-results -->
</div>
<!-- /wp:query -->
