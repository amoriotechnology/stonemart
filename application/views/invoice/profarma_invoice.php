<!-- Product Purchase js -->
<?php    ?>
<script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.4/css/bootstrap-select.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.4/js/bootstrap-select.min.js"></script>
<script src="<?php echo base_url() ?>my-assets/js/countrypicker.js" type="text/javascript"></script>
<script src="<?php echo base_url() ?>my-assets/js/admin_js/invoice.js" type="text/javascript"></script>

<style>
    /*   Bootstrap Country Select CSS  */
 button[data-toggle="dropdown"].btn-default,
button[data-toggle="dropdown"]:hover {
background-color: white !important;
color: #2c3e50 !important;
border: 2px solid #dce4ec;
}
.bootstrap-select:not([class*=col-]):not([class*=form-control]):not(.input-group-btn) {
    width: 420px;
}
    </style>
<!-- Add New Purchase Start -->
<div class="content-wrapper">
    <section class="content-header">
        <div class="header-icon">
            <i class="pe-7s-note2"></i>
        </div>
        <div class="header-title">
            <h1>Proforma Invoice</h1>
            <small>Generate New Proforma Invoice</small>
            <ol class="breadcrumb">
                <li><a href="#"><i class="pe-7s-home"></i> <?php echo display('home') ?></a></li>
                <li><a href="#">Proforma</a></li>
                <li class="active">Proforma Invoice</li>
            </ol>
        </div>
    </section>

    <section class="content">
        <!-- Alert Message -->
        <?php
            $message = $this->session->userdata('message');
            if (isset($message)) {
        ?>
        <div class="alert alert-info alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
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
      <style>
        .ui-front{
            display:none;
        }
        input {
    border: none;
    background-color: #eee;
 }
textarea:focus, input:focus{
   
    outline: none;
}
 .text-right {
    text-align: left; 
}
</style>
        <!-- Purchase report -->
        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-bd lobidrag">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <h4>Create New Proforma Invoice</h4>
                        </div>
                    </div>

                    <div class="panel-body">
  <form id="insert_trucking"  method="post">  
                        <div class="row">
                            <div class="col-sm-6" style="display:none;">
                               <div class="form-group row">
                                    <label for="supplier_sss" class="col-sm-4 col-form-label">Exporter
                                        <i class="text-danger">*</i>
                                    </label>
                                    <div class="col-sm-6">
                                    <input type ="hidden" name="csrf_test_name" id="csrf_test_name" value="<?php echo $this->security->get_csrf_hash();?>">

                                               <textarea rows="4" cols="50" name="billing_address" class=" form-control" placeholder='Add Exporter Detail' id="billing_address"> </textarea>
                                    </div>
                                
                                </div> 
                            </div>

                             <div class="col-sm-6">
                                <div class="form-group row">
                                    <label for="date" class="col-sm-4 col-form-label">Date
                                        <i class="text-danger">*</i>
                                    </label>
                                    <div class="col-sm-8">
                                        <?php $date = date('Y-m-d'); ?>
                                        <input type="date" required tabindex="2" class="form-control datepicker" name="purchase_date" value="<?php echo $date; ?>" id="date" style="width:73%"> 
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group row">
                                    <label for="invoice_no" class="col-sm-4 col-form-label"><?php echo display('invoice_no')  ?>
                                        <i class="text-danger"></i>
                                    </label>
                                    <div class="col-sm-6">
                                        <input type="text" tabindex="3"   class="form-control" id="chalan_no" readonly name="chalan_no" value="<?php if(!empty($voucher_no[0]['voucher'])){
                                $curYear = date('Y'); 
                                $month = date('m');
                               $vn = substr($voucher_no[0]['voucher'],9)+1;
                               echo $voucher_n = 'PI'. $curYear.$month.'-'.$vn;
                             }else{
                                    $curYear = date('Y'); 
                                $month = date('m');
                               echo $voucher_n = 'PI'. $curYear.$month.'-'.'1';
                             } ?>"  />
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-6">
                               <div class="form-group row">
                                    <label for="adress" class="col-sm-4 col-form-label">Buyer / Customer
                                    </label>
                                    <div class="col-sm-8">
                                    <select name="customer_id" id="customer_id" class="form-control" style="width:73%">
                                    <option value="Select the Customer" selected disabled>Select the Customer</option>
                                        
                                            <?php foreach($customer as $customer){ ?>
                                                <option value="<?=$customer['customer_id']; ?>"><?=$customer['customer_name']; ?></option>
                                           <?php } ?>
                                        </select>
                                   <!--     <input type="text" id="currency_type" value="<?php // echo   ?>"/>-->
                                   <a href="#" class="client-add-btn btn " style="color:white;background-color:#38469f;" aria-hidden="true" data-toggle="modal" data-target="#cust_info"><i class="ti-plus m-r-2"></i></a>
                                    </div>
                                </div> 
                            </div>
                        </div>

                        <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>">
                        <input type="hidden" id="invoice_hdn"/> <input type="hidden" id="invoice_hdn1"/>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group row">
                                    <label for="etd" class="col-sm-4 col-form-label">Pre Carriage By
                                        <i class="text-danger"></i>
                                    </label>
                                    <div class="col-sm-6">
                                        <input type="text" tabindex="3" class="form-control" name="pre_carriage" id="pre_carriage" placeholder="Pre Carriage By" id="etd" />
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-6">
                               <div class="form-group row">
                                    <label for="eta" class="col-sm-4 col-form-label">Place of Receipt
                                    </label>
                                    <div class="col-sm-8">
                                        <textarea class="form-control" tabindex="4" id="eta" name="receipt" placeholder="Place of Receipt" rows="1" style="width:73%"   ></textarea>

                                    </div>
                                </div> 
                            </div>
                        </div>




                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group row">
                                    <label for="shipping_line" class="col-sm-4 col-form-label">Country of origin of goods
                                        <i class="text-danger"></i>
                                    </label>
                                    <div class="col-sm-6">
                                    <select class="selectpicker countrypicker form-control"  data-live-search="true" data-default="Select the Country"  name="country_goods" id="shipping_line" style="width:100%"></select>
                                 
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-6">
                               <div class="form-group row">
                                    <label for="container_no" class="col-sm-4 col-form-label">Country of final destination
                                    </label>
                                    <div class="col-sm-8">
                                    <select class="selectpicker countrypicker form-control" data-live-search="true" data-default="Select the Country" id="container_no" name="country_destination" placeholder="Country of final destination" style="width:73%"></select>
                                 
                                      
                                    </div>
                                </div> 
                            </div>
                        </div>

                          <div class="row">


                             <div class="col-sm-6">
                                <div class="form-group row">
                                    <label for="bl_number" class="col-sm-4 col-form-label">Port of loading
                                        <i class="text-danger"></i>
                                    </label>
                                    <div class="col-sm-6">
                                        <input type="text" tabindex="3" class="form-control" name="loading" placeholder="Port of loading" id="bl_number" />
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group row">
                                    <label for="bl_number" class="col-sm-4 col-form-label">Port of discharge
                                        <i class="text-danger"></i>
                                    </label>
                                    <div class="col-sm-6">
                                        <input type="text" tabindex="3" class="form-control" name="discharge" placeholder="Port of discharge" id="bd_number" />
                                    </div>
                                </div>
                            </div>

                           
                        </div>



                        <div class="row">


                             <div class="col-sm-6">
                                <div class="form-group row">
                                    <label for="bl_number" class="col-sm-4 col-form-label">Terms of payment and delivery
                                        <i class="text-danger"></i>
                                    </label>
                                    <div class="col-sm-6">
                                        <input type="text" tabindex="3" class="form-control" name="terms_payment" placeholder="Terms of payment and delivery" id="delivery" />
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group row">
                                    <label for="bl_number" class="col-sm-4 col-form-label">Description of goods
                                        <i class="text-danger"></i>
                                    </label>
                                    <div class="col-sm-6">

                                    <input type="text"  name="description_goods" class=" form-control" placeholder='Polished Granite slabs' id="goods"> 

                                    </div>
                                </div>
                            </div>

                           
                        </div>

