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


class WC_REST_Payment_Controller extends WP_REST_Controller {

    /**
     * Register the routes for the objects of the controller.
     */
    public function register_routes() {
        $version = '1';
        $namespace = 'wc-apis/v' . $version;
        $base = 'users';
        register_rest_route( $namespace, '/payments', array(
            'methods' => 'GET',
            'callback' => array( $this, 'get_payment_methods' )
        ));
        register_rest_route( $namespace, '/countries', array(
            'methods' => 'GET',
            'callback' => array( $this, 'get_countries' )
        ));
        register_rest_route( $namespace, '/states', array(
            'methods' => 'GET',
            'callback' => array( $this, 'get_states' )
        ));
        register_rest_route( $namespace, '/shipping', array(
            'methods' => 'GET',
            'callback' => array( $this, 'get_shipping_methods' )
        ));
    }
    /**
     * Get a collection of items
     *
     * @param WP_REST_Request $request Full data about the request.
     * @return WP_Error|WP_REST_Response
     */
    
    function get_shipping_methods() {
        return WC()->shipping;
    }
    function get_payment_methods() {
        $gateways = WC()->payment_gateways->get_available_payment_gateways();
        $enabled_gateways = [];
        if( $gateways ) {
            foreach( $gateways as $gateway ) {
        
                if( $gateway->enabled == 'yes' ) {
        
                    $enabled_gateways[] = $gateway;
        
                }
            }
        }
        return $enabled_gateways;
    }

    function get_countries(WP_REST_Request $request) {
        global $woocommerce;
        $countries_obj = new WC_Countries();
        $countries = $countries_obj->get_countries();
        return $countries;
    }

    function get_states(WP_REST_Request $request) {
        global $woocommerce;
        $countries_obj   = new WC_Countries();
        $countries   = $countries_obj->__get('countries');
        $default_country = explode("-", $request['code']);
        $default_county_states = $countries_obj->get_states( $default_country[0] );
        if($default_county_states != false || $default_county_states = []){
            return $default_county_states;
        } else {
            return [];
        }
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
