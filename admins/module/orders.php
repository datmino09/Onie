<?php
$donDatHang = new DonDatHang();
// Lấy trang hiện tại
$page = getIndex('page', 1);
$pageSize = 5;
$action = getIndex('action');
// Lấy từ khóa tìm kiếm nếu có
$keyword = getIndex('search_keyword');


// Nếu có từ khóa tìm kiếm, tìm kiếm đơn đặt hàng
if ($keyword != '') {
    $orders = $donDatHang->search($keyword);
    $totalPages = $donDatHang->getCountPagesForSearch($keyword, $pageSize);
} else {
    // Nếu không có từ khóa tìm kiếm, lấy đơn đặt hàng theo trang
    $orders = $donDatHang->getAll($page, $pageSize);
    $totalPages = $donDatHang->getCountPages($pageSize);
}

if ($action === 'delete' && getIndex('id')) {
    $id = intval(getIndex('id'));
    $deleted = $donDatHang->deleteDonHang($id);

    if ($deleted) {
        $_SESSION['message'] = ['type' => 'success', 'content' => 'Huỷ đơn hàng thành công!'];
    } else {
        $_SESSION['message'] = ['type' => 'danger', 'content' => 'Huỷ đơn hàng thất bại!'];
    }
    header("Location: index.php?mod=orders&page=" . $page);
    exit;
}
if ($action === 'detail' && getIndex('id') !=="") {
    // Hiển thị chi tiết đơn hàng
    $ma_don_hang = intval(getIndex('id'));
    $orderDetail = $donDatHang->getDetail($ma_don_hang);
?>
<!-- Chi tiết đơn hàng -->
<div class="container py-5">
    <div class="card shadow-lg">
        <div class="card-header text-white text-center">
            <h3>Chi tiết đơn hàng</h3>
            <span class="badge bg-warning text-dark">Mã đơn hàng:
                <?= htmlspecialchars($orderDetail['ma_don_hang']) ?></span>
        </div>
        <div class="card-body">
            <div class="row mb-4">
                <div class="col-md-6">
                    <h5 class="text-pry">Thông tin khách hàng</h5>
                    <p><strong>Tên:</strong> <?= htmlspecialchars($orderDetail['ho_ten']) ?></p>
                    <p><strong>Email:</strong> <?= htmlspecialchars($orderDetail['email']) ?></p>
                    <p><strong>Số điện thoại:</strong> <?= htmlspecialchars($orderDetail['sdt']) ?></p>
                    <p><strong>Địa chỉ:</strong> <?= htmlspecialchars($orderDetail['dia_chi']) ?></p>
                </div>
                <div class="col-md-6">
                    <h5 class="text-pry">Thông tin đơn hàng</h5>
                    <p><strong>Mã đơn hàng:</strong> <?= htmlspecialchars($orderDetail['ma_don_hang']) ?></p>
                    <p><strong>Tổng tiền:</strong>
                        <span class="text-danger fw-bold">
                            <?= number_format($orderDetail['tongtien'], 0, ',', '.') ?> đ
                        </span>
                    </p>
                    <p><strong>Trạng thái:</strong>
                        <?php if ($orderDetail['trang_thai'] == 1): ?>
                        <span class="badge bg-success">Đã giao thành công</span>
                        <?php else: ?>
                        <span class="badge bg-danger">Chưa được giao</span>
                        <?php endif; ?>
                    </p>
                </div>
            </div>

            <h5 class="text-pry">Danh sách sản phẩm</h5>
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead class="bg-light">
                        <tr>
                            <th class="text-center">Mã SP</th>
                            <th>Tên sản phẩm</th>
                            <th>Hình ảnh</th>
                            <th>Loại sản phẩm</th>
                            <th class="text-center">Số lượng</th>
                            <th class="text-end">Thành tiền</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($orderDetail['chi_tiet'] as $product): ?>
                        <tr>
                            <td class="text-center"><?= htmlspecialchars($product['ma_san_pham']) ?></td>
                            <td><?= htmlspecialchars($product['ten_san_pham']) ?></td>
                            <td>
                                <img src="../images/<?= htmlspecialchars($product['image']) ?>"
                                    alt="<?= htmlspecialchars($product['ten_san_pham']) ?>" class="img-thumbnail"
                                    style="width: 90px; height: 70px;">
                            </td>
                            <td><?= htmlspecialchars($product['ten_loai_san_pham']) ?></td>
                            <td class="text-center"><?= htmlspecialchars($product['so_luong']) ?></td>
                            <td class="text-end text-success fw-bold">
                                <?= number_format($product['thanhtien'], 0, ',', '.') ?> đ
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <div class="text-center mt-4">
                <a href="index.php?mod=orders&page=<?= $page ?>" class="btn btn-secondary">
                    <i class="fas fa-arrow-left me-1"></i> Trở lại
                </a>
            </div>
        </div>
    </div>
</div>
<?php
    exit;
}
?>

