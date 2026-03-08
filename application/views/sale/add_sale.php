<?php $this->load->view('includes/header'); ?>
<?php $this->load->view('includes/sidebar'); ?>
<script type="text/javascript" src="//code.jquery.com/jquery-2.1.0.jsssss"></script>
<?php 

$References = '<select name="ReferenceId" id="ReferenceId" style="width:215px;" class="form-control select2">';
$References .= '<option value="">Select Transportation</option>';
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
      <h1><i class="fa fa-clipboard"></i>&nbsp;Sales</h1>
    </section>
    
    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-md-12">
          <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title text-light-blue">Add Sale</h3>
            </div>
	    <?php echo "<font style=color:#00468E; font-weight:bold text-align:center;>".$this->session->flashdata('record_update')."</font>"; ?>
      
           <form role="form" id="SaleOrderForm" action='<?php echo base_url("Sales/SaveSale") ?>' method="post">
	 
	 <div class="box-body">
        <div class="row invoice-info">
	<div class="col-sm-3 invoice-col">
      <address>
        <strong>Invoice #:</strong><br>
        <span style="color:#3333CC; font-size:13px; font-weight:bold;">(Auto Generated)
	</span>
      </address>
    </div>	
    <input type="hidden" name="ReferenceName" id="ReferenceName" />
    <input type="hidden" name="TotalTaxAmount" id="TotalTaxAmount" />
    
    <div class="col-sm-3 invoice-col">
      <address>
        <strong>Select Counter:</strong><br>
        <select name="Counter" id="Counter" style="width:215px;" class="form-control select2" required="required">
          <option value="1" selected="selected">Counter One</option>
          <option value="2">Counter Two</option>
          <option value="3">Counter Three</option>
        </select>
      </address>
    </div>
    
    <div class="col-sm-3 invoice-col">
      <address>
        <strong>Sale Status:</strong><br>
        <select name="SaleStatus" id="SaleStatus" style="width:215px;" class="form-control select2" required="required">
          <option selected="selected" value="Confirm">Confirm</option>
        </select>
      </address>
    </div>

    <div class="col-sm-3 invoice-col">
      <address>
        <strong>Payment Term:</strong><br>
        <select name="SaleType" id="SaleType" style="width:215px;" class="form-control select2" required="required">
  <option value="">Sale Type</option>
  <option value="1">On Cash</option>
  <option value="2" selected="selected">On Credit</option>
  <option value="3">Online</option>
</select>
      </address>
    </div>
    
    <div class="col-sm-3 invoice-col">
      <address>
        <strong>Buyer Name / Customer Name:</strong><br>
	<select name="CustomerId" id="CustomerId" class="select2 form-control" style="width:215px;" required="required">
        
            <?php foreach ($AllCustomers as $CustomerRecord) { ?>
          <option value="<?php echo $CustomerRecord['CustomerId'].'-'.$CustomerRecord['ChartOfAccountId']; ?>"><?php echo $CustomerRecord['CustomerName'];  ?></option>
            <?php
            } ?>
        </select>
        <a href="<?php echo base_url(); ?>Customer/AddCustomer/" target="_blank"><span  style="cursor:pointer; color:darkgreen; font-weight:600;" id="addrow" class="fa fa-plus"></span></a>
         
      </address>
      
    </div>

    
    

    <div class="col-sm-3 invoice-col">
      <address>
        <strong>Transportation:</strong><br>
       <?php echo $References; ?>
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
      required
      value="<?php 
        // Set timezone explicitly and format date
        date_default_timezone_set('Asia/Karachi'); // Replace with your timezone
        echo date('Y-m-d'); 
      ?>"
    >
  </address>
</div>
    

    

<div class="col-sm-3 invoice-col">
  <address>
    <strong>Sale Date:</strong><br>
    <input class="form-control" id="problematic-datepicker" type="datetime-local" 
           name="SaleDate" style="width:215px;">
  </address>
</div>

    <div class="col-sm-3 invoice-col">
      <address>
        <strong>P.O No:</strong><br>
        <input class="form-control" name="SaleNote" id="SaleNote" type="text" style="width:215px;" value="" autocomplete="off">
      </address>
    </div>
    
    <div class="col-sm-3 invoice-col">
      <address>
        <strong>Vehicle Number:</strong><br>
        <input class="form-control" name="VehicleNo" id="VehicleNo" type="text" style="width:215px;" value="" autocomplete="off">
      </address>
    </div>

    <div class="col-sm-3 invoice-col">
      <address>
        <strong>Saleman:</strong><br>
        <select name="SalemanId" id="SalemanId" class="select2 form-control" style="width:215px;">
          <option value="0"> Select Saleman</option>
            <?php foreach ($GetAllSaleman as $AllSaleman) {
            ?>
          <option value="<?php echo $AllSaleman['SalemanId'].'-'.$AllSaleman['ChartOfAccountId']; ?>"><?php echo $AllSaleman['SalemanName'];  ?></option>
            <?php
            } ?>
        </select>
      </address>
    </div>
    
<div class="col-sm-3 invoice-col">
  <address>
    <strong style="color: #ff0000;">Scenario Type:</strong> <span class="text-danger" title="This field is mandatory">*</span><br>
    <select name="ScenarioType" id="ScenarioType" class="select2 form-control" style="width:215px;" required>
      <option value="" disabled selected>-- Select Scenario Type (Required) --</option>
      <option value="SN001">Goods at Standard Rate to Registered Buyers</option>
      <option value="SN002">Goods at Standard Rate to Unregistered Buyers</option>
      <option value="SN005">Reduced Rate Sale</option>
      <option value="SN006">Exempt Goods Sale</option>
      <option value="SN007">Zero Rated Sale</option>
      <option value="SN008">Sale of 3rd Schedule Goods</option>
      <option value="SN016">Processing / Conversion of Goods</option>
      <option value="SN017">Sale of Goods where FED is Charged in ST Mode</option>
      <option value="SN020">Electric Vehicle</option>
      <option value="SN024">Goods Sold that are Listed in SRO 297(1)/2023</option>
    </select>
    <small class="text-danger" style="display: block; margin-top: 5px; font-weight: 500;">This selection is mandatory</small>
  </address>
