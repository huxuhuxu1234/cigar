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
    if (! isset($_POST['order']) || ! isset($_POST['header']) 
        || ! isset($_POST['content']) 
        || ! isset($_POST['right_header_1']) 
        || ! isset($_POST['right_header_2'])
        || ! isset($_POST['right_content']) 
        || empty($_FILES['img']['tmp_name'])) {
        exit('Parameter Error #1');
    }
    
    $order = $_POST['order'];
    $header = $_POST['header'];
    $content = $_POST['content'];
    $right_header_1 = $_POST['right_header_1'];
    $right_header_2 = $_POST['right_header_2'];
    $right_content = $_POST['right_content'];
    
    if (!is_numeric($order)){
        exit('Parameter Error #2');
    }
    
    if ($_FILES['img']['error'] > 0 || strpos($_FILES['img']['type'], 'image') === FALSE){
        exit('Parameter Error #3');
    }
    
    // 保存文件
    $to = IMAGE_ABOUT_US . $_FILES['img']['name'];
    upload_file('img',$to);
    
    $right_header = $right_header_1 . '@' . $right_header_2;
    //把数据保存到数据库
    C::t('cigar_about')->insert($header,$order,$content,$right_header,$to,$right_content);
    header('Location: about_us_content.php');
    
}

function del_data(){
    
    if (!isset($_POST['id_array'])){
        exit('Parameter Error #1');
    }
    
    $id_array = split(',', $_POST['id_array']);

    //删除图片
    $t = C::t('cigar_about');
    foreach ($id_array as $id){
        $img_array[] = $t->getImagePath($id);
    }
    //     print_r($img_array);
    //     exit(1);
    delete_action_image($img_array);
    
    echo C::t('cigar_about')->delete_id_array($id_array);
}

function update_data(){
    
    if (! isset($_POST['order']) || ! isset($_POST['header']) 
        || ! isset($_POST['content']) 
        || ! isset($_POST['right_header_1']) 
        || ! isset($_POST['right_header_2'])
        || ! isset($_POST['right_content']) 
        || ! isset($_POST['flag'])) {
        exit('Parameter Error #1');
    }
    
    $id = trim($_POST['flag']);
    $order = $_POST['order'];
    $header = $_POST['header'];
    $content = $_POST['content'];
    $right_header_1 = $_POST['right_header_1'];
    $right_header_2 = $_POST['right_header_2'];
    $right_content = $_POST['right_content'];

    

    if (!is_numeric($order) || !is_numeric($id)){
        exit('Parameter Error #2');
    }

    if (!record_exist('cigar_about', $id)){
        exit('Parameter Error #5');
    }

    $to = false;
    $t = C::t('cigar_about');
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
    
    $right_header = $right_header_1 . '@' . $right_header_2;

    //把数据保存到数据库
    $t->update($id,$header,$order,$content,$right_header,$to,$right_content);
    header('Location: about_us_content.php');
}
?>