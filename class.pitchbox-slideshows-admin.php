<?php
if (!defined('ABSPATH')) exit;
class PitchboxSlideShowsAdmin {
	
	public static function init() {
    	register_post_type( 'pitchbox_slideshows',
			array(
				'labels' => array(
					'name' => __( 'SlideShows', 'pitchbox-slideshows' ),
					'singular_name' => __( 'SlideShow', 'pitchbox-slideshows' ),
					'search_items' => __('Search for SlideShows', 'pitchbox-slideshows'),
					'not_found' => __('No SlideShow found', 'pitchbox-slideshows'),
					'not_found_in_trash' => __('No SlideShow found in Trash', 'pitchbox-slideshows'),
					),
				'public' => true,
				'supports' => ('title'),
				'has_archive' => true,
				'rewrite' => array('slug' => _x('slideshows','Slug used in permalinks')),
				'menu_icon' => plugins_url( 'images/icon.png', __FILE__ )
			)
		);
	}

	public function add_builder_mb( ) {
		add_meta_box(
			($this->_slides) ? 'pitchbox_slideshows_builder_2' : 'pitchbox_slideshows_builder',
			__( 'Build your SlideShow :', 'pitchbox-slideshows' ),
			array($this, 'builder_mb_render'),
			'pitchbox_slideshows',
			($this->_slides) ? 'side' : 'normal',
		);
	}
	public function save_data( $post_id, $post ) {
		if ( 'pitchbox_slideshows' !== $post->post_type )
		{ return; }
		else {
			if ( isset( $_POST["pitchbox_slideeditor"] ) &&
				
				foreach ( $_POST["pitchbox_slideeditor"] as $key => $slide ) {
					$slides[$key]['content'] = wp_kses_post(
				}
				update_post_meta($post_id, '_pitchbox_slides', $slides );
			}
  
}

?>