<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Customer Balance Summary Report</title>
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
          <center>
            <div class="box-header">
              <h3 style="color:#000000;" class="box-title">Customer Balance Summary Report</h3>
            </div>
          </center>
            <table class="table table-bordered">
              <thead>
                <tr style="background:#3c8dbc; font-size:13px; color:#FFFFFF;">
                 <th>S.#</th>
		 <th>Customer Name</th>
                 <th style="width:10%;">Sales Order</th>
		 <th style="width:10%;">Cancel Order</th>
		 <th style="width:10%;">Net Order</th>
		 <th style="width:10%;">Invoice Amount</th>
		 <th style="width:12%;">N.Order - I.Amount</th>
                 <th style="width:10%;">Ledger Debit</th>
                 <th style="width:10%;">Ledger Credit</th>
		 <th style="width:12%;">I.Amount - L.Credit</th>
                 <th style="width:12%;">I.Amount - L.Debit</th>
		 <th style="width:25%;">L.Debit - L.Credit</th>		
		 <th style="width:25%;">COGS</th>
		 <th style="width:25%;">C. Advances</th>
		 <th style="width:25%;">C. Expenses</th>
		 </tr>
              </thead>
              <tbody>
              <?php	   
	      //echo '<pre>';
	     // print_r($CustomerGeneralLedgerCOGS);
	      
	      $SNo = 1;
	      $COGSAmount = 0;
	      $CDRAmount = 0;
	      $InvoiceAmount = 0;
	      $AdvancesAmount = 0;
	      $TotalInvoiceAmount = 0;
	      $InvoicePreviousAmount = 0;
	      $TotalInvoicePreviousAmount = 0;
	      $DebitAmount = 0;
	      $DebitAmountWithCOGS = 0;
	      $CreditAmountWithCDR = 0;
	      $TotalDebitAmount = 0;
	      $CreditAmount = 0;
	      $TotalCreditAmount = 0;
	      $BalanceFromInvoice = 0;
	      $TotalBalanceFromInvoice = 0;
	      $PreviousDebitAmount = 0;
	      $TotalPreviousDebitAmount = 0;
	      $BalanceFromLedger = 0;
	      $TotalBalanceFromLedger = 0;
	      $InvoiceLedgerAmtDifference = 0;
	      $TotalInvoiceLedgerAmtDifference = 0;
	      $RemaingingAmount = 0;
	      $TotalRemaingingAmount = 0;
	      $TInvoiceLedgerAmtDifference = 0;
	      
	      $SalesOrderAmount = 0;
	      $TotalSalesOrderAmount = 0;
	      
	      $CancelAmount = 0;
	      $TotalCancelAmount = 0;
	      $TotalNetAmount = 0;
	      $RemainingOrder = 0;
	      $TotalRemainingOrder = 0;
	      $ExpensesAmount = 0;
	      $NetLedger = 0;
	      $TotalNetLedger = 0;
	      $TotalCOGSAmount = 0;
	      $TotalAdvancesAmount = 0;
	      $TotalExpensesAmount = 0;
	      
	      if(isset($CustomerRecord)) {
	      foreach($CustomerRecord as $CustomerValue) 
	      {
		$CustomerName =  $CustomerValue['CustomerName'];
		$CustomerId = $CustomerValue["CustomerId"];
		
		// Getting Customer Sales Order Amount
	        if(isset($CustomerSalesOrder)) 
		{
                  foreach($CustomerSalesOrder as $CustomerSalesOrderAmount) 
		  {
		    if( $CustomerSalesOrderAmount['CustomerId'] == $CustomerId)
		    {
	              $SalesOrderAmount =  $CustomerSalesOrderAmount['OrderAmount'];
		    }
		  } 
		}
		
		// Getting Customer Cancel Order Amount
	        if(isset($CustomerCancelOrder)) 
		{
                  foreach($CustomerCancelOrder as $CustomerCancelOrderAmount) 
		  {
		    if( $CustomerCancelOrderAmount['CustomerId'] == $CustomerId)
		    {
	              $CancelAmount =  $CustomerCancelOrderAmount['CancelAmount'];
		    }
		  } 
		}
		
		// Getting Customer Invoice Amount
	        if(isset($CustomerInvoiceLedger)) 
		{
                  foreach($CustomerInvoiceLedger as $CustomerInvoice) 
		  {		    
		    if( $CustomerInvoice['CustomerId'] == $CustomerId)
		    {
	              $InvoiceAmount =  $CustomerInvoice['InvoiceAmount'];
		    }
		  } 
		}
	
		// Getting Customer Ledger Debit Amount
	        if(isset($CustomerGeneralLedgerDebit))
		{
                  foreach($CustomerGeneralLedgerDebit as $CustomerLedgerDebitAmount) 
		  {
		    if( $CustomerLedgerDebitAmount['CustomerId'] == $CustomerId)
		    {
	              $DebitAmount =  $CustomerLedgerDebitAmount['DebitAmount'];
		    }
		  } 
		}
		
		
		// Getting Customer Advances Amount
	        if(isset($CustomerAdvances))
		{
                  foreach($CustomerAdvances as $CustomerAdvancesAmount) 
		  {
		    if( $CustomerAdvancesAmount['CustomerId'] == $CustomerId)
		    {
	              $AdvancesAmount =  $CustomerAdvancesAmount['DebitAmount'];
		    }
		  } 
		}
		
		
		// Getting Customer Expenses Amount
	        if(isset($CustomerExpenses))
		{
                  foreach($CustomerExpenses as $CustomerExpensesAmount) 
		  {
		    if( $CustomerExpensesAmount['CustomerId'] == $CustomerId)
		    {
	              $ExpensesAmount =  $CustomerExpensesAmount['ExpensesAmount'];
		    }
		  } 
		}
		
		
		 
		 // Getting Customer Ledger Credit Amount
		 if(!empty($CustomerGeneralLedgerCredit)) 
		 {
		   foreach($CustomerGeneralLedgerCredit as $CustomerLedgerCreditAmount) 
		   {
		     if($CustomerLedgerCreditAmount['CustomerId'] == $CustomerId)
		     {		  
		       $CreditAmount = $CustomerLedgerCreditAmount['CreditAmount'];
		     }                      
		   } 
		 }   

		 
		// Getting Customer Cost of Goods Sold Amount
	         if(!empty($CustomerGeneralLedgerCOGS))
		{
                  foreach($CustomerGeneralLedgerCOGS as $CustomerCOGSAmount) 
		  {		    
		    if( $CustomerCOGSAmount['CustomerId'] == $CustomerId)
		    {
			$COGSAmount =  $CustomerCOGSAmount['COGSAmount'];
		    }
		  }
		}
		 
		$RemaingingAmount  = $InvoiceAmount - $CreditAmount;
		$InvoiceLedgerAmtDifference = $InvoiceAmount - $DebitAmount;
		$NetAmount = $SalesOrderAmount - $CancelAmount;
		$RemainingOrder = $NetAmount - $InvoiceAmount;
		$NetLedger = $DebitAmount - $CreditAmount;		
		
	 	$TotalRemainingOrder += $RemainingOrder;
		$TotalSalesOrderAmount += $SalesOrderAmount;
	        $TotalCancelAmount += $CancelAmount;    
		     
		$TotalInvoiceAmount += $InvoiceAmount;
		
		$TotalDebitAmount += $DebitAmount;
		$TotalCreditAmount += $CreditAmount;
		$TotalRemaingingAmount += $RemaingingAmount;
		$TInvoiceLedgerAmtDifference += $InvoiceLedgerAmtDifference;
		$TotalNetAmount += $NetAmount;
		$TotalNetLedger += $NetLedger;
		$TotalCOGSAmount += $COGSAmount;
		$TotalAdvancesAmount += $AdvancesAmount;
		$TotalExpensesAmount += $ExpensesAmount;
        	?>
                 <tr style="font-size:12px;">
                 <td><?php echo $SNo;?></td>
		 <td><?php echo $CustomerName; ?></td>
                 <td style="text-align:right;"><?php echo number_format($SalesOrderAmount,2); ?></td>
		 <td style="text-align:right;"><?php echo number_format($CancelAmount,2); ?></td>
		 <td style="text-align:right;"><?php echo number_format($NetAmount,2); ?></td>
		 <td style="text-align:right;"><?php echo number_format($InvoiceAmount,2); ?></td>
	         <td style="text-align:right;"><?php echo number_format($RemainingOrder,2); ?></td>
                 <td style="text-align:right;"><?php echo number_format($DebitAmount,2); ?></td>
                 <td style="text-align:right;"><?php echo number_format($CreditAmount,2); ?></td>
		 <td style="text-align:right;"><?php echo number_format($RemaingingAmount,2); ?></td>
		 <td style="text-align:right;"><?php echo number_format($InvoiceLedgerAmtDifference,2); ?></td>
		 <td style="text-align:right;"><?php echo number_format($NetLedger,2); ?></td>
		 <td style="text-align:right;"><?php echo number_format($COGSAmount,2); ?></td>
		 <td style="text-align:right;"><?php echo number_format($AdvancesAmount,2); ?></td>
		 <td style="text-align:right;"><?php echo number_format($ExpensesAmount,2); ?></td>		 
                </tr>          
	       <?php
	
	      
	      $CancelAmount = 0;
	      $RemainingOrder = 0;
	      $NetAmount = 0;
              $SalesOrderAmount = 0;
	      $DebitAmountWithCOGS = 0;
	      $InvoiceAmount = 0;
	      $DebitAmount= 0;
	      $CreditAmount= 0;
	      $CDRAmount = 0;
	      $RemaingingAmount = 0;
	      $NetLedger = 0;
	      $COGSAmount = 0;
	      $AdvancesAmount = 0;
	      $ExpensesAmount = 0;
	      $InvoiceLedgerAmtDifference = 0;
	      $SNo++;
	      } }   ?>
               
                <tr style="font-size:12px;">
                <td style="font-weight:600; text-align:left;"></td>
                <td style="font-weight:600; text-align:left;"></td>
                <td style="font-weight:600; text-align:right;"><?php  echo number_format($TotalSalesOrderAmount,2); ?></td>
		<td style="font-weight:600; text-align:right;"><?php echo number_format($TotalCancelAmount,2); ?></td>
		<td style="font-weight:600; text-align:right;"><?php echo number_format($TotalNetAmount,2); ?></td>
		<td style="font-weight:600; text-align:right;"><?php echo number_format($TotalInvoiceAmount,2); ?></td>
		<td style="font-weight:600; text-align:right;"><?php  echo number_format($TotalRemainingOrder,2); ?></td>
		<td style="font-weight:600; text-align:right;"><?php echo number_format($TotalDebitAmount,2); ?></td>
                <td style="font-weight:600; text-align:right;"><?php echo number_format($TotalCreditAmount,2); ?></td>
		<td style="font-weight:600; text-align:right;"><?php echo number_format($TotalRemaingingAmount,2); ?></td>
		<td style="font-weight:600; text-align:right;"><?php echo number_format($TInvoiceLedgerAmtDifference,2); ?></td>
		<td style="font-weight:600; text-align:right;"><?php echo number_format($TotalNetLedger,2); ?></td>
		<td style="font-weight:600; text-align:right;"><?php echo number_format($TotalCOGSAmount,2); ?></td>		
		<td style="font-weight:600; text-align:right;"><?php echo number_format($TotalAdvancesAmount,2); ?></td>
		<td style="font-weight:600; text-align:right;"><?php echo number_format($TotalExpensesAmount,2); ?></td>		
                </tr>
              </tbody>
              </table>
         </div>   
       </div>
    </div>
  </body>
</html>