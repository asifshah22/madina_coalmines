<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class InvoiceReceipt_model extends CI_Model{
	
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
		$this->tbl_banks = "pos_banks";
	    $this->tbl_bank_accounts = "pos_bank_accounts";
		$this->tbl_generaljournal = "pos_accounts_generaljournal";
		$this->tbl_generaljournal_entries = "pos_accounts_generaljournal_entries";
		$this->tbl_area = "pos_area";
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

    function Ajax_GetAllGeneralJournal($requestData)
        {
                $columns = array(
                0 => 'SaleId',
                1 => 'TransactionDate',
                2 => 'Reference',
                3 => 'TotalDebit',
				3 => 'GeneralJournalId',
                );
                // getting total number records without any search
                $sql = "SELECT pos_accounts_generaljournal.TransactionDate, pos_accounts_generaljournal.Reference,
				pos_accounts_generaljournal.TotalDebit, pos_accounts_generaljournal.GeneralJournalId,
				pos_accounts_generaljournal.EntryType, pos_accounts_generaljournal.VoucherType, 
				pos_accounts_generaljournal.SaleId, pos_customer.CustomerName, pos_area.Area_name ";
                $sql.="FROM pos_accounts_generaljournal";
				$sql.=" INNER JOIN pos_customer ON pos_customer.CustomerId = pos_accounts_generaljournal.CustomerId ";
				$sql.=" INNER JOIN pos_area ON pos_area.id = pos_customer.AreaId ";
                $query= $this->db->query($sql); 
                $totalData = $query->num_rows();
                $totalFiltered = $totalData; 
                
                // when there is no search parameter then total number rows = total number filtered rows.
                $sql = "SELECT pos_accounts_generaljournal.TransactionDate, pos_accounts_generaljournal.Reference,
				pos_accounts_generaljournal.TotalDebit, pos_accounts_generaljournal.GeneralJournalId,
				pos_accounts_generaljournal.EntryType, pos_accounts_generaljournal.VoucherType, 
				pos_accounts_generaljournal.SaleId,pos_accounts_generaljournal.SaleUniqueId,pos_accounts_generaljournal.ReceiptNo, pos_customer.CustomerName ";
                $sql.="FROM pos_accounts_generaljournal";
				$sql.=" INNER JOIN pos_customer ON pos_customer.CustomerId = pos_accounts_generaljournal.CustomerId ";
				// $sql.=" INNER JOIN pos_area ON pos_area.id = pos_customer.AreaId ";
                $sql.=" WHERE pos_accounts_generaljournal.IsInvoiceReceipt=1";
                
                if( !empty($requestData['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter
                       $sql.=" AND ( pos_accounts_generaljournal.TransactionDate LIKE '%".$requestData['search']['value']."%' ";
                       $sql.=" OR pos_accounts_generaljournal.Reference LIKE '%".$requestData['search']['value']."%' ";
					   $sql.=" OR pos_accounts_generaljournal.GeneralJournalId LIKE '%".$requestData['search']['value']."%' ";
					   $sql.=" OR pos_customer.CustomerName LIKE '%".$requestData['search']['value']."%' ";
					   $sql.=" OR pos_area.Area_name LIKE '%".$requestData['search']['value']."%' ";
                       $sql.=" OR pos_accounts_generaljournal.TotalDebit LIKE '%".$requestData['search']['value']."%' ";
                       
                       $sql.=" OR pos_accounts_generaljournal.SaleUniqueId LIKE '%".$requestData['search']['value']."%' ";
                       
                       $sql.=" OR pos_accounts_generaljournal.ReceiptNo LIKE '%".$requestData['search']['value']."%' )";
                }
                $query=$this->db->query( $sql) ;
                $totalFiltered = $query->num_rows(); // when there is a search parameter then we have to modify total number filtered rows as per search result. 
                $sql.=" ORDER BY   ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']."  LIMIT ".$requestData['start']." ,".$requestData['length']."   ";
                /* $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc  */	
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
	   	$this->db->join($this->tbl_category, $this->tbl_category.'.CategoryId = '.$this->tbl_sales.'.ProjectId', 'left');
	   	$this->db->join($this->tbl_products, $this->tbl_products.'.ProductId = '.$this->tbl_sales.'.PlotId', 'left');
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
	
	
	function GetInstallments($SaleId)
	{
		$this->db->select('*');
		$this->db->from('pos_sales');
		$this->db->join($this->tbl_customer, $this->tbl_customer.'.CustomerId = '.$this->tbl_sales.'.CustomerId');
		$this->db->join($this->tbl_products, $this->tbl_products.'.ProductId = '.$this->tbl_sales.'.ProjectId', 'left');
		$this->db->where('pos_sales.SaleId',$SaleId);
		$result = $this->db->get();
		return $result->result_array();
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
	
	
	public function SaveInstallmentDetail()
	{
		$this->db->select('*');
		$this->db->from($this->tbl_sales);
		$this->db->where('UniqueId',$this->input->post('invoice_no'));
		$query = $this->db->get();
		$CheckSale = $query->result_array();

		if($this->input->post('date')){ 
			$ReceiptDate =  date('Y-m-d', strtotime($this->input->post('date'))); 
		}else{ 
			$ReceiptDate = date('Y-m-d'); 
		}

		if($this->input->post('bank_account_id') != "0"){
		    $BankId = $this->input->post('bank_account_id');
		    $IdArr = explode("-", $BankId);
		    $BankId = $IdArr[0];
		    $BankChartOfAccountId = $IdArr[1];
		}
		
		
		$CustomerId = $this->input->post('client_id');
		
// 			$CustomerId = $this->input->post('customer_name');
		$this->db->select('*');
		$this->db->from($this->tbl_customer);
		$this->db->where('CustomerId',$CustomerId);
		$query = $this->db->get();
		$Customername = $query->result_array();
		$Customername =$Customername[0]['CustomerName'];
		
		
		$this->db->select('*');
		$this->db->from($this->tbl_bank_accounts);
		$this->db->where('AccountId',$BankId);
		$query = $this->db->get();
		$AccountTitle = $query->result_array();
		$AccountTitle =$AccountTitle[0]['AccountTitle'];
		
        $DebitChartOfAccountId = $this->input->post('ChartOfAccountId');
		$UniqueId = $this->input->post('invoice_no');
		$SaleId = $CheckSale[0]['SaleId'];

		// insert into accounts generaljournal and its detail table
	    
	    // Gets Cash Balance chart of account from setting table
	    $CashChartOfAccountId = 1;
	 
	    $DebitAmount = $this->input->post('amount');
	    $CreditAmount = $this->input->post('amount');
		
		$VoucherType = 0;
	    $ReferenceNo = 0;

		if($this->input->post('payment_type') == "1")
	    {
			$CreditChartOfAccountId = $CashChartOfAccountId;
			$VoucherType = 3;
			$ReferenceNo = $this->CRVReferenceNo();
	    }
		if($this->input->post('payment_type') == "2")
		{ 
		   $CreditChartOfAccountId = $BankChartOfAccountId;
		   $VoucherType = 2;
		   $ReferenceNo = $this->BPVReferenceNo();
        }
		// EntryType = 1 shows auto voucher created
	    $Transactions = array(
			'EntryType' => 1,
            'SaleId' => $SaleId,
			'SaleUniqueId' => $UniqueId,
            'CustomerId' => $CustomerId,
            'BankAccountId' => $BankId,
			'VoucherType' => $VoucherType,
			'Reference' => $ReferenceNo,
			'TransactionDate' => $ReceiptDate,
			'TotalDebit' => $DebitAmount,
			'TotalCredit' => $CreditAmount,
            'IsInvoiceReceipt' => 1,
            'ReceiptNo' => $this->input->post('slip_no'),
            'Detail' => $this->input->post('remarks'),
			'OtherExp' => $this->input->post('OtherExp'),
			'LatePayment' => $this->input->post('LatePayment'),
			'gst' => $this->input->post('Gst'),
			'itax' => $this->input->post('Itax'),
			'stampduty' => $this->input->post('Stampduty'),
			'AddedOn' => date('Y-m-d H:i:s'),
			'AddedBy' => $this->session->userdata('EmployeeId'),
		);
		$this->db->insert('pos_accounts_generaljournal', $Transactions);
		$GeneralJournalId = intval($this->db->insert_id());

		// Following script is entering debit side entry
		$DebitTransactionDetailCash = array(
			'GeneralJournalId' => $GeneralJournalId,
            'SaleId' => $SaleId,
			'CustomerId' => $CustomerId,
			'ChartOfAccountId' => $CreditChartOfAccountId,
			'Debit'   => $DebitAmount,
			'Credit' => '0.00',
		    'Detail'  => "<span style='color:#00A657'>Customer Name: " .$Customername . " , </span>   <span style='color:#f44336'>Cheque No : ".$this->input->post('slip_no') ." ,</span>",
			);
			/*
			
			<span style='color:#605ca8'>Invoice No: " . " " .$UniqueId . " </span>, 
			<span style='color:#ff87b0'>Receipt No : ".$GeneralJournalId ." ,</span>
			<span style='color:#00bcd4'> Bank Ac : ".$AccountTitle*/
		$this->db->insert('pos_accounts_generaljournal_entries', $DebitTransactionDetailCash);

	
		// Following script is entering credit side entry
		$DebitTransactionDetail = array(
			'GeneralJournalId' => $GeneralJournalId,
			'CustomerId' => $CustomerId,
			'ChartOfAccountId' => $DebitChartOfAccountId,
			'Debit'   => '0.00',
			'Credit' => $CreditAmount,
			'Detail'  => "<span style='color:#00A657'>Customer Name: " .$Customername . " , </span>   <span style='color:#f44336'>Cheque No : ".$this->input->post('slip_no') ." ,</span>",
			
            // 'Detail'  => "<span style='color:#605ca8'>Invoice No: " . " " .$UniqueId . " </span>, <span style='color:#00A657'>Customer Name: " .$Customername . " , </span><span style='color:#ff87b0'>Receipt No : ".$GeneralJournalId ." ,</span> <span style='color:#f44336'>Cheque No : ".$this->input->post('slip_no') ." ,</span><span style='color:#00bcd4'> Bank Ac : ".$AccountTitle,
		);
		$this->db->insert('pos_accounts_generaljournal_entries', $DebitTransactionDetail);

		// if tax amount field are not empty.
		if($this->input->post('Itax') != 0 && $this->input->post('Itax') != ""){
			// Following script is entering debit side entry
			$DebitTransactionDetailCash = array(
				'GeneralJournalId' => $GeneralJournalId,
				'SaleId' => $SaleId,
				'CustomerId' => $CustomerId,
				'ChartOfAccountId' => 661,
				'Debit'   => $this->input->post('Itax'),
				'Credit' => '0.00',
				'Detail'  => "Invoice No: " . " " .$UniqueId . " Customer Id: " .$CustomerId . " I.Tax COA Id: 661",
				);
			$this->db->insert('pos_accounts_generaljournal_entries', $DebitTransactionDetailCash);

		
			// Following script is entering credit side entry
			$DebitTransactionDetail = array(
				'GeneralJournalId' => $GeneralJournalId,
				'CustomerId' => $CustomerId,
				'ChartOfAccountId' => $DebitChartOfAccountId,
				'Debit'   => '0.00',
				'Credit' => $this->input->post('Itax'),
				'Detail'  =>  "Invoice No: " . " " .$UniqueId . "  Receipt no ".$GeneralJournalId . " -  I.Tax ",
			);
			$this->db->insert('pos_accounts_generaljournal_entries', $DebitTransactionDetail);
		}
        if($this->input->post('Stampduty') != 0 && $this->input->post('Stampduty') != ""){
    			// Following script is entering debit side entry
    			$DebitTransactionDetailCash = array(
    				'GeneralJournalId' => $GeneralJournalId,
    				'SaleId' => $SaleId,
    				'CustomerId' => $CustomerId,
    				'ChartOfAccountId' => 661,
    				'Debit'   => $this->input->post('Stampduty'),
    				'Credit' => '0.00',
    				'Detail'  => "Invoice No: " . " " .$UniqueId . " Customer Id: " .$CustomerId . " Stampduty COA Id: 661",
    				);
    			$this->db->insert('pos_accounts_generaljournal_entries', $DebitTransactionDetailCash);
    
    		
    			// Following script is entering credit side entry
    			$DebitTransactionDetail = array(
    				'GeneralJournalId' => $GeneralJournalId,
    				'CustomerId' => $CustomerId,
    				'ChartOfAccountId' => $DebitChartOfAccountId,
    				'Debit'   => '0.00',
    				'Credit' => $this->input->post('Stampduty'),
    				'Detail'  =>  "Invoice No: " . " " .$UniqueId . "  Receipt no ".$GeneralJournalId . " -  Stampduty",
    			);
    			$this->db->insert('pos_accounts_generaljournal_entries', $DebitTransactionDetail);
    		}

		// if Other Exp field are not empty.
		if($this->input->post('OtherExp') != 0 && $this->input->post('OtherExp') != ""){
			// Following script is entering debit side entry
			$DebitTransactionDetailCash = array(
				'GeneralJournalId' => $GeneralJournalId,
				'SaleId' => $SaleId,
				'CustomerId' => $CustomerId,
				'ChartOfAccountId' => 799,
				'Debit'   => $this->input->post('OtherExp'),
				'Credit' => '0.00',
				'Detail'  => "Invoice No: " . " " .$UniqueId . " Customer Id: " .$CustomerId . " Other Exp COA Id: 799",
				);
			$this->db->insert('pos_accounts_generaljournal_entries', $DebitTransactionDetailCash);

		
			// Following script is entering credit side entry
			$DebitTransactionDetail = array(
				'GeneralJournalId' => $GeneralJournalId,
				'CustomerId' => $CustomerId,
				'ChartOfAccountId' => $DebitChartOfAccountId,
				'Debit'   => '0.00',
				'Credit' => $this->input->post('OtherExp'),
				'Detail'  =>  "Invoice No: " . " " .$UniqueId . "  Receipt no ".$GeneralJournalId . " -  Other Exp ",
			);
			$this->db->insert('pos_accounts_generaljournal_entries', $DebitTransactionDetail);
		}

		// if Late Payment field are not empty.
		if($this->input->post('LatePayment') != 0 && $this->input->post('LatePayment') != ""){
			// Following script is entering debit side entry
			$DebitTransactionDetailCash = array(
				'GeneralJournalId' => $GeneralJournalId,
				'SaleId' => $SaleId,
				'CustomerId' => $CustomerId,
				'ChartOfAccountId' => 800,
				'Debit'   => $this->input->post('LatePayment'),
				'Credit' => '0.00',
				'Detail'  => "Invoice No: " . " " .$UniqueId . " Customer Id: " .$CustomerId . " Late Payment COA Id: 800",
				);
			$this->db->insert('pos_accounts_generaljournal_entries', $DebitTransactionDetailCash);

		
			// Following script is entering credit side entry
			$DebitTransactionDetail = array(
				'GeneralJournalId' => $GeneralJournalId,
				'CustomerId' => $CustomerId,
				'ChartOfAccountId' => $DebitChartOfAccountId,
				'Debit'   => '0.00',
				'Credit' => $this->input->post('LatePayment'),
				'Detail'  =>  "Invoice No: " . " " .$UniqueId . "  Receipt no ".$GeneralJournalId . " -  Late Payment",
			);
			$this->db->insert('pos_accounts_generaljournal_entries', $DebitTransactionDetail);
		}
				// if Late Payment field are not empty.
		if($this->input->post('Gst') != 0 && $this->input->post('Gst') != ""){
			// Following script is entering debit side entry
			$DebitTransactionDetailCash = array(
				'GeneralJournalId' => $GeneralJournalId,
				'SaleId' => $SaleId,
				'CustomerId' => $CustomerId,
				'ChartOfAccountId' => 838,
				'Debit'   => $this->input->post('Gst'),
				'Credit' => '0.00',
				'Detail'  => "Invoice No: " . " " .$UniqueId . " Customer Id: " .$CustomerId . " Gst COA Id: 838",
				);
			$this->db->insert('pos_accounts_generaljournal_entries', $DebitTransactionDetailCash);

		
			// Following script is entering credit side entry
			$DebitTransactionDetail = array(
				'GeneralJournalId' => $GeneralJournalId,
				'CustomerId' => $CustomerId,
				'ChartOfAccountId' => $DebitChartOfAccountId,
				'Debit'   => '0.00',
				'Credit' => $this->input->post('Gst'),
				'Detail'  =>  "Invoice No: " . " " .$UniqueId . "  Receipt no ".$GeneralJournalId . " -  Gst ",
			);
			$this->db->insert('pos_accounts_generaljournal_entries', $DebitTransactionDetail);
		}
				// if Late Payment field are not empty.
		
	
		return $GeneralJournalId;
	}
    public function SaveMultiInstallmentDetail()
	{
	   // echo "<pre>";
	   //print_r($this->input->post());
	   //die();
	    $invoice_nos=$this->input->post('tick');
	    $GeneralJournalId=0;
	    foreach($invoice_nos as $key=>$invoice_no){
	    
		$this->db->select('*');
		$this->db->from($this->tbl_sales);
		$this->db->where('SaleId',$invoice_no);
		$query = $this->db->get();
		$CheckSale = $query->result_array();




		if($this->input->post('date')){ 
			$ReceiptDate =  date('Y-m-d', strtotime($this->input->post('date'))); 
		}else{ 
			$ReceiptDate = date('Y-m-d'); 
		}

		if($this->input->post('bank_account_id') != "0"){
		    $BankId = $this->input->post('bank_account_id');
		    $IdArr = explode("-", $BankId);
		    $BankId = $IdArr[0];
		    $BankChartOfAccountId = $IdArr[1];
		}
		
		$CustomerId = $this->input->post('customer_name');
		$this->db->select('*');
		$this->db->from($this->tbl_customer);
		$this->db->where('CustomerId',$CustomerId);
		$query = $this->db->get();
		$Customername = $query->result_array();
		$CustomerDebitChartOfAccountId =$Customername[0]['ChartOfAccountId'];
		$Customername =$Customername[0]['CustomerName'];
// 		print_r($Customername); die();
		
		$this->db->select('*');
		$this->db->from($this->tbl_bank_accounts);
		$this->db->where('AccountId',$BankId);
		$query = $this->db->get();
		$AccountTitle = $query->result_array();
		$AccountTitle =$AccountTitle[0]['AccountTitle'];
		
		
		
		$DebitChartOfAccountId = $this->input->post('ChartOfAccountId');
		$UniqueId = $this->input->post('invoice_no')[$invoice_no];
		$SaleId = $invoice_no;
	
		// insert into accounts generaljournal and its detail table
	    
	    // Gets Cash Balance chart of account from setting table
	    $CashChartOfAccountId = 1;
	 
	    $DebitAmount = $this->input->post('amount')[$invoice_no];
	    $CreditAmount = $this->input->post('amount')[$invoice_no];
		
		$VoucherType = 0;
	    $ReferenceNo = 0;

		if($this->input->post('payment_type') == "1")
	    {
			$CreditChartOfAccountId = $CashChartOfAccountId;
			$VoucherType = 3;
			$ReferenceNo = $this->CRVReferenceNo();
	    }
		if($this->input->post('payment_type') == "2")
		{ 
		   $CreditChartOfAccountId = $BankChartOfAccountId;
		   $VoucherType = 2;
		   $ReferenceNo = $this->BPVReferenceNo();
        }
        //echo $SaleId;
		// EntryType = 1 shows auto voucher created
	    $Transactions = array(
			'EntryType' => 1,
            'SaleId' => $SaleId,
			'SaleUniqueId' => $this->input->post('invoice_no')[$invoice_no],
            'CustomerId' => $CustomerId,
            'BankAccountId' => $BankId,
			'VoucherType' => $VoucherType,
			'Reference' => $ReferenceNo,
			'TransactionDate' => $ReceiptDate,
			'TotalDebit' => $DebitAmount,
			'TotalCredit' => $CreditAmount,
            'IsInvoiceReceipt' => 1,
            'ReceiptNo' => $this->input->post('slip_no'),
            'Detail' => $this->input->post('remarks')[$invoice_no],
// 			'OtherExp' => $this->input->post('OtherExp')[$invoice_no],
// 			'LatePayment' => $this->input->post('LatePayment')[$invoice_no],
// 			'gst' => $this->input->post('Gst')[$invoice_no],
			'itax' => $this->input->post('Itax')[$invoice_no],
			'stampduty' => $this->input->post('Stampduty')[$invoice_no],
			'AddedOn' => date('Y-m-d H:i:s'),
			'AddedBy' => $this->session->userdata('EmployeeId'),
		);

		$this->db->insert('pos_accounts_generaljournal', $Transactions);
		$GeneralJournalId = intval($this->db->insert_id());

		// Following script is entering debit side entry
		$DebitTransactionDetailCash = array(
			'GeneralJournalId' => $GeneralJournalId,
            'SaleId' => $SaleId,
			'CustomerId' => $CustomerId,
			'ChartOfAccountId' => $CreditChartOfAccountId,
			'Debit'   => $DebitAmount,
			'Credit' => '0.00',
// 			'Detail'  => "<span style='color:#605ca8'>Invoice No: " . " " .$UniqueId . " </span>, <span style='color:#00A657'>Customer Name: " .$Customername . " , </span><span style='color:#ff87b0'>Receipt No : ".$GeneralJournalId ." ,</span> <span style='color:#f44336'>Cheque No : ".$this->input->post('slip_no') ." ,</span><span style='color:#00bcd4'> Bank Ac : ".$AccountTitle,);
			'Detail'  => "<span style='color:#00A657'>Customer Name: " .$Customername . " , </span>   <span style='color:#f44336'>Cheque No : ".$this->input->post('slip_no') ." ,</span>",
			);
		$this->db->insert('pos_accounts_generaljournal_entries', $DebitTransactionDetailCash);

	
		// Following script is entering credit side entry
		$DebitTransactionDetail = array(
			'GeneralJournalId' => $GeneralJournalId,
			'CustomerId' => $CustomerId,
			'ChartOfAccountId' => $CustomerDebitChartOfAccountId,
			'Debit'   => '0.00',
			'Credit' => $CreditAmount,
			'Detail'  => "<span style='color:#00A657'>Customer Name: " .$Customername . " , </span>   <span style='color:#f44336'>Cheque No : ".$this->input->post('slip_no') ." ,</span>",
			);
// 			'Detail'  =>  "<span style='color:#605ca8'>Invoice No: " . " " .$UniqueId . " </span>, <span style='color:#00A657'>Customer Name: " .$Customername . " , </span><span style='color:#ff87b0'>Receipt No : ".$GeneralJournalId ." ,</span> <span style='color:#f44336'>Cheque No : ".$this->input->post('slip_no') ." ,</span><span style='color:#00bcd4'> Bank Ac : ".$AccountTitle,);
		$this->db->insert('pos_accounts_generaljournal_entries', $DebitTransactionDetail);
   
		// if tax amount field are not empty.
		if($this->input->post('Itax')[$invoice_no] != 0 && $this->input->post('Itax')[$invoice_no] != ""){
			// Following script is entering debit side entry
			$DebitTransactionDetailCash = array(
				'GeneralJournalId' => $GeneralJournalId,
				'SaleId' => $SaleId,
				'CustomerId' => $CustomerId,
				'ChartOfAccountId' => 1262,
				'Debit'   => $this->input->post('Itax')[$invoice_no],
				'Credit' => '0.00',
				'Detail'  => "Invoice No: " . " " .$UniqueId . " Customer Id: " .$CustomerId . " I.Tax COA Id: 1262",
				);
			$this->db->insert('pos_accounts_generaljournal_entries', $DebitTransactionDetailCash);

		
			// Following script is entering credit side entry
			$DebitTransactionDetail = array(
				'GeneralJournalId' => $GeneralJournalId,
				'CustomerId' => $CustomerId,
				'ChartOfAccountId' => $CustomerDebitChartOfAccountId,
				'Debit'   => '0.00',
				'Credit' => $this->input->post('Itax')[$invoice_no],
				'Detail'  =>  "Invoice No: " . " " .$UniqueId . "  Receipt no ".$GeneralJournalId . " -  I.Tax",
			);
			$this->db->insert('pos_accounts_generaljournal_entries', $DebitTransactionDetail);
		}
		
		if($this->input->post('Stampduty')[$invoice_no] != 0 && $this->input->post('Stampduty')[$invoice_no] != ""){
			// Following script is entering debit side entry
			$DebitTransactionDetailCash = array(
				'GeneralJournalId' => $GeneralJournalId,
				'SaleId' => $SaleId,
				'CustomerId' => $CustomerId,
				'ChartOfAccountId' => 1262,
				'Debit'   => $this->input->post('Stampduty')[$invoice_no],
				'Credit' => '0.00',
				'Detail'  => "Invoice No: " . " " .$UniqueId . " Customer Id: " .$CustomerId . " WH Tax COA Id: 1262",
				);
			$this->db->insert('pos_accounts_generaljournal_entries', $DebitTransactionDetailCash);

		
			// Following script is entering credit side entry
			$DebitTransactionDetail = array(
				'GeneralJournalId' => $GeneralJournalId,
				'CustomerId' => $CustomerId,
				'ChartOfAccountId' => $CustomerDebitChartOfAccountId,
				'Debit'   => '0.00',
				'Credit' => $this->input->post('Stampduty')[$invoice_no],
				'Detail'  =>  "Invoice No: " . " " .$UniqueId . "  Receipt no ".$GeneralJournalId . " -  WH Tax",
			);
			$this->db->insert('pos_accounts_generaljournal_entries', $DebitTransactionDetail);
		}

		// if Other Exp field are not empty.
		if($this->input->post('OtherExp')[$invoice_no] != 0 && $this->input->post('OtherExp')[$invoice_no] != ""){
			// Following script is entering debit side entry
			$DebitTransactionDetailCash = array(
				'GeneralJournalId' => $GeneralJournalId,
				'SaleId' => $SaleId,
				'CustomerId' => $CustomerId,
				'ChartOfAccountId' => 799,
				'Debit'   => $this->input->post('OtherExp')[$invoice_no],
				'Credit' => '0.00',
				'Detail'  => "Invoice No: " . " " .$UniqueId . " Customer Id: " .$CustomerId . " Other Exp COA Id: 799",
				);
			$this->db->insert('pos_accounts_generaljournal_entries', $DebitTransactionDetailCash);

		
			// Following script is entering credit side entry
			$DebitTransactionDetail = array(
				'GeneralJournalId' => $GeneralJournalId,
				'CustomerId' => $CustomerId,
				'ChartOfAccountId' => $DebitChartOfAccountId,
				'Debit'   => '0.00',
				'Credit' => $this->input->post('OtherExp')[$invoice_no],
				'Detail'  =>  "Invoice No: " . " " .$UniqueId . "  Receipt no ".$GeneralJournalId . " -  Other Exp",
			);
			$this->db->insert('pos_accounts_generaljournal_entries', $DebitTransactionDetail);
		}

		// if Late Payment field are not empty.
		if($this->input->post('LatePayment')[$invoice_no] != 0 && $this->input->post('LatePayment')[$invoice_no] != ""){
			// Following script is entering debit side entry
			$DebitTransactionDetailCash = array(
				'GeneralJournalId' => $GeneralJournalId,
				'SaleId' => $SaleId,
				'CustomerId' => $CustomerId,
				'ChartOfAccountId' => 800,
				'Debit'   => $this->input->post('LatePayment')[$invoice_no],
				'Credit' => '0.00',
				'Detail'  => "Invoice No: " . " " .$UniqueId . " Customer Id: " .$CustomerId . " Late Payment COA Id: 800",
				);
			$this->db->insert('pos_accounts_generaljournal_entries', $DebitTransactionDetailCash);

		
			// Following script is entering credit side entry
			$DebitTransactionDetail = array(
				'GeneralJournalId' => $GeneralJournalId,
				'CustomerId' => $CustomerId,
				'ChartOfAccountId' => $DebitChartOfAccountId,
				'Debit'   => '0.00',
				'Credit' => $this->input->post('LatePayment')[$invoice_no],
				'Detail'  =>  "Invoice No: " . " " .$UniqueId . "  Receipt no ".$GeneralJournalId . " -  Late Payment",
			);
			$this->db->insert('pos_accounts_generaljournal_entries', $DebitTransactionDetail);
		}
				// if Late Payment field are not empty.
		if($this->input->post('Gst')[$invoice_no] != 0 && $this->input->post('Gst')[$invoice_no] != ""){
			// Following script is entering debit side entry
			$DebitTransactionDetailCash = array(
				'GeneralJournalId' => $GeneralJournalId,
				'SaleId' => $SaleId,
				'CustomerId' => $CustomerId,
				'ChartOfAccountId' => 838,
				'Debit'   => $this->input->post('Gst')[$invoice_no],
				'Credit' => '0.00',
				'Detail'  => "Invoice No: " . " " .$UniqueId . " Customer Id: " .$CustomerId . " Gst COA Id: 838",
				);
			$this->db->insert('pos_accounts_generaljournal_entries', $DebitTransactionDetailCash);

		
			// Following script is entering credit side entry
			$DebitTransactionDetail = array(
				'GeneralJournalId' => $GeneralJournalId,
				'CustomerId' => $CustomerId,
				'ChartOfAccountId' => $DebitChartOfAccountId,
				'Debit'   => '0.00',
				'Credit' => $this->input->post('Gst')[$invoice_no],
				'Detail'  =>  "Invoice No: " . " " .$UniqueId . "  Receipt no ".$GeneralJournalId . " -  Gst",
			);
			$this->db->insert('pos_accounts_generaljournal_entries', $DebitTransactionDetail);
		}
		
	    }
		return $GeneralJournalId;
	
	}

	public function BPVReferenceNo()
	{
		$this->db->select("Reference");
		$this->db->from('pos_accounts_generaljournal');
		$this->db->where('VoucherType', '2');
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

	
	public function UpdateInstallmentDetail()
	{
		$this->db->select('*');
		$this->db->from($this->tbl_sales);
		$this->db->where('UniqueId',$this->input->post('invoice_no'));
		$query = $this->db->get();
		$CheckSale = $query->result_array();

		if($this->input->post('date')){ 
			$ReceiptDate =  date('Y-m-d', strtotime($this->input->post('date'))); 
		}else{ 
			$ReceiptDate = date('Y-m-d'); 
		}

		if($this->input->post('bank_account_id') != "0"){
		    $BankId = $this->input->post('bank_account_id');
		    $IdArr = explode("-", $BankId);
		    $BankId = $IdArr[0];
		    $BankChartOfAccountId = $IdArr[1];
		}
        $GeneralJournalId = $this->input->post('GeneralJournalId');
		$CustomerId = $this->input->post('client_id');
		
		$this->db->select('*');
		$this->db->from($this->tbl_customer);
		$this->db->where('CustomerId',$CustomerId);
		$query = $this->db->get();
		$Customername = $query->result_array();
		$Customername =$Customername[0]['CustomerName'];
		
		
		$this->db->select('*');
		$this->db->from($this->tbl_bank_accounts);
		$this->db->where('AccountId',$BankId);
		$query = $this->db->get();
		$AccountTitle = $query->result_array();
		$AccountTitle =$AccountTitle[0]['AccountTitle'];
		
        $DebitChartOfAccountId = $this->input->post('ChartOfAccountId');
		$UniqueId = $this->input->post('invoice_no');
		$SaleId = $CheckSale[0]['SaleId'];
	    
	    // Gets Cash Balance chart of account from setting table
	    $CashChartOfAccountId = 1;
	    
	    $DebitAmount = $this->input->post('amount');
	    $CreditAmount = $this->input->post('amount');

		$VoucherType = 0;
	    $ReferenceNo = 0;
	    // $DebitChartOfAccountId = 0;

		if($this->input->post('payment_type') == "1")
	    {
			$CreditChartOfAccountId = $CashChartOfAccountId;
			$VoucherType = 3;
			$ReferenceNo = $this->CRVReferenceNo();
	    }
		if($this->input->post('payment_type') == "2")
		{ 
		   $CreditChartOfAccountId = $BankChartOfAccountId;
		   $VoucherType = 2;
		   $ReferenceNo = $this->BPVReferenceNo();
        }
	    
	    $Transactions = array(
            'EntryType' => 1,
            'SaleId' => $SaleId,
			'SaleUniqueId' => $UniqueId,
            'CustomerId' => $CustomerId,
            'BankAccountId' => $BankId,
			'TransactionDate' => $ReceiptDate,
			'TotalDebit' => $DebitAmount,
			'TotalCredit' => $CreditAmount,
			'Reference'   => $ReferenceNo,
			'VoucherType' => $VoucherType,
            'IsInvoiceReceipt' => 1,
            'ReceiptNo' => $this->input->post('slip_no'),
            'Detail' => $this->input->post('remarks'),
            'itax' => $this->input->post('Itax'),
            'OtherExp' => $this->input->post('OtherExp'),
			'LatePayment' => $this->input->post('LatePayment'),
			'gst' => $this->input->post('Gst'),
			'stampduty' => $this->input->post('Stampduty'),
			'AddedOn' => date('Y-m-d H:i:s'),
			'AddedBy' => $this->session->userdata('EmployeeId'),
		);

		$this->db->where('pos_accounts_generaljournal.GeneralJournalId', $GeneralJournalId);
		$this->db->update('pos_accounts_generaljournal', $Transactions);

		// Remove Record from pos_accounts_generaljournal_entries Before Inserting New Record
		$this->db->where('pos_accounts_generaljournal_entries.GeneralJournalId', $GeneralJournalId);
		$deleteEnteries = $this->db->delete('pos_accounts_generaljournal_entries');

		// Add Cash Reciept Voucher
		if($deleteEnteries){
			// Following script is entering debit side entry
			$DebitTransactionDetailCash = array(
				'GeneralJournalId' => $GeneralJournalId,
				'SaleId' => $SaleId,
				'CustomerId' => $CustomerId,
				'ChartOfAccountId' => $CreditChartOfAccountId,
				'Debit'   => $DebitAmount,
				'Credit' => '0.00',
				'Detail'  =>  "<span style='color:#605ca8'>Invoice No: " . " " .$UniqueId . " </span>, <span style='color:#00A657'>Customer Name: " .$Customername . " , </span><span style='color:#ff87b0'>Receipt No : ".$GeneralJournalId ." ,</span> <span style='color:#f44336'>Cheque No : ".$this->input->post('slip_no') ." ,</span><span style='color:#00bcd4'> Bank Ac : ".$AccountTitle,
				);
			$this->db->insert('pos_accounts_generaljournal_entries', $DebitTransactionDetailCash);

		
			// Following script is entering credit side entry
			$DebitTransactionDetail = array(
				'GeneralJournalId' => $GeneralJournalId,
				'CustomerId' => $CustomerId,
				'ChartOfAccountId' => $DebitChartOfAccountId,
				'Debit'   => '0.00',
				'Credit' => $CreditAmount,
				'Detail'  =>  "<span style='color:#605ca8'>Invoice No: " . " " .$UniqueId . " </span>, <span style='color:#00A657'>Customer Name: " .$Customername . " , </span><span style='color:#ff87b0'>Receipt No : ".$GeneralJournalId ." ,</span> <span style='color:#f44336'>Cheque No : ".$this->input->post('slip_no') ." ,</span><span style='color:#00bcd4'> Bank Ac : ".$AccountTitle,
			);
			$this->db->insert('pos_accounts_generaljournal_entries', $DebitTransactionDetail);	

			// if tax amount field are not empty.
			/*if($this->input->post('remarks') != 0 && $this->input->post('remarks') != ""){
				// Following script is entering debit side entry
				$DebitTransactionDetailCash = array(
					'GeneralJournalId' => $GeneralJournalId,
					'SaleId' => $SaleId,
					'CustomerId' => $CustomerId,
					'ChartOfAccountId' => 661,
					'Debit'   => $this->input->post('remarks'),
					'Credit' => '0.00',
					'Detail'  => "Invoice No: " . " " .$SaleId . " Customer Id: " .$CustomerId . " Total Detuction COA Id: 661",
					);
				$this->db->insert('pos_accounts_generaljournal_entries', $DebitTransactionDetailCash);

			
				// Following script is entering credit side entry
				$DebitTransactionDetail = array(
					'GeneralJournalId' => $GeneralJournalId,
					'CustomerId' => $CustomerId,
					'ChartOfAccountId' => $DebitChartOfAccountId,
					'Debit'   => '0.00',
					'Credit' => $this->input->post('remarks'),
					'Detail'  =>  "Invoice No: " . " " .$SaleId . " Customer Id: " .$CustomerId . " Total Detuction COA Id: 661",
				);
				$this->db->insert('pos_accounts_generaljournal_entries', $DebitTransactionDetail);
			}*/
			if($this->input->post('Itax') != 0 && $this->input->post('Itax') != ""){
			// Following script is entering debit side entry
			$DebitTransactionDetailCash = array(
				'GeneralJournalId' => $GeneralJournalId,
				'SaleId' => $SaleId,
				'CustomerId' => $CustomerId,
				'ChartOfAccountId' => 661,
				'Debit'   => $this->input->post('Itax'),
				'Credit' => '0.00',
				'Detail'  => "Invoice No: " . " " .$UniqueId . " Customer Id: " .$CustomerId . " I.Tax COA Id: 661",
				);
			$this->db->insert('pos_accounts_generaljournal_entries', $DebitTransactionDetailCash);

		
			// Following script is entering credit side entry
			$DebitTransactionDetail = array(
				'GeneralJournalId' => $GeneralJournalId,
				'CustomerId' => $CustomerId,
				'ChartOfAccountId' => $DebitChartOfAccountId,
				'Debit'   => '0.00',
				'Credit' => $this->input->post('Itax'),
				'Detail'  =>  "Invoice No: " . " " .$UniqueId . "  Receipt no ".$GeneralJournalId . " -  I.Tax ",
			);
			$this->db->insert('pos_accounts_generaljournal_entries', $DebitTransactionDetail);
		}
		
		
		   if($this->input->post('Stampduty') != 0 && $this->input->post('Stampduty') != ""){
    			// Following script is entering debit side entry
    			$DebitTransactionDetailCash = array(
    				'GeneralJournalId' => $GeneralJournalId,
    				'SaleId' => $SaleId,
    				'CustomerId' => $CustomerId,
    				'ChartOfAccountId' => 661,
    				'Debit'   => $this->input->post('Stampduty'),
    				'Credit' => '0.00',
    				'Detail'  => "Invoice No: " . " " .$UniqueId . " Customer Id: " .$CustomerId . " Stampduty COA Id: 661",
    				);
    			$this->db->insert('pos_accounts_generaljournal_entries', $DebitTransactionDetailCash);
    
    		
    			// Following script is entering credit side entry
    			$DebitTransactionDetail = array(
    				'GeneralJournalId' => $GeneralJournalId,
    				'CustomerId' => $CustomerId,
    				'ChartOfAccountId' => $DebitChartOfAccountId,
    				'Debit'   => '0.00',
    				'Credit' => $this->input->post('Stampduty'),
    				'Detail'  =>  "Invoice No: " . " " .$UniqueId . "  Receipt no ".$GeneralJournalId . " -  Stampduty",
    			);
    			$this->db->insert('pos_accounts_generaljournal_entries', $DebitTransactionDetail);
    		}
			
				if($this->input->post('Gst') != 0 && $this->input->post('Gst') != ""){
			// Following script is entering debit side entry
			$DebitTransactionDetailCash = array(
				'GeneralJournalId' => $GeneralJournalId,
				'SaleId' => $SaleId,
				'CustomerId' => $CustomerId,
				'ChartOfAccountId' => 838,
				'Debit'   => $this->input->post('Gst'),
				'Credit' => '0.00',
				'Detail'  => "Invoice No: " . " " .$UniqueId . " Customer Id: " .$CustomerId . " Gst COA Id: 838",
				);
			$this->db->insert('pos_accounts_generaljournal_entries', $DebitTransactionDetailCash);

		
			// Following script is entering credit side entry
			$DebitTransactionDetail = array(
				'GeneralJournalId' => $GeneralJournalId,
				'CustomerId' => $CustomerId,
				'ChartOfAccountId' => $DebitChartOfAccountId,
				'Debit'   => '0.00',
				'Credit' => $this->input->post('Gst'),
				'Detail'  =>  "Invoice No: " . " " .$UniqueId . "  Receipt no ".$GeneralJournalId . " -  Gst ",
			);
			$this->db->insert('pos_accounts_generaljournal_entries', $DebitTransactionDetail);
		}
			
			// if Other Exp field are not empty.
			if($this->input->post('OtherExp') != 0 && $this->input->post('OtherExp') != ""){
				// Following script is entering debit side entry
				$DebitTransactionDetailCash = array(
					'GeneralJournalId' => $GeneralJournalId,
					'SaleId' => $SaleId,
					'CustomerId' => $CustomerId,
					'ChartOfAccountId' => 799,
					'Debit'   => $this->input->post('OtherExp'),
					'Credit' => '0.00',
					'Detail'  => "Invoice No: " . " " .$UniqueId . " Customer Id: " .$CustomerId . " Other Exp COA Id: 799",
					);
				$this->db->insert('pos_accounts_generaljournal_entries', $DebitTransactionDetailCash);

			
				// Following script is entering credit side entry
				$DebitTransactionDetail = array(
					'GeneralJournalId' => $GeneralJournalId,
					'CustomerId' => $CustomerId,
					'ChartOfAccountId' => $DebitChartOfAccountId,
					'Debit'   => '0.00',
					'Credit' => $this->input->post('OtherExp'),
					'Detail'  =>  "Invoice No: " . " " .$UniqueId . " Cash in hand COA Id: 1" . " Other Exp COA Id: 799",
				);
				$this->db->insert('pos_accounts_generaljournal_entries', $DebitTransactionDetail);
			}

			// if Late Payment field are not empty.
			if($this->input->post('LatePayment') != 0 && $this->input->post('LatePayment') != ""){
				// Following script is entering debit side entry
				$DebitTransactionDetailCash = array(
					'GeneralJournalId' => $GeneralJournalId,
					'SaleId' => $SaleId,
					'CustomerId' => $CustomerId,
					'ChartOfAccountId' => 800,
					'Debit'   => $this->input->post('LatePayment'),
					'Credit' => '0.00',
					'Detail'  => "Invoice No: " . " " .$UniqueId . " Customer Id: " .$CustomerId . " Late Payment COA Id: 800",
					);
				$this->db->insert('pos_accounts_generaljournal_entries', $DebitTransactionDetailCash);

			
				// Following script is entering credit side entry
				$DebitTransactionDetail = array(
					'GeneralJournalId' => $GeneralJournalId,
					'CustomerId' => $CustomerId,
					'ChartOfAccountId' => $DebitChartOfAccountId,
					'Debit'   => '0.00',
					'Credit' => $this->input->post('LatePayment'),
					'Detail'  =>  "Invoice No: " . " " .$UniqueId . " Cash in hand COA Id: 1" . " Late Payment COA Id: 800",
				);
				$this->db->insert('pos_accounts_generaljournal_entries', $DebitTransactionDetail);
			}

		}
	    return $GeneralJournalId;
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

	function DeleteSale($id)
	{
	    $this->db->where('SaleId',$id);
        $this->db->delete('pos_sales');
        return true;
	}
	function GetCustomerById($id,$columns='*')
    {   
        $finalResult = array();
        
		$this->db->select($columns);
		$this->db->from('pos_sales');
		$this->db->join($this->tbl_customer, $this->tbl_customer.'.CustomerId = '.$this->tbl_sales.'.CustomerId');
		$this->db->join($this->tbl_products, $this->tbl_products.'.ProductId = '.$this->tbl_sales.'.ProjectId', 'left');
		$this->db->where('pos_sales.SaleId',$id);
		$result = $this->db->get();
		$Customers = $result->result_array();
		
        $i =0;
        foreach($Customers as $customer){
			
			$installmentAmount = 0;
			$checkInstallment = $this->CheckInstallment($customer['SaleId']);
			if($checkInstallment){
				foreach($checkInstallment as $install){
				   $installmentAmount += $install['Amount'];
				}
			}
			
			$finalResult[$i]['SaleId']        	  = $customer['SaleId'];
			$finalResult[$i]['ClientId']          = $customer['CustomerId'];
			$finalResult[$i]['ProjectId']         = $customer['ProjectId'];
            $finalResult[$i]['CustomerId']        = $customer['CustomerId'];
            $finalResult[$i]['CustomerName']      = $customer['CustomerName'];
            $finalResult[$i]['CnicNo']            = $customer['Email'];
            $finalResult[$i]['ProjectName']       = $customer['CategoryName'];
            $finalResult[$i]['PlotName']       	  = $customer['ProductName'];
			$finalResult[$i]['PhoneNo']       	  = $customer['PhoneNo'];
			$finalResult[$i]['ContactName']       = $customer['ContactName'];
			$finalResult[$i]['OutstandingAmount'] = number_format($customer['GrossLeasingAmount'] - $installmentAmount, 0);
        $i++;
        }

         return $finalResult;
    }
	function CheckInstallment($SaleId)
    {
		$this->db->select('*');
		$this->db->from($this->tbl_installment);
		$this->db->where('pos_installment.SaleId',$SaleId);
		$query = $this->db->get();
		return $query->result_array();
    }
	function GetInstallmentById($InstallmentId)
    {
		$this->db->select('*');
		$this->db->from($this->tbl_installment);
		$this->db->join($this->tbl_bank_accounts, $this->tbl_bank_accounts.'.AccountId = '.$this->tbl_installment.'.AccountId', 'left');
		$this->db->join($this->tbl_banks, $this->tbl_banks.'.BankId = '.$this->tbl_bank_accounts.'.BankId', 'left');
		$this->db->where('InstallmentId',$InstallmentId);
		$result = $this->db->get();
		return $result->result_array();
		
		// $this->db->select('*');
		// $this->db->from($this->tbl_installment);
		// $this->db->where('InstallmentId',$InstallmentId);
		// $query = $this->db->get();
		// return $query->result_array();
    }

    function GetGeneralJournalView($GeneralJournalId,$colums='*')
	{
        $this->db->select($colums);
        $this->db->from('pos_accounts_generaljournal');
        $this->db->join('pos_customer','pos_customer.CustomerId = pos_accounts_generaljournal.CustomerId','left');
        $this->db->join($this->tbl_bank_accounts, $this->tbl_bank_accounts.'.AccountId = '.$this->tbl_generaljournal.'.BankAccountId', 'left');
		$this->db->join($this->tbl_banks, $this->tbl_banks.'.BankId = '.$this->tbl_bank_accounts.'.BankId', 'left');
        $this->db->join($this->tbl_area, $this->tbl_area.'.id = '.$this->tbl_customer.'.AreaId', 'left');
        $this->db->where('GeneralJournalId',$GeneralJournalId);
        $ResultGeneralJournal = $this->db->get()->row();
        $Result = array('GeneralJournal'=>$ResultGeneralJournal);
        
        return $Result;
    }

    public function GetBalance($SaleId)
        {
            $query = $this->db->query("SELECT S.SaleId,S.SaleDate, PA.Area_name,
            C.CustomerId,C.ChartOfAccountId,C.CustomerName
                 FROM  pos_sales AS S
                  LEFT JOIN pos_customer AS C ON C.CustomerId = S.CustomerId
                  LEFT JOIN pos_area AS PA ON PA.id = C.AreaId
                  WHERE S.SaleId LIKE '%{$SaleId}%' ");
    
		    $ChartOfAccount = array();
		
          	foreach ($query->result_array() as $key) 
            {
                $getBalance = $this->db->query("SELECT Debit
                 FROM  pos_accounts_generaljournal_entries
                  WHERE SaleId = ".$key["SaleId"]."");

                // calculate amount
                $lastPaidAmount = 0;
                foreach ($getBalance->result_array() as $lastBalance) 
                {
                    $lastPaidAmount += $lastBalance['Debit'];
                }

                $allSales = $this->Sale_model->GetInvoiceSales($key['SaleId']);
                $previousBalance = 0;
                foreach($allSales as $sale){
                    $previousBalance += $sale['TotalAmount'];
                }
                
                $bn = array(
                    'ChartOfAccountId' => trim($key['ChartOfAccountId']),
                    'PreviousBalance' => $previousBalance - $lastPaidAmount
                );
			
		        $ChartOfAccount[] = $bn;
		    }
                          
		return $ChartOfAccount;
    }

	public function AutoCompleteSearch_invoice($SalesId)
        {
            $query = $this->db->query("SELECT S.SaleId, S.UniqueId,S.SaleDate, PA.Area_name,
            C.CustomerId,C.ChartOfAccountId,C.CustomerName
                 FROM  pos_sales AS S
                  LEFT JOIN pos_customer AS C ON C.CustomerId = S.CustomerId
                  LEFT JOIN pos_area AS PA ON PA.id = C.AreaId
                  WHERE S.SaleOrderId=$SalesId");
    
		    $ChartOfAccount = array();
		
          	foreach ($query->result_array() as $key) 
            {
                $getBalance = $this->db->query("SELECT Debit
                 FROM  pos_accounts_generaljournal_entries
                  WHERE SaleId = ".$key["SaleId"]."");

                // calculate amount
                $lastPaidAmount = 0;
                foreach ($getBalance->result_array() as $lastBalance) 
                {
                    $lastPaidAmount += $lastBalance['Debit'];
                }

                $allSales = $this->Sale_model->GetInvoiceSales($key['SaleId']);
                $previousBalance = 0;
                foreach($allSales as $sale){
                    $previousBalance += $sale['TotalAmount'];
                }
                $BankAbbr = '';
                $bn = array(
                    'SaleId' => trim($key['SaleId']),
                    'UniqueId' => trim($key['UniqueId']),
                    'PreviousBalance' => $previousBalance - $lastPaidAmount
                );
			
		        $ChartOfAccount[] = $bn;
		    }
                          
		return $ChartOfAccount;
    }

}
?>