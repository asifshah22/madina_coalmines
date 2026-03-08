<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Inventory Stock Report</title>
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
              <h3 style="color: #368763;" class="box-title">Product Stock Detail Report</h3>
            </div>
          </center>
            <table class="table table-bordered">
              <thead>
                <tr style="background:#3c8dbc; font-size:14px; color:#FFFFFF;">
                 <th>S No.</th>
                 <th>Product Name</th>
                 <th>Purchased Quantity</th>
                 <th>Purchased Return Quantity</th>
                 <th>Sale Quantity</th>
		 <th>Sale Return Quantity</th>
                 <th>Balance Quantity</th>
                 </tr>
              </thead>
              <tbody>
              <?php                            
              
              $SaleQuantity = 0;
              $SNo=1;
              $PurchaseQuantity = 0;
              $BalanceRecord = 0; 
	      $TotalPurchaseQuantity = 0;
              $TotalSaleQuantity = 0;
	      //echo '<pre>';
	     // print_r($AllPurchaseRecord);
	     // die;
	      
              if(isset($AllProducts)) {
              foreach($AllProducts as $ProductRecord) {
            
              if(isset($AllPurchaseRecord))
	      {
		foreach($AllPurchaseRecord as $PurchaseRecord)
		{ 
		    if($PurchaseRecord['ProductId'] == $ProductRecord['ProductId'])
		    { $PurchaseQuantity = $PurchaseRecord['Quantity']; }
		}
	      }
	      
	      if(isset($AllSaleRecord))
	      {
		foreach($AllSaleRecord as $SaleRecord)
		{ 
		    if($SaleRecord['ProductId'] == $ProductRecord['ProductId'])
		    { 
			$SaleQuantity = $SaleRecord['Quantity']; 
		    }
		    
		}
	      }
	     

          
                     
                     
                     if($StockRegister['StockType'] == 0)
                     { $Description = '<span style="color: #990073;">'.$StockRegister['Notes'].'</span>'; }
                     else
                     $Description = '<span style="color: #003eff;">'.$StockRegister['OrderNo'].'&nbsp;&nbsp;&nbsp;/&nbsp;&nbsp;&nbsp;'.$StockRegister['VendorName'].'</span>';     
                 
                 }
                 else
                 { $StockIn = ''; }
                
                 
                 if($StockRegister['StockType'] == 2)
                 {  
                    $Description = '<span style="color: #008000;">'.$StockRegister['InvoiceNo'].'&nbsp;&nbsp;&nbsp;/&nbsp;&nbsp;&nbsp;'.$StockRegister['CustomerName'].'</span>';
                    $CostOfGoodSoldAmount = $StockRegister['CostOfGoodSoldAmount'];
                  
                    if($StockRegister['SupplyQuantity'] == '')
                   { $StockOut = $StockRegister['StockInOut']; } 
                   
                   else if ($StockRegister['SupplyQuantity'] != '' && $StockRegister['SupplyQuantity'] != 0)
                   { $StockOut = $StockRegister['SupplyQuantity']; }
                   
                   else 
                    {$StockOut = 0; } 
                    
                    if( $StockOut!=0)
                    { $Rate2 = $CostOfGoodSoldAmount /  $StockOut; }
                    $Balance = $Balance - $StockOut;
                    
                 }      
                  else
                { $StockOut = ''; }
                                
               
                if($StockIn!=0)
                { $BalanceValue = ( $StockRegister['Rate'] * $StockIn); 
                 $Rate = $StockRegister['Rate'];
                 $ProductValueBalance += $BalanceValue;
                }  
                else
                { $BalanceValue = $CostOfGoodSoldAmount;
                if( $StockOut!=0) 
                {$Rate = $CostOfGoodSoldAmount /  $StockOut;}
                $ProductValueBalance = $ProductValueBalance - $BalanceValue;
                }
               */
	      
	      
	      /*
               $TotalOfBilled =  ($SalesInvoiceQuantity + $StockInHand) - $SalesOrderQuantity;
               
               if($TotalOfBilled < 0)                   
               { $TotalOfBilled = '<span style="color: #ac2925;">'.$TotalOfBilled.'</span>'; }
               else
               { $TotalOfBilled = '<span style="color: #003eff;">'.$TotalOfBilled.'</span>'; } 
               */
	      
	        if($PurchaseQuantity != 0)
	        {
		  $BalanceRecord = $PurchaseQuantity - $SaleQuantity;
	        }
                ?>
                <tr style="font-family:arial, sans-serif; font-size: 13px;">  
                   <td><?php echo  $SNo; // print date('M d, Y', strtotime($StockRegister['Date'])); ?></td>
                   <td style="text-align:left;"><?php echo $ProductRecord['ProductName'].' - '.$ProductRecord['ProductGroupName'].' - '.$ProductRecord['BrandName']; ?></td>
                   <td style="text-align:right;"><?php echo $PurchaseQuantity; ?></td>
                   <td><?php // print $StockInHand; //$StockInHand; ?></td>
		   <td style="text-align:right;"><?php echo $SaleQuantity; ?></td>
		   <td><?php //echo $SaleQuantity; ?></td>
                   <td style="text-align:right;"><?php echo $BalanceRecord; ?></td>
                </tr>    
               <?php
               $SNo++; 
	       $TotalPurchaseQuantity += $PurchaseQuantity;
               $TotalSaleQuantity += $SaleQuantity;
	       
	       $GrandProductBalanceQuantity = $TotalPurchaseQuantity - $TotalSaleQuantity;
              
	       $PurchaseQuantity = 0;
	       $SaleQuantity = 0;
               /* 
                $StockInHand = 0;
                $Balance1 = 0;
                $Balance2 = 0;
		*/
              } }  
               ?>
                
               <?php  
              
               // } } } ?>
               <?php 
            
               /*
                 $GrandProductValueBalance += $ProductValueBalance;
                 $TotalStockIn = 0;
                 $TotalStockOut = 0;
                 $Balance = 0;
                 $ProductValue = 0;
                 $BalanceValue = 0;
                 $ProductValueBalance = 0;
                 $CostOfGoodSoldAmount = 0;
                 } }
                 */
                
                 ?>               
                <tr>               
                <td colspan="2" style="text-align: right; font-weight: 700; font-size: 13px;">Grand Total:</td>
                <td style="text-align:right;"><strong><?php echo $TotalPurchaseQuantity; ?></strong></td>
                <td></td>
		<td style="text-align:right;"><strong><?php echo $TotalSaleQuantity; ?></strong></td>
                <td></td>
                <td style="text-align:right;"><strong><?php echo $GrandProductBalanceQuantity; ?></strong></td>
                
                </tr>
              </tbody>
              </table>
         </div>   
       </div>
    </div>
  </body>
</html>







<!DOCTYPE html>
<html lang="en">
<head>
  <title>Bootstrap Example</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>

<div class="container">
  <h2>Bordered Table</h2>
  <p>The .table-bordered class adds borders to a table:</p>            
  <table class="table table-bordered">
    <thead>
      <tr style="background:#3c8dbc;">
        <th>Firstname</th>
        <th>Lastname</th>
        <th>Email</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td>John</td>
        <td>Doe</td>
        <td>john@example.com</td>
      </tr>
      <tr>
        <td>Mary</td>
        <td>Moe</td>
        <td>mary@example.com</td>
      </tr>
      <tr>
        <td>July</td>
        <td>Dooley</td>
        <td>july@example.com</td>
      </tr>
    </tbody>
  </table>
</div>

</body>
</html>
