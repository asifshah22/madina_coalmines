<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Payment Against Sale Summary Report</title>
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
              <h3 style="color:#000000;" class="box-title">Invoice Payment Detail Report</h3>
            </div>
          </center>
            <table class="table table-bordered">
              <thead>
                <tr style="background:#3c8dbc; font-size:13px; color:#FFFFFF;">
                 <th>S.#</th>
		 <th>Company</th>
		 <th>Receipt Date</th>
		 <th>Description</th>
		 <th>Cheque No.</th>
		 <th>Invoice Amount</th>
		 <th>Cheque Amount</th>
		 <th>Sales Tax</th>
		 <th>W.H Tax</th>
		 <th>Stamp Duty</th>
		 </tr>
	      </thead>
	      <tbody>
		<?php
		$InvoiceAmount = 0;
		$TotalStampDuty = 0;
		$TotalInvoiceAmount = 0;
		$TotalChequeAmount = 0;
		$TotalSalesTax = 0;
		$TotalWithholdingTax = 0;
		$TotalStampDuty = 0;
		$SNo = 1;

		if(isset($PaymentDetail)) {
		foreach($PaymentDetail as $PaymentDetailRecord)
		{
	
		 $InvoiceAmount = $PaymentDetailRecord['ChequeAmount'] + $PaymentDetailRecord['SalesTax'] + $PaymentDetailRecord['WithholdingTax'] + $PaymentDetailRecord['StampDuty'];
        	 ?>
                 <tr style="font-size:12px;">
                 <td><?php echo $SNo;?></td>
		 <td style="text-align:left;"><?php echo $PaymentDetailRecord['CompanyName']; ?></td>
		 <td style="text-align:left;"><?php echo date('M d, Y', strtotime($PaymentDetailRecord['ReceiptDate'])); ?></td>
		 <td style="text-align:left;"><?php echo $PaymentDetailRecord['CustomerName']; ?></td>
		 <td style="text-align:left;"><?php echo $PaymentDetailRecord['ChequeNumber']; ?></td>
		 <td style="text-align:right;"><?php echo number_format($InvoiceAmount,2); ?></td>
		 <td style="text-align:right;"><?php echo number_format($PaymentDetailRecord['ChequeAmount'],2); ?></td>
		 <td style="text-align:right;"><?php echo number_format($PaymentDetailRecord['SalesTax'],2); ?></td>
		 <td style="text-align:right;"><?php echo number_format($PaymentDetailRecord['WithholdingTax'],2); ?></td>
		 <td style="text-align:right;"><?php echo number_format($PaymentDetailRecord['StampDuty'],2); ?></td>
                </tr>
	        <?php
		$SNo++;
		$TotalInvoiceAmount += $InvoiceAmount;
		$TotalChequeAmount += $PaymentDetailRecord['ChequeAmount'];
		$TotalSalesTax += $PaymentDetailRecord['SalesTax'];
		$TotalWithholdingTax += $PaymentDetailRecord['WithholdingTax'];
		$TotalStampDuty += $PaymentDetailRecord['StampDuty'];
		} } ?>
                <tr style="font-size:12px;">
                <td></td>
		<td></td>
                <td></td>
		<td></td>
		<td></td>
		<td style="font-weight:600; text-align:right;"><?php echo number_format($TotalInvoiceAmount,2); ?></td>	
		<td style="font-weight:600; text-align:right;"><?php echo number_format($TotalChequeAmount,2); ?></td>
		<td style="font-weight:600; text-align:right;"><?php echo number_format($TotalSalesTax,2); ?></td>
		<td style="font-weight:600; text-align:right;"><?php echo number_format($TotalWithholdingTax,2); ?></td>	
		<td style="font-weight:600; text-align:right;"><?php echo number_format($TotalStampDuty,2); ?></td>
                </tr>
              </tbody>
              </table>
         </div>   
       </div>
    </div>
  </body>
</html>