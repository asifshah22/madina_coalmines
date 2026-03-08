<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Sale_model extends CI_Model{
	
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
		$this->tbl_saleman = "pos_saleman";
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


    public function Ajax_GetAllSales($requestData)
    {
       	$columns = array( 
            0 => 'SaleId',
            1 => 'SaleNo',
            2 => 'SaleType',
            3 => 'SaleDate',
            4 => 'TotalAmount',
	        5 => 'CustomerId',
            6 => 'fbr_customer',
            7 => 'fbr_mobile',
			8 => 'SalemanName',
        );
        $sql = "SELECT 
            pos_sales.*,
            pos_customer.CustomerName,
            pos_saleman.SalemanName,
           CASE 
            WHEN EXISTS (
                SELECT 1 
                FROM pos_accounts_generaljournal ag
                INNER JOIN pos_accounts_generaljournal_entries age 
                    ON age.GeneralJournalId = ag.GeneralJournalId
                WHERE ag.SaleUniqueId = pos_sales.SaleId
                  AND ag.CustomerId = pos_sales.CustomerId
            ) 
            THEN 1 ELSE 0 
        END AS has_invoice
        FROM pos_sales
        INNER JOIN pos_customer 
            ON pos_customer.CustomerId = pos_sales.CustomerId
        LEFT JOIN pos_saleman 
            ON pos_saleman.SalemanId = pos_sales.SalemanId";
        
//             $sql = "SELECT *";
//             $sql.=" FROM pos_sales";
//             $sql.=" INNER JOIN pos_customer ON pos_customer.CustomerId = pos_sales.CustomerId ";
// 			$sql.=" LEFT JOIN pos_saleman ON pos_saleman.SalemanId = pos_sales.SalemanId ";

            $query= $this->db->query($sql); 
            $totalData = $query->num_rows();
            $totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.
            $sql.=" WHERE 1=1 ";
                if( !empty($requestData['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter
		         $sql.=" AND (SaleId LIKE '".$requestData['search']['value']."%' ";
		         $sql.=" OR pos_customer.CustomerName LIKE '".$requestData['search']['value']."%' ";
				 $sql.=" OR pos_saleman.SalemanName LIKE '".$requestData['search']['value']."%' ) ";
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

	function GetSales($SaleId)
	{
	    $this->db->select('*,pos_sales.AddedOn');
	    $this->db->from($this->tbl_sales);
	   	$this->db->join($this->tbl_customer, $this->tbl_customer.'.CustomerId = '.$this->tbl_sales.'.CustomerId', 'left');
		$this->db->join($this->tbl_saleman, $this->tbl_saleman.'.SalemanId = '.$this->tbl_sales.'.SalemanId', 'left');
	   	$this->db->join($this->tbl_bank_accounts, $this->tbl_bank_accounts.'.AccountId = '.$this->tbl_sales.'.AccountId', 'left');
	   	$this->db->join($this->tbl_reference, $this->tbl_reference.'.ReferenceId = '.$this->tbl_sales.'.ReferenceId', 'left');
	    $this->db->where('pos_sales.SaleId',$SaleId);
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
	
	
	function GetSalesDetail($SaleId)
	{
	    $this->db->select('*,pos_sales_detail.ProductBarCode');
	    $this->db->from($this->tbl_sales);  
	    $this->db->join($this->tbl_sales_detail, $this->tbl_sales_detail.'.SaleId = '.$this->tbl_sales.'.SaleId');
	    $this->db->join($this->tbl_products, $this->tbl_products.'.ProductId = '.$this->tbl_sales_detail.'.ProductId');
	    $this->db->join($this->tbl_locations, $this->tbl_locations.'.LocationId = '.$this->tbl_sales_detail.'.LocationId','left');
	    $this->db->join($this->tbl_product_colours, $this->tbl_product_colours.'.ColourId = '.$this->tbl_sales_detail.'.ColourId','left');
	    $this->db->where('pos_sales_detail.SaleId',$SaleId);
	    $query = $this->db->get();
	    return $query->result_array();
	}
	
	function GetCashDetails($SaleId)
	{
	    $this->db->select('pos_accounts_generaljournal_entries.Debit');
	    $this->db->from($this->tbl_sales);  
	    $this->db->join($this->tbl_generaljournal, $this->tbl_generaljournal.'.SaleId = '.$this->tbl_sales.'.SaleId');
		$this->db->join($this->tbl_generaljournal_entries, $this->tbl_generaljournal_entries.'.GeneralJournalId  = '.$this->tbl_generaljournal.'.GeneralJournalId');
	    $this->db->where('pos_sales.SaleId',$SaleId);
		$this->db->where('pos_accounts_generaljournal_entries.ChartOfAccountId',1);
	    $query = $this->db->get();
	    return $query->result_array();
	}
	
	public function SaveSaleDetail()
	{
// print_r($this->input->post());
// die();
	     date_default_timezone_set('Asia/Karachi');
	    $CustomerVal =$this->input->post('CustomerId');
		$IdArr = explode("-", $CustomerVal);
		$CustomerId = $IdArr[0];

		$SalemanVal =$this->input->post('SalemanId');
		$IdArrSaleman = explode("-", $SalemanVal);
		$SalemanId = $IdArrSaleman[0];
		$SalemanChartOfAccountId = $IdArrSaleman[1];

	    $TotalAmount = array_sum($this->input->post('NetAmount'));
	    
	    $BankAccountId = $this->input->post('BankAccountId');
	
	    $Sale = array(
	    'AccountId' => $this->input->post('BankAccountId'),
	    'CustomerId' => $CustomerId,
	    'ReferenceId' => $this->input->post('ReferenceId'),
		'SalemanId' => $SalemanId,
	    'Counter' => $this->input->post('Counter'),
	    'SaleStatus'    => $this->input->post('SaleStatus'),
	    'SaleType'    => $this->input->post('SaleType'),
	    'SaleMethod' => $this->input->post('SaleMethod'),
	    'SaleDate' => date('Y-m-d H:i:s', strtotime($this->input->post('SaleDate'))),
	    'TotalAmount' => $TotalAmount,
	    'SaleNote'    => $this->input->post('SaleNote'),
	    'WalkinCustomer'    => $this->input->post('CustomerName'),
	    'MobileNumber'    => $this->input->post('CellNo'),
	    'AddedOn' => date('Y-m-d H:i:s'),
	    'AddedBy' => $this->session->userdata('EmployeeId'),
	    'TotalDiscount' => $this->input->post('TotalTaxAmount'),
	    'PreviousBalance' => $TotalAmount - $this->input->post('TotalTaxAmount') - $this->input->post('cash_received'),
	    'VehicleNo'    => $this->input->post('VehicleNo'),
	    'Scenario_Type'=> $this->input->post('ScenarioType'),
	    'fbr_cnic'    => $this->input->post('fbr_cnic'),
	    'fbr_ntn'    => $this->input->post('fbr_ntn'),
	    'fbr_customer'    => $this->input->post('fbr_customer'),
	    'fbr_mobile'    => $this->input->post('fbr_mobile'),
	     'PODate'    => $this->input->post('PODate'),
	      'isQuatation'    => $this->input->post('isQuatation'),
	      
	     'wh_tax_percent'    => $this->input->post('wh_tax_percent'),
	      'wh_tax_amount'    => $this->input->post('wh_tax_amount'),
	    );

	    $this->db->insert('pos_sales', $Sale);
	    $SaleId = intval($this->db->insert_id());

	    $ProductId = $this->input->post('hdnProductName');    
	
	    foreach($ProductId as $key => $value) 
	    {
/*		$CustomerVal = $this->input->post('CustomerId');
		$IdArr = explode("-", $CustomerVal);
		$CustomerId = $IdArr[0];  */
		
		$SalesDetail = array(
		'SaleId' => $SaleId,
		'ProductBarCode'  => $this->input->post('ProductBarCode')[$key],
		'ProductId'  => $this->input->post('hdnProductName')[$key],
		'LocationId'  => $this->input->post('LocationId')[$key],
		// 'ColourId'  => $this->input->post('ColourId')[$key],
		'Quantity'    => $this->input->post('Quantity')[$key],
		'Rate'    => $this->input->post('Rate')[$key],
		'EngineNo'    => $this->input->post('EngineNo')[$key],
		'ChassisNo'    => $this->input->post('ChassisNo')[$key],
		'DiscountAmount'   => $this->input->post('DiscountAmount')[$key],
		'Amount'   => $this->input->post('Amount')[$key],
		'TaxPercentage'   => $this->input->post('TaxPercentage')[$key],
		'TaxAmount'   => $this->input->post('TaxAmount')[$key],
		'NetAmount'   => $this->input->post('NetAmount')[$key],
		'FurtherTaxRate'   => $this->input->post('FurtherTaxRate')[$key],
		'FurtherTaxAmt'   => $this->input->post('FurtherTaxAmt')[$key],
		);
		
		//echo '<pre>';
		//print_r($SalesDetail);
		
	        $this->db->insert('pos_sales_detail', $SalesDetail);
	    }
	    
	    // Following sale detail enters into stock details table
	    foreach($ProductId as $key=>$value) 
	    {    
		/*$CustomerVal =$this->input->post('CustomerId');
		$IdArr = explode("-", $CustomerVal);
		$CustomerId = $IdArr[0];*/
		
	      $SoldStock = array( 
	      'CustomerId' => $CustomerId,
	      'SaleId' => $SaleId,
	      'ProductId' => $this->input->post('hdnProductName')[$key],
	      'LocationId' => $this->input->post('LocationId')[$key],
	    //   'ColourId' => $this->input->post('ColourId')[$key],
	      'Rate' => $this->input->post('Rate')[$key],
	      'Quantity' => $this->input->post('Quantity')[$key],
	      'DiscountAmount' => $this->input->post('DiscountAmount')[$key],
	      'Amount'=> $this->input->post('Amount')[$key],
	      'NetAmount' => $this->input->post('NetAmount')[$key],
	      'StockType' => 3, // StockType 3 means Sale Transaction
	      'InOutDate' => date('Y-m-d', strtotime($this->input->post('SaleDate'))),
	      'Comments' => $this->input->post('SaleNote'),
	      'AddedBy' => $this->session->userdata('EmployeeId'),
	      'AddedOn' => date('Y-m-d H:i:s'),
              );
		
              // Insert into Stocks Detail table
	      $this->db->insert('pos_stocks_detail', $SoldStock);
            }
	    
	    // insert into accounts generaljournal and its detail table
	    
	    // Gets Cash Balance chart of account from setting table
	    $this->db->select('ChartOfAccountId');
	    $this->db->from('pos_accounts_chartofaccount');
	    $this->db->where('ChartOfAccountCategoryId', 1);
	    $this->db->where('ChartOfAccountControlId', 1);
	    $query = $this->db->get()->row();
	    $CashChartOfAccountId = $query->ChartOfAccountId;
	    
	    // Gets Sale Account Customer chart of account from setting table
	    $this->db->select('ChartOfAccountId');
	    $this->db->from('pos_accounts_chartofaccount');
	    $this->db->where('ChartOfAccountCategoryId', 3);
	    $this->db->where('ChartOfAccountControlId', 6);
	    $query = $this->db->get()->row();
	    $SaleAccountChartOfAccountId = $query->ChartOfAccountId;
	    
	    $DebitAmount = array_sum($this->input->post('NetAmount'));
	    $CreditAmount = array_sum($this->input->post('NetAmount'));
	    
	    
	    // SaleType = 1 is On Cash and SaleType = 2 is On Credit and 3 is online
	    // If Sale Type is On Credit, Customer Chart of Account will be debited.
	    // Voucher Type 1 = CPV, Voucher Type 2 = BPV, Voucher Type 3 = CRV, Voucher Type 4 = BRV, Voucher Type 5 = JV 
	    if($this->input->post('SaleType') == "1")
	    {
			$CreditChartOfAccountId = $SaleAccountChartOfAccountId;
			$VoucherType = 3;
	 		$ReferenceNo = $this->CRVReferenceNo();
	    }
	    
	    if($this->input->post('SaleType') == "2")
	    {		
			$CreditChartOfAccountId = $SaleAccountChartOfAccountId;
			$VoucherType = 5;
			$ReferenceNo = $this->JVReferenceNo();
	    }	
	    
	    if($this->input->post('SaleType') == "3")
	    {		
			$CreditChartOfAccountId = $SaleAccountChartOfAccountId;
			$VoucherType = 4;
			$ReferenceNo = $this->BRVReferenceNo();
	    }
	    
	    // $BankAccountId
		    
	    
	    // EntryType = 1 shows auto voucher created
	    $Transactions = array(
	    'SaleId' => $SaleId,
	    'EntryType' => 1,
	    'VoucherType' => $VoucherType,
	    'Reference' => $ReferenceNo,
	    'TransactionDate' => date('Y-m-d', strtotime($this->input->post('SaleDate'))),
	    'TotalDebit' => $DebitAmount,
	    'TotalCredit' => $CreditAmount,
	    'AddedOn' => date('Y-m-d H:i:s'),
	     'CustomerId' => $CustomerId,
	    'AddedBy' => $this->session->userdata('EmployeeId'),
	    );

	    $this->db->insert('pos_accounts_generaljournal', $Transactions);
	    $GeneralJournalId = intval($this->db->insert_id());
	    
	    // Add Cash Reciept Voucher
		if($this->input->post('cash_received') != 0){
			$CashReceipt = array(
				'SaleId' => $SaleId,
				'EntryType' => 1,
				'VoucherType' => 3,
				'Reference' => $this->CRVReferenceNo(),
				'TransactionDate' => date('Y-m-d', strtotime($this->input->post('SaleDate'))),
				'TotalDebit' => $DebitAmount,
				'TotalCredit' => $CreditAmount,
				'AddedOn' => date('Y-m-d H:i:s'),
				'AddedBy' => $this->session->userdata('EmployeeId'),
				);
		
			$this->db->insert('pos_accounts_generaljournal', $CashReceipt);
			$GeneralJournalCashId = intval($this->db->insert_id());
		}
	    	    
	    foreach($ProductId as $key=>$value) 
	    {
	        
	        	        	// Following script is entering debit side entry
		$DebitTransaction = array(
		'GeneralJournalId' => $GeneralJournalId,
		'ChartOfAccountId' => 3,
		'Debit' => $this->input->post('TaxPercentage')[$key],
		'Credit' => '0.00',
		'Detail' => "GST Amount",
		);

		$this->db->insert('pos_accounts_generaljournal_entries', $DebitTransaction);
		
			// Following script is entering credit side entry
		$CreditTransaction = array(
		'GeneralJournalId' => $GeneralJournalId,
		'ChartOfAccountId' => 1125,
		'Debit'   => '0.00',
		'Credit' => $this->input->post('TaxPercentage')[$key],
		'Detail' =>"GST Amount",
		);

	        $this->db->insert('pos_accounts_generaljournal_entries', $CreditTransaction);
	    	$CustomerChartOfAccountId = "";
	    	if($this->input->post('CustomerId') != "0"){
				$CustomerVal = $this->input->post('CustomerId');
				$IdArr = explode("-", $CustomerVal);
				$CustomerId = $IdArr[0];
				$CustomerChartOfAccountId = $IdArr[1];
			}
		
		if($this->input->post('SaleType') == "1")
		{
		    $DebitChartOfAccountId = $CashChartOfAccountId;
		}
		
		if($this->input->post('SaleType') == "2")
		{
		    $DebitChartOfAccountId = $CustomerChartOfAccountId;
		}
		
		if($this->input->post('SaleType') == "3")
		{
		    $DebitChartOfAccountId = $BankAccountId;
		}
		
		
		// Following script is entering debit side entry
		$DebitTransactionDetail = array(
		'GeneralJournalId' => $GeneralJournalId,
		'CustomerId' => $CustomerId,
		'SalemanId'	=> $SalemanChartOfAccountId,
		'ChartOfAccountId' => $DebitChartOfAccountId,
		'Debit'   => $this->input->post('NetAmount')[$key],
		'Credit' => '0.00',
		'Detail'  =>  $this->input->post('ProductName')[$key] . " " . "Quantity of: " . " " .$this->input->post('Quantity')[$key] . " Rate: " .$this->input->post('Rate')[$key],
		);
	        $this->db->insert('pos_accounts_generaljournal_entries', $DebitTransactionDetail);
		
		
		// Following script is entering credit side entry
		$CreditTransactionDetail = array(
		'GeneralJournalId' => $GeneralJournalId,
		'CustomerId' => $CustomerId,
		'SalemanId'	=> $SalemanChartOfAccountId,
		'ChartOfAccountId' => $CreditChartOfAccountId,
		'Debit'   => '0.00',
		'Credit' => $this->input->post('NetAmount')[$key],
		'Detail'  => $this->input->post('ProductName')[$key] . " " . "Quantity of: " . " " .$this->input->post('Quantity')[$key],
		);		
		$this->db->insert('pos_accounts_generaljournal_entries', $CreditTransactionDetail);
		
		// Add Cash Reciept Voucher
		if($this->input->post('cash_received') != 0){
		// Following script is entering debit side entry
		$DebitTransactionDetailCash = array(
		'GeneralJournalId' => $GeneralJournalCashId,
		'CustomerId' => $CustomerId,
		'SalemanId'	=> $SalemanChartOfAccountId,
		'ChartOfAccountId' => $DebitChartOfAccountId,
		'Debit'   => '0.00',
		'Credit' => $this->input->post('cash_received'),
		'Detail'  =>  "",
		);
		$this->db->insert('pos_accounts_generaljournal_entries', $DebitTransactionDetailCash);


		// Following script is entering credit side entry
		$CreditTransactionDetailCash = array(
		'GeneralJournalId' => $GeneralJournalCashId,
		'CustomerId' => $CustomerId,
		'SalemanId'	=> $SalemanChartOfAccountId,
		'ChartOfAccountId' => 1,
		'Debit'   => $this->input->post('cash_received'),
		'Credit' => '0.00',
		'Detail'  => "",
		);		
		$this->db->insert('pos_accounts_generaljournal_entries', $CreditTransactionDetailCash);	
		}

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

	
	public function UpdateSaleDetail()
	{
	    $SaleId = $this->input->post('SaleId');
	    $DiscountAmount = array_sum($this->input->post('DiscountAmount'));
	    $NetAmount = array_sum($this->input->post('NetAmount'));

// 		$SalemanVal =$this->input->post('SalemanId');
// 		$IdArrSaleman = explode("-", $SalemanVal);
// 		$SalemanId = $IdArrSaleman[0];
// 		$SalemanChartOfAccountId = $IdArrSaleman[1];
	
	$SalemanVal = $this->input->post('SalemanId'); // e.g. "12-45"
$IdArrSaleman = explode("-", $SalemanVal);

$SalemanId = isset($IdArrSaleman[0]) ? $IdArrSaleman[0] : null;
$SalemanChartOfAccountId = isset($IdArrSaleman[1]) ? $IdArrSaleman[1] : null;

	    $BankAccountId = $this->input->post('BankAccountId');
		    
	    $Sale = array(
	    	'AccountId' => $this->input->post('BankAccountId'),
			'SalemanId' => $SalemanId,
			'CustomerId' => $this->input->post('CustomerId'),
			'ReferenceId' => $this->input->post('ReferenceId'),
			'Counter' => $this->input->post('Counter'),
			'SaleStatus'    => $this->input->post('SaleStatus'),
		    'SaleType' => $this->input->post('SaleType'),
		    'SaleMethod' => $this->input->post('SaleMethod'),
		    'SaleDate' => date('Y-m-d H:i:s', strtotime($this->input->post('SaleDate'))), 
		    'TotalAmount' => $NetAmount,
		    'SaleNote'    => $this->input->post('SaleNote'),
		   	'WalkinCustomer'    => $this->input->post('CustomerName'),
	    	'MobileNumber'    => $this->input->post('CellNo'),
		    'AddedOn' => date('Y-m-d H:i:s'),
		    'AddedBy' => $this->session->userdata('EmployeeId'),
		    'VehicleNo'    => $this->input->post('VehicleNo'),
		    'fbr_cnic'    => $this->input->post('fbr_cnic'),
	    'fbr_ntn'    => $this->input->post('fbr_ntn'),
	    'fbr_customer'    => $this->input->post('fbr_customer'),
	    'fbr_mobile'    => $this->input->post('fbr_mobile'),
	     'Scenario_Type'=> $this->input->post('ScenarioType'),
	      'PODate'    => $this->input->post('PODate'),
	      'isQuatation'    => $this->input->post('isQuatation'),
	      'wh_tax_percent'    => $this->input->post('wh_tax_percent'),
	      'wh_tax_amount'    => $this->input->post('wh_tax_amount'),
	    );
	    
	    
	    // Update Sale Record
	    $this->db->where('pos_sales.SaleId', $SaleId);
	    $this->db->update('pos_sales', $Sale);
	    
	    // Remove Sale Detail Record Before Inserting New Record
	    $this->db->where('pos_stocks_detail.SaleId', $SaleId);
	    $this->db->delete('pos_stocks_detail');
	    
	    // Remove Stock Detail Record Before Inserting New Record
	    $this->db->where('pos_sales_detail.SaleId', $SaleId);
	    $this->db->delete('pos_sales_detail');
	    
	    $ProductId = $this->input->post('ProductId');
	    
	    foreach($ProductId as $key => $value) 
	    {
		$CustomerVal =$this->input->post('CustomerId');
		$IdArr = explode("-", $CustomerVal);
		$CustomerId = $IdArr[0];

		$SalesDetail = array(
		'SaleId' => $SaleId,
		'ProductId'  => $this->input->post('ProductId')[$key],
			'ProductBarCode'  => $this->input->post('ProductBarCode')[$key],
		'LocationId'  => $this->input->post('LocationId')[$key],
		// 'ColourId'  => $this->input->post('ColourId')[$key],
		'Quantity'    => $this->input->post('Quantity')[$key],
		'Rate'    => $this->input->post('Rate')[$key],
		'EngineNo'    => $this->input->post('EngineNo')[$key],
		'ChassisNo'    => $this->input->post('ChassisNo')[$key],
		'DiscountAmount'  => $this->input->post('DiscountAmount')[$key],
		'Amount'   => $this->input->post('Amount')[$key],
		'TaxPercentage'   => $this->input->post('TaxPercentage')[$key],
		'TaxAmount'   => $this->input->post('TaxAmount')[$key],
		'NetAmount'   => $this->input->post('NetAmount')[$key], 
		
		'FurtherTaxRate'   => $this->input->post('FurtherTaxRate')[$key],
		'FurtherTaxAmt'   => $this->input->post('FurtherTaxAmt')[$key], 
		);
// 		print_r($SalesDetail);
	        $this->db->insert('pos_sales_detail', $SalesDetail);
	    }

	    // Following code insert record into stock detail table
	    foreach($ProductId as $key=>$value) 
	    {  
		
/*		$CustomerVal =$this->input->post('CustomerId');
		$IdArr = explode("-", $CustomerVal);
		$CustomerId = $IdArr[0];*/
		
		$SoldStock = array( 
		'CustomerId' => $CustomerId,
		'SaleId' => $SaleId,
		'ProductId' => $this->input->post('ProductId')[$key],
		'LocationId' => $this->input->post('LocationId')[$key] != '' ? $this->input->post('LocationId')[$key] : '0',
		// 'ColourId' => $this->input->post('ColourId')[$key] != '' ? $this->input->post('ColourId')[$key] : '0',
		'Rate' => $this->input->post('Rate')[$key],
		'Quantity' => $this->input->post('Quantity')[$key],
		'DiscountAmount' => $this->input->post('DiscountAmount')[$key],
		'Amount'=> $this->input->post('Amount')[$key],
		'NetAmount' => $this->input->post('NetAmount')[$key],
		'StockType' => 3,
		'InOutDate' => date('Y-m-d', strtotime($this->input->post('SaleDate'))),
		// 'Comments' => $this->input->post('Comments')[$key], 
		'AddedBy' => $this->session->userdata('EmployeeId'),
		'AddedOn' => date('Y-m-d H:i:s'),
		);

              // Insert into Stocks Detail table
	      $this->db->insert('pos_stocks_detail', $SoldStock);
            }
	    
	  
	    
	    // Following code update record in accounts generaljournal and its detail table
	    
	    // Gets Cash Balance chart of account from setting table
	    $this->db->select('ChartOfAccountId');
	    $this->db->from('pos_accounts_chartofaccount');
	    $this->db->where('ChartOfAccountCategoryId', 1);
	    $this->db->where('ChartOfAccountControlId', 1);
	    $query = $this->db->get()->row();
	    $CashChartOfAccountId = $query->ChartOfAccountId;
	    
	    // Gets Sale Account Customer chart of account from setting table
	    $this->db->select('ChartOfAccountId');
	    $this->db->from('pos_accounts_chartofaccount');
	    $this->db->where('ChartOfAccountCategoryId', 3);
	    $this->db->where('ChartOfAccountControlId', 6);
	    $query = $this->db->get()->row();
	    $SaleAccountChartOfAccountId = $query->ChartOfAccountId;
	    
	    $DebitAmount = array_sum($this->input->post('NetAmount'));
	    $CreditAmount = array_sum($this->input->post('NetAmount'));
	    
	    // SaleType = 1 is On Cash and SaleType = 2 is On Credit
	    // Voucher Type 1 = CPV, Voucher Type 2 = BPV,  Voucher Type 3 = CRV, Voucher Type 4 = BRV, Voucher Type 5 = JV  
	     // EntryType = 1 shows auto voucher created
	    
	    
	    // SaleType = 1 is On Cash and SaleType = 2 is On Credit
	    // If Sale Type is On Credit, Customer Chart of Account will be debited.
	    // Voucher Type 1 = CPV, Voucher Type 2 = BPV, Voucher Type 3 = CRV, Voucher Type 4 = BRV, Voucher Type 5 = JV 
	    if($this->input->post('SaleType') == "1")
	    {
		$CreditChartOfAccountId = $SaleAccountChartOfAccountId;
		$VoucherType = 3;
	 	$ReferenceNo = $this->CRVReferenceNo();
	    }
	    
	    if($this->input->post('SaleType') == "2")
	    {		
		$CreditChartOfAccountId = $SaleAccountChartOfAccountId;
		$VoucherType = 5;
		$ReferenceNo = $this->JVReferenceNo();
	    }	
	    
	    if($this->input->post('SaleType') == "3")
	    {		
		$CreditChartOfAccountId = $SaleAccountChartOfAccountId;
		$VoucherType = 4;
		$ReferenceNo = $this->BRVReferenceNo();
	    }
	    
	    $Transactions = array(
	    'TransactionDate' => date('Y-m-d', strtotime($this->input->post('SaleDate'))),
	    'TotalDebit' => $NetAmount,
	    'TotalCredit' => $NetAmount,
	    'CustomerId' => $CustomerId,
	    'AddedOn' => date('Y-m-d H:i:s'),
	    'AddedBy' => $this->session->userdata('EmployeeId'),
	    );

	    $this->db->where('pos_accounts_generaljournal.SaleId', $SaleId);
	    $this->db->update('pos_accounts_generaljournal', $Transactions);
	    
	    
	    // Gets GeneralJournal Id
	    $this->db->select('GeneralJournalId');
	    $this->db->from('pos_accounts_generaljournal');
	    $this->db->where('pos_accounts_generaljournal.SaleId', $SaleId);
	    
	    $query = $this->db->get()->result_array();
		$GeneralJournalCashId = 0;
		if(count($query) < 2){
			// Add Cash Reciept Voucher
			if($this->input->post('cash_received') != 0){
				$CashReceipt = array(
					'SaleId' => $SaleId,
					'EntryType' => 1,
					'VoucherType' => 3,
					'Reference' => $this->CRVReferenceNo(),
					'TransactionDate' => date('Y-m-d', strtotime($this->input->post('SaleDate'))),
					'TotalDebit' => $DebitAmount,
					'TotalCredit' => $CreditAmount,
					'AddedOn' => date('Y-m-d H:i:s'),
					'AddedBy' => $this->session->userdata('EmployeeId'),
					);
			
				$this->db->insert('pos_accounts_generaljournal', $CashReceipt);
				$GeneralJournalCashId = intval($this->db->insert_id());
			}
		}
		// Remove Record from pos_accounts_generaljournal_entries Before Inserting New Record
		foreach($query as $GeneralJournalId){
			$this->db->where('pos_accounts_generaljournal_entries.GeneralJournalId', $GeneralJournalId['GeneralJournalId']);
			$this->db->delete('pos_accounts_generaljournal_entries');
		}
		
	    $ProductId = $this->input->post('ProductId');
	    
	    
	    foreach($ProductId as $key=>$value) 
	    {
	        
	        	// Following script is entering debit side entry
		$DebitTransaction = array(
		'GeneralJournalId' => $query[0]['GeneralJournalId'],
		'ChartOfAccountId' => 3,
		'Debit' => $this->input->post('TaxPercentage')[$key],
		'Credit' => '0.00',
		'Detail' => "GST Amount",
		);

		$this->db->insert('pos_accounts_generaljournal_entries', $DebitTransaction);
		
			// Following script is entering credit side entry
		$CreditTransaction = array(
		'GeneralJournalId' => $query[0]['GeneralJournalId'],
		'ChartOfAccountId' => 1125,
		'Debit'   => '0.00',
		'Credit' => $this->input->post('TaxPercentage')[$key],
		'Detail' =>"GST Amount",
		);

	        $this->db->insert('pos_accounts_generaljournal_entries', $CreditTransaction);

	    $CustomerChartOfAccountId = "";
	   	if($this->input->post('CustomerId') != "0"){
			$CustomerVal =$this->input->post('CustomerId');
			$IdArr = explode("-", $CustomerVal);
			$CustomerId = $IdArr[0];
			$CustomerChartOfAccountId = $IdArr[1];
		}
		
		if($this->input->post('SaleType') == "1")
		{
		    $DebitChartOfAccountId = $CashChartOfAccountId;
		}
		
		if($this->input->post('SaleType') == "2")
		{
		    $DebitChartOfAccountId = $CustomerChartOfAccountId;
		}

		if($this->input->post('SaleType') == "3")
		{
		    $DebitChartOfAccountId = $BankAccountId;
		}
		
		// Following script is entering debit side entry
		$DebitTransactionDetail = array(
		'GeneralJournalId' => $query[0]['GeneralJournalId'],
		'CustomerId' => $CustomerId,
		'SalemanId'	=> $SalemanChartOfAccountId,
		'ChartOfAccountId' => $DebitChartOfAccountId,
		'Debit'   => $this->input->post('NetAmount')[$key],
		'Credit' => '0.00',
		'Detail'  => $this->input->post('ProductName')[$key] . " " . "Quantity of: " . " " .$this->input->post('Quantity')[$key] . " Rate: " .$this->input->post('Rate')[$key],
		);
	        $this->db->insert('pos_accounts_generaljournal_entries', $DebitTransactionDetail);
		
		
		// Following script is entering credit side entry
		$CreditTransactionDetail = array(
		'GeneralJournalId' => $query[0]['GeneralJournalId'],
		'CustomerId' => $CustomerId,
		'SalemanId'	=> $SalemanChartOfAccountId,
		'ChartOfAccountId' => $SaleAccountChartOfAccountId,
		'Debit'   => '0.00',
		'Credit' => $this->input->post('NetAmount')[$key],
		'Detail'  => $this->input->post('ProductName')[$key] . " " . "Quantity of: " . " " .$this->input->post('Quantity')[$key],
		);		
		$this->db->insert('pos_accounts_generaljournal_entries', $CreditTransactionDetail);		
		
		// Add Cash Reciept Voucher
			if($this->input->post('cash_received') != 0){
				// Following script is entering debit side entry
				$DebitTransactionDetailCash = array(
				'GeneralJournalId' => (count($query) < 2) ? $GeneralJournalCashId : $query[1]['GeneralJournalId'],
				'CustomerId' => $CustomerId,
				'SalemanId'	=> $SalemanChartOfAccountId,
				'ChartOfAccountId' => $DebitChartOfAccountId,
				'Debit'   => '0.00',
				'Credit' => $this->input->post('cash_received'),
				'Detail'  =>  "",
				);
				$this->db->insert('pos_accounts_generaljournal_entries', $DebitTransactionDetailCash);
				
				
				// Following script is entering credit side entry
				$CreditTransactionDetailCash = array(
				'GeneralJournalId' => (count($query) < 2) ? $GeneralJournalCashId : $query[1]['GeneralJournalId'],
				'CustomerId' => $CustomerId,
				'SalemanId'	=> $SalemanChartOfAccountId,
				'ChartOfAccountId' => 1,
				'Debit'   => $this->input->post('cash_received'),
				'Credit' => '0.00',
				'Detail'  => "",
				);		
				$this->db->insert('pos_accounts_generaljournal_entries', $CreditTransactionDetailCash);	
			}
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
	
	function GetFbrSalesDetail($SaleId)
	{
	    $this->db->select('*');
	    $this->db->from($this->tbl_sales);  
	    $this->db->join($this->tbl_sales_detail, $this->tbl_sales_detail.'.SaleId = '.$this->tbl_sales.'.SaleId');
	    $this->db->join($this->tbl_products, $this->tbl_products.'.ProductId = '.$this->tbl_sales_detail.'.ProductId');
	    $this->db->join($this->tbl_productgroup, $this->tbl_productgroup.'.ProductGroupId = '.$this->tbl_products.'.ProductGroupId');
	    $this->db->join($this->tbl_locations, $this->tbl_locations.'.LocationId = '.$this->tbl_sales_detail.'.LocationId','left');
	    $this->db->join($this->tbl_product_colours, $this->tbl_product_colours.'.ColourId = '.$this->tbl_sales_detail.'.ColourId','left');
	    $this->db->where('pos_sales_detail.SaleId',$SaleId);
	    $query = $this->db->get();
	    return $query->result_array();
	}
	
	function GetFbrSales($SaleId)
	{
	    $this->db->select('*,pos_sales.AddedOn, pos_customer.Address AS buyerAddress');
	    $this->db->from($this->tbl_sales);
	   	$this->db->join($this->tbl_customer, $this->tbl_customer.'.CustomerId = '.$this->tbl_sales.'.CustomerId', 'left');
		$this->db->join($this->tbl_saleman, $this->tbl_saleman.'.SalemanId = '.$this->tbl_sales.'.SalemanId', 'left');
	   	$this->db->join($this->tbl_bank_accounts, $this->tbl_bank_accounts.'.AccountId = '.$this->tbl_sales.'.AccountId', 'left');
	   	$this->db->join($this->tbl_reference, $this->tbl_reference.'.ReferenceId = '.$this->tbl_sales.'.ReferenceId', 'left');
	    $this->db->where('pos_sales.SaleId',$SaleId);
	    $query = $this->db->get();
	    return $query->row();	
	}
    function GetInvoiceSales($SaleId)
	{
		$this->db->select('TotalAmount');
		$this->db->from($this->tbl_sales);
		$this->db->where('pos_sales.SaleId', $SaleId);
		$query = $this->db->get();
		return $query->result_array();
	}

}
?>