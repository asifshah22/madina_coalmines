<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Account extends CI_Controller {

	public function __construct()
	{
	    parent::__construct();
	    $this->check_isvalidated();
	    $this->load->model('Employee_model');
	    $this->load->model('Company_model');
	    $this->load->model('Accounts_model');
	    $this->load->model('Customer_model');
	}
	
	
	private function check_isvalidated()
	{
	    if(!$this->session->has_userdata('EmployeeId'))
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
            $data['GetAllAccounts'] = $this->Accounts_model->GetAllAccounts();
            $data['TotalRecord'] = $this->Accounts_model->TotalRecord();
            
            $data['CustomerNotification'] = $this->Customer_model->GetNotifications();
            $this->load->view('account/accounts',$data);
	}
        
	
	public function ViewAccount($AccountId)
	{
            $data['AdministrationRoles'] = $this->Employee_model->GetAdministrationRoles($this->session->userdata('EmployeeId'));
            $data['SalesRoles'] = $this->Employee_model->GetSalesRoles($this->session->userdata('EmployeeId'));
            $data['PurchasesRoles'] = $this->Employee_model->GetPurchasesRoles($this->session->userdata('EmployeeId'));
            $data['RegistrationRoles'] = $this->Employee_model->GetRegistrationRoles($this->session->userdata('EmployeeId'));
	    $data['TransactionRoles'] = $this->Employee_model->GetTransactionRoles($this->session->userdata('EmployeeId'));
            $data['ReportsRoles'] = $this->Employee_model->GetReportsRoles($this->session->userdata('EmployeeId'));
            $data['GetAccounts']=$this->Accounts_model->GetAccounts($AccountId);
            
            $data['CustomerNotification'] = $this->Customer_model->GetNotifications();
            $this->load->view('account/view_account',$data);
	}
        
	
	 public function AddAccount()
	 {
            $data['AdministrationRoles'] = $this->Employee_model->GetAdministrationRoles($this->session->userdata('EmployeeId'));
            $data['SalesRoles'] = $this->Employee_model->GetSalesRoles($this->session->userdata('EmployeeId'));
            $data['PurchasesRoles'] = $this->Employee_model->GetPurchasesRoles($this->session->userdata('EmployeeId'));
            $data['RegistrationRoles'] = $this->Employee_model->GetRegistrationRoles($this->session->userdata('EmployeeId'));
	    $data['TransactionRoles'] = $this->Employee_model->GetTransactionRoles($this->session->userdata('EmployeeId'));
            $data['ReportsRoles'] = $this->Employee_model->GetReportsRoles($this->session->userdata('EmployeeId'));
            $data['AccountsGroup']=$this->Accounts_model->GetAllAccountsGroup();
            
            $data['CustomerNotification'] = $this->Customer_model->GetNotifications();
	    $this->load->view('account/add_account', $data);
	 }
       
	 
	 public function EditAccount($AccountId)
         {   
            $data['AdministrationRoles'] = $this->Employee_model->GetAdministrationRoles($this->session->userdata('EmployeeId'));
            $data['SalesRoles'] = $this->Employee_model->GetSalesRoles($this->session->userdata('EmployeeId'));
            $data['PurchasesRoles'] = $this->Employee_model->GetPurchasesRoles($this->session->userdata('EmployeeId'));
            $data['RegistrationRoles'] = $this->Employee_model->GetRegistrationRoles($this->session->userdata('EmployeeId'));
	        $data['TransactionRoles'] = $this->Employee_model->GetTransactionRoles($this->session->userdata('EmployeeId'));
            $data['ReportsRoles'] = $this->Employee_model->GetReportsRoles($this->session->userdata('EmployeeId'));            
            $data['AccountsGroup'] = $this->Accounts_model->GetAllAccountsGroup();       
	        $data['GetAccounts'] = $this->Accounts_model->GetAccounts($AccountId);
	    
	        $data['CustomerNotification'] = $this->Customer_model->GetNotifications();
            $this->load->view('account/edit_account',$data);
         }
	
	 
	 public function SaveAccount()
	 {
	    if($AccountId = $this->Accounts_model->SaveAccountDetail())
	    {                  
              $this->session->set_flashdata("record_added","Record added successfully."); 
              redirect("Account/ViewAccount/$AccountId");
	     }
	 }
	
	
	public function UpdateAccount()
	{
	    $AccountId = $this->input->post('AccountId');

	    $data=$this->input->post();
	    if($AccountId = $this->Accounts_model->UpdateAccountDetail($data,$AccountId))
	    {
	    $this->session->set_flashdata("record_update","Record update successfully.");
	    redirect("Account/ViewAccount/$AccountId");
	    }   
	    else{
	    echo "no action performed";
	    }
	}
       
        public function DeleteAccount($AccountId)
        {
            if ($this->Account_model->DeleteAccount($AccountId)) {
           $this->session->set_flashdata("record_deleted","Record deleted successfully."); 
           redirect("Account");
            }
        }      
                
}

?>