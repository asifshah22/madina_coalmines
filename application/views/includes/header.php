
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
    <?php 
$this->load->view('includes/roles');
header('Content-Type: text/html; charset=UTF-8');
?>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>ALSYED Software Solutions</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <?php  header('Content-Type: text/html; charset=ISO-8859-1'); ?>
  <!-- jQuery 2.2.3 -->
  <script src="<?php echo base_url(); ?>plugins/jQuery/jquery-2.2.3.min.js"></script>
  
  <!-- Bootstrap 3.3.6 -->
  <script src="<?php echo base_url(); ?>bootstrap/js/bootstrap.min.js"></script>

  <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>bootstrap/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous"></link>
  <link rel="stylesheet" href="<?php echo base_url(); ?>lib/css/font-awesome/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>lib/css/font-awesome/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>lib/css/IMS.css">
  <link rel="stylesheet" href="<?php echo base_url(); ?>lib/css/IMS.min.css">
  <!-- Select2 -->
  
  <link rel="stylesheet" href="<?php echo base_url(); ?>plugins/select2/select2.min.css">
   <!-- bootstrap datepicker -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>plugins/datepicker/datepicker3.css">
  
  <link rel="stylesheet" href="<?php echo base_url(); ?>lib/css/skins/skin-blue.min.css">
  <!-- datatable -->
<!--   <link rel="stylesheet" href="<?php // echo base_url(); ?>plugins/datatables/jquery.dataTables.css">
  <link rel="stylesheet" href="<?php // echo base_url(); ?>plugins/datatables/jquery.dataTables.js">

  <link rel="stylesheet" href="<?php // echo base_url(); ?>plugins/datatables/jquery.dataTables.min.css">
  <link rel="stylesheet" href="<?php // echo base_url(); ?>plugins/datatables/jquery.dataTables.min.js">

  <link rel="stylesheet" href="<?php // echo base_url(); ?>plugins/datatables/dataTables.bootstrap.css">
  <link rel="stylesheet" href="<?php // echo base_url(); ?>plugins/datatables/dataTables.bootstrap.js"> -->


  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.15/css/jquery.dataTables.min.css">
  <script type="text/javascript"  src="https://cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js"></script> 
  <!--<link rel="stylesheet" href="<?php // echo base_url(); ?>plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">-->
  
</head>
<!--
BODY TAG OPTIONS:
=================
Apply one or more of the following classes to get the
desired effect
|---------------------------------------------------------|
| SKINS         | skin-blue                               |
|               | skin-black                              |
|               | skin-purple                             |
|               | skin-yellow                             |
|               | skin-red                                |
|               | skin-green                              |
|---------------------------------------------------------|
|LAYOUT OPTIONS | fixed                                   |
|               | layout-boxed                            |
|               | layout-top-nav                          |
|               | sidebar-collapse                        |
|               | sidebar-mini                            |
|---------------------------------------------------------|
-->
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

  <!-- Main Header -->
  <header class="main-header">
    <!-- Logo -->
    <a href="#" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><b>ALSYED</b></span>
      <!-- logo for regular state and mobile devices -->
     <!--<span class="logo-lg"><b>Inventory</b> System</span>-->
      <span style="border:0px solid; color:#FFF; margin-left:-14px; padding-top:1px;" class="logo-lg">AL-SYED SOFTWARE</span>
    </a>

    <!-- Header Navbar -->
    <nav class="navbar navbar-static-top" role="navigation">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>
      <!-- Navbar Right Menu -->
      <div class="navbar-custom-menu">       
      <!-- Notification -->
        <ul class="nav navbar-nav">  
         <!-- start notification work -->
<head>
    <style>
        /* Change the color of the bell icon */
        .fa-bell {
            color: red;  /* Replace 'red' with any color you want */
        }
    </style>
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="fa fa-bell" aria-hidden="true"></i> (<b><?php echo count($CustomerNotification); ?></b>)</a>
          <ul class="dropdown-menu notify-drop">
            <!-- end notify title -->
            <!-- notify content -->
            <div class="drop-content">
              <?php 
              foreach($CustomerNotification as $notification){
              ?>
                <li>
            		<div class="col-md-9 col-sm-9 col-xs-9 pd-l0">
                  <a href="<?php echo base_url() ?>Customer/ViewCustomer/<?php echo $notification['CustomerId'] ?>"><?php echo $notification['CustomerName']; ?>
                    <p><?php echo $notification['Note']; ?></p>
                    <p><?php echo $notification['AlertDate']; ?></p>
                  </a>
                  <hr>
                </div>
            	</li>
              <?php 
              }
              ?>
            </div>
          </ul>
        </li>
        <!-- end notification work -->
          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
<!--               <img src="<?php // echo base_url(); ?>lib/css/login/logo.jpeg" class="user-image" alt="User Image"> -->
                <!-- <img src="<?php // echo base_url(); ?>images/company-logo/<?php // echo $this->session->userdata('CompanyLogo'); ?>" class="user-image" alt="User Image"> -->
              <span class="hidden-xs"><?php print 'Profile'; // $this->session->userdata('EmployeeName'); ?></span>
            </a>
            <ul class="dropdown-menu">
              <!-- User image -->
              <li class="user-header">
<!--               <img src="<?php // echo base_url(); ?>images/company-logo/<?php // echo $this->session->userdata('CompanyLogo'); ?>" class="img-circle" alt="User Image"> -->
                <p><?php print $this->session->userdata('EmployeeName'); ?></p>
              </li>
               <!-- Menu Footer-->
              <li class="user-footer">
                <div class="pull-left">
                  <a href="<?php echo base_url() ?>Setting" class="btn btn-default btn-flat">Setting</a>
                </div>
                <div class="pull-right">
                  <a href="<?php echo base_url(); ?>Login/Logout" class="btn btn-default btn-flat">Sign out</a>
                </div>
              </li>
            </ul>
          </li>
        </ul>
      </div>
      
    </nav>
  </header>
 
 <script>
$(function(){

});
  </script>    