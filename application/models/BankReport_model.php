<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class BankReport_model extends CI_Model{
	
	function __construct(){
	
		parent::__construct();
		$this->tbl_banks = "pos_banks";
        $this->tbl_company = "pos_company";
                
	}
    
    public function GetBankReport($CompanyId, $BankId)
    {
        $this->db->select("*");
        $this->db->from('pos_company');
        $this->db->join('pos_Banks', 'pos_company.CompanyId = pos_Banks.CompanyId', 'left');
        if($CompanyId != 0){$this->db->where('pos_banks.CompanyId', $CompanyId);}
        if($BankId != 0){$this->db->where('pos_banks.BankId', $BankId);}
        $query = $this->db->get();
        return $query->result_array();
    }
	
     
        
}
?>