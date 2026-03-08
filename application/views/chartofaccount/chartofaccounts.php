<?php 
$this->load->view("includes/header");
$this->load->view("includes/sidebar");
?>
<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1><i class="fa fa-cube"></i>Chart Of Accounts</h1>
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
            <!--  <h3 class="box-title">Total Records (<?php // print count($GetAllChartOfAccounts); ?>)</h3> -->
            </div>
            <!-- /.box-header -->
            <div class="box-body">
            <?php echo "<font style=color:#00468E; font-weight:bold text-align:center;>".$this->session->flashdata('record_added')."</font>"; ?>
              <table id="COA-grid" class="table table-striped" class="table table-bordered table-striped"  cellpadding="0" cellspacing="0" border="0" class="display" width="100%" >
                  <thead>
                  <tr>
                  <th>Category Code</th>
                  <th>Control Code</th>
                  <th>COA_Code</th>
                  <th>COA_Title</th>
                  <th >Actions</th>
                </tr>
                </thead>
              </tbody>
              </table>
              <?php // if ($RegistrationRoles[0]['AddRoles']==1) { ?>
              <div class="box-footer col-md-2 col-sm-4 col-xs-6">
                 <a href="<?php echo site_url(); ?>ChartOfAccount/AddChartOfaccount" class="btn btn-primary">Add Record</a>
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
<?php $this->load->view("includes/footer"); ?>

<script type="text/javascript">
  $(function () {

            //Chart Of Accounts
        var dataTable = $('#COA-grid').DataTable( {
            'aoColumnDefs': [{
            'bSortable': false,
            'aTargets': [-1] /* 1st one, start by the right */
            }],
            'order': [[ 0, "desc" ]],
            "processing": true,
            "serverSide": true,
            "ajax":{
                url :"<?php echo base_url('ChartOfAccount/Ajax_GetAllChartOfAccount') ?>", // json datasource
                type: "post",  // method  , by default get
                 error: function(){  // error handling
                    $(".COA-grid-error").html("");
                    $("#COA-grid").append('<tbody class="employee-grid-error"><tr><th colspan="3">No data found in the server</th></tr></tbody>');
                    $("#COA-grid_processing").css("display","none");
                }  
            }
        } );

  })
</script>
