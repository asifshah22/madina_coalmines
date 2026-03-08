<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {


	public function __construct(){
		parent::__construct();
		$this->load->model('Login_model');
		$this->load->model('Employee_model');
		$this->load->model('Customer_model');
	}


	public function index($msg = NULL)
	{
		$data['msg'] = $msg;
		$data['GetSettingInformation'] = $this->Employee_model->GetSettingInformation();
		$data['CustomerNotification'] = $this->Customer_model->GetNotifications();
		$this->load->view('index', $data);
	}
	
	public function VerifyUser()
	{
		$result = $this->Login_model->Validate();
		if(!$result)
		{
			$msg = '<font color=red>Invalid username and/or password.</font><br />';
			$this->index($msg);
		} else 	{
		redirect('Dashboard/','refresh'); }
	}
	
	public function Logout()
	{
		$this->session->unset_userdata('EmployeeId');
		$this->session->unset_userdata('CompanyId');
		session_destroy();
		redirect('Login');
	}
}
