<?php defined('BASEPATH') OR exit('No direct script access allowed');

class GeneralJournal extends CI_Controller {

	public function __construct()
	 {
		parent::__construct();
		$this->check_isvalidated();
		$this->load->model('GeneralJournal_model');
    $this->load->model('COA_model');
    $this->load->model('Employee_model');
    $this->load->model('Customer_model');
    $this->load->model('Vendor_model');
     $this->load->model('Sale_model');
     $this->load->model('Saleman_model');
    }
	
	private function check_isvalidated()
	{
		if(!$this->session->userdata('EmployeeId'))
		{ $this->session->set_userdata('url',  current_url());  redirect('Login'); }
	}
	public function index()
	{
      $data['Roles'] = $this->Employee_model->GetRoles();
      $data['AdministrationRoles'] = $this->Employee_model->GetAdministrationRoles($this->session->userdata('EmployeeId'));
      $data['SalesRoles'] = $this->Employee_model->GetSalesRoles($this->session->userdata('EmployeeId'));
      $data['PurchasesRoles'] = $this->Employee_model->GetPurchasesRoles($this->session->userdata('EmployeeId'));
      $data['RegistrationRoles'] = $this->Employee_model->GetRegistrationRoles($this->session->userdata('EmployeeId'));
      $data['TransactionRoles'] = $this->Employee_model->GetTransactionRoles($this->session->userdata('EmployeeId'));
      $data['ReportsRoles'] = $this->Employee_model->GetReportsRoles($this->session->userdata('EmployeeId'));    

      $data['GetAllGeneralJournal']=$this->GeneralJournal_model->GetAllGeneralJournal('GeneralJournalId');
      $data['CustomerNotification'] = $this->Customer_model->GetNotifications();
      $this->load->view('generaljournal/generaljournal',$data);

  }
        
        
  public function Ajax_GetAllGeneralJournal()
	{
      $RegistrationRoles = $this->Employee_model->GetRegistrationRoles($this->session->userdata('EmployeeId'));
      $GetAllGeneralJournal=$this->GeneralJournal_model->Ajax_GetAllGeneralJournal($_REQUEST);
            
	    // Employee Role For Record Update
//	    $AccountsRoles = $this->Employee_model->GetAccountsRoles($this->session->userdata('EmployeeId'));
	    $ViewRecord = '<span style="color:#00a65a;" class="glyphicon glyphicon-th-large"></span>';
	    
	//    if ($AccountsRoles[0]['UpdateRoles']==1){
       $UpdateRecord = '<span style="color:#0c6aad;" class="ace-icon fa fa-edit">'; 
       $PrintRecord = '<span style="color:#0c6aad;" class="ace-icon fa fa-print">'; 
       //}
//	    else{ 
//       $UpdateRecord = ''; 
       //}
	    
	    
	    $data = array();
             
                //$GetAllGeneralJournal = array_filter($GetAllGeneralJournal);
                 foreach($GetAllGeneralJournal['record'] as $row)
                {    
                    $nestedData=array(); 
                    $nestedData[] = date('M d, Y', strtotime($row["TransactionDate"]));
                    $nestedData[] = $row["Reference"];
                    $nestedData[] = $row["EntryType"] == '1' ? '<span class="text-green">Auto Voucher</span>' : '<span class="text-red">Manual</span>';
//                    $nestedData[] = $row["VoucherType"];
                    $nestedData[] = $row["TotalDebit"];
                    $id = $row["GeneralJournalId"];
                    $EntryType = $row["EntryType"];
		            if($EntryType == 1){
                      $nestedData[] = '<a href="'.base_url().'GeneralJournal/ViewGeneralJournal/'.$id.'" title="View Record">'.$ViewRecord.'</a>';
                    }
                    else{
                      $nestedData[] = '<a href="'.base_url().'GeneralJournal/ViewGeneralJournal/'.$id.'" title="View Record">'.$ViewRecord.'</a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="'.base_url().'GeneralJournal/EditGeneralJournal/'.$id.'"title="Update Record"><span style="color:#0c6aad;" class="fa fa-edit"></span></a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="'.base_url().'AccountReports/GenerateVoucherReport?GeneralJournalId='.$id.'&ReferencePrefix=CRV" title="Print Record">'.$PrintRecord.'</a>';
                    }
                    $data[] = $nestedData;
                }
                $json_data = array(
                 "draw"            => intval( $_REQUEST['draw'] ),   // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw. 
                 "recordsTotal"    => intval( $GetAllGeneralJournal['recordsTotal'] ),  // total number of records
                 "recordsFiltered" => intval( $GetAllGeneralJournal['recordsFiltered'] ), // total number of records after searching, if there is no searching then totalFiltered = totalData
                 "data"            => $data   // total data array
                );
                echo json_encode($json_data);  // send data as json format
        }
        
