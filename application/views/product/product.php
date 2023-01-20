<link rel="stylesheet" type="text/css" href="<?php echo base_url()?>my-assets/css/css.css" />
<div class="content-wrapper">
    <section class="content-header">
        <div class="header-icon">
            <i class="pe-7s-note2"></i>
        </div>
        <div class="header-title">
            <h1><?php echo display('manage_product') ?></h1>
            <small><?php echo display('manage_your_product') ?></small>
            <ol class="breadcrumb">
                <li><a href="#"><i class="pe-7s-home"></i> <?php echo display('home') ?>55</a></li>
                <li><a href="#"><?php echo display('product') ?></a></li>
                <li class="active"><?php echo display('manage_product') ?></li>
            </ol>
        </div>
    </section>

    <section class="content">

        <!-- Alert Message -->
        <?php
        error_reporting(1);
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

        <div class="row">
            <div class="col-sm-12">
              
         <?php if($this->permission1->method('create_product','create')->access()){ ?>
                    <a href="<?php echo base_url('Cproduct') ?>" class="btn btn-info m-b-5 m-r-2"><i class="ti-plus"> </i> <?php echo display('add_product') ?> </a>
<?php }?>
<?php if($this->permission1->method('add_product_csv','create')->access()){ ?>
                    <a href="<?php echo base_url('Cproduct/add_product_csv') ?>" class="btn btn-primary m-b-5 m-r-2"><i class="ti-plus"> </i>  <?php echo display('add_product_csv') ?> </a>
                    <?php }?>

                <?php if($this->permission1->method('manage_category','create')->access() || $this->permission1->method('manage_category','read')->access()|| $this->permission1->method('manage_category','update')->access()|| $this->permission1->method('manage_category','delete')->access()){ ?>
                    <a href="<?php echo base_url('Ccategory') ?>" class="btn btn-primary m-b-5 m-r-2"><i class="ti-plus"> </i>Add/Edit Category </a>
                    <?php }?>


                     <?php if($this->permission1->method('manage_unit','create')->access() || $this->permission1->method('manage_unit','read')->access() || $this->permission1->method('manage_unit','delete')->access() || $this->permission1->method('manage_unit','update')->access()){ ?>
                    <a href="<?php echo base_url('Cunit'); ?>" class="btn btn-primary m-b-5 m-r-2"><i class="ti-plus"> </i>Add/Edit Unit </a>
                    <?php }?>


            </div>
        </div>




        <!-- Manage Product report -->
        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-bd lobidrag">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <h4><?php echo display('manage_product') ?></h4>


                        </div>
                    </div>
                    
                    <table class="table table-striped table-bordered">
                        <tr>
                            <th>Sno</th>
                            <th>Product Name</th>
                            <th>Inventry</th>
                            <th>Supplier name</th>
                            <th>Product Model</th>
                            <th>Supplier price</th>
                             <th>Price</th>
                         
                          
                        </tr>
                        <?php 
                        $i=1;
                        foreach($products as $product)
                            { ?>
                        <tr>
                            <td><?php echo $i; ?></td>
                            <td><a href="<?php echo base_url().'Cproduct/'; ?>product_view/<?php echo $product['id']; ?>"><?php echo $product['product_name']; ?></a></td>
                            <td>
                                <div class="row" style="border: 1px solid #d3d3d366;
    margin: -1px;"><div class="col-sm-6">In Stock</div><div class="col-sm-6"><?php echo $product['p_quantity']; ?></div></div>
                                <div class="row" style="border: 1px solid #d3d3d366;
    margin: -1px;"><div class="col-sm-6">Avaliablity</div><div class="col-sm-6"><?php  if($product['product_id']==$sale_count[$i]['product_id']){ $avail=$product['p_quantity']-$sale_count[$i]['value'];
     }
    if($product['product_id']==$expense_count[$i]['product_id']){ 
     
        $avail=$avail+$expense_count[$i]['value']; 
        }

if(isset($avail))
{
    echo $avail;
}

     ?></div></div>
                            </td>
                            <td><?php echo $product['supplier_name']; ?></td>
                           
                            <td><?php echo $product['product_model']; ?></td>
                            <td><?php echo $product['supplier_price']; ?></td>
                            <td><?php echo $product['price']; ?></td>
                            
                           
                        </tr>
                    <?php $i++; } ?>
                    </table>
                </div>
                <input type="hidden" id="total_product" value="<?php echo $total_product;?>" name="">

                 <input type="hidden" id="category_id" value="<?php echo $category_id;?>" name="">
            </div>
        </div>
    </section>
</div>
<!-- <link rel="stylesheet" type="text/css" href="//code.jquery.com/ui/1.9.2/themes/base/jquery-ui.css">



<script type="text/javascript">
$(function() {
 
  $('table th').resizable({
    handles: 'e',
    stop: function(e, ui) {
      $(this).width(ui.size.width);
    }
  });

});

</script> -->