<?php 
$this->load->view('includes/header');
$this->load->view('includes/sidebar');          
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
      <h1><i class="fa fa-laptop"></i>&nbsp;Purchase Return</h1>
    </section>
    
    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-md-12">
          <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title text-light-blue">Edit Purchase Return</h3>
            </div>
      <?php echo "<font style=color:#00468E; font-weight:bold text-align:center;>".$this->session->flashdata('record_update')."</font>"; ?>
      
            <form role="form" id="PurchaseForm" action='<?php echo base_url("PurchaseReturn/UpdatePurchaseReturn") ?>' method="post">
      <input type="hidden" name="PurchaseReturnId" id="PurchaseReturnId" class="form-control" value="<?php echo $Purchases->PurchaseReturnId; ?>">
      <input type="hidden" name="PurchaseReturnNo" id="PurchaseReturnNo" class="form-control" value="<?php echo $Purchases->PurchaseReturnNo; ?>">
      
      <div class="box-body">
        <div class="row invoice-info">
    <div class="col-sm-3 invoice-col">
      <address>
        <strong>Purchase Return #:</strong><br>
        <span style="color:#3333CC; font-size:13px; font-weight:bold;"><?php echo $Purchases->PurchaseReturnId; ?></span>
      </address>
    </div>

    <div class="col-sm-3 invoice-col">
      <address>
        <strong>Vendor:</strong><br>
        <select name="VendorId" id="VendorId" class="form-control select2" style="width:215px; text-align:left;" >
      <option value="">Select Vendor</option>
      <?php foreach ($AllVendors as $VendorRecord) { ?>
      <option <?php echo $Purchases->VendorId == $VendorRecord['VendorId'] ? 'selected=selected' : ''; ?> value="<?php echo $VendorRecord['VendorId'] . "-" .$VendorRecord['ChartOfAccountId']; ?>"><?php echo $VendorRecord['VendorName'];?></option>
      <?php } ?>
          </select>
          </address>
    </div>

    <div class="col-sm-3 invoice-col">
      <address>
        <strong>Bank Account:</strong><br>
           <select name="BankAccountId" class="form-control select2" style="width: 215px;">
                <option value=""> Select Bank Account</option>
                <?php  foreach ($GetAllBankAccounts as $BankAccounts) {
                ?>
                <option <?php echo $Purchases->AccountId == $BankAccounts['AccountId'] ? 'selected=selected' : '' ?> value="<?php echo $BankAccounts['AccountId'].'-'.$BankAccounts['ChartOfAccountId']; ?>"><?php echo $BankAccounts['AccountTitle'] . " - " . $BankAccounts['AccountNumber'];  ?></option>
                <?php
                 } ?>
              </select>
      </address>
    </div>

    <div class="col-sm-3 invoice-col">
      <address>
        <strong>Purchase Return Date:</strong><br>
        <input class="form-control" id="datepicker1" type="text" name="PurchaseReturnDate" value="<?php echo date("m/d/Y", strtotime($Purchases->PurchaseReturnDate)); ?>" style="width: 215px;">
                  </address>
    </div>

    <div class="col-sm-3 invoice-col">
      <address>
        <strong>Purchase Return Type:</strong><br>
        <select name="PurchaseReturnType" id="PurchaseReturnType" style="width:215px;" class="form-control" required="required">
        <option value="1" <?php if($Purchases->PurchaseReturnType == 1){ echo "selected=selected" ; } ?> >On Cash</option>
        <option value="2" <?php if($Purchases->PurchaseReturnType == 2){ echo "selected=selected" ; } ?> >On Credit</option>
        <option value="3" <?php if($Purchases->PurchaseReturnType == 3){ echo "selected=selected" ; } ?> >Online</option>
        </select>
      </address>
    </div>


    <div class="col-sm-3 invoice-col">
      <address>
        <strong>Purchase Return Note:</strong><br>
        <input type="text" name="PurchaseReturnNote" id="PurchaseReturnNote" value="<?php echo $Purchases->PurchaseReturnNote; ?>" class="form-control">
      </address>
    </div>

        </div>
    </div>
    
      <div class="row">
    <div class="col-md-12">
      <div class="box-body pad table-responsive">
        <table class='table table-bordered text-center' id="Purchase_EntriesTable">
       <tr style="background-color:#ECF9FF;">
          <th style="width:2%;">S.#</th>
      <th style="padding:5px; width:10%; text-align: left;">Item</th>
      <th style="padding:5px; width:10%; text-align: left;">Location</th>
      <th style="padding:5px; width:10%; text-align: left;">Color</th>
      <th style="padding:5px; width:10%;">Rate</th>
      <th style="padding:5px; width:10%;">Qty</th>
      <th style="padding:5px; width:10%;">Amount</th>
      <th style="padding:5px; width:10%;">Dis: Amt</th>
      <th style="padding:5px; width:10%;">Net Amount</th>
      <th style="padding:5px; width:20%; text-align: left;">Comments</th>
        <th style='padding:5px; text-align:center;'><span class='fa fa-trash'></span></th>
         </tr>
    <?php 

      $TotalNetAmount = 0;
        $Quantity = 0;
        $Amount = 0;
        $DiscountAmount = 0;
        $NetAmount = 0;

      $SNo = 1; 
      foreach($PurchaseDetail as $Record) {
    ?>
    <tr class="txtMult">
     <td style="margin-top:15px;line-height:25px"><?php echo $SNo; ?></td>
     <td>
      <input style='width:130px;margin-top:1px;' type='text' name="ProductName[]" id="ProductId_<?php echo $SNo?>" autocomplete="off"value="<?php echo $Record['ProductName'];?>">
      <input type='hidden' id="hdnProductName_<?php echo $SNo; ?>" name="ProductId[]" value="<?php echo $Record['ProductId'];?>">
      <input type='hidden' id="OldhdnProductName_<?php echo $SNo; ?>" name="OldProductId[]" value="<?php echo $Record['ProductId'];?>">
     </td>
     <td>
      <input style='width:95%;margin-top:1px;' type='text' id="LocationName_<?php echo $SNo?>" autocomplete="off" value="<?php echo $Record['LocationName'];?>" >
     <input type='hidden' id="hdnLocationName_<?php echo $SNo?>" name="LocationId[]" value="<?php echo $Record['LocationId'];?>">
     <input type='hidden' id="OldhdnLocationName_<?php echo $SNo?>" name="OldLocationId[]" value="<?php echo $Record['LocationId'];?>">
     </td>
     <td style="text-align:center;">
      <input style='width:95%; margin-top:1px;' type='text' name="ColourName[]" id="ColourName_<?php echo $SNo?>" autocomplete="off" value="<?php echo $Record['ColourName'];?>">
     <input type='hidden' id="hdnColourName_<?php echo $SNo?>" name="ColourId[]" value="<?php echo $Record['ColourId'];?>" >
     <input type='hidden' id="OldhdnColourName_<?php echo $SNo?>" name="OldColourId[]" value="<?php echo $Record['ColourId'];?>" >
     </td>
     <td><input style='width:90%; margin-top:1px;' type='number' id="Rate<?php print $SNo; ?>" class="Rate" name='Rate[]' autocomplete="off" value="<?php echo $Record['Rate'];?>" min="0" step="0.01"></td>
     <td style="text-align:center;"><input style='width:100%;margin-top:1px; text-align:right;' type='number' id="Quantity<?php print $SNo; ?>" class="Quantity" name='Quantity[]' autocomplete="off" value="<?php echo $Record['Quantity'];?>" min="0" step="0.01"></td>
     <input style='width:100%;margin-top:1px; text-align:right;' type='hidden' id="OldQuantity<?php print $SNo; ?>" class="Quantity" name='OldQuantity[]' autocomplete="off" value="<?php echo $Record['Quantity'];?>" min="0" step="0.01">
     <td><input style='width:90%; margin-top:1px; text-align:right;' type='number' id="Amount<?php print $SNo; ?>" class="Amount" name='Amount[]' value="<?php echo $Record['Amount'];?>" min="0" step="0.01"></td>
     <td><input style='width:90%; margin-top:1px; text-align:right;' type='number' id="DiscountAmount<?php print $SNo; ?>" class="DiscountAmount" name='DiscountAmount[]' value="<?php echo $Record['DiscountAmount'];?>" min="0" step="0.01"></td>
     <td><input style='width:90%; margin-top:1px; text-align:right;' type='number' id="NetAmount<?php print $SNo; ?>" class="NetAmount" name='NetAmount[]' value="<?php echo $Record['NetAmount'];?>" min="0" step="0.01"></td>
     <td><input style='width:100%; text-align:left; margin-top:1px;' type='text' id="Comments<?php print $SNo; ?>" name='Comments[]' value="<?php echo $Record['Comments']; ?>"></td>
        <td style="padding:5px; width:2%;"><?php if($SNo != 1) { ?><span style='color:red;' id='remove_".$SNo."' class='fa fa-times-circle'></span><?php } ?></td>
        </tr>
    <?php 
        $Quantity += $Record['Quantity'];
          $Amount += $Record['Amount'];
          $DiscountAmount += $Record['DiscountAmount'];
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
     <span style="cursor:pointer; color:darkgreen; font-weight:600;" id="addRow" class="fa fa-plus">Add Row</span>
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
          <td><div id="DiscountAmount" style='font-weight:600; text-align:right; color:#008000;'><?php echo number_format($DiscountAmount,2,'.',''); ?></div></td>
        </tr>

        <tr>
          <td colspan="12" style="width: 90%; text-align:right; font-weight:600; border: 0px solid;">Total Net Amount:</td>
          <td><div id="TotalAmount" style='font-weight:600; text-align:right; color:#008000;'><?php echo number_format($NetAmount,2,'.',''); ?></div></td>
        </tr>



        </tbody>
       </table>

      </div>
    </div>
        </div>
        <?php // } ?> 

        <div class="box-body">
    <div class="row">
      <div class="col-md-2">
        <button type="submit" name="submitForm" value="UpdatePurchaseRecord" name="UpdateRecordBtn" class="btn btn-block btn-primary">Update Record</button>
      </div>
      <div class="col-md-2">
        <a href="<?php echo base_url(); ?>Purchase/"><button type="button" name="cancelForm" value="cancelUpdate" class="btn btn-block btn-primary">Back to Main</button></a>
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
 
     var counter = $("#SNo").val();
    // Add New Row class="txtMult"
    $("#addRow").on("click",function(){
  
  var newRow = $("<tr class='txtMult'>");
    var cols = "";

/*    var txtId = $("input[id^=NetAmount]:last").attr("id");
    var arr = txtId.split("_");
    var nextTxtId = (parseInt(arr[1]) +1);*/
     
  cols += '<td style="margin-top:15px;line-height:25px">' + counter + '</td>';
  cols += '<td><input style="width:130px;margin-top:1px;" class="select2" type="text" id="ProductId_'+ counter +'" name="ProductName[]"><input style="width:90%;" type="hidden" id="hdnProductId_'+ counter +'" name="ProductId[]"></td>';
  cols += '<td style="text-align:center;"><input style="width:95%; margin-top:1px;" class="select2" type="text" id="LocationName_'+ counter +'" name="LocationName_[]"><input style="width:90%;" type="hidden" id="hdnLocationName_'+ counter +'" name="LocationId[]"></td>';
  cols += '<td style="text-align:center;"><input style="width:95%; margin-top:1px;" class="select2" type="text" id="ColourName_'+ counter +'" name="ColourName[]"><input style="width:90%;" type="hidden" id="hdnColourName_'+ counter +'" name="ColourId[]"></td>';
  cols += '<td><input style="width:90%; margin-top:1px; text-align:right;" type="number" id="Rate'+ counter +'" class="Rate" name="Rate[]" autocomplete="off" min="0" step="0.01"></td>';
  cols += '<td><input style="width:100%; margin-top:1px; text-align:right;" type="number" id="Quantity'+ counter +'" class="Quantity" name="Quantity[]" autocomplete="off" min="0" step="0.01"></td>';
  cols += '<td><input style="width:90%; margin-top:1px; text-align:right;" type="number" id="Amount'+ counter +'" class="Amount" name="Amount[]" min="0" step="0.01"></td>';
  cols += '<td><input style="width:90%; margin-top:1px; text-align:right;" type="number" id="DiscountAmount'+ counter +'" class="DiscountAmount" name="DiscountAmount[]" min="0" step="0.01"></td>';
  cols += '<td><input style="width:100%; margin-top:1px; text-align:right;" type="number" id="NetAmount'+ counter +'" class="NetAmount" name="NetAmount[]" min="0" step="0.01"></td>';
  cols += '<td><input style="width:215px; text-align:left; margin-top:1px;" type="text" id="Comments_'+ counter +'" name="Comments[]"></td>'
  cols += '<td style="width:70px;text-align:right; cursor:pointer; color:red;"><i class="fa fa-trash remove" title="Delete" style="margin-top:1px;"></i></td>';

      newRow.append(cols);
        $("#Purchase_EntriesTable").append(newRow);
      counter++;
     }) 
  });
 </script>
  <script>
 $(function(){
     
  // Autocomplete Search Product Name
  $(document).on('keyup','input[id^=ProductId]',function(){
    
    var ProductId = ($(this).attr('id'));
    var  ProductName= $(this).val();
    
    $(this).autocomplete({
    
    source: function(request, response) {
    $.ajax({
        url: "<?php echo site_url('Purchase/AutoCompleteProductList'); ?>",
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
//     alert(ui.item.id);
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
          alert("Rate is not defined for this vendor/product");
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
 
 <script>
     
 $(function(){

    

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



</script>
<?php $this->load->view('includes/footer'); ?>
<script>
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

</script>