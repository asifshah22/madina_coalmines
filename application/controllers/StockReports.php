<?php defined('BASEPATH') OR exit('No direct script access allowed');
class StockReports extends CI_Controller {

	public function __construct()
	{
	    parent::__construct();
	    $this->check_isvalidated();
	    $this->load->model('Product_model');
	    $this->load->model('StockReport_model');
	    $this->load->model('Employee_model');
	    $this->load->model('ProductGroup_model');
	    $this->load->model('Brand_model');
	    $this->load->model('Colour_model');
	    $this->load->model('Location_model');
	    $this->load->model('ProductReport_model');
	    $this->load->model('Category_model');
	    $this->load->model('Customer_model');
	   // $this->output->enable_profiler(true);
	}

	
	private function check_isvalidated()
	{
            if(!$this->session->userdata('EmployeeId'))
            { $this->session->set_userdata('url',  current_url()); redirect('Login'); }
	}
	
	
	function index()
	{
	    $data['AdministrationRoles'] = $this->Employee_model->GetAdministrationRoles($this->session->userdata('EmployeeId'));
	    $data['SalesRoles'] = $this->Employee_model->GetSalesRoles($this->session->userdata('EmployeeId'));
	    $data['PurchasesRoles'] = $this->Employee_model->GetPurchasesRoles($this->session->userdata('EmployeeId'));
	    $data['RegistrationRoles'] = $this->Employee_model->GetRegistrationRoles($this->session->userdata('EmployeeId'));
	    $data['TransactionRoles'] = $this->Employee_model->GetTransactionRoles($this->session->userdata('EmployeeId'));
	    $data['ReportsRoles'] = $this->Employee_model->GetReportsRoles($this->session->userdata('EmployeeId'));

	    $data['GetAllBrands'] = $this->Product_model->GetAllBrands();
	    $data['GetAllProductGroups'] = $this->ProductGroup_model->GetAllProductGroups();
	    $data['AllProducts'] = $this->Product_model->GetAllProducts();
	    $data['CustomerNotification'] = $this->Customer_model->GetNotifications();
	    $this->load->view('report/stockreports/stock_reports', $data);
	}
	
	
	public function StockActivityReportCriteria()
	{
		$ProductGroups = '';
	    $Brands = '';
		$Products = '';
		$AllProducts = $this->Product_model->GetAllProducts();
		$AllProductGroups = $this->ProductGroup_model->GetAllProductGroups();
		$AllBrands = $this->Product_model->GetAllBrands();

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

		$ReportCriteria ='<div style="width:40%; margin-left:190px;" class="box-header with-border">
	    <h3 class="box-title text-light-blue">Report Criteria</h3>
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
			  <button type="button" id="generate_stock_activity_report" class="btn  btn-primary">Show Report</button>
		       </div>                  
	    </div>';
	    echo $ReportCriteria;
	    $this->load->view("includes/footer");

	}


	public function StockBalanceReportCriteria()
	{
		$ProductGroups = '';
	    $Brands = '';
		$Products = '';
		$AllProducts = $this->Product_model->GetAllProducts();
		$AllProductGroups = $this->ProductGroup_model->GetAllProductGroups();
		$AllBrands = $this->Product_model->GetAllBrands();

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

		$ReportCriteria ='<div style="width:40%; margin-left:190px;" class="box-header with-border">
	    <h3 class="box-title text-light-blue">Report Criteria</h3>
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
			  <button type="button" id="generate_stock_balance_report" class="btn  btn-primary">Show Report</button>
		       </div>                  
	    </div>';
	    echo $ReportCriteria;
	    $this->load->view("includes/footer");
	}


