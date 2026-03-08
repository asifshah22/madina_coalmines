<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class SaleReturnReport_model extends CI_Model{
	
	function __construct()
	{
        parent::__construct();
        $this->tbl_category = "pos_category";
        $this->tbl_company = "pos_company";
        $this->tbl_productgroup = "pos_productgroup";
        $this->tbl_products = "pos_products";
        $this->tbl_sales_return = "pos_sales_return";
        $this->tbl_sales_return_detail = "pos_sales_return_detail";
        $this->tbl_stocks = "pos_stocks";
        $this->tbl_customer = "pos_customer";
//            $this->output->enable_profiler;
	}
	
	
	function GetAllSales()
	{
	    $this->db->select('*');
	    $this->db->from($this->tbl_sales_return);
	    if ($this->session->userdata('CompanyId')!=0) { $this->db->where('CompanyId', $this->session->userdata('CompanyId'));}
	    $query = $this->db->get();
	    return $query->result_array();	
	}
	
	public function AllSalesReturn($CompanyId,$CustomerId,$ProductId,$LocationId,$ColourId,$CategoryId,$ProductGroupId,$BrandId,$StartDate,$EndDate)
	{
		$this->db->select('*');
		$this->db->from('pos_sales_return');
		$this->db->join('pos_sales_return_detail', 'pos_sales_return_detail.SaleReturnId = pos_sales_return.SaleReturnId');
		$this->db->join('pos_company', 'pos_company.CompanyId = pos_sales_return.CompanyId', 'left');
		$this->db->join('pos_customer', 'pos_customer.CustomerId = pos_sales_return.CustomerId');
		$this->db->join('pos_products', 'pos_products.ProductId = pos_sales_return_detail.ProductId', 'left');
		$this->db->join('pos_locations', 'pos_locations.LocationId = pos_sales_return_detail.LocationId','left');
		$this->db->join('pos_product_colours', 'pos_product_colours.ColourId = pos_sales_return_detail.ColourId', 'left');
		$this->db->join('pos_category', 'pos_category.CategoryId = pos_products.CategoryId','left');
		$this->db->join('pos_productgroup', 'pos_productgroup.ProductGroupId = pos_products.ProductGroupId');
		$this->db->join('pos_brands', 'pos_brands.BrandId = pos_products.BrandId');
		$this->db->where('pos_sales_return.CompanyId', $this->session->userdata('CompanyId'));

		if($CompanyId != 0){$this->db->where('pos_sales_return.CompanyId', $CompanyId);}
		if($CustomerId != 0){$this->db->where('pos_customer.CustomerId', $CustomerId);}
		if($ProductId != 0){$this->db->where('pos_products.ProductId', $ProductId);}
		if($LocationId != 0){$this->db->where('pos_locations.LocationId', $LocationId);}
		if($ColourId != 0){$this->db->where('pos_product_colours.ColourId', $ColourId);}
		if($CategoryId != 0){$this->db->where('pos_category.CategoryId', $CategoryId);}
		if($ProductGroupId != 0){$this->db->where('pos_productgroup.ProductGroupId', $ProductGroupId);}
		if($BrandId != 0){$this->db->where('pos_brands.BrandId', $BrandId);}
		if($StartDate != 0){$this->db->where('pos_sales_return.SaleReturnDate >=', $StartDate);}
		if($EndDate != 0){$this->db->where('pos_sales_return.SaleReturnDate <=', $EndDate);}
		$this->db->order_by('pos_sales_return.SaleReturnDate', "asc");
		$query = $this->db->get();
		return $query->result_array();
	}
	 
}
?>