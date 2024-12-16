<div class="container mt-5 mb-5">
    <h2>Chỉnh sửa thông tin</h2>
    <form action="index.php?mod=user&ac=edit" method="POST">
        <div class="mb-3">
            <label for="fullname" class="form-label">Họ và tên</label>
            <input type="text" class="form-control" id="fullname" name="fullname" placeholder="Nhập họ và tên" value="<?php echo $_SESSION['khachhang_name']; ?>" required>
        </div>
        
        <div class="mb-3">
            <label for="phone" class="form-label">Số điện thoại</label>
            <input type="text" class="form-control" id="phone" name="phone" placeholder="Nhập số điện thoại" value="<?php echo $_SESSION['khachhang_sdt']; ?>" required>
        </div>

        <div class="mb-3">
            <label for="address" class="form-label">Địa chỉ</label>
            <textarea class="form-control" id="address" name="address" rows="3" placeholder="Nhập địa chỉ"><?php echo isset($_SESSION['khachhang_diachi'])?$_SESSION['khachhang_diachi']:''; ?></textarea>
        </div>

        <button type="submit" name="update-to-user" class="btn btn-primary">Cập nhật thông tin</button>
        <a href="index.php" class="btn btn-danger">Hủy</a>
    </form>
</div>
<?php
    if(isset($_POST['update-to-user'])){
        $hoten = postIndex('fullname');
        $sdt = postIndex("phone");
        $diachi = postIndex('address');
        $KhachHang -> updateUser($_SESSION['khach_hang_id'],$hoten,$sdt,$diachi);
        $newKhachHang = $KhachHang -> getById($_SESSION['khach_hang_id']);
        if($newKhachHang) {
            $_SESSION['khachhang_name'] = $newKhachHang['ho_ten'];
            $_SESSION['khachhang_sdt'] = $newKhachHang['sdt'];
            $_SESSION['khachhang_diachi'] = $newKhachHang['dia_chi'];
            header('Location:index.php?mod=user&ac=thongtin');
            exit();
        }
    }
?>
