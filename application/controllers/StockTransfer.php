<?php defined('BASEPATH') OR exit('No direct script access allowed');
class StockTransfer extends CI_Controller {

	public function __construct()
	{
	    parent::__construct();
	    $this->check_isvalidated();
	    $this->load->model('StockTransfer_model');
	    $this->load->model('Location_model');
	    $this->load->model('Product_model');
//	    $this->load->model('Sale_model');
	    $this->load->model('Employee_model');
	    $this->load->model('Colour_model');
	    $this->load->model('Customer_model');
	  //  $this->output->enable_profiler(true);
	}

	
	private function check_isvalidated()
	{
            if(!$this->session->userdata('EmployeeId'))
            { $this->session->set_userdata('url',  current_url()); redirect('Login'); }
	}
	
	
	function index()
	{	
	    $data['AdministrationRoles'] = $this->Employee_model->GetAdministrationRoles($this->session->userdata('EmployeeId'));
	    $data['SalesRoles'] = $this->Employee_model->GetSalesRoles($this->session->userdata('EmployeeId'));
	    $data['PurchasesRoles'] = $this->Employee_model->GetPurchasesRoles($this->session->userdata('EmployeeId'));
	    $data['RegistrationRoles'] = $this->Employee_model->GetRegistrationRoles($this->session->userdata('EmployeeId'));
	    $data['TransactionRoles'] = $this->Employee_model->GetTransactionRoles($this->session->userdata('EmployeeId'));
	    $data['ReportsRoles'] = $this->Employee_model->GetReportsRoles($this->session->userdata('EmployeeId'));
	    $data['AllLocations']=$this->Location_model->GetAllLocation();
	    $data['CustomerNotification'] = $this->Customer_model->GetNotifications();
	    $this->load->view('stocktransfer/stock_transfers', $data);
	}

	public function Ajax_GetAllStockTransfer()
	{
		$SalesRoles = $this->Employee_model->GetSalesRoles($this->session->userdata('EmployeeId'));
        $GetAllStockTransfers=$this->StockTransfer_model->Ajax_GetAllStockTransfers($_REQUEST);

        $ViewRecord = '<span style="color:#00a65a;" class="glyphicon glyphicon-th-large"></span>';
        $UpdateRecord = '<span style="color:#0c6aad;" class="fa fa-edit">';
        
            $data = array();
            foreach($GetAllStockTransfers['record'] as $row)
            {
                $nestedData=array(); 
                $nestedData[] = $row['StockId'];
                $nestedData[] = $row["ProductName"];
                $nestedData[] = $row["LocationName"];
                $nestedData[] = $row["Quantity"];
                $id = $row["StockId"];
//                if ($StockTransfersRoles[0]['ViewRoles'] == 1 && $StockTransfersRoles[0]['UpdateRoles'] ==1 ) {
                $nestedData[] = '<a href="'.base_url().'StockTransfer/ViewStockTransfer/'.$id.'" title="View Record">'.$ViewRecord.'</a>';
  //              }
/*                if ($StockTransfersRoles[0]['ViewRoles'] == 1 ){
                $nestedData[] = anchor("StockTransfers/ViewStockTransfer/$id",'<i class="ace-icon fa fa-check bigger-130"></i>',array("class"=>"btn btn-xs btn-success","title"=>"View"));	
                }*/
			
                $data[] = $nestedData;
            }

                $json_data = array(
			"draw" => intval( $_REQUEST['draw'] ),   // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw. 
			"recordsTotal"    => intval( $GetAllStockTransfers['recordsTotal'] ),  // total number of records
			"recordsFiltered" => intval( $GetAllStockTransfers['recordsFiltered'] ), // total number of records after searching, if there is no searching then totalFiltered = totalData
			"data" => $data   // total data array
			);
                echo json_encode($json_data);  // send data as json format
        }

