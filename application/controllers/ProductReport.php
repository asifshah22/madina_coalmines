<?php defined('BASEPATH') OR exit('No direct script access allowed');

class ProductReport extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->check_isvalidated();
        $this->load->model('ProductGroup_model');
        $this->load->model('Employee_model');
        $this->load->model('Company_model');
        $this->load->model('Product_model');
        $this->load->model('ProductReport_model');
        $this->load->model('Location_model');
		$this->load->model('Colour_model');
		$this->load->model('Category_model');
		$this->load->model('ProductGroup_model');
		$this->load->model('Customer_model');
		//$this->output->enable_profiler();
	}
	
	
	private function check_isvalidated()
	{
		if(!$this->session->userdata('EmployeeId'))
		{  $this->session->set_userdata('url',  current_url()); redirect('Login'); }
	}
        
	public function index()
	{
        $data['AdministrationRoles'] = $this->Employee_model->GetAdministrationRoles($this->session->userdata('EmployeeId'));
        $data['SalesRoles'] = $this->Employee_model->GetSalesRoles($this->session->userdata('EmployeeId'));
        $data['PurchasesRoles'] = $this->Employee_model->GetPurchasesRoles($this->session->userdata('EmployeeId'));
        $data['RegistrationRoles'] = $this->Employee_model->GetRegistrationRoles($this->session->userdata('EmployeeId'));
        $data['TransactionRoles'] = $this->Employee_model->GetTransactionRoles($this->session->userdata('EmployeeId'));
        $data['ReportsRoles'] = $this->Employee_model->GetReportsRoles($this->session->userdata('EmployeeId'));
        $data['AllProductGroups']=$this->ProductGroup_model->GetAllProductGroups();
        $data['GetAllCompany'] = $this->Company_model->GetAllCompanies();
        $data['GetAllProduct'] = $this->Product_model->GetAllProducts();
        $data['GetAllLocation'] = $this->Location_model->GetAllLocation();
        $data['CustomerNotification'] = $this->Customer_model->GetNotifications();
        $this->load->view('admin/report/products',$data);
	}

	public function ProductReports()
	{
        $data['AdministrationRoles'] = $this->Employee_model->GetAdministrationRoles($this->session->userdata('EmployeeId'));
        $data['SalesRoles'] = $this->Employee_model->GetSalesRoles($this->session->userdata('EmployeeId'));
        $data['PurchasesRoles'] = $this->Employee_model->GetPurchasesRoles($this->session->userdata('EmployeeId'));
        $data['RegistrationRoles'] = $this->Employee_model->GetRegistrationRoles($this->session->userdata('EmployeeId'));
        $data['TransactionRoles'] = $this->Employee_model->GetTransactionRoles($this->session->userdata('EmployeeId'));
        $data['ReportsRoles'] = $this->Employee_model->GetReportsRoles($this->session->userdata('EmployeeId'));
        $data['GetAllCategories'] = $this->Category_model->GetAllCategories();
        $data['AllProductGroups'] = $this->ProductGroup_model->GetAllProductGroups();
        $data['GetAllBrands'] = $this->Product_model->GetAllBrands();
        $data['GetAllCompany'] = $this->Company_model->GetAllCompanies();
        $data['GetAllProduct'] = $this->Product_model->GetAllProducts();
        $data['CustomerNotification'] = $this->Customer_model->GetNotifications();
        $this->load->view('admin/report/productreport',$data);
	}
        
	
    public function ViewProductReport()
    { 
        $CategoryId = $this->input->get('CategoryId');
        $ProductGroupId = $this->input->get('ProductGroupId');
        $BrandId = $this->input->get('BrandId');
        $ProductId = $this->input->get('ProductId');

        $data['Roles'] = $this->Employee_model->GetRoles();
        $data['AdministrationRoles'] = $this->Employee_model->GetAdministrationRoles($this->session->userdata('EmployeeId'));
        $data['SalesRoles'] = $this->Employee_model->GetSalesRoles($this->session->userdata('EmployeeId'));
        $data['PurchasesRoles'] = $this->Employee_model->GetPurchasesRoles($this->session->userdata('EmployeeId'));
        $data['RegistrationRoles'] = $this->Employee_model->GetRegistrationRoles($this->session->userdata('EmployeeId'));
        $data['TransactionRoles'] = $this->Employee_model->GetTransactionRoles($this->session->userdata('EmployeeId'));
        $data['ReportsRoles'] = $this->Employee_model->GetReportsRoles($this->session->userdata('EmployeeId'));

		$data['AllProductReports'] = $this->ProductReport_model->GetProductReport($ProductId,$CategoryId,$ProductGroupId,$BrandId);
		$data['CustomerNotification'] = $this->Customer_model->GetNotifications();
        $this->load->view('admin/report/view_product_report', $data);
    }
}
 ?>