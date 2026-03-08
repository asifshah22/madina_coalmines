<?php defined('BASEPATH') OR exit('No direct script access allowed');


class Export extends CI_Controller {

	public function __construct()
	{
      parent::__construct();
      $this->check_isvalidated();
      $this->load->model('Company_model');
      $this->load->model('Vendor_model');
      $this->load->model('SaleReport_model');
      $this->load->model('Product_model');
      $this->load->model('Employee_model');
      $this->load->model('COA_model');
      $this->load->model('PurchaseReport_model');
      $this->load->model('AccountReport_model');
      $this->load->model('StockReport_model');
      $this->load->model('Category_model');
      $this->load->model('Customer_model');
      $this->load->model('Location_model');
      $this->load->model('Colour_model');
      $this->load->model('ProductReport_model');
//      $this->load->library('Email');
//      $this->load->library('Pdf');
	}
	
	
	private function check_isvalidated()
	{
	    if(!$this->session->has_userdata('EmployeeId'))
	    {  $this->session->set_userdata('url',  current_url()); redirect('Login'); }
	}


	public function ExportSaleDetailReport()
  {
      $SDate =date('Y-m-d', strtotime($this->input->get('StartDate')));
      $EDate =date('Y-m-d', strtotime($this->input->get('EndDate')));

      $data['AllEmployees'] = $this->Employee_model->GetAllEmployees();
      $data['SaleDetail'] = $this->SaleReport_model->GenerateSaleDetailReport($SDate,$EDate);
//      die('test');
      $body = $this->load->view('report/export/salereports/exportpdf_sale_detail_report',$data, TRUE);
//      $body = $this->output->get_output();
      $filename = "Sale Report";

      $this->load->library('Pdf');
      $this->dompdf->loadHtml('<h1> This is fpr test </h1>');
      $this->dompdf->setPaper('A4', 'landscape');
      $this->dompdf->render();
      $this->dompdf->stream($filename.'.pdf', array('Attachment'=>1));
  }


      public function ExportExcelSaleDetailReport()
      {
		$CustomerId = $this->input->get('CustomerId');
        $ReferenceId = $this->input->get('ReferenceId');
        $ProductId = $this->input->get('ProductId');
        $LocationId = $this->input->get('LocationId');
        $SaleType = $this->input->get('SaleType');
        $SaleMethod = $this->input->get('SaleMethod');
        $ColourId = $this->input->get('ColourId');
        $CategoryId = $this->input->get('CategoryId');
        $ProductGroupId = $this->input->get('ProductGroupId');
        $BrandId = $this->input->get('BrandId');
		
         $StartDate = date('Y-m-d', strtotime($this->input->get('StartDate')));
         $EndDate = date('Y-m-d', strtotime($this->input->get('EndDate')));

         $data['AllEmployees'] = $this->Employee_model->GetAllEmployees();
         $data['SaleDetail'] = $this->SaleReport_model->AllSales($CustomerId,$ReferenceId,$ProductId,$LocationId,$SaleType,$SaleMethod,$ColourId,$CategoryId,$ProductGroupId,$BrandId,$StartDate,$EndDate);
      
      $this->load->view('report/export/salereports/exportexcel_sale_detail_report',$data);
      }

      
      public function ExportWordSaleDetailReport()
      {
         $SDate = date('Y-m-d', strtotime($this->input->get('StartDate')));
         $EDate = date('Y-m-d', strtotime($this->input->get('EndDate')));

         $data['AllEmployees'] = $this->Employee_model->GetAllEmployees();
         $data['SaleDetail'] = $this->SaleReport_model->GenerateSaleDetailReport($SDate,$EDate);
         $data['CustomerNotification'] = $this->Customer_model->GetNotifications();
      
      $this->load->view('report/export/salereports/exportword_sale_detail_report',$data);
      }


public function ExportExcelSaleReturnDetailReport()
      {
        $CustomerId = $this->input->get('CustomerId');
        $ProductId = $this->input->get('ProductId');
        $LocationId = $this->input->get('LocationId');
        $ColourId = $this->input->get('ColourId');
        $CategoryId = $this->input->get('CategoryId');
        $ProductGroupId = $this->input->get('ProductGroupId');
        $BrandId = $this->input->get('BrandId');
        $SDate = $this->input->get('StartDate');
        $EDate = $this->input->get('EndDate');

        $StartDate = date("Y-m-d", strtotime($SDate));
        $EndDate = date("Y-m-d", strtotime($EDate));

        $data['Roles'] = $this->Employee_model->GetRoles();
        $data['AdministrationRoles'] = $this->Employee_model->GetAdministrationRoles($this->session->userdata('EmployeeId'));
        $data['SalesRoles'] = $this->Employee_model->GetSalesRoles($this->session->userdata('EmployeeId'));
        $data['PurchasesRoles'] = $this->Employee_model->GetPurchasesRoles($this->session->userdata('EmployeeId'));
        $data['RegistrationRoles'] = $this->Employee_model->GetRegistrationRoles($this->session->userdata('EmployeeId'));
        $data['TransactionRoles'] = $this->Employee_model->GetTransactionRoles($this->session->userdata('EmployeeId'));
        $data['ReportsRoles'] = $this->Employee_model->GetReportsRoles($this->session->userdata('EmployeeId'));

		$data['AllSalesReturn'] = $this->SaleReport_model->AllSalesReturn($CustomerId,$ProductId,$LocationId,$ColourId,$CategoryId,$ProductGroupId,$BrandId,$StartDate,$EndDate);
		
		$data['GetSettingInformation'] = $this->Employee_model->GetSettingInformation();		      
		$data['CustomerNotification'] = $this->Customer_model->GetNotifications();
      $this->load->view('report/export/salereports/exportexcel_sale_return_report',$data);
      }



      public function ExportExcelProductSaleDetailReport()
      {
         $SDate = date('Y-m-d', strtotime($this->input->get('StartDate')));
         $EDate = date('Y-m-d', strtotime($this->input->get('EndDate')));
         $ProductId = $this->input->get('ProductId');

         $data['AllEmployees'] = $this->Employee_model->GetAllEmployees();
         $data['SalesOrderProductDetailReport'] = $this->SaleReport_model->SalesOrderProductDetailReport($ProductId,$SDate,$EDate);
         $data['CustomerNotification'] = $this->Customer_model->GetNotifications();
      
      $this->load->view('report/export/salereports/exportexcel_product_sale_detail_report',$data);
      }


      public function ExportWordProductSaleDetailReport()
      {
         $SDate = date('Y-m-d', strtotime($this->input->get('StartDate')));
         $EDate = date('Y-m-d', strtotime($this->input->get('EndDate')));
         $ProductId = $this->input->get('ProductId');

         $data['AllEmployees'] = $this->Employee_model->GetAllEmployees();
         $data['SalesOrderProductDetailReport'] = $this->SaleReport_model->SalesOrderProductDetailReport($ProductId,$SDate,$EDate);
         $data['CustomerNotification'] = $this->Customer_model->GetNotifications();
      
      $this->load->view('report/export/salereports/exportword_product_sale_detail_report',$data);
      }


