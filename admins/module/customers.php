<?php

$khachHang = new KhachHang();

$page = getIndex('page', 1); 
$pageSize = 5; 

$keyword = getIndex('search_keyword');
if ($keyword != '') {
    $customers = $khachHang->searchCustomer($keyword,$page, $pageSize); 
    $totalPages = $khachHang->getSearchPageCount($keyword,$pageSize);
    echo"<h3>$totalPages</h3>";
} else {
    // Lấy danh sách khách hàng theo trang
    $customers = $khachHang->getAll($page, $pageSize);
    $totalPages = $khachHang->getCountPage($pageSize); 
    ;
}
?>
<div class="container p-4">
    <h3 class="text-center">Danh sách khách hàng</h3>

    <!-- Thanh tìm kiếm -->
    <form method="get" class="mb-3 d-flex align-items-center" action="index.php">
        <input type="hidden" name="mod" value="customers">
        <input type="text" name="search_keyword" class="form-control me-2" style="flex: 1;"
            placeholder="Tìm kiếm khách hàng" value="<?= htmlspecialchars($keyword) ?>">
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
            <table class="table table-bordered table-hover">
                <thead class="thead-dark">
                    <tr>
                        <th>STT</th>
                        <th>Tên khách hàng</th>
                        <th>Email</th>
                        <th>Số điện thoại</th>
                        <th>Địa chỉ</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($customers)): ?>
                    <?php foreach ($customers as $index => $customer): ?>
                    <tr>
                        <td><?= $index + 1 + ($page - 1) * $pageSize ?></td>
                        <td><?= $customer['ho_ten'] ?></td>
                        <td><?= $customer['email'] ?></td>
                        <td><?= $customer['sdt'] ?></td>
                        <td><?= $customer['dia_chi'] ?></td>
                    </tr>
                    <?php endforeach; ?>
                    <?php else: ?>
                    <tr>
                        <td colspan="5" class="text-center">Không có khách hàng nào.</td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Phân trang -->
    <nav class="d-flex justify-content-center mt-3">
        <ul class="pagination">
            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
            <li class="page-item <?= $i == $page ? 'active' : '' ?>">
                <a class="page-link" href="?mod=customers&page=<?= $i ?>"><?= $i ?></a>
            </li>
            <?php endfor; ?>
        </ul>
    </nav>
</div>