        public function AutoCompleteSearch_COA()
        {
	          $ChartOfAccount = $this->input->post('term');
            $query = $this->db->query
                ("SELECT 
                  COA.ChartOfAccountCode AS ChartOfAccountCode,
                  COA.ChartOfAccountTitle AS ChartOfAccountTitle,
                  COA.ChartOfAccountId AS ChartOfAccountId
                  FROM pos_accounts_chartofaccount AS COA
                  WHERE COA.ChartOfAccountControlId != 17 AND COA.ChartOfAccountTitle LIKE '%{$ChartOfAccount}%' ");

		        $ChartOfAccount = array();
		
          	foreach ($query->result_array() as $key) {
                        $BankAbbr = '';
			
/*                        if($key['BankAbbreviation'] != '' || $key['BankAbbreviation'] != null )
                        $BankAbbr = '-'.$key['BankAbbreviation'];*/
			
                        $bn = array(
                  			'id' => trim($key['ChartOfAccountId']),
                        'value' => trim($key['ChartOfAccountCode'].'-'.$key['ChartOfAccountTitle'].$BankAbbr)
			                  );
			
		$ChartOfAccount[] = $bn;
		}
                        
		echo json_encode($ChartOfAccount);
        }
        
        public function GetAllPayee()
        {
           $PayeeValue = $this->input->post('payee');
            $query = $this->db->query
            ("SELECT 
            SalemanId,
            SalemanName,
            ChartOfAccountId
            FROM pos_saleman
            WHERE SalemanName LIKE '%{$PayeeValue}%' LIMIT 10");

            $PayeeValues = array();
            foreach ($query->result_array() as $key)
            {

                $bn = array('id' => trim($key['ChartOfAccountId']), 'value' => trim($key['SalemanName']));
                $PayeeValues[] = $bn;
            }
                echo json_encode($PayeeValues);   
        }
        
        // public function GetAllPayee()
        // {
        //    $PayeeValue = $this->input->post('payee');
        //     $Value = "";
        //     $query = $this->db->query
        //     ("SELECT 
        //     COA.ChartOfAccountCode AS ChartOfAccountCode,
        //     COA.ChartOfAccountTitle AS ChartOfAccountTitle,
        //     COA.ChartOfAccountId AS ChartOfAccountId,
        //     C.CustomerId AS CustomerId,
        //     V.VendorId AS VendorId,
        //     B.AccountId AS BankAccountId
        //     FROM pos_accounts_chartofaccount AS COA
        //     LEFT JOIN pos_customer AS C ON C.ChartOfAccountId = COA.ChartOfAccountId
        //     LEFT JOIN pos_vendor AS V ON V.ChartOfAccountId = COA.ChartOfAccountId
        //     LEFT JOIN pos_bank_accounts AS B ON B.ChartOfAccountId = COA.ChartOfAccountId
        //     WHERE COA.ChartOfAccountTitle LIKE '%{$PayeeValue}%' OR  ChartOfAccountCode LIKE '%{$PayeeValue}%' LIMIT 10");

        //     $PayeeValues = array();
        //     foreach ($query->result_array() as $key)
        //     {
        //         if($key['CustomerId'] != '' || $key['CustomerId'] != null )
        //         { $Value = $key['ChartOfAccountCode'].'-'.$key['CustomerId']; }
                
        //         if($key['VendorId'] != '' || $key['VendorId'] != null )
        //         { $Value = $key['ChartOfAccountCode'].'-'.$key['VendorId']; }
                
        //         if($key['BankAccountId'] != '' || $key['BankAccountId'] != null )
        //         { $Value = $key['ChartOfAccountCode'].'-'.$key['BankAccountId']; }
                
        //        // else if($key['ChartOfAccountId'] != '' || $key['ChartOfAccountId'] != null)
        //        // { $Value = $key['ChartOfAccountCode'].'-'.$key['ChartOfAccountId']; }

        //         $bn = array('id' => trim($Value), 'value' => trim($key['ChartOfAccountCode'].'-'.$key['ChartOfAccountTitle']));
        //         $PayeeValues[] = $bn;
        //     }
        //         echo json_encode($PayeeValues);   
        // }
        
	
     public function SaveGeneralJournal()
	{
	    $Record = $this->input->post();
        $COA_Array  = array_filter($Record['ChartOfAccount']);
        $NoOfRecord = count($COA_Array);
        
        
        if(isset($Record['submitFormWithSms'])){
            $j = 0;
            $CellNo = null;
            for($i = 0; $i < $NoOfRecord; $i++ ){

                if($j % 2 != 0){
                    $j++;
                    continue;
                }

                $DebitRecord = $this->Sale_model->DebitRecord($Record['ChartOfAccount'][$i]);
                $CreditRecord = $this->Sale_model->CreditRecord($Record['ChartOfAccount'][$i]);
                
                $AccountReceivableAmount = ($DebitRecord->Debit - $CreditRecord->Credit);
                // echo $Record['ChartOfAccount'][$i]."<pre>"."</br>";
                // echo $Record['Credit'][$i]."<pre>"."</br>"; 
                // echo $AccountReceivableAmount."<pre>";

                $getCustomer = $this->Customer_model->GetCustomerId($Record['ChartOfAccount'][$i]);
              
                if(!$getCustomer){ continue; }

                if($getCustomer[0]['CellNo']){
                    $RemoveFirstNum = ltrim($getCustomer[0]['CellNo'], 0);
                    $CellNo = "92".$RemoveFirstNum;
                }           

                date_default_timezone_set("Asia/Karachi");
               
                $DateTime =  date("d/m/Y h:i A", strtotime(date("d/m/Y h:i A")));
                $Balance  = ($AccountReceivableAmount != 0) ? $AccountReceivableAmount - $Record['Credit'][$i] : $AccountReceivableAmount;
                $message  = $getCustomer[0]['CustomerName']." , PKR ".number_format($Record['Credit'][$i], 2)." received M.M Traders on ". date("d/m/Y h:i A")." and your balance is ".$Balance;
               
                $api_key = "923363037047-f2634d66-e7f6-438b-b833-feaffbc4a856";///YOUR API KEY
                $mobile  = $CellNo;///Recepient Mobile Number
                $sender  = "M.M Traders";
                $message = $message;
    
                ////sending sms
                $post = "sender=".urlencode($sender)."&mobile=".urlencode($mobile)."&message=".urlencode($message)."";
                $url  = "https://sendpk.com/api/sms.php?api_key=$api_key";
                $ch   = curl_init();
                $timeout = 30; // set to zero for no timeout
                curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1)');
                curl_setopt($ch, CURLOPT_URL,$url);
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_POSTFIELDS,$post);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
                $result = curl_exec($ch);
                /*Print Responce*/
                //echo $result;
                $j++;
            }
        }

	    $GeneralJournalId = $this->GeneralJournal_model->SaveGeneralJournalDetail($Record);

	    if($GeneralJournalId != '') 
	    {        
		$this->session->set_flashdata('messag_GJ','Information Added sucessfuly..!');
		redirect("GeneralJournal/ViewGeneralJournal/".$GeneralJournalId);
	    }
	    else 
	    {
		redirect("GeneralJournal/");
	    }
	}
	
	
	
