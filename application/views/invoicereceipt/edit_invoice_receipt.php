<?php $this->load->view('includes/header'); ?>
<?php $this->load->view('includes/sidebar'); ?>
<?php 
$References = '<select name="ReferenceId" style="width:200px; margin-top:1px;">';
$References .= '<option value="0">Select Reference</option>';
foreach ($AllReferences as $ReferenceRecord) {
$References .= '<option value='.$ReferenceRecord['ReferenceId'].'>'.$ReferenceRecord['FullName'].'</option>';
}
$References .= '</select>';
?>

      <!-- /.main-content starts -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1><i class="fa fa-book"></i>&nbsp;Invoice Receipt</h1>
    </section>
    
    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-md-12">
          <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title text-light-blue">Update Invoice Receipt</h3>
            </div>
<?php echo "<font style=color:#00468E; font-weight:bold text-align:center;>".$this->session->flashdata('record_update')."</font>"; ?>

 <form class="form-horizontal" method="post" action="<?php echo base_url("InvoiceReceipt/UpdateInvoiceReceipt"); ?>" name="basic_validate" id="basic_validate" novalidate="novalidate">
    <div class="box-body">

      <div class="form-group">
        <label for="ProductName" class="col-sm-1 control-label">Date</label>
        <div class="col-sm-4">
          <input class="form-control" name="date" type="text" value="<?php echo date("m/d/Y", strtotime($GetInvoiceReceipt['GeneralJournal']->TransactionDate)); ?>" autocomplete="on">
        </div>
      </div>

      <div class="form-group">
        <label for="ProductName" class="col-sm-1 control-label">Invoice No</label>
        <div class="col-sm-4">
          <input class="form-control" name="invoice_no" id="invoice_no" type="text" value="<?php echo $GetInvoiceReceipt['GeneralJournal']->SaleUniqueId; ?>" autocomplete="on">
        </div>
      </div>

      <div class="form-group">
        <label for="ProductName" class="col-sm-1 control-label">Customer Name</label>
        <div class="col-sm-4">
          <input class="form-control" style="color: #002480;font-weight:bold;" name="customer_name" id="customer_name" type="text" value="<?php echo $GetInvoiceReceipt['GeneralJournal']->CustomerName; ?>" autocomplete="on">
        </div>
      </div>

      <div class="form-group">
        <label for="ProductName" class="col-sm-1 control-label">Department</label>
        <div class="col-sm-4">
        <input class="form-control" name="area" id="area" type="text" style="color: #008000;font-weight:bold;" value="<?php echo $GetInvoiceReceipt['GeneralJournal']->Area_name; ?>" autocomplete="on">
        </div>
      </div>

      <div class="form-group">
        <label for="ProductName" class="col-sm-1 control-label">Invoice Balance:</label>
        <div class="col-sm-4">
          <input class="form-control" id="outstanding_amount" style="color: #c01043;font-weight:bold;" type="text" value="<?php echo $Balance[0]['PreviousBalance']; ?>" autocomplete="on" readonly>
        </div>
      </div>

      <div class="form-group">
        <label for="ProductName" class="col-sm-1 control-label">Payment Type</label>
        <div class="col-sm-4">
          <select name="payment_type" id="payment_type" class="form-control" required="required">
              <option <?php echo $GetInvoiceReceipt['GeneralJournal']->VoucherType == 3 ? 'selected=selected' : ''; ?> value="1">On Cash</option>
              <option <?php echo $GetInvoiceReceipt['GeneralJournal']->VoucherType == 2 ? 'selected=selected' : ''; ?> value="2">On Bank</option>
          </select>
        </div>
      </div>

      <div class="form-group">
        <label for="BankAccount" class="col-sm-1 control-label">Bank Account</label>
        <div class="col-sm-4">
          <select name="bank_account_id" id="bank_account_id" class="form-control" required="required">
              <option value="0">Select Bank Account</option>
                  <?php  foreach ($GetAllBankAccounts as $BankAccounts) { ?>
                  <option <?php echo $GetInvoiceReceipt['GeneralJournal']->BankAccountId == $BankAccounts['AccountId'] ? 'selected=selected' : '' ?> value="<?php echo $BankAccounts['AccountId'] . "-" .$BankAccounts['ChartOfAccountId']; ?>"><?php echo $BankAccounts['AccountTitle'] . " - " . $BankAccounts['AccountNumber'];  ?></option>
                  <?php
                  } ?>
          </select>
        </div>
      </div>

      <div class="form-group">
        <label for="ProductName" class="col-sm-1 control-label">Instrument / Cheque no</label>
        <div class="col-sm-4">
          <input class="form-control" name="slip_no" id="slip_no" type="text" value="<?php echo $GetInvoiceReceipt['GeneralJournal']->ReceiptNo;  ?>" autocomplete="on">
        </div>
      </div>

      <div class="form-group">
        <label for="ProductName" class="col-sm-1 control-label">Receipt Amount</label>
        <div class="col-sm-4">
          <input class="form-control" name="amount" id="amount" type="number" value="<?php echo $GetInvoiceReceipt['GeneralJournal']->TotalDebit;  ?>" autocomplete="on">
        </div>
      </div>

      <div class="form-group">
        <label for="ProductName" class="col-sm-1 control-label">Other Exp</label>
        <div class="col-sm-4">
          <input class="form-control" name="OtherExp" id="OtherExp" onkeyup='inputbtn(1)' type="text" value="<?php echo $GetInvoiceReceipt['GeneralJournal']->OtherExp;  ?>" autocomplete="on">
        </div>
      </div>

      <div class="form-group">
        <label for="ProductName" class="col-sm-1 control-label">Late Payment</label>
        <div class="col-sm-4">
          <input class="form-control" name="LatePayment" id="LatePayment" type="text" onkeyup='inputbtn(1)' value="<?php echo $GetInvoiceReceipt['GeneralJournal']->LatePayment;  ?>" autocomplete="on">
        </div>
      </div>
       <div class="form-group">
        <label for="ProductName" class="col-sm-1 control-label">GST</label>
        <div class="col-sm-4">
          <input class="form-control" name="Gst" id="Gst" type="text" onkeyup='inputbtn(1)' value="<?php echo $GetInvoiceReceipt['GeneralJournal']->gst;  ?>" autocomplete="on">
        </div>
      </div>
         <div class="form-group">
        <label for="ProductName" class="col-sm-1 control-label">WH Tax</label>
        <div class="col-sm-4">
          <input class="form-control" name="Stampduty" id="Stampduty" onkeyup='inputbtn(1)' type="text" value="<?php echo $GetInvoiceReceipt['GeneralJournal']->stampduty;  ?>" autocomplete="on">
        </div>
      </div>
      <div class="form-group">
        <label for="ProductName" class="col-sm-1 control-label">Income Tax</label>
        <div class="col-sm-4">
          <input class="form-control" name="Itax" id="Itax" onkeyup='inputbtn(1)' type="text" value="<?php echo $GetInvoiceReceipt['GeneralJournal']->itax;  ?>" autocomplete="on">
          <input class="form-control" name="client_id" id="client_id" type="hidden" value="<?php echo $GetInvoiceReceipt['GeneralJournal']->CustomerId;  ?>" autocomplete="on"> 
          <input class="form-control" name="ChartOfAccountId" id="ChartOfAccountId" type="hidden" value="<?php echo $Balance[0]['ChartOfAccountId'];  ?>" autocomplete="on">
          <input class="form-control" name="GeneralJournalId" id="GeneralJournalId" type="hidden" value="<?php echo $GeneralJournalId;  ?>" autocomplete="on">
        </div>
      </div>
    <div class="form-group">
        <label for="ProductName" class="col-sm-1 control-label">Total Deduction</label>
        <div class="col-sm-4">
          <input class="form-control" readonly name="remarks" id="remarks" type="text" value="<?php echo $GetInvoiceReceipt['GeneralJournal']->Detail;  ?>" autocomplete="on">
        </div>
      </div>