</div>
     
<div class="col-sm-12">
    <h4 style="color: #2e7d32; font-weight: 600; border-bottom: 2px solid #2e7d32; padding-bottom: 8px; margin-bottom: 20px;">
        FBR Information
    </h4>
</div>

<div class="col-sm-12" style="display: flex; flex-wrap: wrap; gap: 15px; margin-bottom: 20px;">
    <div class="form-group" style="flex: 1; min-width: 220px;">
        <label for="fbr_customer" style="display: block; margin-bottom: 6px; font-weight: 600; color: #555;">Address:</label>
        <input class="form-control" name="fbr_customer" id="fbr_customer" type="text" 
               style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px; transition: all 0.3s;" 
               placeholder="Enter customer address" autocomplete="off">
    </div>
    
    <div class="form-group" style="flex: 1; min-width: 220px;">
        <label for="fbr_cnic" style="display: block; margin-bottom: 6px; font-weight: 600; color: #555;">ST Registration No.:</label>
        <input class="form-control" name="fbr_cnic" id="fbr_cnic" type="text" 
               style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px; transition: all 0.3s;" 
               placeholder="Enter ST registration number" autocomplete="off">
    </div>
    
    <div class="form-group" style="flex: 1; min-width: 220px;">
        <label for="fbr_mobile" style="display: block; margin-bottom: 6px; font-weight: 600; color: #555;">Mobile:</label>
        <input class="form-control" name="Area_Name" id="fbr_mobile" type="text" 
               style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px; transition: all 0.3s;" 
               placeholder="Enter mobile number" autocomplete="off">
    </div>
    
    <div class="form-group" style="flex: 1; min-width: 220px;">
        <label for="fbr_ntn" style="display: block; margin-bottom: 6px; font-weight: 600; color: #555;">NTN:</label>
        <input class="form-control" name="fbr_ntn" id="fbr_ntn" type="text" 
               style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px; transition: all 0.3s;" 
               placeholder="Enter NTN number" autocomplete="off">
    </div>
</div>
      
    </div>
    <div style="overflow-x: auto; width: 100%;">
<table class='table table-bordered' id="Sale_EntriesTable" style="width: 100%; border-collapse: separate; border-spacing: 0;">
    <thead>    
        <tr style="background: linear-gradient(to bottom, #f8f9fa, #e9ecef);">
            <th style="width: 2%; padding: 10px; border-top: 1px solid #dee2e6; border-bottom: 2px solid #dee2e6; font-weight: 600; color: #495057;">S.#</th>
            <th style="width: 5%; padding: 10px; border-top: 1px solid #dee2e6; border-bottom: 2px solid #dee2e6; font-weight: 600; color: #495057;">P.O No#</th>
            <th style="padding: 10px; width: 10%; text-align: left; border-top: 1px solid #dee2e6; border-bottom: 2px solid #dee2e6; font-weight: 600; color: #495057;">Item</th>
            <th style="padding: 10px; width: 10%; text-align: left; border-top: 1px solid #dee2e6; border-bottom: 2px solid #dee2e6; font-weight: 600; color: #495057;">Location</th>
            <th style="padding: 10px; width: 10%; text-align: left; border-top: 1px solid #dee2e6; border-bottom: 2px solid #dee2e6; font-weight: 600; color: #495057;">Qty - TON</th>
            <th style="padding: 10px; width: 10%; text-align: left; border-top: 1px solid #dee2e6; border-bottom: 2px solid #dee2e6; font-weight: 600; color: #495057;">Rate - TON</th>

            <th style="padding: 10px; width: 10%; border-top: 1px solid #dee2e6; border-bottom: 2px solid #dee2e6; font-weight: 600; color: #495057;">Rate</th>
            <th style="padding: 10px; width: 10%; border-top: 1px solid #dee2e6; border-bottom: 2px solid #dee2e6; font-weight: 600; color: #495057;">Qty</th>
            <th style="padding: 10px; width: 8%; border-top: 1px solid #dee2e6; border-bottom: 2px solid #dee2e6; font-weight: 600; color: #495057;">Stock Qty</th>
            <th style="padding: 10px; width: 10%; border-top: 1px solid #dee2e6; border-bottom: 2px solid #dee2e6; font-weight: 600; color: #495057;">Amount</th>
            <th style="padding: 10px; width: 10%; border-top: 1px solid #dee2e6; border-bottom: 2px solid #dee2e6; font-weight: 600; color: #495057;">GST Rate %</th>
            <th style="padding: 10px; width: 5%; border-top: 1px solid #dee2e6; border-bottom: 2px solid #dee2e6; font-weight: 600; color: #495057;">GST Amount</th>
            <th style="padding: 10px; width: 5%; border-top: 1px solid #dee2e6; border-bottom: 2px solid #dee2e6; font-weight: 600; color: #495057;">Further Tax Rate %</th>
            <th style="padding: 10px; width: 5%; border-top: 1px solid #dee2e6; border-bottom: 2px solid #dee2e6; font-weight: 600; color: #495057;">Further Tax Amt</th>
            <th style="padding: 10px; width: 10%; border-top: 1px solid #dee2e6; border-bottom: 2px solid #dee2e6; font-weight: 600; color: #495057;">Discount Total</th>
            <th style="padding: 10px; width: 10%; border-top: 1px solid #dee2e6; border-bottom: 2px solid #dee2e6; font-weight: 600; color: #495057;">Net Amount</th>
            <th style="padding: 10px; text-align: center; border-top: 1px solid #dee2e6; border-bottom: 2px solid #dee2e6; font-weight: 600; color: #495057;">Action</th>
        </tr>
    </thead>
    <tbody style="border-top: none;">
        <!-- Your table body content will go here -->
    </tbody>
