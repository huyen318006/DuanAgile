@extends('layouts.AdminLayout')

@section('content')
<main class="main" id="top">

<section class="py-5 overflow-hidden bg-primary" id="home">
    <div class="container" style="height: 80vh; position: relative;">
        <div class="row flex-center">
            <div class="col-md-5 col-lg-6 order-0 order-md-1 mt-8 mt-md-0">
                <a class="img-landing-banner" href="#!">
                    <img class="img-fluid" src="{{ asset('assets/img/gallery/hero-header.png') }}" alt="hero-header" style="margin-top:95px;"/>
                </a>
            </div>
            <div class="col-md-7 col-lg-6 py-8 text-md-start text-center">
                <h1 class="display-1 fs-md-5 fs-lg-6 fs-xl-8 text-light" data-text="Bạn Đang Đói?">Bạn Đang Đói?</h1>
                <h1 class="text-800 mb-5 fs-4">Chỉ với vài cú nhấp chuột, tìm ngay những món ăn<br class="d-none d-xxl-block" /> ở gần bạn</h1>
            </div>
        </div>

        <!-- Banner nhỏ chạy ngang -->
        <div class="small-banner-carousel">
            <div class="small-banner-track">
                <img src="{{ asset('assets/img/gallery/small1.avif') }}" alt="small1" />
                <img src="{{ asset('assets/img/gallery/small2.avif') }}" alt="small2" />
                <img src="{{ asset('assets/img/gallery/small3.jpg') }}" alt="small3" />
                <img src="{{ asset('assets/img/gallery/small4.avif') }}" alt="small4" />
                <!-- Lặp lại -->
                <img src="{{ asset('assets/img/gallery/small1.avif') }}" alt="small1" />
                <img src="{{ asset('assets/img/gallery/small2.avif') }}" alt="small2" />
            </div>
        </div>

        <!-- Layer sao rơi toàn banner -->
        <div class="star-container">
            <span class="star"></span>
            <span class="star"></span>
            <span class="star"></span>
            <span class="star"></span>
            <span class="star"></span>
            <span class="star"></span>
            <span class="star"></span>
            <span class="star"></span>
            <span class="star"></span>
            <span class="star"></span>
        </div>
    </div>
