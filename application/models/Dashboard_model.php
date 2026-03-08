<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dashboard_model extends CI_Model{
	
	function __construct(){
	
		parent::__construct();
	$this->tbl_vendor = "pos_vendor";
                $this->tbl_customers = "pos_customer";
		$this->tbl_category = "pos_category";
                $this->tbl_productgroup = "pos_productgroup";
		$this->tbl_products = "pos_products";
                $this->tbl_purchase = "pos_purchase";
                $this->tbl_sales = "pos_sales";
                $this->tbl_purchase_detail = "pos_purchase_details";
                $this->tbl_sales_detail = "pos_sales_detail";
			$this->tbl_accounts_generaljournal = "pos_accounts_generaljournal";
			$this->tbl_accounts_generaljournal_entries = "pos_accounts_generaljournal_entries";
                $this->tbl_accounts_chartofaccount = "pos_accounts_chartofaccount";
                $this->tbl_accounts_generaljournal_entries = "pos_accounts_generaljournal_entries";
	}


	public function CustomerOutstanding()
	{
                $this->db->select(''
                . 'pos_accounts_chartofaccount.ChartOfAccountId,'
                . 'pos_accounts_chartofaccount.ChartOfAccountCategoryId,'
                . 'pos_accounts_chartofaccount.ChartOfAccountControlId,'
                . 'pos_accounts_chartofaccount.ChartOfAccountCode,'
                . 'pos_accounts_chartofaccount.ChartOfAccountTitle,'
                . 'pos_accounts_generaljournal_entries.Recipient,'
                . 'pos_accounts_generaljournal.TransactionDate,'
                . 'SUM(pos_accounts_generaljournal.TotalDebit) AS TotalDebit,'
                . 'SUM(pos_accounts_generaljournal.TotalCredit) AS TotalCredit,'
                . 'SUM(pos_accounts_generaljournal_entries.Debit) AS Debit,'
                . 'SUM(pos_accounts_generaljournal_entries.Credit) AS Credit,'
                );
		$this->db->from($this->tbl_accounts_chartofaccount);
		$this->db->join($this->tbl_accounts_generaljournal_entries, $this->tbl_accounts_generaljournal_entries.'.ChartOfAccountId = '.$this->tbl_accounts_chartofaccount.'.ChartOfAccountId', 'left');
        $this->db->join($this->tbl_accounts_generaljournal, $this->tbl_accounts_generaljournal.'.GeneralJournalId = '.$this->tbl_accounts_generaljournal_entries.'.GeneralJournalId', 'left');
/*        if($AsOfDate){$this->db->where('pos_accounts_generaljournal.TransactionDate <=',$AsOfDate);}
        if($ChartOfAccountId!=0) { $this->db->where('pos_accounts_chartofaccount.ChartOfAccountId',$ChartOfAccountId); }*/
        $this->db->where('pos_accounts_chartofaccount.ChartOfAccountControlId',2);
		$this->db->group_by('pos_accounts_chartofaccount.ChartOfAccountId');
                $query = $this->db->get();
		return $query->result_array();

    }

	public function VendorOutstanding()
	{
                $this->db->select(''
                . 'pos_accounts_chartofaccount.ChartOfAccountId,'
                . 'pos_accounts_chartofaccount.ChartOfAccountCategoryId,'
                . 'pos_accounts_chartofaccount.ChartOfAccountControlId,'
                . 'pos_accounts_chartofaccount.ChartOfAccountCode,'
                . 'pos_accounts_chartofaccount.ChartOfAccountTitle,'
                . 'pos_accounts_generaljournal_entries.Recipient,'
                . 'pos_accounts_generaljournal.TransactionDate,'
//                . 'pos_accounts_generaljournal_entries.Debit,'
//                . 'pos_accounts_generaljournal_entries.Credit,'
                . 'SUM(pos_accounts_generaljournal_entries.Debit) AS Debit,'
                . 'SUM(pos_accounts_generaljournal_entries.Credit) AS Credit,'
                );
		$this->db->from($this->tbl_accounts_chartofaccount);
		$this->db->join($this->tbl_accounts_generaljournal_entries, $this->tbl_accounts_generaljournal_entries.'.ChartOfAccountId = '.$this->tbl_accounts_chartofaccount.'.ChartOfAccountId', 'left');
        $this->db->join($this->tbl_accounts_generaljournal, $this->tbl_accounts_generaljournal.'.GeneralJournalId = '.$this->tbl_accounts_generaljournal_entries.'.GeneralJournalId', 'left');
/*        if($AsOfDate){$this->db->where('pos_accounts_generaljournal.TransactionDate <=',$AsOfDate);}
        if($ChartOfAccountId!=0) { $this->db->where('pos_accounts_chartofaccount.ChartOfAccountId',$ChartOfAccountId); }*/
        $this->db->where('pos_accounts_chartofaccount.ChartOfAccountControlId',3);
		$this->db->group_by('pos_accounts_chartofaccount.ChartOfAccountId');
                $query = $this->db->get();
		return $query->result_array();

    }


	public function CurrentMonthSales()
	{
		$Date = date('Y-m');
		$CurrentDate = $Date."- 01";

            $this->db->select(''
		. 'SUM(pos_sales_detail.NetAmount) AS NetAmount');
		$this->db->from($this->tbl_sales);
		$this->db->join($this->tbl_sales_detail, $this->tbl_sales_detail.'.SaleId = '.$this->tbl_sales.'.SaleId');
		$this->db->where('pos_sales.SaleDate >=', $CurrentDate);
                $query = $this->db->get();
            if($query->num_rows() > 0) {
			return $query->result_array();
            }
	}	


	public function CurrentMonthPurchase()
	{
		$Date = date('Y-m');
		$CurrentDate = $Date.'-01';
	    $EndDate = date('Y-m-d');

                $this->db->select(''
		. 'SUM(pos_purchase_details.NetAmount) AS NetAmount');
		$this->db->from($this->tbl_purchase);
		$this->db->join($this->tbl_purchase_detail, $this->tbl_purchase_detail.'.PurchaseId = '.$this->tbl_purchase.'.PurchaseId');
		$this->db->where('pos_purchase.PurchaseDate >=', $CurrentDate);
		$this->db->where('pos_purchase.PurchaseDate <=', $EndDate);
                $query = $this->db->get();
            if($query->num_rows() > 0) {
			return $query->result_array();
            }
	}

	public function CancelledSales()
	{
        $this->db->select('*');
		$this->db->from($this->tbl_sales);
		$this->db->join($this->tbl_sales_detail, $this->tbl_sales_detail.'.SaleId = '.$this->tbl_sales.'.SaleId');
		$this->db->join($this->tbl_customers, $this->tbl_customers.'.CustomerId = '.$this->tbl_sales.'.CustomerId');
		$this->db->where('pos_sales.SaleStatus', 'Cancel');
		$this->db->group_by($this->tbl_sales.'.SaleId');
        $query = $this->db->get();
		return $query->result_array();
	}

	public function CancelledPurchases()
	{
        $this->db->select('*');
		$this->db->from($this->tbl_purchase);
		$this->db->join($this->tbl_purchase_detail, $this->tbl_purchase_detail.'.PurchaseId = '.$this->tbl_purchase.'.PurchaseId');
		$this->db->join($this->tbl_vendor, $this->tbl_vendor.'.VendorId = '.$this->tbl_purchase.'.VendorId');
		$this->db->where('pos_purchase.PurchaseStatus', 'Cancel');
		$this->db->group_by($this->tbl_purchase.'.PurchaseId');
        $query = $this->db->get();
		return $query->result_array();
	}

	function TotalSales()
	{   
	    $StartDate = '2019-05-01';
	    $EndDate = date('Y-m-d');
	    
	    $ConditionDate = "pos_sales.SaleDate BETWEEN '".$StartDate."' AND '".$EndDate."' ";
            
            $this->db->select(''
		. 'SUM(pos_sales_detail.NetAmount) AS NetAmount');
		$this->db->from($this->tbl_sales);
		$this->db->join($this->tbl_sales_detail, $this->tbl_sales_detail.'.SaleId = '.$this->tbl_sales.'.SaleId');
		$this->db->where($ConditionDate);
                $query = $this->db->get();
                
                if($query->num_rows() > 0) {
		return $query->result_array();
                }       
        }
	
	
	function TotalPurchases()
	{   
	    $StartDate = '2019-06-01';
	    $EndDate = date('Y-m-d');
	    
	    $ConditionDate = "pos_purchase.PurchaseDate BETWEEN '".$StartDate."' AND '".$EndDate."' ";

                $this->db->select(''
		. 'SUM(pos_purchase_details.NetAmount) AS NetAmount');
		$this->db->from($this->tbl_purchase);
		$this->db->join($this->tbl_purchase_detail, $this->tbl_purchase_detail.'.PurchaseId = '.$this->tbl_purchase.'.PurchaseId');
		$this->db->where($ConditionDate);
                $query = $this->db->get();
                
                if($query->num_rows() > 0) {
		return $query->result_array();
                }       
        }
	
	
	function TotalCustomers()
	{   
	    $StartDate = '2018-07-01';
	    $EndDate = date('Y-m-d');
	    

                $this->db->select(''
		. 'COUNT(pos_customer.CustomerId) AS TotalCustomers');
		$this->db->from($this->tbl_customers);
	        $query = $this->db->get();
                
                if($query->num_rows() > 0) {
		return $query->result_array();
                }       
        }
	
	
	function TotalVendors()
	{   
	    $StartDate = '2018-07-01';
	    $EndDate = date('Y-m-d');
	    
	    //$ConditionDate = "pos_salesorder.SaleOrderDate BETWEEN '".$StartDate."' AND '".$EndDate."' ";
            //$ProductArray = array();

                $this->db->select(''
		. 'COUNT(pos_vendor.VendorId) AS TotalVendors');
		$this->db->from($this->tbl_vendor);
	        $query = $this->db->get();
                if($query->num_rows() > 0) {
		return $query->result_array();
                }       
        }

    public function DashboardSubAssets()
    {
    $CategoryId = $this->input->get('CId');
	    $ControlCodeId = $this->input->get('CCId');
	    $ChartOfAccountId = $this->input->get('COAId');
	    
	    $StartDate =date('Y-m-d', strtotime($this->input->get('StartDate')));
	    $EndDate =date('Y-m-d', strtotime($this->input->get('EndDate')));

	    $data['Roles'] = $this->Employee_model->GetRoles();
	    $data['AdministrationRoles'] = $this->Employee_model->GetAdministrationRoles($this->session->userdata('EmployeeId'));
	    $data['SalesRoles'] = $this->Employee_model->GetSalesRoles($this->session->userdata('EmployeeId'));
	    $data['PurchasesRoles'] = $this->Employee_model->GetPurchasesRoles($this->session->userdata('EmployeeId'));
	    $data['RegistrationRoles'] = $this->Employee_model->GetRegistrationRoles($this->session->userdata('EmployeeId'));
	    $data['TransactionRoles'] = $this->Employee_model->GetTransactionRoles($this->session->userdata('EmployeeId'));
	    $data['ReportsRoles'] = $this->Employee_model->GetReportsRoles($this->session->userdata('EmployeeId'));
	    
	    if($CategoryId == 1 && $ControlCodeId == 3){
			$data['Detailss'] = $this->Customer_model->GetCustomerById($ChartOfAccountId);
		}
		if($CategoryId == 2 && $ControlCodeId == 2){
			$data['Detailss']   = $this->Vendor_model->GetVendorById($ChartOfAccountId);
		}

		$data['CategoryId']		= $CategoryId;
		$data['ControlCodeId']	= $ControlCodeId;
	   	   
	    $data['LedgerReport'] = $this->AccountReport_model->LedgerReport($StartDate,$EndDate,$CategoryId,$ControlCodeId,$ChartOfAccountId);
	    $data['SubLedgerReport'] = $this->AccountReport_model->SubLedgerReport($StartDate,$EndDate,$CategoryId,$ControlCodeId,$ChartOfAccountId);
	    $data['OpenningBalance'] = $this->AccountReport_model->GetOpenningBalance($StartDate,$EndDate,$CategoryId,$ControlCodeId,$ChartOfAccountId);
		  //  print_r($data['SubLedgerReport']);
//		    echo $this->output->enable_profiler();
	    $data['GetSettingInformation'] = $this->Employee_model->GetSettingInformation();
	    $this->load->view('report/accountreports/view_ledgerreport', $data);
    }
	public function DashboardSubLedgerReport()
	{
            $StartDate='2023-01-01';
            $EndDate=date('Y-m-d');
            $CategoryId=1;
            $ControlCodeId=4;
            $ChartOfAccountId='undefined';
    
            $conditionArray = array();
            if($CategoryId != 0 && $CategoryId != '' && $CategoryId != 'undefined')
                $conditionArray['pos_accounts_chartofaccount_categories.ChartOfAccountCategoryId'] = $CategoryId;
            if($ControlCodeId != 0 && $ControlCodeId != '' && $ControlCodeId != 'undefined')
                $conditionArray['pos_accounts_chartofaccount_controls.ChartOfAccountControlId'] = $ControlCodeId;
            if($ChartOfAccountId != 0 && $ChartOfAccountId != '' && $ChartOfAccountId != 'undefined')
                $conditionArray['pos_accounts_chartofaccount.ChartOfAccountId'] = $ChartOfAccountId;

            $ConditionDate = " 1=1";
            // $ConditionDate .=" AND pos_accounts_generaljournal.TransactionDate BETWEEN '".$StartDate."' AND '".$EndDate."' ";
            $this->db->select('pos_accounts_chartofaccount.ChartOfAccountId');
            $this->db->from('pos_accounts_generaljournal');
            $this->db->join('pos_accounts_generaljournal_entries','pos_accounts_generaljournal_entries.GeneralJournalId=pos_accounts_generaljournal.GeneralJournalId');
            $this->db->join('pos_accounts_chartofaccount','pos_accounts_chartofaccount.ChartOfAccountId=pos_accounts_generaljournal_entries.ChartOfAccountId');
            $this->db->join('pos_accounts_chartofaccount_controls','pos_accounts_chartofaccount_controls.ChartOfAccountControlId=pos_accounts_chartofaccount.ChartOfAccountControlId');
            $this->db->join('pos_accounts_chartofaccount_categories','pos_accounts_chartofaccount_categories.ChartOfAccountCategoryId=pos_accounts_chartofaccount.ChartOfAccountCategoryId');
            $this->db->where($conditionArray);
            $this->db->distinct('pos_accounts_chartofaccount.ChartOfAccountId');
            $this->db->where($ConditionDate);
            $this->db->order_by("pos_accounts_generaljournal.TransactionDate");
            $query = $this->db->get();
            $arra=$query->result_array();
            // print_r($arra); die();
            $array_data=[];
            
            foreach($arra as $key=>$value){
             $ChartOfAccountId=$value['ChartOfAccountId'];
            //  print_r($ChartOfAccountId);
            $conditionArray = array();
            if($CategoryId != 0 && $CategoryId != '' && $CategoryId != 'undefined')
                $conditionArray['pos_accounts_chartofaccount_categories.ChartOfAccountCategoryId'] = $CategoryId;
            if($ControlCodeId != 0 && $ControlCodeId != '' && $ControlCodeId != 'undefined')
                $conditionArray['pos_accounts_chartofaccount_controls.ChartOfAccountControlId'] = $ControlCodeId;
            if($ChartOfAccountId != 0 && $ChartOfAccountId != '' && $ChartOfAccountId != 'undefined')
                $conditionArray['pos_accounts_chartofaccount.ChartOfAccountId'] = $ChartOfAccountId;

            $ConditionDate = " 1=1 AND pos_accounts_generaljournal.TransactionDate BETWEEN '".$StartDate."' AND '".$EndDate."' ";
              $this->db->select('
            pos_accounts_generaljournal.SaleId,
            pos_accounts_generaljournal.IsInvoiceReceipt,
            pos_accounts_chartofaccount.ChartOfAccountId,
            pos_accounts_chartofaccount.ChartOfAccountTitle,
            pos_accounts_generaljournal.GeneralJournalId,
            pos_accounts_generaljournal.TransactionDate,
            pos_accounts_generaljournal.Reference,
            pos_accounts_generaljournal_entries.Detail,
            pos_accounts_generaljournal_entries.Debit,
            pos_accounts_generaljournal_entries.Credit,
            pos_accounts_generaljournal.VoucherType,
            ');
            $this->db->from('pos_accounts_generaljournal');
            $this->db->join('pos_accounts_generaljournal_entries','pos_accounts_generaljournal_entries.GeneralJournalId=pos_accounts_generaljournal.GeneralJournalId');
            $this->db->join('pos_accounts_chartofaccount','pos_accounts_chartofaccount.ChartOfAccountId=pos_accounts_generaljournal_entries.ChartOfAccountId');
            $this->db->join('pos_accounts_chartofaccount_controls','pos_accounts_chartofaccount_controls.ChartOfAccountControlId=pos_accounts_chartofaccount.ChartOfAccountControlId');
            $this->db->join('pos_accounts_chartofaccount_categories','pos_accounts_chartofaccount_categories.ChartOfAccountCategoryId=pos_accounts_chartofaccount.ChartOfAccountCategoryId');
            
            $this->db->select_sum('pos_accounts_generaljournal_entries.Debit');
            $this->db->select_sum('pos_accounts_generaljournal_entries.Credit');
            $this->db->where($conditionArray);
            // $this->db->where($ConditionDate);
            $this->db->order_by("pos_accounts_generaljournal.TransactionDate");
            $query = $this->db->get();
	         $array_data[]=$query->row();
            
            }
            // print_r($array_data);
            // die();
            return $array_data;
    }
        public function DashboardSubLedgerReportCash()
	{
            $StartDate='2023-01-01';
            // $EndDate='2023-04-30';
             $EndDate=date('Y-m-d');
            $CategoryId=1;
            $ControlCodeId=1;
            $ChartOfAccountId='undefined';
    
            $conditionArray = array();
            if($CategoryId != 0 && $CategoryId != '' && $CategoryId != 'undefined')
                $conditionArray['pos_accounts_chartofaccount_categories.ChartOfAccountCategoryId'] = $CategoryId;
            if($ControlCodeId != 0 && $ControlCodeId != '' && $ControlCodeId != 'undefined')
                $conditionArray['pos_accounts_chartofaccount_controls.ChartOfAccountControlId'] = $ControlCodeId;
            if($ChartOfAccountId != 0 && $ChartOfAccountId != '' && $ChartOfAccountId != 'undefined')
                $conditionArray['pos_accounts_chartofaccount.ChartOfAccountId'] = $ChartOfAccountId;

            $ConditionDate = " 1=1 ";
            // $ConditionDate .= " AND pos_accounts_generaljournal.TransactionDate BETWEEN '".$StartDate."' AND '".$EndDate."' ";
            $this->db->select('pos_accounts_chartofaccount.ChartOfAccountId');
            $this->db->from('pos_accounts_generaljournal');
            $this->db->join('pos_accounts_generaljournal_entries','pos_accounts_generaljournal_entries.GeneralJournalId=pos_accounts_generaljournal.GeneralJournalId');
            $this->db->join('pos_accounts_chartofaccount','pos_accounts_chartofaccount.ChartOfAccountId=pos_accounts_generaljournal_entries.ChartOfAccountId');
            $this->db->join('pos_accounts_chartofaccount_controls','pos_accounts_chartofaccount_controls.ChartOfAccountControlId=pos_accounts_chartofaccount.ChartOfAccountControlId');
            $this->db->join('pos_accounts_chartofaccount_categories','pos_accounts_chartofaccount_categories.ChartOfAccountCategoryId=pos_accounts_chartofaccount.ChartOfAccountCategoryId');
            $this->db->distinct('pos_accounts_chartofaccount.ChartOfAccountId');
            $this->db->where($conditionArray);
            $this->db->where($ConditionDate);
            $this->db->order_by("pos_accounts_generaljournal.TransactionDate");
            $query = $this->db->get();
            $arra=$query->result_array();
            $array_data=[];
            
            foreach($arra as $key=>$value){
                // print_r($value['']);
                $ChartOfAccountId=$value['ChartOfAccountId'];
          $conditionArray = array();
            if($CategoryId != 0 && $CategoryId != '' && $CategoryId != 'undefined')
                $conditionArray['pos_accounts_chartofaccount_categories.ChartOfAccountCategoryId'] = $CategoryId;
            if($ControlCodeId != 0 && $ControlCodeId != '' && $ControlCodeId != 'undefined')
                $conditionArray['pos_accounts_chartofaccount_controls.ChartOfAccountControlId'] = $ControlCodeId;
            if($ChartOfAccountId != 0 && $ChartOfAccountId != '' && $ChartOfAccountId != 'undefined')
                $conditionArray['pos_accounts_chartofaccount.ChartOfAccountId'] = $ChartOfAccountId;

            $ConditionDate = " 1=1 AND pos_accounts_generaljournal.TransactionDate BETWEEN '".$StartDate."' AND '".$EndDate."' ";
                $this->db->select('
            pos_accounts_generaljournal.SaleId,
            pos_accounts_generaljournal.IsInvoiceReceipt,
            pos_accounts_chartofaccount.ChartOfAccountId,
            pos_accounts_chartofaccount.ChartOfAccountTitle,
            pos_accounts_generaljournal.GeneralJournalId,
            pos_accounts_generaljournal.TransactionDate,
            pos_accounts_generaljournal.Reference,
            pos_accounts_generaljournal_entries.Detail,
            pos_accounts_generaljournal_entries.Debit,
            pos_accounts_generaljournal_entries.Credit,
            pos_accounts_generaljournal.VoucherType,
            ');
            $this->db->from('pos_accounts_generaljournal');
            $this->db->join('pos_accounts_generaljournal_entries','pos_accounts_generaljournal_entries.GeneralJournalId=pos_accounts_generaljournal.GeneralJournalId');
            $this->db->join('pos_accounts_chartofaccount','pos_accounts_chartofaccount.ChartOfAccountId=pos_accounts_generaljournal_entries.ChartOfAccountId');
            $this->db->join('pos_accounts_chartofaccount_controls','pos_accounts_chartofaccount_controls.ChartOfAccountControlId=pos_accounts_chartofaccount.ChartOfAccountControlId');
            $this->db->join('pos_accounts_chartofaccount_categories','pos_accounts_chartofaccount_categories.ChartOfAccountCategoryId=pos_accounts_chartofaccount.ChartOfAccountCategoryId');
            $this->db->where($conditionArray);
            $this->db->select_sum('pos_accounts_generaljournal_entries.Debit');
            $this->db->select_sum('pos_accounts_generaljournal_entries.Credit');
            $this->db->where($ConditionDate);
         
            $this->db->order_by("pos_accounts_generaljournal.TransactionDate");
            $query = $this->db->get();
            $array_data[]=$query->row();
            
            }
            return $array_data;
            
            
        }
        
        public function TotalDebitOrCredit(){
            
            $StartDate=date('Y-m-01');
             $EndDate=date('Y-m-d');
           $ConditionDate = " 1=1 AND pos_accounts_generaljournal.TransactionDate BETWEEN '".$StartDate."' AND '".$EndDate."' ";
           
           $conditionArray = array();
            // $conditionArray['pos_accounts_chartofaccount.ChartOfAccountId'] = 1;
             $conditionArray['pos_accounts_chartofaccount_categories.ChartOfAccountCategoryId'] = 1;
             $conditionArray['pos_accounts_chartofaccount_controls.ChartOfAccountControlId'] = 1;
               $this->db->select('

            SUM(pos_accounts_generaljournal_entries.Debit) as Debit,
            SUM(pos_accounts_generaljournal_entries.Credit) as Credit,
            ');
            $this->db->from('pos_accounts_generaljournal');
            $this->db->join('pos_accounts_generaljournal_entries','pos_accounts_generaljournal_entries.GeneralJournalId=pos_accounts_generaljournal.GeneralJournalId');
            $this->db->join('pos_accounts_chartofaccount','pos_accounts_chartofaccount.ChartOfAccountId=pos_accounts_generaljournal_entries.ChartOfAccountId');
            $this->db->order_by('ChartOfAccountCode ASC');
            $this->db->join('pos_accounts_chartofaccount_controls','pos_accounts_chartofaccount_controls.ChartOfAccountControlId=pos_accounts_chartofaccount.ChartOfAccountControlId');
            $this->db->join('pos_accounts_chartofaccount_categories','pos_accounts_chartofaccount_categories.ChartOfAccountCategoryId=pos_accounts_chartofaccount.ChartOfAccountCategoryId');
            $this->db->order_by("pos_accounts_generaljournal.TransactionDate");
             $this->db->where($ConditionDate);
              $this->db->where($conditionArray);
            $query = $this->db->get();
            return $query->row_array(); // Fetch a single row as an array

        }
        
    public function DashboardLedgerReport()
	{
            $StartDate='2023-01-01';
            $EndDate='2023-04-30';
            $CategoryId=1;
            $ControlCodeId=4;
            $ChartOfAccountId='undefined';
   
            
            $conditionArray = array();
            if($CategoryId != 0 && $CategoryId != '' && $CategoryId != 'undefined')
                $conditionArray['pos_accounts_chartofaccount_categories.ChartOfAccountCategoryId'] = $CategoryId;
            if($ControlCodeId != 0 && $ControlCodeId != '' && $ControlCodeId != 'undefined')
                $conditionArray['pos_accounts_chartofaccount_controls.ChartOfAccountControlId'] = $ControlCodeId;
            if($ChartOfAccountId != 0 && $ChartOfAccountId != '' && $ChartOfAccountId != 'undefined')
                $conditionArray['pos_accounts_chartofaccount.ChartOfAccountId'] = $ChartOfAccountId;

            $ConditionDate = " 1=1 AND pos_accounts_generaljournal.TransactionDate BETWEEN '".$StartDate."' AND '".$EndDate."' ";

            $this->db->select('
            pos_accounts_chartofaccount.ChartOfAccountCategoryId,
	    pos_accounts_chartofaccount_controls.ChartOfAccountControlId,
            pos_accounts_chartofaccount.ChartOfAccountId,
            pos_accounts_chartofaccount.ChartOfAccountTitle,
            pos_accounts_chartofaccount.ChartOfAccountCode,
            pos_accounts_chartofaccount_categories.DebitIncrease,
	    pos_accounts_chartofaccount_categories.CreditIncrease
            ');
            $this->db->from('pos_accounts_generaljournal');
            $this->db->join('pos_accounts_generaljournal_entries','pos_accounts_generaljournal_entries.GeneralJournalId=pos_accounts_generaljournal.GeneralJournalId');
            $this->db->join('pos_accounts_chartofaccount','pos_accounts_chartofaccount.ChartOfAccountId=pos_accounts_generaljournal_entries.ChartOfAccountId');
            $this->db->join('pos_accounts_chartofaccount_controls','pos_accounts_chartofaccount_controls.ChartOfAccountControlId=pos_accounts_chartofaccount.ChartOfAccountControlId');
            $this->db->join('pos_accounts_chartofaccount_categories','pos_accounts_chartofaccount_categories.ChartOfAccountCategoryId=pos_accounts_chartofaccount.ChartOfAccountCategoryId');
            $this->db->where($conditionArray);
            // $this->db->where($ConditionDate);
            $this->db->group_by("pos_accounts_chartofaccount.ChartOfAccountId");
//                echo $this->db->get_compiled_select();
            $query = $this->db->get();
            return $query->result_array();            
        }

	
}
?>