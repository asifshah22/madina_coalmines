<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Colour_model extends CI_Model{
	
    function __construct(){
	
		parent::__construct();
		$this->tbl_product_colours = "pos_product_colours";
    }
	
        
    function GetAllColours()
    {
        $this->db->select('*')->from('pos_product_colours');
//        if($this->session->userdata('CompanyId') !=0){$this->db->where('pos_product_colours.CompanyId', $this->session->userdata('CompanyId'));}
        $query = $this->db->get();
        return $query->result_array();
    }

    public function Ajax_GetAllColours($requestData)
    {
               $columns = array( 
                        0 => 'ColourName',
                        1 => 'ColourId',
                );
                $sql = "SELECT ColourId,ColourName";
                $sql.=" FROM pos_product_colours";
                //die($sql);
                $query= $this->db->query($sql); 
                //die('test');
                $totalData = $query->num_rows();
                $totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.
                $sql.=" WHERE 1=1 ";
                if( !empty($requestData['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter
                       $sql.=" AND (ColourId LIKE '".$requestData['search']['value']."%' ";
                       $sql.=" OR  ColourName LIKE '".$requestData['search']['value']."%' )";
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

    public function TotalRecord()
    {
        $this->db->select('*')->from('pos_product_colours');
//        if($this->session->userdata('CompanyId') !=0){$this->db->where('pos_product_colours.CompanyId', $this->session->userdata('CompanyId'));}
        $query = $this->db->get();
        return $query->num_rows();
    }

	
    public function GetColourById($NewColourId)
     {
        if ($NewColourId === 0)
        {
            $query = $this->db->get('pos_product_colours');
            return $query->result_array();
        }
				
		$this->db->select('*');
		$this->db->from($this->tbl_product_colours);
		$this->db->where('pos_product_colours.ColourId',$NewColourId);
		$query = $this->db->get();
		return $query->row();
     }
	
	public function SaveColour($array,$id=0) 
        {
            $this->load->helper('url');
            if($id ==0)
            {
                $this->db->insert($this->tbl_product_colours,$array);
                return $NewColourId = intval($this->db->insert_id());
            }
            else
            {
               $this->db->where('ColourId',$id);
               if($this->db->update('pos_product_colours',$array))
               return $id;
            }    
        }

    public function DeleteColour($ColourId)
    {
        $this->db->where('ColourId',$ColourId);
        $this->db->delete('pos_product_colours');
        return true;
    }
}
?>