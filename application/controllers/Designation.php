<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Designation extends CI_Controller {

	public function __construct()
	{
        parent::__construct();
        $this->check_isvalidated();
        $this->load->model('Designation_model');
        $this->load->model('Employee_model');
        $this->load->model('Customer_model');
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
	    $data['EmployeeRoles'] = $this->Employee_model->GetEmployeeRoles($this->session->userdata('EmployeeId'));
	    $data['AdministrationRoles'] = $this->Employee_model->GetAdministrationRoles($this->session->userdata('EmployeeId'));
	    $data['SalesRoles'] = $this->Employee_model->GetSalesRoles($this->session->userdata('EmployeeId'));
	    $data['PurchasesRoles'] = $this->Employee_model->GetPurchasesRoles($this->session->userdata('EmployeeId'));
	    $data['RegistrationRoles'] = $this->Employee_model->GetRegistrationRoles($this->session->userdata('EmployeeId'));
	    $data['TransactionRoles'] = $this->Employee_model->GetTransactionRoles($this->session->userdata('EmployeeId'));
	    $data['ReportsRoles'] = $this->Employee_model->GetReportsRoles($this->session->userdata('EmployeeId'));
	    $data['CustomerNotification'] = $this->Customer_model->GetNotifications();
//	    $data['AllDesignations']=$this->Designation_model->GetAllDesignations();
	    $this->load->view('designation/designations',$data);
	}


	public function Ajax_GetAllDesignations()
	{
		$AdministrationRoles = $this->Employee_model->GetAdministrationRoles($this->session->userdata('EmployeeId'));
        $GetAllDesignations=$this->Designation_model->Ajax_GetAllDesignations($_REQUEST);

        $ViewRecord = '<span style="color:#00a65a;" class="glyphicon glyphicon-th-large"></span>';
        $UpdateRecord = '<span style="color:#0c6aad;" class="fa fa-edit">';

            $data = array();
            foreach($GetAllDesignations['record'] as $row)
            {
                $nestedData=array(); 
                $nestedData[] = $row["DesignationName"];
//                $nestedData[] = $row["DesignationStatus"];
                $id = $row["DesignationId"];
                if ($AdministrationRoles[4]['ViewRoles']==1 && $AdministrationRoles[4]['UpdateRoles']==1) {
					$nestedData[] = '<a href="'.base_url().'Designation/ViewDesignation/'.$id.'" title="View Record">'.$ViewRecord.'</a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="'.base_url().'Designation/EditDesignation/'.$id.'"title="Update Record"><span style="color:#0c6aad;" class="fa fa-edit"></span></a>';
				}
				else{
				$nestedData[] = '<a href="'.base_url().'Designation/ViewDesignation/'.$id.'" title="View Record">'.$ViewRecord.'</a>';
				}
                $data[] = $nestedData;
            }

                $json_data = array(
			"draw" => intval( $_REQUEST['draw'] ),   // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw. 
			"recordsTotal"    => intval( $GetAllDesignations['recordsTotal'] ),  // total number of records
			"recordsFiltered" => intval( $GetAllDesignations['recordsFiltered'] ), // total number of records after searching, if there is no searching then totalFiltered = totalData
			"data" => $data   // total data array
			);
                echo json_encode($json_data);  // send data as json format
        }
	
	public function AddDesignation()
	{
        $data['AdministrationRoles'] = $this->Employee_model->GetAdministrationRoles($this->session->userdata('EmployeeId'));
        $data['SalesRoles'] = $this->Employee_model->GetSalesRoles($this->session->userdata('EmployeeId'));
        $data['PurchasesRoles'] = $this->Employee_model->GetPurchasesRoles($this->session->userdata('EmployeeId'));
        $data['RegistrationRoles'] = $this->Employee_model->GetRegistrationRoles($this->session->userdata('EmployeeId'));
	    $data['TransactionRoles'] = $this->Employee_model->GetTransactionRoles($this->session->userdata('EmployeeId'));
        $data['ReportsRoles'] = $this->Employee_model->GetReportsRoles($this->session->userdata('EmployeeId'));
        $data['CustomerNotification'] = $this->Customer_model->GetNotifications();
        $this->load->view('designation/add_designation', $data);
	}
	
	
	public function ViewDesignation($DesignationId)
	{
	   
            $data['Roles'] = $this->Employee_model->GetRoles();
            $data['AdministrationRoles'] = $this->Employee_model->GetAdministrationRoles($this->session->userdata('EmployeeId'));
            $data['SalesRoles'] = $this->Employee_model->GetSalesRoles($this->session->userdata('EmployeeId'));
            $data['PurchasesRoles'] = $this->Employee_model->GetPurchasesRoles($this->session->userdata('EmployeeId'));
            $data['RegistrationRoles'] = $this->Employee_model->GetRegistrationRoles($this->session->userdata('EmployeeId'));
	    $data['TransactionRoles'] = $this->Employee_model->GetTransactionRoles($this->session->userdata('EmployeeId'));
            $data['ReportsRoles'] = $this->Employee_model->GetReportsRoles($this->session->userdata('EmployeeId'));
            $data['GetDesignation'] = $this->Designation_model->GetDesignation($DesignationId);
            $data['CustomerNotification'] = $this->Customer_model->GetNotifications();
            $this->load->view('designation/view_designation',$data);
	}
	
    
	public function EditDesignation($DesignationId)
	{
            $data['AdministrationRoles'] = $this->Employee_model->GetAdministrationRoles($this->session->userdata('EmployeeId'));
            $data['SalesRoles'] = $this->Employee_model->GetSalesRoles($this->session->userdata('EmployeeId'));
            $data['PurchasesRoles'] = $this->Employee_model->GetPurchasesRoles($this->session->userdata('EmployeeId'));
            $data['RegistrationRoles'] = $this->Employee_model->GetRegistrationRoles($this->session->userdata('EmployeeId'));
	    $data['TransactionRoles'] = $this->Employee_model->GetTransactionRoles($this->session->userdata('EmployeeId'));
            $data['ReportsRoles'] = $this->Employee_model->GetReportsRoles($this->session->userdata('EmployeeId'));
            $data['GetDesignation'] = $this->Designation_model->GetDesignation($DesignationId);
            $data['CustomerNotification'] = $this->Customer_model->GetNotifications();
            $this->load->view('designation/edit_designation',$data);
	}	
        
   
	public function SaveDesignation()
	{	
	    $DesignationId = $this->Designation_model->SaveDesignationDetail();         
	    $this->session->set_flashdata("record_added","Record added successfully."); 
	    redirect("Designation/ViewDesignation/$DesignationId");
	}
        
    
	public function UpdateDesignatio__n($DesignationId)
	{	
	    $DesignationId = $this->input->post('DesignationId');
	    $Record = array(
	    	'DesignationId' => $this->input->post('DesignationId'),
            'DesignationName' => $this->input->post('DesignationName'),
            'AddedOn' => $this->input->post('AddedOn'),
        );
	    if($this->Designation_model->UpdateDesignation($Record, $DesignationId))
	    {
		$this->session->set_flashdata("record_update","Record update successfully."); 
		redirect("Designation");
	    }
	}
	

	public function UpdateDesignation($DesignationId)
	{   
	    if($this->Designation_model->UpdateDesignationDetail($DesignationId))
	    {
		$this->session->set_flashdata("record_update","Record update successfully."); 
		redirect("Designation/ViewDesignation/$DesignationId");
	    }
	}        
        

        public function DeleteDesignation($DesignationId)
        {
           if ($this->Designation_model->DeleteDesignation($DesignationId)) {
           $this->session->set_flashdata("record_deleted","Record deleted successfully."); 
           redirect("Designation");
            }
        }
}

?>