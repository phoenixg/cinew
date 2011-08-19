<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

//过滤数组中的空值
if ( ! function_exists('blankFilter'))
{
	function blankFilter($value)
	{
		if($value === '' || $value == "\n\r" || $value == "\n" || 
		   $value == "\r" || $value == '<br />' || $value == null || $value == ' '){
			return FALSE;
		}

			return TRUE;

	}
}

//判断用户是否已登陆，返回TRUE/FALSE
if ( ! function_exists('whether_logged_in'))
{
	function whether_logged_in()
	{
		$CI = & get_instance();
		
		$is_logged_in = $CI->session->userdata('is_logged_in');
		if(!isset($is_logged_in) || $is_logged_in !== TRUE)
		{
			return FALSE;
		}
		else 
		{
			return TRUE;
		}
	}
}



//判断用户是否已登录
if ( ! function_exists('is_logged_in'))
{
	function is_logged_in()
	{
		$CI = & get_instance();
		
		$is_logged_in = $CI->session->userdata('is_logged_in');
		if(!isset($is_logged_in) || $is_logged_in !== TRUE)
		{
			echo 'You don\'t have permission to access this page.&nbsp;';
			echo anchor('member/index','Login');	
			die();	
		}	
	}
}

//判断是否是管理员登录
if ( ! function_exists('is_logged_in_as_administrator'))
{
	function is_logged_in_as_administrator()
	{
		$CI = & get_instance();
		
		$is_logged_in_as_administrator = $CI->session->userdata('is_logged_in_as_administrator');
		if(!isset($is_logged_in_as_administrator) || $is_logged_in_as_administrator !== TRUE)
		{
			echo 'Sorry, only administrator have permission to access this page.&nbsp;';
			echo anchor('manage/login/index','Login as administrator');	
			die();	
		}	
	}
}



//截取中文字符
if ( ! function_exists('msubstr'))
{
	/**
	 * 字符串截取，支持中文和其他编码
	 *
	 * @static
	 * @access public
	 * @param string $str 需要转换的字符串
	 * @param string $start 开始位置
	 * @param string $length 截取长度
	 * @param string $charset 编码格式
	 * @param string $suffix 截断显示字符
	 * @return string
	 */
	function msubstr($str, $start=0, $length, $charset="utf-8", $suffix=true)
	{
	    if(function_exists("mb_substr"))
	         mb_substr($str, $start, $length, $charset);
	    elseif(function_exists('iconv_substr')) {
	         iconv_substr($str,$start,$length,$charset);
	    }
	    $re['utf-8']   = "/[\x01-\x7f]|[\xc2-\xdf][\x80-\xbf]|[\xe0-\xef][\x80-\xbf]{2}|[\xf0-\xff][\x80-\xbf]{3}/";
	    $re['gb2312'] = "/[\x01-\x7f]|[\xb0-\xf7][\xa0-\xfe]/";
	    $re['gbk']    = "/[\x01-\x7f]|[\x81-\xfe][\x40-\xfe]/";
	    $re['big5']   = "/[\x01-\x7f]|[\x81-\xfe]([\x40-\x7e]|\xa1-\xfe])/";
	    preg_match_all($re[$charset], $str, $match);
	    $slice = join("",array_slice($match[0], $start, $length));
	    if($suffix) return $slice."…";
	    return $slice;
	}
}


//生成wysiwyg表单
if ( ! function_exists('make_wysiwyg_form'))
{
	function make_wysiwyg_form()
	{
		include 'v_form_article.php';
	
	}
}


//获取客户端IP地址
if ( ! function_exists('getIP'))
{
	function getIP() { 
		if (! empty ( $_SERVER ["HTTP_CLIENT_IP"] )) { 
			$cip = $_SERVER ["HTTP_CLIENT_IP"]; 
		} else if (! empty ( $_SERVER ["HTTP_X_FORWARDED_FOR"] )) { 
			$cip = $_SERVER ["HTTP_X_FORWARDED_FOR"]; 
		} else if (! empty ( $_SERVER ["REMOTE_ADDR"] )) { 
			$cip = $_SERVER ["REMOTE_ADDR"]; 
		} else { 
			$cip = ''; 
		} 
		preg_match ( "/[\d\.]{7,15}/", $cip, $cips ); 
		$cip = isset ( $cips [0] ) ? $cips [0] : 'unknown'; 
		unset ( $cips ); 
		
		return $cip; 
	} 
}





