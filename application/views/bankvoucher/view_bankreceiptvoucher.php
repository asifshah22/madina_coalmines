<?php 
$this->load->view("includes/header");
$this->load->view("includes/sidebar");
?>
 <div class="content-wrapper">
    <section class="content-header">
      <h1><i class="fa fa-book"></i>&nbsp;Bank Receipt Voucher</h1>
    </section>
    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-md-12">
          <!-- form elements --> 
          <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title text-light-blue">View Bank Receipt Voucher</h3>
            </div>
      
      <div class="box-body">
	 <div class="row invoice-info">
	    <div class="col-sm-2 form-group">
	      <strong>Voucher #:</strong><br>
		<?php echo $BankReceipt->ReferencePrefix.''.$BankReceipt->Reference; ?>
            </div>
	    <div class="col-sm-2 form-group">
	      <strong>Voucher Date:</strong><br>
		<?php echo date('M d, Y', strtotime($BankReceipt->TransactionDate)); ?>
	    </div>
	     <div class="col-sm-3 form-group">
	    <strong>Bank Account:</strong><br>
	    <?php echo $BankReceipt->AccountTitle; ?>
            </div>
	 </div> 
      </div>
      <div class="row">
        <div class="col-md-12">   
          <div class="box-body pad table-responsive">
            <table id="GJ_EntriesTable" style="border:1px solid; border-color:#dadada;" class="table table-bordered text-center">
              <thead>
               <tr style="background-color:#ECF9FF;">
	        <th style="padding:3px; width:3%;">S.#</th>
		<th style="padding:3px; text-align:center; width:27%;">Account Name</th>
		<th style="padding:3px; text-align:center; width:20%;">Head of Account</th>
		<th style="padding:3px; text-align:center; width:20%;">Description</th>
		<th style="padding:3px; text-align:center; width:15%;">Amount</th>
	       </tr>
	      </thead>
	       <?php
	         $Recon = '';
		 $SNo = 1;
		 
		 foreach($BankReceiptEntries as $Record) {
		 if($Record['Credit'] == 0.00)
		 { continue; }
	       ?>
	       <tr>
		<td style="padding:3px; width:2%; text-align:center;"><?php echo $SNo; ?></td>
		<td style="padding:3px; text-align:left;"><?php echo $Record['ChartOfAccountsCode'].'-'.$Record['ChartOfAccountsTitle']; ?></td>
		<td style="padding:3px; text-align:left;">
                <?php echo $Record['CustomerName']; ?>
                <?php echo $Record['VendorName']; ?>
                <?php echo $Record['AccountTitle']; ?>    
                </td>
		<td style="padding:3px; text-align:left;">
                <?php echo $Record['Detail']?>
                </td>
                <td style="padding:3px; text-align:right;">
                <?php echo number_format($Record['Credit'],2); ?>
                </td>
               </tr>
               <?php $SNo++; } ?>
	       <tr>
                <td colspan="4"></td>
                <td style="font-weight:600; text-align:right; color:#3333CC;"><?php echo number_format($BankReceipt->TotalCredit,2); ?></td>
               </tr>
	      
            </table>
	  </div>
        </div>
      </div>
      <div class="box-body">
      <div class="row">
       <div class="col-md-12">
         <div class="form-group">
	     <label for="VoucherNote" class="col-sm-2 control-label"><strong>Voucher Note:</strong></label>
             <div class="input-group">
               <?php echo $BankReceipt->VoucherNote != '' ? $BankReceipt->VoucherNote : '&nbsp;'; ?> 
             </div>
         </div>
       </div>
	<?php if ($BankReceipt->EntryType != '1') { ?>
       <div class="col-md-2">
	 <a href="<?php echo base_url(); ?>BankReceiptVoucher/AddBRV" class="btn btn-block btn-primary">Add Record</a>
       </div>
	<?php } ?>
       <div class="col-md-2">
	<a href="<?php echo base_url(); ?>BankReceiptVoucher/" class="btn btn-block bg-orange">Back to Main</a>
       </div>
      </div>
      <!-- /.row -->
      </div>
      </div>
    </div>
   </div>
   </section>
   </div>
<?php  $this->load->view("includes/footer"); ?> 