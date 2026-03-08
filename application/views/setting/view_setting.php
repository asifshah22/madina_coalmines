<?php 
    $this->load->view('includes/header');
    $this->load->view('includes/sidebar'); 
   
    $SettingId = $GetSetting->SettingId; 
?>
<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1><i class="fa fa-setting"></i>&nbsp;Setting</h1>
    </section>

  <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-md-12">
          <!-- form elements --> 
          <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title text-light-blue">View Setting</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body no-padding">
            <form role="form" class="form-horizontal" id="Settingform" enctype="multipart/form-data" action='' method="post"> 
              
              <div class="box-body col-md-6">
              
                <div class="form-group">
                  <label for="CompanyName" class="col-sm-4 control-label">Company Name:</label>
                  <div class="col-sm-8">
                      <?php echo $GetSetting->CompanyName; ?>
                  </div>
                </div>

                <div class="form-group">
                  <label for="ContactPerson" class="col-sm-4 control-label">Contact Person:</label>
                  <div class="col-sm-8">
                  <?php echo $GetSetting->ContactPerson; ?>
                  </div>
                </div>

                <div class="form-group">
                  <label for="ContactNumber" class="col-sm-4 control-label">Cell Number:</label>
                  <div class="col-sm-8">
                  <?php echo $GetSetting->ContactNumber; ?>
                  </div>
                </div>

                
                <div class="form-group">
                  <label for="Address" class="col-sm-4 control-label">Home Address:</label>
                  <div class="col-sm-8">
                  <?php echo $GetSetting->Address; ?>
                  </div>
                </div>

        
        </div>

        <div class="box-body col-md-6">
            <div class="form-group">
              <label for="Logo" class="col-sm-4 control-label"></label>
                <img src="<?php echo base_url() ?>images/company-logo/<?php echo $GetSetting->CompanyLogo ?>" class="img-responsive" alt="Image">
            </div>
        </div>
                <div class="box-body">
                  <div class="row">
                    <div class="col-md-2">
                      <!-- <button type="submit" class="btn btn-block btn-primary">Update Record</button> -->
                    </div>   
                  </div>
                </div>
                
              </div>
             
            </form>
            </div>
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

    $('#CompanyName').bind('keyup blur',function(){ 
    var CompanyName = $(this);
    CompanyName.val(CompanyName.val().replace(/[^a-z A-Z" "]/g,'') ); }
  );
    
  })
</script>