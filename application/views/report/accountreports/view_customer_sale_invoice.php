<link rel="stylesheet" href="<?php echo base_url(); ?>bootstrap/css/bootstrap.min.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>lib/css/font-awesome/font-awesome.min.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>lib/css/IMS.min.css">
    
    <div class="col-md-12">
      <!-- form elements --> 
      <div class="box-info">
	  <div class="box-header with-border" style="text-align: center; font-size: 22px; font-weight: 600;">Customer Sale Invoice Detail
	  </h3>
	</div>
      <div class="box-body">
       <div class="row invoice-info">
        <div class="col-sm-3 invoice-col">
          <address style="font-size:13px;">
            <strong>Invoice #:</strong><br>
	     <?php echo 'SI '.$Sales->SaleId; ?>
          </address>
        </div>
	<div class="col-sm-3 invoice-col">
          <address style="font-size:13px;">
            <strong>Customer:</strong><br>
	     <?php echo $Sales->CustomerName; ?>
          </address>
        </div>   
	<div class="col-sm-3 invoice-col">
          <address style="font-size:13px;">
            <strong>Sale Date:</strong><br>
            <?php echo date('M d, Y',strtotime($Sales->SaleDate)); ?>
          </address>
        </div>
	<div class="col-sm-3 invoice-col">
          <address style="font-size:13px;">
            <strong>Sale Mode:</strong><br>
	     <?php echo $Sales->SaleMethod; ?>
          </address>
        </div>
        <div class="col-sm-6 invoice-col">
          <address style="font-size:13px;">
	    <strong>Note:</strong><br>
	     <?php echo $Sales->SaleNote; ?>
          </address>
        </div> 
       </div>
      </div>
      <div class="row">
        <div class="col-md-12">   
          <div class="box-body pad table-responsive">
            <table class="table table-bordered text-center">
              <thead>
               <tr style="background-color:#ECF9FF; font-size:15px;">
	        <th style="padding:3px; width:3%;">S.#</th>
		
		<th style="padding:5px; width:10%; text-align: center;">Barcode</th>
		<th style="padding:5px; width:10%; text-align: center;">Item</th>
		<th style="padding:5px; width:10%; text-align: center;">Location</th>
		<th style="padding:5px; width:5%; text-align: center;">Color</th>
		<th style="padding:5px; width:10%; text-align: center;">Rate</th>
		<th style="padding:5px; width:5%; text-align: center;">Qty</th>
		<th style="padding:5px; width:10%; text-align: center;">Amount</th>
		<th style="padding:5px; width:10%; text-align: center;">Dis: Amt</th>
		<th style="padding:5px; width:10%; text-align: center;">Tax %</th>
		<th style="padding:5px; width:10%; text-align: center;">Tax Amount</th>
		<th style="padding:5px; width:10%; text-align: center;">Net Amount</th>
	       </tr>
	      </thead>
	       <?php
	        $SNo = 1; 
	        $Quantity = 0;
		$Amount = 0;
		$DiscountAmount = 0;
		$TaxAmount = 0;
		$NetAmount = 0;
	        foreach($SalesDetail as $Record) {
	       ?>
	       <tr style="font-size:13px;">
		<td style="text-align:center;"><?php echo $SNo; ?></td>
		<td style="text-align:left;"><?php echo $Record['ProductBarCode'];?></td>
		<td style="text-align:left;"><?php echo $Record['ProductName'];?></td>
		<td style="text-align:left;"><?php echo $Record['LocationName'];?></td>
		<td style="text-align:left;"><?php echo $Record['ColourName'];?></td>
		<td style="text-align:center;"><?php echo $Record['Rate'];?></td>
		<td style="text-align:center;"><?php echo $Record['Quantity'];?></td>
		<td style="text-align:center;"><?php echo $Record['Amount'];?></td>
		<td style="text-align:center;"><?php echo $Record['DiscountAmount'];?></td>
		<td style="text-align:center;"><?php echo $Record['TaxPercentage'];?></td>
		<td style="text-align:center;"><?php echo $Record['TaxAmount'];?></td>
		<td style="text-align:center;"><?php echo $Record['NetAmount'];?></td>
	       </tr>
	       <?php 
	       $SNo++; 
	        $Quantity += $Record['Quantity'];
          $Amount += $Record['Amount'];
          $DiscountAmount += $Record['DiscountAmount'];
          $TaxAmount += $Record['TaxAmount'];
	        $NetAmount += $Record['NetAmount'];
		} ?>
            </table>
	    <table class="table" border="0">
	    <tbody>
	    <tr style="font-size:13px;">
		<td colspan="12" style="width: 93%; text-align:right; font-weight:600; border: 0px solid;">Total Quantity:</td>
		<td><div id="Quantity" style='font-weight:600; text-align:right; color:#008000;'><?php echo number_format($Quantity,2,'.',''); ?></div></td>
	    </tr>
	    <tr style="font-size:13px;">
	      <td colspan="12" style="width: 90%; text-align:right; font-weight:600; border: 0px solid;">Total Amount:</td>
	      <td><div id="Amount" style='font-weight:600; text-align:right; color:#008000;'><?php echo number_format($Amount,2,'.',''); ?></div></td>
	    </tr>
	    <tr style="font-size:13px;">
	      <td colspan="12" style="width: 90%; text-align:right; font-weight:600; border: 0px solid;">Total Discount:</td>
	      <td><div id="DiscountAmount" style='font-weight:600; text-align:right; color:#008000;'><?php echo number_format($DiscountAmount,2,'.',''); ?></div></td>
	    </tr>
	    <tr style="font-size:13px;">
	      <td colspan="12" style="width: 90%; text-align:right; font-weight:600; border: 0px solid;">Tax Amount:</td>
	      <td><div id="TaxAmount" style='font-weight:600; text-align:right; color:#008000;'><?php echo number_format($TaxAmount,2,'.',''); ?></div></td>
	    </tr>
	    <tr style="font-size:13px;">
	      <td colspan="12" style="width: 90%; text-align:right; font-weight:600; border: 0px solid;">Total Net Amount:</td>
	      <td><div id="NetAmount" style='font-weight:600; text-align:right; color:#008000;'><?php echo number_format($NetAmount,2,'.',''); ?></div></td>
	    </tr>
	      </tbody>
	     </table>
	  </div>
        </div>
      </div>
      </div>
    </div>