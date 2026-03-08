<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Area_model extends CI_Model{
	
	function __construct(){
	
		parent::__construct();
		$this->tbl_area = "pos_area";
		$this->tbl_setting = "pos_setting";
		$this->tbl_accounts_chartofaccount_controls = "pos_accounts_chartofaccount_controls";
		$this->tbl_accounts_chartofaccount = "pos_accounts_chartofaccount";
	}
    
    function GetAllAreas()
    {
	$this->db->select('*');
	$this->db->from($this->tbl_area);
    $this->db->order_by("Area_name", "asc");
	$GetAllAreas = $this->db->get();
        return ($GetAllAreas->result_array());   
    }
    
	
    public function SaveAreaDetail($Record,$AreaId=0)
    {

        if($AreaId==0)
        {       
        
            $arrArea = array(
            'Area_name' => $Record['Area_name'],
            'created_at' => date("Y-m-d H:i:s"),
            ); 
            $StatsAccount = $this->db->insert($this->tbl_area,$arrArea);
            if($StatsAccount){

                return $this->db->insert_id();
            }
     
        }
        else
        {                   
            
            $arrArea = array(
                'Area_name' => $Record['Area_name'],
                'created_at' => date("Y-m-d H:i:s"),
                ); 
                $this->db->where('id',$AreaId);
                $StatArea = $this->db->update($this->tbl_area,$arrArea);
                if($StatArea)
                return 'success';
           
        }
    }

	
       public function UpdateCustomerDetail($data,$CustomerId)
       {   
	   $this->db->select('ChartOfAccountTitle');
	   $this->db->from('pos_accounts_chartofaccount');
	   $this->db->where('ChartOfAccountId',$data['ChartOfAccountId']);
	   $query = $this->db->get();
	    
	   if ($query->num_rows() > 0)
	   {
	      $UpdateCustomerName = array('ChartOfAccountTitle' => $data['CustomerName']);	       
	      $this->db->where('ChartOfAccountId',$data['ChartOfAccountId']);
	      $this->db->update($this->tbl_accounts_chartofaccount,$UpdateCustomerName);
	   }
	   else
	   {
	       redirect("Customer/");
	   }
	    
	   $CustomerDetail = array(
	   'CustomerName'=>$data['CustomerName'],
	   'ContactName'=>$data['ContactName'],
	   'Address'=>$data['Address'],
	   'Email'=>$data['Email'],
	   'PhoneNo'=>$data['PhoneNo'],
	   'CellNo'=>$data['CellNo'],
	   'FaxNo'=>$data['FaxNo'],
	   'Website'=>$data['Website'],
	   );
	   
	   $this->db->where('CustomerId',$CustomerId);
	   $StatsCustomer = $this->db->update($this->tbl_customer,$CustomerDetail);
	   return 'success';   
       }
    
	    
    public function Ajax_GetAllAreas($requestData)
    {
      // storing  request (ie, get/post) global array to a variable  
                $columns = array( 
                // datatable column index  => database column name
                        0 => 'Area_name',
                         );
                // getting total number records without any search
                $sql = "SELECT id,Area_name ";
                $sql .="FROM pos_area ";
//                $sql .="FROM pos_customer AS C INNER JOIN pos_division AS DIV ON DIV.DivisionId = C.DivisionId";      
                $query= $this->db->query($sql); 
                $totalData = $query->num_rows();
                $totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.
				$sql.=" WHERE 1 = 1 ";
		
                $sql = "SELECT id,Area_name "; //$sql .="FROM pos_customer AS C";
				$sql.=" FROM pos_area ";
                
		if( !empty($requestData['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter
                       $sql.="Where ( Area_name LIKE '%".$requestData['search']['value']."%' )";    
                }
                //print_r($columns);
                //echo $columns[$requestData['order'][0]['column']];
                //die;
                $query=$this->db->query( $sql) ;
                $totalFiltered = $query->num_rows(); // when there is a search parameter then we have to modify total number filtered rows as per search result. 
                $sql.=" ORDER BY Area_name ". "  LIMIT ".$requestData['start']." ,".$requestData['length']."   ";
//                $sql.=" ORDER BY pos_customer.CustomerName DESC "."   ";
                /* $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc  */	
                $query=$this->db->query($sql);  
                 $array['record'] = $query->result_array();
                $array['recordsFiltered'] = $totalFiltered;
                $array['recordsTotal'] = $totalData;
                
                return $array;
     
    }
     
    function GetArea($id,$columns='*')
    {
         $this->db->select($columns);
         $this->db->from('pos_area');
         $this->db->where('id',$id);
         $result = $this->db->get();
        return ($result->row());
    }
    
    
}
?>