<?php $this->load->view('includes/header'); ?>
<?php $this->load->view('includes/sidebar'); ?>
<?php 
$References = '<select name="ReferenceId" style="width:200px; margin-top:1px;">';
$References .= '<option value="0">Select Transportation</option>';
foreach ($AllReferences as $ReferenceRecord) {
$References .= '<option value='.$ReferenceRecord['ReferenceId'].'>'.$ReferenceRecord['FullName'].'</option>';
}
$References .= '</select>';
date_default_timezone_set('Asia/Karachi');


// Customer List showing in product detail row
$Customers = '<select name="CustomerId" style="width:215px; margin-top:1px;" required="required" class="form-control select2">';
$Customers .= '<option value="">Select Customer</option>';
foreach ($AllCustomers as $CustomerRecord) {
    $selected = ($CustomerRecord['CustomerId'] == $Sales->CustomerId) ? 'selected="selected"' : '';
    $Customers .= '<option value="' . $CustomerRecord['CustomerId'] . '-' . $CustomerRecord['ChartOfAccountId'] . '" ' . $selected . '>' . $CustomerRecord['CustomerName'] . '</option>';
}
$Customers .= '</select>';
?>

      <!-- /.main-content starts -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1><i class="fa fa-shopping-cart"></i>&nbsp;Sales Return</h1>
    </section>
    
    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-md-12">
          <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title text-light-blue">Add Sales Return</h3>
            </div>
      <?php echo "<font style=color:#00468E; font-weight:bold text-align:center;>".$this->session->flashdata('record_update')."</font>"; ?>
