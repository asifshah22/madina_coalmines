<?php defined('BASEPATH') OR exit('No direct script access allowed');
class AccountReports extends CI_Controller {

	public function __construct()
	{
	    parent::__construct();
	    $this->check_isvalidated();
	    $this->load->model('Accounts_model');
	    $this->load->model('AccountsGroup_model');
	    $this->load->model('AccountReport_model');
	    $this->load->model('Employee_model');
	    $this->load->model('Customer_model');
	    $this->load->model('Vendor_model');
	    $this->load->model('COA_model');
	    $this->load->model('Sale_model');
	    $this->load->model('Purchase_model');
	    $this->load->model('SaleReport_model');
	    $this->load->model('PurchaseReport_model');
	    $this->load->model('Area_model');
		$this->load->model('Saleman_model');
	}

	private function check_isvalidated()
	{
        if(!$this->session->userdata('EmployeeId'))
        { $this->session->set_userdata('url',  current_url()); redirect('Login'); }
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
	
		$data['AllAccountsGroup'] = $this->AccountsGroup_model->GetAllAccountGroups();
		$data['AllAccounts'] = $this->Accounts_model->GetAllAccounts();
		$data['CategoryCode'] = $this->COA_model->GetAllCategories();
		
		$data['CustomerNotification'] = $this->Customer_model->GetNotifications();
		$this->load->view('report/accountreports/account_reports', $data);
	}


	public function LedgerReportCriteria() {
        
        // Category code dropdown
        $CategoryCodes = '';

        $CategoryCode = $this->COA_model->GetAllCategories(); 

        foreach($CategoryCode as  $value)
        {
          $CategoryCodes .= '<option value="'.$value["ChartOfAccountCategoryId"].'"> '.$value['CategoryName'].' </option>';
        }

        $ReportCriteria ='<div style="border:0px solid; width:40%; margin-left:190px;" class="box-header with-border">
        <h3 class="box-title text-light-blue">Report Criteria</h3>
         </div>';
	   $ReportCriteria .='<div class="form-group">
		 <label style="width:24%;" for="OrderDate" class="col-sm-1 control-label">Category Code:</label>
		   <div class="input-group date">
                        <select style="width:300px;" class="form-control select2" id="CategoryId" name="CategoryId">
                            <option value="0">Select Category</option>
                            '.$CategoryCodes.'
                        </select>
		   </div>                  
	   </div>'; 
             $ReportCriteria .='<div class="form-group">
		 <label style="width:24%;" for="OrderDate" class="col-sm-1 control-label">Control Code:</label>
		   <div class="input-group date" id="ControlCodeDiv">
                        <select style="width:300px;" class="form-control select2" id="ControlCodeId" name="ControlCodeId">
                            <option value="0">Select Control Code</option>
                        </select>
		   </div>
	   </div>';
              $ReportCriteria .='<div class="form-group">
		 <label style="width:24%;" for="OrderDate" class="col-sm-1 control-label">Chart Of Account Code:</label>
		   <div class="input-group date" id ="ChartOfAccountDiv">
                        <select style="width:300px;" class="form-control select2" id="ChartOfAccountId" name="ChartOfAccountId">
                            <option value="0">Select Chart Of Account</option>
                        </select>
		   </div>                  
	   </div>';              
	  $ReportCriteria .='<div class="form-group">
		 <label style="width:24%;" for="OrderDate" class="col-sm-1 control-label">Date From:</label>
		   <div class="input-group date">
			 <div class="input-group-addon">
			   <i class="fa fa-calendar"></i>
			 </div>                  
			 <input class="form-control" name="StartDate" id="datepicker1" type="text" placeholder="Enter Start Date" style="width:40%;" value="" autocomplete="off">
		   </div>                  
	   </div>';	   
	   $ReportCriteria .='<div class="form-group">
		 <label style="width:24%;" for="OrderDate" class="col-sm-1 control-label">Date To:</label>
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
	   $this->load->view("includes/footer");
	}
	
	
   	public function CustomerLedgerSummaryReportCriteria()
	{
	
	$Customers = $this->Customer_model->GetAllCustomers();  
        $CustomerNames = '';
        
		foreach($Customers as $CustomerValues)
        {
          $CustomerNames .= '<option  value="'.$CustomerValues["ChartOfAccountId"].'"> ' .$CustomerValues['CustomerName'].' </option>';
        }

        $ReportCriteria ='<div style="border:0px solid; width:40%; margin-left:190px;" class="box-header with-border">
        <h3 class="box-title text-light-blue">Report Criteria</h3>
         </div>';
	$ReportCriteria .='<div class="form-group">
		 <label style="width:24%;" for="Customer" class="col-sm-1 control-label">Customer:</label>
		   <div class="input-group date">
                        <select style="width:300px;" class="select2" id="ChartOfAccountId" name="ChartOfAccountId" mutiple="multiple">
                            <option value="0">All Customers</option>
                            '.$CustomerNames.'
                        </select>
		   </div>           
	   </div>';                   
	  $ReportCriteria .='<div class="form-group">
		 <label style="width:24%;" for="OrderDate" class="col-sm-1 control-label">Date From:</label>
		   <div class="input-group date">
			 <div class="input-group-addon">
			   <i class="fa fa-calendar"></i>
			 </div>                  
			 <input class="form-control" name="StartDate" id="datepicker1" type="text" placeholder="Enter Start Date" style="width:40%;" value="" autocomplete="off">
		   </div>                  
	   </div>';	   
	   $ReportCriteria .='<div class="form-group">
		 <label style="width:24%;" for="OrderDate" class="col-sm-1 control-label">Date To:</label>
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
			 <button type="button" id="customer_ledger_summary_report" class="btn  btn-primary">Show Report</button>
		   </div>
	   </div>';
           print $ReportCriteria;
	   $this->load->view("includes/footer");
	}
	
	
	public function VendorLedgerSummaryReportCriteria()
	{
	    
	    $Vendors = $this->Vendor_model->GetAllVendors();
	    $VendorNames = '';
        
	    foreach($Vendors as $VendorValues)
	    {
		$VendorNames .= '<option  value="'.$VendorValues["ChartOfAccountId"].'"> ' .$VendorValues['VendorName'].' </option>';
	    }
        

	    $ReportCriteria ='<div style="border:0px solid; width:40%; margin-left:190px;" class="box-header with-border">
	    <h3 class="box-title text-light-blue">Report Criteria</h3>
	    </div>';
	    $ReportCriteria .='<div class="form-group">
		 <label style="width:24%;" for="Vendors" class="col-sm-1 control-label">Vendors:</label>
		   <div class="input-group date">
                        <select style="width:300px;" class="select2" id="ChartOfAccountId" name="ChartOfAccountId">
                            <option value="0">All Vendors</option>
                            '.$VendorNames.'
                        </select>
		   </div>           
	   </div>';
	                       
	  $ReportCriteria .='<div class="form-group">
		 <label style="width:24%;" for="OrderDate" class="col-sm-1 control-label">Date From:</label>
		   <div class="input-group date">
			 <div class="input-group-addon">
			   <i class="fa fa-calendar"></i>
			 </div>                  
			 <input class="form-control" name="StartDate" id="datepicker1" type="text" placeholder="Enter Start Date" style="width:40%;" value="" autocomplete="off">
		   </div>                  
	   </div>';	   
	   $ReportCriteria .='<div class="form-group">
		 <label style="width:24%;" for="OrderDate" class="col-sm-1 control-label">Date To:</label>
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
			 <button type="button" id="vendor_ledger_summary_report" class="btn  btn-primary">Show Report</button>
		   </div>
	   </div>';
           print $ReportCriteria;
	   $this->load->view("includes/footer");
	}
	
	

