<?php 
    /* Collection of Walker classes */
    
    /* wp_nav_menu()
    
    <div class="menu-container">
        <ul>    // start_lvl()
            <li><a>Link</a><span>description</span></li>    // start_elmt()
            
            <li><a><span>                                   // start_el()
                </a></span></li>                                // end_el()
            
            <li><a>Link</a></li>
            <li><a>Link</a></li>
        </ul>   // end_lvl()
    </div>    
    
    */


// étend la classe
// &$output : & => garde l'array dans la classe d'origine
class Walker_Nav_Primary extends Walker_Nav_Menu {
    
    // create dropdown menu for the 1st level
    function start_lvl(&$output, $depth = 0, $args = array()) {      // <ul>
        $indent = str_repeat("\t", $depth);             // crée une indentation
        $submenu = ($depth > 0) ? ' sub-menu' : '';       // classe par défaut de WP pour le sous-menu si on a au moins un niveau 
        // <ul class="dropdown-menu depth_0">
        $output .= "\n" . $indent . "<ul class=\"dropdown-menu" . $submenu . " depth_" . $depth ."\">\n";
    }
    
    function start_el(&$output, $item, $depth = 0, $args = array(), $id = 0) {       // <li><a><span>
        $indent = ( $depth ) ? str_repeat("\t", $depth) : '';             // crée une indentation
        
        // $li_attributes et $value non utilisés dans l'exemple
        $li_attributes ='';
        $class_names = $value = '';
        
        // ** Enregistre les classes customs des items dans un array
        // récupère les classes WP par défaut si elles existent ('menu-item', 'menu-item-type-post_type'...)
        $classes = empty( $item->classes) ? array() : (array) $item->classes;
        // ajoute la classe BS 'dropdown' si l'item est un sous-menu
        $classes[] = ($args->walker->has_children) ? 'dropdown' : '';
        // ajoute la classe BS 'active' si l'item ou un de ses sous-items est actif sur la page courante
        $classes[] = ($item->current || $item->current_item_ancestor) ? 'active' : '';
        // ajoute la classe WP par défaut connecté à l'ID
        $classes[] = 'menu-item-' . $item->ID;
        // ajoute la classe BS 'dropdown-submenu' en cas de sous-menu multiples
        $classes[] = ($depth && $args->walker->has_children) ? 'dropdown-submenu' : '';
        // !!!! debug !!!
//        echo "<br>• " . join(" ", $classes);
        
        // merge les classes
        $class_names = join( ' ', apply_filters('nav_menu_css_class', array_filter($classes), $item, $args ) );
        $class_names = ' class="' . esc_attr($class_names) . '"';
        
        // récupère l'id
        $id = apply_filters('nav_menu_item_id', 'menu-item-'.$item->ID, $item, $args);
        $id = strlen( $id ) ? ' id="' . esc_attr($id) . '"' : '';
        
        // crée le code <li id="menu-item-XX" class="XX">
        $output .= "\n" . $indent . '<li' . $id . $value . $class_names . $li_attributes . '>';
        
        // ** Crée les attributs de la balise <a>
        $attributes = ! empty( $item->attr_title ) ? ' title="' . esc_attr($item->attr_title) . '"' : '';
        $attributes .= ! empty( $item->target ) ? ' target="' . esc_attr($item->target) . '"' : '';
        $attributes .= ! empty( $item->xfn ) ? ' rel="' . esc_attr($item->xfn) . '"' : '';
        $attributes .= ! empty( $item->url ) ? ' href="' . esc_attr($item->url) . '"' : '';
        // ajoute la classe BS 'dropdown-toggle' si l'item est un sous-menu
        $attributes .= ( $args->walker->has_children ) ? ' class="dropdown-toggle" data-toggle="dropdown"' : '';
        
        // inclus les classes par défaut de WP
        $item_output = $args->before;
        $item_output .= '<a' . $attributes . '>';
        $item_output .= $args->link_before . apply_filters( 'the_title', $item->title, $item->ID) . $args->link_after;
        // ajoute la classe BS 'caret' si l'item est un sous-menu
        $item_output .= ( $depth == 0 && $args->walker->has_children) ? ' <b class="caret"></b></a>' : '</a>';
        $item_output .= $args->after;
        
        $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args);
    }
    
    /*
    function end_el() {         // </li></a></span>
        
    }
    function end_lvl() {        // </ul>
        
    }
    */
}
