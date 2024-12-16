<div class=" wide">
            <div class="container navbar-top hiden_tablet_mobile">
                <ul class="navbar-top__list">
                    <li class="has-hover pointer navbar-top__list-item about-item">
                        <a href="./index.php?mod=about&ac=home" class="item-content">
                            <i class="fa-solid fa-address-card"></i> 
                            Về Onie
                        </a>    
                    </li>
                    <li class="has-hover pointer navbar-top__list-item">
                        <div class="item-content">
                            <i class="navbar__list-icon fa-regular fa-bell"></i>  
                            Thông báo
                        </div>
                        <div class=" navbar__notify apper">
                            <header class="navbar__notify-header">
                                Thông báo mới nhận
                            </header>
                            <ul class="navbar__notify-list">
                                <li class="navbar__notify-item">
                                    <a href="" class="navbar__notify-link">
                                        <img src="https://pos.nvncdn.com/cba2a3-7534/ps/20240502_6LxRfHUCpE.jpeg" alt="" class="navbar__notify-img">
                                        <div class="navbar__notify-info">
                                            <span class="navbar__notify-name">Móc khóa nhồi bông Funny vibes little</span>
                                            <span class="navbar__notify-description">little boy runny nose tóc Vàng</span>
                                        </div>
                                    </a>
                                </li>
                                <li class="navbar__notify-item">
                                    <a href="" class="navbar__notify-link">
                                        <img src="https://pos.nvncdn.com/cba2a3-7534/ps/20240504_X3aTLqZ5cV.jpeg" alt="" class="navbar__notify-img">
                                        <div class="navbar__notify-info">
                                            <span class="navbar__notify-name">Buộc tóc MJ Hải ly Loopy</span>
                                            <span class="navbar__notify-description">Hải ly Loopy má hồng khối tròn - Mix</span>
                                        </div>
                                    </a>
                                </li>
                                <li class="navbar__notify-item">
                                    <a href="" class="navbar__notify-link">
                                        <img src="https://pos.nvncdn.com/cba2a3-7534/ps/20240428_eJeME1MRCF.jpeg" alt="" class="navbar__notify-img">
                                        <div class="navbar__notify-info">
                                            <span class="navbar__notify-name">Đồ chơi xếp hình Sanrio family Kuromi</span>
                                            <span class="navbar__notify-description">Sanrio family Kuromi hình trứng 3x4x6 - Mix</span>
                                        </div>
                                    </a>
                                </li>
                            </ul>
                            <div class="navbar__notify-footer">
                                <a href="" class="navbar__notify-footer-btn">Xem tất cả</a>
                            </div>
                    </li>
                    <li class="navbar-top__list-item">
                        <a href="" class="navbar__list-item-link">
                            <i class="navbar__list-icon fa-regular fa-circle-question"></i>
                            Hỗ trợ
                        </a>
                    </li>
                    <li class="has-hover navbar-top__list-item">
                        <div class="item-content">
                            <i class="navbar__list-icon fa-solid fa-globe"></i>
                            Tiếng việt
                            <i class="navbar__list-icon fa-solid fa-chevron-down"></i>
                        </div>
                        <div class="navbar__language apper">
                            <p class="navbar__language-vn navbar__language--pointer">Tiếng Việt</p>
                            <p class="navbar__language-en navbar__language--pointer">English</p>
                        </div>
                    </li>
                        <?php
                         if(isset($_SESSION['khachhang_login']) && $_SESSION['khachhang_login']){
                        ?>
                            <li class="navbar-top__list-item user-info dropdown">
                                <a href="#" class="navbar__list-item-link dropdown-toggle" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                    <?php echo htmlspecialchars($_SESSION['khachhang_email']); ?>
                                </a>
                                <ul class="dropdown-menu" aria-labelledby="userDropdown">
                                    <li><a class="dropdown-item" href="index.php?mod=user&ac=thongtin">Thông tin cá nhân</a></li>
                                    <li><a class="dropdown-item" href="index.php?mod=user&ac=logout">Đăng xuất</a></li>
                                </ul>
                            </li>
                        <?php
                        }else {
                         ?>
                         <li class="navbar-top__list-item user-btn">
                            <a href="#" class="navbar__list-item-link">Đăng nhập</a>
                        </li>
                         <?php 
                            }
                         ?>
                </ul>
            </div>
    
            <!-- header with search -->
            <div class="header-search-wrap">
                <div class="container header-with-search">
                    <div class="header__logo">
                        <i class="fa-solid fa-bars bars-btn"></i>
                        <a href="index.php ">
                            <img src="./images/Logo.png" alt="" class="header__logo-img">
                        </a>
                        <i class="fa-regular fa-user user-btn"></i>
                    </div>
                    <div class="header-with-search__section">
                    <form id="searchForm" action="index.php" method="GET">
                    <input type="hidden" name="mod" value="product">
                    <input type="hidden" name="ac" value="home">
                        <div class="header__search">
                                <div class="header__search-input-wrap">
                                        <input id="searchInput" name="keyword" type="text" class="header__search-input" placeholder="Tìm kiếm sản phẩm">
                                    <div class="header__search-history">
                                        <h3 class="header__search-history-heading">Lịch sử tìm kiếm</h3>
                                        <ul id="historyList" class="header__search-history-list">
                                        </ul>
                                    </div>
                                </div>
                            <button type="submit" class="header__search-btn">
                                <i class="fa-solid fa-magnifying-glass header__search-btn-icon"></i>
                            </button>
                        </div>
                    </form>
                        <div class="header-product hide-on-mobile-tablet">
                        </div>
                    </div>
                    
                    <label for="check1" class="header__cart has-hover">
                        <input type="checkbox" class="cart-input" hidden id="check1">
                        <?php 
                            if(isset($_SESSION['khachhang_login'])&&$_SESSION['khachhang_login']==true) 
                        {?>
                            <a href="index.php?mod=giohang&ac=home"><i class="fa-solid fa-bag-shopping header__cart-icon"></i>
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                <?php 
                                    $cartCount = $GioHang->countSPinGioHang($_SESSION['khachhang_magiohang']);
                                    echo $cartCount['tongsoluong'] ?? 0; 
                                ?>
                            </span>
                        </a>
                        <?php
                        }else{
                            ?>
                                <span class="navbar-top__list-item user-btn">
                                <a href="#" class="navbar__list-item-link"><i class="fa-solid fa-bag-shopping header__cart-icon"></i></a>
                                </span>
                            <?php
                        }
                        ?>
                    </label>
                </div>
            </div>
    
            <nav class="nav-header translate-l container">
                <ul class="nav__list">
                    <div class="close-nav-header"><i class="fa-solid fa-xmark"></i></div>
                    <li class="has-hover nav__list-item hiden_tablet_mobile">
                        <a href="./index.php?mod=product&ac=home">Tất cả</a>
                    </li>
                   <?php    
                        $loais = $LoaiSanPham -> getAll();
                        foreach($loais as $loai){
                    ?>
                        <li class="has-hover nav__list-item hiden_tablet_mobile">
                        <a href="index.php?mod=product&ac=home&page=1&maloai=<?php echo $loai['ma_loai']?>"><?php echo $loai['ten_loai']?></a>
                        </li>
                    <?php
                        }
                   ?>
                    <li class="nav__list-item active-tablet">
                        <a href="./index.php?mod=about&ac=home">Giới thiệu</a>    
                    </li>
                    <li class="nav__list-item active-tablet">
                        <a href="./product.html">Sản Phẩm</a>    
                    </li>
                    <li class="nav__list-item active-tablet">
                        <a href="#">Thông báo</a>    
                    </li>
                    <li class="nav__list-item active-tablet">
                        <a href="#">Ngôn ngữ</a>    
                    </li>
                    <li class="nav__list-item active-tablet">
                        <a href="#">Cài đặt</a>    
                    </li>
                    <li class="nav__list-item active-tablet">
                        <a href="#">Hỗ trợ</a>    
                    </li>
                </ul>
            </nav>
        </div>

