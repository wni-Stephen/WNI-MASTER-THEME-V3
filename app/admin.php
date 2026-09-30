<?php
/**
 * WordPress admin customisations.
 *
 * Handles login branding, dashboard customisation
 * and editor settings.
 */

defined('ABSPATH') || exit;


/**
 * Get the logo used on the WordPress login screen.
 *
 * Uses the WordPress custom logo when available,
 * falling back to the starter theme logo.
 */
function websiteni_joints_get_login_logo() {

	$custom_logo_id = get_theme_mod(
		'custom_logo'
	);

	if ($custom_logo_id) {

		$custom_logo = wp_get_attachment_image_url(
			$custom_logo_id,
			'full'
		);

		if ($custom_logo) {
			return $custom_logo;
		}
	}

	return get_template_directory_uri()
		. '/assets/images/header/companylogo.svg';
}


/**
 * Custom WordPress login styling.
 */
function websiteni_joints_login_styles() {

	$logo_url = websiteni_joints_get_login_logo();
	?>

	<style>
		.login h1 a {
			width: 100%;
			height: 60px;
			background-image:
				url('<?php echo esc_url($logo_url); ?>');
			background-position: center;
			background-repeat: no-repeat;
			background-size: contain;
		}

		.login #login {
			padding-top: 40px;
			padding-bottom: 40px;
		}

		.login .button-primary {
			background: #000;
			border-color: #000;
		}

		.login .button-primary:hover,
		.login .button-primary:focus {
			background: #222;
			border-color: #222;
		}
	</style>

	<?php
}

add_action(
	'login_enqueue_scripts',
	'websiteni_joints_login_styles'
);


/**
 * Make the login logo link back to the website.
 */
function websiteni_joints_login_logo_url() {

	return home_url('/');
}

add_filter(
	'login_headerurl',
	'websiteni_joints_login_logo_url'
);


/**
 * Login logo accessible text.
 */
function websiteni_joints_login_logo_text() {

	return get_bloginfo(
		'name',
		'display'
	);
}

add_filter(
	'login_headertext',
	'websiteni_joints_login_logo_text'
);


/**
 * Disable the Gutenberg block editor.
 *
 * WebsiteNI projects use ACF flexible content
 * and the classic editing experience by default.
 */
add_filter(
	'use_block_editor_for_post',
	'__return_false'
);

add_filter(
	'use_block_editor_for_post_type',
	'__return_false'
);


/**
 * Remove the WordPress welcome panel.
 */
remove_action(
	'welcome_panel',
	'wp_welcome_panel'
);


/**
 * Remove unnecessary default dashboard widgets.
 */
function websiteni_joints_remove_dashboard_widgets() {

	remove_meta_box(
		'dashboard_right_now',
		'dashboard',
		'normal'
	);

	remove_meta_box(
		'dashboard_activity',
		'dashboard',
		'normal'
	);

	remove_meta_box(
		'dashboard_quick_press',
		'dashboard',
		'side'
	);

	remove_meta_box(
		'dashboard_primary',
		'dashboard',
		'side'
	);
}

add_action(
	'wp_dashboard_setup',
	'websiteni_joints_remove_dashboard_widgets'
);


/**
 * Add WebsiteNI support dashboard widget.
 */
function websiteni_joints_custom_dashboard_widgets() {

	wp_add_dashboard_widget(
		'websiteni_joints_widget',
		'WebsiteNI - Do you need help?',
		'websiteni_joints_widget_dashboard'
	);
}

add_action(
	'wp_dashboard_setup',
	'websiteni_joints_custom_dashboard_widgets'
);


/**
 * WebsiteNI dashboard widget content.
 */
function websiteni_joints_widget_dashboard() {
	?>

	<p>
		Welcome to your WordPress website.
		If you need any help managing your website,
		please contact
		<a href="mailto:support@websiteni.com">
			support@websiteni.com
		</a>.
	</p>

	<?php
}


/**
 * Custom WordPress admin footer.
 */
function websiteni_joints_custom_dashboard_footer() {

	echo wp_kses_post(
		'Created by <a href="https://websiteni.com" target="_blank" rel="noopener noreferrer">WebsiteNI</a>'
	);
}

add_filter(
	'admin_footer_text',
	'websiteni_joints_custom_dashboard_footer'
);