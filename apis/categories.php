<?php

/**
 * The file that defines the WooCommerce user apis class
 *
 * This is used to user related apis
 *
 * @since      1.0.0
 * @package    WC_APIs
 * @subpackage WC_APIs/apis
 * @author     Muhammad Furqan <furqan.khanzada@gmail.com>
 */


class WC_REST_Category_Controller extends WP_REST_Controller {

    /**
     * Register the routes for the objects of the controller.
     */
    public function register_routes() {
        $version = '1';
        $namespace = 'wc-apis/v' . $version;
        $base = 'users';
        register_rest_route( $namespace, '/categories', array(
            'methods' => 'GET',
            'callback' => array( $this, 'get_categories' )
        ));
    }
    /**
     * Get a collection of items
     *
     * @param WP_REST_Request $request Full data about the request.
     * @return WP_Error|WP_REST_Response
     */
   

    function get_categories() {
        $args = array(
            'taxonomy'   => "product_cat"
        );
        $args['exclude'] = get_option( 'default_product_cat' );
        $categories_list = get_terms($args);
    
        return $categories_list;
    }
    /**
     * Get the query params for collections
     *
     * @return array
     */
    public function get_collection_params() {
        return array(
            'page'     => array(
                'description'       => 'Current page of the collection.',
                'type'              => 'integer',
                'default'           => 1,
                'sanitize_callback' => 'absint',
            ),
            'per_page' => array(
                'description'       => 'Maximum number of items to be returned in result set.',
                'type'              => 'integer',
                'default'           => 10,
                'sanitize_callback' => 'absint',
            ),
            'search'   => array(
                'description'       => 'Limit results to those matching a string.',
                'type'              => 'string',
                'sanitize_callback' => 'sanitize_text_field',
            ),
        );
    }
}
