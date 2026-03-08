<?php defined('BASEPATH') OR exit('No direct script access allowed');

class ChartOfAccount extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->check_isvalidated();
		$this->load->model('COA_model');
        $this->load->model('Employee_model');
        $this->load->model('Category_model');
        $this->load->model('Customer_model');
	}
	
	private function check_isvalidated()
	{
		if(!$this->session->userdata('EmployeeId'))
		{ $this->session->set_userdata('url',  current_url()); redirect('Login'); }
	}
	public function index()
	{
//    die('under maintainance');
	    $data['Roles'] = $this->Employee_model->GetRoles();
	    $data['AdministrationRoles'] = $this->Employee_model->GetAdministrationRoles($this->session->userdata('EmployeeId'));
	    $data['SalesRoles'] = $this->Employee_model->GetSalesRoles($this->session->userdata('EmployeeId'));
	    $data['PurchasesRoles'] = $this->Employee_model->GetPurchasesRoles($this->session->userdata('EmployeeId'));
	    $data['RegistrationRoles'] = $this->Employee_model->GetRegistrationRoles($this->session->userdata('EmployeeId'));
	    $data['TransactionRoles'] = $this->Employee_model->GetTransactionRoles($this->session->userdata('EmployeeId'));
	    $data['ReportsRoles'] = $this->Employee_model->GetReportsRoles($this->session->userdata('EmployeeId'));
//	    $data['AllCategories']=$this->Category_model->GetAllCategories();
//	    $data['TotalRecord']=$this->Category_model->TotalRecord();
//            $data['GetAllChartOfAccount']=$this->COA_model->GetAllChartOfAccount();

        $data['CustomerNotification'] = $this->Customer_model->GetNotifications();
        $this->load->view('chartofaccount/chartofaccounts',$data);
	}
      public function Ajax_GetAllChartOfAccount()
	    {
          $RegistrationRoles = $this->Employee_model->GetRegistrationRoles($this->session->userdata('EmployeeId'));
          $GetAllChartOfAccount=$this->COA_model->Ajax_GetAllChartOfAccount($_REQUEST);
          
          $ViewRecord = '<span style="color:#00a65a;" class="glyphicon glyphicon-th-large"></span>';
          $UpdateRecord = '<span style="color:#0c6aad;" class="fa fa-edit">';
            $data = array();
             foreach($GetAllChartOfAccount['record'] as $row)
              {    
              $nestedData=array(); 
              $nestedData[] = $row["CategoryCode"].'-'.$row["CategoryName"];
              $nestedData[] = $row["ControlCode"];
              $nestedData[] = $row["ChartOfAccountCode"];
              $nestedData[] = $row["ChartOfAccountTitle"];
              $id = $row["ChartOfAccountId"];
//              if ($RegistrationRoles[0]['ViewRoles'] == 1 && $RegistrationRoles[0]['UpdateRoles'] ==1 ) {
                  $nestedData[] = '<a href="'.base_url().'ChartOfAccount/ViewChartOfAccount/'.$id.'" title="View Record">'.$ViewRecord.'</a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="'.base_url().'ChartOfAccount/EditChartOfAccount/'.$id.'"title="Update Record"><span style="color:#0c6aad;" class="fa fa-edit"></span></a>';
/*              }
                if ($RegistrationRoles[0]['ViewRoles'] == 1) {
                  $nestedData[] = '<a href="'.base_url().'ChartOfAccount/ViewChartOfAccount/'.$id.'" title="View Record">'.$ViewRecord.'</a>';
                }*/
                    $data[] = $nestedData;
                    
                }
               
            $json_data = array(
			"draw"            => intval( $_REQUEST['draw'] ),   // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw. 
			"recordsTotal"    => intval( $GetAllChartOfAccount['recordsTotal'] ),  // total number of records
			"recordsFiltered" => intval( $GetAllChartOfAccount['recordsFiltered'] ), // total number of records after searching, if there is no searching then totalFiltered = totalData
			"data"            => $data   // total data array
			);
               // print_r($json_data);
               // die;
                echo json_encode($json_data);  // send data as json format

               
            
        }
        
        public function DeletBank($BankId)
	{
		$Responce=$this->COA_model->DeleteBank($BankId);
               if($Responce == 'success')
               {
                   $this->session->set_flashdata('messag_account_delete','Bank Information deleted sucessfuly..!');
                   redirect("ChartOfAccount/");
               }
            
        }
        
        public function ViewAccount($AccountId)
	{        
	    $data['Roles'] = $this->Employee_model->GetRoles();
	    $data['AdministrationRoles'] = $this->Employee_model->GetAdministrationRoles($this->session->userdata('EmployeeId'));
	    $data['SalesRoles'] = $this->Employee_model->GetSalesRoles($this->session->userdata('EmployeeId'));
	    $data['PurchasesRoles'] = $this->Employee_model->GetPurchasesRoles($this->session->userdata('EmployeeId'));
	    $data['RegistrationRoles'] = $this->Employee_model->GetRegistrationRoles($this->session->userdata('EmployeeId'));
	    $data['TransactionRoles'] = $this->Employee_model->GetTransactionRoles($this->session->userdata('EmployeeId'));
	    $data['ReportsRoles'] = $this->Employee_model->GetReportsRoles($this->session->userdata('EmployeeId'));
//	    $data['AllCategories']=$this->Category_model->GetAllCategories();
//	    $data['TotalRecord']=$this->Category_model->TotalRecord();
	    $data['GetAccount']=$this->COA_model->GetAccount($AccountId); 
	    $data['CustomerNotification'] = $this->Customer_model->GetNotifications();
            $this->load->view('chartofaccount/view_account',$data);
	}
        
        public function EditAccount($AccountId)
	{      
	    $data['Roles'] = $this->Employee_model->GetRoles();
	    $data['AdministrationRoles'] = $this->Employee_model->GetAdministrationRoles($this->session->userdata('EmployeeId'));
	    $data['SalesRoles'] = $this->Employee_model->GetSalesRoles($this->session->userdata('EmployeeId'));
	    $data['PurchasesRoles'] = $this->Employee_model->GetPurchasesRoles($this->session->userdata('EmployeeId'));
	    $data['RegistrationRoles'] = $this->Employee_model->GetRegistrationRoles($this->session->userdata('EmployeeId'));
	    $data['TransactionRoles'] = $this->Employee_model->GetTransactionRoles($this->session->userdata('EmployeeId'));
	    $data['ReportsRoles'] = $this->Employee_model->GetReportsRoles($this->session->userdata('EmployeeId'));
//	    $data['AllCategories']=$this->Category_model->GetAllCategories();
//	    $data['TotalRecord']=$this->Category_model->TotalRecord();
	    $data['GetAccount']=$this->COA_model->GetAccount($AccountId);
            $data['GetAllBanks']=$this->COA_model->GetAllBanks();
            $data['CustomerNotification'] = $this->Customer_model->GetNotifications();
            $this->load->view('chartofaccount/edit_chartofaccount',$data);
		
	}
        
        public function UpdateAccount($AccountId)
	{
	        $this->load->view("includes/header");
		$this->load->view("includes/sidebar");
                
                $record = $this->input->post();
               
                 $Responce = $this->COA_model->UpdateAccount($record,$AccountId);
               if($Responce == 'success')
               {
                   $this->session->set_flashdata('messag_account','Account Information updated sucessfuly..!');
                   redirect("ChartOfAccount/ViewAccount/$AccountId");
               }
                
                //die('test');
               // $this->load->view('ChartOfAccount/edit_account',$data);
		
		$this->load->view("includes/footer");
	}
        
  public function AddChartOfAccount()
	{
	    $data['Roles'] = $this->Employee_model->GetRoles();
	    $data['AdministrationRoles'] = $this->Employee_model->GetAdministrationRoles($this->session->userdata('EmployeeId'));
	    $data['SalesRoles'] = $this->Employee_model->GetSalesRoles($this->session->userdata('EmployeeId'));
	    $data['PurchasesRoles'] = $this->Employee_model->GetPurchasesRoles($this->session->userdata('EmployeeId'));
	    $data['RegistrationRoles'] = $this->Employee_model->GetRegistrationRoles($this->session->userdata('EmployeeId'));
	    $data['TransactionRoles'] = $this->Employee_model->GetTransactionRoles($this->session->userdata('EmployeeId'));
	    $data['ReportsRoles'] = $this->Employee_model->GetReportsRoles($this->session->userdata('EmployeeId'));
	    $data['AllCategories']=$this->Category_model->GetAllCategories();
//	    $data['TotalRecord']=$this->Category_model->TotalRecord();
        $data['CustomerNotification'] = $this->Customer_model->GetNotifications();
            $this->load->view('chartofaccount/add_chartofaccount', $data);
	}

        public function ViewChartOfAccount($COA_Id)
        {
	    $data['Roles'] = $this->Employee_model->GetRoles();
	    $data['AdministrationRoles'] = $this->Employee_model->GetAdministrationRoles($this->session->userdata('EmployeeId'));
	    $data['SalesRoles'] = $this->Employee_model->GetSalesRoles($this->session->userdata('EmployeeId'));
	    $data['PurchasesRoles'] = $this->Employee_model->GetPurchasesRoles($this->session->userdata('EmployeeId'));
	    $data['RegistrationRoles'] = $this->Employee_model->GetRegistrationRoles($this->session->userdata('EmployeeId'));
	    $data['TransactionRoles'] = $this->Employee_model->GetTransactionRoles($this->session->userdata('EmployeeId'));
	    $data['ReportsRoles'] = $this->Employee_model->GetReportsRoles($this->session->userdata('EmployeeId'));
//	    $data['AllCategories']=$this->Category_model->GetAllCategories();
//	    $data['TotalRecord']=$this->Category_model->TotalRecord();
	    $data['GetChartOfAccount'] = $this->COA_model->GetChartOfAccount($COA_Id);
	    $data['CustomerNotification'] = $this->Customer_model->GetNotifications();
        $this->load->view('chartofaccount/view_chartofaccount',$data);
        }
        
        public function EditChartOfAccount($COA_Id)
        {
	    $data['Roles'] = $this->Employee_model->GetRoles();
	    $data['AdministrationRoles'] = $this->Employee_model->GetAdministrationRoles($this->session->userdata('EmployeeId'));
	    $data['SalesRoles'] = $this->Employee_model->GetSalesRoles($this->session->userdata('EmployeeId'));
	    $data['PurchasesRoles'] = $this->Employee_model->GetPurchasesRoles($this->session->userdata('EmployeeId'));
	    $data['RegistrationRoles'] = $this->Employee_model->GetRegistrationRoles($this->session->userdata('EmployeeId'));
	    $data['TransactionRoles'] = $this->Employee_model->GetTransactionRoles($this->session->userdata('EmployeeId'));
	    $data['ReportsRoles'] = $this->Employee_model->GetReportsRoles($this->session->userdata('EmployeeId'));
//	    $data['AllCategories']=$this->Category_model->GetAllCategories();
//	    $data['TotalRecord']=$this->Category_model->TotalRecord();
        $data['GetChartOfAccount'] = $this->COA_model->GetChartOfAccount($COA_Id);
        $data['CustomerNotification'] = $this->Customer_model->GetNotifications();
        $this->load->view('chartofaccount/edit_chartofaccount',$data);
        }

        public function SaveChartOfAccount($COA_Id='0')
	{
	        
                $Record = $this->input->post();
//                if($COA_Id !=0 )
                $Record['ChartOfAccountAddedOn'] = date('Y-m-d H:i:s');
                $Record['ChartOfAccountAddedBy'] = $this->session->userdata('EmployeeId');
                
                $LastChartOfAccountId=$this->COA_model->SaveChartOfAccount($Record,$COA_Id);
		
                if($LastChartOfAccountId != '')
		{
                     if($COA_Id == 0) 
                     {
                        $this->session->set_flashdata('messag_chartOfAccount','Account Information Added sucessfuly..!');
                        redirect("ChartOfAccount/ViewChartOfAccount/$LastChartOfAccountId");
                     }   
                     else
                     {
                        $this->session->set_flashdata('messag_chartOfAccount','Account Information update sucessfuly..!');
                        redirect("ChartOfAccount/ViewChartOfAccount/$COA_Id");
                     }
                }
	}

    public function CategoryCode($view = 'dropdown')
	{
       $COA_Id = $this->input->post('id');
       $data['GetAllCategories']=$this->COA_model->GetAllCategories();
       $data['GetChartOfAccount'] = $this->COA_model->GetChartOfAccount($COA_Id,'pos_accounts_chartofaccount_categories.ChartOfAccountCategoryId');
       $data['view'] = $view;
       $data['CustomerNotification'] = $this->Customer_model->GetNotifications();

       $this->load->view('chartofaccount/categorycode',$data);
	}
        /*
        public function ControlCode($view = 'dropdown')
	{
	       
               $CategoryId = $this->input->post('id');
               $COA_Id = $this->input->post('COA_id');
               $data['GetChartOfAccount'] = $this->COA_model->GetChartOfAccount($COA_Id,'pos_accounts_chartofaccount_controls.ChartOfAccountControlId,pos_accounts_chartofaccount_categories.ChartOfAccountCategoryId');
               if(!$CategoryId)
               $CategoryId = $data['GetChartOfAccount']->ChartOfAccountCategoryId;
               $data['view'] = $view;
               $data['GetControlCode']=$this->COA_model->GetControlCodeByCategoryId($CategoryId);
               $this->load->view('chartofaccount/controlcode',$data);
	}
        */
        
        public function ControlCode($view = 'dropdown')
	{
            $CategoryId = $this->input->post('id');
            $COA_Id = $this->input->post('COA_id');
            
            $data['GetChartOfAccount'] = $this->COA_model->GetChartOfAccount($COA_Id,'pos_accounts_chartofaccount_controls.ChartOfAccountControlId,pos_accounts_chartofaccount_categories.ChartOfAccountCategoryId');
            
            if(!$CategoryId)
            $CategoryId = $data['GetChartOfAccount']->ChartOfAccountCategoryId;
            $data['view'] = $view;
            $data['GetControlCode']=$this->COA_model->GetControlCodeByCategoryId($CategoryId);
            $data['CustomerNotification'] = $this->Customer_model->GetNotifications();
            
            $this->load->view('chartofaccount/controlcode',$data);
	}
        
        public function ChartOfAccount_Code()
        {
            
           $ControlCodeId = $this->input->post('id');
           $GetControlCode=$this->COA_model->GetControlCode($ControlCodeId);
           $GetChartOfAccount=$this->COA_model->GetChartOfAccountCode($ControlCodeId);
           //print_r($GetChartOfAccount);
           // die;
            $COA_NextCode = $this->COA_model->NextChartOfAccountCode($ControlCodeId,$GetChartOfAccount->COA_Code) ;


            $arrChartOfAccount =array("Code"=>$COA_NextCode);
          echo json_encode($arrChartOfAccount); 
          
//          if( ($COA_NextCode >= $GetControlCode->StartRange) && ($COA_NextCode <= $GetControlCode->EndRange) )
//              echo $COA_NextCode;
//          else
//              echo "Control code  range is full";
//           
           
        }
        
         public function GetChartOfAccountList($view = 'dropdown')
         {
            $ControlCodeId = $this->input->post('id');
            if(!$ControlCodeId)
            $ControlCodeId = $data['GetChartOfAccount']->ChartOfAccountCategoryId;
            $data['view'] = $view;
            $GetChartOfAccountList =$this->COA_model->GetChartOfAccountByControlCodeId($ControlCodeId);
            $Result = "<option value='0'>Select Chart Of Account</option>"; 
            foreach($GetChartOfAccountList as $row) {
            $Result .= "<option value='".$row['ChartOfAccountId']."'>".$row['ChartOfAccountTitle']."</option>";
            } 
            echo $Result;
         }
        
     

        public function AddControlCode()
        {
         //   $CategoryCodeId = $this->input->post('ChartOfAccountCategoryId');
         $Record = $this->input->post();
         $responce=$this->COA_model->AddControlCode($Record);
         echo $responce;  
        }
        public function UpdateControlCode()
        {
            
          if(count($_POST) <=1 )
          {
              $BankId = $_POST['BId'];
              $GetBank = $this->COA_model->GetBank($BankId);
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
         $responce=$this->COA_model->UpdateControlCode($Record,$ControlCodeId);
         echo $responce;  
        }
}
?>