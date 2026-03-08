<?php defined('BASEPATH') OR exit('No direct script access allowed');

class PurchaseReports extends CI_Controller {

	public function __construct()
	{
	    parent::__construct();
        $this->check_isvalidated();
	    $this->load->model('Vendor_model');
	    $this->load->model('Product_model');
	    $this->load->model('ProductGroup_model');
	    $this->load->model('Purchase_model');
	    $this->load->model('PurchaseReturnReport_model');
	    $this->load->model('PurchaseReport_model');
	    $this->load->model('Employee_model');
	    $this->load->model('Location_model');
	    $this->load->model('Category_model');
	    $this->load->model('Customer_model');
//            $this->output->enable_profiler();
	}
	
	
	private function check_isvalidated()
	{
        if(!$this->session->userdata('EmployeeId') || $this->session->userdata('EmployeeType') == 3)
        { 
            $this->session->set_userdata('url',  current_url());
            redirect("Login"); 
        }
	}

	
	public function index()
	{
        $data['Roles'] = $this->Employee_model->GetRoles();
        $data['AdministrationRoles'] = $this->Employee_model->GetAdministrationRoles($this->session->userdata('EmployeeId'));
        $data['SalesRoles'] = $this->Employee_model->GetSalesRoles($this->session->userdata('EmployeeId'));
        $data['PurchasesRoles'] = $this->Employee_model->GetPurchasesRoles($this->session->userdata('EmployeeId'));
        $data['RegistrationRoles'] = $this->Employee_model->GetRegistrationRoles($this->session->userdata('EmployeeId'));
        $data['TransactionRoles'] = $this->Employee_model->GetTransactionRoles($this->session->userdata('EmployeeId'));
        $data['ReportsRoles'] = $this->Employee_model->GetReportsRoles($this->session->userdata('EmployeeId'));
        $data['CustomerNotification'] = $this->Customer_model->GetNotifications();
	    $this->load->view('report/purchasereports/purchase_reports', $data);
	}


