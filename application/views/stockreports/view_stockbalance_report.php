<!DOCTYPE html>
<html lang="en">
<head>
  <title>Stock Activity </title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>

<div class="container">
  <center><h3 style="color: #368763;" class="box-title">Stock Activity Amount</h3></center>
  <div style="height:10px;">
  	<?php echo "<h5><b> Date From: " . $this->input->get('StartDate') . " To " . $this->input->get("EndDate") ."</b></h5>" ; ?>
  </div><br>
  <table class="table table-bordered">
    <thead>
      <tr style="background:#3c8dbc; color:#fff;">
        <th>S. #</th>
	<th>Product Name</th>
	<th>Product Group</th>
	<th>Brand</th>
	<th>Purchased Qty</th>
	<th>Purchase Amount</th>
	<th>Purchased Return Qty</th>
	<th>Purchase Return Amount</th>
	<th>Sale Qty</th>
	<th>Sale Amount</th>
	<th>Sale Return Qty</th>
	<th>Sale Return Amount</th>
	
      </tr>
    </thead>
    <tbody>
    <?php
    $PurchaseQuantity = 0;
    $PurchaseAmount = 0;
    $PurchaseReturnQuantity = 0;
    $PurchaseReturnAmount = 0;
    $SaleQuantity = 0;
    $SaleAmount = 0;
    $SaleReturnQuantity = 0;
    $SaleReturnAmount = 0;
    $BalanceQuantity = 0;
    
    
    $TotalPurchaseAmount = 0;
    $TotalPurchaseReturnAmount = 0;
	
    $TotalSaleAmount = 0;
    $TotalSaleReturnAmount = 0;

	
    
    $TotalPurchaseQuantity = 0;
    $TotalPurchaseAmount = 0;
    $TotalPurchaseReturnQuantity = 0;
    $TotalSaleQuantity = 0;
    $TotalSaleReturnQuantity = 0;
    $TotalBalanceQuantity = 0;
    $SNo=1;
    
    if(isset($AllProducts)) {
    foreach($AllProducts as $ProductRecord) 
    {
	// Getting Total Purchase Quantity
	if(isset($AllPurchaseRecord))
	{
	  foreach($AllPurchaseRecord as $PurchaseRecord)
	  {  
	      if($PurchaseRecord['ProductId'] == $ProductRecord['ProductId'])
	      { 
		  $PurchaseQuantity = $PurchaseRecord['Quantity'];
		  $PurchaseAmount = ($PurchaseQuantity * $PurchaseRecord['Rate']);
	      }
	  }
	}
	
	// Getting Total Purchase Return Quantity
	if(isset($AllPurchaseReturnRecord))
	{
	  foreach($AllPurchaseReturnRecord as $PurchaseReturnRecord)
	  { 
	      if($PurchaseReturnRecord['ProductId'] == $ProductRecord['ProductId'])
	      { 
		 $PurchaseReturnQuantity = $PurchaseReturnRecord['Quantity'];
		 $PurchaseReturnAmount = ($PurchaseReturnQuantity * $PurchaseReturnRecord['Rate']);
	      }
	  }
	}
	
	// Getting Total Sale Quantity
	if(isset($AllSaleRecord))
	{
	  foreach($AllSaleRecord as $SaleRecord)
	  { 
	      if($SaleRecord['ProductId'] == $ProductRecord['ProductId'])
	      {
		$SaleQuantity = $SaleRecord['Quantity'];
		$SaleAmount = ($SaleQuantity * $SaleRecord['Rate']);
	      }
	  }
	}
	
	// Getting Total Sale Return Quantity
	if(isset($AllSaleReturnRecord))
	{
	  foreach($AllSaleReturnRecord as $SaleReturnRecord)
	  { 
	      if($SaleReturnRecord['ProductId'] == $ProductRecord['ProductId'])
	      {
		$SaleReturnQuantity = $SaleReturnRecord['Quantity']; 
		
		$SaleReturnAmount = ($SaleReturnQuantity *  $SaleReturnRecord['Rate']);
	      }
	  }
	}

	if($PurchaseQuantity != 0 || $PurchaseReturnQuantity != 0 || $SaleQuantity != 0 || $SaleReturnQuantity != 0) 
	{
	   $BalanceQuantity += ($PurchaseQuantity + $SaleReturnQuantity) - ($SaleQuantity + $PurchaseReturnQuantity);	
       ?>
	<tr style="font-family:arial, sans-serif; font-size: 13px;">  
	<td style="text-align:center; "><?php echo $SNo; ?>	</td>
	<td style="text-align:left;"><?php echo $ProductRecord['ProductName'].' - '.$ProductRecord['ProductGroupName'].' - '.$ProductRecord['BrandName']; ?></td>
	<td style="text-align:right; font-weight:600;"><?php echo $ProductRecord['ProductGroupName']; ?></td>
	<td style="text-align:right; font-weight:600;"><?php echo $ProductRecord['BrandName']; ?></td>
	<td style="text-align:right; font-weight:600;"><?php echo $PurchaseQuantity; ?></td>
	<td style="text-align:right; font-weight:600;"><?php echo $PurchaseAmount; ?></td>
	<td style="text-align:right; font-weight:600;"><?php echo $PurchaseReturnQuantity; ?></td>
	<td style="text-align:right; font-weight:600;"><?php echo $PurchaseReturnAmount; ?></td>	
	<td style="text-align:right; font-weight:600;"><?php echo $SaleQuantity; ?></td>
	<td style="text-align:right; font-weight:600;"><?php echo $SaleAmount; ?></td>
	<td style="text-align:right; font-weight:600;"><?php echo $SaleReturnQuantity; ?></td>
	<td style="text-align:right; font-weight:600;"><?php echo $SaleReturnAmount; ?></td>	
	
       </tr>
	<?php
	$SNo++;
	$TotalPurchaseQuantity += $PurchaseQuantity;	
	$TotalPurchaseReturnQuantity += $PurchaseReturnQuantity;
	$TotalSaleQuantity += $SaleQuantity;
	
	$TotalSaleReturnQuantity += $SaleReturnQuantity;	
	$TotalBalanceQuantity = $BalanceQuantity;
	
	
	$TotalPurchaseAmount += $PurchaseAmount;
	$TotalPurchaseReturnAmount += $PurchaseReturnAmount;
	
	$TotalSaleAmount += $SaleAmount;
	$TotalSaleReturnAmount += $SaleReturnAmount;

	$PurchaseQuantity = 0;
	$PurchaseAmount = 0;
	
	$PurchaseReturnQuantity = 0;
	$PurchaseReturnAmount = 0;
	
	$SaleQuantity = 0;
	$SaleAmount = 0;
	
	$SaleReturnQuantity = 0;
	$SaleReturnAmount = 0;
	
	
	} }  }
	?>
     <tr>             
     <td colspan="2" style="text-align:left; font-weight: 700; font-size: 13px;">Total Balance:</td>
     <td style="text-align:right; font-weight:700;"><?php echo "---"; ?></td>
     <td style="text-align:right; font-weight:700;"><?php echo "---"; ?></td>
     <td style="text-align:right; font-weight:700;"><?php echo $TotalPurchaseQuantity; ?></td>
     <td style="text-align:right; font-weight:700;"><?php echo $TotalPurchaseAmount; ?></td>
     <td style="text-align:right; font-weight:700;"><?php echo $TotalPurchaseReturnQuantity; ?></td>
     <td style="text-align:right; font-weight:700;"><?php echo $TotalPurchaseReturnAmount; ?></td>
     
     <td style="text-align:right; font-weight:700;"><?php echo $TotalSaleQuantity; ?></td>
     <td style="text-align:right; font-weight:700;"><?php echo $TotalSaleAmount; ?></td>
     
     <td style="text-align:right; font-weight:700;"><?php echo $TotalSaleReturnQuantity; ?></td>
     <td style="text-align:right; font-weight:700;"><?php echo $TotalSaleReturnAmount; ?></td>
     
     
   
     </tr>
   </tbody>
   </table>
  </div>
</body>
</html>
