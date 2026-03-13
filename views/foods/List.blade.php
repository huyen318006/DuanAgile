@extends('layouts.AdminLayout')

@section('content')
<main class="main" id="top">
      
      <section class="py-5 overflow-hidden bg-primary" id="home">
        <div class="container">
          <div class="row flex-center">
            <div class="col-md-5 col-lg-6 order-0 order-md-1 mt-8 mt-md-0"><a class="img-landing-banner" href="#!"><img class="img-fluid" src="{{ asset('assets/img/gallery/hero-header.png') }}" alt="hero-header" /></a></div>
            <div class="col-md-7 col-lg-6 py-8 text-md-start text-center">
              <h1 class="display-1 fs-md-5 fs-lg-6 fs-xl-8 text-light">Bạn Đang Đói?</h1>
              <h1 class="text-800 mb-5 fs-4">Chỉ với vài cú nhấp chuột, tìm ngay những món ăn<br class="d-none d-xxl-block" /> ở gần bạn</h1>
              <div class="card w-xxl-75">
                <div class="card-body">
                  <nav>
                    <div class="nav nav-tabs" id="nav-tab" role="tablist">
                      <button class="nav-link active mb-3" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-home" type="button" role="tab" aria-controls="nav-home" aria-selected="true"><i class="fas fa-motorcycle me-2"></i>Giao Hàng</button>
                      <button class="nav-link mb-3" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-profile" type="button" role="tab" aria-controls="nav-profile" aria-selected="false"><i class="fas fa-shopping-bag me-2"></i>Đến Lấy</button>
                    </div>
                  </nav>
                  <div class="tab-content mt-3" id="nav-tabContent">
                    <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                      <form class="row gx-2 gy-2 align-items-center">
                        <div class="col">
                          <div class="input-group-icon"><i class="fas fa-map-marker-alt text-danger input-box-icon"></i>
                            <label class="visually-hidden" for="inputDelivery">Địa Chỉ</label>
                            <input class="form-control input-box form-foodwagon-control" id="inputDelivery" type="text" placeholder="Nhập địa chỉ của bạn" />
                          </div>
                        </div>
                        <div class="d-grid gap-3 col-sm-auto">
                          <button class="btn btn-danger" type="submit">Tìm món ăn</button>
                        </div>
                      </form>
                    </div>
                    <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                      <form class="row gx-4 gy-2 align-items-center">
                        <div class="col">
                          <div class="input-group-icon"><i class="fas fa-map-marker-alt text-danger input-box-icon"></i>
                            <label class="visually-hidden" for="inputPickup">Địa Chỉ</label>
                            <input class="form-control input-box form-foodwagon-control" id="inputPickup" type="text" placeholder="Nhập địa chỉ của bạn" />
                          </div>
                        </div>
                        <div class="d-grid gap-3 col-sm-auto">
                          <button class="btn btn-danger" type="submit">Tìm món ăn</button>
                        </div>
                      </form>
                    </div>
                  </div>
                </div>
              </div>
            </div>
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
                    @foreach(array_chunk($foods,4) as $index => $chunk)
                    <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                    <div class="row gx-3 h-100 align-items-center">
                    @foreach($chunk as $food)
                            <div class="col-sm-6 col-md-4 col-xl-3 mb-5 h-100">
                                <div class="card card-span h-100 rounded-3">
                                    <img class="img-fluid rounded-3"src="{{ asset('assets/img/gallery/'.$food->image) }}"alt="{{ $food->name }}"style="width:100%; height:220px; object-fit:cover;">
                                    <div class="card-body ps-0">
                                    <h5 class="fw-bold text-1000 text-truncate mb-1">{{ $food->name }}</h5><div>
                                    <span class="text-warning me-2"><i class="fas fa-map-marker-alt"></i></span>
                                    <span class="text-primary">Món ăn phổ biến</span>
                                    </div>
                                    <span class="text-1000 fw-bold">{{ number_format($food->price) }}đ</span>
                                    </div>
                                    </div>
                                    <div class="d-grid gap-2">
                                    <a class="btn btn-lg btn-danger" href="#">Đặt ngay</a>
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
          <span class="text-warning">@for($i=1;$i<=5;$i++)<i class="fas fa-star"></i>@endfor</span>
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
          <a class="btn btn-lg btn-primary" href="#"style="transition:0.3s;"onmouseover="this.style.transform='scale(1.08)';this.style.boxShadow='0 8px 20px rgba(0,0,0,0.2)';"onmouseout="this.style.transform='scale(1)';this.style.boxShadow='none';">View All<i class="fas fa-chevron-right ms-2"></i></a>
          </div>

          </div>
      </section>


      <!-- ============================================-->
      <!-- <section> begin ============================-->
      <section class="py-8 overflow-hidden">

        <div class="container">
          <div class="row flex-center mb-6">
            <div class="col-lg-7">
              <h5 class="fw-bold fs-3 fs-lg-5 lh-sm text-center text-lg-start">Tìm kiếm theo món ăn</h5>
            </div>
            <div class="col-lg-4 text-lg-end text-center"><a class="btn btn-lg text-800 me-2" href="#" role="button">XEM TẤT CẢ <i class="fas fa-chevron-right ms-2"></i></a></div>
            <div class="col-lg-auto position-relative">
              <button class="carousel-control-prev s-icon-prev carousel-icon" type="button" data-bs-target="#carouselSearchByFood" data-bs-slide="prev"><span class="carousel-control-prev-icon hover-top-shadow" aria-hidden="true"></span><span class="visually-hidden">Previous</span></button>
              <button class="carousel-control-next s-icon-next carousel-icon" type="button" data-bs-target="#carouselSearchByFood" data-bs-slide="next"><span class="carousel-control-next-icon hover-top-shadow" aria-hidden="true"></span><span class="visually-hidden">Next</span></button>
            </div>
          </div>
          <div class="row flex-center">
            <div class="col-12">
              <div class="carousel slide" id="carouselSearchByFood" data-bs-touch="false" data-bs-interval="false">
                <div class="carousel-inner">
                  <div class="carousel-item active" data-bs-interval="10000">
                    <div class="row h-100 align-items-center">
                      <div class="col-sm-6 col-md-4 col-xl mb-5 h-100">
                        <div class="card card-span h-100 rounded-circle"><img class="img-fluid rounded-circle h-100" src="{{ asset('assets/img/gallery/search-pizza.png') }} " alt="..." />
                          <div class="card-body ps-0">
                            <h5 class="text-center fw-bold text-1000 text-truncate mb-2">pizza</h5>
                          </div>
                        </div>
                      </div>
                      <div class="col-sm-6 col-md-4 col-xl mb-5 h-100">
                        <div class="card card-span h-100 rounded-circle"><img class="img-fluid rounded-circle h-100" src="{{ asset('assets/img/gallery/burger.png') }}" alt="..." />
                          <div class="card-body ps-0">
                            <h5 class="text-center fw-bold text-1000 text-truncate mb-2">Burger</h5>
                          </div>
                        </div>
                      </div>
                      <div class="col-sm-6 col-md-4 col-xl mb-5 h-100">
                        <div class="card card-span h-100 rounded-circle"><img class="img-fluid rounded-circle h-100" src="{{ asset('assets/img/gallery/noodles.png') }}" alt="..." />
                          <div class="card-body ps-0">
                            <h5 class="text-center fw-bold text-1000 text-truncate mb-2">Noodles</h5>
                          </div>
                        </div>
                      </div>
                      <div class="col-sm-6 col-md-4 col-xl mb-5 h-100">
                        <div class="card card-span h-100 rounded-circle"><img class="img-fluid rounded-circle h-100" src="{{ asset('assets/img/gallery/sub-sandwich.png') }}" alt="..." />
                          <div class="card-body ps-0">
                            <h5 class="text-center fw-bold text-1000 text-truncate mb-2">Sub-sandwiches</h5>
                          </div>
                        </div>
                      </div>
                      <div class="col-sm-6 col-md-4 col-xl mb-5 h-100">
                        <div class="card card-span h-100 rounded-circle"><img class="img-fluid rounded-circle h-100" src="{{ asset('assets/img/gallery/chowmein.png') }}" alt="..." />
                          <div class="card-body ps-0">
                            <h5 class="text-center fw-bold text-1000 text-truncate mb-2">Chowmein</h5>
                          </div>
                        </div>
                      </div>
                      <div class="col-sm-6 col-md-4 col-xl mb-5 h-100">
                        <div class="card card-span h-100 rounded-circle"><img class="img-fluid rounded-circle h-100" src="{{ asset('assets/img/gallery/steak.png') }}" alt="..." />
                          <div class="card-body ps-0">
                            <h5 class="text-center fw-bold text-1000 text-truncate mb-2">Steak</h5>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="carousel-item" data-bs-interval="5000">
                    <div class="row h-100 align-items-center">
                      <div class="col-sm-6 col-md-4 col-xl mb-5 h-100">
                        <div class="card card-span h-100 rounded-circle"><img class="img-fluid rounded-circle h-100" src="{{ asset('assets/img/gallery/search-pizza.png') }}" alt="..." />
                          <div class="card-body ps-0">
                            <h5 class="text-center fw-bold text-1000 text-truncate mb-2">pizza</h5>
                          </div>
                        </div>
                      </div>
                      <div class="col-sm-6 col-md-4 col-xl mb-5 h-100">
                        <div class="card card-span h-100 rounded-circle"><img class="img-fluid rounded-circle h-100" src="{{ asset('assets/img/gallery/burger.png') }}" alt="..." />
                          <div class="card-body ps-0">
                            <h5 class="text-center fw-bold text-1000 text-truncate mb-2">Burger</h5>
                          </div>
                        </div>
                      </div>
                      <div class="col-sm-6 col-md-4 col-xl mb-5 h-100">
                        <div class="card card-span h-100 rounded-circle"><img class="img-fluid rounded-circle h-100" src="{{ asset('assets/img/gallery/noodles.png') }}" alt="..." />
                          <div class="card-body ps-0">
                            <h5 class="text-center fw-bold text-1000 text-truncate mb-2">Noodles</h5>
                          </div>
                        </div>
                      </div>
                      <div class="col-sm-6 col-md-4 col-xl mb-5 h-100">
                        <div class="card card-span h-100 rounded-circle"><img class="img-fluid rounded-circle h-100" src="{{ asset('assets/img/gallery/sub-sandwich.png') }}" alt="..." />
                          <div class="card-body ps-0">
                            <h5 class="text-center fw-bold text-1000 text-truncate mb-2">Sub-sandwiches</h5>
                          </div>
                        </div>
                      </div>
                      <div class="col-sm-6 col-md-4 col-xl mb-5 h-100">
                        <div class="card card-span h-100 rounded-circle"><img class="img-fluid rounded-circle h-100" src="{{ asset('assets/img/gallery/chowmein.png') }}" alt="..." />
                          <div class="card-body ps-0">
                            <h5 class="text-center fw-bold text-1000 text-truncate mb-2">Chowmein</h5>
                          </div>
                        </div>
                      </div>
                      <div class="col-sm-6 col-md-4 col-xl mb-5 h-100">
                        <div class="card card-span h-100 rounded-circle"><img class="img-fluid rounded-circle h-100" src="{{ asset('assets/img/gallery/steak.png') }}" alt="..." />
                          <div class="card-body ps-0">
                            <h5 class="text-center fw-bold text-1000 text-truncate mb-2">Steak</h5>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="carousel-item" data-bs-interval="3000">
                    <div class="row h-100 align-items-center">
                      <div class="col-sm-6 col-md-4 col-xl mb-5 h-100">
                        <div class="card card-span h-100 rounded-circle"><img class="img-fluid rounded-circle h-100" src="{{ asset('assets/img/gallery/search-pizza.png') }}" alt="..." />
                          <div class="card-body ps-0">
                            <h5 class="text-center fw-bold text-1000 text-truncate mb-2">pizza</h5>
                          </div>
                        </div>
                      </div>
                      <div class="col-sm-6 col-md-4 col-xl mb-5 h-100">
                        <div class="card card-span h-100 rounded-circle"><img class="img-fluid rounded-circle h-100" src="{{ asset('assets/img/gallery/burger.png') }}" alt="..." />
                          <div class="card-body ps-0">
                            <h5 class="text-center fw-bold text-1000 text-truncate mb-2">Burger</h5>
                          </div>
                        </div>
                      </div>
                      <div class="col-sm-6 col-md-4 col-xl mb-5 h-100">
                        <div class="card card-span h-100 rounded-circle"><img class="img-fluid rounded-circle h-100" src="{{ asset('assets/img/gallery/noodles.png') }}" alt="..." />
                          <div class="card-body ps-0">
                            <h5 class="text-center fw-bold text-1000 text-truncate mb-2">Noodles</h5>
                          </div>
                        </div>
                      </div>
                      <div class="col-sm-6 col-md-4 col-xl mb-5 h-100">
                        <div class="card card-span h-100 rounded-circle"><img class="img-fluid rounded-circle h-100" src="{{ asset('assets/img/gallery/sub-sandwich.png') }}" alt="..." />
                          <div class="card-body ps-0">
                            <h5 class="text-center fw-bold text-1000 text-truncate mb-2">Sub-sandwiches</h5>
                          </div>
                        </div>
                      </div>
                      <div class="col-sm-6 col-md-4 col-xl mb-5 h-100">
                        <div class="card card-span h-100 rounded-circle"><img class="img-fluid rounded-circle h-100" src="{{ asset('assets/img/gallery/chowmein.png') }}" alt="..." />
                          <div class="card-body ps-0">
                            <h5 class="text-center fw-bold text-1000 text-truncate mb-2">Chowmein</h5>
                          </div>
                        </div>
                      </div>
                      <div class="col-sm-6 col-md-4 col-xl mb-5 h-100">
                        <div class="card card-span h-100 rounded-circle"><img class="img-fluid rounded-circle h-100" src="{{ asset('assets/img/gallery/steak.png') }}" alt="..." />
                          <div class="card-body ps-0">
                            <h5 class="text-center fw-bold text-1000 text-truncate mb-2">Steak</h5>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="carousel-item">
                    <div class="row h-100 align-items-center">
                      <div class="col-sm-6 col-md-4 col-xl mb-5 h-100">
                        <div class="card card-span h-100 rounded-circle"><img class="img-fluid rounded-circle h-100" src="{{ asset('assets/img/gallery/search-pizza.png') }}" alt="..." />
                          <div class="card-body ps-0">
                            <h5 class="text-center fw-bold text-1000 text-truncate mb-2">pizza</h5>
                          </div>
                        </div>
                      </div>
                      <div class="col-sm-6 col-md-4 col-xl mb-5 h-100">
                        <div class="card card-span h-100 rounded-circle"><img class="img-fluid rounded-circle h-100" src="{{ asset('assets/img/gallery/burger.png') }}" alt="..." />
                          <div class="card-body ps-0">
                            <h5 class="text-center fw-bold text-1000 text-truncate mb-2">Burger</h5>
                          </div>
                        </div>
                      </div>
                      <div class="col-sm-6 col-md-4 col-xl mb-5 h-100">
                        <div class="card card-span h-100 rounded-circle"><img class="img-fluid rounded-circle h-100" src="{{ asset('assets/img/gallery/noodles.png') }}" alt="..." />
                          <div class="card-body ps-0">
                            <h5 class="text-center fw-bold text-1000 text-truncate mb-2">Noodles</h5>
                          </div>
                        </div>
                      </div>
                      <div class="col-sm-6 col-md-4 col-xl mb-5 h-100">
                        <div class="card card-span h-100 rounded-circle"><img class="img-fluid rounded-circle h-100" src="{{ asset('assets/img/gallery/sub-sandwich.png') }}" alt="..." />
                          <div class="card-body ps-0">
                            <h5 class="text-center fw-bold text-1000 text-truncate mb-2">Sub-sandwiches</h5>
                          </div>
                        </div>
                      </div>
                      <div class="col-sm-6 col-md-4 col-xl mb-5 h-100">
                        <div class="card card-span h-100 rounded-circle"><img class="img-fluid rounded-circle h-100" src="{{ asset('assets/img/gallery/chowmein.png') }}" alt="..." />
                          <div class="card-body ps-0">
                            <h5 class="text-center fw-bold text-1000 text-truncate mb-2">Chowmein</h5>
                          </div>
                        </div>
                      </div>
                      <div class="col-sm-6 col-md-4 col-xl mb-5 h-100">
                        <div class="card card-span h-100 rounded-circle"><img class="img-fluid rounded-circle h-100" src="{{ asset('assets/img/gallery/steak.png') }}" alt="..." />
                          <div class="card-body ps-0">
                            <h5 class="text-center fw-bold text-1000 text-truncate mb-2">Steak</h5>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div><!-- end of .container-->

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


      <section class="py-0">
        <div class="bg-holder" style="background-image:url({{ asset('assets/img/gallery/cta-two-bg.png') }});background-position:center;background-size:cover;">
        </div>
        <!--/.bg-holder-->

        <div class="container">
          <div class="row flex-center">
            <div class="col-xxl-9 py-7 text-center">
              <h1 class="fw-bold mb-4 text-white fs-6"> Bạn đã sẵn sàng đặt món  <br />với những ưu đãi tốt nhất chưa?</h1><a class="btn btn-danger" href="#"> ĐẶT MÓN NGAY<i class="fas fa-chevron-right ms-2"></i></a>
            </div>
          </div>
        </div>
      </section>

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
                <li class="lh-lg"><a class="text-200 text-decoration-none" href="#!">Hoàn tiền  &amp; Hủy đơn</a></li>
                <li class="lh-lg"><a class="text-200 text-decoration-none" href="#!">Chính sách bảo mật</a></li>
                <li class="lh-lg"><a class="text-200 text-decoration-none" href="#!">Chính sách Cookie</a></li>
              </ul>
            </div>
              <h3 class="text-500 my-4">Nhận ưu đãi  <br />và giảm giá độc quyền qua email</h3>
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
      </main>
@endsection