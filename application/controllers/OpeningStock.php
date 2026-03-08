<?php defined('BASEPATH') OR exit('No direct script access allowed');

class OpeningStock extends CI_Controller {

	public function __construct()
	{
	    parent::__construct();
	    $this->check_isvalidated();
	    $this->load->model('OpeningStock_model');
	    $this->load->model('Location_model');
	    $this->load->model('Product_model');
	    $this->load->model('Sale_model');
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
	    $this->load->view('openingstock/openingstocks', $data);
	}

	public function Ajax_GetAllOpeningStock()
	{
		$SalesRoles = $this->Employee_model->GetSalesRoles($this->session->userdata('EmployeeId'));
        $GetAllOpeningStocks=$this->OpeningStock_model->Ajax_GetAllOpeningStock($_REQUEST);

        $ViewRecord = '<span style="color:#00a65a;" class="glyphicon glyphicon-th-large"></span>';
        $UpdateRecord = '<span style="color:#0c6aad;" class="fa fa-edit">';

            $data = array();
            foreach($GetAllOpeningStocks['record'] as $row)
            {
                $nestedData=array(); 
                $nestedData[] = $row['StockId'];
                $nestedData[] = $row["ProductName"] . " - " . $row["ProductGroupName"] . " - " . $row["BrandName"];
                $nestedData[] = $row["LocationName"];
                $nestedData[] = $row["Quantity"];
                $id = $row["StockId"];
//                if ($OpeningStocksRoles[0]['ViewRoles'] == 1 && $OpeningStocksRoles[0]['UpdateRoles'] ==1 ) {

                $nestedData[] = '<a href="'.base_url().'OpeningStock/ViewOpeningStock/'.$id.'" title="View Record">'.$ViewRecord.'</a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="'.base_url().'OpeningStock/EditOpeningStock/'.$id.'"title="Update Record"><span style="color:#0c6aad;" class="fa fa-edit"></span></a>';

/*                if ($OpeningStocksRoles[0]['ViewRoles'] == 1 ){
                $nestedData[] = anchor("OpeningStocks/ViewOpeningStock/$id",'<i class="ace-icon fa fa-check bigger-130"></i>',array("class"=>"btn btn-xs btn-success","title"=>"View"));	
                }*/
			
                $data[] = $nestedData;
            }

                $json_data = array(
			"draw" => intval( $_REQUEST['draw'] ),   // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw. 
			"recordsTotal"    => intval( $GetAllOpeningStocks['recordsTotal'] ),  // total number of records
			"recordsFiltered" => intval( $GetAllOpeningStocks['recordsFiltered'] ), // total number of records after searching, if there is no searching then totalFiltered = totalData
			"data" => $data   // total data array
			);
                echo json_encode($json_data);  // send data as json format
        }

	public function ViewOpeningStock($StockId)
	{
	    $data['AdministrationRoles'] = $this->Employee_model->GetAdministrationRoles($this->session->userdata('EmployeeId'));
	    $data['SalesRoles'] = $this->Employee_model->GetSalesRoles($this->session->userdata('EmployeeId'));
	    $data['PurchasesRoles'] = $this->Employee_model->GetPurchasesRoles($this->session->userdata('EmployeeId'));
	    $data['RegistrationRoles'] = $this->Employee_model->GetRegistrationRoles($this->session->userdata('EmployeeId'));
	    $data['TransactionRoles'] = $this->Employee_model->GetTransactionRoles($this->session->userdata('EmployeeId'));
	    $data['ReportsRoles'] = $this->Employee_model->GetReportsRoles($this->session->userdata('EmployeeId'));

	    $data['AllLocations']=$this->Location_model->GetAllLocation();
	    $data['AllColours']=$this->Colour_model->GetAllColours();
//	    $data['OpeningStockTo'] = $this->OpeningStock_model->OpeningStockTo($StockId);
//	    $data['OpeningStockFrom'] = $this->OpeningStock_model->OpeningStockFrom($StockId);
//	    $data['OpeningStock'] = $this->OpeningStock_model->GetOpeningStock($StockId);
	    $data['OpeningStockDetail'] = $this->OpeningStock_model->GetOpeningStockDetail($StockId);
	    $data['CustomerNotification'] = $this->Customer_model->GetNotifications();
	    $this->load->view('openingstock/view_openingstock', $data);
	}

	public function AddOpeningStock()
	{ 
	    $data['AdministrationRoles'] = $this->Employee_model->GetAdministrationRoles($this->session->userdata('EmployeeId'));
	    $data['SalesRoles'] = $this->Employee_model->GetSalesRoles($this->session->userdata('EmployeeId'));
	    $data['PurchasesRoles'] = $this->Employee_model->GetPurchasesRoles($this->session->userdata('EmployeeId'));
	    $data['RegistrationRoles'] = $this->Employee_model->GetRegistrationRoles($this->session->userdata('EmployeeId'));
	    $data['TransactionRoles'] = $this->Employee_model->GetTransactionRoles($this->session->userdata('EmployeeId'));
	    $data['ReportsRoles'] = $this->Employee_model->GetReportsRoles($this->session->userdata('EmployeeId'));
		$data['AllColours']=$this->Colour_model->GetAllColours();
	    $data['FromLocations']=$this->Location_model->FromLocations();
	    $data['AllLocations']=$this->Location_model->GetAllLocation();
	    $data['CustomerNotification'] = $this->Customer_model->GetNotifications();
	    $this->load->view('openingstock/add_openingstock', $data);
	}
	
