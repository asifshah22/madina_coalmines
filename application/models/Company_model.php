<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Company_model extends CI_Model{
	
	function __construct(){
	
		parent::__construct();
		$this->tbl_company = "pos_company";
	}

    public function Ajax_GetAllCompanies($requestData)
    {
               $columns = array( 
                        0 => 'CompanyId',
                        1 => 'CompanyName',
                        2 => 'Address',
                        3 => 'NTN',
                        4 => 'FaxNo',
                        5 => 'Website',
                        6 => 'CompanyWarranty',
                );
                $sql = "SELECT CompanyId,CompanyName,Address,NTN,FaxNo,Website,CompanyWarranty";
                $sql.=" FROM pos_company";
                //die($sql);
                $query= $this->db->query($sql); 
                //die('test');
                $totalData = $query->num_rows();
                $totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.
                if($this->session->userdata('CompanyId') != 0){
                $sql.=" WHERE pos_company.CompanyId = ".$this->session->userdata('CompanyId'); }
                else{$sql.=" WHERE 1=1 "; }
                if( !empty($requestData['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter
                       $sql.=" AND (CompanyName LIKE '".$requestData['search']['value']."%' ";
                       $sql.=" OR Website LIKE '".$requestData['search']['value']."%' ";
                       $sql.=" OR NTN LIKE '".$requestData['search']['value']."%' ";
                       $sql.=" OR  Address LIKE '".$requestData['search']['value']."%' )";
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

        function GetAllCompanies()
        {
            $this->db->select('*');
            $this->db->from($this->tbl_company);
            if ($this->session->userdata('CompanyId') != 0){$this->db->where('pos_company.CompanyId', $this->session->userdata('CompanyId'));}
            $GetAllCompanies = $this->db->get();
            return ($GetAllCompanies->result_array());
        }
        
        
      function GetCompany($CompanyId)
      {
            $Result =  $this->db->get_where($this->tbl_company,array("CompanyId"=>$CompanyId))->row();
            return $Result;
      }
        
	
	    public function SaveCompany($data) 
      {
            $config['upload_path']   = 'images/company-logo/temp/';
            $config['allowed_types'] = 'gif|GIF|jpg|jpeg|JPG|png|PNG|BMP';
            $config['max_size']      = 10000;
            $UserFile = array();  
                    
            $this->load->library('upload', $config);
            if($this->upload->do_upload('CompanyLogo')) 
            {
              $CompanyLogo = $this->upload->data();
              $data['CompanyLogo'] = $CompanyLogo['orig_name'];
            }
                
            $config['image_library'] = 'gd2';
            $config['source_image'] = 'images/company-logo/temp/'.$data['CompanyLogo'];
            $config['new_image'] = 'images/company-logo/';
            $config['create_thumb'] = FALSE;
            $config['maintain_ratio'] = FALSE;
            $config['width']         = 150;
            $config['height']       = 150;

            $this->load->library('image_lib', $config);     
            $this->image_lib->resize();
            
            unlink("images/company-logo/temp/".$data['CompanyLogo']);

            $this->db->insert($this->tbl_company,$data);
            return $this->db->insert_id();
	      }
      
        public function UpdateCompany($data,$CompanyId)
        {
          $config['upload_path']   = 'images/company-logo/temp/';
          $config['allowed_types'] = 'gif|GIF|jpg|jpeg|JPG|png|PNG|BMP';
          $config['max_size']      = 10000;
                
          $this->load->library('upload', $config);
          if($this->upload->do_upload('CompanyLogo')) 
          {
            $CompanyLogo = $this->upload->data();
            $data['CompanyLogo'] = $CompanyLogo['orig_name'];

            $config['image_library'] = 'gd2';
            $config['source_image'] = 'images/company-logo/temp/'.$data['CompanyLogo'];
            $config['new_image'] = 'images/company-logo/';
            $config['create_thumb'] = FALSE;
            $config['maintain_ratio'] = FALSE;
            $config['width']         = 150;
            $config['height']       = 150;
        
            $this->load->library('image_lib', $config);     
            $this->image_lib->resize();
            
            unlink("images/company-logo/temp/".$data['CompanyLogo']);
            
            if($this->input->post('CompanyLogo') != "")
            unlink("images/company-logo/".$this->input->post('PreviousCompanyLogo'));
          }
          $this->db->where('CompanyId',$CompanyId);
          $this->db->update($this->tbl_company,$data);
          return $CompanyId;
      	}

        public function DeleteCompany($CompanyId)
        {
          $this->db->where('CompanyId', $CompanyId);
          $this->db->delete('pos_company');
          return true;
        }
}
?>