</section>


  <!-- ============================================-->
  <!-- <section> begin ============================-->
  <section class="py-0">

    <div class="container">
      <div class="row h-100 gx-2 mt-7">
        <div class="col-sm-6 col-lg-3 mb-3 mb-md-0 h-100 pb-4">
          <div class="card card-span h-100">
            <div class="position-relative"> <img class="img-fluid rounded-3 w-100" src="{{ asset('assets/img/gallery/discount-item-1.png') }}" alt="..." />
              <div class="card-actions">
                <div class="badge badge-foodwagon bg-primary p-4">
                  <div class="d-flex flex-between-center">
                    <div class="text-white fs-7">15</div>
                    <div class="d-block text-white fs-2">% <br />
                      <div class="fw-normal fs-1 mt-2">Giảm</div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="card-body px-0">
              <h5 class="fw-bold text-1000 text-truncate">Burger bò đặc biệt</h5><span class="badge bg-soft-danger py-2 px-3"><span class="fs-1 text-danger">Còn 6 ngày</span></span>
            </div><a class="stretched-link" href="#"></a>
          </div>
        </div>
        <div class="col-sm-6 col-lg-3 mb-3 mb-md-0 h-100 pb-4">
          <div class="card card-span h-100">
            <div class="position-relative"> <img class="img-fluid rounded-3 w-100" src="{{ asset('assets/img/gallery/discount-item-2.png') }}" alt="..." />
              <div class="card-actions">
                <div class="badge badge-foodwagon bg-primary p-4">
                  <div class="d-flex flex-between-center">
                    <div class="text-white fs-7">10</div>
                    <div class="d-block text-white fs-2">% <br />
                      <div class="fw-normal fs-1 mt-2">Giảm</div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="card-body px-0">
              <h5 class="fw-bold text-1000 text-truncate">Pizza hải sản</h5><span class="badge bg-soft-danger py-2 px-3"><span class="fs-1 text-danger">Còn 6 ngày</span></span>
            </div><a class="stretched-link" href="#"></a>
          </div>
        </div>
        <div class="col-sm-6 col-lg-3 mb-3 mb-md-0 h-100 pb-4">
          <div class="card card-span h-100">
            <div class="position-relative"> <img class="img-fluid rounded-3 w-100" src="{{ asset('assets/img/gallery/discount-item-3.png') }}" alt="..." />
              <div class="card-actions">
                <div class="badge badge-foodwagon bg-primary p-4">
                  <div class="d-flex flex-between-center">
                    <div class="text-white fs-7">25</div>
                    <div class="d-block text-white fs-2">% <br />
                      <div class="fw-normal fs-1 mt-2">Giảm</div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="card-body px-0">
              <h5 class="fw-bold text-1000 text-truncate">Gà rán giòn cay</h5><span class="badge bg-soft-danger py-2 px-3"><span class="fs-1 text-danger">Còn 6 ngày</span></span>
            </div><a class="stretched-link" href="#"></a>
          </div>
        </div>
        <div class="col-sm-6 col-lg-3 mb-3 mb-md-0 h-100 pb-4">
          <div class="card card-span h-100">
            <div class="position-relative"> <img class="img-fluid rounded-3 w-100" src="{{ asset('assets/img/gallery/discount-item-4.png') }}" alt="..." />
              <div class="card-actions">
                <div class="badge badge-foodwagon bg-primary p-4">
                  <div class="d-flex flex-between-center">
                    <div class="text-white fs-7">20</div>
                    <div class="d-block text-white fs-2">% <br />
                      <div class="fw-normal fs-1 mt-2">Giảm</div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="card-body px-0">
              <h5 class="fw-bold text-1000 text-truncate">Trà sữa trân châu</h5><span class="badge bg-soft-danger py-2 px-3"><span class="fs-1 text-danger">Còn 6 ngày</span></span>
            </div><a class="stretched-link" href="#"></a>
          </div>
        </div>
      </div>
    </div><!-- end of .container-->

  </section>
  <!-- <section> close ============================-->
  <!-- ============================================-->




  <!-- ============================================-->
  <!-- <section> begin ============================-->
  <section class="py-0 bg-primary-gradient">

    <div class="container">
      <div class="row justify-content-center g-0">
        <div class="col-xl-9">
          <div class="col-lg-6 text-center mx-auto mb-3 mb-md-5 mt-4">
            <h5 class="fw-bold text-danger fs-3 fs-lg-5 lh-sm my-6">Cách thức hoạt động</h5>
          </div>
          <div class="row">
            <div class="col-sm-6 col-md-3 mb-6">
              <div class="text-center"><img class="shadow-icon" src="{{ asset('assets/img/gallery/location.png') }}" height="112" alt="..." />
                <h5 class="mt-4 fw-bold"> Chọn địa chỉ</h5>
                <p class="mb-md-0">Chọn địa chỉ nơi bạn muốn nhận món ăn.</p>
              </div>
            </div>
            <div class="col-sm-6 col-md-3 mb-6">
              <div class="text-center"><img class="shadow-icon" src="{{ asset('assets/img/gallery/order.png') }}" height="112" alt="..." />
                <h5 class="mt-4 fw-bold"> Chọn món ăn</h5>
                <p class="mb-md-0">Xem hàng trăm món ăn và chọn món bạn yêu thích.</p>
              </div>
            </div>
            <div class="col-sm-6 col-md-3 mb-6">
              <div class="text-center"><img class="shadow-icon" src="{{ asset('assets/img/gallery/pay.png') }}" height="112" alt="..." />
                <h5 class="mt-4 fw-bold">Thanh toán</h5>
                <p class="mb-md-0">Nhanh chóng, an toàn và đơn giản với nhiều phương thức thanh toán.</p>
              </div>
            </div>
            <div class="col-sm-6 col-md-3 mb-6">
              <div class="text-center"><img class="shadow-icon" src="{{ asset('assets/img/gallery/meals.png') }}" height="112" alt="..." />
                <h5 class="mt-4 fw-bold">Thưởng thức món ăn</h5>
                <p class="mb-md-0">Món ăn sẽ được chuẩn bị và giao tận nơi cho bạn.</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div><!-- end of .container-->

  </section>
  <!-- <section> close ============================-->
  <!-- ============================================-->


  {{-- LIST MÓN ĂN --}}
  <!-- ============================================-->
  <!-- <section> begin ============================-->
  <section class="py-4 overflow-hidden">

    <div class="container">
      <div class="row h-100">
        <div class="col-lg-7 mx-auto text-center mt-7 mb-5">
          <h5 class="fw-bold fs-3 fs-lg-5 lh-sm">Món ăn phổ biến</h5>
        </div>
        <div class="col-12">
          <div class="carousel slide" id="carouselPopularItems" data-bs-touch="false" data-bs-interval="false">
            <div class="carousel-inner">
              @foreach(array_chunk($popularFoods,4) as $index => $chunk)
              <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                <div class="row gx-3 h-100 align-items-center">
                  @foreach($chunk as $food)
                  <div class="col-sm-6 col-md-4 col-xl-3 mb-5 h-100">
                    <div class="card card-span h-100 rounded-3">
                      <img class="img-fluid rounded-3" src="{{ asset('assets/img/gallery/'.$food->image) }}" alt="{{ $food->name }}" style="width:100%; height:220px; object-fit:cover;">
                      <div class="card-body ps-0">
                        <h5 class="fw-bold text-1000 text-truncate mb-1">{{ $food->name }}</h5>
                        <div>
                          <span class="text-warning me-2"><i class="fas fa-map-marker-alt"></i></span>
                          <span class="text-primary">Món ăn phổ biến</span>
                        </div>
                        <span class="text-1000 fw-bold">{{ number_format($food->price) }}đ</span>
                      </div>
                    </div>
                    <div class="d-grid gap-2">
                     
                      <a href="{{ route('foods/'.$food->id.'/order') }}" class="btn btn-primary" style="transition:0.3s;" onmouseover="this.style.transform='scale(1.05)';this.style.boxShadow='0 8px 20px rgba(0,0,0,0.2)';" onmouseout="this.style.transform='scale(1)';this.style.boxShadow='none';">Đặt Hàng</a>
                    </div>
                  </div>
                  @endforeach
                </div>
              </div>
              @endforeach
            </div>
            <button class="carousel-control-prev carousel-icon" type="button" data-bs-target="#carouselPopularItems" data-bs-slide="prev"><span class="carousel-control-prev-icon hover-top-shadow" aria-hidden="true"></span><span class="visually-hidden">Trước</span></button>
            <button class="carousel-control-next carousel-icon" type="button" data-bs-target="#carouselPopularItems" data-bs-slide="next"><span class="carousel-control-next-icon hover-top-shadow" aria-hidden="true"></span><span class="visually-hidden">Tiếp theo</span></button>
          </div>
        </div>
      </div>
    </div><!-- end of .container-->

  </section>
  <!-- <section> close ============================-->
  <!-- ============================================-->


  <section id="testimonial">
    <div class="container">

      <div class="row h-100">
        <div class="col-lg-7 mx-auto text-center mb-6">
          <h5 class="fw-bold fs-3 fs-lg-5 lh-sm mb-3">Nhà Hàng Nổi Bật</h5>
        </div>
      </div>

      <div class="carousel slide" id="carouselRestaurants" data-bs-ride="carousel" data-bs-interval="3500">
        <div class="carousel-inner">

          @foreach(array_chunk($restaurants,4) as $index => $chunk)
          <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
            <div class="row gx-2">

              @foreach($chunk as $restaurant)
              <div class="col-sm-6 col-md-4 col-lg-3 mb-5" style="display:flex">
                <a href="/restaurant/{{ $restaurant->id }}">
                  <div class="card card-span text-white rounded-3" style="width:100%;height:100%;overflow:hidden;transition:0.25s ease;cursor:pointer" onmouseover="this.style.filter='brightness(1.05)';this.style.transform='translateY(-3px)'" onmouseout="this.style.filter='brightness(1)';this.style.transform='translateY(0)'">

                    <img src="{{ asset('assets/img/gallery/'.$restaurant->image) }}" style="width:100%;height:300px;object-fit:cover;border-radius:10px">

                    <div class="card-img-overlay ps-0">
                      <span class="badge bg-danger p-2 ms-3"><i class="fas fa-tag me-2 fs-0"></i><span class="fs-0">{{ $restaurant->discount }}% off</span></span>
                      <span class="badge bg-primary ms-2 me-1 p-2"><i class="fas fa-clock me-1 fs-0"></i><span class="fs-0">Fast</span></span>
                    </div>

                    <div class="card-body ps-0">
                      <div class="d-flex align-items-center mb-3">

                        <img src="{{ asset('assets/img/gallery/'.$restaurant->logo) }}" style="width:60px;height:100px;object-fit:contain">

                        <div class="flex-1 ms-3">
                          <h5 class="mb-0 fw-bold text-1000">{{ $restaurant->name }}</h5>
                          <span style="font-size:13px;color:#666">{{ $restaurant->slogan }}</span></br>
                          <span class="text-warning">
                            @for($i=1;$i<=5;$i++)
                              @if($i <=$restaurant->rating)
                              <i class="fa-solid fa-star"></i>
                              @else
                              <i class="fa-regular fa-star"></i>
                              @endif
                              @endfor
                          </span>
                          <span class="mb-0 text-primary">{{ $restaurant->rating }}</span>
                        </div>
                      </div>
                    </div>
                  </div>

                </a>

              </div>
              @endforeach
            </div>
          </div>
          @endforeach
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselRestaurants" data-bs-slide="prev" style="width:60px;height:327px;">
          <span class="carousel-control-prev-icon"></span>
        </button>

        <button class="carousel-control-next" type="button" data-bs-target="#carouselRestaurants" data-bs-slide="next" style="width:60px;height:327px;">
          <span class="carousel-control-next-icon"></span>
        </button>

      </div>

      <div class="col-12 d-flex justify-content-center mt-5">
        <a class="btn btn-lg btn-primary" href="#" style="transition:0.3s;" onmouseover="this.style.transform='scale(1.08)';this.style.boxShadow='0 8px 20px rgba(0,0,0,0.2)';" onmouseout="this.style.transform='scale(1)';this.style.boxShadow='none';">View All<i class="fas fa-chevron-right ms-2"></i></a>
      </div>

    </div>
  </section>


  <!-- ============================================-->
  <!-- <section> begin ============================-->

  {{-- phần đề xuất gợi ý --}}
