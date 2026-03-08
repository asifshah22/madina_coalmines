<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Quotation_model extends CI_Model{
	
	function __construct()
	{
        parent::__construct();
	    $this->tbl_category = "pos_category";
	    $this->tbl_customer = "pos_customer";
	    $this->tbl_reference = "pos_references";
	    $this->tbl_productgroup = "pos_productgroup";
	    $this->tbl_products = "pos_products";
	    $this->tbl_sales = "pos_sales";
	    $this->tbl_sales_detail = "pos_sales_detail";
	    $this->tbl_sales_cart = "pos_sales_cart";
	    $this->tbl_stocks_detail = "pos_stocks_detail";
	    $this->tbl_stock_summary = "pos_stock_summary";
	    $this->tbl_locations = "pos_locations";
	    $this->tbl_product_colours = "pos_product_colours";
	    $this->tbl_bank_accounts = "pos_bank_accounts";
		$this->tbl_generaljournal = "pos_accounts_generaljournal";
		$this->tbl_generaljournal_entries = "pos_accounts_generaljournal_entries";
		$this->tbl_generaljournal_entries = "pos_accounts_generaljournal_entries";
		$this->tbl_quotation = "pos_quotation";
	    $this->tbl_quotation_detail = "pos_quotation_detail";
	}

	public function GetAllBankAccounts()
	{
	    $this->db->select('*')->from('pos_banks')->join('pos_bank_accounts', 'pos_banks.BankId = pos_bank_accounts.BankId');
	    $query = $this->db->get();
	    return $query->result_array();
	}

	public function GetLastPrice($ProductId)
	{
	    $this->db->select("NetAmount");
	    $this->db->from('pos_stocks_detail');
	    $this->db->where('ProductId', $ProductId);
//		$this->db->where('LocationId', $LocationId);
	    $this->db->order_by("ProductId", "DESC");
	    $this->db->limit('1');
	    $GetLastPrice = $this->db->get();
	    return $GetLastPrice->result_array();
	}


	public function TotalProducts($ProductId)
	{
		$this->db->select("PurchaseId,Quantity,StockType");
		$this->db->from('pos_stocks_detail');
		$this->db->where('pos_stocks_detail.ProductId', $ProductId);
//		$this->db->where('pos_stocks_detail.LocationId', $LocationId);
		$this->db->where('pos_stocks_detail.StockType', 1);
		$this->db->where('PurchaseId !=',0);
		$query = $this->db->get();
		return $query->result_array();
	}

	public function SoldProducts($ProductId)
	{
		$this->db->select('SaleId,Quantity,StockType');
		$this->db->from('pos_stocks_detail');
		$this->db->where('pos_stocks_detail.ProductId', $ProductId);
//		$this->db->where('pos_stocks_detail.LocationId', $LocationId);
		$this->db->where('pos_stocks_detail.StockType', 3);
		$this->db->where('SaleId !=',0);
		$query = $this->db->get();
		return $query->result_array();
	}
	
	function GetAllSales()
	{
	    $this->db->select('*');
	    $this->db->from($this->tbl_sales);
	    /*$this->db->join($this->tbl_product, $this->tbl_product.'.ProductId = '.$this->tbl_sales.'.ProductId');
	    $this->db->join($this->tbl_customer, $this->tbl_customer.'.StackholderId = '.$this->tbl_sales.'.StackholderId');*/
	    $query = $this->db->get();
	    return $query->result_array();	
	}

    public function Ajax_GetAllQuotation($requestData)
    {
       	$columns = array( 
            0 => 'SaleId',
            1 => 'SaleNo',
            2 => 'SaleDate',
            3 => 'TotalAmount',
	    	4 => 'CustomerId',
            5 => 'CustomerName',
        );
            $sql = "SELECT pos_quotation.*,pos_customer.*,pos_sales.isQuatation";
            $sql.=" FROM pos_quotation";
           $sql.=" INNER JOIN pos_customer ON pos_customer.CustomerId = pos_quotation.CustomerId ";
            $sql.=" Left JOIN pos_sales ON pos_sales.isQuatation = pos_quotation.SaleId ";

            $query= $this->db->query($sql); 
            $totalData = $query->num_rows();
            $totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.
//            $sql.=" WHERE 1=1 ";
                if( !empty($requestData['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter
		    $sql.=" AND (SaleId LIKE '".$requestData['search']['value']."%' )";
		    
                }
                if($this->session->userdata('EmployeeType')==3){
                    $sql.=" and pos_quotation.AddedBy = ".$this->session->userdata    ('EmployeeId');
                }

                $query=$this->db->query( $sql) ;
                $totalFiltered = $query->num_rows(); // when there is a search parameter then we have to modify total number filtered rows as per search result. 
				$sql.=" ORDER BY ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']."  LIMIT ".$requestData['start']." ,".$requestData['length']."   ";
				
// 			echo $sql;
                $query=$this->db->query($sql);  
                
                $array['record'] = $query->result_array();
                $array['recordsFiltered'] = $totalFiltered;
                $array['recordsTotal'] = $totalData;
                return $array;
        }

	function GetQuotation($SaleId)
	{
	    $this->db->select('*,pos_quotation.AddedOn,pos_quotation.Address');
	    $this->db->from($this->tbl_quotation);
	   	$this->db->join($this->tbl_customer, $this->tbl_customer.'.CustomerId = '.$this->tbl_quotation.'.CustomerId', 'left');
	   	$this->db->join($this->tbl_reference, $this->tbl_reference.'.ReferenceId = '.$this->tbl_quotation.'.ReferenceId', 'left');
	    $this->db->where('pos_quotation.SaleId',$SaleId);
	    $query = $this->db->get();
	    return $query->row();	
	}

	function GetSalesByCustomer($CustomerId)
	{
	    $this->db->select('*,pos_sales.AddedOn');
	    $this->db->from($this->tbl_sales);
	   	$this->db->join($this->tbl_customer, $this->tbl_customer.'.CustomerId = '.$this->tbl_sales.'.CustomerId', 'left');
	   	$this->db->join($this->tbl_bank_accounts, $this->tbl_bank_accounts.'.AccountId = '.$this->tbl_sales.'.AccountId', 'left');
	   	$this->db->join($this->tbl_reference, $this->tbl_reference.'.ReferenceId = '.$this->tbl_sales.'.ReferenceId', 'left');
	    $this->db->where('pos_sales.CustomerId',$CustomerId);
	    $query = $this->db->get();
	    return $query->result_array();	
	}
	
	function GetLastSales($InvoiceNo, $CustomerId)
	{
	    $this->db->select('pos_sales.AddedOn');
	    $this->db->from($this->tbl_sales);
	    $this->db->where(['SaleId' => $InvoiceNo,'CustomerId' => $CustomerId]);
	    $query = $this->db->get();
	    $data = $query->row();	
		
		$currentDate = date('Y-m-d H:i:s');
		$checkLastSale = (array) $data;
		// check last invoice
		$this->db->select('pos_sales.AddedOn');
	    $this->db->from($this->tbl_sales);
	    $this->db->where(['CustomerId' => $CustomerId]);
		$this->db->where('AddedOn <', $checkLastSale['AddedOn']);
	    $inv = $this->db->get();
	    return $inv->row();	
	}
	
	
	function GetQuotationDetail($SaleId)
	{
	     $this->db->select('*, '.$this->tbl_quotation_detail.'.ProductBarCode');

	    $this->db->from($this->tbl_quotation);  
	    $this->db->join($this->tbl_quotation_detail, $this->tbl_quotation_detail.'.SaleId = '.$this->tbl_quotation.'.SaleId');
	    $this->db->join($this->tbl_products, $this->tbl_products.'.ProductId = '.$this->tbl_quotation_detail.'.ProductId');
	     $this->db->join('pos_productgroup', $this->tbl_products.'.ProductGroupId = pos_productgroup.ProductGroupId', 'left');
	    $this->db->join($this->tbl_locations, $this->tbl_locations.'.LocationId = '.$this->tbl_quotation_detail.'.LocationId','left');
	    $this->db->join($this->tbl_product_colours, $this->tbl_product_colours.'.ColourId = '.$this->tbl_quotation_detail.'.ColourId','left');
		$this->db->where('pos_quotation_detail.SaleId',$SaleId);
	    $query = $this->db->get();
	    return $query->result_array();
	}
	
		
	
	
	public function SaveQuotationDetail()
	{
	    $CustomerVal =$this->input->post('CustomerId');
		$IdArr = explode("-", $CustomerVal);
		$CustomerId = $IdArr[0];

	    $TotalAmount = array_sum($this->input->post('NetAmount'));
	
	    $Sale = array(
	    'CustomerId' => $CustomerId,
	    'ReferenceId' => $this->input->post('ReferenceId'),
	    'SaleDate' => date('Y-m-d H:i:s', strtotime($this->input->post('SaleDate'))),
	    'TotalAmount' => $TotalAmount,
	    'SaleNote'    => $this->input->post('SaleNote'),
		'Address'     => $this->input->post('Address'),
	    'WalkinCustomer'    => $this->input->post('CustomerName'),
	    'MobileNumber'    => $this->input->post('CellNo'),
	    'AddedOn' => date('Y-m-d H:i:s'),
	    'AddedBy' => $this->session->userdata('EmployeeId'),
	    );

	    $this->db->insert('pos_quotation', $Sale);
	    $SaleId = intval($this->db->insert_id());

	    $ProductId = $this->input->post('hdnProductName');    
	
	    foreach($ProductId as $key => $value) 
	    {
			$SalesDetail = array(
			'SaleId' => $SaleId,
			'ProductBarCode'  => $this->input->post('ProductBarCode')[$key],
			'ProductId'  => $this->input->post('hdnProductName')[$key],
			'LocationId'  => $this->input->post('LocationId')[$key],
			'ColourId'  => $this->input->post('ColourId')[$key],
			'Quantity'    => $this->input->post('Quantity')[$key],
			'Rate'    => $this->input->post('Rate')[$key],
			'DiscountAmount'   => $this->input->post('DiscountAmount')[$key],
			'Amount'   => $this->input->post('Amount')[$key],
			'TaxPercentage'   => $this->input->post('TaxPercentage')[$key],
			'TaxAmount'   => $this->input->post('TaxAmount')[$key],
			'NetAmount'   => $this->input->post('NetAmount')[$key],
			'Notes'   => $this->input->post('Notes')[$key],
			);
		
	        $this->db->insert('pos_quotation_detail', $SalesDetail);
	    }
	    	    
		return $SaleId;
	}
	

	public function CheckStockSummary($LocationId,$ProductId,$ColourId)
	{
		$this->db->select('*')->from($this->tbl_stock_summary);
		$this->db->where('LocationId', $LocationId);
		$this->db->where('ProductId', $ProductId);
		$this->db->where('ColourId', $ColourId);
		$query = $this->db->get();
		return $query->row();
	}

	public function AddStockSummary($LocationId,$ProductId,$ColourId,$Quantity)
	{
		$StockSummary = array(
			'SummaryId' => '',
			'ProductId' => $ProductId,
			'LocationId' => $LocationId,
			'ColourId' => $ColourId,
			'Quantity' => $Quantity,
			'AddedOn' => date('Y-m-d H:i:s'),
	    	'AddedBy' => $this->session->userdata('EmployeeId'),
		);
		$this->db->insert('pos_stock_summary', $StockSummary);
		return true;
	}

	public function UpdateStockSummary($SummaryId,$LocationId,$ProductId,$ColourId,$NewQuantity)
	{
		$UpdateStockSummary = array(
			'SummaryId' => $SummaryId,
			'ProductId' => $ProductId,
			'LocationId' => $LocationId,
			'ColourId' => $ColourId,
			'Quantity' => $NewQuantity,
			'AddedOn' => date('Y-m-d H:i:s'),
	    	'AddedBy' => $this->session->userdata('EmployeeId'),
		);
		$this->db->set($UpdateStockSummary);
		$this->db->where('SummaryId',$SummaryId);
		$this->db->update('pos_stock_summary');
		return $SummaryId;
	}

	
	public function UpdateQuotationDetail()
	{
	    $SaleId = $this->input->post('SaleId');
	    $DiscountAmount = array_sum($this->input->post('DiscountAmount'));
	    $NetAmount = array_sum($this->input->post('NetAmount'));
	
		    
	    $Sale = array(
			'CustomerId' => $this->input->post('CustomerId'),
			'ReferenceId' => $this->input->post('ReferenceId'),
		    'SaleDate' => date('Y-m-d h:i:s', strtotime($this->input->post('SaleDate'))), 
		    'TotalAmount' => $NetAmount,
		    'SaleNote'    => $this->input->post('SaleNote'),
			'Address'    => $this->input->post('Address'),
		   	'WalkinCustomer'    => $this->input->post('CustomerName'),
	    	'MobileNumber'    => $this->input->post('CellNo'),
		    'AddedOn' => date('Y-m-d H:i:s'),
		    'AddedBy' => $this->session->userdata('EmployeeId'),
	    );
	    
	    
	    // Update Sale Record
	    $this->db->where('pos_quotation.SaleId', $SaleId);
	    $this->db->update('pos_quotation', $Sale);
	
	    
	    // Remove Stock Detail Record Before Inserting New Record
	    $this->db->where('pos_quotation_detail.SaleId', $SaleId);
	    $this->db->delete('pos_quotation_detail');
	    
	    $ProductId = $this->input->post('ProductId');
	    
	    foreach($ProductId as $key => $value) 
	    {
		$CustomerVal =$this->input->post('CustomerId');
		
		$SalesDetail = array(
		'SaleId' => $SaleId,
		'ProductId'  => $this->input->post('ProductId')[$key],
		'LocationId'  => $this->input->post('LocationId')[$key],
		'ColourId'  => $this->input->post('ColourId')[$key],
		'Quantity'    => $this->input->post('Quantity')[$key],
		'Rate'    => $this->input->post('Rate')[$key],
		'DiscountAmount'  => $this->input->post('DiscountAmount')[$key],
		'Amount'   => $this->input->post('Amount')[$key],
		'TaxPercentage'   => $this->input->post('TaxPercentage')[$key],
		'TaxAmount'   => $this->input->post('TaxAmount')[$key],
		'NetAmount'   => $this->input->post('NetAmount')[$key],   
			'Notes'   => $this->input->post('Notes')[$key],
		);
		
	        $this->db->insert('pos_quotation_detail', $SalesDetail);
	    }
	    
	 return $SaleId;
	}


	public function BRVReferenceNo()
	{
      $this->db->select("Reference");
      $this->db->from('pos_accounts_generaljournal');
      $this->db->where('VoucherType', 4);
      $this->db->order_by('GeneralJournalId', 'DESC');
      $this->db->limit('1');
      $query = $this->db->get();
      if ($query->num_rows() > 0)
      {
      $row = $query->row();
      $RNo = $row->Reference;

      $iSplit = explode("BRV", $RNo);
      $data['Reference'] = $iSplit[1];

      $ReferenceNo = $data['Reference'] + 1;
      $Prefix = 'BRV';
      $NewReferenceNo = $Prefix.''.$ReferenceNo;
      return $NewReferenceNo;
      }
      else
      { 
      $Prefix = 'BRV';
      $ReferenceNo = 1;
      $NewReferenceNo = $Prefix.''.$ReferenceNo;
      return $NewReferenceNo;
      } 
     }
  


  public function CRVReferenceNo()
  {
      $this->db->select("Reference");
      $this->db->from('pos_accounts_generaljournal');
      $this->db->where('VoucherType', 3);
      $this->db->order_by('GeneralJournalId', 'DESC');
      $this->db->limit('1');
      $query = $this->db->get();
      if ($query->num_rows() > 0)
      {
      $row = $query->row();
      $RNo = $row->Reference;

      $iSplit = explode("CRV", $RNo);
      $data['Reference'] = $iSplit[1];

      $ReferenceNo = $data['Reference'] + 1;
      $Prefix = 'CRV';
      $NewReferenceNo = $Prefix.''.$ReferenceNo;
      return $NewReferenceNo;
      }
      else
      { 
      $Prefix = 'CRV';
      $ReferenceNo = 1;
      $NewReferenceNo = $Prefix.''.$ReferenceNo;
      return $NewReferenceNo;
      } 
  }

  public function JVReferenceNo()
  {
      $this->db->select("Reference");
      $this->db->from('pos_accounts_generaljournal');
      $this->db->where('VoucherType', 5);
      $this->db->order_by('GeneralJournalId', 'DESC');
      $this->db->limit('1');
      $query = $this->db->get();
      if ($query->num_rows() > 0)
      {
      $row = $query->row();
      $RNo = $row->Reference;

      $iSplit = explode("JV", $RNo);
      $data['Reference'] = $iSplit[1];

      $ReferenceNo = $data['Reference'] + 1;
      $Prefix = 'JV';
      $NewReferenceNo = $Prefix.''.$ReferenceNo;
      return $NewReferenceNo;
      }
      else
      { 
      $Prefix = 'JV';
      $ReferenceNo = 1;
      $NewReferenceNo = $Prefix.''.$ReferenceNo;
      return $NewReferenceNo;
      } 
  }


  public function DebitRecord($CoAId)
  {
  	$this->db->select_sum('Debit')->from('pos_accounts_generaljournal_entries');
  	$this->db->where('ChartOfAccountId', $CoAId);
  	$result = $this->db->get();
  	return $result->row();
  }


    public function CreditRecord($CoAId)
    {
  	$this->db->select_sum('Credit')->from('pos_accounts_generaljournal_entries');
  	$this->db->where('ChartOfAccountId', $CoAId);
  	$result = $this->db->get();
  	return $result->row();
    }
    
    
    function AddProductInCart($ProductId)
    {
	$this->db->select('*');
	$this->db->from($this->tbl_products);
	$this->db->where('pos_products.ProductId',$ProductId);
	$query = $this->db->get();

	foreach ($query->result() as $row)
	{
	  $this->db->set('ProductId', $row->ProductId);
	  $this->db->set('ProductBarCode', $row->ProductBarCode);
	  $this->db->set('Quantity', '0');
	  $this->db->set('Rate', $row->SellPrice);
	  $this->db->set('Amount', $row->SellPrice);
	  //$this->db->set('TradePrice', $row->TradePrice);
	  $this->db->set('AddedBy', $this->session->userdata('EmployeeId'));
	  $this->db->insert('pos_sales_cart');
	}
	
	$this->db->select('*');
	$this->db->from($this->tbl_sales_cart);
	$this->db->where('pos_sales_cart.ProductId',$ProductId);
	$this->db->order_by('SaleCartId', 'DESC');
        $this->db->limit('1');
        $query = $this->db->get();
	
	if ($query->num_rows() > 0)
        {
	    $row = $query->row();
	    return $row->SaleCartId;
	}	

	//return true;
    }
    
    
    function AddBarcodeItemInCart($Barcode)
    {
	$this->db->select('*');
	$this->db->from($this->tbl_products);
	$this->db->where('pos_products.ProductBarCode',$Barcode);
	$query = $this->db->get();

	foreach ($query->result() as $row)
	{
	  $this->db->set('ProductId', $row->ProductId);
	  $this->db->set('ProductBarCode', $Barcode);
	  $this->db->set('Quantity', '0');
	  $this->db->set('Rate', $row->SellPrice);
	  $this->db->set('Amount', $row->SellPrice);
	  //$this->db->set('TradePrice', $row->TradePrice);
	  $this->db->set('AddedBy', $this->session->userdata('EmployeeId'));
	  $this->db->insert('pos_sales_cart');
	}
	return true;
    }
    
    
    function AddBarcodeItemInCart_($ProductId)
    {
	$this->db->select('*');
	$this->db->from($this->tbl_products);
	$this->db->where('pos_products.ProductBarCode',$Barcode);
	$query = $this->db->get();

	foreach ($query->result() as $row)
	{
	  $this->db->set('ProductId', $row->ProductId);
	  $this->db->set('ProductBarCode', $Barcode);
	  $this->db->set('Quantity', '1');
	  $this->db->set('Rate', $row->SellPrice);
	  $this->db->set('Amount', $row->SellPrice);
	  //$this->db->set('TradePrice', $row->TradePrice);
	  $this->db->set('AddedBy', $this->session->userdata('EmployeeId'));
	  $this->db->insert('pos_sales_cart');
	}
	return true;
    }
    
    
    function GetProductByBarcode()
    {
      $this->db->select('*');
      $this->db->from($this->tbl_sales_cart);
      $this->db->where('pos_sales_cart.AddedBy',$this->session->userdata('EmployeeId'));
      $this->db->join($this->tbl_products, $this->tbl_products.'.ProductId = '.$this->tbl_sales_cart.'.ProductId');
       $this->db->order_by("pos_sales_cart.SaleCartId", "DESC");
    //  $this->db->join($this->tbl_productgroup, $this->tbl_productgroup.'.ProductGroupId = '.$this->tbl_ims_salesorder_cart.'.ProductGroupId');
      $query = $this->db->get();
      return $query->result();
    }
    
    public function UpdateCartVal($SaleCartId,$Quantity,$Rate,$DiscountAmount)
    {
	
	$Amount = $Quantity * $Rate;
	
	$Data = array(
	'Quantity' => $Quantity,
	'Rate' => $Rate,
	'Amount' => $Amount,
	'DiscountAmount' => $DiscountAmount
	);
	
	$this->db->where('SaleCartId', $SaleCartId);
	$this->db->update('pos_sales_cart', $Data);

    }

public function UpdateSaleOrderDetail($ProductId, $Quantity, $SaleOrderDetailId, $Weight=0, $OldQuantity=null)
	{ 
// 	print_r($SaleOrderDetailId);
// 	die();
    	$NewSupplyDone = 0;
    	$NewSupplyWeight = 0;
		$this->db->select('SupplyDone, SupplyWeight');
		$this->db->from($this->tbl_quotation_detail);
		$this->db->where('pos_quotation_detail.SaleDetailId', $SaleOrderDetailId);
// 		$this->db->where('pos_quotation_detail.SaleId', $SaleOrderId);
// 		$this->db->where('pos_quotation_detail.ProductId', $ProductId);
		$this->db->limit('1');
		$query = $this->db->get();
		$data = $query->result();
		$Result = (array) $data;
// print_r($Result[0]);
			
			// Set supply done.
			if($OldQuantity != null){
				$NewSupplyDone = $Result[0]->SupplyDone - $OldQuantity;
				$NewSupplyDone = $NewSupplyDone + $Quantity;
					$NewSupplyWeight = $Result[0]->SupplyWeight+ $Weight;
				
			}else{
				if($Quantity != $OldQuantity){
					$NewSupplyDone = $Result[0]->SupplyDone + $Quantity;
					$NewSupplyWeight = $Result[0]->SupplyWeight+ $Weight;
				}elseif($OldQuantity == null){
					$NewSupplyDone = $Result[0]->SupplyDone + $Quantity;
					$NewSupplyWeight = $Result[0]->SupplyWeight+ $Weight;
				}else{
					$NewSupplyDone = $Result[0]->SupplyDone;
					$NewSupplyWeight = $Result[0]->SupplyWeight;
					
				}
			}
			
// 			print_r($NewSupplyWeight); die();
		$SalesOrderDetail = array(
		'SupplyDone'  => $NewSupplyDone,
		'SupplyWeight' => $NewSupplyWeight
		);
		
		$this->db->where('pos_quotation_detail.SaleDetailId', $SaleOrderDetailId);
		$success = $this->db->update('pos_quotation_detail', $SalesOrderDetail);
	    
	 return $success;
	}
}
?>