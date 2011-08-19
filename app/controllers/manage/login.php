<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller {

	function __construct()
	{
		parent::__construct();
	}
	
	public function index()
	{
		$this->load->view('includes/v_header');
		$this->load->view('manage/v_form_login');
		$this->load->view('includes/v_footer');
	}

	public function validate_credentials()
	{
		$this->load->model('membership_model');
		$query = $this->membership_model->validate();
		
		if($query) // 如果用户输入的用户名和密码正确
		{
			$q = $this->membership_model->validate_administrator();
			if (!$q)//如果非管理员登录
			{
				$data = array(
					'username' => $this->input->post('username'),
					'is_logged_in' => true
				);
				$this->session->set_userdata($data);
			}
			else //如果是管理员登录 
			{
				$data = array(
					'username' => $this->input->post('username'),
					'is_logged_in_as_administrator' => true
				);
				$this->session->set_userdata($data);
			}
			
			redirect('manage/article/index');
		}
		else // 不正确的用户名和密码
		{
			//设置登录失败信息，并传递给视图
			$this->index(); //login控制器下的index，即返回表单
		}
	}

	public function logout()
	{
		$this->session->sess_destroy();
		$this->index();
	}
		
}
