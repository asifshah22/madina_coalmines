<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Saleman extends CI_Controller {

	public function __construct()
	{
	    parent::__construct();
	    $this->check_isvalidated();
	    $this->load->model('Employee_model');
	    $this->load->model('Customer_model');
		$this->load->model('Saleman_model');
		$this->load->model('COA_model');
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
//	    $data['AllCategories']=$this->Category_model->GetAllCategories();
	    $data['TotalRecord']=$this->Saleman_model->TotalRecord();
	    
	    $data['CustomerNotification'] = $this->Customer_model->GetNotifications();
	    $this->load->view('saleman/saleman',$data);
	}

	public function Ajax_GetAllCategories()
	{
		$AdministrationRoles = $this->Employee_model->GetAdministrationRoles($this->session->userdata('EmployeeId'));
        $GetAllCategories=$this->Saleman_model->Ajax_GetAllCategories($_REQUEST);
        $ViewRecord = '<span style="color:#00a65a;" class="glyphicon glyphicon-th-large"></span>';
        $UpdateRecord = '<span style="color:#0c6aad;" class="fa fa-edit">';

            $data = array();
            foreach($GetAllCategories['record'] as $row)
            {
                $nestedData=array(); 
                $nestedData[] = $row["SalemanName"];
				$nestedData[] = $row["ContactNumber"];
				$nestedData[] = $row["Address"];
//                $nestedData[] = $row["CategoryStatus"];
                $id = $row["SalemanId"];
//                if ($AdministrationRoles[0]['ViewRoles']==1 && $AdministrationRoles[0]['UpdateRoles']==1) {
					$nestedData[] = '<a href="'.base_url().'Saleman/ViewSaleman/'.$id.'" title="View Record">'.$ViewRecord.'</a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="'.base_url().'Saleman/EditSaleman/'.$id.'"title="Update Record"><span style="color:#0c6aad;" class="fa fa-edit"></span></a>';
/*				}
				else{
				$nestedData[] = '<a href="'.base_url().'Category/ViewCategory/'.$id.'" title="View Record">'.$ViewRecord.'</a>';
				}*/
                $data[] = $nestedData;
            }

                $json_data = array(
			"draw" => intval( $_REQUEST['draw'] ),   // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw. 
			"recordsTotal"    => intval( $GetAllCategories['recordsTotal'] ),  // total number of records
			"recordsFiltered" => intval( $GetAllCategories['recordsFiltered'] ), // total number of records after searching, if there is no searching then totalFiltered = totalData
			"data" => $data   // total data array
			);
                echo json_encode($json_data);  // send data as json format
        }
	
	
	public function AddSaleman()
	{

		// control id 3 is account receivables
        $GetChartOfAccount  = $this->COA_model->GetChartOfAccountCode(17);

	    $data['Roles'] = $this->Employee_model->GetRoles();
	    $data['AdministrationRoles'] = $this->Employee_model->GetAdministrationRoles($this->session->userdata('EmployeeId'));
	    $data['SalesRoles'] = $this->Employee_model->GetSalesRoles($this->session->userdata('EmployeeId'));
	    $data['RegistrationRoles'] = $this->Employee_model->GetRegistrationRoles($this->session->userdata('EmployeeId'));
	    $data['TransactionRoles'] = $this->Employee_model->GetTransactionRoles($this->session->userdata('EmployeeId'));
	    $data['PurchasesRoles'] = $this->Employee_model->GetPurchasesRoles($this->session->userdata('EmployeeId'));
	    $data['ReportsRoles'] = $this->Employee_model->GetReportsRoles($this->session->userdata('EmployeeId'));
	    
		$data['Category_Id'] = $GetChartOfAccount->ChartOfAccountCategoryId;
        $data['ControlCode_Id'] = $GetChartOfAccount->ChartOfAccountControlId;
        $data['COA_Code'] = $this->COA_model->NextChartOfAccountCode(3,$GetChartOfAccount->COA_Code);
	    $data['CustomerNotification'] = $this->Customer_model->GetNotifications();
	    $this->load->view('saleman/add_saleman',$data);
	}
	
	
	public function ViewSaleman($CategoryId)
	{
	    $data['Roles'] = $this->Employee_model->GetRoles();
	    $data['AdministrationRoles'] = $this->Employee_model->GetAdministrationRoles($this->session->userdata('EmployeeId'));
	    $data['SalesRoles'] = $this->Employee_model->GetSalesRoles($this->session->userdata('EmployeeId'));
	    $data['PurchasesRoles'] = $this->Employee_model->GetPurchasesRoles($this->session->userdata('EmployeeId'));
	    $data['RegistrationRoles'] = $this->Employee_model->GetRegistrationRoles($this->session->userdata('EmployeeId'));
	    $data['TransactionRoles'] = $this->Employee_model->GetTransactionRoles($this->session->userdata('EmployeeId'));
	    $data['ReportsRoles'] = $this->Employee_model->GetReportsRoles($this->session->userdata('EmployeeId')); 
	    $data['GetCategoryById'] = $this->Saleman_model->GetCategoryById($CategoryId);
	    
	    $data['CustomerNotification'] = $this->Customer_model->GetNotifications();
	    $this->load->view('saleman/view_saleman',$data);
	}
	
    
	public function EditSaleman($CategoryId)
	{
	    $data['AdministrationRoles'] = $this->Employee_model->GetAdministrationRoles($this->session->userdata('EmployeeId'));
	    $data['SalesRoles'] = $this->Employee_model->GetSalesRoles($this->session->userdata('EmployeeId'));
	    $data['PurchasesRoles'] = $this->Employee_model->GetPurchasesRoles($this->session->userdata('EmployeeId'));
	    $data['RegistrationRoles'] = $this->Employee_model->GetRegistrationRoles($this->session->userdata('EmployeeId'));
	    $data['TransactionRoles'] = $this->Employee_model->GetTransactionRoles($this->session->userdata('EmployeeId'));
	    $data['ReportsRoles'] = $this->Employee_model->GetReportsRoles($this->session->userdata('EmployeeId')); 
	    $data['GetCategoryById'] = $this->Saleman_model->GetCategoryById($CategoryId);
	    
	    $data['CustomerNotification'] = $this->Customer_model->GetNotifications();
	    $this->load->view('saleman/edit_saleman',$data);
	}

	
	public function SaveSaleman($SalemanId=0)
	{	
	    $getSaleman = $this->Saleman_model->GetSalemanrByName($this->input->post('SalemanName'));
	    $Record=$this->input->post();

           if($SalemanId == 0)
           {
                if($this->input->post('SalemanName') == $getSaleman->SalemanName){
                    $this->session->set_flashdata("Validate_message","This saleman name already exist.");
                    redirect("Saleman/AddSaleman");
                }
                $LastSalemanId = $this->Saleman_model->SaveSalemanDetail($Record);
            if($LastSalemanId !='')
		      {
			    $this->session->set_flashdata("record_added","Record added successfully."); 
			    redirect("Saleman/ViewSaleman/$LastSalemanId");	
              }
           }
           else
           {
            //   if($this->input->post('CustomerName') == $getCustomers->CustomerName){
            //         $this->session->set_flashdata("Validate_message","This customer name already exist.");
            //         redirect("Customer/EditCustomer/$CustomerId");
            //     }
                
               $Status = $this->Saleman_model->SaveSalemanDetail($Record,$SalemanId);
               if($Status == 'success')
               {
                   $this->session->set_flashdata("record_update","Record update successfully.");
                   redirect("Saleman/ViewSaleman/$SalemanId");
               }    
           }
	}
	// public function SaveSaleman($categoryId='')
	// {	
          
	//     $data=$this->input->post();
	//     $data['SalemanStatus'] = 1;
	//     $data['AddedOn'] = date('Y-m-d H:i:s');
	//     $data['AddedBy'] = $this->session->userdata('EmployeeId');

	//     if($NewCategoryId =  $this->Saleman_model->SaveCategory($data,$categoryId))
	//     {
	//     redirect("Saleman/ViewSaleman/$NewCategoryId");
	//     }
	// }

	
	public function DeleteCategory($CategoryId)
	{
	    if($this->Saleman_model->DeleteCategory($CategoryId))
	    {
		redirect("Saleman");
	    }
	}
}

?>