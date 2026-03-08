<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Dashboard extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->check_isvalidated();
        $this->load->model('Employee_model');
        $this->load->model('Dashboard_model');
        $this->load->model('Customer_model');
//        $this->load->helper("url");
		date_default_timezone_set('Asia/Karachi');
		
		        $this->load->model('Product_model');
        $this->load->model('COA_model');
        $this->load->model('StockReport_model');
        $this->load->model('Category_model');
		
		
	}

	function index__()
	{
	    $data['EmployeeRoles'] = $this->Employee_model->GetEmployeeRoles($this->session->userdata('EmployeeId'));
	    $data['AdministrationRoles'] = $this->Employee_model->GetAdministrationRoles($this->session->userdata('EmployeeId'));
	    $data['SalesRoles'] = $this->Employee_model->GetSalesRoles($this->session->userdata('EmployeeId'));
	    $data['PurchasesRoles'] = $this->Employee_model->GetPurchasesRoles($this->session->userdata('EmployeeId'));
	    $data['ReportsRoles'] = $this->Employee_model->GetReportsRoles($this->session->userdata('EmployeeId'));
	    $data['RegistrationRoles'] = $this->Employee_model->GetRegistrationRoles($this->session->userdata('EmployeeId'));
	    $data['TransactionRoles'] = $this->Employee_model->GetTransactionRoles($this->session->userdata('EmployeeId'));
	    $data['CustomerNotification'] = $this->Customer_model->GetNotifications();

	    $this->load->view('dashboard/dashboards', $data);
	}
	
	
	
	function index()
	{
	    $data['EmployeeRoles'] = $this->Employee_model->GetEmployeeRoles($this->session->userdata('EmployeeId'));
	    $data['AdministrationRoles'] = $this->Employee_model->GetAdministrationRoles($this->session->userdata('EmployeeId'));
	    $data['SalesRoles'] = $this->Employee_model->GetSalesRoles($this->session->userdata('EmployeeId'));
	    $data['PurchasesRoles'] = $this->Employee_model->GetPurchasesRoles($this->session->userdata('EmployeeId'));
	    $data['ReportsRoles'] = $this->Employee_model->GetReportsRoles($this->session->userdata('EmployeeId'));
	    $data['RegistrationRoles'] = $this->Employee_model->GetRegistrationRoles($this->session->userdata('EmployeeId'));
	    $data['TransactionRoles'] = $this->Employee_model->GetTransactionRoles($this->session->userdata('EmployeeId'));
	    $data['CustomerNotification'] = $this->Customer_model->GetNotifications();
	    

		$data['CancelledSales'] = $this->Dashboard_model->CancelledSales();
		$data['CancelledPurchases'] = $this->Dashboard_model->CancelledPurchases();

		$data['CurrentMonthSales'] = $this->Dashboard_model->CurrentMonthSales();
	    $data['CurrentMonthPurchase'] = $this->Dashboard_model->CurrentMonthPurchase();
	    
	    
	    $data['CurrentMonthSales'] = $this->Dashboard_model->CurrentMonthSales();
		$data['DashboardLedgerReport'] = $this->Dashboard_model->DashboardLedgerReport();
		$data['DashboardSubLedgerReport'] = $this->Dashboard_model->DashboardSubLedgerReport();
		$data['DashboardSubLedgerReportCash'] = $this->Dashboard_model->DashboardSubLedgerReportCash();
		
				$data['DashboardTotalDebitOrCredit'] = $this->Dashboard_model->TotalDebitOrCredit();
		
// 		print_r($data['DashboardTotalDebitOrCredit']);
// 		die();
/*	    
	   $data['Sales'] = $this->Dashboard_model->TotalSales();
	   $data['Purchases'] = $this->Dashboard_model->TotalPurchases();
	   $data['Customers'] = $this->Dashboard_model->TotalCustomers();
	   $data['Vendors'] = $this->Dashboard_model->TotalVendors();

	   $data['CustomerOutstanding'] = $this->Dashboard_model->CustomerOutstanding();
	   $data['VendorOutstanding'] = $this->Dashboard_model->VendorOutstanding();
	   
	   $data['TotalSalesInvoices'] = $this->Dashboard_model->TotalSalesInvoices();
	   $data['TotalInvoices'] = $this->Dashboard_model->TotalInvoices();

	   $data['FeaturedCustomers'] = $this->Dashboard_model->FeaturedCustomers();
	   $data['FeaturedVendors'] = $this->Dashboard_model->FeaturedVendors();
	   $data['FeaturedProducts'] = $this->Dashboard_model->FeaturedProducts();
	   	$data['FeaturedPurchasedProducts'] = $this->Dashboard_model->FeaturedPurchasedProducts();
	   $data['FinishedProductDetail'] = $this->Dashboard_model->SumAllFinishedProducts();
	   $data['BankBalance'] = $this->Dashboard_model->BankBalance();*/

/*	   echo "<pre>";
	   print_r($data['BankBalance']);
	   die;*/


	$data['assets'] = $this->DashboardControlCode('dropdown',1);
			foreach($data['assets'] as $key =>$val){
			    $data['assets'][$key]['balance']=$this->DashboardChartaccount($val['ChartOfAccountCategoryId'],$val['ChartOfAccountControlId']);
			 //   print_r($val['ChartOfAccountControlId']);die();
			}
	$data['liabilities'] = $this->DashboardControlCode('dropdown',2);
			foreach($data['liabilities'] as $key =>$val){
			    $data['liabilities'][$key]['balance']=$this->DashboardChartaccount($val['ChartOfAccountCategoryId'],$val['ChartOfAccountControlId']);
			 //   print_r($val['ChartOfAccountControlId']);die();
			}
	$data['Expensis'] = $this->DashboardControlCode('dropdown',4);
			foreach($data['Expensis'] as $key =>$val){
			 //   print_r($val['ChartOfAccountCategoryId'].'-'.$val['ChartOfAccountControlId'].",");
			    $data['Expensis'][$key]['balance']=$this->DashboardChartaccount($val['ChartOfAccountCategoryId'],$val['ChartOfAccountControlId']);
			 //   print_r($val['ChartOfAccountControlId']);die();
		}
		
		$data['CurrentMonthPurchase'] = $this->Dashboard_model->CurrentMonthPurchase();
	    $data['StockValue']  = 'All';
	    $data['stockvalue']=$this->stockvalue();
			
//	   	echo $this->output->enable_profiler();
	   $this->load->view('dashboard/dashboards',$data);
	}
	
	
	public function DashboardControlCode($view = 'dropdown' ,$CategoryId)
	{
            // $CategoryId = $this->input->post('id');
            $COA_Id = $this->input->post('COA_id');
            // $COA_Id =4;
            // $CategoryId = 1;
            $data['GetChartOfAccount'] = $this->COA_model->GetChartOfAccount($COA_Id,'pos_accounts_chartofaccount_controls.ChartOfAccountControlId,pos_accounts_chartofaccount_categories.ChartOfAccountCategoryId');
            if(!$CategoryId)
            $CategoryId = $data['GetChartOfAccount']->ChartOfAccountCategoryId;
            $data['view'] = $view;
            return $this->COA_model->GetControlCodeByCategoryId($CategoryId);
            // retrun $data['GetControlCode']=$this->COA_model->GetControlCodeByCategoryId($CategoryId);
            $data['CustomerNotification'] = $this->Customer_model->GetNotifications();
            // echo "<pre>";
            // print_r($data['GetControlCode']);
            // $this->load->view('chartofaccount/controlcode',$data);
	}
	
	public function DashboardChartaccount($CategoryId,$ControlCodeId)
	{
	                 $conditionArray = array();
            if($CategoryId != 0 && $CategoryId != '' && $CategoryId != 'undefined')
                $conditionArray['pos_accounts_chartofaccount_categories.ChartOfAccountCategoryId'] = $CategoryId;
            if($ControlCodeId != 0 && $ControlCodeId != '' && $ControlCodeId != 'undefined')
                $conditionArray['pos_accounts_chartofaccount_controls.ChartOfAccountControlId'] = $ControlCodeId;
            // if($ChartOfAccountId != 0 && $ChartOfAccountId != '' && $ChartOfAccountId != 'undefined')
            //     $conditionArray['pos_accounts_chartofaccount.ChartOfAccountId'] = $ChartOfAccountId;
            
            $this->db->select('pos_accounts_generaljournal.TransactionDate');
            $this->db->from('pos_accounts_generaljournal');
            $this->db->join('pos_accounts_generaljournal_entries','pos_accounts_generaljournal_entries.GeneralJournalId=pos_accounts_generaljournal.GeneralJournalId');
            $this->db->join('pos_accounts_chartofaccount','pos_accounts_chartofaccount.ChartOfAccountId=pos_accounts_generaljournal_entries.ChartOfAccountId');
            $this->db->join('pos_accounts_chartofaccount_controls','pos_accounts_chartofaccount_controls.ChartOfAccountControlId=pos_accounts_chartofaccount.ChartOfAccountControlId');
            $this->db->join('pos_accounts_chartofaccount_categories','pos_accounts_chartofaccount_categories.ChartOfAccountCategoryId=pos_accounts_chartofaccount.ChartOfAccountCategoryId');
            $this->db->where($conditionArray);
            
            if($CategoryId==4){
                $StartDate=date('Y-m-01');
                $EndDate = date("Y-m-t", strtotime($StartDate));
                  $ConditionDate = "  pos_accounts_generaljournal.TransactionDate BETWEEN '$StartDate' AND '$EndDate' ";
                
            $this->db->where($ConditionDate);    
            }
            
            $this->db->select_sum('pos_accounts_generaljournal_entries.Debit');
            $this->db->select_sum('pos_accounts_generaljournal_entries.Credit');
            $this->db->order_by("pos_accounts_generaljournal.TransactionDate");
            $query = $this->db->get();
            $abcd=$query->row();
            //  if($ControlCodeId==4){
            // echo "<pre>";
            // print_r($abcd);
            //  }
            return $abcd;
	}
	
		private function stockvalue()
	{
	    $CategoryId = 0;
	    $BrandId = 0;
	    $ProductGroupId = 0;
	    $StartDate = "1971-01-01";
	    $EndDate = date('Y-m-d');

	    $data['AdministrationRoles'] = $this->Employee_model->GetAdministrationRoles($this->session->userdata('EmployeeId'));
	    $data['SalesRoles'] = $this->Employee_model->GetSalesRoles($this->session->userdata('EmployeeId'));
	    $data['PurchasesRoles'] = $this->Employee_model->GetPurchasesRoles($this->session->userdata('EmployeeId'));
	    $data['RegistrationRoles'] = $this->Employee_model->GetRegistrationRoles($this->session->userdata('EmployeeId'));
	    $data['TransactionRoles'] = $this->Employee_model->GetTransactionRoles($this->session->userdata('EmployeeId'));
	    $data['ReportsRoles'] = $this->Employee_model->GetReportsRoles($this->session->userdata('EmployeeId'));
	   
	    $data['AllProducts']   = $this->Product_model->GetProducts($StartDate,$EndDate,$CategoryId,$ProductGroupId,$BrandId);
		$data['ProductsPrice'] = $this->Product_model->GetProductsPrice($StartDate,$EndDate,$CategoryId,$ProductGroupId,$BrandId);
		$data['AllPurchaseReturnRecord'] = $this->StockReport_model->GetPurchaseReturnRecord($StartDate,$EndDate,$CategoryId,$ProductGroupId,$BrandId);
	    $data['AllSaleRecord'] = $this->StockReport_model->GetSaleRecord($StartDate,$EndDate,$CategoryId,$ProductGroupId,$BrandId);
	    
		$data['GetCategory'] = $this->Category_model->GetCategoryById($CategoryId);
		
		$data['GetSettingInformation'] = $this->Employee_model->GetSettingInformation();
		$data['CustomerNotification'] = $this->Customer_model->GetNotifications();
		return $data;
	    
	}
	private function check_isvalidated()
	{
            if(!$this->session->userdata('EmployeeId'))
            { $this->session->set_userdata('url',  current_url()); redirect('Login'); }
	}
}
?>