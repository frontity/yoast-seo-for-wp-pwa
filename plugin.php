<?php
/**
 * Plugin Name: Yoast SEO for WordPress PWA
 * Description: Makes Yoast SEO settings available to WordPress PWA using the REST API.
 * Author: Pablo Postigo, Luis Herranz, Niels Garve, Tedy Warsitha, Charlie Francis
 * Version: 1.6.0
 * Plugin URI: https://github.com/wp-pwa/yoast-seo-for-wp-pwa
 */

class Yoast_To_REST_API {
	function __construct() {
		add_action('rest_api_init', array($this, 'add_yoast_data'));
		add_filter('rest_prepare_latest', array($this, 'add_yoast_to_latest'));
	}

	function add_yoast_data() {
		// Custom post types (including posts and pages):
		$types = get_post_types(array('public' => true ));
		foreach ($types as $key => $type) {
			register_rest_field($type, 'yoast_meta',
				array(
					'get_callback'    => array($this, 'wp_api_encode_yoast'),
					'update_callback' => null,
					'schema'          => null,
				)
			);
		}

		// Add custom taxonomies (including category and tag).
		$taxonomies = get_taxonomies(array('public' => true));
		foreach ($taxonomies as $key => $taxonomy) {
			if ($taxonomy === 'post_tag') $taxonomy = 'tag';
			register_rest_field($taxonomy, 'yoast_meta',
				array(
					'get_callback'    => array($this, 'wp_api_encode_yoast_taxonomy'),
					'update_callback' => null,
					'schema'          => null,
				)
			);
		}
	}

	function get_home_title() {
    $wpseo_frontend = WPSEO_Frontend_To_REST_API::get_instance();
    return $wpseo_frontend->get_title_from_options('title-home-wpseo');
	}

	function get_post_type_title($post_type) {
		$wpseo_frontend = WPSEO_Frontend_To_REST_API::get_instance();
		$args = array('post_type' => $post_type);
		$GLOBALS['wp_query'] = new WP_Query($args);
		return $wpseo_frontend->public_get_post_type_archive_title();
	}

	function wp_api_encode_yoast( $p, $field_name, $request ) {
		$wpseo_frontend = WPSEO_Frontend_To_REST_API::get_instance();
		$args = array('p' => $p['id'], 'post_type' => 'any');
		$GLOBALS['wp_query'] = new WP_Query($args);
		return array(
			'title' => $wpseo_frontend->get_content_title(),
		);
	}

	function wp_api_encode_yoast_taxonomy($tag){
		$wpseo_frontend = WPSEO_Frontend_To_REST_API::get_instance();
	  $args = array('tag_id' => $tag['id']);
	  $GLOBALS['wp_query'] = new WP_Query($args);
		return array(
			'title' => $wpseo_frontend->get_taxonomy_title(),
		);
	 }

	function add_yoast_to_latest($data) {
		if ($data['id'] === 'post') {
			$title = $this->get_home_title();
		} else {
			$title = $this->get_post_type_title($data['id']);
		}
		$data['yoast_meta'] = array(
			'title' => $title
		);
		return $data;
	}
}

function WPAPIYoast_init() {
	if ( class_exists( 'WPSEO_Frontend' ) ) {
		require_once(plugin_dir_path( __FILE__ ) . '/classes/class-wpseo-frontend-to-rest-api.php');
		$yoast_To_REST_API = new Yoast_To_REST_API();
	} else {
		add_action( 'admin_notices', 'wpseo_not_loaded' );
	}
}

function wpseo_not_loaded() {
	printf(
		'<div class="error"><p>%s</p></div>',
		__( '<b>Yoast SEO for WordPress PWA</b> plugin not working because <b>Yoast SEO</b> plugin is not active.' )
	);
}

add_action( 'plugins_loaded', 'WPAPIYoast_init' );