	public function AvailableProductPriceReportCriteria()
	{
		$ProductGroups = '';
		$Brands = '';
		$Products = '';
		$AllProducts = $this->Product_model->GetAllProducts();
		$AllProductGroups = $this->ProductGroup_model->GetAllProductGroups();
		$AllBrands = $this->Product_model->GetAllBrands();

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

		$ReportCriteria ='<div style="width:40%; margin-left:190px;" class="box-header with-border">
	    <h3 class="box-title text-light-blue">Report Criteria</h3>
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
		     <label style="width:24%;" for="SalePrice" class="col-sm-1 control-label">Sale Price:</label>
		       <div class="input-group date">
			  <input class="" name="SalePrice" id="SalePrice" type="checkbox" style="" value="" >
		       </div>                  
	    </div>';
		$ReportCriteria .='<div class="form-group">
		     <label style="width:24%;" for="PurchasePrice" class="col-sm-1 control-label">Purchase Price:</label>
		       <div class="input-group date">
			  <input class="" name="PurchasePrice" id="PurchasePrice" type="checkbox" style="" value="" >
		       </div>                  
	    </div>';
		$ReportCriteria .='<div class="form-group">
		     <label style="width:24%;" for="FinalPrice" class="col-sm-1 control-label">Final Price:</label>
		       <div class="input-group date">
			  <input class="" name="FinalPrice" id="FinalPrice" type="checkbox" style="" value="" >
		       </div>                  
	    </div>';
		$ReportCriteria .='<div class="form-group">
		     <label style="width:24%;" for="Specifications" class="col-sm-1 control-label">Specifications:</label>
		       <div class="input-group date">
			  <input class="" name="Specifications" id="Specifications" type="checkbox" style="" value="" >
		       </div>                  
	    </div>';
	    $ReportCriteria .='<div class="form-group">
		     <label style="width:24%;" class="col-sm-2"></label>
		       <div class="input-group date">
			  <button type="button" id="generate_available_product_price_report" class="btn  btn-primary">Show Report</button>
		       </div>                  
	    </div>';
	    echo $ReportCriteria;
	    $this->load->view("includes/footer");
	}


	public function StockTransferReportCriteria()
	{
		$Products = '';
		$Locations = '';
		$Colours = '';
		$Employees = '';
		$AllProducts = $this->Product_model->GetAllProducts();
		$AllLocations = $this->Location_model->GetAllLocation();
		$AllColours = $this->Colour_model->GetAllColours();
		$AllEmployees = $this->Employee_model->GetAllEmployees();

		
 		foreach($AllProducts as  $value)
        {
	       $Products .= '<option value="'.$value["ProductId"].'"> ' .$value['ProductName'].' </option>';
        }

        foreach($AllLocations as  $value)
        {
	       $Locations .= '<option value="'.$value["LocationId"].'"> ' .$value['LocationName'].' </option>';
        }

 		foreach($AllColours as  $value)
        {
	       $Colours .= '<option value="'.$value["ColourId"].'"> ' .$value['ColourName'].' </option>';
        }

 		foreach($AllEmployees as  $value)
        {
	       $Employees .= '<option value="'.$value["EmployeeId"].'"> ' .$value['EmployeeName'].' </option>';
        }

		$ReportCriteria ='<div style="width:40%; margin-left:190px;" class="box-header with-border">
	    <h3 class="box-title text-light-blue">Report Criteria</h3>
	    </div>';
	    $ReportCriteria .='<div class="form-group">
		     <label style="width:24%;" for="Products" class="col-sm-1 control-label">Locations:</label>
		       <div class="input-group date">
			  <select style="width:270px;" class="form-control select2" id="LocationId">
			    <option value="0" selected="selected">All Locations</option>
			    '.$Locations.'
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
		     <label style="width:24%;" for="Products" class="col-sm-1 control-label">Colours:</label>
		       <div class="input-group date">
			  <select style="width:270px;" class="form-control select2" id="ColourId">
			    <option value="0" selected="selected">All Colours</option>
			    '.$Colours.'
			  </select>
		       </div>
	    </div>';
	    $ReportCriteria .='<div class="form-group">
		     <label style="width:24%;" for="Products" class="col-sm-1 control-label">Employees:</label>
		       <div class="input-group date">
			  <select style="width:270px;" class="form-control select2" id="EmployeeId">
			    <option value="0" selected="selected">All Employees</option>
			    '.$Employees.'
			  </select>
		       </div>
	    </div>';
		$ReportCriteria .='<div class="form-group">
		     <label style="width:24%;" for="StartDate" class="col-sm-1 control-label">Start Date:</label>
		       <div class="input-group date">
			  <div class="input-group-addon">
			     <i class="fa fa-calendar"></i>
			  </div>               
			  <input class="form-control" name="StartDate" id="datepicker1" type="text" placeholder="Enter Start Date" style="width:40%;" value="" autocomplete="off">
		       </div>                  
	    </div>';
		$ReportCriteria .='<div class="form-group">
		     <label style="width:24%;" for="StartDate" class="col-sm-1 control-label">End Date:</label>
		       <div class="input-group date">
			  <div class="input-group-addon">
			     <i class="fa fa-calendar"></i>
			  </div>               
			  <input class="form-control" name="EndDate" id="datepicker2" type="text" placeholder="Enter Start Date" style="width:40%;" value="" autocomplete="off">
		       </div>                  
	    </div>';
	    $ReportCriteria .='<div class="form-group">
		     <label style="width:24%;" class="col-sm-2"></label>
		       <div class="input-group date">
			  <button type="button" id="generate_stock_transfer_report" class="btn  btn-primary">Show Report</button>
		       </div>                  
	    </div>';
	    echo $ReportCriteria;
	    $this->load->view("includes/footer");
	}



