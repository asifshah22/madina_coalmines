<?php
header("Content-type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename = Purchase Return Report.xls");
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Purchase Return Report</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport"> 
          <!-- jQuery 2.2.3 -->
  <script src="<?php echo base_url(); ?>plugins/jQuery/jquery-2.2.3.min.js"></script>
  <!-- Bootstrap 3.3.6 -->
  <script src="<?php echo base_url(); ?>bootstrap/js/bootstrap.min.js"></script>
  <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>bootstrap/css/bootstrap.min.css">
  <!-- select2 --->
  <link rel="stylesheet" href="<?php echo base_url(); ?>plugins/select2/select2.min.css">  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>lib/css/font-awesome/font-awesome.min.css">
</head>
<body class="hold-transition skin-blue sidebar-mini">
    <div class="wrapper">
      <div class="box box-info">
        <div class="col-md-12 col-xs-12">
            <h2 style="color:black; font-family:Georgia; font-weight:600;text-align: center; margin-top: 10px;" class="box-title">Hilife Electronics</h2>
          </div>
    <br><br>
          <h3 style="color:green;text-align: center;">Purchase Return</h3>
          
          <div style="padding-top:-0.1em; font-size:12px; font-weight:600; text-align:center;">Period of <?php echo date('M d, Y', strtotime($this->input->get('StartDate'))).' &nbsp; - &nbsp;  '. date('M d, Y', strtotime($this->input->get('EndDate'))); ?>
          </div>
                <hr style="color: #003eff; border-width: 1px; border-style: inset; display: block;">
          <br>
<div style="height:30px;"></div>
  <table class="table table-bordered">
    <thead>
  <?php
//      if($AllPurchaseReturnReport) {
  ?>
  <tr style="background:#205081; color:#fff;">
  <th style="padding:5px;">S. #</th>
  <th style="padding:5px;">Date</th>
  <th style="text-align:left; padding:5px;">Product Name</th>
  <th style="text-align:left; padding:5px;">Brand</th>
  <th style="text-align:left; padding:5px;">Product Group</th>
  <th style="text-align:left; padding:5px;">Category</th>
  <th style="text-align:left; padding:5px;">Colour</th>
  <th style="text-align:left; padding:5px;">Vendor Name</th>
  <th style="text-align:left; padding:5px;">Purchase Type</th>
  <th style="text-align:center; padding:5px;">Rate</th>
  <th style="text-align:center; padding:5px;">Quantity</th>
  <th style="text-align:center; padding:5px;">Amount</th>
  <th style="text-align:center; padding:5px;">Discount</th>
  <th style="text-align:center; padding:5px;">Net Amount</th>
        </tr>
    </thead>
    <tbody>
    <?php
    $TotalPurchasesQuantity = 0;
    $TotalAmount = 0;
   $SNo = 1;
  foreach($AllPurchaseReturnReport as $AllPurchasesRecord)
  { 
    $PurchaseReturnType = "";
    if($AllPurchasesRecord['PurchaseReturnType'] == "1"){
      $PurchaseReturnType = 'On Cash';
    }
    if($AllPurchasesRecord['PurchaseReturnType'] == "2"){
      $PurchaseReturnType = 'On Credit';
    }
    if($AllPurchasesRecord['PurchaseReturnType'] == "3"){
      $PurchaseReturnType = 'Online';
    }

    ?>
  <tr class="gradeU" style="background-color: #fFffff"> 
  <td style="text-align:center;"><?php echo $SNo; ?></td>
  <td style="text-align:center;"><?php echo date('M d, Y', strtotime($AllPurchasesRecord['PurchaseReturnDate'])); ?></td>
  <td style="text-align:left;"><?php echo ($AllPurchasesRecord['ProductName']); ?></td>
  <td style="text-align:left;"><?php echo ($AllPurchasesRecord['BrandName']); ?></td>
  <td style="text-align:left;"><?php echo ($AllPurchasesRecord['ProductGroupName']); ?></td>
  <td style="text-align:left;"><?php echo ($AllPurchasesRecord['CategoryName']); ?></td>
  <td style="text-align:left;"><?php echo ($AllPurchasesRecord['ColourName']); ?></td>
  <td style="text-align:left;"><?php echo ($AllPurchasesRecord['VendorName']); ?></td>
  <td style="text-align:left;"><?php echo $PurchaseReturnType; ?></td>
  <td style="text-align:right;"><?php echo number_format($AllPurchasesRecord['Rate'],2); ?></td>
  <td style="text-align:right;"><?php echo ($AllPurchasesRecord['Quantity']); ?></td>
  <td style="text-align:right;"><?php echo ($AllPurchasesRecord['Amount']); ?></td>
  <td style="text-align:right;"><?php echo ($AllPurchasesRecord['DiscountAmount']); ?></td>
  <td style="text-align:right;"><?php echo number_format($AllPurchasesRecord['NetAmount'],2); ?></td>
        </tr>
  <?php
  $SNo++;
  $TotalPurchasesQuantity += $AllPurchasesRecord['Quantity'];
  $TotalAmount += $AllPurchasesRecord['NetAmount'];
  } 
  
  ?>
  <tr>             
  <td colspan="10" style="text-align:right; font-weight: 700; font-size: 13px;">Total:</td>
  <td style="text-align:right; font-weight:700;"><?php echo number_format($TotalPurchasesQuantity,2); ?></td>
  <td></td>
  <td></td>
  <td style="text-align:right; font-weight:700;"><?php echo number_format($TotalAmount,2); ?></td>
  </tr>
   </tbody>
   </table>
  </div>
</body>
</html>