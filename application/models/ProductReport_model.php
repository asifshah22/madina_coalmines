<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class ProductReport_model extends CI_Model{
	
	function __construct(){
		parent::__construct();
		$this->tbl_products = "pos_products";
        $this->tbl_stocks_detail = "pos_stocks_detail";
        $this->tbl_locations = "pos_locations";
	}
    
    public function CountLocations()
    {
        $this->db->select("*")->from('pos_locations');
        $Query = $this->db->get();
        return $Query->num_rows();
    }

    public function GetProductReport($ProductId,$BrandId,$ProductGroupId)
    {
        $this->db->select("*");
        $this->db->from('pos_products');
        $this->db->join('pos_category', 'pos_category.CategoryId = pos_products.CategoryId', 'left');
        $this->db->join('pos_brands', 'pos_brands.BrandId = pos_products.BrandId', 'left');
        $this->db->join('pos_productgroup', 'pos_productgroup.ProductGroupId = pos_products.ProductGroupId', 'left');

        if($ProductId){$this->db->where('pos_products.ProductId', $ProductId);}
        if($ProductGroupId){$this->db->where('pos_products.ProductGroupId', $ProductGroupId);}
        if($BrandId){$this->db->where('pos_products.BrandId', $BrandId);}

        $query = $this->db->get();
        return $query->result_array();
    }

    public function GetProductReport__($ProductId,$EndDate)
    {
        $this->db->select("*");
        $this->db->from('pos_stocks_detail');
        $this->db->join('pos_products', 'pos_products.ProductId = pos_stocks_detail.ProductId');
       // $this->db->join('pos_locations', 'pos_locations.LocationId = pos_stocks_detail.LocationId');
       // $this->db->join('pos_product_colours', 'pos_product_colours.ColourId = pos_stocks_detail.ColourId');

       // if($ProductId != 0){$this->db->where('pos_stocks_detail.ProductId', $ProductId);}
//        if($LocationId != 0){$this->db->where('pos_stocks_detail.LocationId', $LocationId);}
//        if($StartDate != 0){$this->db->where('pos_stocks_detail.InOutDate >=', $StartDate);}
        if($EndDate != 0){$this->db->where('pos_stocks_detail.InOutDate <=', $EndDate);}
        $this->db->group_by('ProductName');
        $query = $this->db->get();
        return $query->result_array();
    }
    
    
    public function GetProductStocks($UptoDate,$ProductId)
    {
        $this->db->select("pos_stocks_detail.ProductId, pos_stocks_detail.ColourId, pos_products.ProductName, pos_productgroup.ProductGroupName, pos_brands.BrandName");
	//$this->db->select("*");
        $this->db->from('pos_stocks_detail');
        $this->db->join('pos_products', 'pos_products.ProductId = pos_stocks_detail.ProductId', 'left');
	$this->db->join('pos_productgroup', 'pos_productgroup.ProductGroupId = pos_products.ProductGroupId', 'left');
        $this->db->join('pos_brands', 'pos_brands.BrandId = pos_products.BrandId', 'left');
       // $this->db->join('pos_product_colours', 'pos_product_colours.ColourId = pos_stocks_detail.ColourId');

        if($ProductId != 0){$this->db->where('pos_stocks_detail.ProductId', $ProductId);}
        if($UptoDate != 0){$this->db->where('pos_stocks_detail.InOutDate <=', $UptoDate);}
	//$this->db->where('pos_stocks_detail.StockType =', 0);
        $this->db->group_by('ProductId');
        $query = $this->db->get();
        return $query->result_array();
    }
    
    
    public function GetColourStocks($UptoDate,$ProductId)
    {
        $this->db->select("pos_stocks_detail.ProductId, pos_stocks_detail.ColourId");
        $this->db->from('pos_stocks_detail');
        $this->db->join('pos_products', 'pos_products.ProductId = pos_stocks_detail.ProductId');

        if($ProductId != 0){$this->db->where('pos_stocks_detail.ProductId', $ProductId);}
        if($UptoDate != 0){$this->db->where('pos_stocks_detail.InOutDate <=', $UptoDate);}
	//$this->db->where('pos_stocks_detail.StockType =', 0);
        $this->db->group_by('ProductId');
	//$this->db->group_by('LocationId');
	$this->db->group_by('ColourId');
        $query = $this->db->get();
        return $query->result_array();
    }
    
    
    public function GetProductTransferFromRecord($UptoDate,$LocationId,$ProductId)
    {
	$ConditionDate = " 1=1 AND (pos_stocks_detail.StockType = 5) AND pos_stocks_detail.InOutDate <='".$UptoDate."'";
	
        $this->db->select("SUM(pos_stocks_detail.Quantity) AS Quantity, pos_stocks_detail.LocationId, pos_stocks_detail.LocationIdFrom, pos_stocks_detail.ProductId, pos_stocks_detail.ColourId");
        $this->db->from('pos_stocks_detail');
        if($LocationId != 0){$this->db->where('pos_stocks_detail.LocationIdFrom', $LocationId);}
	if($ProductId != 0){$this->db->where('pos_stocks_detail.ProductId', $ProductId);}
        //if($UptoDate != 0){$this->db->where('pos_stocks_detail.InOutDate <=', $UptoDate);}
	$this->db->where($ConditionDate);
        $this->db->group_by('LocationIdFrom');
	$this->db->group_by('ProductId');
	$this->db->group_by('ColourId');
        $query = $this->db->get();
        return $query->result_array();
    }
    
    
    public function GetProductTransferRecord($UptoDate,$LocationId,$ProductId)
    {
	$ConditionDate = " 1=1 AND (pos_stocks_detail.StockType = 5) AND pos_stocks_detail.InOutDate <='".$UptoDate."'";
	
        $this->db->select("SUM(pos_stocks_detail.Quantity) AS Quantity, pos_stocks_detail.LocationId, pos_stocks_detail.LocationIdFrom, pos_stocks_detail.ProductId, pos_stocks_detail.ColourId");
        $this->db->from('pos_stocks_detail');
        if($LocationId != 0){$this->db->where('pos_stocks_detail.LocationId', $LocationId);}
	if($ProductId != 0){$this->db->where('pos_stocks_detail.ProductId', $ProductId);}
        //if($UptoDate != 0){$this->db->where('pos_stocks_detail.InOutDate <=', $UptoDate);}
	$this->db->where($ConditionDate);
        $this->db->group_by('LocationId');
	$this->db->group_by('ProductId');
	$this->db->group_by('ColourId');
        $query = $this->db->get();
        return $query->result_array();
    }
    
    
    public function GetLocationWiseStockPurchase($UptoDate,$LocationId,$ProductId)
    {
	$ConditionDate = " 1=1 AND (pos_stocks_detail.StockType = 1 OR pos_stocks_detail.StockType = 0) AND pos_stocks_detail.InOutDate <='".$UptoDate."'";
	
        $this->db->select("SUM(pos_stocks_detail.Quantity) AS Quantity, pos_stocks_detail.LocationId, pos_stocks_detail.ProductId, pos_stocks_detail.ColourId");
        $this->db->from('pos_stocks_detail');
        if($LocationId != 0){$this->db->where('pos_stocks_detail.LocationId', $LocationId);}
	if($ProductId != 0){$this->db->where('pos_stocks_detail.ProductId', $ProductId);}
        //if($UptoDate != 0){$this->db->where('pos_stocks_detail.InOutDate <=', $UptoDate);}
	$this->db->where($ConditionDate);
        $this->db->group_by('LocationId');
	$this->db->group_by('ProductId');
	$this->db->group_by('ColourId');
        $query = $this->db->get();
        return $query->result_array();
    }
    
    
    
     public function GetLocationWiseStockPurchaseReturn($UptoDate,$LocationId,$ProductId)
    {
	$ConditionDate = " 1=1 AND pos_stocks_detail.StockType = 2 AND pos_stocks_detail.InOutDate <='".$UptoDate."'";
	
        $this->db->select("SUM(pos_stocks_detail.Quantity) AS Quantity, pos_stocks_detail.LocationId, pos_stocks_detail.ProductId, pos_stocks_detail.ColourId");
        $this->db->from('pos_stocks_detail');
        if($LocationId != 0){$this->db->where('pos_stocks_detail.LocationId', $LocationId);}
	if($ProductId != 0){$this->db->where('pos_stocks_detail.ProductId', $ProductId);}
        //if($UptoDate != 0){$this->db->where('pos_stocks_detail.InOutDate <=', $UptoDate);}
	$this->db->where($ConditionDate);
        $this->db->group_by('LocationId');
	$this->db->group_by('ProductId');
	$this->db->group_by('ColourId');
        $query = $this->db->get();
        return $query->result_array();
    }
    
    
    
    
	    
    
    
    public function GetLocationWiseStockSale($UptoDate,$LocationId,$ProductId)
    {
	$ConditionDate = " 1=1 AND pos_stocks_detail.StockType = 3 AND pos_stocks_detail.InOutDate <='".$UptoDate."'";
	
        $this->db->select("SUM(pos_stocks_detail.Quantity) AS Quantity, pos_stocks_detail.LocationId, pos_stocks_detail.ProductId, pos_stocks_detail.ColourId");
        $this->db->from('pos_stocks_detail');
        if($LocationId != 0){$this->db->where('pos_stocks_detail.LocationId', $LocationId);}
	if($ProductId != 0){$this->db->where('pos_stocks_detail.ProductId', $ProductId);}
        //if($UptoDate != 0){$this->db->where('pos_stocks_detail.InOutDate <=', $UptoDate);}
	$this->db->where($ConditionDate);
        $this->db->group_by('LocationId');
        $this->db->group_by('ProductId');
	$this->db->group_by('ColourId');
        $query = $this->db->get();
        return $query->result_array();
    }
    
    
    public function GetLocationWiseStockSaleReturn($UptoDate,$LocationId,$ProductId)
    {
	$ConditionDate = " 1=1 AND pos_stocks_detail.StockType = 4 AND pos_stocks_detail.InOutDate <='".$UptoDate."'";
	
        $this->db->select("SUM(pos_stocks_detail.Quantity) AS Quantity, pos_stocks_detail.LocationId, pos_stocks_detail.ProductId, pos_stocks_detail.ColourId");
        $this->db->from('pos_stocks_detail');

        if($LocationId != 0){$this->db->where('pos_stocks_detail.LocationId', $LocationId);}
	if($ProductId != 0){$this->db->where('pos_stocks_detail.ProductId', $ProductId);}
        //if($UptoDate != 0){$this->db->where('pos_stocks_detail.InOutDate <=', $UptoDate);}
	$this->db->where($ConditionDate);
        $this->db->group_by('LocationId');
        $this->db->group_by('ProductId');
	$this->db->group_by('ColourId');
        $query = $this->db->get();
        return $query->result_array();
    }
    
    
    
    public function ProductColours($ProductId,$LocationId)
    {
        $this->db->select("*");
        $this->db->from('pos_stocks_detail');
        $this->db->join('pos_product_colours', 'pos_product_colours.ColourId = pos_stocks_detail.ColourId', 'left');
        $this->db->where("pos_stocks_detail.ColourId >", 0);
        if($LocationId != 0){$this->db->where('pos_stocks_detail.LocationId', $LocationId);}
        if($ProductId != 0){$this->db->where('pos_stocks_detail.ProductId', $ProductId);}
        $this->db->group_by('ColourName');
        $query = $this->db->get();
        return $query->result_array();
//        return $query->num_rows();
    }

    public function TotalColourQuantity($ColourId,$ProductId,$LocationId)
    {
        $this->db->select_sum("Quantity");
        $this->db->from('pos_stocks_detail');
        $this->db->join('pos_product_colours', 'pos_product_colours.ColourId = pos_stocks_detail.ColourId');
        $this->db->join('pos_locations', 'pos_locations.LocationId = pos_stocks_detail.LocationId');
        $this->db->where('pos_stocks_detail.ColourId', $ColourId);
        if($ProductId != 0){$this->db->where('pos_stocks_detail.ProductId', $ProductId);}
        if($LocationId != 0){$this->db->where('pos_stocks_detail.LocationId', $LocationId);}
        $query = $this->db->get();
        return $query->row();
    }

    public function TotalQuantity($ColourId,$ProductId,$LocationId)
    {
        $this->db->select_sum("Quantity");
        $this->db->from('pos_stocks_detail');
        $this->db->join('pos_product_colours', 'pos_product_colours.ColourId = pos_stocks_detail.ColourId', 'left');
        $this->db->where('pos_stocks_detail.ColourId', $ColourId);
        if($ProductId != 0){$this->db->where('pos_stocks_detail.ProductId', $ProductId);}
        if($LocationId != 0){$this->db->where('pos_stocks_detail.LocationId', $LocationId);}
        $query = $this->db->get();
//        return $query->row();
        return $query->result_array();
    }

    public function LocationQuantity($ColourId,$ProductId,$LocationId)
    {
        $this->db->select("pos_locations.LocationId,LocationName,Quantity");
        $this->db->from('pos_locations');
        $this->db->join('pos_stocks_detail', 'pos_stocks_detail.LocationId = pos_locations.LocationId','right');
        $this->db->where('pos_stocks_detail.ColourId', $ColourId);
//        $this->db->where('pos_stocks_detail.ProductId', $ProductId);
//        $this->db->group_by('LocationId');
        if($ProductId != 0){$this->db->where('pos_stocks_detail.ProductId', $ProductId);}
/*
        if($LocationId != 0){$this->db->where('pos_stocks_detail.LocationId', $LocationId);}
        if($ColourId != 0){$this->db->where('pos_stocks_detail.ColourId', $ColourId);}*/
        $query = $this->db->get();
//        return $query->row();
        return $query->result_array();
    }

    public function GowdownOne($ProductId)
    {
        $conditionArray = array();
          
        if($ProductId != 0 && $ProductId != '' && $ProductId != 'undefined')
        {  $conditionArray['pos_stocks_detail.ProductId'] = $ProductId; }

        if($LocationId != 0 && $LocationId != '' && $LocationId != 'undefined')
        {  $conditionArray['pos_stocks_detail.LocationId'] = $LocationId; }

        $this->db->select_sum("Quantity");
        $this->db->from('pos_stocks_detail');
//        $this->db->join('pos_product_colours', 'pos_product_colours.ColourId = pos_stocks_detail.ColourId');
        $this->db->where($conditionArray);
        $this->db->where('ProductId', $ProductId);
        $this->db->where('LocationId', 1);
        $query = $this->db->get();
        return $query->result_array();
    }	


    public function GowdownTwo($ProductId)
    {
        $conditionArray = array();
          
        if($ProductId != 0 && $ProductId != '' && $ProductId != 'undefined')
        {  $conditionArray['pos_stocks_detail.ProductId'] = $ProductId; }

        if($LocationId != 0 && $LocationId != '' && $LocationId != 'undefined')
        {  $conditionArray['pos_stocks_detail.LocationId'] = $LocationId; }

        $this->db->select_sum("Quantity");
        $this->db->from('pos_stocks_detail');
//        $this->db->join('pos_product_colours', 'pos_product_colours.ColourId = pos_stocks_detail.ColourId');
        $this->db->where($conditionArray);
        $this->db->where('ProductId', $ProductId);
        $this->db->where('LocationId', 2);
        $query = $this->db->get();
        return $query->result_array();
    }   

    public function GowdownThree($ProductId)
    {
        $conditionArray = array();
          
        if($ProductId != 0 && $ProductId != '' && $ProductId != 'undefined')
        {  $conditionArray['pos_stocks_detail.ProductId'] = $ProductId; }

        if($LocationId != 0 && $LocationId != '' && $LocationId != 'undefined')
        {  $conditionArray['pos_stocks_detail.LocationId'] = $LocationId; }

        $this->db->select_sum("Quantity");
        $this->db->from('pos_stocks_detail');
//        $this->db->join('pos_product_colours', 'pos_product_colours.ColourId = pos_stocks_detail.ColourId');
        $this->db->where($conditionArray);
        $this->db->where('ProductId', $ProductId);
        $this->db->where('LocationId', 3);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function GowdownFour($ProductId)
    {
        $conditionArray = array();
          
        if($ProductId != 0 && $ProductId != '' && $ProductId != 'undefined')
        {  $conditionArray['pos_stocks_detail.ProductId'] = $ProductId; }

        if($LocationId != 0 && $LocationId != '' && $LocationId != 'undefined')
        {  $conditionArray['pos_stocks_detail.LocationId'] = $LocationId; }

        $this->db->select_sum("Quantity");
        $this->db->from('pos_stocks_detail');
//        $this->db->join('pos_product_colours', 'pos_product_colours.ColourId = pos_stocks_detail.ColourId');
        $this->db->where($conditionArray);
        $this->db->where('ProductId', $ProductId);
        $this->db->where('LocationId', 4);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function GowdownFive($ProductId)
    {
        $conditionArray = array();
          
        if($ProductId != 0 && $ProductId != '' && $ProductId != 'undefined')
        {  $conditionArray['pos_stocks_detail.ProductId'] = $ProductId; }

        if($LocationId != 0 && $LocationId != '' && $LocationId != 'undefined')
        {  $conditionArray['pos_stocks_detail.LocationId'] = $LocationId; }

        $this->db->select_sum("Quantity");
        $this->db->from('pos_stocks_detail');
//        $this->db->join('pos_product_colours', 'pos_product_colours.ColourId = pos_stocks_detail.ColourId');
        $this->db->where($conditionArray);
        $this->db->where('ProductId', $ProductId);
        $this->db->where('LocationId', 5);
        $query = $this->db->get();
        return $query->result_array();
    }   

    public function GowdownSix($ProductId)
    {
        $conditionArray = array();
          
        if($ProductId != 0 && $ProductId != '' && $ProductId != 'undefined')
        {  $conditionArray['pos_stocks_detail.ProductId'] = $ProductId; }

        if($LocationId != 0 && $LocationId != '' && $LocationId != 'undefined')
        {  $conditionArray['pos_stocks_detail.LocationId'] = $LocationId; }

        $this->db->select_sum("Quantity");
        $this->db->from('pos_stocks_detail');
//        $this->db->join('pos_product_colours', 'pos_product_colours.ColourId = pos_stocks_detail.ColourId');
        $this->db->where($conditionArray);
        $this->db->where('ProductId', $ProductId);
        $this->db->where('LocationId', 6);
        $query = $this->db->get();
        return $query->result_array();
    }



        
}
?>