	public function StockStatusReportCriteria()
	{
		$Products = '';
		$Locations = '';
		$AllProducts = $this->Product_model->GetAllProducts();
		$AllLocations = $this->Location_model->GetAllLocation();
		
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
		     <label style="width:24%;" for="Products" class="col-sm-1 control-label">Locations:</label>
		       <div class="input-group date">
			  <select style="width:270px;" class="form-control select2" id="LocationId">
			    <option value="0" selected="selected">All Locations</option>
			    '.$Locations.'
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
		     <label style="width:24%;" for="StartDate" class="col-sm-1 control-label">As of Date:</label>
		       <div class="input-group date">
			  <div class="input-group-addon">
			     <i class="fa fa-calendar"></i>
			  </div>               
			  <input class="form-control" name="EndDate" id="datepicker2" type="text" placeholder="Enter End Date" style="width:40%;" value="" autocomplete="off">
		       </div>                  
	    </div>';
	    $ReportCriteria .='<div class="form-group">
		     <label style="width:24%;" class="col-sm-2"></label>
		       <div class="input-group date">
			  <button type="button" id="generate_stock_status_report" class="btn  btn-primary">Show Report</button>
		       </div>                  
	    </div>';
	    echo $ReportCriteria;
	    $this->load->view("includes/footer");
	}



	public function ProductReportCriteria()
	{
		$ProductGroups = '';
	    $Brands = '';
		$Products = '';
		$AllProducts = $this->Product_model->GetAllProducts();
		$AllProductGroups = $this->ProductGroup_model->GetAllProductGroups();
		$AllBrands = $this->Product_model->GetAllBrands();

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

		$ReportCriteria ='<div style="width:40%; margin-left:190px;" class="box-header with-border">
	    <h3 class="box-title text-light-blue">Report Criteria</h3>
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
		     <label style="width:24%;" class="col-sm-2"></label>
		       <div class="input-group date">
			  <button type="button" id="generate_product_report" class="btn btn-primary">Show Report</button>
		       </div>                  
	    </div>';
	    echo $ReportCriteria;
	    $this->load->view("includes/footer");
	}








	
	function StockBalanceReport_____OLD()
	{
	    $data['AdministrationRoles'] = $this->Employee_model->GetAdministrationRoles($this->session->userdata('EmployeeId'));
	    $data['SalesRoles'] = $this->Employee_model->GetSalesRoles($this->session->userdata('EmployeeId'));
	    $data['PurchasesRoles'] = $this->Employee_model->GetPurchasesRoles($this->session->userdata('EmployeeId'));
	    $data['RegistrationRoles'] = $this->Employee_model->GetRegistrationRoles($this->session->userdata('EmployeeId'));
	    $data['TransactionRoles'] = $this->Employee_model->GetTransactionRoles($this->session->userdata('EmployeeId'));
	    $data['ReportsRoles'] = $this->Employee_model->GetReportsRoles($this->session->userdata('EmployeeId'));

	    $data['GetAllBrands'] = $this->Product_model->GetAllBrands();
	    $data['GetAllProductGroups'] = $this->ProductGroup_model->GetAllProductGroups();
	    $data['AllProducts'] = $this->Product_model->GetAllProducts();

	    $data['GetSettingInformation'] = $this->Employee_model->GetSettingInformation();
	    $data['CustomerNotification'] = $this->Customer_model->GetNotifications();
	    $this->load->view('report/stockreports/stock_balance_report', $data);
	}
	
	
	
