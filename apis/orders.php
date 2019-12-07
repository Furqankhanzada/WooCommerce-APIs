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


class WC_REST_Order_Controller extends WP_REST_Controller {

    /**
     * Register the routes for the objects of the controller.
     */
    public function register_routes() {
        $version = '1';
        $namespace = 'wc-apis/v' . $version;
        $base = 'users';
        register_rest_route( $namespace, '/orders', array(
            'methods' => 'POST',
            'callback' => array( $this, 'add_order')
        ));
    }
    /**
     * Get a collection of items
     *
     * @param WP_REST_Request $request Full data about the request.
     * @return WP_Error|WP_REST_Response
     */
   

    function add_order(WP_REST_Request $request) {
        global $woocommerce;
        $first_name = $request->get_param('firstname');
        $last_name = $request->get_param('lastname');
        $email = $request->get_param('email');
        $phone = $request->get_param('phone');
        $address_1 = $request->get_param('address');
        $city = $request->get_param('city');
        $state = $request->get_param('state');
        $postcode = $request->get_param('postalCode');
        $country = $request->get_param('country');
        $cart = $request->get_param('cart');
        $cart = json_decode($cart);
        $address = array(
            'first_name' => $first_name,
            'last_name'  => $last_name,
            'email'      => $email,
            'phone'      => $phone,
            'address_1'  => $address_1,
            'city'       => $city,
            'state'      => $state,
            'postcode'   => $postcode,
            'country'    => $country
        );
        // // Now we create the order
        $order = wc_create_order();
        $order->set_address( $address, 'billing' );
        foreach ($cart as &$value) {
            $order->add_product( get_product($value->id), 1); // This is an existing SIMPLE product
        }
        $order->update_status('on-hold');
        $order->calculate_totals();
        return $order;
        // The add_product() function below is located in /plugins/woocommerce/includes/abstracts/abstract_wc_order.php
        // $order->add_product( get_product('275962'), 1); // This is an existing SIMPLE product
        // //
    }

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
