<?php
$this->load->view("includes/header");
$this->load->view("includes/sidebar");
?>
<script>
 function removeCommas(inputText) {
    // pattern works from right to left
    str = inputText.replace(",","");
    return str;
}
</script>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper" style="background-color: #f9f9f9;">
    <!-- Content Header (Page header) -->
    <section class="content-header" style="padding: 20px 20px 10px;">
        <div class="container-fluid">
            <div class="row">
<div class="col-sm-6">
  <h1 class="page-title">
    <i class="fa fa-archive"></i>&nbsp;Products
  </h1>
</div>

<style>
.page-title {
  color: #2e2e2e;
  font-weight: 600;
  font-family: 'Segoe UI', Roboto, sans-serif;
  display: flex;
  align-items: center;
  gap: 6px;
  font-size: 24px;
}

/* Professional green color and effect */
.page-title i {
  color: #098b52; /* elegant green */
  font-size: 26px;
  transition: transform 0.3s ease, color 0.3s ease;
}

/* Hover animation */
.page-title:hover i {
  color: #06a77d; /* lighter green on hover */
  transform: scale(1.15);
}
</style>

<div class="col-sm-6">
  <ol class="breadcrumb float-sm-right custom-breadcrumb">
    <li class="breadcrumb-item">
      <a href="<?php echo base_url(); ?>Dashboard">
        <i class="fa fa-home"></i> Home
      </a>
    </li>
    <li class="breadcrumb-item">
      <a href="<?php echo base_url(); ?>Product/">
        <i class="fa fa-cube"></i> Products
      </a>
    </li>
    <li class="breadcrumb-item active">
      <i class="fa fa-edit"></i> Edit Product
    </li>
  </ol>
</div>

