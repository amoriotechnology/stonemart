<?php
$CI = & get_instance();
$CI->load->model('Web_settings');
$Web_settings = $CI->Web_settings->retrieve_setting_editdata();
?>


   <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

   
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="header-icon">
            <i class="pe-7s-note2"></i>
        </div>
        <div class="header-title">
            <h1>Packing List Invoice Detail</h1>
            <small>Packing List Invoice Detail</small>
            <ol class="breadcrumb">
                <li><a href="#"><i class="pe-7s-home"></i> <?php echo display('home') ?></a></li>
                <li><a href="#"><?php echo display('invoice') ?></a></li>
                <li class="active">Packing List Invoice Detail</li>
            </ol>
        </div>
    </section>
    <!-- Main content -->
    <div class="" id="content">
    <section class="content">
        <!-- Alert Message -->
        <?php
           $message = $this->session->userdata('message');
           if (isset($message)) {
               ?>
               <div class="alert alert-info alert-dismissable">
                   <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                   <?php echo $message ?>                    
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
      <!-- <table id="tab"> -->
           
 <div class="container" id="content">
    <?php 
  
     if($template==2)
     {
       ?>
        <div class="brand-section">
        <div class="row" >
     
     <div class="col-sm-2"><img src="<?php echo  base_url().'assets/'.$logo; ?>" style='width: 100%;'>
        
       </div>
     <div class="col-sm-5 text-center" style="text-align:left;color:white;"><h3><?php echo $header; ?></h3></div>
    <div class="col-sm-5" style="color:white;font-weight:bold;" id='company_info'>
  
          <b> Company name : </b><?php echo $company; ?><br>
          <b>   Address : </b><?php echo $address; ?><br>
          <b>   Email : </b><?php echo $email; ?><br>
          <b>   Contact : </b><?php echo $phone; ?><br>
       </div>
 </div>
        </div>
        <div class="body-section">
            <div class="row">
                <div class="col-sm-6">
                <table id="one" >
    <tr><td  class="key">Packing List NO</td><td style="width:10px;">:</td><td calss="value"><?php echo $invoice;  ?></td></tr>
    <tr><td  class="key">Gross Weight</td><td style="width:10px;">:</td><td calss="value"><?php echo $gross;  ?></td></tr>
 
</table>
               </div>
                <div class="col-sm-6">
                <table id="two">
<tr><td  class="key">Invoice Date</td><td style="width:10px;">:</td><td calss="value"><?php echo $invoice_date;  ?></td></tr>
    <tr><td  class="key">Container No</td><td style="width:10px;">:</td><td calss="value"><?php echo $container;  ?></td></tr>
   </table>
                                           
                </div>
            </div>
        </div>

        <div class="body-section">
            <table class="table-bordered">
                <thead>
                    <tr>
                        <th class="text-white text-center">Product</th>
                        <th class="text-white text-center">Description</th>
                        <th class="text-white text-center">Thickness</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td style="font-size: 16px;"><?php echo $product; ?></td>
                        <td style="font-size: 16px;"><?php echo $description; ?></td>
                        <td style="font-size: 16px;"><?php echo $thickness; ?></td>
                     </tr>

                </tbody>
            </table><br><br><br>

            <table class="table-bordered">
                <thead>
                    <tr>
                        <th rowspan="2" class="text-white text-center">Serial No</th>
                        <th rowspan="2" class="text-white text-center">SLAB NO</th>
                        <th colspan="2" class="text-white text-center">Net Measurement (Inches)</th>
                        <th rowspan="2" class="text-white text-center">Area (Sq. Ft)</th>
                    </tr>
                    <tr> 
                  
                   
                    <th class="text-white text-center">Width</th>
                    <th class="text-white text-center">Height</th>
                </tr>
                
                </thead>
                <tbody>
      
      <?php
                          if ($packing_details) {
                     $count=1;
                         for($i=0;$i<sizeof($packing_details);$i++){ ?>
          <tr>
              <td style="font-size: 16px;"><?php echo $count ;?></td>
              <td style="font-size: 16px;"><?php echo $packing_details[$i]['slab_no']; ?></td>
              <td style="font-size: 16px;"><?php echo $packing_details[$i]['width']; ?></td>
             <td style="font-size: 16px;"><?php echo $packing_details[$i]['height']; ?></td>
             <td style="font-size: 16px;"><?php echo $packing_details[$i]['area']; ?></td>
             <td style="font-size: 16px;"><?php echo $packing_details[$i]['total'];  ?></td>
          </tr>
          <?php $count++;}}  ?>
        
            
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="4" style="text-align:right;font-weight:bold;">Total:</td>
                        <td style="font-size: 16px;"><?php echo $total;  ?></td>
                    </tr>
                         </tfoot>
            </table>
            <br>

<h4>Remarks/Conditions</h4><?php  echo $remarks;  ?><br><br>
        
            
        </div>
        <?php 

}
elseif($template==1)
{
?> 

<div class="brand-section">
   <div class="row">
      
     
     
     <div class="col-sm-5" id='company_info' style="color:white;">
            
     <b> Company name : </b><?php echo $company; ?><br>
          <b>   Address : </b><?php echo $address; ?><br>
          <b>   Email : </b><?php echo $email; ?><br>
          <b>   Contact : </b><?php echo $phone; ?><br>
        </div>
        <div class="col-sm-5 " style="text-align:left;color:white;"><h3><?php echo $header; ?></h3></div>
        <div class="col-sm-2"><img src="<?php echo  base_url().'assets/'.$logo; ?>" style='width: 100%;'>
         
         </div>
  </div>
        </div>
        <div class="body-section">
            <div class="row">
                <div class="col-sm-6">
                <table id="one" >
    <tr><td  class="key">Packing List NO</td><td style="width:10px;">:</td><td calss="value"><?php echo $invoice;  ?></td></tr>
    <tr><td  class="key">Gross Weight</td><td style="width:10px;">:</td><td calss="value"><?php echo $gross;  ?></td></tr>
 
</table>
               </div>
                <div class="col-sm-6">
                <table id="two">
<tr><td  class="key">Invoice Date</td><td style="width:10px;">:</td><td calss="value"><?php echo $invoice_date;  ?></td></tr>
    <tr><td  class="key">Container No</td><td style="width:10px;">:</td><td calss="value"><?php echo $container;  ?></td></tr>
   </table>
                                           
                </div>
            </div>
        </div>

        <div class="body-section">
            <table class="table-bordered">
                <thead>
                    <tr>
                        <th class="text-white text-center">Product</th>
                        <th class="text-white text-center">Description</th>
                        <th class="text-white text-center">Thickness</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td style="font-size: 16px;"><?php echo $product; ?></td>
                        <td style="font-size: 16px;"><?php echo $description; ?></td>
                        <td style="font-size: 16px;"><?php echo $thickness; ?></td>
                     </tr>

                </tbody>
            </table><br><br><br>

            <table class="table-bordered">
                <thead>
                    <tr>
                        <th rowspan="2" class="text-white text-center">Serial No</th>
                        <th rowspan="2" class="text-white text-center">SLAB NO</th>
                        <th colspan="2" class="text-white text-center">Net Measurement (Inches)</th>
                        <th rowspan="2" class="text-white text-center">Area (Sq. Ft)</th>
                    </tr>
                    <tr> 
                  
                   
                    <th class="text-white text-center">Width</th>
                        <th class="text-white text-center">Height</th>
       </tr>
                </thead>
                <tbody>
      
      <?php
                          if ($packing_details) {
                     $count=1;
                         for($i=0;$i<sizeof($packing_details);$i++){ ?>
          <tr>
              <td style="font-size: 16px;"><?php echo $count ;?></td>
              <td style="font-size: 16px;"><?php echo $packing_details[$i]['slab_no']; ?></td>
              <td style="font-size: 16px;"><?php echo $packing_details[$i]['width']; ?></td>
             <td style="font-size: 16px;"><?php echo $packing_details[$i]['height']; ?></td>
             <td style="font-size: 16px;"><?php echo $packing_details[$i]['area']; ?></td>
             <td style="font-size: 16px;"><?php echo $packing_details[$i]['total'];  ?></td>
          </tr>
          <?php $count++;}}  ?>
        
            
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="4" style="text-align:right;font-weight:bold;">Total:</td>
                        <td style="font-size: 16px;"><?php echo $total;  ?></td>
                    </tr>
                         </tfoot>
            </table>
            <br>

<h4>Remarks/Conditions</h4><?php  echo $remarks;  ?><br><br>
        
            
        </div>

        <?php 

}
elseif($template==3)
{
?>

<div class="brand-section">
<div class="row">
       
       <div class="col-sm-2"><img src="<?php echo  base_url().'assets/'.$logo; ?>" style='width: 100%;'>
          
         </div>
       <div class="col-sm-6 text-center" style="color:white;"><h3><?php echo $header; ?></h3></div>
    
   </div>
        </div>
        <div class="body-section">
        <div class="row">
        <div class="col-sm-6 "></div>
            <div class="col-sm-6 " style="width:50%;">
             <table>
          
        <tr>  <td style="100px;font-weight:bold;"> Company name </td><td style="width:10px;">:</td><td> <?php echo $company; ?></td></tr>
        <tr>   <td style="100px;font-weight:bold;"> Address </td><td style="width:10px;">:</td><td> <?php echo $address; ?></td></tr>
        <tr>   <td style="100px;font-weight:bold;"> Email </td><td style="width:10px;">:</td><td> <?php echo $email; ?></td></tr>
        <tr>   <td style="100px;font-weight:bold;"> Contact </td><td style="width:10px;">:</td><td> <?php echo $phone; ?></td></tr>
</tr>        
             
</table>
            </div></div>
              <div class="row"> <div class="col-sm-12 ">&nbsp;</div></div>
            <div class="row">
                <div class="col-sm-6">
                <table id="one" >
    <tr><td  class="key">Packing List NO</td><td style="width:10px;">:</td><td calss="value"><?php echo $invoice;  ?></td></tr>
    <tr><td  class="key">Gross Weight</td><td style="width:10px;">:</td><td calss="value"><?php echo $gross;  ?></td></tr>
 
</table>
               </div>
                <div class="col-sm-6">
                <table id="two">
<tr><td  class="key">Invoice Date</td><td style="width:10px;">:</td><td calss="value"><?php echo $invoice_date;  ?></td></tr>
    <tr><td  class="key">Container No</td><td style="width:10px;">:</td><td calss="value"><?php echo $container;  ?></td></tr>
   </table>
                                           
                </div>
            </div>
        </div>

        <div class="body-section">
            <table class="table-bordered">
                <thead>
                    <tr>
                        <th class="text-white text-center">Product</th>
                        <th class="text-white text-center">Description</th>
                        <th class="text-white text-center">Thickness</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td style="font-size: 16px;"><?php echo $product; ?></td>
                        <td style="font-size: 16px;"><?php echo $description; ?></td>
                        <td style="font-size: 16px;"><?php echo $thickness; ?></td>
                     </tr>

                </tbody>
            </table><br>

            <table class="table-bordered">
                <thead>
                    <tr>
                        <th rowspan="2" class="text-white text-center">Serial No</th>
                        <th rowspan="2" class="text-white text-center">SLAB NO</th>
                        <th colspan="2" class="text-white text-center">Net Measurement (Inches)</th>
                        <th rowspan="2" class="text-white text-center">Area (Sq. Ft)</th>
                    </tr>
                    <tr> 
                  
                   
                    <th class="text-white text-center">Width</th>
                        <th class="text-white text-center">Height</th>
       </tr>
                </thead>
                <tbody>
      
      <?php
                          if ($packing_details) {
                     $count=1;
                         for($i=0;$i<sizeof($packing_details);$i++){ ?>
          <tr>
              <td style="font-size: 16px;"><?php echo $count ;?></td>
              <td style="font-size: 16px;"><?php echo $packing_details[$i]['slab_no']; ?></td>
              <td style="font-size: 16px;"><?php echo $packing_details[$i]['width']; ?></td>
             <td style="font-size: 16px;"><?php echo $packing_details[$i]['height']; ?></td>
             <td style="font-size: 16px;"><?php echo $packing_details[$i]['area']; ?></td>
             <td style="font-size: 16px;"><?php echo $packing_details[$i]['total'];  ?></td>
          </tr>
          <?php $count++;}}  ?>
        
            
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="4" style="text-align:right;font-weight:bold;">Total:</td>
                        <td style="font-size: 16px;"><?php echo $total;  ?></td>
                    </tr>
                         </tfoot>
            </table>
            <br>

<h4>Remarks/Conditions</h4><?php  echo $remarks;  ?>
        
            
        </div>
        <?php  } ?>
    </div>  
    </section> <!-- /.content -->
</div> <!-- /.content-wrapper -->
      <!-- </table> -->
      <div class="modal fade" id="myModal_spacking" role="dialog" >
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content" style="width: 500px;height:100px;text-align:center;margin-bottom:300px;">
        <div class="modal-header" style="">
      
          <h4 class="modal-title">Sale - Packing List</h4>
        </div>
        <div class="content">

        <div class="modal-body">
          
          <h4>Packing List Downloaded Successfully</h4>
     
        </div>
        <div class="modal-footer">
        </div>
        </div>
      </div>
      
    </div>
  </div>
      <style>

.key{
    text-align:left;
font-weight:bold;

}
.value{
    text-align:left;
}
#one,#two{
float:left;
width:100%;
}
body{
    width:100%;
    background-color: #fcf8f8; 
    margin: 0;
    padding: 0;
}
h1,h2,h3,h4,h5,h6{
    margin: 0;
    padding: 0;
}
p{
    margin: 0;
    padding: 0;
}
.heading_name{
    font-weight: bold;
}
.container{
    width: 100%;
    margin-right: auto;
    margin-left: auto;
    margin-top: 50px;
}
.brand-section{
   background-color: #5961b3;
   padding: 10px 40px;
}


