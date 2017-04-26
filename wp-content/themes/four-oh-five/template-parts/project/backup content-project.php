<?php
/**
 * Template part for displaying posts
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Four_Oh_Five
 * @since 1.0
 * @version 1.0
 */

?>


<article id="post-<?php the_ID(); ?>" <?php post_class('card mb-4'); ?>>

  <header>
    <?php if ( '' !== get_the_post_thumbnail() ) : ?>
      <div class="card-img-top img-fluid">
        <?php the_post_thumbnail( 'fourohfive-featured-image', array( 'class' => 'img-fluid' ) ); ?>
      </div>
    <?php endif; ?>
  </header>

  <div class="card-block">
    <?php the_title( '<h1 class="card-title display-4">', '</h1>' ); ?>
    <h2 class="card-subtitle h6 mb-4 text-muted"><?php the_author(); ?> on <?php the_time('F jS, Y') ?></h2>

    <?php
      the_content( sprintf(
        __( 'Continue reading<span class="screen-reader-text"> "%s"</span>', 'four-oh-five' ),
        get_the_title()
      ) );

      $email = get_field('contributor_email');
      echo '<h2>Contributors</h2>';
      echo '<p>'. the_field('contributor_name') .'</p>';
      echo '<p><a href="mailto:'. $email .'">Email</a></p>';
  

      if(get_field('contributor_website'))
      {
        echo '<p><a href="http://'. $url .'">Website</a></p>';
      }

      if(get_field('contributor_photo'))
      {
        echo '<img src="' . get_field('contributor_photo') . '">';
      }



     $images = get_field('gallery');

            if( $images ): ?>
                <div id="slider" class="flexslider">
                    <ul class="slides">
                        <?php foreach( $images as $image ): ?>
                            <li>
                                <img src="<?php echo $image['url']; ?>" alt="<?php echo $image['alt']; ?>" />
                                <p><?php echo $image['caption']; ?></p>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                <div id="carousel" class="flexslider">
                    <ul class="slides">
                        <?php foreach( $images as $image ): ?>
                            <li>
                                <img src="<?php echo $image['sizes']['thumbnail']; ?>" alt="<?php echo $image['alt']; ?>" />
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>       




      wp_link_pages( array(
        'before'      => '<div class="page-links">' . __( 'Pages:', 'four-oh-five' ),
        'after'       => '</div>',
        'link_before' => '<span class="page-number">',
        'link_after'  => '</span>',
      ) );
    ?>
  </div>

  <?php if ( is_single() ) : ?>
    <?php fourohfive_entry_footer(); ?>
  <?php endif; ?>

</article>

