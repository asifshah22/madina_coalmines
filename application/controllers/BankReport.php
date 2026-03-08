<?php defined('BASEPATH') OR exit('No direct script access allowed');

class BankReport extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->check_isvalidated();
        $this->load->model('Productgroup_model');
        $this->load->model('Employee_model');
        $this->load->model('Company_model');
        $this->load->model('Product_model');
        $this->load->model('BankReport_model');
        $this->load->model('Sale_model');
        $this->load->model('Employee_model');
        $this->load->model('Customer_model');
	//	$this->output->enable_profiler();
	}
	
	private function check_isvalidated()
	{
		if(!$this->session->userdata('EmployeeId'))
		{  $this->session->set_userdata('url',  current_url()); redirect('login'); }
	}
        
	public function index()
	{
            $data['AdministrationRoles'] = $this->Employee_model->GetAdministrationRoles($this->session->userdata('EmployeeId'));
            $data['SalesRoles'] = $this->Employee_model->GetSalesRoles($this->session->userdata('EmployeeId'));
            $data['PurchasesRoles'] = $this->Employee_model->GetPurchasesRoles($this->session->userdata('EmployeeId'));
            $data['RegistrationRoles'] = $this->Employee_model->GetRegistrationRoles($this->session->userdata('EmployeeId'));
            $data['TransactionRoles'] = $this->Employee_model->GetTransactionRoles($this->session->userdata('EmployeeId'));
            $data['ReportsRoles'] = $this->Employee_model->GetReportsRoles($this->session->userdata('EmployeeId'));
            $data['ProductGroup']=$this->Productgroup_model->GetAllProductGroups();
            $data['GetAllCompany'] = $this->Company_model->GetAllCompanies();
            $data['CustomerNotification'] = $this->Customer_model->GetNotifications();
//            $data['GetAllProduct'] = $this->Product_model->GetAllProducts();
            $this->load->view('bankreport/bankreport',$data);
	}
        
    public function ViewBankReport()
    {
            $data = $this->input->post();
            
            $CompanyId = $this->input->post('CompanyId');
            $ProductId = $this->input->post('ProductId');

            $data['EmployeeRoles'] = $this->Employee_model->GetEmployeeRoles($this->session->userdata('EmployeeId')); 
            $data['AdministrationRoles'] = $this->Employee_model->GetAdministrationRoles($this->session->userdata('EmployeeId'));
            $data['SalesRoles'] = $this->Employee_model->GetSalesRoles($this->session->userdata('EmployeeId'));
            $data['PurchasesRoles'] = $this->Employee_model->GetPurchasesRoles($this->session->userdata('EmployeeId'));
            $data['AccountsRoles'] = $this->Employee_model->GetAccountsRoles($this->session->userdata('EmployeeId'));
            $data['ReportsRoles'] = $this->Employee_model->GetReportsRoles($this->session->userdata('EmployeeId')); 
//            $data['GetProductGroup'] = $this->Productgroup_model->GetProductGroup($ProductGroupId);
            $data['GetBankReport'] = $this->BankReport_model->GetBankReport($CompanyId, $ProductId);
            $data['CustomerNotification'] = $this->Customer_model->GetNotifications();
            $this->load->view('BankReport/view_BankReport', $data);
	}
        

}

?>