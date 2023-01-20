<!-- Add User start -->
<div class="content-wrapper">
    <section class="content-header">
        <div class="header-icon">
            <i class="pe-7s-note2"></i>
        </div>
        <div class="header-title">
            <h1>Add Admin User</h1>
            <small>Add New Admin User</small>
            <ol class="breadcrumb">
                <li><a href="index.html"><i class="pe-7s-home"></i> <?php echo display('home') ?></a></li>
                <li><a href="#"><?php echo display('web_settings') ?></a></li>
                <li class="active">Add Admin</li>
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

        <div class="row">
          


        <div class='row'> 
                    
        </div>
        <!-- New user -->
        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-bd lobidrag">
              
                    <hr>

                    <div class="panel-heading">
                        <div class="panel-title">
                            <h4>Admin Info</h4>
                        </div>
                    </div>
                    <?php 
                   

                    ?>
                    <div class="panel-body">
                    <?php echo form_open('User/insert_admin_user');?>
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">CompanyName<i class="text-danger">*</i></label>
                          
                            <div class="col-sm-6">
                                <select name="companyid"  class="form-control" required>
                                    <option value="">Select Company  name</option>
                                    <?php
                                    for ($i=0;$i<count($company_info); $i++) { 
                                        
                                                                        ?>
                                    <option value="<?php echo $company_info[$i]['company_id']; ?>"><?php echo $company_info[$i]['company_name']; ?></option>
                                   
                                <?php  } ?>
                                </select>  
                            </div>
                        </div>

                        
                        
                         <div class="form-group row">
                            <label for="password" class="col-sm-3 col-form-label">Username<i class="text-danger">*</i></label>
                            <div class="col-sm-6">
                                <input type="text" tabindex="4"  class="form-control" id="username" required name="username" placeholder="<?php echo display('password') ?>" />
                            </div>
                        </div>

                        


                         <div class="form-group row">
                            <label for="password" class="col-sm-3 col-form-label"><?php echo display('password') ?> <i class="text-danger">*</i></label>
                            <div class="col-sm-6">
                                <input type="password" tabindex="4" ramji="" class="form-control" id="password" required name="password" placeholder="<?php echo display('password') ?>" />
                            </div>
                        </div>

                        

                         <div class="form-group row">
                            <label for="email" class="col-sm-3 col-form-label"><?php echo display('email') ?> <i class="text-danger">*</i></label>
                            <div class="col-sm-6">
                                <input type="email" tabindex="4" ramji="" class="form-control" id="email" required name="email" placeholder="<?php echo display('email') ?>" />
                            </div>
                        </div>

                       

                        <div class="form-group row">
                            <label for="example-text-input" class="col-sm-4 col-form-label"></label>
                            <div class="col-sm-6">
                                <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>">
                                    <input type="hidden" name="uid" value="<?php echo $_SESSION['user_id']; ?>">
                                <input type="submit" id="add-customer" class="btn btn-primary btn-large" name="add-user" value="<?php echo display('save') ?>" tabindex="6"/>
              
								
                            </div>
                        </div>
                   <?php echo form_close(); ?>
                    </div>
                 
                </div>
            </div>
        </div>
    </section>
</div>
<!-- Edit user end -->



