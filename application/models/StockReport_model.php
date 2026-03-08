<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class StockReport_model extends CI_Model{
	
	function __construct()
	{
            parent::__construct();
            $this->tbl_accounts = "pos_accounts";
            $this->tbl_accounts_group = "pos_accounts_group";
            $this->tbl_product_group = "pos_productgroup";
            $this->tbl_brand = "pos_brands";
    }
	
	
	function GetAllPurchaseRecord($SDate,$EDate,$ProductId,$ProductGroupId,$BrandId)
    {
	  	    
        $conditionArray = array();
	    
	    if($ProductId != 0 && $ProductId != '' && $ProductId != 'undefined')
	    {  $conditionArray['pos_stocks_detail.ProductId'] = $ProductId; }

        if($BrandId != 0 && $BrandId != '' && $BrandId != 'undefined')
        {  $conditionArray['pos_brands.BrandId'] = $BrandId; }

        if($ProductGroupId != 0 && $ProductGroupId != '' && $ProductGroupId != 'undefined')
        {  $conditionArray['pos_productgroup.ProductGroupId'] = $ProductGroupId; }

            $ConditionDate = " 1=1 AND pos_stocks_detail.InOutDate BETWEEN '".$SDate."' AND '".$EDate."' AND (pos_stocks_detail.StockType = 1  OR pos_stocks_detail.StockType = 0)";

            $this->db->select('
	    SUM(pos_stocks_detail.Quantity) AS Quantity,
	    pos_stocks_detail.StockType,
            pos_stocks_detail.ProductId,
            pos_stocks_detail.PurchaseId,
	    pos_stocks_detail.Rate,
	    SUM(pos_stocks_detail.NetAmount) AS NetAmount,
            ');
            $this->db->from('pos_stocks_detail');
            $this->db->join('pos_products','pos_products.ProductId = pos_stocks_detail.ProductId');
            $this->db->join('pos_productgroup', 'pos_productgroup.ProductGroupId = pos_products.ProductGroupId');
            $this->db->join('pos_brands', 'pos_brands.BrandId = pos_products.BrandId');
            $this->db->where($conditionArray);
            $this->db->where($ConditionDate);
	        $this->db->group_by('pos_stocks_detail.ProductId');
            $query = $this->db->get();
            return $query->result_array();            
        }
	
	
	function GetAllPurchaseReturnRecord($SDate,$EDate,$ProductId,$ProductGroupId,$BrandId)
        {	
        $conditionArray = array();
          
    
	    
	    if($ProductId != 0 && $ProductId != '' && $ProductId != 'undefined')
	    {  $conditionArray['pos_stocks_detail.ProductId'] = $ProductId; }

        if($BrandId != 0 && $BrandId != '' && $BrandId != 'undefined')
        {  $conditionArray['pos_brands.BrandId'] = $BrandId; }

        if($ProductGroupId != 0 && $ProductGroupId != '' && $ProductGroupId != 'undefined')
        {  $conditionArray['pos_productgroup.ProductGroupId'] = $ProductGroupId; }	   

        $ConditionDate = " 1=1 AND pos_stocks_detail.InOutDate BETWEEN '".$SDate."' AND '".$EDate."' AND pos_stocks_detail.StockType = 2";

            $this->db->select('
	    SUM(pos_stocks_detail.Quantity) AS Quantity,
	    pos_stocks_detail.StockType,
            pos_stocks_detail.ProductId,
            pos_stocks_detail.PurchaseId,
	    pos_stocks_detail.Rate,
            ');
            $this->db->from('pos_stocks_detail');
            $this->db->join('pos_products','pos_products.ProductId = pos_stocks_detail.ProductId');
            $this->db->join('pos_productgroup', 'pos_productgroup.ProductGroupId = pos_products.ProductGroupId');
            $this->db->join('pos_brands', 'pos_brands.BrandId = pos_products.BrandId');
            $this->db->where($conditionArray);
            $this->db->where($ConditionDate);
	    $this->db->group_by('pos_stocks_detail.ProductId');
            $query = $this->db->get();
            return $query->result_array();            
        }
	
	
        function GetAllSaleRecord($SDate,$EDate,$ProductId,$ProductGroupId,$BrandId)
        {	
        $conditionArray = array();
          
        
	    
	    if($ProductId != 0 && $ProductId != '' && $ProductId != 'undefined')
	    {  $conditionArray['pos_stocks_detail.ProductId'] = $ProductId; }

        if($BrandId != 0 && $BrandId != '' && $BrandId != 'undefined')
        {  $conditionArray['pos_brands.BrandId'] = $BrandId; }

        if($ProductGroupId != 0 && $ProductGroupId != '' && $ProductGroupId != 'undefined')
        {  $conditionArray['pos_productgroup.ProductGroupId'] = $ProductGroupId; }

        $ConditionDate = " 1=1 AND pos_stocks_detail.InOutDate BETWEEN '".$SDate."' AND '".$EDate."' AND pos_stocks_detail.StockType = 3";

            $this->db->select('
	    SUM(pos_stocks_detail.Quantity) AS Quantity,
	    pos_stocks_detail.StockType,
            pos_stocks_detail.ProductId,
            pos_stocks_detail.PurchaseId,
	    pos_stocks_detail.Rate,
	    SUM(pos_stocks_detail.NetAmount) AS NetAmount,
            ');
            $this->db->from('pos_stocks_detail');
            $this->db->join('pos_products','pos_products.ProductId = pos_stocks_detail.ProductId');
            $this->db->join('pos_productgroup', 'pos_productgroup.ProductGroupId = pos_products.ProductGroupId');
            $this->db->join('pos_brands', 'pos_brands.BrandId = pos_products.BrandId');
            $this->db->where($conditionArray);
            $this->db->where($ConditionDate);
            $this->db->group_by('pos_stocks_detail.ProductId');
            $query = $this->db->get();
            return $query->result_array();            
        }
	
	function GetAllSaleReturnRecord($SDate,$EDate,$ProductId,$ProductGroupId,$BrandId)
        {	
            $conditionArray = array();
          
    
	    
	    if($ProductId != 0 && $ProductId != '' && $ProductId != 'undefined')
	    {  $conditionArray['pos_stocks_detail.ProductId'] = $ProductId; }

        if($BrandId != 0 && $BrandId != '' && $BrandId != 'undefined')
        {  $conditionArray['pos_brands.BrandId'] = $BrandId; }

        if($ProductGroupId != 0 && $ProductGroupId != '' && $ProductGroupId != 'undefined')
        {  $conditionArray['pos_productgroup.ProductGroupId'] = $ProductGroupId; }

            $ConditionDate = " 1=1 AND pos_stocks_detail.InOutDate BETWEEN '".$SDate."' AND '".$EDate."' AND pos_stocks_detail.StockType = 4";

            $this->db->select('
	    SUM(pos_stocks_detail.Quantity) AS Quantity,
	    pos_stocks_detail.StockType,
            pos_stocks_detail.ProductId,
            pos_stocks_detail.PurchaseId,
	    pos_stocks_detail.Rate,
            ');
            $this->db->from('pos_stocks_detail');
            $this->db->join('pos_products','pos_products.ProductId = pos_stocks_detail.ProductId');
            $this->db->join('pos_productgroup', 'pos_productgroup.ProductGroupId = pos_products.ProductGroupId');
            $this->db->join('pos_brands', 'pos_brands.BrandId = pos_products.BrandId');
            $this->db->where($conditionArray);
            $this->db->where($ConditionDate);
	        $this->db->group_by('pos_stocks_detail.ProductId');
            $query = $this->db->get();
            return $query->result_array();            
        }

    public function AllStockLocationFrom($LocationId)
    {
        $this->db->select('*')->from('pos_stocks_detail');
        $this->db->join('pos_locations', 'pos_locations.LocationId = pos_stocks_detail.LocationIdFrom', 'left');
        $this->db->where('pos_stocks_detail.StockType', 5);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function AllStockTransferRecord($LocationId,$ProductId,$ColourId,$EmployeeId,$StartDate,$EndDate)
    {
        $this->db->select('*');
        $this->db->from('pos_stocks_detail');
        $this->db->join('pos_products', 'pos_products.ProductId = pos_stocks_detail.ProductId', 'left');
        $this->db->join('pos_employees', 'pos_employees.EmployeeId = pos_stocks_detail.EmployeeId', 'left');
        $this->db->join('pos_locations', 'pos_locations.LocationId = pos_stocks_detail.LocationId','left');
        $this->db->join('pos_product_colours', 'pos_product_colours.ColourId = pos_stocks_detail.ColourId', 'left');
        $this->db->join('pos_productgroup', 'pos_productgroup.ProductGroupId = pos_products.ProductGroupId');
        $this->db->join('pos_brands', 'pos_brands.BrandId = pos_products.BrandId');
        if($ProductId != 0){$this->db->where('pos_products.ProductId', $ProductId);}
        if($LocationId != 0){$this->db->where('pos_locations.LocationId', $LocationId);}
        if($ColourId != 0){$this->db->where('pos_product_colours.ColourId', $ColourId);}
        if($EmployeeId != 0){$this->db->where('pos_employees.EmployeeId', $EmployeeId);}
        if($StartDate != 0){$this->db->where('pos_stocks_detail.InOutDate >=', $StartDate);}
        if($EndDate != 0){$this->db->where('pos_stocks_detail.InOutDate <=', $EndDate);}
        $this->db->where('pos_stocks_detail.StockType', 5);
        $this->db->order_by('pos_stocks_detail.InOutDate', 'asc');
        $query = $this->db->get();
        return $query->result_array();
    }
    /*
    * start new report methods
    */
    function GetPurchaseReturnRecord($SDate,$EDate,$CategoryId,$ProductGroupId,$BrandId)
    {	
        $conditionArray = array();
        
	    if($CategoryId != 0 && $CategoryId != '' && $CategoryId != 'undefined')
	    {  $conditionArray['pos_products.CategoryId'] = $CategoryId; }

        if($BrandId != 0 && $BrandId != '' && $BrandId != 'undefined')
        {  $conditionArray['pos_products.BrandId'] = $BrandId; }

        if($ProductGroupId != 0 && $ProductGroupId != '' && $ProductGroupId != 'undefined')
        {  $conditionArray['pos_products.ProductGroupId'] = $ProductGroupId; }	   

        $ConditionDate = " 1=1 AND pos_stocks_detail.InOutDate BETWEEN '".$SDate."' AND '".$EDate."' AND pos_stocks_detail.StockType = 2";

            $this->db->select('
            SUM(pos_stocks_detail.Quantity) AS Quantity,
            pos_stocks_detail.StockType,
            pos_stocks_detail.ProductId,
            pos_stocks_detail.PurchaseId,
	        pos_stocks_detail.Rate,
            ');
            $this->db->from('pos_stocks_detail');
            $this->db->join('pos_products','pos_products.ProductId = pos_stocks_detail.ProductId');
            $this->db->join('pos_productgroup', 'pos_productgroup.ProductGroupId = pos_products.ProductGroupId');
            $this->db->join('pos_brands', 'pos_brands.BrandId = pos_products.BrandId');
            $this->db->where($conditionArray);
            $this->db->where($ConditionDate);
	        $this->db->group_by('pos_stocks_detail.ProductId');
            $query = $this->db->get();
            return $query->result_array();            
        }

    function GetSaleRecord($SDate,$EDate,$CategoryId,$ProductGroupId,$BrandId)
    {	
        $conditionArray = array();
	    
	    if($CategoryId != 0 && $CategoryId != '' && $CategoryId != 'undefined')
	    {  $conditionArray['pos_products.CategoryId'] = $CategoryId; }

        if($BrandId != 0 && $BrandId != '' && $BrandId != 'undefined')
        {  $conditionArray['pos_products.BrandId'] = $BrandId; }

        if($ProductGroupId != 0 && $ProductGroupId != '' && $ProductGroupId != 'undefined')
        {  $conditionArray['pos_products.ProductGroupId'] = $ProductGroupId; }

        $ConditionDate = " 1=1 AND pos_stocks_detail.InOutDate BETWEEN '".$SDate."' AND '".$EDate."' AND pos_stocks_detail.StockType = 3";

            $this->db->select('
            SUM(pos_stocks_detail.Quantity) AS Quantity,
            pos_stocks_detail.StockType,
            pos_stocks_detail.ProductId,
            pos_stocks_detail.PurchaseId,
            pos_stocks_detail.Rate,
            SUM(pos_stocks_detail.NetAmount) AS NetAmount,
            ');
            $this->db->from('pos_stocks_detail');
            $this->db->join('pos_products','pos_products.ProductId = pos_stocks_detail.ProductId');
            $this->db->join('pos_productgroup', 'pos_productgroup.ProductGroupId = pos_products.ProductGroupId');
            $this->db->join('pos_brands', 'pos_brands.BrandId = pos_products.BrandId');
            $this->db->where($conditionArray);
            $this->db->where($ConditionDate);
            $this->db->group_by('pos_stocks_detail.ProductId');
            $query = $this->db->get();
            return $query->result_array();            
        }

}
?>