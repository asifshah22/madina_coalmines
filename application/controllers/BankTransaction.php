<?php defined('BASEPATH') OR exit('No direct script access allowed');

class BankTransaction extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		
		$this->check_isvalidated();
		$this->load->model('BankTransaction_model');
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
        $data['GetAllAccounts']=$this->BankTransaction_model->GetAllAccounts();
        $data['BankVoucher']=$this->BankTransaction_model->BankVoucher();
        $data['CustomerNotification'] = $this->Customer_model->GetNotifications();
        
        $this->load->view('bankvoucher/bankvouchers',$data);
    }


    public function AddBankTransaction()
    {
        $data['AdministrationRoles'] = $this->Employee_model->GetAdministrationRoles($this->session->userdata('EmployeeId'));
        $data['SalesRoles'] = $this->Employee_model->GetSalesRoles($this->session->userdata('EmployeeId'));
        $data['PurchasesRoles'] = $this->Employee_model->GetPurchasesRoles($this->session->userdata('EmployeeId'));
	$data['RegistrationRoles'] = $this->Employee_model->GetRegistrationRoles($this->session->userdata('EmployeeId'));
        $data['TransactionRoles'] = $this->Employee_model->GetTransactionRoles($this->session->userdata('EmployeeId'));
        $data['ReportsRoles'] = $this->Employee_model->GetReportsRoles($this->session->userdata('EmployeeId'));
        $data['GetAllAccounts']=$this->BankTransaction_model->GetAllAccounts();
        $data['GetAllBanks']=$this->BankTransaction_model->GetAllBanks();
        $data['GetAllCompanies']=$this->Company_model->GetAllCompanies();
        $data['CustomerNotification'] = $this->Customer_model->GetNotifications();
        
        $this->load->view('bankvoucher/add_voucher',$data);
    }


    public function ViewBankTransaction($VoucherId)
    {
        $data['Roles'] = $this->Employee_model->GetRoles();
        $data['AdministrationRoles'] = $this->Employee_model->GetAdministrationRoles($this->session->userdata('EmployeeId'));
        $data['SalesRoles'] = $this->Employee_model->GetSalesRoles($this->session->userdata('EmployeeId'));
        $data['PurchasesRoles'] = $this->Employee_model->GetPurchasesRoles($this->session->userdata('EmployeeId'));
	$data['RegistrationRoles'] = $this->Employee_model->GetRegistrationRoles($this->session->userdata('EmployeeId'));
        $data['TransactionRoles'] = $this->Employee_model->GetTransactionRoles($this->session->userdata('EmployeeId'));
        $data['ReportsRoles'] = $this->Employee_model->GetReportsRoles($this->session->userdata('EmployeeId'));
        $data['GetAllAccounts']=$this->BankTransaction_model->GetAllAccounts();
        $data['GetAllBanks']=$this->BankTransaction_model->GetAllBanks();
        $data['GetFrom']=$this->BankTransaction_model->GetFrom($VoucherId);
        $data['GetTo']=$this->BankTransaction_model->GetTo($VoucherId);
        $data['BankTransaction']=$this->BankTransaction_model->GetBankTransaction($VoucherId);
        $data['BankTransactionDetail']=$this->BankTransaction_model->BankTransactionDetail($VoucherId);
        $data['CustomerNotification'] = $this->Customer_model->GetNotifications();
        if(!$data['BankTransaction']){
          redirect('BankTransaction');
        }
        $this->load->view('bankvoucher/view_voucher',$data);
    }


    public function SaveBankTransaction()
	{
        if($LastVoucherId = $this->BankTransaction_model->SaveVoucher())
        {
        $this->session->set_flashdata('messag_accounts','Account Information Added sucessfuly..!');
        redirect("BankTransaction/ViewBankTransaction/$LastVoucherId");
        }

    }


    public function EditBankTransaction($VoucherId)
    {
        $data['Roles'] = $this->Employee_model->GetRoles();
        $data['AdministrationRoles'] = $this->Employee_model->GetAdministrationRoles($this->session->userdata('EmployeeId'));
        $data['SalesRoles'] = $this->Employee_model->GetSalesRoles($this->session->userdata('EmployeeId'));
        $data['PurchasesRoles'] = $this->Employee_model->GetPurchasesRoles($this->session->userdata('EmployeeId'));
	    $data['RegistrationRoles'] = $this->Employee_model->GetRegistrationRoles($this->session->userdata('EmployeeId'));
        $data['TransactionRoles'] = $this->Employee_model->GetTransactionRoles($this->session->userdata('EmployeeId'));
        $data['ReportsRoles'] = $this->Employee_model->GetReportsRoles($this->session->userdata('EmployeeId'));
        $data['GetAllAccounts']=$this->BankTransaction_model->GetAllAccounts();
        $data['GetAllBanks']=$this->BankTransaction_model->GetAllBanks();
        $data['GetFrom']=$this->BankTransaction_model->GetFrom($VoucherId);
        $data['GetTo']=$this->BankTransaction_model->GetTo($VoucherId);
        $data['BankTransaction']=$this->BankTransaction_model->GetBankTransaction($VoucherId);
        $data['BankTransactionDetail']=$this->BankTransaction_model->BankTransactionDetail($VoucherId);
        $data['CustomerNotification'] = $this->Customer_model->GetNotifications();
        $this->load->view('bankvoucher/edit_voucher',$data);
    }

    public function UpdateBankTransaction($VoucherId)
    {
        if($VoucherId = $this->BankTransaction_model->UpdateVoucher($VoucherId))
        {
        redirect(base_url()."BankTransaction/ViewBankTransaction/$VoucherId");
        }
    }

        public function  AutoCompleteAccountList()
    {
                  
        $AccountName = $this->input->post('PaymentFrom');
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

    public function  AutoCompletePaymentTo()
    {
                  
        $AccountName = $this->input->post('PaymentToId');
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