	public function UpdateGeneralJournal()
	{
	    $Record = $this->input->post();
	    if($this->input->post('GeneralJournalId') != '')
	    {
		if($GeneralJournalId = $this->GeneralJournal_model->UpdateGeneralJournalDetail($Record,$this->input->post('GeneralJournalId')))
		{
		    $Message = 'Record updated successfully';
		    $this->session->set_flashdata("success_message",$Message);
		    redirect("GeneralJournal/ViewGeneralJournal/".$GeneralJournalId);
		}
	    }

	}
	
        
    public function ViewGeneralJournal($GeneralJournalId)
    {

      $data['Roles'] = $this->Employee_model->GetRoles();
      $data['AdministrationRoles'] = $this->Employee_model->GetAdministrationRoles($this->session->userdata('EmployeeId'));
      $data['SalesRoles'] = $this->Employee_model->GetSalesRoles($this->session->userdata('EmployeeId'));
      $data['PurchasesRoles'] = $this->Employee_model->GetPurchasesRoles($this->session->userdata('EmployeeId'));
      $data['RegistrationRoles'] = $this->Employee_model->GetRegistrationRoles($this->session->userdata('EmployeeId'));
      $data['TransactionRoles'] = $this->Employee_model->GetTransactionRoles($this->session->userdata('EmployeeId'));
      $data['ReportsRoles'] = $this->Employee_model->GetReportsRoles($this->session->userdata('EmployeeId'));
            
	    $data['GetGeneralJournal']=$this->GeneralJournal_model->GetGeneralJournalView($GeneralJournalId);
	    $data['CustomerNotification'] = $this->Customer_model->GetNotifications();
      // print_r($data['GetGeneralJournal']);
      //     die;
	    $this->load->view('generaljournal/view_generaljournal',$data);
		}

	
        public function AddGeneralJournal()
	{	
      $data['Roles'] = $this->Employee_model->GetRoles();
      $data['AdministrationRoles'] = $this->Employee_model->GetAdministrationRoles($this->session->userdata('EmployeeId'));
      $data['SalesRoles'] = $this->Employee_model->GetSalesRoles($this->session->userdata('EmployeeId'));
      $data['PurchasesRoles'] = $this->Employee_model->GetPurchasesRoles($this->session->userdata('EmployeeId'));
      $data['RegistrationRoles'] = $this->Employee_model->GetRegistrationRoles($this->session->userdata('EmployeeId'));
      $data['TransactionRoles'] = $this->Employee_model->GetTransactionRoles($this->session->userdata('EmployeeId'));
      $data['ReportsRoles'] = $this->Employee_model->GetReportsRoles($this->session->userdata('EmployeeId'));
            
            $data['GetAllCustomer']=$this->Customer_model->GetAllCustomers();
            $data['GetAllVendor']=$this->Vendor_model->GetAllVendors();
            $data['CustomerNotification'] = $this->Customer_model->GetNotifications();
            $this->load->view('generaljournal/add_generaljournal', $data);
	}
        
        
        public function EditGeneralJournal($GeneralJournalId)
        {
          $data['GetGeneralJournal']=$this->GeneralJournal_model->GetGeneralJournal($GeneralJournalId);
          $data['Roles'] = $this->Employee_model->GetRoles();
          $data['AdministrationRoles'] = $this->Employee_model->GetAdministrationRoles($this->session->userdata('EmployeeId'));
          $data['SalesRoles'] = $this->Employee_model->GetSalesRoles($this->session->userdata('EmployeeId'));
          $data['PurchasesRoles'] = $this->Employee_model->GetPurchasesRoles($this->session->userdata('EmployeeId'));
          $data['RegistrationRoles'] = $this->Employee_model->GetRegistrationRoles($this->session->userdata('EmployeeId'));
          $data['TransactionRoles'] = $this->Employee_model->GetTransactionRoles($this->session->userdata('EmployeeId'));
          $data['ReportsRoles'] = $this->Employee_model->GetReportsRoles($this->session->userdata('EmployeeId'));
          
          $data['GetAllCustomer']=$this->GeneralJournal_model->GetAllCustomers();
          $data['GetAllVendor']=$this->GeneralJournal_model->GetAllVendors();
          $data['GetAllBank']=$this->GeneralJournal_model->GetAllBanks();
          $data['GetAllSaleman'] = $this->Saleman_model->GetAllCategories();
          $data['CustomerNotification'] = $this->Customer_model->GetNotifications();

          $this->load->view('generaljournal/edit_generaljournal',$data);
        }


