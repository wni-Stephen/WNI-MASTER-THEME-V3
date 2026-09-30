<?php
/**
 * WebsiteNI Starter Theme
 * Search Overlay.
 */

defined('ABSPATH') || exit;

$theme_uri = get_template_directory_uri();

$search_id = wp_unique_id(
	'search-input-'
);
?>

<div
	id="site-search"
	class="search"
	aria-hidden="true"
	role="dialog"
	aria-modal="true"
	aria-label="Site search"
>

	<div class="search-inner">

		<div class="search-container">

			<form
				class="search-form"
				role="search"
				method="get"
				action="<?php echo esc_url(
					home_url('/')
				); ?>"
			>

				<label
					class="show-for-sr"
					for="<?php echo esc_attr(
						$search_id
					); ?>"
				>
					Search the website
				</label>

				<input
					id="<?php echo esc_attr(
						$search_id
					); ?>"
					class="search-input"
					name="s"
					type="search"
					placeholder="Enter Type..."
					value="<?php echo esc_attr(
						get_search_query()
					); ?>"
					autocomplete="off"
				>

			</form>


			<button
				class="search-close"
				type="button"
				aria-label="Close search"
			>

				<img
					src="<?php echo esc_url(
						$theme_uri
						. '/assets/images/header/close.svg'
					); ?>"
					alt=""
					class="close-icon"
				>

			</button>

		</div>

	</div>

</div>