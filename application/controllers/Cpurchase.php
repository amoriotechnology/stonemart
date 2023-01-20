    <?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Cpurchase extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->db->query('SET SESSION sql_mode = ""');
            $this->load->model(array(
            'accounts_model','Web_settings'
        )); 
    }


public function packing_update_form($purchase_id)
{
$CI = & get_instance();
        $CI->auth->check_admin_auth();
        $CI->load->library('lpurchase');
        $content = $CI->lpurchase->packing_update_form($purchase_id);
        $this->template->full_admin_html_view($content);
}
    public function index() {
       
        $CI = & get_instance();
        $CI->auth->check_admin_auth();
        $CI->load->library('lpurchase');
        $content = $CI->lpurchase->purchase_add_form1();
        $this->template->full_admin_html_view($content);
    }


    public function add_packing_list(){
        $CI = & get_instance();
        $CI->auth->check_admin_auth();
        $CI->load->library('lpurchase');
        $content = $CI->lpurchase->packing_add_form();
        $this->template->full_admin_html_view($content);
    }

    public function manage_packing_list(){

        $this->session->unset_userdata('expense_packing_id');

        $date = $this->input->post("daterange");
        $CI = & get_instance();
        $CI->load->model('Purchases');
        $CI->auth->check_admin_auth();
        $CI->load->library('lpurchase');
        $content1 = $CI->lpurchase->packing_list();
        $expense = $CI->Purchases->packing_list($date);

     
 
        $data = array(
           

            'invoice'         =>  $content1,

            'expense' => $expense


        );
        $content = $this->load->view('purchase/packing_list', $data, true);
        $this->template->full_admin_html_view($content);
    }


    //Manage purchase
    public function manage_purchase() {
         $this->session->unset_userdata('newexpenseid');
        $date = $this->input->post("daterange");
        $CI = & get_instance();
        $CI->load->model('Purchases');
        $this->load->library('lpurchase');
    
        $content1 = $this->lpurchase->purchase_list();
        $expense = $CI->Purchases->newexpense($date);

        $currency_details = $CI->Web_settings->retrieve_setting_editdata();
 
        $data = array(
            'currency' =>$currency_details[0]['currency'],

            'invoice'         =>  $content1,

            'expense' => $expense


        );
        $content = $this->load->view('purchase/purchase', $data, true);
        $this->template->full_admin_html_view($content);
      //  $this->template->full_admin_html_view($content);
    }

     public function manage_purchase_order() {
        $this->session->unset_userdata('purchase_orderid');
        $date = $this->input->post("daterange");
        $this->load->library('lpurchase');
        $CI = & get_instance();
        $CI->load->model('Purchases');
     //   $content1 = $this->lpurchase->purchase_order_list();
        $expense = $CI->Purchases->purchase_order($date);

        $currency_details = $CI->Web_settings->retrieve_setting_editdata();
 
        $data = array(
            'currency' =>$currency_details[0]['currency'],

         //   'invoice'         =>  $content1,

            'expense' => $expense


        );
     
        $content = $this->load->view('purchase/purchase_order_list', $data, true);
        $this->template->full_admin_html_view($content);
    }

    public function manage_ocean_import_tracking() {
        $this->session->unset_userdata('expenseoceanid');

        $this->load->library('lpurchase');
        $content = $this->lpurchase->ocean_import_list();
        $this->template->full_admin_html_view($content);
    
    }
    
    public function get_po_details(){
        $this->load->model('Purchases');
        $po_num = $this->input->post('po');
        $data = $this->Purchases->get_po_details($po_num);
        
        echo json_encode($data);


    }
    public function add_csv_purchase()
    {
         $CI = & get_instance();
         $data = array(
             'title' => display('add_csv_product')
         );
         $content = $CI->parser->parse('purchase/add_purchase_product', $data, true);
         $this->template->full_admin_html_view($content);
    }
    public function uploadPurchasecsv()
    {
         $CI = & get_instance();
         $this->load->model('Purchases');
         $data['purchaseOrder'] = $this->Purchases->get_expense_product();
         // print_r($data['purchaseOrder']); die();
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
                     $purchase_order_id  = date('YmdHis');
                     $purchase_id = date('YmdHis');
                     $purchase_data = array(
                         'create_by'     =>  $this->session->userdata('user_id'),
                         'purchase_order_id' => $purchase_order_id,
                         'purchase_date'=>$row['purchase_date'],
                         'ship_to'=>$row['ship_to'],
                         'created_by'=>$row['created_by'],
                         'payment_terms'=>$row['payment_terms'],
                         'shipment_terms'=>$row['shipment_terms'],
                         'est_ship_date'=>$row['est_ship_date'],
                         'message_invoice'=>$row['message_invoice'],
                     );
                      // print_r($purchase_data);die();
                     $this->db->insert('purchase_order', $purchase_data);
                     $data_invoice = array(
                         'create_by'     =>  $this->session->userdata('user_id'),
                         'purchase_id' => $purchase_id,
                         'product_name'=>$row['product_name'],
                         'slabs'=>$row['slabs'],
                         'quantity'=>$row['quantity'],
                         'rate' => $row['rate'],
                     );
                     // print_r($data_invoice);die();
                     $this->db->insert('purchase_order_details', $data_invoice);
                 }
                 $data=array();
                 $data=array(
                     'purchase_data' =>$purchase_data
                 );
                 $content = $this->load->view('purchase/add_purchase_product', $data, true);
                 $this->template->full_admin_html_view($content);
                 $this->session->set_userdata(array('message'=>display('successfully_added')));
                redirect(base_url('Cpurchase/manage_purchase_order'));
                 //echo "<pre>"; print_r($insert_data);
             }else {
                 $this->session->set_userdata(array('error_message'=>'Please Import Only Csv File'));
                 redirect(base_url('Cpurchase/add_csv_purchase'));
             }
             $this->session->unset_userdata('file_path');
             unlink($file_path);
         }
     }
    }

     public function manage_trucking() {
        $this->load->library('lpurchase');
        $content = $this->lpurchase->trucking_list();
        $this->template->full_admin_html_view($content);
    }
    public function add_csv_product()
    {
        $CI = & get_instance();
        $data = array(
            'title' => display('add_csv_product')
        );
        $content = $CI->parser->parse('purchase/add_expense_product', $data, true);
        $this->template->full_admin_html_view($content);
    }
    public function uploadExpensecsv()
    {
        $CI = & get_instance();
        $this->load->model('Purchases');
        $data['productdetails'] = $this->Purchases->get_expense_product();
        // print_r($data); die();
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
                     $expense_data = array(
                        'create_by'     =>  $this->session->userdata('user_id'),
                        'purchase_id' => $purchase_id,
                        'purchase_date'=>$row['purchase_date'],
                        'payment_due_date'=>$row['payment_due_date'],
                        'chalan_no'=>$row['chalan_no'],
                        'description'=>$row['description'],
                        'remarks'=>$row['remarks'],
                    );
                    $this->db->insert('product_purchase', $expense_data);
                    $data_invoice = array(
                        'create_by'     =>  $this->session->userdata('user_id'),
                        'purchase_id' => $purchase_id,
                        'product_name' => $row['product_name'],
                        'quantity' => $row['quantity'],
                        'rate' => $row['rate'],
                    );
                    // print_r($data_invoice);die();
                    $this->db->insert('product_purchase_details', $data_invoice);
                }
                $data=array();
                $data=array(
                    'expense_data' =>$expense_data
                );
                $content = $this->load->view('purchase/add_expense_product', $data, true);
                $this->template->full_admin_html_view($content);
                $this->session->set_userdata(array('message'=>display('successfully_added')));
               redirect(base_url('Cpurchase/manage_purchase'));
                //echo "<pre>"; print_r($insert_data);
            }else {
                $this->session->set_userdata(array('error_message'=>'Please Import Only Csv File'));
                redirect(base_url('Cpurchase/add_csv_product'));
            }
            $this->session->unset_userdata('file_path');
            unlink($file_path);
        }
    }
}




    public function purchase_order() {
        $CI = & get_instance();
        $CI->auth->check_admin_auth();
        $CI->load->library('lpurchase');
        $content = $CI->lpurchase->purchase_order_form();
        $this->template->full_admin_html_view($content);



       //  $CI = & get_instance();

       //  $CI->auth->check_admin_auth();

       //  $CI->load->library('lpurchase');
       //  $data=array();
       // // echo $content = $CI->linvoice->invoice_add_form();
       //  $content = $this->load->view('purchase/purchase_order', $data, true);
       //  //$content='';
       //  $this->template->full_admin_html_view($content);

    }

    public function ocean_import_tracking(){
        $CI = & get_instance();

        $CI->auth->check_admin_auth();

        $CI->load->library('lpurchase');
       // $data=array();
        $content = $CI->lpurchase->ocean_import_form();
        
        $this->template->full_admin_html_view($content);
    }


       public function trucking(){

         $CI = & get_instance();

        $CI->auth->check_admin_auth();

        $CI->load->library('linvoice');
        $data=array();
         $get_customer= $this->accounts_model->get_customer();
         $bank_list        = $this->Web_settings->bank_list();
       
        $data = array(
            'customer_list' => $get_customer,
            'bank_list'     => $bank_list,
          
        );
        $data['voucher_no'] = $this->accounts_model->Creceive();
    

       
       // echo $content = $CI->linvoice->invoice_add_form();
        $content = $this->load->view('purchase/trucking', $data, true);
        //$content='';
        $this->template->full_admin_html_view($content);
    }



        public function CheckPurchaseList(){
        // GET data
        $this->load->model('Purchases');
        $postData = $this->input->post();
        $data = $this->Purchases->getPurchaseList($postData);
        echo json_encode($data);
    }



     public function CheckOceanImportList(){
        // GET data
        $this->load->model('Purchases');
        $postData = $this->input->post();
        $data = $this->Purchases->getOceanImportList($postData);
        echo json_encode($data);
    } 

     public function CheckPurchaseOrderList(){
         $this->load->model('Purchases');
        $postData = $this->input->post();
        $data = $this->Purchases->getPurchaseOrderList($postData);
        echo json_encode($data);
     }

       public function CheckTruckingList(){
         $this->load->model('Purchases');
        $postData = $this->input->post();
        $data = $this->Purchases->getTruckingList($postData);
        echo json_encode($data);
     }


         public function CheckPackingList(){
        // GET data
        $this->load->model('Purchases');
        $postData = $this->input->post();
        $data = $this->Purchases->getPackingList($postData);
        echo json_encode($data);
    }

    // search purchase by supplier 
    public function purchase_search() {
        $CI = & get_instance();
        $this->auth->check_admin_auth();
        $CI->load->library('lpurchase');
        $CI->load->model('Purchases');
        $supplier_id = $this->input->get('supplier_id');
        #
        #pagination starts
        #
        $config["base_url"] = base_url('Cpurchase/purchase_search/');
        $config["total_rows"] = $this->Purchases->count_purchase_seach($supplier_id);
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
        $content = $this->lpurchase->purchase_search_supplier($supplier_id, $links, $config["per_page"], $page);
        $this->template->full_admin_html_view($content);
    }

