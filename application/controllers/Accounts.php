<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Accounts extends CI_Controller {

	public function __construct()
	{
	    parent::__construct();
	    $this->check_isvalidated();
	    $this->load->model('Accounts_model');
	    $this->load->model('AccountsGroup_model');
//	    $this->load->model('AccountReport_model');
	    $this->load->model('Employee_model');
	    $this->load->model('Company_model');
	    $this->load->model('Customer_model');
	    $this->load->model('Vendor_model');
	    $this->load->model('AccountReport_model');
	    $this->load->model('Product_model');
	    $this->load->model('COA_model');
	//      $this->output->enable_profiler(true);
	}

	
	private function check_isvalidated()
	{
            if(!$this->session->userdata('EmployeeId'))
            { $this->session->set_userdata('url',  current_url()); redirect('Admin/Login'); }
	}
	
	
	function index()
	{
	    
	    $data['Roles'] = $this->Employee_model->GetRoles();
	    $data['AdministrationRoles'] = $this->Employee_model->GetAdministrationRoles($this->session->userdata('EmployeeId'));
	    $data['SalesRoles'] = $this->Employee_model->GetSalesRoles($this->session->userdata('EmployeeId'));
	    $data['PurchasesRoles'] = $this->Employee_model->GetPurchasesRoles($this->session->userdata('EmployeeId'));
	    $data['RegistrationRoles'] = $this->Employee_model->GetRegistrationRoles($this->session->userdata('EmployeeId'));
	    $data['TransactionRoles'] = $this->Employee_model->GetTransactionRoles($this->session->userdata('EmployeeId'));
	    $data['ReportsRoles'] = $this->Employee_model->GetReportsRoles($this->session->userdata('EmployeeId'));

	    $data['Companies'] = $this->Company_model->GetAllCompanies();
	    $data['Customers'] = $this->Customer_model->GetAllCustomers();
	    $data['Vendors'] = $this->Vendor_model->GetAllVendors();
	    $data['BankAccounts'] = $this->Accounts_model->GetAllAccounts();
	    $data['CategoryCode'] = $this->COA_model->GetAllCategories();	
	    $data['AllAccountsGroup'] = $this->AccountsGroup_model->GetAllAccountGroups();
	    $data['AllAccounts'] = $this->Accounts_model->GetAllAccounts();
	    
	    $data['CustomerNotification'] = $this->Customer_model->GetNotifications();
	    $this->load->view('admin/report/account_reports', $data);
	}
	

	public function GetAccountByBankId()
	{
	    $BankId = $_POST['bankId'];
	    $result = $this->db->get_where('pos_bank_accounts',array('BankId'=>$BankId) )->result_array();
	    $AccuntDropDown = '';
	     foreach($result as  $value)
	     {    
		 $AccuntDropDown .= '<option  value="'.$value["AccountId"].'"> ' .$value['AccountTitle'].' </option>';
	     }

	     echo '<select class="" id="AccountId" name="AccountId">
		     <option value="0"> --Select Account--   </option>
		     '.$AccuntDropDown.'
		 </select>';
	}

	function LedgerReport()
	{
	    	    
	    $data['Roles'] = $this->Employee_model->GetRoles();
	    $data['AdministrationRoles'] = $this->Employee_model->GetAdministrationRoles($this->session->userdata('EmployeeId'));
	    $data['SalesRoles'] = $this->Employee_model->GetSalesRoles($this->session->userdata('EmployeeId'));
	    $data['PurchasesRoles'] = $this->Employee_model->GetPurchasesRoles($this->session->userdata('EmployeeId'));
	    $data['RegistrationRoles'] = $this->Employee_model->GetRegistrationRoles($this->session->userdata('EmployeeId'));
	    $data['TransactionRoles'] = $this->Employee_model->GetTransactionRoles($this->session->userdata('EmployeeId'));
	    $data['ReportsRoles'] = $this->Employee_model->GetReportsRoles($this->session->userdata('EmployeeId'));

	    $data['Companies'] = $this->Company_model->GetAllCompanies();
	    $data['Customers'] = $this->Customer_model->GetAllCustomers();
	    $data['Vendors'] = $this->Vendor_model->GetAllVendors();
	    $data['BankAccounts'] = $this->Accounts_model->GetAllAccounts();
	    $data['CategoryCode'] = $this->COA_model->GetAllCategories();	
	    $data['AllAccountsGroup'] = $this->AccountsGroup_model->GetAllAccountGroups();
	    $data['AllAccounts'] = $this->Accounts_model->GetAllAccounts();
	    
	    $data['CustomerNotification'] = $this->Customer_model->GetNotifications();
	    $this->load->view('admin/report/ledger_report', $data);
	}
	

	public function ViewLedgerReport()
	{
	    $CompanyId = $this->input->get('CompanyId');
	    $CategoryId = $this->input->get('CategoryId');
	    $ControlCodeId = $this->input->get('ControlCodeId');
	    $ChartOfAccountId = $this->input->get('ChartOfAccountId');
	    $StartDate =date('Y-m-d', strtotime($this->input->get('StartDate')));
	    $EndDate =date('Y-m-d', strtotime($this->input->get('EndDate')));

	    $data['Roles'] = $this->Employee_model->GetRoles();
	    $data['AdministrationRoles'] = $this->Employee_model->GetAdministrationRoles($this->session->userdata('EmployeeId'));
	    $data['SalesRoles'] = $this->Employee_model->GetSalesRoles($this->session->userdata('EmployeeId'));
	    $data['PurchasesRoles'] = $this->Employee_model->GetPurchasesRoles($this->session->userdata('EmployeeId'));
	    $data['RegistrationRoles'] = $this->Employee_model->GetRegistrationRoles($this->session->userdata('EmployeeId'));
	    $data['TransactionRoles'] = $this->Employee_model->GetTransactionRoles($this->session->userdata('EmployeeId'));
	    $data['ReportsRoles'] = $this->Employee_model->GetReportsRoles($this->session->userdata('EmployeeId'));
	   	   
	    $data['LedgerReport'] = $this->AccountReport_model->LedgerReport($StartDate,$EndDate,$CategoryId,$CompanyId,$ControlCodeId,$ChartOfAccountId);
	    $data['SubLedgerReport'] = $this->AccountReport_model->SubLedgerReport($StartDate,$EndDate,$CategoryId,$CompanyId,$ControlCodeId,$ChartOfAccountId);
	    $data['OpenningBalance'] = $this->AccountReport_model->GetOpenningBalance($StartDate,$EndDate,$CategoryId,$CompanyId,$ControlCodeId,$ChartOfAccountId);
		
		$data['CustomerNotification'] = $this->Customer_model->GetNotifications();
	    $this->load->view('admin/report/view_ledgerreport', $data);
	}
	
	
	
	function IncomeStatementReportCriteria()
	{
	    	    
	    $data['Roles'] = $this->Employee_model->GetRoles();
	    $data['AdministrationRoles'] = $this->Employee_model->GetAdministrationRoles($this->session->userdata('EmployeeId'));
	    $data['SalesRoles'] = $this->Employee_model->GetSalesRoles($this->session->userdata('EmployeeId'));
	    $data['PurchasesRoles'] = $this->Employee_model->GetPurchasesRoles($this->session->userdata('EmployeeId'));
	    $data['RegistrationRoles'] = $this->Employee_model->GetRegistrationRoles($this->session->userdata('EmployeeId'));
	    $data['TransactionRoles'] = $this->Employee_model->GetTransactionRoles($this->session->userdata('EmployeeId'));
	    $data['ReportsRoles'] = $this->Employee_model->GetReportsRoles($this->session->userdata('EmployeeId'));

	    $data['Companies'] = $this->Company_model->GetAllCompanies();
	    
	    $data['CustomerNotification'] = $this->Customer_model->GetNotifications();
	    $this->load->view('admin/report/incomestatement_report_criteria', $data);
	}
	
	
	
	public function ViewIncomeStatementReport()
	{
	    
	    $CompanyId = $this->input->get('CompanyId');
	    $StartDate =date('Y-m-d', strtotime($this->input->get('StartDate')));
	    $EndDate =date('Y-m-d', strtotime($this->input->get('EndDate')));
	    
	    /*
	    $data['Roles'] = $this->Employee_model->GetRoles();
	    $data['AdministrationRoles'] = $this->Employee_model->GetAdministrationRoles($this->session->userdata('EmployeeId'));
	    $data['SalesRoles'] = $this->Employee_model->GetSalesRoles($this->session->userdata('EmployeeId'));
	    $data['PurchasesRoles'] = $this->Employee_model->GetPurchasesRoles($this->session->userdata('EmployeeId'));
	    $data['RegistrationRoles'] = $this->Employee_model->GetRegistrationRoles($this->session->userdata('EmployeeId'));
	    $data['TransactionRoles'] = $this->Employee_model->GetTransactionRoles($this->session->userdata('EmployeeId'));
	    $data['ReportsRoles'] = $this->Employee_model->GetReportsRoles($this->session->userdata('EmployeeId'));
	    */
	    
	    $data['COACategories'] = $this->AccountReport_model->GetIncomeAndExpenseCategories(3,4);
	    $data['GetAllControlCodes'] = $this->AccountReport_model->GetIncomeAndExpenseControlCodes($CompanyId,3,4);
	    $data['GetAllChartOfAccounts'] = $this->AccountReport_model->GetIncomeAndExpenseChartOfAccounts($CompanyId,3,4,$StartDate,$EndDate);
	    
	    $data['CustomerNotification'] = $this->Customer_model->GetNotifications();
	    $this->load->view('admin/report/view_incomestatement_report', $data);
	}


	/*
	function GeneratIncomeStatementReport()
	{
	    // 3 is used for Income, 4 is used for Expense    
	    $CompanyId = $this->input->get('CompanyId');
	    $SDate =date('Y-m-d', strtotime($this->input->get('StartDate')));
	    $EDate =date('Y-m-d', strtotime($this->input->get('EndDate')));

	    $data['COACategories'] = $this->COA_model->GetIncomeAndExpenseCategories(3,4);
	    $data['GetAllControlCodes'] = $this->COA_model->GetIncomeAndExpenseControlCodes(3,4);
	    $data['GetAllChartOfAccounts'] = $this->COA_model->GetIncomeAndExpenseChartOfAccounts($CompanyId,3,4,$SDate,$EDate);
	    
	    $this->load->view('report/accountreports/incomestatement_report',$data);
	}
	*/
	
	public function GetGroupAccounts()
	{
        
         $AccountGroupId = $this->input->post('AccountGroupId');
         
         $AllAccounts = $this->AccountsGroup_model->GetGroupAccounts($AccountGroupId);
           
         $AccountList = '<select class="form-control" name="AccountId" id="AccountId">';
         $AccountList .= '<option value=""> Select Account </option>';
          	foreach ($AllAccounts as $rows):
            $AccountList .= '<option value="'.$rows['AccountId'].'">'.$rows['AccountName'].'</option>';    
            endforeach;
            print $AccountList .= '</select>';            	
    }


       function LedgerReportCriteria() {
           
        // Company code dropdown
/*        echo "this is for checking";
        die;
*/        $Companies = $this->Company_model->GetAllCompanies();  
        $CompanyNames = '';
        foreach($Companies as $CompanyValues)
        {
          $CompanyNames .= '<option  value="'.$CompanyValues["CompanyId"].'"> ' .$CompanyValues['CompanyName'].' </option>';
        }
        
        // Category code dropdown
        $CategoryCode = $this->COA_model->GetAllCategories();  
        $CategoryCodes = '';
        foreach($CategoryCode as  $value)
        {
          $CategoryCodes .= '<option value="'.$value["ChartOfAccountCategoryId"].'"> '.$value['CategoryName'].' </option>';
        }
      
        // For Customers Dropdown   
        $Customers = $this->Customer_model->GetAllCustomers(); 
        $CustomerNames = '';
        foreach($Customers as  $CustomerValues)
        {    
           $CustomerNames .= '<option  value="'.$CustomerValues["CustomerId"].'"> ' .$CustomerValues['CustomerName'].' </option>';
        }
        
        // For Vendors Dropdown   
        $Vendors = $this->Vendor_model->GetAllVendors();
        $VendorNames = '';
        foreach($Vendors as  $VendorValues)
        {    
           $VendorNames .= '<option value="'.$VendorValues["VendorId"].'"> ' .$VendorValues['VendorName'].' </option>';
        }
 
        // For Bank Names Dropdown
        $Bank = $this->Accounts_model->GetAllBanks();   
        $Banks = '';
        foreach($Bank as  $value)
        {    
           $Banks .= '<option  value="'.$value["BankId"].'"> ' .$value['BankName'].'('.$value['BankAbbreviation'].')'.' </option>';
        }       
       
        //Banck account dropdown
        $Account = $this->Accounts_model->GetAllAccounts();   
        $Accounts = '';
        foreach($Account as  $value)
        {
           $Accounts .= '<option  value="'.$value["AccountId"].'"> ' .$value['AccountName'].' </option>';
        }

        $ReportCriteria ='<div style="border:0px solid; width:40%; margin-left:190px;" class="box-header with-border">
        <h3 class="box-title text-light-blue">General Ledger Report</h3>
         </div>';
	    $ReportCriteria .='<div class="form-group">
		 <label style="width:24%;" for="Company" class="col-sm-1 control-label">Company:</label>
		   <div class="input-group date">
                        <select style="width:300px;" class="select2" id="CompanyId" name="CompanyId">
                            <option value="0">All Companies</option>
                            '.$CompanyNames.'
                        </select>
		   </div>           
	   </div>';
           $ReportCriteria .='<div class="form-group">
		 <label style="width:24%;" for="OrderDate" class="col-sm-1 control-label">Category Code:</label>
		   <div class="input-group date">
                        <select style="width:300px;" class="" id="CategoryId" name="CategoryId">
                            <option value="0">Select Category</option>
                            '.$CategoryCodes.'
                        </select>
		   </div>                  
	   </div>'; 
             $ReportCriteria .='<div class="form-group">
		 <label style="width:24%;" for="OrderDate" class="col-sm-1 control-label">Control Code:</label>
		   <div class="input-group date" id="ControlCodeDiv">
                        <select style="width:300px;" class="" id="ControlCodeId" name="ControlCodeId">
                            <option value="0">Select Control Code</option>
                        </select>
		   </div>
	   </div>';
              $ReportCriteria .='<div class="form-group">
		 <label style="width:24%;" for="OrderDate" class="col-sm-1 control-label">Chart Of Account Code:</label>
		   <div class="input-group date" id ="ChartOfAccountDiv">
                        <select style="width:300px;" class="select2" id="ChartOfAccountId" name="ChartOfAccountId">
                            <option value="0">Select Chart Of Account</option>
                        </select>
		   </div>                  
	   </div>';              
            $ReportCriteria .='<div class="form-group">
		 <label style="width:24%;" for="CustomerId" class="col-sm-1 control-label">Payee (Customers:)</label>
		   <div class="input-group date" id="AccountDiv">
                        <select style="width:300px;" class="select2" id="CustomerId" name="CustomerId">
                            <option value="0">Select Customer</option>
                            '.$CustomerNames.'
                        </select>
		   </div>                  
	   </div>';
           $ReportCriteria .='<div class="form-group">
		 <label style="width:24%;" for="VendorId" class="col-sm-1 control-label">Payee (Vendors:)</label>
		   <div class="input-group date" id="AccountDiv">
                        <select style="width:300px;" class="select2" id="VendorId" name="VendorId">
                            <option value="0">Select Vendor</option>
                            '.$VendorNames.'
                        </select>
		   </div>                  
	   </div>';
           $ReportCriteria .='<div class="form-group">
		 <label style="width:24%;" for="OrderDate" class="col-sm-1 control-label">Payee (Bank Accounts:)</label>
		   <div class="input-group date" id="AccountDiv">
                        <select style="width:300px;" class="select2" id="AccountId" name="AccountId">
                            <option value="0">Select Bank Account</option>
                            '.$Accounts.'
                        </select>
		   </div>                  
	   </div>';              		 		
	  $ReportCriteria .='<div class="form-group">
		 <label style="width:24%;" for="OrderDate" class="col-sm-1 control-label">Start Range:</label>
		   <div class="input-group date">
			 <div class="input-group-addon">
			   <i class="fa fa-calendar"></i>
			 </div>                  
			 <input class="form-control" name="StartDate" id="datepicker1" type="text" placeholder="Enter Start Date" style="width:40%;" value="" autocomplete="off">
		   </div>                  
	   </div>';	   
	   $ReportCriteria .='<div class="form-group">
		 <label style="width:24%;" for="OrderDate" class="col-sm-1 control-label">End Range:</label>
		   <div class="input-group date">
			 <div class="input-group-addon">
			   <i class="fa fa-calendar"></i>
			 </div>     
			 <input class="form-control" name="OrderDate" id="datepicker2" type="text" placeholder="Enter End Date" style="width:40%;" value="" autocomplete="off">
		   </div>                  
	   </div>';              
           $ReportCriteria .='<div class="form-group">
		 <label style="width:24%;" class="col-sm-2"></label>
		   <div class="input-group date">
			 <button type="button" id="generate_ledger_report" class="btn  btn-primary">Show Report</button>
		   </div>
	   </div>';
           print $ReportCriteria;
	}

	
    function GeneratLedgerReport____()
	{
	    $CompanyId = $this->input->get('CompanyId');
	    $CustomerId = $this->input->get('CustomerId');
	    $BankId = $this->input->get('BId');
	    $BankAcountId = $this->input->get('BAId');
	    $CategoryId = $this->input->get('CId');
	    $ControlCodeId = $this->input->get('CCId');
	    $ChartOfAccountId = $this->input->get('COAId');
	    $SDate =date('Y-m-d', strtotime($this->input->get('StartDate')));
	    $EDate =date('Y-m-d', strtotime($this->input->get('EndDate')));

	    $data['LedgerReport'] = $this->AccountReport_model->LedgerReport($CategoryId,$ControlCodeId,$ChartOfAccountId,$SDate,$EDate);
	    $data['SubLedgerReport'] = $this->AccountReport_model->SubLedgerReport($CompanyId,$CustomerId,$BankId,$BankAcountId,$CategoryId,$ControlCodeId,$ChartOfAccountId,$SDate,$EDate);
	    $data['SalesInvoiceDetail'] = $this->AccountReport_model->SalesInvoiceByCustomerId($CustomerId,$SDate,$EDate);
	    $this->load->view('admin/report/ledger_report',$data);
	}

	public function ChartOfAccountReportCriteria()
	{
		$data['CategoryCode'] = $this->COA_model->GetAllCategories();
		$data['Companies'] = $this->Company_model->GetAllCompanies();  

		$this->load->view('admin/report/chartofaccount_report', $data);

	}


	public function ViewChartOfAccountReport()
	{
	    $CompanyId = $this->input->get('CompanyId');
	    $ControlCodeId = $this->input->get('ControlCodeId');
	    $CategoryId = $this->input->get('CategoryId');

	    $data['AllEmployees'] = $this->Employee_model->GetAllEmployees();
/*	    $data['COACategories'] = $this->COA_model->GetIncomeAndExpenseCategories(3,4);
	    $data['GetAllControlCodes'] = $this->COA_model->GetIncomeAndExpenseControlCodes(3,4);*/
	    $data['GetAllChartOfAccounts'] = $this->AccountReport_model->GetAllChartOfAccountsReport($CategoryId,$ControlCodeId,$CompanyId);
        $data['CustomerNotification'] = $this->Customer_model->GetNotifications();
//	    echo $this->output->enable_profiler();
	    $this->load->view('admin/report/view_chartofaccount_report', $data);

	}




}
?>