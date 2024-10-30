 /*-------------------------------------------------------------
  |  Intialize datatable
  -------------------------------------------------------------*/

  jQuery(function ($) {


     $('#list_view_data').DataTable( {
                dom: 'Bfrtip',
                buttons: [
                    'copy', 'csv', 'excel', 'pdf', 'print'
                ]
      } );
         
      var email    =  $('#email').val();
      var token    =  $('#token').val();

      if(!email || !token){
          $("#hls_crmf_reset_config").attr('disabled');
      }

      $('#loader').hide();
        
      /*-------------------------------------------------------------
      |  setting Form validation
      -------------------------------------------------------------*/

      $("#hls_crmf_update_config").validate({
          // Specify validation rules
          rules: {
            email: "required",
            token: "required",
            
          },
          messages: {
            email: {
            required: "Please enter email",
           },
           token: {
            required: "Please enter token",
           },      

          },
        
        });

      /*-------------------------------------------------------------
      |  Connect CRM with List
      -------------------------------------------------------------*/

      $("#hls_crmf_get_list").click(function(){

         
         var list_key  = '';
         var email     =  $('#email').val();
         var token     =  $('#token').val();
         list_key      =  $('#list_key').val();

        if(email && token){
                 
             $('#loader').show();

             $.ajax({
                type : "POST",
                url : admin_url,
                data : {action: "hls_crmf_check_credentials","token":token,"email":email},
                dataType:"json",
                success: function(res) {
                  $('#loader').hide();
                  
                  if(res.status == true){


                     window.location.href= admin_url_page;
                    
                    
                  }else{

                    $("#msg_error").removeAttr('style');
                    $("#msg_error").addClass('error');
                    $("#msg_error").text(res.msg);
                    $(".show_error").removeClass('hide');
                    
                  }
                }
            });

       }

      })







      /*-------------------------------------------------------------
      |  Reset CRM Config
      -------------------------------------------------------------*/

      $("#hls_crmf_reset_config").click(function(){

        


          if(confirm("Are you sure you want to reset details ?")){

                $('#loader').show();

                $.ajax({
                  type : "POST",
                  url : admin_url,
                  data : {action: "hls_crmf_reset_crm_config","token":"reset"},
                  dataType:"json",
                  success: function(res) {
                    
                      $('#loader').hide();
                      toastr.success(res.msg);
                      location.reload();
                    
                  }
               });
   

            }else
            {

              return false;
            }



       });

   
      
 });  

   