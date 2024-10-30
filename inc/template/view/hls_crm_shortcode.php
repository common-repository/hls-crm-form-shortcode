<?php  
$hls_key = str_replace("&#039;", '', $hls_key);
?>

<?php ob_start(); ?>

<style type="text/css">
	.custom_hls_crm_frm input, select {
    padding: 10px;
}
</style>

<div class="form-bottom custom_hls_crm_frm custom_<?php echo  esc_attr(trim($hls_key));?>" id="form_sample" data-key="<?php echo  esc_attr(trim($hls_key));?>"></div>

<?php 
      $content = ob_get_contents();
      ob_end_clean();
      return _e($content);

  ?> 