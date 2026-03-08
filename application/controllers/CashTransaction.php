<?php defined('BASEPATH') OR exit('No direct script access allowed');

class CashTransaction extends CI_Controller {

	public function __construct()
	{
	    parent::__construct();
	    $this->check_isvalidated();
	    $this->load->model('CashTransaction_model');
	    $this->load->model('Employee_model');
	    $this->load->model('Customer_model');
//	    $this->load->model('Accounts_model');
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
	    $data['AdministrationRoles'] = $this->Employee_model->GetAdministrationRoles($this->session->userdata('EmployeeId'));
	    $data['SalesRoles'] = $this->Employee_model->GetSalesRoles($this->session->userdata('EmployeeId'));
	    $data['PurchasesRoles'] = $this->Employee_model->GetPurchasesRoles($this->session->userdata('EmployeeId'));
	    $data['RegistrationRoles'] = $this->Employee_model->GetRegistrationRoles($this->session->userdata('EmployeeId'));
	    $data['TransactionRoles'] = $this->Employee_model->GetTransactionRoles($this->session->userdata('EmployeeId'));
	    $data['ReportsRoles'] = $this->Employee_model->GetReportsRoles($this->session->userdata('EmployeeId'));
	    $data['CashTransactions']=$this->CashTransaction_model->AllCashTransactions();
	    
	    $data['CustomerNotification'] = $this->Customer_model->GetNotifications();
	    $this->load->view('cashtransaction/cashtransactions',$data);
	}
	
	
	public function ViewCashTransaction($CashTransactionId)
	{
	    $data['AdministrationRoles'] = $this->Employee_model->GetAdministrationRoles($this->session->userdata('EmployeeId'));
	    $data['SalesRoles'] = $this->Employee_model->GetSalesRoles($this->session->userdata('EmployeeId'));
	    $data['PurchasesRoles'] = $this->Employee_model->GetPurchasesRoles($this->session->userdata('EmployeeId'));
	    $data['RegistrationRoles'] = $this->Employee_model->GetRegistrationRoles($this->session->userdata('EmployeeId'));
	    $data['TransactionRoles'] = $this->Employee_model->GetTransactionRoles($this->session->userdata('EmployeeId'));
	    $data['ReportsRoles'] = $this->Employee_model->GetReportsRoles($this->session->userdata('EmployeeId')); 
	    $data['CashTransaction'] = $this->CashTransaction_model->GetCashTransaction($CashTransactionId);
	    $data['CashTransactionDetail'] = $this->CashTransaction_model->GetCashTransactionDetail($CashTransactionId);
	    
	    $data['CustomerNotification'] = $this->Customer_model->GetNotifications();
	    $this->load->view('cashtransaction/view_cashtransaction',$data);
	}
	
	
	public function AddCashTransaction()
	{
	    $data['AdministrationRoles'] = $this->Employee_model->GetAdministrationRoles($this->session->userdata('EmployeeId'));
	    $data['SalesRoles'] = $this->Employee_model->GetSalesRoles($this->session->userdata('EmployeeId'));
	    $data['PurchasesRoles'] = $this->Employee_model->GetPurchasesRoles($this->session->userdata('EmployeeId'));
	    $data['RegistrationRoles'] = $this->Employee_model->GetRegistrationRoles($this->session->userdata('EmployeeId'));
	    $data['TransactionRoles'] = $this->Employee_model->GetTransactionRoles($this->session->userdata('EmployeeId'));
	    $data['ReportsRoles'] = $this->Employee_model->GetReportsRoles($this->session->userdata('EmployeeId'));
	    
	    $data['CustomerNotification'] = $this->Customer_model->GetNotifications();
	    $this->load->view('cashtransaction/add_cashtransaction',$data);
	}
	
	
	public function EditCashTransaction($CashTransactionId)
	{
	    $data['AdministrationRoles'] = $this->Employee_model->GetAdministrationRoles($this->session->userdata('EmployeeId'));
	    $data['SalesRoles'] = $this->Employee_model->GetSalesRoles($this->session->userdata('EmployeeId'));
	    $data['PurchasesRoles'] = $this->Employee_model->GetPurchasesRoles($this->session->userdata('EmployeeId'));
	    $data['RegistrationRoles'] = $this->Employee_model->GetRegistrationRoles($this->session->userdata('EmployeeId'));
	    $data['TransactionRoles'] = $this->Employee_model->GetTransactionRoles($this->session->userdata('EmployeeId'));
	    $data['ReportsRoles'] = $this->Employee_model->GetReportsRoles($this->session->userdata('EmployeeId')); 
	    $data['CashTransaction'] = $this->CashTransaction_model->GetCashTransaction($CashTransactionId);
	    $data['CashTransactionDetail'] = $this->CashTransaction_model->GetCashTransactionDetail($CashTransactionId);
	    
	    $data['CustomerNotification'] = $this->Customer_model->GetNotifications();
	    $this->load->view('cashtransaction/edit_cashtransaction',$data);
	}
	
	
	public function SaveCashTransaction()
	{          
	    $NewTransactionId = $this->CashTransaction_model->SaveCashTransactionDetail();
	    
	    if($NewTransactionId != '0' &&  !(empty($NewTransactionId)))
	    { redirect("CashTransaction/ViewCashTransaction/$NewTransactionId"); }
	    else
	    { redirect("CashTransaction"); }
	}
	
	
	public function UpdateCashTransaction($CashTransactionId)
	{
	    $CashTransactionId = $this->input->post('CashTransactionId');
	    if($CashTransactionId != '0' &&  !(empty($CashTransactionId)))
	    {
		$this->CashTransaction_model->UpdateCashTransactionDetail($CashTransactionId);
		redirect("CashTransaction/ViewCashTransaction/$CashTransactionId");	    
	    }
	    else
	    { redirect("CashTransaction/"); }
	}
	
	
	public function AutoCompleteAccountList()
	{
            	  
	  $AccountName = $this->input->post('AccountName');
	  $query = "";
	  $CompanyId = $this->session->userdata('CompanyId');

	  if($CompanyId != 0){
	  $query = $this->db->query("SELECT AccountId,AccountName FROM pos_accounts AS P WHERE P.AccountName LIKE '%{$AccountName}%' AND P.CompanyId = '$CompanyId' LIMIT 10");
	  }

	 // $query = $this->db->query("SELECT ProductId,ProductName FROM ims_products AS P WHERE P.ProductName LIKE '%{$ProductName}%' LIMIT 10");
            
          $AccountList = array();
          foreach ($query->result_array() as $key) 
	  {
			    
	    if($key['AccountName'] != '' || $key['AccountName'] != null )
	    { $AccountName = '-'.$key['AccountName']; }
	    
	    $bn = array(
		'id' => trim($key['AccountId']),
		'value' => trim($key['AccountName'])
	    );
	    $AccountList[] = $bn;
	    }
	    echo json_encode($AccountList);
	 }
}

?>