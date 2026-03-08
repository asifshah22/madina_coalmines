<?php 
    $this->load->view('includes/header');
    $this->load->view('includes/sidebar'); 
?>
<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
     <h1><i class="fa fa-cube"></i>&nbsp;Saleman</h1>
    </section>

  <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-md-12">
          <!-- form elements  --> 
          <div id="showresult">
          <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title">View Saleman</h3>
            </div>
              <div class="box-body">

              <label for="fname">Saleman Name:</label>&nbsp;&nbsp;&nbsp;&nbsp;        
                <?php echo $GetCategoryById->SalemanName;?><br>

              <label for="lname">Contact #:</label>&nbsp;&nbsp;&nbsp;&nbsp;
              <?php echo $GetCategoryById->ContactNumber;?><br>

              <label for="lname">Address:</label>&nbsp;&nbsp;&nbsp;&nbsp;
              <?php echo $GetCategoryById->Address;?><br>

              </div>
              <!-- /.box-body -->
	          <div class="box-body">
               <div class="row">
                <div class='col-md-2'>
                <a href="<?php echo base_url(); ?>Saleman/AddSaleman" class="btn btn-block btn-primary">Add Record</a>
                </div>   
               <div class="col-md-2">
               <a href="<?php echo base_url(); ?>Saleman/"><button type="button" name="BankToMain" value="BankToMain" class="btn btn-block btn-primary">Back to Main</button></a>
                </div>
               </div>
              </div>
          </div>
          <!-- /.box -->
          </div>
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
    
  </div>
<?php $this->load->view('includes/footer'); ?>