//purchase list by invoice no
    public function purchase_info_id() {
        $CI = & get_instance();
        $this->auth->check_admin_auth();
        $CI->load->library('lpurchase');
        $CI->load->model('Purchases');
        $invoice_no = $this->input->post('invoice_no',TRUE);
        $content = $this->lpurchase->purchase_list_invoice_no($invoice_no);
        $this->template->full_admin_html_view($content);
    }

    //Insert purchase
    public function insert_purchase() {

        $CI = & get_instance();
        $CI->auth->check_admin_auth();
        $CI->load->model('Purchases');
        $data=$CI->Purchases->purchase_entry();
        echo json_encode($data);



         
    

    }


      //Insert purchase
    public function insert_packing_list() {

        $CI = & get_instance();
        $CI->auth->check_admin_auth();
        $CI->load->model('Purchases');
        $invoice_id=$CI->Purchases->packing_list_entry();
      
        echo json_encode($invoice_id);
        
    }
 public function insert_purchase_order() {
   $CI = & get_instance();
        $CI->auth->check_admin_auth();
        $CI->load->model('Purchases');
        $invoice_id=$CI->Purchases->purchase_order_entry();

       echo json_encode($invoice_id);
      
    }
    public function insert_ocean_import() {
        $CI = & get_instance();
        $CI->auth->check_admin_auth();
        $CI->load->model('Purchases');
        $purchase_id=$CI->Purchases->ocean_import_entry();
      
        echo json_encode($purchase_id);
    }



    public function insert_trucking() {
      $CI = & get_instance();
            $CI->auth->check_admin_auth();
            $CI->load->model('Purchases');
           $purchaseid=$CI->Purchases->trucking_entry();
         
           echo json_encode($purchaseid);
      }


    //purchase Update Form
    public function purchase_update_form($purchase_id) {
        $CI = & get_instance();
        $CI->auth->check_admin_auth();
        $CI->load->library('lpurchase');
        $content = $CI->lpurchase->purchase_edit_data($purchase_id);
        $this->template->full_admin_html_view($content);
    }

      //purchase order Update Form
    public function purchase_order_update_form($purchase_id) {
        $CI = & get_instance();
        $CI->auth->check_admin_auth();
        $CI->load->library('lpurchase');
        $content = $CI->lpurchase->purchase_order_edit_data($purchase_id);
        $this->template->full_admin_html_view($content);
    }


      //Ocean Import Tracking Update Form
    public function ocean_import_tracking_update_form($purchase_id) {
        $CI = & get_instance();
        $CI->auth->check_admin_auth();
        $CI->load->library('lpurchase');
        $content = $CI->lpurchase->ocean_import_tracking_edit_data($purchase_id);
        $this->template->full_admin_html_view($content);
    }

        //Trucking Update Form
    public function trucking_update_form($purchase_id) {
        $CI = & get_instance();
        $CI->auth->check_admin_auth();
        $CI->load->library('lpurchase');
        $content = $CI->lpurchase->trucking_edit_data($purchase_id);
        $this->template->full_admin_html_view($content);
    } 

          //Trucking Update Form
    public function packing_list_update_form($purchase_id) {
        $CI = & get_instance();
        $CI->auth->check_admin_auth();
        $CI->load->library('lpurchase');
        $content = $CI->lpurchase->packing_list_edit_data($purchase_id);
        $this->template->full_admin_html_view($content);
    } 

    // purchase Update
    public function purchase_update() {

       // print_r($this->input->post()); die;
        
        $CI = & get_instance();
        $CI->auth->check_admin_auth();
        $CI->load->model('Purchases');
        $CI->Purchases->update_purchase();
        $this->session->set_userdata(array('message' => display('successfully_updated')));
        //redirect(base_url('Cpurchase/manage_purchase'));
     //   exit;
    }

      // purchase Update
    public function purchase_order_update() {
        $CI = & get_instance();
        $CI->auth->check_admin_auth();
        $CI->load->model('Purchases');
        $CI->Purchases->update_purchase_order();
        $this->session->set_userdata(array('message' => display('successfully_updated')));
        redirect(base_url('Cpurchase/manage_purchase_order'));
        exit;
    }

    //Purchase item by search
    public function purchase_item_by_search() {
        $CI = & get_instance();
        $this->auth->check_admin_auth();
        $CI->load->library('lpurchase');
        $supplier_id = $this->input->post('supplier_id',TRUE);
        $content = $CI->lpurchase->purchase_by_search($supplier_id);
        $this->template->full_admin_html_view($content);
    }



    //Product search by product name
    public function product_search_from_expense(){
          $CI = & get_instance();
        $this->auth->check_admin_auth();
        $CI->load->library('lpurchase');
        $CI->load->model('Suppliers');
        $supplier_id = $this->input->post('supplier_id',TRUE);
        $product_name = $this->input->post('product_name',TRUE);
        $product_info = $CI->Suppliers->product_search_by_name($product_name);
        if(!empty($product_info)){
        $list[''] = '';
        foreach ($product_info as $value) {
            $json_product[] = array('label'=>$value['product_name'].'('.$value['product_model'].')','value'=>$value['product_id']);
        } 
    }else{
        $json_product[] = 'No Product Found';
        }
        echo json_encode($json_product);
    }

    //Product search by supplier id
    public function product_search_by_supplier() {
        $CI = & get_instance();
        $this->auth->check_admin_auth();
        $CI->load->library('lpurchase');
        $CI->load->model('Suppliers');
        $supplier_id = $this->input->post('supplier_id',TRUE);
        $product_name = $this->input->post('product_name',TRUE);
        $product_info = $CI->Suppliers->product_search_item($supplier_id, $product_name);
     
        if(!empty($product_info)){
        $list[''] = '';
        foreach ($product_info as $value) {
            $json_product[] = array('label'=>$value['product_name'].'('.$value['product_model'].')','value'=>$value['product_id']);

           
        } 

        

    }else{
        $json_product[] = 'No Product Found';
        }
        echo json_encode($json_product);
    }

    //Retrive right now inserted data to cretae html
    public function purchase_details_data($purchase_id) {
        
        $CI = & get_instance();
        $CI->auth->check_admin_auth();
        $CI->load->library('lpurchase');
          $data=array();
        $this->load->model('Purchases');

    
        $content = $CI->lpurchase->purchase_details_data($purchase_id);
        $this->template->full_admin_html_view($content);
    }


     //Retrive right now inserted data to cretae html
    public function ocean_import_tracking_details_data($purchase_id) {

        $CI = & get_instance();
        $CI->auth->check_admin_auth();
        $CI->load->library('lpurchase');
        $content = $CI->lpurchase->ocean_import_tracking_details_data($purchase_id);
       
        $this->template->full_admin_html_view($content);
    }


     //Retrive right now inserted data to cretae html
    public function purchase_order_details_data($purchase_id) {
        $CI = & get_instance();
        $CI->auth->check_admin_auth();
        $CI->load->library('linvoice');
        $data=array();
        $this->load->model('Purchases');
        $this->load->model('invoice_design');
        $invoice_no = $this->uri->segment(3);
        $currency_details = $CI->Web_settings->retrieve_setting_editdata();
        // $invoice_list = $this->Purchases->invoice_list();
        $data['invoice'] =$this->Purchases->get_purchases_invoice($invoice_no);
        // print_r( $data); die();
        $data['order'] =$this->Purchases->get_purchases_order($invoice_no);
        //  print_r( $data['invoice']); die();
        $data['supplier'] =$this->Purchases->get_supplier($invoice_no);
        $data['company_info'] =$this->Purchases->company_info();
      //  $order = json_decode($data['order'], true);
      $taxfield1 = $CI->db->select('tax_id,tax')
      ->from('tax_information')
      ->get()
      ->result_array();
$data=array(
    'tax'           => $taxfield1,
    // 'paid_amount'    =>  $invoice_list,
    // 'due_amount'      =>  $invoice_list,
    'currency'       => $currency_details[0]['currency'],
    'invoice_setting'  =>$this->invoice_design->retrieve_data(),
    'invoice' =>$this->Purchases->get_purchases_invoice($invoice_no),
    'order' => $this->Purchases->get_purchases_order($invoice_no),
    'supplier'=> $this->Purchases->get_supplier($invoice_no),
    'supplier_currency' =>$data['supplier'][0]['currency_type'],
    'company_info' =>$this->Purchases->company_info()
);

        //$data['invoice_setting'] =$this->invoice_design->retrieve_data();
        $content = $this->load->view('purchase/purchase_order_invoice', $data, true);
        //$content='';
        $this->template->full_admin_html_view($content);
    }

      public function ocean_import_details_data() {

        $CI = & get_instance();
        $CI->auth->check_admin_auth();
        $CI->load->library('linvoice');
        $data=array();
       // echo $content = $CI->linvoice->invoice_add_form();
        $content = $this->load->view('purchase/ocean_import_invoice_html', $data, true);
        //$content='';
        $this->template->full_admin_html_view($content);

    }


    public function packing_list_details_data($expense_packing_id) {
        $CI = & get_instance();
        $CC = & get_instance();
        $CA = & get_instance();
        $CB = & get_instance();
        $CI->auth->check_admin_auth();
        $CI->load->library('linvoice');
        $CB->load->model('Purchases');
        $CA->load->model('invoice_design');
        $CC->load->model('invoice_content');
        $CC->load->model('Ppurchases');
        $dataw = $CA->invoice_design->retrieve_data();
        $datacontent = $CI->invoice_content->retrieve_data();
        $packing_details = $CB->Purchases->packing_details_data($expense_packing_id);
        $currency_details = $CI->Web_settings->retrieve_setting_editdata();
       // $packing_details = $CB->Invoices->packing_details_data($expense_id);
       $company_info = $CI->Ppurchases->retrieve_company();
        $data=array(
            'currency'       => $currency_details[0]['currency'],
            'packing_details' => $packing_details,
            'company' => $company_info[0]['company_name'],
            'address' => $company_info[0]['address'],
            'email' => $company_info[0]['email'],
            'phone' => $company_info[0]['mobile'],
            'header'=> $dataw[0]['header'],
            'logo'=> $dataw[0]['logo'],
            'color'=> $dataw[0]['color'],
            'template'=> $dataw[0]['template'],
            'invoice'  =>$packing_details[0]['invoice_no'],
            'invoice_date' => $packing_details[0]['invoice_date'],
            'expense_packing_id'=>$packing_details[0]['expense_packing_id'],
            'gross' => $packing_details[0]['gross_weight'],
            'container' => $packing_details[0]['container_no'],
            'remarks' => $packing_details[0]['remarks'],
          
           
        
           
            'packing_details'=>$packing_details,
          
            'product' => $packing_details[0]['product_name']

        //    'pro_no'  => $pro_no

        );
      
       // echo $content = $CI->linvoice->invoice_add_form();
        $content = $this->load->view('purchase/packing_invoice_html', $data, true);
        //$content='';
        $this->template->full_admin_html_view($content);
    }

    public function trucking_details_data() {
        $CI = & get_instance();
        $CI->auth->check_admin_auth();
        $CI->load->library('linvoice');
        $data=array();
       // echo $content = $CI->linvoice->invoice_add_form();
        $content = $this->load->view('purchase/trucking_invoice_html', $data, true);
        //$content='';
        $this->template->full_admin_html_view($content);
    }


    public function delete_trucking() {
        $this->db->where('trucking_id', $_GET['val']);
        $this->db->delete('expense_trucking');
        $this->db->where('expense_trucking_id', $_GET['val']);
        $this->db->delete('expense_trucking_details');
    
 
   }
   public function delete_packing() {
    $this->db->where('expense_packing_id', $_GET['val']);
    $this->db->delete('expense_packing_list');
    $this->db->where('expense_packing_id', $_GET['val']);
    $this->db->delete('expense_packing_list_detail');

 // redirect("Cpurchase/manage_purchase");
}
public function delete_ocean_import(){
    $this->db->where('booking_no', $_GET['val']);
    $this->db->delete('ocean_import_tracking');
   
}
public function deletepurchaseorder(){
    $this->db->where('purchase_order_id', $_GET['val']);
    $this->db->delete('purchase_order');
    $this->db->where('purchase_id', $_GET['val']);
    $this->db->delete('purchase_order_details');
}
public function deletepurchase(){
    $this->db->where('purchase_id', $_GET['val']);
    $this->db->delete('product_purchase');
    $this->db->where('purchase_id', $_GET['val']);
    $this->db->delete('product_purchase_details');
}
    public function delete_purchase($purchase_id = null) {
        $this->load->model('Purchases');
        if ($this->Purchases->purchase_delete($purchase_id)) {
            #set success message
            $this->session->set_flashdata('message', display('delete_successfully'));
        } else {
            #set exception message
            $this->session->set_flashdata('exception', display('please_try_again'));
        }
        redirect(base_url('Cpurchase/manage_purchase'));
    }

    // purchase info date to date
    public function manage_purchase_date_to_date() {
        $CI = & get_instance();
        $this->auth->check_admin_auth();
        $CI->load->library('lpurchase');
        $CI->load->model('Purchases');
        $start = $this->input->post('from_date',TRUE);
        $end = $this->input->post('to_date',TRUE);

        $content = $this->lpurchase->purchase_list_date_to_date($start, $end);
        $this->template->full_admin_html_view($content);
    }
