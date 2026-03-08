<?php $this->load->view('includes/header'); ?>
<?php $this->load->view('includes/sidebar'); ?>
<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1 style="display:inline"><i class="fa fa-shopping-cart"></i>&nbsp;Sales Return</h1>
    </section>

        <?php if($this->session->flashdata('messag_accounts') != ''){?>
            <div class="alert alert-success" role="alert" >
          <?php echo $this->session->flashdata('messag_accounts');?>
          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          </div>
         <?php }?> 
  <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-md-12">
           
          <div class="box box-info">
            <div class="box-header">
    <!--          <h3 class="box-title">Total Records (<?php // print count($GetAllAccounts); ?>)</h3> -->
            </div>
            <!-- /.box-header -->
            <div class="box-body ">
            <?php echo "<font style=color:#00468E; font-weight:bold text-align:center;>".$this->session->flashdata('record_added')."</font>"; ?>
                    <table id="salesreturn-grid"  class="table table-striped"  cellpadding="0" cellspacing="0" border="0" class="display" width="100%" >
                      <thead>
                        <tr>
                          <th>Sale Return No</th>
                          <th>Sale Return Date</th>
                          <th>Sale Return Type</th>
                          <th>Total Amount</th>
                          <th>Action</th>
                        </tr>
                      </thead>

                    </table>
                  <?php // if ($SalesRoles[1]['AddRoles'] == 1) {
                  ?>
                  <div class="col-sm-2"><a href="<?= base_url(); ?>SalesReturn/AddSalesReturn" class="btn btn-primary">Add Record</a></div>
                  <?php // } ?>
              </div><!-- /.span -->
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
<?php $this->load->view('includes/footer'); ?>

  <script>
 $(function(){
     var dataTable = $('#salesreturn-grid').DataTable( {
            'aoColumnDefs': [{
            'bSortable': false,
            'aTargets': [-1] /* 1st one, start by the right */
            }],  
            "processing": true,
            "serverSide": true,
            "ajax":{
                url :"<?php echo base_url('SalesReturn/Ajax_GetAllSalesReturn')?>", // json datasource
                type: "post",  // method  , by default get
                error: function(){  // error handling
                    $(".salesreturn-grid-error").html("");
                    $("#salesreturn-grid").append('<tbody class="employee-grid-error"><tr><th colspan="5">No data found in the server</th></tr></tbody>');
                    $("#salesreturn-grid_processing").css("display","none");
 
                }
            }
        } ); 
 });   
</script>