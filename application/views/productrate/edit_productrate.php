<?php
$this->load->view("includes/header");
$this->load->view("includes/sidebar");
?>
<script>
 function removeCommas(inputText) {
    // pattern works from right to left
    str =inputText.replace(",","");
    return str;
}
</script>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1><i class="fa fa-medkit"></i>&nbsp;Product Rates</h1>
    </section>
  <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-md-12">
          <!-- Horizontal Form -->
          <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title">Edit Product Rate</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <?php $id = $GetProductRate->ProductRateId; ?>
            <form role="form" id="ProductForm" class="form-horizontal" enctype="multipart/form-data" action='<?php echo base_url("ProductRates/SaveProductRate/$id"); ?>' method="post"> 
              <div class="box-body">
                  <div class="form-group">
                  <label for="BrandName" class="col-sm-1 control-label">Product Category:</label>
                  <div class="col-sm-4">
                    <?php echo $GetProductRate->CategoryName; ?>
                    <input type="hidden" name="CategoryId" id="inputCategoryId" class="form-control" value="<?php echo $GetProductRate->CategoryId; ?>">
                     <!-- 
                     <select name="CategoryId" id="" class="form-control select2" required>
                     <option selected="selected">Select Category</option>
                     <?php // foreach ($Categories as $row) { ?>
                      <option value="<?php // echo $row['CategoryId']; ?>"<?php // if($GetProductRate->CategoryId == $row['CategoryId']) { echo "selected=selected"; } ?>><?php // echo $row['CategoryName']; ?></option>
                     <?php // } ?>
                                       </select> -->
                  </div>
                </div>
              <div id="CategoryProductDiv">
		            <div class="form-group">
                  <label for="BrandName" class="col-sm-1 control-label">Product:</label>
                  <div class="col-sm-4">
                    <select name="ProductId" class="form-control select2" required>
                     <option>Select Product</option>
                     <?php foreach ($Products as $row) { ?>
		     <option value="<?php  echo $row['ProductId']; ?>"<?php if($GetProductRate->ProductId == $row['ProductId']) { echo "selected=selected"; } ?>><?php echo $row['ProductName']; ?></option>
                     <?php } ?>
                  </select>
                  </div>
                </div>
              </div>
                <?php 
                if($GetProductRate->CustomerId != 0){
                ?>
                <div class="form-group" id="CustomerDiv">
                  <label for="BrandName" class="col-sm-1 control-label">Customer:</label>
                  <div class="col-sm-4">
                     <select name="CustomerId" class="form-control select2" required>
                     <option selected="selected">Select Customer</option>
                     <?php foreach ($Customers as $row) { ?>
                    <option value="<?php echo $row['CustomerId']; ?>"<?php if($GetProductRate->CustomerId == $row['CustomerId']) { echo "selected=selected"; } ?>><?php echo $row['CustomerName']; ?></option>
                     <?php } ?>
                  </select>
                  </div>
                </div>
                <?php }
                if($GetProductRate->VendorId != 0){
                ?>
                  <div class="form-group" id="VendorDiv">
                  <label for="BrandName" class="col-sm-1 control-label">Vendor:</label>
                  <div class="col-sm-4">
                     <select name="VendorId" class="form-control select2" required>
                     <option selected="selected">Select Vendor</option>
                     <?php foreach ($Vendors as $row) { ?>
                    <option value="<?php echo $row['VendorId']; ?>"<?php if($GetProductRate->VendorId == $row['VendorId']) { echo "selected=selected"; } ?>><?php echo $row['VendorName']; ?></option>
                     <?php } ?>
                  </select>
                  </div>
                </div>
                <?php } ?>
                <div class="form-group">
                  <label for="Rate" class="col-sm-1 control-label">Rate:</label>
                  <div class="col-sm-4">
                    <input type="text" class="form-control" name="Rate" id="Rate" value="<?php echo $GetProductRate->Rate;?>" required>
                  </div>
                </div> 

                <div class="form-group">
                <label for="Note" class="col-sm-1 control-label">Note:</label>
                <div class="col-sm-4">
                <textarea name="Note" class="form-control" rows="4" cols="50"><?php echo $GetProductRate->Note;?></textarea>
                </div>
              </div>
                
              </div>
              <!-- /.box-body -->
              <div class="box-body">
               <div class="row">
                <div class='col-md-2'>
                <button type="submit" class="btn btn-block btn-primary">Update Record</button>
                </div>
               <div class="col-md-2">
                 <a href="<?php echo base_url(); ?>ProductRates">
                  <button type="button" name="BankToMain" value="BankToMain" class="btn btn-block bg-orange">Back to Main</button></a>
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
<?php $this->load->view("includes/footer"); ?>
<script>
  $(function(){
    $("#CategoryId").on('change', function(){
      if ($(this).val() == 1) {
        $("#VendorDiv").css('display', 'block');
        $("#CustomerDiv").css('display', 'none');
      }
      if ($(this).val() == 2) {
        $("#CustomerDiv").css('display', 'block');
        $("#VendorDiv").css('display', 'none');
      }
    var CategoryId = $("#CategoryId").val();
    $.ajax({
      url: '<?php echo base_url(); ?>ProductRates/GetCategoryProducts',
      data:{CategoryId:CategoryId},
      type:'post',
      success:function(data){
        $("#CategoryProductDiv").html(data)
      }
    });

    })
  })
</script>