      function ChartOfAccountReportCriteria() {
           
        // Category code dropdown
        $CategoryCode = $this->COA_model->GetAllCategories();  

        $CategoryCodes = '';
        foreach($CategoryCode as  $value)
        {
          $CategoryCodes .= '<option value="'.$value["ChartOfAccountCategoryId"].'"> '.$value['CategoryName'].' </option>';
        }

        $ReportCriteria ='<div style="border:0px solid; width:40%; margin-left:190px;" class="box-header with-border">
        <h3 class="box-title text-light-blue">Report Criteria</h3>
         </div>';
        $ReportCriteria .='<div class="form-group">
		 <label style="width:24%;" for="OrderDate" class="col-sm-1 control-label">Category Code:</label>
		   <div class="input-group date">
            <select style="width:300px;" class="select2" id="CategoryId" name="CategoryId">
                <option value="0">Select Category</option>
                    '.$CategoryCodes.'
            </select>
		   </div>                  
	   </div>';
/*	   	$ReportCriteria .='<div class="form-group">
                    <label style="width:24%;" for="Employee" class="col-sm-4 control-label">Control Code:</label>
                      <div class="input-group date" style="width: 76%" id="ControlCode">
                          
                      </div>
                  </div>';*/
	    $ReportCriteria .='<div class="form-group">
		 <label style="width:24%;" class="col-sm-2"></label>
		   <div class="input-group date">
			 <button type="button" id="generate_chartofaccount_report" class="btn  btn-primary">Show Report</button>
		   </div>
	   </div>'; 
        print $ReportCriteria;
	   	$this->load->view("includes/footer");
	}	
	

	/************************* Income Statement Report Criteria ************************************/
	
    function IncomeStatementReportCriteria() {        


        $ReportCriteria ='<div style="border:0px solid; width:40%; margin-left:190px;" class="box-header with-border">
        <h3 class="box-title text-light-blue">Report Criteria</h3>
         </div>';
        $ReportCriteria .='<div class="form-group">
		 <label style="width:24%;" for="OrderDate" class="col-sm-1 control-label">Date From:</label>
		   <div class="input-group date">
			 <div class="input-group-addon">
			   <i class="fa fa-calendar"></i>
			 </div>                  
			 <input class="form-control" name="StartDate" id="datepicker1" type="text" placeholder="Enter Start Date" style="width:40%;" value="" autocomplete="off">
		   </div>                  
	   </div>';	   
	   	$ReportCriteria .='<div class="form-group">
		 <label style="width:24%;" for="OrderDate" class="col-sm-1 control-label">Date To:</label>
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
			 <button type="button" id="generate_incomestatement_report" class="btn  btn-primary">Show Report</button>
		   </div>
	   </div>';
           print $ReportCriteria;
	   $this->load->view("includes/footer");
	}



/************************* Customer Outstanding Report Criteria ************************************/
	
