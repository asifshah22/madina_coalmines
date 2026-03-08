<?php
header("Content-type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename = Customer Sale Detail Report.xls");
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Customer Sale Detail Report</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport"> 
  <!-- Bootstrap 3.3.6 -->
  <script src="<?php echo base_url(); ?>bootstrap/js/bootstrap.min.js"></script>
  <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>bootstrap/css/bootstrap.min.css">
        <!-- jQuery 2.2.3 -->
  <script src="<?php echo base_url(); ?>plugins/jQuery/jquery-2.2.3.min.js"></script>
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>lib/css/font-awesome/font-awesome.min.css">
</head>
<body class="hold-transition skin-blue sidebar-mini">
    <div class="wrapper">
      <div class="box box-info">
         <div class="col-md-12 col-xs-12">
            <h2 style="color:black; font-family:Georgia; font-weight:600;text-align: center; margin-top: 10px;" class="box-title">Sunny Paper Mills</h2>
          </div>
    <br><br>
      <h3 style="color:green;text-align: center;">Customer Sales Detail</h3>
      
      <div style="padding-top:-0.1em; font-size:12px; font-weight:600; text-align:center;">Period of <?php echo date('M d, Y', strtotime($this->input->get('StartDate'))).' &nbsp; - &nbsp;  '. date('M d, Y', strtotime($this->input->get('EndDate'))); ?>
      </div>
      <hr style="color: #003eff; border-width: 1px; border-style: inset; display: block;">
       <div style="height:30px;"></div>
            <div class="table-head-only" style="overflow-x: scroll;">
                <table class="table table-bordered" style="width: 100%" id="table-basic">
              <thead>
                <tr style="background:#3c8dbc; font-size:13px; color:#FFFFFF;">
                 <th style="text-align:center;">S.#</th>
                 <th style="text-align:center;">Date</th>
     <th style="text-align:center;">Invoice No</th>
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
              if(isset($CustomerSaleDetail)) {
              foreach($CustomerSaleDetail as $CustomerName => $CustomerRecord) {
              ?>
    <tr>
     <td colspan="11" style="text-align:left; color:#2489c5;"><h4>Customer: <?php echo $CustomerName; ?></h4></td>
     <?php
     if(!empty($CustomerRecord) ) {
                 foreach($CustomerRecord as $row) {
     ?>
                </tr>
                <tr style="font-size:12px;">
                 <td style="text-align:center;"><?php echo $SNo;?></td>
                 <td style="text-align:left;"><?php echo date('M d, Y', strtotime($row['InvoiceDate'])); ?></td>
     <td style="text-align:left;"><?php echo $row['InvoiceNumber']; ?></td>
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
    <tr style="font-size:12px; font-weight:600;">
     <td colspan="5" style="text-align:right;">Customer Total:</td>
     <td style="text-align:right;"><?php echo number_format($TotalWeight,0); ?></td>
                 <td style="text-align:right;"><?php echo $TotalQuantity; ?></td>
     <td style="text-align:right;"></td>
                 <td style="text-align:right;"><?php echo number_format($TotalAmount,0); ?></td> 
     <td style="text-align:right;"><?php echo number_format($TotalGSTAmount,0); ?></td>
     <td style="text-align:right;"><?php echo number_format($TotalNetAmount,0); ?></td>
                </tr>
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
      }
                }
                ?>
                <tr style="font-size:12px;  font-weight:600;">
     <td colspan="11" style="text-align:right;"></td>
                </tr>
    <tr style="font-size:12px; font-weight:600;">
     <td colspan="5" style="text-align:right;">Grand Total:</td>
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
<script src="<?php echo base_url(); ?>lib/js/freeze-table.js"></script>
<script>
$(document).ready(function() {

  $(".table-basic").freezeTable();

  $(".table-head-only").freezeTable({
    'freezeColumn': false,
  });

});
</script>