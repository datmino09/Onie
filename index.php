<?php 
include "config/config.php";
include ROOT."/include/function.php";
spl_autoload_register("loadClass");
ob_start();
if (!isset($_SESSION)) session_start();
$db = new Db();
$LoaiSanPham = new LoaiSanPham();
$SanPham = new SanPham();
$KhachHang = new KhachHang();
$GioHang = new GioHang();
$DonDatHang = new DonDatHang();
$error = false;
$errorLenght = false;
$errorEmail = false;
$errorSDT = false;
if (isset($_POST['login'])) {
  $email = postIndex('email');
  $password = md5(postIndex('password'));
  $khachhang = $KhachHang->checkLogin($email, $password);
 
  if ($khachhang) {
      $_SESSION['khachhang_login'] = true;
      $_SESSION['khach_hang_id'] = $khachhang['ma_khach_hang'];
      $_SESSION['khachhang_name'] = $khachhang['ho_ten'];
      $_SESSION['khachhang_email'] = $khachhang['email'];
      $_SESSION['khachhang_sdt'] = $khachhang['sdt'];
      $_SESSION['khachhang_diachi'] = $khachhang['dia_chi'];
      $giohang = $GioHang -> getMaGioHang($_SESSION['khach_hang_id']);
      $_SESSION['khachhang_magiohang'] = $giohang['ma_gio_hang'];
      header("Location:index.php");
      exit();
  } else {
      $error = true;
  }
}

    if(isset($_POST['register'])){
        $ho_ten = postIndex('name');
        $email = postIndex('email');
        $password = postIndex('password');
        $sdt = postIndex('phone');
        $checkEmail = $KhachHang->checkIssetEmail($email);
        $checkSDT = $KhachHang ->checkIssetSDT($sdt);  
        if(strlen($ho_ten)<8 || strlen($password)<8){
            $errorLenght = true;
        }
        else if($checkEmail){
            $errorEmail = true;
        }else if($checkSDT){
            $errorSDT =true;
        }
        else {
            $password = md5($password);
            $userRegister = $KhachHang -> registerUser($ho_ten,$email,$sdt,$password);
            $userGioHang = $GioHang -> create($userRegister);
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link
    rel="shortcut icon"
    href="https://pngimg.com/uploads/heart/heart_PNG51183.png"
    type="image/x-icon" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="./CSS/Style.css">
    <link rel="stylesheet" href="./CSS/responsive.css">
    <title>Onie</title>
</head>
<body>
    <header class="header">
        <?php  include "./include/header.php" ?>
    </header>
    <?php 
      include "mod.php";
    ?>
    <footer id="footer">
        <?php include "./include/footer.php" ?>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="./js/main.js"></script>
</body>
</html>
<!-- Modal hiển thị thông báo lỗi đăng nhập-->
<div class="modal fade" id="errorModal" tabindex="-1" aria-labelledby="errorModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="errorModalLabel">Thông báo</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Đăng nhập thất bại, vui lòng kiểm tra email và mật khẩu!</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
            </div>
        </div>
    </div>
</div>
<script>
    <?php if ($error){?>
        document.addEventListener("DOMContentLoaded", function() {
            let errorModal = new bootstrap.Modal(document.getElementById('errorModal'), {});
            errorModal.show();
        });
    <?php } ?>
</script>
<!-- Modal hiển thị thông báo lỗi đăng ký khi độ dài họ và tên, mật khẩu k đủ-->

<div class="modal fade" id="errorLengthModal" tabindex="-1" aria-labelledby="errorLengthModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="errorLengthModalLabel">Lỗi đăng ký</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        Độ dài họ và tên hoặc mật khẩu phải từ 8 ký tự trở lên. Vui lòng kiểm tra lại!
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
      </div>
    </div>
  </div>
</div>

<script>
   <?php if ($errorLenght){?>
        document.addEventListener("DOMContentLoaded", function() {
            let errorLengthModal = new bootstrap.Modal(document.getElementById('errorLengthModal'), {});
            errorLengthModal.show();
            });
    <?php } ?>
</script>

<!-- Modal hiển thị thông báo lỗi đăng ký khi trùng email-->

<div class="modal fade" id="errorEmailExistsModal" tabindex="-1" aria-labelledby="errorEmailExistsModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="errorEmailExistsModalLabel">Lỗi đăng ký</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        Email đã tồn tại trong hệ thống. Vui lòng sử dụng email khác!
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
      </div>
    </div>
  </div>
</div>
<script>
    <?php if ($errorEmail){?>
        document.addEventListener("DOMContentLoaded", function() {
            let errorEmailExistsModal = new bootstrap.Modal(document.getElementById('errorEmailExistsModal'), {});
            errorEmailExistsModal.show();
            });
    <?php } ?>
</script>
<!-- Modal hiển thị thông báo lỗi đăng ký khi trùng sdt-->

<div class="modal fade" id="errorSDTExistsModal" tabindex="-1" aria-labelledby="errorSDTExistsModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="errorSDTExistsModalLabel">Lỗi đăng ký</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        Số điện thoại đã tồn tại trong hệ thống. Vui lòng sử dụng số điện thoại khác!
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
      </div>
    </div>
  </div>
</div>
<script>
    <?php if ($errorSDT){?>
        document.addEventListener("DOMContentLoaded", function() {
            let errorSDTExistsModal = new bootstrap.Modal(document.getElementById('errorSDTExistsModal'), {});
            errorSDTExistsModal.show();
            });
    <?php } ?>
</script>
 <!-- Modal hiển thị đăng ký thành công -->

 <div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
     <div class="modal-dialog"> <div class="modal-content"> <div class="modal-header bg-success text-white">
         <h5 class="modal-title" id="successModalLabel">Thông báo</h5> 
         <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> 
    </div> 
    <div class="modal-body"> 
        <p>Đăng ký thành công! Chào mừng bạn đã trở thành thành viên của chúng tôi. Mời bạn đăng nhập !!!!</p>
     </div> 
     <div class="modal-footer"> 
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button> 
    </div> 
    </div> 
</div>
<script>
    <?php if ($userRegister>0){?>
        document.addEventListener("DOMContentLoaded", function() {
            let successRegisterModal = new bootstrap.Modal(document.getElementById('successModal'), {});
            successRegisterModal.show();
        });
    <?php } ?>
</script>

