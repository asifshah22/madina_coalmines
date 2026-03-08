<?php $this->load->view('includes/header'); ?>
<?php $this->load->view('includes/sidebar'); ?>
<script type="text/javascript" src="//code.jquery.com/jquery-2.1.0.jsssss"></script>
<?php 

$References = '<select name="ReferenceId" id="ReferenceId" style="width:215px;" class="form-control select2">';
$References .= '<option value="">Select Reference</option>';
foreach ($AllReferences as $ReferenceRecord) {
$References .= '<option value='.$ReferenceRecord['ReferenceId'].'>'.$ReferenceRecord['FullName'].'</option>';
}
$References .= '</select>';
?>
      <!-- /.main-content starts -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1><i class="fa fa-clipboard"></i>&nbsp;Delivery Challan</h1>
    </section>
    
    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-md-12">
          <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title text-light-blue">Add Delivery Challan</h3>
            </div>
	    <?php echo "<font style=color:#00468E; font-weight:bold text-align:center;>".$this->session->flashdata('record_update')."</font>"; ?>
      
           <form role="form" id="SaleOrderForm" action='<?php echo base_url("Quotation/SaveQuotation") ?>' method="post">
	 
	 <div class="box-body">
        <div class="row invoice-info">
	<div class="col-sm-3 invoice-col">
      <address>
        <strong>DC #:</strong><br>
        <span style="color:#3333CC; font-size:13px; font-weight:bold;">(Auto Generated)
	</span>
      </address>
    </div>	
    <input type="hidden" name="ReferenceName" id="ReferenceName" />
    <input type="hidden" name="TotalTaxAmount" id="TotalTaxAmount" />
    
    <div class="col-sm-3 invoice-col">
      <address>
        <strong>Customer / Business Name:</strong><br>
	<select name="CustomerId" id="CustomerId" class="select2 form-control" style="width:215px;" required="required">
          <option value="">Select Customer</option>
            <?php $i=0; foreach ($AllCustomers as $CustomerRecord) { ?>
          <option <?php echo ($i==0)? "selected":"";  $i++?> value="<?php echo $CustomerRecord['CustomerId'].'-'.$CustomerRecord['ChartOfAccountId']; ?>"><?php echo $CustomerRecord['CustomerName'];  ?></option>
            <?php
            } ?>
        </select>
      </address>
    </div>

    <div class="col-sm-3 invoice-col">
      <address>
        <strong>Transportation:</strong><br>
       <?php echo $References; ?>
      </address>
    </div>

    <div class="col-sm-3 invoice-col">
      <address>
        <strong>P.O No:</strong><br>
        <input class="form-control" name="CustomerName" id="CustomerName" type="text" style="width:215px;" value="" autocomplete="off">
      </address>
    </div>
    

    <div class="col-sm-3 invoice-col">
      <address>
        <strong>P.O Date:</strong><br>
        <input class="form-control" name="CellNo" id="CellNo" type="text" style="width:215px;" value="" autocomplete="off">
      </address>
    </div>

    <div class="col-sm-3 invoice-col">
      <address>
        <strong>DC Date:</strong><br>
        <input class="form-control" name="SaleDate" id="datepicker" type="text" style="width:215px;" value="<?php date_default_timezone_set("Asia/Karachi");  echo date("m/d/Y h:i:s"); ?>" autocomplete="on">
      </address>
    </div>

    <div class="col-sm-3 invoice-col">
      <address>
        <strong>Vehicle No:</strong><br>
        <input class="form-control" name="SaleNote" id="SaleNote" type="text" style="width:215px;" value="" autocomplete="off">
      </address>
    </div>

    <div class="col-sm-3 invoice-col">
      <address>
        <strong>Remarks:</strong><br>
        <input class="form-control" name="Address" id="Address" type="text" style="width:215px;" value="" autocomplete="off">
      </address>
    </div>

    
        </div>
      </div>
    <div class="row" style="display: block;" id="mainRow">
    <div class="col-md-12">
      <div class="box-body pad table-responsive">

    <div style="overflow-x: auto; width: 100%;">
