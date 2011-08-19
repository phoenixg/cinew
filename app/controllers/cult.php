<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cult extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		
		$this->load->helper('MY_others');
		$this->load->helper('date');
		
		if (whether_logged_in()==TRUE)
		{
			$this->data['login'] = TRUE;
		}
		else 
		{
			$this->data['login'] = FALSE;
		}
	}
	
	function index()
	{
		
	}
	
	//显示从首页选择而来的相应cult下的文章
	public function show()
	{
		//加载页头
		$data['login'] = $this->data['login'];
		$this->load->view('includes/v_header',$data);
		
		//加载类型操作模型、文章操作模型、用户操作模型
		$this->load->model('type_model');
		$this->load->model('article_model');
		$this->load->model('membership_model');
		$this->load->model('count_visit_model');
		
		//获取segment的参数
		$cult_id 			= $this->uri->segment(3,0);//cult类型，如UBF、YD
		$type_article_id	= $this->uri->segment(4,1);//文章类型，如news、testimonies
		$article_id			= $this->uri->segment(5,0);//文章id，如1、2、3
		
		//先判断该segment参数是否正确：是否在数据库中存在，如果不正确就跳转到404错误页面
		$cult_exist = $this->type_model->whether_cult_exist($cult_id);
		if (!$cult_exist) show_404();
		
		//根据当前segment里的文章类型，进行判定
		$type_article_exist = $this->type_model->whether_type_article_exist($type_article_id);
		if (!$type_article_exist) show_404();
		
		//根据当前segment里的文章id，进行判定
		$article_exist = $this->article_model->whether_article_exist($article_id);
		if (!$article_exist && !empty($article_id)) show_404();
		
		//执行统计存入
		if ($article_id!==0)
		{
			$exist = $this->count_visit_model->whether_article_id_exist($article_id);
			if (!$exist) 
			{
				$this->count_visit_model->insert_count($article_id,$count=1);
			}
			else 
			{
				$this->count_visit_model->count_plus_one($article_id);
			}
		}
		
		//左侧的文章标题区域
		//先取出分类表里的文章分类，用于下拉框
		
		$ctype = & $cult_id; //cult type
		$atype = & $type_article_id; //article type
		
		//$data['type_article_all'] = $this->type_model->get_type_article_all(); 用下面一个方法了
		$data['type_article_all_with_count'] = $this->type_model->get_type_article_all_with_count($ctype);
		
		//再取出文章表里的文章标题、文章id、及count表里对于这些文章的访问统计
		$data['list'] = $this->article_model->article_id_and_title_and_count_by_ctype_and_atype($ctype,$atype);
		
		//取出count表里访问的最大值、最小值，用于做列表字体差异化 canceled
		//$data['count_min_max'] = $this->count_visit_model->get_count_min_max();
		
		//加载左侧文章标题区域的视图
		$this->load->view('v_cult_show_left',$data);
		
		//准备中间视图的数据，即单个文章显示视图
		//先根据文章id获取文章信息
		$aid = $this->uri->segment(5,0);
		if ($aid > 0)
		{
			/************评论表单验证开始*******************/
			//加载表单验证库
			$this->load->library('form_validation');
			
			//设置表单验证规则
			$this->form_validation->set_rules('article_id', 'article id', 'required');
			$this->form_validation->set_rules('client_ip', 'client ip', 'required');
			$this->form_validation->set_rules('captcha_word', 'captcha word', 'required');
			$this->form_validation->set_rules('comment_nickname', 'comment nickname', 'trim|required|max_length[50]');
			$this->form_validation->set_rules('email_address', 'email address', 'trim|required|valid_email|max_length[100]');
			$this->form_validation->set_rules('comment', 'comment', 'trim|required|max_length[65500]');
			$this->form_validation->set_rules('captcha', 'captcha', 'trim|required|4');

			//表单验证
			if($this->form_validation->run() == TRUE)
			{
				//获取表单传递过来的值,cmt:comment
				$data['cmt_article_id'] = $this->input->post('article_id');
				$data['cmt_client_ip'] = $this->input->post('client_ip');
				$data['cmt_captcha_word'] = $this->input->post('captcha_word');
				$data['cmt_comment_nickname'] = htmlspecialchars(strip_tags($this->input->post('comment_nickname')));
				$data['cmt_email_address'] = $this->input->post('email_address');
				$data['cmt_comment'] = nl2br(htmlspecialchars(strip_tags($this->input->post('comment'))));
				$data['cmt_captcha'] = $this->input->post('captcha');
				
				//现在数据都验证过了，没问题。接下来验证验证码是否填写正确
				if ($data['cmt_captcha'] == $data['cmt_captcha_word'])//OK，现在验证码也对了，执行数据库存入吧
				{
					//加载评论操作模型
					$this->load->model('comment_model');
					
					//执行评论存入
					$insert = $this->comment_model->insert_comment();
					if ($insert) $data['inserted'] = TRUE;
				}
				else 
				{
					$data['cap_right'] = FALSE;
				}
				
			}
			
			/************评论表单验证结束*******************/
			
			
			//获取文章信息
			$data['current_article'] = $this->article_model->get_article_by_aid($aid);
			
			//准备经审核的评论数据
			//先加载评论操作模型
			$this->load->model('comment_model');
			
			//当前文章有无评论
			$comment_exist = $this->comment_model->whether_comment_exist($aid);
			if ($comment_exist)
			{
				$data['comment_exist'] = TRUE;
				$data['authorized_comment'] = $this->comment_model->get_authorized_comment_by_aid($aid);
			}
			else 
			{
				$data['comment_exist'] = FALSE;
				$data['authorized_comment'] = NULL;
			}
				
			
			/************评论区域开始*******************/
			//先加载验证码辅助函数
			$this->load->helper('captcha');
			
			//配置验证码
			$vals = array(
			    'word' => random_string('numeric',4),
			    'img_path' => './captcha/',
			    'img_url' => 'http://'.$_SERVER['SERVER_NAME'].'/'.CULT_PROJECT_NAME.'/captcha/',
			    'font_path' => $_SERVER['DOCUMENT_ROOT'].'/'.CULT_PROJECT_NAME.'/sys/fonts/MSYH.TTF',
			    'img_width' => 90,
			    'img_height' => 30,
			    'expiration' => 7200
			    );
			
			//生成验证码
			$cap = create_captcha($vals);
			
			//把验证码分配给视图
			$data['captcha'] = $cap;
			
			/************评论区域结束*******************/
			
			//加载中间的文章及评论视图
			$this->load->view('v_cult_show_middle',$data);
		
			//准备右侧视图的数据，即该文贡献者列表视图
			$contribute_stats_total = $this->article_model->get_article_by_aid_in_para_table($aid);
			
			//初始化统计结果数组
			$tmp = & $contribute_stats_total;
			
			//遍历$tmp数组，替换成想要的内容
			foreach ($tmp as $item)
			{
				$stat['nickname'][] = $this->membership_model->get_nickname_by_id($item->user_id);
				$stat['para_word_count'][] = str_word_count($item->para_content_en);
			}
			
			//生成分配给视图的结果
			$result = array();
			foreach($stat['nickname'] as $key=>$value)
			{
				@$result[$value->nickname] += $stat['para_word_count'][$key];
			}
			
			//对结果进行排序
			arsort($result);
			
			//计算数组中值的和
			$sum = array_sum($result);
			
			//遍历数组，把值（也就是字数）换成百分比
			foreach ($result as $k => $v)
			{
				$result[$k] = sprintf("%.1f%%",($v/$sum)*100);
			}
			
			//准备变量
			$data['stat'] = $result;
			
			//加载右侧视图
			$this->load->view('v_cult_show_right',$data);
			
		}
		
		
		
		//加载页脚
		$this->load->view('includes/v_footer');
	}
}

	










































