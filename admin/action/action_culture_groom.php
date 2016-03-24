<?php

if (! defined('IN_ACTION')) {
    exit('Access Denied');
}

require_once 'editor_groom.inc.php';

$image = $_EDITOR_GROOM['img']['path'];

if (!empty($_FILES['image']['tmp_name'])){
    // 修改图片
//     exit('1');
    //删除原图
    delete_action_image(array('0' => $image));

    $to = 'images/' . $_FILES['image']['name'];
    $image = upload_file('image', $to);
}

$data = <<<EOT
<?php
// 编辑推荐
\$_EDITOR_GROOM['img']['path'] = '$image';
\$_EDITOR_GROOM['img']['text'] = '{$_POST['img_text']}';
\$_EDITOR_GROOM['img']['url'] = '{$_POST['img_url']}';

\$_EDITOR_GROOM['1']['url'] = '{$_POST['1_url']}';
\$_EDITOR_GROOM['1']['text'] = '{$_POST['1_text']}';
\$_EDITOR_GROOM['2']['url'] = '{$_POST['2_url']}';
\$_EDITOR_GROOM['2']['text'] = '{$_POST['2_text']}';
\$_EDITOR_GROOM['3']['url'] = '{$_POST['3_url']}';
\$_EDITOR_GROOM['3']['text'] = '{$_POST['3_text']}';
\$_EDITOR_GROOM['4']['url'] = '{$_POST['4_url']}';
\$_EDITOR_GROOM['4']['text'] = '{$_POST['4_text']}';
\$_EDITOR_GROOM['5']['url'] = '{$_POST['5_url']}';
\$_EDITOR_GROOM['5']['text'] = '{$_POST['5_text']}';
\$_EDITOR_GROOM['6']['url'] = '{$_POST['6_url']}';
\$_EDITOR_GROOM['6']['text'] = '{$_POST['6_text']}';
\$_EDITOR_GROOM['7']['url'] = '{$_POST['7_url']}';
\$_EDITOR_GROOM['7']['text'] = '{$_POST['7_text']}';
\$_EDITOR_GROOM['8']['url'] = '{$_POST['8_url']}';
\$_EDITOR_GROOM['8']['text'] = '{$_POST['8_text']}';
?>
EOT;

file_put_contents('editor_groom.inc.php',$data);

header('Location: culture_header_manager.php');

?>