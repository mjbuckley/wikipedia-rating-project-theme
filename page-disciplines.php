<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 * @package wrp-theme
 */

get_header(); ?>

  <div id="primary" class="content-area">
    <main id="main" class="site-main" role="main">

      <?php while ( have_posts() ) : the_post(); ?>

        <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
          <header class="entry-header tax-head">
            <?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
          </header><!-- .entry-header -->

          <div class="entry-content">

            <?php the_content(); ?>

            <?php 
              // Uses wp_list_categories to find all terms in the taxonomy.  Set to show empty terms.

              $args = array(
                'taxonomy'     => 'wiki_disciplines',
                'orderby'      => 'name',
                'show_count'   => 1,
                'hide_empty'   => 0,
                'use_desc_for_title' => 0,
                'title_li'     => ''
              );
            ?>

              <ul class="temp-list">
              <?php wp_list_categories( $args ); ?>
              </ul>

          </div><!-- .entry-content -->

          <footer class="entry-footer">
            <?php edit_post_link( __( 'Edit', 'wrp-theme' ), '<span class="edit-link">', '</span>' ); ?>
          </footer><!-- .entry-footer -->
        </article><!-- #post-## -->

      <?php endwhile; // end of the loop. ?>

    </main><!-- #main -->
  </div><!-- #primary -->

<?php get_footer(); ?>
