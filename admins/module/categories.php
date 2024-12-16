<?php

$loaiSanPham = new LoaiSanPham();

// Lấy trang hiện tại
$page = getIndex('page', 1); 
$pageSize = 5; 

// Lấy từ khóa tìm kiếm nếu có
$keyword = getIndex('search_keyword');

// Nếu có từ khóa tìm kiếm, tìm kiếm sản phẩm
if ($keyword != '') {
    $products = $loaiSanPham->search($keyword,$page,$pageSize);
    $totalPages=$loaiSanPham->getSearchPageCount($keyword, $pageSize);
} else {
    // Nếu không có từ khóa tìm kiếm, lấy sản phẩm theo trang
    $products = $loaiSanPham->getByPage($page, $pageSize);
    $totalPages = $loaiSanPham->getTotalPages($pageSize);

}

// Tính tổng số trang

// Xử lý xóa loại sản phẩm
if (getIndex('action') === 'delete' && getIndex('id')) {
    $id = intval(getIndex('id'));

    if ($loaiSanPham->hasProducts($id)) {
        $_SESSION['message'] = ['type' => 'danger', 'content' => 'Không thể xoá loại sản phẩm này vì có sản phẩm thuộc loại này!'];
        header("Location: index.php?mod=categories&page=" . $page);
        exit;
    }
    $deletedCount = $loaiSanPham->deleteByIds([$id]);

    if ($deletedCount > 0) {
        $_SESSION['message'] = ['type' => 'success', 'content' => 'Đã xoá thành công loại sản phẩm!'];
    } else {
        $_SESSION['message'] = ['type' => 'danger', 'content' => 'Xoá thất bại!'];
    }
    header("Location: index.php?mod=categories&page=" . $page);
    exit;
}

// Xử lý xóa các mục đã chọn
if (isset($_POST['delete_selected'])) {
    if (!empty($_POST['selected_ids'])) {
        $selectedIds = $_POST['selected_ids'];
        $invalidItems = []; // Lưu thông tin các loại không thể xóa (tên và ID)
        $validIds = []; // Lưu các ID hợp lệ để xóa

        foreach ($selectedIds as $id) {
            if ($loaiSanPham->hasProducts($id)) {
                // Lấy tên loại sản phẩm không thể xóa
                $item = $loaiSanPham->getById($id);
                $invalidItems[] = $item['ten_loai']; // Chỉ cần tên loại sản phẩm
            } else {
                $validIds[] = $id;
            }
        }

        // Xóa các loại hợp lệ
        if (!empty($validIds)) {
            $deletedCount = $loaiSanPham->deleteByIds($validIds);
        } else {
            $deletedCount = 0;
        }

        // Xử lý thông báo
        if (!empty($invalidItems)) {
            $invalidItemList = implode(', ', $invalidItems);
            $_SESSION['message'] = [
                'type' => 'danger',
                'content' => "Không thể xóa các loại sản phẩm: $invalidItemList vì có sản phẩm thuộc loại này!"
            ];
        }

        if ($deletedCount > 0) {
            $_SESSION['message'] = [
                'type' => 'success',
                'content' => 'Xoá loại sản phẩm thành công!'
            ];
        } elseif (empty($invalidItems)) {
            $_SESSION['message'] = [
                'type' => 'danger',
                'content' => 'Không thể xóa các loại sản phẩm được chọn!'
            ];
        }

        // Chuyển hướng sau khi xử lý
        header("Location: index.php?mod=categories&page=" . $page);
        exit;
    } else {
        $_SESSION['message'] = [
            'type' => 'warning',
            'content' => 'Không có mục nào được chọn!'
        ];
    }
}

// Thêm loại sản phẩm
if (isset($_POST['add_category'])) {
    $tenLoai = postIndex('ten_loai');

    if ($tenLoai != "") {
        $added = $loaiSanPham->save($tenLoai);
        
        if ($added) {
            $_SESSION['message'] = ['type' => 'success', 'content' => 'Thêm loại sản phẩm thành công!'];
        } else {
            $_SESSION['message'] = ['type' => 'danger', 'content' => 'Thêm loại sản phẩm thất bại. Vui lòng thử lại.'];
        }

        header("Location: index.php?mod=categories&page=" . $page);
        exit;
    } else {
        $_SESSION['message'] = ['type' => 'danger', 'content' => 'Tên loại sản phẩm không được để trống!'];
    }
}

