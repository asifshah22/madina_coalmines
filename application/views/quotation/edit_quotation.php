<?php $this->load->view('includes/header'); ?>
<?php $this->load->view('includes/sidebar'); ?>
<?php 
$References = '<select name="ReferenceId" style="width:200px; margin-top:1px;">';
$References .= '<option value="0">Select Reference</option>';
foreach ($AllReferences as $ReferenceRecord) {
$References .= '<option value='.$ReferenceRecord['ReferenceId'].'>'.$ReferenceRecord['FullName'].'</option>';
}
$References .= '</select>';
?>

      <!-- /.main-content starts -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1><i class="fa fa-shopping-cart"></i>&nbsp;Delivery Challan</h1>
    </section>
    
    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-md-12">
          <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title text-light-blue">Update Delivery Challan</h3>
            </div>
      <?php echo "<font style=color:#00468E; font-weight:bold text-align:center;>".$this->session->flashdata('record_update')."</font>"; ?>
<?php  $id = $Sales->SaleId; ?>
 <form class="form-horizontal" method="post" action="<?php echo base_url("Quotation/UpdateQuotation"); ?>" name="basic_validate" id="basic_validate" novalidate="novalidate">
     <input type="hidden" name="SaleId" value="<?php echo $Sales->SaleId; ?>">
     <input type="hidden" name="SaleNo" value="<?php echo $Sales->SaleNo; ?>">
                    
      <div class="box-body">
        <div class="row invoice-info">
    <div class="col-sm-3 invoice-col">
      <address>
        <strong>Delivery Challan#:</strong><br>
          <span style="color:#3333CC; font-size:13px; font-weight:bold;"><?php echo $Sales->SaleId; ?></span>
      </address>
    </div>

    <div class="col-sm-3 invoice-col">
      <address>
        <strong>Customer / Business Name:</strong><br>
         <select name="CustomerId" id="CustomerId" style="width:215px; margin-top:1px;" class="form-control select2" required="required">
         <option selected="selected" value="">Select Customer</option>
         <?php foreach ($AllCustomers as $CustomerRecord) { ?>
         <option value="<?php echo $CustomerRecord['CustomerId'].'-'.$CustomerRecord['ChartOfAccountId']; ?>"<?php if($CustomerRecord['CustomerId'] == $Sales->CustomerId) echo "selected=selected"; ?>><?php echo $CustomerRecord['CustomerName'];?></option>
         <?php } ?>
        </select>
      </address>
    </div>

    <div class="col-sm-3 invoice-col">
      <address>
        <strong>Transportation:</strong><br>
          <select name="ReferenceId" id="ReferenceId" style="width:215px; margin-top:1px;" class="form-control select2">
            <option value="0"> Select Reference</option>
            <?php foreach ($AllReferences as $ReferenceRecord) { ?>
              <option value="<?php echo $ReferenceRecord['ReferenceId']; ?>"<?php if($Sales->ReferenceId == $ReferenceRecord['ReferenceId']) echo "selected=selected"; ?>><?php echo $ReferenceRecord['FullName'];?></option>
            <?php } ?>
          </select>
      </address>
    </div>

     <div class="col-sm-3 invoice-col">
      <address>
        <strong>P.O No:</strong><br>
        <input class="form-control" name="CustomerName" id="CustomerName" type="text" style="width:215px;" value="<?php echo $Sales->WalkinCustomer; ?>" autocomplete="off">
      </address>
    </div>

     <div class="col-sm-3 invoice-col">
      <address>
        <strong>P.O Date:</strong><br>
        <input class="form-control" name="MobileNumber" id="MobileNumber" type="text" style="width:215px;" value="<?php echo $Sales->MobileNumber; ?>" autocomplete="off">
      </address>
    </div>    

    <div class="col-sm-3 invoice-col">
      <address>
        <strong>DC Date:</strong><br>
          <input class="form-control" id="datepicker1" type="text" name="SaleDate" value="<?php date_default_timezone_set("Asia/Karachi"); echo date("m/d/Y h:i:s", strtotime($Sales->SaleDate)); ?>" style="width:215px; " >
        </address>
    </div><!-- /.form-group -->
    
    <div class="col-sm-3 invoice-col">
      <address>
        <strong>Vehicle No:</strong><br>
        <input class="form-control" name="SaleNote" id="SaleNote" type="text" style="width:215px;" value="<?php echo $Sales->SaleNote; ?>" autocomplete="off">
      </address>
    </div>

    <div class="col-sm-3 invoice-col">
      <address>
        <strong>Remarks:</strong><br>
        <input class="form-control" name="Address" id="Address" type="text" style="width:215px;" value="<?php echo $Sales->Address; ?>" autocomplete="off">
      </address>
    </div>
   
  </div>
