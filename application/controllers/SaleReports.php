<?php defined('BASEPATH') OR exit('No direct script access allowed');

class SaleReports extends CI_Controller {

	public function __construct()
	{
	    parent::__construct();
        $this->check_isvalidated();
	    $this->load->model('Customer_model');
	    $this->load->model('Reference_model');
	    $this->load->model('Product_model');
	    $this->load->model('Category_model');
	    $this->load->model('ProductGroup_model');
	    $this->load->model('Sale_model');
	    $this->load->model('SaleReport_model');
	    $this->load->model('SaleReturnReport_model');
	    $this->load->model('Employee_model');
	    $this->load->model('Location_model');
	    $this->load->model('Reference_model');
	    $this->load->model('GeneralJournal_model');
	    $this->load->model('AccountReport_model');
	    $this->load->model('Quotation_model');
		$this->load->model('Saleman_model');
		$this->load->model('Purchase_model');
		$this->load->model('Setting_model');
		
//            $this->output->enable_profiler();
	}
	
	
	private function check_isvalidated()
	{
        // if(!$this->session->userdata('EmployeeId') || $this->session->userdata('EmployeeType') == 3)
        // { 
        //     $this->session->set_userdata('url',  current_url());
        //     redirect("Login"); 
        // }
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
        $data['AllReferences']=$this->Reference_model->GetAllReference();
        $data['CustomerNotification'] = $this->Customer_model->GetNotifications();
	    $this->load->view('report/salereports/sale_reports', $data);
	}


