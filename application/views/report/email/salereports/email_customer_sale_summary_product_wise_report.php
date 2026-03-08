<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Customer Sale Summary Product Wise</title>
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
      <div class="box box-info">
        <div class="col-md-12 col-xs-12">               
          <center>
           <div class="box-header">
	    <h2 style="color:black; font-family:Georgia; font-weight:600;" class="box-title">Sunny Paper Mills
      </h2>
	    <h3 style="color:green; margin-right: 8%" class="box-title">Customer Sale Summary Product Wise</h3>
	    <hr style="color: #003eff; border-width: 1px; border-style: inset; display: block;">
	    <div style="padding-top:-0.1em; font-size:12px; font-weight:600; text-align:left;">Period of: <?php echo date('M d, Y', strtotime($this->input->get('StartDate'))).' To '. date('M d, Y', strtotime($this->input->get('EndDate'))); ?></div>
           </div>
          </center>
	    <div style="height:30px;"></div>
              <div class="table-head-only" style="overflow-x: scroll;">
                <table class="table table-bordered" style="width: 100%" id="table-basic">
              <thead>
                <tr style="background:#3c8dbc; font-size:13px; color:#FFFFFF;">
                 <th style="text-align:center;">S.#</th>
		 <th style="text-align:center;">Product</th>
                 <th style="text-align:center;">Weight</th>
                 <th style="text-align:center;">Net Amount</th>
                </tr>
              </thead>
              <tbody>
              <?php
	      $TotalWeight = 0;
	      $TotalDeductionRawMaterial = 0;
	      $TotalAmount = 0;
	      $TotalFEDAmount = 0;
	      $TotalGSTAmount = 0;
	      $TotalNetAmount = 0;
	      
	      $GrandTotalWeight = 0;
	      $GrandDeductionRawMaterial = 0;
	      $GrandAmount = 0;
	      $GrandGSTAmount = 0;
	      $GrandFEDAmount = 0;
	      $GrandNetAmount = 0;
		
	      $SNo=1;
              if(isset($CustomerProductSaleSummary)) {
              foreach($CustomerProductSaleSummary as $CustomerName => $CustomerRecord) {
              ?>
		<tr>
		 <td colspan="4" style="text-align:left; color:#2489c5;"><h4>Customer: <?php echo $CustomerName; ?></h4></td>
		 <?php
		 if(!empty($CustomerRecord) ) {
                 foreach($CustomerRecord as $row) {
		 ?>
                </tr>
                <tr style="font-size:12px;">
                 <td style="text-align:center;"><?php echo $SNo;?></td>
                 <!-- <td style="text-align:left;"><?php // echo date('M d, Y', strtotime($row['PurchaseDate'])); ?></td> -->
                 <td style="text-align:left;"><?php echo $row['ProductName']; ?></td>
                 <td style="text-align:right;"><?php echo $row['Weight']; ?></td>
		 <td style="text-align:right;"><?php echo number_format($row['NetAmount'],2); ?></td>
                </tr>
                <?php
                $TotalWeight += $row['Weight'];
                $TotalAmount += $row['Amount'];
		$TotalNetAmount += $row['NetAmount'];
                $SNo++; }                   
                }
		?>
		<tr style="font-size:12px;  font-weight:600;">
		 <td colspan="2" style="text-align:right;">Customer Total:</td>
                 <td style="text-align:right;"><?php echo $TotalWeight; ?></td>
                 <td style="text-align:right;"><?php echo number_format($TotalNetAmount,2); ?></td>
                </tr>
		<?php	
		$GrandTotalWeight += $TotalWeight;
		$GrandAmount += $TotalAmount;
		$GrandNetAmount += $TotalNetAmount;
	      
		$TotalWeight = 0;
		$TotalAmount = 0;
		$TotalNetAmount = 0;
		  }
                }
                ?>
                <tr style="font-size:12px;  font-weight:600;">
		 <td colspan="5" style="text-align:right;"></td>
                </tr>
		<tr style="font-size:12px;  font-weight:600;">
		 <td colspan="2" style="text-align:right;">Grand Total:</td>
                 <td style="text-align:right;"><?php echo $GrandTotalWeight; ?></td>
                 <td style="text-align:right;"><?php echo number_format($GrandNetAmount,2); ?></td>
                </tr>
              </tbody>
              </table>
            </div>
         </div>   
       </div>
    </div>
  </body>
</html>