.row{
    display: flex;
    flex-wrap: wrap;
    
}
.col-6{
    width: 50%;
    flex: 0 0 auto;
   
}
.text-white{
    color: #fff;
}
.company-details{
    float: right;
    text-align: right;
}

.body-section{
    padding: 16px;
    border: 1px solid gray;
    
}
.heading{
    font-size: 20px;
    margin-bottom: 08px;
}
.sub-heading{
    color: #262626;
    margin-bottom: 05px;
}
table{
   
    background-color: #fff;
    width: 100%;
    border-collapse: collapse;
   
}

table thead tr{
    vertical-align: text-bottom;
    border-bottom: none !important;
            border: 1px solid #5961b3;
            background-color:  #5961b3;
   
}
.table-bordered td{
    text-align:center;
}
table td {
    vertical-align: middle !important;
  
    word-wrap: break-word;
}
th{
    text-align:center;
    color:white;
}
table th, table td {
    padding-top: 08px;
    padding-bottom: 08px;
}
.table-bordered{
    box-shadow: 0px 0px 5px 0.5px gray !important;
}
.table-bordered td, .table-bordered th {
    border: 1px solid #dee2e6 !important;
}
.text-right{
    text-align: right;
}
.w-20{
    width: 20%;
}
.float-right{
    float: right;
}
@media only screen and (max-width: 600px) {
    
}
.modal {
  position: fixed;
  top: 0;
  left: 0;
  display: flex;
  width: 100%;
  height: 100vh;
  justify-content: center;
  align-items: center;
  opacity: 0;
  visibility: hidden;
}

