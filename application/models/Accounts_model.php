<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Accounts_model extends CI_Model{
	
    function __construct()
    {
	parent::__construct();
	$this->pos_accounts = "pos_accounts";
	$this->tbl_accounts_group = "pos_accounts_group";
    }
   

    function GetAllAccountsGroup()
    {
        $this->db->select('*');
        $this->db->from('pos_accounts_group');
        $AllAccountsGroup = $this->db->get();
        return ($AllAccountsGroup->result_array());
    }
	
    
    function GetAllAccounts()
    {
        $this->db->select('*');
        $this->db->from('pos_accounts');
	    $this->db->join($this->tbl_accounts_group,'pos_accounts_group.AccountGroupId = pos_accounts.AccountGroupId');
        $GetAllAccounts = $this->db->get();
        return ($GetAllAccounts->result_array());
    }
    
    
    function GetAccounts($AccountId)
    {
       $this->db->select('*');
       $this->db->from('pos_accounts');
       $this->db->join($this->tbl_accounts_group,'pos_accounts_group.AccountGroupId = pos_accounts.AccountGroupId', 'left');
       $this->db->where('AccountId', $AccountId);
       $GetAccounts = $this->db->get();
       return $GetAccounts->row();
    }

    public function TotalRecord()
    {
        $this->db->select('*')->from('pos_accounts');
        $query = $this->db->get();
        return $query->num_rows();
    }

    
    public function SaveAccountDetail() 
    {
        $AccountData = array(
        	'AccountGroupId' => $this->input->post('AccountGroupId'),
        	'AccountName' => $this->input->post('AccountName'),
        	'CNIC' => $this->input->post('CNIC'),
        	'OpeningBalance' => $this->input->post('OpeningBalance'),
        	'Email' => $this->input->post('Email'),
        	'CellNo' => $this->input->post('CellNo'),
        	'PhoneNo' => $this->input->post('PhoneNo'),
        	'City' => $this->input->post('City'),
        	'Address' => $this->input->post('Address'),
        	'NTN' => $this->input->post('NTN'),
            'SalesTaxNo' => $this->input->post('SalesTaxNo'),
        	'AutoTransaction' => $this->input->post('AutoTransaction'),
        	'AddedOn' => date('Y-m-d H:i:s'),
            'AddedBy' => $this->session->userdata('EmployeeId')
	);
	
	$AccountId = $this->db->insert($this->pos_accounts,$AccountData);
        return $AccountId = $this->db->insert_id();
    }
	

    public function UpdateAccountDetail($data,$AccountId)
    {
	$AccountData = array(
    	'AccountGroupId' => $this->input->post('AccountGroupId'),
    	'AccountName' => $this->input->post('AccountName'),
    	'CNIC' => $this->input->post('CNIC'),
    	'OpeningBalance' => $this->input->post('OpeningBalance'),
    	'Email' => $this->input->post('Email'),
    	'CellNo' => $this->input->post('CellNo'),
    	'PhoneNo' => $this->input->post('PhoneNo'),
    	'City' => $this->input->post('City'),
    	'Address' => $this->input->post('Address'),
    	'NTN' => $this->input->post('NTN'),
    	'SalesTaxNo' => $this->input->post('SalesTaxNo'),
        'AutoTransaction' => $this->input->post('AutoTransaction'),
	    'AddedOn' => date('Y-m-d H:i:s'),
        'AddedBy' => $this->session->userdata('EmployeeId')
	);
	
        $this->db->where('AccountId',$AccountId);
        $this->db->update($this->pos_accounts,$data);
        return $AccountId;
    }

    
    public function DeleteAccount($AccountId)
    {
       $this->db->where('AccountId', $AccountId);
       $this->db->delete('pos_accounts');
       return true;
    }
     
        
}
?>