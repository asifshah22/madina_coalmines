<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class BankTransaction_model extends CI_Model{
	
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

  function GetPaymentVoucher($VoucherId)
  {
//    $result = $this->db->get('pos_bank_transaction' )->result_array();
//    $this->db->select('*');
//    $this->db->from('pos_bank_transaction');
//    $this->db->join('pos_accounts', 'pos_bank_transaction_detail.PaymentTo = pos_accounts.AccountId');
//    $this->db->join('pos_bank_transaction_detail', 'pos_bank_transaction.BankTransactionId = pos_bank_transaction_detail.BankTransactionId','left');
//    $this->db->join('pos_accounts', 'pos_accounts.AccountId = pos_bank_transaction_detail.PaymentTo', 'left');
//    $this->db->where('pos_bank_transaction_detail.BankTransactionId', $VoucherId);
//    $this->db->where('TransactionType', '2');
//    $result = $this->db->get();
    $query = "SELECT * FROM `pos_bank_transaction` JOIN `pos_company` ON `pos_bank_transaction`.`CompanyId` = `pos_company`.`CompanyId` JOIN `pos_bank_transaction_detail` ON `pos_bank_transaction`.`BankTransactionId` = `pos_bank_transaction_detail`.`BankTransactionId` LEFT JOIN `pos_accounts` ON `pos_accounts`.`AccountId` = `pos_bank_transaction_detail`.`PaymentToId` WHERE `TransactionType` = '2' AND `pos_bank_transaction_detail`.`BankTransactionId` = '$VoucherId'";
    $result  = $this->db->query($query);
    return $result->result_array();
  }

   
  public function ReferenceNo()
  {
      $this->db->select("ReferenceNo");
      $this->db->from('pos_bank_transaction');
      $this->db->where('TransactionType', '1');
      $this->db->order_by('BankTransactionId', 'DESC');
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


  public function PaidReferenceNo()
  {
      $this->db->select("ReferenceNo");
      $this->db->from('pos_bank_transaction');
      $this->db->where('TransactionType', '2');
      $this->db->order_by('BankTransactionId', 'DESC');
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


  public function BankTransactionDetail($VoucherId)
  {
    $this->db->select("*");
    $this->db->from('pos_bank_transaction');
    $this->db->join('pos_company', 'pos_bank_transaction.CompanyId = pos_company.CompanyId');
    $this->db->join('pos_bank_transaction_detail', 'pos_bank_transaction.BankTransactionId = pos_bank_transaction_detail.BankTransactionId');
    $this->db->join('pos_accounts', 'pos_accounts.AccountId = pos_bank_transaction_detail.PaymentFromId');
    $this->db->join('pos_banks', 'pos_banks.BankId = pos_bank_transaction_detail.BankId');
    if($this->session->userdata('CompanyId')!=0){$this->db->where('pos_bank_transaction.CompanyId', $this->session->userdata('CompanyId'));}
    $this->db->where('pos_bank_transaction_detail.BankTransactionId', $VoucherId);
    $result = $this->db->get();
    //$query = "SELECT * FROM `pos_bank_transaction` JOIN `pos_company` ON `pos_bank_transaction`.`CompanyId` = `pos_company`.`CompanyId` JOIN `pos_bank_transaction_detail` ON `pos_bank_transaction`.`BankTransactionId` = `pos_bank_transaction_detail`.`BankTransactionId` JOIN `pos_banks` ON `pos_banks`.`BankId` = `pos_bank_transaction_detail`.`BankId` LEFT JOIN `pos_accounts` ON `pos_accounts`.`AccountId` = `pos_bank_transaction_detail`.`PaymentToId` WHERE `pos_bank_transaction_detail`.`BankTransactionId` = '$VoucherId'";
   // $result  = $this->db->query($query);
    return $result->result_array();

  }

  public function GetBankTransaction($VoucherId)
  {
    $this->db->select("*");
    $this->db->from('pos_bank_transaction');
    if($this->session->userdata('CompanyId')!=0){$this->db->where('pos_bank_transaction.CompanyId', $this->session->userdata('CompanyId'));}
    $this->db->where('pos_bank_transaction.BankTransactionId', $VoucherId);
    $result = $this->db->get();
    return $result->row();
  }


  public function GetFrom($VoucherId)
  {
    $this->db->select("*");
    $this->db->from('pos_bank_transaction_detail');
    $this->db->join('pos_accounts', 'pos_accounts.AccountId = pos_bank_transaction_detail.PaymentFromId', 'left');
    if($this->session->userdata('CompanyId')!=0){$this->db->where('CompanyId', $this->session->userdata('CompanyId'));}
    $this->db->where('pos_bank_transaction_detail.BankTransactionId', $VoucherId);
    $result = $this->db->get();
    return $result->result_array();
  }


  public function GetTo($VoucherId)
  {
    $this->db->select("*");
    $this->db->from('pos_bank_transaction_detail');
    $this->db->join('pos_accounts', 'pos_accounts.AccountId = pos_bank_transaction_detail.PaymentToId', 'left');
//    if($this->session->userdata('CompanyId')!=0){$this->db->where('CompanyId', $this->session->userdata('CompanyId'));}
    $this->db->where('pos_bank_transaction_detail.BankTransactionId', $VoucherId);
    $result = $this->db->get();
    return $result->result_array();
  }
  
  function BankVoucher()
  {
    $this->db->select('*');
    $this->db->from('pos_bank_transaction');
    $this->db->join('pos_bank_transaction_detail', 'pos_bank_transaction.BankTransactionId = pos_bank_transaction_detail.BankTransactionId');
    if ($this->session->userdata('CompanyId') != 0) {$this->db->where('CompanyId', $this->session->userdata('CompanyId'));}
    $this->db->group_by('pos_bank_transaction_detail.BankTransactionId');
    $result = $this->db->get();
    return $result->result_array();
  }


  public function SaveVoucher()
  {
    $ReferenceNo;
    if($this->input->post('TransactionType') == "1"){
      $ReferenceNo = $this->ReferenceNo();
    }
    else{
      $ReferenceNo = $this->PaidReferenceNo();
    }
    $Record = array(
      'BankTransactionId' => '',
      'CompanyId' => $this->session->userdata('CompanyId'),
      'TransactionType' => $this->input->post('TransactionType'),
      'ReferenceNo' => $ReferenceNo,
      'TransactionDate' => date('Y-m-d', strtotime($this->input->post('TransactionDate'))),
      'AddedOn' => date('Y-m-d H:i:s'),
      'AddedBy' => $this->session->userdata('EmployeeId'),
    );

    $this->db->insert('pos_bank_transaction', $Record);
    $LastTransactionId = $this->db->insert_id();

    $TotalCount = count($this->input->post('PaymentToId'));

      for ($i=0; $i < $TotalCount; $i++) 
      {
      $data = array(
        'BankTransactionDetailId' => '',
        'BankTransactionId' => $LastTransactionId,
        'PaymentFromId' => $this->input->post('PaymentFromId')[$i],
        'PaymentToId' => $this->input->post('PaymentToId')[$i],
        'BankId' => $this->input->post('BankId')[$i],
        'ChequeNumber' => $this->input->post('ChequeNumber')[$i],
        'Amount' => $this->input->post('Amount')[$i],
        'Description' => $this->input->post('Description')[$i],
      );
    $this->db->insert('pos_bank_transaction_detail', $data);
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

  
  public function UpdateVoucher($BankTransactionId)
  {
    $Record = array(
      'BankTransactionId' => $this->input->post('BankTransactionId'),
      'CompanyId' => $this->session->userdata('CompanyId'),
      'TransactionType' => $this->input->post('TransactionType'),
      'ReferenceNo' => $this->input->post('ReferenceNo'),
      'TransactionDate' => date('Y-m-d', strtotime($this->input->post('TransactionDate'))),
      'AddedOn' => date('Y-m-d H:i:s'),
      'AddedBy' => $this->session->userdata('EmployeeId'),
    );

    $this->db->where('BankTransactionId', $BankTransactionId);
    $this->db->update('pos_bank_transaction', $Record);

    // Remove Transaction Detail Record Before Iserting New Record
    $this->db->where('pos_bank_transaction_detail.BankTransactionId', $BankTransactionId);
    $this->db->delete('pos_bank_transaction_detail');

    $TotalCount = count($this->input->post('PaymentToId'));

      for ($i=0; $i < $TotalCount; $i++) 
      {
      $data = array(
        'BankTransactionDetailId' => '',
        'BankTransactionId' => $BankTransactionId,
        'PaymentFromId' => $this->input->post('PaymentFromId')[$i],
        'PaymentToId' => $this->input->post('PaymentToId')[$i],
        'BankId' => $this->input->post('BankId')[$i],
        'ChequeNumber' => $this->input->post('ChequeNumber')[$i],
        'Amount' => $this->input->post('Amount')[$i],
        'Description' => $this->input->post('Description')[$i],
      );
    $this->db->insert('pos_bank_transaction_detail', $data);
      }
    return $BankTransactionId;
  }

}
?>