<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class StockTransfer_model extends CI_Model{
	
	function __construct()
	{
        parent::__construct();
        $this->tbl_category = "pos_category";
	$this->tbl_customer = "pos_customer";
        $this->tbl_productgroup = "pos_productgroup";
        $this->tbl_products = "pos_products";
        $this->tbl_stock_transfer = "pos_stock_transfer";
        $this->tbl_stocks_detail = "pos_stocks_detail";
	$this->tbl_locations = "pos_locations";
	$this->tbl_product_colours = "pos_product_colours";
	$this->tbl_stock_summary = "pos_stock_summary";
//            $this->output->enable_profiler;
	}

	public function GetAllBankAccounts()
	{
		$this->db->select('*')->from('pos_banks')->join('pos_bank_accounts', 'pos_banks.BankId = pos_bank_accounts.BankId', 'left');
		$query = $this->db->get();
		return $query->result_array();
	}


	public function GetLastPrice($ProductId, $LocationId)
	{
		$this->db->select("NetAmount");
		$this->db->from('pos_stocks_detail');
		$this->db->where('ProductId', $ProductId);
		$this->db->where('LocationId', $LocationId);
		$this->db->order_by("ProductId", "DESC");
		$this->db->limit('1');
		$GetLastPrice = $this->db->get();
		return $GetLastPrice->result_array();
	}

	public function TransferedProducts($ProductId,$ColourId,$LocationId)
	{
		$this->db->select_sum("Quantity");
		$this->db->from('pos_stocks_detail');
		$this->db->where('pos_stocks_detail.ProductId', $ProductId);
		$this->db->where('pos_stocks_detail.ColourId', $ColourId);
		if($LocationId != 0){$this->db->where('pos_stocks_detail.LocationId', $LocationId);}
		$this->db->where('pos_stocks_detail.StockType', 5);
//		$this->db->where('StockTransferId !=',0);
		$query = $this->db->get();
		return $query->row();
	}

	public function PurchasedProducts($ProductId,$ColourId,$LocationId)
	{
		$this->db->select_sum("Quantity");
		$this->db->from('pos_stocks_detail');
		$this->db->where('pos_stocks_detail.ProductId', $ProductId);
		$this->db->where('pos_stocks_detail.ColourId', $ColourId);
		if($LocationId != 0){$this->db->where('pos_stocks_detail.LocationId', $LocationId);}
		$this->db->where('pos_stocks_detail.StockType', 1);
//		$this->db->where('PurchaseId !=',0);
		$query = $this->db->get();
		return $query->row();
	}

	public function SoldProducts($ProductId,$LocationId)
	{
		$this->db->select('SaleId,Quantity,StockType');
		$this->db->from('pos_stocks_detail');
		$this->db->where('pos_stocks_detail.ProductId', $ProductId);
		$this->db->where('pos_stocks_detail.LocationId', $LocationId);
		$this->db->where('pos_stocks_detail.StockType', 3);
		$this->db->where('SaleId !=',0);
		$query = $this->db->get();
		return $query->result_array();
	}
	
	function GetAllStockTransfer()
	{
	    $this->db->select('*');
	    $this->db->from($this->tbl_stock_transfer);
	    $query = $this->db->get();
	    return $query->result_array();	
	}

	public function SaveStockTransferDetail($data)
	{
		$TotalQuantity = $this->input->post('Quantity');
		$RemainingQuantity = $data['RemainingStock'] - $TotalQuantity;

		$StockType = 5;

		for ($i=0; $i < count($this->input->post('Quantity')) ; $i++) {
			$StockDetails = array(
	    		'EmployeeId' => $this->input->post('EmployeeId'),
				'LocationId' => $this->input->post('StockTransferTo'),
	    		'ProductId' => $this->input->post('ProductId'),
	    		'ColourId' => $this->input->post('ColourId'),
	    		'LocationIdFrom' => $this->input->post('StockTransferFrom'),
				'Quantity' => $this->input->post('Quantity'),
				'StockType' => $StockType,
				'InOutDate' => date("Y-m-d", strtotime($this->input->post('StockTransferDate'))),
				'Comments' => $this->input->post('Comments'),
	    		'AddedBy' => $this->session->userdata('EmployeeId'),
				'AddedOn' => date('Y-m-d H:i:s'),
			);
		$this->db->insert('pos_stocks_detail', $StockDetails);
		$SummaryId = intval($this->db->insert_id());
		}
		return $SummaryId;

	}

	public function CheckStockSummary($LocationId,$ProductId,$ColourId)
	{
		$this->db->select('*')->from($this->tbl_stock_summary);
		$this->db->where('LocationId', $LocationId);
		$this->db->where('ProductId', $ProductId);
		$this->db->where('ColourId', $ColourId);
		$query = $this->db->get();
		return $query->result_array();
	}

	public function CheckOtherLocationStatus($LocationToId,$ProductId,$ColourId)
	{
		$this->db->select('*')->from($this->tbl_stock_summary);
		$this->db->where('LocationId', $LocationToId);
		$this->db->where('ProductId', $ProductId);
		$this->db->where('ColourId', $ColourId);
		$query = $this->db->get();
		return $query->row();
	}

	public function AddStockSummary($LocationId,$ProductId,$ColourId,$Quantity)
	{
		$StockSummary = array(
			'SummaryId' => '',
			'ProductId' => $ProductId,
			'LocationId' => $LocationId,
			'ColourId' => $ColourId,
			'Quantity' => $Quantity,
			'AddedOn' => date('Y-m-d H:i:s'),
	    	'AddedBy' => $this->session->userdata('EmployeeId'),
		);
		$this->db->insert('pos_stock_summary', $StockSummary);
		$SummaryId = intval($this->db->insert_id());
		return $SummaryId;
	}

	public function UpdateStockSummary($SummaryId,$LocationId,$ProductId,$ColourId,$NewQuantity)
	{
		$UpdateStockSummary = array(
			'SummaryId' => $SummaryId,
			'ProductId' => $ProductId,
			'LocationId' => $LocationId,
			'ColourId' => $ColourId,
			'Quantity' => $NewQuantity,
			'AddedOn' => date('Y-m-d H:i:s'),
	    	'AddedBy' => $this->session->userdata('EmployeeId'),
		);
		$this->db->set($UpdateStockSummary);
		$this->db->where('SummaryId',$SummaryId);
		$this->db->update('pos_stock_summary');
		return $SummaryId;
	}



    public function Ajax_GetAllStockTransfers($requestData)
    {
               $columns = array( 
                        0 => 'StockId',
                        1 => 'ProductName',
                        2 => 'LocationName',
                        3 => 'Quantity',
                );
                $sql = "SELECT *";
                $sql.=" FROM pos_stocks_detail";
                $sql.=" LEFT JOIN pos_products ON pos_stocks_detail.ProductId = pos_products.ProductId ";
                $sql.=" LEFT JOIN pos_locations ON pos_stocks_detail.LocationId = pos_locations.LocationId ";
//                $sql.=" LEFT JOIN pos_product_colours ON pos_stocks_detail.ColourId = pos_product_colours.ColourId ";

                $query= $this->db->query($sql); 
                $totalData = $query->num_rows();
                $totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.
//              if($this->session->userdata('CompanyId') != 0){
              $sql.=" WHERE pos_stocks_detail.StockType = 5";
              if( !empty($requestData['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter
                       $sql.=" AND (StockId LIKE '".$requestData['search']['value']."%' ";
                       $sql.=" OR ProductName LIKE '".$requestData['search']['value']."%' ";
                       $sql.=" OR LocationName LIKE '".$requestData['search']['value']."%' )";
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

	public function StockTransferTo($StockTransferId)
	{
		$this->db->select('*');
	    $this->db->from($this->tbl_stock_transfer);
	    $this->db->join($this->tbl_locations, $this->tbl_locations.'.LocationId = '.$this->tbl_stock_transfer.'.StockTransferTo','left');
	    $this->db->where('pos_stock_transfer.StockTransferId',$StockTransferId);
	    $query = $this->db->get();
	    return $query->result_array();
	}

	public function StockTransferFrom($StockTransferId)
	{
		$this->db->select('*');
	    $this->db->from($this->tbl_stock_transfer);
	    $this->db->join($this->tbl_locations, $this->tbl_locations.'.LocationId = '.$this->tbl_stock_transfer.'.StockTransferFrom','left');
	    $this->db->where('pos_stock_transfer.StockTransferId',$StockTransferId);
	    $query = $this->db->get();
	    return $query->result_array();
	}

	function GetStockTransfer($SummaryId)
	{
	    $this->db->select('*');
	    $this->db->from($this->tbl_stock_summary);
	    $this->db->join($this->tbl_locations, $this->tbl_locations.'.LocationId = '.$this->tbl_stock_summary.'.LocationId','left');
	    $this->db->join($this->tbl_products, $this->tbl_products.'.ProductId = '.$this->tbl_stock_summary.'.ProductId','left');
	    $this->db->join($this->tbl_product_colours, $this->tbl_product_colours.'.ColourId = '.$this->tbl_stock_summary.'.ColourId','left');
	    $this->db->where('pos_stock_summary.SummaryId',$SummaryId);
	    $this->db->limit('1');
	    $query = $this->db->get();
	    return $query->result_array();
	}
	
	
	function GetStockTransferDetail($StockId)
	{
	    $this->db->select('*');
		$this->db->from($this->tbl_stocks_detail);
	    $this->db->join($this->tbl_locations, $this->tbl_locations.'.LocationId = '.$this->tbl_stocks_detail.'.LocationId','left');
	    $this->db->join($this->tbl_products, $this->tbl_products.'.ProductId = '.$this->tbl_stocks_detail.'.ProductId','left');
	    $this->db->join($this->tbl_product_colours, $this->tbl_product_colours.'.ColourId = '.$this->tbl_stocks_detail.'.ColourId','left');
	    $this->db->where('pos_stocks_detail.StockId',$StockId);
	    $query = $this->db->get();
	    return $query->row();
	}
	
	
	
	
	public function UpdateStockTransferDetails($StockTransferId)
	{
		$StockTransferTo = explode("-", $this->input->post('StockTransferTo'));
		$StockTypeId = $StockTransferTo[1];

		$StockType = "";
		if($StockTypeId == "1"){ $StockType = "1";}
		if($StockTypeId == "5"){ $StockType = "5";}

		for ($i=0; $i < count($this->input->post('Quantity')) ; $i++) {
	    $StockTransferDetails = array(
	    'StockTransferDate' => date('Y-m-d', strtotime($this->input->post('StockTransferDate'))),
	    'StockTransferFrom' => $this->input->post('StockTransferFrom'),
	    'StockTransferTo' => $this->input->post('StockTransferTo'),
	    'ProductId' => $this->input->post('ProductId'),
	    'ColourId' => $this->input->post('ColourId')[$i],
	    'Quantity' => $this->input->post('Quantity')[$i],
	    'Comment'    => $this->input->post('Comments')[$i],
	    'AddedOn' => date('Y-m-d H:i:s'),
	    'AddedBy' => $this->session->userdata('EmployeeId'),
	    );

	    $this->db->set($StockTransferDetails);
	    $this->db->where('StockTransferId', $StockTransferId);
	    $this->db->update('pos_stock_transfer');
		}

		$this->db->where('pos_stocks_detail.StockTransferId', $StockTransferId);
	    $this->db->delete('pos_stocks_detail');

		for ($i=0; $i < count($this->input->post('Quantity')) ; $i++) {
			$StockDetails = array(
				'StockTransferId' => $StockTransferId,
				'LocationId' => $this->input->post('StockTransferTo'),
	    		'ProductId' => $this->input->post('ProductId'),
	    		'ColourId' => $this->input->post('ColourId')[$i],
	    		'LocationId' => $this->input->post('StockTransferTo'),
				'Quantity' => $this->input->post('Quantity')[$i],
				'StockType' => $StockType,
	    		'AddedBy' => $this->session->userdata('EmployeeId'),
				'AddedOn' => date('Y-m-d H:i:s'),
			);
			$this->db->insert('pos_stocks_detail', $StockDetails);
		}
        return $StockTransferId;
	}
		



	 
}
?>