      public function ExportExcelProductSaleSummaryReport()
      {
         $SDate = date('Y-m-d', strtotime($this->input->get('StartDate')));
         $EDate = date('Y-m-d', strtotime($this->input->get('EndDate')));
         $ProductId = $this->input->get('ProductId');

         $data['AllEmployees'] = $this->Employee_model->GetAllEmployees();
         $data['ProductSaleSummary'] = $this->SaleReport_model->GenerateProductSaleSummaryReport($SDate,$EDate,$ProductId);
         $data['CustomerNotification'] = $this->Customer_model->GetNotifications();
      
//         die('test');
      $this->load->view('report/export/salereports/exportexcel_product_sale_summary_report',$data);
      }


      public function ExportWordProductSaleSummaryReport()
      {
         $SDate = date('Y-m-d', strtotime($this->input->get('StartDate')));
         $EDate = date('Y-m-d', strtotime($this->input->get('EndDate')));
         $ProductId = $this->input->get('ProductId');

         $data['AllEmployees'] = $this->Employee_model->GetAllEmployees();
         $data['ProductSaleSummary'] = $this->SaleReport_model->GenerateProductSaleSummaryReport($SDate,$EDate,$ProductId);
         $data['CustomerNotification'] = $this->Customer_model->GetNotifications();
      
      $this->load->view('report/export/salereports/exportword_product_sale_summary_report',$data);
      }

      public function ExportExcelCustomerSaleDetailReport()
      {
         $SDate = date('Y-m-d', strtotime($this->input->get('StartDate')));
         $EDate = date('Y-m-d', strtotime($this->input->get('EndDate')));
         $CustomerId = $this->input->get('CustomerId');

         $data['AllEmployees'] = $this->Employee_model->GetAllEmployees();
         $data['CustomerSaleDetail'] = $this->SaleReport_model->GenerateCustomerSaleDetailReport($SDate,$EDate,$CustomerId);
         $data['CustomerNotification'] = $this->Customer_model->GetNotifications();
      
//         die('test');
         $this->load->view('report/export/salereports/exportexcel_customer_sale_detail_report',$data);
      }


      public function ExportWordCustomerSaleDetailReport()
      {
         $SDate = date('Y-m-d', strtotime($this->input->get('StartDate')));
         $EDate = date('Y-m-d', strtotime($this->input->get('EndDate')));
         $CustomerId = $this->input->get('CustomerId');

         $data['AllEmployees'] = $this->Employee_model->GetAllEmployees();
         $data['CustomerSaleDetail'] = $this->SaleReport_model->GenerateCustomerSaleDetailReport($SDate,$EDate,$CustomerId);
         $data['CustomerNotification'] = $this->Customer_model->GetNotifications();
      
      $this->load->view('report/export/salereports/exportword_customer_sale_detail_report',$data);
      }


      public function ExportExcelCustomerSaleSummaryReport()
      {
         $SDate = date('Y-m-d', strtotime($this->input->get('StartDate')));
         $EDate = date('Y-m-d', strtotime($this->input->get('EndDate')));
         $CustomerId = $this->input->get('CustomerId');

         $data['AllEmployees'] = $this->Employee_model->GetAllEmployees();
         $data['CustomerSaleSummary'] = $this->SaleReport_model->GenerateCustomerSaleSummaryReport($SDate,$EDate,$CustomerId);
         $data['CustomerNotification'] = $this->Customer_model->GetNotifications();
      
         $this->load->view('report/export/salereports/exportexcel_customer_sale_summary_report',$data);
      }


      public function ExportWordCustomerSaleSummaryReport()
      {
         $SDate = date('Y-m-d', strtotime($this->input->get('StartDate')));
         $EDate = date('Y-m-d', strtotime($this->input->get('EndDate')));
         $CustomerId = $this->input->get('CustomerId');

         $data['AllEmployees'] = $this->Employee_model->GetAllEmployees();
         $data['CustomerSaleSummary'] = $this->SaleReport_model->GenerateCustomerSaleSummaryReport($SDate,$EDate,$CustomerId);
         $data['CustomerNotification'] = $this->Customer_model->GetNotifications();
      
         $this->load->view('report/export/salereports/exportword_customer_sale_summary_report',$data);
      }

    
      function ExportExcelCustomerSaleSummaryProductWise()
      {
         $CustomerId =$this->input->get('CustomerId');
         $SDate =date('Y-m-d', strtotime($this->input->get('StartDate')));
         $EDate =date('Y-m-d', strtotime($this->input->get('EndDate')));
            
         $data['AllEmployees'] = $this->Employee_model->GetAllEmployees();
         $data['CustomerProductSaleSummary'] = $this->SaleReport_model->GenerateCustomerProductSaleSummaryReport($SDate,$EDate,$CustomerId);
         $data['CustomerNotification'] = $this->Customer_model->GetNotifications();
         $this->load->view('report/export/salereports/exportexcel_customer_sale_summary_product_wise_report',$data);
      }

      function ExportWordCustomerSaleSummaryProductWise()
      {
         $CustomerId =$this->input->get('CustomerId');
         $SDate =date('Y-m-d', strtotime($this->input->get('StartDate')));
         $EDate =date('Y-m-d', strtotime($this->input->get('EndDate')));
            
         $data['AllEmployees'] = $this->Employee_model->GetAllEmployees();
         $data['CustomerProductSaleSummary'] = $this->SaleReport_model->GenerateCustomerProductSaleSummaryReport($SDate,$EDate,$CustomerId);    
         $data['CustomerNotification'] = $this->Customer_model->GetNotifications();
         $this->load->view('report/export/salereports/exportword_customer_sale_summary_product_wise_report',$data);
      }


      /*************** END OF EXPORT SALE REPORTS *****************/



