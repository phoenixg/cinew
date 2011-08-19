<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Article extends CI_Controller {

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
		redirect('article/showcult');
	}
	
	public function upload()
	{
		is_logged_in();
		$data['login'] = $this->data['login'];
		$this->load->view('includes/v_header',$data);
		$this->load->view('v_form_article_upload', array('error' => '' ));
		$this->load->view('includes/v_footer');
	}

	public function do_upload()
	{
		is_logged_in();
		$data['login'] = $this->data['login'];
		$this->load->view('includes/v_header',$data);
		
		$config['upload_path'] = './uploads/';
		$config['allowed_types'] = 'txt';
  
		$this->load->library('upload', $config);
 
		if ( ! $this->upload->do_upload('uploadArticle'))
		{
			$error = array('error' => $this->upload->display_errors());
			$this->load->view('v_form_article_upload', $error);
		} 
		else //如果文章上传成功
		{
			//加载文件辅助函数、文章操作模型
			$this->load->helper('file');
			$this->load->model('article_model');
			
			//初始化 $article_id、$para_id
			//$article_id 通过article表的article_id字段求最大值而得
			$article_id = $this->article_model->get_max_article_id();
			$article_id = ($article_id == 0) ? 1:($article_id + 1);//如果表为空则赋值为1
			$para_id = 0;
			
			//把article_id的记录存入articel表，其他字段留空
			if($this->article_model->insert_article_id($article_id) > 0)//article表存入数据成功时，才可以进一步存入para表
			{
				//获得上传文件的信息
				$upload_data = $this->upload->data();
				
				//打开上传的文件
				$fp=fopen($upload_data['full_path'],'r');
				
				//遍历上传的文件，逐行存入para表，只存入ariticle_id,para_id,para_content_en三项,para_content_zh,user_id留空
				while(!feof($fp))
				{
					$line=fgets($fp);
					if(trim($line)!="")
					{
						$para_id ++;
						$this->article_model->create_paras($article_id,$para_id,$line);
					}
				}
				
				//关闭文件
				fclose($fp);
				
				//删除上传的文件
				delete_files($config['upload_path']);
				
				$this->load->view('v_article_upload_successful');
			}
		}
		
		$this->load->view('includes/v_footer');

	}
	
	
	
	
	public function translate() 
	{
		is_logged_in();
		$data['login'] = $this->data['login'];
		$this->load->view('includes/v_header',$data);
		
		//加载文章操作模型、会员操作模型、数组辅助函数
		$this->load->model('article_model');
		$this->load->model('membership_model');
		$this->load->helper('array');
		
		//获取登陆的用户名、用户id
		$username = $this->session->userdata('username');
		$userid = $this->membership_model->get_userid($username);
		
		do{
			//求文章id数组，即把所有存在的article_id放入一数组
			$available_article_id = $this->article_model->get_available_article_id();
			
			//获取一个随机的文章id
			$random_article_id = random_element($available_article_id)->article_id; //needed
			
			//根据该随机文章id，计算该文章下的段落总数
			$total_para = $this->article_model->count_para($random_article_id);
			
			//根据该随机文章id下的段落总数，生成随机段落id
			$random_para_id = rand(1, $total_para); //needed
			
			//判定该文章id-段落id下有没有已经翻译好的译文
			$para_have_translated = $this->article_model->whether_para_have_translated($random_article_id,$random_para_id);
		}while ($para_have_translated);
		
		//获取段落内容
		$random_para_content_en = $this->article_model->get_para_content_en($random_article_id, $random_para_id);
		
		//要传递给视图的数据
		$data['random_para_content_en'] = $random_para_content_en;
		$data['random_article_id'] = $random_article_id;
		$data['random_para_id'] = $random_para_id;
		$data['current_userid'] = $userid;
		
		//加载英文视图、中文译文表单视图、页脚视图
		$this->load->view('v_translate',$data);
		$this->load->view('v_form_para_translate',$data);
		$this->load->view('includes/v_footer');
		
		
	}
	
	//中文译文提交上去后，交给该控制器处理
	public function add_translation()
	{
		is_logged_in();
		
		//加载表单验证库
		$this->load->library('form_validation');
		
		//加载页头视图
		$data['login'] = $this->data['login'];
		$this->load->view('includes/v_header',$data);
		
		//设置表单验证规则
		$this->form_validation->set_rules('para_translate', 'the paragraph', 'trim|required');
		
		//获取从表单提交过来的文章id、段落id
		$data['random_article_id'] = $this->input->post('article_id');
		$data['random_para_id'] = $this->input->post('para_id');
		
		//表单验证
		if($this->form_validation->run() == FALSE)
		{
			$this->load->view('v_form_para_translate',$data);//验证失败，依然显示中文译文表单
		}
		else//如果表单验证通过
		{
			//加载文章操作模型，准备存入段落
			$this->load->model('article_model');
			
			//获取提交过来的文章id、段落id、中文译文、当前用户id
			$article_id = $this->input->post('article_id');
			$para_id = $this->input->post('para_id');
			$para_content_zh = $this->input->post('para_translate');
			$userid = $this->input->post('current_userid');
			
			//执行para数据表更新，将译文存入数据库
			if($this->article_model->update_para_content_zh($article_id, $para_id, $para_content_zh, $userid))
			{
				$this->load->view('v_add_translation_successful');
			}
			else
			{
				redirect('article/translate');
			}
			
			//检查提交上来（即存入）的段落所属的文章下的所有段落是否都已有译文
			$article_translated = $this->article_model->whether_article_translated($article_id);//1:都已翻译好
			if ($article_translated)
			{
				//将所有段落加上<p></p>标签后存入article表
				//先获取文章id下的所有段落
				$all_para = $this->article_model->get_all_para_content_zh_by_aid($article_id);
				
				//再添加<p></p>标签
				$article_zh = NULL;
				foreach ($all_para as $para)
				{
					$para->para_content_zh = "<p>".$para->para_content_zh."</p>\n";
					
					$article_zh .= $para->para_content_zh;
				}
				
				//更新$article_zh到article表
				$update = $this->article_model->update_article_zh($article_id, $article_zh);
				if ($update)
				{
					$this->load->view('v_add_article_successful');
				}
			}
		}
		
		$this->load->view('includes/v_footer');
	}
	
	//显示从首页进入选择的cult下的文章
	//废弃本方法？
	public function showcult()
	{
		//加载页头
		$data['login'] = $this->data['login'];
		$this->load->view('includes/v_header',$data);
		
		//加载文本操作辅助函数、文章操作模型
		$this->load->helper('text');
		$this->load->model('article_model');
		
		//计算全部文章数
		$count = $this->article_model->count_article_usingcount();

		//设置分页链接
		$this->load->library('pagination');

		$config['base_url'] = base_url().'index.php/article/showcult/';
		$config['total_rows'] = $count;
		$config['per_page'] = '5';
		$config['num_links'] = 10; //当前页码边上放几个链接
		$config['first_link'] = '首页';
		$config['last_link'] = '尾页';
		$config['next_link'] = '下一页';
		$config['prev_link'] = '上一页';
		$config['cur_tag_open'] = '<b>';
		$config['cur_tag_close'] = '</b>';
		$config['full_tag_open'] = '<p>';
		$config['full_tag_close'] = '</p>';
		
		$this->pagination->initialize($config);

		//查询
		$page = & $this->uri->segment(3,0);
		$per_page = & $config['per_page'];
		
		//传递给视图的变量
		$data['pagelinks'] = $this->pagination->create_links(); //分页链接HTML
		$data['article'] = $this->article_model->get_article($page,$per_page);//文章各字段信息
		foreach ($data['article'] as $item){
			$item->article_zh = msubstr($item->article_zh,0,200);//截取前200个字符
		}

		//加载视图
		$this->load->view('v_showcult',$data);
		
		//加载页脚
		$this->load->view('includes/v_footer');
	}
		
}












