<br>
                        <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <tr>
                            <td class="hiden" style="width:30%;border:none;text-align:end;font-weight:bold;">
                            Todays Rate : 
                         </td>
                
                                <td class="hiden" style="width:200px;padding:5px;background-color:#38469f;border:none;font-weight:bold;color:white;">1 <?php  echo $curn_info_default;  ?>
                                 = <input style="width:70px;text-align:center;padding:5px;color:black;" type="text" id="custocurrency_rate"/>&nbsp;<label for="custocurrency" style="color:white;"></label></td>
                    <td style="border:none;text-align:right;font-weight:bold;">Tax : 
                                 </td>
                                <td style="width:40%">
                               
                            <select name="tx" id="product_tax" class="form-control" onselect="gtotal();">
                                <option value="Select the Tax" selected>Select the Tax</option>
                                 <!-- <?php foreach($tax as $tx){?>
  
                                    <option value="<?php echo $tx['tax_id'].'-'.$tx['tax'].'%';?>">  <?php echo $tx['tax_id'].'-'.$tx['tax'].'%';  ?></option>
                                <?php } ?> -->
                            </select>
                            </td>
                            </tr>
                        </table>
                          
                            <table class="table table-bordered table-hover" id="normalinvoice">
                                <thead>
                                     <tr>
                                            <th class="text-center" width="20%">Product name<i class="text-danger">*</i></th> 
                                            <th class="text-center">In stock</th>
                                            <th class="text-center">Quantity / Sq ft.<i class="text-danger">*</i></th>
                                            <th class="text-center">Amount<i class="text-danger">*</i></th>

                                            <th class="text-center"><?php echo display('total') ?></th>
                                            <th class="text-center"><?php echo display('action') ?></th>
                                        </tr>
                                </thead>
                                <tbody id="addPurchaseItem">
                                    <tr>
                                        <td class="span3 supplier">
                                        <select name="product_name[]" id="prodt_1" class="form-control product_name" onchange="available_quantity(1);">
                                        <option value="Select the Product" selected>Select the Product</option>
                                           
                                        </select>

                                   
                                            <input type="hidden" class="autocomplete_hidden_value product_id_1" name="product_id[]" id="SchoolHiddenId"/>

                                            <input type="hidden" class="sl" value="1">
                                        </td>

                                       <td class="wt">
                                                <input type="text" id="available_quantity[]" name="available_quantity[]" class="form-control text-right available_quantity_1" placeholder="0.00" readonly/>
                                            </td>
                                        
                                            <td class="text-right">
                                                <input type="text" name="product_quantity[]" id="cartoon_1" required="" min="0" class="form-control text-right store_cal_1"  onkeyup='total_amt(1);'  placeholder="0.00" value=""  tabindex="6"/>
                                            </td>
                                            <td><span class='form-control' style='background-color: #eee;'><?php echo $currency;  ?>
                                                <input type="text" name="product_rate[]" required=""   id="product_rate_1" class="product_rate_1 text-right" placeholder="0.00" value="" min="0" tabindex="7" readonly/>
                                 </span> </td>
                                           

                                            <td><span class='form-control' style='background-color: #eee;'><?php echo $currency;  ?>
                                                <input class="total_price" type="text" name="total_price[]" id="total_price_1" value="0.00" readonly="readonly" />
                                 </span> </td>
                                            <td>

                                               

                                                <button  class="btn btn-danger text-right red" type="button" value="<?php echo display('delete')?>" onclick="deleteRow(this)" tabindex="8"><i class="fa fa-close"></i></button>
                                            </td>
                                    </tr>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        
                                        <td style="text-align:right;" colspan="4"><b><?php echo display('total') ?>:</b></td>
                                        <td><span class='form-control' style='background-color: #eee;'><?php echo $currency;  ?>
                                            <input type="text" id="Total"  name="total" value="0.00" readonly="readonly" />
                                 </span>   </td>
                                       
                                    </tr>
                                    <tr>
                                   
                                   <td style="text-align:right;" colspan="4"><b>Tax Details :</b></td>
                                   <td style="text-align:left;">
                                 <span class="form-control" style="background-color: #eee;"><?php echo $currency;  ?>
                                       <input type="text" id="tax_details" class="text-right" value="0.00" name="tax_details"  readonly="readonly" />
                                       </span></td>
                               
                                      
                               </tr>

                                    <tr> <td style="text-align:right;" colspan="4"><b><?php echo "Grand Total" ?>:</b></td>
                                    <td><span class='form-control' style='background-color: #eee;'><?php echo $currency;  ?>
                                            <input type="text" id="gtotal"  name="gtotal" value="0.00" readonly="readonly" />
                                 </span></td>
                                        <td> <button type="button" id="add_invoice_item" class="btn btn-info" name="add-invoice-item"  onClick="addInputField('addPurchaseItem');addprod();"  tabindex="9"><i class="fa fa-plus"></i></button>
  </tr>
                                    <tr> <td style="text-align:right;"  colspan="4"><b><?php echo "Grand Total" ?>:</b><br/><b>(Preferred Currency)</b></td>
                                    <td>
                                    <span class="form-control" style="background-color: #eee;" id="custospan"><input style="width:7%;font-weight:bold;" type="text" id="cus"  name="cus"  readonly="readonly" />
                                            <input type="text" id="customer_gtotal"  name="customer_gtotal" value="0.00" readonly="readonly" />
                                            </span></td>
                                      

                                            <input type="hidden" id="final_gtotal"  name="final_gtotal" />

                                            <input type="hidden" name="baseUrl" class="baseUrl" value="<?php echo base_url();?>"/></td>
                                    </tr>   
                                </tfoot>
                            </table>
                                         
                        </div>
                            <div class="form-group row">

                                    <label for="billing_address" class="col-sm-4 col-form-label">Account Details/Additional Information</label>

                                    <div class="col-sm-8">

                                        <textarea rows="4" cols="50" id="details" name="ac_details" class=" form-control" placeholder='Account Details/Additional Information' id="" ></textarea>
                                                <br>
                                                
                                    </div>

                                </div>
                                <div class="form-group row">

                                    <label for="remark" class="col-sm-4 col-form-label">Remarks/Conditions</label>

                                    <div class="col-sm-8">

                                        <textarea rows="4" cols="50" id="remarks" name="remarks" class=" form-control" placeholder='Remarks/Conditions' id="" value="<?php echo $remarks; ?>"> </textarea>

                                    </div>

                                </div>

                        <div class="form-group row">
                            <div class="col-sm-6">
                              
                               <table>
                                <tr>
                                    <td>
                                    <input type="submit" id="add_trucking" class="btn btn-primary btn-large" name="add-trucking" value="Save" />
                                <a  style="color: #fff;"  id="final_submit" class='final_submit btn btn-primary'>Submit</a>

                                <a id="download" style="color: #fff;" class='btn btn-primary'>Download</a>
                             </td>
                                    <td>&nbsp;</td>
                                    <td id="btn1_download">
                                        


                                    </td>
                                    <td>&nbsp;</td>
                                    
                                  
                                  
                                    
                                </tr>
                               </table>
                            </div>
                        </div>

