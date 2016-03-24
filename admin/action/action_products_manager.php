<?php
if (! defined('IN_ACTION')) {
    exit('Access Denied');
}

//echo '0.1';

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
	//echo '2';
    if (! isset($_POST['name']) || ! isset($_POST['s_index']) ||
        ! isset($_POST['ext_p']) || ! isset($_POST['price']) || 
        ! isset($_POST['type']) || ! isset($_POST['brand']) ||  
        ! isset($_POST['origin']) || ! isset($_POST['width']) || 
        ! isset($_POST['length']) || ! isset($_POST['make_mode']) 
        || empty($_FILES['img']['tmp_name'])) {
        exit('Parameter Error #1');
    }
    
    $s_index = $_POST['s_index'];
    $form_type = '';
    if($s_index == 0){
        $form_type = 'cigar';
    }else if ($s_index == 1 || $s_index == 2){
        $form_type = 'base';
    }else if ($s_index == 3){
        $form_type = 'redwine';
    }else{
        exit('Parameter Error #1');
    }
    
    if ($form_type == 'cigar') {
        // 添加的雪茄
        if (! isset($_POST['cigar_real']) || empty($_FILES['c_img_desc']['tmp_name']) || ! isset($_POST['cigar_ev_count']) || ! isset($_POST['cigar_taste']) || ! isset($_POST['cigar_exte']) || ! isset($_POST['cigar_cost_per']) || ! isset($_POST['cigar_desc'])) {
            exit('Parameter Error #1');
        }
    } else if ($form_type == 'redwine') {
            // 添加红酒
        if (! isset($_POST['cigar_real']) || ! isset($_POST['cigar_ev_count']) || ! isset($_POST['cigar_taste']) || ! isset($_POST['cigar_exte']) || ! isset($_POST['cigar_cost_per']) || ! isset($_POST['cigar_desc'])) {
            exit('Parameter Error #1');
        }
        if (! isset($_POST['redwine_type']) || ! isset($_POST['redwine_region']) 
            || ! isset($_POST['redwine_level']) 
            || ! isset($_POST['redwine_grape']) 
            || ! isset($_POST['redwine_score1']) 
            || ! isset($_POST['redwine_score2']) 
            || ! isset($_POST['redwine_score3']) 
            || ! isset($_POST['redwine_score4']) 
            || ! isset($_POST['redwine_score5']) 
            || ! isset($_POST['redwine_score6']) 
            || ! isset($_POST['redwine_capa']) 
            || ! isset($_POST['redwine_chateau']) 
            || ! isset($_POST['redwine_dktp']) 
            || ! isset($_POST['redwine_ext1_title']) 
            || ! isset($_POST['redwine_ext1_content']) 
            || ! isset($_POST['redwine_ext2_title']) 
            || ! isset($_POST['redwine_ext2_content']) 
            || ! isset($_POST['redwine_up_count'])) {
            exit('Parameter Error #1');
        }        
    }

	//exit('3');
    
    $type = $_POST['type'];
    $name = $_POST['name'];
    $brand = $_POST['brand'];
    $origin = $_POST['origin'];
    $width = $_POST['width'];
    $length = $_POST['length'];
    $make_mode = $_POST['make_mode'];
    $ext_p = $_POST['ext_p'];
    $price = $_POST['price'];
	$consistence = '';
	if(isset($_POST['consistence'])){
		$consistence = $_POST['consistence'];
	}
    
    // 移动文件
    $to = IMAGE_PRODUCT_PATH . $_FILES['img']['name'];
    $to = upload_file('img', $to);
    
	echo '1.3\n';
    // 把数据保存到数据库
    $pid = C::t('cigar_products')->insert($type, $brand, $name, $width, $length, $origin, $make_mode, $to,$ext_p,$price,$consistence);
    
	echo '1.4\n';
    if ($form_type == 'cigar') {
        // 添加的雪茄
        
        $description = $_POST['cigar_desc'];
        $reliability = $_POST['cigar_real'];
        $evaluate_count = $_POST['cigar_ev_count'];
        $taste = $_POST['cigar_taste'];
        $exterior = $_POST['cigar_exte'];
        $cost_performance = $_POST['cigar_cost_per'];
        
        //处理图片
        for($i = 0; ; $i++){
        	$image = '';
			//exit('1');
	        if (!empty($_FILES[('c_img' . $i)]['tmp_name'])){
	        	
				$cigar_size = $_POST[('cigar_size' . $i)]; 
				$cigar_frontmark = $_POST[('cigar_frontmark' . $i)];
				$cigar_length = $_POST[('cigar_length' . $i)];
				$cigar_width = $_POST[('cigar_width' . $i)];
				$cigar_origin = $_POST[('cigar_origin' . $i)];
	            $image = IMAGE_PRODUCT_PATH . $_FILES[('c_img' . $i)]['name'];
	            $image= upload_file(('c_img' . $i), $image);
				//size,frontmark,origin
	            C::t('cigar_products_images')->insert($pid,$image,$cigar_length,$cigar_width,$cigar_size,$cigar_frontmark,$cigar_origin);
	        }else{
	        	break;
	        }
        }
		
		$image = '';
        $image = IMAGE_PRODUCT_PATH . $_FILES['c_img_desc']['name'];
        $image= upload_file('c_img_desc', $image);
        
        
        C::t('cigar_products_detail')->insert($pid, $description, $reliability, $evaluate_count, $taste, $exterior, $cost_performance,$image);
    } else if ($form_type == 'redwine') {
        // 添加红酒
        $reliability = $_POST['r_real'];
        $evaluate_count = $_POST['r_ev_count'];
        C::t('cigar_products_detail')->insert($pid, '', $reliability, $evaluate_count, 0, 0, 0);
        
        
        $r_type = $_POST['redwine_type'];
        $regions = $_POST['redwine_region'];
        $level=$_POST['redwine_level'];
        $grape_varieties=$_POST['redwine_grape'];
        $score1=$_POST['redwine_score1'];
        $score2=$_POST['redwine_score2'];
        $score3=$_POST['redwine_score3'];
        $score4=$_POST['redwine_score4'];
        $score5=$_POST['redwine_score5'];
        $score6=$_POST['redwine_score6'];
        $capacity=$_POST['redwine_capa'];
        $chateau=$_POST['redwine_chateau'];
        $drinktemp=$_POST['redwine_dktp'];
        $ext1_title=$_POST['redwine_ext1_title'];
        $ext1_content=$_POST['redwine_ext1_content'];
        $ext2_title=$_POST['redwine_ext2_title'];
        $ext2_content=$_POST['redwine_ext2_content'];
        $up_count=$_POST['redwine_up_count'];
        $image1 = '';
        $image2 = '';
        $image3 = '';
        $image4 = '';
        $image5 = '';
        if (!empty($_FILES['redwine_image1']['tmp_name'])){
            $image1 = IMAGE_REDWINE_PATH . $_FILES['redwine_image1']['name'];
            $image1= upload_file('redwine_image1', $image1);
        }
        if (!empty($_FILES['redwine_image2']['tmp_name'])){
            $image2 = IMAGE_REDWINE_PATH . $_FILES['redwine_image2']['name'];
            $image2 = upload_file('redwine_image2', $image2);
        }
        if (!empty($_FILES['redwine_image3']['tmp_name'])){
            $image3 = IMAGE_REDWINE_PATH . $_FILES['redwine_image3']['name'];
            $image3 = upload_file('redwine_image3', $image3);
        }
        if (!empty($_FILES['redwine_image4']['tmp_name'])){
            $image4 = IMAGE_REDWINE_PATH . $_FILES['redwine_image4']['name'];
            $image4 = upload_file('redwine_image4', $image4);
        }
        if (!empty($_FILES['redwine_image5']['tmp_name'])){
            $image5 = IMAGE_REDWINE_PATH . $_FILES['redwine_image5']['name'];
            $image5 = upload_file('redwine_image5', $image5);
        }
        C::t('cigar_redwine_detail')->insert(
        $pid,$r_type,$regions,$level,$grape_varieties,$score1,$score2,$score3,$score4,$score5,$score6,
        $capacity,$chateau,$drinktemp,$ext1_title,$ext1_content,$ext2_title,$ext2_content,$up_count,$image1,$image2,$image3,$image4,$image5);
    }
    header('Location: products_add.php');
    return;
}

