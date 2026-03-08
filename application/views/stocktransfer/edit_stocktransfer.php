<?php $this->load->view('admin/includes/header'); ?>
<?php $this->load->view('admin/includes/sidebar'); ?>

      <!-- /.main-content starts -->
      <div class="main-content">
        <div class="main-content-inner">
          
                     <!-- /.breadcrumb starts -->
          <div class="breadcrumbs ace-save-state" id="breadcrumbs">
            <ul class="breadcrumb">
              <li>
                <i class="ace-icon fa fa-home home-icon"></i>
                <a href="#">Home</a>
              </li>
              <li class="">Stock</li>
              <li class="active">Edit Stock Transfer</li>
            </ul><!-- /.breadcrumb -->

            <div class="nav-search" id="nav-search">
              <form class="form-search">
                <span class="input-icon">
                  <!-- <input type="text" placeholder="Search ..." class="nav-search-input" id="nav-search-input" autocomplete="off" />
                  <i class="ace-icon fa fa-search nav-search-icon"></i> -->
                </span>
              </form>
            </div><!-- /.nav-search -->
          </div>
          <!-- /.breadcrumb ends -->
          <?php $id = $StockTransfer[0]['StockTransferId']; ?>
 <form class="form-horizontal" method="post" action="<?php echo base_url("StockTransfer/UpdateStockTransfer/$id"); ?>" name="basic_validate" id="basic_validate" novalidate="novalidate">
          <div id="content">
	      <div class="page-content">
            <div class="page-header">
              <h1>Edit Stock Transfer</h1>
            </div><!-- /.page-header -->  
                    <!-- /.row  starts-->
                     <div class="box-body">
                      <div class="row">
                       
                        <div class="form-group">
              				<div class="col-xs-12 col-md-12">
			                   <?php echo $this->session->flashdata('record_added'); ?>
                          </div>
                        </div>
                        <?php
                        foreach ($StockTransfer as $row) {
                          $i = 0;
                        ?>

                        <div class="col-md-6">
                          <div class="form-group">
                            <div style="font-weight:600;" class="col-sm-4">Stock Transfer No:</div>
                            <div class="col-sm-8 col-sm-8"><?= $row['StockTransferId']; ?></div>
                          </div><!-- /.form-group -->

                        <div class="form-group">
                            <div style="font-weight:600;" class="col-sm-4">Location From:</div>
                            <div class="col-sm-8 col-sm-8">
                            <select name="StockTransferFrom" id="StockTransferFrom" style="width:200px;" required="required">
                              <?php // echo $Locations; ?>
                              <option value="0">Select Location</option>
                              <?php
                              foreach ($AllLocations as $LocationRecord) {
                                ?>
                                <option <?php echo $StockTransferFrom[0]['LocationId'] == $LocationRecord['LocationId'] ? 'selected=selected' : '' ?> value="<?php echo $LocationRecord['LocationId']; ?> - <?php echo $LocationRecord['LocationType']; ?>"><?php echo $LocationRecord['LocationName']; ?></option>
                              <?php
                                }
                              ?>  
                                </select>
                              
                            </div>
                          </div><!-- /.form-group -->

                          <div class="form-group">
                            <div style="font-weight:600;" class="col-sm-4"> Select Product </div>
                              <div class="col-sm-8 col-sm-8"> <input style='width:200px;' type='text' name="ProductName" id="ProductName_" autocomplete="off" value="<?php echo $row['ProductName']; ?>">
                                <input style='width:90%;' type='hidden' id="hdnProductName_" name="ProductId" value="<?php echo $row['ProductId']; ?>" >
                            </div>
                          </div>

                          <div class="form-group">
                            <div style="font-weight:600;" class="col-sm-4">Available Quantity:</div>
                            <div class="col-sm-8 col-sm-8"><input type="text" name="RemainingStock" id="RemainingStock" readonly="readonly" style="width: 200px;"></div>
                          </div><!-- /.form-group -->
                        </div>
                        
                        <div class="col-md-6">
                          <div class="form-group">
                            <div style="font-weight:600;" class="col-sm-4">Transfer Date:</div>
                            <div class="col-sm-8 col-sm-8"><input type="date" style="width: 200px;" name="StockTransferDate" value="<?php echo date('M d, Y',strtotime($row['StockTransferDate'])); ?>"></div>
                          </div><!-- /.form-group -->

                          <div class="form-group">
                            <div style="font-weight:600;" class="col-sm-4">Location To:</div>
                            <div class="col-sm-8 col-sm-8">
                              <select name="StockTransferTo" id="StockTransferTo" style="width: 200px;" required="required">
                              <option value="0">Select Location</option>
                              <?php
                              foreach ($AllLocations as $LocationRecord) {
                                ?>
                                <option <?php echo $StockTransferTo[0]['LocationId'] == $LocationRecord['LocationId'] ? 'selected=selected' : '' ?> value="<?php echo $LocationRecord['LocationId']; ?> - <?php echo $LocationRecord['LocationType']; ?>"><?php echo $LocationRecord['LocationName']; ?></option>
                              <?php
                                }
                              ?>  
                                </select>
                            </div><!-- /.form-group -->
                          </div>
                          
                          <div class="form-group">
                            <div style="font-weight:600;" class="col-sm-4">Select Color</div>
                            <div class="col-sm-8">
                               <input type='text' style="width: 200px;" name="ColourName" id="ColourName_" autocomplete="off" value="<?php echo $row['ColourName'];  ?>">
                            <input type='hidden' id="hdnColourName_" name="ColourId" value="<?php echo $row['ColourId']; ?>" > 
                            </div>
                          </div>
                        </div>

                        </div>
                      <?php } ?>
      </div>
         </div>

  </div>
               </div>

      <div class="space-4"></div>
      <div class="space-4"></div>   
     <div span="12">
	   <div class="widget-content nopadding">
       <table class="table order-list" border='0'>
              <thead>
               <tr>
		<th style="width:2%;">S.#</th>
    <th style="padding:5px; width:10%; text-align: center;">Qty</th>
		<th style="padding:5px; width:15%; text-align: center;">Color</th>
		<th style="padding:5px; width:25%; text-align: center;">Comments</th>
    <th></th>
	       </tr>
               </thead>
 <?php 
          $SNo = 1; 
          $Amount = 0;
        $NetAmount = 0;
          foreach($StockTransferDetail as $Record) {
            $i = 0;
         ?>
         <tr>
      <td style="margin-top:15px;line-height:25px"><?php echo $SNo; ?></td>
     <td style="text-align:center;"><input style='width:100%;margin-top:1px; text-align:right;' type='number' id="Quantity<?php print $SNo; ?>" class="Quantity" name='Quantity[]' autocomplete="off" value="<?php echo $Record['Quantity'];?>" ></td>
     <td style="text-align:center;">
      <input style='width:95%; margin-top:1px;' type='text' name="ColourName[]" id="ColourName_<?php echo $i?>" autocomplete="off" required="required" value="<?php echo $Record['ColourName'];?>">
      <input type='hidden' id="hdnColourName_<?php echo $i?>" name="ColourId[]" value="<?php echo $Record['ColourId']; ?>"> 
     </td>
     <td><input style='width:100%; text-align:left; margin-top:1px;' type='text' id="Comments<?php print $i; ?>"  name='Comments[]' required="required" value="<?php echo $Record['Comment']; ?>"></td>
     <td style="width:2%;"></td>
     <td style="cursor:pointer; color:red;"><i class="fa fa-trash remove" title="Delete" style="margin-top:1px;"></i></td>
         </tr>
         <?php
         $i++;
         $SNo++; 
          } ?>
          <input type="hidden" name="SNo" id="SNo" class="form-control" value="<?php echo $i; ?>">
             </table>
	    <table class="table" border="0">
            <tbody>
	      <tr>
	       <td colspan="13">
		 <span style="cursor:pointer; color:darkgreen; font-weight:600;" id="addrow" class="fa fa-plus">Add Row</span>
	       </td>
	      </tr>
	    </tbody>
	    </table>

    <table class="table">
      <tr><td>
            <span class="pull-left">
	    <button type='submit' id="Update" class='btn btn-primary bg-primary' value='UpdateStockRecord' name='UpdateStockRecordBtn'>Update Record</button>
	</span>
    </td></tr>
	</table>

          </div>
	</div>
	</form>
	</div>
	
      </div>


