<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class AccountsGroup_model extends CI_Model{
	
    function __construct(){
	
		parent::__construct();
		$this->tbl_pos_accounts_group = "pos_accounts_group";
    }
	
        
    function GetAllAccountGroups()
    {
        $this->db->select('*')->from('pos_accounts_group');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function TotalRecord()
    {
        $this->db->select('*')->from('pos_accounts_group');
        $query = $this->db->get();
        return $query->num_rows();
    }
	
    public function GetAccountGroupById($NewAccountGroupId)
     {
        if ($NewAccountGroupId === 0)
        {
            $query = $this->db->get('pos_accounts_group');
            return $query->result_array();
        }
				
		$this->db->select('*');
		$this->db->from($this->tbl_pos_accounts_group);
		$this->db->where('pos_accounts_group.AccountGroupId',$NewAccountGroupId);
		$query = $this->db->get();
		return $query->row();
     }
	
	public function SaveAccountGroup($array,$id=0) 
        {
            $this->load->helper('url');
            if($id == 0)
            {
                $this->db->insert($this->tbl_pos_accounts_group,$array);
                return $NewAccountGroupId = intval($this->db->insert_id());
            }
            else
            {
               $this->db->where('AccountGroupId',$id);
               if($this->db->update('pos_accounts_group',$array))
               return $id;
            }    
        }

    public function DeleteAccountGroup($AccountGroupId)
    {
        $this->db->where('AccountGroupId',$AccountGroupId);
        $this->db->delete('pos_accounts_group');
        return true;
    }
}
?>