<?php defined('BASEPATH') OR exit('No direct script access allowed');

class SalesOrder extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->check_isvalidated();
		
		$this->load->model('Company_model');
		$this->load->model('Customer_model');
		$this->load->model('Product_model');
		$this->load->model('Salesorder_model');
		$this->load->helper('url');
        $this->load->model('Invoice_model');
        $this->load->model('Employee_model');
		$this->load->model('Reference_model');
             //  $this->output->enable_profiler();
                
		// Loading multiple models at same time
		//$this->load->model(array('employee_model','office_model'));
	     }
	
	private function check_isvalidated()
	{
		if(!$this->session->userdata('UserId'))
		{  $this->session->set_userdata('url',  current_url()); redirect('Login'); }
	}
	
        
        public function index()
	{
            $data['Roles'] = $this->Employee_model->GetRoles();
	    $data['AdministrationRoles'] = $this->Employee_model->GetAdministrationRoles($this->session->userdata('UserId'));
            $data['SalesRoles'] = $this->Employee_model->GetSalesRoles($this->session->userdata('UserId'));
            $data['PurchasesRoles'] = $this->Employee_model->GetPurchasesRoles($this->session->userdata('UserId'));
            $data['AccountsRoles'] = $this->Employee_model->GetAccountsRoles($this->session->userdata('UserId'));
            $data['ReportsRoles'] = $this->Employee_model->GetReportsRoles($this->session->userdata('UserId'));
            $data['CustomerNotification'] = $this->Customer_model->GetNotifications();
            $this->load->view('salesorder/salesorders',$data);
	}
        
        
        public function Ajax_GetAllSalesOrders()
        {
               $SalesOrders=$this->Salesorder_model->Ajax_GetAllSalesOrders($_REQUEST);
               $data = array();
               foreach($SalesOrders['record'] as $row)
               {    
                  $nestedData=array(); 
                  $nestedData[] = '<span style=color:#3333CC;>'.$row["OrderNo"].'</span>';
                  $nestedData[] = '<span style="font-size:13px;">'.date('M d, Y', strtotime($row["OrderDate"])).'</span>';
                  $nestedData[] = $row["CustomerName"].'</span>';
                  $nestedData[] = $row["CompanyName"].'</span>';
                  if($row['SalesOrderStatus']=='1')
                  { $Status = '<span style="width:60px; font-size:11px; height:18px; padding:4px; float:left;" class="label label-warning">Draft</span>'; }
                  if($row['SalesOrderStatus']=='2')
                  { $Status = '<span style="width:60px; font-size:11px; height:18px; padding:4px; float:left;" class="label label-success">Confirmed</span>'; }
                  $nestedData[] = '<span style="font-size:13px;">'.$Status.'</span>'; 
                  $nestedData[] = $row["OrderNetAmount"];
                   
                  $id = $row['SalesOrderId'];
                   
                  $Invoice = $this->Invoice_model->GetInvoiceOfSalesOrderId($id);
                  $nestedData[] = count($Invoice);
                  $nestedData[] = '<a href="'.base_url().'SalesOrder/ViewSalesOrder/'.$id.'"title="View Record"><span style="color:#00a65a;" class="glyphicon glyphicon-th-large"></span></a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="'.base_url().'SalesOrder/EditSalesOrder/'.$id.'"title="Update Record"><span style="color:#0c6aad;" class="fa fa-edit"></span></a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="ViewCancelSalesOrder/'.$id.'" title="Cancel Order"><span class="fa fa-times bg-orange"></span></a>';
                
                  $data[] = $nestedData;
               }
                  $json_data = array(
                  "draw"            => intval( $_REQUEST['draw'] ),   // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw. 
                  "recordsTotal"    => intval( $SalesOrders['recordsTotal'] ),  // total number of records
                 "recordsFiltered" => intval( $SalesOrders['recordsFiltered'] ), // total number of records after searching, if there is no searching then totalFiltered = totalData
                 "data"            => $data   // total data array
                 );
                echo json_encode($json_data);
         } 
        
        

	public function ShowReport()
	{
 	   $this->input->get('sd');
 	   $EDate =	date('Y-m-d', strtotime($this->input->get('EndDate')));
	   $data['ShowProducts'] = $this->Product_model->GetProductByDate($EDate);	
	   $data['CustomerNotification'] = $this->Customer_model->GetNotifications();
	   $this->load->view('report/product_report',$data);
	}
	
	public function ShowProductsOnBlur()
        {
	
	    $ProductName = $this->input->post('ProductName');
	    if($ProductName!="") {
	    $ShowProducts = $this->Product_model->GetProductByBrandName($ProductName);	
            $SNo=1;		
            $Amount = 0;
            $Quantity = 1;
                $CartTable ="<fieldset>";	
                $CartTable .="<table class='table table-bordered text-center'>";
                $CartTable .="<tr style='background-color:#ECF9FF;'>";
                $CartTable .="<th style='padding:5px;'><input type='checkbox' checked='checked' name='parent' id='parent' class='parentCheckBox'></th>";
                $CartTable .="<th style='padding:5px;'>Brand Name</th>";
                $CartTable .="<th style='padding:5px;'>Group Name</th>";
                $CartTable .="<th style='padding:5px;'>Rate</th>";
                $CartTable .="<th style='padding:5px;'>Quantity</th>";
                $CartTable .="<th style='padding:5px;'>R Price</th>";
                $CartTable .="<th style='padding:5px;'>T Price</th>";
                $CartTable .="</tr>";
		
		foreach($ShowProducts as $row)
	    {
		  $CartTable .="<tr>";
		 // $CartTable .="<tr class='txtMult'>";
		  $CartTable .="<td style='padding:5px; width:2%;'><input type='checkbox' checked='checked' name='ProductIdCheck[]' class='ProductIdCheck' value='".$row['ProductId']."'/></td>";
		  $CartTable .="<td style='padding:5px; width:10%;'>".$row['BrandName']."</td>";
		  $CartTable .="<td style='padding:5px; width:10%;'>".$row['ProductGroupName']."</td>";
		  $CartTable .="<td style='padding:5px; width:10%;'>".$row['NetRate']."</td>";
		  $CartTable .="<td style='padding:5px; width:10%;'>".$Quantity."</td>";
		  $CartTable .="<td style='padding:5px; width:10%;'>".$row['RetailPrice']."</td>";
		  $CartTable .="<td style='padding:5px; width:10%;'>".$row['TradePrice']."</td>";
		  $CartTable .="</tr>";
		  $SNo++;
	    }
		  $CartTable .="<tr>";
		  $CartTable .="<td colspan='7' style='text-align:left'><button class='btn btn-primary btn-success' id='AddItems'>Add Item</button></td>";
		  $CartTable .="</tr>";		
		  $CartTable .="</table>";
		  $CartTable .="</fieldset>";
		  print $CartTable;
	  }
	}
    public function ShowProducts()
    {
	    $GroupId = $this->input->post('ProductGroupId');
		if($GroupId!="") {
               
               $ShowProducts = $this->Salesorder_model->GetProductsList($GroupId);	
		$SNo=1;		
		$Amount = 0;
		$Quantity = 1;
		$CartTable ="<fieldset>";	
		$CartTable .="<table class='table table-bordered text-center'>";
                $CartTable .="<tr style='background-color:#ECF9FF;'>";
                $CartTable .="<th style='padding:5px;'><input type='checkbox' checked='checked' name='parent' id='parent' class='parentCheckBox'></th>";
                $CartTable .="<th style='padding:5px;'>Group Name</th>";
                $CartTable .="<th style='padding:5px;'>Brand Name</th>";
                $CartTable .="<th style='padding:5px;'>Quantity</th>";
                $CartTable .="<th style='padding:5px;'>Rate</th>";
                $CartTable .="<th style='padding:5px;'>R Price</th>";
                $CartTable .="<th style='padding:5px;'>T Price</th>";
                $CartTable .="</tr>";
		
		foreach($ShowProducts as $row)
                {
		  $CartTable .="<tr>";
		  $CartTable .="<td style='padding:5px; width:2%;'><input type='checkbox' checked='checked' name='ProductIdCheck[]' class='ProductIdCheck' value='".$row->ProductId."'/></td>";
		  $CartTable .="<td style='padding:5px; width:10%;'>".$row->ProductGroupName."</td>";
		  $CartTable .="<td style='padding:5px; width:10%;'>".$row->BrandName."</td>";
                  $CartTable .="<td style='padding:5px; width:10%;'>".$Quantity."</td>";
		  $CartTable .="<td style='padding:5px; width:10%;'>".$row->NetRate."</td>";
                  $CartTable .="<td style='padding:5px; width:10%;'>".$row->RetailPrice."</td>";
		  $CartTable .="<td style='padding:5px; width:10%;'>".$row->TradePrice."</td>";
		  $CartTable .="</tr>";
		  $SNo++;
                }
		  $CartTable .="<tr>";
		  $CartTable .="<td colspan='7' style='text-align:left'><button class='btn btn-primary btn-success' id='AddItems'>Add Item</button></td>";
        	  $CartTable .="</tr>";		
		  $CartTable .="</table>";
		  $CartTable .="</fieldset>";
		
		  print $CartTable;
	  }
	}
        
        
	public function AddOrderItems() 
	{
         $ProductIds = $this->input->post('ProductIdCheckBoxes');
	 
         // Stop process If no product item is selected 
         if(isset($ProductIds))
         {
            foreach($ProductIds as $ProductId) 
            { if($ProductId!='') { $this->Salesorder_model->AddCartItem($ProductId); }}
         }
         
	if($this->session->userdata('UserId')!="") {
	$AllCartItems = $this->Salesorder_model->GetCartItem($this->session->userdata('UserId'));

        $SNo=1;		
        $Amount = 0;
        $TotalQuantity = 1;
        $TotalAmount = 0;
        
        $CartTable ="<table class='table table-bordered text-center' id='delTable'>";
        $CartTable .="<tr style='background-color:#ECF9FF;'>";
        $CartTable .="<th style='padding:5px;'>S.No</th>";
        $CartTable .="<th style='padding:5px;'>Order Cancel</th>";
        $CartTable .="<th style='padding:5px;'>Group Name</th>";
        $CartTable .="<th style='padding:5px;'>Brand Name</th>";        
        $CartTable .="<th style='padding:5px;'>Qty</th>";
        $CartTable .="<th style='padding:5px;'>UoM</th>";
        $CartTable .="<th style='padding:5px;'>Rate</th>";
        $CartTable .="<th style='padding:5px;'>Dis %</th>";
        $CartTable .="<th style='padding:5px;'>D.Amt</th>";
        $CartTable .="<th style='padding:5px;'>Amount</th>";
        $CartTable .="<th style='padding:5px;'>R Price</th>";
        $CartTable .="<th style='padding:5px;'>T Price</th>";
        $CartTable .="</tr>";
		 
	foreach($AllCartItems as $row)
	{
            $CartTable .="<tr class='txtMult'>";
            $CartTable .='<td style="padding:5px;"><input type="checkbox" name="CheckValue" checked="checked" onclick="document.getElementById('."'Packing".$SNo."'".').disabled=!this.checked; document.getElementById('."'Rate".$SNo."'".').disabled=!this.checked; document.getElementById('."'Discount".$SNo."'".').disabled=!this.checked;"/></td>';
            $CartTable .='<td style="padding:5px;"><a href="#" class="delete" style="color:#FF0000;"><img alt="" align="middle" border="0" src="'.base_url().'lib/img/icon_del.gif" /></a></td>';
            $CartTable .="<td style='padding:5px;'><input type='hidden' name='hdnProductGroupId[]' value='".$row->ProductGroupId."'>".$row->ProductGroupName."</td>";
            $CartTable .="<td style='padding:5px;'><input type='hidden' name='hdnProductId[]' value='".$row->ProductId."'>".$row->BrandName."</td>";
            $CartTable .="<td style='padding:5px;'><input type='number' style='width:100%;' name='Packing[]' class='Packing' id='Packing".$SNo."' value='".$TotalQuantity."'></td>";
            $CartTable .="<td style='padding:5px;'>"
            . "<select name='UoM[]' style='width:100%; font-size:14px; height:26px;'>"
            . "<option selected='selected' value='0'> Select PKTS </option>"
            . "<option value='1000'>1000 Units PKTS</option>"
            . "<option value='200'>200 Units PKTS</option>"
            . "<option value='100'>100 Units PKTS</option>"
            . "<option value='50'>50 Units PKTS</option>"
            . "<option value='30'>30 Units PKTS</option>"
            . "<option value='20'>20 Units PKTS</option>"
            . "<option value='14'>14 Units PKTS</option>"
            . "<option value='12'>12 Units PKTS</option>"
            . "<option value='10'>10 Units PKTS</option>"
            . "<option value='7'>7 Units PKTS</option>"
            . "<option value='6'>6 Units PKTS</option>"
            . "<option value='5'>5 Units PKTS</option>"
            . "</select></td>";
            $CartTable .="<td style='padding:5px;'><input type='number' step='0.01' style='width:100%;' name='Rate[]' class='Rate' id='Rate".$SNo."' value='".$row->Rate."'></td>";
            $CartTable .="<td style='padding:5px;'><input type='number' style='width:100%;' name='Discount[]' class='Discount' id='Discount".$SNo."' value='0'></td>";
            $CartTable .="<td style='padding:5px;'><input type='text' readonly='readonly' style='width:100%;' name='DiscountAmount[]' class='DiscountAmount' id='DiscountAmount".$SNo."' value='0'></td>";
            $CartTable .="<td style='padding:5px;'><input type='text' readonly='readonly' style='width:100%;' name='Amount[]' class='Amount' id='Amount".$SNo."' value='".$Amount."'></td>";
            $CartTable .="<td style='padding:5px;'><input type='text' style='width:100%;' name='RetailPrice[]' class='RetailPrice' id='RetailPrice".$SNo."' value='".$row->RetailPrice."'></td>";
            $CartTable .="<td style='padding:5px;'><input type='text' style='width:100%;' name='TradePrice[]' class='TradePrice' id='TradePrice".$SNo."' value='".$row->TradePrice."'></td>";
            $CartTable .="</tr>";

            $SNo++;
            //$TotalQuantity += $row["Packing"];
            //$TotalAmount   += $Amount;
            $TotalAmount =0;
      }
		  
	$CartTable .="<tr>";
        $CartTable .="<td colspan='5'></td>";
        //$CartTable .="<td><input style='font-weight:600; text-align:right color:#3333CC; background:transparent; border: none;' type='hidden' readonly='readonly' size='8' name='TotalQuantity' id='TotalQuantity' value='".$TotalQuantity."'/></td>";
        $CartTable .="<td></td>";
        $CartTable .="<td colspan='2' style='text-align:right; font-weight:600;'>Total Amount:</td>";
        $CartTable .="<td><input style='font-weight:600; color:#3333CC; background:transparent; border:none;' type='text' readonly='readonly' size='8' name='OrderAmount' id='OrderAmount' value='".$TotalAmount."'/></td>";
        $CartTable .="<td></td>";
        $CartTable .="<td></td>";
        $CartTable .="</tr>";
	$CartTable .="<tr>";
        $CartTable .="<td colspan='8' style='text-align:right; font-weight:600;'>Less Discount Amount:</td>";
        $CartTable .="<td><input style='font-weight:600; color:#800000; background:transparent; border:none;' type='text' readonly='readonly' size='8' name='OrderDiscountAmount' id='OrderDiscountAmount' value='0' /></td>";
        $CartTable .="<td></td>";
        $CartTable .="<td></td>";
        $CartTable .="</tr>";
        $CartTable .="<tr>";
        $CartTable .="<td colspan='8' style='text-align:right; font-weight:600;'>Net Amount:</td>";
        $CartTable .="<td style='font-weight:600; color:#008000;'><input style='font-weight:600; color:#008000; background:transparent; border:none;' type='text' readonly='readonly' size='8' name='OrderNetAmount' id='OrderNetAmount' value='".$TotalAmount."' /></td>";
        $CartTable .="<td></td>";
        $CartTable .="<td></td>";
        $CartTable .="</tr>";
	$CartTable .="</table>";
	print $CartTable;
	  }	
	}
	
	public function ViewSalesOrder($SalesOrderId = NULL)
        {
	    $data['Roles'] = $this->Employee_model->GetRoles();
            $data['AdministrationRoles'] = $this->Employee_model->GetAdministrationRoles($this->session->userdata('UserId'));
            $data['SalesRoles'] = $this->Employee_model->GetSalesRoles($this->session->userdata('UserId'));
            $data['PurchasesRoles'] = $this->Employee_model->GetPurchasesRoles($this->session->userdata('UserId'));
            $data['AccountsRoles'] = $this->Employee_model->GetAccountsRoles($this->session->userdata('UserId'));
            $data['ReportsRoles'] = $this->Employee_model->GetReportsRoles($this->session->userdata('UserId'));
            $data['GetSalesOrderView'] = $this->Salesorder_model->GetSalesOrder($SalesOrderId);
            $data['GetSalesOrderDetailView'] = $this->Salesorder_model->GetSalesOrderDetail($SalesOrderId);
            $data['Invoice'] = $this->Invoice_model->GetInvoiceBySalesOrderId($SalesOrderId,0,'pos_invoice_detail.ProductId,pos_invoice_detail.Quantity,pos_invoice_detail.SupplyQuantity');
            $data['CustomerNotification'] = $this->Customer_model->GetNotifications();
            $this->load->view('salesorder/view_salesorder', $data);
        }
        
        
        public function EditSalesOrder($SalesOrderId = NULL)
        {        
	    $data['Roles'] = $this->Employee_model->GetRoles();
	    $data['AdministrationRoles'] = $this->Employee_model->GetAdministrationRoles($this->session->userdata('UserId'));
            $data['SalesRoles'] = $this->Employee_model->GetSalesRoles($this->session->userdata('UserId'));
            $data['PurchasesRoles'] = $this->Employee_model->GetPurchasesRoles($this->session->userdata('UserId'));
            $data['AccountsRoles'] = $this->Employee_model->GetAccountsRoles($this->session->userdata('UserId'));
            $data['ReportsRoles'] = $this->Employee_model->GetReportsRoles($this->session->userdata('UserId'));
            $data['GetSalesOrderView'] = $this->Salesorder_model->GetSalesOrder($SalesOrderId);
            $data['GetSalesOrderDetailView'] = $this->Salesorder_model->GetSalesOrderDetail($SalesOrderId);         
            $data['GetAllCompany'] = $this->Company_model->GetAllCompanies();
            $data['GetAllCustomer']=$this->Customer_model->GetAllCustomers();
            $data['GetAllReferences'] = $this->Reference_model->GetAllReferences();
            $data['Invoice'] = $this->Invoice_model->GetInvoiceBySalesOrderId($SalesOrderId,0,'pos_invoice_detail.ProductId,pos_invoice_detail.Quantity');
            $data['CustomerNotification'] = $this->Customer_model->GetNotifications();
            $this->load->view('salesorder/edit_salesorder', $data);
        }
        
        public function ViewCancelSalesOrder($SalesOrderId = NULL)
        {           
	    $data['Roles'] = $this->Employee_model->GetRoles();
	    $data['AdministrationRoles'] = $this->Employee_model->GetAdministrationRoles($this->session->userdata('UserId'));
            $data['SalesRoles'] = $this->Employee_model->GetSalesRoles($this->session->userdata('UserId'));
            $data['PurchasesRoles'] = $this->Employee_model->GetPurchasesRoles($this->session->userdata('UserId'));
            $data['AccountsRoles'] = $this->Employee_model->GetAccountsRoles($this->session->userdata('UserId'));
            $data['ReportsRoles'] = $this->Employee_model->GetReportsRoles($this->session->userdata('UserId'));
            $data['GetSalesOrderView'] = $this->Salesorder_model->GetSalesOrder($SalesOrderId);
            $data['GetSalesOrderDetailView'] = $this->Salesorder_model->GetSalesOrderDetail($SalesOrderId);         
            $data['GetAllCompany'] = $this->Company_model->GetAllCompanies();
            $data['GetAllCustomer']=$this->Customer_model->GetAllCustomers();
            $data['GetAllReferences'] = $this->Reference_model->GetAllReferences();
            $data['Invoice'] = $this->Invoice_model->GetInvoiceBySalesOrderId($SalesOrderId,0,'pos_invoice_detail.ProductId,pos_invoice_detail.Quantity,pos_invoice_detail.SupplyQuantity');
            $data['CustomerNotification'] = $this->Customer_model->GetNotifications();
            $this->load->view('salesorder/cancel_salesorder', $data);
        }
        
        
        public function CancelSalesOrder()
        {            
           $SalesOrderId = $this->input->post('SalesOrderId');
           $CancelSalesOrder = $this->input->post('CancelSalesOrder');	
             
           if (isset($CancelSalesOrder) || ($CancelSalesOrder == 'CancelOrder')) 
           {
                if($SalesOrderId = $this->Salesorder_model->CancelSalesOrder($SalesOrderId))
                {
                     $this->session->set_flashdata("record_added","Record updated successfully.");
                     redirect("SalesOrder/ViewCancelSalesOrder/".$SalesOrderId);
                }
           }
           else 
           {
               redirect("SalesOrder");
           }
	}
        
        
	public function get_auto_fill_product(){
	
    	if (isset($_GET['term'])){
     	 $q = strtolower($_GET['term']);
      $this->Product_model->get_pos_product($q);
     }
    }
  
  
	public function AddSalesOrder()
	{
                // clear cart
                $this->db->where('AddedBy', $this->session->userdata('UserId'));
                $this->db->delete('pos_salesorder_cart');
                
                $data['Roles'] = $this->Employee_model->GetRoles();
                $data['AdministrationRoles'] = $this->Employee_model->GetAdministrationRoles($this->session->userdata('UserId'));
                $data['SalesRoles'] = $this->Employee_model->GetSalesRoles($this->session->userdata('UserId'));
                $data['PurchasesRoles'] = $this->Employee_model->GetPurchasesRoles($this->session->userdata('UserId'));
                $data['AccountsRoles'] = $this->Employee_model->GetAccountsRoles($this->session->userdata('UserId'));
                $data['ReportsRoles'] = $this->Employee_model->GetReportsRoles($this->session->userdata('UserId'));
                $data['AllReferences'] = $this->Reference_model->GetAllReferences();
                $data['GetAllCompany'] = $this->Company_model->GetAllCompanies();
		$data['GetAllCustomer']=$this->Customer_model->GetAllCustomers();
		$data['ProductGroup'] = $this->Product_model->GetAllProductGroups();
		$data['ShowCartItems'] = $this->Salesorder_model->GetCartItem($this->session->userdata('UserId'));
		$data['CustomerNotification'] = $this->Customer_model->GetNotifications();
		$this->load->view('salesorder/add_salesorder', $data);
	}
	
	public function ShowSalesOrder() {
                $BrandName = $this->input->post('BrandName');
		$formSubmit = $this->input->post('submitForm');
		
                if (isset($formSubmit) || ($formSubmit == 'formSave')) 
                {
		   $this->load->helper('form');
		
                   if($NewSalesOrderId = $this->Salesorder_model->set_salesorder()) 
                   { 
                     $this->session->set_flashdata("record_added","Record added successfully.");
                     redirect("SalesOrder/ViewSalesOrder/$NewSalesOrderId");
                    }
                
		} else {
                // redirect($this->config->item('backend_folder').'/categories/form');
                $ProductGroupId = $this->security->xss_clean($this->input->post('ProductGroup'));
                $this->load->view("includes/header");
                $this->load->view("includes/sidebar");
                $data['GetAllCompany'] = $this->Company_model->GetAllCompanies();
                $data['GetAllCustomer']=$this->Customer_model->GetAllCustomers();
                $data['ProductGroup'] = $this->Product_model->GetAllProductGroups();
                $data['CustomerNotification'] = $this->Customer_model->GetNotifications();
                //$data['AllProductByGroup'] = $this->product_model->GetAllProductsByGroupId($ProductGroupId);
                $this->load->view('salesorder/add_salesorder', $data);
                $this->load->view("includes/footer");		
		   }
	}
	
        
     public function UpdateSalesOrder()
     {            
        $SalesOrderId = $this->input->post('SalesOrderId');
        $formSubmit = $this->input->post('submitForm');	
        //$OrderDate = $this->security->xss_clean($this->input->post('OrderDate'));                
        if (isset($formSubmit) || ($formSubmit == 'formSave')) 
         {
            if($NewSalesOrderId = $this->Salesorder_model->set_salesorder($SalesOrderId)) 
             { 
                 $this->session->set_flashdata("record_added","Record added successfully.");
                 redirect("SalesOrder/ViewSalesOrder/$NewSalesOrderId");
             }
         }
                 // redirect($this->config->item('backend_folder').'/categories/form');
         else 
         {
             $ProductGroupId = $this->security->xss_clean($this->input->post('ProductGroup'));
             $this->load->view("includes/header");
             $this->load->view("includes/sidebar");
             $data['GetAllCompany'] = $this->Company_model->GetAllCompanies();
             $data['GetAllCustomer']=$this->Customer_model->GetAllCustomers();
             $data['ProductGroup'] = $this->Product_model->GetAllProductGroups();
             $data['CustomerNotification'] = $this->Customer_model->GetNotifications();
             //$data['AllProductByGroup'] = $this->product_model->GetAllProductsByGroupId($ProductGroupId);
             $this->load->view('salesorder/add_salesorder', $data);
             $this->load->view("includes/footer");		
         }
     }
	
	
	public function Delete()
    {
      $SalesOrderId = $this->uri->segment(3);
        
        if (empty($SalesOrderId))
        {
            show_404();
        }
         
		// Following method confirm sales order record existance in table       
        $salesorder_item = $this->Salesorder_model->GetRecordById($SalesOrderId);
		
		// Following method delete records from sales order table        
        $this->Salesorder_model->DeleteSalesOrder($SalesOrderId);
		$this->session->set_flashdata("record_delete","Record removed successfully.");         
        redirect( base_url() . 'SalesOrder/');        
    }
	
	
