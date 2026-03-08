<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title><?php echo $this->uri->segment(1); ?></title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport"> 

        <!-- jQuery 2.2.3 -->
  <script src="<?php echo base_url(); ?>plugins/jQuery/jquery-2.2.3.min.js">
    $(function(){
      $('#functionName').text( $('#functionName').text().replace(/([A-Z])/g, " ") );
    })
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
          <div class="col-xs-2 col-sm-2">
              <img src="<?php echo base_url() ?>images/company-logo/<?php echo $GetSettingInformation[0]['CompanyLogo']; ?>" alt="" width="100" class="img-circle">
          </div>
          <div class="col-xs-8 col-sm-8">
            <h2 style="color:black; font-family:Calibri; font-weight:600;margin-left: 1%; margin-top: 30px;" class="box-title text-center"><?php echo $GetSettingInformation[0]['CompanyName']; // $this->session->userdata('CompanyName'); ?></h2>
          </div>
        </div>
    <br><br>
      <h3 style="color:green;text-align: center;" id="functionName">
        <?php $FunctionName = $this->uri->segment(2);
          $WithSpace = preg_replace('/(?<!\ )[A-Z]/', ' $0', $FunctionName);
          echo $WithSpace;
          ?>
        </h3>
      
      <div style="padding-top:-0.1em; font-size:12px; font-weight:600; text-align:center;">Period of <?php echo date('M d, Y', strtotime($this->input->get('StartDate'))).' &nbsp; - &nbsp;  '. date('M d, Y', strtotime($this->input->get('EndDate'))); ?>
      </div>
        <span class="pull-right no-print" style="font-size:13px; font-family: Arial, Helvetica, sans-serif; margin-top: -100px"><a href="#" class="" id="SendMail" data-toggle="modal" data-target="#myModal" style="color:green">Email</a> &nbsp; &nbsp;<a href="#" style="color:green" onclick="window.print();">Print</a> &nbsp; &nbsp;
        <span class="dropdown pull-left">
          <a class="dropdown-toggle" data-toggle="dropdown" href="#" style="color:green">Export<span class="caret"></a> &nbsp;
        <ul class="dropdown-menu">
          <li><a href="<?php echo base_url() ?>Export/ExportExcelStockStatusReport?StartDate=<?php echo $this->input->get('StartDate') ?>&EndDate=<?php echo $this->input->get('EndDate'); ?>&LocationId=<?php echo $this->input->get('LocationId'); ?>&ProductId=<?php echo $this->input->get('ProductId'); ?>">Excel</a></li>
<!--          <li><a href="<?php // echo base_url()?>Export/ExportWordSaleDetailReport?StartDate=<?php // echo $this->input->get('StartDate') ?>&EndDate=<?php // echo $this->input->get('EndDate'); ?>">Word</a></li> -->
</ul>
          </span> &nbsp; </span>
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

<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Send Email</h4>
        <p id="msg" style="text-align: center;">
          <img id="loader" src="<?php echo base_url(); ?>lib/img/loader.gif" style="display: none;" />
        </p>
      </div>
      <div class="modal-body">
        <div class="form-group">
          <label for="Password" class="col-sm-3 control-label"><b>From:</b></label>
          <div class="col-sm-8">
              <span class=""><?php echo $this->session->userdata('EmployeeName') . " ( " . $this->session->userdata('UserName') . " ) " ; ?></span>
          </div>
        </div> <br><br>

        <div class="form-group">
          <label for="Password" class="col-sm-3 control-label"><b>Receipent:</b></label>
          <div class="col-sm-8">
            <select name="EmployeeId[]" id="EmployeeId" class="form-control js-example-basic-multiple" multiple="multiple" style="width: 100%">
              <option value="">Select Recipient</option>
               <?php foreach ($AllEmployees as $row) { ?>
               <option value="<?php  echo $row['EmailAddress']; ?>"><?php echo $row['EmailAddress']; ?></option>
               <?php } ?>
               <option value="sarmadsoomro94@gmail.com">sarmadsoomro94@gmail.com</option>
              </select><span>If not in the list click here. &nbsp; &nbsp;<i class="fa fa-plus" style="cursor: pointer;" id="Show"></i></span>
          </div>
        </div> <br /><br />
        <div class="form-group">
          <label for="OtherEmployee" class="col-sm-3 control-label"><b></b></label>
          <div class="col-sm-8">
                <input type="email" name="OtherEmployee" id="OtherEmployee" class="form-control" required="required" placeholder="Enter new email here" style="display: none;" >
          </div>
        </div> <br /><br />
        <input type="hidden" name="StartDate" id="StartDate" value="<?php echo $this->input->get('StartDate'); ?>">
        <input type="hidden" name="EndDate" id="EndDate" value="<?php echo $this->input->get('EndDate'); ?>">
<div class="form-group">
          <label for="Subject" class="col-sm-3 control-label"><b>Subject:</b></label>
          <div class="col-sm-8">
                <input type="text" name="Subject" id="Subject" class="form-control" required="required" value="Sale Report from: <?php echo date('M d, Y', strtotime($this->input->get('StartDate')));?> To <?php echo date('M d, Y', strtotime($this->input->get('EndDate')));?> ">
          </div>
        </div> <br /><br />

                <div class="form-group">
                <label for="Comments" class="col-sm-3 control-label"><b>Comments:</b></label>
                <div class="col-sm-8">
                <textarea name="Comments" id="Comments" class="form-control" rows="4" cols="45"></textarea>
                </div>
              </div> <br> <br>

      </div><br /><br><br>
      <div class="modal-footer">
        <button type="button" id="Submit" class="btn btn-primary">Submit</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>

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
  $(function(){
    $("#Submit").on('click', function(){
      var EmployeeId = $("#EmployeeId").val();
      var OtherEmployee = $("#OtherEmployee").val();
      var Subject = $("#Subject").val();
      var Comments = $("#Comments").val();
      var Message = $("#Message").val();
      var StartDate = $("#StartDate").val();
      var EndDate = $("#EndDate").val();

      $.ajax({
        url: '<?php echo base_url(); ?>SendEmail/SendSaleDetailReport',
        data: {EmployeeId:EmployeeId,OtherEmployee:OtherEmployee,Subject:Subject,Comments:Comments,Message:Message,StartDate:StartDate,EndDate:EndDate},
        type: 'post',
        dataType: 'html',

        beforeSend: function(){
        $("#loader").css('display', 'inline');
        },
      success:function(data){
        $("#loader").css('display', 'none');
        $('input').val('');
        $('textarea').val('');
        $("#msg").html(data)
        }
      })
    })
  })
</script>

<script>
  $(document).ready(function() {
    $('.js-example-basic-multiple').select2();
});
</script>