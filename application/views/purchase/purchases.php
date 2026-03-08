<?php 
    $this->load->view('includes/header');
    $this->load->view('includes/sidebar'); 
?>
  <div class="content-wrapper">
    <section class="content-header">
    <h1><i class="fa fa-laptop"></i>&nbsp;Purchases</h1>
    </section>
    <section class="content">
      <div class="row">
        <div class="col-md-12">
          <div class="box box-info">
            <div class="box-header"></div>
              <div class="box-body">
                <?php echo "<font style=color:#00468E; font-weight:bold text-align:center;>".$this->session->flashdata('record_added')."</font>"; ?> 
                <table id="purchase-grid" class="table table-striped" class="table table-bordered table-striped"  cellpadding="0" cellspacing="0" border="0" class="display" width="100%">
                 <thead> 
                  <tr>
                    <th>Purchase Id</th>
                    <th>Purchase Date</th>
                    <th>Purchase Type</th>
					          <th> Vendor </th>
                    <th>Total Amount</th>
                    <th>Action</th>
                  </tr>
                 </thead> 
                </table>
              <?php // if ($PurchasesRoles[0]['AddRoles']==1) { ?>  
              <div class="box-footer col-md-2 col-sm-4 col-xs-6">
                <a href="<?php echo base_url('Purchase/AddPurchase')?>" class="btn btn-primary">Add Record</a>
              </div>
              <?php // } ?>   
              </div>
          </div>
        </div>
      </div>
    </section>
  </div>
<?php $this->load->view('includes/footer'); ?>

  <script>
 $(function(){
     var dataTable = $('#purchase-grid').DataTable( {
            'aoColumnDefs': [{
            'bSortable': false,
            'aTargets': [-1] /* 1st one, start by the right */
            }],  
            "processing": true,
            "serverSide": true,
            "ajax":{
                url :"<?php echo base_url('Purchase/Ajax_GetAllPurchase')?>", // json datasource
                type: "post",  // method  , by default get
                error: function(){  // error handling
                    $(".purchase-grid-error").html("");
                    $("#purchase-grid").append('<tbody class="employee-grid-error"><tr><th colspan="5">No data found in the server</th></tr></tbody>');
                    $("#purchase-grid_processing").css("display","none");
 
                }
            }
        } ); 
 });   
</script>