	function PurchaseDetailReportCriteria()
    {
	    $StartDate = date("m/d/Y");
	    $Products = '';
	    $Vendors = '';
	    $Categories = '';
	    $ProductGroups = '';
	    $Brands = '';
	    $Locations = '';
	   
        $AllVendors = $this->Vendor_model->GetAllVendors();
		$AllCategories = $this->Category_model->GetAllCategories();
		$AllProductGroups = $this->ProductGroup_model->GetAllProductGroups();
		$AllBrands = $this->Product_model->GetAllBrands();
	    $AllProducts = $this->Product_model->GetAllProducts();
	    $AllLocations = $this->Location_model->GetAllLocation();
	    
	    foreach($AllVendors as  $value)
        {
	       $Vendors .= '<option value="'.$value["VendorId"].'">'.$value['VendorName'].'</option>';
        }

	    foreach($AllCategories as  $value)
        {
	       $Categories .= '<option value="'.$value["CategoryId"].'"> ' .$value['CategoryName'].' </option>';
        }

	    foreach($AllProductGroups as  $value)
        {
	       $ProductGroups .= '<option value="'.$value["ProductGroupId"].'"> ' .$value['ProductGroupName'].' </option>';
        }

	    foreach($AllBrands as  $value)
        {
	       $Brands .= '<option value="'.$value["BrandId"].'"> ' .$value['BrandName'].' </option>';
        }

	    foreach($AllProducts as  $value)
        {
	       $Products .= '<option value="'.$value["ProductId"].'"> ' .$value['ProductName'].' </option>';
        }

	    foreach($AllLocations as  $value)
        {
	       $Locations .= '<option value="'.$value["LocationId"].'"> ' .$value['LocationName'].' </option>';
        }
	    
	
	    $ReportCriteria ='<div style="width:40%; margin-left:190px;" class="box-header with-border">
	    <h3 class="box-title text-light-blue">Report Criteria</h3>
	    </div>';
	    $ReportCriteria .='<div class="form-group">
		     <label style="width:24%;" for="Vendors" class="col-sm-1 control-label">Vendors:</label>
		       <div class="input-group date">
			  <select style="width:270px;" class="form-control select2" id="VendorId">
			    <option value="0" selected="selected">All Vendors</option>
			    '.$Vendors.'
			  </select>
		       </div>
	    </div>';
	    $ReportCriteria .='<div class="form-group">
		     <label style="width:24%;" for="Categories" class="col-sm-1 control-label">Category:</label>
		       <div class="input-group date">
			  <select style="width:270px;" class="form-control select2" id="CategoryId">
			    <option value="0" selected="selected">All Categories</option>
			    '.$Categories.'
			  </select>
		       </div>                  
	    </div>';
	    $ReportCriteria .='<div class="form-group">
		     <label style="width:24%;" for="ProductGroups" class="col-sm-1 control-label">ProductGroups:</label>
		       <div class="input-group date">
			  <select style="width:270px;" class="form-control select2" id="ProductGroupId">
			    <option value="0" selected="selected">All ProductGroups</option>
			    '.$ProductGroups.'
			  </select>
		       </div>                  
	    </div>';
	    $ReportCriteria .='<div class="form-group">
		     <label style="width:24%;" for="Brands" class="col-sm-1 control-label">Brands:</label>
		       <div class="input-group date">
			  <select style="width:270px;" class="form-control select2" id="BrandId">
			    <option value="0" selected="selected">All Brands</option>
			    '.$Brands.'
			  </select>
		       </div>
	    </div>';
	    $ReportCriteria .='<div class="form-group">
		     <label style="width:24%;" for="Products" class="col-sm-1 control-label">Products:</label>
		       <div class="input-group date">
			  <select style="width:270px;" class="form-control select2" id="ProductId">
			    <option value="0" selected="selected">All Products</option>
			    '.$Products.'
			  </select>
		       </div>
	    </div>';
	    $ReportCriteria .='<div class="form-group">
		     <label style="width:24%;" for="Locations" class="col-sm-1 control-label">Locations:</label>
		       <div class="input-group date">
			  <select style="width:270px;" class="form-control select2" id="LocationId">
			    <option value="0" selected="selected">All Locations</option>
			    '.$Locations.'
			  </select>
		       </div>
	    </div>';
	    $ReportCriteria .='<div class="form-group">
		     <label style="width:24%;" for="SaleType" class="col-sm-1 control-label">Purchase Type:</label>
		       <div class="input-group date">
			  <select style="width:270px;" class="form-control select2" id="PurchaseType">
			    <option value="0" selected="selected">Purchase Type</option>
			    <option value="1">Cash</option>
			    <option value="2">Credit</option>
			  </select>
		       </div>
	    </div>';
	    $ReportCriteria .='<div class="form-group">
		     <label style="width:24%;" for="StartDate" class="col-sm-1 control-label">Date From:</label>
		       <div class="input-group date">
			  <div class="input-group-addon">
			     <i class="fa fa-calendar"></i>
			  </div>               
			  <input class="form-control" name="StartDate" id="datepicker1" type="text" placeholder="Enter Start Date" style="width:40%;" value="" autocomplete="off">
		       </div>                  
	    </div>';
	    $ReportCriteria .='<div class="form-group">
		     <label style="width:24%;" for="EndDate" class="col-sm-1 control-label">Date To:</label>
		       <div class="input-group date">
			  <div class="input-group-addon">
			     <i class="fa fa-calendar"></i>
			  </div>     
			  <input class="form-control" name="OrderDate" id="datepicker2" type="text" placeholder="Enter End Date" style="width:40%;" value="" autocomplete="off">
		       </div>                  
	    </div>';
	    $ReportCriteria .='<div class="form-group">
		     <label style="width:24%;" class="col-sm-2"></label>
		       <div class="input-group date">
			  <button type="button" id="generate_purchase_detail_report" class="btn  btn-primary">Show Report</button>
		       </div>                  
	    </div>';
	    echo $ReportCriteria;
	    $this->load->view("includes/footer");
	}	


