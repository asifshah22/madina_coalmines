<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class JournalTransaction_model extends CI_Model{
	
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
//    $result = $this->db->get('pos_journal_transaction' )->result_array();
//    $this->db->select('*');
//    $this->db->from('pos_journal_transaction');
//    $this->db->join('pos_accounts', 'pos_journal_transaction_detail.PaymentTo = pos_accounts.AccountId');
//    $this->db->join('pos_journal_transaction_detail', 'pos_journal_transaction.JournalTransactionId = pos_journal_transaction_detail.JournalTransactionId','left');
//    $this->db->join('pos_accounts', 'pos_accounts.AccountId = pos_journal_transaction_detail.PaymentTo', 'left');
//    $this->db->where('pos_journal_transaction_detail.JournalTransactionId', $VoucherId);
//    $this->db->where('TransactionType', '2');
//    $result = $this->db->get();
    $query = "SELECT * FROM `pos_journal_transaction` JOIN `pos_company` ON `pos_journal_transaction`.`CompanyId` = `pos_company`.`CompanyId` JOIN `pos_journal_transaction_detail` ON `pos_journal_transaction`.`JournalTransactionId` = `pos_journal_transaction_detail`.`JournalTransactionId` LEFT JOIN `pos_accounts` ON `pos_accounts`.`AccountId` = `pos_journal_transaction_detail`.`CreditAccountId` WHERE `TransactionType` = '2' AND `pos_journal_transaction_detail`.`JournalTransactionId` = '$VoucherId'";
    $result  = $this->db->query($query);
    return $result->result_array();
  }

   
  public function JournalNo()
  {
      $this->db->select("JournalNo");
      $this->db->from('pos_journal_transaction');
      $this->db->order_by('JournalTransactionId', 'DESC');
      $this->db->limit('1');
      $query = $this->db->get();
      if ($query->num_rows() > 0)
      {
      $row = $query->row();
      $RNo = $row->JournalNo;

      $iSplit = explode("JV", $RNo);
      $data['JournalNo'] = $iSplit[1];

      $JournalNo = $data['JournalNo'] + 1;
      $Prefix = 'JV';
      $NewJournalNo = $Prefix.''.$JournalNo;
      return $NewJournalNo;
      }
      else
      { 
      $Prefix = 'JV';
      $JournalNo = 1;
      $NewJournalNo = $Prefix.''.$JournalNo;
      return $NewJournalNo;
      } 
  }


  public function PaidJournalNo()
  {
      $this->db->select("JournalNo");
      $this->db->from('pos_journal_transaction');
      $this->db->where('TransactionType', '2');
      $this->db->order_by('JournalTransactionId', 'DESC');
      $this->db->limit('1');
      $query = $this->db->get();
      if ($query->num_rows() > 0)
      {
      $row = $query->row();
      $RNo = $row->JournalNo;

      $iSplit = explode("BPV", $RNo);
      $data['JournalNo'] = $iSplit[1];

      $JournalNo = $data['JournalNo'] + 1;
      $Prefix = 'BPV';
      $NewJournalNo = $Prefix.''.$JournalNo;
      return $NewJournalNo;
      }
      else
      { 
      $Prefix = 'BPV';
      $JournalNo = 1;
      $NewJournalNo = $Prefix.''.$JournalNo;
      return $NewJournalNo;
      } 
  }


  public function JournalTransactionDetail($VoucherId)
  {
    $this->db->select("*");
    $this->db->from('pos_journal_transaction');
    $this->db->join('pos_company', 'pos_journal_transaction.CompanyId = pos_company.CompanyId');
    $this->db->join('pos_journal_transaction_detail', 'pos_journal_transaction.JournalTransactionId = pos_journal_transaction_detail.JournalTransactionId');
    $this->db->join('pos_accounts', 'pos_accounts.AccountId = pos_journal_transaction_detail.DebitAccountId');
//    $this->db->join('pos_banks', 'pos_banks.BankId = pos_journal_transaction_detail.BankId');
    if($this->session->userdata('CompanyId')!=0){$this->db->where('pos_journal_transaction.CompanyId', $this->session->userdata('CompanyId'));}
    $this->db->where('pos_journal_transaction_detail.JournalTransactionId', $VoucherId);
    $result = $this->db->get();
    //$query = "SELECT * FROM `pos_journal_transaction` JOIN `pos_company` ON `pos_journal_transaction`.`CompanyId` = `pos_company`.`CompanyId` JOIN `pos_journal_transaction_detail` ON `pos_journal_transaction`.`JournalTransactionId` = `pos_journal_transaction_detail`.`JournalTransactionId` JOIN `pos_banks` ON `pos_banks`.`BankId` = `pos_journal_transaction_detail`.`BankId` LEFT JOIN `pos_accounts` ON `pos_accounts`.`AccountId` = `pos_journal_transaction_detail`.`CreditAccountId` WHERE `pos_journal_transaction_detail`.`JournalTransactionId` = '$VoucherId'";
   // $result  = $this->db->query($query);
    return $result->result_array();

  }

  public function GetJournalTransaction($VoucherId)
  {
    $this->db->select("*");
    $this->db->from('pos_journal_transaction');
    if($this->session->userdata('CompanyId')!=0){$this->db->where('pos_journal_transaction.CompanyId', $this->session->userdata('CompanyId'));}
    $this->db->where('pos_journal_transaction.JournalTransactionId', $VoucherId);
    $result = $this->db->get();
    return $result->row();
  }


  public function GetDebit($VoucherId)
  {
    $this->db->select("*");
    $this->db->from('pos_journal_transaction_detail');
    $this->db->join('pos_journal_transaction', 'pos_journal_transaction.JournalTransactionId = pos_journal_transaction_detail.JournalTransactionId');
    $this->db->join('pos_accounts', 'pos_accounts.AccountId = pos_journal_transaction_detail.DebitAccountId');
//    if($this->session->userdata('CompanyId')!=0){$this->db->where('CompanyId', $this->session->userdata('CompanyId'));}
    $this->db->where('pos_journal_transaction_detail.JournalTransactionId', $VoucherId);
    $result = $this->db->get();
    return $result->result_array();
  }


  public function GetCredit($VoucherId)
  {
    $this->db->select("*");
    $this->db->from('pos_journal_transaction_detail');
    $this->db->join('pos_accounts', 'pos_accounts.AccountId = pos_journal_transaction_detail.CreditAccountId');
    if($this->session->userdata('CompanyId')!=0){$this->db->where('CompanyId', $this->session->userdata('CompanyId'));}
    $this->db->where('pos_journal_transaction_detail.JournalTransactionId', $VoucherId);
    $result = $this->db->get();
    return $result->result_array();
  }
  
  function JournalTransaction()
  {
    $this->db->select('*');
    $this->db->from('pos_journal_transaction');
    $this->db->join('pos_journal_transaction_detail', 'pos_journal_transaction.JournalTransactionId = pos_journal_transaction_detail.JournalTransactionId');
    if ($this->session->userdata('CompanyId') != 0) {$this->db->where('CompanyId', $this->session->userdata('CompanyId'));}
    $this->db->group_by('pos_journal_transaction_detail.JournalTransactionId');
    $result = $this->db->get();
    return $result->result_array();
  }


  public function SaveJournalVoucher()
  {
    $JournalNo = $this->JournalNo();
    $Record = array(
      'JournalTransactionId' => '',
      'CompanyId' => $this->session->userdata('CompanyId'),
      'JournalNo' => $JournalNo,
      'JournalTransactionDate' => date('Y-m-d', strtotime($this->input->post('JournalTransactionDate'))),
      'AddedOn' => date('Y-m-d H:i:s'),
      'AddedBy' => $this->session->userdata('EmployeeId'),
    );

    $this->db->insert('pos_journal_transaction', $Record);
    $LastJournalId = $this->db->insert_id();

    $TotalCount = count($this->input->post('CreditAccountId'));

      for ($i=0; $i < $TotalCount; $i++) 
      {
      $data = array(
        'JournalTransactionDetailId' => '',
        'JournalTransactionId' => $LastJournalId,
        'DebitAccountId' => $this->input->post('DebitAccountId')[$i],
        'CreditAccountId' => $this->input->post('CreditAccountId')[$i],
        'Amount' => $this->input->post('Amount')[$i],
        'Description' => $this->input->post('Description')[$i],
      );
    $this->db->insert('pos_journal_transaction_detail', $data);
//      print_r($data);
      }
    return $LastJournalId;
//      die;
  }


  public function GetAllBanks()
  {
    $this->db->select("*");
    $this->db->from('pos_banks');
    $result = $this->db->get();
    return $result->result_array();
  }

  
  public function UpdateJournalVoucher($JournalTransactionId)
  {
    $Record = array(
      'JournalTransactionId' => $this->input->post('JournalTransactionId'),
      'CompanyId' => $this->session->userdata('CompanyId'),
      'JournalNo' => $this->input->post('JournalNo'),
      'JournalTransactionDate' => date('Y-m-d', strtotime($this->input->post('JournalTransactionDate'))),
      'AddedOn' => date('Y-m-d H:i:s'),
      'AddedBy' => $this->session->userdata('EmployeeId'),
    );

    $this->db->where('JournalTransactionId', $JournalTransactionId);
    $this->db->update('pos_journal_transaction', $Record);

    // Remove Transaction Detail Record Before Iserting New Record
    $this->db->where('pos_journal_transaction_detail.JournalTransactionId', $JournalTransactionId);
    $this->db->delete('pos_journal_transaction_detail');

    $TotalCount = count($this->input->post('CreditAccountId'));

      for ($i=0; $i < $TotalCount; $i++) 
      {
      $data = array(
        'JournalTransactionDetailId' => '',
        'JournalTransactionId' => $JournalTransactionId,
        'DebitAccountId' => $this->input->post('DebitAccountId')[$i],
        'CreditAccountId' => $this->input->post('CreditAccountId')[$i],
        'Amount' => $this->input->post('Amount')[$i],
        'Description' => $this->input->post('Description')[$i],
      );
    $this->db->insert('pos_journal_transaction_detail', $data);
      }
    return $JournalTransactionId;
  }


  public function DeleteJournalTransaction($JournalTransactionId)
  {
      $this->db->where('JournalTransactionId',$JournalTransactionId);
      
      $this->db->where('JournalTransactionId', $JournalTransactionId);
      $this->db->delete('pos_journal_transaction');

      // Remove Transaction Detail Record Before Iserting New Record
      $this->db->where('pos_journal_transaction_detail.JournalTransactionId', $JournalTransactionId);
      $this->db->delete('pos_journal_transaction_detail');
      return true;
  }

}
?>