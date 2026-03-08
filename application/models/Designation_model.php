<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Designation_model extends CI_Model{
	
	function __construct(){
	
		parent::__construct();
		$this->tbl_designation = "pos_designations";
		$this->tbl_company = "pos_company";
	}
	
    function GetAllDesignations()
    {
        $this->db->select('*');
        $this->db->from($this->tbl_designation);
        $query = $this->db->get();
        return $query->result_array();
    }
    
    public function Ajax_GetAllDesignations($requestData)
    {
               $columns = array( 
                        0 => 'DesignationId',
                        1 => 'DesignationName',
                );
                $sql = "SELECT DesignationId,DesignationName";
                $sql.=" FROM pos_designations";
                //die($sql);
                $query= $this->db->query($sql); 
                //die('test');
                $totalData = $query->num_rows();
                $totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.
                $sql.=" WHERE 1=1 ";
                if( !empty($requestData['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter
                       $sql.=" AND (DesignationId LIKE '".$requestData['search']['value']."%' ";
                       $sql.=" OR  DesignationName LIKE '".$requestData['search']['value']."%' )";
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

        public function GetDesignation($DesignationId=0)
        {
	    
            if ($DesignationId == 0)
            {
                $this->db->select('*');
                $this->db->from($this->tbl_designation);
                $query = $this->db->get();
                return $query->result_array();
            }
            else
            {				
		$this->db->select('pos_designations.DesignationId,pos_designations.DesignationName,pos_designations.AddedOn');
		$this->db->from($this->tbl_designation);
		$this->db->where('pos_designations.DesignationId',$DesignationId);
		$query = $this->db->get();
		return $query->row();
            }
	    
        }
	
	public function SaveDesignationDetail()
	{
	    
	    $DesignationRecord = array(
	    'DesignationName' => $this->input->post('DesignationName'),
	    'AddedOn' => date('Y-m-d H:i:s'),
	    'AddedBy' => $this->session->userdata('EmployeeId'),
	    );
	    
	    $this->db->insert($this->tbl_designation,$DesignationRecord);
        return $NewDesignationId = $this->db->insert_id();
	}
		
	
	public function UpdateDesignationDetail($DesignationId)
	{
        $DesignationRecord = array(
	   'DesignationName' => $this->input->post('DesignationName'),
	    );

	     $this->db->where('DesignationId',$DesignationId);
	     $this->db->update($this->tbl_designation,$DesignationRecord);
	     return $DesignationId;
	}
	

    public function DeleteDesignation($DesignationId)
    {
        try{
        $query = $this->db->where('DesignationId', $DesignationId)->delete('pos_designations');
        if(!$query){
          throw new Exception('error in query');
          return false;
        }
        return $query;
        } catch (Exception $e) {
            return;
        }
/*        return false;
        }
        return true;*/
    }
    
    
    
    
    
    /*
        
     public function GetRoles()
	{
            $query = $this->db->query("SELECT * FROM pos_roles WHERE pos_roles.ParantRoleId = 0");
            return $query->result_array();
        }
        
	
        public function GetDesignationRoles($DesignationId)
	{
            $this->db->select('d.DesignationId,r.RoleId,r.RoleFor,r.ParantRoleId,dr.DesignationRoleId,r.RoleName,dr.ViewRoles,dr.AddRoles,dr.UpdateRoles,dr.DeleteRoles');
            $this->db->from('pos_designations_roles dr');
            $this->db->join('pos_roles r', 'r.RoleId = dr.RoleId');
            $this->db->join('pos_designations d', 'd.DesignationId = dr.DesignationId');
            $this->db->where('d.DesignationId',$DesignationId);
            $this->db->order_by('r.ParantRoleId', 'asc');
            $this->db->order_by('r.RoleOrder', 'asc');
            $query = $this->db->get();
            return $query->result_array();
        }
        
	
        function UpdatetDesignationRoles($DesignationId, $RoleId, $RoleName)
        {
          $query = $this->db->query("UPDATE pos_designations_roles set ".$RoleName." = 1 WHERE pos_designations_roles.RoleId = '".$RoleId."' AND pos_designations_roles.DesignationId = '".$DesignationId."'");
          return TRUE;
        }
        
	
        function UpdatetDesignationRolesZero($DesignationId, $RoleId, $RoleName)
        {            
          $query = $this->db->query("UPDATE pos_designations_roles set ".$RoleName." = 0 WHERE pos_designations_roles.RoleId = '".$RoleId."' AND pos_designations_roles.DesignationId = '".$DesignationId."'");
          return TRUE;
        }
	*/
}
?>