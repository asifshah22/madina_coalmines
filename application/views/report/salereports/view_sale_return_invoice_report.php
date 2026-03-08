<?php



?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Sales Invoice Detail Report</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.6 -->
  <script src="<?php echo base_url(); ?>plugins/jQuery/jquery-2.2.3.min.js"></script>
  <!-- Bootstrap 3.3.6 -->
  <script src="<?php echo base_url(); ?>bootstrap/js/bootstrap.min.js"></script>
  <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="<?php echo base_url(); ?>plugins/select2/select2.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>lib/css/font-awesome/font-awesome.min.css">
  <link rel="stylesheet" href="<?php echo base_url(); ?>lib/css/AdminLTE.min.css">
</head>
<style>
@media print {
    body{
        margin: 0mm; /* No margins */
    margin-left: 0mm; /* Remove left margin */
    margin-right: 0mm; /* Remove right margin */
   } 
}
@page {
    size: 80mm 287mm; /* Custom size: 80mm width, 260mm height */
    margin: 0px; /* No margins */
          margin: 0mm; /* No margins */
    margin-left: 0mm; /* Remove left margin */
    margin-right: 0mm; /* Remove right margin */
    
}
</style>
<body >
<?php

// print_r($SaleInvoiceReport);

if(empty($SaleInvoiceReport)) die('<div style="text-align:center;">No record found.</div>'); 


$SaleType = '';

if($SaleInvoiceReport->SaleReturnType == 1) {
    $SaleType = 'Cash';
}
if($SaleInvoiceReport->SaleReturnType == 2) {
    $SaleType = 'Credit';
}
if($SaleInvoiceReport->SaleReturnType == 3) {
    $SaleType = 'Online';
}


/*if($SaleInvoiceReportDetails[0]['InvoiceDate'])
$sInvoiceDate = date('M d, Y',strtotime($SaleInvoiceReportDetails[0]['InvoiceDate']));
else
$sInvoiceDate = '_____/_____/_________';*/
?>
 
    
 <div class="wrapper">
 <!-- Main content --> 
 <div style="page-break-after:always"></div> 
 
 <section class="invoice">

 <div class="box-header">
      <span class="pull-right" style="font-size:13px; font-family: Arial, Helvetica, sans-serif;"><a href="#" class="" id="SendMail" data-toggle="modal" data-target="#myModal" style="color:green">Email</a> &nbsp; &nbsp;<a href="#" style="color:green" onclick="window.print();">Print</a> &nbsp; &nbsp;</span>

  </div>

  <div class="col-xs-12 col-sm-12" style="padding-left: 0px; text-align: center;">
    <img src="<?php echo base_url() ?>images/company-logo/<?php echo $GetSettingInformation[0]['CompanyLogo']; ?>" alt=""  class="img-fluid">
    
</div>
<div class="col-xs-12 col-sm-12" style="padding-left: 0px;">
    <div class="pull-right" style="width:auto; text-align: left;">
        <address>
            <div style="">
        <p style="font-size: 35px; font-weight:bold;color:#3c8dbc">Sale Return INVOICE</p>
    </div>
            <p style="font-size:15px;letter-spacing: 1px;font-family:Calibri;margin-bottom:1px;"><b>POS No:</b> <label><?php echo '180491'; ?></label></p>
             <p style="font-size:15px;letter-spacing: 1px;font-family:Calibri;margin-bottom:1px;"><b>Invoice No:</b> <label><?php echo $SaleInvoiceReport->SaleReturnId; ?></label></p>
            <p style="font-size:15px;letter-spacing: 1px;font-family:Calibri;margin-bottom:0px;"><b>Date:</b> <span style="font-size:13px;letter-spacing: 1px;font-family:Calibri;"><?php echo date("M d, Y H:i:s",strtotime($SaleInvoiceReport->SaleReturnDate)); ?></span></p>
        </address>
    </div>
    <div class="pull-left" style="text-align: left;">
        <address>
            <p style="font-size:15px;letter-spacing: 1px;font-family:Calibri;margin-bottom:0px;"><b>Casheir :</b> <span style="font-size:13px;letter-spacing: 1px;font-family:Calibri;"> <?php echo $this->session->userdata('EmployeeName'); ?></span></p>
            <p style="font-size:15px;letter-spacing: 1px;font-family:Calibri;margin-bottom:0px;"><b>Mode Of Payment :</b> <span style="font-size:13px;letter-spacing: 1px;font-family:Calibri;"> <?php  echo $SaleType;
        ?></span></p>
            <p style="font-size:15px;letter-spacing: 1px;font-family:Calibri;margin-bottom:0px;"><b>Customer Name:</b> <span style="font-size:13px;letter-spacing: 1px;font-family:Calibri;"> <?php echo $SaleInvoiceReport->fbr_customer; ?></span></p>
            <p style="font-size:15px;letter-spacing: 1px;font-family:Calibri;margin-bottom:0px;"><b>CNIC:</b> <span style="font-size:13px;letter-spacing: 1px;font-family:Calibri;"> <?php echo $SaleInvoiceReport->fbr_cnic; ?></span></p>
        </address>
    </div>
    
    