	function PurchaseReturnReportCriteria()
    {
	    $StartDate = date("m/d/Y");
	    $Products = '';
	    $Vendors = '';
	    $Categories = '';
	    $ProductGroups = '';
	    $Brands = '';
	    $Locations = '';
	   
        $AllVendors = $this->Vendor_model->GetAllVendors();
		$AllCategories = $this->Category_model->GetAllCategories();
		$AllProductGroups = $this->ProductGroup_model->GetAllProductGroups();
		$AllBrands = $this->Product_model->GetAllBrands();
	    $AllProducts = $this->Product_model->GetAllProducts();
	    $AllLocations = $this->Location_model->GetAllLocation();
	    
	    foreach($AllVendors as  $value)
        {
	       $Vendors .= '<option value="'.$value["VendorId"].'">'.$value['VendorName'].'</option>';
        }

	    foreach($AllCategories as  $value)
        {
	       $Categories .= '<option value="'.$value["CategoryId"].'"> ' .$value['CategoryName'].' </option>';
        }

	    foreach($AllProductGroups as  $value)
        {
	       $ProductGroups .= '<option value="'.$value["ProductGroupId"].'"> ' .$value['ProductGroupName'].' </option>';
        }

	    foreach($AllBrands as  $value)
        {
	       $Brands .= '<option value="'.$value["BrandId"].'"> ' .$value['BrandName'].' </option>';
        }

	    foreach($AllProducts as  $value)
        {
	       $Products .= '<option value="'.$value["ProductId"].'"> ' .$value['ProductName'].' </option>';
        }

	    foreach($AllLocations as  $value)
        {
	       $Locations .= '<option value="'.$value["LocationId"].'"> ' .$value['LocationName'].' </option>';
        }
	    
	
	    $ReportCriteria ='<div style="width:40%; margin-left:190px;" class="box-header with-border">
	    <h3 class="box-title text-light-blue">Report Criteria</h3>
	    </div>';
	    $ReportCriteria .='<div class="form-group">
		     <label style="width:24%;" for="Vendors" class="col-sm-1 control-label">Vendors:</label>
		       <div class="input-group date">
			  <select style="width:270px;" class="form-control select2" id="VendorId">
			    <option value="0" selected="selected">All Vendors</option>
			    '.$Vendors.'
			  </select>
		       </div>
	    </div>';
	    $ReportCriteria .='<div class="form-group">
		     <label style="width:24%;" for="Categories" class="col-sm-1 control-label">Category:</label>
		       <div class="input-group date">
			  <select style="width:270px;" class="form-control select2" id="CategoryId">
			    <option value="0" selected="selected">All Categories</option>
			    '.$Categories.'
			  </select>
		       </div>                  
	    </div>';
	    $ReportCriteria .='<div class="form-group">
		     <label style="width:24%;" for="ProductGroups" class="col-sm-1 control-label">ProductGroups:</label>
		       <div class="input-group date">
			  <select style="width:270px;" class="form-control select2" id="ProductGroupId">
			    <option value="0" selected="selected">All ProductGroups</option>
			    '.$ProductGroups.'
			  </select>
		       </div>                  
	    </div>';
	    $ReportCriteria .='<div class="form-group">
		     <label style="width:24%;" for="Brands" class="col-sm-1 control-label">Brands:</label>
		       <div class="input-group date">
			  <select style="width:270px;" class="form-control select2" id="BrandId">
			    <option value="0" selected="selected">All Brands</option>
			    '.$Brands.'
			  </select>
		       </div>
	    </div>';
	    $ReportCriteria .='<div class="form-group">
		     <label style="width:24%;" for="Products" class="col-sm-1 control-label">Products:</label>
		       <div class="input-group date">
			  <select style="width:270px;" class="form-control select2" id="ProductId">
			    <option value="0" selected="selected">All Products</option>
			    '.$Products.'
			  </select>
		       </div>
	    </div>';
	    $ReportCriteria .='<div class="form-group">
		     <label style="width:24%;" for="Locations" class="col-sm-1 control-label">Locations:</label>
		       <div class="input-group date">
			  <select style="width:270px;" class="form-control select2" id="LocationId">
			    <option value="0" selected="selected">All Locations</option>
			    '.$Locations.'
			  </select>
		       </div>
	    </div>';
	    $ReportCriteria .='<div class="form-group">
		     <label style="width:24%;" for="StartDate" class="col-sm-1 control-label">Date From:</label>
		       <div class="input-group date">
			  <div class="input-group-addon">
			     <i class="fa fa-calendar"></i>
			  </div>               
			  <input class="form-control" name="StartDate" id="datepicker1" type="text" placeholder="Enter Start Date" style="width:40%;" value="" autocomplete="off">
		       </div>                  
	    </div>';
	    $ReportCriteria .='<div class="form-group">
		     <label style="width:24%;" for="EndDate" class="col-sm-1 control-label">Date To:</label>
		       <div class="input-group date">
			  <div class="input-group-addon">
			     <i class="fa fa-calendar"></i>
			  </div>     
			  <input class="form-control" name="OrderDate" id="datepicker2" type="text" placeholder="Enter End Date" style="width:40%;" value="" autocomplete="off">
		       </div>                  
	    </div>';
	    $ReportCriteria .='<div class="form-group">
		     <label style="width:24%;" class="col-sm-2"></label>
		       <div class="input-group date">
			  <button type="button" id="generate_purchase_return_report" class="btn  btn-primary">Show Report</button>
		       </div>                  
	    </div>';
	    echo $ReportCriteria;
	    $this->load->view("includes/footer");
	}	


