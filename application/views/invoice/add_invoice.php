<?php 
$this->load->view('includes/header');
$this->load->view('includes/sidebar');
?> 
<script>
    $(function(){	
	
    $('body').on("keyup",".txtMult input", multInputs);
    
       function multInputs() {
	     
	    var TotalAmount = 0;
	    var TotalGSTAmount = 0;
	    var TotalFEDAmount = 0;
	    var TotalWeight = 0;
	   //   var TotalDiscountAmount = 0;
	    var GTotal = 0;
	
           // following code works on each individual text field value changed like discount or calculating total amount and for each row:
           $("tr.txtMult").each(function () {
               
            // get the values from this row and calculating Amount and Total Amount
            var $Weight = $('.Weight', this).val();
            var $Rate = $('.Rate', this).val();
	    var $GST = $('.GST', this).val();
	    
	    var $Amount = ($Weight * 1) * ($Rate * 1)
	    
	    TotalWeight += ($Weight * 1);
	    TotalAmount += $Amount;
	    // Calculating GST amount
	    var $GSTAmount = (($Amount * $GST) / 100);
	    $('.GSTAmount',this).val($GSTAmount);
	    TotalGSTAmount += $GSTAmount;
	    
	    // Calculating GST amount
            var $FED = $('.FED', this).val();
	    var $FEDAmount = (($Amount * $FED) / 100);
	    $('.FEDAmount',this).val($FEDAmount);
	    TotalFEDAmount += $FEDAmount;

	    var $DiscountAmount = 0;

            // This is for hidden text value of total amount
            $('.Amount',this).val($Amount.toFixed(2));
            // This is for div value of total amount
            //$('.Amount',this).text($Amount.toFixed(2));
            // Sum of total quantity
	  
	    
	    $('.NetAmount',this).val((($Amount + ($GSTAmount * 1) + ($FEDAmount * 1)) - ($DiscountAmount * 1)).toFixed(2));
            GTotal += ($Amount + ($GSTAmount * 1) + ($FEDAmount * 1) - ($DiscountAmount * 1));
	   // GTotal += ($Amount + ($GSTAmount * 1) + ($FEDAmount * 1) - ($DiscountAmount * 1));
	    
           });
		
      
//	    $("#FrieghtOutwardCharges").val(FrieghtOutwardCharges.toFixed(2));
	    $("#TotalWeight").val(TotalWeight.toFixed(2));
	    $("#TotalGSTAmount").val(TotalGSTAmount.toFixed(2));	   
            $("#TotalFEDAmount").val(TotalFEDAmount.toFixed(2));
	  //  $("#TotalDiscountAmount").val(TotalDiscountAmount.toFixed(2));
            $("#TotalAmount").val(TotalAmount.toFixed(2));
            $("#TotalNetAmount").val((GTotal).toFixed(2));
       } 
       
  });
</script>
 <script type="text/javascript">
  $(function()
  {
       // remove row
       $(document).on('mouseover','span[id^=remove]',function(){
       $(this).css({"cursor":"pointer"}); 
       });
        
       $(document).on('click','span[id^=remove]',function(){
       removeId = $(this).attr('id');
       arr = removeId.split("_");
       
       // parent.fadeOut('slow', function() {$(this).remove();});
       // $(this).parent().parent().fadeOut('slow')
        $(this).parent().parent().remove()
       })
  });
 </script>
 <script>
     $(document).ready(function () {
           
        $("#SaveAsDraft").click(SaveAsDraftBtn);  
	    function SaveAsDraftBtn() {	
            StatusInvoiceVal = '1';
	    $("#StatusInvoice").val(StatusInvoiceVal);
	    }
                
        $("#SaveAndSubmit").click(SaveAsConfirmBtn);  
	    function SaveAsConfirmBtn() {
            StatusInvoiceVal = '2';
            $("#StatusInvoice").val(StatusInvoiceVal);
            }
	    
	 });
