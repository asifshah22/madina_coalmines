<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class CashTransaction_model extends CI_Model{
	
	function __construct()
	{
		parent::__construct();
		$this->tbl_company = "pos_company";
		$this->tbl_account = "pos_accounts";
		$this->tbl_cash_transaction = "pos_cash_transaction";
		$this->tbl_cash_transaction_detail = "pos_cash_transaction_detail";
	}

	
	/* Cash Payment Transactions Functions */ 
        
        function AllCashTransactions()
        {
            $this->db->select('*');
            $this->db->from($this->tbl_cash_transaction);
            if ($this->session->userdata('CompanyId') != 0){$this->db->where('pos_cash_transaction.CompanyId', $this->session->userdata('CompanyId'));}
            $CashPaymentTransactions = $this->db->get();
            return ($CashPaymentTransactions->result_array());
        }
	
	
	function GetCashTransaction($CashTransactionId)
        {
            $this->db->select('*');
            $this->db->from($this->tbl_cash_transaction);
            $this->db->join($this->tbl_cash_transaction_detail, $this->tbl_cash_transaction_detail.'.CashTransactionId = '.$this->tbl_cash_transaction.'.CashTransactionId');
            if ($this->session->userdata('CompanyId') != 0){$this->db->where('pos_cash_transaction.CompanyId', $this->session->userdata('CompanyId'));}
            $this->db->where('pos_cash_transaction_detail.CashTransactionId',$CashTransactionId);
	    $CashPaymentTransactionsView = $this->db->get();
            return ($CashPaymentTransactionsView->row());
        }
	
	
	function GetCashTransactionDetail($CashTransactionId)
        {
            $this->db->select('*');
            $this->db->from($this->tbl_cash_transaction_detail);
	    $this->db->join($this->tbl_account, $this->tbl_account.'.AccountId = '.$this->tbl_cash_transaction_detail.'.AccountId');
            //if ($this->session->userdata('CompanyId') != 0){$this->db->where('pos_cash_transaction.CompanyId', $this->session->userdata('CompanyId'));}
            $this->db->where('pos_cash_transaction_detail.CashTransactionId',$CashTransactionId);
	    $CashPaymentTransactionsDetailView = $this->db->get();
            return ($CashPaymentTransactionsDetailView->result_array())	;
        }
        
	
	public function SaveCashTransactionDetail() 
        {
        $RefNo;
	    if($this->input->post('TransactionType') == "1"){
    	$RefNo = $this->GenerateAutoCRVRefNo();
	    }
	    else{
	      $RefNo = $this->GenerateAutoRefNo();
	    }
	    
	    $TotalAmount = array_sum($this->input->post('Amount'));
	
	    $CashPayment = array(
	    'CompanyId' => $this->session->userdata('CompanyId'),
	    'TransactionType' => $this->input->post('TransactionType'),
	    'TransactionDate' => date('Y-m-d', strtotime($this->input->post('TransactionDate'))),
	    'ReferenceNo' => $RefNo,
	    'TotalAmount' => $TotalAmount,
	    'AddedOn' => date('Y-m-d H:i:s'),
	    'AddedBy' => $this->session->userdata('EmployeeId'),
	    );

	    $this->db->insert($this->tbl_cash_transaction, $CashPayment);
	    $CashTransactionId = intval($this->db->insert_id());

	    $AccountId = $this->input->post('AccountId');

	    foreach($AccountId as $key=>$value) 
	    {
		$CashPaymentDetail = array(
		'CashTransactionId' => $CashTransactionId,
		'AccountId' => $this->input->post('AccountId')[$key],
		'Description' => $this->input->post('Description')[$key],
		'Amount' => $this->input->post('Amount')[$key],
		);
		
		$Sucess = $this->db->insert($this->tbl_cash_transaction_detail, $CashPaymentDetail);
	   }
	     if(isset($Sucess)) { return $CashTransactionId; }
	}
	
	
	public function UpdateCashTransactionDetail($CashTransactionId)
        {
	    
	    $TotalAmount = array_sum($this->input->post('Amount'));
	
	    $CashPayment = array(
	    'TransactionDate' => date('Y-m-d', strtotime($this->input->post('TransactionDate'))),
	    'TotalAmount' => $TotalAmount,
	    'AddedOn' => date('Y-m-d H:i:s'),
	    'AddedBy' => $this->session->userdata('EmployeeId'),
	    );
	    
        $this->db->where('CashTransactionId',$CashTransactionId);
        $this->db->update($this->tbl_cash_transaction,$CashPayment);
	    
	    // delete cash transaction detail record before entering new
	    $this->db->where('CashTransactionId', $CashTransactionId);
	    $this->db->delete($this->tbl_cash_transaction_detail);

	    $AccountId = $this->input->post('AccountId');
	    for($i=0; $i < count($this->input->post('AccountId')); $i++) 
	    {
		$CashPaymentDetail = array(
		'CashTransactionId' => $CashTransactionId,
		'AccountId' => $this->input->post('AccountId')[$i],
		'Description' => $this->input->post('Description')[$i],
		'Amount' => $this->input->post('Amount')[$i],
		);
		
		$Sucess = $this->db->insert($this->tbl_cash_transaction_detail, $CashPaymentDetail);
	    }
	    
	     if(isset($Sucess)) { return true; }
	 
      	}
	
	
	public function GenerateAutoRefNo()
        {
	    $this->db->select("ReferenceNo");
	    $this->db->from('pos_cash_transaction');
	    $this->db->order_by('CashTransactionId', 'DESC');
	    $this->db->limit('1');
	    $this->db->where('pos_cash_transaction.TransactionType',2);
	    $query = $this->db->get();
	    if ($query->num_rows() > 0)
	    {
		$row = $query->row();
		$RefNo = $row->ReferenceNo;

		$iSplit = explode("C", $RefNo);
		//$data['CPV'] = $iSplit[1];

		$CPVRefNo = $iSplit[1] + 1;
		$Prefix = 'CPV';
		$NewCPVRefNo = $Prefix.''.$CPVRefNo;
		return $NewCPVRefNo;
	    }
	    else
	    { 
		$Prefix = 'CPV';
		$CPVRefNo = 1;
		$NewCPVRefNo = $Prefix.''.$CPVRefNo;
		return $NewCPVRefNo;
	   } 
	}


	public function GenerateAutoCRVRefNo()
        {
	    $this->db->select("ReferenceNo");
	    $this->db->from('pos_cash_transaction');
	    $this->db->order_by('CashTransactionId', 'DESC');
	    $this->db->limit('1');
	    $this->db->where('pos_cash_transaction.TransactionType',1);
	    $query = $this->db->get();
	    if ($query->num_rows() > 0)
	    {
		$row = $query->row();
		$RefNo = $row->ReferenceNo;

		$iSplit = explode("C", $RefNo);
		//$data['CRV'] = $iSplit[1];

		$CRVRefNo = $iSplit[1] + 1;
		$Prefix = 'CRV';
		$NewCRVRefNo = $Prefix.''.$CRVRefNo;
		return $NewCRVRefNo;
	    }
	    else
	    { 
		$Prefix = 'CRV';
		$CRVRefNo = 1;
		$NewCRVRefNo = $Prefix.''.$CRVRefNo;
		return $NewCRVRefNo;
	   } 
	}	
	/* End of Cash Payment Transactions Functions */
	
       
	
	
	
       

}
?>