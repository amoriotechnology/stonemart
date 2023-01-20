<!-- Manage Invoice Start -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css"/>
<script type="text/javascript" src="<?php echo base_url()?>assets/js/jquery.base64.js"></script>
  <script type="text/javascript" src="<?php echo base_url()?>assets/js/html2canvas.js"></script>
 <script type="text/javascript" src="<?php echo base_url()?>assets/js/jspdf.plugin.autotable"></script>
  <script type="text/javascript" src="<?php echo base_url()?>assets/js/jspdf.umd.js"></script>
<script type="text/javascript" src="//cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/bootstrap/3/css/bootstrap.css" />
<script type="text/javascript" src="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.js"></script>
<link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.css" />
 <script type="text/javascript" src="<?php echo base_url()?>my-assets/js/tableManager.js"></script>
<script type="text/javascript" src="https://unpkg.com/xlsx@0.15.1/dist/xlsx.full.min.js"></script>
<script type="text/javascript" src="http://mrrio.github.io/jsPDF/dist/jspdf.debug.js"></script>
<input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>">
<link rel="stylesheet" type="text/css" href="<?php echo base_url()?>my-assets/css/css.css" />
<script type="text/javascript" src="http://www.bacubacu.com/colresizable/js/colResizable-1.5.min.js"></script>

<div class="content-wrapper">

    <section class="content-header">

        <div class="header-icon">

            <i class="pe-7s-note2"></i>

        </div>

        <div class="header-title">

            <h1><?php echo display('manage_invoice') ?></h1>

            <small><?php echo display('manage_your_invoice') ?></small>

            <ol class="breadcrumb">

                <li><a href="<?php   echo base_url(); ?>"><i class="pe-7s-home"></i> <?php echo display('home') ?></a></li>

                <li><a href="#"><?php echo display('invoice') ?></a></li>

                <li class="active" style="color:orange;"><?php echo display('manage_invoice') ?></li>

            </ol>

        </div>

    </section>



    <section class="content">

        <!-- Alert Message -->

        <?php

        $message = $this->session->userdata('message');

        if (isset($message)) {

            ?>

            <div class="alert alert-info alert-dismissable">

                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>

                <?php //echo $message ?>                    

            </div>

            <?php

            $this->session->unset_userdata('message');

        }

        $error_message = $this->session->userdata('error_message');

        if (isset($error_message)) {

            ?>

            <div class="alert alert-danger alert-dismissable">

                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>

                <?php echo $error_message ?>                    

            </div>

            <?php

            $this->session->unset_userdata('error_message');

        }

        ?>



<div class="panel panel-default">
                    <div class="panel-body"> 
                        <div class="row">
                        <div class="col-sm-4">
                             <?php if($this->permission1->method('add_purchase','create')->access()){ ?>
                    <a href="<?php echo base_url('Cinvoice') ?>" class="btn btn-info m-b-5 m-r-2">Create Sale</a>
                       <?php } ?>
                        </div>
                        <div class="col-sm-6">
                     
                        <?php echo form_open_multipart('Cinvoice/manage_invoice',array('class' => 'form-vertical', 'id' => 'insert_sale','name' => 'insert_sale'))?>


<?php



$today = date('Y-m-d');

?>

<div class="form-group">

    <label class="" for="from_date"><?php echo 'Search By Date Range : '; ?></label>

    <input type="text" name="daterange" />
    <input type="submit" id="btn-filter" class="btn btn-success" value="Search"/>
    <a href="javascript:window.location.reload(true)" >  <i class="fa fa-refresh" style="font-size:20px;float:right;" aria-hidden="true"></i> </a>
</div> 
<?php echo form_close() ?>
                    </div>
                    <div class="col-sm-2">
                    <i class="fa fa-cog"  aria-hidden="true" id="myBtn" style="font-size:25px;" onClick="columnSwitchMODAL()"></i> <!-- onclick opens MODAL -->
                   
                    <div class="dropdown bootcol" id="drop" style="float:right;padding-right:20px;padding-bottom:10px;">
    <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
       <span class="glyphicon glyphicon-th-list"></span> Download
     
    </button>
    <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
   
  
                
      <li><a href="#" onclick="generate()"> <img src="<?php echo base_url()?>assets/images/pdf.png" width="24px"> PDF</a></li>
      
      <li class="divider"></li>         
                  
      <li><a href="#" onclick="$('#ProfarmaInvList').tableExport({type:'excel',escape:'false'});"> <img src="<?php echo base_url()?>assets/images/xls.png" width="24px"> XLS</a></li>
                 
    </ul>
  </div>

  </div>  


                </div>
            </div>
         </div>