  public function ViewVoucher($GeneralJournalId)
        {
          $data['Roles'] = $this->Employee_model->GetRoles();
          $data['AdministrationRoles'] = $this->Employee_model->GetAdministrationRoles($this->session->userdata('EmployeeId'));
          $data['SalesRoles'] = $this->Employee_model->GetSalesRoles($this->session->userdata('EmployeeId'));
          $data['PurchasesRoles'] = $this->Employee_model->GetPurchasesRoles($this->session->userdata('EmployeeId'));
          $data['RegistrationRoles'] = $this->Employee_model->GetRegistrationRoles($this->session->userdata('EmployeeId'));
          $data['TransactionRoles'] = $this->Employee_model->GetTransactionRoles($this->session->userdata('EmployeeId'));
          $data['ReportsRoles'] = $this->Employee_model->GetReportsRoles($this->session->userdata('EmployeeId'));
      
      $data['GetGeneralJournal']=$this->GeneralJournal_model->GetGeneralJournalVoucher($GeneralJournalId);
      $data['GetSettingInformation'] = $this->Employee_model->GetSettingInformation();
      $data['CustomerNotification'] = $this->Customer_model->GetNotifications();
      $this->load->view('report/accountreports/voucher_report',$data);
        }






        public function DeletBank($BankId)
	{
		$Responce=$this->GeneralJournal_model->GetGeneralJournal($BankId);
               if($Responce == 'success')
               {
                   $this->session->set_flashdata('messag_account_delete','Bank Information deleted sucessfuly..!');
                   redirect("ChartOfAccount/");
               }
            
        }
        public function ViewAccount($AccountId)
	{
	        $this->load->view("includes/header");
		$this->load->view("includes/sidebar");
		
		$data['GetAccount']=$this->GeneralJournal_model->GetAccount($AccountId);   
                $data['CustomerNotification'] = $this->Customer_model->GetNotifications();
                $this->load->view('chartOfAccount/view_account',$data);
		$this->load->view("includes/footer");
	}
        public function EditAccount($AccountId)
	{
	       
                $this->load->view("includes/header");
		$this->load->view("includes/sidebar");
		$data['GetAccount']=$this->GeneralJournal_model->GetAccount($AccountId);
                $data['GetAllBanks']=$this->GeneralJournal_model->GetAllBanks();
                $data['CustomerNotification'] = $this->Customer_model->GetNotifications();
                $this->load->view('ChartOfAccount/edit_account',$data);
		
		$this->load->view("includes/footer");
	}
        
