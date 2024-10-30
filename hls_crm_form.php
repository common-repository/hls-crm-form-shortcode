<?php

/*

 * Plugin Name: HelloLeads CRM Form Shortcode

 * Plugin URI: https://www.helloleads.io/

 * Description: This plugin provide you the shotcode of all the form which has been created into the HelloLeads CRM
   You can see all the form and their shortcode once you are connected via your email and token via plugin config menu.

 * Author: HelloLeads

 * Text Domain: https://www.helloleads.io/

 * Version: 1.0

 * Requires at least: 4.4

 * Tested up to: 6.1

 */

defined( 'ABSPATH' ) or exit;



  add_action('plugins_loaded', 'hls_crmf_load_hlol_scrape_plugin');

  function hls_crmf_load_hlol_scrape_plugin() {

    define('HLS_CRMF_US_PLUGIN_URL', plugin_dir_url(__FILE__));
    define('HLS_CRMF_US_PLUGIN_DIR', plugin_dir_path(__FILE__));

    define('HLS_CRMF_US_GETLEADLIST_URL', 'https://app.helloleads.io/index.php/private/api/lists');
    define('HLS_CRMF_US_CREATELEAD_URL', 'https://app.helloleads.io/index.php/private/api/leads');
     

      require_once HLS_CRMF_US_PLUGIN_DIR . '/inc/loader.php';
      
  }





 /*-------------------------------------------------------------------
| Activation Hook 
 --------------------------------------------------------------------*/


  register_activation_hook(__FILE__, 'hls_crmf_hlol_us_activate_print');

  function hls_crmf_hlol_us_activate_print() {

      
  }





  /*-------------------------------------------------------------------
  | Deactivate Hook 
  --------------------------------------------------------------------*/

  register_deactivation_hook(__FILE__, 'hls_crmf_hlol_us_deactivation_event');

  function hls_crmf_hlol_us_deactivation_event() {

  }


  /*-------------------------------------------------------------------
  | Uninstalled Hook 
  --------------------------------------------------------------------*/
  function hls_crmf_hlol_us_plugin_uninstall(){
     

  }

  register_uninstall_hook(__FILE__, 'hls_crmf_hlol_us_plugin_uninstall');




?>