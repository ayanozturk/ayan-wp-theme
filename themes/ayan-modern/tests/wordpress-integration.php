<?php
/** Run with WP-CLI after installing WordPress and activating Ayan Modern. */

function theme_integration_assert( $condition, $message ) {
	if ( ! $condition ) {
		WP_CLI::error( $message );
	}
	WP_CLI::log( 'PASS: ' . $message );
}

theme_integration_assert( PHP_VERSION_ID >= 80400, 'PHP 8.4 or newer is running.' );
theme_integration_assert( 'ayan-modern' === get_stylesheet(), 'Ayan Modern is active.' );

$category = wp_insert_term( 'Integration topic', 'category' );
theme_integration_assert( ! is_wp_error( $category ), 'Fixture category was created.' );
$category_id = (int) $category['term_id'];

$source_id = wp_insert_post( array( 'post_title' => 'Integration source article', 'post_content' => 'Integration article body', 'post_status' => 'publish', 'post_type' => 'post', 'post_category' => array( $category_id ) ), true );
$related_id = wp_insert_post( array( 'post_title' => 'Integration related article', 'post_content' => 'Related body', 'post_status' => 'publish', 'post_type' => 'post', 'post_category' => array( $category_id ) ), true );
$featured_id = wp_insert_post( array( 'post_title' => 'Integration featured article', 'post_content' => 'Featured body', 'post_status' => 'publish', 'post_type' => 'post' ), true );
foreach ( array( $source_id, $related_id, $featured_id ) as $id ) {
	theme_integration_assert( ! is_wp_error( $id ) && $id > 0, 'Fixture post was created.' );
}
update_post_meta( $featured_id, '_featured_post', '1' );

$featured = do_blocks( '<!-- wp:pattern {"slug":"ayan-modern/featured-query"} /-->' );
theme_integration_assert( str_contains( $featured, 'Integration featured article' ), 'Featured Query renders the marked post.' );
theme_integration_assert( ! str_contains( $featured, 'Integration source article' ), 'Featured Query excludes other posts.' );

global $wp_query, $wp_the_query, $post;
$wp_query = new WP_Query();
$wp_the_query = $wp_query;
$wp_query->query( array() );
$latest = do_blocks( '<!-- wp:pattern {"slug":"ayan-modern/post-row"} /-->' );
theme_integration_assert( str_contains( $latest, 'Integration source article' ), 'The home query renders other published posts.' );
theme_integration_assert( ! str_contains( $latest, 'Integration featured article' ), 'The home query excludes the featured post.' );

$description = '</script><script>example</script> & "quoted"';
$description_filter = static fn() => $description;
add_filter( 'pre_option_blogdescription', $description_filter );
ob_start();
ayan_modern_schema_markup();
$schema_html = ob_get_clean();
remove_filter( 'pre_option_blogdescription', $description_filter );
theme_integration_assert( 1 === preg_match( '~<script type="application/ld\+json">(.*?)</script>~s', $schema_html, $schema_match ), 'Website schema is rendered.' );
$website_schema = json_decode( $schema_match[1], true );
theme_integration_assert( $description === $website_schema['description'], 'Website schema preserves special characters.' );
theme_integration_assert( ! str_contains( $schema_match[1], '</script>' ), 'Website schema safely encodes closing script tags.' );

$wp_query = new WP_Query( array( 'p' => $source_id ) );
$post = $wp_query->post;
setup_postdata( $post );

$related = do_blocks( '<!-- wp:pattern {"slug":"ayan-modern/related-posts"} /-->' );
theme_integration_assert( str_contains( $related, 'Integration related article' ), 'Related Query renders a post from the same category.' );
theme_integration_assert( ! str_contains( $related, 'Integration source article' ), 'Related Query excludes the current post.' );
theme_integration_assert( ! str_contains( $related, 'Integration featured article' ), 'Related Query excludes unrelated categories.' );

