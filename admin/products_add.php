<?php 
ini_set("display_errors", "On"); 
error_reporting(E_ALL | E_STRICT); 


include 'util.php';
include 'check_user_avail.php';
require_once '../source/class/class_core.php';


C::app()->init();

$types = C::t('cigar_types')->types_without_search();
$brands = C::t('cigar_brands')->fetch_data();
$origins = C::t('cigar_origins')->fetch_data();

$title = '添加新产品';
$action = 'action.php?action=products_manager&handle=add';
// 判断参数   本页面是用于添加还是用于修改
if (isset($_GET['flag'])){
    $title = "修改产品信息";
    $action = 'action.php?action=products_manager&handle=update';
    $id = trim($_GET['flag']);
    
    $post_data['info'] = 'update';
    $post_data['type'] = 'products';
    $post_data['id'] = $id;
    
    $b_data = C::t('cigar_products')->fetch($id);
	
	//echo '<pre>';
	//print_r($b_data);
	//exit();
    
    if (!$b_data){
        //查询失败
        echo <<<EOT
<script>
            alert('查询失败，请重试！');
            location='products_all.php';
</script>
EOT;
    }
    
    $b_json_string =  json_encode($b_data);
    $obj = json_decode($b_json_string);
//     print_r(get_object_vars($obj));
//     echo get_object_vars($obj);
//     exit();
    
    if ($obj->tid == 1){
        //品牌
        $b_data = C::t('cigar_products_detail')->fetch($id);
        $b_json_string =  json_encode($b_data);
        $detail = json_decode($b_json_string);
        
        //显示图片
        $images = C::t('cigar_products_images')->_list($id);
//         print_r($detail);
//         exit(1);
    }else if ($obj->tid == 4){
        // 红酒
        $b_data = C::t('cigar_products_detail')->fetch($id);
        $b_json_string =  json_encode($b_data);
        $detail = json_decode($b_json_string);
        
        $b_data = C::t('cigar_redwine_detail')->fetch($id);
        $b_json_string =  json_encode($b_data);
        $redwine = json_decode($b_json_string);
        
//                 print_r($redwine);
//                 exit(1);
    }
    
	//exit('1.0');
    $ext_p = $obj->ext_prop;
    if(!$ext_p){
        $ext_p = '只有类型为雪茄用具或者烟斗世界的时候 此项才为有效';
    }
    
    //脚本  ,设置 selectmenu的值
	$ext_p = preg_replace('/\r|\n|\t/', '', $ext_p);
	$detail->description = preg_replace('/\r|\n|\t/', '', $detail->description);
	$redwine->ext1_content= preg_replace('/\r|\n|\t/', '', $redwine->ext1_content);
	$redwine->ext2_content= preg_replace('/\r|\n|\t/', '', $redwine->ext2_content);
    $script = <<<EOT

    $('select:eq(0)').val('$obj->tid');
    $('select:eq(1)').val('$obj->bid');
    $('select:eq(2)').val('$obj->oid');
    $('select').trigger("chosen:updated");    
    
    KindEditor.html('#input01','$ext_p');
    KindEditor.html('#input02','{$detail->description}');
    KindEditor.html('#input03','{$redwine->ext1_content}');
    KindEditor.html('#input04','{$redwine->ext2_content}');
	
EOT;
}

