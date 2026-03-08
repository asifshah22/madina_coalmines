<?php $this->load->view('includes/header'); ?>
<?php $this->load->view('includes/sidebar'); ?>

<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1 style="display:inline"><i class="fa fa-bank"></i>&nbsp;Opening Stock</h1>
    
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
                    <table id="opening-stock-grid"  class="table table-striped"  cellpadding="0" cellspacing="0" border="0" class="display" width="100%" >
                      <thead>
                        <tr>
                          <th>Stock Opening No</th>
                          <th>Product</th>
                          <th>Location</th>
                          <th>Quantity</th>
                          <th>Action</th>
                        </tr>
                      </thead>

                    </table>
              <?php // if ($RegistrationRoles[1]['AddRoles']==1) { ?>
              <div class="box-footer col-md-2 col-sm-4 col-xs-6">
                <a href="<?php echo base_url(); ?>OpeningStock/AddOpeningStock" class="btn btn-primary">Add Record</a>
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
  <!-- /.content-wrapper -->
    <!-- /.main-content ends -->
<?php $this->load->view('includes/footer'); ?>

  <script>
 $(function(){
     var dataTable = $('#opening-stock-grid').DataTable( {
            'aoColumnDefs': [{
            'bSortable': false,
            'aTargets': [-1] /* 1st one, start by the right */
            }],  
            "processing": true,
            "serverSide": true,
            "ajax":{
                url :"<?php echo base_url('OpeningStock/Ajax_GetAllOpeningStock')?>", // json datasource
                type: "post",  // method  , by default get
                error: function(){  // error handling
                    $(".opening-stock-grid-error").html("");
                    $("#opening-stock-grid").append('<tbody class="employee-grid-error"><tr><th colspan="5">No data found in the server</th></tr></tbody>');
                    $("#opening-stock-grid_processing").css("display","none");
 
                }
            }
        } ); 
 });   
</script>