<section class="py-8 overflow-hidden">
  <div class="container">

    <!-- HEADER -->
    <div class="row align-items-center mb-4">

      <!-- TITLE -->
      <div class="col-lg-6">
        <h5 class="fw-bold fs-3 mb-0">
          🔥 Gợi ý dành cho bạn
        </h5>
      </div>

      <!-- RIGHT -->
      <div class="col-lg-6 text-end d-flex justify-content-end align-items-center gap-2">

       <!-- BUTTON LEFT -->

          <button class="carousel-control-prev carousel-icon"
                  type="button"
                  data-bs-target="#carouselFood"
                  data-bs-slide="prev">
            <span class="carousel-control-prev-icon rounded-circle p-3"></span>
          </button>
          <!-- BUTTON RIGHT -->
          <button class="carousel-control-next carousel-icon"
                  type="button"
                  data-bs-target="#carouselFood"
                  data-bs-slide="next">
            <span class="carousel-control-next-icon rounded-circle p-3"></span>
          </button>

        <!-- VIEW ALL -->
        <a class="btn btn-sm text-primary ms-2" href="{{ route('menu') }}">XEM TẤT CẢ →</a>

      </div>

    </div>

    <!-- CAROUSEL -->
    <div id="carouselFood"
     class="carousel slide"
     data-bs-ride="carousel"
     data-bs-interval="2500"
     data-bs-pause="hover"
     data-bs-wrap="true">

    <!-- auto chạy 2.5s -->
    <!-- hover thì dừng -->
    <!-- chạy vòng -->
      <div class="carousel-inner">

        @php
          $chunks = array_chunk($recommendedFoods, 4);
        @endphp

        @foreach($chunks as $index => $chunk)
        <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
          <div class="row text-center">

            @foreach($chunk as $food)
            <div class="col-6 col-md-3 mb-4">

              <a href="{{ route('foods/'.$food->id.'/order') }}" class="text-decoration-none text-dark">

                <!-- IMAGE -->
                <div style="width:140px;height:140px;margin:auto;">
                  <img src="{{ asset('assets/img/gallery/'.$food->image) }}"
                       style="width:100%;height:100%;object-fit:cover;border-radius:50%;box-shadow:0 4px 15px rgba(0,0,0,0.2);">
                </div>

                <!-- NAME -->
                <h6 class="mt-3 fw-bold text-truncate">
                  {{ $food->name }}
                </h6>

                <!-- PRICE -->
                <p class="text-primary fw-bold mb-1">
                  {{ number_format($food->price) }}đ
                </p>

                <!-- ORDER -->
                <p class="text-muted small">
                  🔥 {{ $food->total_order ?? 0 }} lượt đặt
                </p>

              </a>

            </div>
            @endforeach

          </div>
        </div>
        @endforeach
      </div>
    </div>
  </div>