        function CustomerOutstandingReportCriteria() {
           
        $Customers = $this->Customer_model->GetAllCustomers(); 
		$Areas = $this->Area_model->GetAllAreas(); 
        $CustomerNames = '';
		$AreaNames = '';
      
		foreach($Customers as $CustomerValues)
        {
          $CustomerNames .= '<option  value="'.$CustomerValues["ChartOfAccountId"].'"> ' .$CustomerValues['CustomerName'].' </option>';
        }

		foreach($Areas as $AreaValues)
        {
          $AreaNames .= '<option  value="'.$AreaValues["id"].'"> ' .$AreaValues['Area_name'].' </option>';
        }
        
		
        $ReportCriteria ='<div style="border:0px solid; width:40%; margin-left:190px;" class="box-header with-border">
        <h3 class="box-title text-light-blue">Report Criteria</h3>
         </div>';
	    $ReportCriteria .='<div class="form-group">
		 <label style="width:24%;" for="Customer" class="col-sm-1 control-label">Customer:</label>
		   <div class="input-group date">
				<select style="width:300px;" class="select2" id="ChartOfAccountId" name="ChartOfAccountId" mutiple="multiple">
					<option value="0">All Customers</option>
					'.$CustomerNames.'
				</select>
		   </div>           
	   </div>';
	   $ReportCriteria .='<div class="form-group">
		 <label style="width:24%;" for="Customer" class="col-sm-1 control-label">Company Name:</label>
		   <div class="input-group date">
				<select style="width:300px;" class="select2" id="AreaId" name="AreaId" mutiple="multiple">
					<option value="0">All Company Names</option>
					'.$AreaNames.'
				</select>
		   </div>           
	   </div>';
	   	$ReportCriteria .='<div class="form-group">
		 <label style="width:24%;" for="OrderDate" class="col-sm-1 control-label">Start Date:</label>
		   <div class="input-group date">
			 <div class="input-group-addon">
			   <i class="fa fa-calendar"></i>
			 </div>     
			 <input class="form-control" name="StartDate" id="datepicker1" type="text" placeholder="Enter Start Date" style="width:40%;" value="" autocomplete="off">
		   </div>                  
	   </div>';
	   $ReportCriteria .='<div class="form-group">
		 <label style="width:24%;" for="OrderDate" class="col-sm-1 control-label">End Date:</label>
		   <div class="input-group date">
			 <div class="input-group-addon">
			   <i class="fa fa-calendar"></i>
			 </div>     
			 <input class="form-control" name="EndDate" id="datepicker2" type="text" placeholder="Enter End Date" style="width:40%;" value="" autocomplete="off">
		   </div>                  
	   </div>';              
           $ReportCriteria .='<div class="form-group">
		 <label style="width:24%;" class="col-sm-2"></label>
		   <div class="input-group date">
			 <button type="button" id="generate_customeroutstanding_report" class="btn  btn-primary">Show Report</button>
		   </div>
	   </div>';
           print $ReportCriteria;
	   $this->load->view("includes/footer");
	}

/************************* Vendor Outstanding Report Criteria ************************************/
	
        function VendorOutstandingReportCriteria()
        {
           
        $Vendors = $this->Vendor_model->GetAllVendors();
        $VendorNames = '';
        
	foreach($Vendors as $VendorValues)
        {
          $VendorNames .= '<option  value="'.$VendorValues["ChartOfAccountId"].'"> ' .$VendorValues['VendorName'].' </option>';
        }
        

        $ReportCriteria ='<div style="border:0px solid; width:40%; margin-left:190px;" class="box-header with-border">
        <h3 class="box-title text-light-blue">Report Criteria</h3>
         </div>';
	    $ReportCriteria .='<div class="form-group">
		 <label style="width:24%;" for="Vendors" class="col-sm-1 control-label">Vendors:</label>
		   <div class="input-group date">
                        <select style="width:300px;" class="select2" id="ChartOfAccountId" name="ChartOfAccountId">
                            <option value="0">All Vendors</option>
                            '.$VendorNames.'
                        </select>
		   </div>           
	   </div>';
	   $ReportCriteria .='<div class="form-group">
		 <label style="width:24%;" for="OrderDate" class="col-sm-1 control-label">Start Date:</label>
		   <div class="input-group date">
			 <div class="input-group-addon">
			   <i class="fa fa-calendar"></i>
			 </div>     
			 <input class="form-control" name="StartDate" id="datepicker1" type="text" placeholder="Enter Start Date" style="width:40%;" value="" autocomplete="off">
		   </div>                  
	   </div>';              	   
	   $ReportCriteria .='<div class="form-group">
		 <label style="width:24%;" for="OrderDate" class="col-sm-1 control-label">End Date:</label>
		   <div class="input-group date">
			 <div class="input-group-addon">
			   <i class="fa fa-calendar"></i>
			 </div>     
			 <input class="form-control" name="EndDate" id="datepicker2" type="text" placeholder="Enter End Date" style="width:40%;" value="" autocomplete="off">
		   </div>                  
	   </div>';
           $ReportCriteria .='<div class="form-group">
		 <label style="width:24%;" class="col-sm-2"></label>
		   <div class="input-group date">
			 <button type="button" id="generate_vendoroutstanding_report" class="btn  btn-primary">Show Report</button>
		   </div>
	   </div>';
           print $ReportCriteria;
	   $this->load->view("includes/footer");
	}

