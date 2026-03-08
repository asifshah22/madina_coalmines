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
?>

      <!-- /.main-content starts -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1><i class="fa fa-shopping-cart"></i>&nbsp;Sales</h1>
    </section>
    
    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-md-12">
          <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title text-light-blue">Update Sale</h3>
            </div>
      <?php echo "<font style=color:#00468E; font-weight:bold text-align:center;>".$this->session->flashdata('record_update')."</font>"; ?>
<?php  $id = $Sales->SaleId; ?>
 <form class="form-horizontal" method="post" action="<?php echo base_url("Sales/UpdateSale"); ?>" name="basic_validate" id="basic_validate" novalidate="novalidate">
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
            <strong>Sale Type:</strong><br>
      <?php
       if($Sales->SaleType == '1'){ echo "Cash";}
       if($Sales->SaleType == '2'){ echo "Credit";}
       if($Sales->SaleType == '3'){ echo "Online";}
       ?>
      </address>
    </div>
    <input type="hidden" name="SaleType" id="SaleType" value="<?php echo $Sales->SaleType; ?>">

   
    <div class="col-sm-3 invoice-col">
      <address>
        <strong>Customer:</strong><br>
         <select name="CustomerId" id="CustomerId" style="width:215px; margin-top:1px;" class="form-control select2" required="required">
         <option selected="selected" value="">Select Customer</option>
         <?php foreach ($AllCustomers as $CustomerRecord) { ?>
         <option value="<?php echo $CustomerRecord['CustomerId'].'-'.$CustomerRecord['ChartOfAccountId']; ?>"<?php if($CustomerRecord['CustomerId'] == $Sales->CustomerId) echo "selected=selected"; ?>><?php echo $CustomerRecord['CustomerName'];?></option>
         <?php } ?>
        </select>
          <a href="<?php echo base_url(); ?>Customer/AddCustomer/" target="_blank"><span  style="cursor:pointer; color:darkgreen; font-weight:600;" id="addrow" class="fa fa-plus"></span></a>
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
        <option <?php if($Sales->AccountId == $BankAccounts['AccountId']) { echo 'selected=selected'; } else { echo ''; } ?> value="<?php echo $BankAccounts['AccountId']; ?>"><?php echo $BankAccounts['AccountTitle'] . " - " . $BankAccounts['AccountNumber'];  ?></option>
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
    <strong>P.O. Date:</strong><br>
    <input 
      type="date" 
      name="PODate" 
      id="PODate" 
      style="width:215px;" 
      class="form-control" 
      required="required"
      value="<?php echo isset($Sales->PODate) ? htmlspecialchars($Sales->PODate) : ''; ?>"
    >
  </address>
</div>

            <input class="form-control" name="MobileNumber" id="MobileNumber" type="hidden" style="width:215px;" value="<?php echo $Sales->MobileNumber; ?>" autocomplete="off">
                <input class="form-control" name="CustomerName" id="CustomerName" type="hidden" style="width:215px;" value="<?php echo $Sales->WalkinCustomer; ?>" autocomplete="off">

<div class="col-sm-3 invoice-col">
  <address>
    <strong>Sale Date:</strong><br>
    <input class="form-control" id="problematic-datepicker" type="datetime-local" 
           name="SaleDate" style="width:215px;">
  </address>
