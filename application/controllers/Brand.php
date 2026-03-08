<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Brand extends CI_Controller {

	public function __construct()
	{
	    parent::__construct();
	    $this->check_isvalidated();
	    $this->load->model('Brand_model');
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
//	    $data['AllBrands']=$this->Brand_model->GetAllBrands();
	    $data['TotalRecord']=$this->Brand_model->TotalRecord();
	    
	    $data['CustomerNotification'] = $this->Customer_model->GetNotifications();
	    $this->load->view('brand/brands',$data);
	}

	public function Ajax_GetAllBrands()
	{
		$AdministrationRoles = $this->Employee_model->GetAdministrationRoles($this->session->userdata('EmployeeId'));
        $GetAllBrands=$this->Brand_model->Ajax_GetAllBrands($_REQUEST);

        $ViewRecord = '<span style="color:#00a65a;" class="glyphicon glyphicon-th-large"></span>';
        $UpdateRecord = '<span style="color:#0c6aad;" class="fa fa-edit">';

            $data = array();
            foreach($GetAllBrands['record'] as $row)
            {
                $nestedData=array(); 
                $nestedData[] = $row['BrandId'];
                $nestedData[] = $row["BrandName"];
//                $nestedData[] = $row["BrandStatus"];
                $id = $row["BrandId"];
//                if ($AdministrationRoles[2]['ViewRoles']==1 && $AdministrationRoles[2]['UpdateRoles']==1) {
					$nestedData[] = '<a href="'.base_url().'Brand/ViewBrand/'.$id.'" title="View Record">'.$ViewRecord.'</a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="'.base_url().'Brand/EditBrand/'.$id.'"title="Update Record"><span style="color:#0c6aad;" class="fa fa-edit"></span></a>';
/*            	}
            	else{
					$nestedData[] = '<a href="'.base_url().'Brand/ViewBrand/'.$id.'" title="View Record">'.$ViewRecord.'</a>';
            	}*/
                $data[] = $nestedData;
            }

                $json_data = array(
			"draw" => intval( $_REQUEST['draw'] ),   // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw. 
			"recordsTotal"    => intval( $GetAllBrands['recordsTotal'] ),  // total number of records
			"recordsFiltered" => intval( $GetAllBrands['recordsFiltered'] ), // total number of records after searching, if there is no searching then totalFiltered = totalData
			"data" => $data   // total data array
			);
                echo json_encode($json_data);  // send data as json format
        }
	
	
	public function AddBrand()
	{
	    $data['Roles'] = $this->Employee_model->GetRoles();
	    $data['AdministrationRoles'] = $this->Employee_model->GetAdministrationRoles($this->session->userdata('EmployeeId'));
	    $data['SalesRoles'] = $this->Employee_model->GetSalesRoles($this->session->userdata('EmployeeId'));
	    $data['RegistrationRoles'] = $this->Employee_model->GetRegistrationRoles($this->session->userdata('EmployeeId'));
	    $data['TransactionRoles'] = $this->Employee_model->GetTransactionRoles($this->session->userdata('EmployeeId'));
	    $data['PurchasesRoles'] = $this->Employee_model->GetPurchasesRoles($this->session->userdata('EmployeeId'));
	    $data['ReportsRoles'] = $this->Employee_model->GetReportsRoles($this->session->userdata('EmployeeId')); 
	    
	    $data['CustomerNotification'] = $this->Customer_model->GetNotifications();
	    $this->load->view('brand/add_brand',$data);
	}
	
	
	public function ViewBrand($BrandId)
	{
	    $data['Roles'] = $this->Employee_model->GetRoles();
	    $data['AdministrationRoles'] = $this->Employee_model->GetAdministrationRoles($this->session->userdata('EmployeeId'));
	    $data['SalesRoles'] = $this->Employee_model->GetSalesRoles($this->session->userdata('EmployeeId'));
	    $data['PurchasesRoles'] = $this->Employee_model->GetPurchasesRoles($this->session->userdata('EmployeeId'));
	    $data['RegistrationRoles'] = $this->Employee_model->GetRegistrationRoles($this->session->userdata('EmployeeId'));
	    $data['TransactionRoles'] = $this->Employee_model->GetTransactionRoles($this->session->userdata('EmployeeId'));
	    $data['ReportsRoles'] = $this->Employee_model->GetReportsRoles($this->session->userdata('EmployeeId')); 
	    $data['GetBrandById'] = $this->Brand_model->GetBrandById($BrandId);
	    
	    $data['CustomerNotification'] = $this->Customer_model->GetNotifications();
	    $this->load->view('brand/view_brand',$data);
	}
	
    
	public function EditBrand($BrandId)
	{
	    $data['AdministrationRoles'] = $this->Employee_model->GetAdministrationRoles($this->session->userdata('EmployeeId'));
	    $data['SalesRoles'] = $this->Employee_model->GetSalesRoles($this->session->userdata('EmployeeId'));
	    $data['PurchasesRoles'] = $this->Employee_model->GetPurchasesRoles($this->session->userdata('EmployeeId'));
	    $data['RegistrationRoles'] = $this->Employee_model->GetRegistrationRoles($this->session->userdata('EmployeeId'));
	    $data['TransactionRoles'] = $this->Employee_model->GetTransactionRoles($this->session->userdata('EmployeeId'));
	    $data['ReportsRoles'] = $this->Employee_model->GetReportsRoles($this->session->userdata('EmployeeId')); 
	    $data['GetBrandById'] = $this->Brand_model->GetBrandById($BrandId);
	    $data['CustomerNotification'] = $this->Customer_model->GetNotifications();
	    $this->load->view('brand/edit_brand',$data);
	}

	
	public function SaveBrand($BrandId='')
	{	
          
	    $data=$this->input->post();
	    $data['AddedOn'] = date('Y-m-d H:i:s');
	    $data['AddedBy'] = $this->session->userdata('EmployeeId');

	    if($NewBrandId =  $this->Brand_model->SaveBrand($data,$BrandId))
	    {
	    redirect("Brand/ViewBrand/$NewBrandId");
	    }
	}

	
	public function DeleteBrand($BrandId)
	{
	    if($this->Brand_model->DeleteBrand($BrandId))
	    {
		redirect("Brand");
	    }
	}
}

?>