</table>
</div>
	<?php $i = 1; ?>
	<tbody id="ItemList">
	<!--  <tr>
	  <td style="margin-top:15px;line-height:25px"><?php // echo $i; ?></td>
	  <td><input style="width:100px;margin-top:1px;" type="text" id="txtCode" name="Barcode[]" class="barcodeinput__"></td>
	  <td><input style="width:100px;margin-top:1px;" type="text" id="ProductName_<?php // echo $i; ?>" name="ProductName[]"><input type="hidden" id="hdnProductName_<?php // echo $i; ?>" name="ProductId[]"></td>
	  <td style="text-align:center;"><input style="width:100%; margin-top:1px;" type="text" id="LocationName_<?php // echo $i; ?>" name="LocationName_[]"><input type="hidden" id="hdnLocationName_<?php // echo $i; ?>" name="LocationId[]"></td>
	  <td style="text-align:center;"><input style="width:100%; margin-top:1px;" type="text" id="ColourName_<?php // echo $i; ?>" name="ColourName[]"><input style="width:90%;" type="hidden" id="hdnColourName_<?php // echo $i; ?>" name="ColourId[]"></td>
	  <td><input style="width:100%; margin-top:1px; text-align:right;" type="number" id="Rate<?php // echo $i; ?>" class="Rate" name="Rate[]" autocomplete="off" step="0.00"></td>
	  <td><input style="width:100%; margin-top:1px; text-align:right;" type="number" id="Quantity_<?php // echo $i; ?>" class="Quantity" name="Quantity[]" autocomplete="off" step="0.00"></td>
	  <td><input style="width:100%; margin-top:1px; text-align:right;" type="number" id="Amount<?php // echo $i; ?>" class="Amount" name="Amount[]" step="0.00"></td>
	  <td><input style="width:100%; margin-top:1px; text-align:right;" type="number" id="DiscountAmount<?php // echo $i; ?>" class="DiscountAmount" name="DiscountAmount[]" step="0.00"></td>
	  <td><input style="width:100%; margin-top:1px; text-align:right;" type="number" id="TaxPercentage<?php // echo $i; ?>" class="TaxPercentage" name="TaxPercentage[]" step="0.00"></td>
	  <td><input style="width:100%; margin-top:1px; text-align:right;" type="number" id="TaxAmount<?php // echo $i; ?>" class="TaxAmount" name="TaxAmount[]" step="0.00"></td>
	  <td><input style="width:100%; margin-top:1px; text-align:right;" type="number" id="NetAmount<?php // echo $i; ?>" class="NetAmount" name="NetAmount[]" step="0.00"></td>
	  <td><i class="fa fa-trash remove" title="Delete" style="cursor:pointer; margin-top:6px; color:red;"></i></td>
	</tr>
	  -->
	</tbody>
      </table>
      <table class="table" border="0">
        <tbody>
        <tr>
         <td colspan="13">
	 <span style="cursor:pointer; color:darkgreen; font-weight:600;" id="addrow" class="fa fa-plus">Add Row</span>
         </td>
        </tr>

<tr id="wh-tax-row">
    <td colspan="10" style="width: 80%; text-align:right; font-weight:600; border:0px solid;">WH Tax %:</td>
    <td>
        <input style="text-align:right; width:100%;" id="wh_tax_percent" type="text" name="wh_tax_percent" value="0">
    </td>
    <td style="text-align:right; font-weight:600; border:0px solid;">WH Tax Amount:</td>
    <td>
        <input style="text-align:right; width:100%;" id="wh_tax_amount" type="text" name="wh_tax_amount" value="0">
    </td>
</tr>

                <tr id="cash-received">
                    <td colspan="12" style="width: 90%; text-align:right; font-weight:600; border: 0px solid;"> <select name="BankAccountId" id="BankAccountId" class="select2 form-control" style="width:215px;">
          <option value="0"> Select Bank Account</option>
            <?php foreach ($GetAllBankAccounts as $BankAccounts) {
            ?>
          <option value="<?php echo $BankAccounts['AccountId']; ?>"><?php echo $BankAccounts['AccountTitle'] . " - " . $BankAccounts['AccountNumber'];  ?></option>
            <?php
            } ?>
        </select></td>
          <td><div id="cashreceived" style='font-weight:600; text-align:right; color:#008000;'><input style="text-align:right" id="bank_value" type="text" name="bank_value" value="0"></div></td>
        
        
     </tr>
        <tr>
          <td colspan="12" style="width: 90%; text-align:right; font-weight:600; border: 0px solid;">Total Quantity:</td>
          <td><div id="Quantity" style='font-weight:600; text-align:right; color:#008000;'><?php echo '0.00'; ?></div></td>
        </tr>
        <tr>
          <td colspan="12" style="width: 90%; text-align:right; font-weight:600; border: 0px solid;">Total Amount:</td>
          <td><div id="Amount" style='font-weight:600; text-align:right; color:#008000;'><?php echo '0.00'; ?></div></td>
        </tr>
<tr>
  <td colspan="12" style="width: 90%; text-align:right; font-weight:600; border: 0px solid;">Total GST Amount:</td>
  <td><div id="TotalGSTAmount" style='font-weight:600; text-align:right; color:#008000;'><?php echo '0.00'; ?></div></td>
</tr>

<tr>
  <td colspan="12" style="width: 90%; text-align:right; font-weight:600; border: 0px solid;">Total Discount:</td>
  <td><div id="DiscountAmount" style='font-weight:600; text-align:right; color:#008000;'><?php echo '0.00'; ?></div></td>
</tr>
<tr>
  <td colspan="12" style="width: 90%; text-align:right; font-weight:600; border: 0px solid;">Total FurtherTax Amount:</td>
  <td><div id="FurtherTacAmount" style='font-weight:600; text-align:right; color:#008000;'><?php echo '0.00'; ?></div></td>
