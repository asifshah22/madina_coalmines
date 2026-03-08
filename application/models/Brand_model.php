<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Brand_model extends CI_Model{
    
    function __construct(){
    
        parent::__construct();
        $this->tbl_brand = "pos_brands";
    }
    
        public function Ajax_GetAllBrands($requestData)
        {
               $columns = array( 
                        0 => 'BrandName',
                        1 => 'BrandId',
                );
                $sql = "SELECT BrandId,BrandName";
                $sql.=" FROM pos_brands";
                //die($sql);
                $query= $this->db->query($sql); 
                //die('test');
                $totalData = $query->num_rows();
                $totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.
		
		if( !empty($requestData['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter
                       $sql.=" AND (BrandName LIKE '".$requestData['search']['value']."%' )";
     //                  $sql.=" OR Email LIKE '".$requestData['search']['value']."%' )";  
                }

       //         if( !empty($requestData['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter
         //              $sql.=" AND (BrandId LIKE '".$requestData['search']['value']."%' ";
           //            $sql.=" OR  BrandName LIKE '".$requestData['search']['value']."%' )";
             //   }
                $query=$this->db->query( $sql) ;
                $totalFiltered = $query->num_rows(); // when there is a search parameter then we have to modify total number filtered rows as per search result. 
                $sql.=" ORDER BY ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']."  LIMIT ".$requestData['start']." ,".$requestData['length']."   ";
                $query=$this->db->query($sql);  
                
                $array['record'] = $query->result_array();
                $array['recordsFiltered'] = $totalFiltered;
                $array['recordsTotal'] = $totalData;
                return $array;
   
        }

        
    function GetAllBrands__old()
    {
        $this->db->select('*')->from('pos_brands');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function TotalRecord()
    {
        $this->db->select('*')->from('pos_brands');
        $query = $this->db->get();
        return $query->num_rows();
    }

    
    public function GetBrandById($NewBrandId)
     {
        if ($NewBrandId === 0)
        {
            $query = $this->db->get('pos_brands');
            return $query->result_array();
        }
                
        $this->db->select('*');
        $this->db->from($this->tbl_brand);
        $this->db->where('pos_brands.BrandId',$NewBrandId);
        $query = $this->db->get();
        return $query->row();
     }
    
    public function SaveBrand($array,$id=0) 
        {
            $this->load->helper('url');
            if($id ==0)
            {
                $this->db->insert($this->tbl_brand,$array);
                return $NewBrandId = intval($this->db->insert_id());
            }
            else
            {
               $this->db->where('BrandId',$id);
               if($this->db->update('pos_brands',$array))
               return $id;
            }    
        }

    public function DeleteBrand($BrandId)
    {
        $this->db->where('BrandId',$BrandId);
        $this->db->delete('pos_brands');
        return true;
    }
}
?>