<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Sales extends CI_Controller {

	public function __construct()
	{
	    parent::__construct();
	    $this->check_isvalidated();
	    $this->load->model('Accounts_model');
	    $this->load->model('Account_model');
	    $this->load->model('Customer_model');
	    $this->load->model('Reference_model');
	    $this->load->model('Product_model');
	    $this->load->model('Sale_model');
	    $this->load->model('Employee_model');
	    $this->load->model('Category_model');
	    $this->load->model('Customer_model');
	    $this->load->model('SaleReport_model');
	    $this->load->model('GeneralJournal_model');
	    $this->load->model('StockReport_model');
		$this->load->model('Saleman_model');
		$this->load->model('Setting_model');
		
		
		$this->load->model('AreaManagment_model');
		$this->load->model('Quotation_model');
	}
	

	
	private function check_isvalidated()
	{
        if(!$this->session->userdata('EmployeeId'))
        { $this->session->set_userdata('url',  current_url()); redirect('Login'); }
	}

    private function normalizeImportHeader($value)
    {
        $value = strtolower(trim((string) $value));
        $value = preg_replace('/\s+/', ' ', $value);
        return $value;
    }

    private function normalizeNumericText($value)
    {
        return preg_replace('/\D+/', '', (string) $value);
    }

    private function parseImportFloat($value)
    {
        $value = trim((string) $value);
        if ($value === '') {
            return 0;
        }
        $value = str_replace(',', '', $value);
        return (float) $value;
    }

    private function parseImportDate($value)
    {
        if ($value === null || $value === '') {
            return date('Y-m-d H:i:s');
        }

        if (is_numeric($value)) {
            $excelTime = PHPExcel_Shared_Date::ExcelToPHP((float) $value);
            return date('Y-m-d H:i:s', $excelTime);
        }

        $time = strtotime((string) $value);
        if ($time === false) {
            return date('Y-m-d H:i:s');
        }

        return date('Y-m-d H:i:s', $time);
    }

    private function getMappedValue($row, $aliases)
    {
        foreach ($aliases as $alias) {
            if (array_key_exists($alias, $row) && trim((string) $row[$alias]) !== '') {
                return $row[$alias];
            }
        }
        return '';
    }

    private function detectImportHeaderRow($sheet, $highestRow, $highestColumnIndex)
    {
        $bestRow = 1;
        $bestScore = -1;

        for ($row = 1; $row <= min(15, $highestRow); $row++) {
            $nonEmpty = 0;
            $score = 0;
            for ($col = 0; $col < $highestColumnIndex; $col++) {
                $value = $this->normalizeImportHeader($sheet->getCellByColumnAndRow($col, $row)->getValue());
                if ($value === '') {
                    continue;
                }
                $nonEmpty++;
                if (strpos($value, 'cnic') !== false || strpos($value, 'invoice') !== false || strpos($value, 'ref') !== false) {
                    $score++;
                }
            }

            $score += $nonEmpty;
            if ($score > $bestScore) {
                $bestScore = $score;
                $bestRow = $row;
            }
        }

        return $bestRow;
    }

	public function AllCustomers()
	{
		$data['AllCustomers']=$this->Customer_model->GetAllCustomers();
		$data['CustomerNotification'] = $this->Customer_model->GetNotifications();
		$this->load->view('sale/customers', $data);
	}

	public function AllReferences()
	{
		$data['AllReferences']=$this->Reference_model->GetAllReference();
		$data['CustomerNotification'] = $this->Customer_model->GetNotifications();
		$this->load->view('sale/references', $data);
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
//	    $data['AllSales'] = $this->Sale_model->GetAllSales();
	    $this->load->view('sale/sales', $data);
	}


	public function Ajax_GetAllSales()
	{
		$SalesRoles = $this->Employee_model->GetSalesRoles($this->session->userdata('EmployeeId'));
        $GetAllSales=$this->Sale_model->Ajax_GetAllSales($_REQUEST);

        $ViewRecord = '<span style="color:#00a65a;" class="glyphicon glyphicon-th-large"></span>';
        $ViewReport = '<span style="color:#00a65a;" class=" fa fa-file-text-o text-teal"></span>';
        $UpdateRecord = '<span style="color:#0c6aad;" class="fa fa-edit">';
       

            $data = array();
            $SaleType = "";
            foreach($GetAllSales['record'] as $row)
            {
            	if($row["SaleType"] == '1'){
	            	$SaleType = '<span class="label label-success">On Cash</span>';
	            }
            	if($row["SaleType"] == '2'){
	            	$SaleType = '<span class="label  label-danger">On Credit</span>';
	            }
            	if($row["SaleType"] == '3'){
	            	$SaleType = '<span class="label" style="background:#39cccc; color:#ffffff">Online</span>';
	            }

                $nestedData=array(); 
//                $nestedData[] = $row['SaleNo'];
                $nestedData[] = '<div style="text-align:center;"><input type="checkbox" class="sale-row-checkbox" value="'.$row["SaleId"].'"></div>';
                $nestedData[] = $row['SaleId'];
                
                $nestedData[] = $row['isQuatation'];
                $nestedData[] = $row["SaleDate"];
				$nestedData[] = $SaleType;
				$nestedData[] = $row['SalemanName'];
				$nestedData[] = $row['CustomerName'];
				
				// Paid / Unpaid status (QuickBooks Online style - clean, no icons)
$nestedData[] = $row['has_invoice'] == 1 
    ? '<span style="background:#E6F4EA; color:#137333; padding:6px 14px; border-radius:16px; font-weight:600; font-size:13px; line-height:1;">Paid</span>'
    : '<span style="background:#FDECEA; color:#B71C1C; padding:6px 14px; border-radius:16px; font-weight:600; font-size:13px; line-height:1;">Unpaid</span>';

// FBR Number or Pending (QuickBooks Online style)
$nestedData[] = !empty($row['FbrNo']) 
    ? '<span style="background:#E8F0FE; color:#174EA6; padding:6px 14px; border-radius:16px; font-weight:500; font-size:13px; line-height:1;">'.$row['FbrNo'].'</span>'
: '<span style="background:#F3E8FF; color:#6B21A8; padding:6px 14px; border-radius:16px; font-weight:600; font-size:13px; line-height:1;">Unposted</span>';

// Total Amount (QuickBooks Online style)
$nestedData[] = '<span style="color:#202124; font-weight:600; font-size:14px; line-height:1;">'.$row["TotalAmount"].'</span>';

                $id = $row["SaleId"];
                
//                if ($SalesRoles[0]['ViewRoles'] == 1 && $SalesRoles[0]['UpdateRoles'] ==1 ) {
$links = '
<div class="qbo-dropdown">
    <button type="button" class="qbo-dropbtn">
        <span class="colorful-dots">
            <span style="color: #4CAF50;">•</span>
            <span style="color: #2196F3;">•</span>
            <span style="color: #F44336;">•</span>
        </span>
    </button>
    <div class="qbo-dropdown-content">
        <a href="'.base_url().'Sales/ViewSale/'.$id.'" class="qbo-dropdown-item">
            <i class="fas fa-eye"></i> View Record
        </a>
       
       
        <a href="'.base_url().'SalesReturn/AddSalesReturn/'.$id.'" class="qbo-dropdown-item">
            <i class="fas fa-exchange-alt"></i> Sale Return
        </a>';
        
if($row["FbrNo"]==null) {
    $links .= '
     <a href="'.base_url().'Sales/EditSale/'.$id.'" class="qbo-dropdown-item">
            <i class="fas fa-edit"></i> Edit Record
        </a>
        <a href="'.base_url().'Sales/FBR/'.$id.'" class="qbo-dropdown-item">
            <i class="fas fa-share-square"></i> Post to FBR
        </a>';
        $links .= '
        <a href="'.base_url().'Sales/DeleteSales/'.$id.'" class="qbo-dropdown-item" onclick="return confirm(\'Are you sure you want to delete this record?\')">
            <i class="fas fa-trash-alt"></i> Delete Record
        </a>';
}else{
    $links .= '<a href="'.base_url().'SaleReports/ViewSaleInvoiceReport?InvoiceNo='.$id.'" target="_blank" class="qbo-dropdown-item">
            <i class="fas fa-file-invoice"></i> View Report
        </a>';
}

// Add Delete option


// Add minimal CSS to style the dots
$links .= '
<style>
    .colorful-dots {
        display: inline-flex;
        gap: 4px;
        font-size: 16px;
        line-height: 1;
    }
    .qbo-dropbtn {
        padding: 6px 12px; /* Maintain original button size */
    }
</style>
';

$links .= '
    </div>
</div>

<style>
/* Font Awesome */
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"/>

/* Dropdown Container */
.qbo-dropdown {
    position: relative;
    display: inline-block;
    font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
}

/* Dropdown Button */
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
}

.qbo-dropbtn:hover {
    background: #e9ecef;
    border-color: #adb5bd;
}

/* Dropdown Content */
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

/* Dropdown Items */
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

.qbo-dropdown-item i {
    width: 16px;
    text-align: center;
}

.qbo-dropdown-item:hover {
    background: #f8f9fa;
    color: #2c3e50;
}

/* Icons Color */
.qbo-dropdown-item:nth-child(1) i { color: #3498db; } /* View */
.qbo-dropdown-item:nth-child(2) i { color: #2ecc71; } /* Report */
.qbo-dropdown-item:nth-child(3) i { color: #f39c12; } /* Edit */
.qbo-dropdown-item:nth-child(4) i { color: #e74c3c; } /* Return */
.qbo-dropdown-item:nth-child(5) i { color: #9b59b6; } /* FBR */
.qbo-dropdown-item:nth-child(6) i { color: #e74c3c; } /* Delete */
</style>

<script>
// Close dropdown when clicking outside
document.addEventListener("click", function(event) {
    var dropdowns = document.getElementsByClassName("qbo-dropdown-content");
    for (var i = 0; i < dropdowns.length; i++) {
        var openDropdown = dropdowns[i];
        if (!event.target.matches(".qbo-dropbtn") && !openDropdown.parentElement.contains(event.target)) {
            openDropdown.style.display = "none";
        }
    }
});
</script>';
                $nestedData[] =$links;
/*                }

           
                if ($SalesRoles[0]['ViewRoles'] == 1 ){
					$nestedData[] = '<a href="'.base_url().'Sales/ViewSale/'.$id.'" title="View Record">'.$ViewRecord.'</a>';
                }*/
			
                $data[] = $nestedData;
            }

                $json_data = array(
			"draw" => intval( $_REQUEST['draw'] ),   // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw. 
			"recordsTotal"    => intval( $GetAllSales['recordsTotal'] ),  // total number of records
			"recordsFiltered" => intval( $GetAllSales['recordsFiltered'] ), // total number of records after searching, if there is no searching then totalFiltered = totalData
			"data" => $data   // total data array
			);
                echo json_encode($json_data);  // send data as json format
        }

	function GetRemainingProduct()
	{
//		$LocationId = $this->input->post('LocationId');
		$ProductId = $this->input->post('ProductId');
		$Price = 0;
	    	$Quantity = 0;
	    	$TotalSold = 0;
	    	$RemainingProducts = 0;
//	    	$data['TotalProducts'] = $this->Sale_model->TotalProducts($ProductId, $LocationId);
	    	$data['TotalProducts'] = $this->Sale_model->TotalProducts($ProductId);
		
	    	foreach ($data['TotalProducts'] as $row) {
	    		$Quantity += $row['Quantity'];
	    	}
	   		$TotalPurchased = $Quantity;

//	    	$data['SoldProducts'] = $this->Sale_model->SoldProducts($ProductId, $LocationId);
	    	$data['SoldProducts'] = $this->Sale_model->SoldProducts($ProductId);
	    	foreach ($data['SoldProducts'] as $Sold) {
	    	$TotalSold +=$Sold['Quantity'];
	    	}
	    	if($RemainingProducts = $TotalPurchased - $TotalSold)
		{
//	    	echo "Remaining Stock: " . $RemainingProducts;
	    	echo $RemainingProducts;
		$GetLastPrice = $this->Sale_model->GetLastPrice($ProductId);
//	    $Total = $TotalProducts->PurchaseId;
//		echo "Remaining Stock " . ($Total - $SoldProducts);
//			echo "<br> Last Sold Price " . $Price == $GetLastPrice ? $GetLastPrice->Rate : "" ;
	    	}
	    	else if (!$RemainingProducts) {
    		?>
    		<script>	    			
    		alert("No Stock Available. You can not sale this Product Now");
    		location.reload();
    		</script>
    		<?php
	    	}
	}
	
	function ViewSale($SaleId)
	{
	    $data['AdministrationRoles'] = $this->Employee_model->GetAdministrationRoles($this->session->userdata('EmployeeId'));
	    $data['SalesRoles'] = $this->Employee_model->GetSalesRoles($this->session->userdata('EmployeeId'));
	    $data['PurchasesRoles'] = $this->Employee_model->GetPurchasesRoles($this->session->userdata('EmployeeId'));
	    $data['RegistrationRoles'] = $this->Employee_model->GetRegistrationRoles($this->session->userdata('EmployeeId'));
	    $data['TransactionRoles'] = $this->Employee_model->GetTransactionRoles($this->session->userdata('EmployeeId'));
	    $data['ReportsRoles'] = $this->Employee_model->GetReportsRoles($this->session->userdata('EmployeeId'));
	    $data['GetAllBankAccounts'] = $this->Sale_model->GetAllBankAccounts();
	    
	    $data['Sales'] = $this->Sale_model->GetSales($SaleId);
	    $data['SalesDetail'] = $this->Sale_model->GetSalesDetail($SaleId);
	    $data['CashDetail'] = $this->Sale_model->GetCashDetails($SaleId);
	    $data['CustomerNotification'] = $this->Customer_model->GetNotifications();
	    
	    $this->load->view('sale/view_sale', $data);
	}
	
	
	public function AddSale()
	{
	    // clear sale cart
	    $this->db->where('AddedBy', $this->session->userdata('EmployeeId'));
	    $this->db->delete('pos_sales_cart');
	    
	    $data['AdministrationRoles'] = $this->Employee_model->GetAdministrationRoles($this->session->userdata('EmployeeId'));
	    $data['SalesRoles'] = $this->Employee_model->GetSalesRoles($this->session->userdata('EmployeeId'));
	    $data['PurchasesRoles'] = $this->Employee_model->GetPurchasesRoles($this->session->userdata('EmployeeId'));
	    $data['RegistrationRoles'] = $this->Employee_model->GetRegistrationRoles($this->session->userdata('EmployeeId'));
	    $data['TransactionRoles'] = $this->Employee_model->GetTransactionRoles($this->session->userdata('EmployeeId'));
	    $data['ReportsRoles'] = $this->Employee_model->GetReportsRoles($this->session->userdata('EmployeeId'));
	    $data['AllCustomers']=$this->Customer_model->GetAllCustomers();
	    $data['AllReferences']=$this->Reference_model->GetAllReference();
	    $data['GetAllBankAccounts'] = $this->Sale_model->GetAllBankAccounts();
		$data['GetAllSaleman'] = $this->Saleman_model->GetAllCategories();
	    $data['CustomerNotification'] = $this->Customer_model->GetNotifications();
	    $this->load->view('sale/add_sale', $data);
	}
	
	
	public function EditSale($SaleId)
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
	   // print_r($data['SalesDetail']);
	    $this->load->view('sale/edit_sale', $data);
	}
	public function AddSaleQuatation($QuotationId)
	{   
	   $data['AdministrationRoles'] = $this->Employee_model->GetAdministrationRoles($this->session->userdata('EmployeeId'));
	    $data['SalesRoles'] = $this->Employee_model->GetSalesRoles($this->session->userdata('EmployeeId'));
	    $data['PurchasesRoles'] = $this->Employee_model->GetPurchasesRoles($this->session->userdata('EmployeeId'));
	    $data['RegistrationRoles'] = $this->Employee_model->GetRegistrationRoles($this->session->userdata('EmployeeId'));
	    $data['TransactionRoles'] = $this->Employee_model->GetTransactionRoles($this->session->userdata('EmployeeId'));
	    $data['ReportsRoles'] = $this->Employee_model->GetReportsRoles($this->session->userdata('EmployeeId'));
	    $data['AllReferences']=$this->Reference_model->GetAllReference();
	    $data['AllCustomers']=$this->Customer_model->GetAllCustomers();
	    $data['Sales'] = $this->Quotation_model->GetQuotation($QuotationId);
	    $data['GetAllSaleman'] = $this->Saleman_model->GetAllCategories();
	   // $data['Salemans'] =$this->AreaManagment_model->Ajax_GetAllSalemanAreawise2();
	    $data['SalesDetail'] = $this->Quotation_model->GetQuotationDetail($QuotationId);
	    $data['CustomerNotification'] = $this->Customer_model->GetNotifications();
	    $this->load->view('sale/add_invoice', $data);
	}
    
	
	public function SaveSale___()
	{
	    $AddSaleRecordBtn = $this->input->post('AddSaleRecordBtn');
	    
	    if($AddSaleRecordBtn=='AddSaleRecord')
	    {
	      if($SaleId = $this->Sale_model->SaveSaleDetail())
	      {
	       redirect(base_url()."Sales/ViewSale/$SaleId");
	      }
	    }
	}
	

	public function SaveSale()
	{
	   
	            date_default_timezone_set('Asia/Karachi');
	    $AddSaleRecordBtn = $this->input->post('AddSaleRecordBtn');

	    if($AddSaleRecordBtn=='AddSaleRecord')
	    {
		$SaleId = $this->Sale_model->SaveSaleDetail();
		
	    	for ($i=0; $i < count($this->input->post('LocationId')); $i++)
		{
		    $LocationId = $this->input->post('LocationId')[$i];
		    $ProductId = $this->input->post('ProductId')[$i];
		    $ColourId = $this->input->post('ColourId')[$i];
		    $Quantity = $this->input->post('Quantity')[$i];
	    	
		    if($CheckStockSummary = $this->Sale_model->CheckStockSummary($LocationId,$ProductId,$ColourId))
		    {
			$SummaryId = $CheckStockSummary->SummaryId;
			$AvailableQuantity = $CheckStockSummary->Quantity;
			$NewQuantity = ($AvailableQuantity - $Quantity);
			$this->Sale_model->UpdateStockSummary($SummaryId,$LocationId,$ProductId,$ColourId,$NewQuantity);
		    }
		}
	      
	       redirect(base_url()."Sales/ViewSale/$SaleId");
	    }
	}

	
	public function UpdateSale()
	{
	    date_default_timezone_set('Asia/Karachi');
	   if($this->input->post('SaleId')!= '')
	   {
	    $SaleId = $this->Sale_model->UpdateSaleDetail();
	   		for ($i=0; $i < count($this->input->post('LocationId')); $i++) {
	   			$OldQuantity = $this->input->post('OldQuantity')[$i];
			    $OldColourId = $this->input->post('OldColourId')[$i];
			    $OldLocationId = $this->input->post('OldLocationId')[$i];
			    $OldProductId = $this->input->post('OldProductId')[$i];

	    	$LocationId = $this->input->post('LocationId')[$i];
		    $ProductId = $this->input->post('ProductId')[$i];
		    $ColourId = $this->input->post('ColourId')[$i];
		    $Quantity = $this->input->post('Quantity')[$i];
	    	if($CheckStockSummary = $this->Sale_model->CheckStockSummary($OldLocationId,$OldProductId,$OldColourId)){

				$SummaryId = $CheckStockSummary->SummaryId; // getting id of available stock summary
				$AvailableQuantity = $CheckStockSummary->Quantity; // quantity of that summary id
				$NewQuantity = ($AvailableQuantity - $OldQuantity); 
				// deducting quantity from db to hidden value

				$FinalQuantity = ($Quantity - $NewQuantity);
				// adding result quantity with input field quantity

			$this->Sale_model->UpdateStockSummary($SummaryId,$LocationId,$ProductId,$ColourId,$FinalQuantity);
			}
			else{
				$this->Sale_model->AddStockSummary($LocationId,$ProductId,$ColourId,$Quantity);
			}
		}
		redirect(base_url()."Sales/ViewSale/".$this->input->post('SaleId'));
	    }
	}	
	
  
	public function AutoCompleteProductList()
	{
            	  
	  $ProductName = $this->input->post('ProductName');
	  $query = "";
	  
	  $query = $this->db->query("SELECT PC.CategoryName,P.OpeningStock, P.ProductId,P.ProductBarCode,P.ProductName,P.SellPrice,B.BrandId,B.BrandName,PG.ProductGroupId,PG.ProductGroupName FROM pos_products AS P 
	                            JOIN pos_brands AS B ON P.BrandId = B.BrandId 
	                            JOIN pos_productgroup AS PG ON P.ProductGroupId = PG.ProductGroupId
	                            JOIN pos_category AS PC ON P.CategoryId = PC.CategoryId
	                            WHERE P.ProductName LIKE '%{$ProductName}%' OR B.BrandName LIKE '%{$ProductName}%' OR PC.CategoryName LIKE '%{$ProductName}%' LIMIT 20");
	  
          $ProductList = array();
	  
          foreach ($query->result_array() as $key) 
	  {
	    if($key['ProductName'] != '' || $key['ProductName'] != null )
	    { 
	    //	$ProductName = '-'.$key['ProductName']; 
	    //	$BrandName = '-'.$key['BrandName']; 
	    //}
	    
		$bn = array('id' => trim($key['ProductId']."-".$key['SellPrice']), 
		'value' => trim($key['CategoryName'] . " " . $key['ProductName'] . " " . $key['ProductGroupName'] . "- " . $key['BrandName']),
		'brandname' => trim($key['BrandName']),
		'OpeningStock' => trim($key['OpeningStock']),
		'ProductGroupName' => trim($key['ProductGroupName']),
 		'barcode' => trim($key['ProductBarCode'])
		);
	    }
	    $ProductList[] = $bn;
	  }
	    echo json_encode($ProductList);
         }

	 
	 public function GetProductLastSalePrice($PId = 0)
	{
          if($PId != 0) {	  
	  $ProductId = $PId;
	  }
	  
	  if($this->input->post('ProductId') != 0 || $this->input->post('ProductId') != '') {
	  $ProductId = $this->input->post('ProductId');
	  }
	  
	    $this->db->select("Rate");
	    $this->db->from('pos_sales_detail');
	    $this->db->where('ProductId', $ProductId);
	    $this->db->order_by("SaleDetailId", "DESC");
	    $this->db->limit('1');
	    $query = $this->db->get();	    
	    if($query->num_rows() > 0) {
		$res = $query->row();
		$ProductRate = $res->Rate;
	    } else {
		$ProductRate = 0;
	    }
	  
	    if($PId != 0) {
		return $ProductRate;
	    }
	     
	    if($this->input->post('ProductId') != 0 || $this->input->post('ProductId') != '') {
		echo json_encode($ProductRate);
	    }
	}
	
	public function GetProductLastPurchasePrice($PId = 0)
	{
	  if($PId != 0) {	  
	  $ProductId = $PId;
	  }
	  
	  if($this->input->post('ProductId') != 0 || $this->input->post('ProductId') != '') {
	  $ProductId = $this->input->post('ProductId');
	  }
	  
	    $this->db->select("Rate");
	    $this->db->from('pos_purchase_details');
	    $this->db->where('ProductId', $ProductId);
	    $this->db->order_by("PurchaseDetailId", "DESC");
	    $this->db->limit('1');
	    $query = $this->db->get();
	    if($query->num_rows() > 0) {
		$res = $query->row();
		$ProductRate = $res->Rate;
	    } else {
		$ProductRate = 0;
	    }
	    
	    if($PId != 0) {
		return $ProductRate;
	    }
	     
	    if($this->input->post('ProductId') != 0 || $this->input->post('ProductId') != '') {
		echo json_encode($ProductRate);
	    }
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

	   $query = $this->db->query("SELECT ColourId,ColourName FROM pos_product_colours AS C WHERE C.ColourName LIKE '%{$ColourName}%' LIMIT 10");

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
	
	  
	  public function AddUpdateProduct()
	  {
	   //echo  $SaleCartId = $this->input->post('SaleCartId');
	    $ProductId = $this->input->post('ProductId');
	    $Quantity = $this->input->post('Quantity');
	    
	    $this->db->select('*');
	    $this->db->from("pos_products");
	    $this->db->where('pos_products.ProductId',$ProductId);
	    $query = $this->db->get();

	    foreach ($query->result() as $row)
	    {
	      $this->db->set('ProductId', $row->ProductId);
	      $this->db->set('ProductBarCode', $row->ProductBarCode);
	      $this->db->set('Quantity', $Quantity);
	      $this->db->set('Rate', $row->SellPrice);
	      $this->db->set('Amount', $row->SellPrice);
	      //$this->db->set('TradePrice', $row->TradePrice);
	      $this->db->set('AddedBy', $this->session->userdata('EmployeeId'));
	      $this->db->insert('pos_sales_cart');
	    }
	      
	  }

	  
          public function AccountReceivableAmount()
          {
          	$CustomerId = $this->input->post('CustomerId');
          	$CoAId = $this->input->post('CoAId');

          	$DebitRecord = $this->Sale_model->DebitRecord($CoAId);
          	$CreditRecord = $this->Sale_model->CreditRecord($CoAId);
  
          	$AccountReceivableAmount = ($DebitRecord->Debit - $CreditRecord->Credit);
          	echo $AccountReceivableAmount;
        }
        
        public function CustomerWiseData()
        {
          	$CustomerId = $this->input->post('CustomerId');
             $GetCustomer=$this->Customer_model->GetCustomer($CustomerId);
               echo json_encode($GetCustomer);
        }
	  
	 
	public function AutoAddProductInCart() 
	{
	    if($this->input->post('ProductId')!="")
	    {
		$this->Sale_model->AddProductInCart($this->input->post('ProductId'));
	    }
	    
	}  
	  
	  
	public function SearchProductByBarcode() 
	{
	    
	    if($this->input->post('Barcode')!="")
	    {
	       $this->Sale_model->AddBarcodeItemInCart($this->input->post('Barcode'));
	    }
	    
	    if($this->session->userdata('EmployeeId')!="") {
	    $AllCartItems = $this->Sale_model->GetProductByBarcode();
	    
	    
	
	    
	    $SNo = 1;
	    $TotalAmount = 0;
	    $CartTable = '';
	    foreach($AllCartItems as $row)
	    {
		$LastPurchasePrice = $this->GetProductLastPurchasePrice($row->ProductId);
		$LastSalePrice = $this->GetProductLastSalePrice($row->ProductId);
		
		$CartTable .="<tr class='txtMult'>";
		$CartTable .="<td style='margin-top:15px;line-height:25px'>".$SNo."</td>";
		$CartTable .="<td><input style='width:100px;margin-top:1px;' type='text' id='txtCode' name='ProductBarCode[]' value='".$row->ProductBarCode."' class='barcodeinput'></td>";
		$CartTable .="<td><input style='width:100px;margin-top:1px;' type='text' id='ProductId".$SNo."' name='ProductName[]' value='".$row->ProductName."'><input type='hidden' id='hdnProductId".$SNo."' class='hdnProductId' name='hdnProductName[]' value='".$row->ProductId."'></td>";
		$CartTable .="<td><input style='width:100%; margin-top:1px;' type='text' id='LocationName_".$SNo."' name='LocationName_[]'><input type='hidden' id='hdnLocationName_".$SNo."' name='LocationId[]'></td>";
		$CartTable .="<td><input style='width:60%; margin-top:1px;' type='text' value='".$LastPurchasePrice."' id='LastPurchasePrice_".$SNo."'><input type='hidden' id='hdnColourName_".$SNo."' name='ColourId[]'></td>";
		$CartTable .="<td><input style='width:60%; margin-top:1px;' type='text' value='".$LastSalePrice."' id='LastSalePrice_".$SNo."'></td>";
		$CartTable .="<td><input style='width:100%; margin-top:1px; text-align:right;' type='number' id='Rate_".$SNo."' class='Rate' name='Rate[]' value='".$row->Rate."' autocomplete='off' step='0.00'></td>";
		$CartTable .="<td><input style='width:100%; margin-top:1px; text-align:right;' type='number' id='Quantity_".$SNo."' class='Quantity' name='Quantity[]' value='".$row->Quantity."' autocomplete='off' step='0.00'></td>";
		$CartTable .="<td><input style='width:100%; margin-top:1px; text-align:right;' type='number' id='Amount_".$SNo."' class='Amount' name='Amount[]' value='".$row->Amount."' step='0.00'></td>";
		$CartTable .="<td><input style='width:100%; margin-top:1px; text-align:right;' type='number' id='DiscountAmount_".$SNo."' class='DiscountAmount' name='DiscountAmount[]' step='0.00'></td>";
		$CartTable .="<td><input style='width:100%; margin-top:1px; text-align:right;' type='number' id='TaxPercentage".$SNo."' class='TaxPercentage' name='TaxPercentage[]' step='0.00'></td>";
		$CartTable .="<td><input style='width:100%; margin-top:1px; text-align:right;' type='number' id='TaxAmount".$SNo."' class='TaxAmount' name='TaxAmount[]' step='0.00'></td>";
		$CartTable .="<td><input style='width:100%; margin-top:1px; text-align:right;' type='number' id='NetAmount".$SNo."' class='NetAmount' name='NetAmount[]' value='".$row->Amount."' step='0.00'></td>";
		$CartTable .="<td><input type='hidden' id='SaleCartId_".$SNo."' class='SaleCartId' name='SaleCartId[]' value='".$row->SaleCartId."'><i class='fa fa-times-circle remove' title='Delete' style='cursor:pointer; margin-top:6px; color:red;'></i></td>";
		$CartTable .="</tr>";
		$SNo++;
		$TotalAmount =0;
	    }

	    /*
	     $CartTable .="<tr style='font-size:0.80em; font-weight:700;'>";
	    $CartTable .="<td colspan='7' style='text-align:right;'>Total Amount:</td>";
	    $CartTable .="<td><input style='font-weight:600; color:#3333CC; background:transparent; border:none; text-align:right;' type='text' readonly='readonly' size='8' name='OrderAmount' id='OrderAmount' value='".$TotalAmount."'/></td>";
	    $CartTable .="<td></td>";
	    $CartTable .="<td></td>";
	    $CartTable .="<td></td>";
	    $CartTable .="<td></td>";
	    $CartTable .="<td></td>";
	    $CartTable .="<td></td>";
	    $CartTable .="</tr>";
	    $CartTable .="<tr style='font-size:0.80em; font-weight:700;'>";
	    $CartTable .="<td colspan='7' style='text-align:right;'>Less Discount Amount:</td>";
	    $CartTable .="<td><input style='font-weight:600; color:#800000; background:transparent; border:none; text-align:right;' type='text' readonly='readonly' size='8' name='OrderDiscountAmount' id='OrderDiscountAmount' value='0' /></td>";
	    $CartTable .="<td></td>";
	    $CartTable .="<td></td>";
	    $CartTable .="<td></td>";
	    $CartTable .="<td></td>";
	    $CartTable .="<td></td>";
	    $CartTable .="<td></td>";
	    $CartTable .="</tr>";
	    $CartTable .="<tr style='font-size:0.80em; font-weight:700;'>";
	    $CartTable .="<td colspan='7' style='text-align:right;'>Net Amount:</td>";
	    $CartTable .="<td style='font-weight:600; color:#008000;'><input style='font-weight:600; color:#008000; background:transparent; border:none; text-align:right;' type='text' readonly='readonly' size='8' name='OrderNetAmount' id='OrderNetAmount' value='".$TotalAmount."' /></td>";
	    $CartTable .="<td></td>";
	    $CartTable .="<td></td>";
	    $CartTable .="<td></td>";
	    $CartTable .="<td></td>";
	    $CartTable .="<td></td>";
	    $CartTable .="<td></td>";
	    $CartTable .="</tr>";
	    $CartTable .="</table>";
	    */
	    echo $CartTable;
	  }
	}

	
	public function UpdateCart()
	{
	    $SaleCartId = $this->input->post('SaleCartId');
	    $Quantity =  $this->input->post('Quantity');
	    $Rate = $this->input->post('Rate');
	    $DiscountAmount =  $this->input->post('DiscountAmount');
	    
	    
	    
	    $this->Sale_model->UpdateCartVal($SaleCartId,$Quantity,$Rate,$DiscountAmount);
	}
	
	public function GetProductSaleRates()
	{
	  $ProductId = 0;
	  if($this->input->post('ProductId') != 0 || $this->input->post('ProductId') != '') {
	  $ProductId = $this->input->post('ProductId');
	  }
	  
	    $this->db->select("SellPrice");
	    $this->db->from('pos_products');
	    $this->db->where('ProductId', $ProductId);
	    $this->db->order_by("ProductId", "DESC");
	    $this->db->limit('1');
	    $query = $this->db->get();
	    if($query->num_rows() > 0) {
    		$res = $query->row();
    		$ProductRate = $res->SellPrice;
	    } else {
		    $ProductRate = 0;
	    }
	     
	    if($this->input->post('ProductId') != 0 || $this->input->post('ProductId') != '') {
		  echo json_encode($ProductRate);
	    }
	}
	 public function GetAvailableQty($PId = 0)
	{
	    $StartDate = "2022-01-01";
	    $EndDate = "2070-01-01";
          if($PId != 0) {	  
    	  $ProductId = $PId;
    	  }
	  
	  if($this->input->post('ProductId') != 0 || $this->input->post('ProductId') != '') {
	    $ProductId = $this->input->post('ProductId');
	  }
// 	  echo $ProductId; exit;
	    $AllProducts = $this->Product_model->GetAllProducts($colmun = 'pos_products.ProductId,pos_products.ProductName,pos_productgroup.ProductGroupName,pos_brands.BrandName', $ProductId);
	    $AllPurchaseRecord = $this->StockReport_model->GetAllPurchaseRecord($StartDate,$EndDate,$ProductId,$ProductGroupId=null,$BrandId=null);
	    $AllPurchaseReturnRecord = $this->StockReport_model->GetAllPurchaseReturnRecord($StartDate,$EndDate,$ProductId,$ProductGroupId=null,$BrandId=null);
	    
	    $AllSaleRecord = $this->StockReport_model->GetAllSaleRecord($StartDate,$EndDate,$ProductId,$ProductGroupId=null,$BrandId=null);
	    $AllSaleReturnRecord = $this->StockReport_model->GetAllSaleReturnRecord($StartDate,$EndDate,$ProductId,$ProductGroupId=null,$BrandId=null);
	    
        $PurchaseQuantity = 0;
        $PurchaseReturnQuantity = 0;
        $SaleQuantity = 0;
        $SaleReturnQuantity = 0;
        $BalanceQuantity = 0;
        
        $TotalPurchaseQuantity = 0;
        $TotalPurchaseReturnQuantity = 0;
        $TotalSaleQuantity = 0;
        $TotalSaleReturnQuantity = 0;
        $TotalBalanceQuantity = 0;
        $SNo=1;
    
        if(isset($AllProducts)) {
        foreach($AllProducts as $ProductRecord) 
        {
        	// Getting Total Purchase Quantity
        	if(isset($AllPurchaseRecord))
        	{
        	  foreach($AllPurchaseRecord as $PurchaseRecord)
        	  {  
        	      if($PurchaseRecord['ProductId'] == $ProductRecord['ProductId'])
        	      { 
        		  $PurchaseQuantity = $PurchaseRecord['Quantity']; 
        	      }
        	  }
        	}
        	
        	// Getting Total Purchase Return Quantity
        	if(isset($AllPurchaseReturnRecord))
        	{
        	  foreach($AllPurchaseReturnRecord as $PurchaseReturnRecord)
        	  { 
        	      if($PurchaseReturnRecord['ProductId'] == $ProductRecord['ProductId'])
        	      { 
        		 $PurchaseReturnQuantity = $PurchaseReturnRecord['Quantity'];
        	      }
        	  }
        	}
        	
        	// Getting Total Sale Quantity
        	if(isset($AllSaleRecord))
        	{
        	  foreach($AllSaleRecord as $SaleRecord)
        	  { 
        	      if($SaleRecord['ProductId'] == $ProductRecord['ProductId'])
        	      {
        		$SaleQuantity = $SaleRecord['Quantity']; 
        	      }
        	  }
        	}
        	
        	// Getting Total Sale Return Quantity
        	if(isset($AllSaleReturnRecord))
        	{
        	  foreach($AllSaleReturnRecord as $SaleReturnRecord)
        	  { 
        	      if($SaleReturnRecord['ProductId'] == $ProductRecord['ProductId'])
        	      {
        		$SaleReturnQuantity = $SaleReturnRecord['Quantity']; 
        	      }
        	  }
        	}
    
        	if($PurchaseQuantity != 0 || $PurchaseReturnQuantity != 0 || $SaleQuantity != 0 || $SaleReturnQuantity != 0) 
        	{
        	   $BalanceQuantity += ($PurchaseQuantity + $SaleReturnQuantity) - ($SaleQuantity + $PurchaseReturnQuantity);
        	   
        	   echo json_encode(number_format($BalanceQuantity,0)); die;
        	    $SNo++;	
        	    $TotalPurchaseQuantity += $PurchaseQuantity;	
            	$TotalPurchaseReturnQuantity += $PurchaseReturnQuantity;
            	$TotalSaleQuantity += $SaleQuantity;
            	$TotalSaleReturnQuantity += $SaleReturnQuantity;	
            	$TotalBalanceQuantity += $BalanceQuantity;
            
            	$PurchaseQuantity = 0;
            	$PurchaseReturnQuantity = 0;
            	$SaleQuantity = 0;
            	$SaleReturnQuantity = 0;
            	$BalanceQuantity = 0;
        	}
    	}
    }
	}
	
// 	public function  FBR($SaleId)
// 	{
//         date_default_timezone_set('Asia/Karachi');
// 		$data['Sales'] = $this->Sale_model->GetSales($SaleId);
// 		$data['SalesDetail'] = $this->Sale_model->GetSalesDetail($SaleId);

// 		$items = [];

// 		$totalSaleValue = 0;
// 		$TotalQuantity = 0;
// 		$TotalAmount = 0;
// 		$TotalTaxCharged = 0;
// 		$TotalDiscount = 0;
// 		$InvoiceType = 0;
// 		foreach ($data['SalesDetail'] as $key => $value) {

// 			$items[] = [
// 				"ItemCode" =>  $value['ProductId'],
// 				"ItemName" => $value['ProductName'],
// 				"Quantity" =>  number_format($value['Quantity'], 0),
// 				"PCTCode" => $value['OpeningStock'],
// 				"TaxRate" => number_format($value['DiscountAmount'], 0),
// 				"SaleValue" => number_format($value['Amount']-$value['TaxAmount'], 0),
// 				"TotalAmount" =>  number_format($value['NetAmount'], 0),
// 				"TaxCharged" =>  number_format($value['TaxPercentage'], 0),
// 				"Discount" =>  0,
// 				"FurtherTax" => 0,
// 				"RefUSIN" => null,
// 				"InvoiceType" => 11,
// 				"IsThirdScheduleItem" => true
// 			];

// 			$totalSaleValue += $value['Amount']-$value['TaxAmount'];
// 			$TotalQuantity += $value['Quantity'];
// 			$TotalAmount += $value['NetAmount'];
// 			$TotalTaxCharged += $value['TaxPercentage'];
// 			$TotalDiscount = 0;
// 			$InvoiceType = 1;
// 		}

// 		$postData = array(
// 			"POSID" => 123,
// 			"USIN" => "USIN" . $data['Sales']->SaleId,
// 			"DateTime" => $data['Sales']->SaleDate,
// 			"BuyerNTN" => $data['Sales']->fbr_ntn,
// 			"BuyerCNIC" => $data['Sales']->fbr_cnic,
// 			"BuyerName" => $data['Sales']->fbr_customer,
// 			"BuyerPhoneNumber" => $data['Sales']->fbr_mobile,
// 			"TotalBillAmount" => number_format(($TotalAmount), 0),
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

// 		// Encode the data to JSON format
// 		$jsonData = json_encode($postData);

// 		$curl = curl_init();

// 		curl_setopt_array($curl, array(
// 			CURLOPT_URL => 'https://gw.fbr.gov.pk/di_data/v1/di/postinvoicedata_sb',//'https://gw.fbr.gov.pk/imsp/v1/api/Live/PostData',
// 			CURLOPT_RETURNTRANSFER => true,
// 			CURLOPT_ENCODING => '',
// 			CURLOPT_MAXREDIRS => 10,
// 			CURLOPT_TIMEOUT => 0,
// 			CURLOPT_FOLLOWLOCATION => true,
// 			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
// 			CURLOPT_SSL_VERIFYPEER => false,
// 			CURLOPT_SSL_VERIFYHOST => false,
// 			CURLOPT_CUSTOMREQUEST => 'POST',
// 			CURLOPT_POSTFIELDS => $jsonData,
// 			CURLOPT_HTTPHEADER => array(
// 				'Authorization: Bearer e70881fe-8bcd-3c41-9e51-d9d4f0aa7227',
// 				'Content-Type: application/json'
// 			),
// 		));

// 		$response = curl_exec($curl);

// 		if (curl_errno($curl)) {
// 			echo 'Error:' . curl_error($curl);
// 		}

// 		curl_close($curl);

// 		$response = json_decode($response, true);

// 		$FbrNo = array(
// 			'FbrNo' =>  $response['InvoiceNumber'],
// 		);
		
// 		$this->db->set($FbrNo);
// 		$this->db->where('SaleId', $SaleId);
// 		$this->db->update('pos_sales');
// 		redirect('/Sales');
// 	}
	
// 	public function  FBR($SaleId)
// 	{
//         date_default_timezone_set('Asia/Karachi');
// 		$data['Sales'] = $this->Sale_model->GetFbrSales($SaleId);
// 		$data['SalesDetail'] = $this->Sale_model->GetFbrSalesDetail($SaleId);
// 		$data['GetSetting']=$this->Setting_model->GetSetting($SettingId=1);
// 		$items = [];

// 		$totalSaleValue = 0;
// 		$TotalQuantity = 0;
// 		$TotalAmount = 0;
// 		$TotalTaxCharged = 0;
// 		$TotalDiscount = 0;
// 		$InvoiceType = 0;
// 		foreach ($data['SalesDetail'] as $key => $value) {
			
// 			$items[] = [
//                   "hsCode" => $value['OpeningStock'],
//                   "productDescription" => $value['ProductName'],
//                   "rate" => floatval($value['DiscountAmount'])."%",
//                   "uoM" => $value['ProductGroupName'],
//                   "quantity" => round($value['Quantity'], 2),
//                   "totalValues" => round($value['NetAmount'], 2),
//                   "valueSalesExcludingST" => round($value['Amount'], 2),
//                   "salesTaxApplicable" => round($value['TaxPercentage'], 2),
//                   "fixedNotifiedValueOrRetailPrice" => 0,
//                   "salesTaxWithheldAtSource" => 0,
//                   "extraTax" => 0,
//                   "furtherTax" => 0,
//                   "sroScheduleNo" => "",
//                   "fedPayable" => 0,
//                   "discount" => 0,
//                   "saleType" => "Goods at standard rate (default)",
//                   "sroItemSerialNo" => ""
//             ];

// 			$totalSaleValue += $value['Amount']-$value['TaxAmount'];
// 			$TotalQuantity += $value['Quantity'];
// 			$TotalAmount += $value['NetAmount'];
// 			$TotalTaxCharged += $value['TaxPercentage'];
// 			$TotalDiscount = 0;
// 			$InvoiceType = 1;
// 		}
		
// 		$postData = array(
//           "invoiceType" => "Sale Invoice",
//           "invoiceDate" => date('Y-m-d', strtotime($data['Sales']->SaleDate)),
//           "destinationOfSupply" => "Sindh",
//           "sellerBusinessName" => $data['GetSetting']->CompanyName,
//           "sellerProvince" => "Sindh",
//           "sellerAddress" => $data['GetSetting']->ProductsDeals,
//           "sellerNTNCNIC" => $data['GetSetting']->Email,
//           "buyerNTNCNIC" => $data['Sales']->PhoneNo,
//           "buyerBusinessName" => $data['Sales']->CustomerName,
//           "buyerProvince" => $data['Sales']->FaxNo,
//           "buyerAddress" => $data['Sales']->buyerAddress,
//           "invoiceRefNo" => "",
//           "buyerRegistrationType" => $data['Sales']->AreaId,
//           "scenarioId" => "SN001",
//           "items" => $items
//         );
//         // echo '<pre>'; print_r($postData); echo '</pre>'; exit;
// 		// Encode the data to JSON format
// 		$jsonData = json_encode($postData);

// 		$curl = curl_init();

// 		curl_setopt_array($curl, array(
// 			CURLOPT_URL => 'https://gw.fbr.gov.pk/di_data/v1/di/postinvoicedata',//'https://gw.fbr.gov.pk/di_data/v1/di/postinvoicedata_sb',//'https://gw.fbr.gov.pk/imsp/v1/api/Live/PostData',
// 			CURLOPT_RETURNTRANSFER => true,
// 			CURLOPT_ENCODING => '',
// 			CURLOPT_MAXREDIRS => 10,
// 			CURLOPT_TIMEOUT => 0,
// 			CURLOPT_FOLLOWLOCATION => true,
// 			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
// 			CURLOPT_SSL_VERIFYPEER => false,
// 			CURLOPT_SSL_VERIFYHOST => false,
// 			CURLOPT_CUSTOMREQUEST => 'POST',
// 			CURLOPT_POSTFIELDS => $jsonData,
// 			CURLOPT_HTTPHEADER => array(
// 				'Authorization: Bearer 1dcd5b11-ba89-30c4-9047-ea78e7f33741',
// 				'Content-Type: application/json'
// 			),
// 		));
//     // print_r($response); exit;
// 		$response = curl_exec($curl);
	
// 		if (curl_errno($curl)) {
// 			echo 'Error:' . curl_error($curl);
// 		}

// 		curl_close($curl);

// 		$response = json_decode($response, true);
		
// 		// Check nested invoiceNo
//         $invoiceStatuses = $response['validationResponse']['invoiceStatuses'] ?? [];
//         $invoiceNo = '';
    
//         if (!empty($invoiceStatuses) && isset($invoiceStatuses[0]['invoiceNo'])) {
//             $invoiceNo = $invoiceStatuses[0]['invoiceNo'];
//         }
        
// 		$FbrNo = array(
// 			'FbrNo' =>  $invoiceNo,
// 		);
		
// 		$this->db->set($FbrNo);
// 		$this->db->where('SaleId', $SaleId);
// 		$this->db->update('pos_sales');
        
// 		redirect('/Sales');
// 	}

    
	public function  FBR($SaleId)
	{
        date_default_timezone_set('Asia/Karachi');
		$data['Sales'] = $this->Sale_model->GetFbrSales($SaleId);
		$data['SalesDetail'] = $this->Sale_model->GetFbrSalesDetail($SaleId);
		$data['GetSetting']=$this->Setting_model->GetSetting($SettingId=1);

		$scenarioId = $data['Sales']->Scenario_Type;

		$items = $this->buildFbrItems($data['SalesDetail'], $scenarioId);
		
		$postData = array(
          "invoiceType" => "Sale Invoice",
          "invoiceDate" => date('Y-m-d', strtotime($data['Sales']->SaleDate)),
          "destinationOfSupply" => "Sindh",
          "sellerBusinessName" => $data['GetSetting']->CompanyName,
          "sellerProvince" => "Sindh",
          "sellerAddress" => $data['GetSetting']->ProductsDeals,
          "sellerNTNCNIC" => $data['GetSetting']->Email,
          "buyerNTNCNIC" => ($scenarioId == "SN002") ? "" : $data['Sales']->PhoneNo,
          "buyerBusinessName" => $data['Sales']->CustomerName,
          "buyerProvince" => $data['Sales']->FaxNo,
          "buyerAddress" => $data['Sales']->buyerAddress,
          "invoiceRefNo" => "",
          "buyerRegistrationType" => ($scenarioId == "SN002") ? "Unregistered" : $data['Sales']->AreaId,
          "scenarioId" => $scenarioId,
          "items" => $items
        );
        // echo '<pre>'; print_r($postData); echo '</pre>'; exit;
		// Encode the data to JSON format
		$jsonData = json_encode($postData);

		$curl = curl_init();

		curl_setopt_array($curl, array(
			CURLOPT_URL => 'https://gw.fbr.gov.pk/di_data/v1/di/postinvoicedata_sb',//'https://gw.fbr.gov.pk/imsp/v1/api/Live/PostData',
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
				'Authorization: Bearer 214bcfd9-84b6-3196-934f-3b1e07a9c09a',
				'Content-Type: application/json'
			),
		));
		$responseRaw = curl_exec($curl);
        curl_close($curl);
        
        $response = json_decode($responseRaw, true);
        
        if (json_last_error() !== JSON_ERROR_NONE) {
            echo "JSON Decode Error: " . json_last_error_msg();
            exit;
        }
        
        $invoiceStatuses = $response['validationResponse']['invoiceStatuses'] ?? [];
        
        $errors = [];
        foreach ($invoiceStatuses as $item) {
            if (isset($item['status']) && strtolower($item['status']) === 'invalid') {
                $itemNo = $item['itemSNo'] ?? 'N/A';
                $errorCode = $item['errorCode'] ?? '';
                $errorMsg = $item['error'] ?? 'Unknown error';
                $errors[] = "Item {$itemNo} (Code {$errorCode}): {$errorMsg}";
            }
        }
        
        if (!empty($errors)) {
            $errorMessage = implode('<br>', $errors);
            $this->session->set_flashdata('fbr_error', $errorMessage);
            redirect('/Sales');
            return;
        }
        
        // Extract invoice number if valid
        $invoiceNo = $response['invoiceNumber'] ?? null;
        
        if ($invoiceNo) {
            $FbrNo = ['FbrNo' => $invoiceNo];
            $this->db->set($FbrNo)->where('SaleId', $SaleId)->update('pos_sales');
            $this->session->set_flashdata('fbr_success', 'Invoice submitted successfully');
        } else {
            $this->session->set_flashdata('fbr_error', 'Invoice number not returned by FBR.');
        }
        
        redirect('/Sales');

	}
	public function buildFbrItems($saleDetails, $scenarioId)
	{
		$items = [];

		foreach ($saleDetails as $value) {
			$item = [
				"hsCode" => $value['OpeningStock'],
				"productDescription" => $value['ProductName'],
				"uoM" => $value['ProductGroupName'],
				"quantity" => round($value['Quantity'], 2),
				"totalValues" => round($value['NetAmount'], 2),
				"valueSalesExcludingST" => round($value['Amount'], 2),
				"salesTaxApplicable" => ($scenarioId == "SN006") ? 0 : round($value['TaxPercentage'], 2),
				"fixedNotifiedValueOrRetailPrice" => ($scenarioId == "SN008" || $scenarioId == "SN027" || $scenarioId == "SN018" || $scenarioId == "SN019") ? round($value['Amount'], 2) : 0,
				"salesTaxWithheldAtSource" => 0,
				"extraTax" => ($scenarioId == "SN005" || $scenarioId == "SN028") ? "" : 0,
				"furtherTax" => ($scenarioId == "SN002" || $scenarioId == "SN024" || $scenarioId == "SN026") ? round($value['FurtherTaxAmt'], 2) : 0,
				"fedPayable" => 0,
				"discount" => 0,
			];

			// Scenario specific logic
			switch ($scenarioId) {
				case 'SN001':
				case 'SN002':
					$item["rate"] = floatval($value['DiscountAmount']) . "%";
					$item["saleType"] = "Goods at standard rate (default)";
					$item["sroScheduleNo"] = "";
					$item["sroItemSerialNo"] = "";
					break;

				case 'SN005':
					$item["rate"] = "10%";
					$item["saleType"] = "Goods at Reduced Rate";
					$item["sroScheduleNo"] = "EIGHTH SCHEDULE Table 1";
					$item["sroItemSerialNo"] = "88";
					break;

				case 'SN006':
					$item["rate"] = "Exempt";
					$item["saleType"] = "Exempt goods";
					$item["sroScheduleNo"] = "EIGHTH SCHEDULE Table 1";
					$item["sroItemSerialNo"] = "81";
					break;

				case 'SN007':
					$item["rate"] = "0%";
					$item["saleType"] = "Goods at zero-rate";
					$item["sroScheduleNo"] = "FIFTH SCHEDULE";
					$item["sroItemSerialNo"] = "10";
					break;

				case 'SN008':
					$item["rate"] = "18%";
					$item["saleType"] = "3rd Schedule Goods";
					$item["sroScheduleNo"] = "EIGHTH SCHEDULE Table 1";
					$item["sroItemSerialNo"] = "88";
					break;

				case 'SN016':
					$item["rate"] = "3%";
					$item["saleType"] = "Processing/Conversion of Goods";
					$item["sroScheduleNo"] = "FIFTH SCHEDULE";
					$item["sroItemSerialNo"] = "10";
					break;

				case 'SN017':
					$item["rate"] = "17%";
					$item["saleType"] = "Goods (FED in ST Mode)";
					$item["sroScheduleNo"] = "FIFTH SCHEDULE";
					$item["sroItemSerialNo"] = "10";
					break;
					
				case 'SN018':
					$item["rate"] = "8%";
					$item["saleType"] = "Services (FED in ST Mode)";
					$item["sroScheduleNo"] = "";
					$item["sroItemSerialNo"] = "";
					break;
					
				case 'SN019':
					$item["rate"] = "5%";
					$item["saleType"] = "Services";
					$item["sroScheduleNo"] = "ICTO TABLE I";
					$item["sroItemSerialNo"] = "1(ii)(ii)(a)";
					break;
					
				case 'SN020':
					$item["rate"] = "1%";
					$item["saleType"] = "Electric Vehicle";
					$item["sroScheduleNo"] = "6th Schd Table III";
					$item["sroItemSerialNo"] = "20";
					break;

				case 'SN024':
					$item["rate"] = "25%";
					$item["saleType"] = "Goods as per SRO.297(|)/2023";
					$item["sroScheduleNo"] = "297(I)/2023-Table-I";
					$item["sroItemSerialNo"] = "12";
					break;
					
				case 'SN026':
					$item["rate"] = "18%";
					$item["saleType"] = "Goods at standard rate (default)";
					$item["sroScheduleNo"] = "";
					$item["sroItemSerialNo"] = "";
					break;
					
				case 'SN027':
					$item["rate"] = "18%";
					$item["saleType"] = "3rd Schedule Goods";
					$item["sroScheduleNo"] = "";
					$item["sroItemSerialNo"] = "";
					break;
					
				case 'SN028':
					$item["rate"] = "10%";
					$item["saleType"] = "Goods at Reduced Rate";
					$item["sroScheduleNo"] = "EIGHTH SCHEDULE Table 1";
					$item["sroItemSerialNo"] = "88";
					break;

				default:
					$item["rate"] = "0%";
					$item["saleType"] = "Unknown";
					$item["sroScheduleNo"] = "";
					$item["sroItemSerialNo"] = "";
					break;
			}

			$items[] = $item;
		}
		
		return $items;
	}

    public function DownloadSalesImportTemplate()
    {
        require_once APPPATH . 'libraries/PHPExcel.php';
        if (!class_exists('ZipArchive')) {
            PHPExcel_Settings::setZipClass(PHPExcel_Settings::PCLZIP);
        }

        $excel = new PHPExcel();
        $excel->getProperties()
            ->setCreator('AL-SYED SOFTWARE')
            ->setTitle('Sales Import Template')
            ->setDescription('Latest sales import template');

        $sheet = $excel->setActiveSheetIndex(0);
        $sheet->setTitle('Sales Import');

        $headers = array(
            'Scenario Type',
            'Customer Name',
            'Cus: CNIC',
            'Reference No',
            'Invoice Date',
            'Product Id',
            'Qty',
            'Amount',
            'GST Rate',
            'GST',
            'F.Tax %',
            'F.Tax Amt',
            'Discount',
            'Net Amount',
        );

        $col = 0;
        foreach ($headers as $header) {
            $sheet->setCellValueByColumnAndRow($col, 1, $header);
            $col++;
        }

        $rows = array(
            array('SN006', 'ABC Store', '41301-1234567-1', 'INV-1001', '2026-03-09', 101, 10, 5000, 18, 900, 4, 200, -100, 6000),
            array('SN006', 'ABC Store', '41301-1234567-1', 'INV-1001', '2026-03-09', 102, 5, 2500, 18, 450, 4, 100, -50, 3000),
            array('SN006', 'XYZ Traders', '42101-9876543-9', 'INV-1002', '2026-03-09', 103, 20, 8000, 18, 1440, 4, 320, -200, 9560),
        );

        $rowNumber = 2;
        foreach ($rows as $row) {
            for ($i = 0; $i < count($row); $i++) {
                $sheet->setCellValueByColumnAndRow($i, $rowNumber, $row[$i]);
            }
            $rowNumber++;
        }

        foreach (range('A', 'N') as $columnId) {
            $sheet->getColumnDimension($columnId)->setAutoSize(true);
        }

        $filename = 'Sales_Import_Template_Latest.xlsx';

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');
        header('Cache-Control: max-age=1');
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
        header('Cache-Control: cache, must-revalidate');
        header('Pragma: public');

        $writer = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
        $writer->save('php://output');
        exit;
    }

    public function ImportSalesExcel()
    {
        if (empty($_FILES['import_excel']['name'])) {
            $this->session->set_flashdata('fbr_error', 'Please select an Excel file first.');
            redirect('Sales');
            return;
        }

        $originalName = $_FILES['import_excel']['name'];
        $extension = strtolower(pathinfo($originalName, PATHINFO_EXTENSION));
        if (!in_array($extension, array('xlsx', 'xls'))) {
            $this->session->set_flashdata('fbr_error', 'Only .xlsx or .xls files are allowed.');
            redirect('Sales');
            return;
        }

        $config['upload_path'] = './uploads/';
        $config['allowed_types'] = '*';
        $config['max_size'] = 10240;
        $config['file_name'] = 'sale_import_' . time();
        $config['overwrite'] = false;
        $config['detect_mime'] = false;
        $config['mod_mime_fix'] = false;

        $this->load->library('upload', $config);
        if (!$this->upload->do_upload('import_excel')) {
            $this->session->set_flashdata('fbr_error', $this->upload->display_errors('', ''));
            redirect('Sales');
            return;
        }

        $uploadData = $this->upload->data();
        $filePath = $uploadData['full_path'];

        require_once APPPATH . 'libraries/PHPExcel.php';
        if (!class_exists('ZipArchive')) {
            PHPExcel_Settings::setZipClass(PHPExcel_Settings::PCLZIP);
        }
        try {
            $readerType = ($extension === 'xlsx') ? 'Excel2007' : 'Excel5';
            $reader = PHPExcel_IOFactory::createReader($readerType);
            $reader->setReadDataOnly(true);
            if (!$reader->canRead($filePath)) {
                @unlink($filePath);
                $this->session->set_flashdata('fbr_error', 'Invalid Excel file. Please use the latest template.');
                redirect('Sales');
                return;
            }
            $excel = $reader->load($filePath);
        } catch (Exception $e) {
            @unlink($filePath);
            $this->session->set_flashdata('fbr_error', 'Unable to read Excel file.');
            redirect('Sales');
            return;
        }

        if ((int) $excel->getSheetCount() < 1) {
            @unlink($filePath);
            $this->session->set_flashdata('fbr_error', 'Excel file has no worksheet. Please download and use the latest template again.');
            redirect('Sales');
            return;
        }

        $sheet = $excel->getSheet(0);
        $highestRow = (int) $sheet->getHighestRow();
        $highestColumnIndex = PHPExcel_Cell::columnIndexFromString($sheet->getHighestColumn());
        $headerRowNumber = $this->detectImportHeaderRow($sheet, $highestRow, $highestColumnIndex);

        $headers = array();
        for ($col = 0; $col < $highestColumnIndex; $col++) {
            $headerText = $sheet->getCellByColumnAndRow($col, $headerRowNumber)->getValue();
            $headers[$col] = $this->normalizeImportHeader($headerText);
        }

        $invoiceGroups = array();
        $skippedRows = 0;

        for ($row = $headerRowNumber + 1; $row <= $highestRow; $row++) {
            $rowAssoc = array();
            $hasAnyValue = false;
            for ($col = 0; $col < $highestColumnIndex; $col++) {
                $cell = $sheet->getCellByColumnAndRow($col, $row);
                $value = $cell->getValue();
                if ($cell->getDataType() === PHPExcel_Cell_DataType::TYPE_FORMULA) {
                    $value = $cell->getCalculatedValue();
                }
                if ($value instanceof PHPExcel_RichText) {
                    $value = $value->getPlainText();
                }
                $value = trim((string) $value);
                if ($value !== '') {
                    $hasAnyValue = true;
                }
                $rowAssoc[$headers[$col]] = $value;
            }

            if (!$hasAnyValue) {
                continue;
            }

            $scenarioType = $this->getMappedValue($rowAssoc, array('senario type', 'scenario type'));
            $customerName = $this->getMappedValue($rowAssoc, array('customer name', 'customer', 'cus name', 'cus: name'));
            $customerNic = $this->getMappedValue($rowAssoc, array('cus: cnic', 'customer nic', 'cnic', 'nic'));
            $invoiceNo = $this->getMappedValue($rowAssoc, array('ref: no.', 'invoice no', 'invoice #', 'reference no', 'ref no', 'dc no'));
            $saleDateCell = $this->getMappedValue($rowAssoc, array('invoice date', 'sale date', 'date'));
            $qty = $this->parseImportFloat($this->getMappedValue($rowAssoc, array('sale qty - kgs', 'sale qty -  kgs', 'sale qty', 'qty', 'quantity')));
            $gross = $this->parseImportFloat($this->getMappedValue($rowAssoc, array('gross amount', 'amount', 'value sales excluding st')));
            $gstRate = $this->parseImportFloat($this->getMappedValue($rowAssoc, array('gst rate', 'tax percentage', 'tax rate', 'gst %', 'gst%')));
            $gst = $this->parseImportFloat($this->getMappedValue($rowAssoc, array('gst', 'tax')));
            $furtherTaxRate = $this->parseImportFloat($this->getMappedValue($rowAssoc, array('f.tax %', 'f tax %', 'f.tax rate', 'f tax rate', 'further tax %', 'further tax rate')));
            $furtherTaxAmount = $this->parseImportFloat($this->getMappedValue($rowAssoc, array('f.tax amt', 'f tax amt', 'f.tax amount', 'f tax amount', 'further tax amt', 'further tax amount')));
            $discount = $this->parseImportFloat($this->getMappedValue($rowAssoc, array('discount', 'discounts', 'addl discount')));
            $net = $this->parseImportFloat($this->getMappedValue($rowAssoc, array('net amount incl gst', 'net amount', 'net')));
            $productId = $this->getMappedValue($rowAssoc, array('product id'));
            $productBarcode = $this->getMappedValue($rowAssoc, array('product barcode', 'barcode', 'product code', 'item code'));
            $productName = $this->getMappedValue($rowAssoc, array('product name', 'item name'));

            if ($net == 0 && ($gross != 0 || $gst != 0 || $furtherTaxAmount != 0 || $discount != 0)) {
                $net = ($gross + $gst + $furtherTaxAmount - $discount);
            }
            if ($gstRate == 0 && $gross > 0 && $gst > 0) {
                $gstRate = ($gst / $gross) * 100;
            }
            if ($furtherTaxRate == 0 && $gross > 0 && $furtherTaxAmount > 0) {
                $furtherTaxRate = ($furtherTaxAmount / $gross) * 100;
            }

            // Rate is always auto-calculated from Amount / Qty for import rows.
            $rate = ($qty > 0) ? ($gross / $qty) : 0;

            if ($invoiceNo === '') {
                $invoiceNo = 'AUTO-' . $row;
            }

            if ($customerNic === '') {
                $skippedRows++;
                continue;
            }

            $normalizedInvoiceNo = trim((string) $invoiceNo);
            $groupKey = strtolower($normalizedInvoiceNo);
            if (!isset($invoiceGroups[$groupKey])) {
                $invoiceGroups[$groupKey] = array(
                    'header' => array(
                        'scenario_type' => $scenarioType,
                        'customer_name' => $customerName,
                        'customer_nic' => $customerNic,
                        'invoice_no' => $normalizedInvoiceNo,
                        'sale_date' => $this->parseImportDate($saleDateCell),
                    ),
                    'items' => array(),
                );
            } else {
                // Keep group header usable even if first row had empty/mismatched NIC/name
                if (empty($invoiceGroups[$groupKey]['header']['customer_nic']) && !empty($customerNic)) {
                    $invoiceGroups[$groupKey]['header']['customer_nic'] = $customerNic;
                }
                if (empty($invoiceGroups[$groupKey]['header']['customer_name']) && !empty($customerName)) {
                    $invoiceGroups[$groupKey]['header']['customer_name'] = $customerName;
                }
            }

            $invoiceGroups[$groupKey]['items'][] = array(
                'quantity' => $qty,
                'rate' => $rate,
                'gst_rate' => $gstRate,
                'gross_amount' => $gross,
                'gst_amount' => $gst,
                'further_tax_rate' => $furtherTaxRate,
                'further_tax_amount' => $furtherTaxAmount,
                'discount_amount' => $discount,
                'net_amount' => $net,
                'product_id' => $productId,
                'product_barcode' => $productBarcode,
                'product_name' => $productName,
            );
        }

        $createdInvoices = 0;
        $notFoundCustomers = array();

        foreach ($invoiceGroups as $group) {
            $customer = $this->Sale_model->GetCustomerByNIC($group['header']['customer_nic']);
            if (empty($customer) && !empty($group['header']['customer_name'])) {
                $customerByName = $this->Customer_model->GetCustomerByName(trim((string) $group['header']['customer_name']));
                if (!empty($customerByName)) {
                    $customer = array(
                        'CustomerId' => $customerByName->CustomerId,
                        'CustomerName' => $customerByName->CustomerName,
                    );
                }
            }
            if (empty($customer)) {
                $notFoundCustomers[] = $group['header']['customer_nic'];
                continue;
            }

            $group['header']['customer_id'] = $customer['CustomerId'];
            if (empty($group['header']['customer_name'])) {
                $group['header']['customer_name'] = $customer['CustomerName'];
            }

            $saleId = $this->Sale_model->SaveImportedSale($group['header'], $group['items']);
            if ($saleId) {
                $createdInvoices++;
            }
        }

        @unlink($filePath);

        $message = 'Excel import processed. Imported invoices: ' . $createdInvoices . '.';
        if ($skippedRows > 0) {
            $message .= ' Skipped rows without NIC: ' . $skippedRows . '.';
        }
        if (!empty($notFoundCustomers)) {
            $message .= ' Customer NIC not found (skipped): ' . implode(', ', array_unique($notFoundCustomers)) . '.';
        }
        $this->session->set_flashdata('fbr_success', $message);

        redirect('Sales');
    }
	
	public function DeleteSales($SaleId)
	{
	   
	       // Step 1: Find GeneralJournalId for this Purchase
    $this->db->select('GeneralJournalId');
    $this->db->from('pos_accounts_generaljournal');
    $this->db->where('SaleId', $SaleId);
    $journal = $this->db->get()->row();

    // Step 2: Delete related entries
    if ($journal) {
        $this->db->where('GeneralJournalId', $journal->GeneralJournalId);
        $this->db->delete('pos_accounts_generaljournal_entries');
    }

    // Step 3: Delete journal entry
    $this->db->where('SaleId', $SaleId);
    $this->db->delete('pos_accounts_generaljournal');

    // Step 4: Delete purchase details
    $this->db->where('SaleId', $SaleId);
    $this->db->delete('pos_sales_detail');

    $this->db->where('SaleId', $SaleId);
    $this->db->delete('pos_stocks_detail');
 
    // Step 6: Finally delete main purchase
    $this->db->where('SaleId', $SaleId);
    $this->db->delete('pos_sales');

		    redirect("Sales/");
		
	}
		public function addInvoice($QuotationId)
	{   

	    
	    $data['AdministrationRoles'] = $this->Employee_model->GetAdministrationRoles($this->session->userdata('EmployeeId'));
	    $data['SalesRoles'] = $this->Employee_model->GetSalesRoles($this->session->userdata('EmployeeId'));
	    $data['PurchasesRoles'] = $this->Employee_model->GetPurchasesRoles($this->session->userdata('EmployeeId'));
	    $data['RegistrationRoles'] = $this->Employee_model->GetRegistrationRoles($this->session->userdata('EmployeeId'));
	    $data['TransactionRoles'] = $this->Employee_model->GetTransactionRoles($this->session->userdata('EmployeeId'));
	    $data['ReportsRoles'] = $this->Employee_model->GetReportsRoles($this->session->userdata('EmployeeId'));
	    $data['AllReferences']=$this->Reference_model->GetAllReference();
	    $data['AllCustomers']=$this->Customer_model->GetAllCustomers();
	    $data['Sales'] = $this->Quotation_model->GetQuotation($QuotationId);
	    $data['GetAllSaleman'] = $this->Saleman_model->GetAllCategories();
	   // $data['Salemans'] =$this->AreaManagment_model->Ajax_GetAllSalemanAreawise2();
	    $data['SalesDetail'] = $this->Quotation_model->GetQuotationDetail($QuotationId);
	    $data['CustomerNotification'] = $this->Customer_model->GetNotifications();
	    $this->load->view('sale/add_invoice', $data);
	}

}
?>