</tr>
        
        <tr>
          <td colspan="12" style="width: 90%; text-align:right; font-weight:600; border: 0px solid;">Total Net Amount:</td>
          <td><div id="TotalAmount" style='font-weight:600; text-align:right; color:#008000;'><?php echo '0.00'; ?></div></td>
        </tr>
         <tr>
          <td colspan="12" style="width: 90%; text-align:right; font-weight:600; border: 0px solid;">Total Net Amount+WH Tax Amount :</td>
          <td><div id="TotalAmountWHTax" style='font-weight:600; text-align:right; color:#008000;'><?php echo '0.00'; ?></div></td>
        </tr>
      </tbody>
      </table>

    <div class="box-body">
    <div class="row">
      <div class="col-md-2">
        <button type="submit" name="AddSaleRecordBtn" value="AddSaleRecord" id="AddRecord" class="btn btn-block btn-success">Save Record</button>
      </div>
      <div class="col-md-2">
        <a href="<?php echo base_url(); ?>Sales/"><button type="button" name="" value="cancelUpdate" class="btn btn-block btn-primary">Back to Main</button></a>
      </div>
    </div>
        </div>

      </div>
    </div>
        </div>
        <?php // } ?> 
  
            </form>
    <div class="col-sm-6 invoice-col">
      <address>
        <div style="font-weight:600;" class="col-sm-8" id="AccountReceivable"></div>
      </address>
    </div>    
        </div>
      </div>
    <div class="row" style="display: block;" id="mainRow">
    <div class="col-md-12">
      <div class="box-body pad table-responsive">
          


            </div>
          </div>
        </div>
      </section>
    </div>
  <?php $this->load->view('includes/footer'); ?>
<script src="<?php echo base_url();?>plugins/autocomplete/jquery-ui.js"></script>
<link rel="stylesheet" href="<?php echo base_url();?>plugins/autocomplete/jquery-ui.css" />
<script>
    const form = document.getElementById('SaleOrderForm'); 

    form.addEventListener('submit', function(event) {
        const productNameInputs = document.querySelectorAll('input[name="ProductName[]"]');
        
        let isValid = true;
        let firstInvalidInput = null; // پہلی خالی فیلڈ کو ٹریک کرنے کے لیے ایک ویری ایبل

        productNameInputs.forEach(input => {
            if (input.value.trim() === '') {
                // اگر فیلڈ خالی ہے، تو اسے انویلڈ مارک کریں
                input.classList.add('is-invalid');
                isValid = false;
                
                // اگر یہ پہلی خالی فیلڈ ہے، تو اسے سٹور کریں
                if (!firstInvalidInput) {
                    firstInvalidInput = input;
                }
            } else {
                // اگر فیلڈ خالی نہیں ہے، تو انویلڈ کلاس کو ہٹائیں
                input.classList.remove('is-invalid');
            }
        });

        if (!isValid) {
            event.preventDefault(); // فارم سبمٹ ہونے سے روکیں
            
            // پہلی خالی فیلڈ پر فوکس لائیں
            if (firstInvalidInput) {
                firstInvalidInput.focus();
            }
        }
    });
