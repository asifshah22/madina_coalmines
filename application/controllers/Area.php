<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Area extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->check_isvalidated();
		//$this->output->enable_profiler();
		$this->load->model('Customer_model');
        $this->load->model('COA_model');
        $this->load->model('Area_model');
        $this->load->model('Employee_model');
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
	   
	    $this->load->view('area/areas',$data);
	}
        public function Ajax_GetAllAreas()
        {
               $SalesRoles = $this->Employee_model->GetSalesRoles($this->session->userdata('EmployeeId'));
               $Area=$this->Area_model->Ajax_GetAllAreas($_REQUEST);

                $ViewRecord = '<span style="color:#00a65a;" class="glyphicon glyphicon-th-large"></span>';
                $UpdateRecord = '<span style="color:#0c6aad;" class="fa fa-edit">';

               $data = array();
                 foreach($Area['record'] as $row)
                {    
                    $nestedData=array(); 
                    $nestedData[] = $row["Area_name"];
                    $id = $row['id'];
//                    if ($SalesRoles[2]['ViewRoles'] == 1 && $SalesRoles[2]['UpdateRoles'] == 1 ) {
                    $nestedData[] = '<a href="'.base_url().'Area/ViewArea/'.$id.'" title="View Record">'.$ViewRecord.'</a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="'.base_url().'Area/EditArea/'.$id.'"title="Update Record"><span style="color:#0c6aad;" class="fa fa-edit"></span></a>';
  /*                  }
                    if ($SalesRoles[2]['ViewRoles'] == 1 ) {
                        $nestedData[] = '<a href="'.base_url().'Customer/ViewCustomer/'.$id.'" title="View Record">'.$ViewRecord.'</a>';
                    }*/
                    $data[] = $nestedData;
                    
                }
                 $json_data = array(
			"draw"            => intval( $_REQUEST['draw'] ),   // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw. 
			"recordsTotal"    => intval( $Area['recordsTotal'] ),  // total number of records
			"recordsFiltered" => intval( $Area['recordsFiltered'] ), // total number of records after searching, if there is no searching then totalFiltered = totalData
			"data"            => $data   // total data array
			);
                echo json_encode($json_data);  // send data as json format
         }
	 
	public function AddArea()
	{
        // control id 3 is account receivables
        $GetChartOfAccount  = $this->COA_model->GetChartOfAccountCode(3);

        $data['AdministrationRoles'] = $this->Employee_model->GetAdministrationRoles($this->session->userdata('EmployeeId'));
        $data['SalesRoles'] = $this->Employee_model->GetSalesRoles($this->session->userdata('EmployeeId'));
        $data['PurchasesRoles'] = $this->Employee_model->GetPurchasesRoles($this->session->userdata('EmployeeId'));
        $data['RegistrationRoles'] = $this->Employee_model->GetRegistrationRoles($this->session->userdata('EmployeeId'));
        $data['TransactionRoles'] = $this->Employee_model->GetTransactionRoles($this->session->userdata('EmployeeId'));
        $data['ReportsRoles'] = $this->Employee_model->GetReportsRoles($this->session->userdata('EmployeeId'));

        $data['Category_Id'] = $GetChartOfAccount->ChartOfAccountCategoryId;
        $data['ControlCode_Id'] = $GetChartOfAccount->ChartOfAccountControlId;
        $data['COA_Code'] = $this->COA_model->NextChartOfAccountCode(3,$GetChartOfAccount->COA_Code);
        
        $data['CustomerNotification'] = $this->Customer_model->GetNotifications();

        $this->load->view('area/add_area',$data);
	}
        
	public function SaveArea($AreaId=0)
	{	
	       $Record=$this->input->post();

               if($AreaId == 0)
               {
                        $LastAreaId = $this->Area_model->SaveAreaDetail($Record);
                        if($LastAreaId !='')
			{
			    $this->session->set_flashdata("record_added","Record added successfully."); 
			    redirect("Area/ViewArea/$LastAreaId");	
                        }
               }
               else
               {
                   $Status = $this->Area_model->SaveAreaDetail($Record,$AreaId);
                   if($Status == 'success')
                   {
                       $this->session->set_flashdata("record_update","Record update successfully.");
                       redirect("Area/ViewArea/$AreaId");
                   }    
               }
	}
	
	
	public function UpdateCustomer($CustomerId=0)
	{	
	    $Record=$this->input->post();

	    $Status = $this->Customer_model->UpdateCustomerDetail($Record,$CustomerId);
	    if($Status == 'success')
	    {
		$this->session->set_flashdata("record_update","Record update successfully.");
		redirect("Customer/ViewCustomer/$CustomerId");
	    }
	}
	
	
        public function EditArea($AreaId)
        {
        $data['AdministrationRoles'] = $this->Employee_model->GetAdministrationRoles($this->session->userdata('EmployeeId'));
        $data['SalesRoles'] = $this->Employee_model->GetSalesRoles($this->session->userdata('EmployeeId'));
        $data['PurchasesRoles'] = $this->Employee_model->GetPurchasesRoles($this->session->userdata('EmployeeId'));
        $data['RegistrationRoles'] = $this->Employee_model->GetRegistrationRoles($this->session->userdata('EmployeeId'));
        $data['TransactionRoles'] = $this->Employee_model->GetTransactionRoles($this->session->userdata('EmployeeId'));
        $data['ReportsRoles'] = $this->Employee_model->GetReportsRoles($this->session->userdata('EmployeeId'));
        $data['CustomerNotification'] = $this->Customer_model->GetNotifications();
            
        $data['GetArea']=$this->Area_model->GetArea($AreaId);
        $this->load->view('area/edit_area',$data);
        }
     
	 
         public function ViewArea($AreaId)
        {
             
        $data['AdministrationRoles'] = $this->Employee_model->GetAdministrationRoles($this->session->userdata('EmployeeId'));
        $data['SalesRoles'] = $this->Employee_model->GetSalesRoles($this->session->userdata('EmployeeId'));
        $data['PurchasesRoles'] = $this->Employee_model->GetPurchasesRoles($this->session->userdata('EmployeeId'));
        $data['RegistrationRoles'] = $this->Employee_model->GetRegistrationRoles($this->session->userdata('EmployeeId'));
        $data['TransactionRoles'] = $this->Employee_model->GetTransactionRoles($this->session->userdata('EmployeeId'));
        $data['ReportsRoles'] = $this->Employee_model->GetReportsRoles($this->session->userdata('EmployeeId'));
        $data['GetArea']=$this->Area_model->GetArea($AreaId);
        
        $data['CustomerNotification'] = $this->Customer_model->GetNotifications();
        $this->load->view('area/view_area',$data);
        }        
}

?>