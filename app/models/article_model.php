<?php

class Article_model extends CI_Model{
	function __construct()
	{
		parent::__construct();
	}

/*
 * embryo9_paras表
 * embryo9_articles表
 * */
	
	//存入段落
	function create_paras($article_id,$para_id,$para)
	{
		$insert_data = array(
							'article_id' => $article_id, 
							'para_id' => $para_id, 
							'para_content_en' => $para,
							'para_content_zh' => '',
							'user_id' => ''
						);
						
		$insert = $this->db->insert('embryo9_paras', $insert_data);
		
		return $insert;
	
	}
	
	//在article表里插入一只有article_id的记录，返回当前的自增量id
	function insert_article_id($article_id) 
	{
		$insert_data = array(
							'article_id' => $article_id, 
							'article_title' => '', 
							'article_zh' => '', 
							'article_en' => '', 
							'testimony_people' => '', 
							'testimony_date' => '', 
							'translation_status' => '', 
						);
		$insert = $this->db->insert('embryo9_articles', $insert_data);
		
		return $this->db->insert_id();
	}
	
	//求所有存在的article_id，返回结果数组
	function get_available_article_id()
	{
		$this->db->select('article_id');
		$query = $this->db->get('embryo9_articles');
		
		$result = $query->result();
		return $result;
	}
	
	//从embryo9_paras表中获取article_id的最大值
	function get_max_article_id()
	{
		$this->db->select_max('article_id');
		$query = $this->db->get('embryo9_paras');
		
		$max = $query->row()->article_id;

		return $max;
	}
	
	//从embryo9_articles表中计算总文章数
	function count_article_usingcount() {
		$count = $this->db->count_all_results('embryo9_articles');
		return $count;
	}
	
	//计算某文章的段落数，这里用求最大值法计算总段落数不要紧，因为段落不会删
	function count_para($article_id)
	{
		$this->db->select_max('para_id');
		$this->db->where('article_id', $article_id);
		$query = $this->db->get('embryo9_paras');
		
		$count = $query->row()->para_id;
		
		return $count;
	}
	
