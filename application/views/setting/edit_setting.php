<?php 
    $this->load->view('includes/header');
    $this->load->view('includes/sidebar'); 
    $SettingId = $GetSetting->SettingId; 
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper" style="background-color: #f9f9f9;">
    <!-- Content Header (Page header) -->
    <section class="content-header" style="padding: 20px 20px 10px;">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h1 style="color: #2e2e2e; font-weight: 600;"><i class="fas fa-cog" style="color: #0077c5;"></i> Business Profile</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>Dashboard" style="color: #0077c5;">Home</a></li>
                        <li class="breadcrumb-item"><a href="#" style="color: #0077c5;">Settings</a></li>
                        <li class="breadcrumb-item active">Business Profile</li>
                    </ol>
                </div>
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
                            <h3 class="card-title" style="color: #2e2e2e; font-weight: 600;"><i class="fas fa-building mr-2" style="color: #0077c5;"></i> Company Information</h3>
                        </div>
                        
                        <form role="form" class="form-horizontal" id="Settingform" enctype="multipart/form-data" action='<?php echo base_url("Setting/UpdateSetting/$SettingId"); ?>' method="post">
                            <div class="card-body" style="padding: 30px;">
                                <div class="row">
                                    <div class="col-md-6">
                                        <input type="hidden" name="SettingId" id="SettingId" value="<?php echo $SettingId = $GetSetting->SettingId; ?>">
                                        <input type="hidden" name="PreviousLogo" id="PreviousLogo" value="<?php echo $GetSetting->CompanyLogo?>">

                                        <div class="form-group row mb-4">
                                            <label for="CompanyName" class="col-sm-4 col-form-label" style="font-weight: 500; color: #555;">Business Name*</label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control form-control-lg" name="CompanyName" id="CompanyName" value="<?php echo htmlspecialchars($GetSetting->CompanyName); ?>" required style="border-radius: 4px; border: 1px solid #ddd; padding: 10px;">
                                                <small class="form-text text-muted">Legal name of your business</small>
                                                <span class="text-danger"><?php echo form_error('CompanyName'); ?></span>
                                            </div>
                                        </div>

                                        <div class="form-group row mb-4">
                                            <label for="ContactPerson" class="col-sm-4 col-form-label" style="font-weight: 500; color: #555;">Contact Person</label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control form-control-lg" name="ContactPerson" id="ContactPerson" placeholder="Primary contact" value="<?php echo $GetSetting->ContactPerson; ?>" style="border-radius: 4px; border: 1px solid #ddd; padding: 10px;">
                                                <span class="text-danger"><?php echo form_error('Email'); ?></span>
                                            </div>
                                        </div>

                                        <div class="form-group row mb-4">
                                            <label for="ContactNumber" class="col-sm-4 col-form-label" style="font-weight: 500; color: #555;">Phone Number</label>
                                            <div class="col-sm-8">
                                                <input type="number" class="form-control form-control-lg" name="ContactNumber" id="ContactNumber" value="<?php echo $GetSetting->ContactNumber?>" placeholder="+1 (___) ___-____" style="border-radius: 4px; border: 1px solid #ddd; padding: 10px;">
                                                <span class="text-danger"><?php echo form_error('ContactNumber'); ?></span>
                                            </div>
                                        </div>

                                        <div class="form-group row mb-4">
                                            <label for="Email" class="col-sm-4 col-form-label" style="font-weight: 500; color: #555;">NTN Number</label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control form-control-lg" name="Email" id="Email" value="<?php echo $GetSetting->Email?>" placeholder="Enter NTN" style="border-radius: 4px; border: 1px solid #ddd; padding: 10px;">
                                                <span class="text-danger"><?php echo form_error('Email'); ?></span>
                                            </div>
                                        </div>

                                        <div class="form-group row mb-4">
                                            <label for="Address" class="col-sm-4 col-form-label" style="font-weight: 500; color: #555;">ST Registration No</label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control form-control-lg" name="Address" id="Address" value="<?php echo $GetSetting->Address?>" placeholder="Sales tax registration number" style="border-radius: 4px; border: 1px solid #ddd; padding: 10px;">
                                            </div>
                                        </div>

                                        <div class="form-group row mb-4">
                                            <label for="ProductsDeals" class="col-sm-4 col-form-label" style="font-weight: 500; color: #555;">Address:</label>
                                            <div class="col-sm-8">
                                                <textarea class="form-control form-control-lg" rows="3" name="ProductsDeals" id="ProductsDeals" style="border-radius: 4px; border: 1px solid #ddd; padding: 10px;"><?php echo $GetSetting->ProductsDeals?></textarea>
                                                <small class="form-text text-muted">What does your business sell?</small>
                                            </div>
                                        </div>
                                    </div>

