<?php 
$this->load->view('includes/header');
$this->load->view('includes/sidebar');		      
?>
<script src="<?php echo site_url();?>/lib/js/autocompletejs/jquery-ui.js"></script>
<link rel="stylesheet" href="<?php echo site_url();?>/lib/css/autocompletecss/jquery-ui.css"/>

<style>
  .purchase-form {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
  }
  .table-responsive {
    overflow-x: auto;
    padding: 15px;
    background: #fff;
    border-radius: 8px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
  }
  .table th {
    background: linear-gradient(to bottom, #f8f9fa, #e9ecef);
    padding: 12px 8px;
    font-weight: 600;
    border: 1px solid #dee2e6;
  }
  .table td {
    padding: 10px 8px;
    vertical-align: middle;
  }
  .form-control {
    border-radius: 4px;
    padding: 8px 12px;
    height: 38px;
    border: 1px solid #ced4da;
    width: 100% !important;
  }
  .form-control:focus {
    border-color: #80bdff;
    box-shadow: 0 0 0 0.2rem rgba(0,123,255,.25);
  }
  .final-value {
    font-weight: bold;
    background-color: #f8f9fa;
  }
  .total-row {
    background-color: #e9ecef;
    font-weight: bold;
  }
  .total-row td {
    border-top: 2px solid #dee2e6;
  }
  .box-info {
    border-top: 3px solid #17a2b8;
  }
  .text-light-blue {
    color: #17a2b8 !important;
  }
  #addRow {
    padding: 8px 15px;
    background: #28a745;
    color: white;
    border-radius: 4px;
    display: inline-block;
    margin-bottom: 15px;
  }
  #addRow:hover {
    background: #218838;
    cursor: pointer;
  }
  .invoice-col {
    margin-bottom: 15px;
  }
