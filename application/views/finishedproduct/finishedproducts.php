<?php
$this->load->view("includes/header");
$this->load->view("includes/sidebar");
?>
<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1><i class="fa fa-shopping-cart"></i>&nbsp;Finished Product</i></h1>
    </section>
  <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-md-12">
           
          <div class="box">
            <div class="box-header">
              
            </div>
            <!-- /.box-header -->
            <div class="box-body">
               <?php echo "<font style=color:#00468E; font-weight:bold text-align:center;>".$this->session->flashdata('record_added')."</font>"; ?>
               <table id="production-grid" class="table table-striped" class="table table-bordered table-striped"  cellpadding="0" cellspacing="0" border="0" class="display" width="100%">
                <thead>
                 <tr>
                  <th>Production #</th>
		              <th>Product Name</th>
                  <th>Finished Date</th>
                  <th>Mill Serial. #</th>
		              <th>Shift</th>                 
                  <th>Actions</th>
                 </tr>
               </thead>
              </table>
              <?php if ($AdministrationRoles[8]['AddRoles']==1) { ?>
              <div class="box-footer col-md-2 col-sm-4 col-xs-6">
                <a href="<?php echo base_url(); ?>FinishedProducts/AddFinishedProduct" class="btn btn-primary">Add Record</a>
              </div>
              <?php } ?>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
    
    
  </div>
  <!-- /.content-wrapper -->
  <footer class="main-footer"></footer>
</div>
<!-- ./wrapper -->
<?php $this->load->view("includes/footer"); ?>