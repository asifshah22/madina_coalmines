<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Ledger Report</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <script src="<?php echo base_url(); ?>plugins/jQuery/jquery-2.2.3.min.js"></script>
  <!-- Bootstrap 3.3.6 -->
  <script src="<?php echo base_url(); ?>bootstrap/js/bootstrap.min.js"></script>
  <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="<?php echo base_url(); ?>plugins/select2/select2.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>lib/css/font-awesome/font-awesome.min.css">
  <style>
* {
  box-sizing: border-box;
}

.row {
  margin-left:-5px;
  margin-right:-5px;
}
  
.column {
  float: left;
  width: 50%;
  padding: 5px;
}

/* Clearfix (clear floats) */
.row::after {
  content: "";
  clear: both;
  display: table;
}

table {
  border-collapse: collapse;
  border-spacing: 0;
  width: 100%;
  border: 1px solid #ddd;
}

th, td {
  text-align: left;
  padding: 6px;
}

tr:nth-child(even) {
  background-color: #f2f2f2;
}
</style>
</head>
<body class="hold-transition skin-blue sidebar-mini">
	<div class="wrapper">
  <div class="box box-info">
        <!-- <div class="col-md-12 col-xs-12" style="background: #2AAA8A;border-bottom: 1px solid;margin-bottom: 10px;">
          <div class="col-xs-2 col-sm-2">
              
          </div>
          <div class="col-xs-8 col-sm-8">
            <h2 style="color:black; font-family:Calibri; font-weight:600;margin-left: 1%; margin-top: 30px;" class="box-title text-center"><?php //echo $GetSettingInformation[0]['CompanyName']; // $this->session->userdata('CompanyName'); ?></h2>
          </div>
        </div>
    <br><br> -->
      <h3 style="color:green;text-align: center;color:#A52A2A;font-size: 20px;" id="functionName">
        Daily Activity Report
        </h3>      
      <div style="padding-top:-0.1em; font-size:12px; font-weight:600; text-align:center;">Period of <?php echo date('M d, Y', strtotime($this->input->get('StartDate'))).' &nbsp; - &nbsp;  '. date('M d, Y', strtotime($this->input->get('EndDate'))); ?>
      </div>
        <span class="pull-right no-print" style="font-size:13px; font-family: Arial, Helvetica, sans-serif; margin-top: -100px"><a href="#" class="" id="SendMail" data-toggle="modal" data-target="#myModal" style="color:green"></a> &nbsp; &nbsp;<a href="#" style="color:green" onclick="window.print();"></a> &nbsp; &nbsp;
        <span class="dropdown pull-left">
          <a class="dropdown-toggle" data-toggle="dropdown" href="#" style="color:green"></a> &nbsp;
        <ul class="dropdown-menu">
          <li><a href="<?php //echo base_url() ?>Export/ExportExcelLedgerReport?StartDate=<?php //echo $this->input->get('StartDate') ?>&EndDate=<?php echo $this->input->get('EndDate'); ?>&BId=<?php echo $this->input->get('BId'); ?>&BAId=<?php echo $this->input->get('BAId'); ?>&CId=<?php echo $this->input->get('CId'); ?>&CCId=<?php echo $this->input->get('CCId'); ?>&COAId=<?php echo $this->input->get('COAId'); ?>&CustomerId=<?php echo $this->input->get('CustomerId'); ?>&VendorId=<?php echo $this->input->get('VendorId'); ?>"></a></li>
