<?php
/**
 * @package wrp-theme
 */
?>

<?php
  $names = get_the_terms( $post->ID, 'wiki_title');
  $name = array_pop($names);
  $lastrevid_value = get_post_meta( get_the_ID(), 'lastrevid', true );
  $encode_name = rawurlencode($name->name);
  $lastrevid_link = 'http://en.wikipedia.org/w/index.php?title=' . $encode_name . '&oldid=' . $lastrevid_value;
  $name_link = get_term_link($name);
  $rating_values = get_the_terms( $post->ID, 'wiki_rating');
  $rating_value = array_pop($rating_values);
  $rating_link = get_term_link($rating_value);
  $paged = (get_query_var('paged')) ? get_query_var('paged') : 1; // Determine what page # we are on if paginated
?>

<?php if( $paged === 1 ) { ?>
  <?php if($post == $posts[0]) {
    // probably not the best way to do this, but works for now.  Look in to current_post() ?>

    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
      <header class="entry-header temp">
        <h4 class="most-recent">Most recent review</h4>
        <?php echo '<h1><a href="' . esc_url( $name_link ) . '">' . esc_html( $name->name ) . '</a></h1>'; ?>
        <div class="entry-meta temp">
          <p>By <span class="upcase"><?php the_author_posts_link(); ?></span><span class="upcase-date"><?php the_time('F j, Y'); ?></span></p>
          <p>Revision ID: <a href="<?php echo esc_url( $lastrevid_link ); ?>"><?php echo $lastrevid_value; ?></a></p>
          <?php echo '<p>Rating: <a href="' . esc_url( $rating_link ) . '">' . esc_html( $rating_value->name ) . '</a></p>'; ?>
        </div><!-- .entry-meta -->
      </header><!-- .entry-header -->

      <div class="entry-content temp">
        <?php the_content(); ?>
        <p class="click-to-view"><a href="<?php echo get_permalink(); ?>">Click to view review on a separate page</a></p>
      </div><!-- .entry-content -->

      <footer class="entry-footer">
        <?php wrp_theme_entry_footer(); ?>
      </footer><!-- .entry-footer -->
    </article><!-- #post-## -->

  <?php } elseif($post == $posts[1]) { ?>

   <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
      <header class="entry-header temp">
        <h4 class="most-recent">Additional reviews</h4>
        <?php echo '<h2><a href="' . esc_url( $name_link ) . '">' . esc_html( $name->name ) . '</a></h2>'; ?>
          <div class="entry-meta temp">
            <p>By <span class="upcase"><?php the_author_posts_link(); ?></span><span class="upcase-date"><?php the_time('F j, Y'); ?></span></p>
            <p>Revision ID: <a href="<?php echo esc_url( $lastrevid_link ); ?>"><?php echo $lastrevid_value; ?></a></p>
            <?php echo '<p>Rating: <a href="' . esc_url( $rating_link ) . '">' . esc_html( $rating_value->name ) . '</a></p>'; ?>
            <p><a href="<?php echo get_permalink(); ?>">Click to view the complete review</a></p>
        </div><!-- .entry-meta -->
      </header><!-- .entry-header -->
      <footer class="entry-footer">
        <?php wrp_theme_entry_footer(); ?>
      </footer><!-- .entry-footer -->
    </article><!-- #post-## -->

  <?php } else { ?>

   <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
      <header class="entry-header temp">
        <?php echo '<h2><a href="' . esc_url( $name_link ) . '">' . esc_html( $name->name ) . '</a></h2>'; ?>
          <div class="entry-meta temp">
            <p>By <span class="upcase"><?php the_author_posts_link(); ?></span><span class="upcase-date"><?php the_time('F j, Y'); ?></span></p>
            <p>Revision ID: <a href="<?php echo esc_url( $lastrevid_link ); ?>"><?php echo $lastrevid_value; ?></a></p>
            <?php echo '<p>Rating: <a href="' . esc_url( $rating_link ) . '">' . esc_html( $rating_value->name ) . '</a></p>'; ?>
            <p><a href="<?php echo get_permalink(); ?>">Click to view the complete review</a></p>
        </div><!-- .entry-meta -->
      </header><!-- .entry-header -->
      <footer class="entry-footer">
        <?php wrp_theme_entry_footer(); ?>
      </footer><!-- .entry-footer -->
    </article><!-- #post-## -->
  <?php } ?>
<?php } else { ?>

  <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <header class="entry-header temp">
      <?php echo '<h2><a href="' . esc_url( $name_link ) . '">' . esc_html( $name->name ) . '</a></h2>'; ?>
        <div class="entry-meta temp">
          <p>By <span class="upcase"><?php the_author_posts_link(); ?></span><span class="upcase-date"><?php the_time('F j, Y'); ?></span></p>
          <p>Revision ID: <a href="<?php echo esc_url( $lastrevid_link ); ?>"><?php echo $lastrevid_value; ?></a></p>
          <?php echo '<p>Rating: <a href="' . esc_url( $rating_link ) . '">' . esc_html( $rating_value->name ) . '</a></p>'; ?>
          <p><a href="<?php echo get_permalink(); ?>">Click to view the complete review</a></p>
      </div><!-- .entry-meta -->
    </header><!-- .entry-header -->
    <footer class="entry-footer">
      <?php wrp_theme_entry_footer(); ?>
    </footer><!-- .entry-footer -->
  </article><!-- #post-## -->
<?php } ?>