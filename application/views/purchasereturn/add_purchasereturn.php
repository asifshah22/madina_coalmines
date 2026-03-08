<?php 
$this->load->view('includes/header');
$this->load->view('includes/sidebar');

$Vendors = '<select name="VendorId" id="VendorId" class="form-control select2" style="width:215px">';
$Vendors .= '<option value="0">Select Vendor</option>';
foreach ($AllVendors as $VendorRecord) {
$Vendors .= '<option value='.$VendorRecord['VendorId'].'-'.$VendorRecord['ChartOfAccountId'].'>'.$VendorRecord['VendorName'].'</option>';
}
$Vendors .= '</select>';      
?>
<script src="<?php echo site_url();?>/lib/js/autocompletejs/jquery-ui.js"></script>
<link rel="stylesheet" href="<?php echo site_url();?>/lib/css/autocompletecss/jquery-ui.css"/>
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
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1><i class="fa fa-laptop"></i>&nbsp;Purchase</h1>
    </section>
    
    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-md-12">
          <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title text-light-blue">Add Purchase</h3>
            </div>
	    <?php echo "<font style=color:#00468E; font-weight:bold text-align:center;>".$this->session->flashdata('record_update')."</font>"; ?>
	    
            <form role="form" name="basic_validate" id="basic_validate" action='<?php echo base_url("PurchaseReturn/SavePurchaseReturn") ?>' method="post">
	    
	    <div class="box-body">
	      <div class="row invoice-info">
		<div class="col-sm-3 invoice-col">
		  <address>
		    <strong>Purchase Return #:</strong><br>
		    <span style="color:#3333CC; font-size:13px; font-weight:bold;"> Auto Generated</span>
		  </address>
		</div>

		<div class="col-sm-3 invoice-col">
		  <address>
		    <strong>Vendor:</strong><br>
		   <?php echo $Vendors; ?>
          </address>
		</div>

		<div class="col-sm-3 invoice-col">
		  <address>
		    <strong>Bank Account:</strong><br>
    		   <select name="BankAccountId" id="BankAccountId" class="form-control select2" style="width: 215px;">
	              <option value=""> Select Bank Account</option>
	              <?php  foreach ($GetAllBankAccounts as $BankAccounts) {
	              ?>
	              <option value="<?php echo $BankAccounts['AccountId'].'-'.$BankAccounts['ChartOfAccountId']; ?>"><?php echo $BankAccounts['AccountTitle'] . " - " . $BankAccounts['AccountNumber'];  ?></option>
	              <?php
	               } ?>
	            </select>
		  </address>
		</div>

		<div class="col-sm-3 invoice-col">
		  <address>
		    <strong>Purchase Return Date:</strong><br>
		    <input class="form-control" id="datepicker1" type="text" name="PurchaseReturnDate" value="<?php // echo date("m-d-Y", strtotime($Purchases->PurchaseDate)); ?>" style="width:215px;">
                  </address>
		</div>

		<div class="col-sm-3 invoice-col">
		  <address>
		    <strong>Purchase Return Type:</strong><br>
	        <select name="PurchaseReturnType" id="PurchaseReturnType" style="width:215px;" class="form-control" required="required">
            <option value="" selected="selected"> Purchase Type</option>
				    <option value="1">On Cash</option>
      			<option value="2">On Credit</option>
				    <option  selected="selected" value="3">Online</option>
			    </select>
		  </address>
		</div>


		<div class="col-sm-3 invoice-col">
		  <address>
		    <strong>Purchase Return Note:</strong><br>
				<input type="text" name="PurchaseReturnNote" id="PurchaseReturnNote" class="form-control">
		  </address>
		</div>

	      </div>
	  </div>
	    <?php
		$SNo=1;
		$TotalWeight = '';
		$TotalAmount = '';
		$TotalGSTAmount = '';
	    ?>
	    
	    <div class="row" style="display: block;" id="mainRow">
		<div class="col-md-12" style="">
		  <div class="box-body pad table-responsive">
		    <table class='table table-bordered text-center' id="Purchase_EntriesTable">
		    <tr style="background-color:#ECF9FF;">
		    	<th style="width:2%;">S.#</th>
				<th style="padding:5px; width:10%; text-align: center;">Item</th>
				<th style="padding:5px; width:5%; text-align: center;">Location</th>
				<th style="padding:5px; width:8%; text-align: center;">Color</th>
				<th style="padding:5px; width:10%;">Rate</th>
				<th style="padding:5px; width:5%;">Qty</th>
				<th style="padding:5px; width:10%;">Amount</th>
				<th style="padding:5px; width:10%;">Dis: Amt</th>
				<th style="padding:5px;width: 8%">Net Amount</th>
				<th style="padding:5px; width:15%; text-align: center;">Description</th>
				<th style="width: 2%"></th>
		    </tr>
 <?php 
		 $SNo = 1;
		 for ($i=1; $i < 2; $i++) { ?>
		<tr class="txtMult">
		 <td style="margin-top:15px;line-height:25px"><?php echo $SNo; ?></td>
		 <td>
		  <input style='width:130px;margin-top:1px;' type='text' name="ProductName[]" id="ProductName_<?php echo $i?>" autocomplete="off">
		  <input style='width:90%;' type='hidden' id="hdnProductName_<?php echo $i?>" name="ProductId[]">
		 </td>
		 <td>
		  <input style='width:95%;margin-top:1px;' type='text' id="LocationName_<?php echo $i?>" autocomplete="off">
		  <input type='hidden' id="hdnLocationName_<?php echo $i?>" name="LocationId[]"> 
		 </td>
		 <td style="text-align:center;">
		  <input style='width:95%; margin-top:1px;' type='text' name="ColourName[]" id="ColourName_<?php echo $i?>" autocomplete="off">
		  <input type='hidden' id="hdnColourName_<?php echo $i?>" name="ColourId[]"> 
		 </td>
		 <td><input style='width:90%; margin-top:1px;' type='number' id="Rate<?php print $i; ?>" class="Rate" name='Rate[]' autocomplete="off" min="0" step="0.01"></td>
		 <td style="text-align:center;"><input style='width:100%;margin-top:1px; text-align:right;' type='number' id="Quantity<?php print $i; ?>" class="Quantity" name='Quantity[]' autocomplete="off" min="0" step="0.01"></td>
		 <td><input style='width:90%; margin-top:1px; text-align:right;' type='number' id="Amount<?php print $i; ?>" class="Amount" name='Amount[]' min="0" step="0.01"></td>
		 <td><input style='width:90%; margin-top:1px; text-align:right;' type='number' id="DiscountAmount<?php print $i; ?>" class="DiscountAmount" name='DiscountAmount[]' min="0" step="0.01"></td>
		 <td><input style='width:100%; margin-top:1px; text-align:right;' type='number' id="Amount<?php print $i; ?>" class="NetAmount" name='NetAmount[]' min="0" step="0.01"></td>
		 <td><input style='width:170px; text-align:left; margin-top:1px;' type='text' id="Comments<?php print $i; ?>" class="Description" name='Comments[]'></td>
		 <td style="width:5%;"></td>
		</tr>
		<?php 
		$SNo++;
		} ?>
		<input type="hidden" name="SNo" id="SNo" class="form-control" value="<?php echo $SNo; ?>">
	    </table>
		   
      <div style="height: 50px;"></div>
      <table class="table" border="0">
            <tbody>
        <tr>
         <td colspan="13">
     <span style="cursor:pointer; color:darkgreen; font-weight:600;" id="addRow" class="fa fa-plus">Add Row</span>
         </td>
         <td id="RemainingStock"></td>
        </tr>


        <tr>
          <td colspan="12" style="width: 90%; text-align:right; font-weight:600; border: 0px solid;">Total Quantity:</td>
          <td><div id="Quantity" style='font-weight:600; text-align:right; color:#008000;'><?php echo '0.00'; ?></div></td>
        </tr>

        <tr>
          <td colspan="12" style="width: 90%; text-align:right; font-weight:600; border: 0px solid;">Total Amount:</td>
          <td><div id="Amount" style='font-weight:600; text-align:right; color:#008000;'><?php echo '0.00'; ?></div></td>
        </tr>

        <tr>
          <td colspan="12" style="width: 90%; text-align:right; font-weight:600; border: 0px solid;">Total Discount:</td>
          <td><div id="DiscountAmount" style='font-weight:600; text-align:right; color:#008000;'><?php echo '0.00'; ?></div></td>
        </tr>

        <tr>
          <td colspan="12" style="width: 90%; text-align:right; font-weight:600; border: 0px solid;">Total Net Amount:</td>
          <td><div id="TotalAmount" style='font-weight:600; text-align:right; color:#008000;'><?php echo '0.00'; ?></div></td>
        </tr>


      </tbody>
      </table>

	      <br><br>
	      <div class="box-body">
		<div class="row">
		  <div class="col-md-2" id="PurchaseButton" style="">
		    <button type="submit" name="AddPurchaseRecordBtn" value="AddPurchaseRecord" id="AddRecord" class="btn btn-block btn-primary" >Save Record</button>
		  </div>
		  <div class="col-md-2">
		    <a href="<?php echo base_url(); ?>PurchaseReturn/"><button type="button" name="cancelForm" value="cancelUpdate" class="btn btn-block btn-primary">Back to main</button></a>
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
  // Autocomplete Search Product Name
  $(document).on('keyup','input[id^=ProductId]',function(){
    
    var ProductId = ($(this).attr('id'));
    var  ProductName= $(this).val();
    
    $(this).autocomplete({
    
    source: function(request, response) {
    $.ajax({
        url: "<?php echo site_url('Purchase/AutoCompleteSearch_ProductName')?>",
        data: { ProductName:ProductName},
        dataType: "json",
        type: "POST",
        success: function(data) {
//        console.log(data);
        response(data);
//        alert(data.id);
        }
     });
    },
     select: function (event, ui) {
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

  	var counter = 0;
  	$(document).on('focusout','input[id^=ProductId]',function(){
  		var VendorId = $("#VendorId").val();
  		if(VendorId == "0"){
  			alert("Please Select Vendor");
  			$('input').val('');
  		return;
  		}
  	else{
  		var PId2 = window.PId;
  		var IdR = window.IdAttr;
  		var Rate =
		$.ajax({
			url: '<?php echo base_url(); ?>Purchase/GetProductRate',
			data:{Product:PId2,VendorId:VendorId},
			type: 'post',
			dataType: 'html',
			success:function(data){
				var SN = $("#SN").val();
				if(data == "0"){
//				for (var i = 1; i < SN.length; i++) {
					alert("Rate is not defined for this vendor/product");
//					console.log($("#Rate_"+counter).val(data));
				}
				else{
					if(PId2 != 0){
					counter++;
					$("#Rate_"+IdR).val(data);
					}
					else{
					$("#Rate_"+IdR).val('0');
					}
					window.PId = 0;
				}
			}
		})
		}
  	})

  });

 </script>

<td style='padding:5px; width:5%;'><input type='hidden' style='width:100%; text-align:right;' name='FED[]' class='FED' id='FED_<?php echo $SNo; ?>' autocomplete="off"></td>
<td style='padding:5px; width:5%;'><input type='hidden' style='width:100%; text-align:right;' name='FEDAmount[]' class='FEDAmount' id='FEDAmount_<?php echo $SNo; ?>' autocomplete='off'></td>


 <script>
 $(function(){

    var counter = $("#SNo").val();
$("#addRow").on("click",function () {
  

    var newRow = $("<tr class='txtMult'>");
    var cols = "";

  cols += '<td style="margin-top:15px;line-height:25px">' + counter + '</td>';
  cols += '<td><input style="width:130px;margin-top:1px;" class="select2" name="ProductName[]" type="text" id="ProductName_'+ counter +'" name="ProductName[]"><input style="width:90%;" type="hidden" id="hdnProductName_'+ counter +'" name="ProductId[]"></td>'
  cols += '<td style="text-align:center;"><input style="width:95%; margin-top:1px;" class="select2" type="text" id="LocationName_'+ counter +'" name="LocationName_[]"><input style="width:90%;" type="hidden" id="hdnLocationName_'+ counter +'" name="LocationId[]"></td>';
  cols += '<td style="text-align:center;"><input style="width:95%; margin-top:1px;" class="select2" type="text" id="ColourName_'+ counter +'" name="ColourName[]"><input style="width:90%;" type="hidden" id="hdnColourName_'+ counter +'" name="ColourId[]"></td>';
  cols += '<td><input style="width:90%; margin-top:1px; text-align:right;" type="number" id="Rate'+ counter +'" class="Rate" name="Rate[]" autocomplete="off" min="0" step="0.01"></td>';
  cols += '<td><input style="width:100%; margin-top:1px; text-align:right;" type="number" id="Quantity'+ counter +'" class="Quantity" name="Quantity[]" autocomplete="off" min="0" step="0.01"></td>';
  cols += '<td><input style="width:90%; margin-top:1px; text-align:right;" type="number" id="Amount'+ counter +'" class="Amount" name="Amount[]" min="0" step="0.01"></td>';
  cols += '<td><input style="width:90%; margin-top:1px; text-align:right;" type="number" id="DiscountAmount'+ counter +'" class="DiscountAmount" name="DiscountAmount[]" min="0" step="0.01"></td>';
  cols += '<td><input style="width:100%; margin-top:1px; text-align:right;" type="number" id="NetAmount'+ counter +'" class="NetAmount" name="NetAmount[]" min="0" step="0.01"></td>';
  cols += '<td><input style="width:170px; text-align:left; margin-top:1px;" type="text" id="Comments_'+ counter +'" name="Comments[]"></td>'
  cols += '<td style="width:70px;text-align:center; cursor:pointer; color:red;"><i class="fa fa-trash remove" title="Delete" style="margin-top:1px;"></i></td>';

    	newRow.append(cols);
    		$("#Purchase_EntriesTable").append(newRow);
    	counter++;
    });
    
    // Start Remove row script
    $("#Purchase_EntriesTable").on("click", ".remove", function (event) {
        $(this).closest("tr").remove();       
        counter -= 1
    });
	
  });
</script>

<?php $this->load->view('includes/footer'); ?>
<script type="text/javascript">
	$(function(){

     $('body').on("keyup",".txtMult input", multInputs);
    
       function multInputs() {
     
    var TotalQuantity = 0;
    var TotalDiscount = 0;
    var TotalTaxAmount = 0;
    var TotalAmount = 0;
    var NetAmount = 0;
    var TotalNetAmount = 0;

    $('tr.txtMult').each(function () {

      var Quantity = $('.Quantity', this).val();
      var Rate = $('.Rate', this).val();
      var DiscountAmount = $('.DiscountAmount', this).val();

      var QuantityVal = (isNaN(parseFloat(Quantity))) ? 0 : parseFloat(Quantity);
      var RateVal = (isNaN(parseFloat(Rate))) ? 0 : parseFloat(Rate);
      var DiscountAmountVal = (isNaN(parseFloat(DiscountAmount))) ? 0 : parseFloat(DiscountAmount);

      var Amount = (QuantityVal * 1) * (RateVal * 1);

/*      var TaxAmount = ((Amount * TaxPercentage) / 100); 
      $('.TaxAmount',this).val((TaxAmount).toFixed(2));
      TotalTaxAmount += TaxAmount;*/
      
      if(DiscountAmountVal != 0) 
      {
     NetAmount = (Amount - DiscountAmountVal);
      }
      else
      {
     NetAmount = (Amount);
      }
      
      $('.Amount',this).val(Amount);
      $('.NetAmount',this).val(NetAmount);
       //TotalQuantity = (TotalQuantity * 1) + (QuantityVal * 1);
      TotalQuantity += QuantityVal;
      TotalDiscount += DiscountAmountVal;
      TotalAmount += Amount;
      TotalNetAmount += NetAmount;
  });
        $('#Quantity').text((TotalQuantity).toFixed(2))
        $('#Amount').text((TotalAmount).toFixed(2))
        $('#DiscountAmount').text((TotalDiscount).toFixed(2));
        $('#TotalAmount').text((TotalNetAmount).toFixed(2));

       }
  });  

 $(function(){

    $("#PurchaseReturnType").on('change', function(){
      if($("#PurchaseReturnType").val() == "1")
      {
        $("#BankAccountId").attr('disabled', true);
      }

      if($("#PurchaseReturnType").val() == "2")
      {
        $("#BankAccountId").attr('disabled', true);
      }

      if($("#PurchaseReturnType").val() == "3" || $("#PurchaseReturnType").val() == ""){
        $("#BankAccountId").attr('disabled', false);
      }
      
    })

      
//    })

    // Auto Select Produt List
    //$(document).on('keyup','input[id^=ProductName]',function(){ 
    $('body').on("keyup", "input[id^=ProductName]", function(){
      
      	/*var VendorArraySplit = VendorArray.split("-");
        var VendorId = VendorArraySplit[0];
        var CoAId = VendorArraySplit[1];*/

            var  ProductId  = ($(this).attr('id'));
            var  ProductName = $(this).val();
      
            $(this).autocomplete({
    
                source: function(request, response)   {
                    $.ajax({
                        url: "<?php echo site_url('Purchase/AutoCompleteProductList')?>",
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
                    $("#hdn"+ProductId).val(ui.item.id); // save selected id to hidden input
    },
                minLength: 2
            });
        }); 
    

     // Auto Select Location List
     $('body').on("keyup", "input[id^=LocationName]", function(){
      
            var  LocationId  = ($(this).attr('id'));
            var  LocationName = $(this).val();
      
            $(this).autocomplete({
    
                source: function(request, response)   {
                    $.ajax({
                        url: "<?php echo site_url('Purchase/AutoCompleteLocationList')?>",
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
                        url: "<?php echo site_url('Purchase/AutoCompleteColourList')?>",
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
                   url: "<?php echo base_url('Purchase/GetRemainingProduct'); ?>",
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
              if(ProductName === '' || ProductName == 0)
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

        $("#basic_validate").submit(function(e){
          var SNo = 1;
            $("input[id^=LocationName]").each(function(){
            var LocationName = $(this).val();
              if(LocationName === '' || LocationName == 0)
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
              if(ColourName === '' || ColourName == 0)
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

        $("#basic_validate").submit(function(e){
          var SNo = 1;
            $("input[id^=Rate]").each(function(){
            var Rate = $(this).val();
              if(Rate === '' || Rate == 0)
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
              if(Quantity === '' || Quantity == 0)
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
            $("input[id^=VendorId]").each(function(){
            var VendorId = $(this).val();
              if(VendorId === '' || VendorId == 0)
              {
                 //alert("Please fill this field");
                 $(this).css('border-color', 'red');
                 e.preventDefault();
                 $(this).focus;
              }
              if(VendorId != '' || VendorId != 0){
                $(this).css('border-color', 'green');
              }
          SNo++;
            });
          });

      });    // end of main jQuery


 </script>

  <script type="text/javascript">

  $(function(){
      $("#VendorId").on('change', function(){
        var VendorArray = $("#VendorId").val();
        var VendorArraySplit = VendorArray.split("-");
        var VendorId = VendorArraySplit[0];
        var CoAId = VendorArraySplit[1];

        $.ajax({
          url: '<?php echo base_url() ?>Purchase/AccountPayableAmount',
          type: 'post',
          dataType: 'html',
          data: {VendorId:VendorId,CoAId:CoAId},
          success:function(response){
//            alert(response);
            $("#AccountPayable").html("Account Payable Amount is: "+response);

          },
          error:function(){
            alert('no record found');
          }
        })


      })
  })
   
 </script>

	})
</script>