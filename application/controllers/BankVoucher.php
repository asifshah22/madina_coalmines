<?php defined('BASEPATH') OR exit('No direct script access allowed');

class BankVoucher extends CI_Controller {

	public function __construct()
	{
	    parent::__construct();
	    $this->check_isvalidated();
	    $this->load->model('Category_model');
	    $this->load->model('Employee_model');
	    $this->load->model('Customer_model');
	}
	
	private function check_isvalidated()
	{
	    if(!$this->session->userdata('EmployeeId'))
	    { 
		$this->session->set_userdata('url',  current_url());
		redirect("login"); 
	    }
	}
	
	public function BankPaymentVoucher()
	{	
	     die('BankPaymentVoucher');
	    $data['Roles'] = $this->Employee_model->GetRoles();
	    $data['AdministrationRoles'] = $this->Employee_model->GetAdministrationRoles($this->session->userdata('EmployeeId'));
	    $data['SalesRoles'] = $this->Employee_model->GetSalesRoles($this->session->userdata('EmployeeId'));
	    $data['PurchasesRoles'] = $this->Employee_model->GetPurchasesRoles($this->session->userdata('EmployeeId'));
	    $data['RegistrationRoles'] = $this->Employee_model->GetRegistrationRoles($this->session->userdata('EmployeeId'));
	    $data['TransactionRoles'] = $this->Employee_model->GetTransactionRoles($this->session->userdata('EmployeeId'));
	    $data['ReportsRoles'] = $this->Employee_model->GetReportsRoles($this->session->userdata('EmployeeId'));
	    $data['AllCategories']=$this->Category_model->GetAllCategories();
	    $data['TotalRecord']=$this->Category_model->TotalRecord();
	    $data['CustomerNotification'] = $this->Customer_model->GetNotifications();
	    
	    $this->load->view('category/categories',$data);
	}
	
	
	public function BankReceivedVoucher()
	{
	    die('BankReceivedVoucher');
	    
	    $data['Roles'] = $this->Employee_model->GetRoles();
	    $data['AdministrationRoles'] = $this->Employee_model->GetAdministrationRoles($this->session->userdata('EmployeeId'));
	    $data['SalesRoles'] = $this->Employee_model->GetSalesRoles($this->session->userdata('EmployeeId'));
	    $data['RegistrationRoles'] = $this->Employee_model->GetRegistrationRoles($this->session->userdata('EmployeeId'));
	    $data['TransactionRoles'] = $this->Employee_model->GetTransactionRoles($this->session->userdata('EmployeeId'));
	    $data['PurchasesRoles'] = $this->Employee_model->GetPurchasesRoles($this->session->userdata('EmployeeId'));
	    $data['ReportsRoles'] = $this->Employee_model->GetReportsRoles($this->session->userdata('EmployeeId')); 
	    $data['CustomerNotification'] = $this->Customer_model->GetNotifications();
	    
	    $this->load->view('category/add_category',$data);
	}
	
	
	public function ViewCategory($CategoryId)
	{
	    $data['Roles'] = $this->Employee_model->GetRoles();
	    $data['AdministrationRoles'] = $this->Employee_model->GetAdministrationRoles($this->session->userdata('EmployeeId'));
	    $data['SalesRoles'] = $this->Employee_model->GetSalesRoles($this->session->userdata('EmployeeId'));
	    $data['PurchasesRoles'] = $this->Employee_model->GetPurchasesRoles($this->session->userdata('EmployeeId'));
	    $data['RegistrationRoles'] = $this->Employee_model->GetRegistrationRoles($this->session->userdata('EmployeeId'));
	    $data['TransactionRoles'] = $this->Employee_model->GetTransactionRoles($this->session->userdata('EmployeeId'));
	    $data['ReportsRoles'] = $this->Employee_model->GetReportsRoles($this->session->userdata('EmployeeId')); 
	    $data['GetCategoryById'] = $this->Category_model->GetCategoryById($CategoryId);
	    $data['CustomerNotification'] = $this->Customer_model->GetNotifications();
	    
	    $this->load->view('category/view_category',$data);
	}
	
    
	public function EditCategory($CategoryId)
	{
	    $data['AdministrationRoles'] = $this->Employee_model->GetAdministrationRoles($this->session->userdata('EmployeeId'));
	    $data['SalesRoles'] = $this->Employee_model->GetSalesRoles($this->session->userdata('EmployeeId'));
	    $data['PurchasesRoles'] = $this->Employee_model->GetPurchasesRoles($this->session->userdata('EmployeeId'));
	    $data['RegistrationRoles'] = $this->Employee_model->GetRegistrationRoles($this->session->userdata('EmployeeId'));
	    $data['TransactionRoles'] = $this->Employee_model->GetTransactionRoles($this->session->userdata('EmployeeId'));
	    $data['ReportsRoles'] = $this->Employee_model->GetReportsRoles($this->session->userdata('EmployeeId')); 
	    $data['GetCategoryById'] = $this->Category_model->GetCategoryById($CategoryId);
	    $data['CustomerNotification'] = $this->Customer_model->GetNotifications();
	    
	    $this->load->view('category/edit_category',$data);
	}

	
	public function SaveCategory($categoryId='')
	{	
          
	    $data=$this->input->post();
	    $data['CompanyId'] = $this->session->userdata('CompanyId');
	    $data['AddedOn'] = date('Y-m-d H:i:s');
	    $data['AddedBy'] = $this->session->userdata('EmployeeId');

	    if($NewCategoryId =  $this->Category_model->SaveCategory($data,$categoryId))
	    {
	    redirect("Category/ViewCategory/$NewCategoryId");
	    }
	}

	
	public function DeleteCategory($CategoryId)
	{
	    if($this->Category_model->DeleteCategory($CategoryId))
	    {
		redirect("Category");
	    }
	}
}

?>