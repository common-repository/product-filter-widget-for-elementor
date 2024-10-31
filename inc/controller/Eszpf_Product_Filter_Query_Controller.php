<?php

class Eszpf_Product_Filter_Query_Controller {
    private $eszlwcf_product_query;
    private $eszlwcf_product_args;
    private $eszlwcf_products;
    private $eszlwcf_product_metas;

    public function __construct() {
        $this->init();
    }

    protected function init() {
        $this->eszlwcf_product_metas = $this->eszlwcf_get_product_metas();
        $this->eszlwcf_product_query = $this->eszlwcf_get_query_data();
        $this->eszlwcf_products = $this->eszlwcf_get_products();
        $this->eszlwcf_product_args = $this->eszlwcf_products_args();
    }

    public function eszlwcf_filters_query_data() {
        $data = array();
        $data['eszlwcf_products'] = $this->eszlwcf_products;
        $data['eszlwcf_product_query'] = $this->eszlwcf_product_query;
        return $data;
    }

    protected function eszlwcf_products_args() {
        return array('post_type' => 'product', 'posts_per_page' => -1);
    }

    public function eszlwcf_get_query_data($args_data = array(), $settings = array()) {
        $args = array(
            'post_type' => 'product',
            'posts_per_page' => 9
        );
        if (!empty($settings)) {
            if ($settings['posts_per_page'] === 0):
                $args['posts_per_page'] = -1;
            else:
                $args['posts_per_page'] = $settings['posts_per_page'];
            endif;
            $i = 0;
            foreach ($settings as $key => $value):
                if (strpos($key, 'include_select') !== false && !empty($value)) :
                    if ($i <= 0)
                        $args['tax_query']['relation'] = 'OR';
                    $args['tax_query'][] = array(
                        'taxonomy' => trim(str_replace('include_select_', '', $key)),
                        'field' => 'slug',
                        'terms' => $value,
                    );
                    $i++;
                endif;
            endforeach;
        }
        $the_query = new \WP_Query($args);
        $this->eszlwcf_product_query = $the_query;
        return $the_query;
    }

    public function eszlpf_get_product_query() {
        return $this->eszlwcf_product_query;
    }

    public function eszlwcf_get_products($args = array()) {
        if (!empty($args)) {
            $args = array_merge($this->eszlwcf_product_args, $args);
        } else {
            $args = $this->eszlwcf_product_args;
        }
        $products = get_posts($args);
        return $products;
    }

    public function eszlwcf_get_product_metas($args = array()) {
        $metas = array();
        $products = $this->eszlwcf_get_products($args);
        if (!empty($products)):
            foreach ($products as $product):
                $meta[] = get_post_meta($product->ID);
                $metas['_price'][$product->ID] = get_post_meta($product->ID, '_price', true);
                $metas['_stock_status'][$product->ID] = get_post_meta($product->ID, '_stock_status', true);
                $metas['_wc_average_rating'][$product->ID] = get_post_meta($product->ID, '_wc_average_rating', true);
            endforeach;
        endif;
        return $metas;
    }

    public function eszlwcf_get_all_product_metas() {
        return $this->eszlwcf_get_product_metas($this->eszlwcf_product_args);
    }

}