</style>

 <script type="text/javascript">
  $(function() {
    // remove row
    $(document).on('mouseover','span[id^=remove]',function(){
      $(this).css({"cursor":"pointer"}); 
    });
    
    $(document).on('click','span[id^=remove]',function(){
      removeId = $(this).attr('id');
      arr = removeId.split("_");
      $(this).parent().parent().remove();
      calculateTotals();
    });
    
    // Add new row
    $("#addRow").click(function() {
      var rowCount = $('.txtMult').length;
      var newRow = $('.txtMult:last').clone();
      
      // Update IDs and clear values
      newRow.find('input, select').each(function() {
        var id = $(this).attr('id');
        var name = $(this).attr('name');
        if (id) {
          var newId = id.replace(/_(\d+)/, '_' + (rowCount + 1));
          $(this).attr('id', newId);
        }
        if ($(this).is('input') && !$(this).is('[type="hidden"]')) {
          if (name && name.includes('Old')) {
            // Don't clear old values
          } else if ($(this).hasClass('Amount') || $(this).hasClass('RegularDiscount') || 
              $(this).hasClass('SaleDiscount') || $(this).hasClass('NetAmount')) {
            $(this).val('0.00');
          } else if (!$(this).hasClass('Rate') && !$(this).hasClass('Quantity') && 
                     !$(this).hasClass('DiscountAmount') && !$(this).hasClass('Discount') && 
                     !$(this).hasClass('ODiscount') && !$(this).hasClass('HoldingAmount')) {
            $(this).val('');
          }
        }
      });
      
      // Update the serial number
      newRow.find('td:first').text(rowCount + 1);
      
      // Add remove button
      newRow.find('td:last').html('<span id="remove_' + (rowCount + 1) + '" class="fa fa-times-circle" style="color:red; font-size:18px;"></span>');
      
      // Insert the new row
      newRow.insertAfter('.txtMult:last');
      
      // Initialize autocomplete for the new row
      initAutocomplete(rowCount + 1);
      
      // Update the SNo hidden field
      $("#SNo").val(rowCount + 2);
    });
    
    // Calculate totals when values change
    $(document).on('input', '.Quantity, .Rate, .DiscountAmount, .Discount, .ODiscount, .HoldingAmount', function() {
      calculateRowTotal($(this).closest('tr'));
      calculateTotals();
    });
    
    // Initialize autocomplete for existing rows
    <?php foreach($PurchaseDetail as $key => $Record) { ?>
      initAutocomplete(<?php echo $key + 1; ?>);
    <?php } ?>
  });
  
  function initAutocomplete(rowNum) {
    // Initialize autocomplete for ProductName
    $("#ProductName_" + rowNum).autocomplete({
      source: "<?php echo base_url('Purchase/GetProductNames'); ?>",
      minLength: 1,
      select: function(event, ui) {
        $("#hdnProductName_" + rowNum).val(ui.item.id);
      }
    });
    
    // Initialize autocomplete for LocationName
    $("#LocationName_" + rowNum).autocomplete({
      source: "<?php echo base_url('Purchase/GetLocationNames'); ?>",
      minLength: 1,
      select: function(event, ui) {
        $("#hdnLocationName_" + rowNum).val(ui.item.id);
      }
    });
  }
  
  function calculateRowTotal(row) {
    var rate = parseFloat(row.find('.Rate').val()) || 0;
    var quantity = parseFloat(row.find('.Quantity').val()) || 0;
    var gstRate = parseFloat(row.find('.DiscountAmount').val()) || 0;
    var discount = parseFloat(row.find('.Discount').val()) || 0;
    var oDiscount = parseFloat(row.find('.ODiscount').val()) || 0;
    var holdingAmount = parseFloat(row.find('.HoldingAmount').val()) || 0;
    
    // Calculate amount
    var amount = rate * quantity;
    row.find('.Amount').val(amount.toFixed(2));
    
    // Calculate GST amount
    var gstAmount = (amount * gstRate / 100);
    row.find('.RegularDiscount').val(gstAmount.toFixed(2));
    
    // Calculate value including GST
    var valueInclGst = amount + gstAmount;
    row.find('.SaleDiscount').val(valueInclGst.toFixed(2));
    
    // Calculate final value
    var finalValue = valueInclGst - discount - oDiscount - holdingAmount;
    row.find('.NetAmount').val(finalValue.toFixed(2));
  }
  
  function calculateTotals() {
    var totalQuantity = 0;
    var totalAmount = 0;
    var totalGstAmount = 0;
    var totalValueInclGst = 0;
    var totalDiscount = 0;
    var totalODiscount = 0;
    var totalHoldingAmount = 0;
    var totalFinalValue = 0;
    
    $('.txtMult').each(function() {
      totalQuantity += parseFloat($(this).find('.Quantity').val()) || 0;
      totalAmount += parseFloat($(this).find('.Amount').val()) || 0;
      totalGstAmount += parseFloat($(this).find('.RegularDiscount').val()) || 0;
      totalValueInclGst += parseFloat($(this).find('.SaleDiscount').val()) || 0;
      totalDiscount += parseFloat($(this).find('.Discount').val()) || 0;
      totalODiscount += parseFloat($(this).find('.ODiscount').val()) || 0;
      totalHoldingAmount += parseFloat($(this).find('.HoldingAmount').val()) || 0;
      totalFinalValue += parseFloat($(this).find('.NetAmount').val()) || 0;
    });
    
    // Update summary totals
    $('#Quantity').text(totalQuantity.toFixed(2));
    $('#Amount').text(totalAmount.toFixed(2));
    $('#DiscountAmount').text(totalGstAmount.toFixed(2));
    $('#TotalAmount').text(totalFinalValue.toFixed(2));
    
    // Update column totals
    $('#totalQuantity').text(totalQuantity.toFixed(2));
    $('#totalAmount').text(totalAmount.toFixed(2));
    $('#totalGstAmount').text(totalGstAmount.toFixed(2));
    $('#totalValueInclGst').text(totalValueInclGst.toFixed(2));
    $('#totalDiscount').text(totalDiscount.toFixed(2));
    $('#totalODiscount').text(totalODiscount.toFixed(2));
    $('#totalHoldingAmount').text(totalHoldingAmount.toFixed(2));
    $('#totalFinalValue').text(totalFinalValue.toFixed(2));
  }
 </script>

  <div class="content-wrapper purchase-form">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1><i class="fa fa-laptop"></i>&nbsp;Purchases</h1>
    </section>
    
    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-md-12">
          <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title text-light-blue">Edit Purchase</h3>
            </div>
	    <?php echo "<font style=color:#00468E; font-weight:bold text-align:center;>".$this->session->flashdata('record_update')."</font>"; ?>
	    
            <form role="form" id="PurchaseForm" action='<?php echo base_url("Purchase/UpdatePurchase") ?>' method="post">
	    <input type="hidden" name="PurchaseId" id="PurchaseId" class="form-control" value="<?php echo $Purchases->PurchaseId; ?>">
	    <input type="hidden" name="PurchaseNo" id="PurchaseNo" class="form-control" value="<?php echo $Purchases->PurchaseNo; ?>">
	    
	    <div class="box-body">
	      <div class="row invoice-info">
		<div class="col-sm-3 invoice-col">
		  <address>
		    <strong>Purchase #:</strong><br>
		    <span style="color:#3333CC; font-size:13px; font-weight:bold;"><?php echo $Purchases->PurchaseNo; ?></span>
		  </address>
		</div>

	<div class="col-sm-3 invoice-col">
      <address>
        <strong>Purchase Status:</strong><br>
        <select name="PurchaseStatus" id="PurchaseStatus" class="form-control select2" required="required">
          <option <?php echo $Purchases->PurchaseStatus == "Confirm" ? 'selected=selected' : ''; ?> value="Confirm">Confirm</option>
          <option <?php echo $Purchases->PurchaseStatus == "Cancel" ? 'selected=selected' : ''; ?> value="Cancel">Cancel</option>
        </select>
      </address>
    </div>

		<div class="col-sm-3 invoice-col">
		  <address>
		    <strong>Vendor:</strong><br>
		    <select name="VendorId" id="VendorId" class="form-control select2" required="required">
			<option value="">Select Vendor</option>
			<?php foreach ($AllVendors as $VendorRecord) { ?>
			<option <?php echo $Purchases->VendorId == $VendorRecord['VendorId'] ? 'selected=selected' : ''; ?> value="<?php echo $VendorRecord['VendorId'] . "-" .$VendorRecord['ChartOfAccountId']; ?>"><?php echo $VendorRecord['VendorName'];?></option>
			<?php } ?>
		      </select>
          </address>
		</div>

		<div class="col-sm-3 invoice-col">
		  <address>
		    <strong>Bank Account:</strong><br>
    		   <select name="BankAccountId" class="form-control select2">
	              <option value="0"> Select Bank Account</option>
	              <?php  foreach ($GetAllBankAccounts as $BankAccounts) {
	              ?>
	              <option <?php echo $Purchases->AccountId == $BankAccounts['AccountId'] ? 'selected=selected' : '' ?> value="<?php echo $BankAccounts['AccountId'] . "-" .$BankAccounts['ChartOfAccountId']; ?>"><?php echo $BankAccounts['AccountTitle'] . " - " . $BankAccounts['AccountNumber'];  ?></option>
	              <?php
	               } ?>
	            </select>
		  </address>
		</div>

		<div class="col-sm-3 invoice-col">
		  <address>
		    <strong>Purchase Date:</strong><br>
		    <input class="form-control" id="datepicker1" type="text" name="PurchaseDate" value="<?php echo date("m/d/Y", strtotime($Purchases->PurchaseDate)); ?>">
                  </address>
		</div>

		<div class="col-sm-3 invoice-col">
		  <address>
		    <strong>Purchase Type:</strong><br>
		    <select name="PurchaseType" id="PurchaseType" class="form-control" required="required">
				<option value="1" <?php if($Purchases->PurchaseType == 1){ echo "selected=selected" ; } ?> >On Cash</option>
				<option value="2" <?php if($Purchases->PurchaseType == 2){ echo "selected=selected" ; } ?> >On Credit</option>
				<option value="3" <?php if($Purchases->PurchaseType == 3){ echo "selected=selected" ; } ?> >Online</option>
			  </select>
		  </address>
		</div>


		<div class="col-sm-3 invoice-col">
		  <address>
		    <strong>Purchase Note:</strong><br>
				<input type="text" name="PurchaseNote" id="PurchaseNote" value="<?php echo $Purchases->PurchaseNote; ?>" class="form-control">
		  </address>
		</div>

	      </div>
	  </div>
	  
