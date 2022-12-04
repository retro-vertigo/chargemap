<?php

// ==============================================

//        MANAGE RESPONSIVE IMAGES

// ==============================================

// source : https://cfxdesign.com/efficient-responsive-images-in-wordpress
// Set img sizes attribute depending on template design
add_filter( 'responsive_image_sizes', 'custom_responsive_image_sizes', 10, 3 );
function custom_responsive_image_sizes( $sizes, $img_name, $attachment_id ) {
  $sizes  = wp_get_attachment_image_sizes( $attachment_id, 'original' );
  $meta   = wp_get_attachment_metadata( $attachment_id );
  $width  = $meta['width'];
  if( !$width ) return $sizes;

  switch ( $img_name ) {

    // sizes="(max-width: 500px) 100vw, (max-width: 900px) 50vw, 800px"

    case 'cover':
      $sizes = '(max-width: 564px) 100vw,
                564px';
                break;


    case 'card-webinar':
      $sizes = '(max-width: 576px) 90vw
                (max-width: 940px) 370px,
                564px';
                break;

    case 'card-zoom':
      $sizes = '174px';
                break;

    case 'logo':
      $sizes = '200px';
                break;


  }
  return preg_replace( '/\s+/', ' ', $sizes );
}


/**
 * Get an HTML img element representing an image attachment while allowing
 * custom image names and individual size/srcset filtering
 *
 * @param int          $attachment_id Image attachment ID.
 * @param string       $name          Optional. Custom image name used for filtering purposes. Default
 *                                    'default'.
 * @param string|array $size          Optional. Image size. Accepts any valid image size, or an array of width
 *                                    and height values in pixels (in that order). Default 'original'.
 * @param string|array $attr          Optional. Attributes for the image markup. Default are filtered responsive
 *                                    attributes.
 * @return string HTML img element or empty string on failure.
 */
function get_rwd_image( $attachment_id, $name='default', $size='full', $attr='' ) {
  if( !$attachment_id ) return false;

  // image not available
  $src = wp_get_attachment_image_src( $attachment_id, $size );
  if( !$src ) return false;

  // set img sizes attribute
  $default_attr = array(
    // 'srcset' => apply_filters( 'responsive_image_srcset', false, $name, $attachment_id ),
    'sizes'  => apply_filters( 'responsive_image_sizes', false, $name, $attachment_id )
  );

  // merge srcset / sizes attributes with other attributes (classes, data, alt...)
  $attr = wp_parse_args( $attr, $default_attr );
  $img  = wp_get_attachment_image( $attachment_id, $size, false, $attr );

  return $img;
}


?>
