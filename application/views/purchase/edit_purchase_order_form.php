<script src="<?php echo base_url(); ?>my-assets/js/admin_js/json/supplier.js.php" ></script>



<script src="<?php echo base_url()?>my-assets/js/admin_js/purchase.js" type="text/javascript"></script>





<!-- Add New Purchase Start -->

<div class="content-wrapper">

    <section class="content-header">

        <div class="header-icon">

            <i class="pe-7s-note2"></i>

        </div>

        <div class="header-title">

            <h1>Manage Purchase Order</h1>

            <small><?php echo display('add_new_purchase') ?></small>

            <ol class="breadcrumb">

                <li><a href="#"><i class="pe-7s-home"></i> <?php echo display('home') ?></a></li>

                <li><a href="#"><?php echo display('purchase') ?></a></li>

                <li class="active"><?php echo display('manage_purchase') ?></li>

            </ol>

        </div>

    </section>

    <?php
  $myArray = explode('(', $tax_details); 
 $tax_amt=$myArray[0];
 //$tax_des=$myArray[1];
$tax_des= str_replace(")","",$myArray[1]);
?>

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



        <!-- Purchase report -->

        <div class="row">

            <div class="col-sm-12">

                <div class="panel panel-bd lobidrag">

                    <div class="panel-heading">

                        <div class="panel-title">

                            <h4><?php echo display('edit_purchase') ?></h4>

                        </div>

                    </div>



                    <div class="panel-body">

                    <form id="insert_purchase"  method="post">      
                        



                        <div class="row">

                            <div class="col-sm-6">

                               <div class="form-group row">

                                    <label for="supplier_sss" class="col-sm-4 col-form-label">Vendor

                                        <i class="text-danger">*</i>

                                    </label>

                                    <div class="col-sm-6">

                                        <select name="supplier_id" id="supplier_id" class="form-control " required=""> 

                                          

                                            {supplier_list}

                                            <option value="{supplier_id}">{supplier_name}</option>

                                            {/supplier_list} 

                                            {supplier_selected}

                                            <option value="{supplier_id}" selected="">{supplier_name}</option>

                                            {/supplier_selected}

                                        </select>

                                    </div>



                                 

                                </div> 

                            </div>



                             <div class="col-sm-6">

                                 <div class="form-group row">
                                    <label for="supplier_sss" class="col-sm-4 col-form-label">Ship To
                                        <i class="text-danger">*</i>
                                    </label>
                                    <div class="col-sm-6">
                                         <textarea rows="4" cols="50" name="ship_to" class=" form-control" value="{ship_to}" id="">{ship_to} </textarea>
                                    </div>
                                </div> 


                            </div>

                        </div>



                        <div class="row">

                          <div class="col-sm-6">
                                <div class="form-group row">
                                    <label for="date" class="col-sm-4 col-form-label"><?php echo display('purchase_date') ?>
                                        <i class="text-danger">*</i>
                                    </label>
                                    <div class="col-sm-8">
                                        <?php $date = date('Y-m-d'); ?>
                                        <input type="date" required tabindex="2" class="form-control datepicker" name="purchase_date" value="{est_ship_date}" id="date"  />
                                    </div>
                                </div>
                            </div>


                            <div class="col-sm-6">
                                <div class="form-group row">
                                    <label for="invoice_no" class="col-sm-4 col-form-label">P.O Number
                                        <i class="text-danger"></i>
                                    </label>
                                    <div class="col-sm-6">
                                        <input type="text" readonly tabindex="3" class="form-control" name="chalan_no" value="{chalan_no}" placeholder="P.O Number" id="invoice_no" />
                                        <input type="hidden" tabindex="3" class="form-control" name="purchase_id" value="<?=$this->uri->segment(3); ?>" />
                                    </div>
                                </div>
                            </div>

                        </div>

                            <div class="row">

                                <div class="col-sm-6">
                               <div class="form-group row">
                                    <label for="adress" class="col-sm-4 col-form-label">Created By
                                    </label>
                                    <div class="col-sm-8">
                                        <textarea class="form-control" tabindex="4" id="adress" name="created_by" value="" placeholder="Created By" rows="1">{created_by}</textarea>
                                    </div>
                                </div> 
                            </div>



                            <div class="col-sm-6">
                               <div class="form-group row">
                                    <label for="adress" class="col-sm-4 col-form-label">Payment Terms
                                    </label>
                                    <div class="col-sm-8">
                  <!-- <textarea class="form-control" tabindex="4" id="adress" name="payment_terms" value="" placeholder="Payment Terms" rows="1">{payment_terms}</textarea>  -->
                                    <select class="form-control" tabindex="4" id="adress"  name="payment_terms" id="payment_terms" class=" form-control" placeholder='Payment Terms' id="payment_terms" rows="1">{payment_terms}   >

     <option value="{payment_terms}">{payment_terms}%</option>
    <option value="100%">100%</option>
    <option value="30-70">30-70%</option>
    <option value="70-30">70-30%</option>
    <option value="75-25">75-25%</option>
    <option value="25-75">25-75%</option>
    </select>
                                </div>
                                </div>
                            </div>
                        </div>
                           

                        </div>




                        <div class="row">
                               <div class="col-sm-6">
                               <div class="form-group row">
                                    <label for="adress" class="col-sm-4 col-form-label">Shipment Terms
                                    </label>
                                    <div class="col-sm-8">
                                    <select class="form-control" tabindex="4" id="adress" name="shipment_terms" placeholder="Shipment Terms" rows="1" required>
                             
                                   <option value="{shipment_terms}">{shipment_terms}</option>
                                    <option value="IF">IF</option>
                                   <option value="ICF">ICF</option>
                                   </select>
                                </div>
                                </div>
                            </div>


                               <div class="col-sm-6">
                                <div class="form-group row">
                                    <label for="date" class="col-sm-4 col-form-label">Est. Ship Date
                                        <i class="text-danger">*</i>
                                    </label>
                                    <div class="col-sm-8">
                                        <?php $date = date('Y-m-d'); ?>
                                        <input type="date" required tabindex="2" class="form-control datepicker" name="est_ship_date" value="{est_ship_date}" id="date"  />
                                    </div>
                                </div>
                            </div>

                            <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>">


                           <!--  <div class="col-sm-6">
                                <div class="form-group row">
                                    <label for="shipping_line" class="col-sm-4 col-form-label">Shipping Line
                                        <i class="text-danger"></i>
                                    </label>
                                    <div class="col-sm-6">
                                        <input type="text" tabindex="3" class="form-control" name="shipping_line" placeholder="Shipping Line" id="shipping_line" />
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-6">
                               <div class="form-group row">
                                    <label for="container_no" class="col-sm-4 col-form-label">Container No
                                    </label>
                                    <div class="col-sm-8">
                                        <textarea class="form-control" tabindex="4" id="container_no" name="container_no" placeholder="Container No" rows="1"></textarea>
                                    </div>
                                </div> 
                            </div> -->
                        </div>




                      <br>

                        <div class="table-responsive">
                        <table class="taxtab table table-bordered table-hover" >
                        <tr>
                        <td class="hiden" style="width:30%;border:none;text-align:end;font-weight:bold;">
                            Todays Rate : 
                         </td>
                
                                <td class="hiden" style="width:200px;padding:5px;background-color: #38469f;border:none;font-weight:bold;color:white;">1 <?php  echo $curn_info_default;  ?>
                                 = <input style="width:50px;text-align:center;color:black;padding:5px;" type="text" class="custocurrency_rate"/>&nbsp;<label for="custocurrency" style="color:white;background-color: #38469f;"></label></td>
                    <td style="border:none;text-align:right;font-weight:bold;">Tax : 
                                 </td>
                                <td style="width:40%">
