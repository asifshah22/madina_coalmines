<?php $this->load->view('includes/header'); ?>
<?php $this->load->view('includes/sidebar'); ?>
<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1><i class="fa fa-user"></i>&nbsp;Company</h1>
    </section>
  <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-md-12">
           
          <div class="box box-info">
            <div class="box-header">
<!--              <h3 class="box-title">Total Records (<?php // print count($GetAllCompany); ?>)</h3> -->
           
            </div>
            <!-- /.box-header -->
            <div class="box-body ">
               <?php echo "<font style=color:#00468E; font-weight:bold text-align:center;>".$this->session->flashdata('record_added')."</font>"; ?>
                  <table id="companies-grid" class="table table-striped" class="table table-bordered table-striped"  cellpadding="0" cellspacing="0" border="0" class="display" width="100%">
                      <thead>
                        <tr>
                          <th>Company Name</th>
                          <th>Address</th>
                          <th>NTN</th>
                          <th>Fax No</th>
                          <th>Website</th>
                          <th>Comapny Warranty</th>
                          <th>Action</th>
                        </tr>
                      </thead>

                    </table>
                <?php if ($AdministrationRoles[6]['AddRoles']==1) { ?> 
              <div class="box-footer col-md-2 col-sm-4 col-xs-6">
                <a href="<?php echo base_url(); ?>Company/AddCompany" class="btn btn-primary">Add Record</a>
              </div>
              <?php } ?>
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
<?php $this->load->view('includes/footer'); ?>

<script type="text/javascript">

  $(function(){

          // company table
        var dataTable = $('#companies-grid').DataTable( {
            'aoColumnDefs': [{
            'bSortable': false,
            'aTargets': [-1] /* 1st one, start by the right */
            }],
            'order': [[ 0, "desc" ]],
            "processing": true,
            "serverSide": true,
            "ajax":{
                url :"<?php echo base_url('Company/Ajax_GetAllCompanies') ?>", // json datasource
                type: "post",  // method  , by default get
                 error: function(){  // error handling
                    $(".companies-grid-error").html("");
                    $("#companies-grid").append('<tbody class="company-grid-error"><tr><th colspan="6">No data found in the server</th></tr></tbody>');
                    $("#companies-grid_processing").css("display","none");
                }
            }
        });
  })

</script>