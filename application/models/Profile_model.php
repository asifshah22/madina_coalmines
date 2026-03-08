<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Profile_model extends CI_Model{
	
    function __construct(){
	
		parent::__construct();
        $this->tbl_employee = "pos_employees";
		$this->tbl_designation = "pos_designations";
    }

    public function GetEmployee($EmployeeId, $colmun='*')
    {             
           $this->db->select($colmun)->from($this->tbl_employee)->where('EmployeeId',$this->session->userdata('EmployeeId'));
//           $this->db->join($this->tbl_designation,'pos_designations.DesignationId=pos_employees.DesignationId', 'left');
//           $this->db->join($this->tbl_employee,'pos_company.EmployeeId=pos_employees.EmployeeId', 'left');
           return $this->db->get()->row();
    }

    public function UpdateProfile___($EmployeeId, $Record)
    {
        $this->db->set($Record);
        $this->db->where('EmployeeId',$EmployeeId);
        $this->db->update('pos_employees');
        return true;
    }

    public function UpdateProfile($EmployeeId,$data)
    {
        $config['upload_path']   = 'images/profile-picture/';
        $config['allowed_types'] = 'gif|GIF|jpg|jpeg|JPG|png|PNG|BMP';
        $config['max_size']      = 10000;
        $UserFile = array();  

        if ($_FILES['ProfilePicture']['name'] == "" || $_FILES['ProfilePicture']['name'] == NULL) {
            $this->load->library('upload', $config);
            $this->upload->initialize($config);
            $this->upload->do_upload('ProfilePicture');
            $ProfilePicture = $this->upload->data();
            $data['ProfilePicture'] = $this->input->post('ProfilePicture');
        }
        else{
            $this->load->library('upload', $config);
            $this->upload->initialize($config);
            $this->upload->do_upload('ProfilePicture');
            $ProfilePicture = $this->upload->data();
            $data['ProfilePicture'] = $ProfilePicture['orig_name'];
        }
                    
/*        $this->load->library('upload', $config);
            if($this->upload->do_upload('ProfilePicture')) 
            {
              $ProfilePicture = $this->upload->data();
              $data['ProfilePicture'] = $ProfilePicture['orig_name'];
            }*/
                
            $config['image_library'] = 'gd2';
            $config['source_image'] = 'images/profile-picture/'.$data['ProfilePicture'];
            $config['new_image'] = 'images/profile-picture/';
            $config['create_thumb'] = FALSE;
            $config['maintain_ratio'] = FALSE;
            $config['width']         = 200;
            $config['height']       = 200;

            $this->load->library('image_lib', $config);     
            $this->image_lib->resize();
            
//        unlink("images/profile-picture/".$data['ProfilePicture']);
    
        $this->db->set('ProfilePicture', $data['ProfilePicture']);
        $this->db->where('EmployeeId',$EmployeeId);
        $this->db->update('pos_employees');
        return $EmployeeId;
    }

    public function UpdatePassword($EmployeeId, $Password)
    {
        $this->db->set('Password', $Password);
        $this->db->where('EmployeeId',$EmployeeId);
        $this->db->update('pos_employees');
        return true;
    }
}
?>