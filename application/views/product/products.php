<?php
$this->load->view("includes/header");
$this->load->view("includes/sidebar");
?>
<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
	<h1><i class="fa fa-medkit"></i>&nbsp;Products</h1>
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
              <table id="product-grid" class="table table-striped" class="table table-bordered table-striped"  cellpadding="0" cellspacing="0" border="0" class="display" width="100%" >
                  <thead>
                  <tr>
                  <th>Product Description </th>
                  <th>Category Name</th>
                  <th>Brand</th>
                  <th>P.Price</th>
                  <th>Actions</th>
                </tr>
                </thead>
              </table>
              <div class="box-footer col-md-2 col-sm-4 col-xs-6">
                <a href="<?php echo base_url('Product/AddProduct') ?>" class="btn btn-primary">Add Record</a>
              </div>
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

<script type="text/javascript">
  $(function () {
        
        var dataTable = $('#product-grid').DataTable( {
            'aoColumnDefs': [{
            'bSortable': false,
            'aTargets': [-1] /* 1st one, start by the right */
            }],
            'order': [[ 0, "desc" ]],
            "processing": true,
            "serverSide": true,
            "ajax":{
                url :"<?php echo base_url('Product/Ajax_GetAllProducts') ?>", // json datasource
                type: "post",  // method  , by default get
                error: function(){  // error handling
                    $(".product-grid-error").html("");
                    $("#product-grid").append('<tbody class="employee-grid-error"><tr><th colspan="4">No data found in the server</th></tr></tbody>');
                    $("#product-grid_processing").css("display","none");
                    $('#product-grid_length').css({"margin-left":"10px"});
                 }         
            }
        } );

  })
</script>