	public function StockBalanceReport()
	{	       
	    $ProductId = $this->input->get('ProductId');
	    $BrandId = $this->input->get('BrandId');
	    $ProductGroupId = $this->input->get('ProductGroupId');
	    $StartDate =date('Y-m-d', strtotime($this->input->get('StartDate')));
	    $EndDate =date('Y-m-d', strtotime($this->input->get('EndDate')));

	    $data['AdministrationRoles'] = $this->Employee_model->GetAdministrationRoles($this->session->userdata('EmployeeId'));
	    $data['SalesRoles'] = $this->Employee_model->GetSalesRoles($this->session->userdata('EmployeeId'));
	    $data['PurchasesRoles'] = $this->Employee_model->GetPurchasesRoles($this->session->userdata('EmployeeId'));
	    $data['RegistrationRoles'] = $this->Employee_model->GetRegistrationRoles($this->session->userdata('EmployeeId'));
	    $data['TransactionRoles'] = $this->Employee_model->GetTransactionRoles($this->session->userdata('EmployeeId'));
	    $data['ReportsRoles'] = $this->Employee_model->GetReportsRoles($this->session->userdata('EmployeeId'));
	   
	    $data['AllProducts'] = $this->Product_model->GetAllProducts($colmun = 'pos_products.ProductId,pos_products.ProductName,pos_productgroup.ProductGroupName,pos_brands.BrandName', $ProductId);
	    $data['AllPurchaseRecord'] = $this->StockReport_model->GetAllPurchaseRecord($StartDate,$EndDate,$ProductId,$ProductGroupId,$BrandId);
	    $data['AllPurchaseReturnRecord'] = $this->StockReport_model->GetAllPurchaseReturnRecord($StartDate,$EndDate,$ProductId,$ProductGroupId,$BrandId);
	    
	    $data['AllSaleRecord'] = $this->StockReport_model->GetAllSaleRecord($StartDate,$EndDate,$ProductId,$ProductGroupId,$BrandId);
	    $data['AllSaleReturnRecord'] = $this->StockReport_model->GetAllSaleReturnRecord($StartDate,$EndDate,$ProductId,$ProductGroupId,$BrandId);

		$data['GetSettingInformation'] = $this->Employee_model->GetSettingInformation();	 
		$data['CustomerNotification'] = $this->Customer_model->GetNotifications();

	    $this->load->view('report/stockreports/view_stockbalance_report', $data);
	}
	
