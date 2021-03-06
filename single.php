<?php
/**
 * The template for displaying all single posts.
 *
 * @package Cinnamon
 */

// hideTitle, hideHeader, fullWidth
if( get_post_meta( get_the_ID() , '_feature_fullWidth' , true ) == 'true' || 
	get_post_meta( get_the_ID() , '_feature_hideHeader' , true ) == 'true' || 
	get_post_meta( get_the_ID() , '_feature_hideTitle' , true ) == 'true' )
	{
	get_header('meta');
} else{
	get_header();
}

?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

		<?php while ( have_posts() ) : the_post(); ?>

			<?php get_template_part( 'content', 'single' ); ?>

			<?php cinnamon_post_nav(); ?>

			<?php
				// If comments are open or we have at least one comment, load up the comment template
				if ( comments_open() || get_comments_number() ) :
					comments_template();
				endif;
			?>

		<?php endwhile; // end of the loop. ?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php 
// Hide Sidebar if fullWidth = true
if( get_post_meta( get_the_ID() , '_feature_fullWidth' , true ) != 'true' ){ get_sidebar(); } ?>
<?php get_footer(); ?>
