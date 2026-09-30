<?php
/**
 * WebsiteNI Starter Theme
 *
 * Single post template.
 */
defined('ABSPATH') || exit;
get_header();
$posts_page_id = absint(
	get_option('page_for_posts')
);
$posts_page_url = $posts_page_id
	? get_permalink($posts_page_id)
	: home_url('/');
$posts_page_title = $posts_page_id
	? get_the_title($posts_page_id)
	: __('News', 'websiteni-foundation');
?>
<main
	id="content"
	class="content"
>
	<?php if (have_posts()) : ?>
		<?php
		while (have_posts()) :
			the_post();
			?>
			<article
				id="post-<?php the_ID(); ?>"
				<?php post_class('single-post'); ?>
			>
				<header class="single-header">
					<div class="grid-container">
						<div class="grid-x grid-padding-x">
							<div class="cell small-12">
								<nav
									class="single-breadcrumbs"
									aria-label="Breadcrumb"
								>
									<a
										href="<?php echo esc_url(
											home_url('/')
										); ?>"
									>
										<?php
										esc_html_e(
											'Home',
											'websiteni-foundation'
										);
										?>
									</a>
									<span aria-hidden="true">
										&gt;
									</span>
									<a
										href="<?php echo esc_url(
											$posts_page_url
										); ?>"
									>
										<?php echo esc_html(
											$posts_page_title
										); ?>
									</a>
									<span aria-hidden="true">
										&gt;
									</span>
									<span aria-current="page">
										<?php the_title(); ?>
									</span>
								</nav>
							</div>
							<div class="cell small-12">
								<h1 class="single-title">
									<?php the_title(); ?>
								</h1>
								<p class="single-meta">
									<?php
									printf(
										esc_html__(
											'Posted on %s',
											'websiteni-foundation'
										),
										esc_html(
											get_the_date()
										)
									);
									?>
								</p>
							</div>
						</div>
					</div>
				</header>
				<section class="single-content">
					<div class="grid-container">
						<div class="grid-x grid-padding-x">
							<div class="cell small-12 large-8">
								<?php if (has_post_thumbnail()) : ?>
									<div class="single-featured-image">
										<?php
										the_post_thumbnail(
											'large'
										);
										?>
									</div>
								<?php endif; ?>
								<div class="single-entry-content">
									<?php the_content(); ?>
								</div>
							</div>
						</div>
					</div>
				</section>
				<nav
					class="single-post-navigation"
					aria-label="<?php esc_attr_e(
						'Post navigation',
						'websiteni-foundation'
					); ?>"
				>
					<div class="grid-container">
						<?php
						the_post_navigation(
							array(
								'prev_text' => '<span class="post-nav-label">'
									. esc_html__(
										'Previous',
										'websiteni-foundation'
									)
									. '</span>'
									. '<span class="post-nav-title">%title</span>',
								'next_text' => '<span class="post-nav-label">'
									. esc_html__(
										'Next',
										'websiteni-foundation'
									)
									. '</span>'
									. '<span class="post-nav-title">%title</span>',
							)
						);
						?>
					</div>
				</nav>
			</article>
		<?php endwhile; ?>
	<?php endif; ?>
</main>
<?php
get_footer();