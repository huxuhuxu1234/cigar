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
    if (!isset($_POST['url']) || !isset($_POST['order'])
        || !isset($_POST['start_time'])
        || empty($_FILES['image']['tmp_name'])
        || !isset($_POST['end_time'])) {
        exit('Parameter Error #1');
    }

    $url = $_POST['url'];
    $order = $_POST['order'];
    $startTime = $_POST['start_time'];
    $endTime = $_POST['end_time'];

    if (!is_numeric($order)){
        exit('Parameter Error #2');
    }
    
    //移动文件
    $to = IMAGE_CAD_PATH . $_FILES['image']['name'];
    $to = upload_file('image', $to);

    //把数据保存到数据库
    C::t('cigar_culture_ad')->insert($url,$to,$startTime,$endTime,$order);
    header('Location: culture_ad_manager.php');
}

function del_data(){


    if (!isset($_POST['id_array'])){
        exit('Parameter Error #1');
    }
    $id_array = split(',', $_POST['id_array']);
    $img_array = array();
    
    //删除图片
    $t = C::t('cigar_culture_ad');
    foreach ($id_array as $id){
        $img_array[] = $t->getImagePath($id);
    }
    delete_action_image($img_array);
    
    echo $t->delete_id_array($id_array);

}


function update_data(){
    
    //     exit($_POST['radio']);
    if (! isset($_POST['url']) || ! isset($_POST['order'])
        || !isset($_POST['start_time'])
        || !isset($_POST['end_time'])
        || !isset($_POST['flag'])) {
            exit('Parameter Error #1');
        }

        $id = trim($_POST['flag']);
        $order = $_POST['order'];
        $url = $_POST['url'];
        $start_time = $_POST['start_time'];
        $end_time = $_POST['end_time'];

        if (!is_numeric($order) || !is_numeric($id)){
            exit('Parameter Error #2');
        }

        if (!record_exist('cigar_culture_ad', $id)){
            exit('Parameter Error #5');
        }

        $to = false;
        $t = C::t('cigar_culture_ad');
        if (!empty($_FILES['image']['tmp_name'])){
            //更新图片
            if ($_FILES['image']['error'] > 0 || strpos($_FILES['image']['type'], 'image') === FALSE){
                exit('Parameter Error #3');
            }

            //删除原图
            $img_array = array();
            $img_array[] = $t->getImagePath($id);
            delete_action_image($img_array);

            // 保存文件
            $to = IMAGE_FOOT_PATH . $_FILES['image']['name'];
            $to = upload_file('image',$to);
        }

        //把数据保存到数据库
        $t->update($id,$url,$to,$start_time,$end_time,$order);
        header('Location: culture_ad_manager.php');
}

?>