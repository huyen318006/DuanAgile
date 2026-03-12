@extends('layouts.AdminLayout')

@section('content')
<main class="main" id="top">

  <section class="py-0">
    <div class="bg-holder" style="background-image:url({{ asset('assets/img/gallery/cta-two-bg.png') }});background-position:center;background-size:cover;">
    </div>
    <!--/.bg-holder-->

    <div class="container">
      <div class="row flex-center">
        <div class="col-xxl-9 py-7 text-center">
          <h1 class="fw-bold mb-4 text-white fs-6"> Bạn đã sẵn sàng đặt món <br />với những ưu đãi tốt nhất chưa?</h1><a class="btn btn-danger" href="#"> ĐẶT MÓN NGAY<i class="fas fa-chevron-right ms-2"></i></a>
        </div>
      </div>
    </div>
  </section>
  <div class="container">
    <div class="row h-100">
      <div class="col-lg-7 mx-auto text-center mb-6">
        <h5 class="fw-bold fs-3 fs-lg-5 lh-sm mb-3">Menu</h5>
      </div>
    </div>
    {{-- FILTER SECTION - CSS loaded from assets/css/menu-filter.css --}}

    <div class="menu-filter-container" id="menuFilterSection">
      <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
        <h5 class="fw-bold fs-3 lh-sm mb-0">Lọc theo loại món ăn</h5>
        <div class="d-flex align-items-center gap-2">
          <label for="categoryFilter" class="fw-semibold text-1000 mb-0 text-nowrap">Loại món:</label>
          <select class="form-select menu-filter-select" id="categoryFilter" onchange="filterMenu(this.value)">
            <option value="all" selected>Tất cả</option>
            @foreach($categories as $category)
              <option value="{{ $category->id }}">{{ $category->name }}</option>
            @endforeach
          </select>
        </div>
      </div>
    </div>
    <div class="row gx-2" id="menuCardGrid">
      @foreach($foods as $food)
      <div class="col-sm-6 col-md-4 col-lg-3 h-100 mb-5 menu-card-item visible" data-category="{{ $food->category_id }}">
        <div class="card card-span h-100 text-white rounded-3">
          @if($food->image)
            <img class="img-fluid rounded-3 h-100" src="{{ file_url($food->image) }}" alt="{{ $food->name }}" />
          @else
            <img class="img-fluid rounded-3 h-100" src="{{ asset('assets/img/gallery/food-world.png') }}" alt="{{ $food->name }}" />
          @endif
          <div class="card-body ps-0">
            <div class="d-flex align-items-center mb-3">
              <div class="flex-1 ms-3">
                <h5 class="mb-0 fw-bold text-1000">{{ $food->name }}</h5>
                <span class="text-warning fw-bold">{{ number_format($food->price, 0, ',', '.') }}đ</span>
              </div>
            </div>
            @if($food->description)
              <p class="text-muted small mb-0">{{ $food->description }}</p>
            @endif
          </div>
        </div>
      </div>
      @endforeach

      @if(count($foods) === 0)
      <div class="col-12 text-center py-5">
        <p class="text-muted fs-1">Chưa có món ăn nào trong menu.</p>
      </div>
      @endif
    </div>
  </div>



  <!-- ============================================-->
  <!-- <section> begin ============================-->

  <!-- <section> close ============================-->
  <!-- ============================================-->


  {{-- <section>
        <div class="bg-holder" style="background-image:url({{ asset('assets/img/gallery/cta-one-bg.png') }});background-position:center;background-size:cover;">
  </div>
  <!--/.bg-holder-->

  <div class="container">
    <div class="row justify-content-center">
      <div class="col-xxl-10">
        <div class="card card-span shadow-warning" style="border-radius: 35px;">
          <div class="card-body py-5">
            <div class="row justify-content-evenly">
              <div class="col-md-3">
                <div class="d-flex d-md-block d-xl-flex justify-content-evenly justify-content-lg-between"><img src="{{ asset('assets/img/icons/discounts.png') }}" width="100" alt="..." />
                  <div class="d-flex d-lg-block d-xl-flex flex-center">
                    <h2 class="fw-bolder text-1000 mb-0 text-gradient">Daily<br class="d-none d-md-block" />Discounts </h2>
                  </div>
                </div>
              </div>
              <div class="col-md-3 hr-vertical">
                <div class="d-flex d-md-block d-xl-flex justify-content-evenly justify-content-lg-between"><img src="{{ asset('assets/img/icons/live-tracking.png') }}" width="100" alt="..." />
                  <div class="d-flex d-lg-block d-xl-flex flex-center">
                    <h2 class="fw-bolder text-1000 mb-0 text-gradient">Live Tracking</h2>
                  </div>
                </div>
              </div>
              <div class="col-md-3 hr-vertical">
                <div class="d-flex d-md-block d-xl-flex justify-content-evenly justify-content-lg-between"><img src="{{ asset('assets/img/icons/quick-delivery.png') }}" width="100" alt="..." />
                  <div class="d-flex d-lg-block d-xl-flex flex-center">
                    <h2 class="fw-bolder text-1000 mb-0 text-gradient">Quick Delivery </h2>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    </section> --}}


    <!-- ============================================-->
    <!-- <section> begin ============================-->
    <section class="pb-5 pt-8">

      <div class="container">
        <div class="row">
          <div class="col-12">
            <div class="card card-span mb-3 shadow-lg">
              <div class="card-body py-0">
                <div class="row justify-content-center">
                  <div class="col-md-5 col-xl-7 col-xxl-8 g-0 order-0 order-md-1"><img class="img-fluid w-100 fit-cover h-100 rounded-top rounded-md-end rounded-md-top-0" src="{{ asset('assets/img/gallery/crispy-sandwiches.png') }}" alt="..." /></div>
                  <div class="col-md-7 col-xl-5 col-xxl-4 p-4 p-lg-5">
                    <h1 class="card-title mt-xl-5 mb-4">Ưu đãi tốt nhất cho <span class="text-primary"> Sandwich Giòn</span></h1>
                    <p class="fs-1">Thưởng thức những chiếc sandwich cỡ lớn thơm ngon. Hoàn thiện bữa ăn của bạn với những lát sandwich tuyệt hảo.</p>
                    <div class="d-grid bottom-0"><a class="btn btn-lg btn-primary mt-xl-6" href="#!">TIẾN HÀNH ĐẶT MÓN<i class="fas fa-chevron-right ms-2"></i></a></div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div><!-- end of .container-->

    </section>
    <!-- <section> close ============================-->
    <!-- ============================================-->




    <!-- ============================================-->
    <!-- <section> begin ============================-->
    <section class="py-0">

      <div class="container">
        <div class="row">
          <div class="col-12">
            <div class="card card-span mb-3 shadow-lg">
              <div class="card-body py-0">
                <div class="row justify-content-center">
                  <div class="col-md-5 col-xl-7 col-xxl-8 g-0 order-md-0"><img class="img-fluid w-100 fit-cover h-100 rounded-top rounded-md-start rounded-md-top-0" src="{{ asset('assets/img/gallery/fried-chicken.png') }}" alt="..." /></div>
                  <div class="col-md-7 col-xl-5 col-xxl-4 p-4 p-lg-5">
                    <h1 class="card-title mt-xl-5 mb-4">Hãy tổ chức bữa tiệc <span class="text-primary">với Gà rán thơm ngon</span></h1>
                    <p class="fs-1">Thưởng thức gà rán giòn rụm với hương vị chanh ớt hấp dẫn. Khám phá những ưu đãi tốt nhất dành cho gà rán.</p>
                    <div class="d-grid bottom-0"><a class="btn btn-lg btn-primary mt-xl-6" href="#!">TIẾN HÀNH ĐẶT MÓN<i class="fas fa-chevron-right ms-2"></i></a></div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div><!-- end of .container-->

    </section>
    <!-- <section> close ============================-->
    <!-- ============================================-->




    <!-- ============================================-->
    <!-- <section> begin ============================-->
    <section class="pt-5">

      <div class="container">
        <div class="row">
          <div class="col-12">
            <div class="card card-span mb-3 shadow-lg">
              <div class="card-body py-0">
                <div class="row justify-content-center">
                  <div class="col-md-5 col-xl-7 col-xxl-8 g-0 order-0 order-md-1"><img class="img-fluid w-100 fit-cover h-100 rounded-top rounded-md-end rounded-md-top-0" src="{{ asset('assets/img/gallery/pizza.png') }}" alt="..." /></div>
                  <div class="col-md-7 col-xl-5 col-xxl-4 p-4 p-lg-5">
                    <h1 class="card-title mt-xl-5 mb-4">Bạn muốn ăn <span class="text-primary">pizza nóng & cay không ?</span></h1>
                    <p class="fs-1">Hãy cùng bạn bè thưởng thức những miếng pizza nóng hổi và giòn tan. Đừng bỏ lỡ các ưu đãi hấp dẫn nhất.</p>
                    <div class="d-grid bottom-0"><a class="btn btn-lg btn-primary mt-xl-6" href="#!">TIẾN HÀNH ĐẶT MÓN<i class="fas fa-chevron-right ms-2"></i></a></div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div><!-- end of .container-->

    </section>
    <!-- <section> close ============================-->
    <!-- ============================================-->




    {{-- PHẦN FOOTER --}}
    <!-- ============================================-->
    <!-- <section> begin ============================-->
    <section class="py-0 pt-7 bg-1000">

      <div class="container">
        <hr class="text-900" />
        <div class="row">
          <div class="col-6 col-md-4 col-lg-3 col-xxl-2 mb-3">
            <h5 class="lh-lg fw-bold text-white">Công Ty</h5>
            <ul class="list-unstyled mb-md-4 mb-lg-0">
              <li class="lh-lg"><a class="text-200 text-decoration-none" href="#!">Về chúng tôi</a></li>
              <li class="lh-lg"><a class="text-200 text-decoration-none" href="#!">Đội ngũ</a></li>
              <li class="lh-lg"><a class="text-200 text-decoration-none" href="#!">Tuyển dụng</a></li>
              <li class="lh-lg"><a class="text-200 text-decoration-none" href="#!">blog</a></li>
            </ul>
          </div>
          <div class="col-6 col-md-4 col-lg-3 col-xxl-2 col-lg-3 mb-3">
            <h5 class="lh-lg fw-bold text-white">CONTACT</h5>
            <ul class="list-unstyled mb-md-4 mb-lg-0">
              <li class="lh-lg"><a class="text-200 text-decoration-none" href="#!">Trợ giúp &amp; Hỗ trợ</a></li>
              <li class="lh-lg"><a class="text-200 text-decoration-none" href="#!">Hợp tác với chúng tôi </a></li>
              <li class="lh-lg"><a class="text-200 text-decoration-none" href="#!">Trở thành đối tác giao hàng</a></li>
              <li class="lh-lg"><a class="text-200 text-decoration-none" href="#!">Pháp lí</a></li>
            </ul>
          </div>
          <div class="col-6 col-md-4 col-lg-3 col-xxl-2 mb-3">
            <h5 class="lh-lg fw-bold text-white">PHÁP LÝ</h5>
            <ul class="list-unstyled mb-md-4 mb-lg-0">
              <li class="lh-lg"><a class="text-200 text-decoration-none" href="#!">Điều khoản &amp; Điều kiện</a></li>
              <li class="lh-lg"><a class="text-200 text-decoration-none" href="#!">Hoàn tiền &amp; Hủy đơn</a></li>
              <li class="lh-lg"><a class="text-200 text-decoration-none" href="#!">Chính sách bảo mật</a></li>
              <li class="lh-lg"><a class="text-200 text-decoration-none" href="#!">Chính sách Cookie</a></li>
            </ul>
          </div>
          <h3 class="text-500 my-4">Nhận ưu đãi <br />và giảm giá độc quyền qua email</h3>
          <div class="row input-group-icon mb-5">
            <div class="col-auto"><i class="fas fa-envelope input-box-icon text-500 ms-3"></i>
              <input class="form-control input-box bg-800 border-0" type="email" placeholder="Enter Email" aria-label="email" />
            </div>
            <div class="col-auto">
              <button class="btn btn-primary" type="submit">Đăng kí</button>
            </div>
          </div>
        </div>
      </div>
      <hr class="border border-800" />
      <div class="row flex-center pb-3">
        <div class="col-md-6 order-0">
          <p class="text-200 text-center text-md-start" style='margin-left: 35%;'>QUẢN LÍ DỰ ÁN VỚI AGILE - ĐÒ ĂN NHANH</p>
        </div>
      </div>
  </div><!-- end of .container-->

  </section>
  <!-- <section> close ============================-->
  <!-- ============================================-->
  <script>
    function filterMenu(category) {
      var cards = document.querySelectorAll('.menu-card-item');
      cards.forEach(function(card) {
        var cardCategory = card.getAttribute('data-category');
        if (category === 'all' || cardCategory === category) {
          card.classList.remove('hidden');
          card.classList.add('visible');
        } else {
          card.classList.remove('visible');
          card.classList.add('hidden');
        }
      });
    }
  </script>
</main>
@endsection