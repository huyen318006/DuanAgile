@extends('layouts.AdminLayout')

@section('content')
<main class="main" id="top">

  <section class="py-5 overflow-hidden bg-primary" id="home">
    <div class="bg-holder" style="background-image:url({{ asset('assets/img/gallery/cta-two-bg.png') }});background-position:center;background-size:cover;">
    </div>
    <div class="container">
      <div class="row flex-center">
        <div class="col-xxl-9 py-7 text-center">
          <h1 class="fw-bold mb-4 text-white fs-6"> Bạn đã sẵn sàng đặt món <br />với những ưu đãi tốt nhất chưa?</h1><a class="btn btn-danger" href="#"> ĐẶT MÓN NGAY<i class="fas fa-chevron-right ms-2"></i></a>
        </div>
      </div>
    </div>
  </section>
  <section class="py-4 overflow-hidden">
    <div class="container">
      <div class="text-center">
        <h1 class="display-5 mb-5">Most Popular Food in the World</h1>
      </div>
      <div class="tab-class text-center">
        <!-- Search Box -->
        <div class="d-flex justify-content-center mb-4">
          <div class="position-relative" style="width: 400px;">
            <i class="fas fa-search position-absolute" style="left: 15px; top: 50%; transform: translateY(-50%); color: #aaa;"></i>
            <input type="text" id="menuSearchInput" class="form-control menu-search-input" placeholder="Tìm kiếm món ăn..." style="padding-left: 42px;">
          </div>
        </div>

        <ul class="nav nav-pills d-inline-flex justify-content-center mb-5" id="menuCategoryFilter">
          <li class="nav-item p-2">
            <a class="filter-pill d-flex py-2 mx-2 border border-primary rounded-pill active" href="javascript:void(0)" data-category-id="all">
              <span style="width: 150px;">Tất cả</span>
            </a>
          </li>
          @foreach ($categories as $category)
          <li class="nav-item p-2">
            <a class="filter-pill d-flex py-2 mx-2 border border-primary rounded-pill" href="javascript:void(0)" data-category-id="{{ $category->id }}">
              <span style="width: 150px;">{{ $category->name }}</span>
            </a>
          </li>
          @endforeach
        </ul>
        <div class="tab-content">

          <div class="tab-pane fade show p-0 active">
            <div class="row g-4" id="menuFoodList">
              @foreach($foods as $food)
              <div class="col-lg-6 menu-food-item" data-category="{{ $food->category_id }}" data-name="{{ mb_strtolower($food->name) }}">
                <div class="menu-item d-flex align-items-center"
                     role="button"
                     data-bs-toggle="modal"
                     data-bs-target="#foodModal"
                     data-food-id="{{ $food->id }}"
                     data-food-name="{{ $food->name }}"
                     data-food-price="{{ $food->price }}"
                     data-food-image="{{ asset('assets/img/gallery/'.$food->image) }}"
                     data-food-description="{{ $food->description }}">
                  <img class="rounded-circle" width="100" src="{{ asset('assets/img/gallery/'.$food->image) }}" alt="{{ $food->name }}">
                  <div class="w-100 d-flex flex-column text-start ps-4">
                    <div class="d-flex justify-content-between border-bottom border-primary pb-2 mb-2">
                      <h4>{{ $food->name }}</h4>
                      <h4 class="text-primary">{{ number_format($food->price, 0, ',', '.') }}đ</h4>
                    </div>
                    <p class="mb-0">{{ $food->description }}</p>
                  </div>
                </div>
              </div>
              @endforeach
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

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

  @include('menus.Detail')

</main>

@section('scripts')
<script>
  document.addEventListener('DOMContentLoaded', function() {
    const filterPills = document.querySelectorAll('#menuCategoryFilter .filter-pill');
    const foodItems = document.querySelectorAll('#menuFoodList .menu-food-item');
    const searchInput = document.getElementById('menuSearchInput');

    function filterItems() {
      const activePill = document.querySelector('#menuCategoryFilter .filter-pill.active');
      const categoryId = activePill ? activePill.getAttribute('data-category-id') : 'all';
      const keyword = searchInput.value.trim().toLowerCase();

      foodItems.forEach(function(item) {
        const matchCategory = (categoryId === 'all' || item.getAttribute('data-category') === categoryId);
        const matchSearch = (keyword === '' || item.getAttribute('data-name').includes(keyword));

        if (matchCategory && matchSearch) {
          item.classList.remove('hidden');
          item.classList.add('visible');
        } else {
          item.classList.remove('visible');
          item.classList.add('hidden');
        }
      });
    }

    filterPills.forEach(function(pill) {
      pill.addEventListener('click', function() {
        filterPills.forEach(function(p) { p.classList.remove('active'); });
        this.classList.add('active');
        filterItems();
      });
    });

    searchInput.addEventListener('input', filterItems);
  });
</script>
@endsection
@endsection