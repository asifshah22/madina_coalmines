<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Employee_model extends CI_Model{
	
	function __construct(){
		parent::__construct();
		$this->tbl_employee = "pos_employees";
        $this->tbl_designation = "pos_designations";
        $this->tbl_user_roles = "pos_users_roles";
//        $this->output->enable_profiler(TRUE);
	}

        public function Ajax_GetAllEmployees($requestData)
        {
               $columns = array( 
                        0 => 'EmployeeName', 
                        1 => 'DesignationName',
                        2 => 'EmailAddress',
                        3 => 'CellNo',
                );
                $sql = "SELECT EmployeeId,EmployeeName,DesignationName,EmailAddress,CellNo";
                $sql.=" FROM pos_employees";
                $sql.=" JOIN pos_designations ON pos_employees.DesignationId = pos_designations.DesignationId";
                //die($sql);
                $query= $this->db->query($sql); 
                //die('test');
                $totalData = $query->num_rows();
                $totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.
                $sql.=" WHERE 1=1 ";
                if( !empty($requestData['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter
                       $sql.=" AND (EmployeeName LIKE '".$requestData['search']['value']."%' ";
                       $sql.=" OR  EmailAddress LIKE '".$requestData['search']['value']."%' ";
                       $sql.=" OR  CellNo LIKE '".$requestData['search']['value']."%' ";
                      // $sql.=" OR  EmployeeName LIKE '".$requestData['search']['value']."%' )";  
                }
                $query=$this->db->query( $sql) ;
                $totalFiltered = $query->num_rows(); // when there is a search parameter then we have to modify total number filtered rows as per search result. 
                $sql.=" ORDER BY EmployeeName ". "  LIMIT ".$requestData['start']." ,".$requestData['length']."   ";
                $query=$this->db->query($sql);  
                
                $array['record'] = $query->result_array();
                $array['recordsFiltered'] = $totalFiltered;
                $array['recordsTotal'] = $totalData;
                return $array;
        }
	
    function GetAllEmployees($colmun='*')
    {
        $this->db->select($colmun)->from($this->tbl_employee);
        $this->db->join($this->tbl_designation,'pos_designations.DesignationId=pos_employees.DesignationId', 'INNER');
//        $this->db->where('EmployeeType !=', 1);
        $query = $this->db->get();
        return $query->result_array();
    }

    function GetCompanyEmployees($colmun='*')
    {
        $this->db->select($colmun)->from($this->tbl_employee);
        $this->db->join($this->tbl_designation,'pos_designations.DesignationId=pos_employees.DesignationId', 'INNER');
        $this->db->where('EmployeeType', 3);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function GetSettingInformation()
    {
      $this->db->select('*')->from('pos_setting');
      $query = $this->db->get();
      return $query->result_array();
    }        
        
    function GetEmployee($EmployeeId, $colmun='*')
	{             
           $this->db->select($colmun)->from($this->tbl_employee)->where('EmployeeId',$EmployeeId);
           $this->db->join($this->tbl_designation,'pos_designations.DesignationId=pos_employees.DesignationId', 'left');
           return $this->db->get()->row();
    }
    

  public function SaveEmployee($EmployeeId=0) 
        {
            $EmployeeData = $this->input->post();
            $EmployeeData['JoiningDate'] = date('Y-m-d', strtotime($EmployeeData['JoiningDate']));
            $EmployeeData['Status'] = 1;
            $EmployeeData['AddedOn'] = date('Y-m-d H:i:s');
            $EmployeeData['AddedBy'] = $this->session->userdata('EmployeeId');

            if($EmployeeId == 0)
            {
               $this->db->insert($this->tbl_employee,$EmployeeData);
               $NewEmployeeId = intval($this->db->insert_id());
               
               // Gets Roles and insert into employee roles table
               $query = $this->db->query("SELECT * FROM pos_employee_type_roles WHERE pos_employee_type_roles.EmployeeTypeId = '".$EmployeeData['EmployeeType']."'");
               $RoleIds = $query->result_array();

               foreach($RoleIds as $Record) {
               $EmployeeRoles = array(
               'EmployeeId' => $NewEmployeeId,
               'RoleId' => $Record['RoleId'],
               'ViewRoles' => $Record['ViewRoles'],
               'AddRoles' => $Record['AddRoles'],
               'UpdateRoles' => $Record['UpdateRoles'],
               'DeleteRoles' => $Record['DeleteRoles']
                );
                $Sucess = $this->db->insert('pos_employees_roles', $EmployeeRoles);
                }                 
               return $NewEmployeeId;
            }
            else if($EmployeeId != 0)
            {
               $this->db->where('EmployeeId',$EmployeeId);
               $this->db->update($this->tbl_employee,$EmployeeData);
               return $EmployeeId;
            }
  }
		
	public function SaveEmployee__($Record, $EmployeeId = 0) 
        {
            $EmployeeData = $this->input->post();
            $EmployeeData['JoiningDate'] = date('Y-m-d', strtotime($EmployeeData['JoiningDate']));
            $EmployeeData['AddedOn'] = date('Y-m-d H:i:s');
            $EmployeeData['AddedBy'] = $this->session->userdata('EmployeeId');

            if($EmployeeId == 0)
            {               
               $this->db->insert($this->tbl_employee,$EmployeeData);
               $NewEmployeeId = intval($this->db->insert_id());
               
               // Gets Roles and insert into employee roles table
               $query = $this->db->query("SELECT * FROM pos_designations_roles WHERE pos_designations_roles.DesignationId = '".$EmployeeData['DesignationId']."'");
               $RoleIds = $query->result_array();
               
               foreach($RoleIds as $Record) {
               $EmployeeRoles = array(
               'EmployeeId' => $NewEmployeeId,
               'RoleId' => $Record['RoleId'],
               'ViewRoles' => $Record['ViewRoles'],
               'AddRoles' => $Record['AddRoles'],
               'UpdateRoles' => $Record['UpdateRoles'],
               'DeleteRoles' => $Record['DeleteRoles']
                );
                $Sucess = $this->db->insert('pos_employees_roles', $EmployeeRoles);
                }                 
               return $NewEmployeeId;
            }
        }

    public function UpdateEmployee($EmployeeId) 
        {
            $EmployeeData = $this->input->post();
            $EmployeeData['JoiningDate'] = date('Y-m-d', strtotime($EmployeeData['JoiningDate']));
            $EmployeeData['Status'] = 1;
            $EmployeeData['AddedOn'] = date('Y-m-d H:i:s');
            $EmployeeData['AddedBy'] = $this->session->userdata('EmployeeId');
           $this->db->where('EmployeeId',$EmployeeId);
           $this->db->update($this->tbl_employee,$EmployeeData);
           return $EmployeeId;
        }

    public function DeleteEmployee($EmployeeId) 
    {
           $this->db->where('EmployeeId',$EmployeeId);
           $this->db->delete($this->tbl_employee);
           return true;
    }

        
        public function GetRoles()
	{
            $query = $this->db->query("SELECT * FROM pos_roles WHERE pos_roles.ParantRoleId = 0");
            return $query->result_array();
        }
         
     
        public function GetEmployeeRoles($EmployeeId)
	{
            $this->db->select('e.EmployeeId, r.RoleId,r.RoleFor,r.ParantRoleId,er.EmployeeRoleId,r.RoleName,er.ViewRoles,er.AddRoles,er.UpdateRoles,er.DeleteRoles');
            $this->db->from('pos_employees_roles er');
            $this->db->join('pos_roles r', 'r.RoleId = er.RoleId');
            $this->db->join('pos_employees e', 'e.EmployeeId = er.EmployeeId');
            $this->db->where('e.EmployeeId',$EmployeeId);
            $this->db->order_by('r.ParantRoleId', 'asc');
            $this->db->order_by('r.RoleOrder', 'asc');
            $query = $this->db->get();
   //         print_r($query->result_array());
            return $query->result_array();
        }  
        
        
        
        public function GetAdministrationRoles($EmployeeId)
	{
            $this->db->select('e.EmployeeId, r.RoleId, r.RoleName, er.EmployeeRoleId, er.ViewRoles, er.AddRoles, er.UpdateRoles, er.DeleteRoles');
            $this->db->from('pos_employees_roles er');
            $this->db->join('pos_roles r', 'r.RoleId = er.RoleId');
            $this->db->join('pos_employees e', 'e.EmployeeId = er.EmployeeId');
            $this->db->where('e.EmployeeId',$EmployeeId);
            $this->db->where('r.ParantRoleId',1);
            $query = $this->db->get();
            return $query->result_array();
        }
        
        
        public function GetSalesRoles($EmployeeId)
	{
            $this->db->select('e.EmployeeId, r.RoleId, r.RoleName, er.EmployeeRoleId, er.ViewRoles, er.AddRoles, er.UpdateRoles, er.DeleteRoles');
            $this->db->from('pos_employees_roles er');
            $this->db->join('pos_roles r', 'r.RoleId = er.RoleId');
            $this->db->join('pos_employees e', 'e.EmployeeId = er.EmployeeId');
            $this->db->where('e.EmployeeId',$EmployeeId);
            $this->db->where('r.ParantRoleId',16);
            $query = $this->db->get();
            return $query->result_array();
        }
        
        
        public function GetPurchasesRoles($EmployeeId)
	{
            $this->db->select('e.EmployeeId, r.RoleId, r.RoleName, er.EmployeeRoleId, er.ViewRoles, er.AddRoles, er.UpdateRoles, er.DeleteRoles');
            $this->db->from('pos_employees_roles er');
            $this->db->join('pos_roles r', 'r.RoleId = er.RoleId');
            $this->db->join('pos_employees e', 'e.EmployeeId = er.EmployeeId');
            $this->db->where('e.EmployeeId',$EmployeeId);
            $this->db->where('r.ParantRoleId',20);
            $query = $this->db->get();
            return $query->result_array();
        }
                
        
        public function GetRegistrationRoles($EmployeeId)
	{
            $this->db->select('e.EmployeeId, r.RoleId, r.RoleName, er.EmployeeRoleId, er.ViewRoles, er.AddRoles, er.UpdateRoles, er.DeleteRoles');
            $this->db->from('pos_employees_roles er');
            $this->db->join('pos_roles r', 'r.RoleId = er.RoleId');
            $this->db->join('pos_employees e', 'e.EmployeeId = er.EmployeeId');
            $this->db->where('e.EmployeeId',$EmployeeId);
            $this->db->where('r.ParantRoleId',13);
            $query = $this->db->get();
            return $query->result_array();
        }
	
	
	public function GetTransactionRoles($EmployeeId)
	{
            $this->db->select('e.EmployeeId, r.RoleId, r.RoleName, er.EmployeeRoleId, er.ViewRoles, er.AddRoles, er.UpdateRoles, er.DeleteRoles');
            $this->db->from('pos_employees_roles er');
            $this->db->join('pos_roles r', 'r.RoleId = er.RoleId');
            $this->db->join('pos_employees e', 'e.EmployeeId = er.EmployeeId');
            $this->db->where('e.EmployeeId',$EmployeeId);
            $this->db->where('r.ParantRoleId',20);
            $query = $this->db->get();
            return $query->result_array();
        }


        
        public function GetReportsRoles($EmployeeId)
	      {
            $this->db->select('e.EmployeeId, r.RoleId, r.RoleName, er.EmployeeRoleId, er.ViewRoles, er.AddRoles, er.UpdateRoles, er.DeleteRoles');
            $this->db->from('pos_employees_roles er');  
            $this->db->join('pos_roles r', 'r.RoleId = er.RoleId');
            $this->db->join('pos_employees e', 'e.EmployeeId = er.EmployeeId');
            $this->db->where('e.EmployeeId',$EmployeeId);
            $this->db->where('r.ParantRoleId',24);
            $query = $this->db->get();
            return $query->result_array();
        }
        
        public function UpdatetEmployeeRoles($EmployeeId, $RoleId, $RoleName)
        {
/*          echo $RoleName . "<br>";
          echo $RoleId;
          die;*/
          $query = $this->db->query("UPDATE pos_employees_roles set ".$RoleName." = 1 WHERE pos_employees_roles.RoleId = '".$RoleId."' AND pos_employees_roles.EmployeeId = '".$EmployeeId."'");
       //     $query = $this->db->query("UPDATE pos_employees_roles set ".$RoleName." = 1 WHERE pos_employees_roles.EmployeeRoleId = '".$RoleValue."'");
            return TRUE;
        }

        public function UpdateEmployeeRolesZero($EmployeeId, $RoleId, $RoleName)
        {
            $query = $this->db->query("UPDATE pos_employees_roles set ".$RoleName." = 0 WHERE pos_employees_roles.RoleId = '".$RoleId."' AND pos_employees_roles.EmployeeId = '".$EmployeeId."'");
           // $query = $this->db->query("UPDATE pos_employees_roles set ".$RoleName." = 0 WHERE pos_employees_roles.EmployeeRoleId = '".$RoleValue."'");
            return TRUE;
        }
        
}       
?>