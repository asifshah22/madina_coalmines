<?php 
$this->load->view("includes/header");
$this->load->view("includes/sidebar");
?> 
<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
     <h1 style="display:inline"><i class="fa fa-cube"></i>&nbsp;Accounts</h1>
        <h1 style="display:inline"><a style="float:right" href="<?php echo base_url(); ?>Accounts/"><i class="fa  fa-hand-o-left"></i><span></span></a><h1>
    
    </section>

  <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-md-12">
          <!-- form elements  --> 
          <div id="showresult">
          <div class="box box-info">
           
             <?php $id = $GetAccount->AccountId; ?>
            <!-- /.box-header -->        
            <form role="form" class="form-horizontal" method="post" id="accountform" action='<?php echo site_url("Accounts/UpdateAccount/$id")?>'> 
  <!--          <form role="form" class="form-horizontal" id="userform" enctype="multipart/form-data" action="<?php // echo base_url(); ?>/Category/SaveCategory" method="post">--> 
              
                <div class="box-header with-border">
              <h3 class="box-title">Edit Bank Information</h3>
            </div>
              <div class="box-body" id="bankDropDown">
              </div>
                
               <div class="box-body">
                <div class="form-group">
                  <label for="ChartOfAccountsTitle" class="col-sm-1 control-label">Account Title:</label>
                   <div class="col-sm-5">
                       <input type="text" class="form-control" name="ChartOfAccountsTitle" id="ChartOfAccountsTitle" value="<?php echo $GetAccount->ChartOfAccountsTitle; ?>" >
                  </div>
                </div>
              </div> 
           
                
                    <div class="box-body">
                <div class="form-group">
                  <label for="AccountNumber" class="col-sm-1 control-label">Account Number:</label>
                   <div class="col-sm-5">
                  <input type="text" class="form-control" name="AccountNumber" id="AccountNumber" value="<?php echo $GetAccount->AccountNumber; ?>">
                  </div>
                </div>
              </div> 
           
                
                    <div class="box-body">
                <div class="form-group">
                  <label for="BranchName" class="col-sm-1 control-label">Branch Name:</label>
                   <div class="col-sm-5">
                  <input type="text" class="form-control" name="BranchName" id="BranchName" value="<?php echo $GetAccount->BranchName; ?>">
                  </div>
                </div>
              </div> 
           
                
                    <div class="box-body">
                <div class="form-group">
                  <label for="BranchCode" class="col-sm-1 control-label">Branch Code:</label>
                   <div class="col-sm-5">
                  <input type="text" class="form-control" name="BranchCode" id="BranchCode" value="<?php echo $GetAccount->BranchCode; ?>">
                  </div>
                </div>
              </div> 
           
                
                    <div class="box-body">
                <div class="form-group">
                  <label for="ContactPerson" class="col-sm-1 control-label">Contact Person:</label>
                   <div class="col-sm-5">
                  <input type="text" class="form-control" name="ContactPerson" id="ContactPerson" value="<?php echo $GetAccount->ContactPerson; ?>">
                  </div>
                </div>
              </div> 
           
                
                <div class="box-body">
                <div class="form-group">
                  <label for="Address" class="col-sm-1 control-label">Address:</label>
                   <div class="col-sm-5">
                  <input type="text" class="form-control" name="Address" id="Address" value="<?php echo $GetAccount->Address; ?>">
                  </div>
                </div>
              </div> 
           
               <div class="box-body">
                <div class="form-group">
                  <label for="PhoneNumber" class="col-sm-1 control-label">Phone Number:</label>
                   <div class="col-sm-5">
                  <input type="text" class="form-control" name="PhoneNumber" id="PhoneNumber" value="<?php echo $GetAccount->PhoneNumber; ?>">
                  </div>
                </div>
              </div> 
           
                
                
                <div class="box-body">
                <div class="form-group">
                  <label for="Status" class="col-sm-1 control-label">Status:</label>
                   <div class="col-sm-5">
                  <input type="text" class="form-control" name="Status" id="Status" value="<?php echo $GetAccount->Status; ?>">
                  </div>
                </div>
              </div> 
           
                 <div class="box-header with-border">
              <h3 class="box-title">Edit Account Information</h3>
            </div>
                
                
               <div class="box-body">
                <div class="form-group">
                  <label for="CatagoryCode" class="col-sm-1 control-label">Catagory Code:</label>
                   <div class="col-sm-5">
                  <input type="text" class="form-control" name="CatagoryCode" id="CatagoryCode" value="<?php echo $GetAccount->CatagoryCode; ?>">
                  </div>
                </div>
              </div> 
                
                    <div class="box-body">
                <div class="form-group">
                  <label for="Address" class="col-sm-1 control-label">Address:</label>
                   <div class="col-sm-5">
                  <input type="text" class="form-control" name="Address" id="Address" value="<?php echo $GetAccount->Address; ?>">
                  </div>
                </div>
              </div> 
           
                    <div class="box-body">
                <div class="form-group">
                  <label for="ControllCode" class="col-sm-1 control-label"> Control Code:</label>
                   <div class="col-sm-5">
                  <input type="text" class="form-control" name="ControllCode" id="ControllCode" value="<?php echo $GetAccount->ControllCode; ?>">
                  </div>
                </div>
              </div> 
           
                    <div class="box-body">
                <div class="form-group">
                  <label for="ChartOfAccount" class="col-sm-1 control-label">Chart Of Account:</label>
                   <div class="col-sm-5">
                  <input type="text" class="form-control" name="ChartOfAccount" id="ChartOfAccount" value="<?php echo $GetAccount->ChartOfAccount; ?>">
                  </div>
                </div>
              </div> 
           
                    <div class="box-body">
                <div class="form-group">
                  <label for="ChartOfChartOfAccountsTitle" class="col-sm-1 control-label">Chart Of Account Title:</label>
                   <div class="col-sm-5">
                  <input type="text" class="form-control" name="ChartOfChartOfAccountsTitle" id="ChartOfChartOfAccountsTitle" value="<?php echo $GetAccount->ChartOfChartOfAccountsTitle; ?>">
                  </div>
                </div>
              </div> 
           
                    <div class="box-body">
                <div class="form-group">
                  <label for="OppeningBalance" class="col-sm-1 control-label">Oppening Balance:</label>
                   <div class="col-sm-5">
                  <input type="text" class="form-control" name="OppeningBalance" id="OppeningBalance" value="<?php echo $GetAccount->OppeningBalance; ?>">
                  </div>
                </div>
              </div> 
           
                    <div class="box-body">
                <div class="form-group">
                  <label for="OppeningBalanceDate" class="col-sm-1 control-label">Oppening Balance Date:</label>
                   <div class="col-sm-5">
                  <input type="text" class="form-control" name="OppeningBalanceDate" id="OppeningBalanceDate" value="<?php echo $GetAccount->OppeningBalanceDate; ?>">
                  </div>
                </div>
              </div> 
           
                
                 <div class="box-header with-border">
              <h3 class="box-title">Edit Other Information</h3>
            </div>
                     
               <div class="box-body">
                <div class="form-group">
                  <label for="Notes" class="col-sm-1 control-label">Notes:</label>
                   <div class="col-sm-5">
                  <input type="text" class="form-control" name="Notes" id="Notes" value="<?php echo $GetAccount->Notes; ?>">
                  </div>
                </div>
              </div> 
           
               <div class="box-body">
                <div class="form-group">
                  <label for="AccountAddress" class="col-sm-1 control-label">Added ON:</label>
                   <div class="col-sm-5">
                  <?php echo $GetAccount->AddedOn; ?>
                  </div>
                </div>
              </div> 
           <div class="box-body">
                <div class="form-group">
                  <label for="AccountAddress" class="col-sm-1 control-label">Added By:</label>
                   <div class="col-sm-5">
                 <?php echo $GetAccount->AddedBy; ?>
                  </div>
                </div>
              </div> 
            
            
              <!-- /.box-body -->
			   <div class="box-footer">
                <button type="submit" class="btn btn-primary">Update</button>
              </div>
            </form>
          </div>
          <!-- /.box -->
          </div>
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
   
    
          <!-- model box-->   
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      
        <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="exampleModalLabel">Banks</h4>
        <p id="showBankMesg"><p>
      </div>
      
        <div class="modal-body"  id="showBanks">
        </div>
      
        <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button id="submit" type="button" class="btn btn-primary">Submit</button>
      </div>
    </div>
  </div>
