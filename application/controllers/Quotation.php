<?php error_reporting(0); defined('BASEPATH') OR exit('No direct script access allowed');
class Quotation extends CI_Controller {

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
		$this->load->model('Quotation_model');
		$this->load->model('Customer_model');
	}

	
	private function check_isvalidated()
	{
        if(!$this->session->userdata('EmployeeId'))
        { $this->session->set_userdata('url',  current_url()); redirect('Login'); }
	}

	public function AllCustomers()
	{
		$data['AllCustomers']=$this->Customer_model->GetAllCustomers();
		$this->load->view('sale/customers', $data);
	}

	public function AllReferences()
	{
		$data['AllReferences']=$this->Reference_model->GetAllReference();
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
	    $this->load->view('quotation/quotations', $data);
	}


	public function Ajax_GetAllQuotation()
	{
		$SalesRoles = $this->Employee_model->GetSalesRoles($this->session->userdata('EmployeeId'));
        $GetAllQuotation=$this->Quotation_model->Ajax_GetAllQuotation($_REQUEST);

        $ViewRecord = '<span style="color:#00a65a;" class="glyphicon glyphicon-th-large"></span>';
        $UpdateRecord = '<span style="color:#0c6aad;" class="fa fa-edit">';

            $data = array();
            foreach($GetAllQuotation['record'] as $row)
{
    $nestedData = array(); 
    $nestedData[] = $row['SaleId'];
    $nestedData[] = $row["SaleDate"];
    $nestedData[] = $row['CustomerName'];
    
    // Style the status with colored boxes
    if ($row['isQuatation'] == 0) {
        $status = '<span style="display: inline-block; padding: 2px 8px; background-color: #ff4444; color: white; border-radius: 4px; font-size: 12px;">Invoice Pending</span>';
    } else {
        $status = '<span style="display: inline-block; padding: 2px 8px; background-color: #4CAF50; color: white; border-radius: 4px; font-size: 12px;">Invoice Created</span>';
    }
    $nestedData[] = $status;
    
    $nestedData[] = $row["TotalAmount"];
    $id = $row["SaleId"];

    $nestedData[] = '<a href="'.base_url().'Quotation/ViewQuotation/'.$id.'" title="View Record">'.$ViewRecord.'</a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="'.base_url().'Quotation/EditQuotation/'.$id.'"title="Update Record"><span style="color:#0c6aad;" class="fa fa-edit"></span></a>';

    $data[] = $nestedData;
}

                $json_data = array(
			"draw" => intval( $_REQUEST['draw'] ),   // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw. 
			"recordsTotal"    => intval( $GetAllQuotation['recordsTotal'] ),  // total number of records
			"recordsFiltered" => intval( $GetAllQuotation['recordsFiltered'] ), // total number of records after searching, if there is no searching then totalFiltered = totalData
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
	
	function ViewQuotation($SaleId)
	{
	    $data['AdministrationRoles'] = $this->Employee_model->GetAdministrationRoles($this->session->userdata('EmployeeId'));
	    $data['SalesRoles'] = $this->Employee_model->GetSalesRoles($this->session->userdata('EmployeeId'));
	    $data['PurchasesRoles'] = $this->Employee_model->GetPurchasesRoles($this->session->userdata('EmployeeId'));
	    $data['RegistrationRoles'] = $this->Employee_model->GetRegistrationRoles($this->session->userdata('EmployeeId'));
	    $data['TransactionRoles'] = $this->Employee_model->GetTransactionRoles($this->session->userdata('EmployeeId'));
	    $data['ReportsRoles'] = $this->Employee_model->GetReportsRoles($this->session->userdata('EmployeeId'));
		
	    $data['Sales'] = $this->Quotation_model->GetQuotation($SaleId);
	    $data['SalesDetail'] = $this->Quotation_model->GetQuotationDetail($SaleId);
	    $data['CustomerNotification'] = $this->Customer_model->GetNotifications();
	    $this->load->view('quotation/view_quotation', $data);
	}
	
	
	public function AddQuotation()
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
	    $data['CustomerNotification'] = $this->Customer_model->GetNotifications();
	    $this->load->view('quotation/add_quotation', $data);
	}
	
	
	public function EditQuotation($QuotationId)
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
	    $data['SalesDetail'] = $this->Quotation_model->GetQuotationDetail($QuotationId);
	    $data['CustomerNotification'] = $this->Customer_model->GetNotifications();
	    $this->load->view('quotation/edit_quotation', $data);
	}
    
	
	public function SaveSale___()
	{
	    $AddSaleRecordBtn = $this->input->post('AddQuotationRecordBtn');
	    
	    if($AddSaleRecordBtn=='AddQuotationRecord')
	    {
	      if($SaleId = $this->Sale_model->SaveSaleDetail())
	      {
	       redirect(base_url()."Quotation/ViewQuotation/$SaleId");

	      }
	    }
	}
	

	public function SaveQuotation()
	{
	    $AddQuotationRecordBtn = $this->input->post('AddQuotationRecordBtn');

	    if($AddQuotationRecordBtn=='AddQuotationRecord')
	    {
		
		$QuotationId = $this->Quotation_model->SaveQuotationDetail();
	      
	    redirect(base_url()."Quotation/ViewQuotation/$QuotationId");

	    }
	}

	
	public function UpdateQuotation()
	{
	   if($this->input->post('SaleId') != '')
	   {
	    $this->Quotation_model->UpdateQuotationDetail();
		redirect(base_url()."Quotation/ViewQuotation/".$this->input->post('SaleId'));
	    }
	}	
	
  
	public function AutoCompleteProductList()
	{
            	  
	  $ProductName = $this->input->post('ProductName');
	  $query = "";
	  
	  $query = $this->db->query("SELECT P.ProductId,P.ProductName,P.SellPrice,B.BrandId,B.BrandName,PG.ProductGroupId,PG.ProductGroupName FROM pos_products AS P JOIN pos_brands AS B ON P.BrandId = B.BrandId JOIN pos_productgroup AS PG ON P.ProductGroupId = PG.ProductGroupId WHERE P.ProductName LIKE '%{$ProductName}%' LIMIT 20");
	  
          $ProductList = array();
	  
		foreach ($query->result_array() as $key) 
		{
		if($key['ProductName'] != '' || $key['ProductName'] != null )
		{ 
		//	$ProductName = '-'.$key['ProductName']; 
		//	$BrandName = '-'.$key['BrandName']; 
		//}
		
		$bn = array('id' => trim($key['ProductId']."-".$key['SellPrice']), 
		'value' => trim($key['BrandName'] . " " . $key['ProductGroupName'] . "- " . $key['ProductName']),
		'brandname' => trim($key['BrandName']),
		//'value' => trim($key['ProductName'].$key['RetailPrice'])
		);
		}
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
		$CartTable .="<tr class='txtMult'>";
		$CartTable .="<td style='margin-top:15px;line-height:25px'>".$SNo."</td>";
		$CartTable .="<td><input style='width:100px;margin-top:1px;' type='text' id='txtCode' name='ProductBarCode[]' value='".$row->ProductBarCode."' class='barcodeinput'></td>";
		$CartTable .="<td><input style='width:100px;margin-top:1px;' type='text' id='ProductId".$SNo."' name='ProductName[]' value='".$row->ProductName."'><input type='hidden' id='hdnProductId".$SNo."' class='hdnProductId' name='hdnProductName[]' value='".$row->ProductId."'></td>";
		$CartTable .="<td><input style='width:100%; margin-top:1px;' type='text' id='LocationName_".$SNo."' name='LocationName_[]'><input type='hidden' id='hdnLocationName_".$SNo."' name='LocationId[]'></td>";
		$CartTable .="<td><input style='width:100%; margin-top:1px;' type='text' id='ColourName_".$SNo."' name='ColourName[]'><input style='width:90%;' type='hidden' id='hdnColourName_".$SNo."' name='ColourId[]'></td>";
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


}
?>