<?php 

    //判断是否在登录状态
    require 'check_user_avail.php';
    
	$result = C::t('cigar_about')->fetch_data_flag_admin();

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
                      <li>
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
                    
                    
                  <li class="active">
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
            

            <h2><i class="fa fa-tachometer"></i> 关于我们
            <span>关于我们内容管理</span></h2>


          </div>
          <!-- /page header -->
          
          
            <!-- content main container -->
          <div class="main">




            <!-- row -->
            <div class="row">

              
              <!-- col 12 -->
              <div class="col-md-12">
                
                
                <!-- tile -->
                <section class="tile transparent">


                  <!-- tile header -->
                  <div class="tile-header transparent">
                    <h1>&nbsp;</h1>
                      
                      <div class="checkbox check-transparent">
                            
                      </div>
                      
                    <div class="controls">
                      <a href="#" class="refresh"><i class="fa fa-refresh"></i></a>
                      <a href="#" class="remove"><i class="fa fa-times"></i></a>
                    </div>
                  </div>
                  <!-- /tile header -->

                  <!-- tile body -->
                  <div class="tile-body color transparent-black rounded-corners">
                    
                    <div class="table-responsive">
                      <table  class="table table-datatable table-custom" id="basicDataTable">
                        <thead>
            				<tr>
            					<th class="text-center">
									<input type="checkbox" id="select_all">
                                    <label for="select_all">全选</label>
								</th>
            					<th class="sort-numeric">序号</th>
            					<th class="sort-alpha">头部显示</th>
            					<th class="sort-alpha">右侧图片显示</th>
            					<th class="sort-alpha">右侧头部标题</th>
            					<th class="sort-alpha">右侧头部内容</th>
            					<th class="sort-numeric">显示顺序</th>
            					<th>查看</th>
            				</tr>
            			</thead>
            			
                        <tbody>
                        
					<?php 
				    
				    foreach ($result as $index => $row){
				        $i = $index + 1;
				        $id = $row['aid'];
				        $header = $row['header'];
				        $right_header = $row['right_header'];
						$right_header_1 = split('@', $right_header)[0];
						$right_header_2 = split('@', $right_header)[1];
				        $right_img = '../' . $row['right_img'];
				        $order = $row['order'];
				        echo <<<EOT
				<tr>
                    <td  class="text-center"><input type="checkbox" id="$id"/></td>
                    <td> $i </td>
                    <td>$header</td>
		            <td><img src="$right_img" height="50px" width="100px"/></td>
		            <td>$right_header_1</td>
		            <td>$right_header_2</td>
		            <td>$order</td>
 		            <td><a href="../aboutus.php" target="_blank">查看</a></td>
				</tr>
EOT;
				    }
				
				?>
                          
                        </tbody>
                      </table>
                    </div>
                    
                    
                        <div class="modal fade" id="delete_Confirm" tabindex="-1" role="dialog" aria-labelledby="modalDialogLabel" aria-hidden="true">
					      <div class="modal-dialog">
					        <div class="modal-content">
					          <div class="modal-header">
					            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">Close</button>
					            <h3 class="modal-title" id="modalDialogLabel">确认删除</h3>
					          </div>
					          <div class="modal-body">
					            <p></p><p></p>
					            <p id="detele_tip"></p>
					            
					            
					          </div>
					          
					          <div class="modal-footer">
	                            <button class="btn btn-red" data-dismiss="modal" aria-hidden="true">取消</button>
	                            <button class="btn btn-green" id="delete_confirm_btn" data-dismiss="modal" >确定</button>
                            </div>
					        </div><!-- /.modal-content -->
					      </div><!-- /.modal-dialog -->
					    </div><!-- /.modal -->
					    
					    
				    <div class="modal fade" id="modalConfirm" tabindex="-1" role="dialog" aria-labelledby="modalConfirmLabel" aria-hidden="true">
                      <div class="modal-dialog">
                        <div class="modal-content">
                          <form role="form" name="form_add" action="action.php?action=about_us&handle=add" method="post" enctype="multipart/form-data" parsley-validate >
                          <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">Close</button>
                            <h3 class="modal-title" id="modalConfirmLabel">添加</h3>
                          </div>
                          <div class="modal-body">
                            
                            
                            <div class="form-group">
                                <label for="input04" class="col-sm-2 control-label">上传图片预览：</label>
                                <div class="col-sm-6">
                                
                                </div>
                                <div class="col-sm-4">
                                  <img id="imgView" src=""  height="140" />
                                    <div id="divNewPreview"></div>
                                  </div>
                              </div>
                              
                              <div class="form-group">
                                <label >右侧图片：</label>
                                <div class="input-group">
		                          <span class="input-group-btn">
		                            <span class="btn btn-primary btn-file">
		                              <i class="fa fa-upload"></i><input type="file" name="img" parsley-required="true" parsley-trigger="change" onchange="PreviewImage(this,'imgView','divNewPreview',140,140)">
		                            </span>
		                          </span>
		                          <input type="text" class="form-control" readonly="" parsley-required="true" parsley-error-message="请选择文件！ 如果已经选择，请无视此提示">
		                        </div>
                              </div>

                              <div class="form-group">
                                <label for="passwordInput">显示顺序：</label>
                                <input type="text" class="form-control" id="passwordInput" name="order" parsley-trigger="change" parsley-required="true" parsley-type="number" parsley-required-message="请输入显示顺序" parsley-type-message="请输入正确的数字" >
                              </div>

                              <div class="form-group">
                                <label for="placeholderInput">头部显示：</label>
                                <input type="text" class="form-control" id="placeholderInput" name="header" parsley-required="true" parsley-trigger="change" parsley-required-message="请输入头部显示的内容" > 
                              </div>
                              
                              <div class="form-group">
                                <label for="placeholderInput">右侧头部标题：</label>
                                <input type="text" class="form-control" id="placeholderInput" name="right_header_1" parsley-required="true" parsley-trigger="change" parsley-required-message="请输入右侧头部标题" > 
                              </div>
                              
                              <div class="form-group">
                                <label for="placeholderInput">右侧头部副标题：</label>
                                <input type="text" class="form-control" id="placeholderInput" name="right_header_2" parsley-required="true" parsley-trigger="change" parsley-required-message="请输入头部副标题" > 
                              </div>
                              
                              <div class="form-group ">
		                        <label class="control-label">内容： </label>
		                        <div class="">
		                          <div class="form-control" id="input06" ></div>
		                        </div>
		                      </div>
		                      
		                      <div class="form-group ">
		                        <label class="control-label">右侧内容： </label>
		                        <div class="">
		                          <div class="form-control" id="input08" ></div>
		                        </div>
		                      </div>
                              

                          </div>
                          <div class="modal-footer">
                            <button class="btn btn-red" data-dismiss="modal" aria-hidden="true" type="button">取消</button>
                            <button class="btn btn-green" type="submit">添加</button>
                          </div>
                         </form>
                        </div><!-- /.modal-content -->
                      </div><!-- /.modal-dialog -->
                    </div><!-- /.modal -->           
                    
                    
                    
                    <div class="modal fade" id="updateModalConfirm" tabindex="-1" role="dialog" aria-labelledby="modalConfirmLabel" aria-hidden="true">
                      <div class="modal-dialog">
                        <div class="modal-content">
                          <form role="form" name="form_update" action="action.php?action=about_us&handle=update" method="post" enctype="multipart/form-data" parsley-validate >
                          <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">Close</button>
                            <h3 class="modal-title" id="modalConfirmLabel">修改</h3>
                          </div>
                          <div class="modal-body">
                            
                            
                            <div class="form-group">
                                <label for="input04" class="col-sm-2 control-label">原图：</label>
                                <div class="col-sm-6">
                                  <img id="pre_img" src="" width="140px" height="140px"/>
                                </div>
                                <div class="col-sm-4">
                                  <img id="imgViewU" src=""  height="140" width="140px" />
                                    <div id="divNewPreviewU"></div>
                                  </div>
                              </div>
                              
                              
                              <div class="form-group">
                                <label >右侧图片：</label>
                                <div class="input-group">
		                          <span class="input-group-btn">
		                            <span class="btn btn-primary btn-file">
		                              <i class="fa fa-upload"></i><input type="file" name="img" parsley-required="true" parsley-trigger="change" onchange="PreviewImage(this,'imgViewU','divNewPreviewU',140,140)">
		                            </span>
		                          </span>
		                          <input type="text" class="form-control" readonly="" >
		                        </div>
                              </div>

                              <div class="form-group">
                                <label for="passwordInput">显示顺序：</label>
                                <input type="text" class="form-control" id="passwordInput" name="order" parsley-trigger="change" parsley-required="true" parsley-type="number" parsley-required-message="请输入显示顺序" parsley-type-message="请输入正确的数字" >
                              </div>

                              <div class="form-group">
                                <label for="placeholderInput">头部显示：</label>
                                <input type="text" class="form-control" id="placeholderInput" name="header" parsley-required="true" parsley-trigger="change" parsley-required-message="请输入头部显示的内容" > 
                              </div>
                              
                              <div class="form-group">
                                <label for="placeholderInput">右侧头部标题：</label>
                                <input type="text" class="form-control" id="placeholderInput" name="right_header_1" parsley-required="true" parsley-trigger="change" parsley-required-message="请输入右侧头部标题" > 
                              </div>
                              
                              <div class="form-group">
                                <label for="placeholderInput">右侧头部副标题：</label>
                                <input type="text" class="form-control" id="placeholderInput" name="right_header_2" parsley-required="true" parsley-trigger="change" parsley-required-message="请输入头部副标题" > 
                              </div>
                              
                              <div class="form-group ">
		                        <label class="control-label">内容： </label>
		                        <div class="">
		                          <div class="form-control" id="input09" ></div>
		                        </div>

		                      
		                      <div class="form-group ">
		                        <label class="control-label">右侧内容： </label>
		                        <div class="">
		                          <div class="form-control" id="input10" ></div>
		                        </div>
		                      </div>
                              

                          </div>
                          <div class="modal-footer">
                            <button class="btn btn-red" data-dismiss="modal" aria-hidden="true" type="button">取消</button>
                            <button class="btn btn-green" type="submit">修改</button>
                          </div>
                          <input type="hidden" id="flag" name="flag" value="-1" />
                         </form>
                        </div><!-- /.modal-content -->
                      </div><!-- /.modal-dialog -->
                    </div><!-- /.modal -->   
                    

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
    
    <script src="assets/js/vendor/summernote/summernote.min.js"></script>
    
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

        // Add custom class to pagination div
        $.fn.dataTableExt.oStdClasses.sPaging = 'dataTables_paginate paging_bootstrap paging_custom';

        /*************************************************/
        /**************** BASIC DATATABLE ****************/
        /*************************************************/

        /* Define two custom functions (asc and desc) for string sorting */
        jQuery.fn.dataTableExt.oSort['string-case-asc']  = function(x,y) {
            return ((x < y) ? -1 : ((x > y) ?  1 : 0));
        };
         
        jQuery.fn.dataTableExt.oSort['string-case-desc'] = function(x,y) {
            return ((x < y) ?  1 : ((x > y) ? -1 : 0));
        };


		/* Add a click handler to the all_select checkbox */
		$('#select_all').click(function(){
			var flag = this.checked;
				$('#basicDataTable tbody :checkbox').each(function (){
					this.checked = flag;
			});
		});

        /* Add a click handler to the rows - this could be used as a callback */
        $("#basicDataTable tbody tr").click( function( e ) {
          
          if(event){
			  if($(event.target).attr('href')){
			  	 return;
			  }
          }
        	
          if ( $(this).hasClass('row_selected') ) {
            $(this).removeClass('row_selected');
            $(this).find('input[type=checkbox]:eq(0)').get(0).checked = false;
          }
          else {
//             oTable01.$('tr.row_selected').removeClass('row_selected');
            $(this).addClass('row_selected');
			$(this).find('input[type=checkbox]:eq(0)').get(0).checked = true;
          }

          // FadeIn/Out delete rows button
//        if ($('#basicDataTable tr.row_selected').length > 0) {
//          $('#deleteRow').stop().fadeIn(300);
//        } else {
//          $('#deleteRow').stop().fadeOut(300);
//        }
        });
        
        
        /* Double Click. */
       $("#basicDataTable tbody tr").dblclick(function(e){
         $.jGrowl("正在获取数据中");
         
         
         var id = $(this).find('input[type=checkbox]:eq(0)').attr('id');
         if(!id || isNaN(id)){
         	$.jGrowl("您的选择有误，请刷新页面后重试");
         	return false;
         }
         
         $.post('simple_query.php',{'info': 'update','type': 'about_us','id': id},function(data){
					if(data.hasOwnProperty('result')){
						if(data.result == '-1'){
							$.jGrowl('参数有误    #1');
						}else if(data.result == '-2'){
							$.jGrowl('查询失败，请重试');
						}
						return;
					}
					if(!data || data == ''){
						$.jGrowl('查询失败，请重试');
						return;
					}
					
					$.jGrowl('请求数据完毕，正在整理中，请稍等');

					// ok ，整理form
					var model = eval('(' + data + ')');
					$('#updateModalConfirm input[name=order]').val(model.order);
					$('#updateModalConfirm input[name=header]').val(model.header);
					$('#pre_img').attr('src', '../' + model.right_img);
					$('#input09').code(model.content);
					var r_h = model.right_header.split('@');
					$('#updateModalConfirm input[name=right_header_1]').val(r_h[0]);
					$('#updateModalConfirm input[name=right_header_2]').val(r_h[1]);
					$('#input10').code(model.right_content);
					
					$('#flag').val(id);
					$('#open_update_modal').click();
				}).error(function(){
					$.jGrowl('请求数据失败，请重试');
				});
       	
       });

        /* Build the DataTable with third column using our custom sort functions */
        var oTable01 = $('#basicDataTable').dataTable({
          "sDom":
            "R<'row'<'col-md-6'l><'col-md-6'f>r>"+
            "t"+
            "<'row'<'col-md-4 sm-center'i><'col-md-4'><'col-md-4 text-right sm-center'p>>",
          "oLanguage": {
            "sSearch": "",
            "sLengthMenu": "每页显示 _MENU_ 条记录",
            "sZeroRecords": "Nothing found - 没有记录",
            "sInfo": "显示第  _START_ 条到第  _END_ 条记录,一共  _TOTAL_ 条记录",
            "sInfoEmpty": "显示0条记录",
            "oPaginate": {
             "sPrevious": " 上一页 ",
             "sNext":     " 下一页 ",
             }
          },
          "aaSorting": [ [1,'asc'] ] ,
          "aoColumns": [
            null,
            null,
            { "sType": 'string-case' },
            null,
            null,
            null,
            null,
            null
          ],
          "aoColumnDefs": [ { "bSortable": false, "aTargets": [ 0 ] }],
          "fnInitComplete": function(oSettings, json) { 
            $('.dataTables_filter input').attr("placeholder", "Search");
          }, 
        });

        // Append delete button to table
        var oper = '<div class="col-sm-offset-1 col-sm-6" id="oper" ></div>';
        $('#basicDataTable_wrapper .row .col-md-6:eq(0)').append(oper);
        var addLink = '<a href="#modalConfirm" id="add" data-toggle="modal"  class="btn btn-orange m_r_5">添加</a>';
        $('#oper').append(addLink);
        var updateLink = '<button type="button" id="update" class="btn btn-green m_r_5">修改</button>';
        $('#oper').append(updateLink);
        var deleteRowLink = '<a href="#delete_Confirm" data-toggle="modal" id="deleteRow" class="btn btn-red">删除选中行</a>'
        $('#oper').append(deleteRowLink);
       

		var id_array = new Array();
        /* Add a click handler for the delete row */
        $('#deleteRow').click( function() {
			
			id_array = [];

//			var id_array = new Array();
			
			$('#basicDataTable input[type=checkbox]:checked').each(function(){
				var v = $(this).attr('id');
				if(!v || isNaN(v)){
					return ;
				}
				id_array.push(v);
			});
			
			if(id_array.length == 0){
				$('#detele_tip').html('并没有选中任何数据。');
			}else{
				$('#detele_tip').html('确定要删除这' + id_array.length + '条数据么？');
			}
			
        });
        
        $('#delete_confirm_btn').click(function(){
        	
        	if(id_array.length == 0){
        		return ;
        	}
        	
        	$.post('action.php?action=about_us&handle=del',{'id_array': id_array.join(',')},function(data){
				if(isNaN(data) || data== '' || data == 0){
//					alert('删除失败： ' + data);
					$.jGrowl(data, { header: '删除失败', sticky: true });		
				}else{
					$.jGrowl("删除成功 !");
					var anSelected = fnGetSelected(oTable01);
					if(anSelected.length !== 0 ){
						$(anSelected).each(function(){
							oTable01.fnDeleteRow(this);
						});
					}
				}
			}).error(function (){
				$.jGrowl("删除失败", { sticky: true });
			});
        	
        });
        
        /* update */
       $('#update').click(function(){
         $.jGrowl("双击单条数据进行修改。");
       });
        
        

        /* Get the rows which are currently selected */
        function fnGetSelected(oTable01Local){
          return oTable01Local.$('tr.row_selected');
        };

        //initialize chosen
        $('.dataTables_length select').chosen({disable_search_threshold: 10});
        
          //load wysiwyg editor
	      $('#input06').summernote({
	        toolbar: [
	          //['style', ['style']], // no style button
	          ['style', ['bold', 'italic', 'underline', 'clear']],
	          ['fontsize', ['fontsize']],
	          ['color', ['color']],
	          ['para', ['ul', 'ol', 'paragraph']],
	          ['height', ['height']],
	          //['insert', ['picture', 'link']], // no insert buttons
	          //['table', ['table']], // no table button
	          //['help', ['help']] //no help button
	        ],
	        height: 150   //set editable area's height
	      });
	      $('#input06').parent().find('textarea:eq(0)').attr('name',"content");
	      
	      
	      //load wysiwyg editor
	      $('#input08').summernote({
	        toolbar: [
	          //['style', ['style']], // no style button
	          ['style', ['bold', 'italic', 'underline', 'clear']],
	          ['fontsize', ['fontsize']],
	          ['color', ['color']],
	          ['para', ['ul', 'ol', 'paragraph']],
	          ['height', ['height']],
	          //['insert', ['picture', 'link']], // no insert buttons
	          //['table', ['table']], // no table button
	          //['help', ['help']] //no help button
	        ],
	        height: 150   //set editable area's height
	      });
	      $('#input08').parent().find('textarea:eq(0)').attr('name',"right_content");
	      

	      $('form[name=form_add]').submit(function(){
	      	$(this).find('textarea[name=content]').val($('#input06').code());
	      	$(this).find('textarea[name=right_content]').val($('#input08').code());
	      	
	      });
	      
	      
  	      $('#input09').summernote({
	        toolbar: [
	          //['style', ['style']], // no style button
	          ['style', ['bold', 'italic', 'underline', 'clear']],
	          ['fontsize', ['fontsize']],
	          ['color', ['color']],
	          ['para', ['ul', 'ol', 'paragraph']],
	          ['height', ['height']],
	          //['insert', ['picture', 'link']], // no insert buttons
	          //['table', ['table']], // no table button
	          //['help', ['help']] //no help button
	        ],
	        height: 150   //set editable area's height
	      });
	      $('#input09').parent().find('textarea:eq(0)').attr('name',"content");
	      
	      
	      //load wysiwyg editor
	      $('#input10').summernote({
	        toolbar: [
	          //['style', ['style']], // no style button
	          ['style', ['bold', 'italic', 'underline', 'clear']],
	          ['fontsize', ['fontsize']],
	          ['color', ['color']],
	          ['para', ['ul', 'ol', 'paragraph']],
	          ['height', ['height']],
	          //['insert', ['picture', 'link']], // no insert buttons
	          //['table', ['table']], // no table button
	          //['help', ['help']] //no help button
	        ],
	        height: 150   //set editable area's height
	      });
	      $('#input10').parent().find('textarea:eq(0)').attr('name',"right_content");
	      
	      $('form[name=form_update]').submit(function(){
	      	$(this).find('textarea[name=content]').val($('#input09').code());
	      	$(this).find('textarea[name=right_content]').val($('#input10').code());
	      	
	      });
	      
	      
        
      });
        
    </script>
  </body>
</html>
      
