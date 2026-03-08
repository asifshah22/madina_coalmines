<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class PurchaseReturnReport_model extends CI_Model{
	
	function __construct()
	{
        parent::__construct();
        $this->tbl_category = "pos_category";
        $this->tbl_company = "pos_company";
        $this->tbl_stackholder = "pos_stackholders";
        $this->tbl_productgroup = "pos_productgroup";
        $this->tbl_products = "pos_products";
        $this->tbl_purchase_return = "pos_purchase_return";
        $this->tbl_purchase_return_detail = "pos_purchase_return_detail";
        $this->tbl_stocks = "pos_stocks";
        $this->tbl_vendor = "pos_vendor";
//            $this->output->enable_profiler;
	}
	
	
	function GetAllPurchase()
	{
	    $this->db->select('*');
	    $this->db->from($this->tbl_purchase_return);
	    if ($this->session->userdata('CompanyId')!=0) { $this->db->where('CompanyId', $this->session->userdata('CompanyId'));}
	    $query = $this->db->get();
	    return $query->result_array();	
	}

public function AllColumns()
{
	        
		$fields = $this->db->field_data('pos_purchase_return');

		foreach ($fields as $field)
		{
		   echo $field->name;
		}

}

	public function AllPurchaseReturnReport($CompanyId,$VendorId,$ProductId,$LocationId,$CategoryId,$ProductGroupId,$BrandId,$StartDate,$EndDate)
	{
		$this->db->select('*');
		$this->db->from('pos_purchase_return');
		$this->db->join('pos_purchase_return_detail', 'pos_purchase_return_detail.PurchaseReturnId = pos_purchase_return.PurchaseReturnId', 'left');
		$this->db->join('pos_company', 'pos_company.CompanyId = pos_purchase_return.CompanyId', 'left');
		$this->db->join('pos_vendor', 'pos_vendor.VendorId = pos_purchase_return.VendorId', 'left');
		$this->db->join('pos_products', 'pos_products.ProductId = pos_purchase_return_detail.ProductId', 'left');
		$this->db->join('pos_product_colours', 'pos_product_colours.ColourId = pos_purchase_return_detail.ColourId', 'left');
		$this->db->join('pos_locations', 'pos_locations.LocationId = pos_purchase_return_detail.LocationId', 'left');
		$this->db->join('pos_category', 'pos_category.CategoryId = pos_products.CategoryId','left');
		$this->db->join('pos_productgroup', 'pos_productgroup.ProductGroupId = pos_products.ProductGroupId', 'left');
		$this->db->join('pos_brands', 'pos_brands.BrandId = pos_products.BrandId', 'left');
		$this->db->where('pos_purchase_return.CompanyId', $this->session->userdata('CompanyId'));

		if($VendorId != 0){$this->db->where('pos_vendor.VendorId', $VendorId);}
		if($ProductId != 0){$this->db->where('pos_products.ProductId', $ProductId);}
		if($LocationId != 0){$this->db->where('pos_locations.LocationId', $LocationId);}
		if($CategoryId != 0){$this->db->where('pos_category.CategoryId', $CategoryId);}
		if($ProductGroupId != 0){$this->db->where('pos_productgroup.ProductGroupId', $ProductGroupId);}
		if($BrandId != 0){$this->db->where('pos_brands.BrandId', $BrandId);}
		if($StartDate != 0){$this->db->where('pos_purchase_return.PurchaseReturnDate >=', $StartDate);}
		if($EndDate != 0){$this->db->where('pos_purchase_return.PurchaseReturnDate <=', $EndDate);}
		$this->db->order_by('pos_purchase_return.PurchaseReturnDate', "asc");
		$query = $this->db->get();
		return $query->result_array();
	}
	 
}
?>