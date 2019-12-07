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


class WC_REST_Product_Controller extends WP_REST_Controller {

    /**
     * Register the routes for the objects of the controller.
     */
    public function register_routes() {
        $version = '1';
        $namespace = 'wc-apis/v' . $version;
        $base = 'users';
        register_rest_route( $namespace, '/newarrivals', array(
            'methods' => 'GET',
            'callback' => array( $this, 'get_newarrivals' )
        ));
        register_rest_route( $namespace, '/products', array(
            'methods' => 'GET',
            'callback' => array( $this, 'get_product' )
        ));
        register_rest_route( $namespace, '/currency', array(
            'methods' => 'GET',
            'callback' => array( $this, 'get_currency_symbol' )
        ));
        register_rest_route( $namespace, '/currency', array(
            'methods' => 'GET',
            'callback' => array( $this, 'get_currency_symbol' )
        ));
    }
    /**
     * Get a collection of items
     *
     * @param WP_REST_Request $request Full data about the request.
     * @return WP_Error|WP_REST_Response
     */
   
    function get_newarrivals(WP_REST_Request $request) {
        $lang = $request->get_param('lang');
        $args = array(
            'post_type' => 'product',
            'stock' => 1,
            'orderby' =>'date',
            'order' => 'DESC' );
            $products = wc_get_products( $args );
            $response = [];
            foreach($products as $product ){
                $response[] = array_merge($product->get_data(), [
                    'thumbnail' => wp_get_attachment_url( $product->get_image_id())
                ]);
            }
            return wpm_translate_value( $response, $lang );
            // return $response;
    }

    function get_currency_symbol(WP_REST_Request $request) {
        return get_woocommerce_currency_symbol();
    }
    function get_product(WP_REST_Request $request) {
        // $meta_query = [];
        // $tax_query = [];
        // $min_price = json_decode($request->get_param('min_price'));
        // $max_price = json_decode($request->get_param('max_price'));
        // $category_id = json_decode($request->get_param('category_id'));
        // if($category_id){
        //     $tax_query[] = array(
        //         array(
        //             'taxonomy'      => 'product_cat',
        //             'field' => 'term_id', //This is optional, as it defaults to 'term_id'
        //             'terms'         => $category_id,
        //             'operator'      => 'IN' // Possible values are 'IN', 'NOT IN', 'AND'.
        //         ),
        //         array(
        //             'taxonomy'      => 'product_visibility',
        //             'field'         => 'slug',
        //             'terms'         => 'exclude-from-catalog', // Possibly 'exclude-from-search' too
        //             'operator'      => 'NOT IN'
        //         )
        //     );
        // }
        // if(!$min_price && $max_price){
        //     $meta_query[] = wc_get_min_max_price_meta_query(array(
        //         'max_price' => $max_price
        //     ));
        // }
        // if($min_price && !$max_price){
        //     $meta_query[] = wc_get_min_max_price_meta_query(array(
        //         'min_price' => $min_price
        //     ));
        // }
        // if($min_price && $max_price){
        //     $meta_query[] = wc_get_min_max_price_meta_query(array(
        //         'min_price' => $min_price,
        //         'max_price' => $max_price
        //     ));
        // }
          
        //   $query = array(
        //     'post_status'     => 'publish',
        //     'post_type'       => 'product',
        //     'posts_per_page'  => -1,
        //     'meta_query'      => $meta_query,
        //     'tax_query'       => $tax_query
        //   );
        //   $wpquery = new WP_Query($query);
        //   return $wpquery->get_posts();

        $lang = $request->get_param('lang');
        $args = array();
        $products = wc_get_products( $args );
        $response = [];
        foreach($products as $product ){
            
            $response[] = array_merge($product->get_data(), [
                'thumbnail' => wp_get_attachment_url( $product->get_image_id())
            ]);
        }
        // return wpm_translate_value( $response );
    //    return wpm_translate_object($response[0], wpm_get_default_language());
        return wpm_translate_value( $response, $lang );
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
