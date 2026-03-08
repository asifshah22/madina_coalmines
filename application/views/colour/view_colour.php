<?php $this->load->view('includes/header'); ?>
<?php $this->load->view('includes/sidebar'); ?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1><i class="fa fa-medkit"></i>&nbsp;Colours</h1>
    </section>
  <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-md-12">
          <!-- Horizontal Form -->
          <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title">View Colour</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form role="form" class="form-horizontal" enctype="multipart/form-data" action='<?php echo base_url("Colour/SaveColour"); ?>' method="post"> 
              <div class="box-body">
                <div class="form-group">
                    <div class="col-xs-12 col-md-12">
                      <?php echo $this->session->flashdata('record_added'); ?>
                    </div>
                  </div>
                    
                          <div class="form-group">
                            <label for="ColourName" class="col-sm-1 control-label">Colour Name:</label>
                            <div class="col-sm-4" style="padding: 7px;">
                              <?php print $GetColourById->ColourName; ?>
                              </div>
                          </div><!-- /.form-group -->

                        
              </div>
              <!-- /.box-body -->
              <div class="box-body">
               <div class="row">
    <div class='col-md-2'>
     <a href="<?php echo base_url(); ?>Colour/AddColour" class="btn btn-block btn-primary">Add Record</a>
    </div>   
               <div class="col-md-2">
               <a href="<?php echo base_url(); ?>Colour/"><button type="button" name="BankToMain" value="BankToMain" class="btn btn-block btn-primary">Back to Main</button></a>
                </div>
               </div>
              </div>
              <!-- /.box-footer -->
            </form>
          </div>
       </div>
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>
<!-- ./wrapper -->
<?php $this->load->view('includes/footer'); ?>