<input type="hidden" id="currency"/>
                                
                                 </form>
                    </div>
                </div>

            </div>
        </div>


    </section>
    <input type="hidden" id="hdn"/>
<input type="text" id="gtotal_dup"/>

<div class="modal fade" id="myModal1" role="dialog" >
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content" style="margin-top: 190px;">
        <div class="modal-header" style="">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Sales - Profarma Invoice</h4>
        </div>
        <div class="modal-body" id="bodyModal1" style="text-align:center;font-weight:bold;">
          
      
     
        </div>
        <div class="modal-footer">
          
        </div>
      </div>
      
    </div>
  </div>
  <!------ add new customer -->
  <div class="modal fade" id="cust_info">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                	<h4 class="modal-title">ADD NEW CUSTOMER</h4>

            </div>
            <div class="container"></div>
            <div class="modal-body">  <div id="customeMessage" class="alert hide"></div>



<form id="instant_customer"  method="post">
    
                        <div class="modal-body"    style=" width: 90%;">
                            <div id="customeMessage" class="alert hide"></div>
                    <div class="panel-body">
                        <input type ="hidden" name="csrf_test_name" id="" value="<?php echo $this->security->get_csrf_hash();?>">
                        <div class="form-group row">
                            <label for="customer_name" class="col-sm-4 col-form-label"><?php echo display('customer_name') ?> <i class="text-danger">*</i></label>
                            <div class="col-sm-8">
                                <input class="form-control" name ="customer_name" id="" type="text" placeholder="<?php echo display('customer_name') ?>"  required="" tabindex="1">
                            </div>
                        </div>
	<div class="form-group row">
                            <label for="email" class="col-sm-4 col-form-label"><?php echo display('customer_email') ?><i class="text-danger">*</i></label>
                            <div class="col-sm-8">
                                <input class="form-control" name ="email" id="emaill" type="email" required="" placeholder="<?php echo display('customer_email') ?>" tabindex="2">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="emailaddress" class="col-sm-4 col-form-label"><?php echo display('email').' '.display('address'); ?> <i class="text-danger"></i><i class="text-danger">*</i></label>
                            <div class="col-sm-8">
                                <input class="form-control" name="emailaddress" id="emailaddress" type="email" placeholder="<?php echo display('email').' '.display('address') ?>"  >
                            </div>
                        </div>
  <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>">
                        <div class="form-group row">
                            <label for="mobile" class="col-sm-4 col-form-label"><?php echo display('customer_mobile') ?> <i class="text-danger">*</i></label>
                            <div class="col-sm-8">
                                <input class="form-control" name ="mobile" id="mobile" type="number" placeholder="<?php echo display('customer_mobile') ?>" min="0" tabindex="3" required>
                            </div>
                        </div>
                         <div class="form-group row">
                            <label for="phone" class="col-sm-4 col-form-label"><?php echo display('phone') ?> <i class="text-danger">*</i></label>
                            <div class="col-sm-8">
                                <input class="form-control" name="phone" id="phone" type="number" placeholder="<?php echo display('phone') ?>"  min="0" tabindex="2" required="">
                            </div>
                        </div>
                                 <div class="form-group row">
                            <label for="contact" class="col-sm-4 col-form-label"><?php echo display('contact'); ?> <i class="text-danger">*</i></label>
                            <div class="col-sm-8">
                                <input class="form-control" name="contact" id="contact" type="text" placeholder="<?php echo display('contact') ?>" required="" >
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="fax" class="col-sm-4 col-form-label"><?php echo display('fax'); ?> <i class="text-danger">*</i></label>
                            <div class="col-sm-8">
                                <input class="form-control" name="fax" id="fax" type="text" placeholder="<?php echo display('fax') ?>"  required="">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="Preferred currency" class="col-sm-4 col-form-label"> Preferred currency<i class="text-danger">*</i></label>
                            <div class="col-sm-8">
                            <select id="currency" name="currency1" style="max-width: -webkit-fill-available;">
    <option>Select currency</option>
    <option value="AFN">AFN - Afghan Afghani - ؋</option>
    <option value="ALL">ALL - Albanian Lek - Lek</option>
    <option value="DZD">DZD - Algerian Dinar - دج</option>
    <option value="AOA">AOA - Angolan Kwanza - Kz</option>
    <option value="ARS">ARS - Argentine Peso - $</option>
    <option value="AMD">AMD - Armenian Dram - ֏</option>
    <option value="AWG">AWG - Aruban Florin - ƒ</option>
    <option value="AUD">AUD - Australian Dollar - $</option>
    <option value="AZN">AZN - Azerbaijani Manat - m</option>
    <option value="BSD">BSD - Bahamian Dollar - B$</option>
    <option value="BHD">BHD - Bahraini Dinar - .د.ب</option>
    <option value="BDT">BDT - Bangladeshi Taka - ৳</option>
    <option value="BBD">BBD - Barbadian Dollar - Bds$</option>
    <option value="BYR">BYR - Belarusian Ruble - Br</option>
    <option value="BEF">BEF - Belgian Franc - fr</option>
    <option value="BZD">BZD - Belize Dollar - $</option>
    <option value="BMD">BMD - Bermudan Dollar - $</option>
    <option value="BTN">BTN - Bhutanese Ngultrum - Nu.</option>
    <option value="BTC">BTC - Bitcoin - ฿</option>
    <option value="BOB">BOB - Bolivian Boliviano - Bs.</option>
    <option value="BAM">BAM - Bosnia-Herzegovina Convertible Mark - KM</option>
    <option value="BWP">BWP - Botswanan Pula - P</option>
    <option value="BRL">BRL - Brazilian Real - R$</option>
    <option value="GBP">GBP - British Pound Sterling - £</option>
    <option value="BND">BND - Brunei Dollar - B$</option>
    <option value="BGN">BGN - Bulgarian Lev - Лв.</option>
    <option value="BIF">BIF - Burundian Franc - FBu</option>
    <option value="KHR">KHR - Cambodian Riel - KHR</option>
    <option value="CAD">CAD - Canadian Dollar - $</option>
    <option value="CVE">CVE - Cape Verdean Escudo - $</option>
    <option value="KYD">KYD - Cayman Islands Dollar - $</option>
    <option value="XOF">XOF - CFA Franc BCEAO - CFA</option>
    <option value="XAF">XAF - CFA Franc BEAC - FCFA</option>
    <option value="XPF">XPF - CFP Franc - ₣</option>
    <option value="CLP">CLP - Chilean Peso - $</option>
    <option value="CNY">CNY - Chinese Yuan - ¥</option>
    <option value="COP">COP - Colombian Peso - $</option>
    <option value="KMF">KMF - Comorian Franc - CF</option>
    <option value="CDF">CDF - Congolese Franc - FC</option>
    <option value="CRC">CRC - Costa Rican ColÃ³n - ₡</option>
    <option value="HRK">HRK - Croatian Kuna - kn</option>
    <option value="CUC">CUC - Cuban Convertible Peso - $, CUC</option>
    <option value="CZK">CZK - Czech Republic Koruna - Kč</option>
    <option value="DKK">DKK - Danish Krone - Kr.</option>
    <option value="DJF">DJF - Djiboutian Franc - Fdj</option>
    <option value="DOP">DOP - Dominican Peso - $</option>
    <option value="XCD">XCD - East Caribbean Dollar - $</option>
    <option value="EGP">EGP - Egyptian Pound - ج.م</option>
    <option value="ERN">ERN - Eritrean Nakfa - Nfk</option>
    <option value="EEK">EEK - Estonian Kroon - kr</option>
    <option value="ETB">ETB - Ethiopian Birr - Nkf</option>
    <option value="EUR">EUR - Euro - €</option>
    <option value="FKP">FKP - Falkland Islands Pound - £</option>
    <option value="FJD">FJD - Fijian Dollar - FJ$</option>
    <option value="GMD">GMD - Gambian Dalasi - D</option>
    <option value="GEL">GEL - Georgian Lari - ლ</option>
    <option value="DEM">DEM - German Mark - DM</option>
    <option value="GHS">GHS - Ghanaian Cedi - GH₵</option>
    <option value="GIP">GIP - Gibraltar Pound - £</option>
    <option value="GRD">GRD - Greek Drachma - ₯, Δρχ, Δρ</option>
    <option value="GTQ">GTQ - Guatemalan Quetzal - Q</option>
    <option value="GNF">GNF - Guinean Franc - FG</option>
    <option value="GYD">GYD - Guyanaese Dollar - $</option>
    <option value="HTG">HTG - Haitian Gourde - G</option>
    <option value="HNL">HNL - Honduran Lempira - L</option>
    <option value="HKD">HKD - Hong Kong Dollar - $</option>
    <option value="HUF">HUF - Hungarian Forint - Ft</option>
    <option value="ISK">ISK - Icelandic KrÃ³na - kr</option>
    <option value="INR">INR - Indian Rupee - ₹</option>
    <option value="IDR">IDR - Indonesian Rupiah - Rp</option>
    <option value="IRR">IRR - Iranian Rial - ﷼</option>
    <option value="IQD">IQD - Iraqi Dinar - د.ع</option>
    <option value="ILS">ILS - Israeli New Sheqel - ₪</option>
    <option value="ITL">ITL - Italian Lira - L,£</option>
    <option value="JMD">JMD - Jamaican Dollar - J$</option>
    <option value="JPY">JPY - Japanese Yen - ¥</option>
    <option value="JOD">JOD - Jordanian Dinar - ا.د</option>
    <option value="KZT">KZT - Kazakhstani Tenge - лв</option>
    <option value="KES">KES - Kenyan Shilling - KSh</option>
    <option value="KWD">KWD - Kuwaiti Dinar - ك.د</option>
    <option value="KGS">KGS - Kyrgystani Som - лв</option>
    <option value="LAK">LAK - Laotian Kip - ₭</option>
    <option value="LVL">LVL - Latvian Lats - Ls</option>
    <option value="LBP">LBP - Lebanese Pound - £</option>
    <option value="LSL">LSL - Lesotho Loti - L</option>
    <option value="LRD">LRD - Liberian Dollar - $</option>
    <option value="LYD">LYD - Libyan Dinar - د.ل</option>
    <option value="LTL">LTL - Lithuanian Litas - Lt</option>
    <option value="MOP">MOP - Macanese Pataca - $</option>
    <option value="MKD">MKD - Macedonian Denar - ден</option>
    <option value="MGA">MGA - Malagasy Ariary - Ar</option>
    <option value="MWK">MWK - Malawian Kwacha - MK</option>
    <option value="MYR">MYR - Malaysian Ringgit - RM</option>
    <option value="MVR">MVR - Maldivian Rufiyaa - Rf</option>
    <option value="MRO">MRO - Mauritanian Ouguiya - MRU</option>
    <option value="MUR">MUR - Mauritian Rupee - ₨</option>
    <option value="MXN">MXN - Mexican Peso - $</option>
    <option value="MDL">MDL - Moldovan Leu - L</option>
    <option value="MNT">MNT - Mongolian Tugrik - ₮</option>
    <option value="MAD">MAD - Moroccan Dirham - MAD</option>
    <option value="MZM">MZM - Mozambican Metical - MT</option>
    <option value="MMK">MMK - Myanmar Kyat - K</option>
    <option value="NAD">NAD - Namibian Dollar - $</option>
    <option value="NPR">NPR - Nepalese Rupee - ₨</option>
    <option value="ANG">ANG - Netherlands Antillean Guilder - ƒ</option>
    <option value="TWD">TWD - New Taiwan Dollar - $</option>
    <option value="NZD">NZD - New Zealand Dollar - $</option>
    <option value="NIO">NIO - Nicaraguan CÃ³rdoba - C$</option>
    <option value="NGN">NGN - Nigerian Naira - ₦</option>
    <option value="KPW">KPW - North Korean Won - ₩</option>
    <option value="NOK">NOK - Norwegian Krone - kr</option>
    <option value="OMR">OMR - Omani Rial - .ع.ر</option>
    <option value="PKR">PKR - Pakistani Rupee - ₨</option>
    <option value="PAB">PAB - Panamanian Balboa - B/.</option>
    <option value="PGK">PGK - Papua New Guinean Kina - K</option>
    <option value="PYG">PYG - Paraguayan Guarani - ₲</option>
    <option value="PEN">PEN - Peruvian Nuevo Sol - S/.</option>
    <option value="PHP">PHP - Philippine Peso - ₱</option>
    <option value="PLN">PLN - Polish Zloty - zł</option>
    <option value="QAR">QAR - Qatari Rial - ق.ر</option>
    <option value="RON">RON - Romanian Leu - lei</option>
    <option value="RUB">RUB - Russian Ruble - ₽</option>
    <option value="RWF">RWF - Rwandan Franc - FRw</option>
    <option value="SVC">SVC - Salvadoran ColÃ³n - ₡</option>
    <option value="WST">WST - Samoan Tala - SAT</option>
    <option value="SAR">SAR - Saudi Riyal - ﷼</option>
    <option value="RSD">RSD - Serbian Dinar - din</option>
    <option value="SCR">SCR - Seychellois Rupee - SRe</option>
    <option value="SLL">SLL - Sierra Leonean Leone - Le</option>
    <option value="SGD">SGD - Singapore Dollar - $</option>
    <option value="SKK">SKK - Slovak Koruna - Sk</option>
    <option value="SBD">SBD - Solomon Islands Dollar - Si$</option>
    <option value="SOS">SOS - Somali Shilling - Sh.so.</option>
    <option value="ZAR">ZAR - South African Rand - R</option>
    <option value="KRW">KRW - South Korean Won - ₩</option>
    <option value="XDR">XDR - Special Drawing Rights - SDR</option>
    <option value="LKR">LKR - Sri Lankan Rupee - Rs</option>
    <option value="SHP">SHP - St. Helena Pound - £</option>
    <option value="SDG">SDG - Sudanese Pound - .س.ج</option>
    <option value="SRD">SRD - Surinamese Dollar - $</option>
    <option value="SZL">SZL - Swazi Lilangeni - E</option>
    <option value="SEK">SEK - Swedish Krona - kr</option>
    <option value="CHF">CHF - Swiss Franc - CHf</option>
    <option value="SYP">SYP - Syrian Pound - LS</option>
    <option value="STD">STD - São Tomé and Príncipe Dobra - Db</option>
    <option value="TJS">TJS - Tajikistani Somoni - SM</option>
    <option value="TZS">TZS - Tanzanian Shilling - TSh</option>
    <option value="THB">THB - Thai Baht - ฿</option>
    <option value="TOP">TOP - Tongan pa'anga - $</option>
    <option value="TTD">TTD - Trinidad & Tobago Dollar - $</option>
    <option value="TND">TND - Tunisian Dinar - ت.د</option>
    <option value="TRY">TRY - Turkish Lira - ₺</option>
    <option value="TMT">TMT - Turkmenistani Manat - T</option>
    <option value="UGX">UGX - Ugandan Shilling - USh</option>
    <option value="UAH">UAH - Ukrainian Hryvnia - ₴</option>
    <option value="AED">AED - United Arab Emirates Dirham - إ.د</option>
    <option value="UYU">UYU - Uruguayan Peso - $</option>
    <option value="USD">USD - US Dollar - $</option>
    <option value="UZS">UZS - Uzbekistan Som - лв</option>
    <option value="VUV">VUV - Vanuatu Vatu - VT</option>
    <option value="VEF">VEF - Venezuelan BolÃ­var - Bs</option>
    <option value="VND">VND - Vietnamese Dong - ₫</option>
    <option value="YER">YER - Yemeni Rial - ﷼</option>
    <option value="ZMK">ZMK - Zambian Kwacha - ZK</option>
