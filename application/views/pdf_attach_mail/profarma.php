<?php                

include_once('tcpdf_6_2_13/tcpdf.php'); 

         
  
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

 $myArray = explode('(',$customer_info[0]['tax_details']); 
 // print_r($myArray); die();
 $tax_amt=$myArray[0];
 $tax_des=$myArray[1];
 $tax_des=str_replace(")","%)", $tax_des);
  
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
        color:#fff;
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
        .data_view{
          text-align: center;
        }
    </style>
  </head>
  <body>';

  if($template == 2) {

     $content .= ' <table>
      <tr class="header_view">
        <td style="border: none">
          <img src="../../assets/'.$company_info[0]['logo'].'" width="100px" />
        </td>
        <td style="border: none; color: white">'.$company_info[0]['company_name'].'</td>
        <td style="border: none; text-align: right; color: white">'.$company_info[0]['address'].'</td>
      </tr>
    </table>
    <br> <br>

    <table>
      <tr>
        <td style="border: none; font-weight: normal; line-height: 20px;"><b>Date</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span>&nbsp;: &nbsp;'.$invoice[0]['purchase_date'].'</span></td>
         <td style="border: none; font-weight: normal; line-height: 20px;"><b>Buyer / Customer</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span>&nbsp; : &nbsp;'.$invoice[0]['purchase_date'].'</span></td>
      </tr>

      <tr>
      <td style="border: none; font-weight: normal; line-height: 20px;"><b>Invoice No</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span>&nbsp; : &nbsp;'.$invoice[0]['purchase_id'].'</span></td>

      <td style="border: none; font-weight: normal; line-height: 20px;"><b>Place of Receipt</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span>&nbsp; : &nbsp;'.$invoice[0]['receipt'].'</span></td>
      </tr>
      

      <tr>
      <td style="border: none; font-weight: normal; line-height: 20px;"><b>Pre Carriage By</b>&nbsp;&nbsp;<span>&nbsp; : &nbsp;'.$invoice[0]['pre_carriage'].'</span></td>

         <td style="border: none; font-weight: normal; line-height: 20px;"><b>Country of <br> Final Destination</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;<span>&nbsp; : &nbsp;'.$invoice[0]['country_destination'].'</span></td>
      </tr>

      <tr>
      <td style="border: none; font-weight: normal; line-height: 20px;"><b>Port of Loading</b>&nbsp;&nbsp;<span>&nbsp; : &nbsp;'.$invoice[0]['loading'].'</span></td>


       <td style="border: none; font-weight: normal;line-height: 20px;"><b>Port of Discharge</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span>&nbsp; : &nbsp;'.$invoice[0]['country_goods'].'</span></td>
    
      </tr>

      <tr>
      <td style="border: none; font-weight: normal;"><b>Terms of <br>Payment</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span>&nbsp; : &nbsp;'.$invoice[0]['terms_payment'].'</span></td>

      <td style="border: none; font-weight: normal; line-height: 20px;"><b>Description of Goods</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span>&nbsp; : &nbsp;'.$invoice[0]['description_goods'].'</span></td>

      </tr>
    </table>

    <br> <br>
    <table>
      <tr class="table_view">
        <th class="data_view">S.NO</th>
        <th class="data_view">Product Name</th>
        <th class="data_view">In stock</th>
        <th class="data_view">Quantity / Sq ft.</th>
        <th class="data_view">Rate</th>
        <th class="data_view">Total</th>
      </tr>';
        if ($product_info) {
        $count=1;
        for($i=0;$i<sizeof($product_info);$i++){

      $content .='<tr>
      <td class="data_view">'.$count.'</td>
          <td class="data_view">'.$product_info[$i]['product_name'].'</td>
        <td class="data_view">'.$product_info[$i]['p_quantity'].'</td>
        <td class="data_view">'.$product_info[$i]['quantity'].'</td>
        <td class="data_view">'.$currency[0]['currency'].' '.$product_info[$i]['rate'].'</td>
        <td class="data_view">'.$currency[0]['currency'].' '.$product_info[$i]['total_amount'].'.00</td></tr>';
        $count++;
      }
    }
      $content .='<tr>
        <td colspan="5" style="text-align: right">Total:</td>
        <td class="data_view">'.$currency[0]['currency'].''.$invoice[0]['total'].'</td>
      </tr>
      <tr>
        <td colspan="5" style="text-align:right;">Tax:&nbsp;('.$tax_des.'</td>
        <td class="data_view">'.$currency[0]['currency'].''.$tax_amt.'</td>
      </tr>
      <tr>
        <td colspan="5" style="text-align: right">Grand Total:</td>
        <td class="data_view">'.$currency[0]['currency'].''.$invoice[0]['gtotal'].'</td>
      </tr>
    </table>
     <br>
    <h3 class="heading_view">Account Details/Additional Information : <span style="font-weight: normal;">'.$invoice[0]['ac_details'].'</span></h3>
    <h3 class="heading_view">Remarks/Conditions : <span style="font-weight: normal;">'.$invoice[0]['remarks'].'</span></h3>';

  } elseif($template == 1) {
    
    $content .= ' <table>
      <tr class="header_view">
        <th style="border: none">
          <img src="../../assets/'.$company_info[0]['logo'].'" width="100px" />
        </th>
        <th style="border: none; color: white">'.$company_info[0]['company_name'].'</th>
        <th style="border: none; text-align: right; color: white">'.$company_info[0]['address'].'</th>
      </tr>
    </table>
    <br> <br>

        <table>
      <tr>
        <td style="border: none; font-weight: normal; line-height: 20px;"><b>Date</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span>&nbsp;: &nbsp;'.$invoice[0]['purchase_date'].'</span></td>
         <td style="border: none; font-weight: normal; line-height: 50px;"><b>Buyer / Customer</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span>&nbsp; : &nbsp;'.$invoice[0]['purchase_date'].'</span></td>
      </tr>

      <tr>
      <td style="border: none; font-weight: normal; line-height: 20px;"><b>Invoice No</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span>&nbsp; : &nbsp;'.$invoice[0]['purchase_id'].'</span></td>

      <td style="border: none; font-weight: normal; line-height: 20px;"><b>Place of Receipt</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span>&nbsp; : &nbsp;'.$invoice[0]['receipt'].'</span></td>
      </tr>
      

      <tr>
      <td style="border: none; font-weight: normal; line-height: 20px;"><b>Pre Carriage By</b>&nbsp;&nbsp;<span>&nbsp; : &nbsp;'.$invoice[0]['pre_carriage'].'</span></td>

         <td style="border: none; font-weight: normal; line-height: 20px;"><b>Country of <br> Final Destination</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;<span>&nbsp; : &nbsp;'.$invoice[0]['country_destination'].'</span></td>
      </tr>

      <tr>
      <td style="border: none; font-weight: normal; line-height: 20px;"><b>Port of Loading</b>&nbsp;&nbsp;<span>&nbsp; : &nbsp;'.$invoice[0]['loading'].'</span></td>


       <td style="border: none; font-weight: normal;line-height: 20px;"><b>Port of Discharge</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span>&nbsp; : &nbsp;'.$invoice[0]['country_goods'].'</span></td>
    
      </tr>

      <tr>
      <td style="border: none; font-weight: normal;"><b>Terms of <br>Payment</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span>&nbsp; : &nbsp;'.$invoice[0]['terms_payment'].'</span></td>

      <td style="border: none; font-weight: normal; line-height: 20px;"><b>Description of Goods</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span>&nbsp; : &nbsp;'.$invoice[0]['description_goods'].'</span></td>

      </tr>
    </table>

    <br> <br>
     <table>
      <tr class="table_view">
        <th class="data_view">S.NO</th>
        <th class="data_view">Product Name</th>
        <th class="data_view">In stock</th>
        <th class="data_view">Quantity / Sq ft.</th>
        <th class="data_view">Rate</th>
        <th class="data_view">Total</th>
      </tr>';
        if ($product_info) {
        $count=1;
        for($i=0;$i<sizeof($product_info);$i++){

      $content .='<tr>
      <td class="data_view">'.$count.'</td>
          <td class="data_view">'.$product_info[$i]['product_name'].'</td>
        <td class="data_view">'.$product_info[$i]['p_quantity'].'</td>
        <td class="data_view">'.$product_info[$i]['quantity'].'</td>
        <td class="data_view">'.$currency[0]['currency'].' '.$product_info[$i]['rate'].'</td>
        <td class="data_view">'.$currency[0]['currency'].' '.$product_info[$i]['total_amount'].'.00</td></tr>';
        $count++;
      }
    }
      $content .='<tr>
        <td colspan="5" style="text-align: right">Total:</td>
        <td class="data_view">'.$currency[0]['currency'].''.$invoice[0]['total'].'</td>
      </tr>
      <tr>
        <td colspan="5" style="text-align:right;">Tax:&nbsp;('.$tax_des.'</td>
        <td class="data_view">'.$currency[0]['currency'].''.$tax_amt.'</td>
      </tr>
      <tr>
        <td colspan="5" style="text-align: right">Grand Total:</td>
        <td class="data_view">'.$currency[0]['currency'].''.$invoice[0]['gtotal'].'</td>
      </tr>
    </table>
     <br>
    <h3 class="heading_view">Account Details/Additional Information : <span style="font-weight: normal;">'.$invoice[0]['ac_details'].'</span></h3>
    <h3 class="heading_view">Remarks/Conditions : <span style="font-weight: normal;">'.$invoice[0]['remarks'].'</span></h3>';

  } elseif($template == 1) {
    
    $content .= ' <table>
      <tr class="header_view">
        <th style="border: none">
          <img src="../../assets/'.$company_info[0]['logo'].'" width="100px" />
        </th>
        <th style="border: none; color: white">'.$company_info[0]['company_name'].'</th>
        <th style="border: none; text-align: right; color: white">'.$company_info[0]['address'].'</th>
      </tr>
    </table>
     <br>
    <h3 class="heading_view">Account Details/Additional Information : <span style="font-weight: normal;">'.$invoice[0]['ac_details'].'</span></h3>
    <h3 class="heading_view">Remarks/Conditions : <span style="font-weight: normal;">'.$invoice[0]['remarks'].'</span></h3>';


  } elseif($template == 3){
      
    $content .= ' <table>
      <tr class="header_view">
        <th style="border: none">
          <img src="../../assets/'.$company_info[0]['logo'].'" width="100px" />
        </th>
        <th style="border: none; color: white">'.$company_info[0]['company_name'].'</th>
        <th style="border: none; text-align: right; color: white">'.$company_info[0]['address'].'</th>
      </tr>
    </table>
    <br> <br>

        <table>
      <tr>
        <td style="border: none; font-weight: normal; line-height: 20px;"><b>Date</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span>&nbsp;: &nbsp;'.$invoice[0]['purchase_date'].'</span></td>
         <td style="border: none; font-weight: normal; line-height: 50px;"><b>Buyer / Customer</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span>&nbsp; : &nbsp;'.$invoice[0]['purchase_date'].'</span></td>
      </tr>

      <tr>
      <td style="border: none; font-weight: normal; line-height: 20px;"><b>Invoice No</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span>&nbsp; : &nbsp;'.$invoice[0]['purchase_id'].'</span></td>

      <td style="border: none; font-weight: normal; line-height: 20px;"><b>Place of Receipt</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span>&nbsp; : &nbsp;'.$invoice[0]['receipt'].'</span></td>
      </tr>
      

      <tr>
      <td style="border: none; font-weight: normal; line-height: 20px;"><b>Pre Carriage By</b>&nbsp;&nbsp;<span>&nbsp; : &nbsp;'.$invoice[0]['pre_carriage'].'</span></td>

         <td style="border: none; font-weight: normal; line-height: 20px;"><b>Country of <br> Final Destination</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;<span>&nbsp; : &nbsp;'.$invoice[0]['country_destination'].'</span></td>
      </tr>

      <tr>
      <td style="border: none; font-weight: normal; line-height: 20px;"><b>Port of Loading</b>&nbsp;&nbsp;<span>&nbsp; : &nbsp;'.$invoice[0]['loading'].'</span></td>


       <td style="border: none; font-weight: normal;line-height: 20px;"><b>Port of Discharge</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span>&nbsp; : &nbsp;'.$invoice[0]['country_goods'].'</span></td>
    
      </tr>

      <tr>
      <td style="border: none; font-weight: normal;"><b>Terms of <br>Payment</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span>&nbsp; : &nbsp;'.$invoice[0]['terms_payment'].'</span></td>

      <td style="border: none; font-weight: normal; line-height: 20px;"><b>Description of Goods</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span>&nbsp; : &nbsp;'.$invoice[0]['description_goods'].'</span></td>

      </tr>
    </table>

    <br> <br>
     <table>
      <tr class="table_view">
        <th class="data_view">S.NO</th>
        <th class="data_view">Product Name</th>
        <th class="data_view">In stock</th>
        <th class="data_view">Quantity / Sq ft.</th>
        <th class="data_view">Rate</th>
        <th class="data_view">Total</th>
      </tr>';
        if ($product_info) {
        $count=1;
        for($i=0;$i<sizeof($product_info);$i++){

      $content .='<tr>
      <td class="data_view">'.$count.'</td>
          <td class="data_view">'.$product_info[$i]['product_name'].'</td>
        <td class="data_view">'.$product_info[$i]['p_quantity'].'</td>
        <td class="data_view">'.$product_info[$i]['quantity'].'</td>
        <td class="data_view">'.$currency[0]['currency'].' '.$product_info[$i]['rate'].'</td>
        <td class="data_view">'.$currency[0]['currency'].' '.$product_info[$i]['total_amount'].'.00</td></tr>';
        $count++;
      }
    }
      $content .='<tr>
        <td colspan="5" style="text-align: right">Total:</td>
        <td class="data_view">'.$currency[0]['currency'].''.$invoice[0]['total'].'</td>
      </tr>
      <tr>
        <td colspan="5" style="text-align:right;">Tax:&nbsp;('.$tax_des.'</td>
        <td class="data_view">'.$currency[0]['currency'].''.$tax_amt.'</td>
      </tr>
      <tr>
        <td colspan="5" style="text-align: right">Grand Total:</td>
        <td class="data_view">'.$currency[0]['currency'].''.$invoice[0]['gtotal'].'</td>
      </tr>
    </table>
     <br>
    <h3 class="heading_view">Account Details/Additional Information : <span style="font-weight: normal;">'.$invoice[0]['ac_details'].'</span></h3>
    <h3 class="heading_view">Remarks/Conditions : <span style="font-weight: normal;">'.$invoice[0]['remarks'].'</span></h3>';

  } elseif($template == 1) {
    
    $content .= ' <table>
      <tr class="header_view">
        <th style="border: none">
          <img src="../../assets/'.$company_info[0]['logo'].'" width="100px" />
        </th>
        <th style="border: none; color: white">'.$company_info[0]['company_name'].'</th>
        <th style="border: none; text-align: right; color: white">'.$company_info[0]['address'].'</th>
      </tr>
    </table>
     <br>
    <h3 class="heading_view">Account Details/Additional Information : <span style="font-weight: normal;">'.$invoice[0]['ac_details'].'</span></h3>
    <h3 class="heading_view">Remarks/Conditions : <span style="font-weight: normal;">'.$invoice[0]['remarks'].'</span></h3>';

  }

  $content .= '</body></html>'; 
 $content;
// echo $content;
// die();
$pdf->writeHTML($content);

$file_location = ""; //add your full path of your server
//$file_location = "/opt/lampp/htdocs/examples/generate_pdf/uploads/"; //for local xampp server

$datetime=date('dmY_hms');
$file_name = $invoiceid."_".$datetime.".pdf";
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
  error_reporting(E_ALL ^ E_DEPRECATED);  
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
  $mail->AddAddress('Suryakala@amoriotech.com'); // To mail id
  //$mail->AddCC('info.shinerweb@gmail.com'); // Cc mail id
  //$mail->AddBCC('info.shinerweb@gmail.com'); // Bcc mail id

  $mail->AddAttachment($file_location.$file_name);
  $mail->MsgHTML ($body);
  $mail->WordWrap = 50;
  $mail->Send();  
  $mail->SmtpClose();
  if($mail->IsError()) {
  echo "Mailer Error: " . $mail->ErrorInfo;
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