<table class='table table-bordered' id="Sale_EntriesTable" style="width: 100%; border-collapse: separate; border-spacing: 0;">
    <thead>    
        <tr style="background: linear-gradient(to bottom, #f8f9fa, #e9ecef);">
	<th style="width:2%;">S.#</th>
	<th style="width:5%;">P.O No#</th>
	<th style="padding:5px; width:10%; text-align: left;">P/Description</th>
	<th style="padding:5px; width:10%; text-align: left;">Location</th>
	<th style="padding:5px; width:10%;">Rate</th>
	<th style="padding:5px; width:10%;">Qty</th>
	<th style="padding:5px; width:10%;">Amount</th>
	<th style="padding:5px; width:10%;">Dis: Amt</th>
	<th style="padding:5px; width:5%;">Dist %</th>
	<th style="padding:5px; width:10%;">Discount</th>
	<th style="padding:5px; width:10%;">Net Amount</th>
		<th style="padding:5px; width:10%;">Notes</th>
	<th style='padding:5px; text-align:center;'><span class='fa fa-trash'></span></th>
        </tr>
	</thead>	
	<?php $i = 1; ?>
	<tbody id="ItemList">

	</tbody>
      </table>
      <table class="table" border="0">
        <tbody>
        <tr>
         <td colspan="13">
	 <span style="cursor:pointer; color:darkgreen; font-weight:600;" id="addrow" class="fa fa-plus">Add Row</span>
         </td>
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

    <div class="box-body">
    <div class="row">
      <div class="col-md-2">
        <button type="submit" name="AddQuotationRecordBtn" value="AddQuotationRecord" id="AddRecord" class="btn btn-block btn-success">Save Record</button>
      </div>
      <div class="col-md-2">
        <a href="<?php echo base_url(); ?>Quotation/"><button type="button" name="" value="cancelUpdate" class="btn btn-block btn-primary">Back to Main</button></a>
      </div>
    </div>
        </div>

      </div>
    </div>
        </div>
        <?php // } ?> 
  
            </form>
            </div>
          </div>
        </div>
      </section>
    </div>
  <?php $this->load->view('includes/footer'); ?>
<script src="<?php echo base_url();?>plugins/autocomplete/jquery-ui.js"></script>
<link rel="stylesheet" href="<?php echo base_url();?>plugins/autocomplete/jquery-ui.css" />

