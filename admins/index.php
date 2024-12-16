<?php

include_once "../config/config.php";
include_once ROOT."/include/function.php";
include_once ROOT . "/admins/classes/Db.class.php";
include_once ROOT ."/admins/classes/SanPham.class.php";
include_once ROOT ."/admins/classes/LoaiSanPham.class.php";
include_once ROOT ."/admins/classes/KhachHang.class.php";
include_once ROOT ."/admins/classes/DonDatHang.class.php";

if (!isset($_SESSION)) session_start();
if (!isset($_SESSION["admin_logged_in"]))
{
	header('Location: ./login.php'); 
    exit();
}

$mod = getIndex('mod');
if($mod == ''){
    $mod = 'dashboard';
}

if ($mod === 'logout') {
    // Xóa session và chuyển hướng về trang đăng nhập
    session_unset();
    session_destroy();
    header('Location: login.php');
    exit();
}

// Xác định đường dẫn module
$modules_path = 'module/' . $mod . '.php';

// Kiểm tra module tồn tại
if (!file_exists($modules_path)) {
    $modules_path = 'module/404.php'; 
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css">
    <link rel="stylesheet" href="./resources/css/style.css">
</head>

<body>
    <div class="toggle-sidebar" onclick="toggleSidebar()">☰</div>

    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-2 bg-dark text-white vh-100">
                <h3 class="text-center py-3">Admin</h3>
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a href="index.php?mod=dashboard"
                            class="nav-link <?= $mod === 'dashboard' ? 'active' : '' ?>">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a href="index.php?mod=products"
                            class="nav-link <?= $mod === 'products' ? 'active' : '' ?>">Quản lý sản phẩm</a>
                    </li>
                    <li class="nav-item">
                        <a href="index.php?mod=orders" class="nav-link <?= $mod === 'orders' ? 'active' : '' ?>">Quản lý
                            đơn hàng</a>
                    </li>
                    <li class="nav-item">
                        <a href="index.php?mod=customers"
                            class="nav-link <?= $mod === 'customers' ? 'active' : '' ?>">Quản lý khách hàng</a>
                    </li>
                    <li class="nav-item">
                        <a href="index.php?mod=categories"
                            class="nav-link <?= $mod === 'categories' ? 'active' : '' ?>">Quản lý loại sản phẩm</a>
                    </li>
                    <li class="nav-item">
                        <a href="index.php?mod=logout" class="nav-link <?= $mod === 'logout' ? 'active' : '' ?>">Đăng
                            xuất</a>
                    </li>
                </ul>
            </div>
            <!-- Content -->
            <div class="content">
                <!-- Hiển thị nội dung -->
                <div class="p-2">
                    <h1>Welcome <?php echo"{$_SESSION['admin_username']}";?></h1>
                </div>
                <div class="content-body">
                    <?php if ($mod === 'dashboard') { ?>
                    <div class="p-2">
                        <p>Đây là trang quản lý chính dành cho quảng trị viên. Chọn một mục từ thanh bên trái để bắt đầu
                            quản lý.</p>
                    </div>
                    <?php } else {
                    include $modules_path;
                } ?>
                </div>
            </div>
        </div>
    </div>
    <script>
    function toggleSidebar() {
        document.querySelector('.bg-dark').classList.toggle('active');
    }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/js/script.js"></script>
</body>

</html>