<select name="tx"  id="product_tax" class="form-control" >
<option value="<?php  echo $tax_des; ?>" selected><?php  echo $tax_des; ?></option>
<?php foreach($tax as $tx){?>
  
    <option value="<?php echo $tx['tax_id'].'-'.$tx['tax'].'%';?>">  <?php echo $tx['tax_id'].'-'.$tx['tax'].'%';  ?></option>
<?php } ?>
</select>
</td>
</tr>
</table>
                             <table class="table table-bordered table-hover" id="purchaseTable">
                                <thead>
                                     <tr>
                                            <th class="text-center" width="20%">Product Name(SKU)<i class="text-danger">*</i></th> 
                                            <th class="text-center" width="20%">Description<i class="text-danger">*</i></th> 
                                            <th class="text-center">Balance</th> 
                                            <th class="text-center">Quantity (Sq. ft)<i class="text-danger">*</i></th>
                                            <th class="text-center">Unit Cost<i class="text-danger">*</i></th>
                                            <th class="text-center"><?php echo display('total') ?></th>
                                            <th class="text-center"><?php echo display('action') ?></th>
                                        </tr>
                                </thead>
                                <tbody id="addPurchaseItem">

                                     {purchase_info}
                                    <tr>
                                    <td class="span3 supplier">
                                         
                                         <select  name="product_name[]" id="product_name_1" class="form-control product_name ;" onchange="product_detail(1);">
                                      <option value="{product_name}" selected>{product_name}</option>
                                         
                                  </select>

                                  <input type="hidden"  name="product_id[]" value="{product_id}" id="prod_id_1"/>
                                         

                                 

                                       

                                      </td>


                                         

                                    <td class="wt">
                                                <input type="text" id="" name="description[]" value="{description}" class="form-control text-right" placeholder="0.00"/>
                                            </td>



                                           <td class="wt">
                                                <input type="text" id="available_quantity_1" class="form-control text-right stock_ctn_1" placeholder="0.00" readonly/>
                                            </td>
                                        
                                            <td class="text-right">
                                                <input type="text" name="product_quantity[]" id="cartoon_1" required="" min="0" class="form-control text-right store_cal_1" onkeyup="calculate_store(1);" onchange="calculate_store(1);" placeholder="0.00" value="{quantity}"  tabindex="6"/>
                                            </td>
                                            <td class="test" style="text-align:left;">
                                            <table border="0">
      <tr>
        <td><?php  echo $currency." ";  ?></td>
        <td>   <input type="text" style="border:none;" name="product_rate[]" required="" onkeyup="calculate_store(1);" onchange="calculate_store(1);" id="product_rate_1" class="form-control product_rate_1 text-right" placeholder="0.00" value="{rate}" min="0" tabindex="7"/></td>
     </tr>
   </table>


                                              
                                            </td>
                                           

                                            <td style="text-align:left;">
                                            <table border="0">
      <tr>
        <td><?php  echo $currency." ";  ?></td>
        <td>   <input class="form-control total_price text-right" type="text" name="total_price[]" id="total_price_1" value="{total_amount}" readonly="readonly" /></td>
     </tr>
   </table>
                                               
                                            </td>
                                            <td>

                                               

                                                <button  class="btn btn-danger text-right red" type="button" value="<?php echo display('delete')?>" onclick="deleteRow(this)" tabindex="8"><i class="fa fa-close"></i></button>
                                            </td>
                                    </tr>
                                         {/purchase_info}
                                </tbody>
                                <tfoot>
                                <tr>
                                   
                                   <td style="text-align:right;" colspan="5"><b><?php echo display('total') ?>:</b></td>
                                   <td style="text-align:left;">
                                   <table border="0">
      <tr>
        <td><?php  echo $currency." ";  ?></td>
        <td>    <input type="text" id="Total" class="total" value="0.00" style="padding:5px;" value="{grand_total_amount}" class="text-right" name="total"  readonly="readonly" />  </td>
     </tr>
   </table>  
                                       </td>
                               
                                      
                               </tr>
                               
                                    <tr>
                                   
                                   <td style="text-align:right;" colspan="5"><b>Tax Details :</b></td>
                                   <td style="text-align:left;">
                                   <table border="0">
      <tr>
        <td><?php  echo $currency." ";  ?></td>
        <td>     <input type="text" id="tax_details" class="tax_details" style="padding:5px;" class="text-right" value="<?php  echo $tax_details; ?>" name="tax_details"  readonly="readonly" />  </td>
     </tr>
   </table> 
                                 </td>
                               
                                      
                               </tr>
                               <tr> <td style="text-align:right;" colspan="5"><b><?php echo "Grand Total" ?>:</b></td>
                                    <td>
                                    <table border="0">
      <tr>
        <td><?php  echo $currency." ";  ?></td>
        <td>      <input type="text" id="gtotal" style="padding:5px;"  name="gtotal" class="gtotal"  value="<?php  echo $grand_total_amount; ?>"  readonly="readonly" />  </td>
      
    </tr>
   </table> 
                          </td>
                                        
                          <td> <button type="button" id="add_invoice_item" class="btn btn-info" name="add-invoice-item" onclick="addPurchaseOrderField2('addPurchaseItem');"  tabindex="9" ><i class="fa fa-plus"></i></button></td>
                                           
                                    </tr>
                                    <tr>
                  
                
                             
                    <td style="border:none;text-align:right;font-weight:bold;" colspan="5"><b><?php echo "Grand Total" ?>:</b><br/><b>(Preferred Currency)</b></td>
                                    <td>
                                    <table border="0">
      <tr>
      <td class="cus" name="cus"></td>
        <td>       <input type="text" style="padding:5px;"  id="vendor_gtotal"  class="vendor_gtotal" name="vendor_gtotal" value="<?php  echo $gtotal_preferred_currency; ?>" readonly="readonly" /> </td>
     </tr>
   </table> 
                                          </td>
                                      

                                            <input type="hidden" id="final_gtotal"  name="final_gtotal" />

                                            <input type="hidden" name="baseUrl" class="baseUrl" value="<?php echo base_url();?>"/></td>
                                    </tr> 
                                    
                              
   </table>
                                           </td>
                                      

                                        
                                        </tr>
                                    



                                  
                                       <!--  <tr>
                                       
                                        <td class="text-right" colspan="4"><b><?php echo display('discounts') ?>:</b></td>
                                        <td class="text-right">
                                            <input type="text" id="discount" class="text-right form-control discount" onkeyup="total_amt(1)" name="discount" placeholder="0.00" value="" />
                                        </td>
                                        <td> 

                                           </td>
                                    </tr> -->

                                    <!--     <tr>
                                        
                                        <td class="text-right" colspan="4"><b><?php echo display('grand_total') ?>:</b></td>
                                        <td class="text-right">
                                            <input type="text" id="grandTotal" class="text-right form-control" name="grand_total_price" value="0.00" readonly="readonly" />
                                        </td>
                                        <td> </td>
                                    </tr> -->
                                    <!--      <tr>
                                        
                                        <td class="text-right" colspan="4"><b><?php echo display('paid_amount') ?>:</b></td>
                                        <td class="text-right">
                                            <input type="text" id="paidAmount" class="text-right form-control" onKeyup="invoice_paidamount()" name="paid_amount" value="" />
                                        </td>
                                        <td> </td>
                                    </tr> -->
                                    <!-- <tr>
                                        <td colspan="2" class="text-right">
                                             <input type="button" id="full_paid_tab" class="btn btn-warning" value="<?php echo display('full_paid') ?>" tabindex="16" onClick="full_paid()"/>
                                        </td>
                                        <td class="text-right" colspan="2"><b><?php echo display('due_amount') ?>:</b></td>
                                        <td class="text-right">
                                            <input type="text" id="dueAmmount" class="text-right form-control" name="due_amount" value="0.00" readonly="readonly" />
                                        </td>
                                        <td></td>
                                    </tr> -->
                                </tfoot>
                            </table>

                        </div>

                        <div class="row">
                        <div class="col-sm-6">
                               <div class="form-group row">
                                    <label for="adress" class="col-sm-4 col-form-label">Message / Notes on Invoice
                                    </label>
                                    <div class="col-sm-8">
                                        <textarea class="form-control" rows="4" cols="50" id="adress" name="message_invoice" placeholder="Message on Invoice" rows="1"></textarea>
                                    </div>
                                </div> 
                            </div>


                             <div class="col-sm-6">
                               <div class="form-group row">
                                    <label for="adress" class="col-sm-4 col-form-label">Attachements
                                    </label>
                                    <div class="col-sm-8">
                                       <input type="file" name="attachments" class="form-control">
                                    </div>
                                </div> 
                            </div>
                        </div>




                         <div class="form-group row">
                            <div class="col-sm-6">
                                <input type="submit" id="add_purchase" class="btn btn-primary btn-large" name="add-purchase-order" value="Save" />
                                <a  style="color: #fff;"  id="final_submit" class='final_submit btn btn-primary'>Submit</a>
                                  
                               

