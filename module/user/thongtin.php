<div class="container mt-5 mb-5">
        <div class="card">
            <div class="card-header text-white" style="background-color: var(--primary-color);">
                <h4>Thông Tin Cá Nhân</h4>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-4">
                        <strong>Họ và Tên:</strong>
                    </div>
                    <div class="col-md-8">
                        <?php echo $_SESSION['khachhang_name']; ?>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4">
                        <strong>Email:</strong>
                    </div>
                    <div class="col-md-8">
                        <?php echo $_SESSION['khachhang_email']; ?>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4">
                        <strong>Số Điện Thoại:</strong>
                    </div>
                    <div class="col-md-8">
                        <?php echo $_SESSION['khachhang_sdt']; ?>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4">
                        <strong>Địa chỉ:</strong>
                    </div>
                    <div class="col-md-8">
                        <?php 
                        echo !empty($_SESSION['khachhang_diachi']) 
                            ? $_SESSION['khachhang_diachi']
                            : "Chưa cập nhật"; 
                        ?>
                    </div>

                </div>
            </div>
            <div class="card-footer text-end">
                <a href="index.php?mod=user&ac=edit" class="btn btn-warning">Chỉnh Sửa</a>
                <a href="index.php?mod=user&ac=logout" class="btn btn-danger">Đăng Xuất</a>
            </div>
        </div>
    </div>