<div class="col-md-6">
    <!-- Company Logo Upload Section -->
    <div class="form-group row mb-4">
        <div class="col-sm-12">
            <div class="card" style="border: 1px dashed #ddd; background-color: #fafafa;">
                <div class="card-body text-center">
                    <div class="mb-3">
                        <?php if(!empty($GetSetting->CompanyLogo)): ?>
                            <img src="<?php echo base_url() ?>images/company-logo/<?php echo $GetSetting->CompanyLogo ?>" class="img-fluid" alt="Business Logo" style="max-height: 200px; border-radius: 4px;">
                        <?php endif; ?>
                    </div>
                    <h5 style="font-weight: 500; color: #555;">Business Logo</h5>
                    <p class="text-muted">Recommended size: 300x300px</p>
                    <input type="file" name="CompanyLogo" class="d-none" id="logoUpload">
                    <button type="button" class="btn btn-outline-primary btn-sm" onclick="document.getElementById('logoUpload').click()">
                        <i class="fas fa-upload mr-1"></i> Upload New Logo
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Hidden field to store old signature value -->
    <input type="hidden" name="signatureold" id="signatureold" value="<?php echo $GetSetting->signature ?>">
    
    <!-- Signature Upload Section -->
    <div class="form-group row mb-4">
        <div class="col-sm-12">
            <div class="card" style="border: 1px dashed #ddd; background-color: #fafafa;">
                <div class="card-body text-center">
                    <div class="mb-3">
                        <?php if(!empty($GetSetting->signature)): ?>
                            <img src="<?php echo base_url() ?>images/signature/<?php echo $GetSetting->signature ?>" class="img-fluid" alt="Authorized Signature" style="max-height: 200px; border-radius: 4px;">
                        <?php endif; ?>
                    </div>
                    <h5 style="font-weight: 500; color: #555;">Authorized Signature</h5>
                    <p class="text-muted">Upload signature for official documents</p>
                    <input type="file" name="signature" class="d-none" id="signatureUpload">
                    <button type="button" class="btn btn-outline-primary btn-sm" onclick="document.getElementById('signatureUpload').click()">
                        <i class="fas fa-upload mr-1"></i> Upload Signature
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
                            
                            <div class="card-footer" style="background-color: white; border-top: 1px solid #eaeaea; border-radius: 0 0 8px 8px; padding: 20px 30px;">
                                <div class="row">
                                    <div class="col-sm-12 text-right">
                                        <button type="submit" id="UpdateRecord" class="btn btn-primary" style="background-color: #0077c5; border-color: #0077c5; padding: 8px 20px; font-weight: 500;">
                                            <i class="fas fa-save mr-1"></i> Save Changes
                                        </button>
                                        <a href="<?php echo base_url(); ?>Setting" class="btn btn-outline-secondary" style="padding: 8px 20px; margin-left: 10px;">
                                            Cancel
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

<?php $this->load->view('includes/footer'); ?>

<script type="text/javascript">
  $(function(){
    $('#CompanyName').bind('keyup blur',function(){ 
        var CompanyName = $(this);
        CompanyName.val(CompanyName.val().replace(/[^a-z A-Z" "]/g,'') ); 
    });
    
    //