   function ExportExcelPurchaseDetailReport()
   {
$SDate = "";
        $EDate = "";
        $StartDate = "";
        $EndDate = "";

        if($this->input->get('StartDate') != ""){        	
        	$SDate = $this->input->get('StartDate');
	        $StartDate = date("Y-m-d", strtotime($SDate));
        }

        if($this->input->get('EndDate') != ""){
	        $EDate = $this->input->get('EndDate');
	        $EndDate = date("Y-m-d", strtotime($EDate));
        }

        $VendorId = $this->input->get('VendorId');
        $ProductId = $this->input->get('ProductId');
        $LocationId = $this->input->get('LocationId');
        $PurchaseType = $this->input->get('PurchaseType');
        $ColourId = $this->input->get('ColourId');
        $CategoryId = $this->input->get('CategoryId');
        $ProductGroupId = $this->input->get('ProductGroupId');
        $BrandId = $this->input->get('BrandId');
        

        $data['Roles'] = $this->Employee_model->GetRoles();
        $data['AdministrationRoles'] = $this->Employee_model->GetAdministrationRoles($this->session->userdata('EmployeeId'));
        $data['SalesRoles'] = $this->Employee_model->GetSalesRoles($this->session->userdata('EmployeeId'));
        $data['PurchasesRoles'] = $this->Employee_model->GetPurchasesRoles($this->session->userdata('EmployeeId'));
        $data['RegistrationRoles'] = $this->Employee_model->GetRegistrationRoles($this->session->userdata('EmployeeId'));
        $data['TransactionRoles'] = $this->Employee_model->GetTransactionRoles($this->session->userdata('EmployeeId'));
        $data['ReportsRoles'] = $this->Employee_model->GetReportsRoles($this->session->userdata('EmployeeId'));
		$data['AllPurchaseReport'] = $this->PurchaseReport_model->GetPurchase($VendorId,$ProductId,$LocationId,$PurchaseType,$ColourId,$CategoryId,$ProductGroupId,$BrandId,$StartDate,$EndDate);

		$data['GetSettingInformation'] = $this->Employee_model->GetSettingInformation();
		$data['CustomerNotification'] = $this->Customer_model->GetNotifications();
      $this->load->view('report/export/purchasereports/exportexcel_purchase_detail_report',$data);
   }


   function ExportWordPurchaseDetailReport()
   {
      $SDate =date('Y-m-d', strtotime($this->input->get('StartDate')));
      $EDate =date('Y-m-d', strtotime($this->input->get('EndDate')));

      $data['AllEmployees'] = $this->Employee_model->GetAllEmployees();
      $data['PurchaseDetail'] = $this->SaleReport_model->GeneratePurchaseDetailReport($SDate,$EDate);    
      $data['CustomerNotification'] = $this->Customer_model->GetNotifications();
      $this->load->view('report/export/purchasereports/exportword_purchase_detail_report',$data);
   }


	public function ExportExcelPurchaseReturnReport()
	{
		$SDate = "";
        $EDate = "";
        $StartDate = "";
        $EndDate = "";

        if($this->input->get('StartDate') != ""){        	
        	$SDate = $this->input->get('StartDate');
	        $StartDate = date("Y-m-d", strtotime($SDate));
        }

        if($this->input->get('EndDate') != ""){
	        $EDate = $this->input->get('EndDate');
	        $EndDate = date("Y-m-d", strtotime($EDate));
        }

        $VendorId = $this->input->get('AccountId');
        $ProductId = $this->input->get('ProductId');
        $LocationId = $this->input->get('LocationId');
        $PurchaseType = $this->input->get('PurchaseType');
        $CategoryId = $this->input->get('CategoryId');
        $ProductGroupId = $this->input->get('ProductGroupId');
        $BrandId = $this->input->get('BrandId');
                
        $data['Roles'] = $this->Employee_model->GetRoles();
        $data['AdministrationRoles'] = $this->Employee_model->GetAdministrationRoles($this->session->userdata('EmployeeId'));
        $data['SalesRoles'] = $this->Employee_model->GetSalesRoles($this->session->userdata('EmployeeId'));
        $data['PurchasesRoles'] = $this->Employee_model->GetPurchasesRoles($this->session->userdata('EmployeeId'));
        $data['RegistrationRoles'] = $this->Employee_model->GetRegistrationRoles($this->session->userdata('EmployeeId'));
        $data['TransactionRoles'] = $this->Employee_model->GetTransactionRoles($this->session->userdata('EmployeeId'));
        $data['ReportsRoles'] = $this->Employee_model->GetReportsRoles($this->session->userdata('EmployeeId'));

		$data['AllPurchaseReturnReport'] = $this->PurchaseReport_model->AllPurchaseReturnReport($VendorId,$ProductId,$LocationId,$CategoryId,$ProductGroupId,$BrandId,$StartDate,$EndDate);

		$data['GetSettingInformation'] = $this->Employee_model->GetSettingInformation();
		$data['CustomerNotification'] = $this->Customer_model->GetNotifications();
		$this->load->view('report/export/purchasereports/exportexcel_purchase_return_report', $data);
	}


        function ExportExcelProductPurchaseDetailReport()
   {
       $ProductId =$this->input->get('ProductId');
       $SDate =date('Y-m-d', strtotime($this->input->get('StartDate')));
       $EDate =date('Y-m-d', strtotime($this->input->get('EndDate')));

      $data['AllEmployees'] = $this->Employee_model->GetAllEmployees();
       $data['ProductPurchaseDetail'] = $this->SaleReport_model->GenerateProductPurchaseDetailReport($SDate,$EDate,$ProductId); 
       $data['CustomerNotification'] = $this->Customer_model->GetNotifications();
       $this->load->view('report/export/purchasereports/exportexcel_product_purchase_detail_report',$data);
   }


        function ExportWordProductPurchaseDetailReport()
   {
       $ProductId =$this->input->get('ProductId');
       $SDate =date('Y-m-d', strtotime($this->input->get('StartDate')));
       $EDate =date('Y-m-d', strtotime($this->input->get('EndDate')));

      $data['AllEmployees'] = $this->Employee_model->GetAllEmployees();
       $data['ProductPurchaseDetail'] = $this->SaleReport_model->GenerateProductPurchaseDetailReport($SDate,$EDate,$ProductId); 
       $data['CustomerNotification'] = $this->Customer_model->GetNotifications();
       $this->load->view('report/export/purchasereports/exportword_product_purchase_detail_report',$data);
   }

        function ExportExcelProductPurchaseSummaryReport()
   {
       $ProductId =$this->input->get('ProductId');
       $SDate =date('Y-m-d', strtotime($this->input->get('StartDate')));
       $EDate =date('Y-m-d', strtotime($this->input->get('EndDate')));

      $data['AllEmployees'] = $this->Employee_model->GetAllEmployees();
      $data['ProductPurchaseDetail'] = $this->SaleReport_model->GenerateProductPurchaseSummaryReport($SDate,$EDate,$ProductId); 
      $data['CustomerNotification'] = $this->Customer_model->GetNotifications();
      $this->load->view('report/export/purchasereports/exportexcel_product_purchase_summary_report',$data);
   }

        function ExportWordProductPurchaseSummaryReport()
   {
       $ProductId =$this->input->get('ProductId');
       $SDate =date('Y-m-d', strtotime($this->input->get('StartDate')));
       $EDate =date('Y-m-d', strtotime($this->input->get('EndDate')));

      $data['AllEmployees'] = $this->Employee_model->GetAllEmployees();
      $data['ProductPurchaseDetail'] = $this->SaleReport_model->GenerateProductPurchaseSummaryReport($SDate,$EDate,$ProductId); 
      $data['CustomerNotification'] = $this->Customer_model->GetNotifications();
      $this->load->view('report/export/purchasereports/exportword_product_purchase_summary_report',$data);
   }

