<?php $this->load->view('includes/header'); ?>
<?php $this->load->view('includes/sidebar'); ?>

<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1><i class="fa fa-exchange"></i>&nbsp;Opening Stock</h1>
    </section>
  <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-md-12">
          <!-- Horizontal Form -->
          <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title">Add Opening Stock</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
          <form class="form-horizontal" method="post" action="<?php echo base_url("OpeningStock/SaveOpeningStock"); ?>" name="basic_validate" id="basic_validate" novalidate="novalidate">
          
                  <div class="box-body">
                    <div class="form-group">
                      <div class="col-xs-12 col-md-12">
                        <?php echo $this->session->flashdata('record_added'); ?>
                      </div>
                    </div>

		                    <div class="col-md-6">
                          <div class="form-group">
                            <div style="font-weight:600;" class="col-sm-4"> Select Product </div>
                              <div class="col-sm-8 col-sm-8"> <input style='width:200px;' type='text' name="ProductName" id="ProductName_" autocomplete="off" class="form-control" required="required">
                                <input style='width:90%;' type='hidden' id="hdnProductName_" name="ProductId">
                            </div>
                          </div>

                          <div class="form-group">
                            <div style="font-weight:600;" class="col-sm-4">Select Color:</div>
                            <div class="col-sm-8">
                               <select name="ColourId" id="ColourId" style="width: 200px;" required="required" class="form-control select2">
                              <?php // echo $Locations; ?>
                              <option value="">Select Colour</option>
                              <?php
                              foreach ($AllColours as $ColourRecord) {
                                ?>
                                <option value="<?php echo $ColourRecord['ColourId']; ?>"><?php echo $ColourRecord['ColourName'] ?></option>
                              <?php
                                }
                              ?>  
                                </select>
                            </div>
                          </div>

                        <div class="form-group">
                            <div style="font-weight:600;" class="col-sm-4">Location:</div>
                            <div class="col-sm-8 col-sm-8">
                            <select name="LocationId" id="LocationId" style="width:200px;" required="required" class="form-control select2">
                              <?php // echo $Locations; ?>
                              <option value="">Select Location</option>
                              <?php
                              foreach ($AllLocations as $Locations) {
                                ?>
                                <option value="<?php echo $Locations['LocationId']; ?>"><?php echo $Locations['LocationName'] ?></option>
                              <?php
                                }
                              ?>  
                                </select>
                              
                            </div>
                          </div><!-- /.form-group -->

                          <div class="form-group">
                            <div style="font-weight:600;" class="col-sm-4">Rate:</div>
                            <div class="col-sm-8 col-sm-8"><input style='width: 200px;margin-top:1px; text-align:right;' type='number' id="Rate" class="Rate" name='Rate' autocomplete="off" class="form-control" required="required">
                          </div>
                        </div>

                        </div>
                        
                        <div class="col-md-6">
                          <div class="form-group">
                            <div style="font-weight:600;" class="col-sm-4">Opening Stock No:</div>
                            <div class="col-sm-8 col-sm-8">(Auto Generate)</div>
                          </div><!-- /.form-group -->

                          <div class="form-group">
                            <div style="font-weight:600;" class="col-sm-4">Opening Date:</div>
                            <div class="col-sm-8 col-sm-8"><input type="text" style="width: 200px;" name="OpeningStockDate" id="datepicker1" class="form-control" value="<?php echo date("m/d/Y"); ?>" required="required"></div>
                          </div><!-- /.form-group -->
                          
                        <div class="form-group">
                            <div style="font-weight:600;" class="col-sm-4">Opening Quantity:</div>
                            <div class="col-sm-8 col-sm-8"><input style='width: 200px;margin-top:1px; text-align:right;' type='number' id="Quantity" class="Quantity form-control" name='Quantity' autocomplete="off" required="required">
                          </div>
                        </div>

                         <div class="form-group">
                            <div style="font-weight:600;" class="col-sm-4">Amount:</div>
                            <div class="col-sm-8 col-sm-8"><input style='width: 200px;margin-top:1px; text-align:right;' type='number' id="Amount" class="Amount form-control" name='Amount' autocomplete="off" readonly="readonly">
                          </div>
                        </div>

                        </div>

                        </div>
              <div class="box-body">
               <div class="row">
                  <div class='col-md-2'>
                <button type="submit" class="btn btn-block btn-primary">Save Record</button>
              </div>
             <div class="col-md-2">
               <a href="<?php echo base_url(); ?>OpeningStock/"><button type="button" name="" value="" class="btn btn-block btn-primary">Back to Main</button></a>
              </div>
             </div>
            </div>
              <!-- /.box-footer -->
            </form>
          </div>
       </div>
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
<?php
$this->load->view('includes/footer');
?>

<script src="<?php echo base_url();?>plugins/autocomplete/jquery-ui.js"></script>
<link rel="stylesheet" href="<?php echo base_url();?>plugins/autocomplete/jquery-ui.css" />

<script>
 $(function(){

     $('body').on("keyup","input", multInputs);
    
       function multInputs() {

      // var TotalAmount = 0;
      // var NetAmount = 0;
//      $('input').each(function () {

      var Quantity = $('.Quantity').val();
      var Rate = $('.Rate').val();
      var Amount = $('.Amount').val();

      var QuantityVal = (isNaN(parseInt(Quantity))) ? 0 : parseInt(Quantity);
      var RateVal = (isNaN(parseInt(Rate))) ? 0 : parseInt(Rate);
      var AmountVal = (isNaN(parseInt(Amount))) ? 0 : parseInt(Amount);

      var TotalAmount = (QuantityVal * 1) * (RateVal * 1);
          
      $('.Amount').val(TotalAmount);
       }


    $('body').on("keyup", "input[id^=ProductName]", function(){
      
            var  ProductId  = ($(this).attr('id'));
            var  ProductName = $(this).val();
      
            $(this).autocomplete({
    
                source: function(request, response)   {
                    $.ajax({
                        url: "<?php echo site_url('OpeningStock/AutoCompleteProductList')?>",
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


      $("#ShowAvailableQuantity").click(function(){
        var ProductId = $('input[name^=ProductId]').val();
        var ColourId = $("#ColourId").val();
        var LocationId = $("#LocationFromId").val();

        $.ajax({
           type: 'POST',
           dataType: 'html',
           data: ('ColourId='+ColourId+'&ProductId='+ProductId+'&LocationId='+LocationId),
           url: "<?php echo base_url('OpeningStock/GetRemainingProduct'); ?>",
           success: function(response){
            $('#RemainingStock').val(response);
           }
        });

      })

      $("#basic_validate").submit(function(){
        var RemainingStock = $("#RemainingStock").val();
        var Quantity = ("#Quantity").val();
        if(Quantity > RemainingStock){
          alert("Transfer Quantity is greater than available stock");
          return false;
        }
        else{
        alert(RemainingStock);
        alert("remaining");
        return false;
        }
      })

    });

</script>