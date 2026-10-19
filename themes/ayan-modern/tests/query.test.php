<?php
/** Standalone query regressions: php tests/query.test.php */

if ( 'cli' !== PHP_SAPI ) {
	exit;
}

define( 'ABSPATH', __DIR__ );
$home = true;
$admin = false;
$categories = array( 8 );
$tags = array();

function add_filter( ...$args ) {}
function add_action( ...$args ) {}
function absint( $value ) { return abs( (int) $value ); }
function is_home() { return $GLOBALS['home']; }
function is_front_page() { return false; }
function is_admin() { return $GLOBALS['admin']; }
function get_posts( $args ) { return array( 42 ); }
function get_queried_object_id() { return 17; }
function wp_get_post_categories( $id ) { return $GLOBALS['categories']; }
function wp_get_post_tags( $id, $args ) { return $GLOBALS['tags']; }

require dirname( __DIR__ ) . '/inc/query.php';

function check( $actual, $expected, $message ) {
	if ( $actual !== $expected ) {
		throw new RuntimeException( $message . "\nExpected: " . var_export( $expected, true ) . "\nActual: " . var_export( $actual, true ) );
	}
	echo "PASS: $message\n";
}

function query_block( $class_name ) {
	return (object) array(
		'context' => array( 'ayan-modern/query-class-name' => $class_name, 'postId' => 17 ),
		'attributes' => array( 'className' => 'child-layout-class' ),
	);
}

class Theme_Test_Query {
	public $vars = array( 'post__not_in' => array( 5 ) );
	public $main = true;
	public $home = true;
	public $archive = false;
	public $feed = false;
	public function is_main_query() { return $this->main; }
	public function is_home() { return $this->home; }
	public function is_archive() { return $this->archive; }
	public function is_feed() { return $this->feed; }
	public function get( $key ) { return $this->vars[ $key ] ?? null; }
	public function set( $key, $value ) { $this->vars[ $key ] = $value; }
}

$args = ayan_modern_query_block_context(
	array( 'provides_context' => array( 'query' => 'query' ), 'attributes' => array( 'className' => array( 'type' => 'string' ) ) ),
	'core/query'
);
check( $args['provides_context']['query'], 'query', 'preserves core query context' );
check( $args['provides_context']['ayan-modern/query-class-name'], 'className', 'exposes parent Query classes' );
check( $args['attributes']['className']['default'], '', 'unmarked nested queries reset the marker' );
foreach ( array( 'core/post-template', 'core/query-pagination-numbers', 'core/query-no-results' ) as $name ) {
	$args = ayan_modern_query_block_context( array( 'uses_context' => array( 'query', 'queryId' ) ), $name );
	check( $args['uses_context'], array( 'query', 'queryId', 'ayan-modern/query-class-name' ), "$name consumes the marker" );
}
check( ayan_modern_query_block_context( array(), 'core/paragraph' ), array(), 'unrelated blocks are untouched' );

$base = array( 'post__not_in' => array( 5 ), 'posts_per_page' => 10, 'offset' => 0 );
$featured = ayan_modern_query_loop_block_query_vars( $base, query_block( 'layout is-featured-query' ), 1 );
check( $featured['post__in'], array( 42 ), 'featured child receives the selected featured post' );
check( $featured['posts_per_page'], 1, 'featured section contains one post' );
$child_marker = query_block( '' );
$child_marker->attributes['className'] = 'is-featured-query';
check( ayan_modern_query_loop_block_query_vars( $base, $child_marker, 1 )['post__in'], array( 42 ), 'existing child-level query markers remain supported' );
$latest = ayan_modern_query_loop_block_query_vars( $base, query_block( 'is-home-latest-query' ), 1 );
check( $latest['post__not_in'], array( 5, 42 ), 'latest posts preserve exclusions and omit the feature' );
check( ayan_modern_query_loop_block_query_vars( $base, query_block( 'not-is-featured-query' ), 1 ), $base, 'marker matching uses complete class names' );
check( ayan_modern_query_loop_block_query_vars( $base, query_block( '' ), 1 ), $base, 'unmarked loops retain their own query' );

$related = ayan_modern_query_loop_block_query_vars( $base, query_block( 'is-related-query' ), 1 );
check( $related['category__in'], array( 8 ), 'related reading uses source categories' );
check( $related['post__not_in'], array( 5, 17 ), 'related reading excludes the source and existing exclusions' );
check( $related['posts_per_page'], 3, 'related reading contains up to three posts' );
$categories = array();
$tags = array( '9' );
$related = ayan_modern_query_loop_block_query_vars( $base, query_block( 'is-related-query' ), 1 );
check( $related['tag__in'], array( 9 ), 'related reading falls back to tags' );
$tags = array();
$related = ayan_modern_query_loop_block_query_vars( $base, query_block( 'is-related-query' ), 1 );
check( $related['post__in'], array( 0 ), 'unrelated posts are hidden when no taxonomy matches' );

$home = false;
$query = new Theme_Test_Query();
ayan_modern_pre_get_posts( $query );
check( $query->vars['post__not_in'], array( 5, 42 ), 'homepage uses the supplied query flags' );
check( $query->vars['posts_per_page'], 10, 'homepage retains its page size' );
foreach ( array( 'feed', 'secondary', 'admin' ) as $mode ) {
	$query = new Theme_Test_Query();
	$query->feed = 'feed' === $mode;
	$query->main = 'secondary' !== $mode;
	$admin = 'admin' === $mode;
	$before = $query->vars;
	ayan_modern_pre_get_posts( $query );
	check( $query->vars, $before, "$mode queries retain their original posts and settings" );
}
$admin = false;
$query = new Theme_Test_Query();
$query->home = false;
$query->archive = true;
ayan_modern_pre_get_posts( $query );
check( $query->vars['posts_per_page'], 10, 'archives retain the theme page size' );
echo "Query regressions passed.\n";
