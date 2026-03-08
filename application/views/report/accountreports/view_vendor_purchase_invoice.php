<link rel="stylesheet" href="<?php echo base_url(); ?>bootstrap/css/bootstrap.min.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>lib/css/font-awesome/font-awesome.min.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>lib/css/IMS.min.css">
    
    <div class="col-md-12">
      <!-- form elements --> 
      <div class="box-info">
	  <div class="box-header with-border" style="text-align: center; font-size: 22px; font-weight: 600;">Vendor Purchase Invoice Detail
	  </h3>
	</div>
      <div class="box-body">
       <div class="row invoice-info">
        <div class="col-sm-3 invoice-col">
          <address style="font-size:13px;">
            <strong>Invoice #:</strong><br>
	     <?php echo 'PI '.$Purchases->PurchaseId; ?>
          </address>
        </div>
	<div class="col-sm-3 invoice-col">
          <address style="font-size:13px;">
            <strong>Vendor:</strong><br>
	     <?php echo $Purchases->VendorName; ?>
          </address>
        </div>   
	<div class="col-sm-3 invoice-col">
          <address style="font-size:13px;">
            <strong>Purchase Date:</strong><br>
            <?php echo date("M d,Y", strtotime($Purchases->PurchaseDate)); ?>
          </address>
        </div>
	<div class="col-sm-3 invoice-col">
          <address style="font-size:13px;">
            <strong>Purchase Type:</strong><br>
	      <?php if($Purchases->PurchaseType == 1){ echo "On Cash" ; }
          else if($Purchases->PurchaseType == 2){ echo "On Credit" ; }
          else if($Purchases->PurchaseType == 3){ echo "Online" ; }
          else{ echo 'No Type Selected';  } ?>
          </address>
        </div>
        <div class="col-sm-6 invoice-col">
          <address style="font-size:13px;">
	    <strong>Note:</strong><br>
	     <?php echo $Purchases->PurchaseNote; ?>
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
		
		<th style="padding:5px; width:10%; text-align: left;">Item</th>
		<th style="padding:5px; width:10%; text-align: left;">Location</th>
		<th style="padding:5px; width:10%; text-align: left;">Color</th>
		<th style="padding:5px; width:10%;">Rate</th>
		<th style="padding:5px; width:5%;">Qty</th>
		<th style="padding:5px; width:10%;">Amount</th>
		<th style="padding:5px; width:10%;">Cash Dist:</th>
		<th style="padding:5px; width:10%;">Regular Dist:</th>
		<th style="padding:5px; width:10%;">Sale Dist:</th>
		<th style="padding:5px; width:10%;">Net Amount</th>
		<th style="padding:5px; width:20%; text-align: left;">Comments</th>
	       </tr>
	      </thead>
	       <?php
		$SNo = 1; 
		$Quantity = 0;
		$Amount = 0;
		$DiscountAmount = 0;
		$NetAmount = 0;
		  foreach($PurchaseDetail as $Record) {
		?>
	       <tr style="font-size:13px;">
		<td style="padding:5px;"><?php echo $SNo; ?></td>
		<td style='padding:5px; width:15%; text-align:left;'><?php echo $Record["ProductName"];?></td>
		<td style='padding:5px; width:8%; text-align:right;'><?php echo ($Record["LocationName"]); ?></td>
		<td style='padding:5px; width:12%; text-align:right;'><?php echo $Record["ColourName"];?></td>
		<td style='padding:5px; width:8%; text-align:right;'><?php echo number_format($Record["Rate"],2);?></td>
		<td style='padding:5px; width:8%; text-align:right;'><?php echo number_format($Record["Quantity"],2);?></td>
		<td style='padding:5px; width:8%; text-align:right;'><?php echo number_format($Record["Amount"],2);?></td>
		<td style='padding:5px; width:7%; text-align:right;'><?php echo number_format($Record["DiscountAmount"],2);?></td>
		<td style='padding:5px; width:7%; text-align:right;'><?php echo number_format($Record["RegularDiscount"],2);?></td>
		<td style='padding:5px; width:7%; text-align:right;'><?php echo number_format($Record["SaleDiscount"],2);?></td>
		<td style='padding:5px; text-align:right;'><?php echo number_format($Record["NetAmount"],2);?></td>
		<td style='padding:5px; text-align:right;'><?php echo $Record["Comments"];?></td>
	       </tr>
	        <?php
		$SNo++; 
		$Quantity += $Record['Quantity'];
		$Amount += $Record['Amount'];
		$DiscountAmount += ($Record['DiscountAmount']+$Record['RegularDiscount']+$Record['SaleDiscount']);
		$NetAmount += $Record['NetAmount'];
	        }
	       ?>
            </table>
	    <table class="table" border="0">
	    <tbody>
	    <tr style="font-size:13px;">
		<td colspan="12" style="width: 90%; text-align:right; font-weight:600; border: 0px solid;">Total Quantity:</td>
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