<?php 
$this->load->view('includes/header');
$this->load->view('includes/sidebar');

$ProductQuality = '<select name="ProductQualityId[]" class="form-control select2" style="width:100%; text-align:left;" required="required">';
$ProductQuality .= '<option value="">Select Quality</option>';
foreach ($ProductQualities as $ProductQualitiesRecord) {
$ProductQuality .= '<option value='.$ProductQualitiesRecord['ProductQualityId'].'>'.$ProductQualitiesRecord['ProductQuality'].'</option>';
}
$ProductQuality .= '</select>';

?> 
<script src="<?=site_url();?>lib/js/autocompletejs/jquery-ui.js"></script>
<script>
    $(function(){
	
    $('body').on("keyup",".txtMult input", multInputs);
    
       function multInputs() {
	     
	    var TotalAmount = 0;
	    var TotalGSTAmount = 0;
	    var TotalFEDAmount = 0;
	    var TotalWeight = 0;
	    var GTotal = 0;
	
           // following code works on each individual text field value changed like discount or calculating total amount and for each row:
           $("tr.txtMult").each(function () {
               
            // get the values from this row and calculating Amount and Total Amount
            var $Weight = $('.Weight', this).val();
            var $Rate = $('.Rate', this).val();
	    var $GST = $('.GST', this).val();
	    
	    TotalWeight += ($Weight * 1);
	    
            var $Amount = ($Weight * 1) * ($Rate * 1)
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
              <h3 class="box-title text-light-blue">Update Sale Invoice</h3>
            </div>
	    <?php echo "<font style=color:#00468E; font-weight:bold text-align:center;>".$this->session->flashdata('record_update')."</font>"; ?>
	    
           <form role="form" id="InvoiceForm" action='<?php echo base_url("Invoice/UpdateInvoice") ?>' method="post">
	   <input name="InvoiceId" type="hidden" value="<?php echo $InvoiceView[0]['InvoiceId']; ?>">
	   <input name="SaleOrderId" type="hidden" value="<?php echo $InvoiceView[0]['SaleOrderId']; ?>"> 
	   <input name="InvoiceNumber" type="hidden" value="<?php echo $InvoiceView[0]['InvoiceNumber']; ?>">
	   
	   
	    <div class="box-body">
	      <div class="row invoice-info">
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
		    <input class="form-control" name="InvoiceDate" id="datepicker" type="text" style="width:37%; height:29px;" value="<?php echo date('m/d/Y', strtotime($InvoiceView[0]['InvoiceDate'])); ?>" autocomplete="off">
		  </address>
		</div>
		<div class="col-sm-6 invoice-col">
		  <address>
		    <strong>Due Date:</strong><br>
		    <input class="form-control" name="DueDate" id="datepicker" type="text" style="width:37%; height:29px;" value="<?php echo date('m/d/Y', strtotime($InvoiceView[0]['DueDate'])); ?>" autocomplete="off">
		  </address>
		</div>
		<div class="col-sm-6 invoice-col">
		  <address>
		    <strong>Vehicle No:</strong><br>
		    <input name="VehicleNumber" type="text" value="<?php echo $InvoiceView[0]['VehicleNumber']; ?>" autocomplete="off">
		  </address>
		</div>
		<div class="col-sm-6 invoice-col">
		  <address>
		    <strong>Frieght Outward Charges:</strong><br>
		    <input name="FrieghtOutwardCharges" type="text" class="FrieghtOutwardCharges"  value="<?php echo $InvoiceView[0]['FrieghtOutwardCharges']; ?>" autocomplete="off">
		  </address>
		</div>
		<div class="col-sm-6 invoice-col">
		  <address>
		    <strong>Customer:</strong><br>
		    <?php echo $InvoiceView[0]['CustomerName']; ?>
		    <input name="CustomerId" type="hidden" value="<?php echo $InvoiceView[0]['CustomerId']; ?>">
		    <input name="CustomerName" type="hidden" value="<?php  echo $InvoiceView[0]['CustomerName']; ?>">
		  </address>
		</div>	
	      </div>
	      <?php
		if(isset($InvoiceDetailView)) {
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
		    $TotalWeight = 0;
		    $TotalAmount = 0;
		    $TotalDiscount = 0;
		    $TotalGSTAmount = 0;
		    $TotalFEDAmount = 0;
		    $TotalNetAmount = 0;
		    
		    foreach($InvoiceDetailView as $Record) 
		    {			
		    /*  Sales Order product quantity minus cancel quantity  */
		     $SalesOrderQuantity = 0;
		     $PreviousInvoiceQty = 0;
		     $SupplyQuantity =0;
		     
	     	// Following script gets Sales Order product quantity minus cancel quantity
		      for($i=0; $i < count($SalesOrderProductQuantity); $i++)
		      { 
		        if($SalesOrderProductQuantity[$i]['ProductId'] == $Record["ProductId"])
			{ 
			   $SalesOrderQuantity = $SalesOrderProductQuantity[$i]['Quantity'];
			}
		      }
		      
		     /*
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
		    else
		    {
		        $SupplyQuantity = $Record["Quantity"];
		    }
		     */
			
		   //  for($a=0; $a<$SupplyQuantity; $a++) {
		     ?>
		     <tr class="txtMult">
		      <td style='padding:5px; width:2%;'><?php echo $SNo; ?></td>		      
		      <td style='padding:5px; width:10%; text-align:left;'>
		      <?php // echo $Record["ProductName"]; ?>
		      <input type="text" class="form-control" name="ProductId[]" id="ProductId_<?php echo $SNo; ?>" autocomplete="off" value="<?php echo $Record["ProductName"]; ?>">
		    	<input type='hidden' name="hdnProductId[]" id='hdnProductId_<?php echo $SNo; ?>' value="<?php echo $Record["ProductId"]; ?>">
<!-- 		      <input type="hidden" name="ProductName[]" value="<?php // echo $Record["ProductName"]; ?>">
		      <input type="hidden" name="ProductId[]" id="ProductId_<?php // echo $SNo; ?>" value="<?php // echo $Record["ProductId"]; ?>"> -->
		      </td>
		      <td style='padding:5px; width:10%; text-align:left;'>
		      <?php echo $Record["ProductQuality"]; ?>
		      <input type="hidden" name="ProductQualityId[]" id="ProductQualityId_<?php echo $SNo; ?>" value="<?php echo $Record["ProductQualityId"]; ?>">
		      <input type="hidden" name="ProductQuality[]" value="<?php echo $Record["ProductQuality"]; ?>">
		      </td>
		    <!--  <td style='padding:5px; width:8%; text-align:right;'><input type="text" style="width:100%; background:transparent; border:none; font-size:13px; text-align:right;" name="OrderQty" id="OrderQty_<?php // echo $SNo;?>" value="<?php // echo $SalesOrderQuantity; ?>"></td>-->
		      <td style='padding:5px; width:7%;'><input type="number" step="0.01" min="0" style="width:100%; background:transparent; border:none; text-align:right;" name="ReelSize[]" value="<?php echo $Record["ReelSize"]; ?>"></td>
		      
		      <td style='padding:5px; width:7%;'><input type="number" min="0" style="width:100%; text-align:right;" name="SupplyQuantity[]" class="SupplyQuantity" id="SupplyQuantity_<?php  echo $SNo; ?>" value="<?php echo 1; //$Record["Quantity"]; ?>" autocomplete="off"></td>
		    <td style='padding:5px; width:7%;'><input type="number" step="0.01" style="width:100%; text-align:right;" name="Weight[]" class="Weight" id="Weight_<?php echo $SNo; ?>" value="<?php echo $Record['Weight']; ?>" autocomplete="off"></td>
		    <td style="padding:5px; width:5%;"><input type="number" step="0.01" style="width:100%; text-align:right;" name="Rate[]" class="Rate" id="Rate_<?php echo $SNo; ?>" value="<?php echo $Record['Rate']; ?>" autocomplete="off"></td>
		    <td style="padding:5px; width:8%;"><input type="number" step="0.01" readonly="readonly" style="width:100%; text-align:right;" name="Amount[]" id="Amount_<?php echo $SNo; ?>" value="<?php echo $Record['Amount']; ?>" class="Amount"></td>
		    <td style='padding:5px; width:7%;'><input type="number" min="0" step="0.01" style="width:100%; text-align:right;" name="GST[]" class="GST" id="GST_<?php echo $SNo; ?>" value="<?php echo $Record['GST']; ?>" autocomplete="off"></td>
		    <td style='padding:5px; width:7%;'><input type="number" min="0" step="0.001" style="width:100%; text-align:right;" name="GSTAmount[]" class="GSTAmount" id="GSTAmount_<?php echo $SNo; ?>" value="<?php echo $Record['GSTAmount']; ?>"></td>
		    <td style='padding:5px; width:7%;'><input type="number" min="0" step="0.01" style="width:100%; text-align:right;" name="FED[]" class="FED" id="FED_<?php echo $SNo; ?>" value="<?php echo $Record['FED']; ?>" autocomplete="off"></td>
		    <td style='padding:5px; width:7%;'><input type="number" min="0" step="0.001" style="width:100%; text-align:right;" name="FEDAmount[]" class="FEDAmount" id="FEDAmount_<?php echo $SNo; ?>" value="<?php echo $Record['FEDAmount']; ?>"></td>
		    <td style='padding:5px; width:7%;'><input type="number" min="0" step="0.001" style="width:100%; text-align:right;" name="NetAmount[]" class="NetAmount" id="NetAmount_<?php echo $SNo; ?>" value="<?php echo $Record['NetAmount']; ?>"></td>
		    <td style="padding:5px; width:2%;">
		    <span style='color:red;' id="remove_<?php echo $SNo; ?>" class='fa fa-times-circle'></span>
		    </td>
		    </tr>
		    <?php
		    $SNo++;
		    $TotalWeight += $Record["Weight"];
		     $TotalAmount += $Record["Amount"]; 
		     $TotalGSTAmount += $Record["GSTAmount"];
		     $TotalFEDAmount += $Record["FEDAmount"];
		     $TotalNetAmount += $Record["NetAmount"];
		    } } ?>
		    </table>
		    <table class="table table-bordered text-center">
		     <tr>
		      <td colspan="14" style=" text-align:left;"><span style="cursor:pointer;" id="addRow" class="fa fa-plus">Add Row</span></td>
		     </tr>
		     <tr>
		      <td colspan="5" style="text-align:right; width:38%; font-weight:600;">Total Weight:</td>
		      <td style="width:7%;"><div id="TotalQuantity" style='font-weight:600; color:#3333CC; text-align:right;'><?php echo number_format($TotalWeight,2); ?></div></td>
		      <td colspan="6" style="text-align:right; width:44%; font-weight:600;">Total Amount:</td>
		      <td style="text-align:right; width:7%; color:#3333CC; font-weight:600; padding-right:15px;">
			<input style="font-weight:600; color:#3333CC; background:transparent; border:none; text-align:right;" type="text" readonly="readonly" size="8" name="TotalAmount" id="TotalAmount" value="<?php echo number_format($TotalAmount,2); ?>" />
		      </td>
		      <td style="width:2.2%;"></td>
		     </tr>
		     <tr>
		      <td colspan="6" style="text-align:right; width:38%; font-weight:600;"></td>
		      <td colspan="6" style="text-align:right; width:44%; font-weight:600;">Total GST Amount:</td>
		      <td style="text-align:right; width:7%; color:#3333CC; font-weight:600; padding-right:15px;">
			<input style="font-weight:600; color:#800000; background:transparent; border:none; text-align:right;" type="text" readonly="readonly" size="8" name="TotalGSTAmount" id="TotalGSTAmount" value="<?php echo number_format($TotalGSTAmount,2); ?>" />
		      </td>
		      <td style="width:2.2%;"></td>
		     </tr>
		     <tr>
		      <td colspan="6" style="text-align:right; width:38%; font-weight:600;"></td>
		      <td colspan="6" style="text-align:right; width:44%; font-weight:600;">Total FED Amount:</td>
		      <td style="text-align:right; width:7%; color:#3333CC; font-weight:600; padding-right:15px;">
			<input style="font-weight:600; color:#800000; background:transparent; border:none; text-align:right;" type="text" readonly="readonly" size="8" name="TotalFEDAmount" id="TotalFEDAmount" value="<?php echo number_format($TotalFEDAmount,2); ?>" />
		      </td>
		      <td style="width:2.2%;"></td>
		     </tr>
		     <tr>
		      <td colspan="6" style="text-align:right; width:38%; font-weight:600;"></td>
		      <td colspan="6" style="text-align:right; width:44%; font-weight:600;">Total NET Amount:</td>
		      <td style="text-align:right; width:7%; color:#008000; font-weight:600; padding-right:15px;">
			<input style="font-weight:600; color:#008000; background:transparent; border:none; text-align:right;" type="text" readonly="readonly" size="8" name="TotalNetAmount" id="TotalNetAmount" value="<?php echo number_format($TotalNetAmount,2); ?>" />
		      </td>
		      <td style="width:2.2%;"></td>
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
			 <textarea name="InvoiceNote" class="form-control" rows="4" cols="70"><?php echo $InvoiceView[0]['InvoiceNote']; ?></textarea>
		      </div>
		    </div>
		  </div>

	      <div class="col-md-12">&nbsp;
          <div class="col-sm-6 invoice-col">
                  <address>
                    <strong>Added By</strong><br>
        <?php echo $this->session->userdata('EmployeeName'); ?>
                  </address>

                  <address>
                    <strong>Added On:</strong><br>
                    <?php echo date('M d, Y H:i:s', strtotime($InvoiceView[0]['AddedOn'])); ?>
                  </address>
                </div>
        </div>
		    
		  <!--<div class="col-md-2">
		   <button type="submit" id="SaveAsDraft" name="SaveAsDraft" value="formSave" class="btn btn-block btn-primary">Save As Draft</button>
		  </div>-->
		  <div class="col-md-2">
		   <button type="submit"  id="SaveAndSubmit" name="SaveAndSubmint" value="formSave" class="btn btn-block btn-primary">Update Record</button>
		  </div>
		  <div class="col-md-2">
		   <a href="<?php echo base_url(); ?>Invoice/"><button type="button" name="cancelForm" value="cancelSave" class="btn btn-block bg-orange">Cancel</button></a>
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

<script>
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
      
  $(document).on('keyup','input[id^=ProductId]',function(){
    
    var ProductId = ($(this).attr('id'));
    var  ProductName= $(this).val();
    
    $(this).autocomplete({
    
    source: function(request, response) {
    $.ajax({
        url: "<?php echo site_url('SaleOrder/AutoCompleteSearch_ProductName')?>",
        data: { ProductName:ProductName},
        dataType: "json",
        type: "POST",
        success: function(data) {
        //console.log(data);
        response(data);
        }
     });
    },
     select: function (event, ui) {
     $(this).val(ui.item.value); // display the selected text
     $("#hdn"+ProductId).val(ui.item.id); // save selected id to hidden input
    },
    minLength: 2
     });    
    });


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

<script>
	 $(function(){
 
      // Add New Row class="txtMult"
    $("#addRow").on("click",function(){
    var txtId = $("input[id^=Weight]:last").attr("id");
    var arr = txtId.split("_");
    var nextTxtId = (parseInt(arr[1]) +1);
     
    $("#delTable").append('<tr class="txtMult">'+
		      '<td style="padding:5px; width:2%;">'+nextTxtId+'</td>'+
		      '<td style="padding:5px; width:10%; text-align:left;">'+
		      '<input type="text" class="form-control" name="ProductId[]" id="ProductId_'+nextTxtId+'" autocomplete="off">'+
		    	'<input type="hidden" name="hdnProductId[]" id="hdnProductId_'+nextTxtId+'"></td>'+
		      	'<td style="padding:5px; width:10%; text-align:left;"><?php echo $ProductQuality; ?></td>'+
		      	'<td style="padding:5px; width:7%;"><input type="number" step="0.01" min="0" style="width:100%; background:transparent; border:none; text-align:right;" name="ReelSize[]" id="ReelSize_'+nextTxtId+'"></td>'+
		      	'<td style="padding:5px; width:7%;"><input type="number" min="0" style="width:100%; text-align:right;" name="SupplyQuantity[]" class="SupplyQuantity" id="SupplyQuantity_'+nextTxtId+'" autocomplete="off"></td>'+
		    	'<td style="padding:5px; width:7%;"><input type="number" step="0.01" style="width:100%; text-align:right;" name="Weight[]" class="Weight" id="Weight_'+nextTxtId+'" autocomplete="off"></td>'+
		    	'<td style="padding:5px; width:5%;"><input type="number" step="0.01" style="width:100%; text-align:right;" name="Rate[]" class="Rate" id="Rate_'+nextTxtId+'" autocomplete="off"></td>'+
		    	'<td style="padding:5px; width:8%;"><input type="number" step="0.01" readonly="readonly" style="width:100%; text-align:right;" name="Amount[]" id="Amount_'+nextTxtId+'" class="Amount"></td>'+
		    	'<td style="padding:5px; width:7%;"><input type="number" min="0" style="width:100%; text-align:right;" name="GST[]" class="GST" id="GST_'+nextTxtId+'" autocomplete="off"></td>'+
		    	'<td style="padding:5px; width:7%;"><input type="number" min="0" style="width:100%; text-align:right;" name="GSTAmount[]" class="GSTAmount" id="GSTAmount_'+nextTxtId+'"></td>'+
		    	'<td style="padding:5px; width:7%;"><input type="number" min="0" style="width:100%; text-align:right;" name="FED[]" class="FED" id="FED_'+nextTxtId+'" autocomplete="off"></td>'+
		    	'<td style="padding:5px; width:7%;"><input type="number" min="0" style="width:100%; text-align:right;" name="FEDAmount[]" class="FEDAmount" id="FEDAmount_'+nextTxtId+'"></td>'+
		    	'<td style="padding:5px; width:7%;"><input type="number" step="0.01" min="0" style="width:100%; text-align:right;" name="NetAmount[]" class="NetAmount" id="NetAmount_'+nextTxtId+'"></td>'+
		    	'<td style="padding:5px; width:2%;"><span style="color:red;" id="remove_'+nextTxtId+'" class="fa fa-times-circle"></span></td></tr>');
	
      })	
  });
</script>

<?php $this->load->view('includes/footer'); ?>