</select>    

                            </div>
                            <div id="pageLoader">
                            </div>
                            </div>
                      <div class="form-group row">
                            <label for="state" class="col-sm-4 col-form-label"><?php echo display('state'); ?> <i class="text-danger">*</i></label>
                            <div class="col-sm-8">
                                <input class="form-control" name="state" id="state" type="text" placeholder="<?php echo display('state') ?>" required="" >
                            </div>
                        </div>
                         <div class="form-group row">
                            <label for="zip" class="col-sm-4 col-form-label"><?php echo display('zip'); ?> <i class="text-danger">*</i></label>
                            <div class="col-sm-8">
                                <input class="form-control" name="zip" id="zip" type="text" placeholder="<?php echo display('zip') ?>"  required="">
                            </div>
                        </div>
                         <div class="form-group row">
                            <label for="country" class="col-sm-4 col-form-label"><?php echo display('country') ?> <i class="text-danger">*</i></label>
                            <div class="col-sm-8">
                                <input class="form-control" name="country" id="country" type="text" placeholder="<?php echo display('country') ?>" required="" >
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="address " class="col-sm-4 col-form-label"><?php echo display('customer_address') ?><i class="text-danger">*</i></label>
                            <div class="col-sm-8">
                                <textarea class="form-control" name="address" id="address " required="" rows="2" placeholder="<?php echo display('customer_address') ?>"></textarea>
                            </div>
                        </div>
                          <div class="form-group row">
                            <label for="address2 " class="col-sm-4 col-form-label"><?php echo display('address') ?><i class="text-danger">*</i></label>
                            <div class="col-sm-8">
                                <textarea class="form-control" required="" name="address2" id="address2" rows="2" placeholder="<?php echo display('address') ?>2" ></textarea>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="previous_balance" class="col-sm-4 col-form-label"><?php echo display('previous_balance') ?> <i class="text-danger">*</i></label>
                            <div class="col-sm-8">
                                <input class="form-control" name="previous_balance" id="previous_balance" type="text" min="0" placeholder="<?php echo display('previous_balance') ?>" tabindex="5" required="">
                            </div>
                        </div>
                    </div>
                    </div>
                        <div class="modal-footer">
                            <a href="#" class="btn btn-danger" data-dismiss="modal">Close</a>
                            <input type="submit" class="btn btn-success"  value="Submit">
                        </div>
                        </form>
  </div>
  </div>
  </div>  
          <div id="myModal3" class="modal fade">

	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title">Confirmation</h4>
			</div>
			<div class="modal-body">
				<p>Your Invoice is not submitted. Would you like to submit or discard
				</p>
				<p class="text-warning">
					<small>If you don't submit, your changes will not be saved.</small>
				</p>
			</div>
			<div class="modal-footer">
				<input type="submit" id="ok" class="btn btn-primary pull-left final_submit" onclick="submit_redirect()"  value="Submit"/>
                <button id="btdelete" type="button" class="btn btn-danger pull-left" onclick="discard()">Discard</button>
			
			</div>
		</div>
	</div>

