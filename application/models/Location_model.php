<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Location_model extends CI_Model{
    
    function __construct(){
        parent::__construct();
        $this->tbl_location = "pos_locations";
        $this->tbl_company = "pos_company";
    }
    
    public function FromLocations()
    {
        $this->db->select('*');
        $this->db->from('pos_locations');
        $this->db->where('LocationType', 5);
        if ($this->session->userdata('CompanyId') != 0){ $this->db->where('pos_locations.CompanyId', $this->session->userdata('CompanyId'));}
        $Query = $this->db->get();
        return $Query->result_array();
    }

    public function ToLocations()
    {
        $this->db->select('*');
        $this->db->from('pos_locations');
        $this->db->where('LocationType', 1);
        if ($this->session->userdata('CompanyId') != 0){ $this->db->where('pos_locations.CompanyId', $this->session->userdata('CompanyId'));}
        $Query = $this->db->get();
        return $Query->result_array();
    }

    public function GetLocation($LocationId)
    {
        $this->db->select("*")->from('pos_locations');
        $this->db->where('LocationId', $LocationId);
        $Query = $this->db->get();
        return $Query->row();
    }

    public function Ajax_GetAllLocations($requestData)
    {
               $columns = array( 
                        0 => 'LocationId',
                        1 => 'LocationName',
                        2 => 'Address',
                        3 => 'PhoneNo',
                );
                $sql = "SELECT LocationId,LocationName,Address,PhoneNo";
                $sql.=" FROM pos_locations";
                //die($sql);
                $query= $this->db->query($sql); 
                //die('test');
                $totalData = $query->num_rows();
                $totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.
                if($this->session->userdata('CompanyId') != 0){
                $sql.=" WHERE pos_locations.CompanyId = ".$this->session->userdata('CompanyId');}
                else{
                $sql.=" WHERE 1=1 ";
                }
                if( !empty($requestData['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter
                       $sql.=" AND (LocationId LIKE '".$requestData['search']['value']."%' ";
                       $sql.=" OR LocationName LIKE '".$requestData['search']['value']."%' ";
                       $sql.=" OR PhoneNo LIKE '".$requestData['search']['value']."%' ";
                       $sql.=" OR Address LIKE '".$requestData['search']['value']."%' )";
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

    public function GetAllLocation()
    {
        $this->db->select('*');
        $this->db->from('pos_locations');
        if ($this->session->userdata('CompanyId') != 0){ $this->db->where('pos_locations.CompanyId', $this->session->userdata('CompanyId'));}
        $Query = $this->db->get();
        return $Query->result_array();
    }

     
     public function SaveLocationDetail($Record)
     {
         $this->db->set($Record);
         $this->db->insert('pos_locations');
         return $LocationId =  $this->db->insert_id();
     }
     
     
     function GetCompany($CompanyId)
     {
        $this->db->select('*');
        $this->db->from('pos_company');
        $this->db->where('CompanyId', $CompanyId);
        $Query = $this->db->get();
        return $Query->result_array();
    }


     public function UpdateLocationDetail($Record, $LocationId)
     {
         $this->db->set($Record);
         $this->db->where('LocationId', $LocationId);
         $this->db->update('pos_locations');
         return $LocationId;
     }

     
     public function DeleteLocation($LocationId)
     {
         $this->db->set();
         $this->db->where('LocationId', $LocationId);
         $this->db->delete('pos_locations');
         return true;
     }

    }