<?php  $id = $Sales->SaleId; ?>

     <form class="form-horizontal" method="post" action="<?php echo base_url("SalesReturn/SaveSalesReturn"); ?>" name="basic_validate" id="basic_validate" novalidate="novalidate">
     <input type="hidden" name="SaleId" value="<?php echo $Sales->SaleId; ?>">
     <input type="hidden" name="SaleNo" value="<?php echo $Sales->SaleNo; ?>">
                    
      <div class="box-body">
        <div class="row invoice-info">
    <div class="col-sm-3 invoice-col">
      <address>
        <strong>Invoice #:</strong><br>
          <span style="color:#3333CC; font-size:13px; font-weight:bold;"><?php echo $Sales->SaleId; ?></span>
      </address>
    </div>
    
    <div class="col-sm-3 invoice-col">
      <address>
        <strong>Select Counter:</strong><br>
        <select name="Counter" id="Counter" style="width:215px;" class="form-control select2" required="required">
          <option <?php echo $Sales->Counter == 1 ? 'selected=selected' : ''; ?> value="1">Counter One</option>
          <option <?php echo $Sales->Counter == 2 ? 'selected=selected' : ''; ?> value="2">Counter Two</option>
          <option <?php echo $Sales->Counter == 3 ? 'selected=selected' : ''; ?> value="3">Counter Three</option>
        </select>
      </address>
    </div>

    <div class="col-sm-3 invoice-col">
    
       <address>
        <strong>Sale Return Type:</strong><br>
			 <select name="SaleReturnType" id="SaleReturnType" style="width:215px;" class="form-control" required="required">
        <option selected="selected" value=""> Select Return Type </option>
			    <option value="1" <?php if($Sales->SaleType == '1'){ echo "selected";} ?>>On Cash</option>
          <option value="2" <?php if($Sales->SaleType == '2'){ echo "selected";} ?>>On Credit</option>
			    <option value="3" <?php if($Sales->SaleType == '3'){ echo "selected";} ?>>Online</option>
		    </select>
      </address>
    </div>
    <input type="hidden" name="SaleType" id="SaleType" value="<?php echo $Sales->SaleType; ?>">

   
    <div class="col-sm-3 invoice-col">
      <address>
        <strong>Buyer Name / Customer Name:</strong><br>
       <?php echo $Customers ?>
          <a href="<?php echo base_url(); ?>Customer/AddCustomer/" target="_blank"><span  style="cursor:pointer; color:darkgreen; font-weight:600;" id="addrow" class=""></span></a>
      </address>
    </div>


    
    <div class="col-sm-3 invoice-col" style="border: 0px solid;">
      <address>
        <strong>Bank Account:</strong>
          <select name="BankAccountId" class="form-control select2" style="width:215px; margin-top:1px;" >
        <option value="0"> Select Bank Account</option>
        <?php
          foreach ($GetAllBankAccounts as $BankAccounts) {
        ?>
        <option <?php if($Sales->AccountId == $BankAccounts['AccountId']) { echo 'selected=selected'; } else { echo ''; } ?> value="<?php echo $BankAccounts['AccountId'] . "-" .$BankAccounts['ChartOfAccountId']; ?>"><?php echo $BankAccounts['AccountTitle'] . " - " . $BankAccounts['AccountNumber'];  ?></option>
        <?php
        } ?>
        </select>
      </address>
    </div><!-- /.form-group -->

    <div class="col-sm-3 invoice-col">
      <address>
        <strong>Transportation:</strong><br>
          <select name="ReferenceId" id="ReferenceId" style="width:215px; margin-top:1px;" class="form-control select2">
            <option value="0"> Select Transportation</option>
            <?php foreach ($AllReferences as $ReferenceRecord) { ?>
              <option value="<?php echo $ReferenceRecord['ReferenceId']; ?>"<?php if($Sales->ReferenceId == $ReferenceRecord['ReferenceId']) echo "selected=selected"; ?>><?php echo $ReferenceRecord['FullName'];?></option>
            <?php } ?>
          </select>
      </address>
    </div>

 <div class="col-sm-3 invoice-col">
      <address>
        <strong>Sale Mode:</strong><br>
          <select name="SaleMethod" id="SaleMethod" style="width:215px;" class="form-control select2" required="required">
            <option <?php if($Sales->SaleMethod == "Wholesale"){ echo "selected=selected";} ?> value="Wholesale">Wholesale</option>
            <option <?php if($Sales->SaleMethod == "Retail"){ echo "selected=selected";} ?> value="Retail">Retail</option>
          </select>
      </address>
    </div>

            <input class="form-control" name="MobileNumber" id="MobileNumber" type="hidden" style="width:215px;" value="<?php echo $Sales->MobileNumber; ?>" autocomplete="off">
                <input class="form-control" name="CustomerName" id="CustomerName" type="hidden" style="width:215px;" value="<?php echo $Sales->WalkinCustomer; ?>" autocomplete="off">

    <div class="col-sm-3 invoice-col">
      <address>
        <strong>Sale Date:</strong><br>
 <input class="form-control" id="datepicker1" type="datetime-local" name="SaleReturnDate" value="<?php echo date('Y-m-d\TH:i', strtotime($Sales->SaleDate)); ?>" style="width:215px;" >
                
          <!--<input class="form-control" id="datepicker1" type="datetime-local" name="SaleDate" value="<?php echo date("m/d/Y H:i:s", strtotime($Sales->SaleDate)); ?>" style="width:215px; " >-->
        </address>
    </div><!-- /.form-group -->
    
    <div class="col-sm-3 invoice-col">
      <address>
        <strong>Sale Status:</strong><br>
        <select name="SaleStatus" id="SaleStatus" style="width:215px;" class="form-control select2" required="required">
          <option <?php echo $Sales->SaleStatus == "Confirm" ? 'selected=selected' : ''; ?> value="Confirm">Confirm</option>
          <option <?php echo $Sales->SaleStatus == "Cancel" ? 'selected=selected' : ''; ?> value="Cancel">Cancel</option>
        </select>
      </address>
    </div>

    <div class="col-sm-3 invoice-col">
      <address>
        <strong>Sale Note:</strong><br>
        <input class="form-control" name="SaleReturnNote" id="SaleNote" type="text" style="width:215px;" value="<?php echo $Sales->SaleNote; ?>" autocomplete="off">
      </address>
    </div>

    <div class="col-sm-3 invoice-col" style="border: 0px solid;">
      <address>
        <strong>Saleman:</strong><br>
          <select name="SalemanId" class="form-control select2" style="width:215px; margin-top:1px;" >
        <option value="0"> Select Saleman</option>
        <?php
          foreach ($GetAllSaleman as $AllSaleman) {
        ?>
        <option <?php if($Sales->SalemanId == $AllSaleman['SalemanId']) { echo 'selected=selected'; } else { echo ''; } ?> value="<?php echo $AllSaleman['SalemanId'].'-'.$AllSaleman['ChartOfAccountId']; ?>"><?php echo $AllSaleman['SalemanName'];  ?></option>
        <?php
        } ?>
        </select>
      </address>
    </div><!-- /.form-group -->
