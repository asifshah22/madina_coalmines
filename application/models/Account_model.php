<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Account_model extends CI_Model{
	
	function __construct()
	{
		parent::__construct();
               // $this->output->enable_profiler();
	}
        
      	function GetAllAccounts()
      	{                
                 
              //  $result = $this->db->get_where('pos_accounts')->result_array();
                $result = $this->db->get('pos_bank_accounts' )->result_array();
                //print_r($query->result_array());
                return $result;
        }

        public function GetAllBankAccounts()
        {
          $this->db->select("*")->from('pos_bank_accounts');
//          $this->db->join('pos_banks', 'pos_banks.BankId = pos_bank_accounts.BankId', 'left');
          $query = $this->db->get();
          return $query->result_array();
        }
        
        function GetAllBanks($AllBankes = 'No')
	     {
                if($AllBankes == 'Yes')
                $result = $this->db->get('pos_banks')->result_array();
               else
                $result = $this->db->get_where('pos_banks',array('Status'=>1))->result_array();
               
                return $result;
        }
        function GetBank($id)
	{
                $result = $this->db->get_where('pos_banks',array('BankId'=>$id) )->row();
                return $result;
        }
      
        function GetAllAccountsAjax($requestData)
        {
                $columns = array( 
                        
                        0 => 'AccountId',
                        1 => 'AccountTitle', 
                        2 => 'AccountNumber',
                        3 => 'BranchName',
                        4 => 'BranchCode',
                );
                $sql = "SELECT AccountId,AccountTitle,AccountNumber,BranchName,BranchCode";
                $sql.=" FROM pos_bank_accounts";
                $query= $this->db->query($sql); 
                $totalData = $query->num_rows();
                $totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.
                $sql.=" WHERE 1=1 ";
//                $sql = "SELECT AccountId,AccountTitle,AccountNumber,BranchName,BranchCode";
//                $sql.= " FROM pos_bank_accounts";
//                $sql.=" WHERE 1=1";
                if( !empty($requestData['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter
                       $sql.=" AND ( AccountTitle LIKE '".$requestData['search']['value']."%' ";
                       $sql.=" OR  AccountNumber LIKE '".$requestData['search']['value']."%' "; 
                       $sql.=" OR  BranchName LIKE '".$requestData['search']['value']."%' "; 
                       $sql.=" OR BranchCode LIKE '".$requestData['search']['value']."%' )";  
                }
                $query=$this->db->query( $sql) ;
                $totalFiltered = $query->num_rows(); // when there is a search parameter then we have to modify total number filtered rows as per search result. 
                $sql.=" ORDER BY ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']."  LIMIT ".$requestData['start']." ,".$requestData['length']."   ";
                $query=$this->db->query($sql);  
                $array['record'] = $query->result_array();
                $array['recordsFiltered'] = $totalFiltered;
                $array['recordsTotal'] = $totalData;
                
                return $array;
        }
        function GetAccount($id)
        {
            $this->db->select('*');
            $this->db->from('pos_bank_accounts');
            $this->db->join('pos_banks', 'pos_bank_accounts.BankId = pos_banks.BankId');
            $this->db->join('pos_accounts_chartofaccount', 'pos_accounts_chartofaccount.ChartOfAccountId = pos_bank_accounts.ChartOfAccountId', 'left');
            $this->db->where('pos_bank_accounts.AccountId', $id);
            $result = $this->db->get()->row();
            return $result;
        }
        
        function UpdateAccount($Record,$id)
	      {
          $arrAccount = array(
              'AccountTitle'=>$Record['AccountTitle'],
              'AccountNumber'=>$Record['AccountNumber'],
              'BranchName'=>$Record['BranchName'],
              'BranchNumber'=>$Record['BranchNumber'],
              'BranchCode'=>$Record['BranchCode'],
              'ContactPerson'=>$Record['ContactPerson'],
              'Address'=>$Record['Address'],
              'PhoneNumber'=>$Record['PhoneNumber'],
/*              'CatagoryCode'=>$Record['ChartOfAccountCategoryId'],
              'ControllCode'=>$Record['ChartOfAccountControlCode'],
              'ChartOfAccountTitle'=>$Record['ChartOfAccountTitle'],
              'ChartOfAccount'=>$Record['ChartOfAccountCode'],*/

              'OppeningBalance'=>$Record['OppeningBalance'],
              'OppeningBalanceDate'=> date('Y-m-d', strtotime($Record['OppeningBalanceDate'])),
//              'Notes'=>$Record['Notes'],
              'AddedOn'=>date('Y-m-d H:i:s'),
              'AddedBy'=>$this->session->userdata('EmployeeId'));

/*              $arrChartOfAccount = array(
                'ChartOfAccountCategoryId'=>$Record['ChartOfAccountCategoryId'],
                'ChartOfAccountControlId'=>$Record['ChartOfAccountControlCode'],
                'ChartOfAccountTitle'=>$Record['ChartOfAccountTitle'],
                'ChartOfAccountCode'=>$Record['ChartOfAccountCode'],
                'ChartOfAccountAddedOn'=>date('Y-m-d H:i:s'),
                'ChartOfAccountAddedBy'=>$this->session->userdata('EmployeeId'),
              );*/

             $arrChartOfAccount = array(
             'ChartOfAccountTitle'=>$Record['ChartOfAccountTitle'],
             'ChartOfAccountAddedOn' => date('Y-m-d H:i:s'),    
             'ChartOfAccountAddedBy'=> $this->session->userdata('EmployeeId')     
             );
            
             $this->db->where('ChartOfAccountId',$Record['ChartOfAccountId']);
             $status = $this->db->update('pos_accounts_chartofaccount',$arrChartOfAccount);
                
             // this line eliminates Chart Of Account Title From Array
             unset($Record['ChartOfAccountTitle']);
             
             $this->db->where('AccountId', $id);
             $this->db->update('pos_bank_accounts', $arrAccount);
             
             return $id;
          }

        
        function GetProductWithCondition($requestData)
        {
       // storing  request (ie, get/post) global array to a variable  
            

                $columns = array( 
                // datatable column index  => database column name
                        0 =>'BrandName', 
                        1 => 'CategoryName',
                        1 => 'ProductGroupName',
                        1 => 'Packing',
                );


       
                // getting total number records without any search
                $sql = "SELECT ProductId,BrandName, CategoryName,ProductGroupName,Packing ";
                $sql.="FROM pos_product AS P
                INNER JOIN pos_category AS C ON C.CategoryId = P.CategoryId
                INNER JOIN pos_productgroup AS PD ON PD.ProductGroupId = P.ProductGroupId";
                $query= $this->db->query($sql); 
                $totalData = $query->num_rows();
                $totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.
                
       
                $sql = "SELECT pos_product.ProductId,BrandName, CategoryName,ProductGroupName,Packing ";
                $sql.=" FROM pos_product AS P
                INNER JOIN pos_category AS C ON C.CategoryId = P.CategoryId
                INNER JOIN pos_productgroup AS PD ON PD.ProductGroupId = P.ProductGroupId WHERE 1=1";
                if( !empty($requestData['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter
                       $sql.=" AND ( BrandName LIKE '".$requestData['search']['value']."%' ";    
                       $sql.=" OR CategoryName LIKE '".$requestData['search']['value']."%' ";
                       $sql.=" OR ProductGroupName LIKE '".$requestData['search']['value']."%' )";  
                }
                //print_r($columns);
                //echo $columns[$requestData['order'][0]['column']];
                //die;
                $query=$this->db->query( $sql) ;
                $totalFiltered = $query->num_rows(); // when there is a search parameter then we have to modify total number filtered rows as per search result. 
                $sql.=" ORDER BY ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']."  LIMIT ".$requestData['start']." ,".$requestData['length']."   ";
                /* $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc  */	
                
                $query=$this->db->query($sql);  


                //print_r($query->result_array());
                
      
        return $query->result_array();
    }
            public function DeleteBank($bankId)
            {
              $this->db->where('BankId', $bankId);
              $status =  $this->db->update('pos_accounts', array('Deleted'=>'1'));
              if($status)
                 return('success');
              else    
              return('fail');
            }
            
            public function SaveAccount($Record)
            {
              
                $arrAccount = array(
                'BankId'=>$Record['BankId'],
                'AccountTitle'=>$Record['AccountTitle'],
                'AccountNumber'=>$Record['AccountNumber'],
                'BranchName'=>$Record['BranchName'],
                'BranchNumber'=>$Record['BranchNumber'],
                'BranchCode'=>$Record['BranchCode'],
                'ContactPerson'=>$Record['ContactPerson'],
                'Address'=>$Record['Address'],
                'PhoneNumber'=>$Record['PhoneNumber'],
                'CatagoryCode'=>$Record['ChartOfAccountCategoryId'],
                'ControllCode'=>$Record['ControlCode'],
                'ChartOfAccountTitle'=>$Record['ChartOfAccountTitle'],
                'ChartOfAccount'=>$Record['ChartOfAccountCode'],
  
                'OppeningBalance'=>$Record['OppeningBalance'],
                'OppeningBalanceDate'=> date('Y-m-d', strtotime($Record['OppeningBalanceDate'])),
  //              'Notes'=>$Record['Notes'],
                'AddedOn'=>date('Y-m-d H:i:s'),
                'AddedBy'=>$this->session->userdata('EmployeeId'));

                $arrChartOfAccount = array(
                'ChartOfAccountCategoryId'=>$Record['ChartOfAccountCategoryId'],
                'ChartOfAccountControlId'=>$Record['ControlCode'],
                'ChartOfAccountTitle'=>$Record['ChartOfAccountTitle'],
                'ChartOfAccountCode'=>$Record['ChartOfAccountCode'],
                'ChartOfAccountAddedOn'=>date('Y-m-d H:i:s'),
                'ChartOfAccountAddedBy'=>$this->session->userdata('EmployeeId'),
                 );

                 $this->db->set($arrChartOfAccount);
                 $status = $this->db->insert('pos_accounts_chartofaccount');
             
              if($status)
              {
                    $ChartOfAccountId = $this->db->insert_id();
                    $arrAccount['ChartOfAccountId']=$ChartOfAccountId;
                    $this->db->set($arrAccount);
                    $status = $this->db->insert('pos_bank_accounts');
                    if($status)   
                        return $this->db->insert_id();
                    else{
                      //transection roll back
                    }
              }
              else    
              {
                  //transection rollback
              }
            }
            
        public function AddBank	($Record)
            {
             $this->db->set($Record);
             $status = $this->db->insert('pos_banks');
              if($status)
                 return('success');
              else    
              return('fail');
            }   
            
        function UpdateBank($Record,$id)
	{
              
              $this->db->where('BankId', $id);
              $status =  $this->db->update('pos_banks', $Record);
              if($status)
                 return('success');
              else    
              return('fail');
        }  

}
?>