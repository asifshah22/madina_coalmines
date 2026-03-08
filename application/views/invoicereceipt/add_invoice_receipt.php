<?php $this->load->view('includes/header'); ?>
<?php $this->load->view('includes/sidebar'); ?>
<script type="text/javascript" src="//code.jquery.com/jquery-2.1.0.jsssss"></script>
      <!-- /.main-content starts -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1><i class="fa fa-book"></i>&nbsp;Invoice Receipt</h1>
    </section>
    
    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-md-12">
          <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title text-light-blue">Add Invoice Receipt</h3>
            </div>
	    <?php echo "<font style=color:#00468E; font-weight:bold text-align:center;>".$this->session->flashdata('record_update')."</font>"; ?>
      
  <form role="form" class="form-horizontal" id="SaleOrderForm" action='<?php echo base_url("InvoiceReceipt/SaveInstallment") ?>' method="post">
	 
	 <div class="box-body">

      <div class="form-group">
        <label for="ProductName" class="col-sm-1 control-label">Date</label>
        <div class="col-sm-4">
          <input class="form-control" name="date" id="datepicker" type="text" value="<?php  echo date("m/d/Y"); ?>" autocomplete="on">
        </div>
      </div>

      <div class="form-group">
        <label for="ProductName" class="col-sm-1 control-label">Invoice No</label>
        <div class="col-sm-4">
          <input class="form-control" name="invoice_no" id="invoice_no" type="text" value="" autocomplete="on">
        </div>
      </div>

      <div class="form-group">
        <label for="ProductName" class="col-sm-1 control-label">Customer Name</label>
        <div class="col-sm-4">
          <input class="form-control" style="color: #002480;font-weight:bold;" name="customer_name" id="customer_name" type="text" value="" autocomplete="on">
        </div>
      </div>

      <div class="form-group">
        <label for="ProductName" class="col-sm-1 control-label">Department</label>
        <div class="col-sm-4">
        <input class="form-control" name="area" id="area" style="color: #008000;font-weight:bold;" type="text" value="" autocomplete="on">
        </div>
      </div>

      <div class="form-group">
        <label for="ProductName" class="col-sm-1 control-label">Invoice Balance:</label>
        <div class="col-sm-4">
        <input class="form-control" style="color: #c01043;font-weight:bold;" id="outstanding_amount" type="text" value="" autocomplete="on" readonly>
        </div>
      </div>

      <div class="form-group">
        <label for="ProductName" class="col-sm-1 control-label">Payment Type</label>
        <div class="col-sm-4">
          <select name="payment_type" id="payment_type" class="form-control" required="required">
              <option value="" selected="selected">Select Payment Type</option>
              <option value="1">On Cash</option>
              <option value="2">On Bank</option>
          </select>
        </div>
      </div>

      <div class="form-group">
        <label for="BankAccount" class="col-sm-1 control-label">Bank Account</label>
        <div class="col-sm-4">
          <select name="bank_account_id" id="bank_account_id" class="form-control" required="required">
              <option value="0">Select Bank Account</option>
                  <?php  foreach ($GetAllBankAccounts as $BankAccounts) { ?>
                  <option value="<?php echo $BankAccounts['AccountId'] . "-" .$BankAccounts['ChartOfAccountId']; ?>"><?php echo $BankAccounts['AccountTitle'] . " - " . $BankAccounts['AccountNumber'];  ?></option>
                  <?php
                  } ?>
          </select>
        </div>
      </div>

      <div class="form-group">
        <label for="ProductName" class="col-sm-1 control-label">Instrument / Cheque no</label>
        <div class="col-sm-4">
          <input class="form-control" name="slip_no" id="slip_no" type="text" value="" autocomplete="on">
        </div>
      </div>

      <div class="form-group">
        <label for="ProductName" class="col-sm-1 control-label">Receipt Amount</label>
        <div class="col-sm-4">
          <input class="form-control" name="amount" id="amount" type="number" value="0" autocomplete="on">
        </div>
      </div>

      <div class="form-group">
        <label for="ProductName" class="col-sm-1 control-label">Other Exp</label>
        <div class="col-sm-4">
          <input class="form-control" name="OtherExp" id="OtherExp"  onkeyup='inputbtn(1)' type="text" value="0" autocomplete="on">
        </div>
      </div>

      <div class="form-group">
        <label for="ProductName" class="col-sm-1 control-label">Late Payment</label>
        <div class="col-sm-4">
          <input class="form-control" name="LatePayment" id="LatePayment"  onkeyup='inputbtn(1)' type="text" value="0" autocomplete="on">
        </div>
      </div>
      <div class="form-group">
        <label for="ProductName" class="col-sm-1 control-label">GST</label>
        <div class="col-sm-4">
          <input class="form-control" name="Gst" id="Gst" type="text" onkeyup='inputbtn(1)' value="0" autocomplete="on">
        </div>
      </div>

      <div class="form-group">
        <label for="ProductName" class="col-sm-1 control-label">WH Tax</label>
        <div class="col-sm-4">
          <input class="form-control" name="Stampduty" id="Stampduty" onkeyup='inputbtn(1)' type="text" value="0" autocomplete="on">
        </div>
      </div>
      <div class="form-group">
        <label for="ProductName" class="col-sm-1 control-label">Income Tax</label>
        <div class="col-sm-4">
          <input class="form-control" name="Itax" id="Itax" type="text" onkeyup='inputbtn(1)'  value="0" autocomplete="on">
        </div>
      </div>

      <div class="form-group">
        <label for="ProductName" class="col-sm-1 control-label">Total Deduction</label>
        <div class="col-sm-4">
          <input class="form-control" name="remarks" id="remarks" type="text" value="" autocomplete="on">
          <!-- <input class="form-control" name="sale_id" id="sale_id" type="hidden" value="<?php //echo $InstallmentDetail[0]['SaleId']; ?>" autocomplete="on">-->
          <input class="form-control" name="client_id" id="client_id" type="hidden" value="" autocomplete="on"> 
          <input class="form-control" name="ChartOfAccountId" id="ChartOfAccountId" type="hidden" value="" autocomplete="on">
        </div>
      </div>
   
  </div>

  <div class="row" style="display: block;" id="mainRow">
    <div class="col-md-12">
      <div class="box-body pad table-responsive">


    <div class="box-body">
      <div class="row">
        <div class="col-md-2">
          <button type="submit" name="AddSaleRecordBtn" value="AddSaleRecord" id="AddRecord" class="btn btn-block btn-primary">Save Record</button>
        </div>
        <div class="col-md-2">
          <a href="<?php echo base_url(); ?>InvoiceReceipt/"><button type="button" name="" value="cancelUpdate" class="btn btn-block btn-primary">Back to Main</button></a>
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
  $('body').on('keyup','input[id^=invoice_no]',function(){

      var InvoiceNumber = $("#invoice_no").val();

      $.ajax({
        type: 'POST',
        dataType: 'html',
        data: {InvoiceNumber:InvoiceNumber},
        url: "<?php echo base_url('InvoiceReceipt/AutoCompleteSearch_COA'); ?>",
        success: function(response){
          var payObject = JSON.parse(response);
         $("#customer_name").val(payObject[0].CustomerName);
         $("#client_id").val(payObject[0].CustomerId);
         $("#ChartOfAccountId").val(payObject[0].ChartOfAccountId);
         $("#area").val(payObject[0].AreaName);
         $("#outstanding_amount").val(payObject[0].PreviousBalance);
        }
      });

      })
