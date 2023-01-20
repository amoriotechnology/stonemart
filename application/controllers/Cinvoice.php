<?php



if (!defined('BASEPATH'))

    exit('No direct script access allowed');



class Cinvoice extends CI_Controller {



    function __construct() {

        parent::__construct();
        $this->load->model('Web_settings');
            $this->load->library('session');
        $this->db->query('SET SESSION sql_mode = ""');

    }

    public function updateinvoicedesign($id,$uid)
    {
    
       
     $query='update invoice_design set template='.$id.' where uid='.$uid;
    $this->db->query($query);
    redirect($_SERVER['HTTP_REFERER']);
        redirect('cinvoice/updateinvoicedesign', 'refresh');
    }

    public function index() {
     

        $CI = & get_instance();

        $CI->auth->check_admin_auth();

        $CI->load->library('linvoice');

        $content = $CI->linvoice->invoice_add_form();

        $this->template->full_admin_html_view($content);

    }
    public function add_profarma_product_csv() {
        $CI = & get_instance();
        $data = array(
            'title' => display('add_product_csv')
        );
        $content = $CI->parser->parse('invoice/add_profarma_product_csv', $data, true);
        $this->template->full_admin_html_view($content);
    }
    public function uploadProformacsv()
    {
        $CI = & get_instance();
        $this->load->model('Products');
        $data['productdetails'] = $this->Products->get_profarma_product();
        // print_r($data['productdetails']); die();
        $this->load->library('upload');
        $this->load->library('csvimport');
        if (($_FILES['upload_csv_file']['name'])){
            $files = $_FILES;
            $config = array();
            $config['upload_path'] = './uploads';
            $config['allowed_types'] = 'csv';
            $config['max_size'] = '1000';
            $this->upload->initialize($config);
              if (!$this->upload->do_upload('upload_csv_file')) {
                $data['error_message'] = $this->upload->display_errors();
                $this->session->set_userdata($data);
            } else {
                $file_data = $this->upload->data();
                $file_path =  './uploads/'.$file_data['file_name'];
            if ($this->csvimport->get_array($file_path)) {
                $csv_array = $this->csvimport->get_array($file_path);
                $this->session->set_userdata('file_path',  $csv_array);
                foreach ($csv_array as $row) {
                    $purchase_id = date('YmdHis');
                    $proforma_data = array(
                        'sales_by'     =>  $this->session->userdata('user_id'),
                        'purchase_id'=>$purchase_id,
                        'purchase_date'=>$row['purchase_date'],
                        'chalan_no'=>$row['chalan_no'],
                        'receipt'=>$row['receipt'],
                        'pre_carriage'=>$row['pre_carriage'],
                        'country_destination'=>$row['country_destination'],
                        'loading' => $row['loading'],
                        'discharge' => $row['discharge'],
                        'terms_payment' => $row['terms_payment'],
                        'description_goods' => $row['description_goods'],
                        'ac_details' => $row['ac_details'],
                        'remark' => $row['remark'],
                    );
                    // print_r($proforma_data); die();
                    $this->db->insert('profarma_invoice', $proforma_data);
                    $product_id = $this->generator(10);
                    $data_invoice = array(
                        'product_id' => $product_id,
                        'create_by'     =>  $this->session->userdata('user_id'),
                        'purchase_id'=>$purchase_id,
                        'product_name' => $row['product_name'],
                        'quantity' => $row['quantity'],
                        'rate' => $row['rate'],
                    );
                    // print_r($data_invoice);die();
                    $this->db->insert('profarma_invoice_details', $data_invoice);
                }
                $data=array();
                $data=array(
                    'proforma_data' =>$proforma_data
                );
                $content = $this->load->view('invoice/add_profarma_product_csv', $data, true);
                $this->template->full_admin_html_view($content);
                $this->session->set_userdata(array('message'=>display('successfully_added')));
               redirect(base_url('Cinvoice/manage_profarma_invoice'));
                //echo "<pre>"; print_r($insert_data);
            }else {
                $this->session->set_userdata(array('error_message'=>'Please Import Only Csv File'));
                redirect(base_url('Cinvoice/add_profarma_product_csv'));
            }
            $this->session->unset_userdata('file_path');
            unlink($file_path);
            }
        }
    }
    public function add_product_csv() {
        $CI = & get_instance();
        $this->load->model('Products');
        // $data = array(
        //     'title' => display('add_product_csv')
        // );
        $data['productdetails'] = $this->Products->get_product();
        $content = $CI->parser->parse('invoice/add_product_csv', $data, true);
        $this->template->full_admin_html_view($content);
    }
    public function uploadCsv()
    {
        $CI = & get_instance();
        $this->load->model('Products');
        $data['productdetails'] = $this->Products->get_product();
        $this->load->library('upload');
        $this->load->library('csvimport');
        if (($_FILES['upload_csv_file']['name'])){
            $files = $_FILES;
            $config = array();
            $config['upload_path'] = './uploads';
            $config['allowed_types'] = 'csv';
            $config['max_size'] = '1000';
            $this->upload->initialize($config);
              if (!$this->upload->do_upload('upload_csv_file')) {
                $data['error_message'] = $this->upload->display_errors();
                $this->session->set_userdata($data);
            } else {
                $file_data = $this->upload->data();
                $file_path =  './uploads/'.$file_data['file_name'];
            if ($this->csvimport->get_array($file_path)) {
                $csv_array = $this->csvimport->get_array($file_path);
                $this->session->set_userdata('file_path',  $csv_array);
                foreach ($csv_array as $row) {
                    $insert_data = array(
                        'sales_by'     =>  $this->session->userdata('user_id'),
                        'invoice_id'=>$row['invoice_id'],
                        'date'=>$row['date'],
                        'commercial_invoice_number'=>$row['commercial_invoice_number'],
                        'payment_type'=>$row['payment_type'],
                        'container_no'=>$row['container_no'],
                        'bl_no'=>$row['bl_no'],
                        'billing_address' => $row['billing_address'],
                        'payment_terms' => $row['payment_terms'],
                        'port_of_discharge' => $row['port_of_discharge'],
                        'number_of_days' => $row['number_of_days'],
                        'payment_due_date' => $row['payment_due_date'],
                        'etd' => $row['etd'],
                        'eta' => $row['eta'],
                        'ac_details' => $row['ac_details'],
                        'remark' => $row['remark'],
                    );
                 
                    $this->db->insert('invoice', $insert_data);
                    $product_id = $this->generator(10);
                    $data_invoice = array(
                        'product_id' => $product_id,
                        'create_by'     =>  $this->session->userdata('user_id'),
                        'invoice_id'=>$row['invoice_id'],
                        'product_name' => $row['product_name'],
                        'quantity' => $row['quantity'],
                        'rate' => $row['rate'],
                    );
                    // print_r($data_invoice);die();
                    $this->db->insert('invoice_details', $data_invoice);
                }
                $data=array();
                $data=array(
                    'insert_data' =>$insert_data
                );
                $content = $this->load->view('invoice/add_product_csv', $data, true);
                $this->template->full_admin_html_view($content);
                $this->session->set_userdata(array('message'=>display('successfully_added')));
               redirect(base_url('Cinvoice/manage_invoice'));
                //echo "<pre>"; print_r($insert_data);
            }else {
                $this->session->set_userdata(array('error_message'=>'Please Import Only Csv File'));
                redirect(base_url('Cinvoice/add_product_csv'));
            }
            $this->session->unset_userdata('file_path');
            unlink($file_path);
            }
        }
}
    public function add_payment_info(){
        $CI = & get_instance();

        $CI->auth->check_admin_auth();

        $CI->load->model('Invoices');
        $payment_id=$this->input->post('payment_id');
      
        $payment = $CI->Invoices->add_payment_info();
        $payment_get = $CI->Invoices->get_payment_info($payment_id);
        $amt_paid = $this->db->select('sum(amt_paid) as amt_paid')->from('payment')->where('payment_id',$payment_id)->get()->row()->amt_paid;
        $data=array();
        $data=array(
            'payment_get'  =>$payment_get,
            'amt_paid' =>  $amt_paid

        );
        echo json_encode($data);

  }
  public function payment_history(){
    $CI = & get_instance();

    $CI->auth->check_admin_auth();

    $CI->load->model('Invoices');
    $payment_id=$this->input->post('payment_id');
    $payment_get = $CI->Invoices->get_payment_info($payment_id);

    $amt_paid = $this->db->select('sum(amt_paid) as amt_paid')->from('payment')->where('payment_id',$payment_id)->get()->row()->amt_paid;
    $data=array();
    $data=array(
        'payment_get'  =>$payment_get,
        'amt_paid' =>  $amt_paid

    );
echo json_encode($data);

}
    public function makepay() {


        $CI = & get_instance();

        $CI->auth->check_admin_auth();

        $CI->load->library('linvoice');
        $data=array();
     
       $CI->load->model('Invoices');
       $bank_name = $CI->db->select('bank_name')
       ->from('bank_add')
       ->get()
       ->result_array();
       $data = array(

           'bank_name' =>$bank_name

       );

      
        $content = $this->load->view('invoice/add_bank', $data, true);
        //$content='';
        $this->template->full_admin_html_view($content);


    }

     public function profarma_invoice() {

        $CI = & get_instance();

        $CI->auth->check_admin_auth();

        $CI->load->library('linvoice');
        $data=array();
        $currency_details = $CI->Web_settings->retrieve_setting_editdata();
        $curn_info_default = $CI->db->select('*')->from('currency_tbl')->where('icon',$currency_details[0]['currency'])->get()->result_array();
      
       // echo $content = $CI->linvoice->invoice_add_form();
       $CI->load->model('Invoices');
       $data['customer'] = $CI->Invoices->profarma_invoice_customer();
       $data=array(
        'curn_info_default' =>$curn_info_default[0]['currency_name'],
        //  'curn_info_customer'=>$curn_info_customer[0]['currency_name'],
          'currency'  =>$currency_details[0]['currency'],
  
        'customer' => $CI->Invoices->profarma_invoice_customer(),
        'voucher_no' => $CI->Invoices->profarma_voucher_no()
       );

      
        $content = $this->load->view('invoice/profarma_invoice', $data, true);
        //$content='';
        $this->template->full_admin_html_view($content);

    }
    // Get Customer on email
 
    public function email($customer_id){
        $CI = & get_instance();
        $this->load->model('Invoices');
    
        $postData = $this->input->post();
    
        $data = $this->Invoices->get_customer_data($customer_id);
        
        $email_info = $CI->Invoices->get_email_data();
      
    $data1 = array(
       
    'customer_name'    => $data[0]['customer_name'],
    'customer_email'   => $data[0]['customer_email'],
    'email_subject'    => $email_info[0]['subject'],
    'email_greeting'   => $email_info[0]['greeting'],
    'email_message'    => $email_info[0]['message']
    );
    $invoiceList = $CI->parser->parse('invoice/invoice_email_html', $data1, true);
    $this->template->full_admin_html_view($invoiceList);
    
    }

    // Get Customer on email

    public function get_customer($id){
        $id=explode('-',$id);
        $table=$id[1];
         $col=$id[2];
        $id=$id[0];
    if($table=='ocean_export_tracking')
    {
            $sql='SELECT c.* from '.$table.' i JOIN supplier_information c on c.supplier_id=i.supplier_id WHERE i.'.$col.' ="'.$id.'"';
      $query=$this->db->query($sql);
      $row=$query->result_array();
      // print_r($row); die();
      echo $row[0]['email_address']; die();
    }
    elseif ($table=='sale_trucking') {
      $sql='SELECT c.* from '.$table.' i JOIN customer_information c on i.bill_to=c.customer_id WHERE i.'.$col.' ="'.$id.'"';
      $query=$this->db->query($sql);
    }
    elseif ($table=='sale_packing_list') {
      $sql='SELECT c.* FROM sale_packing_list s JOIN invoice i JOIN customer_information c on c.customer_id=i.customer_id where s.expense_packing_id='.$id;
      $query=$this->db->query($sql);
    }
    else
    {
           $sql='SELECT c.* from '.$table.' i JOIN customer_information c on c.customer_id=i.customer_id WHERE i.'.$col.' ="'.$id.'"';
        //    echo $this->db->last_query(); die();
        //    print_r($sql); die();
    }
        $sql ;
      $query=$this->db->query($sql);
      $row=$query->result_array();
     echo $row[0]['customer_email'];
    }

    // Send email Attachments
    public function sendmail_with_attachments($invoice_id)
    {
      $CA = & get_instance();
      $CI = & get_instance();
      $CA->load->model('invoice_design');
      $CA->load->model('Web_settings');
      $dataw = $CA->invoice_design->retrieve_data();
      $currency_details = $CI->Web_settings->retrieve_setting_editdata();
      $curn_info_default = $CI->db->select('*')->from('currency_tbl')->where('icon',$currency_details[0]['currency'])->get()->result_array();
       // print_r($curn_info_default); die();
    $uid=$_SESSION['user_id'];
    $sql='select c.* from company_information c join user_login as u on u.cid=c.company_id where u.user_id='.$uid;
    $query=$this->db->query($sql);
    $company_info=$query->result_array();
    $product_sql='select c.* from invoice i join customer_information c on c.customer_id=i.customer_id where i.invoice_id='.$invoice_id;
    $query=$this->db->query($product_sql);
    $customer_info=$query->result_array();
    $sql='select p.* from `invoice_details` i join product_information p on p.product_id=i.product_id where i.invoice_id="'.$invoice_id.'";';
    $query=$this->db->query($sql);
    $product_info=$query->result_array();
    // print_r($product_info); die();
    $invoice_sql='select * from `invoice` i join invoice_details p on p.invoice_id=i.invoice_id';
    $query=$this->db->query($invoice_sql);
    $invoice_info=$query->result_array();
// echo '<pre>';
//     print_r($invoice_info); die();
//     echo '</pre>';
    $sql='select * from invoice where invoice_id='.$invoice_id;
    $query=$this->db->query($sql);
    $invoice=$query->result_array();
    // print_r($invoice); die();
    $dataw = $CA->invoice_design->retrieve_data();
    // print_r($dataw); die();
    $data['curn_info_default'] = $curn_info_default[0]['currency_name'];
    $data['currency'] = $currency_details;
    $data['company_info']=$company_info;
    $data['customer_info']=$customer_info;
    $data['product_info']=$product_info;
    $data['invoiceid']=$invoice_id;
    $data['invoice_info']=$invoice_info;
    $data['invoice'] = $invoice;
    $data['template'] = $dataw[0]['template'];
// print_r($data); die();
    $content = $this->load->view('pdf_attach_mail/new_sale', $data, true);
    // if($content)
    // {
    //      redirect("Cinvoice/manage_invoice");
    //  }
         // $this->template->full_admin_html_view($content);
}

