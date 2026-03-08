<?php 
$this->load->view("includes/header");
$this->load->view("includes/sidebar");
?>
<script src="<?=site_url();?>/lib/js/autocompletejs/jquery-ui.js"></script>
<link rel="stylesheet" href="<?=site_url();?>/lib/css/autocompletecss/jquery-ui.css" />   
<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
     <h1 style="display:inline"><i class="fa fa-bank"></i>&nbsp; Bank Account</h1>
        <h1 style="display:inline"><a style="float:right" href="<?php echo base_url(); ?>BankAccount/"><i class="fa  fa-hand-o-left"></i><span></span></a><h1>
    
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
            <form role="form" class="form-horizontal" method="post" id="accountform" action='<?php echo site_url("BankAccount/UpdateAccount/$id")?>'> 
           
              <div class="box-header with-border">
		<h3 class="box-title text-light-blue">Update Bank Acount</h3>
	      </div>
              <!--<div class="box-body" id="bankDropDown">
              </div>-->
	      
	      <div class="box-body">
                <div class="form-group">
                  <label for="AccountTitle" class="col-sm-1 control-label">Account Title:</label>
                   <div class="col-sm-4">
                       <input type="text" class="form-control" name="AccountTitle" id="AccountTitle" value="<?php echo $GetAccount->ChartOfAccountTitle; ?>" >
		   </div>
                </div>
              </div>             
              <div class="box-body">
                <div class="form-group">
                  <label for="AccountNumber" class="col-sm-1 control-label">Account Number:</label>
                   <div class="col-sm-4">
                  <input type="text" class="form-control" name="AccountNumber" id="AccountNumber" value="<?php echo $GetAccount->AccountNumber; ?>">
                  </div>
                </div>
              </div> 
              <div class="box-body">
                <div class="form-group">
                  <label for="BranchName" class="col-sm-1 control-label">Branch Name:</label>
                   <div class="col-sm-4">
                  <input type="text" class="form-control" name="BranchName" id="BranchName" value="<?php echo $GetAccount->BranchName; ?>">
                  </div>
                </div>
              </div> 
              <div class="box-body">
                <div class="form-group">
                  <label for="BranchCode" class="col-sm-1 control-label">Branch Code:</label>
                   <div class="col-sm-4">
                  <input type="text" class="form-control" name="BranchCode" id="BranchCode" value="<?php echo $GetAccount->BranchCode; ?>">
                  </div>
                </div>
              </div> 
               <div class="box-body">
                <div class="form-group">
                  <label for="BranchName" class="col-sm-1 control-label">Branch Number:</label>
                   <div class="col-sm-4">
                  <input type="text" class="form-control" name="BranchNumber" id="BranchNumber" value="<?php echo $GetAccount->BranchNumber; ?>">
                  </div>
                </div>
              </div> 
	      <div class="box-body">
                <div class="form-group">
                  <label for="ContactPerson" class="col-sm-1 control-label">Contact Person:</label>
                   <div class="col-sm-4">
                  <input type="text" class="form-control" name="ContactPerson" id="ContactPerson" value="<?php echo $GetAccount->ContactPerson; ?>">
                  </div>
                </div>
              </div> 
              
              <div class="box-body">
                <div class="form-group">
                  <label for="Address" class="col-sm-1 control-label">Address:</label>
                   <div class="col-sm-4">
                  <input type="text" class="form-control" name="Address" id="Address" value="<?php echo $GetAccount->Address; ?>">
                  </div>
                </div>
              </div> 
              
              <div class="box-body">
                <div class="form-group">
                  <label for="PhoneNumber" class="col-sm-1 control-label">Phone Number:</label>
                   <div class="col-sm-4">
                  <input type="text" class="form-control" name="PhoneNumber" id="PhoneNumber" value="<?php echo $GetAccount->PhoneNumber; ?>">
                  </div>
                </div>
              </div> 

              <div class="box-body">
                <div class="form-group">
                  <label for="OppeningBalance" class="col-sm-1 control-label">Opening Balance:</label>
                   <div class="col-sm-4">
                  <input type="text" class="form-control" name="OppeningBalance" id="OppeningBalance" value="<?php echo $GetAccount->OppeningBalance; ?>">
                  </div>
                </div>
              </div> 
              
              <div class="box-body">
                <div class="form-group">
                  <label for="OppeningBalanceDate" class="col-sm-1 control-label">Opening Balance Date:</label>
                   <div class="col-sm-4">
                  <input type="text" class="form-control" id="datepicker1" name="OppeningBalanceDate" id="OppeningBalanceDate" value="<?php echo date("m/d/Y", strtotime($GetAccount->OppeningBalanceDate)); ?>">
                  </div>
                </div>
              </div> 
             <!--
                <div class="box-body">
                <div class="form-group">
                  <label for="Status" class="col-sm-1 control-label">Status:</label>
                   <div class="col-sm-4">
                  <input type="text" class="form-control" name="Status" id="Status" value="<?php // echo $GetAccount->Status; ?>">
                  </div>
                </div>
              </div>--> 
           
                 <div class="box-header with-border">
              <h3 class="box-title">Chart of Account Information</h3>
            </div>
                
                
             <div class="box-body">
                <div class="form-group">
                  <label for="ChartOfAccount" class="col-sm-1 control-label">Chart Of Account Code:</label>
                   <div class="col-sm-4">
                       <input type="text" class="form-control" id="ChartOfAccountId" value="<?php echo $GetAccount->ChartOfAccountCode; ?>" readonly="readonly">
                       <input type="hidden" id="hdnChartOfAccount" name="ChartOfAccountId" value="<?php echo $GetAccount->ChartOfAccountId?>">
                       <input type="hidden" id="hdnChartOfAccountControlId" name="ChartOfAccountControlId" value="<?php echo $GetAccount->ChartOfAccountControlId?>">
                  </div>
                </div>
              </div> 

              <div class="box-body">
                <div class="form-group">
                  <label for="ChartOfAccount" class="col-sm-1 control-label">Chart Of Account Title:</label>
                   <div class="col-sm-4">
                     <input type="text" class="form-control" name="ChartOfAccountTitle" id="ChartOfAccountTitle" value="<?php echo $GetAccount->ChartOfAccountTitle;?>" required="required" readonly="readonly">
                  </div>
                </div>
              </div>
                
               <!--   
                    <div class="box-body">
                <div class="form-group">
                  <label for="OppeningBalance" class="col-sm-1 control-label">Oppening Balance:</label>
                   <div class="col-sm-4">
                  <input type="text" class="form-control" name="OppeningBalance" id="OppeningBalance" value="<?php // echo $GetAccount->OppeningBalance; ?>">
                  </div>
                </div>
              </div>
           
                    <div class="box-body">
                <div class="form-group">
                  <label for="OppeningBalanceDate" class="col-sm-1 control-label">Oppening Balance Date:</label>
                   <div class="col-sm-4">
                  <input type="text" class="form-control" name="OppeningBalanceDate" id="OppeningBalanceDate" value="<?php  // echo $GetAccount->OppeningBalanceDate; ?>">
                  </div>
                </div>
              </div> 
            
                
                 <div class="box-header with-border">
              <h3 class="box-title">Edit Other Information</h3>
            </div>
                     
               <div class="box-body">
                <div class="form-group">
                  <label for="Notes" class="col-sm-1 control-label">Notes:</label>
                   <div class="col-sm-4">
                  <input type="text" class="form-control" name="Notes" id="Notes" value="<?php // echo $GetAccount->Notes; ?>">
                  </div>
                </div>
              </div> 
           
               <div class="box-body">
                <div class="form-group">
                  <label for="AccountAddress" class="col-sm-1 control-label">Added ON:</label>
                   <div class="col-sm-4">
                  <?php // echo $GetAccount->AddedOn; ?>
                  </div>
                </div>
              </div> 
           <div class="box-body">
                <div class="form-group">
                  <label for="AccountAddress" class="col-sm-1 control-label">Added By:</label>
                   <div class="col-sm-4">
                 <?php // echo $GetAccount->AddedBy; ?>
                  </div>
                </div>
              </div> 
            -->
        	<div class="box-body">
		  <div class="row">
		    <div class='col-md-2'>
		     <button type='submit' class='btn  btn-block btn-primary bg-primary' value='UpdateRecordWithOutTransaction'>Update Record</button>
		    </div>   
                  <div class="col-md-2">
                   <a href="<?php echo base_url(); ?>BankAccount/"><button type="button" name="BankToMain" value="BankToMain" class="btn btn-block btn-primary">Back to main</button></a>
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
    $('#bankDropDown').load('<?php echo base_url("BankAccount/BankDropDown")?>',{id:<?php echo $GetAccount->AccountId; ?>})
   // get bank though ajax set value of modul box
   $(document).on('click','#addBank',function(){
           $('#showBankMesg').text('')
        $.ajax({
                url:"<?php echo base_url('BankAccount/Banks')?>",
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
                url:"<?php echo base_url('BankAccount/AddBank')?>",
                type:'post',
                data:{BName:BankName,BAbb:BankAbb},
                success:function(data){
                   
                   $('#showBanks').load('<?php echo base_url("BankAccount/Banks")?>')
                   $('#showBankMesg').text('Bank added Successfuly...!')
                   $('#bankDropDown').load('<?php echo base_url("BankAccount/BankDropDown")?>',{id:<?php echo $GetAccount->AccountId; ?>})
                   
                   
                }
               
            });
          
      });
 
 
 //update bank
    $(document).on('click','span[id^=BankEdit]',function(){
             var arr= $(this).attr('id').split("_");
             var BankName = $("#BankName_"+arr[1]).val();
             var BankAbb = $("#BankAbb_"+arr[1]).val();
               $.ajax({
                url:"<?php echo base_url('BankAccount/UpdateBank')?>",
                type:'post',
                data:{BName:BankName,BAbb:BankAbb,BId:arr[1]},
                success:function(data){
                    if(data=='success')
                    {
                        $('#showBanks').load('<?php echo base_url("BankAccount/Banks")?>')
                        $('#showBankMesg').text('Bank Updated Successfuly...!')
                        $('#bankDropDown').load('<?php echo base_url("BankAccount/BankDropDown")?>',{id:<?php echo $GetAccount->AccountId; ?>})
                       
                    }
                }
            });
    });
 
 
 //update bank status
    $(document).on('click','span[id^=BankStatus]',function(){
            var arr= $(this).attr('id').split("_");
                  $.ajax({
                url:"<?php echo base_url('BankAccount/UpdateBank')?>",
                type:'post',
                data:{BId:arr[1]},
                success:function(data){
                    console.log(data);
                    if(data=='success')
                    {
                        $('#showBanks').load('<?php echo base_url("BankAccount/Banks")?>')
                        $('#showBankMesg').text('Bank Updated Successfuly...!')
                        $('#bankDropDown').load('<?php echo base_url("BankAccount/BankDropDown")?>',{id:<?php echo $GetAccount->AccountId; ?>})
                        setTimeout(pauseScript, 200)
                    }
                }
            });
    });
    
  //autocomplete
       $('#ChartOfAccount').autocomplete({
   		source: function(request, response)   {
			$.ajax({
				url: "<?php echo site_url('GeneralJournal/AutoCompleteSearch_COA')?>",
				data: { term:$("#ChartOfAccount").val()},
				dataType: "json",
				type: "POST",
				success: function(data) {					
					//console.log(data);
                                        response(data);
				}
			});
		},
                 select: function (event, ui) {
                 $(this).val(ui.item.value); // display the selected text
                 $("#hdnChartOfAccount").val(ui.item.id); // save selected id to hidden input
                },
		minLength: 2
	});

            
       //set chart of account title
       $('#AccountTitle').focus( function() {
          $("#ChartOfAccountTitle").val('');
       });
       $('#AccountTitle').blur( function() {
          var CustomerName = $(this).val();
          $("#ChartOfAccountTitle").val(CustomerName)
       });

   
 });
  </script>
<!-- ./wrapper -->
<?php $this->load->view("includes/footer"); ?>