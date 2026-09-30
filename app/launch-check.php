<?php
/**
 * WebsiteNI Starter Theme
 * Launch readiness checks.
 */

defined('ABSPATH') || exit;


/**
 * Register Launch Check under Appearance.
 */
function websiteni_register_launch_check_page() {
	add_theme_page(
		__('Launch Check', 'websiteni-foundation'),
		__('Launch Check', 'websiteni-foundation'),
		'manage_options',
		'websiteni-launch-check',
		'websiteni_render_launch_check_page'
	);
}

add_action(
	'admin_menu',
	'websiteni_register_launch_check_page'
);


/**
 * Check whether one or more plugin basenames are active.
 *
 * @param string|array $plugins Plugin basename(s).
 * @return bool
 */
function websiteni_launch_plugin_active($plugins) {
	if (!function_exists('is_plugin_active')) {
		require_once ABSPATH . 'wp-admin/includes/plugin.php';
	}

	foreach ((array) $plugins as $plugin) {
		if (is_plugin_active($plugin)) {
			return true;
		}
	}

	return false;
}


/**
 * Check whether a hostname ends with a value.
 *
 * Avoids requiring PHP str_ends_with().
 *
 * @param string $host   Hostname.
 * @param string $suffix Suffix.
 * @return bool
 */
function websiteni_launch_host_ends_with(
	$host,
	$suffix
) {
	if (
		empty($host)
		|| empty($suffix)
	) {
		return false;
	}

	return substr(
		$host,
		-strlen($suffix)
	) === $suffix;
}


/**
 * Determine whether a hostname is clearly local.
 *
 * @param string $host Hostname.
 * @return bool
 */
function websiteni_launch_is_local_host($host) {
	if (empty($host)) {
		return false;
	}

	if (
		in_array(
			$host,
			[
				'localhost',
				'127.0.0.1',
			],
			true
		)
	) {
		return true;
	}

	return (
		websiteni_launch_host_ends_with(
			$host,
			'.local'
		)
		|| websiteni_launch_host_ends_with(
			$host,
			'.test'
		)
		|| websiteni_launch_host_ends_with(
			$host,
			'.localhost'
		)
	);
}


/**
 * Determine whether the site is running in a
 * non-production environment.
 *
 * @return bool
 */
function websiteni_launch_is_non_production_environment() {
	$environment = wp_get_environment_type();

	if (
		in_array(
			$environment,
			[
				'local',
				'development',
				'staging',
			],
			true
		)
	) {
		return true;
	}

	$host = wp_parse_url(
		home_url(),
		PHP_URL_HOST
	);

	return websiteni_launch_is_local_host(
		$host
	);
}


/**
 * Create a launch check.
 *
 * @param string $label       Check label.
 * @param bool   $passed      Whether the check passed.
 * @param string $success     Success message.
 * @param string $warning     Warning message.
 * @param string $group       Group.
 * @param bool   $required    Counts towards launch readiness.
 * @param string $action_url  Optional admin URL.
 * @param string $action_text Optional action text.
 * @return array
 */
function websiteni_launch_check_item(
	$label,
	$passed,
	$success,
	$warning,
	$group = 'general',
	$required = true,
	$action_url = '',
	$action_text = ''
) {
	return [
		'label'       => $label,
		'passed'      => (bool) $passed,
		'message'     => $passed
			? $success
			: $warning,
		'group'       => $group,
		'required'    => (bool) $required,
		'action_url'  => $action_url,
		'action_text' => $action_text,
	];
}


/**
 * Get launch readiness checks.
 *
 * @return array
 */