//purchase pdf download
      public function purchase_downloadpdf(){
        $CI = & get_instance();
        $CI->load->model('Purchases');
        $CI->load->model('Web_settings');
        $CI->load->model('Invoices');
        $CI->load->library('pdfgenerator'); 
        $purchase_list = $CI->Purchases->pdf_purchase_list();
        if (!empty($purchase_list)) {
            $i = 0;
            if (!empty($purchase_list)) {
                foreach ($purchase_list as $k => $v) {
                    $i++;
                    $purchase_list[$k]['sl'] = $i + $CI->uri->segment(3);
                }
            }
        }
        $currency_details = $CI->Web_settings->retrieve_setting_editdata();
        $company_info = $CI->Invoices->retrieve_company();
        $data = array(
            'title'         => display('manage_purchase'),
            'purchase_list' => $purchase_list,
            'currency'      => $currency_details[0]['currency'],
            'logo'          => $currency_details[0]['logo'],
            'position'      => $currency_details[0]['currency_position'],
            'company_info'  => $company_info
        );
            $this->load->helper('download');
            $content = $this->parser->parse('purchase/purchase_list_pdf', $data, true);
            $time = date('Ymdhi');
            $dompdf = new DOMPDF();
            $dompdf->load_html($content);
            $dompdf->render();
            $output = $dompdf->output();
            file_put_contents('assets/data/pdf/'.'purchase'.$time.'.pdf', $output);
            $file_path = 'assets/data/pdf/'.'purchase'.$time.'.pdf';
           $file_name = 'purchase'.$time.'.pdf';
            force_download(FCPATH.'assets/data/pdf/'.$file_name, null);
    }

public function insert_po_product()
{


$date=date('d-m-Y');

    $sql=array(
    'product_id'  => $this->input->post('product_id',TRUE),
    'products_model'  =>$this->input->post('model',TRUE),
    'supplier_id'   =>$this->input->post('supplier_id',TRUE),
    'supplier_price' =>$this->input->post('price',TRUE),
    'created_by'=>$this->session->userdata('user_id')
);
$this->db->insert('supplier_product',$sql);
    redirect('Cpurchase/purchase_order');
}


   
}
