<?php $this->load->view('includes/header'); ?>
<?php $this->load->view('includes/sidebar'); ?>

<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
  <h1><i class="fa fa-building"></i>&nbsp;Colours</h1>
    </section>
  <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-md-12">
           
          <div class="box box-info">
            <div class="box-header">
            </div>
            <!-- /.box-header -->
            <div class="box-body ">
               <?php echo "<font style=color:#00468E; font-weight:bold text-align:center;>".$this->session->flashdata('record_added')."</font>"; ?>
              <table id="color-grid" class="table table-striped" class="table table-bordered table-striped"  cellpadding="0" cellspacing="0" border="0" class="display" width="100%">
               <thead>
               <tr>

                          <th>Colour Name</th>
                          <th>Action</th>
                        </tr>
                      </thead>

                    </table>
                  <div class="space-4"></div>
                  <div class="col-sm-2"><a href="<?= base_url(); ?>Colour/AddColour" class="btn btn-primary">Add Record</a></div>
                  </div><!-- /.span -->
                </div><!-- /.row -->
                </div><!-- /.page-content -->
      </div>
  </div>
    <!-- /.main-content ends -->
<?php $this->load->view('includes/footer'); ?>

  <script>
 $(function(){
     var dataTable = $('#color-grid').DataTable( {
            'aoColumnDefs': [{
            'bSortable': false,
            'aTargets': [-1] /* 1st one, start by the right */
            }],  
            "processing": true,
            "serverSide": true,
            "ajax":{
                url :"<?php echo base_url('Colour/Ajax_GetAllColours')?>", // json datasource
                type: "post",  // method  , by default get
                error: function(){  // error handling
                    $(".color-grid-error").html("");
                    $("#color-grid").append('<tbody class="employee-grid-error"><tr><th colspan="2">No data found in the server</th></tr></tbody>');
                    $("#color-grid_processing").css("display","none");
 
                }
            }
        } ); 
 });   
</script>