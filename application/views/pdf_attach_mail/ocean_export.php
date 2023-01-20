
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
    </style>
  </head>
  <body>';

  if($template == 2){
 
    $content .= '<table>
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
          <td style="border: none; font-weight: normal; line-height: 20px;"><b>Shipper</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span>&nbsp;: &nbsp;'.$supplier_info[0]['supplier_name'].'</span></td>

           <td style="border: none; font-weight: normal; line-height: 20px;"><b>Booking No</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span>&nbsp;: &nbsp;'.$ocean[0]['booking_no'].'</span></td>
      </tr>
      

      <tr>
       <td style="border: none; font-weight: normal; line-height: 20px;"><b>Invoive Date</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span>&nbsp;: &nbsp;'.$ocean[0]['invoice_date'].'</span></td>

       <td style="border: none; font-weight: normal; line-height: 20px;"><b>Customer / Consignee</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span>&nbsp;: &nbsp;'.$ocean[0]['consignee'].'</span></td>

      </tr>
      
      <tr>
      <td style="border: none; font-weight: normal; line-height: 20px;"><b>Notify Party</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span>&nbsp;: &nbsp;'.$ocean[0]['notify_party'].'</span></td>

      <td style="border: none; font-weight: normal; line-height: 20px;"><b>Vessel</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span>&nbsp;: &nbsp;'.$ocean[0]['vessel'].'</span></td>

      </tr>
     

      <tr>
       <td style="border: none; font-weight: normal; line-height: 20px;"><b>Voyage No</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span>&nbsp;: &nbsp;'.$ocean[0]['voyage_no'].'</span></td>

       <td style="border: none; font-weight: normal; line-height: 20px;"><b>Port Of Loading</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span>&nbsp;: &nbsp;'.$ocean[0]['port_of_loading'].'</span></td>

      </tr>
     

      <tr>
        <td style="border: none; font-weight: normal; line-height: 20px;"><b>Port of Discharge</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span>&nbsp;: &nbsp;'.$ocean[0]['port_of_discharge'].'</span></td>

        <td style="border: none; font-weight: normal; line-height: 20px;"><b>Place of Delivery</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span>&nbsp;: &nbsp;'.$ocean[0]['place_of_delivery'].'</span></td>

      </tr>
     

      <tr>
      <td style="border: none; font-weight: normal; line-height: 20px;"><b>Container No</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span>&nbsp;: &nbsp;'.$ocean[0]['container_no'].'</span></td>
      
       <td style="border: none; font-weight: normal; line-height: 20px;"><b>Seal No</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span>&nbsp;: &nbsp;'.$ocean[0]['seal_no'].'</span></td>

      </tr>
     

      <tr>
      <td style="border: none; font-weight: normal; line-height: 20px;"><b>Freight Forwarder</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span>&nbsp;: &nbsp;'.$ocean[0]['freight_forwarder'].'</span></td>

      <th style="border: none; font-weight: normal; line-height: 20px;"><b>Estimate time of arrival</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span>&nbsp;: &nbsp;'.$ocean[0]['eta'].'</span></th>

      </tr>
      

      <tr>
       <td style="border: none; font-weight: normal; line-height: 20px;"><b>Estimate time of <br>depature</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span>&nbsp;: &nbsp;'.$ocean[0]['etd'].'</span></td>

       <td style="border: none; font-weight: normal; line-height: 20px;"><b>Particulars</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span>&nbsp;: &nbsp;'.$ocean[0]['particular'].'</span></td>

      </tr>
      
    </table>';


  }elseif($template == 1){
$content .= '<table>
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
          <td style="border: none; font-weight: normal; line-height: 20px;"><b>Shipper</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span>&nbsp;: &nbsp;'.$supplier_info[0]['supplier_name'].'</span></td>

           <td style="border: none; font-weight: normal; line-height: 20px;"><b>Booking No</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span>&nbsp;: &nbsp;'.$ocean[0]['booking_no'].'</span></td>
      </tr>
      

      <tr>
       <td style="border: none; font-weight: normal; line-height: 20px;"><b>Invoive Date</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span>&nbsp;: &nbsp;'.$ocean[0]['invoice_date'].'</span></td>

       <td style="border: none; font-weight: normal; line-height: 20px;"><b>Customer / Consignee</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span>&nbsp;: &nbsp;'.$ocean[0]['consignee'].'</span></td>

      </tr>
      
      <tr>
      <td style="border: none; font-weight: normal; line-height: 20px;"><b>Notify Party</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span>&nbsp;: &nbsp;'.$ocean[0]['notify_party'].'</span></td>

      <td style="border: none; font-weight: normal; line-height: 20px;"><b>Vessel</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span>&nbsp;: &nbsp;'.$ocean[0]['vessel'].'</span></td>

      </tr>
     

      <tr>
       <td style="border: none; font-weight: normal; line-height: 20px;"><b>Voyage No</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span>&nbsp;: &nbsp;'.$ocean[0]['voyage_no'].'</span></td>

       <td style="border: none; font-weight: normal; line-height: 20px;"><b>Port Of Loading</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span>&nbsp;: &nbsp;'.$ocean[0]['port_of_loading'].'</span></td>

      </tr>
     

      <tr>
        <td style="border: none; font-weight: normal; line-height: 20px;"><b>Port of Discharge</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span>&nbsp;: &nbsp;'.$ocean[0]['port_of_discharge'].'</span></td>

        <td style="border: none; font-weight: normal; line-height: 20px;"><b>Place of Delivery</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span>&nbsp;: &nbsp;'.$ocean[0]['place_of_delivery'].'</span></td>

      </tr>
     

      <tr>
      <td style="border: none; font-weight: normal; line-height: 20px;"><b>Container No</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span>&nbsp;: &nbsp;'.$ocean[0]['container_no'].'</span></td>
      
       <td style="border: none; font-weight: normal; line-height: 20px;"><b>Seal No</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span>&nbsp;: &nbsp;'.$ocean[0]['seal_no'].'</span></td>

      </tr>
     

      <tr>
      <td style="border: none; font-weight: normal; line-height: 20px;"><b>Freight Forwarder</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span>&nbsp;: &nbsp;'.$ocean[0]['freight_forwarder'].'</span></td>

      <th style="border: none; font-weight: normal; line-height: 20px;"><b>Estimate time of arrival</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span>&nbsp;: &nbsp;'.$ocean[0]['eta'].'</span></th>

      </tr>
      

      <tr>
       <td style="border: none; font-weight: normal; line-height: 20px;"><b>Estimate time of <br>depature</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span>&nbsp;: &nbsp;'.$ocean[0]['etd'].'</span></td>

       <td style="border: none; font-weight: normal; line-height: 20px;"><b>Particulars</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span>&nbsp;: &nbsp;'.$ocean[0]['particular'].'</span></td>

      </tr>
      
    </table>';



  }elseif($template == 3){

    $content .= '<table>
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
          <td style="border: none; font-weight: normal; line-height: 20px;"><b>Shipper</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span>&nbsp;: &nbsp;'.$supplier_info[0]['supplier_name'].'</span></td>

           <td style="border: none; font-weight: normal; line-height: 20px;"><b>Booking No</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span>&nbsp;: &nbsp;'.$ocean[0]['booking_no'].'</span></td>
      </tr>
      

      <tr>
       <td style="border: none; font-weight: normal; line-height: 20px;"><b>Invoive Date</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span>&nbsp;: &nbsp;'.$ocean[0]['invoice_date'].'</span></td>

       <td style="border: none; font-weight: normal; line-height: 20px;"><b>Customer / Consignee</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span>&nbsp;: &nbsp;'.$ocean[0]['consignee'].'</span></td>

      </tr>
      
      <tr>
      <td style="border: none; font-weight: normal; line-height: 20px;"><b>Notify Party</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span>&nbsp;: &nbsp;'.$ocean[0]['notify_party'].'</span></td>

      <td style="border: none; font-weight: normal; line-height: 20px;"><b>Vessel</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span>&nbsp;: &nbsp;'.$ocean[0]['vessel'].'</span></td>

      </tr>
     

      <tr>
       <td style="border: none; font-weight: normal; line-height: 20px;"><b>Voyage No</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span>&nbsp;: &nbsp;'.$ocean[0]['voyage_no'].'</span></td>

       <td style="border: none; font-weight: normal; line-height: 20px;"><b>Port Of Loading</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span>&nbsp;: &nbsp;'.$ocean[0]['port_of_loading'].'</span></td>

      </tr>
     

      <tr>
        <td style="border: none; font-weight: normal; line-height: 20px;"><b>Port of Discharge</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span>&nbsp;: &nbsp;'.$ocean[0]['port_of_discharge'].'</span></td>

        <td style="border: none; font-weight: normal; line-height: 20px;"><b>Place of Delivery</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span>&nbsp;: &nbsp;'.$ocean[0]['place_of_delivery'].'</span></td>

      </tr>
     

      <tr>
      <td style="border: none; font-weight: normal; line-height: 20px;"><b>Container No</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span>&nbsp;: &nbsp;'.$ocean[0]['container_no'].'</span></td>
      
       <td style="border: none; font-weight: normal; line-height: 20px;"><b>Seal No</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span>&nbsp;: &nbsp;'.$ocean[0]['seal_no'].'</span></td>

      </tr>
     

      <tr>
      <td style="border: none; font-weight: normal; line-height: 20px;"><b>Freight Forwarder</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span>&nbsp;: &nbsp;'.$ocean[0]['freight_forwarder'].'</span></td>

      <th style="border: none; font-weight: normal; line-height: 20px;"><b>Estimate time of arrival</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span>&nbsp;: &nbsp;'.$ocean[0]['eta'].'</span></th>

      </tr>
      

      <tr>
       <td style="border: none; font-weight: normal; line-height: 20px;"><b>Estimate time of <br>depature</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span>&nbsp;: &nbsp;'.$ocean[0]['etd'].'</span></td>

       <td style="border: none; font-weight: normal; line-height: 20px;"><b>Particulars</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span>&nbsp;: &nbsp;'.$ocean[0]['particular'].'</span></td>

      </tr>
      
    </table>';

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
  $mail->AddAddress('rammg1985@gmail.com'); // To mail id
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