.modal .content {
  position: relative;
  padding: 10px;
 
  border-radius: 8px;
  background-color: #fff;
  box-shadow: rgba(112, 128, 175, 0.2) 0px 16px 24px 0px;
  transform: scale(0);
  transition: transform 300ms cubic-bezier(0.57, 0.21, 0.69, 1.25);
}

.modal .close {
  position: absolute;
  top: 5px;
  right: 5px;
  width: 30px;
  height: 30px;
  cursor: pointer;
  border-radius: 8px;
  background-color: #7080af;
  clip-path: polygon(0 10%, 10% 0, 50% 40%, 89% 0, 100% 10%, 60% 50%, 100% 90%, 90% 100%, 50% 60%, 10% 100%, 0 89%, 40% 50%);
}

.modal.open {
    background-color:#38469f;
  opacity: 1;
  visibility: visible;
}
.modal.open .content {
  transform: scale(1);
}
.content-wrapper.blur {
  filter: blur(5px);
}
.content{
    min-height:0px;
}

</style>     




<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="https://code.jquery.com/jquery-3.1.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js"></script>

 <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.0.272/jspdf.debug.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.4.1/html2canvas.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.2/html2pdf.bundle.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.2/html2pdf.bundle.min.js"></script>
<script>
  
  $(document).ready(function () {
function first(callback1,callback2){
setTimeout( function(){
    var pdf = new jsPDF('p','pt','a4');
    const invoice = document.getElementById("content");
             console.log(invoice);
             console.log(window);
             var pageWidth = 8.5;
             var margin=0.5;
             var opt = {
   lineHeight : 1.2,
   margin : 0.2,
   maxLineWidth : pageWidth - margin *1,
                 filename: 'invoice'+'.pdf',
                 allowTaint: true,
                 html2canvas: { scale: 3 },
                 jsPDF: { unit: 'in', format: 'a4', orientation: 'portrait' }
             };
              html2pdf().from(invoice).set(opt).toPdf().get('pdf').then(function (pdf) {
  var totalPages = pdf.internal.getNumberOfPages();
 for (var i = 1; i <= totalPages; i++) {
    pdf.setPage(i);
    pdf.setFontSize(10);
    pdf.setTextColor(150);
  }
  }).save('invoice_<?php echo $invoice.'.pdf'  ?>');
    callback1();
    callback2();
 }, 2500 );
}
function second(){
setTimeout( function(){
    $( '#myModal_spacking' ).addClass( 'open' );
if ( $( '#myModal_spacking' ).hasClass( 'open' ) ) {
  $( '.container' ).addClass( 'blur' );
}
$( '.close' ).click(function() {
  $( '#myModal_spacking' ).removeClass( 'open' );
  $( '.cont' ).removeClass( 'blur' );
});
}, 3000 );
}
function third(){
    setTimeout( function(){
        window.location='<?php  echo base_url();   ?>'+'Cinvoice/manage_packing_list';
        window.close();
    }, 3500 );
}
first(second,third);
});
   </script>
 

  