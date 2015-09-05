<?php
/**
 * @package wrp-theme
 */
?>

<!-- below works but only if title exist, also should be a better way to do this
if statement around first chunk of display code avoids displaying php errors if title doesn't exist -->

<?php
  $names = get_the_terms( $post->ID, 'wiki_title');
  $name = array_pop($names);
  $name_link = get_term_link($name);
  $lastrevid_value = get_post_meta( get_the_ID(), 'lastrevid', true );
  $encode_name = rawurlencode($name->name);
  $lastrevid_link = 'http://en.wikipedia.org/w/index.php?title=' . $encode_name . '&oldid=' . $lastrevid_value;
  $rating_values = get_the_terms( $post->ID, 'wiki_rating');
  $rating_value = array_pop($rating_values);
  $rating_link = get_term_link($rating_value);
?>


<?php if ( is_array($names)) { ?>
  <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <header class="entry-header temp">
      <?php echo '<h1><a href="' . esc_url( $name_link ) . '">' . esc_html( $name->name ) . '</a></h1>'; ?>
      <div class="entry-meta temp">
        <p>By <span class="upcase"><?php the_author_posts_link(); ?></span><span class="upcase-date"><?php the_time('F j, Y'); ?></span></p>
        <p>Revision ID: <a href="<?php echo esc_url( $lastrevid_link ); ?>"><?php echo $lastrevid_value; ?></a></p>
        <?php echo '<p>Rating: <a href="' . esc_url( $rating_link ) . '">' . esc_html( $rating_value->name ) . '</a></p>'; ?>
      </div><!-- .entry-meta -->
    </header><!-- .entry-header -->
<?php } ?>

    <div class="entry-content temp">
      <?php the_content(); ?>
    </div><!-- .entry-content -->

    <footer class="entry-footer">
      <?php wrp_theme_entry_footer(); ?>
    </footer><!-- .entry-footer -->
  </article><!-- #post-## -->