</script>

<script>
 // coder for ledger report criteria
$(document).ready(function() {
  $('#project_id').on('change', function() {
    var project_id = this.value;
      $.ajax({
        url: "<?php echo base_url() ?>Product/PlotName",
        type: "POST",
        data: {
        project_id: project_id
      },
      cache: false,
      success: function(result){
        $("#plot_id").html(result);
      }
  });
});  
});
 </script>
 <script>
  $(function(){
      $("#plot_id").on('change', function(){
        var plot_id = $("#plot_id").val();
       
        $.ajax({
          url: '<?php echo base_url() ?>Product/GetProductDetailById',
          type: 'post',
          data: {plot_id:plot_id},
          success:function(response){

            $("#square_feet").val(response);

          },
          error:function(){
            alert('no record found');
          }
        })
        
      })

    $("#rate").on('change', function(e){
      var square_feet = $("#square_feet").val();
      var rate = e.target.value;
      var amount = square_feet * rate;
      $("#amount").val(amount.toFixed(0));
    })

    $("#down_payment").on('change', function(e){
      var amount = $("#amount").val();
      var downPayment = e.target.value;
     
      var netAmount = amount - downPayment;
      $("#net_amount").val(netAmount.toFixed(0));
    })

    $("#installment").on('change', function(e){
      var netAmount = $("#net_amount").val();
      var noOfInstallment = e.target.value;
     
      var monthlyInstallment = (netAmount / noOfInstallment);
      $("#monthly_installment").val(monthlyInstallment.toFixed(0));
    })

  })
