<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Company extends CI_Controller {

	public function __construct()
	{
            parent::__construct();
            $this->check_isvalidated();
            $this->load->model('Company_model');
            $this->load->model('Employee_model');
            $this->load->model('Customer_model');
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
        $data['CustomerNotification'] = $this->Customer_model->GetNotifications();
//            $data['Company']=$this->Company_model->GetAllCompanies();
            $this->load->view('company/companies',$data);
	}

    public function Ajax_GetAllCompanies()
    {
        $AdministrationRoles = $this->Employee_model->GetAdministrationRoles($this->session->userdata('EmployeeId'));
        $GetAllCompanies=$this->Company_model->Ajax_GetAllCompanies($_REQUEST);

        $ViewRecord = '<span style="color:#00a65a;" class="glyphicon glyphicon-th-large"></span>';
        $UpdateRecord = '<span style="color:#0c6aad;" class="fa fa-edit">';

            $data = array();
            foreach($GetAllCompanies['record'] as $row)
            {
                $nestedData=array(); 
                $nestedData[] = $row["CompanyName"];
                $nestedData[] = $row["Address"];
                $nestedData[] = $row["NTN"];
                $nestedData[] = $row["FaxNo"];
                $nestedData[] = $row["Website"];
                $nestedData[] = $row["CompanyWarranty"];
                $id = $row["CompanyId"];
                if ($AdministrationRoles[6]['ViewRoles']==1 && $AdministrationRoles[6]['UpdateRoles']==1) {
                    $nestedData[] = '<a href="'.base_url().'Company/ViewCompany/'.$id.'" title="View Record">'.$ViewRecord.'</a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="'.base_url().'Company/EditCompany/'.$id.'"title="Update Record"><span style="color:#0c6aad;" class="fa fa-edit"></span></a>';}
                else{
                    $nestedData[] = '<a href="'.base_url().'Company/ViewCompany/'.$id.'" title="View Record">'.$ViewRecord.'</a>';
                }
            
                $data[] = $nestedData;
            }

                $json_data = array(
            "draw" => intval( $_REQUEST['draw'] ),   // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw. 
            "recordsTotal"    => intval( $GetAllCompanies['recordsTotal'] ),  // total number of records
            "recordsFiltered" => intval( $GetAllCompanies['recordsFiltered'] ), // total number of records after searching, if there is no searching then totalFiltered = totalData
            "data" => $data   // total data array
            );
                echo json_encode($json_data);  // send data as json format
        }
        
	public function AddCompany()
	{
           $data['AdministrationRoles'] = $this->Employee_model->GetAdministrationRoles($this->session->userdata('EmployeeId'));
           $data['SalesRoles'] = $this->Employee_model->GetSalesRoles($this->session->userdata('EmployeeId'));
           $data['PurchasesRoles'] = $this->Employee_model->GetPurchasesRoles($this->session->userdata('EmployeeId'));
           $data['RegistrationRoles'] = $this->Employee_model->GetRegistrationRoles($this->session->userdata('EmployeeId'));
	   $data['TransactionRoles'] = $this->Employee_model->GetTransactionRoles($this->session->userdata('EmployeeId'));
           $data['ReportsRoles'] = $this->Employee_model->GetReportsRoles($this->session->userdata('EmployeeId'));
           $data['CustomerNotification'] = $this->Customer_model->GetNotifications();
           $this->load->view('company/add_company', $data);
	}
	        
        public function ViewCompany($CompanyId)
	{
            $data['AdministrationRoles'] = $this->Employee_model->GetAdministrationRoles($this->session->userdata('EmployeeId'));
            $data['SalesRoles'] = $this->Employee_model->GetSalesRoles($this->session->userdata('EmployeeId'));
            $data['PurchasesRoles'] = $this->Employee_model->GetPurchasesRoles($this->session->userdata('EmployeeId'));
            $data['RegistrationRoles'] = $this->Employee_model->GetRegistrationRoles($this->session->userdata('EmployeeId'));
	    $data['TransactionRoles'] = $this->Employee_model->GetTransactionRoles($this->session->userdata('EmployeeId'));
            $data['ReportsRoles'] = $this->Employee_model->GetReportsRoles($this->session->userdata('EmployeeId'));
            $data['GetCompany']=$this->Company_model->GetCompany($CompanyId);
            $data['CustomerNotification'] = $this->Customer_model->GetNotifications();
            $this->load->view('company/view_company',$data);
	}
        
        public function EditCompany($CompanyId)
	{
            $data['AdministrationRoles'] = $this->Employee_model->GetAdministrationRoles($this->session->userdata('EmployeeId'));
            $data['SalesRoles'] = $this->Employee_model->GetSalesRoles($this->session->userdata('EmployeeId'));
            $data['PurchasesRoles'] = $this->Employee_model->GetPurchasesRoles($this->session->userdata('EmployeeId'));
            $data['RegistrationRoles'] = $this->Employee_model->GetRegistrationRoles($this->session->userdata('EmployeeId'));
	    $data['TransactionRoles'] = $this->Employee_model->GetTransactionRoles($this->session->userdata('EmployeeId'));
            $data['ReportsRoles'] = $this->Employee_model->GetReportsRoles($this->session->userdata('EmployeeId'));
            $data['GetCompany']=$this->Company_model->GetCompany($CompanyId);
            $data['CustomerNotification'] = $this->Customer_model->GetNotifications();
            $this->load->view('company/edit_company',$data);
	}
	
    public function SaveCompany()
	{	
        $data=$this->input->post();
        if($LastCompanyId = $this->Company_model->SaveCompany($data))
        {
		$this->session->set_flashdata("record_added","Record added successfully."); 
        redirect("Company/ViewCompany/$LastCompanyId");
        }
	}
	
        
    public function UpdateCompany($CompanyId)
	{
//            $data=$this->input->post();
        $data = array(
            'CompanyName' => $this->input->post('CompanyName'),
            'Address' => $this->input->post('Address'),
            'NTN' => $this->input->post('NTN'),
            'FaxNo' => $this->input->post('FaxNo'),
            'Website' => $this->input->post('Website'),
            'CompanyWarranty' => $this->input->post('CompanyWarranty'),
        );
            if($this->Company_model->UpdateCompany($data,$CompanyId))
            {
               $this->session->set_flashdata("record_update","Record update successfully."); 
               redirect("Company/ViewCompany/$CompanyId");
            }
	}

	
	public function DeleteCompany($CompanyId)
	{
	    if($this->Company_model->DeleteCompany($CompanyId))
            {
               $this->session->set_flashdata("record_deleted","Record deleted successfully."); 
               redirect("Company");
            }
	}
}

?>