<!--          <li><a href="<?php // echo base_url() ?>Export/ExportExcelLedgerReport?StartDate=<?php // echo $this->input->get('StartDate') ?>&EndDate=<?php // echo $this->input->get('EndDate'); ?>&BId=<?php // echo $this->input->get('BId'); ?>&BAId=<?php // echo $this->input->get('BAId'); ?>&CId=<?php // echo $this->input->get('CId'); ?>&CCId=<?php // echo $this->input->get('CCId'); ?>&COAId=<?php // echo $this->input->get('COAId'); ?>&CustomerId=<?php // echo $this->input->get('CustomerId'); ?>&VendorId=<?php // echo $this->input->get('VendorId'); ?>">Word</a></li> -->
      </ul>
          </span> &nbsp; </span>
      <hr style="color: #003eff; border-width: 1px; border-style: inset; display: block;">
      <!--  <button class="pull-right" type="button" id="SendMail" data-toggle="modal" data-target="#myModal">Send as Email</button> -->
  </div>

  <?php if($ReportType == "cashbook" || $ReportType == "0"){ ?>
<h3 style="text-align: center;
    color: black;
    font-size: 20px;
    font-weight: bold;" id="functionName">
  Cashbook
</h3> 
<!-- bank received voucher and bank payment voucher start -->

<div class="row">
  <div class="column">
    <!-- cash receipt start -->
        <table border="1" cellspacing="0" cellpadding="3">
          <thead>
            <tr>
              <th colspan="9" style="text-align: center;background-color:#000000;color:white;font-weight: bold;">
                Cash Receipt
              </th>
            </tr>
            <tr style="border-bottom:1px solid;">
              <th style="border-bottom:1px solid; width:5%; font-family:Calibri; font-weight:bold; font-size:12px; text-align:center;background-color:#2AAA8A;color:black;">Sr.</th>
              <th style="border-bottom:1px solid; width:10%; font-family:Calibri; font-weight:bold; font-size:12px; text-align:center;background-color:#2AAA8A;color:black;">Date</th>
              <th style="border-bottom:1px solid; width:70%; font-family:Calibri; font-weight:bold; font-size:12px; text-align:center;background-color:#2AAA8A;color:black;">Description</th>
              <th style="border-bottom:1px solid; width:10%; font-family:Calibri; font-weight:bold; font-size:12px; text-align:center;background-color:#2AAA8A;color:black;">Amount</th>
            </tr>
          </thead>
          <tbody>
          <?php
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

            //if(isset($LedgerReport)) {
              foreach($CashbookLedgerReport as $LedgerReportRecord) {
              
              $ChartOfAccountId = $LedgerReportRecord['ChartOfAccountId'];
              $ChartOfAccountTitle = $LedgerReportRecord['ChartOfAccountTitle'];
              $DebitIncrease = $LedgerReportRecord['DebitIncrease'];
              $CreditIncrease = $LedgerReportRecord['CreditIncrease'];

              if(isset($CashbookOpenningBalance))
              {
                foreach($CashbookOpenningBalance as $OpenningBalanceRecord)
                {
                    if($OpenningBalanceRecord['ChartOfAccountId'] === $ChartOfAccountId) 
                    {
                      $dBalance = $OpenningBalanceRecord['Balance']; 
                    }
                }
              }
        ?>
          <tr style="font-size:12px;border-bottom:1px solid;">
            <td style="text-align: center; padding-left:10px;border-bottom:1px solid;"><?php echo "" ?></td>
            <td style="text-align: center; padding-left:10px;border-bottom:1px solid;"><?php echo "" ?></td>
            <td style="text-align: left; padding-left:10px;border-bottom:1px solid;font-weight:bold;">Opening Balance</td>
            <td style="text-align:center; padding-right:5px;font-weight:bold;border-bottom:1px solid;"><?php echo number_format($dBalance,0); ?></td>             
          </tr>
          <?php
        $SNo=0;
        foreach($CashbookSubLedgerReport as $SubLedgerReportRecord) { 
          if($SubLedgerReportRecord['ChartOfAccountId'] == $LedgerReportRecord['ChartOfAccountId']) 
          {
            $ChartOfAccountId = $SubLedgerReportRecord['ChartOfAccountId'];
            $GeneralJournalId = $SubLedgerReportRecord['GeneralJournalId'];
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
          if($sDebit == 0){
            continue;
          }
          $SNo++;
        ?>
          <tr style="font-size:12px;border-bottom:1px solid;">
            <td style="text-align: center; padding-left:10px;border-bottom:1px solid;"><?php echo $SNo; ?></td>
            <td style="text-align: center; padding-left:10px;border-bottom:1px solid;"><?php echo date("M j, Y", strtotime($dTransactionDate)); ?> </td>
            <td style="text-align: left; padding-left:10px;border-bottom:1px solid;<?php if(trim($Detail) == "Closing Balance"){echo "font-weight:bold;"; }?>"><?php echo $Detail; ?></td>
            <td style="text-align:center; padding-right:5px;border-bottom:1px solid;<?php if(trim($Detail) == "Closing Balance"){echo "font-weight:bold;"; }?>"><?php echo $sDebit; ?></td>             
          </tr>
      <?php
      $dGrandTotal_Debit += $dDebit;
      $dGrandTotal_Credit += $dCredit;
      $GrandBalance = $dGrandTotal_Debit - $dGrandTotal_Credit;
        } 
      }
      ?>
      <?php
      $sDebit = 0;
      $sCredit = 0;
      $dBalance = 0;
      //$dTotal_Debit = 0;
      $dTotal_Credit = 0;
      $dBalance = 0;
      ?>
    <?php } ?>
          <tr style="font-size:12px;border-bottom:1px solid;">
            <td colspan="3" style="text-align: right; padding-right:10px;font-weight:bold;border-bottom:1px solid;">Total</td>
            <td style="text-align:center; padding-right:5px; font-weight:bold;border-bottom:1px solid;"><?php echo number_format($dTotal_Debit,0); ?></td>
          </tr>
          </tbody>
        </table>  
      </div>
      
      <!-- cash receipt end -->
      <!-- cash payment start -->
  <div class="column">
        <table border="1" cellspacing="0" cellpadding="3">
          <thead>
            <tr>
              <th colspan="9" style="text-align: center;background-color:#000000;color:white;font-weight: bold;border-bottom:1px solid;">
                Cash Payment
              </th>
            </tr>
            <tr>
              <th style="border-bottom:1px solid; width:5%; font-family:Tahoma, Arial; font-weight:bold; font-size:12px; text-align:center;background-color:#2AAA8A;color:black;">Sr.</th>
              <th style="border-bottom:1px solid; width:10%; font-family:Tahoma, Arial; font-weight:bold; font-size:12px; text-align:center;background-color:#2AAA8A;color:black;">Date</th>
              <th style="border-bottom:1px solid; width:70%; font-family:Tahoma, Arial; font-weight:bold; font-size:12px; text-align:center;background-color:#2AAA8A;color:black;">Description</th>
              <th style="border-bottom:1px solid; width:10%; font-family:Tahoma, Arial; font-weight:bold; font-size:12px; text-align:center;background-color:#2AAA8A;color:black;">Amount</th>
            </tr>
          </thead>
          <tbody>
          <?php
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

            //if(isset($LedgerReport)) {
              foreach($CashbookLedgerReport as $LedgerReportRecord) {
              
              $ChartOfAccountId = $LedgerReportRecord['ChartOfAccountId'];
              $ChartOfAccountTitle = $LedgerReportRecord['ChartOfAccountTitle'];
              $DebitIncrease = $LedgerReportRecord['DebitIncrease'];
              $CreditIncrease = $LedgerReportRecord['CreditIncrease'];

              if(isset($CashbookOpenningBalance))
              {
                foreach($CashbookOpenningBalance as $OpenningBalanceRecord)
                {
                    if($OpenningBalanceRecord['ChartOfAccountId'] === $ChartOfAccountId) 
                    {
                      $dBalance = $OpenningBalanceRecord['Balance']; 
                    }
                }
              }
        
        $SNo=0;
        foreach($CashbookSubLedgerReport as $SubLedgerReportRecord) { 
          if($SubLedgerReportRecord['ChartOfAccountId'] == $LedgerReportRecord['ChartOfAccountId']) 
          {
            $ChartOfAccountId = $SubLedgerReportRecord['ChartOfAccountId'];
            $GeneralJournalId = $SubLedgerReportRecord['GeneralJournalId'];
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
          if($sCredit == 0){
            continue;
          }
          $SNo++;
        ?>
          <tr style="font-size:12px;border-bottom:1px solid;">
            <td style="text-align: center; padding-left:10px;border-bottom:1px solid;"><?php echo $SNo; ?></td>
            <td style="text-align: center; padding-left:10px;border-bottom:1px solid;"><?php echo date("M j, Y", strtotime($dTransactionDate)); ?> </td>
            <td style="text-align: left; padding-left:10px;border-bottom:1px solid;"><?php echo $Detail; ?></td>
            <td style="text-align:center; padding-right:5px;border-bottom:1px solid;"><?php echo $sCredit; ?></td>             
          </tr>
      <?php
      $dGrandTotal_Debit += $dDebit;
      $dGrandTotal_Credit += $dCredit;
      $GrandBalance = $dGrandTotal_Debit - $dGrandTotal_Credit;
        } 
      }
      ?>
      <?php
      $sDebit = 0;
      $sCredit = 0;
      //$dBalance = 0;
      $dTotal_Debit = 0;
      //$dTotal_Credit = 0;
      //$dBalance = 0;
      ?>
    <?php } ?>
          <tr style="font-size:12px;border-bottom:1px solid;">
            <td colspan="3" style="text-align: right; padding-right:10px;font-weight:bold;border-bottom:1px solid;">Total</td>
            <td style="text-align:center; padding-right:5px;font-weight:bold;border-bottom:1px solid;"><?php echo number_format($dTotal_Credit,0); ?></td>
          </tr>
          <tr style="font-size:12px;">
            <td colspan="3" style="text-align: right; padding-right:10px;font-weight:bold;border-bottom:1px solid;">Closing Balance</td>
            <td style="text-align:center; padding-right:5px;font-weight:bold;border-bottom:1px solid;"><?php echo number_format($dBalance,0); ?></td>
          </tr>
          </tbody>
        </table>  
      </div>
</div>
      <!-- cash payment end -->
    <!-- </tr> -->
  <!-- </table> -->
<hr style="border-top: solid 1px gray;"/>
<?php } ?>
<?php if($ReportType == "sale" || $ReportType == "0"){ ?>
  <!-- cash sale and cash purcahse start -->
<div class="row">
  <div class="column">
        <table border="1" cellspacing="0" cellpadding="3">
          <thead>
            <tr>
              <th colspan="8" style="text-align: center;background-color:#000000;color:white;font-weight: bold;border-bottom:1px solid;">
                Sale - Cash
              </th>
            </tr>
            <tr>
              <th style="border-bottom:1px solid; width:5%; font-family:Tahoma, Arial; font-weight:bold; font-size:12px; text-align:center;background-color:#2AAA8A;color:black;">Sr.</th>
              <th style="border-bottom:1px solid; width:10%; font-family:Tahoma, Arial; font-weight:bold; font-size:12px; text-align:center;background-color:#2AAA8A;color:black;">Date</th>
              <th style="border-bottom:1px solid; width:25%; font-family:Tahoma, Arial; font-weight:bold; font-size:12px; text-align:center;background-color:#2AAA8A;color:black;">Product Detail</th>
              <th style="border-bottom:1px solid; width:15%; font-family:Tahoma, Arial; font-weight:bold; font-size:12px; text-align:center;background-color:#2AAA8A;color:black;">Customer Name</th>
              <th style="border-bottom:1px solid; width:5%; font-family:Tahoma, Arial; font-weight:bold; font-size:12px; text-align:center;background-color:#2AAA8A;color:black;">Qty</th>
              <th style="border-bottom:1px solid; width:10%; font-family:Tahoma, Arial; font-weight:bold; font-size:12px; text-align:center;background-color:#2AAA8A;color:black;">Rate</th>
              <th style="border-bottom:1px solid; width:10%; font-family:Tahoma, Arial; font-weight:bold; font-size:12px; text-align:center;background-color:#2AAA8A;color:black;">Amount</th>
              <th style="border-bottom:1px solid; width:10%; font-family:Tahoma, Arial; font-weight:bold; font-size:12px; text-align:center;background-color:#2AAA8A;color:black;">Net Amount</th>
            </tr>
          </thead>
          <tbody>
      <?php 
      $SNo = 0;
      $Amount = 0;
      $DiscountAmount = 0;
      $NetAmount = 0; 
      $NetQuantity = 0;
   
      foreach($SaleCash as $CashSale){
        $NetQuantity    += $CashSale['Quantity'];
        $Amount         += $CashSale['Amount'];
        $NetAmount      += $CashSale['NetAmount'];
      $SNo++; 
      ?>
          <tr style="font-size:12px;border-bottom:1px solid;">
            <td style="text-align: center; padding-left:10px;border-bottom:1px solid;"><?php echo $SNo; ?></td>
            <td style="text-align: center; padding-left:10px;border-bottom:1px solid;"><?php echo date("M j, Y", strtotime($CashSale['SaleDate'])); ?></td>
            <td style="text-align: left; padding-left:10px;border-bottom:1px solid;"><?php echo $CashSale['BrandName']." ".$CashSale['ProductGroupName']." ".$CashSale['ProductName']; ?></td>
            <td style="text-align:center; padding-right:5px;border-bottom:1px solid;"><?php echo $CashSale['CustomerName']; ?></td>
            <td style="text-align:center; padding-right:5px;border-bottom:1px solid;"><?php echo number_format($CashSale['Quantity'], 0); ?></td>
            <td style="text-align:center; padding-right:5px;border-bottom:1px solid;"><?php echo number_format($CashSale['Rate'],0); ?></td>
            <td style="text-align:center; padding-right:5px;border-bottom:1px solid;"><?php echo number_format($CashSale['Amount'],0); ?></td>
            <td style="text-align:center; padding-right:5px;border-bottom:1px solid;"><?php echo number_format($CashSale['NetAmount'],0); ?></td>                
          </tr>
    <?php } ?>
          <tr style="font-size:12px;border-bottom:1px solid;">
            <td colspan="4" style="text-align: right; padding-right:10px;font-weight:bold;border-bottom:1px solid;">Total</td>
            <td style="text-align:center; padding-right:5px;font-weight:bold;border-bottom:1px solid;"><?php echo number_format($NetQuantity,0); ?></td>
            <td style="text-align:center; padding-right:5px;font-weight:bold;border-bottom:1px solid;"><?php echo ""; ?></td>
            <td style="text-align:center; padding-right:5px;font-weight:bold;border-bottom:1px solid;"><?php echo number_format($Amount,0); ?></td>
            <td style="text-align:center; padding-right:5px;font-weight:bold;border-bottom:1px solid;"><?php echo number_format($NetAmount,0); ?></td>
          </tr>
        </table>
  </div>  
  <div class="column">
      <!-- sale credit start -->
      <!-- <div style="float: right;height: 50%;width: 49%;"> -->
        <table border="1" cellspacing="0" cellpadding="3">
          <thead>
            <tr>
              <th colspan="8" style="text-align: center;background-color:#000000;color:white;font-weight: bold;border-bottom:1px solid;">
                Sale - Credit
              </th>
            </tr>
            <tr>
              <th style="border-bottom:1px solid; width:5%; font-family:Tahoma, Arial; font-weight:bold; font-size:12px; text-align:center;background-color:#2AAA8A;color:black;">Sr.</th>
              <th style="border-bottom:1px solid; width:10%; font-family:Tahoma, Arial; font-weight:bold; font-size:12px; text-align:center;background-color:#2AAA8A;color:black;">Date</th>
              <th style="border-bottom:1px solid; width:25%; font-family:Tahoma, Arial; font-weight:bold; font-size:12px; text-align:center;background-color:#2AAA8A;color:black;">Product Detail</th>
              <th style="border-bottom:1px solid; width:15%; font-family:Tahoma, Arial; font-weight:bold; font-size:12px; text-align:center;background-color:#2AAA8A;color:black;">Customer Name</th>
              <th style="border-bottom:1px solid; width:5%; font-family:Tahoma, Arial; font-weight:bold; font-size:12px; text-align:center;background-color:#2AAA8A;color:black;">Qty</th>
              <th style="border-bottom:1px solid; width:10%; font-family:Tahoma, Arial; font-weight:bold; font-size:12px; text-align:center;background-color:#2AAA8A;color:black;">Rate</th>
              <th style="border-bottom:1px solid; width:10%; font-family:Tahoma, Arial; font-weight:bold; font-size:12px; text-align:center;background-color:#2AAA8A;color:black;">Amount</th>
              <th style="border-bottom:1px solid; width:10%; font-family:Tahoma, Arial; font-weight:bold; font-size:12px; text-align:center;background-color:#2AAA8A;color:black;">Net Amount</th>
            </tr>
          </thead>
          <tbody>
          
          <?php 
      $SNo = 0;
      $Amount = 0;
      $DiscountAmount = 0;
      $NetAmount = 0; 
      $NetQuantity = 0;
     
      foreach($SaleCredit as $CreditSale){
        $NetQuantity    += $CreditSale['Quantity'];
        $Amount         += $CreditSale['Amount'];
        $NetAmount      += $CreditSale['NetAmount'];
      $SNo++; 
      ?>
          <tr style="font-size:12px;border-bottom:1px solid;">
            <td style="text-align: center; padding-left:10px;border-bottom:1px solid;"><?php echo $SNo; ?></td>
            <td style="text-align: center; padding-left:10px;border-bottom:1px solid;"><?php echo date("M j, Y", strtotime($CreditSale['SaleDate'])); ?></td>
            <td style="text-align: left; padding-left:10px;border-bottom:1px solid;"><?php echo $CreditSale['BrandName']." ".$CreditSale['ProductGroupName']." ".$CreditSale['ProductName']; ?></td>
            <td style="text-align:center; padding-right:5px;border-bottom:1px solid;"><?php echo $CreditSale['CustomerName']; ?></td>
            <td style="text-align:center; padding-right:5px;border-bottom:1px solid;"><?php echo number_format($CreditSale['Quantity'],0); ?></td>
            <td style="text-align:center; padding-right:5px;border-bottom:1px solid;"><?php echo number_format($CreditSale['Rate'],0); ?></td>
            <td style="text-align:center; padding-right:5px;border-bottom:1px solid;"><?php echo number_format($CreditSale['Amount'],0); ?></td>
            <td style="text-align:center; padding-right:5px;border-bottom:1px solid;"><?php echo number_format($CreditSale['NetAmount'],0); ?></td>                
          </tr>
    <?php } ?>

          <tr style="font-size:12px;border-bottom:1px solid;">
            <td colspan="4" style="text-align: right; padding-right:10px;font-weight:bold;border-bottom:1px solid;">Total</td>
            <td style="text-align:center; padding-right:5px;font-weight:bold;border-bottom:1px solid;"><?php echo number_format($NetQuantity,0); ?></td>
            <td style="text-align:center; padding-right:5px;font-weight:bold;border-bottom:1px solid;"><?php echo ""; ?></td>
            <td style="text-align:center; padding-right:5px;font-weight:bold;border-bottom:1px solid;"><?php echo number_format($Amount,0); ?></td>
            <td style="text-align:center; padding-right:5px;font-weight:bold;border-bottom:1px solid;"><?php echo number_format($NetAmount,0); ?></td>
          </tr>
        </table>  
  </div>
</div>
      <!-- sale credit end -->
<!-- cash sale and cash purcahse end -->
<br>
<!-- sale return cash and sale return credit -->
<!-- <div style="float: left;height: 50%;width: 49%;"> -->
<div class="row">
  <div class="column">
      <table border="1" cellspacing="0" cellpadding="3">
          <thead>
            <tr>
              <th colspan="8" style="text-align: center;background-color:#000000;color:white;font-weight: bold;border-bottom:1px solid;">
                Sale Return - Cash
              </th>
            </tr>
            <tr>
              <th style="border-bottom:1px solid; width:5%; font-family:Tahoma, Arial; font-weight:bold; font-size:12px; text-align:center;background-color:#2AAA8A;color:black;">Sr.</th>
              <th style="border-bottom:1px solid; width:10%; font-family:Tahoma, Arial; font-weight:bold; font-size:12px; text-align:center;background-color:#2AAA8A;color:black;">Date</th>
              <th style="border-bottom:1px solid; width:25%; font-family:Tahoma, Arial; font-weight:bold; font-size:12px; text-align:center;background-color:#2AAA8A;color:black;">Product Detail</th>
              <th style="border-bottom:1px solid; width:15%; font-family:Tahoma, Arial; font-weight:bold; font-size:12px; text-align:center;background-color:#2AAA8A;color:black;">Customer Name</th>
              <th style="border-bottom:1px solid; width:5%; font-family:Tahoma, Arial; font-weight:bold; font-size:12px; text-align:center;background-color:#2AAA8A;color:black;">Qty</th>
              <th style="border-bottom:1px solid; width:10%; font-family:Tahoma, Arial; font-weight:bold; font-size:12px; text-align:center;background-color:#2AAA8A;color:black;">Rate</th>
              <th style="border-bottom:1px solid; width:10%; font-family:Tahoma, Arial; font-weight:bold; font-size:12px; text-align:center;background-color:#2AAA8A;color:black;">Amount</th>
              <th style="border-bottom:1px solid; width:10%; font-family:Tahoma, Arial; font-weight:bold; font-size:12px; text-align:center;background-color:#2AAA8A;color:black;">Net Amount</th>
            </tr>
          </thead>
          <tbody>
      <?php 
      $SNo = 0;
      $Amount = 0;
      $DiscountAmount = 0;
      $NetAmount = 0; 
      $NetQuantity = 0;
      foreach($SaleReturnCash as $CashSaleReturn){
        $NetQuantity    += $CashSaleReturn['Quantity'];
        $Amount         += $CashSaleReturn['Amount'];
        $NetAmount      += $CashSaleReturn['NetAmount'];
      $SNo++; 
      ?>
          <tr style="font-size:12px;border-bottom:1px solid;">
            <td style="text-align: center; padding-left:10px;border-bottom:1px solid;"><?php echo $SNo; ?></td>
            <td style="text-align: center; padding-left:10px;border-bottom:1px solid;"><?php echo date("M j, Y", strtotime($CashSaleReturn['SaleReturnDate'])); ?></td>
            <td style="text-align: left; padding-left:10px;border-bottom:1px solid;"><?php echo $CashSaleReturn['BrandName']." ".$CashSaleReturn['ProductGroupName']." ".$CashSaleReturn['ProductName']; ?></td>
            <td style="text-align:center; padding-right:5px;border-bottom:1px solid;"><?php echo $CashSaleReturn['CustomerName']; ?></td>
            <td style="text-align:center; padding-right:5px;border-bottom:1px solid;"><?php echo number_format($CashSaleReturn['Quantity'],0); ?></td>
            <td style="text-align:center; padding-right:5px;border-bottom:1px solid;"><?php echo number_format($CashSaleReturn['Rate'],0); ?></td>
            <td style="text-align:center; padding-right:5px;border-bottom:1px solid;"><?php echo number_format($CashSaleReturn['Amount'],0); ?></td>
            <td style="text-align:center; padding-right:5px;border-bottom:1px solid;"><?php echo number_format($CashSaleReturn['NetAmount'],0); ?></td>                
          </tr>
    <?php } ?>
          <tr style="font-size:12px;border-bottom:1px solid;">
            <td colspan="4" style="text-align: right; padding-right:10px;font-weight:bold;border-bottom:1px solid;">Total</td>
            <td style="text-align:center; padding-right:5px;font-weight:bold;border-bottom:1px solid;"><?php echo number_format($NetQuantity,0); ?></td>
            <td style="text-align:center; padding-right:5px;font-weight:bold;border-bottom:1px solid;"><?php echo ""; ?></td>
            <td style="text-align:center; padding-right:5px;font-weight:bold;border-bottom:1px solid;"><?php echo number_format($Amount,0); ?></td>
            <td style="text-align:center; padding-right:5px;font-weight:bold;border-bottom:1px solid;"><?php echo number_format($NetAmount,0); ?></td>
          </tr>
        </table>  
  </div>
  <div class="column">
      <!-- sale return credit start -->
  <!-- <div style="float: right;height: 50%;width: 49%;">         -->
    <table border="1" cellspacing="0" cellpadding="3">
          <thead>
            <tr>
              <th colspan="8" style="text-align: center;background-color:#000000;color:white;font-weight: bold;border-bottom:1px solid;">
                Sale Return - Credit
              </th>
            </tr>
            <tr>
              <th style="border-bottom:1px solid; width:5%; font-family:Tahoma, Arial; font-weight:bold; font-size:12px; text-align:center;background-color:#2AAA8A;color:black;">Sr.</th>
              <th style="border-bottom:1px solid; width:10%; font-family:Tahoma, Arial; font-weight:bold; font-size:12px; text-align:center;background-color:#2AAA8A;color:black;">Date</th>
              <th style="border-bottom:1px solid; width:25%; font-family:Tahoma, Arial; font-weight:bold; font-size:12px; text-align:center;background-color:#2AAA8A;color:black;">Product Detail</th>
              <th style="border-bottom:1px solid; width:15%; font-family:Tahoma, Arial; font-weight:bold; font-size:12px; text-align:center;background-color:#2AAA8A;color:black;">Customer Name</th>
              <th style="border-bottom:1px solid; width:5%; font-family:Tahoma, Arial; font-weight:bold; font-size:12px; text-align:center;background-color:#2AAA8A;color:black;">Qty</th>
              <th style="border-bottom:1px solid; width:10%; font-family:Tahoma, Arial; font-weight:bold; font-size:12px; text-align:center;background-color:#2AAA8A;color:black;">Rate</th>
              <th style="border-bottom:1px solid; width:10%; font-family:Tahoma, Arial; font-weight:bold; font-size:12px; text-align:center;background-color:#2AAA8A;color:black;">Amount</th>
              <th style="border-bottom:1px solid; width:10%; font-family:Tahoma, Arial; font-weight:bold; font-size:12px; text-align:center;background-color:#2AAA8A;color:black;">Net Amount</th>
            </tr>
          </thead>
          <tbody>
          
          <?php 
      $SNo = 0;
      $Amount = 0;
      $DiscountAmount = 0;
      $NetAmount = 0; 
      $NetQuantity = 0;
      foreach($SaleReturnCredit as $CreditSaleReturn){
        $NetQuantity    += $CreditSaleReturn['Quantity'];
        $Amount         += $CreditSaleReturn['Amount'];
        $NetAmount      += $CreditSaleReturn['NetAmount'];
      $SNo++; 
      ?>
          <tr style="font-size:12px;border-bottom:1px solid;">
            <td style="text-align: center; padding-left:10px;border-bottom:1px solid;"><?php echo $SNo; ?></td>
            <td style="text-align: center; padding-left:10px;border-bottom:1px solid;"><?php echo date("M j, Y", strtotime($CreditSaleReturn['SaleReturnDate'])); ?></td>
            <td style="text-align: left; padding-left:10px;border-bottom:1px solid;"><?php echo $CreditSaleReturn['BrandName']." ".$CreditSaleReturn['ProductGroupName']." ".$CreditSaleReturn['ProductName']; ?></td>
            <td style="text-align:center; padding-right:5px;border-bottom:1px solid;"><?php echo $CreditSaleReturn['CustomerName']; ?></td>
            <td style="text-align:center; padding-right:5px;border-bottom:1px solid;"><?php echo number_format($CreditSaleReturn['Quantity'],0); ?></td>
            <td style="text-align:center; padding-right:5px;border-bottom:1px solid;"><?php echo number_format($CreditSaleReturn['Rate'],0); ?></td>
            <td style="text-align:center; padding-right:5px;border-bottom:1px solid;"><?php echo number_format($CreditSaleReturn['Amount'],0); ?></td>
            <td style="text-align:center; padding-right:5px;border-bottom:1px solid;"><?php echo number_format($CreditSaleReturn['NetAmount'],0); ?></td>                
          </tr>
    <?php } ?>

          <tr style="font-size:12px;border-bottom:1px solid;">
            <td colspan="4" style="text-align: right; padding-right:10px;font-weight:bold;border-bottom:1px solid;">Total</td>
            <td style="text-align:center; padding-right:5px;font-weight:bold;border-bottom:1px solid;"><?php echo number_format($NetQuantity,0); ?></td>
            <td style="text-align:center; padding-right:5px;font-weight:bold;border-bottom:1px solid;"><?php echo ""; ?></td>
            <td style="text-align:center; padding-right:5px;font-weight:bold;border-bottom:1px solid;"><?php echo number_format($Amount,0); ?></td>
            <td style="text-align:center; padding-right:5px;font-weight:bold;border-bottom:1px solid;"><?php echo number_format($NetAmount,0); ?></td>
          </tr>
        </table>  
    </div>
</div>
      <!-- sale return credit end -->
  <br>
<!-- sale return cash and sale return end -->
<hr style="border-top: solid 1px gray;"/>
<?php } ?>
<?php if($ReportType == "purchase" || $ReportType == "0"){?>
<!-- credit sale and credit purcahse start -->
<div class="row">
  <div class="column">
    <!-- purchase cash start -->
        <table border="1" cellspacing="0" cellpadding="3">
          <thead>
            <tr>
              <th colspan="8" style="text-align: center;background-color:#000000;color:white;font-weight: bold;border-bottom:1px solid;">
                Purchase - Cash
              </th>
            </tr>
            <tr>
              <th style="border-bottom:1px solid; width:5%; font-family:Tahoma, Arial; font-weight:bold; font-size:12px; text-align:center;background-color:#2AAA8A;color:black;">Sr.</th>
              <th style="border-bottom:1px solid; width:10%; font-family:Tahoma, Arial; font-weight:bold; font-size:12px; text-align:center;background-color:#2AAA8A;color:black;">Date</th>
              <th style="border-bottom:1px solid; width:25%; font-family:Tahoma, Arial; font-weight:bold; font-size:12px; text-align:center;background-color:#2AAA8A;color:black;">Product Detail</th>
              <th style="border-bottom:1px solid; width:15%; font-family:Tahoma, Arial; font-weight:bold; font-size:12px; text-align:center;background-color:#2AAA8A;color:black;">Vendor Name</th>
              <th style="border-bottom:1px solid; width:5%; font-family:Tahoma, Arial; font-weight:bold; font-size:12px; text-align:center;background-color:#2AAA8A;color:black;">Qty</th>
              <th style="border-bottom:1px solid; width:10%; font-family:Tahoma, Arial; font-weight:bold; font-size:12px; text-align:center;background-color:#2AAA8A;color:black;">Rate</th>
              <th style="border-bottom:1px solid; width:10%; font-family:Tahoma, Arial; font-weight:bold; font-size:12px; text-align:center;background-color:#2AAA8A;color:black;">Amount</th>
              <th style="border-bottom:1px solid; width:10%; font-family:Tahoma, Arial; font-weight:bold; font-size:12px; text-align:center;background-color:#2AAA8A;color:black;">Net Amount</th>
            </tr>
          </thead>
          <tbody>
      <?php 
        $SNo = 0;
        $Amount = 0;
        $DiscountAmount = 0;
        $NetAmount = 0; 
        $NetQuantity = 0;
      
        foreach($PurchaseCash as $CashPurchase){
          $NetQuantity    += $CashPurchase['Quantity'];
          $Amount         += $CashPurchase['Amount'];
          $NetAmount      += $CashPurchase['NetAmount'];
        $SNo++; 
      ?>
          <tr style="font-size:12px;border-bottom:1px solid;">
            <td style="text-align: center; padding-left:10px;border-bottom:1px solid;"><?php echo $SNo; ?></td>
            <td style="text-align: center; padding-left:10px;border-bottom:1px solid;"><?php echo date("M j, Y", strtotime($CashPurchase['PurchaseDate'])); ?></td>
            <td style="text-align: left; padding-left:10px;border-bottom:1px solid;"><?php echo $CashPurchase['BrandName']." ".$CashPurchase['ProductGroupName']." ".$CashPurchase['ProductName']; ?></td>
            <td style="text-align:center; padding-right:5px;border-bottom:1px solid;"><?php echo $CashPurchase['VendorName']; ?></td>
            <td style="text-align:center; padding-right:5px;border-bottom:1px solid;"><?php echo number_format($CashPurchase['Quantity'],0); ?></td>
            <td style="text-align:center; padding-right:5px;border-bottom:1px solid;"><?php echo number_format($CashPurchase['Rate'],0); ?></td>
            <td style="text-align:center; padding-right:5px;border-bottom:1px solid;"><?php echo number_format($CashPurchase['Amount'],0); ?></td>
            <td style="text-align:center; padding-right:5px;border-bottom:1px solid;"><?php echo number_format($CashPurchase['NetAmount'],0); ?></td>                
          </tr>
     <?php } ?>
          <tr style="font-size:12px;border-bottom:1px solid;">
            <td colspan="4" style="text-align: right; padding-right:10px;font-weight:bold;border-bottom:1px solid;">Total</td>
            <td style="text-align:center; padding-right:5px;font-weight:bold;border-bottom:1px solid;"><?php echo number_format($NetQuantity,0); ?></td>
            <td style="text-align:center; padding-right:5px;font-weight:bold;border-bottom:1px solid;"><?php echo ""; ?></td>
            <td style="text-align:center; padding-right:5px;font-weight:bold;border-bottom:1px solid;"><?php echo number_format($Amount,0); ?></td>
            <td style="text-align:center; padding-right:5px;font-weight:bold;border-bottom:1px solid;"><?php echo number_format($NetAmount,0); ?></td>
          </tr>
        </table>  
  </div>
  <div class="column">
      <!-- purchase cash end -->
      <!-- purchase credit start -->
        <table border="1" cellspacing="0" cellpadding="3">
          <thead>
            <tr>
              <th colspan="8" style="text-align: center;background-color:#000000;color:white;font-weight: bold;border-bottom:1px solid;">
                Purchase - Credit
              </th>
            </tr>
            <tr>
              <th style="border-bottom:1px solid; width:5%; font-family:Tahoma, Arial; font-weight:bold; font-size:12px; text-align:center;background-color:#2AAA8A;color:black;">Sr.</th>
              <th style="border-bottom:1px solid; width:10%; font-family:Tahoma, Arial; font-weight:bold; font-size:12px; text-align:center;background-color:#2AAA8A;color:black;">Date</th>
              <th style="border-bottom:1px solid; width:25%; font-family:Tahoma, Arial; font-weight:bold; font-size:12px; text-align:center;background-color:#2AAA8A;color:black;">Product Detail</th>
              <th style="border-bottom:1px solid; width:15%; font-family:Tahoma, Arial; font-weight:bold; font-size:12px; text-align:center;background-color:#2AAA8A;color:black;">Vendor Name</th>
              <th style="border-bottom:1px solid; width:5%; font-family:Tahoma, Arial; font-weight:bold; font-size:12px; text-align:center;background-color:#2AAA8A;color:black;">Qty</th>
              <th style="border-bottom:1px solid; width:10%; font-family:Tahoma, Arial; font-weight:bold; font-size:12px; text-align:center;background-color:#2AAA8A;color:black;">Rate</th>
              <th style="border-bottom:1px solid; width:10%; font-family:Tahoma, Arial; font-weight:bold; font-size:12px; text-align:center;background-color:#2AAA8A;color:black;">Amount</th>
              <th style="border-bottom:1px solid; width:10%; font-family:Tahoma, Arial; font-weight:bold; font-size:12px; text-align:center;background-color:#2AAA8A;color:black;">Net Amount</th>
            </tr>
          </thead>
          <tbody>
          
      <?php 
        $SNo = 0;
        $Amount = 0;
        $DiscountAmount = 0;
        $NetAmount = 0; 
        $NetQuantity = 0;
        foreach($PurchaseCredit as $CreditPurchase){
          $NetQuantity    += $CreditPurchase['Quantity'];
          $Amount         += $CreditPurchase['Amount'];
          $NetAmount      += $CreditPurchase['NetAmount'];
        $SNo++; 
      ?>
          <tr style="font-size:12px;border-bottom:1px solid;">
            <td style="text-align: center; padding-left:10px;border-bottom:1px solid;"><?php echo $SNo; ?></td>
            <td style="text-align: center; padding-left:10px;border-bottom:1px solid;"><?php echo date("M j, Y", strtotime($CreditPurchase['PurchaseDate'])); ?></td>
            <td style="text-align: left; padding-left:10px;border-bottom:1px solid;"><?php echo $CreditPurchase['BrandName']." ".$CreditPurchase['ProductGroupName']." ".$CreditPurchase['ProductName'];; ?></td>
            <td style="text-align:center; padding-right:5px;border-bottom:1px solid;"><?php echo $CreditPurchase['VendorName']; ?></td>
            <td style="text-align:center; padding-right:5px;border-bottom:1px solid;"><?php echo number_format($CreditPurchase['Quantity'],0); ?></td>
            <td style="text-align:center; padding-right:5px;border-bottom:1px solid;"><?php echo number_format($CreditPurchase['Rate'],0); ?></td>
            <td style="text-align:center; padding-right:5px;border-bottom:1px solid;"><?php echo number_format($CreditPurchase['Amount'],0); ?></td>
            <td style="text-align:center; padding-right:5px;border-bottom:1px solid;"><?php echo number_format($CreditPurchase['NetAmount'],0); ?></td>                
          </tr>
     <?php } ?>
          <tr style="font-size:12px;border-bottom:1px solid;">
            <td colspan="4" style="text-align: right; padding-right:10px;font-weight:bold;border-bottom:1px solid;">Total</td>
            <td style="text-align:center; padding-right:5px;font-weight:bold;border-bottom:1px solid;"><?php echo number_format($NetQuantity,0); ?></td>
            <td style="text-align:center; padding-right:5px;font-weight:bold;border-bottom:1px solid;"><?php echo ""; ?></td>
            <td style="text-align:center; padding-right:5px;font-weight:bold;border-bottom:1px solid;"><?php echo number_format($Amount,0); ?></td>
            <td style="text-align:center; padding-right:5px;font-weight:bold;border-bottom:1px solid;"><?php echo number_format($NetAmount,0); ?></td>
          </tr>
        </table>  
      </div>
</div>
      <!-- purchase credit end -->
<!-- credit sale and credit purcahse end -->
<br>
<!-- purchase return cash and purchase return credit start -->
<div class="row">
  <div class="column">
        <table border="1" cellspacing="0" cellpadding="3">
          <thead>
            <tr>
              <th colspan="8" style="text-align: center;background-color:#000000;color:white;font-weight: bold;border-bottom:1px solid;">
                Purchase Return - Cash
              </th>
            </tr>
            <tr>
              <th style="border-bottom:1px solid; width:5%; font-family:Tahoma, Arial; font-weight:bold; font-size:12px; text-align:center;background-color:#2AAA8A;color:black;">Sr.</th>
              <th style="border-bottom:1px solid; width:10%; font-family:Tahoma, Arial; font-weight:bold; font-size:12px; text-align:center;background-color:#2AAA8A;color:black;">Date</th>
              <th style="border-bottom:1px solid; width:25%; font-family:Tahoma, Arial; font-weight:bold; font-size:12px; text-align:center;background-color:#2AAA8A;color:black;">Product Detail</th>
              <th style="border-bottom:1px solid; width:15%; font-family:Tahoma, Arial; font-weight:bold; font-size:12px; text-align:center;background-color:#2AAA8A;color:black;">Vendor Name</th>
              <th style="border-bottom:1px solid; width:5%; font-family:Tahoma, Arial; font-weight:bold; font-size:12px; text-align:center;background-color:#2AAA8A;color:black;">Qty</th>
              <th style="border-bottom:1px solid; width:10%; font-family:Tahoma, Arial; font-weight:bold; font-size:12px; text-align:center;background-color:#2AAA8A;color:black;">Rate</th>
              <th style="border-bottom:1px solid; width:10%; font-family:Tahoma, Arial; font-weight:bold; font-size:12px; text-align:center;background-color:#2AAA8A;color:black;">Amount</th>
              <th style="border-bottom:1px solid; width:10%; font-family:Tahoma, Arial; font-weight:bold; font-size:12px; text-align:center;background-color:#2AAA8A;color:black;">Net Amount</th>
            </tr>
          </thead>
          <tbody>
      <?php 
        $SNo = 0;
        $Amount = 0;
        $DiscountAmount = 0;
        $NetAmount = 0; 
        $NetQuantity = 0;
      
        foreach($PurchaseReturnCash as $CashPurchaseReturn){
          $NetQuantity    += $CashPurchaseReturn['Quantity'];
          $Amount         += $CashPurchaseReturn['Amount'];
          $NetAmount      += $CashPurchaseReturn['NetAmount'];
        $SNo++; 
      ?>
          <tr style="font-size:12px;border-bottom:1px solid;">
            <td style="text-align: center; padding-left:10px;border-bottom:1px solid;"><?php echo $SNo; ?></td>
            <td style="text-align: center; padding-left:10px;border-bottom:1px solid;"><?php echo date("M j, Y", strtotime($CashPurchaseReturn['PurchaseReturnDate'])); ?></td>
            <td style="text-align: left; padding-left:10px;border-bottom:1px solid;"><?php echo $CashPurchaseReturn['BrandName']." ".$CashPurchaseReturn['ProductGroupName']." ".$CashPurchaseReturn['ProductName']; ?></td>
            <td style="text-align:center; padding-right:5px;border-bottom:1px solid;"><?php echo $CashPurchaseReturn['VendorName']; ?></td>
            <td style="text-align:center; padding-right:5px;border-bottom:1px solid;"><?php echo number_format($CashPurchaseReturn['Quantity'],0); ?></td>
            <td style="text-align:center; padding-right:5px;border-bottom:1px solid;"><?php echo number_format($CashPurchaseReturn['Rate'],0); ?></td>
            <td style="text-align:center; padding-right:5px;border-bottom:1px solid;"><?php echo number_format($CashPurchaseReturn['Amount'],0); ?></td>
            <td style="text-align:center; padding-right:5px;border-bottom:1px solid;"><?php echo number_format($CashPurchaseReturn['NetAmount'],0); ?></td>                
          </tr>
     <?php } ?>
          <tr style="font-size:12px;border-bottom:1px solid;">
            <td colspan="4" style="text-align: right; padding-right:10px;font-weight:bold;border-bottom:1px solid;">Total</td>
            <td style="text-align:center; padding-right:5px;font-weight:bold;border-bottom:1px solid;"><?php echo number_format($NetQuantity,0); ?></td>
            <td style="text-align:center; padding-right:5px;font-weight:bold;border-bottom:1px solid;"><?php echo ""; ?></td>
            <td style="text-align:center; padding-right:5px;font-weight:bold;border-bottom:1px solid;"><?php echo number_format($Amount,0); ?></td>
            <td style="text-align:center; padding-right:5px;font-weight:bold;border-bottom:1px solid;"><?php echo number_format($NetAmount,0); ?></td>
          </tr>
        </table>  
  </div>
      <!-- purchase return cash end -->
      <!-- purchase return credit start -->
  <div class="column">  
        <table border="1" cellspacing="0" cellpadding="3">
          <thead>
            <tr>
              <th colspan="8" style="text-align: center;background-color:#000000;color:white;font-weight: bold;border-bottom:1px solid;">
                Purchase Return - Credit
              </th>
            </tr>
            <tr>
              <th style="border-bottom:1px solid; width:5%; font-family:Tahoma, Arial; font-weight:bold; font-size:12px; text-align:center;background-color:#2AAA8A;color:black;">Sr.</th>
              <th style="border-bottom:1px solid; width:10%; font-family:Tahoma, Arial; font-weight:bold; font-size:12px; text-align:center;background-color:#2AAA8A;color:black;">Date</th>
              <th style="border-bottom:1px solid; width:25%; font-family:Tahoma, Arial; font-weight:bold; font-size:12px; text-align:center;background-color:#2AAA8A;color:black;">Product Detail</th>
              <th style="border-bottom:1px solid; width:15%; font-family:Tahoma, Arial; font-weight:bold; font-size:12px; text-align:center;background-color:#2AAA8A;color:black;">Vendor Name</th>
              <th style="border-bottom:1px solid; width:5%; font-family:Tahoma, Arial; font-weight:bold; font-size:12px; text-align:center;background-color:#2AAA8A;color:black;">Qty</th>
              <th style="border-bottom:1px solid; width:10%; font-family:Tahoma, Arial; font-weight:bold; font-size:12px; text-align:center;background-color:#2AAA8A;color:black;">Rate</th>
              <th style="border-bottom:1px solid; width:10%; font-family:Tahoma, Arial; font-weight:bold; font-size:12px; text-align:center;background-color:#2AAA8A;color:black;">Amount</th>
              <th style="border-bottom:1px solid; width:10%; font-family:Tahoma, Arial; font-weight:bold; font-size:12px; text-align:center;background-color:#2AAA8A;color:black;">Net Amount</th>
            </tr>
          </thead>
          <tbody>
          
          <?php 
        $SNo = 0;
        $Amount = 0;
        $DiscountAmount = 0;
        $NetAmount = 0; 
        $NetQuantity = 0;
        foreach($PurchaseReturnCredit as $CreditPurchaseReturn){
          $NetQuantity    += $CreditPurchaseReturn['Quantity'];
          $Amount         += $CreditPurchaseReturn['Amount'];
          $NetAmount      += $CreditPurchaseReturn['NetAmount'];
        $SNo++; 
      ?>
          <tr style="font-size:12px;border-bottom:1px solid;">
            <td style="text-align: center; padding-left:10px;border-bottom:1px solid;"><?php echo $SNo; ?></td>
            <td style="text-align: center; padding-left:10px;border-bottom:1px solid;"><?php echo date("M j, Y", strtotime($CreditPurchaseReturn['PurchaseReturnDate'])); ?></td>
            <td style="text-align: left; padding-left:10px;border-bottom:1px solid;"><?php echo $CreditPurchaseReturn['BrandName']." ".$CreditPurchaseReturn['ProductGroupName']." ".$CreditPurchaseReturn['ProductName'];; ?></td>
            <td style="text-align:center; padding-right:5px;border-bottom:1px solid;"><?php echo $CreditPurchaseReturn['VendorName']; ?></td>
            <td style="text-align:center; padding-right:5px;border-bottom:1px solid;"><?php echo number_format($CreditPurchaseReturn['Quantity'],0); ?></td>
            <td style="text-align:center; padding-right:5px;border-bottom:1px solid;"><?php echo number_format($CreditPurchaseReturn['Rate'],0); ?></td>
            <td style="text-align:center; padding-right:5px;border-bottom:1px solid;"><?php echo number_format($CreditPurchaseReturn['Amount'],0); ?></td>
            <td style="text-align:center; padding-right:5px;border-bottom:1px solid;"><?php echo number_format($CreditPurchaseReturn['NetAmount'],0); ?></td>                
          </tr>
     <?php } ?>
          <tr style="font-size:12px;border-bottom:1px solid;">
            <td colspan="4" style="text-align: right; padding-right:10px;font-weight:bold;border-bottom:1px solid;">Total</td>
            <td style="text-align:center; padding-right:5px;font-weight:bold;border-bottom:1px solid;"><?php echo number_format($NetQuantity,0); ?></td>
            <td style="text-align:center; padding-right:5px;font-weight:bold;border-bottom:1px solid;"><?php echo ""; ?></td>
            <td style="text-align:center; padding-right:5px;font-weight:bold;border-bottom:1px solid;"><?php echo number_format($Amount,0); ?></td>
            <td style="text-align:center; padding-right:5px;font-weight:bold;border-bottom:1px solid;"><?php echo number_format($NetAmount,0); ?></td>
          </tr>
        </table>  
      </div>
</div>
      <!-- purchase return credit end -->
<!-- purchase return cash and purchase return credit end -->
<br>
<hr style="border-top: solid 1px gray;"/>
<?php } ?>
<!-- bank ledger start -->
<?php if($ReportType == "bank" || $ReportType == "0"){ ?>
  <br>
    <?php
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

        //if(isset($LedgerReport)) {
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
    <table border="1" cellspacing="0" cellpadding="3" style="width:100%; text-align: center; padding-left: 1px;">
      <thead>
        <tr>
          <th colspan="7" style="text-align: left;font-weight: bold;">
            Bank Name: <?php echo $ChartOfAccountTitle; ?>
          </th>
        </tr>
        <tr>
          <th style="border-bottom:1px solid; width:3%; font-family:Tahoma, Arial; font-weight:bold; font-size:12px; text-align:center;background-color:#2AAA8A;color:black;">Sr.</th>
          <th style="border-bottom:1px solid; width:7%; font-family:Tahoma, Arial; font-weight:bold; font-size:12px; text-align:center;background-color:#2AAA8A;color:black;">Date</th>
          <th style="border-bottom:1px solid; width:5%; font-family:Tahoma, Arial; font-weight:bold; font-size:12px; text-align:center;background-color:#2AAA8A;color:black;">Ref.no</th>
          <th style="border-bottom:1px solid; width:45%; font-family:Tahoma, Arial; font-weight:bold; font-size:12px; text-align:center;background-color:#2AAA8A;color:black;">Description</th>
          <th style="border-bottom:1px solid; width:10%; font-family:Tahoma, Arial; font-weight:bold; font-size:12px; text-align:center;background-color:#2AAA8A;color:black;">Debit</th>
          <th style="border-bottom:1px solid; width:10%; font-family:Tahoma, Arial; font-weight:bold; font-size:12px; text-align:center;background-color:#2AAA8A;color:black;">Credit</th>
          <th style="border-bottom:1px solid; width:10%; font-family:Tahoma, Arial; font-weight:bold; font-size:12px; text-align:center;background-color:#2AAA8A;color:black;">Balance</th>
        </tr>
      </thead>
      <tbody>
      <tr style="font-size:12px;border-bottom:1px solid;">
        <td style="text-align:center; padding-left:10px;border-bottom:1px solid;"><?php //echo $SNo; ?></td>
        <td style="text-align:center; padding-left:10px;border-bottom:1px solid;"><?php //echo $sTransactionDate; ?></td>
        <td style="text-align:center; padding-left:10px;border-bottom:1px solid;"><?php //echo $Reference; ?></td>
        <td style="text-align: left; padding-left:10px;border-bottom:1px solid;font-weight:bold;">Opening Balance</td>
        <td style="text-align:center; padding-left:10px;border-bottom:1px solid;"><?php //echo $sDebit; ?></td>
        <td style="text-align:center; padding-left:10px;border-bottom:1px solid;"><?php //echo $sCredit; ?></td>
        <td style="text-align:center; padding-left:10px;border-bottom:1px solid;font-weight:bold;"><?php echo number_format($dBalance,0); ?></td>
      </tr>
      <?php
      $SNo=0;
        foreach($SubLedgerReport as $SubLedgerReportRecord) { 
          if($SubLedgerReportRecord['ChartOfAccountId'] == $LedgerReportRecord['ChartOfAccountId']) 
          {
            $SNo++;
            $ChartOfAccountId = $SubLedgerReportRecord['ChartOfAccountId'];
            $GeneralJournalId = $SubLedgerReportRecord['GeneralJournalId'];
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

      <tr style="font-size:12px;border-bottom:1px solid;">
        <td style="text-align: center; padding-left:10px;border-bottom:1px solid;"><?php echo $SNo; ?></td>
        <td style="text-align: center; padding-left:10px;border-bottom:1px solid;"><?php echo $sTransactionDate; ?></td>
        <td style="text-align:center; padding-left:10px;border-bottom:1px solid;"><?php echo $Reference;; ?></td>
        <td style="text-align:left; padding-left:10px;border-bottom:1px solid;<?php if(trim($Detail) == "Closing Balance"){echo "font-weight:bold;"; }?>"><?php echo $Detail; ?></td>
        <td style="text-align:center; padding-left:10px;border-bottom:1px solid;<?php if(trim($Detail) == "Closing Balance"){echo "font-weight:bold;"; }?>"><?php echo $sDebit; ?></td>              
        <td style="text-align:center; padding-left:10px;border-bottom:1px solid;<?php if(trim($Detail) == "Closing Balance"){echo "font-weight:bold;"; }?>"><?php echo $sCredit; ?></td>
        <td style="text-align:center; padding-left:10px;border-bottom:1px solid;<?php if(trim($Detail) == "Closing Balance"){echo "font-weight:bold;"; }?>"><?php echo number_format($dBalance,0); ?></td>
      </tr>

      <?php
      $dGrandTotal_Debit += $dDebit;
      $dGrandTotal_Credit += $dCredit;
      $GrandBalance = $dGrandTotal_Debit - $dGrandTotal_Credit;
        } 
      }
      ?>
      </tbody>
      <?php
      $sDebit = 0;
      $sCredit = 0;
      $dBalance = 0;
      $dTotal_Debit = 0;
      $dTotal_Credit = 0;
      $dBalance = 0;
       ?>
  </table>
  <br> 
  <?php
      }
  ?>
  <hr style="border-top: solid 1px gray;"/>
<?php
    }
?>
  <!-- bank ledger end -->
  
         </div>   
       </div>
    </div>
  </body>
</html>

<!-- Modal -->

<script src="<?php echo base_url(); ?>plugins/select2/select2.min.js"></script>
<script src="<?php echo base_url(); ?>lib/js/freeze-table.js"></script>

<script>
  $(document).ready(function() {
    $('.js-example-basic-multiple').select2();
});
</script>
<script src="<?php echo base_url(); ?>lib/js/freeze-table.js"></script>
<script>
$(document).ready(function() {

  $(".table-basic").freezeTable();

  $(".table-head-only").freezeTable({
    'freezeColumn': false,
  });

});
</script>