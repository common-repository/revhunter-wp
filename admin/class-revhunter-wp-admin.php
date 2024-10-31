<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://revhunter.pl/
 * @since      1.0.0
 *
 * @package    Revhuner_Wp
 * @subpackage Revhuner_Wp/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Revhuner_Wp
 * @subpackage Revhuner_Wp/admin
 * @author     Revhunter <hello@revhunter.pl>
 */
class Revhuner_Wp_Admin
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
     * @param string $plugin_name The name of this plugin.
     * @param string $version The version of this plugin.
     * @since    1.0.0
     */
    public function __construct($plugin_name, $version)
    {

        $this->plugin_name = $plugin_name;
        $this->version = $version;

    }

    public function check_that_woocommerce_is_active()
    {
        if (is_admin() && current_user_can('activate_plugins') && !is_plugin_active('woocommerce/woocommerce.php')) {
            add_action('admin_notices', 'child_plugin_notice');

            deactivate_plugins(plugin_basename('revhunter-wp/revhunter-wp.php'));

            if (isset($_GET['action']) && $_GET['action'] == 'activate') {
                unset($_GET['action']);
            }
        }

        function child_plugin_notice()
        {
            ?>
            <style>
                div#message.updated {
                    display: none;
                }
            </style>
            <div class="error">
                <p><?= __('To activate this plugin you need to install and activate the WooCommerce plugin.', 'revhunter-wp') ?></p>
            </div>
            <?php
        }
    }

    public function revhunter_admin_menu()
    {
        add_menu_page(
            __('Revhunter', 'revhunter-settings'),
            __('Revhunter', 'revhunter-settings'),
            'manage_options',
            'revhunter',
            'admin_revhunter_page_function',
            'dashicons-performance',
            64
        );

        function admin_revhunter_page_function()
        {
            ?>
            <h1> <?php esc_html_e('Revhunter', 'revhunter-wp'); ?> </h1>
            <form method="POST" action="options.php">
                <?php
                settings_fields('revhunter');
                do_settings_sections('revhunter');
                submit_button();
                ?>
            </form>
            <?php
        }

    }

    public function revhunter_settings_init()
    {

        add_settings_section(
            'revhunter_setting_section',
            __('Set up your store with the Revhunter system', 'revhunter-wp'),
            null,
            'revhunter'
        );

        add_settings_field(
            'revhunter_account_id',
            __('Account ID in Revhunter: ', 'revhunter-wp'),
            'input_markup',
            'revhunter',
            'revhunter_setting_section'
        );

        register_setting('revhunter', 'revhunter_account_id');

        function input_markup()
        {
            ?>
            <input type="text" id="revhunter_account_id" name="revhunter_account_id"
                   value="<?= get_option('revhunter_account_id'); ?>">
            <?php
        }

    }

}
