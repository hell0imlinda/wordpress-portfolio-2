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


<article id="post-<?php the_ID(); ?>" <?php post_class(' mb-4'); ?>>



	<div class="-block">
		<?php the_title( '<h1 class="-title display-4">', '</h1>' ); ?>
		<h2 class="-subtitle h6 mb-4 text-muted"><?php the_author(); ?> on <?php the_time('F jS, Y') ?></h2>

		<?php
			the_content( sprintf(
				__( 'Continue reading<span class="screen-reader-text"> "%s"</span>', 'four-oh-five' ),
				get_the_title()
			) );

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

