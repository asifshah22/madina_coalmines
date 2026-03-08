<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Stocks extends CI_Controller {

	public function __construct()
	{
	    parent::__construct();
	    $this->check_isvalidated();
	    $this->load->model('Company_model');
	    $this->load->model('Product_model');
	    $this->load->model('Brand_model');
	    $this->load->model('Colour_model');
	    $this->load->model('Location_model');
	    $this->load->model('ProductGroup_model');
	    $this->load->model('StockReport_model');
	    $this->load->model('ProductReport_model');
	    $this->load->model('Employee_model');
	    $this->load->model('Customer_model');
//	   $this->output->enable_profiler(true);
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

	    $data['AllBrands'] = $this->Product_model->GetAllBrands();
	    $data['GetAllProductGroups'] = $this->ProductGroup_model->GetAllProductGroups();
	    $data['AllCompanies'] = $this->Company_model->GetAllCompanies();
	    $data['AllProducts'] = $this->Product_model->GetAllProducts();
	    $data['CustomerNotification'] = $this->Customer_model->GetNotifications();
	    $this->load->view('admin/report/stocks', $data);
	}
	
	function StockActivityReport()
	{
	    $data['AdministrationRoles'] = $this->Employee_model->GetAdministrationRoles($this->session->userdata('EmployeeId'));
	    $data['SalesRoles'] = $this->Employee_model->GetSalesRoles($this->session->userdata('EmployeeId'));
	    $data['PurchasesRoles'] = $this->Employee_model->GetPurchasesRoles($this->session->userdata('EmployeeId'));
	    $data['RegistrationRoles'] = $this->Employee_model->GetRegistrationRoles($this->session->userdata('EmployeeId'));
	    $data['TransactionRoles'] = $this->Employee_model->GetTransactionRoles($this->session->userdata('EmployeeId'));
	    $data['ReportsRoles'] = $this->Employee_model->GetReportsRoles($this->session->userdata('EmployeeId'));

	    $data['AllBrands'] = $this->Product_model->GetAllBrands();
	    $data['AllProductGroups'] = $this->ProductGroup_model->GetAllProductGroups();
	    $data['AllCompanies'] = $this->Company_model->GetAllCompanies();
	    $data['AllProducts'] = $this->Product_model->GetAllProducts();
	    $data['CustomerNotification'] = $this->Customer_model->GetNotifications();
	    $this->load->view('admin/report/stock_activity_report', $data);
	}	
	
	function StockBalanceReport()
	{
	    $data['AdministrationRoles'] = $this->Employee_model->GetAdministrationRoles($this->session->userdata('EmployeeId'));
	    $data['SalesRoles'] = $this->Employee_model->GetSalesRoles($this->session->userdata('EmployeeId'));
	    $data['PurchasesRoles'] = $this->Employee_model->GetPurchasesRoles($this->session->userdata('EmployeeId'));
	    $data['RegistrationRoles'] = $this->Employee_model->GetRegistrationRoles($this->session->userdata('EmployeeId'));
	    $data['TransactionRoles'] = $this->Employee_model->GetTransactionRoles($this->session->userdata('EmployeeId'));
	    $data['ReportsRoles'] = $this->Employee_model->GetReportsRoles($this->session->userdata('EmployeeId'));

	    $data['AllBrands'] = $this->Product_model->GetAllBrands();
	    $data['AllProductGroups'] = $this->ProductGroup_model->GetAllProductGroups();
	    $data['AllCompanies'] = $this->Company_model->GetAllCompanies();
	    $data['AllProducts'] = $this->Product_model->GetAllProducts();
	    $data['CustomerNotification'] = $this->Customer_model->GetNotifications();
	    $this->load->view('admin/report/stock_balance_report', $data);
	}
	
	
	
	public function ViewStockBalanceReport()
	{	       
	    $CompanyId = $this->input->get('CompanyId');
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
	    $data['AllPurchaseRecord'] = $this->StockReport_model->GetAllPurchaseRecord($StartDate,$EndDate,$ProductId,$CompanyId,$ProductGroupId,$BrandId);
	    $data['AllPurchaseReturnRecord'] = $this->StockReport_model->GetAllPurchaseReturnRecord($StartDate,$EndDate,$ProductId,$CompanyId,$ProductGroupId,$BrandId);
	    
	    $data['AllSaleRecord'] = $this->StockReport_model->GetAllSaleRecord($StartDate,$EndDate,$ProductId,$CompanyId,$ProductGroupId,$BrandId);
	    $data['AllSaleReturnRecord'] = $this->StockReport_model->GetAllSaleReturnRecord($StartDate,$EndDate,$ProductId,$CompanyId,$ProductGroupId,$BrandId);
	    $data['CustomerNotification'] = $this->Customer_model->GetNotifications();
	    

	    $this->load->view('admin/report/view_stockbalance_report', $data);
	}

 
	public function ViewStockQuantityReport()
	{
	    $CompanyId = $this->input->get('CompanyId');
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
	    $data['AllPurchaseRecord'] = $this->StockReport_model->GetAllPurchaseRecord($StartDate,$EndDate,$ProductId,$CompanyId,$ProductGroupId,$BrandId);
	    $data['AllPurchaseReturnRecord'] = $this->StockReport_model->GetAllPurchaseReturnRecord($StartDate,$EndDate,$ProductId,$CompanyId,$ProductGroupId,$BrandId);
	    
	    $data['AllSaleRecord'] = $this->StockReport_model->GetAllSaleRecord($StartDate,$EndDate,$ProductId,$CompanyId,$ProductGroupId,$BrandId);
	    $data['AllSaleReturnRecord'] = $this->StockReport_model->GetAllSaleReturnRecord($StartDate,$EndDate,$ProductId,$CompanyId,$ProductGroupId,$BrandId);
	    $data['CustomerNotification'] = $this->Customer_model->GetNotifications();
	    $this->load->view('admin/report/view_stockquantity_report', $data);
	}

	public function StockStatus()
	{
        $data['AdministrationRoles'] = $this->Employee_model->GetAdministrationRoles($this->session->userdata('EmployeeId'));
        $data['SalesRoles'] = $this->Employee_model->GetSalesRoles($this->session->userdata('EmployeeId'));
        $data['PurchasesRoles'] = $this->Employee_model->GetPurchasesRoles($this->session->userdata('EmployeeId'));
        $data['RegistrationRoles'] = $this->Employee_model->GetRegistrationRoles($this->session->userdata('EmployeeId'));
        $data['TransactionRoles'] = $this->Employee_model->GetTransactionRoles($this->session->userdata('EmployeeId'));
        $data['ReportsRoles'] = $this->Employee_model->GetReportsRoles($this->session->userdata('EmployeeId'));
        $data['ProductGroup']=$this->ProductGroup_model->GetAllProductGroups();
        $data['GetAllCompany'] = $this->Company_model->GetAllCompanies();
        $data['GetAllProduct'] = $this->Product_model->GetAllProducts();
        $data['GetAllLocation'] = $this->Location_model->GetAllLocation();
        $data['CustomerNotification'] = $this->Customer_model->GetNotifications();
        $this->load->view('admin/report/stock_status',$data);
	}

    public function ViewStockStatusReport()
    { 
        $LocationId = $this->input->get('LocationId');
        $ProductId = $this->input->get('ProductId');
        $UptoDate = $this->input->get('EndDate');

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
	$data['CustomerNotification'] = $this->Customer_model->GetNotifications();
	
	$this->load->view('admin/report/view_stockstatus_report',$data);
    }

	public function StockTransfer()
	{
        $data['AdministrationRoles'] = $this->Employee_model->GetAdministrationRoles($this->session->userdata('EmployeeId'));
        $data['SalesRoles'] = $this->Employee_model->GetSalesRoles($this->session->userdata('EmployeeId'));
        $data['PurchasesRoles'] = $this->Employee_model->GetPurchasesRoles($this->session->userdata('EmployeeId'));
        $data['RegistrationRoles'] = $this->Employee_model->GetRegistrationRoles($this->session->userdata('EmployeeId'));
        $data['TransactionRoles'] = $this->Employee_model->GetTransactionRoles($this->session->userdata('EmployeeId'));
        $data['ReportsRoles'] = $this->Employee_model->GetReportsRoles($this->session->userdata('EmployeeId'));
        $data['ProductGroup']=$this->ProductGroup_model->GetAllProductGroups();
        $data['AllEmployees']=$this->Employee_model->GetCompanyEmployees();
        $data['GetAllColour'] = $this->Colour_model->GetAllColours();
        $data['GetAllCompany'] = $this->Company_model->GetAllCompanies();
        $data['GetAllProduct'] = $this->Product_model->GetAllProducts();
        $data['GetAllLocation'] = $this->Location_model->GetAllLocation();
        $data['CustomerNotification'] = $this->Customer_model->GetNotifications();
        $this->load->view('admin/report/stock_transfer',$data);
	}

    public function ViewStockTransferReport()
    {
//	    $LocationIdFrom = $this->input->get('LocationIdFrom');
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
	    $data['CustomerNotification'] = $this->Customer_model->GetNotifications();
/*	    echo "<pre>";
		print_r($data['AllStockLocationFrom']);
		die;*/
	$this->load->view('admin/report/view_stocktransfer_report',$data);
    }


}
?>