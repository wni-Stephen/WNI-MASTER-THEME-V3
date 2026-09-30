<?php
/**
 * WebsiteNI Starter Theme.
 *
 * Template Name: Privacy Policy
 */

defined('ABSPATH') || exit;

get_header();
?>
<main id="content" class="content page-privacy-policy">
	<?php if (have_posts()) : ?>
		<?php while (have_posts()) : ?>
			<?php the_post(); ?>
			<?php get_template_part('components/page-content'); ?>
		<?php endwhile; ?>
	<?php endif; ?>
</main>
<?php
get_footer();