<a id="download" style="color: #fff;" class='btn btn-primary'>Download</a>
                               

                            </div>
                            </div>
                        </div>

                     
        </form> <input type="hidden" id="invoice_hdn"/> <input type="hidden" id="invoice_hdn1"/>
                    </div>

                </div>

            </div>

        </div>

    </section>

</div>


  <div class="modal fade" id="myModal1" role="dialog" >
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content" style="    margin-top: 190px;">
        <div class="modal-header" style="">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Expense - Purchase Order</h4>
        </div>
        <div class="modal-body" id="bodyModal1" style="font-weight:bold;text-align:center;">
          
        
     
        </div>
        <div class="modal-footer">
          
        </div>
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
					<small>If you don't save, your changes will not be saved.</small>
				</p>
			</div>
			<div class="modal-footer">
            <input type="submit" id="ok" class="btn btn-primary pull-left final_submit" onclick="submit_redirect()"  value="Submit"/>
                <button id="btdelete" type="button" class="btn btn-danger pull-left" onclick="discard()">Discard</button>
			</div>
		</div>
	</div>
</div> 
           
 

          
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script>
   
var csrfName = '<?php echo $this->security->get_csrf_token_name();?>';
var csrfHash = '<?php echo $this->security->get_csrf_hash();?>';