<script>
  $(document).ready(function () {
      
    // $('#ReferenceId').load('<?php echo base_url("Sales/AllReferences")?>');
 
    // Add New Row Script 
    $('body').on("click", "#addrow", function(e) {
	$("#Sale_EntriesTable").append(newRow());
    });
    
    // Start Remove row script
    $("#Sale_EntriesTable").on("click", ".remove", function (event) {
        $(this).closest("tr").remove();       
       // counter -= 1
    });
    // End of Add new row script 
    
    function newRow() 
    {
	var counter = $("#Sale_EntriesTable tr").length -1;
	counter++;
	
var cols = '<tr class="txtMult"><td style="margin-top:15px;line-height:25px">'+ counter + '</td>';
cols += '<td><input style="width:100px;margin-top:1px;" type="text" id="txtCode" name="ProductBarCode[]" class="barcodeinput"></td>';
cols += '<td><input style="width:100px;margin-top:1px;" type="text" id="ProductId_'+ counter +'" name="ProductName[]"><input type="hidden" id="hdnProductId_'+ counter +'" class="hdnProductId" name="hdnProductName[]"></td>';
cols += '<td style="text-align:center;"><input style="width:100%; margin-top:1px;" type="text" id="LocationName_'+ counter +'" name="LocationName_[]"><input style="width:90%;" type="hidden" id="hdnLocationName_'+ counter +'" name="LocationId[]"></td>';
// cols += '<td style="text-align:center;"><input style="width:100%; margin-top:1px;" type="text" id="ColourName_'+ counter +'" name="ColourName[]"><input style="width:90%;" type="hidden" id="hdnColourName_'+ counter +'" name="ColourId[]"></td>';
cols += '<td><input style="width:100%; margin-top:1px; text-align:right;" type="number" id="Rate_'+ counter +'" class="Rate" name="Rate[]" autocomplete="off" step="0.01" min="0"></td>';
cols += '<td><input style="width:100%; margin-top:1px; text-align:right;" type="number" id="Quantity_'+counter+'" class="Quantity" name="Quantity[]" autocomplete="off" step="any" min="0"></td>';
cols += '<td><input style="width:100%; margin-top:1px; text-align:right;" type="number" id="Amount'+ counter +'" class="Amount" name="Amount[]" step="any" min="0"></td>';
cols += '<td><input style="width:100%; margin-top:1px; text-align:right;" type="number" id="DiscountAmount_'+ counter +'" class="DiscountAmount" name="DiscountAmount[]" step="any" min="0"></td>';
cols += '<td><input style="width:100%; margin-top:1px; text-align:right;" type="number" id="TaxPercentage_'+ counter +'" class="TaxPercentage" name="TaxPercentage[]" step="any" min="0"></td>';
cols += '<td><input style="width:100%; margin-top:1px; text-align:right;" type="number" id="TaxAmount'+ counter +'" class="TaxAmount" name="TaxAmount[]" step="any" min="0"></td>';
cols += '<td><input style="width:100%; margin-top:1px; text-align:right;" type="number" id="NetAmount'+ counter +'" class="NetAmount" name="NetAmount[]" step="any" min="0"></td>';
cols += '<td><input style="width:100%; margin-top:1px; text-align:right;" type="number" id="Notes'+ counter +'" class="Notes" name="Notes[]" step="any"></td>';
cols += '<td><input type="hidden" id="SaleCartId_'+ counter +'" class="SaleCartId" name="SaleCartId[]"><i class="fa fa-times-circle remove" title="Delete" style="cursor:pointer; margin-top:6px; color:red;"></i></td>';
return cols;
	};
	
	
// Start Remove row script
	$("#Sale_EntriesTable").on("click", ".remove", function (event) {
        $(this).closest("tr").remove();       
        counter -= 1
	});
	
	/*
		newRow.append(cols);
		$("#Sale_EntriesTable").append(newRow);
	 */
	

	// https://forum.jquery.com/topic/inserting-a-row-into-an-empty-table
     // Calculating total Quantity and Amount Script
     
     
   /*  $('body').on("keyup", "tr.txtMult", function(e) {
	 
	 $("#Sale_EntriesTable .Quantity").each(function () {
	     
	  var Quantity = $(this).val();
	  var ProductId = $('.hdnProductId', this).val();
	  
	    if ($.isNumeric(Quantity)) 
	    {
		//alert(ProductId);
		
	    }
	  });
   });
     
     */
             
    $('body').on("keyup",".txtMult input", multInputs);
    
function multInputs() {
     
    var TotalQuantity = 0;
    var TotalDiscount = 0;
    var TotalTaxAmount = 0;
    var TotalAmount = 0;
    var NetAmount = 0;
    var TotalNetAmount = 0;


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
      
  //      alert(Quantity);
      
      /*
      $('.Quantity', this).on('keyup', function(){
	  
       var Quantity = $('.Quantity', this).val();
	$.ajax({
	type:"post",
	url:"<?php // echo base_url('Sales/AddUpdateProduct'); ?>",
	dataType: 'html',
	data:{ProductId:ProductId, Quantity:Quantity},
      });
      })
      */
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
    
      // total_tax=((TotalNetAmount*totaltax)/100)
      TotalNetAmount=TotalNetAmount;
      
        $('#Quantity').text((TotalQuantity).toFixed(2))
        $('#Amount').text((TotalAmount).toFixed(2))
        $('#TaxAmount').text((TotalTaxAmount).toFixed(2));
        $('#DiscountAmount').text((TotalDiscount).toFixed(2));
        $('#TotalAmount').text((TotalNetAmount).toFixed(2));
        // $('#NetAmountTax').text((total_tax).toFixed(2));
      }
  });  

 $(function(){

    $("#SaleType").on('change', function(){
      if($("#SaleType").val() == "1")
      {
        $("#BankAccountId").attr('disabled', true);
      }

      if($("#SaleType").val() == "2")
      {
        $("#BankAccountId").attr('disabled', true);
      }

      if($("#SaleType").val() == "3" || $("#SaleType").val() == ""){
        $("#BankAccountId").attr('disabled', false);
      }
      
    })


      // add new customer from modal box shortcut in sale component
    $("#SaveCustomer").click(function(){
      var CustomerName = $("#CustomerName").val();
      var ContactName = $("#ContactName").val();
      var Address = $("#Address").val();
      var Email = $("#Email").val();
      var PhoneNo = $("#PhoneNo").val();
      var CellNo = $("#CellNo").val();
      var FaxNo = $("#FaxNo").val();
      var Website = $("#Website").val();

        if(CustomerName == "" || CustomerName == 0 || CustomerName == null){
          $("#CustomerName").css('border-color', 'red');
          alert("Please Enter Customer Name");
          return false;
        }

      $.ajax({
          url: '<?php echo base_url("Customer/SaveCustomer")?>',
          type: 'post',
          dataType: 'html',
          data: {CustomerName:CustomerName,ContactName:ContactName,Address:Address,Email:Email,PhoneNo:PhoneNo,CellNo:CellNo,FaxNo:FaxNo,Website:Website},
          success: function(response){
            $('#CustomerId').load('<?php echo base_url("Sales/AllCustomers")?>')
            $('#SuccessMsg').text('Customer added Successfuly...!')
//            $('input').val('');
            $('#Customer').find('input').val("");
          }
      });

      });

    // Auto Select Produt List
    //$(document).on('keyup','input[id^=ProductName]',function(){ 
 /*   $('body').on("keyup", "input[id^=ProductId]", function(){
      
            var  ProductId  = ($(this).attr('id'));
            var  ProductName = $(this).val();
      
            $(this).autocomplete({
    
                source: function(request, response)   {
                    $.ajax({
                        url: "<?php // echo site_url('Sales/AutoCompleteProductList')?>",
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
//                    $("#hdn"+ProductId).val(ui.item.id); // save selected id to hidden input
                    },
                minLength: 2
            });
        }); 

*/
        // $(document).on('focusout','input[id^=ProductName]',function(){
        //     var id = $(this).attr('id');
        //     var Attr = id.split("_");
        //     var IdAttr = Attr[1];

        //     var PId2 = window.PId;

        //     $.ajax({
        //        type: 'POST',
        //        dataType: 'html',
        //        data: ('ProductId='+PId2),
        //        url: "<?php //echo base_url('Sales/GetRemainingProduct'); ?>",
        //        success: function(response){
        //         $('#Quantity'+IdAttr).val(response);
        //        }
        //     });
        // })
        //     IdR = 0;
    

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

/*            $('body').on('change', 'input[id^=LocationName]', function(){
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
            });*/

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
              if(CustomerId == "" || CustomerId == null)
              {
                 //alert("Please fill this field");
                 $(this).css('border-color', 'red');
                 e.preventDefault();
                 $(this).focus;
              }
              if(CustomerId != "" || CustomerId != 0){
                $(this).css('border-color', 'green');
              }
          SNo++;
            });
          });


      });    // end of main jQuery