<div class="row" style="display: block;" id="mainRow">
    <div class="col-md-12">
        <div class="box-body pad table-responsive">
            <table class='table table-bordered text-center' id="Purchase_EntriesTable" style="border-collapse: separate; border-spacing: 0; border-radius: 8px; overflow: hidden;">
                <thead>
                     <tr style="background: linear-gradient(to bottom, #f8f9fa, #e9ecef);">
                        <th style="width:2%; padding: 12px 5px; font-weight: 600; letter-spacing: 0.5px;">S.#</th>
                        <th style="width:10%; padding: 12px 5px; font-weight: 600; letter-spacing: 0.5px;">ITEM</th>
                        <th style="width:5%; padding: 12px 5px; font-weight: 600; letter-spacing: 0.5px;">LOCATION</th>
                        <th style="width:8%; padding: 12px 5px; font-weight: 600; letter-spacing: 0.5px;">RATE</th>
                        <th style="width:5%; padding: 12px 5px; font-weight: 600; letter-spacing: 0.5px;">QTY</th>
                        <th style="width:8%; padding: 12px 5px; font-weight: 600; letter-spacing: 0.5px;">VALUE</th>
                        <th style="width:8%; padding: 12px 5px; font-weight: 600; letter-spacing: 0.5px;">GST RATE</th>
                        <th style="width:8%; padding: 12px 5px; font-weight: 600; letter-spacing: 0.5px;">GST AMOUNT</th>
                        <th style="width:8%; padding: 12px 5px; font-weight: 600; letter-spacing: 0.5px;">VALUE INCL ST</th>
                        <th style="width:8%; padding: 12px 5px; font-weight: 600; letter-spacing: 0.5px;">DISCOUNT</th>
                        <th style="width:8%; padding: 12px 5px; font-weight: 600; letter-spacing: 0.5px;">O.DISCOUNT</th>
                        <th style="width:8%; padding: 12px 5px; font-weight: 600; letter-spacing: 0.5px;">WH AMOUNT</th>
                        <th style="width:10%; padding: 12px 5px; font-weight: 600; letter-spacing: 0.5px;">FINAL VALUE</th>
                        <th style="width:8%; padding: 12px 5px; font-weight: 600; letter-spacing: 0.5px;">DESCRIPTION</th>
                        <th style="width:2%; padding: 12px 5px; font-weight: 600; letter-spacing: 0.5px;">ACTION</th>
                    </tr>
                </thead>
                <tbody>
		<?php 
			$TotalNetAmount = 0;
		    $Quantity = 0;
		    $Amount = 0;
		    $DiscountAmount = 0;
		    $NetAmount = 0;

			$SNo = 1; 
			foreach($PurchaseDetail as $Record) {
		?>
		<tr class="txtMult">
		 <td style="margin-top:15px;line-height:25px"><?php echo $SNo; ?></td>
		 <td>
		  <input type='text' name="ProductName[]" id="ProductName_<?php echo $SNo?>" autocomplete="off" value="<?php echo $Record['ProductName'];?>" class="form-control">
		  <input type='hidden' id="hdnProductName_<?php echo $SNo; ?>" name="ProductId[]" value="<?php echo $Record['ProductId'];?>">
		  <input type='hidden' id="OldhdnProductName_<?php echo $SNo; ?>" name="OldProductId[]" value="<?php echo $Record['ProductId'];?>">
		 </td>
		 <td>
		  <input type='text' id="LocationName_<?php echo $SNo?>" autocomplete="off" value="<?php echo $Record['LocationName'];?>" class="form-control">
		  <input type='hidden' id="hdnLocationName_<?php echo $SNo?>" name="LocationId[]" value="<?php echo $Record['LocationId'];?>">
      <input type='hidden' id="OldhdnLocationName_<?php echo $SNo?>" name="OldLocationId[]" value="<?php echo $Record['LocationId'];?>">
		 </td>
		 <td><input type='number' id="Rate<?php print $SNo; ?>" class="Rate form-control" name='Rate[]' autocomplete="off" value="<?php echo $Record['Rate'];?>" min="0" step="0.01"></td>
		 <td><input type='number' id="Quantity<?php print $SNo; ?>" class="Quantity form-control" name='Quantity[]' autocomplete="off" value="<?php echo $Record['Quantity'];?>" min="0" step="0.01"></td>
     <input type='hidden' id="OldQuantity<?php print $SNo; ?>" class="Quantity" name='OldQuantity[]' autocomplete="off" value="<?php echo $Record['Quantity'];?>" min="0" step="0.01">
		 <td><input type='number' id="Amount<?php print $SNo; ?>" class="Amount form-control" name='Amount[]' value="<?php echo $Record['Amount'];?>" min="0" step="0.01" readonly></td>
		 <td><input type='number' id="DiscountAmount<?php print $SNo; ?>" class="DiscountAmount form-control" name='DiscountAmount[]' value="<?php echo $Record['DiscountAmount'];?>" min="0" step="0.01"></td>
		 <td><input type='number' id="RegularDiscount<?php print $SNo; ?>" class="RegularDiscount form-control" name='RegularDiscount[]' value="<?php echo $Record['RegularDiscount'];?>" min="0" step="0.01" readonly></td>
		 <td><input type='number' id="SaleDiscount<?php print $SNo; ?>" class="SaleDiscount form-control" name='SaleDiscount[]' value="<?php echo $Record['SaleDiscount'];?>" min="0" step="0.01" readonly></td>
		 
		 <td><input type='number' id="Discount<?php print $SNo; ?>" class="Discount form-control" name='Discount[]' value="<?php echo $Record['Discount'];?>" min="0" step="0.01"></td>
		 <td><input type='number' id="ODiscount<?php print $SNo; ?>" class="ODiscount form-control" name='ODiscount[]' value="<?php echo $Record['ODiscount'];?>" min="0" step="0.01"></td>
		 <td><input type='number' id="HoldingAmount<?php print $SNo; ?>" class="HoldingAmount form-control" name='HoldingAmount[]' value="<?php echo $Record['HoldingAmount'];?>" min="0" step="0.01"></td>
		 
		 <td><input type='number' id="NetAmount<?php print $SNo; ?>" class="NetAmount form-control final-value" name='NetAmount[]' value="<?php echo $Record['NetAmount'];?>" min="0" step="0.01" readonly></td>
		 <td><input type='text' id="Comments<?php print $SNo; ?>" name='Comments[]' value="<?php echo $Record['Comments']; ?>" class="form-control"></td>
		 <td><?php if($SNo != 1) { ?><span style='color:red;' id='remove_<?php echo $SNo; ?>' class='fa fa-times-circle'></span><?php } ?></td>
		</tr>
		<?php 
		    $Quantity += $Record['Quantity'];
        	$Amount += $Record['Amount'];
        	$DiscountAmount += $Record['DiscountAmount'];
        	$NetAmount += $Record['NetAmount'];
		  	$SNo++;
		} ?>
		
		<!-- Totals Row -->
		<tr class="total-row">
		  <td colspan="4" style="text-align: right; font-weight: bold;">TOTALS:</td>
		  <td id="totalQuantity"><?php echo number_format($Quantity,2,'.',''); ?></td>
		  <td id="totalAmount"><?php echo number_format($Amount,2,'.',''); ?></td>
		  <td>-</td>
		  <td id="totalGstAmount"><?php echo number_format($DiscountAmount,2,'.',''); ?></td>
		  <td id="totalValueInclGst"><?php echo number_format($Amount + $DiscountAmount,2,'.',''); ?></td>
		  <?php 
		  	$totalDiscount = 0;
		  	$totalODiscount = 0;
		  	$totalHoldingAmount = 0;
		  	foreach($PurchaseDetail as $Record) {
		  		$totalDiscount += $Record['Discount'];
		  		$totalODiscount += $Record['ODiscount'];
		  		$totalHoldingAmount += $Record['HoldingAmount'];
		  	}
		  ?>
		  <td id="totalDiscount"><?php echo number_format($totalDiscount,2,'.',''); ?></td>
		  <td id="totalODiscount"><?php echo number_format($totalODiscount,2,'.',''); ?></td>
		  <td id="totalHoldingAmount"><?php echo number_format($totalHoldingAmount,2,'.',''); ?></td>
		  <td id="totalFinalValue"><?php echo number_format($NetAmount,2,'.',''); ?></td>
		  <td colspan="2">-</td>
		</tr>
		
		<input type="hidden" name="SNo" id="SNo" class="form-control" value="<?php echo $SNo; ?>">
	    </tbody>
	    </table>

		  <div style="height: 30px;"></div>
      
      <span style="cursor:pointer; color:white; font-weight:600;" id="addRow" class="fa fa-plus"> Add New Row</span>

      <div style="height: 30px;"></div>
      
      <table class="table" border="0">
        <tbody>
 
        </tbody>
      </table>

		  </div>
		</div>
	      </div>