var limits = 500;
function addPurchaseOrderField2(divName){
    var table = document.getElementById("purchaseTable");
    var tbodyRowCount = table.tBodies[0].rows.length;
   
   
    console.log(tbodyRowCount);
    var count = tbodyRowCount + 1;
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
    if (count == limits){
        alert("You have reached the limit of adding " + count + " inputs");
    }
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
   e.innerHTML ='<td class="span3 supplier"><select  name="product_name[]" id="product_name_'+ count +'" class="form-control product_name ;" onchange="product_detail(' + count + ');"><option value="Select the Product" selected>Select the Product</option> </select> <input type="hidden"  name="product_id[]" id="prod_id_'+ count +'"/>  <input type="hidden" class="sl" value="'+ count +'">  </td>  <td class="wt"> <input type="text" class="form-control text-right" name="slabs[]" placeholder="0.00" /> </td>  <td class="wt"> <input type="text" id="available_quantity_'+ count +'" value="0.00" class="form-control text-right stock_ctn_'+ count +'"/> </td><td class="text-right"><input type="text" name="product_quantity[]" tabindex="'+tab2+'" required  id="cartoon_'+ count +'" class="form-control text-right store_cal_' + count + '" onkeyup="calculate_store(' + count + ');" onchange="calculate_store(' + count + ');" placeholder="0.00" value="" min="0"/>  </td> <td style="width:220px"><table border="0"> <tr><td><?php  echo $currency." ";  ?></td> <td><input style="padding:5px;" type="text" name="product_rate[]" required="" onkeyup="calculate_store(' + count + ');" onchange="calculate_store(' + count + ');" id="product_rate_'+ count +'" readonly class="product_rate_'+ count +'" placeholder="0.00" value="" min="0" tabindex="7"/></td></tr></table> </td> <td> <table border="0"> <tr><td><?php  echo $currency." ";  ?></td><td><input class="total_price" type="text" style="padding:5px;" name="total_price[]" id="total_price_'+ count +'" value="0.00" readonly="readonly" /></td> </tr> </table> </td><td> <input type="hidden" id="total_discount_1" class="" /><input type="hidden" id="all_discount_1" class="total_discount" /><button style="text-align: right;" class="btn btn-danger red" type="button"  onclick="deleteRow(this)" tabindex="8"><i class="fa fa-close"></i></button></td>';
     
   document.getElementById(divName).appendChild(e),
                document.getElementById(a).focus(),
                document.getElementById("add_invoice_item").setAttribute("tabindex", tab6);
      
        document.getElementById("add_purchase").setAttribute("tabindex", tab6);
   
       
        count++;

        $("select.form-control:not(.dont-select-me)").select2({
            placeholder: "Select option",
            allowClear: true
        });
    }
}
function product_detail(id){

var pdt=$('#product_name_'+id).val();
   const myArray = pdt.split("-");
   var product_nam=myArray[0];
   var product_model=myArray[1];

  var data = {
    
       product_nam:product_nam,
       product_model:product_model
    };
    data[csrfName] = csrfHash;

    $.ajax({
        type:'POST',
        data: data, 
     dataType:"json",
        url:'<?php echo base_url();?>Cinvoice/product_id',
        success: function(result, statut) {
      console.log(result);
          $("#prod_id_"+id).val(result[0]['product_id']);
          $("#product_rate_"+id).val(result[0]['price']);
          1
        }
    });

  
}
$( document ).ready(function() {
    $('.hiden').hide();
  var data = {
      value: $('#supplier_id').val()
   };
  data[csrfName] = csrfHash;
  $.ajax({
      type:'POST',
      data: data,
      //dataType tells jQuery to expect JSON response
      dataType:"json",
      url:'<?php echo base_url();?>Cinvoice/getvendor_products',
      success: function(states, statut) {
        console.log(states);
        // $(".product_name").html("");
             if (Object.keys(states).length > 0) {
               // $(".product_name").append($('<option></option>').val(0).html('Select a Product'));
             }
             else {
                    $(".product_name").append($('<option></option>').val(0).html(''));
             }
           $.each(states, function (i, state) {
            $(".product_name").append($('<option></option>').val(state.product_name+'-'+state.products_model).html(state.product_name+'-'+state.products_model));
           });;
      }
  });

  
  var data = {
      value: $('#supplier_id').val()
   };
  data[csrfName] = csrfHash;
  $.ajax({
      type:'POST',
      data: data,
   
      //dataType tells jQuery to expect JSON response
      dataType:"json",
      url:'<?php echo base_url();?>Cinvoice/getvendor',
      success: function(result, statut) {
          if(result.csrfName){
             //assign the new csrfName/Hash
             csrfName = result.csrfName;
             csrfHash = result.csrfHash;
          }
         // var parsedData = JSON.parse(result);
        //  alert(result[0].p_quantity);
        console.log(result[0]['currency_type']);
     // $("#vendor_gtotal").val(result[0]['currency_type']);
      $(".cus").html(result[0]['currency_type']);
        $("label[for='custocurrency']").html(result[0]['currency_type']);
       console.log('https://open.er-api.com/v6/latest/<?php echo $curn_info_default; ?>');
       $.getJSON('https://open.er-api.com/v6/latest/<?php echo $curn_info_default; ?>', 
function(data) {
 var custo_currency=result[0]['currency_type'];
    var x=data['rates'][custo_currency];
 var Rate =parseFloat(x).toFixed(3);
  console.log(Rate);
  $('.hiden').show();
  $(".custocurrency_rate").val(Rate);
  var total=$('#Total').val();
  var final=parseInt(total * Rate);
 // $('#vendor_gtotal').val(final);
});
      }
  });

  $('#custocurrency_rate').on('change', function (e) {
    var total=$('#Total').val();
    var custocurrency_rate=$("#custocurrency_rate").val();
    var final=parseInt(total * custocurrency_rate);


  });



    $('#final_submit').hide();
$('#download').hide();
                      
});
$('#supplier_id').on('change', function (e) {
  
  var data = {
      value: $('#supplier_id').val()
   };
  data[csrfName] = csrfHash;
  $.ajax({
      type:'POST',
      data: data,
   
      //dataType tells jQuery to expect JSON response
      dataType:"json",
      url:'<?php echo base_url();?>Cinvoice/getvendor',
      success: function(result, statut) {
          if(result.csrfName){
             //assign the new csrfName/Hash
             csrfName = result.csrfName;
             csrfHash = result.csrfHash;
          }
         // var parsedData = JSON.parse(result);
        //  alert(result[0].p_quantity);
        console.log(result[0]['currency_type']);
     // $("#vendor_gtotal").val(result[0]['currency_type']);
      $(".cus").val(result[0]['currency_type']);
        $("label[for='custocurrency']").html(result[0]['currency_type']);
       console.log('https://open.er-api.com/v6/latest/<?php echo $curn_info_default; ?>');
       $.getJSON('https://open.er-api.com/v6/latest/<?php echo $curn_info_default; ?>', 
function(data) {
 var custo_currency=result[0]['currency_type'];
    var x=data['rates'][custo_currency];
 var Rate =parseFloat(x).toFixed(3);
 Rate = isNaN(Rate) ? 0 : Rate;
  console.log(Rate);
  $('.hiden').show();
  $("#custocurrency_rate").val(Rate);
});
      }
  });


});
$('#insert_purchase').submit(function (event) {
    var dataString = {
        dataString : $("#insert_purchase").serialize()
    
   };
   dataString[csrfName] = csrfHash;
  
    $.ajax({
        type:"POST",
        dataType:"json",
        url:"<?php echo base_url(); ?>Cpurchase/insert_purchase_order",
        data:$("#insert_purchase").serialize(),

        success:function (data) {
     
   
            var split = data.split("/");
            $('#invoice_hdn1').val(split[0]);
         
     
            $('#invoice_hdn').val(split[1]);
            $("#myModal1").find('.modal-body').text('Purchase Order Created Successfully');
            $('#final_submit').show();
$('#download').show();
    $('#myModal1').modal('show');
    window.setTimeout(function(){
        $('.modal').modal('hide');
       
$('.modal-backdrop').remove();
$("#bodyModal1").html("");
 },2500);


       }

    });
    event.preventDefault();
});
$('#download').on('click', function (e) {

 var popout = window.open("<?php  echo base_url(); ?>Cpurchase/purchase_order_details_data/"+$('#invoice_hdn1').val());
 
   

});  
function discard(){
   $.get(
    "<?php echo base_url(); ?>Cpurchase/deletepurchaseorder/", 
   { val: $("#invoice_hdn1").val(), csrfName:csrfHash }, // put your parameters here
   function(responseText){
    console.log(responseText);
    window.btn_clicked = true;      //set btn_clicked to true
    var input_hdn="Your Packing List No :"+$('#invoice_hdn').val()+" has been Discarded";
  
    console.log(input_hdn);
    $('#myModal3').modal('hide');
    $("#bodyModal1").html(input_hdn);
        $('#myModal1').modal('show');
    window.setTimeout(function(){
       

        window.location = "<?php  echo base_url(); ?>Cpurchase/manage_purchase_order";
      }, 2000);
   }
); 
}
     function submit_redirect(){
        window.btn_clicked = true;      //set btn_clicked to true
        var input_hdn="Your Packing List No :"+$('#invoice_hdn').val()+" has been saved Successfully";
  
    console.log(input_hdn);
    $('#myModal3').modal('hide');
    $("#bodyModal1").html(input_hdn);
        $('#myModal1').modal('show');
    window.setTimeout(function(){
       

        window.location = "<?php  echo base_url(); ?>Cpurchase/manage_purchase_order";
      }, 2000);
     }
