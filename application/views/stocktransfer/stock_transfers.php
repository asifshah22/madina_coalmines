<?php $this->load->view('includes/header'); ?>
<?php $this->load->view('includes/sidebar'); ?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
  <h1><i class="fa fa-exchange"></i>&nbsp;Stock Transfer</h1>
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
                  <table id="stocktransfer-grid" class="table table-striped" class="table table-bordered table-striped"  cellpadding="0" cellspacing="0" border="0" class="display" width="100%">
                      <thead>
                        <tr>
                          <th>Stock Tranfer No</th>
                          <th>Product</th>
                          <th>Location</th>
                          <th>Quantity</th>
                          <th>Action</th>
                        </tr>
                      </thead>

                    </table>

                  <div class="col-sm-2"><a href="<?= base_url(); ?>StockTransfer/AddStockTransfer" class="btn btn-primary">Add Record</a>
                  </div>
              
              </div>
            
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
    </section>
    <!-- /.content -->
    
  </div>

<?php $this->load->view('includes/footer'); ?>

  <script>
 $(function(){
     var dataTable = $('#stocktransfer-grid').DataTable( {
            'aoColumnDefs': [{
            'bSortable': false,
            'aTargets': [-1] /* 1st one, start by the right */
            }],  
            "processing": true,
            "serverSide": true,
            "ajax":{
                url :"<?php echo base_url('StockTransfer/Ajax_GetAllStockTransfer')?>", // json datasource
                type: "post",  // method  , by default get
                error: function(){  // error handling
                    $(".stocktransfer-grid-error").html("");
                    $("#stocktransfer-grid").append('<tbody class="employee-grid-error"><tr><th colspan="5">No data found in the server</th></tr></tbody>');
                    $("#stocktransfer-grid_processing").css("display","none");
 
                }
            }
        } ); 
 });   
</script>