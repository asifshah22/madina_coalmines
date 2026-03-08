<?php
$this->load->view("includes/header");
$this->load->view("includes/sidebar");                
?>
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
      <i class="fa fa-eye"></i> View Product
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
                            <h3 class="card-title" style="color: #2e2e2e; font-weight: 600; font-family: 'Segoe UI', Roboto, sans-serif;"><i class="fas fa-eye mr-2" style="color: #0077c5;"></i> Product Information</h3>
                            <div class="card-tools">
                                <a href="<?php echo base_url(); ?>Product/EditProduct/<?php echo $GetProduct->ProductId; ?>" class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                            </div>
                        </div>
                        
                        <div class="card-body" style="padding: 30px;">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group row mb-4">
                                        <label class="col-sm-3 col-form-label" style="font-weight: 600; color: #444; font-family: 'Segoe UI', Roboto, sans-serif;">Product Category</label>
                                        <div class="col-sm-9">
                                            <div class="form-control-plaintext" style="border-radius: 4px; border: 1px solid #eaeaea; padding: 10px; background-color: #f8f9fa;">
                                                <?php echo $GetProduct->CategoryName ?>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group row mb-4">
                                        <label class="col-sm-3 col-form-label" style="font-weight: 600; color: #444; font-family: 'Segoe UI', Roboto, sans-serif;">UOM</label>
                                        <div class="col-sm-9">
                                            <div class="form-control-plaintext" style="border-radius: 4px; border: 1px solid #eaeaea; padding: 10px; background-color: #f8f9fa;">
                                                <?php echo $GetProduct->ProductGroupName ?>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group row mb-4">
                                        <label class="col-sm-3 col-form-label" style="font-weight: 600; color: #444; font-family: 'Segoe UI', Roboto, sans-serif;">Brand</label>
                                        <div class="col-sm-9">
                                            <div class="form-control-plaintext" style="border-radius: 4px; border: 1px solid #eaeaea; padding: 10px; background-color: #f8f9fa;">
                                                <?php echo $GetProduct->BrandName ?>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group row mb-4">
                                        <label class="col-sm-3 col-form-label" style="font-weight: 600; color: #444; font-family: 'Segoe UI', Roboto, sans-serif;">Product Description</label>
                                        <div class="col-sm-9">
                                            <div class="form-control-plaintext" style="border-radius: 4px; border: 1px solid #eaeaea; padding: 10px; background-color: #f8f9fa;">
                                                <?php echo $GetProduct->ProductName ?>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group row mb-4">
                                        <label class="col-sm-3 col-form-label" style="font-weight: 600; color: #444; font-family: 'Segoe UI', Roboto, sans-serif;">Serial Number</label>
                                        <div class="col-sm-9">
                                            <div class="form-control-plaintext" style="border-radius: 4px; border: 1px solid #eaeaea; padding: 10px; background-color: #f8f9fa;">
                                                <?php echo $GetProduct->SerialNumber ?>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group row mb-4">
                                        <label class="col-sm-3 col-form-label" style="font-weight: 600; color: #444; font-family: 'Segoe UI', Roboto, sans-serif;">Product Code</label>
                                        <div class="col-sm-9">
                                            <div class="form-control-plaintext" style="border-radius: 4px; border: 1px solid #eaeaea; padding: 10px; background-color: #f8f9fa;">
                                                <?php echo $GetProduct->ProductBarCode ?>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group row mb-4">
                                        <label class="col-sm-3 col-form-label" style="font-weight: 600; color: #444; font-family: 'Segoe UI', Roboto, sans-serif;">Minimum Stock</label>
                                        <div class="col-sm-9">
                                            <div class="form-control-plaintext" style="border-radius: 4px; border: 1px solid #eaeaea; padding: 10px; background-color: #f8f9fa;">
                                                <?php echo $GetProduct->MinimumStock ?>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group row mb-4">
                                        <label class="col-sm-3 col-form-label" style="font-weight: 600; color: #444; font-family: 'Segoe UI', Roboto, sans-serif;">Scenario Name</label>
                                        <div class="col-sm-9">
                                            <div class="form-control-plaintext" style="border-radius: 4px; border: 1px solid #eaeaea; padding: 10px; background-color: #f8f9fa;">
                                                <?php echo $GetProduct->PurchasePrice ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group row mb-4">
                                        <label class="col-sm-3 col-form-label" style="font-weight: 600; color: #444; font-family: 'Segoe UI', Roboto, sans-serif;">Sale Price</label>
                                        <div class="col-sm-9">
                                            <div class="form-control-plaintext" style="border-radius: 4px; border: 1px solid #eaeaea; padding: 10px; background-color: #f8f9fa;">
                                                <?php echo $GetProduct->SellPrice ?>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="form-group row mb-4">
                                        <label class="col-sm-3 col-form-label" style="font-weight: 600; color: #444; font-family: 'Segoe UI', Roboto, sans-serif;">Final Price</label>
                                        <div class="col-sm-9">
                                            <div class="form-control-plaintext" style="border-radius: 4px; border: 1px solid #eaeaea; padding: 10px; background-color: #f8f9fa;">
                                                <?php echo $GetProduct->FinalPrice ?>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group row mb-4">
                                        <label class="col-sm-3 col-form-label" style="font-weight: 600; color: #444; font-family: 'Segoe UI', Roboto, sans-serif;">HS Code</label>
                                        <div class="col-sm-9">
                                            <div class="form-control-plaintext" style="border-radius: 4px; border: 1px solid #eaeaea; padding: 10px; background-color: #f8f9fa;">
                                                <?php echo $GetProduct->OpeningStock ?>
                                            </div>
                                        </div>
                                    </div>