 public function getvendor_products() {
        $CI = & get_instance();

        $CI->auth->check_admin_auth();

        $CI->load->model('Invoices');
        $value = $this->input->post('value',TRUE);
       
        $content = $CI->Invoices->getvendor_products($value);


      echo json_encode($content);

    }
    public function performa_pdf($purchase_id) {

        $CI = & get_instance();

        $CI->load->model('Invoices');

        $CI->load->model('Web_settings');

        $CI->load->library('occational');

        $purchase_detail = $CI->Invoices->profarma_pdf($purchase_id);

        // print_r($purchase_detail); die();

        $all_profarma = $CI->Invoices->all_profarma($purchase_id);

      
     $product_name = $this->db->select('*')->from('product_information')->where("product_id",$all_profarma[0]['product_id'])->get()->result_array();

      // print_r($product_name);die();
        

        $profarma_details = $this->db->select('*')->from('profarma_invoice_details')->where("purchase_id",$purchase_detail[0]['purchase_id'])->get()->result_array();



        if (!empty($purchase_detail)) {

            $i = 0;

            foreach ($purchase_detail as $k => $v) {

                $i++;

                $purchase_detail[$k]['sl'] = $i;         

        }

    }

        $currency_details = $CI->Web_settings->retrieve_setting_editdata();
        $CII = & get_instance();
        $CC = & get_instance();
        $w = & get_instance();

        $w->load->model('Ppurchases');
        $company_info = $w->Ppurchases->retrieve_company();
         // print_r($company_info); exit();
        $CII->load->model('invoice_design');
        $CC->load->model('invoice_content');
        $CI1 = & get_instance();
        $CI1->load->model('Purchases');
        $currency_details = $CI->Web_settings->retrieve_setting_editdata();
        $curn_info_default = $CI->db->select('*')->from('currency_tbl')->where('icon',$currency_details[0]['currency'])->get()->result_array();
      
        $all_supplier = $CI1->Purchases->select_all_supplier();
        $dataw = $CII->invoice_design->retrieve_data();
        // print_r($dataw); exit();
       $datacontent = $CI->invoice_content->retrieve_data();
      
       $customer = $this->db->select('*')->from('customer_information')->where("customer_id",$purchase_detail[0]['customer_id'])->get()->result_array();
       // print_r($customer); die();
  //$prinfo = $this->db->select('*')->from('product_information')->where('product_id',$product_id)->get()->result_array();
        
              
        $data = array(
            'curn_info_default' =>$curn_info_default[0]['currency_name'],
            'currency'  =>$currency_details[0]['currency'],
            'header'=> $dataw[0]['header'],
            'logo'=> $dataw[0]['logo'],
            'color'=> $dataw[0]['color'],
            'template'=> $dataw[0]['template'],
            'all_supplier' => $all_supplier,
            'address'=>$datacontent[0]['address'],
            
            'cname'=>$datacontent[0]['business_name'],
            'phone'=>$datacontent[0]['phone'],
            'email'=>$datacontent[0]['email'],
            'reg_number'=>$datacontent[0]['reg_number'],
            'website'=>$datacontent[0]['website'],
            'address'=>$datacontent[0]['address'],
            'title'            => display('purchase_details'),
            'customer'  =>  $customer,
            'order'    =>$all_profarma,
            'customer_currency' => $customer[0]['currency_type'],
            'customer'      => $customer[0]['customer_name'],
            'purchase_id'      => $purchase_detail[0]['purchase_id'],

            'chalan_no' =>  $purchase_detail[0]['chalan_no'],

            'purchase_date' => $purchase_detail[0]['purchase_date'],

            'pre_carriage' => $purchase_detail[0]['pre_carriage'],

            'receipt' => $purchase_detail[0]['receipt'],

            'country_goods' => $purchase_detail[0]['country_goods'],

            'country_destination' => $purchase_detail[0]['country_destination'],
            
            'loading' => $purchase_detail[0]['loading'],

            'discharge' => $purchase_detail[0]['discharge'],

            'terms_payment' => $purchase_detail[0]['terms_payment'],

            'description_goods' => $purchase_detail[0]['description_goods'],

            'total' => $purchase_detail[0]['total'],
            'remarks' => $purchase_detail[0]['remarks'],
            'tax' => $purchase_detail[0]['tax_details'],
            'gtotal' => $purchase_detail[0]['gtotal'],
            'customer_gtotal' => $purchase_detail[0]['customer_gtotal'],
            'ac_details' =>  $purchase_detail[0]['ac_details'],

             'product' => $product_name[0]['product_name'],
             'stock' => $product_name[0]['p_quantity'],
            

             'quantity' => $profarma_details[0]['quantity'],
             'totalamount' => $profarma_details[0]['total_amount'],

            'company_info'     => $company_info

          //  'Web_settings'     => $currency_details,

        );

        




        $chapterList = $CI->parser->parse('invoice/profarma_invoice_html', $data, true);
        $this->template->full_admin_html_view( $chapterList);


        return $chapterList;

    }



    public function get_email_data(){
        $CI = & get_instance();
        $this->auth->check_admin_auth();
        $CI->load->model('Invoices');
       // $value = $this->input->post('customer_name',TRUE);
        $email_info = $CI->Invoices->get_email_data();
        echo json_encode($email_info);
    }
     

    function pdf()
    {
        $this->load->library('pdf');
        
        $html = $this->load->view('purchase/trucking_invoice_html', [], true);
        $this->pdf->createPDF($html, 'mypdf', false);
    }

    public function sendmail()
    {
    //Load email library
$this->load->library('email');

$receiver_mail = $this->input->post('email_info',TRUE);
$name_email = $this->input->post('name_email',TRUE);
$subject_email = $this->input->post('subject_email',TRUE);
$message_email = $this->input->post('message_email',TRUE);
//SMTP & mail configuration
$config = array(
    'protocol'  => 'smtp',
    'smtp_host' => 'ssl://smtp.googlemail.com',
    'smtp_port' => 465,
    'smtp_user' => 'suryavenkatesh3093@gmail.com',
    'smtp_pass' => 'hdafyzlzbjqppnlq',
    'mailtype'  => 'text',
    'charset'   => 'utf-8'
);
$this->email->initialize($config);
$this->email->set_mailtype("html");
$this->email->set_newline("\r\n");

//Email content
$htmlContent = '<h1>Greeting from AmorioTech</h1>';
$htmlContent .= $name_email;
$htmlContent .= $message_email;

$this->email->to($receiver_mail);
$this->email->from('suryavenkatesh3093@gmail.com','AmorioTech');
$this->email->subject($subject_email);
$this->email->message($htmlContent);

//Send email
$this->email->send();
$data = "Message Sent Successfully";
echo json_encode($data);

    
    }
    public function getvendor(){
        $CI = & get_instance();
        $this->auth->check_admin_auth();
        $CI->load->model('Purchases');
        $value = $this->input->post('value',TRUE);
        $vendor_info = $CI->Purchases->select_supplier($value);
        echo json_encode($vendor_info);
       
    }
    public function getvendorbyname(){
        $CI = & get_instance();
        $this->auth->check_admin_auth();
        $CI->load->model('Purchases');
        $value = $this->input->post('value',TRUE);
        $vendor_info = $CI->Purchases->select_supplierbyname($value);
        echo json_encode($vendor_info);
       
    }
 /*   public function getcusto_currency(){
       
        $CI = & get_instance();
        $this->auth->check_admin_auth();
        $CI->load->model('Invoices');
        $value = $this->input->post('value1',TRUE);
        $customer_info = $CI->Invoices->getcusto_currency($value);
        echo json_encode($customer_info);
  

   print_r($curn_info_customer);die();
}
*/
    public function getcustomer_data(){
        $CI = & get_instance();
        $this->auth->check_admin_auth();
        $CI->load->model('Invoices');
        $value = $this->input->post('value',TRUE);
        $customer_info = $CI->Invoices->getcustomer_data($value);
     
        echo json_encode($customer_info);
        
    }
    public function delete_trucking() {
        $this->db->where('trucking_id', $_GET['val']);
        $this->db->delete('sale_trucking');
        $this->db->where('sale_trucking_id', $_GET['val']);
        $this->db->delete('sale_trucking_id');
   }
   public function delete_ocean_export(){
    $this->db->where('booking_no', $_GET['val']);
    $this->db->delete('ocean_export_tracking');
}
public function delete_packing() {
    $this->db->where('expense_packing_id', $_GET['val']);
    $this->db->delete('expense_packing_list');
    $this->db->where('expense_packing_id', $_GET['val']);
    $this->db->delete('expense_packing_list_detail');
}
public function deleteprofarma(){
    $this->db->where('purchase_id', $_GET['val']);
    $this->db->delete('profarma_invoice');
    $this->db->where('purchase_id', $_GET['val']);
    $this->db->delete('profarma_invoice_details');
}
public function deletesale(){
    $this->db->where('invoice_id', $_GET['val']);
    $this->db->delete('invoice');
    $this->db->where('invoice_id', $_GET['val']);
    $this->db->delete('invoice_details');
}
    public function getcustomer_byID(){
        $CI = & get_instance();
        $this->auth->check_admin_auth();
        $CI->load->model('Invoices');
        $value = $this->input->post('value',TRUE);
        $customer_info = $CI->Invoices->customerinfo_rpt($value);
      
        echo json_encode($customer_info);
    }
    public function getdate(){
        $CI = & get_instance();
        $this->auth->check_admin_auth();
        $CI->load->model('Invoices');
        $sales_invoice_date = $this->input->post('sales_invoice_date',TRUE);
        $days = $this->input->post('days',TRUE);
        $date= date('Y-m-d', strtotime($sales_invoice_date. ' +'.$days.' day'));
        echo json_encode($date);
    }
        public function profarma_invoice_update_form($invoice_id)
        {
           
            $CI = & get_instance();

            $CI->auth->check_admin_auth();
    
            $CI->load->library('linvoice');
    
            $content = $CI->linvoice->profarma_edit_data($invoice_id);
    
            $this->template->full_admin_html_view($content);
        }    

    public function packing_list(){
        $CI = & get_instance();

        $CI->auth->check_admin_auth();

        $CI->load->library('linvoice');
        $data=array();
       // echo $content = $CI->linvoice->invoice_add_form();
        $content = $this->load->view('invoice/packing_list', $data, true);
        //$content='';
        $this->template->full_admin_html_view($content);
    }
  
    public function availability(){
        $CI = & get_instance();
        $output = new stdClass;
        $output->csrfName = $this->security->get_csrf_token_name();
        $output->csrfHash = $this->security->get_csrf_hash();
        $output->pdt=$this->input->post('pdt');
        $output->data = "add";
        $product_nam=$this->input->post('product_nam');
        $product_model=$this->input->post('product_model');
        $CI->load->model('Invoices');
      $data=  $CI->Invoices->availability($product_nam,$product_model);
        
        echo json_encode($data);
       // die();
   // echo $pdt;
    //   print_r($json);
      
     }
     public function product_id(){
        $CI = & get_instance();
        $output = new stdClass;
        $output->csrfName = $this->security->get_csrf_token_name();
        $output->csrfHash = $this->security->get_csrf_hash();
        $output->pdt=$this->input->post('pdt');
        $output->data = "add";
        $product_nam=$this->input->post('product_nam');
        $product_model=$this->input->post('product_model');
        $CI->load->model('Invoices');
      $data=  $CI->Invoices->product_id($product_nam,$product_model);
        
        echo json_encode($data);
       // die();
   // echo $pdt;
    //   print_r($json);
      
     }

        public function add_packing_list(){
        $CI = & get_instance();

        $CI->auth->check_admin_auth();
        $CI->load->model('Products');
        $CI->load->model('Invoices');
        $CI->load->library('linvoice');
        $products=$CI->Products->get_all_products();
        $data=array();
        $CI->load->model('Units');
        $voucher_no = $CI->Invoices->packing_list_no();
        $unit_list     = $CI->Units->unit_list();
        $currency_details = $CI->Web_settings->retrieve_setting_editdata();
        $data=array(
          //  'curn_info_default' =>$curn_info_default[0]['currency_name'],
            'currency' => $currency_details[0]['currency'],
            'voucher_no' => $voucher_no,
            'products'=> $products,
            'unit_list'    => $unit_list,
            );
     
       // echo $content = $CI->linvoice->invoice_add_form();
        $content = $this->load->view('invoice/add_packing_list', $data, true);
        //$content='';
        $this->template->full_admin_html_view($content);
    }


    public function ocean_export_tracking(){
        $CI = & get_instance();

        $CI->auth->check_admin_auth();

        $CI->load->library('linvoice');

         $content = $CI->linvoice->ocean_export_tracking_add_form();

        $this->template->full_admin_html_view($content);


       //  $data=array();
       // // echo $content = $CI->linvoice->invoice_add_form();
       //  $content = $this->load->view('invoice/ocean_import_tracking', $data, true);
       //  //$content='';
       //  $this->template->full_admin_html_view($content);
    }

          //Ocean Import Tracking Update Form
    public function ocean_export_tracking_update_form($purchase_id) {
        $CI = & get_instance();
        $CI->auth->check_admin_auth();
        $CI->load->library('linvoice');
        $content = $CI->linvoice->ocean_export_tracking_edit_data($purchase_id);
        $this->template->full_admin_html_view($content);
    }



      public function trucking(){
        $CI = & get_instance();

        $CI->auth->check_admin_auth();

        $CI->load->library('linvoice');
       // $data=array();
        $content = $CI->linvoice->trucking_add_form();
      //  $content = $this->load->view('invoice/trucking', $data, true);
        //$content='';
        $this->template->full_admin_html_view($content);
    }
    public function trucking1(){
        $CI = & get_instance();

        $CI->auth->check_admin_auth();

        $CI->load->library('linvoice');
        $data=array();
        $content = $CI->linvoice->trucking_add_form1();
       // $content = $this->load->view('purchase/trucking', $data, true);
        //$content='';
        $this->template->full_admin_html_view($content);
    }


      public function insert_trucking() {


       
        $CI = & get_instance();
        $CI->auth->check_admin_auth();
         $CI->load->model('Invoices');
        $invoiceid=$CI->Invoices->trucking_entry();
        echo json_encode($invoiceid);
      
    }

 

     public function oceanimport() {

        $CI = & get_instance();

        $CI->auth->check_admin_auth();

        $CI->load->library('linvoice');
        $data=array();
       // echo $content = $CI->linvoice->invoice_add_form();
        $content = $this->load->view('invoice/oceanimport', $data, true);
        //$content='';
        $this->template->full_admin_html_view($content);

    }

    public function oceanexport() {

        $CI = & get_instance();

        $CI->auth->check_admin_auth();

        $CI->load->library('linvoice');
        $data=array();
       // echo $content = $CI->linvoice->invoice_add_form();
        $content = $this->load->view('invoice/oceanexport', $data, true);
        //$content='';
        $this->template->full_admin_html_view($content);

    }

