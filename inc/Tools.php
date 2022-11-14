<?php

// ==============================================

//        CLASS TOOLS

// ==============================================


class Tools {

  // Set href and target attributes for links only if they exist
  public static function setLinkAttributes( $link ) {
    $atts = '';
    if( !empty($link['url']) ) {
      $atts .= 'href="'.esc_url( $link['url'] ).'"';
    }
    if( !empty($link['target']) ) {
      $atts .= ' target="'.esc_attr( $link['target'] ).'"';
      if( $link['target'] == '_blank' ) $atts .= ' rel="noopener"';
    }
    echo $atts;
  } 

  // Echo alt attribute for images only if it exists
  public static function imageAlt( $alt ) {
    if ( !empty($alt) ) {
      echo 'alt="'.esc_attr( $alt ).'"';
    }
  }  

  // Echo target attribute for links only if it exists
  public static function get_target( $target ) {
    if ( $target ) {
      echo 'target="'.esc_attr( $target ).'"';
    }
  }  


  // Show posts pagination with format [«] [‹] [1][2][3] [›] [»]
  public static function posts_pagination( $pages_max = '', $range = 1 ) {
    $showitems = ( $range * 2 ) + 1;    // 5 pages to display

    global $paged;
    if( empty( $paged ) ) $paged = 1;

    if( $pages_max == '' ) {
      global $wp_query;
      $pages_max = $wp_query->max_num_pages;
  		echo "pages_max ".$pages_max;
      if( !$pages_max ) {
        $pages_max = 1;
      }
    }

  	$html = '';

    if( $pages_max > 1 ) {
      $html .= "<ul class='pagination'>";

      // [«] button -> go to first page
      if( $paged > 2 && $paged > $range+1 && $showitems < $pages_max ) {
        $html .= "<li><a href='".get_pagenum_link( 1 )."' class='pagination__link arrow reverse'>".
  			"<svg class='icon'><use xlink:href='#icon-chevron-double'></use></svg>"."</a></li>";
  		}
      // [‹] button -> go to prev page
      if( $paged > 1 && $showitems < $pages_max ) {
  			$html .= "<li><a href='".get_pagenum_link( $paged - 1 )."' class='pagination__link arrow reverse'>".
  			"<svg class='icon'><use xlink:href='#icon-chevron'></use></svg>"."</a></li>";
  		}

      // [1] [2] 3 [4] [5]
      for ( $i = 1; $i <= $pages_max; $i++ ) {
        if ( 1 != $pages_max &&( !( $i >= $paged+$range+1 || $i <= $paged-$range-1 ) || $pages_max <= $showitems )) {
          $html .= ( $paged == $i ) ? "<li><span class='pagination__current'>".$i."</span></li>"
                              : "<li><a href='".get_pagenum_link( $i )."' class='pagination__link' >".$i."</a></li>";
        }
      }

      // [›] button -> go to next page (&rsaquo;)
      if ( $paged < $pages_max && $showitems < $pages_max ) {
        $html .= "<li><a href='".get_pagenum_link( $paged + 1 )."' class='pagination__link arrow'>".
  			"<svg class='icon'><use xlink:href='#icon-chevron'></use></svg>"."</a></li>";
  		}
      // [»] button -> go to last page (&raquo;)
      if ( $paged < $pages_max-1 &&  $paged+$range-1 < $pages_max && $showitems < $pages_max ) {
  			$html .= "<li><a href='".get_pagenum_link( $pages_max )."' class='pagination__link arrow'>".
  			"<svg class='icon'><use xlink:href='#icon-chevron-double'></use></svg>"."</a></li>";
  		}

      $html .= "</ul>\n";
  		echo $html;
    } else {
  		// echo "just one page";
  	}
  }


  // Truncate text after a whole word
  public static function truncate_text( $text, $max_length, $ellipsis = '…' ) {
  	$length = strlen( $text );

  	if( $length > $max_length ) {
  		$text = substr( $text, 0, $max_length );
  		$text = explode( ' ', $text );
  		array_pop( $text );
  		$text = implode( ' ', $text ).$ellipsis;
  	}
  	return $text;
  }

}