   function ExportExcelSupplierPurchaseDetailReport()
   {
       $VendorId =$this->input->get('VendorId');
       $SDate =date('Y-m-d', strtotime($this->input->get('StartDate')));
       $EDate =date('Y-m-d', strtotime($this->input->get('EndDate')));

      $data['AllEmployees'] = $this->Employee_model->GetAllEmployees();
       $data['SupplierPurchaseDetail'] = $this->SaleReport_model->GenerateSupplierPurchaseDetailReport($SDate,$EDate,$VendorId);   
       $data['CustomerNotification'] = $this->Customer_model->GetNotifications();
       $this->load->view('report/export/purchasereports/exportexcel_supplier_purchase_detail_report',$data);
   }

      function ExportWordSupplierPurchaseDetailReport()
   {
       $VendorId =$this->input->get('VendorId');
       $SDate =date('Y-m-d', strtotime($this->input->get('StartDate')));
       $EDate =date('Y-m-d', strtotime($this->input->get('EndDate')));

      $data['AllEmployees'] = $this->Employee_model->GetAllEmployees();
       $data['SupplierPurchaseDetail'] = $this->SaleReport_model->GenerateSupplierPurchaseDetailReport($SDate,$EDate,$VendorId);  
       $data['CustomerNotification'] = $this->Customer_model->GetNotifications();
       $this->load->view('report/export/purchasereports/exportword_supplier_purchase_detail_report',$data);
   }


   function ExportExcelSupplierPurchaseSummaryReport()
   {
       $VendorId =$this->input->get('VendorId');
       $SDate =date('Y-m-d', strtotime($this->input->get('StartDate')));
       $EDate =date('Y-m-d', strtotime($this->input->get('EndDate')));

      $data['AllEmployees'] = $this->Employee_model->GetAllEmployees();
       $data['SupplierPurchaseSummary'] = $this->SaleReport_model->GenerateSupplierPurchaseSummaryReport($SDate,$EDate,$VendorId);
       $data['CustomerNotification'] = $this->Customer_model->GetNotifications();
       $this->load->view('report/export/purchasereports/exportexcel_supplier_purchase_summary_report',$data);
   }


   function ExportWordSupplierPurchaseSummaryReport()
   {
       $VendorId =$this->input->get('VendorId');
       $SDate =date('Y-m-d', strtotime($this->input->get('StartDate')));
       $EDate =date('Y-m-d', strtotime($this->input->get('EndDate')));

      $data['AllEmployees'] = $this->Employee_model->GetAllEmployees();
      $data['SupplierPurchaseSummary'] = $this->SaleReport_model->GenerateSupplierPurchaseSummaryReport($SDate,$EDate,$VendorId);
      $data['CustomerNotification'] = $this->Customer_model->GetNotifications();
      $this->load->view('report/export/purchasereports/exportword_supplier_purchase_summary_report',$data);
   }


   function ExportExcelProductPurchaseSummarySupplierWise()
   {
       $ProductId =$this->input->get('ProductId');
       $VendorId =$this->input->get('VendorId');
       $SDate =date('Y-m-d', strtotime($this->input->get('StartDate')));
       $EDate =date('Y-m-d', strtotime($this->input->get('EndDate')));

      $data['AllEmployees'] = $this->Employee_model->GetAllEmployees();
       $data['SupplierPurchaseDetail'] = $this->SaleReport_model->ProductPurchaseSummarySupplierWise($SDate,$EDate,$VendorId,$ProductId);
       $data['CustomerNotification'] = $this->Customer_model->GetNotifications();
       $this->load->view('report/export/purchasereports/exportexcel_supplier_purchase_summary_product_wise',$data);
   }

   function ExportWordProductPurchaseSummarySupplierWise()
   {
      $ProductId =$this->input->get('ProductId');
      $VendorId =$this->input->get('VendorId');
      $SDate =date('Y-m-d', strtotime($this->input->get('StartDate')));
      $EDate =date('Y-m-d', strtotime($this->input->get('EndDate')));

      $data['AllEmployees'] = $this->Employee_model->GetAllEmployees();
      $data['SupplierPurchaseDetail'] = $this->SaleReport_model->ProductPurchaseSummarySupplierWise($SDate,$EDate,$VendorId,$ProductId);
      $data['CustomerNotification'] = $this->Customer_model->GetNotifications();
      $this->load->view('report/export/purchasereports/exportword_supplier_purchase_summary_product_wise',$data);
   }


      /************** END OF EXPORT PURCHASE REPORTS **************/


        function ExportExcelLedgerReport()
   {
       $CustomerId = $this->input->get('CustomerId');
       $BankId = $this->input->get('BId');
       $BankAcountId = $this->input->get('BAId');
       $CategoryId = $this->input->get('CId');
       $ControlCodeId = $this->input->get('CCId');
       $ChartOfAccountId = $this->input->get('COAId');
	   
       $SDate =date('Y-m-d', strtotime($this->input->get('StartDate')));
       $EDate =date('Y-m-d', strtotime($this->input->get('EndDate')));

       $data['AllEmployees'] = $this->Employee_model->GetAllEmployees();
	   
	    $data['LedgerReport'] = $this->AccountReport_model->LedgerReport($SDate,$EDate,$CategoryId,$ControlCodeId,$ChartOfAccountId);
	    $data['SubLedgerReport'] = $this->AccountReport_model->SubLedgerReport($SDate,$EDate,$CategoryId,$ControlCodeId,$ChartOfAccountId);
	    $data['OpenningBalance'] = $this->AccountReport_model->GetOpenningBalance($SDate,$EDate,$CategoryId,$ControlCodeId,$ChartOfAccountId);
		    
//		    echo $this->output->enable_profiler();
		$data['GetSettingInformation'] = $this->Employee_model->GetSettingInformation();
		$data['CustomerNotification'] = $this->Customer_model->GetNotifications();
       $this->load->view('report/export/accountreports/exportexcel_ledger_report',$data);
   }

     function ExportWordLedgerReport()
   {
       $CustomerId = $this->input->get('CustomerId');
       $BankId = $this->input->get('BId');
       $BankAcountId = $this->input->get('BAId');
       $CategoryId = $this->input->get('CId');
       $ControlCodeId = $this->input->get('CCId');
       $ChartOfAccountsId = $this->input->get('COAId');
       $SDate =date('Y-m-d', strtotime($this->input->get('StartDate')));
       $EDate =date('Y-m-d', strtotime($this->input->get('EndDate')));

       $data['AllEmployees'] = $this->Employee_model->GetAllEmployees();
       $data['LedgerReport'] = $this->SaleReport_model->LedgerReport($CategoryId,$ControlCodeId,$ChartOfAccountsId,$SDate,$EDate);
       $data['SubLedgerReport'] = $this->SaleReport_model->SubLedgerReport($CustomerId,$BankId,$BankAcountId,$CategoryId,$ControlCodeId,$ChartOfAccountsId,$SDate,$EDate);
       $data['OpenningBalanceOne']   = $this->SaleReport_model->GetOpenningBalance($CategoryId,$ControlCodeId,$ChartOfAccountsId,$SDate,$EDate);
       $data['SalesInvoiceDetail'] = $this->SaleReport_model->SalesInvoiceByCustomerId($CustomerId,$SDate,$EDate);
       $data['CustomerNotification'] = $this->Customer_model->GetNotifications();
       $this->load->view('report/export/accountreports/exportword_ledger_report',$data);
   }


