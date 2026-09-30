<?php
/**
 * Theme setup.
 *
 * Registers WordPress theme support and navigation menus.
 */

defined('ABSPATH') || exit;


/**
 * Configure theme features.
 */
function websiteni_joints_theme_setup() {

	/**
	 * Load theme translations.
	 */
	load_theme_textdomain(
		'websiteni-foundation',
		get_template_directory() . '/languages'
	);


	/**
	 * Let WordPress manage the document title.
	 */
	add_theme_support(
		'title-tag'
	);


	/**
	 * Enable featured images.
	 */
	add_theme_support(
		'post-thumbnails'
	);


	/**
	 * Add RSS feed links to the document head.
	 */
	add_theme_support(
		'automatic-feed-links'
	);


	/**
	 * Use modern HTML5 markup.
	 */
	add_theme_support(
		'html5',
		array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
			'style',
			'script',
		)
	);


	/**
	 * Improve responsive embedded media.
	 */
	add_theme_support(
		'responsive-embeds'
	);


	/**
	 * Enable WordPress custom logo support.
	 */
	add_theme_support(
		'custom-logo',
		array(
			'height'               => 120,
			'width'                => 400,
			'flex-height'          => true,
			'flex-width'           => true,
			'unlink-homepage-logo' => false,
		)
	);


	/**
	 * WooCommerce support.
	 */
	add_theme_support(
		'woocommerce'
	);


	/**
	 * WooCommerce product gallery features.
	 */
	add_theme_support(
		'wc-product-gallery-zoom'
	);

	add_theme_support(
		'wc-product-gallery-lightbox'
	);

	add_theme_support(
		'wc-product-gallery-slider'
	);


	/**
	 * Register navigation menu locations.
	 */
	register_nav_menus(
		array(
			'primary-navigation' => __(
				'Primary Navigation',
				'websiteni-foundation'
			),

			'secondary-navigation' => __(
				'Secondary Navigation',
				'websiteni-foundation'
			),
		)
	);
}

add_action(
	'after_setup_theme',
	'websiteni_joints_theme_setup'
);