<div class="row">
            <div class="col-sm-12">
                    <a href="<?php echo base_url('Cinvoice/add_product_csv') ?>" class="btn btn-primary m-b-5 m-r-2 text-white"><i class="ti-plus"> </i> &nbsp;  <?php echo display('add_product_csv') ?> </a>
            </div>
        </div>
        <div class="row"> 

        </div>

        <!-- Manage Invoice report -->

        <div class="row">

            <div class="col-sm-12">

                <div class="panel panel-bd lobidrag">

                    <div class="panel-heading">

                    </div>

                    <div class="panel-body">

                    <div id="customers">
  <table class="table table-bordered" cellspacing="0" width="100%" id="ProfarmaInvList">
  <thead>
      <tr>
      <th class="ID" data-resizable-column-id="1"    style="width: 80px; height: 40.0114px;" >ID</th>
        <th class="Invoice No" data-resizable-column-id="2"  style="height: 45.0114px; width: 234.011px" >Invoice No</th>
        <th class="Sale By" data-resizable-column-id="3"  style="height: 42.0114px;"   >Sale By</th>
        <th class="Customer Name"  data-resizable-column-id="4"  style="width: 248.011px;"        >Customer Name</th>
        <th class="Date" data-resizable-column-id="5"    style="width: 198.011px;"       >Date</th>
        <th class="Total Amount" data-resizable-column-id="6" style="width: 190.011px; height: 44.0114px;">Total Amount</th>
      <div class="myButtonClass Action"> 
         <th class="Action text-center" data-column-id="action" data-formatter="commands" data-sortable="false"   style="width: 255.011px; height: 39.0114px;"  >Action</th>
        </div>
      </tr>
    </thead>
    <tbody>

     <?php
    $count=1;

      if(count($sale['rows'])>0){
     foreach($sale['rows'] as $k=>$arr){
          ?>
          <tr style="text-align:center" ><td><?php  echo $count;  ?></td>
 <td><?php   echo $arr['commercial_invoice_number'];  ?></td>
   <td><?php   echo $arr['first_name'].' '.$arr['last_name'];  ?></td>
   <td><?php   echo $arr['customer_name'];  ?></td>
<td><?php   echo $arr['date'];  ?></td>
  <td><?php   echo $currency." ".$arr['total_amount'];  ?></td>
  <!-- <td><a href="<?php //echo base_url()?>Cinvoice/profarma_invoice_update_form/<?php //echo  $arr['invoice_id'];  ?>">edit</a><input type="button" value="delete"/></td> -->
  <div class="form-group">
  <td>
  <a class="btn  btn-sm" style="background-color: #3ca5de; color: #fff;" href="<?php echo base_url()?>Cinvoice/invoice_inserted_data/<?php echo  $arr['invoice_id'];  ?>"><i class="fa fa-download" aria-hidden="true"></i></a>

  <!-- <a class="btn  btn-sm" style="background-color: #3ca5de; color: #fff;"  data-toggle="modal" data-target="#emailmodal"><i class="fa fa-envelope" aria-hidden="true"></i></a> -->

  <a class="btn  btn-sm" style="background-color: #3ca5de; color: #fff;"  data-toggle="modal" data-target="#emailmodal" onclick="mail(<?php echo  $arr['invoice_id'];  ?>,'invoice','invoice_id')"><i class="fa fa-envelope" aria-hidden="true" ></i></a>

  <!-- Modal -->
<!-- <div id="emailmodal" class="modal fade" role="dialog">
  <div class="modal-dialog">
<form action="insert_role">    
    <div class="modal-content" >
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Select Email Template </h4>
      </div>
      <div class="modal-body">
     <div class="row">
        <div class="col-sm-6" style="border: 1px solid #6666;text-align: center;">  <p style="font-weight: bold;">Standard</p>
            <br>
            <i>Standard Email Temeplate</i>
            <br>
            <br>
         <a href="<?php echo base_url('Cinvoice/newsale_with_attachment_stand/').$arr['invoice_id'];  ?>" class="btn btn-default">Select</a></div>
        <div class="col-sm-6" style="border: 1px solid #6666;text-align: center;">  <p style="font-weight: bold;">Custom</p>
            <br>
            <i>Custom Email Temeplate</i>
            <br>
            <br>
         <a class="btn btn-default" href="<?php echo base_url('Cinvoice/newsale_with_attachment_cus/').$arr['invoice_id'];  ?>">Select</a>
         <a class="btn  btn-sm" style="background-color: #3ca5de; color: #fff;"  data-toggle="modal" data-target="#emailmodal" onclick="mail(<?php echo  $arr['invoice_id'];  ?>,'invoice','invoice_id')"><i class="fa fa-envelope" aria-hidden="true" ></i></a>
     </div>
       
     </div>


</div>
      <div class="modal-footer">
      
      </div>
    </div>

  </div>
</div> -->
    <a class="btn  btn-sm" style="background-color: #3ca5de; color: #fff;" href="<?php echo base_url()?>Cinvoice/invoice_update_form/<?php echo  $arr['invoice_id'];  ?>"><i class="fa fa-pencil" aria-hidden="true"></i></a>
  </td>
  </div>
</tr>

     <?php   
$count++;

     
              
                
} }  else{
    ?>
     <tr><td colspan="8" style="text-align:center;font-weight:bold;"><?php  echo "No Records Found"  ;?></td></tr>
    <?php
          }

