<?php
if ($_SESSION['khachhang_diachi']==null){
        header("Location:index.php?mod=giohang&ac=home&errorAdress=true");
        exit();
    }
if(isset($_POST['order-cart'])){
    $makh = postIndex('makhachhang');
    $tongtien = postIndex('tongtien');
    $now = new DateTime();
    $ngaydat = $now ->format('Y-m-d');
    $trangthai = 0;
    $dsSPinGH = $GioHang -> getAllGioHang($_SESSION['khachhang_magiohang']);
    $madh = $DonDatHang -> addDDH($makh,$ngaydat,$trangthai,$tongtien);
    foreach ($dsSPinGH as $item) {
        $masp = $item['ma_san_pham'];
        $sl = $item['so_luong'];
        $thanhtien = $item['thanhtien'];
        $DonDatHang->addchitietDDH($madh, $masp, $sl, $thanhtien);
    }
    $GioHang -> deleteAllSPinGioHang($_SESSION['khachhang_magiohang']);
    header("Location:index.php?mod=giohang&ac=home&success=true");
    exit();
}
?>