</div>


  <div class="row">

        <table border="0" class="table table-striped col-sm-12">
              <thead>
            <tr style="background:#3c8dbc; font-size:12px; color:#FFFFFF;">
            <th style="font-size:12px; font-weight:600; text-align:center; border-bottom:1px solid; border-top:1px solid;">S#</th>
            <th style="font-size:12px; font-weight:600; text-align:left; border-bottom:1px solid; border-top:1px solid;">Discription</th>
            <th style="font-size:12px; font-weight:600; text-align:center; border-bottom:1px solid; border-top:1px solid; ;">Price</th> 
            <th style="font-size:12px; font-weight:600; text-align:center; border-bottom:1px solid; border-top:1px solid; ;">GST Rate</th> 
            <th style="font-size:12px; font-weight:600; text-align:center; border-bottom:1px solid; border-top:1px solid;">Qty</th> 
            <th style="font-size:12px; font-weight:600; text-align:center; border-bottom:1px solid; border-top:1px solid;">GST</th> 
           
            <th style="font-size:12px; font-weight:600; text-align:left; border-bottom:1px solid; border-top:1px solid;">Total</th>
           </tr>
          </thead>
          <tbody>
          <?php //
          $TotalQuantity = 0;
          $TotalAmount = 0;
          $TotalDiscount = 0;
          $TotalNetAmount = 0;
          $TaxPercentage=0;
	  $SNo=1;
	  if(isset($SaleInvoiceReportDetails)) {
        $grossAmount = 0;
        $invoiceDiscount = 0;
        $k = 0;
          foreach($SaleInvoiceReportDetails as $row) {
            //   print_r($row);
            //   die();
            $grossAmount += $row['NetAmount'];
            $invoiceDiscount = $row['DiscountAmount'];
           
          $Particulars = $row['ProductName'];
	  ?>
          <tr>
            <td style="font-size:12px; font-weight:600; text-align:center;"><?php echo $SNo; ?></td>
            <td style="font-size:12px; text-align:left;"><?php echo $Particulars; ?></td>
            <td style="font-size:12px; font-weight:600; text-align:center;"><?php echo $row['Rate'] ?></td>
            <td style="font-size:12px; font-weight:600; text-align:center;"><?php echo $row['DiscountAmount']  ?></td>
            
            <td style="font-size:12px; text-align:center;"><?php echo number_format($row['Quantity'],2); ?></td>
            <td style="font-size:12px; text-align:center;"><?php echo number_format($row['TaxPercentage'],2); ?></td>
         
          
             <td style="font-size:12px; text-align:left;"><?php echo number_format(($row['NetAmount']),2); ?></td>
           </tr>
           <?php $SNo++;
           $TotalQuantity += $row['Quantity'];
           $TotalAmount += $row['Amount'];
           $TotalDiscount += ($row['TaxAmount']);
           $TotalNetAmount += $row['NetAmount'];
           $TaxPercentage += $row['TaxPercentage'];
           
           
           $convertArray   = ($ReceivedCashAmount != null) ? (array) $ReceivedCashAmount['GeneralJournalEntries'] : null;
           $cashRecieved   =  ($convertArray != null) ? $convertArray[0]['Credit'] : 0;
           $ar             = ($SaleInvoices) ? ($CashVoucherAmount - ($grossAmount - $invoiceDiscount)) : 0;
           
           $currentBalance = ($ar + ($grossAmount - $invoiceDiscount));
         
           } 
           ?>
    
      
          
          </tbody>
        </table>
         <table border="0" class="table " style="width: 80%;">
              <thead>
        </thead>
          <tbody>
              <tr>
		    <td colspan="5">
		    </td>
                </tr>
              	<tr>
          <td colspan="6" style="width: 90%; text-align:right; font-weight:600; border: 0px solid;">Total Amount:</td>
          <td><div id="total_tax" style='font-weight:600; text-align:left; color:#008000;'><?php echo number_format($TotalAmount,2); ?></div></td>
        </tr>
        	<tr>
        <td colspan="6" style="width: 90%; text-align:right; font-weight:600; border: 0px solid;">Sales Tax :</td>
          <td><div id="total_tax" style='font-weight:600; text-align:left; color:#008000;'><?php echo number_format($TaxPercentage,2); ?></div></td>
        </tr>
        	<tr>
        <td colspan="6" style="width: 90%; text-align:right; font-weight:600; border: 0px solid;">Discount:</td>
          <td><div id="total_tax" style='font-weight:600; text-align:left; color:#008000;'><?php echo number_format($TotalDiscount) ?></div></td>
        </tr>
        	<tr>
        <td colspan="6" style="width: 90%; text-align:right; font-weight:600; border: 0px solid;">POS Service Fee:</td>
          <td><div id="total_tax" style='font-weight:600; text-align:left; color:#008000;'>1.00</div></td>
        </tr>
        	<tr>
        <td colspan="6" style="width: 90%; text-align:right; font-weight:600; border: 0px solid;">Payables:</td>
          <td><div id="total_tax" style='font-weight:600; text-align:left; color:#008000;'><?php echo number_format(($TotalAmount+$TaxPercentage+1-$TotalDiscount),2); ?></div></td>
        </tr>
      <?php  if($SaleInvoiceReport->SaleReturnType != 1) {
   ?>

        	<!--<tr>
        <td colspan="6" style="width: 90%; text-align:right; font-weight:600; border: 0px solid;">Received:</td>
          <td><div id="total_tax" style='font-weight:600; text-align:left; color:#008000;'><?php if(!empty($CashDetail)){ echo number_format($CashDetail[0]['Debit'],2,'.',''); } ?></div></td>
        </tr>-->
        <?php } ?>
         
           </tr>
          </tbody>
        </table>
        <?php } ?>
      </div>
      
      <div class="col-xs-12 col-sm-12" style="padding-left: 10px; text-align: center;font-size:18px;font-weight:20px;width:90%">
   FBR Invoice# <?php echo $SaleInvoiceReport->FbrNo; ?>
   <div class="row" >
    <div id="qrcode" class="col-xs-6 col-sm-6" ></div> 
     <img src="<?php echo base_url() ?>images/fbri.png"class="col-xs-6 col-sm-6" alt="Image" width="80" height="80">
     
    
       
   </div><p></p>
     <p style="font-size:11px">Verify this invoice through FBR TaxAssan Mobile App or SMS at 9966 and win exciting prizes in draw</p>
   <p style="font-size:11px;text-align: left">Software By: AL SYED Software Solutions</p>