 public function add_profarma_invoice()
 {

       $CI = & get_instance();

        $CI->auth->check_admin_auth();

        $CI->load->library('linvoice');
      //  $data=array();
        $CI->load->model('Invoices');
   $c=   $this->Invoices->add_profarma_invoice();
     print_r($c);
      $this->session->set_userdata(array('message' => display('successfully_added')));
      if (isset($_POST['add-purchase'])) {
        //  print_r($_POST['add-trucking']);
          redirect(base_url('Cinvoice/manage_profarma_invoice'));
          exit;
      } elseif (isset($_POST['add-trucking-another'])) {
         // print_r($_POST['add-trucking-another']);
          redirect(base_url('Cinvoice/trucking'));
          exit;
      }
 }   







    //Insert invoice

    public function insert_invoice() {

        $CI = & get_instance();

        $CI->auth->check_admin_auth();

        $CI->load->model('Invoices');

        $invoice_id = $CI->Invoices->invoice_entry();

        $this->session->set_userdata(array('message' => display('successfully_added')));

        redirect(base_url('Cinvoice/invoice_inserted_data/'.$invoice_id));

    }



    // ================= manual sale insert ============================

    
    // ================= manual sale insert ============================
    




        public function insert_ocean_export() {
        $CI = & get_instance();
        $CI->auth->check_admin_auth();
        $CI->load->model('Invoices');
        $invoice_id=$CI->Invoices->ocean_export_entry();
         echo json_encode($invoice_id);
  
        
    }

/*
       public function invoice_pdf_generate($invoice_id = null) {

        $id = $invoice_id; 

        $this->load->model('Invoices');

        $this->load->model('Web_settings');

        $this->load->library('occational');

        $this->load->library('numbertowords');

        $invoice_detail = $this->Invoices->retrieve_invoice_html_data($invoice_id);

        $taxfield = $this->db->select('*')

                ->from('tax_settings')

                ->where('is_show',1)

                ->get()

                ->result_array();

        $txregname ='';

        foreach($taxfield as $txrgname){

        $regname = $txrgname['tax_name'].' Reg No  - '.$txrgname['reg_no'].', ';

        $txregname .= $regname;

        }       

        $subTotal_quantity = 0;

        $subTotal_cartoon = 0;

        $subTotal_discount = 0;

        $subTotal_ammount = 0;

        $descript = 0;

        $isserial = 0;

        $isunit = 0;

        $is_discount = 0;

        if (!empty($invoice_detail)) {

            foreach ($invoice_detail as $k => $v) {

                $invoice_detail[$k]['final_date'] = $this->occational->dateConvert($invoice_detail[$k]['date']);

            $subTotal_quantity = $subTotal_quantity + $invoice_detail[$k]['quantity'];

            $subTotal_ammount = $subTotal_ammount + $invoice_detail[$k]['total_price'];

            }

            $i = 0;

            foreach ($invoice_detail as $k => $v) {

            $i++;

            $invoice_detail[$k]['sl'] = $i;

            if(!empty($invoice_detail[$k]['description'])){

                $descript = $descript+1;

            }

             if(!empty($invoice_detail[$k]['serial_no'])){

                $isserial = $isserial+1; 

            }

             if(!empty($invoice_detail[$k]['discount_per'])){

                $is_discount = $is_discount+1;   

            }



            if(!empty($invoice_detail[$k]['unit'])){

                    $isunit = $isunit+1;

                    

                }

   

            }

        }



        $currency_details = $this->Web_settings->retrieve_setting_editdata();

        $company_info     = $this->Invoices->retrieve_company();

        $totalbal         = $invoice_detail[0]['total_amount']+$invoice_detail[0]['prevous_due'];

        $amount_inword    = $this->numbertowords->convert_number($totalbal);

        $user_id          = $invoice_detail[0]['sales_by'];

        $users            = $this->Invoices->user_invoice_data($user_id);

         $name            = $invoice_detail[0]['customer_name'];

        $email            = $invoice_detail[0]['customer_email'];

        $data = array(

        'title'             => display('invoice_details'),

        'invoice_id'        => $invoice_detail[0]['invoice_id'],

        'customer_info'     => $invoice_detail,

        'invoice_no'        => $invoice_detail[0]['invoice'],

        'customer_name'     => $invoice_detail[0]['customer_name'],

        'customer_address'  => $invoice_detail[0]['customer_address'],

        'customer_mobile'   => $invoice_detail[0]['customer_mobile'],

        'customer_email'    => $invoice_detail[0]['customer_email'],

        'final_date'        => $invoice_detail[0]['final_date'],

        'invoice_details'   => $invoice_detail[0]['invoice_details'],

        'total_amount'      => number_format($invoice_detail[0]['total_amount']+$invoice_detail[0]['prevous_due'], 2, '.', ','),

        'subTotal_quantity' => $subTotal_quantity,

        'total_discount'    => number_format($invoice_detail[0]['total_discount'], 2, '.', ','),

        'total_tax'         => number_format($invoice_detail[0]['total_tax'], 2, '.', ','),

        'subTotal_ammount'  => number_format($subTotal_ammount, 2, '.', ','),

        'paid_amount'       => number_format($invoice_detail[0]['paid_amount'], 2, '.', ','),

        'due_amount'        => number_format($invoice_detail[0]['due_amount'], 2, '.', ','),

        'previous'          => number_format($invoice_detail[0]['prevous_due'], 2, '.', ','),

        'shipping_cost'     => number_format($invoice_detail[0]['shipping_cost'], 2, '.', ','),

        'invoice_all_data'  => $invoice_detail,

        'company_info'      => $company_info,

        'currency'          => $currency_details[0]['currency'],

        'position'          => $currency_details[0]['currency_position'],

        'discount_type'     => $currency_details[0]['discount_type'],

        'currency_details'  => $currency_details,

        'am_inword'         => $amount_inword,

        'is_discount'       => $is_discount,

        'users_name'        => $users->first_name.' '.$users->last_name,

        'tax_regno'         => $txregname,

        'is_desc'           => $descript,

        'is_serial'         => $isserial,

        'is_unit'           => $isunit,

        );



        $this->load->library('pdfgenerator');

        $html = $this->load->view('invoice/invoice_download', $data, true);

        $dompdf = new DOMPDF();

        $dompdf->load_html($html);

        $dompdf->render();

        $output = $dompdf->output();

        file_put_contents('assets/data/pdf/invoice/' . $id . '.pdf', $output);

        $file_path = getcwd() . '/assets/data/pdf/invoice/' . $id . '.pdf';

        $send_email = '';

        if (!empty($email)) {

            $send_email = $this->setmail($email, $file_path, $invoice_detail[0]['invoice'], $name);

            

            if($send_email){

           return 1;

            }else{

               return 0;

               

            }

           

        }

      return 0; 

       

    }
*/
public function manual_sales_insert(){


    $CI = & get_instance();

    $CI->auth->check_admin_auth();

    $CI->load->model('Invoices');

    $invoice_id = $CI->Invoices->invoice_entry();



    echo json_encode($invoice_id);

}
    public function company_name() {
        $CI = & get_instance();
        $CI->auth->check_admin_auth();
         $CI->load->model('Invoices');
        $companyid=$CI->Invoices->trucking_entry();
        echo json_encode($companyid);
    }


     public function setmail($email, $file_path, $id = null, $name = null) {

        $setting_detail = $this->db->select('*')->from('email_config')->get()->row();

        $subject = 'Purchase  Information';

        $message = strtoupper($name) . '-' . $id;

        $config = Array(

        'protocol'  => $setting_detail->protocol,

        'smtp_host' => $setting_detail->smtp_host,

        'smtp_port' => $setting_detail->smtp_port,

        'smtp_user' => $setting_detail->smtp_user,

        'smtp_pass' => $setting_detail->smtp_pass,

        'mailtype'  => 'html', 

        'charset'   => 'utf-8',

        'wordwrap'  => TRUE

        );

        $this->load->library('email', $config);

        $this->email->set_newline("\r\n");

        $this->email->from($setting_detail->smtp_user);

        $this->email->to($email);

        $this->email->subject($subject);

        $this->email->message($message);

        $this->email->attach($file_path);

        $check_email = $this->test_input($email);

        if (filter_var($check_email, FILTER_VALIDATE_EMAIL)) {

            if ($this->email->send()) {

               

               return true;

            } else {

              

                return false;

            }

        } else {

           

            return true;

        }

    }



    //Email testing for email

    public function test_input($data) {

        $data = trim($data);

        $data = stripslashes($data);

        $data = htmlspecialchars($data);

        return $data;

    }



    //invoice Update Form

    public function invoice_update_form($invoice_id) {

        $CI = & get_instance();

        $CI->auth->check_admin_auth();

        $CI->load->library('linvoice');

        $content = $CI->linvoice->invoice_edit_data($invoice_id);

        $this->template->full_admin_html_view($content);

    }

    

    // invoice Update

    public function invoice_update() {

        $CI = & get_instance();

        $CI->auth->check_admin_auth();

        $CI->load->model('Invoices');

        $invoice_id = $CI->Invoices->update_invoice();

        $this->session->set_userdata(array('message' => display('successfully_updated')));

        // $this->invoice_inserted_data($invoice_id);
          redirect(base_url('Cinvoice/manage_invoice'));

    }

       // purchase Update
    public function update_ocean_export() {

        $CI = & get_instance();
        $CI->auth->check_admin_auth();
        $CI->load->model('Invoices');
        $CI->Invoices->update_ocean_export();
        $this->session->set_userdata(array('message' => display('successfully_updated')));
        redirect(base_url('Cinvoice/manage_ocean_export_tracking'));
        exit;
    }

 

    //Search Inovoice Item

    public function search_inovoice_item() {

        $CI = & get_instance();

        $this->auth->check_admin_auth();

        $CI->load->library('linvoice');



        $customer_id = $this->input->post('customer_id',TRUE);

        $content     = $CI->linvoice->search_inovoice_item($customer_id);

        $this->template->full_admin_html_view($content);

    }



    //Manage invoice list

    public function manage_invoice() {

        $this->session->unset_userdata('invoiceid');

        $this->session->unset_userdata('nation');
        $date = $this->input->post("daterange");

        $CI = & get_instance();

        $this->auth->check_admin_auth();

        $CI->load->library('linvoice');

        $CI->load->model('Invoices');

        $value = $this->linvoice->invoice_list();

        $sale = $CI->Invoices->newsale($date);
       // $CI->load->model('Web_settings');

        $currency_details = $CI->Web_settings->retrieve_setting_editdata();
        $data['currency']          = $currency_details[0]['currency'];
        // print_r($sale); die();

        $data = array(
//'currency'   =>$currency_details[0]['currency'],
            'invoice'         =>  $value,

            'sale' => $sale


        );
        $content = $this->load->view('invoice/invoice', $data, true);
    
        $this->template->full_admin_html_view($content);
      

    }





// $uid=$_SESSION['user_id'];

//  $sql='select c.* from company_information c 
    
//     join 
//     user_login as u 
//     on u.cid=c.company_id
//     where u.user_id='.$uid;
//     $query=$this->db->query($sql);

//     $company_info=$query->result_array();


//  $sql='SELECT c.* from invoice i JOIN customer_information c on c.customer_id=i.customer_id where i.invoice_id='.$uid;
//     $query=$this->db->query($sql);

//     $customer_info=$query->result_array();




//   $sql='SELECT p.* FROM `invoice_details` i JOIN

//  product_information p
//  on p.product_id=i.product_id

//  where 
//  i.invoice_id="'.$invoiceid.'";
//  ';

//     $query=$this->db->query($sql);

//     $product_info=$query->result_array();



//     $data['company_info']=$company_info;
//     $data['customer_info']=$customer_info;
//     $data['product_info']=$product_info;
//     $data['invoiceid']=$invoiceid;




//     $content = $this->load->view('pdf_attach_mail/new_sale', $data, true);
//     if($content)
//     {
//   redirect("Cinvoice/manage_invoice");
// }
//          // $this->template->full_admin_html_view($content);
// }   




public function manage_profarma_invoice() {
    $this->session->unset_userdata('perfarma_invoice_id');
    $date = $this->input->post("daterange");
    $CI = & get_instance();
    $CA = & get_instance();
    $this->auth->check_admin_auth();
    $CI->load->library('linvoice');
    $CI->load->model('Invoices');
    $CA->load->model('Web_settings');
  $invoice = $CI->Invoices->get_profarma_invoice();
  $email_setting = $CA->Web_settings->retrieve_email_setting();
//   print_r($email_setting); die();
  $sale = $CI->Invoices->sample($date);
  $currency_details = $CI->Web_settings->retrieve_setting_editdata();
     $curn_info_default = $CI->db->select('*')->from('currency_tbl')->where('icon',$currency_details[0]['currency'])->get()->result_array();
    $data = array(
           'curn_info_default' =>$curn_info_default[0]['currency_name'],
        'currency' =>$currency_details[0]['currency'],
        'invoice'         =>  $invoice,
        'email_setting'  => $email_setting,
        'sale' => $sale
    );
    $content = $this->load->view('invoice/profarma_invoice_list', $data, true);
    $this->template->full_admin_html_view($content);
}
    public function get_setting() {
        $CI = & get_instance();

        $this->auth->check_admin_auth();
        $CI->load->model('Invoices');
        $menu = $this->input->post('menu');
      
     $submenu = $this->input->post('submenu');
       
        $user=$this->session->userdata('user_id');
  

                $invoice = $CI->Invoices->get_setting($user,$menu,$submenu);
               $menu= $invoice[0]->menu; 
               $submenu=$invoice[0]->submenu;
               $set= $invoice[0]->setting;
$data=array(
'menu'=> $menu,
'submenu'=> $submenu,
'setting' => $set
);
echo json_encode($data);

    }
    public function setting() {
      //  echo "<script>alert(localStorage.getItem('states'))</script>";
        $output = $this->input->post();
        $user=$this->session->userdata('user_id');
$this->output->set_content_type('application/json')
     ->set_output(json_encode($output));
    // echo $output['content'];
  $split= explode("/",$output['page']) ;
$set=json_encode( $output['content']);
  $data=array(
'user' => $user,
'menu' => $split[0],
'submenu' => $split[1],
'setting' => $set
 );
 
 $this->db->select('*');
 $this->db->from('bootgrid_data');
 $this->db->where('user', $user);
 $this->db->where('menu', $split[0]);
 $this->db->where('submenu', $split[1]);
 $query = $this->db->get();

    
        if ($query->num_rows() > 0) {
            $this->db->where('user', $user); 
            $this->db->where('menu', $split[0]); 
            $this->db->where('submenu', $split[1]); 
$this->db->set('setting',$set);
$this->db->update('bootgrid_data');



    }else{
        

 $this->db->insert('bootgrid_data', $data);

    }
   // 
}
    public function insert_packing_list() {

        $CI = & get_instance();
        $CI->auth->check_admin_auth();
        $CI->load->model('Invoices');
        $invoice_id=$CI->Invoices->packing_list_entry();
      echo json_encode($invoice_id);
    
        } 
    