</script>
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1><i class="fa fa-edit"></i>&nbsp;Sale Invoice</h1>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-md-12">
          <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title text-light-blue">Add Sale Invoice</h3>
            </div>
	    <?php echo "<font style=color:#00468E; font-weight:bold text-align:center;>".$this->session->flashdata('record_update')."</font>"; ?>
	    
           <form role="form" id="InvoiceForm" action='<?php echo base_url("Invoice/SaveInvoice") ?>' method="post">
	   <input name="SaleOrderId" type="hidden" value="<?php print $SalesOrder[0]['SaleOrderId']; ?>">
	    
	    <div class="box-body">
	      <div class="row invoice-info">
		<div class="col-sm-6 invoice-col">
		  <address>
		    <strong>Invoice #:</strong><br>
		    <span style="color:#3333CC; font-size:13px; font-weight:bold;">(Auto Generated Id)</span>
		  </address>
		</div>
		 <div class="col-sm-6 invoice-col">
		  <address>
		    <strong>Sale Order #:</strong><br>
		    <span style="color:#800000; font-size:13px; font-weight:bold;"><?php echo $SalesOrder[0]['SaleOrderNumber']; ?></span>
		  </address>
		</div>
		<div class="col-sm-6 invoice-col">
		  <address>
		    <strong>Invoice Date:</strong><br>
    		    <input class="form-control" name="InvoiceDate" id="datepicker" type="text" style="width:37%;" value="<?php echo date("m/d/Y"); ?>" autocomplete="off">
		  </address>
		</div>
		<div class="col-sm-6 invoice-col">
		  <address>
		    <strong>Due Date:</strong><br>
		    <input class="form-control" name="DueDate" id="datepicker2" type="text" style="width:37%;" value="<?php echo date("m/d/Y"); ?>" autocomplete="off">
		  </address>
		</div>
		<div class="col-sm-6 invoice-col">
		  <address>
		    <strong>Vehicle No:</strong><br>
		    <input name="VehicleNumber" type="text" autocomplete="off">
		  </address>
		</div>
		<div class="col-sm-6 invoice-col">
		  <address>
		    <strong>Frieght Outward Charges:</strong><br>
		    <input name="FrieghtOutwardCharges" type="text" class="FrieghtOutwardCharges" autocomplete="off">
		  </address>
		</div>
		<div class="col-sm-6 invoice-col">
		  <address>
		    <strong>Customer:</strong><br>
		    <?php echo @$SalesOrder[0]['CustomerName']; ?>
		    <input name="CustomerId" type="hidden" value="<?php print @$SalesOrder[0]['CustomerId']; ?>">
		    <input name="CustomerName" type="hidden" value="<?php print @$SalesOrder[0]['CustomerName']; ?>">
		  </address>
		</div>	
	      </div>
	      <?php
		 
	      //echo '<pre>';
	      //print_r($GetProductRate);
	      
	      //die;
	      
	       if(empty($GetProductRate[0])){
	     	echo "<p style='text-align:center'><b>No Product rate is defined for this customer. Please define <a href='../../ProductRates/'> Product Rate </a></b></p>";
//		     die();
		 	}
		else{
		if(isset($SalesOrderDetail)) {
		$SNo=1;
	
		$TotalAmount = '';
		$TotalDiscount = '';
	      ?>
	      <div class="row">
		<div class="col-md-12">
		  <div class="box-body pad table-responsive">
		    
		    <table class="table table-bordered text-center" id="delTable">
		     <tr style="background-color:#ECF9FF;">
		       <th style="padding:5px;">S.#</th>
		       <th style="padding:5px;">Product Name</th>
		       <th style="padding:5px;">Quality</th>
		       <th style="padding:5px;">Order Qty</th>
		       <th style="padding:5px;">Reel Size</th>
		       <th style="padding:5px;">Supply Qty</th>
		       <th style="padding:5px;">Weight (KG)</th>
		       <th style="padding:5px; width:7%;">Rate / KG</th>
		       <th style="padding:5px;">Amount</th>
		       <th style="padding:5px;">GST %</th>
		       <th style="padding:5px;">GST Amount</th>
		       <th style="padding:5px;">FED %</th>
		       <th style="padding:5px;">FED Amount</th>
		       <th style="padding:5px;">Net Amount</th>
		      <th style='padding:5px; text-align:center;'><span class='fa fa-trash'></span></th>
		     </tr>
		     <?php	
		     
		    
		     if(!empty($SalesOrderDetail))
		     {	     
		     foreach($SalesOrderDetail as $Record) 
		     {
			
		     /*  Sales Order product quantity minus cancel quantity  */
		     $SalesOrderQuantity = 0;
		     $PreviousInvoiceQty = 0;
		     $SupplyQuantity =0;
		     $Rate = 0;
		     
		    if($Invoice)
			{
		     for($i=0; $i < count($Invoice); $i++)
		     {
			if($Invoice[$i]['ProductId'] == $Record["ProductId"] && $Invoice[$i]['ReelSize'] == $Record["ReelSize"])
			{
			    $PreviousInvoiceQty += $Invoice[$i]['SupplyQuantity'];
			}		
		
			$SupplyQuantity = $Record["Quantity"] - $PreviousInvoiceQty;
		    }
			}
			else{
				$SupplyQuantity = $Record["Quantity"];
			}
			
			if ($GetProductRate) {
			
			for($i=0; $i < count($GetProductRate); $i++)
		     	{
					
					if($GetProductRate[$i][0]['ProductId'] == $Record['ProductId']){
					$Rate = $GetProductRate[$i][0]['Rate'];
					}
					else
					 {
						$Rate += "0";
					}
					
				}
			}
		     
			
		     for($a=0; $a<$SupplyQuantity; $a++) {
		     ?>
		     <tr class="txtMult">
		      <td style='padding:5px; width:2%;'><?php echo $SNo; ?></td>		      
		      <td style='padding:5px; width:10%; text-align:left;'>
		      <a id="ViewWeight" value="<?php echo $Record["ProductId"]; ?>" name="<?php echo $SNo; ?>" href="javascript:void()"><?php echo $Record["ProductName"]; ?></a>
		      <input type="hidden" name="ProductId[]" id="ProductId_<?php echo $SNo; ?>" value="<?php echo $Record["ProductId"]; ?>">
		      <input type="hidden" name="ProductName[]" value="<?php echo $Record["ProductName"]; ?>">
		      </td>
		      <td style='padding:5px; width:8%; text-align:left;'>
		      <?php echo $Record["ProductQuality"]; ?>
		      <input type="hidden" name="ProductQualityId[]" id="ProductQualityId_<?php echo $SNo; ?>" value="<?php echo $Record["ProductQualityId"]; ?>">
		      <input type="hidden" name="ProductQuality[]" value="<?php echo $Record["ProductQuality"]; ?>">
		      </td>
		      <td style='padding:5px; width:7%; text-align:right;'><input type="text" style="width:100%; background:transparent; border:none; font-size:13px; text-align:right;" name="OrderQty" id="OrderQty_<?php echo $SNo;?>" value="<?php echo $Record["Quantity"]; ?>"></td>
		      <td style='padding:5px; width:6%;'><input type="number" style="width:100%; background:transparent; border:none; text-align:right;" name="ReelSize[]" id="ReelSize_<?php echo $SNo;?>" value="<?php echo $Record["ReelSize"]; ?>" readonly="readonly"></td>
		      
		      <td style='padding:5px; width:7%;'><input type="number" min="0" style="width:100%; text-align:right;" name="SupplyQuantity[]" class="SupplyQuantity" id="SupplyQuantity_<?php echo $SNo; ?>" value="<?php echo 1; //$Record["Quantity"]; ?>" autocomplete="off"></td>
		      
		     <?php
		     /* foreach($ProductSoldQtyInStock as $SoldQtyInStock)
		     {
			$ProductSoldId = $SoldQtyInStock['ProductId'];
			$ProductSoldQty = $SoldQtyInStock['Quantity'];
			$ProductSoldBatchId = $SoldQtyInStock['BatchNumberId'];
			$ProductSoldBatchNumber = $SoldQtyInStock['BatchNumber'];

			if($PurchaseQtyInStockRecord['ProductId'] == $ProductSoldId && $PurchaseQtyInStockRecord['BatchNumberId'] == $ProductSoldBatchId)
			{			    
			    $RemainingStockQty = ($PurchaseQtyInStockRecord['Quantity'] - $ProductSoldQty);		   
			    $Amount = $BillQuantity * $Rate;
			}
		     }
		     */
		   ?>
		    <!-- <td style='padding:5px; width:8%;'><input readonly="readonly" type="number" min="0" style="width:100%; font-weight:500; color:#3333CC; background:transparent; border:none; text-align:right;" name="StockQuantity[]" class="Quantity" id="StockQuantity_<?php echo $SNo; ?>" value="<?php // echo $RemainingStockQty; ?>"></td> -->
		    <td style='padding:5px; width:7%;'><input type="number" step="0.01" style="width:100%; text-align:right;" name="Weight[]" class="Weight" id="Weight_<?php echo $SNo; ?>" autocomplete="off"></td>
		    <td style="padding:5px; width:4%;"><input type="number" step="0.01" style="width:100%; text-align:right;" name="Rate[]" class="Rate" id="Rate_<?php echo $SNo; ?>" value="<?php echo $Rate; ?>" autocomplete="off"></td>
		    <td style="padding:5px; width:7%;"><input type="number" step="0.01" readonly="readonly" style="width:100%; text-align:right;" name="Amount[]" id="Amount_<?php echo $SNo; ?>" class="Amount"></td>
		    <!-- <td style='padding:5px; width:7%;'><input type="number" min="0" style="width:100%; text-align:right;" name="DiscountAmount[]" class="DiscountAmount" id="DiscountAmount_<?php echo $SNo; ?>" value="" autocomplete="off"></td> -->
		    <td style='padding:5px; width:7%;'><input type="number" min="0" step="0.01" style="width:100%; text-align:right;" name="GST[]" class="GST" id="GST_<?php echo $SNo; ?>" value="" autocomplete="off"></td>
		    <td style='padding:5px; width:7%;'><input type="number" min="0" step="0.01" style="width:100%; text-align:right;" name="GSTAmount[]" class="GSTAmount" id="GSTAmount_<?php echo $SNo; ?>"></td>
		    <td style='padding:5px; width:7%;'><input type="number" min="0" step="0.01" style="width:100%; text-align:right;" name="FED[]" class="FED" id="FED_<?php echo $SNo; ?>" value="" autocomplete="off"></td>
		    <td style='padding:5px; width:7%;'><input type="number" min="0" step="0.01" style="width:100%; text-align:right;" name="FEDAmount[]" class="FEDAmount" id="FEDAmount_<?php echo $SNo; ?>"></td>
		    <td style='padding:5px; width:7%;'><input type="number" min="0" step="0.01" style="width:100%; text-align:right;" name="NetAmount[]" class="NetAmount" id="NetAmount_<?php echo $SNo; ?>"></td>
		    <td style="padding:5px; width:2%;">
		    <span style='color:red;' id="remove_<?php echo $SNo; ?>" class='fa fa-times-circle'></span>
		    </td>
		    </tr>
		    <?php
		    $SNo++;
		     }
		} } } ?>
		    <tr>
		    <td colspan="6" style="text-align:right; font-weight:600;">Total Weight:</td>
		    <td style="text-align:right;"><input style="font-weight:600; color:#3333CC; background:transparent; border:none; text-align:right;" type="text" readonly="readonly" size="8" name="TotalWeight" id="TotalWeight" value="" /></td>	
		    <td colspan="6" style="text-align:right; font-weight:600;">Total Amount:</td>
		    <td><input style="font-weight:600; color:#3333CC; background:transparent; border:none; text-align:right;" type="text" readonly="readonly" size="8" name="TotalAmount" id="TotalAmount" value="" /></td>
		    <td></td>
		    </tr>
		    <tr>
		    <td colspan="13" style="text-align:right; font-weight:600;">Total GST Amount:</td>
		    <td><input style="font-weight:600; color:#800000; background:transparent; border:none; text-align:right;" type="text" readonly="readonly" size="8" name="TotalGSTAmount" id="TotalGSTAmount" value="" /></td>
		    <td></td>
		    </tr>
		    <tr>
		    <td colspan="13" style="text-align:right; font-weight:600;">Total FED Amount:</td>
		    <td><input style="font-weight:600; color:#800000; background:transparent; border:none; text-align:right;" type="text" readonly="readonly" size="8" name="TotalFEDAmount" id="TotalFEDAmount" value="" /></td>
		    <td></td>
		    </tr>
		    <!-- <tr>
		    <td colspan="13" style="text-align:right; font-weight:600;">Frieght Outward Charges:</td>
		    <td><input style="font-weight:600; color:#800000; background:transparent; border:none;" type="text" readonly="readonly" size="8" id="FrieghtOutwardCharges" value="" /></td>
		    <td></td>
		    </tr>  -->
		    <tr>
		     <td colspan="13" style="text-align:right; font-weight:600;">Total Net Amount:</td>
		     <td style="font-weight:600; color:#008000;"><input style="font-weight:600; color:#008000; background:transparent; border:none; text-align:right;" type="text" readonly="readonly" size="8" name="TotalNetAmount" id="TotalNetAmount" value="" /></td>
		    <td></td>
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
			 <textarea name="InvoiceNote" class="form-control" rows="4" cols="70"></textarea>
		      </div>
		    </div>
		  </div>
		    
		  <!--<div class="col-md-2">
		   <button type="submit" id="SaveAsDraft" name="SaveAsDraft" value="formSave" class="btn btn-block btn-primary">Save As Draft</button>
		  </div>-->
		  <div class="col-md-2">
		   <button type="submit"  id="SaveAndSubmit" name="SaveAndSubmint" value="formSave" class="btn btn-block btn-primary">Add Record</button>
		  </div>
		  <div class="col-md-2">
		   <a href="<?php echo base_url(); ?>SaleOrder/"><button type="button" name="cancelForm" value="cancelSave" class="btn btn-block bg-orange">Cancel</button></a>
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
<?php } ?>