</section>
{{-- phần tin tức món ăn --}}
<section class="py-5 bg-light">
  <div class="container">
    <div class="row g-4">

      @foreach($posts as $post)
   <!-- CONTENT -->
<!-- IMAGE -->
<div class="col-md-5">
  <img 
    src="{{ asset('assets/img/gallery/' . ($post->image ?? 'default.png')) }}"
    class="img-fluid w-100 h-100 image-cover"
    alt="{{ $post->title }}">
</div>

<!-- CONTENT -->
<div class="col-md-7 d-flex flex-column p-4">
  <div class="flex-grow-1">
    <h4 class="fw-bold mb-3 clamp-2">{{ $post->title }}</h4>
    
    <p class="text-muted mb-4 clamp-3">
      {{ $post->content }}
    </p>
  </div>

  <div class="d-flex justify-content-between align-items-center">
    <div class="text-muted small d-flex align-items-center gap-1">
      <i class="bi bi-eye"></i>
      <span>{{ number_format($post->views ?? 0) }} lượt xem</span>
    </div>

    <div>
      <a href="{{ route('post/'.$post->id.'/show') }}" 
         class="btn btn-primary px-5 py-2.5">
        Xem chi tiết
      </a>
    </div>
  </div>
</div>


      @endforeach

    </div>
  </div>
