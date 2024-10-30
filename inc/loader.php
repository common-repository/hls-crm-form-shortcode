<?php



class HLSCRMFORM {  

    
   /*---------------------------------------------------------
   |  Construct function for adding hook
   ----------------------------------------------------------*/

    public function __construct() {

    // ini_set('display_errors', 1);
    // ini_set('display_startup_errors', 1);
    // error_reporting(E_ALL);
        
     add_action( 'admin_menu', array($this,'hls_crmf_hlo_add_admin_page'), 10 );
     
     add_action( 'wp_ajax_nopriv_hls_crmf_check_credentials', array($this,'hls_crmf_check_credentials') );
     add_action( 'wp_ajax_hls_crmf_check_credentials', array($this,'hls_crmf_check_credentials' ) );

     add_action( 'wp_ajax_nopriv_hls_crmf_save_list', array($this,'hls_crmf_save_list') );
     add_action( 'wp_ajax_hls_crmf_save_list', array($this,'hls_crmf_save_list' ) );

     add_action( 'wp_ajax_nopriv_hls_crmf_reset_crm_config', array($this,'hls_crmf_reset_crm_config') );
     add_action( 'wp_ajax_hls_crmf_reset_crm_config', array($this,'hls_crmf_reset_crm_config' ) );

     add_shortcode('HLS_CRM_FORM', array($this,'generate_crm_form_shortcode') );

     add_action( 'admin_enqueue_scripts', array($this,'hls_crm_enqueue_admin_style' ),20 );
     add_action( 'wp_head', array($this,'hls_wp_script' ),20 );

 

    }


     /*--------------------------------------------------------
    | add js/css admin
    ----------------------------------------------------------*/



    public function hls_wp_script(){

          wp_register_script( 'hls_crm_js_intl', plugin_dir_url( __FILE__ ) . 'template/js/intial.js', false, '1.0.0' );
          wp_enqueue_script( 'hls_crm_js_intl' );
    }


    public  function hls_crm_enqueue_admin_style() {

        wp_register_style( 'hls_crm_dtbl_css', plugin_dir_url( __FILE__ ) . 'template/css/jquery.dataTables.min.css', false, '1.0.0' );
        wp_register_style( 'hls_crm_btstp_css', plugin_dir_url( __FILE__ ). 'template/css/bootstrap.min.css', false, '1.0.0' );
        wp_register_style( 'hls_crm_tstr_css', plugin_dir_url( __FILE__ ) . 'template/css/toastr.css', false, '1.0.0' );
        wp_register_style( 'hls_crm_styl_css', plugin_dir_url( __FILE__ ) . 'template/css/style.css', false, '1.0.0' );
        wp_register_style( 'hls_crm_ftws_css', plugin_dir_url( __FILE__ ) . 'template/css/font-awesome.min.css', false, '1.0.0' );

        wp_register_script( 'hls_crm_js_btstrp', plugin_dir_url( __FILE__ ). 'template/js/bootstrap.min.js', false, '1.0.0' );
        wp_register_script( 'hls_crm_js_dttbl', plugin_dir_url( __FILE__ ) . 'template/js/jquery.dataTables.min.js', false, '1.0.0' );
        wp_register_script( 'hls_crm_js_dtbtn', plugin_dir_url( __FILE__ ) . 'template/js/dataTables.buttons.min.js', false, '1.0.0' );
        wp_register_script( 'hls_crm_js_jszip', plugin_dir_url( __FILE__ ) . 'template/js/jszip.min.js', false, '1.0.0' );
        wp_register_script( 'hls_crm_js_pdfmk', plugin_dir_url( __FILE__ ) . 'template/js/pdfmake.min.js', false, '1.0.0' );
        wp_register_script( 'hls_crm_js_vsfnt', plugin_dir_url( __FILE__ ) . 'template/js/vfs_fonts.js', false, '1.0.0' );
        wp_register_script( 'hls_crm_js_tstr', plugin_dir_url( __FILE__ ) . 'template/js/toastr.js', false, '1.0.0' );
        wp_register_script( 'hls_crm_js_vldt', plugin_dir_url( __FILE__ ) . 'template/js/jquery.validate.js', false, '1.0.0' );
        wp_register_script( 'hls_crm_js_cstm', plugin_dir_url( __FILE__ ) . 'template/js/custom.js', false, '1.0.0' );
        
        
        wp_enqueue_script( 'hls_crm_js_btstrp' );
        wp_enqueue_script( 'hls_crm_js_dttbl' );
        wp_enqueue_script( 'hls_crm_js_dtbtn' );
        wp_enqueue_script( 'hls_crm_js_jszip' );
        wp_enqueue_script( 'hls_crm_js_pdfmk' );
        wp_enqueue_script( 'hls_crm_js_vsfnt' );
        wp_enqueue_script( 'hls_crm_js_tstr' );
        wp_enqueue_script( 'hls_crm_js_vldt' );
        wp_enqueue_script( 'hls_crm_js_cstm' );
        
        
        wp_enqueue_style( 'hls_crm_dtbl_css' );
        wp_enqueue_style( 'hls_crm_btstp_css' );
        wp_enqueue_style( 'hls_crm_tstr_css' );
        wp_enqueue_style( 'hls_crm_styl_css' );
        wp_enqueue_style( 'hls_crm_ftws_css' );

      }



