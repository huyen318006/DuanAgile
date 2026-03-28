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
            <h3 class="text-500 my-4">Hãy nhập email của bạn <br />để nhận ưu đãi và giảm giá độc quyền cho khác hàng mới</h3>
           <form action="{{ route('vocher/store') }}" method="POST">
             <div class="row input-group-icon mb-5">
              <div class="col-auto"><i class="fas fa-envelope input-box-icon text-500 ms-3"></i>
                <input class="form-control input-box bg-800 border-0" type="email" placeholder="Nhập Email của bạn" aria-label="email" name="email" required />
              </div>
              <div class="col-auto">
                <button class="btn btn-primary" type="submit">Đăng kí</button>
              </div>
            </div>
           </form>
          </div>
        </div>
        <hr class="border border-800" />
        <div class="row flex-center pb-3">
          <div class="col-md-6 order-0">
            <p class="text-200 text-center text-md-start" style='margin-left: 35%;'>QUẢN LÍ DỰ ÁN VỚI AGILE - ĐỒ ĂN NHANH</p>
          </div>
        </div>
        </div><!-- end of .container-->
    
      </section>
      <!-- <section> close ============================-->
      <!-- ============================================-->