<!-- Đăng nhập và đăng ký -->
 <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header border-bottom-0">
                    <button type="button" class="btn-close close-modal" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="tabs-listing">
                        <nav>
                            <div class="nav nav-tabs d-flex justify-content-center" id="nav-tab" role="tablist">
                                <button class="nav-link text-capitalize active" id="nav-sign-in-tab" data-bs-toggle="tab" data-bs-target="#nav-sign-in" type="button" role="tab" aria-controls="nav-sign-in" aria-selected="true">Đăng nhập</button>
                                <button class="nav-link text-capitalize" id="nav-register-tab" data-bs-toggle="tab" data-bs-target="#nav-register" type="button" role="tab" aria-controls="nav-register" aria-selected="false">Đăng ký</button>
                            </div>
                        </nav>
                        <div class="tab-content" id="nav-tabContent">
                            <div class="tab-pane fade active show" id="nav-sign-in" role="tabpanel" aria-labelledby="nav-sign-in-tab">
                                <form id="sign-in-form" class="needs-validation" novalidate action="index.php" method="POST">
                                    <div class="form-group py-2">
                                        <label class="mb-2" for="sign-in-email">Email:</label>
                                        <input type="email" id="sign-in-email" name="email" placeholder="Nhập email" class="form-control p-2" required>
                                        <div class="invalid-feedback text-start">
                                            Vui lòng nhập email phù hợp.
                                        </div>
                                    </div>
                                    <div class="form-group pb-3">
                                        <label class="mb-2" for="sign-in-password">Mật khẩu:</label>
                                        <input type="password" id="sign-in-password" name="password" placeholder="Nhập mật khẩu." class="form-control p-2" required>
                                        <div class="invalid-feedback text-start">
                                            Vui lòng nhập mật khẩu.
                                        </div>
                                    </div>
                                    <label class="py-2">
                                        <input type="checkbox" id="sign-in-remember" class="d-inline">
                                        <span class="label-body">Lưu tài khoản</span>
                                        <span class="label-body"><a href="#" class="fw-bold">Quên mật khẩu:</a></span>
                                    </label>
                                    <button type="submit" name="login" id="sign-in-submit" class="btn btn-login btn-dark w-100 my-3">Đăng nhập:</button>
                                </form>
                            </div>
                            <div class="tab-pane fade" id="nav-register" role="tabpanel" aria-labelledby="nav-register-tab">
                                <form id="register-form" class="needs-validation" novalidate action="index.php" method="POST">
                                    <div class="form-group py-2">
                                        <label class="mb-2" for="register-email">Emai:</label>
                                        <input type="email" id="register-email" name="email" placeholder="Nhập email." class="form-control p-2" required>
                                        <div class="invalid-feedback text-start">
                                            Vui lòng nhập email phù hợp.
                                        </div>
                                    </div>
                                    <div class="form-group py-2">
                                      <label class="mb-2" for="register-name">Họ và Tên:</label>
                                      <input type="text" id="register-name" name="name" placeholder="Nhập họ và tên" class="form-control p-2" required>
                                      <div class="invalid-feedback text-start">
                                          Vui lòng nhập họ và tên.
                                      </div>
                                  </div>
                                  <div class="form-group py-2">
                                      <label class="mb-2" for="register-phone">Số Điện Thoại:</label>
                                      <input type="tel" id="register-phone" name="phone" placeholder="Nhập số điện thoại" class="form-control p-2" required>
                                      <div class="invalid-feedback text-start">
                                          Vui lòng nhập số điện thoại hợp lệ.
                                      </div>
                                    <div class="form-group py-2">
                                        <label class="mb-2" for="register-password">Mật khẩu:</label>
                                        <input type="password" id="register-password" name="password" placeholder="Nhập mật khẩu." class="form-control p-2 password-register" required>
                                        <div class="invalid-feedback text-start">
                                            Vui lòng nhập mật khẩu.
                                        </div>
                                    </div>
                                    <div class="form-group py-2">
                                        <label for="mb-2" class="form-label">Nhập lại mật khẩu</label>
                                        <input class="form-control p-2 password_confirmation" id="register-password-confirm" name="password_confirmation" placeholder="Xác thực mật khẩu" type="password" required>
                                        <div class="invalid-feedback text-start invalid-confirm-pw">
                                            Không khớp với mật khẩu vừa nhập.
                                        </div>
                                    </div>
                                    <label class="py-2">
                                        <input type="checkbox" id="register-agree" required class="form-check-input d-inline">
                                        <span class="label-body">Đồng ý với <a href="#" class="fw-bold">chính sách bảo mật</a></span>
                                        <span class="invalid-feedback">
                                            Bạn chưa đồng ý chính sách bảo mật.
                                          </span>
                                    </label>
                                    <button type="submit" name="register" id="register-submit" class="btn btn-register btn-dark w-100 my-3">Đăng ký</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

 <!-- Xử lý lịch sử tìm kiếm        -->

<script>
    const searchForm = document.getElementById('searchForm');
    const searchInput = document.getElementById('searchInput');
    const historyList = document.getElementById('historyList');
    const maxHistory = 10;
    function loadHistory() {
        const history = JSON.parse(localStorage.getItem('searchHistory')) || [];
        historyList.innerHTML = '';
        history.forEach(item => {
            const li = document.createElement('li');
            li.className = 'header__search-history-item';
            li.innerHTML = `<a href="index.php?mod=product&ac=home&keyword=${item}">${item}</a>`;
            historyList.appendChild(li);
        });
    }
    function saveHistory(keyword) {
        let history = JSON.parse(localStorage.getItem('searchHistory')) || [];
        // Xóa từ khóa trùng lặp
        history = history.filter(item => item !== keyword);
        // Thêm từ khóa mới vào đầu danh sách
        history.unshift(keyword);
        // Giới hạn số lượng lịch sử
        if (history.length > maxHistory) {
            history.pop();
        }
        localStorage.setItem('searchHistory', JSON.stringify(history));
    }
    searchForm.addEventListener('submit', function (e) {
        const keyword = searchInput.value.trim();
        if (keyword) {
            saveHistory(keyword);
        }
    });
    loadHistory();
</script>
