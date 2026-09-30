<?php
/**
 * WebsiteNI Starter Theme
 *
 * Created by WebsiteNI.
 */

defined('ABSPATH') || exit;

$theme_uri = get_template_directory_uri();

$site_name = get_bloginfo(
	'name',
	'display'
);

$custom_logo_id = get_theme_mod(
	'custom_logo'
);
?>

<!DOCTYPE html>

<html <?php language_attributes(); ?> class="no-js">

<head>

	<meta charset="<?php bloginfo('charset'); ?>">

	<meta
		name="viewport"
		content="width=device-width, initial-scale=1"
	>

	<meta
		name="author"
		content="WebsiteNI"
	>

	<?php wp_head(); ?>

</head>

<body <?php body_class('smooth-scroll'); ?>>

	<?php wp_body_open(); ?>


	<!-- Skip Navigation -->

	<div id="skip-navigation-link">

		<a href="#content">
			Skip to Main Content
		</a>

	</div>



	<!-- Mobile Navigation -->

	<div
		id="mobile-navigation"
		class="navigation-overlay"
		aria-hidden="true"
	>

		<nav aria-label="Primary navigation">


			<button
				class="close"
				type="button"
				aria-label="Close menu"
			>

				<img
					src="<?php echo esc_url(
						$theme_uri
						. '/assets/images/header/close.svg'
					); ?>"
					alt=""
				>

			</button>


			<?php
			wp_nav_menu(
				array(
					'theme_location' => 'primary-navigation',
					'menu_class'     => 'primary-menu',
				)
			);
			?>


		</nav>

	</div>


	<!-- GSAP ScrollSmoother Wrapper -->

	<div id="smooth-wrapper">

		<div id="smooth-content">


			<!-- Website Wrapper -->

			<div
				id="wrapper"
				class="wrapper"
			>

				<div
					id="wrapper-inner"
					class="wrapper-inner"
				>


					<!-- Header -->

					<header class="navigation">

						<div class="grid-container full">

							<div class="grid-container">

								<div class="grid-x grid-padding-x">


									<!-- Logo -->

									<div
										class="cell small-6 large-3 companylogo wni-flex wni-flex-justify-start wni-flex-align-center"
									>

										<a
											class="company-logo"
											href="<?php echo esc_url(
												home_url('/')
											); ?>"
											title="<?php echo esc_attr(
												$site_name
											); ?>"
											rel="home"
										>

											<?php if ($custom_logo_id) : ?>

												<?php
												echo wp_get_attachment_image(
													$custom_logo_id,
													'full',
													false,
													array(
														'class' => 'custom-logo',
														'alt'   => $site_name,
													)
												);
												?>

											<?php else : ?>

												<img
													src="<?php echo esc_url(
														$theme_uri
														. '/assets/images/header/companylogo.svg'
													); ?>"
													alt="<?php echo esc_attr(
														$site_name
													); ?>"
												>

											<?php endif; ?>

										</a>

									</div>


									<!-- Mobile Search + Hamburger -->

									<div
										class="cell small-6 hide-for-large wni-flex wni-flex-justify-end wni-flex-align-center"
									>

										<button
											class="search-open"
											type="button"
											aria-label="Open search"
										>

											<img
												src="<?php echo esc_url(
													$theme_uri
													. '/assets/images/header/search.svg'
												); ?>"
												alt=""
											>

										</button>


										<button
											class="hamburger hamburger--slider-r"
											type="button"
											aria-label="Open menu"
											aria-controls="mobile-navigation"
											aria-expanded="false"
										>

											<span class="hamburger-box">

												<span class="hamburger-inner"></span>

											</span>

										</button>

									</div>


									<!-- Desktop Navigation + Search -->

									<div
										class="cell large-8 large-offset-1 show-for-large wni-flex wni-flex-justify-end wni-flex-align-center"
									>

										<nav aria-label="Secondary navigation">

											<?php
											wp_nav_menu(
												array(
													'theme_location' => 'secondary-navigation',
													'menu_class'     => 'secondary-menu',
												)
											);
											?>

										</nav>


										<button
											class="search-open"
											type="button"
											aria-label="Open search"
										>

											<img
												src="<?php echo esc_url(
													$theme_uri
													. '/assets/images/header/search.svg'
												); ?>"
												alt=""
											>

										</button>

									</div>


								</div>

							</div>

						</div>

					</header>