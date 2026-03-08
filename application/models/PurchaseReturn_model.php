<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class PurchaseReturn_model extends CI_Model{
	
	function __construct()
	{
        parent::__construct();
        $this->tbl_category = "pos_category";
		$this->tbl_vendor = "pos_vendor";
        $this->tbl_locations = "pos_locations";
        $this->tbl_products = "pos_products";
        $this->tbl_product_colours = "pos_product_colours";
		$this->tbl_purchase = "pos_purchase";
		$this->tbl_bankaccount = "pos_bank_accounts";
        $this->tbl_purchase_detail = "pos_purchase_details";
        $this->tbl_purchase_return = "pos_purchase_return";
        $this->tbl_purchase_return_detail = "pos_purchase_return_detail";
        $this->tbl_stocks_detail = "pos_stocks_detail";
        $this->tbl_stock_summary = "pos_stock_summary";
//            $this->output->enable_profiler;
	}
	
	
	function GetAllPurchaseReturn()
	{
	    $this->db->select('*');
	    $this->db->from($this->tbl_purchase_return);
	    //$this->db->join($this->tbl_product, $this->tbl_product.'.ProductId = '.$this->tbl_sales.'.ProductId');
	    //$this->db->join($this->tbl_account, $this->tbl_account.'.accountId = '.$this->tbl_sales.'.accountId');
	    $query = $this->db->get();
	    return $query->result_array();	
	}

    public function Ajax_GetAllPurchaseReturn($requestData)
    {
        $columns = array( 
		0 => 'PurchaseReturnId',
		1 => 'PurchaseReturnNo',
		2 => 'VendorName',
		3 => 'PurchaseReturnType',
		4 => 'PurchaseReturnDate',
		5 => 'TotalAmount',
                );
                $sql = "SELECT *";
                $sql.=" FROM pos_purchase_return";
		$sql.=" JOIN pos_vendor ON pos_vendor.VendorId = pos_purchase_return.VendorId";
                $query= $this->db->query($sql); 
                $totalData = $query->num_rows();
                $totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.
                $sql.=" WHERE 1=1 ";
                if( !empty($requestData['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter
                       $sql.=" AND (PurchaseReturnNo LIKE '".$requestData['search']['value']."%' ";
                       $sql.=" OR VendorName LIKE '".$requestData['search']['value']."%' ";
                       $sql.=" OR PurchaseReturnDate LIKE '".$requestData['search']['value']."%' ";
                       $sql.=" OR  TotalAmount LIKE '".$requestData['search']['value']."%' )";
                }
                $query=$this->db->query( $sql) ;
                $totalFiltered = $query->num_rows(); // when there is a search parameter then we have to modify total number filtered rows as per search result. 
                $sql.=" ORDER BY ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']."  LIMIT ".$requestData['start']." ,".$requestData['length']."   ";
                $query=$this->db->query($sql);  
                
                $array['record'] = $query->result_array();
                $array['recordsFiltered'] = $totalFiltered;
                $array['recordsTotal'] = $totalData;
                return $array;
   
        }
	
	
	function GetPurchase($PurchaseId)
	{
	    $this->db->select('*');
	    $this->db->from($this->tbl_purchase);
	    $this->db->join($this->tbl_vendor, $this->tbl_vendor.'.VendorId = '.$this->tbl_purchase.'.VendorId');
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
	    $this->db->where('pos_purchase_details.PurchaseId',$PurchaseId);
	    $query = $this->db->get();
	    return $query->result_array();
	}
	
	
	
	function GetPurchaseReturn($PurchaseReturnId)
	{
	    $this->db->select('*');
	    $this->db->from($this->tbl_purchase_return);
	    $this->db->join($this->tbl_vendor, $this->tbl_vendor.'.VendorId = '.$this->tbl_purchase_return.'.VendorId','left');
	    $this->db->join($this->tbl_bankaccount, $this->tbl_bankaccount.'.AccountId = '.$this->tbl_purchase_return.'.AccountId', 'left');
	    $this->db->where('pos_purchase_return.PurchaseReturnId',$PurchaseReturnId);
	    $query = $this->db->get();
	    return $query->row();
	    
	}
	
	
	function GetPurchaseReturnDetail($PurchaseReturnId)
	{

	    $this->db->select('*');
	    $this->db->from($this->tbl_purchase_return);
	    $this->db->join($this->tbl_purchase_return_detail, $this->tbl_purchase_return_detail.'.PurchaseReturnId = '.$this->tbl_purchase_return.'.PurchaseReturnId');
	    $this->db->join($this->tbl_products, $this->tbl_products.'.ProductId = '.$this->tbl_purchase_return_detail.'.ProductId', 'left');
	    $this->db->join($this->tbl_locations, $this->tbl_locations.'.LocationId = '.$this->tbl_purchase_return_detail.'.LocationId','left');
	    $this->db->join($this->tbl_product_colours, $this->tbl_product_colours.'.ColourId = '.$this->tbl_purchase_return_detail.'.ColourId','left');
	   // $this->db->join($this->tbl_accounts_transaction, $this->tbl_accounts_transaction.'.PurchaseId = '.$this->tbl_purchase.'.PurchaseId', 'left');
	    $this->db->where('pos_purchase_return_detail.PurchaseReturnId',$PurchaseReturnId);
	    $query = $this->db->get();
	    return $query->result_array();
	}
	
	
	public function SavePurchaseReturnDetail()
	{
// 	   $PurchaseReturnNo = $this->GeneratePurchaseReturnNo();
	   $TotalAmount = array_sum($this->input->post('Amount'));
	   
	    $VendorId =$this->input->post('VendorId');
	    $IdArr = explode("-", $VendorId);
	    $VendorId = $IdArr[0];
	    $VendorChartOfAccountId = $IdArr[1];

	    $BankAccountId =$this->input->post('BankAccountId');
	    $IdArr = explode("-", $BankAccountId);
@	    $BankAccountId = $IdArr[0];
@	    $BankChartOfAccountId = $IdArr[1];

	    $data = array(
//		    'PurchaseReturnNo' => $PurchaseReturnNo,
		    'VendorId' => $VendorId,
		    'AccountId' => $BankAccountId,
		    'PurchaseReturnType' => $this->input->post('PurchaseReturnType'),
		    'PurchaseReturnDate' => date('Y-m-d', strtotime($this->input->post('PurchaseReturnDate'))),
		    'TotalAmount' => $TotalAmount,
		    'PurchaseReturnNote' => $this->input->post('PurchaseReturnNote'),
		    'AddedOn' => date('Y-m-d H:i:s'),
		    'AddedBy' => $this->session->userdata('EmployeeId'),
	    );

	    $this->db->insert('pos_purchase_return', $data);
	    $PurchaseReturnId = intval($this->db->insert_id());
	   
	    $ProductId = $this->input->post('ProductId');
	    
	    foreach($ProductId as $key=>$value) 
	    {
	      $PurchasesDetail = array(
	      'PurchaseReturnId' => $PurchaseReturnId,
	      'ProductId' => $this->input->post('ProductId')[$key],
	      'LocationId' => $this->input->post('LocationId')[$key] != '' ? $this->input->post('LocationId')[$key] : '0',
	      'ColourId' => $this->input->post('ColourId')[$key] != '' ? $this->input->post('ColourId')[$key] : '0',    
	      'Quantity' => $this->input->post('Quantity')[$key],
	      'Rate' => $this->input->post('Rate')[$key],
	      'Amount' => $this->input->post('Amount')[$key],
	      'DiscountAmount' => $this->input->post('DiscountAmount')[$key],
	      'NetAmount' => $this->input->post('NetAmount')[$key],
	      'Comments' => $this->input->post('Comments')[$key],
	      );
		
	     $Sucess = $this->db->insert('pos_purchase_return_detail', $PurchasesDetail);
	    }
	    
	    
	    // Stock Type 1 shows Purchase and 2 shows Purchase Return
	  
	    // Following sale detail enters into stock details table
	    foreach($ProductId as $key=>$value) 
	    {    
	      $PurchasedStock = array( 
	      'VendorId' => $VendorId,
	      'PurchaseReturnId' => $PurchaseReturnId,
	      'ProductId' => $this->input->post('ProductId')[$key],
	      'LocationId' => $this->input->post('LocationId')[$key] != '' ? $this->input->post('LocationId')[$key] : '0',
	      'ColourId' => $this->input->post('ColourId')[$key] != '' ? $this->input->post('ColourId')[$key] : '0',
	      'Rate' => $this->input->post('Rate')[$key],
	      'Quantity' => $this->input->post('Quantity')[$key],
	      'Amount'=> $this->input->post('Amount')[$key],
	      'NetAmount'=> $this->input->post('Amount')[$key],
	      'StockType' => 2,
	      'InOutDate' => date('Y-m-d', strtotime($this->input->post('PurchaseReturnDate'))),
	      'Comments' => $this->input->post('Comments')[$key], 
	      'AddedBy' => $this->session->userdata('EmployeeId'),
	      'AddedOn' => date('Y-m-d H:i:s'),
              );
	      
              // Insert into Stocks Detail table
	     $this->db->insert('pos_stocks_detail', $PurchasedStock);
            }
	      	    
	    
	    // Getting Cash Balance chart of account from setting table
/*	    $this->db->select('ChartOfAccountId');
	    $this->db->from('pos_setting');
	    $this->db->where('ComponentId', 2); // Component Id 2 means Purchase Return
	    $this->db->where('TransactionTypeId', 7); // Component Type Id 7 menas cash 
	    $query = $this->db->get()->row();
	    $CashChartOfAccountId = $query->ChartOfAccountId;
	    */
	    $CashChartOfAccountId = 1;
	    
	    // Getting Purchase Return Account Vendor chart of account from setting table
/*	    $this->db->select('ChartOfAccountId');
	    $this->db->from('pos_setting');
	    $this->db->where('ComponentId', 2);
	    $this->db->where('TransactionTypeId', 2);
	    $query = $this->db->get()->row();
	    $PurchaseReturnChartOfAccountId = $query->ChartOfAccountId;
	    */
	    $PurchaseReturnChartOfAccountId = 114;
	    
	    
	    // If Purchase Return Type is On Credit, VendorId Chart of Account will be debit else Cash Balance Chart of Account will be debit
	    // Voucher Type 1 = CPV, Voucher Type 2 = BPV,  Voucher Type 3 = CRV, Voucher Type 4 = BRV, Voucher Type 5 = JV, 
	    if($this->input->post('PurchaseReturnType') == "1")
	    {
			$DebitChartOfAccountId = $CashChartOfAccountId;
			$VoucherType = 3;
		 	$ReferenceNo = $this->CRVReferenceNo();
	    }
	    
	    if($this->input->post('PurchaseReturnType') == "2")
	    {
			$DebitChartOfAccountId = $VendorChartOfAccountId;
			$VoucherType = 5;	 
			$ReferenceNo = $this->JVReferenceNo();
	    }

	    if($this->input->post('PurchaseReturnType') == "3")
	    {
			$DebitChartOfAccountId = $BankChartOfAccountId;
			$VoucherType = 4;	 
			$ReferenceNo = $this->BRVReferenceNo();
	    }
	    
	    $DebitAmount = array_sum($this->input->post('NetAmount'));
	    $CreditAmount = array_sum($this->input->post('NetAmount'));
	    
	    
	    
	    // EntryType = 1 shows auto voucher created
	    $Transactions = array(
	    'PurchaseReturnId' => $PurchaseReturnId,
	    'EntryType' => 1,
	    'VoucherType' => $VoucherType,
	    'Reference' => $ReferenceNo,
	    'TransactionDate' => date('Y-m-d', strtotime($this->input->post('PurchaseReturnDate'))),
	    'TotalDebit' => $DebitAmount,
	    'TotalCredit' => $CreditAmount,
	    'AddedOn' => date('Y-m-d H:i:s'),
	    'AddedBy' => $this->session->userdata('EmployeeId'),
	    );

	    $this->db->insert('pos_accounts_generaljournal', $Transactions);
	    $GeneralJournalId = intval($this->db->insert_id());
	    
	    $ProductId = $this->input->post('ProductId');	    
	    
	    
	   
	    foreach($ProductId as $key=>$value) 
	    {	
		// Following script is entering debit side entry
		$DebitTransaction = array(
		'GeneralJournalId' => $GeneralJournalId,
		'ChartOfAccountId' => $DebitChartOfAccountId,
		'VendorId' => $VendorId,
		'Debit' => $this->input->post('Amount')[$key],
		'Credit' => '0.00',
		'Detail' => $this->input->post('Comments')[$key] . " " . $this->input->post('ProductName')[$key] . " " . "Quantity of: " . " " .$this->input->post('Quantity')[$key],
		);

		$this->db->insert('pos_accounts_generaljournal_entries', $DebitTransaction);


		if($this->input->post('PurchaseReturnType') == "1")
		{    
		  $CreditChartOfAccountId = $PurchaseReturnChartOfAccountId;
		}
		
		if($this->input->post('PurchaseReturnType') == "2")
		{ 
		   $CreditChartOfAccountId = $PurchaseReturnChartOfAccountId;
        }

		if($this->input->post('PurchaseReturnType') == "3")
		{ 
		   $CreditChartOfAccountId = $PurchaseReturnChartOfAccountId;
        }

		// end of code

		// Following script is entering credit side entry
		$CreditTransaction = array(
		'GeneralJournalId' => $GeneralJournalId,
		'ChartOfAccountId' => $CreditChartOfAccountId,
	        'VendorId' => $VendorId,
		'Debit'   => '0.00',
		'Credit' => $this->input->post('Amount')[$key],
		'Detail' =>  $this->input->post('Comments')[$key] . " " . $this->input->post('ProductName')[$key] . " " . "Quantity of: " . " " .$this->input->post('Quantity')[$key] . "  Rate: " . $this->input->post('Rate')[$key],
		);

	        $this->db->insert('pos_accounts_generaljournal_entries', $CreditTransaction);
	    }
	      return $PurchaseReturnId;
	  
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
	
	public function UpdatePurchaseReturnDetail($PurchaseReturnId)
	{
	    $TotalAmount = array_sum($this->input->post('Amount'));	
		
	    $VendorId =$this->input->post('VendorId');
	    $IdArr = explode("-", $VendorId);
	    $VendorId = $IdArr[0];
	    $VendorChartOfAccountId = $IdArr[1];

	    $BankAccountId =$this->input->post('BankAccountId');
	    $IdArr = explode("-", $BankAccountId);
@	    $BankAccountId = $IdArr[0];
@	    $BankChartOfAccountId = $IdArr[1];

	    $PurchaseReturnData = array(
	    'VendorId' => $VendorId,
	    'AccountId' => $BankAccountId,
	    'PurchaseReturnDate' => date('Y-m-d', strtotime($this->input->post('PurchaseReturnDate'))),
	    'TotalAmount' => $TotalAmount,
	    'AddedOn' => date('Y-m-d H:i:s'),
	    'AddedBy' => $this->session->userdata('EmployeeId'),
	    );

	    $this->db->where('pos_purchase_return.PurchaseReturnId', $PurchaseReturnId);
	    $this->db->update('pos_purchase_return', $PurchaseReturnData);

	    // Remove Sale Return Detail Record Before Inserting New Record
	    $this->db->where('pos_purchase_return_detail.PurchaseReturnId', $PurchaseReturnId);
	    $this->db->delete('pos_purchase_return_detail');
	    
	    // Remove Stock Detail Record Before Inserting New Record
	    $this->db->where('pos_stocks_detail.PurchaseReturnId', $PurchaseReturnId);
	    $this->db->delete('pos_stocks_detail');

	    
	    $ProductId = $this->input->post('ProductId');
	    
	    foreach($ProductId as $key=>$value) 
	    {
	      $PurchasesDetail = array(
	      'PurchaseReturnId' => $PurchaseReturnId,
	      'ProductId' => $this->input->post('ProductId')[$key],
	      'LocationId' => $this->input->post('LocationId')[$key] != '' ? $this->input->post('LocationId')[$key] : '0',
	      'ColourId' => $this->input->post('ColourId')[$key] != '' ? $this->input->post('ColourId')[$key] : '0',    
	      'Quantity' => $this->input->post('Quantity')[$key],
	      'Rate' => $this->input->post('Rate')[$key],
	      'Amount' => $this->input->post('Amount')[$key],
	      'DiscountAmount' => $this->input->post('DiscountAmount')[$key],
	      'NetAmount' => $this->input->post('NetAmount')[$key],
	      'Comments' => $this->input->post('Comments')[$key],
	      );
		
	      $Sucess = $this->db->insert('pos_purchase_return_detail', $PurchasesDetail);
	    }
	    
	    // Following sale detail enters into stock details table
	    foreach($ProductId as $key=>$value) 
	    {    
	      $PurchasedStock = array( 
	      'VendorId' => $VendorId,
	      'PurchaseReturnId' => $PurchaseReturnId,
	      'ProductId' => $this->input->post('ProductId')[$key],
	      'LocationId' => $this->input->post('LocationId')[$key] != '' ? $this->input->post('LocationId')[$key] : '0',
	      'ColourId' => $this->input->post('ColourId')[$key] != '' ? $this->input->post('ColourId')[$key] : '0',
	      'Rate' => $this->input->post('Rate')[$key],
	      'Quantity' => $this->input->post('Quantity')[$key],
	      'Amount'=> $this->input->post('Amount')[$key],
	      'NetAmount'=> $this->input->post('Amount')[$key],
	      'StockType' => 2,
	      'InOutDate' => date('Y-m-d', strtotime($this->input->post('PurchaseReturnDate'))),
	      'Comments' => $this->input->post('Comments')[$key], 
	      'AddedBy' => $this->session->userdata('EmployeeId'),
	      'AddedOn' => date('Y-m-d H:i:s'),
              );
	      
              // Insert into Stocks Detail table
	     $this->db->insert('pos_stocks_detail', $PurchasedStock);
            }
	  
	    
	    // Following codes insert and update record into generaljournal tables
	    // Getting Cash Balance chart of account from setting table
/*	    $this->db->select('ChartOfAccountId');
	    $this->db->from('pos_setting');
	    $this->db->where('ComponentId', 2); // Component Id 2 means Purchase Return
	    $this->db->where('TransactionTypeId', 7); // Component Type Id 7 menas cash 
	    $query = $this->db->get()->row();
	    $CashChartOfAccountId = $query->ChartOfAccountId;
	    */
	    $CashChartOfAccountId = 1;
	    
	    // Getting Purchase Return Account Vendor chart of account from setting table
/*	    $this->db->select('ChartOfAccountId');
	    $this->db->from('pos_setting');
	    $this->db->where('ComponentId', 2);
	    $this->db->where('TransactionTypeId', 2);
	    $query = $this->db->get()->row();
	    $PurchaseReturnChartOfAccountId = $query->ChartOfAccountId;*/
	    $PurchaseReturnChartOfAccountId = 114;
	    
	    
	    // If Purchase Return Type is On Credit, VendorId Chart of Account will be debit else Cash Balance Chart of Account will be debit
	    // Voucher Type 1 = CPV, Voucher Type 2 = BPV,  Voucher Type 3 = CRV, Voucher Type 4 = BRV, Voucher Type 5 = JV, 
	    if($this->input->post('PurchaseReturnType') == "1")
	    {
			$DebitChartOfAccountId = $CashChartOfAccountId;
	    }
	    
	    if($this->input->post('PurchaseReturnType') == "2")
	    {
			$DebitChartOfAccountId = $VendorChartOfAccountId;
	    }

	    if($this->input->post('PurchaseReturnType') == "3")
		{ 
		   $DebitChartOfAccountId = $BankChartOfAccountId;
        }
	    
	    $DebitAmount = array_sum($this->input->post('NetAmount'));
	    $CreditAmount = array_sum($this->input->post('NetAmount'));
	       
	    
	    // EntryType = 1 shows auto voucher created
	    $Transactions = array(
	    'TransactionDate' => date('Y-m-d', strtotime($this->input->post('PurchaseReturnDate'))),
	    'TotalDebit' => $DebitAmount,
	    'TotalCredit' => $CreditAmount,
	    'AddedOn' => date('Y-m-d H:i:s'),
	    'AddedBy' => $this->session->userdata('EmployeeId'),
	    );
	    
	    $this->db->where('pos_accounts_generaljournal.PurchaseReturnId', $PurchaseReturnId);
	    $this->db->update('pos_accounts_generaljournal', $Transactions);
	    
	    // Gets GeneralJournal Id
	    $this->db->select('GeneralJournalId');
	    $this->db->from('pos_accounts_generaljournal');
	    $this->db->where('pos_accounts_generaljournal.PurchaseReturnId', $PurchaseReturnId);
	    $query = $this->db->get()->row();
	    $GeneralJournalId = $query->GeneralJournalId;
	    
	    // Remove Record from pos_accounts_generaljournal_entries Before Inserting New Record
	    $this->db->where('pos_accounts_generaljournal_entries.GeneralJournalId', $GeneralJournalId);
	    $this->db->delete('pos_accounts_generaljournal_entries');
	    	    
	    $ProductId = $this->input->post('ProductId');	    
	    
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


		if($this->input->post('PurchaseReturnType') == "1")
		{    
		  $CreditChartOfAccountId = $PurchaseReturnChartOfAccountId;
		}
		
		if($this->input->post('PurchaseReturnType') == "2")
		{ 
		   $CreditChartOfAccountId = $PurchaseReturnChartOfAccountId;
        }
		if($this->input->post('PurchaseReturnType') == "3")
		{ 
		   $CreditChartOfAccountId = $PurchaseReturnChartOfAccountId;
        }

		// end of code

		// Following script is entering credit side entry
		$CreditTransaction = array(
		'GeneralJournalId' => $GeneralJournalId,
		'ChartOfAccountId' => $CreditChartOfAccountId,
	        'VendorId' => $VendorId,
		'Debit'   => '0.00',
		'Credit' => $this->input->post('Amount')[$key],
		'Detail' =>  $this->input->post('Comments')[$key] . " " . $this->input->post('ProductName')[$key] . " " . "Quantity of: " . " " .$this->input->post('Quantity')[$key] . "  Colour: " . $this->input->post('ColourName')[$key],
		);

	        $this->db->insert('pos_accounts_generaljournal_entries', $CreditTransaction);
	    }

	    return $PurchaseReturnId;
    }
    
    
    public function GeneratePurchaseReturnNo()
        {
	    $this->db->select("PurchaseReturnNo");
	    $this->db->from('pos_purchase_return');
	    $this->db->order_by('PurchaseReturnId', 'DESC');
	    $this->db->limit('1');
	    $query = $this->db->get();
	    if ($query->num_rows() > 0)
	    {
		$row = $query->row();
		$RNo = $row->PurchaseReturnNo;

		$iSplit = explode("PR", $RNo);
		$data['PurchaseReturnNo'] = $iSplit[1];

		$PurchaseReturnNo = $data['PurchaseReturnNo'] + 1;
		$Prefix = 'PR';
		$NewPurchaseReturnNo = $Prefix.''.$PurchaseReturnNo;
		return $NewPurchaseReturnNo;
	    }
	    else
	    {
		$Prefix = 'PR';
		$PurchaseReturnNo = 1;
		$NewPurchaseReturnNo = $Prefix.''.$PurchaseReturnNo;
		return $NewPurchaseReturnNo;
	    }
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
	
	
	function GetAllCategories() 
	{
        $query = $this->db->get_where($this->tbl_category, array('CategoryStatus != '=>"0"));
        $result = $query->result_array();
        $Categories[0] = 'Select Category';
        foreach ($result as $key => $value) {
            $Categories[$value['CategoryId']] = $value['CategoryName'];
        }
        return $Categories;
    }
	
	function GetAllProductGroups() 
	{
        $query = $this->db->get($this->tbl_productgroup);
        $result = $query->result_array();
        $ProductGroups[0] = 'Select Product Group / Generic';
        foreach ($result as $key => $value) {
            $ProductGroups[$value['ProductGroupId']] = $value['ProductGroupName'];
        }
        return $ProductGroups;
    }

}
?>