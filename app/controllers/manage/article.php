<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Article extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		
		$this->load->helper('MY_others');
		is_logged_in_as_administrator();
	}
	
	public function index()
	{
		$this->load->view('includes/v_header');
		$this->load->view('manage/v_dashboard');
		$this->load->view('includes/v_footer');
	}

	public function edit()
	{
		$this->load->model('article_model');
		$this->load->view('includes/v_header');
		
		//分页		
		$count = $this->article_model->count_article_usingcount();
		
		//分页链接设置
		$this->load->library('pagination');

		$config['base_url'] = base_url().'index.php/manage/article/edit/';
		$config['total_rows'] = $count;
		$config['per_page'] = '10';
		$config['num_links'] = 10; //当前页码边上放几个链接
		$config['uri_segment'] = 4;
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
		$page = & $this->uri->segment(4,0);		
		$per_page = & $config['per_page'];
		
		//要传递给视图的变量
		$data['pagelinks'] = $this->pagination->create_links(); //分页链接HTML
		$data['article'] = $this->article_model->get_article($page,$per_page);//文章各字段信息
		/*
		foreach ($data['article'] as $item){
			$item->article_zh = msubstr($item->article_zh,0,200);
		}
		*/
			
		
		//加载视图
		$this->load->view('manage/v_article_edit',$data);
		
		$this->load->view('includes/v_footer');
	}

	
	//编辑一篇文章，表单提交后仍然由当前方法处理
	public function edit_one_article()
	{
		//加载页头视图
		$this->load->view('includes/v_header');
		
		//加载验证库并设置验证规则
		$this->load->library('form_validation');
    	$this->form_validation->set_rules('article_title', 'article title', 'trim|max_length[50]');
		$this->form_validation->set_rules('article_zh', 'article chinese version', 'trim|required');
		$this->form_validation->set_rules('article_en', 'article english version', 'trim');
		$this->form_validation->set_rules('testimony_people', 'testimony people', 'trim|max_length[50]');
		$this->form_validation->set_rules('testimony_date', 'testimony date', 'trim|max_length[50]');
		$this->form_validation->set_rules('origin_address', 'origin address', 'trim|max_length[255]');
		$this->form_validation->set_rules('translation_status', 'translation status', 'trim');
    	
		//加载文章操作模型
		$this->load->model('article_model');
		
		//根据当前segment的id查询数据库，获取文章id对应的文章信息
		$id = $this->uri->segment(4,0);
		$data['article'] = $this->article_model->get_article_by_id($id);
		
		//获取类型表信息，并准备分配给视图的变量
		$data['type_article'] = $this->article_model->get_type_article();
		$data['type_cult'] = $this->article_model->get_type_cult();
		
		//验证没通过就显示表单
		if ($this->form_validation->run() == FALSE)
		{

			$this->load->view('manage/v_edit_one_article',$data);
		}
		else//通过验证，就执行article数据表更新
		{
			if ($this->article_model->update_article_by_id($this->input->post('id')))
			{
				$this->load->view('manage/v_edit_one_article_successful');
			}
		}
		
		
		
		
		
		$this->load->view('includes/v_footer');
	}

	//删除一篇文章，及该文章的所有段落
	public function delete_one_article()
	{
		$this->load->view('includes/v_header');
		$this->load->library('form_validation');
		$this->load->model('article_model');

		$this->form_validation->set_rules('id', 'article id', 'required');
		
		$id = $this->uri->segment(4,0);
		if ($id > 0)
		{
			$data['article_id'] = $id;
			$data['article_title'] = $this->article_model->get_article_title_by_id($id)->article_title;
		}
		else
		{
			$data[] = array();
		}
		
    	if ($this->form_validation->run() == FALSE)
		{
			$this->load->view('manage/v_delete_one_article',$data);
		}
		else//通过验证，就执行删除
		{
			if ($this->article_model->delete_one_article_and_para_by_id($this->input->post('id')))
			{
				$this->load->view('manage/v_delete_one_article_successful');
			}
		}
		
		
		$this->load->view('includes/v_footer');
	}



}












































