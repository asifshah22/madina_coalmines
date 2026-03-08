<?php 
    $this->load->view('includes/header');
    $this->load->view('includes/sidebar'); 
?>
<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1><i class="fa fa-chain"></i>&nbsp;Transportation</h1>
    </section>

  <!-- Main content -->
    <section class="content">	
      <div class="row">
        <div class="col-md-12">
           
          <div class="box box-info">
            <!-- /.box-header -->
             <div class="box-body">
             <table id="reference-grid" class="table table-striped" class="table table-bordered table-striped" cellpadding="0" cellspacing="0" border="0" class="display" width="100%">
              <thead>
                <tr>
		  <th style="width:20%;">Name</th>
		  <th style="width:20%;">Contact Number</th>
		  <th style="width:20%;">Address</th>
                  <th style="width:10%;">Action</th>
                </tr>
              </thead>
            </table>
               
            <div class="box-footer col-md-2 col-sm-4 col-xs-6">
              <a href="<?php echo base_url(); ?>Reference/AddReference" class="btn btn-primary">Add Record</a>
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

<script>
 $(function(){
     var dataTable = $('#reference-grid').DataTable( {
            'aoColumnDefs': [{
            'bSortable': false,
            'aTargets': [-1] /* 1st one, start by the right */
            }],  
            "processing": true,
            "serverSide": true,
            "ajax":{
                url :"<?php echo base_url('Reference/Ajax_GetAllReference')?>", // json datasource
                type: "post",  // method  , by default get
                error: function(){  // error handling
                    $(".reference-grid-error").html("");
                    $("#reference-grid").append('<tbody class="reference-grid-error"><tr><th colspan="2">No data found in the server</th></tr></tbody>');
                    $("#reference-grid_processing").css("display","none");
 
                }
            }
        } ); 
 });   
</script>

