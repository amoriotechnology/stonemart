<style>
.img-flag{
  max-height: 11px;
}
</style>
<!-- Edit supplier page start -->

<div class="content-wrapper">

    <section class="content-header">

        <div class="header-icon">

            <i class="pe-7s-note2"></i>

        </div>

        <div class="header-title">

            <h1><?php echo display('supplier_edit') ?></h1>

            <small><?php echo display('supplier_edit') ?></small>

            <ol class="breadcrumb">

                <li><a href="#"><i class="pe-7s-home"></i> <?php echo display('home') ?></a></li>

                <li><a href="#"><?php echo display('supplier') ?></a></li>

                <li class="active"><?php echo display('supplier_edit') ?></li>

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



        <!-- New supplier -->

        <div class="row">

            <div class="col-sm-12">

                <div class="panel panel-bd lobidrag">

                    <div class="panel-heading">

                        <div class="panel-title">

                            <h4><?php echo display('supplier_edit') ?> </h4>

                        </div>

                    </div>

                   <?php echo form_open_multipart('Csupplier/supplier_update',array( 'id' => 'supplier_update'))?>

                    <div class="panel-body">

                        <div class="col-sm-6">

                    	<div class="form-group row">

                            <label for="supplier_name" class="col-sm-4 col-form-label"><?php echo display('supplier_name') ?> <i class="text-danger">*</i></label>

                            <div class="col-sm-8">

                                <input class="form-control" name ="supplier_name" id="supplier_name" type="text" value="{supplier_name}" placeholder="<?php echo display('supplier_name') ?>"  required="" tabindex="1">

                                <input type="hidden" name="oldname" value="{supplier_name}">

                            </div>

                        </div>



                       	<div class="form-group row">

                            <label for="mobile" class="col-sm-4 col-form-label"><?php echo display('supplier_mobile') ?> <i class="text-danger">*</i></label>

                            <div class="col-sm-8">

                                <input class="form-control" name="mobile" id="mobile" type="number" placeholder="<?php echo display('supplier_mobile') ?>" value="{mobile}" required="" min="0" tabindex="2">

                            </div>

                        </div>



                         <div class="form-group row">

                            <label for="phone" class="col-sm-4 col-form-label"><?php echo display('phone') ?> <i class="text-danger"></i></label>

                            <div class="col-sm-8">

                                <input class="form-control" name="phone" id="phone" type="number" placeholder="<?php echo display('phone') ?>" value="{phone}"  tabindex="2">

                            </div>

                        </div>

                         <div class="form-group row">

                            <label for="email" class="col-sm-4 col-form-label"><?php echo display('email') ?> <i class="text-danger"></i></label>

                            <div class="col-sm-8">

                                <input class="form-control" name="email" id="email" type="email" placeholder="<?php echo display('email') ?>"  value="{emailnumber}"  tabindex="2">

                            </div>

                        </div>

                         <div class="form-group row">

                            <label for="emailaddress" class="col-sm-4 col-form-label"><?php echo display('email').' '.display('address'); ?> <i class="text-danger"></i></label>

                            <div class="col-sm-8">

                                <input class="form-control" name="emailaddress" id="emailaddress" type="text" placeholder="<?php echo display('email').' '.display('address') ?>" value="{email_address}"  >

                            </div>

                        </div>



                          <div class="form-group row">

                            <label for="contact" class="col-sm-4 col-form-label"><?php echo display('contact'); ?> <i class="text-danger"></i></label>

                            <div class="col-sm-8">

                                <input class="form-control" name="contact" id="contact" type="text" placeholder="<?php echo display('contact') ?>" value="{contact}" >

                            </div>

                        </div>



                        <div class="form-group row">

                            <label for="fax" class="col-sm-4 col-form-label"><?php echo display('fax'); ?> <i class="text-danger"></i></label>

                            <div class="col-sm-8">

                                <input class="form-control" name="fax" id="fax" type="text" placeholder="<?php echo display('fax') ?>" value="{fax}" >

                            </div>

                        </div>

                        <div class="form-group row">

                            <label for="city" class="col-sm-4 col-form-label"><?php echo display('city'); ?> <i class="text-danger"></i></label>

                            <div class="col-sm-8">

                                <input class="form-control" name="city" id="city" type="text" placeholder="<?php echo display('city') ?>" value="{city}" >

                            </div>

                        </div>


                    <div class="form-group-row">
                        <label for="" class="col-sm-4 col-form-label">Service Provider</label>
                            <div class="col-sm-8">
                               <select class="form-control" name="service_provider">
                                <option value="1" <?php if($service_provider == '1') { ?> selected="selected"<?php } ?>>Yes</option>
                                <option value="0" <?php if($service_provider == '0') { ?> selected="selected"<?php } ?>>No</option>
                               </select>
                            </div>
                    </div>

                    </div>

                    <div class="col-sm-6">

                         <div class="form-group row">

                            <label for="state" class="col-sm-4 col-form-label"><?php echo display('state'); ?> <i class="text-danger"></i></label>

                            <div class="col-sm-8">

                                <input class="form-control" name="state" id="state" type="text" placeholder="<?php echo display('state') ?>" value="{state}" >

                            </div>

                        </div>

                      

                         

                         <div class="form-group row">

                            <label for="zip" class="col-sm-4 col-form-label"><?php echo display('zip'); ?> <i class="text-danger"></i></label>

                            <div class="col-sm-8">

                                <input class="form-control" name="zip" id="zip" type="text" placeholder="<?php echo display('zip') ?>"  value="{zip}">

                            </div>

                        </div>

                         <div class="form-group row">

                            <label for="country" class="col-sm-4 col-form-label"><?php echo display('country') ?> <i class="text-danger"></i></label>

                            <div class="col-sm-8">

                                <input class="form-control" name="country" id="country" type="text" placeholder="<?php echo display('country') ?>" value="{country}" >

                            </div>

                        </div>

   

                        <div class="form-group row">

                            <label for="address " class="col-sm-4 col-form-label"><?php echo display('supplier_address') ?></label>

                            <div class="col-sm-8">

                                <textarea class="form-control" name="address" id="address " rows="3" placeholder="<?php echo display('supplier_address') ?>" tabindex="3">{address}</textarea>

                            </div>

                        </div>



                         <div class="form-group row">

                            <label for="address2 " class="col-sm-4 col-form-label"><?php echo display('address') ?>2</label>

                            <div class="col-sm-8">

                                <textarea class="form-control" name="address2" id="address2" rows="2" placeholder="<?php echo display('supplier_address') ?>2" tabindex="3">{address2}</textarea>

                            </div>

                        </div>



                        <div class="form-group row">

                            <label for="details" class="col-sm-4 col-form-label"><?php echo display('supplier_details') ?></label>

                            <div class="col-sm-8">

                                <textarea class="form-control" name="details" id="details" rows="3" placeholder="<?php echo display('supplier_details') ?>" tabindex="4">{details}</textarea>

                            </div>

                        </div>

                        <input type="hidden" name="supplier_id" value="{supplier_id}" />

                        <div class="form-group row">
                            <label for="previous_balance" class="col-sm-4 col-form-label"><?php echo "Preferred Currency" ?></label>
                            <div class="col-sm-8">
                            <select name="currency_type" class="currency" id="currency1" style="width: 100%;"></select>
                              <input type="hidden" name="" id="num" >
                            <div class="right_box" style="display:none;">
                              <select name="currency_type" class="currency" id="currency2" style="width: 95%;"></select>
                              <input type="hidden" name="" id="ans" disabled>
                            </div>
                          <small id="errorMSG" style="display:none;"></small>

                          <br><br>
                            </div>
                            <div id="pageLoader">
                            </div> 
                        </div>

                    </div>



                        <div class="form-group row">

                            <label for="example-text-input" class="col-sm-4 col-form-label"></label>

                            <div class="col-sm-6">

                               <input type="submit" id="add-supplier" class="btn btn-success btn-large" name="add-supplier" value="<?php echo display('save_changes') ?>" tabindex="5" />

                            </div>

                        </div>

                    </div>

                    <?php echo form_close()?>

                </div>

            </div>

        </div>

    </section>

