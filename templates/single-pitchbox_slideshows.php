<!DOCTYPE html>
<html <?php language_attributes(); ?>>
	<head>
	<title><?php wp_title(); ?></title>
	<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
		<meta name="apple-mobile-web-app-capable" content="yes" />
	<meta name="apple-mobile-web-app-status-bar-style" content="black-translucent" />

	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no, minimal-ui">

<?php wp_head(); ?>	<!--[if lt IE 9]>	<!-- <script src="<?php echo plugins_url( "js/lib/html5shiv.js", dirname(__FILE__) ) ; ?>"></script>			<![endif]--><?php			$slides = maybe_unserialize(		get_post_meta(get_the_ID(), '_pitchbox_slides', true) );	$slideshow_settings = maybe_unserialize(		get_post_meta( $post->ID, '_pitchbox_slideshow_settings', true) );	if ( isset($slideshow_settings['theme']) ) {		$slideshow_theme = $slideshow_settings['theme'];	} else { $slideshow_theme = ''; }?>
	</head>
	<body><?php printf('<div class="reveal %s %s" id="pitchbox-reveal">',				esc_attr($slideshow_theme),				esc_attr('custom-'. $post->ID)); 		do_action('pitchbox_slideshows_thumbnail_display', $post->ID, $slideshow_settings);?>	
	<div class="slides" id="pitchbox-slides">
<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); 
		foreach ($slides as $key => $slide) {			$use_slideshow_transition = isset($slide['use_slideshow_transition']) ?				$slide['use_slideshow_transition'] : 'no';			if ($use_slideshow_transition === 'yes') {				$section = '<section';			} else {				$section = printf('<section%s',								isset($slide['transition']) ?								' data-transition="'. esc_attr($slide['transition']) .'" ' : '');			}			$section = apply_filters('pitchbox_slideshows_section_display', $section, $slides[$key] );			$section .= '>';			echo $section;			echo do_shortcode( wpautop( htmlspecialchars_decode($slides[$key]['content'])) );			echo '</section>';
		} 	endwhile; else : ?>
	<section><p><?php
	_e( 'Sorry, no SlideShow found.' ); ?>	</p></section>
<?php endif; ?>
	</div>
</div><?php wp_footer(); ?>		
</body>
</html>