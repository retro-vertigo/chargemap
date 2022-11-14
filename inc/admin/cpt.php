<?php

// ==============================================

//        CUSTOM POST TYPES

// ==============================================


// Create custom post type
// -----------------------------------------------

add_action( 'init', 'pga_add_cpt_project' );
function pga_add_cpt_project() {
  $labels = array(
    'name'               => 'Références',
    'menu_name'          => 'Références',
    'singular_name'      => 'Référence',
    'all_items'          => 'Toutes les références',
    'add_new'            => 'Ajouter une référence',
    'add_new_item'       => 'Ajouter une nouvelle référence',
    'edit_item'          => 'Modifier la référence',
    'view_item'          => 'Voir la référence',
    'view_items'         => 'Voir les références',
        'new_item'       => '___New item#',
    'search_items'       => 'Rechercher dans les références',
    'not_found'          => 'Aucune référence trouvée.',
    'not_found_in_trash' => 'Aucune référence trouvée dans la poubelle.',
  );
  $args = array(
    'labels'            => $labels,
    'show_in_rest'      => true,                                                        // active gutenberg editor
    'has_archive'       => true,
    'hierarchical'      => false,
    'public'            => true,
    'show_in_nav_menus' => true,
    'show_in_admin_bar' => false,
    'rewrite'           => array( 'slug' => 'references' ),
    
    'supports'      => array(
      'title',
      'editor',
      'revisions',
      'thumbnail',
    ),
    'taxonomies'    => array( 'cat_project' ),
    'menu_position' => 8,      // below pages
    'menu_icon'     => 'dashicons-awards',
  );
  register_post_type( 'project', $args );
}



// Create custom taxonomy
// -----------------------------------------------

add_action( 'init', 'pga_add_tax_cat_project' );
function pga_add_tax_cat_project() {
  $labels = array(
    'name'                       => 'Catégories de projet',
    'singular_name'              => 'Catégorie',
    'add_new_item'               => 'Ajouter une nouvelle catégorie',
    'all_items'                  => 'Toutes les catégories',
    'edit_item'                  => 'Modifier la catégorie',
    'update_item'                => 'Mettre à jour la catégorie',
    'new_item_name'              => 'Nom de la nouvelle catégorie',
        'view_item'              => '#View catégorie',
    'search_items'               => 'Rechercher dans les catégories',
    'not_found'                  => 'Aucune catégorie trouvée.',
    'back_to_items'              => '&larr; Retour aux catégories', 
    
    // for non hierarchical only 
    'separate_items_with_commas' => 'Séparez les catégorie par des virgules',
    'choose_from_most_used'      => 'Choisir parmis les catégories les plus utilisées.',
  );

  $args = array(
    'labels'            => $labels,
    'show_in_rest'      => true,
    'show_admin_column' => true,
    'show_in_nav_menus' => false,
    'hierarchical' => true,
  );
  register_taxonomy( 'cat_project', 'project', $args );
}



?>