<!-- Product Date field hidden intentionally -->
<?php /* 
<div class="form-group row mb-4">
  <label class="col-sm-3 col-form-label" 
         style="font-weight: 600; color: #444; font-family: 'Segoe UI', Roboto, sans-serif;">
    Product Date
  </label>
  <div class="col-sm-9">
    <div class="form-control-plaintext" 
         style="border-radius: 4px; border: 1px solid #eaeaea; padding: 10px; background-color: #f8f9fa;">
      <?php echo !empty($GetProduct->OpeningStockDate) ? htmlspecialchars($GetProduct->OpeningStockDate) : ''; ?>
    </div>
  </div>
</div>
*/ ?>



                                    
                                    <div class="form-group row mb-4">
                                        <label class="col-sm-3 col-form-label" style="font-weight: 600; color: #444; font-family: 'Segoe UI', Roboto, sans-serif;">Item Sr. No</label>
                                        <div class="col-sm-9">
                                            <div class="form-control-plaintext" style="border-radius: 4px; border: 1px solid #eaeaea; padding: 10px; background-color: #f8f9fa;">
                                                <?php echo $GetProduct->Policy ?>
                                            </div>
                                        </div>
                                    </div>
                                    
<!-- SRO / Schedule No -->
<div class="form-group row mb-4">
  <label class="col-sm-3 col-form-label" 
         style="font-weight: 600; color: #444; font-family: 'Segoe UI', Roboto, sans-serif;">
    SRO / Schedule No
  </label>
  <div class="col-sm-9">
    <div class="form-control-plaintext" 
         style="border-radius: 4px; border: 1px solid #eaeaea; padding: 10px; background-color: #f8f9fa; min-height: 45px;">
      <?php echo !empty($GetProduct->ProductDetails) ? htmlspecialchars($GetProduct->ProductDetails) : '<span class="text-muted">No SRO / Schedule No available</span>'; ?>
    </div>
  </div>
</div>

<!-- Product Image -->
<div class="form-group row mb-4">
  <label class="col-sm-3 col-form-label" 
         style="font-weight: 600; color: #444; font-family: 'Segoe UI', Roboto, sans-serif;">
    Product Image
  </label>
  <div class="col-sm-9">
    <?php if (!empty($GetProduct->ProductImage) && file_exists('./uploads/products/'.$GetProduct->ProductImage)) { ?>
      <div class="form-control-plaintext" 
           style="border-radius: 4px; border: 1px solid #eaeaea; padding: 10px; background-color: #f8f9fa;">
        <img src="<?php echo base_url('uploads/products/'.$GetProduct->ProductImage); ?>" 
             class="img-thumbnail" 
             style="max-width: 200px; max-height: 200px;">
      </div>
    <?php } else { ?>
      <div class="form-control-plaintext" 
           style="border-radius: 4px; border: 1px solid #eaeaea; padding: 10px; background-color: #f8f9fa;">
        <div class="text-muted">No image available</div>
      </div>
    <?php } ?>
  </div>
</div>

                                    </div>
                                </div>
                            </div>
                        </div>
                        
<style>
  .footer-btn {
    padding: 8px 20px;
    font-weight: 500;
    border-radius: 6px;
    transition: all 0.3s ease;
  }

  .btn-add {
    background-color: #007bff;
    border-color: #007bff;
    color: #fff;
  }
  .btn-add:hover {
    background-color: #0056b3;
  }

  .btn-edit {
    background-color: #006400; /* Dark Green */
    border-color: #006400;
    color: #fff;
  }
  .btn-edit:hover,
  .btn-edit:focus {
    background-color: #008000;
    transform: scale(1.05);
    box-shadow: 0 3px 8px rgba(0, 128, 0, 0.3);
  }

  .btn-back {
    background-color: #dc3545;
    border-color: #dc3545;
    color: #fff;
  }
  .btn-back:hover {
    background-color: #b52b37;
  }

  .footer-btn i {
    margin-right: 6px;
    transition: transform 0.3s ease;
  }

  .footer-btn:hover i {
    transform: rotate(15deg);
  }
</style>

<div class="card-footer" style="background-color: white; border-top: 1px solid #eaeaea; border-radius: 0 0 8px 8px; padding: 20px 30px;">
  <div class="row">
    <div class="col-sm-12 text-right">
      
      <!-- Add New Product Button -->
      <a href="<?php echo base_url(); ?>Product/AddProduct" class="btn footer-btn btn-add">
        <i class="fa fa-plus-circle"></i> Add New Product
      </a>

      <!-- Edit Product Button (Dark Green) -->
      <a href="<?php echo base_url(); ?>Product/EditProduct/<?php echo $GetProduct->ProductId; ?>" class="btn footer-btn btn-edit" style="margin-left: 10px;">
        <i class="fa fa-medkit"></i> Edit Product
      </a>

      <!-- Back to List Button -->
      <a href="<?php echo base_url(); ?>Product/" class="btn footer-btn btn-back" style="margin-left: 10px;">
        <i class="fa fa-arrow-left"></i> Back to List
      </a>

    </div>
  </div>
</div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<?php $this->load->view("includes/footer"); ?>