<?php $this->load->view('includes/header'); ?>
<?php $this->load->view('includes/sidebar'); ?>

<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1><i class="fa fa-exchange"></i>&nbsp;Stock Transfer</h1>
    </section>
  <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-md-12">
          <!-- Horizontal Form -->
          <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title">Add Stock Transfer</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->

              <form class="form-horizontal" method="post" action="<?php echo base_url("StockTransfer/SaveStockTransfer"); ?>" name="basic_validate" id="basic_validate" novalidate="novalidate">

                <div class="box-body">
                        <div class="form-group">
              				<div class="col-xs-12 col-md-12">
			                    <?php echo $this->session->flashdata('record_added'); ?>
                            </div>
                        </div>

		                    <div class="col-md-6">
                          <div class="form-group">
                            <div style="font-weight:600;" class="col-sm-4"> Select Product </div>
                              <div class="col-sm-8 col-sm-8"> <input style='width:200px;' type='text' name="ProductName" id="ProductName_" autocomplete="off" class="form-control">
                                <input style='width:90%;' type='hidden' id="hdnProductName_" name="ProductId">
                            </div>
                          </div>

                          <div class="form-group">
                            <div style="font-weight:600;" class="col-sm-4">Select Color</div>
                            <div class="col-sm-8">
                               <select name="ColourId" id="ColourId" style="width: 200px;" required="required" class="form-control">
                              <?php // echo $Locations; ?>
                              <option value="0">Select Colour</option>
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
                            <div style="font-weight:600;" class="col-sm-4">Location From:</div>
                            <div class="col-sm-8 col-sm-8">
                            <select name="StockTransferFrom" id="StockTransferFrom" style="width:200px;" required="required" class="form-control">
                              <?php // echo $Locations; ?>
                              <option value="0">Select Location</option>
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
                            <div style="font-weight:600;" class="col-sm-4"><button type="button" class="btn btn-sm btn btn-danger" id="ShowAvailableQuantity">Show Quantity</button></div>
                            <div class="col-sm-8 col-sm-8"><input type="text" name="RemainingStock" id="RemainingStock" style="width: 200px;" readonly="readonly" class="form-control"></div>
                          </div><!-- /.form-group -->

                          <div class="form-group">
                            <div style="font-weight:600;" class="col-sm-4">Select Employee:</div>
                            <div class="col-sm-8 col-sm-8">
                            <select name="EmployeeId" id="EmployeeId" style="width:200px;" required="required"class="form-control">
                              <?php // echo $Locations; ?>
                              <option value="0">Select Employee</option>
                              <?php
                              foreach ($AllEmployees as $Employees) {
                                ?>
                                <option value="<?php echo $Employees['EmployeeId']; ?>"><?php echo $Employees['EmployeeName'] ?></option>
                              <?php
                                }
                              ?>  
                                </select>
                              
                            </div>
                          </div><!-- /.form-group -->

                        </div> <!-------   end of cl-6  ------>
                        
                        <div class="col-md-6">
                          <div class="form-group">
                            <div style="font-weight:600;" class="col-sm-4">Stock Transfer No:</div>
                            <div class="col-sm-8 col-sm-8">(Auto Generate)</div>
                          </div><!-- /.form-group -->

                          <div class="form-group">
                            <div style="font-weight:600;" class="col-sm-4">Transfer Date:</div>
                            <div class="col-sm-8 col-sm-8"><input type="text" style="width: 200px;" id="datepicker1" name="StockTransferDate" value="<?php echo date("m/d/Y"); ?>" class="form-control"></div>
                          </div><!-- /.form-group -->

                          <div class="form-group">
                            <div style="font-weight:600;" class="col-sm-4">Location To:</div>
                            <div class="col-sm-8 col-sm-8">
                              <select name="StockTransferTo" id="StockTransferTo" style="width: 200px;" required="required" class="form-control">
                              <?php // echo $Locations; ?>
                              <option value="0">Select Location</option>
                              <?php
                              foreach ($AllLocations as $LocationRecord) {
                                ?>
                                <option value="<?php echo $LocationRecord['LocationId']; ?>"><?php echo $LocationRecord['LocationName'] ?></option>
                              <?php
                                }
                              ?>  
                                </select>
                            </div><!-- /.form-group -->
                          </div>
                          
                        <div class="form-group">
                            <div style="font-weight:600;" class="col-sm-4">Transfer Quantity:</div>
                            <div class="col-sm-8 col-sm-8"><input style='width: 200px;margin-top:1px; text-align:right;' type='number' id="Quantity" class="Quantity form-control" name='Quantity' autocomplete="off">
                          </div>
                        </div>

                        <div class="form-group">
                            <div style="font-weight:600;" class="col-sm-4">Comments:</div>
                            <div class="col-sm-8 col-sm-8"><input style='width: 200px;margin-top:1px; text-align:right;' type='text' id="Comments" class="Comments form-control" name='Comments' autocomplete="off">
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
               <a href="<?php echo base_url(); ?>StockTransfer/"><button type="button" name="" value="" class="btn btn-block btn-primary">Back to Main</button></a>
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


      $("#ShowAvailableQuantity").click(function(){
        var ProductId = $('input[name^=ProductId]').val();
        var ColourId = $("#ColourId").val();
        var LocationId = $("#StockTransferFrom").val();

        $.ajax({
           type: 'POST',
           dataType: 'html',
           data: ('ColourId='+ColourId+'&ProductId='+ProductId+'&LocationId='+LocationId),
           url: "<?php echo base_url('StockTransfer/GetRemainingProduct'); ?>",
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