	public function StockDetailWithPriceReport()
	{
	    $ProductId = $this->input->get('ProductId');
	    $BrandId = $this->input->get('BrandId');
	    $ProductGroupId = $this->input->get('ProductGroupId');
	    $StartDate =date('Y-m-d', strtotime($this->input->get('StartDate')));
	    $EndDate =date('Y-m-d', strtotime($this->input->get('EndDate')));
		
	    $SalePrice = $this->input->get('SalePrice');
	    $PurchasePrice = $this->input->get('1PurchasePrice');
	    $FinalPrice = $this->input->get('FinalPrice');
	    $Specifications = $this->input->get('Specifications');

	    $data['AdministrationRoles'] = $this->Employee_model->GetAdministrationRoles($this->session->userdata('EmployeeId'));
	    $data['SalesRoles'] = $this->Employee_model->GetSalesRoles($this->session->userdata('EmployeeId'));
	    $data['PurchasesRoles'] = $this->Employee_model->GetPurchasesRoles($this->session->userdata('EmployeeId'));
	    $data['RegistrationRoles'] = $this->Employee_model->GetRegistrationRoles($this->session->userdata('EmployeeId'));
	    $data['TransactionRoles'] = $this->Employee_model->GetTransactionRoles($this->session->userdata('EmployeeId'));
	    $data['ReportsRoles'] = $this->Employee_model->GetReportsRoles($this->session->userdata('EmployeeId'));
	   
	    $data['AllProducts'] = $this->Product_model->GetAllProducts($colmun = 'pos_products.ProductId,pos_products.ProductName,pos_productgroup.ProductGroupName,pos_brands.BrandName', $ProductId);
	    $data['AllPurchaseRecord'] = $this->StockReport_model->GetAllPurchaseRecord($StartDate,$EndDate,$ProductId,$ProductGroupId,$BrandId);
	    $data['AllPurchaseReturnRecord'] = $this->StockReport_model->GetAllPurchaseReturnRecord($StartDate,$EndDate,$ProductId,$ProductGroupId,$BrandId);
	    
	    $data['AllSaleRecord'] = $this->StockReport_model->GetAllSaleRecord($StartDate,$EndDate,$ProductId,$ProductGroupId,$BrandId);
	    $data['AllSaleReturnRecord'] = $this->StockReport_model->GetAllSaleReturnRecord($StartDate,$EndDate,$ProductId,$ProductGroupId,$BrandId);

		$data['GetSettingInformation'] = $this->Employee_model->GetSettingInformation();	
		$data['CustomerNotification'] = $this->Customer_model->GetNotifications();

	    $this->load->view('report/stockreports/view_availableprouductprice_report', $data);
	}

 
	public function StockQuantityReport()
	{
	    $ProductId = $this->input->get('ProductId');
	    $BrandId = $this->input->get('BrandId');
	    $ProductGroupId = $this->input->get('ProductGroupId');
	    $StartDate =date('Y-m-d', strtotime($this->input->get('StartDate')));
	    $EndDate =date('Y-m-d', strtotime($this->input->get('EndDate')));

	    $data['AdministrationRoles'] = $this->Employee_model->GetAdministrationRoles($this->session->userdata('EmployeeId'));
	    $data['SalesRoles'] = $this->Employee_model->GetSalesRoles($this->session->userdata('EmployeeId'));
	    $data['PurchasesRoles'] = $this->Employee_model->GetPurchasesRoles($this->session->userdata('EmployeeId'));
	    $data['RegistrationRoles'] = $this->Employee_model->GetRegistrationRoles($this->session->userdata('EmployeeId'));
	    $data['TransactionRoles'] = $this->Employee_model->GetTransactionRoles($this->session->userdata('EmployeeId'));
	    $data['ReportsRoles'] = $this->Employee_model->GetReportsRoles($this->session->userdata('EmployeeId'));
	   
	    $data['AllProducts'] = $this->Product_model->GetAllProducts($colmun = 'pos_products.ProductId,pos_products.ProductName,pos_productgroup.ProductGroupName,pos_brands.BrandName', $ProductId);
	    $data['AllPurchaseRecord'] = $this->StockReport_model->GetAllPurchaseRecord($StartDate,$EndDate,$ProductId,$ProductGroupId,$BrandId);
	    $data['AllPurchaseReturnRecord'] = $this->StockReport_model->GetAllPurchaseReturnRecord($StartDate,$EndDate,$ProductId,$ProductGroupId,$BrandId);
	    
	    $data['AllSaleRecord'] = $this->StockReport_model->GetAllSaleRecord($StartDate,$EndDate,$ProductId,$ProductGroupId,$BrandId);
	    $data['AllSaleReturnRecord'] = $this->StockReport_model->GetAllSaleReturnRecord($StartDate,$EndDate,$ProductId,$ProductGroupId,$BrandId);
	    

		$data['GetSettingInformation'] = $this->Employee_model->GetSettingInformation();
		$data['CustomerNotification'] = $this->Customer_model->GetNotifications();
	    $this->load->view('report/stockreports/view_stockquantity_report', $data);
	}


