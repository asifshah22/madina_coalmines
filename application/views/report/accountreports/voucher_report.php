<link rel="stylesheet" href="<?php echo base_url(); ?>bootstrap/css/bootstrap.min.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>lib/css/font-awesome/font-awesome.min.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>lib/css/IMS.min.css">
      <!-- jQuery 2.2.3 -->
<script src="<?php echo base_url(); ?>plugins/jQuery/jquery-2.2.3.min.js"></script>
<style type="text/css">
 @media print {
    .pagebreak { page-break-before: always; } /* page-break-after works, as well */
}
</style>
<?php 
  $TotalDebitAmount = 0;
  $TotalCreditAmount = 0;
  $count = 0;
  foreach ($GetGeneralJournal['GeneralJournal'] as $GeneralJournal) {
  $Reference = preg_split("/(,?\s+)|((?<=[a-z])(?=\d))|((?<=\d)(?=[a-z]))/i", $GeneralJournal['Reference']);
  ?>
    <div class="col-md-12">
      <div class="box-header">
	<div class="row">
        <div class="col-xs-12">
	    <h1 class="page-header" style="font-size: 30px;"><?php echo $GetSettingInformation[0]['CompanyName']; ?></h1>
        </div>
        <div class="col-xs-12">
	 <h3 style="margin-left:42%; margin-top: -10px; color: green;">Voucher Report</h3>
	 <div style="padding-top:-0.1em; font-size:12px; font-weight:800; margin-left: 41%">
	 Period of <?php echo date('M d, Y', strtotime($this->input->get('StartDate'))).'  -  '. date('M d, Y', strtotime($this->input->get('EndDate'))); ?>
        </div>
        </div>
        <!-- /.col -->
      </div>
	  
      </div>
      <!-- form elements --> 
      <div class="box box-info container">
	<div class="box-header with-border">
	</div>

      <div class="box-body">
       <div class="row invoice-info">
	   <div class="col-sm-3 invoice-col">
          <address style="font-size:13px;">
            <strong>Voucher #:</strong><br>
	     <?php echo $GeneralJournal['Reference']; ?>
	   </address>
        </div>
	<div class="col-sm-3 invoice-col">
          <address style="font-size:13px;">
            <strong>Transaction Date:</strong><br>
            <?php echo date('M d, Y', strtotime($GeneralJournal['TransactionDate'])); ?>
          </address>
        </div>
      
        <div class="col-sm-12 invoice-col">
          <address style="font-size:13px;">
	    <strong>Note:</strong><br>
	     <?php echo $GeneralJournal['VoucherNote']; ?>
          </address>
        </div> 
       </div>
      </div>

      <div class="row">
        <div class="col-md-12">   
          <div class="box-body pad table-responsive">
            <table id="GJ_EntriesTable" style="border:0px; solid" class="table table-bordered text-center">
              <thead>
               <tr style="background-color:#ECF9FF; font-size:13px; border-top:1px solid #e0e0e0;">
	        <th style="padding:3px; width:3%;">S.#</th>
		<th style="padding:3px; text-align:center; width:30%;">Account Name</th>
		<th style="padding:3px; text-align:center; width:20%;">Head of Account</th>
		<th style="padding:3px; text-align:center; width:20%;">Description</th>
		<?php if($Reference[0] == 'JV') { ?>
		<th style="padding:3px; text-align:center; width:10%;">Debit</th>
		<th style="padding:3px; text-align:center; width:10%;">Credit</th>
		<?php } else { ?>
		<th style="padding:3px; text-align:center; width:10%;">Amount</th>
		<?php } ?>
	       </tr>
	      </thead>
	       <?php
	      // echo count($GetGeneralJournal['GeneralJournalEntries']);
	     //die;   
	        $SNo = 1;
		for($i=0; $i<count($GetGeneralJournal['GeneralJournalEntries']); $i++) {
		    		    
		if($GetGeneralJournal['GeneralJournalEntries'][$i]['GeneralJournalId'] != $GeneralJournal['GeneralJournalId']){
		  continue;
		}

		if(($Reference[0] == 'BRV' || $Reference[0] == 'CRV' ) && $GetGeneralJournal['GeneralJournalEntries'][$i]['Credit'] == '0.00')
		{
		  continue;
		}

		if(($Reference[0] == 'BPV' || $Reference[0] == 'CPV' ) && $GetGeneralJournal['GeneralJournalEntries'][$i]['Debit'] == '0.00')
		{
		  continue;
		}
	       ?>
	       <tr style="font-size:13px;">
		<td style="padding:3px; width:2%; text-align:center;"><?php echo $SNo; ?></td>
		<td style="padding:3px; text-align:left;"><?php echo $GetGeneralJournal['GeneralJournalEntries'][$i]['ChartOfAccountCode'].'-'.$GetGeneralJournal['GeneralJournalEntries'][$i]['ChartOfAccountTitle'].' -- '.$GetGeneralJournal['GeneralJournalEntries'][$i]['ControlName'] ;?>
		</td>
		<td style="padding:3px; text-align:left;">
                <?php echo $GetGeneralJournal['GeneralJournalEntries'][$i]['CustomerName']; ?>
                <?php echo $GetGeneralJournal['GeneralJournalEntries'][$i]['VendorName']; ?>
                <?php echo $GetGeneralJournal['GeneralJournalEntries'][$i]['AccountTitle']; ?>    
                </td>
		<td style="padding:3px; text-align:left;">
                <?php echo $GetGeneralJournal['GeneralJournalEntries'][$i]['Detail']?>
                </td>
                <?php 
                if($Reference[0] == 'BPV' || $Reference[0] == 'CPV' || $Reference[0] == 'JV') {
                $TotalDebitAmount += $GetGeneralJournal['GeneralJournalEntries'][$i]['Debit'];
		    /*if($GetGeneralJournal['GeneralJournalEntries'][$i]['Debit'] == '0.00'){
                    continue;
                  }*/
                ?>
                <td style="padding:5px; text-align:right;">
                <?php 
		echo number_format($GetGeneralJournal['GeneralJournalEntries'][$i]['Debit'],2);
		?>
                </td>
                <?php }
                if($Reference[0] == 'BRV' || $Reference[0] == 'CRV' || $Reference[0] == 'JV'){
		    $TotalCreditAmount += $GetGeneralJournal['GeneralJournalEntries'][$i]['Credit'];
                  /*if($GetGeneralJournal['GeneralJournalEntries'][$i]['Credit'] == '0.00'){
                    continue;
                  }*/
                ?>
                <td style="padding:5px; text-align:right;">
                <?php echo number_format($GetGeneralJournal['GeneralJournalEntries'][$i]['Credit'],2);?>
                </td> 
                <?php } ?>
	       </tr>
               <?php $SNo++; } ?>
	       <tr style="font-weight:600; font-size:13px;">
                <td colspan="4" style="text-align:right;">Total Amount:</td>
		<?php if($Reference[0] == 'JV') { ?>
		<td style="padding:5px; text-align:right; color:#3333CC;"><?php echo number_format($GeneralJournal['TotalDebit'],2);?></td>
		<td style="padding:5px; text-align:right; color:#3333CC;"><?php echo number_format($GeneralJournal['TotalCredit'],2);?></td>
		<?php } ?>
                <?php 
                if($Reference[0] == 'BPV' || $Reference[0] == 'CPV'){
                ?>
                <td style="padding:5px; text-align:right; color:#3333CC;"><?php echo number_format($TotalDebitAmount,2);?></td>
                <?php }
                if($Reference[0] == 'BRV' || $Reference[0] == 'CRV'){
                ?>
                <td style="padding:5px; text-align:right; color:#3333CC;"><?php echo number_format($TotalCreditAmount,2);?></td>
                <?php } ?>
               </tr>
            </table>
	  </div>
        </div>
      </div>
      </div>
    </div>
    <div style="height:27px;"></div>

  <div class="container">
    <div style="border:0px solid;" class="col-xs-3">
    <div class="row">
        <div style="text-decoration: overline; border:0px solid; margin-top: 30px;" class="col-xs-12">
        <p style="font-size:14px; font-weight:600; ">Prepared By</p>
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->
    </div>

<div style="border:0px solid;" class="col-xs-3">
    <div class="row">
        <div style="text-decoration: overline; border:0px solid; margin-top: 30px;" class="col-xs-12">
        <p style="font-size:14px; font-weight:600; ">Checked by</p>
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->
    </div>

<div style="border:0px solid;" class="col-xs-3">
    <div class="row">
        <div style="text-decoration: overline; border:0px solid; margin-top: 30px;" class="col-xs-12">
        <p style="font-size:14px; font-weight:600; ">Approved By</p>
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->
    </div>

<?php 
  if($GeneralJournal['Reference'] != 'JV'):
?>
<div style="border:0px solid;" class="col-xs-3">
    <div class="row">
        <div style="text-decoration: overline; border:0px solid; margin-top: 30px;" class="col-xs-12">
        <p style="font-size:14px; font-weight:600; ">Received By</p>
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->
    </div>
  <?php endif; ?>
  </div>
    <div style="height: 150px;"></div>
    <div class="pagebreak"> </div>
  <?php
  $TotalDebitAmount = 0;
  $TotalCreditAmount = 0;
  $count++;
  }
  ?>