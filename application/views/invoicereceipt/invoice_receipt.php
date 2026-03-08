<?php $this->load->view('includes/header'); ?>
<?php $this->load->view('includes/sidebar'); ?>

<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1 style="display:inline"><i class="fa fa-book"></i>&nbsp;Invoice Receipt</h1>
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
                    <table id="installment-grid"  class="table table-striped"  cellpadding="0" cellspacing="0" border="0" class="display" width="100%" >
                      <thead>
                        <tr>
                          <th>Receipt No</th>
                          <th>Invoice No</th>
                          <th>Customer Name</th>
                          <th>Department</th>
                          <th>Date</th>
                          <th>Reference</th>
						  <th>Receipt Amount</th>
                            <th>Cheque No</th>
                              
                          <th>Action</th>
                        </tr>
                      </thead>

                    </table>
                    
                    <div class="box-footer col-md-2 col-sm-4 col-xs-6">
                      <a href="<?php echo base_url('InvoiceReceipt/AddInvoiceReceipt') ?>" class="btn btn-primary">Add Record</a>
                    </div>
                  <?php // if ($SalesRoles[0]['AddRoles'] == 1) {
                    ?>
                 
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
     var dataTable = $('#installment-grid').DataTable( {
            'aoColumnDefs': [{
            'bSortable': false,
            'aTargets': [0], /* 1st one, start by the right */
            "bSearchable": false,
            }],
    
            
	          'order': [[ 0, "desc" ]],
            "processing": true,
            "serverSide": true,
            "ajax":{
                url :"<?php echo base_url('InvoiceReceipt/Ajax_GetAllSales')?>", // json datasource
                type: "post",  // method  , by default get
                error: function(){  // error handling
                    $(".installment-grid-error").html("");
                    $("#installment-grid").append('<tbody class="employee-grid-error"><tr><th colspan="5">No data found in the server</th></tr></tbody>');
                    $("#installment-grid_processing").css("display","none");
 
                }
            }
        } ); 
 });   
</script>