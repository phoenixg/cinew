<?php

class Type_model extends CI_Model{
	function __construct()
	{
		parent::__construct();
	}

	//获取cult类型全部信息
	function get_type_cult_all()
	{
		$this->db->select('id, name, fullname_en, intro');
		$query = $this->db->get('embryo9_type_cult');
		$result = $query->result();
		
		return $result;
	}
	
	//获取article类型全部信息
	function get_type_article_all()
	{
		$this->db->select('id,type,memo');
		$query = $this->db->get('embryo9_type_article');
		$result = $query->result();
		
		return $result;
	}
	
	//获取article类型全部信息，包含news、testimonies等类型下的文章总数
	function get_type_article_all_with_count($ctype)
	{
		$query = $this->db->query ("
									SELECT embryo9_type_article.id, embryo9_type_article.type, count(embryo9_articles.article_id) as count
									FROM embryo9_articles
									RIGHT JOIN embryo9_type_article 
									ON embryo9_articles.type_article = embryo9_type_article.id 
									WHERE embryo9_articles.type_cult = $ctype 
									GROUP BY embryo9_type_article.id
									");
		return $query->result();
	}
	
	
	//根据类型获取id
	function get_id_by_name($name)
	{
		$this->db->select('id');
		$query = $this->db->get_where('embryo9_type_cult', array('name'=>$name));
		$result = $query->row();
		
		return $result;
	}
	
	//根据id判断cult是否存在
	public function whether_cult_exist($cult_id)
	{
		$query = $this->db->query("SELECT id FROM embryo9_type_cult WHERE id=$cult_id");
		if ($query->num_rows() > 0)
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}

	//根据文章类型id，判断文章类型是否存在
	public function whether_type_article_exist($type_article_id)
	{
		$query = $this->db->query("SELECT id FROM embryo9_type_article WHERE id=$type_article_id");
		if ($query->num_rows() > 0)
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}
}


































