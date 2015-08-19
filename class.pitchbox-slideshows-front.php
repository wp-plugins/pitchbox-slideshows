<?php

if (!defined('ABSPATH')) exit;

class PitchboxSlideShowsFront {
	
	public function __construct() {
		add_action( 'wp_enqueue_scripts', 
					array($this, 'add_pitchbox_frontend_style') );
		add_filter( 'template_include', 
					array($this, 'include_slideshow_template'), 10, 1 );
	}
		
	public function add_pitchbox_frontend_style() {
		global $post;
		if( is_singular() &&
			$post->post_type === 'pitchbox_slideshows' ) {
				$slideshow_settings = maybe_unserialize(
					get_post_meta( $post->ID, '_pitchbox_slideshow_settings', true )
					);
				
				$theme = sanitize_file_name($slideshow_settings['theme']);
				$autoslideduration = 0;
				if ( isset($slideshow_settings['autoslideduration']) )
					$autoslideduration = intval($slideshow_settings['autoslideduration']) * 1000;
				if ( isset($slideshow_settings['transition']) ) {
					$transition = sanitize_text_field($slideshow_settings['transition']);
				} else {
					$transition = 'slide';
				}
				
				wp_enqueue_style( 'pitchbox-base-css',
							plugins_url( 'css/reveal.css', __FILE__ ),
							array(),
							PITCHBOX_SLIDESHOWS_PLUGIN_VERSION );
				wp_enqueue_style( 'pitchbox-theme-css',
							plugins_url( "css/theme/{$theme}.css", __FILE__ ),
							array('pitchbox-base-css'),
							PITCHBOX_SLIDESHOWS_PLUGIN_VERSION );
				wp_enqueue_style( 'pitchbox-zenburn-css',
							plugins_url( "css/lib/zenburn.css", __FILE__ ),
							array('pitchbox-base-css'),
							PITCHBOX_SLIDESHOWS_PLUGIN_VERSION );
				wp_register_script( 'pitchbox-head-js', 
						    plugins_url( 'js/head.min.js', __FILE__ ),
						    array(),
						    PITCHBOX_SLIDESHOWS_PLUGIN_VERSION,
							true );
				wp_register_script( 'pitchbox-reveal-js', 
							plugins_url( 'js/reveal.js', __FILE__ ),
							array(),
							PITCHBOX_SLIDESHOWS_PLUGIN_VERSION,
							true );
				wp_enqueue_script( 'pitchbox-reveal-init-js', 
							plugins_url( 'js/pitchbox-init.js', __FILE__ ),
							array('pitchbox-head-js', 'pitchbox-reveal-js'),
							PITCHBOX_SLIDESHOWS_PLUGIN_VERSION,
							true );
				$init_settings = array( 'settings' => 
									array(	'controls' => true,
											'progress' => true,
											'history' => true,
											'center' => true,
											'width' => 960,
											'height' => 700,
											'embedded' => false,
											'autoSlide' => $autoslideduration,
											'transition' => $transition ) );
				$init_settings = apply_filters(
									'pitchbox_slideshows_init_settings',
									$init_settings,
									$post->ID );
				wp_localize_script( 'pitchbox-reveal-init-js',
									'PitchboxInit',
									$init_settings );
				do_action(  'pitchbox_slideshows_style_and_script', 
							$post->ID, $theme, $slideshow_settings );
			}
	}
	
	public function include_slideshow_template( $template_path ) {
		if ( get_post_type() == 'pitchbox_slideshows' ) {
			if ( is_single() ) {
				if ( $theme_file = locate_template( array ( 'single-pitchbox_slideshows.php' ) ) ) {
					$template_path = $theme_file;
				} else {
					$template_path = plugin_dir_path(  __FILE__ ) . 'templates/single-pitchbox_slideshows.php';
				}
			}
		}
		return $template_path;
	}
}