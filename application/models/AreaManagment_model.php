<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class AreaManagment_model extends CI_Model
{

    function __construct()
    {

        parent::__construct();
        $this->tbl_group = "pos_customer_type";
    }
    function GetAllCustomerType()
    {
        $this->db->select('*');
        $this->db->from('pos_customer_type');
        return ($this->db->get()->result_array());
    }

    public function Ajax_GetAllSalemanAreawise($requestData)
    {
        $columns = array(
            0 => 'id',
            1 => 'customer_type',
        );
        $sql = "SELECT * FROM pos_saleman_areas";
        $query = $this->db->query($sql);
        $totalData = $query->num_rows();
        $totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.

        if (!empty($requestData['search']['value'])) {
            // if there is a search parameter, $requestData['search']['value'] contains search parameter
            $sql .= " WHERE saleman_name LIKE '" . $requestData['search']['value'] . "%'";
        }

        $query = $this->db->query($sql);
        $totalFiltered = $query->num_rows(); // when there is a search parameter then we have to modify the total number of filtered rows as per search result.
        $sql .= " ORDER BY " . $columns[$requestData['order'][0]['column']] . " " . $requestData['order'][0]['dir'] . " LIMIT " . $requestData['start'] . " ," . $requestData['length'];
        $query = $this->db->query($sql);

        $array['record'] = $query->result_array();
        $array['recordsFiltered'] = $totalFiltered;
        $array['recordsTotal'] = $totalData;
        return $array;
    }
    
    public function Ajax_GetAllSalemanAreawise2()
    {
        $columns = array(
            0 => 'id',
            1 => 'customer_type',
        );
        
        $currentDate = date('l');
        $sql = "SELECT *
        FROM pos_saleman_areas
        WHERE day_sunday = ? 
        OR day_monday = ?
        OR day_tuesday = ?
        OR day_wednesday = ?
        OR day_thursday = ?
        OR day_friday = ?
        OR day_saturday = ?";

$query = $this->db->query($sql, array($currentDate, $currentDate, $currentDate, $currentDate, $currentDate, $currentDate, $currentDate));
        // $sql = "SELECT * FROM pos_saleman_areas";
        // $query = $this->db->query($sql);
        // $totalData = $query->num_rows();
        // $totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.

        $array= $query->result_array();
        return $array;
    }



    function GetAllBrands__old()
    {
        $this->db->select('*')->from('pos_groups');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function TotalRecord()
    {
        $this->db->select('*')->from('pos_saleman_areas');
        $query = $this->db->get();
        return $query->num_rows();
    }


    public function GetSalemanAreaeById($id, $show = NULL)
    {
        if ($id === 0) {
            $query = $this->db->get('pos_saleman_areas');
            return $query->result_array();
        }
        $dynamic_id = '';
        if (!empty($show) && $show == "show") {
            $dynamic_id = "saleman_id";
        } else {
            $dynamic_id = "id";
        }
        $query = $this->db->select('*');
        $query = $this->db->from("pos_saleman_areas");
        $query = $this->db->where("pos_saleman_areas.$dynamic_id", $id);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function SaveSalemanArea($array, $id = 0)
    {
     
     
        $this->load->helper('url');
        if ($id == 0) {
            $this->db->insert("pos_saleman_areas", $array);
            $NewGroupId = intval($this->db->insert_id());
            redirect("AreaManagment");
        }else{
            // dd($array);
            // die();
            $this->db->where(['pos_saleman_areas.id'=> $array['id']]);
            $this->db->update("pos_saleman_areas", $array);
            redirect("AreaManagment");
        }
    }

    public function DeleteGroup($GroupId)
    {
        $this->db->where('GroupId', $GroupId);
        $this->db->delete('pos_groups');
        return true;
    }

    public function GetAllSalemans()
    {
        $this->db->select('*');
        $this->db->from("pos_saleman");
        $query = $this->db->get();
        return $query->result_array();
    }
    public function GetAllAreas()
    {
        $this->db->select('*');
        $this->db->from("pos_area");
        $query = $this->db->get();
        return $query->result_array();
    }
    
    
}