<div class="box-footer" style="background: transparent; padding: 20px 0; margin-top: 25px; border-top: 1px solid #eaeaea;">
  <div class="row">
    <div class="col-md-12">
      <div class="d-flex justify-content-start align-items-center gap-2">
        <button type="submit" name="submitForm" value="UpdatePurchaseRecord" id="UpdateRecordBtn" 
                class="btn" 
                style="background: linear-gradient(135deg, #28a745 0%, #20c997 100%); 
                       color: white; 
                       border: none; 
                       border-radius: 6px; 
                       padding: 10px 20px; 
                       font-weight: 600; 
                       font-size: 14px;
                       transition: all 0.3s ease;
                       box-shadow: 0 3px 10px rgba(40, 167, 69, 0.25);">
          <i class="fa fa-edit mr-2"></i> Update Record
        </button>
        
        <a href="<?php echo base_url(); ?>Purchase/" 
           class="btn" 
           style="background: linear-gradient(135deg, #dc3545 0%, #c82333 100%); 
                  color: white; 
                  border: none; 
                  border-radius: 6px; 
                  padding: 10px 20px; 
                  font-weight: 600; 
                  font-size: 14px;
                  transition: all 0.3s ease;
                  box-shadow: 0 3px 10px rgba(220, 53, 69, 0.25);
                  text-decoration: none;
                  display: inline-block;">
          <i class="fa fa-arrow-left mr-2"></i> Back to Main
        </a>
      </div>
    </div>
  </div>
