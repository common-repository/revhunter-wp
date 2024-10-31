<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://revhunter.pl/
 * @since      1.0.0
 *
 * @package    Revhuner_Wp
 * @subpackage Revhuner_Wp/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Revhuner_Wp
 * @subpackage Revhuner_Wp/public
 * @author     Revhunter <hello@revhunter.pl>
 */
class Revhuner_Wp_Public
{

    /**
     * The ID of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string $plugin_name The ID of this plugin.
     */
    private $plugin_name;

    /**
     * The version of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string $version The current version of this plugin.
     */
    private $version;

    /**
     * Initialize the class and set its properties.
     *
     * @param string $plugin_name The name of the plugin.
     * @param string $version The version of this plugin.
     * @since    1.0.0
     */
    public function __construct($plugin_name, $version)
    {

        $this->plugin_name = $plugin_name;
        $this->version = $version;

    }

    public function revhunter_home_pixel()
    {
        $revhunterPixelId = get_option('revhunter_account_id');
        if ($revhunterPixelId != null && is_home()) {
            echo '<img src="https://app.revhunter.tech/px/' . $revhunterPixelId . '?type=start" width="0" height="0"/>';
        }
    }

    public function revhunter_product_category_pixel()
    {
        $revhunterPixelId = get_option('revhunter_account_id');
        if ($revhunterPixelId != null && function_exists('is_product_category') && is_product_category()) {
            $queriedObject = get_queried_object();
            $categoryId = $queriedObject->term_id;
            if ($categoryId != null) {
                echo '<img src="https://app.revhunter.tech/px/' . $revhunterPixelId . '?type=start&category=' . $categoryId . '" width="0" height="0"/>';
            }
        }
    }

    public function revhunter_product_pixel()
    {
        $revhunterPixelId = get_option('revhunter_account_id');
        if ($revhunterPixelId != null && function_exists('is_product') && is_product()) {
            $queriedObject = get_queried_object();
            $productId = $queriedObject->ID;
            $terms = get_the_terms($productId, 'product_cat');
            $categoriesIds = [];
            foreach ($terms as $term) {
                $categoriesIds[] = $term->term_id;
            }
            if ($productId != null) {
                echo '<img src="https://app.revhunter.tech/px/' . $revhunterPixelId . '?type=start&product=' . $productId . '&category=' .
                    implode(',', $categoriesIds) . '" width="0" height="0"/>';
            }
        }
    }

    public function revhunter_cart_pixel()
    {
        $revhunterPixelId = get_option('revhunter_account_id');
        if ($revhunterPixelId != null && function_exists('is_cart') && is_cart()) {
            echo '<img src="https://app.revhunter.tech/px/' . $revhunterPixelId . '?type=cart" width="0" height="0"/>';
        }
    }

    public function revhunter_order_pixel()
    {
        $revhunterPixelId = get_option('revhunter_account_id');
        if ($revhunterPixelId != null && function_exists('is_order_received_page') && is_order_received_page()) {
            global $wp;
            $order_id = absint($wp->query_vars['order-received']);
            $order = new WC_Order($order_id);
            $total = number_format($order->get_total(), 2, '.', '');
            if ($order->get_id() != null && $total != null) {
                echo '<img src="https://app.revhunter.tech/px/'. $revhunterPixelId .'?type=stop&o='. $order->get_id() .'&b='. $total .'" width="0" height="0"/>';
            }
        }
    }

}
