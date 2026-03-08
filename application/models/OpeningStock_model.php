<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class OpeningStock_model extends CI_Model{
	
	function __construct()
	{
        parent::__construct();
        $this->tbl_category = "pos_category";
        $this->tbl_brand = "pos_brands";
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
//		$this->db->where('OpeningStockId !=',0);
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
	
	function GetAllOpeningStock()
	{
	    $this->db->select('*');
	    $this->db->from($this->tbl_stock_transfer);
	    $query = $this->db->get();
	    return $query->result_array();	
	}

	public function SaveOpeningStockDetail($data)
	{
/*		$TotalQuantity = array_sum($this->input->post('Quantity'));
		$RemainingQuantity = $data['RemainingStock'] - $TotalQuantity;

		$OpeningStockTo = explode("-", $this->input->post('OpeningStockTo'));
		$StockTypeId = $OpeningStockTo[1];*/

		$StockType = "";
/*		if($StockTypeId == "1"){ $StockType = "1";}
		if($StockTypeId == "5"){ $StockType = "5";}*/

/*		for ($i=0; $i < count($this->input->post('Quantity')) ; $i++) {
	    $OpeningStockDetails = array(
    	'OpeningStockId' => '',
	    'CompanyId' => $this->session->userdata('CompanyId'),
	    'OpeningStockDate' => date('Y-m-d', strtotime($this->input->post('OpeningStockDate'))),
	    'OpeningStockFrom' => $this->input->post('OpeningStockFrom'),
	    'OpeningStockTo' => $this->input->post('OpeningStockTo'),
	    'ProductId' => $this->input->post('ProductId'),
	    'ColourId' => $this->input->post('ColourId')[$i],
	    'Quantity' => $this->input->post('Quantity')[$i],
	    'Comment'    => $this->input->post('Comments')[$i],
	    'AddedOn' => date('Y-m-d H:i:s'),
	    'AddedBy' => $this->session->userdata('EmployeeId'),
	    );

	    $this->db->insert('pos_stock_transfer', $OpeningStockDetails);

	    $OpeningStockId = intval($this->db->insert_id());
		}*/

//		for ($i=0; $i < count($this->input->post('Quantity')) ; $i++) {
			$StockDetails = array(
				//'OpeningStockId' => '',
				'LocationId' => $this->input->post('LocationId'),
				'ProductId' => $this->input->post('ProductId'),
				'ColourId' => $this->input->post('ColourId'),
				'Rate' => $this->input->post('Rate'),
				'Quantity' => $this->input->post('Quantity'),
				'Amount' => $this->input->post('Amount'),
				'NetAmount' => $this->input->post('Amount'),
				'InOutDate' => $this->input->post('OpeningStockDate'),
				'StockType' => $StockType,
				'AddedBy' => $this->session->userdata('EmployeeId'),
				'AddedOn' => date('Y-m-d H:i:s'),
			);
		$this->db->insert('pos_stocks_detail', $StockDetails);
//		}
		$StockId = intval($this->db->insert_id());
        return $StockId;

	}

	public function CheckStockSummary($LocationId,$ProductId,$ColourId)
	{
		$this->db->select('*')->from($this->tbl_stock_summary);
		$this->db->where('LocationId', $LocationId);
		$this->db->where('ProductId', $ProductId);
		$this->db->where('ColourId', $ColourId);
		$query = $this->db->get();
		return $query->row();
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



    public function Ajax_GetAllOpeningStock($requestData)
    {
               $columns = array( 
                        0 => 'StockId',
                        1 => 'ProductName', 'ProductGroupName', 'BrandName',
                        2 => 'LocationName',
                        3 => 'Quantity',
                );
                $sql = "SELECT *";
                $sql.=" FROM pos_stocks_detail";
                $sql.=" LEFT JOIN pos_products ON pos_stocks_detail.ProductId = pos_products.ProductId";
                $sql.=" LEFT JOIN pos_locations ON pos_stocks_detail.LocationId = pos_locations.LocationId";
                $sql.=" LEFT JOIN pos_productgroup ON pos_products.ProductGroupId = pos_productgroup.ProductGroupId";
                $sql.=" LEFT JOIN pos_brands ON pos_products.BrandId = pos_brands.BrandId";

                $query= $this->db->query($sql); 
                $totalData = $query->num_rows();
                $totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.
//              $sql.=" WHERE pos_stocks_detail.StockType = 0";
              $sql.=" WHERE 1=1 ";
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
	
	function GetOpeningStockDetail($StockId)
	{
	    $this->db->select('*');
		$this->db->from($this->tbl_stocks_detail);
//	    $this->db->join($this->tbl_stocks_detail, $this->tbl_stocks_detail.'.SummaryId = '.$this->tbl_stock_transfer.'.SummaryId');
	    $this->db->join($this->tbl_locations, $this->tbl_locations.'.LocationId = '.$this->tbl_stocks_detail.'.LocationId','left');
	    $this->db->join($this->tbl_products, $this->tbl_products.'.ProductId = '.$this->tbl_stocks_detail.'.ProductId','left');
	    $this->db->join($this->tbl_product_colours, $this->tbl_product_colours.'.ColourId = '.$this->tbl_stocks_detail.'.ColourId','left');
	    $this->db->where('pos_stocks_detail.StockId',$StockId);
	    $query = $this->db->get();
	    return $query->row();
	}
	
	
	
	
	public function UpdateOpeningStockDetails($StockId)
	{

		$StockType = "";

	    $StockDetails = array(
		'LocationId' => $this->input->post('LocationId'),
		'ProductId' => $this->input->post('ProductId'),
		'ColourId' => $this->input->post('ColourId'),
		'Rate' => $this->input->post('Rate'),
		'Quantity' => $this->input->post('Quantity'),
		'Amount' => $this->input->post('Amount'),
		'NetAmount' => $this->input->post('Amount'),
		'InOutDate' => date('Y-m-d', strtotime($this->input->post('OpeningStockDate'))),
		'StockType' => $StockType,
		'AddedBy' => $this->session->userdata('EmployeeId'),
		'AddedOn' => date('Y-m-d H:i:s'),
	    );

	    $this->db->set($StockDetails);
	    $this->db->where('StockId', $StockId);
	    $this->db->update('pos_stocks_detail');

/*		$this->db->where('pos_stocks_detail.StockId', $StockId);
	    $this->db->delete('pos_stocks_detail');*/

	
    	return $StockId;
	}
		



	 
}
?>