<?php

    //接受参数
    define('IN_ACTION', TRUE);
    
    $__action = @$_GET['action'] or exit('Access denied.');
//     error_exit(whichAction($__action));
    
    switch (whichAction($__action)){
        case 0:
            header('Location','index.php');
            exit;
        case 1:
            break;
        case 2:
            break;
        case 3:
            require 'suggest.php';
            break;
        case 4:
            cul_ev();
            break;
        case 5:
            cul_ev_p_and_n();
            break;
        case 6:
            cul_up();
            break;
        case 7:
            ev_point();
            break;
        case 8:
            ev_content();
            break;
        case 9:
            redwine_like();
            break;
        case 10:
            add_to_box();
            break;
        case 11:
            update_box_point();
            break;
        case 12:
            delete_cigar();
            break;
        case 13:
            get_box_uid();
            break;
        case 14:
            cigar_taste();
            break;
        case -1:
            error_exit('-1');
            break;
    }
    
    //function
    
    /**
     * 参数是哪一种action
     * @param string $__action 字符串参数
     * @return number 行为标记 <br/>
     *   -1:  $__action参数不存在 <br />
     *   0:   未识别                            <br/>
     *   1:   登录                                 <br/>
     *   2:   注册                                <br/>
     *   3:   提交意见                        <br/>
     *   4:   雪茄文化单文章评分页面<br/>
     *   5:   雪茄文件单文章平均分和评分任务 <br/>
     *   6:   雪茄单文章点赞 <br/>
     *   7:   产品评分  <br/>
     *   8:   产品评论  <br/>
     *   9:   redwine_like<br/>
     *   10:  add_to_box <br />
     *   11:  update_box_point <br/>
     *   12:  delete_cigar <br/>
     *   13:  get_box_uid<br/>
     *   14:  cigar_taste<br/>
     */
    function whichAction($__action = null){
        if(!$__action){
            return -1;
        }
        if (strcmp($__action,'login') == 0){
            return 1;
        }
        if (strcmp($__action,'reg') == 0){
            return  2;
        }
        if (strcmp($__action, 'sug_commit') == 0){
            return  3;
        }
        if (strcmp($__action, 'cul_ev') == 0){
            return 4;
        }
        if (strcmp($__action, 'cul_ev_p_and_n') == 0){
            return 5;
        }
        if (strcmp($__action, 'cul_up') == 0){
            return 6;
        }
        if (strcmp($__action, 'ev_point') == 0){
            return 7;
        }
        
        if (strcmp($__action, 'ev_content') == 0){
            return 8;
        }
        if (strcmp($__action, 'redwine_like') == 0){
            return 9;
        }
        if (strcmp($__action, 'add_to_box') == 0){
            return 10;
        }
        if(strcmp($__action, 'update_box_point') == 0){
            return 11;
        }
        if (strcmp($__action, 'delete_cigar') == 0){
            return 12;
        }
        if (strcmp($__action, 'get_box_uid') == 0){
            return 13;
        }
        if (strcmp($__action, 'cigar_taste') == 0){
            return 14;
        }
        
        return 0;
    }
    
    
    function cul_ev(){
//         error_exit('10001');
        header('Content-type: text/json; charset=utf8');
        require_once 'source/class/class_core.php';
        require_once 'salt.php';
        
        C::app()->init();
        global $_G;
        $uid = $_G['uid'];
        if ($uid == 0){
            //没登录用户
            // 错误代码1 ， 用户未登录
            error_exit('1');
        }
        
        if (!isset($_POST['id']) || !isset($_POST['point'])){
            error_exit('2');
        }
        
        $cid = $salt->decode($_POST['id']);
        if ($cid == -1){
            error_exit('3');
        }
        
        $point = $_POST['point'];
        if (!is_numeric($point)){
            error_exit('4');
        }
        
        $ceid = -1;
        $ceid_data = C::t('cigar_culture_evaluates')->_get_ceid($uid,$cid);
        if (isset($ceid_data['ceid'])){
            // 存在ceid  进行更新
            $ceid = $ceid_data['ceid'];
        }
        
        C::t('cigar_culture_evaluates')->ev_point($cid,$uid,$point,$ceid);
        error_exit('0');
        
    }
    
    /**
     * 错误退出，并输出一个 json 的errorCode
     * @param string $code   errorCode
     */
    function error_exit($code = ''){
        exit('' . json_encode(array('errorCode' => $code)));
    }
    
    
    function cul_ev_p_and_n(){
        
        require_once 'source/class/class_core.php';
        require_once 'salt.php';
        
        C::app()->init();
        global $_G;
        
        
        if (!isset($_POST['id'])){
            error_exit('1');
        }
        
        $id = $salt->decode($_POST['id']);
        
        if ($id == -1){
            error_exit('2');
        }
        
        $data = C::t('cigar_culture_evaluates')->evaluate_count_and_avg($id);
        if (!$data){
            error_exit('5');
        }
        echo json_encode($data);
        exit();            
    }
    
    function cul_up(){
        
        require_once 'source/class/class_core.php';
        require_once 'salt.php';
        
        C::app()->init();
        global $_G;
        
        $uid = $_G['uid'];
        if ($uid == 0){
            //没登录用户
            // 错误代码1 ， 用户未登录
            error_exit('1');
        }
        
        if (!isset($_POST['id']) || !isset($_POST['op'])){
            error_exit('2');
        }
        
        $cid = $salt->decode($_POST['id']);
        if ($cid == -1){
            error_exit('3');
        }
        
        $op = $_POST['op'];
        if (!is_numeric($op)){
            error_exit('4');
        }
        
        $ceid = -1;
        $ceid_data = C::t('cigar_culture_evaluates')->_get_ceid($uid,$cid);
        if (isset($ceid_data['ceid'])){
            // 存在ceid  进行更新
            $ceid = $ceid_data['ceid'];
        }

        if ($op == 1){
            C::t('cigar_culture')->up_count_plus($cid,'+');
        }else{
            C::t('cigar_culture')->up_count_plus($cid,'-');
        }
        
        C::t('cigar_culture_evaluates')->ev_up($op,$cid,$uid,$ceid);
        error_exit('0');
    }
    
    
    function ev_point(){
        
        require_once 'source/class/class_core.php';
        require_once 'salt.php';
        
        C::app()->init();
        global $_G;
        
        $uid = $_G['uid'];
        if ($uid == 0){
            //没登录用户
            // 错误代码1 ， 用户未登录
            exit_and_go_back('请登陆后再尝试评分');
        }
        
        if (!isset($_POST['id']) || !isset($_POST['taste'])
            || !isset($_POST['exterior'])
            || !isset($_POST['cost_p'])){
            exit_and_go_back('评论失败，请重试    #1');
        }
        
        $id = $salt->decode($_POST['id']);
        if ($id == -1){
            exit_and_go_back('评论失败，请重试    #2');
        }
        
        $taste = $_POST['taste'];
        $exterior = $_POST['exterior'];
        $cost_p = $_POST['cost_p'];

        $ev_data = C::t('cigar_evaluates')->ev_data($id,$uid);
        if ($ev_data && isset($ev_data['eid'])){
            //存在数据
            C::t('cigar_evaluates')->update($ev_data['eid'],$taste,$exterior,$cost_p,$ev_data['content']);
            exit_and_go_back('评论成功');
        }else{
            //不存在数据插入
            C::t('cigar_evaluates')->insert($id,$uid,$taste,$exterior,$cost_p,'');
            exit_and_go_back('评论成功');
        }
        
    }
    
    function update_box_point(){
        

        require_once 'source/class/class_core.php';
        require_once 'salt.php';
        
        C::app()->init();
        global $_G;
        
        $uid = $_G['uid'];
        if ($uid == 0){
            //没登录用户
            // 错误代码1 ， 用户未登录
            error_exit('1');
        }
        
        if (!isset($_POST['id']) || !isset($_POST['point']) ){
            error_exit('2');
        }
        
        $id = $salt->decode($_POST['id']);
        if ($id == -1){
            error_exit('2');
        }
        
//         exit('' . $id);
        
        $taste = $_POST['point'];
        $exterior = $_POST['point'];
        $cost_p = $_POST['point'];
        
        $ev_data = C::t('cigar_evaluates')->ev_data($id,$uid);
        if ($ev_data && isset($ev_data['eid'])){
            //存在数据
            C::t('cigar_evaluates')->update($ev_data['eid'],$id,$uid,$taste,$exterior,$cost_p,$ev_data['content']);
        }else{
            //不存在数据插入
            C::t('cigar_evaluates')->insert($id,$uid,$taste,$exterior,$cost_p,'');
        }
        error_exit('0');
    }
    
    function ev_content(){
        
        require_once 'source/class/class_core.php';
        require_once 'salt.php';
        
        C::app()->init();
        global $_G;
        
        $uid = $_G['uid'];
        if ($uid == 0){
            //没登录用户
            // 错误代码1 ， 用户未登录
            exit_and_go_back('请登陆后再尝试评分');
        }
        
        if (!isset($_POST['id']) || !isset($_POST['content'])){
            exit_and_go_back('评论失败，请重试    #1');
        }
        
        $id = $salt->decode($_POST['id']);
        if ($id == -1){
            exit_and_go_back('评论失败，请重试    #2');
        }
        
        $content = $_POST['content'];
        
        $ev_data = C::t('cigar_evaluates')->ev_data($id,$uid);
        if ($ev_data && isset($ev_data['eid'])){
            //更新数据
            C::t('cigar_evaluates')->_update($ev_data['eid'],'content',$content);
            exit_and_go_back('评论成功');
        }else{
            //插入数据
             C::t('cigar_evaluates')->insert($id,$uid,0,0,0,$content);
             exit_and_go_back('评论成功');
        }
        
    }
    
    function redwine_like(){
        //点赞红酒
        require_once 'source/class/class_core.php';
        require_once 'salt.php';
        
        C::app()->init();
        global $_G;
        
        $uid = $_G['uid'];
        if ($uid == 0){
            //没登录用户
            // 错误代码1 ， 用户未登录
            error_exit('1');
        }
        
        $id = $salt->decode($_POST['id']);
        if ($id == -1){
            error_exit('2');
        }
        
        $ev_data = C::t('cigar_evaluates')->ev_data($id,$uid);
        if ($ev_data && isset($ev_data['eid'])){
            //更新数据
            if ($ev_data['content'] == '1'){
                error_exit('3');
            }
            C::t('cigar_evaluates')->_update($ev_data['eid'],'content','1');
        }else{
            C::t('cigar_evaluates')->insert($id,$uid,0,0,0,'1');
        }
        error_exit('0');
        
    }
    
    function delete_cigar(){
        
        require_once 'source/class/class_core.php';
        require_once 'salt.php';
        
        C::app()->init();
        global $_G;
        
        $uid = $_G['uid'];
        if ($uid == 0){
            //没登录用户
            // 错误代码1 ， 用户未登录
            error_exit('1');
        }
        
		
        /*$id = $salt->decode($_POST['id']);
        if ($id == -1){
            error_exit('2');
        }*/
		
		if(!isset($_POST['id'])){
			error_exit('2');
		}
		
		$id = $_POST['id'];
        
        $data = C::t('cigar_mybox')->data($id,$uid);
        if ($data && isset($data['mid'])){
            C::t('cigar_mybox')->delete($data['mid']);
        }
        error_exit('0');
        
        
    }
    
    function get_box_uid(){
        require_once 'source/class/class_core.php';
        require_once 'salt.php';
        
        C::app()->init();
        global $_G;
        
        $uid = $_G['uid'];
        if ($uid == 0){
            //没登录用户
            // 错误代码1 ， 用户未登录
            error_exit('1');
        }

        $fuid = $_POST['id'];
        if (!$fuid || !is_numeric($fuid)){
            error_exit('2');
        }
        
        if(!C::t('home_friend')->is_friend($uid,$fuid)){
            error_exit('3');
        }
        
        $data = C::t('cigar_mybox')->simple_data($fuid);
        foreach ($data as $index => $row){
            $data[$index]['pid'] = $salt->encode(1,$row['pid']);
        }
        if ($data){
            echo json_encode($data);
            exit();
        }else{
            error_exit('5');            
        }
    }
    
    function add_to_box(){
        require_once 'source/class/class_core.php';
        require_once 'salt.php';
        
        C::app()->init();
        global $_G;
        
        $uid = $_G['uid'];
        if ($uid == 0){
            //没登录用户
            // 错误代码1 ， 用户未登录
            error_exit('1');
        }
        
        /*$id = $salt->decode($_POST['id']);
        if ($id == -1){
            error_exit('2');
        }*/
        if(!isset($_POST['id'])){
			error_exit('2');
		}
		
		$id = $_POST['id'];
		
        $data = C::t('cigar_mybox')->data($id,$uid);
        if ($data && isset($data['mid'])){
            error_exit('3');
        }
        
        require_once 'util.php';
        if (C::t('cigar_mybox')->_count($uid) >= box_limit()){
            error_exit('4');
        }
        
        C::t('cigar_mybox')->insert($uid,$id);
        error_exit('0');
        
    }
    
    function cigar_taste(){
        
        require_once 'source/class/class_core.php';
        require_once 'salt.php';
        
        C::app()->init();
        global $_G;
        
        $uid = $_G['uid'];
        if ($uid == 0){
            //没登录用户
            // 错误代码1 ， 用户未登录
            error_exit('1');
        }
        
        $id = $salt->decode($_POST['id']);
        if ($id == -1){
            error_exit('2');
        }
        
        if (!isset($_POST['val']) && !isset($_POST['num'])){
            error_exit('2');
        }
        
        $val = $num = 0;
        if (isset($_POST['val']) && is_numeric($_POST['val'])){
            $val = intval($_POST['val']);
        }
        if (isset($_POST['num']) && is_numeric($_POST['num'])){
            $num = intval($_POST['num']);
        }
        
        C::t('cigar_taste')->auto_update($uid,$id,$val,$num);
        
        error_exit('0');
    }
    
    function exit_and_go_back($string = ''){
        
        echo <<<EOT
<html>
<head>
<script>
alert('$string');
history.go(-1);
</script>
</head>
<body></body>
</html>
EOT;
        exit(0);
    }
    
?>