<div class="col-sm-12">
    <h4 style="color: #2e7d32; font-weight: 600; border-bottom: 2px solid #2e7d32; padding-bottom: 8px; margin-bottom: 20px;">
        FBR Information
    </h4>
</div>

<div class="col-sm-12" style="display: flex; flex-wrap: wrap; gap: 15px; margin-bottom: 20px;">
    <input class="form-control" name="FbrNo" id="FbrNo" type="hidden" value="<?php echo $Sales->FbrNo; ?>" autocomplete="off">
    
    <div class="form-group" style="flex: 1; min-width: 200px;">
        <label for="fbr_customer" style="display: block; margin-bottom: 6px; font-weight: 600; color: #555;">Address:</label>
        <input class="form-control" name="fbr_customer" id="fbr_customer" type="text" 
               style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px;" 
               value="<?php echo $Sales->fbr_customer; ?>" placeholder="Enter customer address" autocomplete="off">
    </div>
    
    <div class="form-group" style="flex: 1; min-width: 200px;">
        <label for="fbr_cnic" style="display: block; margin-bottom: 6px; font-weight: 600; color: #555;">ST Registration No.:</label>
        <input class="form-control" name="fbr_cnic" id="fbr_cnic" type="text" 
               style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px;" 
               value="<?php echo $Sales->fbr_cnic; ?>" placeholder="Enter ST registration number" autocomplete="off">
    </div>
    
    <div class="form-group" style="flex: 1; min-width: 180px;">
        <label for="fbr_mobile" style="display: block; margin-bottom: 6px; font-weight: 600; color: #555;">Mobile:</label>
        <input class="form-control" name="fbr_mobile" id="fbr_mobile" type="text" 
               style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px;" 
               value="<?php echo $Sales->fbr_mobile; ?>" placeholder="Enter mobile number" autocomplete="off">
    </div>
    
    <div class="form-group" style="flex: 1; min-width: 180px;">
        <label for="fbr_ntn" style="display: block; margin-bottom: 6px; font-weight: 600; color: #555;">NTN:</label>
        <input class="form-control" name="fbr_ntn" id="fbr_ntn" type="text" 
               style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px;" 
               value="<?php echo $Sales->fbr_ntn; ?>" placeholder="Enter NTN number" autocomplete="off">
    </div>
</div>

<div class="col-sm-6 invoice-col">
    <address>
        <div style="font-weight:600;" class="col-sm-8" id="AccountReceivable"></div>
    </address>
</div>

<table>
    <tr>
        <!--<input style='width:15%; margin-top:1px;' type="text" id="txtCode" class="barcodeinput" autocomplete="off" placeholder="enter barcode"/> <!--<input type="button" value="OK" class="nextcontrol"/> -->
        </td>
        <td> <a href="<?php echo base_url(); ?>Product/AddProduct/" target="_blank"><span  style="cursor:pointer; color:darkgreen; font-weight:600;" class=""></span></a></td>
    </tr>
</table>

