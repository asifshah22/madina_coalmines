<?php defined('BASEPATH') OR exit('No direct script access allowed');
class SalesReturn extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->check_isvalidated();
		$this->load->model('Customer_model');
		$this->load->model('Account_model');
		$this->load->model('Reference_model');
		$this->load->model('Product_model');
		$this->load->model('SalesReturn_model');
		$this->load->model('Sale_model');
		$this->load->model('Employee_model');
		$this->load->model('Saleman_model');
		$this->load->model('Setting_model');

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
	    $data['AllSales'] = $this->SalesReturn_model->GetAllSalesReturn();
	    $data['CustomerNotification'] = $this->Customer_model->GetNotifications();
	    $this->load->view('salesreturn/sales_return', $data);
	}

	public function Ajax_GetAllSalesReturn()
	{
	    $SalesRoles = $this->Employee_model->GetSalesRoles($this->session->userdata('EmployeeId'));
        $GetAllSalesReturn=$this->SalesReturn_model->Ajax_GetAllSalesReturn($_REQUEST);

        $ViewRecord = '<span style="color:#00a65a;" class="glyphicon glyphicon-th-large"></span>';
        $UpdateRecord = '<span style="color:#0c6aad;" class="fa fa-edit">';

            $data = array();
            $SaleReturnType = "";
            foreach($GetAllSalesReturn['record'] as $row)
            {
            	if($row["SaleReturnType"] == "1"){
            		$SaleReturnType = '<span class="label label-success">On Cash</span>';
            	}
            	if($row["SaleReturnType"] == "2"){
            		$SaleReturnType = '<span class="label label-danger">On Credit</span>';
            	}
            	if($row["SaleReturnType"] == "3"){
            		$SaleReturnType = '<span class="label" style="background-color:#39cccc; color:#fff">Online</span>';
            	}

                $nestedData=array(); 
                $nestedData[] = $row['SaleReturnId'];
                $nestedData[] = date("M d, Y", strtotime($row["SaleReturnDate"]));
				$nestedData[] = $SaleReturnType;
                $nestedData[] = $row["TotalAmount"];
                $id = $row["SaleReturnId"];
//                if ($SalesRoles[1]['ViewRoles'] == 1 && $SalesRoles[1]['UpdateRoles'] ==1 ) {
                	$nestedData[] = '<a href="'.base_url().'SalesReturn/ViewSalesReturn/'.$id.'" title="View Record">'.$ViewRecord.'</a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="'.base_url().'SalesReturn/EditSalesReturn/'.$id.'"title="Update Record"><span style="color:#0c6aad;" class="fa fa-edit"></span></a>';
  /*              }
                if ($SalesRoles[1]['ViewRoles'] == 1) {
					$nestedData[] = '<a href="'.base_url().'SalesReturn/ViewSalesReturn/'.$id.'" title="View Record">'.$ViewRecord.'</a>';
                }*/
			
                $data[] = $nestedData;
            }

                $json_data = array(
			"draw" => intval( $_REQUEST['draw'] ),   // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw. 
			"recordsTotal"    => intval( $GetAllSalesReturn['recordsTotal'] ),  // total number of records
			"recordsFiltered" => intval( $GetAllSalesReturn['recordsFiltered'] ), // total number of records after searching, if there is no searching then totalFiltered = totalData
			"data" => $data   // total data array
			);
                echo json_encode($json_data);  // send data as json format
        }

	
	function ViewSalesReturn($SaleReturnId)
	{
	    $data['AdministrationRoles'] = $this->Employee_model->GetAdministrationRoles($this->session->userdata('EmployeeId'));
	    $data['SalesRoles'] = $this->Employee_model->GetSalesRoles($this->session->userdata('EmployeeId'));
	    $data['PurchasesRoles'] = $this->Employee_model->GetPurchasesRoles($this->session->userdata('EmployeeId'));
	    $data['RegistrationRoles'] = $this->Employee_model->GetRegistrationRoles($this->session->userdata('EmployeeId'));
	    $data['TransactionRoles'] = $this->Employee_model->GetTransactionRoles($this->session->userdata('EmployeeId'));
	    $data['ReportsRoles'] = $this->Employee_model->GetReportsRoles($this->session->userdata('EmployeeId'));
	    $data['SalesReturn'] = $this->SalesReturn_model->GetSalesReturn($SaleReturnId); 
	    $data['SalesReturnDetail'] = $this->SalesReturn_model->GetSalesReturnDetail($SaleReturnId);
	    $data['CustomerNotification'] = $this->Customer_model->GetNotifications();
	    $this->load->view('salesreturn/view_salereturn', $data);
	}
	