// Cập nhật loại sản phẩm
if (isset($_POST['update_category'])) {
    $maLoai = postIndex('ma_loai');
    $tenLoai = postIndex('ten_loai');

    if ($maLoai != "") {
        $updated = $loaiSanPham->updateById($maLoai, $tenLoai);

        if ($updated) {
            $_SESSION['message'] = ['type' => 'success', 'content' => 'Cập nhật loại sản phẩm thành công!'];
        } else {
            $_SESSION['message'] = ['type' => 'danger', 'content' => "Cập nhật loại sản phẩm $maLoai thất bại. Vui lòng thử lại."];
        }

        header("Location: index.php?mod=categories&page=" . $page);
        exit;
    } else {
        $_SESSION['message'] = ['type' => 'danger', 'content' => 'Tên loại sản phẩm không được để trống!'];
    }
}

// Chỉnh sửa loại sản phẩm
if (getIndex('action') === 'edit' && getIndex('id')) {
    $id = intval(getIndex('id'));
    $product = $loaiSanPham->getById($id);

    if (!$product) {
        $_SESSION['message'] = ['type' => 'danger', 'content' => 'Loại sản phẩm không tồn tại!'];
        header("Location: index.php?mod=categories&page=" . $page);
        exit;
    } else {
        ?>
<div class="container p-4">
    <h3 class="text-center">Chỉnh sửa loại sản phẩm</h3>
    <form class="form" action="" method="post">
        <label for="ma_loai" class="form-label">Mã loại</label>
        <input type="text" class="form-control" name="ma_loai" value="<?= $product['ma_loai'] ?>" readonly>
        <div class="mb-3">
            <label for="ten_loai" class="form-label">Tên loại sản phẩm</label>
            <input type="text" class="form-control" id="ten_loai" name="ten_loai" value="<?= $product['ten_loai']?>"
                required>
        </div>
        <button type="submit" class="btn btn-primary" name="update_category">Cập nhật</button>
        <a href="index.php?mod=categories&page=<?= $page ?>" class="btn btn-secondary">Hủy</a>
    </form>
</div>
<?php 
        exit;       
    }
}
?>

<div class="container p-4">
    <h3 class="text-center">Quản lý loại sản phẩm</h3>
    <form method="get" class="mb-3 d-flex align-items-center" action="index.php">
        <input type="hidden" name="mod" value="categories"> <!-- Thêm tham số mod=categories -->
        <input type="text" name="search_keyword" class="form-control me-2" style="flex: 1;"
            placeholder="Tìm kiếm loại sản phẩm" value="<?= htmlspecialchars($keyword) ?>">
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

    <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addCategoryModal">
        Thêm loại sản phẩm
    </button>

    <div class="card">
        <div class="card-body">
            <form method="post" action="">
                <table class="table table-bordered table-hover">
                    <thead class="thead-dark">
                        <tr>
                            <th style="width: 50px;"> </th>
                            <th style="width: 80px;">Mã loại</th>
                            <th>Tên loại sản phẩm</th>
                            <th>Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($products)): ?>
                        <?php foreach ($products as $index => $product): ?>
                        <tr>
                            <td>
                                <input type="checkbox" name="selected_ids[]" value="<?= $product['ma_loai'] ?>">
                            </td>
                            <td><?= $product['ma_loai'] ?></td>
                            <td><?=$product['ten_loai']?></td>
                            <td>
                                <a href="index.php?mod=categories&page=<?= $page ?>&action=edit&id=<?= $product['ma_loai'] ?>"
                                    class="btn btn-sm btn-warning">
                                    <i class="fa fa-edit"></i> Sửa
                                </a>
                                <a href="index.php?mod=categories&page=<?= $page ?>&action=delete&id=<?= $product['ma_loai'] ?>"
                                    class="btn btn-sm btn-danger">
                                    <i class="fa fa-trash"></i> Xoá
                                </a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                        <?php else: ?>
                        <tr>
                            <td colspan="4" class="text-center">Không có loại sản phẩm nào.</td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
                <button type="submit" class="btn btn-danger" name="delete_selected">Xóa đã chọn</button>
            </form>
        </div>
    </div>

    <!-- Phân trang -->
    <nav class="d-flex justify-content-center mt-3">
        <ul class="pagination">
            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
            <li class="page-item <?= $i == $page ? 'active' : '' ?>">
                <a class="page-link" href="?mod=categories&page=<?= $i ?>"><?= $i ?></a>
            </li>
            <?php endfor; ?>
        </ul>
    </nav>
</div>
<!-- Modal thêm loại sản phẩm -->
<div class="modal fade" id="addCategoryModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="post" action="">
                <div class="modal-header">
                    <h5 class="modal-title">Thêm loại sản phẩm</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <label for="ten_loai">Tên loại sản phẩm</label>
                    <input type="text" class="form-control" id="ten_loai" name="ten_loai" required>
                </div>
                <div class="modal-footer">
                    <button type="submit" name="add_category" class="btn btn-primary">Thêm</button>
                </div>
            </form>
        </div>
    </div>
</div>