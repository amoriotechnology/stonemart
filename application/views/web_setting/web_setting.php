<!-- Add new customer start -->
<!-- Latest compiled and minified CSS -->

<div class="content-wrapper">
    <section class="content-header">
        <div class="header-icon">
            <i class="pe-7s-note2"></i>
        </div>
        <div class="header-title">
            <h1><?php echo display('update_setting') ?></h1>
            <small><?php echo display('update_your_web_setting') ?></small>
            <ol class="breadcrumb">
                <li><a href="#"><i class="pe-7s-home"></i> <?php echo display('home') ?></a></li>
                <li><a href="#"><?php echo display('web_settings') ?></a></li>
                <li class="active"><?php echo display('update_setting') ?></li>
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
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
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

        <!-- New customer -->
        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-bd lobidrag">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <h4><?php echo display('update_setting') ?> </h4>
                        </div>
                    </div>
                    <?php echo form_open_multipart('Cweb_setting/update_setting', array('class' => 'form-vertical', 'id' => 'insert_customer')) ?>
                    <div class="panel-body">

                        <div class="form-group row">
                            <label for="logo" class="col-sm-3 col-form-label"><?php echo display('logo') ?> <i class="text-danger">*</i></label>
                            <div class="col-sm-6">
                                <input class="form-control" name ="logo" id="logo" type="file" tabindex="1">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="logo" class="col-sm-3 col-form-label"></label>
                            <div class="col-sm-6">
                                <img src="{logo}" class="img img-responsive" height="100" width="100">
                                <input name ="old_logo" type="hidden" value="{logo}">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="invoice_logo" class="col-sm-3 col-form-label"><?php echo display('invoice_logo') ?> <i class="text-danger">*</i></label>
                            <div class="col-sm-6">
                                <input class="form-control" name ="invoice_logo" id="invoice_logo" type="file" tabindex="2">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="invoice_logo" class="col-sm-3 col-form-label"></label>
                            <div class="col-sm-6">
                                <img src="{invoice_logo}" class="img img-responsive" height="100" width="100">
                                <input name ="old_invoice_logo" type="hidden" value="{invoice_logo}">
                            </div>
                        </div>


                        <div class="form-group row">
                            <label for="favicon" class="col-sm-3 col-form-label"><?php echo display('favicon') ?> <i class="text-danger">*</i></label>
                            <div class="col-sm-6">
                                <input class="form-control" name ="favicon" id="favicon" type="file" tabindex="3">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="favicon" class="col-sm-3 col-form-label"></label>
                            <div class="col-sm-6">
                                <img src="{favicon}" class="img img-responsive" height="100" width="100">
                                <input name ="old_favicon" type="hidden" value="{favicon}" tabindex="4">
                            </div>
                        </div>
                        <div id="mask"></div>
                        <div class="form-group row">
                            <label for="currency" class="col-sm-3 col-form-label">Notification Setting<i class="text-danger">*</i></label>
                            <div class="col-sm-6">
                            <span style="padding-left:10px;font-size:20px;">Sales Setting</span>   <span class="open-modal"><i class="fa fa-cog fa-2x"  aria-hidden="true" id="sale" data-toggle="modal" data-target="#basicModal"></span></i>
                            <span style="padding-left:10px;font-size:20px;">Expense Setting</span>   <i class="fa fa-cog fa-2x" aria-hidden="true" id="expense" data-toggle="modal" data-target="#expensemodel"></i>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="currency" class="col-sm-3 col-form-label"><?php echo display('currency') ?> <i class="text-danger">*</i></label>
                            <div class="col-sm-6">
                                <select class="form-control" name="currency" id="currency" tabindex="5">
                                    <?php foreach($currency_list as $clist){?>
                         <option value="<?php echo $clist->icon?>" <?php if ($currency == $clist->icon) {
                        echo "selected";
                    } ?>><?php echo $clist->currency_name.' '.$clist->icon;?></option>
                                    <?php }?>
                                   </select>
                            </div>
                        </div>

                         <div class="form-group row">
                            <label for="time_zone" class="col-sm-3 col-form-label"><?php echo display('timezone') ?> <i class="text-danger">*</i></label>
                            <div class="col-sm-6">
                                  <?php echo form_dropdown('timezone', $timezonelist,$timezone , array('class'=>'form-control')); ?>
                            </div>
                        </div>


                        <div class="form-group row">
                            <label for="currency_position" class="col-sm-3 col-form-label"><?php echo display('currency_position') ?> <i class="text-danger">*</i></label>
                            <div class="col-sm-6">
                                <select class="form-control" name="currency_position" id="currency_position" tabindex="6">
                                    <option value=""><?php echo display('select_one') ?></option>
                                    <option value="0" <?php if ($currency_position == 0) {
                                    echo "selected";
                                } ?>><?php echo display('left') ?></option>
                                    <option value="1" <?php if ($currency_position == 1) {
                                    echo "selected";
                                } ?>><?php echo display('right') ?></option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="footer_text" class="col-sm-3 col-form-label"><?php echo display('footer_text') ?> <i class="text-danger">*</i></label>
                            <div class="col-sm-6">
                                <input class="form-control" name ="footer_text" id="footer_text" type="text" placeholder="Foter Text" value="{footer_text}" tabindex="7">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="language" class="col-sm-3 col-form-label"><?php echo display('language') ?> <i class="text-danger">*</i></label>
                            <div class="col-sm-6">
                        <?php
                        echo form_dropdown('language', $language, '', 'class="form-control" id="language" tabindex="8"');
                        ?>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="lrt" class="col-sm-3 col-form-label"><?php echo display('ltr_or_rtr') ?> <i class="text-danger">*</i></label>
                            <div class="col-sm-6">
                                <select class="form-control" name="rtr" id="lrt" tabindex="9">
                                    <option value=""><?php echo display('select_one') ?></option>
                                    <option value="0" <?php if ($rtr == 0) {
    echo "selected";
} ?>><?php echo display('ltr') ?></option>
                                    <option value="1" <?php if ($rtr == 1) {
    echo "selected";
} ?>><?php echo display('rtr') ?></option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="captcha" class="col-sm-3 col-form-label"><?php echo display('captcha') ?> <i class="text-danger">*</i></label>
                            <div class="col-sm-6">
                                <select class="form-control" name="captcha" id="captcha" tabindex="10">
                                    <option value=""><?php echo display('select_one') ?></option>
                                    <option value="0" <?php if ($captcha == 0) {
                        echo "selected";
                    } ?>><?php echo display('active') ?></option>
                                    <option value="1" <?php if ($captcha == 1) {
                        echo "selected";
                    } ?>><?php echo display('inactive') ?></option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="site_key" class="col-sm-3 col-form-label"><?php echo display('site_key') ?> <i class="text-danger">*</i></label>
                            <div class="col-sm-6">
                                <input class="form-control" name ="site_key" id="site_key" type="text" placeholder="<?php echo display('site_key') ?> " value="{site_key}" tabindex="11">
                            </div>
                        </div>    

                        <div class="form-group row">
                            <label for="secret_key" class="col-sm-3 col-form-label"><?php echo display('secret_key') ?> <i class="text-danger">*</i></label>
                            <div class="col-sm-6">
                                <input class="form-control" name ="secret_key" id="secret_key" type="text" placeholder="<?php echo display('secret_key') ?>" value="{secret_key}" tabindex="12">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="discount_type" class="col-sm-3 col-form-label"><?php echo display('discount_type') ?> <i class="text-danger">*</i></label>
                            <div class="col-sm-6">
                                <select class="form-control" name="discount_type" id="discount_type" tabindex="10">
                                    <option value=""><?php echo display('select_one') ?></option>
                                    <option value="1" <?php if ($discount_type == 1) {
                        echo "selected";
                    } ?>><?php echo display('discount_percentage') ?> %</option>
                                    <option value="2" <?php if ($discount_type == 2) {
                        echo "selected";
                    } ?>><?php echo display('discount') ?></option>
                                    <option value="3" <?php if ($discount_type == 3) {
                        echo "selected";
                    } ?>><?php echo display('fixed_dis') ?></option>
                                </select>
                            </div>
                        </div>


                        <div class="form-group row">
                            <label for="example-text-input" class="col-sm-4 col-form-label"></label>
                            <div class="col-sm-6">
                                <input type="submit"  id="add-customer" class="btn btn-success btn-large" name="add-customer" value="<?php echo display('save_changes') ?>" tabindex="13"/>
                            </div>
                        </div>
                    </div>
