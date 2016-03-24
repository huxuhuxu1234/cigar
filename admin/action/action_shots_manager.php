<?php
if (! defined('IN_ACTION')) {
    exit('Access Denied');
}

if (! isset($_GET['handle'])) {
    exit('Parameter Error #0');
}

switch ($_GET['handle']) {
    case 'add':
        add_data();
        break;
    case 'del':
        del_data();
        break;
    case 'update':
        update_data();
        break;
}

function add_data()
{
//     exit($_POST['radio']);
    if (!isset($_POST['name']) 
        || ! isset($_POST['station']) 
        || ! isset($_POST['cigar']) 
        || ! isset($_POST['content']) 
        || empty($_FILES['img']['tmp_name'])) {
        exit('Parameter Error #1');
    }
    
    $name = $_POST['name'];
    $station = $_POST['station'];
    $pid = $_POST['cigar'];
    $content = $_POST['content'];
    
    if ($_FILES['img']['error'] > 0 || strpos($_FILES['img']['type'], 'image') === FALSE){
        exit('Parameter Error #3');
    }
    
    // 保存文件
    $to = IMAGE_SHOTS_PATH . $_FILES['img']['name'];
    upload_file('img',$to);
    
    
    //把数据保存到数据库
    C::t('cigar_big_shots')->insert($to,$name,$station,$pid,$content);
    header('Location: shots_manage.php');
}


function del_data(){

    if (!isset($_POST['id_array'])){
        exit('Parameter Error #1');
    }
    
    $id_array = split(',', $_POST['id_array']);
    $img_array = array();
    
    //删除图片
    $t = C::t('cigar_big_shots');
    foreach ($id_array as $id){
        $img_array[] = $t->getImagePath($id);
    }
    //     print_r($img_array);
    //     exit(1);
    delete_action_image($img_array);
    
    echo C::t('cigar_big_shots')->delete_id_array($id_array);
}


function update_data()
{
    //     exit($_POST['radio']);
    if (!isset($_POST['name'])
        || ! isset($_POST['station'])
        || ! isset($_POST['cigar'])
        || ! isset($_POST['content'])
        || !isset($_POST['flag'])) {
            exit('Parameter Error #1');
        }

        $id = trim($_POST['flag']);
        $name = $_POST['name'];
        $station = $_POST['station'];
        $pid = $_POST['cigar'];
        $content = $_POST['content'];

        if ( !is_numeric($id)){
            exit('Parameter Error #2');
        }
        
        if (!record_exist('cigar_big_shots', $id)){
            exit('Parameter Error #5');
        }
        
        $to = false;
        $t = C::t('cigar_big_shots');
        if (!empty($_FILES['img']['tmp_name'])){
            
            if ($_FILES['img']['error'] > 0 || strpos($_FILES['img']['type'], 'image') === FALSE){
                exit('Parameter Error #3');
            }
            
            //删除原图
            $img_array = array();
            $img_array[] = $t->getImagePath($id);
            delete_action_image($img_array);
            
            // 保存文件
            $to = IMAGE_SHOTS_PATH . $_FILES['img']['name'];
            upload_file('img',$to);
        }


        //把数据保存到数据库
        C::t('cigar_big_shots')->update($id,$to,$name,$station,$pid,$content);
        header('Location: shots_manage.php');
}

?>