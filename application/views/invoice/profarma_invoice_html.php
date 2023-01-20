<!-- Purchase Payment Ledger Start -->
<div class="content-wrapper">
	<section class="content-header">
	    <div class="header-icon">
	        <i class="pe-7s-note2"></i>
	    </div>
	    <div class="header-title">
	        <h1>Purchase Order Invoice</h1>
	        <small>Purchase Order Invoice</small>
	        <ol class="breadcrumb">
	            <li><a href="#"><i class="pe-7s-home"></i> <?php echo display('home') ?></a></li>
	            <li><a href="#">Purchase Order Invoice</a></li>
	            <li class="active">Purchase Order Invoice</li>
	        </ol>
	    </div>
	</section>

	<!-- Invoice information -->
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

<div class="container" id="content">
<?php

   $myArray = explode('(',$tax); 
 $tax_amt=$myArray[0];
 $tax_des=$myArray[1];
 $tax_des=str_replace(")","%)", $tax_des);


            //////////////Design one///////////// 
            if($template==2)
            {
            ?>
        <div class="brand-section">
        <div class="row" >
     
     <div class="col-sm-2"><img src="<?php echo  base_url().'assets/'.$logo; ?>" style='width: 100%;'>
        
       </div>
     <div class="col-sm-6 text-center" style="color:white;"><h3><?php echo $header; ?></h3></div>
    <div class="col-sm-4" style="color:white;font-weight:bold;" id='company_info'>
           
          <b> Company name : </b><?php echo $cname; ?><br>
          <b>   Address : </b><?php echo $address; ?><br>
          <b>   Email : </b><?php echo $email; ?><br>
          <b>   Contact : </b><?php echo $phone; ?><br>
       </div>
 </div>
        </div>

        <div class="body-section">
            <div class="row">
                <div class="col-6">
                <table id="one" >
    <tr><td  class="key">Date</td><td style="width:10px;">:</td><td calss="value"><?php echo $purchase_date;  ?></td></tr>
    <tr><td  class="key">Invoice No</td><td style="width:10px;">:</td><td calss="value"><?php echo $chalan_no;  ?></td></tr>
    <tr><td  class="key">Pre Carriage By</td><td style="width:10px;">:</td><td calss="value">{pre_carriage}</td></tr>
    <tr><td  class="key">Country of origin of goods</td><td style="width:10px;">:</td><td calss="value"> <?php echo $country_goods;  ?></td></tr>

    <tr><td  class="key">Terms of payment<br> and delivery</td><td style="width:10px;">:</td><td calss="value"><?php echo $terms_payment;  ?></td></tr>
 
</table>

                </div>
                <div class="col-6">
                <table id="two">
<tr><td  class="key">Buyer/Customer</td><td style="width:10px;">:</td><td calss="value"><?php echo $customer;  ?></td></tr>
    <tr><td  class="key">Place of Receipt</td><td style="width:10px;">:</td><td calss="value"><?php echo $receipt;  ?></td></tr>
    <tr><td  class="key">Country of final destination</td><td style="width:10px;">:</td><td calss="value">{country_destination}</td></tr>
    <tr><td class="key">Port of discharge</td><td style="width:10px;">:</td><td calss="value"><?php echo $discharge;  ?></td></tr>
    <tr><td  class="key">Port of loading</td><td style="width:10px;">:</td><td calss="value"><?php echo $loading;  ?></td></tr>
 
</table>
    </div>
            </div>
        </div>

        <div class="body-section">
            <table class="table-bordered" style="outline:thick solid;">
            <thead>
      <tr>
      <th data-column-id="id" class="ID"   style="width:100px;" >S.No</th>
        <th data-column-id="Invoice" class="Invoice No" >Product Name</th>
        <th data-column-id="Sale By" class="Sale By" >Quantity</th>
        <th data-column-id="Customer Name" class="Customer Name"  >Rate</th>
        <th data-column-id="date" class="Date"  >Total Amount</th>
       
      </tr>
    </thead>
                <tbody>
                <?php
                                    if ($order) {
                               $count=1;
                                   for($i=0;$i<sizeof($order);$i++){ ?>
                    <tr>
                        <td style="font-size: 16px;"><?php echo $count ;?></td>
                        <td style="font-size: 16px;"><?php echo $order[$i]['product_name']; ?></td>
                       <td style="font-size: 16px;"><?php echo $order[$i]['quantity']; ?></td>
                       <td style="font-size: 16px;"><?php  echo $currency." " ; ?><?php echo $order[$i]['rate']; ?></td>
                       <td style="font-size: 16px;"><?php  echo $currency." " ; ?><?php echo $order[$i]['total_amount'];  ?></td>
                    </tr>
                    <?php $count++;}}  ?>
                    </tbody>
                    <tfoot>
                    <tr>
                        <td colspan="4" style="text-align:right;font-weight:bold;">Total:</td>
                        <td style="font-size: 16px;"><?php  echo $currency." " ; ?><?php echo $total;  ?></td>
                    </tr>
                    <tr>
                       
                    <td colspan="4" style="text-align:right;font-weight:bold;"><?php echo  "Tax (".$tax_des;  ?></td>
                        <td style="font-size: 16px;"><?php  echo $currency." " ; ?><?php echo $tax_amt;  ?></td>
                    </tr>
                    <tr>
                        <td colspan="4" style="text-align:right;font-weight:bold;">Grand Total:</td>
                        <td style="font-size: 16px;"><?php  echo $currency." " ; ?><?php echo $gtotal;  ?></td>
                    </tr>
                    <?php   if($customer_gtotal >0){ ?>
                    <tr>
                        <td colspan="4" style="text-align:right;font-weight:bold;">Grand Total(Preferred Currency):</td>
                        <td style="font-size: 16px;"><?php  echo $customer_currency." " ; ?><?php echo $customer_gtotal;  ?></td>
                    </tr>
                 <?php  }  ?>
                    </tfoot>
            </table>
            <br>

    <h4>Description of goods : </h4><?php  echo  $description_goods ; ?><br><br>
            <h4>Account Details/Additional Information : </h4><?php  echo  $ac_details ; ?><br><br>

<h4>Remarks/Conditions : </h4><?php  echo  $remarks; ?><br><br>
        
            
        </div>

        
    </div>
    <?php 

}
elseif($template==1)
{
?>     
   <div class="brand-section">
   <div class="row">
      
      <div class="col-sm-2"><img src="<?php echo  base_url().'assets/'.$logo; ?>" style='width: 100%;'>
         
        </div>
      <div class="col-sm-6 text-center" style="color:white;"><h3><?php echo $header; ?></h3></div>
     <div class="col-sm-4" id='company_info' style="color:white;">
            
          <b>  Company name : </b><?php echo $cname; ?><br>
          <b> Address : </b><?php echo $address; ?><br>
          <b>  Email : </b><?php echo $email; ?><br>
          <b>  Contact : </b><?php echo $phone; ?><br>
        </div>
  </div>
        </div>

        <div class="body-section">
            <div class="row">
                <div class="col-6">
                <table id="one" >
    <tr><td  class="key">Date</td><td style="width:10px;">:</td><td calss="value"><?php echo $purchase_date;  ?></td></tr>
    <tr><td  class="key">Invoice No</td><td style="width:10px;">:</td><td calss="value"><?php echo $chalan_no;  ?></td></tr>
    <tr><td  class="key">Pre Carriage By</td><td style="width:10px;">:</td><td calss="value">{pre_carriage}</td></tr>
    <tr><td  class="key">Country of origin of goods</td><td style="width:10px;">:</td><td calss="value"> <?php echo $country_goods;  ?></td></tr>
   
    <tr><td  class="key">Terms of payment<br> and delivery</td><td style="width:10px;">:</td><td calss="value"><?php echo $terms_payment;  ?></td></tr>
 
</table>

                </div>
                <div class="col-6">
                <table id="two">
<tr><td  class="key">Buyer/Customer</td><td style="width:10px;">:</td><td calss="value"><?php echo $customer;  ?></td></tr>
    <tr><td  class="key">Place of Receipt</td><td style="width:10px;">:</td><td calss="value"><?php echo $receipt;  ?></td></tr>
    <tr><td  class="key">Country of final destination</td><td style="width:10px;">:</td><td calss="value">{country_destination}</td></tr>
    <tr><td class="key">Port of discharge</td><td style="width:10px;">:</td><td calss="value"><?php echo $discharge;  ?></td></tr>
    <tr><td  class="key">Port of loading</td><td style="width:10px;">:</td><td calss="value"><?php echo $loading;  ?></td></tr>

</table>
    </div>
            </div>
        </div>

        <div class="body-section">
            <table class="table-bordered" style="outline:thick solid;">
            <thead>
      <tr>
      <th data-column-id="id" class="ID"   style="width:100px;" >S.No</th>
        <th data-column-id="Invoice" class="Invoice No" >Product Name</th>
        <th data-column-id="Sale By" class="Sale By" >Quantity</th>
        <th data-column-id="Customer Name" class="Customer Name"  >Rate</th>
        <th data-column-id="date" class="Date"  >Total Amount</th>
       
      </tr>
    </thead>
                <tbody>
                <?php
                                    if ($order) {
                               $count=1;
                                   for($i=0;$i<sizeof($order);$i++){ ?>
                    <tr>
                        <td style="font-size: 16px;"><?php echo $count ;?></td>
                        <td style="font-size: 16px;"><?php echo $order[$i]['product_name']; ?></td>
                       <td style="font-size: 16px;"><?php echo $order[$i]['quantity']; ?></td>
                       <td style="font-size: 16px;"><?php  echo $currency." " ; ?><?php echo $order[$i]['rate']; ?></td>
                       <td style="font-size: 16px;"><?php  echo $currency." " ; ?><?php echo $order[$i]['total_amount'];  ?></td>
                    </tr>
                    <?php $count++;}}  ?>
                    </tbody>
                    <tfoot>
                    <tr>
                        <td colspan="4" style="text-align:right;font-weight:bold;">Total:</td>
                        <td style="font-size: 16px;"><?php  echo $currency." " ; ?><?php echo $total;  ?></td>
                    </tr>
                    <tr>
                       
                        <td colspan="4" style="text-align:right;font-weight:bold;"><?php echo  "Tax (".$tax_des;  ?></td>
                        <td style="font-size: 16px;"><?php  echo $currency." " ; ?><?php echo $tax_amt;  ?></td>
                    </tr>
                    <tr>
                        <td colspan="4" style="text-align:right;font-weight:bold;">Grand Total:</td>
                        <td style="font-size: 16px;"><?php  echo $currency." " ; ?><?php echo $gtotal;  ?></td>
                    </tr>
                    <?php   if($customer_gtotal >0){ ?>
                    <tr>
                        <td colspan="4" style="text-align:right;font-weight:bold;">Grand Total(Preferred Currency):</td>
                        <td style="font-size: 16px;"><?php  echo $customer_currency." " ; ?><?php echo $customer_gtotal;  ?></td>
                    </tr>
                 <?php  }  ?>
                    </tfoot>
            </table>
            <br>
            <h4>Description of goods : </h4><?php  echo  $description_goods ; ?><br><br>
            <h4>Account Details/Additional Information : </h4><?php  echo  $ac_details ; ?><br><br>

<h4>Remarks/Conditions : </h4><?php  echo  $remarks; ?><br><br>
        
            
        </div>

        
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
       
        <tr>  <td style="100px;font-weight:bold;"> Company name </td><td style="width:10px;">:</td><td> <?php echo $cname; ?></td></tr>
        <tr>   <td style="100px;font-weight:bold;"> Address </td><td style="width:10px;">:</td><td> <?php echo $address; ?></td></tr>
        <tr>   <td style="100px;font-weight:bold;"> Email </td><td style="width:10px;">:</td><td> <?php echo $email; ?></td></tr>
        <tr>   <td style="100px;font-weight:bold;"> Contact </td><td style="width:10px;">:</td><td> <?php echo $phone; ?></td></tr>
</tr>        
             
</table>
            </div></div>
              <div class="row"> <div class="col-sm-12 ">&nbsp;</div></div>
            <div class="row">
            
                <div class="col-6">
                <table id="one" >
    <tr><td  class="key">Date</td><td style="width:10px;">:</td><td calss="value"><?php echo $purchase_date;  ?></td></tr>
    <tr><td  class="key">Invoice No</td><td style="width:10px;">:</td><td calss="value"><?php echo $chalan_no;  ?></td></tr>
    <tr><td  class="key">Pre Carriage By</td><td style="width:10px;">:</td><td calss="value">{pre_carriage}</td></tr>
    <tr><td  class="key">Country of origin of goods</td><td style="width:10px;">:</td><td calss="value"> <?php echo $country_goods;  ?></td></tr>

    <tr><td  class="key">Terms of payment<br> and delivery</td><td style="width:10px;">:</td><td calss="value"><?php echo $terms_payment;  ?></td></tr>
 
</table>

                </div>
                <div class="col-6">
                <table id="two">
<tr><td  class="key">Buyer/Customer</td><td style="width:10px;">:</td><td calss="value"><?php echo $customer;  ?></td></tr>
    <tr><td  class="key">Place of Receipt</td><td style="width:10px;">:</td><td calss="value"><?php echo $receipt;  ?></td></tr>
    <tr><td  class="key">Country of final destination</td><td style="width:10px;">:</td><td calss="value">{country_destination}</td></tr>
    <tr><td class="key">Port of discharge</td><td style="width:10px;">:</td><td calss="value"><?php echo  $discharge;  ?></td></tr>
    <tr><td  class="key">Port of loading</td><td style="width:10px;">:</td><td calss="value"><?php echo $loading;  ?></td></tr>

</table>
    </div>
            </div>
        </div>

        <div class="body-section">
            <table class="table-bordered" style="outline:thick solid;">
            <thead>
      <tr>
      <th data-column-id="id" class="ID"   style="width:100px;" >S.No</th>
        <th data-column-id="Invoice" class="Invoice No" >Product Name</th>
        <th data-column-id="Sale By" class="Sale By" >Quantity</th>
        <th data-column-id="Customer Name" class="Customer Name"  >Rate</th>
        <th data-column-id="date" class="Date"  >Total Amount</th>
       
      </tr>
    </thead>
                <tbody>
                <?php
                                    if ($order) {
                               $count=1;
                                   for($i=0;$i<sizeof($order);$i++){ ?>
                    <tr>
                        <td style="font-size: 16px;"><?php echo $count ;?></td>
                        <td style="font-size: 16px;"><?php echo $order[$i]['product_name']; ?></td>
                       <td style="font-size: 16px;"><?php echo $order[$i]['quantity']; ?></td>
                       <td style="font-size: 16px;"><?php  echo $currency." " ; ?><?php echo $order[$i]['rate']; ?></td>
                       <td style="font-size: 16px;"><?php  echo $currency." " ; ?><?php echo $order[$i]['total_amount'];  ?></td>
                    </tr>
                    <?php $count++;}}  ?>
                    </tbody>
                    <tfoot>
                    <tr>
                        <td colspan="4" style="text-align:right;font-weight:bold;">Total:</td>
                        <td style="font-size: 16px;"><?php  echo $currency." " ; ?><?php echo $total;  ?></td>
                    </tr>
                    <tr>
                       
                        <td colspan="4" style="text-align:right;font-weight:bold;"><?php echo  "Tax (".$tax_des;  ?></td>
                        <td style="font-size: 16px;"><?php  echo $currency." " ; ?><?php echo $tax_amt;  ?></td>
                    </tr>
                    <tr>
                        <td colspan="4" style="text-align:right;font-weight:bold;">Grand Total:</td>
                        <td style="font-size: 16px;"><?php  echo $currency." " ; ?><?php echo $gtotal;  ?></td>
                    </tr>
                    <?php   if($customer_gtotal >0){ ?>
                    <tr>
                        <td colspan="4" style="text-align:right;font-weight:bold;">Grand Total(Preferred Currency):</td>
                        <td style="font-size: 16px;"><?php  echo $customer_currency." " ; ?><?php echo $customer_gtotal;  ?></td>
                    </tr>
                 <?php  }  ?>
                    </tfoot>
            </table>
            <br>
            <h4>Description of goods : </h4><?php  echo  $description_goods ; ?><br><br>
            <h4>Account Details/Additional Information : </h4><?php  echo  $ac_details ; ?><br>

<h4>Remarks/Conditions : </h4><?php  echo  $remarks; ?>
        
            
        </div>

        
    </div>
    <?php  } ?>
    </div>
	</section>

<!-- Purchase ledger End  -->

<div class="modal fade" id="myModal_profarma" role="dialog" >
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content" style="width: 500px;height:100px;text-align:center;margin-bottom: 300px;">
        <div class="modal-header" style="">
      
          <h4 class="modal-title">Sales - Profarma Invoice</h4>
        </div>
        <div class="content">

        <div class="modal-body" style="text-align:center;font-weight:bold;">
          
          <h4>Profarma Invoice Downloaded Successfully</h4>
     
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
 }, 1500 );
}
function second(){
setTimeout( function(){
    $( '#myModal_profarma' ).addClass( 'open' );
if ( $( '#myModal_profarma' ).hasClass( 'open' ) ) {
  $( '.container' ).addClass( 'blur' );
}
$( '.close' ).click(function() {
  $( '#myModal_profarma' ).removeClass( 'open' );
  $( '.cont' ).removeClass( 'blur' );
});
}, 1500 );
}
function third(){
    setTimeout( function(){
        window.location='<?php  echo base_url();   ?>'+'Cinvoice/manage_profarma_invoice';
        window.close();
    }, 3000 );
}
first(second,third);
});
   </script>