<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Category_model extends CI_Model{
	
    function __construct(){
	
		parent::__construct();
		$this->tbl_category = "pos_category";
    }
	
        public function Ajax_GetAllCategories($requestData)
        {
               $columns = array( 
                        0 => 'CategoryName',
                        1 => 'CategoryId',
                        2 => 'CategoryStatus',
                );
                $sql = "SELECT CategoryId,CategoryName,CategoryStatus";
                $sql.=" FROM pos_category";
                //die($sql);
                $query= $this->db->query($sql); 
                //die('test');
                $totalData = $query->num_rows();
                $totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.
                $sql.=" WHERE 1=1 ";
                if( !empty($requestData['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter
                       $sql.=" AND (CategoryId LIKE '".$requestData['search']['value']."%' ";
                       $sql.=" OR  CategoryName LIKE '".$requestData['search']['value']."%' )";
                }
                $query=$this->db->query( $sql) ;
                $totalFiltered = $query->num_rows(); // when there is a search parameter then we have to modify total number filtered rows as per search result. 
                $sql.=" ORDER BY CategoryName ASC ". "  LIMIT ".$requestData['start']." ,".$requestData['length']."   ";
                $query=$this->db->query($sql);  
                
                $array['record'] = $query->result_array();
                $array['recordsFiltered'] = $totalFiltered;
                $array['recordsTotal'] = $totalData;
                return $array;
   
        }

        
    function GetAllCategories()
    {
        $this->db->select('*')->from('pos_category');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function TotalRecord()
    {
        $this->db->select('*')->from('pos_category');
        $query = $this->db->get();
        return $query->num_rows();
    }

	
    public function GetCategoryById($NewCategoryId)
     {
        if ($NewCategoryId === 0)
        {
            $query = $this->db->get('pos_category');
            return $query->result_array();
        }
				
		$this->db->select('*');
		$this->db->from($this->tbl_category);
		$this->db->where('pos_category.CategoryId',$NewCategoryId);
		$query = $this->db->get();
		return $query->row();
     }
	
	public function SaveCategory($array,$id=0) 
        {
            $this->load->helper('url');
            if($id ==0)
            {
                $this->db->insert($this->tbl_category,$array);
                return $NewCategoryId = intval($this->db->insert_id());
            }
            else
            {
               $this->db->where('CategoryId',$id);
               if($this->db->update('pos_category',$array))
               return $id;
            }    
        }

    public function DeleteCategory($CategoryId)
    {
        $this->db->where('CategoryId',$CategoryId);
        $this->db->delete('pos_category');
        return true;
    }
}
?>