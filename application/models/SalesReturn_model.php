<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class SalesReturn_model extends CI_Model{
	
	function __construct()
	{
        parent::__construct();
        $this->tbl_category = "pos_category";
        $this->tbl_customer = "pos_customer";
        $this->tbl_reference = "pos_references";
        $this->tbl_locations = "pos_locations";
        $this->tbl_product_colours = "pos_product_colours";
        $this->tbl_productgroup = "pos_productgroup";
        $this->tbl_products = "pos_products";
        $this->tbl_sales_return = "pos_sales_return";
        $this->tbl_sales_return_detail = "pos_sales_return_detail";
        $this->tbl_stocks_detail = "pos_stocks_detail";
        $this->tbl_stock_summary = "pos_stock_summary";
        $this->tbl_bank_accounts = "pos_bank_accounts";
		$this->tbl_saleman = "pos_saleman";
//        $this->output->enable_profiler;
	}
	
	
	function GetAllSalesReturn()
	{
	    $this->db->select('*');
	    $this->db->from($this->tbl_sales_return);
	    $query = $this->db->get();
	    return $query->result_array();	
	}

    public function Ajax_GetAllSalesReturn($requestData)
    {
               $columns = array( 
                        0 => 'SaleReturnId',
                        1 => 'SaleReturnNo',
                        2 => 'SaleReturnType',
                        3 => 'SaleReturnDate',
                        4 => 'TotalAmount',
                );
                $sql = "SELECT *";
                $sql.=" FROM pos_sales_return";

                $query= $this->db->query($sql); 
                $totalData = $query->num_rows();
                $totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.
                $sql.=" WHERE 1=1 ";
                if( !empty($requestData['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter
                       $sql.=" AND (SaleReturnNo LIKE '".$requestData['search']['value']."%' ";
                       $sql.=" OR SaleReturnType LIKE '".$requestData['search']['value']."%' ";
                       $sql.=" OR SaleReturnDate LIKE '".$requestData['search']['value']."%' ";
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
	
	
	function GetSalesReturn($SaleReturnId)
	{
	    $this->db->select('*');
	    $this->db->from($this->tbl_sales_return);
	   	$this->db->join($this->tbl_customer, $this->tbl_customer.'.CustomerId = '.$this->tbl_sales_return.'.CustomerId', 'left');
		$this->db->join($this->tbl_saleman, $this->tbl_saleman.'.SalemanId = '.$this->tbl_sales_return.'.SalemanId', 'left');
	    $this->db->join($this->tbl_reference, $this->tbl_reference.'.ReferenceId = '.$this->tbl_sales_return.'.ReferenceId', 'left');
	    $this->db->join($this->tbl_bank_accounts, $this->tbl_bank_accounts.'.AccountId = '.$this->tbl_sales_return.'.AccountId', 'left');
	    $this->db->where('pos_sales_return.SaleReturnId',$SaleReturnId);
	    $query = $this->db->get();
	    return $query->row();	
	}
	
	
	function GetSalesReturnDetail($SaleReturnId)
	{
	    $this->db->select('*');
	    $this->db->from($this->tbl_sales_return_detail);
	    $this->db->join($this->tbl_sales_return, $this->tbl_sales_return.'.SaleReturnId = '.$this->tbl_sales_return_detail.'.SaleReturnId');
            $this->db->join($this->tbl_products, $this->tbl_products.'.ProductId = '.$this->tbl_sales_return_detail.'.ProductId', 'left');
	    $this->db->join($this->tbl_locations, $this->tbl_locations.'.LocationId = '.$this->tbl_sales_return_detail.'.LocationId','left');
	    $this->db->join($this->tbl_product_colours, $this->tbl_product_colours.'.ColourId = '.$this->tbl_sales_return_detail.'.ColourId','left');
	    $this->db->where('pos_sales_return_detail.SaleReturnId',$SaleReturnId);
	    $query = $this->db->get();
	    return $query->result_array();
	}	
	
	
	public function SaveSalesReturnDetail()
	{
	    date_default_timezone_set('Asia/Karachi');
//	    $SaleReturnNo = $this->GenerateSalesReturnNo();
	    $CustomerVal = $this->input->post('CustomerId');
	   
		$IdArr = explode("-", $CustomerVal);
		$CustomerId = $IdArr[0];
		$CustomerChartOfAccountId = $IdArr[1];

	    $BankAccountVal = $this->input->post('BankAccountId');
		$IdArr = explode("-", $BankAccountVal);
		$BankAccountId = $IdArr[0];
		$BankChartOfAccountId = $IdArr[0];

		$SalemanVal =$this->input->post('SalemanId');
		$IdArrSaleman = explode("-", $SalemanVal);
		$SalemanId = $IdArrSaleman[0];
		$SalemanChartOfAccountId = $IdArrSaleman[1] ?? $IdArrSaleman[0];
	    
	  //  $Record = $this->input->post();
	    $TotalAmount = array_sum($this->input->post('Amount'));
	
	    $SaleReturn = array(
	    'SaleReturnType'    => $this->input->post('SaleReturnType'),
	    'AccountId' => $BankAccountId,
		'SalemanId' => $SalemanId,
	   	'CustomerId' => $CustomerId,
		'ReferenceId'   => $this->input->post('ReferenceId'),
	    'SaleReturnDate' =>  date('Y-m-d H:i:s', strtotime($this->input->post('SaleReturnDate'))),
//	    'SaleReturnNo' => $SaleReturnNo,
	    'TotalAmount' => $TotalAmount,
	    'SaleReturnNote'    => $this->input->post('SaleReturnNote'),	
	    'AddedOn' => date('Y-m-d H:i:s'),
	    'AddedBy' => $this->session->userdata('EmployeeId'),
	    'FbrNo' => $this->input->post('FbrNo'),
	    'fbr_cnic'    => $this->input->post('fbr_cnic'),
	    'fbr_ntn'    => $this->input->post('fbr_ntn'),
	    'fbr_customer'    => $this->input->post('fbr_customer'),
	    'fbr_mobile'    => $this->input->post('fbr_mobile'),
	    );

	    $this->db->insert('pos_sales_return', $SaleReturn);
	    $SaleReturnId = intval($this->db->insert_id());

	    
	    $ProductId = $this->input->post('ProductId');	    
	
	    foreach($ProductId as $key => $value) 
	    {
		
		$SalesReturnDetail = array(
		'SaleReturnId' => $SaleReturnId,
		'ProductId'  => $this->input->post('ProductId')[$key],
		'LocationId'  => $this->input->post('LocationId')[$key],
		//'ColourId'  => $this->input->post('ColourId')[$key],
		'Rate'    => $this->input->post('Rate')[$key],
		'Quantity'    => $this->input->post('Quantity')[$key],
		'Amount'   => $this->input->post('Amount')[$key],
		'DiscountAmount'   => $this->input->post('DiscountAmount')[$key],
		'TaxPercentage'   => $this->input->post('TaxPercentage')[$key],
		'TaxAmount'   => $this->input->post('TaxAmount')[$key],
		'NetAmount'   => $this->input->post('NetAmount')[$key],
		);
		
	        $this->db->insert('pos_sales_return_detail', $SalesReturnDetail);
	    }
	    
	    
	    
	    
	    // Following sale detail enters into stock details table
	    foreach($ProductId as $key=>$value) 
	    {    
/*		$CustomerVal =$this->input->post('CustomerId')[$key];
		$IdArr = explode("-", $CustomerVal);
		$CustomerId = $IdArr[0];*/
		
	      $SaleReturnStock = array( 
	      'CustomerId' => $CustomerId,
	      'SaleReturnId' => $SaleReturnId,
	      'ProductId' => $this->input->post('ProductId')[$key],
	      'LocationId' => $this->input->post('LocationId')[$key],
	      //'ColourId' => $this->input->post('ColourId')[$key],
	      'Rate' => $this->input->post('Rate')[$key],
	      'Quantity' => $this->input->post('Quantity')[$key],
	      'Amount'=> $this->input->post('Amount')[$key],
	      'NetAmount' => $this->input->post('Amount')[$key],
	      'StockType' => 4,	// 4 shows sale return stock
	      'InOutDate' => date('Y-m-d', strtotime($this->input->post('SaleReturnDate'))),
	      'Comments' => $this->input->post('Comments')[$key], 
	      'AddedBy' => $this->session->userdata('EmployeeId'),
	      'AddedOn' => date('Y-m-d H:i:s'),
              );	    
		
              // Insert into Stocks Detail table
	    $this->db->insert('pos_stocks_detail', $SaleReturnStock);
            }

	    // insert into accounts generaljournal and its detail table
	    
	    // Getting Cash Balance chart of account from setting table
/*	    $this->db->select('ChartOfAccountId');
	    $this->db->from('pos_setting');
	    $this->db->where('ComponentId', 4);
	    $this->db->where('TransactionTypeId', 7);
	    $query = $this->db->get()->row();
	    $CashChartOfAccountId = $query->ChartOfAccountId;
	    */
	    $CashChartOfAccountId = 1;
	    
	    // Getting Sale Account Customer chart of account from setting table
/*	    $this->db->select('ChartOfAccountId');
	    $this->db->from('pos_setting');
	    $this->db->where('ComponentId', 4);
	    $this->db->where('TransactionTypeId', 4);
	    $query = $this->db->get()->row();
	    $SaleReturnChartOfAccountId = $query->ChartOfAccountId;*/
	    $SaleReturnChartOfAccountId = 5;
	    
	    
	    // SaleType = 1 is On Cash and SaleType = 2 is On Credit
	    // Voucher Type 1 = CPV, Voucher Type 2 = BPV,  Voucher Type 3 = CRV, Voucher Type 4 = BRV, Voucher Type 5 = JV,
	    // 
	    // When sale returns type is on cash, it generatees CPV and showing that customer purchased item on cash and now has to return product on Cash so cash will be credit
	    if($this->input->post('SaleReturnType') == "1")
	    {
			$DebitChartOfAccountId = $SaleReturnChartOfAccountId;
			$VoucherType = 1;
		 	$ReferenceNo = $this->CPVReferenceNo();
	    }
	   
	    // When sale returns is on credit, it generatees JV and shows last time customer purchased products on credit
	    if($this->input->post('SaleReturnType') == "2")
	    {
			$DebitChartOfAccountId = $SaleReturnChartOfAccountId;
			$VoucherType = 5;
			$ReferenceNo = $this->JVReferenceNo();
	    }

	    if($this->input->post('SaleReturnType') == "3")
	    {
			$DebitChartOfAccountId = $SaleReturnChartOfAccountId;
			$VoucherType = 2;
			$ReferenceNo = $this->BPVReferenceNo();
	    }
	    
	    $DebitAmount = array_sum($this->input->post('NetAmount'));
	    $CreditAmount = array_sum($this->input->post('NetAmount'));
	    
	     // EntryType = 1 shows auto voucher created
	    $Transactions = array(
		    'SaleReturnId' => $SaleReturnId,
		    'EntryType' => 1,
		    'VoucherType' => $VoucherType,
		    'Reference' => $ReferenceNo,
		    'TransactionDate' => date('Y-m-d', strtotime($this->input->post('SaleReturnDate'))),
		    'TotalDebit' => $DebitAmount,
		    'TotalCredit' => $CreditAmount,
		    'AddedOn' => date('Y-m-d H:i:s'),
		    'AddedBy' => $this->session->userdata('EmployeeId'),
	    );

	    $this->db->insert('pos_accounts_generaljournal', $Transactions);
	    $GeneralJournalId = intval($this->db->insert_id());
	    	 
	    foreach($ProductId as $key=>$value) 
	    {	
/*		$CustomerVal =$this->input->post('CustomerId')[$key];
		$IdArr = explode("-", $CustomerVal);
		$CustomerId = $IdArr[0];
		$CustomerChartOfAccountId = $IdArr[1];*/
		
		// Following script is entering debit side entry
		$CreditTransactionDetail = array(
		'GeneralJournalId' => $GeneralJournalId,
		'CustomerId' => $CustomerId,
		'SalemanId'	=> $SalemanChartOfAccountId,
		'ChartOfAccountId' => $DebitChartOfAccountId,	
		'Debit' => $this->input->post('Amount')[$key],
		'Credit' => '0.00',
		'Detail' => $this->input->post('ProductName')[$key] . " " . "Quantity of: " . " " .$this->input->post('Quantity')[$key],
		);
			
		$this->db->insert('pos_accounts_generaljournal_entries', $CreditTransactionDetail);
		
	
		/// If Sale Type is On Credit, CustomerId Chart of Account will be credit else Cash Balance Chart of Account will be credit

		$CreditChartOfAccountId = 0;
		if($this->input->post('SaleReturnType') == "1")
		{
		   $CreditChartOfAccountId = $CashChartOfAccountId;	  
		}
		
		if($this->input->post('SaleReturnType') == "2")
		{ 
		   $CreditChartOfAccountId = $CustomerChartOfAccountId;
        }

		if($this->input->post('SaleReturnType') == "3")
		{ 
		   $CreditChartOfAccountId = $BankChartOfAccountId;
        }
		// end of code
		  
		// Following script is entering credit side entry
		$CrediTransactionDetail = array(
			'GeneralJournalId' => $GeneralJournalId,
		    'CustomerId' => $CustomerId,
			'SalemanId'	=> $SalemanChartOfAccountId,
			'ChartOfAccountId' => $CreditChartOfAccountId,
			'Credit'   => $this->input->post('Amount')[$key],
			'Debit' => '0.00',
			'Detail'    =>  $this->input->post('ProductName')[$key] . " " . "Quantity of: " . " " .$this->input->post('Quantity')[$key] . "  Rate: " . $this->input->post('Rate')[$key],
		);	
		
	        $this->db->insert('pos_accounts_generaljournal_entries', $CrediTransactionDetail);		
	    }  
	  
	      return $SaleReturnId;
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
	
	 public function UpdateSalesReturn()
	 {
	      date_default_timezone_set('Asia/Karachi');
	    $CustomerVal = $this->input->post('CustomerId');
		$IdArr = explode("-", $CustomerVal);
		$CustomerId = $IdArr[0];
		$CustomerChartOfAccountId = $IdArr[1];

	    $BankAccountVal = $this->input->post('BankAccountId');
		$IdArr = explode("-", $BankAccountVal);
		$BankAccountId = $IdArr[0];
		$BankChartOfAccountId = $IdArr[1];

		$SalemanVal =$this->input->post('SalemanId');
		$IdArrSaleman = explode("-", $SalemanVal);
		$SalemanId = $IdArrSaleman[0];
		$SalemanChartOfAccountId = $IdArrSaleman[1];
		  
	    $SaleReturnId = $this->input->post('SaleReturnId');
	    
	  //  $Record = $this->input->post();
	    $TotalAmount = array_sum($this->input->post('Amount'));
	
	    $SaleReturn = array(
	    'SaleReturnType'    => $this->input->post('SaleReturnType'),
	    'AccountId' => $this->input->post('BankAccountId'),
		'SalemanId' => $SalemanId,
	    'CustomerId' => $CustomerId,
	    'ReferenceId'   => $this->input->post('ReferenceId'),
	    'SaleReturnDate' => date('Y-m-d H:i:s', strtotime($this->input->post('SaleReturnDate'))),
	    'TotalAmount' => $TotalAmount,
	    'SaleReturnNote'    => $this->input->post('SaleReturnNote'),	
	    'AddedOn' => date('Y-m-d H:i:s'),
	    'AddedBy' => $this->session->userdata('EmployeeId'),
	    );

	    // Update Sale Record
	    $this->db->where('pos_sales_return.SaleReturnId', $SaleReturnId);
	    $this->db->update('pos_sales_return', $SaleReturn);
	    
	     // Remove Sale Detail Record Before I  nserting New Record
	    $this->db->where('pos_stocks_detail.SaleReturnId', $SaleReturnId);
	    $this->db->delete('pos_stocks_detail');
	    
	    // Remove Stock Detail Record Before Inserting New Record
	    $this->db->where('pos_sales_return_detail.SaleReturnId', $SaleReturnId);
	    $this->db->delete('pos_sales_return_detail');
	    
	    
	    $ProductId = $this->input->post('ProductId');	    
	
	    foreach($ProductId as $key => $value) 
	    {
		
		$SalesReturnDetail = array(
		'SaleReturnId' => $SaleReturnId,
		'ProductId'  => $this->input->post('ProductId')[$key],
		'LocationId'  => $this->input->post('LocationId')[$key],
		//'ColourId'  => $this->input->post('ColourId')[$key],
		'Quantity'    => $this->input->post('Quantity')[$key],
		'Rate'    => $this->input->post('Rate')[$key],
		'Amount'   => $this->input->post('Amount')[$key],
		'DiscountAmount'   => $this->input->post('DiscountAmount')[$key],
		'TaxPercentage'   => $this->input->post('TaxPercentage')[$key],
		'TaxAmount'   => $this->input->post('TaxAmount')[$key],
		'NetAmount'   => $this->input->post('NetAmount')[$key],
		);
		
	        $this->db->insert('pos_sales_return_detail', $SalesReturnDetail);
	    }
	    
	    // Following sale detail enters into stock details table
	    foreach($ProductId as $key=>$value) 
	    {    
		/*$CustomerVal =$this->input->post('CustomerId')[$key];
		$IdArr = explode("-", $CustomerVal);
		$CustomerId = $IdArr[0];
		*/
	      $SaleReturnStock = array( 
	      'CustomerId' => $CustomerId,
	      'SaleReturnId' => $SaleReturnId,
	      'ProductId' => $this->input->post('ProductId')[$key],
	      'LocationId' => $this->input->post('LocationId')[$key],
	      //'ColourId' => $this->input->post('ColourId')[$key],
	      'Rate' => $this->input->post('Rate')[$key],
	      'Quantity' => $this->input->post('Quantity')[$key],
	      'Amount'=> $this->input->post('Amount')[$key],
	      'NetAmount' => $this->input->post('Amount')[$key],
	      'StockType' => 4,	// 4 shows sale return stock
	      'InOutDate' => date('Y-m-d', strtotime($this->input->post('SaleReturnDate'))),
	      'Comments' => $this->input->post('Comments')[$key], 
	      'AddedBy' => $this->session->userdata('EmployeeId'),
	      'AddedOn' => date('Y-m-d H:i:s'),
              );	    
		
              // Insert into Stocks Detail table
	    $this->db->insert('pos_stocks_detail', $SaleReturnStock);
            }

	   
	    // insert into accounts generaljournal and its detail table
	    
	    // Getting Cash Balance chart of account from setting table
/*	    $this->db->select('ChartOfAccountId');
	    $this->db->from('pos_setting');
	    $this->db->where('ComponentId', 4);
	    $this->db->where('TransactionTypeId', 7);
	    $query = $this->db->get()->row();
	    $CashChartOfAccountId = $query->ChartOfAccountId;
	    */
	    $CashChartOfAccountId = 1;
	    
	    // Getting Sale Account Customer chart of account from setting table
/*	    $this->db->select('ChartOfAccountId');
	    $this->db->from('pos_setting');
	    $this->db->where('ComponentId', 4);
	    $this->db->where('TransactionTypeId', 4);
	    $query = $this->db->get()->row();
	    $SaleReturnChartOfAccountId = $query->ChartOfAccountId;
	    */
	    $SaleReturnChartOfAccountId = 5;
	    
	    
	    // SaleType = 1 is On Cash and SaleType = 2 is On Credit
	    // Voucher Type 1 = CPV, Voucher Type 2 = BPV,  Voucher Type 3 = CRV, Voucher Type 4 = BRV, Voucher Type 5 = JV,
	    // 
	    // When sale returns type is on cash, it generatees CPV and showing that customer purchased item on cash and now has to return product on Cash so cash will be credit
	    if($this->input->post('SaleReturnType') == "1")
	    {
		$DebitChartOfAccountId = $SaleReturnChartOfAccountId;
	    }
	   
	    // When sale returns is on credit, it generatees JV and shows last time customer purchased products on credit
	    if($this->input->post('SaleReturnType') == "2")
	    {
		$DebitChartOfAccountId = $SaleReturnChartOfAccountId;
	    }

	    if($this->input->post('SaleReturnType') == "3")
	    {
		$DebitChartOfAccountId = $SaleReturnChartOfAccountId;
	    }


	    $DebitAmount = array_sum($this->input->post('NetAmount'));
	    $CreditAmount = array_sum($this->input->post('NetAmount'));
	    
	     // EntryType = 1 shows auto voucher created
	    $Transactions = array(
	    'SaleReturnId' => $SaleReturnId,
	    'TransactionDate' => date('Y-m-d', strtotime($this->input->post('SaleReturnDate'))),
	    'TotalDebit' => $DebitAmount,
	    'TotalCredit' => $CreditAmount,
	    'AddedOn' => date('Y-m-d H:i:s'),
	    'AddedBy' => $this->session->userdata('EmployeeId'),
	    );
	    
	     $this->db->where('pos_accounts_generaljournal.SaleReturnId', $SaleReturnId);
	     $this->db->update('pos_accounts_generaljournal', $Transactions);

	   
	    // Gets GeneralJournal Id
	    $this->db->select('GeneralJournalId');
	    $this->db->from('pos_accounts_generaljournal');
	    $this->db->where('pos_accounts_generaljournal.SaleReturnId', $SaleReturnId);
	    $query = $this->db->get()->row();
	    $GeneralJournalId = $query->GeneralJournalId;
	    	     
	    // Remove Record from pos_accounts_generaljournal_entries Before Inserting New Record
	    $this->db->where('pos_accounts_generaljournal_entries.GeneralJournalId', $GeneralJournalId);
	    $this->db->delete('pos_accounts_generaljournal_entries');
	    
	    
	    foreach($ProductId as $key=>$value) 
	    {
/*		$CustomerVal =$this->input->post('CustomerId');
		$IdArr = explode("-", $CustomerVal);
		$CustomerId = $IdArr[0];
		$CustomerChartOfAccountId = $IdArr[1];*/
		
		// Following script is entering debit side entry
		$DebitTransactionDetail = array(
		'GeneralJournalId' => $GeneralJournalId,
		'CustomerId' => $CustomerId,
		'SalemanId'	=> $SalemanChartOfAccountId,
		'ChartOfAccountId' => $DebitChartOfAccountId,	
		'Debit' => $this->input->post('Amount')[$key],
		'Credit' => '0.00',
		'Detail' => $this->input->post('ProductName')[$key] . " " . "Quantity of: " . " " .$this->input->post('Quantity')[$key],
		);
			
		$this->db->insert('pos_accounts_generaljournal_entries', $DebitTransactionDetail);
		
	
		/// If Sale Type is On Credit, CustomerId Chart of Account will be credit
		if($this->input->post('SaleReturnType') == "1")
		{ 
		   $CreditChartOfAccountId = $CashChartOfAccountId;
	        }

		if($this->input->post('SaleReturnType') == "2")
		{
		   $CreditChartOfAccountId =  $CustomerChartOfAccountId;	  
		}

		if($this->input->post('SaleReturnType') == "3")
		{
		   $CreditChartOfAccountId = $BankChartOfAccountId;
        }

		// end of code
		  
		//$DebitChartOfAccountId = 1;

		// Following script is entering credit side entry
		$CrediTransactionDetail = array(
		'GeneralJournalId' => $GeneralJournalId,
		'CustomerId' => $CustomerId,
		'SalemanId'	=> $SalemanChartOfAccountId,
		'ChartOfAccountId' => $CreditChartOfAccountId,
		'Credit'   => $this->input->post('Amount')[$key],
		'Debit' => '0.00',
		'Detail'    =>  $this->input->post('ProductName')[$key] . " " . "Quantity of: " . " " .$this->input->post('Quantity')[$key] . "  Rate: " . $this->input->post('Rate')[$key],
		);	
		
	        $this->db->insert('pos_accounts_generaljournal_entries', $CrediTransactionDetail);		
	    }
	  
	      return $SaleReturnId;
	}

    function EditSalesReturn($SaleReturnId,$colums='*')
    {             
            $this->db->select($colums);
            $this->db->select('*');
            $this->db->from('pos_sales_return');
//            $this->db->join('pos_sales','pos_sales.ChartOfAccountsId = pos_sales.ChartOfAccountsId');
            $this->db->where('SaleReturnId',$SaleReturnId);
            $ResultSalesEntries = $this->db->get()->result_array();
            $Result = array('GeneralJournal'=>$ResultSales,'GeneralJournalEntries'=>$ResultGeneralJournalEntries);
            return $Result;
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
    

    public function GenerateSalesReturnNo()
        {
	    $this->db->select("SaleReturnNo");
	    $this->db->from('pos_sales_return');
	    $this->db->order_by('SaleReturnId', 'DESC');
	    $this->db->limit('1');
	    $query = $this->db->get();
	    if ($query->num_rows() > 0)
	    {
		$row = $query->row();
		$RNo = $row->SaleReturnNo;

		$iSplit = explode("SR", $RNo);
		$data['SaleReturnNo'] = $iSplit[1];

		$SaleReturnNo = $data['SaleReturnNo'] + 1;
		$Prefix = 'SR';
		$NewSaleReturnNo = $Prefix.''.$SaleReturnNo;
		return $NewSaleReturnNo;
	    }
	    else
	    {
		$Prefix = 'SR';
		$SaleReturnNo = 1;
		$NewSaleReturnNo = $Prefix.''.$SaleReturnNo;
		return $NewSaleReturnNo;
	    } 
	}
  

  	public function BPVReferenceNo()
  	{
	    $this->db->select("Reference");
	    $this->db->from('pos_accounts_generaljournal');
	    $this->db->where('VoucherType', 2);
	    $this->db->order_by('GeneralJournalId', 'DESC');
      	$this->db->limit('1');
      	$query = $this->db->get();
      	if ($query->num_rows() > 0)
      	{
	      	$row = $query->row();
	      	$RNo = $row->Reference;

      		$iSplit = explode("BPV", $RNo);
      		$data['Reference'] = $iSplit[1];

      		$ReferenceNo = $data['Reference'] + 1;
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
  
  function GetLastSalesReturn($InvoiceNo, $CustomerId)
	{
	    $this->db->select('pos_sales_return.AddedOn');
	    $this->db->from('pos_sales_return');
	    $this->db->where(['SaleReturnId' => $InvoiceNo,'CustomerId' => $CustomerId]);
	    $query = $this->db->get();
	    $data = $query->row();	
		
	    $currentDate = date('Y-m-d H:i:s');
	    $checkLastSale = (array) $data;
	    // check last invoice
	    $this->db->select('pos_sales_return.AddedOn');
	    $this->db->from('pos_sales_return');
	    $this->db->where(['CustomerId' => $CustomerId]);
	    $this->db->where('AddedOn <', $checkLastSale['AddedOn']);
	    $inv = $this->db->get();
	    return $inv->row();	
	}
	
	public function SaleInvoiceReportDetails($InvoiceNo)
	{
		$this->db->select('*');
		$this->db->from('pos_sales_return');
		$this->db->join('pos_sales_return_detail', 'pos_sales_return_detail.SaleId = pos_sales_return.SaleId', 'left');
		$this->db->join('pos_products', 'pos_products.ProductId = pos_sales_return_detail.ProductId', 'left');
		$this->db->join('pos_locations', 'pos_locations.LocationId = pos_sales_return_detail.LocationId','left');
		$this->db->join('pos_product_colours', 'pos_product_colours.ColourId = pos_sales_return_detail.ColourId', 'left');
		$this->db->join('pos_category', 'pos_category.CategoryId = pos_products.CategoryId','left');
		$this->db->join('pos_productgroup', 'pos_productgroup.ProductGroupId = pos_products.ProductGroupId', 'left');
		$this->db->join('pos_brands', 'pos_brands.BrandId = pos_products.BrandId', 'left');
		if($InvoiceNo) { $this->db->where('pos_sales.SaleId', $InvoiceNo); }
		$query = $this->db->get();
		return $query->result_array();
	}

}
?>