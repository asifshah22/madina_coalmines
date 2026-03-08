<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reference extends CI_Controller {

	public function __construct()
	{
	    parent::__construct();
	    $this->check_isvalidated();
	    $this->load->model('Reference_model');
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
        $data['AdministrationRoles'] = $this->Employee_model->GetAdministrationRoles($this->session->userdata('EmployeeId'));
        $data['SalesRoles'] = $this->Employee_model->GetSalesRoles($this->session->userdata('EmployeeId'));
        $data['PurchasesRoles'] = $this->Employee_model->GetPurchasesRoles($this->session->userdata('EmployeeId'));
        $data['RegistrationRoles'] = $this->Employee_model->GetRegistrationRoles($this->session->userdata('EmployeeId'));
        $data['TransactionRoles'] = $this->Employee_model->GetTransactionRoles($this->session->userdata('EmployeeId'));
        $data['ReportsRoles'] = $this->Employee_model->GetReportsRoles($this->session->userdata('EmployeeId'));
        $data['Reference']=$this->Reference_model->GetAllReference();
        $data['CustomerNotification'] = $this->Customer_model->GetNotifications();
        $this->load->view('reference/references',$data);
	}

	
	public function Ajax_GetAllReference()
	{

        $Reference = $this->Reference_model->GetReferencesWithCondition($_REQUEST);

        $ViewRecord = '<span style="color:#00a65a;" class="glyphicon glyphicon-th-large"></span>';
        $UpdateRecord = '<span style="color:#0c6aad;" class="fa fa-edit"></span>';

        $data = array();
        foreach($Reference['record'] as $row)
        {
           $nestedData=array();
           $nestedData[] = $row["FullName"];
           $nestedData[] = $row["ContactNumber"];
           $nestedData[] = $row["Address"];
           $id = $row['ReferenceId'];
			   
            $nestedData[] = '<a href="'.base_url().'Reference/ViewReference/'.$id.'" title="View Record">'.$ViewRecord.'</a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="'.base_url().'Reference/EditReference/'.$id.'"title="Update Record"><span style="color:#0c6aad;" class="fa fa-edit"></span></a>';

           $data[] = $nestedData;
		   }
           $totalFiltered = count($Reference);
           $json_data = array(
			"draw"            => intval( $_REQUEST['draw'] ),   // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw. 
			"recordsTotal"    => intval( $Reference['recordsTotal'] ),  // total number of records
			"recordsFiltered" => intval( $Reference['recordsFiltered'] ), // total number of records after searching, if there is no searching then totalFiltered = totalData
			"data"            => $data   // total data array
			);

                echo json_encode($json_data);  // send data as json format            
        }
		   
	
	public function AddReference()
	{
        $data['AdministrationRoles'] = $this->Employee_model->GetAdministrationRoles($this->session->userdata('EmployeeId'));
        $data['SalesRoles'] = $this->Employee_model->GetSalesRoles($this->session->userdata('EmployeeId'));
        $data['PurchasesRoles'] = $this->Employee_model->GetPurchasesRoles($this->session->userdata('EmployeeId'));
        $data['RegistrationRoles'] = $this->Employee_model->GetRegistrationRoles($this->session->userdata('EmployeeId'));
        $data['TransactionRoles'] = $this->Employee_model->GetTransactionRoles($this->session->userdata('EmployeeId'));
        $data['ReportsRoles'] = $this->Employee_model->GetReportsRoles($this->session->userdata('EmployeeId'));
        $data['CustomerNotification'] = $this->Customer_model->GetNotifications();
         $this->load->view('reference/add_reference',$data);

	}
	
	public function ViewReference($ReferenceId)
	{
        $data['AdministrationRoles'] = $this->Employee_model->GetAdministrationRoles($this->session->userdata('EmployeeId'));
        $data['SalesRoles'] = $this->Employee_model->GetSalesRoles($this->session->userdata('EmployeeId'));
        $data['PurchasesRoles'] = $this->Employee_model->GetPurchasesRoles($this->session->userdata('EmployeeId'));
        $data['RegistrationRoles'] = $this->Employee_model->GetRegistrationRoles($this->session->userdata('EmployeeId'));
        $data['TransactionRoles'] = $this->Employee_model->GetTransactionRoles($this->session->userdata('EmployeeId'));
        $data['ReportsRoles'] = $this->Employee_model->GetReportsRoles($this->session->userdata('EmployeeId'));
	
         $data['Reference'] = $this->Reference_model->GetReferenceById($ReferenceId);
         $data['CustomerNotification'] = $this->Customer_model->GetNotifications();
         $this->load->view('reference/view_reference',$data);
	}
	
	public function EditReference($ReferenceId)
	{
        $data['AdministrationRoles'] = $this->Employee_model->GetAdministrationRoles($this->session->userdata('EmployeeId'));
        $data['SalesRoles'] = $this->Employee_model->GetSalesRoles($this->session->userdata('EmployeeId'));
        $data['PurchasesRoles'] = $this->Employee_model->GetPurchasesRoles($this->session->userdata('EmployeeId'));
        $data['RegistrationRoles'] = $this->Employee_model->GetRegistrationRoles($this->session->userdata('EmployeeId'));
        $data['TransactionRoles'] = $this->Employee_model->GetTransactionRoles($this->session->userdata('EmployeeId'));
        $data['ReportsRoles'] = $this->Employee_model->GetReportsRoles($this->session->userdata('EmployeeId'));                     
    	$data['Reference'] = $this->Reference_model->GetReferenceById($ReferenceId);
    	$data['CustomerNotification'] = $this->Customer_model->GetNotifications();
         $this->load->view('reference/edit_reference',$data);
	}

	
	public function SaveReference($ReferenceId='')
	{	
          
	    $data=$this->input->post();
			   
	    if($NewReferenceId =  $this->Reference_model->SaveReference($data,$ReferenceId))
	    {
		redirect("Reference/ViewReference/$NewReferenceId");
	    }
	}
	
	public function UpdateReference()
	{
	    $Data = $this->input->post();
	    $ReferenceId = $this->Reference_model->UpdateReferenceDetail($Data);
	    
	    if($ReferenceId != '')
	    {
                redirect("Reference/ViewReference/$ReferenceId");
	    }
	    else
	    {
		redirect("Reference/");
	    }
	    
	}
	
}

?>