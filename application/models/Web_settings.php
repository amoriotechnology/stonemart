<?php



if (!defined('BASEPATH'))

    exit('No direct script access allowed');



class Web_settings extends CI_Model {



    private $table = "language";

    private $phrase = "phrase";



    public function __construct() {

        parent::__construct();

    }



    //Retrieve Setting Edit Data

    public function retrieve_setting_editdata() {

        $this->db->select('*');

        $this->db->from('web_setting');

        $this->db->where('setting_id',1);

        $query = $this->db->get();

        if ($query->num_rows() > 0) {

            return $query->result_array();

        }

        return false;

    }

    // Email Invoice Setting
    public function retrieve_email_setting() {

        $uid=$_SESSION['user_id'];
        $this->db->select('*');

        $this->db->from('invoice_email');

        $this->db->where('uid',$uid);

        $query = $this->db->get();
       
        if ($query->num_rows() > 0) {

            return $query->result_array();

        }

        // return false;

    }


       public function retrieve_setting_new_sale_invoice() {

        $this->db->select('*');

        $this->db->from('sales_invoice_settings');

        $this->db->where('invoice_template', 'new_sale');

        $query = $this->db->get();

        if ($query->num_rows() > 0) {

            return $query->result_array();

        }

        return false;

    }




    //Update Categories

    public function update_setting($data) {

        $this->db->where('setting_id', 1);

        $this->db->update('web_setting', $data);

        return true;

    }
    public function admin_company() {
        $this->db->select('company_name' );
         $this->db->from('company_information');
       $this->db->where('create_by',$this->session->userdata('user_id'));
       $query = $this->db->get();
        if ($query->num_rows() > 0) {
         return $query->result_array();
         }
     }
     public function admin_user_mail_ids($company) {
            $this->db->select('a.email,b.email_id' );
             $this->db->from('company_information a');
             $this->db->join('user_login b', 'b.cid = a.company_id');
             $this->db->where('a.create_by',$this->session->userdata('user_id'));
             $this->db->where('a.company_name',$company);
           $query = $this->db->get();
            if ($query->num_rows() > 0) {
             return $query->result_array();
             }
 
 
     }
    public function invoice_desgn() {
        $purchase_id = date('YmdHis');
      
        $mysqltime = date ('Y-m-d H:i:s');

          
    $this->db->select("*");
    $this->db->from('invoice_design');
    $this->db->where('uid', $_POST['uid'] );
    $query = $this->db->get();
 
if ($query->num_rows() > 0 )
    {
        if($fomdata['input']=='header')
        {
            $data = array(
                'header' => $_POST['value'],
                'uid' => $_POST['id'],
               
                );
                $this->db->insert('invoice_design', $data);

        }
        if($_REQUEST['input']=='color')
        {
            $data = array(
                'color' => $_POST['value'],
                'uid' => $_POST['uid'],
               
                );
                $this->db->insert('invoice_design', $data);
           
        }
    }
    else{
        if($fomdata['input']=='header')
        {
            $data = array(
                'header' => $_POST['value']
                );
                $this->db->where('uid', $_POST['uid']);
              
                $this->db->update('invoice_design',$data);

         

        }
        if($_REQUEST['input']=='color')
        {
            $data = array(
                'color' => $_POST['value']
                );
                $this->db->where('uid', $_POST['uid']);
              
                $this->db->update('invoice_design',$data);

          

        }
    }
    return true;
    }
  
    

        

    public function update_invoice_set() {
        $purchase_id = date('YmdHis');
        $fomdata=$this->input->post();
        $mysqltime = date ('Y-m-d H:i:s');
        if($fomdata['form_type']=='sales&Profarma'){
          
    $this->db->select("*");
    $this->db->from('sales_invoice_settings');

    $this->db->where('user_id', $fomdata['uid'] );
    $this->db->where('invoice_template', $fomdata['form_type'] );

    $query = $this->db->get();

    if ( $query->num_rows() > 0 )
    {
      //  $row = $query->row_array();
      //  return $row;
      $data = array(
        'Time' => $mysqltime,
        'account' => $fomdata['acc'],
        'remarks'  => $fomdata['company_address']
        );
        $this->db->where('user_id', $fomdata['uid']);
        $this->db->where('invoice_template',$fomdata['form_type']);
        $this->db->update('sales_invoice_settings',$data);
    }else{
      
        $data = array(
            'user_id' => $fomdata['uid'],
            'invoice_template' => $fomdata['form_type'],
            'account'  =>  $fomdata['acc'],
            'remarks'  => $fomdata['company_address'],
            'Time'  => $mysqltime,
            );
            $this->db->insert('sales_invoice_settings', $data);
    }

}else///remarks
{
    $this->db->select('*');

    $this->db->from('sales_invoice_settings');

    $this->db->where('user_id', $fomdata['uid'] );
    $this->db->where('invoice_template', $fomdata['form_type'] );

    $query = $this->db->get();

    if ( $query->num_rows() > 0 )
    {

        $data = array(
            'Time' => $mysqltime,
            'remarks' => $fomdata['remarks']
           
            );
            $this->db->where('user_id', $fomdata['uid']);
            $this->db->where('invoice_template',$fomdata['form_type']);
            $this->db->update('sales_invoice_settings',$data);


//////////Update
		 

}
else
{

    $data = array(
        'user_id' => $fomdata['uid'],
        'invoice_template' => $fomdata['form_type'],
       'remarks'  => $fomdata['company_address'],
        'Time'  => $mysqltime,
        );
       $this->db->insert('sales_invoice_settings', $data);
		
}   
    
}
        
  
        return true;
       

    }


    public function update_invoice_setting($data) {

        $this->db->insert('invoice_settings', $data);

        return true;

    }

    //Update user setting

    public function update_user_setting($user_id,$data) {

        $this->db->where('user_id', $user_id);

        $this->db->update('users', $data);

        return true;

    }

    public function get_user_setting($user_id)
    {
         $this->db->where('user_id', $user_id);

        $query = $this->db->get('users');

        return $query->row_array();
    }

    public function app_settingsdata(){

        return $result = $this->db->select('*')

                        ->from('app_setting')

                        ->get()

                        ->result_array();

    }



    public function languages() {

        if ($this->db->table_exists($this->table)) {



            $fields = $this->db->field_data($this->table);



            $i = 1;

            foreach ($fields as $field) {

                if ($i++ > 2)

                    $result[$field->name] = ucfirst($field->name);

            }



            if (!empty($result))

                return $result;

        } else {

            return false;

        }

    }



    // currency list

    public function currency_list(){

        $this->db->select('*');

        $this->db->from('currency_tbl');

        $query = $this->db->get();

        if ($query->num_rows() > 0) {

            return $query->result();

        }

        return false;

    }

    // Bank list

     public function bank_list() {

        $this->db->select('*');

        $this->db->from('bank_add');

        $query = $this->db->get();



        if ($query->num_rows() > 0) {

            return $query->result_array();

        }

        return false;

    }



}