   function ExportExcelTrialBalanceReport()
   {
       $CategoryId = $this->input->get('CId');
       $ControlCodeId = $this->input->get('CCId');
       $ChartOfAccountsId = $this->input->get('COAId');
       $SDate =date('Y-m-d', strtotime($this->input->get('StartDate')));
       $EDate =date('Y-m-d', strtotime($this->input->get('EndDate')));

         $data['AllEmployees'] = $this->Employee_model->GetAllEmployees();
       $data['COACategories'] = $this->COA_model->GetAllCategories($CategoryId);
       $data['GetAllControlCodes'] = $this->COA_model->GetAllControlCodes($ControlCodeId);
       $data['GetAllChartOfAccounts'] = $this->SaleReport_model->GetAllChartOfAccounts($CategoryId,$ControlCodeId,$ChartOfAccountsId,$SDate,$EDate);
       $data['CustomerNotification'] = $this->Customer_model->GetNotifications();
       $this->load->view('report/export/accountreports/exportexcel_trialbalance_report',$data);
   }


   function ExportWordTrialBalanceReport()
   {
       $CategoryId = $this->input->get('CId');
       $ControlCodeId = $this->input->get('CCId');
       $ChartOfAccountsId = $this->input->get('COAId');
       $SDate =date('Y-m-d', strtotime($this->input->get('StartDate')));
       $EDate =date('Y-m-d', strtotime($this->input->get('EndDate')));

         $data['AllEmployees'] = $this->Employee_model->GetAllEmployees();
       $data['COACategories'] = $this->COA_model->GetAllCategories($CategoryId);
       $data['GetAllControlCodes'] = $this->COA_model->GetAllControlCodes($ControlCodeId);
       $data['GetAllChartOfAccounts'] = $this->SaleReport_model->GetAllChartOfAccounts($CategoryId,$ControlCodeId,$ChartOfAccountsId,$SDate,$EDate);
       $data['CustomerNotification'] = $this->Customer_model->GetNotifications();
       $this->load->view('report/export/accountreports/exportword_trialbalance_report',$data);
   } 

   
   function ExportExcelIncomeStatementReport()
   {
       // 3 is used for Income, 4 is used for Expense
       
	    $StartDate =date('Y-m-d', strtotime($this->input->get('StartDate')));
	    $EndDate =date('Y-m-d', strtotime($this->input->get('EndDate')));
	    
	    $data['COACategories'] = $this->AccountReport_model->GetIncomeAndExpenseCategories(3,4);
	    $data['GetAllControlCodes'] = $this->AccountReport_model->GetIncomeAndExpenseControlCodes(3,4);
	    $data['GetAllChartOfAccount'] = $this->AccountReport_model->GetIncomeAndExpenseChartOfAccount(3,4,$StartDate,$EndDate);

		$data['GetSettingInformation'] = $this->Employee_model->GetSettingInformation();	
        $data['CustomerNotification'] = $this->Customer_model->GetNotifications();
       $this->load->view('report/export/accountreports/exportexcel_incomestatement_report',$data);
   }

   function ExportWordIncomeStatementReport()
   {
       // 3 is used for Income, 4 is used for Expense
       
       $SDate =date('Y-m-d', strtotime($this->input->get('StartDate')));
       $EDate =date('Y-m-d', strtotime($this->input->get('EndDate')));

       $data['COACategories'] = $this->COA_model->GetIncomeAndExpenseCategories(3,4);
       $data['GetAllControlCodes'] = $this->COA_model->GetIncomeAndExpenseControlCodes(3,4);
       $data['GetAllChartOfAccounts'] = $this->COA_model->GetIncomeAndExpenseChartOfAccounts(3,4,$SDate,$EDate);
       $data['AllEmployees'] = $this->Employee_model->GetAllEmployees();
       $data['CustomerNotification'] = $this->Customer_model->GetNotifications();

       $this->load->view('report/export/accountreports/exportword_incomestatement_report',$data);
   }   
   

   function ExportExcelBalanceSheetReport()
   {
       // 1 is used for Asset, 2 is used for Liability, 5 is used for Equity
       $AsOfDate =date('Y-m-d', strtotime($this->input->get('AsOfDate')));
      
       $data['AllEmployees'] = $this->Employee_model->GetAllEmployees();
       $data['COACategories'] = $this->COA_model->GetAssetLiabilityEquityCategories(1,2,5);
       $data['GetAllControlCodes'] = $this->COA_model->GetAssetLiabilityEquityControlCodes(1,2,5);
       $data['GetAllChartOfAccounts'] = $this->COA_model->GetAssetLiabilityEquityChartOfAccounts(1,2,5,$AsOfDate);
       $data['CustomerNotification'] = $this->Customer_model->GetNotifications();
       
       $this->load->view('report/export/accountreports/exportexcel_balancesheet_report',$data);
   }

   
   function ExportWordBalanceSheetReport()
   {
       // 1 is used for Asset, 2 is used for Liability, 5 is used for Equity
       $AsOfDate =date('Y-m-d', strtotime($this->input->get('AsOfDate')));
      
       $data['AllEmployees'] = $this->Employee_model->GetAllEmployees();
       $data['COACategories'] = $this->COA_model->GetAssetLiabilityEquityCategories(1,2,5);
       $data['GetAllControlCodes'] = $this->COA_model->GetAssetLiabilityEquityControlCodes(1,2,5);
       $data['GetAllChartOfAccounts'] = $this->COA_model->GetAssetLiabilityEquityChartOfAccounts(1,2,5,$AsOfDate);
       $data['CustomerNotification'] = $this->Customer_model->GetNotifications();
       
       $this->load->view('report/export/accountreports/exportword_balancesheet_report',$data);
   }


   function ExportExcelChartOfAccountReport()
   {
	    $ControlCodeId = $this->input->get('ControlCodeId');
	    $CategoryId = $this->input->get('CategoryId');

	    $data['AllEmployees'] = $this->Employee_model->GetAllEmployees();
	    $data['GetAllChartOfAccount'] = $this->AccountReport_model->GetAllChartOfAccountReport($CategoryId,$ControlCodeId);
		$data['GetSettingInformation'] = $this->Employee_model->GetSettingInformation();
		$data['CustomerNotification'] = $this->Customer_model->GetNotifications();
		
       $this->load->view('report/export/accountreports/exportexcel_chartofaccount_report',$data);
   }


