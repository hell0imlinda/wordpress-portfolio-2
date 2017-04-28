<?php

/**
 * Get WP Flexslider option
 * @access public
 */
function wp_flexslider_get_option( $key = ''){

	$option = get_option( 'wp_flexslider', apply_filters( 'wp_flexslider_default_options', array(
        'animation' => 'slide',
        'autoplay'  => 'on', 
        'loop'      => 'on',
        'animation_speed'   => 600,
        'slideshow_speed'   => 7000,
        'direction_nav'     => 'true',
        'control_nav'       => 'true',
        'smooth_height'       => 'on',

    ) ) );

	if( $key && isset( $option['key'] ) ){
		return $option['key'];
	}

	return $option;
}

// add_shortcode( 'wp_flexslider', 'wp_flexslider_shortcode' );
add_filter( 'post_gallery', 'wp_flexslider_shortcode', 1001 , 2);
/**
 * WP Flexslider shortcode
 * Trick Jetpack carousel by using priority greater than 1000
 *
 * @since 1.0
 * @access public
 */
if( !function_exists( 'wp_flexslider_shortcode') ):
	
	function wp_flexslider_shortcode( $output, $attr ){

	    if( empty( $attr['type'] ) )
			$attr['type'] = 'default';

		if( !in_array( $attr['type'], array( 'flexslider') ) )
			return $output;

		wp_enqueue_style( 'flexslider' );
		wp_enqueue_style( 'wp-flexslider' );
		wp_enqueue_script( 'flexslider' );
		wp_enqueue_script( 'wp-flexslider' );

		$post = get_post();

		static $instance = 0;

		$instance++;

		if ( ! empty( $attr['ids'] ) ) {
			// 'ids' is explicitly ordered, unless you specify otherwise.
			if ( empty( $attr['orderby'] ) )
				$attr['orderby'] = 'post__in';
			$attr['include'] = $attr['ids'];
		}

		// We're trusting author input, so let's at least make sure it looks like a valid orderby statement
		if ( isset( $attr['orderby'] ) ) {
			$attr['orderby'] = sanitize_sql_orderby( $attr['orderby'] );
			if ( ! $attr['orderby'] ) {
				unset( $attr['orderby'] );
			}
		}

		$atts = shortcode_atts( array(
			'order'      => 'ASC',
			'orderby'    => 'menu_order ID',
			'id'         => $post ? $post->ID : 0,
			'size'		 => 'thumbnail',
			'include'    => '',
			'exclude'    => '',
			'link'       => ''
		), $attr, 'gallery' );

		$id = intval( $atts['id'] );
		if ( 'RAND' == $atts['order'] ) {
			$atts['orderby'] = 'none';
		}

		if ( ! empty( $atts['include'] ) ) {
			$_attachments = get_posts( array( 'include' => $atts['include'], 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $atts['order'], 'orderby' => $atts['orderby'] ) );

			$attachments = array();
			foreach ( $_attachments as $key => $val ) {
				$attachments[$val->ID] = $_attachments[$key];
			}
		} elseif ( ! empty( $atts['exclude'] ) ) {
			$attachments = get_children( array( 'post_parent' => $id, 'exclude' => $atts['exclude'], 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $atts['order'], 'orderby' => $atts['orderby'] ) );
		} else {
			$attachments = get_children( array( 'post_parent' => $id, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $atts['order'], 'orderby' => $atts['orderby'] ) );
		}

		if ( empty( $attachments ) ) {
			return '';
		}

		if ( is_feed() ) {
			$output = "\n";
			foreach ( $attachments as $att_id => $attachment ) {
				$output .= wp_get_attachment_link( $att_id, $atts['size'], true ) . "\n";
			}
			return $output;
		}

		$selector = "gallery-{$instance}";

		$gallery_style = '';

		$flex_data = wp_flexslider_get_option();

		$slider_settings = apply_filters( 'wp_flexslider_default_gallery_settings', array(
			'animation' 	=> ( $flex_data['animation'] === 'slide' ? 'slide' : 'fade' ),
			'slideshow'		=> ( !empty( $flex_data['autoplay'] ) ? true : false ),
			'animationLoop'	=> ( !empty( $flex_data['loop'] ) ? true : false ),
			'animationSpeed'=> ( !empty( $flex_data['animation_speed'] ) ? intval( $flex_data['animation_speed'] ) : 600 ),
			'slideshowSpeed'=> ( !empty( $flex_data['slideshow_speed'] ) ? intval( $flex_data['slideshow_speed'] ) : 7000 ),
			'directionNav' 	=> ( $flex_data['direction_nav'] === 'true' ? true : false ),
			'controlNav' 	=> ( $flex_data['control_nav'] === 'true' ? true : false ),
			'smoothHeight'	=> ( !empty( $flex_data['smooth_height'] ) ? true : false )
		), 'gallery');
		$class = "gallery-{$attr['type']}";
		// class='gallery galleryid-{$id}'
		$gallery_div = "<div id='" . esc_attr( $selector ) . "' class='flexslider wp-flexslider " . esc_attr( $class ) ."' data-flex-settings='" . esc_attr( json_encode( $slider_settings ) ) . "'>
			<ul class='slides'>";
		/**
		 * Filter the default gallery shortcode CSS styles.
		 *
		 * @since 2.5.0
		 *
		 * @param string $gallery_style Default gallery shortcode CSS styles.
		 * @param string $gallery_div   Opening HTML div container for the gallery shortcode output.
		 */
		$output = apply_filters( 'gallery_style',  $gallery_div );

		$i = 0;
		foreach ( $attachments as $id => $attachment ) {
			if ( ! empty( $atts['link'] ) && 'file' === $atts['link'] ) {
				$image_output = wp_get_attachment_link( $id, $atts['size'], false, false );
			} elseif ( ! empty( $atts['link'] ) && 'none' === $atts['link'] ) {
				$image_output = wp_get_attachment_image( $id, $atts['size'], false );
			} else {
				$image_output = wp_get_attachment_link( $id, $atts['size'], true, false );
			}

			if( $attachment->post_excerpt || $attachment->post_content){
				$image_output .= '<div class="flex-caption">';
				$image_output .= $attachment->post_excerpt ? "<div class=\"gallery-excerpt\">{$attachment->post_excerpt}</div>" : '';
				
				$image_output .= $attachment->post_content ? "<div class=\"gallery-content\">{$attachment->post_content}</div>" : '';
				$image_output .= '</div>';
			}
			
			$image_meta  = wp_get_attachment_metadata( $id );

			$orientation = '';
			if ( isset( $image_meta['height'], $image_meta['width'] ) ) {
				$orientation = ( $image_meta['height'] > $image_meta['width'] ) ? 'portrait' : 'landscape';
			}
			//  class='gallery-item {$orientation}'
			$output .= '<li><div class="flex-slide">';
			$output .= $image_output;
			$output .= "</li></li>";
		}

		$output .= "</ul>
			</div>\n";

		return $output;

	}
endif;