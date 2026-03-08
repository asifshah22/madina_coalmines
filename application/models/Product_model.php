<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Product_model extends CI_Model{
	
	function __construct()
	{
		parent::__construct();
		$this->tbl_category = "pos_category";
		$this->tbl_productgroup = "pos_productgroup";
		$this->tbl_brand = "pos_brands";
		$this->tbl_product = "pos_products";
		$this->tbl_colours = "pos_product_colours";
		$this->tbl_location = "pos_locations";
		$this->tbl_stocks_detail = "pos_stocks_detail";
	}
	
	function GetAllCategories($colmun = "*")
	{
	    $this->db->select($colmun)->from($this->tbl_category);
	    $GetAllCategories = $this->db->get();
	    return ($GetAllCategories->result_array());
	}
	
	
	function GetAllProducts($colmun = "*") 
	{
	    $this->db->select($colmun);
	    $this->db->from($this->tbl_product);
	    $this->db->join('pos_productgroup', $this->tbl_product.'.ProductGroupId = pos_productgroup.ProductGroupId', 'left');
	    $this->db->join('pos_brands', $this->tbl_product.'.BrandId = pos_brands.BrandId', 'left');
	    $GetAllProducts = $this->db->get();
	    return ($GetAllProducts->result_array());
	}
        
	
	function GetAllBrands() 
	{
	    $this->db->select('*');
	    $this->db->from('pos_brands');
	    return ($this->db->get()->result_array());
	}
	
	
	function GetAllColours() 
	{	    
	    $this->db->select('ColourId,ColourName')->from($this->tbl_colours);
	    $query = $this->db->get();
	    return $query->result_array();
	}

       public function Ajax_GetAllProducts($requestData)
        {
               $columns = array( 
                    0 => 'ProductName',
                    1 => 'BrandName',
                    2 => 'CategoryName',
                    3 => 'ProductId',
                );
                $sql = "SELECT *";
                $sql.=" FROM pos_products";
                $sql.=" JOIN pos_category ON pos_products.CategoryId = pos_category.CategoryId";
                $sql.=" JOIN pos_brands ON pos_products.BrandId = pos_brands.BrandId";
                $query= $this->db->query($sql); 
                //die('test');
                $totalData = $query->num_rows();
                $totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.
                $sql.=" WHERE 1=1 ";
                if( !empty($requestData['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter
                       $sql.=" AND (CategoryName LIKE '".$requestData['search']['value']."%' ";
                       $sql.=" OR ProductName LIKE '".$requestData['search']['value']."%' ";
                       $sql.=" OR  BrandName LIKE '".$requestData['search']['value']."%' )";
                }
                $query=$this->db->query( $sql) ;
                $totalFiltered = $query->num_rows(); // when there is a search parameter then we have to modify total number filtered rows as per search result. 
                $sql.=" ORDER BY ProductName "."  LIMIT ".$requestData['start']." ,".$requestData['length']."   ";
                $query=$this->db->query($sql);  
                
                $array['record'] = $query->result_array();
                $array['recordsFiltered'] = $totalFiltered;
                $array['recordsTotal'] = $totalData;
                return $array;
   
        }
	
    
	function GetProduct($ProductId, $colmun='*' ) 
	{
	    $this->db->select($colmun);
	    $this->db->from('pos_products');
	    $this->db->join('pos_category','pos_category.CategoryId=pos_products.CategoryId');
	    $this->db->join('pos_productgroup','pos_productgroup.ProductGroupId=pos_products.ProductGroupId');
	    $this->db->join('pos_brands','pos_brands.BrandId=pos_products.BrandId');
	    $this->db->where('ProductId',$ProductId);
	    $result = $this->db->get()->row();
	    return $result;
        }
	
/*	function GetAllProducts($colmun = "*", $ProductId = 0)
		{
	    $this->db->select($colmun);
	    $this->db->from($this->tbl_product);
	    $this->db->join($this->tbl_productgroup, $this->tbl_productgroup.'.ProductGroupId = '.$this->tbl_product.'.ProductGroupId');
	    $this->db->join($this->tbl_category, $this->tbl_category.'.CategoryId = '.$this->tbl_product.'.CategoryId');
	    $this->db->join($this->tbl_brand, $this->tbl_brand.'.BrandId = '.$this->tbl_product.'.BrandId');
	    if($ProductId != 0){ $this->db->where('pos_products.ProductId',$ProductId); }
	    $query = $this->db->get();
	    return $query->result_array();	
        }*/

	
/*	function GetAllProducts($colmun = "*")
	{
		$this->db->select($colmun);
		$this->db->from($this->tbl_product);
		$this->db->join($this->tbl_productgroup, $this->tbl_productgroup.'.ProductGroupId = '.$this->tbl_product.'.ProductGroupId');
		$this->db->join($this->tbl_category, $this->tbl_category.'.CategoryId = '.$this->tbl_product.'.CategoryId');
		$this->db->join($this->tbl_brand, $this->tbl_brand.'.BrandId = '.$this->tbl_product.'.BrandId');
		$this->db->join($this->tbl_stocks_detail, $this->tbl_stocks_detail.'.ProductId = '.$this->tbl_product.'.ProductId');
		$this->db->join($this->tbl_colours, $this->tbl_colours.'.ColourId = '.$this->tbl_stocks_detail.'.ColourId');
		$this->db->join($this->tbl_location, $this->tbl_location.'.LocationId = '.$this->tbl_stocks_detail.'.LocationId', 'left');
		$query = $this->db->get();
		return $query->result_array();
    }*/
        
	function GetProductsByCategoryId($CategoryId) 
	{
	
		$this->db->select('pos_productgroup.ProductGroupId, pos_productgroup.ProductGroupName');
		$this->db->from($this->tbl_productgroup);
		$this->db->where('pos_productgroup.CategoryId',$CategoryId);
		$query = $this->db->get();
        return $result = $query->result_array();
    }

	function get_pos_products($q)
	{
    	$this->db->select('BrandName');
    	$this->db->like('BrandName', $q);
    	$query = $this->db->get('pos_products');
    	if($query->num_rows() > 0)
		{
      		foreach ($query->result_array() as $row)
			{
        		$row_set[] = htmlentities(stripslashes($row['BrandName'])); //build an array
     		}
      echo json_encode($row_set); //format the array into json data
    	}
  	}
	
//	$query = $this->db->query("YOUR QUERY");
//	$row = $query->row_array();
	
	 function GetProductByBrandId($BrandId)
	 {
	 	//print $BrandName;
		//print "<r>";
	 	//print $Val = gettype($BrandName);
		
  		$this->db->select('*');
		$this->db->from($this->tbl_product);
		$this->db->join($this->tbl_productgroup, $this->tbl_productgroup.'.ProductGroupId = '.$this->tbl_product.'.ProductGroupId');
		$this->db->where('pos_products.BrandName',$BrandName);
		$query = $this->db->get();
		//return $query->row_array();
		return ($query->result_array());	
        }
        
        /* useless now but keep for few days more
        function ProductOpeningQuantityForStock($ProductId)
	 {
	 	if($ProductId == 0 )
                {
                     $this->db->select('pos_products.ProductId,pos_products.OpenningQuantityUnit')->from('pos_products');
                     $query = $this->db->get();
                }
                else
                {
                    $this->db->select('pos_products.ProductId,pos_products.OpenningQuantityUnit')->from('pos_products');
                    $this->db->where('pos_products.ProductId',$ProductId);
                    $query = $this->db->get();
                }
                return $query->result_array();
        }
	*/
	function GetProductByBrandName($BrandName)
	{
	 	//print $BrandName;
		//print "<r>";
	 	//print $Val = gettype($BrandName);
		
  		$this->db->select('*');
		$this->db->from($this->tbl_product);
		$this->db->join($this->tbl_productgroup, $this->tbl_productgroup.'.ProductGroupId = '.$this->tbl_product.'.ProductGroupId');
		$this->db->where('pos_products.BrandName',$BrandName);
		$query = $this->db->get();
		//return $query->row_array();
		return ($query->result_array());	
        }
	
	function GetAllProductsByGroupId($ProductGroupId)
	 {
  		$this->db->select('*');
		$this->db->from($this->tbl_product);
		$this->db->join($this->tbl_productgroup, $this->tbl_productgroup.'.ProductGroupId = '.$this->tbl_product.'.ProductGroupId');
	//	$this->db->join($this->tbl_category, $this->tbl_category.'.CategoryId = '.$this->tbl_product.'.CategoryId');
		$this->db->where('pos_products.ProductGroupId',$ProductGroupId);
		$query = $this->db->get();
		return ($query->result_array());	
        }

		
	function SaveProductDetail($data) 
        {
          $path = './uploads/products/';

            if(!is_dir('./uploads/products/'))
            {
                $path = mkdir('./uploads/products/', 0777, true);
            }

            $config['upload_path'] = $path;
            $config['allowed_types'] = 'gif|GIF|jpg|jpeg|JPG|png|PNG|BMP';
            $config['max_size']      = 10000;
            $UserFile = array();  
                    
            $this->load->library('upload', $config);
            if($this->upload->do_upload('ProductImage')) 
            {
              $ProductImage = $this->upload->data();
              $data['ProductImage'] = $ProductImage['orig_name'];
            }
                
            $config['image_library'] = 'gd2';
            $config['create_thumb'] = FALSE;
            $config['maintain_ratio'] = TRUE;
            $config['width']         = 150;
            $config['height']       = 150;

            $this->load->library('image_lib', $config);     
            $this->image_lib->resize();
            
		$this->db->insert($this->tbl_product,$data);
		return $this->db->insert_id();
        }
	
	
	function UpdateProductDetail($Data,$ProductId)
        {
	    
          $path = './uploads/products/';

            if(!is_dir('./uploads/products/'))
            {
                $path = mkdir('./uploads/products/', 0777, true);
            }

            $config['upload_path'] = $path;
            $config['allowed_types'] = 'gif|GIF|jpg|jpeg|JPG|png|PNG|BMP';
            $config['max_size']      = 10000;
            $UserFile = array();  
                    
            $this->load->library('upload', $config);
            if($this->upload->do_upload('ProductImage')) 
            {
              $ProductImage = $this->upload->data();
              $Data['ProductImage'] = $ProductImage['orig_name'];
            }
                
            $config['image_library'] = 'gd2';
            $config['create_thumb'] = FALSE;
            $config['maintain_ratio'] = TRUE;
            $config['width']         = 150;
            $config['height']       = 150;

            $this->load->library('image_lib', $config);     
            $this->image_lib->resize();

/*            echo $ProductImage['orig_name'];
            die;*/

		$this->db->where('ProductId',$ProductId)->update($this->tbl_product,$Data);  
	    
		return $ProductId;
        }

	
	public function DeleteProduct($ProductId)
	{
	    $this->db->where('ProductId', $ProductId);
	    $this->db->delete('pos_products');
	    return true;
	}
	function GetProducts($SDate,$EDate,$CategoryId,$ProductGroupId,$BrandId) 
	{
		
		if ($CategoryId == 0)
        {
            $this->db->select('*')->from('pos_category');
			$query = $this->db->get();
			$GetCategory = $query->result_array();
        }else{
			$this->db->select('*');
			$this->db->from('pos_category');
			$this->db->where('pos_category.CategoryId',$CategoryId);
			$query = $this->db->get();
			$GetCategory = $query->result_array();
		}
		$FinalArray = [];
		if($GetCategory){
			$j = 0;
			foreach($GetCategory as $Category){
        
				$conditionArray = array();
			
				if($Category['CategoryId'] != 0 && $Category['CategoryId'] != '' && $Category['CategoryId'] != 'undefined')
				{  $conditionArray['pos_products.CategoryId'] = $Category['CategoryId']; }
		
				if($BrandId != 0 && $BrandId != '' && $BrandId != 'undefined')
				{  $conditionArray['pos_products.BrandId'] = $BrandId; }
		
				if($ProductGroupId != 0 && $ProductGroupId != '' && $ProductGroupId != 'undefined')
				{  $conditionArray['pos_products.ProductGroupId'] = $ProductGroupId; }
		        
				$ConditionDate = " 1=1 AND pos_stocks_detail.InOutDate BETWEEN '".$SDate."' AND '".$EDate."' AND (pos_stocks_detail.StockType = 1  OR pos_stocks_detail.StockType = 0 OR pos_stocks_detail.StockType = 4)";
		
				$this->db->select('pos_products.Policy,pos_products.PurchasePrice,pos_products.FinalPrice,pos_stocks_detail.Rate,pos_products.ProductDetails,pos_products.ProductId,pos_products.ProductGroupId,pos_products.BrandId,pos_products.CategoryId,pos_products.ProductName,pos_productgroup.ProductGroupName,pos_brands.BrandName,pos_stocks_detail.Amount,SUM(pos_stocks_detail.Quantity) AS Quantity');
				$this->db->from($this->tbl_product);
				$this->db->join('pos_stocks_detail', $this->tbl_product.'.ProductId = pos_stocks_detail.ProductId', 'left');
				$this->db->join('pos_productgroup', $this->tbl_product.'.ProductGroupId = pos_productgroup.ProductGroupId', 'left');
				$this->db->join('pos_brands', $this->tbl_product.'.BrandId = pos_brands.BrandId', 'left');
				$this->db->where($conditionArray);
				$this->db->where($ConditionDate);
				$this->db->group_by('pos_stocks_detail.ProductId');
				$this->db->order_by("pos_productgroup.ProductGroupName", "asc");
				$this->db->order_by("pos_brands.BrandName", "asc");
				$this->db->order_by("pos_products.ProductName", "asc");
				$query = $this->db->get();
				$AllProducts = $query->result_array();
				//print_r($AllProducts); exit;
				if(!$AllProducts){ continue; }

				$i = 0;
				$Products = array();
				foreach($AllProducts as $products){
					$PurchaseReturnQuantity = 0;
                	$SaleQuantity = 0;
					$AllPurchaseReturnRecord = $this->StockReport_model->GetPurchaseReturnRecord($SDate,$EDate,$products['CategoryId'],$products['ProductGroupId'],$products['BrandId']);
					$AllSaleRecord           = $this->StockReport_model->GetSaleRecord($SDate,$EDate,$products['CategoryId'],$products['ProductGroupId'],$products['BrandId']);
					
					// Getting Total Purchase Return Quantity
                    if(isset($AllPurchaseReturnRecord))
                    {
                        foreach($AllPurchaseReturnRecord as $PurchaseReturnRecord)
                        { 
                            if($PurchaseReturnRecord['ProductId'] == $products['ProductId'])
                            { 
                            	$PurchaseReturnQuantity = $PurchaseReturnRecord['Quantity'];
                            }
                        }
                    }
                    // Getting Total Sale Quantity
                    if(isset($AllSaleRecord))
                    {
                        foreach($AllSaleRecord as $SaleRecord)
                        { 
                            if($SaleRecord['ProductId'] == $products['ProductId'])
                            {
                        		$SaleQuantity = $SaleRecord['Quantity']; 
                            }
                        }
                    }
					// if($products['ProductId'] == 85){
					// 	echo $products['Quantity']. " ".($SaleQuantity + $PurchaseReturnQuantity); exit;
					// }
					if(($products['Quantity'] - ($SaleQuantity + $PurchaseReturnQuantity)) <= 0){
                        continue;
                    }
					$Products[$i]['ProductId'] 		= $products['ProductId'];
					$Products[$i]['ProductGroupName'] = $products['ProductGroupName'];
					$Products[$i]['BrandName'] 		= $products['BrandName'];
					$Products[$i]['ProductName'] 		= $products['ProductName'];
					$Products[$i]['ProductDetails'] 	= $products['ProductDetails'];
					$Products[$i]['Quantity'] 		= $products['Quantity'];
					$Products[$i]['FinalPrice'] 		= $products['FinalPrice'];
					$Products[$i]['Policy'] 			= $products['Policy'];
					$Products[$i]['PurchasePrice'] 	= $products['PurchasePrice'];
					$i++;
				}
				
                if(!$Products){ continue; }
				$FinalArray[$j] = array(
					'CategoryName' => $Category['CategoryName'],
					'Products' => $Products
				);
				$Products = [];
				$j++;

			}
			
		}

		return $FinalArray;
    }
	function GetProductsPrice($SDate,$EDate,$CategoryId,$ProductGroupId,$BrandId) 
	{

		$conditionArray = array();
	
		if($CategoryId != 0 && $CategoryId != '' && $CategoryId != 'undefined')
		{  $conditionArray['pos_products.CategoryId'] = $CategoryId; }

		if($BrandId != 0 && $BrandId != '' && $BrandId != 'undefined')
		{  $conditionArray['pos_products.BrandId'] = $BrandId; }

		if($ProductGroupId != 0 && $ProductGroupId != '' && $ProductGroupId != 'undefined')
		{  $conditionArray['pos_products.ProductGroupId'] = $ProductGroupId; }
		
		$ConditionDate = " 1=1 AND pos_stocks_detail.InOutDate BETWEEN '".$SDate."' AND '".$EDate."'";

		$this->db->select('pos_products.ProductId,pos_stocks_detail.Amount,pos_stocks_detail.Quantity');
		$this->db->from($this->tbl_product);
		$this->db->join('pos_stocks_detail', $this->tbl_product.'.ProductId = pos_stocks_detail.ProductId', 'left');
		$this->db->join('pos_productgroup', $this->tbl_product.'.ProductGroupId = pos_productgroup.ProductGroupId', 'left');
		$this->db->join('pos_brands', $this->tbl_product.'.BrandId = pos_brands.BrandId', 'left');
		$this->db->where($conditionArray);
		$this->db->where($ConditionDate);
		$this->db->where('pos_stocks_detail.PurchaseId !=', null);
		$query = $this->db->get();
		$AllProducts = $query->result_array();
		
		$i = 0;
		$result = array();
		foreach($AllProducts as $products){
		
			$k = 0;
			for($j=0; $j<$i; $j++){
				if($result[$j]['ProductId'] == $products['ProductId'])
				{
					$result[$j]['Amount']   += $products['Amount'];
					$result[$j]['Quantity'] += $products['Quantity'];
					$k++;
				}
			}
			if($k != 0){
				continue;
			}

			$result[$i]['ProductId'] = $products['ProductId'];
			$result[$i]['Quantity']  = $products['Quantity'];
			$result[$i]['Amount']    = $products['Amount'];
			$i++;
		}

		return $result;
    }
}
?>