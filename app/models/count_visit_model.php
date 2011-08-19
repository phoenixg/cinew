<?php

class Count_visit_model extends CI_Model{
	function __construct()
	{
		parent::__construct();
	}

	//判断文章id在统计表里是否存在，返回TRUE/FALSE
	function whether_article_id_exist($aid)
	{
		$query = $this->db->query("SELECT article_id FROM embryo9_visit_article WHERE article_id=$aid");
		if ($query->num_rows() > 0)
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}
	
	//插入一条新的统计
	public function insert_count($aid,$count=1)
	{
		$insert_data = array(
							'article_id' => $aid, 
							'count' => $count
						);
						
		$insert = $this->db->insert('embryo9_visit_article', $insert_data);
		
		return $insert;
	}
	
	//根据文章id返回访问统计数
	public function get_count($aid)
	{
		$this->db->select('count');
		$query = $this->db->get_where('embryo9_visit_article',array('article_id'=>$aid));
		
		return $query->row()->count;
	}
	
	//更新一条统计
	public function update_count($aid,$count)
	{
		$data = array(
						'article_id' => $aid,
						'count' => $count
		            );
		$this->db->where('article_id', $aid);
		$update = $this->db->update('embryo9_visit_article', $data);
		
		return $update;
	}
	
	//count字段在原来基础上加1，针对传入的$aid进行操作
	public function count_plus_one($aid)
	{
		$query = $this->db->query("UPDATE embryo9_visit_article set count=count+1 WHERE article_id=$aid");
		if ($this->db->affected_rows()==1)
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}		
	}

	//获取所有文章id的访问统计信息
	public function get_counts()
	{
		$this->db->select('article_id,count');
		$query = $this->db->get('embryo9_visit_article');
		return $query->result_array();
	}
	
	//获取count表的count最大值、最小值
	public function get_count_min_max()
	{
		$this->db->select_max('count');
		$query = $this->db->get('embryo9_visit_article');
		$result['max'] = $query->row();

		$this->db->select_min('count');
		$query = $this->db->get('embryo9_visit_article');
		$result['min'] = $query->row();
		
		return $result;	
	}
	
}
