	public function EditOpeningStock($OpeningStockId)
	{   
	    $data['AdministrationRoles'] = $this->Employee_model->GetAdministrationRoles($this->session->userdata('EmployeeId'));
	    $data['SalesRoles'] = $this->Employee_model->GetSalesRoles($this->session->userdata('EmployeeId'));
	    $data['PurchasesRoles'] = $this->Employee_model->GetPurchasesRoles($this->session->userdata('EmployeeId'));
	    $data['RegistrationRoles'] = $this->Employee_model->GetRegistrationRoles($this->session->userdata('EmployeeId'));
	    $data['TransactionRoles'] = $this->Employee_model->GetTransactionRoles($this->session->userdata('EmployeeId'));
	    $data['ReportsRoles'] = $this->Employee_model->GetReportsRoles($this->session->userdata('EmployeeId'));

	    $data['AllLocations']=$this->Location_model->GetAllLocation();
	    $data['AllColours']=$this->Colour_model->GetAllColours();
/*	    $data['OpeningStockTo'] = $this->OpeningStock_model->OpeningStockTo($OpeningStockId);
	    $data['OpeningStockFrom'] = $this->OpeningStock_model->OpeningStockFrom($OpeningStockId);
	    $data['OpeningStock'] = $this->OpeningStock_model->GetOpeningStock($OpeningStockId);*/
	    $data['OpeningStockDetail'] = $this->OpeningStock_model->GetOpeningStockDetail($OpeningStockId);
	    $data['CustomerNotification'] = $this->Customer_model->GetNotifications();
	    $this->load->view('openingstock/edit_openingstock', $data);
	}
	
	public function SaveOpeningStock()
	{
		$data = $this->input->post();

		$LocationId = $this->input->post('LocationId');
	    $ProductId = $this->input->post('ProductId');
	    $ColourId = $this->input->post('ColourId');
	    $Quantity = $this->input->post('Quantity');
	    
	    	$StockId = $this->OpeningStock_model->SaveOpeningStockDetail($data);
	    	
	    		// checking record if already exists in stock summary table
	    	if($CheckStockSummary = $this->OpeningStock_model->CheckStockSummary($LocationId,$ProductId,$ColourId)){

				$SummaryId = $CheckStockSummary->SummaryId;
				$AvailableQuantity = $CheckStockSummary->Quantity;
				$NewQuantity = ($AvailableQuantity + $Quantity);

				$this->OpeningStock_model->UpdateStockSummary($SummaryId,$LocationId,$ProductId,$ColourId,$NewQuantity);
				}

				// check record of other location
/*			if($CheckOtherLocationStatus = $this->OpeningStock_model->CheckOtherLocationStatus($LocationToId,$ProductId,$ColourId)){

				$OtherSummaryId = $CheckOtherLocationStatus->SummaryId;
				$OtherAvailableQuantity = $CheckOtherLocationStatus->Quantity;
				$OtherNewQuantity = ($OtherAvailableQuantity + $Quantity);

				$this->OpeningStock_model->UpdateStockSummary($OtherSummaryId,$LocationToId,$ProductId,$ColourId,$OtherNewQuantity);
				}*/
//				$this->OpeningStock_model->AddStockSummary($LocationToId,$ProductId,$ColourId,$Quantity);
			else{
				$this->OpeningStock_model->AddStockSummary($LocationId,$ProductId,$ColourId,$Quantity);
				}
	      redirect(base_url()."OpeningStock/ViewOpeningStock/$StockId");
	}
	
 
	public function UpdateOpeningStock($StockId)
	{
		$LocationId = $this->input->post('LocationId');
	    $ProductId = $this->input->post('ProductId');
	    $ColourId = $this->input->post('ColourId');
	    $Quantity = $this->input->post('Quantity');

	    $OldQuantity = $this->input->post('OldQuantity');
	    $OldColourId = $this->input->post('OldColourId');
	    $OldLocationId = $this->input->post('OldLocationId');
	    $OldProductId = $this->input->post('OldProductId');

		$StockId = $this->OpeningStock_model->UpdateOpeningStockDetails($StockId);

		// checking record if already exists in stock summary table
	    	if($CheckStockSummary = $this->OpeningStock_model->CheckStockSummary($OldLocationId,$OldProductId,$OldColourId)){
				$SummaryId = $CheckStockSummary->SummaryId;
				$AvailableQuantity = $CheckStockSummary->Quantity;
				$NewQuantity = ($AvailableQuantity - $OldQuantity);

				$FinalQuantity = ($NewQuantity + $Quantity);

				$this->OpeningStock_model->UpdateStockSummary($SummaryId,$LocationId,$ProductId,$ColourId,$FinalQuantity);
				}

/*			else{
				$this->OpeningStock_model->AddStockSummary($LocationId,$ProductId,$ColourId,$Quantity);
				}*/

		redirect(base_url()."OpeningStock/ViewOpeningStock/".$StockId);
	}

	public function GetRemainingProduct()
	{
		$ColourId = $this->input->post('ColourId');
		$ProductId = $this->input->post('ProductId');
		$LocationId = $this->input->post('LocationId');
    	$CheckStockSummary = $this->OpeningStock_model->CheckStockSummary($LocationId,$ProductId,$ColourId);
//    	print_r($CheckStockSummary);
    	if($RemainingItems = $CheckStockSummary->Quantity){
    	echo $RemainingItems;	}
    	else{ echo "No stock available. Please make some purchases";}
	}
	
  
	public function AutoCompleteProductList()
	{
            	  
	  $ProductName = $this->input->post('ProductName');
	  $query = "";

	    $query = $this->db->query("SELECT P.ProductId,P.ProductName,B.BrandId,B.BrandName,PG.ProductGroupId,PG.ProductGroupName FROM pos_products AS P JOIN pos_brands AS B ON P.BrandId = B.BrandId JOIN pos_productgroup AS PG ON P.ProductGroupId = PG.ProductGroupId WHERE P.ProductName LIKE '%{$ProductName}%' LIMIT 10");
	  
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