</script>

<script>
$(function(){
  // Autocomplete Search Product Name
  $(document).on('keyup','input[id^=ProductId]',function(){
    var ProductId = ($(this).attr('id'));
    var ProductName= $(this).val();
    var locationdata= "";
    var colordata="";
    $.ajax({
            url: "<?php echo site_url('Sales/AutoCompleteColourList')?>",
            data: { ColourName:"Geniune"},
            dataType: "json",
            type: "POST",
            success: function(data) {
              colordata=data;
            }
      });
    $.ajax({
        url: "<?php echo site_url('Sales/AutoCompleteLocationList')?>",
        data: { LocationName:"Shop"},
        dataType: "json",
        type: "POST",
        success: function(data) {
          locationdata=data;
        }
    });
    
    $(this).autocomplete({
    
    source: function(request, response) {
    $.ajax({
        url: "<?php echo site_url('Sales/AutoCompleteProductList')?>",
        data: { ProductName:ProductName },
        dataType: "json",
        type: "POST",
        success: function(data) {
//      console.log(data);
        response(data);
//      alert(data.id);
        }
     });
    },
    select: function (event, ui) {
     $(this).val(ui.item.value); // display the selected text
    //  console.log(locationdata[0].value);
    const number = ProductId.split("_");
    //  $('#LocationName_'+number[1]).val(locationdata[0].value)
    //  $("#hdnLocationName_"+number[1]).val(locationdata[0].id);
     
     var colorName =(colordata.length > 0) ? colordata[0].value: "";
     var colorName2 =(colordata.length > 0) ? colordata[0].id: "";
     $('#ColourName_'+number[1]).val(colorName);
     $("#hdnColourName_"+number[1]).val(colorName2); 
     // save selected id to hidden input


     var p = ui.item.id.split('-');
     $("#hdn"+ProductId).val(p[0]);
      window.ProductId = p[0];
      window.Rate = p[1];
    },
    minLength: 2
     });    
    });
    
    
    $(document).on('focusout','input[id^=ProductId]',function(){
    
    var txtId = $("input[id^=ProductId]:last").attr("id");
    var txtId = $(this).attr("id");
    var nextTxtId = txtId.replace ( /[^\d.]/g, '' );
    
    // on focus out insert / update product record in cart table
    $.ajax({
        type: "POST",
	dataType: "json",
	url: "<?php echo site_url('Sales/AutoAddProductInCart')?>",
	data: { ProductId:window.ProductId },
        success: function(data) {
//      console.log(data);  
        response(data);
	$("#SaleCartId"+nextTxtId).val(window.Rate);
//      alert(data.id); hdnProductId
        }
     });
    
    // $("#ProductGroupId"+nextTxtId).text(PG);
     $("#Rate"+nextTxtId).val(window.Rate);
     
    })
    
    /*
	$.ajax({
	    type:"post",
	    url:"<?php // echo base_url('Sales/SearchProductByBarcode'); ?>",
	    dataType: 'html',
	    data:{Barcode : Barcode},
	    success: function(data){
	    $('#ItemList').html(data)
	    $("#txtCode").val('');
	    $("#txtCode").focus();
	    }
	});	
	*/
	
    /*   var counter = 0;
    $(document).on('focusout','input[id^=ProductId]',function(){

      var PId2 = window.PId;
      var IdR = window.IdAttr;
//      var Rate =
    $.ajax({
      url: '<?php // echo base_url(); ?>Sales/GetRemainingProduct',
      data:{Product:PId2,VendorId:VendorId},
      type: 'post',
      dataType: 'html',
      success:function(data){
        var SN = $("#SN").val();
        if(data == "0"){
//        for (var i = 1; i < SN.length; i++) {
          alert("Rate is not defined for this vendor/product");
//          console.log($("#Rate_"+counter).val(data));
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
    })
    }
    })*/

  });

 </script>

  <script type="text/javascript">

  $(function(){
      $("#CustomerId").on('change', function(){
        var CustomerArray = $("#CustomerId").val();
        var CustomerArraySplit = CustomerArray.split("-");
        var CustomerId = CustomerArraySplit[0];
        var CoAId = CustomerArraySplit[1];

        $.ajax({
          url: '<?php echo base_url() ?>Sales/AccountReceivableAmount',
          type: 'post',
          dataType: 'html',
          data: {CustomerId:CustomerId,CoAId:CoAId},
          success:function(response){
            $("#AccountReceivable").html("Account Receivable Amount is: "+response);

          },
          error:function(){
            alert('no record found');
          }
        })
      })
  })
 </script> 
 <script>
  $(document).ready(function() {
    // $("#CustomerId option:eq(2)").prop("selected", true);
    // $("#CustomerId").val($("#CustomerId option:nth(2)").val());
    $("#ReferenceId").change(function(){
      $("#ReferenceName").val(("#ReferenceId").find(":selected").text());
	  $(this).parent().hide();
    });
  });