</script>
<script>
  $(document).ready(function () {
      
    $('#ReferenceId').load('<?php echo base_url("Sales/AllReferences")?>');
 
    // Add New Row Script 
    $('body').on("click", "#addrow", function(e) {
	$("#Sale_EntriesTable").append(newRow());
    });
    
    // Start Remove row script
    $("#Sale_EntriesTable").on("click", ".remove", function (event) {
        $(this).closest("tr").remove();       
        counter -= 1
    });
    // End of Add new row script 
    
function newRow() 
{
    var counter = $("#Sale_EntriesTable tr").length -1;
    counter++;
    
    var cols = '<tr class="txtMult"><td style="margin-top:15px;line-height:25px">'+ counter + '</td>';
    cols += '<td><input style="width:100px;margin-top:1px;" type="text" id="txt'+ counter +'" name="ProductBarCode[]" class="" value=""></td>';
    cols += '<td><input style="width:100px;margin-top:1px;" type="text" value="" id="ProductId'+ counter +'" name="ProductName[]"><input type="hidden" id="hdnProductId'+ counter +'" class="hdnProductId" name="hdnProductName[]"></td>';
    cols += '<td style="text-align:center;"><input style="width:100%; margin-top:1px;" type="text" id="LocationName_'+ counter +'" name="LocationName_[]"><input style="width:90%;" type="hidden" id="hdnLocationName_'+ counter +'" name="LocationId[]"></td>';
    cols += '<td style="text-align:center;"><input style="width:60%; margin-top:1px;" type="text" id="EngineNo_'+ counter +'" name="EngineNo[]"></td>';
    cols += '<td style="text-align:center;"><input style="width:60%; margin-top:1px;" type="text" id="ChassisNo_'+ counter +'" name="ChassisNo[]"></td>';

    cols += '<td><input style="width:100%; margin-top:1px; text-align:right;" type="text" id="Rate_'+ counter +'" class="Rate" name="Rate[]" autocomplete="off"></td>';
    cols += '<td><input style="width:100%; margin-top:1px; text-align:right;" type="text" id="Quantity_'+counter+'" class="Quantity" name="Quantity[]" autocomplete="off"></td>';
    cols += '<td><input style="width:100%; margin-top:1px;"; text-align:center; type="text" id="AvailableQty_'+ counter +'">';
    cols += '<td><input style="width:100%; margin-top:1px; text-align:right;" type="text" id="Amount'+ counter +'" class="Amount" name="Amount[]"></td>';
    cols += '<td><input style="width:100%; margin-top:1px; text-align:right;" type="text" id="DiscountAmount_'+ counter +'" value="18" class="DiscountAmount" name="DiscountAmount[]"></td>';
    cols += '<td><input style="width:100%; margin-top:1px; text-align:right;" type="text" id="TaxPercentage_'+ counter +'"  class="TaxPercentage" name="TaxPercentage[]"></td>';

    cols += '<td><input style="width:100%; margin-top:1px; text-align:right;" type="text" id="FurtherTaxRate_'+ counter +'" value="0" class="FurtherTaxRate" name="FurtherTaxRate[]"></td>';
    cols += '<td><input style="width:100%; margin-top:1px; text-align:right;" type="text" id="FurtherTaxAmt_'+ counter +'" value="0" class="FurtherTaxAmt" name="FurtherTaxAmt[]"></td>';
    cols += '<td><input style="width:100%; margin-top:1px; text-align:right;" type="text" id="TaxAmount'+ counter +'" value="0" class="TaxAmount" name="TaxAmount[]"></td>';
   
    cols += '<td><input style="width:100%; margin-top:1px; text-align:right;" type="text" id="NetAmount'+ counter +'" class="NetAmount" name="NetAmount[]"></td>';
    cols += '<td><input type="hidden" id="SaleCartId_'+ counter +'" class="SaleCartId" name="SaleCartId[]"><i class="fa fa-times-circle remove" title="Delete" style="cursor:pointer; margin-top:6px; color:red;"></i></td>';
    return cols;
};

// TON → KG Auto Conversion
$(document).on("keyup", "input[id^='EngineNo_'], input[id^='ChassisNo_']", function () {

    var id = $(this).attr("id").split("_")[1];

    var ton_qty  = parseFloat($("#EngineNo_" + id).val()) || 0;       // Ton
    var ton_rate = parseFloat($("#ChassisNo_" + id).val()) || 0;      // Rate per Ton

    // Conversion
    var kg_qty  = ton_qty * 1000;          // Ton → KG
    var kg_rate = ton_rate / 1000;         // Ton Rate → KG Rate

    // Auto set values
    $("#Quantity_" + id).val(kg_qty);
    $("#Rate_" + id).val(kg_rate.toFixed(2));
});
	
	
	// Start Remove row script
	$("#Sale_EntriesTable").on("click", ".remove", function (event) {
        $(this).closest("tr").remove();       
        counter -= 1
	});
	
	/*
		newRow.append(cols);
		$("#Sale_EntriesTable").append(newRow);
	 */
	

	// https://forum.jquery.com/topic/inserting-a-row-into-an-empty-table
     // Calculating total Quantity and Amount Script
     
     
   /*  $('body').on("keyup", "tr.txtMult", function(e) {
	 
	 $("#Sale_EntriesTable .Quantity").each(function () {
	     
	  var Quantity = $(this).val();
	  var ProductId = $('.hdnProductId', this).val();
	  
	    if ($.isNumeric(Quantity)) 
	    {
		//alert(ProductId);
		
	    }
	  });
   });
     
     */
             
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
    var TotalTaxAmount2 = 0;
    var TotalAmount = 0;
    var NetAmount = 0;
    var TotalNetAmount = 0;
    var total_tax=0
    var TotalGSTAmount = 0;
    var FurtherTacAmount=0;
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
      TotalAmount += parseFloat(NetAmount);
      TotalTaxAmount2 +=  parseFloat(TaxAmount);
      TotalNetAmount +=  parseFloat(NetAmount);  
      TotalGSTAmount+=  parseFloat(TaxPercentage);
      FurtherTacAmount +=parseFloat(FurtherTaxAmt);
  });
  
    var totaltax= $('#totaltax').val();
    
    if(totaltax!=0){
      // total_tax=((TotalNetAmount*totaltax)/100)
      total_tax=Number(totaltax)
      TotalNetAmount=TotalNetAmount-total_tax;
      TotalDiscount+=total_tax;
    }
	      $('#TotalTaxAmount').val(total_tax)
        $('#Quantity').text((TotalQuantity).toFixed(2))
        $('#Amount').text((TotalAmount).toFixed(2))
        $('#TaxAmount').text((TotalTaxAmount2).toFixed(2));
        $('#DiscountAmount').text((TotalTaxAmount2).toFixed(2));
        $('#FurtherTacAmount').text((FurtherTacAmount).toFixed(2));
        $('#TotalAmount').text((TotalNetAmount).toFixed(2));
        $('#TotalGSTAmount').text((TotalGSTAmount).toFixed(2));
      }
  });  

 $(function(){

    $("#SaleType").on('change', function(){
      if($("#SaleType").val() == "1")
      {
        $("#BankAccountId").attr('disabled', true);
        $("#cash-received").hide();
      }

      if($("#SaleType").val() == "2")
      {
        $("#BankAccountId").attr('disabled', true);
        $("#cash-received").show();
      }

      if($("#SaleType").val() == "3" || $("#SaleType").val() == ""){
        $("#BankAccountId").attr('disabled', false);
        $("#cash-received").hide();
      }
      
    })


      // add new customer from modal box shortcut in sale component
    $("#SaveCustomer").click(function(){
      var CustomerName = $("#CustomerName").val();
      var ContactName = $("#ContactName").val();
      var Address = $("#Address").val();
      var Email = $("#Email").val();
      var PhoneNo = $("#PhoneNo").val();
      var CellNo = $("#CellNo").val();
      var FaxNo = $("#FaxNo").val();
      var Website = $("#Website").val();

        if(CustomerName == "" || CustomerName == 0 || CustomerName == null){
          $("#CustomerName").css('border-color', 'red');
          alert("Please Enter Customer Name");
          return false;
        }

      $.ajax({
          url: '<?php echo base_url("Customer/SaveCustomer")?>',
          type: 'post',
          dataType: 'html',
          data: {CustomerName:CustomerName,ContactName:ContactName,Address:Address,Email:Email,PhoneNo:PhoneNo,CellNo:CellNo,FaxNo:FaxNo,Website:Website},
          success: function(response){
            $('#CustomerId').load('<?php echo base_url("Sales/AllCustomers")?>')
            $('#SuccessMsg').text('Customer added Successfuly...!')
//            $('input').val('');
            $('#Customer').find('input').val("");
          }
      });

      });

      // add new reference from modal box shortcut in sale component
    $("#SaveReference").click(function(){
      var FullName = $("#FullName").val();
      var ContactNumber = $("#ContactNumber").val();
      var ReferenceAddress = $("#ReferenceAddress").val();
      var ReferenceEmail = $("#ReferenceEmail").val();

        if(FullName == "" || FullName == 0 || FullName == null){
          $("#FullName").css('border-color', 'red');
          alert("Please Enter Reference Name");
          return false;
        }
      $.ajax({
          url: '<?php echo base_url("Reference/SaveReference")?>',
          type: 'post',
          dataType: 'html',
          data: {FullName:FullName,ContactNumber:ContactNumber,Address:ReferenceAddress,Email:ReferenceEmail},
          success: function(response){
            $('#ReferenceId').load('<?php echo base_url("Sales/AllReferences")?>')
            $('#SuccessReferenceMsg').text('Reference added Successfuly...!')
//            $('input').val('');
            $('#Reference').find('input').val("");
          }
      });

    });

    // Auto Select Produt List
    //$(document).on('keyup','input[id^=ProductName]',function(){ 
 /*   $('body').on("keyup", "input[id^=ProductId]", function(){
      
            var  ProductId  = ($(this).attr('id'));
            var  ProductName = $(this).val();
      
            $(this).autocomplete({
    
                source: function(request, response)   {
                    $.ajax({
                        url: "<?php // echo site_url('Sales/AutoCompleteProductList')?>",
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
//                    $("#hdn"+ProductId).val(ui.item.id); // save selected id to hidden input
                    },
                minLength: 2
            });
        }); 

*/
 /*       $(document).on('focusout','input[id^=ProductName]',function(){
            var id = $(this).attr('id');
            var Attr = id.split("_");
            var IdAttr = Attr[1];

            var PId2 = window.PId;

            $.ajax({
               type: 'POST',
               dataType: 'html',
               data: ('ProductId='+PId2),
               url: "<?php // echo base_url('Sales/GetRemainingProduct'); ?>",
               success: function(response){
                $('#Quantity'+IdAttr).val(response);
               }
            });
        })
            IdR = 0;
    */

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

/*            $('body').on('change', 'input[id^=LocationName]', function(){
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
            });*/

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
              if(CustomerId == "" || CustomerId == null)
              {
                 //alert("Please fill this field");
                 $(this).css('border-color', 'red');
                 e.preventDefault();
                 $(this).focus;
              }
              if(CustomerId != "" || CustomerId != 0){
                $(this).css('border-color', 'green');
              }
          SNo++;
            });
          });


      });    // end of main jQuery