	public function PurchaseInvoiceDetailReportCriteria()
	{

		$ReportCriteria ='<div style="width:40%; margin-left:190px;" class="box-header with-border">
	    <h3 class="box-title text-light-blue">Report Criteria</h3>
	    </div>';

	    $ReportCriteria .='<div class="form-group">
		     <label style="width:24%;" for="InvoiceNo" class="col-sm-1 control-label">Invoice #:</label>
		       <div class="input-group date">
			  <input class="form-control" name="InvoiceNo" id="InvoiceNo" type="text" placeholder="Enter Invoice Number" style="width:270px;" value="" autocomplete="off">
		       </div>                  
	    </div>';
	    $ReportCriteria .='<div class="form-group">
		     <label style="width:24%;" class="col-sm-2"></label>
		       <div class="input-group date">
			  <button type="button" id="generate_purchaseinvoice_report" class="btn  btn-primary">Show Report</button>
		       </div>
	    </div>';
	    echo $ReportCriteria;
	    $this->load->view("includes/footer");

	}

/*	public function PurchaseReport()
	{
		$data['GetAllBrands'] = $this->Product_model->GetAllBrands();
		$data['GetAllCategories'] = $this->Product_model->GetAllCategories();
		$data['GetAllProductGroups'] = $this->ProductGroup_model->GetAllProductGroups();
		$data['GetAllLocation'] = $this->Location_model->GetAllLocation();
		$data['GetAllColours'] = $this->Product_model->GetAllColours();
	    $data['GetAllVendor'] = $this->Vendor_model->GetAllVendors();
	    $data['GetAllProducts'] = $this->Product_model->GetAllProducts();
      	
		$data['GetSettingInformation'] = $this->Employee_model->GetSettingInformation();
      	$this->load->view('report/purchase_report', $data);
	}*/
	
	public function PurchaseReport()
	{
		$SDate = "";
        $EDate = "";
        $StartDate = "";
        $EndDate = "";

        if($this->input->get('StartDate') != ""){        	
        	$SDate = $this->input->get('StartDate');
	        $StartDate = date("Y-m-d", strtotime($SDate));
        }

        if($this->input->get('EndDate') != ""){
	        $EDate = $this->input->get('EndDate');
	        $EndDate = date("Y-m-d", strtotime($EDate));
        }

        $VendorId = $this->input->get('VendorId');
        $ProductId = $this->input->get('ProductId');
        $LocationId = $this->input->get('LocationId');
        $PurchaseType = $this->input->get('PurchaseType');
        $ColourId = $this->input->get('ColourId');
        $CategoryId = $this->input->get('CategoryId');
        $ProductGroupId = $this->input->get('ProductGroupId');
        $BrandId = $this->input->get('BrandId');
        

        $data['Roles'] = $this->Employee_model->GetRoles();
        $data['AdministrationRoles'] = $this->Employee_model->GetAdministrationRoles($this->session->userdata('EmployeeId'));
        $data['SalesRoles'] = $this->Employee_model->GetSalesRoles($this->session->userdata('EmployeeId'));
        $data['PurchasesRoles'] = $this->Employee_model->GetPurchasesRoles($this->session->userdata('EmployeeId'));
        $data['RegistrationRoles'] = $this->Employee_model->GetRegistrationRoles($this->session->userdata('EmployeeId'));
        $data['TransactionRoles'] = $this->Employee_model->GetTransactionRoles($this->session->userdata('EmployeeId'));
        $data['ReportsRoles'] = $this->Employee_model->GetReportsRoles($this->session->userdata('EmployeeId'));
		$data['AllPurchaseReport'] = $this->PurchaseReport_model->GetPurchase($VendorId,$ProductId,$LocationId,$PurchaseType,$ColourId,$CategoryId,$ProductGroupId,$BrandId,$StartDate,$EndDate);

		$data['GetSettingInformation'] = $this->Employee_model->GetSettingInformation();
		$data['CustomerNotification'] = $this->Customer_model->GetNotifications();
        $this->load->view('report/purchasereports/view_purchasereport', $data);
	}

