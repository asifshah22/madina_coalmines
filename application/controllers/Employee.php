<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Employee extends CI_Controller {

      	public function __construct()
    	{
	    parent::__construct();
	    $this->check_isvalidated();
	    $this->load->model('Employee_model');
	    $this->load->model('Designation_model');
	    $this->load->model('Customer_model');
//      $this->output->enable_profiler();
    	}
	
      	private function check_isvalidated()
    	{
	    if(!$this->session->userdata('EmployeeId'))
	    {  $this->session->set_userdata('url',  current_url()); redirect('Login'); }
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
	    $data['GetAllEmployees']=$this->Employee_model->GetAllEmployees();
	    $data['CustomerNotification'] = $this->Customer_model->GetNotifications();
	    $this->load->view('employee/employees',$data);
      }
      	
        public function Ajax_GetAllEmployees()
        {
            $data['EmployeeRoles'] = $this->Employee_model->GetEmployeeRoles($this->session->userdata('EmployeeId'));
            $AdministrationRoles = $this->Employee_model->GetAdministrationRoles($this->session->userdata('EmployeeId'));
            $data['SalesRoles'] = $this->Employee_model->GetSalesRoles($this->session->userdata('EmployeeId'));
            $data['PurchasesRoles'] = $this->Employee_model->GetPurchasesRoles($this->session->userdata('EmployeeId'));
            $data['RegistrationRoles'] = $this->Employee_model->GetRegistrationRoles($this->session->userdata('EmployeeId'));
            $data['TransactionRoles'] = $this->Employee_model->GetTransactionRoles($this->session->userdata('EmployeeId'));
            $data['ReportsRoles'] = $this->Employee_model->GetReportsRoles($this->session->userdata('EmployeeId'));

            $GetAllEmployees=$this->Employee_model->Ajax_GetAllEmployees($_REQUEST);

            $ViewRecord = '<span style="color:#00a65a;" class="glyphicon glyphicon-th-large"></span>';
            $UpdateRecord = '<span style="color:#0c6aad;" class="fa fa-edit">';

            $data = array();
              foreach($GetAllEmployees['record'] as $row)
            {    
                $nestedData=array(); 
                $nestedData[] = $row["EmployeeName"];
                $nestedData[] = $row["DesignationName"];
                $nestedData[] = $row["CellNo"];
                $nestedData[] = $row["EmailAddress"];
//		$nestedData[] = $row["CompanyName"];
                $id = $row["EmployeeId"];
                $Roles = $this->Employee_model->GetAdministrationRoles($this->session->userdata('EmployeeId'));
                if ($Roles[5]['AddRoles']==1) {
                    $EmployeeRoles = '<a href="'.base_url().'Employee/EmployeeRoles/'.$id.'" title="User Roles"><span class="fa  fa-user-plus"></span></a>';
                      } else {
                    $EmployeeRoles = '';
                      }
                      
                if($this->session->userdata('EmployeeType')==1){ 
                  $nestedData[] = '<a href="'.base_url().'Employee/ViewEmployee/'.$id.'" title="View Record">'.$ViewRecord.'</a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="'.base_url().'Employee/EditEmployee/'.$id.'"title="Update Record"><span style="color:#0c6aad;" class="fa fa-edit"></span></a>';
                }

                if ($AdministrationRoles[5]['ViewRoles']==1 && $AdministrationRoles[5]['UpdateRoles']==1) {
                $nestedData[] = '<a href="'.base_url().'Employee/ViewEmployee/'.$id.'" title="View Record">'.$ViewRecord.'</a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="'.base_url().'Employee/EditEmployee/'.$id.'"title="Update Record"><span style="color:#0c6aad;" class="fa fa-edit"></span></a>'.$EmployeeRoles;
                }

                if ($AdministrationRoles[5]['ViewRoles']==1) {
                  $nestedData[] = '<a href="'.base_url().'Employee/ViewEmployee/'.$id.'" title="View Record">'.$ViewRecord;
                }

                $data[] = $nestedData;
              }
            $json_data = array(
      "draw" => intval( $_REQUEST['draw'] ),   // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw. 
      "recordsTotal"    => intval( $GetAllEmployees['recordsTotal'] ),  // total number of records
      "recordsFiltered" => intval( $GetAllEmployees['recordsFiltered'] ), // total number of records after searching, if there is no searching then totalFiltered = totalData
      "data" => $data   // total data array
      );
                echo json_encode($json_data);  // send data as json format
      }

     	public function AddEmployee()
     	{
  	    $data['AdministrationRoles'] = $this->Employee_model->GetAdministrationRoles($this->session->userdata('EmployeeId'));
  	    $data['SalesRoles'] = $this->Employee_model->GetSalesRoles($this->session->userdata('EmployeeId'));
  	    $data['PurchasesRoles'] = $this->Employee_model->GetPurchasesRoles($this->session->userdata('EmployeeId'));
  	    $data['RegistrationRoles'] = $this->Employee_model->GetRegistrationRoles($this->session->userdata('EmployeeId'));
  	    $data['TransactionRoles'] = $this->Employee_model->GetTransactionRoles($this->session->userdata('EmployeeId'));
  	    $data['ReportsRoles'] = $this->Employee_model->GetReportsRoles($this->session->userdata('EmployeeId'));
  	    $data['GetAllDesignations'] = $this->Designation_model->GetAllDesignations();
  	    $data['CustomerNotification'] = $this->Customer_model->GetNotifications();
  	    $this->load->view('employee/add_employee',$data);
      }
        
        
        public function ViewEmployee($EmployeeId)
	{
	    $data['AdministrationRoles'] = $this->Employee_model->GetAdministrationRoles($this->session->userdata('EmployeeId'));
	    $data['SalesRoles'] = $this->Employee_model->GetSalesRoles($this->session->userdata('EmployeeId'));
	    $data['PurchasesRoles'] = $this->Employee_model->GetPurchasesRoles($this->session->userdata('EmployeeId'));
	    $data['RegistrationRoles'] = $this->Employee_model->GetRegistrationRoles($this->session->userdata('EmployeeId'));
	    $data['TransactionRoles'] = $this->Employee_model->GetTransactionRoles($this->session->userdata('EmployeeId'));
	    $data['ReportsRoles'] = $this->Employee_model->GetReportsRoles($this->session->userdata('EmployeeId'));
	    $data['GetEmployee']=$this->Employee_model->GetEmployee($EmployeeId);
	    $data['CustomerNotification'] = $this->Customer_model->GetNotifications();
	    $this->load->view('employee/view_employee',$data);	
	}
        
	
        public function EditEmployee($EmployeeId)
	{
            $data['AdministrationRoles'] = $this->Employee_model->GetAdministrationRoles($this->session->userdata('EmployeeId'));
            $data['SalesRoles'] = $this->Employee_model->GetSalesRoles($this->session->userdata('EmployeeId'));
            $data['PurchasesRoles'] = $this->Employee_model->GetPurchasesRoles($this->session->userdata('EmployeeId'));
            $data['RegistrationRoles'] = $this->Employee_model->GetRegistrationRoles($this->session->userdata('EmployeeId'));
	    $data['TransactionRoles'] = $this->Employee_model->GetTransactionRoles($this->session->userdata('EmployeeId'));
            $data['ReportsRoles'] = $this->Employee_model->GetReportsRoles($this->session->userdata('EmployeeId'));
            $data['GetAllDesignations'] = $this->Designation_model->GetAllDesignations();
            $data['GetEmployee']=$this->Employee_model->GetEmployee($EmployeeId);
            $data['CustomerNotification'] = $this->Customer_model->GetNotifications();

            $this->load->view('employee/edit_employee',$data);
	}       
        
        public function EmployeeRoles($EmployeeId)
        {
            ini_set('display_errors', 1); ini_set('display_startup_errors', 1); error_reporting(E_ALL);
           $data['Roles'] = $this->Employee_model->GetRoles();
           $data['EmployeeRoles'] = $this->Employee_model->GetEmployeeRoles($EmployeeId);
        
           $data['AdministrationRoles'] = $this->Employee_model->GetAdministrationRoles($this->session->userdata('EmployeeId'));
           $data['SalesRoles'] = $this->Employee_model->GetSalesRoles($this->session->userdata('EmployeeId'));
           $data['PurchasesRoles'] = $this->Employee_model->GetPurchasesRoles($this->session->userdata('EmployeeId'));
           $data['RegistrationRoles'] = $this->Employee_model->GetRegistrationRoles($this->session->userdata('EmployeeId'));
	   $data['TransactionRoles'] = $this->Employee_model->GetTransactionRoles($this->session->userdata('EmployeeId'));
           $data['ReportsRoles'] = $this->Employee_model->GetReportsRoles($this->session->userdata('EmployeeId')); 
           $data['CustomerNotification'] = $this->Customer_model->GetNotifications();
             // print_r($data['EmployeeRoles']);
             
           $this->load->view("employee/view_employeeroles",$data);
        }
        
        public function InsertEmployee()
	{
            $LastEmployeeId = $this->Employee_model->SaveEmployee();
            $this->session->set_flashdata("record_added","Record added successfully."); 
            redirect("Employee/ViewEmployee/$LastEmployeeId");
	}

	
       public function SaveEmployee($EmployeeId)
       {
            $EmployeeData = array(
            'EmployeeName' => $this->input->post('EmployeeName'),
            'DesignationId' => $this->input->post('DesignationId'),
            'Gender' => $this->input->post('Gender'),
            'CompanyId' => $this->session->userdata('CompanyId'),
            'EmployeeType' => $this->input->post('EmployeeType'),
            'Status' => 1,
            'EmailAddress' => $this->input->post('EmailAddress'),
            'Password' => $this->input->post('Password'),
            'CellNo' => $this->input->post('CellNo'),
            'JoiningDate' => date('Y-m-d', strtotime($this->input->post('JoiningDate'))),
            'HomeAddress' => $this->input->post('HomeAddress'),
            'AddedOn' => date("Y-m-d H:i:s"),
            'AddedBy' => $this->session->userdata('EmployeeId'),
            );
            $LastEmployeeId = $this->Employee_model->UpdateEmployee($EmployeeData,$EmployeeId);
            $this->session->set_flashdata("record_added","Record added successfully."); 
            redirect("Employee/ViewEmployee/$LastEmployeeId");
	}

	
        public function DeleteEmployee($EmployeeId)
        {
            if ($this->Employee_model->DeleteEmployee($EmployeeId)) {
           $this->session->set_flashdata("record_deleted","Record deleted successfully."); 
           redirect("Employee");
            }
        }
        
        
      public function UpdateEmployee($EmployeeId)
      {
          if($this->Employee_model->UpdateEmployee($EmployeeId))
          {
              $this->session->set_flashdata("record_update","Record update successfully."); 
              redirect("Employee/ViewEmployee/$EmployeeId");
          }
	    }
        
        
    //     public function EmployeeRoles($EmployeeId)
    //     {
    //       $data['Roles'] = $this->Employee_model->GetRoles();
    //       $data['EmployeeRoles'] = $this->Employee_model->GetEmployeeRoles($EmployeeId);
    //       $data['AdministrationRoles'] = $this->Employee_model->GetAdministrationRoles($this->session->userdata('EmployeeId'));
    //       $data['SalesRoles'] = $this->Employee_model->GetSalesRoles($this->session->userdata('EmployeeId'));
    //       $data['PurchasesRoles'] = $this->Employee_model->GetPurchasesRoles($this->session->userdata('EmployeeId'));
    //       $data['RegistrationRoles'] = $this->Employee_model->GetRegistrationRoles($this->session->userdata('EmployeeId'));
	   //$data['TransactionRoles'] = $this->Employee_model->GetTransactionRoles($this->session->userdata('EmployeeId'));
    //       $data['ReportsRoles'] = $this->Employee_model->GetReportsRoles($this->session->userdata('EmployeeId')); 
    //       $data['CustomerNotification'] = $this->Customer_model->GetNotifications();
    //       $this->load->view("admin/employee/view_employee_roles",$data);
    //     }
        
        
        public function UpdateEmployeeRoles()
        {
           $CheckboxData = $this->input->post();
          /*
           echo "<pre>";
           print_r($CheckboxData);
           die;
           */
           $ErrMessage = 'Record updated successfully';
           $this->session->set_flashdata("record_updated",'<div style="text-align:center;" class="callout callout-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'.$ErrMessage.'</div>');
           
           $data = $this->Employee_model->GetEmployeeRoles($CheckboxData['EmployeeId']);
           
           $i=0;
           foreach ($data as $rows):
         
            if(isset($CheckboxData['ViewRoles'.$i]))
            $this->Employee_model->UpdatetEmployeeRoles($CheckboxData['EmployeeId'], $rows['RoleId'], 'ViewRoles');
            else
            $this->Employee_model->UpdateEmployeeRolesZero($CheckboxData['EmployeeId'], $rows['RoleId'], 'ViewRoles');
            
            if(isset($CheckboxData['AddRoles'.$i]))
            $this->Employee_model->UpdatetEmployeeRoles($CheckboxData['EmployeeId'], $rows['RoleId'], 'AddRoles');
            else
            $this->Employee_model->UpdateEmployeeRolesZero($CheckboxData['EmployeeId'], $rows['RoleId'], 'AddRoles');
           
            if(isset($CheckboxData['UpdateRoles'.$i]))
            $this->Employee_model->UpdatetEmployeeRoles($CheckboxData['EmployeeId'], $rows['RoleId'], 'UpdateRoles');
            else
            $this->Employee_model->UpdateEmployeeRolesZero($CheckboxData['EmployeeId'], $rows['RoleId'], 'UpdateRoles');
            
            if(isset($CheckboxData['DeleteRoles'.$i]))
            $this->Employee_model->UpdatetEmployeeRoles($CheckboxData['EmployeeId'], $rows['RoleId'], 'DeleteRoles');
            else
            $this->Employee_model->UpdateEmployeeRolesZero($CheckboxData['EmployeeId'], $rows['RoleId'], 'DeleteRoles');
            
           $i++;
           endforeach;
          
           redirect("Employee/EmployeeRoles/".$CheckboxData['EmployeeId']);
        }
}
?>