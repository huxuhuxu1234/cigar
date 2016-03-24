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
    if (! isset($_POST['url']) 
        || ! isset($_POST['pos']) 
        || empty($_FILES['img']['tmp_name'])) {
        exit('Parameter Error #1');
    }
    
    $url = $_POST['url'];
    $position = $_POST['pos'];
    
    if ($_FILES['img']['error'] > 0 || strpos($_FILES['img']['type'], 'image') === FALSE){
        exit('Parameter Error #3');
    }
    $pos = -2;
    if ($position == 'left'){
        $pos = -1;
    }else if ($position == 'middle'){
        $pos = 0;
    }else if ($position == 'right'){
        $pos = 1;
    }else{
        exit('Parameter Error #4');
    }
    
    // 保存文件
    $to = IMAGE_FOOT_PATH . $_FILES['img']['name'];
    $to = upload_file('img',$to);
    
    
    //把数据保存到数据库
    C::t('cigar_footer')->insert($url,$to,$pos);
    header('Location: foot_images_set.php');
}

function update_data(){
    //     exit($_POST['radio']);
    if ( ! isset($_POST['url'])
        || !isset($_POST['pos'])
        || !isset($_POST['flag'])) {
            exit('Parameter Error #1');
        }
    
        $id = trim($_POST['flag']);
        $url = $_POST['url'];
        $position = $_POST['pos'];
    
        if ( !is_numeric($id)){
            exit('Parameter Error #2');
        }
    
        if (!record_exist('cigar_footer', $id)){
            exit('Parameter Error #5');
        }
        
        $pos = -2;
        if ($position == 'left'){
            $pos = -1;
        }else if ($position == 'middle'){
            $pos = 0;
        }else if ($position == 'right'){
            $pos = 1;
        }else{
            exit('Parameter Error #4');
        }
        
        $to = false;
        $t = C::t('cigar_footer');
        if (!empty($_FILES['img']['tmp_name'])){
            //更新图片
            if ($_FILES['img']['error'] > 0 || strpos($_FILES['img']['type'], 'image') === FALSE){
                exit('Parameter Error #3');
            }
            
            //删除原图
            $img_array = array();
            $img_array[] = $t->getImagePath($id);
            delete_action_image($img_array);
            
            // 保存文件
            $to = IMAGE_FOOT_PATH . $_FILES['img']['name'];
            $to = upload_file('img',$to);
        }
        
        //把数据保存到数据库
        $t->update($id,$url,$to,$pos);
        header('Location: foot_images_set.php');
}

function del_data(){

    if (!isset($_POST['id_array'])){
        exit('Parameter Error #1');
    }

    $id_array = split(',', $_POST['id_array']);
    $img_array = array();
    
    //删除图片
    $t = C::t('cigar_footer');
    foreach ($id_array as $id){
        $img_array[] = $t->getImagePath($id);
    }
    //     print_r($img_array);
    //     exit(1);
    delete_action_image($img_array);

    echo C::t('cigar_footer')->delete_id_array($id_array);
}

?>