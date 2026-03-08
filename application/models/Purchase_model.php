<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Purchase_model extends CI_Model{
	
	function __construct()
	{
        parent::__construct();
        $this->tbl_bank_account = "pos_bank_accounts";	
        $this->tbl_vendor = "pos_vendor";
	$this->tbl_category = "pos_category";
        $this->tbl_productgroup = "pos_productgroup";
        $this->tbl_products = "pos_products";
        $this->tbl_purchase = "pos_purchase";
        $this->tbl_purchase_detail = "pos_purchase_details";
	 $this->tbl_purchase_cart = "pos_purchase_cart";
        $this->tbl_stocks_detail = "pos_stocks_detail";
        $this->tbl_stock_summary = "pos_stock_summary";
	    $this->tbl_locations = "pos_locations";
	    $this->tbl_product_colours = "pos_product_colours";
	    $this->tbl_accounts_transaction = "pos_accounts_transaction";
	    //$this->output->enable_profiler(true);
   	}
	 
// stock type ids,, 1 for purchase, 2 is purchase return, 3 is sale, 4 is sale return

	public function GetLastPrice($ProductId, $LocationId)
	{
		$this->db->select("Rate");
		$this->db->from('pos_stocks_detail');
		$this->db->where('ProductId', $ProductId);
		$this->db->where('LocationId', $LocationId);
		$this->db->where('pos_stocks_detail.StockType', 1);
		$this->db->order_by("ProductId", "DESC");
		$this->db->limit('1');
		$GetLastPrice = $this->db->get();
		return $GetLastPrice->row();
	}

	
	public function TotalProducts($ProductId,$LocationId)
	{
		$this->db->select("PurchaseId,SaleReturnId,Quantity,StockType");
		$this->db->from('pos_stocks_detail');
//		$this->db->join('pos_stocks_detail', 'pos_products.ProductId = pos_stocks_detail.ProductId', 'left');
		$this->db->where('pos_stocks_detail.ProductId', $ProductId);
		$this->db->where('pos_stocks_detail.LocationId', $LocationId);
		$this->db->where('PurchaseId !=',0);
		$this->db->where('pos_stocks_detail.StockType', 1);
		$query = $this->db->get();
		return $query->result_array();
	}

	public function SoldProducts($ProductId,$LocationId)
	{
		$this->db->select('SaleId, Quantity');
		$this->db->from('pos_stocks_detail');
		$this->db->where('pos_stocks_detail.ProductId', $ProductId);
		$this->db->where('pos_stocks_detail.LocationId', $LocationId);
		$this->db->where('pos_stocks_detail.StockType', 3);
		$query = $this->db->get();
		return $query->result_array();
	}

    public function Ajax_GetAllPurchase($requestData)
    {
               $columns = array( 
                    0 => 'PurchaseId',
                    1 => 'PurchaseType',
                    2 => 'PurchaseDate',
                    3 => 'TotalAmount',
        			4 => 'VendorId',
        			5 => 'VendorName',
                );
                $sql = "SELECT *";
                $sql.=" FROM pos_purchase";
				$sql.=" INNER JOIN pos_vendor ON pos_vendor.VendorId = pos_purchase.VendorId ";

                $query= $this->db->query($sql); 
                $totalData = $query->num_rows();
                $totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.
                $sql.=" WHERE 1=1 ";
                if( !empty($requestData['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter
                       $sql.=" AND (PurchaseId LIKE '".$requestData['search']['value']."%' ";
                       $sql.=" OR PurchaseType LIKE '".$requestData['search']['value']."%' ";
                       $sql.=" OR VendorName LIKE '".$requestData['search']['value']."%' ";
                       $sql.=" OR  TotalAmount LIKE '".$requestData['search']['value']."%' )";
                }
                $query=$this->db->query( $sql) ;
                $totalFiltered = $query->num_rows(); // when there is a search parameter then we have to modify total number filtered rows as per search result. 
                $sql.=" ORDER BY VendorName ". "  LIMIT ".$requestData['start']." ,".$requestData['length']."   ";
                $query=$this->db->query($sql);
                
                $array['record'] = $query->result_array();
                $array['recordsFiltered'] = $totalFiltered;
                $array['recordsTotal'] = $totalData;
                return $array;
        }

	function GetAllPurchase()
	{

	    $this->db->select('PurchaseId, PurchaseInvoice, TotalAmount, PurchaseNo, PurchaseDate, AccountName');
	    $this->db->from($this->tbl_purchase);
    	    $this->db->join($this->tbl_accounts, $this->tbl_accounts.'.AccountId = '.$this->tbl_purchase.'.AccountId','left');
	    $this->db->order_by("pos_purchase.PurchaseId", "desc");
	    $query = $this->db->get();
	    return $query->result_array();	
	}
	

	function GetAllVendors()
	{
	    $this->db->select('*');
	    $this->db->from('pos_vendor');
	    $GetAllVendors = $this->db->get();
	    return ($GetAllVendors->result_array());
	}
	
	
	function GetPurchase($PurchaseId)
	{
	    $this->db->select('*');
	    $this->db->from($this->tbl_purchase);
	    $this->db->join($this->tbl_vendor, $this->tbl_vendor.'.VendorId = '.$this->tbl_purchase.'.VendorId', 'left');
	    $this->db->join($this->tbl_bank_account, $this->tbl_bank_account.'.AccountId = '.$this->tbl_purchase.'.AccountId', 'left');
	    $this->db->where('pos_purchase.PurchaseId',$PurchaseId);
	    $query = $this->db->get();
	    return $query->row();	
	}
	
	
	function GetPurchaseDetail($PurchaseId)
	{
	    $this->db->select('*');
	    $this->db->from($this->tbl_purchase);
	    $this->db->join($this->tbl_purchase_detail, $this->tbl_purchase_detail.'.PurchaseId = '.$this->tbl_purchase.'.PurchaseId');
	    $this->db->join($this->tbl_products, $this->tbl_products.'.ProductId = '.$this->tbl_purchase_detail.'.ProductId', 'left');
	    $this->db->join($this->tbl_locations, $this->tbl_locations.'.LocationId = '.$this->tbl_purchase_detail.'.LocationId','left');
	    $this->db->join($this->tbl_product_colours, $this->tbl_product_colours.'.ColourId = '.$this->tbl_purchase_detail.'.ColourId','left');
	   // $this->db->join($this->tbl_accounts_transaction, $this->tbl_accounts_transaction.'.PurchaseId = '.$this->tbl_purchase.'.PurchaseId', 'left');
	    $this->db->where('pos_purchase_details.PurchaseId',$PurchaseId);
	    $query = $this->db->get();
	    return $query->result_array();
	}
	
	
	public function SavePurchaseDetail()
	{
	    $VendorId = "";
	    $BankId = "";
	    $BankChartOfAccountId = "";
	    $TotalAmount = array_sum($this->input->post('NetAmount'));
	    if($this->input->post('VendorId') != "0"){
		    $VendorId =$this->input->post('VendorId');
		    $IdArr = explode("-", $VendorId);
		    $VendorId = $IdArr[0];
		    $VendorIdChartOfAccountId = $IdArr[1];
		}

		if($this->input->post('BankAccountId') != "0"){
		    $BankId =$this->input->post('BankAccountId');
@		    $IdArr = explode("-", $BankId);
@		    $BankId = $IdArr[0];
@		    $BankChartOfAccountId = $IdArr[1];
		}
	    
	    $data = array(
	    'AccountId' => $this->input->post('BankAccountId'),
	    'VendorId' => $VendorId,
	    'PurchaseType' => $this->input->post('PurchaseType'),
	    'PurchaseStatus' => $this->input->post('PurchaseStatus'),
	    'PurchaseDate' => date('Y-m-d', strtotime($this->input->post('PurchaseDate'))),
//	    'PurchaseNo' => $PurchaseNo,
	    'PurchaseInvoice' => $this->input->post('PurchaseInvoice'),
	    'TotalAmount' => $TotalAmount,
	    'PurchaseNote' => $this->input->post('PurchaseNote'),
	    'AddedOn' => date('Y-m-d H:i:s'),
	    'AddedBy' => $this->session->userdata('EmployeeId'),
	    );

	    $this->db->insert('pos_purchase', $data);
	    $PurchaseId = intval($this->db->insert_id());
	   
	    $ProductId =  array_filter($this->input->post('ProductId'));
	    
	    foreach($ProductId as $key=>$value) 
	    {
	      $PurchasesDetail = array(
	      'PurchaseId' => $PurchaseId,
	      'ProductBarCode'  => $this->input->post('ProductBarCode')[$key],
	      'ProductId' => $this->input->post('ProductId')[$key],
	      'LocationId' => $this->input->post('LocationId')[$key] != '' ? $this->input->post('LocationId')[$key] : '0',
	      //'ColourId' => $this->input->post('ColourId')[$key] != '' ? $this->input->post('ColourId')[$key] : '0',    
	      'Quantity' => $this->input->post('Quantity')[$key],
	      'Rate' => $this->input->post('Rate')[$key],
	      'Amount' => $this->input->post('Amount')[$key],
	      'DiscountAmount' => $this->input->post('DiscountAmount')[$key],
	      'RegularDiscount' => $this->input->post('RegularDiscount')[$key],
	      'SaleDiscount' => $this->input->post('SaleDiscount')[$key],
	      'NetAmount' => $this->input->post('NetAmount')[$key],
	      'Comments' => $this->input->post('Comments')[$key],
	      'Discount' => $this->input->post('Discount')[$key],
	      'ODiscount' => $this->input->post('ODiscount')[$key],
	      'HoldingAmount' => $this->input->post('HoldingAmount')[$key],
	      );
		
		$this->db->insert('pos_purchase_details', $PurchasesDetail);
	    }
	    
	    
	    // Stock Type 1 shows Purchase
	     // Following sale detail enters into stock details table
	    foreach($ProductId as $key=>$value) 
	    {    
	      $PurchasedStock = array( 
	      'VendorId' => $VendorId,
	      'PurchaseId' => $PurchaseId,
	      'ProductId' => $this->input->post('ProductId')[$key],
	      'LocationId' => $this->input->post('LocationId')[$key] != '' ? $this->input->post('LocationId')[$key] : '0',
	      //'ColourId' => $this->input->post('ColourId')[$key] != '' ? $this->input->post('ColourId')[$key] : '0',
	      'Rate' => $this->input->post('Rate')[$key],
	      'Quantity' => $this->input->post('Quantity')[$key],
	      'DiscountAmount' => $this->input->post('DiscountAmount')[$key],
	      'Amount'=> $this->input->post('Amount')[$key],
	      'NetAmount' => $this->input->post('NetAmount')[$key],
	      'StockType' => 1,
	      'InOutDate' => date('Y-m-d', strtotime($this->input->post('PurchaseDate'))),
	      'Comments' => $this->input->post('Comments')[$key], 
	      'AddedBy' => $this->session->userdata('EmployeeId'),
	      'AddedOn' => date('Y-m-d H:i:s'),
              );
	      
              // Insert into Stocks Detail table
	      $this->db->insert('pos_stocks_detail', $PurchasedStock);
            }
	    

            // Gets Cash Balance chart of account from coa table
/*	    $this->db->select('ChartOfAccountId');
	    $this->db->from('pos_accounts_chartofaccount');
	    $this->db->where('ChartOfAccountCategoryId', 1);
	    $this->db->where('ChartOfAccountControlId', 1);
	    $query = $this->db->get()->row();
	    $CashChartOfAccountId = $query->ChartOfAccountId;*/
	    $CashChartOfAccountId = 1;
	    
	    // Gets Sale Account Customer chart of account from coa table
/*	    $this->db->select('ChartOfAccountId');
	    $this->db->from('pos_accounts_chartofaccount');
	    $this->db->where('ChartOfAccountCategoryId', 1);
	    $this->db->where('ChartOfAccountControlId', 5);
	    $query = $this->db->get()->row();
	    $PurchaseChartOfAccountId = $query->ChartOfAccountId;*/
	    $PurchaseChartOfAccountId = 2;

	    $VoucherType = 0;
	    $ReferenceNo = 0;
	    $DebitChartOfAccountId = 0;
	    if($this->input->post('PurchaseType') == "1")
	    {
		$DebitChartOfAccountId = $PurchaseChartOfAccountId;
		$VoucherType = 1;
	 	$ReferenceNo = $this->CPVReferenceNo();
	    }
	    
	    if($this->input->post('PurchaseType') == "2")
	    {
		$DebitChartOfAccountId = $PurchaseChartOfAccountId;
		$VoucherType = 5;
		$ReferenceNo = $this->JVReferenceNo();
	    }

	    if($this->input->post('PurchaseType') == "3")
	    {
		$DebitChartOfAccountId = $PurchaseChartOfAccountId;
		$VoucherType = 2;
		$ReferenceNo = $this->BPVReferenceNo();
	    }

	    $DebitAmount = array_sum($this->input->post('NetAmount'));
	    $CreditAmount = array_sum($this->input->post('NetAmount'));

	    // PurchaseType = 1 is On Cash and PurchaseType = 2 is On Credit
	    // Voucher Type 1 = CPV, Voucher Type 2 = BPV,  Voucher Type 3 = CRV, Voucher Type 4 = BRV, Voucher Type 5 = JV, 	    
	    
	    // EntryType = 1 shows auto voucher created
	    $Transactions = array(
	    'PurchaseId' => $PurchaseId,
	    'EntryType' => 1,
	    'VoucherType' => $VoucherType,
	    'Reference' => $ReferenceNo,
	    'TransactionDate' => date('Y-m-d', strtotime($this->input->post('PurchaseDate'))),
	    'TotalDebit' => $DebitAmount,
	    'TotalCredit' => $CreditAmount,
	    'AddedOn' => date('Y-m-d H:i:s'),
	    'AddedBy' => $this->session->userdata('EmployeeId'),
	    );

	    $this->db->insert('pos_accounts_generaljournal', $Transactions);
	    $GeneralJournalId = intval($this->db->insert_id());
	    	    

	    foreach($ProductId as $key=>$value) 
	    {	
		
		// Following script is entering debit side entry
		$DebitTransaction = array(
		'GeneralJournalId' => $GeneralJournalId,
		'ChartOfAccountId' => 1125,
		'VendorId' => $VendorId,
		'Debit' => $this->input->post('RegularDiscount')[$key],
		'Credit' => '0.00',
		'Detail' => $this->input->post('ProductName')[$key] . " " . "Quantity of: " . " " .$this->input->post('Quantity')[$key] . "  Rate: " . $this->input->post('Rate')[$key],
		);

		$this->db->insert('pos_accounts_generaljournal_entries', $DebitTransaction);
		
			// Following script is entering credit side entry
		$CreditTransaction = array(
		'GeneralJournalId' => $GeneralJournalId,
		'ChartOfAccountId' => 2,
		'VendorId' => $VendorId,
		'Debit'   => '0.00',
		'Credit' => $this->input->post('RegularDiscount')[$key],
		'Detail' => $this->input->post('ProductName')[$key] . " " . "Quantity of: " . " " .$this->input->post('Quantity')[$key],
		);

	        $this->db->insert('pos_accounts_generaljournal_entries', $CreditTransaction);
		
		// Following script is entering debit side entry
		$DebitTransaction = array(
		'GeneralJournalId' => $GeneralJournalId,
		'ChartOfAccountId' => $DebitChartOfAccountId,
		'VendorId' => $VendorId,
		'Debit' => $this->input->post('NetAmount')[$key],
		'Credit' => '0.00',
		'Detail' => $this->input->post('ProductName')[$key] . " " . "Quantity of: " . " " .$this->input->post('Quantity')[$key] . "  Rate: " . $this->input->post('Rate')[$key],
		);

		$this->db->insert('pos_accounts_generaljournal_entries', $DebitTransaction);

	
		// If Purchase Type is On Credit, VendorId Chart of Account will be credit else Cash Balance Chart of Account will be credit
		if($this->input->post('PurchaseType') == "1")
		{
		   $CreditChartOfAccountId = $CashChartOfAccountId;
		}
		
		if($this->input->post('PurchaseType') == "2")
		{ 
		   $CreditChartOfAccountId = $VendorIdChartOfAccountId;
        }

		if($this->input->post('PurchaseType') == "3")
		{ 
		   $CreditChartOfAccountId = $BankChartOfAccountId;
        }
		// end of code

		// Following script is entering credit side entry
		$CreditTransaction = array(
		'GeneralJournalId' => $GeneralJournalId,
		'ChartOfAccountId' => $CreditChartOfAccountId,
		'VendorId' => $VendorId,
		'Debit'   => '0.00',
		'Credit' => $this->input->post('NetAmount')[$key],
		'Detail' => $this->input->post('ProductName')[$key] . " " . "Quantity of: " . " " .$this->input->post('Quantity')[$key],
		);

	        $this->db->insert('pos_accounts_generaljournal_entries', $CreditTransaction);
	    }
	    
	    return $PurchaseId;
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
	
	
	function UpdatePurchaseDetail($PurchaseId)
	{	
/*		$ProductId =  $this->input->post('ProductId');
		print_r($ProductId);
		die;
*/	  
	    $PurchaseNo = $this->input->post('PurchaseNo');	    
	    $TotalAmount = array_sum($this->input->post('Amount'));
	    
	    if($this->input->post('VendorId') != "0"){
		    $VendorId =$this->input->post('VendorId');
		    $IdArr = explode("-", $VendorId);
		    $VendorId = $IdArr[0];
		    $VendorIdChartOfAccountId = $IdArr[1];
		}

		if($this->input->post('BankAccountId') != "0"){
		    $BankId =$this->input->post('BankAccountId');
		    $IdArr = explode("-", $BankId);
		    $BankId = $IdArr[0];
		    $BankChartOfAccountId = $IdArr[1];
		}
	    
	     
	    $Purchsedata = array(
	    'AccountId' => $this->input->post('BankAccountId'),
	    'VendorId' => $VendorId,
	    'PurchaseType' => $this->input->post('PurchaseType'),
	    'PurchaseStatus' => $this->input->post('PurchaseStatus'),
	    'PurchaseDate' => date('Y-m-d', strtotime($this->input->post('PurchaseDate'))),
	    'PurchaseInvoice' => $this->input->post('PurchaseInvoice'),
	    'TotalAmount' => $TotalAmount,
	    'PurchaseNote' => $this->input->post('PurchaseNote'),
	    'AddedOn' => date('Y-m-d H:i:s'),
	    'AddedBy' => $this->session->userdata('EmployeeId'),
	    );

	    $this->db->where('pos_purchase.PurchaseId', $PurchaseId);
	    $this->db->update('pos_purchase', $Purchsedata);
	     
	    // Delete Purchase Detail record before Inserting new one
	    $this->db->where('pos_purchase_details.PurchaseId', $PurchaseId);
	    $this->db->delete('pos_purchase_details');
	   
	    // Delete Purchase detail record from Stock table before Inserting new one
	    $this->db->where('pos_stocks_detail.PurchaseId', $PurchaseId);
	    $this->db->delete('pos_stocks_detail');
	    
	   
	    $ProductId =  array_filter($this->input->post('ProductId'));
	    
	    foreach($ProductId as $key=>$value) 
	    {
	      $PurchasesDetail = array(
	      'PurchaseId' => $PurchaseId,
	      'ProductId' => $this->input->post('ProductId')[$key],
	      'LocationId' => $this->input->post('LocationId')[$key] != '' ? $this->input->post('LocationId')[$key] : '0',
	      //'ColourId' => $this->input->post('ColourId')[$key] != '' ? $this->input->post('ColourId')[$key] : '0',    
	      'Quantity' => $this->input->post('Quantity')[$key],
	      'Rate' => $this->input->post('Rate')[$key],
	      'Amount' => $this->input->post('Amount')[$key],
	      'DiscountAmount' => $this->input->post('DiscountAmount')[$key],
	      'RegularDiscount' => $this->input->post('RegularDiscount')[$key],
	      'SaleDiscount' => $this->input->post('SaleDiscount')[$key],
	      'NetAmount' => $this->input->post('NetAmount')[$key],	 
	      'Discount' => $this->input->post('Discount')[$key],
	      'ODiscount' => $this->input->post('ODiscount')[$key],
	      'HoldingAmount' => $this->input->post('HoldingAmount')[$key],
	      'Comments' => $this->input->post('Comments')[$key],
	      );
		
	      $this->db->insert('pos_purchase_details', $PurchasesDetail);
	    }
	    
	    
	    // Stock Type 1 shows Purchase
	     // Following sale detail enters into stock details table
	    foreach($ProductId as $key=>$value) 
	    {    
	      $PurchasedStock = array( 
	      'VendorId' => $VendorId,
	      'PurchaseId' => $PurchaseId,
	      'ProductId' => $this->input->post('ProductId')[$key],
	      'LocationId' => $this->input->post('LocationId')[$key] != '' ? $this->input->post('LocationId')[$key] : '0',
	      //'ColourId' => $this->input->post('ColourId')[$key] != '' ? $this->input->post('ColourId')[$key] : '0',
	      'Rate' => $this->input->post('Rate')[$key],
	      'Quantity' => $this->input->post('Quantity')[$key],
	      'Amount'=> $this->input->post('Amount')[$key],
	      'DiscountAmount' => $this->input->post('DiscountAmount')[$key],
	      'NetAmount' => $this->input->post('NetAmount')[$key],
	      'StockType' => 1,
	      'InOutDate' => date('Y-m-d', strtotime($this->input->post('PurchaseDate'))),
	      'Comments' => $this->input->post('Comments')[$key], 
	      'AddedBy' => $this->session->userdata('EmployeeId'),
	      'AddedOn' => date('Y-m-d H:i:s'),
              );
	      
              // Insert into Stocks Detail table
	      $this->db->insert('pos_stocks_detail', $PurchasedStock);
            }
	    

	    // Getting Cash Balance chart of account from coa table

/*	    $this->db->select('ChartOfAccountId');
	    $this->db->from('pos_accounts_chartofaccount');
	    $this->db->where('ChartOfAccountCategoryId', 1);
	    $this->db->where('ChartOfAccountControlId', 1);
	    $query = $this->db->get()->row();
	    $CashChartOfAccountId = $query->ChartOfAccountId;*/
	    $CashChartOfAccountId = 1;
	    
	    // Gets Sale Account Customer chart of account from coa table
/*	    $this->db->select('ChartOfAccountId');
	    $this->db->from('pos_accounts_chartofaccount');
	    $this->db->where('ChartOfAccountCategoryId', 1);
	    $this->db->where('ChartOfAccountControlId', 5);
	    $query = $this->db->get()->row();
	    $PurchaseChartOfAccountId = $query->ChartOfAccountId;*/
	    $PurchaseChartOfAccountId = 2;
	    
	    // PurchaseType = 1 is On Cash and PurchaseType = 2 is On Credit
	    // Voucher Type 1 = CPV, Voucher Type 2 = BPV,  Voucher Type 3 = CRV, Voucher Type 4 = BRV, Voucher Type 5 = JV, 
	    if($this->input->post('PurchaseType') == "1")
	    {
			$VoucherType = 1;
			$ReferenceNo = $this->CPVReferenceNo();
			$DebitChartOfAccountId = $PurchaseChartOfAccountId;
	    }
	    
	    if($this->input->post('PurchaseType') == "2")
	    {
			$VoucherType = 5;
			$ReferenceNo = $this->JVReferenceNo();
			$DebitChartOfAccountId = $PurchaseChartOfAccountId;
	    }

		if($this->input->post('PurchaseType') == "3")
		{ 
			$VoucherType = 2;
			$ReferenceNo = $this->BPVReferenceNo();
		   	$DebitChartOfAccountId = $PurchaseChartOfAccountId;
        }
	    
	    $DebitAmount = array_sum($this->input->post('NetAmount'));
	    $CreditAmount = array_sum($this->input->post('NetAmount'));

	    // This script checks if accounting entries not find then insert new record else update existing record
	    $this->db->select('GeneralJournalId');
	    $this->db->from('pos_accounts_generaljournal');
	    $this->db->where('pos_accounts_generaljournal.PurchaseId', $PurchaseId);
	    $query = $this->db->get();
	
	    if ($query->num_rows() == 0)
	    {		
		$Transactions = array(
		'PurchaseId' => $PurchaseId,
		'EntryType' => 1,
		'VoucherType' => $VoucherType,
		'Reference' => $ReferenceNo,
		'TransactionDate' => date('Y-m-d', strtotime($this->input->post('PurchaseDate'))),
		'TotalDebit' => $DebitAmount,
		'TotalCredit' => $CreditAmount,
		'AddedOn' => date('Y-m-d H:i:s'),
		'AddedBy' => $this->session->userdata('EmployeeId'),
		);

		$this->db->insert('pos_accounts_generaljournal', $Transactions);
		$GeneralJournalId = intval($this->db->insert_id());
			    
		foreach($ProductId as $key=>$value) 
		{	
		    
		    $DebitTransaction = array(
		'GeneralJournalId' => $GeneralJournalId,
		'ChartOfAccountId' => 1125,
		'VendorId' => $VendorId,
		'Debit' => $this->input->post('RegularDiscount')[$key],
		'Credit' => '0.00',
		'Detail' => 'Percentage',
		);

		$this->db->insert('pos_accounts_generaljournal_entries', $DebitTransaction);
		
			// Following script is entering credit side entry
		$CreditTransaction = array(
		'GeneralJournalId' => $GeneralJournalId,
		'ChartOfAccountId' => 2,
		'VendorId' => $VendorId,
		'Debit'   => '0.00',
		'Credit' => $this->input->post('RegularDiscount')[$key],
		'Detail' => 'Percentage',
		);

		    	$this->db->insert('pos_accounts_generaljournal_entries', $DebitTransaction);
		    // Following script is entering debit side entry
		    $DebitTransaction = array(
		    'GeneralJournalId' => $GeneralJournalId,
		    'ChartOfAccountId' => $DebitChartOfAccountId,
		    'VendorId' => $VendorId,
		    'Debit' => $this->input->post('NetAmount')[$key],
		    'Credit' => '0.00',
		    'Detail' => $this->input->post('Comments')[$key] . " " . $this->input->post('ProductName')[$key] . " " . "Quantity of: " . " " .$this->input->post('Quantity')[$key] . "  Colour: " . $this->input->post('ColourName')[$key],
		    );

		    $this->db->insert('pos_accounts_generaljournal_entries', $DebitTransaction);


		    // If Purchase Type is On Credit, VendorId Chart of Account will be credit else Cash Balance Chart of Account will be credit
		    if($this->input->post('PurchaseType') == "1")
		    {
		    $VoucherType = 2;
			$CreditChartOfAccountId = $CashChartOfAccountId;
		    }

		    if($this->input->post('PurchaseType') == "2")
		    {
		    $VoucherType = 2; 
			$CreditChartOfAccountId = $VendorIdChartOfAccountId;
		    }
    		
    		if($this->input->post('PurchaseType') == "3")
			{ 
			$VoucherType = 2;
			$ReferenceNo = $this->BPVReferenceNo();
		   	$CreditChartOfAccountId = $BankChartOfAccountId;
        	}
		    // end of code

		    // Following script is entering credit side entry
		    $CreditTransaction = array(
		    'GeneralJournalId' => $GeneralJournalId,
		    'ChartOfAccountId' => $CreditChartOfAccountId,
		    'VendorId' => $VendorId,
		    'Debit'   => '0.00',
		    'Credit' => $this->input->post('NetAmount')[$key],
		    'Detail' =>  $this->input->post('Comments')[$key] . " " . $this->input->post('ProductName')[$key] . " " . "Quantity of: " . " " .$this->input->post('Quantity')[$key] . "  Colour: " . $this->input->post('ColourName')[$key],
		     );

		     $this->db->insert('pos_accounts_generaljournal_entries', $CreditTransaction);
		}
	    
	    }

	    else
	    {
		
		// EntryType = 1 shows auto voucher created
		$Transactions = array(
		'TransactionDate' => date('Y-m-d', strtotime($this->input->post('PurchaseDate'))),
		'TotalDebit' => $DebitAmount,
		'TotalCredit' => $CreditAmount,
		'AddedOn' => date('Y-m-d H:i:s'),
		'AddedBy' => $this->session->userdata('EmployeeId'),
		);

		$this->db->where('pos_accounts_generaljournal.PurchaseId', $PurchaseId);
		$this->db->update('pos_accounts_generaljournal', $Transactions);
	    }

	    // Gets GeneralJournal Id
	    $this->db->select('GeneralJournalId');
	    $this->db->from('pos_accounts_generaljournal');
	    $this->db->where('pos_accounts_generaljournal.PurchaseId', $PurchaseId);
	    $query = $this->db->get()->row();
	    $GeneralJournalId = $query->GeneralJournalId;
	    
	    // Remove Record from pos_accounts_generaljournal_entries Before Inserting New Record
	    $this->db->where('pos_accounts_generaljournal_entries.GeneralJournalId', $GeneralJournalId);
	    $this->db->delete('pos_accounts_generaljournal_entries');
	    
  
	    foreach($ProductId as $key=>$value) 
	    {	
		// Following script is entering debit side entry
		$DebitTransaction = array(
		'GeneralJournalId' => $GeneralJournalId,
		'ChartOfAccountId' => $DebitChartOfAccountId,
		'VendorId' => $VendorId,
		'Debit' => $this->input->post('NetAmount')[$key],
		'Credit' => '0.00',
		'Detail' => $this->input->post('Comments')[$key] . " " . $this->input->post('ProductName')[$key] . " " . "Quantity of: " . " " .$this->input->post('Quantity')[$key] . "  Colour: " . $this->input->post('ColourName')[$key],
		);

		$this->db->insert('pos_accounts_generaljournal_entries', $DebitTransaction);

		// If Purchase Type is On Credit, VendorId Chart of Account will be credit else Cash Balance Chart of Account will be credit
		if($this->input->post('PurchaseType') == "1")
		{
		   $CreditChartOfAccountId = $CashChartOfAccountId;
		}
		
		if($this->input->post('PurchaseType') == "2")
		{ 
		   $CreditChartOfAccountId = $VendorIdChartOfAccountId;
        }

		if($this->input->post('PurchaseType') == "3")
		{ 
		   $CreditChartOfAccountId = $BankChartOfAccountId;
        }
		// end of code

		// Following script is entering credit side entry
		$CreditTransaction = array(
		'GeneralJournalId' => $GeneralJournalId,
		'ChartOfAccountId' => $CreditChartOfAccountId,
	        'VendorId' => $VendorId,
		'Debit'   => '0.00',
		'Credit' => $this->input->post('NetAmount')[$key],
		'Detail' =>  $this->input->post('Comments')[$key] . " " . $this->input->post('ProductName')[$key] . " " . "Quantity of: " . " " .$this->input->post('Quantity')[$key] . "  Colour: " . $this->input->post('ColourName')[$key],
		);

	        $this->db->insert('pos_accounts_generaljournal_entries', $CreditTransaction);
	    }	    
	    
	    return $PurchaseId;
	}
	
	
/*	public function GeneratePurchaseNo()
        {
	    $this->db->select("PurchaseNo");
	    $this->db->from('pos_purchase');
	    $this->db->order_by('PurchaseId', 'DESC');
	    $this->db->limit('1');
	    $query = $this->db->get();
	    if ($query->num_rows() > 0)
	    {
		$row = $query->row();
		$RNo = $row->PurchaseNo;

		$iSplit = explode("P", $RNo);
		$data['PurchaseNo'] = $iSplit[1];

		$PurchaseNo = $data['PurchaseNo'] + 1;
		$Prefix = 'P';
		$NewPurchaseNo = $Prefix.''.$PurchaseNo;
		return $NewPurchaseNo;
	    }
	    else
	    { 
		$Prefix = 'P';
		$PurchaseNo = 1;
		$NewPurchaseNo = $Prefix.''.$PurchaseNo;
		return $NewPurchaseNo;
	   } 
	}*/


  public function CPVReferenceNo()
  {
      $this->db->select("Reference");
      $this->db->from('pos_accounts_generaljournal');
      $this->db->where('VoucherType', 1);
      $this->db->order_by('GeneralJournalId', 'DESC');
      $this->db->limit('1');
      $query = $this->db->get();
      if ($query->num_rows() > 0)
      {
      $row = $query->row();
      $RNo = $row->Reference;

      $iSplit = explode("CPV", $RNo);
      $data['Reference'] = $iSplit[1];

      $ReferenceNo = $data['Reference'] + 1;
      $Prefix = 'CPV';
      $NewReferenceNo = $Prefix.''.$ReferenceNo;
      return $NewReferenceNo;
      }
      else
      { 
      $Prefix = 'CPV';
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


  public function BPVReferenceNo()
  {
      $this->db->select("ReferenceNo");
      $this->db->from('pos_accounts_transaction');
      $this->db->where('TransactionType', '2');
      $this->db->order_by('AccountTransactionId', 'DESC');
      $this->db->limit('1');
      $query = $this->db->get();
      if ($query->num_rows() > 0)
      {
      $row = $query->row();
      $RNo = $row->ReferenceNo;

      $iSplit = explode("BPV", $RNo);
      $data['ReferenceNo'] = $iSplit[1];

      $ReferenceNo = $data['ReferenceNo'] + 1;
      $Prefix = 'BPV';
      $NewReferenceNo = $Prefix.''.$ReferenceNo;
      return $NewReferenceNo;
      }
      else
      { 
      $Prefix = 'BPV';
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
	  $this->db->insert('pos_purchase_cart');
	}
	
	$this->db->select('*');
	$this->db->from($this->tbl_purchase_cart);
	$this->db->where('pos_purchase_cart.ProductId',$ProductId);
	$this->db->order_by('PurchaseCartId', 'DESC');
        $this->db->limit('1');
        $query = $this->db->get();
	
	if ($query->num_rows() > 0)
        {
	    $row = $query->row();
	    return $row->PurchaseCartId;
	}
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
	  $this->db->insert('pos_purchase_cart');
	}
	return true;
    }
   
    
    function GetProductByBarcode()
    {
      $this->db->select('*,pos_product_colours.ColourId,pos_product_colours.ColourName,pos_locations.LocationId,pos_locations.LocationName');
    //  $this->db->select('*');
      $this->db->from($this->tbl_purchase_cart);
      $this->db->where('pos_purchase_cart.AddedBy',$this->session->userdata('EmployeeId'));
      $this->db->join($this->tbl_products, $this->tbl_products.'.ProductId = '.$this->tbl_purchase_cart.'.ProductId');
      $this->db->join($this->tbl_product_colours, $this->tbl_product_colours.'.ColourId = '.$this->tbl_purchase_cart.'.ColourId','left');
      $this->db->join($this->tbl_locations, $this->tbl_locations.'.LocationId = '.$this->tbl_purchase_cart.'.LocationId','left');
       $this->db->order_by("pos_purchase_cart.PurchaseCartId", "DESC");
    //  $this->db->join($this->tbl_productgroup, $this->tbl_productgroup.'.ProductGroupId = '.$this->tbl_ims_salesorder_cart.'.ProductGroupId');
      $query = $this->db->get();
      return $query->result();
    }
    
    public function UpdateCartVal($PurchaseCartId,$Quantity,$Rate,$DiscountAmount,$LocationId,$ColourId)
    {
	$Amount = $Quantity * $Rate;
	
	$Data = array(
	'Quantity' => $Quantity,
	'Rate' => $Rate,
	'Amount' => $Amount,
	'DiscountAmount' => $DiscountAmount,
	'LocationId' => $LocationId,
	'ColourId' => $ColourId
	);
	
	$this->db->where('PurchaseCartId', $PurchaseCartId);
	$this->db->update('pos_purchase_cart', $Data);

    }
     function GetAveragePrice()
	{
	    $this->db->select('
			ProductId,
			SUM(Amount) AS InvoiceAmount,
            SUM(Quantity) AS Quantity,
		');
	    $this->db->from($this->tbl_purchase_detail);
		$this->db->group_by("ProductId");
	    $query = $this->db->get();
	    $result = $query->result_array();	

		$averagePurchasePrice = [];
		$i = 0;
		foreach($result as $array){
			$averagePurchasePrice[$i]['ProductId'] 	   = $array['ProductId'];
			$averagePurchasePrice[$i]['PurchasePrice'] = round($array['InvoiceAmount']) / round($array['Quantity']);
			$i++;
		}
		return $averagePurchasePrice;
	}

}
?>