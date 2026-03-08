
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1 style="display:inline">Accounts</h1>
       <h1 style="display:inline"><a style="float:right" href="<?php echo base_url(); ?>Accounts/"><i class="fa  fa-hand-o-left"></i><span></span></a><h1>
       
      <?php if($this->session->flashdata('messag_account') != ''){?>
      <div class="alert alert-success" role="alert" >
          <?php echo $this->session->flashdata('messag_account');?>
          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <div>
      <?php }?>
              
          
              
    </section>
  <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-md-12">
          <!-- Horizontal Form -->
          <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title">Bank Information</h3>
            </div>
            <div class="row">
            <div class="box-body">
                
                <div class="col-md-2 col-xs-6" > 
                  Bank Name:
                </div>
                <div  class="col-md-8 col-xs-6"> 
                   <?php echo $GetAccount->BankName;?>
                </div>
            </div>
          </div>
              <!-- single row start  -->
              <div class="row">
            <div class="box-body">
                
                <div class="col-md-2 col-xs-6" > 
                  Account Title:
                </div>
                <div  class="col-md-8 col-xs-6"> 
                   <?php echo $GetAccount->ChartOfAccountsTitle;?>
                </div>
            </div>
                <!-- /.box-body -->
             
              <!-- /.box-footer -->
          </div>
                <!-- single row End -->

                            <!-- single row start  -->
              <div class="row">
            <div class="box-body">
                
                <div class="col-md-2 col-xs-6" > 
                  Account Number:
                </div>
                <div  class="col-md-8 col-xs-6"> 
                   <?php echo $GetAccount->AccountNumber;?>
                </div>
            </div>
          </div>
                <!-- single row End -->

                              <!-- single row start  -->
              <div class="row">
            <div class="box-body">
                
                <div class="col-md-2 col-xs-6" > 
                  Account Title:
                </div>
                <div  class="col-md-8 col-xs-6"> 
                   <?php echo $GetAccount->ChartOfAccountsTitle;?>
                </div>
            </div>
          </div>
                <!-- single row End -->

                              <!-- single row start  -->
              <div class="row">
            <div class="box-body">
                
                <div class="col-md-2 col-xs-6" > 
                  Branch Name:
                </div>
                <div  class="col-md-8 col-xs-6"> 
                   <?php echo $GetAccount->BranchName;?>
                </div>
            </div>
          </div>
                <!-- single row End -->

                              <!-- single row start  -->
              <div class="row">
            <div class="box-body">
                
                <div class="col-md-2 col-xs-6" > 
                  Branch Code:
                </div>
                <div  class="col-md-8 col-xs-6"> 
                   <?php echo $GetAccount->BranchCode;?>
                </div>
            </div>
          </div>
                <!-- single row End -->

                              <!-- single row start  -->
              <div class="row">
            <div class="box-body">
                
                <div class="col-md-2 col-xs-6" > 
                  Contact Person:
                  </div>
                <div  class="col-md-8 col-xs-6"> 
                   <?php echo $GetAccount->ContactPerson;?>
                </div>
            </div>
          </div>
                <!-- single row End -->

                              <!-- single row start  -->
              <div class="row">
            <div class="box-body">
                
                <div class="col-md-2 col-xs-6" > 
                 Address:
                </div>
                <div  class="col-md-8 col-xs-6"> 
                   <?php echo $GetAccount->Address;?>
                </div>
            </div>
          </div>
                <!-- single row End -->

                              <!-- single row start  -->
              <div class="row">
            <div class="box-body">
                
                <div class="col-md-2 col-xs-6" > 
                 ChartOfAccountsTitle:
                </div>
                <div  class="col-md-8 col-xs-6"> 
                   <?php echo $GetAccount->AccountNumber;?>
                </div>
            </div>
          </div>
                <!-- single row End -->

            <div class="box-header with-border">
              <h3 class="box-title">Account Information</h3>
            </div>
            
            <div class="row">
            <div class="box-body">
                
                <div class="col-md-2 col-xs-6" > 
                Catagory Code:
                </div>
                <div  class="col-md-8 col-xs-6"> 
                   <?php echo $GetAccount->CatagoryCode;?>
                </div>
            </div>
                <!-- /.box-body -->
             
              <!-- /.box-footer -->
          </div>
            <div class="row">
            <div class="box-body">
                
                <div class="col-md-2 col-xs-6" > 
                 Control Code:
                </div>
                <div  class="col-md-8 col-xs-6"> 
                   <?php echo $GetAccount->ControllCode;?>
                </div>
            </div>
                <!-- /.box-body -->
             
              <!-- /.box-footer -->
          </div>
        <div class="row">
            <div class="box-body">
                
                <div class="col-md-2 col-xs-6" > 
                 Chart Of Account Title:
                </div>
                <div  class="col-md-8 col-xs-6"> 
                   <?php echo $GetAccount->ChartOfChartOfAccountsTitle;?>
                </div>
            </div>
                <!-- /.box-body -->
             
              <!-- /.box-footer -->
          </div>
         <div class="row">
            <div class="box-body">
                
                <div class="col-md-2 col-xs-6" > 
                 Oppening Balance:
                </div>
                <div  class="col-md-8 col-xs-6"> 
                   <?php echo $GetAccount->OppeningBalance;?>
                </div>
            </div>
                <!-- /.box-body -->
             
              <!-- /.box-footer -->
          </div>
        <div class="row">
            <div class="box-body">
                
                <div class="col-md-2 col-xs-6" > 
                 Status:
                </div>
                <div  class="col-md-8 col-xs-6"> 
                   <?php echo $GetAccount->Status;?>
                </div>
            </div>
                <!-- /.box-body -->
             
              <!-- /.box-footer -->
          </div>
             <div class="row">
            <div class="box-body">
                
                <div class="col-md-2 col-xs-6" > 
                 Oppening Balance Date:
                </div>
                <div  class="col-md-8 col-xs-6"> 
                   <?php echo $GetAccount->OppeningBalanceDate;?>
                </div>
            </div>
                <!-- /.box-body -->
             
              <!-- /.box-footer -->
          </div>

                
            <div class="box-header with-border">
              <h3 class="box-title">Other Information</h3>
            </div>
            
            <div class="row">
            <div class="box-body">
                
                <div class="col-md-2 col-xs-6" > 
                 Notes:
                </div>
                <div  class="col-md-8 col-xs-6"> 
                   <?php echo $GetAccount->Notes;?>
                </div>
            </div>
                <!-- /.box-body -->
             
              <!-- /.box-footer -->
          </div>
            <div class="row">
            <div class="box-body">
                
                <div class="col-md-2 col-xs-6" > 
                  Added On:
                </div>  
                <div  class="col-md-8 col-xs-6"> 
                   <?php echo $GetAccount->AddedOn;?>
                </div>
            </div>
                <!-- /.box-body -->
             
              <!-- /.box-footer -->
          </div>
             <div class="row">
            <div class="box-body">
                
                <div class="col-md-2 col-xs-6" > 
                  Added By:
                </div>  
                <div  class="col-md-8 col-xs-6"> 
                   <?php echo $GetAccount->AddedBy;?>
                </div>
            </div>
                <!-- /.box-body -->
             
              <!-- /.box-footer -->
          </div>
          </div>
          
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
 <script> 


</script>
  <!-- Main Footer -->
  <footer class="main-footer">
    <!-- Default to the left -->
    <strong>Copyright &copy; 2017 <a href="#">Company Name</a>.</strong> All rights reserved.
  </footer>

</div>
<!-- ./wrapper -->