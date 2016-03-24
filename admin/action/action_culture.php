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
    
//     exit(isset($_POST['header']) ? '1,' :'0,');
//     exit(empty($_FILES['image']['tmp_name']) ? '1,' :'0,');
    
    if (! isset($_POST['header']) || !isset($_POST['title'])
        || !isset($_POST['source'])
        || !isset($_POST['view'])
        || !isset($_POST['author'])
        || !isset($_POST['content'])
        || !isset($_POST['up_count'])
		|| !isset($_POST['description'])
        || empty($_FILES['image']['tmp_name'])) {
        exit('Parameter Error #1');
    }
    
    $header = $_POST['header'];
    $title = $_POST['title'];
    $source = $_POST['source'];
    $view = $_POST['view'];
    $content = $_POST['content'];
    $up_count = $_POST['up_count'];
    $author = $_POST['author'];
	$description = $_POST['description'];
    
    if (!is_numeric($view) || !is_numeric($up_count)){
        exit('Parameter Error #2');
    }
    
    if ($_FILES['image']['error'] > 0 || strpos($_FILES['image']['type'], 'image') === FALSE){
        exit('Parameter Error #3');
    }
    
    $to = IMAGE_CULTURE_PATH . $_FILES['image']['name'];
    $to = upload_file('image', $to);
    
    //把数据保存到数据库
    C::t('cigar_culture')->insert($header,$title,$source,$description,$content,$to,$up_count,$view,$author);
    header('Location: culture_content.php');
}

function del_data(){
    
    if (!isset($_POST['id_array'])){
        exit('Parameter Error #1');
    }
    
    $id_array = split(',', $_POST['id_array']);
    $img_array = array();

    //删除图片
    $t = C::t('cigar_culture');
    foreach ($id_array as $id){
        $img_array[] = $t->getImagePath($id);
        //删除有关文章的评价
        C::t('cigar_culture_evaluates')->delete_cultrue($id);
    }
    //     print_r($img_array);
    //     exit(1);
    delete_action_image($img_array);
    
    echo C::t('cigar_culture')->delete_id_array($id_array);
    
}

function update_data()
{
    if (! isset($_POST['header']) || !isset($_POST['title'])
        || !isset($_POST['source'])
        || !isset($_POST['view'])
        || !isset($_POST['content'])
        || !isset($_POST['author'])
        || !isset($_POST['up_count'])
		|| !isset($_POST['description'])
        || !isset($_POST['flag'])) {
            exit('Parameter Error #1');
        }

        $id = trim($_POST['flag']);
        $header = $_POST['header'];
        $title = $_POST['title'];
        $source = $_POST['source'];
        $view = $_POST['view'];
        $content = $_POST['content'];
        $up_count = $_POST['up_count'];
        $author = $_POST['author'];
		$description = $_POST['description'];

        if (!is_numeric($view) || !is_numeric($up_count) || !is_numeric($id)){
            exit('Parameter Error #2');
        }

        if (!record_exist('cigar_culture', $id)){
            exit('Parameter Error #5');
        }
        
        $to = false;
        $t = C::t('cigar_culture');
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
        C::t('cigar_culture')->update($id,$header,$title,$source,$description,$content,$to,$up_count,$view,$author);
        header('Location: culture_content.php');
}

?>