//exit('1');
?>
<!DOCTYPE html>
<html>
  <head>
    <title> 雪茄中国网站后台管理系统  </title>
   
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="UTF-8" />
	
	
	
    <link rel="icon" type="image/ico" href="http://tattek.com/minimal/assets/images/favicon.ico" />
    <!-- Bootstrap -->
    <link href="assets/css/vendor/bootstrap/bootstrap.min.css" rel="stylesheet">
    <link href="http://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/vendor/animate/animate.css">
    <link type="text/css" rel="stylesheet" media="all" href="assets/js/vendor/mmenu/css/jquery.mmenu.all.css" />
    <link rel="stylesheet" href="assets/js/vendor/videobackground/css/jquery.videobackground.css">
    <link rel="stylesheet" href="assets/css/vendor/bootstrap-checkbox.css">

	<link rel="stylesheet" href="assets/js/vendor/jgrowl/css/jquery.jgrowl.min.css">
    <link rel="stylesheet" href="assets/js/vendor/chosen/css/chosen.min.css">
    <link rel="stylesheet" href="assets/js/vendor/chosen/css/chosen-bootstrap.css">
    <link rel="stylesheet" href="assets/js/vendor/datatables/css/dataTables.bootstrap.css">
    <link rel="stylesheet" href="assets/js/vendor/datatables/css/ColVis.css">
    <link rel="stylesheet" href="assets/js/vendor/datatables/css/TableTools.css">
    
    <link rel="stylesheet" href="assets/js/vendor/summernote/css/summernote.css">
    <link rel="stylesheet" href="assets/js/vendor/summernote/css/summernote-bs3.css">
    
    <link rel="stylesheet" href="assets/js/vendor/tabdrop/css/tabdrop.css">

    <link href="assets/css/minimal.css" rel="stylesheet">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
	
	
    
    <style>
		.m_r_5{ margin-right: 5px;}    	
    </style>
    
    <script type="text/javascript" src="js/preview_img.js"></script>
   
    <link rel="stylesheet" href="/editor/themes/default/default.css" />
	<link rel="stylesheet" href="/editor/plugins/code/prettify.css" />
    <script type="text/javascript" src="js/preview_img.js"></script>
    <script type="text/javascript" src="/editor/kindeditor.js" charset="UTF-8"></script>
	<script type="text/javascript" src="/editor/lang/zh_CN.js" charset="UTF-8"></script>
    <script charset="utf-8" src="/editor/plugins/code/prettify.js"></script>
   
   
  </head>
  <body class="bg-1">

 

    <!-- Preloader -->
    <div class="mask"><div id="loader"></div></div>
    <!--/Preloader -->

    <!-- Wrap all page content here -->
    <div id="wrap">

      


      <!-- Make page fluid -->
      <div class="row">
        




        <!-- Fixed navbar -->
        <div class="navbar navbar-default navbar-fixed-top navbar-transparent-black mm-fixed-top" role="navigation" id="navbar">
          


          <!-- Branding -->
          <div class="navbar-header col-md-2">
            <a class="navbar-brand" href="./">
              <strong>INBKJ</strong>
            </a>
            <div class="sidebar-collapse">
              <a href="#">
                <i class="fa fa-bars"></i>
              </a>
            </div>
          </div>
          <!-- Branding end -->


          <!-- .nav-collapse -->
          <div class="navbar-collapse">
                        
            <!-- Page refresh -->
            <ul class="nav navbar-nav refresh">
              <li class="divided">
                <a href="#" class="page-refresh"><i class="fa fa-refresh"></i></a>
              </li>
            </ul>
            <!-- /Page refresh -->

            <!-- Search -->
            <div class="search" id="main-search">
              <i class="fa fa-search"></i> <input type="text" placeholder="Search...">
            </div>
            <!-- Search end -->
              
            <!-- Quick Actions -->
            <ul class="nav navbar-nav quick-actions">
                <li class="dropdown divided"><a class="navbar-brand" href="./"> 雪茄中国网站后台管理系统   </a></li>
            </ul>

            <!-- Sidebar -->
            <ul class="nav navbar-nav side-nav" id="sidebar">
              
              <li class="collapsed-content"> 
                <ul>
                  <li class="search"><!-- Collapsed search pasting here at 768px --></li>
                </ul>
              </li>

              <li class="navigation" id="navigation">
                <a href="#" class="sidebar-toggle" data-toggle="#navigation">导航栏 <i class="fa fa-angle-up"></i></a>
                
                <ul class="menu">
                  
                    
                  <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                      <i class="fa fa-tachometer"></i> 基本设置 <b class="fa fa-plus dropdown-plus"></b>
                    </a>
                    <ul class="dropdown-menu">
                      <li>
                        <a href="./">
                          <i class="fa fa-caret-right"></i> 网站基本设置
                        </a>
                      </li>
                      <li >
                        <a href="index_images_set.php">
                          <i class="fa fa-caret-right"></i> 首页轮播图片
                        </a>
                      </li>
                      <li>
                        <a href="foot_images_set.php">
                          <i class="fa fa-caret-right"></i> 底部轮播图片
                        </a>
                      </li>
                      <li>
                        <a href="activity.php">
                          <i class="fa fa-caret-right"></i> 推广活动
                        </a>
                      </li>
					  <li>
                        <a href="zhenwo_manage.php">
                          <i class="fa fa-caret-right"></i> 真我风采
                        </a>
                      </li>
                    </ul>
                  </li>
                    

                  <li class="dropdown active open">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                      <i class="fa fa-list"></i> 产品 <b class="fa fa-plus dropdown-plus"></b>
                    </a>
                    <ul class="dropdown-menu">
                      <li>
                        <a href="brand_manager.php">
                          <i class="fa fa-caret-right"></i> 品牌,产地,类别管理
                        </a>
                      </li>
                      <li class="">
                        <a href="products_all.php">
                          <i class="fa fa-caret-right"></i> 全部产品  -  雪茄
                        </a>
                      </li>
                      <li class="">
                        <a href="products_all-1.php">
                          <i class="fa fa-caret-right"></i> 全部产品  -  雪茄用具
                        </a>
                      </li>
                      <li class="">
                        <a href="products_all-2.php">
                          <i class="fa fa-caret-right"></i> 全部产品  -  烟斗世界
                        </a>
                      </li>
                      <li class="">
                        <a href="products_all-3.php">
                          <i class="fa fa-caret-right"></i> 全部产品  -  红酒品味
                        </a>
                      </li>
                      <li class="active">
                        <a href="products_add.php">
                          <i class="fa fa-caret-right"></i> 添加产品
                        </a>
                      </li>
                      <li>
                        <a href="evaluates.php">
                          <i class="fa fa-caret-right"></i> 评分管理
                        </a>
                      </li>
                      <li>
                        <a href="search_.php">
                          <i class="fa fa-caret-right"></i> 高级搜索设置
                        </a>
                      </li>
                    </ul>
                  </li>
                    
                    
                  <li >
                    <a href="about_us_content.php">
                      <i class="fa fa-tint"></i> 关于我们
                    </a>
                  </li>
                    
                    

                  <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                      <i class="fa fa-pencil"></i> 雪茄文化 <b class="fa fa-plus dropdown-plus"></b>
                    </a>
                    <ul class="dropdown-menu">
                      <li>
                        <a href="culture_header_manager.php">
                          <i class="fa fa-caret-right"></i> 头部，编辑推荐管理
                        </a>
                      </li>
                      <li>
                        <a href="culture_content.php">
                          <i class="fa fa-caret-right"></i> 内容管理
                        </a>
                      </li>
                      <li>
                        <a href="culture_evaluates.php">
                          <i class="fa fa-caret-right"></i> 评分管理
                        </a>
                      </li>
                      <li>
                        <a href="culture_ad_manager.php">
                          <i class="fa fa-caret-right"></i> 广告位管理
                        </a>
                      </li>
                    </ul>
                  </li>

                  <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                      <i class="fa fa-th-large"></i> 雪茄大咖 <b class="fa fa-plus dropdown-plus"></b>
                    </a>
                    <ul class="dropdown-menu">
                      <li>
                        <a href="station_manager.php">
                          <i class="fa fa-caret-right"></i> 岗位管理
                        </a>
                      </li>
                      <li>
                        <a href="shots_manage.php">
                          <i class="fa fa-caret-right"></i> 内容管理
                        </a>
                      </li>
                    </ul>
                  </li>

                  <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                      <i class="fa fa-align-right"></i> 联系我们 <b class="fa fa-plus dropdown-plus"></b>
                    </a>
                    <ul class="dropdown-menu">
                      <li>
                        <a href="contact_us_content.php">
                          <i class="fa fa-caret-right"></i> 内容管理
                        </a>
                      </li>
                      <li>
                        <a href="suggestions_manager.php">
                          <i class="fa fa-caret-right"></i> 意见管理
                        </a>
                      </li>
                    </ul>
                  </li>
                    
                    
                  <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                      <i class="fa fa-crop"></i> 雪茄盒管理 <b class="fa fa-plus dropdown-plus"></b>
                    </a>
                    <ul class="dropdown-menu">
                      <li>
                        <a href="box_manager.php">
                          <i class="fa fa-caret-right"></i> 雪茄盒管理
                        </a>
                      </li>
                      <li>
                        <a href="group_box_limit.php">
                          <i class="fa fa-caret-right"></i> 会员组雪茄盒容量设置
                        </a>
                      </li>
                      <li>
                        <a href="box_year_manager.php">
                          <i class="fa fa-caret-right"></i> 年度管理
                        </a>
                      </li>
                      <li>
                        <a href="box_commonage_manager.php">
                          <i class="fa fa-caret-right"></i> 大众排行管理
                        </a>
                      </li>
                      <li>
                        <a href="filter.php">
                          <i class="fa fa-caret-right"></i> 筛选设置
                        </a>
                      </li>
                      <li>
                        <a href="box_groom_manager.php">
                          <i class="fa fa-caret-right"></i> 年度,大众排行内容管理
                        </a>
                      </li>
                    </ul>
                  </li>

                  <li>
                    <a href="../admin.php?">
                      <i class="fa fa-comment-o"></i> 论坛管理
                    </a>
                  </li>


                </ul>

              </li>
              
            </ul>
            <!-- Sidebar end -->





          </div>
          <!--/.nav-collapse -->





        </div>
        <!-- Fixed navbar end -->
        




        
        <!-- Page content -->
        <div id="content" class="col-md-12">
          
          <!-- page header -->
          <div class="pageheader">
            

            <h2><i class="fa fa-tachometer"></i> 产品
            <span>添加产品</span></h2>


          </div>
          <!-- /page header -->
          
          
          <!-- content main container -->
          <div class="main">

            <!-- row -->
            <div class="row">

              
              <!-- col 12 -->
              <div class="col-md-12">
                
                <!-- tile -->
                <section id="rootwizard" class="tabbable transparent tile">



                  <!-- tile header -->
                  <div class="tile-header transparent">
                    <h1>&nbsp; </h1>
                    <div class="controls">
                      <a href="#" class="refresh"><i class="fa fa-refresh"></i></a>
                      <a href="#" class="remove"><i class="fa fa-times"></i></a>
                    </div>
                  </div>
                  <!-- /tile header -->

                  <!-- tile widget -->
                  <div class="tile-widget nopadding color transparent-black rounded-top-corners">
                    <ul>
                      <li><a href="#tab1" data-toggle="tab">基本信息</a></li>
                      <li><a href="#tab2" data-toggle="tab">雪茄详细信息</a></li>
                      <li><a href="#tab3" data-toggle="tab">红酒详细信息</a></li>
                      <li><a href="#tab4" data-toggle="tab" id="_last_tab">确认添加</a></li>
                    </ul>
                  </div>
                  <!-- /tile widget -->

                  <!-- tile body -->
                  <div class="tile-body">
                    
                    <div id="bar" class="progress progress-striped active">
                      <div class="progress-bar progress-bar-cyan animate-progress-bar"></div>
                    </div>

                    <div class="tab-content">
                    
                              
                      <div class="tab-pane" id="tab1">
                      <form  class="form-horizontal form1">
                          
                          <div class="form-group">
                                <label class="col-sm-2 control-label" for="">商品名字：</label>
                                <div class="col-sm-10">
                                <input type="text" class="form-control" id="" name="name" value="<?php echo $obj->name;?>" parsley-trigger="change" parsley-required="true" parsley-required-message="请输入商品名字"  >
                                </div>
                          </div>
                              
                          <div class="form-group">
                                <label class="col-sm-2 control-label" for="">商品类型：</label>
                                <div class="col-sm-10">
                                <select class="<?php if(!$obj) echo 'chosen-select';  ?> form-control" name="type" id="input07" <?php if($obj && isset($obj->tid) && !empty($obj->tid)) echo "readonly=\"\"" ;?> >
