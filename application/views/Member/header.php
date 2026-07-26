<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <title>AIM</title>
    <!-- Favicon-->
    <link rel="icon" href="../../favicon.ico" type="image/x-icon">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

<style type="text/css">
    .search-barb input[type="text"] {
    width: 100%;
    font-size: 16px;
    padding: 25px 60px 23px 56px;
    border: none;

}

#search-rows{
    animation-name: bounceInDown;
    animation-duration: 1s;
    display: none;
}

#search-result{
    animation-duration: 1s;
    animation-name: bounceInDown;
}

#menu li{
    padding: 10px;
}

.search-barb .search-icon {
    position: absolute;
    top: 20px;
    left: 14px;

    }

    .border{
       display: none;
    }

.search-barb .close-search{
    position: absolute;
cursor: pointer;
font-size: 30px;
top: 18px;
right: 18px;
}

.search-barb {
    position: fixed;
    top: -100px;
    display: none;
    margin-top: 100px;
    margin-left: 0px;
    left: 0;
    z-index: 9999999;
    width: 100%;
    -moz-transition: 0.25s;
    -o-transition: 0.25s;
    -webkit-transition: 0.25s;
    transition: 0.25s;
}
* {
    -webkit-box-sizing: border-box;
    -moz-box-sizing: border-box;
    box-sizing: border-box;
}
</style>
    <!-- Waves Effect Css -->

    <!-- Animation Css -->

    <!-- Custom Css -->

    <!-- AdminBSB Themes. You can choose a theme from css/themes instead of get all themes -->

    <!-- AdminBSB Themes. You can choose a theme from css/themes instead of get all themes -->
    <link href="<?= base_url('assets/css/themes/all-themes.css');?>" rel="stylesheet" />
    <!-- Google Fonts -->

    <link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/icon.css'); ?>">
    <link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/icon2.css'); ?>">
<!--
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,700&subset=latin,cyrillic-ext" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" type="text/css">
-->
    <!-- Bootstrap Core Css -->
    <link href="<?= base_url('assets/plugins/bootstrap/css/bootstrap.css');?>" rel="stylesheet">

    <!-- Waves Effect Css -->
    <link href="<?= base_url('assets/plugins/node-waves/waves.css');?>" rel="stylesheet" />

    <!-- Animation Css -->
    <link href="<?= base_url('assets/plugins/animate-css/animate.css');?>" rel="stylesheet" />

    <!-- Sweet Alert Css -->
    <link href="<?= base_url('assets/plugins/sweetalert/sweetalert.css');?>" rel="stylesheet" />

    <!-- Custom Css -->
    <link href="<?= base_url('assets/css/style.css');?>" rel="stylesheet">

     <link href="<?= base_url('assets/css/themes/all-themes.css');?>" rel="stylesheet" />





</head>


