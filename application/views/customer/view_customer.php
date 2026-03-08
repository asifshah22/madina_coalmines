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
                        <i class="fas fa-user-tie" 
                           style="color: #098b52; transition: transform 0.3s ease, color 0.3s ease;"></i> 
                        Customer Details
                    </h1>
                </div>

                <style>
                /* Hover effect for main page icon */
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
                            <i class="fa fa-eye"></i> View Details
                        </li>
                    </ol>
                </div>

                <style>
                /* Matching breadcrumb with professional dark green gradient */
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
                                <i class="fas fa-eye mr-2" style="color: #098b52;"></i> Customer Information
                            </h3>
                            <div class="card-tools">
                                <a href="<?php echo base_url(); ?>Customer/EditCustomer/<?php echo $GetCustomer->CustomerId; ?>" 
                                   class="btn btn-sm btn-outline-success" 
                                   style="font-family: 'Segoe UI', Roboto, sans-serif; border-radius: 5px;">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                            </div>
                        </div>

                        
                        <div class="card-body" style="padding: 30px;">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group row mb-4">
                                        <label class="col-sm-3 col-form-label" style="font-weight: 600; color: #444; font-family: 'Segoe UI', Roboto, sans-serif;">Customer Name</label>
                                        <div class="col-sm-9">
                                            <div class="form-control-plaintext view-field" style="padding: 10px 0; font-family: 'Segoe UI', Roboto, sans-serif;">
                                                <?php echo $GetCustomer->CustomerName; ?>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group row mb-4">
                                        <label class="col-sm-3 col-form-label" style="font-weight: 600; color: #444; font-family: 'Segoe UI', Roboto, sans-serif;">CNIC/Registration No.</label>
                                        <div class="col-sm-9">
                                            <div class="form-control-plaintext view-field" style="padding: 10px 0; font-family: 'Segoe UI', Roboto, sans-serif;">
                                                <?php echo $GetCustomer->ContactName; ?>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group row mb-4">
                                        <label class="col-sm-3 col-form-label" style="font-weight: 600; color: #444; font-family: 'Segoe UI', Roboto, sans-serif;">Address</label>
                                        <div class="col-sm-9">
                                            <div class="form-control-plaintext view-field" style="padding: 10px 0; font-family: 'Segoe UI', Roboto, sans-serif;">
                                                <?php echo $GetCustomer->Address; ?>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="form-group row mb-4">
                                        <label class="col-sm-3 col-form-label" style="font-weight: 600; color: #444; font-family: 'Segoe UI', Roboto, sans-serif;">Company</label>
                                        <div class="col-sm-9">
                                            <div class="form-control-plaintext view-field" style="padding: 10px 0; font-family: 'Segoe UI', Roboto, sans-serif;">
                                                <?php foreach($GetAllAreas as $value): ?>
                                                    <?php if($value['Area_name'] == $GetCustomer->AreaId): ?>
                                                        <?php echo $value['Area_name']; ?>
                                                    <?php endif; ?>
                                                <?php endforeach; ?>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="form-group row mb-4">
                                        <label class="col-sm-3 col-form-label" style="font-weight: 600; color: #444; font-family: 'Segoe UI', Roboto, sans-serif;">ST Registration No</label>
                                        <div class="col-sm-9">
                                            <div class="form-control-plaintext view-field" style="padding: 10px 0; font-family: 'Segoe UI', Roboto, sans-serif;">
                                                <?php echo $GetCustomer->Email; ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="form-group row mb-4">
                                        <label class="col-sm-3 col-form-label" style="font-weight: 600; color: #444; font-family: 'Segoe UI', Roboto, sans-serif;">NTN No.</label>
                                        <div class="col-sm-9">
                                            <div class="form-control-plaintext view-field" style="padding: 10px 0; font-family: 'Segoe UI', Roboto, sans-serif;">
                                                <?php echo $GetCustomer->PhoneNo; ?>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="form-group row mb-4">
                                        <label class="col-sm-3 col-form-label" style="font-weight: 600; color: #444; font-family: 'Segoe UI', Roboto, sans-serif;">Primary Phone</label>
                                        <div class="col-sm-9">
                                            <div class="form-control-plaintext view-field" style="padding: 10px 0; font-family: 'Segoe UI', Roboto, sans-serif;">
                                                <?php echo $GetCustomer->CellNo; ?>
                                            </div>
                                        </div>
                                    </div>
                                    
