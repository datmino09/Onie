<?php 
    $dssp = $GioHang -> getAllGioHang($_SESSION['khachhang_magiohang']);
    $total = 0;
    $stt =1;
    $errorAdress = isset($_GET['errorAdress'])?$_GET['errorAdress']:false;
    $successOrder = isset($_GET['success'])?$_GET['success']:false;
?>
<div class="container my-5">
        <h1 class="text-center mb-4">Chi Tiết Giỏ Hàng</h1>
        <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th>STT</th>
                    <th>Ảnh Sản Phẩm</th>
                    <th>Sản Phẩm</th>
                    <th>Giá</th>
                    <th>Số Lượng</th>
                    <th>Thành Tiền</th>
                    <th>Hành Động</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($dssp as $item) {
                    $sp = $SanPham -> getById($item['ma_san_pham']);   
                ?>
                <tr>
                    <td><?php echo $stt; $stt++;?></td>
                    <td><img src="./images/<?php echo $sp['image'] ?>" alt="Ảnh <?php echo $sp['ten_san_pham'] ?>" class="img-fluid" style="width: 70px; height: 70px;"></td>
                    <td><?php echo $sp['ten_san_pham']?></td>
                    <td><?php echo number_format($sp['gia'], 0, ',', '.') . " đ";?></td>
                    <td>
                        <input type="number" name="soluong" class="form-control" value="<?php echo $item['so_luong']?>" min="1" style="width: 70px;" disabled>
                    </td>
                    <td>
                        <?php 
                            echo number_format($item['thanhtien'], 0, ',', '.') . " đ";
                            $total = $total + $item['thanhtien'];
                        ?>
                    </td>
                    <td>
                        <form action="index.php?mod=giohang&ac=home" method="POST">
                            <input type="hidden" name="masanpham" value="<?php echo $item['ma_san_pham']; ?>">
                            <input type="hidden" name="magiohang" value="<?php echo  $_SESSION['khachhang_magiohang'];?>">
                            <button name="delete_to_cart" class="btn btn-danger btn-sm">Xóa</button>
                        </form>
                    </td>
                </tr>
                <?php
                }
                ?>
            </tbody>
        </table>
        <div class="d-flex justify-content-between mt-4">
            <h4>Tổng cộng: <span class="text-danger"><?php echo number_format($total, 0, ',', '.') . " đ"; ?></span></h4>
            <form action="index.php?mod=dondathang&ac=xuly" method="POST">
                <input type="hidden" name="makhachhang" value="<?php echo  $_SESSION['khach_hang_id']?>">
                <input type="hidden" name="tongtien" value="<?php echo  $total ?>">
                <button type="submit" name="order-cart" class="btn btn-success">Đặt hàng</button>
            </form>
        </div>
        <!-- Đơn đặt hàng -->
        <div class="mt-4">
        <h5 class="mb-3">Thông Tin Đơn Hàng</h5>
        <div class="d-flex justify-content-start gap-3">
            <?php 
            $orderCount = $DonDatHang->countOrder($_SESSION['khach_hang_id']);
            if($orderCount['tongdon']>0){
            ?>
            <!-- Nút Đơn Đang Giao -->
            <a href="index.php?mod=dondathang&ac=donhangchuagiao">
            <button class="btn btn-info d-flex align-items-center gap-2 position-relative" data-bs-toggle="modal" data-bs-target="#modalOrdersShipping">
                <i class="fa-solid fa-truck"></i>
                Đơn Đang Giao
                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                    <?php 
                        echo $orderCount['tongdon']; 
                    ?>
                </span>
            </button>
            </a>
            <?php 
            }else{
            ?>
            <a href="index.php?mod=dondathang&ac=donrong">
            <button class="btn btn-info d-flex align-items-center gap-2 position-relative" data-bs-toggle="modal" data-bs-target="#modalOrdersShipping">
                <i class="fa-solid fa-truck"></i>
                Đơn Đang Giao
                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                    <?php 
                        echo $orderCount['tongdon']; 
                    ?>
                </span>
            </button>
            </a>
            <?php 
            }
            $orderedCount = $DonDatHang->countOrdered($_SESSION['khach_hang_id']);
            if($orderedCount['tongdon'] > 0){
            ?>
             <!-- Nút Đơn Đã Giao -->
                <a href="index.php?mod=dondathang&ac=donhangdagiao">
            <button class="btn btn-info d-flex align-items-center gap-2 position-relative" data-bs-toggle="modal" data-bs-target="#modalOrdersShipping">
                <i class="fa-solid fa-truck"></i>
                Đơn Đã Giao
                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                    <?php 
                       
                        echo $orderedCount['tongdon']; 
                    ?>
                </span>
            </button>
            </a>
            <?php }
            else{
            ?>
            <a href="index.php?mod=dondathang&ac=donrong">
            <button class="btn btn-info d-flex align-items-center gap-2 position-relative" data-bs-toggle="modal" data-bs-target="#modalOrdersShipping">
                <i class="fa-solid fa-truck"></i>
                Đơn Đã Giao
                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                    <?php              
                        echo $orderedCount['tongdon']; 
                    ?>
                </span>
            </button>
            </a>
            <?php
            }
            ?>
            
        </div>
    </div>
    </div>
    <?php 
        if(isset($_POST['delete_to_cart'])){
            $masp = postIndex('masanpham');
            $magh = postIndex('magiohang');
            $GioHang -> deleteSPinGioHang($magh,$masp);
            header("Location:index.php?mod=giohang&ac=home");
            exit();
        }
    ?>
<!-- Hiển thị lỗi chưa có địa chỉ -->
<script>
    <?php if ($errorAdress){?>
        document.addEventListener("DOMContentLoaded", function() {
            let errorModal = new bootstrap.Modal(document.getElementById('errorModalAdress'), {});
            errorModal.show();
        });
    <?php } ?>
</script>
<div class="modal fade" id="errorModalAdress" tabindex="-1" aria-labelledby="errorModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="errorModalLabel">Thông báo</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Bạn chưa cập nhật địa chỉ, vui lòng cập nhật địa chỉ để đặt hàng!!!!!!</p>
            </div>
            <div class="modal-footer">
                <a href="index.php?mod=user&ac=thongtin">
                    <button  class="btn btn-secondary">Cập nhật</button>
                </a>
                 <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
            </div>
        </div>
    </div>
</div>
<!-- Hiển thị đặt hàng thành công -->
<div class="modal fade" id="successModalOrder" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
     <div class="modal-dialog"> <div class="modal-content"> <div class="modal-header bg-success text-white">
         <h5 class="modal-title" id="successModalLabel">Thông báo</h5> 
         <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> 
    </div> 
    <div class="modal-body"> 
        <p>Đặt hàng thành công !!!!!!!</p>
     </div> 
     <div class="modal-footer"> 
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button> 
    </div> 
    </div> 
</div>
<script>
    <?php if ($successOrder){?>
        document.addEventListener("DOMContentLoaded", function() {
            let successRegisterModal = new bootstrap.Modal(document.getElementById('successModalOrder'), {});
            successRegisterModal.show();
        });
    <?php } ?>
</script>