<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login_model extends CI_Model{
	
   function __construct(){	
	parent::__construct();
      $this->load->database();
   }
	
   public function Validate()
   {
      $EmailAddress = $this->security->xss_clean($this->input->post('UserName'));
      $Password = $this->security->xss_clean($this->input->post('Password'));
      $this->db->select('*');
      $this->db->from('pos_employees');
      $this->db->where('EmailAddress', $EmailAddress);
      $this->db->where('Password', $Password);
      $this->db->where('Status', 1);
      $query = $this->db->get();
      
      // If there is a user, then create session data
      if($query->num_rows() == 1) {
      $row = $query->row();
      $data = array(
      'EmployeeId' => $row->EmployeeId,
      'EmployeeName' => $row->EmployeeName,
      'EmailAddress' => $row->EmailAddress,
      'validated' => true
      );
      $this->session->set_userdata(array('EmployeeId'=>$row->EmployeeId,'EmployeeName'=>$row->EmployeeName,'EmployeeType'=>$row->EmployeeType,'ProfilePicture'=>$row->ProfilePicture));
      return true;
      }
      return false;
   }

}
?>