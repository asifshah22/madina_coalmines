<?php
$this->load->view("includes/header");
$this->load->view("includes/sidebar");
?>
<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1><i class="glyphicon glyphicon-user"></i>&nbsp;Customer</h1>
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
              <table id="customer-grid" class="table table-striped" class="table table-bordered table-striped"  cellpadding="0" cellspacing="0" border="0" class="display" width="100%">
                  <thead>
                  <tr>
                  <th>Customer/Buyer Name</th>
                  <th>Registration No</th>
                  <th>STRN Number</th>
                  <th>Due Amount</th>
                  <th>Contact No</th>
                  <th>Action</th>
                </tr>
              </thead>
              </table>
              <?php // if ($SalesRoles[2]['AddRoles']==1) { ?>
              <div class="box-footer col-md-2 col-sm-4 col-xs-6">
                  <a href="<?php echo base_url(); ?>Customer/AddCustomer" class="btn btn-primary">Add Record</a>
              </div>
              <?php // } ?>
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
<?php $this->load->view("includes/footer"); ?>

  <script>
 $(function(){
     var dataTable = $('#customer-grid').DataTable( {
            'aoColumnDefs': [{
            'bSortable': false,
            'aTargets': [-1] /* 1st one, start by the right */
            }],  
            "processing": true,
            "serverSide": true,
            "ajax":{
                url :"<?php echo base_url('Customer/Ajax_GetAllCustomers')?>", // json datasource
                type: "post",  // method  , by default get
                error: function(){  // error handling
                    $(".customer-grid-error").html("");
                    $("#customer-grid").append('<tbody class="employee-grid-error"><tr><th colspan="4">No data found in the server</th></tr></tbody>');
                    $("#customer-grid_processing").css("display","none");
 
                }
            }
        } ); 
 });   
</script>