<body class="theme-cyan">


    <script type="text/javascript">
        $(document).ready(function(){
            $(".js-search").click(function(){
               $(".search-barb").slideDown('fast');
            });

            $(".close-search").click(function(){
               $(".search-barb").slideUp('fast');
               $("#searching-panel").fadeOut('fast');
               $("#searching").val('');
                $(".search-barb").hide('fast');
            });

            $(".form-control").click(function(){
               $(".form-control").css('border-bottom','solid 1px blue');
               $(".form-label").css('top','-16px');
                $(".form-label").css('font-size','12px');
            });


            var s = $(".form-control").val();

            if (s=='') {
                 $(".form-control").css('border-bottom','none');
               $(".form-label").css('top','10px');
                 $(".form-label").css('font-size','16px');
            }else{
                 $(".form-control").css('border-bottom','solid 1px blue');
               $(".form-label").css('top','-16px');
                $(".form-label").css('font-size','12px');

            }

            
            
        });
    </script>
    <!-- Page Loader 
    <div class="page-loader-wrapper">
        <div class="loader">
            <div class="preloader">
                <div class="spinner-layer pl-red">
                    <div class="circle-clipper left">
                        <div class="circle"></div>
                    </div>
                    <div class="circle-clipper right">
                        <div class="circle"></div>
                    </div>
                </div>
            </div>
            <p>Please wait...</p>
        </div>
    </div>
    Page Loader -->
    <!-- Overlay For Sidebars -->
    <div class="overlay"></div>
    <!-- #END# Overlay For Sidebars -->
    <!-- Search Bar -->
    <div class="search-barb" >
        <div class="search-icon">
            <i class="material-icons">search</i>
        </div>
        <form method="post" id="searchForm">
            <input type="text"  name="searching" placeholder="Search..." id="searching">
        </form>
        <div class="close-search">
            <i class="material-icons">close</i>
        </div>
    </div>
    <!-- #END# Search Bar -->
    <!-- Top Bar -->
   <nav class="navbar">
        <div class="container-fluid">
            <div class="navbar-header">
                <a href="javascript:void(0);" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse" aria-expanded="false"></a>
                <a href="javascript:void(0);" class="bars"></a>
                <a class="navbar-brand" href="<?= site_url('Member_login/dashboard'); ?>">Advance Industry Maintainance</a>
            </div>
            <div class="collapse navbar-collapse" id="navbar-collapse">
                <ul class="nav navbar-nav navbar-right">
                    <!-- Call Search -->
                    <li><a href="javascript:void(0);" class="js-search" data-close="true"><i class="material-icons">search</i></a></li>
                    <!-- #END# Call Search -->
                    <!-- Notifications -->
                  
                    <!-- #END# Notifications -->
                    <!-- Tasks -->
                    <li class="dropdown">
                        <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button">
                            <i class="material-icons">flag</i>
                            <span class="label-count">9</span>
                        </a>
                       
                    <li class="pull-right"><a href="javascript:void(0);" class="js-right-sidebar" data-close="true"><i class="material-icons">more_vert</i></a></li>
                </ul>
            </div>
        </div>
    </nav>
    <!-- #END# Search Bar -->
    <!-- Top Bar -->
    <nav class="navbar">
        <div class="container-fluid">
            <div class="navbar-header">
                <a href="javascript:void(0);" class="bars"></a>
                <a class="navbar-brand" href="<?= site_url('Member_login/dashboard'); ?>">Advance Industery Management</a>
            </div>
            <div class="collapse navbar-collapse">
                <ul class="nav navbar-nav navbar-right">
                    <!-- Call Search -->
                    <li><a href="javascript:void(0);" class="js-search"><i class="material-icons">search</i></a></li>
                    <!-- #END# Call Search -->
                    <!-- Notifications -->
                    <li class="dropdown">
                        <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button">
                            <i class="material-icons">notifications</i>
                            <span class="label-count" id="count">7</span>
                        </a>
                        <ul class="dropdown-menu">
                            <li class="header">NOTIFICATIONS</li>
                            <li class="body">
                                <ul class="menu" style="list-style: none;" id="notifications">
                                  
                          
                        </ul>
                    </li>
                    <!-- #END# Notifications -->
                   </ul>
            </div>
        </div>
    </nav>
    <!-- #Top Bar -->
    <section>
        <!-- Left Sidebar -->
        <aside id="leftsidebar" class="sidebar">
            <!-- User Info -->
            <div class="user-info">
                    <div class="user_data">
                        
                    </div>

                     <div class="btn-group  pull-right" >
                        <i class="material-icons" style="color: #fff;cursor: pointer;" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">keyboard_arrow_down</i>
                        <ul class="dropdown-menu pull-right">
                            <li><a href="<?= site_url('Member_login/profile'); ?>"><i class="material-icons">person</i>Profile</a></li>
                            <li role="seperator" class="divider"></li>
                            <li><a href="<?= site_url('Member_login/logout'); ?>"><i class="material-icons">input</i>Sign Out</a></li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- #User Info -->
            <!-- Menu -->
            <div class="menu">
                <ul class="list">
                    <li class="header">MAIN NAVIGATION</li>
                      <li >
                        <a href="<?= site_url('Member_login/dashboard'); ?>">
                            <i class="material-icons">home</i>
                            <span>Dashboard</span>
                        </a>
                    </li>
                         <!-- Menu -->
            <div>
                <ul class="list" >
                  
                   
                    <li>
                        <a href="<?= site_url('Member_login/media'); ?>" class="">
                            <i class="material-icons">perm_media</i>
                            <span>My Directory</span>
                        </a>
                        
                    </li>
                    
                    <li>
                        <a href="<?= site_url('Member_login/shared_with') ?>" class="">
                            <i class="material-icons">share</i>
                            <span>Shared with me</span>
                        </a>
                       
                    </li>
                   
                   
                   
                    <li class="header">Important</li>
                    <li>
                        <a href="<?= site_url('Member_login/trash'); ?>">
                            <i class="material-icons col-red">donut_large</i>
                            <span>Trash</span>
                        </a>
                    </li>
                  
                </ul>
            </div>
          
                    <li>
                        <a href="javascript:void(0);" class="">
                            
                        </a>
                        <ul class="ml-menu">
                            <li>
                                <a href="../../pages/ui/alerts.html">Alerts</a>
                            </li>
                            <li>
                                <a href="../../pages/ui/animations.html">Animations</a>
                            </li>
                            <li class="active">
                                <a href="../../pages/ui/badges.html">Badges</a>
                            </li>
                            <li>
                                <a href="../../pages/ui/breadcrumbs.html">Breadcrumbs</a>
                            </li>
                            <li>
                                <a href="../../pages/ui/buttons.html">Buttons</a>
                            </li>
                            <li>
                                <a href="../../pages/ui/collapse.html">Collapse</a>
                            </li>
                            <li>
                                <a href="../../pages/ui/colors.html">Colors</a>
                            </li>
                            <li>
                                <a href="../../pages/ui/dialogs.html">Dialogs</a>
                            </li>
                            <li>
                                <a href="../../pages/ui/icons.html">Icons</a>
                            </li>
                            <li>
                                <a href="../../pages/ui/labels.html">Labels</a>
                            </li>
                            <li>
                                <a href="../../pages/ui/list-group.html">List Group</a>
                            </li>
                            <li>
                                <a href="../../pages/ui/media-object.html">Media Object</a>
                            </li>
                            <li>
                                <a href="../../pages/ui/modals.html">Modals</a>
                            </li>
                            <li>
                                <a href="../../pages/ui/notifications.html">Notifications</a>
                            </li>
                            <li>
                                <a href="../../pages/ui/pagination.html">Pagination</a>
                            </li>
                            <li>
                                <a href="../../pages/ui/preloaders.html">Preloaders</a>
                            </li>
                            <li>
                                <a href="../../pages/ui/progressbars.html">Progress Bars</a>
                            </li>
                            <li>
                                <a href="../../pages/ui/range-sliders.html">Range Sliders</a>
                            </li>
                            <li>
                                <a href="../../pages/ui/sortable-nestable.html">Sortable & Nestable</a>
                            </li>
                            <li>
                                <a href="../../pages/ui/tabs.html">Tabs</a>
                            </li>
                            <li>
                                <a href="../../pages/ui/thumbnails.html">Thumbnails</a>
                            </li>
                            <li>
                                <a href="../../pages/ui/tooltips-popovers.html">Tooltips & Popovers</a>
                            </li>
                            <li>
                                <a href="../../pages/ui/waves.html">Waves</a>
                            </li>
                        </ul>
                    </li>
               
         
                    
                   
                   
               
                   
                </ul>
            </div>

         
        </aside>

      
        <!-- #END# Left Sidebar -->
       
    </section>

        <div class="col-lg-9" style="margin-left: 320px;background: #fff;height: 650px;margin-bottom: 100px;display: none;" id="searching-panel">
            <div class="panel panel-default" style="margin-top: 20px;">
                <div class="panel-heading ">
                    <h4>Search Result <span class="pull-right"><i class="material-icons">search</i></span></h4>
                </div>
                <div class="panel-body" id="search-result" style="overflow-y: scroll;height:500px;">
                    
                  


                    

                </div>
            </div>
        </div>


      <script type="text/javascript">
            $(document).ready(function(){
                $(".user_data").load('<?= site_url("Member_login/user_detail"); ?>').fadeIn();
                  $("#notifications").load('<?= site_url("Member_login/notification"); ?>').fadeIn();
                  $("#count").load('<?= site_url("Member_login/counter"); ?>').fadeIn();

                  $("#searching").keyup(function(){
               $("#searching-panel").fadeIn('fast');

                        $.ajax({
                            url:'<?= site_url("Member_login/search"); ?>',
                            type:'post',
                            data:$("#searchForm").serialize(),
                            success:function(data){
                               //$("#search-result").load('<?= site_url("Member_login/search"); ?>').fadeIn();
                               $("#search-rows").fadeIn();

                               $("#search-result").html(data);

                            }
                        });
                  });
            });
        </script>