$('.final_submit').on('click', function (e) {

    window.btn_clicked = true;      //set btn_clicked to true
    var input_hdn="Your Invoice No : "+$('#invoice_hdn').val()+" has been Updated Successfully";
  
    console.log(input_hdn);
    $("#myModal1").find('.modal-body').text(input_hdn);
   // $("#bodyModal1").html(input_hdn);
    $('#myModal1').modal('show');
    window.setTimeout(function(){
        $('.modal').modal('hide');
       
$('.modal-backdrop').remove();
 },2500);
    window.setTimeout(function(){
       

        window.location = "<?php  echo base_url(); ?>Cpurchase/manage_purchase_order";
      }, 2500);
       
});

window.onbeforeunload = function(){
    if(!window.btn_clicked){
       // window.btn_clicked = true; 
        $('#myModal3').modal('show');
       return false;
    }
}
$('#product_tax').on('change', function (e) {
        var first=$("#Total").val();
    var tax= $('#product_tax').val();
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
 var custo_amt=$('.custocurrency_rate').val(); 
 console.log("numhere :"+num +"-"+custo_amt);
 var value=parseInt(num*custo_amt);
 var custo_final = isNaN(parseInt(value)) ? 0 : parseInt(value)
$('#vendor_gtotal').val(custo_final);  
$('#balance').val(custo_final);
calculate();
});