function websiteni_get_launch_checks() {
	$theme_dir = get_template_directory();

	$home_url = home_url();
	$site_url = site_url();

	$home_host = wp_parse_url(
		$home_url,
		PHP_URL_HOST
	);

	$is_local_host = websiteni_launch_is_local_host(
		$home_host
	);

	$is_non_production = websiteni_launch_is_non_production_environment();

	$https_enabled = function_exists(
		'wp_is_using_https'
	)
		? wp_is_using_https()
		: is_ssl();

	$blog_public = (int) get_option(
		'blog_public'
	);

	$permalink_structure = get_option(
		'permalink_structure'
	);

	$site_title = trim(
		(string) get_bloginfo('name')
	);

	$tagline = trim(
		(string) get_option('blogdescription')
	);

	$admin_email = get_option(
		'admin_email'
	);

	$timezone = get_option(
		'timezone_string'
	);

	$front_page_id = (int) get_option(
		'page_on_front'
	);

	$privacy_page_id = (int) get_option(
		'wp_page_for_privacy_policy'
	);

	$front_page_ready = (
		'page' === get_option('show_on_front')
		&& $front_page_id > 0
		&& 'publish' === get_post_status(
			$front_page_id
		)
	);

	$privacy_page_ready = (
		$privacy_page_id > 0
		&& 'publish' === get_post_status(
			$privacy_page_id
		)
	);

	$tagline_ready = (
		'just another wordpress site'
		!== strtolower($tagline)
	);

	$primary_menu_ready = has_nav_menu(
		'primary-navigation'
	);

	$secondary_menu_ready = has_nav_menu(
		'secondary-navigation'
	);

	$comments_disabled = (
		'closed'
		=== get_option(
			'default_comment_status'
		)
	);

	$css_file = (
		$theme_dir
		. '/assets/dist/style.css'
	);

	$js_file = (
		$theme_dir
		. '/assets/dist/script.js'
	);

	$compiled_css_ready = (
		is_file($css_file)
		&& filesize($css_file) > 0
	);

	$compiled_js_ready = (
		is_file($js_file)
		&& filesize($js_file) > 0
	);

	/**
	 * Plugin checks.
	 */
	$acf_active = websiteni_launch_plugin_active(
		[
			'advanced-custom-fields-pro/acf.php',
			'advanced-custom-fields/acf.php',
		]
	);

	$acfe_active = websiteni_launch_plugin_active(
		'acf-extended/acf-extended.php'
	);

	$yoast_active = websiteni_launch_plugin_active(
		'wordpress-seo/wp-seo.php'
	);

	$formidable_active = websiteni_launch_plugin_active(
		'formidable/formidable.php'
	);

	$cpt_ui_active = websiteni_launch_plugin_active(
		'custom-post-type-ui/custom-post-type-ui.php'
	);

	$litespeed_active = websiteni_launch_plugin_active(
		'litespeed-cache/litespeed-cache.php'
	);

	$safe_svg_active = websiteni_launch_plugin_active(
		'safe-svg/safe-svg.php'
	);

	/**
	 * Search visibility behaves differently depending
	 * on whether this is production.
	 */
	$search_visibility_ready = $is_non_production
		? 0 === $blog_public
		: 1 === $blog_public;

	$search_visibility_success = $is_non_production
		? 'Search engine indexing is disabled for this non-production site.'
		: 'Search engines are allowed to index the site.';

	$search_visibility_warning = $is_non_production
		? 'This non-production site currently allows search engine indexing.'
		: 'Search Engine Visibility is discouraging indexing on the live site.';

	/**
	 * WP_DEBUG is allowed during development but
	 * should be disabled in production.
	 */
	$wp_debug_enabled = (
		defined('WP_DEBUG')
		&& WP_DEBUG
	);

	$wp_debug_ready = $is_non_production
		? true
		: !$wp_debug_enabled;

	$wp_debug_success = $wp_debug_enabled
		? 'WP_DEBUG is enabled for this non-production environment.'
		: 'WP_DEBUG is disabled.';

	return [

		/**
		 * Website.
		 */
		websiteni_launch_check_item(
			'HTTPS',
			$https_enabled
				|| $is_local_host,
			$https_enabled
				? 'HTTPS is enabled.'
				: 'Local development site — HTTPS is not required here.',
			'The site is not currently using HTTPS.',
			'website',
			true
		),

		websiteni_launch_check_item(
			'Search Engine Visibility',
			$search_visibility_ready,
			$search_visibility_success,
			$search_visibility_warning,
			'website',
			true,
			admin_url(
				'options-reading.php'
			),
			'Open Reading Settings'
		),

		websiteni_launch_check_item(
			'Permalinks',
			!empty(
				$permalink_structure
			),
			'Pretty permalinks are enabled.',
			'Permalinks are using the default structure.',
			'website',
			true,
			admin_url(
				'options-permalink.php'
			),
			'Open Permalink Settings'
		),

		websiteni_launch_check_item(
			'Homepage',
			$front_page_ready,
			'A published static homepage is assigned.',
			'A published static homepage has not been assigned.',
			'website',
			true,
			admin_url(
				'options-reading.php'
			),
			'Open Reading Settings'
		),

		websiteni_launch_check_item(
			'Privacy Policy',
			$privacy_page_ready,
			'A published privacy policy page is assigned.',
			'A published privacy policy page has not been assigned.',
			'website',
			true,
			admin_url(
				'options-privacy.php'
			),
			'Open Privacy Settings'
		),

		websiteni_launch_check_item(
			'Timezone',
			!empty($timezone),
			'A named timezone is configured.',
			'The site is using a UTC offset rather than a named timezone.',
			'website',
			true,
			admin_url(
				'options-general.php'
			),
			'Open General Settings'
		),

		websiteni_launch_check_item(
			'Site Title',
			!empty($site_title),
			'Site title is set.',
			'The site title is empty.',
			'website',
			true,
			admin_url(
				'options-general.php'
			),
			'Open General Settings'
		),

		websiteni_launch_check_item(
			'Tagline',
			$tagline_ready,
			'The default WordPress tagline is not being used.',
			'The site is still using the default WordPress tagline.',
			'website',
			true,
			admin_url(
				'options-general.php'
			),
			'Open General Settings'
		),

		websiteni_launch_check_item(
			'Admin Email',
			(bool) is_email(
				$admin_email
			),
			'Admin email appears valid.',
			'The WordPress admin email should be checked.',
			'website',
			true,
			admin_url(
				'options-general.php'
			),
			'Open General Settings'
		),

		websiteni_launch_check_item(
			'Custom Logo',
			has_custom_logo(),
			'A custom logo is set.',
			'No custom logo has been set.',
			'website',
			true,
			admin_url(
				'customize.php'
			),
			'Set Logo'
		),

		websiteni_launch_check_item(
			'Site Icon',
			(bool) get_option(
				'site_icon'
			),
			'A site icon is set.',
			'No site icon / favicon has been set.',
			'website',
			true,
			admin_url(
				'customize.php'
			),
			'Set Site Icon'
		),

		/**
		 * Content & Navigation.
		 */
		websiteni_launch_check_item(
			'Primary Navigation',
			$primary_menu_ready,
			'A primary navigation menu is assigned.',
			'No primary navigation menu has been assigned.',
			'content',
			true,
			admin_url(
				'nav-menus.php'
			),
			'Open Menus'
		),

		websiteni_launch_check_item(
			'Secondary Navigation',
			$secondary_menu_ready,
			'A secondary navigation menu is assigned.',
			'No secondary navigation menu is assigned.',
			'content',
			false,
			admin_url(
				'nav-menus.php'
			),
			'Open Menus'
		),

		websiteni_launch_check_item(
			'Comments',
			$comments_disabled,
			'Comments are disabled by default.',
			'Comments are currently enabled for new posts.',
			'content',
			false,
			admin_url(
				'options-discussion.php'
			),
			'Open Discussion Settings'
		),

		/**
		 * URLs & Environment.
		 */
		websiteni_launch_check_item(
			'Site Address',
			!empty($home_url),
			'Site Address is configured.',
			'Site Address could not be determined.',
			'urls',
			true,
			admin_url(
				'options-general.php'
			),
			'Open General Settings'
		),

		websiteni_launch_check_item(
			'WordPress Address',
			!empty($site_url),
			'WordPress Address is configured.',
			'WordPress Address could not be determined.',
			'urls',
			true,
			admin_url(
				'options-general.php'
			),
			'Open General Settings'
		),

		websiteni_launch_check_item(
			'Development URL',
			$is_non_production
				|| !$is_local_host,
			$is_non_production
				? 'Non-production URL detected — expected for this environment.'
				: 'No local development hostname detected.',
			'The production site still appears to be using a local development hostname.',
			'urls',
			true,
			admin_url(
				'options-general.php'
			),
			'Check Site URLs'
		),

		/**
		 * Development.
		 */
		websiteni_launch_check_item(
			'WP_DEBUG',
			$wp_debug_ready,
			$wp_debug_success,
			'WP_DEBUG is enabled and should be disabled on the production site.',
			'development',
			true
		),

		websiteni_launch_check_item(
			'Compiled CSS',
			$compiled_css_ready,
			'Compiled stylesheet exists and is not empty.',
			'assets/dist/style.css is missing or empty.',
			'development',
			true
		),

		websiteni_launch_check_item(
			'Compiled JavaScript',
			$compiled_js_ready,
			'Compiled JavaScript exists and is not empty.',
			'assets/dist/script.js is missing or empty.',
			'development',
			true
		),

		/**
		 * Required plugins.
		 */
		websiteni_launch_check_item(
			'Advanced Custom Fields',
			$acf_active,
			'Advanced Custom Fields is active.',
			'Advanced Custom Fields is not active.',
			'required_plugins',
			true,
			admin_url(
				'plugins.php'
			),
			'Open Plugins'
		),

		/**
		 * Recommended plugins.
		 */
		websiteni_launch_check_item(
			'ACF Extended',
			$acfe_active,
			'ACF Extended is active.',
			'ACF Extended is not active.',
			'recommended_plugins',
			false,
			admin_url(
				'plugins.php'
			),
			'Open Plugins'
		),

		websiteni_launch_check_item(
			'Yoast SEO',
			$yoast_active,
			'Yoast SEO is active.',
			'Yoast SEO is not active.',
			'recommended_plugins',
			false,
			admin_url(
				'plugins.php'
			),
			'Open Plugins'
		),

		websiteni_launch_check_item(
			'Formidable Forms',
			$formidable_active,
			'Formidable Forms is active.',
			'Formidable Forms is not active.',
			'recommended_plugins',
			false,
			admin_url(
				'plugins.php'
			),
			'Open Plugins'
		),

		websiteni_launch_check_item(
			'Custom Post Type UI',
			$cpt_ui_active,
			'Custom Post Type UI is active.',
			'Custom Post Type UI is not active.',
			'recommended_plugins',
			false,
			admin_url(
				'plugins.php'
			),
			'Open Plugins'
		),

		websiteni_launch_check_item(
			'LiteSpeed Cache',
			$litespeed_active,
			'LiteSpeed Cache is active.',
			'LiteSpeed Cache is not active.',
			'recommended_plugins',
			false,
			admin_url(
				'plugins.php'
			),
			'Open Plugins'
		),

		websiteni_launch_check_item(
			'Safe SVG',
			$safe_svg_active,
			'Safe SVG is active.',
			'Safe SVG is not active.',
			'recommended_plugins',
			false,
			admin_url(
				'plugins.php'
			),
			'Open Plugins'
		),
	];
}


