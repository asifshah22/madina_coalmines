<link rel="stylesheet" href="<?php echo base_url(); ?>bootstrap/css/bootstrap.min.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>lib/css/font-awesome/font-awesome.min.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>lib/css/pos.min.css">
      <!-- jQuery 2.2.3 -->
<script src="<?php echo base_url(); ?>plugins/jQuery/jquery-2.2.3.min.js"></script>
<style type="text/css">
 @media print {
    .pagebreak { page-break-before: always; } /* page-break-after works, as well */
}
</style>
<?php 
  $count = 0;
  foreach ($GetGeneralJournal['GeneralJournal'] as $GeneralJournal) {
//    if($GeneralJournal == null)
//      continue;
/*    echo "<pre>";
    print_r($GeneralJournal);*/
//    echo count($GeneralJournal);
  ?>
    <div class="col-md-12">
      <div class="box-header">
        <h2 style="color:black; font-family:Georgia; font-weight:600; margin-left: 40%" class="box-title">Sunny Paper Mills</h2>
        <br><br>
         <h3 style="color:green; margin-left: 45%;" class="box-title text-light-blue">Voucher</h3>

         <br><br>
          <?php
            if($this->input->get('StartDate') || $this->input->get('EndDate')):
          ?>
         <div style="padding-top:-0.1em; font-size:12px; font-weight:600; margin-left: 39%">Period of <?php echo date('M d, Y', strtotime($this->input->get('StartDate'))).' &nbsp; - &nbsp;  '. date('M d, Y', strtotime($this->input->get('EndDate'))); ?>
        </div>
      <?php endif; ?>
      </div>
      <!-- form elements --> 
      <div class="box box-info container">
	<div class="box-header with-border">
	  <!-- <h3 class="box-title text-light-blue">Voucher</h3> -->
	</div>

      <div class="box-body">
       <div class="row invoice-info">
        <div class="col-sm-3 invoice-col">
          <address style="font-size:13px;">
            <strong>Voucher #:</strong><br>
	     <?php echo $GeneralJournal['ReferencePrefix'] . "" . $GeneralJournal['Reference']; ?>
          </address>
        </div>
	     <div class="col-sm-3 invoice-col">
          <address style="font-size:13px;">
            <strong>Transaction Date:</strong><br>
            <?php echo date('M d, Y', strtotime($GeneralJournal['TransactionDate'])); ?>
          </address>
        </div>

        <?php if($GeneralJournal['ReferencePrefix'] == 'BPV' || $GeneralJournal['ReferencePrefix'] == 'BRV'): ?>
        <div class="col-sm-3 invoice-col">
          <address style="font-size:13px;">
            <strong>Bank Account:</strong><br>
            <?php echo $GeneralJournal['AccountTitle']; ?>
          </address>
        </div>

<?php 
  if($GeneralJournal['ReferencePrefix'] != 'BRV'):
?>

      <div class="col-sm-3 invoice-col">
        <address style="font-size:13px;">
      <strong>Bank Cheque:</strong><br>
      <?php echo $GeneralJournal['ChequeNumber'] != 0 ? $GeneralJournal['ChequeNumber'] : 'Without Cheque'; ?>
        </address>
      </div>

      <?php
       endif; 
       endif; 
       ?>

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
		<th style="padding:3px; text-align:center; width:10%;">Amount</th>
	       </tr>
	      </thead>
	       <?php
	        $SNo = 1;
		for($i=0; $i<count($GetGeneralJournal['GeneralJournalEntries']); $i++) {
      if($GetGeneralJournal['GeneralJournalEntries'][$i]['GeneralJournalId'] != $GeneralJournal['GeneralJournalId']){
        continue;
      }

      if($GeneralJournal['ReferencePrefix'] == 'BRV' && $GetGeneralJournal['GeneralJournalEntries'][$i]['Credit'] == '0.00')
      {
        continue;
      }

      if($GeneralJournal['ReferencePrefix'] == 'BPV' && $GetGeneralJournal['GeneralJournalEntries'][$i]['Debit'] == '0.00')
      {
        continue;
      }

	       ?>
	       <tr style="font-size:13px;">
		<td style="padding:3px; width:2%; text-align:center;"><?php echo $SNo; ?></td>
		<td style="padding:3px; text-align:left;"><?php echo $GetGeneralJournal['GeneralJournalEntries'][$i]['ChartOfAccountsCode'].'-'.$GetGeneralJournal['GeneralJournalEntries'][$i]['ChartOfAccountsTitle'].' -- '.$GetGeneralJournal['GeneralJournalEntries'][$i]['ControlName'] ;?>
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
                if($GeneralJournal['ReferencePrefix'] == 'BPV' || $GeneralJournal['ReferencePrefix'] == 'CPV'):
                ?>
                <td style="padding:5px; text-align:right;">
                <?php echo number_format($GetGeneralJournal['GeneralJournalEntries'][$i]['Debit'],2);?>
                </td>
                <?php endif;
                if($GeneralJournal['ReferencePrefix'] == 'BRV' || $GeneralJournal['ReferencePrefix'] == 'CRV'):
                ?>
                <td style="padding:5px; text-align:right;">
                <?php echo number_format($GetGeneralJournal['GeneralJournalEntries'][$i]['Credit'],2);?>
                </td> 
                <?php endif; ?>
	       </tr>
               <?php $SNo++; } ?>
	       <tr style="font-weight:600; font-size:13px;">
                <td colspan="4" style="text-align:right;">Total Amount:</td>
                <?php 
                if($GeneralJournal['ReferencePrefix'] == 'BPV' || $GeneralJournal['ReferencePrefix'] == 'CPV'){
                ?>
                <td style="padding:5px; text-align:right; color:#3333CC;"><?php echo number_format($GetGeneralJournal['GeneralJournal'][0]['TotalDebit'],2);?></td>
                <?php }
                if($GeneralJournal['ReferencePrefix'] == 'BRV' || $GeneralJournal['ReferencePrefix'] == 'CRV'){
                ?>
                 <td style="padding:5px; text-align:right; color:#3333CC;"><?php echo number_format($GetGeneralJournal['GeneralJournal'][0]['TotalCredit'],2);?></td>
               <?php }
               ?>
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
  if($GeneralJournal['ReferencePrefix'] != 'JV'):
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
  $count++;
  }
  ?>

<script type="text/javascript">
  $(function(){
//    window.print();
  })
</script>