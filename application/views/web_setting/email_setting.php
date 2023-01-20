<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/mail.css'); ?>">
<script src="<?php echo base_url('assets/ckeditor/ckeditor.js'); ?>"></script>
<!-- Add new customer start -->
<div class="content-wrapper">
    <section class="content-header">
        <div class="header-icon">
            <i class="pe-7s-note2"></i>
        </div>
        <div class="header-title">
            <h1><?php echo display('update_setting') ?></h1>
            <small>Email</small>
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
                            <h4>Webmail</h4>
                        </div>
                    </div>
                    
                <div class="mail-box">
                  <aside class="sm-side">
                      <div class="user-head">
                          <a class="inbox-avatar" href="javascript:;">
                              <img  width="64" hieght="60" src="http://bootsnipp.com/img/avatars/ebeb306fd7ec11ab68cbcaa34282158bd80361a7.jpg">
                          </a>
                          <div class="user-name">
                              <h5><a href="#">Admin User</a></h5>
                              <span><a href="#">admin@gmail.com</a></span>
                          </div>
                          <!-- <a class="mail-dropdown pull-right" href="javascript:;">
                              <i class="fa fa-chevron-down"></i>
                          </a> -->
                      </div>
                      <div class="inbox-body">
                          <a href="#myModal" data-toggle="modal"  title="Compose" class="btn btn-compose">
                              Compose
                          </a>
                          <!-- Modal -->
                          <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="myModal" class="modal fade" style="display: none;">
                              <div class="modal-dialog modal-lg">
                                  <div class="modal-content">
                                      <div class="modal-header">
                                         <h4 class="modal-title">Compose</h4>
                                          <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                                      </div>
                                      <div class="modal-body">
                                          <form role="form">
                                              <div class="form-group">
                                                  <label class="col-lg-12 control-label">To</label>
                                                  <div class="col-lg-12">
                                                      <input type="email" placeholder="" id="inputEmail1" class="form-control">
                                                  </div>
                                              </div>
                                              <div class="form-group">
                                                  <label class="col-lg-12 control-label">Cc / Bcc</label>
                                                  <div class="col-lg-12">
                                                      <input type="email" placeholder="" id="cc" class="form-control">
                                                  </div>
                                              </div>
                                              <div class="form-group">
                                                  <label class="col-lg-12 control-label">Subject</label>
                                                  <div class="col-lg-12">
                                                      <input type="text" placeholder="" id="inputPassword1" class="form-control">
                                                  </div>
                                              </div>
                                              <div class="form-group">
                                                  <label class="col-lg-12 control-label">Message</label>
                                                  <div class="col-lg-12">
                                                      <textarea rows="10" cols="30" class="form-control" id="text_editor" name="text_editor"></textarea>
                                                  </div>
                                              </div>

                                              <div class="form-group">
                                                  <div class="col-lg-offset-2 col-lg-12">
                                                      <span class="btn green fileinput-button">
                                                        <i class="fa fa-plus fa fa-white"></i>
                                                        <span>Attachment</span>
                                                        <input type="file" name="files[]" multiple="">
                                                      </span>
                                                      &nbsp;
                                                      <button class="btn btn-send" type="submit">Send</button>
                                                  </div>
                                              </div>
                                          </form>
                                      </div>
                                  </div><!-- /.modal-content -->
                              </div><!-- /.modal-dialog -->
                          </div><!-- /.modal -->
                      </div>
                      <ul class="inbox-nav inbox-divider">
                          <li class="active">
                              <a href="#" class="tablinks" onclick="openCity(event, 'Inbox')" id="defaultOpen"><i class="fa fa-inbox"></i> Inbox <span class="label label-danger pull-right">3</span></a>

                          </li>
                          <li>
                              <a href="#" class="tablinks" onclick="openCity(event, 'Sentbox')"><i class="fa fa-envelope-o"></i> Sent</a>
                          </li>
                         <!--  <li>
                              <a href="#"><i class="fa fa-bookmark-o"></i> Important</a>
                          </li>
                          <li>
                              <a href="#"><i class=" fa fa-external-link"></i> Drafts <span class="label label-info pull-right">30</span></a>
                          </li> -->
                          <li>
                              <a href="#" class="tablinks" onclick="openCity(event, 'Trash')"><i class=" fa fa-trash-o"></i> Trash</a>
                          </li>
                      </ul>
                      
                      

                     <!--  <div class="inbox-body text-center">
                          <div class="btn-group">
                              <a class="btn mini btn-primary" href="javascript:;">
                                  <i class="fa fa-plus"></i>
                              </a>
                          </div>
                          <div class="btn-group">
                              <a class="btn mini btn-success" href="javascript:;">
                                  <i class="fa fa-phone"></i>
                              </a>
                          </div>
                          <div class="btn-group">
                              <a class="btn mini btn-info" href="javascript:;">
                                  <i class="fa fa-cog"></i>
                              </a>
                          </div>
                      </div> -->

                  </aside>
                  <aside class="lg-side">
                      <div class="inbox-head">
                          <h3>Inbox</h3>
                          <form action="#" class="pull-right position">
                              <div class="input-append">
                                  <input type="text" class="sr-input" placeholder="Search Mail">
                                  <button class="btn sr-btn" type="button"><i class="fa fa-search"></i></button>
                              </div>
                          </form>
                      </div>
                      <div class="inbox-body">
                         <div class="mail-option">
                             <div class="chk-all">
                                 <input type="checkbox" id="checkAll" class="mail-checkbox mail-group-checkbox">
                                 <div class="btn-group">
                                     <a data-toggle="dropdown" href="#" class="btn mini all" aria-expanded="false">
                                         All
                                         <i class="fa fa-angle-down "></i>
                                     </a>
                                     <ul class="dropdown-menu">
                                         <li><a href="#"> None</a></li>
                                         <li><a href="#"> Read</a></li>
                                         <li><a href="#"> Unread</a></li>
                                     </ul>
                                 </div>
                             </div>

                             <div class="btn-group">
                                 <a data-original-title="Refresh" data-placement="top" data-toggle="dropdown" href="#" class="btn mini tooltips">
                                     <i class=" fa fa-refresh"></i>
                                 </a>
                             </div>
                             <div class="btn-group hidden-phone">
                                 <a data-toggle="dropdown" href="#" class="btn mini blue" aria-expanded="false">
                                     More
                                     <i class="fa fa-angle-down "></i>
                                 </a>
                                 <ul class="dropdown-menu">
                                     <li><a href="#"><i class="fa fa-pencil"></i> Mark as Read</a></li>
                                     <li><a href="#"><i class="fa fa-ban"></i> Spam</a></li>
                                     <li class="divider"></li>
                                     <li><a href="#"><i class="fa fa-trash-o"></i> Delete</a></li>
                                 </ul>
                             </div>
                             <div class="btn-group">
                                 <a data-toggle="dropdown" href="#" class="btn mini blue">
                                     Move to
                                     <i class="fa fa-angle-down "></i>
                                 </a>
                                 <ul class="dropdown-menu">
                                     <li><a href="#"><i class="fa fa-pencil"></i> Mark as Read</a></li>
                                     <li><a href="#"><i class="fa fa-ban"></i> Spam</a></li>
                                     <li class="divider"></li>
                                     <li><a href="#"><i class="fa fa-trash-o"></i> Delete</a></li>
                                 </ul>
                             </div>

                             <ul class="unstyled inbox-pagination">
                                 <li><span>1-50 of 234</span></li>
                                 <li>
                                     <a class="np-btn" href="#"><i class="fa fa-angle-left  pagination-left"></i></a>
                                 </li>
                                 <li>
                                     <a class="np-btn" href="#"><i class="fa fa-angle-right pagination-right"></i></a>
                                 </li>
                             </ul>
                         </div>
                         <!-- Table Inbox -->
                          <div id="Inbox" class="tabcontent">
                            <table class="table table-inbox table-hover">
                              <tbody>
                                <tr class="unread" class="tablinks" onclick="openCity(event, 'View')">
                                  <td class="inbox-small-cells">
                                      <input type="checkbox" id="checkItem" class="mail-checkbox">
                                  </td>
                                  <td class="inbox-small-cells"><i class="fa fa-star"></i></td>
                                  <td class="view-message  dont-show">PHPClass</td>
                                  <td class="view-message ">Added a new class: Login Class Fast Site</td>
                                  <td class="view-message  inbox-small-cells"><i class="fa fa-paperclip"></i> &nbsp; <i class="fa fa-trash" aria-hidden="true"></i> </td>
                                  <td class="view-message  text-right"><?php echo date('M d'); ?></td>
                                </tr>

                                <tr class="">
                                  <td class="inbox-small-cells">
                                      <input type="checkbox" id="checkItem" class="mail-checkbox">
                                  </td>
                                  <td class="inbox-small-cells"><i class="fa fa-star inbox-started"></i></td>
                                  <td class="view-message dont-show">Freelancer.com</td>
                                  <td class="view-message">Stop wasting your visitors </td>
                                   <td class="view-message  inbox-small-cells"><i class="fa fa-paperclip"></i> &nbsp; <i class="fa fa-trash" aria-hidden="true"></i> </td>
                                  <td class="view-message text-right"><?php echo date('M d'); ?></td>
                              </tr>

                               <tr class="">
                                  <td class="inbox-small-cells">
                                      <input type="checkbox" id="checkItem" class="mail-checkbox">
                                  </td>
                                  <td class="inbox-small-cells"><i class="fa fa-star"></i></td>
                                  <td class="view-message dont-show">Facebook</td>
                                  <td class="view-message view-message">Somebody requested a new password </td>
                                   <td class="view-message  inbox-small-cells"><i class="fa fa-paperclip"></i> &nbsp; <i class="fa fa-trash" aria-hidden="true"></i> </td>
                                  <td class="view-message text-right"><?php echo date('M d'); ?></td>
                              </tr>
                              </tbody>
                            </table>
                          </div>
                          <!-- Table inbox end -->
                          <div id="Sentbox" class="tabcontent">
                            <table class="table table-inbox table-hover">
                              <tbody>
                                <tr class="unread">
                                  <td class="inbox-small-cells">
                                      <input type="checkbox" id="checkItem" class="mail-checkbox">
                                  </td>
                                  <td class="inbox-small-cells"><i class="fa fa-star"></i></td>
                                  <td class="view-message  dont-show">Sentbox</td>
                                  <td class="view-message ">Added a new class: Login Class Fast Site</td>
                                   <td class="view-message  inbox-small-cells"><i class="fa fa-paperclip"></i> &nbsp; <i class="fa fa-trash" aria-hidden="true"></i> </td>
                                  <td class="view-message  text-right"><?php echo date('H:i:A'); ?></td>
                                </tr>
                              </tbody>
                            </table>
                          </div>

                          <div id="Trash" class="tabcontent">
                            <table class="table table-inbox table-hover">
                              <tbody>
                                <tr class="unread">
                                  <td class="inbox-small-cells">
                                      <input type="checkbox" id="checkItem" class="mail-checkbox">
                                  </td>
                                  <td class="inbox-small-cells"><i class="fa fa-star"></i></td>
                                  <td class="view-message  dont-show">Trash</td>
                                  <td class="view-message ">Added a new class: Login Class Fast Site</td>
                                   <td class="view-message  inbox-small-cells"><i class="fa fa-paperclip"></i> &nbsp; <i class="fa fa-trash" aria-hidden="true"></i> </td>
                                  <td class="view-message  text-right"><?php echo date('H:i:A'); ?></td>
                                </tr>
                              </tbody>
                            </table>
                          </div>

                          <div id="View" class="tabcontent">
                            <table class="table table-inbox table-hover">
                                  <tbody>
                                    <tr class="unread">
                                      <td class="view-message" onclick="openCity(event, 'Inbox')"><i class="fa fa-arrow-left" aria-hidden="true"></i> &nbsp;&nbsp; Added a new class: Login Class Fast Site</td>
                                      <td class="view-message  inbox-small-cells text-right"><i class="fa fa-clock-o" aria-hidden="true"></i>&nbsp;<span style="font-weight: normal;"><?php echo date('H:i:A'); ?></span></td>
                                       <td class="view-message  inbox-small-cells text-right"><i class="fa fa-print" aria-hidden="true"></i> &nbsp; <i class="fa fa-star"></i></i> </td>
                                    </tr>
                                  </tbody>
                            </table>
                            <br>
                              <table class="table table-inbox table-hover">
                                  <tbody>
                                    <tr class="unread">
                                      <td class="view-message dont-show"><img width="64" hieght="60" src="http://bootsnipp.com/img/avatars/ebeb306fd7ec11ab68cbcaa34282158bd80361a7.jpg"></td>
                                      <td class="view-message text-left" style="max-width: 340px;">John Adam <br><br>
                                        <address style="font-weight: normal;">Hi Kos9,

                                            We wanted to let you know that your payout for earnings up until the end of July 2021 has been calculated.

                                            Your payout will be $320.00.

                                            Your payout will be processed as part of our normal schedule later this month. You will receive an email when your payout has been processed.

                                            Regards,
                                            Envato Market Team
                                        </address>
                                      </td>
                                      <td class="view-message text-left"></td>
                                       <td class="view-message  inbox-small-cells"><a href="#myModal" data-toggle="modal"  title="Compose"><i class="fa fa-reply" aria-hidden="true"></i> </a></td>
                                      <td class="view-message  text-right"><?php echo date('M d'); ?></td>
                                    </tr>
                                  </tbody>
                            </table>
                          </div>
                      </div>
                  </aside>
              </div>
