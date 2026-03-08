<?php
$this->load->view("includes/header");
$this->load->view("includes/sidebar");
?>
<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
	<h1><i class="fa fa-medkit"></i>&nbsp;Products Rates</h1>
    </section>

  <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-md-12">
           
          <div class="box box-info">
            <div class="box-header">
            </div>
            <!-- /.box-header -->
            <div class="box-body">
            <?php echo "<font style=color:#00468E; font-weight:bold text-align:center;>".$this->session->flashdata('record_added')."</font>"; ?>
              <table id="product-rates-grid" class="table table-striped" class="table table-bordered table-striped"  cellpadding="0" cellspacing="0" border="0" class="display" width="100%" >
                  <thead>
                  <tr>
                  <th>Product </th>
                  <th>Category</th>
                  <th>Customer</th>
		  <th>Vendor</th>
                  <th>Rate</th>
                  <th>Actions</th>
                </tr>
                </thead>
              </table>
              <?php if ($AdministrationRoles[2]['AddRoles']==1) { ?> 
              <div class="box-footer col-md-2 col-sm-4 col-xs-6">
                <a href="<?php echo base_url()?>ProductRates/AddProductRate/" class="btn btn-primary">Add New Record</a>
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
<!-- ./wrapper -->
<?php $this->load->view("includes/footer"); ?>