</div>

<style>
  .btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(0,0,0,0.2);
  }
  
  #UpdateRecordBtn:hover {
    background: linear-gradient(135deg, #20c997 0%, #28a745 100%) !important;
    box-shadow: 0 5px 15px rgba(40, 167, 69, 0.35) !important;
  }
  
  .btn[style*="dc3545"]:hover {
    background: linear-gradient(135deg, #c82333 0%, #dc3545 100%) !important;
    box-shadow: 0 5px 15px rgba(220, 53, 69, 0.35) !important;
  }
  
  .btn:active {
    transform: translateY(0);
    box-shadow: 0 2px 8px rgba(0,0,0,0.15);
  }
</style>
	      </div>
            </form>
        </div>
      </div>
    </div> 
  </section>
  </div>

        </form>
            </div>
    </div>
</div>
</section>
</div>


 <script>
 $(function(){
 
     var counter = $("#SNo").val();
    // Add New Row class="txtMult"
    $("#addRow").on("click",function(){
	
	var newRow = $("<tr class='txtMult'>");
    var cols = "";

/*    var txtId = $("input[id^=NetAmount]:last").attr("id");
    var arr = txtId.split("_");
    var nextTxtId = (parseInt(arr[1]) +1);*/
     
  cols += '<td style="margin-top:15px;line-height:25px">' + counter + '</td>';
  cols += '<td><input style="width:130px;margin-top:1px;" class="select2" type="text" id="ProductName_'+ counter +'" name="ProductName[]"><input style="width:90%;" type="hidden" id="hdnProductName_'+ counter +'" name="ProductId[]"></td>';
  cols += '<td style="text-align:center;"><input style="width:95%; margin-top:1px;" class="select2" type="text" id="LocationName_'+ counter +'" name="LocationName_[]"><input style="width:90%;" type="hidden" id="hdnLocationName_'+ counter +'" name="LocationId[]"></td>';
  //cols += '<td style="text-align:center;"><input style="width:95%; margin-top:1px;" class="select2" type="text" id="ColourName_'+ counter +'" name="ColourName[]"><input style="width:90%;" type="hidden" id="hdnColourName_'+ counter +'" name="ColourId[]"></td>';
  cols += '<td><input style="width:90%; margin-top:1px; text-align:right;" type="number" id="Rate'+ counter +'" class="Rate" name="Rate[]" autocomplete="off" min="0" step="0.01"></td>';
  cols += '<td><input style="width:100%; margin-top:1px; text-align:right;" type="number" id="Quantity'+ counter +'" class="Quantity" name="Quantity[]" autocomplete="off" min="0" step="0.01"></td>';
  cols += '<td><input style="width:90%; margin-top:1px; text-align:right;" type="number" id="Amount'+ counter +'" class="Amount" name="Amount[]" min="0" step="0.01"></td>';
  cols += '<td><input style="width:90%; margin-top:1px; text-align:right;" type="number" id="DiscountAmount'+ counter +'" class="DiscountAmount" value="18" name="DiscountAmount[]" min="0" step="0.01"></td>';
  cols += '<td><input style="width:90%; margin-top:1px; text-align:right;" type="number" id="RegularDiscount'+ counter +'" class="RegularDiscount" name="RegularDiscount[]" min="0" step="0.01"></td>';
  cols += '<td><input style="width:90%; margin-top:1px; text-align:right;" type="number" id="SaleDiscount'+ counter +'" class="SaleDiscount" name="SaleDiscount[]" min="0" step="0.01"></td>';
  
  
  cols += '<td><input style="width:90%; margin-top:1px; text-align:right;" type="number" id="Discount'+ counter +'" value= "0" class="Discount" name="Discount[]" min="0" step="0.01"></td>';
  cols += '<td><input style="width:90%; margin-top:1px; text-align:right;" type="number" id="ODiscount'+ counter +'"  value= "0" class="ODiscount" name="ODiscount[]" min="0" step="0.01"></td>';
  cols += '<td><input style="width:90%; margin-top:1px; text-align:right;" type="number" id="HoldingAmount'+ counter +'" value= "0" class="HoldingAmount" name="HoldingAmount[]" min="0" step="0.01"></td>';
  
  cols += '<td><input style="width:100%; margin-top:1px; text-align:right;" type="number" id="NetAmount'+ counter +'" class="NetAmount" name="NetAmount[]" min="0" step="0.01"></td>';
  cols += '<td><input style="width:215px; text-align:left; margin-top:1px;" type="text" id="Comments_'+ counter +'" name="Comments[]"></td>'
  cols += '<td style="width:70px;text-align:right; cursor:pointer; color:red;"><i class="fa fa-times-circle remove" id="remove_'+ counter +'" title="Delete" style="margin-top:1px;"></i></td>';

    	newRow.append(cols);
    		$("#Purchase_EntriesTable").append(newRow);
    	counter++;
     });

    // Start Remove row script
    $("#Purchase_EntriesTable").on("click", ".remove", function (event) {
        $(this).closest("tr").remove();       
        counter -= 1
    });

  });
 </script>
  <script>
 $(function(){
     
  // Autocomplete Search Product Name
  $('body').on("keyup", "input[id^=ProductName]", function(){
      
            var  ProductId  = ($(this).attr('id'));
            var  ProductName = $(this).val();
      
            $(this).autocomplete({
    
                source: function(request, response)   {
                    $.ajax({
                        url: "<?php echo site_url('Purchase/AutoCompleteProductList')?>",
                        data: { ProductName:ProductName},
                        dataType: "json",
                        type: "POST",
                        success: function(data) {
                         response(data);
                        }
                    });
                },
		    select: function (event,ui) {
                    $(this).val(ui.item.value); // display the selected text
                    $("#hdn"+ProductId).val(ui.item.id); // save selected id to hidden input
    },
                minLength: 2
            });
        });
	
 /* $(document).on('keyup','input[id^=ProductId]',function(){
    
    var ProductId = ($(this).attr('id'));
    var  ProductName= $(this).val();
    
    $(this).autocomplete({
    
    source: function(request, response) {
    $.ajax({
        url: "<?php // echo site_url('Purchase/AutoCompleteProductList'); ?>",
        data: { ProductName:ProductName},
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
//     alert(ui.item.id);
     var id = $(this).attr('id');
     var Attr = id.split("_");
     window.IdAttr = Attr[1];
     $("#hdn"+ProductId).val(ui.item.id); // save selected id to hidden input
     window.PId = ui.item.id;
    },
    minLength: 2
     });    
    });
    */


  	var counter = 0;
  	$(document).on('focusout','input[id^=ProductId]',function(){
  		var VendorId = $("#VendorId").val();
  		if(VendorId == "0"){
  			alert("Please Select Vendor");
  			$('input').val('');
  		return;
  		}
  	else{
  		var PId2 = window.PId;
  		var IdR = window.IdAttr;
  		var Rate =
		$.ajax({
			url: '<?php echo base_url(); ?>Purchase/GetProductRate',
			data:{Product:PId2,VendorId:VendorId},
			type: 'post',
			dataType: 'html',
			success:function(data){
				var SN = $("#SN").val();
				if(data == "0"){
					alert("Rate is not defined for this vendor/product");
				}
				else{
					if(PId2 != 0){
					counter++;
					$("#Rate_"+IdR).val(data);
					}
					else{
					$("#Rate_"+IdR).val('0');
					}
					window.PId = 0;
				}
			}
		})
		}
  	})

  });
 </script>
 
 <script>
     
 $(function(){

    

     // Auto Select Location List
     $('body').on("keyup", "input[id^=LocationName]", function(){
      
            var  LocationId  = ($(this).attr('id'));
            var  LocationName = $(this).val();
      
            $(this).autocomplete({
    
                source: function(request, response)   {
                    $.ajax({
                        url: "<?php echo site_url('Purchase/AutoCompleteLocationList')?>",
                        data: { LocationName:LocationName},
                        dataType: "json",
                        type: "POST",
                        success: function(data) {
                         response(data);
                        }
                    });
                },
                select: function (event,ui) {
                    $(this).val(ui.item.value); // display the selected text
                    $("#hdn"+LocationId).val(ui.item.id); // save selected id to hidden input
    },
                minLength: 2
            });
        });
  
  
     // Auto Select Colour List
     $('body').on("keyup", "input[id^=ColourName]", function(){
      
            var  ColourId  = ($(this).attr('id'));
            var  ColourName = $(this).val();
      
            $(this).autocomplete({
    
                source: function(request, response)   {
                    $.ajax({
                        url: "<?php echo site_url('Purchase/AutoCompleteColourList')?>",
                        data: { ColourName:ColourName},
                        dataType: "json",
                        type: "POST",
                        success: function(data) {
                         response(data);
                        }
                    });
                },
                select: function (event,ui) {
                    $(this).val(ui.item.value); // display the selected text
                    $("#hdn"+ColourId).val(ui.item.id); // save selected id to hidden input
    },
                minLength: 2
            });
        });

            $('body').on('change', 'input[id^=LocationName]', function(){
                var LocationId = $('input[name^=LocationId]').val();
                var ProductId = $('input[name^=ProductId]').val();

                $.ajax({
                   type: 'POST',
                   dataType: 'html',
                   data: ('LocationId='+LocationId+'&ProductId='+ProductId),
                   url: "<?php echo base_url('Purchase/GetRemainingProduct'); ?>",
                   success: function(response){
                    $('#RemainingStock').html(response);
                   }
                });
            });


});



</script>
<?php $this->load->view('includes/footer'); ?>
<script>
	$(function(){

     $('body').on("keyup",".txtMult input", multInputs);
    
       function multInputs() {
     
    var TotalQuantity = 0;
    var TotalDiscount = 0;
    var TotalTaxAmount = 0;
    var TotalAmount = 0;
    var NetAmount = 0;
    var TotalNetAmount = 0;

    $('tr.txtMult').each(function () {

      
      var Quantity = $('.Quantity', this).val();
      var Rate = $('.Rate', this).val();
      var DiscountAmount = $('.DiscountAmount', this).val();
     
     
      var Amount = $('.Amount', this).val();
      
  $('.RegularDiscount', this).val((DiscountAmount*(Amount/100)).toFixed(2));
   var RegularDiscount = $('.RegularDiscount', this).val();
   var RegularDiscount = (isNaN(parseFloat(RegularDiscount))) ? 0 : parseFloat(RegularDiscount);
   
          $('.SaleDiscount', this).val(parseFloat(RegularDiscount)+parseFloat(Amount));
          var SaleDiscount = $('.SaleDiscount', this).val();
          
      var QuantityVal = (isNaN(parseFloat(Quantity))) ? 0 : parseFloat(Quantity);
      var RateVal = (isNaN(parseFloat(Rate))) ? 0 : parseFloat(Rate);
      var DiscountAmount = (isNaN(parseFloat(DiscountAmount))) ? 0 : parseFloat(DiscountAmount);
     
      var SaleDiscountVal = (isNaN(parseFloat(SaleDiscount))) ? 0 : parseFloat(SaleDiscount);
      
      DiscountAmountVal = (DiscountAmount+SaleDiscountVal);
      
      

      var Amount = (QuantityVal * 1) * (RateVal * 1);

/*      var TaxAmount = ((Amount * TaxPercentage) / 100); 
      $('.TaxAmount',this).val((TaxAmount).toFixed(2));
      TotalTaxAmount += TaxAmount;*/
      
      if(DiscountAmountVal != 0) 
      {
     NetAmount = (Amount - DiscountAmountVal);
      }
      else
      {
     NetAmount = (Amount);
      }
      
      $('.Amount',this).val(Amount);
      
      
    var Discount=$('.Discount',this).val();
    var ODiscount=$('.ODiscount',this).val();
    var HoldingAmount=$('.HoldingAmount',this).val();
     
     $('.NetAmount',this).val(parseFloat(SaleDiscountVal) - parseFloat(Discount) - parseFloat(ODiscount) + parseFloat(HoldingAmount) );
     
    //   $('.NetAmount',this).val(NetAmount);
       //TotalQuantity = (TotalQuantity * 1) + (QuantityVal * 1);
      TotalQuantity += QuantityVal;
      TotalDiscount += DiscountAmountVal;
      TotalAmount += Amount;
      TotalNetAmount += NetAmount;

  });
        $('#Quantity').text((TotalQuantity).toFixed(2))
        $('#Amount').text((TotalAmount).toFixed(2))
        $('#DiscountAmount').text((TotalDiscount).toFixed(2));
        $('#TotalAmount').text((TotalNetAmount).toFixed(2));

       }
  });  

</script>