?>
  
    </tbody>
    <!--
    <tfoot>

<th colspan="5" class="text-right"><?php echo display('total') ?>:</th>



<th></th>  

<th></th> 

            </tfoot>-->
  </table>
      </div>
</section>
<input type="hidden" value="Sale/New Sale" id="url"/>
<script src="<?php echo base_url()?>assets/js/jquery.bootgrid.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.5/jspdf.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.0.0-alpha.1/jspdf.plugin.autotable.js"></script>



    <!-- The Modal Column Switch -->
            <div id="myModal_colSwitch" class="modal_colSwitch">
                    <div class="modal-content_colSwitch">
                          <span class="close_colSwitch">&times;</span>
                         
                          <input type="checkbox"  data-control-column="1" class="opt ID"  value="ID"/> ID<br>

    <input type="checkbox"  data-control-column="2" class="opt Invoice No"  value="Invoice No"/>Invoice No<br>
 
    <input type="checkbox"  data-control-column="3" class="opt Sale By"   value="Sale By"/>Sale By<br>
  
    <input type="checkbox"  data-control-column="4" class="opt Customer Name"   value="Customer Name"/>Customer Name<br>

    <input type="checkbox"  data-control-column="5" class="opt Date"   value="Date"/>Date<br>

    <input type="checkbox"  data-control-column="6" class="opt Total Amount"   value="Total"/>Total<br>

    <input type="checkbox"  data-control-column="7" class="opt Action"   value="Action"/>Action<br>
               <!--      <input type="submit" value="submit" id="submit"/>-->
                    </div>
                </div>





                            

                        </div>

                       



                  

                </div>


                       



                    </div>

                </div>

                <input type="hidden" id="total_invoice" value="<?php echo $total_invoice;?>" name="">

                 <input type="hidden" id="currency" value="{currency}" name="">

            </div>

        </div>

    </section>
    <input type ="hidden" name="csrf_test_name" id="csrf_test_name" value="<?php echo $this->security->get_csrf_hash();?>">

</div>

<!-- Manage Invoice End -->

<script type="text/javascript" src="<?php echo base_url()?>my-assets/js/profarma.js"></script>
<script>

    var csrfName = '<?php echo $this->security->get_csrf_token_name();?>';
var csrfHash = '<?php echo $this->security->get_csrf_hash();?>';
$editor = $('#submit'),
  $editor.on('click', function(e) {
    if (this.checkValidity && !this.checkValidity()) return;
    e.preventDefault();
    var yourArray = [];
    //loop through all checkboxes which is checked
    $('.modal-content_colSwitch input[type=checkbox]:not(:checked)').each(function() {
      yourArray.push($(this).val());//push value in array
    });
   
    values = {
    
      extralist_text: yourArray
    
    };
    console.log(values)
    var json=values;
    var data = {
        page:$('#url').val(),
          content: yourArray
       
       };
       data[csrfName] = csrfHash;
$.ajax({
    
    type: "POST",  
    url:'<?php echo base_url();?>Cinvoice/setting',
   
    data: data,
    dataType: "json", 
    success: function(data) {
        if(data) {
           console.log(data);
        }
    }  
});
  });

  $( document ).ready(function() {
   var page=$('#url').val();
   page=page.split('/');
    var data = {
        'menu':page[0],
        'submenu':page[1]
         
       
       };
      
       data[csrfName] = csrfHash;
    $.ajax({
    
    type: "POST",  
    url:'<?php echo base_url();?>Cinvoice/get_setting',
   
    data: data,
    dataType: "json", 
    success: function(data) {
     var menu=data.menu;
     var submenu=data.submenu;
     if(menu=='Sale' && submenu=='New Sale'){
     var s=data.setting;
s=JSON.parse(s);
console.log(s);
for (var i = 0; i < s.length; i++) {
    console.log(s[i]);
    $('td.'+s[i]).hide(); // hide the column header th
    $('th.'+s[i]).hide();
$('tr').each(function(){
     $(this).find('td:eq('+$('td.'+s[i]).index()+')').hide();
});
    }
    for (var i = 0; i < s.length; i++) {
        if( $('.'+s[i]))
  $('.'+s[i]).prop('checked', false); //check the box from the array, note: you need to add a class to your checkbox group to only select the checkboxes, right now it selects all input elements that have the values in the array 
    }  
}
    }
});


});

    </script>