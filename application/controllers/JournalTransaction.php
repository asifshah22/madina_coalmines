<?php defined('BASEPATH') OR exit('No direct script access allowed');

class JournalTransaction extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		
		$this->check_isvalidated();
		$this->load->model('JournalTransaction_model');
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
            redirect('Login'); 
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
        $data['GetAllAccounts']=$this->JournalTransaction_model->GetAllAccounts();
        $data['GetAllJournalTransaction']=$this->JournalTransaction_model->JournalTransaction();
        $data['CustomerNotification'] = $this->Customer_model->GetNotifications();
        $this->load->view('journaltransaction/journaltransactions',$data);
    }


    public function AddJournalTransaction()
    {
        $data['AdministrationRoles'] = $this->Employee_model->GetAdministrationRoles($this->session->userdata('EmployeeId'));
        $data['SalesRoles'] = $this->Employee_model->GetSalesRoles($this->session->userdata('EmployeeId'));
        $data['PurchasesRoles'] = $this->Employee_model->GetPurchasesRoles($this->session->userdata('EmployeeId'));
	    $data['RegistrationRoles'] = $this->Employee_model->GetRegistrationRoles($this->session->userdata('EmployeeId'));
        $data['TransactionRoles'] = $this->Employee_model->GetTransactionRoles($this->session->userdata('EmployeeId'));
        $data['ReportsRoles'] = $this->Employee_model->GetReportsRoles($this->session->userdata('EmployeeId'));
        $data['GetAllAccounts']=$this->JournalTransaction_model->GetAllAccounts();
        $data['GetAllBanks']=$this->JournalTransaction_model->GetAllBanks();
        $data['GetAllCompanies']=$this->Company_model->GetAllCompanies();
        $data['CustomerNotification'] = $this->Customer_model->GetNotifications();
        $this->load->view('journaltransaction/add_journal',$data);
    }


    public function ViewJournalTransaction($VoucherId)
    {
        $data['Roles'] = $this->Employee_model->GetRoles();
        $data['AdministrationRoles'] = $this->Employee_model->GetAdministrationRoles($this->session->userdata('EmployeeId'));
        $data['SalesRoles'] = $this->Employee_model->GetSalesRoles($this->session->userdata('EmployeeId'));
        $data['PurchasesRoles'] = $this->Employee_model->GetPurchasesRoles($this->session->userdata('EmployeeId'));
	    $data['RegistrationRoles'] = $this->Employee_model->GetRegistrationRoles($this->session->userdata('EmployeeId'));
        $data['TransactionRoles'] = $this->Employee_model->GetTransactionRoles($this->session->userdata('EmployeeId'));
        $data['ReportsRoles'] = $this->Employee_model->GetReportsRoles($this->session->userdata('EmployeeId'));
        $data['GetAllAccounts']=$this->JournalTransaction_model->GetAllAccounts();
        $data['GetAllBanks']=$this->JournalTransaction_model->GetAllBanks();
        $data['GetDebit']=$this->JournalTransaction_model->GetDebit($VoucherId);
        $data['GetCredit']=$this->JournalTransaction_model->GetCredit($VoucherId);
        $data['JournalTransaction']=$this->JournalTransaction_model->GetJournalTransaction($VoucherId);
        $data['JournalTransactionDetail']=$this->JournalTransaction_model->JournalTransactionDetail($VoucherId);
        $data['CustomerNotification'] = $this->Customer_model->GetNotifications();
        if(!$data['JournalTransaction']){
          redirect('JournalTransaction');
        }
        $this->load->view('journaltransaction/view_journal',$data);
    }


    public function SaveJournalTransaction()
	{
        if($LastJournalId = $this->JournalTransaction_model->SaveJournalVoucher())
        {
        $this->session->set_flashdata('messag_accounts','Account Information Added sucessfuly..!');
        redirect("JournalTransaction/ViewJournalTransaction/$LastJournalId");
        }

    }


    public function EditJournalTransaction($VoucherId)
    {
        $data['Roles'] = $this->Employee_model->GetRoles();
        $data['AdministrationRoles'] = $this->Employee_model->GetAdministrationRoles($this->session->userdata('EmployeeId'));
        $data['SalesRoles'] = $this->Employee_model->GetSalesRoles($this->session->userdata('EmployeeId'));
        $data['PurchasesRoles'] = $this->Employee_model->GetPurchasesRoles($this->session->userdata('EmployeeId'));
        $data['RegistrationRoles'] = $this->Employee_model->GetRegistrationRoles($this->session->userdata('EmployeeId'));
        $data['TransactionRoles'] = $this->Employee_model->GetTransactionRoles($this->session->userdata('EmployeeId'));
        $data['ReportsRoles'] = $this->Employee_model->GetReportsRoles($this->session->userdata('EmployeeId'));
        $data['GetAllAccounts']=$this->JournalTransaction_model->GetAllAccounts();
        $data['GetAllBanks']=$this->JournalTransaction_model->GetAllBanks();
        $data['GetDebit']=$this->JournalTransaction_model->GetDebit($VoucherId);
        $data['GetCredit']=$this->JournalTransaction_model->GetCredit($VoucherId);
        $data['JournalTransaction']=$this->JournalTransaction_model->GetJournalTransaction($VoucherId);
        $data['JournalTransactionDetail']=$this->JournalTransaction_model->JournalTransactionDetail($VoucherId);
        $data['CustomerNotification'] = $this->Customer_model->GetNotifications();
        $this->load->view('journaltransaction/edit_journal',$data);
    }

    public function UpdateJournalTransaction($VoucherId)
    {
        if($VoucherId = $this->JournalTransaction_model->UpdateJournalVoucher($VoucherId))
        {
        redirect(base_url()."JournalTransaction/ViewJournalTransaction/$VoucherId");
        }
    }


    public function DeleteJournalTransaction($JournalTransactionId)
    {
        if($this->JournalTransaction_model->DeleteJournalTransaction($JournalTransactionId))
        {
        $this->session->set_flashdata('messag_accounts','Account Information Added sucessfuly..!');
        redirect("JournalTransaction");
        }

    }

        public function  AutoCompleteAccountList()
    {
                  
        $AccountName = $this->input->post('DebitAccount');
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

    public function  AutoCompleteCreditAccount()
    {
                  
        $AccountName = $this->input->post('CreditAccount');
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