<div class="row" style="display: block;" id="mainRow">
    <div class="col-md-12">
        <div class="box-body pad table-responsive">
            <table class='table table-bordered text-center' id="Sale_EntriesTable">
                <thead>
                    <tr style="background: linear-gradient(to bottom, #f8f9fa, #e9ecef);">
                        <th style="width:2%; padding: 10px; border-top: 1px solid #dee2e6; border-bottom: 2px solid #dee2e6; font-weight: 600; color: #495057;">S.#</th>
                        <th style="padding: 10px; width:10%; text-align: left; border-top: 1px solid #dee2e6; border-bottom: 2px solid #dee2e6; font-weight: 600; color: #495057;">Item</th>
                        <th style="padding: 10px; width:10%; text-align: left; border-top: 1px solid #dee2e6; border-bottom: 2px solid #dee2e6; font-weight: 600; color: #495057;">Location</th>
                        <th style="padding: 10px; width:10%; border-top: 1px solid #dee2e6; border-bottom: 2px solid #dee2e6; font-weight: 600; color: #495057;">Rate</th>
                        <th style="padding: 10px; width:10%; border-top: 1px solid #dee2e6; border-bottom: 2px solid #dee2e6; font-weight: 600; color: #495057;">Qty</th>
                        <th style="padding: 10px; width:10%; border-top: 1px solid #dee2e6; border-bottom: 2px solid #dee2e6; font-weight: 600; color: #495057;">Amount</th>
                        <th style="padding: 10px; width:10%; border-top: 1px solid #dee2e6; border-bottom: 2px solid #dee2e6; font-weight: 600; color: #495057;">GST Rate %</th>
                        <th style="padding: 10px; width:10%; border-top: 1px solid #dee2e6; border-bottom: 2px solid #dee2e6; font-weight: 600; color: #495057;">GST Amount %</th>
                        <th style="padding: 10px; width:10%; border-top: 1px solid #dee2e6; border-bottom: 2px solid #dee2e6; font-weight: 600; color: #495057;">Discount Total</th>
                        <th style="padding: 10px; width:10%; border-top: 1px solid #dee2e6; border-bottom: 2px solid #dee2e6; font-weight: 600; color: #495057;">Net Amount</th>
                        <th style="padding: 10px; width:2%; border-top: 1px solid #dee2e6; border-bottom: 2px solid #dee2e6; font-weight: 600; color: #495057; text-align: center;">Delete</th>
                    </tr>
		<?php
		$SNo = 1; 
		$TotalNetAmount = 0;
    $Quantity = 0;
    $Amount = 0;
    $DiscountAmount = 0;
    $TaxAmount = 0;
    $NetAmount = 0;
		foreach($SalesDetail as $Record) {
		 ?>
		<tr class="txtMult">
		 <td style="margin-top:15px;line-height:25px"><?php echo $SNo; ?></td>
		 <td>
		  <input style='width:90px;margin-top:1px;' type='text' name="ProductName[]" id="ProductName_<?php echo $SNo?>" autocomplete="off"value="<?php echo $Record['ProductName'];?>">
		  <input type='hidden' id="hdnProductName_<?php echo $SNo; ?>" name="ProductId[]" value="<?php echo $Record['ProductId'];?>">
		 </td>
		 <td>
		  <input style='width:90%;margin-top:1px;' type='text' id="LocationName_<?php echo $SNo?>" autocomplete="off" value="<?php echo $Record['LocationName'];?>" >
		 <input type='hidden' id="hdnLocationName_<?php echo $SNo?>" name="LocationId[]" value="<?php echo $Record['LocationId'];?>"> 
		 </td>
		 <td><input style='width:100%; margin-top:1px;' type='text' id="Rate<?php print $SNo; ?>" class="Rate" name='Rate[]' autocomplete="off" value="<?php echo $Record['Rate'];?>" min="0"></td>
		 <td style="text-align:center;"><input style='width:90%;margin-top:1px; text-align:right;' type='text' id="Quantity<?php print $SNo; ?>" class="Quantity" name='Quantity[]' autocomplete="off" value="<?php echo $Record['Quantity'];?>" min="0"></td>
		 <td><input style='width:90%; margin-top:1px; text-align:right;' type='text' id="Amount<?php print $SNo; ?>" class="Amount" name='Amount[]' value="<?php echo $Record['Amount'];?>" min="0"></td>
		 <td><input style='width:90%; margin-top:1px; text-align:right;' type='text' id="DiscountAmount<?php print $SNo; ?>" class="DiscountAmount" name='DiscountAmount[]' value="<?php echo $Record['DiscountAmount'];?>" min="0"></td>
		<td><input style='width:90%; margin-top:1px; text-align:right;' type='text' id="TaxPercentage<?php print $SNo; ?>" class="TaxPercentage" name='TaxPercentage[]' min="0" value="<?php echo $Record['TaxPercentage'];?>"></td>
		<td><input style='width:90%; margin-top:1px; text-align:right;' type='text' id="TaxAmount<?php print $SNo; ?>" class="TaxAmount" name='TaxAmount[]' min="0" value="<?php echo $Record['TaxAmount'];?>"></td>
		 <td><input style='width:90%; margin-top:1px; text-align:right;' type='text' id="Amount<?php print $SNo; ?>" class="NetAmount" name='NetAmount[]' value="<?php echo $Record['NetAmount'];?>" min="0"></td>
		 <td style="text-align:center; cursor:pointer; color:red;"><i class="fa fa-trash remove" title="Delete" style="margin-top:1px;"></i></td>
		</tr>
		<?php 
		    $Quantity += $Record['Quantity'];
		    $Amount += $Record['Amount'];
		    $DiscountAmount += $Record['TaxPercentage'];
		    $TaxAmount += $Record['TaxAmount'];
		    $NetAmount += $Record['NetAmount'];
		  $SNo++;
		} ?>
		<input type="hidden" name="SNo" id="SNo" class="form-control" value="<?php echo $SNo; ?>">
	    </table>
  <div style="height: 50px;"></div>
       <table class="table" border="0">
              <tbody>
                        <tr>
         <td colspan="11">
     <span style="cursor:pointer; color:darkgreen; font-weight:600;" id="addrow" class="fa fa-plus">Add Row</span>
         </td>
         <td id="RemainingStock"></td>
        </tr>
	<tr>
          <input type="hidden" name="total_tax" id="total_tax" value="<?php echo number_format($Record['TotalDiscount'],2,'.',''); ?>" />
          <td colspan="12" style="width: 90%; text-align:right; font-weight:600; border: 0px solid;">Total Discount:</td>
          <td><div id="DiscountAmount" style='font-weight:600; text-align:right; color:#008000;'><?php echo number_format($TaxAmount); ?></div></td>
        </tr>
       <?php if($Sales->SaleType == "2"){ ?>
        <tr id="cash-received">
          <td colspan="12" style="width: 90%; text-align:right; font-weight:600; border: 0px solid;">Cash Received:</td>
          <td><div id="cashreceived" style='font-weight:600; text-align:right; color:#008000;'><input id="cash_received" type="number" name="cash_received" value="<?php echo ($Sales->SaleType != "2") ? 0 : ((!empty($CashDetail)) ? number_format($CashDetail[0]['Debit'],2,'.','') : 0); ?>"></div></td>
        </tr>
        <?php } ?>
        <tr>
          <td colspan="12" style="width: 90%; text-align:right; font-weight:600; border: 0px solid;">Total Quantity:</td>
          <td><div id="Quantity" style='font-weight:600; text-align:right; color:#008000;'><?php echo number_format($Quantity,2,'.',''); ?></div></td>
        </tr>

        <tr>
          <td colspan="12" style="width: 90%; text-align:right; font-weight:600; border: 0px solid;">Total Amount:</td>
          <td><div id="Amount" style='font-weight:600; text-align:right; color:#008000;'><?php echo number_format($Amount,2,'.',''); ?></div></td>
        </tr>

        <tr>
          <td colspan="12" style="width: 90%; text-align:right; font-weight:600; border: 0px solid;">Total GST Amount:</td>
          <td><div id="TotalGSTAmount" style='font-weight:600; text-align:right; color:#008000;'><?php echo number_format($DiscountAmount,2,'.',''); ?></div></td>
        </tr>

      

        <tr>
          <td colspan="12" style="width: 90%; text-align:right; font-weight:600; border: 0px solid;">Total Actual Sale Amount:</td>
          <td><div id="TotalAmount" style='font-weight:600; text-align:right; color:#008000;'><?php echo number_format($NetAmount,2,'.',''); ?></div></td>
        </tr>



        </tbody>
       </table>

