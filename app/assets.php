<?php
/**
 * WebsiteNI Starter Theme
 * Front-end asset loading.
 */

defined('ABSPATH') || exit;


/**
 * Website font configuration.
 *
 * This should be the main place fonts are changed
 * when starting a new WebsiteNI project.
 *
 * To use different body and heading fonts:
 *
 * - update the Google Fonts URL
 * - update body_stack
 * - update heading_stack
 *
 * To disable Google Fonts completely:
 *
 * 'google_fonts_enabled' => false,
 */
function websiteni_get_font_config() {
	return [
		'google_fonts_enabled' => true,

		'google_fonts_url' => (
			'https://fonts.googleapis.com/css2'
			. '?family=Open+Sans:wght@400;500;600;700'
			. '&display=swap'
		),

		'body_stack' => (
			'"Open Sans", Arial, sans-serif'
		),

		'heading_stack' => (
			'"Open Sans", Arial, sans-serif'
		),
	];
}


/**
 * Enqueue theme assets.
 */
function websiteni_enqueue_assets() {
	$theme_dir = get_template_directory();
	$theme_uri = get_template_directory_uri();

	$style_path = (
		$theme_dir
		. '/assets/dist/style.css'
	);

	$script_path = (
		$theme_dir
		. '/assets/dist/script.js'
	);

	$style_uri = (
		$theme_uri
		. '/assets/dist/style.css'
	);

	$script_uri = (
		$theme_uri
		. '/assets/dist/script.js'
	);

	$theme_version = wp_get_theme()->get(
		'Version'
	);

	$style_version = file_exists(
		$style_path
	)
		? filemtime($style_path)
		: $theme_version;

	$script_version = file_exists(
		$script_path
	)
		? filemtime($script_path)
		: $theme_version;

	$font_config = websiteni_get_font_config();

	$style_dependencies = [];

	/**
	 * Google Fonts.
	 */
	if (
		!empty(
			$font_config[
				'google_fonts_enabled'
			]
		)
		&& !empty(
			$font_config[
				'google_fonts_url'
			]
		)
	) {
		wp_enqueue_style(
			'wni-google-fonts',
			$font_config[
				'google_fonts_url'
			],
			[],
			null
		);

		$style_dependencies[] = (
			'wni-google-fonts'
		);
	}

	/**
	 * Main stylesheet.
	 */
	wp_enqueue_style(
		'wni-main',
		$style_uri,
		$style_dependencies,
		$style_version
	);

	/**
	 * Font CSS variables.
	 *
	 * Foundation and custom SCSS use these variables
	 * rather than hardcoded font-family values.
	 */
	$font_css = sprintf(
		':root {
			--font-body: %s;
			--font-heading: %s;
		}',
		$font_config['body_stack'],
		$font_config['heading_stack']
	);

	wp_add_inline_style(
		'wni-main',
		$font_css
	);

	/**
	 * Main JavaScript.
	 *
	 * jQuery is provided by WordPress.
	 */
	wp_enqueue_script(
		'wni-main',
		$script_uri,
		[
			'jquery',
		],
		$script_version,
		true
	);
}

add_action(
	'wp_enqueue_scripts',
	'websiteni_enqueue_assets'
);


/**
 * Add Google Fonts preconnect hints.
 *
 * @param array  $urls          Existing resource hints.
 * @param string $relation_type Resource relationship.
 * @return array
 */
function websiteni_font_resource_hints(
	$urls,
	$relation_type
) {
	if ('preconnect' !== $relation_type) {
		return $urls;
	}

	$font_config = websiteni_get_font_config();

	if (
		empty(
			$font_config[
				'google_fonts_enabled'
			]
		)
	) {
		return $urls;
	}

	$urls[] = (
		'https://fonts.googleapis.com'
	);

	$urls[] = [
		'href' => (
			'https://fonts.gstatic.com'
		),
		'crossorigin' => 'anonymous',
	];

	return $urls;
}

add_filter(
	'wp_resource_hints',
	'websiteni_font_resource_hints',
	10,
	2
);