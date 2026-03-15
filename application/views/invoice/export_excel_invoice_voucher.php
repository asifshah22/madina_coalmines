<?php 

header("Content-type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename = Invoice Voucher.xls");
?>

<link rel="stylesheet" href="<?php echo base_url(); ?>bootstrap/css/bootstrap.min.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>lib/css/font-awesome/font-awesome.min.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>lib/css/pos.min.css">

<div class="col-md-12">
      <!-- form elements --> 
  <div class="box box-info">
  <div class="box-header with-border">
    <h3 class="box-title text-light-blue">Voucher</h3>
  </div>
      <div class="box-body">
       <div class="row invoice-info">
        <div class="col-sm-6 invoice-col">
		<div class="col-sm-6 invoice-col">
		  <address>
		    <strong>Invoice #:</strong><br>
		    <span style="color:#3333CC; font-size:13px; font-weight:bold;"><?php echo $InvoiceView[0]['InvoiceNumber']; ?></span>
		  </address>
		</div>
		 <div class="col-sm-6 invoice-col">
		  <address>
		    <strong>Sale Order #:</strong><br>
		    <span style="color:#800000; font-size:13px; font-weight:bold;"><?php echo $InvoiceView[0]['SaleOrderNumber']; ?></span>
		  </address>
		</div>
		<div class="col-sm-6 invoice-col">
		  <address>
		    <strong>Invoice Date:</strong><br>
		    <?php print date('M d, Y', strtotime($InvoiceView[0]['InvoiceDate'])); ?>
		  </address>
		</div>
		<div class="col-sm-6 invoice-col">
		  <address>
		    <strong>Due Date:</strong><br>
    		    <?php print date('M d, Y', strtotime($InvoiceView[0]['DueDate'])); ?>
		  </address>
		</div>
		<div class="col-sm-6 invoice-col">
		  <address>
		    <strong>Vehicle No:</strong><br>
		    <?php echo $InvoiceView[0]['VehicleNumber']; ?>
		  </address>
		</div>
		<div class="col-sm-6 invoice-col">
		  <address>
		    <strong>Frieght Outward Charges:</strong><br>
		    <?php echo 'Rs. '.number_format($InvoiceView[0]['FrieghtOutwardCharges'],0); ?>
		  </address>
		</div>
		<div class="col-sm-6 invoice-col">
		  <address>
		    <strong>Customer:</strong><br>
		    <?php echo $InvoiceView[0]['CustomerName']; ?>
		  </address>
		</div>
		
	      </div>
	      <?php
		if(isset($InvoiceDetailView)) {
		$SNo=1;
		$TotalWeight = 0;
		$TotalAmount = 0;
		$TotalDiscount = 0;
		$TotalGSTAmount = 0;
		$TotalFEDAmount = 0;
		$TotalFurtherTaxAmount = 0;
		$TotalNetAmount = 0;
	      ?>
	      <div class="row">
		<div class="col-md-12">
		  <div class="box-body pad table-responsive">
		    
		    <table class="table table-bordered text-center" id="delTable">
		     <tr style="background-color:#ECF9FF;">
		       <th style="padding:5px;">S.#</th>
		       <th style="padding:5px;">Product Name</th>
		       <th style="padding:5px;">Quality</th>
		       <!--<th style="padding:5px;">Order Qty</th> -->
		       <th style="padding:5px;">Reel Size</th>
		       <th style="padding:5px;">Supply Qty</th>
		       <th style="padding:5px;">Weight in KG</th>
		       <th style="padding:5px;">Rate / KG</th>
		       <th style="padding:5px;">Amount</th>
		       <th style="padding:5px;">GST %</th>
		       <th style="padding:5px;">GST Amount</th>
		       <th style="padding:5px;">F.Tax %</th>
		       <th style="padding:5px;">F.Tax Amt</th>
		       <th style="padding:5px;">FED %</th>
		       <th style="padding:5px;">FED Amount</th>
		       <th style="padding:5px;">Net Amount</th>
		 
		     </tr>
		     <?php
		    		
		     foreach($InvoiceDetailView as $Record) 
		     {
		     /*  Sales Order product quantity minus cancel quantity */
		     $SalesOrderQuantity = 0;

		     /* gets remaining invoice / bill quantities */ 
		     $RemainingInvoiceQuantity = 0;

		     $BillQuantity = $SalesOrderQuantity - $RemainingInvoiceQuantity;

		     ?>
		     <tr>
		      <td style='padding:5px; width:2%;'><?php echo $SNo; ?></td>		      
		      <td style='padding:5px; width:10%; text-align:left;'><?php echo $Record["ProductName"]; ?></td>
		      <td style='padding:5px; width:10%; text-align:left;'><?php echo $Record["ProductQuality"]; ?></td>
		      <!-- <td style='padding:5px; width:8%; text-align:right;'><input type="text" style="width:100%; background:transparent; border:none; font-size:13px;" name="OrderQty" id="OrderQty_<?php echo $SNo;?>" value="<?php // echo $Record["Quantity"]; ?>"></td> -->
		      <td style='padding:5px; width:7%; text-align:right;'><?php echo $Record["ReelSize"]; ?></td>
		      
		      <td style='padding:5px; width:7%; text-align:right;'><?php echo $Record["SupplyQuantity"]; ?></td>
		      
		    <?php
		   	?>
		    <td style='padding:5px; width:7%; text-align:right;'><?php echo $Record["Weight"]; ?></td>
		    <td style="padding:5px; width:5%; text-align:right;"><?php echo $Record["Rate"]; ?></td>
		    <td style="padding:5px; width:8%; text-align:right;"><?php echo $Record["Amount"]; ?></td>
		    <td style='padding:5px; width:7%; text-align:right;'><?php echo $Record["GST"]; ?></td>
		    <td style='padding:5px; width:7%; text-align:right;'><?php echo number_format($Record["GSTAmount"],2); ?></td>
		    <td style='padding:5px; width:7%; text-align:right;'><?php echo isset($Record["FurtherTaxRate"]) ? $Record["FurtherTaxRate"] : 0; ?></td>
		    <td style='padding:5px; width:7%; text-align:right;'><?php echo number_format(isset($Record["FurtherTaxAmt"]) ? $Record["FurtherTaxAmt"] : 0,2); ?></td>
		    <td style='padding:5px; width:7%; text-align:right;'><?php echo $Record["FED"]; ?></td>
		    <td style='padding:5px; width:7%; text-align:right;'><?php echo number_format($Record["FEDAmount"],2); ?></td>
		    <td style='padding:5px; width:7%; text-align:right;'><?php echo number_format($Record["NetAmount"],2); ?></td>
		    </tr>
		    <?php
		     $TotalWeight += $Record["Weight"];
		     $TotalAmount += $Record["Amount"]; 
		     $TotalGSTAmount += $Record["GSTAmount"];
		     $TotalFurtherTaxAmount += isset($Record["FurtherTaxAmt"]) ? $Record["FurtherTaxAmt"] : 0;
		     $TotalFEDAmount += $Record["FEDAmount"];
		     $TotalNetAmount += $Record["NetAmount"];
		    
		    $SNo++;
		    } } ?>
		    <tr>
		    <td colspan="5" style="text-align:right; font-weight:600;"></td>
		    <td style="text-align:right; font-weight:600;"><?php echo number_format($TotalWeight,0); ?></td>
		    <td colspan="8" style="text-align:right; font-weight:600;">Total Amount:</td>
		    <td style="text-align:right; color:#3333CC; font-weight:600;"><?php echo number_format($TotalAmount,2); ?></td>
		    </tr>
		    <tr>
		    <td colspan="14" style="text-align:right; font-weight:600;">Total GST Amount:</td>
		    <td style="text-align:right; font-weight:600;"><?php echo number_format($TotalGSTAmount,2); ?></td>
		    
		    </tr>
		    <tr>
		    <td colspan="14" style="text-align:right; font-weight:600;">Total Further Tax Amount:</td>
		    <td style="text-align:right; font-weight:600;"><?php echo number_format($TotalFurtherTaxAmount,2); ?></td>
		    </tr>
		    <tr>
		    <td colspan="14" style="text-align:right; font-weight:600;">Total FED Amount:</td>
		    <td style="text-align:right; font-weight:600;"><?php echo number_format($TotalFEDAmount,2); ?></td>
		    </tr>
		     <td colspan="14" style="text-align:right; font-weight:600;">Total Net Amount:</td>
		     <td style="font-weight:600; color:#008000; text-align:right;"><?php echo number_format($TotalNetAmount,2); ?></td>
		   
		    </tr>
		    </table>
		  </div>
		</div>
	      </div>
	    	
	      <div class="box-body">
		<div class="row">
		 
		  <div class="col-md-12">
		    <div class="form-group">
		      <label for="InvoiceNote" class="col-sm-2 control-label">Invoice Note:</label>
			<div class="input-group">
			    <?php echo $InvoiceView[0]['InvoiceNote']; ?>
		      </div>
		    </div>
		  </div>
		 
		</div>
	      </div>
            </div>
            </form>
        </div>
      </div>
    </div> 
  </section>
  </div>