</div>

     <!-- /.col -->
    <!--</div>-->

    <!-- /.row -->
    <!-- Table row -->
<?php if($SaleInvoiceReport->SaleReturnType != 1 && $isLedger == 1){ ?>
    <div class="row">
      <div class="col-xs-12 table-responsive">

<?php

  $SNo=1;
  $CompanyName = '';
  $dTotal_Debit = 0;
  $dTotal_Credit = 0;
  $dGrandTotal_Debit = 0;
  $dGrandTotal_Credit = 0;
  $GrandBalance = 0;

  $dDebit = 0; 
  $dCredit = 0;
  $dTransBalance = 0;
  $dBalance = 0;
  $dClosingBalance = 0;

  if(isset($LedgerReport)) {
  foreach($LedgerReport as $LedgerReportRecord) {

    $ChartOfAccountId = $LedgerReportRecord['ChartOfAccountId'];
    $ChartOfAccountTitle = $LedgerReportRecord['ChartOfAccountTitle'];
    $DebitIncrease = $LedgerReportRecord['DebitIncrease'];
    $CreditIncrease = $LedgerReportRecord['CreditIncrease'];

    if(isset($OpenningBalance))
    {
      foreach($OpenningBalance as $OpenningBalanceRecord)
      {
          if($OpenningBalanceRecord['ChartOfAccountId'] === $ChartOfAccountId) 
          {
            $dBalance = $OpenningBalanceRecord['Balance']; 
          }
      }
  }
	    ?>
        <table border="0" class="table table-striped">
          <thead>
            <tr style="background-color: #3c8dbc; color: #fff; height: 30px;border-bottom: 1px solid;">
              <th style="border-bottom:1px solid; width:10%; font-family:Calibri; font-weight:bold; font-size:12px; text-align: center;">Date</th>
              <th style="border-bottom:1px solid; width:35%; font-family:Calibri; font-weight:bold; font-size:12px; text-align: center;">Detail</th>
              <th style="border-bottom:1px solid; width:5%; font-family:Calibri; font-weight:bold; font-size:12px; text-align: center;">Ref No.</th>
              <th style="border-bottom:1px solid; width:10%; font-family:Calibri; font-weight:bold; font-size:12px; text-align: center;">Debit</th>
              <th style="border-bottom:1px solid; width:10%; font-family:Calibri; font-weight:bold; font-size:12px; text-align: center;">Credit</th>
              <th style="border-bottom:1px solid; width:10%; font-family:Calibri; font-weight:bold; font-size:12px; text-align: center;">Balance</th>
            </tr>
          </thead>
          <tbody>
      <?php
        sort($SubLedgerReport);
        foreach($SubLedgerReport as $SubLedgerReportRecord) {
      
        if($SubLedgerReportRecord['ChartOfAccountId'] == $LedgerReportRecord['ChartOfAccountId']) 
        {
          $ChartOfAccountId = $SubLedgerReportRecord['ChartOfAccountId'];
          $GeneralJournalId = $SubLedgerReportRecord['GeneralJournalId'];
          $SaleId = $SubLedgerReportRecord['SaleId'];
          $Reference = $SubLedgerReportRecord['Reference'];
          $dTransactionDate = $SubLedgerReportRecord['TransactionDate'];
          $sTransactionDate = date("M j, Y", strtotime($dTransactionDate));
          $Detail = $SubLedgerReportRecord['Detail'];
          $dDebit = $SubLedgerReportRecord['Debit'];
          $dCredit = $SubLedgerReportRecord['Credit'];
          $ChartOfAccountTitle = $SubLedgerReportRecord['ChartOfAccountTitle'];
	        $voucherType = $SubLedgerReportRecord['VoucherType'];
	
	      
          if($DebitIncrease == 1)
          {
            $dTransBalance = $dDebit - $dCredit;
          }
                
          if($CreditIncrease == 1)
          {
            $dTransBalance = $dCredit - $dDebit;
          }
          
          if($DebitIncrease == 1)
          {
            $dBalance += $dTransBalance; 
          }
        
          if($CreditIncrease == 1)
          {
            $dBalance += $dTransBalance;
          }	 
                
          $dTotal_Debit += $dDebit;
          $dTotal_Credit += $dCredit;

          $sDebit = number_format($dDebit, 0);
          $sCredit = number_format($dCredit, 0);
          
          if ($dDebit == 0) $sDebit = '';
          if ($dCredit == 0) $sCredit = '';
                
          $dClosingBalance = 0;
	      ?>
            <tr style="font-size:12px; height: 30px;">
              <td style="text-align: left; padding-left:10px; font-weight: 600"><?php echo $sTransactionDate; ?></td>
              <td style="text-align: left; padding-left:10px;"><?php 
              if ($SaleId) { 
                echo 'Sale Invoice no. '.'<a style="color:#205081;font-weight: bold;" target="_blank" href="'.base_url().'SaleReports/ViewSaleInvoiceReport?InvoiceNo='.$SaleId.'">'.$SaleId.'</a>';
              } 
              if ($SubLedgerReportRecord['SaleReturnId']) { 
                echo 'Sale Return Invoice no. '.'<a style="color:#FF0000;font-weight: bold;" target="_blank" href="'.base_url().'SalesReturn/ViewSalesReturn/'.$SubLedgerReportRecord['SaleReturnId'].'">'.$SubLedgerReportRecord['SaleReturnId'].'</a>';
              } 
              if($SubLedgerReportRecord['SaleReturnId'] == Null && ($SaleId == Null || $SaleId == 0)){
                echo 'Cash Recieved Voucher no. '.'<a style="color:green;font-weight: bold;" target="_blank" href="'.base_url().'AccountReports/GenerateVoucherReport?GeneralJournalId='.$SubLedgerReportRecord['GeneralJournalId'].'&ReferencePrefix=CRV">'.$SubLedgerReportRecord['GeneralJournalId'].'</a>';
              }
              ?></td> 
              <td style=" text-align: center; font-weight: 600"><?php echo $Reference; // if ($SaleId != 0) { echo 'SI '.$SaleId; };  /* if($SaleId == 0 || $SaleId == '') { echo $Reference; } else {  echo 'SI '.$SaleId; } */  //'<a href="javascript:void(0)" onclick="window.open(\''.base_url().'GeneralJournal/ViewVoucher/'.$GeneralJournalId.'\',\'popUpWindow\',\'height=450,width=800,left=400,top=100,resizable=no,scrollbars=0,toolbar=no,menubar=no,location=no,directories=no, status=yes\');">'.$Reference.'</a>'; ?></td>
              <td style="text-align: center;"><?php echo $sDebit; ?></td>
              <td style="text-align: center;"><?php echo $sCredit; ?></td>
              <td style="text-align: center;"><?php echo number_format($dBalance,0); ?></td>                
            </tr>
            <?php
              $dGrandTotal_Debit += $dDebit;
              $dGrandTotal_Credit += $dCredit;
              $GrandBalance = $dGrandTotal_Debit - $dGrandTotal_Credit;
              } }
            ?>
            <!-- <tr style="font-size:12px; height: 30px;">
                <td colspan="3" style=" font-weight:700; text-align: right;">Total:</td>
                <td style="font-weight: 700; text-align: center;"><?php //echo number_format($dTotal_Debit,0); ?></td>
                <td style="font-weight: 700; text-align: center;"><?php //echo number_format($dTotal_Credit,0); ?></td>
                <td style="font-weight: 700; text-align: center;"><?php //echo number_format($dBalance,0); ?></td>
              </tr> -->
              <?php
               $sDebit = 0;
               $sCredit = 0;
               $dBalance = 0;
               $dTotal_Debit = 0;
               $dTotal_Credit = 0;
               $dBalance = 0;
              ?> 

            <?php } // for loop ends 
            } // main codition end
            ?> 
          
          </tbody>
        </table>
      </div>
    </div>
<?php } ?>
    <div class="box-header">
         
       
      <span class="pull-right" style="font-size:13px; font-family: Arial, Helvetica, sans-serif;font-weight:bold;margin-top: 10px;">
           <?php 
           if(isset($_GET['print2'])){
            
            ?>
           
           <img src="<?php echo base_url() ?>images/signature/<?php echo  $Settings->signature ?>" class="" alt="Image" width="50" height="50">
           <br>
           <?php } ?>
          </span>

    </div>
    <!-- /.row -->
    <div style="height:52px;"></div>
  
    

 </section>
 </div>
 
 <?php // if($sDCReport == "true") { ?>
 <!-- Page Break code -->
 <!--<div style="page-break-after:always"></div>-->
  
 <!--FbrNo-->
</body>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
    <script>
        var qrcode = new QRCode(document.getElementById("qrcode"), {
            text: "<?php echo $SaleInvoiceReport->FbrNo; ?>",
            width: 100,
            height: 100
        });
</script>
</html>