<?
include "admin.lib.php";

$mb_id = $_SESSION["mb_id"];
$token = $_SESSION["token"];
$login = $_SESSION["login"];

$login_check = chk_token($token,$mb_id);

if(!$mb_id || $login != 1 || !$login_check){
  alert("로그인 해 주세요.");
  move_page("./login.php");
}

if($ac_type==1){
  $active_member = "active";
}else if($ac_type==2){
  $active_item = "active";
}else if($ac_type==3){
  $active_rfq = "active";
}else if($ac_type==4){
  $active_quo = "active";
}else if($ac_type==5){
  $active_msg = "active";
}else if($ac_type==6){
  $active_post = "active";
}


?>

<!DOCTYPE html>
<html lang="ko">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>관리자 페이지</title>

    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
    <link href="css/admin.css" rel="stylesheet">

    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
    <script src="js/sb-admin-2.min.js"></script>
    <script src="js/admin.js"></script>
</head>


<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center" href="index.php">관리자 메뉴</a>

            <!-- Divider -->
            <li class="nav-item <?=$active_member?>">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseMembers"
                    aria-expanded="true" aria-controls="collapseUtilities">
                    <i class="fas fa-fw fa-address-card"></i>
                    <span>회원 관리</span>
                </a>
                <div id="collapseMembers" class="collapse" aria-labelledby="headingUtilities"
                    data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <a class="collapse-item" href="">Customer</a>
                        <a class="collapse-item" href="">Supplier</a>
                        <a class="collapse-item" href="">Admin</a>
                    </div>
                </div>
            </li>
            <li class="nav-item <?=$active_item?>">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseItems"
                    aria-expanded="true" aria-controls="collapseUtilities">
                    <i class="fas fa-fw fa-box-open"></i>
                    <span>상품 관리</span>
                </a>
                <div id="collapseItems" class="collapse" aria-labelledby="headingUtilities"
                    data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <a class="collapse-item" href="">주조품</a>
                        <a class="collapse-item" href="">단조품</a>
                        <a class="collapse-item" href="">제관품</a>
                        <a class="collapse-item" href="">조립품</a>
                    </div>
                </div>
            </li>
            <li class="nav-item <?=$active_rfq?>">
                <a class="nav-link" href="">
                    <i class="fas fa-fw fa-file"></i>
                    <span>RFQ 관리</span></a>
            </li>
            <li class="nav-item <?=$active_quo?>">
                <a class="nav-link" href="">
                    <i class="fas fa-fw fa-file-alt"></i>
                    <span>Quotation 관리</span></a>
            </li>
            <li class="nav-item <?=$active_msg?>">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseMsg"
                    aria-expanded="true" aria-controls="collapseUtilities">
                    <i class="fas fa-fw fa-box-open"></i>
                    <span>메세지 관리</span>
                </a>
                <div id="collapseMsg" class="collapse" aria-labelledby="headingUtilities"
                    data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <a class="collapse-item" href="admin_msg.php">메세지 확인 / 답장</a>
                        <a class="collapse-item" href="admin_msg_send.php">메세지 보내기</a>
                    </div>
                </div>
            </li>
            <li class="nav-item <?=$active_post?>">
                <a class="nav-link" href="admin_news.php">
                    <i class="fas fa-fw fa-newspaper"></i>
                    <span>업계소식 관리</span></a>
            </li>

            <hr class="sidebar-divider">


            <!-- Nav Item - Dashboard -->
            <li class="nav-item active">
                <a class="nav-link" href="index.html">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading">
                Interface
            </div>

            <!-- Nav Item - Pages Collapse Menu -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo"
                    aria-expanded="true" aria-controls="collapseTwo">
                    <i class="fas fa-fw fa-cog"></i>
                    <span>Components</span>
                </a>
                <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Custom Components:</h6>
                        <a class="collapse-item" href="buttons.html">Buttons</a>
                        <a class="collapse-item" href="cards.html">Cards</a>
                    </div>
                </div>
            </li>

            <!-- Nav Item - Utilities Collapse Menu -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities"
                    aria-expanded="true" aria-controls="collapseUtilities">
                    <i class="fas fa-fw fa-wrench"></i>
                    <span>Utilities</span>
                </a>
                <div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities"
                    data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Custom Utilities:</h6>
                        <a class="collapse-item" href="utilities-color.html">Colors</a>
                        <a class="collapse-item" href="utilities-border.html">Borders</a>
                        <a class="collapse-item" href="utilities-animation.html">Animations</a>
                        <a class="collapse-item" href="utilities-other.html">Other</a>
                    </div>
                </div>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading">
                Addons
            </div>

            <!-- Nav Item - Pages Collapse Menu -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages"
                    aria-expanded="true" aria-controls="collapsePages">
                    <i class="fas fa-fw fa-folder"></i>
                    <span>Pages</span>
                </a>
                <div id="collapsePages" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Login Screens:</h6>
                        <a class="collapse-item" href="login.php">Login</a>
                        <a class="collapse-item" href="register.html">Register</a>
                        <a class="collapse-item" href="forgot-password.html">Forgot Password</a>
                        <div class="collapse-divider"></div>
                        <h6 class="collapse-header">Other Pages:</h6>
                        <a class="collapse-item" href="404.html">404 Page</a>
                        <a class="collapse-item" href="blank.html">Blank Page</a>
                    </div>
                </div>
            </li>

            <!-- Nav Item - Charts -->
            <li class="nav-item">
                <a class="nav-link" href="charts.html">
                    <i class="fas fa-fw fa-chart-area"></i>
                    <span>Charts</span></a>
            </li>

            <!-- Nav Item - Tables -->
            <li class="nav-item">
                <a class="nav-link" href="tables.html">
                    <i class="fas fa-fw fa-table"></i>
                    <span>Tables</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block">

            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>


        </ul>

        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
                  <ul class="navbar-nav ml-auto">
                    <li class="nav-item dropdown no-arrow">
                        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span class="mr-2 d-none d-lg-inline text-gray-600 large"><?=$mb_id?></span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                            aria-labelledby="userDropdown">
                            <a class="dropdown-item" href="logout.php" data-toggle="modal" data-target="#logoutModal">
                                <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                로그아웃
                            </a>
                        </div>
                    </li>
                  </ul>
                </nav>
