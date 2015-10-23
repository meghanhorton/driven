<?php
/*
 * Template Name: Home Splash Page (No Content)
 */

get_header('splash'); ?>

<div class="homepage">
	<div class="homepage-logo">
		<?php the_post_thumbnail('large');?>
	</div>
	<?php wp_nav_menu( array( 'theme_location' => 'homepage_nav', 'container_class' => 'homepage-nav' , 'depth' => 1) ); ?>
</div>

<?php get_footer('splash'); ?>
