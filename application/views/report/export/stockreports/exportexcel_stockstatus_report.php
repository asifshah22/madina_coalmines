<?php
header("Content-type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename = Stock Status Report.xls");
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Stock Status Report</title>
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
              <h3 style="color:green;" class="box-title">Stock Status Report</h3>
	      <hr style="color: #003eff; border-width: 1px; border-style: inset; display: block;">
<div style="padding-top:-0.1em; font-size:12px; font-weight:600; text-align:center;">Period of <?php echo date('M d, Y', strtotime($this->input->get('StartDate'))).' &nbsp; - &nbsp;  '. date('M d, Y', strtotime($this->input->get('EndDate'))); ?>
      </div>
            </div>
          </center>
        </div>
    <br><br>

      <hr style="color: #003eff; border-width: 1px; border-style: inset; display: block;">
      <!--  <button class="pull-right" type="button" id="SendMail" data-toggle="modal" data-target="#myModal">Send as Email</button> -->
           </div>
	     <div style="height:30px;"></div>
            <div class="table-head-only" style="overflow-x: scroll;">
                <table class="table table-bordered" style="width: 100%" id="table-basic">
              <thead>
                <tr style="background:#205081; font-size:13px; color:#FFFFFF;">
       <th style="width:30%">Particulars</th>
        <?php
	foreach($AllLocations as $LocationRecord) { ?> 
	 <th><?php echo $LocationRecord['LocationName']; ?></th> 
	<?php } ?>	
       <th>Total</th>	
      </tr>
    </thead>
    <tbody>
    <?php
    
  //  echo '<pre>';
  //  print_r($LocationWiseStockPurchase);
   // die;
    $LocationWiseRecordPurchaseQty = 0;
    $LocationWiseRecordPurchaseReturnQty = 0;
    $LocationWiseRecordSaleQty = 0;
    $LocationWiseRecordSaleReturnQty = 0;
    $LocationAndProductWiseTotalRecord = 0;
    $LocationWiseTotalRecord = 0;
    $LocationWiseGrandTotalRecord = 0;
    $ProductTransferQty = 0;
    $NetLocationWiseQtyRecord = 0;
    $PreeLocationAndProductWiseTotalRecord = 0;
    $ProductTransferQtyFrom = 0;
	
    if(isset($AllProducts)) 
    {
      foreach($AllProducts as $ProductRecord) 
      {
	
	// Getting product record from stock table product wise
	if(isset($ProductWiseStock))
	{
	  foreach($ProductWiseStock as $ProductWiseRecord)
	  {
	    if($ProductWiseRecord['ProductId'] == $ProductRecord['ProductId'])
	    {		  
       ?>
	<tr style="font-family:arial, sans-serif; font-size: 13px;">
	<td style="text-align:left; font-weight:600;"><?php echo $ProductWiseRecord['ProductName'].' - '.$ProductWiseRecord['ProductGroupName'].' - '.$ProductWiseRecord['BrandName']; ?></td>
	<td colspan="<?php echo count($AllLocations); ?>"></td>
	<td></td>
	</tr>
	<?php 
	    // Getting product color from color table
	    if(isset($ColourWiseStock)) 
	    {
		foreach($ColourWiseStock as $ColourWiseRecord)
		{	
		    if(isset($AllColours)) 
		    {
			foreach($AllColours as $ColourRecord)
			{
			    if($ColourWiseRecord['ProductId'] == $ProductWiseRecord['ProductId'] && $ColourWiseRecord['ColourId'] == $ColourRecord['ColourId'])
			    {

	?>
	<tr style="font-family:arial, sans-serif; font-size: 13px;">
	<td style="text-align:left;"><?php echo $ColourRecord['ColourName']; ?></td>
	<?php
	  // Getting all locations from location table
	 foreach($AllLocations as $LocationRecord) 
	 {
	 ?> 
	<td style="text-align:right; font-weight:600;">
	<?php
	
	// Function of Purchase Record
	foreach($LocationWiseStockPurchase as $LocationWiseRecordPurchase) 
	{	
	   if($LocationWiseRecordPurchase['LocationId'] == $LocationRecord['LocationId'] && $LocationWiseRecordPurchase['ProductId'] == $ProductWiseRecord['ProductId'] && $LocationWiseRecordPurchase['ColourId'] == $ColourWiseRecord['ColourId'])
	   {
	     $LocationWiseRecordPurchaseQty = $LocationWiseRecordPurchase['Quantity'];
	   }
	}
	
	// Function of Purchase Return Record
	foreach($LocationWiseStockPurchaseReturn as $LocationWiseRecordPurchaseReturn) 
	{	
	   if($LocationWiseRecordPurchaseReturn['LocationId'] == $LocationRecord['LocationId'] && $LocationWiseRecordPurchaseReturn['ProductId'] == $ProductWiseRecord['ProductId'] && $LocationWiseRecordPurchaseReturn['ColourId'] == $ColourWiseRecord['ColourId'])
	   {
	 	 $LocationWiseRecordPurchaseReturnQty = $LocationWiseRecordPurchaseReturn['Quantity'];
	   }
	}
	
	// Function of Sale Record
	foreach($LocationWiseStockSale as $LocationWiseRecordSale) 
	{	
	   if($LocationWiseRecordSale['LocationId'] == $LocationRecord['LocationId'] && $LocationWiseRecordSale['ProductId'] == $ProductWiseRecord['ProductId'] && $LocationWiseRecordSale['ColourId'] == $ColourWiseRecord['ColourId'])
	   {
		 $LocationWiseRecordSaleQty = $LocationWiseRecordSale['Quantity'];
	   }
	}
	
	// Function of Sale Return Record
	foreach($LocationWiseStockSaleReturn as $LocationWiseRecordSaleReturn) 
	{	
	   if($LocationWiseRecordSaleReturn['LocationId'] == $LocationRecord['LocationId'] && $LocationWiseRecordSaleReturn['ProductId'] == $ProductWiseRecord['ProductId'] && $LocationWiseRecordSaleReturn['ColourId'] == $ColourWiseRecord['ColourId'])
	   {
		 $LocationWiseRecordSaleReturnQty = $LocationWiseRecordSaleReturn['Quantity'];
	   }
	}
	
	// Function of Product Transfer Record From
	foreach($ProductsTransferFrom as $ProductTransferRecordFrom) 
	{
	   if($ProductTransferRecordFrom['LocationIdFrom'] == $LocationRecord['LocationId'] && $ProductTransferRecordFrom['ProductId'] == $ProductWiseRecord['ProductId'] && $ProductTransferRecordFrom['ColourId'] == $ColourWiseRecord['ColourId'])
	   {
		$ProductTransferQtyFrom = $ProductTransferRecordFrom['Quantity'];
	   }
	}
	
	// Function of Product Transfer Record
	foreach($ProductsTransfer as $ProductTransferRecord) 
	{   
	   if($ProductTransferRecord['LocationId'] == $LocationRecord['LocationId'] && $ProductTransferRecord['ProductId'] == $ProductWiseRecord['ProductId'] && $ProductTransferRecord['ColourId'] == $ColourWiseRecord['ColourId'])
	   {
		$ProductTransferQty = $ProductTransferRecord['Quantity'];
	   }
	}	
	
	 $NetLocationWiseQtyRecord = (floatval(($LocationWiseRecordPurchaseQty + $LocationWiseRecordSaleReturnQty) - $ProductTransferQtyFrom));
	
	 $LocationWiseQtyRecord = (floatval($NetLocationWiseQtyRecord  + $ProductTransferQty) - floatval($LocationWiseRecordSaleQty + $LocationWiseRecordPurchaseReturnQty));
	 echo $LocationWiseQtyRecord != 0 ? '<span style="font-weight:600; color:blue;">'.$LocationWiseQtyRecord.'</span>' : '<span style="font-weight:300; color:red;">0</span>';
	 
	
	 $PreeLocationAndProductWiseTotalRecord += (floatval(($LocationWiseRecordPurchaseQty + $LocationWiseRecordSaleReturnQty) - $ProductTransferQtyFrom));
	 $LocationAndProductWiseTotalRecord += (floatval($PreeLocationAndProductWiseTotalRecord + $ProductTransferQty) - floatval($LocationWiseRecordSaleQty + $LocationWiseRecordPurchaseReturnQty));
	
	 $LocationWiseRecordPurchaseQty = 0;
	 $LocationWiseRecordPurchaseReturnQty = 0;
	 $LocationWiseRecordSaleQty = 0;
	 $LocationWiseRecordSaleReturnQty = 0;
	 $ProductTransferQty = 0;
	 $ProductTransferQtyFrom = 0;
	 $PreeLocationAndProductWiseTotalRecord = 0;
	?>
	</td>
	 
	 <?php } ?>
	<td style="text-align:right; font-weight:600;"><?php echo $LocationAndProductWiseTotalRecord; ?></td>
       </tr>
	<?php
	$LocationAndProductWiseTotalRecord = 0;
	  }  } }
	   
	    //  End of product color from color table 
	    } }
	  
	    // End of product record from stock table product wise
	    } } } 
	 
		} }	
	?>
     <tr>
     <td style="text-align:left; font-weight: 700; font-size: 13px;">Grand Total:</td>
     	<?php foreach($AllLocations as $LocationRecord) { ?>
	<td style="text-align:right; font-weight:700;">	
	<?php
	
	// Function of Purchase Record
	foreach($LocationWiseStockPurchase as $LocationWiseRecordPurchase) 
	{	
	   if($LocationWiseRecordPurchase['LocationId'] == $LocationRecord['LocationId'])
	   {
		 $LocationWiseRecordPurchaseQty += $LocationWiseRecordPurchase['Quantity'];
	   }
	}
	
	// Function of Purchase Return Record
	foreach($LocationWiseStockPurchaseReturn as $LocationWiseRecordPurchaseReturn) 
	{	
	   if($LocationWiseRecordPurchaseReturn['LocationId'] == $LocationRecord['LocationId'])
	   {
	 	 $LocationWiseRecordPurchaseReturnQty += $LocationWiseRecordPurchaseReturn['Quantity'];
	   }
	}
	
	// Function of Sale Record
	foreach($LocationWiseStockSale as $LocationWiseRecordSale) 
	{	
	   if($LocationWiseRecordSale['LocationId'] == $LocationRecord['LocationId'])
	   {
	      $LocationWiseRecordSaleQty += $LocationWiseRecordSale['Quantity'];
	   }
	}
	
	// Function of Sale Return Record
	foreach($LocationWiseStockSaleReturn as $LocationWiseRecordSaleReturn) 
	{	
	   if($LocationWiseRecordSaleReturn['LocationId'] == $LocationRecord['LocationId'])
	   {
	      $LocationWiseRecordSaleReturnQty += $LocationWiseRecordSaleReturn['Quantity'];
	   }
	}
	
	// Function of Product Transfer Record From
	foreach($ProductsTransferFrom as $ProductTransferRecordFrom) 
	{   
	   if($ProductTransferRecordFrom['LocationIdFrom'] == $LocationRecord['LocationId'] && $ProductTransferRecordFrom['ProductId'] == $ProductWiseRecord['ProductId'] && $ProductTransferRecordFrom['ColourId'] == $ColourWiseRecord['ColourId'])
	   {
		$ProductTransferQtyFrom = $ProductTransferRecordFrom['Quantity'];
	   }
	}
	
	// Function of Product Transfer Record
	foreach($ProductsTransfer as $ProductTransferRecord) 
	{   
	   if($ProductTransferRecord['LocationId'] == $LocationRecord['LocationId'] && $ProductTransferRecord['ProductId'] == $ProductWiseRecord['ProductId'] && $ProductTransferRecord['ColourId'] == $ColourWiseRecord['ColourId'])
	   {
		$ProductTransferQty = $ProductTransferRecord['Quantity'];
	   }
	}
	
	
	 $NetLocationWiseQtyRecord = (floatval(($LocationWiseRecordPurchaseQty + $LocationWiseRecordSaleReturnQty) - $ProductTransferQtyFrom));	
	
	// $NetLocationWiseTotalRecord = (floatval($LocationWiseRecordPurchaseQty + $LocationWiseRecordSaleReturnQty) - floatval($LocationWiseRecordSaleQty + $LocationWiseRecordPurchaseReturnQty));
	 
	 echo $LocationWiseTotalRecord = (floatval($NetLocationWiseQtyRecord + $ProductTransferQty) - floatval($LocationWiseRecordSaleQty + $LocationWiseRecordPurchaseReturnQty));
	 $LocationWiseGrandTotalRecord += (floatval($LocationWiseRecordPurchaseQty + $LocationWiseRecordSaleReturnQty)  - floatval($LocationWiseRecordSaleQty + $LocationWiseRecordPurchaseReturnQty));
	
	 $LocationWiseRecordPurchaseQty = 0;
	 $LocationWiseRecordPurchaseReturnQty = 0;
	 $LocationWiseRecordSaleQty = 0;
	 $LocationWiseRecordSaleReturnQty = 0;
	 $ProductTransferQtyFrom = 0;
	 $ProductTransferQty = 0;
	?>
	</td>
	<?php  }  ?>
	<td style="text-align:right; font-weight:700;"><strong><?php echo $LocationWiseGrandTotalRecord; ?></strong></td>
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