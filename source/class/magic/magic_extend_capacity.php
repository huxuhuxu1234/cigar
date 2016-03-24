<?php


if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

class magic_extend_capacity {

	var $version = '1.0';
	var $name = 'extend_capacity_name';
	var $description = 'extend_capacity_desc';
	var $price = '0';
	var $weight = '0';
	var $copyright = '<a href="http://www.inbkj.com" target="_blank">创晓科技</a>';
	var $magic = array();
	var $parameters = array();
	var $num = 1;


	
	function getsetting(&$magic) {}
	
	function setsetting(&$magicnew, &$parameters) {}

	
	function usesubmit() {
	    global $_G;
	    
	    error_log('usesubmit');
	    
	    

		C::t('cigar_box_limit')->extend($_G['uid'], 1);
		usemagic($this->magic['magicid'], $this->magic['num']);
		updatemagiclog($this->magic['magicid'], '2', '1', '0');
		showmessage(lang('magic/extend_capacity', 'extend_capacity_ok',array('num' => '1')), dreferer(), array(), array('alert' => 'right', 'showdialog' => 1, 'closetime' => true, 'locationtime' => true));
	}
	
	function show() {
	    
	    global $_G;
	    
	    magicshowtips(lang('magic/extend_capacity','extend_capacity_info',array('num' => '1')));
	}
	

}

?>