function del_data(){

    if (!isset($_POST['id_array'])){
        exit('Parameter Error #1');
    }
    
    $id_array = split(',', $_POST['id_array']);
    $img_array = array();
    
    foreach ($id_array as $id){
        if (!C::t('cigar_big_shots')->check_delete_pid($id)){
            exit('-1');
        }
        if (!C::t('cigar_box_groom_1')->check_delete_pid($id)){
            exit('-10');
        }
        if (!C::t('cigar_box_groom_2')->check_delete_pid($id)){
            exit('-11');
        }
//         if (!C::t('cigar_mybox')->check_delete_pid($id)){
//             exit('-2');
//         }
    }
    
    //删除评论
    C::t('cigar_evaluates')->delete_pid_array($id_array);
    C::t('cigar_products_detail')->delete_id_array($id_array);
    
    $rt = C::t('cigar_redwine_detail');
    // 删除图片红酒品味
    foreach ($id_array as $id){
        $img_array[] = $rt->getImage1Path($id);
        $img_array[] = $rt->getImage2Path($id);
        $img_array[] = $rt->getImage3Path($id);
        $img_array[] = $rt->getImage4Path($id);
        $img_array[] = $rt->getImage5Path($id);
    }
    $rt->delete_id_array($id_array);
    
    
    //删除图片
    $t = C::t('cigar_products');
    foreach ($id_array as $id){
        $img_array[] = $t->getImagePath($id);
    }
    //     print_r($img_array);
    //     exit(1);
    delete_action_image($img_array);
    
   $ret = C::t('cigar_products')->delete_id_array($id_array);
   if (!$ret){
       echo '0';
   }else{
       echo $ret;
   }
}


