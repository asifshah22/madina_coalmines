<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Setting_model extends CI_Model{
    
    function __construct(){
        parent::__construct();
        $this->tbl_setting = "pos_setting";
    }

    function GetAllSettings()
    {
        $this->db->select('*');
        $this->db->from($this->tbl_setting);
        if ($this->session->userdata('SettingId') != 0){$this->db->where('pos_setting.SettingId', $this->session->userdata('SettingId'));}
        $GetAllSettings = $this->db->get();
        return ($GetAllSettings->result_array());
    }
        
        
    function GetSetting($SettingId)
   {
        $this->db->select('*');
        $this->db->from('pos_setting');
        $this->db->where('SettingId', $SettingId);
        $Result = $this->db->get();
        return $Result->row();

        }
        
    
    public function SaveSetting($array) 
    {
        $this->db->insert($this->tbl_setting,$array);
        return $this->db->insert_id();
    }
      

    public function UpdateSetting($data,$SettingId)
    {
        if($_FILES['CompanyLogo']['name'] == ""){
            $data['CompanyLogo'] = $this->input->post('PreviousLogo');
        }
        else{
            $path = './images/company-logo/';

            $config['upload_path'] = $path;
            $config['allowed_types'] = 'gif|GIF|jpg|jpeg|JPG|png|PNG|BMP';
            $config['max_size']      = 10000;
            
            $this->load->library('upload', $config);

            if ( ! $this->upload->do_upload('CompanyLogo'))
            {
                die($this->upload->display_errors());
            }

            else
            {
                $this->upload->data();
            }

            $data['CompanyLogo'] = $_FILES['CompanyLogo']['name'];
/*            if($this->upload->do_upload('CompanyLogo'))
            {
              $CompanyLogo = $this->upload->data();
              $data['CompanyLogo'] = $CompanyLogo['orig_name'];
            }*/

        }
        
         if($_FILES['signature']['name'] == ""){
            $data['signature'] = $this->input->post('signatureold');
        }
        else{
            $path = './images/signature/';

            $config['upload_path'] = $path;
            $config['allowed_types'] = 'gif|GIF|jpg|jpeg|JPG|png|PNG|BMP';
            $config['max_size']      = 10000;
            
            $this->load->library('upload', $config);

            if ( ! $this->upload->do_upload('signature'))
            {
                die($this->upload->display_errors());
            }

            else
            {
                $this->upload->data();
            }

            $data['signature'] = $_FILES['signature']['name'];


        }

//        echo $CompanyLogo;
/*        echo $data['CompanyLogo'];
        die;
*/

        $this->db->where('SettingId',$SettingId);
        $this->db->update($this->tbl_setting,$data);
        return $SettingId;
    
    }

    public function DeleteSetting($SettingId)
    {
        $this->db->where('SettingId', $SettingId);
        $this->db->delete('pos_setting');
        return true;
    }
}

?>