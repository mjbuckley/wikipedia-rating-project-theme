<?php
/**
 * The template part for displaying a message that posts cannot be found.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package wrp-theme
 */
?>

<section class="no-results not-found">
	<header class="page-header">
		<h1 class="page-title"><?php _e( 'Nothing Found', 'wrp-theme' ); ?></h1>
	</header><!-- .page-header -->

	<div class="page-content">
		<?php if ( is_search() ) : ?>

			<p><?php _e( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'wrp-theme' ); ?></p>
			<?php get_search_form(); ?>

		<?php else : ?>

			<p>Sorry, but there are new reviews yet in that category.</p>

		<?php endif; ?>
	</div><!-- .page-content -->
</section><!-- .no-results -->
