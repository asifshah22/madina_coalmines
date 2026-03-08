<?php 
    $this->load->view('includes/header');
    $this->load->view('includes/sidebar'); 
?>
<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
     <h1><i class="fa fa-cube"></i>&nbsp;Category</h1>
    </section>

  <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-md-12">
          <!-- form elements  --> 
          <div id="showresult">
          <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title">Edit Category</h3>
            </div>
            <!-- /.box-header -->        
            <form role="form" class="form-horizontal" action='<?php echo base_url("Category/SaveCategory/$GetCategoryById->CategoryId") ?>' method="post" id="userform"> 
              <div class="box-body">
                <div class="form-group">
                  <label for="CategoryName" class="col-sm-1 control-label">Category Name:</label>
                   <div class="col-sm-4">
                       <input type="text" class="form-control" name="CategoryName" value="<?php echo $GetCategoryById->CategoryName;?>" required="required">
                  </div>
                </div>
              </div>
              <!-- /.box-body -->
              <div class="box-body">
               <div class="row">
		<div class='col-md-2'>
		   <button type='submit' class='btn  btn-block btn-primary bg-primary' value='UpdateCategory' name=''>Update Record</button>
		  </div>   
                <div class="col-md-2">
                   <a href="<?php echo base_url(); ?>Category/"><button type="button" name="BankToMain" value="BankToMain" class="btn btn-block btn-primary">Back to Main</button></a>
                </div>
               </div>
              </div>
            </form>
          </div>
          <!-- /.box -->
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