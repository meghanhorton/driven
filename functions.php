<?php

	/* 
	****
	Call Parent & Child CSS files
	****
	*/
	function theme_enqueue_styles() {
		$parent_style = 'parent-style';

    	wp_enqueue_style( $parent_style, get_template_directory_uri() . '/style.css' );
    	wp_enqueue_style( 'child-style',
	        get_stylesheet_directory_uri() . '/assets/css/driven.css',
	        array( $parent_style )
	    );
	}
	
	add_action( 'wp_enqueue_scripts', 'theme_enqueue_styles' );

	/* 
	****
	Homepage: Set Link Color from Accent Color
	****
	*/
	function driven_color_scheme(){
		$accent_color = get_theme_mod( 'accent_color', false );

		$color_scheme = ".homepage-nav li a{ color: ".$accent_color."}";

		if( $color_scheme ){
			wp_add_inline_style( 'child-style', $color_scheme );
		}
	}

	add_action( 'wp_enqueue_scripts', 'driven_color_scheme' );

	/* 
	****
	Homepage: Add navigation location to homepage
	****
	*/
	register_nav_menus( 
		array('homepage_nav' => 'Homepage Navigation')
	);

	/* 
	****
	Add CustomFields
	****
	*/

	include('_includes/customFields.php');


	
	


?>
