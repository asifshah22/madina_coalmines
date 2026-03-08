<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Product Sale Report</title>
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
        <h3 style="color:green; margin-right: 8%;" class="box-title">Product Sale Summary Report</h3>
	      <hr style="color: #003eff; border-width: 1px; border-style: inset; display: block;">
	      <div style="padding-top:-0.1em; font-size:12px; font-weight:600; text-align:left;">Period of: <?php echo date('M d, Y', strtotime($this->input->get('StartDate'))).' To '. date('M d, Y', strtotime($this->input->get('EndDate'))); ?></div>
            </div>
          </center>
	    <div style="height:30px;"></div>
            <div class="table-head-only" style="overflow-x: scroll;">
                <table class="table table-bordered" style="width: 100%" id="table-basic">
              <thead>
                <tr style="background:#3c8dbc; font-size:14px; color:#FFFFFF;">
                 <th style="text-align:center; width:4%;">S. #</th>
                 <th style="text-align:center;">Product</th>
                 <th style="text-align:center;">Weight</th>
		 <th style="text-align:center;">Quantity</th>
		 <th style="text-align:center;">Amount</th>
		 <th style="text-align:center;">GST Amount</th>
                 <th style="text-align:center;">FED Amount</th>
		 <th style="text-align:center;">Net Amount</th>
                </tr>
              </thead>
              <tbody>
              <?php     
              $TotatalRate='';
	      $TotalWeight = 0;
              $TotalQuantity = 0;
	      $TotalAmount = 0;
	      $TotalGSTAmount = 0;
	      $TotalFEDAmount = 0;
              $TotalNetAmount = 0;
              $SNo=1;
              
              if(isset($ProductSaleSummary)) {
              
              foreach($ProductSaleSummary as $Record) 
	      {     
              ?>
              <tr style="font-size:13px;">
               <td style="text-align:center;"><?php echo $SNo; ?></td>
               <td style="text-align:left;"><?php echo $Record['ProductName']?></td>
               <td style="text-align:right;"><?php echo number_format($Record['Weight'],0); ?></td>
	       <td style="text-align:right;"><?php echo number_format($Record['Quantity'],0); ?></td>
               <td style="text-align:right;"><?php echo number_format($Record['Amount'],0); ?></td>
	       <td style="text-align:right;"><?php echo number_format($Record['GSTAmount'],0); ?></td>
	       <td style="text-align:right;"><?php echo number_format($Record['FEDAmount'],0); ?></td>
	       <td style="text-align:right;"><?php echo number_format($Record['NetAmount'],0); ?></td>
              </tr>
              <?php $SNo++;
	      $TotalWeight += $Record['Weight'];
	      $TotalQuantity += $Record['Quantity'];
	      $TotalAmount += $Record['Amount'];
	      $TotalGSTAmount += $Record['GSTAmount'];
	      $TotalFEDAmount += $Record['FEDAmount'];
	      $TotalNetAmount += $Record['NetAmount'];
	      } } ?>       
              <tr style="font-size:13px;">
	       <td style="font-weight:700; text-align:right;" colspan="2">&nbsp; Grand Total:</td>
               <td style="font-weight:700; text-align:right;">&nbsp;<?php echo number_format($TotalWeight,0); ?></td>
	       <td style="font-weight:700; text-align:right;">&nbsp;<?php echo number_format($TotalQuantity,0); ?></td>
               <td style="font-weight:700; text-align:right;"><?php echo number_format($TotalAmount,0); ?></td>
	       <td style="font-weight:700; text-align:right;"><?php echo number_format($TotalGSTAmount,0); ?></td>
	       <td style="font-weight:700; text-align:right;"><?php echo number_format($TotalFEDAmount,0); ?></td>
	       <td style="font-weight:700; text-align:right;"><?php echo number_format($TotalNetAmount,0); ?></td>
              </tr> 
              </tbody>
              </table>
            </div>
         </div>   
       </div>
    </div>
  </body>
</html>