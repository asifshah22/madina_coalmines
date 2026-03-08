<?php $this->load->view('admin/includes/header'); ?>
<?php $this->load->view('admin/includes/sidebar'); ?>

      <!-- /.main-content starts -->
      <div class="main-content">
        <div class="main-content-inner">

          <div class="breadcrumbs ace-save-state" id="breadcrumbs">
            <ul class="breadcrumb">
              <li>
                <i class="ace-icon fa fa-home home-icon"></i>
                <a href="#">Home</a>
              </li>
              <li class="active">Setting</li>
            </ul><!-- /.breadcrumb -->

            <div class="nav-search" id="nav-search">
              <form class="form-search">
                <span class="input-icon">
                  <!-- <input type="text" placeholder="Search ..." class="nav-search-input" id="nav-search-input" autocomplete="off" />
                  <i class="ace-icon fa fa-search nav-search-icon"></i> -->
                </span>
              </form>
            </div><!-- /.nav-search -->
          </div>

          <div class="page-content">  
          <!-- /.row  <starts-->
            <div class="row">
                        
                        <div class="form-group">
                <div class="col-xs-12 col-md-12">
                <?php echo $this->session->flashdata('record_message'); ?>
                          </div>
                        </div>

              <div class="col-xs-12">
                <!-- PAGE CONTENT BEGINS -->
                <div class="row">
                  <div class="col-xs-12">
                    <div class="clearfix">
                      <div class="pull-right tableTools-container"></div>
                    </div>
                    <div class="table-header">
                      Settings
                    </div>
                    <table id="internship-grid"  class="table table-bordered table-striped"  cellpadding="0" cellspacing="0" border="0" class="display" width="100%" >
                      <thead>
                        <tr>
                        <th>Company Name</th>
                        <th>Component Name</th>
			<th>Transaction Type</th>
			<th>Chart Of Account Title</th>
			<th>Control Name</th>
			<th>Action</th>
                        </tr>
                      </thead>
                    </table>
                  <div class="space-4"></div>
                  <div class="col-sm-2"><a href="<?= base_url(); ?>Setting/AddSetting" class="btn btn-primary">Add New Record</a></div>
                  </div><!-- /.span -->
                </div><!-- /.row -->
                </div><!-- /.page-content -->
      </div>
  </div>
    <!-- /.main-content ends -->
<?php $this->load->view('admin/includes/footer'); ?>

  <script>
 $(function(){
     var dataTable = $('#internship-grid').DataTable( {
            'aoColumnDefs': [{
            'bSortable': false,
            'aTargets': [-1] /* 1st one, start by the right */
            }],  
            "processing": true,
            "serverSide": true,
            "ajax":{
                url :"<?php echo base_url('Setting/Ajax_GetAllSettings')?>", // json datasource
                type: "post",  // method  , by default get
                error: function(){  // error handling
                    $(".internship-grid-error").html("");
                    $("#internship-grid").append('<tbody class="employee-grid-error"><tr><th colspan="5">No data found in the server</th></tr></tbody>');
                    $("#internship-grid_processing").css("display","none");
 
                }
            }
        } ); 
 });   
</script>