   function ExportWordChartOfAccountReport()
   {
       $CategoryId = $this->input->get('CategoryId');

      $data['AllEmployees'] = $this->Employee_model->GetAllEmployees();
       $data['COACategories'] = $this->COA_model->GetIncomeAndExpenseCategories(3,4);
       $data['GetAllControlCodes'] = $this->COA_model->GetIncomeAndExpenseControlCodes(3,4);
       $data['GetAllChartOfAccounts'] = $this->COA_model->GetAllChartOfAccountsReport($CategoryId);
       $data['CustomerNotification'] = $this->Customer_model->GetNotifications();
       $this->load->view('report/export/accountreports/exportword_chartofaccount_report',$data);
   }


       function ExportExcelCustomerOutstandingReport()
   {
	    $ChartOfAccountId = $this->input->get('ChartOfAccountId');
		$SDate =date('Y-m-d', strtotime($this->input->get('StartDate')));
	    $EDate =date('Y-m-d', strtotime($this->input->get('EndDate')));

	   	$data['AllEmployees'] = $this->Employee_model->GetAllEmployees();
	    $data['CustomerOutstandingReport'] = $this->AccountReport_model->CustomerOutstandingReport($ChartOfAccountId,$SDate,$EDate);
	   	$data['OpenningBalance'] = $this->AccountReport_model->GetOpenningBalance($SDate,$EDate,$ChartOfAccountId);

		$data['GetSettingInformation'] = $this->Employee_model->GetSettingInformation();
		$data['CustomerNotification'] = $this->Customer_model->GetNotifications();
      $this->load->view('report/export/accountreports/exportexcel_customeroutstanding_report',$data);
   }

       function ExportWordCustomerOutstandingReport()
   {
       $ChartOfAccountsId = $this->input->get('ChartOfAccountsId');
       $SDate =date('Y-m-d', strtotime($this->input->get('StartDate')));
       $EDate =date('Y-m-d', strtotime($this->input->get('EndDate')));

      $data['AllEmployees'] = $this->Employee_model->GetAllEmployees();
      $data['CustomerOutstandingReport'] = $this->AccountReport_model->CustomerOutstandingReport($ChartOfAccountsId,$SDate,$EDate);
      $data['CustomerNotification'] = $this->Customer_model->GetNotifications();
      $this->load->view('report/export/accountreports/exportword_customeroutstanding_report',$data);
   }

    function ExportExcelVendorOutstandingReport()
   {
	    $ChartOfAccountId = $this->input->get('ChartOfAccountId');
	    $SDate =date('Y-m-d', strtotime($this->input->get('StartDate')));
		$EDate =date('Y-m-d', strtotime($this->input->get('EndDate')));

	   	$data['AllEmployees'] = $this->Employee_model->GetAllEmployees();
	    $data['VendorOutstandingReport'] = $this->AccountReport_model->VendorOutstandingReport($ChartOfAccountId,$SDate,$EDate);
	   	$data['OpenningBalance'] = $this->AccountReport_model->GetOpenningBalance($SDate,$EDate,$ChartOfAccountId);

	    $data['GetSettingInformation'] = $this->Employee_model->GetSettingInformation();
	    $data['CustomerNotification'] = $this->Customer_model->GetNotifications();
		
       $this->load->view('report/export/accountreports/exportexcel_vendoroutstanding_report',$data);
   }


    function ExportWordVendorOutstandingReport()
   {
       $ChartOfAccountsId = $this->input->get('ChartOfAccountsId');
       $SDate =date('Y-m-d', strtotime($this->input->get('StartDate')));
       $EDate =date('Y-m-d', strtotime($this->input->get('EndDate')));

         $data['AllEmployees'] = $this->Employee_model->GetAllEmployees();
       $data['CustomerOutstandingReport'] = $this->AccountReport_model->VendorOutstandingReport($ChartOfAccountsId,$SDate,$EDate);
       $data['CustomerNotification'] = $this->Customer_model->GetNotifications();
       $this->load->view('report/export/accountreports/exportword_vendoroutstanding_report',$data);
   }
   
   
       function ExportExcelVoucherReport()
	{
		$SDate = "";
		$EDate = "";

		if($this->input->get('StartDate')){
	    	$SDate = date('Y-m-d', strtotime($this->input->get('StartDate')));
		}
		if($this->input->get('EndDate')){
	    	$EDate = date('Y-m-d', strtotime($this->input->get('EndDate')));
		}
	
	    $ReferencePrefix = $this->input->get('ReferencePrefix');

	    $data['GetGeneralJournal'] = $this->AccountReport_model->GenerateVoucherReport($SDate,$EDate,$ReferencePrefix);
	    $data['GetSettingInformation'] = $this->Employee_model->GetSettingInformation();
	    $data['CustomerNotification'] = $this->Customer_model->GetNotifications();
	    $this->load->view('report/accountreports/voucher_report',$data);

	}



    function ExportExcelCashBookReport()
   {
      $ChartOfAccountsId = $this->input->get('ChartOfAccountsId');
       $SDate =date('Y-m-d', strtotime($this->input->get('StartDate')));
       $EDate =date('Y-m-d', strtotime($this->input->get('EndDate')));

         $data['AllEmployees'] = $this->Employee_model->GetAllEmployees();
       $data['OutwardCashBookReport'] = $this->SaleReport_model->GenerateOutwardCashBookReport($SDate,$EDate);
       $data['InwardCashBookReport'] = $this->SaleReport_model->GenerateInwardCashBookReport($SDate,$EDate);
       $data['CustomerNotification'] = $this->Customer_model->GetNotifications();

       $this->load->view('report/export/accountreports/exportexcel_cashbook_report',$data);
   }


    function ExportWordCashBookReport()
   {
      $ChartOfAccountsId = $this->input->get('ChartOfAccountsId');
       $SDate =date('Y-m-d', strtotime($this->input->get('StartDate')));
       $EDate =date('Y-m-d', strtotime($this->input->get('EndDate')));

         $data['AllEmployees'] = $this->Employee_model->GetAllEmployees();
       $data['OutwardCashBookReport'] = $this->SaleReport_model->GenerateOutwardCashBookReport($SDate,$EDate);
       $data['InwardCashBookReport'] = $this->SaleReport_model->GenerateInwardCashBookReport($SDate,$EDate);
       $data['CustomerNotification'] = $this->Customer_model->GetNotifications();

       $this->load->view('report/export/accountreports/exportword_cashbook_report',$data);
   }

