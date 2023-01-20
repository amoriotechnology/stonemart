


<script src="<?php echo base_url() ?>assets/js/canvasjs.min.js" ></script>
<script src="<?php echo base_url() ?>assets/js/dashboard.js" ></script>
<link href="<?php echo base_url() ?>assets/css/xcharts.min.css" rel="stylesheet">
		<link href="<?php echo base_url() ?>assets/css/style.css" rel="stylesheet">
		<link href="<?php echo base_url() ?>assets/css/daterangepicker.css" rel="stylesheet">
		<link href="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/2.2.2/css/bootstrap.min.css" rel="stylesheet" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">
<link rel="stylesheet" href="<?php echo base_url() ?>my-assets/css/style.css">

<!-- Admin Home Start -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->

    <section class="content-header">
        <div class="header-icon">
            <i class="pe-7s-world"></i>

        </div>
        <div class="header-title">
            <h1><?php echo display('dashboard') ?></h1>
            <small><?php echo display('home') ?></small>
            <ol class="breadcrumb">
                <li><a href="#"><i class="pe-7s-home"></i> <?php echo display('home') ?></a></li>
                <li class="active"><?php echo display('dashboard') ?></li>
            </ol>
        </div>
    </section>
    <!-- Main content -->
    <section class="content">

        <!-- Alert Message -->

<style>

.box-para div {
   
    clear: none; 
}
.footer{
    float:top;
}
.cards {
   
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    grid-gap: 1.2rem;
    margin-top: 1rem;
    padding:10px;
    overflow: hidden;
    height: auto;
}

.card-single {
    display: flex;
    justify-content: space-between;
    background: rgba(237, 233, 232);
    backdrop-filter: blur(16px);
   padding:10px;
    border-radius: 30px;
    box-shadow: 0 0 20px rgba(0, 0, 0, .2);
    overflow: hidden;
    filter: brightness(120%);
    transition: all 400ms;
}
.cards .card-single {
    height: 150px;
}
.card-single:hover {
    transform: scale(1.04);
    border-radius: 25px;
}
a{
    text-decoration:none;
}
.card-single div:last-child span {
    font-size: 3rem;
    background: var(--pink);
    -webkit-text-fill-color: transparent;
    text-fill-color: transparent;
    -webkit-background-clip: text;
    background-clip: text;
}


.card-single div:first-child span {
    text-transform: uppercase;
    color: #fff;
}


.recent-grid {
    margin-top: 3.5rem;
    display: grid;
    grid-gap: 2rem;
    grid-template-columns: 65% auto;

}

.card {
    /* 	background:#fff; */
    background: rgba(0, 0, 0, .2);
    backdrop-filter: blur(16px);
    border-radius: 10px;
}
.text {
    color:white;
	position: absolute;
	bottom: 0px;
    text-align: center;
    width:100%;
    background: blue;
	border: solid 1px black;
}
#span{
    font-size: 30px;
    line-height: 50px;
  
    color: white;
    width: 50px;
    height: 50px;
    text-align: center;
    vertical-align: bottom;
}
    </style>
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
        <!-- First Counter -->
        <div class="row">

        <div class="cards">
