

<?php                

error_reporting(1);
include_once('tcpdf_6_2_13/tcpdf.php'); 
$base_url=$this->session->userdata('base');
if(1==1) 
{
  //----- Code for generate pdf
  $pdf = new TCPDF('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
  $pdf->SetCreator(PDF_CREATOR);  
  //$pdf->SetTitle("Export HTML Table data to PDF using TCPDF in PHP");  
  $pdf->SetHeaderData('', '', PDF_HEADER_TITLE, PDF_HEADER_STRING);  
  $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));  
  $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));  
  $pdf->SetDefaultMonospacedFont('helvetica');  
  $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);  
  $pdf->SetMargins(PDF_MARGIN_LEFT, '5', PDF_MARGIN_RIGHT);  
  $pdf->setPrintHeader(false);  
  $pdf->setPrintFooter(false);  
  $pdf->SetAutoPageBreak(TRUE, 10);  
  $pdf->SetFont('helvetica', '', 12);  
  $pdf->AddPage(); //default A4
  //$pdf->AddPage('P','A5'); //when you require custome page size 
  
 
 $myArray = explode('(',$invoice_info[0]['total_tax']); 
 // print_r($myArray); die();
 $tax_amt=$myArray[0];
 $tax_des=$myArray[1];


  $content = ''; 
    $content .= '<!DOCTYPE html>
