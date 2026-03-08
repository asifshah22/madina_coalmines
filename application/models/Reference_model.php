<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Reference_model extends CI_Model{
	
    function __construct(){
	
		parent::__construct();
		$this->tbl_reference = "pos_references";
    }
	
        
    function GetAllReference()
    {
        $this->db->select('*')->from($this->tbl_reference);
        $query = $this->db->get();
        return $query->result_array();
    }

    function GetReferencesWithCondition($requestData)
    {
       // storing  request (ie, get/post) global array to a variable  
                $columns = array( 
                // datatable column index  => database column name
                        0 =>'ReferenceId',
                        1 =>'FullName', 
                        2 =>'ContactNumber',
                        3 =>'Email',
                        4 =>'Address',
                );
                // getting total number records without any search
                $sql = "SELECT ReferenceId,FullName,ContactNumber,Email,Address ";
                $sql.=" FROM pos_references";
                $query= $this->db->query($sql); 
                $totalData = $query->num_rows();
                $totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.
       
				$sql = "SELECT ReferenceId,FullName,ContactNumber,Email,Address ";
                $sql.=" FROM pos_references";
                if( !empty($requestData['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter
                $sql.=" AND ( FullName LIKE '".$requestData['search']['value']."%' ";
                $sql.=" OR  ContactNumber LIKE '".$requestData['search']['value']."%' "; 
                $sql.=" OR  Email LIKE '".$requestData['search']['value']."%' "; 
                $sql.=" OR  Address LIKE '".$requestData['search']['value']."%' )"; 
                }
                //print_r($columns);
                //echo $columns[$requestData['order'][0]['column']];
                //die;
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

	
    public function GetReferenceById($NewReferenceId)
     {
        if ($NewReferenceId === 0)
        {
            $query = $this->db->get('pos_references');
            return $query->result_array();
        }
				
		$this->db->select('*');
		$this->db->from($this->tbl_reference);
		$this->db->where('pos_references.ReferenceId',$NewReferenceId);
		$query = $this->db->get();
		return $query->row();
     }
	
	public function SaveReference($data,$id=0) 
        {
            $this->load->helper('url');
            if($id ==0)
            {
                $this->db->insert($this->tbl_reference,$data);
                return $NewReferenceId = intval($this->db->insert_id());
            }
            else
            {
               $this->db->where('ReferenceId',$id);
               if($this->db->update('pos_references',$data))
               return $id;
            }    
        }
	
	public function UpdateReferenceDetail($Data)
        {
	    $Data['AddedOn'] = date('Y-m-d H:i:s');
	    $Data['AddedBy'] = $this->session->userdata('UserId');
	    
	    $this->db->where('ReferenceId',$Data['ReferenceId']);
	    $this->db->update($this->tbl_reference,$Data);
	    return $Data['ReferenceId'];
	}
}
?>