</section>

 


</main>

<div id="cart-toast" style="position:fixed;top:20px;right:20px;z-index:9999;display:none;cursor:pointer;" onclick="window.location.href='{{ APP_URL }}cart'">
  <div class="alert alert-success shadow-lg d-flex align-items-center" role="alert" style="min-width:280px;border-radius:12px;">
    <i class="fas fa-check-circle me-2 fs-4"></i>
    <div class="flex-grow-1">
      <span id="cart-toast-msg">Đã thêm vào giỏ hàng!</span>
      <div style="font-size:12px;opacity:0.8;margin-top:2px;">Nhấn để xem giỏ hàng <i class="fas fa-chevron-right"></i></div>
    </div>
  </div>
</div>

@section('scripts')
<script>
  document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.btn-order-now').forEach(function(btn) {
      btn.addEventListener('click', function() {
        var foodId = this.getAttribute('data-food-id');
        var button = this;

        button.disabled = true;
        button.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i>Đang thêm...';

        var formData = new FormData();
        formData.append('food_id', foodId);
        formData.append('quantity', 1);

        fetch('{{ APP_URL }}cart/add', {
            method: 'POST',
            headers: {
              'X-Requested-With': 'XMLHttpRequest'
            },
            body: formData
          })
          .then(function(res) {
            return res.json();
          })
          .then(function(data) {
            if (data.success) {
              showCartToast(data.message || 'Đã thêm vào giỏ hàng!');
              var badge = document.getElementById('cart-count-badge');
              if (badge && data.cart_count !== undefined) {
                badge.textContent = data.cart_count;
              }
            } else {
              showCartToast('Có lỗi xảy ra, vui lòng thử lại!', true);
            }
          })
          .catch(function() {
            window.location.href = '{{ APP_URL }}login';
          })
          .finally(function() {
            button.disabled = false;
            button.innerHTML = '<i class="fas fa-cart-plus me-1"></i>Đặt ngay';
          });
      });
    });

    function showCartToast(msg, isError) {
      var toast = document.getElementById('cart-toast');
      var msgEl = document.getElementById('cart-toast-msg');
      var alertDiv = toast.querySelector('.alert');
      var hintEl = toast.querySelector('div[style*="font-size:12px"]');

      msgEl.textContent = msg;
      alertDiv.className = 'alert shadow-lg d-flex align-items-center';
      alertDiv.classList.add(isError ? 'alert-danger' : 'alert-success');
      alertDiv.style.minWidth = '280px';
      alertDiv.style.borderRadius = '12px';

      toast.style.cursor = isError ? 'default' : 'pointer';
      toast.onclick = isError ? null : function() {
        window.location.href = '{{ APP_URL }}cart';
      };
      if (hintEl) hintEl.style.display = isError ? 'none' : 'block';

      toast.style.display = 'block';
      setTimeout(function() {
        toast.style.display = 'none';
      }, 4000);
    }
  });