        public function manage_packing_list() {
            $this->session->unset_userdata('packingid');
            $date = $this->input->post("daterange");
            $CI = & get_instance();
            $CA = & get_instance();
            $this->auth->check_admin_auth();
            $CI->load->library('linvoice');
            $CI->load->model('Invoices');
             $CA->load->model('Web_settings');
            $sale = $CI->Invoices->packing_list($date);
            $value = $this->linvoice->packing_invoice_list();
            $email_setting = $CA->Web_settings->retrieve_email_setting();
            // print_r($email_setting); die();
            $data = array(
                 'invoice'         =>  $value,
                 'email_setting' => $email_setting,
                  'sale' => $sale
            );
          //  print_r($sale);
            $content = $this->load->view('invoice/packing_list', $data, true);
            $this->template->full_admin_html_view($content);
        }
    public function packing_list_update_form($purchase_id) {
        $CI = & get_instance();
        $CI->auth->check_admin_auth();
        $CI->load->library('linvoice');
        $content = $CI->linvoice->packing_list_edit_data($purchase_id);
        $this->template->full_admin_html_view($content);
    } 
    public function manage_ocean_export_tracking() {
        $this->session->unset_userdata('oceanid');
        $CI = & get_instance();
        $CA = & get_instance();

        $date = $this->input->post("daterange");
        $this->auth->check_admin_auth();
        $CI->load->library('linvoice');
        $CI->load->model('Invoices');
        $sale = $CI->Invoices->ocean_export($date);
        $value = $this->linvoice->ocean_export_tracking_invoice_list();
        $email_setting = $CA->Web_settings->retrieve_email_setting();
        // print_r($email_setting); die();
        $data = array(

            'invoice'         =>  $value,
            'email_setting' => $email_setting,
            'sale' => $sale
        );
        $content = $this->load->view('invoice/ocean_export_tracking_invoice_list', $data, true);
        $this->template->full_admin_html_view($content);
    }


    public function manage_trucking() {

        $this->session->unset_userdata('truckid');
        $CI = & get_instance();
        $CA = & get_instance();
        $date = $this->input->post("daterange");
        $this->auth->check_admin_auth();
        $CI->load->library('linvoice');
        $CI->load->model('Invoices');
        $value = $this->linvoice->trucking_invoice_list();
        $sale = $CI->Invoices->sale_trucking($date);
        $email_setting = $CA->Web_settings->retrieve_email_setting();

        $currency_details = $CI->Web_settings->retrieve_setting_editdata();
        $data = array(
            'currency' =>$currency_details[0]['currency'],
            'invoice'         =>  $value,


            'email_setting' => $email_setting,

            'sale' => $sale
        );
        $content = $this->load->view('invoice/trucking_invoice_list', $data, true);
        $this->template->full_admin_html_view($content);
    }





        public function CheckInvoiceList(){

        // GET data

        $this->load->model('Invoices');

        $postData = $this->input->post();

        $data = $this->Invoices->getInvoiceList($postData);

        echo json_encode($data);


    } 



    // public function CheckProfarmaInvoiceList(){
       
    //     $CI = & get_instance();
    //     $CI->auth->check_admin_auth();
    //    $CI->load->model('Invoices');
    //     $content = $CI->Invoices->sample();
       
    //     $this->template->full_admin_html_view($content);
 
    // } 

    public function CheckProfarmaInvoiceList(){

        // GET data

        $this->load->model('Invoices');

        $postData = $this->input->post();

        $data = $this->Invoices->getProfarmaInvoiceList($postData);

        echo json_encode($data);

    }


     public function CheckPackingList(){
        // GET data
        $this->load->model('Invoices');
        $postData = $this->input->post();
        $data = $this->Invoices->getPackingList($postData);
        echo json_encode($data);
    }





    public function index1()
    { $CI = & get_instance();
        $CI->load->model('Invoices','boot');
        $data['data'] = $this->boot->get_datas();
        print_r($data);
        die();
        $this->load->view('invoice/profarma_invoice_list',$data);
    }

     //Retrive right now inserted data to cretae html
    public function ocean_export_tracking_details_data($purchase_id) {

        $CI = & get_instance();
        $CI->auth->check_admin_auth();
       $CI->load->library('linvoice');
        $content = $CI->linvoice->ocean_export_tracking_details_data($purchase_id);
       // echo json_encode($content);
      $this->template->full_admin_html_view($content);
    }
    public function add_payment_type(){
        $this->load->model('Invoices');
        
        $postData = $this->input->post('new_payment_type');
        
        $data = $this->Invoices->add_payment_type($postData);
        echo json_encode($data);
       

    }


      public function CheckOceanExportList(){
        // GET data
         $this->load->model('Invoices');
        $postData = $this->input->post();
        $data = $this->Invoices->getOceanExportList($postData);
        echo json_encode($data);
    } 


        public function CheckTruckingList(){
         $this->load->model('Invoices');
        $postData = $this->input->post();
        $data = $this->Invoices->getTruckingList($postData);
        echo json_encode($data);
     }
     public function select_bank_name(){
   
    }

          //Trucking Update Form
    public function trucking_update_form($purchase_id) {
        $CI = & get_instance();
        $CI->auth->check_admin_auth();
        $CI->load->library('linvoice');
        $content = $CI->linvoice->trucking_edit_data($purchase_id);
        $this->template->full_admin_html_view($content);
    } 


// invoice list pdf download

    public function sale_downloadpdf(){

        $CI = & get_instance();

        $CI->load->model('Invoices');

        $CI->load->model('Web_settings');

        $CI->load->library('occational');

        $CI->load->library('linvoice');

        $CI->load->library('pdfgenerator'); 

        $invoices_list = $CI->Invoices->invoice_list_pdf();

        if (!empty($invoices_list)) {

            $i = 0;

            if (!empty($invoices_list)) {

                 foreach ($invoices_list as $k => $v) {

                $invoices_list[$k]['final_date'] = $CI->occational->dateConvert($invoices_list[$k]['date']);

            }

                foreach ($invoices_list as $k => $v) {

                    $i++;

                    $invoices_list[$k]['sl'] = $i + $CI->uri->segment(3);

                }

            }

        }

        $currency_details = $CI->Web_settings->retrieve_setting_editdata();

         $company_info = $CI->Invoices->retrieve_company();

        $data = array(

            'title'         => display('manage_invoice'),

            'invoices_list' => $invoices_list,

            'currency'      => $currency_details[0]['currency'],

            'logo'          => $currency_details[0]['logo'],

            'position'      => $currency_details[0]['currency_position'],

            'company_info'  => $company_info

        );

            $this->load->helper('download');

            $content = $this->parser->parse('invoice/invoice_list_pdf', $data, true);

            $time = date('Ymdhi');

            $dompdf = new DOMPDF();

            $dompdf->load_html($content);

            $dompdf->render();

            $output = $dompdf->output();

            file_put_contents('assets/data/pdf/'.'sales'.$time.'.pdf', $output);

            $file_path = 'assets/data/pdf/'.'sales'.$time.'.pdf';

           $file_name = 'sales'.$time.'.pdf';

            force_download(FCPATH.'assets/data/pdf/'.$file_name, null);

    }





//         public function invoicdetails_download($invoice_id = null) {



//         $this->load->model('Invoices');

//         $this->load->model('Web_settings');

//         $this->load->library('occational');

//         $this->load->library('numbertowords');

//         $invoice_detail = $this->Invoices->retrieve_invoice_html_data($invoice_id);

//          // print_r($invoice_detail);
//          // die;

//         $taxfield = $this->db->select('*')

//                 ->from('tax_settings')

//                 ->where('is_show',1)

//                 ->get()

//                 ->result_array();

//         $txregname ='';

//         foreach($taxfield as $txrgname){

//         $regname = $txrgname['tax_name'].' Reg No  - '.$txrgname['reg_no'].', ';

//         $txregname .= $regname;

//         }       

//         $subTotal_quantity = 0;

//         $subTotal_cartoon = 0;

//         $subTotal_discount = 0;

//         $subTotal_ammount = 0;

//         $descript = 0;

//         $isserial = 0;

//         $isunit = 0;

//         $is_discount = 0;

//         if (!empty($invoice_detail)) {

//             foreach ($invoice_detail as $k => $v) {

//                 $invoice_detail[$k]['final_date'] = isset($invoice_detail[$k]['date'])?$this->occational->dateConvert($invoice_detail[$k]['date']):$this->occational->dateConvert(date('Y-m-d'));

//                 $subTotal_quantity = $subTotal_quantity + $invoice_detail[$k]['quantity'];

//                 $subTotal_ammount = $subTotal_ammount + $invoice_detail[$k]['total_price']; 

//             }

//             $i = 0;

//             foreach ($invoice_detail as $k => $v) {

//                 $i++;

//                 $invoice_detail[$k]['sl'] = $i;

//                 if(!empty($invoice_detail[$k]['description'])){

//                     $descript = $descript+1;

//                 }

//                  if(!empty($invoice_detail[$k]['serial_no'])){

//                     $isserial = $isserial+1;

//                 }

//                  if(!empty($invoice_detail[$k]['discount_per'])){

//                     $is_discount = $is_discount+1;

//                 }

//                 if(!empty($invoice_detail[$k]['unit'])){

//                     $isunit = $isunit+1;

//                 }

//             }

//         }


//         $t=isset($invoice_detail[0]['total_amount'])?$invoice_detail[0]['total_amount']:0;
//         $t1=isset($invoice_detail[0]['prevous_due'])?$invoice_detail[0]['prevous_due']:0;
//         $currency_details = $this->Web_settings->retrieve_setting_editdata();

//         $company_info     = $this->Invoices->retrieve_company();

//         $totalbal         = $t+$t1;

//         $amount_inword    = $this->numbertowords->convert_number($totalbal);

//         $user_id          = isset($invoice_detail[0]['sales_by'])?$invoice_detail[0]['sales_by']:0;

//         $users            = $this->Invoices->user_invoice_data($user_id);

//         $data = array(

//         'title'             => display('invoice_details'),

//         'invoice_id'        => @$invoice_detail[0]['invoice_id'],

//         'customer_info'     => @$invoice_detail,

//         'invoice_no'        => @$invoice_detail[0]['invoice'],

//         'customer_name'     => @$invoice_detail[0]['customer_name'],

//         'customer_address'  => @$invoice_detail[0]['customer_address'],

//         'customer_mobile'   => @$invoice_detail[0]['customer_mobile'],

//         'customer_email'    => @$invoice_detail[0]['customer_email'],

//         'final_date'        => @$invoice_detail[0]['final_date'],

//         'invoice_details'   => @$invoice_detail[0]['invoice_details'],

//         'total_amount'      => number_format($t+$t1, 2, '.', ','),

//         'subTotal_quantity' => $subTotal_quantity,

//         'total_discount'    =>isset($invoice_detail[0]['total_discount'])?number_format($invoice_detail[0]['total_discount'], 2, '.', ','):0,

//         'total_tax'         => isset($invoice_detail[0]['total_tax'])?number_format($invoice_detail[0]['total_tax'], 2, '.', ','):0,

//         'subTotal_ammount'  => number_format($subTotal_ammount, 2, '.', ','),

//         'paid_amount'       => isset($invoice_detail[0]['paid_amount'])?number_format($invoice_detail[0]['paid_amount'], 2, '.', ','):0,

//         'due_amount'        => isset($invoice_detail[0]['due_amount'])?number_format($invoice_detail[0]['due_amount'], 2, '.', ','):0,

//         'previous'          => number_format($t1, 2, '.', ','),

//         'shipping_cost'     => isset($invoice_detail[0]['shipping_cost'])?number_format($invoice_detail[0]['shipping_cost'], 2, '.', ','):0,

//         'invoice_all_data'  => $invoice_detail,

//         'company_info'      => $company_info,

//         'currency'          => $currency_details[0]['currency'],

//         'position'          => $currency_details[0]['currency_position'],

//         'discount_type'     => $currency_details[0]['discount_type'],

//         'currency_details'  => $currency_details,

//         'am_inword'         => $amount_inword,

//         'is_discount'       => $is_discount,

//         'users_name'        => $users->first_name.' '.$users->last_name,

//         'tax_regno'         => $txregname,

//         'is_desc'           => $descript,

//         'is_serial'         => $isserial,

//         'is_unit'           => $isunit,

//         );

//    $this->load->library('pdfgenerator');

//         $dompdf = new DOMPDF();

//         $page = $this->load->view('invoice/invoice_download', $data, true);

//         $file_name = time();

//         $dompdf->load_html($page,'UTF-8');

//         $dompdf->render();

//         $output = $dompdf->output();

//         file_put_contents("assets/data/pdf/invoice/$file_name.pdf", $output);

//         $filename = $file_name . '.pdf';

//         $file_path = base_url() . 'assets/data/pdf/invoice/' . $filename;



//         $this->load->helper('download');

//         force_download('./assets/data/pdf/invoice/' . $filename, NULL);

//         redirect("Cinvoice/manage_invoice");

//     }



    // search invoice by customer id

    public function invoice_search() {

        $CI = & get_instance();

        $this->auth->check_admin_auth();

        $CI->load->library('linvoice');

        $CI->load->model('Invoices');

        $customer_id = $this->input->get('customer_id');

        #

        #pagination starts

        #

        $config["base_url"] = base_url('Cinvoice/invoice_search/');

        $config["total_rows"] = $this->Invoices->invoice_search_count($customer_id);

        $config["per_page"] = 10;

        $config["uri_segment"] = 3;

        $config["num_links"] = 5;

        $config['suffix'] = '?' . http_build_query($_GET);

        $config['first_url'] = $config["base_url"] . $config['suffix'];

        /* This Application Must Be Used With BootStrap 3 * */

        $config['full_tag_open'] = "<ul class='pagination'>";

        $config['full_tag_close'] = "</ul>";

        $config['num_tag_open'] = '<li>';

        $config['num_tag_close'] = '</li>';

        $config['cur_tag_open'] = "<li class='disabled'><li class='active'><a href='#'>";

        $config['cur_tag_close'] = "<span class='sr-only'></span></a></li>";

        $config['next_tag_open'] = "<li>";

        $config['next_tag_close'] = "</li>";

        $config['prev_tag_open'] = "<li>";

        $config['prev_tagl_close'] = "</li>";

        $config['first_tag_open'] = "<li>";

        $config['first_tagl_close'] = "</li>";

        $config['last_tag_open'] = "<li>";

        $config['last_tagl_close'] = "</li>";

        /* ends of bootstrap */

        $this->pagination->initialize($config);

        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;

        $links = $this->pagination->create_links();

        #

        #pagination ends

        #  

        $content = $this->linvoice->invoice_search($customer_id, $links, $config["per_page"], $page);

        $this->template->full_admin_html_view($content);

    }



