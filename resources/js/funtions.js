 function show(){
      	value=document.getElementById("user").value;
         $.post('<?php echo base_url()."welcome/check_user";?>',{username:value},function(data){
              if (data==1) {
              	 
              };   
      
        });
      }

      function check_names(id){
          var value=document.getElementById(id).value;
           $.post('<?php echo base_url()."welcome/show_result";?>',{name:value},function(data){
            $('div#details').html(data);
           });
      }
      function alert_details(){
      	document.getElementById('chk').style.visibility='visible';

      }