<?php

add_filter('wp_pwa_get_site_info', 'get_site_info');

function get_title_home_wpseo() {
  $wpseo_frontend = WPSEO_Frontend_To_REST_API::get_instance();

  return $wpseo_frontend->get_title_from_options( 'title-home-wpseo' );
}

function get_metadesc_home_wpseo() {
  $wpseo_frontend = WPSEO_Frontend_To_REST_API::get_instance();
  $wpseo_replace_vars = new WPAPI_WPSEO_Replace_Vars();
  //Generate metadesc-home-wpseo
  $metadesc = $wpseo_frontend->options['metadesc-home-wpseo'];
  $post_data     = array();
  $omit = array();
  if ( empty( $metadesc ) ) {
    $metadesc = get_bloginfo( 'description' );
  }
  return $wpseo_replace_vars->replace( $metadesc, $post_data, $omit );
}

function get_site_info($site_info) {
  $site_info['homepage_title'] = get_title_home_wpseo();
  $site_info['homepage_metadesc'] = get_metadesc_home_wpseo();

  return $site_info;
 }