</div>
          
  <div class="row" style="display: block;" id="mainRow">
    <div class="col-md-12">
    <div style="overflow-x: auto; width: 100%;">
<table class='table table-bordered' id="Sale_EntriesTable" style="width: 100%; border-collapse: separate; border-spacing: 0;">
    <thead>    
        <tr style="background: linear-gradient(to bottom, #f8f9fa, #e9ecef);">
	    <th style="width:2%;">S.#</th>
	    <th style="width:5%;">P.O No#</th>
	    <th style="padding:5px; width:10%; text-align: left;">P/Description</th>
	    <th style="padding:5px; width:10%; text-align: left;">Location</th>
	    <!--<th style="padding:5px; width:10%; text-align: left;">Color</th>-->
	    <th style="padding:5px; width:10%;">Rate</th>
	    <th style="padding:5px; width:10%;">Qty</th>
	    <th style="padding:5px; width:10%;">Amount</th>
	    <th style="padding:5px; width:10%;">Dis: Amt</th>
	    <th style="padding:5px; width:10%;">Dis %</th>
	    <th style="padding:5px; width:10%;">Discount</th>
	    <th style="padding:5px; width:10%;">Net Amount</th>
	    <th style="padding:5px; width:20%; text-align: left;"></th>
	   </tr>
		<?php
		$SNo = 1; 
		$TotalNetAmount = 0;
    $Quantity = 0;
    $Amount = 0;
    $DiscountAmount = 0;
    $TaxAmount = 0;
    $NetAmount = 0;
    
		foreach($SalesDetail as $Record) {
		 ?>
		<tr class="txtMult">
		 <td style="margin-top:15px;line-height:25px"><?php echo $SNo; ?></td>
		 <td>
		  <input style='width:90px;margin-top:1px;' type='text' name="ProductBarCode[]" id="txtCode<?php echo $SNo?>" autocomplete="off"value="<?php echo $Record['ProductBarCode'];?>">
		  
		 </td>
		 <td>
		  <input style='width:90px;margin-top:1px;' type='text' name="ProductName[]" id="ProductName_<?php echo $SNo?>" autocomplete="off"value="<?php echo $Record['ProductName'];?>">
		  <input type='hidden' id="hdnProductName_<?php echo $SNo; ?>" name="ProductId[]" value="<?php echo $Record['ProductId'];?>">
		 </td>
		 <td>
		  <input style='width:90%;margin-top:1px;' type='text' id="LocationName_<?php echo $SNo?>" autocomplete="off" value="<?php echo $Record['LocationName'];?>" >
		 <input type='hidden' id="hdnLocationName_<?php echo $SNo?>" name="LocationId[]" value="<?php echo $Record['LocationId'];?>"> 
		 </td>
		 <!--<td style="text-align:center;">-->
		  <!--<input style='width:90%; margin-top:1px;' type='text' name="ColourName[]" id="ColourName_<?php echo $SNo?>" autocomplete="off" value="<?php echo $Record['ColourName'];?>">-->
		 <!--<input type='hidden' id="hdnColourName_<?php echo $SNo?>" name="ColourId[]" value="<?php echo $Record['ColourId'];?>" >-->
		 <!--</td>-->
		 <td><input style='width:100%; margin-top:1px;' type='number' id="Rate<?php print $SNo; ?>" class="Rate" name='Rate[]' autocomplete="off" value="<?php echo $Record['Rate'];?>" min="0" step="0.01"></td>
		 <td style="text-align:center;"><input style='width:90%;margin-top:1px; text-align:right;' type='number' id="Quantity<?php print $SNo; ?>" class="Quantity" name='Quantity[]' autocomplete="off" value="<?php echo $Record['Quantity'];?>" min="0" step="0.01"></td>
		 <td><input style='width:90%; margin-top:1px; text-align:right;' type='number' id="Amount<?php print $SNo; ?>" class="Amount" name='Amount[]' value="<?php echo $Record['Amount'];?>" min="0" step="0.01"></td>
		 <td><input style='width:90%; margin-top:1px; text-align:right;' type='number' id="DiscountAmount<?php print $SNo; ?>" class="DiscountAmount" name='DiscountAmount[]' value="<?php echo $Record['DiscountAmount'];?>" min="0" step="0.01"></td>
		<td><input style='width:90%; margin-top:1px; text-align:right;' type='number' id="TaxPercentage<?php print $SNo; ?>" class="TaxPercentage" name='TaxPercentage[]' min="0" step="0.01" value="<?php echo $Record['TaxPercentage'];?>"></td>
		<td><input style='width:90%; margin-top:1px; text-align:right;' type='number' id="TaxAmount<?php print $SNo; ?>" class="TaxAmount" name='TaxAmount[]' min="0" step="0.01" value="<?php echo $Record['TaxAmount'];?>"></td>
		 <td><input style='width:90%; margin-top:1px; text-align:right;' type='number' id="Amount<?php print $SNo; ?>" class="NetAmount" name='NetAmount[]' value="<?php echo $Record['NetAmount'];?>" min="0" step="0.01"></td>
		 <td style="width:50px;text-align:right; cursor:pointer; color:red;"><i class="fa fa-trash remove" title="Delete" style="margin-top:1px;"></i></td>
		</tr>
		<?php 
		    $Quantity += $Record['Quantity'];
        $Amount += $Record['Amount'];
        $DiscountAmount += $Record['DiscountAmount'];
        $TaxAmount += $Record['TaxAmount'];
        $NetAmount += $Record['NetAmount'];
		  $SNo++;
		} ?>
		<input type="hidden" name="SNo" id="SNo" class="form-control" value="<?php echo $SNo; ?>">
	    </table>
  <div style="height: 50px;"></div>
       <table class="table" border="0">
              <tbody>
                        <tr>
         <td colspan="13">
     <span style="cursor:pointer; color:darkgreen; font-weight:600;" id="addrow" class="fa fa-plus">Add Row</span>
         </td>
         <td id="RemainingStock"></td>
        </tr>
    
        <tr>
          <td colspan="12" style="width: 90%; text-align:right; font-weight:600; border: 0px solid;">Total Quantity:</td>
          <td><div id="Quantity" style='font-weight:600; text-align:right; color:#008000;'><?php echo number_format($Quantity,2,'.',''); ?></div></td>
        </tr>

        <tr>
          <td colspan="12" style="width: 90%; text-align:right; font-weight:600; border: 0px solid;">Total Amount:</td>
          <td><div id="Amount" style='font-weight:600; text-align:right; color:#008000;'><?php echo number_format($Amount,2,'.',''); ?></div></td>
        </tr>

        <tr>
          <td colspan="12" style="width: 90%; text-align:right; font-weight:600; border: 0px solid;">Total Discount:</td>
          <td><div id="DiscountAmount" style='font-weight:600; text-align:right; color:#008000;'><?php echo number_format($DiscountAmount+$Record['TotalDiscount'],2,'.',''); ?></div></td>
        </tr>

        <tr>
          <td colspan="12" style="width: 90%; text-align:right; font-weight:600; border: 0px solid;">Total Net Amount:</td>
          <td><div id="TotalAmount" style='font-weight:600; text-align:right; color:#008000;'><?php echo number_format($NetAmount-$Record['TotalDiscount'],2,'.',''); ?></div></td>
        </tr>



        </tbody>
       </table>

