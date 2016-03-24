<?php

// print 'it\'s going<br/>';

if (! defined('IN_ACTION')) {
    exit('Access Denied');
}

if (! isset($_POST['web_title']) || ! isset($_POST['keywords']) || ! isset($_POST['description']) || ! isset($_POST['weixin_number'])) {
    exit('Parameter Error.');
}

// print 'step 0 <br/>';

$title = $_POST['web_title'];
$keywords = $_POST['keywords'];
$description = $_POST['description'];
$weixin = $_POST['weixin_number'];

// check image
$image_path = 0;
if (!empty($_FILES['2d_code']['tmp_name'])){
    // 上传了文件 ，传输到 文件夹里面
    $filename = '../img/foot/erweima.png';
    if (file_exists($filename)){
        @unlink($filename);
    }
    if ($_FILES['2d_code']['error'] <= 0){
        if (!move_uploaded_file($_FILES['2d_code']['tmp_name'], $filename)){
            exit('ERROR');
        }
        $image_path = $filename;
    }else{
        exit('ERROR1： ' . $_FILES['2d_code']['error']);
    }
}


require_once 'config.inc.php';

if (!$image_path){
    $image_path =  $_MCONFIG['2d_code_image'];
}

// exit('error: ' .$_MCONFIG['2d_code_image']);





// echo 'setp 1 <br/>';

$content = '<?php ' . "\n";
// echo $content;
$content = $content . '  //basic set ' . "\n" ;
$content = $content . str_replace('%title%', $title, '  $_MCONFIG[\'title\'] = \'%title%\';' . "\n");
$content = $content . str_replace('%keywords%', $keywords, '  $_MCONFIG[\'keywords\'] = \'%keywords%\';'. "\n");
$content = $content . str_replace('%description%', $description, '  $_MCONFIG[\'description\'] = \'%description%\';' . "\n");
$content = $content . str_replace('%weixin%', $weixin, '  $_MCONFIG[\'weixin_number\'] = \'%weixin%\';' . "\n");
$content = $content . str_replace('%image%', $image_path , '  $_MCONFIG[\'2d_code_image\'] = \'%image%\';' . "\n");
$content = $content . '?>';


file_put_contents('config.inc.php',$content);

header('Content-type: text/html; charset=utf-8');
header('Location: admin.php');
// echo <<<EOT
//     <html>
//         <head>
//             <script>location: baseSet.php;</script>
//         </head>
//     </html>

// EOT;

?>