</div>         

<style>
    #customer_id-button{
        display:none;
    }
 #btn1_download{
display:none;
 }
     #btn1_email{
        display:none;
     }
    </style>

    <script>


        var csrfName = '<?php echo $this->security->get_csrf_token_name();?>';
var csrfHash = '<?php echo $this->security->get_csrf_hash();?>';
$(document).ready(function(){
    $('#final_submit').hide();
$('#download').hide();

$('#email').hide();
    addprod();
    addtax();
  //  currency();
    $('#product_tax').on('change', function (e) {
        var first=$("#Total").val();
    var tax= $('#product_tax').val();

    // console.log(tax);

var field = tax.split('-');

var percent = field[1];
var answer=0;
  var answer = parseInt((percent / 100) * first);
   console.log("Answer : "+answer);
  var gtotal = parseInt(first + answer);
  console.log("gtotal :" +gtotal);
 var final_g= $('#final_gtotal').val();


 var amt=parseInt(answer)+parseInt(first);
 var num = isNaN(parseInt(amt)) ? 0 : parseInt(amt)
 var custo_amt=$('#custocurrency_rate').val();
 $("#gtotal").val(num);  
 console.log("numhere :"+num +"-"+custo_amt);
 var value=amt*parseInt(custo_amt);
 var custo_final = isNaN(parseInt(value)) ? 0 : parseInt(value)
$('#customer_gtotal').val(custo_final);  
var first=$("#Total").val();
    var tax= $('#product_tax').val();

    // console.log(tax);

var field = tax.split('-');

var percent = field[1];
var answer=0;
  var answer = parseInt((percent / 100) * first);
  // console.log(answer);
  var gtotal = parseInt(first + answer);
  console.log(gtotal);
 var final_g= $('#final_gtotal').val();


 var amt=parseInt(answer)+parseInt(first);
 var num = isNaN(parseInt(amt)) ? 0 : parseInt(amt)
 var custo_amt=$('#custocurrency_rate').val();
 $("#gtotal").val(num);  
 console.log(num +"-"+custo_amt);
 var value=amt*parseInt(custo_amt);
 var custo_final = isNaN(parseInt(value)) ? 0 : parseInt(value)
$('#customer_gtotal').val(custo_final);  
calculate();
});
});
$( document ).ready(function() {
                        $('.hiden').css("display","none");
$('#product_tax').on('change', function (e) {
    calculate();
});
$('#custocurrency_rate').on('change textInput input', function (e) {
    calculate();
});

$('.common_qnt').on('change textInput input', function (e) {
    calculate();
});

});


