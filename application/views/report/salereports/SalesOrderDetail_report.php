<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Product Report</title>
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
          <center>
            <div class="box-header">
              <h3 style="color:#000000; height:50px;" class="box-title">Sales Order Detail Report</h3>
            </div>
          </center>
             <div class="table-head-only" style="overflow-x: scroll;">
                <table class="table table-bordered" style="width: 100%" id="table-basic">
              <thead>
                <tr style="background:#3c8dbc; font-size:14px; color:#FFFFFF;">
                 <th>S.#</th>
                 <th>Company Name</th>
		 <th>Reference</th>
                 <th>Product Name</th>
                 <th>Product Group</th>
                 <th>Rate</th>
                 <th>Sales Order No</th>
                 <th>Ordered Qty</th>
                 <th>Ordered Amount</th>
                 <th>Sales Invoice No</th>
                 <th>Supply Qty</th>
                 <th>Supply Amount</th>
                 <th>Bill Qty</th>
                 <th>Bill Amount</th>
                </tr>
              </thead>
              <tbody>
              <?php
              $TotatalRate='';
              $TotalOrderedQuantity=0;
              $TotalOrderedAmount=0;
              $TotalSupplyQuantity=0;
              $TotalSupplyAmount=0;
              $TotalBillQuantity=0;
              $TotalBillAmount=0;
              $TotalGrandOrderedQuantity =0;
              $TotalGrandOrderedAmount =0;
              $TotalGrandSupplyQuantity =0;
              $TotalGrandSupplyAmount =0;
              $TotalGrandBillQuantity =0;
              $TotalGrandBillAmount = 0;
              $CustomerRecord=0;
              $SNo=1;
              $TempCustomerName = '';
              
              if(isset($SalesOrderDetailReport)) {
              
              foreach($SalesOrderDetailReport as $CustomerName => $CustomerRecord) {     
              ?>
                <tr>
                    <td style="padding-left:10px; padding-top:10px;"><?php echo $SNo;?></td>
                    <td colspan="8" style=" text-align:left;"><h4>Customer Name: <?php echo $CustomerName; ?></h4></td>
                     <?php

                      if(!empty($CustomerRecord) ) {    

                      foreach($CustomerRecord as $row){
                      $TotalOrderedQuantity += $row['Ordered Quantity'];
                      $TotalOrderedAmount +=$row['Ordered Amount']; 
                      
                    
                      // script for Sales Order row highlighting
                    //  if($row['SalesOrderId']!='' && $row['InvoiceProductId'] == $row['SalesOrderProductId'])
                     // $color = '#d9edf7';
                      //else
                      //$color = '';     

                      ?>
               </tr>
                 
                 <tr style="font-size:13px; background: <?php // echo $color; ?>;">
                 <td></td>
                 <td><?php echo $row['CompanyName']?></td>
		 <td><?php echo $row['FullName']?></td>
                 <td><?php echo $row['BrandName']?></td>
                 <td><?php echo $row['ProductGroupName']?></td>
                 <td><?php echo $row['Rate']; ?></td>
                 <td><?php echo $row['SalesOrderNo']; ?></td>
                 <td><?php echo $row['Ordered Quantity']?></td>
                 <td><?php echo number_format($row['Ordered Amount'],2); ?></td>
                 <td></td>
                 <td><?php //echo $row['Supply Quantity']; ?></td>
                 <td><?php //echo number_format($SupplyAmount,2); ?></td>
                 <td><?php ?></td>
                 <td><?php ?></td>
                </tr>
                    
                 <?php   } } ?>
                
                <?php
                if(isset($SalesOrderDetailInvoiceReport)) {
                foreach($SalesOrderDetailInvoiceReport as $row2) {
                        
                if($row2['CustomerId'] == $row['CustomerId']) { 
                $SumSupplyAmount = ($row2['Rate'] * $row2['Supply Quantity']);
                
                // if supply quantity is blank then get bill quantity in place of supply quantity and amount
                $SupplyQuantity = $row2['Supply Quantity'] != '' ? $row2['Supply Quantity'] : $row2['Bill Quantity'];
                $SupplyAmount = $row2['Supply Quantity'] != '' ? $SumSupplyAmount : $row2['Bill Amount'];
                 
                 $TotalSupplyQuantity += $SupplyQuantity;
                 $TotalSupplyAmount += $SupplyAmount;
                 
                 $TotalBillQuantity += $row2['Bill Quantity'];
                 $TotalBillAmount += $row2['Bill Amount'];
                 ?>
                
                <tr style="font-size:13px;">
                 <td></td>
                 <td><?php echo $row2['CompanyName']?></td>
		 <td><?php echo $row['FullName']?></td>
                 <td><?php echo $row2['BrandName']?></td>
                 <td><?php echo $row2['ProductGroupName']?></td>
                 <td><?php echo $row2['Rate']; ?></td>
                 <td><?php echo $row2['OrderNo']; ?></td>
                 <td></td>
                 <td></td>
                 <td><?php  echo $row2['InvoiceNo']; ?></td>
                 <td><?php echo $SupplyQuantity; ?></td>
                 <td><?php echo number_format($SupplyAmount,2); ?></td>
                 <td><?php echo $row2['Bill Quantity']; ?></td>
                 <td><?php echo number_format($row2['Bill Amount'],2); ?></td>
                </tr>
               
                <?php } }  }  ?>            
                
                 <tr style="font-size:13px;">
                 <td colspan="3" align="right" ><strong><?php //echo $TotatalRate; ?></strong></td>
                 <td>&nbsp;</td>
	         <td>&nbsp;</td>
                 <td>&nbsp;</td>
                 <td>&nbsp;</td>
                 <td><strong><?php echo $TotalOrderedQuantity; ?></strong></td>
                 <td><strong><?php echo number_format($TotalOrderedAmount,2); ?></strong></td>
                 <td>&nbsp;</td>
                 <td><strong><?php echo $TotalSupplyQuantity; ?></strong></td>
                 <td><strong><?php echo number_format($TotalSupplyAmount,2); ?></srong></td>
                 <td><strong><?php echo $TotalBillQuantity; ?></strong></td>
                 <td><strong><?php echo number_format($TotalBillAmount,2); ?></strong></td>
                </tr>
                <tr style=" text-align: left; font-size:13px;"><td colspan="13">
                <?php                   
                // Calculating Grand totals
                $TotalGrandOrderedQuantity += $TotalOrderedQuantity;
                $TotalGrandOrderedAmount += $TotalOrderedAmount;
                $TotalGrandSupplyQuantity += $TotalSupplyQuantity;
                $TotalGrandSupplyAmount += $TotalSupplyAmount;
                $TotalGrandBillQuantity += $TotalBillQuantity;
                $TotalGrandBillAmount += $TotalBillAmount;

                $TotalBalanceAmount = ($TotalOrderedAmount - $TotalBillAmount);
                echo '<p></p>';
                echo  '<strong>Total Ordered Amount: Rs.'.number_format($TotalOrderedAmount,2).'<strong>';
                echo '<p></p>';
                echo '<strong>Total Bill Amount: Rs.'.number_format($TotalBillAmount,2).'</strong>';
                echo '<p></p>';
                echo '<strong>Total Balance: Rs.'.number_format($TotalBalanceAmount,2).'</strong>';
                echo '<p></p>';
                ?>
                </td>
                </tr>
                <?php  
                $TotalOrderedQuantity=0;
                $TotalOrderedAmount=0; 

                $TotalSupplyQuantity=0;
                $TotalSupplyAmount=0;

                $TotalBillQuantity=0;
                $TotalBillAmount=0;
                $SNo++; 
                } }
                ?> 
                <tr style=" text-align: center; font-size:13px;">
                <td colspan="7"></td>
                <td style="font-weight:600"><?php echo $TotalGrandOrderedQuantity; ?></td>
                <td style="font-weight:600"><?php echo number_format($TotalGrandOrderedAmount,2); ?></td>
                <td></td>
                <td style="font-weight:600"><?php echo $TotalGrandSupplyQuantity; ?></td>
                <td style="font-weight:600"><?php echo number_format($TotalGrandSupplyAmount,2); ?></td>
                <td style="font-weight:600"><?php echo $TotalGrandBillQuantity; ?></td>
                <td style="font-weight:600"><?php echo number_format($TotalGrandBillAmount,2); ?></td>
                </tr>
                <tr style=" text-align: left; font-size:13px;"><td colspan="13">
                <?php
                echo '<p></p>';
                echo  '<strong>Grand Total Ordered Amount: Rs.'.number_format($TotalGrandOrderedAmount,2).'<strong>';
                echo '<p></p>';
                echo '<strong>Grand Total Bill Amount: Rs.'.number_format($TotalGrandBillAmount,2).'</strong>';
                echo '<p></p>';
                echo '<strong>Grand Total Balance: Rs.'.number_format($TotalGrandBalanceAmount = ($TotalGrandOrderedAmount - $TotalGrandBillAmount),2).'</strong>';
                echo '<p></p>';
                ?>
                </td>
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