<div class="container p-4">
    <h3 class="text-center">Quản lý đơn đặt hàng</h3>
    <form method="get" class="mb-3 d-flex align-items-center" action="index.php">
        <input type="hidden" name="mod" value="orders">
        <input type="text" name="search_keyword" class="form-control me-2" style="flex: 1;"
            placeholder="Tìm kiếm đơn đặt hàng" value="<?= htmlspecialchars($keyword) ?>">
        <button type="submit" class="btn btn-primary">Tìm kiếm</button>
    </form>
    <?php
    if (isset($_SESSION['message'])):
        $messageType = $_SESSION['message']['type'];
        $messageContent = $_SESSION['message']['content'];
    ?>
    <div class="alert alert-<?= $messageType ?> alert-dismissible fade show" role="alert">
        <?= $messageContent ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    <?php unset($_SESSION['message']); ?>
    <?php endif; ?>
    <div class="card">
        <div class="card-body">
            <form method="post" action="">
                <table style="width: 100%;" class="table table-bordered table-hover">
                    <thead class="thead-dark">
                        <tr>
                            <th style="width: 80px;">Mã ĐH</th>
                            <th>Tên khách hàng</th>
                            <th>Số điện thoại</th>
                            <th>Địa chỉ</th>
                            <th>Tổng tiền</th>
                            <th>Trạng thái</th>
                            <th>Chi tiết</th>
                            <th>Huỷ</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($orders)): ?>
                        <?php foreach ($orders as $index => $order): ?>
                        <tr>
                            <td><?= $order['ma_don_hang'] ?></td>
                            <td><?= $order['ho_ten'] ?></td>
                            <td><?= $order['sdt'] ?></td>
                            <td><?= $order['dia_chi'] ?></td>
                            <td><?= number_format($order['tongtien'], 0, ',', '.') ?> đ</td>
                            <td>
                                <?php if($order['trang_thai'] ==0 ) echo"Đang giao"; else  echo"Đã giao"; ?>
                            </td>
                            <!-- Hiển thị tổng tiền -->
                            <td>
                                <a href="index.php?mod=orders&page=<?= $page ?>&action=detail&id=<?= $order['ma_don_hang'] ?>"
                                    class="btn btn-sm btn-info btn_detail" style="height: 30px;">
                                    chi tiết
                                </a>
                            </td>
                            <td class="text-center">
                                <?php if($order['trang_thai'] == 0 ){?>
                                <a href="index.php?mod=orders&page=<?= $page ?>&action=delete&id=<?= $order['ma_don_hang'] ?>"
                                    class="btn btn-sm text-danger btn_delete" style="font-size: 24px; line-height: 1;">
                                    &times;
                                </a>
                                <?php }?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                        <?php else: ?>
                        <tr>
                            <td colspan="7" class="text-center">Không có đơn đặt hàng nào.</td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </form>
        </div>
    </div>

    <!-- Phân trang -->
    <nav class="d-flex justify-content-center mt-3">
        <ul class="pagination">
            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
            <li class="page-item <?= $i == $page ? 'active' : '' ?>">
                <a class="page-link" href="?mod=orders&page=<?= $i ?>"><?= $i ?></a>
            </li>
            <?php endfor; ?>
        </ul>
    </nav>
</div>