</div>
 <!-- model box -->   
    

      
    </section>
    <!-- /.content -->
    	
    
  </div>
  <!-- /.content-wrapper -->

<script>

 $('#userform').submit(function(e){  
    e.preventDefault(); // Prevent Default Submission
  
  $.ajax({
  url: '<?php echo site_url('Category/SaveCategory'); ?>',
  type: 'POST',
  data: $(this).serialize(), // it will serialize the form data
  dataType: 'html'
    })
    .done(function(data){
     $('#showresult').fadeOut('slow', function(){
          $('#showresult').fadeIn('slow').html(data);
        });
    })
    .fail(function(){
  alert('Ajax Submit Failed ...'); 
    });
 });
  </script>
  
    <script>
  $(function(){

 //load bank drop down
    $('#bankDropDown').load('<?php echo base_url("Accounts/BankDropDown")?>',{id:<?php echo $GetAccount->AccountId; ?>})
   // get bank though ajax set value of modul box
   $(document).on('click','#addBank',function(){
           $('#showBankMesg').text('')
        $.ajax({
                url:"<?php echo base_url('Accounts/Banks')?>",
                type:'post',
                success:function(data){
                    $('#showBanks').html(data)
                }
               
            });
   });
      
  // show modul box    
  $(document).on('show.bs.modal','#exampleModal', function (event) {
  var button = $(event.relatedTarget) // Button that triggered the modal
  var recipient = button.data('whatever') 
  var modal = $(this)
  modal.find('.modal-title').text('Banks')
  //modal.find('.modal-body input').val(recipient)
})
    // add new bank 
    $(document).on('click','#submit',function(){
        var BankName = $('#NewBankName').val();
        if(BankName == '')
        {
            alert("Please Fill Empty Fields..")
            return
        }    
        var BankAbb = $('#NewBankAbb').val();
            $.ajax({
                url:"<?php echo base_url('Accounts/AddBank')?>",
                type:'post',
                data:{BName:BankName,BAbb:BankAbb},
                success:function(data){
                   
                   $('#showBanks').load('<?php echo base_url("Accounts/Banks")?>')
                   $('#showBankMesg').text('Bank added Successfuly...!')
                   $('#bankDropDown').load('<?php echo base_url("Accounts/BankDropDown")?>',{id:<?php echo $GetAccount->AccountId; ?>})
                   
                   
                }
               
            });
          
      });
 
 
 //update bank
    $(document).on('click','span[id^=BankEdit]',function(){
             var arr= $(this).attr('id').split("_");
             var BankName = $("#BankName_"+arr[1]).val();
             var BankAbb = $("#BankAbb_"+arr[1]).val();
               $.ajax({
                url:"<?php echo base_url('Accounts/UpdateBank')?>",
                type:'post',
                data:{BName:BankName,BAbb:BankAbb,BId:arr[1]},
                success:function(data){
                    if(data=='success')
                    {
                        $('#showBanks').load('<?php echo base_url("Accounts/Banks")?>')
                        $('#showBankMesg').text('Bank Updated Successfuly...!')
                        $('#bankDropDown').load('<?php echo base_url("Accounts/BankDropDown")?>',{id:<?php echo $GetAccount->AccountId; ?>})
                       
                    }
                }
            });
    });
 
 
 //update bank status
    $(document).on('click','span[id^=BankStatus]',function(){
            var arr= $(this).attr('id').split("_");
                  $.ajax({
                url:"<?php echo base_url('Accounts/UpdateBank')?>",
                type:'post',
                data:{BId:arr[1]},
                success:function(data){
                    console.log(data);
                    if(data=='success')
                    {
                        $('#showBanks').load('<?php echo base_url("Accounts/Banks")?>')
                        $('#showBankMesg').text('Bank Updated Successfuly...!')
                        $('#bankDropDown').load('<?php echo base_url("Accounts/BankDropDown")?>',{id:<?php echo $GetAccount->AccountId; ?>})
                        setTimeout(pauseScript, 200)
                    }
                }
            });
    });
 // Make bank drop down selected
 
    //console.log($('#BankId').attr('id'));
   
 });
  </script>

  
  
  <!-- Main Footer -->
  <footer class="main-footer">
    <!-- To the right -->
    <div class="pull-right hidden-xs">
      Anything you want
    </div>
    <!-- Default to the left -->
    <strong>Copyright &copy; 2017 <a href="#">Company Name</a>.</strong> All rights reserved.
  </footer>
</div>
<!-- ./wrapper -->
<?php $this->load->view("includes/footer"); ?> 