<div style="<?php if($sale_setting=='disable'){ echo "display: none;"; }else{ echo "display: block;"; } ?>" >
                    <div class="card-single col">
                 
                    <div id="span" class="text-center">
                           
                            <span style="background-color: #18628f;padding:5px;border-radius:10px;"> <i class="fa fa-usd" style="font-size:30px;color: #fff;"></i></span>
                        </div>
                        <div>
                            <span> <h1><span class="count-number"><?php if($no_of_sale==''){echo 0;}else{echo html_escape($no_of_sale);} ?></span></h1>
                            <p><?php echo "Sales"?></p></span>

                        </div>
                        <div class="text" style="background-color: #18628f;">
		<a href="<?php echo base_url('Admin_dashboard/todays_sales_report') ?>">Total Sales</a>
	</div></div>
                    </div>
                    <div style="<?php if($expense_setting=='disable'){ echo "display: none;"; }else{ echo "display: block;"; } ?>" >
                    <div class="card-single col">
                    <div id="span" class="text-center">
                           
                            <span style="background-color: #9D467A;padding:5px;border-radius:10px;"> <i class="fa fa-money" style="font-size:30px;color: #fff;"></i></span>
                        </div>
                        <div>
                            <span> <h1><span class="count-number"><?php if($no_of_expense==''){echo 0;}else{echo html_escape($no_of_expense);}   ?></span></h1>
                            <p><?php echo "Expense"?></p></span>

                        </div>
                        <div class="text" style="background-color: #9D467A;">
		<a href="<?php echo base_url('Admin_dashboard/todays_purchase_report') ?>">Total Expense</a>
	</div>
                    </div>
                    </div>
                    <div style="<?php if($sale_invoice_setting=='disable'){ echo "display: none;"; }else{ echo "display: block;"; } ?>" >
                    <div class="card-single col">
                 
                    <div id="span" class="text-center">
                           
                            <span style="background-color: #489D86;padding:5px;border-radius:10px;"> <i class="fa fa-user" style="color: #fff;"></i></span>
                        </div>
                        <div>
                            <span> <h1><span class="count-number"><?php if($total_sales_invoice==''){echo 0;}else{echo $currency." ".html_escape($total_sales_invoice);} ?></span></h1>
                            <p><?php echo "Sales Invoice"?></p></span>

                        </div>
                        <div class="text" style="background-color: #489D86;">
		<a href="<?php echo base_url('Cinvoice/manage_invoice') ?>">Total Sales Invoice</a>
	</div></div>
                    </div>
                    <div style="<?php if($expense_invoice_setting=='disable'){ echo "display: none;"; }else{ echo "display: block;"; } ?>" >
                    <div class="card-single col">
                 
                    <div id="span" class="text-center">
                           
                            <span style="background-color: #B68448;padding:5px;border-radius:10px;"> <i class="fa fa-file-text-o" style="color: #fff;"></i></span>
                        </div>
                        <div>
                            <span> <h1><span class="count-number"><?php if($overall_purchase_amt==''){echo 0;}else{echo $currency." ".html_escape($overall_purchase_amt);} ?></span></h1>
                            <p><?php echo "Expense Invoice"?></p></span>

                        </div>
                        <div class="text" style="background-color: #B68448;">
		<a href="<?php echo base_url('Cpurchase/manage_purchase') ?>">Total Expense Invoice</a>
	</div></div>
                    </div>
                </div>
    </div>
      
    <div class="row">

        <div class="cards">

                    <div style="<?php if($product_sold=='disable'){ echo "display: none;"; }else{ echo "display: block;"; } ?>" >
                    <div class="card-single col">
                 
                    <div id="span" class="text-center">
                            
                            <span style="background-color: #9B59B6 ;padding:5px;border-radius:10px;"> <i class="fa fa-product-hunt" style="color: #fff;"></i></span>
                        </div>
                        <div>
                            <span> <h1><span class="count-number"><?php if($total_sales_product==''){echo 0;}else{echo html_escape($total_sales_product);} ?></span></h1>
                            <p><?php echo "Products Sold"?></p></span>

                        </div>
                        <div class="text" style="background-color: #9B59B6 ;">
		<a href="<?php echo base_url('Cproduct/manage_product') ?>">Total Products Sold</a>
	</div></div>
                    </div>
                    <div style="<?php if($product_purchased=='disable'){ echo "display: none;"; }else{ echo "display: block;"; } ?>" >
                 <div class="card-single col">
                 
                    <div id="span" class="text-center">
                          
                            <span style="background-color: #76448A;padding:5px;border-radius:10px;"> <i class="fa fa-shopping-basket" style="color: #fff;"></i></span>
                        </div>
                        <div>
                            <span> <h1><span class="count-number"><?php if($total_expense_product==''){echo 0;}else{echo html_escape($total_expense_product);} ?></span></h1>
                            <p><?php echo "Products Purchased"?></p></span>

                        </div>
                        <div class="text" style="background-color: #76448A;">
                    <a href="<?php echo base_url('Cproduct/manage_product') ?>">Total Products Purchased</a>
	</div></div>
                    </div>
                    <div style="<?php if($vendor=='disable'){ echo "display: none;"; }else{ echo "display: block;"; } ?>" >
                    <div class="card-single col">
                 
                 <div id="span" class="text-center">
                       
                         <span style="background-color:  #7645768A;padding:6px;border-radius:10px;"> <i class="fa fa-users" style="color: #fff;"></i></span>
                         <!-- <div id="span" class="text-center">
                            
                            <span style="background-color: #9B59B6 ;padding:5px;border-radius:10px;"> <i class="fa fa-product-hunt" style="color: #fff;"></i></span> -->
                     </div>
                     <div>
                  
                         <span> <h1><span class="count-number"><?php if($servic_p_amount==''){echo 0;}else{ print_r($servic_p_amount); } ?></span></h1>
                         <p>
                            <?php
            //    .'('. print_r($servic_p_amount).')';  ?>
                    <?php 
                    // print_r(count(array_filter($service_provider_list[0]['supplier_name'])));
                     $count=1;
                         foreach ($service_provider_list as $single) {
                          //  echo $single['supplier_name']; 
                          //  echo "<br/>";
                            $count++;
                         }
                         echo 'Vendors('.count($service_provider_list).')';
                       //
                       //  echo $count;
                         ?>
                
                </p></span>

                     </div>
                     <div class="text" style="background-color: #7645768A;">
     <a href="<?php echo base_url('Csupplier/supplier_ledger_report') ?>">Total Vendors</a>
 </div></div>
                 </div>
                  
                    


                </div>
    </div>



    <?php if ($this->session->userdata('user_type') == '1') { ?>
            <div class="row">

<div class="col-sm-12">
                        
         

       
<div class="col-sm-6" style="<?php if($best_sales_product=='disable'){ echo "display: none;"; }else{ echo "display: block;"; } ?>">

               

                         <br/>  <br/>  <br/>
<?php echo form_open_multipart('Admin_dashboard/index',array('class' => 'form-vertical', 'id' => 'insert_sale','name' => 'insert_sale'))?>
<div id="placeholder" style="width:700px;">
<form class="form-horizontal">
			  <fieldset>
		        <div class="input-prepend">
                <input  style="width5"class="daterangepicker-field" name="daterangepicker-field" autocomplete="off" id="daterangepicker-field" value="<?php echo $searchdate;?>"></input>
                  <select id="type" name="type" class="select">  
        <option>Sale</option>  
        <option>Expense</option>  
        
  </select>  
                 </div>
               
			  </fieldset>
			</form>
			
			
				<figure id="chart" name="chart"></figure>
                </div>


<?php echo form_close();?>

</div>
<?php
if(isset($_POST['btnSearch'])){
    $s = $_REQUEST["daterangepicker-field"];
  
}
$prev_month = date('Y-m-d', strtotime('first day of january this year'));
$current=date('Y-m-d');
$dat2= $prev_month."to". $current;

$searchdate =(!empty($s)?$s:$dat2);
    $dat = str_replace(' ', '', $searchdate);
    $split=explode("to",$dat);
?>
       
<div class="col-sm-6" style="<?php if($yearly_reportsetting=='disable'){ echo "display: none;"; }else{ echo "display: block;"; } ?>">

               

                         <br/>  <br/>  <br/>
<?php echo form_open_multipart('Admin_dashboard/index',array('class' => 'form-vertical', 'id' => 'insert_sale','name' => 'insert_sale'))?>
<div class="form-group" style="background-color:white;">
                    <?php echo form_open_multipart('Admin_dashboard/index',array('class' => 'form-vertical', 'id' => 'insert_sale','name' => 'insert_sale'))?>

<div style="padding-right:30px;">
<br/>
<input class="daterangepicker-field" name="daterangepicker-field" autocomplete="off" id="daterangepicker-field" value="<?php echo $searchdate;?>"></input>


&nbsp;&nbsp; <input type="submit" name="btnSearch" id="submit1" />

</div>
<?php echo form_close();?>


<div id="chartContainer" name="chartContainer"  class="piechartcontainer"></div>


</div>
</div>


</div>
<?php  } ?>

