<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Colour extends CI_Controller {

	public function __construct()
	{
	    parent::__construct();
	    $this->check_isvalidated();
	    $this->load->model('Colour_model');
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
	    $data['Roles'] = $this->Employee_model->GetRoles();
	    $data['AdministrationRoles'] = $this->Employee_model->GetAdministrationRoles($this->session->userdata('EmployeeId'));
	    $data['SalesRoles'] = $this->Employee_model->GetSalesRoles($this->session->userdata('EmployeeId'));
	    $data['PurchasesRoles'] = $this->Employee_model->GetPurchasesRoles($this->session->userdata('EmployeeId'));
	    $data['RegistrationRoles'] = $this->Employee_model->GetRegistrationRoles($this->session->userdata('EmployeeId'));
	    $data['TransactionRoles'] = $this->Employee_model->GetTransactionRoles($this->session->userdata('EmployeeId'));
	    $data['ReportsRoles'] = $this->Employee_model->GetReportsRoles($this->session->userdata('EmployeeId'));
//	    $data['AllColours']=$this->Colour_model->GetAllColours();
	    $data['TotalRecord']=$this->Colour_model->TotalRecord();
	    
	    $data['CustomerNotification'] = $this->Customer_model->GetNotifications();
	    $this->load->view('colour/colours',$data);
	}

	public function Ajax_GetAllColours()
	{
		$AdministrationRoles = $this->Employee_model->GetAdministrationRoles($this->session->userdata('EmployeeId'));
        $GetAllColours=$this->Colour_model->Ajax_GetAllColours($_REQUEST);

        $ViewRecord = '<span style="color:#00a65a;" class="glyphicon glyphicon-th-large"></span>';
        $UpdateRecord = '<span style="color:#0c6aad;" class="fa fa-edit">';
        
            $data = array();
            foreach($GetAllColours['record'] as $row)
            {
                $nestedData=array(); 
                $nestedData[] = $row["ColourName"];
//                $nestedData[] = $row["ColourStatus"];
                $id = $row["ColourId"];
//                if ($AdministrationRoles[8]['ViewRoles']==1 && $AdministrationRoles[8]['UpdateRoles']==1) {
                    $nestedData[] = '<a href="'.base_url().'Colour/ViewColour/'.$id.'" title="View Record">'.$ViewRecord.'</a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="'.base_url().'Colour/EditColour/'.$id.'"title="Update Record"><span style="color:#0c6aad;" class="fa fa-edit"></span></a>';
/*                }
				else{
                    $nestedData[] = '<a href="'.base_url().'Colour/ViewColour/'.$id.'" title="View Record">'.$ViewRecord.'</a>';
				}*/
                $data[] = $nestedData;
            }

                $json_data = array(
			"draw" => intval( $_REQUEST['draw'] ),   // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw. 
			"recordsTotal"    => intval( $GetAllColours['recordsTotal'] ),  // total number of records
			"recordsFiltered" => intval( $GetAllColours['recordsFiltered'] ), // total number of records after searching, if there is no searching then totalFiltered = totalData
			"data" => $data   // total data array
			);
                echo json_encode($json_data);  // send data as json format
        }	
	
	public function AddColour()
	{
	    $data['Roles'] = $this->Employee_model->GetRoles();
	    $data['AdministrationRoles'] = $this->Employee_model->GetAdministrationRoles($this->session->userdata('EmployeeId'));
	    $data['SalesRoles'] = $this->Employee_model->GetSalesRoles($this->session->userdata('EmployeeId'));
	    $data['RegistrationRoles'] = $this->Employee_model->GetRegistrationRoles($this->session->userdata('EmployeeId'));
	    $data['TransactionRoles'] = $this->Employee_model->GetTransactionRoles($this->session->userdata('EmployeeId'));
	    $data['PurchasesRoles'] = $this->Employee_model->GetPurchasesRoles($this->session->userdata('EmployeeId'));
	    $data['ReportsRoles'] = $this->Employee_model->GetReportsRoles($this->session->userdata('EmployeeId'));
	    
	    $data['CustomerNotification'] = $this->Customer_model->GetNotifications();
	    $this->load->view('colour/add_colour',$data);
	}
	
	
	public function ViewColour($ColourId)
	{
	    $data['Roles'] = $this->Employee_model->GetRoles();
	    $data['AdministrationRoles'] = $this->Employee_model->GetAdministrationRoles($this->session->userdata('EmployeeId'));
	    $data['SalesRoles'] = $this->Employee_model->GetSalesRoles($this->session->userdata('EmployeeId'));
	    $data['PurchasesRoles'] = $this->Employee_model->GetPurchasesRoles($this->session->userdata('EmployeeId'));
	    $data['RegistrationRoles'] = $this->Employee_model->GetRegistrationRoles($this->session->userdata('EmployeeId'));
	    $data['TransactionRoles'] = $this->Employee_model->GetTransactionRoles($this->session->userdata('EmployeeId'));
	    $data['ReportsRoles'] = $this->Employee_model->GetReportsRoles($this->session->userdata('EmployeeId')); 
	    $data['GetColourById'] = $this->Colour_model->GetColourById($ColourId);
	    
	    $data['CustomerNotification'] = $this->Customer_model->GetNotifications();
	    $this->load->view('colour/view_colour',$data);
	}
	
    
	public function EditColour($ColourId)
	{
	    $data['AdministrationRoles'] = $this->Employee_model->GetAdministrationRoles($this->session->userdata('EmployeeId'));
	    $data['SalesRoles'] = $this->Employee_model->GetSalesRoles($this->session->userdata('EmployeeId'));
	    $data['PurchasesRoles'] = $this->Employee_model->GetPurchasesRoles($this->session->userdata('EmployeeId'));
	    $data['RegistrationRoles'] = $this->Employee_model->GetRegistrationRoles($this->session->userdata('EmployeeId'));
	    $data['TransactionRoles'] = $this->Employee_model->GetTransactionRoles($this->session->userdata('EmployeeId'));
	    $data['ReportsRoles'] = $this->Employee_model->GetReportsRoles($this->session->userdata('EmployeeId')); 
	    $data['GetColourById'] = $this->Colour_model->GetColourById($ColourId);
	    
	    $data['CustomerNotification'] = $this->Customer_model->GetNotifications();
	    $this->load->view('colour/edit_colour',$data);
	}

	
	public function SaveColour($ColourId='')
	{  
	    $data=$this->input->post();
	    $data['AddedOn'] = date('Y-m-d H:i:s');
	    $data['AddedBy'] = $this->session->userdata('EmployeeId');
	   
	    if($NewColourId =  $this->Colour_model->SaveColour($data,$ColourId))
	    {
		redirect("Colour/ViewColour/$NewColourId");
	    }
	}

	
	public function DeleteColour($ColourId)
	{
	    if($this->Colour_model->DeleteColour($ColourId))
	    {
		redirect("Colour");
	    }
	}
}
?>