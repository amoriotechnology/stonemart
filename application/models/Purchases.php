<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Purchases extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    //Count purchase
    public function count_purchase() {
        $this->db->select('a.*,b.supplier_name');
        $this->db->from('product_purchase a');
        $this->db->join('supplier_information b', 'b.supplier_id = a.supplier_id');
         $this->db->where('a.create_by',$this->session->userdata('user_id'));
        $this->db->order_by('a.purchase_date', 'desc');
        $this->db->order_by('purchase_id', 'desc');
        $query = $this->db->get();

        $last_query = $this->db->last_query();
        if ($query->num_rows() > 0) {
            return $query->num_rows();
        }
        return false;
    }

    public function expense_package()
    {
        $sql='select * from expense_packing_list where create_by='.$_SESSION['user_id'];
        $query=$this->db->query($sql);
 if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;
    }

        //Count purchase
    public function count_purchase_order() {
        $this->db->select('*');
        $this->db->from('purchase_order');
  //  $this->db->join('supplier_information b', 'b.supplier_id = a.supplier_id');
       ////  $this->db->where('a.create_by',$this->session->userdata('user_id'));
//$this->db->order_by('a.purchase_date', 'desc');
     //   $this->db->order_by('purchase_id', 'desc');
        $query = $this->db->get();

        $last_query = $this->db->last_query();
        if ($query->num_rows() > 0) {
            return $query->num_rows();
        }
        return false;
    }

           //Count Ocean Import
    public function count_ocean_import() {
        $this->db->select('*');
        $this->db->from('ocean_import_tracking');
  //  $this->db->join('supplier_information b', 'b.supplier_id = a.supplier_id');
       ////  $this->db->where('a.create_by',$this->session->userdata('user_id'));
//$this->db->order_by('a.purchase_date', 'desc');
     //   $this->db->order_by('purchase_id', 'desc');
        $query = $this->db->get();

        $last_query = $this->db->last_query();
        if ($query->num_rows() > 0) {
            return $query->num_rows();
        }
        return false;
    }


               //Count Trucking
    public function count_trucking() {
        $this->db->select('*');
        $this->db->from('expense_trucking');
  //    $this->db->join('supplier_information b', 'b.supplier_id = a.supplier_id');
       ////  $this->db->where('a.create_by',$this->session->userdata('user_id'));
//$this->db->order_by('a.purchase_date', 'desc');
     //   $this->db->order_by('purchase_id', 'desc');
        $query = $this->db->get();

        $last_query = $this->db->last_query();
        if ($query->num_rows() > 0) {
            return $query->num_rows();
        }
        return false;
    }

    


     public function getPurchaseList($postData=null){
         $this->load->library('occational');
         $this->load->model('Web_settings');
         $currency_details = $this->Web_settings->retrieve_setting_editdata();
         $response = array();
         $fromdate = $this->input->post('fromdate');
         $todate   = $this->input->post('todate');
         if(!empty($fromdate)){
            $datbetween = "(a.purchase_date BETWEEN '$fromdate' AND '$todate')";
         }else{
            $datbetween = "";
         }
         ## Read value
         $draw = $postData['draw'];
         $start = $postData['start'];
         $rowperpage = $postData['length']; // Rows display per page
         $columnIndex = $postData['order'][0]['column']; // Column index
         $columnName = $postData['columns'][$columnIndex]['data']; // Column name
         $columnSortOrder = $postData['order'][0]['dir']; // asc or desc
         $searchValue = $postData['search']['value']; // Search value

         ## Search 
         $searchQuery = "";
         if($searchValue != ''){
            $searchQuery = " (b.supplier_name like '%".$searchValue."%' or a.chalan_no like '%".$searchValue."%' or a.purchase_date like'%".$searchValue."%')";
         }

         ## Total number of records without filtering
        $this->db->select('count(*) as allcount');
        $this->db->from('product_purchase a');
        $this->db->join('supplier_information b', 'b.supplier_id = a.supplier_id','left');
        $this->db->where('a.create_by',$this->session->userdata('user_id'));
          if(!empty($fromdate) && !empty($todate)){
             $this->db->where($datbetween);
         }
          if($searchValue != '')
          $this->db->where($searchQuery);
          
         $records = $this->db->get()->result();
         $totalRecords = $records[0]->allcount;

         ## Total number of record with filtering
         $this->db->select('count(*) as allcount');
        $this->db->from('product_purchase a');
        $this->db->join('supplier_information b', 'b.supplier_id = a.supplier_id','left');
        $this->db->where('a.create_by',$this->session->userdata('user_id'));
         if(!empty($fromdate) && !empty($todate)){
             $this->db->where($datbetween);
         }
         if($searchValue != '')
            $this->db->where($searchQuery);
          
         $records = $this->db->get()->result();
         $totalRecordwithFilter = $records[0]->allcount;

         ## Fetch records
        $this->db->select('a.*,b.supplier_name');
        $this->db->from('product_purchase a');
        $this->db->join('supplier_information b', 'b.supplier_id = a.supplier_id','left');
        $this->db->where('a.create_by',$this->session->userdata('user_id'));
          if(!empty($fromdate) && !empty($todate)){
             $this->db->where($datbetween);
         }
         if($searchValue != '')
         $this->db->where($searchQuery);
       
         $this->db->order_by($columnName, $columnSortOrder);
         $this->db->limit($rowperpage, $start);
         $records = $this->db->get()->result();
         $data = array();
         $sl =1;
         foreach($records as $record ){
          $button = '';
          $base_url = base_url();
          $jsaction = "return confirm('Are You Sure ?')";

           $button .='  <a href="'.$base_url.'Cpurchase/purchase_details_data/'.$record->purchase_id.'" class="btn btn-success btn-sm" data-toggle="tooltip" data-placement="left" title="'.display('purchase_details').'"><i class="fa fa-window-restore" aria-hidden="true"></i></a>';
      if($this->permission1->method('manage_purchase','update')->access()){
         $button .=' <a href="'.$base_url.'Cpurchase/purchase_update_form/'.$record->purchase_id.'" class="btn btn-info btn-sm" data-toggle="tooltip" data-placement="left" title="'. display('update').'"><i class="fa fa-pencil" aria-hidden="true"></i></a> ';
     }

     

         $purchase_ids ='<a href="'.$base_url.'Cpurchase/purchase_update_form/'.$record->purchase_id.'">'.$record->purchase_id.'</a>';
               
            $data[] = array( 
                'sl'               =>$sl,
                'chalan_no'        =>$record->chalan_no,
                 'etd'        =>$record->etd,
                  'eta'        =>$record->eta,
                'purchase_id'      =>$purchase_ids,
                'supplier_name'    =>$record->supplier_name,
                'purchase_date'    =>$this->occational->dateConvert($record->purchase_date),
                'total_amount'     =>$record->grand_total_amount,
                'button'           =>$button,
                
            ); 
            $sl++;
         }

         ## Response
         $response = array(
            "draw" => intval($draw),
            "iTotalRecords" => $totalRecordwithFilter,
            "iTotalDisplayRecords" => $totalRecords,
            "aaData" => $data
         );

         return $response; 
    }





       public function getPurchaseOrderList($postData=null){
         $this->load->library('occational');
         $this->load->model('Web_settings');
         $currency_details = $this->Web_settings->retrieve_setting_editdata();
         $response = array();
         $fromdate = $this->input->post('fromdate');
         $todate   = $this->input->post('todate');
         if(!empty($fromdate)){
            $datbetween = "(a.est_ship_date BETWEEN '$fromdate' AND '$todate')";
         }else{
            $datbetween = "";
         }
         ## Read value
         $draw = $postData['draw'];
         $start = $postData['start'];
         $rowperpage = $postData['length']; // Rows display per page
         $columnIndex = $postData['order'][0]['column']; // Column index
         $columnName = $postData['columns'][$columnIndex]['data']; // Column name
         $columnSortOrder = $postData['order'][0]['dir']; // asc or desc
         $searchValue = $postData['search']['value']; // Search value

         ## Search 
         $searchQuery = "";
         if($searchValue != ''){
            $searchQuery = " (b.supplier_name like '%".$searchValue."%' or a.chalan_no like '%".$searchValue."%' or a.purchase_date like'%".$searchValue."%')";
         }

        ## Total number of records without filtering
        $this->db->select('count(*) as allcount');
        $this->db->from('purchase_order a');
        $this->db->join('supplier_information b', 'b.supplier_id = a.supplier_id','left');
       // $this->db->where('a.create_by',$this->session->userdata('user_id'));
        if(!empty($fromdate) && !empty($todate)){
             $this->db->where($datbetween);
         }
          if($searchValue != '')
          $this->db->where($searchQuery);
          
         $records = $this->db->get()->result();
         $totalRecords = $records[0]->allcount;

         ## Total number of record with filtering
         $this->db->select('count(*) as allcount');
        $this->db->from('purchase_order a');
        $this->db->join('supplier_information b', 'b.supplier_id = a.supplier_id','left');
        $this->db->where('a.create_by',$this->session->userdata('user_id'));
         if(!empty($fromdate) && !empty($todate)){
             $this->db->where($datbetween);
         }
         if($searchValue != '')
            $this->db->where($searchQuery);
          
         $records = $this->db->get()->result();
         $totalRecordwithFilter = $records[0]->allcount;

         ## Fetch records
        $this->db->select('a.*,b.supplier_name');
        $this->db->from('purchase_order a');
        $this->db->join('supplier_information b', 'b.supplier_id = a.supplier_id','left');
        $this->db->where('a.create_by',$this->session->userdata('user_id'));
          if(!empty($fromdate) && !empty($todate)){
             $this->db->where($datbetween);
         }
         if($searchValue != '')
         $this->db->where($searchQuery);
       
         $this->db->order_by($columnName, $columnSortOrder);
         $this->db->limit($rowperpage, $start);
         $records = $this->db->get()->result();
         $data = array();
         $sl =1;
         foreach($records as $record ){
          $button = '';
          $base_url = base_url();
          $jsaction = "return confirm('Are You Sure ?')";

           $button .='  <a href="'.$base_url.'Cpurchase/purchase_order_details_data/'.$record->purchase_order_id.'" class="btn btn-success btn-sm" data-toggle="tooltip" data-placement="left" title="'.display('purchase_details').'"><i class="fa fa-window-restore" aria-hidden="true"></i></a>';
      if($this->permission1->method('manage_purchase','update')->access()){
         $button .=' <a href="'.$base_url.'Cpurchase/purchase_order_update_form/'.$record->purchase_order_id.'" class="btn btn-info btn-sm" data-toggle="tooltip" data-placement="left" title="'. display('update').'"><i class="fa fa-pencil" aria-hidden="true"></i></a> ';
     }

     

         $purchase_ids ='<a href="'.$base_url.'Cpurchase/purchase_order_update_form/'.$record->purchase_order_id.'">'.$record->purchase_order_id.'</a>';
               
               $data[] = array( 
                'sl'               =>$sl,
                'chalan_no'        =>$record->chalan_no,
                'etd'        =>$record->etd,
                'eta'        =>$record->eta,
                'purchase_id'      =>$purchase_ids,
                'supplier_name'    =>$record->supplier_name,
                'purchase_date'    =>$this->occational->dateConvert($record->purchase_date),
                'total_amount'     =>$record->grand_total_amount,
                'button'           =>$button,
                
            ); 
            $sl++;
         }

         ## Response
         $response = array(
            "draw" => intval($draw),
            "iTotalRecords" => $totalRecordwithFilter,
            "iTotalDisplayRecords" => $totalRecords,
            "aaData" => $data
         );

         return $response; 
    }



      public function getOceanImportList($postData=null){
         $this->load->library('occational');
         $this->load->model('Web_settings');
         $currency_details = $this->Web_settings->retrieve_setting_editdata();
         $response = array();
         $fromdate = $this->input->post('fromdate');
         $todate   = $this->input->post('todate');
         if(!empty($fromdate)){
            $datbetween = "(a.est_ship_date BETWEEN '$fromdate' AND '$todate')";
         }else{
            $datbetween = "";
         }
         ## Read value
         $draw = $postData['draw'];
         $start = $postData['start'];
         $rowperpage = $postData['length']; // Rows display per page
         $columnIndex = $postData['order'][0]['column']; // Column index
         $columnName = $postData['columns'][$columnIndex]['data']; // Column name
         $columnSortOrder = $postData['order'][0]['dir']; // asc or desc
         $searchValue = $postData['search']['value']; // Search value

         ## Search 
         $searchQuery = "";
         if($searchValue != ''){
            $searchQuery = " (b.supplier_name like '%".$searchValue."%' or a.chalan_no like '%".$searchValue."%' or a.purchase_date like'%".$searchValue."%')";
         }

        ## Total number of records without filtering
        $this->db->select('count(*) as allcount');
        $this->db->from('ocean_import_tracking a');
        $this->db->join('supplier_information b', 'b.supplier_id = a.supplier_id','left');
       // $this->db->where('a.create_by',$this->session->userdata('user_id'));
        if(!empty($fromdate) && !empty($todate)){
             $this->db->where($datbetween);
         }
          if($searchValue != '')
          $this->db->where($searchQuery);
          
         $records = $this->db->get()->result();
         $totalRecords = $records[0]->allcount;

         ## Total number of record with filtering
         $this->db->select('count(*) as allcount');
        $this->db->from('ocean_import_tracking a');
        $this->db->join('supplier_information b', 'b.supplier_id = a.supplier_id','left');
        $this->db->where('a.create_by',$this->session->userdata('user_id'));
         if(!empty($fromdate) && !empty($todate)){
             $this->db->where($datbetween);
         }
         if($searchValue != '')
            $this->db->where($searchQuery);
          
         $records = $this->db->get()->result();
         $totalRecordwithFilter = $records[0]->allcount;

         ## Fetch records
        $this->db->select('a.*,b.supplier_name');
        $this->db->from('ocean_import_tracking a');
        $this->db->join('supplier_information b', 'b.supplier_id = a.supplier_id','left');
        $this->db->where('a.create_by',$this->session->userdata('user_id'));
          if(!empty($fromdate) && !empty($todate)){
             $this->db->where($datbetween);
         }
         if($searchValue != '')
         $this->db->where($searchQuery);
       
         $this->db->order_by($columnName, $columnSortOrder);
         $this->db->limit($rowperpage, $start);
         $records = $this->db->get()->result();
         $data = array();
         $sl =1;
         foreach($records as $record ){
          $button = '';
          $base_url = base_url();
          $jsaction = "return confirm('Are You Sure ?')";

           $button .='  <a href="'.$base_url.'Cpurchase/ocean_import_tracking_details_data/'.$record->ocean_import_tracking_id.'" class="btn btn-success btn-sm" data-toggle="tooltip" data-placement="left" title="'.display('purchase_details').'"><i class="fa fa-window-restore" aria-hidden="true"></i></a>';
      if($this->permission1->method('manage_purchase','update')->access()){
         $button .=' <a href="'.$base_url.'Cpurchase/ocean_import_tracking_update_form/'.$record->ocean_import_tracking_id.'" class="btn btn-info btn-sm" data-toggle="tooltip" data-placement="left" title="'. display('update').'"><i class="fa fa-pencil" aria-hidden="true"></i></a> ';
     }

     

         $purchase_ids ='<a href="'.$base_url.'Cpurchase/ocean_import_tracking_update_form/'.$record->ocean_import_tracking_id.'">'.$record->ocean_import_tracking_id.'</a>';
               
               $data[] = array( 
                'sl'               =>$sl,
                'booking_no'        =>$record->booking_no,
                 'container_no'        =>$record->container_no,
                  'seal_no'        =>$record->seal_no,
                'ocean_import_tracking_id'      =>$purchase_ids,
                'supplier_name'    =>$record->supplier_name,
                'invoice_date'    =>$this->occational->dateConvert($record->invoice_date),
                'place_of_delivery'     =>$record->place_of_delivery,
                'button'           =>$button,
                
            ); 
            $sl++;
         }

         ## Response
         $response = array(
            "draw" => intval($draw),
            "iTotalRecords" => $totalRecordwithFilter,
            "iTotalDisplayRecords" => $totalRecords,
            "aaData" => $data
         );

         return $response; 
    }




        public function getTruckingList($postData=null){
         $this->load->library('occational');
         $this->load->model('Web_settings');
         $currency_details = $this->Web_settings->retrieve_setting_editdata();
         $response = array();
         $fromdate = $this->input->post('fromdate');
         $todate   = $this->input->post('todate');
         if(!empty($fromdate)){
            $datbetween = "(a.est_ship_date BETWEEN '$fromdate' AND '$todate')";
         }else{
            $datbetween = "";
         }
         ## Read value
         $draw = $postData['draw'];
         $start = $postData['start'];
         $rowperpage = $postData['length']; // Rows display per page
         $columnIndex = $postData['order'][0]['column']; // Column index
         $columnName = $postData['columns'][$columnIndex]['data']; // Column name
         $columnSortOrder = $postData['order'][0]['dir']; // asc or desc
         $searchValue = $postData['search']['value']; // Search value

         ## Search 
         $searchQuery = "";
         if($searchValue != ''){
            $searchQuery = " (b.supplier_name like '%".$searchValue."%' or a.chalan_no like '%".$searchValue."%' or a.purchase_date like'%".$searchValue."%')";
         }

        ## Total number of records without filtering
        $this->db->select('count(*) as allcount');
        $this->db->from('expense_trucking a');
        $this->db->join('customer_information b', 'b.customer_id = a.bill_to','left');
       // $this->db->where('a.create_by',$this->session->userdata('user_id'));
        if(!empty($fromdate) && !empty($todate)){
             $this->db->where($datbetween);
         }
          if($searchValue != '')
          $this->db->where($searchQuery);
          
         $records = $this->db->get()->result();
         $totalRecords = $records[0]->allcount;

         ## Total number of record with filtering
         $this->db->select('count(*) as allcount');
        $this->db->from('expense_trucking a');
         $this->db->join('customer_information b', 'b.customer_id = a.bill_to','left');
        $this->db->where('a.create_by',$this->session->userdata('user_id'));
         if(!empty($fromdate) && !empty($todate)){
             $this->db->where($datbetween);
         }
         if($searchValue != '')
            $this->db->where($searchQuery);
          
         $records = $this->db->get()->result();
         $totalRecordwithFilter = $records[0]->allcount;

         ## Fetch records
        $this->db->select('a.*,b.customer_name');
          $this->db->from('expense_trucking a');
         $this->db->join('customer_information b', 'b.customer_id = a.bill_to','left');
        $this->db->where('a.create_by',$this->session->userdata('user_id'));
          if(!empty($fromdate) && !empty($todate)){
             $this->db->where($datbetween);
         }
         if($searchValue != '')
         $this->db->where($searchQuery);
       
         $this->db->order_by($columnName, $columnSortOrder);
         $this->db->limit($rowperpage, $start);
         $records = $this->db->get()->result();
         $data = array();
         $sl =1;
         foreach($records as $record ){
          $button = '';
          $base_url = base_url();
          $jsaction = "return confirm('Are You Sure ?')";

           $button .='  <a href="'.$base_url.'Cpurchase/trucking_details_data/'.$record->trucking_id.'" class="btn btn-success btn-sm" data-toggle="tooltip" data-placement="left" title="'.display('purchase_details').'"><i class="fa fa-window-restore" aria-hidden="true"></i></a>';
      if($this->permission1->method('manage_purchase','update')->access()){
         $button .=' <a href="'.$base_url.'Cpurchase/trucking_update_form/'.$record->trucking_id.'" class="btn btn-info btn-sm" data-toggle="tooltip" data-placement="left" title="'. display('update').'"><i class="fa fa-pencil" aria-hidden="true"></i></a> ';
     }

     

         $purchase_ids ='<a href="'.$base_url.'Cpurchase/trucking_update_form/'.$record->trucking_id.'">'.$record->trucking_id.'</a>';
               
               $data[] = array( 
                'sl'               =>$sl,
                'invoice_no'        =>$record->invoice_no,
                'trucking_id'      =>$purchase_ids,
                'customer_name'    =>$record->customer_name,
                'container_pickup_date' => $record->container_pickup_date,
                'delivery_date' => $record->delivery_date,
                'invoice_date'    =>$this->occational->dateConvert($record->invoice_date),
                'shipment_company'     =>$record->shipment_company,
                'total' => $record->grand_total_amount,
                'button'           =>$button,
                
            ); 
            $sl++;
         }

         ## Response
         $response = array(
            "draw" => intval($draw),
            "iTotalRecords" => $totalRecordwithFilter,
            "iTotalDisplayRecords" => $totalRecords,
            "aaData" => $data
         );

         return $response; 
    }
    public function trucking($date=null) {
        if($date) {
$split = array_map(
 function($value) {
     return implode(' ', $value);
 },
 array_chunk(explode('-', $date), 3)
);


     $start = str_replace(' ', '-', $split[0]);
     $end = str_replace(' ', '-', $split[1]);
     $start = rtrim($start, "-");
     $end= preg_replace('/' . '-' . '/', '', $end, 1);
}
$query = '';
     $data = array();

     $records_per_page = 10;
     $start_from = 0;
     $current_page_number = 0;
     if(isset($_POST["rowCount"]))
     {
      $records_per_page = $_POST["rowCount"];
     }
     else
     {
      $records_per_page = 10;
     }
     if(isset($_POST["current"]))
     {
      $current_page_number = $_POST["current"];
     }
     else
     {
      $current_page_number = 1;
     }
     $start_from = ($current_page_number - 1) * $records_per_page;
     $this->db->select('a.*,b.customer_name');
     $this->db->from('expense_trucking a');
    $this->db->join('customer_information b', 'b.customer_id = a.bill_to','left');
   $this->db->where('a.create_by',$this->session->userdata('user_id'));

   



     if($date) {
      if(!empty($start) && !empty($end)){
         $this->db->where('a.invoice_date >=',$start);
     $this->db->where('a.invoice_date <=',$end);
      }
 
     }
    
     if(!empty($_POST["searchPhrase"]))
     {
      $query .= 'WHERE (a.invoice_no LIKE "%'.$_POST["searchPhrase"].'%" ';
      $query .= 'OR a.invoice_date LIKE "%'.$_POST["searchPhrase"].'%" ';
      $query .= 'OR a.bill_to LIKE "%'.$_POST["searchPhrase"].'%" ';
      $query .= 'OR b.customer_name LIKE "%'.$_POST["searchPhrase"].'%" ) ';
    
     }
     
     $order_by = '';
     if(isset($_POST["sort"]) && is_array($_POST["sort"]))
     {
      foreach($_POST["sort"] as $key => $value)
      {
       $order_by .= " $key $value, ";
      }
     }
     else
     {
     $query .= 'ORDER BY trucking_id DESC ';
     }
    // if($order_by != '')
   //  {
   //   $query .= ' ORDER BY ' . substr($order_by, 0, -2);
  //   }
     
     if($records_per_page != -1)
     {
      $query .= " LIMIT " . $start_from . ", " . $records_per_page;
     }
    
        $query = $this->db->get();
   //    echo $this->db->last_query();
    // $result = $this->db->query($query); 
    $result = $query->result_array();
    foreach($result as $row)
 {
     $data[] = $row;
 }
   
     
     
     $this->db->select('*');
  
     $this->db->from('expense_trucking');
     $query1 = $this->db->get();
     $result1 = $query1->result_array();
   
     $total_records = $query1->num_rows();
     $output = array(
  
      'rows'   => $data
     );
   return $output;
//  echo json_encode($output);

 }
        public function ocean_import($date=null) {
        if($date) {
$split = array_map(
 function($value) {
     return implode(' ', $value);
 },
 array_chunk(explode('-', $date), 3)
);


     $start = str_replace(' ', '-', $split[0]);
     $end = str_replace(' ', '-', $split[1]);
     $start = rtrim($start, "-");
     $end= preg_replace('/' . '-' . '/', '', $end, 1);
}
$query = '';
     $data = array();

     $records_per_page = 10;
     $start_from = 0;
     $current_page_number = 0;
     if(isset($_POST["rowCount"]))
     {
      $records_per_page = $_POST["rowCount"];
     }
     else
     {
      $records_per_page = 10;
     }
     if(isset($_POST["current"]))
     {
      $current_page_number = $_POST["current"];
     }
     else
     {
      $current_page_number = 1;
     }
     $start_from = ($current_page_number - 1) * $records_per_page;
     $this->db->select('a.*,b.supplier_name');
     $this->db->from('ocean_import_tracking a');
     $this->db->join('supplier_information b', 'b.supplier_id = a.supplier_id','left');
     $this->db->where('a.create_by',$this->session->userdata('user_id'));



     if($date) {
      if(!empty($start) && !empty($end)){
         $this->db->where('a.invoice_date >=',$start);
     $this->db->where('a.invoice_date <=',$end);
      }
 
     }
    
     if(!empty($_POST["searchPhrase"]))
     {
      $query .= 'WHERE (a.booking_no LIKE "%'.$_POST["searchPhrase"].'%" ';
      $query .= 'OR a.container_no LIKE "%'.$_POST["searchPhrase"].'%" ';
      $query .= 'OR a.seal_no LIKE "%'.$_POST["searchPhrase"].'%" ';
      $query .= 'OR b.supplier_name LIKE "%'.$_POST["searchPhrase"].'%" ) ';
    
     }
     
     $order_by = '';
     if(isset($_POST["sort"]) && is_array($_POST["sort"]))
     {
      foreach($_POST["sort"] as $key => $value)
      {
       $order_by .= " $key $value, ";
      }
     }
     else
     {
     $query .= 'ORDER BY ocean_import_tracking_id DESC ';
     }
    // if($order_by != '')
   //  {
   //   $query .= ' ORDER BY ' . substr($order_by, 0, -2);
  //   }
     
     if($records_per_page != -1)
     {
      $query .= " LIMIT " . $start_from . ", " . $records_per_page;
     }
    
        $query = $this->db->get();
   //    echo $this->db->last_query();
    // $result = $this->db->query($query); 
    $result = $query->result_array();
    foreach($result as $row)
 {
     $data[] = $row;
 }
   
     
     
     $this->db->select('*');
  
     $this->db->from('ocean_import_tracking');
     $query1 = $this->db->get();
     $result1 = $query1->result_array();
   
     $total_records = $query1->num_rows();
     $output = array(
  
      'rows'   => $data
     );
   return $output;
//  echo json_encode($output);

 }
    public function packing_list($date=null) {
        if($date) {
$split = array_map(
 function($value) {
     return implode(' ', $value);
 },
 array_chunk(explode('-', $date), 3)
);


     $start = str_replace(' ', '-', $split[0]);
     $end = str_replace(' ', '-', $split[1]);
     $start = rtrim($start, "-");
     $end= preg_replace('/' . '-' . '/', '', $end, 1);
}
$query = '';
     $data = array();

     $records_per_page = 10;
     $start_from = 0;
     $current_page_number = 0;
     if(isset($_POST["rowCount"]))
     {
      $records_per_page = $_POST["rowCount"];
     }
     else
     {
      $records_per_page = 10;
     }
     if(isset($_POST["current"]))
     {
      $current_page_number = $_POST["current"];
     }
     else
     {
      $current_page_number = 1;
     }
     $start_from = ($current_page_number - 1) * $records_per_page;

     $this->db->select('*');
     $this->db->from('expense_packing_list');
    $this->db->where('create_by',$this->session->userdata('user_id'));

     if($date) {
      if(!empty($start) && !empty($end)){
         $this->db->where('invoice_date >=',$start);
     $this->db->where('invoice_date <=',$end);
      }
 
     }
    
     if(!empty($_POST["searchPhrase"]))
     {
      $query .= 'WHERE (a.invoice_no LIKE "%'.$_POST["searchPhrase"].'%" ';
      $query .= 'OR invoice_date LIKE "%'.$_POST["searchPhrase"].'%" ';
      $query .= 'OR expense_packing_id LIKE "%'.$_POST["searchPhrase"].'%" ';
      $query .= 'OR grand_total_amount LIKE "%'.$_POST["searchPhrase"].'%" ) ';
    
     }
     
     $order_by = '';
     if(isset($_POST["sort"]) && is_array($_POST["sort"]))
     {
      foreach($_POST["sort"] as $key => $value)
      {
       $order_by .= " $key $value, ";
      }
     }
     else
     {
     $query .= 'ORDER BY expense_packing_id DESC ';
     }
    // if($order_by != '')
   //  {
   //   $query .= ' ORDER BY ' . substr($order_by, 0, -2);
  //   }
     
     if($records_per_page != -1)
     {
      $query .= " LIMIT " . $start_from . ", " . $records_per_page;
     }
    
        $query = $this->db->get();
   //    echo $this->db->last_query();
    // $result = $this->db->query($query); 
    $result = $query->result_array();
    foreach($result as $row)
 {
     $data[] = $row;
 }
   
     
     
     $this->db->select('*');
  
     $this->db->from('expense_packing_list');
     $query1 = $this->db->get();
     $result1 = $query1->result_array();
   
     $total_records = $query1->num_rows();
     $output = array(
  
      'rows'   => $data
     );
   return $output;
//  echo json_encode($output);

 }
    public function newexpense($date=null) {
        if($date) {
$split = array_map(
 function($value) {
     return implode(' ', $value);
 },
 array_chunk(explode('-', $date), 3)
);


     $start = str_replace(' ', '-', $split[0]);
     $end = str_replace(' ', '-', $split[1]);
     $start = rtrim($start, "-");
     $end= preg_replace('/' . '-' . '/', '', $end, 1);
}
$query = '';
     $data = array();

     $records_per_page = 10;
     $start_from = 0;
     $current_page_number = 0;
     if(isset($_POST["rowCount"]))
     {
      $records_per_page = $_POST["rowCount"];
     }
     else
     {
      $records_per_page = 10;
     }
     if(isset($_POST["current"]))
     {
      $current_page_number = $_POST["current"];
     }
     else
     {
      $current_page_number = 1;
     }
     $start_from = ($current_page_number - 1) * $records_per_page;
     $usertype = $this->session->userdata('user_type');
     $this->db->select('a.*,b.supplier_name');
     $this->db->from('product_purchase a');
     $this->db->join('supplier_information b', 'b.supplier_id = a.supplier_id');
     $this->db->where('a.create_by',$this->session->userdata('user_id'));

     if($date) {
      if(!empty($start) && !empty($end)){
         $this->db->where('a.purchase_date >=',$start);
     $this->db->where('a.purchase_date <=',$end);
      }
 
     }
    
     if(!empty($_POST["searchPhrase"]))
     {
      $query .= 'WHERE (a.chalan_no LIKE "%'.$_POST["searchPhrase"].'%" ';
      $query .= 'OR a.purchase_date LIKE "%'.$_POST["searchPhrase"].'%" ';
      $query .= 'OR b.supplier_name LIKE "%'.$_POST["searchPhrase"].'%" ';
      $query .= 'OR a.grand_total_amount LIKE "%'.$_POST["searchPhrase"].'%" ) ';
    
     }
     
     $order_by = '';
     if(isset($_POST["sort"]) && is_array($_POST["sort"]))
     {
      foreach($_POST["sort"] as $key => $value)
      {
       $order_by .= " $key $value, ";
      }
     }
     else
     {
     $query .= 'ORDER BY a.purchase_id DESC ';
     }
    // if($order_by != '')
   //  {
   //   $query .= ' ORDER BY ' . substr($order_by, 0, -2);
  //   }
     
     if($records_per_page != -1)
     {
      $query .= " LIMIT " . $start_from . ", " . $records_per_page;
     }
    
        $query = $this->db->get();
   //    echo $this->db->last_query();
    // $result = $this->db->query($query); 
    $result = $query->result_array();
    foreach($result as $row)
 {
     $data[] = $row;
 }
   
     
     
     $this->db->select('*');
  
     $this->db->from('product_purchase');
     $query1 = $this->db->get();
     $result1 = $query1->result_array();
   
     $total_records = $query1->num_rows();
     $output = array(
  
      'rows'   => $data
     );
   return $output;
//  echo json_encode($output);

 }

 public function purchase_order($date=null) {
    if($date) {
$split = array_map(
function($value) {
 return implode(' ', $value);
},
array_chunk(explode('-', $date), 3)
);


 $start = str_replace(' ', '-', $split[0]);
 $end = str_replace(' ', '-', $split[1]);
 $start = rtrim($start, "-");
 $end= preg_replace('/' . '-' . '/', '', $end, 1);
}
$query = '';
 $data = array();

 $records_per_page = 10;
 $start_from = 0;
 $current_page_number = 0;
 if(isset($_POST["rowCount"]))
 {
  $records_per_page = $_POST["rowCount"];
 }
 else
 {
  $records_per_page = 10;
 }
 if(isset($_POST["current"]))
 {
  $current_page_number = $_POST["current"];
 }
 else
 {
  $current_page_number = 1;
 }
 $start_from = ($current_page_number - 1) * $records_per_page;
 $this->db->select('po.*,si.* ,po.created_by AS create');
 $this->db->from('purchase_order po');
 $this->db->join('supplier_information si', 'po.supplier_id = si.supplier_id'); 
 $this->db->where('po.create_by',$this->session->userdata('user_id'));



 if($date) {
  if(!empty($start) && !empty($end)){
     $this->db->where('po.purchase_date >=',$start);
 $this->db->where('po.purchase_date <=',$end);
  }

 }

 if(!empty($_POST["searchPhrase"]))
 {
  $query .= 'WHERE (po.chalan_no LIKE "%'.$_POST["searchPhrase"].'%" ';
  $query .= 'OR po.purchase_date LIKE "%'.$_POST["searchPhrase"].'%" ';
  $query .= 'OR si.supplier_name LIKE "%'.$_POST["searchPhrase"].'%" ';
  $query .= 'OR a.grand_total_amount LIKE "%'.$_POST["searchPhrase"].'%" ) ';

 }
 
 $order_by = '';
 if(isset($_POST["sort"]) && is_array($_POST["sort"]))
 {
  foreach($_POST["sort"] as $key => $value)
  {
   $order_by .= " $key $value, ";
  }
 }
 else
 {
 $query .= 'ORDER BY po.purchase_order_id DESC ';
 }
// if($order_by != '')
//  {
//   $query .= ' ORDER BY ' . substr($order_by, 0, -2);
//   }
 
 if($records_per_page != -1)
 {
  $query .= " LIMIT " . $start_from . ", " . $records_per_page;
 }

    $query = $this->db->get();
 //  echo $this->db->last_query();
// $result = $this->db->query($query); 
$result = $query->result_array();
foreach($result as $row)
{
 $data[] = $row;
}

 
 
 $this->db->select('*');

 $this->db->from('purchase_order');
 $query1 = $this->db->get();
 $result1 = $query1->result_array();

 $total_records = $query1->num_rows();
 $output = array(

  'rows'   => $data
 );
return $output;
//  echo json_encode($output);

}
       public function getPackingList($postData=null){
         $this->load->library('occational');
         $this->load->model('Web_settings');
         $currency_details = $this->Web_settings->retrieve_setting_editdata();
         $response = array();
         $fromdate = $this->input->post('fromdate');
         $todate   = $this->input->post('todate');
         if(!empty($fromdate)){
            $datbetween = "(a.est_ship_date BETWEEN '$fromdate' AND '$todate')";
         }else{
            $datbetween = "";
         }
         ## Read value
         $draw = $postData['draw'];
         $start = $postData['start'];
         $rowperpage = $postData['length']; // Rows display per page
         $columnIndex = $postData['order'][0]['column']; // Column index
         $columnName = $postData['columns'][$columnIndex]['data']; // Column name
         $columnSortOrder = $postData['order'][0]['dir']; // asc or desc
         $searchValue = $postData['search']['value']; // Search value

         ## Search 
         $searchQuery = "";
         if($searchValue != ''){
            $searchQuery = " (b.supplier_name like '%".$searchValue."%' or a.chalan_no like '%".$searchValue."%' or a.purchase_date like'%".$searchValue."%')";
         }

        ## Total number of records without filtering
        $this->db->select('count(*) as allcount');
        $this->db->from('expense_packing_list');
     //   $this->db->join('customer_information b', 'b.customer_id = a.bill_to','left');
       // $this->db->where('a.create_by',$this->session->userdata('user_id'));
        if(!empty($fromdate) && !empty($todate)){
             $this->db->where($datbetween);
         }
          if($searchValue != '')
          $this->db->where($searchQuery);
          
         $records = $this->db->get()->result();
         $totalRecords = $records[0]->allcount;

         ## Total number of record with filtering
         $this->db->select('count(*) as allcount');
        $this->db->from('expense_packing_list');
        // $this->db->join('customer_information b', 'b.customer_id = a.bill_to','left');
        $this->db->where('create_by',$this->session->userdata('user_id'));
         if(!empty($fromdate) && !empty($todate)){
             $this->db->where($datbetween);
         }
         if($searchValue != '')
            $this->db->where($searchQuery);
          
         $records = $this->db->get()->result();
         $totalRecordwithFilter = $records[0]->allcount;

         ## Fetch records
        $this->db->select('*');
        $this->db->from('expense_packing_list');
         // $this->db->join('customer_information b', 'b.customer_id = a.bill_to','left');
        $this->db->where('create_by',$this->session->userdata('user_id'));
          if(!empty($fromdate) && !empty($todate)){
             $this->db->where($datbetween);
         }
         if($searchValue != '')
         $this->db->where($searchQuery);
       
         $this->db->order_by($columnName, $columnSortOrder);
         $this->db->limit($rowperpage, $start);
         $records = $this->db->get()->result();
         $data = array();
         $sl =1;
         foreach($records as $record ){
          $button = '';
          $base_url = base_url();
          $jsaction = "return confirm('Are You Sure ?')";
           
          $button .='  <a href="'.$base_url.'Cpurchase/packing_list_details_data/'.$record->expense_packing_id.'" class="btn btn-success btn-sm" data-toggle="tooltip" data-placement="left" title="Packing Download"><i class="fa fa-window-restore" aria-hidden="true"></i></a>';

           $button .='  <a href="'.$base_url.'Cpurchase/packing_list_details_data/'.$record->expense_packing_id.'" class="btn btn-success btn-sm" data-toggle="tooltip" data-placement="left" title="Packing List Detail"><i class="fa fa-window-restore" aria-hidden="true"></i></a>';
              if($this->permission1->method('manage_purchase','update')->access()){
                 $button .=' <a href="'.$base_url.'Cpurchase/packing_list_update_form/'.$record->expense_packing_id.'" class="btn btn-info btn-sm" data-toggle="tooltip" data-placement="left" title="'. display('update').'"><i class="fa fa-pencil" aria-hidden="true"></i></a> ';
             }

     

         $purchase_ids ='<a href="'.$base_url.'Cpurchase/packing_details_data/'.$record->expense_packing_id.'">'.$record->expense_packing_id.'</a>';
               
               $data[] = array(
                'sl'               =>$sl,
                'invoice_no'        =>$record->invoice_no,
                'expense_packing_id'  =>$purchase_ids,
                'gross_weight' => $record->gross_weight,
                'container_no' => $record->container_no,
                'invoice_date'    =>$record->invoice_date,
                // 'invoice_date'    =>$this->occational->dateConvert($record->invoice_date),
                'total' => $record->grand_total_amount,
                'thickness' => $record->thickness,
                'button'           =>$button,
                
            ); 
            $sl++;
         }

         ## Response
         $response = array(
            "draw" => intval($draw),
            "iTotalRecords" => $totalRecordwithFilter,
            "iTotalDisplayRecords" => $totalRecords,
            "aaData" => $data
         );

         return $response; 
    }


    //purchase List
    public function purchase_list($per_page, $page) {
        $this->db->select('a.*,b.supplier_name');
        $this->db->from('product_purchase a');
        $this->db->join('supplier_information b', 'b.supplier_id = a.supplier_id');
        $this->db->where('a.create_by',$this->session->userdata('user_id'));
        $this->db->order_by('a.purchase_date', 'desc');
        $this->db->order_by('purchase_id', 'desc');
        $this->db->limit($per_page, $page);
        $query = $this->db->get();

        $last_query = $this->db->last_query();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;
    }

    // purchase search by suppplier
    public function purchase_search($supplier_id, $per_page, $page) {
        $this->db->select('a.*,b.supplier_name');
        $this->db->from('product_purchase a');
        $this->db->join('supplier_information b', 'b.supplier_id = a.supplier_id');
        $this->db->where('a.create_by',$this->session->userdata('user_id'));
        $this->db->where('a.supplier_id', $supplier_id);
        $this->db->order_by('a.purchase_date', 'desc');
        $this->db->limit($per_page, $page);
        $query = $this->db->get();

        $last_query = $this->db->last_query();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;
    }




    // purchase search count
    public function count_purchase_seach($supplier_id) {
        $this->db->select('a.*,b.supplier_name');
        $this->db->from('product_purchase a');
        $this->db->join('supplier_information b', 'b.supplier_id = a.supplier_id');
        $this->db->where('a.create_by',$this->session->userdata('user_id'));
        $this->db->where('a.supplier_id', $supplier_id);
        $query = $this->db->get();

        $last_query = $this->db->last_query();
        if ($query->num_rows() > 0) {
            return $query->num_rows();
        }
        return false;
    }