    /*---------------------------------------------------------
    |  Create  Shortcode  HLS CRM Form
    ----------------------------------------------------------*/

     public function generate_crm_form_shortcode( $atts = array() ) {
        
        $hls_key = $atts['id']; 

        ob_start();
        require_once HLS_CRMF_US_PLUGIN_DIR . '/inc/template/view/hls_crm_shortcode.php';
        $email_content = ob_get_contents();
        ob_end_clean(); 

        return $email_content;  
       

     }





    /*---------------------------------------------------------
    |  Update List with CF7 config setting
    ----------------------------------------------------------*/

    public function hls_crmf_save_list(){

        $data = [];

        if(null != $_POST['cf7_id'] && !empty($_POST['cf7_id']) && null != $_POST['hls_list_id'] && !empty($_POST['hls_list_id']) ){

            $post_id     = sanitize_text_field($_POST['cf7_id']);
            $list_key_id = sanitize_text_field($_POST['hls_list_id']);
            $list_found  = $this->get_list_name_by_id_hls_crmf($list_key_id);

            if(null != $list_found){

              if(metadata_exists('post', $post_id, 'hlolead_list_key')) {
                delete_post_meta($post_id,'hlolead_list_key');
              }
              global $wpdb;
              $tablename  = $wpdb->prefix.'postmeta';
              $list_exist = $wpdb->get_results("SELECT * FROM $tablename WHERE `meta_key` = 'hlolead_list_key'");

              if($list_exist){
                foreach ($list_exist as $key => $list_e) {
                  if($list_e->meta_value == $list_key_id){
                    delete_post_meta($list_e->post_id,'hlolead_list_key');
                    
                  }
                }
              }

              update_post_meta($post_id,'hlolead_list_key',$list_key_id);
           


              $data['status'] = true;
              $data['msg']    = " mapped to ";

            }else{
              
              $data['status'] = false;
              $data['msg']    = "Invalid parameters. Please try again.";
            }

            

        }else{
                $data['status'] = false;
                $data['msg']    = "Invalid parameters. Please try again.";
        }

        echo json_encode($data);exit;
    }



    
    
    /*---------------------------------------------------------
    |  Reset config setting
    ----------------------------------------------------------*/

    public function hls_crmf_reset_crm_config(){

        $data = [];

        if( null != sanitize_text_field($_POST['token'])  && !empty(sanitize_text_field($_POST['token'])) && sanitize_text_field($_POST['token'] == 'reset') ){

            
            $metas   = array( 'hls_crmf_email'         =>'',
                              'hls_crmf_token'         =>'', 
                            );

            foreach($metas as $key => $value) {
                delete_option($key);
            }

            

            $data['status'] = true;
            $data['msg']    = "Configration has been reset !";

        }else{
                $data['status'] = false;
                $data['msg']    = "Something went wrong try again.";
        }

        echo json_encode($data);exit;


    }



    /*---------------------------------------------------------
    |  Update config setting
    ----------------------------------------------------------*/