<?php
$this->load->view('admin/includes/footer');
?>

<script src="<?php echo base_url();?>js/admin/jquery-ui.js"></script>
<link rel="stylesheet" href="<?php echo base_url();?>css/admin/jquery-ui.css" />

<script>
  $(document).ready(function () {

    var counter = $("#SNo").val();
    
    // Add New Row Script 
    $('body').on("click", "#addrow", function(e) {
  
        var newRow = $("<tr class='txtMult'>");
        var cols = "";
	cols += '<td style="margin-top:15px;line-height:25px">' + counter + '</td>';
  cols += '<td><input style="width:100%; margin-top:1px; text-align:right;" type="number" id="Quantity'+ counter +'" class="Quantity" name="Quantity[]" autocomplete="off"></td>';
	cols += '<td style="text-align:center;"><input style="width:95%; margin-top:1px;" class="select2" type="text" id="ColourName_'+ counter +'" name="ColourName[]"><input style="width:90%;" type="hidden" id="hdnColourName_'+ counter +'" name="ColourId[]"></td>';
	cols += '<td><input style="width:100%; text-align:left; margin-top:1px;" type="text" id="Comments_'+ counter +'" name="Comments[]"></td>'
	cols += '<td style="width:70px;text-align:right; cursor:pointer; color:red;"><i class="fa fa-trash remove" title="Delete" style="margin-top:1px;"></i></td>';

        newRow.append(cols);
        $("table.order-list").append(newRow);
        counter++;
    });
    
    // Start Remove row script
    $("table.order-list").on("click", ".remove", function (event) {
        $(this).closest("tr").remove();       
        counter -= 1
    });
    // End of Add new row script
   
     // Calculating total Quantity and Amount Script
             
     $('body').on("keyup",".txtMult input", multInputs);
    
       function multInputs() {
     
        var TotalAmount = 0;
    var NetAmount = 0;
    $('tr.txtMult').each(function () {

      var Quantity = $('.Quantity', this).val();
      var Rate = $('.Rate', this).val();
      var DiscountAmount = $('.DiscountAmount', this).val();

      var QuantityVal = (isNaN(parseInt(Quantity))) ? 0 : parseInt(Quantity);
      var RateVal = (isNaN(parseInt(Rate))) ? 0 : parseInt(Rate);
      var DiscountAmountVal = (isNaN(parseInt(DiscountAmount))) ? 0 : parseInt(DiscountAmount);

      var Amount = (QuantityVal * 1) * (RateVal * 1);
      
      if(DiscountAmountVal != 0) 
      {
     NetAmount = (Amount - DiscountAmountVal);
      }
      else
      {
     NetAmount = Amount;
      }
      
      $('.Amount',this).val(Amount);
      $('.NetAmount',this).val(NetAmount);
       //TotalQuantity = (TotalQuantity * 1) + (QuantityVal * 1);
       TotalAmount += NetAmount;
  });
       $('#TotalAmount').text((TotalAmount).toFixed(2));
       }
  });  

 $(function(){
    // Auto Select Produt List

    $('body').on('change', 'input[id^=ColourName]', function(){
        var ColourId = $('input[name^=ColourId]').val();
        var ProductId = $('input[name^=ProductId]').val();
        var LocationId = $("#StockTransferFrom").val();

        $.ajax({
           type: 'POST',
           dataType: 'html',
           data: ('ColourId='+ColourId+'&ProductId='+ProductId+'&LocationId='+LocationId),
//           data{ColourId:ColourId,ProductId:ProductId},
           url: "<?php echo base_url('StockTransfer/GetRemainingProduct'); ?>",
           success: function(response){
            $('#RemainingStock').val(response);
           }
        });
    });


    $('body').on("keyup", "input[id^=ProductName]", function(){
      
            var  ProductId  = ($(this).attr('id'));
            var  ProductName = $(this).val();
      
            $(this).autocomplete({
    
                source: function(request, response)   {
                    $.ajax({
                        url: "<?php echo site_url('StockTransfer/AutoCompleteProductList')?>",
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
                        url: "<?php echo site_url('StockTransfer/AutoCompleteLocationList')?>",
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
                        url: "<?php echo site_url('StockTransfer/AutoCompleteColourList')?>",
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
            $("input[id^=CustomerId]").each(function(){
            var CustomerId = $(this).val();
              if(CustomerId === '' || CustomerId == 0)
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