    public function StockStatusReport()
    { 
        $LocationId = $this->input->get('LocationId');
        $ProductId = $this->input->get('ProductId');
        $EDate = $this->input->get('EndDate');

        $UptoDate = date("Y-m-d", strtotime($EDate));

        $data['AdministrationRoles'] = $this->Employee_model->GetAdministrationRoles($this->session->userdata('EmployeeId'));
        $data['SalesRoles'] = $this->Employee_model->GetSalesRoles($this->session->userdata('EmployeeId'));
        $data['PurchasesRoles'] = $this->Employee_model->GetPurchasesRoles($this->session->userdata('EmployeeId'));
        $data['RegistrationRoles'] = $this->Employee_model->GetRegistrationRoles($this->session->userdata('EmployeeId'));
        $data['TransactionRoles'] = $this->Employee_model->GetTransactionRoles($this->session->userdata('EmployeeId'));
        $data['ReportsRoles'] = $this->Employee_model->GetReportsRoles($this->session->userdata('EmployeeId'));
	
	$data['AllProducts'] = $this->Product_model->GetAllProducts('pos_products.ProductId, pos_products.ProductName',$ProductId);
	$data['AllLocations'] = $this->Location_model->GetAllLocation($LocationId);
	$data['AllColours'] = $this->Colour_model->GetAllColours($LocationId);
	
	$data['ProductWiseStock'] = $this->ProductReport_model->GetProductStocks($UptoDate,$ProductId);
	$data['ColourWiseStock'] = $this->ProductReport_model->GetColourStocks($UptoDate,$ProductId);
	
	
	if($LocationId == 0)
	{ $data['ProductsTransferFrom'] = $this->ProductReport_model->GetProductTransferRecord($UptoDate,$LocationId,$ProductId); }
	else { $data['ProductsTransferFrom'] = $this->ProductReport_model->GetProductTransferFromRecord($UptoDate,$LocationId,$ProductId); }
	
	
	$data['ProductsTransfer'] = $this->ProductReport_model->GetProductTransferRecord($UptoDate,$LocationId,$ProductId);
	
	$data['LocationWiseStockPurchase'] = $this->ProductReport_model->GetLocationWiseStockPurchase($UptoDate,$LocationId,$ProductId);
	$data['LocationWiseStockPurchaseReturn'] = $this->ProductReport_model->GetLocationWiseStockPurchaseReturn($UptoDate,$LocationId,$ProductId);
	
	$data['LocationWiseStockSale'] = $this->ProductReport_model->GetLocationWiseStockSale($UptoDate,$LocationId,$ProductId);
	$data['LocationWiseStockSaleReturn'] = $this->ProductReport_model->GetLocationWiseStockSaleReturn($UptoDate,$LocationId,$ProductId);

	$data['GetSettingInformation'] = $this->Employee_model->GetSettingInformation();
	$data['CustomerNotification'] = $this->Customer_model->GetNotifications();

//	echo $this->output->enable_profiler();

/*	echo "<pre>";
	print_r($data['LocationWiseStockSaleReturn']);
	die;*/
	$this->load->view('report/stockreports/view_stockstatus_report',$data);
    }


        public function StockTransferReport()
    {
	    $LocationId = $this->input->get('LocationId');
	    $ProductId = $this->input->get('ProductId');
	    $ColourId = $this->input->get('ColourId');
	    $EmployeeId = $this->input->get('EmployeeId');
	    $StartDate = $this->input->get('StartDate');
	    $EndDate = $this->input->get('EndDate');

	    $data['AdministrationRoles'] = $this->Employee_model->GetAdministrationRoles($this->session->userdata('EmployeeId'));
	    $data['SalesRoles'] = $this->Employee_model->GetSalesRoles($this->session->userdata('EmployeeId'));
	    $data['PurchasesRoles'] = $this->Employee_model->GetPurchasesRoles($this->session->userdata('EmployeeId'));
	    $data['RegistrationRoles'] = $this->Employee_model->GetRegistrationRoles($this->session->userdata('EmployeeId'));
	    $data['TransactionRoles'] = $this->Employee_model->GetTransactionRoles($this->session->userdata('EmployeeId'));
	    $data['ReportsRoles'] = $this->Employee_model->GetReportsRoles($this->session->userdata('EmployeeId'));
	   
//	    $data['AllProducts'] = $this->Product_model->GetAllProducts($colmun = 'pos_products.ProductId,pos_products.ProductName,pos_productgroup.ProductGroupName,pos_brands.BrandName', $ProductId);
	    $data['AllStockLocationFrom'] = $this->StockReport_model->AllStockLocationFrom($LocationId);
	    $data['AllStockTransferRecord'] = $this->StockReport_model->AllStockTransferRecord($LocationId,$ProductId,$ColourId,$EmployeeId,$StartDate,$EndDate);
		$data['GetSettingInformation'] = $this->Employee_model->GetSettingInformation();
		$data['CustomerNotification'] = $this->Customer_model->GetNotifications();
	$this->load->view('report/stockreports/view_stocktransfer_report',$data);
    }


    public function ProductReport()
    {
	    $ProductId = $this->input->get('ProductId');
	    $BrandId = $this->input->get('BrandId');
	    $ProductGroupId = $this->input->get('ProductGroupId');

	    $data['GetSettingInformation'] = $this->Employee_model->GetSettingInformation();
	    $data['GetProductReport'] = $this->ProductReport_model->GetProductReport($ProductId,$BrandId,$ProductGroupId);
	    $data['CustomerNotification'] = $this->Customer_model->GetNotifications();
	    $this->load->view('report/stockreports/view_product_report',$data);
    }
    