    function ExportExcelBankBookReport()
   {
       $SDate =date('Y-m-d', strtotime($this->input->get('StartDate')));
       $EDate =date('Y-m-d', strtotime($this->input->get('EndDate')));

         $data['AllEmployees'] = $this->Employee_model->GetAllEmployees();
       $data['OutwardBankBookReport'] = $this->SaleReport_model->GenerateOutwardBankBookReport($SDate,$EDate);
       $data['InwardBankBookReport'] = $this->SaleReport_model->GenerateInwardBankBookReport($SDate,$EDate);
       $data['CustomerNotification'] = $this->Customer_model->GetNotifications();

       $this->load->view('report/export/accountreports/exportexcel_bankbook_report',$data);
   }

   
   function ExportWordBankBookReport()
   {
       $SDate =date('Y-m-d', strtotime($this->input->get('StartDate')));
       $EDate =date('Y-m-d', strtotime($this->input->get('EndDate')));

         $data['AllEmployees'] = $this->Employee_model->GetAllEmployees();
       $data['OutwardBankBookReport'] = $this->SaleReport_model->GenerateOutwardBankBookReport($SDate,$EDate);
       $data['InwardBankBookReport'] = $this->SaleReport_model->GenerateInwardBankBookReport($SDate,$EDate);
       $data['CustomerNotification'] = $this->Customer_model->GetNotifications();

       $this->load->view('report/export/accountreports/exportword_bankbook_report',$data);
   }


//		Stock Reports section starts here



	public function ExportExcelStockQuantityReport()
	{
	    $ProductId = $this->input->get('ProductId');
	    $BrandId = $this->input->get('BrandId');
	    $ProductGroupId = $this->input->get('ProductGroupId');
	    $StartDate =date('Y-m-d', strtotime($this->input->get('StartDate')));
	    $EndDate =date('Y-m-d', strtotime($this->input->get('EndDate')));

	    $data['AdministrationRoles'] = $this->Employee_model->GetAdministrationRoles($this->session->userdata('EmployeeId'));
	    $data['SalesRoles'] = $this->Employee_model->GetSalesRoles($this->session->userdata('EmployeeId'));
	    $data['PurchasesRoles'] = $this->Employee_model->GetPurchasesRoles($this->session->userdata('EmployeeId'));
	    $data['RegistrationRoles'] = $this->Employee_model->GetRegistrationRoles($this->session->userdata('EmployeeId'));
	    $data['TransactionRoles'] = $this->Employee_model->GetTransactionRoles($this->session->userdata('EmployeeId'));
	    $data['ReportsRoles'] = $this->Employee_model->GetReportsRoles($this->session->userdata('EmployeeId'));
	   
	    $data['AllProducts'] = $this->Product_model->GetAllProducts($colmun = 'pos_products.ProductId,pos_products.ProductName,pos_productgroup.ProductGroupName,pos_brands.BrandName', $ProductId);
	    $data['AllPurchaseRecord'] = $this->StockReport_model->GetAllPurchaseRecord($StartDate,$EndDate,$ProductId,$ProductGroupId,$BrandId);
	    $data['AllPurchaseReturnRecord'] = $this->StockReport_model->GetAllPurchaseReturnRecord($StartDate,$EndDate,$ProductId,$ProductGroupId,$BrandId);
	    
	    $data['AllSaleRecord'] = $this->StockReport_model->GetAllSaleRecord($StartDate,$EndDate,$ProductId,$ProductGroupId,$BrandId);
	    $data['AllSaleReturnRecord'] = $this->StockReport_model->GetAllSaleReturnRecord($StartDate,$EndDate,$ProductId,$ProductGroupId,$BrandId);
	    

		$data['GetSettingInformation'] = $this->Employee_model->GetSettingInformation();
		$data['CustomerNotification'] = $this->Customer_model->GetNotifications();
	    $this->load->view('report/export/stockreports/exportexcel_stockquantity_report', $data);
	}
	
	
		public function ExportExcelStockBalanceReport()
	{	       
	    $ProductId = $this->input->get('ProductId');
	    $BrandId = $this->input->get('BrandId');
	    $ProductGroupId = $this->input->get('ProductGroupId');
	    $StartDate =date('Y-m-d', strtotime($this->input->get('StartDate')));
	    $EndDate =date('Y-m-d', strtotime($this->input->get('EndDate')));

	    $data['AdministrationRoles'] = $this->Employee_model->GetAdministrationRoles($this->session->userdata('EmployeeId'));
	    $data['SalesRoles'] = $this->Employee_model->GetSalesRoles($this->session->userdata('EmployeeId'));
	    $data['PurchasesRoles'] = $this->Employee_model->GetPurchasesRoles($this->session->userdata('EmployeeId'));
	    $data['RegistrationRoles'] = $this->Employee_model->GetRegistrationRoles($this->session->userdata('EmployeeId'));
	    $data['TransactionRoles'] = $this->Employee_model->GetTransactionRoles($this->session->userdata('EmployeeId'));
	    $data['ReportsRoles'] = $this->Employee_model->GetReportsRoles($this->session->userdata('EmployeeId'));
	   
	    $data['AllProducts'] = $this->Product_model->GetAllProducts($colmun = 'pos_products.ProductId,pos_products.ProductName,pos_productgroup.ProductGroupName,pos_brands.BrandName', $ProductId);
	    $data['AllPurchaseRecord'] = $this->StockReport_model->GetAllPurchaseRecord($StartDate,$EndDate,$ProductId,$ProductGroupId,$BrandId);
	    $data['AllPurchaseReturnRecord'] = $this->StockReport_model->GetAllPurchaseReturnRecord($StartDate,$EndDate,$ProductId,$ProductGroupId,$BrandId);
	    
	    $data['AllSaleRecord'] = $this->StockReport_model->GetAllSaleRecord($StartDate,$EndDate,$ProductId,$ProductGroupId,$BrandId);
	    $data['AllSaleReturnRecord'] = $this->StockReport_model->GetAllSaleReturnRecord($StartDate,$EndDate,$ProductId,$ProductGroupId,$BrandId);

		$data['GetSettingInformation'] = $this->Employee_model->GetSettingInformation();	    
        $data['CustomerNotification'] = $this->Customer_model->GetNotifications();
	    $this->load->view('report/export/stockreports/exportexcel_stockbalance_report', $data);
	}



