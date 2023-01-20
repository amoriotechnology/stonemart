<?php
    $CI =& get_instance();
    $CI->load->model('Web_settings');
    $Web_settings = $CI->Web_settings->retrieve_setting_editdata();
?>
<footer class="main-footer">
    <strong>
      <?php if (isset($Web_settings[0]['footer_text'])) { echo html_escape($Web_settings[0]['footer_text']); }?>
    </strong><i class="fa fa-heart color-green"></i>
      <input type ="hidden" name="csrf_test_name" id="csrf_test_name" value="<?php echo $this->security->get_csrf_hash();?>">
       <input type ="hidden" name="base_url" id="base_url" value="<?php echo base_url();?>">
</footer>

  <!-- COMMON CALCULATOR MODAL -->
   <!-- calculator modal -->
    <div class="modal fade-scale" id="calculator" role="dialog">
    <div class="modal-dialog" id="calculatorcontent">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-body">
            <div class="calcontainer">
         <div class="screen">
      <h1 id="mainScreen">0</h1>
    </div>
    <table>
      <tr>
        <td><button value="7" id="7" onclick="InputSymbol(7)">7</button></td>
        <td><button value="8" id="8" onclick="InputSymbol(8)">8</button></td>
        <td><button value="9" id="9" onclick="InputSymbol(9)">9</button></td>
        <td><button onclick="DeleteLastSymbol()">CE</button></td>
      </tr>
      <tr>
        <td><button value="4" id="4" onclick="InputSymbol(4)">4</button></td>
        <td><button value="5" id="5" onclick="InputSymbol(5)">5</button></td>
        <td><button value="6" id="6" onclick="InputSymbol(6)">6</button></td>
        <td><button value="/" id="104" onclick="InputSymbol(104)">/</button></td>
      </tr>
      <tr>
        <td><button value="1" id="1" onclick="InputSymbol(1)">1</button></td>
        <td><button value="2" id="2" onclick="InputSymbol(2)">2</button></td>
        <td><button value="3" id="3" onclick="InputSymbol(3)">3</button></td>
        <td><button value="*" id="103" onclick="InputSymbol(103)">*</button></td>
      </tr>
      <tr>
        <td><button value="0" id="0" onclick="InputSymbol(0)">0</button></td>
        <td><button value="." id="128" onclick="InputSymbol(128)">.</button></td>
        <td><button value="-" id="102" onclick="InputSymbol(102)">-</button></td>
        <td><button value="+" id="101" onclick="InputSymbol(101)">+</button></td>
      </tr>
      <tr>
        <td colspan="2"><button onclick="ClearScreen()">C</button></td>
        <td colspan="1"><button onclick="CalculateTotal()">=</button></td>
        <td colspan="1"><button  data-dismiss="modal" class="btn-danger"><i class="fa fa-power-off"></i></button></td>
      </tr>
    </table>
</div>
        </div>
       
      </div>
      
    </div>
  </div>
<script type="text/javascript">
function hide()
{
setTimeout(hide, 3000);
function hide() {
 $('#myModal1').modal('hide');

}
}
</script>


<div id="emailmodal" class="modal fade" role="dialog">
  <div class="modal-dialog">
