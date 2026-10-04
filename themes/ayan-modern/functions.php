<?php
/**
 * Ayan Modern Theme Functions
 *
 * Slim bootstrap: setup, enqueue, meta, bindings, query, schema, login, patterns.
 *
 * @package Ayan_Modern
 * @author Ayan Ozturk
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$ayan_modern_includes = array(
	'setup.php',
	'enqueue.php',
	'meta.php',
	'bindings.php',
	'query.php',
	'schema.php',
	'login.php',
	'patterns.php',
	'share.php',
	'project-images.php',
);

foreach ( $ayan_modern_includes as $ayan_modern_file ) {
	require_once get_template_directory() . '/inc/' . $ayan_modern_file;
}
