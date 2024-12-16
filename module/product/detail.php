<?php 
    $masanpham = getIndex('masanpham');
    $detailproduct = $SanPham -> getById($masanpham);
    $nameLoai = $LoaiSanPham -> getName($detailproduct['ma_loai']);
?>
<div class="container">
<form action="index.php?mod=product&ac=detail&masanpham=<?php echo $masanpham?>" method="POST">
<div class="row mt-5 mb-5">
            <div class="col-md-6">
                <div class="card">
                    <img src="./images/<?php echo $detailproduct["image"]; ?>" class="card-img-top" alt="Hình sản phẩm">
                </div>
            </div>

            <div class="col-md-6">
                <h1 class="fw-bold">Tên Sản Phẩm: <?php echo $detailproduct["ten_san_pham"]; ?></h1>
                <p class="text-muted">Mã sản phẩm: <?php echo $detailproduct["ma_san_pham"]; ?></p>
                <h2 class="text-danger">Giá: <?php echo number_format($detailproduct['gia'], 0, ',', '.') . " đ";   ?></h2>
                <p class="mt-4">Mô tả: <?php echo $detailproduct["mo_ta"]; ?></p>
                <div class="d-flex align-items-center mt-4">
                    <input type="number" name="soluong" min="1" class="form-control w-25 me-3" value="1">
                    <button type="submit" name="add_to_cart" class="btn btn-primary me-2 <?php echo !isset($_SESSION['khachhang_magiohang']) ? 'disabled' : ''; ?>">Thêm vào giỏ hàng</button>
                </div>
                <div class="mt-4">
                    <p><strong>Danh mục: </strong><?php echo $nameLoai['ten_loai'] ?></p>
                </div>
            </div>
</div>
<input type="hidden" name="masanpham" value="<?php echo $detailproduct['ma_san_pham']; ?>">
<input type="hidden" name="magiohang" value="<?php echo isset($_SESSION['khachhang_magiohang'])?$_SESSION['khachhang_magiohang']:"" ?>">
<input type="hidden" name="gia" value="<?php echo $detailproduct['gia']; ?>">
</form>
</div>
<?php
    if (isset($_POST['add_to_cart']) && isset($_SESSION['khachhang_login']) && $_SESSION['khachhang_login']== true){
        $masp = postIndex('masanpham');
        $magh = postIndex('magiohang');
        $sl = (int)postIndex('soluong');
        $gia = (double) postIndex('gia');
        $thanhtien = $sl * $gia;
        $checkSPinGioHang = $GioHang -> checkSPinGioHang($magh,$masp);
        if($checkSPinGioHang){
            $slcurrent = $GioHang -> getSoluong($magh,$masp);
            $sl += (int) $slcurrent['so_luong'];
            $thanhtien = $sl * $gia;
            $GioHang -> updateGioGang($magh,$masp,$sl,$thanhtien);
        }else{
            $GioHang->addGioHang($magh, $masp, $sl, $thanhtien);
        }
        header("Location:index.php?mod=product&ac=detail&masanpham=".$masp);
        exit();
    }
?>