<form action="insert_role">    <!-- Modal content-->
    <div class="modal-content" style="width: 177%; !important;
    margin-left: -43%;
   " >
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Email</h4>
      </div>
      <div class="modal-body">
     <div class="panel panel-default">
      <div class="panel-body message">
        <p class="text-center">Send Invoice</p>
        <form class="form-horizontal" role="form" action="dsd">
          <div class="form-group">
              <label for="to" class="col-sm-1 control-label">To:</label>
              <div class="col-sm-11">
                  <input type="text" name="" class="form-control" id="customer_emailid">
              </div>
            </div>
          <div class="form-group">    
              <label for="cc" class="col-sm-1 control-label">CC:</label>
              <div class="col-sm-11">
                              <input type="email" class="form-control select2-offscreen" id="cc" placeholder="Type email" tabindex="-1">
              </div>
            </div>
          <div class="form-group">
              <label for="bcc" class="col-sm-1 control-label">Subject:</label>
              <div class="col-sm-11">
                              <input type="text" class="form-control select2-offscreen" id="bcc" placeholder="Type email" tabindex="-1" value="<?php echo $email_setting[0]['subject']; ?>">
              </div>
            </div>
          
        <div class="col-sm-11 col-sm-offset-1">
          
          <div class="btn-toolbar" role="toolbar">
       
          </div>
          <br>  
          
          <div class="form-group">
            <textarea class="form-control" id="message" name="body" rows="12" ><?php echo $email_setting[0]['greeting']; ?>
              
             
              <?php echo $email_setting[0]['message']; ?>

              Regards

              <?php echo $company_info[0]['company_name']; ?>
            
              <?php echo $company_info[0]['email']; ?>
             
              <?php echo $company_info[0]['address']; ?>

            </textarea>
          </div>
          
          <div class="form-group"> 

            <img src="https://play-lh.googleusercontent.com/9XKD5S7rwQ6FiPXSyp9SzLXfIue88ntf9sJ9K250IuHTL7pmn2-ZB0sngAX4A2Bw4w" style="width: 5%">
            
                <span class="invoice_id" style="font-weight: bold;font-style: italic;">
            </span>
           
            <a  id="sendmail"  style="float: right; color: white;" type="button" class="btn btn-success">Send Mail</a>
            </form>
          </div>
        </div>  
      </div>  
    </div>


</div>
      <div class="modal-footer">
      <p></p>
      </div>
    </div>

  </div>
</div>


<script type="text/javascript">
  function mail(id,table,col)
  {

  var id=id+'-'+table+'-'+col;

    // alert(id);
        var url='<?php echo base_url('Cinvoice/get_customer/'); ?>';

       $.ajax({
        url:url+id,
        type: 'GET',
        success: function(res) {
          
            $('#customer_emailid').val(res);
            console.log(id);
            const myArray = id.split("-");
            let word = myArray[0];
            
            $("#sendmail").attr("href", "<?php echo base_url()?>Cinvoice/sendmail_with_attachments/"+word);
    
        }
    });
 
  }
</script>

<script type="text/javascript">
  function profarmamail(id,table,col)
  {

  var id=id+'-'+table+'-'+col;

   
        var url='<?php echo base_url('cinvoice/get_customer/'); ?>';

       $.ajax({
        url:url+id,
        type: 'GET',
        success: function(res) {
          
            $('#customer_emailid').val(res);
            console.log(id);
            const myArray = id.split("-");
            let word = myArray[0];
            
            $("#sendmail").attr("href", "<?php echo base_url()?>Cinvoice/proforma_with_attachment_cus/"+word);
    
        }
    });
 
  }
</script>

<script type="text/javascript">
  function packingmail(id,table,col)
  {

  var id=id+'-'+table+'-'+col;

   
        var url='<?php echo base_url('cinvoice/get_customer/'); ?>';

       $.ajax({
        url:url+id,
        type: 'GET',
        success: function(res) {
          
            $('#customer_emailid').val(res);
            console.log(id);
            const myArray = id.split("-");
            let word = myArray[0];
            
            $("#sendmail").attr("href", "<?php echo base_url()?>Cinvoice/packing_with_attachment_cus/"+word);
    
        }
    });
 
  }
</script>

<script type="text/javascript">
  function oceanexportmail(id,table,col)
  {

  var id=id+'-'+table+'-'+col;
   
        var url='<?php echo base_url('cinvoice/get_customer/'); ?>';

       $.ajax({
        url:url+id,
        type: 'GET',
        success: function(res) {
          
            $('#customer_emailid').val(res);
            console.log(id);
            const myArray = id.split("-");
            let word = myArray[0];
            
            $("#sendmail").attr("href", "<?php echo base_url()?>Cinvoice/ocean_with_attachment_cus/"+word);
    
        }
    });
 
  }
</script>

<script type="text/javascript">
  function truckingmail(id,table,col)
  {

  var id=id+'-'+table+'-'+col;
   
        var url='<?php echo base_url('cinvoice/get_customer/'); ?>';

       $.ajax({
        url:url+id,
        type: 'GET',
        success: function(res) {
          
            $('#customer_emailid').val(res);
            console.log(id);
            const myArray = id.split("-");
            let word = myArray[0];
            
            $("#sendmail").attr("href", "<?php echo base_url()?>Cinvoice/trucking_with_attachment_cus/"+word);
    
        }
    });
 
  }
</script>