<html>
  <head>
    <style>
      body {
        border: 1px solid #dee2e6;
      }
      table {
        font-family: arial, sans-serif;
        border-collapse: collapse;
        width: 100%;
      }

      td,
      th {
        border: 1px solid #dddddd;
        text-align: left;
        padding: 10px;
      }
      .table_view {
        border: 1px solid #111;
        background-color: #5961b3;
      }

      .header_view {
        background-color: #5961b3;
        padding: 10px 40px;
      }
      table .heading{
            border: 1px solid #111;
            background-color:#5961b3;
        }
        .text_color{
            color: #fff;
        }
        .heading_view{
           margin-left: 10px;
        }

    </style>
  </head>
  <body>';
  if($template==2){

   $content .= '<table>
      <tr class="header_view">
        <td style="border: none">
          <img src='.$base_url.'assets/'.$company_info[0]['logo'].' width="100px" />
          <br />
        </td>
         <td style="border: none; color: white">'.$company_info[0]['address'].'</td>
        <td style="border: none; text-align: right; color: white">'.$company_info[0]['company_name'].'</td>
      </tr>
    </table>
    <br><br>

    <table class="table_view_content">
      <tr>
        <td style="border: none; font-weight: normal; line-height: 20px;"><b>Commercial Invoice Number</b>&nbsp;<span>&nbsp;: &nbsp;'.$invoice[0]['commercial_invoice_number'].'</span></td>
        <td style="border: none; font-weight: normal; line-height: 20px;"><b>Container Number</b>&nbsp;<span>&nbsp; : &nbsp;'.$invoice[0]['container_no'].'</span></td>
      </tr>
      

      <tr>
        <td style="border: none; font-weight: normal; line-height: 20px;"><b>Customer Name </b> &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;<span> &nbsp; : &nbsp;Name</span></td>
        <td style="border: none; font-weight: normal; line-height: 20px;"><b>BL/No </b>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;<span>&nbsp; : &nbsp;'.$invoice[0]['bl_no'].'</span></td>
      </tr>
      

      <tr>
        <td style="border: none; font-weight: normal; line-height: 20px;"><b>Invoice No</b> &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; <span style="margin-left: 4px;">&nbsp; : &nbsp;'.$invoice[0]['invoice'].'</span></td>
        <td style="border: none; font-weight: normal; line-height: 20px;"><b>Number of days</b>  &nbsp; &nbsp; <span>&nbsp; : &nbsp;'.$invoice[0]['number_of_days'].'</span></td>
      </tr>
       

      <tr>
        <td style="border: none; font-weight: normal; line-height: 20px;"><b>Payment due date</b> &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;<span style="margin-left: 4px;">&nbsp; : &nbsp;'.$invoice[0]['payment_due_date'].'</span></td>
        <td style="border: none; font-weight: normal; line-height: 20px;"><b>Port of discharge</b>  &nbsp;<span style="margin-left:2px;">&nbsp; : &nbsp;'.$invoice[0]['port_of_discharge'].'</span></td>
      </tr>
      

      <tr>
        <td style="border: none; font-weight: normal; line-height: 20px;"><b>ETA </b>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;<span>&nbsp; : &nbsp;'.$invoice[0]['eta'].'</span></td>
        <td style="border: none; font-weight: normal; line-height: 20px;"><b>Billing Address </b>  &nbsp; &nbsp; &nbsp;<span >&nbsp; : &nbsp;'.$invoice[0]['billing_address'].'</span></td>
      </tr>
      
      <tr>
        <td style="border: none; font-weight: normal; line-height: 20px;"><b>ETD </b>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;<span>&nbsp; : &nbsp;'.$invoice[0]['etd'].'</span></td>
        <td style="border: none; font-weight: normal; line-height: 20px;"><b>Payment Type </b>  &nbsp; &nbsp; &nbsp; &nbsp;<span>&nbsp; : &nbsp;'.$invoice[0]['payment_type'].'</span></td>
      </tr>
    </table>

    <br><br><br>
    <table>
      <tr class="heading">
        <th class="text_color">S.No</th>
        <th class="text_color">Product Name</th>
        <th class="text_color">In Stock</th>
        <th class="text_color">Quantity / Sq ft.</th>
        <th class="text_color">Amount</th>
        <th class="text_color">Total</th>
      </tr>';
       if ($product_info) {
                               $count=1;
                                   for($i=0;$i<sizeof($product_info);$i++){
        $content .='<tr>
        <td class="data_view">'.$count.'</td>                           
        <td>'.$product_info[$i]['product_name'].'</td>
        <td>'.$product_info[$i]['p_quantity'].'</td>
        <td>'.$invoice_info[$i]['quantity'].'</td>
        <td>'.$currency[$i]['currency'].' '.$invoice_info[$i]['rate'].'</td>
        <td>'.$currency[$i]['currency'].' '.$invoice_info[$i]['total_price'].'.00</td>
        </tr>';
        $count++;
      }
    }
      $content .='<tr>
        <td colspan="5" style="text-align: right;">Total:</td>
        <td>'.$currency[0]['currency'].' '.$invoice_info[0]['total_amount'].'</td>
      </tr>
      <tr>
        <td colspan="5" style="text-align:right;">Tax:&nbsp;('.$tax_des.'</td>
        <td>'.$currency[0]['currency'].''.$tax_amt.'</td>
      </tr>
      <tr>
        <td colspan="5" style="text-align: right;">Grand Total:</td>
        <td>'.$currency[0]['currency'].' '.$invoice_info[0]['gtotal'].'</td>
      </tr>
     
    </table>
    <br>
    <h3 class="heading_view">Account Details/Additional Information : <span style="font-weight: normal;">'.$invoice[0]['ac_details'].'</span></h3>
    <h3 class="heading_view">Remarks/Conditions : <span style="font-weight: normal;">'.$invoice[0]['remark'].'</span></h3>';
  }elseif($template==1){
$content .= '<table>
      <tr class="header_view">
        <td style="border: none">
        <img src='.$base_url.'assets/'.$company_info[0]['logo'].' width="100px" />
          <br />
        </td>
         <td style="border: none; color: white">'.$company_info[0]['address'].'</td>
        <td style="border: none; text-align: right; color: white">'.$company_info[0]['address'].'</td>
      </tr>
    </table>
    <br />

    <table class="table_view_content">
      <tr>
        <td style="border: none; font-weight: normal; line-height: 20px;"><b>Commercial Invoice Number</b>&nbsp;<span>&nbsp;: &nbsp;'.$invoice[0]['commercial_invoice_number'].'</span></td>
        <td style="border: none; font-weight: normal; line-height: 20px;"><b>Container Number</b>&nbsp;<span>&nbsp; : &nbsp;'.$invoice[0]['container_no'].'</span></td>
      </tr>
      

      <tr>
        <td style="border: none; font-weight: normal; line-height: 20px;"><b>Customer Name </b> &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;<span> &nbsp; : &nbsp;Name</span></td>
        <td style="border: none; font-weight: normal; line-height: 20px;"><b>BL/No </b>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;<span>&nbsp; : &nbsp;'.$invoice[0]['bl_no'].'</span></td>
      </tr>
      

      <tr>
        <td style="border: none; font-weight: normal; line-height: 20px;"><b>Invoice No</b> &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; <span style="margin-left: 4px;">&nbsp; : &nbsp;'.$invoice[0]['invoice'].'</span></td>
        <td style="border: none; font-weight: normal; line-height: 20px;"><b>Number of days</b>  &nbsp; &nbsp; <span>&nbsp; : &nbsp;'.$invoice[0]['number_of_days'].'</span></td>
      </tr>
       

      <tr>
        <td style="border: none; font-weight: normal; line-height: 20px;"><b>Payment due date</b> &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;<span style="margin-left: 4px;">&nbsp; : &nbsp;'.$invoice[0]['payment_due_date'].'</span></td>
        <td style="border: none; font-weight: normal; line-height: 20px;"><b>Port of discharge</b>  &nbsp;<span style="margin-left:2px;">&nbsp; : &nbsp;'.$invoice[0]['port_of_discharge'].'</span></td>
      </tr>
      

      <tr>
        <td style="border: none; font-weight: normal; line-height: 20px;"><b>ETA </b>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;<span>&nbsp; : &nbsp;'.$invoice[0]['eta'].'</span></td>
        <td style="border: none; font-weight: normal; line-height: 20px;"><b>Billing Address </b>  &nbsp; &nbsp; &nbsp;<span >&nbsp; : &nbsp;'.$invoice[0]['billing_address'].'</span></td>
      </tr>
      
      <tr>
        <td style="border: none; font-weight: normal; line-height: 20px;"><b>ETD </b>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;<span>&nbsp; : &nbsp;'.$invoice[0]['etd'].'</span></td>
        <td style="border: none; font-weight: normal; line-height: 20px;"><b>Payment Type </b>  &nbsp; &nbsp; &nbsp; &nbsp;<span>&nbsp; : &nbsp;'.$invoice[0]['payment_type'].'</span></td>
      </tr>
    </table>

    <br /><br />
    <table>
      <tr class="heading">
        <th class="text_color">S.No</th>
        <th class="text_color">Product Name</th>
        <th class="text_color">In Stock</th>
        <th class="text_color">Quantity / Sq ft.</th>
        <th class="text_color">Amount</th>
        <th class="text_color">Total</th>
      </tr>';
       if ($product_info) {
                               $count=1;
                                   for($i=0;$i<sizeof($product_info);$i++){
        $content .='<tr>
        <td class="data_view">'.$count.'</td>                           
        <td>'.$product_info[$i]['product_name'].'</td>
        <td>'.$product_info[$i]['p_quantity'].'</td>
        <td>'.$invoice_info[$i]['quantity'].'</td>
        <td>'.$currency[$i]['currency'].' '.$invoice_info[$i]['rate'].'</td>
        <td>'.$currency[$i]['currency'].' '.$invoice_info[$i]['total_price'].'.00</td>
        </tr>';
        $count++;
      }
    }
      $content .='<tr>
        <td colspan="5" style="text-align: right;">Total:</td>
        <td>'.$currency[0]['currency'].' '.$invoice_info[0]['total_amount'].'</td>
      </tr>
      <tr>
        <td colspan="5" style="text-align:right;">Tax:&nbsp;('.$tax_des.'</td>
        <td>'.$currency[0]['currency'].''.$tax_amt.'</td>
      </tr>
      <tr>
        <td colspan="5" style="text-align: right;">Grand Total:</td>
        <td>'.$currency[0]['currency'].' '.$invoice_info[0]['gtotal'].'</td>
      </tr>
     
    </table>
    <br>
    <h3 class="heading_view">Account Details/Additional Information : <span style="font-weight: normal;">'.$invoice[0]['ac_details'].'</span></h3>
    <h3 class="heading_view">Remarks/Conditions : <span style="font-weight: normal;">'.$invoice[0]['remark'].'</span></h3>';
  }elseif($template==3){
    $content .= '<table>
      <tr class="header_view">
        <td style="border: none">
        <img src='.$base_url.'assets/'.$company_info[0]['logo'].' width="100px" />
          <br />
        </td>
         <td style="border: none; color: white">'.$company_info[0]['address'].'</td>
        <td style="border: none; text-align: right; color: white">'.$company_info[0]['address'].'</td>
      </tr>
    </table>
    <br />

    <table class="table_view_content">
      <tr>
        <td style="border: none; font-weight: normal; line-height: 20px;"><b>Commercial Invoice Number</b>&nbsp;<span>&nbsp;: &nbsp;'.$invoice[0]['commercial_invoice_number'].'</span></td>
        <td style="border: none; font-weight: normal; line-height: 20px;"><b>Container Number</b>&nbsp;<span>&nbsp; : &nbsp;'.$invoice[0]['container_no'].'</span></td>
      </tr>
      

      <tr>
        <td style="border: none; font-weight: normal; line-height: 20px;"><b>Customer Name </b> &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;<span> &nbsp; : &nbsp;Name</span></td>
        <td style="border: none; font-weight: normal; line-height: 20px;"><b>BL/No </b>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;<span>&nbsp; : &nbsp;'.$invoice[0]['bl_no'].'</span></td>
      </tr>
      

      <tr>
        <td style="border: none; font-weight: normal; line-height: 20px;"><b>Invoice No</b> &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; <span style="margin-left: 4px;">&nbsp; : &nbsp;'.$invoice[0]['invoice'].'</span></td>
        <td style="border: none; font-weight: normal; line-height: 20px;"><b>Number of days</b>  &nbsp; &nbsp; <span>&nbsp; : &nbsp;'.$invoice[0]['number_of_days'].'</span></td>
      </tr>
       

      <tr>
        <td style="border: none; font-weight: normal; line-height: 20px;"><b>Payment due date</b> &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;<span style="margin-left: 4px;">&nbsp; : &nbsp;'.$invoice[0]['payment_due_date'].'</span></td>
        <td style="border: none; font-weight: normal; line-height: 20px;"><b>Port of discharge</b>  &nbsp;<span style="margin-left:2px;">&nbsp; : &nbsp;'.$invoice[0]['port_of_discharge'].'</span></td>
      </tr>
      

      <tr>
        <td style="border: none; font-weight: normal; line-height: 20px;"><b>ETA </b>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;<span>&nbsp; : &nbsp;'.$invoice[0]['eta'].'</span></td>
        <td style="border: none; font-weight: normal; line-height: 20px;"><b>Billing Address </b>  &nbsp; &nbsp; &nbsp;<span >&nbsp; : &nbsp;'.$invoice[0]['billing_address'].'</span></td>
      </tr>
      
      <tr>
        <td style="border: none; font-weight: normal; line-height: 20px;"><b>ETD </b>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;<span>&nbsp; : &nbsp;'.$invoice[0]['etd'].'</span></td>
        <td style="border: none; font-weight: normal; line-height: 20px;"><b>Payment Type </b>  &nbsp; &nbsp; &nbsp; &nbsp;<span>&nbsp; : &nbsp;'.$invoice[0]['payment_type'].'</span></td>
      </tr>
    </table>

    <br /><br />
    <table>
      <tr class="heading">
        <th class="text_color">S.No</th>
        <th class="text_color">Product Name</th>
        <th class="text_color">In Stock</th>
        <th class="text_color">Quantity / Sq ft.</th>
        <th class="text_color">Amount</th>
        <th class="text_color">Total</th>
      </tr>';
       if ($product_info) {
                               $count=1;
                                   for($i=0;$i<sizeof($product_info);$i++){
        $content .='<tr>
        <td class="data_view">'.$count.'</td>                           
        <td>'.$product_info[$i]['product_name'].'</td>
        <td>'.$product_info[$i]['p_quantity'].'</td>
        <td>'.$invoice_info[$i]['quantity'].'</td>
        <td>'.$currency[$i]['currency'].' '.$invoice_info[$i]['rate'].'</td>
        <td>'.$currency[$i]['currency'].' '.$invoice_info[$i]['total_price'].'.00</td>
        </tr>';
        $count++;
      }
    }
      $content .='<tr>
        <td colspan="5" style="text-align: right;">Total:</td>
        <td>'.$currency[0]['currency'].' '.$invoice_info[0]['total_amount'].'</td>
      </tr>
      <tr>
        <td colspan="5" style="text-align:right;">Tax:&nbsp;('.$tax_des.'</td>
        <td>'.$currency[0]['currency'].''.$tax_amt.'</td>
      </tr>
      <tr>
        <td colspan="5" style="text-align: right;">Grand Total:</td>
        <td>'.$currency[0]['currency'].' '.$invoice_info[0]['gtotal'].'</td>
      </tr>
     
    </table>
    <br>
    <h3 class="heading_view">Account Details/Additional Information : <span style="font-weight: normal;">'.$invoice[0]['ac_details'].'</span></h3>
    <h3 class="heading_view">Remarks/Conditions : <span style="font-weight: normal;">'.$invoice[0]['remark'].'</span></h3>';
  }
  $content .= '</body></html>'; 
 $content;
//echo $content;
//die();
$pdf->writeHTML($content);

// $file_location =  base_url()."Pdf/"; //add your full path of your server
//$file_location = "/opt/lampp/htdocs/examples/generate_pdf/uploads/"; //for local xampp server

$file_location = "";

$datetime=date('dmY_hms');
$file_name = $invoiceid."_".$datetime.".pdf";
//echo $file_location.$file_name;die();
ob_end_clean();


 if(1==1)
{

$pdf->Output($file_location.$file_name, 'F',777); // F means upload PDF file on some folder

include 'mail.php';
}
else 
{
$pdf->Output($file_location.$file_name, 'F'); // F means upload PDF file on some folder
//echo "Email send successfully!!";

  include_once('PHPMailer/class.phpmailer.php');  
  require ('PHPMailer/PHPMailerAutoload.php');

  $body='';
  $body .="<html>
  <head>
  <style type='text/css'> 
  body {
  font-family: Calibri;
  font-size:16px;
  color:#000;
  }
  </style>
  </head>
  <body>
  Dear Customer,
  <br>
  Please find attached invoice copy.
  <br>
  Thank you!
  </body>
  </html>";

  $mail = new PHPMailer();
  $mail->CharSet = 'UTF-8';
  $mail->IsMAIL();
  $mail->IsSMTP();
  $mail->Subject    = "Invoice details";
  $mail->From = "mail@shinerweb.com";
  $mail->FromName = "Shinerweb Technologies";
  $mail->IsHTML(true);
  $mail->AddAddress('rammg1985@gmail.com'); // To mail id
  //$mail->AddCC('info.shinerweb@gmail.com'); // Cc mail id
  //$mail->AddBCC('info.shinerweb@gmail.com'); // Bcc mail id

  $mail->AddAttachment($file_location.$file_name);
  $mail->MsgHTML ($body);
  $mail->WordWrap = 50;
  $mail->Send();  
  $mail->SmtpClose();
  if($mail->IsError()) {
  // echo "Mailer Error: " . $mail->ErrorInfo;
     echo "<script>$('#myModal1').modal('show');</script>";
  } else {
    echo "Message sent!"; 
            
  };
}
//----- End Code for generate pdf
  
}
else
{
  echo 'Record not found for PDF.';
}

?>


<div class="modal fade" id="myModal1" role="dialog" >
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content" style="margin-top: 190px;">
        <div class="modal-header" style="">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">New Sale</h4>
        </div>
        <div class="modal-body" id="bodyModal1" style="text-align:center;font-weight:bold;">
          
        Mail Send Successfully
     
        </div>
        <div class="modal-footer">
          
        </div>
      </div>
      
    </div>
  </div>