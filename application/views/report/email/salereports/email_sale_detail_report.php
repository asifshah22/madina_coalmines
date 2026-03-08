<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Sales Detail Report</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport"> 

        <!-- jQuery 2.2.3 -->
  <script src="<?php echo base_url(); ?>plugins/jQuery/jquery-2.2.3.min.js"></script>
  <!-- Bootstrap 3.3.6 -->
  <script src="<?php echo base_url(); ?>bootstrap/js/bootstrap.min.js"></script>
  <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>bootstrap/css/bootstrap.min.css">

  <link rel="stylesheet" href="<?php echo base_url(); ?>plugins/select2/select2.min.css">

  <link rel="stylesheet" href="<?php echo base_url(); ?>lib/css/skins/skin-blue.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>lib/css/font-awesome/font-awesome.min.css">
</head>
<body class="hold-transition skin-blue sidebar-mini">
    <div class="wrapper">
      <div class="box box-info">
        <div class="col-md-12 col-xs-12">               
          <center>
           <div class="box-header">
	    <h2 style="color:black; font-family:Georgia; font-weight:600;" class="box-title">Sunny Paper Mills</h2>  
            <h3 style="color:green;" class="box-title">Sale Detail Report</h3>
	    <hr style="color: #003eff; border-width: 1px; border-style: inset; display: block;">
	    <div style="padding-top:-0.1em; font-size:12px; font-weight:600; text-align:left;">Period of: <?php echo date('M d, Y', strtotime($this->input->get('StartDate'))).' To '. date('M d, Y', strtotime($this->input->get('EndDate'))); ?>
      </div>
           </div>
          </center>
	     <div style="height:30px;"></div>
            <div class="table-head-only" style="overflow-x: scroll;">
                <table class="table table-bordered" style="width: 100%" id="table-basic">
              <thead>
                <tr style="background:#3c8dbc; font-size:13px; color:#FFFFFF;">
                 <th style="text-align:center;">S.#</th>
                 <th style="text-align:center;">Date</th>
            		 <th style="text-align:center;">Invoice No</th>
                 <th style="text-align:center;">Customer</th>
            		 <th style="text-align:center;">Product</th>
            		 <th style="text-align:center;">Reel Size</th>
            		 <th style="text-align:center;">Weight (KG)</th>
                 <th style="text-align:center;">Quantity</th>
	         <th style="text-align:center;">Rate</th>
                 <th style="text-align:center;">Amount</th>
                 <th style="text-align:center;">GST Amount</th>
                 <th style="text-align:center;">Net Amount</th>
                </tr>
              </thead>
              <tbody>
              <?php
	      $TotalWeight = 0;
	      $TotalQuantity = 0;
	      $TotalAmount = 0;
	      $TotalGSTAmount = 0;
	      $TotalNetAmount = 0;
	      
	      $GrandTotalWeight = 0;
	      $GrandTotalQuantity = 0;
	      $GrandAmount = 0;
	      $GrandGSTAmount = 0;
	      $GrandNetAmount = 0;
		
	      $SNo=1;
              if(isset($SaleDetail)) {
              foreach($SaleDetail as $row) {
              ?>
		            <tr style="font-size:12px;">
                 <td style="text-align:center;"><?php echo $SNo;?></td>
                 <td style="text-align:left;"><?php echo date('M d, Y', strtotime($row['InvoiceDate'])); ?></td>
		 <td style="text-align:left;"><?php echo $row['InvoiceNumber']; ?></td>
                 <td style="text-align:left;"><?php echo $row['CustomerName']; ?></td>
                 <td style="text-align:left;"><?php echo $row['ProductName']; ?></td>
		 <td style="text-align:right;"><?php echo $row['ReelSize']; ?></td>
		 <td style="text-align:right;"><?php echo number_format($row['Weight'],0); ?></td>
                 <td style="text-align:right;"><?php echo $row['SupplyQuantity']; ?></td>
		 <td style="text-align:right;"><?php echo $row['Rate']; ?></td>
                 <td style="text-align:right;"><?php echo number_format($row['Amount'],0); ?></td>
		 <td style="text-align:right;"><?php echo number_format($row['GSTAmount'],0); ?></td>
		 <td style="text-align:right;"><?php echo number_format($row['NetAmount'],0); ?></td>
                </tr>
                <?php
                $TotalWeight += $row['Weight'];
		$TotalQuantity += $row['SupplyQuantity'];
                $TotalAmount += $row['Amount'];
                $TotalGSTAmount += $row['GSTAmount'];
		$TotalNetAmount += $row['NetAmount'];
                $SNo++; }                   
                }
		?>
		<?php	
		$GrandTotalWeight += $TotalWeight;
		$GrandTotalQuantity += $TotalQuantity;	
		$GrandAmount += $TotalAmount;
		$GrandGSTAmount += $TotalGSTAmount;
		$GrandNetAmount += $TotalNetAmount;
	      
		$TotalWeight = 0;
		$TotalQuantity = 0;
		$TotalAmount = 0;
		$TotalGSTAmount = 0;
		$TotalNetAmount = 0;
		            ?>
    <tr style="font-size:12px;  font-weight:600;">
		 <td colspan="11" style="text-align:right;"></td>
    </tr>
		<tr style="font-size:12px; font-weight:600;">
		 <td colspan="6" style="text-align:right;">Grand Total:</td>
		 <td style="text-align:right;"><?php echo number_format($GrandTotalWeight,0); ?></td>
                 <td style="text-align:right;"><?php echo $GrandTotalQuantity; ?></td>
		 <td style="text-align:right;"></td>
                 <td style="text-align:right;"><?php echo number_format($GrandAmount,0); ?></td>
		 <td style="text-align:right;"><?php echo number_format($GrandGSTAmount,0); ?></td>
		 <td style="text-align:right;"><?php echo number_format($GrandNetAmount,0); ?></td>
                </tr>
              </tbody>
              </table>
            </div>
         </div>   
       </div>
    </div>
  </body>
</html>