<?php echo form_close() ?>
                </div>
            </div>
        </div>
    </section>
</div>
<style>
    input,select,.company,.mail {
  margin-bottom: 1em;
  padding: .25em;
  border: 0;
  border: 1px solid #337ab7;

  letter-spacing: .15em;
  border-radius: 0;
  &:focus, &:active {
    outline: 0;
   
  }
}
.table{
    font-weight:normal;
    padding:10px;
}
th{
    text-align:center;
}
.modal-dialog {
    position: fixed;
    margin: auto;
    width: 320px;
    height: 100%;
    left: 500px;
}
#bold{
    font-weight:bold;
}

    </style>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<!-- Add new customer end -->
<div class="modal fade" id="basicModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"  aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content" style="width: max-content;">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                </button>
                 <h4 class="modal-title" id="myModalLabel">SALES SETTING</h4>

            </div>
            <div class="modal-body">
                <table class="table table-bordered" id="table" >
                    <thead style="text-align:center;">
                        <tr>
                        <th><input type="checkbox"  onClick="toggle(this)"/>&nbsp;SELECTALL </th>
                            <th>DATES</th>
                            <th>TIME</th>
                            <th>SOURCE</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                        <td> <input type="checkbox" id="eta" name="checkbox" /></td>
                           <td><span id="bold">NEW SALE</span> - ETD</td>
                           <td>
                            <select class="when"  style="width: -webkit-fill-available;">
                            <option value="Select Preferred Date">Select Preferred Date</option>
                          </select>
                            </td>
                            <td>
                            <select class="where"  style="width: -webkit-fill-available;">
                            <option value="Select Preferred Source">Select Preferred Source</option>
                          </select>
                            </td>
                            <td class="EMAIL">  <select class="where"  style="width: -webkit-fill-available;">
                            <option value="Select Preferred Email">Select Preferred Email</option>
                          </select></td>
                        </tr>
                        <tr>
                        <td><input type="checkbox" id="etd" name="checkbox"/></td>
                        <td><span id="bold">NEW SALE</span> - ETA</td>
                           <td>
                            <select class="when"  style="width: -webkit-fill-available;">
                            <option value="Select Preferred Date">Select Preferred Date</option>
                          </select>
                            </td>
                            <td>
                            <select class="where"  style="width: -webkit-fill-available;">
                            <option value="Select Preferred Source">Select Preferred Source</option>
                          </select>
                            </td>
                            <td class="EMAIL">  <select class="where"  style="width: -webkit-fill-available;">
                            <option value="Select Preferred Email">Select Preferred Email</option>
                          </select></td>
                        </tr>
                        <tr>
                        <td><input type="checkbox" id="pay" name="checkbox"/></td>
                           <td><span id="bold">NEW SALE</span> - PAYMENT DUE DATE</td>
                           <td>
                            <select class="when"  style="width: -webkit-fill-available;">
                            <option value="Select Preferred Date">Select Preferred Date</option>
                          </select>
                            </td>
                            <td>
                            <select class="where"  style="width: -webkit-fill-available;">
                            <option value="Select Preferred Source">Select Preferred Source</option>
                          </select>
                            </td>
                            <td class="EMAIL">  <select class="where"  style="width: -webkit-fill-available;">
                            <option value="Select Preferred Email">Select Preferred Email</option>
                          </select></td>
                        </tr>
                        <tr>
                        <td><input type="checkbox" id="delivery" name="checkbox"/></td>
                           <td><span id="bold">OCEAN EXPORT TRACKING</span> - ETD</td>
                           <td>
                            <select class="when"  style="width: -webkit-fill-available;">
                           <option value="Select Preferred Date">Select Preferred Date</option>
                          </select>
                            </td>
                            <td>
                            <select class="where"  style="width: -webkit-fill-available;">
                            <option value="Select Preferred Source">Select Preferred Source</option>
                          </select>
                            </td>
                            <td class="EMAIL">  <select class="where"  style="width: -webkit-fill-available;">
                            <option value="Select Preferred Email">Select Preferred Email</option>
                          </select></td>
                        </tr>
                        <tr>
                        <td><input type="checkbox" id="delivery" name="checkbox"/></td>
                           <td><span id="bold">OCEAN EXPORT TRACKING</span> - ETA</td>
                           <td>
                            <select class="when"  style="width: -webkit-fill-available;">
                           <option value="Select Preferred Date">Select Preferred Date</option>
                          </select>
                            </td>
                            <td>
                            <select class="where"  style="width: -webkit-fill-available;">
                            <option value="Select Preferred Source">Select Preferred Source</option>
                          </select>
                            </td>
                            <td class="EMAIL">  <select class="where"  style="width: -webkit-fill-available;">
                            <option value="Select Preferred Email">Select Preferred Email</option>
                          </select></td>
                        </tr>
                        <tr>
                        <td><input type="checkbox" id="delivery" name="checkbox"/></td>
                           <td><span id="bold">TRUCKING</span> - CONTAINER PICKUP DATE</td>
                           <td>
                            <select class="when"  style="width: -webkit-fill-available;">
                           <option value="Select Preferred Date">Select Preferred Date</option>
                          </select>
                            </td>
                            <td>
                            <select class="where"  style="width: -webkit-fill-available;">
                            <option value="Select Preferred Source">Select Preferred Source</option>
                          </select>
                            </td>
                            <td class="EMAIL">  <select class="where"  style="width: -webkit-fill-available;">
                            <option value="Select Preferred Email">Select Preferred Email</option>
                          </select></td>
                        </tr>
                        <tr>
                        <td><input type="checkbox" id="delivery" name="checkbox"/></td>
                           <td><span id="bold">TRUCKING</span> - DELIVERY DATE</td>
                           <td>
                            <select class="when"  style="width: -webkit-fill-available;">
                           <option value="Select Preferred Date">Select Preferred Date</option>
                          </select>
                            </td>
                            <td>
                            <select class="where"  style="width: -webkit-fill-available;">
                            <option value="Select Preferred Source">Select Preferred Source</option>
                          </select>
                            </td>
                            <td class="EMAIL">  <select class="where"  style="width: -webkit-fill-available;">
                            <option value="Select Preferred Email">Select Preferred Email</option>
                          </select></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                <button type="button" class="btn btn-primary" style="background-color:#1c2350;">Save</button>
            </div>
        </div>
    </div>
