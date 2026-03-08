<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Category extends CI_Controller {

	public function __construct()
	{
	    parent::__construct();
	    $this->check_isvalidated();
	    $this->load->model('Category_model');
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
//	    $data['AllCategories']=$this->Category_model->GetAllCategories();
	    $data['TotalRecord']=$this->Category_model->TotalRecord();
	    
	    $data['CustomerNotification'] = $this->Customer_model->GetNotifications();
	    $this->load->view('category/categories',$data);
	}

	public function Ajax_GetAllCategories()
	{
		$AdministrationRoles = $this->Employee_model->GetAdministrationRoles($this->session->userdata('EmployeeId'));
        $GetAllCategories=$this->Category_model->Ajax_GetAllCategories($_REQUEST);
        
        $ViewRecord = '<span style="color:#00a65a;" class="glyphicon glyphicon-th-large"></span>';
        $UpdateRecord = '<span style="color:#0c6aad;" class="fa fa-edit">';

            $data = array();
            foreach($GetAllCategories['record'] as $row)
            {
                $nestedData=array(); 
                $nestedData[] = $row["CategoryName"];
//                $nestedData[] = $row["CategoryStatus"];
                $id = $row["CategoryId"];
//                if ($AdministrationRoles[0]['ViewRoles']==1 && $AdministrationRoles[0]['UpdateRoles']==1) {
					$nestedData[] = '<a href="'.base_url().'Category/ViewCategory/'.$id.'" title="View Record">'.$ViewRecord.'</a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="'.base_url().'Category/EditCategory/'.$id.'"title="Update Record"><span style="color:#0c6aad;" class="fa fa-edit"></span></a>';
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
	
	
	public function AddCategory()
	{
	    $data['Roles'] = $this->Employee_model->GetRoles();
	    $data['AdministrationRoles'] = $this->Employee_model->GetAdministrationRoles($this->session->userdata('EmployeeId'));
	    $data['SalesRoles'] = $this->Employee_model->GetSalesRoles($this->session->userdata('EmployeeId'));
	    $data['RegistrationRoles'] = $this->Employee_model->GetRegistrationRoles($this->session->userdata('EmployeeId'));
	    $data['TransactionRoles'] = $this->Employee_model->GetTransactionRoles($this->session->userdata('EmployeeId'));
	    $data['PurchasesRoles'] = $this->Employee_model->GetPurchasesRoles($this->session->userdata('EmployeeId'));
	    $data['ReportsRoles'] = $this->Employee_model->GetReportsRoles($this->session->userdata('EmployeeId'));
	    
	    $data['CustomerNotification'] = $this->Customer_model->GetNotifications();
	    $this->load->view('category/add_category',$data);
	}
	
	
	public function ViewCategory($CategoryId)
	{
	    $data['Roles'] = $this->Employee_model->GetRoles();
	    $data['AdministrationRoles'] = $this->Employee_model->GetAdministrationRoles($this->session->userdata('EmployeeId'));
	    $data['SalesRoles'] = $this->Employee_model->GetSalesRoles($this->session->userdata('EmployeeId'));
	    $data['PurchasesRoles'] = $this->Employee_model->GetPurchasesRoles($this->session->userdata('EmployeeId'));
	    $data['RegistrationRoles'] = $this->Employee_model->GetRegistrationRoles($this->session->userdata('EmployeeId'));
	    $data['TransactionRoles'] = $this->Employee_model->GetTransactionRoles($this->session->userdata('EmployeeId'));
	    $data['ReportsRoles'] = $this->Employee_model->GetReportsRoles($this->session->userdata('EmployeeId')); 
	    $data['GetCategoryById'] = $this->Category_model->GetCategoryById($CategoryId);
	    
	    $data['CustomerNotification'] = $this->Customer_model->GetNotifications();
	    $this->load->view('category/view_category',$data);
	}
	
    
	public function EditCategory($CategoryId)
	{
	    $data['AdministrationRoles'] = $this->Employee_model->GetAdministrationRoles($this->session->userdata('EmployeeId'));
	    $data['SalesRoles'] = $this->Employee_model->GetSalesRoles($this->session->userdata('EmployeeId'));
	    $data['PurchasesRoles'] = $this->Employee_model->GetPurchasesRoles($this->session->userdata('EmployeeId'));
	    $data['RegistrationRoles'] = $this->Employee_model->GetRegistrationRoles($this->session->userdata('EmployeeId'));
	    $data['TransactionRoles'] = $this->Employee_model->GetTransactionRoles($this->session->userdata('EmployeeId'));
	    $data['ReportsRoles'] = $this->Employee_model->GetReportsRoles($this->session->userdata('EmployeeId')); 
	    $data['GetCategoryById'] = $this->Category_model->GetCategoryById($CategoryId);
	    
	    $data['CustomerNotification'] = $this->Customer_model->GetNotifications();
	    $this->load->view('category/edit_category',$data);
	}

	
	public function SaveCategory($categoryId='')
	{	
          
	    $data=$this->input->post();
	    $data['CategoryStatus'] = 1;
	    $data['AddedOn'] = date('Y-m-d H:i:s');
	    $data['AddedBy'] = $this->session->userdata('EmployeeId');

	    if($NewCategoryId =  $this->Category_model->SaveCategory($data,$categoryId))
	    {
	    redirect("Category/ViewCategory/$NewCategoryId");
	    }
	}

	
	public function DeleteCategory($CategoryId)
	{
	    if($this->Category_model->DeleteCategory($CategoryId))
	    {
		redirect("Category");
	    }
	}
}

?>