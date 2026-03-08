<?php 
$this->load->view("includes/header");
$this->load->view("includes/sidebar");

$Company = '<select name="ReferenceId" id="ReferenceId" style="width:215px;" class="form-control select2">';
$Company .= '<option value="">Select Company</option>';
foreach ($AllReferences as $ReferenceRecord) {
$Company .=  '<option value='.$ReferenceRecord['ReferenceId'].'>'.$ReferenceRecord['FullName'].'</option>';
}
$Company .= '</select>';
?>
<script src="<?php echo site_url();?>/lib/js/autocompletejs/jquery-ui.js"></script>
<link rel="stylesheet" href="<?php echo site_url();?>/lib/css/autocompletecss/jquery-ui.css"/>

<div class="content-wrapper">
    <section class="content-header">
        <h1><i class="fa fa-file-text-o"></i>&nbsp; Add Invoice Receipt</h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url(); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Invoice Receipt</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title text-primary"><i class="fa fa-plus-circle"></i> Add New Invoice Receipt</h3>
                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                        </div>
                    </div>
                    
                    <?php if($this->session->flashdata('record_update')): ?>
                    <div class="alert alert-success alert-dismissible" style="margin:15px;">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <h4><i class="icon fa fa-check"></i> Success!</h4>
                        <?php echo $this->session->flashdata('record_update'); ?>
                    </div>
                    <?php endif; ?>
                    
                    <form role="form" class="form-horizontal" id="SaleOrderForm" action='<?php echo base_url("InvoiceReceipt/SaveMultiInstallment") ?>' method="post" enctype="multipart/form-data">
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="col-sm-4 control-label">Customer Name:</label>
                                        <div class="col-sm-8">
                                            <select class="form-control select2" name="customer_name" id="customer_name" required>
                                                <option value="">Select Customer</option>
                                                <?php foreach($AllCustomers as $Customers){ ?>
                                                <option value="<?php echo $Customers['CustomerId'] ?>"><?php echo $Customers['CustomerName']; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="col-sm-4 control-label">Department:</label>
                                        <div class="col-sm-8">
                                            <input type="text" name="area" class="form-control" id="department" style="color:#008000">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
<div class="row">
    <div class="col-md-12">
        <div class="box box-solid" style="border-top: 3px solid #3c8dbc;">
            <div class="box-header with-border" style="background-color: #f8f9fa; border-bottom: 1px solid #dee2e6;">
                <h3 class="box-title" style="color: #2c3e50; font-weight: 600; letter-spacing: 0.5px;">
                    <i class="fas fa-file-invoice-dollar"></i> DUE INVOICES
                </h3>
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                </div>
            </div>
            <div class="box-body" style="padding: 15px;">
                <div class="table-responsive">
                    <table id="GJ_EntriesTable" class="table table-bordered table-striped table-hover">
                        <thead>
                            <tr style="background-color: #2c3e50; color: white;">
                                <th width="5%" class="text-center"><i class="far fa-check-square"></i></th>
                                <th width="5%" class="text-center">S.#</th>
                                <th width="15%" class="text-center">INVOICE NO</th>
                                <th width="15%" class="text-center">INVOICE DATE</th>
                                <th width="12%" class="text-center">AMOUNT</th>
                                <th width="10%" class="text-center">INCOME TAX</th>
                                <th width="10%" class="text-center">WH TAX</th>
                                <th width="13%" class="text-center">TOTAL DEDUCTION</th>
                                <th width="10%" class="text-center">CHEQUE AMOUNT</th>
                                <th width="15%" class="text-center">REMAINING</th>
                            </tr>
                        </thead>
                                                    <tbody>
                                                        <!-- Table content will be generated dynamically -->
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="col-sm-4 control-label">Payment Type:</label>
                                        <div class="col-sm-8">
                                            <select name="payment_type" id="payment_type" class="form-control" required>
                                                <option value="">Select Payment Type</option>
                                                <option value="1">On Cash</option>
                                                <option value="2">On Bank</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="col-sm-4 control-label">Bank Account:</label>
                                        <div class="col-sm-8">
                                            <select name="bank_account_id" id="bank_account_id" class="form-control" required>
                                                <option value="0">Select Bank Account</option>
                                                <?php foreach ($GetAllBankAccounts as $BankAccounts) { ?>
                                                <option value="<?php echo $BankAccounts['AccountId'] . "-" .$BankAccounts['ChartOfAccountId']; ?>">
                                                    <?php echo $BankAccounts['AccountTitle'] . " - " . $BankAccounts['AccountNumber']; ?>
                                                </option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="col-sm-4 control-label">Cheque No:</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" name="slip_no" placeholder="Instrument/Cheque number">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="col-sm-4 control-label">Date:</label>
                                        <div class="col-sm-8">
                                            <input type="date" class="form-control" name="date">
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="col-sm-4 control-label">Attachment:</label>
                                        <div class="col-sm-8">
                                            <input type="file" class="form-control" name="copy">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">Notes:</label>
                                        <div class="col-sm-10">
                                            <textarea name="Note" class="form-control" rows="3" placeholder="Enter any additional notes here..."></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="box-footer">
                            <div class="row">
<div class="col-md-12">
    <div class="form-group">
        <div class="col-sm-12" style="margin-top: 20px;">
            <button type="submit" name="submitForm" value="AddRecord" class="btn btn-danger" style="padding: 8px 20px;">
                <i class="fas fa-save fa-lg"></i> Save Record
            </button>
            <a href="<?php echo base_url(); ?>GeneralJournal/" class="btn btn-default" style="padding: 8px 20px; margin-left: 10px; border: 1px solid #ddd;">
                <i class="fas fa-arrow-left fa-lg"></i> Back
            </a>
        </div>
    </div>
</div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>

<script>

$('#customer_name').on('change', function() {
 
   var customer_name = this.value;
    $.ajax({
        type: 'POST',
        dataType: 'html',
        data: {customer_name:customer_name},
        url: "<?php echo base_url('InvoiceReceipt/AutoMultiCompleteSearch_COA'); ?>",
        success: function(response){
          var payObject = JSON.parse(response);
          $("tbody").html('');
          var a=1
          payObject.forEach(myFunction);
            function myFunction(item, index) {
     
            var row='';
        row+= "<tr id='row_"+index+"'>";
	    row += "<td><input type='checkbox'   name='tick[]' data-id='"+index+"'   value='"+item.SaleId+"' id='tick' onclick='checkbox("+index+")' class='tick'></td>";
		row+= "<td>"+a+"</td>";
		row+= "<td><input style='width:100%; text-align:left;' type='text'name='invoice_no["+item.SaleId+"]' id='Invoiceno_"+index+"' value='"+item.SaleId+"' /></td>";
		row+= "<td><input style='width:100%; text-align:left;' type='text' name='Invoicedate["+item.SaleId+"]' id='Invoicedate_"+index+"'  value='"+item.SaleDate+"'/></td>";
		row+= "<td><input style='width:100%; text-align:left;color:purple' type='text' name='outstanding_amount["+item.SaleId+"]' id='Invoiceamount_"+index+"'   value='"+item.PreviousBalance+"'/></td>";
		row+= "<td><input style='width:100%; text-align:left;' onkeyup='inputbtn("+index+")' type='text' value='0' name='Itax["+item.SaleId+"]' id='Itax_"+index+"' autocomplete='off'/></td>";
		row+= "<td><input style='width:100%; text-align:left;' onkeyup='inputbtn("+index+")' type='text' value='0' name='Stampduty["+item.SaleId+"]' id='Stampduty_"+index+"' autocomplete='off'/></td>";
		//row+= "<td><input style='width:100%; text-align:left;' onkeyup='inputbtn("+index+")'type='text' value='0' name='Gst["+item.SaleId+"]' id='Gst_"+index+"' autocomplete='off'/></td>";
		//row+= "<td><input style='width:100%; text-align:left;' onkeyup='inputbtn("+index+")'type='text' value='0' name='LatePayment["+item.SaleId+"]' id='latepayment_"+index+"' autocomplete='off'/></td>";
		//row+= "<td><input style='width:100%; text-align:left;' onkeyup='inputbtn("+index+")'type='text'value='0'  name='OtherExp["+item.SaleId+"]' id='Otherexpense_"+index+"' autocomplete='off'/></td>";
	    row+= "<td><input style='width:100%; text-align:left;color:#008000' onkeyup='inputbtn("+index+")'type='text' value='0' name='remarks["+item.SaleId+"]'  id='Totaldeduction_"+index+"' autocomplete='off'/></td>";
		row+= "<td><input style='width:100%; text-align:left;color:#002480' type='text' name='amount["+item.SaleId+"]'onkeyup='checkbtn("+index+")'   id='Chequeamount_"+index+"' value='"+item.PreviousBalance+"' /></td>";
		row+= "<td><input style='width:100%; text-align:left;color:#dd4b39' onkeyup='inputbtn("+index+")' type='text'  name='Remainingamount["+item.SaleId+"]' id='Remainingamount_"+index+"' value='"+item.PreviousBalance+"'/></td>";
	    row+= "</tr>";
	    a++;
	    $("#GJ_EntriesTable").append(row);
	    
	    $('#department').val(item.AreaName);
	     $('#ChartOfAccountId').val(item.ChartOfAccountId);
            }
             var row='';
         row+= "<tr >";
	    row+= "<td></td>";
	    row+= "<td></td>";
		row+= "<td></td>";
		row+= "<td></td>";
		row+= "<td id='totInvoiceamount' style='color:purple'></td>";
		row+= "<td id='totItax'></td>";
		row+= "<td id='totStampduty'></td>";
// 		row+= "<td id='totGst'></td>";
// 		row+= "<td id='totlatepayment'></td>";
// 		row+= "<td id='tototherExpense'></td>";
		row+= "<td id='totTotaldeduction'  style='color:#008000'></td>";
		row+= "<td id='totChequeamount' style='color:#002480'></td>";
		row+= "<td id='totRemainingamount' style='color:#dd4b39'></td>";
		row+= "</tr>"
        $("#GJ_EntriesTable").append(row);
        //  $("#customer_name").val(payObject[0].CustomerName);
        //  $("#client_id").val(payObject[0].CustomerId);
        //  $("#ChartOfAccountId").val(payObject[0].ChartOfAccountId);
        //  $("#area").val(payObject[0].AreaName);
        //  $("#outstanding_amount").val(payObject[0].PreviousBalance);
        }
      });
    
    
    
});
function checkbtn(id){
      Invoiceamount=parseInt($('#Invoiceamount_'+id).val());
      totChequeamount= $('#Chequeamount_'+id).val();
       totRemainingamount=$('#Totaldeduction_'+id).val();
       Remainingamount=Invoiceamount-totChequeamount-totRemainingamount;
       parseInt($('#Remainingamount_'+id).val(Remainingamount));
}
function inputbtn(id){
// $( "input" ).on( "keyup", function() {
// $("input").keyup(function(){
   

            // id=$(this).val();
            tottax=0;
            Invoiceamount=parseInt($('#Invoiceamount_'+id).val());
            totItax=parseInt($('#Itax_'+id).val());
            totStampduty=parseInt($('#Stampduty_'+id).val());
            // totGst=parseInt($('#Gst_'+id).val());
            // totlatepayment=parseInt($('#latepayment_'+id).val());
            totTotaldeduction=parseInt($('#Totaldeduction_'+id).val());
            // tototherExpense=parseInt($('#Otherexpense_'+id).val());
            
            // totItax=parseInt(totItax)*parseInt(Invoiceamount)/100;
            // totStampduty=parseInt(totStampduty)*parseInt(Invoiceamount)/100;
            // totGst=parseInt(totGst)*parseInt(Invoiceamount)/100;
            // console.log(parseInt(totItax), parseInt(totStampduty), parseInt(totGst) , parseInt(totlatepayment) , parseInt(tototherExpense));
            // +parseInt(totGst)+parseInt(totlatepayment)+parseInt(tototherExpense
            tottax=parseInt(totItax)+parseInt(totStampduty)
            totChequeamount=Invoiceamount-tottax;
            $('#Chequeamount_'+id).val(totChequeamount);
            Remainingamount=Invoiceamount-tottax-totChequeamount;
           
             parseInt($('#Totaldeduction_'+id).val(tottax));
             parseInt($('#Remainingamount_'+id).val(Remainingamount));
          checkbox();
       
};

  function checkbox(id){
      
   Invoiceamount=0;
    totItax=0;
    totStampduty=0;
    totGst=0;
    totlatepayment=0;
    totTotaldeduction=0;
    tototherExpense=0;
     totRemainingamount=0;
     totChequeamount=0;
    
    $('.tick').each(function () {
        if (this.checked) {
            id=$(this).data("id");
            
            Invoiceamount+=parseInt($('#Invoiceamount_'+id).val());
            console.log(Invoiceamount);
            console.log();
            totItax+=parseInt($('#Itax_'+id).val());
            totStampduty+=parseInt($('#Stampduty_'+id).val());
            totGst+=parseInt($('#Gst_'+id).val());
            totlatepayment+=parseInt($('#latepayment_'+id).val());
            totTotaldeduction+=parseInt($('#Totaldeduction_'+id).val());
            tototherExpense+=parseInt($('#Otherexpense_'+id).val());
             totChequeamount+=parseInt($('#Chequeamount_'+id).val());
              totRemainingamount+=parseInt($('#Remainingamount_'+id).val());
          
        }
    });
    $('#totInvoiceamount').html(Invoiceamount)
    $('#totItax').html(totItax)
    $('#totStampduty').html(totStampduty)
    $('#totGst').html(totGst)
    $('#totlatepayment').html(totlatepayment)
    $('#totTotaldeduction').html(totTotaldeduction)
    $('#tototherExpense').html(tototherExpense)
    $('#totChequeamount').html(totChequeamount)
    $('#totRemainingamount').html(totRemainingamount)
  };
  </script>
<?php  $this->load->view("includes/footer"); ?> 