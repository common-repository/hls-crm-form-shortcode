<?php
require_once HLS_CRMF_US_PLUGIN_DIR . '/inc/template/header.php';
?>

<?php 

$email     = get_option('hls_crmf_email');
$token     = get_option('hls_crmf_token');

global $current_user;

if(isset($lead_list['lists']) && $lead_list['lists'] != null){
  $lead_list = $lead_list['lists'];
}

?>

<?php if(isset($email) && !empty($email) && isset($token) && !empty($token)):?>
      
      <div class="container">
        <div class="row">

          <div class="col-md-12">
            <div class="align_center">
              <a target="_blank" href="https://www.helloleads.io/">
               <img src="<?php echo plugin_dir_url( __FILE__ ) .'../img/HLS_Logo.png'; ?>">
             </a>
            </div>
            <p class="font_size pb-20">Congratulations&nbsp;<b><?php echo esc_html($current_user->user_login); ?> !!!</b>&nbsp;Your Integration with HelloLeads CRM Form is successfull.</p>
          </div>

        <div class="col-md-12">
            
           <table id="list_view_data" class="display table table-resposive table-bordered" style="width:100%">
 
                <thead>
                    <tr>
                              <th>Sr No.</th>
                              <th>List Name</th>
                              <th>List Owner</th>
                              <th>Created Date</th>
                              <th>Modified Date</th>
                              <th>Code to Embed Hello Form  </th>
                            

                              
                          </tr>
                </thead>
                <tbody>

                
                  <?php if(null != $hls_from_data): ?>

                     <?php foreach ($hls_from_data as $key => $value): ?>
                      <?php $list_key_val = $value['list_key']; ?>
                    <tr>
                       <td><?php echo esc_html($key +=1);?></td>
                       <td><?php echo esc_html($value['name']);?></td>
                       <td><?php echo esc_html($value['owner']);?></td>
                       <td><?php echo esc_html($value['created']);?></td>
                       <td><?php echo esc_html($value['modified']);?></td>
                       <td> <i class="fa fa-copy copy_shortcode" onclick="copyToClipboard('<?php echo esc_attr($list_key_val); ?>')"></i>
                        <span class="">&nbsp;&nbsp; [HLS_CRM_FORM id=<?php echo esc_html($value['list_key']); ?>]</span>
                       </td>
                    </tr>
                     <?php endforeach; ?>

                  <?php endif; ?>
                   
                   

                
                   
                    
                   
                </tbody>
                
            </table> 
        
          
        </div>



        
      </div> <!-- container -->

    

      <div id="loader">
      </div>



<script type="text/javascript">
  function copyToClipboard(element) {
        var $temp = jQuery("<input>");
        jQuery("body").append($temp);
        var shotc = jQuery.trim(("[HLS_CRM_FORM id="+element+"]"));
        $temp.val(shotc).select();
        document.execCommand("copy");
        toastr.success("Form Shortcode Copied");
        $temp.remove();
      }
</script>
      <style type="text/css">
           #loader {display: none;position: fixed;top: 0;left: 0;right: 0;bottom: 0;width: 100%;background: rgba(0, 0, 0, 0.75) url("<?php echo plugin_dir_url( __FILE__ ) .'../img/loading.gif'; ?>") no-repeat center center;z-index: 10000;}.view_pdf{cursor: pointer;}span.view_pdf.view_pdf_btn {color: cornflowerblue;}i.fa.fa-copy.copy_shortcode {color: #1c84c6;cursor: pointer;}

      </style>
    

<?php else:?>
   <meta http-equiv="Refresh" content="0; url=<?php echo admin_url('admin.php?page=hls-crmf-config');?>">

<?php endif; ?>

<?php
require_once HLS_CRMF_US_PLUGIN_DIR . '/inc/template/footer.php';
?>