//purchase info by invoice id
    public function purchase_list_invoice_id($invoice_no) {
        $this->db->select('a.*,b.supplier_name');
        $this->db->from('product_purchase a');
        $this->db->join('supplier_information b', 'b.supplier_id = a.supplier_id');
        $this->db->where('a.create_by',$this->session->userdata('user_id'));
        $this->db->where('a.chalan_no', $invoice_no);
        $this->db->order_by('a.purchase_date', 'desc');
        $this->db->order_by('purchase_id', 'desc');
        $query = $this->db->get();

        $last_query = $this->db->last_query();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;
    }
  //  $this->db->select('*')->from('supplier_information')->where('supplier_id',$supplier_id)->get()->row();
    //Select All Supplier List
    public function select_all_supplier() {
        $query = $this->db->select('*')
                ->from('supplier_information')
                ->where('created_by',$this->session->userdata('user_id'))
                ->where('status', '1')
                ->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;
    }
    public function select_supplier($value) {
        $query = $this->db->select('*')
                ->from('supplier_information')
                ->where('created_by',$this->session->userdata('user_id'))
                ->where('supplier_id',$value)
                ->where('status', '1')
                ->get();
             
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
      
    }
    public function select_supplierbyname($value) {
        $query = $this->db->select('*')
                ->from('supplier_information')
                ->where('created_by',$this->session->userdata('user_id'))
                ->where('supplier_name',$value)
                ->where('status', '1')
                ->get();
             
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
      
    }
    //purchase Search  List
    public function purchase_by_search($supplier_id) {
        $this->db->select('a.*,b.supplier_name');
        $this->db->from('product_purchase a');
        $this->db->join('supplier_information b', 'b.supplier_id = a.supplier_id');
        $this->db->where('a.create_by',$this->session->userdata('user_id'));
        $this->db->where('b.supplier_id', $supplier_id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;
    }

    //Count purchase
    public function purchase_entry() {
        $purchase_id = date('YmdHis');
        $chalan_no =$this->input->post('chalan',TRUE);
        $p_id = $this->input->post('product_id',TRUE);
        $supplier_id = $this->input->post('supplier_id',TRUE);
        $supinfo =$this->db->select('*')->from('supplier_information')->where('supplier_id',$supplier_id)->get()->row();
        $sup_head = $supinfo->supplier_id.'-'.$supinfo->supplier_name;
        $sup_coa = $this->db->select('*')->from('acc_coa')->where('HeadName',$sup_head)->get()->row();
        $receive_by=$this->session->userdata('user_id');
        $receive_date=date('Y-m-d');
        $createdate=date('Y-m-d H:i:s');
        $paid_amount = $this->input->post('paid_amount',TRUE);
        $due_amount = $this->input->post('due_amount',TRUE);



        $discount = $this->input->post('discount',TRUE);
          $bank_id = $this->input->post('bank_id',TRUE);
        if(!empty($bank_id)){
         $bankname = $this->db->select('bank_name')->from('bank_add')->where('bank_id',$bank_id)->get()->row()->bank_name;
      
         $bankcoaid = $this->db->select('HeadCode')->from('acc_coa')->where('HeadName',$bankname)->get()->row()->HeadCode;
       }else{
           $bankcoaid = '';
       }


       if(!empty($_FILES['attachments']['name'])){
        $config['upload_path'] = 'my-assets/productnewimg/';
        $config['allowed_types'] = 'jpg|jpeg|png|gif';
        $config['file_name'] = $_FILES['attachments']['name'];
        
        //Load upload library and initialize here configuration
        $this->load->library('upload',$config);
        $this->upload->initialize($config);
        
        if($this->upload->do_upload('attachments')){
            $uploadData = $this->upload->data();
            $profile_img = $uploadData['file_name'];
        }else{
            $profile_img = '';
        }
    }else{
        $profile_img = '';
    }






        //supplier & product id relation ship checker.
        for ($i = 0, $n = count($p_id); $i < $n; $i++) {
            $product_id = $p_id[$i];
            $value = $this->product_supplier_check($product_id, $supplier_id);
            if ($value == 0) {
                $this->session->set_flashdata('message', display('product_and_supplier_did_not_match'));
              //  redirect(base_url('Cpurchase/'));
               
            }
        }
      
        $data = array(
            'purchase_id'        => $purchase_id,
            'create_by'       =>  $this->session->userdata('user_id'),
            'chalan_no'          => $this->input->post('chalan',TRUE),
            'supplier_id'        => $this->input->post('supplier_id',TRUE),
            'total' => $this->input->post('total',TRUE),
            'grand_total_amount' => $this->input->post('gtotal',TRUE),
            // 'grand_total_amount' => $this->input->post('grand_total_price',TRUE),
            'total_discount'     => $this->input->post('discount',TRUE),
            'purchase_date'      => $this->input->post('bill_date',TRUE),
            'purchase_details'   => $this->input->post('purchase_details',TRUE),
            'payment_due_date'   => $this->input->post('payment_due_date',TRUE),
            'remarks'            => $this->input->post('remark',TRUE),
            'message_invoice'    => $this->input->post('message_invoice',TRUE),
            'total_tax'  =>  $this->input->post('tax_details',TRUE),
            'packing_id' => $this->input->post('packing_id',TRUE),
            'etd'   => $this->input->post('etd',TRUE),
            'eta'   => $this->input->post('eta',TRUE),
           
            'gtotal_preferred_currency'  => $this->input->post('vendor_gtotal',TRUE),
            'shipping_line'   => $this->input->post('shipping_line',TRUE),
            'container_no'   => $this->input->post('container_no',TRUE),
            'bl_number'   => $this->input->post('bl_number',TRUE),
            'isf_filling'   => $this->input->post('isf_no',TRUE),
            'paid_amount'    => $this->input->post('amount_paid',TRUE),
            'balance'    => $this->input->post('balance',TRUE),
            'payment_id'    => $this->input->post('payment_id',TRUE),
            'status'             => 1,
            'bank_id'            =>  $this->input->post('bank_id',TRUE),

            'packing_id'            =>  $this->input->post('packing_id',TRUE),


            'payment_type'       =>  $this->input->post('paytype',TRUE),
             'image'              =>  $profile_img,
        );

        $purchase_id_1 = $this->db->where('chalan_no',$this->input->post('chalan',TRUE));
        $q=$this->db->get('product_purchase');
        $row = $q->row_array();
      
    if(!empty($row['purchase_id'])){
      
        $this->session->set_userdata("purchase_1",$row['purchase_id']);
       
   $this->db->where('purchase_id', $this->session->userdata("purchase_1"));
  $this->db->delete('product_purchase');

        $this->db->insert('product_purchase', $data);


   }   
    else{
        //die("else part");
    $this->db->insert('product_purchase', $data);


  
    }
    $purchase_id_2 = $this->db->select('purchase_id')->from('product_purchase')->where('chalan_no',$this->input->post('chalan',TRUE))->get()->row()->purchase_id;
      $this->session->set_userdata("purchase_2",$purchase_id_2);
    $purchasecoatran = array(
          'VNo'            =>  $purchase_id,
          'Vtype'          =>  'Purchase',
          'VDate'          =>  $this->input->post('purchase_date',TRUE),
          'COAID'          =>  $sup_coa->HeadCode,
          'Narration'      =>  'Supplier .'.$supinfo->supplier_name,
          'Debit'          =>  0,
          'Credit'         =>  $this->input->post('grand_total_price',TRUE),
          'IsPosted'       =>  1,
          'CreateBy'       =>  $receive_by,
          'CreateDate'     =>  $receive_date,
          'IsAppove'       =>  1
        ); 
          ///Inventory Debit
       $coscr = array(
      'VNo'            =>  $purchase_id,
      'Vtype'          =>  'Purchase',
      'VDate'          =>  $this->input->post('purchase_date',TRUE),
      'COAID'          =>  10107,
      'Narration'      =>  'Inventory Debit For Supplier '.$supinfo->supplier_name,
      'Debit'          =>  $this->input->post('grand_total_price',TRUE),
      'Credit'         =>  0,//purchase price asbe
      'IsPosted'       => 1,
      'CreateBy'       => $receive_by,
      'CreateDate'     => $createdate,
      'IsAppove'       => 1
    ); 



       // Expense for company
         $expense = array(
      'VNo'            => $purchase_id,
      'Vtype'          => 'Purchase',
      'VDate'          => $this->input->post('purchase_date',TRUE),
      'COAID'          => 402,
      'Narration'      => 'Company Credit For  '.$supinfo->supplier_name,
      'Debit'          => $this->input->post('grand_total_price',TRUE),
      'Credit'         => 0,//purchase price asbe
      'IsPosted'       => 1,
      'CreateBy'       => $receive_by,
      'CreateDate'     => $createdate,
      'IsAppove'       => 1
    ); 
             $cashinhand = array(
      'VNo'            =>  $purchase_id,
      'Vtype'          =>  'Purchase',
      'VDate'          =>  $this->input->post('purchase_date',TRUE),
      'COAID'          =>  1020101,
      'Narration'      =>  'Cash in Hand For Supplier '.$supinfo->supplier_name,
      'Debit'          =>  0,
      'Credit'         =>  $paid_amount,
      'IsPosted'       =>  1,
      'CreateBy'       =>  $receive_by,
      'CreateDate'     =>  $createdate,
      'IsAppove'       =>  1
    ); 

     $supplierdebit = array(
          'VNo'            =>  $purchase_id,
          'Vtype'          =>  'Purchase',
          'VDate'          =>  $this->input->post('purchase_date',TRUE),
          'COAID'          =>  $sup_coa->HeadCode,
          'Narration'      =>  'Supplier .'.$supinfo->supplier_name,
          'Debit'          =>  $paid_amount,
          'Credit'         =>  0,
          'IsPosted'       =>  1,
          'CreateBy'       =>  $receive_by,
          'CreateDate'     =>  $receive_date,
          'IsAppove'       =>  1
        ); 
             
                  // bank ledger
 $bankc = array(
      'VNo'            =>  $purchase_id,
      'Vtype'          =>  'Purchase',
      'VDate'          =>  $this->input->post('purchase_date',TRUE),
      'COAID'          =>  $bankcoaid,
      'Narration'      =>  'Paid amount for Supplier  '.$supinfo->supplier_name,
      'Debit'          =>  0,
      'Credit'         =>  $paid_amount,
      'IsPosted'       =>  1,
      'CreateBy'       =>  $receive_by,
      'CreateDate'     =>  $createdate,
      'IsAppove'       =>  1
    ); 
 // Bank summary for credit

       //new end


        
       
       
        $this->db->insert('acc_transaction',$coscr);
        $this->db->insert('acc_transaction',$purchasecoatran);  
        $this->db->insert('acc_transaction',$expense);
        if($this->input->post('paytype') == 2){
          if(!empty($paid_amount)){
        $this->db->insert('acc_transaction',$bankc);
       
        $this->db->insert('acc_transaction',$supplierdebit);
      }
        }
        if($this->input->post('paytype') == 1){
          if(!empty($paid_amount)){
        $this->db->insert('acc_transaction',$cashinhand);
        $this->db->insert('acc_transaction',$supplierdebit); 
        }    
        }       

         $description = $this->input->post('description',TRUE);
        $rate = $this->input->post('product_rate',TRUE);
        $quantity = $this->input->post('product_quantity',TRUE);
        $t_price = $this->input->post('total_price',TRUE);
        $discount = $this->input->post('discount',TRUE);
      

        for ($i = 0, $n = count($p_id); $i < $n; $i++) {
            $product_quantity = $quantity[$i];
            $product_rate = $rate[$i];
            $product_id = $p_id[$i];
            $total_price = $t_price[$i];
            $desc = $description[$i];
            // $disc = $discount[$i];

            $data1 = array(
                'purchase_detail_id' => $this->generator(15),
                'purchase_id'        => $this->session->userdata("purchase_2"),
                'product_id'         => $product_id,
              
                'quantity'           => $product_quantity,
                'rate'               => $product_rate,
                'total_amount'       => $total_price,
                'description'       => $desc,
                'discount'           => 0,
                'create_by'          =>  $this->session->userdata('user_id'),
                'status'             => 1
            );

           
          
            $this->db->insert('product_purchase_details', $data1);
          
            
        }
                $this->db->where('purchase_id', $this->session->userdata("purchase_1"));

        $this->db->delete('product_purchase_details');
        
        return $purchase_id."/".$chalan_no;
       
    }

    public function get_expense_product()
    {
        $this->db->select('a.*,b.*');
        $this->db->from('product_purchase a');
        $this->db->join('product_purchase_details b', 'b.purchase_id = a.purchase_id');
        $this->db->where('a.create_by',$this->session->userdata('user_id'));
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
    }
    public function get_purchase_product()
    {
        $this->db->select('a.*,b.*');
        $this->db->from('purchase_order a');
        $this->db->join('purchase_order_details b', 'b.purchase_order_detail_id = a.purchase_order_id');
        $this->db->where('a.create_by',$this->session->userdata('user_id'));
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
    }

       //packing_list_entry
    public function packing_list_entry() {
       
        $purchase_id  = date('YmdHis');
        $invoice_no =$this->input->post('invoice_no',TRUE);
        $p_id = $this->input->post('product_id',TRUE);
     $receive_by=$this->session->userdata('user_id');
        $receive_date=date('Y-m-d');
        $createdate=date('Y-m-d H:i:s');
        $paid_amount = $this->input->post('paid_amount',TRUE);
        $due_amount = $this->input->post('due_amount',TRUE);
        $discount = $this->input->post('discount',TRUE);
          $bank_id = $this->input->post('bank_id',TRUE);
        if(!empty($bank_id)){
         $bankname = $this->db->select('bank_name')->from('bank_add')->where('bank_id',$bank_id)->get()->row()->bank_name;
      
         $bankcoaid = $this->db->select('HeadCode')->from('acc_coa')->where('HeadName',$bankname)->get()->row()->HeadCode;
        }else
        {
               $bankcoaid = '';
        }
        $data = array(
            'expense_packing_id'        => $purchase_id,
            'create_by'       =>  $this->session->userdata('user_id'),
            'invoice_no'          => $this->input->post('invoice_no',TRUE),
            'invoice_date'        => $this->input->post('invoice_date',TRUE),
            'gross_weight' => $this->input->post('gross_weight',TRUE),
            'remarks' => $this->input->post('remarks',TRUE),
           'container_no'     => $this->input->post('container_no',TRUE),
            'grand_total_amount'      => $this->input->post('total',TRUE),
            'thickness'   =>$this->input->post('thickness',TRUE),
            'status'             => 1,
        );
        $purchase_id_1 = $this->db->where('invoice_no',$this->input->post('invoice_no',TRUE));
        $q=$this->db->get('expense_packing_list');
        $row = $q->row_array();
    if(!empty($row['expense_packing_id'])){
   //  echo $row['expense_packing_id'];
        $this->session->set_userdata("packing_1",$row['expense_packing_id']);
      
        $this->db->where('invoice_no',$this->input->post('invoice_no',TRUE));
 
        $this->db->delete('expense_packing_list');
      // echo $this->db->last_query();echo "<br/>";
        $this->db->insert('expense_packing_list', $data);
     //  echo $this->db->last_query();echo "<br/>";
   }   
    else{
    $this->db->insert('expense_packing_list', $data);
    
   //echo $this->db->last_query();echo "<br/>";
    }
      
    $purchase_id = $this->db->select('expense_packing_id')->from('expense_packing_list')->where('invoice_no',$this->input->post('invoice_no',TRUE))->get()->row()->expense_packing_id;

       $this->session->set_userdata("packing_2",$purchase_id);

  if($this->input->post('paytype') == 2){
          if(!empty($paid_amount)){
        $this->db->insert('acc_transaction',$bankc);
       
        $this->db->insert('acc_transaction',$supplierdebit);
      }
        }
        if($this->input->post('paytype') == 1){
          if(!empty($paid_amount)){
        $this->db->insert('acc_transaction',$cashinhand);
        $this->db->insert('acc_transaction',$supplierdebit); 
        }    
        }    

        $serial_number = $this->input->post('serial_number',TRUE);
        $bun_ref = $this->input->post('bun_ref',TRUE);
        $product_name =$this->input->post('product_name',TRUE);
        $bundle_no = $this->input->post('bundle_no',TRUE);
        $quantity = $this->input->post('quantity',TRUE);

        $q_per_bundle=$this->input->post('q_per_bundle',TRUE);
        $q_per_package=$this->input->post('q_per_package',TRUE);
        

        $rate = $this->input->post('rate',TRUE);
        $total_price =$this->input->post('total_price',TRUE);
      //  $bundle = $this->input->post('bundle',TRUE);
        $p_id1 = $this->input->post('product_id',TRUE);
        $rowCount = count($this->input->post('product_name',TRUE));
        $this->db->where('expense_packing_id', $this->session->userdata("packing_1"));
        $this->db->delete('expense_packing_list_detail');
     //   echo $this->db->last_query();echo "<br/>";
        for ($i = 0; $i < $rowCount; $i++) {
            $serial = $serial_number[$i];
            $bun_reff = $bun_ref[$i];
            $p_name=$product_name[$i];
            $b_no =$bundle_no[$i];

            $qnty_bundle =$q_per_bundle[$i];

            $qnty_package=$q_per_package[$i];


            $p_id =$p_id1[$i];
           
          //  $bundlee =$bundle[$i];
            $rte = $rate[$i];
            $t_price = $total_price[$i];
      
            $data1 = array(
             
                'expense_packing_detail_id' => $this->generator(15),
                'expense_packing_id'        =>$this->session->userdata("packing_2"),
                'serial_no'         => $serial,
                'bundle_ref'               => $bun_reff,
               'product_name' =>$p_name,
                'product_id' => $p_id,
                'no_of_bundle' => $b_no,
                
                'quantity_per_bundle'  => $qnty_bundle,
                'quantity_per_package'   => $qnty_package,
                'rate' => $rte,
                'total_price' => $t_price,
                'create_by'          =>  $this->session->userdata('user_id'),
                'status'             => 1
            );
       
        
//$this->db->where('expense_packing_id',$this->session->userdata('sale_p_2'));
//  echo $this->db->last_query();echo "<br/>";
//$this->db->delete('sale_packing_list_detail');
$this->db->insert('expense_packing_list_detail', $data1);
//echo $this->db->last_query();echo "<br/>";

    }

           
         //   $this->db->where('expense_packing_id', $this->session->userdata("packing_1"));
 
         //   $this->db->delete('expense_packing_list_detail');
         //   $this->db->insert('expense_packing_list_detail', $data1);



           
            
       // }
        return $purchase_id."/".$invoice_no;
       
    }




     //Purchase Order Entry
     /*
     public function purchase_order_entry() {
        $purchase_id = date('YmdHis');
$chalan_no =$this->input->post('chalan_no',TRUE);
        $p_id = $this->input->post('product_id',TRUE);
        $supplier_id = $this->input->post('supplier_id',TRUE);
        $supinfo =$this->db->select('*')->from('supplier_information')->where('supplier_id',$supplier_id)->get()->row();
        $sup_head = $supinfo->supplier_id.'-'.$supinfo->supplier_name;
        $sup_coa = $this->db->select('*')->from('acc_coa')->where('HeadName',$sup_head)->get()->row();
        $receive_by=$this->session->userdata('user_id');
        $receive_date=date('Y-m-d');
        $createdate=date('Y-m-d H:i:s');
        $paid_amount = $this->input->post('paid_amount',TRUE);
        $due_amount = $this->input->post('due_amount',TRUE);
        $discount = $this->input->post('discount',TRUE);
          $bank_id = $this->input->post('bank_id',TRUE);
        if(!empty($bank_id)){
         $bankname = $this->db->select('bank_name')->from('bank_add')->where('bank_id',$bank_id)->get()->row()->bank_name;
      
         $bankcoaid = $this->db->select('HeadCode')->from('acc_coa')->where('HeadName',$bankname)->get()->row()->HeadCode;
       }else{
           $bankcoaid = '';
       }

        //supplier & product id relation ship checker.
        for ($i = 0, $n = count($p_id); $i < $n; $i++) {
            $product_id = $p_id[$i];
            $value = $this->product_supplier_check($product_id, $supplier_id);
            if ($value == 0) {
                $this->session->set_flashdata('error_message', display('product_and_supplier_did_not_match'));
             
            }
        }
 
        $data = array(
            'purchase_order_id'        => $purchase_id,
            'create_by'       =>  $this->session->userdata('user_id'),
            'tax_details'  =>  $this->input->post('tax_details',TRUE),

            'ship_to'         =>$this->input->post('ship_to',TRUE),
            'created_by'       =>$this->input->post('created_by',TRUE),
            'payment_terms' => $this->input->post('payment_terms',TRUE),
            'shipment_terms' => $this->input->post('shipment_terms',TRUE),
            'est_ship_date'  => $this->input->post('est_ship_date',TRUE),


            'chalan_no'          => $this->input->post('chalan_no',TRUE),
            'supplier_id'        => $this->input->post('supplier_id',TRUE),
            'total' => $this->input->post('total',TRUE),
            'grand_total_amount' => $this->input->post('gtotal',TRUE),
             'gtotal_preferred_currency' => $this->input->post('vendor_gtotal',TRUE),
            'total_discount'     => $this->input->post('discount',TRUE),
            'purchase_date'      => $receive_date,
            'purchase_details'   => $this->input->post('purchase_details',TRUE),
            'payment_due_date'   => $this->input->post('payment_due_date',TRUE),
            'remarks'            => $this->input->post('remarks',TRUE),
            'message_invoice'    => $this->input->post('message_invoice',TRUE),
          
            'etd'   => $this->input->post('etd',TRUE),
            'eta'   => $this->input->post('eta',TRUE),
            'shipping_line'   => $this->input->post('shipping_line',TRUE),
            'container_no'   => $this->input->post('container_no',TRUE),
            'bl_number'   => $this->input->post('bl_number',TRUE),
            'isf_filling'   => $this->input->post('isf_filling',TRUE),
            'paid_amount'        => $paid_amount,
            'due_amount'         => $due_amount,
            'status'             => 1,
            'bank_id'            =>  $this->input->post('bank_id',TRUE),
            'payment_type'       =>  $this->input->post('paytype',TRUE),
        );
        //Supplier Credit
        $purchasecoatran = array(
          'VNo'            =>  $purchase_id,
          'Vtype'          =>  'Purchase',
          'VDate'          =>  $this->input->post('purchase_date',TRUE),
          'COAID'          =>  $sup_coa->HeadCode,
          'Narration'      =>  'Supplier .'.$supinfo->supplier_name,
          'Debit'          =>  0,
          'Credit'         =>  $this->input->post('grand_total_price',TRUE),
          'IsPosted'       =>  1,
          'CreateBy'       =>  $receive_by,
          'CreateDate'     =>  $receive_date,
          'IsAppove'       =>  1
        ); 
          ///Inventory Debit
       $coscr = array(
      'VNo'            =>  $purchase_id,
      'Vtype'          =>  'Purchase',
      'VDate'          =>  $this->input->post('purchase_date',TRUE),
      'COAID'          =>  10107,
      'Narration'      =>  'Inventory Debit For Supplier '.$supinfo->supplier_name,
      'Debit'          =>  $this->input->post('grand_total_price',TRUE),
      'Credit'         =>  0,//purchase price asbe
      'IsPosted'       => 1,
      'CreateBy'       => $receive_by,
      'CreateDate'     => $createdate,
      'IsAppove'       => 1
    ); 



       // Expense for company
         $expense = array(
      'VNo'            => $purchase_id,
      'Vtype'          => 'Purchase',
      'VDate'          => $this->input->post('purchase_date',TRUE),
      'COAID'          => 402,
      'Narration'      => 'Company Credit For  '.$supinfo->supplier_name,
      'Debit'          => $this->input->post('grand_total_price',TRUE),
      'Credit'         => 0,//purchase price asbe
      'IsPosted'       => 1,
      'CreateBy'       => $receive_by,
      'CreateDate'     => $createdate,
      'IsAppove'       => 1
    ); 
             $cashinhand = array(
      'VNo'            =>  $purchase_id,
      'Vtype'          =>  'Purchase',
      'VDate'          =>  $this->input->post('purchase_date',TRUE),
      'COAID'          =>  1020101,
      'Narration'      =>  'Cash in Hand For Supplier '.$supinfo->supplier_name,
      'Debit'          =>  0,
      'Credit'         =>  $paid_amount,
      'IsPosted'       =>  1,
      'CreateBy'       =>  $receive_by,
      'CreateDate'     =>  $createdate,
      'IsAppove'       =>  1
    ); 

     $supplierdebit = array(
          'VNo'            =>  $purchase_id,
          'Vtype'          =>  'Purchase',
          'VDate'          =>  $this->input->post('purchase_date',TRUE),
          'COAID'          =>  $sup_coa->HeadCode,
          'Narration'      =>  'Supplier .'.$supinfo->supplier_name,
          'Debit'          =>  $paid_amount,
          'Credit'         =>  0,
          'IsPosted'       =>  1,
          'CreateBy'       =>  $receive_by,
          'CreateDate'     =>  $receive_date,
          'IsAppove'       =>  1
        ); 
             
                  // bank ledger
 $bankc = array(
      'VNo'            =>  $purchase_id,
      'Vtype'          =>  'Purchase',
      'VDate'          =>  $this->input->post('purchase_date',TRUE),
      'COAID'          =>  $bankcoaid,
      'Narration'      =>  'Paid amount for Supplier  '.$supinfo->supplier_name,
      'Debit'          =>  0,
      'Credit'         =>  $paid_amount,
      'IsPosted'       =>  1,
      'CreateBy'       =>  $receive_by,
      'CreateDate'     =>  $createdate,
      'IsAppove'       =>  1
    ); 
 // Bank summary for credit

       //new end
     
       $purchase_id_1 = $this->db->where('chalan_no',$this->input->post('chalan_no',TRUE));
       $q=$this->db->get('purchase_order');
       $row = $q->row_array();
     //  echo $row['purchase_order_id'];
      if(!empty($row['purchase_order_id'])){
       $this->session->set_userdata("SESSION_NAME_1",$row['purchase_order_id']);
     
       $this->db->where('chalan_no', $this->input->post('chalan_no',TRUE));

       $this->db->delete('purchase_order');
  
        $this->db->insert('purchase_order', $data);
      
      }
      else{
        $this->db->insert('purchase_order', $data);
       
      }
        $purchase_id = $this->db->select('purchase_order_id')->from('purchase_order')->where('chalan_no',$this->input->post('chalan_no',TRUE))->get()->row()->purchase_order_id;
    
        $this->session->set_userdata("SESSION_NAME",$purchase_id);
       
      
        $this->db->insert('acc_transaction',$coscr);
        $this->db->insert('acc_transaction',$purchasecoatran);  
        $this->db->insert('acc_transaction',$expense);
        if($this->input->post('paytype') == 2){
          if(!empty($paid_amount)){
        $this->db->insert('acc_transaction',$bankc);
       
        $this->db->insert('acc_transaction',$supplierdebit);
      }
        }
        if($this->input->post('paytype') == 1){
          if(!empty($paid_amount)){
        $this->db->insert('acc_transaction',$cashinhand);
        $this->db->insert('acc_transaction',$supplierdebit); 
        }    
        }       

        $rate = $this->input->post('product_rate',TRUE);
        $quantity = $this->input->post('product_quantity',TRUE);
        $slabs_po = $this->input->post('slabs',TRUE);

        $t_price = $this->input->post('total_price',TRUE);
        $discount = $this->input->post('discount',TRUE);

        for ($i = 0, $n = count($p_id); $i < $n; $i++) {
            $slabs = $slabs_po[$i];
            $product_quantity = $quantity[$i];
            $product_rate = $rate[$i];
            $product_id = $p_id[$i];
            $total_price = $t_price[$i];
            $disc = 0;

            $data1 = array(
                'purchase_order_detail_id' => $this->generator(15),
                'purchase_id'        =>  $this->session->userdata("SESSION_NAME"),
                'product_id'         => $product_id,
                'slabs'              => $slabs,
                'quantity'           => $product_quantity,
                'rate'               => $product_rate,
                'total_amount'       => $total_price,
                'discount'           => $disc,
                'create_by'          => $this->session->userdata('user_id'),
                'status'             => 1
            );
          //  
      //    SESSION_NAME_1
          //  echo $purchase_id;
          //  $this->db->where('purchase_id', $purchase_id );

           // $this->db->delete('purchase_order_details');
         //   echo $this->db->last_query();
          //  if (!empty($quantity)) {
          
            $this->db->where('purchase_id', $this->session->userdata("SESSION_NAME_1"));
 
            $this->db->delete('purchase_order_details');
            $this->db->insert('purchase_order_details', $data1);
               
           // }
        }
      
        return $purchase_id."/".$chalan_no;
    }
*/
public function purchase_order_entry() {
    $purchase_id = date('YmdHis');
$chalan_no =$this->input->post('chalan_no',TRUE);
    $p_id = $this->input->post('product_id',TRUE);
    $supplier_id = $this->input->post('supplier_id',TRUE);
    $supinfo =$this->db->select('*')->from('supplier_information')->where('supplier_id',$supplier_id)->get()->row();
  //  echo $this->db->last_query();
    $sup_head = $supinfo->supplier_id.'-'.$supinfo->supplier_name;
    $sup_coa = $this->db->select('*')->from('acc_coa')->where('HeadName',$sup_head)->get()->row();
    $receive_by=$this->session->userdata('user_id');
    $receive_date=date('Y-m-d');
    $createdate=date('Y-m-d H:i:s');
    $paid_amount = $this->input->post('amount_paid',TRUE);
    $due_amount = $this->input->post('balance',TRUE);
    $discount = $this->input->post('discount',TRUE);
      $bank_id = $this->input->post('bank_id',TRUE);
    if(!empty($bank_id)){
     $bankname = $this->db->select('bank_name')->from('bank_add')->where('bank_id',$bank_id)->get()->row()->bank_name;
     $bankcoaid = $this->db->select('HeadCode')->from('acc_coa')->where('HeadName',$bankname)->get()->row()->HeadCode;
   }else{
       $bankcoaid = '';
   }
    //supplier & product id relation ship checker.
    for ($i = 0, $n = count($p_id); $i < $n; $i++) {
        $product_id = $p_id[$i];
        $value = $this->product_supplier_check($product_id, $supplier_id);
        if ($value == 0) {
            $this->session->set_flashdata('error_message', display('product_and_supplier_did_not_match'));
        }
    }
    $data = array(
        'purchase_order_id'        => $purchase_id,
        'create_by'       =>  $this->session->userdata('user_id'),
        'ship_to'         =>$this->input->post('ship_to',TRUE),
        'created_by'       =>$this->input->post('created_by',TRUE),
        'payment_terms' => $this->input->post('payment_terms',TRUE),
        'shipment_terms' => $this->input->post('shipment_terms',TRUE),
        'est_ship_date'  => $this->input->post('est_ship_date',TRUE),
        'chalan_no'          => $this->input->post('chalan_no',TRUE),
        'supplier_id'        => $this->input->post('supplier_id',TRUE),
        'total'  =>$this->input->post('total',TRUE),
        'grand_total_amount' => $this->input->post('gtotal',TRUE),
         'gtotal_preferred_currency' => $this->input->post('vendor_gtotal',TRUE),
        'total_discount'     => $this->input->post('discount',TRUE),
        'purchase_date'      => $receive_date,
        'purchase_details'   => $this->input->post('purchase_details',TRUE),
        'payment_due_date'   => $this->input->post('payment_due_date',TRUE),
        'remarks'            => $this->input->post('remarks',TRUE),
        'message_invoice'    => $this->input->post('message_invoice',TRUE),
        'tax_details'    => $this->input->post('tax_details',TRUE),
        'etd'   => $this->input->post('etd',TRUE),
        'eta'   => $this->input->post('eta',TRUE),
        'shipping_line'   => $this->input->post('shipping_line',TRUE),
        'container_no'   => $this->input->post('container_no',TRUE),
        'bl_number'   => $this->input->post('bl_number',TRUE),
        'isf_filling'   => $this->input->post('isf_filling',TRUE),
        'paid_amount'        => $paid_amount,
        'due_amount'         => $due_amount,
        'status'             => 1,
        'bank_id'            =>  $this->input->post('bank_id',TRUE),
        'payment_type'       =>  $this->input->post('paytype',TRUE),
    );
    //Supplier Credit
    $purchasecoatran = array(
      'VNo'            =>  $purchase_id,
      'Vtype'          =>  'Purchase',
      'VDate'          =>  $this->input->post('purchase_date',TRUE),
      'COAID'          =>  $sup_coa->HeadCode,
      'Narration'      =>  'Supplier .'.$supinfo->supplier_name,
      'Debit'          =>  0,
      'Credit'         =>  $this->input->post('grand_total_price',TRUE),
      'IsPosted'       =>  1,
      'CreateBy'       =>  $receive_by,
      'CreateDate'     =>  $receive_date,
      'IsAppove'       =>  1
    );
      ///Inventory Debit
   $coscr = array(
  'VNo'            =>  $purchase_id,
  'Vtype'          =>  'Purchase',
  'VDate'          =>  $this->input->post('purchase_date',TRUE),
  'COAID'          =>  10107,
  'Narration'      =>  'Inventory Debit For Supplier '.$supinfo->supplier_name,
  'Debit'          =>  $this->input->post('grand_total_price',TRUE),
  'Credit'         =>  0,//purchase price asbe
  'IsPosted'       => 1,
  'CreateBy'       => $receive_by,
  'CreateDate'     => $createdate,
  'IsAppove'       => 1
);
   // Expense for company
     $expense = array(
  'VNo'            => $purchase_id,
  'Vtype'          => 'Purchase',
  'VDate'          => $this->input->post('purchase_date',TRUE),
  'COAID'          => 402,
  'Narration'      => 'Company Credit For  '.$supinfo->supplier_name,
  'Debit'          => $this->input->post('grand_total_price',TRUE),
  'Credit'         => 0,//purchase price asbe
  'IsPosted'       => 1,
  'CreateBy'       => $receive_by,
  'CreateDate'     => $createdate,
  'IsAppove'       => 1
);
         $cashinhand = array(
  'VNo'            =>  $purchase_id,
  'Vtype'          =>  'Purchase',
  'VDate'          =>  $this->input->post('purchase_date',TRUE),
  'COAID'          =>  1020101,
  'Narration'      =>  'Cash in Hand For Supplier '.$supinfo->supplier_name,
  'Debit'          =>  0,
  'Credit'         =>  $paid_amount,
  'IsPosted'       =>  1,
  'CreateBy'       =>  $receive_by,
  'CreateDate'     =>  $createdate,
  'IsAppove'       =>  1
);
 $supplierdebit = array(
      'VNo'            =>  $purchase_id,
      'Vtype'          =>  'Purchase',
      'VDate'          =>  $this->input->post('purchase_date',TRUE),
      'COAID'          =>  $sup_coa->HeadCode,
      'Narration'      =>  'Supplier .'.$supinfo->supplier_name,
      'Debit'          =>  $paid_amount,
      'Credit'         =>  0,
      'IsPosted'       =>  1,
      'CreateBy'       =>  $receive_by,
      'CreateDate'     =>  $receive_date,
      'IsAppove'       =>  1
    );
              // bank ledger
$bankc = array(
  'VNo'            =>  $purchase_id,
  'Vtype'          =>  'Purchase',
  'VDate'          =>  $this->input->post('purchase_date',TRUE),
  'COAID'          =>  $bankcoaid,
  'Narration'      =>  'Paid amount for Supplier  '.$supinfo->supplier_name,
  'Debit'          =>  0,
  'Credit'         =>  $paid_amount,
  'IsPosted'       =>  1,
  'CreateBy'       =>  $receive_by,
  'CreateDate'     =>  $createdate,
  'IsAppove'       =>  1
);
// Bank summary for credit
   //new end
   $purchase_id_1 = $this->db->where('chalan_no',$this->input->post('chalan_no',TRUE));
   $q=$this->db->get('purchase_order');
   $row = $q->row_array();
 //  echo $row['purchase_order_id'];
  if(!empty($row['purchase_order_id'])){
   $this->session->set_userdata("SESSION_NAME_1",$row['purchase_order_id']);
   $this->db->where('chalan_no', $this->input->post('chalan_no',TRUE));
   $this->db->delete('purchase_order');
    $this->db->insert('purchase_order', $data);
   // echo $this->db->last_query();
  }
  else{
    $this->db->insert('purchase_order', $data);
  //  echo $this->db->last_query();
  }
    $purchase_id = $this->db->select('purchase_order_id')->from('purchase_order')->where('chalan_no',$this->input->post('chalan_no',TRUE))->get()->row()->purchase_order_id;
    $this->session->set_userdata("SESSION_NAME",$purchase_id);
    $this->db->insert('acc_transaction',$coscr);
    $this->db->insert('acc_transaction',$purchasecoatran);
    $this->db->insert('acc_transaction',$expense);
    if($this->input->post('paytype') == 2){
      if(!empty($paid_amount)){
    $this->db->insert('acc_transaction',$bankc);
    $this->db->insert('acc_transaction',$supplierdebit);
  }
    }
    if($this->input->post('paytype') == 1){
      if(!empty($paid_amount)){
    $this->db->insert('acc_transaction',$cashinhand);
    $this->db->insert('acc_transaction',$supplierdebit);
    }
    }
    $rate = $this->input->post('product_rate',TRUE);
    $quantity = $this->input->post('product_quantity',TRUE);
  
    $t_price = $this->input->post('total_price',TRUE);
    $discount = $this->input->post('discount',TRUE);
    $description = $this->input->post('description',TRUE);
    $this->db->where('purchase_id', $this->session->userdata("SESSION_NAME_1"));
    $this->db->delete('purchase_order_details');
    $rowCount = count($this->input->post('product_name',TRUE));

 //   echo $this->db->last_query();echo "<br/>";
    for ($i = 0; $i < $rowCount; $i++) {

 
        $product_quantity = $quantity[$i];
        $product_rate = $rate[$i];
        $product_id = $p_id[$i];
        $total_price = $t_price[$i];
        $descr       = $description[$i];
        $disc = 0;
        $data1 = array(
            'purchase_order_detail_id' => $this->generator(15),
            'purchase_id'        =>  $this->session->userdata("SESSION_NAME"),
            'product_id'         => $product_id,
          
            'quantity'           => $product_quantity,
            'rate'               => $product_rate,
            'total_amount'       => $total_price,
            'description'                =>   $descr,
            'discount'           => $disc,
            'create_by'          => $this->session->userdata('user_id'),
            'status'             => 1
        );
      //
  //    SESSION_NAME_1
      //  echo $purchase_id;
      //  $this->db->where('purchase_id', $purchase_id );
       // $this->db->delete('purchase_order_details');
     //   echo $this->db->last_query();
      //  if (!empty($quantity)) {
       
        $this->db->insert('purchase_order_details', $data1);
     //   echo $this->db->last_query();
       // }
    }
    return $purchase_id."/".$chalan_no;
}
    public function invoice_dropdown(){
        $this->db->select('chalan_no');
        $this->db->from('product_purchase');
        $this->db->where('create_by',$this->session->userdata('user_id'));
        $query = $this->db->get();
       // echo $this->db->last_query();die();
        return $query->result_array();
    }
    public function shipment_bl_number() {
        $query = $this->db->select('shipment_number')
                ->from('expense_trucking')
                ->where('created_by',$this->session->userdata('user_id'))
                // ->where('supplier_name',$value)
                ->where('status', '1')
                ->get();
    }
         //Ocean Import Entry
    public function ocean_import_entry() {

        $purchase_id = date('YmdHis');

        $p_id = $this->input->post('product_id',TRUE);
        $supplier_id = $this->input->post('supplier_id',TRUE);
        $supinfo =$this->db->select('*')->from('supplier_information')->where('supplier_id',$supplier_id)->get()->row();
        $sup_head = $supinfo->supplier_id.'-'.$supinfo->supplier_name;
        $sup_coa = $this->db->select('*')->from('acc_coa')->where('HeadName',$sup_head)->get()->row();
        $receive_by=$this->session->userdata('user_id');
        $receive_date=date('Y-m-d');
        $createdate=date('Y-m-d H:i:s');
        $paid_amount = $this->input->post('paid_amount',TRUE);
        $due_amount = $this->input->post('due_amount',TRUE);
        $discount = $this->input->post('discount',TRUE);
          $bank_id = $this->input->post('bank_id',TRUE);
        if(!empty($bank_id)){
         $bankname = $this->db->select('bank_name')->from('bank_add')->where('bank_id',$bank_id)->get()->row()->bank_name;
      
         $bankcoaid = $this->db->select('HeadCode')->from('acc_coa')->where('HeadName',$bankname)->get()->row()->HeadCode;
       }else{
           $bankcoaid = '';
       }

      $data = array(
            'ocean_import_tracking_id'        => $purchase_id,
            'booking_no'          => $this->input->post('booking_no',TRUE),
            'container_no' =>$this->input->post('container_no',TRUE),
            'seal_no'      =>$this->input->post('seal_no',TRUE),
            'etd'   => $this->input->post('etd',TRUE),
            'eta'   => $this->input->post('eta',TRUE),
            'supplier_id'        => $this->input->post('supplier_id',TRUE),
            'shipper' => $this->input->post('supplier_id',TRUE),
            'invoice_date' => $this->input->post('invoice_date',TRUE),
            'bl_shipment_date' => $this->input->post('bl_shipment',TRUE),
            'consignee' => $this->input->post('consignee',TRUE),
            'notify_party' => $this->input->post('notify_party',TRUE),
            'vessel' => $this->input->post('vessel',TRUE),
            'voyage_no' =>$this->input->post('voyage_no',TRUE),
            'port_of_loading' => $this->input->post('port_of_loading',TRUE),
            'port_of_discharge' => $this->input->post('port_of_discharge',TRUE),
            'place_of_delivery' =>$this->input->post('place_of_delivery',TRUE),
            'freight_forwarder' =>$this->input->post('freight_forwarder',TRUE),
            'particular'   => $this->input->post('particulars',TRUE),
            'country_origin' => $this->input->post('country_of_origin',TRUE),
            'remarks'              => $this->input->post('remark',TRUE),
            'status'             => 1,
            'create_by'       =>  $this->session->userdata('user_id'),
            );


            $purchase_id_1 = $this->db->where('booking_no',$this->input->post('booking_no',TRUE));
            $q=$this->db->get('ocean_import_tracking');
            $row = $q->row_array();
        if(!empty($row['booking_no'])){
            $this->session->set_userdata("ocean_import_1",$row['booking_no']);
          
            $this->db->where('booking_no',$this->input->post('booking_no',TRUE));
     
            $this->db->delete('ocean_import_tracking');
          //  echo $this->db->last_query();
            $this->db->insert('ocean_import_tracking', $data);
          // echo $this->db->last_query();
        }   
        else{
        $this->db->insert('ocean_import_tracking', $data);
       // echo $this->db->last_query();
        }
 
           
        
      //    $query= $this->db->insert('ocean_import_tracking', $data);
     

       return $purchase_id."/".$this->input->post('booking_no',TRUE);
    }

        public function voucher_no()
    {
      return  $data = $this->db->select("chalan_no as voucher")
            ->from('purchase_order') 
            ->like('chalan_no', 'PO', 'after')
            ->order_by('ID','desc')
            ->get()
            ->result_array();
           
    }
        public function packing_voucher_no()
    {
      return  $data = $this->db->select("invoice_no as voucher")
            ->from('expense_packing_list') 
            ->like('invoice_no', 'PL', 'after')
            ->order_by('ID','desc')
            ->get()
            ->result_array();
           
    }

            public function trucking_voucher_no()
    {
      return  $data = $this->db->select("invoice_no as voucher")
            ->from('expense_trucking') 
            ->like('invoice_no', 'T', 'after')
            ->order_by('ID','desc')
            ->get()
            ->result_array();
           
    }


           //Trucking 
    //Entry
    public function trucking_entry() {

        $purchase_id = date('YmdHis');
        $invoice_no= $this->input->post('invoice_no',TRUE);
        $p_id = $this->input->post('product_id',TRUE);
      
      //  $supplier_id = $this->input->post('supplier_id',TRUE);
      //  $supinfo =$this->db->select('*')->from('supplier_information')->where('supplier_id',$supplier_id)->get()->row();
      //  $sup_head = $supinfo->supplier_id.'-'.$supinfo->supplier_name;
      //  $sup_coa = $this->db->select('*')->from('acc_coa')->where('HeadName',$sup_head)->get()->row();
        $receive_by=$this->session->userdata('user_id');
        $receive_date=date('Y-m-d');
        $createdate=date('Y-m-d H:i:s');
        $paid_amount = $this->input->post('paid_amount',TRUE);
        $due_amount = $this->input->post('due_amount',TRUE);
        $discount = $this->input->post('discount',TRUE);
          $bank_id = $this->input->post('bank_id',TRUE);
        if(!empty($bank_id)){
         $bankname = $this->db->select('bank_name')->from('bank_add')->where('bank_id',$bank_id)->get()->row()->bank_name;
      
         $bankcoaid = $this->db->select('HeadCode')->from('acc_coa')->where('HeadName',$bankname)->get()->row()->HeadCode;
       }else{
           $bankcoaid = '';
       }
       $payment_id=$this->input->post('payment_id');
       $shipment_number = $this->input->post('shipment_bl_number',TRUE);
   $data = array(
    'payment_id' => $payment_id,
            'trucking_id'        => $purchase_id,
            'create_by'       =>  $this->session->userdata('user_id'),
            'invoice_no' => $this->input->post('invoice_no',TRUE),
            'invoice_date' =>$this->input->post('invoice_date',TRUE),
            'bill_to'      =>$this->input->post('bill_to',TRUE),
            'total_amt' => $this->input->post('total',TRUE),
            'customer_gtotal' =>$this->input->post('customer_gtotal',TRUE),
            'tax' => $this->input->post('tax_details',TRUE),
            'amt_paid'    => $this->input->post('amount_paid',TRUE),
            'balance'    => $this->input->post('balance',TRUE),
            'shipment_company'   => $this->input->post('shipment_company',TRUE),
            'shipment_number' => $this->input->post('shipment_bl_number',TRUE),
            'container_pickup_date'   => $this->input->post('container_pick_up_date',TRUE),
            'container_no'   => $this->input->post('container_number',TRUE),
            'delivery_date' => $this->input->post('delivery_date',TRUE),
            'grand_total_amount' => $this->input->post('gtotal',TRUE),
            'status'             => 1,
            'remarks'             => $this->input->post('remarks',TRUE)
         

          
        );



        $purchase_id_1 = $this->db->where('invoice_no',$this->input->post('invoice_no',TRUE));
        $q=$this->db->get('expense_trucking');
        $row = $q->row_array();
    if(!empty($row['trucking_id'])){
        $this->session->set_userdata("trucking_1",$row['trucking_id']);
      
        $this->db->where('invoice_no',$this->input->post('invoice_no',TRUE));
 
        $this->db->delete('expense_trucking');
        $this->db->insert('expense_trucking', $data);
        
   }   
    else{
    $this->db->insert('expense_trucking', $data);
  
    }
       $purchase_id = $this->db->select('trucking_id')->from('expense_trucking')->where('invoice_no',$this->input->post('invoice_no',TRUE))->get()->row()->trucking_id;
    
       $this->session->set_userdata("trucking_2",$purchase_id);


       if($this->input->post('paytype') == 2){
          if(!empty($paid_amount)){
        $this->db->insert('acc_transaction',$bankc);
       
        $this->db->insert('acc_transaction',$supplierdebit);
      }
        }
        if($this->input->post('paytype') == 1){
          if(!empty($paid_amount)){
        $this->db->insert('acc_transaction',$cashinhand);
        $this->db->insert('acc_transaction',$supplierdebit); 
        }    
        }       

        $trucking_date = $this->input->post('trucking_date',TRUE);
        $rate = $this->input->post('product_rate',TRUE);
        $quantity = $this->input->post('product_quantity',TRUE);
        $description = $this->input->post('description',TRUE);
        $pro_no =  $this->input->post('pro_no',TRUE);
        $t_price = $this->input->post('total_price',TRUE);
      
        $rowCount = count($this->input->post('trucking_date',TRUE));

        for ($i = 0; $i < $rowCount; $i++) {
            $t_date = $this->input->post('trucking_date',TRUE);
            $trucking_rate = $this->input->post('product_rate',TRUE);
            $quantity = $this->input->post('product_quantity',TRUE);
            $trucking_description = $this->input->post('description',TRUE);
            $trucking_pro_no =  $this->input->post('pro_no',TRUE);
            $t_price = $this->input->post('total_price',TRUE);
          $trucking_date = $t_date[$i];
                $product_quantity = $quantity[$i];
                $description = $trucking_description[$i];
                $product_rate =  $trucking_rate[$i];
                $pro_no = $trucking_pro_no[$i];
                $total =  $t_price[$i];
                $data1 = array(
                    'expense_trucking_detail_id' => $this->generator(15),
                    'expense_trucking_id'        =>  $this->session->userdata("trucking_2"),
                    'trucking_date' =>$trucking_date,
                   
                    'qty'           => $product_quantity,
                    'description'               => $description,
                    'rate'              =>  $product_rate ,
                  
                    'pro_no_reference'           => $pro_no,
                    'total'       => $total,
                    'create_by'          =>  $this->session->userdata('user_id'),
                    'status'             => 1
                );
             
            $this->db->where('expense_trucking_id', $this->session->userdata("trucking_1"));
              $this->db->delete('expense_trucking_details');

              $this->db->insert('expense_trucking_details', $data1);
              
          //  if (!empty($quantity)) {
               
          //  }
   
    }
       // echo $rowCount;

        return $purchase_id."/".$invoice_no;
    }
    //Retrieve purchase Edit Data
    public function retrieve_purchase_editdata($purchase_id) {

        $this->db->select('a.*,
						b.*,
					c.product_id,
                        c.product_name,
                        c.product_model,
                        d.supplier_id,
                        d.supplier_name'
        );
        $this->db->from('product_purchase a');
        $this->db->join('product_purchase_details b', 'b.purchase_id =a.purchase_id');
        $this->db->join('product_information c', 'c.product_id =b.product_id');
        $this->db->join('supplier_information d', 'd.supplier_id = a.supplier_id');
       $this->db->where('a.create_by',$this->session->userdata('user_id'));
        $this->db->where('a.purchase_id', $purchase_id);
       // $this->db->order_by('a.purchase_details', 'asc');
        $query = $this->db->get();

    //                $str = $this->db->last_query();

   //echo $this->db->last_query();

    // echo "<pre>";

    // print_r($str);

    // exit;
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
      
    }


       //Retrieve purchase order Edit Data
    public function retrieve_purchase_order_editdata($purchase_id) {
        $this->db->select('a.*,
                        b.*,
                        c.product_id,
                        c.product_name,
                        c.product_model,
                        d.supplier_id,
                        d.supplier_name'
        );
        $this->db->from('purchase_order a');
        $this->db->join('purchase_order_details b', 'b.purchase_id =a.purchase_order_id');
        $this->db->join('product_information c', 'c.product_id =b.product_id');
        $this->db->join('supplier_information d', 'd.supplier_id = a.supplier_id');
        $this->db->where('a.create_by',$this->session->userdata('user_id'));
        $this->db->where('a.purchase_order_id', $purchase_id);
        $this->db->order_by('a.purchase_details', 'asc');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
     
        return true;
    }


       //Retrieve ocean import tracking Edit Data
    public function retrieve_ocean_import_tracking_editdata($purchase_id) {
        $this->db->select('a.*,b.*');
        $this->db->from('ocean_import_tracking a');
        $this->db->join('supplier_information b', 'b.supplier_id =a.supplier_id');
        $this->db->where('a.create_by',$this->session->userdata('user_id'));
        $this->db->where('a.ocean_import_tracking_id', $purchase_id);
        // $this->db->order_by('a.purchase_details', 'asc');
        $query = $this->db->get();
      
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return true;
    }


        //Retrieve trucking Edit Data
    public function retrieve_trucking_editdata($purchase_id) {
       $this->db->select('a.*,
                        b.*,
                        c.product_id,
                        c.product_name,
                        c.product_model,
                        d.supplier_id,
                        d.supplier_name'
        );
        $this->db->from('expense_trucking a');
        $this->db->join('expense_trucking_details b', 'b.expense_trucking_id =a.trucking_id');
        $this->db->join('product_information c', 'c.product_id =b.product_id');
        $this->db->join('customer_information d', 'd.customer_id = a.bill_to');
        $this->db->where('a.create_by',$this->session->userdata('user_id'));
        $this->db->where('a.trucking_id', $purchase_id);
       // $this->db->order_by('a.purchase_details', 'asc');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;
    }
         //Retrieve trucking Edit Data
    public function retrieve_packing_editdata($purchase_id) {
       $this->db->select('a.*,
                        b.*,c.*
                   '
        );
        $this->db->from('expense_packing_list a');
        $this->db->join('expense_packing_list_detail b', 'b.expense_packing_id =a.expense_packing_id');
        $this->db->join('product_information c', 'c.product_id =b.product_id');
  
        $this->db->where('b.create_by',$this->session->userdata('user_id'));
        $this->db->where('b.expense_packing_id', $purchase_id);
       // $this->db->order_by('a.purchase_details', 'asc');
        $query = $this->db->get();
     // echo $this->db->last_query();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
       
    }


    //Retrieve company Edit Data
    public function retrieve_company() {
        $this->db->select('*');
        $this->db->from('company_information');
        $this->db->limit('1');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;
    }

    //Update Categories
    public function update_purchase() {
          $purchase_id  = $this->input->post('purchase_id',TRUE);
          $paid_amount  = $this->input->post('paid_amount',TRUE);
          $due_amount   = $this->input->post('due_amount',TRUE);
          $bank_id      = $this->input->post('bank_id',TRUE);
        if(!empty($bank_id)){
       $bankname = $this->db->select('bank_name')->from('bank_add')->where('bank_id',$bank_id)->get()->row()->bank_name;
    
       $bankcoaid = $this->db->select('HeadCode')->from('acc_coa')->where('HeadName',$bankname)->get()->row()->HeadCode;
   }
        $p_id = $this->input->post('product_id',TRUE);
        $supplier_id = $this->input->post('supplier_id',TRUE);
        $supinfo =$this->db->select('*')->from('supplier_information')->where('supplier_id',$supplier_id)->get()->row();
        $sup_head = $supinfo->supplier_id.'-'.$supinfo->supplier_name;
        $sup_coa = $this->db->select('*')->from('acc_coa')->where('HeadName',$sup_head)->get()->row();
       $receive_by=$this->session->userdata('user_id');
        $receive_date=date('Y-m-d');
        $createdate=date('Y-m-d H:i:s');


        $data = array(
            'purchase_id'        => $purchase_id,
            'chalan_no'          => $this->input->post('chalan_no',TRUE),
            'supplier_id'        => $this->input->post('supplier_id',TRUE),
            'grand_total_amount' => $this->input->post('total',TRUE),
            'total_discount'     => $this->input->post('discount',TRUE),
            'purchase_date'      => $this->input->post('purchase_date',TRUE),
            'purchase_details'   => $this->input->post('purchase_details',TRUE),
            'paid_amount'        => $paid_amount,
            'due_amount'         => $due_amount,
            'bank_id'           =>  $this->input->post('bank_id',TRUE),
            'payment_type'       =>  $this->input->post('paytype',TRUE),
        );


         $cashinhand = array(
      'VNo'            =>  $purchase_id,
      'Vtype'          =>  'Purchase',
      'VDate'          =>  $this->input->post('purchase_date',TRUE),
      'COAID'          =>  1020101,
      'Narration'      =>  'Cash in Hand For Supplier '.$supinfo->supplier_name,
      'Debit'          =>  0,
      'Credit'         =>  $paid_amount,
      'IsPosted'       =>  1,
      'CreateBy'       =>  $receive_by,
      'CreateDate'     =>  $createdate,
      'IsAppove'       =>  1
    ); 
                  // bank ledger
 $bankc = array(
      'VNo'            =>  $purchase_id,
      'Vtype'          =>  'Purchase',
      'VDate'          =>  $this->input->post('purchase_date',TRUE),
      'COAID'          =>  'test',
      'Narration'      =>  'Paid amount for Supplier  '.$supinfo->supplier_name,
      'Debit'          =>  0,
      'Credit'         =>  $paid_amount,
      'IsPosted'       =>  1,
      'CreateBy'       =>  $receive_by,
      'CreateDate'     =>  $createdate,
      'IsAppove'       =>  1
    ); 

        
         $purchasecoatran = array(
          'VNo'            =>  $purchase_id,
          'Vtype'          =>  'Purchase',
          'VDate'          =>  $this->input->post('purchase_date',TRUE),
          'COAID'          =>  $sup_coa->HeadCode,
          'Narration'      =>  'Supplier -'.$supinfo->supplier_name,
          'Debit'          =>  0,
          'Credit'         =>  $this->input->post('grand_total_price',TRUE),
          'IsPosted'       =>  1,
          'CreateBy'       =>  $receive_by,
          'CreateDate'     =>  $receive_date,
          'IsAppove'       =>  1
        ); 
          ///Inventory credit
       $coscr = array(
      'VNo'            =>  $purchase_id,
      'Vtype'          =>  'Purchase',
      'VDate'          =>  $this->input->post('purchase_date',TRUE),
      'COAID'          =>  10107,
      'Narration'      =>  'Inventory Devit Supplier '.$supinfo->supplier_name,
      'Debit'          =>  $this->input->post('grand_total_price',TRUE),
      'Credit'         =>  0,//purchase price asbe
      'IsPosted'       => 1,
      'CreateBy'       => $receive_by,
      'CreateDate'     => $createdate,
      'IsAppove'       => 1
    ); 
          // Expense for company
         $expense = array(
      'VNo'            => $purchase_id,
      'Vtype'          => 'Purchase',
      'VDate'          => $this->input->post('purchase_date',TRUE),
      'COAID'          => 402,
      'Narration'      => 'Company Credit For Supplier'.$supinfo->supplier_name,
      'Debit'          => $this->input->post('grand_total_price',TRUE),
      'Credit'         => 0,//purchase price asbe
      'IsPosted'       => 1,
      'CreateBy'       => $receive_by,
      'CreateDate'     => $createdate,
      'IsAppove'       => 1
    ); 

         $supplier_debit = array(
          'VNo'            =>  $purchase_id,
          'Vtype'          =>  'Purchase',
          'VDate'          =>  $this->input->post('purchase_date',TRUE),
          'COAID'          =>  $sup_coa->HeadCode,
          'Narration'      =>  'Supplier . '.$supinfo->supplier_name,
          'Debit'          =>  $paid_amount,
          'Credit'         =>  0,
          'IsPosted'       =>  1,
          'CreateBy'       =>  $receive_by,
          'CreateDate'     =>  $receive_date,
          'IsAppove'       =>  1
        ); 

        if ($purchase_id != '') {
            $this->db->where('purchase_id', $purchase_id);
            $this->db->update('product_purchase', $data);
            //account transaction update
             $this->db->where('VNo', $purchase_id);
            $this->db->delete('acc_transaction');
        
            //supplier ledger update

            $this->db->where('purchase_id', $purchase_id);
            $this->db->delete('product_purchase_details');
        }

        $this->db->insert('acc_transaction',$coscr);
        $this->db->insert('acc_transaction',$purchasecoatran);  
        $this->db->insert('acc_transaction',$expense);
        if($this->input->post('paytype') == 2){
          if(!empty($paid_amount)){
        $this->db->insert('acc_transaction',$bankc);
        $this->db->insert('acc_transaction',$supplier_debit);
      }
        }
        if($this->input->post('paytype') == 1){
          if(!empty($paid_amount)){
        $this->db->insert('acc_transaction',$cashinhand);
        $this->db->insert('acc_transaction',$supplier_debit); 
        }    
        }       

        $rate = $this->input->post('product_rate',TRUE);
        $p_id = $this->input->post('product_id',TRUE);
        $description = $this->input->post('description',TRUE);
        // print_r($description);die();

        $quantity = $this->input->post('product_quantity',TRUE);
        $t_price = $this->input->post('total_price',TRUE);

        $discount = $this->input->post('discount',TRUE);

        for ($i = 0, $n = count($p_id); $i < $n; $i++) {
            $product_quantity = $quantity[$i];
            $product_rate = $rate[$i];
            $product_id = $p_id[$i];
            $total_price = $t_price[$i];
            $desc = $description[$i];

            $disc = 0;

            $data1 = array(
                'purchase_detail_id' => $this->generator(15),
                'purchase_id'        => $purchase_id,
                'product_id'         => $product_id,
                'quantity'           => $product_quantity,
                'rate'               => $product_rate,
                'total_amount'       => $total_price,
                'discount'           => $disc,
                'description'       => $desc,
                'status'=> 1,
                'create_by' => $this->session->userdata('user_id'),
            );


            if (($quantity)) {

                $this->db->insert('product_purchase_details', $data1);
            }
        }
       
    }

public function get_purchases_invoice($invoice_no='')
{

    $this->db->where('purchase_order_id',$invoice_no);
    $this->db->select('po.*,si.* ,po.created_by AS create');
    $this->db->from('purchase_order po');
    $this->db->join('supplier_information si', 'po.supplier_id = si.supplier_id'); 
    $query = $this->db->get();
    return $query->result_array();
    

}
public function get_purchases_order($invoice_no)
{

   
    $this->db->where('purchase_id',$invoice_no);
    $this->db->select('po.*,pi.*');
    $this->db->from('purchase_order_details po');
    $this->db->join('product_information pi', 'po.product_id = pi.product_id'); 
    $query = $this->db->get();
    return $query->result_array();

}
public function get_supplier($purchase_id='')
{
   $sql= 'SELECT b.* FROM `purchase_order` a JOIN supplier_information b on a.supplier_id=b.supplier_id where a.purchase_order_id='.$purchase_id;
   $query=$this->db->query($sql);
   if ($query->num_rows() > 0) {
            return $query->result_array();
        }


}
public function company_info()
{
    $this->db->select('c.*,u.*');
    $this->db->from('company_information c');
    $this->db->join('user_login u', 'u.cid = c.company_id'); 
    $this->db->where('u.user_id',$_SESSION['user_id']);
    $query = $this->db->get();

    
    

   if ($query->num_rows() > 0) {
            return $query->result_array();
        }
}

 


 public function update_purchase_order() {
            // echo "<pre>";
            //print_r($this->input->post('slabs')); die;

          $purchase_id  = $this->input->post('purchase_id',TRUE);
          $paid_amount  = $this->input->post('paid_amount',TRUE);
          $due_amount   = $this->input->post('due_amount',TRUE);
          $bank_id      = $this->input->post('bank_id',TRUE);
        if(!empty($bank_id)){
       $bankname = $this->db->select('bank_name')->from('bank_add')->where('bank_id',$bank_id)->get()->row()->bank_name;
    
       $bankcoaid = $this->db->select('HeadCode')->from('acc_coa')->where('HeadName',$bankname)->get()->row()->HeadCode;
   }
        $p_id = $this->input->post('product_id',TRUE);
        $supplier_id = $this->input->post('supplier_id',TRUE);
        $supinfo =$this->db->select('*')->from('supplier_information')->where('supplier_id',$supplier_id)->get()->row();
        $sup_head = $supinfo->supplier_id.'-'.$supinfo->supplier_name;
        $sup_coa = $this->db->select('*')->from('acc_coa')->where('HeadName',$sup_head)->get()->row();
       $receive_by=$this->session->userdata('user_id');
        $receive_date=date('Y-m-d');
        $createdate=date('Y-m-d H:i:s');




        $data = array(
            'purchase_order_id'        => $purchase_id,
            'chalan_no'          => $this->input->post('chalan_no',TRUE),
            'supplier_id'        => $this->input->post('supplier_id',TRUE),
            'grand_total_amount' => $this->input->post('grand_total_price',TRUE),
            'total_discount'     => $this->input->post('discount',TRUE),
            'purchase_date'      => $this->input->post('purchase_date',TRUE),
            'purchase_details'   => $this->input->post('purchase_details',TRUE),
            'grand_total_amount'              => $this->input->post('total',TRUE),
        );
      $cashinhand = array(
      'VNo'            =>  $purchase_id,
      'Vtype'          =>  'Purchase',
      'VDate'          =>  $this->input->post('purchase_date',TRUE),
      'COAID'          =>  1020101,
      'Narration'      =>  'Cash in Hand For Supplier '.$supinfo->supplier_name,
      'Debit'          =>  0,
      'Credit'         =>  $paid_amount,
      'IsPosted'       =>  1,
      'CreateBy'       =>  $receive_by,
      'CreateDate'     =>  $createdate,
      'IsAppove'       =>  1
    ); 
                  // bank ledger
 $bankc = array(
      'VNo'            =>  $purchase_id,
      'Vtype'          =>  'Purchase',
      'VDate'          =>  $this->input->post('purchase_date',TRUE),
      'COAID'          =>  $bankcoaid,
      'Narration'      =>  'Paid amount for Supplier  '.$supinfo->supplier_name,
      'Debit'          =>  0,
      'Credit'         =>  $paid_amount,
      'IsPosted'       =>  1,
      'CreateBy'       =>  $receive_by,
      'CreateDate'     =>  $createdate,
      'IsAppove'       =>  1
    ); 

        
         $purchasecoatran = array(
          'VNo'            =>  $purchase_id,
          'Vtype'          =>  'Purchase',
          'VDate'          =>  $this->input->post('purchase_date',TRUE),
          'COAID'          =>  $sup_coa->HeadCode,
          'Narration'      =>  'Supplier -'.$supinfo->supplier_name,
          'Debit'          =>  0,
          'Credit'         =>  $this->input->post('grand_total_price',TRUE),
          'IsPosted'       =>  1,
          'CreateBy'       =>  $receive_by,
          'CreateDate'     =>  $receive_date,
          'IsAppove'       =>  1
        ); 
          ///Inventory credit
       $coscr = array(
      'VNo'            =>  $purchase_id,
      'Vtype'          =>  'Purchase',
      'VDate'          =>  $this->input->post('purchase_date',TRUE),
      'COAID'          =>  10107,
      'Narration'      =>  'Inventory Devit Supplier '.$supinfo->supplier_name,
      'Debit'          =>  $this->input->post('grand_total_price',TRUE),
      'Credit'         =>  0,//purchase price asbe
      'IsPosted'       => 1,
      'CreateBy'       => $receive_by,
      'CreateDate'     => $createdate,
      'IsAppove'       => 1
    ); 
          // Expense for company
         $expense = array(
      'VNo'            => $purchase_id,
      'Vtype'          => 'Purchase',
      'VDate'          => $this->input->post('purchase_date',TRUE),
      'COAID'          => 402,
      'Narration'      => 'Company Credit For Supplier'.$supinfo->supplier_name,
      'Debit'          => $this->input->post('grand_total_price',TRUE),
      'Credit'         => 0,//purchase price asbe
      'IsPosted'       => 1,
      'CreateBy'       => $receive_by,
      'CreateDate'     => $createdate,
      'IsAppove'       => 1
    ); 

         $supplier_debit = array(
          'VNo'            =>  $purchase_id,
          'Vtype'          =>  'Purchase',
          'VDate'          =>  $this->input->post('purchase_date',TRUE),
          'COAID'          =>  $sup_coa->HeadCode,
          'Narration'      =>  'Supplier . '.$supinfo->supplier_name,
          'Debit'          =>  $paid_amount,
          'Credit'         =>  0,
          'IsPosted'       =>  1,
          'CreateBy'       =>  $receive_by,
          'CreateDate'     =>  $receive_date,
          'IsAppove'       =>  1
        ); 

        if ($purchase_id != '') {

            $this->db->where('purchase_order_id', $purchase_id);
            $this->db->update('purchase_order', $data);
            //account transaction update
             $this->db->where('VNo', $purchase_id);
            $this->db->delete('acc_transaction');
        
            //supplier ledger update

            $this->db->where('purchase_id', $purchase_id);
            $this->db->delete('purchase_order_details');
        }

        $this->db->insert('acc_transaction',$coscr);
        $this->db->insert('acc_transaction',$purchasecoatran);  
        $this->db->insert('acc_transaction',$expense);
        if($this->input->post('paytype') == 2){
          if(!empty($paid_amount)){
        $this->db->insert('acc_transaction',$bankc);
        $this->db->insert('acc_transaction',$supplier_debit);
      }
        }
        if($this->input->post('paytype') == 1){
          if(!empty($paid_amount)){
        $this->db->insert('acc_transaction',$cashinhand);
        $this->db->insert('acc_transaction',$supplier_debit); 
        }    
        }       

        $rate = $this->input->post('product_rate',TRUE);
        $p_id = $this->input->post('product_id',TRUE);

        $quantity = $this->input->post('product_quantity',TRUE);
        $t_price = $this->input->post('total_price',TRUE);

        $discount = $this->input->post('discount',TRUE);

        $slabs_po = $this->input->post('slabs',TRUE);

        for ($i = 0, $n = count($p_id); $i < $n; $i++) {
            $product_quantity = $quantity[$i];
            $product_rate = $rate[$i];
            $product_id = $p_id[$i];
            $total_price = $t_price[$i];
            $slabs = $slabs_po[$i];
            $disc = $discount[$i];

            $data1 = array(
                'purchase_order_detail_id' => $this->generator(15),
                'purchase_id'        => $purchase_id,
                'product_id'         => $product_id,
                'quantity'           => $product_quantity,
                'rate'               => $product_rate,
                'create_by'          =>$this->session->userdata('user_id'),
                'total_amount'       => $total_price,
                'discount'           => $disc,
                'slabs'           => $slabs,
                'create_by'          =>  $this->session->userdata('user_id'),
                'status'             => 1
            );

            //print_r($data1); 


            if (($quantity)) {

                $this->db->insert('purchase_order_details', $data1);
            }
        }
        return true;
    }

    // Delete purchase Item

    public function purchase_search_list($cat_id, $company_id) {
        $this->db->select('a.*,b.sub_category_name,c.category_name');
        $this->db->from('purchases a');
        $this->db->join('purchase_sub_category b', 'b.sub_category_id = a.sub_category_id');
        $this->db->join('purchase_category c', 'c.category_id = b.category_id');
        $this->db->where('a.create_by',$this->session->userdata('user_id'));
        $this->db->where('a.sister_company_id', $company_id);
        $this->db->where('c.category_id', $cat_id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;
    }

    //Retrieve purchase_details_data
    public function purchase_details_data($purchase_id) {
        $this->db->select('a.*,b.*,c.*,d.*');
        $this->db->from('product_purchase a');
        $this->db->join('supplier_information b', 'b.supplier_id = a.supplier_id');
        $this->db->join('product_purchase_details c', 'c.purchase_id = a.purchase_id');
        $this->db->join('product_information d', 'd.product_id = c.product_id');
        $this->db->join('product_purchase e', 'e.purchase_id = c.purchase_id');
        $this->db->where('a.purchase_id', $purchase_id);
        $this->db->group_by('d.product_id');
        $query = $this->db->get(); 
     
        if ($query->num_rows() > 0) {
            
            return $query->result_array();
        }
       
    }
    public function get_po_details($po_num) {
        $this->db->select('a.*,b.*,c.*');
        $this->db->from('purchase_order a');
            $this->db->join('purchase_order_details b' , 'a.purchase_order_id=b.purchase_id');
            $this->db->join('supplier_information c', 'c.supplier_id = a.supplier_id');
        $this->db->where('a.chalan_no' ,$po_num);
            $query = $this->db->get();
         //  $query = $this->db->query($sql);
       
           if ($query->num_rows() > 0) {
               return $query->result_array();
           }

    }



    public function packing_details_data($expense_packing_id) {
       // $sql='SELECT * FROM `expense_packing_list_detail` a JOIN product_information b on b.product_id=a.product_id where a.expense_packing_id="'.$purchase_id.'"';
        // $sql='SELECT * FROM expense_packing_list as a JOIN expense_packing_list_detail as b ON b.product_id = a.product_id WHERE a.expense_packing_id = '.$expense_packing_id;
  //$sql = 'SELECT * FROM expense_packing_list as a JOIN expense_packing_list_detail as ac JOIN product_information as b ON b.product_id = a.product_id WHERE a.expense_packing_id = '.$expense_packing_id;
        $this->db->select('*');
     $this->db->from('expense_packing_list a');
         $this->db->join('expense_packing_list_detail ac' , 'a.expense_packing_id=ac.expense_packing_id');
         $this->db->join('product_information b' , 'b.product_id = ac.product_id');
     $this->db->where('a.expense_packing_id' , $expense_packing_id);
     $this->db->order_by("bundle_ref", "asc");
         $query = $this->db->get();
      //  $query = $this->db->query($sql);

        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
    }


      //Ocean Import Tracking details_data
    public function ocean_import_tracking_details_data($purchase_id) {
        $this->db->select('*');
        $this->db->from('ocean_import_tracking a');
        $this->db->join('supplier_information b', 'b.supplier_id = a.supplier_id');
        $this->db->where('a.ocean_import_tracking_id', $purchase_id);
     
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;
    }

    //This function will check the product & supplier relationship.
    public function product_supplier_check($product_id, $supplier_id) {
        $this->db->select('*');
        $this->db->from('supplier_product');
        $this->db->where('created_by',$this->session->userdata('user_id'));
        $this->db->where('product_id', $product_id);
        $this->db->where('supplier_id', $supplier_id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return true;
        }
        return 0;
    }

    //This function is used to Generate Key
    public function generator($lenth) {
        $number = array("A", "B", "C", "D", "E", "F", "G", "H", "I", "J", "K", "L", "N", "M", "O", "P", "Q", "R", "S", "U", "V", "T", "W", "X", "Y", "Z", "a", "b", "c", "d", "e", "f", "g", "h", "i", "j", "k", "l", "m", "n", "o", "p", "q", "r", "s", "t", "u", "v", "w", "x", "y", "z", "1", "2", "3", "4", "5", "6", "7", "8", "9", "0");

        for ($i = 0; $i < $lenth; $i++) {
            $rand_value = rand(0, 61);
            $rand_number = $number["$rand_value"];

            if (empty($con)) {
                $con = $rand_number;
            } else {
                $con = "$con" . "$rand_number";
            }
        }
        return $con;
    }

    public function purchase_delete($purchase_id = null) {
        //Delete product_purchase table
        $this->db->where('VNo', $purchase_id);
        $this->db->delete('acc_transaction');
        //Delete acc transaction
        $this->db->where('purchase_id', $purchase_id);
        $this->db->delete('product_purchase');
        //Delete product_purchase_details table
        $this->db->where('purchase_id', $purchase_id);
        $this->db->delete('product_purchase_details');
        return true;
        if ($this->db->affected_rows()) {
            return true;
        } else {
            return false;
        }
    }

//purchase list date to date
    public function purchase_list_date_to_date($start, $end) {
        $this->db->select('a.*,b.supplier_name');
        $this->db->from('product_purchase a');
        $this->db->join('supplier_information b', 'b.supplier_id = a.supplier_id');
        $this->db->where('a.create_by',$this->session->userdata('user_id'));
        $this->db->order_by('a.purchase_date', 'desc');
        $this->db->where('a.purchase_date >=', $start);
        $this->db->where('a.purchase_date <=', $end);
        $query = $this->db->get();

        $last_query = $this->db->last_query();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;
    }
// purchase list for pdf
     public function pdf_purchase_list() {
        $this->db->select('a.*,b.supplier_name');
        $this->db->from('product_purchase a');
        $this->db->join('supplier_information b', 'b.supplier_id = a.supplier_id');
        $this->db->where('a.create_by',$this->session->userdata('user_id'));
        $this->db->order_by('a.purchase_date', 'desc');
        $query = $this->db->get();

        $last_query = $this->db->last_query();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;
    }
    public function get_invoice_design()
    {
        $uid=$_SESSION['user_id'];
    $sql='select * from invoice_design where uid="'.$uid.'"';
     $query=$this->db->query($sql); 

        if ($query->num_rows() > 0) {

            return $query->result_array();

        }
        return false;
    }
    public function invoice_detail_edit($purchase_id)
    {
        $sql='SELECT * FROM `expense_packing_list_detail` WHERE expense_packing_id="'.$purchase_id.'"';
       
        $query=$this->db->query($sql);
   
         if ($query->num_rows() > 0) {
            return $query->result_array();
        }
    }

    public function invoice_product_edit($purchase_id)
    {
        $sql='SELECT * FROM `expense_packing_list_detail` a JOIN product_information b on b.product_id=a.product_id where a.expense_packing_id="'.$purchase_id.'"';

        $query=$this->db->query($sql);
         if ($query->num_rows() > 0) {
            return $query->result_array();
        }

    }
    public function invoice_edit($purchase_id)
    {
        $sql='SELECT * FROM `expense_packing_list` WHERE expense_packing_id="'.$purchase_id.'"';
      
        $query=$this->db->query($sql);
    
         if ($query->num_rows() > 0) {
            return $query->result_array();
        }

    }
    // csv upload purchase list
        public function purchase_csv_file() {
         $query = $this->db->select('a.chalan_no,a.purchase_id,b.supplier_name,a.purchase_date,a.grand_total_amount')
                ->from('product_purchase a')
                ->join('supplier_information b', 'b.supplier_id = a.supplier_id', 'left')
                ->where('create_by',$this->session->userdata('user_id'))
                ->order_by('a.purchase_date','desc')
                ->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;
    }
///////////////////////Invoice Area////////



}
