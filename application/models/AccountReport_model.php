<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class AccountReport_model extends CI_Model{
	
	function __construct()
	{
            parent::__construct();
            $this->tbl_accounts = "pos_accounts";
            $this->tbl_accounts = "pos_accounts";
            $this->tbl_accounts_group = "pos_accounts_group";
            $this->tbl_accounts_chartofaccount = "pos_accounts_chartofaccount";
            $this->tbl_accounts_generaljournal = "pos_accounts_generaljournal";
            $this->tbl_customer = "pos_customer";
            $this->tbl_vendor = "pos_vendor";
            $this->tbl_accounts_generaljournal_entries = "pos_accounts_generaljournal_entries";
       }
	
	
        function LedgerReport($StartDate,$EndDate,$CategoryId,$ControlCodeId,$ChartOfAccountId)
        {
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
            $this->db->where($ConditionDate);
            $this->db->group_by("pos_accounts_chartofaccount.ChartOfAccountId");
//                echo $this->db->get_compiled_select();
            $query = $this->db->get();
            return $query->result_array();            
        }
        
        function SubLedgerReport($StartDate,$EndDate,$CategoryId,$ControlCodeId,$ChartOfAccountId)
        {
            $conditionArray = array();
            if($CategoryId != 0 && $CategoryId != '' && $CategoryId != 'undefined')
                $conditionArray['pos_accounts_chartofaccount_categories.ChartOfAccountCategoryId'] = $CategoryId;
            if($ControlCodeId != 0 && $ControlCodeId != '' && $ControlCodeId != 'undefined')
                $conditionArray['pos_accounts_chartofaccount_controls.ChartOfAccountControlId'] = $ControlCodeId;
            if($ChartOfAccountId != 0 && $ChartOfAccountId != '' && $ChartOfAccountId != 'undefined')
                $conditionArray['pos_accounts_chartofaccount.ChartOfAccountId'] = $ChartOfAccountId;

            $ConditionDate = " 1=1 AND pos_accounts_generaljournal.TransactionDate BETWEEN '".$StartDate."' AND '".$EndDate."' ";
            $this->db->select('
            pos_accounts_chartofaccount.ChartOfAccountId,
            pos_accounts_chartofaccount.ChartOfAccountTitle,
            pos_accounts_generaljournal.GeneralJournalId,
            pos_accounts_generaljournal.TransactionDate,
            pos_accounts_generaljournal.SaleId,
            pos_accounts_generaljournal.SaleUniqueId,
            pos_accounts_generaljournal.PurchaseId,
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
            $this->db->where($ConditionDate);
            $this->db->order_by("pos_accounts_generaljournal.TransactionDate");
            $query = $this->db->get();
            return $query->result_array();
        }
	
	
	function CustomerLedgerReport($StartDate,$EndDate,$CategoryId,$ControlCodeId,$ChartOfAccountId)
        {
	    
	    $CategoryId = 1;
	   // $ControlCodeId1 = 1;
	    $ControlCodeId2 = 3;
	    if($ChartOfAccountId != 0 && $ChartOfAccountId != '' && $ChartOfAccountId != 'undefined')
	    {
		$conditionArray = "pos_accounts_chartofaccount_categories.ChartOfAccountCategoryId = '".$CategoryId."' AND pos_accounts_chartofaccount_controls.ChartOfAccountControlId = '".$ControlCodeId2."' AND pos_accounts_chartofaccount.ChartOfAccountId = '".$ChartOfAccountId."'";
		//$conditionArray = "pos_accounts_chartofaccount_categories.ChartOfAccountCategoryId = '".$CategoryId."' AND (pos_accounts_chartofaccount_controls.ChartOfAccountControlId =  '".$ControlCodeId1."' OR pos_accounts_chartofaccount_controls.ChartOfAccountControlId =  '".$ControlCodeId2."') AND pos_accounts_chartofaccount.ChartOfAccountId = '".$ChartOfAccountId."'";
	    }
	    else
	    {
		$conditionArray = "pos_accounts_chartofaccount_categories.ChartOfAccountCategoryId = '".$CategoryId."' AND pos_accounts_chartofaccount_controls.ChartOfAccountControlId = '".$ControlCodeId2."'";
		//$conditionArray = "pos_accounts_chartofaccount_categories.ChartOfAccountCategoryId = '".$CategoryId."' AND (pos_accounts_chartofaccount_controls.ChartOfAccountControlId =  '".$ControlCodeId1."' OR pos_accounts_chartofaccount_controls.ChartOfAccountControlId =  '".$ControlCodeId2."')";
	    }

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
            $this->db->where($ConditionDate);
            $this->db->group_by("pos_accounts_chartofaccount.ChartOfAccountId");
//                echo $this->db->get_compiled_select();
            $query = $this->db->get();
            return $query->result_array();            
        }
        
        function CustomerSubLedgerReport($StartDate,$EndDate,$CategoryId,$ControlCodeId,$ChartOfAccountId,$invoice = null)
        {	  
	    $CategoryId = 1;
	   // $ControlCodeId1 = 1;
	    $ControlCodeId2 = 3;
	    if($ChartOfAccountId != 0 && $ChartOfAccountId != '' && $ChartOfAccountId != 'undefined')
	    {
	        
		$conditionArray = "pos_accounts_chartofaccount_categories.ChartOfAccountCategoryId = '".$CategoryId."' AND pos_accounts_chartofaccount_controls.ChartOfAccountControlId = '".$ControlCodeId2."' AND pos_accounts_chartofaccount.ChartOfAccountId = '".$ChartOfAccountId."'";
		//$conditionArray = "pos_accounts_chartofaccount_categories.ChartOfAccountCategoryId = '".$CategoryId."' AND (pos_accounts_chartofaccount_controls.ChartOfAccountControlId =  '".$ControlCodeId1."' OR pos_accounts_chartofaccount_controls.ChartOfAccountControlId =  '".$ControlCodeId2."') AND pos_accounts_chartofaccount.ChartOfAccountId = '".$ChartOfAccountId."'";
	    }
	    else
	    {
		$conditionArray = "pos_accounts_chartofaccount_categories.ChartOfAccountCategoryId = '".$CategoryId."' AND pos_accounts_chartofaccount_controls.ChartOfAccountControlId = '".$ControlCodeId2."'";
		//$conditionArray = "pos_accounts_chartofaccount_categories.ChartOfAccountCategoryId = '".$CategoryId."' AND (pos_accounts_chartofaccount_controls.ChartOfAccountControlId =  '".$ControlCodeId1."' OR pos_accounts_chartofaccount_controls.ChartOfAccountControlId =  '".$ControlCodeId2."')";
	    }
	    
            $ConditionDate = " 1=1 AND pos_accounts_generaljournal.TransactionDate BETWEEN '".$StartDate."' AND '".$EndDate."' ";
            
	    $this->db->select('
            pos_accounts_chartofaccount.ChartOfAccountId,
            pos_accounts_chartofaccount.ChartOfAccountTitle,
            pos_accounts_generaljournal.GeneralJournalId,
            pos_accounts_generaljournal.TransactionDate,
            pos_accounts_generaljournal.Reference,
            pos_accounts_generaljournal_entries.Detail,
            SUM(pos_accounts_generaljournal_entries.Debit) AS Debit,
            SUM(pos_accounts_generaljournal_entries.Credit) AS Credit,
            pos_accounts_generaljournal.VoucherType,
	        pos_accounts_generaljournal.SaleId,
            pos_accounts_generaljournal.SaleReturnId,
            ');
            $this->db->from('pos_accounts_generaljournal');
            $this->db->join('pos_accounts_generaljournal_entries','pos_accounts_generaljournal_entries.GeneralJournalId=pos_accounts_generaljournal.GeneralJournalId');
            $this->db->join('pos_accounts_chartofaccount','pos_accounts_chartofaccount.ChartOfAccountId=pos_accounts_generaljournal_entries.ChartOfAccountId');
            $this->db->join('pos_accounts_chartofaccount_controls','pos_accounts_chartofaccount_controls.ChartOfAccountControlId=pos_accounts_chartofaccount.ChartOfAccountControlId');
            $this->db->join('pos_accounts_chartofaccount_categories','pos_accounts_chartofaccount_categories.ChartOfAccountCategoryId=pos_accounts_chartofaccount.ChartOfAccountCategoryId');
            $this->db->where($conditionArray);
            $this->db->where($ConditionDate);
	        $this->db->group_by("pos_accounts_generaljournal_entries.GeneralJournalId");
            if(!$invoice) {$this->db->order_by("pos_accounts_generaljournal.TransactionDate"); }
            if($invoice) {$this->db->order_by("pos_accounts_generaljournal.TransactionDate", "desc"); }
            if($invoice) { $this->db->limit(3); }
            $query = $this->db->get();
            // echo "<pre>";
            // print_r($query->result_array());
            // echo "</pre>"; exit;
            return $query->result_array();
        }
	
	
	function GetCustomerOpenningBalance($StartDate,$EndDate,$CategoryId,$ControlCodeId,$ChartOfAccountId)
        {
           $CategoryId = 1;
	   // $ControlCodeId1 = 1;
	    $ControlCodeId2 = 3;
	    if($ChartOfAccountId != 0 && $ChartOfAccountId != '' && $ChartOfAccountId != 'undefined')
	    {
		$conditionArray = "pos_accounts_chartofaccount_categories.ChartOfAccountCategoryId = '".$CategoryId."' AND pos_accounts_chartofaccount_controls.ChartOfAccountControlId = '".$ControlCodeId2."' AND pos_accounts_chartofaccount.ChartOfAccountId = '".$ChartOfAccountId."'";
		//$conditionArray = "pos_accounts_chartofaccount_categories.ChartOfAccountCategoryId = '".$CategoryId."' AND (pos_accounts_chartofaccount_controls.ChartOfAccountControlId =  '".$ControlCodeId1."' OR pos_accounts_chartofaccount_controls.ChartOfAccountControlId =  '".$ControlCodeId2."') AND pos_accounts_chartofaccount.ChartOfAccountId = '".$ChartOfAccountId."'";
	    }
	    else
	    {
		$conditionArray = "pos_accounts_chartofaccount_categories.ChartOfAccountCategoryId = '".$CategoryId."' AND pos_accounts_chartofaccount_controls.ChartOfAccountControlId = '".$ControlCodeId2."'";
		//$conditionArray = "pos_accounts_chartofaccount_categories.ChartOfAccountCategoryId = '".$CategoryId."' AND (pos_accounts_chartofaccount_controls.ChartOfAccountControlId =  '".$ControlCodeId1."' OR pos_accounts_chartofaccount_controls.ChartOfAccountControlId =  '".$ControlCodeId2."')";
	    }

            $ConditionDate = " 1=1 AND pos_accounts_generaljournal.TransactionDate < '".$StartDate."'";

            $this->db->select('
	    if(pos_accounts_chartofaccount_categories.DebitIncrease = "1", SUM(pos_accounts_generaljournal_entries.Debit) - SUM(pos_accounts_generaljournal_entries.Credit), SUM(pos_accounts_generaljournal_entries.Credit) - SUM(pos_accounts_generaljournal_entries.Debit)) AS "Balance", pos_accounts_chartofaccount.ChartOfAccountId
            ');
            $this->db->from('pos_accounts_generaljournal');
            $this->db->join('pos_accounts_generaljournal_entries','pos_accounts_generaljournal_entries.GeneralJournalId=pos_accounts_generaljournal.GeneralJournalId');
            $this->db->join('pos_accounts_chartofaccount','pos_accounts_chartofaccount.ChartOfAccountId = pos_accounts_generaljournal_entries.ChartOfAccountId');
	    $this->db->join('pos_accounts_chartofaccount_controls','pos_accounts_chartofaccount_controls.ChartOfAccountControlId = pos_accounts_chartofaccount.ChartOfAccountControlId');
            $this->db->join('pos_accounts_chartofaccount_categories','pos_accounts_chartofaccount_categories.ChartOfAccountCategoryId = pos_accounts_chartofaccount.ChartOfAccountCategoryId');
            $this->db->where($conditionArray);
            $this->db->where($ConditionDate);
	    $this->db->group_by("pos_accounts_chartofaccount.ChartOfAccountId");
            $query = $this->db->get();
            return $query->result_array();            
        }
	
	
	function VendorLedgerReport($StartDate,$EndDate,$CategoryId,$ControlCodeId,$ChartOfAccountId)
        {
	    
	    $CategoryId = 2;
	   // $ControlCodeId1 = 1;
	    $ControlCodeId2 = 2;
	    if($ChartOfAccountId != 0 && $ChartOfAccountId != '' && $ChartOfAccountId != 'undefined')
	    {
		$conditionArray = "pos_accounts_chartofaccount_categories.ChartOfAccountCategoryId = '".$CategoryId."' AND pos_accounts_chartofaccount_controls.ChartOfAccountControlId = '".$ControlCodeId2."' AND pos_accounts_chartofaccount.ChartOfAccountId = '".$ChartOfAccountId."'";
		//$conditionArray = "pos_accounts_chartofaccount_categories.ChartOfAccountCategoryId = '".$CategoryId."' AND (pos_accounts_chartofaccount_controls.ChartOfAccountControlId =  '".$ControlCodeId1."' OR pos_accounts_chartofaccount_controls.ChartOfAccountControlId =  '".$ControlCodeId2."') AND pos_accounts_chartofaccount.ChartOfAccountId = '".$ChartOfAccountId."'";
	    }
	    else
	    {
		$conditionArray = "pos_accounts_chartofaccount_categories.ChartOfAccountCategoryId = '".$CategoryId."' AND pos_accounts_chartofaccount_controls.ChartOfAccountControlId = '".$ControlCodeId2."'";
		//$conditionArray = "pos_accounts_chartofaccount_categories.ChartOfAccountCategoryId = '".$CategoryId."' AND (pos_accounts_chartofaccount_controls.ChartOfAccountControlId =  '".$ControlCodeId1."' OR pos_accounts_chartofaccount_controls.ChartOfAccountControlId =  '".$ControlCodeId2."')";
	    }

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
            $this->db->where($ConditionDate);
            $this->db->group_by("pos_accounts_chartofaccount.ChartOfAccountId");
//                echo $this->db->get_compiled_select();
            $query = $this->db->get();
            return $query->result_array();            
        }
        
	
        function VendorSubLedgerReport($StartDate,$EndDate,$CategoryId,$ControlCodeId,$ChartOfAccountId)
        {	  
	    
	    $CategoryId = 2;
	   // $ControlCodeId1 = 1;
	    $ControlCodeId2 = 2;
	    if($ChartOfAccountId != 0 && $ChartOfAccountId != '' && $ChartOfAccountId != 'undefined')
	    {
		$conditionArray = "pos_accounts_chartofaccount_categories.ChartOfAccountCategoryId = '".$CategoryId."' AND pos_accounts_chartofaccount_controls.ChartOfAccountControlId = '".$ControlCodeId2."' AND pos_accounts_chartofaccount.ChartOfAccountId = '".$ChartOfAccountId."'";
		//$conditionArray = "pos_accounts_chartofaccount_categories.ChartOfAccountCategoryId = '".$CategoryId."' AND (pos_accounts_chartofaccount_controls.ChartOfAccountControlId =  '".$ControlCodeId1."' OR pos_accounts_chartofaccount_controls.ChartOfAccountControlId =  '".$ControlCodeId2."') AND pos_accounts_chartofaccount.ChartOfAccountId = '".$ChartOfAccountId."'";
	    }
	    else
	    {
		$conditionArray = "pos_accounts_chartofaccount_categories.ChartOfAccountCategoryId = '".$CategoryId."' AND pos_accounts_chartofaccount_controls.ChartOfAccountControlId = '".$ControlCodeId2."'";
		//$conditionArray = "pos_accounts_chartofaccount_categories.ChartOfAccountCategoryId = '".$CategoryId."' AND (pos_accounts_chartofaccount_controls.ChartOfAccountControlId =  '".$ControlCodeId1."' OR pos_accounts_chartofaccount_controls.ChartOfAccountControlId =  '".$ControlCodeId2."')";
	    }
	    
            $ConditionDate = " 1=1 AND pos_accounts_generaljournal.TransactionDate BETWEEN '".$StartDate."' AND '".$EndDate."' ";
            
	    $this->db->select('
            pos_accounts_chartofaccount.ChartOfAccountId,
            pos_accounts_chartofaccount.ChartOfAccountTitle,
            pos_accounts_generaljournal.GeneralJournalId,
            pos_accounts_generaljournal.TransactionDate,
            pos_accounts_generaljournal.Reference,
            pos_accounts_generaljournal_entries.Detail,
            SUM(pos_accounts_generaljournal_entries.Debit) AS Debit,
            SUM(pos_accounts_generaljournal_entries.Credit) AS Credit,
            pos_accounts_generaljournal.VoucherType,
	    pos_accounts_generaljournal.PurchaseId,
            ');
            $this->db->from('pos_accounts_generaljournal');
            $this->db->join('pos_accounts_generaljournal_entries','pos_accounts_generaljournal_entries.GeneralJournalId=pos_accounts_generaljournal.GeneralJournalId');
            $this->db->join('pos_accounts_chartofaccount','pos_accounts_chartofaccount.ChartOfAccountId=pos_accounts_generaljournal_entries.ChartOfAccountId');
            $this->db->join('pos_accounts_chartofaccount_controls','pos_accounts_chartofaccount_controls.ChartOfAccountControlId=pos_accounts_chartofaccount.ChartOfAccountControlId');
            $this->db->join('pos_accounts_chartofaccount_categories','pos_accounts_chartofaccount_categories.ChartOfAccountCategoryId=pos_accounts_chartofaccount.ChartOfAccountCategoryId');
            $this->db->where($conditionArray);
            $this->db->where($ConditionDate);
	    $this->db->group_by("pos_accounts_generaljournal_entries.GeneralJournalId");
            $this->db->order_by("pos_accounts_generaljournal.TransactionDate");
            $query = $this->db->get();
            return $query->result_array();
        }
	
	
	function GetVendorOpenningBalance($StartDate,$EndDate,$CategoryId,$ControlCodeId,$ChartOfAccountId)
        {
           $CategoryId = 1;
	   // $ControlCodeId1 = 1;
	    $ControlCodeId2 = 2;
	    if($ChartOfAccountId != 0 && $ChartOfAccountId != '' && $ChartOfAccountId != 'undefined')
	    {
		$conditionArray = "pos_accounts_chartofaccount_categories.ChartOfAccountCategoryId = '".$CategoryId."' AND pos_accounts_chartofaccount_controls.ChartOfAccountControlId = '".$ControlCodeId2."' AND pos_accounts_chartofaccount.ChartOfAccountId = '".$ChartOfAccountId."'";
		//$conditionArray = "pos_accounts_chartofaccount_categories.ChartOfAccountCategoryId = '".$CategoryId."' AND (pos_accounts_chartofaccount_controls.ChartOfAccountControlId =  '".$ControlCodeId1."' OR pos_accounts_chartofaccount_controls.ChartOfAccountControlId =  '".$ControlCodeId2."') AND pos_accounts_chartofaccount.ChartOfAccountId = '".$ChartOfAccountId."'";
	    }
	    else
	    {
		$conditionArray = "pos_accounts_chartofaccount_categories.ChartOfAccountCategoryId = '".$CategoryId."' AND pos_accounts_chartofaccount_controls.ChartOfAccountControlId = '".$ControlCodeId2."'";
		//$conditionArray = "pos_accounts_chartofaccount_categories.ChartOfAccountCategoryId = '".$CategoryId."' AND (pos_accounts_chartofaccount_controls.ChartOfAccountControlId =  '".$ControlCodeId1."' OR pos_accounts_chartofaccount_controls.ChartOfAccountControlId =  '".$ControlCodeId2."')";
	    }

            $ConditionDate = " 1=1 AND pos_accounts_generaljournal.TransactionDate < '".$StartDate."'";

            $this->db->select('
	    if(pos_accounts_chartofaccount_categories.DebitIncrease = "1", SUM(pos_accounts_generaljournal_entries.Debit) - SUM(pos_accounts_generaljournal_entries.Credit), SUM(pos_accounts_generaljournal_entries.Credit) - SUM(pos_accounts_generaljournal_entries.Debit)) AS "Balance", pos_accounts_chartofaccount.ChartOfAccountId
            ');
            $this->db->from('pos_accounts_generaljournal');
            $this->db->join('pos_accounts_generaljournal_entries','pos_accounts_generaljournal_entries.GeneralJournalId=pos_accounts_generaljournal.GeneralJournalId');
            $this->db->join('pos_accounts_chartofaccount','pos_accounts_chartofaccount.ChartOfAccountId = pos_accounts_generaljournal_entries.ChartOfAccountId');
	    $this->db->join('pos_accounts_chartofaccount_controls','pos_accounts_chartofaccount_controls.ChartOfAccountControlId = pos_accounts_chartofaccount.ChartOfAccountControlId');
            $this->db->join('pos_accounts_chartofaccount_categories','pos_accounts_chartofaccount_categories.ChartOfAccountCategoryId = pos_accounts_chartofaccount.ChartOfAccountCategoryId');
            $this->db->where($conditionArray);
            $this->db->where($ConditionDate);
	    $this->db->group_by("pos_accounts_chartofaccount.ChartOfAccountId");
            $query = $this->db->get();
            return $query->result_array();            
        }
	
	
	function GetIncomeAndExpenseCategories($Income, $Expense)
	{	    
	    $where = "pos_accounts_chartofaccount_categories.ChartOfAccountCategoryId = '".$Income."' OR pos_accounts_chartofaccount_categories.ChartOfAccountCategoryId = '".$Expense."'";
	    $this->db->where($where);
            $result = $this->db->get('pos_accounts_chartofaccount_categories')->result_array();
            return $result;
        }
	
	
	function GetIncomeAndExpenseControlCodes($Income, $Expense)
	{
	    $where = "(pos_accounts_chartofaccount_controls.ChartOfAccountCategoryId = '".$Income."' OR pos_accounts_chartofaccount_controls.ChartOfAccountCategoryId = '".$Expense."')";
	    $this->db->where($where);
	    $result = $this->db->get('pos_accounts_chartofaccount_controls')->result_array();
            return $result;
        }
	
	
	function GetIncomeAndExpenseChartOfAccount($Income,$Expense,$SDate,$EDate)
        {
	    
	    $where = "(pos_accounts_chartofaccount.ChartOfAccountCategoryId = '".$Income."' OR pos_accounts_chartofaccount.ChartOfAccountCategoryId = '".$Expense."') AND (pos_accounts_chartofaccount_controls.ChartOfAccountCategoryId = '".$Income."' OR pos_accounts_chartofaccount_controls.ChartOfAccountCategoryId = '".$Expense."')";  
            
	    $ConditionDate = " 1=1 AND pos_accounts_generaljournal.TransactionDate BETWEEN '".$SDate."' AND '".$EDate."' ";
            
            $this->db->select('
	    pos_accounts_chartofaccount.ChartOfAccountCategoryId,
	    pos_accounts_chartofaccount_controls.ChartOfAccountControlId,
            pos_accounts_chartofaccount.ChartOfAccountId,
	    pos_accounts_chartofaccount.ChartOfAccountCode,
	    pos_accounts_chartofaccount.ChartOfAccountTitle,
            pos_accounts_generaljournal.GeneralJournalId,
            pos_accounts_generaljournal.TransactionDate,
            SUM(pos_accounts_generaljournal_entries.Debit) AS Debit,
            SUM(pos_accounts_generaljournal_entries.Credit) AS Credit,            
            ');
            $this->db->from('pos_accounts_generaljournal');
            $this->db->join('pos_accounts_generaljournal_entries','pos_accounts_generaljournal_entries.GeneralJournalId=pos_accounts_generaljournal.GeneralJournalId');
            $this->db->join('pos_accounts_chartofaccount','pos_accounts_chartofaccount.ChartOfAccountId = pos_accounts_generaljournal_entries.ChartOfAccountId');
            $this->db->join('pos_accounts_chartofaccount_controls','pos_accounts_chartofaccount_controls.ChartOfAccountControlId = pos_accounts_chartofaccount.ChartOfAccountControlId');
            
	    $this->db->where($where);
            $this->db->where($ConditionDate);
            $this->db->group_by("pos_accounts_chartofaccount.ChartOfAccountId");
            $this->db->order_by("pos_accounts_generaljournal.TransactionDate");
            $query = $this->db->get();
            return $query->result_array();
        }
	
	
    
	function GetAllChartOfAccount($StartDate,$EndDate,$CategoryId,$ControlCodeId,$ChartOfAccountId)
        {
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
        pos_accounts_chartofaccount.ChartOfAccountCode,
        pos_accounts_chartofaccount.ChartOfAccountTitle,
            pos_accounts_generaljournal.GeneralJournalId,
            pos_accounts_generaljournal.TransactionDate,
            SUM(pos_accounts_generaljournal_entries.Debit) AS Debit,
            SUM(pos_accounts_generaljournal_entries.Credit) AS Credit,
            pos_accounts_chartofaccount_categories.DebitIncrease
            ');

            $this->db->from('pos_accounts_generaljournal');
            $this->db->join('pos_accounts_generaljournal_entries','pos_accounts_generaljournal_entries.GeneralJournalId=pos_accounts_generaljournal.GeneralJournalId');
            $this->db->join('pos_accounts_chartofaccount','pos_accounts_chartofaccount.ChartOfAccountId=pos_accounts_generaljournal_entries.ChartOfAccountId');
            $this->db->join('pos_accounts_chartofaccount_controls','pos_accounts_chartofaccount_controls.ChartOfAccountControlId=pos_accounts_chartofaccount.ChartOfAccountControlId');
            $this->db->join('pos_accounts_chartofaccount_categories','pos_accounts_chartofaccount_categories.ChartOfAccountCategoryId=pos_accounts_chartofaccount.ChartOfAccountCategoryId');
            $this->db->where($conditionArray);
            $this->db->where($ConditionDate);
            $this->db->group_by("pos_accounts_chartofaccount.ChartOfAccountId");
            $this->db->order_by("pos_accounts_generaljournal.TransactionDate");
            $query = $this->db->get();
            return $query->result_array();
        }	 

        // ************* Chart of Account Report Generated ****************///

    function GetAllChartOfAccountReport($CategoryId,$ControlCodeId)
    {
         $this->db->select('
    pos_accounts_chartofaccount_categories.ChartOfAccountCategoryId, 
    pos_accounts_chartofaccount_categories.CategoryName, 
 pos_accounts_chartofaccount_controls.ControlName,
 pos_accounts_chartofaccount.ChartOfAccountTitle,
    SUM(pos_accounts_generaljournal_entries.Debit) as TotalDebit, 
    SUM(pos_accounts_generaljournal_entries.Credit) as TotalCredit,
pos_accounts_chartofaccount.`ChartOfAccountCode
');

        // $this->db->select('*');
        $this->db->from('pos_accounts_chartofaccount_categories');          
        $this->db->join('pos_accounts_chartofaccount','pos_accounts_chartofaccount.ChartOfAccountCategoryId=pos_accounts_chartofaccount_categories.ChartOfAccountCategoryId');
           
             $this->db->join('pos_accounts_generaljournal_entries','pos_accounts_generaljournal_entries.ChartOfAccountId=pos_accounts_chartofaccount.ChartOfAccountId');
             
        $this->db->join('pos_accounts_chartofaccount_controls','pos_accounts_chartofaccount_controls.ChartOfAccountControlId = pos_accounts_chartofaccount.ChartOfAccountControlId', 'left');
        if($CategoryId != 0)$this->db->where('pos_accounts_chartofaccount_categories.ChartOfAccountCategoryId', $CategoryId);
        if($ControlCodeId != 0)$this->db->where('pos_accounts_chartofaccount_controls.ChartOfAccountControlId', $ControlCodeId);
        $this->db->order_by("pos_accounts_chartofaccount_categories.ChartOfAccountCategoryId");
        // $this->db->group_by('pos_accounts_chartofaccount.ChartOfAccountControlId');
        $this->db->group_by('
    pos_accounts_chartofaccount_categories.ChartOfAccountCategoryId,
    pos_accounts_chartofaccount_controls.ControlName,
    pos_accounts_chartofaccount.ChartOfAccountTitle,
    pos_accounts_chartofaccount.ChartOfAccountCode
');
        $query = $this->db->get();
        return $query->result_array();
        }

    function GetOpenningBalance____NEW($SDate,$EDate,$ChartOfAccountId)
    {
        $conditionArray = array();
                
            if($ChartOfAccountId != 0 && $ChartOfAccountId != '' && $ChartOfAccountId != 'undefined')
                $conditionArray['pos_accounts_chartofaccount.ChartOfAccountId'] = $ChartOfAccountId;

            $ConditionDate = " 1=1 AND pos_accounts_generaljournal.TransactionDate < '".$SDate."'";

/**            $this->db->select(
            'SUM(pos_accounts_generaljournal_entries.Debit) AS Debit,'
            .'SUM(pos_accounts_generaljournal_entries.Credit) AS Credit, pos_accounts_chartofaccount.ChartOfAccountId'
            ); 
			$this->db->select('
				SUM(pos_accounts_generaljournal_entries.Debit) - SUM(pos_accounts_generaljournal_entries.Credit), SUM(pos_accounts_generaljournal_entries.Credit) - SUM(pos_accounts_generaljournal_entries.Debit) AS "Balance", pos_accounts_chartofaccount.ChartOfAccountId
            ');
			**/
	    $this->db->select('
	    SUM(pos_accounts_generaljournal_entries.Credit) - SUM(pos_accounts_generaljournal_entries.Debit) AS "Balance", pos_accounts_chartofaccount.ChartOfAccountId
            ');
            $this->db->from('pos_accounts_generaljournal');
            $this->db->join('pos_accounts_generaljournal_entries','pos_accounts_generaljournal_entries.GeneralJournalId=pos_accounts_generaljournal.GeneralJournalId');
            $this->db->join('pos_accounts_chartofaccount','pos_accounts_chartofaccount.ChartOfAccountId = pos_accounts_generaljournal_entries.ChartOfAccountId');
            $this->db->where($conditionArray);
            $this->db->where($ConditionDate);
	    $this->db->group_by("pos_accounts_chartofaccount.ChartOfAccountId");
            $query = $this->db->get();
            return $query->result_array();            
        }
	
	
	function GetOpenningBalance($StartDate,$EndDate,$CategoryId,$ControlCodeId,$ChartOfAccountId)
        {
            $conditionArray = array();
	    
            if($CategoryId != 0 && $CategoryId != '' && $CategoryId != 'undefined')
                $conditionArray['pos_accounts_chartofaccount.ChartOfAccountCategoryId'] = $CategoryId;
	    
            if($ControlCodeId != 0 && $ControlCodeId != '' && $ControlCodeId != 'undefined')
                $conditionArray['pos_accounts_chartofaccount.ChartOfAccountControlId'] = $ControlCodeId;
	    
            if($ChartOfAccountId != 0 && $ChartOfAccountId != '' && $ChartOfAccountId != 'undefined')
                $conditionArray['pos_accounts_chartofaccount.ChartOfAccountId'] = $ChartOfAccountId;

            $ConditionDate = " 1=1 AND pos_accounts_generaljournal.TransactionDate < '".$StartDate."'";

            $this->db->select('
	    if(pos_accounts_chartofaccount_categories.DebitIncrease = "1", SUM(pos_accounts_generaljournal_entries.Debit) - SUM(pos_accounts_generaljournal_entries.Credit), SUM(pos_accounts_generaljournal_entries.Credit) - SUM(pos_accounts_generaljournal_entries.Debit)) AS "Balance", pos_accounts_chartofaccount.ChartOfAccountId
            ');
            $this->db->from('pos_accounts_generaljournal');
            $this->db->join('pos_accounts_generaljournal_entries','pos_accounts_generaljournal_entries.GeneralJournalId=pos_accounts_generaljournal.GeneralJournalId');
            $this->db->join('pos_accounts_chartofaccount','pos_accounts_chartofaccount.ChartOfAccountId = pos_accounts_generaljournal_entries.ChartOfAccountId');
	    $this->db->join('pos_accounts_chartofaccount_controls','pos_accounts_chartofaccount_controls.ChartOfAccountControlId = pos_accounts_chartofaccount.ChartOfAccountControlId');
            $this->db->join('pos_accounts_chartofaccount_categories','pos_accounts_chartofaccount_categories.ChartOfAccountCategoryId = pos_accounts_chartofaccount.ChartOfAccountCategoryId');
            $this->db->where($conditionArray);
            $this->db->where($ConditionDate);
	    $this->db->group_by("pos_accounts_chartofaccount.ChartOfAccountId");
            $query = $this->db->get();
            return $query->result_array();            
        }
	
	

    function CustomerOutstandingReport($ChartOfAccountId,$SDate,$EDate,$AreaId=null)
    {
        $SDate = date('Y-m-d', strtotime($SDate));
		$EDate = date('Y-m-d', strtotime($EDate));
 
        $this->db->select(''
            . 'pos_accounts_chartofaccount.ChartOfAccountTitle,'
            . 'pos_accounts_chartofaccount.ChartOfAccountId,'
            . 'SUM(pos_accounts_generaljournal_entries.Debit) AS Debit,'
            . 'SUM(pos_accounts_generaljournal_entries.Credit) AS Credit,'
            . 'pos_customer.CustomerName,'
            . 'pos_customer.Address,'
            . 'pos_customer.CellNo,'
        );
        $this->db->from($this->tbl_accounts_generaljournal);
        $this->db->join($this->tbl_accounts_generaljournal_entries, $this->tbl_accounts_generaljournal_entries.'.GeneralJournalId = '.$this->tbl_accounts_generaljournal.'.GeneralJournalId');
        $this->db->join($this->tbl_accounts_chartofaccount, $this->tbl_accounts_chartofaccount.'.ChartOfAccountId = '.$this->tbl_accounts_generaljournal_entries.'.ChartOfAccountId');
        $this->db->join($this->tbl_customer, $this->tbl_customer.'.ChartOfAccountId = '.$this->tbl_accounts_chartofaccount.'.ChartOfAccountId');
		if($SDate){$this->db->where('pos_accounts_generaljournal.TransactionDate >=',$SDate);}
        if($EDate){$this->db->where('pos_accounts_generaljournal.TransactionDate <=',$EDate);}
        if($ChartOfAccountId!=0) { $this->db->where('pos_accounts_chartofaccount.ChartOfAccountId',$ChartOfAccountId); }
        if($AreaId!=0) { $this->db->where('pos_customer.AreaId',$AreaId); }
        $this->db->where('pos_accounts_chartofaccount.ChartOfAccountControlId',3);
        $this->db->group_by('pos_accounts_generaljournal_entries.ChartOfAccountId');
                $query = $this->db->get();
        return $query->result_array();
        }

       function VendorOutstandingReport($ChartOfAccountId,$SDate,$EDate)
    {
        $SDate = date('Y-m-d', strtotime($SDate));
		$EDate = date('Y-m-d', strtotime($EDate));
 
                $this->db->select(''
                . 'pos_accounts_chartofaccount.ChartOfAccountTitle,'
                . 'pos_accounts_chartofaccount.ChartOfAccountId,'
                . 'SUM(pos_accounts_generaljournal_entries.Debit) AS Debit,'
                . 'SUM(pos_accounts_generaljournal_entries.Credit) AS Credit,'
                . 'pos_vendor.VendorName,'
                . 'pos_vendor.Address,'
                . 'pos_vendor.CellNo,'
                );
        $this->db->from($this->tbl_accounts_generaljournal);
        $this->db->join($this->tbl_accounts_generaljournal_entries, $this->tbl_accounts_generaljournal_entries.'.GeneralJournalId = '.$this->tbl_accounts_generaljournal.'.GeneralJournalId');
        $this->db->join($this->tbl_accounts_chartofaccount, $this->tbl_accounts_chartofaccount.'.ChartOfAccountId = '.$this->tbl_accounts_generaljournal_entries.'.ChartOfAccountId');
        $this->db->join($this->tbl_vendor, $this->tbl_vendor.'.ChartOfAccountId = '.$this->tbl_accounts_chartofaccount.'.ChartOfAccountId');
//		if($SDate){$this->db->where('pos_accounts_generaljournal.TransactionDate >=',$SDate);}
        if($EDate){$this->db->where('pos_accounts_generaljournal.TransactionDate <=',$EDate);}
        if($ChartOfAccountId!=0) { $this->db->where('pos_accounts_chartofaccount.ChartOfAccountId',$ChartOfAccountId); }
        $this->db->where('pos_accounts_chartofaccount.ChartOfAccountControlId',2);
        $this->db->group_by('pos_accounts_generaljournal_entries.ChartOfAccountId');
        $query = $this->db->get();
        return $query->result_array();
        }





    function GetAllOutstandingCustomers()
    {
        $this->db->select('*');
        $this->db->from('pos_accounts_chartofaccount');
        $this->db->where('ChartOfAccountControlId', 2);
        $result = $this->db->get()->result_array();
        return $result;
    }        

    function GetAllOutstandingVendors()
    {
        $this->db->select('*');
        $this->db->from('pos_accounts_chartofaccount');
        $this->db->where('ChartOfAccountControlId', 7);
        $result = $this->db->get()->result_array();
        return $result;
    }        


    function GenerateVoucherReport($SDate,$EDate,$Reference,$GeneralJournalId,$colums='*')
    {

        $this->db->select($colums);
        $this->db->from('pos_accounts_generaljournal');
//        $this->db->join('pos_bank_accounts','pos_bank_accounts.AccountId = pos_accounts_generaljournal.BankAccountId','left');
        if($SDate){ $this->db->where('TransactionDate >=',$SDate); }
        if($EDate){ $this->db->where('TransactionDate <=',$EDate); }
        if($GeneralJournalId){ $this->db->where('GeneralJournalId =',$GeneralJournalId); }
        // if($Reference){ $this->db->like('Reference',$Reference, 'after'); }
        $ResultGeneralJournal = $this->db->get()->result_array();

            
        $this->db->select(
           'pos_accounts_chartofaccount.`ChartOfAccountTitle`,
            pos_accounts_chartofaccount.`ChartOfAccountCode`,
            pos_accounts_generaljournal_entries.`ChartOfAccountId`,
            pos_accounts_chartofaccount_controls.ControlName,
            pos_accounts_generaljournal_entries.GeneralJournalId,
            pos_accounts_generaljournal_entries.`Debit`,
            pos_accounts_generaljournal_entries.`Credit`,
            pos_accounts_generaljournal_entries.`ReconciliationStatus`,
            pos_customer.`CustomerName` AS CustomerName,
            pos_vendor.`VendorName` AS VendorName,
            pos_bank_accounts.`AccountTitle` AS AccountTitle,
            pos_accounts_generaljournal_entries.`Detail`
        ');
            $this->db->from('pos_accounts_generaljournal_entries');
            $this->db->order_by('GeneralJournalEntryId ASC');
            if($SDate){ $this->db->where('TransactionDate >=',$SDate); }
            if($EDate){ $this->db->where('TransactionDate <=',$EDate); }
//            if($Reference){ $this->db->where('Reference',$Reference); }
            // if($Reference){ $this->db->like('Reference',$Reference, 'after'); }
            $this->db->join('pos_accounts_generaljournal','pos_accounts_generaljournal.GeneralJournalId = pos_accounts_generaljournal_entries.GeneralJournalId');
            $this->db->join('pos_accounts_chartofaccount','pos_accounts_chartofaccount.ChartOfAccountId = pos_accounts_generaljournal_entries.ChartOfAccountId');
            $this->db->join('pos_accounts_chartofaccount_controls','pos_accounts_chartofaccount_controls.ChartOfAccountControlId = pos_accounts_chartofaccount.ChartOfAccountControlId');
            $this->db->join('pos_customer','pos_customer.CustomerId = pos_accounts_generaljournal_entries.CustomerId','left');
            $this->db->join('pos_vendor','pos_vendor.VendorId = pos_accounts_generaljournal_entries.VendorId','left');
            $this->db->join('pos_bank_accounts','pos_bank_accounts.AccountId = pos_accounts_generaljournal_entries.BankAccountId','left');
            
            $ResultGeneralJournalEntries = $this->db->get()->result_array();
            
            $Result = array('GeneralJournal'=>$ResultGeneralJournal,'GeneralJournalEntries'=>$ResultGeneralJournalEntries);
            return $Result;
        }

        function SalemanLedgerReport($StartDate,$EndDate,$CategoryId,$ControlCodeId,$SalemanId)
        {   
            $CategoryId = 1;
            $ControlCodeId2 = 17;
            if($SalemanId != 0 && $SalemanId != '' && $SalemanId != 'undefined')
            {
            $conditionArray = "pos_accounts_chartofaccount_categories.ChartOfAccountCategoryId = '".$CategoryId."' AND pos_accounts_chartofaccount_controls.ChartOfAccountControlId = '".$ControlCodeId2."' AND pos_accounts_chartofaccount.ChartOfAccountId = '".$SalemanId."'";
            //$conditionArray = "pos_accounts_chartofaccount_categories.ChartOfAccountCategoryId = '".$CategoryId."' AND (pos_accounts_chartofaccount_controls.ChartOfAccountControlId =  '".$ControlCodeId1."' OR pos_accounts_chartofaccount_controls.ChartOfAccountControlId =  '".$ControlCodeId2."') AND pos_accounts_chartofaccount.ChartOfAccountId = '".$ChartOfAccountId."'";
            }
            else
            {
            $conditionArray = "pos_accounts_chartofaccount_categories.ChartOfAccountCategoryId = '".$CategoryId."' AND pos_accounts_chartofaccount_controls.ChartOfAccountControlId = '".$ControlCodeId2."'";
            //$conditionArray = "pos_accounts_chartofaccount_categories.ChartOfAccountCategoryId = '".$CategoryId."' AND (pos_accounts_chartofaccount_controls.ChartOfAccountControlId =  '".$ControlCodeId1."' OR pos_accounts_chartofaccount_controls.ChartOfAccountControlId =  '".$ControlCodeId2."')";
            }

            $ConditionDate = " 1=1 AND pos_accounts_generaljournal.TransactionDate BETWEEN '".$StartDate."' AND '".$EndDate."' ";

            $this->db->select('
            pos_accounts_chartofaccount.ChartOfAccountCategoryId,
	        pos_accounts_chartofaccount_controls.ChartOfAccountControlId,
            pos_accounts_chartofaccount.ChartOfAccountId,
            pos_accounts_chartofaccount.ChartOfAccountTitle,
            pos_accounts_chartofaccount.ChartOfAccountCode,
            pos_accounts_chartofaccount_categories.DebitIncrease,
	        pos_accounts_chartofaccount_categories.CreditIncrease,
            pos_saleman.ContactNumber,
            pos_saleman.Address
            ');
            $this->db->from('pos_accounts_generaljournal');
            $this->db->join('pos_accounts_generaljournal_entries','pos_accounts_generaljournal_entries.GeneralJournalId=pos_accounts_generaljournal.GeneralJournalId');
            $this->db->join('pos_accounts_chartofaccount','pos_accounts_chartofaccount.ChartOfAccountId=pos_accounts_generaljournal_entries.SalemanId');
            $this->db->join('pos_accounts_chartofaccount_controls','pos_accounts_chartofaccount_controls.ChartOfAccountControlId=pos_accounts_chartofaccount.ChartOfAccountControlId');
            $this->db->join('pos_accounts_chartofaccount_categories','pos_accounts_chartofaccount_categories.ChartOfAccountCategoryId=pos_accounts_chartofaccount.ChartOfAccountCategoryId');
            $this->db->join('pos_saleman','pos_saleman.ChartOfAccountId=pos_accounts_chartofaccount.ChartOfAccountId');
            $this->db->where($conditionArray);
            $this->db->where($ConditionDate);
            $this->db->group_by("pos_accounts_chartofaccount.ChartOfAccountId");
//                echo $this->db->get_compiled_select();
            $query = $this->db->get();
            return $query->result_array();  
        }

        function SalemanSubLedgerReport($StartDate,$EndDate,$CategoryId,$ControlCodeId,$ChartOfAccountId,$invoice = null)
        {	  
	    
	    $CategoryId = 1;
	   // $ControlCodeId1 = 1;
	    $ControlCodeId2 = 17;
	    if($ChartOfAccountId != 0 && $ChartOfAccountId != '' && $ChartOfAccountId != 'undefined')
	    {
		$conditionArray = "pos_accounts_chartofaccount_categories.ChartOfAccountCategoryId = '".$CategoryId."' AND pos_accounts_chartofaccount_controls.ChartOfAccountControlId = '".$ControlCodeId2."' AND pos_accounts_chartofaccount.ChartOfAccountId = '".$ChartOfAccountId."'";
		//$conditionArray = "pos_accounts_chartofaccount_categories.ChartOfAccountCategoryId = '".$CategoryId."' AND (pos_accounts_chartofaccount_controls.ChartOfAccountControlId =  '".$ControlCodeId1."' OR pos_accounts_chartofaccount_controls.ChartOfAccountControlId =  '".$ControlCodeId2."') AND pos_accounts_chartofaccount.ChartOfAccountId = '".$ChartOfAccountId."'";
	    }
	    else
	    {
		$conditionArray = "pos_accounts_chartofaccount_categories.ChartOfAccountCategoryId = '".$CategoryId."' AND pos_accounts_chartofaccount_controls.ChartOfAccountControlId = '".$ControlCodeId2."'";
		//$conditionArray = "pos_accounts_chartofaccount_categories.ChartOfAccountCategoryId = '".$CategoryId."' AND (pos_accounts_chartofaccount_controls.ChartOfAccountControlId =  '".$ControlCodeId1."' OR pos_accounts_chartofaccount_controls.ChartOfAccountControlId =  '".$ControlCodeId2."')";
	    }
	    
            $ConditionDate = " 1=1 AND pos_accounts_generaljournal.TransactionDate BETWEEN '".$StartDate."' AND '".$EndDate."' ";
            
	    $this->db->select('
            pos_accounts_chartofaccount.ChartOfAccountId,
            pos_accounts_chartofaccount.ChartOfAccountTitle,
            pos_accounts_generaljournal.GeneralJournalId,
            pos_accounts_generaljournal.TransactionDate,
            pos_accounts_generaljournal.Reference,
            pos_accounts_generaljournal.SaleReturnId,
            pos_accounts_generaljournal_entries.Detail,
            SUM(pos_accounts_generaljournal_entries.Debit) AS Debit,
            SUM(pos_accounts_generaljournal_entries.Credit) AS Credit,
            pos_accounts_generaljournal.VoucherType,
	        pos_accounts_generaljournal.SaleId,
            ');
            $this->db->from('pos_accounts_generaljournal');
            $this->db->join('pos_accounts_generaljournal_entries','pos_accounts_generaljournal_entries.GeneralJournalId=pos_accounts_generaljournal.GeneralJournalId');
            $this->db->join('pos_accounts_chartofaccount','pos_accounts_chartofaccount.ChartOfAccountId=pos_accounts_generaljournal_entries.SalemanId');
            $this->db->join('pos_accounts_chartofaccount_controls','pos_accounts_chartofaccount_controls.ChartOfAccountControlId=pos_accounts_chartofaccount.ChartOfAccountControlId');
            $this->db->join('pos_accounts_chartofaccount_categories','pos_accounts_chartofaccount_categories.ChartOfAccountCategoryId=pos_accounts_chartofaccount.ChartOfAccountCategoryId');
            $this->db->where($conditionArray);
            $this->db->where($ConditionDate);
	        $this->db->group_by("pos_accounts_generaljournal_entries.GeneralJournalId");
            if(!$invoice) {$this->db->order_by("pos_accounts_generaljournal.TransactionDate"); }
            if($invoice) {$this->db->order_by("pos_accounts_generaljournal.TransactionDate", "desc"); }
            if($invoice) { $this->db->limit(3); }
            $query = $this->db->get();
            return $query->result_array();
        }

        function GetSalemanOpenningBalance($StartDate,$EndDate,$CategoryId,$ControlCodeId,$ChartOfAccountId)
        {
           $CategoryId = 1;
	    $ControlCodeId2 = 17;
	    if($ChartOfAccountId != 0 && $ChartOfAccountId != '' && $ChartOfAccountId != 'undefined')
	    {
		$conditionArray = "pos_accounts_chartofaccount_categories.ChartOfAccountCategoryId = '".$CategoryId."' AND pos_accounts_chartofaccount_controls.ChartOfAccountControlId = '".$ControlCodeId2."' AND pos_accounts_chartofaccount.ChartOfAccountId = '".$ChartOfAccountId."'";
	    }
	    else
	    {
		$conditionArray = "pos_accounts_chartofaccount_categories.ChartOfAccountCategoryId = '".$CategoryId."' AND pos_accounts_chartofaccount_controls.ChartOfAccountControlId = '".$ControlCodeId2."'";
		//$conditionArray = "pos_accounts_chartofaccount_categories.ChartOfAccountCategoryId = '".$CategoryId."' AND (pos_accounts_chartofaccount_controls.ChartOfAccountControlId =  '".$ControlCodeId1."' OR pos_accounts_chartofaccount_controls.ChartOfAccountControlId =  '".$ControlCodeId2."')";
	    }

            $ConditionDate = " 1=1 AND pos_accounts_generaljournal.TransactionDate < '".$StartDate."'";

            $this->db->select('
	    if(pos_accounts_chartofaccount_categories.DebitIncrease = "1", SUM(pos_accounts_generaljournal_entries.Debit) - SUM(pos_accounts_generaljournal_entries.Credit), SUM(pos_accounts_generaljournal_entries.Credit) - SUM(pos_accounts_generaljournal_entries.Debit)) AS "Balance", pos_accounts_chartofaccount.ChartOfAccountId
            ');
            $this->db->from('pos_accounts_generaljournal');
            $this->db->join('pos_accounts_generaljournal_entries','pos_accounts_generaljournal_entries.GeneralJournalId=pos_accounts_generaljournal.GeneralJournalId');
            $this->db->join('pos_accounts_chartofaccount','pos_accounts_chartofaccount.ChartOfAccountId = pos_accounts_generaljournal_entries.SalemanId');
	    $this->db->join('pos_accounts_chartofaccount_controls','pos_accounts_chartofaccount_controls.ChartOfAccountControlId = pos_accounts_chartofaccount.ChartOfAccountControlId');
            $this->db->join('pos_accounts_chartofaccount_categories','pos_accounts_chartofaccount_categories.ChartOfAccountCategoryId = pos_accounts_chartofaccount.ChartOfAccountCategoryId');
            $this->db->where($conditionArray);
            $this->db->where($ConditionDate);
	    $this->db->group_by("pos_accounts_chartofaccount.ChartOfAccountId");
            $query = $this->db->get();
            return $query->result_array();            
        }

	function CustomerAgingReport($CustomerId)
        {
	    
        
        // $this->db->select('
        //     pos_accounts_chartofaccount.ChartOfAccountTitle,
        //     pos_accounts_chartofaccount.ChartOfAccountId,
        //     pos_accounts_generaljournal.SaleId,
        //     SUM(pos_accounts_generaljournal_entries.Debit) AS Debit,
        //     SUM(pos_accounts_generaljournal_entries.Credit) AS Credit,
        //     pos_customer.CustomerName,
        //     pos_customer.Address,
        //     pos_customer.CellNo
        // ');
        
        $this->db->select('*,pos_sales.CustomerId');
        $this->db->from('pos_sales');
        // $this->db->join('pos_sales_detail', 'pos_sales_detail'.'.SaleId = pos_sales.SaleId');
           $this->db->join($this->tbl_customer, $this->tbl_customer.'.CustomerId = pos_sales.CustomerId');
         $this->db->join('pos_area', 'id = '.$this->tbl_customer.'.AreaId');
        //   
           $this->db->order_by('pos_sales.SaleDate', 'ASC');
        $this->db->where('pos_sales.SaleType',2);
        // die($CustomerId);
        if ($CustomerId != 0) {
        $this->db->where($this->tbl_customer . '.ChartOfAccountId', $CustomerId);
        }
        
   
        
        // Group by InvoiceNumber and other relevant fields
        // $this->db->group_by([
        //     'pos_sales.SaleId',
        //     'pos_customer.CustomerName'
        // ]);
        
        $query = $this->db->get();
            return $query->result_array();            
        }
        
         function InCompleteInvoice($SalesId=null)
	{
// 		$SalesId = $this->input->post('customer_name');

// 		$query = $this->db->query("SELECT S.SaleId,S.SaleDate, PA.Area_name,
//             C.CustomerId,C.ChartOfAccountId,C.CustomerName,S.UniqueId
//                  FROM  pos_sales AS S
//                   LEFT JOIN pos_customer AS C ON C.CustomerId = S.CustomerId
//                   LEFT JOIN pos_area AS PA ON PA.id = C.AreaId
//                   WHERE C.ChartOfAccountId ='$SalesId' ");
//  AND S.isSecondarySale = 1

  $where = "";
    if (!empty($SalesId)) {
        $where = "WHERE C.ChartOfAccountId = '" . $this->db->escape_str($SalesId) . "'";
    }

    $query = $this->db->query("
        SELECT S.SaleId, S.SaleDate, PA.Area_name,
               C.CustomerId, C.ChartOfAccountId, C.CustomerName, S.UniqueId
        FROM pos_sales AS S
        LEFT JOIN pos_customer AS C ON C.CustomerId = S.CustomerId
        LEFT JOIN pos_area AS PA ON PA.id = C.AreaId
        $where
    ");
    
    
		$ChartOfAccount = array();
	
		foreach ($query->result_array() as $key) {
			$getBalance = $this->db->query("SELECT pos_accounts_generaljournal_entries.Debit
                 FROM  pos_accounts_generaljournal_entries,pos_accounts_generaljournal
                  WHERE pos_accounts_generaljournal_entries.GeneralJournalId=pos_accounts_generaljournal.GeneralJournalId and pos_accounts_generaljournal.CustomerId='" . $key["CustomerId"] . "' and pos_accounts_generaljournal.SaleUniqueId = '" . $key["SaleId"] . "'");

			// calculate amount
			$lastPaidAmount = 0;
			foreach ($getBalance->result_array() as $lastBalance) {
				$lastPaidAmount += $lastBalance['Debit'];
			}
			// print_r($lastPaidAmount);
			$allSales = $this->Sale_model->GetInvoiceSales($key['SaleId']);
			$previousBalance = 0;
			foreach ($allSales as $sale) {
				$previousBalance += $sale['TotalAmount'];
			}
			$BankAbbr = '';
			$previousBalanceamount = $previousBalance - $lastPaidAmount;
			if ($previousBalanceamount != 0) {
				$bn = array(
					'SaleId' => trim($key['SaleId']),
					'UniqueId' => trim($key['UniqueId']),
					'value' => trim($key['SaleId']),
					'SaleDate' => trim(date('Y-m-d', strtotime($key['SaleDate']))),
					'AreaName' => trim($key['Area_name']),
					'CustomerName' => trim($key['CustomerName']),
					'CustomerId' => trim($key['CustomerId']),
					'ChartOfAccountId' => trim($key['ChartOfAccountId']),
					'previousBalanceamount' => $previousBalanceamount,
					'lastPaidAmount' => $lastPaidAmount,
					'PreviousBalance' => $previousBalance
				);

				$ChartOfAccount[] = $bn;
			}
		}
 return $ChartOfAccount;
// 		echo json_encode($ChartOfAccount);
	}
        
        

}

?>