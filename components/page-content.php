<?php
/**
 * Render the current page using the WebsiteNI flexible-content builder,
 * falling back to the WordPress editor when no layouts are configured.
 */

defined('ABSPATH') || exit;

$has_flexible_content = (
	function_exists('have_rows')
	&& have_rows('page_content')
);

if ($has_flexible_content) {
	get_template_part('components/flexible-content');
	return;
}
?>
<div class="grid-container page-content-fallback">
	<div class="grid-x grid-padding-x">
		<div class="cell small-12">
			<?php the_content(); ?>
	</div>
</div>
