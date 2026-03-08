<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Setting extends CI_Controller {

  public function __construct()
  {
            parent::__construct();
            $this->check_isvalidated();
            $this->load->model('Setting_model');
            $this->load->model('Employee_model');
            $this->load->model('Company_model');
            $this->load->model('Accounts_model');
            $this->load->model('COA_model');
            $this->load->model('Customer_model');
     //$this->output->enable_profiler(true);
  }
  
  
        private function check_isvalidated()
  {
            if(!$this->session->userdata('EmployeeId'))
            { $this->session->set_userdata('url',  current_url()); redirect('Login'); }
  }

  
        public function index()
  {
            $data['AdministrationRoles'] = $this->Employee_model->GetAdministrationRoles($this->session->userdata('EmployeeId'));
            $data['SalesRoles'] = $this->Employee_model->GetSalesRoles($this->session->userdata('EmployeeId'));
            $data['PurchasesRoles'] = $this->Employee_model->GetPurchasesRoles($this->session->userdata('EmployeeId'));
            $data['RegistrationRoles'] = $this->Employee_model->GetRegistrationRoles($this->session->userdata('EmployeeId'));
            $data['TransactionRoles'] = $this->Employee_model->GetTransactionRoles($this->session->userdata('EmployeeId'));
            $data['ReportsRoles'] = $this->Employee_model->GetReportsRoles($this->session->userdata('EmployeeId'));
            $data['GetSetting']=$this->Setting_model->GetSetting($SettingId=1);
            $data['CustomerNotification'] = $this->Customer_model->GetNotifications();
            $this->load->view('setting/edit_setting',$data);
  }

      
  public function AddSetting()
  {
      
      $data['AdministrationRoles'] = $this->Employee_model->GetAdministrationRoles($this->session->userdata('EmployeeId'));
      $data['SalesRoles'] = $this->Employee_model->GetSalesRoles($this->session->userdata('EmployeeId'));
      $data['PurchasesRoles'] = $this->Employee_model->GetPurchasesRoles($this->session->userdata('EmployeeId'));
      $data['RegistrationRoles'] = $this->Employee_model->GetRegistrationRoles($this->session->userdata('EmployeeId'));
      $data['TransactionRoles'] = $this->Employee_model->GetTransactionRoles($this->session->userdata('EmployeeId'));
      $data['ReportsRoles'] = $this->Employee_model->GetReportsRoles($this->session->userdata('EmployeeId'));
      $data['GetAllCompanies']=$this->Company_model->GetAllCompanies();
      $data['GetAllChartOfAccount']=$this->COA_model->GetAllChartOfAccount();
      $data['GetAllControlCodes']=$this->COA_model->GetAllControlCodes();
      $data['CustomerNotification'] = $this->Customer_model->GetNotifications();
      $this->load->view('setting/add_setting', $data);
  
  }
          
  public function ViewSetting($SettingId)
  {
      $data['AdministrationRoles'] = $this->Employee_model->GetAdministrationRoles($this->session->userdata('EmployeeId'));
      $data['SalesRoles'] = $this->Employee_model->GetSalesRoles($this->session->userdata('EmployeeId'));
      $data['PurchasesRoles'] = $this->Employee_model->GetPurchasesRoles($this->session->userdata('EmployeeId'));
      $data['RegistrationRoles'] = $this->Employee_model->GetRegistrationRoles($this->session->userdata('EmployeeId'));
      $data['TransactionRoles'] = $this->Employee_model->GetTransactionRoles($this->session->userdata('EmployeeId'));
      $data['ReportsRoles'] = $this->Employee_model->GetReportsRoles($this->session->userdata('EmployeeId'));
      $data['GetSetting']=$this->Setting_model->GetSetting($SettingId);
      $data['CustomerNotification'] = $this->Customer_model->GetNotifications();
      $this->load->view('setting/view_setting',$data);
  }
        
  public function EditSetting($SettingId)
  {
      $data['AdministrationRoles'] = $this->Employee_model->GetAdministrationRoles($this->session->userdata('EmployeeId'));
      $data['SalesRoles'] = $this->Employee_model->GetSalesRoles($this->session->userdata('EmployeeId'));
      $data['PurchasesRoles'] = $this->Employee_model->GetPurchasesRoles($this->session->userdata('EmployeeId'));
      $data['RegistrationRoles'] = $this->Employee_model->GetRegistrationRoles($this->session->userdata('EmployeeId'));
   $data['TransactionRoles'] = $this->Employee_model->GetTransactionRoles($this->session->userdata('EmployeeId'));
      $data['ReportsRoles'] = $this->Employee_model->GetReportsRoles($this->session->userdata('EmployeeId'));
      $data['GetAllCompanies']=$this->Company_model->GetAllCompanies();
      $data['GetAllChartOfAccount']=$this->COA_model->GetAllChartOfAccount();
      $data['GetAllControlCodes']=$this->COA_model->GetAllControlCodes();
      $data['GetSetting']=$this->Setting_model->GetSetting($SettingId);
      $data['CustomerNotification'] = $this->Customer_model->GetNotifications();
      $this->load->view('setting/edit_setting',$data);
  }
  
    public function SaveSetting()
  {
        $data=$this->input->post();
        $data['AddedOn'] = date('Y-m-d H:i:s');
        $data['AddedBy'] = $this->session->userdata('EmployeeId');
        if($LastSettingId = $this->Setting_model->SaveSetting($data))
        {
        $this->session->set_flashdata("record_added","Record added successfully."); 
        redirect("Setting/ViewSetting/$LastSettingId");
        }
  }
  
        
    public function UpdateSetting($SettingId)
  {
//        $data=$this->input->post();
    $data = array(
      'CompanyName' => $this->input->post('CompanyName'),
      'ContactPerson' => $this->input->post('ContactPerson'),
      'ContactNumber' => $this->input->post('ContactNumber'),
      'Email' => $this->input->post('Email'),
      'Address' => $this->input->post('Address'),
       'signature' => $this->input->post('signature'),
      
      'ProductsDeals' => $this->input->post('ProductsDeals'),
    );
        $data['AddedOn'] = date('Y-m-d H:i:s');
        $data['AddedBy'] = $this->session->userdata('EmployeeId');

        if($this->Setting_model->UpdateSetting($data,$SettingId))
        {
          $this->session->set_flashdata("record_update","Record update successfully."); 
          redirect("Setting");
        }
  }

  
  public function DeleteSetting($SettingId)
  {
    if($this->Setting_model->DeleteSetting($SettingId))
    {
        $this->session->set_flashdata("record_deleted","Record deleted successfully."); 
        redirect("Setting");
    }
  }

}

?>