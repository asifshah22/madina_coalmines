<?php defined('BASEPATH') OR exit('No direct script access allowed');

class AccountsGroup extends CI_Controller {

	public function __construct()
	{
	    parent::__construct();
	    $this->check_isvalidated();
	    $this->load->model('AccountsGroup_model');
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

	
	public function index()
	{	
	    $data['Roles'] = $this->Employee_model->GetRoles();
	    $data['AdministrationRoles'] = $this->Employee_model->GetAdministrationRoles($this->session->userdata('EmployeeId'));
	    $data['SalesRoles'] = $this->Employee_model->GetSalesRoles($this->session->userdata('EmployeeId'));
	    $data['PurchasesRoles'] = $this->Employee_model->GetPurchasesRoles($this->session->userdata('EmployeeId'));
	    $data['RegistrationRoles'] = $this->Employee_model->GetRegistrationRoles($this->session->userdata('EmployeeId'));
	    $data['TransactionRoles'] = $this->Employee_model->GetTransactionRoles($this->session->userdata('EmployeeId'));
	    $data['ReportsRoles'] = $this->Employee_model->GetReportsRoles($this->session->userdata('EmployeeId'));
	    $data['AllAccountGroups']=$this->AccountsGroup_model->GetAllAccountGroups();
	    $data['TotalRecord']=$this->AccountsGroup_model->TotalRecord();
	    
	    $data['CustomerNotification'] = $this->Customer_model->GetNotifications();
	    $this->load->view('accountgroup/accountgroups',$data);
	}
	
	
	public function AddAccountGroup()
	{
	    $data['Roles'] = $this->Employee_model->GetRoles();
	    $data['AdministrationRoles'] = $this->Employee_model->GetAdministrationRoles($this->session->userdata('EmployeeId'));
	    $data['SalesRoles'] = $this->Employee_model->GetSalesRoles($this->session->userdata('EmployeeId'));
	    $data['RegistrationRoles'] = $this->Employee_model->GetRegistrationRoles($this->session->userdata('EmployeeId'));
	    $data['TransactionRoles'] = $this->Employee_model->GetTransactionRoles($this->session->userdata('EmployeeId'));
	    $data['PurchasesRoles'] = $this->Employee_model->GetPurchasesRoles($this->session->userdata('EmployeeId'));
	    $data['ReportsRoles'] = $this->Employee_model->GetReportsRoles($this->session->userdata('EmployeeId')); 
	    
	    $data['CustomerNotification'] = $this->Customer_model->GetNotifications();
	    $this->load->view('accountgroup/add_accountgroup',$data);
	}
	
	
	public function ViewAccountGroup($AccountGroupId)
	{
	    $data['Roles'] = $this->Employee_model->GetRoles();
	    $data['AdministrationRoles'] = $this->Employee_model->GetAdministrationRoles($this->session->userdata('EmployeeId'));
	    $data['SalesRoles'] = $this->Employee_model->GetSalesRoles($this->session->userdata('EmployeeId'));
	    $data['PurchasesRoles'] = $this->Employee_model->GetPurchasesRoles($this->session->userdata('EmployeeId'));
	    $data['RegistrationRoles'] = $this->Employee_model->GetRegistrationRoles($this->session->userdata('EmployeeId'));
	    $data['TransactionRoles'] = $this->Employee_model->GetTransactionRoles($this->session->userdata('EmployeeId'));
	    $data['ReportsRoles'] = $this->Employee_model->GetReportsRoles($this->session->userdata('EmployeeId')); 
	    $data['GetAccountGroupById'] = $this->AccountsGroup_model->GetAccountGroupById($AccountGroupId);
	    
	    $data['CustomerNotification'] = $this->Customer_model->GetNotifications();
	    $this->load->view('accountgroup/view_accountgroup',$data);
	}
	
    
	public function EditAccountGroup($AccountGroupId)
	{
	    $data['AdministrationRoles'] = $this->Employee_model->GetAdministrationRoles($this->session->userdata('EmployeeId'));
	    $data['SalesRoles'] = $this->Employee_model->GetSalesRoles($this->session->userdata('EmployeeId'));
	    $data['PurchasesRoles'] = $this->Employee_model->GetPurchasesRoles($this->session->userdata('EmployeeId'));
	    $data['RegistrationRoles'] = $this->Employee_model->GetRegistrationRoles($this->session->userdata('EmployeeId'));
	    $data['TransactionRoles'] = $this->Employee_model->GetTransactionRoles($this->session->userdata('EmployeeId'));
	    $data['ReportsRoles'] = $this->Employee_model->GetReportsRoles($this->session->userdata('EmployeeId')); 
	    $data['GetAccountGroupById'] = $this->AccountsGroup_model->GetAccountGroupById($AccountGroupId);
	    
	    $data['CustomerNotification'] = $this->Customer_model->GetNotifications();
	    $this->load->view('accountgroup/edit_accountgroup',$data);
	}

	
	public function SaveAccountGroup($AccountGroupId)
	{  
	    $data=$this->input->post();
	    $data['AddedOn'] = date('Y-m-d H:i:s');
	    $data['AddedBy'] = $this->session->userdata('EmployeeId');
	   
	    if($NewAccountGroupId =  $this->AccountsGroup_model->SaveAccountGroup($data,$AccountGroupId))
	    {
		redirect("AccountsGroup/ViewAccountGroup/$NewAccountGroupId");
	    }
	}

	
	public function DeleteAccountGroup($AccountGroupId)
	{
	    if($this->AccountsGroup_model->DeleteAccountGroup($AccountGroupId))
	    {
		redirect("AccountsGroup");
	    }
	}
}
?>