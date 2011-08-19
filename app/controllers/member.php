<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Member extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->helper('MY_others');
		if (whether_logged_in()==TRUE)
		{
			$this->data['login'] = TRUE;
		}
		else 
		{
			$this->data['login'] = FALSE;
		}
	}
	
	public function index()
	{
		redirect('member/login');
	}
	
	public function login()
	{
		//加载页头
		$data['login'] = $this->data['login'];
		$this->load->view('includes/v_header',$data);
		
		//判断用户是否已登陆
		if ($this->session->userdata('is_logged_in')==TRUE)
		{
			redirect('home/index');
		}
		else 
		{
			//加载登陆表单
			$this->load->view('v_form_login');
		}
		
		
		//加载页脚
		$this->load->view('includes/v_footer');
	}
	
	public function validate_credentials()
	{
		$this->load->model('membership_model');
		$query = $this->membership_model->validate();
		
		if($query) // 如果用户输入的用户名和密码正确
		{
			$data = array(
				'username' => $this->input->post('username'),
				'is_logged_in' => TRUE
			);
			$this->session->set_userdata($data);
			
			redirect('home/index');
		}
		else // 不正确的用户名和密码
		{
			//设置登录失败信息，并传递给视图
			$this->index(); //login控制器下的index，即返回表单
		}
	}
	
	function signup()
	{
		$data['login'] = $this->data['login'];
		$data['main_content'] = 'v_form_signup';
		$this->load->view('includes/v_template', $data);
	}
	
	function create_member()
	{
		$data['login'] = $this->data['login'];
		
		$this->load->library('form_validation');
		
		$this->form_validation->set_rules('username', 'Username', 'trim|required|max_length[50]');
		//$this->form_validation->set_rules('email_address', 'email_address', 'trim|required|valid_email');
		$this->form_validation->set_rules('password1', 'First Password', 'trim|required|max_length[50]');
		$this->form_validation->set_rules('password2', 'Second Password', 'trim|required|matches[password1]');
		
		
		if($this->form_validation->run() == FALSE)
		{
			$data['main_content'] = 'v_form_signup';
			$this->load->view('includes/v_template', $data);
		}
		else
		{			
			$this->load->model('membership_model');
			
			if($query = $this->membership_model->create_member())
			{
				$data['main_content'] = 'v_signup_successful';
				$this->load->view('includes/v_template', $data);
			}
			else
			{
				$data['error_registered_info'] = '该用户名已被注册';
				$data['main_content'] = 'v_form_signup';
				$this->load->view('includes/v_template', $data);
			}
		}
		
	}
	
	function logout()
	{
		$this->session->sess_destroy();
		$this->index();
	}
		
}
