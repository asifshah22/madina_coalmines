<?php defined('BASEPATH') OR exit('No direct script access allowed');
class PurchaseReturn extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->check_isvalidated();
		$this->load->model('Company_model');
		$this->load->model('Product_model');
		$this->load->model('Purchase_model');	
		$this->load->model('PurchaseReturn_model');
		$this->load->model('Employee_model');
		$this->load->model('Accounts_model');
		$this->load->model('Account_model');
		$this->load->model('Customer_model');
		$this->load->helper("url");
//		$this->output->enable_profiler();
	}

	private function check_isvalidated()
	{
            if(!$this->session->userdata('EmployeeId'))
            { $this->session->set_userdata('url',  current_url()); redirect('Login'); }
	}
	
	function index()
	{
//	     die('To be uploaded soon!');
	    $data['AdministrationRoles'] = $this->Employee_model->GetAdministrationRoles($this->session->userdata('EmployeeId'));
	    $data['SalesRoles'] = $this->Employee_model->GetSalesRoles($this->session->userdata('EmployeeId'));
	    $data['PurchasesRoles'] = $this->Employee_model->GetPurchasesRoles($this->session->userdata('EmployeeId'));
	    $data['RegistrationRoles'] = $this->Employee_model->GetRegistrationRoles($this->session->userdata('EmployeeId'));
	    $data['TransactionRoles'] = $this->Employee_model->GetTransactionRoles($this->session->userdata('EmployeeId'));
	    $data['ReportsRoles'] = $this->Employee_model->GetReportsRoles($this->session->userdata('EmployeeId'));
	    $data['AllPurchaseReturn'] = $this->PurchaseReturn_model->GetAllPurchaseReturn();
	    $data['CustomerNotification'] = $this->Customer_model->GetNotifications();
	    $this->load->view('purchasereturn/purchase_return', $data);
	}


	public function Ajax_GetAllPurchaseReturn()
	{
	    $PurchasesRoles = $this->Employee_model->GetPurchasesRoles($this->session->userdata('EmployeeId'));
		
	    $GetAllPurchaseReturn=$this->PurchaseReturn_model->Ajax_GetAllPurchaseReturn($_REQUEST);
    
            $ViewRecord = '<span style="color:#00a65a;" class="glyphicon glyphicon-th-large"></span>';
            $UpdateRecord = '<span style="color:#0c6aad;" class="fa fa-edit">';

            $data = array();
            $PurchaseReturnType = "";
            foreach($GetAllPurchaseReturn['record'] as $row)
            {	
            	if($row["PurchaseReturnType"] == "1"){
            		$PurchaseReturnType = '<span class="label label-success">On Cash</span>';
            	}
            	if($row["PurchaseReturnType"] == "2"){
            		$PurchaseReturnType = '<span class="label label-danger">On Credit</span>';
            	}
            	if($row["PurchaseReturnType"] == "3"){
            		$PurchaseReturnType = '<span class="label" style="background-color:#39cccc; color:#fff">Online</span>';
            	}

                $nestedData=array(); 
                $nestedData[] = $row['PurchaseReturnId'];
//				$nestedData[] = $row['VendorName'];
                $nestedData[] = date("M d, Y", strtotime($row["PurchaseReturnDate"]));
				$nestedData[] = $PurchaseReturnType;
                $nestedData[] = $row["TotalAmount"];
                $id = $row["PurchaseReturnId"];
		
				$nestedData[] = '<a href="'.base_url().'PurchaseReturn/ViewPurchaseReturn/'.$id.'" title="View Record">'.$ViewRecord.'</a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="'.base_url().'PurchaseReturn/EditPurchaseReturn/'.$id.'"title="Update Record"><span style="color:#0c6aad;" class="fa fa-edit"></span></a>';
        	
                $data[] = $nestedData;
            }

                $json_data = array(
			"draw" => intval( $_REQUEST['draw'] ),   // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw. 
			"recordsTotal"    => intval( $GetAllPurchaseReturn['recordsTotal'] ),  // total number of records
			"recordsFiltered" => intval( $GetAllPurchaseReturn['recordsFiltered'] ), // total number of records after searching, if there is no searching then totalFiltered = totalData
			"data" => $data   // total data array
			);
                echo json_encode($json_data);  // send data as json format
        }
	

	function ViewPurchaseReturn($PurchaseReturnId)
	{	    
	    $data['AdministrationRoles'] = $this->Employee_model->GetAdministrationRoles($this->session->userdata('EmployeeId'));
	    $data['SalesRoles'] = $this->Employee_model->GetSalesRoles($this->session->userdata('EmployeeId'));
	    $data['PurchasesRoles'] = $this->Employee_model->GetPurchasesRoles($this->session->userdata('EmployeeId'));
	    $data['RegistrationRoles'] = $this->Employee_model->GetRegistrationRoles($this->session->userdata('EmployeeId'));
	    $data['TransactionRoles'] = $this->Employee_model->GetTransactionRoles($this->session->userdata('EmployeeId'));
	    $data['ReportsRoles'] = $this->Employee_model->GetReportsRoles($this->session->userdata('EmployeeId'));

	    $data['Purchases'] = $this->PurchaseReturn_model->GetPurchaseReturn($PurchaseReturnId);	   
	    $data['PurchaseDetail'] = $this->PurchaseReturn_model->GetPurchaseReturnDetail($PurchaseReturnId);
	    $data['CustomerNotification'] = $this->Customer_model->GetNotifications();
	    $this->load->view('purchasereturn/view_purchasereturn', $data);
	}
	
	
	public function AddPurchaseReturn()
	{	    
	    $data['AdministrationRoles'] = $this->Employee_model->GetAdministrationRoles($this->session->userdata('EmployeeId'));
	    $data['SalesRoles'] = $this->Employee_model->GetSalesRoles($this->session->userdata('EmployeeId'));
	    $data['PurchasesRoles'] = $this->Employee_model->GetPurchasesRoles($this->session->userdata('EmployeeId'));
	    $data['RegistrationRoles'] = $this->Employee_model->GetRegistrationRoles($this->session->userdata('EmployeeId'));
	    $data['TransactionRoles'] = $this->Employee_model->GetTransactionRoles($this->session->userdata('EmployeeId'));
	    $data['ReportsRoles'] = $this->Employee_model->GetReportsRoles($this->session->userdata('EmployeeId'));
	    $data['AllVendors']=$this->Purchase_model->GetAllVendors();
	   	$data['GetAllBankAccounts']=$this->Account_model->GetAllBankAccounts();
	   	$data['CustomerNotification'] = $this->Customer_model->GetNotifications();
	    $this->load->view('purchasereturn/add_purchasereturn', $data);
	}

	public function EditPurchaseReturn($PurchaseReturnId)
	{
	    $data['AdministrationRoles'] = $this->Employee_model->GetAdministrationRoles($this->session->userdata('EmployeeId'));
	    $data['SalesRoles'] = $this->Employee_model->GetSalesRoles($this->session->userdata('EmployeeId'));
	    $data['PurchasesRoles'] = $this->Employee_model->GetPurchasesRoles($this->session->userdata('EmployeeId'));
	    $data['RegistrationRoles'] = $this->Employee_model->GetRegistrationRoles($this->session->userdata('EmployeeId'));
	    $data['TransactionRoles'] = $this->Employee_model->GetTransactionRoles($this->session->userdata('EmployeeId'));
	    $data['ReportsRoles'] = $this->Employee_model->GetReportsRoles($this->session->userdata('EmployeeId'));
	    $data['AllVendors']=$this->Purchase_model->GetAllVendors();
	    $data['GetAllBankAccounts']=$this->Account_model->GetAllBankAccounts();
	    $data['Purchases'] = $this->PurchaseReturn_model->GetPurchaseReturn($PurchaseReturnId);	   
	    $data['PurchaseDetail'] = $this->PurchaseReturn_model->GetPurchaseReturnDetail($PurchaseReturnId);
	    $data['CustomerNotification'] = $this->Customer_model->GetNotifications();
	    $this->load->view('purchasereturn/edit_purchasereturn', $data);
	     
	}
    
	public function SavePurchaseReturn()
	{
       $PurchaseReturnId = $this->PurchaseReturn_model->SavePurchaseReturnDetail();

   	    for ($i=0; $i < count($this->input->post('LocationId')); $i++) {
    	$LocationId = $this->input->post('LocationId')[$i];
	    $ProductId = $this->input->post('ProductId')[$i];
	    $ColourId = $this->input->post('ColourId')[$i];
	    $Quantity = $this->input->post('Quantity')[$i];
    		if($CheckStockSummary = $this->PurchaseReturn_model->CheckStockSummary($LocationId,$ProductId,$ColourId)){
		$SummaryId = $CheckStockSummary->SummaryId;
		$AvailableQuantity = $CheckStockSummary->Quantity;
		$NewQuantity = ($AvailableQuantity - $Quantity);
		$this->PurchaseReturn_model->UpdateStockSummary($SummaryId,$LocationId,$ProductId,$ColourId,$NewQuantity);
			}
		}

       redirect(base_url()."PurchaseReturn/ViewPurchaseReturn/$PurchaseReturnId");
   	}


	public function SavePurchaseReturn__()
	{
	   //$AddPurchaseReturnRecord = $this->input->post('AddPurchaseReturnRecordBtn');
	    
	   //if($AddPurchaseReturnRecord =='AddPurchaseReturnRecord')
	   //{
	      //if($PurchaseReturnId = $this->PurchaseReturn_model->SavePurchaseReturnDetail())
	      //{
	       $PurchaseReturnId = $this->PurchaseReturn_model->SavePurchaseReturnDetail();
	       redirect(base_url()."PurchaseReturn/ViewPurchaseReturn/$PurchaseReturnId");
	      //}
	   //}
	    
	}


	public function UpdatePurchaseReturn__()
	{
	    $PurchaseReturnId = $this->input->post('PurchaseReturnId');
	    
	    $this->PurchaseReturn_model->UpdatePurchaseReturnDetail($PurchaseReturnId);
	    if($PurchaseReturnId != '') 
	    {
	        $Message = 'Record updated successfully';
		$this->session->set_flashdata("success_message",$Message);
		redirect("PurchaseReturn/ViewPurchaseReturn/$PurchaseReturnId");
	    }

	}
		
	public function UpdatePurchaseReturn()
	{
	    $PurchaseReturnId = $this->input->post('PurchaseReturnId');
	    $PurchaseReturnId = $this->PurchaseReturn_model->UpdatePurchaseReturnDetail($PurchaseReturnId);
	    	for ($i=0; $i < count($this->input->post('LocationId')); $i++) {
@	   			$OldQuantity = $this->input->post('OldQuantity')[$i];
@			    $OldColourId = $this->input->post('OldColourId')[$i];
@			    $OldLocationId = $this->input->post('OldLocationId')[$i];
@			    $OldProductId = $this->input->post('OldProductId')[$i];

	    	$LocationId = $this->input->post('LocationId')[$i];
		    $ProductId = $this->input->post('ProductId')[$i];
		    $ColourId = $this->input->post('ColourId')[$i];
		    $Quantity = $this->input->post('Quantity')[$i];
	    	if($CheckStockSummary = $this->PurchaseReturn_model->CheckStockSummary($OldLocationId,$OldProductId,$OldColourId)){

				$SummaryId = $CheckStockSummary->SummaryId; // getting id of available stock summary
				$AvailableQuantity = $CheckStockSummary->Quantity; // quantity of that summary id
				$NewQuantity = ($AvailableQuantity - $OldQuantity); 
				// deducting quantity from db to hidden value

				$FinalQuantity = ($Quantity - $NewQuantity);
				// adding result quantity with input field quantity

			$this->PurchaseReturn_model->UpdateStockSummary($SummaryId,$LocationId,$ProductId,$ColourId,$FinalQuantity);
			}
			else{
				$this->PurchaseReturn_model->AddStockSummary($LocationId,$ProductId,$ColourId,$Quantity);
			}
		}
		redirect("PurchaseReturn/ViewPurchaseReturn/$PurchaseReturnId");
	}

    public function AutoCompleteProductList()
    {
	  $Product = $this->input->post('term');
      $query = $this->db->query
        ("SELECT 
          ProductId,ProductName,ProductBarCode
          FROM ims_products AS Product WHERE ProductName LIKE '%{$Product}%' OR ProductBarCode LIKE '{%$Product%}' LIMIT 10");
            
       $Products = array();
        	foreach ($query->result_array() as $key) {
                $ProductName = '';
                if($key['ProductName'] != '' || $key['ProductName'] != null )
                $ProductName = '-'.$key['ProductName'];
                $bn = array(
				'id' => trim($key['ProductId']),
                'value' => trim($key['ProductBarCode'].'-'.$key['ProductName'].$ProductName)
			);
		    $Products[] = $bn;
			}
                        
		echo json_encode($Products);
        }



	 public function AutoCompleteLocationList()
	 {
            	  
	   $LocationName = $this->input->post('LocationName');
	   $query = "";
	   $CompanyId = $this->session->userdata('CompanyId');

	   if($CompanyId != 0){
	   $query = $this->db->query("SELECT LocationId,LocationName FROM pos_locations AS L WHERE L.LocationName LIKE '%{$LocationName}%' AND L.CompanyId = '$CompanyId' LIMIT 10");
	   }

	   $query = $this->db->query("SELECT LocationId,LocationName FROM pos_locations AS P WHERE P.LocationName LIKE '%{$LocationName}%' LIMIT 10");
            
           $LocationList = array();
	   
           foreach ($query->result_array() as $key) 
	   {
			    
	     if($key['LocationName'] != '' || $key['LocationName'] != null )
	     { $LocationName = '-'.$key['LocationName']; }
	    
	     $Locations = array(
		'id' => trim($key['LocationId']),
		'value' => trim($key['LocationName'])
	     );
	     $LocationList[] = $Locations;
	     }
	     echo json_encode($LocationList);
          }
	  
	  
	 public function AutoCompleteColourList()
	 {
            	  
	   $ColourName = $this->input->post('ColourName');
	  
	   $CompanyId = $this->session->userdata('CompanyId');
	   if($CompanyId != 0){
	   $query = $this->db->query("SELECT ColourId,ColourName FROM pos_product_colours AS C WHERE C.ColourName LIKE '%{$ColourName}%' AND C.CompanyId = '$CompanyId' LIMIT 10");
	  	}
	   $query = $this->db->query("SELECT ColourId,ColourName FROM pos_product_colours AS C WHERE C.ColourName LIKE '%{$ColourName}%' LIMIT 10");
            
           $ColourList = array();	   
           foreach ($query->result_array() as $key) 
	   {			    
	     if($key['ColourName'] != '' || $key['ColourName'] != null )
	     { $ColourName = '-'.$key['ColourName']; }
	    
	     $Colours = array(
		'id' => trim($key['ColourId']),
		'value' => trim($key['ColourName'])
	     );
	     $ColourList[] = $Colours;
	     }
	     echo json_encode($ColourList);
          }

	
}
?>