    // search invoice by invoice id

    public function manage_invoice_invoice_id() {

        $CI = & get_instance();

        $this->auth->check_admin_auth();

        $CI->load->library('linvoice');

        $CI->load->model('Invoices');

        $invoice_no = $this->input->post('invoice_no',TRUE);

        $content = $this->linvoice->invoice_list_invoice_no($invoice_no);

        $this->template->full_admin_html_view($content);

    }



    // invoice list date to date 

    public function date_to_date_invoice() {

        $CI = & get_instance();

        $this->auth->check_admin_auth();

        $CI->load->library('linvoice');

        $CI->load->model('Invoices');

        $from_date = $this->input->get('from_date');

        $to_date = $this->input->get('to_date');



        #

        #pagination starts

        #

        $config["base_url"] = base_url('Cinvoice/date_to_date_invoice/');

        $config["total_rows"] = $this->Invoices->invoice_list_date_to_date_count($from_date, $to_date);

        $config["per_page"] = 10;

        $config["uri_segment"] = 3;

        $config["num_links"] = 5;

        $config['suffix'] = '?' . http_build_query($_GET, '', '&');

        $config['first_url'] = $config["base_url"] . $config['suffix'];

        /* This Application Must Be Used With BootStrap 3 * */

        $config['full_tag_open'] = "<ul class='pagination'>";

        $config['full_tag_close'] = "</ul>";

        $config['num_tag_open'] = '<li>';

        $config['num_tag_close'] = '</li>';

        $config['cur_tag_open'] = "<li class='disabled'><li class='active'><a href='#'>";

        $config['cur_tag_close'] = "<span class='sr-only'></span></a></li>";

        $config['next_tag_open'] = "<li>";

        $config['next_tag_close'] = "</li>";

        $config['prev_tag_open'] = "<li>";

        $config['prev_tagl_close'] = "</li>";

        $config['first_tag_open'] = "<li>";

        $config['first_tagl_close'] = "</li>";

        $config['last_tag_open'] = "<li>";

        $config['last_tagl_close'] = "</li>";

        /* ends of bootstrap */

        $this->pagination->initialize($config);

        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;

        $links = $this->pagination->create_links();

        #

        #pagination ends

        #  



        $content = $this->linvoice->invoice_list_date_to_date($from_date, $to_date, $links, $config["per_page"], $page);

        $this->template->full_admin_html_view($content);

    }


 


    public function packing_list_details_data($expense_id) {
    
      $CI = & get_instance();
        $CC = & get_instance();
        $CA = & get_instance();
        $CB = & get_instance();
        $w = & get_instance();
        $CI->auth->check_admin_auth();
        $CI->load->library('linvoice');
        $CB->load->model('Invoices');
        $CA->load->model('invoice_design');
        $CC->load->model('invoice_content');
        $w->load->model('Ppurchases');
        $company_info = $w->Ppurchases->retrieve_company();
        // print_r($company_info); exit();
        $dataw = $CA->invoice_design->retrieve_data();
        // print_r($dataw); die();
        $datacontent = $CI->invoice_content->retrieve_data();

        $packing_details = $CB->Invoices->packing_details_data($expense_id);
     

 
        $data=array(
            'header'=> $dataw[0]['header'],
            'logo'=> $dataw[0]['logo'],
            'color'=> $dataw[0]['color'],
            'template'=> $dataw[0]['template'],
            'company' => $company_info[0]['company_name'],
            'address' => $company_info[0]['address'],
            'email' => $company_info[0]['email'],
            'phone' => $company_info[0]['mobile'],
            'invoice'  =>$packing_details[0]['invoice_no'],
            'invoice_date' => $packing_details[0]['invoice_date'],
            'expense_packing_id'=>$packing_details[0]['expense_packing_id'],
            'gross' => $packing_details[0]['gross_weight'],
            'container' => $packing_details[0]['container_no'],
            'remarks' => $packing_details[0]['remarks'],
            'description' => $packing_details[0]['description'],
            'thickness' => $packing_details[0]['thickness'],
            'total' => $packing_details[0]['grand_total_amount'],
            'serial' => $packing_details[0]['serial_no'],
            'slab' => $packing_details[0]['slab_no'],
            'width' => $packing_details[0]['width'],
            'packing_details'=>$packing_details,
            'height' => $packing_details[0]['height'],
            'area' => $packing_details[0]['area'],
            'product' => $packing_details[0]['product_name']
        );
     

       // echo $content = $CI->linvoice->invoice_add_form();
        $content = $this->load->view('invoice/packing_list_invoice_html', $data, true);
        //$content='';
        $this->template->full_admin_html_view($content);
    }





    //POS invoice page load

    public function pos_invoice() {

        $CI = & get_instance();

        $CI->auth->check_admin_auth();

        $CI->load->library('linvoice');

        $content = $CI->linvoice->pos_invoice_add_form();

        $this->template->full_admin_html_view($content);

    }



    //Insert pos invoice

    public function insert_pos_invoice() {

        $CI = & get_instance();

        $CI->auth->check_admin_auth();

        $CI->load->model('Invoices');

        $CI->load->model('Web_settings');

        $product_id = $this->input->post('product_id',TRUE);



        $product_details  = $CI->Invoices->pos_invoice_setup($product_id);

        $currency_details = $CI->Web_settings->retrieve_setting_editdata();

        $taxfield = $CI->db->select('tax_name,default_value')

                ->from('tax_settings')

                ->get()

                ->result_array();

           $prinfo = $this->db->select('*')->from('product_information')->where('product_id',$product_id)->get()->result_array();

        $tr = " ";

        if (!empty($product_details)) {

            $product_id = $this->generator(5);

            $serialdata =explode(',', $product_details->serial_no);

            if($product_details->total_product > 0){

              $qty = 1;

            }else{

                $qty = 1;

            }



        $html = "";

        if (empty($serialdata)) {

            $html .="No Serial Found !";

        }else{

            // Select option created for product

            $html .="<select name=\"serial_no[]\"   class=\"serial_no_1 form-control\" id=\"serial_no_" . $product_details->product_id . "\">";

                $html .= "<option value=''>".display('select_one')."</option>";

                foreach ($serialdata as $serial) {

                    $html .="<option value=".$serial.">".$serial."</option>";

                }   

            $html .="</select>";

        }

            

            $tr .= "<tr id=\"row_" . $product_details->product_id . "\">

                        <td class=\"\" style=\"width:220px\">

                            

                            <input type=\"text\" name=\"product_name\" onkeypress=\"invoice_productList('" . $product_details->product_id . "');\" class=\"form-control productSelection \" value='" . $product_details->product_name . "- (" . $product_details->product_model . ")" . "' placeholder='" . display('product_name') . "' required=\"\" id=\"product_name_" . $product_details->product_id . "\" tabindex=\"\" readonly>



                            <input type=\"hidden\" class=\"form-control autocomplete_hidden_value product_id_" . $product_details->product_id . "\" name=\"product_id[]\" id=\"SchoolHiddenId_" . $product_details->product_id . "\" value = \"$product_details->product_id\"/>

                            

                        </td>

                         <td>

                             <input type=\"text\" name=\"desc[]\" class=\"form-control text-right \"  />

                                        </td>

                                        <td>".$html."</td>

                        <td>

                            <input type=\"text\" name=\"available_quantity[]\" class=\"form-control text-right available_quantity_" . $product_details->product_id . "\" value='" . $product_details->total_product . "' readonly=\"\" id=\"available_quantity_" . $product_details->product_id . "\"/>

                        </td>



                        <td>

                            <input class=\"form-control text-right unit_'" . $product_details->product_id . "' valid\" value=\"$product_details->unit\" readonly=\"\" aria-invalid=\"false\" type=\"text\">

                        </td>

                    

                        <td>

                            <input type=\"text\" name=\"product_quantity[]\" onkeyup=\"quantity_calculate('" . $product_details->product_id . "');\" onchange=\"quantity_calculate('" . $product_details->product_id . "');\" class=\"total_qntt_" . $product_details->product_id . " form-control text-right\" id=\"total_qntt_" . $product_details->product_id . "\" placeholder=\"0.00\" min=\"0\" value='" . $qty . "'/>

                        </td>



                        <td style=\"width:85px\">

                            <input type=\"text\" name=\"product_rate[]\" onkeyup=\"quantity_calculate('" . $product_details->product_id . "');\" onchange=\"quantity_calculate('" . $product_details->product_id . "');\" value='" . $product_details->price . "' id=\"price_item_" . $product_details->product_id . "\" class=\"price_item1 form-control text-right\" required placeholder=\"0.00\" min=\"0\"/>

                        </td>



                        <td class=\"\">

                            <input type=\"text\" name=\"discount[]\" onkeyup=\"quantity_calculate('" . $product_details->product_id . "');\" onchange=\"quantity_calculate('" . $product_details->product_id . "');\" id=\"discount_" . $product_details->product_id . "\" class=\"form-control text-right\" placeholder=\"0.00\" min=\"0\"/>



                            <input type=\"hidden\" value=" . $currency_details[0]['discount_type'] . " name=\"discount_type\" id=\"discount_type_" . $product_details->product_id . "\">

                        </td>



                        <td class=\"text-right\" style=\"width:100px\">

                            <input class=\"total_price form-control text-right\" type=\"text\" name=\"total_price[]\" id=\"total_price_" . $product_details->product_id . "\" value='" . $product_details->price . "' tabindex=\"-1\" readonly=\"readonly\"/>

                        </td>



                        <td>";

                        $sl=0;

                        foreach ($taxfield as $taxes) {

                            $txs = 'tax'.$sl;

                           $tr .= "<input type=\"hidden\" id=\"total_tax".$sl."_" . $product_details->product_id . "\" class=\"total_tax".$sl."_" . $product_details->product_id . "\" value='" . $prinfo[0][$txs] . "'/>

                            <input type=\"hidden\" id=\"all_tax".$sl."_" . $product_details->product_id . "\" class=\" total_tax".$sl."\" value='" . $prinfo[0][$txs]*$product_details->price . "' name=\"tax[]\"/>";  

                       $sl++; }

                        

                             $tr .= "<input type=\"hidden\" id=\"total_discount_" . $product_details->product_id . "\" />

                            <input type=\"hidden\" id=\"all_discount_" . $product_details->product_id . "\" class=\"total_discount dppr\"/>

                            <button  class=\"btn btn-danger btn-xs text-center\" type=\"button\"  onclick=\"deleteRow(this)\">" . '<i class="fa fa-close"></i>' . "</button>

                        </td>

                    </tr>";

            echo $tr;

        } else {

            return false;

        }

    }



    //Retrive right now inserted data to cretae html

    public function invoice_inserted_data($invoice_id) {

       // echo $invoice_id; die();

        $CI = & get_instance();
        $CC = & get_instance();
        $CA = & get_instance();
        $w = & get_instance();

        $w->load->model('Ppurchases');
        $company_info = $w->Ppurchases->retrieve_company();
        $CI->load->model('Invoices');
        $CA->load->model('invoice_design');
        $CC->load->model('invoice_content');

        $invoice_detail = $CI->Invoices->invoice_pdf($invoice_id);

        // print_r($invoice_detail); die();

        $all_invoice = $CI->Invoices->all_invoice($invoice_id);

         // print_r($all_invoice); die();

        $dataw = $CA->invoice_design->retrieve_data();
       
        $datacontent = $CC->invoice_content->retrieve_data();

        $customer = $this->db->select('*')->from('customer_information')->where("customer_id",$invoice_detail[0]['customer_id'])->get()->result_array();

        $currency_details = $CI->Web_settings->retrieve_setting_editdata();
        $curn_info_default = $CI->db->select('*')->from('currency_tbl')->where('icon',$currency_details[0]['currency'])->get()->result_array();
      

         $product_name = $this->db->select('*')->from('product_information')->where("product_id",$all_invoice[0]['product_id'])->get()->result_array();

        //  echo $this->db->last_query(); die();

          // print_r($product_name); die();

        $data=array(
            'curn_info_default' =>$curn_info_default[0]['currency_name'],
            'currency'  =>$currency_details[0]['currency'],
            'header'=> $dataw[0]['header'],
            'logo'=> $dataw[0]['logo'],
            'color'=> $dataw[0]['color'],
            'template'=> $dataw[0]['template'],
            'packing_id'  =>$invoice_detail[0]['packing_id'],
            'company'=> $company_info,
            'customer_currency'=> $customer[0]['currency_type'],
            'customername'=> $customer[0]['customer_name'],
            'payment'=> $invoice_detail[0]['payment_type'],
            'billing'=> $invoice_detail[0]['billing_address'],
            'date'=> $invoice_detail[0]['date'],
            'paymentterms'=> $invoice_detail[0]['payment_terms'],
            'days'=> $invoice_detail[0]['number_of_days'],
            'mobile'=> $customer[0]['customer_mobile'],
            'customeraddress'=> $customer[0]['customer_address'],
            'invoicenumber'=> $invoice_detail[0]['commercial_invoice_number'],
            'container'=> $invoice_detail[0]['container_no'],
            'blno'=> $invoice_detail[0]['bl_no'],
            'port'=> $invoice_detail[0]['port_of_discharge'],
            'paymentdue'=> $invoice_detail[0]['payment_due_date'],
           
            'all_products'=>$product_name,
           'all_invoice'=>$all_invoice,
            'quantity'=> $all_invoice[0]['quantity'],
            'rate'=> $all_invoice[0]['rate'],
            'ac_details'=> $all_invoice[0]['ac_details'],
            'remark'=> $all_invoice[0]['remark'],
            'total'=> $all_invoice[0]['total_price'],
            'tax_details'=> $all_invoice[0]['total_tax'],
            'etd'=> $all_invoice[0]['etd'],
            'eta'=> $all_invoice[0]['eta'],
            'amt_paid'=> $all_invoice[0]['amt_paid'],
            'balance'=> $all_invoice[0]['balance'],
            'gtotal'       => $all_invoice[0]['gtotal']
        );
   
    

    $content = $this->load->view('invoice/new_invoice_pdf_html', $data, true);

    $this->template->full_admin_html_view($content);
    }