function update_data()
{
    if (! isset($_POST['name']) || ! isset($_POST['type']) || ! isset($_POST['ext_p']) || ! isset($_POST['price']) || ! isset($_POST['brand']) || ! isset($_POST['origin']) || ! isset($_POST['width']) || ! isset($_POST['length']) || ! isset($_POST['make_mode']) || ! isset($_POST['flag'])) {
        exit('Parameter Error #1');
    }
    $s_index = $_POST['s_index'];
    $form_type = '';
    if($s_index == 0){
        $form_type = 'cigar';
    }else if ($s_index == 1 || $s_index == 2){
        $form_type = 'base';
    }else if ($s_index == 3){
        $form_type = 'redwine';
    }else{
        exit('Parameter Error #1');
    }

    if ($form_type == 'cigar') {
        // 添加的雪茄
        if (! isset($_POST['cigar_real']) || ! isset($_POST['cigar_ev_count']) || ! isset($_POST['cigar_taste']) || ! isset($_POST['cigar_exte']) || ! isset($_POST['cigar_cost_per']) || ! isset($_POST['cigar_desc'])) {
            exit('Parameter Error #1');
        }
    } else if ($form_type == 'redwine') {
        // 添加红酒
        
        if (! isset($_POST['cigar_real']) || ! isset($_POST['cigar_ev_count']) || ! isset($_POST['cigar_taste']) || ! isset($_POST['cigar_exte']) || ! isset($_POST['cigar_cost_per'])  || ! isset($_POST['cigar_desc'])) {
            exit('Parameter Error #1');
        }
        if (! isset($_POST['redwine_type']) || ! isset($_POST['redwine_region'])
            || ! isset($_POST['redwine_level'])
            || ! isset($_POST['redwine_grape'])
            || ! isset($_POST['redwine_score1'])
            || ! isset($_POST['redwine_score2'])
            || ! isset($_POST['redwine_score3'])
            || ! isset($_POST['redwine_score4'])
            || ! isset($_POST['redwine_score5'])
            || ! isset($_POST['redwine_score6'])
            || ! isset($_POST['redwine_capa'])
            || ! isset($_POST['redwine_chateau'])
            || ! isset($_POST['redwine_dktp'])
            || ! isset($_POST['redwine_ext1_title'])
            || ! isset($_POST['redwine_ext1_content'])
            || ! isset($_POST['redwine_ext2_title'])
            || ! isset($_POST['redwine_ext2_content'])
            || ! isset($_POST['redwine_up_count'])) {
                exit('Parameter Error #1');
            }
    }

    $id = trim($_POST['flag']);
    $name = $_POST['name'];
    $type = $_POST['type'];
    $brand = $_POST['brand'];
    $origin = $_POST['origin'];
    $width = $_POST['width'];
    $length = $_POST['length'];
    $make_mode = $_POST['make_mode'];
    $ext_p = $_POST['ext_p'];
    $price = $_POST['price'];
	$consistence = '';
	if(isset($_POST['consistence'])){
		$consistence = $_POST['consistence'];
	}

    if (!is_numeric($id)){
        exit('Parameter Error #2');
    }
    
    
    $to = false;
    $t = C::t('cigar_products');
    
//     print_r($t->fetch_type_by_pid($id));
//     exit(1);
    if ($t->fetch_type_by_pid($id) != $type){
        echo <<<EOT
<script>
            alert('无法更改商品类型！');
            location='products_all.php';
</script>
EOT;
        exit(1);
    }
    
    if (!empty($_FILES['img']['tmp_name'])){
        
        if ($_FILES['img']['error'] > 0 || strpos($_FILES['img']['type'], 'image') === FALSE){
            exit('Parameter Error #3');
        }
        
        $img_array = array();
        $img_array[] = $t->getImagePath($id);
        delete_action_image($img_array);
        
        // 移动文件
        $to = IMAGE_PRODUCT_PATH . $_FILES['img']['name'];
        $to = upload_file('img', $to);
        
    }

    // 把数据保存到数据库
    C::t('cigar_products')->update($id,$type, $brand, $name, $width, $length, $origin, $make_mode, $to,$ext_p,$price,$consistence);

//     exit($form_type == 'redwine' ? 'true' : 'false');
    
    if ($form_type == 'cigar') {
        // 添加的雪茄
        $description = $_POST['cigar_desc'];
        $reliability = $_POST['cigar_real'];
        $evaluate_count = $_POST['cigar_ev_count'];
        $taste = $_POST['cigar_taste'];
        $exterior = $_POST['cigar_exte'];
        $cost_performance = $_POST['cigar_cost_per'];
        
        //处理图片
		for($i = 0; ; $i++){
        	$image = '';
			
			if(!isset($_POST[('cigar_size' . $i)])){
				break;
			}
			
			$cigar_size = $_POST[('cigar_size' . $i)]; 
			$cigar_frontmark = $_POST[('cigar_frontmark' . $i)];
			$cigar_length = $_POST[('cigar_length' . $i)];
			$cigar_width = $_POST[('cigar_width' . $i)];
			$cigar_origin = $_POST[('cigar_origin' . $i)];
			$image_id = $_POST[('cigar_imageid' . $i)];
           
			//size,frontmark,origin
	        if (!empty($_FILES[('c_img' . $i)]['tmp_name'])){
				$image = IMAGE_PRODUCT_PATH . $_FILES[('c_img' . $i)]['name'];
            	$image= upload_file(('c_img' . $i), $image);	
				/*$path = C::t('cigar_products_images')->delete_one_flag_pid($id);
            	@unlink($path);*/
	        }
			
			//exit('image id: ' . $image_id);
			if(!isset($image_id) || !$image_id){
				C::t('cigar_products_images')->insert($id,$image,$cigar_length,$cigar_width,$cigar_size,$cigar_frontmark,$cigar_origin);
			}else{
				C::t('cigar_products_images')->update($image_id,$id,$image,$cigar_length,$cigar_width,$cigar_size,$cigar_frontmark,$cigar_origin);
			}
			
        }

		//exit("i: " . $i);
        
        $image = '';
        if (!empty($_FILES['c_img_desc']['tmp_name'])){
            $image = IMAGE_PRODUCT_PATH . $_FILES['c_img_desc']['name'];
            $image= upload_file('c_img_desc', $image);
        }
        
        
        
        C::t('cigar_products_detail')->update($id, $description, $reliability, $evaluate_count, $taste, $exterior, $cost_performance,$image);
    } else if ($form_type == 'redwine') {
//         exit($id . ' :1');
        
        $reliability = $_POST['r_real'];
        $evaluate_count = $_POST['r_ev_count'];
        C::t('cigar_products_detail')->update($id, '', $reliability, $evaluate_count, 0, 0, 0);
        
        // 添加红酒
        $r_type = $_POST['redwine_type'];
        $regions = $_POST['redwine_region'];
        $level=$_POST['redwine_level'];
        $grape_varieties=$_POST['redwine_grape'];
        $score1=$_POST['redwine_score1'];
        $score2=$_POST['redwine_score2'];
        $score3=$_POST['redwine_score3'];
        $score4=$_POST['redwine_score4'];
        $score5=$_POST['redwine_score5'];
        $score6=$_POST['redwine_score6'];
        $capacity=$_POST['redwine_capa'];
        $chateau=$_POST['redwine_chateau'];
        $drinktemp=$_POST['redwine_dktp'];
        $ext1_title=$_POST['redwine_ext1_title'];
        $ext1_content=$_POST['redwine_ext1_content'];
        $ext2_title=$_POST['redwine_ext2_title'];
        $ext2_content=$_POST['redwine_ext2_content'];
        $up_count=$_POST['redwine_up_count'];
		$tmp_data_row = C::t('cigar_redwine_detail')->fetch($id);
        $image1 = $tmp_data_row['image1'];
        $image2 = $tmp_data_row['image2'];
        $image3 = $tmp_data_row['image3'];
        $image4 = $tmp_data_row['image4'];
        $image5 = $tmp_data_row['image5'];
        if (!empty($_FILES['redwine_image1']['tmp_name'])){
            $image1 = IMAGE_REDWINE_PATH . $_FILES['redwine_image1']['name'];
            $image1= upload_file('redwine_image1', $image1);
        }
        if (!empty($_FILES['redwine_image2']['tmp_name'])){
            $image2 = IMAGE_REDWINE_PATH . $_FILES['redwine_image2']['name'];
            $image2 = upload_file('redwine_image2', $image2);
        }
        if (!empty($_FILES['redwine_image3']['tmp_name'])){
            $image3 = IMAGE_REDWINE_PATH . $_FILES['redwine_image3']['name'];
            $image3 = upload_file('redwine_image3', $image3);
        }
        if (!empty($_FILES['redwine_image4']['tmp_name'])){
            $image4 = IMAGE_REDWINE_PATH . $_FILES['redwine_image4']['name'];
            $image4 = upload_file('redwine_image4', $image4);
        }
        if (!empty($_FILES['redwine_image5']['tmp_name'])){
            $image5 = IMAGE_REDWINE_PATH . $_FILES['redwine_image5']['name'];
            $image5 = upload_file('redwine_image5', $image5);
        }
        C::t('cigar_redwine_detail')->update(
        $id,$r_type,$regions,$level,$grape_varieties,$score1,$score2,$score3,$score4,$score5,$score6,
        $capacity,$chateau,$drinktemp,$ext1_title,$ext1_content,$ext2_title,$ext2_content,$up_count,$image1,$image2,$image3,$image4,$image5);
    }
    header('Location: products_all.php');
    return;
}

?>