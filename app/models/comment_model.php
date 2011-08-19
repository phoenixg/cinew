<?php

class Comment_model extends CI_Model{
	function __construct()
	{
		parent::__construct();
	}

	//存入提交上来的文章评论
	function insert_comment()
	{
		$data = array(
				'article_id' => $this->input->post('article_id'),
				'client_ip' => $this->input->post('client_ip'),
				'comment_nickname' => htmlspecialchars(strip_tags($this->input->post('comment_nickname'))),
				'email_address' => $this->input->post('email_address'),
				'comment' => nl2br(htmlspecialchars(strip_tags($this->input->post('comment')))),
				'authorized' => '0',
				);

		$insert = $this->db->insert('embryo9_comment', $data);
		
		return $insert;
	}
	
	//根据文章id获取当前文章下的所有经审核的评论
	public function get_authorized_comment_by_aid($aid) 
	{
		$this->db->select('id,comment_nickname,email_address,comment,comment_time,authorized');
		$this->db->order_by("comment_time", "desc"); 
		$query = $this->db->get_where('embryo9_comment',array('article_id'=>$aid,'authorized'=>'1'));
		$result = $query->result();
		
		return $result;
	}
	
	//根据文章id判断当前文章有无评论，返回TRUE/FALSE
	public function whether_comment_exist($aid)
	{
		$query = $this->db->query("SELECT id FROM embryo9_comment WHERE article_id=$aid");
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
