    function VoucherCriteria() 
    {        

        $ReportCriteria ='<div style="border:0px solid; width:40%; margin-left:190px;" class="box-header with-border">
        <h3 class="box-title text-light-blue">Report Criteria</h3>
        </div>';
        $ReportCriteria .='<div class="form-group">
		 <label style="width:24%;" for="ReferencePrefix" class="col-sm-1 control-label">Voucher:</label>
		   <div class="input-group date" id="AccountDiv">
                        <select style="width:230px;" class="select2" id="ReferencePrefix" name="ReferencePrefix">
                            <option value="0">Select Voucher</option>
                            <option value="BPV">Bank Payment Voucher</option>
                            <option value="BRV">Bank Receipt Voucher</option>
                            <option value="CPV">Cash Payment Voucher</option>
                            <option value="CRV">Cash Receipt Voucher</option>
                            <option value="JV">Journal Voucher</option>
                        </select>
		   </div>                  
	   </div>';
		$ReportCriteria .='<div class="form-group">
		 <label style="width:24%;" for="OrderDate" class="col-sm-1 control-label">Date From:</label>
		   <div class="input-group date">
			 <div class="input-group-addon">
			   <i class="fa fa-calendar"></i>
			 </div>                  
			 <input class="form-control" name="StartDate" id="datepicker1" type="text" placeholder="Enter Start Date" style="width:40%;" value="" autocomplete="off">
		   </div>                  
	   	</div>';	   
	   	$ReportCriteria .='<div class="form-group">
		 <label style="width:24%;" for="OrderDate" class="col-sm-1 control-label">Date To:</label>
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
			 <button type="button" id="generate_voucher_report" class="btn  btn-primary">Show Report</button>
		   </div>
	   </div>';
           print $ReportCriteria;
	   $this->load->view("includes/footer");
	}