/*	function upload_file() {
 
        //upload file
        $config['upload_path'] = 'uploads/';
        $config['allowed_types'] = '*';
        $config['max_filename'] = '255';
        $config['encrypt_name'] = TRUE;
        $config['max_size'] = '1024'; //1 MB
 
        if (isset($_FILES['file']['name'])) {
            if (0 < $_FILES['file']['error']) {
                echo 'Error during file upload' . $_FILES['file']['error'];
            } else {
                if (file_exists('uploads/' . $_FILES['file']['name'])) {
                    echo 'File already exists : uploads/' . $_FILES['file']['name'];
                } else {
                    $this->load->library('upload', $config);
                    if (!$this->upload->do_upload('file')) {
                        echo $this->upload->display_errors();
                    } else {
                        echo 'File successfully uploaded : uploads/' . $_FILES['file']['name'];
                    }
                }
            }
        } else {
            echo 'Please choose a file';
        }
    }*/
	
	
	public function InvoiceHistory() {
	die("Invoice History Detail Goes Here");
	}

	
	public function AutoCompleteSearch_GroupName() 
        {  
	  $GroupName = $this->input->post('GroupName');
          $ProductGroupNames = array();
          
	  $query = $this->db->query("SELECT ProductGroupId,ProductGroupName FROM pos_productgroup WHERE ProductGroupName LIKE '%{$GroupName}%' LIMIT 10");
	  foreach ($query->result_array() as $key) 
          {
            $ArrayVal = array(
            'id' => trim($key['ProductGroupId']),
            'value' => trim($key['ProductGroupName'])
            );
	    $ProductGroupNames[] = $ArrayVal;
          }
           echo json_encode($ProductGroupNames);
	}
        
        
        public function AutoCompleteSearch_BrandName() {
	  
	  $BrandName = $this->input->post('BrandName');
         
	  $query = $this->db->query("SELECT ProductId,BrandName FROM pos_product WHERE BrandName LIKE '%{$BrandName}%' LIMIT 10");
	  $BrandNames = array();

		foreach ($query->result_array() as $key) {
			$bn = array(
				'id' => trim($key['ProductId']),
			//	'label' => trim($key['BrandName']),
				'value' => trim($key['BrandName'])
			);
		    $BrandNames[] = $bn;
			}

		echo json_encode($BrandNames);
	}
        
       
    public function GenerateSalesOrderNo()
    {
      $query = $this->db->query("SELECT OrderNo FROM pos_salesorder ORDER BY SalesOrderId DESC limit 1");
      if ($query->num_rows() > 0)
      {
           $row = $query->row();
           $SalesOrderNo = $row->OrderNo;
           
           $iSplit = explode("-", $SalesOrderNo);
           $data['SalesOrderNo'] = $iSplit[0];
           $SalesOrderNo = $data['SalesOrderNo'];
           
           $SalesOrderNo = $SalesOrderNo + 1;
           $CurrentYear =  17; //date("y",time());
           $NextYear = $CurrentYear +1;
           $ActualSalesOrderNo = "$SalesOrderNo-$CurrentYear-$NextYear";
           echo $ActualSalesOrderNo;
      }
    }    
 }
?>