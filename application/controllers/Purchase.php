<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Purchase extends CI_Controller {

	public function __construct()
	{
	    parent::__construct();
	    $this->check_isvalidated();
	    $this->load->model('Employee_model');
	    $this->load->model('Account_model');
	    $this->load->model('Purchase_model');
	    $this->load->model('Sale_model');
	    $this->load->model('Location_model');
	    $this->load->model('Vendor_model');
	    $this->load->model('Customer_model');
		date_default_timezone_set('Asia/Karachi');
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
	    $data['CustomerNotification'] = $this->Customer_model->GetNotifications();
//	    $data['AllPurchases'] = $this->Purchase_model->GetAllPurchase();
	    $this->load->view('purchase/purchases', $data);
	}

	public function Ajax_GetAllPurchase()
	{
	    $PurchasesRoles = $this->Employee_model->GetPurchasesRoles($this->session->userdata('EmployeeId'));
        $GetAllPurchase=$this->Purchase_model->Ajax_GetAllPurchase($_REQUEST);

        $ViewRecord = '<span style="color:#00a65a;" class="glyphicon glyphicon-th-large"></span>';
        $UpdateRecord = '<span style="color:#0c6aad;" class="fa fa-edit">';

		$data = array();
            foreach($GetAllPurchase['record'] as $row)
            {
            	$PurchaseType = "";
            	if($row["PurchaseType"] == '1'){
            		$PurchaseType = '<span class="label label-success">On Cash</span>';
            	}
				if($row["PurchaseType"] == '2'){
            		$PurchaseType = '<span class="label label-danger">On Credit</span>';
            	}
            	if($row["PurchaseType"] == '3'){
            		$PurchaseType = '<span class="label" style="background:#39cccc; color:#ffffff">Online</span>';
            	}

                $nestedData=array(); 
                $nestedData[] = $row['PurchaseId'];
                $nestedData[] = $row["PurchaseDate"];
                $nestedData[] = $PurchaseType;
				$nestedData[] = $row["VendorName"];
                $nestedData[] = $row["TotalAmount"];
                $id = $row["PurchaseId"];
//                if ($PurchasesRoles[0]['ViewRoles'] == 1 && $PurchasesRoles[0]['UpdateRoles'] ==1 ) {
$nestedData[] = '
<div class="qbo-dropdown">
    <button class="qbo-dropbtn">
        <span class="colorful-dots">
            <span style="color: #4CAF50;">•</span>
            <span style="color: #2196F3;">•</span>
            <span style="color: #F44336;">•</span>
        </span>
    </button>
    <div class="qbo-dropdown-content">
        <a href="'.base_url().'Purchase/ViewPurchase/'.$id.'" class="qbo-dropdown-item">
            <i class="fas fa-eye"></i> View Record
        </a>
        <a href="'.base_url().'Purchase/EditPurchase/'.$id.'" class="qbo-dropdown-item">
            <i class="fas fa-edit"></i> Edit Record
        </a>
        <a href="javascript:void(0)" class="qbo-dropdown-item" onclick="if(confirm(\'Are you sure you want to delete this record?\')){window.location.href=\''.base_url().'Purchase/DeletePurchase/'.$id.'\'}">
            <i class="fas fa-trash-alt"></i> Delete Record
        </a>
    </div>
</div>

<style>
.qbo-dropdown {
    position: relative;
    display: inline-block;
}
.qbo-dropbtn {
    background: #f8f9fa;
    color: #2c3e50;
    border: 1px solid #ddd;
    border-radius: 4px;
    padding: 6px 12px;
    cursor: pointer;
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 13px;
    transition: all 0.2s;
    width: auto;
    height: auto;
}
.qbo-dropbtn:hover {
    background: #e9ecef;
    border-color: #adb5bd;
}
.colorful-dots {
    display: inline-flex;
    gap: 4px;
    font-size: 16px;
    line-height: 1;
}
.qbo-dropdown-content {
    display: none;
    position: absolute;
    right: 0;
    background: white;
    min-width: 180px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.15);
    border-radius: 4px;
    z-index: 100;
    border: 1px solid #e0e0e0;
}
.qbo-dropdown:hover .qbo-dropdown-content {
    display: block;
}
.qbo-dropdown-item {
    color: #495057;
    padding: 8px 12px;
    text-decoration: none;
    display: flex;
    align-items: center;
    gap: 10px;
    font-size: 13px;
    border-bottom: 1px solid #f1f1f1;
}
.qbo-dropdown-item:last-child {
    border-bottom: none;
}
.qbo-dropdown-item:hover {
    background: #f8f9fa;
    color: #2c3e50;
}
.qbo-dropdown-item i {
    width: 16px;
    text-align: center;
}
.qbo-dropdown-item:nth-child(1) i { color: #3498db; }
.qbo-dropdown-item:nth-child(2) i { color: #2ecc71; }
.qbo-dropdown-item:nth-child(3) i { color: #e74c3c; }
</style>';
/*                }
                if ($PurchasesRoles[0]['ViewRoles'] == 1) {
					$nestedData[] = '<a href="'.base_url().'Purchase/ViewPurchase/'.$id.'" title="View Record">'.$ViewRecord.'</a>';
                }*/
			
                $data[] = $nestedData;
            }

                $json_data = array(
			"draw" => intval( $_REQUEST['draw'] ),   // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw. 
			"recordsTotal"    => intval( $GetAllPurchase['recordsTotal'] ),  // total number of records
			"recordsFiltered" => intval( $GetAllPurchase['recordsFiltered'] ), // total number of records after searching, if there is no searching then totalFiltered = totalData
			"data" => $data   // total data array
			);
                echo json_encode($json_data);  // send data as json format
        }            

	function ViewPurchase($PurchaseId)
	{ 
	    $data['AdministrationRoles'] = $this->Employee_model->GetAdministrationRoles($this->session->userdata('EmployeeId'));
	    $data['SalesRoles'] = $this->Employee_model->GetSalesRoles($this->session->userdata('EmployeeId'));
	    $data['PurchasesRoles'] = $this->Employee_model->GetPurchasesRoles($this->session->userdata('EmployeeId'));
	    $data['RegistrationRoles'] = $this->Employee_model->GetRegistrationRoles($this->session->userdata('EmployeeId'));
	    $data['TransactionRoles'] = $this->Employee_model->GetTransactionRoles($this->session->userdata('EmployeeId'));
	    $data['ReportsRoles'] = $this->Employee_model->GetReportsRoles($this->session->userdata('EmployeeId'));
	    $data['Purchases'] = $this->Purchase_model->GetPurchase($PurchaseId);
	    $data['PurchaseDetail'] = $this->Purchase_model->GetPurchaseDetail($PurchaseId);
	    $data['CustomerNotification'] = $this->Customer_model->GetNotifications();
	    $this->load->view('purchase/view_purchase', $data);
	}
	
	
	public function AddPurchase()
	{
	    
	    $data['AdministrationRoles'] = $this->Employee_model->GetAdministrationRoles($this->session->userdata('EmployeeId'));
	    $data['SalesRoles'] = $this->Employee_model->GetSalesRoles($this->session->userdata('EmployeeId'));
	    $data['PurchasesRoles'] = $this->Employee_model->GetPurchasesRoles($this->session->userdata('EmployeeId'));
	    $data['RegistrationRoles'] = $this->Employee_model->GetRegistrationRoles($this->session->userdata('EmployeeId'));
	    $data['TransactionRoles'] = $this->Employee_model->GetTransactionRoles($this->session->userdata('EmployeeId'));
	    $data['ReportsRoles'] = $this->Employee_model->GetReportsRoles($this->session->userdata('EmployeeId'));
	    $data['GetAllBankAccounts']=$this->Account_model->GetAllBankAccounts();
	    $data['AllLocations']=$this->Location_model->GetAllLocation();
	    $data['AllVendors']=$this->Vendor_model->GetAllVendors();
	    $data['CustomerNotification'] = $this->Customer_model->GetNotifications();
	    $this->load->view('purchase/add_purchase', $data);
	}

	
	function EditPurchase($PurchaseId)
	{
	    $data['AdministrationRoles'] = $this->Employee_model->GetAdministrationRoles($this->session->userdata('EmployeeId'));
	    $data['SalesRoles'] = $this->Employee_model->GetSalesRoles($this->session->userdata('EmployeeId'));
	    $data['PurchasesRoles'] = $this->Employee_model->GetPurchasesRoles($this->session->userdata('EmployeeId'));
	    $data['RegistrationRoles'] = $this->Employee_model->GetRegistrationRoles($this->session->userdata('EmployeeId'));
	    $data['TransactionRoles'] = $this->Employee_model->GetTransactionRoles($this->session->userdata('EmployeeId'));
	    $data['ReportsRoles'] = $this->Employee_model->GetReportsRoles($this->session->userdata('EmployeeId'));
		$data['GetAllBankAccounts']=$this->Account_model->GetAllBankAccounts();
	    $data['AllVendors']=$this->Vendor_model->GetAllVendors();
	    $data['Purchases'] = $this->Purchase_model->GetPurchase($PurchaseId);
	    $data['PurchaseDetail'] = $this->Purchase_model->GetPurchaseDetail($PurchaseId);
	    $data['CustomerNotification'] = $this->Customer_model->GetNotifications();
	    $this->load->view('purchase/edit_purchase', $data);
	}

	public function SavePurchase()
	{
	    $AddRecordBtn = $this->input->post('AddPurchaseRecordBtn');
	    $SummaryId = "";
	    if($AddRecordBtn=='AddPurchaseRecord')
	    {
			$PurchaseId = $this->Purchase_model->SavePurchaseDetail();
	    	for ($i=0; $i < count($this->input->post('LocationId')); $i++) {
		    $LocationId = $this->input->post('LocationId')[$i];
		    $ProductId = $this->input->post('ProductId')[$i];
		    $ColourId = $this->input->post('ColourId')[$i];
		    $Quantity = $this->input->post('Quantity')[$i];
				if($CheckStockSummary = $this->Purchase_model->CheckStockSummary($LocationId,$ProductId,$ColourId)){
				$SummaryId = $CheckStockSummary->SummaryId;
				$AvailableQuantity = $CheckStockSummary->Quantity;
				$NewQuantity = ($AvailableQuantity + $Quantity);
				$this->Purchase_model->UpdateStockSummary($SummaryId,$LocationId,$ProductId,$ColourId,$NewQuantity);
				}
				else{
				$this->Purchase_model->AddStockSummary($LocationId,$ProductId,$ColourId,$Quantity);
				}
	    	}
		    redirect("Purchase/ViewPurchase/$PurchaseId");
	    }
	}

	public function SavePurchase__()
	{
	    $AddRecordBtn = $this->input->post('AddPurchaseRecordBtn');
	    
	    if($AddRecordBtn=='AddPurchaseRecord')
	    {
		$PurchaseId = $this->Purchase_model->SavePurchaseDetail();
		if($PurchaseId != '')
		{
		    redirect("Purchase/ViewPurchase/$PurchaseId");
		}
		else
		{
		    redirect("Purchase/");
		}    
	    }
	}

	
	public function UpdatePurchase()
	{
/*
	    echo $UpdateRecordBtn = $this->input->post('UpdateRecordBtn');
	    die;	   
	    if($UpdateRecordBtn=='UpdatePurchaseRecord')
	    {*/
	    	$PurchaseId = $this->input->post('PurchaseId');
			$PurchaseId = $this->Purchase_model->UpdatePurchaseDetail($PurchaseId);
	    	for ($i=0; $i < count($this->input->post('LocationId')); $i++) {
@	    		$OldQuantity = $this->input->post('OldQuantity')[$i];
@			    $OldColourId = $this->input->post('OldColourId')[$i];
@			    $OldLocationId = $this->input->post('OldLocationId')[$i];
@			    $OldProductId = $this->input->post('OldProductId')[$i];

		    $LocationId = $this->input->post('LocationId')[$i];
		    $ProductId = $this->input->post('ProductId')[$i];
		    $ColourId = $this->input->post('ColourId')[$i];
		    $Quantity = $this->input->post('Quantity')[$i];
				if($CheckStockSummary = $this->Purchase_model->CheckStockSummary($OldLocationId,$OldProductId,$OldColourId)){

				$SummaryId = $CheckStockSummary->SummaryId; // getting id of available stock summary
				$AvailableQuantity = $CheckStockSummary->Quantity; // quantity of that summary id
				$NewQuantity = ($AvailableQuantity - $OldQuantity); 
				// deducting quantity from db to hidden value

				$FinalQuantity = ($NewQuantity + $Quantity);
				// adding result quantity with input field quantity

				$this->Purchase_model->UpdateStockSummary($SummaryId,$LocationId,$ProductId,$ColourId,$FinalQuantity);
				}
				else{
				$this->Purchase_model->AddStockSummary($LocationId,$ProductId,$ColourId,$Quantity);
				}
	    	}
		    redirect("Purchase/ViewPurchase/".$PurchaseId);
//	    }   

	}


	public function UpdatePurchase___()
	{
	    $UpdateRecordBtn = $this->input->post('UpdateRecordBtn');
	    $PurchaseId = $this->input->post('PurchaseId');
	   
	    if($UpdateRecordBtn=='UpdatePurchaseRecord')
	    {		
		$this->Purchase_model->UpdatePurchaseDetail($PurchaseId);
		if($PurchaseId != '')
		{
		    redirect("Purchase/ViewPurchase/$PurchaseId");
		}
		else
		{
		    redirect("Purchase/");
		}    
	    }   
	}
	

	public function AutoCompleteProductList()
	{
            	  
	  $ProductName = $this->input->post('ProductName');
	  $query = "";
      $query = $this->db->query("SELECT PC.CategoryName, P.ProductId,P.ProductName,P.SellPrice,B.BrandId,B.BrandName,PG.ProductGroupId,PG.ProductGroupName FROM pos_products AS P 
	                            JOIN pos_brands AS B ON P.BrandId = B.BrandId 
	                            JOIN pos_productgroup AS PG ON P.ProductGroupId = PG.ProductGroupId
	                            JOIN pos_category AS PC ON P.CategoryId = PC.CategoryId
	                            WHERE P.ProductName LIKE '%{$ProductName}%' OR B.BrandName LIKE '%{$ProductName}%' OR PC.CategoryName LIKE '%{$ProductName}%' LIMIT 10");
	/*  else
	  {
	    $query = $this->db->query("SELECT ProductId,ProductName,B.BrandId,B.BrandName,PG.ProductGroupId,PG.ProductGroupName FROM pos_products AS P JOIN pos_brands AS B ON P.BrandId = B.BrandId JOIN pos_productgroup AS PG ON P.ProductGroupId = PG.ProductGroupId WHERE P.ProductName LIKE '%{$ProductName}%' LIMIT 10");
	  } 
        */
	  $ProductList = array();
          foreach ($query->result_array() as $key) 
	  {
			    
	    if($key['ProductName'] != '' || $key['ProductName'] != null )
	    { $ProductName = '-'.$key['ProductName']; }
	    
	    $bn = array(
		'id' => trim($key['ProductId']),
		'value' => trim($key['CategoryName'] ." ". $key['ProductName'] ." ". $key['BrandName'] ." ". $key['ProductGroupName']),
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


	public function AccountPayableAmount()
	  {
	  	$CustomerId = $this->input->post('CustomerId');
	  	$CoAId = $this->input->post('CoAId');

	  	$DebitRecord = $this->Purchase_model->DebitRecord($CoAId);
	  	$CreditRecord = $this->Purchase_model->CreditRecord($CoAId);

	  	$AccountPayableAmount = ($CreditRecord->Credit - $DebitRecord->Debit);
	  	echo $AccountPayableAmount;
	  }
	  
	  
	  public function AutoAddProductInCart() 
	{
	    if($this->input->post('ProductId')!="")
	    {
		$this->Purchase_model->AddProductInCart($this->input->post('ProductId'));
	    }
	    
	}  
	  
	  
	public function SearchProductByBarcode() 
	{
	    
	    if($this->input->post('Barcode')!="")
	    {
	       $this->Purchase_model->AddBarcodeItemInCart($this->input->post('Barcode'));
	    }
	    
	    if($this->session->userdata('EmployeeId')!="") {
	    $AllCartItems = $this->Purchase_model->GetProductByBarcode();
	    
	    
	    $SNo = 1;
	    $TotalAmount = 0;
	    $CartTable = '';
	    foreach($AllCartItems as $row)
	    {
		$CartTable .="<tr class='txtMult'>";
		$CartTable .="<td style='margin-top:15px;line-height:25px'>".$SNo."</td>";
		$CartTable .="<td><input style='width:100px; margin-top:1px;' type='text' id='txtCode' name='ProductBarCode[]' value='".$row->ProductBarCode."' class='barcodeinput'></td>";
		$CartTable .="<td><input style='width:100px; margin-top:1px;' type='text' id='ProductId".$SNo."' name='ProductName[]' value='".$row->ProductName."'><input type='hidden' id='hdnProductId_".$SNo."' class='hdnProductId' name='hdnProductName[]' value='".$row->ProductId."'></td>";
		$CartTable .="<td><input style='width:100%; margin-top:1px;' type='text' id='LocationName_".$SNo."' name='LocationName_[]' value='".$row->LocationName."'><input type='hidden' id='hdnLocationName_".$SNo."' name='LocationId[]' value='".$row->LocationId."'></td>";
		$CartTable .="<td><input style='width:100%; margin-top:1px;' type='text' id='ColourName_".$SNo."' name='ColourName[]' value='".$row->ColourName."'><input style='width:90%;' type='hidden' id='hdnColourName_".$SNo."' name='ColourId[]' value='".$row->ColourId."'></td>";
		$CartTable .="<td><input style='width:100%; margin-top:1px; text-align:right;' type='number' id='Rate_".$SNo."' class='Rate' name='Rate[]' value='".$row->Rate."' autocomplete='off' step='0.00'></td>";
		$CartTable .="<td><input style='width:100%; margin-top:1px; text-align:right;' type='number' id='Quantity_".$SNo."' class='Quantity' name='Quantity[]' value='".$row->Quantity."' autocomplete='off' step='0.00'></td>";
		$CartTable .="<td><input style='width:100%; margin-top:1px; text-align:right;' type='number' id='Amount".$SNo."' class='Amount' name='Amount[]' value='".$row->Amount."' step='0.00'></td>";
		$CartTable .="<td><input style='width:100%; margin-top:1px; text-align:right;' type='number' id='DiscountAmount_".$SNo."' class='DiscountAmount' name='DiscountAmount[]' step='0.00'></td>";
		$CartTable .="<td><input style='width:100%; margin-top:1px; text-align:right;' type='number' id='RegularDiscount".$SNo."' class='RegularDiscount' name='RegularDiscount[]' step='0.00'></td>";
		$CartTable .="<td><input style='width:100%; margin-top:1px; text-align:right;' type='number' id='SaleDiscount".$SNo."' class='SaleDiscount' name='SaleDiscount[]' step='0.00'></td>";
		$CartTable .="<td><input style='width:100%; margin-top:1px; text-align:right;' type='number' id='NetAmount".$SNo."' class='NetAmount' name='NetAmount[]' value='".$row->Amount."' step='0.00'></td>";
		$CartTable .="<td><input style='width:170px; margin-top:1px; text-align:left;' type='text' id='Comments".$SNo."' class='Description' name='Comments[]'></td>";
		$CartTable .="<td><input type='hidden' id='PurchaseCartId_".$SNo."' class='PurchaseCartId' name='PurchaseCartId[]' value='".$row->PurchaseCartId."'><i class='fa fa-times-circle remove' title='Delete' style='cursor:pointer; margin-top:6px; color:red;'></i></td>";
		$CartTable .="</tr>";
		$SNo++;
		$TotalAmount =0;
	    }
        echo $CartTable;
	  }
	}
		
	public function UpdateCart()
	{
	    $PurchaseCartId = $this->input->post('PurchaseCartId');
	    $Quantity =  $this->input->post('Quantity');
	    $Rate = $this->input->post('Rate');
	    $DiscountAmount =  $this->input->post('DiscountAmount');
	    $LocationId =  $this->input->post('LocationId');
	    $ColourId =  $this->input->post('ColourId');
	    
	        
	    $this->Purchase_model->UpdateCartVal($PurchaseCartId,$Quantity,$Rate,$DiscountAmount,$LocationId,$ColourId);
	}
	public function DeletePurchase($purchaseId)
	{
	   
	       // Step 1: Find GeneralJournalId for this Purchase
    $this->db->select('GeneralJournalId');
    $this->db->from('pos_accounts_generaljournal');
    $this->db->where('PurchaseId', $purchaseId);
    $journal = $this->db->get()->row();

    // Step 2: Delete related entries
    if ($journal) {
        $this->db->where('GeneralJournalId', $journal->GeneralJournalId);
        $this->db->delete('pos_accounts_generaljournal_entries');
    }

    // Step 3: Delete journal entry
    $this->db->where('PurchaseId', $purchaseId);
    $this->db->delete('pos_accounts_generaljournal');

    // Step 4: Delete purchase details
    $this->db->where('PurchaseId', $purchaseId);
    $this->db->delete('pos_purchase_details');

    // Step 5: Delete stock detail
    $this->db->where('PurchaseId', $purchaseId);
    $this->db->delete('pos_stocks_detail');

    // Step 6: Finally delete main purchase
    $this->db->where('PurchaseId', $purchaseId);
    $this->db->delete('pos_purchase');

		    redirect("Purchase/");
		
	}
	

}
?>