$( document ).ready(function() {
    $('#gtotal').on('change textInput input', function (e) {
    calculate();
});
$('.custocurrency_rate').on('change textInput input', function (e) {
    calculate();
});

$('.common_qnt').on('change textInput input', function (e) {
    calculate();
});

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
  $('#tax_details').val(answer +" ( "+tax+" )");
   calculate();
 
});
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

 var num = isNaN(amt) ? 0 : amt;
 var custo_amt=$('.custocurrency_rate').val();
 $("#gtotal").val(num);  
 console.log(num +"-"+custo_amt);
 localStorage.setItem("customer_grand_amount_sale",num);

 var value=parseInt(num*custo_amt);
 var custo_final = isNaN(parseInt(value)) ? 0 : parseInt(value)
$('#vendor_gtotal').val(custo_final);
$('#balance').val(custo_final);
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
var num = isNaN(amt) ? 0 : amt;
$("#gtotal").val(num);  
localStorage.setItem("customer_grand_amount_sale",num);

var custo_amt=$('.custocurrency_rate').val();

console.log(num +"-"+custo_amt);
var value=parseInt(num*custo_amt);
var custo_final = isNaN(parseInt(value)) ? 0 : parseInt(value)
$('#vendor_gtotal').val(custo_final);  
$('#balance').val(custo_final);
}
function supplier(id){
    console.log(id);
  var data = {
      value: $('#supplier_id').val()
   };
  data[csrfName] = csrfHash;
  $.ajax({
      type:'POST',
      data: data,
   
      //dataType tells jQuery to expect JSON response
      dataType:"json",
      url:'<?php echo base_url();?>Cinvoice/getvendor_products',
      success: function(states, statut) {
        console.log(states);
        var select = $("#product_name_"+id);
       // $("#product_name_"+id).html("");
//        for (i = 0; 1 < Object.keys(states).length; i++) {
//     select.append($('<option>', {
//         value: i,
//         text: states[i]
//     }));
// }
  if (Object.keys(states).length > 0) {
                $(".product_name").append($('<option></option>').val(0).html('Select a Product'));
             }
          $.each(states, function (i, state) {
            $(".product_name").append($('<option></option>').val(state.product_name+'-'+state.products_model).html(state.product_name+'-'+state.products_model));
           });;
      }
  });
  }
  $('#add_invoice_item,#supplier_id').on('click change', function (e) {
  var data = {
      value: $('#supplier_id').val()
   };
  data[csrfName] = csrfHash;
  $.ajax({
      type:'POST',
      data: data,
      //dataType tells jQuery to expect JSON response
      dataType:"json",
      url:'<?php echo base_url();?>Cinvoice/getvendor_products',
      success: function(states, statut) {
        console.log(states);
        // $(".product_name").html("");
             if (Object.keys(states).length > 0) {
               // $(".product_name").append($('<option></option>').val(0).html('Select a Product'));
             }
             else {
                    $(".product_name").append($('<option></option>').val(0).html(''));
             }
           $.each(states, function (i, state) {
            $(".product_name").append($('<option></option>').val(state.product_name+'-'+state.products_model).html(state.product_name+'-'+state.products_model));
           });;
      }
  });
});
    </script>

<style>
        input {
    border: none;
    
 }
textarea:focus, input:focus{
   
    outline: none;
}
 .text-right {
    text-align: left; 
}
.form-control[disabled], .form-control[readonly], fieldset[disabled] .form-control {
        background-color:white;
        border: none;
        }
</style>


         




