<?php
/**
 * WordPress security and front-end cleanup.
 */

defined('ABSPATH') || exit;


/**
 * Disable XML-RPC.
 *
 * This reduces an unnecessary attack surface for WebsiteNI sites
 * that do not use remote publishing or XML-RPC integrations.
 */
add_filter(
	'xmlrpc_enabled',
	'__return_false'
);


/**
 * Hide the WordPress version generator.
 */
function websiteni_joints_hide_wordpress_version() {

	return '';
}

add_filter(
	'the_generator',
	'websiteni_joints_hide_wordpress_version'
);


/**
 * Obscure WordPress login errors.
 *
 * Avoid revealing whether a username or email address exists.
 */
function websiteni_joints_obscure_login_errors() {

	return 'Something wasn\'t quite right there, please try again.';
}

add_filter(
	'login_errors',
	'websiteni_joints_obscure_login_errors'
);


/**
 * Disable WordPress emoji assets.
 *
 * Modern browsers support emoji natively, so the additional
 * WordPress emoji scripts and styles are unnecessary.
 */
function websiteni_joints_disable_emoji_assets() {

	remove_action(
		'wp_head',
		'print_emoji_detection_script',
		7
	);

	remove_action(
		'admin_print_scripts',
		'print_emoji_detection_script'
	);

	remove_action(
		'wp_print_styles',
		'print_emoji_styles'
	);

	remove_action(
		'admin_print_styles',
		'print_emoji_styles'
	);

	remove_filter(
		'wp_mail',
		'wp_staticize_emoji_for_email'
	);

	remove_filter(
		'the_content_feed',
		'wp_staticize_emoji'
	);

	remove_filter(
		'comment_text_rss',
		'wp_staticize_emoji'
	);

	add_filter(
		'emoji_svg_url',
		'__return_false'
	);
}

add_action(
	'init',
	'websiteni_joints_disable_emoji_assets'
);