<div class="row"  style="<?php if($todays_overviewsetting=='disable'){ echo "display: none;"; }else{ echo "display: block;"; } ?>">
                <div class="col-sm-6">
                <div class="panel panel-bd lobidisable" style="height:300px;">
                <div class="panel-heading">
                    <div class="panel-title">
                        <h4><?php echo display('todays_overview') ?></h4>
                    </div>
                </div>
                <div class="panel-body">
                    <div class="message_inner">
                        <div class="message_widgets">

                            <table class="table table-bordered table-striped table-hover">
                                <tr>
                                    <th><?php echo display('todays_report') ?></th>
                                    <th><?php echo display('money') ?></th>
                                </tr>
                                <tr>
                                    <th><?php echo display('total_sales') ?></th>
                                    <td><?php echo html_escape((($position == 0) ? "$currency $sales_amount" : "$sales_amount $currency")) ?></td>
                                </tr>
                                <tr>
                                    <th><?php echo display('total_purchase') ?></th>
                                    <td><?php echo html_escape((($position == 0) ? "$currency $todays_total_purchase" : "$todays_total_purchase $currency")) ?></td>
                                </tr>

                            </table>

                            <table class="table table-bordered table-striped table-hover">
                                <tr>
                                    <th><?php echo display('last_sales') ?></th>
                                    <th><?php echo display('money') ?></th>
                                </tr>
                                <?php
                                if ($todays_sale_product) {
                                    ?>
                                    {todays_sale_product}
                                    <tr>
                                        <th>{product_name}</th>
                                        <td><?php echo (($position == 0) ? "$currency {price}" : "{price} $currency") ?></td>
                                    </tr>
                                    {/todays_sale_product}
                                <?php } ?>
                            </table>

                        </div>
                    </div>
                </div>
            </div>
			



                        
                        </div>
                                </div>
                                <div class="row">
                <!-- Total Report -->
                
                   <!-- This today transaction progress -->
                <div class="col-sm-12 col-md-12" style="<?php if($todays_sales_reportsetting=='disable'){ echo "display: none;"; }else{ echo "display: block;"; } ?>">
                    <div class="panel panel-bd">
                        <div class="panel-heading">
                            <div class="panel-title">
                                <h4 class="charttitle"> <?php echo display('todays_sales_report') ?></h4>
                            </div>
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive todayssaletitle">
                            <?php 
                           
                            if( $todays_sales_report_detail)
                                     {  ?>
                                <table class="table table-bordered table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th><?php echo display('sl') ?></th>
                                            <th><?php echo display('customer_name') ?></th>
                                            <th><?php echo display('invoice_no') ?></th>
                                            <th><?php echo display('total_amount') ?></th>
                                            <th><?php echo display('paid_ammount') ?></th>
                                        </tr>
                                    </thead>
                                    <?php  } ?>
                                    <tbody>
                                        <?php
                                       
                                         $ttl_amount = $ttl_paid = $ttl_due = $ttl_discout = $ttl_receipt = 0;
                                        $todays = date('Y-m-d');
                                        if( $todays_sales_report_detail)
                                     {
                                            $sl = 0;
                     foreach ($todays_sales_report_detail as $single) {
                   

                                                $sl++;
                                                ?>
                                                <tr>
                                                    <td><?php echo $sl; ?></td>
                                                    <td>
                                                        <a href="<?php echo base_url(); ?>Ccustomer/customer_ledger_report">
                                                            <?php echo html_escape($single['customer_name']); ?>
                                                        </a>
                                                    </td>
                                                    <td>
                                                        <a href="<?php echo base_url() . 'Cinvoice/invoice_inserted_data/'; ?><?php echo html_escape($single->invoice_id); ?>">
                                                            <?php echo html_escape($single['invoice']); ?>
                                                        </a>
                                                    </td>
                                                    <td class="text-right">
                                                        <?php
                                                        $ttl_amount += $single['total_amount']; 
                                                        echo html_escape(number_format($single['total_amount'], '2','.',',')); 
                                                        ?>
                                                    </td>
                                                    <td class="text-right">
                                                        <?php
                                                        $ttl_paid += $single['paid_amount'];
                                                        echo html_escape(number_format($single['paid_amount'], '2', '.', ',')); ?>
                                                    </td>
                                                   
                                                   
                                                   
                                                   
                                                  
                                                </tr>
                                                <?php
                                            }
                                        } else {
                                            ?>
                                            <tr>
                                                <th class="text-center" colspan="5"><?php echo display('not_found'); ?></th>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                  
                                  <?php  
                                   if(is_array($todays_sales_report_detail) && count($todays_sales_report_detail)>0)
                                     {  ?>
                                    <tfoot>
                                        
                                        <tr>
                                            <td colspan="3" align="right">&nbsp;<b><?php echo display('total') ?>:</b></td>
                                            <td class="text-right">
                                                <?php
                                                $ttl_amount_float = html_escape(number_format($ttl_amount, '2', '.',','));
                                                echo (($position == 0) ? "$currency $ttl_amount_float" : "$ttl_amount_float $currency"); ?>
                                            </td>
                                            <td class="text-right">
                                                <?php
                                                $ttl_paid_float = html_escape(number_format($ttl_paid, '2', '.',','));
                                                echo (($position == 0) ? "$currency $ttl_paid_float" : "$ttl_paid_float $currency"); ?>
                                            </td>
                                           <?php  } ?>
                                          
                                           
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                            
                        </div>

                        
                    </div>
                
                </div>
                
      
               
             
            </div>
   
  <input type="hidden" id="currency" value="<?php echo  html_escape($currency)?>" name="">
  <input type="hidden" id="totalsalep" value="<?php echo html_escape($this->Reports->total_sales_amount($split[0],$split[1]))?>" name="">
   <input type="hidden" id="totalplurchasep" value="<?php
     echo html_escape($this->Reports->total_purchase_amount($split[0],$split[1]))?>" name="">
      <input type="hidden" id="totalexpensep" value="<?php
     echo html_escape($this->Reports->total_expense_amount($split[0],$split[1]))?>" name="">
     <input type="hidden" id="totalemployeesalaryp" value="<?php
     echo html_escape($this->Reports->total_employee_salary($split[0],$split[1]))?>" name="">

      <input type="hidden" id="totalservicep" value="<?php
     echo html_escape($this->Reports->total_service_amount($split[0],$split[1]))?>" name="">





      <input type="hidden" id="month" value="<?php echo html_escape($month);?>" name="">
      <input type="hidden" id="tlvmonthsale" value="<?php echo html_escape($tlvmonthsale);?>" name="">
      <input type="hidden" id="tlvmonthpurchase" value="<?php echo html_escape($tlvmonthpurchase);?>" name=""> 
      <input type="hidden" id="salspurhcaselabel"  value="<?php echo display("sales_and_purchase_report_summary");?>- <?php echo  date("Y")?>" name="">     


<input type="hidden" id="bestsalelabel" value='<?php echo html_escape($chart_label);?>' name=""> 
<input type="hidden" id="bestsaledata" value='<?php echo html_escape($chart_data);?>' name=""> 


    
          


<!--<input type="hidden" value='<?php// @$seperatedData = explode(',', $chart_data); echo html_escape(($seperatedData[0] + 10));?>' name="" id="bestsalemax">  -->   
    </section> <!-- /.content -->
</div> <!-- /.content-wrapper -->
<!-- Admin Home end -->



<!-- ChartJs JavaScript -->

<!-- partial -->
  <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.6/moment.js'></script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/knockout/3.4.0/knockout-debug.js'></script>

<script  src="<?php echo base_url() ?>my-assets/js/script.js"></script>
<script>

//create data object here so we can dynamically set new csrfName/Hash
$('#submit1').on('click', function (e) {
        
        var date=$('#daterangepicker-field').val();
        sessionStorage.setItem("daterange", date);
   
  });
$(function() { 
 //   sessionStorage.clear();
 var today = new Date();
var dd = String(today.getDate()).padStart(2, '0');
var mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
var yyyy = today.getFullYear();
today = yyyy + '-' + mm + '-' + dd;
var firstdate = new Date().getFullYear()+'-01-01';

var retrieve =sessionStorage.getItem("daterange");
if(retrieve==null){
    $('#daterangepicker-field').val(firstdate+" to "+today);
}else{
$('#daterangepicker-field').val(retrieve);
}

});



</script>
<!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>-->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>


<!-- xcharts includes -->
<script src="//cdnjs.cloudflare.com/ajax/libs/d3/2.10.0/d3.v2.js"></script>
<script src="<?php echo base_url() ?>assets/js/xcharts.min.js"></script>

<!-- The daterange picker bootstrap plugin -->
<script src="<?php echo base_url() ?>assets/js/sugar.min.js"></script>
<script src="<?php echo base_url() ?>assets/js/daterangepicker.js"></script>

<!-- Our main script file -->
<script src="<?php echo base_url() ?>assets/js/script.js"></script>

<!-- BSA AdPacks code. Please ignore and remove.-->


<script>
    
$(function() {

// Set the default dates
var startDate	= Date.create().addDays(-6),	// 7 days ago
    endDate		= Date.create(); 				// today

var range = $('#range');

// Show the dates in the range input
range.val(startDate.format('{MM}/{dd}/{yyyy}') + ' - ' + endDate.format('{MM}/{dd}/{yyyy}'));

// Load chart
ajaxLoadChart(startDate,endDate);

range.daterangepicker({
    
    startDate: startDate,
    endDate: endDate,
    
    ranges: {
        'Today': ['today', 'today'],
        'Yesterday': ['yesterday', 'yesterday'],
        'Last 7 Days': [Date.create().addDays(-6), 'today'],
        'Last 30 Days': [Date.create().addDays(-29), 'today']
    }
},function(start, end){
    
    ajaxLoadChart(start, end);
    
});

// The tooltip shown over the chart
var tt = $('<div class="ex-tooltip">').appendTo('body'),
    topOffset = -32;

var data = {
    "xScale" : "time",
    "yScale" : "linear",
    "main" : [{
        className : ".stats",
        "data" : []
    }]
};

var opts = {
    paddingLeft : 50,
    paddingTop : 20,
    paddingRight : 10,
    axisPaddingLeft : 25,
    tickHintX: 9, // How many ticks to show horizontally

    dataFormatX : function(x) {
        
        // This turns converts the timestamps coming from
        // ajax.php into a proper JavaScript Date object
        
        return Date.create(x);
    },

    tickFormatX : function(x) {
        
        // Provide formatting for the x-axis tick labels.
        // This uses sugar's format method of the date object. 

        return x.format('{MM}/{dd}');
    },
    
    "mouseover": function (d, i) {
        var pos = $(this).offset();
        
        tt.text(d.x.format('{Month} {ord}') + ': ' + d.y).css({
            
            top: topOffset + pos.top,
            left: pos.left
            
        }).show();
    },
    
    "mouseout": function (x) {
        tt.hide();
    }
};

// Create a new xChart instance, passing the type
// of chart a data set and the options object

var chart = new xChart('line-dotted', data, '#chart' , opts);

// Function for loading data via AJAX and showing it on the chart
function ajaxLoadChart(startDate,endDate) {

    // If no data is passed (the chart was cleared)
    
    if(!startDate || !endDate){
        chart.setData({
            "xScale" : "time",
            "yScale" : "linear",
            "main" : [{
                className : ".stats",
                data : []
            }]
        });
        
        return;
    }

    // Otherwise, issue an AJAX request

    $.getJSON('<?php echo base_url() ?>Admin_dashboard/chart', {
        
        start:	startDate.format('{yyyy}-{MM}-{dd}'),
        end:	endDate.format('{yyyy}-{MM}-{dd}')
        
    }, function(data) {
        
        var set = [];
        $.each(data, function() {
            set.push({
                x : this.label,
                y : parseInt(this.value, 10)
            });
        });
        
        chart.setData({
            "xScale" : "time",
            "yScale" : "linear",
            "main" : [{
                className : ".stats",
                data : set
            }]
        });

    });
}
});

 

    </script>