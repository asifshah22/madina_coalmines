<?php

header("Content-type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename = Sales Detail Report.xls");
?>

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
            <h2 style="color:black; font-family:Georgia; font-weight:600;text-align: center; margin-top: 10px;" class="box-title">Hilife Electronics</h2>
          </div>
    <br><br>
      <h3 style="color:green;text-align: center;">Sales Detail</h3>
      
      <div style="padding-top:-0.1em; font-size:12px; font-weight:600; text-align:center;">Period of <?php echo date('M d, Y', strtotime($this->input->get('StartDate'))).' &nbsp; - &nbsp;  '. date('M d, Y', strtotime($this->input->get('EndDate'))); ?>
      </div>
      <hr style="color: #003eff; border-width: 1px; border-style: inset; display: block;">
       <div style="height:30px;"></div>
            <div class="table-head-only" style="overflow-x: scroll;">
                <table class="table table-bordered" style="width: 100%" id="table-basic">
              <thead>
                <tr style="background:#205081; font-size:0.75em; color:#FFFFFF;" class="">
            		  <th style="">S.#</th>
                  <th style="text-align:center;">Date</th>
                  <th style="text-align:left;">Product Name</th>
                  <th style="text-align:left;">Colour</th>
                  <th style="text-align:left;">Location</th>
                  <th style="text-align:left;">Brand</th>
                  <th style="text-align:left;">Product Group</th>
                  <th style="text-align:left;">Category</th>
                  <th style="text-align:left;">Customer Name</th>
                  <th style="text-align:left;">Reference By</th>
                  <th style="text-align:left;">Walk in Cust: Name</th>
                  <th style="text-align:left;">Walk in Cust: Mobile No.</th>
                  <th style="text-align:center;">Sale Type</th>
                  <th style="text-align:center;">Rate</th>
                  <th style="text-align:center;">Quantity</th>
                  <th style="text-align:center;">Amount</th>
                  <th style="text-align:center;">Discount</th>
                  <th style="text-align:center;">Tax Amount</th>
                  <th style="text-align:center;">Net Amount</th>
                </tr>
              </thead>
              <tbody>
                <?php 
                $SNo = 0;
                $Amount = 0;
                $NetQuantity = 0;
                $DiscountAmount = 0;
                $TaxAmount = 0;
                $NetAmount = 0;
                foreach ($SaleDetail as $AllSalesRecord) {
                $SNo++;
                  $SaleType = "";
                  if($AllSalesRecord['SaleType'] == "1"){
                    $SaleType = "On Cash";
                  }
                  if($AllSalesRecord['SaleType'] == "2"){
                    $SaleType = "On Credit";
                  }
                  if($AllSalesRecord['SaleType'] == "3"){
                    $SaleType = "Online";
                  }

                  ?>
                <tr class="gradeU" style="background-color: #fFffff;font-size:0.75em;">
                  <td style="text-align:center;"><?php echo $SNo; // $AllSalesRecord['SaleId']; ?></td>
                  <td style="text-align:center;"><?php echo date('M d, Y', strtotime($AllSalesRecord['SaleDate'])); ?></td>
                  <td style="text-align:left;"><?php echo ($AllSalesRecord['ProductName']); ?></td>
                  <td style="text-align:left;"><?php echo ($AllSalesRecord['ColourName']); ?></td>
                  <td style="text-align:left;"><?php echo ($AllSalesRecord['LocationName']); ?></td>
                  <td style="text-align:left;"><?php echo ($AllSalesRecord['BrandName']); ?></td>
                  <td style="text-align:left;"><?php echo ($AllSalesRecord['ProductGroupName']); ?></td>
                  <td style="text-align:left;"><?php echo ($AllSalesRecord['CategoryName']); ?></td>
                  <td style="text-align:left;"><?php echo ($AllSalesRecord['CustomerName']); ?></td>
                  <td style="text-align:left;"><?php echo ($AllSalesRecord['FullName']); ?></td>
                  <td style="text-align:left;"><?php echo ($AllSalesRecord['WalkinCustomer']); ?></td>
                  <td style="text-align:left;"><?php echo ($AllSalesRecord['MobileNumber']); ?></td>
                  <td style="text-align:left;"><?php echo $SaleType; ?></td>
                  <td style="text-align:center;"><?php echo number_format($AllSalesRecord['Rate'],2); ?></td>
                  <td style="text-align:center;"><?php echo number_format($AllSalesRecord['Quantity'],2); ?></td>
                  <td style="text-align:center;"><?php echo number_format($AllSalesRecord['Amount'],2); ?></td>
                  <td style="text-align:center;"><?php echo number_format($AllSalesRecord['DiscountAmount'],2); ?></td>
                  <td style="text-align:center;"><?php echo number_format($AllSalesRecord['TaxAmount'],2); ?></td>
                  <td style="text-align:center;"><?php echo number_format($AllSalesRecord['NetAmount'],2); ?></td>
                </tr>
                <?php
                  $NetQuantity += $AllSalesRecord['Quantity'];
                  $Amount += $AllSalesRecord['Amount'];
                  $DiscountAmount += $AllSalesRecord['DiscountAmount'];
                  $TaxAmount += $AllSalesRecord['TaxAmount'];
                  $NetAmount += $AllSalesRecord['NetAmount'];
              }
                ?>
                  <tr>             
                    <td colspan="14" style="text-align:right; font-weight: 700; font-size: 13px;">Total:</td>
                    <td style="text-align:right; font-weight:700;"><?php echo number_format($NetQuantity,2); ?></td>
                    <td style="text-align:right; font-weight:700;"><?php echo number_format($Amount,2); ?></td>
                    <td style="text-align:right; font-weight:700;"><?php echo number_format($DiscountAmount,2); ?></td>
                    <td style="text-align:right; font-weight:700;"><?php echo number_format($TaxAmount,2); ?></td>
                    <td style="text-align:right; font-weight:700;"><?php echo number_format($NetAmount,2); ?></td>
                  </tr>
              </tbody>
	    </table>
    </center>
          </div>
        </div>
        <?php
//      }
      ?>
</body>
</html>