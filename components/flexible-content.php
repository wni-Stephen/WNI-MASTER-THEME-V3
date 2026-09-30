<?php
/**
 * Flexible Content Renderer.
 *
 * Renders ACF Page Content layouts from individual
 * component files inside /components/layouts/.
 */

defined('ABSPATH') || exit;

if (!function_exists('have_rows')) {
	return;
}

if (!have_rows('page_content')) {
	return;
}

while (have_rows('page_content')) {

	the_row();

	$layout_name = get_row_layout();

	if (!$layout_name) {
		continue;
	}

	/**
	 * Get shared layout settings.
	 *
	 * Supports:
	 * - ACF Extended Settings Modal
	 * - Standard layout_options Clone field
	 * - No settings at all
	 */
	$layout_options = websiteni_joints_get_layout_settings();

	$layout = websiteni_joints_get_layout_options(
		$layout_options
	);

	/**
	 * Sanitise the ACF layout name before
	 * using it as a template path.
	 */
	$layout_name = sanitize_file_name(
		$layout_name
	);

	$template = get_template_directory()
		. '/components/layouts/'
		. $layout_name
		. '.php';

	if (file_exists($template)) {
		include $template;
	}
}