// 	public function AddSalesReturn()
// 	{ 
// 	    $data['AdministrationRoles'] = $this->Employee_model->GetAdministrationRoles($this->session->userdata('EmployeeId'));
// 	    $data['SalesRoles'] = $this->Employee_model->GetSalesRoles($this->session->userdata('EmployeeId'));
// 	    $data['PurchasesRoles'] = $this->Employee_model->GetPurchasesRoles($this->session->userdata('EmployeeId'));
// 	    $data['RegistrationRoles'] = $this->Employee_model->GetRegistrationRoles($this->session->userdata('EmployeeId'));
// 	    $data['TransactionRoles'] = $this->Employee_model->GetTransactionRoles($this->session->userdata('EmployeeId'));
// 	    $data['ReportsRoles'] = $this->Employee_model->GetReportsRoles($this->session->userdata('EmployeeId'));
// 	    $data['AllCustomers']=$this->Customer_model->GetAllCustomers();
// 	    $data['AllReferences']=$this->Reference_model->GetAllReference();
// 	    $data['GetAllBankAccounts']=$this->Account_model->GetAllBankAccounts();
// 		$data['GetAllSaleman'] = $this->Saleman_model->GetAllCategories();
// 	    $data['CustomerNotification'] = $this->Customer_model->GetNotifications();
// 	    $this->load->view('salesreturn/add_salereturn', $data);
// 	}
	public function AddSalesReturn($SaleId)
	{   
	    $data['AdministrationRoles'] = $this->Employee_model->GetAdministrationRoles($this->session->userdata('EmployeeId'));
	    $data['SalesRoles'] = $this->Employee_model->GetSalesRoles($this->session->userdata('EmployeeId'));
	    $data['PurchasesRoles'] = $this->Employee_model->GetPurchasesRoles($this->session->userdata('EmployeeId'));
	    $data['RegistrationRoles'] = $this->Employee_model->GetRegistrationRoles($this->session->userdata('EmployeeId'));
	    $data['TransactionRoles'] = $this->Employee_model->GetTransactionRoles($this->session->userdata('EmployeeId'));
	    $data['ReportsRoles'] = $this->Employee_model->GetReportsRoles($this->session->userdata('EmployeeId'));
	    $data['AllReferences']=$this->Reference_model->GetAllReference();
	    $data['AllCustomers']=$this->Customer_model->GetAllCustomers();
	    $data['Sales'] = $this->Sale_model->GetSales($SaleId);
	    $data['SalesDetail'] = $this->Sale_model->GetSalesDetail($SaleId);
	    $data['CashDetail'] = $this->Sale_model->GetCashDetails($SaleId);
	    $data['GetAllBankAccounts'] = $this->Sale_model->GetAllBankAccounts();
		$data['GetAllSaleman'] = $this->Saleman_model->GetAllCategories();
	    $data['CustomerNotification'] = $this->Customer_model->GetNotifications();
	    $this->load->view('salesreturn/add_salereturn', $data);
	}
	
	function EditSalesReturn($SaleReturnId)
	{
	    $data['AdministrationRoles'] = $this->Employee_model->GetAdministrationRoles($this->session->userdata('EmployeeId'));
	    $data['SalesRoles'] = $this->Employee_model->GetSalesRoles($this->session->userdata('EmployeeId'));
	    $data['PurchasesRoles'] = $this->Employee_model->GetPurchasesRoles($this->session->userdata('EmployeeId'));
	    $data['RegistrationRoles'] = $this->Employee_model->GetRegistrationRoles($this->session->userdata('EmployeeId'));
	    $data['TransactionRoles'] = $this->Employee_model->GetTransactionRoles($this->session->userdata('EmployeeId'));
	    $data['ReportsRoles'] = $this->Employee_model->GetReportsRoles($this->session->userdata('EmployeeId'));
	    $data['AllCustomers']=$this->Customer_model->GetAllCustomers();
	    $data['AllReferences']=$this->Reference_model->GetAllReference(); 
	    $data['GetAllBankAccounts']=$this->Account_model->GetAllBankAccounts(); 
	    $data['SalesReturn'] = $this->SalesReturn_model->GetSalesReturn($SaleReturnId); 
	    $data['SalesReturnDetail'] = $this->SalesReturn_model->GetSalesReturnDetail($SaleReturnId);
	    $data['CustomerNotification'] = $this->Customer_model->GetNotifications();

//	    echo $this->output->enable_profiler();
	    $this->load->view('salesreturn/edit_salereturn', $data);
	}
	
	public function SaveSalesReturn()
	{
	    date_default_timezone_set('Asia/Karachi');
	    $AddSaleReturnRecordBtn = $this->input->post('AddSaleReturnRecordBtn');
	    
	   	if($AddSaleReturnRecordBtn=='AddSaleReturnRecord')
	   	{
	      $SaleReturnId = $this->SalesReturn_model->SaveSalesReturnDetail();
	     
	      $this->FBR($SaleReturnId);
	      for ($i=0; $i < count($this->input->post('LocationId')); $i++) {
	    	$LocationId = $this->input->post('LocationId')[$i];
		    $ProductId = $this->input->post('ProductId')[$i];
		    $ColourId = $this->input->post('ColourId')[$i];
		    $Quantity = $this->input->post('Quantity')[$i];
				if($CheckStockSummary = $this->SalesReturn_model->CheckStockSummary($LocationId,$ProductId,$ColourId)){
				$SummaryId = $CheckStockSummary->SummaryId;
				$AvailableQuantity = $CheckStockSummary->Quantity;
				$NewQuantity = ($AvailableQuantity + $Quantity);
				$this->SalesReturn_model->UpdateStockSummary($SummaryId,$LocationId,$ProductId,$ColourId,$NewQuantity);
				}
				else{
				$this->SalesReturn_model->AddStockSummary($LocationId,$ProductId,$ColourId,$Quantity);
				}
			}
	       redirect(base_url()."SalesReturn/ViewSalesReturn/$SaleReturnId");
	   	}
	    
	}

	
	public function SaveSalesReturn__()
	{
	    $AddSaleReturnRecordBtn = $this->input->post('AddSaleReturnRecordBtn');
	    
	   if($AddSaleReturnRecordBtn=='AddSaleReturnRecord')
	   {
	      if($SaleReturnId = $this->SalesReturn_model->SaveSalesReturnDetail())
	      {
	       redirect(base_url()."SalesReturn/ViewSalesReturn/$SaleReturnId");
	      }
	   }
	    
	}

    public function UpdateSalesReturn()
    {    	
	   $SaleReturnId = $this->input->post('SaleReturnId');
	
       $SaleReturnId = $this->SalesReturn_model->UpdateSalesReturn();
//			$SaleReturnId = $this->SalesReturn_model->UpdatePurchaseDetail($SaleReturnId);
	    	for ($i=0; $i < count($this->input->post('LocationId')); $i++) {
	    		$OldQuantity = $this->input->post('OldQuantity')[$i];
			    $OldColourId = $this->input->post('OldColourId')[$i];
			    $OldLocationId = $this->input->post('OldLocationId')[$i];
			    $OldProductId = $this->input->post('OldProductId')[$i];

		    $LocationId = $this->input->post('LocationId')[$i];
		    $ProductId = $this->input->post('ProductId')[$i];
		    $ColourId = $this->input->post('ColourId')[$i];
		    $Quantity = $this->input->post('Quantity')[$i];
				if($CheckStockSummary = $this->SalesReturn_model->CheckStockSummary($OldLocationId,$OldProductId,$OldColourId)){

				$SummaryId = $CheckStockSummary->SummaryId; // getting id of available stock summary
				$AvailableQuantity = $CheckStockSummary->Quantity; // quantity of that summary id
				$NewQuantity = ($AvailableQuantity - $OldQuantity); 
				// deducting quantity from db to hidden value

				$FinalQuantity = ($NewQuantity + $Quantity);
				// adding result quantity with input field quantity

				$this->SalesReturn_model->UpdateStockSummary($SummaryId,$LocationId,$ProductId,$ColourId,$FinalQuantity);
				}
				else{
				$this->SalesReturn_model->AddStockSummary($LocationId,$ProductId,$ColourId,$Quantity);
				}

		redirect("SalesReturn/ViewSalesReturn/$SaleReturnId");
    	}
	}

    public function UpdateSalesReturn__()
    {    	
	   $SaleReturnId = $this->input->post('SaleReturnId');
	
             $this->SalesReturn_model->UpdateSalesReturn();
             if($SaleReturnId != '')
	     {
		$Message = 'Record updated successfully';
		$this->session->set_flashdata("success_message",$Message);
		redirect("SalesReturn/ViewSalesReturn/$SaleReturnId");
            }

    }

  
	public function AutoCompleteProductList()
	{
            	  
	  $ProductName = $this->input->post('ProductName');
	  $query = "";

	  $query = $this->db->query("SELECT ProductId,ProductName FROM pos_products AS P WHERE P.ProductName LIKE '%{$ProductName}%' LIMIT 10");
            
          $ProductList = array();
          foreach ($query->result_array() as $key) 
	  {
			    
	    if($key['ProductName'] != '' || $key['ProductName'] != null )
	    { $ProductName = '-'.$key['ProductName']; }
	    
	    $bn = array(
		'id' => trim($key['ProductId']),
		'value' => trim($key['ProductName'])
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

	   $query = $this->db->query("SELECT LocationId,LocationName FROM pos_locations AS L WHERE L.LocationName LIKE '%{$LocationName}%' LIMIT 10");

	 //  $query = $this->db->query("SELECT LocationId,LocationName FROM pos_locations AS P WHERE P.LocationName LIKE '%{$LocationName}%' LIMIT 10");
            
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
          
       public function  FBR($SaleId)
        {
         date_default_timezone_set('Asia/Karachi');
		$data['Sales'] = $this->SalesReturn_model->GetSalesReturn($SaleId);
		$data['SalesDetail'] = $this->SalesReturn_model->GetSalesReturnDetail($SaleId);
		$data['GetSetting']=$this->Setting_model->GetSetting($SettingId=1);
		$data['Saless'] = $this->Sale_model->GetFbrSales($data['Sales']->SaleIdd);
// 		echo '<pre>'; print_r($data['Saless']); echo '</pre>'; exit;

		$items = [];

		$totalSaleValue = 0;
		$TotalQuantity = 0;
		$TotalAmount = 0;
		$TotalTaxCharged = 0;
		$TotalDiscount = 0;
		$InvoiceType = 0;
		foreach ($data['SalesDetail'] as $key => $value) {

// 			$items[] = [
// 				"ItemCode" =>  $value['ProductId'],
// 				"ItemName" => $value['ProductName'],
// 				"Quantity" =>  number_format($value['Quantity'], 0),
// 				"PCTCode" => number_format($value['OpeningStock'], 0),
// 				"TaxRate" => number_format($value['DiscountAmount'], 0),
// 				"SaleValue" => number_format($value['Amount']-$value['TaxAmount'], 0),
// 				"TotalAmount" =>  number_format($value['NetAmount'], 0),
// 				"TaxCharged" =>  number_format($value['TaxPercentage'], 0),
// 				"Discount" =>  0,
// 				"FurtherTax" => 0,
// 				"InvoiceType" => 3,
// 				"RefUSIN" => null
// 			];
			
			$items[] = [
                  "hsCode" => $value['OpeningStock'],
                  "productDescription" => $value['ProductName'],
                  "rate" => floatval($value['DiscountAmount'])."%",
                  "uoM" => $value['ProductGroupName'],
                  "quantity" => round($value['Quantity'], 2),
                  "totalValues" => round($value['NetAmount'], 2),
                  "valueSalesExcludingST" => round($value['Amount'], 2),
                  "salesTaxApplicable" => round($value['TaxPercentage'], 2),
                  "fixedNotifiedValueOrRetailPrice" => 0,
                  "salesTaxWithheldAtSource" => 0,
                  "extraTax" => 0,
                  "furtherTax" => 0,
                  "sroScheduleNo" => "",
                  "fedPayable" => 0,
                  "discount" => 0,
                  "saleType" => "Goods at standard rate (default)",
                  "sroItemSerialNo" => ""
            ];
			
		}

// 		$postData = array(
// 			"InvoiceNumber" => "",
// 			"POSID" => ,
// 			"USIN" => "USIN" . $data['Sales']->SaleReturnId,
// 			"DateTime" => $data['Sales']->SaleReturnDate,
// 			"BuyerNTN" => $data['Sales']->fbr_ntn,
// 			"BuyerCNIC" => $data['Sales']->fbr_cnic,
// 			"BuyerName" => $data['Sales']->fbr_customer,
// 			"BuyerPhoneNumber" => $data['Sales']->fbr_mobile,
// 			"TotalBillAmount" => number_format(($TotalAmount ), 0),
// 			"TotalQuantity" => number_format($TotalQuantity, 0),
// 			"TotalSaleValue" => number_format($totalSaleValue, 0),
// 			"TotalTaxCharged" => number_format($TotalTaxCharged, 0),
// 			"Discount" => number_format($TotalDiscount, 0),
// 			"FurtherTax" => 0,
// 			"PaymentMode" => $InvoiceType,
// 			"RefUSIN" => null,
// 			"InvoiceType" => $InvoiceType,
// 			"Items" => $items
// 		);
		
		$postData = array(
          "invoiceType" => "Debit Note",
          "invoiceDate" => date('Y-m-d', strtotime($data['Sales']->SaleReturnDate)),
          "destinationOfSupply" => "Sindh",
          "sellerBusinessName" => $data['GetSetting']->CompanyName,
          "sellerProvince" => "Sindh",
          "sellerAddress" => $data['GetSetting']->ProductsDeals,
          "sellerNTNCNIC" => $data['GetSetting']->Email,
          "buyerNTNCNIC" => $data['Sales']->PhoneNo,
          "buyerBusinessName" => $data['Sales']->CustomerName,
          "buyerProvince" => $data['Sales']->FaxNo,
          "buyerAddress" => $data['Saless']->buyerAddress,
          "invoiceRefNo" => $data['Saless']->FbrNo,
          "buyerRegistrationType" => $data['Sales']->AreaId,
          "scenarioId" => "SN001",
          "items" => $items
        );
// 	echo '<pre>'; print_r($postData); echo '</pre>'; exit;

		// Encode the data to JSON format
		$jsonData = json_encode($postData);


		$curl = curl_init();

		curl_setopt_array($curl, array(
			CURLOPT_URL => 'https://gw.fbr.gov.pk/di_data/v1/di/postinvoicedata_sb',//'https://gw.fbr.gov.pk/di_data/v1/di/postinvoicedata_sb',//'https://gw.fbr.gov.pk/imsp/v1/api/Live/PostData',
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => '',
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 0,
			CURLOPT_FOLLOWLOCATION => true,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_SSL_VERIFYPEER => false,
			CURLOPT_SSL_VERIFYHOST => false,
			CURLOPT_CUSTOMREQUEST => 'POST',
			CURLOPT_POSTFIELDS => $jsonData,
		CURLOPT_HTTPHEADER => array(
				'Authorization: Bearer ',
				'Content-Type: application/json'
			),
		));

		$response = curl_exec($curl);

		if (curl_errno($curl)) {
			echo 'Error:' . curl_error($curl);
		}

		curl_close($curl);

		$response = json_decode($response, true);
		// Check nested invoiceNo
        $invoiceNo = $response['validationResponse']['invoiceNo'] ?? '';
 
		$FbrNo = array(
			'FbrNo' =>  $invoiceNo,
		);
		$this->db->set($FbrNo);
		$this->db->where('SaleReturnId', $SaleId);
		$this->db->update('pos_sales_return');
		
	}
}
?>