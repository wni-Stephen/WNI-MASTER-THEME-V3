<?php
/**
 * Advanced Custom Fields configuration.
 */

defined('ABSPATH') || exit;


/**
 * Register ACF Options pages.
 */
function websiteni_joints_register_acf_options_pages() {

	if (!function_exists('acf_add_options_page')) {
		return;
	}


	/**
	 * Global Settings parent menu.
	 */
	acf_add_options_page(
		array(
			'page_title' => 'Global Settings',
			'menu_title' => 'Global Settings',
			'menu_slug'  => 'global-settings',
			'redirect'   => true,
		)
	);


	/**
	 * General Settings.
	 */
	acf_add_options_sub_page(
		array(
			'page_title'  => 'General Settings',
			'menu_title'  => 'General Settings',
			'menu_slug'   => 'general-settings',
			'parent_slug' => 'global-settings',
		)
	);


	/**
	 * Footer Settings.
	 */
	acf_add_options_sub_page(
		array(
			'page_title'  => 'Footer Settings',
			'menu_title'  => 'Footer Settings',
			'menu_slug'   => 'footer-settings',
			'parent_slug' => 'global-settings',
		)
	);
}

add_action(
	'acf/init',
	'websiteni_joints_register_acf_options_pages'
);


/**
 * Save ACF Local JSON field groups
 * to the starter theme.
 *
 * @param string $path Default save path.
 *
 * @return string
 */
function websiteni_joints_acf_json_save_point(
	$path
) {

	return get_template_directory()
		. '/acf-json';
}

add_filter(
	'acf/settings/save_json',
	'websiteni_joints_acf_json_save_point'
);


/**
 * Load ACF Local JSON field groups
 * from the starter theme.
 *
 * @param array $paths Existing ACF JSON paths.
 *
 * @return array
 */
function websiteni_joints_acf_json_load_point(
	$paths
) {

	$theme_path = get_template_directory()
		. '/acf-json';

	if (!in_array(
		$theme_path,
		$paths,
		true
	)) {
		$paths[] = $theme_path;
	}

	return $paths;
}

add_filter(
	'acf/settings/load_json',
	'websiteni_joints_acf_json_load_point'
);