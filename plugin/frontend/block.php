<?php
namespace Sgdg\Frontend\Block;

function register() {
	if ( function_exists( 'register_block_type' ) ) {
		add_action( 'init', '\\Sgdg\\Frontend\\Block\\add' );
	}
}

function add() {
	wp_register_script( 'sgdg_block', plugins_url( '/skaut-google-drive-gallery/frontend/js/block.js' ), [ 'wp-blocks', 'wp-element' ] );
	wp_localize_script( 'sgdg_block', 'sgdg_block_localize', [
		'block_name'        => esc_html__( 'Google Drive gallery', 'skaut-google-drive-gallery' ),
		'block_description' => esc_html__( 'A WordPress gallery using Google Drive as file storage', 'skaut-google-drive-gallery' ),
		'root_name'         => esc_html__( 'Google Drive gallery', 'skaut-google-drive-gallery' ),
		'ajax_url'          => admin_url( 'admin-ajax.php' ),
		'nonce'             => wp_create_nonce( 'sgdg_editor_plugin' ),
	]);
	register_block_type( 'skaut-google-drive-gallery/gallery', [
		'editor_script'   => 'sgdg_block',
		'render_callback' => '\\Sgdg\\Frontend\\Block\\html',
	] );
}

function html( $attributes ) {
	$atts = [ 'path' => '' ];
	if ( isset( $attributes['path'] ) ) {
		$atts['path'] = implode( '/', json_decode( $attributes['path'] ) );
	}
	return \Sgdg\Frontend\Shortcode\render( $atts );
}
