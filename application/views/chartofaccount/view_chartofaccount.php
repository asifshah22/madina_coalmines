<?php 
$this->load->view("includes/header");
$this->load->view("includes/sidebar");
?>
<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
     <h1><i class="fa fa-cube"></i>&nbsp;Chart Of Accounts</h1>
    </section>

  <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-md-12">
          <!-- form elements  --> 
          <div id="showresult">
          <div class="box box-info">
          
                        
           <?php //print_r($GetChartOfAccount) ?>
         
            <!-- /.box-header -->        
  <!--          <form role="form" class="form-horizontal" id="userform" enctype="multipart/form-data" action="<?php // echo base_url(); ?>/Category/SaveCategory" method="post">--> 
           
            <div class="box-header with-border">
              <h3 class="box-title">View Chart of Account</h3>
            </div>

               <div class="box-body" >
                   <div class="form-group">
                  <label for="CategoryCode" class="col-sm-1 control-label">Category Code:</label>
                   <?php echo $GetChartOfAccount->CategoryCode.'-'. $GetChartOfAccount->CategoryName; ?>
                </div>
              </div> 
                
               <div class="box-body" >
                   
                   <div class="form-group">
                  <label for="ControlCode" class="col-sm-1 control-label">Control Code:</label>
                   <?php echo $GetChartOfAccount->ControlCode.'-'.$GetChartOfAccount->ControlName; ?>
                </div>
              </div> 
           
                
                   
                <!--
                <div class="box-body">
                <div class="form-group">
                  <label for="ParentChartofAccount" class="col-sm-1 control-label">Parent Chart of Account:</label>
                   <div class="col-sm-4">
                  <input type="text" class="form-control" name="ParentChartofAccount" id="ParentChartofAccount" >
                  </div>
                </div>
              </div> 
                -->
                
                    <div class="box-body">
                <div class="form-group">
                  <label for="ChartOfAccountCode" class="col-sm-1 control-label">Chart of Accounts Code:</label>
                   <div class="col-sm-4">
                      <?php echo $GetChartOfAccount->ChartOfAccountCode; ?>                  </div>
                </div>
              </div> 
           
                
                    <div class="box-body">
                <div class="form-group">
                  <label for="ChartOfAccountTitle" class="col-sm-1 control-label">Account Title:</label>
                   <div class="col-sm-4">
                    <?php echo $GetChartOfAccount->ChartOfAccountTitle; ?>
                   </div>
                </div>
              </div> 
           
               <div class="box-body">
                <div class="form-group">
                  <label for="Notes" class="col-sm-1 control-label">Notes:</label>
                   <div class="col-sm-4">
                    <?php echo $GetChartOfAccount->Notes; ?>
                   </div>
                </div>
              </div> 
           
            
              <!-- /.box-body -->

			   <div class="box-footer">
          <div class="col-sm-2">
            <a class="btn btn-block btn-primary" href="<?php echo base_url() ?>ChartOfAccount/AddChartOfAccount" role="button">Add Record</a>
          </div>
          <div class="col-sm-2">
            <?php echo anchor("ChartOfAccount/","Back to Main",array("class"=>"btn btn-block btn-primary"))?>
                 </div>
               </div>
          </div>
          <!-- /.box -->
          </div>
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->

  

  <!-- Main content -->
   
     
   
  </section>
    <!-- /.content -->
    	
    
  </div>
  <!-- /.content-wrapper -->

</div>
<!-- ./wrapper -->
<?php $this->load->view("includes/footer"); ?>