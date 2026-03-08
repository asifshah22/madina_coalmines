<?php 
$this->load->view("includes/header");
$this->load->view("includes/sidebar");

?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
       <h1 style="display:inline"><i class="fa fa-bank"></i>&nbsp;Bank Account</h1>
    </section>
  <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-md-12">
          <!-- Horizontal Form -->
          <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title text-light-blue">View Bank Account</h3>
            </div>

	  <div class="row">
            <div class="box-body">      
                <div class="col-md-2 col-xs-6" > 
                  Bank Name:
                </div>
                <div  class="col-md-8 col-xs-6"> 
                  <?php echo $GetAccount->BankName; ?>
                </div>
            </div>
          </div>
          <div class="row">
            <div class="box-body">
                
                <div class="col-md-2 col-xs-6" > 
                  Account Title:
                </div>
                <div  class="col-md-8 col-xs-6"> 
                   <?php echo $GetAccount->AccountTitle; ?>
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
                <div class="col-md-8 col-xs-6"> 
                   <?php echo $GetAccount->AccountNumber;?>
                </div>
            </div>
          </div>

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

          <div class="row">
            <div class="box-body">
                <div class="col-md-2 col-xs-6" > 
                  Branch Number:
                </div>
                <div  class="col-md-8 col-xs-6"> 
                   <?php echo $GetAccount->BranchNumber;?>
                </div>
            </div>
          </div>

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

              <div class="row">
            <div class="box-body">
                <div class="col-md-2 col-xs-6" > 
                 Phone Number:
                </div>
                <div  class="col-md-8 col-xs-6"> 
                   <?php echo $GetAccount->PhoneNumber;?>
                </div>
            </div>
          </div>

              <div class="row">
            <div class="box-body">
                <div class="col-md-2 col-xs-6" > 
                 Opening Balance:
                </div>
                <div  class="col-md-8 col-xs-6"> 
                   <?php echo $GetAccount->OppeningBalance;?>
                </div>
            </div>
          </div>

              <div class="row">
            <div class="box-body">
                <div class="col-md-2 col-xs-6" > 
                 Opening Balance Date:
                </div>
                <div  class="col-md-8 col-xs-6"> 
                   <?php echo date("M d, Y", strtotime($GetAccount->OppeningBalanceDate));?>
                </div>
            </div>
          </div>

            <div class="box-header with-border">
              <h3 class="box-title">Chart of Account Information</h3>
            </div>
            
           
        <div class="row">
             <div class="box-body">
                <div class="col-md-2 col-xs-6" > 
                 Chart Of Account Code:
                </div>
                <div  class="col-md-8 col-xs-6"> 
                   <?php echo $GetAccount->ChartOfAccountCode;?>
                </div>
            </div>
                <!-- /.box-body -->
          <div class="box-body">
                <div class="col-md-2 col-xs-6" > 
                 Chart Of Account Title:
                </div>
                <div  class="col-md-8 col-xs-6"> 
                   <?php echo $GetAccount->ChartOfAccountTitle;?>
                </div>
              
            </div>
                <!-- /.box-body -->
            
              <!-- /.box-footer -->
          </div>

 <div class="box-footer">
                <div class="col-sm-2">
                  <a class="btn btn-block btn-primary" href="<?php echo base_url(); ?>BankAccount/AddAccount" role="button">Add Record</a>
                </div>
                <div class="col-sm-2">
                  <a class="btn btn-block btn-primary" href="<?php echo base_url() ?>BankAccount" role="button">Back to Main</a>
                </div>
              </div>
          
         <div class="row">
             
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
<?php $this->load->view("includes/footer"); ?>