</div>
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
        <strong>P.O No:</strong><br>
        <input class="form-control" name="SaleNote" id="SaleNote" type="text" style="width:215px;" value="<?php echo $Sales->SaleNote; ?>" autocomplete="off">
      </address>
    </div>
    
    <div class="col-sm-3 invoice-col">
      <address>
        <strong>Vehicle Number:</strong><br>
        <input class="form-control" name="VehicleNo" id="VehicleNo" type="text" style="width:215px;" value="<?php echo $Sales->VehicleNo; ?>" autocomplete="off">
      </address>
    </div>
    
  <div class="col-sm-3 invoice-col">
  <address>
    <strong style="color: #ff0000;">Scenario Type:</strong> <span class="text-danger" title="This field is mandatory">*</span><br>
    <select name="ScenarioType" id="ScenarioType" class="select2 form-control" style="width:215px;" required>
      <option value="" disabled>-- Select Scenario Type (Required) --</option>
      <option value="SN001" <?php echo (isset($editData['ScenarioType']) && $editData['ScenarioType'] == 'SN001') ? 'selected' : ''; ?>>Goods at Standard Rate to Registered Buyers</option>
      <option value="SN002" <?php echo (isset($editData['ScenarioType']) && $editData['ScenarioType'] == 'SN002') ? 'selected' : ''; ?>>Goods at Standard Rate to Unregistered Buyers</option>
      <option value="SN005" <?php echo (isset($editData['ScenarioType']) && $editData['ScenarioType'] == 'SN005') ? 'selected' : ''; ?>>Reduced Rate Sale</option>
      <option value="SN006" <?php echo (isset($editData['ScenarioType']) && $editData['ScenarioType'] == 'SN006') ? 'selected' : ''; ?>>Exempt Goods Sale</option>
      <option value="SN007" <?php echo (isset($editData['ScenarioType']) && $editData['ScenarioType'] == 'SN007') ? 'selected' : ''; ?>>Zero Rated Sale</option>
      <option value="SN008" <?php echo (isset($editData['ScenarioType']) && $editData['ScenarioType'] == 'SN008') ? 'selected' : ''; ?>>Sale of 3rd Schedule Goods</option>
      <option value="SN016" <?php echo (isset($editData['ScenarioType']) && $editData['ScenarioType'] == 'SN016') ? 'selected' : ''; ?>>Processing / Conversion of Goods</option>
      <option value="SN017" <?php echo (isset($editData['ScenarioType']) && $editData['ScenarioType'] == 'SN017') ? 'selected' : ''; ?>>Sale of Goods where FED is Charged in ST Mode</option>
      <option value="SN020" <?php echo (isset($editData['ScenarioType']) && $editData['ScenarioType'] == 'SN020') ? 'selected' : ''; ?>>Electric Vehicle</option>
      <option value="SN024" <?php echo (isset($editData['ScenarioType']) && $editData['ScenarioType'] == 'SN024') ? 'selected' : ''; ?>>Goods Sold that are Listed in SRO 297(1)/2023</option>
    </select>
    <small class="text-danger" style="display: block; margin-top: 5px; font-weight: 500;">This selection is mandatory</small>
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

<div class="col-sm-12" style="display: flex; flex-wrap: wrap; justify-content: space-between; margin-bottom: 20px;">
    <div class="form-group" style="width: calc(25% - 15px); margin-bottom: 15px;">
        <label for="fbr_customer" style="display: block; margin-bottom: 6px; font-weight: 600; color: #555;">Address:</label>
        <input class="form-control" name="fbr_customer" id="fbr_customer" type="text" 
               style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px; transition: all 0.3s;" 
               value="<?php echo $Sales->fbr_customer; ?>" placeholder="Enter customer name" autocomplete="off">
    </div>
    
    <div class="form-group" style="width: calc(25% - 15px); margin-bottom: 15px;">
        <label for="fbr_cnic" style="display: block; margin-bottom: 6px; font-weight: 600; color: #555;">ST Registration No.:</label>
        <input class="form-control" name="fbr_cnic" id="fbr_cnic" type="text" 
               style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px; transition: all 0.3s;" 
               value="<?php echo $Sales->fbr_cnic; ?>" placeholder="Enter ST registration number" autocomplete="off">
    </div>
    
    <div class="form-group" style="width: calc(25% - 15px); margin-bottom: 15px;">
        <label for="fbr_mobile" style="display: block; margin-bottom: 6px; font-weight: 600; color: #555;">Mobile:</label>
        <input class="form-control" name="fbr_mobile" id="fbr_mobile" type="text" 
               style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px; transition: all 0.3s;" 
               value="<?php echo $Sales->fbr_mobile; ?>" placeholder="Enter mobile number" autocomplete="off">
    </div>
    
    <div class="form-group" style="width: calc(25% - 15px); margin-bottom: 15px;">
        <label for="fbr_ntn" style="display: block; margin-bottom: 6px; font-weight: 600; color: #555;">NTN:</label>
        <input class="form-control" name="fbr_ntn" id="fbr_ntn" type="text" 
               style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px; transition: all 0.3s;" 
               value="<?php echo $Sales->fbr_ntn; ?>" placeholder="Enter NTN number" autocomplete="off">
    </div>