        public function UpdateAccount($AccountId)
	{
	        $this->load->view("includes/header");
		$this->load->view("includes/sidebar");
                
                $record = $this->input->post();
               
                $Responce = $this->GeneralJournal_model->UpdateAccount($record,$AccountId);
                if($Responce == 'success')
                {
                   $this->session->set_flashdata('messag_account','Account Information updated sucessfuly..!');
                   redirect("ChartOfAccount/ViewAccount/$AccountId");
                }
                
                //die('test');
               // $this->load->view('ChartOfAccount/edit_account',$data);
		
		$this->load->view("includes/footer");
	}
        
        
        public function ViewChartOfAccount($COA_Id)
        {
                $data['GetChartOfAccount'] = $this->GeneralJournal_model->GetChartOfAccount($COA_Id);
                $data['CustomerNotification'] = $this->Customer_model->GetNotifications();
                $this->load->view("includes/header");
		$this->load->view("includes/sidebar");
                $this->load->view('ChartOfAccount/view_chartofaccount',$data);
		$this->load->view("includes/footer");
        }
        public function EditChartOfAccount($COA_Id)
        {
            $data['CustomerNotification'] = $this->Customer_model->GetNotifications();
           $data['GetChartOfAccount'] = $this->GeneralJournal_model->GetChartOfAccount($COA_Id);
           $this->load->view("includes/header");
           $this->load->view("includes/sidebar");
           $this->load->view('ChartOfAccount/edit_chartofaccount',$data);
           $this->load->view("includes/footer");
          
           
        }