    public function sale_packing(){

        $CI = & get_instance();
        $CC = & get_instance();
        $CA = & get_instance();
        $w = & get_instance();

        $w->load->model('Ppurchases');
        $company_info = $w->Ppurchases->retrieve_company();
        $CI->load->model('Invoices');
        $CA->load->model('invoice_design');
        $CC->load->model('invoice_content');
        
        $company_info = $w->Ppurchases->retrieve_company();
        $packing_detail = $CI->Invoices->packing_pdf();

        // print_r($packing_detail); die();

        $data=array(
            'header'=> $dataw[0]['header'],
            'logo'=> $dataw[0]['logo'],
            'color'=> $dataw[0]['color'],
            'template'=> $dataw[0]['template'],
            'company'=> $company_info[0]['company_name'],
            // 'address'=> $company_info[0]['address'],
            // 'customername'=> $customer[0]['customer_name'],
            // 'payment'=> $invoice_detail[0]['payment_type'],
            // 'billing'=> $invoice_detail[0]['billing_address'],
            // 'date'=> $invoice_detail[0]['date'],
            // 'paymentterms'=> $invoice_detail[0]['payment_terms'],
            // 'days'=> $invoice_detail[0]['number_of_days'],
            // 'mobile'=> $customer[0]['customer_mobile'],
            // 'customeraddress'=> $customer[0]['customer_address'],
            // 'invoicenumber'=> $invoice_detail[0]['commercial_invoice_number'],
            // 'container'=> $invoice_detail[0]['container_no'],
            // 'blno'=> $invoice_detail[0]['bl_no'],
            // 'port'=> $invoice_detail[0]['port_of_discharge'],
            // 'paymentdue'=> $invoice_detail[0]['payment_due_date'],
            // 'product'=> $product_name[0]['product_name'],
            // 'stock'=> $product_name[0]['p_quantity'],
            // 'quantity'=> $all_invoice[0]['quantity'],
            // 'rate'=> $all_invoice[0]['rate'],
            // 'total'=> $all_invoice[0]['total_price'],
        );
     
    

    $content = $this->load->view('invoice/packing_list_invoice_html', $data, true);

    $this->template->full_admin_html_view($content);



    }



    public function profarma_invoice_inserted_data() {

        $CI = & get_instance();
        ////////////Tax value////////////////

        $tx=& get_instance();
        $tx->load->model('Tax');
        $tx->Tax->taxlist();
       // $taxfield = $CI->db->select('tax_name,default_value')
       // ->from('tax_settings')
       // ->get()
       // ->result_array();   
       // $data1 = array(
           
       //     'taxes'         => $taxfield
            
      //  );
      //  $invoiceForm = $CI->parser->parse('invoice/add_invoice_form', $data1, true);
        $CI = & get_instance();
        $CI->load->model('Invoices');
        $CI->load->model('Web_settings');
        $customer_details = $CI->Invoices->pos_customer_setup();
     
        $currency_details = $CI->Web_settings->retrieve_setting_editdata();
        $taxfield1 = $CI->db->select('tax_id,tax')
        ->from('tax_information')
        ->get()
        ->result_array();
        $taxfield = $CI->db->select('tax_name,default_value')
                ->from('tax_settings')
                ->get()
                ->result_array();
        $bank_list          = $CI->Web_settings->bank_list();
        $prodt = $CI->db->select('product_name,product_model,p_quantity')
        ->from('product_information')
        ->get()
        ->result_array();
        $voucher_no = $CI->Invoices->packing_list_no();
       
        $data = array(
            'title'         => display('add_new_invoice'),
            'discount_type' => $currency_details[0]['discount_type'],
            'taxes'         => $taxfield,
            'tax'           => $taxfield1,
            'product'       =>$prodt,
           
            'customer_name' => isset($customer_details[0]['customer_name'])?$customer_details[0]['customer_name']:'',
            'customer_id'   => isset($customer_details[0]['customer_id'])?$customer_details[0]['customer_id']:'',
            'bank_list'     => $bank_list,
            'voucher_no' => $voucher_no,
                'tax_name'=>'ww',
        );
        $content = $this->load->view('invoice/profarma_invoice_html', $data, true);
        //$content='';
        $this->template->full_admin_html_view($content);

    }


    public function packing_invoice_inserted_data(){
         $CI = & get_instance();

        $CI->auth->check_admin_auth();

        $CI->load->library('linvoice');
        $data=array();
       // echo $content = $CI->linvoice->invoice_add_form();
        $content = $this->load->view('invoice/packing_list_invoice_html', $data, true);
        //$content='';
        $this->template->full_admin_html_view($content);
    }

     public function ocean_invoice_inserted_data(){
         $CI = & get_instance();

        $CI->auth->check_admin_auth();

        $CI->load->library('linvoice');
        $data=array();
       // echo $content = $CI->linvoice->invoice_add_form();
        $content = $this->load->view('invoice/ocean_export_invoice_html', $data, true);
        //$content='';
        $this->template->full_admin_html_view($content);
    }


     public function trucking_invoice_inserted_data(){
         $CI = & get_instance();

        $CI->auth->check_admin_auth();

        $CI->load->library('linvoice');
        $data=array();
       // echo $content = $CI->linvoice->invoice_add_form();
        $content = $this->load->view('invoice/trucking_invoice_html', $data, true);
        //$content='';
        $this->template->full_admin_html_view($content);
    }





        public function invoice_inserted_data_manual() {

        $CI = & get_instance();

        $CI->auth->check_admin_auth();

        $invoice_id = $this->input->post('invoice_id',TRUE);

        $CI->load->library('linvoice');

        $content = $CI->linvoice->invoice_html_data_manual($invoice_id);

        $this->template->full_admin_html_view($content);

    }

    public function pos_invoice_inserted_data_manual() {

        $CI = & get_instance();

        $CI->auth->check_admin_auth();

        $CI->load->library('linvoice');

        $invoice_id = $this->input->post('invoice_id',TRUE);

        $url = $this->input->post('url',TRUE);

        $content = $CI->linvoice->pos_invoice_html_data_manual($invoice_id,$url);

        $this->template->full_admin_html_view($content);

    }





    //Retrive right now inserted data to cretae html

    public function pos_invoice_inserted_data($invoice_id) {

        // 


    }

//Min invoice data

     public function min_invoice_inserted_data($invoice_id) {

        $CI = & get_instance();

        $CI->auth->check_admin_auth();

        $CI->load->library('linvoice');

        $content = $CI->linvoice->min_invoice_html_data($invoice_id);

        $this->template->full_admin_html_view($content);

    }



    // Retrieve_product_data from expense

        public function retrieve_product_data() {

        $CI = & get_instance();

        $this->auth->check_admin_auth();

        $CI->load->model('Invoices');

        $product_id  = $this->input->post('product_id',TRUE);

        $supplier_id = $this->input->post('supplier_id',TRUE);



        $product_info = $CI->Invoices->get_total_product($product_id, $supplier_id);



        echo json_encode($product_info);

    }



    //Retrieve_product_data from purchase order


      public function retrieve_product_data_from_po() {

        $CI = & get_instance();

        $this->auth->check_admin_auth();

        $CI->load->model('Invoices');

        $product_id  = $this->input->post('product_id',TRUE);

        //$supplier_id = $this->input->post('supplier_id',TRUE);



        $product_info = $CI->Invoices->get_total_product_from_purchase_order($product_id);



        echo json_encode($product_info);

    }

    // Retrieve_product_data

    // public function retrieve_product_data() {

    //      echo "hello";return;

    //     $CI = & get_instance();

    //     $this->auth->check_admin_auth();

    //     $CI->load->model('Invoices');

    //     $product_id  = $this->input->post('product_id',TRUE);

    //     $supplier_id = $this->input->post('supplier_id',TRUE);



    //     $product_info = $CI->Invoices->get_total_product($product_id, $supplier_id);



    //     echo json_encode($product_info);

    // }



    //product info retrive by product id for invoice

    public function retrieve_product_data_inv() {

        $CI = & get_instance();

        $this->auth->check_admin_auth();

        $CI->load->model('Invoices');

        $product_id = $this->input->post('product_id',TRUE);

        $product_info = $CI->Invoices->get_total_product_invoic($product_id);



        echo json_encode($product_info);

    }



    // Invoice delete

    public function invoice_delete($invoice_id) {

        $CI = & get_instance();

        $this->auth->check_admin_auth();

        $CI->load->model('Invoices');

        $result = $CI->Invoices->delete_invoice($invoice_id);

        if ($result) {

            $this->session->set_userdata(array('message' => display('successfully_delete')));

             redirect('Cinvoice/manage_invoice');

        }

    }



        public function autocompleteproductsearch(){

        $CI =& get_instance();

        $this->auth->check_admin_auth();

        $CI->load->model('Invoices');

        $product_name   = $this->input->post('product_name',TRUE);

        $product_info   = $CI->Invoices->autocompletproductdata($product_name);



       if(!empty($product_info)){

        $list[''] = '';

        foreach ($product_info as $value) {
          
            $json_product[] = array('label'=>$value['product_name'].'('.$value['product_model'].')','value'=>$value['product_id']);

        } 

    }else{

        //$json_product[] = 'No Product Found';
        $json_product[] = 'Add New Product';

        }

        echo json_encode($json_product);

    

    }



    //AJAX INVOICE STOCKs

    public function product_stock_check($product_id) {

        $CI = & get_instance();

        $this->auth->check_admin_auth();

        $CI->load->model('Invoices');

        $purchase_stocks = $CI->Invoices->get_total_purchase_item($product_id);

        $total_purchase = 0;

        if (!empty($purchase_stocks)) {

            foreach ($purchase_stocks as $k => $v) {

                $total_purchase = ($total_purchase + $purchase_stocks[$k]['quantity']);

            }

        }

        $sales_stocks = $CI->Invoices->get_total_sales_item($product_id);

        $total_sales = 0;

        if (!empty($sales_stocks)) {

            foreach ($sales_stocks as $k => $v) {

                $total_sales = ($total_sales + $sales_stocks[$k]['quantity']);

            }

        }



        $final_total = ($total_purchase - $total_sales);

        return $final_total;

    }



//    =========== its for 1 increment =============

    function randomChange($myValue) {

        $random = rand(0, 1);

        if ($random > 0)

            return $myValue + 1;



        return $myValue - 1;

    }



    //This function is used to Generate Key

    public function generator($lenth) {

        $number = array("1", "2", "3", "4", "5", "6", "7", "8", "9");



        for ($i = 0; $i < $lenth; $i++) {

            $rand_value = rand(0, 8);

            $rand_number = $number["$rand_value"];



            if (empty($con)) {

                $con = $rand_number;

            } else {

                $con = "$con" . "$rand_number";

            }

        }

        return $con;

    }

    //customer previous due

     public function previous() {

         $CI = & get_instance();

        $CI->load->model('Customers');

        $customer_id = $this->input->post('customer_id',TRUE);

        $this->db->select("a.*,b.HeadCode,((select ifnull(sum(Debit),0) from acc_transaction where COAID= `b`.`HeadCode` AND IsAppove = 1)-(select ifnull(sum(Credit),0) from acc_transaction where COAID= `b`.`HeadCode` AND IsAppove = 1)) as balance");

         $this->db->from('customer_information a');

         $this->db->join('acc_coa b','a.customer_id = b.customer_id','left');

         $this->db->where('a.customer_id',$customer_id);

        $result = $this->db->get()->result_array();

       $balance = $result[0]['balance'];   

       $b = (!empty($balance)?$balance:0);                            

        if ($b){

           echo  $b;

        } else {

           echo  $b;

        }

    }



    public function customer_autocomplete(){

        $CI =& get_instance();

        $this->auth->check_admin_auth();

        $CI->load->library('lpurchase');

        $CI->load->model('Customers');

        $customer_id    = $this->input->post('customer_id',TRUE);

        $customer_info   = $CI->Customers->customer_search($customer_id);



          if($customer_info){

        $json_customer[''] = '';

        foreach ($customer_info as $value) {

            $json_customer[] = array('label'=>$value['customer_name'],'value'=>$value['customer_id']);

        }

         }else{

           $json_customer[] = 'No Record found';

        }

        echo json_encode($json_customer);

    }

    //csv excel 

     public function exportinvocsv() {

        // file name 

        $this->load->model('Invoices');

        $filename = 'sale_' . date('Ymd') . '.csv';

        header("Content-Description: File Transfer");

        header("Content-Disposition: attachment; filename=$filename");

        header("Content-Type: application/csv; ");

        // get data 

        $invoicedata = $this->Invoices->invoice_csv_file();

        // file creation 

        $file = fopen('php://output', 'w');



        $header = array('invoice_no', 'invoice_id', 'customer_name', 'date', 'total_amount');

        fputcsv($file, $header);

        foreach ($invoicedata as $line) {

            fputcsv($file, $line);

        }

        fclose($file);

        exit;

    }





    public function gui_pos(){

    //      ini_set('display_errors', 1);
    // ini_set('display_startup_errors', 1);
    // error_reporting(E_ALL);

           $this->load->model('Invoices');

           $this->load->model('Web_settings');

            $taxfield = $this->db->select('tax_name,default_value')

                ->from('tax_settings')

                ->get()

                ->result_array();

                $tablecolumn = $this->db->list_fields('tax_collection');

                $num_column = count($tablecolumn)-4;

            $data['title'] = display('gui_pos');

            $saveid=$this->session->userdata('user_id');

            $walking_customer      = $this->Invoices->walking_customer();

            $data['customer_id']   = $walking_customer[0]['customer_id'];

            $data['customer_name'] = $walking_customer[0]['customer_name'];

           $data['categorylist']  = $this->Invoices->category_dropdown();
            //$data['categorylist']  = array();

            $customer_details      = $this->Invoices->pos_customer_setup();

            $data['customerlist']  = $this->Invoices->customer_dropdown();

            $currency_details      = $this->Web_settings->retrieve_setting_editdata();

            $data['customer_name'] = $customer_details[0]['customer_name'];

            $data['customer_id']   = $customer_details[0]['customer_id'];

            $data['itemlist']      =  $this->Invoices->allproduct();

            $data['discount_type'] = $currency_details[0]['discount_type'];

            $data['position']       = $currency_details[0]['currency_position'];

            $data['currency']       = $currency_details[0]['currency'];

            $data['taxes']         = $taxfield;

            $data['taxnumber']     = $num_column;

            $data['todays_invoice']= $this->Invoices->todays_invoice();

            $content  = $this->parser->parse('invoice/gui_pos_invoice', $data, true);

     $this->template->full_admin_html_view($content);  

        }



        //gui pos invoice 

