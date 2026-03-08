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

                <!-- Page Title -->
                <div class="col-sm-6">
                    <h1 style="color: #2e2e2e; font-weight: 700; font-family: 'Segoe UI', Roboto, sans-serif;">
                        <i class="fas fa-user-edit" 
                           style="color: #098b52; transition: transform 0.3s ease, color 0.3s ease;"></i>
                        Edit Customer
                    </h1>
                </div>

                <style>
                /* Hover effect for page icon */
                h1:hover i {
                    color: #06a77d;
                    transform: scale(1.15);
                }
                </style>

                <!-- Breadcrumb -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right custom-breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="<?php echo base_url(); ?>Dashboard">
                                <i class="fa fa-home"></i> Home
                            </a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="<?php echo base_url(); ?>Customer/">
                                <i class="fa fa-users"></i> Customers
                            </a>
                        </li>
                        <li class="breadcrumb-item active">
                            <i class="fa fa-edit"></i> Edit Customer
                        </li>
                    </ol>
                </div>

                <style>
                /* Dark green breadcrumb (same as Product Form) */
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

                .custom-breadcrumb .breadcrumb-item a,
                .custom-breadcrumb .breadcrumb-item.active {
                    color: #ffffff !important;
                    font-weight: 500;
                    text-decoration: none;
                }

                .custom-breadcrumb i {
                    color: #ffffff;
                    margin-right: 5px;
                }

                .custom-breadcrumb .breadcrumb-item a:hover {
                    text-decoration: underline;
                }

                .custom-breadcrumb .breadcrumb-item + .breadcrumb-item::before {
                    content: "\f105"; /* Font Awesome right arrow */
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
                    <div class="card" style="border-radius: 8px; box-shadow: 0 2px 15px rgba(0,0,0,0.08); border: none;">
                        <div class="card-header" style="background-color: white; border-bottom: 1px solid #eaeaea; border-radius: 8px 8px 0 0;">
                            <h3 class="card-title" style="color: #2e2e2e; font-weight: 600; font-family: 'Segoe UI', Roboto, sans-serif;">
                                <i class="fas fa-edit mr-2" style="color: #098b52;"></i> Customer Information
                            </h3>
                            <p class="text-muted mt-2" style="font-size: 14px;">
                                <span class="text-danger">*</span> Indicates required fields
                            </p>
                        </div>

                        
                        <form role="form" class="form-horizontal" enctype="multipart/form-data" action='<?php echo base_url("Customer/SaveCustomer/".$GetCustomer->CustomerId); ?>' method="post" id="customerForm">
                            <div class="card-body" style="padding: 30px;">
                                <?php if($this->session->flashdata('Validate_message')): ?>
                                <div class="alert alert-danger alert-dismissible" style="border-radius: 4px;">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                    <i class="icon fas fa-ban"></i> <?php echo $this->session->flashdata('Validate_message'); ?>
                                </div>
                                <?php endif; ?>
                                
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group row mb-4">
                                            <label for="CustomerName" class="col-sm-3 col-form-label" style="font-weight: 600; color: #444; font-family: 'Segoe UI', Roboto, sans-serif;">
                                                Customer Name <span class="text-danger">*</span>
                                            </label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control form-control-lg required-field" name="CustomerName" id="CustomerName" value="<?php echo $GetCustomer->CustomerName; ?>" required autocomplete="off" style="border-radius: 4px; border: 1px solid #ddd; padding: 10px; font-family: 'Segoe UI', Roboto, sans-serif;">
                                                <small class="form-text text-muted" style="font-size: 12px;">Legal name of customer</small>
                                                <div class="alert-msg text-danger mt-1" style="font-size: 12px; display: none;">
                                                    <i class="fas fa-exclamation-circle"></i> Customer Name is required
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group row mb-4">
                                            <label for="ContactName" class="col-sm-3 col-form-label" style="font-weight: 600; color: #444; font-family: 'Segoe UI', Roboto, sans-serif;">CNIC No.</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control form-control-lg" name="ContactName" id="ContactName" value="<?php echo $GetCustomer->ContactName; ?>" autocomplete="off" placeholder="XXXXX-XXXXXXX-X" style="border-radius: 4px; border: 1px solid #ddd; padding: 10px; font-family: 'Segoe UI', Roboto, sans-serif;">
                                            </div>
                                        </div>

                                        <div class="form-group row mb-4">
                                            <label for="Address" class="col-sm-3 col-form-label" style="font-weight: 600; color: #444; font-family: 'Segoe UI', Roboto, sans-serif;">Address</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control form-control-lg" name="Address" id="Address" value="<?php echo $GetCustomer->Address; ?>" autocomplete="off" style="border-radius: 4px; border: 1px solid #ddd; padding: 10px; font-family: 'Segoe UI', Roboto, sans-serif;">
                                            </div>
                                        </div>
                                        
                                        <div class="form-group row mb-4">
                                            <label for="Area_name" class="col-sm-3 col-form-label" style="font-weight: 600; color: #444; font-family: 'Segoe UI', Roboto, sans-serif;">Company</label>
                                            <div class="col-sm-9">
                                                <select class="form-control select2 form-control-lg" id="Area_name" name="Area_name" style="border-radius: 4px; border: 1px solid #ddd; padding: 8px; font-family: 'Segoe UI', Roboto, sans-serif;">
                                                    <?php foreach($GetAllAreas as $value): ?>
                                                    <option value="<?php echo $value["Area_name"]; ?>" <?php if($value['Area_name'] == $GetCustomer->AreaId) echo "selected"; ?>>
                                                        <?php echo $value['Area_name']; ?>
                                                    </option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                        </div>
                                        
                                        <div class="form-group row mb-4">
                                            <label for="Email" class="col-sm-3 col-form-label" style="font-weight: 600; color: #444; font-family: 'Segoe UI', Roboto, sans-serif;">ST Registration No</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control form-control-lg" name="Email" id="Email" value="<?php echo $GetCustomer->Email; ?>" autocomplete="off" style="border-radius: 4px; border: 1px solid #ddd; padding: 10px; font-family: 'Segoe UI', Roboto, sans-serif;">
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <div class="form-group row mb-4">
                                            <label for="PhoneNo" class="col-sm-3 col-form-label" style="font-weight: 600; color: #444; font-family: 'Segoe UI', Roboto, sans-serif;">
                                                NTN No. <span class="text-danger">*</span>
                                            </label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control form-control-lg required-field" name="PhoneNo" id="PhoneNo" value="<?php echo $GetCustomer->PhoneNo; ?>" required autocomplete="off" style="border-radius: 4px; border: 1px solid #ddd; padding: 10px; font-family: 'Segoe UI', Roboto, sans-serif;">
                                                <div class="alert-msg text-danger mt-1" style="font-size: 12px; display: none;">
                                                    <i class="fas fa-exclamation-circle"></i> NTN No. is required
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="form-group row mb-4">
                                            <label for="CellNo" class="col-sm-3 col-form-label" style="font-weight: 600; color: #444; font-family: 'Segoe UI', Roboto, sans-serif;">Primary Phone</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control form-control-lg" name="CellNo" id="CellNo" value="<?php echo $GetCustomer->CellNo; ?>" autocomplete="off" placeholder="+92 XXX XXXXXXX" style="border-radius: 4px; border: 1px solid #ddd; padding: 10px; font-family: 'Segoe UI', Roboto, sans-serif;">
                                            </div>
                                        </div>
                                        
<div class="form-group row mb-4">
    <label for="FaxNo" class="col-sm-3 col-form-label" style="font-weight: 600; color: #444; font-family: 'Segoe UI', Roboto, sans-serif;">
        Province <span class="text-danger">*</span>
    </label>
    <div class="col-sm-9">
        <select class="form-control select2 form-control-lg required-field" id="FaxNo" name="FaxNo" required style="border-radius: 4px; border: 1px solid #ddd; padding: 8px; font-family: 'Segoe UI', Roboto, sans-serif;">
            <option value="">Select Province</option>
            <option value="AZAD JAMMU AND KASHMIR" <?php echo ($GetCustomer->FaxNo == 'AZAD JAMMU AND KASHMIR') ? 'selected' : ''; ?>>AZAD JAMMU AND KASHMIR</option>
            <option value="BALOCHISTAN" <?php echo ($GetCustomer->FaxNo == 'BALOCHISTAN') ? 'selected' : ''; ?>>BALOCHISTAN</option>
            <option value="CAPITAL TERRITORY" <?php echo ($GetCustomer->FaxNo == 'CAPITAL TERRITORY') ? 'selected' : ''; ?>>CAPITAL TERRITORY</option>
            <option value="FATA/PATA" <?php echo ($GetCustomer->FaxNo == 'FATA/PATA') ? 'selected' : ''; ?>>FATA/PATA</option>
            <option value="GILGIT BALTISTAN" <?php echo ($GetCustomer->FaxNo == 'GILGIT BALTISTAN') ? 'selected' : ''; ?>>GILGIT BALTISTAN</option>
            <option value="KHYBER PAKHTUNKHWA" <?php echo ($GetCustomer->FaxNo == 'KHYBER PAKHTUNKHWA') ? 'selected' : ''; ?>>KHYBER PAKHTUNKHWA</option>
            <option value="PUNJAB" <?php echo ($GetCustomer->FaxNo == 'PUNJAB') ? 'selected' : ''; ?>>PUNJAB</option>
            <option value="SINDH" <?php echo ($GetCustomer->FaxNo == 'SINDH') ? 'selected' : ''; ?>>SINDH</option>
        </select>
        <div class="alert-msg text-danger mt-1" style="font-size: 12px; display: none;">
            <i class="fas fa-exclamation-circle"></i> Province is required
        </div>
    </div>
</div>

                                        

                                        
                                        <div class="form-group row mb-4">
                                            <label for="Website" class="col-sm-3 col-form-label" style="font-weight: 600; color: #444; font-family: 'Segoe UI', Roboto, sans-serif;">Product Rate</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control form-control-lg" name="Website" id="Website" value="<?php echo $GetCustomer->Website; ?>" autocomplete="off" placeholder="Type Rate Here" style="border-radius: 4px; border: 1px solid #ddd; padding: 10px; font-family: 'Segoe UI', Roboto, sans-serif;">
                                            </div>
                                        </div>
                                        
                                        <div class="form-group row mb-4">
                                            <label for="note" class="col-sm-3 col-form-label" style="font-weight: 600; color: #444; font-family: 'Segoe UI', Roboto, sans-serif;">Notes</label>
                                            <div class="col-sm-9">
                                                <textarea rows="3" class="form-control form-control-lg" name="note" autocomplete="off" style="border-radius: 4px; border: 1px solid #ddd; padding: 10px; font-family: 'Segoe UI', Roboto, sans-serif;"><?php echo $GetCustomer->Note; ?></textarea>
                                            </div>
                                        </div>
                                        
                                        <div class="form-group row mb-4">
                                            <label for="alert_date" class="col-sm-3 col-form-label" style="font-weight: 600; color: #444; font-family: 'Segoe UI', Roboto, sans-serif;">Follow-up Date</label>
                                            <div class="col-sm-9">
                                                <input type="date" class="form-control form-control-lg" name="alert_date" id="alert_date" value="<?php echo $GetCustomer->AlertDate; ?>" autocomplete="off" style="border-radius: 4px; border: 1px solid #ddd; padding: 10px; font-family: 'Segoe UI', Roboto, sans-serif;">
                                            </div>
                                        </div>
                                        
                                        <div class="form-group row mb-4">
                                            <label for="Cleared" class="col-sm-3 col-form-label" style="font-weight: 600; color: #444; font-family: 'Segoe UI', Roboto, sans-serif;">Amount Cleared</label>
                                            <div class="col-sm-9">
                                                <div class="custom-control custom-switch" style="padding-top: 7px;">
                                                    <input type="checkbox" class="custom-control-input" id="Cleared" name="Cleared" value="1" <?php echo ($GetCustomer->Cleared == 1) ? "checked" : ""; ?>>
                                                    <label class="custom-control-label" for="Cleared"></label>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <input type="hidden" name="ChartOfAccountCode" value="<?php echo $GetCustomer->ChartOfAccountCode;?>">
                                        <input type="hidden" name="ChartOfAccountId" value="<?php echo $GetCustomer->ChartOfAccountId;?>">
                                        <input type="hidden" name="ChartOfAccountCategoryId" value="<?php echo $GetCustomer->ChartOfAccountCategoryId;?>">
                                        <input type="hidden" name="ChartOfAccountControlId" value="<?php echo $GetCustomer->ChartOfAccountControlId;?>">
                                        <input type="hidden" name="ChartOfAccountTitle" id="ChartOfAccountTitle" value="<?php echo $GetCustomer->ChartOfAccountTitle;?>" required readonly>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="card-footer" style="background-color: white; border-top: 1px solid #eaeaea; border-radius: 0 0 8px 8px; padding: 20px 30px;">
                                <div class="row">
                                    <div class="col-sm-12 text-right">
                                        <button type="submit" name="submitForm" value="UpdateRecord" class="btn btn-primary" style="background-color: #0077c5; border-color: #0077c5; padding: 10px 25px; font-weight: 600; font-family: 'Segoe UI', Roboto, sans-serif;">
                                            <i class="fas fa-save mr-1"></i> Update Customer
                                        </button>
                                        <a href="<?php echo base_url(); ?>Customer/" class="btn btn-danger" style="background-color: #dc3545; border-color: #dc3545; padding: 10px 25px; margin-left: 10px; font-weight: 500; font-family: 'Segoe UI', Roboto, sans-serif;">
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
$(function(){
    $('#CustomerName').focus(function() {
        $("#ChartOfAccountTitle").val('');
    });
    
    $('#CustomerName').blur(function() {
        var CustomerName = $(this).val();
        $("#ChartOfAccountTitle").val(CustomerName);
    });
    
    // Initialize select2
    $('.select2').select2({
        theme: 'bootstrap4',
        width: '100%'
    });
    
    // Form validation with alerts
    $('#customerForm').on('submit', function(e) {
        var isValid = true;
        
        // Check required fields
        $('.required-field').each(function() {
            if ($(this).val() === '') {
                $(this).addClass('is-invalid');
                $(this).siblings('.alert-msg').show();
                isValid = false;
            } else {
                $(this).removeClass('is-invalid');
                $(this).siblings('.alert-msg').hide();
            }
        });
        
        if (!isValid) {
            e.preventDefault();
            
            // Scroll to first error
            $('.is-invalid').first().focus();
            
            // Show alert message
            $('html, body').animate({
                scrollTop: $('.is-invalid').first().offset().top - 100
            }, 500);
        }
    });
    
    // Remove error styling when user starts typing
    $('.required-field').on('input change', function() {
        if ($(this).val() !== '') {
            $(this).removeClass('is-invalid');
            $(this).siblings('.alert-msg').hide();
        }
    });
});
</script>

<style>
.is-invalid {
    border-color: #dc3545 !important;
}
</style>

<?php $this->load->view("includes/footer"); ?>