<style>
/* Dark green professional breadcrumb */
.custom-breadcrumb {
  background: linear-gradient(135deg, #064d35, #0a6b4a);
  padding: 8px 18px;
  border-radius: 8px;
  box-shadow: 0 2px 6px rgba(0, 0, 0, 0.25);
  display: inline-flex;
  align-items: center;
  gap: 8px;
  font-family: 'Calibri', sans-serif;
  font-size: 15px;
}

/* Make all text white */
.custom-breadcrumb .breadcrumb-item a,
.custom-breadcrumb .breadcrumb-item.active {
  color: #ffffff !important;
  font-weight: 500;
  text-decoration: none;
}

/* Font Awesome icons styling */
.custom-breadcrumb i {
  color: #ffffff;
  margin-right: 5px;
  font-size: 14px;
}

/* Hover effect for links */
.custom-breadcrumb .breadcrumb-item a:hover {
  text-decoration: underline;
}

/* Divider styling */
.custom-breadcrumb .breadcrumb-item + .breadcrumb-item::before {
  content: "\f105"; /* Font Awesome right arrow (fa-angle-right) */
  font-family: "Font Awesome 5 Free";
  font-weight: 900;
  color: #ffffff;
  padding: 0 8px;
}
</style>

            </div>
        </div>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card" style="border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.08); border: none;">
                        <div class="card-header" style="background-color: white; border-bottom: 1px solid #eaeaea; border-radius: 8px 8px 0 0;">
                            <h3 class="card-title" style="color: #2e2e2e; font-weight: 600; font-family: 'Segoe UI', Roboto, sans-serif;"><i class="fas fa-edit mr-2" style="color: #0077c5;"></i> Edit Product</h3>
                        </div>
                        
                        <?php $id = $GetProduct->ProductId; ?>
                        <form role="form" id="ProductForm" class="form-horizontal" enctype="multipart/form-data" action='<?php echo base_url("Product/UpdateProduct/$id"); ?>' method="post">
                            <div class="card-body" style="padding: 30px;">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group row mb-4">
                                            <label for="CategoryId" class="col-sm-3 col-form-label" style="font-weight: 600; color: #444; font-family: 'Segoe UI', Roboto, sans-serif;">Product Category <span style="color: #dc3545;">*</span></label>
                                            <div class="col-sm-9">
                                                <select name="CategoryId" class="form-control select2" required style="border-radius: 4px; border: 1px solid #ddd; padding: 8px;">
                                                    <option value="">Select Category</option>
                                                    <?php foreach ($GetAllCategories as $row) { ?>
                                                    <option value="<?php echo $row['CategoryId']; ?>"<?php if($GetProduct->CategoryId == $row['CategoryId']) { echo "selected=selected"; } ?>><?php echo $row['CategoryName']; ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group row mb-4">
                                            <label for="ProductGroupId" class="col-sm-3 col-form-label" style="font-weight: 600; color: #444; font-family: 'Segoe UI', Roboto, sans-serif;">UOM <span style="color: #dc3545;">*</span></label>
                                            <div class="col-sm-9">
                                                <select name="ProductGroupId" class="form-control select2" required style="border-radius: 4px; border: 1px solid #ddd; padding: 8px;">
                                                    <option value="">Select UOM</option>
                                                    <?php foreach ($GetAllProductGroup as $row) { ?>
                                                    <option value="<?php echo $row['ProductGroupId']; ?>"<?php if($GetProduct->ProductGroupId == $row['ProductGroupId']) { echo "selected=selected"; } ?>><?php echo $row['ProductGroupName']; ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group row mb-4">
                                            <label for="BrandId" class="col-sm-3 col-form-label" style="font-weight: 600; color: #444; font-family: 'Segoe UI', Roboto, sans-serif;">Brand <span style="color: #dc3545;">*</span></label>
                                            <div class="col-sm-9">
                                                <select name="BrandId" class="form-control select2" required style="border-radius: 4px; border: 1px solid #ddd; padding: 8px;">
                                                    <option value="">Select Brand</option>
                                                    <?php foreach ($GetAllBrands as $row) { ?>
                                                    <option value="<?php echo $row['BrandId']; ?>"<?php if($GetProduct->BrandId == $row['BrandId']) { echo "selected=selected"; } ?>><?php echo $row['BrandName']; ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group row mb-4">
                                            <label for="ProductName" class="col-sm-3 col-form-label" style="font-weight: 600; color: #444; font-family: 'Segoe UI', Roboto, sans-serif;">Product Description</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control form-control-lg" name="ProductName" value="<?php echo $GetProduct->ProductName; ?>" required autocomplete="off" style="border-radius: 4px; border: 1px solid #ddd; padding: 10px;">
                                            </div>
                                        </div>

                                        <div class="form-group row mb-4">
                                            <label for="SerialNumber" class="col-sm-3 col-form-label" style="font-weight: 600; color: #444; font-family: 'Segoe UI', Roboto, sans-serif;">Serial Number</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control form-control-lg" name="SerialNumber" value="<?php echo $GetProduct->SerialNumber; ?>" autocomplete="off" style="border-radius: 4px; border: 1px solid #ddd; padding: 10px;">
                                            </div>
                                        </div>

                                        <div class="form-group row mb-4">
                                            <label for="ProductBarCode" class="col-sm-3 col-form-label" style="font-weight: 600; color: #444; font-family: 'Segoe UI', Roboto, sans-serif;">Product Code</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control form-control-lg" name="ProductBarCode" id="ProductBarCode" value="<?php echo $GetProduct->ProductBarCode; ?>" autocomplete="off" style="border-radius: 4px; border: 1px solid #ddd; padding: 10px;">
                                            </div>
                                        </div>

                                        <div class="form-group row mb-4">
                                            <label for="MinimumStock" class="col-sm-3 col-form-label" style="font-weight: 600; color: #444; font-family: 'Segoe UI', Roboto, sans-serif;">Minimum Stock</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control form-control-lg" name="MinimumStock" id="MinimumStock" value="<?php echo $GetProduct->MinimumStock; ?>" placeholder="" autocomplete="off" style="border-radius: 4px; border: 1px solid #ddd; padding: 10px;">
                                            </div>
                                        </div>

                                        <div class="form-group row mb-4">
                                            <label for="PurchasePrice" class="col-sm-3 col-form-label" style="font-weight: 600; color: #444; font-family: 'Segoe UI', Roboto, sans-serif;">Scenario Name</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control form-control-lg" name="PurchasePrice" id="PurchasePrice" value="<?php echo $GetProduct->PurchasePrice; ?>" placeholder="" autocomplete="off" style="border-radius: 4px; border: 1px solid #ddd; padding: 10px;">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group row mb-4">
                                            <label for="SellPrice" class="col-sm-3 col-form-label" style="font-weight: 600; color: #444; font-family: 'Segoe UI', Roboto, sans-serif;">Sale Price</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control form-control-lg" name="SellPrice" id="SellPrice" value="<?php echo $GetProduct->SellPrice; ?>" placeholder="" autocomplete="off" style="border-radius: 4px; border: 1px solid #ddd; padding: 10px;">
                                            </div>
                                        </div>
                                        
                                        <div class="form-group row mb-4">
                                            <label for="FinalPrice" class="col-sm-3 col-form-label" style="font-weight: 600; color: #444; font-family: 'Segoe UI', Roboto, sans-serif;">Final Price</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control form-control-lg" name="FinalPrice" id="FinalPrice" value="<?php echo $GetProduct->FinalPrice; ?>" placeholder="" autocomplete="off" style="border-radius: 4px; border: 1px solid #ddd; padding: 10px;">
                                            </div>
                                        </div>

                                        <div class="form-group row mb-4">
                                            <label for="OpeningStock" class="col-sm-3 col-form-label" style="font-weight: 600; color: #444; font-family: 'Segoe UI', Roboto, sans-serif;">HS Code <span style="color: #dc3545;">*</span></label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control form-control-lg" name="OpeningStock" id="OpeningStock" value="<?php echo $GetProduct->OpeningStock; ?>" placeholder="" required autocomplete="off" style="border-radius: 4px; border: 1px solid #ddd; padding: 10px;">
                                            </div>
                                        </div>

<!-- Product Date field hidden intentionally -->
<?php /* 
<div class="form-group row mb-4">
  <label for="OpeningStockDate" 
         class="col-sm-3 col-form-label" 
         style="font-weight: 600; color: #444; font-family: 'Segoe UI', Roboto, sans-serif;">
    Product Date
  </label>
  <div class="col-sm-9">
    <input type="text" 
           class="form-control form-control-lg" 
           name="OpeningStockDate" 
           id="OpeningStockDate" 
           value="<?php echo !empty($GetProduct->OpeningStockDate) ? htmlspecialchars($GetProduct->OpeningStockDate) : ''; ?>" 
           placeholder="Enter Opening Stock Date" 
           autocomplete="off" 
           style="border-radius: 4px; border: 1px solid #ddd; padding: 10px;">
  </div>
</div>
*/ ?>




                                        <div class="form-group row mb-4">
                                            <label for="Policy" class="col-sm-3 col-form-label" style="font-weight: 600; color: #444; font-family: 'Segoe UI', Roboto, sans-serif;">Item Sr. No</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control form-control-lg" name="Policy" id="Policy" value="<?php echo $GetProduct->Policy; ?>" placeholder="" autocomplete="off" style="border-radius: 4px; border: 1px solid #ddd; padding: 10px;">
                                            </div>
                                        </div>

                                        <div class="form-group row mb-4">
                                            <label for="CurrentImage" class="col-sm-3 col-form-label" style="font-weight: 600; color: #444; font-family: 'Segoe UI', Roboto, sans-serif;">Current Image</label>
                                            <div class="col-sm-9">
                                                <?php if($GetProduct->ProductImage && file_exists('./uploads/products/'.$GetProduct->ProductImage)) { ?>
                                                    <img src="<?php echo base_url(); ?>uploads/products/<?php echo $GetProduct->ProductImage; ?>" class="img-thumbnail" style="max-width: 200px; max-height: 200px; border-radius: 4px; border: 1px solid #ddd;">
                                                <?php } else { ?>
                                                    <div class="text-muted" style="border-radius: 4px; border: 1px solid #ddd; padding: 10px; background-color: #f8f9fa;">No image available</div>
                                                <?php } ?>
                                            </div>
                                        </div>

                                        <!-- SRO / Schedule No -->
<div class="form-group row mb-4">
  <label for="ProductDetails" 
         class="col-sm-3 col-form-label" 
         style="font-weight: 600; color: #444; font-family: 'Segoe UI', Roboto, sans-serif;">
    SRO / Schedule No
  </label>
  <div class="col-sm-9">
    <input type="text" 
           class="form-control form-control-lg" 
           name="ProductDetails" 
           id="ProductDetails" 
           value="<?php echo !empty($GetProduct->ProductDetails) ? htmlspecialchars($GetProduct->ProductDetails) : ''; ?>" 
           placeholder="Enter SRO or Schedule No" 
           autocomplete="off" 
           style="border-radius: 4px; border: 1px solid #ddd; padding: 10px;">
  </div>
</div>

<!-- Upload New Image -->
<div class="form-group row mb-4">
  <label for="ProductImage" 
         class="col-sm-3 col-form-label" 
         style="font-weight: 600; color: #444; font-family: 'Segoe UI', Roboto, sans-serif;">
    Upload New Image
  </label>
  <div class="col-sm-9">
    <input type="file" 
           name="ProductImage" 
           id="ProductImage" 
           class="form-control form-control-lg" 
           style="border-radius: 4px; border: 1px solid #ddd; padding: 8px;">
  </div>
</div>

                                </div>
                            </div>
                            
                            <div class="card-footer" style="background-color: white; border-top: 1px solid #eaeaea; border-radius: 0 0 8px 8px; padding: 20px 30px;">
                                <div class="row">
                                    <div class="col-sm-12 text-right">
                                        <button type="submit" class="btn btn-primary" style="background-color: #007bff; border-color: #007bff; padding: 8px 20px; font-weight: 500;">
                                            <i class="fas fa-save mr-1"></i> Update Product
                                        </button>
                                        <a href="<?php echo base_url(); ?>Product/" class="btn btn-danger" style="background-color: #dc3545; border-color: #dc3545; padding: 8px 20px; margin-left: 10px;">
                                            <i class="fas fa-times mr-1"></i> Cancel
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<script>  
$(document).ready(function() {
    // Initialize select2
    $('.select2').select2({
        theme: 'bootstrap4',
        width: '100%'
    });

    // Form validation
    $("#ProductForm").submit(function(event) {
        var OpenningQuantityUnit = $("#OpenningQuantityUnit").val();
        var CurrentOpenningQuantityUnit = $("#CurrentOpenningQuantityUnit").val();
        
        // Check if required fields are selected
        var categoryId = $("select[name='CategoryId']").val();
        var productGroupId = $("select[name='ProductGroupId']").val();
        var brandId = $("select[name='BrandId']").val();
        var hscode = $("#OpeningStock").val();
        
        if (!categoryId) {
            alert('Please select Product Category');
            event.preventDefault();
            $("select[name='CategoryId']").focus();
            return false;
        }
        
        if (!productGroupId) {
            alert('Please select UOM');
            event.preventDefault();
            $("select[name='ProductGroupId']").focus();
            return false;
        }
        
        if (!brandId) {
            alert('Please select Brand');
            event.preventDefault();
            $("select[name='BrandId']").focus();
            return false;
        }
        
        if (!hscode) {
            alert('Please enter HS Code');
            event.preventDefault();
            $("#OpeningStock").focus();
            return false;
        }
        
        if(parseInt(OpenningQuantityUnit) < parseInt(CurrentOpenningQuantityUnit)) {
            alert('You cannot enter less quantity than previous quantity');
            event.preventDefault();
            $(this).focus();
            return false;
        }
    });
});
</script>

<?php $this->load->view("includes/footer"); ?>