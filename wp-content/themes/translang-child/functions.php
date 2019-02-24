<?php
/**
 * Child-Theme functions and definitions
 */

function translang_child_scripts() {
    wp_enqueue_style( 'translang-parent-style', get_template_directory_uri(). '/style.css' );
}
add_action( 'wp_enqueue_scripts', 'translang_child_scripts' );

?>
