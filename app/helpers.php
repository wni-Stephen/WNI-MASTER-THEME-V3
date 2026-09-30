<?php
/**
 * Theme helper functions.
 */

defined('ABSPATH') || exit;


/**
 * Get a trimmed post excerpt.
 *
 * @param int $limit Number of words to return.
 *
 * @return string
 */
function websiteni_joints_excerpt($limit = 20) {

	$limit = absint($limit);

	if (!$limit) {
		return '';
	}

	$excerpt = get_the_excerpt();

	$excerpt = strip_shortcodes(
		$excerpt
	);

	$excerpt = wp_strip_all_tags(
		$excerpt
	);

	return wp_trim_words(
		$excerpt,
		$limit,
		''
	);
}


/**
 * Move the comment field to the bottom
 * of the WordPress comment form.
 *
 * @param array $fields Comment form fields.
 *
 * @return array
 */
function websiteni_joints_comment_form_comment_field_to_bottom(
	$fields
) {

	if (empty($fields['comment'])) {
		return $fields;
	}

	$comment_field = $fields['comment'];

	unset(
		$fields['comment']
	);

	$fields['comment'] = $comment_field;

	return $fields;
}

add_filter(
	'comment_form_fields',
	'websiteni_joints_comment_form_comment_field_to_bottom'
);


/**
 * Get layout settings for the current
 * Flexible Content row.
 *
 * Supports:
 *
 * 1. ACF Extended Flexible Content Settings Modal.
 * 2. A manual ACF Clone field named "layout_options".
 * 3. No layout settings at all.
 *
 * @return array
 */
function websiteni_joints_get_layout_settings() {

	/**
	 * ACF Extended Settings Modal.
	 */
	if (
		function_exists('have_settings')
		&& have_settings()
	) {

		$options = array();

		while (have_settings()) {

			the_setting();

			$options = array(
				'section_id' => get_sub_field(
					'section_id'
				),

				'background' => get_sub_field(
					'background'
				),

				'padding_top' => get_sub_field(
					'padding_top'
				),

				'padding_bottom' => get_sub_field(
					'padding_bottom'
				),

				'extra_class' => get_sub_field(
					'extra_class'
				),
			);
		}

		return $options;
	}


	/**
	 * Standard ACF Clone field fallback.
	 *
	 * Allows projects without ACF Extended
	 * to use a grouped Clone field called
	 * "layout_options".
	 */
	if (function_exists('get_sub_field')) {

		$options = get_sub_field(
			'layout_options'
		);

		if (is_array($options)) {
			return $options;
		}
	}


	/**
	 * No layout settings configured.
	 */
	return array();
}


/**
 * Build reusable layout attributes from
 * Flexible Content Layout Options.
 *
 * @param array $options Layout settings.
 *
 * @return array
 */
function websiteni_joints_get_layout_options(
	$options = array()
) {

	if (!is_array($options)) {
		$options = array();
	}

	$classes = array();


	/**
	 * Background colour.
	 */
	$backgrounds = array(
		'primary',
		'secondary',
		'tertiary',
		'quaternary',
		'quinary',
		'senary',
		'white',
		'black',
	);

	if (
		!empty($options['background'])
		&& in_array(
			$options['background'],
			$backgrounds,
			true
		)
	) {
		$classes[] =
			'bg-' . $options['background'];
	}


	/**
	 * Top padding.
	 */
	$padding_top = array(
		'xsmall' => 'paddingtopxsml',
		'small'  => 'paddingtopsml',
		'medium' => 'paddingtopmed',
		'large'  => 'paddingtoplrg',
		'xlarge' => 'paddingtopxlrg',
	);

	if (
		!empty($options['padding_top'])
		&& isset(
			$padding_top[
				$options['padding_top']
			]
		)
	) {
		$classes[] =
			$padding_top[
				$options['padding_top']
			];
	}


	/**
	 * Bottom padding.
	 */
	$padding_bottom = array(
		'xsmall' => 'paddingbottomxsml',
		'small'  => 'paddingbottomsml',
		'medium' => 'paddingbottommed',
		'large'  => 'paddingbottomlrg',
		'xlarge' => 'paddingbottomxlrg',
	);

	if (
		!empty($options['padding_bottom'])
		&& isset(
			$padding_bottom[
				$options['padding_bottom']
			]
		)
	) {
		$classes[] =
			$padding_bottom[
				$options['padding_bottom']
			];
	}


	/**
	 * Additional custom CSS classes.
	 */
	if (!empty($options['extra_class'])) {

		$extra_classes = preg_split(
			'/\s+/',
			trim(
				$options['extra_class']
			)
		);

		foreach ($extra_classes as $extra_class) {

			$extra_class = sanitize_html_class(
				$extra_class
			);

			if ($extra_class) {
				$classes[] = $extra_class;
			}
		}
	}


	/**
	 * Optional section ID.
	 */
	$section_id = '';

	if (!empty($options['section_id'])) {

		$section_id = sanitize_title(
			$options['section_id']
		);
	}


	return array(
		'id' => $section_id,

		'classes' => implode(
			' ',
			array_unique(
				$classes
			)
		),
	);
}