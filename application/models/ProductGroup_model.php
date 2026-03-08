<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class ProductGroup_model extends CI_Model{
    
    function __construct(){
    
        parent::__construct();
        $this->tbl_productgroup = "pos_productgroup";
        $this->tbl_category = "pos_category";
    }
    
        public function Ajax_GetAllProductGroups($requestData)
        {
               $columns = array( 
                        0 => 'ProductGroupName',
                        1 => 'ProductGroupId',
                        2 => 'CategoryName',
                );
                $sql = "SELECT pos_productgroup.ProductGroupId,pos_productgroup.ProductGroupName,pos_category.CategoryId,pos_category.CategoryName";
                $sql.=" FROM pos_productgroup";
                $sql.=" JOIN pos_category ON pos_productgroup.CategoryId = pos_category.CategoryId";
                //die($sql);
                $query= $this->db->query($sql); 
                //die('test');
                $totalData = $query->num_rows();
                $totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.

                if( !empty($requestData['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter
                       $sql.=" AND (CategoryName LIKE '".$requestData['search']['value']."%' ";
                       $sql.=" OR  ProductGroupName LIKE '".$requestData['search']['value']."%' )";
                }
                $query=$this->db->query( $sql) ;
                $totalFiltered = $query->num_rows(); // when there is a search parameter then we have to modify total number filtered rows as per search result. 
                $sql.=" ORDER BY ProductGroupName "."  LIMIT ".$requestData['start']." ,".$requestData['length']."   ";
                $query=$this->db->query($sql);  
                
                $array['record'] = $query->result_array();
                $array['recordsFiltered'] = $totalFiltered;
                $array['recordsTotal'] = $totalData;
                return $array;
   
        }

        
    function GetAllProductGroups()
    {
        $this->db->select('*')->from('pos_productgroup');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function TotalRecord()
    {
        $this->db->select('*')->from('pos_productgroup');
        $query = $this->db->get();
        return $query->num_rows();
    }

    
    public function GetProductGroupById($NewProductGroupId)
     {
        if ($NewProductGroupId === 0)
        {
            $query = $this->db->get('pos_productgroup');
            return $query->result_array();
        }
                
        $this->db->select('*');
        $this->db->from($this->tbl_productgroup);
        $this->db->join('pos_category', 'pos_category.CategoryId = pos_productgroup.CategoryId');
        $this->db->where('pos_productgroup.ProductGroupId',$NewProductGroupId);
        $query = $this->db->get();
        return $query->row();
     }
    
    public function SaveProductGroup($array,$id=0) 
        {
            $this->load->helper('url');
            if($id ==0)
            {
                $this->db->insert($this->tbl_productgroup,$array);
                return $NewProductGroupId = intval($this->db->insert_id());
            }
            else
            {
               $this->db->where('ProductGroupId',$id);
               if($this->db->update('pos_productgroup',$array))
               return $id;
            }    
        }

    public function DeleteProductGroup($ProductGroupId)
    {
        $this->db->where('ProductGroupId',$ProductGroupId);
        $this->db->delete('pos_productgroup');
        return true;
    }

    public function GetAllCategories($colmun = "*")
    {
        $this->db->select($colmun)->from($this->tbl_category);
        $GetAllCategories = $this->db->get();
        return ($GetAllCategories->result_array());
    }
}
?>