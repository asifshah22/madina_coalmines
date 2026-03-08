<?php defined('BASEPATH') OR exit('No direct script access allowed');

class AccountTransaction extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		
		$this->check_isvalidated();
		$this->load->model('AccountTransaction_model');
        $this->load->model('Company_model');
        $this->load->model('Employee_model');
        $this->load->model('Customer_model');
//    $this->output->enable_profiler();
	}
	
	private function check_isvalidated()
	{
		if(!$this->session->userdata('EmployeeId'))
		{
            $this->session->set_userdata('url',  current_url());
            redirect('login'); 
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
        $data['GetAllAccounts']=$this->AccountTransaction_model->GetAllAccounts();
        $data['AllAccountTransaction']=$this->AccountTransaction_model->AllAccountTransaction();
        
        $data['CustomerNotification'] = $this->Customer_model->GetNotifications();
        $this->load->view('accounttransaction/accounttransactions',$data);
    }


    public function AddAccountTransaction()
    {
        $data['AdministrationRoles'] = $this->Employee_model->GetAdministrationRoles($this->session->userdata('EmployeeId'));
        $data['SalesRoles'] = $this->Employee_model->GetSalesRoles($this->session->userdata('EmployeeId'));
        $data['PurchasesRoles'] = $this->Employee_model->GetPurchasesRoles($this->session->userdata('EmployeeId'));
	    $data['RegistrationRoles'] = $this->Employee_model->GetRegistrationRoles($this->session->userdata('EmployeeId'));
        $data['TransactionRoles'] = $this->Employee_model->GetTransactionRoles($this->session->userdata('EmployeeId'));
        $data['ReportsRoles'] = $this->Employee_model->GetReportsRoles($this->session->userdata('EmployeeId'));
        $data['GetAllAccounts']=$this->AccountTransaction_model->GetAllAccounts();
        $data['GetAllBanks']=$this->AccountTransaction_model->GetAllBanks();
        $data['GetAllCompanies']=$this->Company_model->GetAllCompanies();
        
        $data['CustomerNotification'] = $this->Customer_model->GetNotifications();
        $this->load->view('accounttransaction/add_accounttransaction',$data);
    }


    public function ViewAccountTransaction($AccountTransactionId)
    {
        $data['Roles'] = $this->Employee_model->GetRoles();
        $data['AdministrationRoles'] = $this->Employee_model->GetAdministrationRoles($this->session->userdata('EmployeeId'));
        $data['SalesRoles'] = $this->Employee_model->GetSalesRoles($this->session->userdata('EmployeeId'));
        $data['PurchasesRoles'] = $this->Employee_model->GetPurchasesRoles($this->session->userdata('EmployeeId'));
	    $data['RegistrationRoles'] = $this->Employee_model->GetRegistrationRoles($this->session->userdata('EmployeeId'));
        $data['TransactionRoles'] = $this->Employee_model->GetTransactionRoles($this->session->userdata('EmployeeId'));
        $data['ReportsRoles'] = $this->Employee_model->GetReportsRoles($this->session->userdata('EmployeeId'));
        $data['GetAllAccounts']=$this->AccountTransaction_model->GetAllAccounts();
        $data['GetAllBanks']=$this->AccountTransaction_model->GetAllBanks();
        $data['DebitId']=$this->AccountTransaction_model->DebitId($AccountTransactionId);
        $data['CreditId']=$this->AccountTransaction_model->CreditId($AccountTransactionId);
        $data['AccountTransaction']=$this->AccountTransaction_model->GetAccountTransaction($AccountTransactionId);
        $data['AccountTransactionDetail']=$this->AccountTransaction_model->AccountTransactionDetail($AccountTransactionId);
        
        $data['CustomerNotification'] = $this->Customer_model->GetNotifications();
        $this->load->view('accounttransaction/view_accounttransaction',$data);
    }


    public function SaveAccountTransaction()
	{
        if($LastAccountTransactionId = $this->AccountTransaction_model->SaveAccountTransaction())
        {
        $this->session->set_flashdata('messag_accounts','Account Information Added sucessfuly..!');
        redirect("AccountTransaction/ViewAccountTransaction/$LastAccountTransactionId");
        }

    }


    public function EditAccountTransaction($AccountTransactionId)
    {
        $data['Roles'] = $this->Employee_model->GetRoles();
        $data['AdministrationRoles'] = $this->Employee_model->GetAdministrationRoles($this->session->userdata('EmployeeId'));
        $data['SalesRoles'] = $this->Employee_model->GetSalesRoles($this->session->userdata('EmployeeId'));
        $data['PurchasesRoles'] = $this->Employee_model->GetPurchasesRoles($this->session->userdata('EmployeeId'));
	    $data['RegistrationRoles'] = $this->Employee_model->GetRegistrationRoles($this->session->userdata('EmployeeId'));
        $data['TransactionRoles'] = $this->Employee_model->GetTransactionRoles($this->session->userdata('EmployeeId'));
        $data['ReportsRoles'] = $this->Employee_model->GetReportsRoles($this->session->userdata('EmployeeId'));
        $data['GetAllAccounts']=$this->AccountTransaction_model->GetAllAccounts();
        $data['GetAllBanks']=$this->AccountTransaction_model->GetAllBanks();
        $data['DebitId']=$this->AccountTransaction_model->DebitId($AccountTransactionId);
        $data['CreditId']=$this->AccountTransaction_model->CreditId($AccountTransactionId);
        $data['AccountTransaction']=$this->AccountTransaction_model->GetAccountTransaction($AccountTransactionId);
        $data['AccountTransactionDetail']=$this->AccountTransaction_model->AccountTransactionDetail($AccountTransactionId);
        
        $data['CustomerNotification'] = $this->Customer_model->GetNotifications();
        $this->load->view('accounttransaction/edit_accounttransaction',$data);
    }

    public function UpdateAccountTransaction($AccountTransactionId)
    {
        if($AccountTransactionId = $this->AccountTransaction_model->UpdateAccountTransaction($AccountTransactionId))
        {
        redirect(base_url()."AccountTransaction/ViewAccountTransaction/$AccountTransactionId");
        }
    }

        public function  AutoCompleteAccountList()
    {
        $AccountName = $this->input->post('Account');
        $query = "";
        $CompanyId = $this->session->userdata('CompanyId');

        if($CompanyId != 0){
        $query = $this->db->query("SELECT AccountId,AccountName FROM pos_accounts AS P WHERE P.AccountName LIKE '%{$AccountName}%' AND P.CompanyId = '$CompanyId' LIMIT 10 ");
        }

        $query = $this->db->query("SELECT AccountId,AccountName FROM pos_accounts AS P WHERE P.AccountName LIKE '%{$AccountName}%' LIMIT 10");
            
        $AccountList = array();
        foreach ($query->result_array() as $key) 
        {
        if($key['AccountName'] != '' || $key['AccountName'] != null )
        {
        $AccountName = '-'.$key['AccountName'];
        }
        
        $bn = array(
        'id' => trim($key['AccountId']),
        'value' => trim($key['AccountName'])
        );
        $AccountList[] = $bn;
        }
        echo json_encode($AccountList);
    }

    public function  AutoCompleteCredit()
    {
                  
        $AccountName = $this->input->post('Account');
        $query = "";
        $CompanyId = $this->session->userdata('CompanyId');

        if($CompanyId != 0){
        $query = $this->db->query("SELECT AccountId,AccountName FROM pos_accounts AS P WHERE P.AccountName LIKE '%{$AccountName}%' AND P.CompanyId = '$CompanyId' LIMIT 10 ");
        }

        $query = $this->db->query("SELECT AccountId,AccountName FROM pos_accounts AS P WHERE P.AccountName LIKE '%{$AccountName}%' LIMIT 10");
            
        $AccountList = array();
        foreach ($query->result_array() as $key) 
        {
        if($key['AccountName'] != '' || $key['AccountName'] != null )
        {
        $AccountName = '-'.$key['AccountName'];
        }
        
        $bn = array(
        'id' => trim($key['AccountId']),
        'value' => trim($key['AccountName'])
        );
        $AccountList[] = $bn;
        }
        echo json_encode($AccountList);
        }


}