	public function PurchaseReturnReport_____()
	{
		$data['GetAllBrands'] = $this->Product_model->GetAllBrands();
		$data['GetAllCategories'] = $this->Product_model->GetAllCategories();
		$data['GetAllProductGroups'] = $this->ProductGroup_model->GetAllProductGroups();
		$data['GetAllLocation'] = $this->Location_model->GetAllLocation();
		$data['GetAllColours'] = $this->Product_model->GetAllColours();
	    $data['GetAllVendor'] = $this->Vendor_model->GetAllVendors();
	    $data['GetAllProducts'] = $this->Product_model->GetAllProducts();
//	    $data['AllPurchaseReport'] = $this->PurchaseReport_model->GetAllPurchases();
		$data['GetSettingInformation'] = $this->Employee_model->GetSettingInformation();
		$data['CustomerNotification'] = $this->Customer_model->GetNotifications();
      	$this->load->view('report/purchasereturn_report', $data);
	}
	

	public function PurchaseReturnReport()
	{
		$SDate = "";
        $EDate = "";
        $StartDate = "";
        $EndDate = "";

        if($this->input->get('StartDate') != ""){        	
        	$SDate = $this->input->get('StartDate');
	        $StartDate = date("Y-m-d", strtotime($SDate));
        }

        if($this->input->get('EndDate') != ""){
	        $EDate = $this->input->get('EndDate');
	        $EndDate = date("Y-m-d", strtotime($EDate));
        }

        $VendorId = $this->input->get('AccountId');
        $ProductId = $this->input->get('ProductId');
        $LocationId = $this->input->get('LocationId');
        $PurchaseType = $this->input->get('PurchaseType');
        $CategoryId = $this->input->get('CategoryId');
        $ProductGroupId = $this->input->get('ProductGroupId');
        $BrandId = $this->input->get('BrandId');
        
        
        $data['Roles'] = $this->Employee_model->GetRoles();
        $data['AdministrationRoles'] = $this->Employee_model->GetAdministrationRoles($this->session->userdata('EmployeeId'));
        $data['SalesRoles'] = $this->Employee_model->GetSalesRoles($this->session->userdata('EmployeeId'));
        $data['PurchasesRoles'] = $this->Employee_model->GetPurchasesRoles($this->session->userdata('EmployeeId'));
        $data['RegistrationRoles'] = $this->Employee_model->GetRegistrationRoles($this->session->userdata('EmployeeId'));
        $data['TransactionRoles'] = $this->Employee_model->GetTransactionRoles($this->session->userdata('EmployeeId'));
        $data['ReportsRoles'] = $this->Employee_model->GetReportsRoles($this->session->userdata('EmployeeId'));

		$data['AllPurchaseReturnReport'] = $this->PurchaseReport_model->AllPurchaseReturnReport($VendorId,$ProductId,$LocationId,$CategoryId,$ProductGroupId,$BrandId,$StartDate,$EndDate);

		$data['GetSettingInformation'] = $this->Employee_model->GetSettingInformation();
		$data['CustomerNotification'] = $this->Customer_model->GetNotifications();
		$this->load->view('report/purchasereports/view_purchasereturnreport', $data);
	}


	public function PurchaseInvoiceReport()
	{
		$PurchaseId = $this->input->get('PNo');

        
        $data['Roles'] = $this->Employee_model->GetRoles();
        $data['AdministrationRoles'] = $this->Employee_model->GetAdministrationRoles($this->session->userdata('EmployeeId'));
        $data['SalesRoles'] = $this->Employee_model->GetSalesRoles($this->session->userdata('EmployeeId'));
        $data['PurchasesRoles'] = $this->Employee_model->GetPurchasesRoles($this->session->userdata('EmployeeId'));
        $data['RegistrationRoles'] = $this->Employee_model->GetRegistrationRoles($this->session->userdata('EmployeeId'));
        $data['TransactionRoles'] = $this->Employee_model->GetTransactionRoles($this->session->userdata('EmployeeId'));
        $data['ReportsRoles'] = $this->Employee_model->GetReportsRoles($this->session->userdata('EmployeeId'));

		$data['PurchaseInvoiceReport'] = $this->PurchaseReport_model->PurchaseInvoiceReport($PurchaseId);
		$data['PurchaseInvoiceReportDetails'] = $this->PurchaseReport_model->PurchaseInvoiceReportDetails($PurchaseId);

//		echo $this->output->enable_profiler();
		$data['GetSettingInformation'] = $this->Employee_model->GetSettingInformation();
		$data['CustomerNotification'] = $this->Customer_model->GetNotifications();
        $this->load->view('report/purchasereports/view_purchase_invoice_report', $data);
	}

}

?>