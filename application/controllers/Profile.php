<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Profile extends CI_Controller {

	public function __construct()
	{
            parent::__construct();
            $this->check_isvalidated();
            $this->load->model('Profile_model');
            $this->load->model('Employee_model');
            $this->load->model('Customer_model');
            //$this->load->model(array('employee_model','office_model'));
	}
	
	private function check_isvalidated()
	{
            if(!$this->session->userdata('EmployeeId'))
            { 
               $this->session->set_userdata('url',  current_url());
               redirect("Login"); 
            }
	}

	public function index()
	{
            $EmployeeId = $this->session->userdata('EmployeeId');
            $data['AdministrationRoles'] = $this->Employee_model->GetAdministrationRoles($this->session->userdata('EmployeeId'));
            $data['SalesRoles'] = $this->Employee_model->GetSalesRoles($this->session->userdata('EmployeeId'));
            $data['PurchasesRoles'] = $this->Employee_model->GetPurchasesRoles($this->session->userdata('EmployeeId'));
            $data['RegistrationRoles'] = $this->Employee_model->GetRegistrationRoles($this->session->userdata('EmployeeId'));
            $data['TransactionRoles'] = $this->Employee_model->GetTransactionRoles($this->session->userdata('EmployeeId'));
            $data['ReportsRoles'] = $this->Employee_model->GetReportsRoles($this->session->userdata('EmployeeId'));
            $data['GetProfile']=$this->Profile_model->GetEmployee($EmployeeId);
            $data['CustomerNotification'] = $this->Customer_model->GetNotifications();
            $this->load->view('admin/profile/profile', $data);
	}


    public function UpdateProfile($EmployeeId)
    {
        $data = $this->input->post();
        /*$EmployeeId = $this->session->userdata('EmployeeId');
        $Record = array(
            'EmployeeName' => $this->input->post('EmployeeName'),
            'EmailAddress' => $this->input->post('EmailAddress'),
            'Password' => $this->input->post('Password'),
            'DesignationId' => $this->input->post('DesignationId'),
            'CompanyId' => $this->input->post('CompanyId'),
            'Gender' => $this->input->post('Gender'),
            'CellNo' => $this->input->post('CellNo'),
            'OtherContactNumber' => $this->input->post('OtherContactNumber'),
            'JoiningDate' => $this->input->post('JoiningDate'),
            'HomeAddress' => $this->input->post('HomeAddress'),
            'EmployeeType' => $this->input->post('EmployeeType'),
            'AddedBy' => $this->input->post('AddedBy'),
             );
        */
        if($this->Profile_model->UpdateProfile($EmployeeId, $data)){
            redirect('Profile');
        }

    }

    public function UpdatePassword($EmployeeId)
    {
        $Password = $this->input->post('Password');
        $this->Profile_model->UpdatePassword($EmployeeId, $Password);
    }

}

?>