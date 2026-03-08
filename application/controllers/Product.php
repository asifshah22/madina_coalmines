<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Product extends CI_Controller {

	public function __construct()
	{
	    parent::__construct();	
	    $this->check_isvalidated();
	    $this->load->model('Product_model');
	    $this->load->model('Employee_model');
	    $this->load->model('ProductGroup_model');
	    $this->load->model('Customer_model');
	}
	
	
	private function check_isvalidated()
	{
		if(!$this->session->userdata('EmployeeId'))
		{  $this->session->set_userdata('url',  current_url()); redirect('Login'); }
	}
	        
        
    public function index()
	{
        $data['Roles'] = $this->Employee_model->GetRoles();
        $data['EmployeeRoles'] = $this->Employee_model->GetEmployeeRoles($this->session->userdata('EmployeeId'));
        $data['AdministrationRoles'] = $this->Employee_model->GetAdministrationRoles($this->session->userdata('EmployeeId'));
        $data['SalesRoles'] = $this->Employee_model->GetSalesRoles($this->session->userdata('EmployeeId'));
        $data['PurchasesRoles'] = $this->Employee_model->GetPurchasesRoles($this->session->userdata('EmployeeId'));
        $data['RegistrationRoles'] = $this->Employee_model->GetRegistrationRoles($this->session->userdata('EmployeeId'));
        $data['TransactionRoles'] = $this->Employee_model->GetTransactionRoles($this->session->userdata('EmployeeId'));
        $data['ReportsRoles'] = $this->Employee_model->GetReportsRoles($this->session->userdata('EmployeeId'));
        $data['CustomerNotification'] = $this->Customer_model->GetNotifications();
        $this->load->view('product/products',$data);
	}

    public function Ajax_GetAllProducts()
    {
        $AdministrationRoles = $this->Employee_model->GetAdministrationRoles($this->session->userdata('EmployeeId'));
        $Ajax_GetAllProducts=$this->Product_model->Ajax_GetAllProducts($_REQUEST);
            $ViewRecord = '<span style="color:#00a65a;" class="glyphicon glyphicon-th-large"></span>';
            $UpdateRecord = '<span style="color:#0c6aad;" class="fa fa-edit">';

            $data = array();
            foreach($Ajax_GetAllProducts['record'] as $row)
            {
                $nestedData=array(); 
                $nestedData[] = $row['ProductName'];
                $nestedData[] = $row['CategoryName'];
                $nestedData[] = $row['BrandName'];
                $nestedData[] = $row["PurchasePrice"];
                $id = $row["ProductId"];
                if ($AdministrationRoles[3]['ViewRoles']==1 && $AdministrationRoles[3]['UpdateRoles']==1) {
                $nestedData[] = '<a href="'.base_url().'Product/ViewProduct/'.$id.'" title="View Record">'.$ViewRecord.'</a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="'.base_url().'Product/EditProduct/'.$id.'"title="Update Record"><span style="color:#0c6aad;" class="fa fa-edit"></span></a>';
                }
                else{
                $nestedData[] = '<a href="'.base_url().'Product/ViewProduct/'.$id.'" title="View Record">'.$ViewRecord.'</a>';
                }
            
                $data[] = $nestedData;
            }

                $json_data = array(
            "draw" => intval( $_REQUEST['draw'] ),   // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw. 
            "recordsTotal"    => intval( $Ajax_GetAllProducts['recordsTotal'] ),  // total number of records
            "recordsFiltered" => intval( $Ajax_GetAllProducts['recordsFiltered'] ), // total number of records after searching, if there is no searching then totalFiltered = totalData
            "data" => $data   // total data array
            );
                echo json_encode($json_data);  // send data as json format
        }
	
	
	public function AddProduct()
	{
        $data['Roles'] = $this->Employee_model->GetRoles();
        $data['EmployeeRoles'] = $this->Employee_model->GetEmployeeRoles($this->session->userdata('EmployeeId'));
        $data['AdministrationRoles'] = $this->Employee_model->GetAdministrationRoles($this->session->userdata('EmployeeId'));
        $data['SalesRoles'] = $this->Employee_model->GetSalesRoles($this->session->userdata('EmployeeId'));
        $data['PurchasesRoles'] = $this->Employee_model->GetPurchasesRoles($this->session->userdata('EmployeeId'));
        $data['RegistrationRoles'] = $this->Employee_model->GetRegistrationRoles($this->session->userdata('EmployeeId'));
        $data['TransactionRoles'] = $this->Employee_model->GetTransactionRoles($this->session->userdata('EmployeeId'));
        $data['ReportsRoles'] = $this->Employee_model->GetReportsRoles($this->session->userdata('EmployeeId'));   
        $data['GetAllCategories'] = $this->ProductGroup_model->GetAllCategories();
        $data['GetAllProductGroup'] = $this->ProductGroup_model->GetAllProductGroups();
        $data['GetAllBrands'] = $this->Product_model->GetAllBrands();
        $data['GetColours']= $this->Product_model->GetAllColours();
        $data['CustomerNotification'] = $this->Customer_model->GetNotifications();
        $this->load->view('product/add_product', $data);
	}
        
	
    public function EditProduct($ProductId)
    {
        $data['Roles'] = $this->Employee_model->GetRoles();
        $data['AdministrationRoles'] = $this->Employee_model->GetAdministrationRoles($this->session->userdata('EmployeeId'));
        $data['SalesRoles'] = $this->Employee_model->GetSalesRoles($this->session->userdata('EmployeeId'));
        $data['PurchasesRoles'] = $this->Employee_model->GetPurchasesRoles($this->session->userdata('EmployeeId'));
        $data['RegistrationRoles'] = $this->Employee_model->GetRegistrationRoles($this->session->userdata('EmployeeId'));
        $data['TransactionRoles'] = $this->Employee_model->GetTransactionRoles($this->session->userdata('EmployeeId'));
        $data['ReportsRoles'] = $this->Employee_model->GetReportsRoles($this->session->userdata('EmployeeId'));
/*	    $data['GetAllProductGroup'] = $this->Product_model->Ajax_GetAllProducts('ims_productgroup.CategoryId,ims_productgroup.ProductGroupId,ims_productgroup.ProductGroupName');	*/
        $data['GetAllCategories'] = $this->ProductGroup_model->GetAllCategories();
        $data['GetAllProductGroup'] = $this->ProductGroup_model->GetAllProductGroups();
        $data['GetAllBrands'] = $this->Product_model->GetAllBrands();
        $data['GetColours']= $this->Product_model->GetAllColours();
        $data['GetProduct']= $this->Product_model->GetProduct($ProductId);
        $data['CustomerNotification'] = $this->Customer_model->GetNotifications();
        $this->load->view('product/edit_product', $data);		
    }
	
        
    public function ViewProduct($ProductId)
    {
        $data['Roles'] = $this->Employee_model->GetRoles();
        $data['AdministrationRoles'] = $this->Employee_model->GetAdministrationRoles($this->session->userdata('EmployeeId'));
        $data['SalesRoles'] = $this->Employee_model->GetSalesRoles($this->session->userdata('EmployeeId'));
        $data['PurchasesRoles'] = $this->Employee_model->GetPurchasesRoles($this->session->userdata('EmployeeId'));
        $data['RegistrationRoles'] = $this->Employee_model->GetRegistrationRoles($this->session->userdata('EmployeeId'));
        $data['TransactionRoles'] = $this->Employee_model->GetTransactionRoles($this->session->userdata('EmployeeId'));
        $data['ReportsRoles'] = $this->Employee_model->GetReportsRoles($this->session->userdata('EmployeeId'));
        $data['GetProduct']= $this->Product_model->GetProduct($ProductId);
        $data['CustomerNotification'] = $this->Customer_model->GetNotifications();
        $this->load->view('product/view_product', $data);
    }

        
	public function SaveProduct()
	{
        
    	$data['CategoryId'] = $this->input->post('CategoryId');
        $data['ProductGroupId'] = $this->input->post('ProductGroupId');
        $data['BrandId'] = $this->input->post('BrandId');
        $data['ProductName'] = $this->input->post('ProductName');
        $data['ProductBarCode'] = $this->input->post('ProductBarCode');
        $data['SerialNumber'] = $this->input->post('SerialNumber');
        $data['MinimumStock'] = $this->input->post('MinimumStock');
        $data['PurchasePrice'] = $this->input->post('PurchasePrice');
        $data['SellPrice'] = $this->input->post('SellPrice');
        $data['FinalPrice'] = $this->input->post('FinalPrice');
        $data['ProductDetails'] = $this->input->post('ProductDetails');
        $data['OpeningStock'] = $this->input->post('OpeningStock');
        $data['OpeningStockDate'] = date('Y-m-d', strtotime($this->input->post('OpeningStockDate')));
        $data['Policy'] = $this->input->post('Policy');
        $data['AddedOn'] = date('Y-m-d H:i:s');
        $data['AddedBy'] = $this->session->userdata('EmployeeId');
       
	    $NewProductId = $this->Product_model->SaveProductDetail($data);
        if(isset($NewProductId))
        {  
            $this->session->set_flashdata("record_added","Record added successfully."); 
            redirect("Product/ViewProduct/$NewProductId");
        }
	}
	
	
	public function UpdateProduct($ProductId)
{
    // Debug - check what's being posted
    // echo "<pre>"; print_r($this->input->post()); echo "</pre>"; exit;
    
    $data['CategoryId'] = $this->input->post('CategoryId');
    $data['ProductGroupId'] = $this->input->post('ProductGroupId');
    $data['BrandId'] = $this->input->post('BrandId');
    $data['ProductName'] = $this->input->post('ProductName');
    $data['ProductBarCode'] = $this->input->post('ProductBarCode');
    $data['SerialNumber'] = $this->input->post('SerialNumber');
    $data['MinimumStock'] = $this->input->post('MinimumStock');
    $data['PurchasePrice'] = $this->input->post('PurchasePrice');
    $data['SellPrice'] = $this->input->post('SellPrice');
    $data['FinalPrice'] = $this->input->post('FinalPrice');
    $data['ProductDetails'] = $this->input->post('ProductDetails');
    $data['OpeningStock'] = $this->input->post('OpeningStock'); // THIS WAS MISSING
    $data['OpeningStockDate'] = date('Y-m-d', strtotime($this->input->post('OpeningStockDate')));
    $data['Policy'] = $this->input->post('Policy');
    $data['AddedOn'] = date('Y-m-d H:i:s');
    $data['AddedBy'] = $this->session->userdata('EmployeeId');

    // Handle file upload if a new image was provided
    if(!empty($_FILES['ProductImage']['name'])) {
        $config['upload_path'] = './uploads/products/';
        $config['allowed_types'] = 'gif|jpg|png';
        $config['max_size'] = 2048;
        
        $this->load->library('upload', $config);
        
        if($this->upload->do_upload('ProductImage')) {
            $upload_data = $this->upload->data();
            $data['ProductImage'] = $upload_data['file_name'];
            
            // Optionally delete old image
            $old_image = $this->Product_model->GetProduct($ProductId)->ProductImage;
            if($old_image && file_exists('./uploads/products/'.$old_image)) {
                unlink('./uploads/products/'.$old_image);
            }
        }
    }

    $this->Product_model->UpdateProductDetail($data, $ProductId);
    
    $this->session->set_flashdata("record_update", "Record updated successfully."); 
    redirect("Product/ViewProduct/$ProductId");
}

	
	public function DeleteProduct($ProductId)
	{
        if($this->Product_model->DeleteProduct($ProductId)){
        $this->session->set_flashdata("record_deleted","Record deleted successfully."); 
        redirect("Product");
        }
	}
}

?>