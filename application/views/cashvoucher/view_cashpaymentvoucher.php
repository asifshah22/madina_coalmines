<?php
$this->load->view("includes/header");
$this->load->view("includes/sidebar");
?>
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
		<h3 class="box-title text-light-blue">View Cash Payment Voucher</h3>
	    </div>
	
	 <div class="box-body">
	    
	  <div class="row invoice-info">
	    <div class="col-sm-3 form-group">
	      <strong>Voucher #:</strong><br>
		<?php echo $CashPayment->ReferencePrefix.''.$CashPayment->Reference; ?>
            </div>
	    <div class="col-sm-3 form-group">
	      <strong>Voucher Date:</strong><br>
		<div class="input-group date">
		  <?php echo date('M d, Y', strtotime($CashPayment->TransactionDate)); ?>
		</div>
	    </div>
	    <div class="col-sm-3 form-group">
	      <strong>Cash Balance:</strong><br>
		<div class="input-group date">
		  <span id="ShowCashBalance" style="color:blue; text-align:left;">
		  <?php echo number_format($CashOpenningBalance[0]['Balance'],2); ?>
		  </span>
		</div>
	    </div>
	  </div>
	  </div>   
	     
	  <!-- Voucher Detail Entries Block -->
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
	        
		 $SNo = 1;
		 foreach($CashPaymentEntries as $Record) {
		
		if($Record['Debit'] == 0.00)
		{ continue; }
	       ?>
	       <tr>
		<td style="padding:3px; width:2%; text-align:center;"><?php echo $SNo; ?></td>
		<td style="padding:3px; text-align:left;"><?php echo $Record['ChartOfAccountsCode'].'-'.$Record['ChartOfAccountsTitle'] ;?></td>
		<td style="padding:3px; text-align:left;">
                <?php echo $Record['CustomerName']; ?>
                <?php echo $Record['VendorName']; ?>
                <?php echo $Record['AccountTitle']; ?>    
                </td>
		<td style="padding:3px; text-align:left;">
                <?php echo $Record['Detail']?>
                </td>
                <td style="padding:3px; text-align:right;">
                <?php echo number_format($Record['Debit'],2);?>
                </td>
	       </tr>
               <?php  $SNo++; } ?>
	       <tr>                
                <td colspan="4"></td>
                <td style="font-weight:600; text-align:right; color:#3333CC;"><?php echo number_format($CashPayment->TotalDebit,2); ?></td>
               </tr>
            </table>
	    <div style="height:5px;"></div>	
	    </div>		      
	    </div>
	   </div>
	   <div class="box-body">
	    <div class="row">
	     <div class="col-md-12">
	      <div class="form-group">
	       <label for="VoucherNote" class="col-sm-2 control-label"><strong>Voucher Note:</strong></label>
               <div class="input-group">
                <?php echo $CashPayment->VoucherNote != '' ? $CashPayment->VoucherNote : '&nbsp;'; ?> 
               </div>
	      </div>
	     </div>
	     <?php if ($CashPayment->EntryType != '1') { ?>
	    <div class="col-md-2">
	     <a href="<?php echo base_url(); ?>CashPaymentVoucher/AddCPV" class="btn btn-block btn-primary">Add Record</a>
	    </div>
	    <?php } ?>
	    <div class="col-md-2">
	     <a href="<?php echo base_url(); ?>CashPaymentVoucher/" class="btn btn-block bg-orange">Back to Main</a>
	    </div>
	    </div>
	   </div>
	
      </div>
     </div>
     </div>
    </section>
  </div>
<?php $this->load->view("includes/footer"); ?>