</div>
          
  <div class="row" style="display: block;" id="mainRow">
    <div class="col-md-12">
      <div class="box-body pad table-responsive">
    
        <div style="height: 50px;"></div>

          <div class="box-body">
              <div class="row">
                <div class="col-md-2">
                  <button type="submit" name="submitForm" value="AddRecord" id="AddRecord" class="btn btn-block btn-primary">Update Record</button>
                </div>
                <div class="col-md-2">
                  <a href="<?php echo base_url(); ?>InvoiceReceipt/"><button type="button" name="" value="cancelUpdate" class="btn btn-block btn-primary">Back to Main</button></a>
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
function inputbtn(id){
// $( "input" ).on( "keyup", function() {
// $("input").keyup(function(){
   

            // id=$(this).val();
            tottax=0;
            // Invoiceamount=parseInt($('#Invoiceamount_').val());
            totItax=parseInt($('#Itax').val());
            totStampduty=parseInt($('#Stampduty').val());
            totGst=parseInt($('#Gst').val());
            totlatepayment=parseInt($('#LatePayment').val());
            tototherExpense=parseInt($('#OtherExp').val());
            
            console.log(totItax);
            console.log(totStampduty);
            console.log(totGst);
            console.log(totlatepayment);
            console.log(tototherExpense);
            tottax=parseInt(totItax)+parseInt(totStampduty)+parseInt(totGst)+parseInt(totlatepayment)+parseInt(tototherExpense)
        
             parseInt($('#remarks').val(tottax));
          
       
};
inputbtn(1);

  $('body').on('keyup','input[id^=invoice_no]',function(){

      var InvoiceNumber = $("#invoice_no").val();

      $.ajax({
        type: 'POST',
        dataType: 'html',
        data: {InvoiceNumber:InvoiceNumber},
        url: "<?php echo base_url('InvoiceReceipt/AutoCompleteSearch_COA'); ?>",
        success: function(response){
          var payObject = JSON.parse(response);
         $("#customer_name").val(payObject[0].CustomerName);
         $("#client_id").val(payObject[0].CustomerId);
         $("#ChartOfAccountId").val(payObject[0].ChartOfAccountId);
         $("#area").val(payObject[0].AreaName);
         $("#outstanding_amount").val(payObject[0].PreviousBalance);
        }
      });

      })