<div class="box-body">
    <div class="row">
      <div class="col-md-2">
          <button type="submit" name="AddSaleReturnRecordBtn" value="AddSaleReturnRecord" id="AddRecord" class="btn btn-block btn-primary">Save Record</button>
      </div>
      <div class="col-md-2">
        <a href="<?php echo base_url(); ?>Sales/"><button type="button" name="" value="cancelUpdate" class="btn btn-block btn-primary">Back to Main</button></a>
      </div>
    </div>
        </div>


          </div>
	</div>
    						</div>
						</div>			
					</div>
				</div>
</div>
</form>
</section>

<?php
$this->load->view('includes/footer');
?>

<script src="<?php echo base_url();?>plugins/autocomplete/jquery-ui.js"></script>
<link rel="stylesheet" href="<?php echo base_url();?>plugins/autocomplete/jquery-ui.css" />

<script>
  $(document).ready(function () {
    var counter = $("#SNo").val();
    
    // Add New Row Script 
    $('body').on("click", "#addrow", function(e) {
	
        var newRow = $("<tr class='txtMult'>");
        var cols = "";
  cols += '<td style="margin-top:15px;line-height:25px">' + counter + '</td>';
  cols += '<td><input style="width:90px;margin-top:1px;" class="select2" name="ProductName[]" type="text" id="ProductName_'+ counter +'" name="ProductName[]"><input style="width:90%;" type="hidden" id="hdnProductName_'+ counter +'" name="ProductId[]"></td>'
  cols += '<td style="text-align:center;"><input style="width:90%; margin-top:1px;" class="select2" type="text" id="LocationName_'+ counter +'" name="LocationName_[]"><input style="width:90%;" type="hidden" id="hdnLocationName_'+ counter +'" name="LocationId[]"></td>';
 //  cols += '<td style="text-align:center;"><input style="width:90%; margin-top:1px;" class="select2" type="text" id="ColourName_'+ counter +'" name="ColourName[]"><input style="width:90%;" type="hidden" id="hdnColourName_'+ counter +'" name="ColourId[]"></td>';
  cols += '<td><input style="width:100%; margin-top:1px; text-align:right;" type="number" id="Rate'+ counter +'" class="Rate" name="Rate[]" autocomplete="off" min="0" step="0.01"></td>';
  cols += '<td><input style="width:90%; margin-top:1px; text-align:right;" type="number" id="Quantity'+ counter +'" class="Quantity" name="Quantity[]" autocomplete="off" min="0" step="0.01"></td>';
  cols += '<td><input style="width:90%; margin-top:1px; text-align:right;" type="number" id="Amount'+ counter +'" class="Amount" name="Amount[]" min="0" step="0.01"></td>';
  cols += '<td><input style="width:90%; margin-top:1px; text-align:right;" type="number" id="DiscountAmount'+ counter +'" class="DiscountAmount" name="DiscountAmount[]" min="0" value="18" step="0.01"></td>';
  cols += '<td><input style="width:90%; margin-top:1px; text-align:right;" type="number" id="TaxPercentage'+ counter +'" class="TaxPercentage" name="TaxPercentage[]" step="0.00"></td>';
  cols += '<td><input style="width:90%; margin-top:1px; text-align:right;" type="number" id="TaxAmount'+ counter +'" class="TaxAmount" name="TaxAmount[]" step="0.00"></td>';
  cols += '<td><input style="width:90%; margin-top:1px; text-align:right;" type="number" id="NetAmount'+ counter +'" class="NetAmount" name="NetAmount[]" min="0" step="0.01"></td>';
  cols += '<td style="text-align:center; cursor:pointer; color:red;"><i class="fa fa-trash remove" title="Delete" style="margin-top:1px;"></i></td>';

        newRow.append(cols);
        $("#Sale_EntriesTable").append(newRow);
        counter++;
    });
    
    // Start Remove row script
    $("#Sale_EntriesTable").on("click", ".remove", function (event) {
        $(this).closest("tr").remove();       
        counter -= 1
    });
    // End of Add new row script
   
     // Calculating total Quantity and Amount Script
             
     $('body').on("keyup",".txtMult input", multInputs);
    $('body').on("keyup","#totaltax", multInputs);
    
    function multInputs() {
     
    var TotalQuantity = 0;
    var TotalDiscount = 0;
    var TotalTaxAmount = 0;
    var TotalAmount = 0;
    var NetAmount = 0;
    var TotalNetAmount = 0;
    var total_tax=0
    var TotalGSTAmount =0;
    var TotalTaxAmount2 = 0;
    $('tr.txtMult').each(function () {

     // var SaleCartId = $('.SaleCartId', this).val();
      //var ProductId = $('.hdnProductId', this).val();
     
      var Quantity = $('.Quantity', this).val();
      var Rate = $('.Rate', this).val();
      var DiscountAmount = $('.DiscountAmount', this).val();

      var QuantityVal = (isNaN(parseFloat(Quantity))) ? 0 : parseFloat(Quantity);
      var RateVal = (isNaN(parseFloat(Rate))) ? 0 : parseFloat(Rate);
      var DiscountAmountVal = (isNaN(parseFloat(DiscountAmount))) ? 0 : parseFloat(DiscountAmount);

      var Amount = (QuantityVal * 1) * (RateVal * 1);      
      
//      alert(Quantity);
      
      /*
      $('.Quantity', this).on('keyup', function(){
	  
       var Quantity = $('.Quantity', this).val();
	$.ajax({
	type:"post",
	url:"<?php // echo base_url('Sales/AddUpdateProduct'); ?>",
	dataType: 'html',
	data:{ProductId:ProductId, Quantity:Quantity},
      });
      })
      */
      // Inserting product detail in sale cart table
           
      var $TaxAmount = $('.TaxAmount', this).val();
      var $TaxPercentage = $('.TaxPercentage', this).val();
      var $Tax = ((Amount * $TaxPercentage) / 100); 
      
    //   $('.TaxAmount',this).val(($Tax).toFixed(2));      
      
      if(DiscountAmountVal != 0) 
      {
	NetAmount = (Amount - DiscountAmountVal - $Tax);
      }
      else
      {
	NetAmount = (Amount - $Tax);
      }
      
   
      
       $('.Amount',this).val(Amount);
     
       $('.TaxPercentage',this).val((Amount*(DiscountAmountVal/100)).toFixed(2));
          var TaxPercentage = $('.TaxPercentage', this).val();
         $('.NetAmount',this).val(parseFloat(TaxPercentage)+parseFloat(Amount)-parseFloat($TaxAmount));
      

          var TaxAmount = $('.TaxAmount', this).val();
      var NetAmount = $('.NetAmount',this).val();
     
      TotalQuantity += QuantityVal;
      TotalDiscount += DiscountAmountVal;
      TotalAmount += parseFloat(Amount);
      TotalTaxAmount2 +=  parseFloat(TaxAmount);
      TotalNetAmount +=  parseFloat(NetAmount);  
      TotalGSTAmount+=  parseFloat(TaxPercentage);
  });

    var totaltax= $('#totaltax').val();
    console.log(totaltax);
    // if(totaltax!=0){
    //   // total_tax=((TotalNetAmount*totaltax)/100)
    //   total_tax=Number(totaltax)
    //   TotalNetAmount=TotalNetAmount-total_tax;
    //   TotalDiscount+=total_tax;
    // }
    //   alert(TotalNetAmount);
    // console.log('asdsadsa'+TotalTaxAmount2)
	      $('#TotalDiscount').val(TotalDiscount)
        $('#Quantity').text((TotalQuantity).toFixed(2))
        $('#Amount').text((TotalAmount).toFixed(2))
        $('#DiscountAmount').text((TotalTaxAmount2).toFixed(2));
        $('#TotalGSTAmount').text((TotalGSTAmount).toFixed(2));
        $('#TotalAmount').text((TotalNetAmount).toFixed(2));
      }
  });  

 $(function(){
    // Auto Select Produt List
    $('body').on("keyup", "input[id^=ProductName]", function(){
      
            var  ProductId  = ($(this).attr('id'));
            var  ProductName = $(this).val();
      
            $(this).autocomplete({
    
                source: function(request, response)   {
                    $.ajax({
                        url: "<?php echo site_url('Sales/AutoCompleteProductList')?>",
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
                   var id = $(this).attr('id');
                   var Attr = id.split("_");
                   window.IdAttr = Attr[1];
                   $("#hdn"+ProductId).val(ui.item.id); // save selected id to hidden input
                   window.PId = ui.item.id;
		},
                minLength: 2
            });
        }); 


        $(document).on('focusout','input[id^=ProductName]',function(){
            var id = $(this).attr('id');
            var Attr = id.split("_");
            var IdAttr = Attr[1];
            var PId2 = window.PId;

            $.ajax({
               type: 'POST',
               dataType: 'html',
//               data: ('LocationId='+LocationId+'&ProductId='+ProductId),
               data: ('ProductId='+PId2),
               url: "<?php echo base_url('Sales/GetRemainingProduct'); ?>",
               success: function(response){
//                $('#RemainingStock').html(response);
                $('#Quantity'+IdAttr).val(response);
               }
            });

        })

     // Auto Select Location List
     $('body').on("keyup", "input[id^=LocationName]", function(){
      
            var  LocationId  = ($(this).attr('id'));
            var  LocationName = $(this).val();
      
            $(this).autocomplete({
    
                source: function(request, response)   {
                    $.ajax({
                        url: "<?php echo site_url('Sales/AutoCompleteLocationList')?>",
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
                        url: "<?php echo site_url('Sales/AutoCompleteColourList')?>",
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
                   url: "<?php echo base_url('Sales/GetRemainingProduct'); ?>",
                   success: function(response){
                    $('#RemainingStock').html(response);
                   }
                });
            });


});


 $(function(){

        $("#basic_validate").submit(function(e){
          var SNo = 1;
            $("input[id^=ProductName]").each(function(){
            var ProductName = $(this).val();
              if(ProductName == '' || ProductName == 0)
              {
                //alert("Please fill this field");
                $(this).css('border-color', 'red');
                e.preventDefault();
                $(this).focus;
              }
              if(ProductName != '' || ProductName != 0){
                $(this).css('border-color', 'green');
              }
          SNo++;
            });
        });

	/*
        $("#basic_validate").submit(function(e){
          var SNo = 1;
            $("input[id^=LocationName]").each(function(){
            var LocationName = $(this).val();
              if(LocationName == '' || LocationName == 0)
              {
                 //alert("Please fill this field");
                 $(this).css('border-color', 'red');
                 e.preventDefault();
                 $(this).focus;
              }
              if(LocationName != '' || LocationName != 0){
                $(this).css('border-color', 'green');
              }
          SNo++;
            });
        });

        $("#basic_validate").submit(function(e){
          var SNo = 1;
            $("input[id^=ColourName]").each(function(){
            var ColourName = $(this).val();
              if(ColourName == '' || ColourName == 0)
              {
                 //alert("Please fill this field");
                 $(this).css('border-color', 'red');
                 e.preventDefault();
                 $(this).focus;
              }
              if(ColourName != '' || ColourName != 0){
                $(this).css('border-color', 'green');
              }
          SNo++;
            });
        });

	*/

        $("#basic_validate").submit(function(e){
          var SNo = 1;
            $("input[id^=Rate]").each(function(){
            var Rate = $(this).val();
              if(Rate == '' || Rate == 0)
              {
                 //alert("Please fill this field");
                 $(this).css('border-color', 'red');
                 e.preventDefault();
                 $(this).focus;
              }
              if(Rate != '' || Rate != 0){
                $(this).css('border-color', 'green');
              }
          SNo++;
            });
        });

        $("#basic_validate").submit(function(e){
          var SNo = 1;
            $("input[id^=Quantity]").each(function(){
            var Quantity = $(this).val();
              if(Quantity == '' || Quantity == 0)
              {
                 //alert("Please fill this field");
                 $(this).css('border-color', 'red');
                 e.preventDefault();
                 $(this).focus;
              }
              if(Quantity != '' || Quantity != 0){
                $(this).css('border-color', 'green');
              }
          SNo++;
            });
        });


          $("#basic_validate").submit(function(e){
          var SNo = 1;
            $("input[id^=CustomerId]").each(function(){
            var CustomerId = $(this).val();
              if(CustomerId == '' || CustomerId == "0")
              {
                 //alert("Please fill this field");
                 $(this).css('border-color', 'red');
                 e.preventDefault();
                 $(this).focus;
              }
              if(CustomerId != '' || CustomerId != 0){
                $(this).css('border-color', 'green');
              }
          SNo++;
            });
          });


      });    // end of main jQuery


 </script>