</script>
<style>
/* Nút gọn, chữ căn giữa, bo tròn đẹp */
.btn-primary {
    border-radius: 50px;
    font-weight: 500;
    font-size: 1rem;
    padding: 10px 32px;        /* ngắn lại, vừa phải */
    min-width: 160px;          /* kiểm soát chiều rộng */
    transition: all 0.3s ease;
}

.btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 20px rgba(13, 110, 253, 0.3);
}

/* Nếu muốn nút vàng giống ảnh trước đó */
.btn-warning {
    border-radius: 50px;
    font-weight: 500;
    padding: 10px 32px;
    min-width: 160px;
    font-size: 1rem;
}

.btn-warning:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 20px rgba(255, 193, 7, 0.35);
}
/* Làm cho phần lượt xem nhỏ và đẹp hơn */
.small {
    font-size: 0.875rem;
}

.bi-eye {
    font-size: 1.1rem;
}

/* Điều chỉnh nút khi có lượt xem */
.btn-primary {
    border-radius: 50px;
    font-weight: 500;
    padding: 10px 28px;
    font-size: 0.98rem;
    transition: all 0.3s ease;
}

.btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 18px rgba(13, 110, 253, 0.3);
}
.clamp-2 {
  display: -webkit-box;
  -webkit-line-clamp: 2;   /* giới hạn 2 dòng */
  -webkit-box-orient: vertical;
  overflow: hidden;
  text-overflow: ellipsis;
}

.clamp-3 {
  display: -webkit-box;
  -webkit-line-clamp: 3;   /* giới hạn 3 dòng */
  -webkit-box-orient: vertical;
  overflow: hidden;
  text-overflow: ellipsis;
}
.image-cover {
  object-fit: cover;
}

</style>
@endsection
@endsection