</script>

<script>
  if($("#payment_type").val() == 1)
  {
    $("#bank_account_id").attr('disabled', true);
  }
  $("#payment_type").on('change', function(){
    
    if($("#payment_type").val() == "")
    {
      $("#bank_account_id").attr('disabled', true);
    }

    if($("#payment_type").val() == "1")
    {
      $("#bank_account_id").attr('disabled', true);
    }

    if($("#payment_type").val() == "2")
    {
      console.log($("#payment_type").val());
      $("#bank_account_id").attr('disabled', false);
    }

    })
</script>

<script>
  $(document).ready(function () {
   
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

    $('tr.txtMult').each(function () {

      var Quantity = $('.Quantity', this).val();
      var Rate = $('.Rate', this).val();
      var DiscountAmount = $('.DiscountAmount', this).val();

      var QuantityVal = (isNaN(parseFloat(Quantity))) ? 0 : parseFloat(Quantity);
      var RateVal = (isNaN(parseFloat(Rate))) ? 0 : parseFloat(Rate);
      var DiscountAmountVal = (isNaN(parseFloat(DiscountAmount))) ? 0 : parseFloat(DiscountAmount);

      var Amount = (QuantityVal * 1) * (RateVal * 1);

      var $TaxAmount = $('.TaxAmount', this).val();
      var $TaxPercentage = $('.TaxPercentage', this).val();
      
      var $Tax = ((Amount * $TaxPercentage) / 100); 
      
      $('.TaxAmount',this).val(($Tax).toFixed(2));
      
      if(DiscountAmountVal != 0) 
      {
	 // NetAmount = (Amount - DiscountAmountVal - $Tax);
	 NetAmount = (Amount - DiscountAmountVal);
      }
      else
      {
	// NetAmount = (Amount - $Tax);
	NetAmount = (Amount);
      }
      
      $('.Amount',this).val(Amount);
      $('.NetAmount',this).val(NetAmount);
       //TotalQuantity = (TotalQuantity * 1) + (QuantityVal * 1);
      TotalQuantity += QuantityVal;
      TotalDiscount += DiscountAmountVal;
      TotalAmount += Amount;
      TotalTaxAmount += $Tax + Amount;
      TotalNetAmount += NetAmount;

  });
      var totaltax= $('#totaltax').val();

      // console.log('tax',totaltax);
      
      if(totaltax!=0){
        // total_tax=((TotalNetAmount*totaltax)/100)
        total_tax=Number(totaltax)
        TotalNetAmount=TotalNetAmount-total_tax;
        TotalTaxAmount = TotalTaxAmount-total_tax;
        TotalDiscount+=total_tax;
      }

        $('#total_tax').val(total_tax)
        $('#Quantity').text((TotalQuantity).toFixed(2))
        $('#Amount').text((TotalAmount).toFixed(2))
        $('#TotalTaxAmount').text((TotalTaxAmount).toFixed(2));
        $('#DiscountAmount').text((TotalDiscount).toFixed(2));
        $('#TotalAmount').text((TotalNetAmount).toFixed(2));

      }
  });  

 </script>