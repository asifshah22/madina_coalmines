<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class SaleReport_model extends CI_Model{
	
	function __construct()
	{
            parent::__construct();

            $this->tbl_category = "pos_category";
            $this->tbl_customer = "pos_customer";
            $this->tbl_productgroup = "pos_productgroup";
            $this->tbl_products = "pos_products";
            $this->tbl_pos_salesorder_cart = "pos_salesorder_cart";
            $this->tbl_sales = "pos_sales";
            $this->tbl_sales_detail = "pos_sales_detail";
            $this->tbl_stocks = "pos_stocks";
            $this->tbl_references = "pos_references";
            $this->tbl_quotation = "pos_quotation";
			$this->tbl_quotation_detail = "pos_quotation_detail";
//            $this->output->enable_profiler;
	}
	
	function GetAllSalesByCustomer($CustomerId)
	{
	    $this->db->select('*');
	    $this->db->from($this->tbl_sales);
		$this->db->where('CustomerId',$CustomerId);
	    $query = $this->db->get();
	    return $query->result_array();	
	}
	
	
	function GetAllSales()
	{
	    $this->db->select('*');
	    $this->db->from($this->tbl_sales);
	    $query = $this->db->get();
	    return $query->result_array();	
	}


	public function AllSales($CustomerId,$SalemanId=0,$ReferenceId,$ProductId,$LocationId,$SaleType,$SaleMethod,$ColourId,$CategoryId,$ProductGroupId,$BrandId,$StartDate,$EndDate,$Counter=null)
	{

		$this->db->select('*,pos_customer.PhoneNo');
		$this->db->from('pos_sales');
		$this->db->join('pos_sales_detail', 'pos_sales_detail.SaleId = pos_sales.SaleId');
		$this->db->join('pos_customer', 'pos_customer.CustomerId = pos_sales.CustomerId', 'left');
		$this->db->join('pos_saleman', 'pos_saleman.SalemanId = pos_sales.SalemanId', 'left');
		$this->db->join('pos_products', 'pos_products.ProductId = pos_sales_detail.ProductId', 'left');
		$this->db->join('pos_locations', 'pos_locations.LocationId = pos_sales_detail.LocationId','left');
		$this->db->join('pos_product_colours', 'pos_product_colours.ColourId = pos_sales_detail.ColourId', 'left');
		$this->db->join('pos_references', 'pos_references.ReferenceId = pos_sales.ReferenceId', 'left');
		$this->db->join('pos_category', 'pos_category.CategoryId = pos_products.CategoryId','left');
		$this->db->join('pos_productgroup', 'pos_productgroup.ProductGroupId = pos_products.ProductGroupId');
		$this->db->join('pos_brands', 'pos_brands.BrandId = pos_products.BrandId');

		if($CustomerId != 0){$this->db->where('pos_customer.CustomerId', $CustomerId);}
		if($SalemanId != 0){$this->db->where('pos_sales.SalemanId', $SalemanId);}
		if($ReferenceId != 0){$this->db->where('pos_references.ReferenceId', $ReferenceId);}
		if($ProductId != 0){$this->db->where('pos_products.ProductId', $ProductId);}
		if($LocationId != 0){$this->db->where('pos_locations.LocationId', $LocationId);}
		if($Counter != 0){$this->db->where('pos_sales.Counter', $Counter);}
		if($SaleType != 0){$this->db->where('pos_sales.SaleType', $SaleType);}
		if($SaleMethod != "0"){$this->db->where('pos_sales.SaleMethod', $SaleMethod);}
		if($ColourId != 0){$this->db->where('pos_product_colours.ColourId', $ColourId);}
		if($CategoryId != 0){$this->db->where('pos_category.CategoryId', $CategoryId);}
		if($ProductGroupId != 0){$this->db->where('pos_productgroup.ProductGroupId', $ProductGroupId);}
		if($BrandId != 0){$this->db->where('pos_brands.BrandId', $BrandId);}
		if($StartDate != 0){$this->db->where('pos_sales.SaleDate >=', $StartDate);}
		if($EndDate != 0){$this->db->where('pos_sales.SaleDate <=', $EndDate);}
		//$this->db->order_by('pos_sales.SaleId', "asc");
		$this->db->order_by('pos_sales.SaleDate', "asc");
		$query = $this->db->get();
		return $query->result_array();
	}

    public function SaleReturnInvoiceReport($InvoiceNo)
	{        
		$this->db->select('*');
		$this->db->from('pos_sales_return');
		$this->db->join('pos_sales_return_detail', 'pos_sales_return_detail.SaleReturnId = pos_sales_return.SaleReturnId', 'left');
	
// 		$this->db->join('pos_area', 'pos_area.id = pos_customer.AreaId', 'left');
		$this->db->join('pos_references', 'pos_references.ReferenceId = pos_sales_return.ReferenceId', 'left');
		$this->db->join('pos_saleman', 'pos_saleman.SalemanId = pos_sales_return.SalemanId', 'left');
			$this->db->join('pos_customer', 'pos_customer.CustomerId = pos_sales_return.CustomerId', 'left');
		if($InvoiceNo) { $this->db->where('pos_sales_return.SaleReturnId', $InvoiceNo); }
		$query = $this->db->get();
		return $query->row();
	}

	public function SaleInvoiceReport($InvoiceNo)
	{        
		$this->db->select('*');
		$this->db->from('pos_sales');
		$this->db->join('pos_sales_detail', 'pos_sales_detail.SaleId = pos_sales.SaleId', 'left');
	
// 		$this->db->join('pos_area', 'pos_area.id = pos_customer.AreaId', 'left');
		$this->db->join('pos_references', 'pos_references.ReferenceId = pos_sales.ReferenceId', 'left');
		$this->db->join('pos_saleman', 'pos_saleman.SalemanId = pos_sales.SalemanId', 'left');
			$this->db->join('pos_customer', 'pos_customer.CustomerId = pos_sales.CustomerId', 'left');
		if($InvoiceNo) { $this->db->where('pos_sales.SaleId', $InvoiceNo); }
		$query = $this->db->get();
		return $query->row();
	}


	public function SaleInvoiceReportDetails($InvoiceNo)
	{
		$this->db->select('*,pos_sales_detail.ProductBarCode as BarCode');
		$this->db->from('pos_sales');
		$this->db->join('pos_sales_detail', 'pos_sales_detail.SaleId = pos_sales.SaleId', 'left');
		$this->db->join('pos_products', 'pos_products.ProductId = pos_sales_detail.ProductId', 'left');
		$this->db->join('pos_locations', 'pos_locations.LocationId = pos_sales_detail.LocationId','left');
		$this->db->join('pos_product_colours', 'pos_product_colours.ColourId = pos_sales_detail.ColourId', 'left');
		$this->db->join('pos_category', 'pos_category.CategoryId = pos_products.CategoryId','left');
		$this->db->join('pos_productgroup', 'pos_productgroup.ProductGroupId = pos_products.ProductGroupId', 'left');
		$this->db->join('pos_brands', 'pos_brands.BrandId = pos_products.BrandId', 'left');
		if($InvoiceNo) { $this->db->where('pos_sales.SaleId', $InvoiceNo); }
		$query = $this->db->get();
		return $query->result_array();
	}
	public function SaleRetunInvoiceReportDetails($InvoiceNo)
	{
		$this->db->select('*');
		$this->db->from('pos_sales_return');
		$this->db->join('pos_sales_return_detail', 'pos_sales_return_detail.SaleReturnId = pos_sales_return.SaleReturnId', 'left');
		$this->db->join('pos_products', 'pos_products.ProductId = pos_sales_return_detail.ProductId', 'left');
		$this->db->join('pos_locations', 'pos_locations.LocationId = pos_sales_return_detail.LocationId','left');
		$this->db->join('pos_product_colours', 'pos_product_colours.ColourId = pos_sales_return_detail.ColourId', 'left');
		$this->db->join('pos_category', 'pos_category.CategoryId = pos_products.CategoryId','left');
		$this->db->join('pos_productgroup', 'pos_productgroup.ProductGroupId = pos_products.ProductGroupId', 'left');
		$this->db->join('pos_brands', 'pos_brands.BrandId = pos_products.BrandId', 'left');
		if($InvoiceNo) { $this->db->where('pos_sales_return.SaleReturnId', $InvoiceNo); }
		$query = $this->db->get();
		return $query->result_array();
	}


	public function AllSalesReturn($CustomerId,$ProductId,$LocationId,$ColourId,$CategoryId,$ProductGroupId,$BrandId,$StartDate,$EndDate,$SaleReturnType=null)
	{
		$this->db->select('*');
		$this->db->from('pos_sales_return');
		$this->db->join('pos_sales_return_detail', 'pos_sales_return_detail.SaleReturnId = pos_sales_return.SaleReturnId');
		$this->db->join('pos_customer', 'pos_customer.CustomerId = pos_sales_return.CustomerId', 'left');
		$this->db->join('pos_references', 'pos_references.ReferenceId = pos_sales_return.ReferenceId', 'left');
		$this->db->join('pos_products', 'pos_products.ProductId = pos_sales_return_detail.ProductId', 'left');
		$this->db->join('pos_locations', 'pos_locations.LocationId = pos_sales_return_detail.LocationId','left');
		$this->db->join('pos_product_colours', 'pos_product_colours.ColourId = pos_sales_return_detail.ColourId', 'left');
		$this->db->join('pos_category', 'pos_category.CategoryId = pos_products.CategoryId','left');
		$this->db->join('pos_productgroup', 'pos_productgroup.ProductGroupId = pos_products.ProductGroupId');
		$this->db->join('pos_brands', 'pos_brands.BrandId = pos_products.BrandId');

		if($CustomerId != 0){$this->db->where('pos_customer.CustomerId', $CustomerId);}
		if($ProductId != 0){$this->db->where('pos_products.ProductId', $ProductId);}
		if($LocationId != 0){$this->db->where('pos_locations.LocationId', $LocationId);}
		if($ColourId != 0){$this->db->where('pos_product_colours.ColourId', $ColourId);}
		if($CategoryId != 0){$this->db->where('pos_category.CategoryId', $CategoryId);}
		if($ProductGroupId != 0){$this->db->where('pos_productgroup.ProductGroupId', $ProductGroupId);}
		if($BrandId != 0){$this->db->where('pos_brands.BrandId', $BrandId);}
		if($SaleReturnType != null){$this->db->where('pos_sales_return.SaleReturnType', $SaleReturnType);}
		if($StartDate != 0){$this->db->where('pos_sales_return.SaleReturnDate >=', $StartDate);}
		if($EndDate != 0){$this->db->where('pos_sales_return.SaleReturnDate <=', $EndDate);}
		//$this->db->order_by('pos_sales_return.SaleReturnId', "asc");
		$this->db->order_by('pos_sales_return.SaleReturnDate', "asc");
		$query = $this->db->get();
		return $query->result_array();
	}
	
	public function QuotationInvoiceReport($QuotationNo)
	{        
		$this->db->select('*,pos_customer.Address as customerAddress');
		$this->db->from('pos_quotation');
		$this->db->join('pos_quotation_detail', 'pos_quotation_detail.SaleId = pos_quotation.SaleId', 'left');
		$this->db->join('pos_customer', 'pos_customer.CustomerId = pos_quotation.CustomerId', 'left');
		$this->db->join('pos_references', 'pos_references.ReferenceId = pos_quotation.ReferenceId', 'left');
		if($QuotationNo) { $this->db->where('pos_quotation.SaleId', $QuotationNo); }
		$query = $this->db->get();
		return $query->row();
	}

	public function QuotationInvoiceReportDetails($QuotationNo)
	{
		$this->db->select('*,pos_quotation_detail.ProductBarCode as BarCode');
		$this->db->from('pos_quotation');
		$this->db->join('pos_quotation_detail', 'pos_quotation_detail.SaleId = pos_quotation.SaleId', 'left');
		$this->db->join('pos_products', 'pos_products.ProductId = pos_quotation_detail.ProductId', 'left');
		$this->db->join('pos_locations', 'pos_locations.LocationId = pos_quotation_detail.LocationId','left');
		$this->db->join('pos_product_colours', 'pos_product_colours.ColourId = pos_quotation_detail.ColourId', 'left');
		$this->db->join('pos_category', 'pos_category.CategoryId = pos_products.CategoryId','left');
		$this->db->join('pos_productgroup', 'pos_productgroup.ProductGroupId = pos_products.ProductGroupId', 'left');
		$this->db->join('pos_brands', 'pos_brands.BrandId = pos_products.BrandId', 'left');
		if($QuotationNo) { $this->db->where('pos_quotation.SaleId', $QuotationNo); }
		$query = $this->db->get();
		return $query->result_array();
	}

	 
}
?>