        public function gui_pos_invoice() {

        $CI = & get_instance();

        $CI->auth->check_admin_auth();

        $CI->load->model('Invoices');

        $CI->load->model('Web_settings');

        //$product_id = $this->input->post('product_id',TRUE);
        $product_id = $this->input->post('product_id',TRUE);



        $product_details = $CI->Invoices->pos_invoice_setup($product_id);
     //  print_r($product_details);
        $currency_details = $CI->Web_settings->retrieve_setting_editdata();

        $taxfield = $CI->db->select('tax_name,default_value')

                ->from('tax_settings')

                ->get()

                ->result_array();

           $prinfo = $this->db->select('*')->from('product_information')->where('product_id',$product_id)->get()->result_array();



        $tr = " ";

        if (!empty($product_details)) {

            $product_id = $this->generator(5);

            $serialdata =explode(',', $product_details->serial_no);

            if($product_details->total_product > 0){

              $qty = 1;

            }else{

                $qty = 1;

            }



        $html = "";

        if (empty($serialdata)) {

            $html .="No Serial Found !";

        }else{

            // Select option created for product

            $html .="<select name=\"serial_no[]\"   class=\"serial_no_1 form-control\" id=\"serial_no_".$product_details->product_id."\">";

                $html .= "<option value=''>".display('select_one')."</option>";

                foreach ($serialdata as $serial) {

                    $html .="<option value=".$serial.">".$serial."</option>";

                }   

            $html .="</select>";

        }

            

            $tr .= "<tr id=\"row_" . $product_details->product_id . "\">

                        <td class=\"\" style=\"width:220px\">

                            

                            <input type=\"text\" name=\"product_name\" onkeypress=\"invoice_productList('" . $product_details->product_id . "');\" class=\"form-control productSelection \" value='" . $product_details->product_name . "- (" . $product_details->product_model . ")" . "' placeholder='" . display('product_name') . "' required=\"\"  tabindex=\"\" readonly>



                            <input type=\"hidden\" class=\"form-control autocomplete_hidden_value product_id_" . $product_details->product_id . "\" name=\"product_id[]\" id=\"SchoolHiddenId_" . $product_details->product_id . "\" value = \"$product_details->product_id\"/>

                        </td>

                        <td>".$html."</td>

                        <td>

                            <input type=\"text\" name=\"available_quantity[]\" class=\"form-control text-right available_quantity_" . $product_details->product_id . "\" value='" . $product_details->total_product . "' readonly=\"\" id=\"available_quantity_" . $product_details->product_id . "\"/>

                        </td>

                        <td>

                            <input type=\"text\" name=\"product_quantity[]\" onkeyup=\"quantity_calculate('" . $product_details->product_id . "');\" onchange=\"quantity_calculate('" . $product_details->product_id . "');\" class=\"total_qntt_" . $product_details->product_id . " form-control text-right\" id=\"total_qntt_" . $product_details->product_id . "\" placeholder=\"0.00\" min=\"0\" value='" . $qty . "' required=\"required\"/>

                        </td>

                        <td style=\"width:85px\">

                            <input type=\"text\" name=\"product_rate[]\" onkeyup=\"quantity_calculate('" . $product_details->product_id . "');\" onchange=\"quantity_calculate('" . $product_details->product_id . "');\" value='" . $product_details->price . "' id=\"price_item_" . $product_details->product_id . "\" class=\"price_item1 form-control text-right\" required placeholder=\"0.00\" min=\"0\"/>

                        </td>



                        <td class=\"\">

                            <input type=\"text\" name=\"discount[]\" onkeyup=\"quantity_calculate('" . $product_details->product_id . "');\" onchange=\"quantity_calculate('" . $product_details->product_id . "');\" id=\"discount_" . $product_details->product_id . "\" class=\"form-control text-right\" placeholder=\"0.00\" min=\"0\"/>



                            <input type=\"hidden\" value=" . $currency_details[0]['discount_type'] . " name=\"discount_type\" id=\"discount_type_" . $product_details->product_id . "\">

                        </td>



                        <td class=\"text-right\" style=\"width:100px\">

                            <input class=\"total_price form-control text-right\" type=\"text\" name=\"total_price[]\" id=\"total_price_" . $product_details->product_id . "\" value='" . $product_details->price . "' tabindex=\"-1\" readonly=\"readonly\"/>

                        </td>



                        <td>";

                            $sl=0;

                        foreach ($taxfield as $taxes) {

                            $txs = 'tax'.$sl;

                           $tr .= "<input type=\"hidden\" id=\"total_tax".$sl."_" . $product_details->product_id . "\" class=\"total_tax".$sl."_" . $product_details->product_id . "\" value='" . $prinfo[0][$txs] . "'/>

                            <input type=\"hidden\" id=\"all_tax".$sl."_" . $product_details->product_id . "\" class=\" total_tax".$sl."\" value='" . $prinfo[0][$txs]*$product_details->price . "' name=\"tax[]\"/>";  

                       $sl++; }

                           $tr.="<input type=\"hidden\" id=\"total_discount_" . $product_details->product_id . "\" />

                            <input type=\"hidden\" id=\"all_discount_" . $product_details->product_id . "\" class=\"total_discount dppr\"/>

                            <a style=\"text-align: right;\" class=\"btn btn-danger btn-xs\" href=\"#\"  onclick=\"deleteRow(this)\">" . '<i class="fa fa-close"></i>' . "</a>

                             <a style=\"text-align: right;\" class=\"btn btn-success btn-xs\" href=\"#\"  onclick=\"detailsmodal('".$product_details->product_name."','".$product_details->total_product."','".$product_details->product_model."','".$product_details->unit."','".$product_details->price."','".$product_details->image."')\">" . '<i class="fa fa-eye"></i>' . "</a>

                        </td>

                    </tr>";

            echo $tr;

        } else {

            return false;

        }

    }



        public function getitemlist(){

             $this->load->model('Invoices');

                $prod=$this->input->post('product_name',TRUE);

                $catid=$this->input->post('category_id',TRUE);

                $getproduct = $this->Invoices->searchprod($catid,$prod);

                if(!empty($getproduct)){

                $data['itemlist']=$getproduct;

                $this->load->view('invoice/getproductlist', $data);  

                }

                else{

                    $title['title'] = 'Product Not found';

                    $this->load->view('invoice/productnot_found', $title);

                    }

        }
        public function trucking_details_data($purchase_id) {

            $CI = & get_instance();
            $CI->auth->check_admin_auth();
            $CI->load->library('linvoice');
            $content = $CI->linvoice->trucking_details_data($purchase_id);
            $this->template->full_admin_html_view($content);
    
    
            // $CI = & get_instance();
            // $CI->auth->check_admin_auth();
            // $CI->load->library('linvoice');
            // $data=array();
           // echo $content = $CI->linvoice->invoice_add_form();
            //$content = $this->load->view('purchase/trucking_invoice_html', $data, true);
            //$content='';
            //$this->template->full_admin_html_view($content);
        }

    
    public function packing_ins(){

        $purchase_id  = date('YmdHis');

        $data = array(
            'expense_packing_id'        => $purchase_id,
            'create_by'       =>  $this->session->userdata('user_id'),
            'invoice_no'          => $this->input->post('invoice_no',TRUE),
            'invoice_date'        => $this->input->post('invoice_date',TRUE),
            'gross_weight' => $this->input->post('gross_weight',TRUE),
            'thickness' => $this->input->post('thickness',TRUE),
            'description'=> $this->input->post('description',TRUE),
            'product_id' => $this->input->post('product_id',TRUE),
            // 'grand_total_amount' => $this->input->post('grand_total_price',TRUE),
            'container_no'     => $this->input->post('container_no',TRUE),
            'grand_total_amount'      => $this->input->post('total',TRUE),
            'status'             => 1,
        );

        $content = $this->load->view('invoice/add_packing_list', $data, true);

        $this->template->full_admin_html_view($content);

        $this->db->insert('sale_packing_list', $data);

        $this->session->set_userdata(array('message' => display('successfully_added')));

        redirect('Cinvoice/manage_packing_list');


        // print_r($data); exit();
    }



    public function performer_ins(){
          
        $CI = & get_instance();
        $CI->auth->check_admin_auth();
        $CI->load->library('linvoice');
        $data=array();
        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->library('form_validation');
     
      // print_r($_POST);
    
         $purchase_id = date('YmdHis');
         $chalan_no=$this->input->post('chalan_no');
       // echo $chalan_no;
        $postData = $this->input->post();
       // print_r($postData);
       // foreach ($post as $id)
       //  {
      //   $this->model_admin->delete_admin_user($id);
      //   }
         $data = array(
                    'purchase_id' => $purchase_id,
                    'chalan_no'=>$this->input->post('chalan_no'),
                    'purchase_date'=>$this->input->post('purchase_date'),
                    'billing_address'=> $this->input->post('billing_address'),
                    'customer_id'=>$this->input->post('customer_id'),
                    'pre_carriage'=>$this->input->post('pre_carriage'),
                    'receipt'=>$this->input->post('receipt'),
                    'remarks'=>$this->input->post('remarks'),
                    'tax_details'=>$this->input->post('tax_details'),
               'gtotal'=>$this->input->post('gtotal'),
               'customer_gtotal'  =>$this->input->post('customer_gtotal'),
                    'country_goods'=>$this->input->post('country_goods'),
                    'country_destination'=>$this->input->post('country_destination'),
                    'loading'=>$this->input->post('loading'),
                    'discharge'=>$this->input->post('discharge'),
                    'terms_payment'=>$this->input->post('terms_payment'),
                    'description_goods'=>$this->input->post('description_goods'),
                    'total'=>$this->input->post('total'),
                    'ac_details'=>$this->input->post('ac_details'),
                    'sales_by'        => $this->session->userdata('user_id')
                 );
            //    $content = $this->load->view('invoice/profarma_invoice', $data, true);

             //   $this->template->full_admin_html_view($content);


                $purchase_id_1 = $this->db->where('chalan_no',$this->input->post('chalan_no',TRUE));
                $q=$this->db->get('profarma_invoice');
            
                $row = $q->row_array();
            if(!empty($row['purchase_id'])){
                $this->session->set_userdata("profarma_1",$row['purchase_id']);
           $this->db->where('purchase_id', $this->session->userdata("profarma_1"));
          $this->db->delete('profarma_invoice');
        
                $this->db->insert('profarma_invoice', $data);
             
           }   
            else{
            $this->db->insert('profarma_invoice', $data);
      
          
            }
            $purchase_id = $this->db->select('purchase_id')->from('profarma_invoice')->where('chalan_no',$this->input->post('chalan_no',TRUE))->get()->row()->purchase_id;
              $this->session->set_userdata("profarma_2",$purchase_id);
                  
               
                 $avl = $this->input->post('available_quantity');
                 $p_id = $this->input->post('product_id');
                 // print_r($p_id); exit();
                 $p_id = $this->input->post('product_id');
                 $quantity = $this->input->post('product_quantity');
                 $rate = $this->input->post('product_rate');
                 $t_price = $this->input->post('total_price');
                 $p_name= $this->input->post('product_name');
                 $rowCount = count($this->input->post('product_id',TRUE));
                
                 for ($i = 0; $i < $rowCount; $i++) {
                    $product_name = $p_name[$i];
                    $product_quantity = $quantity[$i];
                    $product_rate = $rate[$i];
                    $product_id = $p_id[$i];
                    $total_price = $t_price[$i];
                    $data1 = array(
                        'purchase_detail_id' => $this->generator(15),
                        'purchase_id'        => $this->session->userdata("profarma_2"),
                        'product_id'         => $product_id,
                        // 'product_name'         => $product_name,
                        'quantity'           => $product_quantity,
                        'rate'               => $product_rate,
                        'total_amount'       => $total_price,
                        'create_by'          =>  $this->session->userdata('user_id'),
                        'status'             => 1
                    );
                    // print_r($data1); exit();

                  // echo json_encode($data1);
                  $this->db->where('purchase_id', $this->session->userdata("profarma_1"));

                  $this->db->delete('profarma_invoice_details');
                
                  $this->db->insert('profarma_invoice_details', $data1);
                
                    
                }
                $final_return = $purchase_id."/".$chalan_no;
                echo json_encode($final_return);
                  //  $this->session->set_userdata(array('perfarma_invoice_id' => $purchase_id));


                 //   redirect('Cinvoice/profarma_invoice');
                    
            

     }





     public function instant_customer(){
        $CI = & get_instance();
        $CI->auth->check_admin_auth();
        $CI->load->model('Customers');
    $data = array(
        'customer_name'   => $this->input->post('customer_name',TRUE),
        'customer_address'=> $this->input->post('address',TRUE),
        'address2'        => $this->input->post('address2',TRUE),
        'customer_mobile' => $this->input->post('mobile',TRUE),
        'currency_type'   => $this->input->post('currency1',TRUE),
        'phone'           => $this->input->post('phone',TRUE),
        'fax'             => $this->input->post('fax',TRUE),
        'contact'         => $this->input->post('contact',TRUE),
        'city'            => $this->input->post('city',TRUE),
        'state'           => $this->input->post('state',TRUE),
        'zip'             => $this->input->post('zip',TRUE),
        'country'         => $this->input->post('country',TRUE),
        'email_address'   => $this->input->post('emailaddress',TRUE),
        'customer_email'  => $this->input->post('email',TRUE),
        'status'          => 2,
        'create_by'       => $this->session->userdata('user_id'),
  );
    $result = $this->Customers->customer_entry($data);
  
    if ($result) {
    $customer_id = $this->db->insert_id();
    $vouchar_no = $this->auth->generator(10);
    //Customer  basic information adding.
    $coa = $this->Customers->headcode();
        if($coa->HeadCode!=NULL){
            $headcode=$coa->HeadCode+1;
        }else{
            $headcode="102030001";
        }
$c_acc=$customer_id.'-'.$this->input->post('customer_name',TRUE);
$createby=$this->session->userdata('user_id');
$createdate=date('Y-m-d H:i:s');
$customer_coa = [
         'HeadCode'         => $headcode,
         'HeadName'         => $c_acc,
         'PHeadName'        => 'Customer Receivable',
         'HeadLevel'        => '4',
         'IsActive'         => '1',
         'IsTransaction'    => '1',
         'IsGL'             => '0',
         'HeadType'         => 'A',
         'IsBudget'         => '0',
         'IsDepreciation'   => '0',
         'customer_id'      => $customer_id,
         'DepreciationRate' => '0',
         'CreateBy'         => $createby,
         'CreateDate'       => $createdate,
    ];
        //Previous balance adding -> Sending to customer model to adjust the data.
        $this->db->insert('acc_coa',$customer_coa);
        $this->Customers->previous_balance_add($this->input->post('previous_balance',TRUE), $customer_id);
    //     $data['status']        = true;
    //     $data['message']       = display('save_successfully');
    //     $data['customer_id']   = $customer_id;
    //     $data['customer_name'] = $data['customer_name'];
    // } else {
    //     $data['status'] = false;
    //     $data['error_message'] = display('please_try_again');
    // }
}
$all_customer = $this->Customers->all_customer();
    echo json_encode($all_customer);
    }

public function newsale_with_attachment_stand($invoiceid)
  {

    $sql='select c.* from user_login  u
    join 
    company_information c
    on c.company_id=u.cid
     where u.user_id='.$_SESSION['user_id'];
    $query=$this->db->query($sql);
    $data['company_info']=$query->result_array();

        $sql='SELECT b.* from invoice a JOIN customer_information b on b.customer_id=a.customer_id
 WHERE a.invoice_id='.$invoiceid;
    $query=$this->db->query($sql);
    $data['customer_info']=$query->result_array();

      $sql='select b.* from invoice_details a join product_information b on a.product_id=b.product_id
 where a.invoice_id='.$invoiceid;
    $query=$this->db->query($sql);
    $data['product_info']=$query->result_array();

 $sql='select * from invoice_details where invoice_id='.$invoiceid;
    $query=$this->db->query($sql);
    $data['invoice_details']=$query->result_array();
$sql='select * from invoice where invoice_id='.$invoiceid;
    $query=$this->db->query($sql);
    $data['invoice']=$query->result_array();

    $content = $this->load->view('pdf_attach_mail/new_sale', $data, true);
  
   
  }