    public function ExportExcelStockStatusReport()
    { 
        $LocationId = $this->input->get('LocationId');
        $ProductId = $this->input->get('ProductId');
        $EDate = $this->input->get('EndDate');

        $UptoDate = date("Y-m-d", strtotime($EDate));

        $data['AdministrationRoles'] = $this->Employee_model->GetAdministrationRoles($this->session->userdata('EmployeeId'));
        $data['SalesRoles'] = $this->Employee_model->GetSalesRoles($this->session->userdata('EmployeeId'));
        $data['PurchasesRoles'] = $this->Employee_model->GetPurchasesRoles($this->session->userdata('EmployeeId'));
        $data['RegistrationRoles'] = $this->Employee_model->GetRegistrationRoles($this->session->userdata('EmployeeId'));
        $data['TransactionRoles'] = $this->Employee_model->GetTransactionRoles($this->session->userdata('EmployeeId'));
        $data['ReportsRoles'] = $this->Employee_model->GetReportsRoles($this->session->userdata('EmployeeId'));
	
	$data['AllProducts'] = $this->Product_model->GetAllProducts('pos_products.ProductId, pos_products.ProductName',$ProductId);
	$data['AllLocations'] = $this->Location_model->GetAllLocation($LocationId);
	$data['AllColours'] = $this->Colour_model->GetAllColours($LocationId);
	
	$data['ProductWiseStock'] = $this->ProductReport_model->GetProductStocks($UptoDate,$ProductId);
	$data['ColourWiseStock'] = $this->ProductReport_model->GetColourStocks($UptoDate,$ProductId);
	
	
	if($LocationId == 0)
	{ $data['ProductsTransferFrom'] = $this->ProductReport_model->GetProductTransferRecord($UptoDate,$LocationId,$ProductId); }
	else { $data['ProductsTransferFrom'] = $this->ProductReport_model->GetProductTransferFromRecord($UptoDate,$LocationId,$ProductId); }
	
	
	$data['ProductsTransfer'] = $this->ProductReport_model->GetProductTransferRecord($UptoDate,$LocationId,$ProductId);
	
	$data['LocationWiseStockPurchase'] = $this->ProductReport_model->GetLocationWiseStockPurchase($UptoDate,$LocationId,$ProductId);
	$data['LocationWiseStockPurchaseReturn'] = $this->ProductReport_model->GetLocationWiseStockPurchaseReturn($UptoDate,$LocationId,$ProductId);
	
	$data['LocationWiseStockSale'] = $this->ProductReport_model->GetLocationWiseStockSale($UptoDate,$LocationId,$ProductId);
	$data['LocationWiseStockSaleReturn'] = $this->ProductReport_model->GetLocationWiseStockSaleReturn($UptoDate,$LocationId,$ProductId);

	$data['GetSettingInformation'] = $this->Employee_model->GetSettingInformation();	
	$data['CustomerNotification'] = $this->Customer_model->GetNotifications();

	$this->load->view('report/export/stockreports/exportexcel_stockstatus_report',$data);
    }


	public function ExportExcelStockTransferReport()
    {
	    $LocationId = $this->input->get('LocationId');
	    $ProductId = $this->input->get('ProductId');
	    $ColourId = $this->input->get('ColourId');
	    $EmployeeId = $this->input->get('EmployeeId');
	    $StartDate = $this->input->get('StartDate');
	    $EndDate = $this->input->get('EndDate');

	    $data['AdministrationRoles'] = $this->Employee_model->GetAdministrationRoles($this->session->userdata('EmployeeId'));
	    $data['SalesRoles'] = $this->Employee_model->GetSalesRoles($this->session->userdata('EmployeeId'));
	    $data['PurchasesRoles'] = $this->Employee_model->GetPurchasesRoles($this->session->userdata('EmployeeId'));
	    $data['RegistrationRoles'] = $this->Employee_model->GetRegistrationRoles($this->session->userdata('EmployeeId'));
	    $data['TransactionRoles'] = $this->Employee_model->GetTransactionRoles($this->session->userdata('EmployeeId'));
	    $data['ReportsRoles'] = $this->Employee_model->GetReportsRoles($this->session->userdata('EmployeeId'));
	   
	    $data['AllStockLocationFrom'] = $this->StockReport_model->AllStockLocationFrom($LocationId);
	    $data['AllStockTransferRecord'] = $this->StockReport_model->AllStockTransferRecord($LocationId,$ProductId,$ColourId,$EmployeeId,$StartDate,$EndDate);
		$data['GetSettingInformation'] = $this->Employee_model->GetSettingInformation();
		$data['CustomerNotification'] = $this->Customer_model->GetNotifications();
	$this->load->view('report/export/stockreports/exportexcel_stocktransfer_report',$data);
    }


	public function ExportExcelStockDetailWithPriceReport()
	{
	    $ProductId = $this->input->get('ProductId');
	    $BrandId = $this->input->get('BrandId');
	    $ProductGroupId = $this->input->get('ProductGroupId');
	    $StartDate =date('Y-m-d', strtotime($this->input->get('StartDate')));
	    $EndDate =date('Y-m-d', strtotime($this->input->get('EndDate')));
		
	    $SalePrice = $this->input->get('SalePrice');
	    $PurchasePrice = $this->input->get('1PurchasePrice');
	    $FinalPrice = $this->input->get('FinalPrice');
	    $Specifications = $this->input->get('Specifications');

	    $data['AdministrationRoles'] = $this->Employee_model->GetAdministrationRoles($this->session->userdata('EmployeeId'));
	    $data['SalesRoles'] = $this->Employee_model->GetSalesRoles($this->session->userdata('EmployeeId'));
	    $data['PurchasesRoles'] = $this->Employee_model->GetPurchasesRoles($this->session->userdata('EmployeeId'));
	    $data['RegistrationRoles'] = $this->Employee_model->GetRegistrationRoles($this->session->userdata('EmployeeId'));
	    $data['TransactionRoles'] = $this->Employee_model->GetTransactionRoles($this->session->userdata('EmployeeId'));
	    $data['ReportsRoles'] = $this->Employee_model->GetReportsRoles($this->session->userdata('EmployeeId'));
	   
	    $data['AllProducts'] = $this->Product_model->GetAllProducts($colmun = 'pos_products.ProductId,pos_products.ProductName,pos_productgroup.ProductGroupName,pos_brands.BrandName', $ProductId);
	    $data['AllPurchaseRecord'] = $this->StockReport_model->GetAllPurchaseRecord($StartDate,$EndDate,$ProductId,$ProductGroupId,$BrandId);
	    $data['AllPurchaseReturnRecord'] = $this->StockReport_model->GetAllPurchaseReturnRecord($StartDate,$EndDate,$ProductId,$ProductGroupId,$BrandId);
	    
	    $data['AllSaleRecord'] = $this->StockReport_model->GetAllSaleRecord($StartDate,$EndDate,$ProductId,$ProductGroupId,$BrandId);
	    $data['AllSaleReturnRecord'] = $this->StockReport_model->GetAllSaleReturnRecord($StartDate,$EndDate,$ProductId,$ProductGroupId,$BrandId);

		$data['GetSettingInformation'] = $this->Employee_model->GetSettingInformation();	
		$data['CustomerNotification'] = $this->Customer_model->GetNotifications();

	    $this->load->view('report/export/stockreports/exportexcel_availableprouductprice_report', $data);
	}


    public function ExportExcelProductReport()
    {
	    $ProductId = $this->input->get('ProductId');
	    $BrandId = $this->input->get('BrandId');
	    $ProductGroupId = $this->input->get('ProductGroupId');

	    $data['GetSettingInformation'] = $this->Employee_model->GetSettingInformation();
	    $data['GetProductReport'] = $this->ProductReport_model->GetProductReport($ProductId,$BrandId,$ProductGroupId);
	    $data['CustomerNotification'] = $this->Customer_model->GetNotifications();
	    $this->load->view('report/export/stockreports/exportexcel_product_report',$data);
    }



}