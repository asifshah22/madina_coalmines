<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Vendor extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->check_isvalidated();
		//$this->output->enable_profiler();
		$this->load->model('Vendor_model');
        $this->load->model('COA_model');
        $this->load->model('Employee_model');
        $this->load->model('Customer_model');
//	$this->output->enable_profiler(true);
		//$this->load->model(array('employee_model','office_model'));
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
        $data['CustomerNotification'] = $this->Customer_model->GetNotifications();
        $this->load->view('vendor/vendors',$data);
	}
        public function Ajax_GetAllVendors()
        {
            $PurchasesRoles = $this->Employee_model->GetPurchasesRoles($this->session->userdata('EmployeeId'));
               $Vendor=$this->Vendor_model->Ajax_GetAllVendors($_REQUEST);

//			echo $this->output->enable_profiler();	
            $ViewRecord = '<span style="color:#00a65a;" class="glyphicon glyphicon-th-large"></span>';
            $UpdateRecord = '<span style="color:#0c6aad;" class="fa fa-edit">';

               $data = array();
                 foreach($Vendor['record'] as $row)
                {    
                    $nestedData=array(); 
                    $nestedData[] = $row["VendorName"];
                    $nestedData[] = $row["ContactName"];
                    $nestedData[] = $row["Email"];
                    $nestedData[] = $row["PhoneNo"];
                    $id = $row['VendorId'];
//                    if ($PurchasesRoles[2]['ViewRoles'] == 1 && $PurchasesRoles[2]['UpdateRoles'] ==1 ) {
                    $nestedData[] = '<a href="'.base_url().'Vendor/ViewVendor/'.$id.'" title="View Record">'.$ViewRecord.'</a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="'.base_url().'Vendor/EditVendor/'.$id.'"title="Update Record"><span style="color:#0c6aad;" class="fa fa-edit"></span></a>';
/*                    }
                    if ($PurchasesRoles[2]['ViewRoles'] == 1 ) {
                    $nestedData[] = '<a href="'.base_url().'Vendor/ViewVendor/'.$id.'" title="View Record">'.$ViewRecord.'</a>';
                    }*/

                    $data[] = $nestedData;
                    
                }
                 $json_data = array(
			"draw"            => intval( $_REQUEST['draw'] ),   // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw. 
			"recordsTotal"    => intval( $Vendor['recordsTotal'] ),  // total number of records
			"recordsFiltered" => intval( $Vendor['recordsFiltered'] ), // total number of records after searching, if there is no searching then totalFiltered = totalData
			"data"            => $data   // total data array
			);
                echo json_encode($json_data);  // send data as json format
         }
	 
	public function AddVendor()
	{
        $GetChartOfAccount  = $this->COA_model->GetChartOfAccountCode(2);

        $data['AdministrationRoles'] = $this->Employee_model->GetAdministrationRoles($this->session->userdata('EmployeeId'));
        $data['SalesRoles'] = $this->Employee_model->GetSalesRoles($this->session->userdata('EmployeeId'));
        $data['PurchasesRoles'] = $this->Employee_model->GetPurchasesRoles($this->session->userdata('EmployeeId'));
        $data['RegistrationRoles'] = $this->Employee_model->GetRegistrationRoles($this->session->userdata('EmployeeId'));
        $data['TransactionRoles'] = $this->Employee_model->GetTransactionRoles($this->session->userdata('EmployeeId'));
        $data['ReportsRoles'] = $this->Employee_model->GetReportsRoles($this->session->userdata('EmployeeId'));

        $data['Category_Id'] = $GetChartOfAccount->ChartOfAccountCategoryId;
        $data['ControlCode_Id'] = $GetChartOfAccount->ChartOfAccountControlId;
        $data['COA_Code'] = $this->COA_model->NextChartOfAccountCode(2,$GetChartOfAccount->COA_Code);
        $data['CustomerNotification'] = $this->Customer_model->GetNotifications();
            $this->load->view('vendor/add_vendor',$data);
	}
        
	public function SaveVendor($VendorId=0)
	{	
	    $data=$this->input->post();

            $LastVendorId = $this->Vendor_model->SaveVendorDetail($data);
	    if($LastVendorId != '')
	    {                               
	       $this->session->set_flashdata("record_added","Record added successfully."); 
	       redirect("Vendor/ViewVendor/$LastVendorId");	
	    }
	}

	
	public function UpdateVendor($VendorId)
	{
	   $data=$this->input->post();

        if($this->Vendor_model->UpdateVendorDetail($data,$VendorId)){
              $this->session->set_flashdata("record_update","Record updated successfully.");
              redirect("Vendor/ViewVendor/".$VendorId);
        }
	}
        
        public function EditVendor($VendorId)
        {
	  
        $data['AdministrationRoles'] = $this->Employee_model->GetAdministrationRoles($this->session->userdata('EmployeeId'));
        $data['SalesRoles'] = $this->Employee_model->GetSalesRoles($this->session->userdata('EmployeeId'));
        $data['PurchasesRoles'] = $this->Employee_model->GetPurchasesRoles($this->session->userdata('EmployeeId'));
        $data['RegistrationRoles'] = $this->Employee_model->GetRegistrationRoles($this->session->userdata('EmployeeId'));
        $data['TransactionRoles'] = $this->Employee_model->GetTransactionRoles($this->session->userdata('EmployeeId'));
        $data['ReportsRoles'] = $this->Employee_model->GetReportsRoles($this->session->userdata('EmployeeId'));
            
         $data['GetVendor']=$this->Vendor_model->GetVendor($VendorId);
         $data['CustomerNotification'] = $this->Customer_model->GetNotifications();
         $this->load->view('vendor/edit_vendor',$data);
        }
     
	 
         public function ViewVendor($VendorId)
        {
             
        $data['AdministrationRoles'] = $this->Employee_model->GetAdministrationRoles($this->session->userdata('EmployeeId'));
        $data['SalesRoles'] = $this->Employee_model->GetSalesRoles($this->session->userdata('EmployeeId'));
        $data['PurchasesRoles'] = $this->Employee_model->GetPurchasesRoles($this->session->userdata('EmployeeId'));
        $data['RegistrationRoles'] = $this->Employee_model->GetRegistrationRoles($this->session->userdata('EmployeeId'));
        $data['TransactionRoles'] = $this->Employee_model->GetTransactionRoles($this->session->userdata('EmployeeId'));
        $data['ReportsRoles'] = $this->Employee_model->GetReportsRoles($this->session->userdata('EmployeeId'));
	//  $data['GetAllDivisions'] = $this->Vendor_model->GetAllDivisions();
	//  $data['GetAllDistricts'] = $this->Vendor_model->GetAllDistricts();
	  $data['GetVendor']=$this->Vendor_model->GetVendor($VendorId);
	  $data['CustomerNotification'] = $this->Customer_model->GetNotifications();
	  $this->load->view('vendor/view_vendor',$data);
        }        
}

?>