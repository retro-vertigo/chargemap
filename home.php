<?php
/**
 * The template for displaying Archive pages.
 *
 * Used to display archive-type pages if nothing more specific matches a query.
 * For example, puts together date-based pages if no date.php file exists.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * Methods for TimberHelper can be found in the /lib sub-directory
 *
 * @package  WordPress
 * @subpackage  Timber
 * @since   Timber 0.2
 */


$context = Timber::context();

// get blog posts 
// global $paged;
// if (!isset($paged) || !$paged){
//     $paged = 1;
// }
$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
$posts_per_page = get_option( 'posts_per_page' );
// $posts_per_page = 6;		// ∆∆∆∆
$args = array(
  'post_type'      => 'post',
  'posts_per_page' => $posts_per_page,
  'paged'          => $paged,
  'order'          => 'DESC',
  'post_status'    => 'publish',
);
$query = new Timber\PostQuery( $args );
$context['posts'] = $query;


// Object with query params and props for LoadMore.js 
$loadmore_params = array(
  'found_posts'    => $query->found_posts,                           // posts_max  --> total number of posts
  'max_num_pages'  => ceil($query->found_posts / $posts_per_page),   // pages_max  --> total number of pages
  'posts_per_page' => $posts_per_page,
  'paged'          => $paged,
  'post_type'      => 'post',
  'taxonomy'       => 'category',
  'card_partial'   => 'card-news',                                   // partial with cards to output in load-more.php 
); 
$context['loadmore_params'] = $loadmore_params;


// get terms for filters button
$args = array(
  'taxonomy'   => 'category',
  'orderby'    => 'count',
  'order'      => 'DESC',
  'hide_empty' => 1
);
$context['post_terms'] = Timber::get_terms( $args );

Timber::render( 'archive-news.twig', $context );