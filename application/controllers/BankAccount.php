<?php defined('BASEPATH') OR exit('No direct script access allowed');

class BankAccount extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		
		$this->check_isvalidated();
		$this->load->model('Account_model');
        $this->load->model('COA_model');
        $this->load->model('Employee_model');
        $this->load->model('Customer_model');
	}
	
	private function check_isvalidated()
	{
		if(!$this->session->userdata('EmployeeId'))
		{ 
            $this->session->set_userdata('url',  current_url());
            redirect('Login'); 
        }
	}
	
        
                  
	public function index()
	{
        $data['AdministrationRoles'] = $this->Employee_model->GetAdministrationRoles($this->session->userdata('EmployeeId'));
        $data['SalesRoles'] = $this->Employee_model->GetSalesRoles($this->session->userdata('EmployeeId'));
        $data['PurchasesRoles'] = $this->Employee_model->GetPurchasesRoles($this->session->userdata('EmployeeId'));
        $data['RegistrationRoles'] = $this->Employee_model->GetRegistrationRoles($this->session->userdata('EmployeeId'));
        $data['TransactionRoles'] = $this->Employee_model->GetTransactionRoles($this->session->userdata('EmployeeId'));
        $data['ReportsRoles'] = $this->Employee_model->GetReportsRoles($this->session->userdata('EmployeeId'));
        $data['GetAllAccounts']=$this->Account_model->GetAllAccounts();
        
        $data['CustomerNotification'] = $this->Customer_model->GetNotifications();
//        $data['GetAllBankAccounts']=$this->Account_model->GetAllBankAccounts();
        // print_r($data['GetAllBankAccounts']);
        // die;
            $this->load->view('accounts/accounts',$data);
		
	}
        public function GetAllAccountsAjax()
	{
		      $GetAllAccounts=$this->Account_model->GetAllAccountsAjax($_REQUEST);

        $ViewRecord = '<span style="color:#00a65a;" class="glyphicon glyphicon-th-large"></span>';
        $UpdateRecord = '<span style="color:#0c6aad;" class="fa fa-edit">';

          $data = array();
            foreach($GetAllAccounts['record'] as $row)
            {    
              $nestedData=array(); 
              $nestedData[] = $row["AccountTitle"];
              $nestedData[] = $row["AccountNumber"];
              $nestedData[] = $row["BranchName"];
              $nestedData[] = $row["BranchCode"];
              $id = $row["AccountId"];

          $nestedData[] = '<a href="'.base_url().'BankAccount/ViewAccount/'.$id.'" title="View Record">'.$ViewRecord.'</a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="'.base_url().'BankAccount/EditAccount/'.$id.'"title="Update Record"><span style="color:#0c6aad;" class="fa fa-edit"></span></a>';

//              $nestedData[] = anchor("BankAccount/ViewAccount/$id",'<i class="ace-icon fa fa-check bigger-130"></i>',array("class"=>"btn btn-xs btn-success","title"=>"View")).
//                  ' '.anchor("BankAccount/EditAccount/$id",'<i style="color:#FFFFFF;" class="ace-icon fa fa-pencil bigger-120"></i>',array("class"=>"btn btn-xs btn-info","title"=>"Edit"));
//              $nestedData[] = '<a href="ViewAccount/'.$id.'" title="View Record"><span class="glyphicon glyphicon-th-large"></span></a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="EditAccount/'.$id.'" title="Update Record"><span class="fa fa-pencil"></span></a>';
//              $nestedData[] =  anchor("BankAccount/ViewAccount/$id",'View') .' <span class="fa fa-eye"></span>&nbsp;&nbsp;   '. anchor("BankAccount/EditAccount/$id",'Edit') .' <spa n class="fa fa-edit"></span>&nbsp;&nbsp;';//.anchor("Accounts/DeletAccount/$id",'Status').' <span class="fa fa-   $data[] = $nestedData;
              $data[] = $nestedData;
            }
           $json_data = array(
            "draw"            => intval( $_REQUEST['draw'] ),   // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw. 
        		"recordsTotal"    => intval( $GetAllAccounts['recordsTotal'] ),  // total number of records
        		"recordsFiltered" => intval( $GetAllAccounts['recordsFiltered'] ), // total number of records after searching, if there is no searching then totalFiltered = totalData
        			"data"            => $data   // total data array
        		);
                echo json_encode($json_data);  // send data as json format

               
            
        }
        
        public function DeletBank($BankId)
	{
		$Responce=$this->Account_model->DeleteBank($BankId);
               if($Responce == 'success')
               {
                   $this->session->set_flashdata('messag_account_delete','Bank Information deleted sucessfuly..!');
                   redirect("Accounts/");
               }
            
        }
        public function ViewAccount($AccountId)
	{
	    $data['AdministrationRoles'] = $this->Employee_model->GetAdministrationRoles($this->session->userdata('EmployeeId'));
        $data['SalesRoles'] = $this->Employee_model->GetSalesRoles($this->session->userdata('EmployeeId'));
        $data['PurchasesRoles'] = $this->Employee_model->GetPurchasesRoles($this->session->userdata('EmployeeId'));
        $data['RegistrationRoles'] = $this->Employee_model->GetRegistrationRoles($this->session->userdata('EmployeeId'));
        $data['TransactionRoles'] = $this->Employee_model->GetTransactionRoles($this->session->userdata('EmployeeId'));
        $data['ReportsRoles'] = $this->Employee_model->GetReportsRoles($this->session->userdata('EmployeeId'));
        $data['GetAccount']=$this->Account_model->GetAccount($AccountId);      
        $data['CustomerNotification'] = $this->Customer_model->GetNotifications();
        
        $this->load->view('accounts/view_account',$data);
	}
        
        public function EditAccount($AccountId)
	{       
            $data['AdministrationRoles'] = $this->Employee_model->GetAdministrationRoles($this->session->userdata('EmployeeId'));
            $data['SalesRoles'] = $this->Employee_model->GetSalesRoles($this->session->userdata('EmployeeId'));
            $data['PurchasesRoles'] = $this->Employee_model->GetPurchasesRoles($this->session->userdata('EmployeeId'));
            $data['RegistrationRoles'] = $this->Employee_model->GetRegistrationRoles($this->session->userdata('EmployeeId'));
            $data['TransactionRoles'] = $this->Employee_model->GetTransactionRoles($this->session->userdata('EmployeeId'));
            $data['ReportsRoles'] = $this->Employee_model->GetReportsRoles($this->session->userdata('EmployeeId'));
            $data['GetAccount']=$this->Account_model->GetAccount($AccountId);
            $data['GetAllBanks']=$this->Account_model->GetAllBanks();        
            $data['CustomerNotification'] = $this->Customer_model->GetNotifications();
            $this->load->view('accounts/edit_account',$data);
	}
        
        public function UpdateAccount($AccountId)
	{      
             $record = $this->input->post();
               
             $AccountId = $this->Account_model->UpdateAccount($record,$AccountId);
              
             $Message = 'Record updated successfully';
             $this->session->set_flashdata("success_message",$Message);
             redirect("BankAccount/ViewAccount/".$AccountId);
	}
        
        
        public function AddAccount()
	{
            $GetChartOfAccount  = $this->COA_model->GetChartOfAccountCode(4);

            $data['GetAllChartOfAccount']=$this->COA_model->GetAllChartOfAccount();
            $data['GetAllBanks']=$this->Account_model->GetAllBanks();

            $data['AdministrationRoles'] = $this->Employee_model->GetAdministrationRoles($this->session->userdata('EmployeeId'));
            $data['SalesRoles'] = $this->Employee_model->GetSalesRoles($this->session->userdata('EmployeeId'));
            $data['PurchasesRoles'] = $this->Employee_model->GetPurchasesRoles($this->session->userdata('EmployeeId'));
            $data['RegistrationRoles'] = $this->Employee_model->GetRegistrationRoles($this->session->userdata('EmployeeId'));
            $data['TransactionRoles'] = $this->Employee_model->GetTransactionRoles($this->session->userdata('EmployeeId'));
            $data['ReportsRoles'] = $this->Employee_model->GetReportsRoles($this->session->userdata('EmployeeId'));

            $data['Category_Id'] = $GetChartOfAccount->ChartOfAccountCategoryId;
            $data['ControlCode_Id'] = $GetChartOfAccount->ChartOfAccountControlId;
            $data['COA_Code'] = $this->COA_model->NextChartOfAccountCode(4,$GetChartOfAccount->COA_Code);

            $data['GetAllChartOfAccount']=$this->COA_model->GetAllChartOfAccount();
            $data['GetAllBanks']=$this->Account_model->GetAllBanks();
            
            $data['CustomerNotification'] = $this->Customer_model->GetNotifications();

            $this->load->view('accounts/add_account',$data);

	}
        public function SaveAccount()
	{
	        
                $record = $this->input->post();
//                echo "<pre>";
//                print_r($record);
//                die;
                if($LastAccountId = $responce=$this->Account_model->SaveAccount($record))
                {
                     $this->session->set_flashdata('messag_accounts','Account Information Added sucessfuly..!');
                     redirect("BankAccount/ViewAccount/$LastAccountId");
                }  
                
               
	}
        public function Banks()
	{
             $data['GetAllBanks']=$this->Account_model->GetAllBanks('Yes');
             
             $data['CustomerNotification'] = $this->Customer_model->GetNotifications();
             $this->load->view('accounts/banks',$data);
        }
       
        public function BankDropDown()
	{
	       $AccountId = $this->input->post('id');
               $data['GetAllBanks']=$this->Account_model->GetAllBanks();
               if($this->input->post('id') != '' )
                $data['GetAccount']=$this->Account_model->GetAccount($AccountId);
                
                $data['CustomerNotification'] = $this->Customer_model->GetNotifications();
                $this->load->view('accounts/bank_dropdown',$data);
               
	}

        public function AddBank()
        {
            
           $Record = array(
                        'BankName'=>$this->input->post('BName'),
                        'BankAbbreviation'=>$this->input->post('BAbb'),
                        'AddedOn'=>date('Y-m-d H:i:s'),
                        'AddedBy'=>1
                        
           );
         $responce=$this->Account_model->AddBank($Record);
         echo $responce;  
        }
        
        public function UpdateBank()
        {
            
          if(count($_POST) <=1 )
          {
              $BankId = $_POST['BId'];
              $GetBank = $this->Account_model->GetBank($BankId);
              if($GetBank->Status   ==1)
                  $Record = array("Status" => 0);
              else    
                  $Record = array("Status" => 1);
              
              
             
          }
          else
          {
                     $Record = array(
                                 'BankName'=>$_POST['BName'],
                                 'BankAbbreviation'=>$_POST['BAbb'],
                                  );
                    $BankId = $_POST['BId'];
  
          }
         $responce=$this->Account_model->UpdateBank($Record,$BankId);
         echo $responce;  
        }
        
        public function GetAccountByBankId()
        {
           $BankId = $_POST['bankId'];
           $result = $this->db->get_where('ims_bank_accounts',array('BankId'=>$BankId) )->result_array();
           $AccuntDropDown = '';
            foreach($result as  $value)
            {    
                $AccuntDropDown .= '<option  value="'.$value["AccountId"].'"> ' .$value['AccountTitle'].' </option>';
            }
           
           echo  '<select class="" id="AccountId" name="AccountId">
                            <option value="0"> --Select Account--   </option>
                            '.$AccuntDropDown.'
                        </select>';
           
           
        }
        
}

?>