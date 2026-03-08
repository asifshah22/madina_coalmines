<?php defined('BASEPATH') OR exit('No direct script access allowed');

class ProductGroup extends CI_Controller {

	public function __construct()
	{
	    parent::__construct();
	    $this->check_isvalidated();
	    $this->load->model('ProductGroup_model');
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
//	    $data['AllProductGroups']=$this->ProductGroup_model->GetAllProductGroups();
	    $data['TotalRecord']=$this->ProductGroup_model->TotalRecord();
	    $data['CustomerNotification'] = $this->Customer_model->GetNotifications();
	    $this->load->view('productgroup/productgroups',$data);
	}

	public function Ajax_GetAllProductGroups()
	{
		$AdministrationRoles = $this->Employee_model->GetAdministrationRoles($this->session->userdata('EmployeeId'));
        $GetAllProductGroups=$this->ProductGroup_model->Ajax_GetAllProductGroups($_REQUEST);

        $ViewRecord = '<span style="color:#00a65a;" class="glyphicon glyphicon-th-large"></span>';
        $UpdateRecord = '<span style="color:#0c6aad;" class="fa fa-edit">';

            $data = array();
            foreach($GetAllProductGroups['record'] as $row)
            {
                $nestedData=array(); 
                $nestedData[] = $row['ProductGroupId'];
                $nestedData[] = $row['CategoryName'];
                $nestedData[] = $row["ProductGroupName"];
                $id = $row["ProductGroupId"];
//                if ($AdministrationRoles[1]['ViewRoles']==1 && $AdministrationRoles[1]['UpdateRoles']==1) {
					$nestedData[] = '<a href="'.base_url().'ProductGroup/ViewProductGroup/'.$id.'" title="View Record">'.$ViewRecord.'</a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="'.base_url().'ProductGroup/EditProductGroup/'.$id.'"title="Update Record"><span style="color:#0c6aad;" class="fa fa-edit"></span></a>';
  /*              }
                else{
					$nestedData[] = '<a href="'.base_url().'ProductGroup/ViewProductGroup/'.$id.'" title="View Record">'.$ViewRecord.'</a>';
				}*/
                $data[] = $nestedData;
            }

                $json_data = array(
			"draw" => intval( $_REQUEST['draw'] ),   // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw. 
			"recordsTotal"    => intval( $GetAllProductGroups['recordsTotal'] ),  // total number of records
			"recordsFiltered" => intval( $GetAllProductGroups['recordsFiltered'] ), // total number of records after searching, if there is no searching then totalFiltered = totalData
			"data" => $data   // total data array
			);
                echo json_encode($json_data);  // send data as json format
        }
	
	
	public function AddProductGroup()
	{
	    $data['Roles'] = $this->Employee_model->GetRoles();
	    $data['AdministrationRoles'] = $this->Employee_model->GetAdministrationRoles($this->session->userdata('EmployeeId'));
	    $data['SalesRoles'] = $this->Employee_model->GetSalesRoles($this->session->userdata('EmployeeId'));
	    $data['RegistrationRoles'] = $this->Employee_model->GetRegistrationRoles($this->session->userdata('EmployeeId'));
	    $data['TransactionRoles'] = $this->Employee_model->GetTransactionRoles($this->session->userdata('EmployeeId'));
	    $data['PurchasesRoles'] = $this->Employee_model->GetPurchasesRoles($this->session->userdata('EmployeeId'));
	    $data['ReportsRoles'] = $this->Employee_model->GetReportsRoles($this->session->userdata('EmployeeId')); 
	    $data['GetAllCategories'] = $this->ProductGroup_model->GetAllCategories();
	    $data['CustomerNotification'] = $this->Customer_model->GetNotifications();
	    $this->load->view('productgroup/add_productgroup',$data);
	}
	
	
	public function ViewProductGroup($ProductGroupId)
	{
	    $data['Roles'] = $this->Employee_model->GetRoles();
	    $data['AdministrationRoles'] = $this->Employee_model->GetAdministrationRoles($this->session->userdata('EmployeeId'));
	    $data['SalesRoles'] = $this->Employee_model->GetSalesRoles($this->session->userdata('EmployeeId'));
	    $data['PurchasesRoles'] = $this->Employee_model->GetPurchasesRoles($this->session->userdata('EmployeeId'));
	    $data['RegistrationRoles'] = $this->Employee_model->GetRegistrationRoles($this->session->userdata('EmployeeId'));
	    $data['TransactionRoles'] = $this->Employee_model->GetTransactionRoles($this->session->userdata('EmployeeId'));
	    $data['ReportsRoles'] = $this->Employee_model->GetReportsRoles($this->session->userdata('EmployeeId')); 
	    $data['GetProductGroupById'] = $this->ProductGroup_model->GetProductGroupById($ProductGroupId);
	    $data['CustomerNotification'] = $this->Customer_model->GetNotifications();
	    $this->load->view('productgroup/view_productgroup',$data);
	}
	
    
	public function EditProductGroup($ProductGroupId)
	{
	    $data['AdministrationRoles'] = $this->Employee_model->GetAdministrationRoles($this->session->userdata('EmployeeId'));
	    $data['SalesRoles'] = $this->Employee_model->GetSalesRoles($this->session->userdata('EmployeeId'));
	    $data['PurchasesRoles'] = $this->Employee_model->GetPurchasesRoles($this->session->userdata('EmployeeId'));
	    $data['RegistrationRoles'] = $this->Employee_model->GetRegistrationRoles($this->session->userdata('EmployeeId'));
	    $data['TransactionRoles'] = $this->Employee_model->GetTransactionRoles($this->session->userdata('EmployeeId'));
	    $data['ReportsRoles'] = $this->Employee_model->GetReportsRoles($this->session->userdata('EmployeeId')); 
	    $data['GetAllCategories'] = $this->ProductGroup_model->GetAllCategories();
	    $data['GetProductGroupById'] = $this->ProductGroup_model->GetProductGroupById($ProductGroupId);
	    $data['CustomerNotification'] = $this->Customer_model->GetNotifications();
	    $this->load->view('productgroup/edit_productgroup',$data);
	}

	
	public function SaveProductGroup($ProductGroupId='')
	{	
          
	    $data=$this->input->post();
	    $data['AddedOn'] = date('Y-m-d H:i:s');
	    $data['AddedBy'] = $this->session->userdata('EmployeeId');

	    if($NewProductGroupId =  $this->ProductGroup_model->SaveProductGroup($data,$ProductGroupId))
	    {
	    redirect("ProductGroup/ViewProductGroup/$NewProductGroupId");
	    }
	}

	
	public function DeleteProductGroup($ProductGroupId)
	{
	    if($this->ProductGroup_model->DeleteProductGroup($ProductGroupId))
	    {
		redirect("ProductGroup");
	    }
	}
}

?>