</script>

<script>
$(function(){
  // Autocomplete Search Product Name
  $(document).on('keyup','input[id^=ProductId]',function(){
    
    var ProductId = ($(this).attr('id'));
    var ProductName= $(this).val();
    
    $(this).autocomplete({
    
    source: function(request, response) {
    $.ajax({
        url: "<?php echo site_url('Sales/AutoCompleteProductList')?>",
        data: { ProductName:ProductName },
        dataType: "json",
        type: "POST",
        success: function(data) {
//      console.log(data);
        response(data);
//      alert(data.id);
        }
     });
    },
    select: function (event, ui) {
     $(this).val(ui.item.value); // display the selected text
     var p = ui.item.id.split('-');
     $("#hdn"+ProductId).val(p[0]);
     var nextTxtId = ProductId.replace ( /[^\d.]/g, '' );
    //  console.log(nextTxtId);
     $("#EngineNo_"+nextTxtId).val(ui.item.Openi);
    $("#ChassisNo_"+nextTxtId).val(ui.item.Pro);
    
    $("#txtCode"+nextTxtId).val(ui.item.barcode);
      window.ProductId = p[0];
      window.Rate = p[1];
    // var id = $(this).attr('id');
     //var Attr = id.split("_");
  //   window.IdAttr = Attr[1];
   //  $("#hdn"+ProductId).val(ui.item.id); // save selected id to hidden input
    // window.PId = ui.item.id;
    },
    minLength: 2
     });    
    });
    
    
    $(document).on('focusout','input[id^=ProductId]',function(){
    
    var txtId = $("input[id^=ProductId]:last").attr("id");
    var txtId = $(this).attr("id");
    var nextTxtId = txtId.replace ( /[^\d.]/g, '' );
    
    // on focus out insert / update product record in cart table
    $.ajax({
        type: "POST",
	dataType: "json",
	url: "<?php echo site_url('Sales/AutoAddProductInCart')?>",
	data: { ProductId:window.ProductId },
        success: function(data) {
//      console.log(data);  
        response(data);
	$("#SaleCartId"+nextTxtId).val(window.Rate);
//      alert(data.id); hdnProductId
        }
     });
     
      $.ajax({
        type: "POST",
	dataType: "json",
	url: "<?php echo site_url('Sales/GetProductLastSalePrice')?>",
	data: { ProductId:window.ProductId },
	success:function(data){
	    
	$("#LastSalePrice_"+nextTxtId).val(data);
 //       $('#ShowData').html(data)
//	$('#showMsg').text('')
      }
     });
     
     $.ajax({
        type: "POST",
	dataType: "json",
	url: "<?php echo site_url('Sales/GetAvailableQty')?>",
	data: { ProductId:window.ProductId },
	success:function(data){
	    
	$("#AvailableQty_"+nextTxtId).val(data);
      }
     });
     
     $.ajax({
        type: "POST",
	dataType: "json",
	url: "<?php echo site_url('Sales/GetProductLastPurchasePrice')?>",
	data: { ProductId:window.ProductId },
	success:function(data){
	    
	$("#LastPurchasePrice_"+nextTxtId).val(data);
 //       $('#ShowData').html(data)
//	$('#showMsg').text('')
      }
     });
     
      $.ajax({
        type: "POST",
    	dataType: "json",
    	url: "<?php echo site_url('Sales/GetProductSaleRates')?>",
    	data: { ProductId:window.ProductId },
    	success:function(data){
    	    
    	$("#Rate_"+nextTxtId).val(data);
      }
     });
    
    // $("#ProductGroupId"+nextTxtId).text(PG);
     //$("#Rate"+nextTxtId).val(window.Rate);
     
    })
    
    /*
	$.ajax({
	    type:"post",
	    url:"<?php // echo base_url('Sales/SearchProductByBarcode'); ?>",
	    dataType: 'html',
	    data:{Barcode : Barcode},
	    success: function(data){
	    $('#ItemList').html(data)
	    $("#txtCode").val('');
	    $("#txtCode").focus();
	    }
	});	
	*/
	
    /*   var counter = 0;
    $(document).on('focusout','input[id^=ProductId]',function(){

      var PId2 = window.PId;
      var IdR = window.IdAttr;
//      var Rate =
    $.ajax({
      url: '<?php // echo base_url(); ?>Sales/GetRemainingProduct',
      data:{Product:PId2,VendorId:VendorId},
      type: 'post',
      dataType: 'html',
      success:function(data){
        var SN = $("#SN").val();
        if(data == "0"){
//        for (var i = 1; i < SN.length; i++) {
          alert("Rate is not defined for this vendor/product");
//          console.log($("#Rate_"+counter).val(data));
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
    })
    }
    })*/

  });

 </script>

  <script type="text/javascript">

  $(function(){
      $("#CustomerId").on('change', function(){
        var CustomerArray = $("#CustomerId").val();
        var CustomerArraySplit = CustomerArray.split("-");
        var CustomerId = CustomerArraySplit[0];
        var CoAId = CustomerArraySplit[1];

        $.ajax({
          url: '<?php echo base_url() ?>Sales/AccountReceivableAmount',
          type: 'post',
          dataType: 'html',
          data: {CustomerId:CustomerId,CoAId:CoAId},
          success:function(response){
            $("#AccountReceivable").html("Account Receivable Amount is: "+response);

          },
          error:function(){
            alert('no record found');
          }
        })
        
        
        $.ajax({
          url: '<?php echo base_url() ?>Sales/CustomerWiseData',
          type: 'post',
          dataType: 'json',
          data: {CustomerId:CustomerId,CoAId:CoAId},
          success:function(response){
              console.log(response.CustomerName)
            $("#fbr_customer").val(response.Address);
            $("#fbr_cnic").val(response.Email);
            $("#fbr_mobile").val(response.CellNo);
            $("#fbr_ntn").val(response.PhoneNo);

          },
          error:function(){
            alert('no record found');
          }
        })
      })
  })
 </script> 
 <script>
  $(document).ready(function() {
    $("#ReferenceId").change(function(){
      $("#ReferenceName").val(("#ReferenceId").find(":selected").text());
	  $(this).parent().hide();
    });
  });
