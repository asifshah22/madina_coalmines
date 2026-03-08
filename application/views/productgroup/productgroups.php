<?php $this->load->view('includes/header'); ?>
<?php $this->load->view('includes/sidebar'); ?>

  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
  <h1><i class="fa fa-medkit"></i>&nbsp;UOM</h1>
    </section>

  <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-md-12">
           
          <div class="box box-info">
            <div class="box-header">
            </div>
	      <a href="edit_productgroup.php"></a>
            <!-- /.box-header -->
            <div class="box-body">
            <?php echo "<font style=color:#00468E; font-weight:bold text-align:center;>".$this->session->flashdata('record_added')."</font>"; ?>
              <table id="productGroup-grid" class="table table-striped" class="table table-bordered table-striped"  cellpadding="0" cellspacing="0" border="0" class="display" width="100%" >
                  <thead>
                  <tr>
                  <th>S.No</th>
                  <th>Category Name</th>
                  <th>UOM Name</th>
                  <th>Actions</th>
                </tr>
                </thead>
              </table>
              <?php // if ($AdministrationRoles[1]['AddRoles']==1) { ?> 
              <div class="box-footer col-md-2 col-sm-4 col-xs-6">
                <a href="<?php echo base_url(); ?>ProductGroup/AddProductGroup" class="btn btn-primary">Add Record</a>
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
<!-- ./wrapper -->
<?php $this->load->view('includes/footer'); ?>

  <script>
 $(function(){
   //productGroup table
        var dataTable = $('#productGroup-grid').DataTable( {
        'aoColumnDefs': [{
            'bSortable': false,
            'aTargets': [-1] /* 1st one, start by the right */
            }],
            'order': [[ 0, "desc" ]],
            "processing": true,
            "serverSide": true,
            "ajax":{
                url :"<?php echo base_url('ProductGroup/Ajax_GetAllProductGroups') ?>", // json datasource
                type: "post",  // method  , by default get
                 error: function(){  // error handling
                    $(".productGroup-grid-error").html("");
                    $("#productGroup-grid").append('<tbody class="employee-grid-error"><tr><th colspan="3">No data found in the server</th></tr></tbody>');
                    $("#productGroup-grid_processing").css("display","none");
                }
            }
        } );
 });   
</script>