</script>
<script type="text/javascript">

 // This is barcode searching script
    $(document).ready(function () {
    var keyupFiredCount = 0; 

    function DelayExecution(f, delay) {
        var timer = null; 
        return function () {
            var context = this, args = arguments;
           
            clearTimeout(timer);
            timer = window.setTimeout(function () {
                f.apply(context, args);
            },
            delay || 300);
        };
    }
    $.fn.ConvertToBarcodeTextbox = function () {

        $(this).focus(function () { $(this).select();$("#msg").html(""); });

         $(this).keydown(function (event) {
            var keycode = (event.keyCode ? event.keyCode : event.which); 
            
            if ($(this).val() == '') {
                keyupFiredCount = 0; 
            }  
            if (keycode == 13) {//enter key 
                    $(".nextcontrol").focus();
                    return false;
                    event.stopPropagation(); 
            } 
        });

        $(this).keyup(DelayExecution(function (event) {
            var keycode = (event.keyCode ? event.keyCode : event.which);  
                keyupFiredCount = keyupFiredCount + 1;  
        }));

         $(this).blur(function (event) {
             if ($(this).val() == '')
                 return false;
	     
            if(keyupFiredCount <= 1)
	    {
		var Barcode = $(this).val();
		
		$.ajax({
		  type:"post",
		  url:"<?php echo base_url('Sales/SearchProductByBarcode'); ?>",
		  dataType: 'html',
	  	  data:{Barcode : Barcode},
		  success: function(data){
		 $('#ItemList').html(data)
		 $("#txtCode").val('');
		 $("#txtCode").focus();
		 }
		});		
		
		
		/*
		$("#Sale_EntriesTable").append(newRow());
		$("#txtCode").val('');
		$("#txtCode").focus();
				
		function newRow() {

		var counter = $("#Sale_EntriesTable tr").length -1;
		counter++;

		var cols = '<tr><td style="margin-top:15px;line-height:25px">'+ counter + '</td>';  
		cols += '<td><input style="width:90px;margin-top:1px;" name="ProductName[]" type="text" value="'+ Barcode +'" id="ProductName_'+ counter +'" name="ProductName[]"><input style="width:90%;" type="hidden" id="hdnProductName_'+ counter +'" name="ProductId[]"></td>';
		cols += '<td style="text-align:center;"><input style="width:90%; margin-top:1px;" class="select2" type="text" id="LocationName_'+ counter +'" name="LocationName_[]"><input style="width:90%;" type="hidden" id="hdnLocationName_'+ counter +'" name="LocationId[]"></td>';
		cols += '<td style="text-align:center;"><input style="width:90%; margin-top:1px;" class="select2" type="text" id="ColourName_'+ counter +'" name="ColourName[]"><input style="width:90%;" type="hidden" id="hdnColourName_'+ counter +'" name="ColourId[]"></td>';
		cols += '<td><input style="width:90%; margin-top:1px; text-align:right;" type="number" id="Rate'+ counter +'" class="Rate" name="Rate[]" autocomplete="off" step="0.00"></td>';
		cols += '<td><input style="width:100%; margin-top:1px; text-align:right;" type="number" id="Quantity_'+counter+'" class="Quantity" name="Quantity[]" autocomplete="off" step="0.00"></td>';
		cols += '<td><input style="width:90%; margin-top:1px; text-align:right;" type="number" id="Amount'+ counter +'" class="Amount" name="Amount[]" step="0.00"></td>';
		cols += '<td><input style="width:90%; margin-top:1px; text-align:right;" type="number" id="DiscountAmount'+ counter +'" class="DiscountAmount" name="DiscountAmount[]" step="0.00"></td>';
		cols += '<td><input style="width:90%; margin-top:1px; text-align:right;" type="number" id="TaxPercentage'+ counter +'" class="TaxPercentage" name="TaxPercentage[]" step="0.00"></td>';
		cols += '<td><input style="width:90%; margin-top:1px; text-align:right;" type="number" id="TaxAmount'+ counter +'" class="TaxAmount" name="TaxAmount[]" step="0.00"></td>';
		cols += '<td><input style="width:90%; margin-top:1px; text-align:right;" type="number" id="NetAmount'+ counter +'" class="NetAmount" name="NetAmount[]" step="0.00"></td>';
		cols += '<td><i class="fa fa-trash remove" title="Delete" style="cursor:pointer; margin-top:6px; color:red;"></i></td>';

		return cols;
		};
		
		*/
	
	
                //$("#msg").html("<span style='color:green'>Its Scanner!</span>");
		
		/*
		var txtId = $("input[id^=Quantity]:last").attr("id");
		var arr = txtId.split("_");
		var counter = (parseInt(arr[1]) +1);
		 
		var newRow = $("<tr>");
		var cols = "";
		cols += '<td style="margin-top:15px;line-height:25px">' + counter + '</td>';
		cols += '<td><input style="width:90px;margin-top:1px;" class="select2" name="ProductName[]" type="text" value="'+Barcode+'" id="ProductName_'+ counter +'" name="ProductName[]"><input style="width:90%;" type="hidden" id="hdnProductName_'+ counter +'" name="ProductId[]"></td>'
		cols += '<td style="text-align:center;"><input style="width:90%; margin-top:1px;" class="select2" type="text" id="LocationName_'+ counter +'" name="LocationName_[]"><input style="width:90%;" type="hidden" id="hdnLocationName_'+ counter +'" name="LocationId[]"></td>';
		cols += '<td style="text-align:center;"><input style="width:90%; margin-top:1px;" class="select2" type="text" id="ColourName_'+ counter +'" name="ColourName[]"><input style="width:90%;" type="hidden" id="hdnColourName_'+ counter +'" name="ColourId[]"></td>';
		cols += '<td><input style="width:90%; margin-top:1px; text-align:right;" type="number" id="Rate'+ counter +'" class="Rate" name="Rate[]" autocomplete="off" step="0.00"></td>';
		cols += '<td><input style="width:100%; margin-top:1px; text-align:right;" type="number" id="Quantity_'+counter+'" class="Quantity" name="Quantity[]" autocomplete="off" step="0.00"></td>';
		cols += '<td><input style="width:90%; margin-top:1px; text-align:right;" type="number" id="Amount'+ counter +'" class="Amount" name="Amount[]" step="0.00"></td>';
		cols += '<td><input style="width:90%; margin-top:1px; text-align:right;" type="number" id="DiscountAmount'+ counter +'" class="DiscountAmount" name="DiscountAmount[]" step="0.00"></td>';
		cols += '<td><input style="width:90%; margin-top:1px; text-align:right;" type="number" id="TaxPercentage'+ counter +'" class="TaxPercentage" name="TaxPercentage[]" step="0.00"></td>';
		cols += '<td><input style="width:90%; margin-top:1px; text-align:right;" type="number" id="TaxAmount'+ counter +'" class="TaxAmount" name="TaxAmount[]" step="0.00"></td>';
		cols += '<td><input style="width:90%; margin-top:1px; text-align:right;" type="number" id="NetAmount'+ counter +'" class="NetAmount" name="NetAmount[]" step="0.00"></td>';
		cols += '<td style="width:50px;text-align:right; cursor:pointer; color:red;"><i class="fa fa-trash remove" title="Delete" style="margin-top:1px;"></i></td>';

		newRow.append(cols);
		$("#Sale_EntriesTable").append(newRow);
		*/
             }
             else 
             {
                 $("#msg").html("<span style='color:red'>Its Manually Typed!</span>");
                 //alert('Its Manual Entry');
             }

             keyupFiredCount = 0;
         }); 
    };
    try {
        $(".barcodeinput").ConvertToBarcodeTextbox();
        if ($(".barcodeinput").val() == '')
            $(".barcodeinput").focus();
        else
            $(".nextcontrol").focus(); 
    } catch (e) { }

});

</script>
<script type="text/javascript">
  $(function(){
  
       // Validation of Bill Quantity with Stock and Sale Order Quantity TaxPercentage
       $('body').on("keyup", "input[id^=Quantity]", function() {    

	  var Quantity = $(this).attr('id');
          var arr = Quantity.split("_")
          console.log(arr)
	  
	   var Quantity = $(this).val();
	   var SaleCartId = parseInt($("#SaleCartId_"+arr[1]).val());
     console.log($("#SaleCartId_1").val())
	   
	   var Rate = parseInt($("#Rate_"+arr[1]).val());
	   var DiscountAmount = parseInt($("#DiscountAmount_"+arr[1]).val());
	    
	   $.ajax({
              url:"<?php echo base_url('Sales/UpdateCart')?>",
              type:'post',
              data:{SaleCartId:SaleCartId,Quantity:Quantity,Rate:Rate,DiscountAmount:DiscountAmount},
              success:function(){
	
              }
             });	  
	 });  
	
        });  
</script>