    public function StockStatusDetailCriteria()
	{
		$ProductGroups = '';
		$Brands = '';
		$Products = '';
		$AllCategories = $this->Product_model->GetAllCategories();
		$AllProductGroups = $this->ProductGroup_model->GetAllProductGroups();
		$AllBrands = $this->Product_model->GetAllBrands();

	    foreach($AllProductGroups as  $value)
        {
	       $ProductGroups .= '<option value="'.$value["ProductGroupId"].'"> ' .$value['ProductGroupName'].' </option>';
        }

	    foreach($AllBrands as  $value)
        {
	       $Brands .= '<option value="'.$value["BrandId"].'"> ' .$value['BrandName'].' </option>';
        }

 		foreach($AllCategories as  $value)
        {
	       $Products .= '<option value="'.$value["CategoryId"].'"> ' .$value['CategoryName'].' </option>';
        }

		$ReportCriteria ='<div style="width:40%; margin-left:190px;" class="box-header with-border">
	    <h3 class="box-title text-light-blue">Report Criteria</h3>
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
		     <label style="width:24%;" for="Products" class="col-sm-1 control-label">Categories:</label>
		       <div class="input-group date">
			  <select style="width:270px;" class="form-control select2" id="CategoryId">
			    <option value="0" selected="selected">All Categories</option>
			    '.$Products.'
			  </select>
		       </div>
	    </div>';
	    $ReportCriteria .='<div class="form-group">
		     <label style="width:24%;" for="Products" class="col-sm-1 control-label">Stock Value:</label>
		       <div class="input-group date">
			  <select style="width:270px;" class="form-control select2" id="StockValue">
			    <option value="all" selected="selected">ALL</option>
				<option value="selected">SELECTED</option>
			  </select>
		       </div>
	    </div>';
	    $ReportCriteria .='<div class="form-group">
		     <label style="width:24%;" class="col-sm-2"></label>
		       <div class="input-group date">
			  <button type="button" id="generate_stock_status_detail" class="btn  btn-primary">Show Report</button>
		       </div>                  
	    </div>';
	    echo $ReportCriteria;
	    $this->load->view("includes/footer");
	}

	public function StockStatusDetailReport()
    {
	    $CategoryId = $this->input->get('CategoryId');
	    $BrandId = $this->input->get('BrandId');
	    $ProductGroupId = $this->input->get('ProductGroupId');
	    $StartDate = "1971-01-01";
	    $EndDate = date('Y-m-d');

	    $data['AdministrationRoles'] = $this->Employee_model->GetAdministrationRoles($this->session->userdata('EmployeeId'));
	    $data['SalesRoles'] = $this->Employee_model->GetSalesRoles($this->session->userdata('EmployeeId'));
	    $data['PurchasesRoles'] = $this->Employee_model->GetPurchasesRoles($this->session->userdata('EmployeeId'));
	    $data['RegistrationRoles'] = $this->Employee_model->GetRegistrationRoles($this->session->userdata('EmployeeId'));
	    $data['TransactionRoles'] = $this->Employee_model->GetTransactionRoles($this->session->userdata('EmployeeId'));
	    $data['ReportsRoles'] = $this->Employee_model->GetReportsRoles($this->session->userdata('EmployeeId'));
	   
	    $data['AllProducts']   = $this->Product_model->GetProducts($StartDate,$EndDate,$CategoryId,$ProductGroupId,$BrandId);
		$data['ProductsPrice'] = $this->Product_model->GetProductsPrice($StartDate,$EndDate,$CategoryId,$ProductGroupId,$BrandId);
		$data['AllPurchaseReturnRecord'] = $this->StockReport_model->GetPurchaseReturnRecord($StartDate,$EndDate,$CategoryId,$ProductGroupId,$BrandId);
	    $data['AllSaleRecord'] = $this->StockReport_model->GetSaleRecord($StartDate,$EndDate,$CategoryId,$ProductGroupId,$BrandId);
		$data['GetCategory'] = $this->Category_model->GetCategoryById($CategoryId);
		$data['StockValue']  = $this->input->get('StockValue');
		$data['GetSettingInformation'] = $this->Employee_model->GetSettingInformation();
		$data['CustomerNotification'] = $this->Customer_model->GetNotifications();
	    $this->load->view('report/stockreports/view_stock_status_detail',$data);
    }


}
?>