<?php

/**
 * Calls the class on the post edit screen.
 */
function call_someClass() {
    new someClass();
}

if ( is_admin() ) {
    add_action( 'load-post.php', 'call_someClass' );
    add_action( 'load-post-new.php', 'call_someClass' );
}

/** 
 * The Class.
 */
class someClass {

	/**
	 * Hook into the appropriate actions when the class is constructed.
	 */
	public function __construct() {
		add_action( 'add_meta_boxes', array( $this, 'add_meta_box' ) );
		add_action( 'save_post', array( $this, 'save' ) );
	}

	/**
	 * Adds the meta box container.
	 */
	public function add_meta_box( $post_type ) {
		add_meta_box(
			'feature_box_name'
			,__( 'Feature Story Options', 'feature_textdomain' )
			,array( $this, 'render_meta_box_content' )
			,'post'
			,'side'
			,'core'
		);
	}

	/**
	 * Save the meta when the post is saved.
	 *
	 * @param int $post_id The ID of the post being saved.
	 */
	public function save( $post_id ) {
	
		/*
		 * We need to verify this came from the our screen and with proper authorization,
		 * because save_post can be triggered at other times.
		 */

		// Check if our nonce is set.
		if ( ! isset( $_POST['feature_inner_custom_box_nonce'] ) )
			return $post_id;

		$nonce = $_POST['feature_inner_custom_box_nonce'];

		// Verify that the nonce is valid.
		if ( ! wp_verify_nonce( $nonce, 'feature_inner_custom_box' ) )
			return $post_id;

		// If this is an autosave, our form has not been submitted,
                //     so we don't want to do anything.
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) 
			return $post_id;

		// Check the user's permissions.
		if ( 'page' == $_POST['post_type'] ) {

			if ( ! current_user_can( 'edit_page', $post_id ) )
				return $post_id;
	
		} else {

			if ( ! current_user_can( 'edit_post', $post_id ) )
				return $post_id;
		}

		/* OK, its safe for us to save the data now. */

		// Store hideTitle
		$hideTitle = sanitize_text_field( $_POST['feature_hideTitle'] );
		update_post_meta( $post_id, '_feature_hideTitle', $hideTitle );

		// Store hideHeader
		$hideHeader = sanitize_text_field( $_POST['feature_hideHeader'] );
		update_post_meta( $post_id, '_feature_hideHeader', $hideHeader );

		// Store fullWidth
		$fullWidth = sanitize_text_field( $_POST['feature_fullWidth'] );
		update_post_meta( $post_id, '_feature_fullWidth', $fullWidth );
	}


	/**
	 * Render Meta Box content.
	 *
	 * @param WP_Post $post The post object.
	 */
	public function render_meta_box_content( $post ) {
	
		// Add an nonce field so we can check for it later.
		wp_nonce_field( 'feature_inner_custom_box', 'feature_inner_custom_box_nonce' );

		echo '<p>'._e( 'Here you can adjust the display of your post.', 'feature_textdomain' ).'</p>';

		echo '<ul>';

		// Create "Hide Title" Option
		$value = get_post_meta( $post->ID, '_feature_hideTitle', true );
		echo '<li>';
		echo '<label for="feature_hideTitle">';
		echo '<input type="checkbox" id="feature_hideTitle" name="feature_hideTitle" value="true"';
			if(esc_attr($value) == 'true') echo ' checked';
		echo '>';
        echo 'Hide Title</label>';
        echo '</li>';

        // Create "Remove Header Formatting" Option
		$value = get_post_meta( $post->ID, '_feature_hideHeader', true );
		echo '<li>';
		echo '<label for="feature_hideHeader">';
		echo '<input type="checkbox" id="feature_hideHeader" name="feature_hideHeader" value="true"';
			if(esc_attr($value) == 'true') echo ' checked';
		echo '>';
        echo 'Remove Header Formatting</label>';
        echo '</li>';

        // Create "Hide Sidebar" Option
		$value = get_post_meta( $post->ID, '_feature_fullWidth', true );
		echo '<li>';
		echo '<label for="feature_fullWidth">';
		echo '<input type="checkbox" id="feature_fullWidth" name="feature_fullWidth" value="true"';
			if(esc_attr($value) == 'true') echo ' checked';
		echo '>';
        echo 'Hide Sidebar (Full Width)</label> ';
        echo '</li>';

        echo '</ul>';
	}
}