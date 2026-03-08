<?php
header("Content-type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename = Available Product Price Report.xls");
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Available Product Price Report</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport"> 

        <!-- jQuery 2.2.3 -->
  <script src="<?php echo base_url(); ?>plugins/jQuery/jquery-2.2.3.min.js">
  </script>
  <!-- Bootstrap 3.3.6 -->
  <script src="<?php echo base_url(); ?>bootstrap/js/bootstrap.min.js"></script>
  <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="<?php echo base_url(); ?>plugins/select2/select2.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>lib/css/font-awesome/font-awesome.min.css">
<style type="text/css">

@media print
{    
    .no-print, .no-print *
    {
        display: none !important;
    }
}

</style>

</head>
<body class="hold-transition skin-blue sidebar-mini">
    <div class="wrapper">
      <div class="box box-info">
        <div class="col-md-12 col-xs-12">
          <center>
            <div class="box-header">
	      <h2 style="color:black; font-family:Georgia; font-weight:600;" class="box-title">Hilife Electronics</h2>
              <h3 style="color:green;" class="box-title">Available Product Price Report</h3>
	      <hr style="color: #003eff; border-width: 1px; border-style: inset; display: block;">
<div style="padding-top:-0.1em; font-size:12px; font-weight:600; text-align:center;">Period of <?php echo date('M d, Y', strtotime($this->input->get('StartDate'))).' &nbsp; - &nbsp;  '. date('M d, Y', strtotime($this->input->get('EndDate'))); ?>
      </div>
            </div>
          </center>
        </div>
    <br><br>

      <hr style="color: #003eff; border-width: 1px; border-style: inset; display: block;">
           </div>
	     <div style="height:30px;"></div>
            <div class="table-head-only" style="overflow-x: scroll;">
                <table class="table table-bordered" style="width: 100%" id="table-basic">
              <thead>
                <tr style="background:#205081; font-size:13px; color:#FFFFFF;">
        <th>S. #</th>
	<th>Category</th>
	<th>Brand</th>
	<th>Group</th>
	<th>Model</th>
	<?php if($this->input->get('PurchasePrice') == 1) { ?>
	<th>Purchased Price</th>
	<?php } if($this->input->get('SalePrice') ==1) { ?>
	<th>Sale Price</th>
	<?php } if($this->input->get('FinalPrice') ==1) { ?>
	<th>Final Price</th>
	<?php } ?>
	<th>Barcode</th>
	<?php if($this->input->get('Specifications') ==1) { ?>
	<th>Product Specifications</th>
	<?php } ?>
	
	
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
		 // $PurchaseAmount = ($PurchaseQuantity * $PurchaseRecord['Rate']);
		  $PurchaseAmount = ($PurchaseRecord['NetAmount']);
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
		//$SaleAmount = ($SaleQuantity * $SaleRecord['Rate']);
		$SaleAmount = ($SaleRecord['NetAmount']);
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
	<td style="text-align:left; "><?php echo $ProductRecord['ProductGroupName']; ?></td>
	<td style="text-align:left; "><?php echo $ProductRecord['BrandName']; ?></td>
		<?php if($this->input->get('PurchasePrice') == 1) { ?>
	<td style="text-align:right; "><?php echo $PurchaseQuantity; ?></td>
		<?php } ?>
		<?php if($this->input->get('SalePrice') == 1) { ?>
	<td style="text-align:right; "><?php echo $PurchaseAmount; ?></td>
		<?php } ?>
		<?php if($this->input->get('FinalPrice') == 1) { ?>
	<td style="text-align:right; "><?php echo $PurchaseReturnQuantity; ?></td>
		<?php } ?>
	<td style="text-align:right; "><?php echo $PurchaseReturnAmount; ?></td>	
	<td style="text-align:right; "><?php echo $SaleQuantity; ?></td>
	<?php if($this->input->get('Specifications') == 1) { ?>
	<td style="text-align:right; "><?php echo $ProductRecord['ProductDetails']; ?></td>
	<?php } ?>
	
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
     <td colspan="3" style="text-align:left; font-weight: 700; font-size: 13px;">Total Balance:</td>
     <td style="text-align:right; font-weight:700;"><?php echo "---"; ?></td>
     <td style="text-align:right; font-weight:700;"><?php echo "---"; ?></td>
	 		<?php if($this->input->get('PurchasePrice') == 1) { ?>
     <td style="text-align:right; font-weight:700;"><?php echo $TotalPurchaseQuantity; ?></td>
			<?php } ?>
			<?php if($this->input->get('SalePrice') == 1) { ?>
     <td style="text-align:right; font-weight:700;"><?php echo $TotalPurchaseAmount; ?></td>
			<?php } ?>
			<?php if($this->input->get('FinalPrice') == 1) { ?>
     <td style="text-align:right; font-weight:700;"><?php echo $TotalPurchaseReturnQuantity; ?></td>
			<?php } ?>
			<?php if($this->input->get('Specifications') == 1) { ?>
     <td style="text-align:right; font-weight:700;"><?php echo $TotalPurchaseReturnAmount; ?></td>
			<?php } ?>
     <td style="text-align:right; font-weight:700;"><?php echo $TotalSaleReturnAmount; ?></td>

     </tr>
   </tbody>
   </table>
  </div>
</body>
</html>

<script src="<?php echo base_url(); ?>plugins/select2/select2.min.js"></script>
<script src="<?php echo base_url(); ?>lib/js/freeze-table.js"></script>
<script>
$(document).ready(function() {

  $(".table-basic").freezeTable();

  $(".table-head-only").freezeTable({
    'freezeColumn': false,
  });


  $("#Show").click(function(){
    $("#OtherEmployee").toggle('2000');
  })


});
</script>


<script>
  $(document).ready(function() {
    $('.js-example-basic-multiple').select2();
});
</script>