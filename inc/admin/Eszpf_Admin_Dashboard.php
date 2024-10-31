<?php

class Eszpf_Admin_Dashboard {

    public function __construct() {
        add_action('admin_menu', [$this, 'eszlwcf_cerate_admin_page'], 9);
    }

    public function eszlwcf_cerate_admin_page() {
        add_menu_page(
            'Product Filter',
            'Product Filter',
            'administrator',
            'esz-product-filter-for-elementor',
            array($this, 'esz_display_plugin_admin_dashboard'),
            'dashicons-store',
            65
        );
    }

    public function esz_display_plugin_admin_dashboard() { ?>
    <?php }
}

$admin_page = new Eszpf_Admin_Dashboard();