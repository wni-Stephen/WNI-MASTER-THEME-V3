<?php
/**
 * Theme plugin configuration.
 *
 * Registers recommended plugins for WebsiteNI projects.
 */

defined('ABSPATH') || exit;


/**
 * TGM Plugin Activation.
 */
require_once get_template_directory()
	. '/modules/class-tgm-plugin-activation.php';


/**
 * Register recommended WebsiteNI plugins.
 */
function websiteni_joints_register_plugins() {

	$plugins = array(

		/**
		 * Formidable Forms.
		 */
		array(
			'name'     => 'Formidable Forms',
			'slug'     => 'formidable',
			'required' => false,
		),

		/**
		 * Yoast SEO.
		 */
		array(
			'name'     => 'Yoast SEO',
			'slug'     => 'wordpress-seo',
			'required' => false,
		),

		/**
		 * Custom Post Type UI.
		 */
		array(
			'name'     => 'Custom Post Type UI',
			'slug'     => 'custom-post-type-ui',
			'required' => false,
		),

		/**
		 * LiteSpeed Cache.
		 */
		array(
			'name'     => 'LiteSpeed Cache',
			'slug'     => 'litespeed-cache',
			'required' => false,
		),

		/**
		 * Safe SVG.
		 *
		 * Provides sanitised SVG upload support.
		 */
		array(
			'name'     => 'Safe SVG',
			'slug'     => 'safe-svg',
			'required' => false,
		),

	);

	$config = array(
		'id'           => 'websiteni-plugins',
		'default_path' => '',
		'menu'         => 'tgmpa-install-plugins',
		'parent_slug'  => 'themes.php',
		'capability'   => 'edit_theme_options',
		'has_notices'  => true,
		'dismissable'  => true,
		'is_automatic' => false,
	);

	tgmpa(
		$plugins,
		$config
	);
}

add_action(
	'tgmpa_register',
	'websiteni_joints_register_plugins'
);