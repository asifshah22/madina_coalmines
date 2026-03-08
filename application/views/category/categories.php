<?php
    $this->load->view('includes/header');
    $this->load->view('includes/sidebar');
?>
<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1><i class="fa fa-cube"></i>&nbsp;Category</h1>
    </section>

  <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-md-12">
           
          <div class="box box-info">
            <!-- /.box-header -->
             <div class="box-body">
             <table id="category-grid" class="table table-striped" class="table table-bordered table-striped" cellpadding="0" cellspacing="0" border="0" class="display" width="100%">
              <thead>
                <tr>
                  <th>Category Name</th>
                  <th>Action</th>
                </tr>
              </thead>
            </table>
            <div class="box-footer col-md-2 col-sm-4 col-xs-6">
              <a href="<?php echo base_url(); ?>Category/AddCategory" class="btn btn-primary">Add Record</a>
            </div>
            <!-- /.box-body -->
          </div>
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->  
  </div>
<?php $this->load->view('includes/footer'); ?>

<script type="text/javascript">
  $(function () {

    var dataTable = $('#category-grid').DataTable( {
      
            'aoColumnDefs': [{
            'bSortable': false,
            'aTargets': [-1] /* 1st one, start by the right */
            }],
            'order': [[ 0, "desc" ]],
            "processing": true,
            "serverSide": true,
            "ajax":{
                url :"<?php echo base_url('Category/Ajax_GetAllCategories') ?>", // json datasource
                type: "post",  // method  , by default get
                 error: function(){  // error handling
                    $(".category-grid-error").html("");
                    $("#category-grid").append('<tbody class="employee-grid-error"><tr><th colspan="3">No data found in the server</th></tr></tbody>');
                    $("#category-grid_processing").css("display","none");
                }
            }
        }); 
  })


</script>