</script>
<script>
  $("#bank_account_id").attr('disabled', true);
  $("#payment_type").on('change', function(){
    
    if($("#payment_type").val() == "")
    {
      $("#bank_account_id").attr('disabled', true);
    }

    if($("#payment_type").val() == "1")
    {
      $("#bank_account_id").attr('disabled', true);
    }

    if($("#payment_type").val() == "2")
    {
      console.log($("#payment_type").val());
      $("#bank_account_id").attr('disabled', false);
    }

    })
</script>

<script>

function inputbtn(id){
// $( "input" ).on( "keyup", function() {
// $("input").keyup(function(){
   

            // id=$(this).val();
            tottax=0;
            // Invoiceamount=parseInt($('#Invoiceamount_').val());
            totItax=parseInt($('#Itax').val());
            totStampduty=parseInt($('#Stampduty').val());
            totGst=parseInt($('#Gst').val());
            totlatepayment=parseInt($('#LatePayment').val());
            tototherExpense=parseInt($('#OtherExp').val());
            
            console.log(totItax);
            console.log(totStampduty);
            console.log(totGst);
            console.log(totlatepayment);
            console.log(tototherExpense);
            tottax=parseInt(totItax)+parseInt(totStampduty)+parseInt(totGst)+parseInt(totlatepayment)+parseInt(tototherExpense)
        
             parseInt($('#remarks').val(tottax));
          
       
};


 $(function(){

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

      // add new reference from modal box shortcut in sale component
    $("#SaveReference").click(function(){
      var FullName = $("#FullName").val();
      var ContactNumber = $("#ContactNumber").val();
      var ReferenceAddress = $("#ReferenceAddress").val();
      var ReferenceEmail = $("#ReferenceEmail").val();

        if(FullName == "" || FullName == 0 || FullName == null){
          $("#FullName").css('border-color', 'red');
          alert("Please Enter Reference Name");
          return false;
        }
      $.ajax({
          url: '<?php echo base_url("Reference/SaveReference")?>',
          type: 'post',
          dataType: 'html',
          data: {FullName:FullName,ContactNumber:ContactNumber,Address:ReferenceAddress,Email:ReferenceEmail},
          success: function(response){
            $('#ReferenceId').load('<?php echo base_url("Sales/AllReferences")?>')
            $('#SuccessReferenceMsg').text('Reference added Successfuly...!')
//            $('input').val('');
            $('#Reference').find('input').val("");
          }
      });

    });

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
     $('#LocationName_'+number[1]).val(locationdata[0].value)
     $("#hdnLocationName_"+number[1]).val(locationdata[0].id);
     $('#ColourName_'+number[1]).val(colordata[0].value)
     $("#hdnColourName_"+number[1]).val(colordata[0].id); 
     // save selected id to hidden input


     var p = ui.item.id.split('-');
     $("#hdn"+ProductId).val(p[0]);
     
      window.ProductId = p[0];
      window.Rate = p[1];
    // var id = $(this).attr('id');
     //var Attr = id.split("_");
  //   window.IdAttr = Attr[1];
   //  $("#hdn"+ProductId).val(ui.item.id); // save selected id to hidden input
    // window.PId = ui.item.id;
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

     $.ajax({
        type: "POST",
	dataType: "json",
	url: "<?php echo site_url('Sales/GetProductLastSalePrice')?>",
	data: { ProductId:window.ProductId },
	success:function(data){
	    
	$("#LastSalePrice_"+nextTxtId).val(data);
 //       $('#ShowData').html(data)
//	$('#showMsg').text('')
      }
     });
     
     $.ajax({
        type: "POST",
	dataType: "json",
	url: "<?php echo site_url('Sales/GetProductLastPurchasePrice')?>",
	data: { ProductId:window.ProductId },
	success:function(data){
	    
	$("#LastPurchasePrice_"+nextTxtId).val(data);
 //       $('#ShowData').html(data)
//	$('#showMsg').text('')
      }
     });
     
      $.ajax({
        type: "POST",
    	dataType: "json",
    	url: "<?php echo site_url('Sales/GetProductSaleRates')?>",
    	data: { ProductId:window.ProductId },
    	success:function(data){
    	    
    	$("#Rate_"+nextTxtId).val(data);
      }
     });
    
    // $("#ProductGroupId"+nextTxtId).text(PG);
     $("#Rate"+nextTxtId).val(window.Rate);
     
    })

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