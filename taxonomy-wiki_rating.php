<?php
/**
 * The template for displaying custom taxonomy pages.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package wrp-theme
 */

get_header(); ?>

  <div id="primary" class="content-area">
    <main id="main" class="site-main" role="main">

    <?php if ( have_posts() ) : ?>

      <header class="page-header">
        <?php
          // the_archive_title( '<h1 class="page-title">', '</h1>' );
          // the_archive_description( '<div class="taxonomy-description">', '</div>' );
          echo '<h1 class="page-title tax-head">All reviews with a rating of: ' . single_cat_title( '', false ) . '</h1>';
        ?>
      </header><!-- .page-header -->

      <?php /* Start the Loop */ ?>
      <?php while ( have_posts() ) : the_post(); ?>

        <?php
          /* Include the Post-Format-specific template for the content.
           * If you want to override this in a child theme, then include a file
           * called content-___.php (where ___ is the Post Format name) and that will be used instead.
           */
          get_template_part( 'content', get_post_type() );
        ?>

      <?php endwhile; ?>

      <?php the_posts_pagination(); ?>

    <?php else : ?>

      <?php get_template_part( 'content', 'none' ); ?>

    <?php endif; ?>

    </main><!-- #main -->
  </div><!-- #primary -->

<?php get_footer(); ?>
