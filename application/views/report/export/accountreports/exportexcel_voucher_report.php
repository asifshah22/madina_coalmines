<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title><?php echo 'Voucher Report'
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport"> 

        <!-- jQuery 2.2.3 -->
  <script src="<?php echo base_url(); ?>plugins/jQuery/jquery-2.2.3.min.js"></script>
  <!-- Bootstrap 3.3.6 -->
  <script src="<?php echo base_url(); ?>bootstrap/js/bootstrap.min.js"></script>
  <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="<?php echo base_url(); ?>plugins/select2/select2.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>lib/css/font-awesome/font-awesome.min.css">
</head>
<body class="hold-transition skin-blue sidebar-mini">
    <div class="wrapper">
      <style type="text/css">
        body{
          font-family: 'Calibri';
        }
 @media print {
    .pagebreak { page-break-before: always; } /* page-break-after works, as well */

    .no-print, .no-print *
    {
        display: none !important;
    }
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
    $Voucher = $GeneralJournal['Reference'];
    $VoucherReport = preg_replace('/[^a-zA-Z]/', '', $Voucher);
    $VoucherTite = "";
    if($VoucherReport == 'BPV'){
      $VoucherTite = "Bank Payment Voucher";
    }
    if($VoucherReport == 'BRV'){
      $VoucherTite = "Bank Receipt Voucher";
    }
    if($VoucherReport == 'CPV'){
      $VoucherTite = "Cash Payment Voucher";
    }
    if($VoucherReport == 'CRV'){
      $VoucherTite = "Cash Receipt Voucher";
    }
    if($VoucherReport == 'JV'){
      $VoucherTite = "Journal Voucher";
    }


  ?>

      <div class="box box-info">
        <div class="col-md-12 col-xs-12">
          <div class="col-xs-2 col-sm-2">
              <img src="<?php echo base_url() ?>images/company-logo/<?php echo $GetSettingInformation[0]['CompanyLogo']; ?>" alt="" width="100" class="img-circle">
          </div>
          <div class="col-xs-8 col-sm-8">
            <h2 style="color:black; font-family:Calibri; font-weight:600;margin-left: 1%; margin-top: 30px;" class="box-title text-center"><?php echo $GetSettingInformation[0]['CompanyName']; // $this->session->userdata('CompanyName'); ?></h2>
          </div>
        </div>
    <br><br>
      <h3 style="color:green;text-align: center;"><?php echo $VoucherTite; ?></h3>
      
      <div style="padding-top:-0.1em; font-size:12px; font-weight:600; text-align:center;">Period of <?php echo date('M d, Y', strtotime($this->input->get('StartDate'))).' &nbsp; - &nbsp;  '. date('M d, Y', strtotime($this->input->get('EndDate'))); ?>
      </div>
        <span class="pull-right no-print" style="font-size:13px; font-family: Arial, Helvetica, sans-serif; margin-top: -100px"><a href="#" class="" id="SendMail" data-toggle="modal" data-target="#myModal" style="color:green">Email</a> &nbsp; &nbsp;<a href="#" style="color:green" onclick="window.print();">Print</a> &nbsp; &nbsp;
      <hr style="color: #003eff; border-width: 1px; border-style: inset; display: block;">
      <!--  <button class="pull-right" type="button" id="SendMail" data-toggle="modal" data-target="#myModal">Send as Email</button> -->
           </div>
    <div class="col-md-12">
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
	     <?php echo $GeneralJournal['Reference']; ?>
          </address>
        </div>
	     <div class="col-sm-3 invoice-col">
          <address style="font-size:13px;">
            <strong>Transaction Date:</strong><br>
            <?php echo date('M d, Y', strtotime($GeneralJournal['TransactionDate'])); ?>
          </address>
        </div>

        <?php if($GeneralJournal['Reference'] == 'BPV' || $GeneralJournal['Reference'] == 'BRV'): ?>
        <div class="col-sm-3 invoice-col">
          <address style="font-size:13px;">
            <strong>Bank Account:</strong><br>
            <?php echo $GeneralJournal['AccountTitle']; ?>
          </address>
        </div>

<?php 
  if($GeneralJournal['Reference'] != 'BRV'):
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
            <table id="GJ_EntriesTable" style="border:1px solid; width: 100%" class="table table-bordered text-center">
              <thead>
               <tr style="background-color:#ECF9FF; font-size:13px; border-top:1px solid #e0e0e0;">
	        <th style="padding:3px; width:3%;">S.#</th>
		<th style="padding:3px; text-align:center; width:30%;">Account Name</th>
		<!-- <th style="padding:3px; text-align:center; width:20%;">Head of Account</th> -->
		<th style="padding:3px; text-align:center; width:20%;">Description</th>
		<th style="padding:3px; text-align:center; width:10%;">Debit</th>
    <th style="padding:3px; text-align:center; width:10%;">Credit</th>
	       </tr>
	      </thead>
	       <?php
	        $SNo = 1;
		for($i=0; $i<count($GetGeneralJournal['GeneralJournalEntries']); $i++) {
      if($GetGeneralJournal['GeneralJournalEntries'][$i]['GeneralJournalId'] != $GeneralJournal['GeneralJournalId']){
        continue;
      }

      if($GeneralJournal['Reference'] == 'BRV' && $GetGeneralJournal['GeneralJournalEntries'][$i]['Credit'] == '0.00')
      {
        continue;
      }

      if($GeneralJournal['Reference'] == 'BPV' && $GetGeneralJournal['GeneralJournalEntries'][$i]['Debit'] == '0.00')
      {
        continue;
      }

	       ?>
	       <tr style="font-size:13px;">
		<td style="padding:3px; width:2%; text-align:center;"><?php echo $SNo; ?></td>
		<td style="padding:3px; text-align:left;"><?php echo $GetGeneralJournal['GeneralJournalEntries'][$i]['ChartOfAccountCode'].'-'.$GetGeneralJournal['GeneralJournalEntries'][$i]['ChartOfAccountTitle'].' -- '.$GetGeneralJournal['GeneralJournalEntries'][$i]['ControlName'] ;?>
		</td>
<!-- 		<td style="padding:3px; text-align:left;">
                <?php // echo $GetGeneralJournal['GeneralJournalEntries'][$i]['CustomerName']; ?>
                <?php // echo $GetGeneralJournal['GeneralJournalEntries'][$i]['VendorName']; ?>
                <?php // echo $GetGeneralJournal['GeneralJournalEntries'][$i]['AccountTitle']; ?>    
                </td> -->
		<td style="padding:3px; text-align:left;">
                <?php echo $GetGeneralJournal['GeneralJournalEntries'][$i]['Detail']?>
                </td>
                <?php 
//                if($GeneralJournal['Reference'] == 'BPV' || $GeneralJournal['Reference'] == 'CPV'):
                ?>
                <td style="padding:5px; text-align:right;">
                <?php echo number_format($GetGeneralJournal['GeneralJournalEntries'][$i]['Debit'],2);?>
                </td>
                <?php // endif;
//                if($GeneralJournal['Reference'] == 'BRV' || $GeneralJournal['Reference'] == 'CRV'):
                ?>
                <td style="padding:5px; text-align:right;">
                <?php echo number_format($GetGeneralJournal['GeneralJournalEntries'][$i]['Credit'],2);?>
                </td> 
                <?php // endif; ?>
	       </tr>
               <?php $SNo++; } ?>
	       <tr style="font-weight:600; font-size:13px;">
                <td colspan="3" style="text-align:right;">Total Amount:</td>
                <?php 
//                if($GeneralJournal['Reference'] == 'BPV' || $GeneralJournal['Reference'] == 'CPV'){
                ?>
                <td style="padding:5px; text-align:right; color:#3333CC;"><?php echo number_format($GetGeneralJournal['GeneralJournal'][$count]['TotalDebit'],2);?></td>
                <?php // }
//                if($GeneralJournal['Reference'] == 'BRV' || $GeneralJournal['Reference'] == 'CRV'){
                ?>
                 <td style="padding:5px; text-align:right; color:#3333CC;"><?php echo number_format($GetGeneralJournal['GeneralJournal'][$count]['TotalCredit'],2);?></td>
               <?php // }
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
  $count++;
  }
  ?>

<script type="text/javascript">
  $(function(){
//    window.print();
  })
</script>