/**
 * Render Launch Check admin page.
 */
function websiteni_render_launch_check_page() {
	if (!current_user_can('manage_options')) {
		return;
	}

	$checks = websiteni_get_launch_checks();

	$is_non_production = websiteni_launch_is_non_production_environment();

	$groups = [
		'website' => 'Website',
		'content' => 'Content & Navigation',
		'urls' => 'URLs & Environment',
		'development' => 'Development',
		'required_plugins' => 'Required Plugins',
		'recommended_plugins' => 'Recommended Plugins',
	];

	$required_checks = array_filter(
		$checks,
		function ($check) {
			return $check['required'];
		}
	);

	$total_required = count(
		$required_checks
	);

	$passed_required = count(
		array_filter(
			$required_checks,
			function ($check) {
				return $check['passed'];
			}
		)
	);

	$remaining = (
		$total_required
		- $passed_required
	);

	$ready = 0 === $remaining;

	?>

	<div class="wrap websiteni-launch-check">

		<h1>
			<?php esc_html_e(
				'WebsiteNI Launch Check',
				'websiteni-foundation'
			); ?>
		</h1>

		<p class="description">
			<?php esc_html_e(
				'Quick checks to run before a WebsiteNI site goes live.',
				'websiteni-foundation'
			); ?>
		</p>


		<?php if ($is_non_production) : ?>

			<div class="notice notice-info inline">
				<p>
					<strong>
						<?php esc_html_e(
							'Non-production environment detected.',
							'websiteni-foundation'
						); ?>
					</strong>

					<?php esc_html_e(
						'Run the Launch Check again on the production site after the final URL or DNS change.',
						'websiteni-foundation'
					); ?>
				</p>
			</div>

		<?php endif; ?>


		<div
			class="wni-launch-summary <?php echo $ready
				? 'is-ready'
				: 'needs-check'; ?>"
		>

			<?php if ($ready) : ?>

				<strong>
					<?php
					echo esc_html(
						$is_non_production
							? 'Configuration checks ready'
							: 'Ready for launch'
					);
					?>
				</strong>

				<p>
					<?php
					echo esc_html(
						sprintf(
							'All %d required checks are ready.',
							$total_required
						)
					);
					?>
				</p>

			<?php else : ?>

				<strong>
					<?php
					echo esc_html(
						sprintf(
							'%d launch %s need attention',
							$remaining,
							1 === $remaining
								? 'item'
								: 'items'
						)
					);
					?>
				</strong>

				<p>
					<?php
					echo esc_html(
						sprintf(
							'%d of %d required checks ready.',
							$passed_required,
							$total_required
						)
					);
					?>
				</p>

			<?php endif; ?>

			<p class="wni-launch-summary-note">
				<?php esc_html_e(
					'Only required checks count towards the launch score.',
					'websiteni-foundation'
				); ?>
			</p>

		</div>


		<?php foreach ($groups as $group_key => $group_label) : ?>

			<h2>
				<?php echo esc_html(
					$group_label
				); ?>
			</h2>

			<div class="wni-launch-grid">

				<?php foreach ($checks as $check) : ?>

					<?php
					if (
						$check['group']
						!== $group_key
					) {
						continue;
					}

					if ($check['required']) {
						$status_class = $check['passed']
							? 'is-ready'
							: 'needs-check';

						$status_text = $check['passed']
							? 'Ready'
							: 'Check';

						$status_icon = $check['passed']
							? 'dashicons-yes-alt'
							: 'dashicons-warning';
					} else {
						$status_class = $check['passed']
							? 'is-ready'
							: 'is-optional';

						$status_text = $check['passed']
							? 'Ready'
							: 'Optional';

						$status_icon = $check['passed']
							? 'dashicons-yes-alt'
							: 'dashicons-info';
					}
					?>

					<div
						class="wni-launch-card <?php echo esc_attr(
							$status_class
						); ?>"
					>

						<div class="wni-launch-status">

							<span
								class="dashicons <?php echo esc_attr(
									$status_icon
								); ?>"
							></span>

							<?php echo esc_html(
								$status_text
							); ?>

						</div>

						<h3>
							<?php echo esc_html(
								$check['label']
							); ?>
						</h3>

						<p>
							<?php echo esc_html(
								$check['message']
							); ?>
						</p>

						<?php if (
							!empty($check['action_url'])
							&& !empty($check['action_text'])
						) : ?>

							<p class="wni-launch-action">

								<a
									class="button button-secondary button-small"
									href="<?php echo esc_url(
										$check['action_url']
									); ?>"
								>
									<?php echo esc_html(
										$check['action_text']
									); ?>
								</a>

							</p>

						<?php endif; ?>

					</div>

				<?php endforeach; ?>

			</div>

		<?php endforeach; ?>


		<h2>
			<?php esc_html_e(
				'Environment',
				'websiteni-foundation'
			); ?>
		</h2>

		<table class="widefat striped wni-launch-environment">

			<tbody>

				<tr>
					<th>Environment</th>

					<td>
						<?php echo esc_html(
							wp_get_environment_type()
						); ?>
					</td>
				</tr>

				<tr>
					<th>Home URL</th>

					<td>
						<?php echo esc_html(
							home_url()
						); ?>
					</td>
				</tr>

				<tr>
					<th>WordPress URL</th>

					<td>
						<?php echo esc_html(
							site_url()
						); ?>
					</td>
				</tr>

				<tr>
					<th>WordPress</th>

					<td>
						<?php echo esc_html(
							get_bloginfo('version')
						); ?>
					</td>
				</tr>

				<tr>
					<th>PHP</th>

					<td>
						<?php echo esc_html(
							PHP_VERSION
						); ?>
					</td>
				</tr>

				<tr>
					<th>Locale</th>

					<td>
						<?php echo esc_html(
							get_locale()
						); ?>
					</td>
				</tr>

				<tr>
					<th>Timezone</th>

					<td>
						<?php
						echo esc_html(
							get_option(
								'timezone_string'
							)
							?: 'UTC offset'
						);
						?>
					</td>
				</tr>

				<tr>
					<th>Theme</th>

					<td>
						<?php echo esc_html(
							wp_get_theme()->get(
								'Name'
							)
						); ?>
					</td>
				</tr>

				<tr>
					<th>Theme Version</th>

					<td>
						<?php echo esc_html(
							wp_get_theme()->get(
								'Version'
							)
						); ?>
					</td>
				</tr>

			</tbody>

		</table>


		<p class="wni-launch-site-health">

			<a
				class="button button-secondary"
				href="<?php echo esc_url(
					admin_url(
						'site-health.php'
					)
				); ?>"
			>
				<?php esc_html_e(
					'Open WordPress Site Health',
					'websiteni-foundation'
				); ?>
			</a>

		</p>

	</div>


	<style>
		.websiteni-launch-check {
			max-width: 1200px;
		}

		.websiteni-launch-check
		.notice.inline {
			margin:
				25px
				0
				0;
		}

		.wni-launch-summary {
			margin:
				25px
				0
				35px;
			padding: 20px;
			background: #fff;
			border-left:
				4px
				solid
				#2271b1;
			box-shadow:
				0
				1px
				1px
				rgba(
					0,
					0,
					0,
					.04
				);
		}

		.wni-launch-summary strong {
			font-size: 18px;
		}

		.wni-launch-summary p {
			margin:
				6px
				0
				0;
		}

		.wni-launch-summary
		.wni-launch-summary-note {
			color: #646970;
			font-size: 12px;
		}

		.wni-launch-summary.is-ready {
			border-left-color: #00a32a;
		}

		.wni-launch-summary.needs-check {
			border-left-color: #dba617;
		}

		.wni-launch-grid {
			display: grid;
			grid-template-columns:
				repeat(
					auto-fit,
					minmax(
						240px,
						1fr
					)
				);
			gap: 15px;
			margin-bottom: 35px;
		}

		.wni-launch-card {
			padding: 20px;
			background: #fff;
			border:
				1px
				solid
				#dcdcde;
			border-left-width: 4px;
			box-sizing: border-box;
		}

		.wni-launch-card.is-ready {
			border-left-color: #00a32a;
		}

		.wni-launch-card.needs-check {
			border-left-color: #dba617;
		}

		.wni-launch-card.is-optional {
			border-left-color: #72aee6;
		}

		.wni-launch-card h3 {
			margin:
				10px
				0
				5px;
		}

		.wni-launch-card p {
			margin-bottom: 0;
		}

		.wni-launch-status {
			display: flex;
			align-items: center;
			gap: 5px;
			font-weight: 600;
		}

		.is-ready
		.wni-launch-status {
			color: #008a20;
		}

		.needs-check
		.wni-launch-status {
			color: #996800;
		}

		.is-optional
		.wni-launch-status {
			color: #2271b1;
		}

		.wni-launch-action {
			margin-top: 15px;
		}

		.wni-launch-action
		.button {
			margin-bottom: 0;
		}

		.wni-launch-environment {
			max-width: 750px;
			margin-bottom: 20px;
		}

		.wni-launch-environment th {
			width: 200px;
		}

		.wni-launch-site-health {
			margin-bottom: 40px;
		}
	</style>

	<?php
}