	public function ViewStockTransfer($SummaryId)
	{
	    $data['AdministrationRoles'] = $this->Employee_model->GetAdministrationRoles($this->session->userdata('EmployeeId'));
	    $data['SalesRoles'] = $this->Employee_model->GetSalesRoles($this->session->userdata('EmployeeId'));
	    $data['PurchasesRoles'] = $this->Employee_model->GetPurchasesRoles($this->session->userdata('EmployeeId'));
	    $data['RegistrationRoles'] = $this->Employee_model->GetRegistrationRoles($this->session->userdata('EmployeeId'));
	    $data['TransactionRoles'] = $this->Employee_model->GetTransactionRoles($this->session->userdata('EmployeeId'));
	    $data['ReportsRoles'] = $this->Employee_model->GetReportsRoles($this->session->userdata('EmployeeId'));

	    $data['AllLocations']=$this->Location_model->GetAllLocation();
	    $data['AllColours']=$this->Colour_model->GetAllColours();
//	    $data['StockTransferTo'] = $this->StockTransfer_model->StockTransferTo($SummaryId);
//	    $data['StockTransferFrom'] = $this->StockTransfer_model->StockTransferFrom($SummaryId);
//	    $data['StockTransfer'] = $this->StockTransfer_model->GetStockTransfer($SummaryId);
	    $data['StockTransferDetail'] = $this->StockTransfer_model->GetStockTransferDetail($SummaryId);
	    $data['CustomerNotification'] = $this->Customer_model->GetNotifications();
	    $this->load->view('stocktransfer/view_stocktransfer', $data);
	}

	public function AddStockTransfer()
	{ 
	    $data['AdministrationRoles'] = $this->Employee_model->GetAdministrationRoles($this->session->userdata('EmployeeId'));
	    $data['SalesRoles'] = $this->Employee_model->GetSalesRoles($this->session->userdata('EmployeeId'));
	    $data['PurchasesRoles'] = $this->Employee_model->GetPurchasesRoles($this->session->userdata('EmployeeId'));
	    $data['RegistrationRoles'] = $this->Employee_model->GetRegistrationRoles($this->session->userdata('EmployeeId'));
	    $data['TransactionRoles'] = $this->Employee_model->GetTransactionRoles($this->session->userdata('EmployeeId'));
	    $data['ReportsRoles'] = $this->Employee_model->GetReportsRoles($this->session->userdata('EmployeeId'));
		$data['AllEmployees']=$this->Employee_model->GetAllEmployees();
		$data['AllColours']=$this->Colour_model->GetAllColours();
	    $data['FromLocations']=$this->Location_model->FromLocations();
	    $data['AllLocations']=$this->Location_model->GetAllLocation();
	    $data['CustomerNotification'] = $this->Customer_model->GetNotifications();
	    $this->load->view('stocktransfer/add_stocktransfer', $data);
	}
	
	public function EditStockTransfer($StockTransferId)
	{   
	    $data['AdministrationRoles'] = $this->Employee_model->GetAdministrationRoles($this->session->userdata('EmployeeId'));
	    $data['SalesRoles'] = $this->Employee_model->GetSalesRoles($this->session->userdata('EmployeeId'));
	    $data['PurchasesRoles'] = $this->Employee_model->GetPurchasesRoles($this->session->userdata('EmployeeId'));
	    $data['RegistrationRoles'] = $this->Employee_model->GetRegistrationRoles($this->session->userdata('EmployeeId'));
	    $data['TransactionRoles'] = $this->Employee_model->GetTransactionRoles($this->session->userdata('EmployeeId'));
	    $data['ReportsRoles'] = $this->Employee_model->GetReportsRoles($this->session->userdata('EmployeeId'));

	    $data['AllLocations']=$this->Location_model->GetAllLocation();
	    $data['StockTransferTo'] = $this->StockTransfer_model->StockTransferTo($StockTransferId);
	    $data['StockTransferFrom'] = $this->StockTransfer_model->StockTransferFrom($StockTransferId);
	    $data['StockTransfer'] = $this->StockTransfer_model->GetStockTransfer($StockTransferId);
	    $data['StockTransferDetail'] = $this->StockTransfer_model->GetStockTransferDetail($StockTransferId);
	    $data['CustomerNotification'] = $this->Customer_model->GetNotifications();
	    $this->load->view('stocktransfer/edit_stocktransfer', $data);
	}
	