	public function LedgerReport()
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
		    
//		    echo $this->output->enable_profiler();
	    $data['GetSettingInformation'] = $this->Employee_model->GetSettingInformation();
	    $this->load->view('report/accountreports/view_ledgerreport', $data);
	}

	
	public function CustomerLedgerSummaryReport()
	{
	   // $this->output->enable_profiler();
	    
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
	   	   	    
	    $data['LedgerReport'] = $this->AccountReport_model->CustomerLedgerReport($StartDate,$EndDate,$CategoryId,$ControlCodeId,$ChartOfAccountId);
	    $data['SubLedgerReport'] = $this->AccountReport_model->CustomerSubLedgerReport($StartDate,$EndDate,$CategoryId,$ControlCodeId,$ChartOfAccountId);
	    $data['OpenningBalance'] = $this->AccountReport_model->GetCustomerOpenningBalance($StartDate,$EndDate,$CategoryId,$ControlCodeId,$ChartOfAccountId);
	    
	    $data['GetSettingInformation'] = $this->Employee_model->GetSettingInformation();
	    $this->load->view('report/accountreports/view_customer_ledger_summary_report', $data);
	}
	
	
	public function VendorLedgerSummaryReport()
	{
	   // $this->output->enable_profiler();
	    
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
	   	   	    
	    $data['LedgerReport'] = $this->AccountReport_model->VendorLedgerReport($StartDate,$EndDate,$CategoryId,$ControlCodeId,$ChartOfAccountId);
	    $data['SubLedgerReport'] = $this->AccountReport_model->VendorSubLedgerReport($StartDate,$EndDate,$CategoryId,$ControlCodeId,$ChartOfAccountId);
	    $data['OpenningBalance'] = $this->AccountReport_model->GetVendorOpenningBalance($StartDate,$EndDate,$CategoryId,$ControlCodeId,$ChartOfAccountId);
	    
	    $data['GetSettingInformation'] = $this->Employee_model->GetSettingInformation();
	    $this->load->view('report/accountreports/view_vendor_ledger_summary_report', $data);
	}
	

	public function ViewIncomeStatementReport()
	{
	    
	    $StartDate =date('Y-m-d', strtotime($this->input->get('StartDate')));
	    $EndDate =date('Y-m-d', strtotime($this->input->get('EndDate')));
	    
	    $data['COACategories'] = $this->AccountReport_model->GetIncomeAndExpenseCategories(3,4);
	    $data['GetAllControlCodes'] = $this->AccountReport_model->GetIncomeAndExpenseControlCodes(3,4);
	    $data['GetAllChartOfAccount'] = $this->AccountReport_model->GetIncomeAndExpenseChartOfAccount(3,4,$StartDate,$EndDate);

		$data['GetSettingInformation'] = $this->Employee_model->GetSettingInformation();	
	    $this->load->view('report/accountreports/view_incomestatement_report', $data);
	}


	public function ChartOfAccountReport()
	{
	    $ControlCodeId = $this->input->get('ControlCodeId');
	    $CategoryId = $this->input->get('CategoryId');

	    $data['AllEmployees'] = $this->Employee_model->GetAllEmployees();
	    $data['GetAllChartOfAccount'] = $this->AccountReport_model->GetAllChartOfAccountReport($CategoryId,$ControlCodeId);
		$data['GetSettingInformation'] = $this->Employee_model->GetSettingInformation();
	    $this->load->view('report/accountreports/view_chartofaccount_report', $data);
	}


    function CustomerOutstandingReport()
	{
	    $ChartOfAccountId = $this->input->get('ChartOfAccountId');
		$AreaId = $this->input->get('AreaId');
	    $SDate =date('Y-m-d', strtotime($this->input->get('StartDate')));
	    $EDate =date('Y-m-d', strtotime($this->input->get('EndDate')));

	    $data['AllEmployees'] = $this->Employee_model->GetAllEmployees();
	    $data['CustomerOutstandingReport'] = $this->AccountReport_model->CustomerOutstandingReport($ChartOfAccountId,$SDate,$EDate,$AreaId);
	    $data['OpenningBalance'] = $this->AccountReport_model->GetOpenningBalance($SDate,$EDate,$CategoryId=0,$ControlCodeId=0,$ChartOfAccountId);
	    //$data['OpenningBalance'] = $this->AccountReport_model->GetOpenningBalance($StartDate,$EndDate,$CategoryId,$ControlCodeId,$ChartOfAccountId);

	    $data['GetSettingInformation'] = $this->Employee_model->GetSettingInformation();
	    $this->load->view('report/accountreports/customeroutstanding_report',$data);
	    
	}

    function VendorOutstandingReport()
	{
	    $ChartOfAccountId = $this->input->get('ChartOfAccountId');
	    $SDate =date('Y-m-d', strtotime($this->input->get('StartDate')));
	    $EDate =date('Y-m-d', strtotime($this->input->get('EndDate')));

	    $data['AllEmployees'] = $this->Employee_model->GetAllEmployees();
	    $data['VendorOutstandingReport'] = $this->AccountReport_model->VendorOutstandingReport($ChartOfAccountId,$SDate,$EDate);
	    $data['OpenningBalance'] = $this->AccountReport_model->GetOpenningBalance($SDate,$EDate,$CategoryId=0,$ControlCodeId=0,$ChartOfAccountId);
	    
	    $data['GetSettingInformation'] = $this->Employee_model->GetSettingInformation();

//	    echo $this->output->enable_profiler();	    
	    $this->load->view('report/accountreports/vendoroutstanding_report',$data);
	}
 
	public function ViewAccountReport()
	{
	    $AccountId = $this->input->get('AccountId');
	    $AccountGroupId = $this->input->get('AccountGroupId');
	    $StartDate =date('Y-m-d', strtotime($this->input->get('StartDate')));
	    $EndDate =date('Y-m-d', strtotime($this->input->get('EndDate')));

	    $data['Roles'] = $this->Employee_model->GetRoles();
	    $data['AdministrationRoles'] = $this->Employee_model->GetAdministrationRoles($this->session->userdata('EmployeeId'));
	    $data['SalesRoles'] = $this->Employee_model->GetSalesRoles($this->session->userdata('EmployeeId'));
	    $data['PurchasesRoles'] = $this->Employee_model->GetPurchasesRoles($this->session->userdata('EmployeeId'));
	    $data['RegistrationRoles'] = $this->Employee_model->GetRegistrationRoles($this->session->userdata('EmployeeId'));
	    $data['TransactionRoles'] = $this->Employee_model->GetTransactionRoles($this->session->userdata('EmployeeId'));
	    $data['ReportsRoles'] = $this->Employee_model->GetReportsRoles($this->session->userdata('EmployeeId'));
	   
	    $data['LedgerReport'] = $this->AccountReport_model->LedgerReport($StartDate,$EndDate,$AccountId,$AccountGroupId);
	    $data['SubLedgerReport'] = $this->AccountReport_model->SubLedgerReport($StartDate,$EndDate,$AccountId,$AccountGroupId);

		$data['GetSettingInformation'] = $this->Employee_model->GetSettingInformation();
	    $this->load->view('admin/accountreports/view_ledgerreport', $data);
	}

    function GenerateVoucherReport()
    {
		$GeneralJournalId = 0;
	if($this->input->get('GeneralJournalId')){
		$GeneralJournalId = $this->input->get('GeneralJournalId');
	}
	$SDate = "";
	$EDate = "";
	if($this->input->get('StartDate')){
	$SDate = date('Y-m-d', strtotime($this->input->get('StartDate')));
	}
	if($this->input->get('EndDate')){
	$EDate = date('Y-m-d', strtotime($this->input->get('EndDate')));
	}
	
	$ReferencePrefix = $this->input->get('ReferencePrefix');

	
	$data['GetGeneralJournal'] = $this->AccountReport_model->GenerateVoucherReport($SDate,$EDate,$ReferencePrefix,$GeneralJournalId);
	$data['GetSettingInformation'] = $this->Employee_model->GetSettingInformation();
	$this->load->view('report/accountreports/voucher_report',$data);
	}


    public function GetGroupAccounts(){
        
        $AccountGroupId = $this->input->post('AccountGroupId');
         
        $AllAccounts = $this->AccountsGroup_model->GetGroupAccounts($AccountGroupId);
           
        $AccountList = '<select class="form-control" name="AccountId" id="AccountId">';
        $AccountList .= '<option value=""> Select Account </option>';
          	foreach ($AllAccounts as $rows):
            $AccountList .= '<option value="'.$rows['AccountId'].'">'.$rows['AccountName'].'</option>';    
            endforeach;
        print $AccountList .= '</select>';            	
    }
    
    public function ViewCustomerSaleInvoice($SaleId)
    {	
	$data['Roles'] = $this->Employee_model->GetRoles();
	$data['AdministrationRoles'] = $this->Employee_model->GetAdministrationRoles($this->session->userdata('EmployeeId'));
	$data['SalesRoles'] = $this->Employee_model->GetSalesRoles($this->session->userdata('EmployeeId'));
	$data['PurchasesRoles'] = $this->Employee_model->GetPurchasesRoles($this->session->userdata('EmployeeId'));
	$data['RegistrationRoles'] = $this->Employee_model->GetRegistrationRoles($this->session->userdata('EmployeeId'));
	$data['TransactionRoles'] = $this->Employee_model->GetTransactionRoles($this->session->userdata('EmployeeId'));
	$data['ReportsRoles'] = $this->Employee_model->GetReportsRoles($this->session->userdata('EmployeeId'));
	
	$data['Sales'] = $this->Sale_model->GetSales($SaleId);
	$data['SalesDetail'] = $this->Sale_model->GetSalesDetail($SaleId);
	    
	$this->load->view('report/accountreports/view_customer_sale_invoice',$data);
    }
    
    
    public function ViewVendorPurchaseInvoice($PurchaseId)
    {	
	$data['Roles'] = $this->Employee_model->GetRoles();
	$data['AdministrationRoles'] = $this->Employee_model->GetAdministrationRoles($this->session->userdata('EmployeeId'));
	$data['SalesRoles'] = $this->Employee_model->GetSalesRoles($this->session->userdata('EmployeeId'));
	$data['PurchasesRoles'] = $this->Employee_model->GetPurchasesRoles($this->session->userdata('EmployeeId'));
	$data['RegistrationRoles'] = $this->Employee_model->GetRegistrationRoles($this->session->userdata('EmployeeId'));
	$data['TransactionRoles'] = $this->Employee_model->GetTransactionRoles($this->session->userdata('EmployeeId'));
	$data['ReportsRoles'] = $this->Employee_model->GetReportsRoles($this->session->userdata('EmployeeId'));
		
	$data['Purchases'] = $this->Purchase_model->GetPurchase($PurchaseId);
	$data['PurchaseDetail'] = $this->Purchase_model->GetPurchaseDetail($PurchaseId);

	$this->load->view('report/accountreports/view_vendor_purchase_invoice',$data);
    }
    
    function ActivityCriteria() 
    {        

        $ReportCriteria ='<div style="border:0px solid; width:40%; margin-left:190px;" class="box-header with-border">
        <h3 class="box-title text-light-blue">Report Criteria</h3>
        </div>';
        $ReportCriteria .='<div class="form-group">
		 <label style="width:24%;" for="ReferencePrefix" class="col-sm-1 control-label">Select Type:</label>
		   <div class="input-group date" id="AccountDiv">
				<select style="width:230px;" class="select2" id="type" name="type">
					<option value="0">Select Type</option>
					<option value="sale">Sale</option>
					<option value="purchase">Purchase</option>
					<option value="bank">Banks</option>
					<option value="cashbook">Cashbook</option>
				</select>
		   </div>                  
	   </div>';
		$ReportCriteria .='<div class="form-group">
		 <label style="width:24%;" for="OrderDate" class="col-sm-1 control-label">Date From:</label>
		   <div class="input-group date">
			 <div class="input-group-addon">
			   <i class="fa fa-calendar"></i>
			 </div>                  
			 <input class="form-control" name="StartDate" id="datepicker1" type="text" placeholder="Enter Start Date" style="width:40%;" value="" autocomplete="off">
		   </div>                  
	   	</div>';	   
	   	$ReportCriteria .='<div class="form-group">
		 <label style="width:24%;" for="OrderDate" class="col-sm-1 control-label">Date To:</label>
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
			 <button type="button" id="generate_activity_report" class="btn  btn-primary">Show Report</button>
		   </div>
	   </div>';
           print $ReportCriteria;
	   $this->load->view("includes/footer");
	}

	function GenerateActivityReport()
	{
		$StartDate = "";
		$EndDate   = "";
		if($this->input->get('StartDate')){
			$StartDate = date('Y-m-d', strtotime($this->input->get('StartDate')));
		}
		if($this->input->get('EndDate')){
			$EndDate = date('Y-m-d', strtotime($this->input->get('EndDate')));
		}
		
		$Type = $this->input->get('Type');
		// sale methods
		$data['SaleCash'] 	= ($Type == "sale" || $Type == 0) ? $this->SaleReport_model->AllSales(0, 0, 0, 0 , 0, 1, 0, 0, 0, 0, 0, $StartDate, $EndDate) : array();
		$data['SaleCredit'] = ($Type == "sale" || $Type == 0) ? $this->SaleReport_model->AllSales(0, 0, 0, 0 , 0, 2, 0, 0, 0, 0, 0, $StartDate, $EndDate) : array();
		$data['SaleReturnCash']   = ($Type == "sale" || $Type == 0) ? $this->SaleReport_model->AllSalesReturn(0, 0, 0, 0, 0, 0, 0, $StartDate, $EndDate, 1) : array();
		$data['SaleReturnCredit'] = ($Type == "sale" || $Type == 0) ? $this->SaleReport_model->AllSalesReturn(0, 0, 0, 0, 0, 0, 0, $StartDate, $EndDate, 2) : array();
		// purchase methods
		$data['PurchaseCash'] = ($Type == "purchase" || $Type == 0) ? $this->PurchaseReport_model->GetPurchase(0, 0, 0, 1, 0, 0, 0, 0, $StartDate,$EndDate) : array();
		$data['PurchaseCredit'] = ($Type == "purchase" || $Type == 0) ? $this->PurchaseReport_model->GetPurchase(0, 0, 0, 2, 0, 0, 0, 0, $StartDate,$EndDate) : array();
		$data['PurchaseReturnCash'] = ($Type == "purchase" || $Type == 0) ? $this->PurchaseReport_model->AllPurchaseReturnReport(0, 0, 0, 0, 0, 0, $StartDate, $EndDate, 1) : array();
		$data['PurchaseReturnCredit'] = ($Type == "purchase" || $Type == 0) ? $this->PurchaseReport_model->AllPurchaseReturnReport(0, 0, 0, 0, 0, 0, $StartDate, $EndDate, 2) : array();
	
		// bank method
		$data['LedgerReport'] 	 = ($Type == "bank" || $Type == 0) ? $this->AccountReport_model->LedgerReport($StartDate, $EndDate, 1, 4, 0) : array();
	    $data['SubLedgerReport'] = ($Type == "bank" || $Type == 0) ? $this->AccountReport_model->SubLedgerReport($StartDate, $EndDate, 1, 4, 0) : array();
		$data['OpenningBalance'] = ($Type == "bank" || $Type == 0) ? $this->AccountReport_model->GetOpenningBalance($StartDate, $EndDate, 1, 4, 0) : array();
		// cashbook method
		$data['CashbookLedgerReport'] 	 = ($Type == "cashbook" || $Type == 0) ? $this->AccountReport_model->LedgerReport($StartDate, $EndDate, 1, 1, 1) : array();
	    $data['CashbookSubLedgerReport'] = ($Type == "cashbook" || $Type == 0) ? $this->AccountReport_model->SubLedgerReport($StartDate, $EndDate, 1, 1, 1) : array();
		$data['CashbookOpenningBalance'] = ($Type == "cashbook" || $Type == 0) ? $this->AccountReport_model->GetOpenningBalance($StartDate, $EndDate, 1, 1, 1) : array();
		
		$data['ReportType']	= $Type;
		$data['GetSettingInformation'] = $this->Employee_model->GetSettingInformation();
		$this->load->view('report/accountreports/activity_report',$data);
	}

	public function SalemanSaleAndRecoveryReportCriteria()
	{
	
	$Saleman = $this->Saleman_model->GetAllCategories();  
        $SalemanNames = '';
        
		foreach($Saleman as $SalemanValues)
        {
          $SalemanNames .= '<option  value="'.$SalemanValues["ChartOfAccountId"].'"> ' .$SalemanValues['SalemanName'].' </option>';
        }

        $ReportCriteria ='<div style="border:0px solid; width:40%; margin-left:190px;" class="box-header with-border">
        <h3 class="box-title text-light-blue">Report Criteria</h3>
         </div>';
	$ReportCriteria .='<div class="form-group">
		 <label style="width:24%;" for="Saleman" class="col-sm-1 control-label">Saleman:</label>
		   <div class="input-group date">
                        <select style="width:300px;" class="select2" id="SalemanId" name="SalemanId" mutiple="multiple">
                            <option value="0">All Saleman</option>
                            '.$SalemanNames.'
                        </select>
		   </div>           
	   </div>';                   
	  $ReportCriteria .='<div class="form-group">
		 <label style="width:24%;" for="OrderDate" class="col-sm-1 control-label">Date From:</label>
		   <div class="input-group date">
			 <div class="input-group-addon">
			   <i class="fa fa-calendar"></i>
			 </div>                  
			 <input class="form-control" name="StartDate" id="datepicker1" type="text" placeholder="Enter Start Date" style="width:40%;" value="" autocomplete="off">
		   </div>                  
	   </div>';	   
	   $ReportCriteria .='<div class="form-group">
		 <label style="width:24%;" for="OrderDate" class="col-sm-1 control-label">Date To:</label>
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
			 <button type="button" id="saleman_sale_and_recovery_report" class="btn  btn-primary">Show Report</button>
		   </div>
	   </div>';
           print $ReportCriteria;
	   $this->load->view("includes/footer");
	}

	public function SalemanSaleAndRecoveryReport()
	{
	   // $this->output->enable_profiler();
	    
	    // $CategoryId = $this->input->get('CId');
	    // $ControlCodeId = $this->input->get('CCId');
	    $SalemanId = $this->input->get('SalemanId');
	    
	    $StartDate =date('Y-m-d', strtotime($this->input->get('StartDate')));
	    $EndDate =date('Y-m-d', strtotime($this->input->get('EndDate')));

	    $data['Roles'] = $this->Employee_model->GetRoles();
	    $data['AdministrationRoles'] = $this->Employee_model->GetAdministrationRoles($this->session->userdata('EmployeeId'));
	    $data['SalesRoles'] = $this->Employee_model->GetSalesRoles($this->session->userdata('EmployeeId'));
	    $data['PurchasesRoles'] = $this->Employee_model->GetPurchasesRoles($this->session->userdata('EmployeeId'));
	    $data['RegistrationRoles'] = $this->Employee_model->GetRegistrationRoles($this->session->userdata('EmployeeId'));
	    $data['TransactionRoles'] = $this->Employee_model->GetTransactionRoles($this->session->userdata('EmployeeId'));
	    $data['ReportsRoles'] = $this->Employee_model->GetReportsRoles($this->session->userdata('EmployeeId'));
	   	   	    
	    $data['LedgerReport'] = $this->AccountReport_model->SalemanLedgerReport($StartDate,$EndDate,$CategoryId=0,$ControlCodeId=0,$SalemanId);
	    $data['SubLedgerReport'] = $this->AccountReport_model->SalemanSubLedgerReport($StartDate,$EndDate,$CategoryId=0,$ControlCodeId=0,$SalemanId);
	    $data['OpenningBalance'] = $this->AccountReport_model->GetSalemanOpenningBalance($StartDate,$EndDate,$CategoryId=0,$ControlCodeId=0,$SalemanId);
		// echo "<pre>";
		// print_r($data['OpenningBalance']);
		// echo "</pre>"; exit;
	    
	    $data['GetSettingInformation'] = $this->Employee_model->GetSettingInformation();
	    $this->load->view('report/accountreports/view_saleman_sale_and_recovery_report', $data);
	}
    	function TrialBalanceReportCriteria() {
           
          
        // Category code dropdown
        $CategoryCode = $this->COA_model->GetAllCategories();  

        $CategoryCodes = '';
        foreach($CategoryCode as  $value)
        {
          $CategoryCodes .= '<option value="'.$value["ChartOfAccountCategoryId"].'"> '.$value['CategoryName'].' </option>';
        }

        $ReportCriteria ='<div style="border:0px solid; width:40%; margin-left:190px;" class="box-header with-border">
        <h3 class="box-title text-light-blue">Report Criteria</h3>
         </div>';
        $ReportCriteria .='<div class="form-group">
		 <label style="width:24%;" for="OrderDate" class="col-sm-1 control-label">Category Code:</label>
		   <div class="input-group date">
            <select style="width:300px;" class="select2" id="CategoryId" name="CategoryId">
                <option value="0">Select Category</option>
                    '.$CategoryCodes.'
            </select>
		   </div>                  
	   </div>';
/*	   	$ReportCriteria .='<div class="form-group">
                    <label style="width:24%;" for="Employee" class="col-sm-4 control-label">Control Code:</label>
                      <div class="input-group date" style="width: 76%" id="ControlCode">
                          
                      </div>
                  </div>';*/
	    $ReportCriteria .='<div class="form-group">
		 <label style="width:24%;" class="col-sm-2"></label>
		   <div class="input-group date">
			 <button type="button" id="generate_trialbalance_report" class="btn  btn-primary">Show Report</button>
		   </div>
	   </div>'; 
        print $ReportCriteria;
	   	$this->load->view("includes/footer");
	}	
		function AgingReportCriteria() {
           
       	$Customers = $this->Customer_model->GetAllCustomers();  
        $CustomerNames = '';
        
		foreach($Customers as $CustomerValues)
        {
          $CustomerNames .= '<option  value="'.$CustomerValues["ChartOfAccountId"].'"> ' .$CustomerValues['CustomerName'].' </option>';
        }

        $ReportCriteria ='<div style="border:0px solid; width:40%; margin-left:190px;" class="box-header with-border">
        <h3 class="box-title text-light-blue">Report Criteria</h3>
         </div>';
	$ReportCriteria .='<div class="form-group">
		 <label style="width:24%;" for="Customer" class="col-sm-1 control-label">Customer:</label>
		   <div class="input-group date">
                        <select style="width:300px;" class="select2" id="ChartOfAccountId" name="ChartOfAccountId" mutiple="multiple">
                            <option value="0">All Customers</option>
                            '.$CustomerNames.'
                        </select>
		   </div>           
	   </div>';                   
         
           $ReportCriteria .='<div class="form-group">
		 <label style="width:24%;" class="col-sm-2"></label>
		   <div class="input-group date">
			 <button type="button" id="generate_aging_report" class="btn  btn-primary">Show Report</button>
		   </div>
	   </div>';
           print $ReportCriteria;
	   $this->load->view("includes/footer");
	}
		public function AgingReport()
	{

	    $CustomerId = $this->input->get('ChartOfAccountId');
	    

	    $data['Roles'] = $this->Employee_model->GetRoles();
	    $data['AdministrationRoles'] = $this->Employee_model->GetAdministrationRoles($this->session->userdata('EmployeeId'));
	    $data['SalesRoles'] = $this->Employee_model->GetSalesRoles($this->session->userdata('EmployeeId'));
	    $data['PurchasesRoles'] = $this->Employee_model->GetPurchasesRoles($this->session->userdata('EmployeeId'));
	    $data['RegistrationRoles'] = $this->Employee_model->GetRegistrationRoles($this->session->userdata('EmployeeId'));
	    $data['TransactionRoles'] = $this->Employee_model->GetTransactionRoles($this->session->userdata('EmployeeId'));
	    $data['ReportsRoles'] = $this->Employee_model->GetReportsRoles($this->session->userdata('EmployeeId'));
	   	   	    
	   // $data['LedgerReport'] = $this->AccountReport_model->CustomerAgingReport($CustomerId);
	   $data['LedgerReport'] = $this->AccountReport_model->InCompleteInvoice($CustomerId);
	  
	   $distributedCredits = []; // To track remaining credits for each ChartOfAccountId
/*
        foreach ($data['LedgerReport'] as $key => $ledger) {
            $chartOfAccountId = $ledger['ChartOfAccountId'];
        
            // Fetch total credit for the ChartOfAccountId if not already tracked
            if (!isset($distributedCredits[$chartOfAccountId])) {
                $customerAging = $this->AccountReport_model->CustomerAging($chartOfAccountId);
                $distributedCredits[$chartOfAccountId] = $customerAging['total_credit'] ?? 0; // Set the total credit
            }
        
            // Allocate credit to the current row
            $remainingCredit = &$distributedCredits[$chartOfAccountId]; // Reference remaining credit
            $netAmount = $ledger['TotalAmount'];
        
            if ($remainingCredit > 0) {
                $creditToAllocate = min($remainingCredit, $netAmount); // Allocate credit without exceeding NetAmount
                $remainingCredit -= $creditToAllocate; // Reduce the remaining credit
                $data['LedgerReport'][$key]['PaidAmount'] = $creditToAllocate;
            } else {
                $data['LedgerReport'][$key]['PaidAmount'] = 0; // No remaining credit to allocate
            }
        }*/
// 	    echo "<pre>";
	   //die();
	    $data['GetSettingInformation'] = $this->Employee_model->GetSettingInformation();
	    $this->load->view('report/accountreports/view_aging_report', $data);
	}
	
		public function TrialBalanceReport()
	{
	    $ControlCodeId = $this->input->get('ControlCodeId');
	    $CategoryId = $this->input->get('CategoryId');

	    $data['AllEmployees'] = $this->Employee_model->GetAllEmployees();
	    $data['GetAllChartOfAccount'] = $this->AccountReport_model->GetAllChartOfAccountReport($CategoryId,$ControlCodeId);
// 	  echo "<pre>";
// 	  print_r( $data['GetAllChartOfAccount']);
// 	  die();
		$data['GetSettingInformation'] = $this->Employee_model->GetSettingInformation();
	    $this->load->view('report/accountreports/view_trailbalance_report', $data);
	}
	
}

    
?>