  public function newsale_with_attachment_cus($invoiceid)
  {
   
    $sql='select c.* from user_login  u
    join 
    company_information c
    on c.company_id=u.cid
     where u.user_id='.$_SESSION['user_id'];
    $query=$this->db->query($sql);
    $data['company_info']=$query->result_array();

        $sql='SELECT b.* from invoice a JOIN customer_information b on b.customer_id=a.customer_id
 WHERE a.invoice_id='.$invoiceid;
    $query=$this->db->query($sql);
    $data['customer_info']=$query->result_array();

      $sql='select b.* from invoice_details a join product_information b on a.product_id=b.product_id
 where a.invoice_id='.$invoiceid;
    $query=$this->db->query($sql);
    $data['product_info']=$query->result_array();

 $sql='select * from invoice_details where invoice_id='.$invoiceid;
    $query=$this->db->query($sql);
    $data['invoice_details']=$query->result_array();
$sql='select * from invoice where invoice_id='.$invoiceid;
    $query=$this->db->query($sql);
    $data['invoice']=$query->result_array();
    $sql='select * from invoice_email where uid='.$_SESSION['user_id'];;
    $query=$this->db->query($sql);

    $data['mail']= $query->result_array();

    $content = $this->load->view('pdf_attach_mail/new_sale', $data, true);
  
   

  }


  /////////////////////proforma//////////////////////////////////

  public function proforma_with_attachment_stand($invoiceid)
  {
  
  
    $sql='select c.* from user_login  u
    join 
    company_information c
    on c.company_id=u.cid
     where u.user_id='.$_SESSION['user_id'];
    $query=$this->db->query($sql);
    $data['company_info']=$query->result_array();

        $sql='SELECT b.* from profarma_invoice a JOIN customer_information b on b.customer_id=a.customer_id
 WHERE a.purchase_id='.$invoiceid;
    $query=$this->db->query($sql);
    $data['customer_info']=$query->result_array();

      $sql='select a.* from profarma_invoice_details a join product_information b on a.product_id=b.product_id
 where a.purchase_id='.$invoiceid;
    $query=$this->db->query($sql);
    $data['product_info']=$query->result_array();

 $sql='select * from profarma_invoice_details where purchase_id='.$invoiceid;
    $query=$this->db->query($sql);
    $data['invoice_details']=$query->result_array();
$sql='select * from profarma_invoice where purchase_id='.$invoiceid;
    $query=$this->db->query($sql);
    $data['invoice']=$query->result_array();

$content = $this->load->view('pdf_attach_mail/profarma', $data, true);
  }



  public function proforma_with_attachment_cus($invoiceid)
  {
      $CA = & get_instance();
      $CI = & get_instance();
      $CA->load->model('invoice_design');
      $CA->load->model('Web_settings');
      $dataw = $CA->invoice_design->retrieve_data();
      $currency_details = $CI->Web_settings->retrieve_setting_editdata();
      $curn_info_default = $CI->db->select('*')->from('currency_tbl')->where('icon',$currency_details[0]['currency'])->get()->result_array();
       // print_r($curn_info_default); die();
    $sql='select c.* from user_login  u
    join
    company_information c
    on c.company_id=u.cid
     where u.user_id='.$_SESSION['user_id'];
    $query=$this->db->query($sql);
    $data['company_info']=$query->result_array();
        $sql='SELECT * from profarma_invoice a JOIN customer_information b on b.customer_id=a.customer_id
 WHERE a.purchase_id='.$invoiceid;
    $query=$this->db->query($sql);
    $data['customer_info']=$query->result_array();
      // print_r( $data['customer_info']); die();
      $sql='select * from profarma_invoice_details a join product_information b on a.product_id=b.product_id
 where a.purchase_id='.$invoiceid;
    $query=$this->db->query($sql);
    $data['product_info']=$query->result_array();
   // print_r( $data['product_info']); die();
 $sql='select * from profarma_invoice_details where purchase_id='.$invoiceid;
    $query=$this->db->query($sql);
    $data['invoice_details']=$query->result_array();
$sql='select * from profarma_invoice where purchase_id='.$invoiceid;
    $query=$this->db->query($sql);
    $data['invoice']=$query->result_array();
    // print_r($data['invoice']);
    $sql='select * from invoice_email where uid='.$_SESSION['user_id'];;
    $query=$this->db->query($sql);
    $data['mail']= $query->result_array();
    $data['template'] = $dataw[0]['template'];
    $data['curn_info_default'] = $curn_info_default[0]['currency_name'];
    $data['currency'] = $currency_details;
    // print_r($data['currency']); die();
     // print_r($data); die();
    $content = $this->load->view('pdf_attach_mail/profarma', $data, true);
  }

  /////////////////////packing//////////////////////////////////

  public function packing_with_attachment_stand($invoiceid)
  {
    
$sql='select c.* from user_login  u
    join 
    company_information c
    on c.company_id=u.cid
     where u.user_id='.$_SESSION['user_id'];
    $query=$this->db->query($sql);
    $data['company_info']=$query->result_array();

    

      $sql='select b.* from sale_packing_list_detail a join product_information b on a.product_id=b.product_id
 where a.expense_packing_id='.$invoiceid;
    $query=$this->db->query($sql);
    $data['product_info']=$query->result_array();

 $sql='select * from sale_packing_list_detail where expense_packing_id='.$invoiceid;
    $query=$this->db->query($sql);
    $data['invoice_details']=$query->result_array();
$sql='select * from sale_packing_list where expense_packing_id='.$invoiceid;
    $query=$this->db->query($sql);
    $data['invoice']=$query->result_array();

    $content = $this->load->view('pdf_attach_mail/packing', $data, true);


  } 

  public function packing_with_attachment_cus($invoiceid)
  {
    $CA = & get_instance();
    $CI = & get_instance();
    $CA->load->model('invoice_design');
    // $CA->load->model('Web_settings');
      $dataw = $CA->invoice_design->retrieve_data();
      // $currency_details = $CI->Web_settings->retrieve_setting_editdata();
      // $curn_info_default = $CI->db->select('*')->from('currency_tbl')->where('icon',$currency_details[0]['currency'])->get()->result_array();
  $sql='select c.* from user_login  u
    join
    company_information c
    on c.company_id=u.cid
     where u.user_id='.$_SESSION['user_id'];
    $query=$this->db->query($sql);
    $data['company_info']=$query->result_array();
     // print_r($data['company_info']); die();
    $sql='select * from sale_packing_list_detail a join product_information b on a.product_id=b.product_id
      where a.expense_packing_id='.$invoiceid;
    $query=$this->db->query($sql);
    // echo $this->db->last_query(); die();
    $data['product_info']=$query->result_array();
    // print_r($data['product_info']); die();
    $sql='select * from sale_packing_list_detail where expense_packing_id='.$invoiceid;
    $query=$this->db->query($sql);
    $data['invoice_details']=$query->result_array();
    $sql='select * from sale_packing_list where expense_packing_id='.$invoiceid;
    $query=$this->db->query($sql);
    $data['invoice']=$query->result_array();
    $sql='SELECT * FROM sale_packing_list s JOIN invoice i JOIN customer_information c on c.customer_id=i.customer_id where s.expense_packing_id='.$invoiceid;
    $query=$this->db->query($sql);
    $data['customer_info']=$query->result_array();
    // echo '<pre>';
    // print_r($data['customer_info'][0]['customer_email']); die();
    // echo '</pre>';
     // print_r($data['invoice']);
    $sql='select * from invoice_email where uid='.$_SESSION['user_id'];;
    $query=$this->db->query($sql);
    $data['mail']= $query->result_array();
     $data['template'] = $dataw[0]['template'];
    // $data['curn_info_default'] = $curn_info_default[0]['currency_name'];
    // $data['currency'] = $currency_details;
    $content = $this->load->view('pdf_attach_mail/packing', $data, true);
  }
  /////////////////////Ocean//////////////////////////////////

  public function ocean_with_attachment_stand($invoiceid)
  {
   
$sql='select c.* from user_login  u
    join 
    company_information c
    on c.company_id=u.cid
     where u.user_id='.$_SESSION['user_id'];
    $query=$this->db->query($sql);
    $data['company_info']=$query->result_array();

         $sql='SELECT b.* from ocean_export_tracking a JOIN supplier_information b on b.supplier_id=a.supplier_id
 WHERE a.ocean_export_tracking_id='.$invoiceid;
    $query=$this->db->query($sql);
    $data['supplier_info']=$query->result_array();

  

 
$sql='select * from ocean_export_tracking where ocean_export_tracking_id='.$invoiceid;
    $query=$this->db->query($sql);
    $data['ocean']=$query->result_array();
$content = $this->load->view('pdf_attach_mail/ocean', $data, true);
   

  }

  public function ocean_with_attachment_cus($invoiceid)
  {
    $CA = & get_instance();
    $CI = & get_instance();
    $CA->load->model('invoice_design');
    $dataw = $CA->invoice_design->retrieve_data();
   $sql='select c.* from user_login  u join company_information c on c.company_id=u.cid where u.user_id='.$_SESSION['user_id'];
    $query=$this->db->query($sql);
    $data['company_info']=$query->result_array();
   $sql='select b.* from ocean_export_tracking a join supplier_information b on b.supplier_id=a.supplier_id WHERE a.ocean_export_tracking_id='.$invoiceid;
    $query=$this->db->query($sql);
    $data['supplier_info']=$query->result_array();
   $sql='select * from ocean_export_tracking where ocean_export_tracking_id='.$invoiceid;
    $query=$this->db->query($sql);
    $data['ocean']=$query->result_array();
    // print_r($data['ocean']); die();
//    echo($data['ocean'][0]['consignee']); die();
    $customer_name = $CI->db->select('*')->from('customer_information')->where('customer_id', $data['ocean'][0]['consignee'])->get()->result_array();
    $data['customername']= $customer_name[0]['customer_name'];
    // $data = array(
    //     'customername' =>  $customer_name[0]['customer_name']
    // );
    // print_r($data['customername']); die();
    $sql='SELECT c.* from ocean_export_tracking i JOIN supplier_information c on c.supplier_id=i.supplier_id WHERE i.ocean_export_tracking_id ='.$invoiceid ;
    $query=$this->db->query($sql);
    $data['customer_info']=$query->result_array();
    // echo '<pre>';
    // print_r($data['customer_info'][0]['email_address']); die();
    // echo '</pre>';
   $sql='select * from invoice_email where uid='.$_SESSION['user_id'];;
    $query=$this->db->query($sql);
    $data['mail']= $query->result_array();
    $data['template'] = $dataw[0]['template'];
    $content = $this->load->view('pdf_attach_mail/ocean_export', $data, true);
}
  /////////////////////Trucking//////////////////////////////////

  public function trucking_with_attachment_stand($invoiceid)
  {
  
$sql='select c.* from user_login  u
    join 
    company_information c
    on c.company_id=u.cid
     where u.user_id='.$_SESSION['user_id'];
    $query=$this->db->query($sql);
    $data['company_info']=$query->result_array();

     $sql=' SELECT b.* FROM `sale_trucking` a join customer_information b on b.customer_id=a.bill_to where trucking_id='.$invoiceid;
    $query=$this->db->query($sql);
    $data['customer_info']=$query->result_array();  

 

  $sql='select * from sale_trucking_details where sale_trucking_id='.$invoiceid;
    $query=$this->db->query($sql);
    $data['sale_trucking_details']=$query->result_array();
$sql='select * from sale_trucking where trucking_id='.$invoiceid;
    $query=$this->db->query($sql);
    $data['sale_trucking']=$query->result_array();
    $sql='select * from sale_trucking_details where sale_trucking_id='.$invoiceid;
    $query=$this->db->query($sql);
    $data['sale_trucking_details']=$query->result_array();
$sql='select * from sale_trucking where trucking_id='.$invoiceid;
    $query=$this->db->query($sql);
    $data['sale_trucking']=$query->result_array();

$content = $this->load->view('pdf_attach_mail/trucking', $data, true);
  }

  public function trucking_with_attachment_cus($invoiceid)
  {
    $CA = & get_instance();
    $CI = & get_instance();
    $CA->load->model('invoice_design');
    $CI->load->model('Web_settings');
    $dataw = $CA->invoice_design->retrieve_data();
    $currency_details = $CI->Web_settings->retrieve_setting_editdata();
    $curn_info_default = $CI->db->select('*')->from('currency_tbl')->where('icon',$currency_details[0]['currency'])->get()->result_array();
   $sql='select c.* from user_login  u
    join
    company_information c
    on c.company_id=u.cid
     where u.user_id='.$_SESSION['user_id'];
    $query=$this->db->query($sql);
    $data['company_info']=$query->result_array();
   $sql=' SELECT * FROM `sale_trucking` a join customer_information b on b.customer_id=a.bill_to where trucking_id='.$invoiceid;
    $query=$this->db->query($sql);
    $data['customer_info']=$query->result_array();
   $sql='select * from sale_trucking_details where sale_trucking_id='.$invoiceid;
    $query=$this->db->query($sql);
    $data['sale_trucking_details']=$query->result_array();
    // print_r($data['sale_trucking_details']);
   $sql='select * from sale_trucking where trucking_id='.$invoiceid;
    $query=$this->db->query($sql);
    $data['sale_trucking']=$query->result_array();
    $sql='select * from invoice_email where uid='.$_SESSION['user_id'];;
    $query=$this->db->query($sql);
    $data['mail']= $query->result_array();
    $data['template'] = $dataw[0]['template'];
    $data['curn_info_default'] = $curn_info_default[0]['currency_name'];
    $data['currency'] = $currency_details;
// print_r($data['curn_info_default']);
// exit;
$content = $this->load->view('pdf_attach_mail/trucking', $data, true);
  }
}







