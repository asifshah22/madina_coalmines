<?php 
    $this->load->view('includes/header');
    $this->load->view('includes/sidebar'); 
?>
<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1><i class="fa fa-black-tie"></i>&nbsp;Designations</h1>
    </section>

    <section class="content">
      <div class="row">
        <div class="col-md-12">           
          <div class="box box-info">
             <div class="box-body">
             <table id="designation-grid" class="table table-striped" class="table table-bordered table-striped" cellpadding="0" cellspacing="0" border="0" class="display" width="100%">
              <thead>
                <tr>
                  <th>Designation</th>
                  <th>Action</th>
                </tr>
              </thead>
            </table>
             <?php if ($AdministrationRoles[6]['AddRoles']==1) { ?>     
            <div class="box-footer col-md-2 col-sm-4 col-xs-6">
	      <a href="<?php echo base_url(); ?>Designation/AddDesignation" class="btn btn-primary">Add Record</a>
            </div>
             <?php } ?>
            <!-- /.box-body -->
          </div>
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
  </div>  
<?php $this->load->view('includes/footer'); ?>

<script type="text/javascript">
  $(function () {
    
        // Designation table
        var dataTable = $('#designation-grid').DataTable( {
            'aoColumnDefs': [{
            'bSortable': false,
            'aTargets': [-1] /* 1st one, start by the right */
            }],
            'order': [[ 0, "desc" ]],
            "processing": true,
            "serverSide": true,
            "ajax":{
                url :"<?php echo base_url('Designation/Ajax_GetAllDesignations') ?>", // json datasource
                type: "post",  // method  , by default get
                 error: function(){  // error handling
                    $(".designation-grid-error").html("");
                    $("#designation-grid").append('<tbody class="employee-grid-error"><tr><th colspan="3">No data found in the server</th></tr></tbody>');
                    $("#designation-grid_processing").css("display","none");
                }             
            }
        } ); 

  })
</script>