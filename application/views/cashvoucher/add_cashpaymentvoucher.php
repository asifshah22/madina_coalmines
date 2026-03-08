<?php
$this->load->view("includes/header");
$this->load->view("includes/sidebar");
?>

<script src="<?php echo site_url();?>/lib/js/autocompletejs/jquery-ui.js"></script>
<link rel="stylesheet" href="<?php echo site_url();?>/lib/css/autocompletecss/jquery-ui.css"/>
  <div class="content-wrapper">
    <section class="content-header">
      <h1><i class="fa fa-book"></i>&nbsp;Cash Payment Voucher</h1>
    </section>

    <!-- Main content -->
    <section class="content">
     <div class="row">
	 <div class="col-md-12">
	 <div class="box box-info">
         <div  class="box-header with-border">
          <h3 class="box-title text-light-blue">Add Cash Payment Voucher</h3>
         </div>
	
         <form role="form" id="GeneralJournalForm" method="post" action='<?php echo site_url("CashPaymentVoucher/SaveCPV"); ?>'>
	 <input type="hidden" name="CashCOA" value="1">
	 <div class="box-body">
	     <div class="row invoice-info">
	    <div class="col-sm-2 form-group">
	      <strong>Voucher #:</strong><br>
		(Auto Generated)
            </div>
	    <div class="col-sm-3 form-group">
	      <strong>Voucher Date:</strong><br>
		<div class="input-group date">
		   <input style="width:220px; height:28px;" class="form-control" name="TransactionDate" id="datepicker" type="text" value="<?php echo date("m/d/Y"); ?>" autocomplete="off">
		</div>
	    </div>
	    <div class="col-sm-3 form-group">
	      <strong>Cash Balance:</strong><br>
		<div class="input-group date">
		   <span id="ShowCashBalance">
		   <input style="background:transparent; border:none; color:blue; text-align:left;" class="form-control" name="CashBalance" id="CashBalance" type="text" value="<?php if (!empty($CashOpenningBalance[0]['Balance'])) { echo $CashOpenningBalance[0]['Balance']; } else { echo 0.00; } ?>" readonly>
		   </span>
		</div>	
	    </div>   
	  </div>
	  </div>
	     
	  <!-- Voucher Detail Entries Block -->
          <div class="row">
	    <div class="col-md-12">
                    
	     <div class="box-body pad table-responsive">
	     <table id="GJ_EntriesTable" class="table table-bordered text-center">
              <tr style="background-color:#ECF9FF; border:1px solid; border-color:#dadada;">
	       <th>S. #</th>
	       <th>Account Name</th>
	       <th>Head of Account</th>
	       <th>Description</th>
	       <th>Amount</th>
	       <th><span style="padding-top:2px;" class="fa fa-trash"></span></th>
	      </tr>
	      <?php
	      for($i=1; $i<=2; $i++) { ?>
	       
	      <tr id="row_<?php echo $i; ?>">
	       <td><?php echo $i; ?></td>
	       <td><input style="width:100%; height:30px; text-align:left;" type="text" class="form-control" id="ChartOfAccount_<?php echo $i; ?>" autocomplete="off"/><input type="hidden" id="hdnChartOfAccount_<?php echo $i; ?>" name="ChartOfAccount[]"></td>
	       <td><input style="width:100%; height:30px; text-align:left;" type="text" class="form-control" id="PayeeName_<?php echo $i; ?>" autocomplete="off"/><input type="hidden" id="hdnPayeeName_<?php echo $i; ?>" name="PayeeName[]"/></td>
	       <td><input style="width:100%; height:30px; text-align:left;" type="text" class="form-control" id="Description_<?php echo $i; ?>" name="Description[]" autocomplete="off"></td>
	       <td><input style="width:100%; height:30px; text-align:right;" type="text" class="form-control" id="Debit_<?php echo $i; ?>" name="Debit[]" autocomplete="off"></td>
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
		<td colspan="4" style="text-align:right; width:76%; padding:9px; font-weight:600;">Total Amount:</td>
		<td style="text-align:right; width:24%; padding:9px; font-weight:600;"><div id="TotalAmount">0.00</div></td>
		<td style="width:9%; color:#008000; padding:9px; text-align:right;">&nbsp;&nbsp;&nbsp;&nbsp;</td>
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
	      <a href="<?php echo base_url(); ?>CashPaymentVoucher/"><button type="button" name="BackForm" value="BacktoForm" class="btn btn-block bg-orange">Back to Main</button></a>
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
  /*  function myFunction() {
    following code get cash balance upto date
    var d = document.getElementById("datepicker");
    var DateVal = d.value;
 
    var DateArray = DateVal.split("/");
    var VoucherDate = DateArray[2] + '-' + DateArray[0] + '-' + DateArray[1];

    $.ajax({	
      type: "POST",
      url:"<?php // site_url('CashPaymentVoucher/GetCashBalance')?>",
      dataType: 'html',
      data: {  VoucherDate : VoucherDate},
      success: function(data){
      $('#ShowCashBalance').html(data)
      }
  });
        return false;
}
*/
</script>
 <script>
    $(function(){
    
    // Get Chart of Account value on auto complete action
    $(document).on('keyup','input[id^=ChartOfAccount]',function(){
	var  txtid      = ($(this).attr('id'));
	var  txtvalue   = $(this).val();
	
	$(this).autocomplete({
	    source: function(request, response)   {
		$.ajax({
		    url: "<?php echo site_url('Generaljournal/AutoCompleteSearch_COA')?>",
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
		    url: "<?php echo site_url('Generaljournal/GetAllPayee'); ?>",
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
	$("#GJ_EntriesTable").append('<tr><td>'+nextTxtId+'</td><td><input class="form-control" type="text" style="width:100%; text-align:left;" id="ChartOfAccount_'+nextTxtId+'" autocomplete="off"/><input type="hidden" id="hdnChartOfAccount_'+nextTxtId+'" name="ChartOfAccount[]"></td><td><input class="form-control" type="text" style="width:100%; text-align:left;" id="PayeeName_'+nextTxtId+'" autocomplete="off"/><input type="hidden" id="hdnPayeeName_'+nextTxtId+'" name="PayeeName[]" value=""/></td><td><input class="form-control" style="width:100%; text-align:left;" type="text" id="Description_'+nextTxtId+'" name="Description[]" autocomplete="off"/></td><td><input class="form-control" style="width:100%; height:30px; text-align:right;" type="text" id="Debit_'+nextTxtId+'" name="Debit[]" autocomplete="off"/></td><td><span style="color:red; cursor: pointer; padding-top:8px;" id="remove_'+nextTxtId+'" class="fa fa-times-circle"></span><input type="hidden" name="ReconciliationStatus[]" value="0"></td><tr>');
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

    //Debit value must be number
    $("input[id^=Debit]").on("keyup",function(){
        var format = $(this).val();
        if(isNaN(format))
        {
           alert("Amount must be number!");
           $(this).focus();
           $(this).val('');
        }
    });
    
    // Sum total Debit values
     $(document).on("keyup","input[id^=Debit]",function(){
    
        var TotalAmount = 0;
        $("input[id^=Debit]").each(function(){
            var value = $(this).val();
            if(value != '')
            TotalAmount += parseInt(value);
           $("#TotalAmount").text(TotalAmount.toFixed(2));
        });
    });
    
    // Form validation
    $("#GeneralJournalForm").on("submit",function(e){
        counter = 0;
	
        $("input[id^=Debit]").each(function()
	{
             var arr = $(this).attr("id").split("_");
             var Debit = $("#Debit_"+arr[1]).val();
             var COA = $("#ChartOfAccount_"+arr[1]).val();
	     var hdnCOA = $("#hdnChartOfAccount_"+arr[1]).val();
	      
	    if(Debit == '' && counter == 0)
            {
               e.preventDefault()
               alert("Please enter amount");
               $("#Debit_"+arr[1]).focus();
               return false 
            }
	    
	    if((Debit != '') && (hdnCOA == '' || COA == '') )
            {
               e.preventDefault()
               alert("Please enter chart of account");
               $("#ChartOfAccount_"+arr[1]).focus();
               return false 
            }

	    if((Debit == '') && (COA != ''))
            {
               e.preventDefault()
               alert("Please enter amount");
               $("#Debit_"+arr[1]).focus();
               return false
            }
   
	    if(COA != '' && hdnCOA != '')
            { counter++; }

        });
	
	//var CashBalance = parseFloat($("#CashBalance").val());
	//var Total_Amount = parseFloat($("#TotalAmount").text());
	  
	/*
	 following code restrict to submit form if cash balance is lower than transaction amount  
	if(CashBalance < Total_Amount )
	{
	    alert("Form cannot be submitted because Cash Balance is less than Total Amount");
	    e.preventDefault();
	    $(this).focus;
	}
	*/
    });
});
</script>
<?php $this->load->view("includes/footer"); ?>