$share = do_blocks( '<!-- wp:pattern {"slug":"ayan-modern/share-row"} /-->' );
theme_integration_assert( str_contains( $share, 'twitter.com/intent/tweet?' ) && str_contains( $share, 'linkedin.com/sharing/share-offsite/?' ), 'Share links have server-rendered destinations.' );
theme_integration_assert( ! str_contains( $share, 'href="#"' ), 'Share links do not require JavaScript to obtain a destination.' );
$share_tags = new WP_HTML_Tag_Processor( $share );
$share_services = array();
while ( $share_tags->next_tag( 'a' ) ) {
	$service = $share_tags->get_attribute( 'data-share' );
	if ( in_array( $service, array( 'x', 'linkedin' ), true ) ) {
		parse_str( (string) wp_parse_url( $share_tags->get_attribute( 'href' ), PHP_URL_QUERY ), $share_args );
		theme_integration_assert( get_permalink( $source_id ) === ( $share_args['url'] ?? null ), 'The ' . $service . ' share URL contains the complete post permalink.' );
		$share_services[] = $service;
	}
}
theme_integration_assert( 2 === count( $share_services ), 'Both social share links were inspected.' );

$template = get_block_template( get_stylesheet() . '//single', 'wp_template' );
theme_integration_assert( $template && ! empty( $template->content ), 'The single-post block template is available.' );
$rendered = do_blocks( $template->content );
theme_integration_assert( str_contains( $rendered, 'Integration article body' ), 'The single-post template renders post content.' );
theme_integration_assert( str_contains( $rendered, 'Integration related article' ), 'The single-post template renders related content.' );

$tag = wp_insert_term( 'Integration tag', 'post_tag' );
theme_integration_assert( ! is_wp_error( $tag ), 'Fixture tag was created.' );
wp_set_object_terms( $source_id, array(), 'category' );
wp_set_object_terms( $source_id, array( (int) $tag['term_id'] ), 'post_tag' );
wp_set_object_terms( $related_id, array( (int) $tag['term_id'] ), 'post_tag' );
$related = do_blocks( '<!-- wp:pattern {"slug":"ayan-modern/related-posts"} /-->' );
theme_integration_assert( str_contains( $related, 'Integration related article' ), 'Related Query falls back to shared tags when categories are absent.' );
wp_set_object_terms( $source_id, array(), 'post_tag' );
$related = do_blocks( '<!-- wp:pattern {"slug":"ayan-modern/related-posts"} /-->' );
theme_integration_assert( ! str_contains( $related, 'Integration related article' ), 'Related Query omits unrelated posts when no terms are present.' );

wp_set_current_user( 1 );
$request = new WP_REST_Request( 'POST', '/wp/v2/posts/' . $source_id );
$request->set_body_params( array( 'meta' => array( '_featured_post' => '0', '_reading_time' => 7 ) ) );
$response = rest_do_request( $request );
theme_integration_assert( 200 === $response->get_status(), 'The editor can update registered post meta through REST.' );
theme_integration_assert( 7 === (int) get_post_meta( $source_id, '_reading_time', true ), 'The reading-time override is saved.' );
theme_integration_assert( str_contains( ayan_modern_format_reading_time( $source_id ), '7' ), 'The saved reading-time override is displayed.' );
$rendered = do_blocks( $template->content );
theme_integration_assert( str_contains( $rendered, '7 mins read' ), 'The reading-time binding renders the saved override in the template.' );
do_action( 'enqueue_block_editor_assets' );
theme_integration_assert( wp_script_is( 'ayan-modern-editor', 'enqueued' ), 'The post options editor script is enqueued.' );

wp_set_current_user( 0 );
$request = new WP_REST_Request( 'POST', '/wp/v2/posts/' . $source_id );
$request->set_body_params( array( 'meta' => array( '_reading_time' => 42 ) ) );
$response = rest_do_request( $request );
theme_integration_assert( in_array( $response->get_status(), array( 401, 403 ), true ), 'Anonymous users cannot update post meta.' );
theme_integration_assert( 7 === (int) get_post_meta( $source_id, '_reading_time', true ), 'A rejected request leaves post meta unchanged.' );

wp_reset_postdata();
WP_CLI::success( 'WordPress integration checks passed on WordPress ' . get_bloginfo( 'version' ) . '.' );
