<?php
/**
 * WebsiteNI Starter Theme
 * Media configuration and image helpers.
 *
 * SVG uploads are intentionally not enabled directly by the theme.
 *
 * WebsiteNI projects should use a dedicated SVG sanitization plugin
 * so uploaded SVG files are cleaned before being stored or rendered.
 */

defined('ABSPATH') || exit;


/**
 * Register reusable WebsiteNI image sizes.
 */
function websiteni_register_image_sizes() {
	/**
	 * Standard content/card image.
	 * Ratio: 4:3
	 */
	add_image_size(
		'wni-card',
		800,
		600,
		true
	);

	/**
	 * Square image.
	 * Ratio: 1:1
	 */
	add_image_size(
		'wni-square',
		800,
		800,
		true
	);

	/**
	 * Wide landscape image.
	 * Ratio: 16:9
	 */
	add_image_size(
		'wni-landscape',
		1200,
		675,
		true
	);
}

add_action(
	'after_setup_theme',
	'websiteni_register_image_sizes'
);


/**
 * Make custom image sizes available in the
 * WordPress image size selector.
 *
 * @param array $sizes Existing image sizes.
 * @return array
 */
function websiteni_add_image_size_names($sizes) {
	return array_merge(
		$sizes,
		[
			'wni-card' => __(
				'WebsiteNI Card (4:3)',
				'websiteni-foundation'
			),

			'wni-square' => __(
				'WebsiteNI Square (1:1)',
				'websiteni-foundation'
			),

			'wni-landscape' => __(
				'WebsiteNI Landscape (16:9)',
				'websiteni-foundation'
			),
		]
	);
}

add_filter(
	'image_size_names_choose',
	'websiteni_add_image_size_names'
);


/**
 * Get an attachment ID from either:
 *
 * - WordPress attachment ID
 * - ACF image array
 *
 * @param int|array|null $image Image value.
 * @return int
 */
function websiteni_get_image_id($image) {
	if (is_numeric($image)) {
		return (int) $image;
	}

	if (is_array($image)) {
		if (!empty($image['ID'])) {
			return (int) $image['ID'];
		}

		if (!empty($image['id'])) {
			return (int) $image['id'];
		}
	}

	return 0;
}


/**
 * Return responsive image markup.
 *
 * Uses wp_get_attachment_image() so WordPress automatically
 * handles:
 *
 * - srcset
 * - sizes
 * - width
 * - height
 * - alt text
 * - loading behaviour
 * - decoding behaviour
 *
 * Works with either an attachment ID or an ACF image array.
 *
 * Example:
 *
 * echo websiteni_get_image(
 *     get_field('image'),
 *     'wni-card',
 *     [
 *         'class' => 'news-card__image',
 *     ]
 * );
 *
 * @param int|array|null $image      Attachment ID or ACF image array.
 * @param string|array   $size       Registered image size.
 * @param array          $attributes Additional HTML attributes.
 * @return string
 */
function websiteni_get_image(
	$image,
	$size = 'full',
	$attributes = []
) {
	$image_id = websiteni_get_image_id(
		$image
	);

	if (!$image_id) {
		return '';
	}

	return wp_get_attachment_image(
		$image_id,
		$size,
		false,
		$attributes
	);
}


/**
 * Output responsive image markup.
 *
 * @param int|array|null $image      Attachment ID or ACF image array.
 * @param string|array   $size       Registered image size.
 * @param array          $attributes Additional HTML attributes.
 */
function websiteni_image(
	$image,
	$size = 'full',
	$attributes = []
) {
	echo wp_kses_post(
		websiteni_get_image(
			$image,
			$size,
			$attributes
		)
	);
}