<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class COA_model extends CI_Model{
	
	function __construct()
	{
		parent::__construct();
               // $this->output->enable_profiler();
	}
	
	function GetAllChartOfAccount()
	{ 
      $this->db->select('*');
      $this->db->from('pos_accounts_chartofaccount');
      $this->db->join('pos_accounts_chartofaccount_categories', 'pos_accounts_chartofaccount_categories.ChartOfAccountCategoryId = pos_accounts_chartofaccount.ChartOfAccountCategoryId');
      $result = $this->db->get()->result_array();
      return $result;

    }
   	function GetChartOfAccount($COA_Id,$colums='*')
	 {
        $this->db->select($colums);
        $this->db->from('pos_accounts_chartofaccount');
        $this->db->join('pos_accounts_chartofaccount_categories', 'pos_accounts_chartofaccount_categories.ChartOfAccountCategoryId = pos_accounts_chartofaccount.ChartOfAccountCategoryId');
        $this->db->join('pos_accounts_chartofaccount_controls', 'pos_accounts_chartofaccount_controls.ChartOfAccountControlId = pos_accounts_chartofaccount.ChartOfAccountControlId');
        $this->db->where('ChartOfAccountId',$COA_Id);
        $result = $this->db->get()->row();
        return $result;
    }

    function GetAllCategories()
	  {
        $result = $this->db->get('pos_accounts_chartofaccount_categories')->result_array();
        return $result;
    }
        
        function GetAllControlCodes()
	{
	     $this->db->select('*');
	    $this->db->from('pos_accounts_chartofaccount_controls');
	    $result = $this->db->get()->result_array();
	    return $result;
	    
              //  $result = $this->db->get('pos_accounts_chartofaccount_controls')->result_array();
               // return $result;
        }

/*        function GetControlCodeByCategoryId($id)
	{
                $result = $this->db->get_where('pos_accounts_chartofaccount_controls',array('ChartOfAccountCategoryId'=>$id) )->result_array();
                return $result;
        }
        */

        function GetControlCodeByCategoryId($id)
  {
/*
            $result = $this->db->get_where('pos_accounts_chartofaccount_controls',array('ChartOfAccountCategoryId'=>$id) )->result_array();
            return $result;*/
            $this->db->select('*');
            $this->db->from('pos_accounts_chartofaccount_controls');
            $this->db->where('pos_accounts_chartofaccount_controls.ChartOfAccountCategoryId', $id);
            $result = $this->db->get();
            return ($result->result_array());
        }
        
  function GetChartOfAccountByControlCodeId($id)
	{
      $result = $this->db->get_where('pos_accounts_chartofaccount',array('ChartOfAccountControlId'=>$id))->result_array();
        return $result;
  }
        
    function GetControlCode($id)
	  {
        $result = $this->db->get_where('pos_accounts_chartofaccount_controls',array('ChartOfAccountControlId'=>$id) )->row();
        return $result;
    }
        
    function GetChartOfAccountCode($id)
	  {
                $this->db->select('(ChartOfAccountCode) AS COA_Code,ChartOfAccountId,ChartOfAccountTitle,ChartOfAccountCategoryId,ChartOfAccountControlId');
                $this->db->from('pos_accounts_chartofaccount');
                $this->db->where('ChartOfAccountControlId',$id);
                $this->db->order_by("ChartOfAccountCode","desc");
                $this->db->limit(1);
//                echo $this->db->get_compiled_select();
//                die;
                $result = $this->db->get();
                if($result->num_rows()<=0)
                {

                    $this->db->select('StartRange AS COA_Code,ChartOfAccountCategoryId,ChartOfAccountControlId','ChartOfAccountId','ChartOfAccountTitle');
                    $this->db->from('pos_accounts_chartofaccount_controls');
                    $this->db->where('ChartOfAccountControlId',$id);
                   // echo $this->db->get_compiled_select();
                    //die;
                    return $result = $this->db->get()->row();
                    
                }
               else
                return $result->row();
        }

        function Ajax_GetAllChartOfAccount($requestData)
        {
                $columns = array( 
                // datatable column index  => database column name //ChartOfAccountTitle,AccountNumber,BankAbbreviation,BranchCode
                        0 => 'ChartOfAccountId',
                        1 => 'CategoryCode', 
                        2 => 'ControlCode',
                        3 => 'ChartOfAccountCode',
                        4 => 'ChartOfAccountTitle',
                );
       
                // getting total number records without any search
                $sql = "SELECT ChartOfAccountId,CategoryCode,CategoryName,ControlCode,ChartOfAccountCode,ChartOfAccountTitle ";
                $sql.="FROM pos_accounts_chartofaccount ";
                $sql.=" INNER JOIN pos_accounts_chartofaccount_categories ON pos_accounts_chartofaccount_categories.ChartOfAccountCategoryId = pos_accounts_chartofaccount.ChartOfAccountCategoryId";
                $sql.=" INNER JOIN pos_accounts_chartofaccount_controls ON pos_accounts_chartofaccount_controls.ChartOfAccountControlId = pos_accounts_chartofaccount.ChartOfAccountControlId";
                $query= $this->db->query($sql); 
                $totalData = $query->num_rows();
                $totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.
                
       
                $sql = "SELECT ChartOfAccountId,CategoryCode,CategoryName,ControlCode,ChartOfAccountCode,ChartOfAccountTitle ";
                $sql.="FROM pos_accounts_chartofaccount ";
                $sql.=" INNER JOIN pos_accounts_chartofaccount_categories ON pos_accounts_chartofaccount_categories.ChartOfAccountCategoryId = pos_accounts_chartofaccount.ChartOfAccountCategoryId";
                $sql.=" INNER JOIN pos_accounts_chartofaccount_controls ON pos_accounts_chartofaccount_controls.ChartOfAccountControlId = pos_accounts_chartofaccount.ChartOfAccountControlId";
                $sql.=" WHERE 1=1 ";
                if( !empty($requestData['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter
                       $sql.=" AND ( CategoryCode LIKE '".$requestData['search']['value']."%' ";
                       $sql.=" OR  ControlCode LIKE '".$requestData['search']['value']."%' "; 
                       $sql.=" OR  ChartOfAccountCode LIKE '".$requestData['search']['value']."%' "; 
                       $sql.=" OR ChartOfAccountTitle LIKE '".$requestData['search']['value']."%' )";  
                }
                //print_r($columns);
                //echo $columns[$requestData['order'][0]['column']];
                $query=$this->db->query( $sql) ;
                $totalFiltered = $query->num_rows(); // when there is a search parameter then we have to modify total number filtered rows as per search result. 
                $sql.=" ORDER BY ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']."  LIMIT ".$requestData['start']." ,".$requestData['length']."   ";
                /* $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc  */	
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
                $this->db->where('pos_bank_accounts.AccountId', $id);
                $result = $this->db->get()->row();
              
                return $result;
        }
           function UpdateAccount($record,$id)
	{
            
              $this->db->where('AccountId', $id);
              $status =  $this->db->update('pos_bank_accounts', $record);
              if($status)
                 return('success');
              else    
              return('fail');
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

      public function SaveChartOfAccount($Record,$id)
      {
          if($id != 0)
          {
		$this->db->where('ChartOfAccountId',$id);
		$status = $this->db->update('pos_accounts_chartofaccount',$Record);
		if($status)
		{
		   return('success');
		} else
		{
		   return('fail');
		}
          }
          else
          {
		$this->db->set($Record);
		$status = $this->db->insert('pos_accounts_chartofaccount');
		if($status)
		{
		   return $this->db->insert_id();
		} else    
		{
		    return false;
		}
          }
      }
           
      
        public function AddControlCode	($Record)
            {
             $this->db->set($Record);
             $status = $this->db->insert('pos_accounts_chartofaccount_controls');
              if($status)
                 return('success');
              else    
              return('fail');
            }   
            
        public function UpdateControlCode($Record,$id)
	{
              
              $this->db->where('ChartOfAccountControlId', $id);
              $status =  $this->db->update('pos_accounts_chartofaccount_controls', $Record);
              if($status)
                 return('success');
              else    
              return('fail');
        }
	
	public function NextChartOfAccountCode($ChartOfAccountControlId,$COA_Code)
        {
	    $query =  $this->db->select('*')->from('pos_accounts_chartofaccount')->where('ChartOfAccountControlId',$ChartOfAccountControlId)->get()->result_array();
            $TotalRecord = count($query);
            if($TotalRecord == 0)
            return($COA_Code);
	    
	    $result =  $this->db->select('StartRange,EndRange')->from('pos_accounts_chartofaccount_controls')->Where('ChartOfAccountControlId',$ChartOfAccountControlId)->get()->row();
            $NewCOA_Code = $COA_Code +1;
	    
	    // Cast to an array first. The reason is, that an object is an object and there is no useful definition of "an empty object"
	    $TempResult = (array) $result;
	    if(!empty($TempResult))
	    {
		return $NewCOA_Code;
	    }
	    
            $StartRange =$result->StartRange;
            $EndRange =$result->EndRange;
	   
            if($NewCOA_Code >= $StartRange && $NewCOA_Code<=$EndRange)
	    {
               return $NewCOA_Code;
	    }
	    else
	    {
               return "Control Code range is full";
	    }
        }
	
        public function NextChartOfAccountCode___($ChartOfAccountControlId,$COA_Code)
        {
            $query =  $this->db->select('*')->from('pos_accounts_chartofaccount')->where('ChartOfAccountControlId',$ChartOfAccountControlId)->get()->result_array();
            $TotalRecord = count($query);
            if($TotalRecord == 0)
                return($COA_Code);

            $result =  $this->db->select('StartRange,EndRange')->from('pos_accounts_chartofaccount_controls')->Where('ChartOfAccountControlId',$ChartOfAccountControlId)->get()->row();
            $NewCOA_Code = $COA_Code +1;
            
	    if (count($result) ==1 )
            return $NewCOA_Code;
            $StartRange =$result->StartRange;
            $EndRange =$result->EndRange;
            
	    if($NewCOA_Code >= $StartRange && $NewCOA_Code<=$EndRange)
                return $NewCOA_Code;
            else
               return "Control Code range is full";
        } 

}
?>