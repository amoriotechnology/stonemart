<!-- User List Start -->
<div class="content-wrapper">
	<section class="content-header">
	    <div class="header-icon">
	        <i class="pe-7s-note2"></i>
	    </div>
	    <div class="header-title">
	        <h1>Manage User</h1>
	        <small>Manage User</small>
	        <ol class="breadcrumb">
	            <li><a href="#"><i class="pe-7s-home"></i> <?php echo display('home') ?></a></li>
	            <li><a href="#"><?php echo display('web_settings') ?></a></li>
	            <li class="active">Manage User</li>
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
            <div class="col-sm-12">
              
                	<?php if($this->permission1->method('add_user','create')->access()){?>
                  <a href="<?php echo base_url('User/add_user')?>" class="btn btn-success m-b-5 m-r-2"><i class="ti-plus"> </i> Add User </a>
              <?php }?>
               
            </div>
        </div>

		<!-- User List -->
		<div class="row">
		    <div class="col-sm-12">
		        <div class="panel panel-bd lobidrag">
		            <div class="panel-heading">
		                <div class="panel-title">
		                    <!-- <h4><?php echo display('manage_users') ?> </h4> -->
							<h4>Manage user </h4>
		                </div>
		            </div>
		            <div class="panel-body">
		                <div class="table-responsive">
		                    <table id="dataTableExample3" class="table table-bordered table-striped table-hover">
		           				<thead>
									<tr>
										<th><?php echo display('sl') ?></th>
										
										<th><?php echo display('name') ?></th>
										<th><?php echo display('email') ?></th>
										<th><?php echo display('user_type') ?></th>
										<th><?php echo display('status') ?></th>
										<th><?php echo display('action') ?></th>
									</tr>
								</thead>
								<tbody>
								<?php
								if ($user_list) {
									foreach ($user_list as $user) {
								?>
									<tr>
										<td><?php echo $user["sl"]?></td>
									
										<td><?php echo html_escape($user["username"])?></td>
										<td><?php echo html_escape($user["username"])?></td>
										<td><?php 
											$user_type = $user["user_type"];
											if ($user_type == 1) {
												echo "Admin";
											}else{
												echo "User";
											}
										?></td>
											<td><?php 
											$status=$user["status"];
											if ($status==1) {
												echo "Active";
											}else{
												echo "Inactive";
											}
										?></td>
										<td>
											<center>
											<?php echo form_open()?>
												<!-- 			 -->
												<?php
													if ($user["u_type"] != 2) {
												?>
												<a href="<?php echo base_url('User/user_delete/'.$user["user_id"])?>" class="btn btn-danger btn-sm"  data-toggle="tooltip" onclick="return confirm('Are you Sure ?')" data-placement="right" title="" data-original-title="<?php echo display('delete') ?> " style='color:#fff;'><i class="fa fa-trash-o" aria-hidden="true"></i></a>
												<?php
													}
												?>
											<?php echo form_close()?>
											</center>
										</td>
									</tr>
								<?php } } ?>
								</tbody>
		                    </table>
		                </div>
		            </div>
		        </div>
		    </div>
		</div>
	</section>
</div>
<!-- User List End -->
