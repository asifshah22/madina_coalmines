<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Vendor_model extends CI_Model{
	
	function __construct(){
	
		parent::__construct();
		$this->tbl_vendor = "pos_vendor";
		$this->tbl_setting = "pos_setting";
		$this->tbl_accounts_chartofaccount_controls = "pos_accounts_chartofaccount_controls";
		$this->tbl_accounts_chartofaccount = "pos_accounts_chartofaccount";
                
	}
    
    function GetAllVendors()
    {
       // $this->db->select('BankId, BankName');
       // $this->db->from($this->tbl_company);
    	$this->db->select('*')->from('pos_vendor');
        $GetAllVendors = $this->db->get();
        return ($GetAllVendors->result_array());
        
    }
	

	public function SaveVendorDetail($array) 
    {
     	$arrChartOfAccount = array(
            'ChartOfAccountCategoryId'=>$array['ChartOfAccountCategoryId'],
            'ChartOfAccountControlId'=>$array['ChartOfAccountControlId'],
            'ChartOfAccountTitle'=>$array['ChartOfAccountTitle'],
            'ChartOfAccountCode'=>$array['ChartOfAccountCode'],
    	);

        $this->db->set($arrChartOfAccount);
        $status = $this->db->insert('pos_accounts_chartofaccount');
        if($status)
        {
            $ChartOfAccountId = $this->db->insert_id();
                $arrVendor = array(
                'VendorName'=>$array['VendorName'],
                'ContactName'=>$array['ContactName'],
                'Email'=>$array['Email'],
                'Address'=> $array['Address'], 
                'PhoneNo'=>$array['PhoneNo'],
                'CellNo'=>$array['CellNo'],
                'NTN'=>$array['NTN'],
                'ChartOfAccountId'=>$ChartOfAccountId,
                'AddedOn' => date('Y-m-d H:i:s'),
	    		'AddedBy' => $this->session->userdata('EmployeeId'),
                );
            $this->db->insert($this->tbl_vendor,$arrVendor);
            return $this->db->insert_id();
        }
            
	}


    public function UpdateVendorDetail($array,$id) {
	
        $arrChartOfAccount = array(
            'ChartOfAccountCategoryId'=>$array['ChartOfAccountCategoryId'],
            'ChartOfAccountControlId'=>$array['ChartOfAccountControlId'],
            'ChartOfAccountTitle'=>$array['ChartOfAccountTitle'],
            'ChartOfAccountCode'=>$array['ChartOfAccountCode'],
        );

            $this->db->where('ChartOfAccountId',$array['ChartOfAccountId']);
            $status = $this->db->update('pos_accounts_chartofaccount',$arrChartOfAccount);
         
            if($status)
            {
               
                $ChartOfAccountId = $this->db->insert_id();
                $arrVendor = array(
                'VendorName'=>$array['VendorName'],
                'ContactName'=>$array['ContactName'],
                'Email'=>$array['Email'],
                'Address'=> $array['Address'],   
                'PhoneNo'=>$array['PhoneNo'],
                'CellNo'=>$array['CellNo'],
                'NTN'=>$array['NTN'],
                'ChartOfAccountId'=>$array['ChartOfAccountId'],
                'AddedOn' => date('Y-m-d H:i:s'),
	    		'AddedBy' => $this->session->userdata('EmployeeId'),
                );

                $this->db->where('VendorId',$id)->update($this->tbl_vendor,$arrVendor);
            
            }
            return $status;	
	}
        


   	public function UpdateVendorDetail______($data,$VendorId)
	{
		$this->db->select('ChartOfAccountTitle');
		$this->db->from('pos_accounts_chartofaccount');
		$this->db->where('ChartOfAccountId',$data['ChartOfAccountId']);
		$query = $this->db->get();

		if ($query->num_rows() > 0)
		{
		   $UpdateVendorName = array('ChartOfAccountTitle' => $data['VendorName']);   
		   $this->db->where('ChartOfAccountId',$data['ChartOfAccountId']);
		   $this->db->update($this->tbl_accounts_chartofaccount,$UpdateVendorName);
		}
		else
		{
		    redirect("Vendor/");
		}
	
		$VendorDetail = array(	
		'VendorName'=>$data['VendorName'],
		'ContactName'=>$data['ContactName'],
		'Address'=>$data['Address'],
		'Email'=>$data['Email'],
		'PhoneNo'=>$data['PhoneNo'],
		'CellNo'=>$data['CellNo'],
	    'NTN'=>$data['NTN'],
		'AddedOn' => date('Y-m-d H:i:s'),
		'AddedBy' => $this->session->userdata('EmployeeId'),
		);
	
		$this->db->where('VendorId',$VendorId);
		$this->db->update($this->tbl_vendor,$VendorDetail);
		
		return $VendorId;
	    }
	
	
    
    public function Ajax_GetAllVendors($requestData)
    {
      // storing  request (ie, get/post) global array to a variable  
                $columns = array( 
                // datatable column index  => database column name
                        0 => 'VendorName',
                        1 => 'VendorId', 
                        2 => 'ContactName',
                        3 => 'Email',
                        4 => 'PhoneNo', );
                // getting total number records without any search
                $sql = "SELECT VendorId,VendorName,ContactName,Email,PhoneNo ";
                $sql .="FROM pos_vendor ";
                $query= $this->db->query($sql); 
                $totalData = $query->num_rows();
                $totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.
				$sql.=" WHERE 1=1 ";
       /*
                $sql = "SELECT VendorId,VendorName,ContactName,Email,PhoneNo "; //$sql .="FROM pos_vendor AS C";
                $sql .="FROM pos_vendor WHERE 1=1 ";*/
		
                if( !empty($requestData['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter
                       $sql.=" AND ( VendorName LIKE '".$requestData['search']['value']."%' ";    
                       $sql.=" OR ContactName LIKE '".$requestData['search']['value']."%' ";
                       $sql.=" OR PhoneNo LIKE '".$requestData['search']['value']."%' ";
                       $sql.=" OR Email LIKE '".$requestData['search']['value']."%' )";  
                }
                //print_r($columns);
                //echo $columns[$requestData['order'][0]['column']];
				//echo $requestData['order'][0]['dir'];
                
                $query=$this->db->query( $sql) ;
                $totalFiltered = $query->num_rows(); // when there is a search parameter then we have to modify total number filtered rows as per search result. 
                $sql.=" ORDER BY VendorName "." LIMIT ".$requestData['start']." ,".$requestData['length']."   ";
                /* $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc  */	
                $query=$this->db->query($sql);  
                $array['record'] = $query->result_array();
                $array['recordsFiltered'] = $totalFiltered;
                $array['recordsTotal'] = $totalData;
                
                return $array;
     
    }
     
    function GetVendor($id,$columns='*')
    {
         $this->db->select($columns);
         $this->db->from('pos_vendor');
         $this->db->join('pos_accounts_chartofaccount','pos_accounts_chartofaccount.ChartOfAccountId =pos_vendor.ChartOfAccountId');
         $this->db->where('VendorId',$id);
         $result = $this->db->get();
        return ($result->row());
    }
    
    function GetVendorById($id,$columns='*')
    {   
        $finalResult = array();
        $Vendors = array();
        if($id == 0){
            $this->db->select('*');
            $this->db->from('pos_vendor');
            $this->db->order_by("VendorName", "asc");
            $GetAllVendor = $this->db->get();
            $Vendors = $GetAllVendor->result_array(); 
        }else{

            $this->db->select($columns);
            $this->db->from('pos_vendor');
            $this->db->where('ChartOfAccountId',$id);
            $result = $this->db->get();
            $Vendors = $result->result_array();
        }
        
        $i =0;
        foreach($Vendors as $vendor){
            
            $finalResult[$i]['VendorId']          = $vendor['VendorId'];
            $finalResult[$i]['ChartOfAccountId']  = $vendor['ChartOfAccountId'];
            $finalResult[$i]['AreaName']          = "";
            $finalResult[$i]['ContactName']       = $vendor['ContactName'];
            $finalResult[$i]['CellNo']            = $vendor['CellNo'];
            $finalResult[$i]['Address']           = $vendor['Address'];
        $i++;
        }
         return $finalResult;
    }
     
    
}
?>