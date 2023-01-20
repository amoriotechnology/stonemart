

<div class="content-wrapper">
    <section class="content-header" >
        <div class="header-icon">
            <i class="pe-7s-note2"></i>
        </div>
        <div class="header-title" >
            <h1><?php echo display('purchase_ledger') ?></h1>
            <small><?php echo display('purchase_ledger') ?></small>
            <ol class="breadcrumb">
                <li><a href="#"><i class="pe-7s-home"></i> <?php echo display('home') ?></a></li>
                <li><a href="#"><?php echo display('purchase') ?></a></li>
                <li class="active"><?php echo display('purchase_ledger') ?></li>
            </ol>
        </div>
    </section>
  <!-- Invoice information -->
  <?php
        $myArray = explode('(',$total_tax); 
       $tax_amt=$myArray[0];
       $tax_des=$myArray[1];
      
      
      ?>
     <div class="container" id="content">
        <?php
    
     if($template==2)
            {
            ?>
        <div class="brand-section">
        <div class="row" >
     
     <div class="col-sm-2"><img src="<?php echo  base_url().'assets/'.$logo; ?>" style='width: 100%;'>
        
       </div>
     <div class="col-sm-5 text-center" style="color:white;"><h3><?php echo $header; ?></h3></div>
    <div class="col-sm-5" style="color:white;font-weight:bold;" id='company_info'>
           
          <b> Company name : </b><?php echo $company_info[0]['company_name']; ?><br>
          <b>   Address : </b><?php echo $company_info[0]['address']; ?><br>
          <b>   Email : </b><?php echo $company_info[0]['email']; ?><br>
          <b>   Contact : </b><?php echo $company_info[0]['mobile']; ?><br>
       </div>
 </div>
        </div>
       
        <div class="body-section">
            <div class="row">
                <div class="col-6">
                <table id="one" style="border:none;">
    <tr><td  class="key">Vendor</td><td style="width:10px;">:</td><td calss="value"><?php echo $supplier_name;  ?></td></tr>
    <tr><td  class="key">Invoice No</td><td style="width:10px;">:</td><td calss="value"><?php echo $chalan_no;  ?></td></tr>
   <?php  if(!empty($isf_filling)) { ?>
    <tr><td  class="key">ISF NO</td><td style="width:10px;">:</td><td calss="value"><?php echo $isf_filling;  ?></td></tr>
<?php   }  ?>
   
</table>

                </div>
                <div class="col-6">
                <table id="two">
<tr><td  class="key">Expenses /Bill Date</td><td style="width:10px;">:</td><td calss="value"><?php echo $final_date;  ?></td></tr>
    <tr><td  class="key">Payment Due Date</td><td style="width:10px;">:</td><td calss="value"><?php echo $payment_due_date;  ?></td></tr>
    <?php  if(!empty($packing_id)) { ?>
    <tr><td  class="key">Packing Invoice No</td><td style="width:10px;">:</td><td calss="value"><?php echo $packing_id;  ?></td></tr>
    <?php   }  ?>
</table> </div>
            </div>
        </div>
        <div class="body-section">
            <table class="table-bordered">
                <thead>
                    <tr>
                    <th class="text-center text-white">S.No</th>
                        <th class="text-center text-white">Product</th>
                        <th class="text-center text-white">Description</th>
                        <th class="text-center text-white">Quantity</th>
                        <th class="text-center text-white">Unit</th>
                        <th class="text-center text-white">Rate</th>
                        <th class="text-center text-white">Total</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                                    if ($purchase_all_data) {
                               $count=1;
                                   for($i=0;$i<sizeof($purchase_all_data);$i++){ ?>
                    <tr>
                    <td style="font-size: 16px;"><?php echo $count ;?></td>
                       <td style="font-size: 16px;"><?php echo $purchase_all_data[$i]['product_name']; ?></td>
                       <td style="font-size: 16px;"><?php echo $purchase_all_data[$i]['description']; ?></td>
                       <td style="font-size: 16px;"><?php echo $purchase_all_data[$i]['quantity']; ?></td>
                       <td style="font-size: 16px;"><?php echo $purchase_all_data[$i]['slab']; ?></td>
                       <td style="font-size: 16px;"><?php echo $purchase_all_data[$i]['rate']; ?></td>
                       <td style="font-size: 16px;"><?php  echo $currency." " ; ?><?php echo $purchase_all_data[$i]['total_amount']; ?></td>
                    </tr>
                    <?php $count++;}}  ?>
                    <tr>
                        <td colspan="6" style="text-align:right;font-weight:bold;">Total</td>
                        <td style="font-size: 16px;"><?php  echo $currency." " ; ?><?php echo $purchase_all_data[0]['total']; ?></td>
                    </tr>
                    <tr>
                       
                       <td colspan="6" style="text-align:right;font-weight:bold;"><?php echo  "Tax (".$tax_des;  ?></td>
                              <td style="font-size: 16px;"><?php  echo $currency." " ; ?><?php echo $tax_amt;  ?></td>
                          </tr>
                       <tr>
                       <td colspan="6" style="text-align:right;font-weight:bold;">Grand Total:</td>
                           <td style="font-size: 16px;"><?php  echo $currency." " ; ?><?php echo $purchase_all_data[0]['grand_total_amount']; ?></td>
                       </tr>
                    <tr>
                        <td colspan="6" style="text-align:right;font-weight:bold;">Grand Total(Preferred Currency)</td>
                        <td style="font-size: 16px;"><?php echo $supplier_currency." "; ?><?php echo $purchase_all_data[0]['gtotal_preferred_currency']; ?></td>
                    </tr>
                   
                    <tr>
                        <td colspan="6" style="text-align:right;font-weight:bold;">Amount Paid</td>
                        <td style="font-size: 16px;"><?php echo $supplier_currency." "; ?><?php echo $purchase_all_data[0]['paid_amount']; ?></td>
                    </tr>
                    <tr>
                        <td colspan="6" style="text-align:right;font-weight:bold;">Balance</td>
                        <td style="font-size: 16px;"><?php echo $supplier_currency." "; ?><?php echo $purchase_all_data[0]['balance']; ?></td>
                    </tr>
                </tbody>
            </table>
            <br>
<h4>Remarks :</h4><?php echo $purchase_all_data[0]['remarks']; ?><br><br><br>
        </div>


        <?php 

}
elseif($template==1)
{
?>     
   <div class="brand-section">
   <div class="row">
      

     <div class="col-sm-5" id='company_info' style="color:white;">
            
          <b>  Company name : </b><?php echo $company_info[0]['company_name']; ?><br>
          <b> Address : </b><?php echo $company_info[0]['address']; ?><br>
          <b>  Email : </b><?php echo $company_info[0]['email']; ?><br>
          <b>  Contact : </b><?php echo $company_info[0]['mobile']; ?><br>
        </div>
        <div class="col-sm-5 text-center" style="color:white;"><h3><?php echo $header; ?></h3></div>
        <div class="col-sm-2"><img src="<?php echo  base_url().'assets/'.$logo; ?>" style='width: 100%;'>
         
         </div>
      
  </div>
        </div>
        <div class="body-section">
            <div class="row">
                <div class="col-6">
                <table id="one" style="border:none;">
    <tr><td  class="key">Vendor</td><td style="width:10px;">:</td><td calss="value"><?php echo $supplier_name;  ?></td></tr>
    <tr><td  class="key">Invoice No</td><td style="width:10px;">:</td><td calss="value"><?php echo $chalan_no;  ?></td></tr>
  
    <?php  if(!empty($isf_filling)) { ?>
    <tr><td  class="key">ISF NO</td><td style="width:10px;">:</td><td calss="value"><?php echo $isf_filling;  ?></td></tr>
<?php   }  ?>
   
</table>

                </div>
                <div class="col-6">
                <table id="two">
<tr><td  class="key">Expenses /Bill Date</td><td style="width:10px;">:</td><td calss="value"><?php echo $final_date;  ?></td></tr>
    <tr><td  class="key">Payment Due Date</td><td style="width:10px;">:</td><td calss="value"><?php echo $payment_due_date;  ?></td></tr>
    <?php  if(!empty($packing_id)) { ?>
    <tr><td  class="key">Packing Invoice No</td><td style="width:10px;">:</td><td calss="value"><?php echo $packing_id;  ?></td></tr>
    <?php   }  ?>
</table> </div>
            </div>
        </div>
        <div class="body-section">
            <table class="table-bordered">
                <thead>
                    <tr>
                    <th class="text-center text-white">S.No</th>
                        <th class="text-center text-white">Product</th>
                        <th class="text-center text-white">Description</th>
                        <th class="text-center text-white">Quantity</th>
                        <th class="text-center text-white">Unit</th>
                        <th class="text-center text-white">Rate</th>
                        <th class="text-center text-white">Total</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                                    if ($purchase_all_data) {
                               $count=1;
                                   for($i=0;$i<sizeof($purchase_all_data);$i++){ ?>
                    <tr>
                    <td style="font-size: 16px;"><?php echo $count ;?></td>
                       <td style="font-size: 16px;"><?php echo $purchase_all_data[$i]['product_name']; ?></td>
                       <td style="font-size: 16px;"><?php echo $purchase_all_data[$i]['description']; ?></td>
                       <td style="font-size: 16px;"><?php echo $purchase_all_data[$i]['quantity']; ?></td>
                       <td style="font-size: 16px;"><?php echo $purchase_all_data[$i]['slab']; ?></td>
                       <td style="font-size: 16px;"><?php echo $purchase_all_data[$i]['rate']; ?></td>
                       <td style="font-size: 16px;"><?php  echo $currency." " ; ?><?php echo $purchase_all_data[$i]['total_amount']; ?></td>
                    </tr>
                    <?php $count++;}}  ?>
                    <tr>
                        <td colspan="6" style="text-align:right;font-weight:bold;">Total</td>
                        <td style="font-size: 16px;"><?php  echo $currency." " ; ?><?php echo $purchase_all_data[0]['total']; ?></td>
                    </tr>
                    <tr>
                       
                       <td colspan="6" style="text-align:right;font-weight:bold;"><?php echo  "Tax (".$tax_des;  ?></td>
                              <td style="font-size: 16px;"><?php  echo $currency." " ; ?><?php echo $tax_amt;  ?></td>
                          </tr>
                       <tr>
                       <td colspan="6" style="text-align:right;font-weight:bold;">Grand Total:</td>
                           <td style="font-size: 16px;"><?php  echo $currency." " ; ?><?php echo $purchase_all_data[0]['grand_total_amount']; ?></td>
                       </tr>
                       <tr>
                        <td colspan="6" style="text-align:right;font-weight:bold;">Grand Total(Preferred Currency)</td>
                        <td style="font-size: 16px;"><?php echo $supplier_currency." "; ?><?php echo $purchase_all_data[0]['gtotal_preferred_currency']; ?></td>
                    </tr>
                   
                    <tr>
                        <td colspan="6" style="text-align:right;font-weight:bold;">Amount Paid</td>
                        <td style="font-size: 16px;"><?php echo $supplier_currency." "; ?><?php echo $purchase_all_data[0]['paid_amount']; ?></td>
                    </tr>
                    <tr>
                        <td colspan="6" style="text-align:right;font-weight:bold;">Balance</td>
                        <td style="font-size: 16px;"><?php echo $supplier_currency." "; ?><?php echo $purchase_all_data[0]['balance']; ?></td>
                    </tr>
                </tbody>
            </table>
            <br>
<h4>Remarks :</h4><?php echo $purchase_all_data[0]['remarks']; ?><br><br><br>
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
       
        <tr>  <td style="100px;font-weight:bold;"> Company name </td><td style="width:10px;">:</td><td> <?php echo $company_info[0]['company_name']; ?></td></tr>
        <tr>   <td style="100px;font-weight:bold;"> Address </td><td style="width:10px;">:</td><td> <?php echo $company_info[0]['address']; ?></td></tr>
        <tr>   <td style="100px;font-weight:bold;"> Email </td><td style="width:10px;">:</td><td> <?php echo $company_info[0]['email']; ?></td></tr>
        <tr>   <td style="100px;font-weight:bold;"> Contact </td><td style="width:10px;">:</td><td> <?php echo $company_info[0]['mobile']; ?></td></tr>
</tr>        
             
</table>
            </div></div>
              <div class="row"> <div class="col-sm-12 ">&nbsp;</div></div>
              <div class="row">
                <div class="col-6">
                <table id="one" style="border:none;">
    <tr><td  class="key">Vendor</td><td style="width:10px;">:</td><td calss="value"><?php echo $supplier_name;  ?></td></tr>
    <tr><td  class="key">Invoice No</td><td style="width:10px;">:</td><td calss="value"><?php echo $chalan_no;  ?></td></tr>
    <?php  if(!empty($isf_filling)) { ?>
    <tr><td  class="key">ISF NO</td><td style="width:10px;">:</td><td calss="value"><?php echo $isf_filling;  ?></td></tr>
<?php   }  ?>
   
</table>

                </div>
                <div class="col-6">
                <table id="two">
<tr><td  class="key">Expenses /Bill Date</td><td style="width:10px;">:</td><td calss="value"><?php echo $final_date;  ?></td></tr>
    <tr><td  class="key">Payment Due Date</td><td style="width:10px;">:</td><td calss="value"><?php echo $payment_due_date;  ?></td></tr>
    <?php  if(!empty($packing_id)) { ?>
    <tr><td  class="key">Packing Invoice No</td><td style="width:10px;">:</td><td calss="value"><?php echo $packing_id;  ?></td></tr>
    <?php   }  ?>
</table> </div>
            </div>
        </div>
        <div class="body-section">
            <table class="table-bordered">
                <thead>
                    <tr>
                    <th class="text-center text-white">S.No</th>
                        <th class="text-center text-white">Product</th>
                        <th class="text-center text-white">Description</th>
                        <th class="text-center text-white">Quantity</th>
                        <th class="text-center text-white">Unit</th>
                        <th class="text-center text-white">Rate</th>
                        <th class="text-center text-white">Total</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                                    if ($purchase_all_data) {
                               $count=1;
                                   for($i=0;$i<sizeof($purchase_all_data);$i++){ ?>
                    <tr>
                    <td style="font-size: 16px;"><?php echo $count ;?></td>
                       <td style="font-size: 16px;"><?php echo $purchase_all_data[$i]['product_name']; ?></td>
                       <td style="font-size: 16px;"><?php echo $purchase_all_data[$i]['description']; ?></td>
                       <td style="font-size: 16px;"><?php echo $purchase_all_data[$i]['quantity']; ?></td>
                       <td style="font-size: 16px;"><?php echo $purchase_all_data[$i]['slab']; ?></td>
                       <td style="font-size: 16px;"><?php echo $purchase_all_data[$i]['rate']; ?></td>
                       <td style="font-size: 16px;"><?php  echo $currency." " ; ?><?php echo $purchase_all_data[$i]['total_amount']; ?></td>
                    </tr>
                    <?php $count++;}}  ?>
                    <tr>
                        <td colspan="6" style="text-align:right;font-weight:bold;">Total</td>
                        <td style="font-size: 16px;"><?php  echo $currency." " ; ?><?php echo $purchase_all_data[0]['total']; ?></td>
                    </tr>
                    <tr>
                       
                       <td colspan="6" style="text-align:right;font-weight:bold;"><?php echo  "Tax (".$tax_des;  ?></td>
                              <td style="font-size: 16px;"><?php  echo $currency." " ; ?><?php echo $tax_amt;  ?></td>
                          </tr>
                       <tr>
                       <td colspan="6" style="text-align:right;font-weight:bold;">Grand Total:</td>
                           <td style="font-size: 16px;"><?php  echo $currency." " ; ?><?php echo $purchase_all_data[0]['grand_total_amount']; ?></td>
                       </tr>
                       <tr>
                        <td colspan="6" style="text-align:right;font-weight:bold;">Grand Total(Preferred Currency)</td>
                        <td style="font-size: 16px;"><?php echo $supplier_currency." "; ?><?php echo $purchase_all_data[0]['gtotal_preferred_currency']; ?></td>
                    </tr>
                   
                    <tr>
                        <td colspan="6" style="text-align:right;font-weight:bold;">Amount Paid</td>
                        <td style="font-size: 16px;"><?php echo $supplier_currency." "; ?><?php echo $purchase_all_data[0]['paid_amount']; ?></td>
                    </tr>
                    <tr>
                        <td colspan="6" style="text-align:right;font-weight:bold;">Balance</td>
                        <td style="font-size: 16px;"><?php echo $supplier_currency." "; ?><?php echo $purchase_all_data[0]['balance']; ?></td>
                    </tr>
                </tbody>
            </table>
            <br>
<h4>Remarks :</h4><?php echo $purchase_all_data[0]['remarks']; ?><br><br><br>
        </div>

        <?php  } ?>

    </div>

