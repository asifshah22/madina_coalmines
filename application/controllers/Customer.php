<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Customer extends CI_Controller {

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
	   
	    $this->load->view('customer/customers',$data);
	}
        public function Ajax_GetAllCustomers()
        {
               $SalesRoles = $this->Employee_model->GetSalesRoles($this->session->userdata('EmployeeId'));
               $Customer=$this->Customer_model->Ajax_GetAllCustomers($_REQUEST);

                $ViewRecord = '<span style="color:#00a65a;" class="glyphicon glyphicon-th-large"></span>';
                $UpdateRecord = '<span style="color:#0c6aad;" class="fa fa-edit">';

               $data = array();
                 foreach($Customer['record'] as $row)
                {    
                    $nestedData=array(); 
                     $DueAmount= $row['DueAmount']?? 0;
                    $nestedData[] = $row["CustomerName"];
                    $nestedData[] = $row["ContactName"];
                    $nestedData[] = $row["Email"];
                    
                    $nestedData[] = "<span class='btn btn-danger'>$DueAmount</span>";
                    $nestedData[] = $row["CellNo"];
                    $id = $row['CustomerId'];
//                    if ($SalesRoles[2]['ViewRoles'] == 1 && $SalesRoles[2]['UpdateRoles'] == 1 ) {
                    $nestedData[] = '<a href="'.base_url().'Customer/ViewCustomer/'.$id.'" title="View Record">'.$ViewRecord.'</a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="'.base_url().'Customer/EditCustomer/'.$id.'"title="Update Record"><span style="color:#0c6aad;" class="fa fa-edit"></span></a>';
  /*                  }
                    if ($SalesRoles[2]['ViewRoles'] == 1 ) {
                        $nestedData[] = '<a href="'.base_url().'Customer/ViewCustomer/'.$id.'" title="View Record">'.$ViewRecord.'</a>';
                    }*/
                    $data[] = $nestedData;
                    
                }
                 $json_data = array(
			"draw"            => intval( $_REQUEST['draw'] ),   // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw. 
			"recordsTotal"    => intval( $Customer['recordsTotal'] ),  // total number of records
			"recordsFiltered" => intval( $Customer['recordsFiltered'] ), // total number of records after searching, if there is no searching then totalFiltered = totalData
			"data"            => $data   // total data array
			);
                echo json_encode($json_data);  // send data as json format
         }
	 
	public function AddCustomer()
	{
        // control id 3 is account receivables
        $GetChartOfAccount  = $this->COA_model->GetChartOfAccountCode(3);

        $data['AdministrationRoles'] = $this->Employee_model->GetAdministrationRoles($this->session->userdata('EmployeeId'));
        $data['SalesRoles'] = $this->Employee_model->GetSalesRoles($this->session->userdata('EmployeeId'));
        $data['PurchasesRoles'] = $this->Employee_model->GetPurchasesRoles($this->session->userdata('EmployeeId'));
        $data['RegistrationRoles'] = $this->Employee_model->GetRegistrationRoles($this->session->userdata('EmployeeId'));
        $data['TransactionRoles'] = $this->Employee_model->GetTransactionRoles($this->session->userdata('EmployeeId'));
        $data['ReportsRoles'] = $this->Employee_model->GetReportsRoles($this->session->userdata('EmployeeId'));
        
        $data['GetAllAreas'] = $this->Area_model->GetAllAreas();

        $data['Category_Id'] = $GetChartOfAccount->ChartOfAccountCategoryId;
        $data['ControlCode_Id'] = $GetChartOfAccount->ChartOfAccountControlId;
        $data['COA_Code'] = $this->COA_model->NextChartOfAccountCode(3,$GetChartOfAccount->COA_Code);
        
        $data['CustomerNotification'] = $this->Customer_model->GetNotifications();

        $this->load->view('customer/add_customer',$data);
	}
        
	public function SaveCustomer($CustomerId=0)
	{	
	    $getCustomers = $this->Customer_model->GetCustomerByName($this->input->post('CustomerName'));
	    $Record=$this->input->post();

           if($CustomerId == 0)
           {
                if($this->input->post('CustomerName') == $getCustomers->CustomerName){
                    $this->session->set_flashdata("Validate_message","This customer name already exist.");
                    redirect("Customer/AddCustomer");
                }
                $LastCustomerId = $this->Customer_model->SaveCustomerDetail($Record);
            if($LastCustomerId !='')
		      {
			    $this->session->set_flashdata("record_added","Record added successfully."); 
			    redirect("Customer/ViewCustomer/$LastCustomerId");	
              }
           }
           else
           {
            //   if($this->input->post('CustomerName') == $getCustomers->CustomerName){
            //         $this->session->set_flashdata("Validate_message","This customer name already exist.");
            //         redirect("Customer/EditCustomer/$CustomerId");
            //     }
                
               $Status = $this->Customer_model->SaveCustomerDetail($Record,$CustomerId);
               if($Status == 'success')
               {
                   $this->session->set_flashdata("record_update","Record update successfully.");
                   redirect("Customer/ViewCustomer/$CustomerId");
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
	
	
        public function EditCustomer($CustomerId)
        {
        $data['AdministrationRoles'] = $this->Employee_model->GetAdministrationRoles($this->session->userdata('EmployeeId'));
        $data['SalesRoles'] = $this->Employee_model->GetSalesRoles($this->session->userdata('EmployeeId'));
        $data['PurchasesRoles'] = $this->Employee_model->GetPurchasesRoles($this->session->userdata('EmployeeId'));
        $data['RegistrationRoles'] = $this->Employee_model->GetRegistrationRoles($this->session->userdata('EmployeeId'));
        $data['TransactionRoles'] = $this->Employee_model->GetTransactionRoles($this->session->userdata('EmployeeId'));
        $data['ReportsRoles'] = $this->Employee_model->GetReportsRoles($this->session->userdata('EmployeeId'));
        
        $data['GetAllAreas'] = $this->Area_model->GetAllAreas();
            
            // $data['GetAllStates'] = $this->Customer_model->GetAllStates();
            // $data['GetAllDivisions'] = $this->Customer_model->GetAllDivisions();
            // $data['GetAllDistricts'] = $this->Customer_model->GetAllDistricts();
            
            $data['GetCustomer']=$this->Customer_model->GetCustomer($CustomerId);
            $data['CustomerNotification'] = $this->Customer_model->GetNotifications();
            $this->load->view('customer/edit_customer',$data);
        }
     
	 
         public function ViewCustomer($CustomerId)
        {
             
        $data['AdministrationRoles'] = $this->Employee_model->GetAdministrationRoles($this->session->userdata('EmployeeId'));
        $data['SalesRoles'] = $this->Employee_model->GetSalesRoles($this->session->userdata('EmployeeId'));
        $data['PurchasesRoles'] = $this->Employee_model->GetPurchasesRoles($this->session->userdata('EmployeeId'));
        $data['RegistrationRoles'] = $this->Employee_model->GetRegistrationRoles($this->session->userdata('EmployeeId'));
        $data['TransactionRoles'] = $this->Employee_model->GetTransactionRoles($this->session->userdata('EmployeeId'));
        $data['ReportsRoles'] = $this->Employee_model->GetReportsRoles($this->session->userdata('EmployeeId'));
        $data['GetCustomer']=$this->Customer_model->GetCustomer($CustomerId);
        $data['GetAllAreas'] = $this->Area_model->GetAllAreas();
        $data['CustomerNotification'] = $this->Customer_model->GetNotifications();
        $this->load->view('customer/view_customer',$data);
        }        
}

?>