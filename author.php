<!-- Incomplete.  This is just a simple version of what will go here-->

<?php get_header(); ?>

<div id="content" class="narrowcolumn">

<!-- This sets the $curauth variable -->

    <?php
    $curauth = (isset($_GET['author_name'])) ? get_user_by('slug', $author_name) : get_userdata(intval($author));
    ?>

    <h1><?php echo $curauth->nickname; ?></h1>

    <?php if( !empty( $curauth->user_description ) ) { ?>
    <h3>Bio</h3>
    <p><?php echo $curauth->user_description; ?></p>
    <?php } ?>
</div>


<!-- The Loop -->
    <h3>Reviews</h3>
    <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
        <li>
            <a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link: <?php the_title(); ?>">
            <?php the_title(); ?></a>
            <?php the_time('M d, Y');?>
        </li>

    <?php endwhile; ?>

    <br>

    <?php the_posts_pagination(); ?>

    <?php else : ?>

        <p><?php _e('No posts by this author.'); ?></p>

    <?php endif; ?>

<!-- End Loop -->




<?php get_footer(); ?>