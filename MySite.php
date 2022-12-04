<?php
/**
 * We're going to configure our theme inside of a subclass of Timber\Site
 * You can move this to its own file and include here via php's include("MySite.php")
 */
class StarterSite extends Timber\Site {
	/** Add timber support. */
	public function __construct() {
		add_filter( 'timber/context', array( $this, 'add_to_context' ) );
		add_filter( 'timber/twig', array( $this, 'add_to_twig' ) );
		parent::__construct();
	}
	

	/** This is where you add some context
	 *	
	 * @param string $context context['this'] Being the Twig's {{ this }}.
	 */
	public function add_to_context( $context ) {
		// $context['foo']   = 'bar';
		// $context['stuff'] = 'I am a value set in your functions.php file';
		// $context['notes'] = 'These values are available everytime you call Timber::context();';
		$context['site']  = $this;
		$context['nav_primary']  = new Timber\Menu( 'primary' );
		$context['nav_footer']  = new Timber\Menu( 'footer' );
		$context['nav_legal']  = new Timber\Menu( 'legal' );
		$context['nav_social']  = new Timber\Menu( 'social' );

		// $context['favicon_link']  = get_template_directory_uri() . '/images';			// Ex: <link rel="icon" href="{{ favicon_link }}favicon.svg" type="image/svg+xml">
		$context['favicon_link']  = FAVICON_URL;			// Ex: <link rel="icon" href="{{ favicon_link }}favicon.svg" type="image/svg+xml">
		$context['image_link']  = IMAGE_URL;
		$context['svg_link']  = SVG_URL;
		$context['svg_sprite']  = SVG_PATH . 'sprite.svg';
		$context['acf_options'] = get_fields('option');

						$context['page_news_link'] = get_post_type_archive_link('post');
						$context['page_projects_link'] = get_post_type_archive_link('project');

		// Retourne l'url de la page contact localisé (lien dans le header)
		$page_contact     = get_field( 'page_contact', 'options' );
		$page_contact     = pl_get_post( $page_contact->ID );   // localize contact page
		$context['page_contact'] = $page_contact;
		// $page_contact_url = get_permalink( $page_contact );

		return $context;
	}

	

	/** This Would return 'foo bar!'.
	 *
	 * @param string $text being 'foo', then returned 'foo bar!'.
	 */



	public function function_getRwdImage( $attachment_id, $name='default', $size='full', $attr='' ) {
		if ( function_exists( 'get_rwd_image' ) ) {
			return get_rwd_image( $attachment_id, $name, $size, $attr );
		}
	}


	// set src, alt, width and height attributes on images if needed
	public function function_setImgAttributes( $item ) {
		$atts = '';

		if ( isset($item["url"]) && !empty($item["url"]) ) {
			$atts .= 'src="'.esc_url( $item["url"] ).'"';
		}

		if ( isset($item["alt"]) && !empty($item["alt"]) ) {
			$atts .= ' alt="' . esc_attr( $item["alt"] ).'"';
		}

		if ( isset($item["width"]) && !empty($item["width"]) ) {
			$atts .= ' width="' . esc_attr( $item["width"] ).'"';
		}

		if ( isset($item["height"]) && !empty($item["height"]) ) {
			$atts .= ' height="' . esc_attr( $item["height"] ).'"';
		}
		return $atts;
	}

	// set href and target attributes on links if needed
	public function function_setLinkAttributes( $item ) {
		$atts = '';
		$tt = gettype($item);

		if( gettype($item) == 'object') {
			if ( isset($item->url) && !empty($item->url) ) {
				$atts .= 'href="'.esc_url( $item->url ).'"';
			}
	
			if ( isset($item->target) && !empty($item->target) ) {
				$atts .= ' target="' . esc_attr( $item->target ).'"';
				if( $item->target == '_blank' ) $atts .= ' rel="noopener"';
			}
		// ACF link
		} else {
			if ( isset($item["url"]) && !empty($item["url"]) ) {
				$atts .= 'href="'.esc_url( $item["url"] ).'"';
			}
	
			if ( isset($item["target"]) && !empty($item["target"]) ) {
				$atts .= ' target="' . esc_attr( $item["target"] ).'"';
				if( $item["target"] == '_blank' ) $atts .= ' rel="noopener"';
			}
		}
		return $atts;
	}

	// get pll translation 
	public function function_pll( $string = '' ) {
		if ( function_exists( 'pll__' ) ) {
			return pll__( $string );
		}
		return $string;
	}

	// Dump and mehods filters
	public function filter_dump( $var ) {
    var_dump( $var );
  }
  public function filter_methods( $object ) {
    var_dump( get_class_methods( $object ) );
  }

	// Colorise en bleu une partie d'un titre délimité par des crochets (Mon titre [en bleu] et noir)
  public function filter_titleColor( $string ) {
		if (str_contains($string, '[')) {
				$pattern = ['[', ']'];
				$replace = ['<span class="alt-color">', '</span>'];
				$string = str_replace($pattern, $replace, $string);
		} 
		return $string;
  }
	

	/** This is where you can add your own functions to twig.
	 *
	 * @param string $twig get extension.
	 */
	public function add_to_twig( $twig ) {
		$twig->addExtension( new Twig\Extension\StringLoaderExtension() );
		// $twig->addFilter( new Twig\TwigFilter( 'myfoo', array( $this, 'myfoo' ) ) );

		if( defined('WP_DEBUG') && WP_DEBUG === true ) {
      $twig->addFilter( new Twig\TwigFilter( 'dump', [$this, 'filter_dump'] ) );
      $twig->addFilter( new Twig\TwigFilter( 'methods', [$this, 'filter_methods'] ) );
    }
		$twig->addFilter( new Twig\TwigFilter( 'titleColor', [$this, 'filter_titleColor'] ) );


		// Adding a function.
    $twig->addFunction( new Timber\Twig_Function( 'pll__', [$this, 'function_pll'] ) );
    $twig->addFunction( new Timber\Twig_Function( 'setLinkAttributes', [$this, 'function_setLinkAttributes'] ) );
    $twig->addFunction( new Timber\Twig_Function( 'setImgAttributes', [$this, 'function_setImgAttributes'] ) );
    $twig->addFunction( new Timber\Twig_Function( 'getRwdImage', [$this, 'function_getRwdImage'] ) );
    

		return $twig;
	}
}