</div>

<div class="modal fade" id="myModal_ex" role="dialog" >
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content" style="width: 500px;height:100px;text-align:center;margin-bottom: 300px;">
        <div class="modal-header" style="">
      
          <h4 class="modal-title">New Expenses</h4>
        </div>
        <div class="content">

        <div class="modal-body">
          
          <h4>New Expenses Downloaded Successfully</h4>
     
        </div>
        <div class="modal-footer">
        </div>
        </div>
      </div>
      
    </div>
  </div>

<style>

.key{
    border:none;
    text-align:left;
font-weight:bold;

}
.value{
    border:none;
    text-align:left;
}
#one,#two{
float:left;
width:100%;
}
body{
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
.logo{
    width: 50%;
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
    border: 1px solid #111;
    background-color: #5961b3;
   
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
.content {
    min-height: 0px;
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
  }).save('invoice_no_<?php echo $chalan_no.'.pdf'  ?>');
    callback1();
    callback2();
 }, 2500 );
}
function second(){
setTimeout( function(){
    $( '#myModal_ex' ).addClass( 'open' );
if ( $( '#myModal_ex' ).hasClass( 'open' ) ) {
  $( '.container' ).addClass( 'blur' );
}
$( '.close' ).click(function() {
  $( '#myModal_ex' ).removeClass( 'open' );
  $( '.cont' ).removeClass( 'blur' );
});
}, 2500 );
}
function third(){
    setTimeout( function(){
        window.location='<?php  echo base_url();   ?>'+'Cpurchase/manage_purchase';
        window.close();
    }, 3500 );
}
first(second,third);
});
</script>