<script>
    $(function(){

		$('a[id^=ViewWeight]').on('click', function(){
			var PId = ($(this).attr('value'));
	  		var SNo = $(this).attr('name');
	  		var ReelSize = $("#ReelSize_"+SNo).attr('value');
      	$.ajax({
        url: '<?php echo base_url("FinishedProducts/GetFinishedProductsById/") ?>'+PId,
        type: 'post',
        dataType: 'html',
        data: {SerialNo:SNo,ReelSize:ReelSize},
        success:function(data){
        	$("#myModal").modal('show');
			$("#productDetails").html(data);
        }
	})
  })
})

      
  	$(function(){
       // Validation of Bill Quantity with Stock and Sale Order Quantity
       $('body').on("keyup", "input[id^=Quantity]", function() {
    
	  var OrderQtyId = $(this).attr('id');
          var arr = OrderQtyId.split("_")
          
	  var OrderQty = $(this).val();
          
	  var StockQty = parseInt($("#StockQuantity_"+arr[1]).val());
          var PId = parseInt($("#hdnProductId_"+arr[1]).val()); 
          var SOId = parseInt($("#SalesOrderId").val());
	  
	  if(parseInt(OrderQty) > parseInt(StockQty) )
          {
              alert("Bill quantity is greater than stock quantity");
              $(this).focus();
              return;
          }
	  $.ajax({
              url:"<?php echo base_url('Invoice/CheckSalesOrderQuntity')?>",
              type:'post',
              //dataType:"json",
              data:{ProductId:PId,ProductInvoiceQnty:OrderQty,SalesOrderId:SOId},
              success:function(RemainingQnty){
              // alert(RemainingQnty+'--'+OrderQnty);
              //$("#ChartOfAccountsCode").val(data.Code
              if(parseInt(RemainingQnty)!= 0 && parseInt(OrderQty) > parseInt(RemainingQnty))    
              alert("Bill quantity is greater than sales order quantity")
              }
             });
        });
      
       // Validation of Bill Quantity with Stock and Sale Order Quantity
      /* $('body').on("keyup", "input[id^=Quantity]", function() {
    
	  var OrderQtyId = $(this).attr('id');
          var arr = OrderQtyId.split("_")
          
	  var OrderQty = $(this).val();
          
	  var StockVal = $("#StockQuantity_"+arr[1]).val();
          var PId = $("#hdnProductId_"+arr[1]).val(); 
          var SOId = $("#SalesOrderId").val();
	  
	  // Split BatchNumber value into Quantity and its BatchNumber Id
	  var StockQtyArr = StockVal.split("-");
	  var StockQty = StockQtyArr[0]; 
	  
	  if(parseInt(OrderQty) > parseInt(StockQty) )
          {
              alert("Bill quantity is greater than stock quantity");
              $(this).focus();
              return;
          }
	  $.ajax({
              url:"<?php // echo base_url('Invoice/CheckSalesOrderQuntity')?>",
              type:'post',
              //dataType:"json",
              data:{ProductId:PId,ProductInvoiceQnty:OrderQty,SalesOrderId:SOId},
              success:function(RemainingQnty){
              // alert(RemainingQnty+'--'+OrderQnty);
              //$("#ChartOfAccountsCode").val(data.Code
              if(parseInt(RemainingQnty)!= 0 && parseInt(OrderQty) > parseInt(RemainingQnty))    
              alert("Bill quantity is greater than sales order quantity")
              }
             });
        });
	*/
	
	// Validation of Supply Quantity with Stock and Sale Order Quantity
	/* $('body').on("keyup", "input[id^=SupplyQuantity]", function() {
    
	  var OrderQtyId = $(this).attr('id');
          var arr = OrderQtyId.split("_")
          
	  var OrderQty = $(this).val();
          
	  var StockVal = $("#StockQuantity_"+arr[1]).val();
          var PId = $("#hdnProductId_"+arr[1]).val(); 
          var SOId = $("#SalesOrderId").val();
	  
	  
	  // Split BatchNumber value into Quantity and its BatchNumber Id
	  var StockQtyArr = StockVal.split("-");
	  var StockQty = StockQtyArr[0];
	  	  
	  if(parseInt(OrderQty) > parseInt(StockQty) )
          {
              alert("Supply quantity is greater than stock quantity");
              $(this).focus();
              return;
          }
	  $.ajax({
              url:"<?php //echo base_url('Invoice/CheckSalesOrderQuntity')?>",
              type:'post',
              //dataType:"json",
              data:{ProductId:PId,ProductInvoiceQnty:OrderQty,SalesOrderId:SOId},
              success:function(RemainingQnty){
              // alert(RemainingQnty+'--'+OrderQnty);
              //$("#ChartOfAccountsCode").val(data.Code
              if(parseInt(RemainingQnty)!= 0 && parseInt(OrderQty) > parseInt(RemainingQnty))    
              alert("Supply quantity is greater than sales order quantity")
              }
              });
          }); */
	});
 </script>