	public function SaveStockTransfer()
	{
		$data = $this->input->post();

		$SummaryId = "";
		$LocationFromId = $this->input->post('StockTransferFrom');
		$LocationToId = $this->input->post('StockTransferTo');
	    $ProductId = $this->input->post('ProductId');
	    $ColourId = $this->input->post('ColourId');
	    $Quantity = $this->input->post('Quantity');

	    	//saving stock transfer details in stocks_detail table
	    	$StockId = $this->StockTransfer_model->SaveStockTransferDetail($data);
	    
	    		// checking record if already exists in stock summary table
	    	if($CheckStockSummary = $this->StockTransfer_model->CheckStockSummary($LocationFromId,$ProductId,$ColourId)){
/**		print_r($CheckStockSummary);
		die;
		**/
				$SummaryId = $CheckStockSummary[0]['SummaryId'];
				$AvailableQuantity = $CheckStockSummary[0]['Quantity'];
				$NewQuantity = ($AvailableQuantity - $Quantity);

				$this->StockTransfer_model->UpdateStockSummary($SummaryId,$LocationFromId,$ProductId,$ColourId,$NewQuantity);
				}

				// check record of other location
			if($CheckOtherLocationStatus = $this->StockTransfer_model->CheckOtherLocationStatus($LocationToId,$ProductId,$ColourId)){

				$OtherSummaryId = $CheckOtherLocationStatus->SummaryId;
				$OtherAvailableQuantity = $CheckOtherLocationStatus->Quantity;
				$OtherNewQuantity = ($OtherAvailableQuantity + $Quantity);

				$this->StockTransfer_model->UpdateStockSummary($OtherSummaryId,$LocationToId,$ProductId,$ColourId,$OtherNewQuantity);
				}
//				$this->StockTransfer_model->AddStockSummary($LocationToId,$ProductId,$ColourId,$Quantity);
			else{
				$this->StockTransfer_model->AddStockSummary($LocationToId,$ProductId,$ColourId,$Quantity);
				}
	      	redirect(base_url()."StockTransfer/ViewStockTransfer/".$StockId);
	}
	
 
	public function UpdateStockTransfer($StockTransferId)
	{
		$LocationId = $this->input->post('LocationId');
	    $ProductId = $this->input->post('ProductId');
	    $ColourId = $this->input->post('ColourId');
	    $Quantity = $this->input->post('Quantity');

		$OldQuantity = $this->input->post('OldQuantity');
	    $OldColourId = $this->input->post('OldColourId');
	    $OldLocationId = $this->input->post('OldLocationId');
	    $OldProductId = $this->input->post('OldProductId');

	    		// checking record if already exists in stock summary table
	    	if($CheckStockSummary = $this->StockTransfer_model->CheckStockSummary($OldLocationId,$OldProductId,$OldColourId)){

				$SummaryId = $CheckStockSummary->SummaryId;
				$AvailableQuantity = $CheckStockSummary->Quantity;
				$NewQuantity = ($AvailableQuantity - $Quantity);

				$FinalQuantity = ($NewQuantity + $Quantity);

				$this->StockTransfer_model->UpdateStockSummary($SummaryId,$LocationId,$ProductId,$ColourId,$FinalQuantity);
				}

				// check record of other location
			if($CheckOtherLocationStatus = $this->StockTransfer_model->CheckOtherLocationStatus($LocationToId,$ProductId,$ColourId)){

				$OtherSummaryId = $CheckOtherLocationStatus->SummaryId;
				$OtherAvailableQuantity = $CheckOtherLocationStatus->Quantity;
				$OtherNewQuantity = ($OtherAvailableQuantity + $Quantity);

				$this->StockTransfer_model->UpdateStockSummary($OtherSummaryId,$LocationToId,$ProductId,$ColourId,$OtherNewQuantity);
				}
//				$this->StockTransfer_model->AddStockSummary($LocationToId,$ProductId,$ColourId,$Quantity);
			else{
				$this->StockTransfer_model->AddStockSummary($LocationToId,$ProductId,$ColourId,$Quantity);
				}

		$StockTransferId = $this->StockTransfer_model->UpdateStockTransferDetails($StockTransferId);
		redirect(base_url()."StockTransfer/ViewStockTransfer/".$StockTransferId);
	    }