$('#customer_id').on('change', function (e) {
  
    var data = {
        value: $('#customer_id').val()
     };
    data[csrfName] = csrfHash;
    $.ajax({
        type:'POST',
        data: data,
     
        //dataType tells jQuery to expect JSON response
        dataType:"json",
        url:'<?php echo base_url();?>Cinvoice/getcustomer_byID',
        success: function(result, statut) {
            if(result.csrfName){
               //assign the new csrfName/Hash
               csrfName = result.csrfName;
               csrfHash = result.csrfHash;
            }
           // var parsedData = JSON.parse(result);
          //  alert(result[0].p_quantity);
          console.log(result[0]['currency_type']);
       $("#cus").val(result[0]['currency_type']);
        $("label[for='custocurrency']").html(result[0]['currency_type']);
       console.log('https://open.er-api.com/v6/latest/<?php echo $curn_info_default; ?>');
       $.getJSON('https://open.er-api.com/v6/latest/<?php echo $curn_info_default; ?>', 
function(data) {
 var custo_currency=result[0]['currency_type'];
    var x=data['rates'][custo_currency];
   // $('#cus').html(x);
 var Rate =parseFloat(x).toFixed(3);
  console.log(Rate);
  $('.hiden').show();
  Rate = isNaN(Rate) ? 0 : Rate;
  $("#custocurrency_rate").val(Rate);
});
      
        }
    });
<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

});

$('#product_tax').on('change', function (e) {
    var optionSelected = $("option:selected", this);
    var valueSelected = this.value;
    var total=$('#Total').val();
var tax= $('#product_tax').val();

var field = tax.split('-');

var percent = field[1];
percent=percent.replace("%","");
 var answer = (percent / 100) * parseInt(total);
$('#final_gtotal').val(answer);
   $('#hdn').val(valueSelected);
   console.log("taxi :"+valueSelected);
   // answer=answer.toFixed();
   $('#tax_details').val(answer +" ( "+tax+" )");
});
function addtax(){

var data = {};
  data[csrfName] = csrfHash;
$.ajax({
    type:'POST',
    data: data, 
    dataType:"json",
    url:'<?php echo base_url();?>Cproduct/get_all_tax',
    success: function(result, statut) {
        if(result.csrfName){
           csrfName = result.csrfName;
           csrfHash = result.csrfHash;
           console.log(result.product_name);
        }
        console.log(result);
        var len = result.length;
        for( var i = 0; i<len; i++){
                var tax_id = result[i]['tax_id'];
                var tax= result[i]['tax'];
                var value=tax_id+"-"+tax;
                $("#product_tax").append("<option value='"+value+"'>"+value+"</option>");

            }
        }

    });
}
function addprod(){

    var data = {
    };
      
    data[csrfName] = csrfHash;

    $.ajax({
        type:'POST',
        data: data, 
        dataType:"json",
        url:'<?php echo base_url();?>Cproduct/get_all_product1',
        success: function(result, statut) {
            console.log(result);
            if(result.csrfName){
               csrfName = result.csrfName;
               csrfHash = result.csrfHash;
               console.log(result.product_name);
            }
            var len = result.length;
            for( var i = 0; i<len; i++){
                    var product_name = result[i]['product_name'];
                    var product_model = result[i]['product_model'];
                    
                 var value=product_name+"-"+product_model;
                    $(".product_name").append("<option value='"+value+"'>"+value+"</option>");

                }
            }
 
        });
    }

    (function($) {
  $.fn.inputFilter = function(callback, errMsg) {
    return this.on("input keydown keyup mousedown mouseup select contextmenu drop focusout", function(e) {
      if (callback(this.value)) {
        // Accepted value
        if (["keydown","mousedown","focusout"].indexOf(e.type) >= 0){
          $(this).removeClass("input-error");
          this.setCustomValidity("");
        }
        this.oldValue = this.value;
        this.oldSelectionStart = this.selectionStart;
        this.oldSelectionEnd = this.selectionEnd;
      } else if (this.hasOwnProperty("oldValue")) {
        // Rejected value - restore the previous one
        $(this).addClass("input-error");
        this.setCustomValidity(errMsg);
        this.reportValidity();
        this.value = this.oldValue;
        this.setSelectionRange(this.oldSelectionStart, this.oldSelectionEnd);
      } else {
        // Rejected value - nothing to restore
        this.value = "";
      }
    });
  };
}(jQuery));

$("#custocurrency_rate").inputFilter(function(value) {
  return /^-?\d*[.,]?\d*$/.test(value); }, "Must be a floating (real) Number");


</script>
</div>
<!-- Purchase Report End -->

<input type="text" id="hdn" name="hdn"/>

<div id="result" style="display:none;"></div>


<script>
var csrfName = '<?php echo $this->security->get_csrf_token_name();?>';
var csrfHash = '<?php echo $this->security->get_csrf_hash();?>';

