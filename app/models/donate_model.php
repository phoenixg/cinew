<?php

class Donate_model extends CI_Model{
	function __construct()
	{
		parent::__construct();
	}

	//存入一条新的捐赠申请记录
	function insert_donation()
	{
		$data = array(
				'amount' => $this->input->post('amount'),
				'contact_info' => htmlspecialchars(strip_tags($this->input->post('contact_info'))),
				'ip' => $this->input->post('ip'),
				'confirmed' => '0',
				);

		$insert = $this->db->insert('embryo9_donate', $data);
		
		return $insert;
	}
}