	public function GetRemainingProduct()
	{
		$ColourId = $this->input->post('ColourId');
		$ProductId = $this->input->post('ProductId');
		$LocationId = $this->input->post('LocationId');
		$RemainingItems = 0;
    	$CheckStockSummary = $this->StockTransfer_model->CheckStockSummary($LocationId,$ProductId,$ColourId);
//    	print_r($CheckStockSummary);
    	if($CheckStockSummary){
    		echo $CheckStockSummary[0]['Quantity'];
    	die;
    	}
    	else{
//    	echo $RemainingItems;
    	echo "No stock available.";
    	}
	}
	
  
	public function AutoCompleteProductList()
	{
            	  
	  $ProductName = $this->input->post('ProductName');
	  $query = "";
//	  $CompanyId = $this->session->userdata('CompanyId');

/*	  if($CompanyId != 0){
	    $query = $this->db->query("SELECT P.ProductId,P.ProductName,B.BrandId,B.BrandName,PG.ProductGroupId,PG.ProductGroupName FROM pos_products AS P JOIN pos_brands AS B ON P.BrandId = B.BrandId JOIN pos_productgroup AS PG ON P.ProductGroupId = PG.ProductGroupId WHERE P.ProductName LIKE '%{$ProductName}%' AND P.CompanyId = '$CompanyId' LIMIT 10");
	  }
	  else
	  {*/
	    $query = $this->db->query("SELECT P.ProductId,P.ProductName,B.BrandId,B.BrandName,PG.ProductGroupId,PG.ProductGroupName FROM pos_products AS P JOIN pos_brands AS B ON P.BrandId = B.BrandId JOIN pos_productgroup AS PG ON P.ProductGroupId = PG.ProductGroupId WHERE P.ProductName LIKE '%{$ProductName}%' LIMIT 10");
//	  }
	  
          $ProductList = array();
          foreach ($query->result_array() as $key) 
	  	{ 
	  		if($key['ProductName'] != '' || $key['ProductName'] != null )
	    { 
	    	$ProductName = '-'.$key['ProductName']; 
	    	$BrandName = '-'.$key['BrandName']; 
		}
	    
	    $bn = array(
		'id' => trim($key['ProductId']),
		'value' => trim($key['ProductName'] . " " . $key['ProductGroupName'] . "- " . $key['BrandName']),
		'brandname' => trim($key['BrandName']),
		//'value' => trim($key['ProductName'].$key['RetailPrice'])
	    );
	    $ProductList[] = $bn;
	    }
	    echo json_encode($ProductList);
         }


	 public function AutoCompleteLocationList()
	 {
            	  
	   $LocationName = $this->input->post('LocationName');
	   $query = "";
//	   $CompanyId = $this->session->userdata('CompanyId');

/*	   if($CompanyId != 0){
	   $query = $this->db->query("SELECT LocationId,LocationName FROM pos_locations AS L WHERE L.LocationName LIKE '%{$LocationName}%' AND L.CompanyId = '$CompanyId' LIMIT 10");
	   }

	   else{*/

	   	$query = $this->db->query("SELECT LocationId,LocationName FROM pos_locations AS P WHERE P.LocationName LIKE '%{$LocationName}%' LIMIT 10");
//		}
            
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
	  
	   //$CompanyId = $this->session->userdata('CompanyId');

	   //if($CompanyId != 0){
	   $query = $this->db->query("SELECT ColourId,ColourName FROM pos_product_colours AS C WHERE C.ColourName LIKE '%{$ColourName}%' LIMIT 10");
	   //}

	 //  $query = $this->db->query("SELECT LocationId,LocationName FROM pos_locations AS P WHERE P.LocationName LIKE '%{$LocationName}%' LIMIT 10");
            
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