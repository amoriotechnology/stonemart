<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Linvoice {

    //Retrieve  Invoice List
    public function invoice_list() {
        $CI = & get_instance();
        $CI->load->model('Invoices');
        $CI->load->model('Web_settings');
        $CI->load->model('Permission_model');
        $assign_role=$CI->Permission_model->assign_role();
        $email_setting=$CI->Web_settings->retrieve_email_setting();

        $sale = $CI->Invoices->newsale();
 

        // print_r($sale); die();
        $CI->load->library('occational');
        $company_info = $CI->Invoices->retrieve_company();
        
        $currency_details = $CI->Web_settings->retrieve_setting_editdata();
        $data = array(
            'currency'       => $currency_details[0]['currency'],
            'title'         => display('manage_invoice'),
            'total_invoice' => $CI->Invoices->count_invoice(),
            'currency'      => $currency_details[0]['currency'],
            'company_info'  => $company_info,
            'role'  => $assign_role,
            'email_setting'  => $email_setting,
            'sale' => $sale
        );
        // echo '<pre>';

        // echo '</pre>';
        $invoiceList = $CI->parser->parse('invoice/invoice', $data, true);
        return $invoiceList;
    }
    
    public function packing_list_edit_data($purchase_id) {

        $CI = & get_instance();
    
        $CI->load->model('Invoices');
    
        $CI->load->model('Suppliers');
    
        $CI->load->model('Web_settings');
    
         //$bank_list        = $CI->Web_settings->bank_list();
    
        $purchase_detail = $CI->Invoices->retrieve_packing_editdata($purchase_id);
   // print_r($purchase_detail);
        // $customer_id = $purchase_detail[0]['customer_id'];
    
        // $supplier_list = $CI->Suppliers->supplier_list("110", "0");
    
        // $supplier_selected = $CI->Suppliers->supplier_search_item($supplier_id);
   
    
    
        if (!empty($purchase_detail)) {
    
            $i = 0;
    
            foreach ($purchase_detail as $k => $v) {
    
                $i++;
    
                $purchase_detail[$k]['sl'] = $i;
    
            }
    
        }
    
        $prodt = $CI->db->select('product_name,product_model,p_quantity')
        ->from('product_information')
        ->where('created_by',$purchase_detail[0]['create_by'])
        ->get()
        ->result_array();
    
        $currency_details = $CI->Web_settings->retrieve_setting_editdata();
    
        $data = array(
    
            'title'         => 'Packing List Edit',
    
            'expense_packing_id'   => $purchase_detail[0]['expense_packing_id'],
    
            'invoice_no'     => $purchase_detail[0]['invoice_no'],
    
            'invoice_date'   => $purchase_detail[0]['invoice_date'],
    
            'gross_weight' => $purchase_detail[0]['gross_weight'],
    
            'container_no' => $purchase_detail[0]['container_no'],
    
            'thickness' => $purchase_detail[0]['thickness'],
    
          'remarks' =>$purchase_detail[0]['remarks'],
          'currencyd' => $currency_details[0]['currency'],
    'quantity_per_package'   =>$purchase_detail[0]['quantity_per_package'],
            'grand_total_amount' =>  $purchase_detail[0]['grand_total_amount'],
    
            'serial_no' =>   $purchase_detail[0]['serial_no'],
    
            'purchase_info' => $purchase_detail,
    
         'products' =>$prodt
    
          //  'prouduct_name' =>  $purchase_detail[0]['product_name'],
    
          
    
        );
 
    
  
      
        $chapterList = $CI->parser->parse('invoice/edit_packing_form', $data, true);
    
        return $chapterList;
    
    }

     public function profarma_invoice_list() {
        $CI = & get_instance();
        $CI->load->model('Invoices');
        $CI->load->model('Web_settings');
        $CI->load->library('occational');
        $company_info = $CI->Invoices->retrieve_company();
        $currency_details = $CI->Web_settings->retrieve_setting_editdata();
        // $email_setting = $CI->Web_settings->retrieve_email_setting();
        $sale = $CI->Invoices->newsale();
    $customer=  $CI->Invoices->profarma_invoice_customer();

        // print_r($email_setting); die();
        $data = array(
               'customer' => $customer,
            'title'         => display('manage_invoice'),
            'total_invoice' => $CI->Invoices->count_invoice(),
            'currency'      => $currency_details[0]['currency'],
            'company_info'  => $company_info,
            // 'email_setting'  => $email_setting,
            'sale' => $sale
        );
        $invoiceList = $CI->parser->parse('invoice/profarma_invoice_list', $data, true);
        return $invoiceList;
    }


     public function packing_invoice_list() {
     

        $CI = & get_instance();
        // $CII = & get_instance();
        $CI->load->model('Invoices');
        $CI->load->model('Web_settings');
        $CI->load->library('occational');
        // $CII->load->model('invoice_design');
        // $C->load->model('invoice_content');
        $company_info = $CI->Invoices->retrieve_company();
        // $dataw = $CII->invoice_design->retrieve_data();
        // $datacontent = $CI->invoice_content->retrieve_data();
        $currency_details = $CI->Web_settings->retrieve_setting_editdata();
        $data = array(
            'title'         => display('manage_invoice'),
            'total_invoice' => $CI->Invoices->count_invoice(),
            'currency'      => $currency_details[0]['currency'],
            'company_info'  => $company_info,
        );

        // $data = array(
        //     'header'=> $dataw[0]['header'],
        //     'logo'=> $dataw[0]['logo'],
        //     'color'=> $dataw[0]['color'],
        //     'template'=> $dataw[0]['template'],
        //     'title'         => display('manage_invoice'),
        //     'total_invoice' => $CI->Invoices->count_invoice(),
        //     'currency'      => $currency_details[0]['currency'],
        //     'company_info'  => $company_info,
        // );

        $invoiceList = $CI->parser->parse('invoice/packing_list', $data, true);
        return $invoiceList;
    }

     public function ocean_export_tracking_invoice_list() {
     

        $CI = & get_instance();
        $CI->load->model('Invoices');
        $CI->load->model('Web_settings');
        $CI->load->library('occational');
        $company_info = $CI->Invoices->retrieve_company();
        $currency_details = $CI->Web_settings->retrieve_setting_editdata();
        $data = array(
            'title'         => 'Manage Ocean Export Invoices',
            'total_invoice' => $CI->Invoices->count_invoice(),
            'currency'      => $currency_details[0]['currency'],
            'company_info'  => $company_info,
        );
        $invoiceList = $CI->parser->parse('invoice/ocean_export_tracking_invoice_list', $data, true);
        return $invoiceList;
    }


         //ocean import tracking Edit Data

         public function ocean_export_tracking_edit_data($purchase_id) {

            $CI = & get_instance();
    
           $CI->load->model('Invoices');
    
            $CI->load->model('Suppliers');
    
            $CI->load->model('Web_settings');
    
            $bank_list       = $CI->Web_settings->bank_list();
    
            $purchase_detail = $CI->Invoices->retrieve_ocean_export_tracking_editdata($purchase_id);
    
            $customer_name = $CI->db->select('*')->from('customer_information')->where('customer_id', $purchase_detail[0]['consignee'])->get()->result_array();
    
    
            $supplier_id = $purchase_detail[0]['supplier_id'];
    
            $supplier_name = $purchase_detail[0]['supplier_name'];
    
            $supplier_list = $CI->Suppliers->supplier_list("110", "0");

            $supplier_selected = $CI->Suppliers->supplier_search_item($supplier_id);
    
    
    
            if (!empty($purchase_detail)) {
    
                $i = 0;
    
                foreach ($purchase_detail as $k => $v) {
    
                    $i++;
    
                    $purchase_detail[$k]['sl'] = $i;
    
                }
    
            }
    

    
            $currency_details = $CI->Web_settings->retrieve_setting_editdata();
            $customer=  $CI->Invoices->profarma_invoice_customer();
            $data = array(
    
                'title'         => 'Edit Ocean Import Tracking Invoice',
    
                'ocean_export_tracking_id'   => $purchase_detail[0]['ocean_export_tracking_id'],
    
                'booking_no'     => $purchase_detail[0]['booking_no'],
                'customer_name'  => $customer_name[0]['customer_name'],
                'customer_id'  => $customer_name[0]['customer_id'],
                'supplier_name' => $supplier_name,
                'supplier_list' =>$supplier_list,
    
                'supplier_id'   => $supplier_id,
    
                'container_no' => $purchase_detail[0]['container_no'],
    
                'seal_no'   => $purchase_detail[0]['seal_no'],
    
                'shipper' => $purchase_detail[0]['shipper'],
    
                'invoice_date' => $purchase_detail[0]['invoice_date'],
    
                'consignee' => $purchase_detail[0]['consignee'],
    
                'notify_party' => $purchase_detail[0]['notify_party'],
    
                'vessel' =>  $purchase_detail[0]['vessel'],
    
                'voyage_no' =>  $purchase_detail[0]['voyage_no'],
    
                'port_of_loading' =>  $purchase_detail[0]['port_of_loading'],
    
                'port_of_discharge' => $purchase_detail[0]['port_of_discharge'],
    
                'place_of_delivery' => $purchase_detail[0]['place_of_delivery'],
    
                'freight_forwarder'  => $purchase_detail[0]['freight_forwarder'],
    
                'particular' => $purchase_detail[0]['particular'],
    
                'attachment' => $purchase_detail[0]['attachment'],
    
                'status'  => $purchase_detail[0]['status'],
                'customer' =>$customer
    
            );
    
    
    
            $chapterList = $CI->parser->parse('invoice/edit_ocean_export_tracking_form', $data, true);
    
            return $chapterList;
    
        }



    public function ocean_export_tracking_details_data($purchase_id) {



        $CI = & get_instance();

        $CI->load->model('Invoices');
        $CI->load->model('Web_settings');

        $CI->load->library('occational');



        $purchase_detail = $CI->Invoices->ocean_export_tracking_details_data($purchase_id);
        

     

        if (!empty($purchase_detail)) {

            $i = 0;

            foreach ($purchase_detail as $k => $v) {

                $i++;

                $purchase_detail[$k]['sl'] = $i;

            }



            foreach ($purchase_detail as $k => $v) {

                $purchase_detail[$k]['convert_date'] = $CI->occational->dateConvert($purchase_detail[$k]['invoice_date']);

            }

        }

        $CII = & get_instance();
        $CII->load->model('invoice_design');
        $currency_details = $CI->Web_settings->retrieve_setting_editdata();
        $dataw = $CII->invoice_design->retrieve_data();
        $company_info = $CI->Invoices->retrieve_company();
        $customer_name = $CI->db->select('*')->from('customer_information')->where('customer_id', $purchase_detail[0]['consignee'])->get()->result_array();
    
        

        $data = array(
            'header'=> $dataw[0]['header'],
            'logo'=> $dataw[0]['logo'],
            'color'=> $dataw[0]['color'],
            'template'=> $dataw[0]['template'],

        'title'            => 'Ocean Export Tracking Invoice Detail',

        'ocean_import_tracking_id'      => $purchase_detail[0]['ocean_export_tracking_id'],

            'booking_no' => $purchase_detail[0]['booking_no'],
          'customer_name'  => $customer_name[0]['customer_name'],
            'supplier'    => $purchase_detail[0]['supplier_name'],

            'container_no'    => $purchase_detail[0]['container_no'],
            'company'    => $company_info[0]['company_name'],
            'address'    => $company_info[0]['address'],
            'email'    => $company_info[0]['email'],
            'phone'    => $company_info[0]['mobile'],
            'seal_no'       => $purchase_detail[0]['seal_no'],
            'etd' => $purchase_detail[0]['etd'],
            'eta' => $purchase_detail[0]['eta'],
            'supplier_id' => $purchase_detail[0]['supplier_id'],
            'supplier_name' => $purchase_detail[0]['supplier_name'],
            'shipper' => $purchase_detail[0]['shipper'],
            'invoice_date' => $purchase_detail[0]['invoice_date'],
            'consignee' => $purchase_detail[0]['consignee'],
            'notify_party' => $purchase_detail[0]['notify_party'],
            'vessel' => $purchase_detail[0]['vessel'],
            'voyage_no' => $purchase_detail[0]['voyage_no'],
            'port_of_loading' => $purchase_detail[0]['port_of_loading'],
            'port_of_discharge' => $purchase_detail[0]['port_of_discharge'],
            'place_of_delivery' => $purchase_detail[0]['place_of_delivery'],
            'freight_forwarder' => $purchase_detail[0]['freight_forwarder'],
            'particular' => $purchase_detail[0]['particular'],
            'attachment' => $purchase_detail[0]['attachment'],
            'status' => $purchase_detail[0]['status'],
            'create_by' => $purchase_detail[0]['create_by'],

            // 'sub_total_amount' => number_format($purchase_detail[0]['grand_total_amount'], 2, '.', ','),

       

        );


        $chapterList = $CI->parser->parse('invoice/ocean_export_invoice_html', $data, true);

        return $chapterList;

    }

    public function trucking_edit_data($purchase_id) {

        $CI = & get_instance();
       
        $CI->load->model('Invoices');

        $CI->load->model('Suppliers');
        $CI->load->model('Ppurchases');
        
        $CI->load->model('Web_settings');
        $CI->load->model('Accounts_model');
         //$bank_list        = $CI->Web_settings->bank_list();

        $purchase_detail = $CI->Invoices->retrieve_trucking_editdata($purchase_id);

        // print_r($purchase_detail); exit();

     
        $customer_id = $purchase_detail[0]['customer_id'];

        // $supplier_list = $CI->Suppliers->supplier_list("110", "0");

        // $supplier_selected = $CI->Suppliers->supplier_search_item($supplier_id);



        if (!empty($purchase_detail)) {

            $i = 0;

            foreach ($purchase_detail as $k => $v) {

                $i++;

                $purchase_detail[$k]['sl'] = $i;

            }

        }

        $currency_details = $CI->Web_settings->retrieve_setting_editdata();
        $curn_info_default = $CI->db->select('*')->from('currency_tbl')->where('icon',$currency_details[0]['currency'])->get()->result_array();
      
        $taxfield = $CI->db->select('tax_name,default_value')->from('tax_settings')->get()->result_array();
        $taxfield1 = $CI->db->select('tax_id,tax')
        ->from('tax_information')
        ->get()
        ->result_array();
        $get_customer= $CI->Accounts_model->get_customer();
        $all_supplier = $CI->Ppurchases->select_all_supplier_trucker();
        $pro_number = $CI->Invoices->pro_number();
        $company_info = $CI->Ppurchases->retrieve_company();
       
        $bank_list      = $CI->Web_settings->bank_list();
        $data = array(
            'all_supplier'  => $all_supplier,
            'curn_info_default' =>$curn_info_default[0]['currency_name'],
            'currency'  =>$currency_details[0]['currency'],

            'title'         => 'Edit Trucking Invoice',
            'taxes'         => $taxfield,
            'tax'         => $taxfield1,

            'trucking_id'   => $purchase_detail[0]['trucking_id'],

            'invoice_no'     => $purchase_detail[0]['invoice_no'],
          
            'customer_name' => $purchase_detail[0]['customer_name'],

            'customer_id'   => $purchase_detail[0]['customer_id'],
            'bank_list'       => $bank_list,
            'bill_to'   => $purchase_detail[0]['bill_to'],

            'purchase_info' => $purchase_detail,

            'shipment_company'   => $purchase_detail[0]['shipment_company'],

            'container_pickup_date'   => $purchase_detail[0]['container_pickup_date'],

            'delivery_date'   => $purchase_detail[0]['delivery_date'],

            'total'         => number_format($purchase_detail[0]['grand_total_amount'] + (!empty($purchase_detail[0]['total_discount'])?$purchase_detail[0]['total_discount']:0),2),

            'customer_list' => $get_customer,
            'company_info' => $company_info,
            'invoice'  => $pro_no_reference

        );



        $chapterList = $CI->parser->parse('invoice/edit_trucking_form', $data, true);

        return $chapterList;

    }
    public function trucking_details_data($purchase_id) {



        $CI = & get_instance();

        $CI->load->model('Invoices');

        $CI->load->model('Web_settings');

        $CI->load->library('occational');



        $purchase_detail = $CI->Invoices->trucking_details_data($purchase_id);



        if (!empty($purchase_detail)) {

            $i = 0;

            foreach ($purchase_detail as $k => $v) {

                $i++;

                $purchase_detail[$k]['sl'] = $i;

            }



            foreach ($purchase_detail as $k => $v) {

                $purchase_detail[$k]['convert_date'] = $CI->occational->dateConvert($purchase_detail[$k]['invoice_date']);

            }

        }



        $currency_details = $CI->Web_settings->retrieve_setting_editdata();
        $curn_info_default = $CI->db->select('*')->from('currency_tbl')->where('icon',$currency_details[0]['currency'])->get()->result_array();
      
        $CII = & get_instance();
        $CC = & get_instance();
        $w = & get_instance();

        $w->load->model('Ppurchases');

       $company_info = $w->Ppurchases->retrieve_company();

       // print_r($company_info); die();

        $CII->load->model('invoice_design');
        $CC->load->model('invoice_content');
        $CI1 = & get_instance();
        $CI1->load->model('Purchases');
        $all_supplier = $CI1->Purchases->select_all_supplier();
       $dataw = $CII->invoice_design->retrieve_data();
       $datacontent = $CI->invoice_content->retrieve_data();
     $data = array(
        'curn_info_default' =>$curn_info_default[0]['currency_name'],
        'currency'  =>$currency_details[0]['currency'],
            'header'=> $dataw[0]['header'],
            'logo'=> $dataw[0]['logo'],
            'color'=> $dataw[0]['color'],
            'template'=> $dataw[0]['template'],
            'all_supplier' => $all_supplier,
            'add'=>$company_info[0]['address'],
            'company'=>$company_info[0]['company_name'],
            'cname'=>$datacontent[0]['business_name'],
            'phone'=>$datacontent[0]['phone'],
            'email'=>$datacontent[0]['email'],
            'reg_number'=>$datacontent[0]['reg_number'],
            'website'=>$datacontent[0]['website'],
            'address'=>$datacontent[0]['address'],
            'title'            => display('purchase_details'),

            'trucking_id'      => $purchase_detail[0]['trucking_id'],
          
           
            'invoice_no' =>  $purchase_detail[0]['invoice_no'],

            'invoice_date' => $purchase_detail[0]['invoice_date'],

            'bill_to' => $purchase_detail[0]['bill_to'],

            'shipment_company' => $purchase_detail[0]['shipment_company'],

            'container_pickup_date' => $purchase_detail[0]['container_pickup_date'],

            'delivery_date' => $purchase_detail[0]['delivery_date'],

            'truckingdate' => $purchase_detail[0]['trucking_date'],
            
            'customer_name' => $purchase_detail[0]['customer_name'],
            'customer_currency' => $purchase_detail[0]['currency_type'],

            'qty' => $purchase_detail[0]['qty'],

            'description' => $purchase_detail[0]['description'],

            'rate' => $purchase_detail[0]['rate'],

           // 'pro_no_reference' => $purchase_detail[0]['pro_no_reference'],

            'total_amt' =>  $purchase_detail[0]['total_amt'],
            'tax' =>  $purchase_detail[0]['tax'],

            'grandtotal' =>  $purchase_detail[0]['grand_total_amount'],
            'remarks' =>  $purchase_detail[0]['remarks'],
            'purchase_all_data'=> $purchase_detail,

           // 'company_info'     => $company_info,

            'Web_settings'     => $currency_details,

        );

        // echo "<pre>";
  



        $chapterList = $CI->parser->parse('invoice/trucking_invoice_html', $data, true);

        return $chapterList;

    }

    public function trucking_invoice_list() {
     

        $CI = & get_instance();
        $CI->load->model('Invoices');
        $CI->load->model('Web_settings');
        $CI->load->library('occational');
        $company_info = $CI->Invoices->retrieve_company();
        $currency_details = $CI->Web_settings->retrieve_setting_editdata();
        $data = array(
            'title'         => display('manage_invoice'),
            'total_invoice' => $CI->Invoices->count_invoice(),
            'currency'      => $currency_details[0]['currency'],
            'company_info'  => $company_info,
        );
        $invoiceList = $CI->parser->parse('invoice/trucking_invoice_list', $data, true);
        return $invoiceList;
    }

    //pdf download
    public function pdf_download(){
             $CI = & get_instance();
        $CI->load->model('Invoices');
        $CI->load->model('Web_settings');
        $CI->load->library('occational');

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
       
        $data = array(
            'title'         => display('manage_invoice'),
            'invoices_list' => $invoices_list,
            'currency'      => $currency_details[0]['currency'],
            'position'      => $currency_details[0]['currency_position']
        );
        $invoiceList = $CI->parser->parse('invoice/invoice_list_pdf', $data, true);
        return $invoiceList;
    }

    // Search invoice by customer id
    public function invoice_search($customer_id, $links, $per_page, $page) {

        $CI = & get_instance();
        $CI->load->model('Invoices');
        $CI->load->model('Web_settings');
        $CI->load->library('occational');

        $invoices_list = $CI->Invoices->invoice_search($customer_id, $per_page, $page);
        if (!empty($invoices_list)) {
            foreach ($invoices_list as $k => $v) {
                $invoices_list[$k]['final_date'] = $CI->occational->dateConvert($invoices_list[$k]['date']);
            }
            $i = 0;
            if (!empty($invoices_list)) {
                foreach ($invoices_list as $k => $v) {
                    $i++;
                    $invoices_list[$k]['sl'] = $i + $CI->uri->segment(3);
                }
            }
        }
        $currency_details = $CI->Web_settings->retrieve_setting_editdata();
        $data = array(
            'title'         => display('manage_invoice'),
            'invoices_list' => $invoices_list,
            'links'         => $links,
            'currency'      => $currency_details[0]['currency'],
            'position'      => $currency_details[0]['currency_position'],
        );
        $invoiceList = $CI->parser->parse('invoice/invoice', $data, true);
        return $invoiceList;
    }

    //inovie_manage search by invoice id
    public function invoice_list_invoice_no($invoice_no) {

        $CI = & get_instance();
        $CI->load->model('Invoices');
        $CI->load->model('Web_settings');
        $CI->load->library('occational');

        $invoices_list = $CI->Invoices->invoice_list_invoice_id($invoice_no);
        if (!empty($invoices_list)) {
            foreach ($invoices_list as $k => $v) {
                $invoices_list[$k]['final_date'] = $CI->occational->dateConvert($invoices_list[$k]['date']);
            }
            $i = 0;
            if (!empty($invoices_list)) {
                foreach ($invoices_list as $k => $v) {
                    $i++;
                    $invoices_list[$k]['sl'] = $i + $CI->uri->segment(3);
                }
            }
        }
        $currency_details = $CI->Web_settings->retrieve_setting_editdata();
        $data = array(
            'title'         => display('manage_invoice'),
            'invoices_list' => $invoices_list,
            'links'         => '',
            'currency'      => $currency_details[0]['currency'],
            'position'      => $currency_details[0]['currency_position'],
        );
        $invoiceList = $CI->parser->parse('invoice/invoice', $data, true);
        return $invoiceList;
    }

    // date to date invoice list 
    public function invoice_list_date_to_date($from_date, $to_date, $links, $perpage, $page) {

        $CI = & get_instance();
        $CI->load->model('Invoices');
        $CI->load->model('Web_settings');
        $CI->load->library('occational');

        $invoices_list = $CI->Invoices->invoice_list_date_to_date($from_date, $to_date, $perpage, $page);
        if (!empty($invoices_list)) {
            foreach ($invoices_list as $k => $v) {
                $invoices_list[$k]['final_date'] = $CI->occational->dateConvert($invoices_list[$k]['date']);
            }
            $i = 0;
            if (!empty($invoices_list)) {
                foreach ($invoices_list as $k => $v) {
                    $i++;
                    $invoices_list[$k]['sl'] = $i + $CI->uri->segment(3);
                }
            }
        }
        $currency_details = $CI->Web_settings->retrieve_setting_editdata();
        $data = array(
            'title'         => display('manage_invoice'),
            'invoices_list' => $invoices_list,
            'links'         => $links,
            'currency'      => $currency_details[0]['currency'],
            'position'      => $currency_details[0]['currency_position'],
        );
        $invoiceList = $CI->parser->parse('invoice/invoice', $data, true);
        return $invoiceList;
    }

    //Pos invoice add form
    public function pos_invoice_add_form() {

        $CI = & get_instance();
        $CI->load->model('Invoices');
        $CI->load->model('Web_settings');
        $customer_details = $CI->Invoices->pos_customer_setup();
        $bank_list        = $CI->Web_settings->bank_list();
        $currency_details = $CI->Web_settings->retrieve_setting_editdata();
        $taxfield = $CI->db->select('tax_name,default_value')
                ->from('tax_settings')
                ->get()
                ->result_array();
                $tablecolumn = $CI->db->list_fields('tax_collection');
                $num_column = count($tablecolumn)-4;
        $data = array(
            'title'         => display('pos_invoice'),
            'customer_name' => $customer_details[0]['customer_name'],
            'customer_id'   => $customer_details[0]['customer_id'],
            'discount_type' => $currency_details[0]['discount_type'],
            'taxes'         => $taxfield,
            'taxnumber'     => $num_column,
            'bank_list'     => $bank_list,
        );
        $invoiceForm = $CI->parser->parse('invoice/add_pos_invoice_form', $data, true);
        return $invoiceForm;
    }

    //Retrieve  Invoice List
    public function search_inovoice_item($customer_id) {
        $CI = & get_instance();
        $CI->load->model('Invoices');
        $CI->load->library('occational');
        $invoices_list = $CI->Invoices->search_inovoice_item($customer_id);
        if (!empty($invoices_list)) {
            foreach ($invoices_list as $k => $v) {
                $invoices_list[$k]['final_date'] = $CI->occational->dateConvert($invoices_list[$k]['date']);
            }
            $i = 0;
            if (!empty($invoices_list)) {
                foreach ($invoices_list as $k => $v) {
                    $i++;
                    $invoices_list[$k]['sl'] = $i + $CI->uri->segment(3);
                }
            }
        }
        $data = array(
            'title' => display('manage_invoice'),
            'invoices_list' => $invoices_list
        );
        $invoiceList = $CI->parser->parse('invoice/invoice', $data, true);
        return $invoiceList;
    }

    //Invoice add form
    public function invoice_add_form() {

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
     $payment_type= $CI->Invoices->payment_type();
        $currency_details = $CI->Web_settings->retrieve_setting_editdata();
        $curn_info_default = $CI->db->select('*')->from('currency_tbl')->where('icon',$currency_details[0]['currency'])->get()->result_array();
       
       // $curn_info_customer = $CI->db->select('*')->from('currency_tbl')->where('icon',$customer_details[0]['currency_type'])->get()->result_array();
        $taxfield1 = $CI->db->select('tax_id,tax')
        ->from('tax_information')
        ->get()
        ->result_array();
        $bank_name = $CI->db->select('bank_name')
        ->from('bank_add')
        ->get()
        ->result_array();
        $container_booking_no= $CI->Invoices->container_booking_no();
        $taxfield = $CI->db->select('tax_name,default_value')
                ->from('tax_settings')
                ->get()
                ->result_array();
        $bank_list          = $CI->Web_settings->bank_list();
        $prodt = $CI->db->select('product_name,product_model,p_quantity')
        ->from('product_information')
        ->get()
        ->result_array();
        $paytype=$CI->Invoices->payment_type();
        $voucher_no = $CI->Invoices->commercial_inv_number();
        $sales_packing_list = $CI->Invoices->sales_packing_list();
        $data = array(
            'curn_info_default' =>$curn_info_default[0]['currency_name'],
           // 'curn_info_customer'=>$curn_info_customer[0]['currency_name'],
            'currency'  =>$currency_details[0]['currency'],
            'title'         => display('add_new_invoice'),
            'discount_type' => $currency_details[0]['discount_type'],
            'taxes'         => $taxfield,
            'payment_typ' =>  $payment_type,
            'bank_name'  =>$bank_name,
            'tax'           => $taxfield1,
            'booking_no'=>$container_booking_no,
              'container_no'=>$container_booking_no,
            'product'       =>$prodt,
            'customer_details'   => $customer_details,
             'customer_currency' =>isset($customer_details[0]['currency_type'])?$customer_details[0]['currency_type']:'',
            'customer_name' => isset($customer_details[0]['customer_name'])?$customer_details[0]['customer_name']:'',
            'customer_id'   => isset($customer_details[0]['customer_id'])?$customer_details[0]['customer_id']:'',
            'bank_list'     => $bank_list,
            'voucher_no' => $voucher_no,
                'tax_name'=>'ww',
                'packinglist'=>$sales_packing_list,
                'payment_type'  =>$paytype


        );


        $invoiceForm = $CI->parser->parse('invoice/add_invoice_form', $data, true);
       // $invoiceForm = $CI->parser->parse('invoice/profarma_invoice', $data, true);
        return $invoiceForm;
    }
  
    public function invoice_add_form1() {
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
        $curn_info_default = $CI->db->select('*')->from('currency_tbl')->where('icon',$currency_details[0]['currency'])->get()->result_array();
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
        $voucher_no = $CI->Invoices->commercial_inv_number();
        $data = array(

            'curn_info_default' =>$curn_info_default[0]['currency_name'],
            //  'curn_info_customer'=>$curn_info_customer[0]['currency_name'],
              'currency'  =>$currency_details[0]['currency'],
            'title'         => display('add_new_invoice'),
            'discount_type' => $currency_details[0]['discount_type'],
            'taxes'         => $taxfield,
            'tax'           => $taxfield1,
            'product'       =>$prodt,
            'customer_currency' =>isset($customer_details[0]['currency_type'])?$customer_details[0]['currency_type']:'',
            'customer_name' => isset($customer_details[0]['customer_name'])?$customer_details[0]['customer_name']:'',
            'customer_id'   => isset($customer_details[0]['customer_id'])?$customer_details[0]['customer_id']:'',
            'bank_list'     => $bank_list,
            'voucher_no' => $voucher_no,
                'tax_name'=>'ww',
        );
      //  $invoiceForm = $CI->parser->parse('invoice/add_invoice_form', $data, true);
        $invoiceForm = $CI->parser->parse('invoice/profarma_invoice', $data, true);
        return $invoiceForm;
    }

      //ocean_export_tracking_add_form
      public function ocean_export_tracking_add_form() {
        $CI = & get_instance();
        $CI->load->model('Invoices');
        $CI->load->model('Ppurchases');
        $CI->load->model('Web_settings');
        $all_supplier = $CI->Ppurchases->select_all_supplier();
        $customer_details = $CI->Invoices->pos_customer_setup();
        $currency_details = $CI->Web_settings->retrieve_setting_editdata();
        $taxfield = $CI->db->select('tax_name,default_value')->from('tax_settings')->get()->result_array();
        $bank_list          = $CI->Web_settings->bank_list();
        $data = array(
            'title'         => 'Add New Export Invoice',
            'discount_type' => $currency_details[0]['discount_type'],
            'taxes'         => $taxfield,
            'customer_name' => $CI->Invoices->pos_customer_setup(),
            'customer_id'   => isset($customer_details[0]['customer_id'])?$customer_details[0]['customer_id']:'',
            'bank_list'     => $bank_list,
               'all_supplier'  => $all_supplier
        );
        $invoiceForm = $CI->parser->parse('invoice/ocean_export_tracking', $data, true);
        return $invoiceForm;
    }

      //Invoice add form
    public function trucking_add_form() {
        $CI = & get_instance();
        $CI->load->model('Invoices');
        $CI->load->model('Accounts_model');
        $CI->load->model('Web_settings');
        $CI->load->model('Ppurchases');
        $all_supplier = $CI->Ppurchases->select_all_supplier_trucker();
        $customer_details = $CI->Invoices->pos_customer_setup();
        $get_customer= $CI->Accounts_model->get_customer();


        $pro_number = $CI->Invoices->pro_number();
        $voucher = $CI->Invoices->sale_trucking_voucher();
       // print_r($customer_details);
        $currency_details = $CI->Web_settings->retrieve_setting_editdata();
        $curn_info_default = $CI->db->select('*')->from('currency_tbl')->where('icon',$currency_details[0]['currency'])->get()->result_array();
        $taxfield = $CI->db->select('tax_name,default_value')->from('tax_settings')->get()->result_array();
        $taxfield1 = $CI->db->select('tax_id,tax')
        ->from('tax_information')
        ->get()
        ->result_array();
        $company_info = $CI->Invoices->company_information();
        $bank_list = $CI->Web_settings->bank_list();
        $data = array(
            'curn_info_default' =>$curn_info_default[0]['currency_name'],
            'currency'  =>$currency_details[0]['currency'],
            'title'         => 'Add New Trucking Invoice',
            'discount_type' => $currency_details[0]['discount_type'],
            'all_supplier'  => $all_supplier,
            'taxes'         => $taxfield,
            'tax'         => $taxfield1,
            'company_name' =>$company_info,
            'customer_name' => isset($customer_details[0]['customer_name'])?$customer_details[0]['customer_name']:'',
            'customer_id'   => isset($customer_details[0]['customer_id'])?$customer_details[0]['customer_id']:'',
            'bank_list'     => $bank_list,
            'customer_list' => $get_customer,

            'invoice'  => $pro_number,
          'voucher_no' => $voucher
        );

        $invoiceForm = $CI->parser->parse('invoice/trucking', $data, true);
        return $invoiceForm;
    }
    public function trucking_add_form1() {
        $CI = & get_instance();
        $CI->load->model('Invoices');
        $CI->load->model('Accounts_model');
        $CI->load->model('Web_settings');
        $CI->load->model('Ppurchases');
        $all_supplier = $CI->Ppurchases->select_all_supplier_trucker();
        $customer_details = $CI->Invoices->pos_customer_setup();
        $get_customer= $CI->Accounts_model->get_customer();
       // print_r($customer_details);
     
        $taxfield = $CI->db->select('tax_name,default_value')
                ->from('tax_settings')
                ->get()
                ->result_array();
        $bank_list          = $CI->Web_settings->bank_list();
        $data = array(
           
            'title'         => 'Add New Trucking Invoice',
            'discount_type' => $currency_details[0]['discount_type'],
                 'all_supplier'  => $all_supplier,
            'taxes'         => $taxfield,
            'customer_name' => isset($customer_details[0]['customer_name'])?$customer_details[0]['customer_name']:'',
            'customer_id'   => isset($customer_details[0]['customer_id'])?$customer_details[0]['customer_id']:'',
            'bank_list'     => $bank_list,
              'customer_list' => $get_customer
        );

        $invoiceForm = $CI->parser->parse('purchase/trucking', $data, true);
      
        return $invoiceForm;
    }

    public function profarma_invoice_add() {
        $CI = & get_instance();
        $CI->load->model('Invoices');
        $data = $CI->Invoices->profarma_invoice_customer();
       
        $profarma_customer = $CI->parser->parse('invoice/profarma_invoice', $data, true);

       // print_r($data); die;
        return $profarma_customer;
    }
    //Insert invoice
    public function insert_invoice($data) {
        $CI = & get_instance();
        $CI->load->model('Invoices');
        $CI->Invoices->invoice_entry($data);
        return true;
    }

    //Invoice Edit Data
    public function invoice_edit_data($invoice_id) {
        $CI = & get_instance();
        $CI->load->model('Invoices');
        $CI->load->model('Web_settings');
        $customer = $CI->Invoices->profarma_invoice_customer();
        $invoice_detail = $CI->Invoices->retrieve_invoice_editdata($invoice_id);
      
        //echo "<pre>"; print_r($invoice_detail); die;
        $bank_list      = $CI->Web_settings->bank_list();
        $taxinfo        = $CI->Invoices->service_invoice_taxinfo($invoice_id);
        $taxfield       = $CI->db->select('tax_name,default_value')
                ->from('tax_settings')
                ->get()
                ->result_array();
        $i = 0;
        //echo "<pre>";print_r($invoice_detail); die;

        if (!empty($invoice_detail)) {
            foreach ($invoice_detail as $k => $v) {
                $i++;
                $invoice_detail[$k]['sl'] = $i;
                $stock = $CI->Invoices->stock_qty_check($invoice_detail[$k]['product_id']);
                $invoice_detail[$k]['stock_qty'] = $stock + $invoice_detail[$k]['quantity'];
            }
        }

        $currency_details = $CI->Web_settings->retrieve_setting_editdata();
        $paytype=$CI->Invoices->payment_type();
        $curn_info_default = $CI->db->select('*')->from('currency_tbl')->where('icon',$currency_details[0]['currency'])->get()->result_array();
        $prodt = $CI->db->select('product_name,product_model,p_quantity')
        ->from('product_information')
        ->get()
        ->result_array();
        $taxfield1 = $CI->db->select('tax_id,tax')
        ->from('tax_information')
        ->get()
        ->result_array();
        $all_invoice = $CI->Invoices->all_invoice($invoice_id);
        $sales_packing_list = $CI->Invoices->sales_packing_list();
        $data = array(
            'customer'  => $customer,
            'curn_info_default' =>$curn_info_default[0]['currency_name'],
            'currency'  =>$currency_details[0]['currency'],
            'title'           => display('invoice_edit'),
            'invoice_id'      => $invoice_detail[0]['invoice_id'],
            'customer_id'     => $invoice_detail[0]['customer_id'],
            'customer_name'   => $invoice_detail[0]['customer_name'],
            'date'            => $invoice_detail[0]['date'],
            'commercial_invoice_number' => $invoice_detail[0]['commercial_invoice_number'],
            'billing_address' => $invoice_detail[0]['billing_address'],
            'container_no'=> $invoice_detail[0]['container_no'],
            'bl_no'=> $invoice_detail[0]['bl_no'],
            'product'       =>$prodt,
            'port_of_discharge' => $invoice_detail[0]['port_of_discharge'],
            'invoice_detail' => $invoice_detail[0]['invoice_details'],
            'invoice'         => $invoice_detail[0]['invoice'],
            'total_amount'    => $invoice_detail[0]['total_amount'],
            'paid_amount'     => $invoice_detail[0]['paid_amount'],
            'due_amount'      => $invoice_detail[0]['due_amount'],
            'invoice_discount'=> $invoice_detail[0]['invoice_discount'],
            'total_discount'  => $invoice_detail[0]['total_discount'],
            'unit'            => $invoice_detail[0]['unit'],
            'tax'             => $invoice_detail[0]['tax'],
            'payment_terms'             => $invoice_detail[0]['payment_terms'],
            'number_of_days'  =>$invoice_detail[0]['number_of_days'],
            'etd'  =>$invoice_detail[0]['etd'],
            'eta'  =>$invoice_detail[0]['eta'],
            'all_tax' =>$taxfield1,
            'payment_due_date' =>$invoice_detail[0]['payment_due_date'],
            'taxes'          => $taxfield,
            'prev_due'        => $invoice_detail[0]['prevous_due'],
            'net_total'       => $invoice_detail[0]['prevous_due'] + $invoice_detail[0]['total_amount'], 
            'shipping_cost'   => $invoice_detail[0]['shipping_cost'],
            'total_tax'       => $invoice_detail[0]['taxs'],
            'invoice_all_data'=> $invoice_detail,
            'taxvalu'         => $taxinfo,
            'payment_type'  =>$paytype,
            'all_invoice'=>$all_invoice,
            'quantity'=> $all_invoice[0]['quantity'],
            'rate'=> $all_invoice[0]['rate'],
            'ac_details'=> $all_invoice[0]['ac_details'],
            'remark'=> $all_invoice[0]['remark'],
            'total'=> $all_invoice[0]['total_price'],
            'tax_details'=> $all_invoice[0]['total_tax'],
            'etd'=> $all_invoice[0]['etd'],
            'eta'=> $all_invoice[0]['eta'],
            'gtotal'       => $all_invoice[0]['gtotal'],
            'discount_type'   => $currency_details[0]['discount_type'],
            'bank_list'       => $bank_list,
            'bank_id'         => $invoice_detail[0]['bank_id'],
            'paytype'         => $invoice_detail[0]['payment_type'],
            'packinglist'=>$sales_packing_list
        );
   
  
        $chapterList = $CI->parser->parse('invoice/edit_invoice_form', $data, true);
        return $chapterList;
    }


    public function profarma_edit_data($invoice_id) {
     
        $CI = & get_instance();

        $CI->load->model('Invoices');

        $CI->load->model('Suppliers');

        $CI->load->model('Web_settings');

         //$bank_list        = $CI->Web_settings->bank_list();

        $purchase_detail = $CI->Invoices->retrieve_profarma_invoice_editdata($invoice_id);
      
        // echo "<pre>";
     
        
        $customer_id = $purchase_detail[0]['customer_id'];

        // $supplier_list = $CI->Suppliers->supplier_list("110", "0");

        // $supplier_selected = $CI->Suppliers->supplier_search_item($supplier_id);



        if (!empty($purchase_detail)) {

            $i = 0;

            foreach ($purchase_detail as $k => $v) {

                $i++;

                $purchase_detail[$k]['sl'] = $i;

            }

        }

        $currency_details = $CI->Web_settings->retrieve_setting_editdata();
        $curn_info_default = $CI->db->select('*')->from('currency_tbl')->where('icon',$currency_details[0]['currency'])->get()->result_array();
      
        $customer = $CI->Invoices->profarma_invoice_customer();
        $taxfield1 = $CI->db->select('tax_id,tax')
        ->from('tax_information')
        ->get()
        ->result_array();

        $data = array(
            'customer'  => $customer,
           
            'curn_info_default' =>$curn_info_default[0]['currency_name'],
            'currency'  =>$currency_details[0]['currency'],

            'title'         => 'Edit Profarma Invoice',
            'tax' =>$taxfield1,

            'purchase_id'   => $purchase_detail[0]['purchase_id'],

            'chalan_no'     => $purchase_detail[0]['chalan_no'],
            
            'purchase_date'  => $purchase_detail[0]['purchase_date'],

            'billing_address'  => $purchase_detail[0]['billing_address'],

            'pre_carriage' => $purchase_detail[0]['pre_carriage'],

            'receipt'    =>  $purchase_detail[0]['receipt'],

            'country_goods'    =>  $purchase_detail[0]['country_goods'],

            'country_destination' =>  $purchase_detail[0]['country_destination'],

            'purchase_info' => $purchase_detail,

            'loading' =>  $purchase_detail[0]['loading'],

            'discharge'=>  $purchase_detail[0]['discharge'],

            'terms_payment'=>  $purchase_detail[0]['terms_payment'],

            'description_goods'=>  $purchase_detail[0]['description_goods'],

            'ac_details' =>  $purchase_detail[0]['ac_details'],

            'customer_name' => $purchase_detail[0]['customer_name'],

            'customer_id'   => $purchase_detail[0]['customer_id'],

            'total'         => number_format($purchase_detail[0]['total_amount'] + (!empty($purchase_detail[0]['total_discount'])?$purchase_detail[0]['total_discount']:0),2),

         

        );



        $chapterList = $CI->parser->parse('invoice/profarma_invoice_update', $data, true);

        return $chapterList;
    }    

    //Invoice html Data
    public function invoice_html_data($invoice_id) {
        // $CI = & get_instance();
        // $CI->load->model('Invoices');
        // $CI->load->model('Web_settings');
        // $CI->load->library('occational');
        // $CI->load->library('numbertowords');
        // $invoice_detail = $CI->Invoices->retrieve_invoice_html_data($invoice_id);
        // $taxfield = $CI->db->select('*')
        //         ->from('tax_settings')
        //         ->where('is_show',1)
        //         ->get()
        //         ->result_array();
        // $txregname ='';
        // foreach($taxfield as $txrgname){
        // $regname = $txrgname['tax_name'].' Reg No  - '.$txrgname['reg_no'].', ';
        // $txregname .= $regname;
        // }       
        // $subTotal_quantity = 0;
        // $subTotal_cartoon = 0;
        // $subTotal_discount = 0;
        // $subTotal_ammount = 0;
        // $descript = 0;
        // $isserial = 0;
        // $isunit = 0;
        // $is_discount = 0;
        // if (!empty($invoice_detail)) {
        //     foreach ($invoice_detail as $k => $v) {
        //         $invoice_detail[$k]['final_date'] = $CI->occational->dateConvert($invoice_detail[$k]['date']);
        //         $subTotal_quantity = $subTotal_quantity + $invoice_detail[$k]['quantity'];
        //         $subTotal_ammount = $subTotal_ammount + $invoice_detail[$k]['total_price'];
               
        //     }

        //     $i = 0;
        //     foreach ($invoice_detail as $k => $v) {
        //         $i++;
        //         $invoice_detail[$k]['sl'] = $i;
        //         if(!empty($invoice_detail[$k]['description'])){
        //             $descript = $descript+1;
                    
        //         }
        //          if(!empty($invoice_detail[$k]['serial_no'])){
        //             $isserial = $isserial+1;
                    
        //         }
        //          if(!empty($invoice_detail[$k]['discount_per'])){
        //             $is_discount = $is_discount+1;
                    
        //         }

        //         if(!empty($invoice_detail[$k]['unit'])){
        //             $isunit = $isunit+1;
                    
        //         }
   
        //     }
        // }

        // $currency_details = $CI->Web_settings->retrieve_setting_editdata();
        // $company_info = $CI->Invoices->retrieve_company();
        // // $totalbal = $invoice_detail[0]['total_amount']+$invoice_detail[0]['prevous_due'];
        // $totalbal = $invoice_detail[0]['total_amount']+0;
        // $amount_inword = $CI->numbertowords->convert_number($totalbal);
        // $user_id = $invoice_detail[0]['sales_by'];
        // $users = $CI->Invoices->user_invoice_data($user_id);
        // $data = array(
        // 'title'             => display('invoice_details'),
        // 'invoice_id'        => $invoice_detail[0]['invoice_id'],
        // 'invoice_no'        => $invoice_detail[0]['invoice'],
        // 'commercial_invoice_number' => $invoice_detail[0]['commercial_invoice_number'],
        // 'payment_due_date' =>$invoice_detail[0]['payment_due_date'],
        // 'payment_terms'=> $invoice_detail[0]['payment_terms'],
        // 'container_no'=> $invoice_detail[0]['container_no'],
        // 'customer_name'     => $invoice_detail[0]['customer_name'],
        // 'customer_address'  => $invoice_detail[0]['customer_address'],
        // 'customer_mobile'   => $invoice_detail[0]['customer_mobile'],
        // 'customer_email'    => $invoice_detail[0]['customer_email'],
        // 'final_date'        => $invoice_detail[0]['final_date'],
        // 'invoice_details'   => $invoice_detail[0]['invoice_details'],
        // 'total_amount'      => number_format($invoice_detail[0]['total_amount']+$invoice_detail[0]['prevous_due'], 2, '.', ','),
        // 'subTotal_quantity' => $subTotal_quantity,
        // 'total_discount'    => number_format($invoice_detail[0]['total_discount'], 2, '.', ','),
        // 'total_tax'         => number_format($invoice_detail[0]['total_tax'], 2, '.', ','),
        // 'subTotal_ammount'  => number_format($subTotal_ammount, 2, '.', ','),
        // 'paid_amount'       => number_format($invoice_detail[0]['paid_amount'], 2, '.', ','),
        // 'due_amount'        => number_format($invoice_detail[0]['due_amount'], 2, '.', ','),
        // 'previous'          => number_format($invoice_detail[0]['prevous_due'], 2, '.', ','),
        // 'shipping_cost'     => number_format($invoice_detail[0]['shipping_cost'], 2, '.', ','),
        // 'invoice_all_data'  => $invoice_detail,
        // 'company_info'      => $company_info,
        // 'currency'          => $currency_details[0]['currency'],
        // 'position'          => $currency_details[0]['currency_position'],
        // 'discount_type'     => $currency_details[0]['discount_type'],
        // 'am_inword'         => $amount_inword,
        // 'is_discount'       => $is_discount,
        // 'users_name'        => $users->first_name.' '.$users->last_name,
        // 'tax_regno'         => $txregname,
        // 'is_desc'           => $descript,
        // 'is_serial'         => $isserial,
        // 'is_unit'           => $isunit,
        // );

    $data=array();
    $data['ramji']=1;

        $chapterList = $CI->parser->parse('invoice/invoice_html', $data, true);
        return $chapterList;
    }


        //Invoice html Data manual
    public function invoice_html_data_manual($invoice_id) {
        $CI = & get_instance();
        $CI->load->model('Invoices');
        $CI->load->model('Web_settings');
        $CI->load->library('occational');
        $CI->load->library('numbertowords');
        $invoice_detail = $CI->Invoices->retrieve_invoice_html_data($invoice_id);
        $taxfield = $CI->db->select('*')
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
        if (!empty($invoice_detail)) {
            foreach ($invoice_detail as $k => $v) {
                $invoice_detail[$k]['final_date'] = $CI->occational->dateConvert($invoice_detail[$k]['date']);
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
                 if(!empty($invoice_detail[$k]['unit'])){
                    $isunit = $isunit+1;
                    
                }
   
            }
        }

        $currency_details = $CI->Web_settings->retrieve_setting_editdata();
        $company_info = $CI->Invoices->retrieve_company();
        $totalbal = $invoice_detail[0]['total_amount']+$invoice_detail[0]['prevous_due'];
        $amount_inword = $CI->numbertowords->convert_number($totalbal);
        $user_id = $invoice_detail[0]['sales_by'];
        $users = $CI->Invoices->user_invoice_data($user_id);
        $data = array(
        'title'             => display('invoice_details'),
        'invoice_id'        => $invoice_detail[0]['invoice_id'],
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
        'am_inword'         => $amount_inword,
        'is_discount'       => $invoice_detail[0]['total_discount']-$invoice_detail[0]['invoice_discount'],
        'users_name'        => $users->first_name.' '.$users->last_name,
        'tax_regno'         => $txregname,
        'is_desc'           => $descript,
        'is_serial'         => $isserial,
        'is_unit'           => $isunit,
        );

        $chapterList = $CI->parser->parse('invoice/invoice_html_manual', $data, true);
        return $chapterList;
    }

    //POS invoice html Data
    public function pos_invoice_html_data($invoice_id) {
        $CI = & get_instance();
        $CI->load->model('Invoices');
        $CI->load->model('Web_settings');
        $CI->load->library('occational');
        $invoice_detail = $CI->Invoices->retrieve_invoice_html_data($invoice_id);
         $taxfield = $CI->db->select('*')
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
                $invoice_detail[$k]['final_date'] = $CI->occational->dateConvert($invoice_detail[$k]['date']);
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

        $currency_details = $CI->Web_settings->retrieve_setting_editdata();
        $company_info = $CI->Invoices->retrieve_company();
        $totalbal = $invoice_detail[0]['total_amount']+$invoice_detail[0]['prevous_due'];
         $user_id = $invoice_detail[0]['sales_by'];
        $users = $CI->Invoices->user_invoice_data($user_id);
        $data = array(
        'title'                => display('invoice_details'),
        'invoice_id'           => $invoice_detail[0]['invoice_id'],
        'invoice_no'           => $invoice_detail[0]['invoice'],
        'customer_name'        => $invoice_detail[0]['customer_name'],
        'customer_address'     => $invoice_detail[0]['customer_address'],
        'customer_mobile'      => $invoice_detail[0]['customer_mobile'],
        'customer_email'       => $invoice_detail[0]['customer_email'],
        'final_date'           => $invoice_detail[0]['final_date'],
        'invoice_details'      => $invoice_detail[0]['invoice_details'],
        'total_amount'         => number_format($totalbal, 2, '.', ','),
        'subTotal_cartoon'     => $subTotal_cartoon,
        'subTotal_quantity'    => $subTotal_quantity,
        'invoice_discount'     => number_format($invoice_detail[0]['invoice_discount'], 2, '.', ','),
        'total_discount'       => number_format($invoice_detail[0]['total_discount'], 2, '.', ','),
        'total_tax'            => number_format($invoice_detail[0]['total_tax'], 2, '.', ','),
        'subTotal_ammount'     => number_format($subTotal_ammount, 2, '.', ','),
        'paid_amount'          => number_format($invoice_detail[0]['paid_amount'], 2, '.', ','),
        'due_amount'           => number_format($invoice_detail[0]['due_amount'], 2, '.', ','),
        'shipping_cost'        => number_format($invoice_detail[0]['shipping_cost'], 2, '.', ','),
        'invoice_all_data'     => $invoice_detail,
        'previous'             => number_format($invoice_detail[0]['prevous_due'], 2, '.', ','),
        'company_info'         => $company_info,
         'is_discount'         => $is_discount,
        'currency'             => $currency_details[0]['currency'],
        'position'             => $currency_details[0]['currency_position'],
        'users_name'           => $users->first_name.' '.$users->last_name,
        'tax_regno'            => $txregname,
        'is_desc'              => $descript,
        'is_serial'            => $isserial,
        'is_unit'              => $isunit,

        );

        $chapterList = $CI->parser->parse('invoice/pos_invoice_html', $data, true);
        return $chapterList;
    }

    /// Manual invoice insert data
    public function pos_invoice_html_data_manual($invoice_id,$url) {
        $CI = & get_instance();
        $CI->load->model('Invoices');
        $CI->load->model('Web_settings');
        $CI->load->library('occational');
        $invoice_detail = $CI->Invoices->retrieve_invoice_html_data($invoice_id);
         $taxfield = $CI->db->select('*')
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
        $is_discount = 0;
        $isunit = 0;
        if (!empty($invoice_detail)) {
            foreach ($invoice_detail as $k => $v) {
                $invoice_detail[$k]['final_date'] = $CI->occational->dateConvert($invoice_detail[$k]['date']);
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
                 if(!empty($invoice_detail[$k]['unit'])){
                    $isunit = $isunit+1;
                    
                }
                    if(!empty($invoice_detail[$k]['discount_per'])){
                    $is_discount = $is_discount+1;
                    
                }
            }
        }

        $currency_details = $CI->Web_settings->retrieve_setting_editdata();
        $company_info = $CI->Invoices->retrieve_company();
        $totalbal = $invoice_detail[0]['total_amount']+$invoice_detail[0]['prevous_due'];
         $user_id = $invoice_detail[0]['sales_by'];
        $users = $CI->Invoices->user_invoice_data($user_id);
        $data = array(
        'title'                => display('invoice_details'),
        'invoice_id'           => $invoice_detail[0]['invoice_id'],
        'invoice_no'           => $invoice_detail[0]['invoice'],
        'customer_name'        => $invoice_detail[0]['customer_name'],
        'customer_address'     => $invoice_detail[0]['customer_address'],
        'customer_mobile'      => $invoice_detail[0]['customer_mobile'],
        'customer_email'       => $invoice_detail[0]['customer_email'],
        'final_date'           => $invoice_detail[0]['final_date'],
        'invoice_details'      => $invoice_detail[0]['invoice_details'],
        'total_amount'         => number_format($totalbal, 2, '.', ','),
        'subTotal_cartoon'     => $subTotal_cartoon,
        'subTotal_quantity'    => $subTotal_quantity,
        'invoice_discount'     => number_format($invoice_detail[0]['invoice_discount'], 2, '.', ','),
        'total_discount'       => number_format($invoice_detail[0]['total_discount'], 2, '.', ','),
        'total_tax'            => number_format($invoice_detail[0]['total_tax'], 2, '.', ','),
        'subTotal_ammount'     => number_format($subTotal_ammount, 2, '.', ','),
        'paid_amount'          => number_format($invoice_detail[0]['paid_amount'], 2, '.', ','),
        'due_amount'           => number_format($invoice_detail[0]['due_amount'], 2, '.', ','),
        'shipping_cost'        => number_format($invoice_detail[0]['shipping_cost'], 2, '.', ','),
        'invoice_all_data'     => $invoice_detail,
        'previous'             => number_format($invoice_detail[0]['prevous_due'], 2, '.', ','),
        'company_info'         => $company_info,
         'is_discount'         => $is_discount,
        'currency'             => $currency_details[0]['currency'],
        'position'             => $currency_details[0]['currency_position'],
        'users_name'           => $users->first_name.' '.$users->last_name,
        'tax_regno'            => $txregname,
        'is_desc'              => $descript,
        'is_serial'            => $isserial,
        'is_unit'              => $isunit,
        'url'                  => $url,

        );

        $chapterList = $CI->parser->parse('invoice/pos_invoice_html_direct', $data, true);
        return $chapterList;
    }
    // min invoice data 
    public function min_invoice_html_data($invoice_id) {
        $CI = & get_instance();
        $CI->load->model('Invoices');
        $CI->load->model('Web_settings');
        $CI->load->library('occational');
        $CI->load->library('numbertowords');
        $invoice_detail = $CI->Invoices->retrieve_invoice_html_data($invoice_id);
         $taxfield = $CI->db->select('*')
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
        if (!empty($invoice_detail)) {
            foreach ($invoice_detail as $k => $v) {
                $invoice_detail[$k]['final_date'] = $CI->occational->dateConvert($invoice_detail[$k]['date']);
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
                 if(!empty($invoice_detail[$k]['unit'])){
                    $isunit = $isunit+1;
                    
                }
            }
        }

        $currency_details = $CI->Web_settings->retrieve_setting_editdata();
        $company_info = $CI->Invoices->retrieve_company();
         $totalbal = $invoice_detail[0]['total_amount']+$invoice_detail[0]['prevous_due'];
        $amount_inword = $CI->numbertowords->convert_number($totalbal);
        $user_id = $invoice_detail[0]['sales_by'];
        $users = $CI->Invoices->user_invoice_data($user_id);
        $data = array(
        'title'            => display('invoice_details'),
        'invoice_id'       => $invoice_detail[0]['invoice_id'],
        'invoice_no'       => $invoice_detail[0]['invoice'],
        'customer_name'    => $invoice_detail[0]['customer_name'],
        'customer_address' => $invoice_detail[0]['customer_address'],
        'customer_mobile'  => $invoice_detail[0]['customer_mobile'],
        'customer_email'   => $invoice_detail[0]['customer_email'],
        'final_date'       => $invoice_detail[0]['final_date'],
        'invoice_details'  => $invoice_detail[0]['invoice_details'],
        'total_amount'     => number_format($totalbal, 2, '.', ','),
        'subTotal_cartoon' => $subTotal_cartoon,
        'subTotal_quantity'=> $subTotal_quantity,
        'invoice_discount' => number_format($invoice_detail[0]['invoice_discount'], 2, '.', ','),
        'total_discount'   => number_format($invoice_detail[0]['total_discount'], 2, '.', ','),
        'total_tax'        => number_format($invoice_detail[0]['total_tax'], 2, '.', ','),
        'subTotal_ammount' => number_format($subTotal_ammount, 2, '.', ','),
        'paid_amount'      => number_format($invoice_detail[0]['paid_amount'], 2, '.', ','),
        'due_amount'       => number_format($invoice_detail[0]['due_amount'], 2, '.', ','),
         'shipping_cost'   => number_format($invoice_detail[0]['shipping_cost'], 2, '.', ','),
        'invoice_all_data' => $invoice_detail,
        'previous'         => number_format($invoice_detail[0]['prevous_due'], 2, '.', ','),
        'company_info'     => $company_info,
        'currency'         => $currency_details[0]['currency'],
        'logo'             => $currency_details[0]['logo'],
        'am_inword'        => $amount_inword,
        'is_discount'      => $invoice_detail[0]['total_discount']-$invoice_detail[0]['invoice_discount'],
        'position'         => $currency_details[0]['currency_position'],
        'users_name'       => $users->first_name.' '.$users->last_name,
        'tax_regno'        => $txregname,
        'is_desc'          => $descript,
        'is_serial'        => $isserial,
        'is_unit'          => $isunit,
        );

        $chapterList = $CI->parser->parse('invoice/min_invoice_html', $data, true);
        return $chapterList;
    }

}

?>