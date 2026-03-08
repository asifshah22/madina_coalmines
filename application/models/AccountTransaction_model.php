<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class AccountTransaction_model extends CI_Model{
	
	function __construct()
	{
		parent::__construct();
    $this->tbl_banks = "pos_banks";
	}
        
	function GetAllAccounts()
	{
    $result = $this->db->get('pos_accounts' );
    if ($this->session->userdata('CompanyId') != 0) {$this->db->where('CompanyId', $this->session->userdata('CompanyId'));}
    return $result->result_array();
  }

  public function AllAccountTransaction()
  {
    $result = $this->db->select("*")->from('pos_accounts_transaction')->get();
    return $result->result_array();
  }

   
  public function BRVReferenceNo()
  {
      $this->db->select("ReferenceNo");
      $this->db->from('pos_accounts_transaction');
      $this->db->where('TransactionType', '1');
      $this->db->order_by('AccountTransactionId', 'DESC');
      $this->db->limit('1');
      $query = $this->db->get();
      if ($query->num_rows() > 0)
      {
      $row = $query->row();
      $RNo = $row->ReferenceNo;

      $iSplit = explode("BRV", $RNo);
      $data['ReferenceNo'] = $iSplit[1];

      $ReferenceNo = $data['ReferenceNo'] + 1;
      $Prefix = 'BRV';
      $NewReferenceNo = $Prefix.''.$ReferenceNo;
      return $NewReferenceNo;
      }
      else
      { 
      $Prefix = 'BRV';
      $ReferenceNo = 1;
      $NewReferenceNo = $Prefix.''.$ReferenceNo;
      return $NewReferenceNo;
      } 
  }


  public function BPVReferenceNo()
  {
      $this->db->select("ReferenceNo");
      $this->db->from('pos_accounts_transaction');
      $this->db->where('TransactionType', '2');
      $this->db->order_by('AccountTransactionId', 'DESC');
      $this->db->limit('1');
      $query = $this->db->get();
      if ($query->num_rows() > 0)
      {
      $row = $query->row();
      $RNo = $row->ReferenceNo;

      $iSplit = explode("BPV", $RNo);
      $data['ReferenceNo'] = $iSplit[1];

      $ReferenceNo = $data['ReferenceNo'] + 1;
      $Prefix = 'BPV';
      $NewReferenceNo = $Prefix.''.$ReferenceNo;
      return $NewReferenceNo;
      }
      else
      { 
      $Prefix = 'BPV';
      $ReferenceNo = 1;
      $NewReferenceNo = $Prefix.''.$ReferenceNo;
      return $NewReferenceNo;
      } 
  }


  public function CRVReferenceNo()
  {
      $this->db->select("ReferenceNo");
      $this->db->from('pos_accounts_transaction');
      $this->db->where('TransactionType', '3');
      $this->db->order_by('AccountTransactionId', 'DESC');
      $this->db->limit('1');
      $query = $this->db->get();
      if ($query->num_rows() > 0)
      {
      $row = $query->row();
      $RNo = $row->ReferenceNo;

      $iSplit = explode("CRV", $RNo);
      $data['ReferenceNo'] = $iSplit[1];

      $ReferenceNo = $data['ReferenceNo'] + 1;
      $Prefix = 'CRV';
      $NewReferenceNo = $Prefix.''.$ReferenceNo;
      return $NewReferenceNo;
      }
      else
      { 
      $Prefix = 'CRV';
      $ReferenceNo = 1;
      $NewReferenceNo = $Prefix.''.$ReferenceNo;
      return $NewReferenceNo;
      } 
  }

  
  public function CPVReferenceNo()
  {
      $this->db->select("ReferenceNo");
      $this->db->from('pos_accounts_transaction');
      $this->db->where('TransactionType', '4');
      $this->db->order_by('AccountTransactionId', 'DESC');
      $this->db->limit('1');
      $query = $this->db->get();
      if ($query->num_rows() > 0)
      {
      $row = $query->row();
      $RNo = $row->ReferenceNo;

      $iSplit = explode("CPV", $RNo);
      $data['ReferenceNo'] = $iSplit[1];

      $ReferenceNo = $data['ReferenceNo'] + 1;
      $Prefix = 'CPV';
      $NewReferenceNo = $Prefix.''.$ReferenceNo;
      return $NewReferenceNo;
      }
      else
      { 
      $Prefix = 'CPV';
      $ReferenceNo = 1;
      $NewReferenceNo = $Prefix.''.$ReferenceNo;
      return $NewReferenceNo;
      } 
  }


  public function JVReferenceNo()
  {
      $this->db->select("ReferenceNo");
      $this->db->from('pos_accounts_transaction');
      $this->db->where('TransactionType', '5');
      $this->db->order_by('AccountTransactionId', 'DESC');
      $this->db->limit('1');
      $query = $this->db->get();
      if ($query->num_rows() > 0)
      {
      $row = $query->row();
      $RNo = $row->ReferenceNo;

      $iSplit = explode("JV", $RNo);
      $data['ReferenceNo'] = $iSplit[1];

      $ReferenceNo = $data['ReferenceNo'] + 1;
      $Prefix = 'JV';
      $NewReferenceNo = $Prefix.''.$ReferenceNo;
      return $NewReferenceNo;
      }
      else
      { 
      $Prefix = 'JV';
      $ReferenceNo = 1;
      $NewReferenceNo = $Prefix.''.$ReferenceNo;
      return $NewReferenceNo;
      } 
  }


  public function GetAccountTransaction($AccountTransactionId)
  {
    $this->db->select("*");
    $this->db->from('pos_accounts_transaction');
    if($this->session->userdata('CompanyId')!=0){$this->db->where('pos_accounts_transaction.CompanyId', $this->session->userdata('CompanyId'));}
    $this->db->where('pos_accounts_transaction.AccountTransactionId', $AccountTransactionId);
    $result = $this->db->get();
    return $result->row();
  }


  public function AccountTransactionDetail($AccountTransactionId)
  {
    $this->db->select("*");
    $this->db->from('pos_accounts_transaction');
    $this->db->join('pos_company', 'pos_accounts_transaction.CompanyId = pos_company.CompanyId', 'left');
    $this->db->join('pos_accounts_transaction_detail', 'pos_accounts_transaction.AccountTransactionId = pos_accounts_transaction_detail.AccountTransactionId', 'left');
    $this->db->join('pos_accounts', 'pos_accounts.AccountId = pos_accounts_transaction_detail.AccountId', 'left');
//    $this->db->join('pos_banks', 'pos_banks.BankId = pos_accounts_transaction_detail.BankId', 'left');
//    $this->db->join('pos_stocks_detail', 'pos_stocks_detail.ProductId = pos_accounts_transaction_detail.ProductId', 'left');
    $this->db->join('pos_products', 'pos_products.ProductId = pos_accounts_transaction_detail.ProductId', 'left');
    if($this->session->userdata('CompanyId')!=0){$this->db->where('pos_accounts_transaction.CompanyId', $this->session->userdata('CompanyId'));}
    $this->db->where('pos_accounts_transaction_detail.AccountTransactionId', $AccountTransactionId);
    $result = $this->db->get();
    return $result->result_array();
  }


  public function DebitId($AccountTransactionId) // from
  {
    $this->db->select("*");
    $this->db->from('pos_accounts_transaction_detail');
    $this->db->join('pos_accounts', 'pos_accounts.AccountId = pos_accounts_transaction_detail.AccountId', 'left');
//    if($this->session->userdata('CompanyId')!=0){$this->db->where('CompanyId', $this->session->userdata('CompanyId'));}
    $this->db->where('pos_accounts_transaction_detail.AccountTransactionId', $AccountTransactionId);
    $result = $this->db->get();
    return $result->result_array();
  }


  public function CreditId($AccountTransactionId) //to
  {
    $this->db->select("*");
    $this->db->from('pos_accounts_transaction_detail');
    $this->db->join('pos_accounts', 'pos_accounts.AccountId = pos_accounts_transaction_detail.AccountId', 'left');
//    if($this->session->userdata('CompanyId')!=0){$this->db->where('CompanyId', $this->session->userdata('CompanyId'));}
    $this->db->where('pos_accounts_transaction_detail.AccountTransactionId', $AccountTransactionId);
    $result = $this->db->get();
    return $result->result_array();
  }
  
  function BankVoucher()
  {
    $this->db->select('*');
    $this->db->from('pos_accounts_transaction');
    $this->db->join('pos_accounts_transaction_detail', 'pos_accounts_transaction.AccountTransactionId = pos_accounts_transaction_detail.AccountTransactionId');
    if ($this->session->userdata('CompanyId') != 0) {$this->db->where('CompanyId', $this->session->userdata('CompanyId'));}
    $this->db->group_by('pos_accounts_transaction_detail.AccountTransactionId');
    $result = $this->db->get();
    return $result->result_array();
  }


  public function SaveAccountTransaction()
  {
    $ReferenceNo = "";
    if($this->input->post('TransactionType') == "1"){
      $ReferenceNo = $this->BRVReferenceNo();}
    if($this->input->post('TransactionType') == "2"){
      $ReferenceNo = $this->BPVReferenceNo();}
    if($this->input->post('TransactionType') == "3"){
      $ReferenceNo = $this->CRVReferenceNo();}
    if($this->input->post('TransactionType') == "4"){
      $ReferenceNo = $this->CPVReferenceNo();}
    if($this->input->post('TransactionType') == "5"){
      $ReferenceNo = $this->JVReferenceNo();}

      $TotalDebit = array_sum($this->input->post('DebitAmount'));
      $TotalCredit = array_sum($this->input->post('CreditAmount'));

    $Record = array(
      'AccountTransactionId' => '',
      'CompanyId' => $this->session->userdata('CompanyId'),
      'TransactionType' => $this->input->post('TransactionType'),
      'ReferenceNo' => $ReferenceNo,
      'TransactionDate' => date('Y-m-d', strtotime($this->input->post('TransactionDate'))),
      'TotalDebit' => $TotalDebit,
      'TotalCredit' => $TotalCredit,
      'AddedOn' => date('Y-m-d H:i:s'),
      'AddedBy' => $this->session->userdata('EmployeeId'),
    );

    $this->db->insert('pos_accounts_transaction', $Record);
    $LastTransactionId = $this->db->insert_id();

    $TotalCount = count($this->input->post('AccountId'));

      for ($i=0; $i < $TotalCount; $i++) 
      {
      $data = array(
        'AccountTransactionDetailId' => '',
        'AccountTransactionId' => $LastTransactionId,
        'AccountId' => $this->input->post('AccountId')[$i],
        'BankId' => $this->input->post('BankId')[$i],
        'ChequeNumber' => $this->input->post('ChequeNumber')[$i],
        'DebitAmount' => $this->input->post('DebitAmount')[$i],
        'CreditAmount' => $this->input->post('CreditAmount')[$i],
        'Description' => $this->input->post('Description')[$i],
      );
      $this->db->insert('pos_accounts_transaction_detail', $data);
      }

    return $LastTransactionId;
  }


  public function GetAllBanks()
  {
    $this->db->select("*");
    $this->db->from('pos_banks');
    $result = $this->db->get();
    return $result->result_array();
  }

  
  public function UpdateAccountTransaction($AccountTransactionId)
  {
    $Record = array(
      'AccountTransactionId' => $this->input->post('AccountTransactionId'),
      'CompanyId' => $this->session->userdata('CompanyId'),
      'TransactionType' => $this->input->post('TransactionType'),
      'ReferenceNo' => $this->input->post('ReferenceNo'),
      'TransactionDate' => date('Y-m-d', strtotime($this->input->post('TransactionDate'))),
      'AddedOn' => date('Y-m-d H:i:s'),
      'AddedBy' => $this->session->userdata('EmployeeId'),
    );

    $this->db->where('AccountTransactionId', $AccountTransactionId);
    $this->db->update('pos_accounts_transaction', $Record);

    // Remove Transaction Detail Record Before Iserting New Record
    $this->db->where('pos_accounts_transaction_detail.AccountTransactionId', $AccountTransactionId);
    $this->db->delete('pos_accounts_transaction_detail');

    $TotalCount = count($this->input->post('AccountId'));

      for ($i=0; $i < $TotalCount; $i++) 
      {
      $data = array(
        'AccountTransactionDetailId' => '',
        'AccountTransactionId' => $AccountTransactionId,
        'AccountId' => $this->input->post('AccountId')[$i],
        'BankId' => $this->input->post('BankId')[$i],
        'ChequeNumber' => $this->input->post('ChequeNumber')[$i],
        'DebitAmount' => $this->input->post('DebitAmount')[$i],
        'CreditAmount' => $this->input->post('CreditAmount')[$i],
        'Description' => $this->input->post('Description')[$i],
      );
    $this->db->insert('pos_accounts_transaction_detail', $data);

      }
    return $AccountTransactionId;
  }

}
?>