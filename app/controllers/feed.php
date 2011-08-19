<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Feed extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model('article_model');
        $this->load->helper('xml');
	}
    
    function index()
    {
        $data['encoding'] = 'utf-8';
        $data['feed_name'] = 'Latest Updated Testimonies';
        $data['feed_url'] = site_url().'/feed';
        $data['page_description'] = 'testimonies by ex-members of cult-like groups';
        $data['page_language'] = 'zh-CN';
        $data['creator_email'] = 'gopher.huang at gmail.com';
        $data['posts'] = $this->article_model->getRecentTestimoniesForRss();   
        header('Content-Type:text/xml;charset=utf-8');
        
		$this->load->view('feed/rss', $data);
    }
}