<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Support extends CI_Controller {

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
		//加载页头
		$data['login'] = $this->data['login'];
		$this->load->view('includes/v_header',$data);
		
		//加载support介绍视图
		$this->load->view('support/v_support_intro');
		
		//加载页脚
		$this->load->view('includes/v_footer');
	}
	
	public function donate()
	{
		//加载页头
		$data['login'] = $this->data['login'];
		$this->load->view('includes/v_header',$data);
		
		//加载验证库并设置验证规则
		$this->load->library('form_validation');
		$this->form_validation->set_rules('amount', 'amount', 'trim|required');
    	$this->form_validation->set_rules('contact_info', 'contact info', 'trim|required|min_length[5]|max_length[250]');
		
		//验证没通过就显示表单
		if ($this->form_validation->run() == FALSE)
		{
			$this->load->view('support/v_support_donate');
		}
		else//通过验证
		{
			//存入提交上来的申请，状态为0，以表示等待确认
			$this->load->model('donate_model');
			if ($this->donate_model->insert_donation())
			{
				$this->load->view('support/v_support_donate_successful');
			}
			
			
		}

		
		//加载页脚
		$this->load->view('includes/v_footer');
	}

	

}




