        public function CategoryCode($view = 'dropdown')
	{
               $COA_Id = $this->input->post('id');
               $data['GetAllCategories']=$this->GeneralJournal_model->GetAllCategories();
               $data['GetChartOfAccount'] = $this->GeneralJournal_model->GetChartOfAccount($COA_Id,'pos_accounts_chartofaccount_categories.ChartOfAccountCategoryId');
               $data['view'] = $view;
               //if($this->input->post('id') != '' )
               //$data['GetAccount']=$this->GeneralJournal_model->GetAccount($AccountId);
               $data['CustomerNotification'] = $this->Customer_model->GetNotifications();
               $this->load->view('chartofaccount/categorycode',$data);
               
	}
        public function ControlCode($view = 'dropdown')
	{
	       
               $CategoryId = $this->input->post('id');
               $COA_Id = $this->input->post('COA_id');
               $data['GetChartOfAccount'] = $this->GeneralJournal_model->GetChartOfAccount($COA_Id,'pos_accounts_chartofaccount_controls.ChartOfAccountControlId,pos_accounts_chartofaccount_categories.ChartOfAccountCategoryId');
               if(!$CategoryId)
               $CategoryId = $data['GetChartOfAccount']->ChartOfAccountCategoryId;
               $data['view'] = $view;
               $data['GetControlCode']=$this->GeneralJournal_model->GetControlCodeByCategoryId($CategoryId);
               $data['CustomerNotification'] = $this->Customer_model->GetNotifications();
               $this->load->view('chartofaccount/controlcode',$data);
	}
        public function ChartOfAccount_Code()
        {
           $ControlCodeId = $this->input->post('id');
           $GetControlCode=$this->GeneralJournal_model->GetControlCode($ControlCodeId);
           $GetChartOfAccount=$this->GeneralJournal_model->GetChartOfAccountCode($ControlCodeId);
           $COA_NextCode = ($GetChartOfAccount->COA_Code +1) ;
           
          if( ($COA_NextCode >= $GetControlCode->StartRange) && ($COA_NextCode <= $GetControlCode->EndRange) )
              echo $COA_NextCode;
          else
              echo "Control code  range is full";
           
           
        }
        
     

        public function AddControlCode()
        {
            //   $CategoryCodeId = $this->input->post('ChartOfAccountCategoryId');
               $Record = $this->input->post();
       
            
         $responce=$this->GeneralJournal_model->AddControlCode($Record);
         echo $responce;  
        }
        public function UpdateControlCode()
        {
            
          if(count($_POST) <=1 )
          {
              $BankId = $_POST['BId'];
              $GetBank = $this->GeneralJournal_model->GetBank($BankId);
              if($GetBank->Status   ==1)
                  $Record = array("Status" => 0);
              else    
                  $Record = array("Status" => 1);
              
              
             
          }
          else
          {
              
              $ControlCodeId = $this->input->post('ChartOfAccountControlId');
              $Record = $this->input->post();
          }
         $responce=$this->GeneralJournal_model->UpdateControlCode($Record,$ControlCodeId);
         echo $responce;  
        }
        
        
}

?>