function discard(){
   $.get(
    "<?php echo base_url(); ?>Cinvoice/deleteprofarma/", 
   { val: $("#invoice_hdn1").val(), csrfName:csrfHash }, // put your parameters here
   function(responseText){
    console.log(responseText);
    window.btn_clicked = true;      //set btn_clicked to true
    var input_hdn="Your Invoice No :"+$('#invoice_hdn').val()+" has been Discared";
  
    console.log(input_hdn);
    $('#myModal3').modal('hide');
    $("#bodyModal1").html(input_hdn);
        $('#myModal1').modal('show');
    window.setTimeout(function(){
       

        window.location = "<?php  echo base_url(); ?>Cinvoice/manage_profarma_invoice";
      }, 2000);
   }
); 
}
     function submit_redirect(){
        window.btn_clicked = true;      //set btn_clicked to true
    var input_hdn="Your Invoice No :"+$('#invoice_hdn').val()+" has been created Successfully";
  
    console.log(input_hdn);
    $('#myModal3').modal('hide');
    $("#bodyModal1").html(input_hdn);
    $('#myModal1').modal('show');
    window.setTimeout(function(){
       

        window.location = "<?php  echo base_url(); ?>Cinvoice/manage_profarma_invoice";
      }, 2000);
     }
     $('#email').on('click', function (e) {
// var link=localStorage.getItem("truck");
// console.log(link);
 var popout = window.open("<?php  echo base_url(); ?>Cinvoice/proforma_with_attachment_cus/"+$('#invoice_hdn1').val());
    // window.setTimeout(function(){
    //     popout.close();
    //  }, 1500);
      e.preventDefault();
});
$('#insert_trucking').submit(function (event) {
   
       
    var dataString = {
        dataString : $("#insert_trucking").serialize()
    
   };
   dataString[csrfName] = csrfHash;
  
    $.ajax({
        type:"POST",
        dataType:"json",
        url:"<?php echo base_url(); ?>Cinvoice/performer_ins",
        data:$("#insert_trucking").serialize(),

        success:function (data) {
        console.log(data);
        var input_hdn="Profarma invoice created Successfully";
        $("#bodyModal1").html(input_hdn);
        $('#myModal1').modal('show');
        $('#final_submit').show();
        $('#download').show();
        $('#email').show();
    window.setTimeout(function(){
        $('.modal').modal('hide');
       
$('.modal-backdrop').remove();
 },2500);

            var split = data.split("/");
            $('#invoice_hdn1').val(split[0]);
         
     
         $('#invoice_hdn').val(split[1]);
       }

    });
    event.preventDefault();
});
$('#download').on('click', function (e) {
// var link=localStorage.getItem("truck");
// console.log(link);
 var popout = window.open("<?php  echo base_url(); ?>Cinvoice/performa_pdf/"+$('#invoice_hdn1').val());
 
  

});  

$('#email').on('click', function (e) {
// var link=localStorage.getItem("truck");
// console.log(link);
 var popout = window.open("<?php  echo base_url(); ?>Cinvoice/proforma_with_attachment_cus/"+$('#invoice_hdn1').val());
 
    // window.setTimeout(function(){
    //     popout.close();
   
    //  }, 1500);
      e.preventDefault();

}); 


$('.final_submit').on('click', function (e) {

    window.btn_clicked = true;      //set btn_clicked to true
    var input_hdn="Your Invoice No :"+$('#invoice_hdn').val()+" has been created Successfully";
  
    console.log(input_hdn);
    $("#bodyModal1").html(input_hdn);
        $('#myModal1').modal('show');
    window.setTimeout(function(){
       

        window.location = "<?php  echo base_url(); ?>Cinvoice/manage_profarma_invoice";
      }, 2000);
       
});

window.onbeforeunload = function(){
    if(!window.btn_clicked){
       // window.btn_clicked = true; 
        $('#myModal3').modal('show');
       return false;
    }
};
 


function addInputField(t) {
    //debugger;
    var row = $("#normalinvoice tbody tr").length;
    var count = row + 1;
      var  tab1 = 0;
      var  tab2 = 0;
      var  tab3 = 0;
      var  tab4 = 0;
      var  tab5 = 0;
      var  tab6 = 0;
      var  tab7 = 0;
      var  tab8 = 0;
      var  tab9 = 0;
      var  tab10 = 0;
      var  tab11 = 0;
      var  tab12 = 0;
    var limits = 500;
     var taxnumber = $("#txfieldnum").val();
    var tbfild ='';
    for(var i=0;i<taxnumber;i++){
        var taxincrefield = '<input id="total_tax'+i+'_'+count+'" class="total_tax'+i+'_'+count+'" type="hidden"><input id="all_tax'+i+'_'+count+'" class="total_tax'+i+'" type="hidden" name="tax[]">';
         tbfild +=taxincrefield;
    }
    if (count == limits)
        alert("You have reached the limit of adding " + count + " inputs");
    else {
        var a = "product_name_" + count,
                tabindex = count * 6,
                e = document.createElement("tr");
        tab1 = tabindex + 1;
        tab2 = tabindex + 2;
        tab3 = tabindex + 3;
        tab4 = tabindex + 4;
        tab5 = tabindex + 5;
        tab6 = tabindex + 6;
        tab7 = tabindex + 7;
        tab8 = tabindex + 8;
        tab9 = tabindex + 9;
        tab10 = tabindex + 10;
        tab11 = tabindex + 11;
        tab12 = tabindex + 12;
        e.innerHTML = "<td><select name='product_name[]' id='prodt_" + count + "' class='form-control product_name' onchange='available_quantity("+ count +");'>"+
        "<option value='Select the Product' selected>Select the Product</option></select>"+
        "<input type='hidden' class='autocomplete_hidden_value product_id_"+ count +"' name='product_id[]' id='SchoolHiddenId'/><td><input type='text' name='available_quantity[]' id='' class='form-control text-right common_avail_qnt available_quantity_" + count + "' placeholder='0.00' readonly='readonly' /></td><td> <input type='text' name='product_quantity[]'  required='required' onkeyup='total_amt(" + count + ");'  id='cartoon_" + count + "' class='form-control text-right store_cal_" + count + "'  placeholder='0.00' min='0' tabindex='" + tab3 + "'/></td>   <td><span class='form-control' style='background-color: #eee;'><?php echo $currency." ";  ?><input type='text' name='product_rate[]' onkeyup='quantity_calculate(" + count + ");' onchange='quantity_calculate(" + count + ");' id='product_rate_" + count + "' class='product_rate_" + count + "' required placeholder='0.00' min='0' tabindex='" + tab4 + "'/></span></td>   <td><span class='form-control' style='background-color: #eee;'><?php echo $currency." " ; ?><input class='common_total_price total_price' type='text' name='total_price[]' id='total_price_" + count + "' value='0.00' readonly='readonly'/></span></td><td>"+tbfild+"<input type='hidden' id='all_discount_" + count + "' class='total_discount dppr' name='discount_amount[]'/><button tabindex='" + tab5 + "' style='text-align: right;' class='btn btn-danger' type='button' value='Delete' onclick='deleteRow(this)'><i class='fa fa-close'></i></button></td>",
            
        document.getElementById(t).appendChild(e),
             
                count++
    }
}
function sumArray(array) {
  
  let sum = 0;

  for (let i = 0; i < array.length; i += 1) {
    sum += array[i];
  }
  
  return sum;
}

