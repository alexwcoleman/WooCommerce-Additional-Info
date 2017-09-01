<?php
function awc_scripts() {
    if( is_product() ){
        wp_enqueue_script( 'measurement-calc', get_stylesheet_directory_uri() . '/js/measurement-converter.js', array( 'jquery' ) );
    }
}
add_action( 'wp_enqueue_scripts', 'awc_scripts' );

add_filter( 'script_loader_tag', 'wsds_defer_scripts', 10, 3 );
function wsds_defer_scripts( $tag, $handle, $src ) {

	// The handles of the enqueued scripts we want to defer
	$defer_scripts = array( 
		'measurement-calc',
	);

    if ( in_array( $handle, $defer_scripts ) ) {
        return '<script src="' . $src . '" defer="defer" type="text/javascript"></script>' . "\n";
    }
    
    return $tag;
}