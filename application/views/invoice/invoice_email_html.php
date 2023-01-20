<input type ="hidden" name="csrf_test_name" id="csrf_test_name" value="<?php echo $this->security->get_csrf_hash();?>">
<div class="modal fade" id="modelboot" style="background-color: aliceblue;" tabindex="-1" role="dialog" aria-labelledby="modelbootLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
            <div id="loading">Loading please wait...</div>
				<h4 class="modal-title" id="modelbootLabel" style="font-weight:bold;color:blue;"></h4>
              
			</div>
			<div class="modal-body">
				<div class="alert alert-success hidden" id="contactSuccess">
					<strong>Success!</strong> Your message has been sent to us.
				</div>

				<div class="alert alert-danger hidden" id="contactError">
					<strong>Error!</strong> There was an error sending your message.
				</div>
             
			
					<div class="row">
						<div class="form-group">
							<div class="col-md-6">
								<label>Your name *</label>
								<input type="text"  data-msg-required="Please enter your name." maxlength="100" class="form-control" name="name" id="name_email" value="<?php echo $email_greeting;  ?>" required>
							</div>
							<div class="col-md-6">
								<label>Your email address *</label>
								<input type="email"  data-msg-required="Please enter your email address." data-msg-email="Please enter a valid email address." maxlength="100" value="<?php echo $customer_email;  ?>"   class="form-control" name="email" id="email_info" required>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="form-group">
							<div class="col-md-12">
								<label>Subject</label>
								<input type="text"  data-msg-required="Please enter the subject." maxlength="100" class="form-control" name="subject" value="<?php echo $email_subject;  ?>"  id="subject_email" required>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="form-group">
							<div class="col-md-12">
								<label>Message *</label>
								<textarea maxlength="5000" data-msg-required="Please enter your message." rows="10" class="form-control" name="message" value="<?php echo $email_message;  ?>" id="message_email" required></textarea>
							</div>
						</div>
					</div>
					<br>
					<div class="row">
                        <div class="col-md-12">
			
							<input type="submit" value="Send Message" id="email_send" name="email_send" class="btn btn-primary" data-loading-text="Loading...">

							<!-- <input type="submit" value="Close" name="" class="btn btn-danger" data-loading-text="Loading..."> -->
                           
                        </div>
                       
					</div>
                   

			</div>
		</div>
	</div>
</div>

<style>


#loading{


 display:none;
  color: black;
  opacity: 1;
  transition: 0.5s;
  visibility: visible;
}
#loading.hidden{
  opacity: 0;
  visibility: hidden;
}
    </style>




 
<script type="text/javascript">
	var csrfName = '<?php echo $this->security->get_csrf_token_name();?>';
var csrfHash = '<?php echo $this->security->get_csrf_hash();?>';
    $(window).on('load', function() {
     
    
        $('#modelboot').modal({backdrop: 'static', keyboard: false}, 'show');
      
    });


$('#email_send').click(function(){
    $('#loading').show();
    var data = {
        name_email:$('#name_email').val(),
        email_info:$('#email_info').val(),
        message_email:$('#message_email').val(),
        subject_email:$('#subject_email').val()
      };
      data[csrfName] = csrfHash;
  
      $.ajax({
          type:'POST',
          data: data, 
         dataType:"json",
          url:'<?php echo base_url();?>Cinvoice/sendmail',
          success: function(result) {
           if (result)
           {
                console.log(result);
                setTimeout(function() {
                  
  $('#loading').addClass('hidden');
$("#modelbootLabel").show();
                $("#modelbootLabel").html(result);
                setTimeout(function() {
                window.location='<?php echo base_url();?>Cinvoice/manage_profarma_invoice';
            }, 2000);
}, 3000);
               

           }
        }
      });
});
</script>