<div class="box-body">
    <div class="row">
      <div class="col-md-2">
        <button type="submit" name="submitForm" value="AddRecord" id="AddRecord" class="btn btn-block btn-success">Update Record</button>
      </div>
      <div class="col-md-2">
        <a href="<?php echo base_url(); ?>Quotation/"><button type="button" name="" value="cancelUpdate" class="btn btn-block btn-primary">Back to Main</button></a>
      </div>
    </div>
        </div>


          </div>
	</div>
    						</div>
						</div>			
					</div>
				</div>
</div>
</form>
</section>

<?php
$this->load->view('includes/footer');
?>

<script src="<?php echo base_url();?>plugins/autocomplete/jquery-ui.js"></script>
<link rel="stylesheet" href="<?php echo base_url();?>plugins/autocomplete/jquery-ui.css" />

<script>
  $(document).ready(function () {
    var counter = $("#SNo").val();
    
    // Add New Row Script 
    $('body').on("click", "#addrow", function(e) {
	
        var newRow = $("<tr class='txtMult'>");
        var cols = "";
  cols += '<td style="margin-top:15px;line-height:25px">' + counter + '</td>';
  	cols += '<td><input style="width:100px;margin-top:1px;" type="text" id="txtCode" name="ProductBarCode[]" class="barcodeinput"></td>';
  cols += '<td><input style="width:90px;margin-top:1px;" class="select2" name="ProductName[]" type="text" id="ProductName_'+ counter +'" name="ProductName[]"><input style="width:90%;" type="hidden" id="hdnProductName_'+ counter +'" name="ProductId[]"></td>'
  cols += '<td style="text-align:center;"><input style="width:90%; margin-top:1px;" class="select2" type="text" id="LocationName_'+ counter +'" name="LocationName_[]"><input style="width:90%;" type="hidden" id="hdnLocationName_'+ counter +'" name="LocationId[]"></td>';
//   cols += '<td style="text-align:center;"><input style="width:90%; margin-top:1px;" class="select2" type="text" id="ColourName_'+ counter +'" name="ColourName[]"><input style="width:90%;" type="hidden" id="hdnColourName_'+ counter +'" name="ColourId[]"></td>';
  cols += '<td><input style="width:100%; margin-top:1px; text-align:right;" type="number" id="Rate'+ counter +'" class="Rate" name="Rate[]" autocomplete="off" min="0" step="0.01"></td>';
  cols += '<td><input style="width:90%; margin-top:1px; text-align:right;" type="number" id="Quantity'+ counter +'" class="Quantity" name="Quantity[]" autocomplete="off" min="0" step="0.01"></td>';
  cols += '<td><input style="width:90%; margin-top:1px; text-align:right;" type="number" id="Amount'+ counter +'" class="Amount" name="Amount[]" min="0" step="0.01"></td>';
  cols += '<td><input style="width:90%; margin-top:1px; text-align:right;" type="number" id="DiscountAmount'+ counter +'" class="DiscountAmount" name="DiscountAmount[]" min="0" step="0.01"></td>';
  cols += '<td><input style="width:90%; margin-top:1px; text-align:right;" type="number" id="TaxPercentage'+ counter +'" class="TaxPercentage" name="TaxPercentage[]" step="0.00"></td>';
  cols += '<td><input style="width:90%; margin-top:1px; text-align:right;" type="number" id="TaxAmount'+ counter +'" class="TaxAmount" name="TaxAmount[]" step="0.00"></td>';
  cols += '<td><input style="width:90%; margin-top:1px; text-align:right;" type="number" id="NetAmount'+ counter +'" class="NetAmount" name="NetAmount[]" min="0" step="0.01"></td>';
  cols += '<td style="width:50px;text-align:right; cursor:pointer; color:red;"><i class="fa fa-trash remove" title="Delete" style="margin-top:1px;"></i></td>';

        newRow.append(cols);
        $("#Sale_EntriesTable").append(newRow);
        counter++;
    });
    
    // Start Remove row script
    $("#Sale_EntriesTable").on("click", ".remove", function (event) {
        $(this).closest("tr").remove();       
        counter -= 1
    });
    // End of Add new row script
   
     // Calculating total Quantity and Amount Script
             
     $('body').on("keyup",".txtMult input", multInputs);
    
     function multInputs() {
     
     var TotalQuantity = 0;
     var TotalDiscount = 0;
     var TotalTaxAmount = 0;
     var TotalAmount = 0;
     var NetAmount = 0;
     var TotalNetAmount = 0;
     var total_tax=0
 
 
     $('tr.txtMult').each(function () {
 
      // var SaleCartId = $('.SaleCartId', this).val();
       //var ProductId = $('.hdnProductId', this).val();
       var Quantity = $('.Quantity', this).val();
       var Rate = $('.Rate', this).val();
       var DiscountAmount = $('.DiscountAmount', this).val();
     
       var QuantityVal = (isNaN(parseFloat(Quantity))) ? 0 : parseFloat(Quantity);
       var RateVal = (isNaN(parseFloat(Rate))) ? 0 : parseFloat(Rate);
       var DiscountAmountVal = (isNaN(parseFloat(DiscountAmount))) ? 0 : parseFloat(DiscountAmount);
 
       var Amount = (QuantityVal * 1) * (RateVal * 1);      
       
  
       // Inserting product detail in sale cart table
            
       var $TaxAmount = $('.TaxAmount', this).val();
       var $TaxPercentage = $('.TaxPercentage', this).val();
       var $Tax = ((Amount * $TaxPercentage) / 100); 
       
       $('.TaxAmount',this).val(($Tax).toFixed(2));      
       
       if(DiscountAmountVal != 0) 
       {
         NetAmount = (Amount - DiscountAmountVal - $Tax);
       }
       else
       {
         NetAmount = (Amount - $Tax);
       }
       
       
       $('.Amount',this).val(Amount);
       $('.NetAmount',this).val(NetAmount);
 
       TotalQuantity += QuantityVal;
       TotalDiscount += DiscountAmountVal;
       TotalAmount += Amount;
       TotalTaxAmount += $Tax;
       TotalNetAmount += NetAmount;  
     });
   
     // console.log('tax',totaltax);
     
       TotalNetAmount=TotalNetAmount;
       TotalDiscount+=total_tax;
 
         $('#Quantity').text((TotalQuantity).toFixed(2))
         $('#Amount').text((TotalAmount).toFixed(2))
         $('#TaxAmount').text((TotalTaxAmount).toFixed(2));
         $('#DiscountAmount').text((TotalDiscount).toFixed(2));
         $('#TotalAmount').text((TotalNetAmount).toFixed(2));
         // $('#NetAmountTax').text((total_tax).toFixed(2));
       }
  });  

 $(function(){
    // Auto Select Produt List
    $('body').on("keyup", "input[id^=ProductName]", function(){
      
            var  ProductId  = ($(this).attr('id'));
            var  ProductName = $(this).val();
      
            $(this).autocomplete({
    
                source: function(request, response)   {
                    $.ajax({
                        url: "<?php echo site_url('Sales/AutoCompleteProductList')?>",
                        data: { ProductName:ProductName},
                        dataType: "json",
                        type: "POST",
                        success: function(data) {
                         response(data);
                        }
                    });
                },
                select: function (event,ui) {
                    $(this).val(ui.item.value); // display the selected text
                   var id = $(this).attr('id');
                   var Attr = id.split("_");
                   window.IdAttr = Attr[1];
                   $("#hdn"+ProductId).val(ui.item.id); // save selected id to hidden input
                   window.PId = ui.item.id;
		},
                minLength: 2
            });
        }); 


        $(document).on('focusout','input[id^=ProductName]',function(){
            var id = $(this).attr('id');
            var Attr = id.split("_");
            var IdAttr = Attr[1];
            var PId2 = window.PId;

            $.ajax({
               type: 'POST',
               dataType: 'html',
//               data: ('LocationId='+LocationId+'&ProductId='+ProductId),
               data: ('ProductId='+PId2),
               url: "<?php echo base_url('Sales/GetRemainingProduct'); ?>",
               success: function(response){
//                $('#RemainingStock').html(response);
                $('#Quantity'+IdAttr).val(response);
               }
            });

        })

     // Auto Select Location List
     $('body').on("keyup", "input[id^=LocationName]", function(){
      
            var  LocationId  = ($(this).attr('id'));
            var  LocationName = $(this).val();
      
            $(this).autocomplete({
    
                source: function(request, response)   {
                    $.ajax({
                        url: "<?php echo site_url('Sales/AutoCompleteLocationList')?>",
                        data: { LocationName:LocationName},
                        dataType: "json",
                        type: "POST",
                        success: function(data) {
                         response(data);
                        }
                    });
                },
                select: function (event,ui) {
                    $(this).val(ui.item.value); // display the selected text
                    $("#hdn"+LocationId).val(ui.item.id); // save selected id to hidden input
    },
                minLength: 2
            });
        });
  
  
     // Auto Select Colour List
     $('body').on("keyup", "input[id^=ColourName]", function(){
      
            var  ColourId  = ($(this).attr('id'));
            var  ColourName = $(this).val();
      
            $(this).autocomplete({
    
                source: function(request, response)   {
                    $.ajax({
                        url: "<?php echo site_url('Sales/AutoCompleteColourList')?>",
                        data: { ColourName:ColourName},
                        dataType: "json",
                        type: "POST",
                        success: function(data) {
                         response(data);
                        }
                    });
                },
                select: function (event,ui) {
                    $(this).val(ui.item.value); // display the selected text
                    $("#hdn"+ColourId).val(ui.item.id); // save selected id to hidden input
    },
                minLength: 2
            });
        });

            $('body').on('change', 'input[id^=LocationName]', function(){
                var LocationId = $('input[name^=LocationId]').val();
                var ProductId = $('input[name^=ProductId]').val();

                $.ajax({
                   type: 'POST',
                   dataType: 'html',
                   data: ('LocationId='+LocationId+'&ProductId='+ProductId),
                   url: "<?php echo base_url('Sales/GetRemainingProduct'); ?>",
                   success: function(response){
                    $('#RemainingStock').html(response);
                   }
                });
            });


});


 $(function(){

        $("#basic_validate").submit(function(e){
          var SNo = 1;
            $("input[id^=ProductName]").each(function(){
            var ProductName = $(this).val();
              if(ProductName == '' || ProductName == 0)
              {
                //alert("Please fill this field");
                $(this).css('border-color', 'red');
                e.preventDefault();
                $(this).focus;
              }
              if(ProductName != '' || ProductName != 0){
                $(this).css('border-color', 'green');
              }
          SNo++;
            });
        });

	/*
        $("#basic_validate").submit(function(e){
          var SNo = 1;
            $("input[id^=LocationName]").each(function(){
            var LocationName = $(this).val();
              if(LocationName == '' || LocationName == 0)
              {
                 //alert("Please fill this field");
                 $(this).css('border-color', 'red');
                 e.preventDefault();
                 $(this).focus;
              }
              if(LocationName != '' || LocationName != 0){
                $(this).css('border-color', 'green');
              }
          SNo++;
            });
        });

        $("#basic_validate").submit(function(e){
          var SNo = 1;
            $("input[id^=ColourName]").each(function(){
            var ColourName = $(this).val();
              if(ColourName == '' || ColourName == 0)
              {
                 //alert("Please fill this field");
                 $(this).css('border-color', 'red');
                 e.preventDefault();
                 $(this).focus;
              }
              if(ColourName != '' || ColourName != 0){
                $(this).css('border-color', 'green');
              }
          SNo++;
            });
        });

	*/

        $("#basic_validate").submit(function(e){
          var SNo = 1;
            $("input[id^=Rate]").each(function(){
            var Rate = $(this).val();
              if(Rate == '' || Rate == 0)
              {
                 //alert("Please fill this field");
                 $(this).css('border-color', 'red');
                 e.preventDefault();
                 $(this).focus;
              }
              if(Rate != '' || Rate != 0){
                $(this).css('border-color', 'green');
              }
          SNo++;
            });
        });

        $("#basic_validate").submit(function(e){
          var SNo = 1;
            $("input[id^=Quantity]").each(function(){
            var Quantity = $(this).val();
              if(Quantity == '' || Quantity == 0)
              {
                 //alert("Please fill this field");
                 $(this).css('border-color', 'red');
                 e.preventDefault();
                 $(this).focus;
              }
              if(Quantity != '' || Quantity != 0){
                $(this).css('border-color', 'green');
              }
          SNo++;
            });
        });


          $("#basic_validate").submit(function(e){
          var SNo = 1;
            $("input[id^=CustomerId]").each(function(){
            var CustomerId = $(this).val();
              if(CustomerId == '' || CustomerId == "0")
              {
                 //alert("Please fill this field");
                 $(this).css('border-color', 'red');
                 e.preventDefault();
                 $(this).focus;
              }
              if(CustomerId != '' || CustomerId != 0){
                $(this).css('border-color', 'green');
              }
          SNo++;
            });
          });


      });    // end of main jQuery


 </script>