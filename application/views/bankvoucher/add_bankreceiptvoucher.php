<?php
$this->load->view("includes/header");
$this->load->view("includes/sidebar");
?>
<script src="<?php echo site_url();?>/lib/js/autocompletejs/jquery-ui.js"></script>
<link rel="stylesheet" href="<?php echo site_url();?>/lib/css/autocompletecss/jquery-ui.css"/>
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1><i class="fa fa-book"></i>&nbsp;Bank Receipt Voucher</h1>
    </section>
    
    <!-- Main content -->
    <section class="content">
     <div class="row">
	<div class="col-md-12">
	 <div class="box box-info">
         <div  class="box-header with-border">
	   <h3 class="box-title text-light-blue"><span style="color:#000000;">Add Bank Receipt Voucher</span></h3>
         </div>
	
         <form role="form" id="GeneralJournalForm" method="post" action='<?php echo site_url("BankReceiptVoucher/SaveBRV"); ?>'>
	  <div class="box-body">
	  <div class="row invoice-info">
	    <div class="col-sm-2 form-group">
	      <strong>Voucher #:</strong><br>
	      (Auto Generated)
	    </div>
	    <div class="col-sm-3 form-group">
	      <strong>Voucher Date:</strong><br>
		<div class="input-group date">
		 <input style="width:220px; height:30px;" class="form-control" name="TransactionDate" id="datepicker" type="text" value="<?php echo date("m/d/Y"); ?>" autocomplete="off">
		</div>
	    </div>
	      <div class="col-sm-3 form-group">
	      <strong>Bank Accounts:</strong><br>
	      <div class="input-group date">
		<select name="BankAccount" id="BankAccount" class="form-control select2" style="width:220px;" required="required">
		  <option value="">Select Bank Account</option>  
		  <?php foreach ($GetBankAccounts as $BankAccounts) { ?>
		   <option value="<?php echo $BankAccounts['AccountId'].'-'.$BankAccounts['ChartOfAccountsId']; ?>"><?php echo $BankAccounts['AccountTitle']; ?></option>
		 <?php } ?>
	      </select>
	    </div>
	    </div>
	  </div>
	   </div>   
	  <div style="height:10px;"></div>
	     
	  <!-- Voucher Detail Entries Block -->
          <div class="row">
	    <div class="col-md-12">
                    
		<div class="box-body pad table-responsive">
		<table id="GJ_EntriesTable" class="table table-bordered text-center">
		<tr style="background-color:#ECF9FF; border:1px solid; border-color:#dadada;"> 
		    <th>S.#</th>
		    <th>Account Name</th>
		    <th>Head of Account</th>
		    <th>Description</th>
		    <th>Amount</th>
		    <th><span class="fa fa-trash"></span></th>
		   </tr>
		  <?php for($i=1; $i<=2; $i++) { ?>
		   <tr id="row_<?php echo $i; ?>">
		    <td><?php echo $i; ?></td>
		    <td><input style="width:100%; text-align:left;" type="text" id="ChartOfAccount_<?php echo $i; ?>" autocomplete="off"/><input type="hidden" id="hdnChartOfAccount_<?php echo $i; ?>" name="ChartOfAccount[]"></td>
		    <td><input style="width:100%; text-align:left;" type="text" id="PayeeName_<?php echo $i; ?>" value="" autocomplete="off"/><input type="hidden" id="hdnPayeeName_<?php echo $i; ?>" name="PayeeName[]"/></td>
		    <td><input style="width:100%; text-align:left;" type="text" id="Description_<?php echo $i; ?>" name="Description[]" autocomplete="off"></td>
		    <td><input style="width:100%; text-align:right;" type="text" id="Credit_<?php echo $i; ?>" name="Credit[]" autocomplete="off"></td>
		    <td>
		      <?php if($i != 1) { ?>
		      <span style="color:red; cursor:pointer; padding-top:8px;" id="remove_<?php echo $i?>" class="fa fa-times-circle"></span>
		      <?php } ?>
		    </td>
		   </tr>
		  <?php } ?>
		</table>
		<table class="table table-bordered text-center">
		<tr>
		 <td colspan="4" style="text-align:right; width:74%; padding:9px; font-weight:600;">Total Amount:</td>
		 <td style="text-align:right; width:23%; padding:9px; font-weight:600;"><div id="TotalAmount">0.00</div></td>
		<td style="width:9%; color:#008000; padding:9px; padding-right:3px; text-align:right;">&nbsp;&nbsp;&nbsp;&nbsp;</td>
	        </tr>
	        <tr>
		 <td colspan="6" style="text-align:left;"><span style="cursor:pointer; color:darkgreen; font-weight:600;" id="addRow" class="fa fa-plus"> Add Row</span></td>
		</tr>
		</table>
		<div style="height:5px;"></div>
		</div>		      
	    </div>
	  </div>
	  <div class="box-body">
	    <div class="row">
	     <div class="col-md-12">
	      <address>
		<label for="VoucherNote" class="col-sm-2 control-label">Voucher Note:</label>
		 <div class="input-group">
		   <textarea name="VoucherNote" class="form-control" rows="2" cols="60"></textarea>
		 </div>
	      </address>
	     </div>
	     <div class="col-md-2">
	      <button type="submit" name="submitForm" value="AddRecord" class="btn btn-block btn-primary">Save Record</button>
	     </div>
	     <div class="col-md-2">
	       <a href="<?php echo base_url(); ?>BankPaymentVoucher/"><button type="button" name="BackForm" value="BacktoForm" class="btn btn-block bg-orange">Back to Main</button></a>
	     </div>
	    </div>
	  </div>
       </form>
      </div>
     </div>
     </div>
    </section>
    <!-- /.content -->
  </div>
 <script>
    $(function(){
	
	
        // auto complete chartOfAccount
        $(document).on('keyup','input[id^=ChartOfAccount]',function(){
            var  txtid      = ($(this).attr('id'));
            var  txtvalue   = $(this).val();
	     //var BankAccountId = $("#BankAccountId").val();
	    
            $(this).autocomplete({
                source: function(request, response)   {
                    $.ajax({
                        url: "<?php echo site_url('BankPaymentVoucher/AutoCompleteSearch_BankCOA'); ?>",
                        data: { term:txtvalue},
                        dataType: "json",
                        type: "POST",
                        success: function(data) {
                        response(data);
                        }
                    });
                },
                select: function (event,ui) {
                    $(this).val(ui.item.value); // display the selected text
                    $("#hdn"+txtid).val(ui.item.id); // save selected id to hidden input
                },
                minLength: 2
            });
        });
	
	
               
	// Script for Payees
	$(document).on('keyup','input[id^=PayeeName]',function(){
            var  payeeid    = ($(this).attr('id'));
            var  payeevalue = $(this).val();
	    
	    // Assign blank value to payee id if payee value is null
	    if(payeevalue === '')
	    {
		$("#hdn"+payeeid).val('');
	    }
         
            $(this).autocomplete({
                source: function(request, response)   {
                    $.ajax({
                        url: "<?php echo site_url('GeneralJournal/GetAllPayee'); ?>",
                        data: { payee:payeevalue},
                        dataType: "json",
                        type: "POST",
                        success: function(data) {
                        response(data);
                        }
                    });
                },
                select: function (event,ui) {
                    $(this).val(ui.item.value); // display the selected text
                    $("#hdn"+payeeid).val(ui.item.id); // save selected id to hidden input
                },
                minLength: 2
            });
        });
	
	
        
        // Add New Row
    $("#addRow").on("click",function(){
	var txtId = $("input[id^=ChartOfAccount]:last").attr("id");
	var arr = txtId.split("_");
	var nextTxtId = (parseInt(arr[1]) +1);
	$("#GJ_EntriesTable").append('<tr><td>'+nextTxtId+'</td><td><input class="form-control" type="text" style="width:100%; text-align:left;" id="ChartOfAccount_'+nextTxtId+'" autocomplete="off"/><input type="hidden" id="hdnChartOfAccount_'+nextTxtId+'" name="ChartOfAccount[]"></td><td><input class="form-control" type="text" style="width:100%; text-align:left;" id="PayeeName_'+nextTxtId+'" autocomplete="off"/><input type="hidden" id="hdnPayeeName_'+nextTxtId+'" name="PayeeName[]" value=""/></td><td><input class="form-control" style="width:100%; text-align:left;" type="text" id="Description_'+nextTxtId+'" name="Description[]" autocomplete="off"/></td><td><input class="form-control" style="width:100%; height:30px; text-align:right;" type="text" id="Credit_'+nextTxtId+'" name="Credit[]" autocomplete="off"/></td><td><span style="color:red; cursor: pointer; padding-top:8px;" id="remove_'+nextTxtId+'" class="fa fa-times-circle"></span><input type="hidden" name="ReconciliationStatus[]" value="0"></td><tr>');
    })
    
    // Remove Row
    $(document).on('mouseover','span[id^=remove]',function(){
	$(this).css({"cursor":"pointer"});
    });
    $(document).on('click','span[id^=remove]',function(){
	removeId = $(this).attr('id');
	arr = removeId.split("_");
	$(this).parent().parent().remove()
    })

    //Credit value must be number
    $("input[id^=Credit]").on("keyup",function(){
        var format = $(this).val();
        if(isNaN(format))
        {
           alert("Amount must be number!");
           $(this).focus();
           $(this).val('');
        }
    });
    
    // Sum total Credit values
     $(document).on("keyup","input[id^=Credit]",function(){
    
        var TotalAmount = 0;
        $("input[id^=Credit]").each(function(){
            var value = $(this).val();
            if(value != '')
            TotalAmount += parseInt(value);
           $("#TotalAmount").text(TotalAmount.toFixed(2));
        });
    });
    
    // Form validation
    $("#GeneralJournalForm").on("submit",function(e){
        counter = 0;
	
        $("input[id^=Credit]").each(function()
	{
             var arr = $(this).attr("id").split("_");
             var Credit = $("#Credit_"+arr[1]).val();
             var COA = $("#ChartOfAccount_"+arr[1]).val();
	     var hdnCOA = $("#hdnChartOfAccount_"+arr[1]).val();
	      
	    if(Credit == '' && counter == 0)
            {
               e.preventDefault()
               alert("Please enter amount");
               $("#Credit_"+arr[1]).focus();
               return false 
            }
	    
	    if((Credit != '') && (hdnCOA == '' || COA == '') )
            {
               e.preventDefault()
               alert("Please enter chart of account");
               $("#ChartOfAccount_"+arr[1]).focus();
               return false 
            }

	    if((Credit == '') && (COA != ''))
            {
               e.preventDefault()
               alert("Please enter amount");
               $("#Credit_"+arr[1]).focus();
               return false
            }
   
	    if(COA != '' && hdnCOA != '')
            { counter++; }

        });
    });
    
    
    
    
    
});
</script>
<?php $this->load->view("includes/footer"); ?>