</div>
<input type ="hidden" name="csrf_test_name" id="csrf_test_name" value="<?php echo $this->security->get_csrf_hash();?>">

<script>
    $(document).ready(function(){
        $('.EMAIL').hide();

    });
    $('.where').on("change", function() {
     $value=   $(this).closest('tr').find('.where').val();
       if($value=='EMAIL'){
      $(this).closest('tr').append('<tr class="hdn"><td> <select name="company" class="company form-control"><option value="Select Your Company">Select Your Company</option'+
        '<?php foreach ($admin_company as $key => $value){echo" <option value=$value[company_name]> $value[company_name] </option>";  } ?></select></td><td>&nbsp;</td><td><select name="mail" class="mail" style="display:none;"></select></td></tr>');
        }else{
            $(this).closest('tr').find('.hdn').hide();
        }   
});
$('.where').on("change", function() {
     $value=   $(this).closest('tr').find('.where').val();
      if($value=='SMS'){
            $(this).closest('tr').append("<input type='text' style='width:100%;' class='mobile' placeholder='Mobile Number'/>");
        }   else{
            $(this).closest('tr').find('.mobile').hide();
        }   
});
var csrfName = '<?php echo $this->security->get_csrf_token_name();?>';
var csrfHash = '<?php echo $this->security->get_csrf_hash();?>';
$(document).on('change', ".company", function(){
    var curEle = jQuery(this);
        var categorieID = curEle.val();
    var parentEle = curEle.closest('tr');
    var prodEle = parentEle.find('select[name^="mail"]');
   
    prodEle.empty();
    prodEle.show();
     var dataString = {
        dataString : $(this).closest('tr').find('.company').val()
    
   };
   dataString[csrfName] = csrfHash;
  
    $.ajax({
        type:"POST",
        dataType:"json",
        url:"<?php echo base_url(); ?>Cweb_setting/admin_user_mail_ids", 
        data: dataString,

        success:function (result) {
            console.log(result);
            prodEle.append('<option value=' + JSON.stringify(result[0]['email']) + '>'+ JSON.stringify(result[0]['email']) + '</option>');
        $.each(result, function (i, value) {
      

        prodEle.append('<option value=' + JSON.stringify(value['email_id']) + '>'+ JSON.stringify(value['email_id']) + '</option>');
            });

       }

    });
    event.preventDefault();
 });

