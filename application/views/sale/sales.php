<?php $this->load->view('includes/header'); ?>
<?php $this->load->view('includes/sidebar'); ?>

<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1 style="display:inline"><i class="fa fa-shopping-cart"></i>&nbsp;Sales</h1>
    </section>

        <?php if($this->session->flashdata('messag_accounts') != ''){?>
            <div class="alert alert-success" role="alert" >
          <?php echo $this->session->flashdata('messag_accounts');?>
          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          </div>
         <?php }?> 
         
         <?php if($this->session->flashdata('fbr_success') != ''){?>
            <div class="alert alert-success" role="alert" >
          <?php echo $this->session->flashdata('fbr_success');?>
          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          </div>
         <?php }?> 
         
         <?php if($this->session->flashdata('fbr_error') != ''){?>
            <div class="alert alert-danger" role="alert" >
          <?php echo $this->session->flashdata('fbr_error');?>
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
                    <table id="sale-grid"  class="table table-striped"  cellpadding="0" cellspacing="0" border="0" class="display" width="100%" >
                      <thead>
                        <tr>
                          <th>Invoice No</th>
                         <th>Dc No</th>
                          <th>Sale Date</th>
                          <th>Sale Type</th>
                          <th>Saleman</th>
						 <th> Customer </th>
						 <th> Recipt Status </th>
						 <th> FBR Invocie No </th>
                          <th>Total Amount</th>
                          <th>Action</th>
                        </tr>
                      </thead>

                    </table>
                    
                  <?php // if ($SalesRoles[0]['AddRoles'] == 1) {
                    ?>
                  <div class="row" style="margin-top:10px;">
                    <div class="col-sm-2" style="margin-bottom:10px;">
                      <a href="<?= base_url(); ?>Sales/AddSale" class="btn btn-primary">Add Record</a>
                    </div>
                    <div class="col-sm-10">
                      <form action="<?= base_url(); ?>Sales/ImportSalesExcel" method="post" enctype="multipart/form-data" class="form-inline">
                        <div class="form-group" style="margin-right:8px;">
                          <input type="file" name="import_excel" class="form-control" accept=".xlsx,.xls" required>
                        </div>
                        <button type="submit" class="btn btn-success">Import Excel</button>
                        <a href="<?= base_url(); ?>Sales/DownloadSalesImportTemplate" class="btn btn-info" style="margin-left:6px;">Download Latest Template</a>
                      </form>
                    </div>
                  </div>
                    <?php
//                  } ?>
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
     var dataTable = $('#sale-grid').DataTable( {
            'aoColumnDefs': [{
            'bSortable': false,
            'aTargets': [-1] /* 1st one, start by the right */
            }],
	    'order': [[ 0, "desc" ]],
            "processing": true,
            "serverSide": true,
            "ajax":{
                url :"<?php echo base_url('Sales/Ajax_GetAllSales')?>", // json datasource
                type: "post",  // method  , by default get
                error: function(){  // error handling
                    $(".sale-grid-error").html("");
                    $("#sale-grid").append('<tbody class="employee-grid-error"><tr><th colspan="5">No data found in the server</th></tr></tbody>');
                    $("#sale-grid_processing").css("display","none");
 
                }
            }
        } ); 
 });   
</script>
