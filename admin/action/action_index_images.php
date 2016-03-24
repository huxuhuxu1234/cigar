<?php

if (! defined('IN_ACTION')) {
    exit('Access Denied');
}

if (!isset($_GET['handle'])){
    exit('Parameter Error #0');
}

switch ($_GET['handle']){
    case 'add':
        add_image();
        break;
    case 'del':
        del_data();
        break;
    case 'update':
        update_data();
        break;
}

function add_image(){
    
    if (!isset($_POST['time']) || !isset($_POST['order'])  || !isset($_POST['url']) ){
        exit('Parameter Error #1');
    }
    
    $time = $_POST['time'];
    $order = $_POST['order'];
    $url = $_POST['url'];
    
    if (!is_numeric($time) || !is_numeric($order)){
        exit('Parameter Error #2');
    }
    
    $t = C::t('cigar_images_index');
    if (!isset($_POST['flag'])){
        // 这里是增加
        if (empty($_FILES['img']['tmp_name'])){
            exit('Parameter Error #1');
        }
        if ($_FILES['img']['error'] > 0 || strpos($_FILES['img']['type'], 'image') === FALSE){
            exit('Parameter Error #3');
        }
        // 保存文件
        $to = IMAGE_INDEX_PATH . iconv("UTF-8","gb2312", $_FILES['img']['name']);
        $to = upload_file('img',$to);
        
        //把数据保存到数据库
        $t->insert($to,$time,$order,$url);
    }else{
        // 这里是修改
        $id = trim($_POST['flag']);
        if (!is_numeric($id)){
            exit('Parameter Error #2');
        }
        if (!record_exist('cigar_images_index', $id)){
            exit('Parameter Error #5');
        }
        
        $image = false;
        if (!empty($_FILES['img']['tmp_name'])){
            if ($_FILES['img']['error'] > 0 || strpos($_FILES['img']['type'], 'image') === FALSE){
                exit('Parameter Error #3');
            }

            //删除原图
            $img_array = array();
            $img_array[] = $t->getImagePath($id);
            delete_action_image($img_array);
            
            // 保存文件
            $to = IMAGE_INDEX_PATH . $_FILES['img']['name'];
            $image = upload_file('img',$to);
        }
        
        //更新
        $t->update($id,$image,$time,$order,$url);
    }
//     exit('type: ' . $_FILES['img']['type']);

    
    header('Location: index_images_set.php');
}

function update_data(){
    

    if (!isset($_POST['time']) || !isset($_POST['order']) || !isset($_POST['url'])){
        exit('Parameter Error #1');
    }
    
    $time = $_POST['time'];
    $order = $_POST['order'];
    $url = $_POST['url'];
    
    if (!is_numeric($time) || !is_numeric($order)){
        exit('Parameter Error #2');
    }
    
    $t = C::t('cigar_images_index');
    if (!isset($_POST['flag'])){
        // 这里是增加
        if (empty($_FILES['img']['tmp_name'])){
            exit('Parameter Error #1');
        }
        if ($_FILES['img']['error'] > 0 || strpos($_FILES['img']['type'], 'image') === FALSE){
            exit('Parameter Error #3');
        }
        // 保存文件
        $to = IMAGE_INDEX_PATH . iconv("UTF-8","gb2312", $_FILES['img']['name']);
        $to = upload_file('img',$to);
    
        //把数据保存到数据库
        $t->insert($to,$time,$order,$url);
    }else{
        // 这里是修改
        $id = trim($_POST['flag']);
        if (!is_numeric($id)){
            exit('Parameter Error #2');
        }
        if (!record_exist('cigar_images_index', $id)){
            exit('Parameter Error #5');
        }
    
        $image = false;
        if (!empty($_FILES['img']['tmp_name'])){
            if ($_FILES['img']['error'] > 0 || strpos($_FILES['img']['type'], 'image') === FALSE){
                exit('Parameter Error #3');
            }
    
            //删除原图
            $img_array = array();
            $img_array[] = $t->getImagePath($id);
            delete_action_image($img_array);
    
            // 保存文件
            $to = IMAGE_INDEX_PATH . $_FILES['img']['name'];
            $image = upload_file('img',$to);
        }
    
        //更新
        $t->update($id,$image,$time,$order,$url);
    }
    //     exit('type: ' . $_FILES['img']['type']);
    
    
    header('Location: index_images_set.php');

    
}


function del_data(){
    if (!isset($_POST['id_array'])){
        exit('Parameter Error #1');
    }  
    $id_array = split(',', $_POST['id_array']);
    $img_array = array();
    
    //删除图片
    $t = C::t('cigar_images_index');
    foreach ($id_array as $id){
        $img_array[] = $t->getImagePath($id);
    }
//     print_r($img_array);
//     exit(1);
    delete_action_image($img_array);
    
    echo $t->delete_id_array($id_array);
}
?>