function available_quantity (id) {
    //create data object here so we can dynamically set new csrfName/Hash
    $('.product_name').on('change', function (e) {
        var name = 'available_quantity_'+ id;
   
   var amount = 'product_rate_'+ id;
   var pdt=$('#prodt_'+id).val();
   const myArray = pdt.split("-");
   var product_nam=myArray[0];
   var product_model=myArray[1];
  // alert(pdt);
    var data = {
       amount:'product_rate_'+ id,
       name:'available_quantity_'+ id,
       product_nam:product_nam,
       product_model:product_model
    };
    data[csrfName] = csrfHash;

    $.ajax({
        type:'POST',
        data: data, 
        //dataType tells jQuery to expect JSON response
        dataType:"json",
        url:'<?php echo base_url();?>Cinvoice/availability',
        success: function(result, statut) {
            if(result.csrfName){
               //assign the new csrfName/Hash
               csrfName = result.csrfName;
               csrfHash = result.csrfHash;
            }
           // var parsedData = JSON.parse(result);
          //  alert(result[0].p_quantity);
          $(".available_quantity_"+ id).val(result[0]['p_quantity']);
          $("#product_rate_"+ id).val(result[0]['price']);
          $(".product_id_"+ id).val(result[0]['product_id']);
          //  $('#available_quantity_'+ id).html(result[0].p_quantity);
            console.log(result);
        }
    });
});
}


var arr=[];

function total_amt(id){

var sum=0;

var total='total_price_'+id;

var quantity='cartoon_'+id;
var amount = 'product_rate_'+ id;
var grand=$('#gtotal').val();
var quan=$('#'+quantity).val();
var amt=$('#'+amount).val();
var result=parseInt(quan) * parseInt(amt);
result = isNaN(result) ? 0 : result;
arr.push(result);
$('#'+total).val(result);

gt();
}
function gt(){
var sum=0;
$('.total_price').each(function() {
sum += parseFloat($(this).val());
});
$('#Total').val(sum);

var final_g= $('#final_gtotal').val();
if(final_g !=''){
var first=$("#Total").val();
var tax= $('#product_tax').val();

var field = tax.split('-');

var percent = field[1];
var answer=0;
var answer =(parseInt(percent) / 100) * parseInt(first);
console.log(answer);
$('#tax_details').val(answer +" ( "+tax+" )");

var gtotal = parseInt(first + answer);
console.log(gtotal);
var amt=parseInt(answer)+parseInt(first);
var num = isNaN(parseInt(amt)) ? 0 : parseInt(amt)
var custo_amt=$('#custocurrency_rate').val();
$("#gtotal").val(num);  
console.log(num +"-"+custo_amt);
localStorage.setItem("customer_grand_amount_sale",num);

var value=parseInt(num*custo_amt);
var custo_final = isNaN(parseInt(value)) ? 0 : parseInt(value)
$('#customer_gtotal').val(custo_final);
}  
}
function calculate(){

var first=$("#Total").val();
var tax= $('#product_tax').val();
var field = tax.split('-');

var percent = field[1];
var answer=0;
var answer = parseInt((percent / 100) * first);
var gtotal = parseInt(first + answer);
console.log(gtotal);
var final_g= $('#final_gtotal').val();


var amt=parseInt(final_g)+parseInt(first);
var num = isNaN(parseInt(amt)) ? 0 : parseInt(amt);
$("#gtotal").val(num);  
localStorage.setItem("customer_grand_amount_sale",num);

var custo_amt=$('#custocurrency_rate').val();

console.log(num +"-"+custo_amt);
var value=parseInt(num*custo_amt);
var custo_final = isNaN(parseInt(value)) ? 0 : parseInt(value)
$('#customer_gtotal').val(custo_final);  
}

$('#instant_customer').submit(function (event) {
    var dataString = {
        dataString : $("#instant_customer").serialize()
   };
   dataString[csrfName] = csrfHash;
    $.ajax({
        type:"POST",
        dataType:"json",
        url:"<?php echo base_url(); ?>Cinvoice/instant_customer",
        data:$("#instant_customer").serialize(),
        success:function (data) {
            console.log(data);
            $.each(data, function (i, item) {
           
           result = '<option value=' + data[i].customer_id + '>' + data[i].customer_name + '</option>';
       });
       

       $('#customer_id').selectmenu(); 
       $('#customer_id').append(result).selectmenu('refresh',true);
       $("#bodyModal1").html("New Customer Added Successfully");
      
      $('#myModal1').modal('show');
      $('#cust_info').modal('hide');
     
    
      window.setTimeout(function(){
       $('#myModal1').modal('hide');
       $('.modal-backdrop').remove();

},2500);
      //  console.log(data);
        }
    });
    event.preventDefault();
});

const select = document.querySelectorAll(".currency");
const btn = document.getElementById("btn");
const num = document.getElementById("num");
const ans = document.getElementById("ans");
const err = document.getElementById("errorMSG");
const info = document.getElementById("info");
const baseFlagsUrl = "https://wise.com/public-resources/assets/flags/rectangle";
const currencyApiUrl = "https://open.er-api.com/v6/latest";

document.addEventListener('DOMContentLoaded', function(){ 
  fetch(currencyApiUrl)
    .then((data) => data.json())
    .then((data) => {
    err.innerHTML = "";
    display(data.rates);
    $('.currency').select2({
      width: 'resolve',
  
      maximumInputLength: 3
    });
    info.innerHTML = "Result: "+data.result+"<br>Provider: "+data.provider+"<br>Documentation: "+data.documentation+"<br>Terms of use: "+data.terms_of_use+"<br>Time Last Update UTC: "+data.time_last_update_utc;
    $('#pageLoader').fadeOut();
  }).catch(function(error) {
    err.innerHTML = "Error: " + error;
    $('#pageLoader').fadeOut();
  });
function display(data){
  const entries = Object.entries(data);
  for (var i = 0; i < entries.length; i++){
    select[0].innerHTML += `<option value="${entries[i][0]}">${entries[i][0]}</option>`;
    select[1].innerHTML += `<option value="${entries[i][0]}">${entries[i][0]}</option>`;
  }
  
}
});
/*
function gtotal(){
                  
    var first=$("#Total").val();
    var tax= $('#product_tax').val();

    // console.log(tax);

var field = tax.split('-');

var percent = field[1];
var answer=0;
  var answer = parseInt((percent / 100) * first);
  // console.log(answer);
  var gtotal = parseInt(first + answer);
 // console.log(gtotal);
 var final_g= $('#final_gtotal').val();
                  
                     var amt=parseInt(answer)+parseInt(gtotal);
                     console.log("Here  : "  +answer +"-"+gtotal);
 var num = isNaN(amt) ? 0 : amt;
 var custo_amt=$('#custocurrency_rate').val();
 $("#gtotal").val(num);  

 var value=amt*custo_amt;
 var custo_final = isNaN(parseInt(value)) ? 0 : parseInt(value)
$('#customer_gtotal').val(custo_final); 
                  
                  
                  }
                  */
      /*  $('#down').click(function(e){
    e.preventDefault();    
    var data=$('#hdn').val() ;
    

        $.ajax({url: "../assets/Invoice_PDF.php?"+data, success: function(result){
         //   window.location.href = '../assets/Invoice_PDF.php'; 
  }});



     });   

       $('#send').click(function(e){
    e.preventDefault();    

$.ajax({
            type: 'GET',
            url: '../assets/Download_Send_Mail.php',
       
            success: function (response) {
           
              //  console.log(response);
              window.location.href = '../assets/Download_Send_Mail.php'; 
    
            }
          });


     });  */ 
     
</script>


