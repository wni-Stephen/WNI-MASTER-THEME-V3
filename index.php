<?php
/**
 * WebsiteNI Starter Theme
 *
 * Default post index / blog archive.
 */
defined('ABSPATH') || exit;
get_header();
$posts_page_id = get_option(
	'page_for_posts'
);
$page_title = $posts_page_id
	? get_the_title($posts_page_id)
	: __('News', 'websiteni-foundation');
?>
<main id="content" class="content">
	<section class="grid-container full">
		<div class="grid-container">
			<div class="grid-x grid-padding-x">
				<div class="cell small-12">
					<header class="archive-header">
						<h1>
							<?php echo esc_html(
								$page_title
							); ?>
						</h1>
					</header>
				</div>
			</div>
		</div>
	</section>
	<section class="grid-container full">
		<div class="grid-container">
			<div class="grid-x grid-padding-x">
				<div class="cell small-12 large-8">
					<?php if (have_posts()): ?>
						<div class="posts-list">
							<?php
							while (have_posts()):
								the_post();
								?>
								<article id="post-<?php the_ID(); ?>" <?php post_class('post-card'); ?>>
									<a class="post-card-link" href="<?php the_permalink(); ?>">
										<?php if (has_post_thumbnail()): ?>
											<div class="post-card-image">
												<?php
												the_post_thumbnail(
													'large'
												);
												?>
											</div>
										<?php endif; ?>
										<div class="post-card-content">
											<h2 class="post-card-title">
												<?php the_title(); ?>
											</h2>
											<p class="post-card-date">
												<?php
												echo esc_html(
													get_the_date()
												);
												?>
											</p>
											<div class="post-card-excerpt">
												<p>
													<?php
													echo esc_html(
														websiteni_joints_excerpt(
															25
														)
													);
													?>
												</p>
											</div>
											<span class="post-card-read-more">
												Read more
											</span>
										</div>
									</a>
								</article>
							<?php endwhile; ?>
						</div>
						<nav class="pagination" aria-label="Posts pagination">
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
						<p>
							<?php
							esc_html_e(
								'No posts were found.',
								'websiteni-foundation'
							);
							?>
						</p>
					<?php endif; ?>
				</div>
				<aside class="cell small-12 large-4 posts-sidebar" aria-label="News archive">
					<div class="posts-categories">
						<h2>
							<?php
							esc_html_e(
								'Categories',
								'websiteni-foundation'
							);
							?>
						</h2>
						<ul>
							<?php
							wp_list_categories(
								array(
									'title_li' => '',
								)
							);
							?>
						</ul>
					</div>
					<div class="posts-archives">
						<h2>
							<?php
							esc_html_e(
								'Archives',
								'websiteni-foundation'
							);
							?>
						</h2>
						<ul>
							<?php
							wp_get_archives(
								array(
									'type' => 'monthly',
								)
							);
							?>
						</ul>
					</div>
				</aside>
			</div>
		</div>
	</section>
</main>
<?php
get_footer();