<div class="form-group row mb-4">
    <label class="col-sm-3 col-form-label" style="font-weight: 600; color: #444; font-family: 'Segoe UI', Roboto, sans-serif;">
        Province
    </label>
    <div class="col-sm-9">
        <div class="form-control-plaintext view-field" style="padding: 10px 0; font-family: 'Segoe UI', Roboto, sans-serif;">
            <?php echo !empty($GetCustomer->FaxNo) ? $GetCustomer->FaxNo : '-'; ?>
        </div>
    </div>
</div>

                                    

                                    
                                    <div class="form-group row mb-4">
                                        <label class="col-sm-3 col-form-label" style="font-weight: 600; color: #444; font-family: 'Segoe UI', Roboto, sans-serif;">Product Rate</label>
                                        <div class="col-sm-9">
                                            <div class="form-control-plaintext view-field" style="padding: 10px 0; font-family: 'Segoe UI', Roboto, sans-serif;">
                                                <?php echo $GetCustomer->Website; ?>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="form-group row mb-4">
                                        <label class="col-sm-3 col-form-label" style="font-weight: 600; color: #444; font-family: 'Segoe UI', Roboto, sans-serif;">Notes</label>
                                        <div class="col-sm-9">
                                            <div class="form-control-plaintext view-field" style="padding: 10px 0; min-height: 60px; font-family: 'Segoe UI', Roboto, sans-serif;">
                                                <?php echo $GetCustomer->Note; ?>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="form-group row mb-4">
                                        <label class="col-sm-3 col-form-label" style="font-weight: 600; color: #444; font-family: 'Segoe UI', Roboto, sans-serif;">Follow-up Date</label>
                                        <div class="col-sm-9">
                                            <div class="form-control-plaintext view-field" style="padding: 10px 0; font-family: 'Segoe UI', Roboto, sans-serif;">
                                                <?php echo $GetCustomer->AlertDate; ?>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="form-group row mb-4">
                                        <label class="col-sm-3 col-form-label" style="font-weight: 600; color: #444; font-family: 'Segoe UI', Roboto, sans-serif;">Amount Cleared</label>
                                        <div class="col-sm-9">
                                            <div class="form-control-plaintext view-field" style="padding: 10px 0; font-family: 'Segoe UI', Roboto, sans-serif;">
                                                <?php echo ($GetCustomer->Cleared == 1) ? 'Yes' : 'No'; ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="card-footer" style="background-color: white; border-top: 1px solid #eaeaea; border-radius: 0 0 8px 8px; padding: 20px 30px;">
                            <div class="row">
                                <div class="col-sm-12 text-right">
                                    <a href="<?php echo base_url(); ?>Customer/AddCustomer" class="btn btn-primary" style="background-color: #0077c5; border-color: #0077c5; padding: 10px 25px; font-weight: 600; font-family: 'Segoe UI', Roboto, sans-serif;">
                                        <i class="fas fa-plus mr-1"></i> Add New Customer
                                    </a>
                                    <a href="<?php echo base_url(); ?>Customer/" class="btn btn-danger" style="background-color: #dc3545; border-color: #dc3545; padding: 10px 25px; margin-left: 10px; font-weight: 500; font-family: 'Segoe UI', Roboto, sans-serif;">
                                        <i class="fas fa-arrow-left mr-1"></i> Back to List
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<style>
.view-field {
    border-bottom: 1px solid #eaeaea;
    color: #555;
    font-weight: 500;
}
</style>

<?php $this->load->view("includes/footer"); ?>