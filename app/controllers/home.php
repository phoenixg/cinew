<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller {
	
	var $data;

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
		
		//加载分类操作模型
		$this->load->model('type_model');
		
		//准备分配给视图的变量
		$data['type_cult_all'] = $this->type_model->get_type_cult_all();
		
		//加载进入cult分类视图
		$this->load->view('v_home_access_cult', $data);
		
		//加载进入翻译分类视图
		$this->load->view('v_home_access_trans');
		
		//加载页脚
		$this->load->view('includes/v_footer');
	}

	public function sendsecretmail()
	{
		//加载页头
		$data['login'] = $this->data['login'];
		$this->load->view('includes/v_header',$data);
		
		//加载phpmailer自定义辅助函数
		$this->load->helper('MY_phpmailer');
		
		//收件人, 主题, 内容,附件绝对路径，尽量用英文以避免乱码，且不要用HTML格式，用纯文本
		$mail_subject = "=?UTF-8?B?".base64_encode('是乱码吗')."?=";
		$mail_body = '<h1>测试</h1>fefefefe'; 
		
		//执行邮件发送，返回TRUE/FALSE
		smtp_mail('xxx@xx.com', $mail_subject, $mail_body, array());
		

		
		//加载页脚
		$this->load->view('includes/v_footer');
	}

	

}
