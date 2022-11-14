<?php

// ==============================================

//        BREADCRUMBS

// ==============================================


// Truncate text after a whole word

// Breadcrumbs
function custom_breadcrumbs() {

    // Settings
    $separator          = '/';
    $breadcrums_id      = 'breadcrumbs';
    $breadcrums_class   = 'breadcrumbs';
    $home_title         = 'Accueil';

    // If you have any custom post types with custom taxonomies, put the taxonomy name below (e.g. product_cat)
    $custom_taxonomy    = 'product_cat';

    // Get the query & post information
    global $post,$wp_query;

    // Do not display on the homepage
    if ( !is_front_page() ) {

        // Build the breadcrums
        echo '<ol id="' . $breadcrums_id . '" class="' . $breadcrums_class . '">';

        // Home page
        echo '<li class="item-home"><a href="' . get_home_url() . '">' . $home_title . '</a></li>';
        echo '<li class="separator separator-home"> ' . $separator . ' </li>';

        if ( is_archive() && !is_tax() && !is_category() && !is_tag() ) {

            echo '<li class="item-current item-archive"><strong>' . post_type_archive_title($prefix, false) . '</strong></li>';

        } else if ( is_archive() && is_tax() && !is_category() && !is_tag() ) {

            // If post is a custom post type
            $post_type = get_post_type();

            // If it is a custom post type display name and link
            if( $post_type != 'post' ) {

                $post_type_object = get_post_type_object( $post_type );
                $post_type_archive = get_post_type_archive_link ($post_type );

                echo '<li class="item-cat item-custom-post-type-' . $post_type . '"><a href="' . $post_type_archive . '">' . $post_type_object->labels->name . '</a></li>';
                echo '<li class="separator"> ' . $separator . ' </li>';

            }

            $custom_tax_name = get_queried_object()->name;
            echo '<li class="item-current item-archive"><strong>' . $custom_tax_name . '</strong></li>';

        } else if ( is_single() ) {

            // If post is a custom post type
            $post_type = get_post_type();

            // If it is a custom post type display name and link
            if($post_type != 'post') {

                $post_type_object = get_post_type_object( $post_type) ;
                $post_type_archive = get_post_type_archive_link( $post_type );
                
                // ∆∆∆∆∆∆∆∆∆
                $page_jobs_index = get_field( 'page_jobs_index', 'options' );
                $page_jobs_index_link = get_permalink( $page_jobs_index );
                echo '<li class="item-cat item-custom-post-type-' . $post_type . '"><a href="' . $page_jobs_index_link . '">' . $post_type_object->labels->name . '</a></li>';
                // echo '<li class="item-cat item-custom-post-type-' . $post_type . '"><a href="' . $post_type_archive . '">' . $post_type_object->labels->name . '</a></li>';
                // ∆∆∆∆∆∆∆∆∆

                echo '<li class="separator"> ' . $separator . ' </li>';

            }

            // Get post category info
            $category = get_the_category();

            if( !empty($category) ) {

                // Get last category post is in
                $array_values = array_values($category);
                $last_category = end($array_values);

                // Get parent any categories and create array
                $get_cat_parents = rtrim(get_category_parents($last_category->term_id, true, ','),',');
                $cat_parents = explode(',',$get_cat_parents);

                // Loop through parent categories and store in variable $cat_display
                $cat_display = '';
                // ∆∆∆∆∆∆
                $page_actualites = get_field( 'page_actualites', 'options' );
                $actus_link = '<a href="'. get_permalink( $page_actualites ).'">'. get_the_title( $page_actualites ).'</a>';
                // ∆∆∆∆∆∆
                $cat_display .= '<li class="item-cat">'. $actus_link .'</li>';
                $cat_display .= '<li class="separator"> ' . $separator . ' </li>';
                // foreach($cat_parents as $parents) {
                //     $cat_display .= '<li class="item-cat">'.$parents.'</li>';
                //     $cat_display .= '<li class="separator"> ' . $separator . ' </li>';
                // }
            }

            // If it's a custom post type within a custom taxonomy
            $taxonomy_exists = taxonomy_exists($custom_taxonomy);
            if(empty($last_category) && !empty($custom_taxonomy) && $taxonomy_exists) {

                $taxonomy_terms = get_the_terms( $post->ID, $custom_taxonomy );
                $cat_id         = $taxonomy_terms[0]->term_id;
                $cat_nicename   = $taxonomy_terms[0]->slug;
                $cat_link       = get_term_link($taxonomy_terms[0]->term_id, $custom_taxonomy);
                $cat_name       = $taxonomy_terms[0]->name;
            }

            // Check if the post is in a category
            if(!empty($last_category)) {
                echo $cat_display;
                echo '<li class="item-current item-' . $post->ID . '"><strong>' . get_the_title() . '</strong></li>';

            // Else if post is in a custom taxonomy
            } else if(!empty($cat_id)) {

                echo '<li class="item-cat item-cat-' . $cat_id . ' item-cat-' . $cat_nicename . '"><a href="' . $cat_link . '">' . $cat_name . '</a></li>';
                echo '<li class="separator"> ' . $separator . ' </li>';
                echo '<li class="item-current item-' . $post->ID . '"><strong>' . get_the_title() . '</strong></li>';

            } else {

                echo '<li class="item-current item-' . $post->ID . '"><strong>' . get_the_title() . '</strong></li>';

            }

        } else if ( is_category() ) {
            // Category page
            echo '<li class="item-current item-cat"><strong>' . single_cat_title('', false) . '</strong></li>';

        } else if ( is_page() ) {

            // Standard page
            if( $post->post_parent ){

                // If child page, get parents
                $anc = get_post_ancestors( $post->ID );

                // Get parents in the right order
                $anc = array_reverse($anc);

                // Parent page loop
                if ( !isset( $parents ) ) $parents = null;
                foreach ( $anc as $ancestor ) {
                    $parents .= '<li class="item-parent item-parent-' . $ancestor . '"><a href="' . get_permalink($ancestor) . '">' . get_the_title($ancestor) . '</a></li>';
                    $parents .= '<li class="separator separator-' . $ancestor . '"> ' . $separator . ' </li>';
                }

                // Display parent pages
                echo $parents;

                // Current page
                echo '<li class="item-current item-' . $post->ID . '"><strong> ' . get_the_title() . '</strong></li>';

            } else {

                // Just display current page if not parents
                echo '<li class="item-current item-' . $post->ID . '"><strong> ' . get_the_title() . '</strong></li>';

            }

        } else if ( is_tag() ) {

            // Tag page

            // Get tag information
            $term_id        = get_query_var('tag_id');
            $taxonomy       = 'post_tag';
            $args           = 'include=' . $term_id;
            $terms          = get_terms( $taxonomy, $args );
            $get_term_id    = $terms[0]->term_id;
            $get_term_slug  = $terms[0]->slug;
            $get_term_name  = $terms[0]->name;

            // Display the tag name
            echo '<li class="item-current item-tag-' . $get_term_id . ' item-tag-' . $get_term_slug . '"><strong>' . $get_term_name . '</strong></li>';

        } elseif ( is_day() ) {

            // Day archive

            // Year link
            echo '<li class="item-year item-year-' . get_the_time('Y') . '"><a href="' . get_year_link( get_the_time('Y') ) . '">' . get_the_time('Y') . ' Archives</a></li>';
            echo '<li class="separator separator-' . get_the_time('Y') . '"> ' . $separator . ' </li>';

            // Month link
            echo '<li class="item-month item-month-' . get_the_time('m') . '"><a href="' . get_month_link( get_the_time('Y'), get_the_time('m') ) . '">' . get_the_time('M') . ' Archives</a></li>';
            echo '<li class="separator separator-' . get_the_time('m') . '"> ' . $separator . ' </li>';

            // Day display
            echo '<li class="item-current item-' . get_the_time('j') . '"><strong> ' . get_the_time('jS') . ' ' . get_the_time('M') . ' Archives</strong></li>';

        } else if ( is_month() ) {

            // Month Archive

            // Year link
            echo '<li class="item-year item-year-' . get_the_time('Y') . '"><a href="' . get_year_link( get_the_time('Y') ) . '">' . get_the_time('Y') . ' Archives</a></li>';
            echo '<li class="separator separator-' . get_the_time('Y') . '"> ' . $separator . ' </li>';

            // Month display
            echo '<li class="item-month item-month-' . get_the_time('m') . '"><strong>' . get_the_time('M') . ' Archives</strong></li>';

        } else if ( is_year() ) {

            // Display year archive
            echo '<li class="item-current item-current-' . get_the_time('Y') . '"><strong>' . get_the_time('Y') . ' Archives</strong></li>';

        } else if ( is_author() ) {

            // Auhor archive

            // Get the author information
            global $author;
            $userdata = get_userdata( $author );

            // Display author name
            echo '<li class="item-current item-current-' . $userdata->user_nicename . '"><strong>' . 'Author: ' . $userdata->display_name . '</strong></li>';

        } else if ( get_query_var('paged') ) {

            // Paginated archives
            echo '<li class="item-current item-current-' . get_query_var('paged') . '"><strong>'.__('Page') . ' ' . get_query_var('paged') . '</strong></li>';

        } else if ( is_search() ) {

            // Search results page
            echo '<li class="item-current item-current-' . get_search_query() . '"><strong>'.pl_e( 'Résultat des recherches' )."&nbsp;" . get_search_query() . '</strong></li>';

        } elseif ( is_404() ) {

            // 404 page
            echo '<li>' . 'Page 404' . '</li>';
        }

        echo '</ol>';

    }

}

?>