</script>
<script type="text/javascript">

 // This is barcode searching script
    $(document).ready(function () {
    
    var keyupFiredCount = 0; 

    function DelayExecution(f, delay) {
        var timer = null; 
        return function () {
            var context = this, args = arguments;
           
            clearTimeout(timer);
            timer = window.setTimeout(function () {
                f.apply(context, args);
            },
            delay || 300);
        };
    }
    $.fn.ConvertToBarcodeTextbox = function () {

        $(this).focus(function () { $(this).select();$("#msg").html(""); });

         $(this).keydown(function (event) {
            var keycode = (event.keyCode ? event.keyCode : event.which); 
            
            if ($(this).val() == '') {
                keyupFiredCount = 0; 
            }  
            if (keycode == 13) {//enter key 
                    $(".nextcontrol").focus();
                    return false;
                    event.stopPropagation(); 
            } 
        });

        $(this).keyup(DelayExecution(function (event) {
            var keycode = (event.keyCode ? event.keyCode : event.which);  
                keyupFiredCount = keyupFiredCount + 1;  
        }));

         $(this).blur(function (event) {
             if ($(this).val() == '')
                 return false;
	     
            if(keyupFiredCount <= 1)
	    {
		var Barcode = $(this).val();
		
		$.ajax({
		  type:"post",
		  url:"<?php echo base_url('Sales/SearchProductByBarcode'); ?>",
		  dataType: 'html',
	  	  data:{Barcode : Barcode},
		  success: function(data){
		 $('#ItemList').html(data)
		 $("#txtCode").val('');
		 $("#txtCode").focus();
		 }
		});		
		
		
		/*
		$("#Sale_EntriesTable").append(newRow());
		$("#txtCode").val('');
		$("#txtCode").focus();
				
		function newRow() {

		var counter = $("#Sale_EntriesTable tr").length -1;
		counter++;

		var cols = '<tr><td style="margin-top:15px;line-height:25px">'+ counter + '</td>';  
		cols += '<td><input style="width:90px;margin-top:1px;" name="ProductName[]" type="text" value="'+ Barcode +'" id="ProductName_'+ counter +'" name="ProductName[]"><input style="width:90%;" type="hidden" id="hdnProductName_'+ counter +'" name="ProductId[]"></td>';
		cols += '<td style="text-align:center;"><input style="width:90%; margin-top:1px;" class="select2" type="text" id="LocationName_'+ counter +'" name="LocationName_[]"><input style="width:90%;" type="hidden" id="hdnLocationName_'+ counter +'" name="LocationId[]"></td>';
		cols += '<td style="text-align:center;"><input style="width:90%; margin-top:1px;" class="select2" type="text" id="ColourName_'+ counter +'" name="ColourName[]"><input style="width:90%;" type="hidden" id="hdnColourName_'+ counter +'" name="ColourId[]"></td>';
		cols += '<td><input style="width:90%; margin-top:1px; text-align:right;" type="number" id="Rate'+ counter +'" class="Rate" name="Rate[]" autocomplete="off" step="0.00"></td>';
		cols += '<td><input style="width:100%; margin-top:1px; text-align:right;" type="number" id="Quantity_'+counter+'" class="Quantity" name="Quantity[]" autocomplete="off" step="0.00"></td>';
		cols += '<td><input style="width:90%; margin-top:1px; text-align:right;" type="number" id="Amount'+ counter +'" class="Amount" name="Amount[]" step="0.00"></td>';
		cols += '<td><input style="width:90%; margin-top:1px; text-align:right;" type="number" id="DiscountAmount'+ counter +'" class="DiscountAmount" name="DiscountAmount[]" step="0.00"></td>';
		cols += '<td><input style="width:90%; margin-top:1px; text-align:right;" type="number" id="TaxPercentage'+ counter +'" class="TaxPercentage" name="TaxPercentage[]" step="0.00"></td>';
		cols += '<td><input style="width:90%; margin-top:1px; text-align:right;" type="number" id="TaxAmount'+ counter +'" value="0.00" class="TaxAmount" name="TaxAmount[]" step="0.00"></td>';
		cols += '<td><input style="width:90%; margin-top:1px; text-align:right;" type="number" id="NetAmount'+ counter +'" class="NetAmount" name="NetAmount[]" step="0.00"></td>';
		cols += '<td><i class="fa fa-trash remove" title="Delete" style="cursor:pointer; margin-top:6px; color:red;"></i></td>';

		return cols;
		};
		
		*/
	
	ve
                //$("#msg").html("<span style='color:green'>Its Scanner!</span>");
		
		/*
		var txtId = $("input[id^=Quantity]:last").attr("id");
		var arr = txtId.split("_");
		var counter = (parseInt(arr[1]) +1);
		 
		var newRow = $("<tr>");
		var cols = "";
		cols += '<td style="margin-top:15px;line-height:25px">' + counter + '</td>';
		cols += '<td><input style="width:90px;margin-top:1px;" class="select2" name="ProductName[]" type="text" value="'+Barcode+'" id="ProductName_'+ counter +'" name="ProductName[]"><input style="width:90%;" type="hidden" id="hdnProductName_'+ counter +'" name="ProductId[]"></td>'
		cols += '<td style="text-align:center;"><input style="width:90%; margin-top:1px;" class="select2" type="text" id="LocationName_'+ counter +'" name="LocationName_[]"><input style="width:90%;" type="hidden" id="hdnLocationName_'+ counter +'" name="LocationId[]"></td>';
		cols += '<td style="text-align:center;"><input style="width:90%; margin-top:1px;" class="select2" type="text" id="ColourName_'+ counter +'" name="ColourName[]"><input style="width:90%;" type="hidden" id="hdnColourName_'+ counter +'" name="ColourId[]"></td>';
		cols += '<td><input style="width:90%; margin-top:1px; text-align:right;" type="number" id="Rate'+ counter +'" class="Rate" name="Rate[]" autocomplete="off" step="0.00"></td>';
		cols += '<td><input style="width:100%; margin-top:1px; text-align:right;" type="number" id="Quantity_'+counter+'" class="Quantity" name="Quantity[]" autocomplete="off" step="0.00"></td>';
		cols += '<td><input style="width:90%; margin-top:1px; text-align:right;" type="number" id="Amount'+ counter +'" class="Amount" name="Amount[]" step="0.00"></td>';
		cols += '<td><input style="width:90%; margin-top:1px; text-align:right;" type="number" id="DiscountAmount'+ counter +'" class="DiscountAmount" name="DiscountAmount[]" step="0.00"></td>';
		cols += '<td><input style="width:90%; margin-top:1px; text-align:right;" type="number" id="TaxPercentage'+ counter +'" class="TaxPercentage" name="TaxPercentage[]" step="0.00"></td>';
		cols += '<td><input style="width:90%; margin-top:1px; text-align:right;" type="number" id="TaxAmount'+ counter +'" class="TaxAmount" name="TaxAmount[]" step="0.00"></td>';
		cols += '<td><input style="width:90%; margin-top:1px; text-align:right;" type="number" id="NetAmount'+ counter +'" class="NetAmount" name="NetAmount[]" step="0.00"></td>';
		cols += '<td style="width:50px;text-align:right; cursor:pointer; color:red;"><i class="fa fa-trash remove" title="Delete" style="margin-top:1px;"></i></td>';

		newRow.append(cols);
		$("#Sale_EntriesTable").append(newRow);
		*/
             }
             else 
             {
                 $("#msg").html("<span style='color:red'>Its Manually Typed!</span>");
                 //alert('Its Manual Entry');
             }

             keyupFiredCount = 0;
         }); 
    };
    try {
        $(".barcodeinput").ConvertToBarcodeTextbox();
        if ($(".barcodeinput").val() == '')
            $(".barcodeinput").focus();
        else
            $(".nextcontrol").focus(); 
    } catch (e) { }

});

</script>
<script type="text/javascript">
  $(function(){
  
       // Validation of Bill Quantity with Stock and Sale Order Quantity TaxPercentage
       $('body').on("keyup", "input[id^=Quantity]", function() {    

	  var Quantity = $(this).attr('id');
          var arr = Quantity.split("_")
	  
	   var Quantity = $(this).val();
	   var SaleCartId = parseInt($("#SaleCartId_"+arr[1]).val());
	   
	   var Rate = parseInt($("#Rate_"+arr[1]).val());
	   var DiscountAmount = parseInt($("#DiscountAmount_"+arr[1]).val());
	    
	   $.ajax({
              url:"<?php echo base_url('Sales/UpdateCart')?>",
              type:'post',
              data:{SaleCartId:SaleCartId,Quantity:Quantity,Rate:Rate,DiscountAmount:DiscountAmount},
              success:function(){
	
              }
             });	  
	 });  
	
        });  
</script>