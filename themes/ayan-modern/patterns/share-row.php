<?php
/**
 * Title: Share Row
 * Slug: ayan-modern/share-row
 * Categories: ayan-modern
 * Description: Share links with clipboard copy for the current post.
 * Viewport Width: 1400
 *
 * @package Ayan_Modern
 */

?>
<!-- wp:group {"className":"share-row","style":{"spacing":{"padding":{"top":"var:preset|spacing|50","bottom":"var:preset|spacing|50"}},"border":{"top":{"color":"var:preset|color|line","width":"1px"},"bottom":{"color":"var:preset|color|line","width":"1px"}}},"layout":{"type":"flex","flexWrap":"wrap","justifyContent":"space-between","verticalAlignment":"center"}} -->
<div class="wp-block-group share-row" style="border-top-color:var(--wp--preset--color--line);border-top-width:1px;border-bottom-color:var(--wp--preset--color--line);border-bottom-width:1px;padding-top:var(--wp--preset--spacing--50);padding-bottom:var(--wp--preset--spacing--50)">
	<!-- wp:paragraph {"fontSize":"small","fontFamily":"syne","style":{"typography":{"textTransform":"uppercase","letterSpacing":"0.06em","fontWeight":"600"}}} -->
	<p class="has-small-font-size" style="font-weight:600;letter-spacing:0.06em;text-transform:uppercase">Share</p>
	<!-- /wp:paragraph -->

	<!-- wp:group {"className":"share-row__actions","layout":{"type":"flex","flexWrap":"wrap","verticalAlignment":"center"},"style":{"spacing":{"blockGap":"var:preset|spacing|40"}}} -->
	<div class="wp-block-group share-row__actions">
		<!-- wp:paragraph {"className":"share-link share-link--x","fontSize":"small"} -->
		<p class="share-link share-link--x has-small-font-size"><a href="#" data-share="x" rel="noopener noreferrer">X</a></p>
		<!-- /wp:paragraph -->

		<!-- wp:paragraph {"className":"share-link share-link--linkedin","fontSize":"small"} -->
		<p class="share-link share-link--linkedin has-small-font-size"><a href="#" data-share="linkedin" rel="noopener noreferrer">LinkedIn</a></p>
		<!-- /wp:paragraph -->

		<!-- wp:paragraph {"className":"share-link share-link--copy","fontSize":"small"} -->
		<p class="share-link share-link--copy has-small-font-size"><button type="button" class="share-copy" data-share="copy">Copy link</button></p>
		<!-- /wp:paragraph -->
	</div>
	<!-- /wp:group -->
</div>
<!-- /wp:group -->
