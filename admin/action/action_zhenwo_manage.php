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
    //     name,image,link,insertTime
    if (!isset($_POST['name'])
        || ! isset($_POST['link'])
        || empty($_FILES['image']['tmp_name'])) {
            exit('Parameter Error #1');
        }

        $name = $_POST['name'];
        $link = $_POST['link'];

        if ($_FILES['image']['error'] > 0 || strpos($_FILES['image']['type'], 'image') === FALSE){
            exit('Parameter Error #3');
        }

        // 保存文件
        $to = IMAGE_ZHENWO_PATH . $_FILES['image']['name'];
        upload_file('image',$to);


        //把数据保存到数据库
        //insert($name,$image,$link)
        C::t('cigar_zhenwo')->insert($name,$to,$link);
        header('Location: zhenwo_manage.php');
}


function del_data(){

    if (!isset($_POST['id_array'])){
        exit('Parameter Error #1');
    }

    $id_array = split(',', $_POST['id_array']);
    $img_array = array();

    //删除图片
    $t = C::t('cigar_zhenwo');
    foreach ($id_array as $id){
        $img_array[] = $t->getImagePath($id);
    }
    //     print_r($img_array);
    //     exit(1);
    delete_action_image($img_array);

    echo C::t('cigar_zhenwo')->delete_id_array($id_array);
}


function update_data()
{
    //     exit($_POST['radio']);
    if (!isset($_POST['name'])
        || ! isset($_POST['link'])
        || !isset($_POST['flag'])) {
            exit('Parameter Error #1');
        }

        $id = trim($_POST['flag']);
        $name = $_POST['name'];
        $link = $_POST['link'];

        if ( !is_numeric($id)){
            exit('Parameter Error #2');
        }

        if (!record_exist('cigar_zhenwo', $id)){
            exit('Parameter Error #5');
        }

        $to = false;
        $t = C::t('cigar_zhenwo');
        if (!empty($_FILES['image']['tmp_name'])){

            if ($_FILES['image']['error'] > 0 || strpos($_FILES['image']['type'], 'image') === FALSE){
                exit('Parameter Error #3');
            }

            //删除原图
            $img_array = array();
            $img_array[] = $t->getImagePath($id);
            delete_action_image($img_array);

            // 保存文件
            $to = IMAGE_ZHENWO_PATH . $_FILES['image']['name'];
            upload_file('image',$to);
        }


        //把数据保存到数据库
        //update($id,$name,$image,$link)
        C::t('cigar_zhenwo')->update($id,$name,$to,$link);
        header('Location: zhenwo_manage.php');
}

?>