<script>
 $(function(){
    // check bill order quantity is greater than stock quntity 
     $("#InvoiceForm").submit(function(e){
	
	var TempProductId = 0;
        var TotalBillQuantity = 0;
	var counter = 1;

            if($("#StatusInvoice").val() !== '1')
            {
                    $("input[id^=Quantity]").each(function(){
	
                        var BillQuantity = parseInt($(this).val());		
			var BillQuantityId = $(this).attr('id');
			var arr = BillQuantityId.split('_');
			
			var ProductId = parseInt($("#hdnProductId_"+arr[1]).val());
			var StockQuantity = parseInt($("#StockQuantity_"+arr[1]).val());  // Getting Stock Quantity	
			var SaleOrderQuantity = parseInt($("#Packing_"+arr[1]).val());	    // Getting Sale Order Quantity
			var SupplyQuantity = parseInt($("#SupplyQuantity_"+arr[1]).val());
						
			if(TempProductId === ProductId)
			{
			    TotalBillQuantity += BillQuantity;
			}
			else
			{
			    TotalBillQuantity = BillQuantity;
			}

			TempProductId = ProductId;
			 
			if(isNaN(parseFloat(SupplyQuantity)))
			{
			    if(parseInt(TotalBillQuantity) > parseInt(SaleOrderQuantity))
			    {
				alert('Form can not be submitted because some of Product(s) Total Bill Quantity of Batch Wise is greater than Sale Order Quantity');
				e.preventDefault();
				$(this).focus;
			    }

			    if(parseInt(BillQuantity) > parseInt(StockQuantity))
			    {
				alert("Form can not be submitted because some of Product(s) Bill Quantity is greater than Stock Quantity");
				e.preventDefault();
				$(this).focus;
			    }
			    

			    if(parseInt(BillQuantity) > parseInt(SaleOrderQuantity))
			    {
				alert("Form can not be submitted because some of Product(s) Bill Quantity is greater than Sale Order Quantity");
				e.preventDefault();
				$(this).focus;
			    }
			}
                        counter++;
                    });
                }      
         });
    });
  
  
  
     
     $(function(){
     // check supply order quantity is greater than stock quntity 
     $("#InvoiceForm").submit(function(e){
            var counter = 1;
	    var TempProductId = 0;
	    var TotalSupplyQuantity = 0;
	   	 
            if($("#StatusInvoice").val() !== '1')
            {
		$("input[id^=SupplyQuantity]").each(function(){
		
		var SupplyQuantity = parseInt($(this).val());
		var SupplyQuantityId = $(this).attr('id');
		var arr = SupplyQuantityId.split('_');	
		
		var ProductId = parseInt($("#hdnProductId_"+arr[1]).val());
		var StockQuantity = parseInt($("#StockQuantity_"+arr[1]).val());
		var SaleOrderQuantity = parseInt($("#Packing_"+arr[1]).val()); // Getting Sale Order Quantity
		
		if(TempProductId === ProductId)
		{
		    TotalSupplyQuantity += SupplyQuantity;
		}
		else
		{
		    TotalSupplyQuantity = SupplyQuantity;
		}

		TempProductId = ProductId;
			
		if(parseInt(TotalSupplyQuantity) > parseInt(SaleOrderQuantity))
		{
		    alert('Form can not be submitted because some of product(s) Total Supply quantity of batch wise is greater than Sale order quantity');
		    e.preventDefault();
		    $(this).focus;
		}
			
		if(parseInt(SupplyQuantity) > parseInt(StockQuantity))
		{
		  alert("Form can not be submitted because some of product(s) Supply quantity is greater than stock quantity");
		  e.preventDefault();
		  $(this).focus;
		}

		if(parseInt(SupplyQuantity) > parseInt(SaleOrderQuantity))
		{
		    alert("Form can not be submitted because some of product(s) Supply quantity is greater than Sale Order quantity");
		    e.preventDefault();
		    $(this).focus;
		}
		counter++;	
	     });
	   }         
        });
    });
    
    
    
   /* $(function(){
     $("#InvoiceForm").submit(function(e){
            var counter = 1;
	    var TempProductId = 0;
	    var TotalSupplyQuantity = 0;
	   	 
            if($("#StatusInvoice").val() !== '1')
            {
		$("input[id^=SupplyQuantity]").each(function(){
		
		var SupplyQuantity = parseInt($(this).val());
		var SupplyQuantityId = $(this).attr('id');
		var arr = SupplyQuantityId.split('_');	
		
		var ProductId = parseInt($("#hdnProductId_"+arr[1]).val());
		var StockQuantity = parseInt($("#StockQuantity_"+arr[1]).val());
		var SaleOrderQuantity = parseInt($("#Packing_"+arr[1]).val()); // Getting Sale Order Quantity
		
		if(TempProductId === ProductId)
		{
		    TotalSupplyQuantity += SupplyQuantity;
		}
		else
		{
		    TotalSupplyQuantity = SupplyQuantity;
		}

		TempProductId = ProductId;
			
		if(parseInt(TotalSupplyQuantity) > parseInt(SaleOrderQuantity))
		{
		    alert('Form can not be submitted because some of product(s) Total Supply quantity of batch wise is greater than Sale order quantity');
		    e.preventDefault();
		    $(this).focus;
		}
			
		if(parseInt(SupplyQuantity) > parseInt(StockQuantity))
		{
		  alert("Form can not be submitted because some of product(s) Supply quantity is greater than stock quantity");
		  e.preventDefault();
		  $(this).focus;
		}

		if(parseInt(SupplyQuantity) > parseInt(SaleOrderQuantity))
		{
		    alert("Form can not be submitted because some of product(s) Supply quantity is greater than Sale Order quantity");
		    e.preventDefault();
		    $(this).focus;
		}
		counter++;	
	     });
	   }         
        });
    });
    */
  
  /*  $(function(){
    // check bill order quantity is greater than stock quntity 
     $("#InvoiceForm").submit(function(e){          
            var counter = 1;
            //e.preventDefault()
            if($("#StatusInvoice").val() !== 1)
            {   
                    $("input[id^=Quantity]").each(function(){
			
			
                        var OrderQnty = parseInt($(this).val());
                        var OrderQntyId = $(this).attr('id');
			var arr = OrderQntyId.split('_');
						
			var SupplyQuantity = parseInt($("#SupplyQuantity_"+arr[1]).val());
			
                        if(SupplyQuantity === '')
			{
			    var StockQnty = parseInt($("#StockQuantity_"+counter).val()); 
						
			    if(parseInt(OrderQnty) > parseInt(StockQnty))
			    {
				alert("Form can not be submitted because some of product(s) BILL quantity is greater than stock quantity");
				e.preventDefault();
				$(this).focus;
			    }
			    counter++;
			}
		    });
                }
         });
    });
    */
  
  // Make sure no Bill quantity shouldn't be zero value
  $(function(){
  
     $("#InvoiceForm").submit(function(e){          
          var counter = 1;
            $("input[id^=Quantity]").each(function(){
            var Quantity = $(this).val();
                    if(Quantity === '' || Quantity === 0)
                    {
                       alert("Sorry! Form can not be submitted because some of the Product's Bill quantity is zero");
                       e.preventDefault();
                       $(this).focus;
                    }
                counter++;
            });
         });
    });

</script>

<?php $this->load->view('includes/footer'); ?>
  
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog modal-md">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">View Product Details</h4>
        </div>
        <div class="modal-body">
          <div id="productDetails"></div>
        </div>
        <div class="modal-footer">
          <!-- <button type="submit" class="btn btn-primary" id="Submit" >Submit</button> -->	
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
</div>