<?php error_reporting(0);
defined('BASEPATH') or exit('No direct script access allowed');
class InvoiceReceipt extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->check_isvalidated();
		$this->load->model('Accounts_model');
		$this->load->model('Account_model');
		$this->load->model('Customer_model');
		$this->load->model('Reference_model');
		$this->load->model('Product_model');
		$this->load->model('Sale_model');
		$this->load->model('Employee_model');
		$this->load->model('Category_model');
		$this->load->model('InvoiceReceipt_model');
		$this->load->model('Area_model');
	}


	private function check_isvalidated()
	{
		if (!$this->session->userdata('EmployeeId')) {
			$this->session->set_userdata('url',  current_url());
			redirect('Login');
		}
	}

	public function AllCustomers()
	{
		$data['AllCustomers'] = $this->Customer_model->GetAllCustomers();
		$data['CustomerNotification'] = $this->Customer_model->GetNotifications();
		$this->load->view('sale/customers', $data);
	}

	function index()
	{
		$data['AdministrationRoles'] = $this->Employee_model->GetAdministrationRoles($this->session->userdata('EmployeeId'));
		$data['SalesRoles'] = $this->Employee_model->GetSalesRoles($this->session->userdata('EmployeeId'));
		$data['PurchasesRoles'] = $this->Employee_model->GetPurchasesRoles($this->session->userdata('EmployeeId'));
		$data['RegistrationRoles'] = $this->Employee_model->GetRegistrationRoles($this->session->userdata('EmployeeId'));
		$data['TransactionRoles'] = $this->Employee_model->GetTransactionRoles($this->session->userdata('EmployeeId'));
		$data['ReportsRoles'] = $this->Employee_model->GetReportsRoles($this->session->userdata('EmployeeId'));
		//	    $data['AllSales'] = $this->Sale_model->GetAllSales();
		$data['CustomerNotification'] = $this->Customer_model->GetNotifications();
		$this->load->view('invoicereceipt/invoice_receipt', $data);
	}


	public function Ajax_GetAllSales()
	{
		$SalesRoles = $this->Employee_model->GetSalesRoles($this->session->userdata('EmployeeId'));
		$GetAllGeneralJournal = $this->InvoiceReceipt_model->Ajax_GetAllGeneralJournal($_REQUEST);

		// Employee Role For Record Update
		//	    $AccountsRoles = $this->Employee_model->GetAccountsRoles($this->session->userdata('EmployeeId'));
		$ViewRecord = '<span style="color:#00a65a;" class="glyphicon glyphicon-th-large"></span>';

		//    if ($AccountsRoles[0]['UpdateRoles']==1){
		$UpdateRecord = '<span style="color:#0c6aad;" class="ace-icon fa fa-edit">';

		$data = array();

		//$GetAllGeneralJournal = array_filter($GetAllGeneralJournal);
		foreach ($GetAllGeneralJournal['record'] as $row) {
			$nestedData = array();
			$nestedData[] = $row["GeneralJournalId"];
			$nestedData[] = $row["SaleUniqueId"];
			$nestedData[] = '<p style="color: #002480;font-weight:bold;">' . $row["CustomerName"] . '</p>';
			$nestedData[] = '<p style="color: #008000;font-weight:bold;">' . $row["Area_name"] . '</p>';
			$nestedData[] = date('M d, Y', strtotime($row["TransactionDate"]));
			$nestedData[] = $row["Reference"];
			$nestedData[] = $row["TotalDebit"];
			$id = $row["GeneralJournalId"];
			$EntryType = $row["EntryType"];
			$receiptno = $row['ReceiptNo'];
			$nestedData[] = $row["ReceiptNo"] . " <a href='../SaleReports/ViewChequeReport?chaque=$receiptno'> Report</a>";

			$nestedData[] = '<a href="' . base_url() . 'InvoiceReceipt/ViewInvoiceReceipt/' . $id . '" title="View Record">' . $ViewRecord . '</a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="' . base_url() . 'InvoiceReceipt/EditInvoiceReceipt/' . $id . '"title="Update Record"><span style="color:#0c6aad;" class="fa fa-edit"></span></a>';

			$data[] = $nestedData;
		}
		$json_data = array(
			"draw"            => intval($_REQUEST['draw']),   // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw. 
			"recordsTotal"    => intval($GetAllGeneralJournal['recordsTotal']),  // total number of records
			"recordsFiltered" => intval($GetAllGeneralJournal['recordsFiltered']), // total number of records after searching, if there is no searching then totalFiltered = totalData
			"data"            => $data   // total data array
		);
		echo json_encode($json_data);  // send data as json format
	}

	function GetRemainingProduct()
	{
		//		$LocationId = $this->input->post('LocationId');
		$ProductId = $this->input->post('ProductId');
		$Price = 0;
		$Quantity = 0;
		$TotalSold = 0;
		$RemainingProducts = 0;
		//	    	$data['TotalProducts'] = $this->Sale_model->TotalProducts($ProductId, $LocationId);
		$data['TotalProducts'] = $this->Sale_model->TotalProducts($ProductId);

		foreach ($data['TotalProducts'] as $row) {
			$Quantity += $row['Quantity'];
		}
		$TotalPurchased = $Quantity;

		//	    	$data['SoldProducts'] = $this->Sale_model->SoldProducts($ProductId, $LocationId);
		$data['SoldProducts'] = $this->Sale_model->SoldProducts($ProductId);
		foreach ($data['SoldProducts'] as $Sold) {
			$TotalSold += $Sold['Quantity'];
		}
		if ($RemainingProducts = $TotalPurchased - $TotalSold) {
			//	    	echo "Remaining Stock: " . $RemainingProducts;
			echo $RemainingProducts;
			$GetLastPrice = $this->Sale_model->GetLastPrice($ProductId);
			//	    $Total = $TotalProducts->PurchaseId;
			//		echo "Remaining Stock " . ($Total - $SoldProducts);
			//			echo "<br> Last Sold Price " . $Price == $GetLastPrice ? $GetLastPrice->Rate : "" ;
		} else if (!$RemainingProducts) {
?>
			<script>
				alert("No Stock Available. You can not sale this Product Now");
				location.reload();
			</script>
<?php
		}
	}

	function ViewInvoiceReceipt($GeneralJournalId)
	{
		$data['AdministrationRoles'] = $this->Employee_model->GetAdministrationRoles($this->session->userdata('EmployeeId'));
		$data['SalesRoles'] = $this->Employee_model->GetSalesRoles($this->session->userdata('EmployeeId'));
		$data['PurchasesRoles'] = $this->Employee_model->GetPurchasesRoles($this->session->userdata('EmployeeId'));
		$data['RegistrationRoles'] = $this->Employee_model->GetRegistrationRoles($this->session->userdata('EmployeeId'));
		$data['TransactionRoles'] = $this->Employee_model->GetTransactionRoles($this->session->userdata('EmployeeId'));
		$data['ReportsRoles'] = $this->Employee_model->GetReportsRoles($this->session->userdata('EmployeeId'));

		$data['GetInvoiceReceipt'] = $this->InvoiceReceipt_model->GetGeneralJournalView($GeneralJournalId);

		$data['Areas'] = $this->Area_model->GetAllAreas();
		$data['CustomerNotification'] = $this->Customer_model->GetNotifications();
		// echo "<pre>";
		// print_r( $data);
		// die();
		$this->load->view('invoicereceipt/view_invoice_receipt', $data);
	}


	public function AddInvoiceReceipt()
	{
		// clear sale cart
		$this->db->where('AddedBy', $this->session->userdata('EmployeeId'));
		$this->db->delete('pos_sales_cart');

		$data['AdministrationRoles'] = $this->Employee_model->GetAdministrationRoles($this->session->userdata('EmployeeId'));
		$data['SalesRoles'] = $this->Employee_model->GetSalesRoles($this->session->userdata('EmployeeId'));
		$data['PurchasesRoles'] = $this->Employee_model->GetPurchasesRoles($this->session->userdata('EmployeeId'));
		$data['RegistrationRoles'] = $this->Employee_model->GetRegistrationRoles($this->session->userdata('EmployeeId'));
		$data['TransactionRoles'] = $this->Employee_model->GetTransactionRoles($this->session->userdata('EmployeeId'));
		$data['ReportsRoles'] = $this->Employee_model->GetReportsRoles($this->session->userdata('EmployeeId'));
		$data['AllCustomers'] = $this->Customer_model->GetAllCustomers();
		$data['GetAllCategories'] = $this->Category_model->GetAllCategories();
		$data['GetAllBankAccounts'] = $this->Account_model->GetAllBankAccounts();
		//$data['InstallmentDetail'] = $this->InvoiceReceipt_model->GetCustomerById();

		$data['GetAllAreas'] = $this->Area_model->GetAllAreas();
		$data['CustomerNotification'] = $this->Customer_model->GetNotifications();
		$this->load->view('invoicereceipt/add_invoice_receipt', $data);
	}
	public function AddMultiInvoiceReceipt()
	{
		// clear sale cart
		$this->db->where('AddedBy', $this->session->userdata('EmployeeId'));
		$this->db->delete('pos_sales_cart');

		$data['AdministrationRoles'] = $this->Employee_model->GetAdministrationRoles($this->session->userdata('EmployeeId'));
		$data['SalesRoles'] = $this->Employee_model->GetSalesRoles($this->session->userdata('EmployeeId'));
		$data['PurchasesRoles'] = $this->Employee_model->GetPurchasesRoles($this->session->userdata('EmployeeId'));
		$data['RegistrationRoles'] = $this->Employee_model->GetRegistrationRoles($this->session->userdata('EmployeeId'));
		$data['TransactionRoles'] = $this->Employee_model->GetTransactionRoles($this->session->userdata('EmployeeId'));
		$data['ReportsRoles'] = $this->Employee_model->GetReportsRoles($this->session->userdata('EmployeeId'));
		$data['AllCustomers'] = $this->Customer_model->GetAllCustomers();
		$data['GetAllCategories'] = $this->Category_model->GetAllCategories();
		$data['GetAllBankAccounts'] = $this->Account_model->GetAllBankAccounts();
		//$data['InstallmentDetail'] = $this->InvoiceReceipt_model->GetCustomerById();

		$data['GetAllAreas'] = $this->Area_model->GetAllAreas();
		$data['CustomerNotification'] = $this->Customer_model->GetNotifications();
		$this->load->view('invoicereceipt/add_invoice_receipt2', $data);
	}

	public function EditInvoiceReceipt($GeneralJournalId)
	{
		$data['AdministrationRoles'] = $this->Employee_model->GetAdministrationRoles($this->session->userdata('EmployeeId'));
		$data['SalesRoles'] = $this->Employee_model->GetSalesRoles($this->session->userdata('EmployeeId'));
		$data['PurchasesRoles'] = $this->Employee_model->GetPurchasesRoles($this->session->userdata('EmployeeId'));
		$data['RegistrationRoles'] = $this->Employee_model->GetRegistrationRoles($this->session->userdata('EmployeeId'));
		$data['TransactionRoles'] = $this->Employee_model->GetTransactionRoles($this->session->userdata('EmployeeId'));
		$data['ReportsRoles'] = $this->Employee_model->GetReportsRoles($this->session->userdata('EmployeeId'));
		$data['GetAllBankAccounts'] = $this->Account_model->GetAllBankAccounts();

		$data['GetInvoiceReceipt'] = $this->InvoiceReceipt_model->GetGeneralJournalView($GeneralJournalId);

		$GetInvoiceReceipt = (array) $data['GetInvoiceReceipt'];
		$data['Balance'] = $this->InvoiceReceipt_model->GetBalance($GetInvoiceReceipt['GeneralJournal']->SaleId);
		$data['GeneralJournalId'] = $GeneralJournalId;

		$data['Areas'] = $this->Area_model->GetAllAreas();
		$data['CustomerNotification'] = $this->Customer_model->GetNotifications();
		$this->load->view('invoicereceipt/edit_invoice_receipt', $data);
	}


	public function SaveSale___()
	{
		$AddSaleRecordBtn = $this->input->post('AddSaleRecordBtn');

		if ($AddSaleRecordBtn == 'AddSaleRecord') {
			if ($SaleId = $this->Sale_model->SaveSaleDetail()) {
				redirect(base_url() . "Sales/ViewSale/$SaleId");
			}
		}
	}


	public function SaveInstallment()
	{
		$AddSaleRecordBtn = $this->input->post('AddSaleRecordBtn');

		if ($AddSaleRecordBtn == 'AddSaleRecord') {
			$SaleId = $this->InvoiceReceipt_model->SaveInstallmentDetail();
			redirect(base_url() . "InvoiceReceipt/ViewInvoiceReceipt/$SaleId");
		}
	}
	public function SaveMultiInstallment()
	{
		$AddSaleRecordBtn = $this->input->post('submitForm');
		// print_r($this->input->post());
		if ($AddSaleRecordBtn == 'AddRecord') {
			$SaleId = $this->InvoiceReceipt_model->SaveMultiInstallmentDetail();
			
			redirect(base_url() . "InvoiceReceipt/ViewInvoiceReceipt/$SaleId");
		}
	}

	public function UpdateInvoiceReceipt()
	{
		// echo "<pre>";
		//       print_r($this->input->post()); exit;
		//       echo "</pre>";
		if ($this->input->post('GeneralJournalId') != '') {
			$GeneralJournalId = $this->InvoiceReceipt_model->UpdateInstallmentDetail();
			redirect(base_url() . "InvoiceReceipt/ViewInvoiceReceipt/" . $GeneralJournalId);
		}
	}

	public function AccountReceivableAmount()
	{
		$CustomerId = $this->input->post('CustomerId');
		$CoAId = $this->input->post('CoAId');

		$DebitRecord = $this->Sale_model->DebitRecord($CoAId);
		$CreditRecord = $this->Sale_model->CreditRecord($CoAId);

		$AccountReceivableAmount = ($DebitRecord->Debit - $CreditRecord->Credit);
		echo $AccountReceivableAmount;
	}

	public function GetProductSaleRates()
	{
		$ProductId = 0;
		if ($this->input->post('ProductId') != 0 || $this->input->post('ProductId') != '') {
			$ProductId = $this->input->post('ProductId');
		}

		$this->db->select("SellPrice");
		$this->db->from('pos_products');
		$this->db->where('ProductId', $ProductId);
		$this->db->order_by("ProductId", "DESC");
		$this->db->limit('1');
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			$res = $query->row();
			$ProductRate = $res->SellPrice;
		} else {
			$ProductRate = 0;
		}

		if ($this->input->post('ProductId') != 0 || $this->input->post('ProductId') != '') {
			echo json_encode($ProductRate);
		}
	}

	public function GetCustomerData()
	{
		$allotment_id = $this->input->post('allotment_id');

		$Customer = $this->InvoiceReceipt_model->GetCustomerById($allotment_id);
		echo json_encode($Customer);
	}

	public function DeleteSale($id)
	{

		$Delete = $this->Sale_model->DeleteSale($id);
		if ($Delete) {
			$this->session->set_flashdata("record_deleted", "Record deleted successfully.");
			redirect(base_url() . "Sales/index");
		}
	}

	public function AutoCompleteSearch_COA()
	{
		$SalesId = $this->input->post('InvoiceNumber');
		$query = $this->db->query("SELECT S.SaleId,S.SaleDate, PA.Area_name,
            C.CustomerId,C.ChartOfAccountId,C.CustomerName,S.UniqueId
                 FROM  pos_sales AS S
                  LEFT JOIN pos_customer AS C ON C.CustomerId = S.CustomerId
                  LEFT JOIN pos_area AS PA ON PA.id = C.AreaId
                  WHERE S.UniqueId LIKE '$SalesId' ");

		$ChartOfAccount = array();

		foreach ($query->result_array() as $key) {
			// and pos_accounts_generaljournal.SaleId IS Null 
			$getBalance = $this->db->query("SELECT pos_accounts_generaljournal_entries.Debit
                 FROM  pos_accounts_generaljournal_entries,pos_accounts_generaljournal
                  WHERE pos_accounts_generaljournal_entries.GeneralJournalId=pos_accounts_generaljournal.GeneralJournalId and pos_accounts_generaljournal.CustomerId='" . $key["CustomerId"] . "' and pos_accounts_generaljournal.SaleUniqueId = '" . $key["UniqueId"] . "'");

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
			$bn = array(
				'SaleId' => trim($key['SaleId']),
				'UniqueId' => trim($key['UniqueId']),
				'value' => trim($key['SaleId']),
				'SaleDate' => trim($key['SaleDate']),
				'AreaName' => trim($key['Area_name']),
				'CustomerName' => trim($key['CustomerName']),
				'CustomerId' => trim($key['CustomerId']),
				'ChartOfAccountId' => trim($key['ChartOfAccountId']),
				'PreviousBalance' => $previousBalance - $lastPaidAmount
			);

			$ChartOfAccount[] = $bn;
		}

		echo json_encode($ChartOfAccount);
	}
	public function AutoMultiCompleteSearch_COA()
	{
		$SalesId = $this->input->post('customer_name');

		$query = $this->db->query("SELECT S.SaleId,S.SaleDate, PA.Area_name,
            C.CustomerId,C.ChartOfAccountId,C.CustomerName,S.UniqueId
                 FROM  pos_sales AS S
                  LEFT JOIN pos_customer AS C ON C.CustomerId = S.CustomerId
                  LEFT JOIN pos_area AS PA ON PA.id = C.AreaId
                  WHERE S.CustomerId ='$SalesId' ");
//  AND S.isSecondarySale = 1
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
					'PreviousBalance' => $previousBalanceamount
				);

				$ChartOfAccount[] = $bn;
			}
		}

		echo json_encode($ChartOfAccount);
	}
}
?>