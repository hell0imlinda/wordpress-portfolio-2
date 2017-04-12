<?php
/**
 * Template part for displaying page content in page.php
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Four_Oh_Five
 * @since 1.0
 * @version 1.0
 */

?>

<?php if ( has_post_thumbnail() && ( is_single() || ( is_page() && ! fourohfive_is_frontpage() ) ) ) : ?>
	<div style="background: url(<?php the_post_thumbnail_url( 'full' ); ?>) center center no-repeat; background-size: cover; -webkit-transform: translate3d(0,0,0); translate3d(0,0,0); background-attachment: fixed; height: 50vh;">
	</div>
<?php endif; ?>

<div class="container py-4">
	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		<header>
			<?php the_title( '<h1 class="display-4">', '</h1>' ); ?>
		</header>
		<div class="entry-content">
			<?php
				the_content();

				fourohfive_edit_link( get_the_ID() );

				if ( comments_open() || get_comments_number() ) :
					comments_template();
				endif;
			?>
		</div>
	</article>
</div>
