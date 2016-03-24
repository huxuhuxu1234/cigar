<?php 

    //判断是否在登录状态
    require 'check_user_avail.php';
    require 'contact.inc.php';
    
	$result = C::t('cigar_culture_header')->fetch_data();

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
                    

                  <li class="dropdown">
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
                      <li>
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

                  <li class="dropdown active open">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                      <i class="fa fa-align-right"></i> 联系我们 <b class="fa fa-plus dropdown-plus"></b>
                    </a>
                    <ul class="dropdown-menu">
                      <li class="active">
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
            

            <h2><i class="fa fa-align-right"></i> 联系我们
            <span>内容设置</span></h2>


          </div>
          <!-- /page header -->
          
          
          <!-- content main container -->
          <div class="main">


            
            <!-- row -->
            <div class="row">

              
              <!-- col 12 -->
              <div class="col-md-10">
                
                
                <!-- tile -->
                <section class="tile color transparent-black">


                  <!-- tile header -->
                  <div class="tile-header">
                    <h1> &nbsp; </h1>
                      
                    <div class="controls">
                      <a href="#" class="refresh"><i class="fa fa-refresh"></i></a>
                      <a href="#" class="remove"><i class="fa fa-times"></i></a>
                    </div>
                  </div>
                  <!-- /tile header -->

                  <!-- tile body -->
                  <div class="tile-body">
                  
                  
                     <form class="form-horizontal" role="form" method="post" action="action.php?action=contact" >
                      
                      <div class="form-group">
                        <label for="input01" class="col-sm-2 control-label">QQ：</label>
                        <div class="col-sm-4">
                          <input type="text" class="form-control" id="input01" value="<?php echo $_CINFO['qq'];?>" name="qq" >
                        </div>
                      </div>
                      
                      <div class="form-group">
                        <label for="input03" class="col-sm-2 control-label">电话：</label>
                        <div class="col-sm-4">
                          <input type="text" class="form-control" id="input03" value="<?php echo $_CINFO['tel'];?>" name="tel">
                        </div>
                      </div>
                      
                      
                      <div class="form-group">
                        <label for="input07" class="col-sm-2 control-label">微博：</label>
                        <div class="col-sm-4">
                          <input type="text" class="form-control" id="input07" value="<?php echo $_CINFO['weibo'];?>" name="weibo"> 
                        </div>
                      </div>
                      
                      <div class="form-group">
                        <label for="input09" class="col-sm-2 control-label">微信：</label>
                        <div class="col-sm-4">
                          <input type="text" class="form-control" id="input09" value="<?php echo $_CINFO['weixin'];?>" name="weixin">
                        </div>
                      </div>
                      
                      <div class="form-group">
                        <label for="input11" class="col-sm-2 control-label">邮箱：</label>
                        <div class="col-sm-4">
                          <input type="text" class="form-control" id="input11" value="<?php echo $_CINFO['mail'];?>" name="mail">
                        </div>
                      </div>

                      
                      <div class="form-group form-footer">
                        <div class="col-sm-offset-4 col-sm-8">
                          <button type="submit" class="btn btn-primary">更改</button>
                          <button type="reset" class="btn btn-default">重置</button>
                        </div>
                      </div>

                    </form>

                  </div>
                  <!-- /tile body -->
                


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

    <script src="assets/js/minimal.min.js"></script>
    <script>

    $(function(){
    	
    });
        
    </script>
  </body>
</html>
      
