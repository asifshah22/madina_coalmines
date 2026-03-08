<?php
header("Content-type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename = Ledger Report.xls");
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Ledger Report</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport"> 
  <!-- Bootstrap 3.3.6 -->
  <script src="<?php echo base_url(); ?>bootstrap/js/bootstrap.min.js"></script>
  <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>bootstrap/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>lib/css/font-awesome/font-awesome.min.css">
</head>
<body class="hold-transition skin-blue sidebar-mini">
	<div class="wrapper">
      <div class="box box-info">

        <div class="col-md-12 col-xs-12">
            <h2 style="color:black; font-family:Georgia; font-weight:600;text-align: center; margin-top: 10px;" class="box-title">HANIF PACKAGES</h2>
          </div>
    <br><br>
      <h3 style="color:green;text-align: center;">General Ledger</h3>
      
      <div style="padding-top:-0.1em; font-size:12px; font-weight:600; text-align:center;">Period of <?php echo date('M d, Y', strtotime($this->input->get('StartDate'))).' &nbsp; - &nbsp;  '. date('M d, Y', strtotime($this->input->get('EndDate'))); ?>
      </div>
      <hr style="color: #003eff; border-width: 1px; border-style: inset; display: block;">
           </div>
           <br>
      <div style="height:30px;"></div>
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
            
//            $AccountGroupId = $LedgerReportRecord['AccountGroupId'];
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
            <table style="width:100%; text-align: center; padding-left: 1px; border-bottom: 0px;">
              <thead>
                <tr style="border-bottom: 0px; border-top: 0px; border-right: 0px; border-left: 0px;">
                 <th style="font-family:Calibri; font-size:15px; padding-left:10px; height: 40px;" align="left" colspan="7">General Ledger - <?php echo $ChartOfAccountTitle; ?></th>
		</tr>
		<tr>
		   <th style="font-family:Calibri; font-size:15px; padding-left:10px; height: 40px; border: none;" align="left" colspan="7">Opening Balance  <?php echo number_format($dBalance, 0); ?></th> 
		</tr>
                <tr style="background-color: #205081; color: #fff; height: 30px;border-bottom: 1px solid;">
                 <th style="border-bottom:1px solid; width:6%; font-family:Calibri; font-weight:bold; font-size:12px; text-align: center;">Date</th>
                 <th style="border-bottom:1px solid; width:35%; font-family:Calibri; font-weight:bold; font-size:12px; text-align: center;">Detail</th>
                 <th style="border-bottom:1px solid; width:5%; font-family:Calibri; font-weight:bold; font-size:12px; text-align: center;">Ref No.</th>
                 <th style="border-bottom:1px solid; width:10%; font-family:Calibri; font-weight:bold; font-size:12px; text-align: center;">Debit</th>
                 <th style="border-bottom:1px solid; width:10%; font-family:Calibri; font-weight:bold; font-size:12px; text-align: center;">Credit</th>
                 <th style="border-bottom:1px solid; width:10%; font-family:Calibri; font-weight:bold; font-size:12px; text-align: center;">Balance</th>
                </tr>
              </thead>
              <tbody>
              <?php
              foreach($SubLedgerReport as $SubLedgerReportRecord) {
            
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
//              $CompanyName = $SubLedgerReportRecord['CompanyName'];
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
	      
	      /*
	      if($DebitIncrease == 1)
	      {
		  $dBalance += $dTransBalance;
	      }
              else
	      { 
		  $dBalance -= $dTransBalance;
	      }
              */
              
              $dTotal_Debit += $dDebit;
              $dTotal_Credit += $dCredit;

              $sDebit = number_format($dDebit, 0);
              $sCredit = number_format($dCredit, 0);
              
              if ($dDebit == 0) $sDebit = '';
              if ($dCredit == 0) $sCredit = '';
              
	      $dClosingBalance = 0;
	      /*
	      if($DebitIncrease == '1') 
	      { 
		  $dClosingBalance = $dTotal_Debit - $dTotal_Credit; 
	      }
              else 
	      {
		  $dClosingBalance = $dTotal_Credit - $dTotal_Debit;			
	      }
	      */
	      ?>
              <tr style="font-size:12px; height: 30px;">
                <td style="text-align: left; padding-left:10px; font-weight: 600"><?php echo $sTransactionDate; ?></td>
                <td style="text-align: left; padding-left:10px;"><?php echo "<b>".$Detail . "</b>"; ?></td> 
                <td style=" text-align: center; font-weight: 600"><?php echo '<a href="javascript:void(0)" onclick="window.open(\''.base_url().'GeneralJournal/ViewVoucher/'.$GeneralJournalId.'\',\'popUpWindow\',\'height=450,width=800,left=400,top=100,resizable=no,scrollbars=0,toolbar=no,menubar=no,location=no,directories=no, status=yes\');">'.$Reference.'</a>'; ?></td>
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
              <tr style="font-size:12px; height: 30px;">
                <td colspan="3" style=" font-weight:700; text-align: right;">Total:</td>
                <td style="font-weight: 700; text-align: center;"><?php echo number_format($dTotal_Debit,0); ?></td>
                <td style="font-weight: 700; text-align: center;"><?php echo number_format($dTotal_Credit,0); ?></td>
                <td style="font-weight: 700; text-align: center;"><?php echo number_format($dBalance,0); ?></td>
              </tr>
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
              <tr>
                  <td colspan="7">&nbsp;</td>
               </tr>
            </table>            
         </div>   
       </div>
    </div>
  </body>
</html>