</div>
</div>


                    <!-- <?php echo form_open_multipart('Cweb_setting/update_invoice_setting/new_sale', array('class' => 'form-vertical', 'id' => '')) ?>
                    <div class="panel-body">

                           <iframe src="https://webmail.afterlogic.com/" style="width: 1000px; height: 640px;"></iframe>

                    </div>
                   <?php echo form_close() ?> -->
                </div>
            </div>
        </div>
    </section>
</div>
<!-- Add new customer end -->

<script>
  CKEDITOR.replace("text_editor");
</script> 

<script type="text/javascript">
     $("#checkAll").click(function () {
     $('input:checkbox').not(this).prop('checked', this.checked);
 });
</script>   

<style type="text/css">
  .cke_bottom {
  padding-bottom: 3px;
  display: none;
}

.label-danger{
    background-color: #38469f;
    border: 2px solid #38469f;
}
</style>

<script>
  function openCity(evt, cityName) {
    var i, tabcontent, tablinks;
    tabcontent = document.getElementsByClassName("tabcontent");
    for (i = 0; i < tabcontent.length; i++) {
      tabcontent[i].style.display = "none";
    }
    tablinks = document.getElementsByClassName("tablinks");
    for (i = 0; i < tablinks.length; i++) {
      tablinks[i].className = tablinks[i].className.replace(" active", "");
    }
    document.getElementById(cityName).style.display = "block";
    evt.currentTarget.className += " active";
  }

  // Get the element with id="defaultOpen" and click on it
  document.getElementById("defaultOpen").click();
</script>



