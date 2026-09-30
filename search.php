<?php
/**
 * WebsiteNI Starter Theme
 *
 * Search results template.
 */
defined('ABSPATH') || exit;
get_header();
$search_query = get_search_query();
?>
<main id="content" class="content">
	<section class="search-results-header">
		<div class="grid-container">
			<div class="grid-x grid-padding-x">
				<div class="cell small-12">
					<?php
					if (function_exists('yoast_breadcrumb')) {
						yoast_breadcrumb(
							'<nav class="search-breadcrumbs" aria-label="Breadcrumb">',
							'</nav>'
						);
					}
					?>
				</div>
				<div class="cell small-12 large-8">
					<h1 class="search-results-title">
						<?php
						printf(
							esc_html__(
								'Search results for: %s',
								'websiteni-foundation'
							),
							esc_html(
								$search_query
							)
						);
						?>
					</h1>
				</div>
			</div>
		</div>
	</section>
	<section class="search-results-content">
		<div class="grid-container">
			<?php if (have_posts()): ?>
				<div class="grid-x grid-padding-x search-results-grid">
					<?php
					while (have_posts()):
						the_post();
						?>
						<div class="cell small-12 medium-6 large-4">
							<article id="post-<?php the_ID(); ?>" <?php post_class('search-result-card'); ?>>
								<a class="search-result-link" href="<?php the_permalink(); ?>">
									<div class="search-result-image">
										<?php if (has_post_thumbnail()): ?>
											<?php
											the_post_thumbnail(
												'large'
											);
											?>
										<?php endif; ?>
									</div>
									<div class="search-result-content">
										<h2 class="search-result-title">
											<?php the_title(); ?>
										</h2>
									</div>
								</a>
							</article>
						</div>
					<?php endwhile; ?>
				</div>
				<nav class="search-pagination" aria-label="<?php esc_attr_e(
					'Search results pagination',
					'websiteni-foundation'
				); ?>">
					<?php
					the_posts_pagination(
						array(
							'mid_size' => 2,
							'prev_text' => __(
								'Previous',
								'websiteni-foundation'
							),
							'next_text' => __(
								'Next',
								'websiteni-foundation'
							),
						)
					);
					?>
				</nav>
			<?php else: ?>
				<div class="search-no-results">
					<h2 class="search-no-results-title">
						<?php
						esc_html_e(
							'No results found.',
							'websiteni-foundation'
						);
						?>
					</h2>
					<p>
						<?php
						esc_html_e(
							'Sorry, we couldn’t find anything matching your search. Try another search term or return to the homepage.',
							'websiteni-foundation'
						);
						?>
					</p>
					<a class="button" href="<?php echo esc_url(
						home_url('/')
					); ?>">
						<?php
						esc_html_e(
							'Return Home',
							'websiteni-foundation'
						);
						?>
					</a>
				</div>
			<?php endif; ?>
		</div>
	</section>
</main>
<?php
get_footer();