	//获得某文章某段落的英文内容
	function get_para_content_en($article_id, $para_id)
	{
		$query = $this->db->query("SELECT `para_content_en` FROM `embryo9_paras` 
									WHERE `article_id`=$article_id AND `para_id`=$para_id;");
		
		$para_content_en = $query->row()->para_content_en;
		
		return $para_content_en;
	}
	
	//更新某文章某段落的中文内容、用户id
	function update_para_content_zh($article_id, $para_id, $para_content_zh, $userid)
	{
		$query = $this->db->query("UPDATE `embryo9_paras` SET `para_content_zh`='".$para_content_zh."',`user_id`='".$userid."'  
									WHERE `article_id`='".$article_id."' AND `para_id`='".$para_id."';");

		return $query;
	}
	
	//获得(当前页码)下的embryo9_articles表中的各字段
	function get_article($page,$per_page)
	{
		$query = $this->db->query("SELECT `id`,`article_title`,`article_zh`,`testimony_people`,`testimony_date`,`translation_status` 
									FROM `embryo9_articles`  
									ORDER BY `id` DESC 
									LIMIT $page,$per_page;");
		
		$result = $query->result();
		return $result;
	}
	
	//跟上面函数一样，只不过是全部文章
	function get_article_total()
	{
		$query = $this->db->query("SELECT `id`,`article_title`,`article_zh`,`testimony_people`,`testimony_date`,`translation_status` 
									FROM `embryo9_articles`  
									ORDER BY `id` DESC;");
		
		$result = $query->result();
		return $result;
	}
	
	//跟上面函数一样，只不过返回的是$query
	function get_article_for_edit()
	{
		$query = $this->db->query("SELECT `article_title`,`testimony_people`,`testimony_date`,`translation_status` 
									FROM `embryo9_articles`  
									ORDER BY `id` DESC;");
		return $query;
	}
	
	//根据id获取文章各字段内容
	function get_article_by_id($id)
	{
		if($id > 0){
			$query = $this->db->get_where('embryo9_articles', array('id' => $id));
			
			$result = $query->row();//取一行就是row()，取多行就是result()
			return $result; /*访问如echo $result->article_zh;*/
		}
		else
		{
			return NULL;
		}
	}
	
	//根据文章id获取文章各字段内容
	function get_article_by_aid($aid)
	{
		if($aid > 0){
			$query = $this->db->get_where('embryo9_articles', array('article_id' => $aid));
			
			$result = $query->row();//取一行就是row()，取多行就是result()
			return $result; /*访问如echo $result->article_zh;*/
		}
		else
		{
			return NULL;
		}
	}
	
	//根据文章id仅获取文章的标题
	function get_article_title_by_id($id)
	{
		$this->db->select('article_title');
		$query = $this->db->get_where('embryo9_articles', array('id' => $id));
		
		$result = $query->row();
		return $result;/*访问如echo $result->article_title;*/
	} 
	
	
	
	
	
	//根据文章id更新文章各字段内容
	function update_article_by_id($id)
	{
		$data = array(
		               'article_title' => $this->input->post('article_title'),
		               'article_zh' => $this->input->post('article_zh'),
		               'article_en' => $this->input->post('article_en'),
		               'testimony_people' => $this->input->post('testimony_people'),
		               'testimony_date' => $this->input->post('testimony_date'),
					   'origin_address' => $this->input->post('origin_address'),
		               'translation_status' => $this->input->post('translation_status'),
		               'type_article' => $this->input->post('type_article'),
		               'type_cult' => $this->input->post('type_cult'),
		            );
		
		$this->db->where('id', $id);
		$update = $this->db->update('embryo9_articles', $data);
		return $update;
	}

	//删除一篇文章及下面的所有段落
	function delete_one_article_and_para_by_id($id)
	{
		$del_one = $this->db->delete('embryo9_articles', array('id' => $id));
		$del_two = $this->db->delete('embryo9_paras', array('article_id' => $id));
		if($del_one && $del_two)
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}
	
	//判断段落是否已经有翻译好的译文，返回TRUE/FALSE
	//$aid:article id , $pid:para id
	function whether_para_have_translated($aid,$pid)
	{
		$this->db->select('para_content_zh');//要查询的字段
		$query = $this->db->get_where('embryo9_paras', array('article_id'=>$aid , 'para_id'=>$pid));
		
		$result = $query->row();
		
		if (strlen(trim($result->para_content_zh)) > 0)
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}
	
	//判断某文章下的所有段落是否都已翻译好，如果都翻译好了，返回TRUE，反之返回FALSE
	function whether_article_translated($aid)
	{
		$this->db->select('id');
		$query = $this->db->get_where('embryo9_paras',array('article_id'=>$aid, 'para_content_zh'=>''));
		
		$result = $query->result();
		
		if (empty($result))
		{
			return TRUE;
		}
		else 
		{
			return FALSE;
		}
	}
	
	//根据文章id获取所有下属段落的中文译文
	function get_all_para_content_zh_by_aid($aid)
	{
		$this->db->select('para_content_zh');
		$this->db->order_by("para_id", "asc"); 
		$query = $this->db->get_where('embryo9_paras',array('article_id'=>$aid));
		
		$result  = $query->result();
		
		return $result;
	}
	
	//检查段落都已翻译完后，更新一篇中文译文$article_zh至article表
	function update_article_zh($aid, $article_zh)
	{
		$data = array(
						'article_zh' => $article_zh,
		            );
		$this->db->where('article_id', $aid);
		$update = $this->db->update('embryo9_articles', $data);
		
		return $update;
	}
	
	//获取article类型
	function get_type_article()
	{
		$this->db->select('id,type');
		$query = $this->db->get('embryo9_type_article');
		
		$result = $query->result();
	
		return $result;	
	}
	
	//获取cult类型
	function get_type_cult()
	{
		$this->db->select('id,name');
		$query = $this->db->get('embryo9_type_cult');
		
		$result = $query->result();
	
		return $result;	
	}
	
	//获取全部文章的文章id、文章标题，用于左侧视图显示
	function get_article_id_and_title()
	{
		$this->db->select('article_id, article_title');
		$this->db->order_by("update_time", "desc"); 
		$query = $this->db->get('embryo9_articles');
		
		$result = $query->result();
		
		return $result;
	}
	
	//根据文章id判断文章是否存在
	public function whether_article_exist($article_id)
	{
		$query = $this->db->query("SELECT article_id FROM embryo9_articles WHERE article_id=$article_id");
		if ($query->num_rows() > 0)
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}
	
	//根据文章类型和cult类型，取出所有文章的id和title
	//only get translation_status = 1 articles
	public function article_id_and_title_by_ctype_and_atype($ctype,$atype)
	{
		$this->db->select('article_id, article_title');
		$this->db->order_by("update_time", "desc"); 
		$query = $this->db->get_where('embryo9_articles',array('type_cult'=>$ctype,
																'type_article'=>$atype,
																'translation_status'=>'1'));
		
		$result = $query->result();
		
		return $result;
	}
	
	//根据文章类型和cult类型，取出所有文章的id和title，以及count表里这些文章的访问统计
	//only get translation_status = 1 articles
	public function article_id_and_title_and_count_by_ctype_and_atype($ctype,$atype)
	{
		$query = $this->db->query("SELECT embryo9_articles.article_id,
								 		  embryo9_articles.article_title,
										  embryo9_visit_article.count 
								  FROM embryo9_articles
								  LEFT JOIN embryo9_visit_article
								  ON embryo9_articles.article_id = embryo9_visit_article.article_id
								  WHERE
								  	embryo9_articles.type_cult = $ctype
								  AND
								    embryo9_articles.type_article = $atype
								  AND
								    embryo9_articles.translation_status = 1 
								  ORDER BY embryo9_articles.update_time DESC");
		
		$result = $query->result();
		
		return $result;
	}
	
	//根据文章id获取要统计志愿者贡献度的文章内容
	public function get_article_by_aid_in_para_table($aid)
	{
		$this->db->select('id,article_id,para_id,para_content_en,user_id');
		$this->db->order_by('para_id','asc');
		$query = $this->db->get_where('embryo9_paras',array('article_id'=>$aid));
		
		$result = $query->result();
		
		return $result;
	}
	
	//获取用于RSS显示的所有见证文章
	public function getRecentTestimoniesForRss()
	{
		$this->db->select('*')->limit(20)->order_by("update_time","desc")->from('embryo9_articles');

		return $this->db->get()->result_array();
	}
	
	
	
	
}