    public function hls_crmf_check_credentials(){

        $data = [];

        if(null != $_POST['token'] && !empty($_POST['token']) && null != $_POST['email'] && !empty($_POST['email']) ){

            $email      = sanitize_email($_POST['email']);
            $token      = sanitize_text_field($_POST['token']);
            $lists       = $this->get_lead_listead_list_hls_crmf($token,$email);
            

            if(array_key_exists('error', $lists)){

                $data['status'] = false;
                $data['msg']    = 'Invalid parameters. Please try again.'; //$lists["message"];

            }else{

                     $metas = array( 
                                      'hls_crmf_email'         => $email,
                                      'hls_crmf_token'         => $token, 
                                  );

                      foreach($metas as $key => $value) {
                          update_option($key, $value);
                      }

                      $data['status'] = true;
                      $data['msg']    = "Setting updated successfully.";
                      


            }

                     

            


        }else{

              $data['status'] = false;
              $data['msg']    = "Invalid parameters. Please try again.";
        }

        echo json_encode($data);exit;

    }



   /*---------------------------------------------------------
    |  Plugin add admin menu page
    ----------------------------------------------------------*/

    public function hls_crmf_hlo_add_admin_page(){

        $icon_url = plugin_dir_url( __FILE__ ) .'../inc/template/img/icon.png';

        add_menu_page( 'HLS CRM Config', 'HLS CRM Config', 'manage_options', 'hls-crmf-config', array($this,'Hellolead_config_hls_crmf'),$icon_url, 82);

         $email     = get_option('hls_crmf_email');
         $token     = get_option('hls_crmf_token');

         if(null != $email && !empty($email) && null != $token && !empty($token)):

          add_submenu_page( 'hls-crmf-config','HLS CRM Form List','HLS CRM Form List','manage_options','hls-crmf-list',array($this,'Manage_hls_list_hls_crmf'));
         endif;

    }

    /*---------------------------------------------------------
    |  Admin page callback
    ----------------------------------------------------------*/

    public function Hellolead_config_hls_crmf(){

        ob_start();
        require_once HLS_CRMF_US_PLUGIN_DIR . '/inc/template/view/config.php';
        $email_content = ob_get_contents();
        ob_end_clean(); 

        echo  html_entity_decode(esc_html($email_content));
       

    }

    public function Manage_hls_list_hls_crmf(){


        $email     = get_option('hls_crmf_email');
        $token     = get_option('hls_crmf_token');
        $hls_from_data  = [];

        if(isset($email) && isset($token)){
          $lead_list = $this->get_lead_listead_list_hls_crmf($token,$email);
        }

       
        if(null != $lead_list){
          if(null != $lead_list['lists']){
            foreach ($lead_list['lists'] as $key => $value) {

              $hls_from_data[$key]['name']      = $value['name'];
              $hls_from_data[$key]['list_key']  = $value['list_key'];
              $hls_from_data[$key]['owner']     = $value['owner'];
              $hls_from_data[$key]['created']   = $value['created'];
              $hls_from_data[$key]['modified']  = $value['modified'];
              
            }
          }
        }

        ob_start();
        require_once HLS_CRMF_US_PLUGIN_DIR . '/inc/template/view/hls_list.php';
        $email_content = ob_get_contents();
        ob_end_clean(); 
        echo  html_entity_decode(esc_html($email_content));
        

    }



    /*--------------------------------------------------------------------------
    | Commom function for CRM
    -------------------------------------------------------------------------*/

    public function get_list_name_by_id_hls_crmf($list_key){

         $email     = get_option('hls_crmf_email');
         $token     = get_option('hls_crmf_token');
         $data      = $this->get_lead_listead_list_hls_crmf($token,$email);
         
         if(!empty($data) ){

            if(isset($data['lists']) && null != $data['lists']){
              foreach ($data['lists'] as $key => $val) {
              if($val['list_key'] == $list_key){
                return  $val['name'];exit;
              }
            }
           
           }
         }
         


    }

    

    public function get_lead_listead_list_hls_crmf($token=null,$xemail=null){



        $res = [];
        $endpoint = HLS_CRMF_US_GETLEADLIST_URL;
        $options = [
            'body'        => '',
            'headers'     => [
                    "hls-key"       => "token=$token",
                    "xemail"        => "$xemail"
            ],
            // 'timeout'     => 60,
            // 'redirection' => 5,
            // 'blocking'    => true,
            // 'httpversion' => '1.0',
            // 'sslverify'   => false,
            // 'data_format' => 'body',
        ];
         
        $response = wp_remote_get( $endpoint, $options );

        if(!is_wp_error($response)){
          $res      = $response['body'];
        }
        
        return json_decode($res,true);


        

    }




    /*-------------------------------------------------*/




}

new HLSCRMFORM();