</div>

<!-- Edit supplier page end -->

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" type="text/javascript"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js" type="text/javascript"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css">
   
<!-- Add new customer end -->
 <!-- script for currency selector -->
<script>
   
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
      templateResult: formatFlags,
      templateSelection: formatCountry,
      maximumInputLength: 3
    });
    info.innerHTML = "Result: "+data.result+"<br>Provider: "+data.provider+"<br>Documentation: "+data.documentation+"<br>Terms of use: "+data.terms_of_use+"<br>Time Last Update UTC: "+data.time_last_update_utc;
    $('#pageLoader').fadeOut();
  }).catch(function(error) {
    err.innerHTML = "Error: " + error;
    $('#pageLoader').fadeOut();
  });


  $('.currency').on('select2:select', function (e) {
    let currency1 = select[0].value;
    let currency2 = select[1].value;
    let num1 = num.value;
    convert(currency1, currency2, num1)
  });
}, false);

function display(data){
  const entries = Object.entries(data);
  for (var i = 0; i < entries.length; i++){
    select[0].innerHTML += `<option value="${entries[i][0]}">${entries[i][0]}</option>`;
    select[1].innerHTML += `<option value="${entries[i][0]}">${entries[i][0]}</option>`;
  }
  if ($('#currency2').find("option[value='CLP']").length) {
    $('#currency2').val('CLP').trigger('change');
    $('#num').val(1);
    let currency1 = select[0].value;
    let currency2 = select[1].value;
    let num1 = num.value;
    convert(currency1, currency2, num1)
  }
}
function formatFlags (country) {
  if (!country.id) {
    return country.text;
  }
  var $countryFlag = $('<span><img src="' + baseFlagsUrl + '/' + country.element.value.toLowerCase() + '.png" class="img-flag" /> ' + country.text + '</span>');
  return $countryFlag;
}
function formatCountry (country) {
  if (!country.id) {
    return country.text;
  }
  var $countryFlag = $('<span><img class="img-flag"/> <span></span></span>');
  $countryFlag.find("span").text(country.text);
  $countryFlag.find("img").attr("src", baseFlagsUrl + "/" + country.element.value.toLowerCase() + ".png");
  return $countryFlag;
}

function convert(currency1, currency2, value){
  fetch(`${currencyApiUrl}/${currency1}`)
    .then((val) => val.json())
    .then((val) => {
    console.log('Converting ' +currency1 + ' to '+currency2);
    var res  = val.rates[currency2] * value 
    ans.value = res.toFixed(2);
    err.innerHTML = "";
  }).catch(function(error) {
    err.innerHTML = "Error: " + error;
  });
}
    </script>







