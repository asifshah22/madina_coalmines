<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Location extends CI_Controller 
{

	function __construct()
	{
	    parent::__construct();
	    $this->load->helper("form");
	    $this->check_isvalidated();
	    $this->load->model('Location_model');
	    $this->load->model('Employee_model');
	    $this->load->model('Customer_model');
	    $this->load->library('session');
	}

	
	private function check_isvalidated()
	{
	    if(!$this->session->userdata('EmployeeId'))
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
	    $data['CustomerNotification'] = $this->Customer_model->GetNotifications();
	    $this->load->view('location/locations', $data);
	}

	public function Ajax_GetAllLocations()
	{
    	$AdministrationRoles = $this->Employee_model->GetAdministrationRoles($this->session->userdata('EmployeeId'));
        $GetAllLocations=$this->Location_model->Ajax_GetAllLocations($_REQUEST);

        $ViewRecord = '<span style="color:#00a65a;" class="glyphicon glyphicon-th-large"></span>';
        $UpdateRecord = '<span style="color:#0c6aad;" class="fa fa-edit">';

            $data = array();
            foreach($GetAllLocations['record'] as $row)
            {
                $nestedData=array(); 
                $nestedData[] = $row["LocationName"];
                $nestedData[] = $row["Address"];
                $nestedData[] = $row["PhoneNo"];
                $id = $row["LocationId"];
//                if ($AdministrationRoles[7]['ViewRoles']==1 && $AdministrationRoles[7]['UpdateRoles']==1) {
                    $nestedData[] = '<a href="'.base_url().'Location/ViewLocation/'.$id.'" title="View Record">'.$ViewRecord.'</a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="'.base_url().'Location/EditLocation/'.$id.'"title="Update Record"><span style="color:#0c6aad;" class="fa fa-edit"></span></a>';
/*                }
                if ($AdministrationRoles[7]['ViewRoles']==1) {
                    $nestedData[] = '<a href="'.base_url().'Location/ViewLocation/'.$id.'" title="View Record">'.$ViewRecord.'</a>';
                }*/
			
                $data[] = $nestedData;
            }

                $json_data = array(
			"draw" => intval( $_REQUEST['draw'] ),   // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw. 
			"recordsTotal"    => intval( $GetAllLocations['recordsTotal'] ),  // total number of records
			"recordsFiltered" => intval( $GetAllLocations['recordsFiltered'] ), // total number of records after searching, if there is no searching then totalFiltered = totalData
			"data" => $data   // total data array
			);
                echo json_encode($json_data);  // send data as json format
        }
	

	public function ViewLocation($LocationId)
	{
	    $data['AdministrationRoles'] = $this->Employee_model->GetAdministrationRoles($this->session->userdata('EmployeeId'));
	    $data['SalesRoles'] = $this->Employee_model->GetSalesRoles($this->session->userdata('EmployeeId'));
	    $data['PurchasesRoles'] = $this->Employee_model->GetPurchasesRoles($this->session->userdata('EmployeeId'));
	    $data['RegistrationRoles'] = $this->Employee_model->GetRegistrationRoles($this->session->userdata('EmployeeId'));
	    $data['TransactionRoles'] = $this->Employee_model->GetTransactionRoles($this->session->userdata('EmployeeId'));
	    $data['ReportsRoles'] = $this->Employee_model->GetReportsRoles($this->session->userdata('EmployeeId'));
	    $data['GetLocation']=$this->Location_model->GetLocation($LocationId);
	    $data['CustomerNotification'] = $this->Customer_model->GetNotifications();
	    $this->load->view('location/view_location',$data);
	}


	public function AddLocation()
	{
	    $data['AdministrationRoles'] = $this->Employee_model->GetAdministrationRoles($this->session->userdata('EmployeeId'));
	    $data['SalesRoles'] = $this->Employee_model->GetSalesRoles($this->session->userdata('EmployeeId'));
	    $data['PurchasesRoles'] = $this->Employee_model->GetPurchasesRoles($this->session->userdata('EmployeeId'));
	    $data['RegistrationRoles'] = $this->Employee_model->GetRegistrationRoles($this->session->userdata('EmployeeId'));
	    $data['TransactionRoles'] = $this->Employee_model->GetTransactionRoles($this->session->userdata('EmployeeId'));
	    $data['ReportsRoles'] = $this->Employee_model->GetReportsRoles($this->session->userdata('EmployeeId'));
	    $data['CustomerNotification'] = $this->Customer_model->GetNotifications();
	    $this->load->view('location/add_location', $data);
	}

	
	public function SaveLocation()
	{
	    $Record = array(
	    'LocationName' => $this->input->post('LocationName'),
	    'LocationType' => $this->input->post('LocationType'),
	    'Address' => $this->input->post('Address'),
	    'PhoneNo' => $this->input->post('PhoneNo'),
	    'AddedOn' => date("Y-m-d H:i:s"),
	    'AddedBy' => $this->session->userdata('EmployeeId'),
	    );

	    $LocationId = $this->Location_model->SaveLocationDetail($Record);
	    if(($LocationId != '') && isset($LocationId))
	    {
		$this->session->set_flashdata("record_added","Record Added successfully.");
		redirect("Location/ViewLocation/$LocationId");
	    }
	}

	
	public function EditLocation($LocationId)
	{
	    $data['AdministrationRoles'] = $this->Employee_model->GetAdministrationRoles($this->session->userdata('EmployeeId'));
	    $data['SalesRoles'] = $this->Employee_model->GetSalesRoles($this->session->userdata('EmployeeId'));
	    $data['PurchasesRoles'] = $this->Employee_model->GetPurchasesRoles($this->session->userdata('EmployeeId'));
	    $data['RegistrationRoles'] = $this->Employee_model->GetRegistrationRoles($this->session->userdata('EmployeeId'));
	    $data['TransactionRoles'] = $this->Employee_model->GetTransactionRoles($this->session->userdata('EmployeeId'));
	    $data['ReportsRoles'] = $this->Employee_model->GetReportsRoles($this->session->userdata('EmployeeId'));
	    $data['GetLocation']=$this->Location_model->GetLocation($LocationId);
	    $data['CustomerNotification'] = $this->Customer_model->GetNotifications();
	    $this->load->view('location/edit_location', $data);
	}

    
	public function UpdateLocation($LocationId)
	{	
	    $Record = array(
	    'LocationName' => $this->input->post('LocationName'),
	    'LocationType' => $this->input->post('LocationType'),
	    'Address' => $this->input->post('Address'),
	    'PhoneNo' => $this->input->post('PhoneNo'),
	    'AddedOn' => date("Y-m-d H:i:s"),
	    'AddedBy' => $this->session->userdata('EmployeeId'),
	    );

	    $this->Location_model->UpdateLocationDetail($Record, $LocationId);
	    $this->session->set_flashdata("record_added","Record Updated successfully.");
	    redirect("Location/ViewLocation/$LocationId");
	}

	
	public function DeleteLocation($LocationId)
	{
	    if($this->Location_model->DeleteLocation($LocationId)){
	    $this->session->set_flashdata("record_deleted","Record Deleted successfully.");
            redirect("Location");
	    }
	}
}