$(document).ready(function(){
    $('.where').change();
})
    var selectValues = { "On Date": "On Date", "1 Day Before": "1 Day Before" , "3 Days Before": "3 Days Before", "1 Week Before": "1 Week Before"};
$.each(selectValues, function(key, value) {   
     $('.when')
         .append($("<option></option>")
                    .attr("value", value)
                    .text(value)); 
});
var selectValues = { "SMS": "SMS", "EMAIL": "EMAIL" , "STOCKEAI": "STOCKEAI", "CALENDER": "CALENDER"};
$.each(selectValues, function(key, value) {   
     $('.where')
         .append($("<option></option>")
                    .attr("value", value)
                    .text(value)); 
});
    function openModalBox(){
  var modal = $('.modal, #mask');
$('.open-modal').on('click', function() {
 modal.fadeIn(300);
});
//$('.close-modal, #mask').on('click', function() {
 //modal.fadeOut(800);
//});
}
openModalBox();
function toggle(source) {
  checkboxes = document.getElementsByName('checkbox');
  for(var i=0, n=checkboxes.length;i<n;i++) {
    checkboxes[i].checked = source.checked;
  }
}
    </script>
<div class="modal fade" id="expensemodel" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"  aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content" style="width: max-content;">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                </button>
                 <h4 class="modal-title" id="myModalLabel_exp">EXPENSE SETTING</h4>

            </div>
            <div class="modal-body">
                <table class="table table-bordered" >
                    <thead style="text-align:center;">
                        <tr>
                            <th><input type="checkbox"  onClick="toggle_exp(this)"/>&nbsp;SELECTALL </th>
                            <th>DATES</th>
                            <th>TIME</th>
                            <th>SOURCE</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                        <td> <input type="checkbox" id="exp_etd" name="checkbox_exp" /></td>
                           <td><span id="bold">NEW EXPENSE</span> - PAYMENT DUE DATE</td>
                           <td>
                            <select class="when_exp"  style="width: -webkit-fill-available;">
                            <option value="Select Preferred Date">Select Preferred Date</option>
                          </select>
                            </td>
                            <td>
                            <select class="where_exp"  style="width: -webkit-fill-available;">
                            <option value="Select Preferred Source">Select Preferred Source</option>
                          </select>
                            </td>
                            <td class="EMAIL_exp">  <select class="where_exp"  style="width: -webkit-fill-available;">
                            <option value="Select Preferred Email">Select Preferred Email</option>
                          </select></td>
                        </tr>
                        <tr>
                        <td><input type="checkbox" id="etd" name="checkbox_exp"/></td>
                           <td><span id="bold">PURCHASE ORDER</span> - EST.SHIPMENT DATE</td>
                           <td>
                            <select class="when_exp"  style="width: -webkit-fill-available;">
                            <option value="Select Preferred Date">Select Preferred Date</option>
                          </select>
                            </td>
                            <td>
                            <select class="where_exp"  style="width: -webkit-fill-available;">
                            <option value="Select Preferred Source">Select Preferred Source</option>
                          </select>
                            </td>
                            <td class="EMAIL_exp">  <select class="where_exp"  style="width: -webkit-fill-available;">
                            <option value="Select Preferred Email">Select Preferred Email</option>
                          </select></td>
                        </tr>
                        <tr>
                        <td><input type="checkbox" id="pay" name="checkbox_exp"/></td>
                           <td><span id="bold">OCEAN IMPORT TRACKING</span> - ETA</td>
                           <td>
                            <select class="when_exp"  style="width: -webkit-fill-available;">
                            <option value="Select Preferred Date">Select Preferred Date</option>
                          </select>
                            </td>
                            <td>
                            <select class="where_exp"  style="width: -webkit-fill-available;">
                            <option value="Select Preferred Source">Select Preferred Source</option>
                          </select>
                            </td>
                            <td class="EMAIL_exp">  <select class="where_exp"  style="width: -webkit-fill-available;">
                            <option value="Select Preferred Email">Select Preferred Email</option>
                          </select></td>
                        </tr>
                        <tr>
                        <td><input type="checkbox" id="delivery" name="checkbox_exp"/></td>
                        <td><span id="bold">OCEAN IMPORT TRACKING</span> - ETD</td>
                           <td>
                            <select class="when_exp"  style="width: -webkit-fill-available;">
                           <option value="Select Preferred Date">Select Preferred Date</option>
                          </select>
                            </td>
                            <td>
                            <select class="where_exp"  style="width: -webkit-fill-available;">
                            <option value="Select Preferred Source">Select Preferred Source</option>
                          </select>
                            </td>
                            <td class="EMAIL_exp">  <select class="where_exp"  style="width: -webkit-fill-available;">
                            <option value="Select Preferred Email">Select Preferred Email</option>
                          </select></td>
                        </tr>
                        <tr>
                        <td><input type="checkbox" id="delivery" name="checkbox_exp"/></td>
                        <td><span id="bold">TRUCKING</span> - CONTAINER/GOODS PICKUP DATE</td>
                           <td>
                            <select class="when_exp"  style="width: -webkit-fill-available;">
                           <option value="Select Preferred Date">Select Preferred Date</option>
                          </select>
                            </td>
                            <td>
                            <select class="where_exp"  style="width: -webkit-fill-available;">
                            <option value="Select Preferred Source">Select Preferred Source</option>
                          </select>
                            </td>
                            <td class="EMAIL_exp">  <select class="where_exp"  style="width: -webkit-fill-available;">
                            <option value="Select Preferred Email">Select Preferred Email</option>
                          </select></td>
                        </tr>
                        <tr>
                        <td><input type="checkbox" id="delivery" name="checkbox_exp"/></td>
                        <td><span id="bold">TRUCKING</span> - DELIVERY DATE</td>
                           <td>
                            <select class="when_exp"  style="width: -webkit-fill-available;">
                           <option value="Select Preferred Date">Select Preferred Date</option>
                          </select>
                            </td>
                            <td>
                            <select class="where_exp"  style="width: -webkit-fill-available;">
                            <option value="Select Preferred Source">Select Preferred Source</option>
                          </select>
                            </td>
                            <td class="EMAIL_exp">  <select class="where_exp"  style="width: -webkit-fill-available;">
                            <option value="Select Preferred Email">Select Preferred Email</option>
                          </select></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                <button type="button" class="btn btn-primary" style="background-color:#1c2350;">Save</button>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function(){
        $('.EMAIL_exp').hide();

    });
    $('.where_exp').on("change", function() {
     $value=   $(this).closest('tr').find('.where_exp').val();
       if($value=='EMAIL'){
      $(this).closest('tr').append('<tr class="hdn"><td> <select name="company1" class="company1 form-control"><option value="Select Your Company">Select Your Company</option'+
        '<?php foreach ($admin_company as $key => $value){echo" <option value=$value[company_name]> $value[company_name] </option>";  } ?></select></td><td>&nbsp;</td><td><select name="mail1" class="mail1" style="display:none;"></select></td></tr>');
        }else{
            $(this).closest('tr').find('.hdn').hide();
        }   
});
$('.where_exp').on("change", function() {
     $value=   $(this).closest('tr').find('.where_exp').val();
      if($value=='SMS'){
            $(this).closest('tr').append("<input type='text' style='width:100%;' class='mobile' placeholder='Mobile Number'/>");
        }   else{
            $(this).closest('tr').find('.mobile').hide();
        }   
});
var csrfName = '<?php echo $this->security->get_csrf_token_name();?>';
var csrfHash = '<?php echo $this->security->get_csrf_hash();?>';
$(document).on('change', ".company1", function(){
    var curEle = jQuery(this);
        var categorieID = curEle.val();
    var parentEle = curEle.closest('tr');
    var prodEle = parentEle.find('select[name^="mail1"]');
   
    prodEle.empty();
    prodEle.show();
     var dataString = {
        dataString : $(this).closest('tr').find('.company1').val()
    
   };
   dataString[csrfName] = csrfHash;
  
    $.ajax({
        type:"POST",
        dataType:"json",
        url:"<?php echo base_url(); ?>Cweb_setting/admin_user_mail_ids", 
        data: dataString,

        success:function (result) {
            console.log(result);
            prodEle.append('<option value=' + JSON.stringify(result[0]['email']) + '>'+ JSON.stringify(result[0]['email']) + '</option>');
        $.each(result, function (i, value) {
      

        prodEle.append('<option value=' + JSON.stringify(value['email_id']) + '>'+ JSON.stringify(value['email_id']) + '</option>');
            });

       }

    });
    event.preventDefault();
 });

$(document).ready(function(){
    $('.where_exp').change();
})
    var selectValues = { "On Date": "On Date", "1 Day Before": "1 Day Before" , "3 Days Before": "3 Days Before", "1 Week Before": "1 Week Before"};
$.each(selectValues, function(key, value) {   
     $('.when_exp')
         .append($("<option></option>")
                    .attr("value", value)
                    .text(value)); 
});
var selectValues = { "SMS": "SMS", "EMAIL": "EMAIL" , "STOCKEAI": "STOCKEAI", "CALENDER": "CALENDER"};
$.each(selectValues, function(key, value) {   
     $('.where_exp')
         .append($("<option></option>")
                    .attr("value", value)
                    .text(value)); 
});
  
function toggle_exp(source) {
  checkboxes = document.getElementsByName('checkbox_exp');
  for(var i=0, n=checkboxes.length;i<n;i++) {
    checkboxes[i].checked = source.checked;
  }
}
    </script>