</div>
      
    </div>
<div class="col-sm-6 invoice-col">
    <address>
        <div style="font-weight:600;" class="col-sm-8" id="AccountReceivable"></div>
    </address>
</div>

<div class="row" style="display: block; margin-top: 20px;" id="mainRow">
    <div class="col-md-12">
        <div class="box-body pad table-responsive">
            <table class='table table-bordered' id="Sale_EntriesTable" style="width: 100%; border-collapse: separate; border-spacing: 0;">
                <thead>    
                    <tr style="background: linear-gradient(to bottom, #f8f9fa, #e9ecef);">
                        <th style="width: 2%; padding: 10px; border-top: 1px solid #dee2e6; border-bottom: 2px solid #dee2e6; font-weight: 600; color: #495057;">S.#</th>
                                  <th style="width: 5%; padding: 10px; border-top: 1px solid #dee2e6; border-bottom: 2px solid #dee2e6; font-weight: 600; color: #495057;">P.O No#</th>
                        <th style="padding: 10px; width: 10%; text-align: left; border-top: 1px solid #dee2e6; border-bottom: 2px solid #dee2e6; font-weight: 600; color: #495057;">Item</th>
                        <th style="padding: 10px; width: 10%; text-align: left; border-top: 1px solid #dee2e6; border-bottom: 2px solid #dee2e6; font-weight: 600; color: #495057;">Location</th>
                        <th style="padding: 10px; width: 10%; text-align: left; border-top: 1px solid #dee2e6; border-bottom: 2px solid #dee2e6; font-weight: 600; color: #495057;">QTY - TON</th>
                        <th style="padding: 10px; width: 10%; text-align: left; border-top: 1px solid #dee2e6; border-bottom: 2px solid #dee2e6; font-weight: 600; color: #495057;">Rate - TON</th>
                        <th style="padding: 10px; width: 10%; border-top: 1px solid #dee2e6; border-bottom: 2px solid #dee2e6; font-weight: 600; color: #495057;">Rate</th>
                        <th style="padding: 10px; width: 10%; border-top: 1px solid #dee2e6; border-bottom: 2px solid #dee2e6; font-weight: 600; color: #495057;">Qty</th>
                        <th style="padding: 10px; width: 10%; border-top: 1px solid #dee2e6; border-bottom: 2px solid #dee2e6; font-weight: 600; color: #495057;">Amount</th>
                        <th style="padding: 10px; width: 10%; border-top: 1px solid #dee2e6; border-bottom: 2px solid #dee2e6; font-weight: 600; color: #495057;">GST Rate %</th>
                        <th style="padding: 10px; width: 10%; border-top: 1px solid #dee2e6; border-bottom: 2px solid #dee2e6; font-weight: 600; color: #495057;">GST Amount</th>
                        
            <th style="padding: 10px; width: 5%; border-top: 1px solid #dee2e6; border-bottom: 2px solid #dee2e6; font-weight: 600; color: #495057;">Further Tax Rate %</th>
            <th style="padding: 10px; width: 5%; border-top: 1px solid #dee2e6; border-bottom: 2px solid #dee2e6; font-weight: 600; color: #495057;">Further Tax Amt</th>
                        <th style="padding: 10px; width: 10%; border-top: 1px solid #dee2e6; border-bottom: 2px solid #dee2e6; font-weight: 600; color: #495057;">Discount Total</th>
                        <th style="padding: 10px; width: 10%; border-top: 1px solid #dee2e6; border-bottom: 2px solid #dee2e6; font-weight: 600; color: #495057;">Net Amount</th>
                        <th style="padding: 10px; width: 2%; text-align: center; border-top: 1px solid #dee2e6; border-bottom: 2px solid #dee2e6; font-weight: 600; color: #495057;">Delete</th>
	   </tr>
		<?php
		$SNo = 1; 
		$TotalNetAmount = 0;
    $Quantity = 0;
    $Amount = 0;
    $DiscountAmount = 0;
    $TaxAmount = 0;
    $NetAmount = 0;
    $FurtherTaxAmt=0;
		foreach($SalesDetail as $Record) {
		 ?>
		<tr class="txtMult">
		 <td style="margin-top:15px;line-height:25px"><?php echo $SNo; ?></td>
		 <td><input style="width:100px;margin-top:1px;" type="text" id="txt<?php echo $SNo; ?>" name="ProductBarCode[]" class=""  value="<?php echo $Record['ProductBarCode'];?>"></td>
		 <td>
		  <input style='width:90px;margin-top:1px;' type='text' name="ProductName[]" id="ProductName_<?php echo $SNo?>" autocomplete="off"value="<?php echo $Record['ProductName'];?>">
		  <input type='hidden' id="hdnProductName_<?php echo $SNo; ?>" name="ProductId[]" value="<?php echo $Record['ProductId'];?>">
		 </td>
		 <td>
		  <input style='width:90%;margin-top:1px;' type='text' id="LocationName_<?php echo $SNo?>" autocomplete="off" value="<?php echo $Record['LocationName'];?>" >
		 <input type='hidden' id="hdnLocationName_<?php echo $SNo?>" name="LocationId[]" value="<?php echo $Record['LocationId'];?>"> 
		 </td>
		 <td><input style='width:100%; margin-top:1px;' type='text' id="Rate<?php print $SNo; ?>" class="EngineNo" name='EngineNo[]' autocomplete="off" value="<?php echo $Record['EngineNo'];?>"></td>
		 <td><input style='width:100%; margin-top:1px;' type='text' id="Rate<?php print $SNo; ?>" class="ChassisNo" name='ChassisNo[]' autocomplete="off" value="<?php echo $Record['ChassisNo'];?>" min="0"></td>
		 <td><input style='width:100%; margin-top:1px;' type='text' id="Rate<?php print $SNo; ?>" class="Rate" name='Rate[]' autocomplete="off" value="<?php echo $Record['Rate'];?>" min="0"></td>
		 <td style="text-align:center;"><input style='width:90%;margin-top:1px; text-align:right;' type='text' id="Quantity<?php print $SNo; ?>" class="Quantity" name='Quantity[]' autocomplete="off" value="<?php echo $Record['Quantity'];?>" min="0"></td>
		 <td><input style='width:90%; margin-top:1px; text-align:right;' type='text' id="Amount<?php print $SNo; ?>" class="Amount" name='Amount[]' value="<?php echo $Record['Amount'];?>" min="0"></td>
		 <td><input style='width:90%; margin-top:1px; text-align:right;' type='text' id="DiscountAmount<?php print $SNo; ?>" class="DiscountAmount" name='DiscountAmount[]' value="<?php echo $Record['DiscountAmount'];?>" min="0"></td>
		<td><input style='width:90%; margin-top:1px; text-align:right;' type='text' id="TaxPercentage<?php print $SNo; ?>" class="TaxPercentage" name='TaxPercentage[]' min="0" value="<?php echo $Record['TaxPercentage'];?>"></td>
	
		<td><input style='width:90%; margin-top:1px; text-align:right;' type='text' id="FurtherTaxRate_<?php print $SNo; ?>" class="FurtherTaxRate" name='FurtherTaxRate[]' min="0" value="<?php echo $Record['FurtherTaxRate'];?>"></td>
		<td><input style='width:90%; margin-top:1px; text-align:right;' type='text' id="FurtherTaxAmt_<?php print $SNo; ?>" class="FurtherTaxAmt" name='FurtherTaxAmt[]' min="0" value="<?php echo $Record['FurtherTaxAmt'];?>"></td>
	
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
		     $FurtherTaxAmt += $Record['FurtherTaxAmt'];
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
        <tr id="wh-tax-row">
    <td colspan="10" style="width: 80%; text-align:right; font-weight:600; border:0px solid;">WH Tax %:</td>
    <td>
        <input style="text-align:right; width:100%;" id="wh_tax_percent" type="text" name="wh_tax_percent" value="<?php echo $Sales->wh_tax_percent; ?>">
    </td>
    <td style="text-align:right; font-weight:600; border:0px solid;">WH Tax Amount:</td>
    <td>
        <input style="text-align:right; width:100%;" id="wh_tax_amount" type="text" name="wh_tax_amount" value="<?php echo $Sales->wh_tax_amount; ?>">
    </td>
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
          <td colspan="12" style="width: 90%; text-align:right; font-weight:600; border: 0px solid;">Total Further Tax Amount:</td>
          <td><div id="Amount" style='font-weight:600; text-align:right; color:#008000;'><?php echo number_format($FurtherTaxAmt,2,'.',''); ?></div></td>
        </tr>

        <tr>
          <td colspan="12" style="width: 90%; text-align:right; font-weight:600; border: 0px solid;">Total GST Amount:</td>
          <td><div id="TotalGSTAmount" style='font-weight:600; text-align:right; color:#008000;'><?php echo number_format($DiscountAmount,2,'.',''); ?></div></td>
        </tr>

      

        <tr>
          <td colspan="12" style="width: 90%; text-align:right; font-weight:600; border: 0px solid;">Total Actual Sale Amount:</td>
          <td><div id="TotalAmount" style='font-weight:600; text-align:right; color:#008000;'><?php echo number_format($NetAmount,2,'.',''); ?></div></td>
        </tr>
          <tr>
          <td colspan="12" style="width: 90%; text-align:right; font-weight:600; border: 0px solid;">Total Net Amount+WH Tax Amount :</td>
          <td><div id="TotalAmountWHTax" style='font-weight:600; text-align:right; color:#008000;'><?php echo $NetAmount+$Sales->wh_tax_amount; ?></div></td>
        </tr>



        </tbody>
       </table>

<div class="box-body">
    <div class="row">
      <div class="col-md-2">
        <button type="submit" name="submitForm" value="AddRecord" id="AddRecord" class="btn btn-block btn-primary">Update Record</button>
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
      cols += '<td><input style="width:100px;margin-top:1px;" type="text" id="txt'+ counter +'" name="ProductBarCode[]" class="" value=""></td>';
  cols += '<td><input style="width:90px;margin-top:1px;" class="select2" name="ProductName[]" type="text" id="ProductName_'+ counter +'" name="ProductName[]"><input style="width:90%;" type="hidden" id="hdnProductName_'+ counter +'" name="ProductId[]"></td>'
  cols += '<td style="text-align:center;"><input style="width:90%; margin-top:1px;" class="select2" type="text" id="LocationName_'+ counter +'" name="LocationName_[]"><input style="width:90%;" type="hidden" id="hdnLocationName_'+ counter +'" name="LocationId[]"></td>';
 //  cols += '<td style="text-align:center;"><input style="width:90%; margin-top:1px;" class="select2" type="text" id="ColourName_'+ counter +'" name="ColourName[]"><input style="width:90%;" type="hidden" id="hdnColourName_'+ counter +'" name="ColourId[]"></td>';
 	cols += '<td style="text-align:center;"><input style="width:60%; margin-top:1px;" type="text" id="EngineNo_'+ counter +'" name="EngineNo[]"></td>';
	cols += '<td style="text-align:center;"><input style="width:60%; margin-top:1px;" type="text" id="ChassisNo_'+ counter +'" name="ChassisNo[]"></td>';
  cols += '<td><input style="width:100%; margin-top:1px; text-align:right;" type="text" id="Rate'+ counter +'" class="Rate" name="Rate[]" autocomplete="off" min="0" step="0.01"></td>';
  cols += '<td><input style="width:90%; margin-top:1px; text-align:right;" type="text" id="Quantity'+ counter +'" class="Quantity" name="Quantity[]" autocomplete="off" min="0" step="0.01"></td>';
  cols += '<td><input style="width:90%; margin-top:1px; text-align:right;" type="text" id="Amount'+ counter +'" class="Amount" name="Amount[]" min="0" step="0.01"></td>';
  cols += '<td><input style="width:90%; margin-top:1px; text-align:right;" type="text" id="DiscountAmount'+ counter +'" class="DiscountAmount" name="DiscountAmount[]" min="0" value="18" step="0.01"></td>';
  cols += '<td><input style="width:90%; margin-top:1px; text-align:right;" type="text" id="TaxPercentage'+ counter +'" class="TaxPercentage" name="TaxPercentage[]" step="0.00"></td>';
  cols += '<td><input style="width:100%; margin-top:1px; text-align:right;" type="text" id="FurtherTaxRate_'+ counter +'" value="0" class="FurtherTaxRate" name="FurtherTaxRate[]"></td>';
    cols += '<td><input style="width:100%; margin-top:1px; text-align:right;" type="text" id="FurtherTaxAmt_'+ counter +'" value="0" class="FurtherTaxAmt" name="FurtherTaxAmt[]"></td>';
   
  cols += '<td><input style="width:90%; margin-top:1px; text-align:right;" type="text" id="TaxAmount'+ counter +'" class="TaxAmount" name="TaxAmount[]" step="0.00"></td>';
  cols += '<td><input style="width:90%; margin-top:1px; text-align:right;" type="text" id="NetAmount'+ counter +'" class="NetAmount" name="NetAmount[]" min="0" step="0.01"></td>';
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
    $('body').on("keyup", "#wh_tax_percent", calculates);
     function calculates() {
         TotalAmount=  $('#Amount').text();
         wh_tax_percent=  $('#wh_tax_percent').val();
         var wh_tax_amount = ((TotalAmount * wh_tax_percent) / 100); 
          $('#wh_tax_amount').val(wh_tax_amount);
        //  alert(wh_tax_amount+'-'+TotalAmount);
        $('#TotalAmountWHTax').text(parseFloat(wh_tax_amount)+parseFloat(TotalAmount));
        
     }
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
  var FurtherTaxRate = $('.FurtherTaxRate', this).val();
      var QuantityVal = (isNaN(parseFloat(Quantity))) ? 0 : parseFloat(Quantity);
      var RateVal = (isNaN(parseFloat(Rate))) ? 0 : parseFloat(Rate);
      var DiscountAmountVal = (isNaN(parseFloat(DiscountAmount))) ? 0 : parseFloat(DiscountAmount);
var FurtherTaxRateVal = (isNaN(parseFloat(FurtherTaxRate))) ? 0 : parseFloat(FurtherTaxRate);

      var Amount = Number(((QuantityVal * 1) * (RateVal * 1)).toFixed(2));
    //   var Amount = (QuantityVal * 1) * (RateVal * 1);      
      
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
          $('.FurtherTaxAmt',this).val((Amount*(FurtherTaxRateVal/100)).toFixed(2));
          var TaxPercentage = $('.TaxPercentage', this).val();
           var FurtherTaxAmt = $('.FurtherTaxAmt', this).val();
         $('.NetAmount',this).val(parseFloat(TaxPercentage)+parseFloat(FurtherTaxAmt)+parseFloat(Amount)-parseFloat($TaxAmount));
      

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
                   $("#hdn"+ProductId).val(ui.item.id);
                    $("#EngineNo_"+Attr[1]).val(ui.item.OpeningStock);
                     $("#ChassisNo_"+Attr[1]).val(ui.item.ProductGroupName);
                     // save selected id to hidden input
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
                // $('#Quantity'+IdAttr).val(response);
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