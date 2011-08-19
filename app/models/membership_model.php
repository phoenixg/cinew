<?php

class Membership_model extends CI_Model{
	function __construct()
	{
		parent::__construct();
	}

	//登录验证
	public function validate()
	{
		$this->db->where('username', $this->input->post('username'));
		$this->db->where('password', md5($this->input->post('password')));
		$query = $this->db->get('embryo9_membership');

		if($query->num_rows == 1)
		{
			return TRUE;
		}
		
	}
	
	//登录验证：是否为管理员
	public function validate_administrator()
	{
		$this->db->where('username',$this->input->post('username'));
		$this->db->where('password',md5($this->input->post('password')));
		$this->db->where('is_administrator',1);
		$query = $this->db->get('embryo9_membership');
		
		if ($query->num_rows == 1) 
		{
			return TRUE;
		}
		
	}
	
	//创建用户
	public function create_member()
	{	
		$this->db->where('username', $this->input->post('username'));
		$query = $this->db->get('embryo9_membership');
		
		if ($query->num_rows == 1)
		{
			$insert = FALSE;
		}
		else
		{
			$new_member_insert_data = array(
				'username' => $this->input->post('username'),
				//'email_address' => $this->input->post('email_address'),			
				'password' => md5($this->input->post('password1'))						
			);
			$insert = $this->db->insert('embryo9_membership', $new_member_insert_data);
		}
		
		return $insert;
	}
	
	//获取用户id
	public function get_userid($username)
	{
		$query = $this->db->query("SELECT `id` FROM `embryo9_membership` 
									WHERE `username`='$username';");
		$userid = $query->row()->id;
		
		return $userid;
	}
	
	//根据用户id获取昵称 $uid:user_id
	public function get_nickname_by_id($uid)
	{
		$this->db->select('nickname');
		$query = $this->db->get_where('embryo9_membership',array('id'=>$uid));
		
		$result = $query->row();

		return $result;
	}
	
}

