<?php 
    foreach ($types as $type){
        $t = $type['value'];
        $tv = $type['tid'];
        echo <<<EOT
<option value="$tv">$t</option>
EOT;
    }
?>
                                    
                                </select>  
                                </div>
                              </div>
                              
                              <div class="form-group">
                                <label class="col-sm-2 control-label" for="">商品品牌：</label>
                                <div class="col-sm-10">
                                <select class="chosen-select form-control" name="brand" id="input07"  value="<?php echo $obj->bid?>">
<?php 
    foreach ($brands as $brand){
        $b = $brand['value'];
        $bv = $brand['bid'];
        echo <<<EOT
<option value="$bv">$b</option>
EOT;
    }
?>
                                    
                                </select>  
                              </div>
                              </div>
                              
                              <div class="form-group">
                                <label class="col-sm-2 control-label" for="">商品产地：</label>
                                <div class="col-sm-10">
                                <select class="chosen-select form-control " name="origin" id="input07" value="<?php $obj->oid;?>">
<?php 
    foreach ($origins as $origin){
        $o = $origin['value'];
        $ov = $origin['oid'];
        echo <<<EOT
<option value="$ov">$o</option>
EOT;
    }
?>
                                    
                                </select>  
                              </div>
                              </div>
                              
                              <div class="form-group">
                                <label class="col-sm-2 control-label" for="">商品宽度：</label>
                                <div class="col-sm-10">
                                <input type="text" class="form-control" id="" placeholder="添加雪茄时请此项请填写0" value="<?php echo $obj->width;?>" name="width" parsley-trigger="change" parsley-required="true" parsley-type="number" parsley-required-message="请输入商品宽度" parsley-type-message="请输入正确的数字" >
                              </div>
                              </div>
                              
                              <div class="form-group">
                                <label class="col-sm-2 control-label" for="">商品长度：</label>
                                <div class="col-sm-10">
                                <input type="text" class="form-control" id="" placeholder="添加雪茄时请此项请填写0" value="<?php echo $obj->length;?>" name="length" parsley-trigger="change" parsley-required="true" parsley-type="number" parsley-required-message="请输入商品长度" parsley-type-message="请输入正确的数字" >
                              </div>
                              </div>
                              
                              <div class="form-group">
                                <label class="col-sm-2 control-label" for="">商品价格：</label>
                                <div class="col-sm-10">
                                <input type="text" class="form-control" id="" value="<?php echo $obj->price;?>" name="price" parsley-trigger="change" parsley-required="true" parsley-type="number" parsley-required-message="请输入商品价格" parsley-type-message="请输入正确的数字" >
                              </div>
                              </div>
                              
                              <div class="form-group">
                                <label class="col-sm-2 control-label" for="">制作方式：</label>
                                <div class="col-sm-10">
                                <input type="text" class="form-control" id="" name="make_mode" value="<?php echo $obj->make_mode;?>" parsley-trigger="change" parsley-required="true" parsley-required-message="请输入制作方式" >
                              </div>
                              </div>
                              
                              <div class="form-group">
                                <label for="" class="col-sm-2 control-label">原图：</label>
                                <div class="col-sm-6">
                                  <img id="pre_img" src="<?php echo $obj->image ? '../' . $obj->image : '';?>" />
                                </div>
                                <div class="col-sm-4">
                                  <img id="imgViewU" src=""  height="auto" width="auto" />
                                    <div id="divNewPreviewU"></div>
                                  </div>
                              </div>
                              
                              
                              <div class="form-group">
                                <label class="col-sm-2 control-label" style="margin-right: 15px;" >显示图片：</label>
                                <div class="input-group col-sm-9">
		                          <span class="input-group-btn">
		                            <span class="btn btn-primary btn-file">
		                              <i class="fa fa-upload"></i><input type="file" name="img" parsley-required="true" parsley-trigger="change" onchange="PreviewImage(this,'imgViewU','divNewPreviewU',0,0)">
		                            </span>
		                          </span>
		                          <input type="text" class="form-control" readonly=""  <?php if(!$obj) echo 'parsley-required="true" parsley-error-message="请选择文件！ 如果已经选择，请无视此提示"';?>>
		                        </div>
                              </div>
                              
                              <div class="form-group transparent-editor" id="other_desc">
		                        <label class="col-sm-2 control-label" >描述： </label>
		                        <div class=" col-sm-10">
		                          <textarea id="input01" name="ext_p" >只有类型为雪茄用具或者烟斗世界的时候 此项才为有效</textarea>
		                        </div>
		                      </div>
		                      
                              </form>

                      </div>

                      <div class="tab-pane" id="tab2">
                      
                      <form  class="form-horizontal form2">

						  <div class="form-group">
                            <label class="col-sm-2 control-label" for="">浓度：</label>
                            <div class="col-sm-10">
                            <input type="text" class="form-control" id="" value="<?php echo $obj->consistence?>" name="consistence" parsley-trigger="change" parsley-required="true" parsley-required-message="请输入可信度" parsley-type-message="请输入正确的数字" >
                          </div>
                          </div>


                          <div class="form-group">
                            <label class="col-sm-2 control-label" for="">可信度：</label>
                            <div class="col-sm-10">
                            <input type="text" class="form-control" id="" value="<?php echo $detail->reliability?>" name="cigar_real" parsley-trigger="change" parsley-required="true" parsley-type="number" parsley-required-message="请输入可信度" parsley-type-message="请输入正确的数字" >
                          </div>
                          </div>
                          
                          <div class="form-group">
                            <label class="col-sm-2 control-label" for="">评价次数：</label>
                            <div class="col-sm-10">
                            <input type="text" class="form-control" id="" value="<?php echo $detail->evaluate_count?>"  name="cigar_ev_count" parsley-trigger="change" parsley-required="true" parsley-type="number" parsley-required-message="请输入评价次数" parsley-type-message="请输入正确的数字" >
                          </div>
                          </div>
                          
                          
                          <div class="form-group">
                            <label class="col-sm-2 control-label" for="">口味评分：</label>
                            <div class="col-sm-10">
                            <input type="text" class="form-control" id="" value="<?php echo $detail->taste?>"  name="cigar_taste" parsley-trigger="change" parsley-required="true" parsley-type="number" parsley-required-message="请输入口味评分" parsley-type-message="请输入正确的数字" >
                          </div>
                          </div>
                          
                          
                          <div class="form-group">
                            <label class="col-sm-2 control-label" for="">外观评分：</label>
                            <div class="col-sm-10">
                            <input type="text" class="form-control" id="" value="<?php echo $detail->exterior?>"  name="cigar_exte" parsley-trigger="change" parsley-required="true" parsley-type="number" parsley-required-message="请输入外观评分" parsley-type-message="请输入正确的数字" >
                          </div>
                          </div>
                          
                          <div class="form-group">
                            <label class="col-sm-2 control-label" for="">性价比评分：</label>
                            <div class="col-sm-10">
                            <input type="text" class="form-control" id="" value="<?php echo $detail->cost_performance?>" name="cigar_cost_per" parsley-trigger="change" parsley-required="true" parsley-type="number" parsley-required-message="请输入性价比评分" parsley-type-message="请输入正确的数字" >
                          </div>
                          </div>
                          
                          
                          <div class="form-group transparent-editor" id="other_desc">
	                        <label class="col-sm-2 control-label" >描述： </label>
	                        <div class=" col-sm-10">
	                          <textarea id="input02" name="cigar_desc" ></textarea>
	                        </div>
	                      </div>
	                      
	                      <div class="form-group">
                            <label for="" class="col-sm-2 control-label">原图：</label>
                            <div class="col-sm-6">
                              <img id="pre_img0" src="../<?php echo $detail->image;?>" width="140px" height="140px"/>
                            </div>
                            <div class="col-sm-4">
                              <img id="imgViewUD" src=""  />
                                <div id="divNewPreviewUD"></div>
                              </div>
                          </div>
	                      
	                      <div class="form-group">
                            <label class="col-sm-2 control-label" style="margin-right: 15px;" >详情页图片：</label>
                            <div class="input-group col-sm-9">
	                          <span class="input-group-btn">
	                            <span class="btn btn-primary btn-file">
	                              <i class="fa fa-upload"></i><input type="file" name="c_img_desc" parsley-required="true" parsley-trigger="change" onchange="PreviewImage(this,'imgViewUD','divNewPreviewUD',140,140)">
	                            </span>
	                          </span>
	                          <input type="text" class="form-control" readonly="" >
	                        </div>
                          </div>
                          

                        <?php 
                          if(isset($images) && $images) {
                          	$tmp_index = 0;
                          	foreach($images as $image){ ?>
                          		
                          <div id="small_cigar<?php echo $tmp_index;?>">
                          
                          <div class="form-group">
                          	
                          	<label class="col-sm-2 control-label" for="">尺寸：</label>
                            <div class="col-sm-10">
                            	<input type="text" class="form-control" id="" value="<?php echo $image['size'];?>"  name="cigar_size<?php echo $tmp_index;?>" >
                          	</div>
                          	
                          </div>
                          
                          <div class="form-group">
                          	
                          	<label class="col-sm-2 control-label" for="">前标：</label>
                            <div class="col-sm-10">
                            	<input type="text" class="form-control" id="" value="<?php echo $image['frontmark'];?>"  name="cigar_frontmark<?php echo $tmp_index;?>"  >
                          	</div>
                          	
                          </div>
                          
                          <div class="form-group">
                          	
                          	<label class="col-sm-2 control-label" for="">长度：</label>
                            <div class="col-sm-10">
                            	<input type="text" class="form-control" id="" value="<?php echo $image['length'];?>"  name="cigar_length<?php echo $tmp_index;?>"  >
                          	</div>
                          	
                          </div>
                          
                          <div class="form-group">
                          	
                          	<label class="col-sm-2 control-label" for="">环径：</label>
                            <div class="col-sm-10">
                            	<input type="text" class="form-control" id="" value="<?php echo $image['width'];?>"  name="cigar_width<?php echo $tmp_index;?>" >
                          	</div>
                          	
                          </div>
                          
                          <div class="form-group">
                          	
                          	<label class="col-sm-2 control-label" for="">包装产地：</label>
                            <div class="col-sm-10">
                            	<input type="text" class="form-control" id="" value="<?php echo $image['origin'];?>"  name="cigar_origin<?php echo $tmp_index;?>"  >
                          	</div>
                          	
                          </div>
                          
                          	
                          <div class="form-group">
                          	
                          	<label for="" class="col-sm-2 control-label">原图：</label>
                            <div class="col-sm-6">
                              <img id="pre_img<?php echo $tmp_index;?>" src="<?php echo $image['image'] ? '../' . $image['image'] : ''?>" />
                            </div>
                            <div class="col-sm-4">
                              <img id="imgViewc<?php echo $tmp_index + 1;?>" src="" />
                                <div id="divNewPreviewc<?php echo $tmp_index + 1;?>"></div>
                            </div>
                            
                            
                          </div>
                          	
                          	
                          <div class="form-group">
                          	
                          	<label class="col-sm-2 control-label" style="margin-right: 15px;" >显示图片：</label>
                            <div class="input-group col-sm-9">
	                          <span class="input-group-btn">
	                            <span class="btn btn-primary btn-file">
	                              <i class="fa fa-upload"></i><input type="file" name="c_img<?php echo $tmp_index;?>" onchange="PreviewImage(this,'imgViewc<?php echo $tmp_index + 1;?>','divNewPreviewc<?php echo $tmp_index + 1;?>',140,300)">
	                            </span>
	                          </span>
	                          <input type="text" class="form-control" readonly="" >
	                        </div>
                            
                            
                          </div>
                          
                          <input type="hidden" name="cigar_imageid<?php echo $tmp_index;?>" value="<?php echo $image['id']; ?>"  />
                          </div>
                          
                          		
                        <?php		$tmp_index++; 
							}  
                          } else {   ?>
                          
                          <div id="small_cigar0" >
                          
                          <div class="form-group">
                          	
                          	<label class="col-sm-2 control-label" for="">尺寸：</label>
                            <div class="col-sm-10">
                            	<input type="text" class="form-control" id="" value=""  name="cigar_size0" parsley-trigger="change" placeholder="请填写1-9"  >
                          	</div>
                          	
                          </div>
                          
                          <div class="form-group">
                          	
                          	<label class="col-sm-2 control-label" for="">前标：</label>
                            <div class="col-sm-10">
                            	<input type="text" class="form-control" id="" value=""  name="cigar_frontmark0"   >
                          	</div>
                          	
                          </div>
                          
                          <div class="form-group">
                          	
                          	<label class="col-sm-2 control-label" for="">长度：</label>
                            <div class="col-sm-10">
                            	<input type="text" class="form-control" id="" value=""  name="cigar_length0"  >
                          	</div>
                          	
                          </div>
                          
                          <div class="form-group">
                          	
                          	<label class="col-sm-2 control-label" for="">环径：</label>
                            <div class="col-sm-10">
                            	<input type="text" class="form-control" id="" value=""  name="cigar_width0" >
                          	</div>
                          	
                          </div>
                          
                          <div class="form-group">
                          	
                          	<label class="col-sm-2 control-label" for="">包装产地：</label>
                            <div class="col-sm-10">
                            	<input type="text" class="form-control" id="" value=""  name="cigar_origin0"  >
                          	</div>
                          	
                          </div>
                          
                          	
                          <div class="form-group">
                          	
                          	<label for="" class="col-sm-2 control-label">原图：</label>
                            <div class="col-sm-6">
                              <img id="pre_img0" src="" />
                            </div>
                            <div class="col-sm-4">
                              <img id="imgViewc1" src="" />
                                <div id="divNewPreviewc1"></div>
                            </div>
                            
                            
                          </div>
                          	
                          	
                          <div class="form-group">
                          	
                          	<label class="col-sm-2 control-label" style="margin-right: 15px;" >显示图片：</label>
                            <div class="input-group col-sm-9">
	                          <span class="input-group-btn">
	                            <span class="btn btn-primary btn-file">
	                              <i class="fa fa-upload"></i><input type="file" name="c_img0" onchange="PreviewImage(this,'imgViewc1','divNewPreviewc1',140,300)">
	                            </span>
	                          </span>
	                          <input type="text" class="form-control" readonly="" >
	                        </div>
                            
                            
                          </div>
                          
                          </div>
                          
                        <?php  }
                        ?>
                          
                          
                          <div class="form-group" >
                          	
	                        <label class="col-sm-2 control-label" style="margin-right: 15px;" > 添加：</label>
                            <div class="col-sm-4 ">
                            	<button type="button" class="form-control btn btn-cyan" id="add_cigar_" style="margin-left: -15px;">请点击</button>
                          	</div>
	                      </div>
                              
                          
                        </form>
                      </div>
                      
                      <div class="tab-pane" id="tab3">
                        
                        
                        <form  class="form-horizontal form3">
                        
                          <div class="form-group">
                                <label class="col-sm-2 control-label" for="">初始评价次数：</label>
                                <div class="col-sm-10">
                                <input type="text" class="form-control" id="" value="<?php echo $detail->evaluate_count?>" name="r_ev_count" parsley-trigger="change" parsley-required="true" parsley-required-message="请输入初始评价次数"   parsley-type="number" parsley-type-message="请输入正确的数字" >
                                </div>
                          </div>
                          
                          <div class="form-group">
                                <label class="col-sm-2 control-label" for="">可信度：</label>
                                <div class="col-sm-10">
                                <input type="text" class="form-control" id="" value="<?php echo $detail->reliability?>" name="r_real" parsley-trigger="change" parsley-required="true" parsley-required-message="请输入可信度"    parsley-type="number"  parsley-type-message="请输入正确的数字">
                                </div>
                          </div>
                        
                          <div class="form-group">
                                <label class="col-sm-2 control-label" for="">红酒类型：</label>
                                <div class="col-sm-10">
                                <input type="text" class="form-control" id="" value="<?php echo $redwine->type?>" name="redwine_type" parsley-trigger="change" parsley-required="true" parsley-required-message="请输入红酒类型"  >
                                </div>
                          </div>
                          
                          <div class="form-group">
                                <label class="col-sm-2 control-label" for="">产区：</label>
                                <div class="col-sm-10">
                                <input type="text" class="form-control" id="" value="<?php echo $redwine->regions?>" name="redwine_region" parsley-trigger="change" parsley-required="true" parsley-required-message="请输入产区"  >
                                </div>
                          </div>
                          
                          <div class="form-group">
                                <label class="col-sm-2 control-label" for="">级别：</label>
                                <div class="col-sm-10">
                                <input type="text" class="form-control" id=""  value="<?php echo $redwine->level?>" name="redwine_level" parsley-trigger="change" parsley-required="true" parsley-required-message="请输入级别"  >
                                </div>
                          </div>
                          
                          <div class="form-group">
                                <label class="col-sm-2 control-label" for="">葡萄品种：</label>
                                <div class="col-sm-10">
                                <input type="text" class="form-control" id="" value="<?php echo $redwine->grape_varieties?>" name="redwine_grape" parsley-trigger="change" parsley-required="true" parsley-required-message="请输入葡萄品种"  >
                                </div>
                          </div>
                          
                          <div class="form-group">
                                <label class="col-sm-2 control-label" for="">评分1：</label>
                                <div class="col-sm-10">
                                <input type="text" class="form-control" id="" value="<?php echo $redwine->score1?>" name="redwine_score1" parsley-trigger="change" parsley-required="true" parsley-required-message="请输入评分1"  >
                                </div>
                          </div>
                          
                          <div class="form-group">
                                <label class="col-sm-2 control-label" for="">评分2：</label>
                                <div class="col-sm-10">
                                <input type="text" class="form-control" id="" value="<?php echo $redwine->score2?>" name="redwine_score2" parsley-trigger="change" parsley-required="true" parsley-required-message="请输入评分2"  >
                                </div>
                          </div>
                          
                          <div class="form-group">
                                <label class="col-sm-2 control-label" for="">评分3：</label>
                                <div class="col-sm-10">
                                <input type="text" class="form-control" id=""  value="<?php echo $redwine->score3?>" name="redwine_score3" parsley-trigger="change" parsley-required="true" parsley-required-message="请输入评分3"  >
                                </div>
                          </div>
                          
                          <div class="form-group">
                                <label class="col-sm-2 control-label" for="">评分4：</label>
                                <div class="col-sm-10">
                                <input type="text" class="form-control" id="" value="<?php echo $redwine->score4?>" name="redwine_score4" parsley-trigger="change" parsley-required="true" parsley-required-message="请输入评分4"  >
                                </div>
                          </div>
                          
                          <div class="form-group">
                                <label class="col-sm-2 control-label" for="">评分5：</label>
                                <div class="col-sm-10">
                                <input type="text" class="form-control" id="" value="<?php echo $redwine->score5?>" name="redwine_score5" parsley-trigger="change" parsley-required="true" parsley-required-message="请输入评分5"  >
                                </div>
                          </div>
                          
                          <div class="form-group">
                                <label class="col-sm-2 control-label" for="">评分6：</label>
                                <div class="col-sm-10">
                                <input type="text" class="form-control" id="" value="<?php echo $redwine->score6?>" name="redwine_score6" parsley-trigger="change" parsley-required="true" parsley-required-message="请输入评分6"  >
                                </div>
                          </div>
                          
                          <div class="form-group">
                                <label class="col-sm-2 control-label" for="">容量：</label>
                                <div class="col-sm-10">
                                <input type="text" class="form-control" id="" value="<?php echo $redwine->capacity?>" name="redwine_capa" parsley-trigger="change" parsley-required="true" parsley-required-message="请输入容量"  >
                                </div>
                          </div>
                          
                          <div class="form-group">
                                <label class="col-sm-2 control-label" for="">酒庄：</label>
                                <div class="col-sm-10">
                                <input type="text" class="form-control" id="" value="<?php echo $redwine->chateau?>" name="redwine_chateau" parsley-trigger="change" parsley-required="true" parsley-required-message="请输入酒庄"  >
                                </div>
                          </div>
                          
                          <div class="form-group">
                                <label class="col-sm-2 control-label" for="">适饮温度：</label>
                                <div class="col-sm-10">
                                <input type="text" class="form-control" id="" value="<?php echo $redwine->drinktemp?>" name="redwine_dktp" parsley-trigger="change" parsley-required="true" parsley-required-message="请输入适饮温度"  >
                                </div>
                          </div>
                          
                          <div class="form-group">
                                <label class="col-sm-2 control-label" for="">喜欢这款红酒的人数：</label>
                                <div class="col-sm-10">
                                <input type="text" class="form-control" id="" value="<?php echo $redwine->up_count?>" name="redwine_up_count" parsley-trigger="change" parsley-required="true" parsley-required-message="请输入喜欢这款红酒的人数" parsley-type="number" parsley-type-message="请输入正确的数字"  >
                                </div>
                          </div>
                          
                          <div class="form-group">
                                <label class="col-sm-2 control-label" for="">额外1标题：</label>
                                <div class="col-sm-10">
                                <input type="text" class="form-control" id="" value="<?php echo $redwine->ext1_title?>" name="redwine_ext1_title" parsley-trigger="change" parsley-required="true" parsley-required-message="请输入额外1标题"  >
                                </div>
                          </div>
                          
                          <div class="form-group transparent-editor" id="other_desc">
		                        <label class="col-sm-2 control-label" >描述： </label>
		                        <div class=" col-sm-10">
		                          <textarea id="input03" name="redwine_ext1_content" ></textarea>
		                        </div>
		                      </div>
                          
                          
                          <div class="form-group">
                                <label class="col-sm-2 control-label" for="">额外2标题：</label>
                                <div class="col-sm-10">
                                <input type="text" class="form-control" id="" value="<?php echo $redwine->ext2_title?>" name="redwine_ext2_title" parsley-trigger="change" parsley-required="true" parsley-required-message="请输入额外2标题"  >
                                </div>
                          </div>
                          
                          
                          <div class="form-group transparent-editor" id="other_desc">
		                        <label class="col-sm-2 control-label" >描述： </label>
		                        <div class=" col-sm-10">
		                          <textarea id="input04" name="redwine_ext2_content" ></textarea>
		                        </div>
		                      </div>
		                      
		                      
	                      <div class="form-group">
                            <label for="" class="col-sm-2 control-label">原图：</label>
                            <div class="col-sm-6">
                              <img id="pre_img" src="<?php echo $redwine->image1 ? '../' . $redwine->image1 : '';?>" width="auto" height="auto"/>
                            </div>
                            <div class="col-sm-4">
                              <img id="imgViewr1" src=""  height="300px" width="140px" />
                                <div id="divNewPreviewr1"></div>
                              </div>
                          </div>
		                   
                          
                          <div class="form-group">
                            <label class="col-sm-2 control-label" style="margin-right: 15px;" >显示图片1：</label>
                            <div class="input-group col-sm-9">
	                          <span class="input-group-btn">
	                            <span class="btn btn-primary btn-file">
	                              <i class="fa fa-upload"></i><input type="file" name="redwine_image1" parsley-required="true" parsley-trigger="change" onchange="PreviewImage(this,'imgViewr1','divNewPreviewr1',140,140)" >
	                            </span>
	                          </span>
	                          <input type="text" class="form-control" readonly="" >
	                        </div>
                          </div>
                          
                          
                          <div class="form-group">
                            <label for="" class="col-sm-2 control-label">原图：</label>
                            <div class="col-sm-6">
                              <img id="pre_img" src="<?php echo $redwine->image2 ? '../' . $redwine->image2 : '';?>" width="auto" height="auto"/>
                            </div>
                            <div class="col-sm-4">
                              <img id="imgViewr2" src=""  height="300px" width="140px" />
                                <div id="divNewPreviewr2"></div>
                              </div>
                          </div>
                          
                          <div class="form-group">
                            <label class="col-sm-2 control-label" style="margin-right: 15px;" >显示图片2：</label>
                            <div class="input-group col-sm-9">
	                          <span class="input-group-btn">
	                            <span class="btn btn-primary btn-file">
	                              <i class="fa fa-upload"></i><input type="file" name="redwine_image2" parsley-required="true" parsley-trigger="change"  onchange="PreviewImage(this,'imgViewr2','divNewPreviewr2',140,140)">
	                            </span>
	                          </span>
	                          <input type="text" class="form-control" readonly="" >
	                        </div>
                          </div>
                          
                          <div class="form-group">
                            <label for="" class="col-sm-2 control-label">原图：</label>
                            <div class="col-sm-6">
                              <img id="pre_img" src="<?php echo $redwine->image3 ? '../' . $redwine->image3 : '';?>" width="auto" height="auto"/>
                            </div>
                            <div class="col-sm-4">
                              <img id="imgViewr3" src=""  height="300px" width="140px" />
                                <div id="divNewPreviewr3"></div>
                              </div>
                          </div>
                          
                          <div class="form-group">
                            <label class="col-sm-2 control-label" style="margin-right: 15px;" >显示图片3：</label>
                            <div class="input-group col-sm-9">
	                          <span class="input-group-btn">
	                            <span class="btn btn-primary btn-file">
	                              <i class="fa fa-upload"></i><input type="file" name="redwine_image3" parsley-required="true" parsley-trigger="change"  onchange="PreviewImage(this,'imgViewr3','divNewPreviewr3',140,140)" > 
	                            </span>
	                          </span>
	                          <input type="text" class="form-control" readonly="" >
	                        </div>
                          </div>
                          
                          
                          <div class="form-group">
                            <label for="" class="col-sm-2 control-label">原图：</label>
                            <div class="col-sm-6">
                              <img id="pre_img" src="<?php echo $redwine->image4 ? '../' . $redwine->image4 : '';?>" width="auto" height="auto"/>
                            </div>
                            <div class="col-sm-4">
                              <img id="imgViewr4" src=""  height="300px" width="140px" />
                                <div id="divNewPreviewr4"></div>
                              </div>
                          </div>
                          
                          <div class="form-group">
                            <label class="col-sm-2 control-label" style="margin-right: 15px;" >显示图片4：</label>
                            <div class="input-group col-sm-9">
	                          <span class="input-group-btn">
	                            <span class="btn btn-primary btn-file">
	                              <i class="fa fa-upload"></i><input type="file" name="redwine_image4" parsley-required="true" parsley-trigger="change"  onchange="PreviewImage(this,'imgViewr4','divNewPreviewr4',140,140)" >
	                            </span>
	                          </span>
	                          <input type="text" class="form-control" readonly="" >
	                        </div>
                          </div>
                          
                          <div class="form-group">
                            <label for="" class="col-sm-2 control-label">原图：</label>
                            <div class="col-sm-6">
                              <img id="pre_img" src="<?php echo $redwine->image5 ? '../' . $redwine->image5 : '';?>" width="auto" height="auto"/>
                            </div>
                            <div class="col-sm-4">
                              <img id="imgViewr5" src=""  height="300px" width="140px" />
                                <div id="divNewPreviewr5"></div>
                              </div>
                          </div>
                          
                          <div class="form-group">
                            <label class="col-sm-2 control-label" style="margin-right: 15px;" >显示图片5：</label>
                            <div class="input-group col-sm-9">
	                          <span class="input-group-btn">
	                            <span class="btn btn-primary btn-file">
	                              <i class="fa fa-upload"></i><input type="file" name="redwine_image5" parsley-required="true" parsley-trigger="change"  onchange="PreviewImage(this,'imgViewr5','divNewPreviewr5',140,140)">
	                            </span>
	                          </span>
	                          <input type="text" class="form-control" readonly="" >
	                        </div>
                          </div>
                              
                          
                          
                        </form>
                      </div>
                      
                      <div class="tab-pane" id="tab4">
                        
                        
                        <form  class="form-horizontal form4">
                        
                            <div class="form-group">
                            <div class="col-sm-12">
                              <div class="checkbox">
                                <input type="checkbox" value="1" id="opt02" name="newsletter" checked="checked">
                                <label for="opt02">确定添加</label>
                              </div>
                            </div>
                          </div>
                        
                        </form>
                      </div>

                     <!-- </form> -->
                    </div>
                    
                  </div>
                  <!-- /tile body -->

                  <!-- tile footer -->
                  <div class="tile-footer border-top color white rounded-bottom-corners nopadding">
                    <ul class="pager pager-full wizard">
                      <li class="previous"><a href="javascript:;"><i class="fa fa-arrow-left fa-lg"></i></a></li>
                      <li class="next"><a href="javascript:;"><i class="fa fa-arrow-right fa-lg"></i></a></li>
                      <li class="next finish" style="display:none;"><a href="javascript:;"><i class="fa fa-check fa-lg"></i></a></li>
                    </ul>
                  </div>
                  <!-- /tile footer -->
                  
                


                </section>
                <!-- /tile -->
                
                
              </div>
              <!-- /col 12 -->

            </div>
            <!-- /row -->
            

          </div>
          <!-- /content container -->





        </div>
        <!-- Page content end -->



      </div>
      <!-- Make page fluid-->




    </div>
    <!-- Wrap all page content end -->
    
	<a href="#updateModalConfirm" data-toggle="modal" id="open_update_modal"> <span></span></a>


	//hidden form
	<form role="form" id="post_form" action="<?php echo $action;?>" method="post" enctype="multipart/form-data" style="display: none;" >  
        
        <?php 
	      if(isset($obj->pid)){
	          echo '<input name="flag" type="hidden" value="'.$obj->pid.'"/>';
	      }
	    ?>
	    
                          
        <input type="text" class="form-control" name="name"  >
        <input name="type" value="-1"/>
        <input name="brand" value="-1"/>
        <input name="origin" value="-1"/>
        <input name="type" value="-1"/>
        <input name="s_index" value="-1"/>
      
        <input type="text" class="form-control"  name="width" >
      
        <input type="text" class="form-control"  name="price" >
        <input type="text" class="form-control"  name="length" >
        <input type="text" class="form-control"  name="make_mode" >

		<input type="text" name="consistence" class="form-control" >

        <input type="text" class="form-control"  name="cigar_real"  >
      
        <input type="text" class="form-control"  name="cigar_ev_count">
      
      
        <input type="text" class="form-control"  name="cigar_taste" >
      
      
        <input type="text" class="form-control"  name="cigar_exte"  >
      
        <input type="text" class="form-control"  name="cigar_cost_per"  >
                          
                              
        <input type="text" class="form-control"  name="r_ev_count"  >
        <input type="text" class="form-control"  name="r_real"  >
        <input type="text" class="form-control"  name="redwine_type"  >
  
        <input type="text" class="form-control"  name="redwine_region" >
  
        <input type="text" class="form-control"  name="redwine_level" >
  
        <input type="text" class="form-control"  name="redwine_grape" >
  
        <input type="text" class="form-control"  name="redwine_score1"  >
  
        <input type="text" class="form-control"  name="redwine_score2"  >
  
        <input type="text" class="form-control"  name="redwine_score3"  >
  
        <input type="text" class="form-control"  name="redwine_score4" >
  
        <input type="text" class="form-control"  name="redwine_score5"  >
  
        <input type="text" class="form-control"  name="redwine_score6" >
  
        <input type="text" class="form-control"  name="redwine_capa" >
  
        <input type="text" class="form-control"  name="redwine_chateau" >
  
        <input type="text" class="form-control"  name="redwine_dktp" >
  
        <input type="text" class="form-control"  name="redwine_up_count"  >
        <input type="text" class="form-control"  name="redwine_ext1_title"  >
        
                          
         <input type="text" name="redwine_ext2_title">
                         
                          
        	   
	</form>

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://code.jquery.com/jquery.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="assets/js/vendor/bootstrap/bootstrap.min.js"></script>
    <script src="https://google-code-prettify.googlecode.com/svn/loader/run_prettify.js?lang=css&skin=sons-of-obsidian"></script>
    <script type="text/javascript" src="assets/js/vendor/mmenu/js/jquery.mmenu.min.js"></script>
    <script type="text/javascript" src="assets/js/vendor/sparkline/jquery.sparkline.min.js"></script>
    <script type="text/javascript" src="assets/js/vendor/nicescroll/jquery.nicescroll.min.js"></script>
    <script type="text/javascript" src="assets/js/vendor/animate-numbers/jquery.animateNumbers.js"></script>
    <script type="text/javascript" src="assets/js/vendor/videobackground/jquery.videobackground.js"></script>
    <script type="text/javascript" src="assets/js/vendor/blockui/jquery.blockUI.js"></script>\

	<script src="assets/js/vendor/jgrowl/jquery.jgrowl.min.js"></script>
    <script src="assets/js/vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="assets/js/vendor/datatables/ColReorderWithResize.js"></script>
    <script src="assets/js/vendor/datatables/colvis/dataTables.colVis.min.js"></script>
    <script src="assets/js/vendor/datatables/tabletools/ZeroClipboard.js"></script>
    <script src="assets/js/vendor/datatables/tabletools/dataTables.tableTools.min.js"></script>
    <script src="assets/js/vendor/datatables/dataTables.bootstrap.js"></script>

    <script src="assets/js/vendor/chosen/chosen.jquery.min.js"></script>
    
    <script src="assets/js/vendor/parsley/parsley.min.js"></script>
    
    <script src="assets/js/vendor/wizard/jquery.bootstrap.wizard.min.js"></script>
    <script src="assets/js/vendor/tabdrop/bootstrap-tabdrop.min.js"></script>
    
    <script src="assets/js/vendor/summernote/summernote.min.js"></script>

    <script src="assets/js/minimal.min.js"></script>
    <script>
    
    //initialize file upload button function
    $(document)
      .on('change', '.btn-file :file', function() {
        var input = $(this),
        numFiles = input.get(0).files ? input.get(0).files.length : 1,
        label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
        input.trigger('fileselect', [numFiles, label]);
    });
        
    $(function(){
    	
    	
    	//initialize file upload button
	      $('.btn-file :file').on('fileselect', function(event, numFiles, label) {
	        
	        var input = $(this).parents('.input-group').find(':text'),
	            log = numFiles > 1 ? numFiles + ' files selected' : label;
	
	            console.log(log);
	        
	        if( input.length ) {
	          input.val(log);
	        } else {
	          if( log ) alert(log);
	        }
	        
	      });


        //initialize chosen
        $('.dataTables_length select').chosen({disable_search_threshold: 10});

        //chosen select input
        $(".chosen-select").chosen({disable_search_threshold: 10});

        //load wysiwyg editor
        


        var jump_validate = false;
        //initialize form wizard
        $('#rootwizard').bootstrapWizard({

          'tabClass': 'nav nav-tabs tabdrop',
          onTabShow: function(tab, navigation, index) {

      	    var _index = $('.form1 select:eq(0)').get(0).selectedIndex;
        	  
              if(index == 2){
            	  
          	      if(_index != 3){
            	    	jump_validate = true;
            	    	$('.nav-tabs li:eq(1)').find('a').click();
            	        return false;
              	  }
               }else if(index == 1){
           	      if(_index != 0){
             	    	jump_validate = true;
             	       $('.nav-tabs li:eq(1)').find('a').click();
              	       return false;
               	  }
               }
              
            var $total = navigation.find('li').not('.tabdrop').length;
            var $current = index+1;
            var $percent = ($current/$total) * 100;
            $('#rootwizard').find('#bar .progress-bar').css({width:$percent+'%'});

            // If it's the last tab then hide the last button and show the finish instead
            if($current >= $total) {
              $('#rootwizard').find('.pager .next').hide();
              $('#rootwizard').find('.pager .finish').show();
              $('#rootwizard').find('.pager .finish').removeClass('disabled');
            } else {
              $('#rootwizard').find('.pager .next').show();
              $('#rootwizard').find('.pager .finish').hide();
            }  
          },

          onNext: function(tab, navigation, index) {
//               alert(index);
//         	  $('#_last_tab').click();
//               return true;
//         	console.log('n: ' + index);
        	

            var form = $('.form' + index)

            form.parsley('validate');

            if(form.parsley('isValid')) {
              tab.addClass('success');    
              
              //ok 这里确定跳到哪个位置
              switch(index){
              case 1:
                  var _index = $('.form1 select:eq(0)').get(0).selectedIndex;
//                   console.log('n_: ' + _index);
                  if(_index == 0){
                	  
                  }else if(_index == 3){
//                 	  console.log('n___: ..');
                	 $('.nav-tabs li:eq(3)').find('a').click();
                	 return false;
                  }else{
                	  $('#_last_tab').click();
                  }
                  break;
              case 2:
            	  $('#_last_tab').click();
                  break;
              case 3:
            	  $('#_last_tab').click();
                  break;
              }
              //
            } else {
              return false;
            }

          },

          onTabClick: function(tab, navigation, index) {

            if(jump_validate){
            	jump_validate = false;
                return true;
            }

            var form = $('.form' + (index+1))

            form.parsley('validate');

            if(form.parsley('isValid')) {
              tab.addClass('success');  
            } else {
              return false;
            }

          },
          onPrevious: function(tab, navigation, index){

        	  var _index = $('.form1 select:eq(0)').get(0).selectedIndex;
        	  switch(index){
        	  case 2:
        		  if(_index == 1 || _index == 2){
        			  $('.nav-tabs li:eq(1)').find('a').click();
        		  }else if(_index == 0){
        			  $('.nav-tabs li:eq(2)').find('a').click();
        			  return false;
      			  }
            	  break;
        	  case 1:
        		  $('.nav-tabs li:eq(1)').find('a').click();
            	  break;
        	  }
        	  
          },


          onLast: function(tab, navigation, index){
        	  console.log('last.');
          }

          
        });

        // Initialize tabDrop
        $('.tabdrop').tabdrop({text: '<i class="fa fa-th-list"></i>'});

        $('.pager .finish').click(function(){
        	console.log('finish.');
        	editor1.sync();
        	editor2.sync();
        	editor3.sync();
        	editor4.sync();
            //提交表单
            $('#post_form input[name=name]').val($('.form1 input[name=name]').val());
            console.log('1.');
            $('#post_form input[name=type]').val($('.form1 select[name=type]').val());
            $('#post_form input[name=s_index]').val($('.form1 select[name=type]').get(0).selectedIndex);
            $('#post_form input[name=brand]').val($('.form1 select[name=brand]').val());
            $('#post_form input[name=origin]').val($('.form1 select[name=origin]').val());
            $('#post_form input[name=width]').val($('.form1 input[name=width]').val());
            $('#post_form input[name=length]').val($('.form1 input[name=length]').val());
            $('#post_form input[name=make_mode]').val($('.form1 input[name=make_mode]').val());
//             $('#post_form input[name=img]').val($('.form1 input[name=img]').val());
            $('.form1 input[name=img]').appendTo($('#post_form'));
            $('.form2 input[name=c_img_desc]').appendTo($('#post_form'));
            $('#post_form input[name=price]').val($('.form1 input[name=price]').val());
            //$('#post_form textarea[name=ext_p]').val(.html());
			$('#input01').appendTo($('#post_form'));
			$('#input02').appendTo($('#post_form'));
			$('#input03').appendTo($('#post_form'));
			$('#input04').appendTo($('#post_form'));
            $('#post_form input[name=consistence]').val($('.form2 input[name=consistence]').val());
            $('#post_form input[name=cigar_real]').val($('.form2 input[name=cigar_real]').val());
            $('#post_form input[name=cigar_ev_count]').val($('.form2 input[name=cigar_ev_count]').val());
            $('#post_form input[name=cigar_taste]').val($('.form2 input[name=cigar_taste]').val());
            $('#post_form input[name=cigar_exte]').val($('.form2 input[name=cigar_exte]').val());
            $('#post_form input[name=cigar_cost_per]').val($('.form2 input[name=cigar_cost_per]').val());
            //$('#post_form textarea[name=cigar_desc]').val($('#input02').html());
//             $('#post_form input[name=c_img1]').val($('.form2 input[name=c_img1]').val());
//             $('#post_form input[name=c_img2]').val($('.form2 input[name=c_img2]').val());
//             $('#post_form input[name=c_img3]').val($('.form2 input[name=c_img3]').val());
//             $('#post_form input[name=c_img4]').val($('.form2 input[name=c_img4]').val());
//             $('#post_form input[name=c_img5]').val($('.form2 input[name=c_img5]').val());
            $('.form2 input[name=c_img1]').appendTo($('#post_form'));
            $('.form2 input[name=c_img2]').appendTo($('#post_form'));
            $('.form2 input[name=c_img3]').appendTo($('#post_form'));
            $('.form2 input[name=c_img4]').appendTo($('#post_form'));
            $('.form2 input[name=c_img5]').appendTo($('#post_form'));
            $('#post_form input[name=redwine_type]').val($('.form3 input[name=redwine_type]').val());
            $('#post_form input[name=r_ev_count]').val($('.form3 input[name=r_ev_count]').val());
            $('#post_form input[name=r_real]').val($('.form3 input[name=r_real]').val());
            $('#post_form input[name=redwine_region]').val($('.form3 input[name=redwine_region]').val());
            $('#post_form input[name=redwine_level]').val($('.form3 input[name=redwine_level]').val());
            $('#post_form input[name=redwine_grape]').val($('.form3 input[name=redwine_grape]').val());
            $('#post_form input[name=redwine_score1]').val($('.form3 input[name=redwine_score1]').val());
            $('#post_form input[name=redwine_score2]').val($('.form3 input[name=redwine_score2]').val());
            $('#post_form input[name=redwine_score3]').val($('.form3 input[name=redwine_score3]').val());
            $('#post_form input[name=redwine_score4]').val($('.form3 input[name=redwine_score4]').val());
            $('#post_form input[name=redwine_score5]').val($('.form3 input[name=redwine_score5]').val());
            $('#post_form input[name=redwine_score6]').val($('.form3 input[name=redwine_score6]').val());
            $('#post_form input[name=redwine_capa]').val($('.form3 input[name=redwine_capa]').val());
            $('#post_form input[name=redwine_chateau]').val($('.form3 input[name=redwine_chateau]').val());
            $('#post_form input[name=redwine_dktp]').val($('.form3 input[name=redwine_dktp]').val());
            $('#post_form input[name=redwine_up_count]').val($('.form3 input[name=redwine_up_count]').val());
            $('#post_form input[name=redwine_ext1_title]').val($('.form3 input[name=redwine_ext1_title]').val());
            //$('#post_form textarea[name=redwine_ext1_content]').val($('#input03').html());
            $('#post_form input[name=redwine_ext2_title]').val($('.form3 input[name=redwine_ext2_title]').val());
            //$('#post_form textarea[name=redwine_ext2_content]').val($('#input04').html());
//             $('#post_form input[name=redwine_image1]').val($('.form3 input[name=redwine_image1]').val());
//             $('#post_form input[name=redwine_image2]').val($('.form3 input[name=redwine_image2]').val());
//             $('#post_form input[name=redwine_image3]').val($('.form3 input[name=redwine_image3]').val());
//             $('#post_form input[name=redwine_image4]').val($('.form3 input[name=redwine_image4]').val());
//             $('#post_form input[name=redwine_image5]').val($('.form3 input[name=redwine_image5]').val());
            $('.form3 input[name=redwine_image1]').appendTo($('#post_form'));
            $('.form3 input[name=redwine_image2]').appendTo($('#post_form'));
            $('.form3 input[name=redwine_image3]').appendTo($('#post_form'));
            $('.form3 input[name=redwine_image4]').appendTo($('#post_form'));
            $('.form3 input[name=redwine_image5]').appendTo($('#post_form'));
            
            for(var i = 0; i < smc_id; i++){
            	var en = $('#small_cigar' + i);
            	en.appendTo($('#post_form'));
            }
            

            console.log('end.');
            $('#post_form').submit();
            
        });

		var smc_id = <?php echo $tmp_index ? $tmp_index : 1;?>;
		$('#add_cigar_').click(function(){
			var e = $('#small_cigar0').clone(true);
			e.attr('id','small_cigar' + smc_id);
			
			//sub attr
			var tmp_id = smc_id -1;
			e.find('[name=cigar_size0]').attr('name','cigar_size' + smc_id).val('');
			//e.find('[name=cigar_size' + smc_id + ']').val('');
			e.find('[name=cigar_frontmark0]').attr('name','cigar_frontmark' + smc_id).val('');
			e.find('[name=cigar_length0]').attr('name','cigar_length' + smc_id).val('');
			e.find('[name=cigar_width0]').attr('name','cigar_width' + smc_id).val('');
			e.find('[name=cigar_origin0]').attr('name','cigar_origin' + smc_id).val('');
			e.find('[name=c_img0]').attr('name','c_img' + smc_id);
			$('#small_cigar' + (smc_id-1)).after(e);
			
			//pre_img0
			$('#small_cigar'+smc_id+' #pre_img0').attr('src','').attr('id','pre_img' + (tmp_id+1));
			$('#small_cigar'+smc_id+' [name=cigar_imageid0]:eq(0)').remove();
			$('#small_cigar'+smc_id+' #imgViewc1').attr('src','').attr('id','imgViewc' + (smc_id+1));
			$('#small_cigar'+smc_id+' #divNewPreviewc1').attr('src','').attr('id','divNewPreviewc' + (smc_id+1));
			e.find('[name=c_img' +smc_id+']').attr('onchange',"PreviewImage(this,'imgViewc"+(smc_id+1)+"','divNewPreviewc"+(smc_id+1)+"',140,300)");
			//onchange="PreviewImage(this,'imgViewc1','divNewPreviewc1',140,300)"
			
			smc_id++;
		});

		var editor1;
        var editor2;
        var editor3;
        var editor4;
    	KindEditor.ready(function(K) {
			editor1 = K.create('#input01', {
				width : '100%',
				height: '431px',
				cssPath : '/editor/plugins/code/prettify.css',
				uploadJson : '/editor/php/upload_json.php',
				fileManagerJson : '/editor/php/file_manager_json.php',
				allowFileManager : true
			});
			
			editor2 = K.create('#input02', {
				width : '100%',
				height: '431px',
				cssPath : '/editor/plugins/code/prettify.css',
				uploadJson : '/editor/php/upload_json.php',
				fileManagerJson : '/editor/php/file_manager_json.php',
				allowFileManager : true
			});
			editor3 = K.create('#input03', {
				width : '100%',
				height: '431px',
				cssPath : '/editor/plugins/code/prettify.css',
				uploadJson : '/editor/php/upload_json.php',
				fileManagerJson : '/editor/php/file_manager_json.php',
				allowFileManager : true
			});
			editor4 = K.create('#input04', {
				width : '100%',
				height: '431px',
				cssPath : '/editor/plugins/code/prettify.css',
				uploadJson : '/editor/php/upload_json.php',
				fileManagerJson : '/editor/php/file_manager_json.php',
				allowFileManager : true,
				afterCreate : function(){
					<?php echo $script;?>
				}
			});
			prettyPrint();
		});


        
        
      });
        
    </script>
  </body>
</html>
      
