<?php 
    $dhchuagiaos = $DonDatHang -> getAllDDHDaGiaoCuaKH($_SESSION['khach_hang_id']);
?>
<div class="container mt-5 mb-5">
    <?php 
        foreach($dhchuagiaos as $dh){
    ?>
     <div class="border rounded p-3 mt-5 shadow">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div>
                    <strong>Mã đơn hàng: <?php echo  $dh['ma_don_hang']?></strong>
                </div>
                <div>
                    <span>Ngày đặt: <?php $ngaydat = date("d-m-Y", strtotime($dh['ngay_dat'])); echo $ngaydat ?></span>
                </div>
                <div>
                    <span class="text-success fw-bold">Giao hàng thành công</span>
                </div>
            </div>
            <?php
                $chitiet = $DonDatHang -> getAllSPinDDH($dh['ma_don_hang']);
                foreach($chitiet as $item){
                 $sanpham = $SanPham -> getById($item['ma_san_pham']);
            ?>
            <div class="d-flex mb-3">
                <div class="me-3">
                    <img src="./images/<?php echo $sanpham['image'] ?>" alt="Ảnh <?php echo $sanpham['ten_san_pham'] ?>" class="img-thumbnail" width="100">
                </div>
                <div class="flex-grow-1">
                    <h5 class="mb-1"><?php echo $sanpham['ten_san_pham'] ?></h5>
                    <p class="mb-0"><?php $item['so_luong'] ?></p>
                </div>
                <div>
                    <p class="fw-bold mb-0"><?php echo number_format($item['thanhtien'], 0, ',', '.') . " đ"; ?></p>
                </div>
            </div>
            <?php
                }
            ?>
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <p class="text-danger mb-0">Thành tiền: <span class="fs-4 fw-bold"><?php echo number_format($dh['tongtien'], 0, ',', '.') . " đ"; ?></span></p>
                </div>
                <div>
                <button class="btn btn-danger btn-sm">Đánh Giá</button>
                <button class="btn btn-outline-primary btn-sm">Mua Lại</button>
                </div>
            </div>
        </div>
    <?php        
        }
    ?>       
</div>