
    <Section class="row banners">
        <div class="banner col-md-9 col-12 " id="banner1">
            <div id="demo" class="carousel slide banner-slide" data-bs-ride="carousel">

                <!-- Indicators/dots -->
                <div class="carousel-indicators carousel-btn-list">
                  <button type="button" data-bs-target="#demo" data-bs-slide-to="0" class="active"></button>
                  <button type="button" data-bs-target="#demo" data-bs-slide-to="1"></button>
                  <button type="button" data-bs-target="#demo" data-bs-slide-to="2"></button>
                </div>
              
                <!-- The slideshow/carousel -->
                <div class="carousel-inner h-100">
                  <div class="carousel-item h-100 active">
                    <img src="https://pos.nvncdn.com/cba2a3-7534/bn/20240425_aCR1k3kT.gif" alt="Los Angeles" class="d-block w-100 h-100">
                  </div>
                  <div class="carousel-item h-100">
                    <img src="https://pos.nvncdn.com/cba2a3-7534/bn/20240409_63dyFlGa.gif" alt="Chicago" class="d-block w-100 h-100">
                  </div>
                  <div class="carousel-item h-100">
                    <img src="https://pos.nvncdn.com/cba2a3-7534/bn/20240425_aCR1k3kT.gif" alt="New York" class="d-block w-100 h-100">
                  </div>
                </div>
              
                <!-- Left and right controls/icons -->
                <button class="slide-btn carousel-control-prev" type="button" data-bs-target="#demo" data-bs-slide="prev">
                  <span class="carousel-control-prev-icon"></span>
                </button>
                <button class="slide-btn carousel-control-next" type="button" data-bs-target="#demo" data-bs-slide="next">
                  <span class="carousel-control-next-icon"></span>
                </button>
              </div>
        </div>
        <div class="banner col-md-3 col-12" id="banner2">
            <div class="">
                <img class="d-block h-100 w-100"src="https://www.btaskee.com/wp-content/uploads/2023/02/decor-ban-hoc-de-thuong.jpg" alt="">
            </div>
            <div class="">
                <img class="d-block h-100 w-100" src="https://static.comem.vn/uploads/November2022/mua-qua-sinh-nhat-cho-be-gai-10-tuoi.jpg" alt="">
            </div>
        </div>
    </Section>
    <!-- Lấy ngẫu nhiên sản phẩm -->
    <Section class="new-items">
        <div class="container-md">
            <div class="section-title d-flex justify-content-between align-items-center mb-4 mt-4">
              <h2 class="d-flex align-items-center">Sản phẩm mới</h2>
              <a href="./product.html" class="btn">Xem thêm</a>
            </div>
            <div class="wrap-new-items-List">
                <div class="new-items-List">
                    <div class="list">
                      <?php
                       $sanphams = $SanPham->getRand(); 
                       foreach($sanphams as $sanpham){
                        ?>
                        <div class="product-item new-item card">
                        <a href="index.php?mod=product&ac=detail&masanpham=<?php echo $sanpham["ma_san_pham"] ?>">
                        <span class="flag">New</span>
                        <div class="product-item-img">
                            <img src="./images/<?php echo $sanpham['image'] ?>" class="card-img-top" alt="...">
                        </div>
                        <div class="card-body">
                          <h6 class="card-title fw-bold"><?php echo $sanpham['ten_san_pham']?></h6>
                          <p class="card-text"><?php echo number_format($sanpham['gia'], 0, ',', '.') . " đ";   ?></p>
                          <div class="icon-add">
                              <i class="fa-solid fa-plus"></i>
                          </div>
                        </div>
                        </a>
                        </div>
                       <?php 
                       }
                      ?>
                        
                    </div>
                </div>
                <button id="new-item-pre-btn" class="hiden_tablet_mobile"><i class="fa-solid fa-chevron-left"></i></button>
                <button id="new-item-next-btn" class="hiden_tablet_mobile"><i class="fa-solid fa-chevron-right"></i></button>
            </div>
          </div>
    </Section>
    <section id="limited-offer">
      <div class="container-md h-100 d-flex align-items-center">
        <div class="row d-flex align-items-center">
          <div class="col-md-7 col-12 text-center">
            <div class="image-holder">
              <img src="./images/Lovepik_com-401539260-toy-bear.png" class="img-fluid" alt="banner">
            </div>
          </div>
          <div class="col-md-5 col-12 text-center text-md-start">
            <h2 class="fw-bold">Giảm 30% cho tất cả sản phẩm. Nhanh tay lên!!!</h2>
            <div id="countdown-clock" class="text-dark d-flex align-items-center my-3">
              <div class="time d-grid pe-3">
                <span class="days fs-1 fw-normal">00</span>
                <small>Days</small>
              </div>
              <span class="fs-1 circle-countdown">:</span>
              <div class="time d-grid pe-3 ps-3">
                <span class="hours fs-1 fw-normal">00</span>
                <small>Hrs</small>
              </div>
              <span class="fs-1 circle-countdown">:</span>
              <div class="time d-grid pe-3 ps-3">
                <span class="minutes fs-1 fw-normal">00</span>
                <small>Min</small>
              </div>
              <span class="fs-1 circle-countdown">:</span>
              <div class="time d-grid ps-3">
                <span class="seconds fs-1 fw-normal">00</span>
                <small>Sec</small>
              </div>
            </div>
            <a href="shop.html" class="btn mt-3">Shop Collection</a>
          </div>
        </div>
      </div>
      </div>
    </section>
    <section class="product-list container-md">
        <div class="section-title d-flex justify-content-between align-items-center mb-4 mt-4">
            <h2 class="d-flex align-items-center">Giảm giá sốc</h2>
            <a href="./product.html" class="btn">Xem thêm</a>
          </div>
        <div class="row">
        <?php
            $sanphams = $SanPham->getRand(); 
            foreach($sanphams as $sanpham){
              include "./include/sanpham.php";
            }
            ?>
        </div>
    </section>
    <div id="backTop">
        <i class="fa-solid fa-angles-up"></i>
    </div>