<?php
  /*
    Template Name: Page de contact
    Template Post Type: page
  */


$context = Timber::context();

$timber_post     = new Timber\Post();
$context['post'] = $timber_post;
Timber::render( 'template-contact.twig' , $context );