	function SaleDetailReportCriteria()
    {
        
	    $StartDate = date("m/d/Y");
	    $Products = '';
	    $Customers = '';
	    $References = '';
	    $Categories = '';
	    $ProductGroups = '';
	    $Brands = '';
	    $Locations = '';
		$Salemans = '';
	   
        $AllCustomers = $this->Customer_model->GetAllCustomers();
		$AllReferences = $this->Reference_model->GetAllReference();
		$AllCategories = $this->Category_model->GetAllCategories();
		$AllProductGroups = $this->ProductGroup_model->GetAllProductGroups();
		$AllBrands = $this->Product_model->GetAllBrands();
	    $AllProducts = $this->Product_model->GetAllProducts();
	    $AllLocations = $this->Location_model->GetAllLocation();
		$AllSaleman = $this->Saleman_model->GetAllCategories();
	    
	    foreach($AllCustomers as  $value)
        {
	       $Customers .= '<option value="'.$value["CustomerId"].'">'.$value['CustomerName'].'</option>';
        }

		foreach($AllSaleman as  $value)
        {
	       $Salemans .= '<option value="'.$value["SalemanId"].'">'.$value['SalemanName'].'</option>';
        }

	    foreach($AllReferences as  $value)
        {
	       $References .= '<option value="'.$value["ReferenceId"].'">'.$value['FullName'].'</option>';
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
		     <label style="width:24%;" for="Customers" class="col-sm-1 control-label">Customers:</label>
		       <div class="input-group date">
			  <select style="width:270px;" class="form-control select2" id="CustomerId">
			    <option value="0" selected="selected">All Customers</option>
			    '.$Customers.'
			  </select>
		       </div>
	    </div>';
		$ReportCriteria .='<div class="form-group">
		     <label style="width:24%;" for="Customers" class="col-sm-1 control-label">Saleman:</label>
		       <div class="input-group date">
			  <select style="width:270px;" class="form-control select2" id="SalemanId">
			    <option value="0" selected="selected">All Saleman</option>
			    '.$Salemans.'
			  </select>
		       </div>
	    </div>';
	    $ReportCriteria .='<div class="form-group">
		     <label style="width:24%;" for="Counters" class="col-sm-1 control-label">Select Counter:</label>
		       <div class="input-group date">
			  <select style="width:270px;" class="form-control select2" id="Counter">
			    <option value="0" selected="selected">All Counters</option>
				<option value="1">Counter One</option>
				<option value="2">Counter Two</option>
				<option value="3">Counter Three</option>
			  </select>
		       </div>
	    </div>';
	    $ReportCriteria .='<div class="form-group">
		     <label style="width:24%;" for="References" class="col-sm-1 control-label">Transportation:</label>
		       <div class="input-group date">
			  <select style="width:270px;" class="form-control select2" id="ReferenceId">
			    <option value="0" selected="selected">All Transportation</option>
			    '.$References.'
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
		     <label style="width:24%;" for="SaleType" class="col-sm-1 control-label">Sale Type:</label>
		       <div class="input-group date">
			  <select style="width:270px;" class="form-control select2" id="SaleType">
			    <option value="0" selected="selected">Sale Type</option>
			    <option value="1">Cash</option>
			    <option value="2">Credit</option>
			    <option value="3">Online</option>
			  </select>
		       </div>
	    </div>';
	    $ReportCriteria .='<div class="form-group">
		     <label style="width:24%;" for="SaleMethod" class="col-sm-1 control-label">Sale Method:</label>
		       <div class="input-group date">
			  <select style="width:270px;" class="form-control select2" id="SaleMethod">
			    <option value="0" selected="selected">Sale Method</option>
			    <option value="Wholesale">Wholesale</option>
			    <option value="Retail">Retail</option>
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
			  <button type="button" id="generate_sale_detail_report" class="btn  btn-primary">Show Report</button>
		       </div>                  
	    </div>';
	    echo $ReportCriteria;
	    $this->load->view("includes/footer");
	}	


	function SaleReturnReportCriteria()
    {
        
	    $StartDate = date("m/d/Y");
	    $Products = '';
	    $Customers = '';
	    $References = '';
	    $Categories = '';
	    $ProductGroups = '';
	    $Brands = '';
	    $Locations = '';
	   
        $AllCustomers = $this->Customer_model->GetAllCustomers();
		$AllReferences = $this->Reference_model->GetAllReference();
		$AllCategories = $this->Category_model->GetAllCategories();
		$AllProductGroups = $this->ProductGroup_model->GetAllProductGroups();
		$AllBrands = $this->Product_model->GetAllBrands();
	    $AllProducts = $this->Product_model->GetAllProducts();
	    $AllLocations = $this->Location_model->GetAllLocation();
	    
	    foreach($AllCustomers as  $value)
        {
	       $Customers .= '<option value="'.$value["CustomerId"].'">'.$value['CustomerName'].'</option>';
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
		     <label style="width:24%;" for="Customers" class="col-sm-1 control-label">Customers:</label>
		       <div class="input-group date">
			  <select style="width:270px;" class="form-control select2" id="CustomerId">
			    <option value="0" selected="selected">All Customers</option>
			    '.$Customers.'
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
			  <input class="form-control" name="SaleDate" id="datepicker2" type="text" placeholder="Enter End Date" style="width:40%;" value="" autocomplete="off">
		       </div>                  
	    </div>';
	    $ReportCriteria .='<div class="form-group">
		     <label style="width:24%;" class="col-sm-2"></label>
		       <div class="input-group date">
			  <button type="button" id="generate_sale_return_report" class="btn  btn-primary">Show Report</button>
		       </div>                  
	    </div>';
	    echo $ReportCriteria;
	    $this->load->view("includes/footer");
	}	
	

	public function SaleReport()
	{
		$data['GetAllBrands'] = $this->Product_model->GetAllBrands();
		$data['GetAllCategories'] = $this->Product_model->GetAllCategories();
		$data['GetAllProductGroups'] = $this->ProductGroup_model->GetAllProductGroups();
		$data['GetAllLocation'] = $this->Location_model->GetAllLocation();
		$data['GetAllColours'] = $this->Product_model->GetAllColours();
	    $data['GetAllCustomer'] = $this->Customer_model->GetAllCustomers();
	    $data['GetAllProducts'] = $this->Product_model->GetAllProducts();
	    $data['AllReferences']=$this->Reference_model->GetAllReference();
	    $data['AllSalesReport'] = $this->SaleReport_model->GetAllSales();
    	$data['GetAllFieldOfficers'] = $this->Employee_model->GetAllEmployees();

    	$data['GetSettingInformation'] = $this->Employee_model->GetSettingInformation();
    	$data['CustomerNotification'] = $this->Customer_model->GetNotifications();
      	$this->load->view('report/salereports/sale_report', $data);
	}
	
	public function SaleDetailReport()
	{
        $CustomerId = $this->input->get('CustomerId');
		$SalemanId = $this->input->get('SalemanId');
        $Counter = $this->input->get('Counter');
        $ReferenceId = $this->input->get('ReferenceId');
        $ProductId = $this->input->get('ProductId');
        $LocationId = $this->input->get('LocationId');
        $SaleType = $this->input->get('SaleType');
        $SaleMethod = $this->input->get('SaleMethod');
        $ColourId = $this->input->get('ColourId');
        $CategoryId = $this->input->get('CategoryId');
        $ProductGroupId = $this->input->get('ProductGroupId');
        $BrandId = $this->input->get('BrandId');
        $SDate = $this->input->get('StartDate');
        $EDate = $this->input->get('EndDate');

        $StartDate = date("Y-m-d", strtotime($SDate));
        $EndDate = date("Y-m-d", strtotime($EDate));
        
        $data['Roles'] = $this->Employee_model->GetRoles();
        $data['AdministrationRoles'] = $this->Employee_model->GetAdministrationRoles($this->session->userdata('EmployeeId'));
        $data['SalesRoles'] = $this->Employee_model->GetSalesRoles($this->session->userdata('EmployeeId'));
        $data['PurchasesRoles'] = $this->Employee_model->GetPurchasesRoles($this->session->userdata('EmployeeId'));
        $data['RegistrationRoles'] = $this->Employee_model->GetRegistrationRoles($this->session->userdata('EmployeeId'));
        $data['TransactionRoles'] = $this->Employee_model->GetTransactionRoles($this->session->userdata('EmployeeId'));
        $data['ReportsRoles'] = $this->Employee_model->GetReportsRoles($this->session->userdata('EmployeeId'));

	    $data['AllSales'] = $this->SaleReport_model->AllSales($CustomerId,$SalemanId,$ReferenceId,$ProductId,$LocationId,$SaleType,$SaleMethod,$ColourId,$CategoryId,$ProductGroupId,$BrandId,$StartDate,$EndDate,$Counter);
        $data['GetAveragePrice'] = $this->Purchase_model->GetAveragePrice();
        // print_r($data['AllSales'] ); die();
//		echo $this->output->enable_profiler();
    	$data['GetSettingInformation'] = $this->Employee_model->GetSettingInformation();
    	$data['CustomerNotification'] = $this->Customer_model->GetNotifications();
        $this->load->view('report/salereports/view_salereport', $data);
	}

	public function SaleReturnReport()
	{
		$data['GetAllBrands'] = $this->Product_model->GetAllBrands();
		$data['GetAllCategories'] = $this->Product_model->GetAllCategories();
		$data['GetAllProductGroups'] = $this->ProductGroup_model->GetAllProductGroups();
		$data['GetAllLocation'] = $this->Location_model->GetAllLocation();
		$data['GetAllColours'] = $this->Product_model->GetAllColours();
	    $data['GetAllCustomer'] = $this->Customer_model->GetAllCustomers();
	    $data['GetAllProducts'] = $this->Product_model->GetAllProducts();
	    $data['AllSalesReport'] = $this->SaleReport_model->GetAllSales();
    	$data['GetAllFieldOfficers'] = $this->Employee_model->GetAllEmployees();

    	$data['GetSettingInformation'] = $this->Employee_model->GetSettingInformation();
    	$data['CustomerNotification'] = $this->Customer_model->GetNotifications();
      	$this->load->view('report/salereports/salereturn_report', $data);
	}

	public function ViewSaleReturnReport()
	{
        $CustomerId = $this->input->get('CustomerId');
        $ProductId = $this->input->get('ProductId');
        $LocationId = $this->input->get('LocationId');
        $ColourId = $this->input->get('ColourId');
        $CategoryId = $this->input->get('CategoryId');
        $ProductGroupId = $this->input->get('ProductGroupId');
        $BrandId = $this->input->get('BrandId');

        $SDate = $this->input->get('StartDate');
        $EDate = $this->input->get('EndDate');

        $StartDate = date("Y-m-d", strtotime($SDate));
        $EndDate = date("Y-m-d", strtotime($EDate));

        $data['Roles'] = $this->Employee_model->GetRoles();
        $data['AdministrationRoles'] = $this->Employee_model->GetAdministrationRoles($this->session->userdata('EmployeeId'));
        $data['SalesRoles'] = $this->Employee_model->GetSalesRoles($this->session->userdata('EmployeeId'));
        $data['PurchasesRoles'] = $this->Employee_model->GetPurchasesRoles($this->session->userdata('EmployeeId'));
        $data['RegistrationRoles'] = $this->Employee_model->GetRegistrationRoles($this->session->userdata('EmployeeId'));
        $data['TransactionRoles'] = $this->Employee_model->GetTransactionRoles($this->session->userdata('EmployeeId'));
        $data['ReportsRoles'] = $this->Employee_model->GetReportsRoles($this->session->userdata('EmployeeId'));

		$data['AllSalesReturn'] = $this->SaleReport_model->AllSalesReturn($CustomerId,$ProductId,$LocationId,$ColourId,$CategoryId,$ProductGroupId,$BrandId,$StartDate,$EndDate);
		
		$data['GetSettingInformation'] = $this->Employee_model->GetSettingInformation();
		$data['CustomerNotification'] = $this->Customer_model->GetNotifications();
		$this->load->view('report/salereports/view_salereturnreport', $data);
	}

	public function SalesInvoiceDetailReportCriteria()
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
		     <label style="width:24%;" for="Locations" class="col-sm-1 control-label">With Customer Ledger Summary:</label>
		       <div class="input-group date">
			   <input type="checkbox" class="cbCheck" id="ledger" name="ledger" value="1" />
		       </div>
	    </div>';
	    $ReportCriteria .='<div class="form-group">
		     <label style="width:24%;" class="col-sm-2"></label>
		       <div class="input-group date">
			  <button type="button" id="generate_sale_invoice_report" class="btn  btn-primary">Show Report</button>
		       </div>                  
	    </div>';
	    echo $ReportCriteria;
	    $this->load->view("includes/footer");

	}


	public function SaleInvoiceReport()
	{
		$data['GetAllBrands'] = $this->Product_model->GetAllBrands();
		$data['GetAllCategories'] = $this->Product_model->GetAllCategories();
		$data['GetAllProductGroups'] = $this->ProductGroup_model->GetAllProductGroups();
		$data['GetAllLocation'] = $this->Location_model->GetAllLocation();
		$data['GetAllColours'] = $this->Product_model->GetAllColours();
	    $data['GetAllCustomer'] = $this->Customer_model->GetAllCustomers();
	    $data['AllReferences']=$this->Reference_model->GetAllReference();
	    $data['GetAllProducts'] = $this->Product_model->GetAllProducts();
	    $data['AllSalesReport'] = $this->SaleReport_model->GetAllSales();
    	$data['GetAllFieldOfficers'] = $this->Employee_model->GetAllEmployees();

    	$data['GetSettingInformation'] = $this->Employee_model->GetSettingInformation();
    	$data['CustomerNotification'] = $this->Customer_model->GetNotifications();
      	$this->load->view('report/salereports/sale_invoice_report', $data);
	}
	
	
		public function ViewSaleReturnInvoiceReport()
	{
	    


        $InvoiceNo = $this->input->get('InvoiceNo');
        $Ledger = $this->input->get('ledger');
		$StartDate = "1971-01-01";
		$EndDate   = "2071-12-30";

        $data['Roles'] = $this->Employee_model->GetRoles();
        $data['AdministrationRoles'] = $this->Employee_model->GetAdministrationRoles($this->session->userdata('EmployeeId'));
        $data['SalesRoles'] = $this->Employee_model->GetSalesRoles($this->session->userdata('EmployeeId'));
        $data['PurchasesRoles'] = $this->Employee_model->GetPurchasesRoles($this->session->userdata('EmployeeId'));
        $data['RegistrationRoles'] = $this->Employee_model->GetRegistrationRoles($this->session->userdata('EmployeeId'));
        $data['TransactionRoles'] = $this->Employee_model->GetTransactionRoles($this->session->userdata('EmployeeId'));
        $data['ReportsRoles'] = $this->Employee_model->GetReportsRoles($this->session->userdata('EmployeeId'));

		$data['SaleInvoiceReport'] = $this->SaleReport_model->SaleReturnInvoiceReport($InvoiceNo);
		$data['CashDetail'] = $this->Sale_model->GetCashDetails($InvoiceNo);

		// get balance amount
		$SaleInvoiceReport = (array) $data['SaleInvoiceReport'];
		$data['SaleInvoices'] = $this->Sale_model->GetLastSalesReturn($InvoiceNo, $SaleInvoiceReport['CustomerId']);

		
		// get sale count
		$data['InvoiceCount'] = count($this->SaleReport_model->GetAllSalesByCustomer($SaleInvoiceReport['CustomerId']));

		//get received cash amount
		$data['GetJournalId'] = $this->GeneralJournal_model->GetGeneralJournalBySaleId($SaleInvoiceReport['SaleReturnId']);
		$journalId = (array) $data['GetJournalId'];
		$data['ReceivedCashAmount']	= ($SaleInvoiceReport['SaleReturnType'] == 2) ? (($journalId) ? $this->GeneralJournal_model->GetGeneralJournal($journalId['GeneralJournalId']) : null) : 0;
		$data['SaleInvoiceReportDetails'] = $this->SaleReport_model->SaleRetunInvoiceReportDetails($InvoiceNo);
		
		$data['GetSettingInformation'] = $this->Employee_model->GetSettingInformation();

		// get all sales by customer
		$data['AllSales'] = $this->Sale_model->GetSalesByCustomer($SaleInvoiceReport['CustomerId']);
		$allSales = (array) $data['AllSales'];
		$previousBalance = 0;
		foreach($allSales as $sale){
			if($sale['SaleId'] == $InvoiceNo){
				continue;
			}
			$previousBalance += $sale['PreviousBalance'];
		}
		$data['LastBalance'] = $previousBalance;
		// get account receivable amount
		$data['LedgerReport']    = $this->AccountReport_model->LedgerReport($StartDate,$EndDate,1,3,$SaleInvoiceReport['ChartOfAccountId']);
	    $data['SubLedgerReport'] = $this->AccountReport_model->SubLedgerReport($StartDate,$EndDate,1,3,$SaleInvoiceReport['ChartOfAccountId']);
	    $data['OpenningBalance'] = $this->AccountReport_model->GetOpenningBalance($StartDate,$EndDate,1,3,$SaleInvoiceReport['ChartOfAccountId']);
	    
	    //get last transactions
		$ChartOfAccountId = $this->Customer_model->GetCustomer($SaleInvoiceReport['CustomerId']);
		$data['isLedger'] 	  = $Ledger;
		$data['LedgerReport'] = $this->AccountReport_model->CustomerLedgerReport($StartDate,$EndDate,1,3,$ChartOfAccountId->ChartOfAccountId);
	    $data['SubLedgerReport'] = $this->AccountReport_model->CustomerSubLedgerReport($StartDate,$EndDate,1,3,$ChartOfAccountId->ChartOfAccountId, "invoice");
	    $data['OpenningBalance'] = $this->AccountReport_model->GetCustomerOpenningBalance($StartDate,$EndDate,1,3,$ChartOfAccountId->ChartOfAccountId, "invoice");

		// get all cash received vouchers.
		$ChartOfAccountId = $this->Customer_model->GetCustomerChartOfAccountId($SaleInvoiceReport['CustomerId']); 
		$data['CashVoucherAmount'] = $this->AccountReceivableAmount($ChartOfAccountId[0]['ChartOfAccountId']);
		
		$data['Settings'] = $this->Setting_model->GetSetting(1);
		
// 		print_r($data['Settings']->signature); die();
		// echo $SaleInvoiceReport['ChartOfAccountId']; exit;
	    $data['CustomerNotification'] = $this->Customer_model->GetNotifications();
	    

        $this->load->view('report/salereports/view_sale_return_invoice_report', $data);
	}
	public function ViewSaleInvoiceReport()
	{
	    


        $InvoiceNo = $this->input->get('InvoiceNo');
        $Ledger = $this->input->get('ledger');
		$StartDate = "1971-01-01";
		$EndDate   = "2071-12-30";

        $data['Roles'] = $this->Employee_model->GetRoles();
        $data['AdministrationRoles'] = $this->Employee_model->GetAdministrationRoles($this->session->userdata('EmployeeId'));
        $data['SalesRoles'] = $this->Employee_model->GetSalesRoles($this->session->userdata('EmployeeId'));
        $data['PurchasesRoles'] = $this->Employee_model->GetPurchasesRoles($this->session->userdata('EmployeeId'));
        $data['RegistrationRoles'] = $this->Employee_model->GetRegistrationRoles($this->session->userdata('EmployeeId'));
        $data['TransactionRoles'] = $this->Employee_model->GetTransactionRoles($this->session->userdata('EmployeeId'));
        $data['ReportsRoles'] = $this->Employee_model->GetReportsRoles($this->session->userdata('EmployeeId'));

		$data['SaleInvoiceReport'] = $this->SaleReport_model->SaleInvoiceReport($InvoiceNo);
		$data['CashDetail'] = $this->Sale_model->GetCashDetails($InvoiceNo);

		// get balance amount
		$SaleInvoiceReport = (array) $data['SaleInvoiceReport'];
		$data['SaleInvoices'] = $this->Sale_model->GetLastSales($InvoiceNo, $SaleInvoiceReport['CustomerId']);

		
		// get sale count
		$data['InvoiceCount'] = count($this->SaleReport_model->GetAllSalesByCustomer($SaleInvoiceReport['CustomerId']));

		//get received cash amount
		$data['GetJournalId'] = $this->GeneralJournal_model->GetGeneralJournalBySaleId($SaleInvoiceReport['SaleId']);
		$journalId = (array) $data['GetJournalId'];
		$data['ReceivedCashAmount']	= ($SaleInvoiceReport['SaleType'] == 2) ? (($journalId) ? $this->GeneralJournal_model->GetGeneralJournal($journalId['GeneralJournalId']) : null) : 0;
		$data['SaleInvoiceReportDetails'] = $this->SaleReport_model->SaleInvoiceReportDetails($InvoiceNo);
		
		$data['GetSettingInformation'] = $this->Employee_model->GetSettingInformation();

		// get all sales by customer
		$data['AllSales'] = $this->Sale_model->GetSalesByCustomer($SaleInvoiceReport['CustomerId']);
		$allSales = (array) $data['AllSales'];
		$previousBalance = 0;
		foreach($allSales as $sale){
			if($sale['SaleId'] == $InvoiceNo){
				continue;
			}
			$previousBalance += $sale['PreviousBalance'];
		}
		$data['LastBalance'] = $previousBalance;
		// get account receivable amount
		$data['LedgerReport']    = $this->AccountReport_model->LedgerReport($StartDate,$EndDate,1,3,$SaleInvoiceReport['ChartOfAccountId']);
	    $data['SubLedgerReport'] = $this->AccountReport_model->SubLedgerReport($StartDate,$EndDate,1,3,$SaleInvoiceReport['ChartOfAccountId']);
	    $data['OpenningBalance'] = $this->AccountReport_model->GetOpenningBalance($StartDate,$EndDate,1,3,$SaleInvoiceReport['ChartOfAccountId']);
	    
	    //get last transactions
		$ChartOfAccountId = $this->Customer_model->GetCustomer($SaleInvoiceReport['CustomerId']);
		$data['isLedger'] 	  = $Ledger;
		$data['LedgerReport'] = $this->AccountReport_model->CustomerLedgerReport($StartDate,$EndDate,1,3,$ChartOfAccountId->ChartOfAccountId);
	    $data['SubLedgerReport'] = $this->AccountReport_model->CustomerSubLedgerReport($StartDate,$EndDate,1,3,$ChartOfAccountId->ChartOfAccountId, "invoice");
	    $data['OpenningBalance'] = $this->AccountReport_model->GetCustomerOpenningBalance($StartDate,$EndDate,1,3,$ChartOfAccountId->ChartOfAccountId, "invoice");

		// get all cash received vouchers.
		$ChartOfAccountId = $this->Customer_model->GetCustomerChartOfAccountId($SaleInvoiceReport['CustomerId']); 
		$data['CashVoucherAmount'] = $this->AccountReceivableAmount($ChartOfAccountId[0]['ChartOfAccountId']);
		
		$data['Settings'] = $this->Setting_model->GetSetting(1);
// 		print_r($data['Settings']->signature); die();
		// echo $SaleInvoiceReport['ChartOfAccountId']; exit;
	    $data['CustomerNotification'] = $this->Customer_model->GetNotifications();
	    

        $this->load->view('report/salereports/view_sale_invoice_report', $data);
	}
	
	public function AccountReceivableAmount($CoAId)
	{
		$DebitRecord = $this->Sale_model->DebitRecord($CoAId);
		$CreditRecord = $this->Sale_model->CreditRecord($CoAId);

		$AccountReceivableAmount = ($DebitRecord->Debit - $CreditRecord->Credit);
		return $AccountReceivableAmount;
	}
	
	public function ViewGatePassReport()
	{
        $InvoiceNo = $this->input->get('InvoiceNo');
        $Ledger = $this->input->get('ledger');
		$StartDate = "1971-01-01";
		$EndDate   = "2071-12-30";

        $data['Roles'] = $this->Employee_model->GetRoles();
        $data['AdministrationRoles'] = $this->Employee_model->GetAdministrationRoles($this->session->userdata('EmployeeId'));
        $data['SalesRoles'] = $this->Employee_model->GetSalesRoles($this->session->userdata('EmployeeId'));
        $data['PurchasesRoles'] = $this->Employee_model->GetPurchasesRoles($this->session->userdata('EmployeeId'));
        $data['RegistrationRoles'] = $this->Employee_model->GetRegistrationRoles($this->session->userdata('EmployeeId'));
        $data['TransactionRoles'] = $this->Employee_model->GetTransactionRoles($this->session->userdata('EmployeeId'));
        $data['ReportsRoles'] = $this->Employee_model->GetReportsRoles($this->session->userdata('EmployeeId'));

		$data['SaleInvoiceReport'] = $this->SaleReport_model->SaleInvoiceReport($InvoiceNo);
		
		// get balance amount
		$SaleInvoiceReport = (array) $data['SaleInvoiceReport'];
		$data['SaleInvoices'] = $this->Sale_model->GetLastSales($InvoiceNo, $SaleInvoiceReport['CustomerId']);
		
		// get sale count
		$data['InvoiceCount'] = count($this->SaleReport_model->GetAllSalesByCustomer($SaleInvoiceReport['CustomerId']));

		//get received cash amount
		$data['GetJournalId'] = $this->GeneralJournal_model->GetGeneralJournalBySaleId($SaleInvoiceReport['SaleId']);
		$journalId = (array) $data['GetJournalId'];
		$data['ReceivedCashAmount']	= ($SaleInvoiceReport['SaleType'] == 2) ? (($journalId) ? $this->GeneralJournal_model->GetGeneralJournal($journalId['GeneralJournalId']) : null) : 0;
		$data['SaleInvoiceReportDetails'] = $this->SaleReport_model->SaleInvoiceReportDetails($InvoiceNo);
		
		$data['GetSettingInformation'] = $this->Employee_model->GetSettingInformation();

		// get all sales by customer
		$data['AllSales'] = $this->Sale_model->GetSalesByCustomer($SaleInvoiceReport['CustomerId']);
		$allSales = (array) $data['AllSales'];
		$previousBalance = 0;
		foreach($allSales as $sale){
			if($sale['SaleId'] == $InvoiceNo){
				continue;
			}
			$previousBalance += $sale['PreviousBalance'];
		}
		$data['LastBalance'] = $previousBalance;
		// get account receivable amount
		$data['LedgerReport']    = $this->AccountReport_model->LedgerReport($StartDate,$EndDate,1,3,$SaleInvoiceReport['ChartOfAccountId']);
	    $data['SubLedgerReport'] = $this->AccountReport_model->SubLedgerReport($StartDate,$EndDate,1,3,$SaleInvoiceReport['ChartOfAccountId']);
	    $data['OpenningBalance'] = $this->AccountReport_model->GetOpenningBalance($StartDate,$EndDate,1,3,$SaleInvoiceReport['ChartOfAccountId']);
	    
	    //get last transactions
		$ChartOfAccountId = $this->Customer_model->GetCustomer($SaleInvoiceReport['CustomerId']);
		$data['isLedger'] 	  = $Ledger;
		$data['LedgerReport'] = $this->AccountReport_model->CustomerLedgerReport($StartDate,$EndDate,1,3,$ChartOfAccountId->ChartOfAccountId);
	    $data['SubLedgerReport'] = $this->AccountReport_model->CustomerSubLedgerReport($StartDate,$EndDate,1,3,$ChartOfAccountId->ChartOfAccountId, "invoice");
	    $data['OpenningBalance'] = $this->AccountReport_model->GetCustomerOpenningBalance($StartDate,$EndDate,1,3,$ChartOfAccountId->ChartOfAccountId, "invoice");
	$data['Settings'] = $this->Setting_model->GetSetting(1);

	    $data['CustomerNotification'] = $this->Customer_model->GetNotifications();

        $this->load->view('report/salereports/view_gate_pass_report', $data);
	}
	
	
	public function ViewSaleInvoiceReport___()
	{
        $InvoiceNo = $this->input->get('InvoiceNo');

        
        $data['Roles'] = $this->Employee_model->GetRoles();
        $data['AdministrationRoles'] = $this->Employee_model->GetAdministrationRoles($this->session->userdata('EmployeeId'));
        $data['SalesRoles'] = $this->Employee_model->GetSalesRoles($this->session->userdata('EmployeeId'));
        $data['PurchasesRoles'] = $this->Employee_model->GetPurchasesRoles($this->session->userdata('EmployeeId'));
        $data['RegistrationRoles'] = $this->Employee_model->GetRegistrationRoles($this->session->userdata('EmployeeId'));
        $data['TransactionRoles'] = $this->Employee_model->GetTransactionRoles($this->session->userdata('EmployeeId'));
        $data['ReportsRoles'] = $this->Employee_model->GetReportsRoles($this->session->userdata('EmployeeId'));

		$data['SaleInvoiceReport'] = $this->SaleReport_model->SaleInvoiceReport($InvoiceNo);
		$data['SaleInvoiceReportDetails'] = $this->SaleReport_model->SaleInvoiceReportDetails($InvoiceNo);

//		echo $this->output->enable_profiler();

		$data['GetSettingInformation'] = $this->Employee_model->GetSettingInformation();
		$data['CustomerNotification'] = $this->Customer_model->GetNotifications();
        $this->load->view('report/salereports/view_sale_invoice_report', $data);
	}
	
	public function QuotationReportCriteria()
	{

		$ReportCriteria ='<div style="width:40%; margin-left:190px;" class="box-header with-border">
	    <h3 class="box-title text-light-blue">Report Criteria</h3>
	    </div>';

	    $ReportCriteria .='<div class="form-group">
		     <label style="width:24%;" for="QuotationNo" class="col-sm-1 control-label">Quotation #:</label>
		       <div class="input-group date">
			  <input class="form-control" name="QuotationNo" id="QuotationNo" type="text" placeholder="Enter Quotation Number" style="width:270px;" value="" autocomplete="off">
		       </div>                  
	    </div>';
	    $ReportCriteria .='<div class="form-group">
		     <label style="width:24%;" class="col-sm-2"></label>
		       <div class="input-group date">
			  <button type="button" id="generate_quotation_report" class="btn  btn-primary">Show Report</button>
		       </div>                  
	    </div>';
	    echo $ReportCriteria;
	    $this->load->view("includes/footer");
	}
	public function ViewQuotationeReport()
	{
        $QuotationNo = $this->input->get('QuotationNo');
		$StartDate = "1971-01-01";
		$EndDate   = "2071-12-30";

        $data['Roles'] = $this->Employee_model->GetRoles();
        $data['AdministrationRoles'] = $this->Employee_model->GetAdministrationRoles($this->session->userdata('EmployeeId'));
        $data['SalesRoles'] = $this->Employee_model->GetSalesRoles($this->session->userdata('EmployeeId'));
        $data['PurchasesRoles'] = $this->Employee_model->GetPurchasesRoles($this->session->userdata('EmployeeId'));
        $data['RegistrationRoles'] = $this->Employee_model->GetRegistrationRoles($this->session->userdata('EmployeeId'));
        $data['TransactionRoles'] = $this->Employee_model->GetTransactionRoles($this->session->userdata('EmployeeId'));
        $data['ReportsRoles'] = $this->Employee_model->GetReportsRoles($this->session->userdata('EmployeeId'));

		$data['SaleInvoiceReport'] = $this->SaleReport_model->QuotationInvoiceReport($QuotationNo);
		$data['SaleInvoiceReportDetails'] = $this->SaleReport_model->QuotationInvoiceReportDetails($QuotationNo);
		
		$data['GetSettingInformation'] = $this->Employee_model->GetSettingInformation();
		$data['CustomerNotification'] = $this->Customer_model->GetNotifications();
	
        $this->load->view('report/salereports/view_quotation_report', $data);
	}

}

?>